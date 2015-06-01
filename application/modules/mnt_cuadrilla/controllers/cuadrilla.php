<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * Controlador Principal Modulo mnt_cuadrilla
 */
class Cuadrilla extends MX_Controller {

    /** Constructor */
    public function __construct() {
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->model('model_mnt_cuadrilla', 'model');
    }

    public function index($field = '', $order = '') {
        
        if ($this->hasPermissionClassA()) {
            // $HEADER Y $VIEW SON LOS ARREGLOS DE PARAMETROS QUE SE LE PASAN A LAS VISTAS CORRESPONDIENTES
            $header['title'] = 'Ver Cuadrilla';

            if (!empty($field)) {
                switch ($field) {
                    case 'orden_codigo': $field = 'id';
                        break;
                    case 'orden_nombre': $field = 'cuadrilla';
                        break;
                    default: $field = 'id';
                        break;
                }
            }
            $order = (empty($order) || ($order == 'asc')) ? 'desc' : 'asc';
            $item = $this->model->get_allitem($field, $order);

            
            if ($_POST) {
                $view['item'] = $this->buscar_cuadrilla();
            } else {
                $view['item'] = $item;
            }
            $view['order'] = $order;

            //CARGAR LAS VISTAS GENERALES MAS LA VISTA DE VER USUARIO
            $this->load->view('template/header', $header);
            $this->load->view('mnt_cuadrilla/listar_cuadrillas', $view);
            $this->load->view('template/footer');
        } else {
            $header['title'] = 'Error de Acceso';
            $this->load->view('template/erroracc', $header);
        }
    }

    public function buscar_cuadrilla() {
        if ($_POST) {
            $header['title'] = 'Buscar Cuadrilla';
            $post = $_POST;
            return($this->model->buscar_cuadrilla($post['item']));
        } else {
            redirect('mnt_cuadrilla/cuadrilla/index');
        }
    }

    /**
     * 
     * Metodo 
     * =====================
     * En este metodo, se hace una busqueda de Item especificado y se muestra el detalle para ser editado
     * @author   en fecha: 28/04/2015
     * 
     */
    public function detalle_cuadrilla($id = '') {

        $header['title'] = 'Detalle Item de Cuadrilla';
        if (!empty($id)) {
            $item = $this->model->get_oneitem($id);
            $view['item'] = $item;

            //CARGAR LAS VISTAS GENERALES MAS LA VISTA DE VER ITEM
            $this->load->view('template/header', $header);
            if ($this->session->userdata('item')['id'] == $item->id) {
                $view['edit'] = TRUE;
                $this->load->view(' mnt_cuadrilla/mod_item', $view);
            } else {
                if ($this->hasPermissionClassA()) {
                    $view['edit'] = TRUE;
                    $this->load->view(' mnt_cuadrilla/mod_item', $view);
                } else {
                    $header['title'] = 'Error de Acceso';
                    $this->load->view('template/erroracc', $header);
                }
            }
            $this->load->view('template/footer');
        } else {
            $this->session->set_flashdata('edit_item', 'error');
            redirect(base_url() . 'index.php/Cuadrilla/listar');
        }
    }

    public function modificar_item() {
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

    public function eliminar_item($id = '') {
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

}
