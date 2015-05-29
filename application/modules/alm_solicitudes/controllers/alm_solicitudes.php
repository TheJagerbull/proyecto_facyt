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
    public function generar_nr()//se utiliza para generar un valor de 9 caracteres de tipo string que sera el numero de la solicitud
    {
    	$aux = $this->model_alm_solicitudes->get_last_id() + 1;
    	$nr = str_pad($aux, 9, '0', STR_PAD_LEFT);// tomado de http://stackoverflow.com/questions/1699958/formatting-a-number-with-leading-zeros-in-php
    	// die_pre($nr);
    	return((string)$nr);
    }


//cargas de vistas
    public function generar_solicitud($field='', $order='', $aux='')
    {

    	if($this->session->userdata('user'))
		{
			$where = array('id_usuario'=>$this->session->userdata('user')['id_usuario'], 'status'=>'carrito');
			if(!$this->model_alm_solicitudes->exist($where))
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
	    		redirect('solicitud/enviar');
		    }
		}
		else
		{
			$header['title'] = 'Error de Acceso';
			$this->load->view('template/erroracc',$header);
		}
    }
    public function consultar_solicitud()//COMPLETADA
    {
    	echo_pre($this->session->all_userdata());
    	if($this->session->userdata('user'))
		{
	    	if(empty($this->session->userdata('articulos')[0]['descripcion']))
	    	{
	    		redirect('solicitud/confirmar');
	    	}
			$header['title'] = 'Lista de Solicitudes';
			$user = $this->session->userdata('user')['id_dependencia'];
			if($this->session->flashdata('solicitud_completada'))
			{
				$view['solicitudes']=$this->model_alm_solicitudes->get_departamentoSolicitud($user);
				$view['solicitudes'] = array_merge($this->model_alm_solicitudes->get_depLastCompleted($user), $view['solicitudes']);
			}
			else
			{
				$view['solicitudes']=$this->model_alm_solicitudes->get_departamentoSolicitud($user);
			}

			foreach ($view['solicitudes'] as $key => $sol)
			{
				$articulo[$sol['nr_solicitud']]= $this->model_alm_solicitudes->get_solArticulos($sol);
			}
			if(!empty($articulo))
			{
				$view['articulos']=$articulo;
			}
			$this->load->view('template/header', $header);
			$this->load->view('alm_solicitudes/solicitudes_lista', $view);
	    	$this->load->view('template/footer');
		}
		else
		{
			$header['title'] = 'Error de Acceso';
			$this->load->view('template/erroracc',$header);
		}

    }
/////////////////Administrador    
    public function consultar_solicitudes()//Consulta de Administrador de Almacen y Autoridad [incompleta]
    {
    	if($this->session->userdata('user')['sys_rol']=='autoridad' || $this->session->userdata('user')['sys_rol']=='asist_autoridad' || $this->session->userdata('user')['sys_rol']=='jefe_alm')
		{
			$header['title'] = 'Lista de Solicitudes';
			$user = $this->session->userdata('user')['id_dependencia'];
			
			if($_POST)
			{
				if(!empty($_POST['command']))
				{
					switch($_POST['command'])
					{
						case 'dep':
							$view['command']='dep';
							echo_pre('departamento');
						break;
						case 'find_usr':
							$view['command']='find_usr';
							// $view['solicitudes']=;
						break;
						case 'status':
							$view['command']='status';
							echo_pre('mostrara varias listas en funcion de solicitudes completadas, y sin aprobar');
						break;
						case 'last_date':
							$view['command']='last_date';
							echo_pre('default');
						break;
					}
				}
				if(!empty($_POST['usuario']))
				{
					$this->load->model('user/model_dec_usuario');
					$aux=$this->model_dec_usuario->buscar_usr($_POST['usuario']);
					if(!empty($aux[1]) || empty($aux[0]))
					{
						$view['command']='find_usr';
						$this->session->set_flashdata('user_error', 'error');
					}
					else
					{
						$id=$aux[0]->id_usuario;
						// die_pre($this->model_alm_solicitudes->get_userSolicitud($id));
						// die_pre($id);
					}
				}
				// if(!empty($_POST['']))
				// {

				// }
				// if(!empty($_POST['']))
				// {

				// }
				// if(!empty($_POST['']))
				// {
					
				// }
			}
			// else
			// {
				$view['solicitudes']=$this->model_alm_solicitudes->get_allSolicitud();
			// }

			foreach ($view['solicitudes'] as $key => $sol)//para consultar todos los articulos de cada solicitud, y cargarlos en un array aparte
			{
				$articulo[$sol['nr_solicitud']]= $this->model_alm_solicitudes->get_solArticulos($sol);
				foreach ($articulo[$sol['nr_solicitud']] as $a => $art)
				{
					$exist=$this->model_alm_articulos->get_existencia($art['id_articulo']);
					$articulo[$sol['nr_solicitud']][$a] = array_merge($art, $exist);
				}
			}
			$view['articulos'] = $articulo;
			// die_pre($view);
			$this->load->view('template/header', $header);
			$this->load->view('alm_solicitudes/administrador_lista', $view);
	    	$this->load->view('template/footer');
		}
		else
		{
			$header['title'] = 'Error de Acceso';
			$this->load->view('template/erroracc',$header);
		}

    }
    public function autorizar_solicitudes()//incompleta
    {
    	if($this->session->userdata('user'))
		{
			$header['title']='Solicitudes para autorizar';
			$this->load->view('template/header', $header);
	    	echo "tears is how weakness leaves your body";
	    	$this->load->view('template/footer');
		}
		else
		{
			$header['title'] = 'Error de Acceso';
			$this->load->view('template/erroracc',$header);
		}

    }
    public function completar_solicitud()
    {
    	if($this->session->userdata('user'))
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
			$header['title'] = 'Error de Acceso';
			$this->load->view('template/erroracc',$header);
		}
    }

//funciones y operaciones
////////agregar y quitar articulos de la session
    public function agregar_articulo()
    {
    	if($this->session->userdata('user'))
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
			$header['title'] = 'Error de Acceso';
			$this->load->view('template/erroracc',$header);
		}

    }
    public function quitar_articulo()
    {
    	if($this->session->userdata('user'))
		{
			echo_pre($_POST['ID']);
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
    public function confirmar_articulos()//solicitudes_step2.php
    {
    	if($this->session->userdata('user') && $this->session->userdata('articulos'))
		{
			if(empty($this->session->userdata('articulos')[0]['descripcion']))
			{
				$aux = array();
				foreach ($this->session->userdata('articulos') as $key => $articulo)
				{
					array_push($aux, $articulo);
					// array_push($view['articulos'], $this->model_alm_articulos->get_articulo($articulo));
				}
				$view['articulos'] = $this->model_alm_articulos->get_articulo($aux);
				// echo_pre($view['articulos'][0][0]->ID);
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
								'id_articulo'=>$_POST['ID'.$i],
								'NRS'=>$_POST['nr'],
								'nr_solicitud'=>$_POST['nr'],
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
						$solicitud['contiene'] = $contiene;
						$check = $this->model_alm_solicitudes->insert_solicitud($solicitud);
						if($check!= FALSE)
						{
							$this->session->unset_userdata('articulos');
							$where = array('id_usuario'=> $this->session->userdata('user')['id_usuario'], 'status'=>'carrito');
							// if($this->model_alm_solicitudes->exist($where))
							// {
								$art = $this->model_alm_solicitudes->get_solArticulos($where);
								$this->session->set_userdata('articulos', $art);
								$aux = $this->model_alm_solicitudes->get_solNumero($where);
								$this->session->set_userdata('nr_solicitud', $aux);
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
	    		redirect('solicitud/enviar');
			}
		}
		else
		{
			$header['title'] = 'Error de Acceso';
			$this->load->view('template/erroracc',$header);
		}

    }

    public function editar_solicitud($nr_solicitud)//incompleta
    {
    	if($this->session->userdata('user'))
		{
			$header['title'] = 'Lista de Solicitudes';
			// die_pre($nr_solicitud);
			$aux = $this->model_alm_solicitudes->allDataSolicitud($nr_solicitud);
			$view = $aux;
			// die_pre($view);
			$this->load->view('template/header', $header);
			$this->load->view('alm_solicitudes/solicitud_actual', $view);
	    	$this->load->view('template/footer');
		}
		else
		{
			$header['title'] = 'Error de Acceso';
			$this->load->view('template/erroracc',$header);
		}
    }
    public function enviar_solicitud()//incompleta
    {
	    if($this->session->userdata('user'))
	    {
	    	if($_POST)
	    	{
	    		if($this->change_statusSol($_POST))
	    		{
	    			//esta bien
	    			$view['enviada']=TRUE;
	    			$this->session->unset_userdata('articulos');
	    			$header['title'] = 'Solicitud Enviada';
					$this->load->view('template/header', $header);
			    	// $this->load->view('alm_solicitudes/solicitudes_step3', $view);
			    	$this->load->view('alm_solicitudes/solicitudes_step3', $view);
			    	$this->load->view('template/footer');
	    		}
	    		else
	    		{
	    			//esta mal
	    			$this->session->set_flashdata('send_solicitud','error');
	    			redirect('solicitud/enviar');
	    		}

	    	}
	    	else
	    	{

	    		$view['enviada']=FALSE;
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
	    	$header['title'] = 'Error de Acceso';
			$this->load->view('template/erroracc',$header);
	    }
    }
    public function get_solicitudHist()
    {


    }
    public function change_statusSol($where='')
    {
    	return($this->model_alm_solicitudes->change_statusEn_proceso($where));
    }

    public function get_userSolicitud($user='')
    {

    }

    //Funcion para generar PDF de solicitudes

     public function generar() {
    	if($this->session->userdata('user'))
		{
		
        	$this->load->library('Pdf');
        	$pdf = new Pdf('P', 'mm', 'A4', true, 'UTF-8', false);
        	$pdf->SetCreator(PDF_CREATOR);
        	$pdf->SetAuthor('Beca servicio de Telematicas');
        	$pdf->SetTitle('Ejemplo de Solicitudes con TCPDF');
        	$pdf->SetSubject('Sistema Inventarios');
        	$pdf->SetKeywords('TCPDF, PDF, example, test, guide');
 
			// datos por defecto de cabecera, se pueden modificar en el archivo tcpdf_config_alt.php de libraries/config
	        $pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE, PDF_HEADER_STRING ,array(0, 64, 255), array(0, 64, 128));
	        $pdf->setFooterData($tc = array(0, 64, 0), $lc = array(0, 64, 128));
	 
			// datos por defecto de cabecera, se pueden modificar en el archivo tcpdf_config.php de libraries/config
	        $pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
	        $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
	 
			// se pueden modificar en el archivo tcpdf_config.php de libraries/config
	        $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
	 
			// se pueden modificar en el archivo tcpdf_config.php de libraries/config
	        $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
	        $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
	        $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
	 
			// se pueden modificar en el archivo tcpdf_config.php de libraries/config
	        $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
	 
			//relación utilizada para ajustar la conversión de los píxeles
	        $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
	 
	 
			// ---------------------------------------------------------
			// establecer el modo de fuente por defecto
	        $pdf->setFontSubsetting(true);
	 
			// Establecer el tipo de letra
	 
			//Si tienes que imprimir carácteres ASCII estándar, puede utilizar las fuentes básicas como
			// Helvetica para reducir el tamaño del archivo.
	        $pdf->SetFont('freemono', '', 14, '', true);
	 
			// Añadir una página
			// Este método tiene varias opciones, consulta la documentación para más información.
	        $pdf->AddPage();
	 
			//fijar efecto de sombra en el texto
	        $pdf->setTextShadow(array('enabled' => true, 'depth_w' => 0.2, 'depth_h' => 0.2, 'color' => array(196, 196, 196), 'opacity' => 1, 'blend_mode' => 'Normal'));
	 
			// Establecemos el contenido para imprimir
	        $solicitud = $this->input->post('solicitud');
	        $solicitudf = $this->model_alm_solicitudes->getSolicitudesSeleccionadas($solicitud);
	        foreach($solicitudf as $fila)
	        {
	            $num = $fila['l.status'];
	        }
	        //preparamos y maquetamos el contenido a crear
	        $html = '';
	        $html .= "<style type=text/css>";
	        $html .= "th{color: #fff; font-weight: bold; background-color: #222}";
	        $html .= "td{color: #020000;font-weight: bolder; background-color: #AAC7E3; }";
	        $html .= "</style>";
	        $html .= "<h2>Solicitud status ".$num."</h2><h4>Actualmente: ".count($solicitudf)." Solicitudes</h4>";
	        $html .= "<table width='100%'>";
	        $html .= "<tr><th>Id Solicitud</th><th>Solicita</th></tr>";
	        
	        //solicitudf es la respuesta de la función getSolicitudesSeleccionadas($solicitud) del modelo
	        foreach ($solicitudf as $fila) 
	        {
	            $usuario = $fila['l.id_usuario'];
	            $observacion = $fila['l.observacion'];
	        
	 
	            $html .= "<tr><td class='usuario'>" . $usuario . "</td><td class='observacion'>" . $observacion . "</td></tr>";
	        }
	        $html .= "</table>";
	 
			// Imprimimos el texto con writeHTMLCell()
	        $pdf->writeHTMLCell($w = 0, $h = 0, $x = '', $y = '', $html, $border = 0, $ln = 1, $fill = 0, $reseth = true, $align = '', $autopadding = true);
	 
			// ---------------------------------------------------------
			// Cerrar el documento PDF y preparamos la salida
			// Este método tiene varias opciones, consulte la documentación para más información.
	        $nombre_archivo = utf8_decode("Solicitud status ".$num.".pdf");
	        $pdf->Output($nombre_archivo, 'I');
	    }
		else
		{
			$header['title'] = 'Error de Acceso';
			$this->load->view('template/erroracc',$header);
		}
    }

}