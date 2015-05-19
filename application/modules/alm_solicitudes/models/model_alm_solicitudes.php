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

	// public function get_userSolicitud($id_usuario)
	// {

	// 	if()
	// 	{
			
	// 		return($array);
	// 	}
	// 	return FALSE;
	// }

	public function change_statusA2B($user)
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

	// public function change_statusB2C($array)
	// {
	// 	$aux = array(
	// 		'status' = 'en_proceso');
	// 	$this->db->where($array);
	// 	$this->db->update('alm_solicitud', $aux);
	// }
	// public function change_statusC2D($array)
	// {
	// 	$aux = array(
	// 		'status' = 'en_proceso');
	// 	$this->db->where($array);
	// 	$this->db->update('alm_solicitud', $aux);
	// }
	public function get_carrito($where)//articulos de una solicitud de status = carrito, de un usuario correspondiente
	{
		$aux = $this->db->get_where('alm_solicitud',$where)->result()[0]->nr_solicitud;

		$where = array('nr_solicitud'=>$aux);
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