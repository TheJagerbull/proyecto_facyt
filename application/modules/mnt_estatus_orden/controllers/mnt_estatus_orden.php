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
        $this->load->model('mnt_asigna_cuadrilla/model_mnt_asigna_cuadrilla', 'model_asigna');
        $this->load->model('mnt_ayudante/model_mnt_ayudante', 'model_ayudante');
        $this->load->model('mnt_responsable_orden/model_mnt_responsable_orden','model_responsable');
    }

    public function cambiar_estatus()
    {
            //die_pre($_POST);
            $uri=$_POST['uri'];
            ($user = $this->session->userdata('user')['id_usuario']);
            $orden = $_POST['orden'];
            $this->load->helper('date');
            $datestring = "%Y-%m-%d %h:%i:%s";
            $time = time();
            $fecha = mdate($datestring, $time);
            $tipo = $this->model_sol->get_orden($orden);
            $cuadrilla = $_POST['id_cu'];
            //die_pre($tipo);
            if ($_POST['select_estado'] == '6'):
            $asignados = $this->model_ayudante->ayudantes_DeOrden($orden);
//            die_pre($asignados);
            foreach ($asignados as $asigna):
            $elimina = array('id_trabajador'=>$asigna['id_usuario'],
                            'id_orden_trabajo'=>$orden);
            $this->model_ayudante->ayudante_fuera_deOrden($elimina);
            endforeach;
            $elimina2 = array(
                'id_cuadrilla' => $cuadrilla,
                'id_ordenes' => $orden);
            $this->model_asigna->quitar_cuadrilla($elimina2);
            $this->model_responsable->del_resp($orden);
        endif;


        if (!empty($_POST['select_estado'])):
        
                $estado = $_POST['select_estado'];
                    $data = array(
                        'id_estado' => $estado,
                        'id_orden_trabajo' => $orden,
                        'id_usuario' => $user,
                        'fecha_p' => $fecha);   
                $this->model_estatus_orden->insert_orden($data);
           
            if (isset($_POST['motivo'])):
                    $data2 = array(
                        'fecha' => $fecha,
                        'estatus' => $estado,
                        'motivo' => strtoupper($_POST['motivo']));
                    $this->model_sol->actualizar_orden($data2,$orden);
            endif;
                
                $datos = array(
                    'fecha' => $fecha,
                    'estatus' => $estado);

                $this->model_sol->actualizar_orden($datos, $orden);
                $this->session->set_flashdata('estatus_orden', 'success');

        else:

               $this->session->set_flashdata('estatus_orden', 'error'); 
                
        endif;     
                redirect($uri);
                     
    }
}
