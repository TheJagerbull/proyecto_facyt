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

    public function get_alls() {
        return($this->model_mnt_solicitudes->get_all());
    }

    public function lista_solicitudes($field = '', $order = '') {
        //die_pre($this->session->all_userdata());
        if ($this->hasPermissionClassA()) {
            $per_page = 6; //uso para paginacion (indica cuantas filas de la tabla, por pagina, se mostraran)
            ///////////////////////////////////////Esta porcion de codigo, separa las URI de ordenamiento de resultados, de las URI de listado comun	
            if (!is_numeric($this->uri->segment(3, 0))) {
                $url = 'index.php/mnt_solicitudes/list/' . $field . '/' . $order . '/'; //uso para paginacion
                $offset = $this->uri->segment(5, 0); //uso para consulta en BD
                $uri_segment = 5; //uso para paginacion
            } else {
                $url = 'index.php/mnt_solicitudes/lista/'; //uso para paginacion
                $offset = $this->uri->segment(3, 0); //uso para consulta en BD
                $uri_segment = 3; //uso para paginacion
            }
///////////////////////////////////////Esta porcion de codigo, separa las URI de ordenamiento de resultados, de las URI de listado comun

            $header['title'] = 'Ver Solicitudes';

            if (!empty($field)) {//verifica si se le ha pasado algun valor a $field, el cual indicara en funcion de cual columna se ordenara
                switch ($field) { //aqui se le "traduce" el valor, al nombre de la columna en la BD
                    case 'orden': $field = 'id_orden';
                        break;
                    case 'tipo': $field = 'id_tipo_orden';
                        break;
                    default: $field = 'id_orden';
                        break;
                    default: $field = '';
                        break; //en caso que no haya ninguna coincidencia, lo deja vacio
                }
            }
            $order = (empty($order) || ($order == 'desc')) ? 'asc' : 'desc';      
            if ($_POST) {//debido a que en la vista hay un pequeno formulario para el campo de busqueda, verifico si no se le ha pasado algun valor
                $view['mant_solicitudes'] = $this->buscar_usuario($field, $order, $per_page, $offset); //cargo la busqueda de los usuarios
                $total_rows = $this->model_mnt_solicitudes->buscar_usrCount($_POST['usuarios']); //contabilizo la cantidad de resultados arrojados por la busqueda
                $config = initPagination($url, $total_rows, $per_page, $uri_segment); //inicializo la configuracion de la paginacion
                $this->pagination->initialize($config); //inicializo la paginacion en funcion de la configuracion
                $view['links'] = $this->pagination->create_links(); //se crean los enlaces, que solo se mostraran en la vista, si $total_rows es mayor que $per_page
            } else {//en caso que no se haya captado ningun dato en el formulario
                $total_rows = $this->get_alls(); //uso para paginacion
                $view['mant_solicitudes'] = $this->model_mnt_solicitudes->get_allorden($field, $order, $per_page, $offset);
                $config = initPagination($url, $total_rows, $per_page, $uri_segment);
                $this->pagination->initialize($config);
                $view['links'] = $this->pagination->create_links(); //NOTA, La paginacion solo se muestra cuando $total_rows > $per_page
            }
            $view['order'] = $order;
                    
            // echo "Current View";
            // die_pre($view);
            //CARGAR LAS VISTAS GENERALES MAS LA VISTA DE VER USUARIO
            $this->load->view('template/header', $header);
            $this->load->view('mnt_solicitudes/main', $view);
            $this->load->view('template/footer');
        } else {
            $header['title'] = 'Error de Acceso';
            $this->load->view('template/erroracc', $header);
        }
    }

    
    public function mnt_detalle($id = '') {
       $header['title'] = 'Detalles de la Solicitud';
        if (!empty($id)) {
            $tipo = $this->model_mnt_solicitudes->get_orden($id);
            $view['tipo'] = $tipo;

            //CARGAR LAS VISTAS GENERALES MAS LA VISTA DE VER ITEM
            $this->load->view('template/header', $header);
            if ($this->session->userdata('tipo')['id'] == $tipo->id_orden) {
                $view['edit'] = TRUE;
                $this->load->view('mnt_solicitudes/detalle_solicitud', $view);
            } else {
                if ($this->hasPermissionClassA()) {
                    $view['edit'] = TRUE;
                    $this->load->view('mnt_solicitudes/detalle_solicitud', $view);
                } else {
                    $header['title'] = 'Error de Acceso';
                    $this->load->view('template/erroracc', $header);
                }
            }
            $this->load->view('template/footer');
        } else {
            $this->session->set_flashdata('edit_tipo', 'error');
            redirect(base_url() . 'index.php/mnt_solicitudes/detalle');
        }
        //}
        //else
        //{
        //	$header['title'] = 'Error de Acceso';
        //	$this->load->view('template/erroracc',$header);
        //}
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
