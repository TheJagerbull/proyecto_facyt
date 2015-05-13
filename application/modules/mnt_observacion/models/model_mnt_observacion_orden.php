<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Model_mnt_observacion_orden extends CI_Model
{
	//constructor predeterminado del modelo
	function __construct()
	{
		parent::__construct();
	}
		
	
	public function insert_orden($data='')
	{
		if(!empty($data))
		{
			$data['observac']=$_POST['observac'];
			$this->db->insert('mnt_observacion_orden',$data);
			return $this->db->insert_id();
		}
		return FALSE;
	}
	
	public function edit_orden($data='')
	{
		if(!empty($data))
		{
			$this->db->where('id',$data['id']);
			$this->db->update('mnt_observacion_orden',$data);
			return $data['id'];
		}
		return FALSE;
	}
}