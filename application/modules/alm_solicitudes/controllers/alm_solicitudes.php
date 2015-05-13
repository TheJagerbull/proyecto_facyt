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
    public function generar_solicitud($field='', $order='', $aux='')
    {

    	if($this->session->userdata('user'))
		{
			$this->load->module('alm_articulos');
			if($field=='buscar')//control para parametros pasados a la funcion, sin esto, no se ordenan los resultados de la busqueda
			{
				$field=$order;
				$order=$aux;
			}
			$per_page = 10;//uso para paginacion
			
			///////////////////////////////////////Esta porcion de codigo, separa las URI de ordenamiento de resultados, de las URI de listado comun	
			if($this->uri->segment(3)=='buscar'||$this->uri->segment(4)=='buscar')//para saber si la "bandera de busqueda" esta activada
			{
				if(!is_numeric($this->uri->segment(4,0)))//para saber si la "bandera de ordenamiento" esta activada
				{
					$url = 'index.php/solicitud/inventario/orden/buscar/'.$field.'/'.$order.'/';//uso para paginacion
					$offset = $this->uri->segment(7, 0);//uso para consulta en BD
					$uri_segment = 7;//uso para paginacion
				}
				else
				{
					$url = 'index.php/solicitud/inventario/buscar/';//uso para paginacion
					$offset = $this->uri->segment(4, 0);//uso para consulta en BD
					$uri_segment = 4;//uso para paginacion
				}

			}
			else
			{

				$this->session->unset_userdata('query');
				if(!is_numeric($this->uri->segment(4,0)))
				{
					$url = 'index.php/solicitud/inventario/orden/'.$field.'/'.$order.'/';//uso para paginacion
					$offset = $this->uri->segment(6, 0);//uso para consulta en BD
					$uri_segment = 6;//uso para paginacion
				}
				else
				{
					$url = 'index.php/solicitud/inventario/';//uso para paginacion
					$offset = $this->uri->segment(3, 0);//uso para consulta en BD
					$uri_segment = 3;//uso para paginacion
				}

			}
		///////////////////////////////////////Esta porcion de codigo, separa las URI de ordenamiento de resultados, de las URI de listado comun
			
			if(!empty($field))//verifica si se le ha pasado algun valor a $field, el cual indicara en funcion de cual columna se ordenara
			{
				switch ($field) //aqui se le "traduce" el valor, al nombre de la columna en la BD
				{
					case 'orden_cod': $field = 'cod_articulo'; break;
					case 'orden_descr': $field = 'descripcion'; break;
					case 'orden_exist': $field = 'existencia'; break;
					case 'orden_reserv': $field = 'reserv'; break;
					case 'orden_disp': $field = 'disp'; break;
					default: $field = ''; break;//en caso que no haya ninguna coincidencia, lo deja vacio
				}
			}
			$order = (empty($order) || ($order == 'asc')) ? 'desc' : 'asc';//aqui permite cambios de tipo "toggle" sobre la variable $order, que solo puede ser ascendente y descendente

			if($_POST)
			{
				$this->session->set_userdata('query',$_POST['articulos']);
			}
			if($this->uri->segment(3)=='buscar'||$this->uri->segment(4)=='buscar')//debido a que en la vista hay un pequeno formulario para el campo de busqueda, verifico si no se le ha pasado algun valor
			{
				// die_pre($this->session->userdata('query'));
				$view['articulos'] = $this->alm_articulos->buscar_articulos($field, $order, $per_page, $offset); //cargo la busqueda de los usuarios
				$total_rows = $this->model_alm_articulos->count_foundArt($this->session->userdata('query'));//contabilizo la cantidad de resultados arrojados por la busqueda
				$config = initPagination($url,$total_rows,$per_page,$uri_segment); //inicializo la configuracion de la paginacion
				$this->pagination->initialize($config); //inicializo la paginacion en funcion de la configuracion
				$view['links'] = $this->pagination->create_links(); //se crean los enlaces, que solo se mostraran en la vista, si $total_rows es mayor que $per_page
			}
			else//en caso que no se haya captado ningun dato en el formulario
			{
				$total_rows = $this->get_artCount();//uso para paginacion
				$view['articulos'] = $this->model_alm_articulos->get_activeArticulos($field,$order,$per_page, $offset);
				$config = initPagination($url,$total_rows,$per_page,$uri_segment);
				$this->pagination->initialize($config);
				$view['links'] = $this->pagination->create_links();//NOTA, La paginacion solo se muestra cuando $total_rows > $per_page
			}

////////////////////////////////////////////////////////////////////////////////////////////////////////


			$view['order'] = $order;
	    	//die_pre($view);

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



			$header['title'] = 'Solicitud';
			$this->load->view('template/header', $header);
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
			if($_POST)
			{
				die_pre("YUPIIII!!!!".$_POST['ID']." cantidad: ".$_POST['cant']."numero_solicitud: ".$_POST['Nr']);
			}

		}
		else
		{
			$header['title'] = 'Error de Acceso';
			$this->load->view('template/erroracc',$header);
		}

    }
////////agregar y quitar articulos de la session
    public function agregar_articulo()
    {
    	if($this->session->userdata('user'))
		{
			if($_POST)
			{
				// die_pre($_POST['ID']." URI= ".$_POST['URI']);
				$articulo = $_POST['ID'];
			}
			if(empty($this->session->userdata('articulos')))
			{
				$art = array();
			}
			else
			{
				$art = $this->session->userdata('articulos');
			}
			
			// $this->session->userdata('articulos')= array(" ");
			array_push($art, $articulo);
			// die_pre($art);
			$this->session->set_userdata('articulos', $art);
			// die_pre($this->session->userdata('articulos'));
				redirect($_POST['URI']);

		}
		else
		{
			$header['title'] = 'Error de Acceso';
			$this->load->view('template/erroracc',$header);
		}

    }
    public function quitar_articulo()
    {
    	if($this->session->userdata('user'))
		{
			// echo_pre($_POST['ID']);
			$art = $this->session->userdata('articulos');
			// echo_pre($art);
			// echo_pre(array_search($_POST['ID'], $art));
			unset($art[array_search($_POST['ID'], $art)]);
			// echo_pre($art);
			$this->session->set_userdata('articulos', $art);
			if(empty($art))
			{
				$this->session->unset_userdata('articulos');
				redirect('solicitud/inventario');
			}
			else
			{
				echo_pre($this->session->userdata('articulos'));
				redirect('solicitud/confirmar');
			}
			

		}
		else
		{
			$header['title'] = 'Error de Acceso';
			$this->load->view('template/erroracc',$header);
		}
    }
////////fin de agregar y quitar articulos de la session
	public function exist_solicitud()
	{
		$where['nr_solicitud'] = $this->input->post('nr');
		
		if($this->model_alm_solicitudes->exist($where))
		{
		
			$this->form_validation->set_message('exist_solicitud','<strong>Numero de Solicitud</strong> ya fue usado, intente nuevamente');
			return FALSE;
		}
		return TRUE;
	}
    public function confirmar_articulos()
    {
    	if($this->session->userdata('user'))
		{
			$aux = array();
			foreach ($this->session->userdata('articulos') as $key => $articulo)
			{
				array_push($aux, $articulo);
				// array_push($view['articulos'], $this->model_alm_articulos->get_articulo($articulo));
			}
			$view['articulos'] = $this->model_alm_articulos->get_articulo($aux);
			// echo_pre($view['articulos'][0][0]->ID);
			// die_pre($view['articulos']);
			if($_POST)
			{
				// die_pre($_POST);
				$this->form_validation->set_error_delimiters('<div class="alert alert-danger">','</div>');
		    	$this->form_validation->set_message('required', '%s es Obligatorio');
		    	$this->form_validation->set_message('numeric', '%s Debe ser numerica');
				$this->form_validation->set_rules('nr','<strong>Numero de Solicitud</strong>','callback_exist_solicitud');

	    		$i=0;
	    		while(!empty($_POST['ID'.$i]))
	    		{
	    			$this->form_validation->set_rules(('qt'.$i),('La <strong>Cantidad del Articulo '.($i+1).'</strong>'),'numeric|required');
	    			// echo_pre($_POST['qt'.$i]);
	    			$i++;
	    		}

	    		if($this->form_validation->run($this))
				{
					$i=0;
		    		while(!empty($_POST['ID'.$i]))
		    		{
						$contiene[$i] = array(
							'ID'=>$_POST['ID'.$i],
							'cant_solicitada'=>$_POST['qt'.$i]
							);
						$i++;
					}
					$solicitud['id_usuario']=$this->session->userdata('user')['id_usuario'];
					$solicitud['nr_solicitud']=$_POST['nr'];
					$solicitud['status']='carrito';
					$solicitud['observacion']=$_POST['observacion'];
					$this->load->helper('date');
					$datestring = "%Y-%m-%d %h:%i:%s";
					$time = time();
					$solicitud['fecha_gen'] = mdate($datestring, $time);
					echo_pre($contiene);
					die_pre($solicitud);
	    		}
	    		else
	    		{
					$view['nr']=$this->generar_nr();
			    	$header['title'] = 'Generar solicitud - Paso 2';
					$this->load->view('template/header', $header);
			    	$this->load->view('alm_solicitudes/solicitudes_step2', $view);
			    	$this->load->view('template/footer');
	    		}
			}
			else
			{
				$view['nr']=$this->generar_nr();
		    	$header['title'] = 'Generar solicitud - Paso 2';
				$this->load->view('template/header', $header);
		    	$this->load->view('alm_solicitudes/solicitudes_step2', $view);
		    	$this->load->view('template/footer');
		    }
		}
		else
		{
			$header['title'] = 'Error de Acceso';
			$this->load->view('template/erroracc',$header);
		}

    }
    public function enviar_solicitud()
    {
    	
    	
    }

    public function prueba()
    {

    }

    public function generar_nr()//se utiliza para generar un valor de 9 caracteres de tipo string que sera el numero de la solicitud
    {
    	$aux = $this->model_alm_solicitudes->get_last_id() + 1;
    	$nr = str_pad($aux, 9, '0', STR_PAD_LEFT);// tomado de http://stackoverflow.com/questions/1699958/formatting-a-number-with-leading-zeros-in-php
    	// die_pre($nr);
    	return((string)$nr);
    }

}