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
		$this->load->model('model_mnt_solicitudes','model1');
		$this->load->model('mnt_observacion/model_mnt_observacion_orden','model2'); // llamo al modelo desde su ubicacion (carpeta de ubicacion, nombre del modelo)
		$this->load->model('mnt_ubicaciones/model_mnt_ubicaciones_dep','model3');
		$this->load->model('mnt_estatus/model_mnt_estatus','model4');
		$this->load->model('mnt_estatus_orden/model_mnt_estatus_orden','model5');
		
		
				
    }

    public function index()
	{

		$this->load->view('nueva_orden');

	}

// PARA CREAR UNA NUEVA ORDEN...

	public function nueva_orden()
	{
		//llamo a las variables de la funcion de consulta de los modelos
		$view['consulta'] = $this->model->devuelve_tipo();
		$view['query'] = $this->model3->get_ubicaciones();
		
		//die_pre($orden);
		
		//defino el permiso del usuario
		if($this->hasPermissionClassA())
		{
			// $HEADER Y $VIEW SON LOS ARREGLOS DE PARAMETROS QUE SE LE PASAN A LAS VISTAS CORRESPONDIENTES
			$header['title'] = 'Crear orden';

			if($_POST)
				//se llama al id_dependencia y al usuario con el cual se inicio session

			{   ($depe = $this->session->userdata('user')['id_dependencia']);
				($usu  = $this->session->userdata('user')['id_usuario']);
				
				//me devuelve la fecha actual
				$this->load->helper('date');
				$datestring = "%Y-%m-%d %h:%i:%s";
				$time = time();
                $fecha=mdate($datestring, $time);

                //asigno un valor al id del estatus
                $ver='id_estado';
                $ver ="1";

                //die_pre($ver);
				

				

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
				$this->form_validation->set_rules('oficina_select','trim|required');
				$this->form_validation->set_rules('oficina_txt','trim|required');
				
				if($this->form_validation->run($this))
				{
                 	
                  	 //verifica cual de las 2 variables no esta vacia para guardar
                  	if (isset($post['oficina_select'])) {
                      $oficina =  $post['oficina_select'];                   

                  	}else{
                      $oficina =  $post['oficina_txt'];    
                      $data3 = array(
					'id_dependencia' => $depe,
					'oficina' => $oficina);
					$orden = $this->model3->insert_orden($data3);                   
                  	
                  	}
                  	               	
                                 
					//arreglo para guardar en tabla mnt_ubicaciones_dep
					$data3 = array(
					'id_dependencia' => $depe,
					'oficina' => $oficina);
					$orden1 = $this->model3->insert_orden($data3);
					//die_pre($data3);
					//arreglo para guardar en tabla mnt_orden_trabajo
					$data1 = array(
					'id_tipo' => $post['id_tipo'],
					'nombre_contacto' => $post['nombre_contacto'],
					'telefono_contacto' => $post['telefono_contacto'],
					'asunto' => $post['asunto'],
					'descripcion_general' => $post['descripcion_general'],
					'dependencia' => $depe,
					'ubicacion' => $orden1);
					$orden2 = $this->model1->insert_orden($data1);
					//arreglo para guardar en tabla mnt_observacion_orden
					$data2 = array(
					'id_usuario' => $usu,
					'id_orden_trabajo' =>$orden2, //llamo a $orden2 para que devuel el id de orden
					'observac' => $post['observac']);
					$orden3 = $this->model2->insert_orden($data2);
					//arreglo para guardar en tabla mnt_estatus_orden
					//die_pre($orden2);
					$data4 = array(
					'id_estado' => $ver,
					'id_orden_trabajo' =>$orden2, //llamo a $orden2 para que devuel el id de orden
					'id_usuario' => $usu,
					'fecha_p' => $fecha);
					$orden = $this->model5->insert_orden($data4);

					

					if($orden != FALSE)

					{

						$this->session->set_flashdata('create_orden','success');
						redirect(base_url().'index.php/mnt_solicitudes/orden/nueva_orden',$view);
						
					}
					
				}
				
			}	//$this->session->set_flashdata('create_orden','error');
				$this->load->view('template/header',$header);
				$this->load->view('mnt_solicitudes/nueva_orden',$view);
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
        $query = $this->model1->ajax_likeSols($sol);
        $query = objectSQL_to_array($query);
        echo json_encode($query);
         
        
    }
}