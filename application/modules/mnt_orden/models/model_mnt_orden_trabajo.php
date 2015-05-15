<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Model_mnt_orden_trabajo extends CI_Model
{
	//constructor predeterminado del modelo
	function __construct()
	{
		parent::__construct();
	}
		


	public function insert_orden($data1='')
	{
		if(!empty($data1))

		{
			$this->db->insert('mnt_orden_trabajo',$data1);

			
		}
		return FALSE;
	}
	
	//public function edit_orden($data='')
	//{
		//if(!empty($data))
		//{
			//$this->db->where('id',$data['id']);
			//$this->db->update('mnt_orden_trabajo',$data);
			//return $data['id'];
		//}
		//return FALSE;
	//}
}