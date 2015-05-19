<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Orden extends MX_Controller
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
        $this->load->model('mnt_tipo/model_mnt_tipo_orden','model');
		$this->load->model('model_mnt_orden_trabajo','model1');
		$this->load->model('mnt_observacion/model_mnt_observacion_orden','model2'); // llamo al modelo desde su ubicacion (carpeta de ubicacion, nombre del modelo)
		$this->load->model('mnt_ubicaciones/model_mnt_ubicaciones_dep','model3');
				
    }
    public function index()
	{

		$this->load->view('nueva_orden');

	}

// PARA CREAR UNA NUEVA ORDEN...

	public function nueva_orden()
	{
		$orden['consulta'] = $this->model->devuelve_tipo();
		$orden['query'] = $this->model3->get_ubicaciones();
		//die_pre($orden);
		
		//die ('llega');
		if($this->hasPermissionClassA())
		{
			// $HEADER Y $VIEW SON LOS ARREGLOS DE PARAMETROS QUE SE LE PASAN A LAS VISTAS CORRESPONDIENTES
			$header['title'] = 'Crear orden';

			if($_POST)
				//se llama al id_dependencia y al usuario con el cual se inicio session

			{   ($depe = $this->session->userdata('user')['id_dependencia']);
				($usu  = $this->session->userdata('user')['id_usuario']);
				//die_pre($dep);
				$post = $_POST;

				
				// REGLAS DE VALIDACION DEL FORMULARIO PARA CREAR LA ORDEN
				$this->form_validation->set_error_delimiters('<div class="col-md-3"></div><div class="col-md-7 alert alert-danger" style="text-align:center">','</div><div class="col-md-2"></div>');
				$this->form_validation->set_message('required', '%s es Obligatorio');
				$this->form_validation->set_rules('nombre_contacto','<strong>Nombre de Contacto</strong>','trim|required');
				$this->form_validation->set_rules('telefono_contacto','<strong>Telefono de Contacto</strong>','trim|required');
				$this->form_validation->set_rules('asunto','<strong>Asunto</strong>','trim|required');
				$this->form_validation->set_rules('descripcion_general','<strong>Descripcion</strong>','trim|required');
				$this->form_validation->set_rules('observac','<strong>Observacion</strong>','trim|required');
				$this->form_validation->set_rules('otro','<strong>Otra Ubicacion</strong>','trim|required');
				
				
				if($this->form_validation->run($this))
				{
					die_pre($post['otro']);
					//arreglo para guardar en tabla mnt_ubicaciones_dep
					$data3 = array(
					'id_dependencia' => $depe,
					'oficina' => $post['otro']);
					$orden = $this->model3->insert_orden($data3);
					//die_pre($data3);
					//arreglo para guardar en tabla mnt_orden_trabajo
					$data1 = array(
					'id_tipo' => $post['id_tipo'],
					'nombre_contacto' => $post['nombre_contacto'],
					'telefono_contacto' => $post['telefono_contacto'],
					'asunto' => $post['asunto'],
					'descripcion_general' => $post['descripcion_general'],
					'dependencia' => $depe,
					'ubicacion' => $post['oficina']);
					$orden = $this->model1->insert_orden($data1);
					//arreglo para guardar en tabla mnt_observacion_orden
					$data2 = array(
					'id_usuario' => $usu,
					'id_orden_trabajo' =>$orden, 
					'observac' => $post['observac']);
					$orden = $this->model2->insert_orden($data2);
					

					if($orden != FALSE)

					{

						$this->session->set_flashdata('create_orden','success');
						redirect(base_url().'index.php/mnt_orden/orden/nueva_orden',$orden);
						
					}
					
				}
				
			}	//$this->session->set_flashdata('create_orden','error');
				$this->load->view('template/header',$header);
				$this->load->view('mnt_orden/nueva_orden',$orden);
				$this->load->view('template/footer');
				

		}
		else
		{
			$header['title'] = 'Error de Acceso';
			$this->load->view('template/erroracc',$header);
		}
	}

	////////////////////////Control de permisologia para usar las funciones
    public function hasPermissionClassA() {//Solo si es usuario autoridad y/o Asistente de autoridad
        return ($this->session->userdata('user')['sys_rol'] == 'autoridad' || $this->session->userdata('user')['sys_rol'] == 'asist_autoridad');
    }

    public function hasPermissionClassB() {//Solo si es usuario "Director de Departamento" y/o "jefe de Almacen"
        return ($this->session->userdata('user')['sys_rol'] == 'director_dep' || $this->session->userdata('user')['sys_rol'] == 'jefe_alm');
    }

    public function hasPermissionClassC() {//Solo si es usuario "Jefe de Almacen"
        return ($this->session->userdata('user')['sys_rol'] == 'jefe_alm');
    }

    public function hasPermissionClassD() {//Solo si es usuario "Director de Departamento"
        return ($this->session->userdata('user')['sys_rol'] == 'director_dep');
    }

    public function isOwner($user = '') {
        if (!empty($user) || $this->session->userdata('user')) {
            return $this->session->userdata('user')['ID'] == $user['ID'];
        } else {
            return FALSE;
        }
    }
 	////////////////////////Fin del Control de permisologia para usar las funciones
    public function ajax_likeSols() {
        //error_log("Hello", 0);
        $sol = $this->input->post('orden');
        //die_pre($solicitud);
        header('Content-type: application/json');
        $query = $this->model_mnt_solicitudes->ajax_likeSols($sol);
        $query = objectSQL_to_array($query);
        echo json_encode($query);
         
        
    }
}