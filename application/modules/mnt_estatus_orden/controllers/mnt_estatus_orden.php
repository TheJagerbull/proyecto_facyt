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
        $this->load->model('mnt_estatus/model_mnt_estatus', 'model_estatus');
        $this->load->model('mnt_estatus_orden/model_mnt_estatus_orden', 'model_estatus_orden');
    }

    public function cambiar_estatus() {
    $this->load->helper('date');
        $datestring = "%Y-%m-%d %h:%i:%s";
        $time = time();
        $fecha = mdate($datestring, $time);
        if (isset($post['select_estado'])) {
            $estado = $post['select_estado'];
            if ($estado == 'EN PROCESO' || $estado== 'CERRADA');
                $data = array(
                    'fecha_p' => $fecha);
                $estado1 = $this->model_estatus_orden->insert_orden();
