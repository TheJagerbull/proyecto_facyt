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

    
    //Esta funcion se una para construir el json para el llenado del datatable en la vista de permisos
    function list_sol($est='') {
        $results = $this->model_permisos->get_list();//Va al modelo para tomar los datos para llenar el datatable
        echo json_encode($results); //genera la salida de datos
    }
    
    public function load_vista() {
        $header['title'] = 'Asignación de Permisologia de Usuarios';
        $this->load->view('template/header', $header);
        $this->load->view('dec_permiso/view_dec_permiso');
        $this->load->view('template/footer');
    }
    
    
}


