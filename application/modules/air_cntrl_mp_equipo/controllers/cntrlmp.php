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
		$this->load->model('dec_dependencia/model_dec_dependencia', 'model_dep');
        $this->load->model('mnt_ubicaciones/model_mnt_ubicaciones_dep', 'model_ubic');
        $this->load->model('inv_equipos/model_inv_equipos', 'model_equip');
       
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
			$control = $this->model->get_allcntrl($field,$order);
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
	
    public function crear_cntrl() {

        //llamo a las variables de la funcion de consulta de los modelos
        $view['ubica'] = $this->model_ubic->get_ubicaciones();
        $view['equipo'] = $this->model_equip->get_alleq();
        ($depe = $this->session->userdata('user')['id_dependencia']);
        $view['nombre_depen'] = $this->model_dep->get_nombre_dependencia($depe);
        $view['dependencia'] = $this->model_dep->get_dependencia();
        $view['id_depen'] = $depe;
              
        //die_pre($depe);
        //defino el permiso del usuario
        if ($this->hasPermissionClassA()) {
            // $HEADER Y $VIEW SON LOS ARREGLOS DE PARAMETROS QUE SE LE PASAN A LAS VISTAS CORRESPONDIENTES
            $header['title'] = 'Crear Control';

            if ($_POST) {
                
                //me devuelve la fecha actual
                $this->load->helper('date');
                $datestring = "%Y-%m-%d %h:%i:%s";
                $time = time();
                $fecha2 = mdate($datestring, $time);

                
                //die_pre($ver);
                //die_pre($depe);
                $post = $_POST;
                //die_pre($post);

                // REGLAS DE VALIDACION DEL FORMULARIO PARA CREAR LA ORDEN
                $this->form_validation->set_error_delimiters('<div class="col-md-3"></div><div class="col-md-7 alert alert-danger" style="text-align:center">', '</div><div class="col-md-2"></div>');
                $this->form_validation->set_message('required', '%s es Obligatorio');
                $this->form_validation->set_rules('capacidad', '<strong>Capacidad</strong>', 'trim|required');
                $this->form_validation->set_rules('fecha_mnt', '<strong>Fecha Mant.</strong>', 'trim|required');
                $this->form_validation->set_rules('periodo', '<strong>Periodo</strong>', 'trim|required');
                //$this->form_validation->set_rules('oficina_select', 'trim|required');
                //$this->form_validation->set_rules('observac', '<strong>Observacion</strong>', 'trim|required');
                //$this->form_validation->set_rules('oficina_txt', 'trim|required');

                //die_pre($this->form_validation->run($this));

                if (1) {
                    
                //die_pre($post);                      
                  
                    //arreglo para guardar en tabla mnt_orden_trabajo
                    $data1 = array(
                        'fecha_mp' => $post['fecha_mp'],
                        'id_inv_equipo' => $post['id_equipo'],
                        'capacidad' => $post['capacidad'],
                        'periodo' => $post['periodo'],
                        'creado' => $fecha2,
                        'id_dec_dependencia' => $depe,
                        'id_mnt_ubicaciones_dep' => $oficina_select);

                    die_pre($data1)
                    $cntrl = $this->model->insert_cntrl($data1);
                    
                    redirect('air_cntrl_mp_equipo/cntrlmp/index');
                  
                }
            } //$this->session->set_flashdata('create_orden','error');

            $this->load->view('template/header', $header);
            $this->load->view('air_cntrl_mp_equipo/nuevo_control', $view);
            $this->load->view('template/footer');
        } else {
            $header['title'] = 'Error de Acceso';
            $this->load->view('template/erroracc', $header);
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
/* End of file cntrlmp.php */
/* Location: ./application/modules/air_cntrl_mp_equipo/controllers/cntrlmp.php */
		
}