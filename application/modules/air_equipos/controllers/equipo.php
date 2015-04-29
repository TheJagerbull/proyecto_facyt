<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Equipo extends MX_Controller
{
	function __construct() //constructor predeterminado del controlador
    {
        parent::__construct();
        $this->load->library('form_validation');
		$this->load->model('model_air_tipo_eq');
    }
	
	public function index()
	{
		$header['title'] = 'Página de Inicio - Sistema de Inventario';
		$this->load->view('home');
			
	}
	//funcion callback para revisar si existe el usuario en la base de datos
	public function exist_user()
	{
		
		$where['id'] = $this->input->post('id');
				
		if(!$this->model_air_tipo_eq->exist($where))

	}

	
	
	public function lista_equipo($field='',$order='')
	{
		//die_pre($this->session->all_userdata());
		if($this->hasPermissionClassA())
		{
			// $HEADER Y $VIEW SON LOS ARREGLOS DE PARAMETROS QUE SE LE PASAN A LAS VISTAS CORRESPONDIENTES
			$header['title'] = 'Ver equipo';
			
			if(!empty($field))
			{
				switch ($field)
				{
					case 'orden_codigo': $field = 'id'; break;
					case 'orden_descripcion': $field = 'desc'; break;
					default: $field = 'id'; break;
				}
			}
			$order = (empty($order) || ($order == 'asc')) ? 'desc' : 'asc';
			$equipo = $this->model_air_tipo_eq->get_allusers($field,$order);
			// PARA VER LA INFORMACION DE LOS USUARIOS DESCOMENTAR LA LINEA DE ABAJO, GUARDAR Y REFRESCAR EL EXPLORADOR
			// die_pre($usuarios);
			if($_POST)
			{
				$view['equipo'] = $this->buscar_equipo();
			}
			else
			{
				$view['equipo'] = $equipo;
			}
			$view['order'] = $order;
			
			//CARGAR LAS VISTAS GENERALES MAS LA VISTA DE VER USUARIO
			$this->load->view('template/header',$header);
			$this->load->view('air_equipos/lista_equipo',$view);
			$this->load->view('template/footer');
		}
		else
		{
			$header['title'] = 'Error de Acceso';
			$this->load->view('template/erroracc',$header);
		}
	}
	
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

	// RECIBE POR URL EL ID DEL USUARIO A EDITAR
	public function detalle_equipo($id='')
	{
		if($this->session->userdata('equipo'))
		{
			// $HEADER Y $VIEW SON LOS ARREGLOS DE PARAMETROS QUE SE LE PASAN A LAS VISTAS CORRESPONDIENTES
			$header['title'] = 'Detalle equipo';
			if(!empty($id_usuario))
			{
				$equipo = $this->model_air_tipo_eq->get_oneq($id);
				$view['equipo'] = $equipo;
				
				//CARGAR LAS VISTAS GENERALES MAS LA VISTA DE VER USUARIO
				$this->load->view('template/header',$header);
				if($this->session->userdata('equipo')['ID'] == $equipo->ID )
				{
					$view['edit'] = TRUE;
					$this->load->view('air_equipos/ver_usuario',$view);
				}
				else
				{
					if($this->hasPermissionClassA())
					{
						$view['edit'] = TRUE;
						$this->load->view('air_equipos/ver_usuarios',$view);
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
				$this->session->set_flashdata('edit_equipo','error');
				redirect(base_url().'index.php/equipo/listar');
			}
		}
		else
		{
			$header['title'] = 'Error de Acceso';
			$this->load->view('template/erroracc',$header);
		}
	}

	public function modificar_equipo()
	{
		if($this->session->userdata('equipo'))
		{
			if($_POST)
			{
				$post = $_POST;
				
				// REGLAS DE VALIDACION DEL FORMULARIO PARA CREAR USUARIOS NUEVOS
				$this->form_validation->set_error_delimiters('<div class="col-md-3"></div><div class="col-md-7 alert alert-danger" style="text-align:center">','</div><div class="col-md-2"></div>');
				$this->form_validation->set_message('required', '%s es Obligatorio');
				$this->form_validation->set_rules('id','<strong>Codigo</strong>','trim|required|min_lenght[7]|xss_clean');
				$this->form_validation->set_rules('desc','<strong>Descripcion</strong>','trim|required|xss_clean');
				
					// SE MANDA EL ARREGLO $POST A INSERTARSE EN LA BASE DE DATOS
					// if($this->hasPermissionClassA()|| $this->isOwner($post))
					// {
						$user = $this->model_air_tipo_eq->edit_user($post);
					// }
					if($user != FALSE)
					{
						$this->session->set_flashdata('edit_user','success');
						redirect(base_url().'index.php/air_equipos/equipo/lista_equipo');
					}
				}
				$this->detalle_equipo($post['ID']);
			}
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
	public function buscar_usuario()
	{
		if($_POST)
		{
			$header['title'] = 'Buscar equipo';
			$post = $_POST;
			return($this->model_dec_usuario->buscar_usr($post['equipo']));
			
		}else
		{
			die_pre('fin');
			redirect('air_equipos/equipo/lista_equipo');
		}
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

/* End of file usuario.php */
/* Location: ./application/modules/user/controllers/usuario.php */
}