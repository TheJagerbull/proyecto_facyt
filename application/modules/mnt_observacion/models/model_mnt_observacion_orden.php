<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Model_mnt_observacion_orden extends CI_Model
{
	//constructor predeterminado del modelo
	function __construct()
	{
		parent::__construct();
	}
		
	
	public function insert_orden($data2='')
	{
		if(!empty($data2))
		{
			//die_pre($data2);
			$this->db->insert('mnt_observacion_orden',$data2);
			
		}
		return FALSE;
	}
	public function actualizar_orden($data = '', $id_orden = '')
	{
        if (!empty($data))
        {
            $this->db->where('id_orden_trabajo', $id_orden);
            $this->db->update('mnt_observacion_orden', $data);
        }
        return FALSE;
    }
	
        public function get_observacion ($id=''){
            $this->db->where('id_orden_trabajo',$id);
            $this->db->select('observac');
            $campo = $this->db->get('mnt_observacion_orden')->result_array();  
            return $campo[0]['observac'];   
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