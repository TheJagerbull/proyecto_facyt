<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Mnt_solicitudes extends MX_Controller {

    function __construct() { //constructor predeterminado del controlador
        parent::__construct(); //carga los helpers
        $this->load->helper('array');
        $this->load->library('form_validation');
        $this->load->library('pagination');
        $this->load->model('model_mnt_solicitudes'); //cargar los modelos de los cuales se necesitan datos
        $this->load->model('mnt_tipo/model_mnt_tipo_orden', 'model_tipo');
        $this->load->model('dec_dependencia/model_dec_dependencia', 'model_dependen');
        $this->load->model('mnt_ubicaciones/model_mnt_ubicaciones_dep', 'model_ubicacion');
        $this->load->model('mnt_cuadrilla/model_mnt_cuadrilla', 'model_cuadrilla');
        $this->load->model('mnt_asigna_cuadrilla/model_mnt_asigna_cuadrilla', 'model_asigna');
        $this->load->model('mnt_miembros_cuadrilla/model_mnt_miembros_cuadrilla', 'model_miembros_cuadrilla');
        $this->load->model('user/model_dec_usuario', 'model_user');
        $this->load->model('mnt_estatus/model_mnt_estatus', 'model_estatus');
        $this->load->model('mnt_ayudante/model_mnt_ayudante');
        
    }

    //funcionan que devuelve la cantidad de solicitudes en la tabla
    public function get_alls() {
        return($this->model_mnt_solicitudes->get_all());
    }


    // permite listar las solicitudes para la vista consultar solicitud del menu principal
    public function lista_solicitudes($field = '', $order = '', $aux = '') {

        if ($this->hasPermissionClassA() || ($this->hasPermissionClassD())) {
//            $view['asigna'] = $this->model_asigna->get_allasigna();
            $cuadrilla = $this->model_cuadrilla->get_cuadrillas();
//            $miembros = $this->model_miembros_cuadrilla->get_miembros();
            $view['estatus'] = $this->model_estatus->get_estatus2();
            $i = 0;
            foreach ($cuadrilla as $cua):
                $id[$i]['nombre'] = $this->model_user->get_user_cuadrilla($cua->id_trabajador_responsable);
                $cua->nombre = $id[$i]['nombre'];
                $i++;
            endforeach;
//            $i = 0;
//            foreach ($miembros as $miemb):
//                $new[$i]['miembros'] = $this->model_user->get_user_cuadrilla($miemb->id_trabajador);
//                $miemb->miembros = $new[$i]['miembros'];
//                $i++;
//            endforeach;
//                echo_pre($new);
//                echo_pre($miembros);
//                echo_pre($cuadrilla);
            $view['cuadrilla'] = $cuadrilla;
//            $view['miembros'] = $miembros;
//                $nombre = $this->model_user->get_user_cuadrilla($cuadrilla['id_trabajador_responsable']);
//                echo_pre($nombre);
//                echo_pre($view);
            // $HEADER Y $VIEW SON LOS ARREGLOS DE PARAMETROS QUE SE LE PASAN A LAS VISTAS CORRESPONDIENTES
            if ($field == 'buscar') {//control para parametros pasados a la funcion, sin esto, no se ordenan los resultados de la busqueda
                $field = $order;
                $order = $aux;
            }
            $per_page = 10; //uso para paginacion (indica cuantas filas de la tabla, por pagina, se mostraran)
            if ($this->uri->segment(3) == 'buscar') {//para saber si la "bandera de busqueda" esta activada
                if (!is_numeric($this->uri->segment(4, 0))) {//para saber si la "bandera de ordenamiento" esta activada
                    $url = 'index.php/mnt_solicitudes/orden/buscar/' . $field . '/' . $order . '/'; //uso para paginacion
                    $offset = $this->uri->segment(6, 0); //uso para consulta en BD
                    $uri_segment = 6; //uso para paginacion
                } else {
                    $url = 'index.php/mnt_solicitudes/listar/buscar/'; //uso para paginacion
                    $offset = $this->uri->segment(4, 0); //uso para consulta en BD
                    $uri_segment = 4; //uso para paginacion
                }
            } else {
                $this->session->unset_userdata('tmp');
                if (!is_numeric($this->uri->segment(3, 0))) {
                    $url = 'index.php/mnt_solicitudes/orden/' . $field . '/' . $order . '/'; //uso para paginacion
                    $offset = $this->uri->segment(5, 0); //uso para consulta en BD
                    $uri_segment = 5; //uso para paginacion
                } else {
                    $url = 'index.php/mnt_solicitudes/listar/'; //uso para paginacion
                    $offset = $this->uri->segment(3, 0); //uso para consulta en BD
                    $uri_segment = 3; //uso para paginacion
                }
            }
//////////////////////////Esta porcion de codigo, separa las URI de ordenamiento de resultados, de las URI de listado comun

            $header['title'] = 'Ver Solicitudes';

            if (!empty($field)) {//verifica si se le ha pasado algun valor a $field, el cual indicara en funcion de cual columna se ordenara
                switch ($field) { //aqui se le "traduce" el valor, al nombre de la columna en la BD
                    case 'orden': $field = 'id_orden';
                        break;
                    case 'fecha': $field = 'fecha_p';
                        break;
                    case 'responsable': $field = 'nombre';
                        break;
                    case 'dependencia': $field = 'dependen';
                        break;
                    case 'estatus': $field = 'descripcion';
                        break;
                    case 'cuadrilla': $field = 'cuadrilla';
                        break;
                    default: $field = 'id_orden';
                        break;
                    default: $field = '';
                        break; //en caso que no haya ninguna coincidencia, lo deja vacio
                }
            }
            $order = (empty($order) || ($order == 'desc')) ? 'asc' : 'desc';

            if ($_POST) {
                //falta validar cuando envian o no las fecha;
                $this->session->set_userdata('tmp', $_POST);
            }
            //echo_pre($field);
//	     $solicitudes = $this->model_mnt_solicitudes->get_allorden($field,$order,$per_page, $offset);//el $offset y $per_page deben ser igual a los suministrados a initPagination()
//			// PARA VER LA INFORMACION DE LOS USUARIOS DESCOMENTAR LA LINEA DE ABAJO, GUARDAR Y REFRESCAR EL EXPLORADOR
//            die_pre($this->session->userdata('query'));
            if ($this->uri->segment(3) == 'buscar') {//debido a que en la vista hay un pequeno formulario para el campo de busqueda, verifico si no se le ha pasado algun valor
                //die_pre($this->session->userdata('query'));
                $view['mant_solicitudes'] = $this->buscar_solicitud($field, $order, $per_page, $offset); //cargo la busqueda de las solicitudes
                $temp = $this->session->userdata('tmp');
                $total_rows = $this->model_mnt_solicitudes->buscar_solCount($temp['solicitudes'], $temp['fecha']); //contabilizo la cantidad de resultados arrojados por la busqueda
                $config = initPagination($url, $total_rows, $per_page, $uri_segment); //inicializo la configuracion de la paginacion
                $this->pagination->initialize($config); //inicializo la paginacion en funcion de la configuracion
                $view['links'] = $this->pagination->create_links(); //se crean los enlaces, que solo se mostraran en la vista, si $total_rows es mayor que $per_page            
            } else {//en caso que no se haya captado ningun dato en el formulario
                $total_rows = $this->get_alls(); //uso para paginacion
                //echo_pre($per_page);
                //die_pre($total_rows);
                $view['mant_solicitudes'] = $this->model_mnt_solicitudes->get_allorden($field, $order, $per_page, $offset);
                $config = initPagination($url, $total_rows, $per_page, $uri_segment);
                $this->pagination->initialize($config);
                $view['links'] = $this->pagination->create_links(); //NOTA, La paginacion solo se muestra cuando $total_rows > $per_page
            }
            $view['order'] = $order;

//             echo_pre($view['asigna']);
            //  die_pre($view);
//             die_pre($view['mant_solicitudes']);
            //CARGAR LAS VISTAS GENERALES MAS LA VISTA DE VER USUARIO
            $view['ayudantes'] = $this->model_user->get_userObrero();
            //echo_pre($view, __LINE__, __FILE__);
            $this->load->view('template/header', $header);
            $this->load->view('mnt_solicitudes/main', $view);
            $this->load->view('template/footer');
        } else {
            $header['title'] = 'Error de Acceso';
            $this->load->view('template/erroracc', $header);
        }
    }

    public function listado() {// trabajar con el dataTable 
        if ($this->hasPermissionClassA() || ($this->hasPermissionClassD())) {
            $header['title'] = 'Ver Solicitudes';
            $view['cuadrilla'] = $this->model_cuadrilla->get_cuadrillas();
            $view['mant_solicitudes'] = $this->model_mnt_solicitudes->get_ordenes();
            $view['asigna'] = $this->model_asigna->get_allasigna();
//            die_pre($view);
//            die_pre($view['mant_solicitudes']);
            $view['estatus'] = $this->model_estatus->get_estatus2();
            $view['ayudantes'] = $this->model_user->get_userObrero();
//            die_pre($view['ayudantes']);
            $this->load->view('template/header', $header);
            $this->load->view('mnt_solicitudes/solicitudes', $view);
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
            // $view['tipo_solicitud'] = $this->model_tipo->devuelve_tipo();
            // $view['dependencia'] = $this->model_dependen->get_dependencia();
            //$view['ubica'] = $this->model_ubicacion->get_ubicaciones();
            // $view['cuadrilla'] = $this->model_cuadrilla->get_cuadrillas();
            //  $view['miembros'] = $this->model_miembros_cuadrilla->get_miembros();
            //  $view['asigna'] = $this->model_asigna->get_allasigna();
            //foreach ($tipo as $nombre => $nomb):
            $trabajador_id = $tipo['id_trabajador_responsable'];
            //endforeach;
            $view['nombre'] = $this->model_user->get_user_cuadrilla($trabajador_id);
            //echo_pre($trabajador_id);      
//            echo_pre($view['cuadrilla']); 
            // die_pre($view);
////            $view['nombre_cuadrilla']=$this->model_cuadrilla->get_nombre_cuadrilla($id);
//            die_pre($view['nombre_cuadrilla']);
//CARGAR LAS VISTAS GENERALES MAS LA VISTA DE VER ITEM
            $this->load->view('template/header', $header);

            if ($this->session->userdata('tipo')['id'] == $tipo['id_orden']) {
                $view['edit'] = TRUE;
                $this->load->view('mnt_solicitudes/detalle_solicitud', $view);
            } else {
                if ($this->hasPermissionClassA() || ($this->hasPermissionClassD())) {
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

    public function buscar_solicitud($field = '', $order = '', $per_page = '', $offset = '') {
        //die_pre($field);

        if ($this->session->userdata('tmp')) {
            //
            if ($this->session->userdata('tmp') == '' || $this->session->userdata('tmp') == ' ') {
                $this->session->unset_userdata('tmp');
                redirect(base_url() . 'index.php/mnt_solicitudes/listar');
            }
            //die_pre($this->session->userdata('query'));
            $header['title'] = 'Buscar Solicitudes';
            // $post = $_POST;
            $temp = $this->session->userdata('tmp');
            //die_pre($temp['solicitudes']);
            return($this->model_mnt_solicitudes->buscar_sol($temp['solicitudes'], ($temp['fecha']), $field, $order, $per_page, $offset));
        } else {
            //die_pre('fin');
            redirect('mnt_solicitudes/listar');
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
        $solicitud = $this->input->post('solicitudes');
        //die_pre($solicitud);
        header('Content-type: application/json');
        $query = $this->model_mnt_solicitudes->ajax_likeSols($solicitud);
        $query = objectSQL_to_array($query);
        echo json_encode($query);
    }

}
