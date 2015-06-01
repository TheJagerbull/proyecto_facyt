<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Tipoeq extends MX_Controller
{
	/**
	 * 
	 * Metodo Construct.
	 * 
	 * 
	 */
	function __construct() //constructor predeterminado del controlador
    {
        parent::__construct();
        $this->load->library('form_validation');
		$this->load->model('model_air_tipo_eq','model');
    }

	/**
	 * 
	 * Metodo Index.
	 * 
	 * 
	 */
	public function index($field='',$order='')
	{
		//die("llega");
		if($this->hasPermissionClassA())
		{
			// $HEADER Y $VIEW SON LOS ARREGLOS DE PARAMETROS QUE SE LE PASAN A LAS VISTAS CORRESPONDIENTES
			$header['title'] = 'Ver Equipo';
			
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
			$tipo = $this->model->get_alltipo($field,$order);
			// PARA VER LA INFORMACION DE LOS USUARIOS DESCOMENTAR LA LINEA DE ABAJO, GUARDAR Y REFRESCAR EL EXPLORADOR
			// die_pre($usuarios);
			if($_POST)
			{
				$view['tipo'] = $this->buscar_tipo();
			}
			else
			{
				$view['tipo'] = $tipo;
			}
			$view['order'] = $order;
			
			//CARGAR LAS VISTAS GENERALES MAS LA VISTA DE LOS TIPOS
			$this->load->view('template/header',$header);
			$this->load->view('air_tipoeq/lista_tipo',$view);
			$this->load->view('template/footer');
		}else{
			$header['title'] = 'Error de Acceso';
			$this->load->view('template/erroracc',$header);
		}
	}

	/**
	 * 
	 * 
	 * 
	 */
	public function buscar_tipo()
	{
		if($_POST)
		{
			$header['title'] = 'Buscar Tipo';
			$post = $_POST;
			return($this->model->buscar_tipo($post['tipo']));
			
		}else
		{
			//die_pre('fin');
			redirect('air_tipoeq/tipoeq/index');
		}
	}

	/**
	 * 
	 * Metodo detalle_tipo.
	 *
	 * 
	 */
	public function detalle_tipo($id='')
	{
		//if($this->session->userdata('equipo'))
		//{
			
			$header['title'] = 'Detalle Tipo';
			if(!empty($id))
			{
				$tipo = $this->model->get_onetipo($id);
				$view['tipo'] = $tipo;
				
				//CARGAR LAS VISTAS GENERALES MAS LA VISTA DE VER ITEM
				$this->load->view('template/header',$header);
				if($this->session->userdata('tipo')['id'] == $tipo->id )
				{
					$view['edit'] = TRUE;
					$this->load->view('air_tipoeq/ver_tipo',$view);
				}
				else
				{
					if($this->hasPermissionClassA())
					{
						$view['edit'] = TRUE;
						$this->load->view('air_tipoeq/ver_tipo',$view);
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
				$this->session->set_flashdata('edit_tipo','error');
				redirect(base_url().'index.php/Tipoeq/listar');
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
	 * Metodo modificar_tipo.
	 * 
	 * 
	 */
	public function modificar_tipo()
	{
		//if($this->session->userdata('tipo'))
		//{
			if($_POST)
			{
				$post = $_POST;
				
				// REGLAS DE VALIDACION DEL FORMULARIO PARA CREAR USUARIOS NUEVOS
				$this->form_validation->set_error_delimiters('<div class="col-md-3"></div><div class="col-md-7 alert alert-danger" style="text-align:center">','</div><div class="col-md-2"></div>');
				$this->form_validation->set_message('required', '%s es Obligatorio');
				$this->form_validation->set_rules('cod','<strong>Codigo</strong>','trim|required|min_lenght[7]|xss_clean');
				$this->form_validation->set_rules('desc','<strong>Descripcion</strong>','trim|required|xss_clean');
				
					$tipo = $this->model->edit_tipo($post);
					if($tipo != FALSE)
					{
						$this->session->set_flashdata('edit_tipo','success');
						redirect(base_url().'index.php/air_tipoeq/tipoeq/index');
					}
				
				$this->detalle_tipo($post['id']);
			}
		
		else
		{
			$header['title'] = 'Error de Acceso';
			$this->load->view('template/erroracc',$header);
		}
	}

	// PARA CREAR UN USUARIO ES NECESARIO QUE ESTEN CREADAS LAS SUCURSALES DE LAS FARMACIAS, YA QUE EL USUARIO PIDE SU RIF COMO ATRIBUTO
	public function nuevo_tipo($field='',$order='')
	{
		if($this->hasPermissionClassA())
		{
			// $HEADER Y $VIEW SON LOS ARREGLOS DE PARAMETROS QUE SE LE PASAN A LAS VISTAS CORRESPONDIENTES
			$header['title'] = 'Crear tipo';
			if($_POST)
			{
				$post = $_POST;
				
				// REGLAS DE VALIDACION DEL FORMULARIO PARA CREAR USUARIOS NUEVOS
				$this->form_validation->set_error_delimiters('<div class="col-md-3"></div><div class="col-md-7 alert alert-danger" style="text-align:center">','</div><div class="col-md-2"></div>');
				$this->form_validation->set_rules('cod','<strong>codigo</strong>','trim|required|xss_clean');
				$this->form_validation->set_rules('desc','<strong>descripcion</strong>','trim|required|xss_clean');
				$this->form_validation->set_message('is_unique','El campo %s ingresado ya existe en la base de datos');
				$this->form_validation->set_message('required', '%s es Obligatorio');
				
				if($this->form_validation->run($this))
				{
					
					// SE MANDA EL ARREGLO $POST A INSERTARSE EN LA BASE DE DATOS
					$tipo = $this->model->insert_tipo($post);
					if($tipo != FALSE)
					{
						$this->session->set_flashdata('create_tipo','success');
						redirect(base_url().'index.php/air_tipoeq/tipoeq/index');
					}
				}
				
			}
			$this->session->set_flashdata('create_tipo','error');
			$this->load->view('template/header',$header);
			$this->load->view('air_tipoeq/nuevo_tipo');
			$this->load->view('template/footer');
		}
		else
		{
			$header['title'] = 'Error de Acceso';
			$this->load->view('template/erroracc',$header);
		}
	}
	
	// RECIBE POR URL EL ID DEL TIPO A ELIMINAR
	public function eliminar_tipo($id='')
	{
		//if($this->session->userdata('tipo')&&$this->hasPermissionClassA())
		//{
			if(!empty($id))
			{
				$tipo = $this->model->drop_tipo($id);
				if($tipo)
				{
					$this->session->set_flashdata('drop_tipo','success');
					redirect(base_url().'index.php/air_tipoeq/tipoeq/index');
				}
			}
			$this->session->set_flashdata('drop_tipo','error');
			redirect(base_url().'index.php/air_tipoeq/tipoeq/index');
		//}
		//else
		{
			$header['title'] = 'Error de Acceso';
			$this->load->view('template/erroracc',$header);
		}
	}

	
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