<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Model_mnt_tipo_orden extends CI_Model
{
	//constructor predeterminado del modelo
	function __construct()
	{
		parent::__construct();
	}
		

		public function devuelve_tipo()
		
		{
			//die_pre('hola');
			$consulta= $this->db->query("SELECT id_tipo, tipo_orden FROM mnt_tipo_orden");
			return $consulta->result();
		}

		
			
}
		

	
	