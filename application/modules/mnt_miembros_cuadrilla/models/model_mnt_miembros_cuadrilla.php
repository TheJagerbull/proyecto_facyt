<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Model_mnt_miembros_cuadrilla extends CI_Model {

    //constructor predeterminado del modelo
    function __construct() {
        parent::__construct();
    }	
	
	
	//Aporte de Juan Parra

    public function get_miembros() {
        return $this->db->get('mnt_miembros_cuadrilla')->result();
    }



 }
