<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

Class Dec_permiso extends MX_Controller{
    
    function __construct() { //constructor predeterminado del controlador
        parent::__construct(); //carga los helpers
        $this->load->helper('array');
        $this->load->library('form_validation');
        $this->load->library('pagination');
        $this->load->model('user/model_dec_usuario', 'model_user');
        $this->load->model('model_dec_permiso', 'model_permisos');
    }
    
    
    
}


