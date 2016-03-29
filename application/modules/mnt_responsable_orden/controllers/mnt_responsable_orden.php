<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Mnt_responsable_orden extends MX_Controller {

    function __construct() { //constructor predeterminado del controlador
        parent::__construct(); //carga los helpers
        $this->load->helper('array');
        $this->load->library('form_validation');
        $this->load->library('pagination');
        $this->load->model('mnt_solicitudes/model_mnt_solicitudes', 'model_sol');
        $this->load->model('mnt_asigna_cuadrilla/model_mnt_asigna_cuadrilla', 'model_asigna');
        $this->load->model('mnt_tipo/model_mnt_tipo_orden', 'model_tipo');
        $this->load->model('dec_dependencia/model_dec_dependencia', 'model_dependen');
        $this->load->model('mnt_ubicaciones/model_mnt_ubicaciones_dep', 'model_ubicacion');
        $this->load->model('mnt_cuadrilla/model_mnt_cuadrilla', 'model_cuadrilla');
        $this->load->model('mnt_asigna_cuadrilla/model_mnt_asigna_cuadrilla', 'model_asigna');
        $this->load->model('mnt_miembros_cuadrilla/model_mnt_miembros_cuadrilla', 'model_miembros_cuadrilla');
        $this->load->model('user/model_dec_usuario', 'model_user');
        $this->load->model('mnt_estatus_orden/model_mnt_estatus_orden', 'model_estatus');
        $this->load->model('mnt_ayudante/model_mnt_ayudante', 'model_ayudante');
        $this->load->model('model_mnt_responsable_orden', 'model_responsable');
    }

 public function select_responsable() { //funcion trabajada con ajax en mainFunctions.js para asignar el responsable de una solicitud
        if ($this->input->post('id')) {
            $id_cuadrilla = $this->input->post('id');
            if(is_numeric($id_cuadrilla))://Para evaluar si viene de la cuadrilla o del modal de ayudantes
                $miembros = $this->model_miembros_cuadrilla->get_miembros_cuadrilla($id_cuadrilla);
                if ($this->input->post('sol')):
                    foreach ($miembros as $fila) {
                        if ($this->model_responsable->es_respon_orden($fila->id_trabajador,$this->input->post('sol'))):?> 
                            <option selected value="<?= $fila->id_trabajador?>"><?= $fila->trabajador ?></option>
                  <?php else:?>
                            <option value="<?= $fila->id_trabajador ?>"><?= $fila->trabajador ?></option>
                  <?php endif;
                    }
                else:
                    foreach ($miembros as $fila) {
                        if($this->model_cuadrilla->es_responsable($fila->id_trabajador,$id_cuadrilla)):?> 
                            <option selected value="<?= $fila->id_trabajador?>"><?= $fila->trabajador ?></option>                     
                  <?php else:?>
                            <option value="<?= $fila->id_trabajador ?>"><?= $fila->trabajador ?></option>
                  <?php endif; 
                    }
                endif;
            else:
                $ayudantes = $this->model_user->get_userObrero();
                $responsable = ($this->model_responsable->get_responsable($this->input->post('sol')));
                if($this->model_responsable->get_responsable($this->input->post('sol'))):?>
                    <option></option>
                    <option selected="<?php echo $responsable['id_responsable']?>" value="<?php echo $responsable['id_responsable']?>"  ><?php echo $responsable['nombre'].' '.$responsable['apellido']?></option>   
          <?php else:?>
                    <option></option>
          <?php endif;
                foreach ($ayudantes as $ayu):
                    if($ayu['id_usuario'] != $responsable['id_responsable']):?>
                        <option value="<?= $ayu['id_usuario'] ?>"><?= $ayu['nombre'].' '.$ayu['apellido']?></option>
              <?php endif;
                endforeach; 
            endif;
        }
    }
    
    public function show_all_respon(){
//        if ($this->input->post('estatus')):
            $band = 0;
            $todos = $this->model_user->get_userObrero();
//          echo_pre($todas);
            ?><option></option><?php
            foreach ($todos as $all):
                if ($this->model_responsable->existe_resp_2($all['id_usuario'],$this->input->post('estatus'),$this->input->post('fecha1'),$this->input->post('fecha2'))):
                    $band++;?>
                    <option value="<?= $all['id_usuario']?>"><?= $all['nombre'].' '.$all['apellido'];?></option>
    <?php       endif;
            endforeach;
            if ($band>1):
                ?><option value="all">Todos</option><?php
            endif;
//        endif;
    }
}
