<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Rhh_nota extends MX_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->module('dec_permiso/dec_permiso');
        $this->load->model('model_rhh_nota'); /*Para procesar los datos en la BD */
        /* Incluyo otro modelo para usuar funciones que están "sobrecargadas"? y son comunes en todos los modulos de rhh
            - public function guardar($tabla, $data)
            - public function eliminar($tabla, $ID)
            - public function existe_como($tabla, $columna, $id, $este)
        */
        $this->load->model('model_rhh_funciones');
    }
    
    /* Carga elementos para efectos demostrativos */
    public function index()
    {
        $data["title"] ='Notas de Retraso';
        $notas = $this->model_rhh_nota->obtener_todas_notas('rhh_nota');
        $this->load->view('template/header', $data);
        $this->load->view('index', array(
            'notas' => $notas ));
        $this->load->view('template/footer');
    }

    public function modificar($idnota)
    {
        return $idnota;
    }

    public function eliminar($idnota)
    {
        return $idnota;
    }
}