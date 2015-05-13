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
		$this->load->model('model_mnt_orden_trabajo','model1');
		$this->load->model('mnt_observacion/model_mnt_observacion_orden','model2'); // llamo al modelo desde su ubicacion (carpeta de ubicacion, nombre del modelo)
		$this->load->model('mnt_ubicaciones/model_mnt_ubicaciones_dep','model3');
		
    }

	
	public function index()
	{

		$this->load->view('nueva_orden');
	}


// PARA CREAR UNA NUEVA ORDEN...

	public function nueva_orden($field='',$order='')
	{
		//die ('llega');
		//if($this->hasPermissionClassA())
		{
			// $HEADER Y $VIEW SON LOS ARREGLOS DE PARAMETROS QUE SE LE PASAN A LAS VISTAS CORRESPONDIENTES
			$header['title'] = 'Crear orden';
			if($_POST)
			{
				$post = $_POST;
				
				// REGLAS DE VALIDACION DEL FORMULARIO PARA CREAR LA ORDEN
				$this->form_validation->set_error_delimiters('<div class="col-md-3"></div><div class="col-md-7 alert alert-danger" style="text-align:center">','</div><div class="col-md-2"></div>');
				$this->form_validation->set_rules('id_tipo','<strong>Tipo de Orden</strong>','trim|required|xss_clean');
				$this->form_validation->set_rules('nombre_contacto','<strong>Nombre de Contacto</strong>','trim|required|xss_clean');
				$this->form_validation->set_rules('telefono_contacto','<strong>Telefono de Contacto</strong>','trim|required|xss_clean');
				$this->form_validation->set_rules('Asunto','<strong>Asunto</strong>','trim|required|xss_clean');
				$this->form_validation->set_rules('descripcion_general','<strong>Descripcion</strong>','trim|required|xss_clean');
				$this->form_validation->set_rules('observac','<strong>Observacion</strong>','trim|required|xss_clean');
				$this->form_validation->set_rules('oficina','<strong>Ubicacion</strong>','trim|required|xss_clean');
				$this->form_validation->set_message('is_unique','El campo %s ingresado ya existe en la base de datos');
				$this->form_validation->set_message('required', '%s es Obligatorio');
				
				if($this->form_validation->run($this))
				{
					
					$orden = $this->model1->insert_orden($post);
					$orden = $this->model2->insert_orden($data);
					$orden = $this->model3->insert_orden($data);
					if($orden != FALSE)
					{
						$this->session->set_flashdata('create_orden','success');
						redirect(base_url().'index.php/mnt_orden/orden/nueva_orden');
					}
				}
				
			}
			$this->session->set_flashdata('create_orden','error');
			$this->load->view('template/header',$header);
			$this->load->view('mnt_orden/nueva_orden');
			$this->load->view('template/footer');
		}
		//else
		{
			$header['title'] = 'Error de Acceso';
			$this->load->view('template/erroracc',$header);
		}
	}
}