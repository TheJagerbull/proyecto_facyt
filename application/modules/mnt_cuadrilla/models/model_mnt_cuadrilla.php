<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Model_mnt_cuadrilla extends CI_Model
{
	//constructor predeterminado del modelo
	function __construct()
	{
		parent::__construct();
	}
		

		public function get_cuadrillas()
		
		{
			//die_pre('hola');
			return $this->db->get('mnt_cuadrilla')->result();
		}
                
                public function get_nombre_cuadrilla($id){
//                    $this->db->where('id' == '1');
//                    
//                    
//                    return $this->db->get('mnt_cuadrilla');
                    
                    
                }

		
			
}
		

	
	