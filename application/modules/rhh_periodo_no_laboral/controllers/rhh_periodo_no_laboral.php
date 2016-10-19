<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Rhh_periodo_no_laboral extends MX_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->module('dec_permiso/dec_permiso');
        $this->load->model('model_rhh_periodo_no_laboral'); /*Para procesar los datos en la BD */
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
        is_user_logged($this->session->userdata('user'));
        $header = $this->dec_permiso->load_permissionsView();
        $header["title"] ='Periodos No Laborables';

        $periodos = $this->model_rhh_periodo_no_laboral->obtener_periodos_no_laborales();
        $periodos_globales = $this->model_rhh_funciones->obtener_todos('rhh_periodo');

        $this->load->view('template/header', $header);
        $this->load->view('index', array(
            'periodos' => $periodos,
            'periodos_globales' => $periodos_globales ));
        $this->load->view('template/footer');
    }

    /*Para poder insertar un nuevo elemento en la base de datos*/
    public function nuevo($periodo = null, $action = 'periodo-no-laboral/agregar')
    {
        is_user_logged($this->session->userdata('user'));
        $header = $this->dec_permiso->load_permissionsView();
        $header["title"]='Control de Asistencia - Periodos No Laboral Nuevo';

        $this->load->view('template/header', $header);
        $this->load->view('nuevo', array(
            'periodo' => $periodo,
            'action' => $action));
        $this->load->view('template/footer');
    }

    public function modificar($ID)
    {
        is_user_logged($this->session->userdata('user'));

        //obtener los datos del modelo
        $periodo = $this->model_rhh_funciones->obtener_uno('rhh_periodo_no_laboral', $ID);

        //Devolverlos a la vista
        if ($periodo == null) {
            set_message('danger','El periodo que intenta modificar no existe');
            redirect('periodo');

        }else{
            // retorna al formulario de agregar periodo los datos para ser modificados
            return $this->nuevo($periodo, 'periodo-no-laboral/actualizar');
        }
    }

    public function agregar()
    {
        is_user_logged($this->session->userdata('user'));
        $nombre = $this->input->post('nombre_periodo');
        $descripcion = $this->input->post('descripcion_periodo');
        $cant_dias = $this->input->post('cant_dias_periodo');
        $fecha_inicio = $this->input->post('fecha_inicio_periodo');
        $fecha_fin = $this->input->post('fecha_fin_periodo');
        $periodo = $this->input->post('periodo_global');

        $periodo_no_laboral = array(
            'nombre' => $nombre,
            'descripcion' => $descripcion,
            'cant_dias' => $cant_dias,
            'fecha_inicio' => $fecha_inicio,
            'fecha_fin' => $fecha_fin,
            'periodo' => $periodo,
        );

        // echo_pre($periodo_no_laboral);
        // die();

        //Esta función recibe 'nombre_tabla' donde se guardaran los datos pasados por $jornada 
        if ($this->model_rhh_funciones->existe_como('rhh_periodo_no_laboral', 'nombre', $nombre, null)) {
            set_message('danger','Ya existe un periodo no laboral con el mismo nombre. Intente colocar otro');
        }else{
            $this->model_rhh_funciones->guardar('rhh_periodo_no_laboral', $periodo_no_laboral);
            set_message('success','Se ha agregado el periodo no laboral de forma correcta');
        }
        redirect('periodo-no-laboral');
    }

    /*SE ACCEDE SOLO POR POST*/
    public function actualizar()
    {
        is_user_logged($this->session->userdata('user'));
        if(!is_method_right($this->input->server('REQUEST_METHOD'), 'POST')){ //funcion del helper para verificar tipo de peticion correcta
            set_message('danger','Acción no permitida');
            redirect('inicio');
        }

        $ID = $this->input->post('ID');
        $nombre = $this->input->post('nombre_periodo');
        $descripcion = $this->input->post('descripcion_periodo');
        $cant_dias = $this->input->post('cant_dias_periodo');
        $fecha_inicio = $this->input->post('fecha_inicio_periodo');
        $fecha_fin = $this->input->post('fecha_fin_periodo');
        $periodo = $this->input->post('periodo_global');

        $periodo_no_laboral = array(
            'ID' => $ID,
            'nombre' => $nombre,
            'descripcion' => $descripcion,
            'cant_dias' => $cant_dias,
            'fecha_inicio' => $fecha_inicio,
            'fecha_fin' => $fecha_fin,
            'periodo' => $periodo,
        );

        $periodo_global = $this->model_rhh_funciones->obtener_uno('rhh_periodo', $periodo_no_laboral['periodo']);

        if ($this->verificar_periodo_global($periodo_global, $periodo_no_laboral)) {
            $this->model_rhh_funciones->guardar('rhh_periodo_no_laboral', $periodo_no_laboral);
            set_message('success','Se ha modificado el Periodo No Laboral de forma correcta');
            redirect('periodo-no-laboral');
        }else{
            set_message('danger','El periodo no laboral elegido se solapa con una de las fechas del periodo global, los cambios no fueron guardados');
            redirect('periodo-no-laboral/modificar/'.$ID);
        }
    }

    public function eliminar($ID)
    {
        is_user_logged($this->session->userdata('user'));
        if ($this->model_rhh_funciones->existe_como('rhh_periodo_no_laboral','ID',$ID, null)) {
            
            $periodo = $this->model_rhh_funciones->obtener_uno('rhh_periodo_no_laboral', $ID);
            set_message('success',"Se ha eliminado el Periodo No Laboral: <span class='negritas'>".$periodo['nombre']."</span>, de forma correcta");
            $this->model_rhh_funciones->eliminar('rhh_periodo_no_laboral', $ID);
        }else{
            set_message('danger','Al parecer el periodo que ha especificado no existe');
        }
        redirect('periodo-no-laboral');
    }

    /* FUNCION PARA VERIFICAR QUE EL PERIDO_NO_LABORAL ESTE CONTENIDO ENTRE EL PERIOGO GLOBAL*/
    private function verificar_periodo_global($periodo_global, $periodo_no_laboral)
    {

        $pg_ini = new DateTime($periodo_global['fecha_inicio']);
        $pg_fin = new DateTime($periodo_global['fecha_fin']);

        $pnl_ini = new DateTime($periodo_no_laboral['fecha_inicio']);
        $pnl_fin = new DateTime($periodo_no_laboral['fecha_fin']);

        if ($pnl_ini >= $pg_ini && $pnl_fin <= $pg_fin) {
            return true;
        }else{
            return false;
        }
    }
    
}