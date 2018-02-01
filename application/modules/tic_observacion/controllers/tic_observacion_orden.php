<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Tic_observacion_orden extends MX_Controller {

    function __construct() { //constructor predeterminado del controlador
        parent::__construct(); //carga los helpers
        $this->load->helper('array');
        $this->load->library('form_validation');
//        $this->load->library('pagination');
        $this->load->model('model_tic_observacion_orden','model_observac'); //cargar los modelos de los cuales se necesitan datos
        $this->load->model('tic_tipo/model_tic_tipo_orden', 'model_tipo');
        $this->load->model('dec_dependencia/model_dec_dependencia', 'model_dependen');
        $this->load->model('mnt_ubicaciones/model_mnt_ubicaciones_dep', 'model_ubicacion');
//        $this->load->model('tic_cuadrilla/model_tic_cuadrilla');
        $this->load->model('tic_asigna_cuadrilla/model_tic_asigna_cuadrilla', 'model_asigna');
//        $this->load->model('tic_miembros_cuadrilla/model_tic_miembros_cuadrilla', 'model_miembros_cuadrilla');
        $this->load->model('user/model_dec_usuario', 'model_user');
        $this->load->model('mnt_estatus/model_mnt_estatus', 'model_estatus');
        $this->load->model('tic_ayudante/model_tic_ayudante');
    }

    public function ajax_detalle($id = '') { //funcion trabajada con ajax en model_tic_observacion_orden para mostrar las observaciones.
//            echo_pre($id);
        $list = $this->model_observac->get_datatables($id);
//        echo_pre($list);
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $i=>$observ):
            $fnomb = explode(" " , $observ->nombre);
            $fapell = explode(" ", $observ->apellido);
            $row = array();
            $row[] = $fnomb['0'].' '.$fapell['0'];
            $row[] = $observ->observac;
            $row[] = date("d/m/Y", strtotime($observ->fecha_observacion));//Para mostrar la fecha
            $row[] = date("h:i a", strtotime($observ->fecha_observacion));//Para mostrar la hora
            $data[] = $row;
        endforeach;

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->model_observac->count_all($id),
            "recordsFiltered" => $this->model_observac->count_filtered($id),
            "data" => $data,
        );
        //output to json format
//                echo_pre($output);
        echo json_encode($output);
    }
    
   
}
