<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Model_alm_solicitudes extends CI_Model
{
	//constructor predeterminado del modelo
	function __construct()
	{
		parent::__construct();
        $this->load->model('alm_articulos/model_alm_articulos');
	}
///////////////////////funciones de insercion en BD
	public function insert_solicitud($id_carrito)//inserta sobre la tabla alm_solicitud y luego retorna el nr_solicitud para las referencias a otras inserciones posteriores
	{
		//variable auxiliar para verificar las inserciones exitosas
		$insertID=1;
		///defino la fecha en la que se crea la solicitud en almacen
		$this->load->helper('date');
		$datestring = "%Y-%m-%d %H:%i:%s";
		$time = time();
		$fecha_gen = mdate($datestring, $time);

		///solicito el id de la ultima solicitud generada, para definir el nuevo numero de solicitud
		$last_solicitud=$this->get_last_id();
		$nr_solicitud = str_pad($last_solicitud+1, 9, '0', STR_PAD_LEFT);

		///extraigo los valores del carrito para insertarlo a la solicitud
		$carrito = $this->db->get_where('alm_carrito', array('id_carrito' => $id_carrito))->row_array();
		//extraigo los articulos contenidos en el carrito para insertarlos posteriormente en la nueva solicitud
		$articulos = $this->db->get_where('alm_car_contiene', array('id_carrito' => $id_carrito))->result_array();
		//extraigo al autor del carrito, para reflejarlo en la solicitud
		$autor = $this->db->get_where('alm_guarda', array('id_carrito' => $id_carrito))->row_array();
		// echo_pre($articulos, __LINE__, __FILE__);
		///construyo la solicitud a insertar en la tabla
		$solicitud['nr_solicitud']=$nr_solicitud;
		$solicitud['status']='carrito';
		$solicitud['observacion']=$carrito['observacion'];
		$solicitud['fecha_gen']=$fecha_gen;

		//inserto la solicitud y valido el exito de la insercion
		$this->db->insert('alm_solicitud', $solicitud);
		$insertID *=$this->db->insert_id();

		//construyo los datos de generacion y reflejo en historial, al autor que genero el carrito
		$efectua['TIME']=$autor['TIME'];
		$efectua['id_usuario']=$autor['id_usuario'];
		$efectua['nr_solicitud']=$nr_solicitud;
		//... y valido el exito de la insercion
		$this->db->insert('alm_efectua', $efectua);
		$insertID *= $this->db->insert_id();

		$historial['fecha_ej']=$autor['TIME'];
		$historial['usuario_ej']=$autor['id_usuario'];
		$historial['nr_solicitud']=$nr_solicitud;
		$historial['status_ej']='carrito';
		//... y valido el exito de la insercion
		$this->db->insert('alm_historial_s', $historial);
		$insertID *= $this->db->insert_id();

		//recorro e inserto los articulos del carrito en la solicitud
		foreach ($articulos as $key => $value)
		{
			unset($value['id_carrito']);
			unset($value['ID']);
			$value['nr_solicitud']= $nr_solicitud;
		//... y valido el exito de la insercion
			$this->db->insert('alm_art_en_solicitud', $value);
			$insertID *= $this->db->insert_id();
		}

		if($this->delete_carrito(array('id_carrito' => $id_carrito)))
		{
			return($insertID);
		}
		else
		{
			return(FALSE);
		}
	}

	// public function insert_solicitud($array)//proveniente del paso 2, ahora sera del momento de enviar
	// {//en uso
	// 	die_pre($array, __LINE__, __FILE__);
	// 	if(empty($array['id_carrito']))
	// 	{
	// 		$this->db->where(array('alm_guarda.id_usuario' => $array['id_usuario']));
	// 		$this->db->join('alm_guarda', 'alm_guarda.id_carrito = alm_carrito.id_carrito');
	// 	}
	// 	else
	// 	{
	// 		$this->db->where(array('id_carrito' => $array['id_carrito']));
	// 	}
	// 	$alm_carrito = $this->db->get('alm_carrito')->row_array();
	// 	// die_pre($alm_carrito, __LINE__, __FILE__);
	// 	///genera el numero de solicitud
	// 		$aux = $this->get_last_id() + 1;
	//     	$nr = str_pad($aux, 9, '0', STR_PAD_LEFT);
 //    	///genera la fecha de envio
	//     	$this->load->helper('date');
	// 		$datestring = "%Y-%m-%d %H:%i:%s";
	// 		$time = time();
	// 		$fecha_gen = mdate($datestring, $time);
 //    	///genera la lista de articulos para la solicitud (carrito a solicitud)
	// 		$articulos = $this->db->get_where('alm_car_contiene', array('id_carrito' => $alm_carrito['id_carrito']))->result_array();
	// 		foreach ($articulos as $key => $art)
	// 		{
	// 			$contenido[$key]['id_articulo'] = $art['id_articulo'];
	// 			$contenido[$key]['nr_solicitud'] = $nr;
	// 			$contenido[$key]['cant_solicitada'] = $art['cant_solicitada'];
	// 		}
	// 		// die_pre($contenido, __LINE__, __FILE__);
	// 	///
	// 	if(!empty($array))
	// 	{
	// 		$alm_solicitud = array(
	// 			'nr_solicitud'=>$nr,
	// 			'status'=>'en_proceso',
	// 			'observacion'=>$alm_carrito['observacion'],
	// 			'fecha_gen'=>$fecha_gen);
			
	// 		$alm_efectua = array(
	// 			'id_usuario'=>$array['id_usuario'],
	// 			'nr_solicitud'=>$nr);
			

	// 		$alm_historial_s = array(
	// 			'nr_solicitud'=>$nr,
	// 			'fecha_ej'=>$fecha_gen,
	// 			'usuario_ej'=>$array['id_usuario'],
	// 			'status_ej'=>'en_proceso' );
			

	// 		$alm_art_en_solicitud = $contenido;
	// 		$this->db->insert('alm_solicitud', $alm_solicitud);
	// 		$sol = $this->db->insert_id();
	// 		$this->db->insert('alm_efectua', $alm_efectua);
	// 		$gen = $this->db->insert_id();
	// 		$this->db->insert('alm_historial_s', $alm_historial_s);
	// 		$hist = $this->db->insert_id();
	// 		$this->db->insert_batch('alm_art_en_solicitud', $alm_art_en_solicitud);
	// 		$cont = $this->db->insert_id();
	// 		// die_pre($sol*$gen*$hist*$cont, __LINE__, __FILE__);
	// 		////////debo desaparecer la solicitud en carrito
	// 		$this->db->delete('alm_carrito', array('id_carrito' => $alm_carrito['id_carrito']));
	// 		////////
	// 		return($sol*$gen*$hist*$cont);
	// 	}
	// 	return FALSE;
	// }

	public function insert_carrito($array)//para el carro de solicitudes por usuario
	{//en uso
		// die_pre($array, __LINE__, __FILE__);
		if(!empty($array))
		{
			$alm_carrito = array(
				'id_carrito'=>$array['id_carrito'],
				'observacion'=>$array['observacion']);
			$this->db->insert('alm_carrito', $alm_carrito);
			$alm_guarda = array(
				'id_usuario'=>$array['id_usuario'],
				'id_carrito'=>$array['id_carrito']);
			$this->db->insert('alm_guarda', $alm_guarda);

			$alm_car_contiene = $array['contiene'];
			$this->db->insert_batch('alm_car_contiene', $alm_car_contiene);
			return($this->db->insert_id());
		}
		return FALSE;
	}

///////////////////////funciones de consulta de BD


	public function get_last_id()//retorna un entero resultante del ultimo registro del campo ID de la tabla alm_solicitud
	{
		$this->db->select_max('nr_solicitud');
		$query = $this->db->get('alm_solicitud');
		$aux = $query->row();
		if(empty($aux))
		{
			die_pre($query->row(), __LINE__, __FILE__);
		}
		$this->db->select_max('ID');
		$query = $this->db->get('alm_solicitud');
		$row = $query->row();
		return($row->ID); // actualmetne es utilizado para generar el numero de Solicitud
	}

	// public function get_blah($where)//articulos de una solicitud de status = carrito, de un usuario correspondiente
	// {
	// 	// echo("linea 212 - Model_alm_solicitudes");
	// 	// echo_pre($where);
	// 	if(!is_array($where))
	// 	{
	// 		$aux = $where;
	// 		$where = array('nr_solicitud'=>$aux);
	// 	}
	// 	else
	// 	{
	// 		if(empty($where['nr_solicitud']))
	// 		{
	// 			$genera['alm_genera.id_usuario']=$where['id_usuario'];
	// 			$genera['status']=$where['status'];
	// 			$this->db->join('alm_genera', 'alm_genera.nr_solicitud = alm_solicitud.nr_solicitud');
	// 			$where = $this->db->get_where('alm_solicitud',$genera)->result()[0]->nr_solicitud;
	// 			$where = array('nr_solicitud'=>$where);
	// 		}
	// 		else
	// 		{
	// 			$aux = $where;
	// 			$where = array('nr_solicitud'=>$aux['nr_solicitud']);
	// 		}
	// 	}
	// 	$query = $this->db->get_where('alm_contiene', $where);
	// 	$int=0;
	// 	foreach ($query->result() as $key)
	// 	{
	// 		$array[$int]['id_articulo'] = $key->id_articulo;
	// 		$array[$int]['descripcion'] = $this->db->get_where('alm_articulo', array('ID' => $key->id_articulo))->result()[0]->descripcion;
	// 		$array[$int]['cant'] = $key->cant_solicitada;
	// 		$array[$int]['cant_aprob'] = $key->cant_aprobada;
	// 		$array[$int]['cant_usados'] = $key->cant_usados;
	// 		$array[$int]['cant_nuevos'] = $key->cant_nuevos;
	// 		$aux = $this->db->get_where('alm_articulo', array('ID' => $key->id_articulo))->result()[0];
	// 		$array[$int]['unidad'] = $aux->unidad;
	// 		$array[$int]['reserv'] = $aux->reserv;
	// 		$array[$int]['disp'] = $aux->nuevos + $aux->usados;
	// 		$array[$int]['nuevos'] = $aux->nuevos;
	// 		$array[$int]['usados'] = $aux->usados;

	// 		$int++;
	// 	}
 //        return($array);
	// }

	public function get_allSolicitud()//Retorna TODAS LAS SOLICITUDES
	{//actualizado
		$this->db->select('alm_efectua.id_usuario, nombre, apellido, email, telefono, alm_solicitud.status, sys_rol, fecha_gen, alm_solicitud.nr_solicitud, alm_solicitud.observacion, fecha_comp');
		$this->db->order_by('fecha_gen', 'desc');
		$this->db->from('dec_usuario');
		$this->db->join('alm_efectua', 'alm_efectua.id_usuario = dec_usuario.id_usuario');
		$this->db->join('alm_solicitud', 'alm_solicitud.nr_solicitud = alm_efectua.nr_solicitud');
		die_pre(objectSQL_to_array($this->db->get()->result()), __LINE__, __FILE__);
		return(objectSQL_to_array($this->db->get()->result()));
	}

	public function get_liveSolicitud()//Retorna Todas las Solicitudes menos las que han sido completadas (para fines de aprobacion y corroborar estado)
	{
		$this->db->where_not_in('status', 'completado');
		$aux = $this->db->get('alm_solicitud')->result();
		$aux = objectSQL_to_array($aux);
		die_pre($aux, __LINE__, __FILE__);
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
		die_pre($aux, __LINE__, __FILE__);
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
			$this->db->select('alm_efectua.id_usuario, nombre, apellido, email, telefono, alm_solicitud.status, sys_rol, fecha_gen, alm_solicitud.nr_solicitud, alm_solicitud.observacion, fecha_comp');
			if($status['alm_solicitud.status']=='x2')//solo para los permisos de aprobacion y despacho
			{
				$where = "alm_solicitud.status = 'en_proceso' OR alm_solicitud.status = 'aprobada'";
				$this->db->where($where);
			}
			else
			{
				$this->db->where($status);
			}

			$this->db->where_not_in('alm_solicitud.status', 'carrito');
		
			if(!empty($desde) && !empty($hasta))
			{
				$this->db->where('fecha_gen >=', $desde);
				$this->db->where('fecha_gen <=', $hasta);
			}
		
			$this->db->order_by('fecha_gen', 'desc');
			$this->db->from('dec_usuario');
			$this->db->join('alm_efectua', 'alm_efectua.id_usuario = dec_usuario.id_usuario');
			$this->db->join('alm_solicitud', 'alm_solicitud.nr_solicitud = alm_efectua.nr_solicitud');
			$this->db->limit($per_page, $offset);
			$array=$this->db->get()->result();
			$array = objectSQL_to_array($array);
			die_pre($aux, __LINE__, __FILE__);
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
	public function get_adminUser($id_usuario='', $field='', $order='', $per_page='', $offset='', $desde='', $hasta='')//recibe usuarios de solicitudes para administrador (recibe mas datos)
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
		$this->db->select('alm_efectua.id_usuario, nombre, apellido, email, telefono, alm_solicitud.status, sys_rol, fecha_gen, alm_solicitud.nr_solicitud, alm_solicitud.observacion, fecha_comp');
		$this->db->where_not_in('alm_solicitud.status', 'carrito');
		
		if(!empty($desde) && !empty($hasta))
		{
			$this->db->where('fecha_gen >=', $desde);
			$this->db->where('fecha_gen <=', $hasta);
		}

		$this->db->join('alm_efectua', 'alm_efectua.id_usuario = dec_usuario.id_usuario');
		$this->db->join('alm_solicitud', 'alm_solicitud.nr_solicitud = alm_efectua.nr_solicitud');
		$query = $this->db->get('dec_usuario', $per_page, $offset);
		// die_pre(objectSQL_to_array($query->result()), __LINE__, __FILE__);
		return objectSQL_to_array($query->result());
	}

	public function get_approvedSolicitudes($per_page='', $offset='')
	{
		$this->db->select('alm_genera.id_usuario, nombre, apellido, email, telefono, alm_solicitud.status, sys_rol, fecha_gen, alm_solicitud.nr_solicitud, alm_solicitud.observacion, fecha_comp');
		$this->db->where('alm_solicitud.status', 'aprobada');
		$this->db->join('alm_genera', 'alm_genera.id_usuario = dec_usuario.id_usuario');
		$this->db->join('alm_solicitud', 'alm_solicitud.nr_solicitud = alm_genera.nr_solicitud');
		if(!empty($per_page) && !empty($offset))
		{
			$query = $this->db->get('dec_usuario', $per_page, $offset)->result_array();
		}
		else
		{
			$query = $this->db->get('dec_usuario')->result_array();
		}
		return($query);
	}

	public function get_adminCount($desde='', $hasta='')
	{
		$this->db->select('alm_efectua.id_usuario, nombre, apellido, email, telefono, alm_solicitud.status, sys_rol, fecha_gen, alm_solicitud.nr_solicitud, alm_solicitud.observacion, fecha_comp');
		$this->db->where_not_in('alm_solicitud.status', 'carrito');
		
		if(!empty($desde) && !empty($hasta))
		{
			$this->db->where('fecha_gen >=', $desde);
			$this->db->where('fecha_gen <=', $hasta);
		}

		$this->db->from('dec_usuario');
		$this->db->join('alm_efectua', 'alm_efectua.id_usuario = dec_usuario.id_usuario');
		$this->db->join('alm_solicitud', 'alm_solicitud.nr_solicitud = alm_efectua.nr_solicitud');
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
	//$this->session->userdata('user')['id_dependencia'];
	public function get_departamentoCarts()//dado el numero de id del departamento, se trae todas las solicitudes con sus respectivos usuarios
	{
		$id_dependencia['id_dependencia']=$this->session->userdata('user')['id_dependencia'];
		$this->db->select('alm_guarda.id_usuario, nombre, apellido, sys_rol, alm_carrito.TIME AS fecha_gen, alm_carrito.id_carrito, alm_carrito.observacion');
		$this->db->where($id_dependencia);
		$this->db->order_by('fecha_gen', 'desc');
		$this->db->from('dec_usuario');
		$this->db->join('alm_guarda', 'alm_guarda.id_usuario = dec_usuario.id_usuario');
		$this->db->join('alm_carrito', 'alm_carrito.id_carrito = alm_guarda.id_carrito');
		$aux = $this->db->get()->result_array();
		// die_pre($aux, __LINE__, __FILE__);
		return($aux);
	}

	public function get_usersDepCartSol()//para construir los modales de los usuarios sobre las solicitudes y carritos por departamento
	{
		$id_dependencia['id_dependencia']=$this->session->userdata('user')['id_dependencia'];
		
		$this->db->select('dec_usuario.id_usuario, nombre, apellido, email, telefono, sys_rol');
		$this->db->where($id_dependencia);
		$this->db->join('alm_guarda', 'alm_guarda.id_usuario = dec_usuario.id_usuario');
		$this->db->distinct();
		$auxC = $this->db->get('dec_usuario')->result_array();
		
		$this->db->select('dec_usuario.id_usuario, nombre, apellido, email, telefono, sys_rol');
		$this->db->where($id_dependencia);
		$this->db->join('alm_efectua', 'alm_efectua.id_usuario = dec_usuario.id_usuario');
		$this->db->distinct();
		$auxS = $this->db->get('dec_usuario')->result_array();
		$aux = array_merge($auxS, $auxC);
		$aux = array_unique($aux, SORT_REGULAR);
		// die_pre(array_unique($aux, SORT_REGULAR));
		// die_pre($aux, __LINE__, __FILE__);
		return($aux);
	}

	public function get_departamentoSolicitud()//dado el numero de id del departamento, se trae todas las solicitudes con sus respectivos usuarios
	{
		$id_dependencia['id_dependencia']=$this->session->userdata('user')['id_dependencia'];
		$this->db->select('alm_efectua.id_usuario, nombre, apellido, sys_rol, alm_solicitud.status, fecha_gen, alm_solicitud.nr_solicitud, alm_solicitud.observacion, fecha_comp');
		$this->db->where($id_dependencia);
		$this->db->where('alm_solicitud.status !=', 'completado');
		$this->db->order_by('fecha_gen', 'desc');
		$this->db->from('dec_usuario');
		$this->db->join('alm_efectua', 'alm_efectua.id_usuario = dec_usuario.id_usuario');
		$this->db->join('alm_solicitud', 'alm_solicitud.nr_solicitud = alm_efectua.nr_solicitud');
		$aux = $this->db->get()->result_array();
		// die_pre($aux, __LINE__, __FILE__);
		return($aux);
	}
	public function get_depAprovedSolicitud()//del usuario en session, usa id_dependencia para traer todas las solicitudes aprobadas de su departamento
	{
		$id_dependencia['id_dependencia']=$this->session->userdata('user')['id_dependencia'];
		$this->db->select('alm_genera.id_usuario, nombre, apellido, sys_rol, alm_solicitud.status, fecha_gen, alm_solicitud.nr_solicitud, alm_solicitud.observacion, fecha_comp');
		$this->db->where($id_dependencia);
		$this->db->where('alm_solicitud.status', 'aprobada');
		$this->db->order_by('fecha_gen', 'desc');
		$this->db->from('dec_usuario');
		$this->db->join('alm_genera', 'alm_genera.id_usuario = dec_usuario.id_usuario');
		$this->db->join('alm_solicitud', 'alm_solicitud.nr_solicitud = alm_genera.nr_solicitud');
		$aux = $this->db->get()->result_array();
		// die_pre($aux, __LINE__, __FILE__);
		return($aux);
	}
	public function get_ownAprovedSolicitud()//del usuario en session, usa id_dependencia para traer todas las solicitudes aprobadas de su departamento
	{
		$id_usuario['alm_genera.id_usuario']=$this->session->userdata('user')['id_usuario'];
		$this->db->select('alm_genera.id_usuario, nombre, apellido, sys_rol, alm_solicitud.status, fecha_gen, alm_solicitud.nr_solicitud, alm_solicitud.observacion, fecha_comp');
		$this->db->where($id_usuario);
		$this->db->where('alm_solicitud.status', 'aprobada');
		$this->db->order_by('fecha_gen', 'desc');
		$this->db->from('dec_usuario');
		$this->db->join('alm_genera', 'alm_genera.id_usuario = dec_usuario.id_usuario');
		$this->db->join('alm_solicitud', 'alm_solicitud.nr_solicitud = alm_genera.nr_solicitud');
		$aux = $this->db->get()->result_array();
		// die_pre($aux, __LINE__, __FILE__);
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

	public function change_statusEn_proceso($where)//para expirar
	{
		// die_pre($where, __LINE__, __FILE__);
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
		echo_pre($where, __LINE__, __FILE__);
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

	public function get_solArticulos($where)//articulos de una solicitud, de un usuario correspondiente
	{/////en uso
		// echo("linea 212 - Model_alm_solicitudes");
		// echo_pre('get_solArticulos', __LINE__, __FILE__);
		if(!is_array($where))
		{
			$aux = $where;
			$where = array('nr_solicitud'=>$aux);
		}
		else
		{
			if(empty($where['nr_solicitud']))
			{
				$genera['alm_efectua.id_usuario']=$where['id_usuario'];
				$genera['status']=$where['status'];
				$this->db->join('alm_efectua', 'alm_efectua.nr_solicitud = alm_solicitud.nr_solicitud');
				$where = $this->db->get_where('alm_solicitud',$genera)->result()[0]->nr_solicitud;
				$where = array('nr_solicitud'=>$where);
			}
			else
			{
				$aux = $where;
				$where = array('nr_solicitud'=>$aux['nr_solicitud']);
			}
		}
		$query = $this->db->get_where('alm_art_en_solicitud', $where);
		$int=0;
		foreach ($query->result() as $key)
		{
			$array[$int]['id_articulo'] = $key->id_articulo;
			$array[$int]['descripcion'] = $this->db->get_where('alm_articulo', array('ID' => $key->id_articulo))->result()[0]->descripcion;
			$array[$int]['cant'] = $key->cant_solicitada;
			$array[$int]['cant_aprob'] = $key->cant_aprobada;
			$array[$int]['cant_usados'] = $key->cant_usados;
			$array[$int]['cant_nuevos'] = $key->cant_nuevos;
			$aux = $this->db->get_where('alm_articulo', array('ID' => $key->id_articulo))->result()[0];
			$array[$int]['unidad'] = $aux->unidad;
			$array[$int]['reserv'] = $aux->reserv;
			$array[$int]['disp'] = $aux->nuevos + $aux->usados;
			$array[$int]['nuevos'] = $aux->nuevos;
			$array[$int]['usados'] = $aux->usados;

			$int++;
		}
        return($array);
	}
	public function get_cartArticulos($where)//articulos de una solicitud, de un usuario correspondiente
	{
		// echo("linea 212 - Model_alm_solicitudes");
		// echo_pre('get_cartArticulos', __LINE__, __FILE__);
		if(!is_array($where))
		{
			$aux = $where;
			$where = array('id_carrito'=>$aux);
		}
		else
		{
			if(empty($where['id_carrito']))
			{
				$genera['alm_genera.id_usuario']=$where['id_usuario'];
				$genera['status']=$where['status'];
				$this->db->join('alm_genera', 'alm_genera.nr_solicitud = alm_solicitud.nr_solicitud');
				$where = $this->db->get_where('alm_solicitud',$genera)->result()[0]->nr_solicitud;
				$where = array('id_carrito'=>$where);
			}
			else
			{
				$aux = $where;
				$where = array('id_carrito'=>$aux['id_carrito']);
			}
		}
		$query = $this->db->get_where('alm_car_contiene', $where);
		$int=0;
		foreach ($query->result() as $key)
		{
			$array[$int]['id_articulo'] = $key->id_articulo;
			$array[$int]['descripcion'] = $this->db->get_where('alm_articulo', array('ID' => $key->id_articulo))->result()[0]->descripcion;
			$array[$int]['cant'] = $key->cant_solicitada;
			// $array[$int]['cant_aprob'] = $key->cant_aprobada;
			// $array[$int]['cant_usados'] = $key->cant_usados;
			// $array[$int]['cant_nuevos'] = $key->cant_nuevos;
			$aux = $this->db->get_where('alm_articulo', array('ID' => $key->id_articulo))->result()[0];
			$array[$int]['unidad'] = $aux->unidad;
			// $array[$int]['reserv'] = $aux->reserv;
			// $array[$int]['disp'] = $aux->nuevos + $aux->usados;
			// $array[$int]['nuevos'] = $aux->nuevos;
			// $array[$int]['usados'] = $aux->usados;

			$int++;
		}
        return($array);
	}

	public function get_idArticulos($nr_solicitud)//articulos de una solicitud en carrito, de un usuario correspondiente
	{
		echo_pre('get_idArticulos', __LINE__, __FILE__);
		// echo("linea 212 - Model_alm_solicitudes");
		// echo_pre($where);
		if(!is_array($nr_solicitud))
		{
			$aux = $nr_solicitud;
			$nr_solicitud = array('nr_solicitud'=>$aux);
		}
		else
		{
			$aux = $nr_solicitud;
			$nr_solicitud = array('nr_solicitud'=>$aux['nr_solicitud']);
		}
		$query = $this->db->get_where('alm_contiene', $nr_solicitud);
		$int=0;
		foreach ($query->result() as $key)
		{
			$array[$int]['id_articulo'] = $key->id_articulo;
			$int++;
		}
        return($array);
	}

	public function exist($where)//usado al iniciar session, y al generar una solicitud nueva (retorna si existe una solicitud con condiciones predeterminadas en un arreglo)
	{
		if(isset($where['id_usuario']) && isset($where['status']))
		{
			$genera['alm_genera.id_usuario']=$where['id_usuario'];
			$genera['status']=$where['status'];
		}
		else
		{
			$genera['alm_solicitud.nr_solicitud'] = $where['nr_solicitud'];
		}
		$this->db->join('alm_genera', 'alm_genera.nr_solicitud = alm_solicitud.nr_solicitud');
		$query = $this->db->get_where('alm_solicitud',$genera);
        return($query->num_rows() > 0);
	}

	public function allDataSolicitud($nr_solicitud)//dado el numero de una solicitud, retorna todos los datos de una solicitud(incluyendo quien la genera, y los articulos)
	{
		echo_pre('allDataSolicitud', __LINE__, __FILE__);
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

	public function get_recibidoUsers()
	{
		// $this->db->select('nr_solicitud, id_usuario AS recibido_por');
		// $this->db->group_by('nr_solicitud');
		// $query = $this->db->get('alm_retira')->result_array();
		// // die_pre($query, __LINE__, __FILE__);
		// if(!empty($query))
		// {
		// 	foreach ($query as $key => $value)
		// 	{
		// 		$this->db->select('nombre, apellido');
		// 		$this->db->where('id_usuario',$value['recibido_por']);
		// 		// SE EXTRAEN TODOS LOS DATOS DEl USUARIO
		// 		$aux = $this->db->get('dec_usuario')->result_array()[0];
		// 		// echo_pre($aux);
		// 		$result[$value['nr_solicitud']] = $aux['nombre'].' '.$aux['apellido'];
		// 	}
		// 	// die_pre($result, __LINE__, __FILE__);
		// 	return($result);
		// }
		// else
		// {
		// 	return(NULL);
		// }

	}
	public function completar_solicitud($array)//despachar
	{
		$solicitud['nr_solicitud'] = $array['nr_solicitud'];
		$nr_solicitud = $array['nr_solicitud'];
		$query = $this->db->get_where('alm_contiene', $solicitud)->result_array();
		// die_pre($query, __LINE__, __FILE__);
		if(!empty($query))
		{
			foreach ($query as $key => $value)//para cada articulo
			{
				// echo_pre($value['id_articulo'], __LINE__, __FILE__);
				$despachado = $value['cant_aprobada'];
				$art['ID'] = $value['id_articulo'];
				$this->db->where($art);
				$articulo = $this->db->get('alm_articulo')->result_array()[0];

				if(($articulo['nuevos']+$articulo['usados']+$articulo['reserv'])==0)//desactiva el articulo, si se agoto la existencia
				{
					$articulo['ACTIVE'] = 0;
				}
				$articulo['reserv'] = $articulo['reserv']-$despachado;
				$this->db->where($art);
				$this->db->update('alm_articulo', $articulo);//decrementar de alm_articulo

				$hist_a = array('id_articulo' => $articulo['cod_articulo'], );

				if($value['cant_nuevos'] > 0 && $value['cant_usados'] > 0)
				{
					$id_historial = $nr_solicitud.$value['id_articulo'].'1';
					//guardar detalle sobre historial (alm_historial_a)
					$historial_a = array('id_historial_a' => $id_historial,
										'salida' => $value['cant_nuevos'],
										'nuevo'=> 1,
										'observacion' => ' ');
					
					$this->db->insert('alm_historial_a', $historial_a);//inserto el historial
					$link=array(
			        'id_historial_a'=>$historial_a['id_historial_a'],
			        'id_articulo'=> $articulo['cod_articulo']
			        );
			        $this->db->insert('alm_genera_hist_a', $link);//inserto el enlace con el historial

					$id_historial = $nr_solicitud.$value['id_articulo'].'0';
					//guardar detalle sobre historial (alm_historial_a)
					$historial_a = array('id_historial_a' => $id_historial,
										'salida' => $value['cant_usados'],
										'nuevo'=> 0,
										'observacion' => ' ');
					
					$this->db->insert('alm_historial_a', $historial_a);//inserto el historial
					$link=array(
			        'id_historial_a'=>$historial_a['id_historial_a'],
			        'id_articulo'=> $articulo['cod_articulo']
			        );
			        $this->db->insert('alm_genera_hist_a', $link);//inserto el enlace con el historial

				}
				else
				{
					if($value['cant_nuevos'] > 0)
					{
						$id_historial = $nr_solicitud.$value['id_articulo'].'1';
						//guardar detalle sobre historial (alm_historial_a)
						$historial_a = array('id_historial_a' => $id_historial,
											'salida' => $value['cant_nuevos'],
											'nuevo'=> 1,
											'observacion' => ' ');
							$this->db->insert('alm_historial_a', $historial_a);//inserto el historial
							$link=array(
					        'id_historial_a'=>$historial_a['id_historial_a'],
					        'id_articulo'=> $articulo['cod_articulo']
					        );
					        $this->db->insert('alm_genera_hist_a', $link);//inserto el enlace con el historial

					}
					else
					{
						if($value['cant_usados'] > 0)
						{
							$id_historial = $nr_solicitud.$value['id_articulo'].'0';
							//guardar detalle sobre historial (alm_historial_a)
							$historial_a = array('id_historial_a' => $id_historial,
												'salida' => $value['cant_usados'],
												'nuevo'=> 0,
												'observacion' => ' ');
							$this->db->insert('alm_historial_a', $historial_a);//inserto el historial
							$link=array(
					        'id_historial_a'=>$historial_a['id_historial_a'],
					        'id_articulo'=> $articulo['cod_articulo']
					        );
					        $this->db->insert('alm_genera_hist_a', $link);//inserto el enlace con el historial

						}
					}
				}
				//indico quien retiro la solicitud (tabla alm_retira) por cada articulo
				$retira = array('nr_solicitud' => $array['nr_solicitud'],
								'cod_articulo' => $articulo['cod_articulo'],
								'id_usuario' => $array['id_usuario']);
				$this->db->insert('alm_retira', $retira);

			}

			//actualizo el estado de la solicitud
			$this->load->helper('date');
			$datestring = "%Y-%m-%d %h:%i:%s";
			$time = time();
			$aux = array('status'=>'completado', 'fecha_comp'=>mdate($datestring, $time));
			$this->db->where($solicitud);
			$this->db->update('alm_solicitud', $aux);

			$aux = array('fecha_comp'=>mdate($datestring, $time));
			$this->db->where(array('NRS' => $nr_solicitud));
			$this->db->update('alm_historial_s', $aux);
			return(TRUE);
		}
		else
		{
			return(FALSE);
		}
	}
	public function aprobar_solicitud($nr_solicitud, $solicitud)
	{
		// echo_pre($solicitud);
		// die_pre($nr_solicitud, __LINE__, __FILE__);
		$estado = 0;//variable auxiliar acumulativa, para cambiar el estado de la solicitud de 'aprobado'...
		//A 'en_proceso' de forma automatica, si se aprueban todas las cantidades aprobadas en 
		foreach ($solicitud as $key => $value)//para recorrer los renglones de articulos de la solicitud
		{
			$estado = $estado + $value['cant_aprobada'];
			$aux = array('nr_solicitud' => $value['nr_solicitud'],
				'id_articulo' => $value['id_articulo']);
			// die_pre($value);
			$query = $this->db->get_where('alm_art_en_solicitud', $aux)->result_array()[0];//consulto el contenido de articulos en la solicitud
			$aprob_anterior = $query['cant_aprobada'];
			$nuevos_anterior = $query['cant_nuevos'];
			$usados_anterior = $query['cant_usados'];
			//se guarda en variables auxiliares
			// die_pre($query);
			$this->db->where($aux);
			$this->db->update('alm_art_en_solicitud', $value);//guardo los nuevos valores del contenido en solicitud

			$art['ID'] = $value['id_articulo'];
			$this->db->where($art);
			$query = $this->db->get('alm_articulo')->result_array()[0];//consulto el articulo en sistema que conside con el de la solicitud
			// echo_pre($query);
			// echo_pre($value['cant_aprobada']);
			// echo_pre('anterior: '.$aprob_anterior);
			
			if($value['cant_aprobada'] != $aprob_anterior)//si la cantidad aprobada antes, es diferente a la cantidad aprobada antes
			{
				if($value['cant_aprobada'] > $aprob_anterior)//si la cantidad aprobada, es mayor que la cantidad aprobada antes(si se aprueba por primera vez, vale 0)
				{
					$query['reserv'] = ($query['reserv'] + ($value['cant_aprobada'] - $aprob_anterior));
					//entonces la cantidad de ese articulo reservado, pasa a ser la suma de lo que estaba reservado antes, mas la cantidad aprobada, menos la cantidad aprobada antes
				}
				else//en caso que la cantidad aprobada, sea menor o igual a la cantidad aprobada anterior
				{
					$query['reserv'] = ($query['reserv'] - ($aprob_anterior - $value['cant_aprobada']));//disminuyo de reservados
					//entonces la cantidad reservada de ese articulo, pasa a ser la resta de la cantidad reservada anterior, menos la resta entre la cantidad aprobada anterior menos la cantidad aprobada actual
				}
			}

			if($value['cant_nuevos'] != $nuevos_anterior)//aplica el mismo algoritmo de las cantidades reservadas, excepto que suma cuando resta en reserva, y resta cuando suma en reserva
			{
				if($value['cant_nuevos'] > $nuevos_anterior)
				{
					$query['nuevos'] = ($query['nuevos'] - ($value['cant_nuevos'] - $nuevos_anterior));
				}
				else
				{
					$query['nuevos'] = ($query['nuevos'] + ($nuevos_anterior - $value['cant_nuevos']));//se lo sumo a articulos nuevos si esos eran los que reserve antes
				}					
			}

			if($value['cant_usados'] != $usados_anterior)//aplica el mismo algoritmo de las cantidades reservadas, excepto que suma cuando resta en reserva, y resta cuando suma en reserva
			{
				if($value['cant_usados'] > $usados_anterior)
				{
					$query['usados'] = ($query['usados'] - ($value['cant_usados'] - $usados_anterior));
				}
				else
				{
					$query['usados'] = ($query['usados'] + ($usados_anterior - $value['cant_usados']));//se lo sumo a articulos usados si esos eran los que reserve antes
				}
			}

			// die_pre($query, __LINE__, __FILE__);
			$this->db->update('alm_articulo', $query, $art);//actualiza los nuevos datos en el articulo
		}
		// $aprueba = array('id_usuario' => $this->session->userdata('user')['id_usuario'],
		// 				'nr_solicitud' =>$value['nr_solicitud']);
		// $test = $this->db->get_where('alm_efectua', $aprueba)->result_array();
		$efectua = array('id_usuario' => $this->session->userdata('user')['id_usuario'],
						'nr_solicitud' =>$value['nr_solicitud']);
		$aprueba = array('usuario_ej' => $this->session->userdata('user')['id_usuario'],
						'nr_solicitud' => $value['nr_solicitud'],
						'status_ej' => 'aprobado');
		$test = $this->db->get_where('alm_historial_s', $aprueba)->result_array();//verifico si la solicitud fue previamente aprobada
		// die_pre($test, __LINE__, __FILE__);
		if(empty($test))//en caso de que la solicitud no aparesca como aprobada anteriormente, la ingreso a la bd como aprobada
		{
			$this->db->where(array('nr_solicitud' =>$value['nr_solicitud']));
			$this->db->update('alm_efectua', $efectua);//esto dara problemas si una misma persona solicita, aprueba, cancela, despacha, anula, o cualquier combinacion de ellas
			$this->db->insert('alm_historial_s', $aprueba);
		}
		
		if($estado == 0) //si la solicitud queda vacia
		{
			$update['status'] = 'en_proceso';//pasa a estar en proceso
		}
		else
		{
			$update['status'] = 'aprobado';
		}
		$this->db->where($nr_solicitud);
		$this->db->update('alm_solicitud', $update);//actualiza el estatus de la solicitud

		$this->load->helper('date');
		$datestring = "%Y-%m-%d %h:%i:%s";
		$time = time();
		if($update['status']=='aprobado')//actualiza el historial de la solicitud
		{
			// $historial_s = array('fecha_ap'=>mdate($datestring, $time));
			$historial_s['fecha_ej'] = mdate($datestring, $time);
			$historial_s['usuario_ej'] = $this->session->userdata('user')['id_usuario'];
			$historial_s['status_ej'] = 'aprobado';
		}
		else
		{
			// $historial_s = array('fecha_ap'=>NULL);
			$historial_s['fecha_ej'] = mdate($datestring, $time);
			$historial_s['usuario_ej'] = $this->session->userdata('user')['id_usuario'];
			$historial_s['status_ej'] = 'en_proceso';
		}
		$this->db->where(array('nr_solicitud' => $nr_solicitud['nr_solicitud'], 'status_ej' => $historial_s['status_ej']));
		$this->db->update('alm_historial_s', $historial_s);
// `fecha_ej`
// `usuario_ej`
// `status_ej`

		// return($this->db->update_id());
	}

//////////////////////////////////////////Carrito de solicitudes por usuario, todavia no enviadas a administracion
	public function update_carrito($array)
	{
		foreach ($array as $key => $value)
		{
			if($key=='observacion')
			{
				$update['observacion']=$value;
			}
			if($key=='id_carrito')
			{
				$where['id_carrito']=$value;
			}
		}
		if(!(empty($where)&&empty($update)))
		{
			$this->db->where($where);
			$this->db->update('alm_carrito', $update);
			return(true);
		}
		else
		{
			return(false);
		}
	}
	public function allDataCarrito($id_carrito='')
	{
		// die_pre($this->session->userdata('user')['id_usuario'], __LINE__, __FILE__);
		if(empty($id_carrito))
		{
			$this->db->where(array('id_usuario' => $this->session->userdata('user')['id_usuario']));
		}
		else
		{
			$this->db->where(array('alm_carrito.id_carrito' => $id_carrito));
		}
		$this->db->join('alm_carrito', 'alm_carrito.id_carrito = alm_guarda.id_carrito'); // me traigo la observacion del carrito
		$query = $this->db->get('alm_guarda')->row_array();
		$carrito['carrito'] = $query;
		// die_pre($carrito, __LINE__, __FILE__);
		$this->db->select('id_articulo, descripcion, cant_solicitada AS cant');
		$this->db->join('alm_articulo', 'alm_articulo.ID = alm_car_contiene.id_articulo');
		$this->db->where(array('id_carrito' => $query['id_carrito']));
		$carrito['articulos'] = $this->db->get('alm_car_contiene')->result_array();
		// die_pre($carrito, __LINE__, __FILE__);
		return($carrito);
	}

	public function get_carArticulos($id_carrito)
	{
		$this->db->select('id_articulo');
		$query = $this->db->get_where('alm_car_contiene', array('id_carrito' => $id_carrito))->result_array();
		return($query);
	}

	public function get_last_cart()//retorna un entero resultante del ultimo registro del campo ID de la tabla alm_carrito
	{
		$this->db->select_max('id_carrito');
		$query = $this->db->get('alm_carrito');
		$aux = $query->row();
		if(empty($aux))
		{
			die_pre($query->row(), __LINE__, __FILE__);
		}
		$this->db->select_max('ID');
		$query = $this->db->get('alm_carrito');
		$row = $query->row();
		return($row->ID); // actualmetne es utilizado para generar el identificador de carrito
	}

	public function delete_carrito($cart)//para eliminar el carrito de la base de datos y todos sus relaciones y adyacencias
	{//debe recibir solo el id_carrito
		die_pre($cart, __LINE__, __FILE__);
		$this->db->where($cart);
		$this->db->delete('alm_carrito');
		$this->db->where($cart);
		$this->db->delete('alm_car_contiene');
		$this->db->where($cart);
		$this->db->delete('alm_guarda');
		$query = $this->db->get_where('alm_carrito', $cart)->row_array();
		if($query)
		{
			return(FALSE);
		}
		else
		{
			return(TRUE);
		}

	}

	public function remove_art($car_art)//FUNCIONA
	{
		// die_pre($car_art, __LINE__, __FILE__);
		$this->db->where($car_art);
		$this->db->delete('alm_car_contiene');
	}
	public function add_art($car_art)//FUNCIONA recibe un array('id_articulo','NRS','nr_solicitud','cant_solicitada');
	{
		// die_pre($car_art, __LINE__, __FILE__);
		$car_art['cant_solicitada'] = 1;
		$this->db->insert('alm_car_contiene', $car_art);
		return($this->db->insert_id());
	}
	public function get_userCart($where='')//se utiliza para cargar los datos de la tabla de carro de "compras" para luego ser asignado en sesion
	{
		$this->db->select('id_carrito');
		if(!empty($where['id_usuario']))
		{
			$this->db->where($where);
		}
		else
		{
			$this->db->where(array('id_usuario' => $this->session->userdata('user')['id_usuario']));
		}
		$carrito = $this->db->get('alm_guarda')->row_array();
		if(empty($carrito))
		{
			return FALSE;
		}
		else
		{
			
			$this->db->select('id_articulo, cant_solicitada');
			$this->db->where($carrito);
			$articulos = $this->db->get('alm_car_contiene')->result_array();
			$articulos = $this->model_alm_articulos->get_articulos($articulos);
			// die_pre($articulos, __LINE__, __FILE__);
			$cart['id_carrito'] = $carrito['id_carrito'];
			$cart['articulos'] = $articulos;
			// die_pre($cart, __LINE__, __FILE__);
			return $cart;
		}
	}

	public function update_ByidArticulos($where, $array) //edita las cantidades de los articulos de una solicitud, a travez de los ID de los mimos
	{
		$this->db->where($where);
		$this->db->update('alm_car_contiene', $array);
	}
	public function update_observacion($where, $observacion)
	{
		// die_pre($observacion, __LINE__, __FILE__);
		$this->db->where(array('id_carrito' => $where));
		$this->db->update('alm_carrito', array('observacion' => $observacion ));
	}
//se pregunta antes de editar el carrito
	public function cart_isOwner($id_carrito)//se le pasa un string de id carrito, y verifica en BD si no ha sido enviada y, si es dueno del carrito
	{
		$where['id_usuario'] = $this->session->userdata('user')['id_usuario'];
		$where['id_carrito'] = $id_carrito;
		$query = $this->db->get_where('alm_guarda', $where)->row_array();
		if(!empty($query))
		{
			return($query);
		}
		else
		{
			return(FALSE);
		}
	}
	public function solicitud_toCart()//editar antes de probar
	{
		$querry_llenado1="insert into (a1, a2, a3)".$periodo_nuevo."_DAE_ALUMNOS_NR b values(select * from ".$periodo_pasado."_DAE_ALUMNOS_NR c where condicion )";
		$bd_sice->ejecutarQuery($querry_llenado1);
	}

//////////////////////////////////////////FIN DE Carrito de solicitudes por usuario, todavia no enviadas a administracion
<<<<<<< HEAD
//////////ver. 1.3
/////////////////////////////////////////Carrito de usuario////////////////////////////////////////////////

/////////////////////////////////////////FIN DE Carrito de usuario/////////////////////////////////////////


=======
	public function migracion()
	{
		$insertID=1;
		// echo_pre($id_carrito);
		//consultar las solicitudes con estatus "en_carrito" de alm_solicitud, alm_genera, alm_contiene y alm_historial_s
		$where['status'] = 'carrito';
    	$this->db->where($where);
    	$this->db->join('alm_genera', 'alm_genera.nr_solicitud = alm_solicitud.nr_solicitud');
    	$this->db->join('alm_historial_s', 'alm_historial_s.NRS = alm_solicitud.nr_solicitud');
    	// $this->db->join('alm_contiene', 'alm_contiene.nr_solicitud = alm_solicitud.nr_solicitud');
    	$sol=$this->db->get('alm_solicitud')->result_array();
    	echo "cargo todas las solicitudes de status carrito: </br>";
    	echo_pre($sol, __LINE__, __FILE__);
    	if(!empty($sol))
    	{
    		foreach ($sol as $key => $value)
    		{
				$id = $this->get_last_cart();
				$id_carrito = str_pad($id+1, 9, '0', STR_PAD_LEFT);
    			$delete['nr_solicitud'] = $value['nr_solicitud'];
		    	//desglozar los datos relevantes para "alm_carrito"
		    	$carrito['id_carrito']=$id_carrito;
		    	$carrito['observacion']=$value['observacion'];
		    	$guarda['id_usuario']=$value['id_usuario'];
		    	$guarda['id_carrito']=$id_carrito;

		    	//insertar los datos en alm_guarda, alm_carrito y alm_car_contiene
		    	$this->db->insert('alm_carrito', $carrito);
		    	$insertID *= $this->db->insert_id();
		    	$this->db->insert('alm_guarda', $guarda);
		    	$insertID *= $this->db->insert_id();

		    	$where2['nr_solicitud'] = $value['nr_solicitud'];
    			$articulos = $this->db->get_where('alm_contiene', $where2)->result_array();
    			echo "Articulos de la solicitud nr: ".$value['nr_solicitud']."</br>";
    			echo_pre($articulos, __LINE__, __FILE__);
    			foreach ($articulos as $ind => $art)
    			{
	    			$carcontiene['id_carrito']=$id_carrito;
	    			$carcontiene['id_articulo']=$art['id_articulo'];
	    			$carcontiene['cant_solicitada']=$art['cant_solicitada'];
	    			$this->db->insert('alm_car_contiene', $carcontiene);
		    		$insertID *= $this->db->insert_id();
    			}
    			if($insertID)
    			{
    				//eliminar los datos de alm_genera, alm_solicitud, alm_contiene y alm_historial_s
    				echo "valor de nr solicitud a borrar </br>";
    				echo_pre($delete);
	    			$this->db->delete('alm_solicitud', $delete);
	    			echo $this->db->last_query();
	    			// $this->db->delete('alm_genera', array('nr_solicitud' => $delete));
	    			// $this->db->delete('alm_contiene', array('nr_solicitud' => $delete));
	    			// $this->db->delete('alm_historial_s', array('nr_solicitud' => $delete));
	    			//reinicia la validacion de las inserciones
    				$insertID=1;
    			}
    		}
	    	if($insertID)
	    	{
	    		// $where['status'] = 'carrito';
		    	// $this->db->where($where);
		    	$this->db->join('alm_genera', 'alm_genera.nr_solicitud = alm_solicitud.nr_solicitud');
		    	$this->db->join('alm_historial_s', 'alm_historial_s.NRS = alm_solicitud.nr_solicitud');
	    		$sol=$this->db->get('alm_solicitud')->result_array();
	    		die_pre($sol, __LINE__, __FILE__);
	    		return TRUE;
	    	}
	    	else
	    	{
	    		return FALSE;
	    	}
    	}
    	else
    	{
    		$aux['alm_solicitud.nr_solicitud'] = '000000002';
    		$this->db->where($aux);
    		$this->db->join('alm_genera', 'alm_genera.nr_solicitud = alm_solicitud.nr_solicitud');
	    	$this->db->join('alm_historial_s', 'alm_historial_s.NRS = alm_solicitud.nr_solicitud');
    		$sol=$this->db->get('alm_solicitud')->result_array();
    		die_pre($sol, __LINE__, __FILE__);
    	}
	}
>>>>>>> origin/master
}