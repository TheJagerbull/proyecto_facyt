<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Itemmp extends MX_Controller
{
	/**
	 * 
	 * Metodo Construct.
	 * =====================
	 * En este metodo, se hace el constructor
	 * @author José Henriquez en fecha: 28/04/2015
	 * 
	 */
	function __construct() //constructor predeterminado del controlador
    {
        parent::__construct();
        $this->load->library('form_validation');
		$this->load->model('model_air_mant_prev_item','model');
    }
	
	
	
	/**
	 * 
	 * Metodo Index.
	 * =====================
	 * En este metodo, se hace lista todos los Items de Mantenimiento Preventivo
	 * @author José Henriquez en fecha: 28/04/2015
	 * 
	 */
	public function index($field='',$order='')
	{
		//die("llega");
		if($this->hasPermissionClassA())
		{
			// $HEADER Y $VIEW SON LOS ARREGLOS DE PARAMETROS QUE SE LE PASAN A LAS VISTAS CORRESPONDIENTES
			$header['title'] = 'Ver equipo';
			
			if(!empty($field))
			{
				switch ($field)
				{
					case 'orden_codigo': $field = 'cod'; break;
					case 'orden_descripcion': $field = 'desc'; break;
					default: $field = 'id'; break;
				}
			}
			$order = (empty($order) || ($order == 'asc')) ? 'desc' : 'asc';
			$item = $this->model->get_allitem($field,$order);
			// PARA VER LA INFORMACION DE LOS USUARIOS DESCOMENTAR LA LINEA DE ABAJO, GUARDAR Y REFRESCAR EL EXPLORADOR
			// die_pre($usuarios);
			if($_POST)
			{
				$view['item'] = $this->buscar_item();
			}
			else
			{
				$view['item'] = $item;
			}
			$view['order'] = $order;
			
			//CARGAR LAS VISTAS GENERALES MAS LA VISTA DE VER USUARIO
			$this->load->view('template/header',$header);
			$this->load->view('air_mntprvitm/lista_items',$view);
			$this->load->view('template/footer');
		}else{
			$header['title'] = 'Error de Acceso';
			$this->load->view('template/erroracc',$header);
		}
	}

	/**
	 * 
	 * Metodo buscar_item.
	 * =====================
	 * En este metodo, se hace una busqueda de Items de Mantenimiento Preventivo
	 * @author José Henriquez en fecha: 28/04/2015
	 * 
	 */
	public function buscar_item()
	{
		if($_POST)
		{
			$header['title'] = 'Buscar Item';
			$post = $_POST;
			return($this->model->buscar_item($post['item']));
			
		}else
		{
			//die_pre('fin');
			redirect('air_mntprvitm/itemmp/index');
		}
	}

	/**
	 * 
	 * Metodo detalle_item.
	 * =====================
	 * En este metodo, se hace una busqueda de Item especificado y se muestra el detalle para ser editado
	 * @author José Henriquez en fecha: 28/04/2015
	 * 
	 */
	public function detalle_item($id='')
	{
		//if($this->session->userdata('equipo'))
		//{
			
			$header['title'] = 'Detalle Item de Mantenimiento Preventivo';
			if(!empty($id))
			{
				$item = $this->model->get_oneitem($id);
				$view['item'] = $item;
				
				//CARGAR LAS VISTAS GENERALES MAS LA VISTA DE VER ITEM
				$this->load->view('template/header',$header);
				if($this->session->userdata('item')['id'] == $item->id )
				{
					$view['edit'] = TRUE;
					$this->load->view('air_mntprvitm/mod_item',$view);
				}
				else
				{
					if($this->hasPermissionClassA())
					{
						$view['edit'] = TRUE;
						$this->load->view('air_mntprvitm/mod_item',$view);
					}
					else
					{
						$header['title'] = 'Error de Acceso';
						$this->load->view('template/erroracc',$header);
					}
				}
				$this->load->view('template/footer');
			}else
			{
				$this->session->set_flashdata('edit_item','error');
				redirect(base_url().'index.php/Itemmp/listar');
			}
		//}
		//else
		//{
		//	$header['title'] = 'Error de Acceso';
		//	$this->load->view('template/erroracc',$header);
		//}
	}

	/**
	 * 
	 * Metodo modificar_item.
	 * =====================
	 * En este metodo, se modifica el Item especificado
	 * @author José Henriquez en fecha: 28/04/2015
	 * 
	 */
	public function modificar_item()
	{
		//if($this->session->userdata('item'))
		//{
			if($_POST)
			{
				// REGLAS DE VALIDACION DEL FORMULARIO PARA CREAR USUARIOS NUEVOS
					$this->form_validation->set_error_delimiters('<div class="col-md-3"></div><div class="col-md-7 alert alert-danger" style="text-align:center">','</div><div class="col-md-2"></div>');
					$this->form_validation->set_message('required', '%s es Obligatorio');
					$this->form_validation->set_rules('cod','<strong>Codigo</strong>','trim|required|min_lenght[7]|xss_clean');
					$this->form_validation->set_rules('desc','<strong>Descripcion</strong>','trim|xss_clean');
					
				$post = $_POST;

				//print_r($this->form_validation->run($this));
				//die("Llego hast aaqui");
				if($this->form_validation->run($this))
					{
					
						$iteme = $this->model->edit_item($post);
						if($iteme != FALSE)
						{
							$this->session->set_flashdata('edit_item','success');
							redirect('air_mntprvitm/itemmp/index');
						}
					
					$this->detalle_item($post['id']);

				}
				else
				{
					$this->session->set_flashdata('edit_item','error');
							$this->detalle_item($post['id']);
				}
			}
		//}
		//else
		//{
		//	$header['title'] = 'Error de Acceso';
		//	$this->load->view('template/erroracc',$header);
		//}
	}


	/*
	// PARA CREAR UN USUARIO ES NECESARIO QUE ESTEN CREADAS LAS SUCURSALES DE LAS FARMACIAS, YA QUE EL USUARIO PIDE SU RIF COMO ATRIBUTO
	public function tipo_equipo($field='',$order='')
	{
		if($this->hasPermissionClassA())
		{
			// $HEADER Y $VIEW SON LOS ARREGLOS DE PARAMETROS QUE SE LE PASAN A LAS VISTAS CORRESPONDIENTES
			$header['title'] = 'Ingresar equipo';
			if($_POST)
			{
				$post = $_POST;
				
				// REGLAS DE VALIDACION DEL FORMULARIO PARA CREAR USUARIOS NUEVOS
				$this->form_validation->set_error_delimiters('<div class="col-md-3"></div><div class="col-md-7 alert alert-danger" style="text-align:center">','</div><div class="col-md-2"></div>');
				$this->form_validation->set_rules('id','<strong>Codigo</strong>','trim|required|xss_clean|is_unique[air_tipo_eq.id]');
				$this->form_validation->set_rules('desc','<strong>Descripcion</strong>','trim|required|xss_clean');
				$this->form_validation->set_message('is_unique','El campo %s ingresado ya existe en la base de datos');
				$this->form_validation->set_message('required', '%s es Obligatorio');
				

			if($this->form_validation->run($this))
			{
				unset($post['repass']);
				$post['password'] = sha1($post['password']);
				// SE MANDA EL ARREGLO $POST A INSERTARSE EN LA BASE DE DATOS
				$user = $this->model_dec_usuario->insert_user($post);
				if($user != FALSE)
				{
					$this->session->set_flashdata('nuevo_equipo','success');
					redirect(base_url().'index.php/user/usuario/lista_usuarios');
				}
			}
								
			}
			$this->session->set_flashdata('tipo_equipo','error');
			$this->load->view('template/header',$header);
			$this->load->view('air_equipos/tipo_equipo');
			$this->load->view('template/footer');
		}
		else
		{
			$header['title'] = 'Error de Acceso';
			$this->load->view('template/erroracc',$header);
		}
	}

	
	
	// RECIBE POR URL EL ID DEL USUARIO A ELIMINAR
	public function eliminar_usuario($id='')
	{
		if($this->session->userdata('equipo')&&$this->hasPermissionClassA())
		{
			if(!empty($id))
			{
				$response = $this->model_dec_usuario->drop_user($id_usuario);
				if($response)
				{
					$this->session->set_flashdata('drop_user','success');
					redirect(base_url().'index.php/air_equipos/equipo/lista_equipo');
				}
			}
			$this->session->set_flashdata('drop_user','error');
			redirect(base_url().'index.php/air_equipos/equipo/lista_equipo');
		}
		else
		{
			$header['title'] = 'Error de Acceso';
			$this->load->view('template/erroracc',$header);
		}
	}

	
	
	////////////////////////Fin del Control de permisologia para usar las funciones
	public function logout()
	{
		
		$this->session->sess_destroy();
		redirect('/');
	}
	

	public function autocomplete()
	{
		die_pre();

	}

	// public function jq_buscar_usuario()
	// {
	// 	$keyword = $this->input->post('busqueda');
 
	// 	 $data['response'] = 'false'; //Set default response
		 
	// 	 $query = $this->model_dec_usuario->buscar_usr($keyword); //Model DB search
		 
	// 	 if($query->num_rows() > 0){
	// 	    $data['response'] = 'true'; //Set response
	// 	    $data['message'] = array(); //Create array
	// 	    foreach($query->result() as $row){
	// 	 	  $data['message'][] = array('label'=> $row->friendly_name, 'value'=> $row->friendly_name); //Add a row to array
	// 	    }
	// 	 }
	// 	 echo json_encode($data);
	// }

	public function ajax_likeUsers()
	{
		// error_log("Hello", 0);
		$usuario = $this->input->post('equipo');
		header('Content-type: application/json');
		$query = $this->model_dec_usuario->ajax_likeUsers($usuario);
		$query = objectSQL_to_array($query);
		echo json_encode($query);
	}
/////////no pertenece al proyecto
*/
	////////////////////////Control de permisologia para usar las funciones
	public function hasPermissionClassA()//Solo si es usuario autoridad y/o Asistente de autoridad
	{
		return ($this->session->userdata('user')['sys_rol']=='autoridad'||$this->session->userdata('user')['sys_rol']=='asist_autoridad');
	}
	public function hasPermissionClassB()//Solo si es usuario "Director de Departamento" y/o "jefe de Almacen"
	{
		return ($this->session->userdata('user')['sys_rol']=='director_dep'||$this->session->userdata('user')['sys_rol']=='jefe_alm');
	}
	public function hasPermissionClassC()//Solo si es usuario "Jefe de Almacen"
	{
		return ($this->session->userdata('user')['sys_rol']=='jefe_alm');
	}
	public function hasPermissionClassD()//Solo si es usuario "Director de Departamento"
	{
		return ($this->session->userdata('user')['sys_rol']=='director_dep');
	}	
/* End of file usuario.php */
/* Location: ./application/modules/user/controllers/usuario.php */
}