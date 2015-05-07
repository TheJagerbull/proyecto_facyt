<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * 
 * Controlador Principal Modulo Air_Home
 * =====================
 * 
 * @author Jose Henriquez 
 * 
 */
class Index extends MX_Controller
{
	/**
	 * 
	 * Clase Constructora
	 * 
	 * @author Jose Henriquez 23-03-2015
	 * 
	 */
	public function __construct()
	{
		
		parent::__construct();
		
	}
	
	/**
	 * 
	 * Muestra Pagina con mensaje Inicial y Menú
	 * 
	 * @author Jose Henriquez
	 * 
	 */
	public function index()
	{
		$data["title"]='Página de Inicio';
		$this->load->view('template/header', $data);
		$this->load->view('home');
		$this->load->view('template/footer');
			
	}
	
	
	
}