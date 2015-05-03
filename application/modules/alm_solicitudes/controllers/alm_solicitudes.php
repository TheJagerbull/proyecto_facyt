<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Alm_solicitudes extends MX_Controller
{
	function __construct() //constructor predeterminado del controlador
    {
        parent::__construct();
        $this->load->library('form_validation');
		$this->load->model('model_alm_solicitudes');
    }

    public function index()
    {
    	if($this->session->userdata('user'))
		{
	    	$this->load->view('template/header');
	    	$this->load->view('template/footer');
		}
		else
		{
			$header['title'] = 'Error de Acceso';
			$this->load->view('template/erroracc',$header);
		}
    }
//cargas de vistas
    public function generar_solicitud()
    {
    	if($this->session->userdata('user'))
		{
			$this->load->view('template/header');
			$i=$this->generar_nr();
	    	echo $i;
	    	
	    	$this->load->view('alm_solicitudes/solicitudes_main');
	    	$this->load->view('template/footer');
		}
		else
		{
			$header['title'] = 'Error de Acceso';
			$this->load->view('template/erroracc',$header);
		}
    }

    public function consultar_solicitud()
    {
    	if($this->session->userdata('user'))
		{
			$this->load->view('template/header');
	    	echo "hell is for the cowards";
	    	$this->load->view('template/footer');
		}
		else
		{
			$header['title'] = 'Error de Acceso';
			$this->load->view('template/erroracc',$header);
		}

    }
    public function consultar_solicitudes()
    {
    	if($this->session->userdata('user'))
		{
			$this->load->view('template/header');
	    	echo "hell is for the cowards";
	    	$this->load->view('template/footer');
		}
		else
		{
			$header['title'] = 'Error de Acceso';
			$this->load->view('template/erroracc',$header);
		}

    }
    public function autorizar_solicitudes()
    {
    	if($this->session->userdata('user'))
		{
			$this->load->view('template/header');
	    	echo "tears is weakness leaving your body";
	    	$this->load->view('template/footer');
		}
		else
		{
			$header['title'] = 'Error de Acceso';
			$this->load->view('template/erroracc',$header);
		}

    }

    public function editar_solicitud()
    {
    	if($this->session->userdata('user'))
		{
			$this->load->view('template/header');
	    	echo "hell is for the cowards";
	    	$this->load->view('template/footer');
		}
		else
		{
			$header['title'] = 'Error de Acceso';
			$this->load->view('template/erroracc',$header);
		}
    }

//funciones y operaciones
    public function agregar_articulos()
    {
    	if($this->session->userdata('user'))
		{


		}
		else
		{
			$header['title'] = 'Error de Acceso';
			$this->load->view('template/erroracc',$header);
		}

    }

    public function quitar_articulos()
    {
    	if($this->session->userdata('user'))
		{

		}
		else
		{
			$header['title'] = 'Error de Acceso';
			$this->load->view('template/erroracc',$header);
		}
    }

    public function generar_nr()//se utiliza para generar un valor de 9 caracteres de tipo string que sera el numero de la solicitud
    {
    	$aux = $this->model_alm_solicitudes->get_last_id() + 1;
    	$nr = str_pad($aux, 9, '0', STR_PAD_LEFT);// tomado de http://stackoverflow.com/questions/1699958/formatting-a-number-with-leading-zeros-in-php
    	// die_pre($nr);
    	return((string)$nr);
    }

}