<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Tic_responsable_orden extends MX_Controller {

    function __construct() { //constructor predeterminado del controlador
        parent::__construct(); //carga los helpers
        $this->load->helper('array');
        $this->load->library('form_validation');
        $this->load->library('pagination');
        $this->load->model('tic_solicitudes/model_tic_solicitudes', 'model_sol');
        $this->load->model('tic_asigna_cuadrilla/model_tic_asigna_cuadrilla', 'model_asigna');
        $this->load->model('tic_tipo/model_tic_tipo_orden', 'model_tipo');
        $this->load->model('dec_dependencia/model_dec_dependencia', 'model_dependen');
        $this->load->model('mnt_ubicaciones/model_mnt_ubicaciones_dep', 'model_ubicacion');
        $this->load->model('tic_cuadrilla/model_tic_cuadrilla', 'model_cuadrilla');
        $this->load->model('tic_asigna_cuadrilla/model_tic_asigna_cuadrilla', 'model_asigna');
        $this->load->model('tic_miembros_cuadrilla/model_tic_miembros_cuadrilla', 'model_miembros_cuadrilla');
        $this->load->model('user/model_dec_usuario', 'model_user');
        $this->load->model('tic_estatus_orden/model_tic_estatus_orden', 'model_estatus');
        $this->load->model('tic_ayudante/model_tic_ayudante', 'model_ayudante');
        $this->load->model('model_tic_responsable_orden', 'model_responsable');
        $this->load->model('mnt_estatus/model_mnt_estatus');
    }

 public function select_responsable() { //funcion trabajada con ajax en mainFunctions.js para asignar el responsable de una solicitud
        if ($this->input->post('id')) {
            $id_cuadrilla = $this->input->post('id');
            if(is_numeric($id_cuadrilla))://Para evaluar si viene de la cuadrilla o del modal de ayudantes
                $miembros = $this->model_miembros_cuadrilla->get_miembros_cuadrilla($id_cuadrilla);
                if ($this->input->post('sol')):
                    foreach ($miembros as $fila) {
                        if ($this->model_responsable->es_respon_orden($fila->id_trabajador,$this->input->post('sol'))):?> 
                            <option selected value="<?php echo $fila->id_trabajador?>"><?php echo $fila->trabajador ?></option>
                  <?php else:?>
                            <option value="<?php echo $fila->id_trabajador ?>"><?php echo $fila->trabajador ?></option>
                  <?php endif;
                    }
                else:
                    foreach ($miembros as $fila) {
                        if($this->model_cuadrilla->es_responsable($fila->id_trabajador,$id_cuadrilla)):?> 
                            <option selected value="<?php echo $fila->id_trabajador?>"><?php echo $fila->trabajador ?></option>                     
                  <?php else:?>
                            <option value="<?php echo $fila->id_trabajador ?>"><?php echo $fila->trabajador ?></option>
                  <?php endif; 
                    }
                endif;
            else:
                $ayudantes1 = $this->model_user->get_user_activos('6');
                $ayudantes2 = $this->model_user->get_user_activos('9');
                $ayudantes = array_merge($ayudantes1,$ayudantes2);
                $responsable = ($this->model_responsable->get_responsable($this->input->post('sol')));
                if($this->model_responsable->get_responsable($this->input->post('sol'))):?>
                    <option></option>
                    <option selected="<?php echo $responsable['id_responsable']?>" value="<?php echo $responsable['id_responsable']?>"  ><?php echo $responsable['nombre'].' '.$responsable['apellido']?></option>   
          <?php else:?>
                    <option></option>
          <?php endif;
                foreach ($ayudantes as $ayu):
                    if($ayu['id_usuario'] != $responsable['id_responsable']):?>
                        <option value="<?php echo $ayu['id_usuario'] ?>"><?php echo $ayu['nombre'].' '.$ayu['apellido']?></option>
              <?php endif;
                endforeach; 
            endif;
        }
    }
    
    public function show_all_respon(){
        $todos = $this->model_user->get_userObrero();
        $id_tipo = $this->model_cuadrilla->es_resp_no_jefe_cuad($this->session->userdata('user')['id_usuario']);
        ?><option></option><?php
        foreach ($todos as $all):
            if ($this->model_responsable->existe_resp_2($all['id_usuario'],"","","",$id_tipo)):
                ?>
                <option value="<?php echo $all['id_usuario']?>"><?php echo $all['nombre'].' '.$all['apellido'];?></option>
 <?php       endif;
        endforeach;
    }
    
     public function load_respond(){
        $band=1; //para que me muestre los datos consultados en el modelo
//        die_pre($this->input->post('estatus'). ' '. $this->input->post('id_trabajador'). ' '.$this->input->post('fecha1').' '.$this->input->post('fecha2'));
        ?>
        <div class="panel panel-info">
        <?php
        $estatus = $this->model_mnt_estatus->get_estatus_id($this->input->post('estatus'));
        if (is_numeric($this->input->post('id_trabajador'))):
            $datos = $this->model_responsable->consul_respon_sol($this->input->post('id_trabajador'),$this->input->post('estatus'),$this->input->post('fecha1'),$this->input->post('fecha2'),$band);
            $total_datos = count($datos); //Para tener la cantidad de datos obtenidos
            ?>
            <div class="panel-heading">
            <?php
            foreach ($datos as $dat):
                if ($total_datos >= 1):
                    $total_datos=0;
                    ?>             
                        <label><strong><?php echo $dat['Nombre'].' '.$dat['Apellido']?></strong></label>
                        <div class="btn-group btn-group-sm pull-right">
                            <label><strong></strong> Estatus : <?php echo $estatus?></strong> </label>
                        </div>
                        
                    <?php $nombre = $dat['cuadrilla'];
                endif;
                $ayudantes[$dat['id_orden']] = $this->model_ayudante->ayudantes_DeOrden($dat['id_orden']);
                
            endforeach;
//                die_pre($ayudantes);
                    
            ?>
            </div>
            <div class="panel-body">
                <div class="col-md-12 col-xs-12">
                    <p>Desde: <strong><?php echo date("d/m/Y", strtotime($this->input->post('fecha1')))?></strong>
                       Hasta: <strong><?php echo date("d/m/Y", strtotime($this->input->post('fecha2')))?></strong></p>
                </div>
                <div class="col-md-12 col-xs-12"><p>Cuadrilla: <strong><?php echo $nombre ?></strong></p></div>
                <input type="hidden" name="fecha1" value="<?php echo $this->input->post('fecha1') ?>"/>
                <input type="hidden" name="fecha2" value="<?php echo $this->input->post('fecha2') ?>"/>
                <input type="hidden" name="estatus" value="<?php echo $this->input->post('estatus') ?>"/>
                <input type="hidden" name="id_trabajador" value="<?php echo $this->input->post('id_trabajador') ?>"/>
                <button class="btn btn-default pull-right" id="reportePdf" type="submit">Crear PDF</button>
                <div class="col-md-12 col-xs-12"><br></div>
                <table id="res" class="table table-hover table-bordered table-condensed">
                    <thead>
                        <tr>
                            <th><div align="center">Orden</div></th>
                            <th><div align="center">Asignada</div></th>
                            <th><div align="center">Dependencia</div></th>
                            <th><div align="center">Asunto</div></th> 
                            <th><div align="center">Trabajadores</div></th> 
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($datos as $index => $dat) : 
                        $cont=0;?>  
                        <tr>
                            <td><div align="center"><?php echo ucfirst($dat['Orden'])?></div></td>
                            <td><div align="center"><?php echo date("d/m/Y", strtotime($dat['fecha']))?></div></td>
                            <td><div align="center"><?php echo ucfirst($dat['Dependencia'])?></div></td>
                            <td><div align="center"><?php echo ucfirst($dat['Asunto'])?></div></td>
                            <td><div align="center"><?php foreach($ayudantes[$dat['Orden']] as $id=>$ay): 
                                $cont++;
                                $total_datos = count($ayudantes[$dat['Orden']]);
                                echo ucfirst($ay['nombre']).' '.$ay['apellido'];
                                if($cont<$total_datos):
                                    echo ', ';
                                endif;
                                endforeach ?></div></td>
                        </tr>
                        <?php endforeach ?>
                    </tbody>
                </table>
<!--                <table class="display table table-hover table-bordered table-condensed">
                    <thead>
                        <tr>
                            <th><div align="center">Orden</div></th>
                            <th><div align="center">Trabajadores</div></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($ayudantes as $i=>$ayu): ?>
                         <tr>
                        <td><?php echo $i?></td>     
                         <td>
                           <div align="center">
                             <?php foreach($ayu as $id=>$ay): 
                                 $cont++;
                                echo ucfirst($ay['nombre']).' '.$ay['apellido'].''.$id;
                                if($cont>$id-1):
                                    echo ', ';
                                endif;
                                endforeach ?>
                            </div>
                         </td>   
                         </tr>
                                <?php endforeach ?>
                                
                            
                
                    </tbody>
                </table>-->
            </div>
            <?php
        elseif($this->input->post('id_trabajador')=='all'):
            $datos = $this->model_responsable->consul_respon_sol('',$this->input->post('estatus'),$this->input->post('fecha1'),$this->input->post('fecha2'),$band);
//            die_pre($datos);
            $total_datos = count($datos);
            foreach ($datos as $dat):
                $ayudantes[$dat['id_orden']] = $this->model_ayudante->ayudantes_DeOrden($dat['id_orden']);
            endforeach;
//            die_pre($ayudantes);
            ?>
                <style>
                    tr.group,
                    tr.group:hover {
                        background-color: #ddd !important;
                    }
                </style>
                <script type="text/javascript">
                    $(document).ready(function() {
                    var table = $('#trabajado').DataTable({
                    "language": {
                        "url": "<?php echo base_url() ?>assets/js/lenguaje_datatable/spanish.json"
                    },
                    "pagingType": "full_numbers",
                    "columnDefs": [
                        { "visible": false, "targets": 0 }
                    ],
                    "order": [[ 0, 'asc' ]],
                    "sDom": '<"top"l<"clear">>rt<"bottom"ip<"clear">>',
                    "oLanguage": { 
                        "oPaginate": 
                        {
                            "sNext": '<i title="Siguiente" class="glyphicon glyphicon-forward" ></i>',
                            "sPrevious": '<i title="Anterior" class="glyphicon glyphicon-backward" ></i>',
                            "sLast": '<i title="Último" class="glyphicon glyphicon-step-forward"></i>',
                            "sFirst": '<i title="Primero" class="glyphicon glyphicon-step-backward"></i>'
                        }
                    },
                    "drawCallback": function ( settings ) {
                        var api = this.api();
                        var rows = api.rows( {page:'current'} ).nodes();
                        var last=null; 
                        api.column(0, {page:'current'} ).data().each( function ( group, i ) {
                            if ( last !== group ) {
                                $(rows).eq( i ).before(
                                '<tr class="group"><td colspan="5">Responsable: '+group+'</td></tr>'
                                ); 
                                last = group;
                            }
                        });
                    }
                    });
 
                     // Order by the grouping
                    $('#trabajado tbody').on( 'click', 'tr.group', function () {
                        var currentOrder = table.order()[0];
                        if ( currentOrder[0] === 0 && currentOrder[1] === 'asc' ) {
                            table.order( [ 0, 'desc' ] ).draw();
                        }
                        else {
                            table.order( [ 0, 'asc' ] ).draw();
                        }
                    });
                    });
                </script>
                <div class="panel-heading">
                    <label><strong></strong></label>
                        <div class="btn-group btn-group-sm pull-right">
                            <label><strong></strong> Estatus : <?php echo $estatus?></strong> </label>
                        </div>
                </div>
                <div class="panel-body">
                    <div class="col-md-12 col-xs-12">
                    <p>Desde: <strong><?php echo date("d/m/Y", strtotime($this->input->post('fecha1')))?></strong>
                       Hasta: <strong><?php echo date("d/m/Y", strtotime($this->input->post('fecha2')))?></strong></p>
                    </div>
                <div class="col-md-12 col-xs-12"><br></div>
                <input type="hidden" name="fecha1" value="<?php echo $this->input->post('fecha1') ?>"/>
                <input type="hidden" name="fecha2" value="<?php echo $this->input->post('fecha2') ?>"/>
                <input type="hidden" name="estatus" value="<?php echo $this->input->post('estatus') ?>"/>
                <button class="btn btn-default pull-right" id="reportePdf" type="submit">Crear PDF</button>
                <div class="col-md-12 col-xs-12"><br></div>
                <table id="trabajado" class="table table-hover table-bordered table-condensed" align="center" width="100%">
                    <thead>
                        <tr>
                            <!--<th></th>-->
                            <th><div align="center">Nombre</div></th>
                            <th><div align="center">Orden</div></th>
                            <th><div align="center">Asignada</div></th>
                            <th><div align="center">Dependencia</div></th>
                            <th><div align="center">Asunto</div></th> 
                            <th><div align="center">Trabajadores</div></th>
                        </tr>
                    </thead>
                    <tbody>
                             <?php foreach($datos as $index => $dat) : 
                             $cont=0;?>  
                        <tr>
                            <td><?php echo ucfirst($dat['Nombre'].' '.$dat['Apellido'])?></td>
                            <td><div align="center"><?php echo ucfirst($dat['Orden'])?></div></td>
                            <td><div align="center"><?php echo date("d/m/Y", strtotime($dat['fecha']))?></div></td>
                            <td><div align="center"><?php echo ucfirst($dat['Dependencia'])?></div></td>
                            <td><div align="center"><?php echo ucfirst($dat['Asunto'])?></div></td>
                            <td><div align="center"><?php foreach($ayudantes[$dat['Orden']] as $id=>$ay): 
                                $cont++;
                                $total_datos = count($ayudantes[$dat['Orden']]);
                                echo ucfirst($ay['nombre']).' '.$ay['apellido'];
                                if($cont<$total_datos):
                                    echo ', ';
                                endif;
                                endforeach ?></div></td>
                        </tr>
                        <?php endforeach ?>                   
                    </tbody>
                </table>
                </div>
             <?php
        else:
            ?>
            <div class="panel-body">
                <div align='center' class='alert alert-danger' role='alert'><strong>Error... debe seleccionar un trabajador para mostrar el reporte</strong></div>
            </div>
            <?php
        endif;
    ?>
    </div><?php
    }
}
