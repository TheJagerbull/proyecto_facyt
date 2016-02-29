<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Model_mnt_tipo_orden extends CI_Model {

    //constructor predeterminado del modelo
    function __construct() {
        parent::__construct();
    }

    public function devuelve_tipo() { // funcion para obtener el tipo de solicitud
        //die_pre('hola');
        $consulta = $this->db->get('mnt_tipo_orden');
        return $consulta->result();
    }

    public function set_tipo_orden($data = '') { //funcion se usa para que tipo de solicitud sea igual al de la cuadrilla
        if (!empty($data)) { //verifica que no se haga una insercion vacia
            $this->db->insert('mnt_tipo_orden', $data); // $data es el nombre del tipo de solicitud
            return $this->db->insert_id();
        }
        return FALSE;
    }

}
