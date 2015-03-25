<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Usuario extends MX_Controller
{
	function __construct() //constructor predeterminado del controlador
    {
        parent::__construct();
        $this->load->library('form_validation');
		$this->load->model('model_dec_usuario');
    }
	
	//funcion callback para revisar si existe el usuario en la base de datos
	public function exist_user()
	{
		$where['id_usuario'] = $this->input->post('id');
		$where['password'] = sha1($this->input->post('password'));
		
		if(!$this->model_dec_usuario->exist($where))
		{
			$this->form_validation->set_message('exist_user','Combinación de <strong>Cedula de identidad</strong> y <strong>Contraseña</strong> inválida');
			return FALSE;
		}
		return TRUE;
	}
	
	public function index()
	{
		$this->load->view('log-in');
	}
	
	public function login()
	{
		$post = $_POST;
		//print_r($post);
		/*$post['password'] = sha1($post['password']);
		echo '<pre>'; print_r($post); echo '</pre>';*/
			
		
		$this->form_validation->set_error_delimiters('<div class="alert alert-danger">','</div>');
		$this->form_validation->set_message('required', '%s es Obligatorio');
		$this->form_validation->set_rules('id','<strong>Cedula de Identidad</strong>','trim|required|min_lenght[7]&max_lenght[9]|xss_clean|callback_exist_user');
		//$this->form_validation->set_rules('id','<strong>Nr de Identificacion</strong>','required');
		$this->form_validation->set_rules('password','<strong>Contraseña</strong>','trim|required|xss_clean');
		//$this->form_validation->set_rules('password','<strong>Contraseña</strong>','required');
		
		if($this->form_validation->run($this))
		{
			//Exito en las validaciones
			$post['password'] = sha1($post['password']);//encripta el password a sha1, para no ser decifrado en la BD
			$user = $this->model_dec_usuario->existe($post);
			if(isset($user))
			{
				//echo '<pre>'; print_r($user->id_usuario); echo '</pre>';
				//echo_pre($user['id_usuario']);
				//Si no esta mala la consulta, mostrar vista bonita "redirect('nombre de la vista')"
				//$this->session->all_userdata();
				$plus_user = array('id_usuario'=>$user->id_usuario, 'nombre'=>$user->nombre, 'apellido'=>$user->apellido, 'sys_rol'=>$user->sys_rol);
				$this->session->set_userdata('user',$plus_user);
				//echo_pre($this->session->all_userdata());
				//print_r($this->session->all_userdata());
				$header['title'] = 'Home';
				redirect('air_home/index'); //redirecciona con las session de usuario
				$this->load->view('template/footer');
			}
		}
		//$this->load->view('include/header');
		$this->load->view('login/log-in');
		//$this->load->view('include/footer');
	}
	/*
	public function ver_usuario($field='',$order='')
	{
		
		// $HEADER Y $VIEW SON LOS ARREGLOS DE PARAMETROS QUE SE LE PASAN A LAS VISTAS CORRESPONDIENTES
		$header['title'] = 'Ver usuario';
		
		if(!empty($field))
		{
			switch ($field)
			{
				case 'orden_email': $field = 'id_usuario'; break;
				case 'orden_nombre': $field = 'nombre'; break;
				case 'orden_tipousuario': $field = 'tipo_usuario'; break;
				default: $field = 'id_usuario'; break;
			}
		}
		$order = (empty($order) || ($order == 'asc')) ? 'desc' : 'asc';
		$usuarios = $this->model_dec_usuario->get_allusers($field,$order);
		// PARA VER LA INFORMACION DE LOS USUARIOS DESCOMENTAR LA LINEA DE ABAJO, GUARDAR Y REFRESCAR EL EXPLORADOR
		// die_pre($usuarios);
		$view['users'] = $usuarios;
		$view['order'] = $order;
		
		//CARGAR LAS VISTAS GENERALES MAS LA VISTA DE VER USUARIO
		$this->load->view('includes/header',$header);
		$this->load->view('usuario/ver_usuario',$view);
		$this->load->view('includes/footer');
	}*/
	
	// PARA CREAR UN USUARIO ES NECESARIO QUE ESTEN CREADAS LAS SUCURSALES DE LAS FARMACIAS, YA QUE EL USUARIO PIDE SU RIF COMO ATRIBUTO
	public function crear_usuario()
	{
		// $HEADER Y $VIEW SON LOS ARREGLOS DE PARAMETROS QUE SE LE PASAN A LAS VISTAS CORRESPONDIENTES
		$header['title'] = 'Crear usuario';
		
		if($_POST)
		{
			$post = $_POST;
			
			// REGLAS DE VALIDACION DEL FORMULARIO PARA CREAR USUARIOS NUEVOS
			$this->form_validation->set_error_delimiters('<div class="col-md-3"></div><div class="col-md-7 alert alert-danger" style="text-align:center">','</div><div class="col-md-2"></div>');
			$this->form_validation->set_rules('id_usuario','<strong>Email</strong>','trim|required|valid_email|min_lenght[8]|xss_clean|is_unique[usuario.ide_usuario]');
			$this->form_validation->set_rules('password','<strong>Contraseña</strong>','trim|required|xss_clean');
			$this->form_validation->set_rules('repass','<strong>Repetir Contraseña</strong>','trim|required|matches[password]|xss_clean');
			$this->form_validation->set_rules('nombre','<strong>Nombre</strong>','trim|required|xss_clean');
			$this->form_validation->set_rules('apellido','<strong>Apellido</strong>','trim|required|xss_clean');
			$this->form_validation->set_message('is_unique','El <strong>Email</strong> ingresado ya existe en la base de datos');
			
			if($this->form_validation->run($this))
			{
				unset($post['repass']);
				$post['password'] = sha1($post['password']);
				// SE MANDA EL ARREGLO $POST A INSERTARSE EN LA BASE DE DATOS
				$user = $this->model_dec_usuario->insert_user($post);
				if($user != FALSE)
				{
					$this->session->set_flashdata('create_user','success');
					redirect(base_url().'index.php/usuarios/ver');
				}
			}
			
		}
		
		//CARGAR LAS VISTAS GENERALES MAS LA VISTA DE VER USUARIO
		$this->load->view('includes/header',$header);
		$this->load->view('usuario/crear_usuario');
		$this->load->view('includes/footer');
	}

	// RECIBE POR URL EL ID DEL USUARIO A EDITAR
	public function detalle_usuario($id_usuario='')
	{
		// $HEADER Y $VIEW SON LOS ARREGLOS DE PARAMETROS QUE SE LE PASAN A LAS VISTAS CORRESPONDIENTES
		$header['title'] = 'Detalle de usuario';
		
		if(!empty($id_usuario))
		{
			$user = $this->model_dec_usuario->get_oneuser($id_usuario);
			$view['user'] = $user;
			$view['edit'] = TRUE;
			
			//CARGAR LAS VISTAS GENERALES MAS LA VISTA DE VER USUARIO
			$this->load->view('includes/header',$header);
			$this->load->view('usuario/crear_usuario',$view);
			$this->load->view('includes/footer');
		}else
		{
			$this->session->set_flashdata('edit_user','error');
			redirect(base_url().'index.php/usuarios/ver');
		}
	}

	public function modificar_usuario()
	{
		if($_POST)
		{
			$post = $_POST;
			
			// REGLAS DE VALIDACION DEL FORMULARIO PARA CREAR USUARIOS NUEVOS
			$this->form_validation->set_error_delimiters('<div class="col-md-3"></div><div class="col-md-7 alert alert-danger" style="text-align:center">','</div><div class="col-md-2"></div>');
			$this->form_validation->set_rules('ide_usuario','<strong>Email</strong>','trim|required|valid_email|min_lenght[8]|xss_clean');
			$this->form_validation->set_rules('password','<strong>Contraseña</strong>','trim|xss_clean');
			$this->form_validation->set_rules('repass','<strong>Repetir Contraseña</strong>','trim|matches[password]|xss_clean');
			$this->form_validation->set_rules('nombre','<strong>Nombre</strong>','trim|required|xss_clean');
			$this->form_validation->set_rules('apellido','<strong>Apellido</strong>','trim|required|xss_clean');
			
			if($this->form_validation->run($this))
			{
				if(empty($post['password']))
				{
					unset($post['password']);
				}else
				{
					$post['password'] = sha1($post['password']);
				}
				unset($post['repass']);
				// SE MANDA EL ARREGLO $POST A INSERTARSE EN LA BASE DE DATOS
				$user = $this->model_dec_usuario->edit_user($post);
				if($user != FALSE)
				{
					$this->session->set_flashdata('edit_user','success');
					redirect(base_url().'index.php/usuarios/ver');
				}
			}
			$this->detalle_usuario($post['id']);
		}
	}

	// RECIBE POR URL EL ID DEL USUARIO A ELIMINAR
	public function eliminar_usuario($id_usuario='')
	{
		if(!empty($id_usuario))
		{
			$response = $this->model_dec_usuario->drop_user($id_usuario);
			if($response)
			{
				$this->session->set_flashdata('drop_user','success');
				redirect(base_url().'index.php/usuarios/ver');
			}
		}
		$this->session->set_flashdata('drop_user','error');
		redirect(base_url().'index.php/usuarios/ver');
	}
	
	public function logout()
	{
		$this->session->sess_destroy();
		redirect('/');
	}
}

/* End of file usuario.php */
/* Location: ./application/controllers/usuario.php */
