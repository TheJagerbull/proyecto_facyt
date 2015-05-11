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

	public function exist($where)
	{
		$query = $this->db->get_where('alm_solicitud',$where);
        return($query->num_rows() > 0);
	}

}