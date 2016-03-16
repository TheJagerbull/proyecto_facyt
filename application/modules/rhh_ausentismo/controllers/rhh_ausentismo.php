<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Rhh_ausentismo extends MX_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->module('dec_permiso/dec_permiso');
        $this->load->model('model_rhh_ausentismo');
    }
    
    public function index()
    {
        $data["title"]='Ausentimos';
        //$header = $this->dec_permiso->load_permissionsView();
        /* Decidir que cabeceras usar */
        $this->load->view('rhh_asistencia/rhh_header', $data);
        $this->load->view('inicio');
        /* Decidir que footer usar */
        $this->load->view('rhh_asistencia/rhh_footer');
    }

    /* Devuelve los ausentismos agregados */
    public function ver(){
        $data = array('title' => 'Ausentimos Ver Todos');
        $ausentismos['ausentismos'] = $this->model_rhh_ausentismo->obtenerTodos();
        $this->load->view('rhh_asistencia/rhh_header', $data);
        $this->load->view('ver_todos', $ausentismos);
        $this->load->view('rhh_asistencia/rhh_footer');
    }

    /* Devuelve la vista para cargar una nueva configuración de ausentismo */
    public function configuracion()
    {
        $data["title"]='Ausentimos - Configuraciones';
        //$header = $this->dec_permiso->load_permissionsView();
        /* Decidir que cabeceras usar */
        $this->load->view('rhh_asistencia/rhh_header', $data);
        $this->load->view('configuracion_agregar');
        /* Decidir que footer usar */
        $this->load->view('rhh_asistencia/rhh_footer');
    }

    /* Maneja la petición de agregacion de una configuración de ausentismo */
    public function agregar_configuracion(){
        $data['title'] = 'Ausentimos - Configuraciones - Agregar';

        /*Obeteniendo los valores del formulario*/
        $tipo_ausentismo = strtoupper($this->input->post('tipo_ausentismo'));
        $nombre = $this->input->post('nombre');
        $min_dias = $this->input->post('min_dias');
        $max_dias = $this->input->post('max_dias');
        $max_mensual = $this->input->post('max_mensual');

        $ausentismo = array(
            'tipo' => $tipo_ausentismo,
            'nombre' => $nombre,
            'minimo_dias_permiso' => $min_dias,
            'maximo_dias_permiso' => $max_dias,
            'cantidad_maxima_mensual' => $max_mensual
        );

        /* Verificar que los valores del formulario no esten en blanco por servidor */
        if ($nombre == '' || $min_dias == '' || $max_dias == '' || $max_mensual == '') {
             $mensaje = "<div class='alert alert-danger text-center' role='alert'><i class='fa fa-exclamation fa-2x pull-left'></i> <b>Disculpe</b>, Parece que alguno(s) de los valores del formulario están en blanco, por favor verifiquelos.</div>";
            $this->load->view('rhh_asistencia/rhh_header', $data);
            $this->load->view('configuracion_agregar', array(
                'mensaje' => $mensaje,
                'form_data' => $ausentismo));
            $this->load->view('rhh_asistencia/rhh_footer');
        }else{
            /*Verficiar que el tipo no sea uno existente.*/
            if ($this->model_rhh_ausentismo->existe_configuracion_ausentismo($ausentismo)) {
                /*Ya hay un tipo de ausentismo con ese nombre*/
                $mensaje = "<div class='alert alert-danger text-center' role='alert'><i class='fa fa-exclamation fa-2x pull-left'></i>El ausentismo que ha indicado ya existe, por favor utilice otro nombre.</div>";
                $this->load->view('rhh_asistencia/rhh_header', $data);
                $this->load->view('configuracion_agregar', array(
                    'mensaje' => $mensaje,
                    'form_data' => $ausentismo));
                $this->load->view('rhh_asistencia/rhh_footer');
            }else{
                /*no existe el tipo de ausentismo con ese nombre*/
                $mensaje = "<div class='alert alert-success text-center' role='alert'><i class='fa fa-check fa-2x pull-left'></i>Se ha agregado el tipo de ausentismo de manera satisfactoria.<br></div>";
                $this->model_rhh_ausentismo->agregar_configuracion_ausentismo($ausentismo);
                $this->load->view('rhh_asistencia/rhh_header', $data);
                $this->load->view('configuracion_agregar', array(
                    'mensaje' => $mensaje
                ));
                $this->load->view('rhh_asistencia/rhh_footer');
            }
        }
    }
}