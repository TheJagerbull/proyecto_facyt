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
    }

    public function cambiar_estatus() {
        $this->load->helper('date');
        $datestring = "%Y-%m-%d %h:%i:%s";
        $time = time();
        $fecha = mdate($datestring, $time);
        $orden = $_post['orden'];
        ($user = $this->session->userdata('user')['id_usuario']);
        if (isset($post['select_estado'])) {
            $estado = $post['select_estado'];
            
                $data = array(
                    'id_estado' => $post['id_estado'],
                    'id_orden_trabajo' => $orden,
                    'id_usuario' => $user,
                    'fecha_p' => $fecha);
                $datos = $this->model_estatus_orden->insert_orden($data);
