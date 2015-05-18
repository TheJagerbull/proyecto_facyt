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

   
}
