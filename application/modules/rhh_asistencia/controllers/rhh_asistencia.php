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
        	
        	$mensaje = "<div class='alert alert-success text-center' role='alert'><i class='fa fa-check fa-2x pull-left'></i>Se ha agregado la asistencia<br></div>";
        	$data["title"]='Control de Asistencia - Agregar';
        	$this->load->view('rhh_asistencia/rhh_header', $data);
        	$this->load->view('agregado',
				array(
					'mensaje' => $mensaje,
					'persona' => $persona,
					'asistencias' => $asistencias
				)
			);
			$this->load->view('rhh_asistencia/rhh_footer');
        }else{
        	$mensaje = "<div class='alert alert-danger text-center' role='alert'><i class='fa fa-exclamation fa-2x pull-left'></i>La cédula que ha ingresado no se encuentra en nuestros registros.</div>";
        	$data["title"]='Control de Asistencia - Agregar';
        	$this->load->view('rhh_asistencia/rhh_header', $data);
        	$this->load->view('agregado',
				array('mensaje' => $mensaje)
			);
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

			$mensaje = "<div class='alert alert-success text-center' role='alert'><i class='fa fa-check fa-2x pull-left'></i>Se ha agregado la configuración de forma correcta.<br></div>";

			$configuraciones = $this->model_rhh_asistencia->obtener_configuracion();

			$data["title"]='Control de Asistencia - Configuraciones';
			//$header = $this->dec_permiso->load_permissionsView();
			$this->load->view('rhh_asistencia/rhh_header', $data);
			$this->load->view('configuracion',array(
				'mensaje' => $mensaje,
				'configuraciones' => $configuraciones));
			$this->load->view('rhh_asistencia/rhh_footer');
		}else{
			$mensaje = "<div class='alert alert-danger text-center' role='alert'><i class='fa fa-exclamation fa-2x pull-left'></i>La cantidad de horas debe ser mayor a 0.<br></div>";

			$data["title"]='Control de Asistencia - Configuraciones - Agregar';
			//$header = $this->dec_permiso->load_permissionsView();
			$this->load->view('rhh_asistencia/rhh_header', $data);
			$this->load->view('configuracion_agregar', array(
				'mensaje' => $mensaje,
				'cantidad' => $cantidad));
			$this->load->view('rhh_asistencia/rhh_footer');
		}
	}

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

	public function modificar_jornada(){}

	public function eliminar_jornada(){}

}