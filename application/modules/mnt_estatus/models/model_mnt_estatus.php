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
    
    public function estatus_al_jefe_cuad() { // funcion para obtener los estatus para reportes del jefe de cuadrilla
        $estado = array(1,4,6);
        $this->db->where_not_in('id_estado', $estado);
        $estatus = $this->db->get('mnt_estatus');
        return $estatus->result();
    }
    
    public function get_estatus_id($id='') { // funcion para obtener el nombre del estatus dando el id
        if (!empty($id)) {
            $this->db->where('id_estado', $id);
            $query = $this->db->get('mnt_estatus')->result_array();
            return $query['0']['descripcion'];
        }
        return FALSE;
    }
    
    public function get_estatus_pendpers() { // funcion para cambiar opciones en select de estatatus cuando
    //el estatus sea pendiente por personal
        $estado = array('ABIERTA','ANULADA');
        $this->db->where_in('descripcion', $estado);
        $estatus = $this->db->get('mnt_estatus');
        return $estatus->result();       
    }

    public function get_estatus2() { // funcion que me permite no mostrar los estatus de abierta y en proceso en select de estatus
    	$estado = array('ABIERTA','EN PROCESO');
    	$this->db->where_not_in('descripcion', $estado);
    	$estatus = $this->db->get('mnt_estatus');
        return $estatus->result();
    }
    
    public function get_estatus3() { // funcion que me permite no mostrar los estatus de abierta y en anulada en select de estatus
    	$estado = array('ABIERTA','ANULADA');
    	$this->db->where_not_in('descripcion', $estado);
    	$estatus = $this->db->get('mnt_estatus');
        return $estatus->result_array();
    }
}