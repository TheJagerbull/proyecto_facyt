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
		return($this->db->get('alm_solicitud')->result());
	}

	public function get_liveSolicitud()
	{
		$this->db->where_not_in('status', 'completado');
		return($this->db->get('alm_solicitud')->result());
	}

	public function get_departamentoSolicitud($id)//dado el numero de id del departamento, se trae todas las solicitudes con sus respectivos usuarios
	{
		$id_dependencia['id_dependencia']=$id;
		$status['alm_solicitud.status']='completado';
		$this->db->select('alm_genera.id_usuario, nombre, apellido, email, telefono, alm_solicitud.status, sys_rol, fecha_gen, alm_solicitud.nr_solicitud, alm_solicitud.observacion, fecha_comp');
		$this->db->where($id_dependencia);
		$this->db->order_by('fecha_gen', 'desc');
		$this->db->from('dec_usuario');
		$this->db->join('alm_genera', 'alm_genera.id_usuario = dec_usuario.id_usuario');
		$this->db->join('alm_solicitud', 'alm_solicitud.nr_solicitud = alm_genera.nr_solicitud');
		$this->db->where_not_in($status);
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
		die_pre($array);
		return($array);
	}

	public function change_statusEn_proceso($user)
	{
		$array = array(
			'id_usuario' => $user,
			'status' => 'carrito');

		$aux = array(
			'status' => 'en_proceso');

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
			$aux = array('status'=>'completado');
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
		}
		$where = array('nr_solicitud'=>$where['nr_solicitud']);
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

}