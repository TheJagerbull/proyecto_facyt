<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Usuario extends MX_Controller {

    function __construct() { //constructor predeterminado del controlador
        parent::__construct();
        $this->load->library('form_validation');
<<<<<<< HEAD
        $this->load->library('pagination');
        $this->load->model('model_dec_usuario');
        $this->load->model('dec_dependencia/model_dec_dependencia');
        $this->load->module('dec_permiso/dec_permiso');
    }

    //funcion callback para revisar si existe el usuario en la base de datos
    public function exist_user() {

        $where['id_usuario'] = $this->input->post('id');
        $where['password'] = sha1($this->input->post('password'));

        if (!$this->model_dec_usuario->exist($where)) {
            $this->form_validation->set_message('exist_user', 'Combinación de <strong>Cedula de identidad</strong> y <strong>Contraseña</strong> inválida');
            return FALSE;
        }
        if (!$this->model_dec_usuario->is_active($where)) {
            $this->form_validation->set_message('exist_user', '<strong>EL usuario se encuentra desactivado en el sistema</strong>');
            return FALSE;
        }
        if (!$this->model_dec_usuario->rol_asign($where)) {
            $this->form_validation->set_message('exist_user', '<strong>EL usuario no tiene rol asignado en sistema</strong>');
            return FALSE;
        }
        return TRUE;
    }

    public function index() {
        if (!$this->session->userdata('user')) {
            $this->load->view('log-in');
        } else {
            $header["title"] = 'Página de Inicio';
            $header = $this->dec_permiso->load_permissionsView();
            $this->load->view('template/header', $header);
            $this->load->view('start');
            $this->load->view('template/footer');
        }
    }

    public function login() {//Funciona perfecto
        $post = $_POST;
        $this->load->model('alm_solicitudes/model_alm_solicitudes');
        $this->form_validation->set_error_delimiters('<div class="alert alert-danger">', '</div>');
        $this->form_validation->set_message('required', '%s es Obligatorio');
        $this->form_validation->set_rules('id', '<strong>Cedula de Identidad</strong>', 'trim|required|min_lenght[7]|callback_exist_user|xss_clean');
        $this->form_validation->set_rules('password', '<strong>Contraseña</strong>', 'trim|required|xss_clean');

        if ($this->form_validation->run($this)) {
            //Exito en las validaciones

            $post['password'] = sha1($post['password']); //encripta el password a sha1, para no ser decifrado en la BD
            $user = $this->model_dec_usuario->existe($post);
            if ($user) {
                if ($user->status != 'inactivo') {
                    if ($user->sys_rol != 'no_visible') {
                        //Si no esta mala la consulta, mostrar vista bonita "redirect('nombre de la vista')"
                        $plus_user = array('id_usuario' => $user->id_usuario, 'nombre' => $user->nombre, 'ID' => $user->ID, 'apellido' => $user->apellido, 'sys_rol' => $user->sys_rol, 'status' => $user->status, 'id_dependencia' => $user->id_dependencia, 'telefono' => $user->telefono);
                        $this->session->set_userdata('user', $plus_user);
                        ///////////////////// debo extraer si hay alguna solicitud, para cargarla en la session $this->session->userdata('articulos');
                        $cart = $this->model_alm_solicitudes->get_userCart();
                        if ($cart) {
                            // die_pre($cart, __LINE__, __FILE__);
                            $this->session->set_userdata('articulos', $cart['articulos']);
                            $this->session->set_userdata('id_carrito', $cart['id_carrito']);
                        }
                        /////////////////////
                        //die_pre($this->session->all_userdata());
                        redirect('inicio'); //redirecciona con la session de usuario
                    } else {
                        $this->load->view('template/errorsysrol');
                    }
                } else {

                    //die_pre($this->session->all_userdata());
                    $this->load->view('template/errorinact');
                }
            }
        } else {
            //$this->load->view('include/header');
            $this->load->view('user/log-in');
            //$this->load->view('include/footer');
        }
    }

    public function get_usersCount() {
        return($this->model_dec_usuario->get_userCount());
    }

    public function lista_usuarios($field = '', $order = '', $aux = '') {////con mas comentarios, y mejor explicado, para preguntas escribir a Luigiepa87@gmail.com
        // echo_pre($this->session->userdata('query'));
        // echo_pre($field);
        // echo_pre($order);
        // echo_pre($aux);
        if ($this->hasPermissionClassA() || $this->dec_permiso->has_permission('usr', 2) || $this->dec_permiso->has_permission('usr', 3)) {
            $view['dep'] = ($this->session->userdata('user')['id_dependencia']);
            if($this->dec_permiso->has_permission('usr',1)):
                $view['agregar'] = 1;
            else:
                $view['agregar'] = 0;
            endif;
            if($this->dec_permiso->has_permission('usr',5)):
                $view['activa'] = 1;
            else:
                $view['activa'] = 0;
            endif;
            // $HEADER Y $VIEW SON LOS ARREGLOS DE PARAMETROS QUE SE LE PASAN A LAS VISTAS CORRESPONDIENTES
//            if ($field == 'buscar') {//control para parametros pasados a la funcion, sin esto, no se ordenan los resultados de la busqueda
//                $field = $order;
//                $order = $aux;
//            }
//            $per_page = 10; //uso para paginacion (indica cuantas filas de la tabla, por pagina, se mostraran)
//            ///////////////////////////////////////Esta porcion de codigo, separa las URI de ordenamiento de resultados, de las URI de listado comun	
//            if ($this->uri->segment(3) == 'buscar') {//para saber si la "bandera de busqueda" esta activada
//                if (!is_numeric($this->uri->segment(4, 0))) {//para saber si la "bandera de ordenamiento" esta activada
//                    $url = 'index.php/usuario/orden/buscar/' . $field . '/' . $order . '/'; //uso para paginacion
//                    $offset = $this->uri->segment(6, 0); //uso para consulta en BD
//                    $uri_segment = 6; //uso para paginacion
//                } else {
//                    $url = 'index.php/usuario/listar/buscar/'; //uso para paginacion
//                    $offset = $this->uri->segment(4, 0); //uso para consulta en BD
//                    $uri_segment = 4; //uso para paginacion
//                }
//            } else {
//
//                $this->session->unset_userdata('query');
//                if (!is_numeric($this->uri->segment(3, 0))) {
//                    $url = 'index.php/usuario/orden/' . $field . '/' . $order . '/'; //uso para paginacion
//                    $offset = $this->uri->segment(5, 0); //uso para consulta en BD
//                    $uri_segment = 5; //uso para paginacion
//                } else {
//                    $url = 'index.php/usuario/listar/'; //uso para paginacion
//                    $offset = $this->uri->segment(3, 0); //uso para consulta en BD
//                    $uri_segment = 3; //uso para paginacion
//                }
//            }
//            ///////////////////////////////////////Esta porcion de codigo, separa las URI de ordenamiento de resultados, de las URI de listado comun
//
//            $header['title'] = 'Lista de usuarios'; //titulo de la pagina
//
//            if (!empty($field)) {//verifica si se le ha pasado algun valor a $field, el cual indicara en funcion de cual columna se ordenara
//                switch ($field) { //aqui se le "traduce" el valor, al nombre de la columna en la BD
//                    case 'orden_CI': $field = 'id_usuario';
//                        break;
//                    case 'orden_nombre': $field = 'nombre';
//                        break;
//                    case 'orden_tipousuario': $field = 'sys_rol';
//                        break;
//                    case 'orden_status': $field = 'status';
//                        break;
//                    default: $field = '';
//                        break; //en caso que no haya ninguna coincidencia, lo deja vacio
//                }
//            }
//            $order = (empty($order) || ($order == 'asc')) ? 'desc' : 'asc'; //aqui permite cambios de tipo "toggle" sobre la variable $order, que solo puede ser ascendente y descendente
//            // die_pre($field);
//            // $usuarios = $this->model_dec_usuario->get_allusers($field,$order,$per_page, $offset);//el $offset y $per_page deben ser igual a los suministrados a initPagination()
//            // PARA VER LA INFORMACION DE LOS USUARIOS DESCOMENTAR LA LINEA DE ABAJO, GUARDAR Y REFRESCAR EL EXPLORADOR
//            // die_pre($this->session->userdata('query'));
//            if ($_POST) {
//                $this->session->set_userdata('query', $_POST['usuarios']);
//            }
//            if ($this->uri->segment(3) == 'buscar') {//debido a que en la vista hay un pequeno formulario para el campo de busqueda, verifico si no se le ha pasado algun valor
//                // die_pre($this->session->userdata('query'));
//                $view['users'] = $this->buscar_usuario($field, $order, $per_page, $offset); //cargo la busqueda de los usuarios
//                $total_rows = $this->model_dec_usuario->buscar_usrCount($this->session->userdata('query')); //contabilizo la cantidad de resultados arrojados por la busqueda
//                $config = initPagination($url, $total_rows, $per_page, $uri_segment); //inicializo la configuracion de la paginacion
//                $this->pagination->initialize($config); //inicializo la paginacion en funcion de la configuracion
//                $view['links'] = $this->pagination->create_links(); //se crean los enlaces, que solo se mostraran en la vista, si $total_rows es mayor que $per_page
//            } else {//en caso que no se haya captado ningun dato en el formulario
//                $total_rows = $this->get_usersCount(); //uso para paginacion
//                $view['users'] = $this->model_dec_usuario->get_allusers($field, $order, $per_page, $offset);
//                $config = initPagination($url, $total_rows, $per_page, $uri_segment);
//                $this->pagination->initialize($config);
//                $view['links'] = $this->pagination->create_links(); //NOTA, La paginacion solo se muestra cuando $total_rows > $per_page
//            }
//
//            $view['order'] = $order;

            // echo "Current View";
            // die_pre($view);
            //CARGAR LAS VISTAS GENERALES MAS LA VISTA DE VER USUARIO
            $header = $this->dec_permiso->load_permissionsView();
            $this->load->view('template/header', $header);
            $this->load->view('user/lista_usuario',$view);
            $this->load->view('template/footer');
        } else {
            $header['title'] = 'Error de Acceso';
            $this->load->view('template/erroracc', $header);
        }
    }

    // PARA CREAR UN USUARIO ES NECESARIO QUE ESTEN CREADAS LAS SUCURSALES DE LAS FARMACIAS, YA QUE EL USUARIO PIDE SU RIF COMO ATRIBUTO
    public function crear_usuario($field = '', $order = '') {
        if ($this->hasPermissionClassA()) {
            $view['dependencia'] = $this->model_dec_dependencia->get_dependencia();
            // $HEADER Y $VIEW SON LOS ARREGLOS DE PARAMETROS QUE SE LE PASAN A LAS VISTAS CORRESPONDIENTES
            $header['title'] = 'Crear usuario';
            if ($_POST) {
                $post = $_POST;
                // REGLAS DE VALIDACION DEL FORMULARIO PARA CREAR USUARIOS NUEVOS
                $this->form_validation->set_error_delimiters('<div class="col-md-3"></div><div class="col-md-7 alert alert-danger" style="text-align:center">', '</div><div class="col-md-2"></div>');
                $this->form_validation->set_rules('nombre', '<strong>Nombre</strong>', 'trim|required|xss_clean');
                $this->form_validation->set_rules('apellido', '<strong>Apellido</strong>', 'trim|required|xss_clean');
                $this->form_validation->set_rules('id_usuario', '<strong>Cedula</strong>', 'trim|required|xss_clean|is_unique[dec_usuario.id_usuario]');
                $this->form_validation->set_rules('email', '<strong>Email</strong>', 'trim|valid_email|min_lenght[8]|xss_clean|is_unique[dec_usuario.email]');
                $this->form_validation->set_rules('telefono', '<strong>Telefono</strong>', 'trim|xss_clean');
                $this->form_validation->set_rules('password', '<strong>Contraseña</strong>', 'trim|required|xss_clean');
                $this->form_validation->set_rules('repass', '<strong>Repetir Contraseña</strong>', 'trim|required|matches[password]|xss_clean');
                $this->form_validation->set_rules('id_dependencia', '<strong>Dependencia</strong>', 'required');
                $this->form_validation->set_rules('cargo', '<strong>Cargo</strong>', 'trim|required|xss_clean');
                $this->form_validation->set_message('is_unique', 'El campo %s ingresado ya existe en la base de datos');
                $this->form_validation->set_message('required', '%s es Obligatorio');
                $this->form_validation->set_message('valid_email', '%s No es un correo valido');
                $this->form_validation->set_message('matches', 'las Contrasenas no corresponden');

                // echo_pre($post);
                if ($this->form_validation->run($this)) {
                    unset($post['repass']);
                    $post['password'] = sha1($post['password']);
                    // SE MANDA EL ARREGLO $POST A INSERTARSE EN LA BASE DE DATOS
                    $user = $this->model_dec_usuario->insert_user($post);
                    if ($user != FALSE) {
                        $this->session->set_flashdata('create_user', 'success');
                        redirect(base_url() . 'index.php/usuario/listar');
                    }
                } else {
                    $this->session->set_flashdata('create_user', 'error');
                    $header = $this->dec_permiso->load_permissionsView();
                    $this->load->view('template/header', $header);
                    $this->load->view('user/crear_usuario', $view);
                    $this->load->view('template/footer');
                }
            } else {
                $header = $this->dec_permiso->load_permissionsView();
                $this->load->view('template/header', $header);
                $this->load->view('user/crear_usuario', $view);
                $this->load->view('template/footer');
            }
        } else {
            $header['title'] = 'Error de Acceso';
            $this->load->view('template/erroracc', $header);
        }
    }

    // RECIBE POR URL EL ID DEL USUARIO A EDITAR
    public function detalle_usuario($id_usuario = '') {
        if ($this->session->userdata('user')) {
            // $HEADER Y $VIEW SON LOS ARREGLOS DE PARAMETROS QUE SE LE PASAN A LAS VISTAS CORRESPONDIENTES
            $header['title'] = 'Detalle de usuario';
            if (!empty($id_usuario)) {
                $user = $this->model_dec_usuario->get_oneuser($id_usuario);
                $view['user'] = $user;

                $view['dependencia'] = $this->model_dec_dependencia->get_dependencia();
                //CARGAR LAS VISTAS GENERALES MAS LA VISTA DE VER USUARIO
                $header = $this->dec_permiso->load_permissionsView();
                $this->load->view('template/header', $header);
                if ($this->session->userdata('user')['ID'] == $user->ID) {
                    $view['edit'] = TRUE;
                    $this->load->view('user/ver_usuario', $view);
                } else {
                    if ($this->hasPermissionClassA()) {
                        $view['edit'] = TRUE;
                        $this->load->view('user/ver_usuarios', $view);
                    } else {
                        $header['title'] = 'Error de Acceso';
                        $this->load->view('template/erroracc', $header);
                    }
                }
                $this->load->view('template/footer');
            } else {
                $this->session->set_flashdata('edit_user', 'error');
                redirect(base_url() . 'index.php/usuario/listar');
            }
        } else {
            $header['title'] = 'Error de Acceso';
            $this->load->view('template/erroracc', $header);
        }
    }

    public function modificar_usuario() {
        if ($this->session->userdata('user')) {
            if ($_POST) {
                $post = $_POST;
                echo_pre($post['uri'], __LINE__, __FILE__);
                $uri = $post['uri'];
                unset($post['uri']);
                if (empty($post['telefono']) && ($uri == 'index.php/usuario/listar')) {//solucion temporal para usuarios ajenos
                    $_POST['telefono'] = '000';
                }
                // REGLAS DE VALIDACION DEL FORMULARIO PARA modificar usuarios
                $this->form_validation->set_error_delimiters('<div class="col-md-3"></div><div class="col-md-7 alert alert-danger" style="text-align:center">', '</div><div class="col-md-2"></div>');
                $this->form_validation->set_message('required', '%s es Obligatorio');
                $this->form_validation->set_rules('nombre', '<strong>Nombre</strong>', 'trim|required|xss_clean');
                $this->form_validation->set_rules('apellido', '<strong>Apellido</strong>', 'trim|required|xss_clean');
                $this->form_validation->set_rules('telefono', '<strong>Telefono</strong>', 'trim|required|xss_clean');
                // $this->form_validation->set_rules('id_usuario','<strong>Cedula de Identidad</strong>','trim|required|min_lenght[7]|xss_clean');
                $this->form_validation->set_rules('password', '<strong>Contraseña</strong>', 'trim|xss_clean');
                $this->form_validation->set_rules('repass', '<strong>Repetir Contraseña</strong>', 'trim|matches[password]|xss_clean');
                if ($this->form_validation->run($this)) {
                    $aux = explode(' ', $_POST['nombre']);
                    if (!empty($aux[1])) {
                        $_POST['nombre'] = ucfirst($aux[0]) . " " . ucfirst($aux[1]);
                    }
                    $aux = explode(' ', $_POST['apellido']);
                    if (!empty($aux[1])) {
                        $_POST['apellido'] = ucfirst($aux[0]) . " " . ucfirst($aux[1]);
                    }

                    // die_pre($_POST, __LINE__, __FILE__);
                    if (empty($post['password'])) {
                        unset($post['password']);
                    } else {
                        $post['password'] = sha1($post['password']);
                    }
                    unset($post['repass']);
                    // SE MANDA EL ARREGLO $POST A INSERTARSE EN LA BASE DE DATOS
                    // if($this->hasPermissionClassA()|| $this->isOwner($post))
                    // {
                    $user = $this->model_dec_usuario->edit_user($post);
                    // }
                    if ($user != FALSE) {
                        if ($this->session->userdata('user')['ID'] == $_POST['ID']) {
                            $this->update_session();
                        }
                        $this->session->set_flashdata('edit_user', 'success');
                        redirect(base_url() . $uri);
                    }
                }
//                die_pre($_POST, __LINE__, __FILE__);
                $this->session->set_flashdata('edit_user', 'error');
                redirect(base_url() . $uri);
            }
        } else {
            $header['title'] = 'Error de Acceso';
            $this->load->view('template/erroracc', $header);
        }
    }

    // RECIBE POR URL EL ID DEL USUARIO A ELIMINAR
    public function eliminar_usuario($str = '') {
        if ($this->session->userdata('user') && $this->hasPermissionClassA()) {
            $aux = explode('-', $str);
            $id_usuario = $aux[0];
            unset($aux[0]);
            $aux2 = "";
            foreach ($aux as $value) {
                $aux2 = $aux2 . "/" . $value;
            }
            if (!empty($id_usuario)) {
                $response = $this->model_dec_usuario->drop_user($id_usuario);
                if ($response) {
                    $this->session->set_flashdata('drop_user', 'success');
                    redirect($aux2);
                }
            }
            $this->session->set_flashdata('drop_user', 'error');
            redirect(base_url() . $aux2);
        } else {
            $header['title'] = 'Error de Acceso';
            $this->load->view('template/erroracc', $header);
        }
    }

    public function activar_usuario($str = '') {
        if ($this->session->userdata('user') && $this->hasPermissionClassA()) {
            $aux = explode('-', $str);
            $id_usuario = $aux[0];
            unset($aux[0]);
            $aux2 = "";
            foreach ($aux as $value) {
                $aux2 = $aux2 . "/" . $value;
            }
            if (!empty($id_usuario)) {
                $response = $this->model_dec_usuario->activate_user($id_usuario);
                if ($response) {
                    $this->session->set_flashdata('activate_user', 'success');
                    redirect($aux2);
                }
            }
            $this->session->set_flashdata('activate_user', 'error');
            redirect(base_url() . $aux2);
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
    public function logout() {

        $this->session->sess_destroy();
        redirect('/');
    }

    public function buscar_usuario($field = '', $order = '', $per_page = '', $offset = '') {
        if ($this->session->userdata('query')) {
            //
            if ($this->session->userdata('query') == '' || $this->session->userdata('query') == ' ') {
                $this->session->unset_userdata('query');

                redirect(base_url() . 'index.php/usuario/listar');
            }
            //die_pre($this->session->userdata('query'));
            $header['title'] = 'Buscar usuarios';
            // $post = $_POST;
            // $request
            return($this->model_dec_usuario->buscar_usr($this->session->userdata('query'), $field, $order, $per_page, $offset));
        } else {
            //die_pre('fin');
            redirect('usuario/listar');
        }
    }

    public function autocomplete() {
        die_pre();
    }

    public function exist_dependencia() {

        $where['id_usuario'] = $this->input->post('id');
        $where['password'] = sha1($this->input->post('password'));

        if (!$this->model_dec_dependencia->exist($where)) {
            $this->form_validation->set_message('exist_dependencia', 'el Identificador de dependencia ya esta siendo usado por una dependencia');
            return FALSE;
        }
        return TRUE;
    }

    public function dependencia() {
        if ($this->session->userdata('user') && $this->hasPermissionClassA()) {
            $header['title'] = 'Control de dependencia';
            $view['dependencias'] = $this->model_dec_dependencia->get_allDependencias();
            if ($_POST) {
                // echo_pre($_POST);
                if ($_POST['opcion'] == 'agregar') {//para editar, pasas un hidden que se llame opcion y el valor es agregar
                    unset($_POST['opcion']);
                    $this->form_validation->set_rules('dependen', '<strong>Dependencia</strong>', 'trim|required|xss_clean');
                    $this->form_validation->set_rules('id_dependencia', '<strong>Identificador de dependencia</strong>', 'trim|required|xss_clean|is_unique[dec_dependencia.id_dependencia]');
                    $this->form_validation->set_message('is_unique', 'El campo %s ingresado ya existe en la base de datos');
                    if ($this->form_validation->run($this)) {
                        $dep = $this->model_dec_dependencia->edit_dependencia($_POST);
                        if ($dep != FALSE) {
                            $this->session->set_flashdata('add_dependencia', '<div class="alert alert-success" style="text-align: center">Dependencia agregada con éxito</div>');
                            redirect('dependencia/listar');
                        }
                    }
                    $this->session->set_flashdata('add_dependencia', '<div class="alert alert-danger" style="text-align: center">Ocurri&oacute; un problema agregando la dependencia</div>');
                    redirect('dependencia/listar');
                }
                if ($_POST['opcion'] == 'editar') {//para editar, pasas un hidden que se llame opcion y el valor es editar
                    unset($_POST['opcion']);
                    $this->form_validation->set_rules('dependen', '<strong>Dependencia</strong>', 'trim|required|xss_clean');
                    $this->form_validation->set_rules('id_dependencia', '<strong>Identificador de dependencia</strong>', 'trim|required|xss_clean|callback_exist_dependencia');
                    if ($this->form_validation->run($this)) {
                        $dep = $this->model_dec_dependencia->set_newDependencia($_POST);
                        if ($dep != FALSE) {
                            $this->session->set_flashdata('edit_dependencia', '<div class="alert alert-success" style="text-align: center">Dependencia editada con éxito</div>');
                            redirect('dependencia/listar');
                        }
                    }
                    $this->session->set_flashdata('edit_dependencia', '<div class="alert alert-danger" style="text-align: center">Ocurri&oacute; un problema editando la dependencia</div>');
                    redirect('dependencia/listar');
                }
            }

            $header = $this->dec_permiso->load_permissionsView();
            $this->load->view('template/header', $header);
            $this->load->view('dec_dependencia/dependencias', $view);
            $this->load->view('template/footer');
        } else {
            $header['title'] = 'Error de Acceso';
            $this->load->view('template/erroracc', $header);
        }
    }

    public function update_session() {
        $user = $this->model_dec_usuario->get_oneuser($this->session->userdata('user')['ID']);
        $this->session->unset_userdata('user');
        $plus_user = array('id_usuario' => $user->id_usuario, 'nombre' => $user->nombre, 'ID' => $user->ID, 'apellido' => $user->apellido, 'sys_rol' => $user->sys_rol, 'status' => $user->status, 'id_dependencia' => $user->id_dependencia, 'telefono' => $user->telefono);
        $this->session->set_userdata('user', $plus_user);
    }

    // public function jq_buscar_usuario()
    // {
    // 	$keyword = $this->input->post('busqueda');
    // 	 $data['response'] = 'false'; //Set default response
    // 	 $query = $this->model_dec_usuario->buscar_usr($keyword); //Model DB search
    // 	 if($query->num_rows() > 0){
    // 	    $data['response'] = 'true'; //Set response
    // 	    $data['message'] = array(); //Create array
    // 	    foreach($query->result() as $row){
    // 	 	  $data['message'][] = array('label'=> $row->friendly_name, 'value'=> $row->friendly_name); //Add a row to array
    // 	    }
    // 	 }
    // 	 echo json_encode($data);
    // }

    public function ajax_likeUsers() {
        // error_log("Hello", 0);
        $this->load->model('model_dec_usuario');
        $usuario = $this->input->post('usuarios');
        header('Content-type: application/json');
        $query = $this->model_dec_usuario->ajax_likeUsers($usuario);
        $query = objectSQL_to_array($query);
        echo json_encode($query);
    }

    function list_user() { // Para crear la nueva tabla con los usuarios
        if ($this->session->userdata('user') && $this->hasPermissionClassA()) {
            $results = $this->model_dec_usuario->get_list(); //Va al modelo para tomar los datos para llenar el datatable
            echo json_encode($results); //genera la salida de datos
           
        }
    }

/////////no pertenece al proyecto

        /* End of file usuario.php */
        /* Location: ./application/modules/user/controllers/usuario.php */
    }
    
