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
	
	public function index()
	{
		$data["title"]='Control de Asistencia';
		//$header = $this->dec_permiso->load_permissionsView();
		$this->load->view('template/rhh_header', $data);
		$this->load->view('inicio');
		$this->load->view('template/rhh_footer');
	}

	public function agregar(){
		$data["title"]='Control de Asistencia - Agregar';
		//$header = $this->dec_permiso->load_permissionsView();
		$this->load->view('template/rhh_header', $data);
		$this->load->view('agregar');
		$this->load->view('template/rhh_footer');
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
        	$this->load->view('template/rhh_header', $data);
        	$this->load->view('agregado',
				array(
					'mensaje' => $mensaje,
					'persona' => $persona,
					'asistencias' => $asistencias
				)
			);
			$this->load->view('template/rhh_footer');
        }else{
        	$mensaje = "<div class='alert alert-danger text-center' role='alert'><i class='fa fa-exclamation fa-2x pull-left'></i>La cédula que ha ingresado no se encuentra en nuestros registros.</div>";
        	$data["title"]='Control de Asistencia - Agregar';
        	$this->load->view('template/rhh_header', $data);
        	$this->load->view('agregado',
				array('mensaje' => $mensaje)
			);
			$this->load->view('template/rhh_footer');
        }
	}
	#Pos: Devolver la información recien almacenada
}