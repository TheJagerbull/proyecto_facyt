<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Dec_dependencia extends MX_Controller {
    
    function __construct() {
        parent::__construct();
        $this->load->helper('array');
        $this->load->library('form_validation');
        $this->load->library('pagination');
        $this->load->model('model_dec_dependencia','model_dependen'); //cargar los modelos de los cuales se necesitan datos
        $this->load->model('mnt_tipo/model_mnt_tipo_orden', 'model_tipo');
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
    
    public function all_Dependencias()
    {
        $depe= $this->model_dependen->get_allDependencias();
//        echo_pre($depe);
         $data = array();
        foreach ($depe  as $i=> $r) {
            $dos = str_pad($i+1, 2, '0', STR_PAD_LEFT);
            array_push($data, array(
                $dos,
                $r['dependen']
             ));
        }
        
        echo json_encode(array('data' => $data));
    }
    
    
    
    
    
    
}