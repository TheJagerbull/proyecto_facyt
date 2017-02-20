<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Tic_solicitudes extends MX_Controller {

    function __construct() 
    { //constructor predeterminado del controlador
        parent::__construct(); //carga los helpers
        $this->load->helper('array');
        $this->load->library('form_validation');
        $this->load->library('pagination');
        $this->load->model('model_tic_solicitudes'); //cargar los modelos de los cuales se necesitan datos
        $this->load->model('tic_tipo/model_tic_tipo_orden', 'model_tipo');
        $this->load->model('dec_dependencia/model_dec_dependencia', 'model_dependen');
        $this->load->model('mnt_ubicaciones/model_mnt_ubicaciones_dep', 'model_ubicacion');
        $this->load->model('tic_cuadrilla/model_tic_cuadrilla', 'model_cuadrilla');
        $this->load->model('tic_asigna_cuadrilla/model_tic_asigna_cuadrilla', 'model_asigna');
        $this->load->model('tic_miembros_cuadrilla/model_tic_miembros_cuadrilla', 'model_miembros_cuadrilla');
        $this->load->model('user/model_dec_usuario', 'model_user');
        $this->load->model('mnt_estatus/model_mnt_estatus', 'model_estatus');
        $this->load->model('tic_estatus_orden/model_tic_estatus_orden');
        $this->load->model('tic_ayudante/model_tic_ayudante');
        $this->load->model('tic_observacion/model_tic_observacion_orden','tic_observacion');
        $this->load->model('tic_responsable_orden/model_tic_responsable_orden','model_responsable');
        $this->load->model('dec_permiso/model_dec_permiso','dec_permiso');
        $this->load->module('dec_permiso/dec_permiso');
    }

    //funcion que devuelve la cantidad de solicitudes en la tabla
    public function get_alls() 
    {
        return($this->model_tic_solicitudes->get_all());
    }

    public function list_filter()
    {
       if($this->dec_permiso->has_permission('tic', 5) || $this->dec_permiso->has_permission('tic', 9) || $this->dec_permiso->has_permission('tic', 10) || $this->dec_permiso->has_permission('tic', 11) || $this->dec_permiso->has_permission('tic', 13) || $this->dec_permiso->has_permission('tic', 14) || $this->dec_permiso->has_permission('tic', 16) || $this->dec_permiso->has_permission('tic', 17)){
            $this->listado();
       }elseif($this->dec_permiso->has_permission('tic', 7) || $this->dec_permiso->has_permission('tic', 12) || $this->dec_permiso->has_permission('tic', 14)){
           $this->listado_close();
       }elseif($this->dec_permiso->has_permission('tic2',3)){
           $this->listado_null();     
         }else{
            $this->session->set_flashdata('permission', 'error');
            redirect('inicio');
//            $header['title'] = 'Error de Acceso';
//            $this->load->view('template/erroracc',$header);
       }
    }

     
    //Esta funcion se una para construir el json para el llenado del datatable en la vista de solicitudes
    function list_sol($est='') {
        $results = $this->model_tic_solicitudes->get_list($est);//Va al modelo para tomar los datos para llenar el datatable
        echo json_encode($results); //genera la salida de datos
    }
    
    public function listado() 
    {// Listado de solicitudes (trabaja con dataTable) 
        if ($this->dec_permiso->has_permission('tic', 5) || $this->dec_permiso->has_permission('tic', 9) || $this->dec_permiso->has_permission('tic', 10) || $this->dec_permiso->has_permission('tic', 11) || $this->dec_permiso->has_permission('tic', 13) || $this->dec_permiso->has_permission('tic', 14) || $this->dec_permiso->has_permission('tic', 16) || $this->dec_permiso->has_permission('tic', 17)) 
        {           
            $view['dep'] = ($this->session->userdata('user')['id_dependencia']);
            if ($this->dec_permiso->has_permission('tic', 10)) {
                $view['all_status']=1;
            }else{
                $view['all_status']=0;
            }
            if ($this->dec_permiso->has_permission('tic',11)){
                 $view['status_proceso']=1;
            }else{
                $view['status_proceso']=0;
            }
            if ($this->dec_permiso->has_permission('tic', 12)) {
                $view['close']=1;
            }else{
                $view['close']=0;
            }
            if ($this->dec_permiso->has_permission('tic2', 3)) {
                $view['anuladas']=1;
            }else{
                $view['anuladas']=0;
            }
            if ($this->dec_permiso->has_permission('tic', 14)) {
                $view['ver_asig']=1;
            }else{
                $view['ver_asig']=0;
            }
            if ($this->dec_permiso->has_permission('tic',4)){
                 $view['ubicacion']=1;
            }else{
                 $view['ubicacion']=0;
            }
            if ($this->dec_permiso->has_permission('tic',1)){
                 $view['crear']=1;
            }else{
                $view['crear']=0;
            }
            if ($this->dec_permiso->has_permission('tic',2)){
                 $view['crear_dep']=1;
            }else{
                $view['crear_dep']=0;
            }
            if ($this->dec_permiso->has_permission('tic', 17)) {
                $view['edit_status']=1;
//                $view['all_status']=1;
            }else{
//                $view['all_status']=0;
                $view['edit_status']=0;
            }
            if ($this->dec_permiso->has_permission('tic', 15)) {
                $view['resportes']=1;
            }else{
                $view['reportes']=0;
            }
            if ($this->dec_permiso->has_permission('tic', 5)) {
                $view['asig_per']=1;
            }else{
                $view['asig_per']=0;
            }
            
//            echo_pre($view);
            $header = $this->dec_permiso->load_permissionsView();
            $header['title'] = 'Ver Solicitudes';
			$this->load->view('template/header', $header);
            if(isset($view)){
                $this->load->view('tic_solicitudes/solicitudes',$view);
            }else{
                $this->load->view('tic_solicitudes/solicitudes');
            }
            $this->load->view('template/footer');
        }
         else 
        {
            $this->session->set_flashdata('permission', 'error');
            redirect('inicio');
        }
    }
    
    public function listado_close()//Listado de solicitudes cerradas 
    {// Listado para Autoridad (trabaja con dataTable) 
//        echo_pre($this->model_tic_solicitudes->get_califica());
        if ($this->dec_permiso->has_permission('tic', 7) || $this->dec_permiso->has_permission('tic', 12) || $this->dec_permiso->has_permission('tic', 14)) 
        {
            $view['dep'] = ($this->session->userdata('user')['id_dependencia']);
            $view['est'] = 'close';
             if ($this->dec_permiso->has_permission('tic', 15)) {
                $view['resportes']=1;
            }else{
                $view['reportes']=0;
            }
            if ($this->dec_permiso->has_permission('tic', 14)) {
                $view['asig_per']=1;
            }else{
                $view['asig_per']=0;
            }
            if ($this->dec_permiso->has_permission('tic', 9) || $this->dec_permiso->has_permission('tic', 10) || $this->dec_permiso->has_permission('tic', 11) || $this->dec_permiso->has_permission('tic', 13)){
                $view['ver']=1;
            }else{
                $view['ver']=0;
            }
            if ($this->dec_permiso->has_permission('tic',1)){
                 $view['crear']=1;
            }else{
                $view['crear']=0;
            }
            if ($this->dec_permiso->has_permission('tic',2)){
                 $view['crear_dep']=1;
            }else{
                $view['crear_dep']=0;
            }
            if ($this->dec_permiso->has_permission('tic2',3)) {
                $view['anuladas']=1;
            }else{
                $view['anuladas']=0;
            }
            if ($this->dec_permiso->has_permission('tic',7)) {
                $view['califica']=1;
            }else{
                $view['califica']=0;
            }
            $view['cuadrilla'] = $this->model_cuadrilla->get_cuadrillas();
            $mant_solicitudes = $this->model_tic_solicitudes->get_ordenes_close();
            if(!empty($mant_solicitudes)):
                foreach ($mant_solicitudes as $key => $sol):
                    $result[$key] = $sol;
                    if(!empty($sol['id_responsable'])):
                        $result[$key] = $sol;
                        $test = $this->model_responsable->get_responsable($sol['id_orden']);
                        $responsable = $test['nombre'].' '.$test['apellido'];
                        $result[$key]['responsable'] = $responsable;
                    endif;
                endforeach;
                $view['mant_solicitudes'] = $result;
            else:
                $view['mant_solicitudes'] = $mant_solicitudes;
            endif;
//            $view['asigna'] = $this->model_asigna->get_allasigna();
//            echo_pre($view['asigna']);
//           die_pre($view['mant_solicitudes']);
            $view['estatus'] = $this->model_estatus->get_estatus2();
            //$view['creada'] = $this->model_tic_estatus_orden->get_first_fecha('4');
//            $view['ayudantes'] = $this->model_user->get_userObrero();
            $view['ayuEnSol'] = $this->model_tic_ayudante->array_of_orders();
//            die_pre($view['mant_solicitudes'], __LINE__, __FILE__);
            $header = $this->dec_permiso->load_permissionsView();
            $header['title'] = 'Ver Solicitudes';
			$this->load->view('template/header', $header);
            $this->load->view('tic_solicitudes/solicitudes_closed', $view);
            $this->load->view('template/footer');
        }
         else 
        {
           $this->session->set_flashdata('permission', 'error');
           redirect('inicio');
        }
    }
    
        public function listado_null()//Listado de solicitudes anuladas 
    {// Listado para Autoridad (trabaja con dataTable) 
//        echo_pre($this->model_tic_solicitudes->get_califica());
        if ($this->dec_permiso->has_permission('tic2', 3) || $this->dec_permiso->has_permission('tic', 12) || $this->dec_permiso->has_permission('tic', 14)) 
        {
            $view['dep'] = ($this->session->userdata('user')['id_dependencia']);
            $view['est'] = 'anuladas';
             if ($this->dec_permiso->has_permission('tic', 15)) {
                $view['resportes']=1;
            }else{
                $view['reportes']=0;
            }
             if ($this->dec_permiso->has_permission('tic', 12)) {
                $view['close']=1;
            }else{
                $view['close']=0;
            }
            if ($this->dec_permiso->has_permission('tic', 14)) {
                $view['asig_per']=1;
            }else{
                $view['asig_per']=0;
            }
            if ($this->dec_permiso->has_permission('tic', 9) || $this->dec_permiso->has_permission('tic', 10) || $this->dec_permiso->has_permission('tic', 11) || $this->dec_permiso->has_permission('tic', 13)){
                $view['ver']=1;
            }else{
                $view['ver']=0;
            }
            if ($this->dec_permiso->has_permission('tic',1)){
                 $view['crear']=1;
            }else{
                $view['crear']=0;
            }
            if ($this->dec_permiso->has_permission('tic',2)){
                 $view['crear_dep']=1;
            }else{
                $view['crear_dep']=0;
            }
            $view['cuadrilla'] = $this->model_cuadrilla->get_cuadrillas();
            $mant_solicitudes = $this->model_tic_solicitudes->get_ordenes_close();
            if(!empty($mant_solicitudes)):
                foreach ($mant_solicitudes as $key => $sol):
                    $result[$key] = $sol;
                    if(!empty($sol['id_responsable'])):
                        $result[$key] = $sol;
                        $test = $this->model_responsable->get_responsable($sol['id_orden']);
                        $responsable = $test['nombre'].' '.$test['apellido'];
                        $result[$key]['responsable'] = $responsable;
                    endif;
                endforeach;
                $view['mant_solicitudes'] = $result;
            else:
                $view['mant_solicitudes'] = $mant_solicitudes;
            endif;
//            $view['asigna'] = $this->model_asigna->get_allasigna();
//            echo_pre($view['asigna']);
//           die_pre($view['mant_solicitudes']);
            $view['estatus'] = $this->model_estatus->get_estatus2();
            //$view['creada'] = $this->model_tic_estatus_orden->get_first_fecha('4');
//            $view['ayudantes'] = $this->model_user->get_userObrero();
            $view['ayuEnSol'] = $this->model_tic_ayudante->array_of_orders();
//            die_pre($view['mant_solicitudes'], __LINE__, __FILE__);
            $header = $this->dec_permiso->load_permissionsView();
            $header['title'] = 'Ver Solicitudes';
			$this->load->view('template/header', $header);
            $this->load->view('tic_solicitudes/solicitudes_null', $view);
            $this->load->view('template/footer');
        }
         else 
        {
           $this->session->set_flashdata('permission', 'error');
           redirect('inicio');
        }
    }

public function tic_detalle($id = '') // funcion para ver el detalle de una solicitud, se define permisologia.
    {
        if (!empty($id)) {
            $tipo = $this->model_tic_solicitudes->get_orden($id);
//            die_pre($tipo);
            //$nombre = $this->model_user->get_user_cuadrilla($this->session->userdata('user')['id_usuario']);
            $usr_make_sol = $this->model_tic_estatus_orden->get_user_make_sol($id);
            if ($this->dec_permiso->has_permission('tic',2)){ //se define permisologia y se redirecciona cuando se edita la solicitud dependiendo el permiso que se le asigne
                $view['action'] =  base_url().'tic_solicitudes/tic_solicitudes/editar_solicitud_dep';
                $view['ubica']=($this->model_ubicacion->get_ubicaciones_dependencia($tipo['dependencia']));
            } 
            if ($this->dec_permiso->has_permission('tic',1)){ //se define permisologia y se redirecciona cuando se edita la solicitud dependiendo el permiso que se le asigne
                $view['todas']=1;
                $view['action'] =  base_url().'tic_solicitudes/tic_solicitudes/editar_solicitud';
            }else{
                $view['todas']=0;
            }
            if ($this->dec_permiso->has_permission('tic',16) && $usr_make_sol == $this->session->userdata('user')['id_usuario']){
                 $view['editar']=1;
            }else{
                $view['editar']=0;
            }
            if ($this->dec_permiso->has_permission('tic', 17)) {
                $view['edit_status']=1;
            }else{
                $view['edit_status']=0;
            }
            if ($this->dec_permiso->has_permission('tic',5)){
                $view['asignar']=1;
            }else{
                $view['asignar']=0;
            }
            if ($this->dec_permiso->has_permission('tic',8)){
                $view['observac']=1;
            }else{
                $view['observac']=0;
            }
            if(strtoupper($this->session->userdata('user')['cargo']) != 'JEFE DE CUADRILLA'){
                $view['agre_observa']=1;
            }else{
                $view['agre_observa']=0;
            }
           
            //die_pre($tipo);
            $view['tipo'] = $tipo;
            $view['tipo_solicitud'] = $this->model_tipo->devuelve_tipo();
            $view['dependencia'] = $this->model_dependen->get_dependencia();
            $view['responsable'] = $this->model_responsable->get_responsable($id);
            $trabajador_id = $tipo['id_trabajador_responsable'];
            $view['nombre'] = $this->model_user->get_user_cuadrilla($trabajador_id);
            $cuadrilla = $this->model_tic_ayudante->ayudantesDeCuadrilla_enOrden($id, $tipo['id_cuadrilla']);
            $ayudantes = $this->model_tic_ayudante->ayudantes_DeOrden($id);
            $view['creada'] = $this->model_tic_estatus_orden->get_first_fecha($id);
            $autor = $this->model_tic_estatus_orden->get_user_make_sol($id); 
            $view['autor'] = $this->model_user->get_user_cuadrilla($autor);
            $view['oficina'] = $this->model_ubicacion->obtener_ubicacion($tipo['id_dependencia'],$tipo['ubicacion']);
            $view['todos'] = $this->model_user->get_user_activos();
            $view['estatus'] = $this->model_estatus->get_estatus2();
            $view['miembros'] = $this->model_cuadrilla->get_cuadrillas();
            $view['ayuEnSol'] = $this->model_tic_ayudante->array_of_orders();
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
            $view['observacion'] = $this->tic_observacion->get_observacion($id);
            //echo_pre($view);
            //CARGAR LAS VISTAS GENERALES MAS LA VISTA DE VER ITEM
            $header = $this->dec_permiso->load_permissionsView();
            $header['title'] = 'Detalles de la Solicitud';
			$this->load->view('template/header', $header);
            if ($this->session->userdata('tipo')['id'] == $tipo['id_orden']) 
            {
                $view['edit'] = TRUE;
                $this->load->view('tic_solicitudes/detalle_solicitud', $view);
            } 
            else 
            {
                if ($this->dec_permiso->has_permission ('tic',13) || $this->dec_permiso->has_permission ('tic',16))
                {
                    $view['edit'] = TRUE;
                    $this->load->view('tic_solicitudes/detalle_solicitud', $view);
                } 
                else 
                {
                    $this->session->set_flashdata('permission', 'error');
                    redirect('inicio');
                }
            }
            $this->load->view('template/footer');
        } else {
            $this->session->set_flashdata('permission', 'error');
            redirect('inicio');
        }
    }
    
 public function editar_solicitud() // funcion para editar solicitud puede editar tiene la opcion de editar la dependencia 
    {
//        die_pre($_POST);
        $solic = $_POST['id'];

        if (isset($_POST['data'])) 
        {
            ($usu = $this->session->userdata('user')['id_usuario']);
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
            $this->model_tic_solicitudes->actualizar_orden($data1,$solic);
//            if(isset($_POST['observac'])):
//                $data2 = array(
//                    'observac' => strtoupper($_POST['observac']));
//                $this->tic_observacion->actualizar_orden($data2,$solic);
//            endif;
            $data3 = array(
                        'id_estado' => '1',
                        'id_orden_trabajo' => $_POST['id'], //llamo a $orden2 para que devuel el id de orden
                        'id_usuario' => $usu,
                        'fecha_p' => $fecha,
                        'motivo_cambio' => 'edicion');
            $orden = $this->model_tic_estatus_orden->insert_orden($data3);

            if ($solic != FALSE) 
            {
                $this->session->set_flashdata('actualizar_orden', 'success');
                redirect(base_url() . 'tic_solicitudes/detalle/'.$solic);
            }


            $this->tic_detalle($solic);
        }elseif(isset($_POST['img'])){
            if(($_FILES['archivo']['error'])== 0){
//                die_pre($_POST);
//                echo_pre('./'.$_POST['ruta']);
                if(isset($_POST['ruta'])){
                    $del = unlink('./'.$_POST['ruta']);
                }
                $dir = './uploads/tic/solicitudes'; //para enviar a la funcion de guardar imagen
                $tipo = 'gif|jpg|png|jpeg'; //Establezco el tipo de imagen
                $mi_imagen = 'archivo'; // asigno en nombre del input_file a $mi_imagen
                if ($this->model_cuadrilla->guardar_imagen($dir, $tipo, '', $mi_imagen) == 'exito') {
                    $ext = ($this->upload->data());
                    $ruta = 'uploads/tic/solicitudes/' . $ext['file_name']; //para guardar en la base de datos
                    $datos = array(//Guarda la ruta en la tabla respectiva ----
                        'ruta' => $ruta
                    );
                    $this->model_tic_solicitudes->actualizar_orden($datos, $_POST['id']); //actualiza en la base de datos este campo
                } else {
                    $view['error'] = ($this->model_cuadrilla->guardar_imagen($dir, $tipo, '', $mi_imagen));
                }
                
                if ($solic != FALSE) 
                {
                    $this->session->set_flashdata('actualizar_foto', 'success');
                    redirect(base_url() . 'tic_solicitudes/detalle/'.$solic);
                }
            
            }else{
                $this->session->set_flashdata('actualizar_foto', 'error');
                redirect(base_url() . 'tic_solicitudes/detalle/'.$solic);
            }
        }else 
        {
            $this->session->set_flashdata('permission', 'error');
            redirect('inicio');
        }
    }
    public function editar_solicitud_dep() // funcion para editar solicitud puede editar no tiene permitido editar la dependencia 
    {
//        echo_pre($_FILES);
//        die_pre($_POST);
        $solic = $_POST['id'];

        if (isset($_POST['data'])) 
        {
            ($usu = $this->session->userdata('user')['id_usuario']);
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
            $this->model_tic_solicitudes->actualizar_orden($data1,$solic);
//            $data2 = array(
//                'observac' => strtoupper($_POST['observac']));
//            $this->tic_observacion->actualizar_orden($data2,$solic);
            $data3 = array(
                        'id_estado' => '1',
                        'id_orden_trabajo' => $_POST['id'], //llamo a $orden2 para que devuel el id de orden
                        'id_usuario' => $usu,
                        'fecha_p' => $fecha,
                        'motivo_cambio' => 'edicion');
            $orden = $this->model_tic_estatus_orden->insert_orden($data3);
            if ($solic != FALSE) 
            {
                $this->session->set_flashdata('actualizar_orden', 'success');
                redirect(base_url() . 'tic_solicitudes/detalle/'.$solic);
            }

            $this->tic_detalle($solic);
        }elseif(isset($_POST['img'])){
           if(($_FILES['archivo']['error'])== 0){
//                die_pre($_POST);
//                echo_pre('./'.$_POST['ruta']);
                $del = unlink('./'.$_POST['ruta']);
                if($del){
                    $dir = './uploads/tic/solicitudes'; //para enviar a la funcion de guardar imagen
                    $tipo = 'gif|jpg|png|jpeg'; //Establezco el tipo de imagen
                    $mi_imagen = 'archivo'; // asigno en nombre del input_file a $mi_imagen
                    if ($this->model_cuadrilla->guardar_imagen($dir, $tipo, '', $mi_imagen) == 'exito') {
                        // AQUI TERMINA
                        $ext = ($this->upload->data());
                        $ruta = 'uploads/tic/solicitudes/' . $ext['file_name']; //para guardar en la base de datos
                        $datos = array(//Guarda la ruta en la tabla respectiva ----
                            'ruta' => $ruta
                        );
                        $this->model_tic_solicitudes->actualizar_orden($datos, $_POST['id']); //actualiza en la base de datos este campo
                    } else {
                        $view['error'] = ($this->model_cuadrilla->guardar_imagen($dir, $tipo, '', $mi_imagen));
                    }
                }
                if ($solic != FALSE) 
                {
                    $this->session->set_flashdata('actualizar_foto', 'success');
                    redirect(base_url() . 'tic_solicitudes/detalle/'.$solic);
                }
            
            }else{
                $this->session->set_flashdata('actualizar_foto', 'error');
                redirect(base_url() . 'tic_solicitudes/detalle/'.$solic);
            } 
        }else 
        {
            $header['title'] = 'Error de Acceso';
            $this->load->view('template/erroracc', $header);
        }
    }

//funcion para crear pdf
    public function pdf($id='') 
    { // llamo a las funciones con sus modelos para obtener la informacion a mostrar en el pdf
        $tipo = $this->model_tic_solicitudes->get_orden($id);
        $view['tipo'] = $tipo;  
        $view['responsable'] = $this->model_responsable->get_responsable($id);
        $trabajador_id = $tipo['id_trabajador_responsable'];
        $view['nombre'] = $this->model_user->get_user_cuadrilla($trabajador_id);
        $cuadrilla = $this->model_tic_ayudante->ayudantesDeCuadrilla_enOrden($id, $tipo['id_cuadrilla']);
        $ayudantes = $this->model_tic_ayudante->ayudantes_DeOrden($id);
        $autor = $this->model_tic_estatus_orden->get_user_make_sol($id); 
        $view['autor'] = $this->model_user->get_user_cuadrilla($autor);
        $view['creada'] = $this->model_tic_estatus_orden->get_first_fecha($id);
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
        $view['observacion'] = $this->tic_observacion->get_observacion($id);
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

     //funcion para crear pdf por dependencia
    public function pdf_dep($id='') 
    {
        $tipo = $this->model_tic_solicitudes->get_orden($id);
        $view['tipo'] = $tipo;  
        $view['responsable'] = $this->model_responsable->get_responsable($id);
        $trabajador_id = $tipo['id_trabajador_responsable'];
        $view['nombre'] = $this->model_user->get_user_cuadrilla($trabajador_id);
        $cuadrilla = $this->model_tic_ayudante->ayudantesDeCuadrilla_enOrden($id, $tipo['id_cuadrilla']);
        $ayudantes = $this->model_tic_ayudante->ayudantes_DeOrden($id);
        $autor = $this->model_tic_estatus_orden->get_user_make_sol($id); 
        $view['autor'] = $this->model_user->get_user_cuadrilla($autor);
        $view['creada'] = $this->model_tic_estatus_orden->get_first_fecha($id);
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
        $view['observacion'] = $this->tic_observacion->get_observacion($id);
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
    { // funcion para crear una sugerencia en solicitudes cerradas
//        die_pre($_POST, __LINE__, __FILE__);
        $uri=$_POST['uri'];
        $id_orden = $_POST['id_orden'];
        $this->load->helper('date');
        $datestring = "%Y-%m-%d %h:%i:%s";
        $time = time();
        $fecha = mdate($datestring, $time);
        if (isset($_POST['sugerencia'])):
            $data2 = array(
            'fecha' => $fecha,
            'star' => ($_POST['star']),
            'sugerencia' => strtoupper($_POST['sugerencia']));
            $this->model_tic_solicitudes->actualizar_orden($data2,$id_orden);
            $this->session->set_flashdata('sugerencia', 'success');
        else:
            $this->session->set_flashdata('sugerencia', 'error');
        endif;
        redirect($uri);
        
    }  

    public function observaciones()
    { // funcion para crear una observacion en view detalle
        $uri=$_POST['uri'];
        $usu =($this->session->userdata('user')['id_usuario']);
        $numsol = $_POST['numsol'];
        if (isset($_POST['observac'])):
            $datos = array(
            'id_usuario' => $usu,
            'id_orden_trabajo' => $numsol,
            'observac' => strtoupper($_POST['observac']));
            $this->tic_observacion->insert_orden($datos);
            $this->session->set_flashdata('observacion', 'success');
        else:
            $this->session->set_flashdata('observacion', 'error');
        endif;
            redirect($uri);
    }
}
