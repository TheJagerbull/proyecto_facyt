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
        $this->load->model('mnt_responsable_orden/model_mnt_responsable_orden','model_responsable');
        $this->load->model('dec_permiso/model_dec_permiso','dec_permiso');
        $this->load->module('dec_permiso/dec_permiso');
    }

    //funcion que devuelve la cantidad de solicitudes en la tabla
    public function get_alls() 
    {
        return($this->model_mnt_solicitudes->get_all());
    }

    public function list_filter()
    {
       if($this->dec_permiso->has_permission('mnt', 5) || $this->dec_permiso->has_permission('mnt', 9) || $this->dec_permiso->has_permission('mnt', 10) || $this->dec_permiso->has_permission('mnt', 11) || $this->dec_permiso->has_permission('mnt', 13) || $this->dec_permiso->has_permission('mnt', 14) || $this->dec_permiso->has_permission('mnt', 16) || $this->dec_permiso->has_permission('mnt', 17)){
            $this->listado();
       }elseif($this->dec_permiso->has_permission('mnt', 7) || $this->dec_permiso->has_permission('mnt', 12) || $this->dec_permiso->has_permission('mnt', 14)){
           $this->listado_close();
       }elseif($this->dec_permiso->has_permission('mnt2',3)){
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
        $results = $this->model_mnt_solicitudes->get_list($est);//Va al modelo para tomar los datos para llenar el datatable
        echo json_encode($results); //genera la salida de datos
    }
    
    public function listado() 
    {// Listado de solicitudes (trabaja con dataTable) 
        if ($this->dec_permiso->has_permission('mnt', 5) || $this->dec_permiso->has_permission('mnt', 9) || $this->dec_permiso->has_permission('mnt', 10) || $this->dec_permiso->has_permission('mnt', 11) || $this->dec_permiso->has_permission('mnt', 13) || $this->dec_permiso->has_permission('mnt', 14) || $this->dec_permiso->has_permission('mnt', 16) || $this->dec_permiso->has_permission('mnt', 17)) 
        {           
            $view['dep'] = ($this->session->userdata('user')['id_dependencia']);
            if ($this->dec_permiso->has_permission('mnt', 10)) {
                $view['all_status']=1;
            }else{
                $view['all_status']=0;
            }
            if ($this->dec_permiso->has_permission('mnt',11)){
                 $view['status_proceso']=1;
            }else{
                $view['status_proceso']=0;
            }
            if ($this->dec_permiso->has_permission('mnt', 12)) {
                $view['close']=1;
            }else{
                $view['close']=0;
            }
            if ($this->dec_permiso->has_permission('mnt2', 3)) {
                $view['anuladas']=1;
            }else{
                $view['anuladas']=0;
            }
            if ($this->dec_permiso->has_permission('mnt', 14)) {
                $view['ver_asig']=1;
            }else{
                $view['ver_asig']=0;
            }
            if ($this->dec_permiso->has_permission('mnt',4)){
                 $view['ubicacion']=1;
            }else{
                 $view['ubicacion']=0;
            }
            if ($this->dec_permiso->has_permission('mnt',1)){
                 $view['crear']=1;
            }else{
                $view['crear']=0;
            }
            if ($this->dec_permiso->has_permission('mnt',2)){
                 $view['crear_dep']=1;
            }else{
                $view['crear_dep']=0;
            }
            if ($this->dec_permiso->has_permission('mnt', 17)) {
                $view['edit_status']=1;
//                $view['all_status']=1;
            }else{
//                $view['all_status']=0;
                $view['edit_status']=0;
            }
            if ($this->dec_permiso->has_permission('mnt', 15)) {
                $view['resportes']=1;
            }else{
                $view['reportes']=0;
            }
            if ($this->dec_permiso->has_permission('mnt', 5)) {
                $view['asig_per']=1;
            }else{
                $view['asig_per']=0;
            }
            
//            echo_pre($view);
            $header = $this->dec_permiso->load_permissionsView();
            $header['title'] = 'Ver Solicitudes';
			$this->load->view('template/header', $header);
            if(isset($view)){
                $this->load->view('mnt_solicitudes/solicitudes',$view);
            }else{
                $this->load->view('mnt_solicitudes/solicitudes');
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
//        echo_pre($this->model_mnt_solicitudes->get_califica());
        if ($this->dec_permiso->has_permission('mnt', 7) || $this->dec_permiso->has_permission('mnt', 12) || $this->dec_permiso->has_permission('mnt', 14)) 
        {
            $view['dep'] = ($this->session->userdata('user')['id_dependencia']);
            $view['est'] = 'close';
             if ($this->dec_permiso->has_permission('mnt', 15)) {
                $view['resportes']=1;
            }else{
                $view['reportes']=0;
            }
            if ($this->dec_permiso->has_permission('mnt', 14)) {
                $view['asig_per']=1;
            }else{
                $view['asig_per']=0;
            }
            if ($this->dec_permiso->has_permission('mnt', 9) || $this->dec_permiso->has_permission('mnt', 10) || $this->dec_permiso->has_permission('mnt', 11) || $this->dec_permiso->has_permission('mnt', 13)){
                $view['ver']=1;
            }else{
                $view['ver']=0;
            }
            if ($this->dec_permiso->has_permission('mnt',1)){
                 $view['crear']=1;
            }else{
                $view['crear']=0;
            }
            if ($this->dec_permiso->has_permission('mnt',2)){
                 $view['crear_dep']=1;
            }else{
                $view['crear_dep']=0;
            }
            if ($this->dec_permiso->has_permission('mnt2',3)) {
                $view['anuladas']=1;
            }else{
                $view['anuladas']=0;
            }
            if ($this->dec_permiso->has_permission('mnt',7)) {
                $view['califica']=1;
            }else{
                $view['califica']=0;
            }
            $view['cuadrilla'] = $this->model_cuadrilla->get_cuadrillas();
            $mant_solicitudes = $this->model_mnt_solicitudes->get_ordenes_close();
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
            //$view['creada'] = $this->model_mnt_estatus_orden->get_first_fecha('4');
//            $view['ayudantes'] = $this->model_user->get_userObrero();
            $view['ayuEnSol'] = $this->model_mnt_ayudante->array_of_orders();
//            die_pre($view['mant_solicitudes'], __LINE__, __FILE__);
            $header = $this->dec_permiso->load_permissionsView();
            $header['title'] = 'Ver Solicitudes';
			$this->load->view('template/header', $header);
            $this->load->view('mnt_solicitudes/solicitudes_closed', $view);
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
//        echo_pre($this->model_mnt_solicitudes->get_califica());
        if ($this->dec_permiso->has_permission('mnt2', 3) || $this->dec_permiso->has_permission('mnt', 12) || $this->dec_permiso->has_permission('mnt', 14)) 
        {
            $view['dep'] = ($this->session->userdata('user')['id_dependencia']);
            $view['est'] = 'anuladas';
             if ($this->dec_permiso->has_permission('mnt', 15)) {
                $view['resportes']=1;
            }else{
                $view['reportes']=0;
            }
             if ($this->dec_permiso->has_permission('mnt', 12)) {
                $view['close']=1;
            }else{
                $view['close']=0;
            }
            if ($this->dec_permiso->has_permission('mnt', 14)) {
                $view['asig_per']=1;
            }else{
                $view['asig_per']=0;
            }
            if ($this->dec_permiso->has_permission('mnt', 9) || $this->dec_permiso->has_permission('mnt', 10) || $this->dec_permiso->has_permission('mnt', 11) || $this->dec_permiso->has_permission('mnt', 13)){
                $view['ver']=1;
            }else{
                $view['ver']=0;
            }
            if ($this->dec_permiso->has_permission('mnt',1)){
                 $view['crear']=1;
            }else{
                $view['crear']=0;
            }
            if ($this->dec_permiso->has_permission('mnt',2)){
                 $view['crear_dep']=1;
            }else{
                $view['crear_dep']=0;
            }
            $view['cuadrilla'] = $this->model_cuadrilla->get_cuadrillas();
            $mant_solicitudes = $this->model_mnt_solicitudes->get_ordenes_close();
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
            //$view['creada'] = $this->model_mnt_estatus_orden->get_first_fecha('4');
//            $view['ayudantes'] = $this->model_user->get_userObrero();
            $view['ayuEnSol'] = $this->model_mnt_ayudante->array_of_orders();
//            die_pre($view['mant_solicitudes'], __LINE__, __FILE__);
            $header = $this->dec_permiso->load_permissionsView();
            $header['title'] = 'Ver Solicitudes';
			$this->load->view('template/header', $header);
            $this->load->view('mnt_solicitudes/solicitudes_null', $view);
            $this->load->view('template/footer');
        }
         else 
        {
           $this->session->set_flashdata('permission', 'error');
           redirect('inicio');
        }
    }

public function mnt_detalle($id = '') // funcion para ver el detalle de una solicitud, se define permisologia.
    {
        if (!empty($id)) {
            $tipo = $this->model_mnt_solicitudes->get_orden($id);
//            die_pre($tipo);
            //$nombre = $this->model_user->get_user_cuadrilla($this->session->userdata('user')['id_usuario']);
            $usr_make_sol = $this->model_mnt_estatus_orden->get_user_make_sol($id);
            if ($this->dec_permiso->has_permission('mnt',2)){ //se define permisologia y se redirecciona cuando se edita la solicitud dependiendo el permiso que se le asigne
                $view['action'] =  base_url().'index.php/mnt_solicitudes/mnt_solicitudes/editar_solicitud_dep';
                $view['ubica']=($this->model_ubicacion->get_ubicaciones_dependencia($tipo['dependencia']));
            } 
            if ($this->dec_permiso->has_permission('mnt',1)){ //se define permisologia y se redirecciona cuando se edita la solicitud dependiendo el permiso que se le asigne
                $view['todas']=1;
                $view['action'] =  base_url().'index.php/mnt_solicitudes/mnt_solicitudes/editar_solicitud';
            }else{
                $view['todas']=0;
            }
            if ($this->dec_permiso->has_permission('mnt',16) && $usr_make_sol == $this->session->userdata('user')['id_usuario']){
                 $view['editar']=1;
            }else{
                $view['editar']=0;
            }
            if ($this->dec_permiso->has_permission('mnt', 17)) {
                $view['edit_status']=1;
            }else{
                $view['edit_status']=0;
            }
            if ($this->dec_permiso->has_permission('mnt',5)){
                $view['asignar']=1;
            }else{
                $view['asignar']=0;
            }
            if ($this->dec_permiso->has_permission('mnt',8)){
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
            $header = $this->dec_permiso->load_permissionsView();
            $header['title'] = 'Detalles de la Solicitud';
			$this->load->view('template/header', $header);
            if ($this->session->userdata('tipo')['id'] == $tipo['id_orden']) 
            {
                $view['edit'] = TRUE;
                $this->load->view('mnt_solicitudes/detalle_solicitud', $view);
            } 
            else 
            {
                if ($this->dec_permiso->has_permission ('mnt',13) || $this->dec_permiso->has_permission ('mnt',16))
                {
                    $view['edit'] = TRUE;
                    $this->load->view('mnt_solicitudes/detalle_solicitud', $view);
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
            $this->model_mnt_solicitudes->actualizar_orden($data1,$solic);
//            if(isset($_POST['observac'])):
//                $data2 = array(
//                    'observac' => strtoupper($_POST['observac']));
//                $this->mnt_observacion->actualizar_orden($data2,$solic);
//            endif;
            $data3 = array(
                        'id_estado' => '1',
                        'id_orden_trabajo' => $_POST['id'], //llamo a $orden2 para que devuel el id de orden
                        'id_usuario' => $usu,
                        'fecha_p' => $fecha,
                        'motivo_cambio' => 'edicion');
            $orden = $this->model_mnt_estatus_orden->insert_orden($data3);

            if ($solic != FALSE) 
            {
                $this->session->set_flashdata('actualizar_orden', 'success');
                redirect(base_url() . 'index.php/mnt_solicitudes/detalle/'.$solic);
            }


            $this->mnt_detalle($solic);
        }elseif(isset($_POST['img'])){
            if(($_FILES['archivo']['error'])== 0){
//                die_pre($_POST);
//                echo_pre('./'.$_POST['ruta']);
                if(isset($_POST['ruta'])){
                    $del = unlink('./'.$_POST['ruta']);
                }
                $dir = './uploads/mnt/solicitudes'; //para enviar a la funcion de guardar imagen
                $tipo = 'gif|jpg|png|jpeg'; //Establezco el tipo de imagen
                $mi_imagen = 'archivo'; // asigno en nombre del input_file a $mi_imagen
                if ($this->model_cuadrilla->guardar_imagen($dir, $tipo, '', $mi_imagen) == 'exito') {
                    $ext = ($this->upload->data());
                    $ruta = 'uploads/mnt/solicitudes/' . $ext['file_name']; //para guardar en la base de datos
                    $datos = array(//Guarda la ruta en la tabla respectiva ----
                        'ruta' => $ruta
                    );
                    $this->model_mnt_solicitudes->actualizar_orden($datos, $_POST['id']); //actualiza en la base de datos este campo
                } else {
                    $view['error'] = ($this->model_cuadrilla->guardar_imagen($dir, $tipo, '', $mi_imagen));
                }
                
                if ($solic != FALSE) 
                {
                    $this->session->set_flashdata('actualizar_foto', 'success');
                    redirect(base_url() . 'index.php/mnt_solicitudes/detalle/'.$solic);
                }
            
            }else{
                $this->session->set_flashdata('actualizar_foto', 'error');
                redirect(base_url() . 'index.php/mnt_solicitudes/detalle/'.$solic);
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
            $this->model_mnt_solicitudes->actualizar_orden($data1,$solic);
//            $data2 = array(
//                'observac' => strtoupper($_POST['observac']));
//            $this->mnt_observacion->actualizar_orden($data2,$solic);
            $data3 = array(
                        'id_estado' => '1',
                        'id_orden_trabajo' => $_POST['id'], //llamo a $orden2 para que devuel el id de orden
                        'id_usuario' => $usu,
                        'fecha_p' => $fecha,
                        'motivo_cambio' => 'edicion');
            $orden = $this->model_mnt_estatus_orden->insert_orden($data3);
            if ($solic != FALSE) 
            {
                $this->session->set_flashdata('actualizar_orden', 'success');
                redirect(base_url() . 'index.php/mnt_solicitudes/detalle/'.$solic);
            }

            $this->mnt_detalle($solic);
        }elseif(isset($_POST['img'])){
           if(($_FILES['archivo']['error'])== 0){
//                die_pre($_POST);
//                echo_pre('./'.$_POST['ruta']);
                $del = unlink('./'.$_POST['ruta']);
                if($del){
                    $dir = './uploads/mnt/solicitudes'; //para enviar a la funcion de guardar imagen
                    $tipo = 'gif|jpg|png|jpeg'; //Establezco el tipo de imagen
                    $mi_imagen = 'archivo'; // asigno en nombre del input_file a $mi_imagen
                    if ($this->model_cuadrilla->guardar_imagen($dir, $tipo, '', $mi_imagen) == 'exito') {
                        // AQUI TERMINA
                        $ext = ($this->upload->data());
                        $ruta = 'uploads/mnt/solicitudes/' . $ext['file_name']; //para guardar en la base de datos
                        $datos = array(//Guarda la ruta en la tabla respectiva ----
                            'ruta' => $ruta
                        );
                        $this->model_mnt_solicitudes->actualizar_orden($datos, $_POST['id']); //actualiza en la base de datos este campo
                    } else {
                        $view['error'] = ($this->model_cuadrilla->guardar_imagen($dir, $tipo, '', $mi_imagen));
                    }
                }
                if ($solic != FALSE) 
                {
                    $this->session->set_flashdata('actualizar_foto', 'success');
                    redirect(base_url() . 'index.php/mnt_solicitudes/detalle/'.$solic);
                }
            
            }else{
                $this->session->set_flashdata('actualizar_foto', 'error');
                redirect(base_url() . 'index.php/mnt_solicitudes/detalle/'.$solic);
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
        $tipo = $this->model_mnt_solicitudes->get_orden($id);
        $view['tipo'] = $tipo;  
        $view['responsable'] = $this->model_responsable->get_responsable($id);
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

     //funcion para crear pdf por dependencia
    public function pdf_dep($id='') 
    {
        $tipo = $this->model_mnt_solicitudes->get_orden($id);
        $view['tipo'] = $tipo;  
        $view['responsable'] = $this->model_responsable->get_responsable($id);
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
            $this->model_mnt_solicitudes->actualizar_orden($data2,$id_orden);
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
            $this->mnt_observacion->insert_orden($datos);
            $this->session->set_flashdata('observacion', 'success');
        else:
            $this->session->set_flashdata('observacion', 'error');
        endif;
            redirect($uri);
    }
}

//  FUNCIONES QUE NO ESTAN EN USO POR OPTIMIZACION
 // permite listar las solicitudes para la vista consultar solicitud del menu principal
 //    // No esta en uso por migrar a Datatable
//    public function lista_solicitudes($field = '', $order = '', $aux = '')
//    {
//        if ($this->hasPermissionClassA())
//        {
////            $view['asigna'] = $this->model_asigna->get_allasigna();
//            $cuadrilla = $this->model_cuadrilla->get_cuadrillas();
////            $miembros = $this->model_miembros_cuadrilla->get_miembros();
//            $view['estatus'] = $this->model_estatus->get_estatus2();
//            $i = 0;
//            foreach ($cuadrilla as $cua):
//                $id[$i]['nombre'] = $this->model_user->get_user_cuadrilla($cua->id_trabajador_responsable);
//                $cua->nombre = $id[$i]['nombre'];
//                $i++;
//            endforeach;
////            $i = 0;
////            foreach ($miembros as $miemb):
////                $new[$i]['miembros'] = $this->model_user->get_user_cuadrilla($miemb->id_trabajador);
////                $miemb->miembros = $new[$i]['miembros'];
////                $i++;
////            endforeach;
////                echo_pre($new);
////                echo_pre($miembros);
////                echo_pre($cuadrilla);
//            $view['cuadrilla'] = $cuadrilla;
////            $view['miembros'] = $miembros;
////                $nombre = $this->model_user->get_user_cuadrilla($cuadrilla['id_trabajador_responsable']);
////                echo_pre($nombre);
////                echo_pre($view);
//            // $HEADER Y $VIEW SON LOS ARREGLOS DE PARAMETROS QUE SE LE PASAN A LAS VISTAS CORRESPONDIENTES
//            if ($field == 'buscar')
//            {//control para parametros pasados a la funcion, sin esto, no se ordenan los resultados de la busqueda
//                $field = $order;
//                $order = $aux;
//            }
//            $per_page = 10; //uso para paginacion (indica cuantas filas de la tabla, por pagina, se mostraran)
//            if ($this->uri->segment(3) == 'buscar')
//            {//para saber si la "bandera de busqueda" esta activada
//                if (!is_numeric($this->uri->segment(4, 0)))
//                {//para saber si la "bandera de ordenamiento" esta activada
//                    $url = 'index.php/mnt_solicitudes/orden/buscar/' . $field . '/' . $order . '/'; //uso para paginacion
//                    $offset = $this->uri->segment(6, 0); //uso para consulta en BD
//                    $uri_segment = 6; //uso para paginacion
//                }
//                else
//                {
//                    $url = 'index.php/mnt_solicitudes/listar/buscar/'; //uso para paginacion
//                    $offset = $this->uri->segment(4, 0); //uso para consulta en BD
//                    $uri_segment = 4; //uso para paginacion
//                }
//            }
//            else
//            {
//                $this->session->unset_userdata('tmp');
//                if (!is_numeric($this->uri->segment(3, 0)))
//                {
//                    $url = 'index.php/mnt_solicitudes/orden/' . $field . '/' . $order . '/'; //uso para paginacion
//                    $offset = $this->uri->segment(5, 0); //uso para consulta en BD
//                    $uri_segment = 5; //uso para paginacion
//                }
//                else
//                {
//                    $url = 'index.php/mnt_solicitudes/listar/'; //uso para paginacion
//                    $offset = $this->uri->segment(3, 0); //uso para consulta en BD
//                    $uri_segment = 3; //uso para paginacion
//                }
//            }
////////////////////////////Esta porcion de codigo, separa las URI de ordenamiento de resultados, de las URI de listado comun
//
//            $header['title'] = 'Ver Solicitudes';
//
//            if (!empty($field))
//            {//verifica si se le ha pasado algun valor a $field, el cual indicara en funcion de cual columna se ordenara
//                switch ($field)
//                { //aqui se le "traduce" el valor, al nombre de la columna en la BD
//                    case 'orden': $field = 'id_orden';
//                        break;
//                    case 'fecha': $field = 'fecha_p';
//                        break;
//                    case 'responsable': $field = 'nombre';
//                        break;
//                    case 'dependencia': $field = 'dependen';
//                        break;
//                    case 'estatus': $field = 'descripcion';
//                        break;
//                    case 'cuadrilla': $field = 'cuadrilla';
//                        break;
//                    default: $field = 'id_orden';
//                        break;
//                    default: $field = '';
//                        break; //en caso que no haya ninguna coincidencia, lo deja vacio
//                }
//            }
//            $order = (empty($order) || ($order == 'desc')) ? 'asc' : 'desc';
//
//            if ($_POST)
//            {
//                //falta validar cuando envian o no las fecha;
//                $this->session->set_userdata('tmp', $_POST);
//            }
//            //echo_pre($field);
////	     $solicitudes = $this->model_mnt_solicitudes->get_allorden($field,$order,$per_page, $offset);//el $offset y $per_page deben ser igual a los suministrados a initPagination()
////			// PARA VER LA INFORMACION DE LOS USUARIOS DESCOMENTAR LA LINEA DE ABAJO, GUARDAR Y REFRESCAR EL EXPLORADOR
////            die_pre($this->session->userdata('query'));
//            if ($this->uri->segment(3) == 'buscar')
//            {//debido a que en la vista hay un pequeno formulario para el campo de busqueda, verifico si no se le ha pasado algun valor
//                //die_pre($this->session->userdata('query'));
//                $view['mant_solicitudes'] = $this->buscar_solicitud($field, $order, $per_page, $offset); //cargo la busqueda de las solicitudes
//                $temp = $this->session->userdata('tmp');
//                $total_rows = $this->model_mnt_solicitudes->buscar_solCount($temp['solicitudes'], $temp['fecha']); //contabilizo la cantidad de resultados arrojados por la busqueda
//                $config = initPagination($url, $total_rows, $per_page, $uri_segment); //inicializo la configuracion de la paginacion
//                $this->pagination->initialize($config); //inicializo la paginacion en funcion de la configuracion
//                $view['links'] = $this->pagination->create_links(); //se crean los enlaces, que solo se mostraran en la vista, si $total_rows es mayor que $per_page            
//            }
//            else
//            {//en caso que no se haya captado ningun dato en el formulario
//                $total_rows = $this->get_alls(); //uso para paginacion
//                //echo_pre($per_page);
//                //die_pre($total_rows);
//                $view['mant_solicitudes'] = $this->model_mnt_solicitudes->get_allorden($field, $order, $per_page, $offset);
//                $config = initPagination($url, $total_rows, $per_page, $uri_segment);
//                $this->pagination->initialize($config);
//                $view['links'] = $this->pagination->create_links(); //NOTA, La paginacion solo se muestra cuando $total_rows > $per_page
//            }
//            $view['order'] = $order;
//
////             echo_pre($view['asigna']);
//            //  die_pre($view);
////             die_pre($view['mant_solicitudes']);
//            //CARGAR LAS VISTAS GENERALES MAS LA VISTA DE VER USUARIO
//            $view['ayudantes'] = $this->model_user->get_userObrero();
//            //echo_pre($view, __LINE__, __FILE__);
//            $header = $this->dec_permiso->load_permissionsView();
			// $this->load->view('template/header', $header);
//            $this->load->view('mnt_solicitudes/main', $view);
//            $this->load->view('template/footer');
//        }
//        else
//        {
//            $header['title'] = 'Error de Acceso';
//            $this->load->view('template/erroracc', $header);
//        }
//    }
    
//No esta en uso por problemas de query
//    public function ajax_sol_adm() {
//        $ayuEnSol = $this->model_mnt_ayudante->array_of_orders();  
//        $list = $this->model_mnt_solicitudes->get_sol();
//        $data = array();
//        $no = $_POST['start'];
//        foreach ($list as $i=>$sol):
//            $no++;
//            $row = array();
//            $row[] = '<a href="'.base_url().'index.php/mnt_solicitudes/detalle/'.$sol['id_orden'].'">'.$sol['id_orden'].'</a>';
//            $row[] = date("d/m/Y", strtotime($sol['fecha']));
//            $row[] = $sol['dependen'];
//            $row[] = $sol['asunto'];
//            $row[] = $sol['descripcion'];
//            switch ($sol['descripcion']){
//                case 'EN PROCESO':
//                  $row[] = '<a  href="#estatus_sol'.$sol['id_orden'].'" data-toggle="modal" data-id="'.$sol['id_orden'].'"class="open-Modal"><div align="center" title="En proceso"><img src="'.base_url()."assets/img/mnt/proceso.png".'" class="img-rounded" alt="bordes redondeados" width="25" height="25"></a>';
//                break;
//                case 'CERRADA':
//                  $row[] = '<a  href="#estatus_sol'.$sol['id_orden'].'" data-toggle="modal" data-id="'.$sol['id_orden'].'"class="open-Modal"><div align="center" title="Cerrada"><img src="'.base_url()."assets/img/mnt/cerrar.png".'" class="img-rounded" alt="bordes redondeados" width="25" height="25"></a>';
//                break;
//                case 'ANULADA':
//                  $row[] = '<a  href="#estatus_sol'.$sol['id_orden'].'" data-toggle="modal" data-id="'.$sol['id_orden'].'"class="open-Modal"><div align="center" title="Anulada"><img src="'.base_url()."assets/img/mnt/anulada.png".'" class="img-rounded" alt="bordes redondeados" width="25" height="25"></a>';
//                break;
//                case 'PENDIENTE POR MATERIAL':
//                  $row[] = '<a  href="#estatus_sol'.$sol['id_orden'].'" data-toggle="modal" data-id="'.$sol['id_orden'].'"class="open-Modal"><div align="center" title="Pendiente por material"><img src="'.base_url()."assets/img/mnt/material.png".'" class="img-rounded" alt="bordes redondeados" width="25" height="25"></a>';
//                break;
//                case 'PENDIENTE POR PERSONAL':
//                  $row[] = '<a  href="#estatus_sol'.$sol['id_orden'].'" data-toggle="modal" data-id="'.$sol['id_orden'].'"class="open-Modal"><div align="center" title="Pendiente por personal"><img src="'.base_url()."assets/img/mnt/empleado.png".'" class="img-rounded" alt="bordes redondeados" width="25" height="25"></a>';
//                break;
//                default: 
//                  $row[]= '<a href="#estatus_sol'.$sol['id_orden'].'" data-toggle="modal" data-id="'.$sol['id_orden'].'" class="open-Modal" ><div align="center" title="Abierta"><img src="'.base_url()."assets/img/mnt/abrir.png".'" class="img-rounded" alt="bordes redondeados" width="25" height="25"></div>';
//            }
////            if ($this->session->userdata('user')['sys_rol'] == 'autoridad'):
//            if (!empty($sol['cuadrilla'])):
//                $row[]= '<a href="#cuad'.$sol['id_orden'].'" data-toggle="modal" data-id="'.$sol['id_orden'].'" data-asunto="'.$sol['asunto'].'" data-tipo_sol="'.$sol['tipo_orden'].'" class="open-Modal" onclick="cuad_asignada($(' . "'".'#responsable'.$sol['id_orden']."'" . '),($(' . "'".'#respon'.$sol['id_orden']."'" . ')),' . "'".$sol['id_orden']."'" . ',' . "'".$sol['id_cuadrilla']."'" . ', ($(' . "'".'#show_signed'.$sol['id_orden']."'" . ')), ($(' . "'".'#otro'.$sol['id_orden']."'" . ')),($(' . "'".'#mod_resp'.$sol['id_orden']."'" . ')))" ><div align="center"> <img title="Cuadrilla asignada" src="'.base_url().$sol['icono'].'" class="img-rounded" alt="bordes redondeados" width="25" height="25"></div></a>';
//            else:
//                $row[]= '<a href="#cuad'.$sol['id_orden'].'" data-toggle="modal" data-id="'.$sol['id_orden'].'" data-asunto="'.$sol['asunto'].'" data-tipo_sol="'.$sol['tipo_orden'].'" class="open-Modal" onclick="cuad_asignada($(' . "'".'#responsable'.$sol['id_orden']."'" . '),($(' . "'".'#respon'.$sol['id_orden']."'" . ')),' . "'".$sol['id_orden']."'" . ',' . "'".$sol['id_cuadrilla']."'" . ', ($(' . "'".'#show_signed'.$sol['id_orden']."'" . ')), ($(' . "'".'#otro'.$sol['id_orden']."'" . ')),($(' . "'".'#mod_resp'.$sol['id_orden']."'" . ')))" ><div align="center"> <i title="Asignar cuadrilla" class="glyphicon glyphicon-pencil" style="color:#D9534F"></i></div></a>';
//            endif;
//            if(in_array(array('id_orden_trabajo' => $sol['id_orden']), $ayuEnSol)): $a= ('<i title="Agregar ayudantes" class="glyphicon glyphicon-plus" style="color:#5BC0DE"></i>'); else:  $a = ('<i title="Asignar ayudantes" class="glyphicon glyphicon-pencil" style="color:#D9534F"></i>'); endif;
//            $row[]= '<a href="#ayudante'.$sol['id_orden'].'" data-toggle="modal" data-id="'.$sol['id_orden'].'" data-asunto="'.$sol['asunto'].'" data-tipo_sol="'.$sol['tipo_orden'].'" class="open-Modal" onclick="ayudantes($(' . "'".'#mod_resp'.$sol['id_orden']."'" . '),$(' . "'".'#responsable'.$sol['id_orden']."'" . '),' . "'".$sol['estatus']."'" . ',' . "'".$sol['id_orden']."'" . ', ($(' . "'".'#disponibles'.$sol['id_orden']."'" . ')), ($(' . "'".'#asignados'.$sol['id_orden']."'" . ')))"><div align="center">'.$a.'</div></a>';
//                                      
//         //   endif  
//           $data[] = $row;
//        endforeach;
//
//        $output = array(
//            "draw" => $_POST['draw'],
//            "recordsTotal" => $this->model_mnt_solicitudes->count_all(),
//            "recordsFiltered" => $this->model_mnt_solicitudes->count_filtered(),
//            "data" => $data,
//        );
//        //output to json format
////                echo_pre($output);
//        echo json_encode($output);
//    }
    // Aquí se filtra el tipo de usuario para cargar la vista de listado de solicitudes
//        if ($this->hasPermissionClassA())
//        {
//            $this->listado();
//        }
//        elseif ($this->hasPermissionClassD()||($this->hasPermissionClassB()))
//        {
//            $this->listado_dep();
//        } else 
//        {
//            $header['title'] = 'Error de Acceso';
//            $this->load->view('template/erroracc', $header);
//        }
//        die_pre($this->dec_permiso->has_permission('mnt', 2));

//    public function permiso(){
//        //permiso para entrar al modulo a ver todas las solicitudes  
//        if ($this->dec_permiso->has_permission('mnt', 1)) {
//            return 'todas_solicitudes';
//        }
////        //permiso para ver solo solicitudes por departamento
////        if ($this->dec_permiso->has_permission('mnt', 2)) {
////            return 'sol_dep';
////        }
//        //permiso para ver todos los estatus de las solicitudes
//        if ($this->dec_permiso->has_permission('mnt', 2)) {
//            return 'all_status';
//        }
//        //permiso para ver solo las que estan en proceso
//        if ($this->dec_permiso->has_permission('mnt', 3)) {
//            return 'status_proceso';
//        }
//        //permiso para ver las cerradas o anuladas
//        if ($this->dec_permiso->has_permission('mnt', 4)) {
//            return 'cerradas_anuladas';
//        }
//        //permiso para ver detalles de la solicitud por departamento
//        if ($this->dec_permiso->has_permission('mnt', 5)) {
//            return 'detalle';
//        }
////        //permiso para ver detalles de la solicitud siendo administrador
////        if ($this->dec_permiso->has_permission('mnt', 7)) {
////            return 'detalle_adm';
////        }
//        //permiso para ver la asignacion de personal solicitud cerrada /anulada
//        if ($this->dec_permiso->has_permission('mnt', 6)) {
//            return 'ver_asignacion';
//        }
//    }
//            $view['cuadrilla'] = $this->model_cuadrilla->get_cuadrillas();
//            $mant_solicitudes = $this->model_mnt_solicitudes->get_ordenes();
//            if(!empty($mant_solicitudes)):
//                foreach ($mant_solicitudes as $key => $sol):
//                    $result[$key] = $sol;
//                    if(!empty($sol['id_responsable'])):
//                        $result[$key] = $sol;
//                        $test = $this->model_responsable->get_responsable($sol['id_orden']);
//                        $responsable = $test['nombre'].' '.$test['apellido'];
//                        $result[$key]['responsable'] = $responsable;
//                    endif;
//                endforeach;
//                $view['mant_solicitudes'] = $result;
//            else:
//                $view['mant_solicitudes'] = $mant_solicitudes;
//            endif;
//            $view['asigna'] = $this->model_asigna->get_allasigna();
//            echo_pre($view['asigna']);
//           die_pre($view['mant_solicitudes']);
//            $view['estatus'] = $this->model_estatus->get_estatus2();
//            $view['ayudantes'] = $this->model_user->get_userObrero();
//            $view['ayuEnSol'] = $this->model_mnt_ayudante->array_of_orders();
//            die_pre($view['mant_solicitudes'], __LINE__, __FILE__);
//    public function listado_dep() 
//    {// Listado para Director Departamento (trabaja con dataTable) 
//        if ($this->permiso()== 'sol_dep') 
//        {
//            $dep = ($this->session->userdata('user')['id_dependencia']);
////            $view['cuadrilla'] = $this->model_cuadrilla->get_cuadrillas();
//            $view['mant_solicitudes'] = $this->model_mnt_solicitudes->get_ordenes_dep($dep);
////            $view['asigna'] = $this->model_asigna->get_allasigna();
////            echo_pre($view['asigna']);
////            die_pre($view['mant_solicitudes']);
////            $view['estatus'] = $this->model_estatus->get_estatus2();
////            $view['ayudantes'] = $this->model_user->get_userObrero();
////            $view['ayuEnSol'] = $this->model_mnt_ayudante->array_of_orders();
//            // die_pre($view['ayuEnSol'], __LINE__, __FILE__);
//            $view['dep'] = $dep;
//            $header = $this->dec_permiso->load_permissionsView();
//            $header['title'] = 'Ver Solicitudes';
//			$this->load->view('template/header', $header);
//            $this->load->view('mnt_solicitudes/solicitudes_dep', $view);
//            $this->load->view('template/footer');
//        } 
//        else 
//        {
//            $header['title'] = 'Error de Acceso';
//            $this->load->view('template/erroracc', $header);
//        }
//    }
//    
//    public function listado_dep_close() 
//    {// Listado para Director Departamento (trabaja con dataTable) 
//        if ($this->hasPermissionClassD() || ($this->hasPermissionClassB())) 
//        {
//            $dep = ($this->session->userdata('user')['id_dependencia']);
//            $view['est'] = 'close';
////            $view['cuadrilla'] = $this->model_cuadrilla->get_cuadrillas();
//            $view['mant_solicitudes'] = $this->model_mnt_solicitudes->get_ordenes_dep_close($dep);
////            $view['asigna'] = $this->model_asigna->get_allasigna();
////            echo_pre($view['asigna']);
////            die_pre($view['mant_solicitudes']);
////            $view['estatus'] = $this->model_estatus->get_estatus2();
////            $view['ayudantes'] = $this->model_user->get_userObrero();
////            $view['ayuEnSol'] = $this->model_mnt_ayudante->array_of_orders();
//            // die_pre($view['ayuEnSol'], __LINE__, __FILE__);
//            $view['dep'] = $dep;
//            $header = $this->dec_permiso->load_permissionsView();
//            $header['title'] = 'Ver Solicitudes';
//            $this->load->view('template/header', $header);
//            $this->load->view('mnt_solicitudes/solicitudes_dep_close', $view);
//            $this->load->view('template/footer');
//        } 
//        else 
//        {
//            $this->session->set_flashdata('permission', 'error');
//            redirect('inicio');
//            $header['title'] = 'Error de Acceso';
//            $this->load->view('template/erroracc',$header);
//        }
//    }
//      public function mnt_detalle_dep($id = '')
//      {
//        if (!empty($id)) 
//        {
//            $tipo = $this->model_mnt_solicitudes->get_orden($id);
//            $view['tipo'] = $tipo;
//            $view['tipo_solicitud'] = $this->model_tipo->devuelve_tipo();
//            $view['ubica'] = $this->model_ubicacion->get_ubicaciones_dependencia($tipo['id_dependencia']);
////            $view['dependencia'] = $this->model_dependen->get_dependencia();
//            $view['responsable'] = $this->model_responsable->get_responsable($id);
//            $trabajador_id = $tipo['id_trabajador_responsable'];
//            $view['nombre'] = $this->model_user->get_user_cuadrilla($trabajador_id);
//            $cuadrilla = $this->model_mnt_ayudante->ayudantesDeCuadrilla_enOrden($id, $tipo['id_cuadrilla']);
//            $ayudantes = $this->model_mnt_ayudante->ayudantes_DeOrden($id);
//            $autor = $this->model_mnt_estatus_orden->get_user_make_sol($id); 
//            $view['autor'] = $this->model_user->get_user_cuadrilla($autor);
//            $view['creada'] = $this->model_mnt_estatus_orden->get_first_fecha($id);
//            $view['oficina'] = $this->model_ubicacion->obtener_ubicacion($tipo['id_dependencia'],$tipo['ubicacion']);
//            $view['todos'] = $this->model_user->get_user_activos_dep($tipo['id_dependencia']);
////            echo_pre($view);
//            $final_ayudantes=array();
//            $miembros = array();
//            $this->model_asigna->asignados_cuadrilla_ayudantes($cuadrilla, $ayudantes,$final_ayudantes,$miembros);
//            if(!empty($cuadrilla)):
//              $view['cuadrilla'] = $miembros; //se guarda aca para mostrarlos en la vista 
//            endif;
//            if(!empty($ayudantes)):
//              $view['ayudantes'] = $final_ayudantes;
//            endif; 
//            $view['observacion'] = $this->mnt_observacion->get_observacion($id);
//            //echo_pre($view);
//            //CARGAR LAS VISTAS GENERALES MAS LA VISTA DE VER ITEM
//            $header = $this->dec_permiso->load_permissionsView();
//            $header['title'] = 'Detalles de la Solicitud';
//			$this->load->view('template/header', $header);
//            if ($this->session->userdata('tipo')['id'] == $tipo['id_orden']) 
//            {
//                $view['edit'] = TRUE;
//                $this->load->view('mnt_solicitudes/detalle_solicitud', $view);
//            } 
//            else 
//            {
//                if ($this->hasPermissionClassD() || ($this->hasPermissionClassB()))
//                {
//                    $view['edit'] = TRUE;
//                    $this->load->view('mnt_solicitudes/detalle_solicitud_dep', $view);
//                } 
//                else 
//                {
//                    $this->session->set_flashdata('permission', 'error');
//                    redirect('inicio');
//                }
//            }
//            $this->load->view('template/footer');
//        } else {
//            $this->session->set_flashdata('edit_tipo', 'error');
//            redirect(base_url() . 'index.php/mnt_solicitudes/detalles');
//        }
//    }
//    public function buscar_solicitud($field = '', $order = '', $per_page = '', $offset = '') 
//    {
//        //die_pre($field);
//
//        if ($this->session->userdata('tmp')) 
//        {
//            //
//            if ($this->session->userdata('tmp') == '' || $this->session->userdata('tmp') == ' ') 
//            {
//                $this->session->unset_userdata('tmp');
//                redirect(base_url() . 'index.php/mnt_solicitudes/listar');
//            }
//            //die_pre($this->session->userdata('query'));
//            $header['title'] = 'Buscar Solicitudes';
//            // $post = $_POST;
//            $temp = $this->session->userdata('tmp');
//            //die_pre($temp['solicitudes']);
//            return($this->model_mnt_solicitudes->buscar_sol($temp['solicitudes'], ($temp['fecha']), $field, $order, $per_page, $offset));
//        } 
//        else 
//        {
//            //die_pre('fin');
//            redirect('mnt_solicitudes/listar');
//        }
//    }
//
//////////////////////////Control de permisologia para usar las funciones
//
//    public function hasPermissionClassA() 
//    {//Solo si es usuario autoridad y/o Asistente de autoridad
//        return ($this->session->userdata('user')['sys_rol'] == 'autoridad' || $this->session->userdata('user')['sys_rol'] == 'asist_autoridad' || $this->session->userdata('user')['sys_rol'] == 'jefe_mnt');
//    }
//
//    public function hasPermissionClassB() 
//    {//Solo si es usuario "Director de Departamento" y/o "jefe de Almacen"
//        return ($this->session->userdata('user')['sys_rol'] == 'director_dep' || $this->session->userdata('user')['sys_rol'] == 'jefe_alm');
//    }
//
//    public function hasPermissionClassC() 
//    {//Solo si es usuario "Jefe de Almacen"
//        return ($this->session->userdata('user')['sys_rol'] == 'jefe_alm');
//    }
//
//    public function hasPermissionClassD() 
//    {//Solo si es usuario "Director de Dependencia y/o Asistente de dependencia"
//        return ($this->session->userdata('user')['sys_rol'] == 'asistente_dep_alm' || $this->session->userdata('user')['sys_rol'] == 'asistente_dep_mnt'|| $this->session->userdata('user')['sys_rol'] == 'asistente_dep');
//    }
//
//    public function isOwner($user = '') 
//    {
//        if (!empty($user) || $this->session->userdata('user')) 
//        {
//            return $this->session->userdata('user')['ID'] == $user['ID'];
//        } 
//        else 
//        {
//            return FALSE;
//        }
//    }
//
//    ////////////////////////Fin del Control de permisologia para usar las funciones
//    public function ajax_likeSols() 
//    {
//        //error_log("Hello", 0);
//        $solicitud = $this->input->post('solicitudes');
//        //die_pre($solicitud);
//        header('Content-type: application/json');
//        $query = $this->model_mnt_solicitudes->ajax_likeSols($solicitud);
//        $query = objectSQL_to_array($query);
//        echo json_encode($query);
//    }