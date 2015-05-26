<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Model_dec_dependencia extends CI_Model {

    //constructor predeterminado del modelo
    function __construct() {
        parent::__construct();
    }

    public function get_dependencia() {
        $query = $this->db->get('dec_dependencia');
        return $query->result();
    }
    
    public function get_total_dep() {
        return($this->db->count_all('dec_dependencia'));
    }

    public function get_nombre_dependencia($id) {
        $dat = $this->conect($id);
        return ($dat['dependen']);
    }

    public function conect($id) {
        $this->db->where('id_dependencia', $id);
        $this->db->select('dependen');
        $query = $this->db->get('dec_dependencia');
        return $query->row_array();
    }
}
