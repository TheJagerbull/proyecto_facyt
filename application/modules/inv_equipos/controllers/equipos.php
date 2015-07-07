
<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * 
 * Controlador Principal Modulo Equipos
 * =====================
 * 
 * @author José Henriquez en fecha: 06-04-2015
 * 
 */
class Equipos extends MX_Controller
{
	/**
	 * 
	 * Clase Constructora
	 * 
	 * @author José Henriquez en fecha 06-04-2015 modificado por pureba
	 * 
	 */
	public function __construct()
	{
		
		parent::__construct();
		$this->load->library('form_validation');
		$this->load->model('inv_equipos/model_inv_equipos','model_inveq');
		$this->load->model('air_tipoeq/model_air_tipo_eq','model_tipoeq');
		
	}
	
	/**
	 * 
	 * Muestra Pagina con mensaje Inicial y Menú
	 * 
	 * @author José Henriquez en fecha 06-04-2015
	 * 
	 */
	public function index()
	{
		$header['title'] = 'Página de Inicio - Sistema de Inventario';
		$this->load->view('home');
			
	}

	/**
	 * 
	 * Formulario para agregar un equipo a la Tabla
	 * 
	 * @author José Henriquez en fecha 06-04-2015
	 * 
	 */
	public function form_equipo()
	{
		$header['title']='Página de Inicio - Sistema de Inventario';
		$this->load->view('home');
			
	}

	/**
	 * 
	 * Formulario para agregar un equipo a la Tabla
	 * 
	 * @author José Henriquez en fecha 13-04-2015
	 * 
	 */
	
	
	public function nuevo_equipo($field='',$order='')
	{
		// $HEADER Y $VIEW SON LOS ARREGLOS DE PARAMETROS QUE SE LE PASAN A LAS VISTAS CORRESPONDIENTES
		$header['title'] = 'Crear Equipo de Aire Acondicionado';
		


		if($_POST)
		{
			$post = $_POST;
			
			// REGLAS DE VALIDACION DEL FORMULARIO PARA CREAR USUARIOS NUEVOS
			$this->form_validation->set_error_delimiters('<div class="col-md-3"></div><div class="col-md-7 alert alert-danger" style="text-align:center">','</div><div class="col-md-2"></div>');
			$this->form_validation->set_rules('nombre','<strong>Nombre del Equipo</strong>','trim|required|xss_clean');
			$this->form_validation->set_rules('inv_uc','<strong>Inventario UC</strong>','trim|required|xss_clean');
			$this->form_validation->set_rules('marca','<strong>Marca</strong>','trim|required|xss_clean');
			$this->form_validation->set_rules('modelo','<strong>Modelo</strong>','trim|required|xss_clean');
			$this->form_validation->set_message('required', '%s es Obligatorio');
			

			if($this->form_validation->run($this))
			//if(1)
			{
				
				$eq = $this->model_inveq->insert_eq($post);
				if($eq != FALSE)
				{
					$this->session->set_flashdata('nuevo_equipo','success');
					redirect(base_url().'index.php/inv_equipos/equipos/index');
				}
			}
			
		}
		$header["tipoeqs"]=$this->model_tipoeq->get_alltipo();
		$this->session->set_flashdata('nuevo_equipo','error');
		$this->load->view('template/header',$header);
		$this->load->view('inv_equipos/nuevo_equipo');
		$this->load->view('template/footer');
	}
	

	public function listar_equipos($field='',$order='')
	{
		
		
		$header['title'] = 'Ver Equipos';
		$header['equipos'] = $this->model_inveq->get_alleq();
		
		//if(!empty($field))
		//{
		//	switch ($field)
		//	{
		//		case 'orden_CI': $field = 'id_usuario'; break;
		//		case 'orden_nombre': $field = 'nombre'; break;
		//		case 'orden_tipousuario': $field = 'tipo'; break;
		//		default: $field = 'id_usuario'; break;
		//	}
		//}
		//$order = (empty($order) || ($order == 'asc')) ? 'desc' : 'asc';
		//$usuarios = $this->model_dec_usuario->get_allusers($field,$order);
		// PARA VER LA INFORMACION DE LOS USUARIOS DESCOMENTAR LA LINEA DE ABAJO, GUARDAR Y REFRESCAR EL EXPLORADOR
		// die_pre($usuarios);
		//$view['users'] = $usuarios;
		//$view['order'] = $order;
		
		//CARGAR LAS VISTAS GENERALES MAS LA VISTA DE VER USUARIO
		$this->load->view('template/header',$header);
		//$this->load->view('user/lista_usuario',$view);
		$this->load->view('inv_equipos/listar_equipos');
		$this->load->view('template/footer');
	}
	
	
}
