<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Rhh_periodo extends MX_Controller
{
	public function __construct()
    {
        parent::__construct();
        // $this->load->library('form_validation');
        $this->load->module('dec_permiso/dec_permiso');
        $this->load->model('model_rhh_periodo'); /*Para procesar los datos en la BD */
        /* Incluyo otro modelo para usuar funciones que están "sobrecargadas"? y son comunes en todos los modulos de rhh
            - public function guardar($tabla, $data)
            - public function eliminar($tabla, $ID)
            - public function existe_como($tabla, $columna, $id, $este)
        */
        $this->load->model('model_rhh_funciones');
    }

    /* Pasa elementos a la tabla */
    public function index()
    {
        if($this->session->userdata('user') == NULL){ redirect('error_acceso'); }
        $header = $this->dec_permiso->load_permissionsView();
        $header["title"] ='Periodos';
        $periodos = $this->model_rhh_funciones->obtener_todos('rhh_periodo');
        $this->load->view('template/header', $header);
        $this->load->view('index', array(
            'periodos' => $periodos ));
        $this->load->view('template/footer');
    }
}