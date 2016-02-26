<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Model_mnt_estatus extends CI_Model {

    //constructor predeterminado del modelo
    function __construct() {
        parent::__construct();
    }

    
    public function get_estatus() { // funcion para obtener todos los estatus
        $ver = $this->db->get('mnt_estatus');
        return $ver->result();
    }
    public function get_estatus2() { // funcion que me permite no mostrar los estatus de abierta y en proceso en select de estatus
    	$estado = array('ABIERTA','EN PROCESO');
    	$this->db->where_not_in('descripcion', $estado);
    	$estatus = $this->db->get('mnt_estatus');
        return $estatus->result();
    }
}