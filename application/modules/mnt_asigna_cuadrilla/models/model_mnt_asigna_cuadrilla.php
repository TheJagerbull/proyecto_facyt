<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Model_mnt_asigna_cuadrilla extends CI_Model
{
	//constructor predeterminado del modelo
	function __construct()
	{
		parent::__construct();
	}
		

		public function get_allasigna()
		
		{
			//die_pre('hola');
			return $this->db->get('mnt_asigna_cuadrilla')->result();
		}

		
			
}
		

	
	