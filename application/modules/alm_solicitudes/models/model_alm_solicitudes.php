<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Model_alm_solicitudes extends CI_Model
{
	//constructor predeterminado del modelo
	function __construct()
	{
		parent::__construct();
	}

	public function get_last_id()//retorna un entero resultante del ultimo registro del campo ID de la tabla alm_solicitud
	{
		$this->db->select_max('ID');
		$query = $this->db->get('alm_solicitud');
		$row = $query->row();
		return($row->ID); // actualmetne es utilizado para generar el numero de Solicitud
	}

	public function insert_solicitud($array)
	{
		if(!empty($array))
		{
			$alm_solicitud = array(
				'id_usuario'=>$array['id_usuario'],
				'nr_solicitud'=>$array['nr_solicitud'],
				'status'=>$array['status'],
				'observacion'=>$array['observacion'],
				'fecha_gen'=>$array['fecha_gen']);
			$this->db->insert('alm_solicitud', $alm_solicitud);
			$alm_genera = array(
				'id_usuario'=>$array['id_usuario'],
				'nr_solicitud'=>$array['nr_solicitud']);
			$this->db->insert('alm_genera', $alm_genera);

			$alm_historial_s = array(
				'NRS'=>$array['nr_solicitud'],
				'fecha_gen'=>$array['fecha_gen'],
				'usuario_gen'=>$array['id_usuario'] );
			$this->db->insert('alm_historial_s', $alm_historial_s);

			$alm_contiene = $array['contiene'];
			$this->db->insert_batch('alm_contiene', $alm_contiene);
			return($this->db->insert_id());
		}
		return FALSE;
	}
	public function remove_art($sol_art)//FUNCIONA
	{
		// die_pre($sol_art, __LINE__, __FILE__);
		$this->db->where($sol_art);
		$this->db->delete('alm_contiene');
	}
	public function add_art($sol_art)//FUNCIONA recibe un array('id_articulo','NRS','nr_solicitud','cant_solicitada');
	{
		// die_pre($sol_art, __LINE__, __FILE__);
		$this->db->insert('alm_contiene', $sol_art);
		return($this->db->insert_id());
	}
	public function get_allSolicitud()//Retorna TODAS LAS SOLICITUDES
	{
		$this->db->select('alm_genera.id_usuario, nombre, apellido, email, telefono, alm_solicitud.status, sys_rol, fecha_gen, alm_solicitud.nr_solicitud, alm_solicitud.observacion, fecha_comp');
		$this->db->order_by('fecha_gen', 'desc');
		$this->db->from('dec_usuario');
		$this->db->join('alm_genera', 'alm_genera.id_usuario = dec_usuario.id_usuario');
		$this->db->join('alm_solicitud', 'alm_solicitud.nr_solicitud = alm_genera.nr_solicitud');
		return(objectSQL_to_array($this->db->get()->result()));
	}

	public function get_liveSolicitud()//Retorna Todas las Solicitudes menos las que han sido completadas (para fines de aprobacion y corroborar estado)
	{
		$this->db->where_not_in('status', 'completado');
		$aux = $this->db->get('alm_solicitud')->result();
		$aux = objectSQL_to_array($aux);
		return($aux);
	}

////CONSULTAS DE ADMINISTRADOR DE SOLICITUDES (todo menos las solicitudes que no han sido enviadas, es decir alm_solicitud.status = 'carrito')
	
	public function count_adminStaSolicitud($status, $desde='', $hasta='')
	{
		$this->db->where($status);
		
		if(!empty($desde) && !empty($hasta))
		{
			$this->db->where('fecha_gen >=', $desde);
			$this->db->where('fecha_gen <=', $hasta);
		}
		
		$this->db->from('alm_solicitud');
		$aux = $this->db->count_all_results();
		// die_pre($aux);
		return($aux);
	}
	public function get_adminStaSolicitud($status='', $field='', $order='', $per_page='', $offset='', $desde='', $hasta='')
	{
		if(!empty($status))
		{
			if(!empty($field))
			{
				$this->db->order_by($field, $order);
			}
			$this->db->select('alm_genera.id_usuario, nombre, apellido, email, telefono, alm_solicitud.status, sys_rol, fecha_gen, alm_solicitud.nr_solicitud, alm_solicitud.observacion, fecha_comp');
			$this->db->where($status);
			$this->db->where_not_in('alm_solicitud.status', 'carrito');
		
		if(!empty($desde) && !empty($hasta))
		{
			$this->db->where('fecha_gen >=', $desde);
			$this->db->where('fecha_gen <=', $hasta);
		}
		
			$this->db->order_by('fecha_gen', 'desc');
			$this->db->from('dec_usuario');
			$this->db->join('alm_genera', 'alm_genera.id_usuario = dec_usuario.id_usuario');
			$this->db->join('alm_solicitud', 'alm_solicitud.nr_solicitud = alm_genera.nr_solicitud');
			$this->db->limit($per_page, $offset);
			$array=$this->db->get()->result();
			$array = objectSQL_to_array($array);
			// die_pre($aux);
			return($array);
		}
	}
	public function count_adminDepSolicitud($id, $desde='', $hasta='')
	{
		$id_dependencia['id_dependencia']=$id;
		$this->db->select('alm_genera.id_usuario, nombre, apellido, email, telefono, alm_solicitud.status, sys_rol, fecha_gen, alm_solicitud.nr_solicitud, alm_solicitud.observacion, fecha_comp');
		$this->db->where($id_dependencia);
		$this->db->where_not_in('alm_solicitud.status', 'carrito');
		
		if(!empty($desde) && !empty($hasta))
		{
			$this->db->where('fecha_gen >=', $desde);
			$this->db->where('fecha_gen <=', $hasta);
		}
		
		$this->db->order_by('fecha_gen', 'desc');
		$this->db->from('dec_usuario');
		$this->db->join('alm_genera', 'alm_genera.id_usuario = dec_usuario.id_usuario');
		$this->db->join('alm_solicitud', 'alm_solicitud.nr_solicitud = alm_genera.nr_solicitud');
		$aux = $this->db->count_all_results();
		// die_pre($aux);
		return($aux);
	}
	public function get_adminDepSolicitud($id='', $field='', $order='', $per_page='', $offset='', $desde='', $hasta='')
	{
		if(!empty($id))
		{
			if(!empty($field))
			{
				$this->db->order_by($field, $order);
			}
			$id_dependencia['id_dependencia']=$id;
			$this->db->select('alm_genera.id_usuario, nombre, apellido, email, telefono, alm_solicitud.status, sys_rol, fecha_gen, alm_solicitud.nr_solicitud, alm_solicitud.observacion, fecha_comp');
			$this->db->where($id_dependencia);
			$this->db->where_not_in('alm_solicitud.status', 'carrito');
		
		if(!empty($desde) && !empty($hasta))
		{
			$this->db->where('fecha_gen >=', $desde);
			$this->db->where('fecha_gen <=', $hasta);
		}
		
			$this->db->order_by('fecha_gen', 'desc');
			$this->db->from('dec_usuario');
			$this->db->join('alm_genera', 'alm_genera.id_usuario = dec_usuario.id_usuario');
			$this->db->join('alm_solicitud', 'alm_solicitud.nr_solicitud = alm_genera.nr_solicitud');
			$this->db->limit($per_page, $offset);
			$array=$this->db->get()->result();
			$array = objectSQL_to_array($array);
			// die_pre($array);
			return($array);
		}
		return FALSE;
	}
	public function count_adminUser($id_usuario='', $desde='', $hasta='')///Listo
	{
		if(!empty($id_usuario))
		{
				
			$find['alm_genera.id_usuario']=$id_usuario;
			$this->db->select('alm_genera.id_usuario, nombre, apellido, email, telefono, alm_solicitud.status, sys_rol, fecha_gen, alm_solicitud.nr_solicitud, alm_solicitud.observacion, fecha_comp');
			$this->db->where($find);
			$this->db->where_not_in('alm_solicitud.status', 'carrito');
		
		if(!empty($desde) && !empty($hasta))
		{
			$this->db->where('fecha_gen >=', $desde);
			$this->db->where('fecha_gen <=', $hasta);
		}
		
			$this->db->from('dec_usuario');
			$this->db->join('alm_genera', 'alm_genera.id_usuario = dec_usuario.id_usuario');
			$this->db->join('alm_solicitud', 'alm_solicitud.nr_solicitud = alm_genera.nr_solicitud');
			$array=$this->db->count_all_results();
			// $array = objectSQL_to_array($array);
			return($array);
		}
		return FALSE;

	}
	public function get_adminUser($id_usuario='', $field='', $order='', $per_page='', $offset='', $desde='', $hasta='')
	{
		if(!empty($id_usuario))
		{
			if(!empty($field))
			{
				$this->db->order_by($field, $order);
			}
				
			$find['alm_genera.id_usuario']=$id_usuario;
			$this->db->select('alm_genera.id_usuario, nombre, apellido, email, telefono, alm_solicitud.status, sys_rol, fecha_gen, alm_solicitud.nr_solicitud, alm_solicitud.observacion, fecha_comp');
			$this->db->where($find);
			$this->db->where_not_in('alm_solicitud.status', 'carrito');
		
		if(!empty($desde) && !empty($hasta))
		{
			$this->db->where('fecha_gen >=', $desde);
			$this->db->where('fecha_gen <=', $hasta);
		}
		
			$this->db->from('dec_usuario');
			$this->db->join('alm_genera', 'alm_genera.id_usuario = dec_usuario.id_usuario');
			$this->db->join('alm_solicitud', 'alm_solicitud.nr_solicitud = alm_genera.nr_solicitud');
			$this->db->limit($per_page, $offset);
			$array=$this->db->get()->result();
			$array = objectSQL_to_array($array);
			return($array);
		}
		return FALSE;

	}
	public function filtrar_solicitudes($field='', $order='', $per_page='', $offset='')//sin funcionar
	{
		$this->db->select('alm_genera.id_usuario, nombre, apellido, email, telefono, alm_solicitud.status, sys_rol, fecha_gen, alm_solicitud.nr_solicitud, alm_solicitud.observacion, fecha_comp');
		$this->db->order_by('fecha_gen', 'desc');
		$this->db->where_not_in('alm_solicitud.status', 'carrito');
		
		if(!empty($desde) && !empty($hasta))
		{
			$this->db->where('fecha_gen >=', $desde);
			$this->db->where('fecha_gen <=', $hasta);
		}
		
		$this->db->from('dec_usuario');
		$this->db->join('alm_genera', 'alm_genera.id_usuario = dec_usuario.id_usuario');
		$this->db->join('alm_solicitud', 'alm_solicitud.nr_solicitud = alm_genera.nr_solicitud');
		return(objectSQL_to_array($this->db->get()->result()));
		
	}
	public function get_activeSolicitudes($field='', $order='', $per_page='', $offset='', $desde='', $hasta='')
	{
		if(!empty($field))
		{
			$this->db->order_by($field, $order);
		}
		$this->db->select('alm_genera.id_usuario, nombre, apellido, email, telefono, alm_solicitud.status, sys_rol, fecha_gen, alm_solicitud.nr_solicitud, alm_solicitud.observacion, fecha_comp');
		$this->db->where_not_in('alm_solicitud.status', 'carrito');
		
		if(!empty($desde) && !empty($hasta))
		{
			$this->db->where('fecha_gen >=', $desde);
			$this->db->where('fecha_gen <=', $hasta);
		}

		$this->db->join('alm_genera', 'alm_genera.id_usuario = dec_usuario.id_usuario');
		$this->db->join('alm_solicitud', 'alm_solicitud.nr_solicitud = alm_genera.nr_solicitud');
		$query = $this->db->get('dec_usuario', $per_page, $offset);
		return objectSQL_to_array($query->result());
	}
	public function get_adminCount($desde='', $hasta='')
	{
		$this->db->select('alm_genera.id_usuario, nombre, apellido, email, telefono, alm_solicitud.status, sys_rol, fecha_gen, alm_solicitud.nr_solicitud, alm_solicitud.observacion, fecha_comp');
		$this->db->where_not_in('alm_solicitud.status', 'carrito');
		
		if(!empty($desde) && !empty($hasta))
		{
			$this->db->where('fecha_gen >=', $desde);
			$this->db->where('fecha_gen <=', $hasta);
		}

		$this->db->from('dec_usuario');
		$this->db->join('alm_genera', 'alm_genera.id_usuario = dec_usuario.id_usuario');
		$this->db->join('alm_solicitud', 'alm_solicitud.nr_solicitud = alm_genera.nr_solicitud');
		// $query = $this->db->get();
		return ($this->db->count_all_results());

	}
	public function get_adminFecha($desde, $hasta)
	{
		echo_pre($desde);
		die_pre($hasta);
		$this->db->select('alm_genera.id_usuario, nombre, apellido, email, telefono, alm_solicitud.status, sys_rol, fecha_gen, alm_solicitud.nr_solicitud, alm_solicitud.observacion, fecha_comp');
		$this->db->order_by('fecha_gen', 'desc');
		$this->db->where_not_in('alm_solicitud.status', 'carrito');
		if(!empty($desde) && !empty($hasta))
		{
			$this->db->where('fecha_gen >=', $desde);
			$this->db->where('fecha_gen <=', $hasta);
		}
		// $this->db->where('alm_solicitud.fecha_comp > NOW() - INTERVAL 15 MINUTE');
		// $this->db->where('alm_solicitud.fecha_comp > NOW() - INTERVAL 15 MINUTE');
		$this->db->from('dec_usuario');
		$this->db->join('alm_genera', 'alm_genera.id_usuario = dec_usuario.id_usuario');
		$this->db->join('alm_solicitud', 'alm_solicitud.nr_solicitud = alm_genera.nr_solicitud');
		return(objectSQL_to_array($this->db->get()->result()));
		
	}
//// FIN DE CONSULTAS DE ADMINISTRADOR DE SOLICITUDES
	public function get_departamentoSolicitud($id)//dado el numero de id del departamento, se trae todas las solicitudes con sus respectivos usuarios
	{
		$id_dependencia['id_dependencia']=$id;
		$this->db->select('alm_genera.id_usuario, nombre, apellido, email, telefono, alm_solicitud.status, sys_rol, fecha_gen, alm_solicitud.nr_solicitud, alm_solicitud.observacion, fecha_comp');
		$this->db->where($id_dependencia);
		$this->db->where('alm_solicitud.status !=', 'completado');
		$this->db->order_by('fecha_gen', 'desc');
		$this->db->from('dec_usuario');
		$this->db->join('alm_genera', 'alm_genera.id_usuario = dec_usuario.id_usuario');
		$this->db->join('alm_solicitud', 'alm_solicitud.nr_solicitud = alm_genera.nr_solicitud');
		$aux = $this->db->get()->result();
		$aux = objectSQL_to_array($aux);
		// die_pre($aux);
		return($aux);
	}
	public function get_depLastCompleted($id)//dado el id del departamento, retorna todas las ultimas solicitudes complatadas en los ultimos 15 minutos
	{
		$id_dependencia['id_dependencia']=$id;
		$this->db->select('alm_genera.id_usuario, nombre, apellido, email, telefono, alm_solicitud.status, sys_rol, fecha_gen, alm_solicitud.nr_solicitud, alm_solicitud.observacion, fecha_comp');
		$this->db->where($id_dependencia);
		$this->db->where('alm_solicitud.status', 'completado');
		$this->db->where('alm_solicitud.fecha_comp > NOW() - INTERVAL 15 MINUTE');
		$this->db->order_by('fecha_gen', 'desc');
		$this->db->from('dec_usuario');
		$this->db->join('alm_genera', 'alm_genera.id_usuario = dec_usuario.id_usuario');
		$this->db->join('alm_solicitud', 'alm_solicitud.nr_solicitud = alm_genera.nr_solicitud');
		$aux = $this->db->get()->result();
		$aux = objectSQL_to_array($aux);
		// die_pre($aux);
		return($aux);
	}

	public function get_userSolicitud($id_usuario)//dado un entero de id_usuario, devuelve las Solicitudes que haya generado
	{
		$find['alm_genera.id_usuario']=$id_usuario;
		$this->db->select('alm_genera.id_usuario, nombre, apellido, email, telefono, alm_solicitud.status, sys_rol, fecha_gen, alm_solicitud.nr_solicitud, alm_solicitud.observacion, fecha_comp');
		$this->db->where($find);
		$this->db->from('dec_usuario');
		$this->db->join('alm_genera', 'alm_genera.id_usuario = dec_usuario.id_usuario');
		$this->db->join('alm_solicitud', 'alm_solicitud.nr_solicitud = alm_genera.nr_solicitud');
		$array=$this->db->get()->result();
		$array = objectSQL_to_array($array);
		return($array);
	}

	public function change_statusEn_proceso($where)
	{
		$array = array(
			'status' => 'carrito');
		$array = array_merge($where, $array);
		$aux = array(
			'status' => 'en_proceso');
		$aux = array_merge($where, $aux);
		// die_pre($aux);

		$this->db->where($array);
		$update_id = $this->db->get('alm_solicitud')->row();
		if(!empty($update_id))
		{
			$this->db->where($array);
			$this->db->update('alm_solicitud', $aux);
			return(TRUE);
		}
		else
		{
			return(FALSE);
		}
	}

	public function change_statusCompletado($array)//incompleto
	{
		if(!empty($array['nr_solicitud']))
		{
			$this->load->helper('date');
			$datestring = "%Y-%m-%d %h:%i:%s";
			$time = time();
			$aux = array('status'=>'completado', 'fecha_comp'=>mdate($datestring, $time));
			$this->db->where($array);
			$this->db->update('alm_solicitud', $aux);
			return(TRUE);
		}
		else
		{
			return(FALSE);
		}
	}
	// public function change_statusC2D($array)
	// {
	// 	$aux = array(
	// 		'status' = 'en_proceso');
	// 	$this->db->where($array);
	// 	$this->db->update('alm_solicitud', $aux);
	// }
	public function get_solNumero($where)//de acuerdo al usuario, retorna el numero de solicitud (incompleto)
	{
		echo_pre($where);
		if(array_key_exists('id_usuario', $where))
		{
			$where['alm_genera.id_usuario']=$where['id_usuario'];
			unset($where['id_usuario']);
			$this->db->join('alm_genera', 'alm_genera.nr_solicitud = alm_solicitud.nr_solicitud');
			// $where = $this->db->get_where('alm_solicitud',$genera)->result()[0]->nr_solicitud;
			// $where = array('nr_solicitud'=>$where);
			// echo_pre(array_key_exists('id_usuario', $where));
			// die_pre($where);
		}
		$query = $this->db->get_where('alm_solicitud', $where);
		if($query->num_rows()==1)
		{
			return($query->result()[0]->nr_solicitud);
		}
		else
		{
			return(NULL);
		}

	}
	public function get_solStatus($nr_solicitud)//devuelve el estatus de una solicitud
	{
		if(!is_array($nr_solicitud))
		{
			$aux=$nr_solicitud;
			unset($nr_solicitud);
			$nr_solicitud['nr_solicitud'] = $aux;
		}
		if(!array_key_exists('nr_solicitud', $nr_solicitud))
		{
			$nr_solicitud['nr_solicitud'] = $nr_solicitud;
		}
		$this->db->select('status');
		$query = $this->db->get_where('alm_solicitud', $nr_solicitud);
		return($query->row()->status);
	}
	public function get_solArticulos($where)//articulos de una solicitud de status = carrito, de un usuario correspondiente
	{
		// echo("linea 212 - Model_alm_solicitudes");
		// echo_pre($where);
		if(!is_array($where))
		{
			$aux = $where;
			$where = array('nr_solicitud'=>$aux);
		}
		else
		{
			if(empty($where['nr_solicitud']))
			{
				$genera['alm_genera.id_usuario']=$where['id_usuario'];
				$genera['status']=$where['status'];
				$this->db->join('alm_genera', 'alm_genera.nr_solicitud = alm_solicitud.nr_solicitud');
				$where = $this->db->get_where('alm_solicitud',$genera)->result()[0]->nr_solicitud;
				$where = array('nr_solicitud'=>$where);
			}
			else
			{
				$aux = $where;
				$where = array('nr_solicitud'=>$aux['nr_solicitud']);
			}
		}
		$query = $this->db->get_where('alm_contiene', $where);
		$int=0;
		foreach ($query->result() as $key)
		{
			$array[$int]['id_articulo'] = $key->id_articulo;
			$array[$int]['descripcion'] = $this->db->get_where('alm_articulo', array('ID' => $key->id_articulo))->result()[0]->descripcion;
			$array[$int]['cant'] = $key->cant_solicitada;
			$array[$int]['cant_aprob'] = $key->cant_aprobada;
			$array[$int]['unidad'] = $this->db->get_where('alm_articulo', array('ID' => $key->id_articulo))->result()[0]->unidad;
			$array[$int]['reserv'] = $this->db->get_where('alm_articulo', array('ID' => $key->id_articulo))->result()[0]->reserv;
			$array[$int]['disp'] = $this->db->get_where('alm_articulo', array('ID' => $key->id_articulo))->result()[0]->disp;
			$int++;
		}
        return($array);
	}
	public function exist($where)//usado al iniciar session, y al generar una solicitud nueva (retorna si existe una solicitud con condiciones predeterminadas en un arreglo)
	{
		$genera['alm_genera.id_usuario']=$where['id_usuario'];
		$genera['status']=$where['status'];
		$this->db->join('alm_genera', 'alm_genera.nr_solicitud = alm_solicitud.nr_solicitud');
		$query = $this->db->get_where('alm_solicitud',$genera);
        return($query->num_rows() > 0);
	}

	public function allDataSolicitud($nr_solicitud)//dado el numero de una solicitud, retorna todos los datos de una solicitud(incluyendo quien la genera, y los articulos)
	{
		if(empty($nr_solicitud['nr_solicitud']))
		{
			$aux['alm_solicitud.nr_solicitud']= $nr_solicitud;
		}
		else
		{
			$aux['alm_solicitud.nr_solicitud']=$nr_solicitud['nr_solicitud'];
		}
		$this->db->select('alm_genera.id_usuario as cedula, alm_solicitud.nr_solicitud, alm_solicitud.status, alm_solicitud.observacion, alm_solicitud.fecha_gen, dependen as dependencia, nombre, apellido, email, telefono');
		$this->db->where($aux);
		$this->db->from('alm_solicitud');
		$this->db->join('alm_genera', 'alm_genera.nr_solicitud = alm_solicitud.nr_solicitud');
		$this->db->join('dec_usuario', 'dec_usuario.id_usuario = alm_genera.id_usuario');
		$this->db->join('dec_dependencia', 'dec_usuario.id_dependencia = dec_dependencia.id_dependencia');
		$aux = $this->db->get()->result();
		$array['solicitud'] = objectSQL_to_array($aux)[0];
		///trabajando por aqui
		$array['articulos'] = $this->get_solArticulos($array['solicitud']['nr_solicitud']);
		// die_pre($array);
		return($array);
	}

	public function date_forQuery($fecha)
	{
        $this->load->helper('date');
        $datestring = "%Y-%m-%d %h:%i:%s";
        $time = human_to_unix($desde);
        echo $time;
        $time = mdate($datestring, $time);
        return($fecha);
	}

	//AGREGADAS PARA LA GENERACION DEL PDF
	function getSolicitudes()
	{
		$query = $this->db->get('alm_solicitud');
		if($query->num_rows()>0)
		{
			foreach ($query->result() as $fila)
			{
				$data[] = $fila;
			}
				return $data;
		}
	}
	  function getSolicitudesSeleccionadas($solicitud)
	{
		
       
        $query = $this->db->query('SELECT l.nr_solicitud, l.id_usuario, l.observacion, l.status
                                  from alm_solicitud l 
                                  where l.nr_solicitud = 1111111 ');
        $data["solicitud_l"]=array();
	    if($query->num_rows()>0)
	    {
			foreach ($query->result() as $fila)
			{
				$data["solicitud_l"][$fila->nr_solicitud]["l.id_usuario"] = $fila->id_usuario;
				$data["solicitud_l"][$fila->nr_solicitud]["l.observacion"] = $fila->observacion;
				$data["solicitud_l"][$fila->nr_solicitud]["l.status"] = $fila->status;
			}
		}
		return $data["solicitud_l"];
	 }
	
}