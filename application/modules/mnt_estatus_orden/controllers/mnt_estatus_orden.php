<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Mnt_estatus_orden extends MX_Controller {

    function __construct() { //constructor predeterminado del controlador
        parent::__construct(); //carga los helpers
        $this->load->helper('array');
        $this->load->library('form_validation');
        $this->load->library('pagination');
        $this->load->model('mnt_solicitudes/model_mnt_solicitudes', 'model_sol');
        $this->load->model('user/model_dec_usuario', 'model_user');
        $this->load->model('mnt_estatus/model_mnt_estatus', 'model_estatus');
        $this->load->model('mnt_estatus_orden/model_mnt_estatus_orden', 'model_estatus_orden');
        $this->load->model('mnt_observacion/model_mnt_observacion_orden', 'model_obser');
    }

    public function cambiar_estatus() {
         
            $orden = $post['orden'];
            $fecha = mdate($datestring, $time);
            ($user = $this->session->userdata('user')['id_usuario']);
            $this->load->helper('date');
            $datestring = "%Y-%m-%d %h:%i:%s";
            $time = time();
            

        if (isset($post['select_estado'])){
            $estado = $post['select_estado'];
                       
                $data = array(
                    'id_estado' => $post['id_estado'],
                    'id_orden_trabajo' => $orden,
                    'id_usuario' => $user,
                    'fecha_p' => $fecha);           
                $datos = $this->model_estatus_orden->insert_orden($data);
            if (isset($post['observac'])):
                $data2 = array(
                    'id_usuario' => $user,
                    'id_orden_trabajo' => $orden, 
                    'observac' => $post['observac']);
                $this->model_obser->insert_orden($data2);
                $datos1 = array(
                    'fecha' => $fecha,
                    'estatus' => $var);
                $this->model_sol->actualizar_orden($datos1, $orden);
                $this->session->set_flashdata('estatus_orden', 'success');
            }else{
                $this->session->set_flashdata('estatus_orden', 'error');
        endif;
            redirect(base_url() . 'index.php/mnt_solicitudes/lista_solicitudes');
        }
    }   
