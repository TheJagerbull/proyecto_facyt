<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Model_mnt_tipo_orden extends CI_Model {

    //constructor predeterminado del modelo
    function __construct() {
        parent::__construct();
    }

    public function devuelve_tipo() {
        //die_pre('hola');
        $consulta = $this->db->get('mnt_tipo_orden');
        return $consulta->result();
    }

    public function set_tipo_orden($data = '') {
        if (!empty($data)) { //verifica que no se haga una insercion vacia
            $this->db->insert('mnt_tipo_orden', $data);
            return $this->db->insert_id();
        }
        return FALSE;
    }

}
