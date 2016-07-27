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
		$this->load->model('dec_dependencia/model_dec_dependencia');
		$this->load->model('user/model_dec_usuario');
        $this->load->module('dec_permiso/dec_permiso');
    }
    //la egne &ntilde;
    //acento &acute;
    public function index()//Administrar Solicitudes
    {
    	if($this->session->userdata('user'))
		{
			$header['title'] = 'Pagina Principal de Solicitudes';
			$header = $this->dec_permiso->load_permissionsView();
			$this->load->view('template/header', $header);
	    	$this->load->view('template/footer');
		}
		else
		{
			$header['title'] = 'Error de Acceso';
			$this->load->view('template/erroracc',$header);
		}
    }

    public function get_artCount()//usado para recibir la cantidad total de articulos en sistema
    {
    	return $this->model_alm_articulos->count_articulos();
    }

    public function generar_nr()//se utiliza para generar un valor de 9 caracteres de tipo string que sera el numero de la solicitud
    {
    	$aux = $this->model_alm_solicitudes->get_last_id() + 1;
    	$nr = str_pad($aux, 9, '0', STR_PAD_LEFT);// tomado de http://stackoverflow.com/questions/1699958/formatting-a-number-with-leading-zeros-in-php
    	// die_pre($nr, __LINE__, __FILE__);
    	return((string)$nr);
    }

    public function asignar_carrito()
    {
    	$aux = $this->model_alm_solicitudes->get_last_cart() + 1;
    	$nr = str_pad($aux, 9, '0', STR_PAD_LEFT);// tomado de http://stackoverflow.com/questions/1699958/formatting-a-number-with-leading-zeros-in-php
    	// die_pre($nr, __LINE__, __FILE__);
    	return((string)$nr);
    }

//cargas de vistas
/////////////////////////////////////////generacion de solicitudes////////////////////////////
//     public function paso_1($field='', $order='', $aux='')//para el listado del paso 1 para generar solicitudes
//     {
// //    	echo_pre('permiso para generar solicitud, crear carrito', __LINE__, __FILE__);//modulo=alm, func=9
//     	if($this->session->userdata('user') && ($this->dec_permiso->has_permission('alm', 9)))//9
// 		{
			
// 			if(!$this->model_alm_solicitudes->get_userCart())
// 			{
// 				$this->load->module('alm_articulos');
// 				if($field=='buscar')//control para parametros pasados a la funcion, sin esto, no se ordenan los resultados de la busqueda
// 				{
// 					$field=$order;
// 					$order=$aux;
// 				}
// 				$per_page = 10;//uso para paginacion
				
// 				///////////////////////////////////////Esta porcion de codigo, separa las URI de ordenamiento de resultados, de las URI de listado comun	
// 				if($this->uri->segment(3)=='buscar'||$this->uri->segment(4)=='buscar')//para saber si la "bandera de busqueda" esta activada
// 				{
// 					if(!is_numeric($this->uri->segment(4,0)))//para saber si la "bandera de ordenamiento" esta activada
// 					{
// 						$url = 'index.php/solicitud/inventario/orden/buscar/'.$field.'/'.$order.'/';//uso para paginacion
// 						$offset = $this->uri->segment(7, 0);//uso para consulta en BD
// 						$uri_segment = 7;//uso para paginacion
// 					}
// 					else
// 					{
// 						$url = 'index.php/solicitud/inventario/buscar/';//uso para paginacion
// 						$offset = $this->uri->segment(4, 0);//uso para consulta en BD
// 						$uri_segment = 4;//uso para paginacion
// 					}

// 				}
// 				else
// 				{

// 					$this->session->unset_userdata('query');
// 					if(!is_numeric($this->uri->segment(4,0)))
// 					{
// 						$url = 'index.php/solicitud/inventario/orden/'.$field.'/'.$order.'/';//uso para paginacion
// 						$offset = $this->uri->segment(6, 0);//uso para consulta en BD
// 						$uri_segment = 6;//uso para paginacion
// 					}
// 					else
// 					{
// 						$url = 'index.php/solicitud/inventario/';//uso para paginacion
// 						$offset = $this->uri->segment(3, 0);//uso para consulta en BD
// 						$uri_segment = 3;//uso para paginacion
// 					}

// 				}
// 			///////////////////////////////////////Esta porcion de codigo, separa las URI de ordenamiento de resultados, de las URI de listado comun
				
// 				if(!empty($field))//verifica si se le ha pasado algun valor a $field, el cual indicara en funcion de cual columna se ordenara
// 				{
// 					switch ($field) //aqui se le "traduce" el valor, al nombre de la columna en la BD
// 					{
// 						case 'orden_cod': $field = 'cod_articulo'; break;
// 						case 'orden_descr': $field = 'descripcion'; break;
// 						case 'orden_exist': $field = 'existencia'; break;
// 						case 'orden_reserv': $field = 'reserv'; break;
// 						case 'orden_disp': $field = 'disp'; break;
// 						default: $field = ''; break;//en caso que no haya ninguna coincidencia, lo deja vacio
// 					}
// 				}
// 				$order = (empty($order) || ($order == 'asc')) ? 'desc' : 'asc';//aqui permite cambios de tipo "toggle" sobre la variable $order, que solo puede ser ascendente y descendente

// 				if($_POST)
// 				{
// 					$this->session->set_userdata('query',$_POST['articulos']);
// 				}
// 				if($this->uri->segment(3)=='buscar'||$this->uri->segment(4)=='buscar')//debido a que en la vista hay un pequeno formulario para el campo de busqueda, verifico si no se le ha pasado algun valor
// 				{
// 					// die_pre($this->session->userdata('query'));
// 					$view['articulos'] = $this->alm_articulos->buscar_articulos($field, $order, $per_page, $offset); //cargo la busqueda de los usuarios
// 					$total_rows = $this->model_alm_articulos->count_foundArt($this->session->userdata('query'));//contabilizo la cantidad de resultados arrojados por la busqueda
// 					$config = initPagination($url,$total_rows,$per_page,$uri_segment); //inicializo la configuracion de la paginacion
// 					$this->pagination->initialize($config); //inicializo la paginacion en funcion de la configuracion
// 					$view['links'] = $this->pagination->create_links(); //se crean los enlaces, que solo se mostraran en la vista, si $total_rows es mayor que $per_page
// 				}
// 				else//en caso que no se haya captado ningun dato en el formulario
// 				{
// 					$total_rows = $this->get_artCount();//uso para paginacion
// 					$view['articulos'] = $this->model_alm_articulos->get_activeArticulos($field,$order,$per_page, $offset);
// 					$config = initPagination($url,$total_rows,$per_page,$uri_segment);
// 					$this->pagination->initialize($config);
// 					$view['links'] = $this->pagination->create_links();//NOTA, La paginacion solo se muestra cuando $total_rows > $per_page
// 				}

// 	////////////////////////////////////////////////////////////////////////////////////////////////////////


// 				$view['order'] = $order;
// 		    	//die_pre($view);
// 				// die_pre($header, __LINE__, __FILE__);
// 				$header = $this->dec_permiso->load_permissionsView();
// 				$header['title'] = 'Generar solicitud';
// 				$this->load->view('template/header', $header);
// 		    	// $this->load->view('alm_solicitudes/solicitudes_steps', $view);
// 		    	$this->load->view('alm_solicitudes/solicitudes_main', $view);
// 		    	$this->load->view('template/footer');
// 		    }
// 		    else
// 		    {

//     			// die_pre('ya tiene una solicitud pendiente', __LINE__, __FILE__);
// 				$this->session->set_flashdata('Cart', 'true');
// 	    		redirect('solicitud/enviar');
// 		    }
// 		}
// 		else
// 		{
// 			$this->session->set_flashdata('permission', 'error');
// 			redirect('inicio');
// 			$header['title'] = 'Error de Acceso';
// 			$this->load->view('template/erroracc',$header);
// 		}
//     }
//     public function paso_2()//solicitudes_step2.php
//     {
//     	echo_pre('permiso para generar solicitud', __LINE__, __FILE__);//9
//     	if($this->session->userdata('user') && ($this->dec_permiso->has_permission('alm', 9)))
// 		{
// 			if(empty($this->session->userdata('articulos')[0]['descripcion']))
// 			{
// 				$aux = array();
// 				foreach ($this->session->userdata('articulos') as $key => $articulo)
// 				{
// 					array_push($aux, $articulo);
// 					// array_push($view['articulos'], $this->model_alm_articulos->get_articulo($articulo));
// 				}
// 				$id_cart = $this->asignar_carrito();
// 				$view['articulos'] = $this->model_alm_articulos->get_articulo($aux);//cambio la funcion a "result_array()"
// 				// echo_pre($view['articulos'], __LINE__, __FILE__);
// 				if($_POST)
// 				{
// 					// die_pre($_POST, __LINE__, __FILE__);
// 					$this->form_validation->set_error_delimiters('<div class="alert alert-danger">','</div>');
// 			    	$this->form_validation->set_message('required', '%s es Obligatorio');
// 			    	$this->form_validation->set_message('numeric', '%s Debe ser numerica');
// 					// $this->form_validation->set_rules('nr','<strong>Numero de Solicitud</strong>','callback_exist_solicitud');

// 		    		$i=0;
// 		    		while(!empty($_POST['ID'.$i]))
// 		    		{
// 		    			$this->form_validation->set_rules(('qt'.$i),('La <strong>Cantidad del Articulo '.($i+1).'</strong>'),'numeric|required');
// 		    			// echo_pre($_POST['qt'.$i]);
// 		    			$i++;
// 		    		}

// 		    		if($this->form_validation->run($this))
// 					{
// 						$i=0;
// 			    		while(!empty($_POST['ID'.$i]))
// 			    		{
// 							$contiene[$i] = array(
// 								'id_carrito'=>$id_cart,
// 								'id_articulo'=>$_POST['ID'.$i],
// 								// 'NRS'=>$_POST['nr'],
// 								//'nr_solicitud'=>$_POST['nr'],/////revisar
// 								'cant_solicitada'=>$_POST['qt'.$i]
// 								);
// 							$i++;
// 						}
// 						$carrito['id_usuario']=$this->session->userdata('user')['id_usuario'];
// 						// $solicitud['nr_solicitud']=$_POST['nr'];
// 						$carrito['id_carrito'] = $id_cart;
// 						$carrito['observacion']=$_POST['observacion'];
// 						// $this->load->helper('date');
// 						// $datestring = "%Y-%m-%d %H:%i:%s";
// 						// $time = time();
// 						// $carrito['fecha_gen'] = mdate($datestring, $time);
// 						$carrito['contiene'] = $contiene;
// 						// die_pre($carrito, __LINE__, __FILE__);
// 						$check = $this->model_alm_solicitudes->insert_carrito($carrito);
// 						if($check!= FALSE)
// 						{
// 							$this->session->unset_userdata('articulos');
// 							// $where = array('id_usuario'=> $this->session->userdata('user')['id_usuario'], 'status'=>'carrito');
// 							$where = array('id_usuario'=> $this->session->userdata('user')['id_usuario']);

// 							// if($this->model_alm_solicitudes->exist($where))
// 							// {
// 								// die_pre($where, __LINE__, __FILE__);
// /**/							$cart = $this->model_alm_solicitudes->get_userCart();
// 								if($cart)
// 								{
// 									// die_pre($cart, __LINE__, __FILE__);
// 									$this->session->set_userdata('articulos', $cart['articulos']);
// 									$this->session->set_userdata('id_carrito', $cart['id_carrito']);
// 								}
// 							// }
// 							$this->session->set_flashdata('create_solicitud','success');
// 							redirect('solicitud/enviar');
// 						}
// 						else
// 						{
// 							$this->session->set_flashdata('create_solicitud','error');
// 							redirect('solicitud/confirmar');
// 						}

// 		    		}
// 		    		else
// 		    		{
// 						// die_pre($header, __LINE__, __FILE__);
// 						$header = $this->dec_permiso->load_permissionsView();
// 				    	$header['title'] = 'Generar solicitud - Paso 2';
// 						$this->load->view('template/header', $header);
// 				    	$this->load->view('alm_solicitudes/solicitudes_step2', $view);
// 				    	$this->load->view('template/footer');
// 		    		}
// 				}
// 				else
// 				{
// 					// die_pre($header, __LINE__, __FILE__);
// 					$header = $this->dec_permiso->load_permissionsView();
// 			    	$header['title'] = 'Generar solicitud - Paso 2';
// 					$this->load->view('template/header', $header);
// 			    	$this->load->view('alm_solicitudes/solicitudes_step2', $view);
// 			    	$this->load->view('template/footer');
// 			    }
// 			}
// 			else
// 			{
// 	    		redirect('solicitud/enviar');
// 			}
// 		}
// 		else
// 		{
// 			$this->session->set_flashdata('permission', 'error');
// 			redirect('inicio');
// 			$header['title'] = 'Error de Acceso';
// 			$this->load->view('template/erroracc',$header);
// 		}

//     }
// public function paso_3()//completada //a extinguir ver 1.03
//     {
//     	echo_pre('permiso para enviar solicitudes', __LINE__, __FILE__);//14
// 	    if($this->session->userdata('user') && ($this->dec_permiso->has_permission('alm', 14) || $this->dec_permiso->has_permission('alm', 9)))
// 	    {
// 	    	$view = $this->dec_permiso->parse_permission('', 'alm');
// 	    	if($_POST && $this->dec_permiso->has_permission('alm', 14))//recibe el formulario, Y debe terner el permiso para envios
// 	    	{
// 	    		$uri = $_POST['url'];
// 	    		unset($_POST['url']);
// 	    		echo_pre($_POST, __LINE__, __FILE__);
// 	    		// if($this->change_statusSol($_POST))
// 	    		if($this->model_alm_solicitudes->insert_solicitud($_POST))
// 	    		{
//     				$this->session->unset_userdata('articulos');
// 	    			$this->session->unset_userdata('id_carrito');
// 	    			$this->session->set_flashdata('send_solicitud', 'success');
// 	    			redirect($uri);
// 	    		}
// 	    		else
// 	    		{
// 	    			//esta mal
// 	    			$this->session->set_flashdata('send_solicitud','error');
// 	    			redirect($uri);
// 	    		}

// 	    	}
// 	    	else
// 	    	{
// 	    		if($_POST)//captura formularios sin permisos
// 	    		{
// 	    			echo_pre($_POST, __LINE__, __FILE__);
// 					$this->session->set_flashdata('permission', 'error');
// 	    			redirect($_POST['url']);
// 	    		}
// 	    		if($this->session->userdata('id_carrito'))//para la vista de solicitud propia (tercer paso)
// 	    		{
// 	    			$view['enviada']=FALSE;//error por aqui
// 	    		}
// 	    		else
// 	    		{
// 	    			$view['enviada']=TRUE;
// 	    		}
// 					// die_pre($view['alm'], __LINE__, __FILE__);
// 					$header = $this->dec_permiso->load_permissionsView();
// 			    	$header['title'] = 'Solicitud Guardada';
// 					$this->load->view('template/header', $header);
// 			    	// $this->load->view('alm_solicitudes/solicitudes_step3', $view);
// 			    	$this->load->view('alm_solicitudes/solicitudes_step3', $view);
// 			    	$this->load->view('template/footer');
// 	    	}
// 	    	// $view[''];
// 	    }
// 	    else
// 	    {
// 			$this->session->set_flashdata('permission', 'error');
// 			redirect('inicio');
// 	  //   	$header['title'] = 'Error de Acceso';
// 			// $this->load->view('template/erroracc',$header);
// 	    }
//     }
//////////////////////Fin de generacion de solicitudes////////////////
//     public function consultar_DepSolicitudes()//COMPLETADA//para ser reemplazada
//     {
// //    	echo_pre('permiso de ver solicitudes de departamento', __LINE__, __FILE__);//modulo=alm, func=3
//     	if($this->session->userdata('user') && ($this->dec_permiso->has_permission('alm', 3) || $this->dec_permiso->has_permission('alm', 11) || $this->dec_permiso->has_permission('alm', 14)))
// 		{
// 			$view = $this->dec_permiso->parse_permission('', 'alm');
// 			if($this->session->flashdata('solicitud_completada'))//al completar una solicitud, pasa por aqui otra vez para mostrar la ultima solicitud que acaba de ser "completada"
// 			{
// 				$view['solicitudes']=$this->model_alm_solicitudes->get_departamentoSolicitud();
// 				$view['solicitudes'] = array_merge($this->model_alm_solicitudes->get_depLastCompleted($user), $view['solicitudes']);
// 			}

// 			$view['solicitudes']=$this->model_alm_solicitudes->get_departamentoSolicitud();
// 			// die_pre($view['solicitudes'], __LINE__, __FILE__);
// 			$view['carritos'] = $this->model_alm_solicitudes->get_departamentoCarts();
// 			$view['usuarios'] = $this->model_alm_solicitudes->get_usersDepCartSol();
// 			foreach ($view['solicitudes'] as $key => $sol)
// 			{
// 				$articuloSol[$sol['nr_solicitud']]= $this->model_alm_solicitudes->get_solArticulos($sol);
// 			}
// 			foreach ($view['carritos'] as $key => $cart)
// 			{
// 				$articuloCart[$cart['id_carrito']]= $this->model_alm_solicitudes->get_cartArticulos($cart);
// 			}
// 			if(!empty($articuloSol))
// 			{
// 				$view['articulosSol']=$articuloSol;
// 			}
// 			if(!empty($articuloCart))
// 			{
// 				$view['articulosCart']=$articuloCart;
// 			}
// 			// die_pre($view, __LINE__, __FILE__);
// 			$header = $this->dec_permiso->load_permissionsView();
// 			$header['title'] = 'Solicitudes del departamento';
// 			$this->load->view('template/header', $header);
// 			$this->load->view('alm_solicitudes/solicitudes_lista', $view);
// 	    	$this->load->view('template/footer');
// 		}
// 		else
// 		{
// 			$this->session->set_flashdata('permission', 'error');
// 			redirect('inicio');
// 			// $header['title'] = 'Error de Acceso';
// 			// $this->load->view('template/erroracc',$header);
// 		}

//     }
    public function consultar_UsrSolicitudes()
    {
    	if($this->session->userdata('user'))
    	{
			$header = $this->dec_permiso->load_permissionsView();
			$header['title'] = 'Solicitudes de usuario';
			$this->load->view('template/header', $header);
			$this->load->view('alm_solicitudes/usuario_solicitudes');
	    	$this->load->view('template/footer');
    	}
		else
		{
			$header['title'] = 'Error de Acceso';
			$this->load->view('template/erroracc',$header);
		}
    }
    public function consultar_DepSolicitudes()//COMPLETADA
    {
    	if($this->session->userdata('user'))
    	{
			if($this->dec_permiso->has_permission('alm', 3))
			{
				$header = $this->dec_permiso->load_permissionsView();
				$header['title'] = 'Solicitudes del departamento';
				$this->load->view('template/header', $header);
				$this->load->view('alm_solicitudes/departamento_solicitudes');
		    	$this->load->view('template/footer');
			}
			else
			{
				$this->session->set_flashdata('permission', 'error');
				redirect('inicio');
			}
		}
		else
		{
			$header['title'] = 'Error de Acceso';
			$this->load->view('template/erroracc',$header);
		}
    }
/////////////////Administrador    TERMINADO NO TOCAR
    public function consultar_solicitudes()//Consulta de Administrador de Almacen y Autoridad [incompleta]//para ser reemplazada
    {
//    	echo_pre('permiso de vista de solicitudes', __LINE__, __FILE__);//modulo=alm, func=2 , func=12, func=13
    	if($this->session->userdata('user'))
    	{
	    	if(($this->dec_permiso->has_permission('alm', 2) || $this->dec_permiso->has_permission('alm', 12) || $this->dec_permiso->has_permission('alm', 13)))
			{
				$header = $this->dec_permiso->load_permissionsView();
				$header['title'] = 'Lista de Solicitudes';
				$this->load->view('template/header', $header);
				$this->load->view('alm_solicitudes/administrador_solicitudes');
		    	$this->load->view('template/footer');
			}
			else
			{
				if($this->dec_permiso->has_permission('alm', 3))
				{
					$header = $this->dec_permiso->load_permissionsView();
					$header['title'] = 'Lista de Solicitudes';
					$this->load->view('template/header', $header);
					$this->load->view('alm_solicitudes/departamento_solicitudes');
			    	$this->load->view('template/footer');
				}
				else
				{
					$this->session->set_flashdata('permission', 'error');
					redirect('inicio');
				}
			}
		}
		else
		{

				$header['title'] = 'Error de Acceso';
				$this->load->view('template/erroracc',$header);
		}

    }
//     public function consultar_solicitudes($field='', $order='', $aux='')//Consulta de Administrador de Almacen y Autoridad [incompleta]//para ser reemplazada
//     {
// //    	echo_pre('permiso de vista de solicitudes', __LINE__, __FILE__);//modulo=alm, func=2 , func=12, func=13
//     	if($this->session->userdata('user') && ($this->dec_permiso->has_permission('alm', 2) || $this->dec_permiso->has_permission('alm', 12) || $this->dec_permiso->has_permission('alm', 13)))
// 		{

// 			if(!is_array($this->session->userdata('query')))//verifica si hay alguna palabra de busqueda en session
// 			{
// 				$this->session->unset_userdata('query');//la elimino
// 			}
// 			// $this->session->unset_userdata('range');
// 			// echo_pre($this->session->userdata('range'));
// 			if($this->uri->segment(3)=='reiniciar')//verifico el enlace proveniente para reiniciar los valores de busqueda
// 			{
// 				$this->session->unset_userdata('range');//elimino rango de fechas
// 				$this->session->unset_userdata('query');//elimino palabra de busqueda
// 				redirect('administrador/solicitudes');//

// 			}
// //////////////probando algo que llamaria "pre-construccion parcial de la vista", util para reducir el uso de php en la vista
// 			$dependencia = $this->model_dec_dependencia->get_dependencia();//carga las dependencias para la busqueda por dependencias
// 			$aux1="<select name='id_dependencia' onchange='submit()'>";
//             $aux1=$aux1."<option value='' selected >--SELECCIONE--</option>";
// 			foreach ($dependencia as $dep):
// 	              $aux1=$aux1."<option value = '".$dep->id_dependencia."'>".$dep->dependen."</option>";
// 	        endforeach;
// 	        $view['dependencia']=$aux1."</select>";
// //////////////fin de probando algo que llamaria "pre-construccion parcial de la vista", util para reducir el uso de php en la vista
// 			// die_pre($view['dependencia']);
// 			if($field=='filtrar')//control para parametros pasados a la funcion, sin esto, no se ordenan los resultados de la busqueda
// 			{
// 				$field=$order;
// 				$order=$aux;
// 			}
// 			$per_page = 10;//uso para paginacion

// ///////////////////////////////////////Esta porcion de codigo, separa las URI de ordenamiento de resultados, de las URI de listado comun	
// 			if($this->uri->segment(3)=='filtrar'||$this->uri->segment(4)=='filtrar')//para saber si la "bandera de busqueda" esta activada
// 			{
// 				if(!is_numeric($this->uri->segment(4,0)))//para saber si la "bandera de ordenamiento" esta activada
// 				{
// 					$url = 'index.php/administrador/solicitudes/orden/filtrar/'.$field.'/'.$order.'/';//uso para paginacion
// 					$offset = $this->uri->segment(7, 0);//uso para consulta en BD
// 					$uri_segment = 7;//uso para paginacion
// 				}
// 				else
// 				{
// 					$url = 'index.php/administrador/solicitudes/filtrar/';//uso para paginacion
// 					$offset = $this->uri->segment(4, 0);//uso para consulta en BD
// 					$uri_segment = 4;//uso para paginacion
// 				}

// 			}
// 			else
// 			{
// 				if(isset($view['command'])){unset($view['command']);}
// 				$this->session->unset_userdata('command');
// 				if(!is_numeric($this->uri->segment(4,0)))
// 				{
// 					$url = 'index.php/administrador/solicitudes/orden/'.$field.'/'.$order.'/';//uso para paginacion
// 					$offset = $this->uri->segment(6, 0);//uso para consulta en BD
// 					$uri_segment = 6;//uso para paginacion
// 				}
// 				else
// 				{
// 					$url = 'index.php/administrador/solicitudes/';//uso para paginacion
// 					$offset = $this->uri->segment(3, 0);//uso para consulta en BD
// 					$uri_segment = 3;//uso para paginacion
// 				}

// 			}
// ///////////////////////////////////////Esta porcion de codigo, separa las URI de ordenamiento de resultados, de las URI de listado comun
			
// 			if(!empty($field))//verifica si se le ha pasado algun valor a $field, el cual indicara en funcion de cual columna se ordenara
// 			{
// 				switch ($field) //aqui se le "traduce" el valor, al nombre de la columna en la BD
// 				{
// 					case 'orden_sol': $field = 'nr_solicitud'; break;
// 					case 'orden_fecha': $field = 'fecha_gen'; break;
// 					case 'orden_gen': $field = 'apellido'; break;
// 					case 'orden_rol': $field = 'sys_rol'; break;
// 					case 'orden_stad': $field = 'alm_solicitud.status'; break;
// 					default: $field = ''; break;//en caso que no haya ninguna coincidencia, lo deja vacio
// 				}
// 			}
// 			$order = (empty($order) || ($order == 'asc')) ? 'desc' : 'asc';//aqui permite cambios de tipo "toggle" sobre la variable $order, que solo puede ser ascendente y descendente
// //////////////////////////Control para comandos, rango de fecha y demas (editable)
// 			if($_POST && $this->dec_permiso->has_permission('alm', 2))
// 			{
// 				// die_pre($_POST, __LINE__, __FILE__);
// 				// die_pre($this->session->all_userdata(), __LINE__, __FILE__);
// 				/////Control de comandos
// 					if($_POST['command']!='blah')
// 					{
// 						$view['command'] = $_POST['command'];
// 						switch ($_POST['command'])//para interpretar y guardar consulta del comando (para paginacion de resultados)
// 						{
// 							case 'find_usr':
// 								if(!empty($_POST['usuarios']))
// 								{
// 									$this->session->unset_userdata('query');
// 									$query['usuarios']=$_POST['usuarios'];
// 									$this->session->set_userdata('query', $query);
// 									// echo_pre($_POST['usuarios'], __LINE__, __FILE__);
// 								}
// 								break;
// 							case 'dep':
// 								if(!empty($_POST['id_dependencia']))
// 								{
// 									$this->session->unset_userdata('query');
// 									$query['id_dependencia']=$_POST['id_dependencia'];
// 									$this->session->set_userdata('query', $query);
// 									// echo_pre($_POST['id_dependencia'], __LINE__, __FILE__);
// 								}
// 								break;
// 							case 'status':
// 								if(!empty($_POST['status']))
// 								{
// 									$this->session->unset_userdata('query');
// 									$query['status']=$_POST['status'];
// 									$this->session->set_userdata('query', $query);
// 									// echo_pre($_POST['status'], __LINE__, __FILE__);
// 								}
// 								break;
							
// 							default:
// 								die_pre($_POST['command'], __LINE__, __FILE__);
// 								break;
// 						}
// 					}
// 					else
// 					{
						
// 						$this->session->unset_userdata('query');
// 					}
// 				/////fin de Control de comandos
// 				/////control de rango de fecha, para paginacion
// 					if($_POST['fecha']!='Fecha')
// 					{
// 						$this->load->helper('date');
// 						$view['fecha']=$_POST['fecha'];//uso para la vista (mantener el valor sobre el campo de la fecha)
// 						$this->session->set_userdata('range', $_POST['fecha']);//para guardar la busqueda y mantenerla con la paginacion
// 					///////////conversion de fechas, desde el string del campo 'fecha'	
// 						// $fecha=preg_split("'al '", $_POST['fecha']);
// 						// $desde=$fecha[0].' 00:00:00';
// 						// $hasta=$fecha[1].' 23:59:59';
// 						// $range['desde'] = $this->date_to_query($desde);
// 						// $range['hasta'] = $this->date_to_query($hasta);
// 					///////////fin de conversion de fechas, desde el string del campo 'fecha'
// 					}
// 					else
// 					{
// 						$this->session->unset_userdata('range');
// 					}
// 				/////fin de control de rango de fecha, para paginacion
// 					// echo_pre($this->session->all_userdata(), __LINE__, __FILE__);
// 					//die_pre($_POST);
// 					// $view['desde'] = $_POST['desde'];
// 					// $view['hasta'] = $_POST['hasta'];
// 					$view['command'] = $_POST['command'];
// 			}
// 			if($this->session->userdata('range')&&$this->dec_permiso->has_permission('alm', 2))
// 			{
// 				$fecha=preg_split("'al '", $this->session->userdata('range'));
// 				$desde=$fecha[0].' 00:00:00';
// 				$hasta=$fecha[1].' 23:59:59';
// 				$range['desde'] = $this->date_to_query($desde);
// 				$range['hasta'] = $this->date_to_query($hasta);
// 			}

// //////////////////////////FIN de Control para comandos, rango de fecha y demas (editable)
// 			if($this->uri->segment(3)=='filtrar'||$this->uri->segment(4)=='filtrar')//debido a que en la vista hay un pequeno formulario para el campo de busqueda, verifico si no se le ha pasado algun valor
// 			{
				
// 				if(!empty($range))
// 				{
// 					$view = array_merge($view, $this->comandos_deLista($field, $order, $per_page, $offset, $range['desde'], $range['hasta']));
// 				}
// 				else
// 				{
// 					$view = array_merge($view, $this->comandos_deLista($field, $order, $per_page, $offset));
// 				}
// 				// die_pre($view['solicitudes'], __LINE__, __FILE__);
// 				// $view['solicitudes'] = $this->model_alm_solicitudes->filtrar_solicitudes($field, $order, $per_page, $offset); //cargo la busqueda de los usuarios
// 				// $total_rows = $this->model_alm_solicitudes->count_filterSol($this->session->userdata('command'));//contabilizo la cantidad de resultados arrojados por la busqueda
// 				$total_rows=$view['total_rows'];
// 				unset($view['total_rows']);
// 				$config = initPagination($url,$total_rows,$per_page,$uri_segment); //inicializo la configuracion de la paginacion
// 				$this->pagination->initialize($config); //inicializo la paginacion en funcion de la configuracion
// 				$view['links'] = $this->pagination->create_links(); //se crean los enlaces, que solo se mostraran en la vista, si $total_rows es mayor que $per_page
// 				// die_pre($view);
// 			}
// 			else//en caso que no se haya captado ningun dato en el formulario(opcion de filtrado)
// 			{
// 				if(!empty($range))
// 				{
// 					$total_rows = $this->model_alm_solicitudes->get_adminCount($range['desde'], $range['hasta']);//uso para paginacion
// 					$view['solicitudes'] = $this->model_alm_solicitudes->get_activeSolicitudes($field,$order,$per_page, $offset, $range['desde'], $range['hasta']);
// 				}
// 				else
// 				{
// 					if($this->dec_permiso->has_permission('alm', 13) && !($this->dec_permiso->has_permission('alm', 2) || $this->dec_permiso->has_permission('alm', 12)))//para cargar solicitudes que esten aprobadas, solo para despachar
// 					{
// 						$status['alm_solicitud.status']='aprobado';
// 		    			$view['solicitudes'] = $this->model_alm_solicitudes->get_adminStaSolicitud($status, $field, $order, $per_page, $offset);
// 		    			$total_rows = $this->model_alm_solicitudes->count_adminStaSolicitud($status);
// 					}
// 					else
// 					{
// 						if($this->dec_permiso->has_permission('alm', 12) && !($this->dec_permiso->has_permission('alm', 2) || $this->dec_permiso->has_permission('alm', 13)))//para cargar solicitudes que esten en proceso, solo para aprobar
// 						{
// 							$status['alm_solicitud.status']='en_proceso';
// 			    			$view['solicitudes'] = $this->model_alm_solicitudes->get_adminStaSolicitud($status, $field, $order, $per_page, $offset);
// 			    			$total_rows = $this->model_alm_solicitudes->count_adminStaSolicitud($status);
// 						}
// 						else
// 						{
// 							if($this->dec_permiso->has_permission('alm', 12) && $this->dec_permiso->has_permission('alm', 12) && !$this->dec_permiso->has_permission('alm', 2))
// 							{
// 								$status['alm_solicitud.status']='x2';
// 				    			$view['solicitudes'] = $this->model_alm_solicitudes->get_adminStaSolicitud($status, $field, $order, $per_page, $offset);
// 				    			$total_rows = $this->model_alm_solicitudes->count_adminStaSolicitud($status);
// 							}
// 							else
// 							{
// 								$view['solicitudes'] = $this->model_alm_solicitudes->get_activeSolicitudes($field,$order,$per_page, $offset);
// 								$total_rows = $this->model_alm_solicitudes->get_adminCount();//uso para paginacion
// 							}
// 						}
// 					}
// 				}
// 				$config = initPagination($url,$total_rows,$per_page,$uri_segment);
// 				$this->pagination->initialize($config);
// 				$view['links'] = $this->pagination->create_links();//NOTA, La paginacion solo se muestra cuando $total_rows > $per_page
// 			}
// ////////////////////////////////////////////////////////////////////////////////////////////////////////
// 			// if(empty($view['solicitudes']))//si no hay solicitudes, redireccione con mensaje de error
// 			// {
// 			// 	$this->session->unset_userdata('range');
// 			// 	$this->session->unset_userdata('query');
// 			// 	$this->session->set_flashdata('solicitudes','error');
// 			// 	redirect('administrador/solicitudes');
// 			// }
// 			// else
// 			if(!empty($view['solicitudes']))
// 			{
// /////////carga de articulos de cada solicitud
// 				foreach ($view['solicitudes'] as $key => $sol)
// 				{
// 					$articulo[$sol['nr_solicitud']]= $this->model_alm_solicitudes->get_solArticulos($sol);
// 				}
// 				$view['articulos']= $articulo;
// /////////fin de carga de articulos de cada solicitud
// 			}
// /////////carga de todos los usuarios
// 			$view['act_users'] = $this->model_dec_usuario->get_user_activos();
// 			// die_pre($view, __LINE__, __FILE__);
// /////////fin de carga de todos los usuarios
// /////////carga de los usuarios que han recibido articulos de solicitudes
// 			$view['recibidos'] = $this->model_alm_solicitudes->get_recibidoUsers();
// 			// isSubArray_inArray($subArray, $array, $index, $key='')
// 			// die_pre($view['solicitudes'], __LINE__, __FILE__);
// 			// echo $view['recibidos'][$view['solicitudes']['']]
// /////////fin de carga de los usuarios que han recibido articulos de solicitudes
// /////////filtrado de permisos para las acciones de la vista
// 			$view['permits']=$this->dec_permiso->parse_permission('', 'alm');
// 			// echo_pre($view['permits']);
// /////////fin de filtrado de permisos para las acciones de la vista

// 			// die_pre($view, __LINE__, __FILE__);
// 			$view['order'] = $order;
// 			$header = $this->dec_permiso->load_permissionsView();
// 			$header['title'] = 'Lista de Solicitudes';
// 			$this->load->view('template/header', $header);
// 			$this->load->view('alm_solicitudes/administrador_lista', $view);
// 	    	$this->load->view('template/footer');
// 		}
// 		else
// 		{
// 			$this->session->set_flashdata('permission', 'error');
// 			redirect('inicio');
// 			$header['title'] = 'Error de Acceso';
// 			$this->load->view('template/erroracc',$header);
// 		}

//     }
    public function comandos_deLista($field='', $order='', $per_page='', $offset='', $desde='', $hasta='')
    {
    	switch (key($this->session->userdata('query'))) {
    		case 'usuarios':
    			// die_pre($this->session->userdata('query')['usuarios']);
    			$this->load->model("user/model_dec_usuario");
				// echo_pre($this->session->userdata('query'), __LINE__, __FILE__);
	    		$usr=$this->model_dec_usuario->buscar_usr($this->session->userdata('query')['usuarios']);//primero buscar si el usuario existe, y retornar su id
	    		$view['solicitudes'] = $this->model_alm_solicitudes->get_adminUser($usr[0]->id_usuario, $field, $order, $per_page, $offset, $desde, $hasta);//debo modificar para paginar
	    		$view['total_rows']= $this->model_alm_solicitudes->count_adminUser($usr[0]->id_usuario, $desde, $hasta);
	    		// die_pre($view);
	    		return($view);
    			break;
    		case 'id_dependencia':
    			// die_pre($this->session->userdata('query')['id_dependencia'], __LINE__, __FILE__);
    			$id=$this->session->userdata('query')['id_dependencia'];
    			$view['solicitudes'] = $this->model_alm_solicitudes->get_adminDepSolicitud($id, $field, $order, $per_page, $offset, $desde, $hasta);
    			$view['total_rows'] = $this->model_alm_solicitudes->count_adminDepSolicitud($id, $desde, $hasta);
    			return($view);
    			break;
    		case 'status':
    			// die_pre($this->session->userdata('query')['status']);
    			$status['alm_solicitud.status']=$this->session->userdata('query')['status'];
    			$view['solicitudes'] = $this->model_alm_solicitudes->get_adminStaSolicitud($status, $field, $order, $per_page, $offset, $desde, $hasta);
    			$view['total_rows'] = $this->model_alm_solicitudes->count_adminStaSolicitud($status, $desde, $hasta);
    			// die_pre($view);
    			return($view);
    			break;
    		
    		default:
    			return FALSE;
    			break;
    	}
    }

    public function completar_solicitud()//despachar solicitudes
    {
//    	echo_pre('permiso para despachar solicitudes', __LINE__, __FILE__);//modulo=alm, func=13
    	if($this->session->userdata('user') && ($this->dec_permiso->has_permission('alm', 13)))
		{
			if($_POST)
			{
				$solicitud=$_POST;
				if($this->model_alm_solicitudes->change_statusCompletado($solicitud))
				{
					$this->session->set_flashdata('solicitud_completada', 'success');
					redirect('solicitud/consultar');
				}
				else
				{
					$this->session->set_flashdata('solicitud_completada', 'error');
					redirect('solicitud/consultar');
				}
			}
		}
		else
		{
			$this->session->set_flashdata('permission', 'error');
			redirect('inicio');
			$header['title'] = 'Error de Acceso';
			$this->load->view('template/erroracc',$header);
		}
    }

//funciones y operaciones
////////agregar y quitar articulos de la session
    public function agregar_articulo()
    {
//    	echo_pre('permiso para generar solicitudes', __LINE__, __FILE__);//9
    	if($this->session->userdata('user') && ($this->dec_permiso->has_permission('alm', 9)))
		{
			if($_POST)
			{
				// die_pre($_POST['ID']." URI= ".$_POST['URI']);
				$articulo = $_POST['ID'];
				$aux = $this->session->userdata('articulos');
				if(empty($aux))
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
		}
		else
		{
			$this->session->set_flashdata('permission', 'error');
			redirect('inicio');
			$header['title'] = 'Error de Acceso';
			$this->load->view('template/erroracc',$header);
		}

    }
    public function quitar_articulo($nr_solicitud='')
    {
//    	echo_pre('permiso para edicion de solicitudes', __LINE__, __FILE__);//11
    	if($this->session->userdata('user') && ($this->dec_permiso->has_permission('alm', 9)||$this->dec_permiso->has_permission('alm', 11)))
		{
				// echo_pre($_POST['ID'], __LINE__, __FILE__);
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
			// }
		}
		else
		{
			$this->session->set_flashdata('permission', 'error');
			redirect('inicio');
			$header['title'] = 'Error de Acceso';
			$this->load->view('template/erroracc',$header);
		}
    }
////////fin de agregar y quitar articulos de la session
	public function eliminar_solicitud()//elimina los articulos de la solicitud en carrito
	{
		if($this->session->userdata('user') && ($this->dec_permiso->has_permission('alm', 9)||$this->dec_permiso->has_permission('alm', 11)))//edicion de solicitudes o generar solicitudes
		{
			if($_POST)
			{
				$uri = $_POST['uri'];
				$cart['id_carrito'] = $_POST['id_carrito'];
				$aux = $this->session->userdata('id_carrito');
				//verifico si el carrito que voy a anular es "mio" o de alguien mas, para desmontarlo de la session
				if(!empty($aux)&&($this->session->userdata('id_carrito')==$_POST['id_carrito']))
				{
					$this->session->unset_userdata('articulos');
					$this->session->unset_userdata('id_carrito');
				}
				// $cart['id_usuario'] = $_POST['id_usuario']; //para validar si solo el dueno puede eliminar la solicitud
				if($this->model_alm_solicitudes->delete_carrito($cart))//elimina el carrito, pasando los datos necesarios
				{
					$this->session->set_flashdata('cart_delete', 'success');
					redirect($uri);
				}
				else
				{
					$this->session->set_flashdata('cart_delete', 'error');
					redirect($uri);
				}
			}
		}
		else
		{
			$this->session->set_flashdata('permission', 'error');
			redirect('inicio');
			$header['title'] = 'Error de Acceso';
			$this->load->view('template/erroracc',$header);
		}
	}

	public function exist_solicitud() // para validar el numero de solicitud
	{
		$where['nr_solicitud'] = $this->input->post('nr');
		
		if($this->model_alm_solicitudes->exist($where))
		{
			$this->form_validation->set_message('exist_solicitud','<strong>Numero de Solicitud</strong> ya fue usado, intente nuevamente');
			return FALSE;
		}
		return TRUE;
	}
    
    public function updateUserCart()//actualiza la session desde la BD
    {
    	// $where = array('id_usuario'=>$this->session->userdata('user')['id_usuario'], 'status'=>'carrito');
    	$cart = $this->model_alm_solicitudes->get_userCart();
		if(!empty($cart))
		{
			$art = $cart['articulos'];
			$aux = $cart['id_carrito'];
			if($this->session->userdata('articulos'))
			{
				$this->session->unset_userdata('articulos');
			}
			if($this->session->userdata('id_carrito'))
			{
				$this->session->unset_userdata('id_carrito');
			}
			$this->session->set_userdata('articulos', $art);
			$this->session->set_userdata('id_carrito', $aux);
			// die_pre($this->session->all_userdata(), __LINE__, __FILE__);
		}
		else
		{
			$this->session->unset_userdata('articulos');
			$this->session->unset_userdata('id_carrito');
		}
    }
    public function editar_solicitud($id_carrito)//completada //ahora es editar carrito
    {
//    	echo_pre('permiso para editar solicitudes', __LINE__, __FILE__);//11
    	if($this->session->userdata('user') && ($this->dec_permiso->has_permission('alm', 9)||$this->dec_permiso->has_permission('alm', 11)||$this->model_alm_solicitudes->cart_isOwner($id_carrito)))
		{
			$view = $this->dec_permiso->parse_permission('', 'alm');
			if($_POST && ($this->dec_permiso->has_permission('alm', 11))|| ($id_carrito == $this->session->userdata('id_carrito')))
			{
				// echo_pre($this->uri->uri_string());
				// echo_pre($this->uri->segment(3));
				// die_pre($_POST, __LINE__, __FILE__);
				switch ($this->uri->segment(3))
				{
					case 'remover':
						$where['id_carrito']=$id_carrito;
						$where['id_articulo']=$_POST['id_articulo'];
						$this->model_alm_solicitudes->remove_art($where);//elimina el articulo de la solicitud
						if($id_carrito == $this->session->userdata('id_carrito'))//si la solicitud no ha sido enviada (esta en la session del usuario)
						{
							$this->updateUserCart();//actualiza el carrito de la session
						}
						redirect('solicitud/editar/'.$id_carrito);
					break;
					case 'agregar':
						$where['id_carrito']=$id_carrito;
						$where['id_articulo']=$_POST['id_articulo'];
						$this->model_alm_solicitudes->add_art($where);//agrega el articulo a la solicitud
						//$this->model_alm_solicitudes->remove_art($where);//elimina el articulo de la solicitud
						if($id_carrito == $this->session->userdata('id_carrito'))//si la solicitud no ha sido enviada (esta en la session del usuario)
						{
							$this->updateUserCart();//actualiza el carrito de la session
						}
						redirect('solicitud/editar/'.$id_carrito);
					break;
					
					default:
						$this->form_validation->set_error_delimiters('<div class="alert alert-danger">','</div>');
				    	$this->form_validation->set_message('required', '%s es Obligatorio');
				    	$this->form_validation->set_message('numeric', '%s Debe ser numerica');

			    		$i=0;
			    		while(!empty($_POST['ID'.$i]))
			    		{
			    			$this->form_validation->set_rules(('qt'.$i),('La <strong>Cantidad del Articulo '.($i+1).'</strong>'),'numeric|required');
			    			$i++;
			    		}

			    		if($this->form_validation->run($this))
						{
							// echo_pre($nr_solicitud, __LINE__, __FILE__);
							// die_pre($_POST, __LINE__, __FILE__);
				    		$i=0;
				    		while(!empty($_POST['ID'.$i]))
				    		{
				    			$where['id_carrito'] = $id_carrito;
				    			$where['id_articulo'] = $_POST['ID'.$i];
				    			$array['cant_solicitada'] = $_POST['qt'.$i];
				    			$this->model_alm_solicitudes->update_ByidArticulos($where, $array);
				    			$i++;
				    		}
							if(!empty($_POST['observacion']) && isset($_POST['observacion']))
							{
								$array['observacion'] = $_POST['observacion'];
								$this->model_alm_solicitudes->update_observacion($id_carrito, $_POST['observacion']);
							}
							if($id_carrito == $this->session->userdata('id_carrito'))//si es dueno de la solicitud
							{
								$this->updateUserCart();//actualiza el carrito de la session
								$this->session->set_flashdata('saved', 'success');
								redirect('solicitud/editar/'.$id_carrito);
							}
							$this->session->set_flashdata('saved', 'success');
							redirect('solicitud/consultar');

						}
					break;
				}
			}
			$view['nr']=$id_carrito;
			
			$aux = $this->model_alm_solicitudes->allDataCarrito($id_carrito);
			$view += $aux;
			$view['user'] = $this->model_dec_usuario->get_basicUserdata($aux['carrito']['id_usuario']);
			$view['id_articulos'] = $this->model_alm_solicitudes->get_carArticulos($id_carrito);//construye un arreglo de id de articulos en carrito
			$view['inventario'] = $this->model_alm_articulos->get_activeArticulos();
			// die_pre($view, __LINE__, __FILE__);
			$header = $this->dec_permiso->load_permissionsView();
			$header['title'] = 'Solicitud actual';
			$this->load->view('template/header', $header);
			$this->load->view('alm_solicitudes/solicitud_actual', $view);
	    	$this->load->view('template/footer');
		}
		else
		{
			$this->session->set_flashdata('permission', 'error');
			redirect('inicio');
			// $header['title'] = 'Error de Acceso';
			// $this->load->view('template/erroracc',$header);
		}
    }
    public function enviar_solicitud()//completada
    {
//    	echo_pre('permiso para enviar solicitudes', __LINE__, __FILE__);//14
	    if($this->session->userdata('user') && ($this->dec_permiso->has_permission('alm', 14) || $this->dec_permiso->has_permission('alm', 9)))
	    {
	    	$view = $this->dec_permiso->parse_permission('', 'alm');
	    	if($_POST && $this->dec_permiso->has_permission('alm', 14))//recibe el formulario, Y debe terner el permiso para envios
	    	{
                die_pre($_POST, __LINE__, __FILE__);
	    		$uri = $_POST['url'];
	    		unset($_POST['url']);
	    		// echo_pre($_POST, __LINE__, __FILE__);
	    		// if($this->change_statusSol($_POST))
	    		if($this->model_alm_solicitudes->insert_solicitud($_POST))
	    		{
    				$this->session->unset_userdata('articulos');
	    			$this->session->unset_userdata('id_carrito');
	    			$this->session->set_flashdata('send_solicitud', 'success');
	    			redirect($uri);
	    		}
	    		else
	    		{
	    			//esta mal
	    			$this->session->set_flashdata('send_solicitud','error');
	    			redirect($uri);
	    		}

	    	}
	    	else
	    	{
	    		if($_POST)//captura formularios sin permisos
	    		{
	    			// echo_pre($_POST, __LINE__, __FILE__);
					$this->session->set_flashdata('permission', 'error');
	    			redirect($_POST['url']);
	    		}
	    		if($this->session->userdata('id_carrito'))//para la vista de solicitud propia (tercer paso)
	    		{
	    			$view['enviada']=FALSE;//error por aqui
	    		}
	    		else
	    		{
	    			$view['enviada']=TRUE;
	    		}
					// die_pre($view['alm'], __LINE__, __FILE__);
					$header = $this->dec_permiso->load_permissionsView();
			    	$header['title'] = 'Solicitud Guardada';
					$this->load->view('template/header', $header);
			    	// $this->load->view('alm_solicitudes/solicitudes_step3', $view);
			    	$this->load->view('alm_solicitudes/solicitudes_step3', $view);
			    	$this->load->view('template/footer');
	    	}
	    	// $view[''];
	    }
	    else
	    {
			$this->session->set_flashdata('permission', 'error');
			redirect('inicio');
	  //   	$header['title'] = 'Error de Acceso';
			// $this->load->view('template/erroracc',$header);
	    }
    }
    public function change_statusSol($where='')
    {
    	return($this->model_alm_solicitudes->change_statusEn_proceso($where));
    }

    public function solicitud_steps()//voy por aqui 20-11-2015 (culminado) usado por la vista 'solicitudes_steps.php'
    {
    	if($this->input->post('cart'))//para construir los pasos del sistema
    	{
    		//verifico en la bd si hay algun carrito del usuario
    		$cart = $this->model_alm_solicitudes->get_userCart();
    		if($cart)
    		{
				$this->session->set_userdata('articulos', $cart['articulos']);
				$this->session->set_userdata('id_carrito', $cart['id_carrito']);
    			echo json_encode($cart);
    		}
    		else
    		{
    			$aux['false']=1;
    			echo json_encode($aux);
    		}
    	}
    	if($this->input->post('step2'))//para construir el paso 3   en esta area se guarda la solicitud en la base de datos
    	{
    		$post = $this->input->post('step2');
    		$observacion='';
    		if($post['observacion']!='')
    		{
    			$observacion = $post['observacion'];
    		}
    		unset($post['observacion']);
    		$aux = $this->model_alm_solicitudes->get_userCart();
    		if($aux)
    		{
    			$id_carrito = $aux['id_carrito'];
    			foreach ($post as $key => $value)
	    		{
	    			$contiene[] = array(
	    				'id_carrito'=>$id_carrito,
	    				'id_articulo'=>$key,
	    				'cant_solicitada'=>$value
	    				);
	    		}
	    		$update['observacion']= $observacion;
	    		$update['contiene'] = $contiene;
	    		$update['id_carrito'] = $id_carrito;
    			$check = $this->model_alm_solicitudes->update_carrito($update);
    		}
    		else
    		{
	    		$id_cart = $this->asignar_carrito();//numero de carrito
	    		foreach ($post as $key => $value)
	    		{
	    			$contiene[] = array(
	    				'id_carrito'=>$id_cart,
	    				'id_articulo'=>$key,
	    				'cant_solicitada'=>$value
	    				);
	    		}

	    		$carrito['id_usuario']=$this->session->userdata('user')['id_usuario'];
	    		$carrito['id_carrito'] = $id_cart;
	    		$carrito['observacion']=$observacion;
	    		$carrito['contiene'] = $contiene;
    			$check = $this->model_alm_solicitudes->insert_carrito($carrito);//guardo la solicitud en la BD
    		}

    		if($check)//reviso si fue almacenada exitosamente
    		{
    			$cart = $this->model_alm_solicitudes->get_userCart();
    			if ($cart)
    			{
    			    $this->session->set_userdata('articulos', $cart['articulos']);
    			    $this->session->set_userdata('id_carrito', $cart['id_carrito']);
    			}
    			$success = '<div class="alert alert-success"> Su solicitud ha sido guardada con &Eacute;xito. </div>';
    			echo($success);
    		}
    		else
    		{
    			$err='<div class="alert alert-danger">
                            Ocurri&oacute; un problema al guardar la solicitud.
                        </div>';
    			echo ($err);
    		}
    	}
    	if($this->input->get('session'))//para enviar por ajax datos en session
    	{
    		$this->updateUserCart();
    		$cart['id_carrito'] = $this->session->userdata('id_carrito');
    		$cart['articulos'] = $this->session->userdata('articulos');
    		echo json_encode($cart);
    	}
    	if($this->input->post('cancel'))//para cancelar la solicitud y volver al principio
    	{
    		$cart = $this->session->userdata('id_carrito');
    		if($this->model_alm_solicitudes->delete_carrito($cart))
    		{
	    		$this->updateUserCart();
	    		echo "success";
    		}
    		else
    		{
    			echo "error";
    		}
    	}
    	else
    	{
	    	if($this->input->post('update'))
	    	{
	    		$update = $this->input->post('update');
	    		if($update=='/clear')
	    		{
	    			// echo "desmontar de session";
	    			$this->session->unset_userdata('articulos');
	    		}
	    		else
	    		{
		    		$this->session->set_userdata('articulos', $this->input->post('update'));	
	    		}
		    	echo_pre($this->session->userdata('articulos'), __LINE__, __FILE__);
	    	}
	    	else
	    	{
	    		// $this->session->unset_userdata('articulos');//verificar si dano algos
	    	}
	    }
    }
    public function load_listStep2()//(culminado) usado por la vista 'solicitudes_steps.php'
    {
    	if($this->session->userdata('articulos'))
    	{
    		$items = $this->session->userdata('articulos');
			$list['aaData'] = array();
    		if(!is_array($items[0]))//precaucion
    		{
				$aux = $this->model_alm_articulos->get_articulo($items);
				// die_pre($aux);
				header('Content-type: application/json');
				$string='';
				foreach ($aux as $key => $value)
				{
					$string='';
					if($key==0)
					{
						$string='<script type="text/javascript">
							  	$(document).ready(function()
							  	{
							  		var intRegex = /^[1-9]?[0-9]*[0-9]$/;
							  		//script
							        $("input[type=\'numb\']").on("keyup change blur", function()
							        {
								      var aux = $("#msg_"+this.id.slice(2));
							          if(intRegex.test(this.value))
							          {
							          	console.log("paso la prueba");
								          if(parseInt(this.value) > parseInt(this.max))
								          {
								          	this.value = this.max;
											aux.html("El valor no puede ser mayor a "+this.max);
											aux.fadeIn(2000);
											aux.fadeOut(4000, "linear");
								          }
								          else
								          {
								          	if(parseInt(this.value) < parseInt(this.min))
								          	{
								          		this.value = "1";
												aux.html("El valor no puede ser menor a "+this.min);
												aux.fadeIn(2000);
												aux.fadeOut(4000, "linear");
								          	}
								          	else
								          	{
								          		console.log("normal");
								          	}
								          }
								      }
								      else
								      {
								      	this.value = "";
										aux.html("Solo puede usar numeros enteros");
										aux.fadeIn(2000);
										aux.fadeOut(4000, "linear");
								      }
							        });
							  	});
							</script>';
					}
					$list['aaData'][$key]['ID'] = '<div align="center">'.$aux[$key]->ID.'</div>';
					$list['aaData'][$key]['cod_articulo'] = '<div align="center">'.$aux[$key]->cod_articulo.'</div>';
					$list['aaData'][$key]['unidad'] = '<div align="center">'.$aux[$key]->unidad.'</div>';//para futuro, se puede incluir un select en esta variable para elegir el tipo de unidad que se desea del articulo
					$list['aaData'][$key]['descripcion'] = $aux[$key]->descripcion;
					$list['aaData'][$key]['agregar'] = $string.'<div align="center">
	                                                        <div class="col-xs-6"><input form="agrega" type="numb" max="999" min="1" class="form-control input-sm" id="qt'.$aux[$key]->ID.'" type="text" name="step2['.$aux[$key]->ID.']" style="width: -moz-available;"><span hidden id="msg_'.$aux[$key]->ID.'"class="label label-danger"style="width: -moz-available;"></span></div>
	                                                    </div>';
	                $list['aaData'][$key]['quitar'] = '<div align="center"><span id="clickable"><i id="row_'.$aux[$key]->ID.'" style="color:#D9534F" class="fa fa-minus"></i></span></div>';
	                // $list['aaData']['DT_RowId']= 'row_'.$aux[$key]->ID;
				}
				// die_pre($list);
				echo (json_encode($list));
			}
			else
			{
				header('Content-type: application/json');
				$list['aaData'][0]['ID'] = '';
				$list['aaData'][0]['cod_articulo'] = '';
				$list['aaData'][0]['unidad'] = '';
				$list['aaData'][0]['descripcion'] = '';
				$list['aaData'][0]['agregar'] = '';
				$list['aaData'][0]['quitar'] = '';
				echo (json_encode($list));
			}
    	}
    	else
    	{
    		$list['aaData'][0]['ID'] = '';
			$list['aaData'][0]['cod_articulo'] = '';
			$list['aaData'][0]['unidad'] = '';
			$list['aaData'][0]['descripcion'] = '';
			$list['aaData'][0]['agregar'] = '';
			$list['aaData'][0]['quitar'] = '';
			// $list['aaData']['DT_RowId']='';
    		echo (json_encode($list));
    	}
    }
    
    function date_to_query($fecha)
	{
		$this->load->helper('date');
	    $datestring = "%Y-%m-%d %H:%i:%s";
	    // $datestring = "%Y-%m-%d";
	    $fecha = str_replace("/", "-", $fecha);
	    // echo_pre(strtotime($fecha));
	    // echo_pre(unix_to_human(strtotime($fecha)));
	    $time = mdate($datestring, strtotime($fecha));
	    // die_pre($time);
	    return($time);
	}
    //Aqui esta la funcion donde vas a trabajar la aprobacion
    public function aprobar()
    {
//    	echo_pre('permiso para aprobar solicitudes', __LINE__, __FILE__);//12
        if($this->session->userdata('user') && ($this->dec_permiso->has_permission('alm', 12)))
        {
        	// echo_pre($_POST, __LINE__, __FILE__);
	        if($_POST)
	        {
                // die_pre($_POST, __LINE__, __FILE__);
	        	$where['nr_solicitud'] = $_POST['nr_solicitud'];
                //para aprobaciones en 0
                $aprobados = 0;
	        	foreach ($_POST['nuevos'] as $art => $cant)
	        	{
	        		if(!isset($_POST['usados'][$art]))
	        		{

	        		}
	        		$solicitud[] = array('nr_solicitud' => $_POST['nr_solicitud'], 
	        			'id_articulo' => $art, 
	        			'cant_aprobada' => $_POST['nuevos'][$art],
	        			'cant_nuevos' => $_POST['nuevos'][$art]);
                    $aprobados+=$_POST['nuevos'][$art];
	        	}
	        	// die_pre($aprobados, __LINE__, __FILE__);
                if($aprobados != 0)
                {
	        	  $this->model_alm_solicitudes->aprobar_solicitud($where, $solicitud);
                }
	        	redirect($_POST['uri']);
	        	// die_pre($array);
	        }
	    }
	    else
	    {
			$this->session->set_flashdata('permission', 'error');
			redirect('inicio');
	    	$header['title'] = 'Error de Acceso';
			$this->load->view('template/erroracc',$header);
	    }
    }

    public function anular()
    {
    	if($this->session->userdata('user') && $this->dec_permiso->has_permission('alm', 14))
    	{
            if($_POST)
            {
                // die_pre($_POST, __LINE__, __FILE__);
                $this->model_alm_solicitudes->anular_solicitud($_POST);
                redirect('solicitudes/almacen');
            }
    	}
    }

    public function despachar($nr_solicitud="")//a extinguir
    {
//    	echo_pre('permiso para despachar solicitudes', __LINE__, __FILE__);//13
    	//trata de que el $_POST tenga solo $_POST['nr_solicitud'] y $_POST['id_usuario']
        if($this->session->userdata('user') && ($this->dec_permiso->has_permission('alm', 13)))
        {
        	if($_POST)
        	{
        		$uri = $_POST['uri'];
        		unset($_POST['uri']);
        		$post = $_POST;
        		// die_pre($_POST, __LINE__, __FILE__);
        		$this->model_alm_solicitudes->completar_solicitud($post);
        		$this->session->set_flashdata('solicitud_completada', 'success');
        		redirect($uri);
        	}
        	else
        	{
        		redirect('solicitudes/almacen');
        	}
	    }
	    else
	    {
			$this->session->set_flashdata('permission', 'error');
			redirect('inicio');
	    	$header['title'] = 'Error de Acceso';
			$this->load->view('template/erroracc',$header);
	    }
    }
////////////////////////para migracion de datos de una tabla a otra
    public function migrar()
    {
    	if($this->session->userdata('user') && ($this->session->userdata('user')['id_usuario']=='17986853'))
    	{
	    	if($this->model_alm_solicitudes->migracion())
	    	{
	    		echo_pre('Migraci&oacute;n exitosa');
	    	}
	    	else
	    	{
	    		echo_pre('Error en migraci&oacute;n de datos');
	    	}
	    }
	    else
	    {

	    	$header['title'] = 'Error de Acceso';
			$this->load->view('template/erroracc',$header);
	    }
    }
    
////////////////////////cambios radicales sobre sistema ver 1.3
    public function generar_solicitud()
    {
    	if($this->session->userdata('user'))
    	{
    		if($this->dec_permiso->has_permission('alm', 9))
    		{
                $view = $this->dec_permiso->parse_permission('', 'alm');
				$header = $this->dec_permiso->load_permissionsView();
				$header['title'] = 'Generar solicitud';
				$this->load->view('template/header', $header);
				$this->load->view('solicitudes_steps', $view);
				$this->load->view('template/footer');

    		}
    		else
    		{
    			$this->session->set_flashdata('permission', 'error');
				redirect('inicio');
    		}
    	}
    	else
    	{
    		$header['title'] = 'Error de Acceso';
    		$this->load->view('template/erroracc',$header);
    	}
    }
    public function revisar_solicitud()//debe tener permiso para someter la solicitud a "en_proceso", solo recibe un POST
    {
    	//debo consultar el usuario propietario de la solicitud a revisar
    	if($this->session->userdata('user') && ($this->dec_permiso->has_permission('alm', 15)||$this->dec_permiso->has_permission('alm', 14)))
    	{
    		if($this->input->post())//capturo si viene de un formulario
    		{
                die_pre($this->input->post(), __LINE__, __FILE__);
    			if($this->model_alm_solicitudes->update_carrito($this->input->post()))//actualizo la observacion del carrito
    			{
    				$nr_solicitud = $this->model_alm_solicitudes->insert_solicitud($this->input->post('id_carrito'));//inserto la solicitud desde carrito
    				if($nr_solicitud)//valida
    				{
    					$aux = $this->input->post(NULL, TRUE);
    					$aux['nr_solicitud'] = $nr_solicitud;
    					echo_pre($aux, __LINE__, __FILE__);
    					//ahora debo guardar los motivos y desactivar los articulos cancelados de la revision de la solicitud
    					if($this->model_alm_solicitudes->edit_solicitud($aux))
						{
							$this->session->set_flashdata('revision', 'success');
							redirect('solicitud/consultar');
						}
						else
						{
							$this->session->set_flashdata('revision', 'error');
							redirect('solicitud/consultar');
						}
    					die_pre($this->input->post(NULL, TRUE), __LINE__, __FILE__);
    				}
    			}
    		}
    		else
    		{
    			redirect('solicitud/editar/'.$sol);
    		}
    	}
    	else
    	{
	    	$header['title'] = 'Error de Acceso';
			$this->load->view('template/erroracc',$header);
    		// respuesta de procedimiento (el usuario que genera la solicitud, no es quien la puede revisar)
    	}
    }
    // public function aprobar_solicitud()
    // {

    // }
    // public function despachar_solicitud()
    // {

    // }
    public function solicitudes_carrito($forWho='')
    {
    	/* Array of database columns which should be read and sent back to DataTables. Use a space where
    	 * you want to insert a non-database field (for example a counter or static image)
    	 */
		$aColumns = array('alm_carrito.id_carrito', 'alm_carrito.TIME', '', 'alm_carrito.observacion', '', '');
		// DB table to use
        $sTable = 'alm_carrito';

        // DataTable parameters
        $iDisplayStart = $this->input->get('iDisplayStart', true);
        $iDisplayLength = $this->input->get_post('iDisplayLength', true);
        $iSortCol_0 = $this->input->get_post('iSortCol_0', true);
        $iSortingCols = $this->input->get_post('iSortingCols', true);
        $sSearch = $this->input->get_post('sSearch', true);
        $sEcho = $this->input->get_post('sEcho', true);
    
        // Paging
        if(isset($iDisplayStart) && $iDisplayLength != '-1')
        {
            $this->db->limit($this->db->escape_str($iDisplayLength), $this->db->escape_str($iDisplayStart));
        }
        
        // Ordering
        if(isset($iSortCol_0))
        {
        	if($iSortCol_0!=2)//columna del usuario
        	{
	            for($i=0; $i<intval($iSortingCols); $i++)
	            {
	                $iSortCol = $this->input->get_post('iSortCol_'.$i, true);
	                $bSortable = $this->input->get_post('bSortable_'.intval($iSortCol), true);
	                $sSortDir = $this->input->get_post('sSortDir_'.$i, true);
	    
	                if($bSortable == 'true')
	                {
	                		$this->db->order_by($aColumns[intval($this->db->escape_str($iSortCol))], $this->db->escape_str($sSortDir));
	                }
	            }
        	}
        	else
        	{
        		$bSortable = $this->input->get_post('bSortable_2', true);
        		if($bSortable == 'true')
        		{
        			$this->db->order_by('nombre' , $this->db->escape_str($this->input->get_post('sSortDir_2', true)));
        		}
        	}
        }
        
        /* 
         * Filtering
         * NOTE this does not match the built-in DataTables filtering which does it
         * word by word on any field. It's possible to do here, but concerned about efficiency
         * on very large tables, and MySQL's regex functionality is very limited
         */
        if(isset($sSearch) && !empty($sSearch))
        {
            for($i=0; $i<count($aColumns); $i++)
            {
            	if($i!=2)//la tercera columna es del usuario que genero la solicitud
            	{

	                $bSearchable = $this->input->get_post('bSearchable_'.$i, true);
	                
	                // Individual column filtering
	                if(isset($bSearchable) && $bSearchable == 'true')
	                {
	                    	$this->db->or_like($aColumns[$i], $this->db->escape_like_str($sSearch));
	                }
	            }
	            else
	            {
	            	$bSearchable = $this->input->get_post('bSearchable_2', true);
	            	
	            	// Individual column filtering
	            	if(isset($bSearchable) && $bSearchable == 'true')
	            	{
		            	$this->db->or_like('nombre', $this->db->escape_like_str($sSearch));//para filtrar por: nombre del ususario que genero la solicitud
		            	$this->db->or_like('apellido', $this->db->escape_like_str($sSearch));//para filtrar por: apellido del usuario que genero la solicitud
		            	$this->db->or_like('alm_guarda.id_usuario', $this->db->escape_like_str($sSearch));//para filtrar por: cedula del usuario que genero la solicitud
		            	// if($dep!='dep')
		            	// {
		            	// 	$this->db->or_like('dependen', $this->db->escape_like_str($sSearch));//para filtrar por: nombre de la dependencia del usuario que genero la solicitud
		            	// }
		            }
	            }
            }
        }
        if($forWho=='dep')
        {
        	$this->db->where('dec_dependencia.id_dependencia', $this->session->userdata('user')['id_dependencia']);
        }
        if($forWho=='user')
        {
        	$this->db->where('alm_guarda.id_usuario', $this->session->userdata('user')['id_usuario']);
        }

        $this->db->join('alm_guarda', 'alm_guarda.id_carrito = alm_carrito.id_carrito');
        $this->db->join('dec_usuario', 'dec_usuario.id_usuario = alm_guarda.id_usuario');
        $this->db->join('dec_dependencia', 'dec_dependencia.id_dependencia = dec_usuario.id_dependencia');


        $this->db->select('SQL_CALC_FOUND_ROWS *, alm_carrito.observacion AS car_observacion', false);
		// Select Data
		$rResult = $this->db->get($sTable);
		// Data set length after filtering
        $this->db->select('FOUND_ROWS() AS found_rows');
        $iFilteredTotal = $this->db->get()->row()->found_rows;
    
        // Total data set length
        $iTotal = $this->db->count_all($sTable);
    	// $this->input->get('', true);
        // Output
        $output = array(
            'sEcho' => intval($sEcho),
            'iTotalRecords' => $iTotal,
            'iTotalDisplayRecords' => $iFilteredTotal,
            'aaData' => array()
        );
        $i=1+$iDisplayStart;
		foreach($rResult->result_array() as $aRow)//construccion a pie de los campos a mostrar en la lista, cada $row[] es una fila de la lista, y lo que se le asigna en el orden es cada columna
        {
            $row = array();
            $aux = '';

            $row[]= $i;
			// $row[]= '<td><span class="label label-warning">Solicitud sin enviar</span></td>';//segunda columna:: Solicitud
            $row[]= $aRow['TIME'];//tercera columna:: Fecha generada
            // $user = $this->model_dec_usuario->get_basicUserdata($aRow['usuario_ej']);
			if($forWho!='user')
			{
            	$row[]= $aRow['nombre'].' '.$aRow['apellido'];//cuarta columna:: Generada por:
            }
            $row[]= $aRow['car_observacion'];

///////////////////construye modal de articulos en solicitud
            $art = $this->model_alm_solicitudes->get_carArticulos($aRow['id_carrito']);
			$aux .= '<div id="cArt'.$aRow['ID'].'" class="modal modal-message modal-info fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
			                        <div class="modal-dialog">
			                            <div class="modal-content">
			                                <div class="modal-header">
			                                    <h4 class="modal-title">Detalles</h4>
			                                </div>
			                                <div class="modal-body">
			                                    <div>
			                                        <h4><label>Articulos en solicitud: 
			                                                 '.$aRow['id_carrito'].'
			                                            </label></h4>
			                                            <table id="item'.$aRow['ID'].'" class="table">
			                                                ';
			                                                	$aux.='<thead>
			                                                				<tr>
			                                                					<th><strong>Articulo</strong></th>
			                                                					<th><strong>Cantidad Solicitada</strong></th>

			                                                				</tr>
			                                                			<thead>
			                                                			<tbody>';
			                                                    foreach ($art as $key => $record)
			                                                    {
			                                                    	$aux.='<tr>
			                                                    				<td>'.$record['descripcion'].'</td>
			                                                    				<td>'.$record['cant_solicitada'].'</td>
			                                                    			</tr>';
			                                                    }
			                                                    
				                                                	$aux.='</tbody>';
			                                                    $aux=$aux.'
			                                            </table>
			                                    </div>

			                                    <div class="modal-footer">';    
			                                    if(isset($aRow['car_observacion']) && $aRow['car_observacion']!="")
			                                    {
			                                    	$aux.='<label class="control-label col-lg-2" for="observacion">Nota: </label>
				                                            <div class="col-lg-4" align="left">'.$aRow['car_observacion'].'</div>
				                                            <br>
				                                            <br>';
			                                    }
			                            		$aux.='</div>
			                                </div>
			                            </div>
			                        </div> 
			                    </div>';
///////////////////fin de modal de articulos en solicitud

            $row[]='<h4><a href="#cArt'.$aRow['ID'].'" data-toggle="modal" title="Muestra los articulos en la solicitud"><i class="glyphicon glyphicon-zoom-in color"></i></a></h4>'.$aux;//cuarta columna
            ///////se deben filtrar las acciones de acuerdo a los permisos
           	//acciones sobre solicitudes:
           	//								revisar
           	//								cancelar
           	//								Enviar

            $row[] = $this->_carActions($forWho, $aRow['id_carrito'], $aRow['car_observacion']);//acciones

            $output['aaData'][] = $row;
            $i++;
        }
    
        echo json_encode($output);

    }

    public function build_tables($forWho='')
    {
    	/* Array of database columns which should be read and sent back to DataTables. Use a space where
    	 * you want to insert a non-database field (for example a counter or static image)
    	 */
    	// <th>Solicitud</th>
    	// <th>Fecha generada</th>
    	// <th>Generada por:</th>
    	// <th>Revisada por:</th>
    	// <th>Estado actual</th>
    	// <th>Detalles</th>
    	// <th>Acciones</th>
    	$solStatus=array();
    	if($forWho=='admin')
    	{
    		// $aColumns = array('ID', 'cod_articulo', 'descripcion', 'exist', 'reserv', 'nuevos', 'usados', 'stock_min');
    		$aColumns = array('alm_solicitud.nr_solicitud', 'fecha_gen', '', 'dependen', 'alm_solicitud.status', '', '');
    		if($this->dec_permiso->has_permission('alm', 13))//permiso para despachar
    		{
    			$solStatus[]='aprobado';
    		}
    		if($this->dec_permiso->has_permission('alm', 12))//permiso para aprobar
    		{
    			$solStatus[]='en_proceso';
    		}
    		if($this->dec_permiso->has_permission('alm', 2))
    		{
    			$solStatus=1;
    		}
    	}
    	if($forWho=='user')
    	{
    		// $aColumns = array('ID', 'cod_articulo', 'descripcion', 'exist', 'reserv', 'nuevos', 'usados', 'stock_min');
			$aColumns = array('alm_solicitud.nr_solicitud', 'fecha_gen', '', 'alm_solicitud.status', '', '');
    	}
    	if($forWho=='dep')
    	{
    		// $aColumns = array('ID', 'cod_articulo', 'descripcion', 'exist', 'reserv', 'nuevos', 'usados', 'stock_min');
			$aColumns = array('alm_solicitud.nr_solicitud', 'fecha_gen', '', 'alm_solicitud.status', '', '');
    	}
        // DB table to use
        // $sTable = 'alm_articulo';//solicitudes
        $sTable = 'alm_solicitud';
        // $display = $this->model_alm_solicitudes->DataTable($this->input->get('', true), $aColumns, $sTable);

        $iDisplayStart = $this->input->get('iDisplayStart', true);
        $iDisplayLength = $this->input->get_post('iDisplayLength', true);
        $iSortCol_0 = $this->input->get_post('iSortCol_0', true);
        $iSortingCols = $this->input->get_post('iSortingCols', true);
        $sSearch = $this->input->get_post('sSearch', true);
        $sEcho = $this->input->get_post('sEcho', true);
    
        // Paging
        if(isset($iDisplayStart) && $iDisplayLength != '-1')
        {
            $this->db->limit($this->db->escape_str($iDisplayLength), $this->db->escape_str($iDisplayStart));
        }
        
        // Ordering
        if(isset($iSortCol_0))
        {
        	if($iSortCol_0!=2)//columna del usuario
        	{
	            for($i=0; $i<intval($iSortingCols); $i++)
	            {
	                $iSortCol = $this->input->get_post('iSortCol_'.$i, true);
	                $bSortable = $this->input->get_post('bSortable_'.intval($iSortCol), true);
	                $sSortDir = $this->input->get_post('sSortDir_'.$i, true);
	    
	                if($bSortable == 'true')
	                {
	                		$this->db->order_by($aColumns[intval($this->db->escape_str($iSortCol))], $this->db->escape_str($sSortDir));
	                }
	            }
        	}
        	else
        	{
        		$this->db->order_by('nombre' , $this->db->escape_str($this->input->get_post('sSortDir_0', true)));
        	}
        }
        
        /* 
         * Filtering
         * NOTE this does not match the built-in DataTables filtering which does it
         * word by word on any field. It's possible to do here, but concerned about efficiency
         * on very large tables, and MySQL's regex functionality is very limited
         */
        if(isset($sSearch) && !empty($sSearch))
        {
            $like='';
            $like .= '(';
            for($i=0; $i<count($aColumns); $i++)
            {
	            if($i==2)//la tercera columna es del usuario que genero la solicitud
	            {
                    $like .= 'OR dec_usuario.nombre LIKE "%'.$this->db->escape_like_str($sSearch).'%"
                    ';
                    $like .= 'OR dec_usuario.apellido LIKE "%'.$this->db->escape_like_str($sSearch).'%"
                    ';
                    $like .= 'OR dec_usuario.id_usuario LIKE "%'.$this->db->escape_like_str($sSearch).'%"
                    ';
                    $like .= 'OR dependen LIKE "%'.$this->db->escape_like_str($sSearch).'%"
                    ';
	            	// $this->db->or_like('dec_usuario.nombre', $this->db->escape_like_str($sSearch));//para filtrar por: nombre del ususario que genero la solicitud
	            	// $this->db->or_like('dec_usuario.apellido', $this->db->escape_like_str($sSearch));//para filtrar por: apellido del usuario que genero la solicitud
	            	// $this->db->or_like('dec_usuario.id_usuario', $this->db->escape_like_str($sSearch));//para filtrar por: cedula del usuario que genero la solicitud
	            	// $this->db->or_like('dependen', $this->db->escape_like_str($sSearch));//para filtrar por: nombre de la dependencia del usuario que genero la solicitud
	            }
            	else
            	{

	                $bSearchable = $this->input->get_post('bSearchable_'.$i, true);
	                
	                // Individual column filtering
	                if(isset($bSearchable) && $bSearchable == 'true')
	                {
	                	if($i==0)
	                	{
	                		// $this->db->or_like('alm_solicitud.status', 'en_proceso');
                            $like .= $aColumns[$i].' LIKE "%'.$this->db->escape_like_str($sSearch).'%"
                                ';
	                	}
	                	else
	                	{
                            // if($sSearch=='en proceso')
                            if(preg_match('/^en\s(proceso)?/', $sSearch))
                            {
                                $like .= 'OR alm_solicitud.status LIKE "en_proceso"
                                ';
                            }
                            else
                            {
                                $like .= 'OR '.$aColumns[$i].' LIKE "%'.$this->db->escape_like_str($sSearch).'%"
                                ';
                            }
	                    	// $this->db->or_like($aColumns[$i], $this->db->escape_like_str($sSearch));
	                	}
	                }
	            }
            }
            $like.=')';
        }
        
        $this->db->select('SQL_CALC_FOUND_ROWS *, alm_genera.ID AS hist_id, alm_solicitud.ID AS id, alm_solicitud.status AS solStatus, alm_solicitud.observacion AS sol_observacion', false);
        // Select Data
        if($forWho=='admin')
        {
        	// $this->db->join('alm_historial_s', 'alm_historial_s.nr_solicitud = alm_solicitud.nr_solicitud');
        }
        if($forWho=='user')
        {
        	$this->db->where('alm_genera.usuario_ej', $this->session->userdata('user')['id_usuario']);
        }
        if($forWho=='dep')
        {
        	$this->db->where('dec_usuario.id_dependencia', $this->session->userdata('user')['id_dependencia']);
        }
        if($this->input->get('fecha'))
        {
        	$rang = preg_split("/[' al ']+/", $this->input->get('fecha'));
			$mes = array('january', 'february', 'march', 'april', 'may', 'june', 'july', 'august', 'september', 'october', 'november', 'december');
			$date1 = preg_split("/['\/']+/", $rang[0]);
			$stringA = $date1[0].' '.$mes[((int)$date1[1])-1].' '.$date1[2].'00:00:00';

			$date2 = preg_split("/['\/']+/", $rang[1]);
			$stringB = $date2[0].' '.$mes[((int)$date2[1])-1].' '.$date2[2].'23:59:59';
	    	$this->db->where('alm_solicitud.fecha_gen >=', date('Y-m-d H:i:s',strtotime($stringA)));
			$this->db->where('alm_solicitud.fecha_gen <=', date('Y-m-d H:i:s',strtotime($stringB)));
        }
        if($this->input->get('articulo'))//para buscar articulo en solicitud
        {
        	$id_articulo = $this->input->get('articulo');
        	$this->db->join('alm_art_en_solicitud AS alm_contiene', 'alm_contiene.nr_solicitud=alm_solicitud.nr_solicitud AND alm_contiene.id_articulo="'.$id_articulo.'"', 'inner');
        	// $this->db->where('`id_articulo`', NULL, false);
        }
        // $this->db->select('SQL_CALC_FOUND_ROWS '.str_replace(' , ', ' ', implode(', ', $aColumns)), false);
        // if(($this->hasPermissionClassA() || $this->hasPermissionClassC) || $active==1)
        // {
        //     $this->db->where('ACTIVE', 1);
        // }
        // $this->db->select(' *, usados + nuevos + reserv AS exist, usados + nuevos AS disp', false);
		// $this->db->where('status_ej', 'carrito');//solo para traer a quien creo la solicitud
		if(is_array($solStatus) && isset($solStatus[0]))
		{
			$this->db->where_in('alm_solicitud.status', $solStatus);
		}
        if(isset($like))
        {
            $this->db->where($like);
        }
        $this->db->join('alm_historial_s AS alm_genera', 'alm_genera.nr_solicitud=alm_solicitud.nr_solicitud AND alm_genera.status_ej="carrito"', 'inner');
        $this->db->join('dec_usuario', 'dec_usuario.id_usuario=alm_genera.usuario_ej');
        $this->db->join('dec_dependencia', 'dec_dependencia.id_dependencia=dec_usuario.id_dependencia', 'inner');
        $this->db->group_by('alm_solicitud.nr_solicitud');
        
        $rResult = $this->db->get($sTable);
        // print_r($this->db->last_query());
        // Data set length after filtering
        $this->db->select('FOUND_ROWS() AS found_rows');
        $iFilteredTotal = $this->db->get()->row()->found_rows;
    
        // Total data set length
        $iTotal = $this->db->count_all($sTable);
        
        // Output
        $output = array(
            'sEcho' => intval($sEcho),
            'iTotalRecords' => $iTotal,
            'iTotalDisplayRecords' => $iFilteredTotal,
            'aaData' => array()
        );
        $i=1+$iDisplayStart;
        foreach($rResult->result_array() as $aRow)//construccion a pie de los campos a mostrar en la lista, cada $row[] es una fila de la lista, y lo que se le asigna en el orden es cada columna
        {
            $row = array();
            $i++;
            $aux = '';
            if($i==2+$iDisplayStart)
            {
            	$aux.='<script type="text/javascript">
						  	$(document).ready(function()
						  	{
						  		var intRegex = /^[1-9][0-9]*$/;
						  		//script
						        $("input[type=\'numb\']").on("keyup change blur focus", validation);

                                function validation(){
                                    if(intRegex.test(this.value))
                                    {
                                      if(parseInt(this.value) > parseInt(this.max))
                                      {
                                        this.value = this.max;
                                      }
                                      else
                                      {
                                        if(parseInt(this.value) < parseInt(this.min))
                                        {
                                            this.value = "0";
                                        }
                                      }
                                    }
                                    else
                                    {
                                    if($.isNumeric(this.value) || this.value ==="0")
                                    {
                                        while(this.value.length>this.max.length)
                                        {
                                            this.value = this.value.substring(1);
                                        }
                                        if(parseInt(this.value) > parseInt(this.max))
                                        {
                                            this.value = this.max;
                                        }
                                        else
                                        {
                                          this.value = "0";
                                        }
                                    }
                                    else
                                    {
                                        this.value = "0";
                                    }
                                    }
                                }

								$("button[id^=\'an\']").on("click", function(){
									aux=this.id.slice(2);
									console.log(aux);
									var input = $("#anula"+aux+" textarea").val();
									var msg = $("#anula"+aux+" #motivo_msg");
									console.log(msg);
									if(input.length===0)
									{
										console.log("error");
										msg.html("El motivo es obligatorio");
										return false;
									}
									else
									{
										msg.html("");
										$("#anula"+aux).submit();
									}
								});
						  	});
						</script>';
            }
            
            $row[]= '<div align="center">'.$aRow['nr_solicitud'].'</div>';//segunda columna:: Solicitud
            $row[]= '<div align="center">'.$aRow['fecha_gen'].'</div>';//tercera columna:: Fecha generada
            // $user = $this->model_dec_usuario->get_basicUserdata($aRow['usuario_ej']);
            $row[]= $aRow['nombre'].' '.$aRow['apellido'];//cuarta columna:: Generada por:
            if($forWho=='admin')
            {
            	$row[]= $aRow['dependen'];
            }
            switch ($aRow['solStatus'])//para usar labels en los estatus de la solicitud
            {
            	case 'carrito':
//            		$row[]= '<span class="label label-default">Sin enviar</span>';//Estado actual
                        $row[]= '<div align="center"><img src="'.base_url()."assets/img/alm/status/sin_enviar.png".'" title="Sin enviar" class="img-rounded" alt="bordes redondeados" width="35" height="30"></img></div>';
            	break;
            	case 'en_proceso':
//            		$row[]= '<span class="label label-default">En proceso</span>';//Estado actual
                        $row[]= '<div align="center"><img src="'.base_url()."assets/img/alm/status/process.png".'" title="En proceso" class="img-rounded" alt="bordes redondeados" width="35" height="30"></img></div>';
            	break;
            	case 'aprobado':
//            		$row[]= '<span class="label label-success">Aprobado</span>';//Estado actual
                        $row[]= '<div align="center"><img src="'.base_url()."assets/img/alm/status/aprobar.png".'" title="Solicitud aprobada" class="img-rounded" alt="bordes redondeados" width="35" height="30"></img></div>';
                break;
            	case 'enviado':
//            		$row[]= '<span class="label label-success">Enviado</span>';//Estado actual
                        $row[]= '<div align="center"><img src="'.base_url()."assets/img/alm/status/enviado.png".'" title="Solicitud enviada a almacén" class="img-rounded" alt="bordes redondeados" width="35" height="30"></img></div>';
            	break;
            	case 'retirado':
//            		$row[]= '<span class="label label-info">Retirado</span>';//Estado actual
                        $row[]= '<div align="center"><img src="'.base_url()."assets/img/alm/status/retirado.png".'" title="Artículos retirados de almacén" class="img-rounded" alt="bordes redondeados" width="35" height="30"></img></div>';
            	break;
            	case 'completado':
//            		$row[]= '<span class="label label-info">Completado</span>';//Estado actual
                        $row[]= '<div align="center"><img src="'.base_url()."assets/img/alm/status/completado.png".'" title="Solicitud Completada" class="img-rounded" alt="bordes redondeados" width="35" height="30"></img></div>';
            	break;
            	case 'cancelado':
//            		$row[]= '<span class="label label-default">Cancelado</span>';//Estado actual
                        $row[]= '<div align="center"><img src="'.base_url()."assets/img/alm/status/cancelado.png".'" title="Solicitud cancelada" class="img-rounded" alt="bordes redondeados" width="35" height="30"></img></div>';
            	break;
            	case 'anulado':
//            		$row[]= '<span class="label label-default">Anulado</span>';//Estado actual
            		$row[]= '<div align="center"><img src="'.base_url()."assets/img/alm/status/anulado.png".'" title="Solicitud anulada" class="img-rounded" alt="bordes redondeados" width="35" height="30"></img></div>';
	    // 			$aux.='<div id="anulado'.$refID.'" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
					// 					  <div class="modal-dialog modal-sm">
					// 					    <div class="modal-content">
					// 					      <div class="modal-header">
					// 					        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">X</button>
					// 					        <h4 class="modal-title">Motivo:</h4>
					// 					      </div>
					// 					      <div class="modal-body">                            
					// 					        <!-- Profile form -->
					// 					      </div>
					// 					    </div>
					// 					  </div>
					// 					</div>';
					// $aux.='<a href="#anulado'.$refID.'" data-toggle="modal" title="motivo de la anulacion"><i class="glyphicon glyphicon-remove color"></i></a>';
            	break;
            	case 'cerrado':
//            		$row[]= '<span class="label label-default">Cerrado</span>';//Estado actual
                        $row[]= '<div align="center"><img src="'.base_url()."assets/img/alm/status/cerrado.png".'" title="Solicitud cerrada" class="img-rounded" alt="bordes redondeados" width="35" height="30"></img></div>';
            	break;
            	
            	default:
            		$row[]= '<span class="label label-default">'.$aRow['solStatus'].'</span>';//Estado actual
//                        $row[]= '<div align="center"><img src="'.base_url()."assets/img/alm/status/cerrado.png".'" title="Solicitud cerrada" class="img-rounded" alt="bordes redondeados" width="35" height="30"></img></div>';
            	break;
            }
            $row[] = $aux.$this->_solDetails('', $aRow); //penúltima columna
            ///////se deben filtrar las acciones de acuerdo a los permisos
           	
            $row[] = $this->_solActions($forWho, $aRow['nr_solicitud']);//acciones Ultima columna

            $output['aaData'][] = $row;
        }
    
        echo json_encode($output);
    }
    private function _carActions($who, $refID='', $observacion='')
    {
    	if($who!='')
    	{
            //acciones sobre solicitudes: 'carrito','en_proceso','aprobado','enviado','completado','cancelado','anulado','cerrado'
            //                              revisar
            //                              cancelar
            //                              Enviar
            $articulos = $this->model_alm_solicitudes->get_cartArticulos($refID);
            $auxEnlaces='<h4><div align="center">';
            $auxModales='';
    		switch ($who)
    		{
    			case 'dep':
//////////////////////modal de revisar///
                    if($this->dec_permiso->has_permission('alm', 14))//si tiene el permiso para enviar
                    {
                        $auxModales .='<div id="revisar'.$refID.'" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                              <div class="modal-dialog modal-lg">
                                                <div class="modal-content">
                                                  <div class="modal-header">
                                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">X</button>
                                                    <h4 class="modal-title">Numero de solicitud '.$refID.'</h4>
                                                  </div>
                                                  <div class="modal-body">                    
                                                    <form class="form" id="envia'.$refID.'" name="aprueba" action="'.base_url().'index.php/solicitud/revisar" method="post"> 
                                                    <!-- Profile form -->
                                                    <div class="table-responsive">
                                                        <table id="tblGrid" class="table table-hover table-bordered table-condensed">
                                                            <thead>
                                                                  <tr>                                                        
                                                                    <th><div align="center">Item</div></th>
                                                                    <th><div align="center">Descripcion</div></th>
                                                                    <th><div align="center">Unidad</div></th>
                                                                    <th><div align="center">Solicitados</div></th>
                                                                    <th><divalign="center">Aprobar/Descartar</div></th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>';
                                                        foreach ($articulos as $i => $articulo)
                                                        {
                                                            $auxModales.='<tr>
                                                                        <td><div align="center">'.$articulo['id_articulo'].'</div></td>
                                                                        <td>'.$articulo['descripcion'].'</td>
                                                                        <td><div align="center">'.$articulo['unidad'].'</div></td>
                                                                        <td><div align="center">'.$articulo['cant'].'</div></td>
                                                                        <td><div align="center">'..'</div></td>
                                                                    </tr>';
                                                        }
                                                        $auxModales.='
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                    <div class="modal-footer">';
                                                    if(isset($observacion) && $observacion!='')
                                                    {
                                                        $auxModales.='<label class="control-label col-lg-2" for="observacion">Nota: </label>
                                                                <div class="col-lg-4" align="left"><textarea form="envia'.$refID.'">'.$observacion.'</textarea></div>
                                                                <br>
                                                                <br>';
                                                    }
                                                        $auxModales.='<input form="envia'.$refID.'" name="nr_solicitud" hidden value="'.$refID.'">
                                                            <input form="envia'.$refID.'" name="uri" hidden value="solicitudes/almacen">
                                                            <button form="envia'.$refID.'" type="submit" class="btn btn-success">Aprobar</button>
                                                    </div>
                                                    </form>
                                                  </div>
                                                </div>
                                              </div>
                                          </div>';
                        $auxEnlaces .='<a href="#revisar'.$refID.'" data-toggle="modal" title="Inicia el proceso para revisar y enviar la solicitud"><i class="glyphicon glyphicon-share color"></i></a>';
                    }
//////////////////////Fin de modal de revisar///
    				// $auxEnlaces .= '<a title="Inicia el proceso para revisar y enviar la solicitud"><i class="glyphicon glyphicon-share color"></i></a>';

    				$auxEnlaces .= '<a title="cancela la solicitud"><i class="glyphicon glyphicon-remove"></i></a>';
    			break;
    			
    			case 'user':
    				$auxEnlaces .= '<a title="Envia la solicitud"><i class="glyphicon glyphicon-share color"></i></a>';
                    $auxEnlaces .= '<a title="cancela la solicitud"><i class="glyphicon glyphicon-remove"></i></a>';
    			break;
    			
    			default:
    				$auxEnlaces .='blah';
    			break;
    		}
            $auxEnlaces.='</div></h4>';
            $aux = $auxEnlaces.$auxModales;
    		return($aux);
    	}
    	else
    	{
    		return('blah');
    	}
    }

    private function _solActions($who, $refID='')//acciones de la solicitud
    {
    	//$who solo puede ser "admin", "dep", y "user"
    	//$refID es la referencia de identidad del input que se realizara, o de los botones para las acciones
    	if($who!='')
    	{
    		// $row = array();
    		$auxEnlaces='';
    		$auxModales='';
    		$articulos = $this->model_alm_solicitudes->get_solArticulos($refID);
    		$act_users = $this->model_dec_usuario->get_user_activos();
    		$sol_status = $this->model_alm_solicitudes->get_solStatus($refID);
            $auxEnlaces .='<h4><div align="center">';
    		switch ($who)
    		{
    			case 'admin':
    			//acciones de administrador de almacen sobre solicitudes: 
    			//			Aprobar <a title="Inicia el proceso para aprobar la solicitud"><i class="glyphicon glyphicon-ok color"></i></a>
    			//			Despachar <a title="Inicia el proceso para aprobar la solicitud"><i class="glyphicon glyphicon-send color"></i></a>
    			//			Anular <a title="Inicia el proceso para aprobar la solicitud"><i class="glyphicon glyphicon-remove color"></i></a>
    			//			Cerrar <a title="Inicia el proceso para aprobar la solicitud"><i class="glyphicon glyphicon-ok color"></i></a>
                	// if($this->dec_permiso->has_permission('alm', 12)&&($sol_status=='aprobado'||$sol_status=='en_proceso'))
                	if($this->dec_permiso->has_permission('alm', 12)&&($sol_status=='en_proceso'))
                	{
//////////////////////modal de aprobar///
		    			$auxModales .='<div id="aprobar'.$refID.'" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		                                      <div class="modal-dialog modal-lg">
		                                        <div class="modal-content">
		                                          <div class="modal-header">
		                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">X</button>
		                                            <h4 class="modal-title">Numero de solicitud '.$refID.'</h4>
		                                          </div>
		                                          <div class="modal-body">                    
		                                            <form class="form" id="aprueba'.$refID.'" name="aprueba" action="'.base_url().'index.php/solicitud/aprobar" method="post"> 
		                                            <!-- Profile form -->
		                                            <div class="table-responsive">
		                                                <table id="tblGrid" class="table table-hover table-bordered table-condensed">
			                                                <thead>
			                                                      <tr>                                                        
			                                                        <th><div align="center">Item</div></th>
			                                                        <th><div align="center">Descripcion</div></th>
			                                                        <th><div align="center">Unidad</div></th>
			                                                        <th><div align="center">Solicitados</div></th>
			                                                        <th><div align="center">Disponibles</div></th>
			                                                        <th><div align="center">Aprobados</div></th>
			                                                        <th><div align="center">Por despachar</div></th>
			                                                    </tr>
			                                                </thead>
		                                                	<tbody>';
		                                                foreach ($articulos as $i => $articulo)
		                                                {
		                                                	$auxModales.='<tr>
				                                                        <td><div align="center">'.$articulo['id_articulo'].'</div></td>
				                                                        <td>'.$articulo['descripcion'].'</td>
				                                                        <td><div align="center">'.$articulo['unidad'].'</div></td>
				                                                        <td><div align="center">'.$articulo['cant'].'</div></td>
				                                                        <td><div align="center">'.$articulo['disp'].'</div></td>
				                                                        <td>
				                                                            <div align="center">
				                                                                <div class="col-xs-6"><input form="aprueba'.$refID.'" type="numb" max="'.($articulo['cant']>$articulo['disp'] ? $articulo['disp'] : $articulo['cant']).'" min="0" class="form-control input-sm" id="nuevos'.$refID.$articulo['id_articulo'].'" type="text" value="" name="nuevos['.$articulo['id_articulo'].']"></div>
				                                                            </div>
				                                                        </td>
				                                                        <td><div align="center">'.$articulo['reserv'].'</div></td>
				                                                    </tr>';
		                                                }
		                                                $auxModales.='
		                                                	</tbody>
		                                                </table>
		                                            </div>
		                                            <div class="modal-footer">
                                                            <input form="aprueba'.$refID.'" name="nr_solicitud" hidden value="'.$refID.'">
                                                            <input form="aprueba'.$refID.'" name="uri" hidden value="solicitudes/almacen">
		                                                    <button form="aprueba'.$refID.'" type="submit" class="btn btn-success">Aprobar</button>
		                                            </div>
		                                            </form>
		                                          </div>
		                                        </div>
		                                      </div>
		                                  </div>';
	                    $auxEnlaces .='<a href="#aprobar'.$refID.'" data-toggle="modal" title="Inicia el proceso para aprobar la solicitud"><i class="glyphicon glyphicon-ok color"></i></a>';
//////////////////////Fin de modal de aprobar///
	                }

	                if($this->dec_permiso->has_permission('alm', 13)&&($sol_status=='aprobado'))
	                {
//////////////////////modal de despachar///
	                	$auxModales .='<div id="despachar'.$refID.'" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		                                      <div class="modal-dialog modal-lg">
		                                        <div class="modal-content">
		                                          <div class="modal-header">
		                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">X</button>
		                                            <h4 class="modal-title">Numero de solicitud '.$refID.'</h4>
		                                          </div>
		                                          <div class="modal-body">                    
		                                            <!-- Profile form -->
		                                            <div class="table-responsive">
		                                                <table id="tblGrid" class="table table-hover table-bordered table-condensed">
			                                                <thead>
			                                                      <tr>                                                        
			                                                        <th><div align="center">Item</div></th>
			                                                        <th><div align="center">Descripcion</div></th>
			                                                        <!--<th><div align="center">Solicitados</div></th>-->
			                                                        <th><div align="center">Aprobados</div></th>
			                                                    </tr>
			                                                </thead>
		                                                	<tbody>';
		                                                foreach ($articulos as $i => $articulo)
		                                                {
		                                                	$auxModales.='<tr>
				                                                        <td><div align="center">'.$articulo['id_articulo'].'</div></td>
				                                                        <td>'.$articulo['descripcion'].'</td>
				                                                        <!--<td><div align="center">'.$articulo['cant'].'</div></td>-->
				                                                        <td><div align="center">'.$articulo['cant_aprob'].'</div></td>
				                                                    </tr>';
		                                                }
		                                                $auxModales.='
		                                                	</tbody>
		                                                </table>
		                                            </div>
		                                            <div class="modal-footer">                                                                                     
		                                                    <form class="form" id="despacha'.$refID.'" name="despacha" action="'.base_url().'index.php/solicitud/despachar" method="post"> 
                                                            </form>
                                                                <div class="form-group">
                                                                	<label class="control-label col-lg-4" for="recibido"><i class="color">*  </i>Entregado a:</label>
                                                                    <div class="col-lg-6">
                                                                        <select form="despacha'.$refID.'" class="form-control input select2" id="recibido" name="id_usuario" required>
                                                                        <option value="">--RECEPTOR DE LOS ARTICULOS--</option>';
                                                                        foreach ($act_users as $all)
                                                                        {
                                                                            $auxModales.='<option value="'.$all['id_usuario'].'">'.ucfirst($all['nombre']) . ' ' . ucfirst($all['apellido']).'</option>';
                                                                        }
                                                                    	$auxModales.='</select>	                                    
                                                                    </div>
                                                                </div>
		                                            </div>
		                                          </div>
		                                        </div>
		                                      </div>
		                                  </div>';
						$auxEnlaces .='<a href="#despachar'.$refID.'" data-toggle="modal" title="Inicia el proceso para despachar los articulos de la solicitud"><i class="glyphicon glyphicon-send color"></i></a>';
//////////////////////Fin de modal de despachar///
	                }
	                if($this->dec_permiso->has_permission('alm', 15)&&($sol_status=='aprobado' || $sol_status=='en_proceso'))
	                {
/////////////////////Modal de Anular solicitud///'carrito','en_proceso','aprobado','enviado','completado','cancelado','anulado','cerrado'
	                	$auxModales .='<div id="anular'.$refID.'" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		                                      <div class="modal-dialog modal-lg">
		                                        <div class="modal-content">
		                                          <div class="modal-header">
		                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">X</button>
		                                            <h4 class="modal-title">Numero de solicitud '.$refID.'</h4>
		                                          </div>
		                                          <div class="modal-body">                   
		                                            <form class="form" id="anula'.$refID.'" name="anula" action="'.base_url().'index.php/solicitud/anular" method="post"> 
		                                            <!-- Profile form -->
		                                            <div class="alert alert-warning" align="center">
		                                            Una vez anulada la solicitud, no ser&aacute; involucrada en ning&uacute;n otro proceso.
		                                            </div>
		                                            <div class="form-group">
		                                            	<label class="control-label col-lg-4" for="motivo">Motivo:</label>
		                                                <textarea form="anula'.$refID.'" align="center" class="form-control input-md" name="motivo" placeholder="Explique brevemente el motivo de la anulaci&oacute;n..."></textarea>
		                                                <span id="motivo_msg" class="label label-danger"></span>
		                                                <input hidden name="nr_solicitud" value="'.$refID.'"/>
		                                                <br>
		                                                <br>
		                                                <br>
		                                            </div>
		                                            <div class="modal-footer">
			                                            <button type="button" class="btn btn-default" data-dismiss="modal" aria-hidden="true">Cancelar</button>
			                                            <button id="an'.$refID.'" form="anula'.$refID.'" type="button" class="btn btn-primary">Anular</button>
		                                            </div>
		                                            </form>
		                                          </div>
		                                        </div>
		                                      </div>
		                                  </div>';
                        $auxEnlaces .='<a href="#anular'.$refID.'" data-toggle="modal" title="Anula la solicitud"><i class="glyphicon glyphicon-remove color"></i></a>';
	                	// $auxEnlaces .='<a class="clickable" id="anular'.$refID.'" data-toggle="modal" title="Anula la solicitud"><i class="glyphicon glyphicon-remove color"></i></a>';
/////////////////////Fin de Modal de Anular solicitud///
	                }
					if($this->dec_permiso->has_permission('alm', 16)&&($sol_status=='aprobado' || $sol_status=='en_proceso'))
					{
						$auxEnlaces .='<a href="#cerrar'.$refID.'" data-toggle="modal" title="Inicia el proceso para cerrar la solicitud"><i class="glyphicon glyphicon-trash color"></i></a>';
					}
    			break;
    			case 'dep':
    			//acciones del director de departamento sobre solicitudes:
    			//			Cancelar
    			//			Completar
    			//			Enviar
    				$auxEnlaces .='<h4><div align="center"><a title="Cancela la solicitud"><i class="glyphicon glyphicon-remove color"></i></a>
							<a title="Marca como recibido, los articulos de la solicitud"><i class="glyphicon glyphicon-ok color"></i></a>
							<a title="Inicia el proceso sobre el cual revisa y env&iacute;a la solicitud"><i class="glyphicon glyphicon-check color"></i></a></div></h4>
    						';
    				// $row[] = '<a title="Cancela la solicitud"><i class="glyphicon glyphicon-ok color"></i></a>';
    				// $row[] ='<a title="Marca como recibido, los articulos de la solicitud"><i class="glyphicon glyphicon-send color"></i></a>';
    				// $row[] = '<a title="Inicia el proceso sobre el cual revisa y env&iacute;a la solicitud"><i class="glyphicon glyphicon-remove color"></i></a>';
    			break;
    			case 'user':
    			//acciones de un usuario sobre solicitudes propias:
    			//			Cancelar
    			//			Completar
    			//			Enviar
    				$auxEnlaces .='<h4><div align="center"><a title="Cancela la solicitud"><i class="glyphicon glyphicon-ok color"></i></a>
							<a title="Marca como recibido, los articulos de la solicitud"><i class="glyphicon glyphicon-send color"></i></a>
							<a title="Inicia el proceso sobre el cual revisa y env&iacute;a la solicitud"><i class="glyphicon glyphicon-remove color"></i></a></div></h4>
    						';
    			break;
    			
    			default:
    				$auxEnlaces.='blah';
    			break;
    		}

            $auxEnlaces .='</div></h4>';
    		$aux = $auxModales.$auxEnlaces;
    		return($aux);
    	}
    	else
    	{
    		return('blah');
    	}
    }
    private function _solDetails($who='', $aRow)//detalles de la solicitud
    {
        $auxModales = '';
    	$auxEnlaces = '';
    	$auxEnlaces.= '<h4><div align="center">';

        $hist = $this->model_alm_solicitudes->get_solHistory($aRow['nr_solicitud']);
        $art = $this->model_alm_solicitudes->get_solArticulos($aRow['nr_solicitud']);
    	///construccion del modal para listar articulos en la solicitud
            $auxModales .= '<div id="art'.$aRow['id'].'" class="modal modal-message modal-info fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h4 class="modal-title">Detalles</h4>
                                </div>
                                <div class="modal-body">
                                    <div>
                                        <h4><label>Articulos en solicitud: 
                                                 '.$aRow['nr_solicitud'].'
                                            </label></h4>
                                            <table id="item'.$aRow['id'].'" class="table">
                                                ';
                                                    $auxModales.='<thead>
                                                                <tr>
                                                                    <th><strong>Articulo</strong></th>
                                                                    <th><strong>Unidad</strong></th>
                                                                    <th><strong>Cantidad solicitada</strong></th>';
                                                        if($aRow['solStatus']!='en_proceso' && $aRow['solStatus']!='cancelado' && $aRow['solStatus']!='anulado' && $aRow['solStatus']!='cerrado')
                                                        {
                                                            $auxModales.='<th><strong>Cantidad aprobada</strong></th>';
                                                        }
                                                        $auxModales.='</tr>
                                                            <thead>
                                                            <tbody>';
                                                    foreach ($art as $key => $record)
                                                    {
                                                        $auxModales.='<tr>
                                                                    <td>'.$record['descripcion'].'</td>
                                                                    <td>'.$record['unidad'].'</td>
                                                                    <td>'.$record['cant'].'</td>';
                                                        if($aRow['solStatus']!='en_proceso' && $aRow['solStatus']!='cancelado' && $aRow['solStatus']!='anulado' && $aRow['solStatus']!='cerrado')
                                                        {
                                                            $auxModales.='<td>'.$record['cant_aprob'].'</td>';
                                                        }
                                                        $auxModales.='</tr>';
                                                    }
                                                    
                                                        $auxModales.='</tbody>';
                                                    $auxModales=$auxModales.'
                                            </table>
                                    </div>

                                    <div class="modal-footer">';    
                                    if(isset($aRow['sol_observacion']) && $aRow['sol_observacion']!='')
                                    {
                                        $auxModales.='<label class="control-label col-lg-2" for="observacion">Nota: </label>
                                                <div class="col-lg-4" align="left">'.$aRow['sol_observacion'].'</div>
                                                <br>';
                                    }
                                    if(isset($aRow['motivo']) && $aRow['motivo']!='')
                                    {
                                        $auxModales.='<label class="control-label col-lg-2" for="observacion"><span class="label label-default">Motivo: </span></label>
                                                <div class="col-lg-4" align="left">'.$aRow['motivo'].'</div>
                                                <br>';
                                    }
                                    $auxModales.='</div>
                                </div>
                            </div>
                        </div> 
                    </div>';
            $auxEnlaces.= '<a href="#art'.$aRow['id'].'" data-toggle="modal" title="Muestra los articulos en la solicitud"><i class="glyphicon glyphicon-zoom-in color"></i></a>';
            ///construccion del modal para listar el historial de la solicitud
            $auxModales.= '<div id="hist'.$aRow['id'].'" class="modal modal-message modal-info fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h4 class="modal-title">Detalles</h4>
                                </div>
                                <div class="modal-body">
                                    <div>
                                        <h4><label>Historial de acciones sobre solicitud: 
                                                 '.$aRow['nr_solicitud'].'
                                            </label></h4>
                                            <table id="item'.$aRow['id'].'" class="table">
                                                ';
                                                    $auxModales.='<thead>
                                                                <tr>
                                                                    <th><strong>Accion realizada</strong></th>
                                                                    <th><strong>Por usuario</strong></th>
                                                                    <th><strong>En fecha</strong></th>
                                                                </tr>
                                                            <thead>
                                                            <tbody>';
                                                    foreach ($hist as $key => $record)
                                                    {
                                                        $histuser = $this->model_dec_usuario->get_basicUserdata($record['usuario_ej']);
                                                        $auxModales.='<tr>';
                                                                switch ($record['status_ej'])
                                                                {
                                                                    case 'carrito':
                                                                        $auxModales.= '<td><span class="label label-default">Cre&oacute; solicitud</span></td>';//Estado actual
                                                                    break;
                                                                    case 'en_proceso':
                                                                        $auxModales.= '<td><span class="label label-primary">Envi&oacute solicitud</span></td>';//Estado actual
                                                                    break;
                                                                    case 'aprobado':
                                                                        $auxModales.= '<td><span class="label label-success">Aprob&oacute; solicitud</span></td>';//Estado actual
                                                                    break;
                                                                    case 'enviado':
                                                                        $auxModales.= '<td><span class="label label-success">Envi&oacute; solicitud</span></td>';//Estado actual
                                                                    break;
                                                                    case 'retirado':
                                                                        $auxModales.= '<td><span class="label label-info">Retir&oacute; solicitud</span></td>';//Estado actual
                                                                    break;
                                                                    case 'completado':
                                                                        $auxModales.= '<td><span class="label label-info">Complet&oacute; solicitud</span></td>';//Estado actual
                                                                    break;
                                                                    case 'cancelado':
                                                                        $auxModales.= '<td><span class="label label-default">Cancel&oacute; solicitud</span></td>';//Estado actual
                                                                    break;
                                                                    case 'anulado':
                                                                        $auxModales.= '<td><span class="label label-default">Anul&oacute; solicitud</span></td>';//Estado actual
                                                                    break;
                                                                    case 'cerrado':
                                                                        $auxModales.= '<td><span class="label label-default">Cerr&oacute; solicitud</span></td>';//Estado actual
                                                                    break;
                                                                    
                                                                    default:
                                                                        $auxModales.= '<td><span class="label label-default">StatusSD</span></td>';//Estado actual
                                                                    break;
                                                                }
                                                                    //'<td><strong>'.$record['status_ej'].'</strong></td>';
                                                                    
                                                                $auxModales.='<td>'.$histuser['nombre'].' '.$histuser['apellido'].'</td>
                                                                    <td>'.$record['fecha_ej'].'</td>
                                                                </tr>';
                                                    }
                                                    $auxModales=$auxModales.'</tbody>
                                            </table>
                                    </div>

                                    <div class="modal-footer">
                                         
                                    </div>
                                </div>
                            </div>
                        </div> 
                    </div>';
            $auxEnlaces.= '<a href="#hist'.$aRow['id'].'" data-toggle="modal" title="Muestra el historial de la solicitud"><i class="glyphicon glyphicon-time color"></i></a>';
////////////////////////////////////////////////////////////Borrable, para pruebas sobre los atributos de datatable
                    // $auxModales.= '<div id="DT'.$aRow['id'].'" class="modal modal-message modal-info fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                    //     <div class="modal-dialog">
                    //         <div class="modal-content">
                    //             <div class="modal-header">
                    //                 <h4 class="modal-title">Detalles</h4>
                    //             </div>
                    //             <div class="modal-body">
                    //                 <div>
                    //                     <h4><label>Historial de acciones sobre solicitud: 
                    //                              '.$aRow['nr_solicitud'].'
                    //                         </label></h4>
                    //                         <table id="item'.$aRow['id'].'" class="table">
                    //                             <thead>';
                    //                                 foreach ($this->input->get() as $key => $val)
                    //                                 {
                    //                                  $auxModales.='<tr>
                    //                                              <th><strong>'.$key.'</strong></th>
                    //                                              <th><strong>:</strong></th>
                    //                                              <th><strong>'.$val.'</strong></th>
                    //                                          </tr>';
                    //                                 }
                    //                                 $auxModales.='</thead>
                    //                                      <tbody>';
                    //                                 $auxModales=$auxModales.'</tbody>
                    //                         </table>
                    //                 </div>

                    //                 <div class="modal-footer">
                                         
                    //                 </div>
                    //             </div>
                    //         </div>
                    //     </div> 
                    // </div>';
                    // $auxEnlaces.='<a href="#DT'.$aRow['id'].'" data-toggle="modal"><i class="glyphicon glyphicon-console color"></i></a>';
////////////////////////////////////////////////////////fin del borrable

    	$auxEnlaces.='</div></h4>';
    	$aux = $auxModales.$auxEnlaces;
    	return($aux);
    }
////////////////////////FIN de cambios radicales sobre sistema

    public function test_view()
    {
    	$header = $this->dec_permiso->load_permissionsView();
		$header['title'] = 'Prueba de vistas';
		$this->load->view('template/header', $header);

    	$this->load->view('administrador_solicitudes');
    	$this->load->view('departamento_solicitudes');
    	$this->load->view('usuario_solicitudes');
    	// $this->load->view('solicitudes_steps');

    	$this->load->view('template/footer');
    }

    public function test_sql()
    {
    	// $game = array();
    	// for ($i=1; $i <=55; $i++)//sacado de un juego
    	// {
    	// 	$game[$i]=array();
    	// 	$game[$i][] = 'numero del 1 al 9 = '.$i;
    	// 	$aux = $i * 3;
    	// 	$game[$i][] = 'multiplicado por 3 = '.$aux;
    	// 	$aux+= 3;
    	// 	$game[$i][] = 'sumandole 3 = '.$aux;
    	// 	$aux*= 3;
    	// 	$game[$i][] = 'multiplicado por 3 otra vez = '.$aux;
    	// 	$game[$i][] = array_sum(str_split($aux));
    	// }

    	$header = $this->dec_permiso->load_permissionsView();
		$header['title'] = 'Prueba de SQL';
		$this->load->view('template/header', $header);

		// $aColumns = array('alm_solicitud.nr_solicitud', 'fecha_gen', '', 'dependen', 'solStatus', '', '');
		// $sTable = 'alm_solicitud';
		// 			$this->db->or_like('nombre','l');//para filtrar por: nombre del ususario que genero la solicitud
	 //            	$this->db->or_like('apellido','l');//para filtrar por: apellido del usuario que genero la solicitud
	 //            	$this->db->or_like('id_usuario','l');//para filtrar por: cedula del usuario que genero la solicitud
	 //            	$this->db->or_like('dependen','l');//para filtrar por: nombre de la dependencia del usuario que genero la solicitud
		// $this->db->select(' *, alm_historial_s.ID AS hist_id, alm_solicitud.status AS solStatus, alm_solicitud.observacion AS sol_observacion', false);
		// $this->db->where('status_ej', 'carrito');//solo para traer a quien creo la solicitud
		//         $this->db->join('alm_historial_s', 'alm_historial_s.nr_solicitud=alm_solicitud.nr_solicitud');
		//         $this->db->join('dec_usuario', 'dec_usuario.id_usuario=alm_historial_s.usuario_ej');
		//         $this->db->join('dec_dependencia', 'dec_dependencia.id_dependencia=dec_usuario.id_dependencia');
		//         $this->db->group_by('alm_solicitud.nr_solicitud, hist_id');
		        
		//         $rResult = $this->db->get($sTable);
		// $this->db->select('FOUND_ROWS() AS found_rows');
		//         $iFilteredTotal = $this->db->get()->row()->found_rows;
		// $iTotal = $this->db->count_all($sTable);
		// echo_pre($rResult);
		// echo_pre($iFilteredTotal);
		// echo_pre($iTotal);
		$aColumns = array('alm_solicitud.nr_solicitud', 'alm_solicitud.fecha_gen', '', 'dependen', 'solStatus', '', '');

		$sTable = 'alm_solicitud';

		$this->db->select('SQL_CALC_FOUND_ROWS *, alm_genera.ID AS hist_id, alm_solicitud.status AS solStatus, alm_solicitud.observacion AS sol_observacion', false);

		// $input = '01/06/2016 al 30/06/2016';
		// $rang = preg_split("/[' al ']+/", $input);

		// $mes = array('january', 'february', 'march', 'april', 'may', 'june', 'july', 'august', 'september', 'october', 'november', 'december');
		// $date1 = preg_split("/['\/']+/", $rang[0]);
		// $stringA = $date1[0].' '.$mes[((int)$date1[1])-1].' '.$date1[2].'00:00:00';

		// $date2 = preg_split("/['\/']+/", $rang[1]);
		// $stringB = $date2[0].' '.$mes[((int)$date2[1])-1].' '.$date2[2].'23:59:59';
		// $desde = date('Y-m-d H:i:s',strtotime($stringA));
		// $hasta = date('Y-m-d H:i:s',strtotime($stringB));
		// echo "<br>".$desde;
		// echo "<br>".$hasta;
  //   	$this->db->where('alm_solicitud.fecha_gen >=', $desde);
		// $this->db->where('alm_solicitud.fecha_gen <=', $hasta);
		$sSearch='gabriel';
        for($i=0; $i<count($aColumns); $i++)
        {
            if($i==2)//la tercera columna es del usuario que genero la solicitud
            {
            	$this->db->or_like('nombre', $this->db->escape_like_str($sSearch));//para filtrar por: nombre del ususario que genero la solicitud
            	$this->db->or_like('apellido', $this->db->escape_like_str($sSearch));//para filtrar por: apellido del usuario que genero la solicitud
            	$this->db->or_like('id_usuario', $this->db->escape_like_str($sSearch));//para filtrar por: cedula del usuario que genero la solicitud
            	$this->db->or_like('dependen', $this->db->escape_like_str($sSearch));//para filtrar por: nombre de la dependencia del usuario que genero la solicitud
            }
        	else
        	{

                // $bSearchable = $this->input->get_post('bSearchable_'.$i, true);
                //'carrito','en_proceso','aprobado','enviado','completado','cancelado','anulado','cerrado'
                //'carrito','en_proceso','aprobado','enviado','retirado','completado','cancelado','anulado','cerrado'
                // Individual column filtering
                if(!($i==4 || $i==5 || $i==6))
                {
                    	$this->db->or_like($aColumns[$i], $this->db->escape_like_str($sSearch));
                }
            }
        }


        $status_ej=array('en_proceso','aprobado','enviado','retirado','completado','cancelado','anulado','cerrado');
		// $this->db->where_not_in('alm_historial_s.status_ej', $status_ej);
		// $this->db->where('alm_historial_s.status_ej', 'carrito');//solo para traer a quien creo la solicitud
		// $this->db->where('alm_genera.status_ej', 'carrito');//solo para traer a quien creo la solicitud
        $this->db->join('alm_historial_s AS alm_genera', 'alm_genera.nr_solicitud=alm_solicitud.nr_solicitud AND alm_genera.status_ej="carrito"', 'inner');
        $this->db->join('dec_usuario', 'dec_usuario.id_usuario=alm_genera.usuario_ej');
        $this->db->join('dec_dependencia', 'dec_dependencia.id_dependencia=dec_usuario.id_dependencia', 'inner');
        $this->db->group_by('alm_solicitud.nr_solicitud');
        
        $rResult = $this->db->get($sTable);
        echo_pre($rResult->result_array());
        echo_pre($this->db->last_query());
		// echo_pre($this->model_alm_solicitudes->get_solHistory('000000118'));
    	$this->load->view('template/footer');

    }
}