<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Mnt_estatus_orden extends MX_Controller 
{

    function __construct() //constructor predeterminado del controlador
    { 
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
    public function mostrar_estatus()
    {

    }

    public function cambiar_estatus()
    {
            //die_pre($_POST);
            ($user = $this->session->userdata('user')['id_usuario']);
            $orden = $_POST['orden'];
            $status = $_POST['num'];
            $this->load->helper('date');
            $datestring = "%Y-%m-%d %h:%i:%s";
            $time = time();
            $fecha = mdate($datestring, $time);

          
        if (!empty($_POST['select_estado'])):
        
                $estado = $_POST['select_estado'];
                    $data = array(
                        'id_estado' => $estado,
                        'id_orden_trabajo' => $orden,
                        'id_usuario' => $user,
                        'fecha_p' => $fecha);   
                $this->model_estatus_orden->insert_orden($data);
           
            if (!empty($_POST['observac'])):
                $motivo = $_POST['observac'];          
                    $data2 = array(
                        'id_usuario' => $user,
                        'id_orden_trabajo' => $orden, 
                        'observac' => strtoupper($motivo));
                   $this->model_obser->insert_orden($data2);
            endif;
                
                $datos = array(
                    'fecha' => $fecha,
                    'estatus' => $estado);

                $this->model_sol->actualizar_orden($datos, $orden);
                $this->session->set_flashdata('estatus_orden', 'success');

        else:

               $this->session->set_flashdata('estatus_orden', 'error'); 
                
        endif;     
                redirect(base_url() . 'index.php/mnt_solicitudes/lista_solicitudes');
                     
    }
}
