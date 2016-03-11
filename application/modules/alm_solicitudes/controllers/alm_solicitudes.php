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
    public function index()//sin usar todavia
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
    public function generar_solicitud($field='', $order='', $aux='')//para el listado del pasi 1 para generar solicitudes
    {
    	echo_pre('permiso para generar solicitud, crear carrito', __LINE__, __FILE__);//modulo=alm, func=9
    	if($this->session->userdata('user') && ($this->dec_permiso->has_permission('alm', 9)))//9
		{
			
			if(!$this->model_alm_solicitudes->get_userCart())
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
				// die_pre($header, __LINE__, __FILE__);
				$header = $this->dec_permiso->load_permissionsView();
				$header['title'] = 'Generar solicitud';
				$this->load->view('template/header', $header);
		    	// $this->load->view('alm_solicitudes/solicitudes_steps', $view);
		    	$this->load->view('alm_solicitudes/solicitudes_main', $view);
		    	$this->load->view('template/footer');
		    }
		    else
		    {

    			// die_pre('ya tiene una solicitud pendiente', __LINE__, __FILE__);
				$this->session->set_flashdata('Cart', 'true');
	    		redirect('solicitud/enviar');
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
    public function consultar_DepSolicitudes()//COMPLETADA
    {
    	echo_pre('permiso de ver solicitudes de departamento', __LINE__, __FILE__);//modulo=alm, func=3
    	if($this->session->userdata('user') && ($this->dec_permiso->has_permission('alm', 3) || $this->dec_permiso->has_permission('alm', 11) || $this->dec_permiso->has_permission('alm', 14)))
		{
			$view = $this->dec_permiso->parse_permission('', 'alm');
			if($this->session->flashdata('solicitud_completada'))//al completar una solicitud, pasa por aqui otra vez para mostrar la ultima solicitud que acaba de ser "completada"
			{
				$view['solicitudes']=$this->model_alm_solicitudes->get_departamentoSolicitud();
				$view['solicitudes'] = array_merge($this->model_alm_solicitudes->get_depLastCompleted($user), $view['solicitudes']);
			}

			$view['solicitudes']=$this->model_alm_solicitudes->get_departamentoSolicitud();
			// die_pre($view['solicitudes'], __LINE__, __FILE__);
			$view['carritos'] = $this->model_alm_solicitudes->get_departamentoCarts();
			$view['usuarios'] = $this->model_alm_solicitudes->get_usersDepCartSol();
			foreach ($view['solicitudes'] as $key => $sol)
			{
				$articuloSol[$sol['nr_solicitud']]= $this->model_alm_solicitudes->get_solArticulos($sol);
			}
			foreach ($view['carritos'] as $key => $cart)
			{
				$articuloCart[$cart['id_carrito']]= $this->model_alm_solicitudes->get_cartArticulos($cart);
			}
			if(!empty($articuloSol))
			{
				$view['articulosSol']=$articuloSol;
			}
			if(!empty($articuloCart))
			{
				$view['articulosCart']=$articuloCart;
			}
			// die_pre($view, __LINE__, __FILE__);
			$header = $this->dec_permiso->load_permissionsView();
			$header['title'] = 'Solicitudes del departamento';
			$this->load->view('template/header', $header);
			$this->load->view('alm_solicitudes/solicitudes_lista', $view);
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
/////////////////Administrador    TERMINADO NO TOCAR
    public function consultar_solicitudes($field='', $order='', $aux='')//Consulta de Administrador de Almacen y Autoridad [incompleta]
    {
    	echo_pre('permiso de vista de solicitudes', __LINE__, __FILE__);//modulo=alm, func=2 , func=12, func=13
    	if($this->session->userdata('user') && ($this->dec_permiso->has_permission('alm', 2) || $this->dec_permiso->has_permission('alm', 12) || $this->dec_permiso->has_permission('alm', 13)))
		{

			if(!is_array($this->session->userdata('query')))//verifica si hay alguna palabra de busqueda en session
			{
				$this->session->unset_userdata('query');//la elimino
			}
			// $this->session->unset_userdata('range');
			// echo_pre($this->session->userdata('range'));
			if($this->uri->segment(3)=='reiniciar')//verifico el enlace proveniente para reiniciar los valores de busqueda
			{
				$this->session->unset_userdata('range');//elimino rango de fechas
				$this->session->unset_userdata('query');//elimino palabra de busqueda
				redirect('administrador/solicitudes');//

			}
//////////////probando algo que llamaria "pre-construccion parcial de la vista", util para reducir el uso de php en la vista
			$dependencia = $this->model_dec_dependencia->get_dependencia();//carga las dependencias para la busqueda por dependencias
			$aux1="<select name='id_dependencia' onchange='submit()'>";
            $aux1=$aux1."<option value='' selected >--SELECCIONE--</option>";
			foreach ($dependencia as $dep):
	              $aux1=$aux1."<option value = '".$dep->id_dependencia."'>".$dep->dependen."</option>";
	        endforeach;
	        $view['dependencia']=$aux1."</select>";
//////////////fin de probando algo que llamaria "pre-construccion parcial de la vista", util para reducir el uso de php en la vista
			// die_pre($view['dependencia']);
			if($field=='filtrar')//control para parametros pasados a la funcion, sin esto, no se ordenan los resultados de la busqueda
			{
				$field=$order;
				$order=$aux;
			}
			$per_page = 10;//uso para paginacion

///////////////////////////////////////Esta porcion de codigo, separa las URI de ordenamiento de resultados, de las URI de listado comun	
			if($this->uri->segment(3)=='filtrar'||$this->uri->segment(4)=='filtrar')//para saber si la "bandera de busqueda" esta activada
			{
				if(!is_numeric($this->uri->segment(4,0)))//para saber si la "bandera de ordenamiento" esta activada
				{
					$url = 'index.php/administrador/solicitudes/orden/filtrar/'.$field.'/'.$order.'/';//uso para paginacion
					$offset = $this->uri->segment(7, 0);//uso para consulta en BD
					$uri_segment = 7;//uso para paginacion
				}
				else
				{
					$url = 'index.php/administrador/solicitudes/filtrar/';//uso para paginacion
					$offset = $this->uri->segment(4, 0);//uso para consulta en BD
					$uri_segment = 4;//uso para paginacion
				}

			}
			else
			{
				if(isset($view['command'])){unset($view['command']);}
				$this->session->unset_userdata('command');
				if(!is_numeric($this->uri->segment(4,0)))
				{
					$url = 'index.php/administrador/solicitudes/orden/'.$field.'/'.$order.'/';//uso para paginacion
					$offset = $this->uri->segment(6, 0);//uso para consulta en BD
					$uri_segment = 6;//uso para paginacion
				}
				else
				{
					$url = 'index.php/administrador/solicitudes/';//uso para paginacion
					$offset = $this->uri->segment(3, 0);//uso para consulta en BD
					$uri_segment = 3;//uso para paginacion
				}

			}
///////////////////////////////////////Esta porcion de codigo, separa las URI de ordenamiento de resultados, de las URI de listado comun
			
			if(!empty($field))//verifica si se le ha pasado algun valor a $field, el cual indicara en funcion de cual columna se ordenara
			{
				switch ($field) //aqui se le "traduce" el valor, al nombre de la columna en la BD
				{
					case 'orden_sol': $field = 'nr_solicitud'; break;
					case 'orden_fecha': $field = 'fecha_gen'; break;
					case 'orden_gen': $field = 'apellido'; break;
					case 'orden_rol': $field = 'sys_rol'; break;
					case 'orden_stad': $field = 'alm_solicitud.status'; break;
					default: $field = ''; break;//en caso que no haya ninguna coincidencia, lo deja vacio
				}
			}
			$order = (empty($order) || ($order == 'asc')) ? 'desc' : 'asc';//aqui permite cambios de tipo "toggle" sobre la variable $order, que solo puede ser ascendente y descendente
//////////////////////////Control para comandos, rango de fecha y demas (editable)
			if($_POST && $this->dec_permiso->has_permission('alm', 2))
			{
				// die_pre($_POST, __LINE__, __FILE__);
				// die_pre($this->session->all_userdata(), __LINE__, __FILE__);
				/////Control de comandos
					if($_POST['command']!='blah')
					{
						$view['command'] = $_POST['command'];
						switch ($_POST['command'])//para interpretar y guardar consulta del comando (para paginacion de resultados)
						{
							case 'find_usr':
								if(!empty($_POST['usuarios']))
								{
									$this->session->unset_userdata('query');
									$query['usuarios']=$_POST['usuarios'];
									$this->session->set_userdata('query', $query);
									// echo_pre($_POST['usuarios'], __LINE__, __FILE__);
								}
								break;
							case 'dep':
								if(!empty($_POST['id_dependencia']))
								{
									$this->session->unset_userdata('query');
									$query['id_dependencia']=$_POST['id_dependencia'];
									$this->session->set_userdata('query', $query);
									// echo_pre($_POST['id_dependencia'], __LINE__, __FILE__);
								}
								break;
							case 'status':
								if(!empty($_POST['status']))
								{
									$this->session->unset_userdata('query');
									$query['status']=$_POST['status'];
									$this->session->set_userdata('query', $query);
									// echo_pre($_POST['status'], __LINE__, __FILE__);
								}
								break;
							
							default:
								die_pre($_POST['command'], __LINE__, __FILE__);
								break;
						}
					}
					else
					{
						
						$this->session->unset_userdata('query');
					}
				/////fin de Control de comandos
				/////control de rango de fecha, para paginacion
					if($_POST['fecha']!='Fecha')
					{
						$this->load->helper('date');
						$view['fecha']=$_POST['fecha'];//uso para la vista (mantener el valor sobre el campo de la fecha)
						$this->session->set_userdata('range', $_POST['fecha']);//para guardar la busqueda y mantenerla con la paginacion
					///////////conversion de fechas, desde el string del campo 'fecha'	
						// $fecha=preg_split("'al '", $_POST['fecha']);
						// $desde=$fecha[0].' 00:00:00';
						// $hasta=$fecha[1].' 23:59:59';
						// $range['desde'] = $this->date_to_query($desde);
						// $range['hasta'] = $this->date_to_query($hasta);
					///////////fin de conversion de fechas, desde el string del campo 'fecha'
					}
					else
					{
						$this->session->unset_userdata('range');
					}
				/////fin de control de rango de fecha, para paginacion
					// echo_pre($this->session->all_userdata(), __LINE__, __FILE__);
					//die_pre($_POST);
					// $view['desde'] = $_POST['desde'];
					// $view['hasta'] = $_POST['hasta'];
					$view['command'] = $_POST['command'];
			}
			if($this->session->userdata('range')&&$this->dec_permiso->has_permission('alm', 2))
			{
				$fecha=preg_split("'al '", $this->session->userdata('range'));
				$desde=$fecha[0].' 00:00:00';
				$hasta=$fecha[1].' 23:59:59';
				$range['desde'] = $this->date_to_query($desde);
				$range['hasta'] = $this->date_to_query($hasta);
			}

//////////////////////////FIN de Control para comandos, rango de fecha y demas (editable)
			if($this->uri->segment(3)=='filtrar'||$this->uri->segment(4)=='filtrar')//debido a que en la vista hay un pequeno formulario para el campo de busqueda, verifico si no se le ha pasado algun valor
			{
				
				if(!empty($range))
				{
					$view = array_merge($view, $this->comandos_deLista($field, $order, $per_page, $offset, $range['desde'], $range['hasta']));
				}
				else
				{
					$view = array_merge($view, $this->comandos_deLista($field, $order, $per_page, $offset));
				}
				// die_pre($view['solicitudes'], __LINE__, __FILE__);
				// $view['solicitudes'] = $this->model_alm_solicitudes->filtrar_solicitudes($field, $order, $per_page, $offset); //cargo la busqueda de los usuarios
				// $total_rows = $this->model_alm_solicitudes->count_filterSol($this->session->userdata('command'));//contabilizo la cantidad de resultados arrojados por la busqueda
				$total_rows=$view['total_rows'];
				unset($view['total_rows']);
				$config = initPagination($url,$total_rows,$per_page,$uri_segment); //inicializo la configuracion de la paginacion
				$this->pagination->initialize($config); //inicializo la paginacion en funcion de la configuracion
				$view['links'] = $this->pagination->create_links(); //se crean los enlaces, que solo se mostraran en la vista, si $total_rows es mayor que $per_page
				// die_pre($view);
			}
			else//en caso que no se haya captado ningun dato en el formulario(opcion de filtrado)
			{
				if(!empty($range))
				{
					$total_rows = $this->model_alm_solicitudes->get_adminCount($range['desde'], $range['hasta']);//uso para paginacion
					$view['solicitudes'] = $this->model_alm_solicitudes->get_activeSolicitudes($field,$order,$per_page, $offset, $range['desde'], $range['hasta']);
				}
				else
				{
					if($this->dec_permiso->has_permission('alm', 13) && !($this->dec_permiso->has_permission('alm', 2) || $this->dec_permiso->has_permission('alm', 12)))//para cargar solicitudes que esten aprobadas, solo para despachar
					{
						$status['alm_solicitud.status']='aprobada';
		    			$view['solicitudes'] = $this->model_alm_solicitudes->get_adminStaSolicitud($status, $field, $order, $per_page, $offset);
		    			$total_rows = $this->model_alm_solicitudes->count_adminStaSolicitud($status);
					}
					else
					{
						if($this->dec_permiso->has_permission('alm', 12) && !($this->dec_permiso->has_permission('alm', 2) || $this->dec_permiso->has_permission('alm', 13)))//para cargar solicitudes que esten en proceso, solo para aprobar
						{
							$status['alm_solicitud.status']='en_proceso';
			    			$view['solicitudes'] = $this->model_alm_solicitudes->get_adminStaSolicitud($status, $field, $order, $per_page, $offset);
			    			$total_rows = $this->model_alm_solicitudes->count_adminStaSolicitud($status);
						}
						else
						{
							if($this->dec_permiso->has_permission('alm', 12) && $this->dec_permiso->has_permission('alm', 12) && !$this->dec_permiso->has_permission('alm', 2))
							{
								$status['alm_solicitud.status']='x2';
				    			$view['solicitudes'] = $this->model_alm_solicitudes->get_adminStaSolicitud($status, $field, $order, $per_page, $offset);
				    			$total_rows = $this->model_alm_solicitudes->count_adminStaSolicitud($status);
							}
							else
							{
								$view['solicitudes'] = $this->model_alm_solicitudes->get_activeSolicitudes($field,$order,$per_page, $offset);
								$total_rows = $this->model_alm_solicitudes->get_adminCount();//uso para paginacion
							}
						}
					}
				}
				$config = initPagination($url,$total_rows,$per_page,$uri_segment);
				$this->pagination->initialize($config);
				$view['links'] = $this->pagination->create_links();//NOTA, La paginacion solo se muestra cuando $total_rows > $per_page
			}
////////////////////////////////////////////////////////////////////////////////////////////////////////
			// if(empty($view['solicitudes']))//si no hay solicitudes, redireccione con mensaje de error
			// {
			// 	$this->session->unset_userdata('range');
			// 	$this->session->unset_userdata('query');
			// 	$this->session->set_flashdata('solicitudes','error');
			// 	redirect('administrador/solicitudes');
			// }
			// else
			if(!empty($view['solicitudes']))
			{
/////////carga de articulos de cada solicitud
				foreach ($view['solicitudes'] as $key => $sol)
				{
					$articulo[$sol['nr_solicitud']]= $this->model_alm_solicitudes->get_solArticulos($sol);
				}
				$view['articulos']= $articulo;
/////////fin de carga de articulos de cada solicitud
			}
/////////carga de todos los usuarios
			$view['act_users'] = $this->model_dec_usuario->get_user_activos();
			// die_pre($view, __LINE__, __FILE__);
/////////fin de carga de todos los usuarios
/////////carga de los usuarios que han recibido articulos de solicitudes
			$view['recibidos'] = $this->model_alm_solicitudes->get_recibidoUsers();
			// isSubArray_inArray($subArray, $array, $index, $key='')
			// die_pre($view['solicitudes'], __LINE__, __FILE__);
			// echo $view['recibidos'][$view['solicitudes']['']]
/////////fin de carga de los usuarios que han recibido articulos de solicitudes
/////////filtrado de permisos para las acciones de la vista
			$view['permits']=$this->dec_permiso->parse_permission('', 'alm');
			// echo_pre($view['permits']);
/////////fin de filtrado de permisos para las acciones de la vista

			// die_pre($view, __LINE__, __FILE__);
			$view['order'] = $order;
			$header = $this->dec_permiso->load_permissionsView();
			$header['title'] = 'Lista de Solicitudes';
			$this->load->view('template/header', $header);
			$this->load->view('alm_solicitudes/administrador_lista', $view);
	    	$this->load->view('template/footer');
		}
		else
		{
			$this->session->set_flashdata('permission', 'error');
			redirect('inicio');
			$header['title'] = 'Error de Acceso';
			$this->load->view('template/erroracc',$header);
		}

    }
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

    public function autorizar_solicitudes()//incompleta
    {
    	if($this->session->userdata('user') && ($this->dec_permiso->has_permission('alm', 12)))
		{
			$header['title']='Solicitudes para autorizar';
			$header = $this->dec_permiso->load_permissionsView();
			// die_pre($header, __LINE__, __FILE__);
			$header = $this->dec_permiso->load_permissionsView();
			$this->load->view('template/header', $header);
	    	echo "tears is how weakness leaves your body";
	    	$this->load->view('template/footer');
		}
		else
		{
			$this->session->set_flashdata('permission', 'error');
			redirect('inicio');
			$header['title'] = 'Error de Acceso';
			$this->load->view('template/erroracc',$header);
		}

    }
    public function completar_solicitud()//despachar solicitudes
    {
    	echo_pre('permiso para despachar solicitudes', __LINE__, __FILE__);//modulo=alm, func=13
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
    	echo_pre('permiso para generar solicitudes', __LINE__, __FILE__);//9
    	if($this->session->userdata('user') && ($this->dec_permiso->has_permission('alm', 9)))
		{
			if($_POST)
			{
				// die_pre($_POST['ID']." URI= ".$_POST['URI']);
				$articulo = $_POST['ID'];
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
    	echo_pre('permiso para edicion de solicitudes', __LINE__, __FILE__);//11
    	if($this->session->userdata('user') && ($this->dec_permiso->has_permission('alm', 9)||$this->dec_permiso->has_permission('alm', 11)))
		{
			// if()
			// {

			// }
			// else
			// {
				echo_pre($_POST['ID'], __LINE__, __FILE__);
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
	public function eliminar_solicitud()//elimina los articulos de la solicitud, y la cancela, liberando el valor del ID
	{
		if($this->session->userdata('user') && ($this->dec_permiso->has_permission('alm', 9)||$this->dec_permiso->has_permission('alm', 11)))//edicion de solicitudes o generar solicitudes
		{
			if($_POST)
			{
				$uri = $_POST['uri'];
				$cart['id_carrito'] = $_POST['id_carrito'];
				//verifico si el carrito que voy a anular es "mio" o de alguien mas, para desmontarlo de la session
				if(!empty($this->session->userdata('id_carrito'))&&($this->session->userdata('id_carrito')==$_POST['id_carrito']))
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
    public function confirmar_articulos()//solicitudes_step2.php
    {
    	echo_pre('permiso para generar solicitud', __LINE__, __FILE__);//9
    	if($this->session->userdata('user') && ($this->dec_permiso->has_permission('alm', 9)))
		{
			if(empty($this->session->userdata('articulos')[0]['descripcion']))
			{
				$aux = array();
				foreach ($this->session->userdata('articulos') as $key => $articulo)
				{
					array_push($aux, $articulo);
					// array_push($view['articulos'], $this->model_alm_articulos->get_articulo($articulo));
				}
				$id_cart = $this->asignar_carrito();
				$view['articulos'] = $this->model_alm_articulos->get_articulo($aux);//cambio la funcion a "result_array()"
				// echo_pre($view['articulos'], __LINE__, __FILE__);
				if($_POST)
				{
					// die_pre($_POST, __LINE__, __FILE__);
					$this->form_validation->set_error_delimiters('<div class="alert alert-danger">','</div>');
			    	$this->form_validation->set_message('required', '%s es Obligatorio');
			    	$this->form_validation->set_message('numeric', '%s Debe ser numerica');
					// $this->form_validation->set_rules('nr','<strong>Numero de Solicitud</strong>','callback_exist_solicitud');

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
								'id_carrito'=>$id_cart,
								'id_articulo'=>$_POST['ID'.$i],
								// 'NRS'=>$_POST['nr'],
								//'nr_solicitud'=>$_POST['nr'],/////revisar
								'cant_solicitada'=>$_POST['qt'.$i]
								);
							$i++;
						}
						$carrito['id_usuario']=$this->session->userdata('user')['id_usuario'];
						// $solicitud['nr_solicitud']=$_POST['nr'];
						$carrito['id_carrito'] = $id_cart;
						$carrito['observacion']=$_POST['observacion'];
						// $this->load->helper('date');
						// $datestring = "%Y-%m-%d %H:%i:%s";
						// $time = time();
						// $carrito['fecha_gen'] = mdate($datestring, $time);
						$carrito['contiene'] = $contiene;
						// die_pre($carrito, __LINE__, __FILE__);
						$check = $this->model_alm_solicitudes->insert_carrito($carrito);
						if($check!= FALSE)
						{
							$this->session->unset_userdata('articulos');
							// $where = array('id_usuario'=> $this->session->userdata('user')['id_usuario'], 'status'=>'carrito');
							$where = array('id_usuario'=> $this->session->userdata('user')['id_usuario']);

							// if($this->model_alm_solicitudes->exist($where))
							// {
								// die_pre($where, __LINE__, __FILE__);
/**/							$cart = $this->model_alm_solicitudes->get_userCart();
								if($cart)
								{
									// die_pre($cart, __LINE__, __FILE__);
									$this->session->set_userdata('articulos', $cart['articulos']);
									$this->session->set_userdata('id_carrito', $cart['id_carrito']);
								}
							// }
							$this->session->set_flashdata('create_solicitud','success');
							redirect('solicitud/enviar');
						}
						else
						{
							$this->session->set_flashdata('create_solicitud','error');
							redirect('solicitud/confirmar');
						}

		    		}
		    		else
		    		{
						// die_pre($header, __LINE__, __FILE__);
						$header = $this->dec_permiso->load_permissionsView();
				    	$header['title'] = 'Generar solicitud - Paso 2';
						$this->load->view('template/header', $header);
				    	$this->load->view('alm_solicitudes/solicitudes_step2', $view);
				    	$this->load->view('template/footer');
		    		}
				}
				else
				{
					// die_pre($header, __LINE__, __FILE__);
					$header = $this->dec_permiso->load_permissionsView();
			    	$header['title'] = 'Generar solicitud - Paso 2';
					$this->load->view('template/header', $header);
			    	$this->load->view('alm_solicitudes/solicitudes_step2', $view);
			    	$this->load->view('template/footer');
			    }
			}
			else
			{
	    		redirect('solicitud/enviar');
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
    public function updateUserCart()//actualiza desde la BD
    {
    	// $where = array('id_usuario'=>$this->session->userdata('user')['id_usuario'], 'status'=>'carrito');
    	$cart = $this->model_alm_solicitudes->get_userCart();
		if(!empty($cart))
		{
			$art = $cart['articulos'];
			$aux = $cart['id_carrito'];
			$this->session->unset_userdata('articulos');
			$this->session->unset_userdata('id_carrito');
			$this->session->set_userdata('articulos', $art);
			$this->session->set_userdata('id_carrito', $aux);
		}
		else
		{
			$this->session->unset_userdata('articulos');
			$this->session->unset_userdata('nr_solicitud');
		}
    }
    public function editar_solicitud($id_carrito)//completada //ahora es editar carrito
    {
    	echo_pre('permiso para editar solicitudes', __LINE__, __FILE__);//11
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
			$view = $aux;
			$view['user'] = $this->model_dec_usuario->get_basicUserdata($aux['carrito']['id_usuario']);
			$view['id_articulos'] = $this->model_alm_solicitudes->get_carArticulos($id_carrito);//construye un arreglo de id de articulos en carrito
			$view['inventario'] = $this->model_alm_articulos->get_activeArticulos();
			// die_pre($header, __LINE__, __FILE__);
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
    	echo_pre('permiso para enviar solicitudes', __LINE__, __FILE__);//14
	    if($this->session->userdata('user') && ($this->dec_permiso->has_permission('alm', 14) || $this->dec_permiso->has_permission('alm', 9)))
	    {
	    	$view = $this->dec_permiso->parse_permission('', 'alm');
	    	if($_POST && $this->dec_permiso->has_permission('alm', 14))//recibe el formulario, Y debe terner el permiso para envios
	    	{
	    		$uri = $_POST['url'];
	    		unset($_POST['url']);
	    		echo_pre($_POST, __LINE__, __FILE__);
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
	    			echo_pre($_POST, __LINE__, __FILE__);
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
    public function get_solicitudHist()
    {


    }
    public function change_statusSol($where='')
    {
    	return($this->model_alm_solicitudes->change_statusEn_proceso($where));
    }

    public function solicitud_steps()//voy por aqui 20-11-2015
    {
    	if($this->input->post('step1'))//para construir el paso 2
    	{
    		//agregar_articulo() agrega sobre la session (cookie)
    		$items = $this->input->post('step1');
    		$aux = $this->model_alm_articulos->get_articulo($items);
    		foreach ($aux as $key => $value)
    		{
    			$list[$key]['ID'] = $aux[$key]['ID'];
    			$list[$key]['cod_articulo'] = $aux[$key]['cod_articulo'];
    			$list[$key]['descripcion'] = $aux[$key]['descripcion'];
    			$list[$key]['Agregar'] = 'X';
    		}
			echo_pre($aux, __LINE__, __FILE__);

			header('Content-type: application/json');
			echo (json_encode($aux));
    	}
    	if($this->input->post('desperate'))//para construir el paso 2
    	{
    		//agregar_articulo() agrega sobre la session (cookie)
    		$items = $this->input->post('step1');
    		$aux = $this->model_alm_articulos->get_articulo($items);
			// echo_pre($aux, __LINE__, __FILE__);
    		$list = '<table class="table">
                            <thead>
                            <tr>
                              <th>Articulo</th>
                              <th>Descripcion</th>
                              <th>Cantidad</th>
                            </tr>
                            </thead>
                            <tbody>';
            foreach ($aux as $key => $value)
    		{
    			$list=$list.'<tr> 
    							<td>'.$aux[$key]['cod_articulo'].'</td>
    							<td>'.$aux[$key]['descripcion'].'</td>
    							<td>'.'<div><input class="cant input-sm col-sm-2" disabled type="text" id="cant_'.$aux[$key]['cod_articulo'].'" value="0"></div>'.'</td>
    						</tr>';
    		}
    		$list = $list.'</tbody>
    		<script type="text/javascript">
	    		$(function(){
				    console.log($(".cant").lenght);
				    		});
    		</script>';
    		echo $list;
			// echo (json_encode($list));
    	}
    	else
    	{
	    	if($this->input->post('step2'))
	    	{
	    		
	    	}
	    	else
	    	{
		    	if($this->input->post('update'))
		    	{
		    		if(empty($this->input->post('update')))
		    		{
		    		}
		    		else
		    		{
			    		$this->session->set_userdata('articulos', $this->input->post('update'));	
		    		}
			    	echo_pre($this->session->userdata('articulos'), __LINE__, __FILE__);
		    	}
		    	else
		    	{
		    		$this->session->unset_userdata('articulos');
		    	}
		    }
	    }
    }
    public function load_listStep2()
    {
    	$items = $this->session->userdata('articulos');
		$aux = $this->model_alm_articulos->get_articulo($items);
		header('Content-type: application/json');
		// $list = array();
		// foreach ($aux as $key => $value)
		// {
		// 	$list[$key]['ID'] = $aux[$key]['ID'];
		// 	$list[$key]['cod_articulo'] = $aux[$key]['cod_articulo'];
		// 	$list[$key]['descripcion'] = $aux[$key]['descripcion'];
		// 	$list[$key]['agregar'] = 'X';
		// }
		echo (json_encode($aux));
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
    	echo_pre('permiso para aprobar solicitudes', __LINE__, __FILE__);//12
        if($this->session->userdata('user') && ($this->dec_permiso->has_permission('alm', 12) || $this->dec_permiso->has_permission('alm', 13)))
        {
        	// die_pre($_POST, __LINE__, __FILE__);
	        if($_POST)
	        {
	        	$where['nr_solicitud'] = $_POST['nr_solicitud'];
	        	foreach ($_POST['usados'] as $art => $cant)
	        	{
	        		$solicitud[] = array('nr_solicitud' => $_POST['nr_solicitud'], 
	        			'id_articulo' => $art, 
	        			'cant_aprobada' => $_POST['nuevos'][$art]+$_POST['usados'][$art],
	        			'cant_nuevos' => $_POST['nuevos'][$art],
	        			'cant_usados' => $_POST['usados'][$art]);
	        	}
	        	// die_pre($solicitud, __LINE__, __FILE__);
	        	$this->model_alm_solicitudes->aprobar_solicitud($where, $solicitud);
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
    public function despachar($nr_solicitud="")
    {
    	echo_pre('permiso para despachar solicitudes', __LINE__, __FILE__);//13
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
        		redirect('administrador/solicitudes');
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

}