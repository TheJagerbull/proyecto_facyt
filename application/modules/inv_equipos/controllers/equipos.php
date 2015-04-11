
<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * 
 * Controlador Principal Modulo Equipos
 * =====================
 * 
 * @author José Henriquez en fecha: 06-04-2015
 * 
 */
class Equipos extends MX_Controller
{
	/**
	 * 
	 * Clase Constructora
	 * 
	 * @author José Henriquez en fecha 06-04-2015
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
	 * @author José Henriquez en fecha 06-04-2015
	 * 
	 */
	public function index()
	{
		["titulop"]='Página de Inicio - Sistema de Inventario';
		$this->load->view('home',);
			
	}

	/**
	 * 
	 * Formulario para agregar un equipo a la Tabla
	 * 
	 * @author José Henriquez en fecha 06-04-2015
	 * 
	 */
	public function form_equipo()
	{
		["titulop"]='Página de Inicio - Sistema de Inventario';
		$this>load->view('home',);
			
	}
	
	
	
}
