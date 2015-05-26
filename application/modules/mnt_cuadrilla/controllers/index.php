<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Controlador Principal Modulo mnt_cuadrilla
 */
class Index extends MX_Controller
{
	/** Constructor*/
	public function __construct()
	{
		parent::__construct();
		
	}
	
	/**Muestra Pagina con mensaje Inicial y Menú */
	public function index()
	{
		$data["title"]='Cuadrillas';
		$this->load->view('template/header', $data);
		$this->load->view('listar_cuadrillas');
		$this->load->view('template/footer');		
	}



	
}