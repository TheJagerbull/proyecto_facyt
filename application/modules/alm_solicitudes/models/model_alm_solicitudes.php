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

	public function change_status($array)
	{
		$this->db->where('nr_solicitud', $array['nr_solicitud']);
		$this->db->update('alm_solicitud', $array);
	}
	public function exist($where)
	{
		$query = $this->db->get_where('alm_solicitud',$where);
        return($query->num_rows() > 0);
	}

}