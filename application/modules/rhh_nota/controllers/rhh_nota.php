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

    public function actualizar()
    {
        $nota_id = $this->input->post('nota_id');
        $nota_cuerpo = $this->input->post('nota_cuerpo');
        $nota = array(
            'ID' => $nota_id,
            'cuerpo_nota' => $nota_cuerpo);
        $this->model_rhh_funciones->guardar('rhh_nota', $nota);

        $mensaje = "<div class='alert alert-success text-center' role='alert'><i class='fa fa-check fa-2x pull-left'></i>Se ha modificado exitosamente la nota de retraso.</div>";
            $this->session->set_flashdata("mensaje", $mensaje);
        redirect('nota');
    }

    public function eliminar($idnota)
    {
        $this->model_rhh_funciones->eliminar('rhh_nota', $idnota);
        $mensaje = "<div class='alert alert-success text-center' role='alert'><i class='fa fa-check fa-2x pull-left'></i>Se eliminó con éxito la nota.</div>";
        $this->session->set_flashdata("mensaje", $mensaje);
        redirect('nota');
    }
}