<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Model_mnt_ubicaciones_dep extends CI_Model {

    //constructor predeterminado del modelo
    function __construct() {
        parent::__construct();
    }

    
    public function get_ubicaciones() {
        $query = $this->db->get('mnt_ubicaciones_dep');
        return $query->result();
    }
    
    public function insert_orden($data3 = '') {
        if (!empty($data3)) {
            $this->db->insert('mnt_ubicaciones_dep', $data3);
            
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
