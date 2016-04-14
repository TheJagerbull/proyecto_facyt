<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Rhh_asistencia extends MX_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->module('dec_permiso/dec_permiso');
        $this->load->model('model_rhh_asistencia'); /*Para procesar los datos en la BD */
    }
    
    /* Carga elementos para efectos demostrativos */
    public function index()
    {
        $data["title"]='Control de Asistencia';
        //$header = $this->dec_permiso->load_permissionsView();
        $this->load->view('rhh_asistencia/rhh_header', $data);
        $this->load->view('inicio');
        $this->load->view('rhh_asistencia/rhh_footer');
    }

    /* Vista: Agregar Asistencia*/
    public function agregar()
    {
        $data["title"]='Control de Asistencia - Agregar';
        //$header = $this->dec_permiso->load_permissionsView();
        $this->load->view('rhh_asistencia/rhh_header', $data);
        $this->load->view('agregar');
        $this->load->view('rhh_asistencia/rhh_footer');
    }

    #Pre: Verificar que el trabajador existe
    public function verificar()
    {
        $cedula = $this->input->post('cedula');
        $persona = null;

        if ($this->model_rhh_asistencia->existe_cedula($cedula)) {
            $this->model_rhh_asistencia->agregar_asistencia($cedula);
            $persona = $this->model_rhh_asistencia->obtener_persona($cedula);
            $asistencias = $this->model_rhh_asistencia->obtener_asistencia_del_dia($cedula);
            
            $mensaje = "<div class='alert alert-success text-center' role='alert'><i class='fa fa-check fa-2x pull-left'></i>Se ha agregado la asistencia</div>";
            $this->session->set_flashdata("mensaje", $mensaje);
            $data["title"]='Control de Asistencia - Agregar';
            $this->load->view('rhh_asistencia/rhh_header', $data);
            $this->load->view('agregado',
                array(
                    'persona' => $persona,
                    'asistencias' => $asistencias
                )
            );
            $this->load->view('rhh_asistencia/rhh_footer');
        }else{
            $mensaje = "<div class='alert alert-danger text-center' role='alert'><i class='fa fa-exclamation fa-2x pull-left'></i>La cédula que ha ingresado no se encuentra en nuestros registros.</div>";
            $this->session->set_flashdata("mensaje", $mensaje);

            $data["title"]='Control de Asistencia - Agregar';
            $this->load->view('rhh_asistencia/rhh_header', $data);
            $this->load->view('agregado');
            $this->load->view('rhh_asistencia/rhh_footer');
        }
    }
    #Pos: Devolver la información recien almacenada

    /* Tiene las condifuraciones que controlan las Asistencias
        Ej. Cantidad de Min_Hrs_Falta_Semanal 
       Mostrará las configuraciones existentes
    */
    public function configuracion()
    {
        $data["title"]='Control de Asistencia - Configuraciones';
        $configuraciones = $this->model_rhh_asistencia->obtener_configuracion();

        //$header = $this->dec_permiso->load_permissionsView();
        $this->load->view('rhh_asistencia/rhh_header', $data);
        $this->load->view('configuracion', array(
            'configuraciones' => $configuraciones));
        $this->load->view('rhh_asistencia/rhh_footer');
    }

    /*
    public function configuracion_agregar()
    {
        $data["title"]='Control de Asistencia - Configuraciones - Agregar';
        //$header = $this->dec_permiso->load_permissionsView();
        $this->load->view('rhh_asistencia/rhh_header', $data);
        $this->load->view('configuracion_agregar');
        $this->load->view('rhh_asistencia/rhh_footer');
    }*/

    public function verificar_configuracion()
    {
        /*Guardar en la base de datos lo que está mal*/
        $cantidad = $this->input->post('cantidad');
        $id = $this->input->post('id');

        if ($cantidad > 0) {
            $this->model_rhh_asistencia->guardar_configuracion($id, $cantidad);

            $mensaje = "<div class='alert alert-success text-center' role='alert'><i class='fa fa-check fa-2x pull-left'></i>Se ha agregado la configuración de forma correcta.</div>";
            $this->session->set_flashdata("mensaje", $mensaje);

            $configuraciones = $this->model_rhh_asistencia->obtener_configuracion();

            $data["title"]='Control de Asistencia - Configuraciones';
            //$header = $this->dec_permiso->load_permissionsView();
            $this->load->view('rhh_asistencia/rhh_header', $data);
            $this->load->view('configuracion',array(
                'configuraciones' => $configuraciones));
            $this->load->view('rhh_asistencia/rhh_footer');
        }else{
            $mensaje = "<div class='alert alert-danger text-center' role='alert'><i class='fa fa-exclamation fa-2x pull-left'></i>La cantidad de horas debe ser mayor a 0.</div>";
            $this->session->set_flashdata("mensaje", $mensaje);

            $data["title"]='Control de Asistencia - Configuraciones - Agregar';
            //$header = $this->dec_permiso->load_permissionsView();
            $this->load->view('rhh_asistencia/rhh_header', $data);
            $this->load->view('configuracion_agregar', array(
                'cantidad' => $cantidad));
            $this->load->view('rhh_asistencia/rhh_footer');
        }
    }

    /* Modificar una entrada de la tabla de configuraciones de asistencia */
    public function modificar_configuracion($id, $cantidad)
    {
        $data["title"]='Control de Asistencia - Configuraciones - Agregar';
        //$header = $this->dec_permiso->load_permissionsView();
        $this->load->view('rhh_asistencia/rhh_header', $data);
        $this->load->view('configuracion_agregar', array(
            'cantidad' => $cantidad,
            'id' => $id));
        $this->load->view('rhh_asistencia/rhh_footer');
    }


    /* Devuelve la lista de jornadas cargadas */
    public function jornada()
    {
        $jornadas = $this->model_rhh_asistencia->obtener_jornadas();
        $data["title"]='Control de Asistencia - Jornadas - Lista';
        //$header = $this->dec_permiso->load_permissionsView();
        $this->load->view('rhh_asistencia/rhh_header', $data);
        $this->load->view('jornada', array(
            'jornadas' => $jornadas));
        $this->load->view('rhh_asistencia/rhh_footer');
    }

    /*
        Carga la vista(formulario) para 
            - agregar una jornada
            - modificar una jornada
    */
    public function nueva_jornada($jornada = null, $action = 'asistencia/jornada/agregar')
    {
        $data["title"]='Control de Asistencia - Jornadas - Agregar';
        //$header = $this->dec_permiso->load_permissionsView();
        $this->load->view('rhh_asistencia/rhh_header', $data);
        $this->load->view('jornada_agregar', array(
            'jornada' => $jornada,
            'action' => $action));
        $this->load->view('rhh_asistencia/rhh_footer');
    }

    /* Procesa el formulario de una jornada nueva */
    public function agregar_jornada()
    {
        $nombre = $this->input->post('nombre_jornada');

        $hora_inicio = $this->input->post('hora_inicio');
        $ampm = $this->input->post('ampm_inicio');
        $hora_inicio = $hora_inicio.' '.$ampm;
        $hrs_ini = new DateTime($hora_inicio);

        $hora_fin = $this->input->post('hora_fin');
        $ampm = $this->input->post('ampm_fin');
        $hora_fin = $hora_fin.' '.$ampm;
        $hrs_fin = new DateTime($hora_fin);

        $cantidad_horas_descanso = $this->input->post('cantidad_horas_descanso');
        $tolerancia = $this->input->post('tolerancia');
        $tipo = $this->input->post('tipo');
        $cargo = $this->input->post('cargo');

        $jornada = array(
            'nombre' => $nombre,
            'hora_inicio' => $hrs_ini->format('H:i:s'), //Guardando en formato 24hrs
            'hora_fin'  => $hrs_fin->format('H:i:s'), //Guardando en formato 24hrs
            'tipo'  => $tipo,
            'tolerancia'    => $tolerancia,
            'cantidad_horas_descanso' => $cantidad_horas_descanso,
            'id_cargo' => $cargo
        );

        /* Esta función recibe 'nombre_tabla' donde se guardaran los datos pasados por $jornada */
        if ($this->model_rhh_funciones->existe_como('rhh_jornada_laboral', 'id_cargo', $cargo, null)) {
            $mensaje = "<div class='alert alert-danger text-center' role='alert'><i class='fa fa-exclamation fa-2x pull-left'></i>Ya existe una Jornada asociada al cargo que especifico. Elija un cargo que tiene jornada o modifique el existente.</div>";
        }else{
            $this->model_rhh_funciones->guardar('rhh_jornada_laboral', $jornada);
        
            $mensaje = "<div class='alert alert-success text-center' role='alert'><i class='fa fa-check fa-2x pull-left'></i>Se ha agregado la configuración de forma correcta.</div>";
        }
        $this->session->set_flashdata("mensaje", $mensaje);
        redirect('asistencia/jornada');
    }

    public function modificar_jornada($ID)
    {
        //obtener los datos del modelo
        $jornada = $this->model_rhh_asistencia->obtener_jornada($ID);

        //Devolverlos a la vista
        if ($jornada == null) {
            $mensaje = "<div class='alert alert-danger text-center' role='alert'><i class='fa fa-exclamation fa-2x pull-left'></i>La jornada que intenta modificar no existe.</div>";
            $this->session->set_flashdata("mensaje", $mensaje);
            redirect('asistencia/jornada');

        }else{
            foreach ($jornada as $key) {
                $data = array(
                    'ID' => $key->ID,
                    'nombre' => $key->nombre,
                    'hora_inicio' => $key->hora_inicio,
                    'hora_fin' => $key->hora_fin,
                    'tolerancia' => $key->tolerancia,
                    'tipo' => $key->tipo,
                    'cargo' => $key->id_cargo,
                    'cantidad_horas_descanso' => $key->cantidad_horas_descanso
                );
            }
            // retorna al formulario de agregar jornada los datos para ser modificados
            return $this->nueva_jornada($data, 'asistencia/jornada/actualizar');
        }
    }

    /*
        Para procesar los datos de un jornada modificada
    */
    public function actualizar_jornada()
    {
        $ID = $this->input->post('ID');
        $nombre = $this->input->post('nombre_jornada');

        $hora_inicio = $this->input->post('hora_inicio');
        $ampm = $this->input->post('ampm_inicio');
        $hora_inicio = $hora_inicio.' '.$ampm;
        $hrs_ini = new DateTime($hora_inicio);

        $hora_fin = $this->input->post('hora_fin');
        $ampm = $this->input->post('ampm_fin');
        $hora_fin = $hora_fin.' '.$ampm;
        $hrs_fin = new DateTime($hora_fin);

        $cantidad_horas_descanso = $this->input->post('cantidad_horas_descanso');
        $tolerancia = $this->input->post('tolerancia');
        $tipo = $this->input->post('tipo');
        $cargo = $this->input->post('cargo');

        $jornada = array(
            'ID' => $ID,
            'nombre' => $nombre,
            'hora_inicio' => $hrs_ini->format('H:i:s'), //Guardando en formato 24hrs
            'hora_fin'  => $hrs_fin->format('H:i:s'), //Guardando en formato 24hrs
            'tipo'  => $tipo,
            'tolerancia'    => $tolerancia,
            'cantidad_horas_descanso' => $cantidad_horas_descanso,
            'id_cargo' => $cargo
        );

        /* Esta función recibe 'nombre_tabla' donde se guardaran los datos pasados por $jornada
        en este caso jornada tiene un campo ID para actualizar */
        if ($this->model_rhh_funciones->existe_como('rhh_jornada_laboral', 'id_cargo', $cargo, $ID)) {
            $mensaje = "<div class='alert alert-danger text-center' role='alert'><i class='fa fa-exclamation fa-2x pull-left'></i>Ya existe una Jornada asociada al cargo que especifico. Elija un cargo que tiene jornada o modifique el existente.</div>";
        }else{
            $this->model_rhh_funciones->guardar('rhh_jornada_laboral', $jornada);
            $mensaje = "<div class='alert alert-success text-center' role='alert'><i class='fa fa-check fa-2x pull-left'></i>Se ha modificado la Jornada de forma exitosa.</div>";
        }

        $this->session->set_flashdata("mensaje", $mensaje);
        redirect('asistencia/jornada');
    }

    public function eliminar_jornada($id)
    {
        /* Verificar que existe una jornada para eliminar */
        if($this->model_rhh_asistencia->existe_en('rhh_jornada_laboral', $id))
        {
            $this->model_rhh_asistencia->eliminar('rhh_jornada_laboral', $id);
            $mensaje = "<div class='alert alert-success text-center' role='alert'><i class='fa fa-check fa-2x pull-left'></i>Se ha eliminado la jornada con exito.</div>";
        }else{
            $mensaje = "<div class='alert alert-danger text-center' role='alert'><i class='fa fa-exclamation fa-2x pull-left'></i>La Jornada que intenta eliminar no existe.</div>";
            
        }
        $this->session->set_flashdata("mensaje", $mensaje);
        redirect('asistencia/jornada');
    }

}