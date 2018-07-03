<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Tic_miembros_cuadrilla extends MX_Controller {

    function __construct() { //constructor predeterminado del controlador
        parent::__construct(); //carga los helpers
        $this->load->helper('array');
        $this->load->library('form_validation');
//        $this->load->library('pagination');
        $this->load->model('model_tic_miembros_cuadrilla'); //cargar los modelos de los cuales se necesitan datos
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

    public function get_cuad_assigned() {
        $id = $this->input->post('id');//id de la cuadrilla
        $num_sol = $this->input->post('solicitud');//numero de solicitud
        $ayudantes = $this->model_tic_ayudante->ayudantes_DeOrden($num_sol);
//        echo_pre($num_sol);
        ?>
        <!--<div class="col-md-12">-->
            <ul id="myTab2" class="nav nav-tabs" role="tablist">
		<li class="active">
                    <a href="#tabtable1<?php echo $num_sol ?>" role="tab" data-toggle="tab">Grupo asignado</a>
		</li>
		<li>
                    <a href="#tabtable2<?php echo $num_sol ?>" role="tab" data-toggle="tab">Ayudantes asignados</a>
		</li>
	    </ul>
            <div class="tab-content">
                <div class="tab-pane fade in active" role="tabpanel" id="tabtable1<?php echo $num_sol ?>">
                    <table id="cuad_assigned<?php echo $num_sol ?>" name="cuadrilla" class="table table-hover table-bordered table-condensed" width="100%">
                        <thead>
                            <tr>
                                <th><div align="center">Items</div></th>
                                <th><div align="center">Trabajador</div></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $asignados = $this->model_tic_ayudante->ayudantesDeCuadrilla_enOrden($num_sol, $id);
                            foreach ($asignados as $i => $miem):
                                $nom['nombre'] = $this->model_user->get_user_cuadrilla($miem['id_trabajador']);
                                ?>
                                <tr>
                                    <td><div align="center"> <?php $dos = str_pad($i+1, 2, '0', STR_PAD_LEFT); echo $dos; ?></div> </td> 
                                    <td>
                                    <?php echo($nom['nombre']); ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody> 
                    </table>
                </div>                                            
                <?php
                $final_ayudantes=array();
                $miembros = array();
                $this->model_asigna->asignados_cuadrilla_ayudantes($asignados, $ayudantes,$final_ayudantes,$miembros);
//          if(!empty($final_ayudantes)):?>
            <div class="tab-pane fade in" id="tabtable2<?php echo $num_sol ?>" role="tabpanel">
                <!--<label for = "responsable">Ayudantes en la orden</label>-->
                <table id="ayu_assigned<?php echo $num_sol ?>" name="cuadrilla" class="table table-hover table-bordered table-condensed" width="100%">
                    <thead>
                        <tr> 
                            <th></th>
                            <th><div align="center">Trabajador</div></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($final_ayudantes as $i => $fin): ?>
                        <tr>
                            <td><div align="center"> <?php $tres = str_pad($i+1, 2, '0', STR_PAD_LEFT);echo $tres; ?></div></td>
                            <td>
                            <?php echo($fin) ?>
                            </td>
                        </tr>
                   <?php endforeach; ?>
                    </tbody> 
                </table>      
            <?php // endif;?> 
            </div>
            </div>
        <!--</div>-->
<?php
    }
    
    public function list_miembros(){
//        echo_pre($this->input->post('nombre'));
       if (!empty($_POST['nombre'])):
            $trabajador = $this->input->post('nombre');
            $id_cuad = $this->input->post('cuad');?>
                <label class="control-label" for = "responsable">Asignar ayudantes</label>
                <table id="trabajadores2" name="cuadrilla" class="table table-hover table-bordered table-condensed" width="100%">
                    <thead>
                        <tr> 
                            <th><div align="center"></div></th>
                            <th><div align="center">Trabajador</div></th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php
                        $ayudantes = $this->model_user->get_userObrero();
//                        echo_pre($ayudantes);
                        foreach ($ayudantes as $ayu):
                            $completo = $ayu['nombre'].' '.$ayu['apellido'];
//                            echo_pre($completo);
                            if ($completo == $trabajador):
//                                echo $ayu['id_usuario'];
                                 $id = $ayu['id_usuario'];
//                                 echo_pre ($id);
//                                 if ($ayu['id_usuario'] == $id):
                                $cargo = $ayu['cargo'];
//                              endif;
                            endif;
//                            echo_pre ($id);
                        endforeach;
//                       
                          $miembros = $this->model_miembros_cuadrilla->get_miembros_cuadrilla($id_cuad);
//                          echo_pre($miembros);  
                          foreach ($miembros as $i => $ayu):
//                                if ($ayu->id_trabajador != $id):
                                    ?>
                                    <tr>
                                                                                
                                        <td><div align="center"><?php echo $i+1; ?> </div></td>
                                        <td><div align="center"><?php echo $ayu->trabajador; ?> </div>  </td> 
                                        
                                    </tr>
                                    <?php
//                                endif;
                            endforeach;
//                    
                        ?>
                    </tbody> 
                </table>
                <input type="hidden" name="id_trabajador" id="id_trabajador" value="<?php echo $id ?>"> <!--id del trabajador-->
                <div class="row">
                <div class="col-xs-4">
                    <label class="control-label">Selecciona una imagen</label>
                    <input id="file-3" name="archivo" type="file" multiple=true class="file-loading">
                </div>
                <div class="col-xs-12">
                        
                </div>
                <div class="col-xs-3">
                    <label class="control-label">Nombre de la imagen:</label>
                    <input class="form-control"name="nombre_img" id="nombre_img" type="text">
                </div>
                  <div class="col-xs-12">
                        
                 </div>
                </div>
        <?php            

            endif;
//          endif;
        
    }

}
