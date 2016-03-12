<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Rhh_ausentismo extends MX_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->module('dec_permiso/dec_permiso');
        //$this->load->model('model_rhh_ausentismo'); /*Para procesar los datos en la BD */
    }
    
    public function index()
    {
        $data["title"]='Control de Asistencia';
        //$header = $this->dec_permiso->load_permissionsView();
        /* Decidir que cabeceras usar */
        $this->load->view('rhh_asistencia/rhh_header', $data);
        $this->load->view('inicio');

        /* Decidir que footer usar */
        $this->load->view('rhh_asistencia/rhh_footer');
    }
}