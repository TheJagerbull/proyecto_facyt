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
	
	public function login()//Funciona perfecto
	{
		$post = $_POST;
		
		$this->form_validation->set_error_delimiters('<div class="alert alert-danger">','</div>');
		$this->form_validation->set_message('required', '%s es Obligatorio');
		$this->form_validation->set_rules('id','<strong>Cedula de Identidad</strong>','trim|required|min_lenght[7]|callback_exist_user|xss_clean');
		$this->form_validation->set_rules('password','<strong>Contraseña</strong>','trim|required|xss_clean');
		
		if($this->form_validation->run($this))
		{
			//Exito en las validaciones

			$post['password'] = sha1($post['password']);//encripta el password a sha1, para no ser decifrado en la BD
			$user = $this->model_dec_usuario->existe($post);
			if($user)
			{

				//Si no esta mala la consulta, mostrar vista bonita "redirect('nombre de la vista')"
				//$plus_user = array('id_usuario'=>$user->id_usuario, 'nombre'=>$user->nombre, 'id'=>$user->ID, 'apellido'=>$user->apellido, 'sys_rol'=>$user->sys_rol);
				$this->session->set_userdata('user',$user);
				//die_pre($this->session->all_userdata());
				redirect('air_home/index'); //redirecciona con la session de usuario
			}
		}
		//$this->load->view('include/header');
		$this->load->view('user/log-in');
		//$this->load->view('include/footer');
	}
	
	public function lista_usuarios($field='',$order='')
	{
		
		// $HEADER Y $VIEW SON LOS ARREGLOS DE PARAMETROS QUE SE LE PASAN A LAS VISTAS CORRESPONDIENTES
		$header['title'] = 'Ver usuario';
		
		if(!empty($field))
		{
			switch ($field)
			{
				case 'orden_CI': $field = 'id_usuario'; break;
				case 'orden_nombre': $field = 'nombre'; break;
				case 'orden_tipousuario': $field = 'tipo'; break;
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
		$this->load->view('template/header',$header);
		$this->load->view('user/lista_usuario',$view);
		$this->load->view('template/footer');
	}
	
	// PARA CREAR UN USUARIO ES NECESARIO QUE ESTEN CREADAS LAS SUCURSALES DE LAS FARMACIAS, YA QUE EL USUARIO PIDE SU RIF COMO ATRIBUTO
	public function crear_usuario($field='',$order='')
	{
		// $HEADER Y $VIEW SON LOS ARREGLOS DE PARAMETROS QUE SE LE PASAN A LAS VISTAS CORRESPONDIENTES
		$header['title'] = 'Crear usuario';
		if($_POST)
		{
			$post = $_POST;
			
			// REGLAS DE VALIDACION DEL FORMULARIO PARA CREAR USUARIOS NUEVOS
			$this->form_validation->set_error_delimiters('<div class="col-md-3"></div><div class="col-md-7 alert alert-danger" style="text-align:center">','</div><div class="col-md-2"></div>');
			$this->form_validation->set_rules('nombre','<strong>Nombre</strong>','trim|required|xss_clean');
			$this->form_validation->set_rules('apellido','<strong>Apellido</strong>','trim|required|xss_clean');
			$this->form_validation->set_rules('id_usuario','<strong>Cedula</strong>','trim|required|xss_clean|is_unique[dec_usuario.id_usuario]');
			$this->form_validation->set_rules('email','<strong>Email</strong>','trim|required|valid_email|min_lenght[8]|xss_clean|is_unique[dec_usuario.email]');
			$this->form_validation->set_rules('telefono','<strong>Telefono</strong>','trim|required|xss_clean');
			$this->form_validation->set_rules('password','<strong>Contraseña</strong>','trim|required|xss_clean');
			$this->form_validation->set_rules('repass','<strong>Repetir Contraseña</strong>','trim|required|matches[password]|xss_clean');
			$this->form_validation->set_rules('dependencia','<strong>Apellido</strong>','trim|required|xss_clean');
			$this->form_validation->set_rules('cargo','<strong>Apellido</strong>','trim|required|xss_clean');
			$this->form_validation->set_message('is_unique','El campo %s ingresado ya existe en la base de datos');
			$this->form_validation->set_message('required', '%s es Obligatorio');
			$this->form_validation->set_message('valid_email', '%s No es un correo valido');
			$this->form_validation->set_message('matches', 'las Contrasenas con corresponden');

			if($this->form_validation->run($this))
			{
				unset($post['repass']);
				$post['password'] = sha1($post['password']);
				// SE MANDA EL ARREGLO $POST A INSERTARSE EN LA BASE DE DATOS
				$user = $this->model_dec_usuario->insert_user($post);
				if($user != FALSE)
				{
					$this->session->set_flashdata('create_user','success');
					redirect(base_url().'index.php/user/usuario/lista_usuarios');
				}
			}
			
		}
		$this->session->set_flashdata('create_user','error');
		$this->load->view('template/header',$header);
		$this->load->view('user/crear_usuario');
		$this->load->view('template/footer');
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
			$this->load->view('template/header',$header);
			if($this->session->userdata('user')->ID == $user->ID )
			{
				$this->load->view('user/ver_usuario',$view);
			}
			else
			{
				$this->load->view('user/ver_usuarios',$view);
			}


			$this->load->view('template/footer');
		}else
		{
			$this->session->set_flashdata('edit_user','error');
			redirect(base_url().'index.php/usuario/ver');
		}
	}

	public function modificar_usuario()
	{
		if($_POST)
		{
			$post = $_POST;
			
			// REGLAS DE VALIDACION DEL FORMULARIO PARA CREAR USUARIOS NUEVOS
			$this->form_validation->set_error_delimiters('<div class="col-md-3"></div><div class="col-md-7 alert alert-danger" style="text-align:center">','</div><div class="col-md-2"></div>');
			$this->form_validation->set_message('required', '%s es Obligatorio');
			$this->form_validation->set_rules('nombre','<strong>Nombre</strong>','trim|required|xss_clean');
			$this->form_validation->set_rules('apellido','<strong>Apellido</strong>','trim|required|xss_clean');
			$this->form_validation->set_rules('id_usuario','<strong>Cedula de Identidad</strong>','trim|required|min_lenght[7]|xss_clean');
			$this->form_validation->set_rules('password','<strong>Contraseña</strong>','trim|xss_clean');
			$this->form_validation->set_rules('repass','<strong>Repetir Contraseña</strong>','trim|matches[password]|xss_clean');
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
					redirect(base_url().'index.php/user/detalle');
				}
			}
			$this->detalle_usuario($post['ID']);
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
				redirect(base_url().'index.php/user/listar');
			}
		}
		$this->session->set_flashdata('drop_user','error');
		redirect(base_url().'index.php/user/listar');
	}
	
	public function logout()
	{
		
		$this->session->sess_destroy();
		redirect('/');
	}
}

/* End of file usuario.php */
/* Location: ./application/modules/user/controllers/usuario.php */
