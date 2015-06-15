<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Cntrlmp extends MX_Controller
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
		$this->load->model('model_air_cntrl_mp_equipo','model');
    }

	/**
	 * 
	 * Metodo Index.
	 * 
	 * Creado por @jahenriq 15-06-2015
	 */
	public function index($field='',$order='')
	{
		
		if($this->hasPermissionClassA())
		{
			
			$header['title'] = 'Ver Control de Mantenimiento Preventivo';
			
			if(!empty($field))
			{
				switch ($field)
				{
					case 'orden_id_inv_equipo': $field = 'id_inv_equipo'; break;
					case 'orden_fecha_mp': $field = 'fecha_mp'; break;
					default: $field = 'id'; break;
				}
			}
			$order = (empty($order) || ($order == 'asc')) ? 'desc' : 'asc';
			$control = $this->model->get_allcontrol($field,$order);
			// PARA VER LA INFORMACION DE LOS USUARIOS DESCOMENTAR LA LINEA DE ABAJO, GUARDAR Y REFRESCAR EL EXPLORADOR
			
			if($_POST)
			{
				$view['control'] = $this->buscar_control();
			}
			else
			{
				$view['control'] = $control;
			}
			$view['order'] = $order;
			
			//CARGAR LAS VISTAS GENERALES MAS LA VISTA DE LOS TIPOS
			$this->load->view('template/header',$header);
			$this->load->view('air_cntrl_mp_equipo/lista_control',$view);
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
	public function buscar_control()
	{
		if($_POST)
		{
			$header['title'] = 'Buscar Control Mantenimiento';
			$post = $_POST;
			return($this->model->buscar_tipo($post['control']));
			
		}else
		{
			//die_pre('fin');
			redirect('air_cntrl_mp_equipo/cntrlmp/index');
		}
	}
	/**
	 * 
	 * 
	 * 
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
/* End of file cntrlmp.php */
/* Location: ./application/modules/air_cntrl_mp_equipo/controllers/cntrlmp.php */
		
}