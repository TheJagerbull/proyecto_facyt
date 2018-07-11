<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Tic_tipo_orden extends MX_Controller{

    function __construct() { //constructor predeterminado del controlador 
    	parent::__construct();
        $this->load->helper('array');
        $this->load->library('form_validation');
        $this->load->library('pagination');
        $this->load->model('model_tic_tipo_orden', 'model_tipo');
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
        $this->load->model('tic_cuadrilla/model_tic_cuadrilla', 'model_tic_cuadrilla');
    }

        public function listar_tipo(){
            //if ($this->dec_permiso->has_permission('tic', 5) || $this->dec_permiso->has_permission('tic', 9) || $this->dec_permiso->has_permission('tic', 10) || $this->dec_permiso->has_permission('tic', 11) || $this->dec_permiso->has_permission('tic', 13) || $this->dec_permiso->has_permission('tic', 14) || $this->dec_permiso->has_permission('tic', 16) || $this->dec_permiso->has_permission('tic', 17)) 
            //{           
            
            $header = $this->dec_permiso->load_permissionsView();
            
            $header['title'] = 'Tipos de Solicitud';
                $this->load->view('template/header', $header);
            //if(isset($view)){
            //    $this->load->view('tic_solicitudes/solicitudes',$view);
            //}else{
                $this->load->view('tic_tipo/listado_orden');
           // }
            $this->load->view('template/footer');
        //}
        // else 
       // {
        //    $this->session->set_flashdata('permission', 'error');
        //    redirect('inicio');
       // }
        }
        
        function list_tipo() { // Para crear la nueva tabla con los usuarios
        //if ($this->session->userdata('user') && $this->hasPermissionClassA()) {
            $results = $this->model_tipo->get_list(); //Va al modelo para tomar los datos para llenar el datatable
            echo json_encode($results); //genera la salida de datos
           
        //}
    }

}