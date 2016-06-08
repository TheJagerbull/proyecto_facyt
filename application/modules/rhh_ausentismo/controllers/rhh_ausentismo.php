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
    
    /* Muestra todos los tipos de ausentismos agregados en la configuracion */
    public function index()
    {
        $data["title"] ='Ausentimos';
        $ausentismos = $this->model_rhh_ausentismo->obtenerTodos();
        $this->load->view('template/header', $data);
        $this->load->view('ver_todos', array(
            'ausentismos' => $ausentismos ));
        $this->load->view('template/footer');
    }

    /* Devuelve la vista para cargar una nueva configuración de ausentismo */
    public function configuracion_nueva()
    {
        // CUANDO ESTOY OBTENIENDO UN ERROR DEL CONTROLADOR Y QUIERO USAR EL FLASHDATA PARA PASAR EL MENSAJE
        $ausentismo = $this->session->flashdata('ausentismo');

        $data["title"]='Ausentimos - Configuraciones';
        $header = $this->dec_permiso->load_permissionsView();
        $this->load->view('template/header', $data);
        $this->load->view('configuracion_agregar', array(
            'form_data' => $ausentismo));
        $this->load->view('template/footer');
    }

     // MANEJA LA PETICIÓN DE AGREGACION DE UNA CONFIGURACIÓN DE AUSENTISMO 
    public function configuracion_verificar()
    {
        $data['title'] = 'Ausentimos - Configuraciones - Agregar';

        // OBTENIENDO LOS VALORES DEL FORMULARIO
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

        if (strlen($nombre) < 3 || $nombre == ' ') {
            $mensaje = "<div class='alert alert-danger well-sm' role='alert'><i class='fa fa-exclamation fa-2x pull-left'></i> <b>Disculpe</b>, el nombre del nuevo ausentismo no puede tener tan pocos caracteres o estar en blanco.</div>";
            $this->session->set_flashdata("mensaje", $mensaje);

            $this->session->set_flashdata("ausentismo", $ausentismo);
            redirect('ausentismo/configuracion/nueva', $ausentismo);
        }

        // VERIFICAR QUE LOS VALORES DEL FORMULARIO NO ESTEN EN BLANCO
        if ($nombre == '' || $min_dias == '' || $max_dias == '' || $max_mensual == '') {
            $mensaje = "<div class='alert alert-danger well-sm' role='alert'><i class='fa fa-exclamation fa-2x pull-left'></i> <b>Disculpe</b>, Parece que alguno(s) de los valores del formulario están en blanco, por favor completelos.</div>";
            $this->session->set_flashdata("mensaje", $mensaje);
            
            $this->session->set_flashdata("ausentismo", $ausentismo);
            redirect('ausentismo/configuracion/nueva', $ausentismo);
        }

        if ($min_dias <= 0 || $max_dias <= 0 || $max_mensual <= 0) {
            $mensaje = "<div class='alert alert-danger well-sm' role='alert'><i class='fa fa-exclamation fa-2x pull-left'></i>Los días o cantidad por mes no pueden ser negativas o menores iguales a 0.</div>";
            $this->session->set_flashdata("mensaje", $mensaje);
            
            $this->session->set_flashdata("ausentismo", $ausentismo);
            redirect('ausentismo/configuracion/nueva', $ausentismo);
        }
        
        if ($min_dias > $max_dias) {
            $mensaje = "<div class='alert alert-danger well-sm' role='alert'><i class='fa fa-exclamation fa-2x pull-left'></i>La cantidad de <b>Días Máximos</b> debe ser mayor que la Cantidad de <b>Días Mínimos</b></div>";
            $this->session->set_flashdata("mensaje", $mensaje);
            
            $this->session->set_flashdata("ausentismo", $ausentismo);
            redirect('ausentismo/configuracion/nueva', $ausentismo);
        }

        // VERFICIAR QUE EL TIPO NO SEA UNO EXISTENTE.
        if ($this->model_rhh_ausentismo->existe_configuracion_ausentismo($ausentismo)) {
            // YA HAY UN TIPO DE AUSENTISMO CON ESE NOMBRE
            $mensaje = "<div class='alert alert-danger well-sm' role='alert'><i class='fa fa-exclamation fa-2x pull-left'></i>El ausentismo que ha indicado ya existe, por favor utilice otro nombre.</div>";
            $this->session->set_flashdata("mensaje", $mensaje);

            $this->session->set_flashdata("ausentismo", $ausentismo);
            redirect('ausentismo/configuracion/nueva', $ausentismo);

        }else{
            // NO EXISTE EL TIPO DE AUSENTISMO CON ESE NOMBRE
            $mensaje = "<div class='alert alert-success well-sm' role='alert'><i class='fa fa-check fa-2x pull-left'></i>Se ha agregado el tipo de ausentismo de manera satisfactoria.<br></div>";
            $this->session->set_flashdata("mensaje", $mensaje);
            
            // ALMACENAR EN LA BASE DE DATOS EL AUSENTISMO 
            $this->model_rhh_ausentismo->agregar_configuracion_ausentismo($ausentismo);
            redirect('ausentismo');
        }
    }

    /* Maneja las cantidades de configuraciones */
    public function configuracion_editar($ID)
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
        $this->load->view('template/header', $data);
        $this->load->view('configuracion_modificar', array(
            'form_data' => $ausentismo));
        $this->load->view('template/footer');
    }

    /* Actualiza una configuración */
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

        if (strlen($nombre) < 3 || $nombre == ' ') {
            $mensaje = "<div class='alert alert-danger well-sm' role='alert'><i class='fa fa-exclamation fa-2x pull-left'></i> <b>Disculpe</b>, el nombre del nuevo ausentismo no puede tener tan pocos caracteres o estar en blanco.</div>";
            $this->session->set_flashdata("mensaje", $mensaje);

            // $this->session->set_flashdata("ausentismo", $ausentismo);
            redirect('ausentismo/configuracion/modificar/'.$ID);
        }

        // VERIFICAR QUE LOS VALORES DEL FORMULARIO NO ESTEN EN BLANCO
        if ($nombre == '' || $min_dias == '' || $max_dias == '' || $max_mensual == '') {
            $mensaje = "<div class='alert alert-danger well-sm' role='alert'><i class='fa fa-exclamation fa-2x pull-left'></i> <b>Disculpe</b>, Parece que alguno(s) de los valores del formulario están en blanco, por favor completelos.</div>";
            $this->session->set_flashdata("mensaje", $mensaje);
            
            // $this->session->set_flashdata("ausentismo", $ausentismo);
            redirect('ausentismo/configuracion/modificar/'.$ID);
        }

        if ($min_dias <= 0 || $max_dias <= 0 || $max_mensual <= 0) {
            $mensaje = "<div class='alert alert-danger well-sm' role='alert'><i class='fa fa-exclamation fa-2x pull-left'></i>Los días o cantidad por mes no pueden ser negativas o menores iguales a 0.</div>";
            $this->session->set_flashdata("mensaje", $mensaje);
            
            // $this->session->set_flashdata("ausentismo", $ausentismo);
            redirect('ausentismo/configuracion/modificar/'.$ID);
        }
        
        if ($min_dias > $max_dias) {
            $mensaje = "<div class='alert alert-danger well-sm' role='alert'><i class='fa fa-exclamation fa-2x pull-left'></i>La cantidad de <b>Días Máximos</b> debe ser mayor que la Cantidad de <b>Días Mínimos</b></div>";
            $this->session->set_flashdata("mensaje", $mensaje);
            
            // $this->session->set_flashdata("ausentismo", $ausentismo);
            redirect('ausentismo/configuracion/modificar/'.$ID);
        }

        if ($min_dias <= 0 || $max_dias <= 0 || $max_mensual <= 0) {
            $mensaje = "<div class='alert alert-danger well-sm' role='alert'><i class='fa fa-exclamation fa-2x pull-left'></i> <b>Disculpe</b>, Parece que alguno(s) de los valores del formulario son menores o iguales a cero.</div>";
            $this->load->view('template/header', $data);
            $this->load->view('configuracion_modificar', array(
                'form_data' => $ausentismo));
            $this->load->view('template/footer');
        }
        
        $this->model_rhh_ausentismo->actualizar_configuracion_ausentismo($ausentismo);
        $mensaje = "<div class='alert alert-success well-sm' role='alert'><i class='fa fa-check fa-2x pull-left'></i>Se ha modificado el tipo de ausentismo de manera satisfactoria.<br></div>";
        $this->session->set_flashdata('mensaje', $mensaje);
        redirect('ausentismo');
    }

    /* Elimina una configuración */
    public function eliminar_configuracion($ID)
    {
        if (sizeof($this->model_rhh_ausentismo->obtenerUno($ID)) > 0) {
            $this->model_rhh_ausentismo->eliminar($ID);
            $mensaje = "<div class='alert alert-success well-sm' role='alert'><i class='fa fa-check fa-2x pull-left'></i>Se ha eliminado la configuración de manera éxitosa.<br></div>";
        }else{
            $mensaje = "<div class='alert alert-danger well-sm' role='alert'><i class='fa fa-exclamation fa-2x pull-left'></i>Se ha producido un error al eliminar la configuración</div>";
        }
        $this->session->set_flashdata("mensaje", $mensaje);
        redirect('ausentismo');
    }

    /**********************************************/
    /******** PARA SOLICITAR UN AUSENTISMO ********/
    /**********************************************/

    /* Formulario para solicitar un ausentismo */
    public function solicitar_nuevo()
    {
        $data["title"]='Ausentimos - Configuraciones';
        $header = $this->dec_permiso->load_permissionsView();
        $this->load->view('template/header', $data);
        $this->load->view('solicitar_nuevo');
        $this->load->view('template/footer');
    }

    /* es para el ajax de obtener los tipos de ausentismos cuando el usuario está agregando un ausentismo nuevo */
    public function obtener_tipos()
    {
        $formulario = $this->input->post();
        $result = $this->model_rhh_ausentismo->get_ausentimos_by_tipo($formulario['tipo']);
        header('Content-Type: application/json');
        echo json_encode($result);
    }

    public function solicitar_nuevo_agregar()
    {
        $formulario = $this->input->post();
        echo_pre($formulario);
    }
}