<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Controlador Principal Modulo mnt_cuadrilla
 */
class Cuadrilla extends MX_Controller
{
	/** Constructor*/
	public function __construct()
	{
		parent::__construct();
		
	}

	public function index()
	{
	//	$header['title'] = 'Página de Inicio - Sistema de Inventario';
		$this->load->view('home');
			
	}

	public function nueva_cuadrilla()
	{
		$this->load->view('template/header',$header);
		$this->load->view('mnt_cuadrilla/nueva_cuadrilla');
		//$this->load->view('inv_equipos/nuevo_equipo');
		$this->load->view('template/footer');
		$header['title']='Registrar nueva cuadrilla - Sistema de Mantenimiento';
		
			
	}



}