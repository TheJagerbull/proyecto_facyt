<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * Controlador Principal Modulo mnt_cuadrilla
 */
class Cuadrilla extends MX_Controller {

    /**
     * Constructor de la clase Cuadrilla
     * =====================
     * @author Jhessica_Martinez  en fecha: 28/05/2015
     */
    public function __construct() {
        parent::__construct();
        $this->load->helper('array');
        $this->load->library('form_validation');
        $this->load->library('pagination');
        $this->load->model('model_mnt_cuadrilla', 'model');						//permite consultar los datos de la tabla cuadrilla
        $this->load->model('user/model_dec_usuario', 'model_user'); 			//permite consultar los datos de los miembros y responsables
        $this->load->model('mnt_miembros_cuadrilla/model_mnt_miembros_cuadrilla', 'model_miembros_cuadrilla');
    }
    /**
     * Index
     * =====================
     * metodo base. Llamado en la vista inicial del modulo cuadrilla.
     * @author Jhessica_Martinez  en fecha: 28/05/2015
     */
    public function index($field = '', $order = '') {
        
        if ($this->hasPermissionClassA()) {
            
            $header['title'] = 'Ver Cuadrilla';         	//	variable para la vista

            if (!empty($field)) {							// 	identifica el campo desde el que se ordenará
                switch ($field) {
                    case 'orden_codigo': $field = 'id';
                        break;
                    case 'orden_nombre': $field = 'cuadrilla';
                        break;
                    case 'orden_responsable': $field = 'id_trabajador_responsable';
                        break;    
                    default: $field = 'id';					//	si no seleccionó ninguno, toma mnt_cuadrilla.id 
                        break;
                }
            }
            $order = (empty($order) || ($order == 'asc')) ? 'desc' : 'asc'; //asigna valor asc o des a la variable que ordenará
            $item = $this->model->get_allitem($field, $order);				//llama al modelo para obtener todas las cuadrillas
            
            if ($_POST) {
                $view['item'] = $this->buscar_cuadrilla();
            } else {
                $view['item'] = $item;
            }
            $view['order'] = $order;
            foreach ($item as $key => $alfin) {
               $view['nombre'] = $this->model_user->get_user_cuadrilla($alfin['id_trabajador_responsable']);	//busca los datos del responsable en el modulo dec_usuario
            }
           echo_pre($view['nombre']);
            

            
            //CARGA LAS VISTAS GENERALES MAS LA VISTA DE LISTAR CUADRILLA
            $this->load->view('template/header', $header);
            $this->load->view('mnt_cuadrilla/listar_cuadrillas', $view);
            $this->load->view('template/footer');
        } else {
            $header['title'] = 'Error de Acceso';
            $this->load->view('template/erroracc', $header);
        }
    }
    /**
     * buscar_cuadrilla
     * =====================
     *
     * @author Jhessica_Martinez  en fecha: 28/05/2015
     */
    public function buscar_cuadrilla() {
        if ($_POST) {
            $header['title'] = 'Buscar cuadrilla';
            $post = $_POST;
            return($this->model->buscar_cuadrilla($post['item']));
        } else {
            redirect('mnt_cuadrilla/cuadrilla/index');
        }
    }

    /**
     * detalle_cuadrilla
     * =====================
     * En este metodo, se hace una busqueda de la cuadrilla especificada y 
     * muestra el detalle para ser editada.
     * Usada en la vista ver_cuadrilla
     * @author Jhessica_Martinez  en fecha: 28/05/2015
     */
    public function detalle_cuadrilla($id = '') {

        $header['title'] = 'Detalle de cuadrilla';
        if (!empty($id)) {
            $item = $this->model->get_oneitem($id);										//consulta los datos de la cuadrilla seleccionada
            $view['item'] = $item;
            
            $view['nombre'] = $this->model_user->get_user_cuadrilla( $item['id_trabajador_responsable'] );	//busca los datos del responsable en el modulo dec_usuario

            $this->load->view('template/header', $header); 								//cargando las vistas
            if ($this->session->userdata('item')['id'] == $item['id'] ){
                $view['edit'] = TRUE;
                $this->load->view('mnt_cuadrilla/ver_cuadrilla', $view);
            } else {
                if ($this->hasPermissionClassA() ||($this->hasPermissionClassD())) {
                    $view['edit'] = TRUE;
                    $this->load->view('mnt_cuadrilla/ver_cuadrilla', $view);
                } else {
                    $header['title'] = 'Error de Acceso';
                    $this->load->view('template/erroracc', $header);
                }
            }
            $this->load->view('template/footer');
        } else {
            $this->session->set_flashdata('edit_cuadrilla', 'error');
            redirect(base_url() . 'index.php/Cuadrilla/listar');
        }
    }
    /**
     * modificar_cuadrilla
     * =====================
     * @author Jhessica_Martinez  en fecha: 28/05/2015
     */
    public function modificar_cuadrilla() {
        //if($this->session->userdata('item'))
        //{
        if ($_POST) {
            // REGLAS DE VALIDACION DEL FORMULARIO PARA MODIFICAR 
            $this->form_validation->set_error_delimiters('<div class="col-md-3"></div><div class="col-md-7 alert alert-danger" style="text-align:center">', '</div><div class="col-md-2"></div>');
            $this->form_validation->set_message('required', '%s es Obligatorio');
            $this->form_validation->set_rules('id', '<strong>Codigo</strong>', 'trim|required|min_lenght[7]|xss_clean');
            $this->form_validation->set_rules('cuadrilla', '<strong>Descripcion</strong>', 'trim|xss_clean');

            $post = $_POST;

            //print_r($this->form_validation->run($this));
            //die("Llego hast aaqui");
            if ($this->form_validation->run($this)) {

                $iteme = $this->model->edit_item($post);
                if ($iteme != FALSE) {
                    $this->session->set_flashdata('edit_item', 'success');
                    redirect('mnt_cuadrilla/cuadrilla/index');
                }

                $this->detalle_item($post['id']);
            } else {
                $this->session->set_flashdata('edit_item', 'error');
                $this->detalle_item($post['id']);
            }
        }
        //}
        //else
        //{
        //	$header['title'] = 'Error de Acceso';
        //	$this->load->view('template/erroracc',$header);
        //}
    }
    /**
     * eliminar_cuadrilla
     * =====================
     * @author Jhessica_Martinez  en fecha: 28/05/2015
     */
    public function eliminar_cuadrilla($id = '') {
        if ($this->hasPermissionClassA()) {
            if (!empty($id)) {
                $response = $this->model->drop_cuadrilla($id);
                if ($response) {
                    $this->session->set_flashdata('drop_itemprv', 'success');
                    redirect(base_url() . 'index.php/mnt_cuadrilla/cuadrilla/index');
                }
            }
            $this->session->set_flashdata('drop_itemprv', 'error');
            redirect(base_url() . 'index.php/mnt_cuadrilla/cuadrilla/index');
        } else {
            $header['title'] = 'Error de Acceso';
            $this->load->view('template/erroracc', $header);
        }
    }
    /**
     * crear_uadrilla
     * =====================
     * @author Jhessica_Martinez  en fecha: 28/05/2015
     */
    public function crear_cuadrilla() {
        if ($this->hasPermissionClassA()) {

            $header['title'] = 'Crear Cuadrilla de Mantenimiento';
            if ($_POST) {
                $post = $_POST;

                // REGLAS DE VALIDACION DEL FORMULARIO PARA MODIFICAR ITEMS 
                $this->form_validation->set_error_delimiters('<div class="col-md-3"></div><div class="col-md-7 alert alert-danger" style="text-align:center">', '</div><div class="col-md-2"></div>');
                $this->form_validation->set_message('required', '%s es Obligatorio');
                $this->form_validation->set_rules('cod', '<strong>Codigo</strong>', 'trim|required|min_lenght[7]|xss_clean');
                $this->form_validation->set_rules('desc', '<strong>Descripcion</strong>', 'trim|xss_clean');


                if ($this->form_validation->run($this)) {

                    // SE MANDA EL ARREGLO $POST A INSERTARSE EN LA BASE DE DATOS
                    $item1 = $this->model->insert_cuadrilla($post);
                    if ($item1 != FALSE) {
                        $this->session->set_flashdata('create_cuadrilla', 'success');
                        redirect(base_url() . 'index.php/mnt_cuadrilla/cuadrilla/index');
                    }
                }
            }
            $this->session->set_flashdata('create_cuadrilla', 'error');
            $this->load->view('template/header', $header);
            $this->load->view('mnt_cuadrilla/nueva_cuadrilla');
            $this->load->view('template/footer');
        } else {
            $header['title'] = 'Error de Acceso';
            $this->load->view('template/erroracc', $header);
        }
    }

    //--------------------------------------------Control de permisologia para usar las funciones
    //Para usuario = autoridad y/o Asistente de autoridad
    public function hasPermissionClassA() {
        return ($this->session->userdata('user')['sys_rol'] == 'autoridad' || $this->session->userdata('user')['sys_rol'] == 'asist_autoridad');
    }
    //Para usuario = "Director de Departamento" y/o "jefe de Almacen"
    public function hasPermissionClassB() {
        return ($this->session->userdata('user')['sys_rol'] == 'director_dep' || $this->session->userdata('user')['sys_rol'] == 'jefe_alm');
    }
    //Para usuario = "Jefe de Almacen"
    public function hasPermissionClassC() {
        return ($this->session->userdata('user')['sys_rol'] == 'jefe_alm');
    }
    //Para usuario = "Director de Departamento"
    public function hasPermissionClassD() {
        return ($this->session->userdata('user')['sys_rol'] == 'director_dep');
    }

    public function isOwner($user = '') {
        if (!empty($user) || $this->session->userdata('user')) {
            return $this->session->userdata('user')['ID'] == $user['ID'];
        } else {
            return FALSE;
        }
    }
    //-----------------------------------Fin del Control de permisologia para usar las funciones

    //----------------------------Usado para el campo de autocompletado de la vista de cuadrilla (dec_usuarios)
    public function ajax_likeSols() 
    {
        $cuadrilla = $this->input->post('item');            // item es el name del input en la vista
        header('Content-type: application/json');
        $query = $this->model->ajax_likeSols($cuadrilla); 	// pasa la variable al modelo para buscarla en la tabla mnt_cuadrilla
        $query = objectSQL_to_array($query);
        echo json_encode($query);
    }


}
