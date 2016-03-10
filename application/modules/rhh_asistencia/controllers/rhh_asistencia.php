<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Rhh_asistencia extends MX_Controller
{

	public function __construct()
	{
		parent::__construct();
        $this->load->module('dec_permiso/dec_permiso');
	}
	
	public function index()
	{
		$data["title"]='Control de Asistencia';
		$header = $this->dec_permiso->load_permissionsView();
		$this->load->view('template/rhh_header', $data);
		$this->load->view('inicio');
		$this->load->view('template/rhh_footer');
	}

	public function agregar(){
		$data["title"]='Control de Asistencia - Agregar';
		$header = $this->dec_permiso->load_permissionsView();
		$this->load->view('template/rhh_header', $data);
		$this->load->view('agregar');
		$this->load->view('template/rhh_footer');
	}
}