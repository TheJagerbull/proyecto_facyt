<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Mnt_solicitudes extends MX_Controller {

    function __construct() { //constructor predeterminado del controlador
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->library('pagination');
        $this->load->model('model_mnt_solicitudes');
    }
    
    public function get_alls()
	{
		return($this->model_mnt_solicitudes->get_all());
	}

   
    	public function lista_solicitudes($field='',$order='')
	{
		//die_pre($this->session->all_userdata());
		if($this->hasPermissionClassA())
		{
			// $HEADER Y $VIEW SON LOS ARREGLOS DE PARAMETROS QUE SE LE PASAN A LAS VISTAS CORRESPONDIENTES
			$url = 'index.php/mnt_solicitudes/listar/';
			$total_rows = $this->get_alls();
			$per_page = 5;
			$offset = $this->uri->segment(3, 0);
			$uri_segment = 3;
			// $offset = $this->uri->segment(4) - $per_page;

			// $config['base_url'] = base_url().$url;
	  //       $config['total_rows'] = $total_rows;
	  //       $config['per_page'] = $per_page;
	  //       $config['uri_segment'] = $uri_segment;
	  //       $config['num_links'] = 3;
	        //style template use
				// $config['full_tag_open']='<ul class="pagination pagination-sm">';
				// $config['full_tag_close']='</ul>';
				// $config['first_tag_open'] = $config['last_tag_open']= $config['next_tag_open']= $config['prev_tag_open'] = $config['num_tag_open'] = '<li>';
		  //       $config['first_tag_close'] = $config['last_tag_close']= $config['next_tag_close']= $config['prev_tag_close'] = $config['num_tag_close'] = '</li>';
		  //       $config['cur_tag_open'] = "<li><span><b>";
		  //       $config['cur_tag_close'] = "</b></span></li>";
	        //end style template use
			$config = initPagination($url,$total_rows,$per_page,$uri_segment);
			$this->pagination->initialize($config);
			$header['title'] = 'Ver Solicitudes';
			
			if(!empty($field))
			{
				switch ($field)
				{
					case 'orden': $field = 'id_orden'; break;
					case 'tipo': $field = 'id_tipo_orden'; break;
					default: $field = 'id_orden'; break;
				}
			}
			$order = (empty($order) || ($order == 'desc')) ?  'asc': 'desc';

			$datos = $this->model_mnt_solicitudes->get_allorden($field,$order,$per_page, $offset);
			// PARA VER LA INFORMACION DE LOS USUARIOS DESCOMENTAR LA LINEA DE ABAJO, GUARDAR Y REFRESCAR EL EXPLORADOR
			 //die_pre($datos);
			if($_POST)
			{
				$view['users'] = $this->buscar_usuario();
                                
			}
			else
			{
				$view['users'] = $datos;
                                
			}   

			$view['order'] = $order;
			$view['links'] = $this->pagination->create_links();
			// echo "Current View";
			// die_pre($view);
			//CARGAR LAS VISTAS GENERALES MAS LA VISTA DE VER USUARIO
			$this->load->view('template/header',$header);
			$this->load->view('mnt_solicitudes/main',$view);
			$this->load->view('template/footer');
		}
		else
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
	public function isOwner($user='')
	{
		if(!empty($user)||$this->session->userdata('user'))
		{
			return $this->session->userdata('user')['ID'] == $user['ID'];
		}
		else
		{
			return FALSE;
		}
	}
	////////////////////////Fin del Control de permisologia para usar las funciones

}
