<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Model_mnt_cuadrilla extends CI_Model {

    //constructor predeterminado del modelo
    function __construct() {
        parent::__construct();
    }

    public function get_cuadrillas() {
        return $this->db->get('mnt_cuadrilla')->result();
    }

    public function get_nombre_cuadrilla($id) {
        $dat = $this->conect($id);
        return ($dat['cuadrilla']);
    }

    public function conect($id) {
        $this->db->where('id', $id);
        $this->db->select('cuadrilla');
        $query = $this->db->get('mnt_cuadrilla');
        return $query->row_array();
    }

}
