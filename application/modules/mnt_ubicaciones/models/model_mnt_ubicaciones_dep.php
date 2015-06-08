<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Model_mnt_ubicaciones_dep extends CI_Model {

    //constructor predeterminado del modelo
    function __construct() {
        parent::__construct();
    }

    
    public function get_ubicaciones() 
    {
        $query = $this->db->get('mnt_ubicaciones_dep');
        return $query->result();
    }
    
    public function get_ubicaciones_dependencia($dependen) 
    {    
        $this->db->where('id_dependencia',$dependen);
	    $this->db->order_by('oficina','asc');
	    $oficina = $this->db->get('mnt_ubicaciones_dep');
	    if($oficina->num_rows()>0)
	   {
	       return $oficina->result();
	   }
	
    }
    public function get_oficina_null() 
    {   
        $where="oficina='N/A'";
        $this->db->where($where);
        $oficina = $this->db->get('mnt_ubicaciones_dep');
        if($oficina->num_rows()>0)
       {
           return $oficina->result();
       }
        
    }
    
    public function get_total_ubica() {
        return($this->db->count_all('mnt_ubicaciones_dep'));
    }

    

    public function insert_orden($data3 = '')
    {
        //die_pre($data3);
        if (!empty($data3))
        {
            $this->db->insert('mnt_ubicaciones_dep', $data3);
            return $this->db->insert_id();
            
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
