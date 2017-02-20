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
        $this->load->module('dec_permiso/dec_permiso');
		
	}
	
	/**Muestra Pagina con mensaje Inicial y Menú */
	public function index()
	{
		$data["title"]='Cuadrillas';
		$header = $this->dec_permiso->load_permissionsView();
			$this->load->view('template/header', $data);
		$this->load->view('listar_cuadrillas');
		$this->load->view('template/footer');		
	}



	
}