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
        $header["title"] ='Períodos';
        $periodos = $this->model_rhh_funciones->obtener_todos('rhh_periodo');
        $this->load->view('template/header', $header);
        $this->load->view('index', array(
            'periodos' => $periodos ));
        $this->load->view('template/footer');
    }

    /*Para poder insertar un nuevo elemento en la base de datos*/
    public function nuevo($periodo = null, $action = 'periodo/agregar')
    {
        if($this->session->userdata('user') == NULL){ redirect('error_acceso'); }
        $header = $this->dec_permiso->load_permissionsView();
        $header["title"]='Control de Asistencia - Período Nuevo';

        $this->load->view('template/header', $header);
        $this->load->view('nuevo', array(
            'periodo' => $periodo,
            'action' => $action));
        $this->load->view('template/footer');
    }

    public function modificar($ID)
    {
        if($this->session->userdata('user') == NULL){ redirect('error_acceso'); }

        //obtener los datos del modelo
        $periodo = $this->model_rhh_funciones->obtener_uno('rhh_periodo', $ID);

        //Devolverlos a la vista
        if ($periodo == null) {
            $mensaje = "<div class='alert alert-danger well-sm' role='alert'><i class='fa fa-exclamation fa-2x pull-left'></i>El periodo que intenta modificar no existe.</div>";
            $this->session->set_flashdata("mensaje", $mensaje);
            redirect('periodo');

        }else{
            foreach ($periodo as $key) {
                $data = array(
                    'ID' => $key->ID,
                    'nombre' => $key->nombre,
                    'descripcion' => $key->descripcion,
                    'cant_dias' => $key->cant_dias,
                    'fecha_inicio' => $key->fecha_inicio,
                    'fecha_fin' => $key->fecha_fin
                );
            }
            // retorna al formulario de agregar periodo los datos para ser modificados
            return $this->nuevo($data, 'periodo/actualizar');
        }
    }

    public function agregar()
    {
        if($this->session->userdata('user') == NULL){ redirect('error_acceso'); }

        $nombre = $this->input->post('nombre_periodo');
        $descripcion = $this->input->post('descripcion_periodo');
        $cant_dias = $this->input->post('cant_dias_periodo');
        $fecha_inicio = $this->input->post('fecha_inicio_periodo');
        $fecha_fin = $this->input->post('fecha_fin_periodo');

        $periodo_no_laboral = array(
            'nombre' => $nombre,
            'descripcion' => $descripcion,
            'cant_dias' => $cant_dias,
            'fecha_inicio' => $fecha_inicio,
            'fecha_fin' => $fecha_fin
        );

        //Esta función recibe 'nombre_tabla' donde se guardaran los datos pasados por $jornada 
        if ($this->model_rhh_funciones->existe_como('rhh_periodo', 'nombre', $nombre, null)) {
            $mensaje = "<div class='alert alert-danger well-sm' role='alert'><i class='fa fa-exclamation fa-2x pull-left'></i>Ya existe un periodo con el mismo nombre. Intente colocar otro.</div>";
        }else{
            $this->model_rhh_funciones->guardar('rhh_periodo', $periodo_no_laboral);
            $mensaje = "<div class='alert alert-success well-sm' role='alert'><i class='fa fa-check fa-2x pull-left'></i>Se ha agregado el periodo de forma correcta.</div>";
        }
        $this->session->set_flashdata("mensaje", $mensaje);
        redirect('periodo');
    }

    public function actualizar()
    {
        if($this->session->userdata('user') == NULL){ redirect('error_acceso'); }

        $ID = $this->input->post('ID');
        $nombre = $this->input->post('nombre_periodo');
        $descripcion = $this->input->post('descripcion_periodo');
        $cant_dias = $this->input->post('cant_dias_periodo');
        $fecha_inicio = $this->input->post('fecha_inicio_periodo');
        $fecha_fin = $this->input->post('fecha_fin_periodo');

        $periodo = array(
            'ID' => $ID,
            'nombre' => $nombre,
            'descripcion' => $descripcion,
            'cant_dias' => $cant_dias,
            'fecha_inicio' => $fecha_inicio,
            'fecha_fin' => $fecha_fin
        );

        $this->model_rhh_funciones->guardar('rhh_periodo', $periodo);

        $mensaje = "<div class='alert alert-success well-sm' role='alert'><i class='fa fa-check fa-2x pull-left'></i>Se ha modificado el Período de forma correcta.</div>";
        $this->session->set_flashdata("mensaje", $mensaje);
        redirect('periodo');
    }

    public function eliminar($ID)
    {
        if($this->session->userdata('user') == NULL){ redirect('error_acceso'); }
        if ($this->model_rhh_funciones->existe_como('rhh_periodo','ID',$ID, null)) {
            $periodo = $this->model_rhh_funciones->obtener_uno('rhh_periodo', $ID);
            $mensaje = "<div class='alert alert-success well-sm' role='alert'><i class='fa fa-check fa-2x pull-left'></i>Se ha eliminado el Período: <span class='negritas'>".$periodo[0]->nombre."</span>, de forma correcta.<br></div>";
            $this->model_rhh_funciones->eliminar('rhh_periodo', $ID);
        }else{
            $mensaje = "<div class='alert alert-danger well-sm' role='alert'><i class='fa fa-exclamation fa-2x pull-left'></i>Al parecer el periodo que ha especificado no existe.</div>";
        }
        $this->session->set_flashdata("mensaje", $mensaje);
        redirect('periodo');
    }

    public function duplicar($ID)
    {
        if($this->session->userdata('user') == NULL){ redirect('error_acceso'); }
        $periodo_global = $this->model_rhh_funciones->obtener_uno('rhh_periodo', $ID);
        // header('Content-Type: text/html; charset=utf-8');
        // echo_pre($periodo_global);
        // echo "Posteriormente obtener todos los elementos que estan asociados a este perido que se quiere duplicar.<br>";

        $periodos_asociados = $this->model_rhh_periodo->obtener_periodos_asociados($ID);
        if (sizeof($periodos_asociados) == 0) {
            $mensaje = "<div class='alert alert-warning well-sm' role='alert'><i class='fa fa-exclamation fa-2x pull-left'></i>El Período Global elegido no tiene ningun Período No Laboral asociado.</div>";
            $this->session->set_flashdata("mensaje", $mensaje);
            redirect('periodo');
        }else{
            $header = $this->dec_permiso->load_permissionsView();
            $header["title"]='Control de Asistencia - Período Duplicar';

            $this->load->view('template/header', $header);
            $this->load->view('duplicar_modificar', array(
                'periodo_global' => $periodo_global,
                'periodos' => $periodos_asociados));
            $this->load->view('template/footer');
            
        }
    }
}