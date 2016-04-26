<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Rhh_periodo extends MX_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->library('form_validation');
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
        $data["title"] ='Periodos No Laborables';
        $periodos = $this->model_rhh_funciones->obtener_todos('rhh_periodo_no_laboral');
        $this->load->view('rhh_asistencia/rhh_header', $data);
        $this->load->view('index', array(
            'periodos' => $periodos ));
        $this->load->view('rhh_asistencia/rhh_footer');
    }

    /*Para poder insertar un nuevo elemento en la base de datos*/
    public function nuevo($periodo = null, $action = 'periodo-no-laboral/agregar')
    {
        $data["title"]='Control de Asistencia - Jornadas - Agregar';
        //$header = $this->dec_permiso->load_permissionsView();
        $this->load->view('rhh_asistencia/rhh_header', $data);
        $this->load->view('nuevo', array(
            'periodo' => $periodo,
            'action' => $action));
        $this->load->view('template/footer');
    }

    public function modificar($ID)
    {
        //obtener los datos del modelo
        $periodo = $this->model_rhh_periodo->obtener_periodo($ID);

        //Devolverlos a la vista
        if ($periodo == null) {
            $mensaje = "<div class='alert alert-danger text-center' role='alert'><i class='fa fa-exclamation fa-2x pull-left'></i>El periodo que intenta modificar no existe.</div>";
            $this->session->set_flashdata("mensaje", $mensaje);
            redirect('periodo');

        }else{
            foreach ($periodo as $key) {
                $data = array(
                    'ID' => $key->ID,
                    'nombre' => $key->nombre,
                    'descripcion' => $key->descripcion,
                    'fecha_inicio' => $key->fecha_inicio,
                    'fecha_fin' => $key->fecha_fin
                );
            }
            // retorna al formulario de agregar periodo los datos para ser modificados
            return $this->nuevo($data, 'periodo-no-laboral/actualizar');
        }
    }

    public function agregar()
    {
        $nombre = $this->input->post('nombre_periodo');
        $descripcion = $this->input->post('descripcion_periodo');
        $fecha_inicio = $this->input->post('fecha_inicio_periodo');
        $fecha_fin = $this->input->post('fecha_fin_periodo');

        $periodo_no_laboral = array(
            'nombre' => $nombre,
            'descripcion' => $descripcion,
            'fecha_inicio' => $fecha_inicio,
            'fecha_fin' => $fecha_fin
        );

        print_r($periodo_no_laboral);

        //Esta función recibe 'nombre_tabla' donde se guardaran los datos pasados por $jornada 
        if ($this->model_rhh_funciones->existe_como('rhh_periodo_no_laboral', 'nombre', $nombre, null)) {
            $mensaje = "<div class='alert alert-danger text-center' role='alert'><i class='fa fa-exclamation fa-2x pull-left'></i>Ya existe un periodo no laboral con el mismo nombre. Intente colocar otro.</div>";
        }else{
            $this->model_rhh_funciones->guardar('rhh_periodo_no_laboral', $periodo_no_laboral);
            $mensaje = "<div class='alert alert-success text-center' role='alert'><i class='fa fa-check fa-2x pull-left'></i>Se ha agregado el periodo no laboral de forma correcta.</div>";
        }
        $this->session->set_flashdata("mensaje", $mensaje);
        redirect('periodo-no-laboral');
    }

    public function actualizar()
    {
        $ID = $this->input->post('ID');
        $nombre = $this->input->post('nombre_periodo');
        $descripcion = $this->input->post('descripcion_periodo');
        $fecha_inicio = $this->input->post('fecha_inicio_periodo');
        $fecha_fin = $this->input->post('fecha_fin_periodo');

        $periodo = array(
            'ID' => $ID,
            'nombre' => $nombre,
            'descripcion' => $descripcion,
            'fecha_inicio' => $fecha_inicio,
            'fecha_fin' => $fecha_fin
        );

        $this->model_rhh_funciones->guardar('rhh_periodo_no_laboral', $periodo);

        $mensaje = "<div class='alert alert-success text-center' role='alert'><i class='fa fa-check fa-2x pull-left'></i>Se ha modificado el Periodo No Laboral de forma correcta.</div>";
        $this->session->set_flashdata("mensaje", $mensaje);
        redirect('periodo-no-laboral');
    }

    public function eliminar($ID)
    {
        if ($this->model_rhh_funciones->existe_como('rhh_periodo_no_laboral','ID',$ID, null)) {
            
            $this->model_rhh_funciones->eliminar('rhh_periodo_no_laboral', $ID);
            $mensaje = "<div class='alert alert-success text-center' role='alert'><i class='fa fa-check fa-2x pull-left'></i>Se ha eliminado el Periodo No Laboral de forma correcta.<br></div>";
        
        }else{
            $mensaje = "<div class='alert alert-danger text-center' role='alert'><i class='fa fa-exclamation fa-2x pull-left'></i>Al parecer el periodo que ha especificado no existe.</div>";
        }
        $this->session->set_flashdata("mensaje", $mensaje);
        redirect('periodo-no-laboral');
    }

}