<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Model_mnt_estatus extends CI_Model {

    //constructor predeterminado del modelo
    function __construct() {
        parent::__construct();
    }

    
    public function get_estatus() {
        $ver = $this->db->get('mnt_estatus');
        return $ver->result();
    }
    public function get_estatus2() {
    	$estado = array('ABIERTA','EN PROCESO');
    	$this->db->where_not_in('descripcion', $estado);
    	$estatus = $this->db->get('mnt_estatus');
        return $estatus->result();
    }
}