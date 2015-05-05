<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Alm_solicitudes extends MX_Controller
{
	function __construct() //constructor predeterminado del controlador
    {
        parent::__construct();
        $this->load->library('form_validation');
		$this->load->model('model_alm_solicitudes');
		$this->load->model("alm_articulos/model_alm_articulos");
		$this->load->library('pagination');
    }

    public function index()
    {
    	if($this->session->userdata('user'))
		{
			$header['title'] = 'Pagina Principal de Solicitudes';
			$this->load->view('template/header', $header);
	    	$this->load->view('template/footer');
		}
		else
		{
			$header['title'] = 'Error de Acceso';
			$this->load->view('template/erroracc',$header);
		}
    }
    public function get_artCount()
    {
    	return $this->model_alm_articulos->count_articulos();
    }


//cargas de vistas
    public function generar_solicitud()
    {
    	if($this->session->userdata('user'))
		{
			$this->load->module('alm_articulos');
			$total_rows = $this->get_artCount();//uso para paginacion
			$per_page = 10;//uso para paginacion
			$url = 'index.php/solicitud/inventario/';//uso para paginacion
			$offset = $this->uri->segment(3, 0);//uso para consulta en BD
			$uri_segment = 3;//uso para paginacion
			$config = initPagination($url,$total_rows,$per_page,$uri_segment); //funcion del helper
			$this->pagination->initialize($config); // inicializacion de la paginacion
			if($_POST)
			{
				$post=$_POST;
				$articulo = $post['articulos'];
				$view['articulos'] = $this->alm_articulos->Buscar_Articulos($articulo);
				$view['links'] = '';
			}
			else
			{
				$view['articulos'] = $this->model_alm_articulos->get_activeArticulos($per_page, $offset);//el $offset y $per_page deben ser igual a los suministrados a initPagination()
				$view['links'] = $this->pagination->create_links();
			}
			$view['nr']=$this->generar_nr();
	    	// die_pre($view);

			$header['title'] = 'Generar solicitud';
			$this->load->view('template/header', $header);
	    	$this->load->view('alm_solicitudes/solicitudes_main', $view);
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
			$this->load->view('template/header', $header);
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
			$this->load->view('template/header', $header);
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
			$this->load->view('template/header', $header);
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
			$this->load->view('template/header', $header);
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