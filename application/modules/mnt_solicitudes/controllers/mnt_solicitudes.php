<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Mnt_solicitudes extends MX_Controller {

    function __construct() 
    { //constructor predeterminado del controlador
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
        $this->load->model('mnt_estatus_orden/model_mnt_estatus_orden');
        $this->load->model('mnt_ayudante/model_mnt_ayudante');
        $this->load->model('mnt_observacion/model_mnt_observacion_orden','mnt_observacion');
    }

    //funcionan que devuelve la cantidad de solicitudes en la tabla
    public function get_alls() 
    {
        return($this->model_mnt_solicitudes->get_all());
    }

    public function list_filter()
    {// Aquí se filtra el tipo de usuario para cargar la vista de listado de solicitudes
        if ($this->hasPermissionClassA())
        {
            $this->listado();
        }
        elseif ($this->hasPermissionClassD())
        {
            $this->listado_dep();
        } else 
        {
            $header['title'] = 'Error de Acceso';
            $this->load->view('template/erroracc', $header);
        }
    }
    // permite listar las solicitudes para la vista consultar solicitud del menu principal
    public function lista_solicitudes($field = '', $order = '', $aux = '')
    {

        if ($this->hasPermissionClassA() || ($this->hasPermissionClassD()))
        {
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
            if ($field == 'buscar')
            {//control para parametros pasados a la funcion, sin esto, no se ordenan los resultados de la busqueda
                $field = $order;
                $order = $aux;
            }
            $per_page = 10; //uso para paginacion (indica cuantas filas de la tabla, por pagina, se mostraran)
            if ($this->uri->segment(3) == 'buscar')
            {//para saber si la "bandera de busqueda" esta activada
                if (!is_numeric($this->uri->segment(4, 0)))
                {//para saber si la "bandera de ordenamiento" esta activada
                    $url = 'index.php/mnt_solicitudes/orden/buscar/' . $field . '/' . $order . '/'; //uso para paginacion
                    $offset = $this->uri->segment(6, 0); //uso para consulta en BD
                    $uri_segment = 6; //uso para paginacion
                }
                else
                {
                    $url = 'index.php/mnt_solicitudes/listar/buscar/'; //uso para paginacion
                    $offset = $this->uri->segment(4, 0); //uso para consulta en BD
                    $uri_segment = 4; //uso para paginacion
                }
            }
            else
            {
                $this->session->unset_userdata('tmp');
                if (!is_numeric($this->uri->segment(3, 0)))
                {
                    $url = 'index.php/mnt_solicitudes/orden/' . $field . '/' . $order . '/'; //uso para paginacion
                    $offset = $this->uri->segment(5, 0); //uso para consulta en BD
                    $uri_segment = 5; //uso para paginacion
                }
                else
                {
                    $url = 'index.php/mnt_solicitudes/listar/'; //uso para paginacion
                    $offset = $this->uri->segment(3, 0); //uso para consulta en BD
                    $uri_segment = 3; //uso para paginacion
                }
            }
//////////////////////////Esta porcion de codigo, separa las URI de ordenamiento de resultados, de las URI de listado comun

            $header['title'] = 'Ver Solicitudes';

            if (!empty($field))
            {//verifica si se le ha pasado algun valor a $field, el cual indicara en funcion de cual columna se ordenara
                switch ($field)
                { //aqui se le "traduce" el valor, al nombre de la columna en la BD
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

            if ($_POST)
            {
                //falta validar cuando envian o no las fecha;
                $this->session->set_userdata('tmp', $_POST);
            }
            //echo_pre($field);
//	     $solicitudes = $this->model_mnt_solicitudes->get_allorden($field,$order,$per_page, $offset);//el $offset y $per_page deben ser igual a los suministrados a initPagination()
//			// PARA VER LA INFORMACION DE LOS USUARIOS DESCOMENTAR LA LINEA DE ABAJO, GUARDAR Y REFRESCAR EL EXPLORADOR
//            die_pre($this->session->userdata('query'));
            if ($this->uri->segment(3) == 'buscar')
            {//debido a que en la vista hay un pequeno formulario para el campo de busqueda, verifico si no se le ha pasado algun valor
                //die_pre($this->session->userdata('query'));
                $view['mant_solicitudes'] = $this->buscar_solicitud($field, $order, $per_page, $offset); //cargo la busqueda de las solicitudes
                $temp = $this->session->userdata('tmp');
                $total_rows = $this->model_mnt_solicitudes->buscar_solCount($temp['solicitudes'], $temp['fecha']); //contabilizo la cantidad de resultados arrojados por la busqueda
                $config = initPagination($url, $total_rows, $per_page, $uri_segment); //inicializo la configuracion de la paginacion
                $this->pagination->initialize($config); //inicializo la paginacion en funcion de la configuracion
                $view['links'] = $this->pagination->create_links(); //se crean los enlaces, que solo se mostraran en la vista, si $total_rows es mayor que $per_page            
            }
            else
            {//en caso que no se haya captado ningun dato en el formulario
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
        }
        else
        {
            $header['title'] = 'Error de Acceso';
            $this->load->view('template/erroracc', $header);
        }
    }

    public function listado() 
    {// Listado para Autoridad (trabaja con dataTable) 
        if ($this->hasPermissionClassA()) 
        {
            $header['title'] = 'Ver Solicitudes';
            $view['cuadrilla'] = $this->model_cuadrilla->get_cuadrillas();
            $view['mant_solicitudes'] = $this->model_mnt_solicitudes->get_ordenes();
//            $view['asigna'] = $this->model_asigna->get_allasigna();
//            echo_pre($view['asigna']);
//           die_pre($view['mant_solicitudes']);
            $view['estatus'] = $this->model_estatus->get_estatus2();
//            $view['ayudantes'] = $this->model_user->get_userObrero();
            $view['ayuEnSol'] = $this->model_mnt_ayudante->array_of_orders();
//            die_pre($view['mant_solicitudes'], __LINE__, __FILE__);
            $this->load->view('template/header', $header);
            $this->load->view('mnt_solicitudes/solicitudes', $view);
            $this->load->view('template/footer');
        }
         else 
        {
            $header['title'] = 'Error de Acceso';
            $this->load->view('template/erroracc', $header);
        }
    }
    
    public function listado_close()//Listado de solicitudes cerradas 
    {// Listado para Autoridad (trabaja con dataTable) 
        if ($this->hasPermissionClassA()) 
        {
            $header['title'] = 'Ver Solicitudes';
            $view['cuadrilla'] = $this->model_cuadrilla->get_cuadrillas();
            $view['mant_solicitudes'] = $this->model_mnt_solicitudes->get_ordenes_close();
//            $view['asigna'] = $this->model_asigna->get_allasigna();
//            echo_pre($view['asigna']);
//           die_pre($view['mant_solicitudes']);
            $view['estatus'] = $this->model_estatus->get_estatus2();
//            $view['ayudantes'] = $this->model_user->get_userObrero();
            $view['ayuEnSol'] = $this->model_mnt_ayudante->array_of_orders();
//            die_pre($view['mant_solicitudes'], __LINE__, __FILE__);
            $this->load->view('template/header', $header);
            $this->load->view('mnt_solicitudes/solicitudes_closed', $view);
            $this->load->view('template/footer');
        }
         else 
        {
            $header['title'] = 'Error de Acceso';
            $this->load->view('template/erroracc', $header);
        }
    }

    public function listado_dep() 
    {// Listado para Director Departamento (trabaja con dataTable) 
        if ($this->hasPermissionClassD()) 
        {
            $dep = ($this->session->userdata('user')['id_dependencia']);
            $header['title'] = 'Ver Solicitudes';
//            $view['cuadrilla'] = $this->model_cuadrilla->get_cuadrillas();
            $view['mant_solicitudes'] = $this->model_mnt_solicitudes->get_ordenes_dep($dep);
//            $view['asigna'] = $this->model_asigna->get_allasigna();
//            echo_pre($view['asigna']);
//            die_pre($view['mant_solicitudes']);
//            $view['estatus'] = $this->model_estatus->get_estatus2();
//            $view['ayudantes'] = $this->model_user->get_userObrero();
//            $view['ayuEnSol'] = $this->model_mnt_ayudante->array_of_orders();
            // die_pre($view['ayuEnSol'], __LINE__, __FILE__);
            $this->load->view('template/header', $header);
            $this->load->view('mnt_solicitudes/solicitudes_dep', $view);
            $this->load->view('template/footer');
        } 
        else 
        {
            $header['title'] = 'Error de Acceso';
            $this->load->view('template/erroracc', $header);
        }
    }
    
    public function listado_dep_close() 
    {// Listado para Director Departamento (trabaja con dataTable) 
        if ($this->hasPermissionClassD()) 
        {
            $dep = ($this->session->userdata('user')['id_dependencia']);
            $header['title'] = 'Ver Solicitudes';
//            $view['cuadrilla'] = $this->model_cuadrilla->get_cuadrillas();
            $view['mant_solicitudes'] = $this->model_mnt_solicitudes->get_ordenes_dep_close($dep);
//            $view['asigna'] = $this->model_asigna->get_allasigna();
//            echo_pre($view['asigna']);
//            die_pre($view['mant_solicitudes']);
//            $view['estatus'] = $this->model_estatus->get_estatus2();
//            $view['ayudantes'] = $this->model_user->get_userObrero();
//            $view['ayuEnSol'] = $this->model_mnt_ayudante->array_of_orders();
            // die_pre($view['ayuEnSol'], __LINE__, __FILE__);
            $this->load->view('template/header', $header);
            $this->load->view('mnt_solicitudes/solicitudes_dep_close', $view);
            $this->load->view('template/footer');
        } 
        else 
        {
            $header['title'] = 'Error de Acceso';
            $this->load->view('template/erroracc', $header);
        }
    }

    public function mnt_detalle($id = '') 
    {
        $header['title'] = 'Detalles de la Solicitud';
        if (!empty($id)) {
            $tipo = $this->model_mnt_solicitudes->get_orden($id);
            //die_pre($tipo);
            $view['tipo'] = $tipo;
            $view['tipo_solicitud'] = $this->model_tipo->devuelve_tipo();
            $view['dependencia'] = $this->model_dependen->get_dependencia();
            $trabajador_id = $tipo['id_trabajador_responsable'];
            $view['nombre'] = $this->model_user->get_user_cuadrilla($trabajador_id);
            $cuadrilla = $this->model_mnt_ayudante->ayudantesDeCuadrilla_enOrden($id, $tipo['id_cuadrilla']);
            $ayudantes = $this->model_mnt_ayudante->ayudantes_DeOrden($id);
            $view['creada'] = $this->model_mnt_estatus_orden->get_first_fecha($id);
            $autor = $this->model_mnt_estatus_orden->get_user_make_sol($id); 
            $view['autor'] = $this->model_user->get_user_cuadrilla($autor);
            $view['oficina'] = $this->model_ubicacion->obtener_ubicacion($tipo['id_dependencia'],$tipo['ubicacion']);
            $view['todos'] = $this->model_user->get_user_activos();
            $view['estatus'] = $this->model_estatus->get_estatus2();
            $view['miembros'] = $this->model_cuadrilla->get_cuadrillas();
            $view['ayuEnSol'] = $this->model_mnt_ayudante->array_of_orders();
//            echo_pre($view);
            $final_ayudantes=array();
            $miembros = array();
            $this->model_asigna->asignados_cuadrilla_ayudantes($cuadrilla, $ayudantes,$final_ayudantes,$miembros);
            if(!empty($cuadrilla)):
              $view['cuadrilla'] = $miembros; //se guarda aca para mostrarlos en la vista 
            endif;
            if(!empty($ayudantes)):
              $view['ayudantes'] = $final_ayudantes;
            endif; 
            $view['observacion'] = $this->mnt_observacion->get_observacion($id);
            //echo_pre($view);
            //CARGAR LAS VISTAS GENERALES MAS LA VISTA DE VER ITEM
            $this->load->view('template/header', $header);
            if ($this->session->userdata('tipo')['id'] == $tipo['id_orden']) 
            {
                $view['edit'] = TRUE;
                $this->load->view('mnt_solicitudes/detalle_solicitud', $view);
            } 
            else 
            {
                if ($this->hasPermissionClassA())
                {
                    $view['edit'] = TRUE;
                    $this->load->view('mnt_solicitudes/detalle_solicitud', $view);
                } 
                else 
                {
                    $header['title'] = 'Error de Acceso';
                    $this->load->view('template/erroracc', $header);
                }
            }
            $this->load->view('template/footer');
        } else {
            $this->session->set_flashdata('edit_tipo', 'error');
            redirect(base_url() . 'index.php/mnt_solicitudes/detalle');
        }
    }
    
      public function mnt_detalle_dep($id = '') 
      {
        $header['title'] = 'Detalles de la Solicitud';
        if (!empty($id)) 
        {
            $tipo = $this->model_mnt_solicitudes->get_orden($id);
            $view['tipo'] = $tipo;
            $view['tipo_solicitud'] = $this->model_tipo->devuelve_tipo();
            $view['ubica'] = $this->model_ubicacion->get_ubicaciones_dependencia($tipo['id_dependencia']);
//            $view['dependencia'] = $this->model_dependen->get_dependencia();
            $trabajador_id = $tipo['id_trabajador_responsable'];
            $view['nombre'] = $this->model_user->get_user_cuadrilla($trabajador_id);
            $cuadrilla = $this->model_mnt_ayudante->ayudantesDeCuadrilla_enOrden($id, $tipo['id_cuadrilla']);
            $ayudantes = $this->model_mnt_ayudante->ayudantes_DeOrden($id);
            $autor = $this->model_mnt_estatus_orden->get_user_make_sol($id); 
            $view['autor'] = $this->model_user->get_user_cuadrilla($autor);
            $view['creada'] = $this->model_mnt_estatus_orden->get_first_fecha($id);
            $view['oficina'] = $this->model_ubicacion->obtener_ubicacion($tipo['id_dependencia'],$tipo['ubicacion']);
            $view['todos'] = $this->model_user->get_user_activos_dep($tipo['id_dependencia']);
//            echo_pre($view);
            $final_ayudantes=array();
            $miembros = array();
            $this->model_asigna->asignados_cuadrilla_ayudantes($cuadrilla, $ayudantes,$final_ayudantes,$miembros);
            if(!empty($cuadrilla)):
              $view['cuadrilla'] = $miembros; //se guarda aca para mostrarlos en la vista 
            endif;
            if(!empty($ayudantes)):
              $view['ayudantes'] = $final_ayudantes;
            endif; 
            $view['observacion'] = $this->mnt_observacion->get_observacion($id);
            //echo_pre($view);
            //CARGAR LAS VISTAS GENERALES MAS LA VISTA DE VER ITEM
            $this->load->view('template/header', $header);
            if ($this->session->userdata('tipo')['id'] == $tipo['id_orden']) 
            {
                $view['edit'] = TRUE;
                $this->load->view('mnt_solicitudes/detalle_solicitud', $view);
            } 
            else 
            {
                if ($this->hasPermissionClassD()) 
                {
                    $view['edit'] = TRUE;
                    $this->load->view('mnt_solicitudes/detalle_solicitud_dep', $view);
                } 
                else 
                {
                    $header['title'] = 'Error de Acceso';
                    $this->load->view('template/erroracc', $header);
                }
            }
            $this->load->view('template/footer');
        } else {
            $this->session->set_flashdata('edit_tipo', 'error');
            redirect(base_url() . 'index.php/mnt_solicitudes/detalles');
        }
    }

    public function editar_solicitud() 
    {
        //die_pre($_POST);
        $solic = $_POST['id'];

        if ($_POST) 
        {

            $this->load->helper('date');
            $datestring = "%Y-%m-%d %h:%i:%s";
            $time = time();
            $fecha = mdate($datestring, $time);
            //die_pre($fecha);
            // REGLAS DE VALIDACION DEL FORMULARIO DETALLE SOLICITUD
            $this->form_validation->set_rules('nombre_contacto', '<strong>Nombre de Contacto</strong>', 'trim|required');
            $this->form_validation->set_rules('telefono_contacto', '<strong>Telefono de Contacto</strong>', 'trim|required');
            $this->form_validation->set_rules('asunto', '<strong>Asunto</strong>', 'trim|required|xss_clean');
            $this->form_validation->set_rules('descripcion_general', '<strong>Descripcion</strong>', 'trim|required|xss_clean');

            $data1 = array(
                'fecha' => $fecha,
                'nombre_contacto' => strtoupper($_POST['nombre_contacto']),
                'telefono_contacto' => $_POST['telefono_contacto'],
                'id_tipo' => $_POST['id_tipo'],
                'asunto' => strtoupper($_POST['asunto']),
                'descripcion_general' => strtoupper($_POST['descripcion_general']),
                'dependencia' => ($_POST['dependencia']),
                'ubicacion' => ($_POST['ubicacion']));
            $this->model_mnt_solicitudes->actualizar_orden($data1,$solic);
            $data2 = array(
                'observac' => strtoupper($_POST['observac']));
            $this->mnt_observacion->actualizar_orden($data2,$solic);

            if ($solic != FALSE) 
            {
                $this->session->set_flashdata('actualizar_orden', 'success');
                redirect(base_url() . 'index.php/mnt_solicitudes/lista_solicitudes');
            }


            $this->mnt_detalle($solic);
        } 
        else 
        {
            $header['title'] = 'Error de Acceso';
            $this->load->view('template/erroracc', $header);
        }
    }
    public function editar_solicitud_dep() 
    {
        //die_pre($_POST);
        $solic = $_POST['id'];

        if ($_POST) 
        {

            $this->load->helper('date');
            $datestring = "%Y-%m-%d %h:%i:%s";
            $time = time();
            $fecha = mdate($datestring, $time);
            //die_pre($fecha);
            // REGLAS DE VALIDACION DEL FORMULARIO DETALLE SOLICITUD
            $this->form_validation->set_rules('nombre_contacto', '<strong>Nombre de Contacto</strong>', 'trim|required');
            $this->form_validation->set_rules('telefono_contacto', '<strong>Telefono de Contacto</strong>', 'trim|required');
            $this->form_validation->set_rules('asunto', '<strong>Asunto</strong>', 'trim|required|xss_clean');
            $this->form_validation->set_rules('descripcion_general', '<strong>Descripcion</strong>', 'trim|required|xss_clean');

            $data1 = array(
                'fecha' => $fecha,
                'nombre_contacto' => strtoupper($_POST['nombre_contacto']),
                'telefono_contacto' => $_POST['telefono_contacto'],
                'id_tipo' => $_POST['id_tipo'],
                'asunto' => strtoupper($_POST['asunto']),
                'descripcion_general' => strtoupper($_POST['descripcion_general']),
                'dependencia' => $this->session->userdata('user')['id_dependencia'],
                'ubicacion' => ($_POST['ubicacion']));
            $this->model_mnt_solicitudes->actualizar_orden($data1,$solic);
            $data2 = array(
                'observac' => strtoupper($_POST['observac']));
            $this->mnt_observacion->actualizar_orden($data2,$solic);

            if ($solic != FALSE) 
            {
                $this->session->set_flashdata('actualizar_orden', 'success');
                redirect(base_url() . 'index.php/mnt_solicitudes/lista_solicitudes');
            }


            $this->mnt_detalle($solic);
        } 
        else 
        {
            $header['title'] = 'Error de Acceso';
            $this->load->view('template/erroracc', $header);
        }
    }

    public function buscar_solicitud($field = '', $order = '', $per_page = '', $offset = '') 
    {
        //die_pre($field);

        if ($this->session->userdata('tmp')) 
        {
            //
            if ($this->session->userdata('tmp') == '' || $this->session->userdata('tmp') == ' ') 
            {
                $this->session->unset_userdata('tmp');
                redirect(base_url() . 'index.php/mnt_solicitudes/listar');
            }
            //die_pre($this->session->userdata('query'));
            $header['title'] = 'Buscar Solicitudes';
            // $post = $_POST;
            $temp = $this->session->userdata('tmp');
            //die_pre($temp['solicitudes']);
            return($this->model_mnt_solicitudes->buscar_sol($temp['solicitudes'], ($temp['fecha']), $field, $order, $per_page, $offset));
        } 
        else 
        {
            //die_pre('fin');
            redirect('mnt_solicitudes/listar');
        }
    }

////////////////////////Control de permisologia para usar las funciones
    public function hasPermissionClassA() 
    {//Solo si es usuario autoridad y/o Asistente de autoridad
        return ($this->session->userdata('user')['sys_rol'] == 'autoridad' || $this->session->userdata('user')['sys_rol'] == 'asist_autoridad');
    }

    public function hasPermissionClassB() 
    {//Solo si es usuario "Director de Departamento" y/o "jefe de Almacen"
        return ($this->session->userdata('user')['sys_rol'] == 'director_dep' || $this->session->userdata('user')['sys_rol'] == 'jefe_alm');
    }

    public function hasPermissionClassC() 
    {//Solo si es usuario "Jefe de Almacen"
        return ($this->session->userdata('user')['sys_rol'] == 'jefe_alm');
    }

    public function hasPermissionClassD() 
    {//Solo si es usuario "Director de Dependencia y/o Asistente de dependencia"
        return ($this->session->userdata('user')['sys_rol'] == 'director_dep' || $this->session->userdata('user')['sys_rol'] == 'asistente_dep');
    }

    public function isOwner($user = '') 
    {
        if (!empty($user) || $this->session->userdata('user')) 
        {
            return $this->session->userdata('user')['ID'] == $user['ID'];
        } 
        else 
        {
            return FALSE;
        }
    }

    ////////////////////////Fin del Control de permisologia para usar las funciones
    public function ajax_likeSols() 
    {
        //error_log("Hello", 0);
        $solicitud = $this->input->post('solicitudes');
        //die_pre($solicitud);
        header('Content-type: application/json');
        $query = $this->model_mnt_solicitudes->ajax_likeSols($solicitud);
        $query = objectSQL_to_array($query);
        echo json_encode($query);
    }

    //funcion para crear pdf
    public function pdf($id='') 
    {
        $tipo = $this->model_mnt_solicitudes->get_orden($id);
        $view['tipo'] = $tipo;  
        $trabajador_id = $tipo['id_trabajador_responsable'];
        $view['nombre'] = $this->model_user->get_user_cuadrilla($trabajador_id);
        $cuadrilla = $this->model_mnt_ayudante->ayudantesDeCuadrilla_enOrden($id, $tipo['id_cuadrilla']);
        $ayudantes = $this->model_mnt_ayudante->ayudantes_DeOrden($id);
        $autor = $this->model_mnt_estatus_orden->get_user_make_sol($id); 
        $view['autor'] = $this->model_user->get_user_cuadrilla($autor);
        $view['creada'] = $this->model_mnt_estatus_orden->get_first_fecha($id);
        $view['oficina'] = $this->model_ubicacion->obtener_ubicacion($tipo['id_dependencia'],$tipo['ubicacion']);
       // $view['todos'] = $this->model_user->get_user_activos_dep($tipo['id_dependencia']);
//      echo_pre($view);
        $final_ayudantes=array();
        $miembros = array();
        $this->model_asigna->asignados_cuadrilla_ayudantes($cuadrilla, $ayudantes,$final_ayudantes,$miembros);
        if(!empty($miembros)):
            $view['cuadrilla'] = $miembros; 
        endif;
        if(!empty($final_ayudantes)):
            $view['ayudantes'] = $final_ayudantes;
        endif; 
        $view['observacion'] = $this->mnt_observacion->get_observacion($id);
        // Load all views as normal
        $this->load->view('pdf_detalle',$view);
        // Get output html
        $html = $this->output->get_output();
        
        // Load library
        $this->load->library('dompdf_gen');
        
        // Convert to PDF
        $this->dompdf->load_html(utf8_decode($html));
        //$this->dompdf->set_base_path('www/test/css/bootstrap.css');
        $this->dompdf->render();
        $this->dompdf->stream("solicitud.pdf", array('Attachment' => 0));
    }

     //funcion para crear pdf departamento
    public function pdf_dep($id='') 
    {
        $tipo = $this->model_mnt_solicitudes->get_orden($id);
        $view['tipo'] = $tipo;  
        $trabajador_id = $tipo['id_trabajador_responsable'];
        $view['nombre'] = $this->model_user->get_user_cuadrilla($trabajador_id);
        $cuadrilla = $this->model_mnt_ayudante->ayudantesDeCuadrilla_enOrden($id, $tipo['id_cuadrilla']);
        $ayudantes = $this->model_mnt_ayudante->ayudantes_DeOrden($id);
        $autor = $this->model_mnt_estatus_orden->get_user_make_sol($id); 
        $view['autor'] = $this->model_user->get_user_cuadrilla($autor);
        $view['creada'] = $this->model_mnt_estatus_orden->get_first_fecha($id);
        $view['oficina'] = $this->model_ubicacion->obtener_ubicacion($tipo['id_dependencia'],$tipo['ubicacion']);
//      echo_pre($view);
        $final_ayudantes=array();
        $miembros = array();
        $this->model_asigna->asignados_cuadrilla_ayudantes($cuadrilla, $ayudantes,$final_ayudantes,$miembros);
        if(!empty($miembros)):
            $view['cuadrilla'] = $miembros; 
        endif;
        if(!empty($final_ayudantes)):
            $view['ayudantes'] = $final_ayudantes;
        endif; 
        $view['observacion'] = $this->mnt_observacion->get_observacion($id);
        // Load all views as normal
        $this->load->view('pdf_detalle_dep',$view);
        // Get output html
        $html = $this->output->get_output();
        
        // Load library
        $this->load->library('dompdf_gen');
        
        // Convert to PDF
        $this->dompdf->load_html(utf8_decode($html));
        $this->dompdf->render();
        $this->dompdf->stream("solicitud.pdf", array('Attachment' => 0));
    }

    public function sugerencias()
    {
        $uri=$_POST['uri'];
        $id_orden = $_POST['id_orden'];
        $this->load->helper('date');
        $datestring = "%Y-%m-%d %h:%i:%s";
        $time = time();
        $fecha = mdate($datestring, $time);
        if (isset($_POST['sugerencia'])):
            $data2 = array(
            'fecha' => $fecha,
            'sugerencia' => strtoupper($_POST['sugerencia']));
            $this->model_mnt_solicitudes->actualizar_orden($data2,$id_orden);
            $this->session->set_flashdata('sugerencia', 'success');
        else:
            $this->session->set_flashdata('sugerencia', 'error');
        endif;
        redirect($uri);
        
    }  

    public function observaciones()
    {
        $uri=$_POST['uri'];
        $usu =($this->session->userdata('user')['id_usuario']);
        $numsol = $_POST['numsol'];
        if (isset($_POST['observac'])):
            $datos = array(
            'id_usuario' => $usu,
            'id_orden_trabajo' => $numsol,
            'observac' => strtoupper($_POST['observac']));
            $this->mnt_observacion->insert_orden($datos);
            $this->session->set_flashdata('observacion', 'success');
        else:
            $this->session->set_flashdata('observacion', 'error');
        endif;
            redirect($uri);
    }  
}
