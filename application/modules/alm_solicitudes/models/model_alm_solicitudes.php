<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Model_alm_solicitudes extends CI_Model
{
	//constructor predeterminado del modelo
	function __construct()
	{
		parent::__construct();
	}

	public function get_last_id()
	{
		$this->db->select_max('ID');
		$query = $this->db->get('alm_solicitud');
		$row = $query->row();
		return($row->ID);
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
	public function get_allSolicitud()
	{
		$this->db->select('alm_genera.id_usuario, nombre, apellido, email, telefono, alm_solicitud.status, sys_rol, fecha_gen, alm_solicitud.nr_solicitud, alm_solicitud.observacion, fecha_comp');
		$this->db->order_by('fecha_gen', 'desc');
		$this->db->from('dec_usuario');
		$this->db->join('alm_genera', 'alm_genera.id_usuario = dec_usuario.id_usuario');
		$this->db->join('alm_solicitud', 'alm_solicitud.nr_solicitud = alm_genera.nr_solicitud');
		return(objectSQL_to_array($this->db->get()->result()));
	}

	public function get_liveSolicitud()
	{
		$this->db->where_not_in('status', 'completado');
		$aux = $this->db->get('alm_solicitud')->result();
		$aux = objectSQL_to_array($aux);
		return($aux);
	}

	public function get_departamentoSolicitud($id)//dado el numero de id del departamento, se trae todas las solicitudes con sus respectivos usuarios
	{
		$id_dependencia['id_dependencia']=$id;
		$this->db->select('alm_genera.id_usuario, nombre, apellido, email, telefono, alm_solicitud.status, sys_rol, fecha_gen, alm_solicitud.nr_solicitud, alm_solicitud.observacion, fecha_comp');
		$this->db->where($id_dependencia);
		$this->db->where('alm_solicitud.status !=', 'completado');
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
	public function get_depLastCompleted($id)
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
	public function get_adminDepSolicitud($id)
	{
		$id_dependencia['id_dependencia']=$id;
		$this->db->select('alm_genera.id_usuario, nombre, apellido, email, telefono, alm_solicitud.status, sys_rol, fecha_gen, alm_solicitud.nr_solicitud, alm_solicitud.observacion, fecha_comp');
		$this->db->where($id_dependencia);
		$this->db->order_by('fecha_gen', 'desc');
		$this->db->from('dec_usuario');
		$this->db->join('alm_genera', 'alm_genera.id_usuario = dec_usuario.id_usuario');
		$this->db->join('alm_solicitud', 'alm_solicitud.nr_solicitud = alm_genera.nr_solicitud');
		$aux = $this->db->get()->result();
		$aux = objectSQL_to_array($aux);
		// die_pre($aux);
		return($aux);
	}

	public function get_userSolicitud($id_usuario)//funciona correctamente
	{
		$find['id_usuario']=$id_usuario;
		$array=$this->db->get_where('alm_solicitud', $find)->result();
		$array = objectSQL_to_array($array);
		return($array);
	}

	public function change_statusEn_proceso($where)
	{
		$array = array(
			'status' => 'carrito');
		$array = array_merge($where, $array);
		echo_pre($array);
		$aux = array(
			'status' => 'en_proceso');
		$aux = array_merge($where, $aux);
		die_pre($aux);

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

	public function change_statusCompletado($array)
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
	public function get_solArticulos($where)//articulos de una solicitud de status = carrito, de un usuario correspondiente
	{
		if(empty($where['nr_solicitud']))
		{
			$where = $this->db->get_where('alm_solicitud',$where)->result()[0]->nr_solicitud;
			$where = array('nr_solicitud'=>$where);
		}
		else
		{
			$aux = $where;
			$where = array('nr_solicitud'=>$aux['nr_solicitud']);
		}
		$query = $this->db->get_where('alm_contiene', $where);
		$int=0;
		foreach ($query->result() as $key)
		{
			$array[$int]['id_articulo'] = $key->id_articulo;
			$array[$int]['descripcion'] = $this->db->get_where('alm_articulo', array('ID' => $key->id_articulo))->result()[0]->descripcion;
			$array[$int]['cant'] = $key->cant_solicitada;
			$int++;
		}
        return($array);
	}
	public function exist($where)
	{
		$query = $this->db->get_where('alm_solicitud',$where);
        return($query->num_rows() > 0);
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