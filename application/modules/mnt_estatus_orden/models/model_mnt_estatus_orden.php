<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Model_mnt_estatus_orden extends CI_Model
{
	//constructor predeterminado del modelo
	function __construct()
	{
		parent::__construct();
	}
		
	
	public function insert_orden($data4='')
	{
		if(!empty($data4))

		{
			//die_pre($data4);
			$this->db->insert('mnt_estatus_orden',$data4);
			

		}
		return FALSE;
	}
}