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
        $data["title"] ='Ausentimos';
        $ausentismos = $this->model_rhh_ausentismo->obtenerTodos();
        $this->load->view('rhh_asistencia/rhh_header', $data);
        $this->load->view('ver_todos', array(
            'ausentismos' => $ausentismos ));
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
    public function agregar_configuracion()
    {
        $data['title'] = 'Ausentimos - Configuraciones - Agregar';

        /*Obteniendo los valores del formulario*/
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

        if ($min_dias <= 0 && max_dias <= 0 && $max_mensual <= 0) {
            $mensaje = "<div class='alert alert-danger text-center' role='alert'><i class='fa fa-exclamation fa-2x pull-left'></i> <b>Disculpe</b>, Parece que alguno(s) de los valores del formulario son menores o iguales a cero.</div>";
            $this->session->set_flashdata("mensaje", $mensaje);

            $this->load->view('rhh_asistencia/rhh_header', $data);
            $this->load->view('configuracion_agregar', array(
                'form_data' => $ausentismo));
            $this->load->view('rhh_asistencia/rhh_footer');
        }

        /* Verificar que los valores del formulario no esten en blanco por servidor */
        if ($nombre == '' || $min_dias == '' || $max_dias == '' || $max_mensual == '') {
             $mensaje = "<div class='alert alert-danger text-center' role='alert'><i class='fa fa-exclamation fa-2x pull-left'></i> <b>Disculpe</b>, Parece que alguno(s) de los valores del formulario están en blanco, por favor verifiquelos.</div>";
             $this->session->set_flashdata("mensaje", $mensaje);
            $this->load->view('rhh_asistencia/rhh_header', $data);
            $this->load->view('configuracion_agregar', array(
                'form_data' => $ausentismo));
            $this->load->view('rhh_asistencia/rhh_footer');
        }else{
            if ($min_dias <= 0 || $max_dias <= 0 || $max_mensual <= 0) {
                $mensaje = "<div class='alert alert-danger text-center' role='alert'><i class='fa fa-exclamation fa-2x pull-left'></i><b>Perdón</b>, debe especificar un nombre a la configuración</div>";
                $this->session->set_flashdata("mensaje", $mensaje);
                $this->load->view('rhh_asistencia/rhh_header', $data);
                $this->load->view('configuracion_agregar', array(
                    'form_data' => $ausentismo));
                $this->load->view('rhh_asistencia/rhh_footer');
            }else{
                if ($min_dias > $max_dias) {
                    $mensaje = "<div class='alert alert-danger text-center' role='alert'><i class='fa fa-exclamation fa-2x pull-left'></i>La Cantidad de Días Max debe ser mayor que la Cantidad de días Mínimos</div>";
                    $this->session->set_flashdata("mensaje", $mensaje);
                    $this->load->view('rhh_asistencia/rhh_header', $data);
                    $this->load->view('configuracion_agregar', array(
                        'form_data' => $ausentismo));
                    $this->load->view('rhh_asistencia/rhh_footer');
                }else{
                    /*Verficiar que el tipo no sea uno existente.*/
                    if ($this->model_rhh_ausentismo->existe_configuracion_ausentismo($ausentismo)) {
                        /*Ya hay un tipo de ausentismo con ese nombre*/
                        $mensaje = "<div class='alert alert-danger text-center' role='alert'><i class='fa fa-exclamation fa-2x pull-left'></i>El ausentismo que ha indicado ya existe, por favor utilice otro nombre.</div>";
                        $this->session->set_flashdata("mensaje", $mensaje);
                        $this->load->view('rhh_asistencia/rhh_header', $data);
                        $this->load->view('configuracion_agregar', array(
                            'form_data' => $ausentismo));
                        $this->load->view('rhh_asistencia/rhh_footer');
                    }else{
                        /*no existe el tipo de ausentismo con ese nombre*/
                        $mensaje = "<div class='alert alert-success text-center' role='alert'><i class='fa fa-check fa-2x pull-left'></i>Se ha agregado el tipo de ausentismo de manera satisfactoria.<br></div>";
                        $this->session->set_flashdata("mensaje", $mensaje);
                        $this->model_rhh_ausentismo->agregar_configuracion_ausentismo($ausentismo);
                        $ausentismos = $this->model_rhh_ausentismo->obtenerTodos();
                        $this->load->view('rhh_asistencia/rhh_header', $data);
                        $this->load->view('ver_todos', array(
                            'ausentismos' => $ausentismos
                        ));
                        $this->load->view('rhh_asistencia/rhh_footer');
                    }
                }
            }
        }
    }

    public function editar_configuracion($ID)
    {
        $conf = $this->model_rhh_ausentismo->obtenerUno($ID);
        foreach ($conf as $key) {
                $ausentismo = array(
                'ID' => $ID,
                'tipo' => $key->tipo,
                'nombre' => $key->nombre,
                'minimo_dias_permiso' => $key->minimo_dias_permiso,
                'maximo_dias_permiso' => $key->maximo_dias_permiso,
                'cantidad_maxima_mensual' => $key->cantidad_maxima_mensual
            );
        }

        $data["title"]='Ausentimos - Configuraciones';
        $this->load->view('rhh_asistencia/rhh_header', $data);
        $this->load->view('configuracion_modificar', array(
            'form_data' => $ausentismo));
        $this->load->view('rhh_asistencia/rhh_footer');
    }

    public function guardar_modificacion($ID)
    {
        $data["title"]='Ausentimos - Configuraciones';
        /*Obeteniendo los valores del formulario*/
        $tipo_ausentismo = strtoupper($this->input->post('tipo_ausentismo'));
        $nombre = $this->input->post('nombre');
        $min_dias = $this->input->post('min_dias');
        $max_dias = $this->input->post('max_dias');
        $max_mensual = $this->input->post('max_mensual');

        $ausentismo = array(
            'ID' => $ID,
            'tipo' => $tipo_ausentismo,
            'nombre' => $nombre,
            'minimo_dias_permiso' => $min_dias,
            'maximo_dias_permiso' => $max_dias,
            'cantidad_maxima_mensual' => $max_mensual
        );

        if ($nombre == '') {

            $mensaje = "<div class='alert alert-danger text-center' role='alert'><i class='fa fa-exclamation fa-2x pull-left'></i><b>Perdón</b>, debe especificar un nombre a la configuración</div>";
            $this->session->set_flashdata("mensaje", $mensaje);

            $this->load->view('rhh_asistencia/rhh_header', $data);
            $this->load->view('configuracion_modificar', array(
                'form_data' => $ausentismo));
            $this->load->view('rhh_asistencia/rhh_footer');

        }else{

            if ($min_dias > $max_dias) {

                $mensaje = "<div class='alert alert-danger text-center' role='alert'><i class='fa fa-exclamation fa-2x pull-left'></i>La Cantidad de Días Max debe ser mayor que la Cantidad de días Mínimos</div>";
                $this->session->set_flashdata("mensaje", $mensaje);

                $this->load->view('rhh_asistencia/rhh_header', $data);
                $this->load->view('configuracion_modificar', array(
                    'form_data' => $ausentismo));
                $this->load->view('rhh_asistencia/rhh_footer');

            }else{
                if ($min_dias <= 0 || $max_dias <= 0 || $max_mensual <= 0) {

                    $mensaje = "<div class='alert alert-danger text-center' role='alert'><i class='fa fa-exclamation fa-2x pull-left'></i> <b>Disculpe</b>, Parece que alguno(s) de los valores del formulario son menores o iguales a cero.</div>";
                    $this->load->view('rhh_asistencia/rhh_header', $data);
                    $this->load->view('configuracion_modificar', array(
                        'form_data' => $ausentismo,
                        'mensaje' => $mensaje));
                    $this->load->view('rhh_asistencia/rhh_footer');
                }

                $this->model_rhh_ausentismo->actualizar_configuracion_ausentismo($ausentismo);
                $mensaje = "<div class='alert alert-success text-center' role='alert'><i class='fa fa-check fa-2x pull-left'></i>Se ha modificado el tipo de ausentismo de manera satisfactoria.<br></div>";
                    $this->index($mensaje);
            }    
        }
    }

    public function eliminar_configuracion($ID)
    {
        $data['titulo'] = "Ausentismo - Configuraciones";
        $ausentismos = $this->model_rhh_ausentismo->obtenerTodos();

        if (sizeof($this->model_rhh_ausentismo->obtenerUno($ID)) > 0) {
            $this->model_rhh_ausentismo->eliminar($ID);
            $mensaje = "<div class='alert alert-success text-center' role='alert'><i class='fa fa-check fa-2x pull-left'></i>Se ha eliminado la configuración de manera éxitosa.<br></div>";
        }else{
            $mensaje = "<div class='alert alert-danger text-center' role='alert'><i class='fa fa-exclamation fa-2x pull-left'></i>Se ha producido un error al eliminar la configuración</div>";
        }
        $this->session->set_flashdata("mensaje", $mensaje);
        redirect('ausentismo');
    }
}