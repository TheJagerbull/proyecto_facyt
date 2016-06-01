<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Dec_dependencia extends MX_Controller {
    
    function __construct() {
        parent::__construct();
        $this->load->helper('array');
        $this->load->library('form_validation');
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
    
    public function all_Dependencias()//Funcion que devuelve todas las dependencias de la base de datos para usar con datatable
    {
        $depe= $this->model_dependen->get_allDependencias(); //Se obtienen todas las dependencias del modelo
        $data = array();//Para guardar las dependendias
        foreach ($depe  as $i=> $r) {
            $dos = str_pad($i+1, 2, '0', STR_PAD_LEFT);//contador
            array_push($data, array(
                $dos,//Se guarda el contador
                $r['dependen'] //La dependencia obtenida
             ));
        }
        echo json_encode(array('data' => $data)); //Se devuelve el dato tipo json para el manejo del datatable
    }
    
    public function save_dependen(){
        if($_POST):
            $uri=$_POST['uri'];
            $datos = array('dependen' => strtoupper($_POST['dependen']));
//            echo_pre($this->model_dependen->exist('',$datos));
            if(!$this->model_dependen->exist('',$datos)):
                $this->model_dependen->set_newDependencia($datos);
                $this->session->set_flashdata('nueva_dependencia', 'success');//Mensaje de que la dependencia fue agregada
            else:
                $this->session->set_flashdata('nueva_dependencia', 'existe');//Mensaje de que la dependencia existe
            endif;
            redirect(base_url() . $uri);
        endif;
        
        
    }
}