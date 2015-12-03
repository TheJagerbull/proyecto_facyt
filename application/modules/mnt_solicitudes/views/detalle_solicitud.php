<script src="<?php echo base_url() ?>assets/js/jquery.min.js"></script>
<script type="text/javascript">
     base_url = '<?= base_url() ?>';
     $(document).ready(function() {
    $('#example').DataTable( {
        "paging":  true,
        "ordering": true,
        "info":     false
    } );
} );
</script>
<!--<script>
    function imprimir()
    {
        var objeto = document.getElementById('imprime');  //obtenemos el objeto a imprimir
        var ventana = window.open('', '_blank');  //abrimos una ventana vacía nueva
        ventana.document.write(objeto.innerHTML);  //imprimimos el HTML del objeto en la nueva ventana
        ventana.document.close();  //cerramos el documento
        ventana.print();  //imprimimos la ventana
        ventana.close();  //cerramos la ventana
    }
</script>-->
<style type="text/css">
    .modal-message .modal-header .fa, 
    .modal-message .modal-header 
    .glyphicon, .modal-message 
    .modal-header .typcn, .modal-message .modal-header .wi {
        font-size: 30px;
    }
</style>
<!-- Page content -->
<div class="mainy">
     <!--Page title--> 
    <div class="page-title">
        <h2 align="right"><i class="fa fa-desktop color"></i> Solicitud<small>Detalles</small></h2>
        <hr /> 
    </div>
    <div class="row">
        <div class="col-md-12">

            <div id='imprime' class="awidget full-width">
                <!--<link href="<?php echo base_url() ?>assets/css/bootstrap.min.css" rel="stylesheet">-->
                <div class="awidget-head">
                    <h3>Detalles de la Solicitud </h3>
                </div>
                <div class="awidget-body">
<!--                          Nuevo button Asignar personal -->
                    
                    <?php if ($this->session->flashdata('edit_solicitud') == 'success') : ?>
                        <div class="alert alert-success" style="text-align: center">La solicitud fue modificado con éxito</div>
                    <?php endif ?>
                    <?php if ($this->session->flashdata('edit_solicitud') == 'error') : ?>
                        <div class="alert alert-danger" style="text-align: center">Ocurrió un problema con la edición de la solicitud</div>
                    <?php endif ?>
                    <div class="row">
                        <div class="col-md-3 col-sm-3">
                        </div>
                        <div class="col-md-9 col-sm-9">
                           <?php if (($tipo['estatus'] != '3') && ($tipo['estatus'] != '4')) :?>
                            <div class="row">
                              <div class="btn-group pull-right " >
                                <button class="btn btn-info dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Asignar personal <span class="caret"></span>
                                </button>
                                <ul class="dropdown-menu">
                                <?php 
                                  
                                    if (!empty($tipo['cuadrilla'])): ?>
                                        <li><a onclick='cuad_asignada(($("#respon<?php echo($tipo['id_orden']) ?>")),<?php echo json_encode($tipo['id_orden']) ?>,<?php echo json_encode($tipo['id_cuadrilla']) ?>, ($("#show_signed<?php echo $tipo['id_orden'] ?>")), ($("#otro<?php echo $tipo['id_orden'] ?>")))' href='#cuad<?php echo $tipo['id_orden'] ?> ' data-toggle="modal" data-id="<?php echo $tipo['id_orden']; ?>" data-asunto="<?php echo $tipo['asunto'] ?>" data-tipo_sol="<?php echo $tipo['tipo_orden']; ?>" class="open-Modal" >
                                            <div align="center">Cuadrilla </div></a>
                                        </li>
                                <?php
                                    else :?>
                                        <li><a href='#cuad<?php echo $tipo['id_orden'] ?> ' data-toggle="modal" data-id="<?php echo $tipo['id_orden']; ?>" data-asunto="<?php echo $tipo['asunto'] ?>" data-tipo_sol="<?php echo $tipo['tipo_orden']; ?>" class="open-Modal" >
                                            <div align="center">Cuadrilla</div></a>
                                        </li>
                                  <?php endif; ?> 
                                        <li class="divider" role="separador"></li>
                                        <li><a onclick='ayudantes(<?php echo json_encode($tipo['estatus']) ?>,<?php echo json_encode($tipo['id_orden']) ?>, ($("#disponibles<?php echo $tipo['id_orden'] ?>")), ($("#asignados<?php echo $tipo['id_orden'] ?>")))' href='#ayudante<?php echo $tipo['id_orden'] ?>' data-toggle="modal"><div align="center"><?php if(in_array(array('id_orden_trabajo' => $tipo['id_orden']), $ayuEnSol)){ echo('Ayudantes');} else { echo ('Ayudantes');}?></div></a></li>
                                      
                                </ul>
                              </div>
                            </div>
                            <?php endif; ?>  
                            <br>
                            <div>
                            <table class="table">
                                <tr>
                                    <td><strong>Número Solicitud:</strong></td>
                                    <td>:</td>
                                    <td><?php echo $tipo['id_orden']; ?></td>
                                </tr>
                                <tr>    
                                    <td><strong>Contacto</strong></td>
                                    <td>:</td>
                                    <td><?php echo $tipo['nombre_contacto']; ?></td>
                                </tr>
                                <tr>    
                                    <td><strong>Teléfono</strong></td>
                                    <td>:</td>
                                    <td><?php echo $tipo['telefono_contacto']; ?></td>
                                </tr>
                                <tr>
                                    <td><strong>Creada por:</strong></td>
                                    <td>:</td>
                                    <td><?php echo $autor; ?></td>
                                </tr>
                                <tr>
                                    <td><strong>Fecha:</strong></td>
                                    <td>:</td>
                                    <td><?php echo date("d/m/Y", strtotime($creada)); ?></td>
                                </tr>
                                <tr>
                                    <td><strong>Última modificación</strong></td>
                                    <td>:</td>
                                    <td><?php echo date("d/m/Y", strtotime($tipo['fecha'])); ?></td>
                                </tr>
                                <tr>    
                                    <td><strong>Tipo de Solicitud</strong></td>
                                    <td>:</td>
                                    <td><?php echo $tipo['tipo_orden']; ?></td>
                                </tr>
                                <tr>    
                                    <td><strong>Dependencia</strong></td>
                                    <td>:</td>
                                    <td><?php echo $tipo['dependen']; ?></td>
                                </tr>
                                <tr>    
                                    <td><strong>Ubicación</strong></td>
                                    <td>:</td>
                                    <td><?php
                                        if ($oficina != 'N/A'):
                                            echo $oficina;
                                        else:
                                            if (!empty($observacion)):
                                                echo $observacion;
                                            else:
                                                echo ('<p class="text-muted">No Agregada</p>'); 
                                            endif;
                                        endif;
                                        ?></td>
                                </tr>
                                <tr>    
                                    <td><strong>Asunto</strong></td>
                                    <td>:</td>
                                    <td><?php echo $tipo['asunto']; ?></td>
                                </tr>
                                <tr>    
                                    <td><strong>Descripción</strong></td>
                                    <td>:</td>
                                    <td><?php echo $tipo['descripcion_general']; ?></td>
                                </tr>
                                <tr>    
                                    <td><strong>Estatus</strong></td>
                                    <td>:</td>
                                    <td><?php echo $tipo['descripcion']; ?></td>
                                </tr>
                                <?php if ($tipo['id_estado'] == '3' || $tipo['id_estado'] == '4' || $tipo['id_estado'] == '5' || $tipo['id_estado'] == '6'){ ?>
                                <tr>    
                                    <td><strong>Motivo del estatus</strong></td>
                                    <td>:</td>
                                    <td><?php echo $tipo['motivo']; }; ?></td>
                                </tr>
                                <?php if ($tipo['id_estado'] != '1' && !empty($cuadrilla)) { ?>
                                    <tr>    
                                        <td><strong>Cuadrilla</strong></td>
                                        <td>:</td>
                                        <?php if (empty($tipo['cuadrilla'])) { ?>
                                            <td> <?php echo ('<p class="text-muted">SIN ASIGNAR </p>'); ?></td>
                                        <?php } else { ?>
                                            <td> <?php
                                                echo ($tipo['cuadrilla']);
                                            };
                                            ?>
                                        </td>
                                    </tr>
                                    <tr>    
                                        <td><strong>Jefe de cuadrilla</strong></td>
                                        <td>:</td>
                                        <?php if (empty($nombre)) { ?>
                                            <td> <?php echo ('<p class="text-muted">SIN ASIGNAR </p>'); ?></td>
                                        <?php } else { ?>
                                            <td> <?php
                                                echo ($nombre);
                                            };
                                            ?></td>
                                    </tr>
                                    <tr>    
                                        <td><strong>Miembros</strong></td>
                                        <td>:</td>
                                        <td>
                                            <?php
                                            if (!empty($cuadrilla)) {
                                                foreach ($cuadrilla as $cuad):
                                                    if ($cuad != $nombre):
                                                        echo ($cuad) . '<br>';
                                                    endif;
                                                endforeach;
                                            }else {
                                                echo ('<p class="text-muted">SIN ASIGNAR </p>');
                                            };
                                            ?>
                                        </td>

                                    </tr>
                                    <tr>
                                        <?php
                                        if (!empty($ayudantes)) {
                                            echo '<td><strong>' . 'Ayudantes' . '</strong></td>';
                                            echo '<td>' . ':' . '</td>';
                                            echo '<td>';
                                            foreach ($ayudantes as $ayu):
                                                echo ($ayu) . '<br>';
                                            endforeach;
                                            echo '</td>';
                                        };
                                    }else {
                                        if (!empty($ayudantes)) {
                                            echo '<td><strong>' . 'Ayudantes' . '</strong></td>';
                                            echo '<td>' . ':' . '</td>';
                                            echo '<td>';
                                            foreach ($ayudantes as $ayu):
                                                echo ($ayu) . '<br>';
                                            endforeach;
                                            echo '</td>';
                                        };
                                    };
                                    ?>
                                </tr>
                                <?php if (!empty($tipo['sugerencia'])) { ?>
                                    <tr>    
                                        <td><strong>Sugerencia</strong></td>
                                        <td>:</td>
                                        <td><?php  echo $tipo['sugerencia'];   ?></td>
                                    </tr>
                                <?php };?>
                            </table>
                          </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class='container'align="right">
                
                <div class="inline">
                    
                    <button onClick="javascript:window.history.back();" type="button" name="Submit" class="btn btn-info">Regresar</button>
              
                     <button type="button" class="btn btn-primary" onclick="imprimir();">Imprimir</button>
                    <a data-toggle="modal" data-target="#pdf" class="btn btn-default btn">Crear PDF</a> 
                     <!--Button modal estatus--> 
                    <?php if (($tipo['estatus'] != '3') && ($tipo['estatus'] != '4')) : ?>
                    <a data-toggle="modal" data-target="#estatus_sol<?php echo $tipo['id_orden'] ?>" class="btn btn-success">Cambiar Estatus</a> 
                    <?php endif ?>
                     <!--Button to trigger modal--> 
                    <?php if (($tipo['estatus'] == '1')) : ?>
                        <a href="#modificar" class="btn btn-success" data-toggle="modal">Modificar</a>
                    <?php endif ?>
                     <!--Button modal comentarios-->
                    <?php if (($tipo['estatus'] != '3')) : ?>
                        <a href="#comentarios<?php echo $tipo['id_orden'] ?>" class="btn btn-warning" data-toggle="modal">Observaciones</a>
                    <?php endif ?>
                    
                </div>
                </div>
            </div>
        </div>

    </div>  
   
    <!-- Modal -->
    <div id="modificar" class="modal modal-message modal-info fade" tabindex="-1" role="dialog" aria-labelledby="modificacion" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <span><i class="glyphicon glyphicon-edit"></i></span>
                </div>
                <form class="form" action="<?php echo base_url() ?>index.php/mnt_solicitudes/mnt_solicitudes/editar_solicitud" method="post" onsubmit="return validacion()" name="modifica" id="modifica">
                    <div class="modal-body row">
                        <div class="col-md-6">

                            <!-- NOMBRE CONTACTO -->
                            <div class="form-group">
                                <label class="control-label" for="nombre_contacto">Contacto:</label>
                                <div class="control-label">
                                    <select class="form-control input-sm select2" id="nombre_contacto" name="nombre_contacto">
                                        <option></option>
                                        <option selected="<?php echo ($tipo['nombre_contacto'])?>" value="<?php echo ($tipo['nombre_contacto'])?>"><?php echo ($tipo['nombre_contacto'])?></option>
                                        <?php foreach ($todos as $all):
                                            $nombre = strtoupper($all['nombre']) . ' ' . strtoupper($all['apellido']);
                                          echo $nombre;
                                            if (($tipo['nombre_contacto'])!= ($nombre)):?>
                                            <option value="<?php echo strtoupper($all['nombre']) . ' ' . strtoupper($all['apellido']) ?>"><?php echo strtoupper($all['nombre']) . ' ' . strtoupper($all['apellido']) ?></option>
                                        <?php 
                                           endif;
                                        endforeach; ?>
                                    </select>
                                </div>
                            </div>
                            <!-- TELEFONO CONTACTO -->
                            <div class="form-group">
                                <label class="control-label" for="telefono_contacto">Teléfono:</label>
                                <div class="control-label">
                                    <input autocomplete="off" onblur="validatePhone('telefono_contacto', 'phone_msg')" type="text" value="<?php echo ($tipo['telefono_contacto']) ?>"
                                           class="form-control input-sm" style="text-transform:uppercase;" onkeyup="javascript:this.value = this.value.toUpperCase();" class="form-control" id="telefono_contacto" name="telefono_contacto"></input>
                                <span id="phone_msg" class="label label-danger"></span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <!-- SELECT TIPO DE SOLICITUD -->
                            <div class="form-group">   
                                <label class="control-label" for = "tipo">Tipo de Solicitud</label>
                                <select class = "form-control input-sm select2" id = "id_tipo" name="id_tipo">
                                    <?php foreach ($tipo_solicitud as $ord): ?>
                                        <option value=""></option>
                                        <?php if ($tipo['tipo_orden'] != $ord->tipo_orden): ?>
                                            <option value = " <?php echo $ord->id_tipo ?>"><?php echo $ord->tipo_orden ?></option>
                                        <?php else: ?>
                                            <option selected="$tipo['tipo_orden']" value = " <?php echo $tipo['id_tipo'] ?>"><?php echo $tipo['tipo_orden'] ?></option>
                                        <?php endif; ?>
                                    <?php endforeach; ?>
                                </select>
                            </div>

                            <div class="form-group">
                                <label class="control-label" for="asunto">Asunto</label>
                                <div class="control-label">
                                    <input autocomplete="off" style="text-transform:uppercase;" onKeyDown=" contador(this.form.asunto, ($('#restan')), 25);" onblur="validateLetters('asunto', 'asunto_msg')" type="text" class="form-control input-sm" id="asunto" name="asunto" value='<?php echo ($tipo['asunto']) ?>'>
                                   <span id="asunto_msg" class="label label-danger"></span>
                                </div>
                                <?php $total= "<script type='text/javascript'>var uno = document.getElementById('asunto');var dos = uno.value.length;document.write(dos);</script>";?>
                                <small><p align="right" name="resto" id="restan"><?php echo $total;?>/25</p></small>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="asunto">Descripción</label>
                            <div class="col-lg-24">
                                <textarea autocomplete="off" style="text-transform:uppercase;" onblur="validateLetters('descripcion_general', 'descripcion_msg')" onKeyDown=" contador(this.form.descripcion_general, ($('#resta')), 160)"class="form-control" id="descripcion_general" name="descripcion_general"><?php echo ($tipo['descripcion_general']) ?> </textarea>
                                <span id="descripcion_msg" class="label label-danger"></span>
                            </div>
                            <?php $total= "<script type='text/javascript'>var uno = document.getElementById('descripcion_general');var dos = uno.value.length;document.write(dos);</script>";?>
                                <small><p align="right" name="resto" id="resta"><?php echo $total;?>/160</p></small>
                        </div>
                        <!-- SELECT DE DEPENDENCIA-->
                        <div class="form-group">   
                            <label class="control-label" for = "dependencia">Dendendencia</label>
                            <select class = "form-control select2" id = "dependencia_select" name="dependencia">
                                <option value=""></option>
                                <option selected="$tipo['id_dependencia']" value = " <?php echo $tipo['id_dependencia'] ?>"><?php echo $tipo['dependen'] ?></option>
                                <?php foreach ($dependencia as $dep): ?>
                                    <?php if ($tipo['dependen'] != $dep->dependen): ?>
                                        <option value = " <?php echo $dep->id_dependencia ?>"><?php echo $dep->dependen ?></option>
                                    <?php endif; ?>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="form-group">   
                            <label class="control-label" for = "ubicacion">Ubicación</label>
                            <select class = "form-control" id = "oficina_select" name="ubicacion" enabled>
                                <option selected="$oficina" value = " <?php echo $tipo['ubicacion'] ?>"><?php echo $oficina?></option>
                            </select>
                        </div>
                        <?php  if (!empty($observacion)):?>
                            <div class="form-group">
                                <label class="control-label" for="otra">Otra ubicación</label>
                                <div class="control-label">
                                    <input autocomplete="off" style="text-transform:uppercase;" type="text" class="form-control input-sm" id="observac" name="observac" value='<?php echo $observacion ?>'>
                                </div>
                                
                            </div>
                        <?php endif ?>
                    </div>

                    <?php if (isset($edit) && $edit && isset($tipo)) : ?>
                        <input type="hidden" name="id" value="<?php echo $tipo['id_orden'] ?>" />
                    <?php endif ?>
                    <div class="modal-footer">
                        <button type="submit" id="hola"class="btn btn-primary">Guardar cambios</button>
                        <button type="button" class="btn btn-default" data-dismiss="modal" aria-hidden="true">Cancelar</button>
                    </div>
                </form>


            </div>

        </div>
    </div>

    <!-- Modal para iframe del pdf -->
    <div class="modal fade" id="pdf" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-lg">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h4 class="modal-title"></h4>
          </div>
          <div class="modal-body" style="height: 768px">
              <iframe  src="<?php echo base_url() ?>index.php/mnt_solicitudes/pdf/<?php echo $tipo['id_orden']; ?>" width="100%" height="100%" frameborder="0" allowtransparency="true"></iframe>  
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            <!-- <button type="button" class="btn btn-primary">Save changes</button> -->
          </div>
        </div>
        <!-- /.modal-content -->
      </div>
      <!-- /.modal-dialog -->
    </div>  

<!-- Modal para cambiar el estatus de una solicitud-->
    <div id="estatus_sol<?php echo $tipo['id_orden'] ?>" class="modal modal-message modal-info fade" tabindex="-1" role="dialog" aria-labelledby="mod" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <label class="modal-title">Cambiar Estatus</label>
                    <span><i class="glyphicon glyphicon-pencil"></i></span>
                </div>
                <form class="form" action="<?php echo base_url() ?>index.php/mnt_estatus_orden/cambiar_estatus" method="post" name="edita" id="edita" onsubmit="if ($('#<?php echo $tipo['id_orden'] ?>')){return valida_motivo($('#motivo<?php echo $tipo['id_orden'] ?>'));}">
                    <div class="modal-body row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="control-label" for = "estatus">Estatus:</label>
                                    <input type="hidden" id="orden" name="orden" value="<?php echo $tipo['id_orden'] ?>">
                                    <input type="hidden" id="id_cu" name="id_cu" value="<?php echo $tipo['id_cuadrilla'] ?>">
                                    <!-- SWITCH PARA EVALUAR OPCIONES DEL ESTATUS DE LA SOLICITUD-->
                                        <?php switch ($tipo['descripcion'])
                                        {
                                            case 'CERRADA':
                                                echo '<div class="alert alert-info" align="center"><strong>¡La solicitud fué cerrada. No puede cambiar de estatus!<strong></div>';
                                                break;
                                            case 'ANULADA':
                                                echo '<div class="alert alert-info" align="center"><strong>¡La solicitud fué anulada. No puede cambiar de estatus!<strong></div>';
                                                break;
                                            default:?>
                                            <?php if (($tipo['descripcion']!= 'EN PROCESO') && ($tipo['descripcion']!= 'PENDIENTE POR MATERIAL') && ($tipo['descripcion']!= 'PENDIENTE POR PERSONAL'))
                                            {
                                                echo '<div class="alert alert-warning" align="center"><strong>¡La solicitud está abierta. Debe asignar un personal!<strong></div>';
                                            }else{?>
                                            <select class="form-control select2" id = "sel<?php echo $tipo['id_orden'] ?>" name="select_estado" onchange="statusOnChange(this,$('#<?php echo $tipo['id_orden'] ?>'),$('#motivo<?php echo $tipo['id_orden'] ?>'))">
                                                    <?php if($tipo['descripcion']!= 'ABIERTA'):?>
                                                         <option value=""></option>
                                                    <?php endif; 
                                                foreach ($estatus as $est): ?>
                                                    <?php if ($tipo['descripcion'] != $est->descripcion): ?>
                                                        <option value = "<?php echo $est->id_estado ?>"><?php echo $est->descripcion ?></option>
                                                    <?php  endif;
                                                endforeach; ?>
                                            </select>
                                            <div id="<?php echo $tipo['id_orden'] ?>" name= "observacion">
                                                 <label class="control-label" for="observacion">Motivo:</label>
                                                    <div class="control-label">
                                                        <textarea rows="3" autocomplete="off" type="text" onKeyDown=" contador(this.form.motivo,($('#quitar<?php echo $tipo['id_orden'] ?>')),160);" onKeyUp="contador(this.form.motivo,($('#quitar<?php echo $tipo['id_orden'] ?>')),160);"
                                                        value="" style="text-transform:uppercase;" onkeyup="javascript:this.value = this.value.toUpperCase();" class="form-control" id="motivo<?php echo $tipo['id_orden'] ?>" name="motivo" placeholder='Indique el motivo..'></textarea>
                                                    </div> 
                                                    <small><p  align="right" name="quitar" id="quitar<?php echo $tipo['id_orden'] ?>" size="4">0/160</p></small>
                                            </div>
                                        <?php
                                            };
                                        break;
                                        } ?>
                                </div>
                            </div>
                        </div>
                    <div class="modal-footer">
                        <?php if($tipo['descripcion']!= 'ABIERTA'):?>
                            <button type="submit" class="btn btn-primary" id="<?php echo $tipo['id_orden'] ?>" >Enviar</button>
                        <?php endif; ?>
                        <button type="button" class="btn btn-default" data-dismiss="modal" aria-hidden="true">Cancelar</button>
                    </div>
              
               </form> <!-- /.fin de formulario -->
           </div> <!-- /.modal-content -->
        </div> <!-- /.modal-dialog -->
    </div><!-- /.Fin de modal estatus-->
      
    <!-- modal de cuadrilla -->
        <div id="cuad<?php echo $tipo['id_orden'] ?>" class="modal modal-message modal-info fade" tabindex="-1" role="dialog" aria-labelledby="cuadrilla" >
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                             <label class="modal-title">Asignar Cuadrilla</label>
                            <span><i class="glyphicon glyphicon-pushpin"></i></span>
                        </div>
                        <div class="modal-body row">
                            <div class="col-md-12">
                                <h4><label>Solicitud Número:
                                        <label name="data" id="data"></label>
                                    </label>
                                </h4>
                            </div>
                            <div class="col-md-6">
                                <label class="control-label" for = "tipo">Tipo:</label>
                                    <label class="control-label" id="tipo"></label>
                            </div>
                            <div class="col-md-6">
                                <label class="control-label" for = "tipo">Asunto:</label>
                                <label class="control-label" id="asunto"></label>
                            </div>
                           
                            <form class="form" action="<?php echo base_url() ?>index.php/mnt_asigna_cuadrilla/mnt_asigna_cuadrilla/asignar_cuadrilla" method="post" name="modifica" id="modifica">
                                <?php if (empty($tipo['cuadrilla'])): ?>
                                     <input type ="hidden" id="num_sol" name="num_sol" value="<?php echo $tipo['id_orden'] ?>">
                                     <div class="col-md-2">
                                            <label class="control-label" for="cuadrilla">Cuadrilla</label>
                                     </div>
                                     <div class="col-md-12">
                                        <div class="form-grouṕ">
                                            <select class = "form-control" id = "cuadrilla_select" name="cuadrilla_select" onchange="mostrar(this.form.num_sol, this.form.cuadrilla_select, this.form.responsable, ($('#ss<?php echo $tipo['id_orden'] ?>')))">
                                                <option selected=" " value = "">--Seleccione--</option>
                                                <?php foreach ($miembros as $cuad): ?>
                                                    <option value = "<?php echo $cuad->id ?>"><?php echo $cuad->cuadrilla ?></option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                            <label class="control-label" for = "responsable">Responsable</label>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <select class = "form-control" id = "responsable" name="responsable">
                                                <option selected=" " value = "">--Seleccione--</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div id= "test" class="col-md-12">
                                        <br>
                                        <div id="ss<?php echo $tipo['id_orden'] ?>">
                                            <!--aqui se muestra la tabla de las cuadrillas-->
                                        </div>
                                    </div>
                            <?php else: ?>
                                     <input type ="hidden" id="cut" name="cut" value="<?php echo $tipo['id_orden'] ?>">
                                      <input type ="hidden" id="cuadrilla" name="cuadrilla" value="<?php echo $tipo['id_cuadrilla'] ?>">
                                      <!--<div align="center"><label class="alert-danger">Esta cuadrilla ya fue asignada</label></div>-->
                                      <div align="center"><label>Jefe de cuadrilla:</label>
                                         <label name="respon" id="respon<?php echo $tipo['id_orden'] ?>"></label>
                                      </div>
                                      <!--<div class="col-md-6"><label for = "responsable">Miembros de la Cuadrilla</label></div>-->
                                      <div id="show_signed<?php echo $tipo['id_orden'] ?>" class="col-md-12">
                                      <!--mostrara la tabla de la cuadrilla asignada-->   
                                      </div>
                                    
                                    <div class="col-md-12">
                                      <div class="form-control alert-warning" align="center">
                                       <label class="checkbox-inline"> 
                                          <input type="checkbox" id="otro<?php echo $tipo['id_orden'] ?>" value="opcion_1">Quitar asignación de la cuadrilla
                                      </label>        
                                      </div>
                                    </div>
                                 <?php                                     
                                endif;?>
                                      
                                <div class="modal-footer">
                                    <div class = "col-md-12">
                                    <input  type="hidden" name="uri" value="<?php echo $this->uri->uri_string() ?>"/>
                                    <button type="button" class="btn btn-default" data-dismiss="modal" aria-hidden="true">Cancelar</button>
                                    <button type="submit" id="<?php echo $tipo['id_orden'] ?>" class="btn btn-primary">Guardar cambios</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
        </div>
    </div>
     <!-- fin de modal de cuadrilla-->
    <!-- MODAL DE AYUDANTES-->
        <div id="ayudante<?php echo $tipo['id_orden'] ?>" class="modal modal-message modal-info fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
             <div class="modal-dialog">
                 <div class="modal-content">
                     <div class="modal-header">
                         <h4 class="modal-title">Asignar Ayudantes</h4>
                     </div>
                     <div class="modal-body">
                         <div>
                             <h4><label>Solicitud Número: 
                                     <?php echo $tipo['id_orden'] ?>
                                 </label></h4>
                         </div>
                         <div>
                            <ul class="nav nav-tabs" role="tablist">
                                <li class="active">
                                    <a href="#tab-table1" data-toggle="tab">ayudantes disponibles</a>
                                </li>
                                <li>
                                    <a href="#tab-table2" data-toggle="tab">Ayudantes asignados</a>
                                </li>
                            </ul>
                        <div class="tab-content">
                            <div class="tab-pane active" id="tab-table1">
                         <div id='disponibles<?php echo $tipo['id_orden'] ?>'>
                             <!-- AQUI CONSTRULLE UNA LISTA DE AYUDANTES DISPONIBLES NO ASIGNADOS A LA ORDEN (revisar script mainFunctions.js linea 208 en adelante)-->
                         </div>
                            </div>
                        <div class="tab-pane" id="tab-table2">
                         <div id='asignados<?php echo $tipo['id_orden'] ?>'>
                             <!-- AQUI CONSTRULLE UNA LISTA DE AYUDANTES ASIGNADOS A LA ORDEN (revisar script mainFunctions.js linea 208 en adelante)-->
                         </div>
                        </div>
                         </div>
                         <div class="modal-footer">
                             <input form="ay<?php echo $tipo['id_orden'] ?>" type="hidden" name="uri" value="<?php echo $this->uri->uri_string() ?>"/>
                             <input form="ay<?php echo $tipo['id_orden'] ?>" type="hidden" name="id_orden_trabajo" value="<?php echo $tipo['id_orden'] ?>"/>
                             <button form="ay<?php echo $tipo['id_orden'] ?>" type="submit" class="btn btn-primary">Guardar cambios</button>

                             <button type="button" class="btn btn-default" data-dismiss="modal" aria-hidden="true">Cancelar</button>
                         </div>
                     </div>
                 </div>
             </div> 
        </div>
    <!-- FIN DE MODAL DE AYUDANTES-->
     
<!--modal comentarios -->
 <div id="comentarios<?php echo $tipo['id_orden'] ?>" class="modal modal-message modal-info fade" tabindex="-1" role="dialog" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content">
                <div class="modal-header">
                    <label class="modal-title">Observaciones</label><i class="glyphicon glyphicon-comment"></i>
                </div>
            <form class="form" action="<?php echo base_url() ?>index.php/mnt_solicitudes/observaciones" method="post" onsubmit="if ($('#<?php echo $tipo['id_orden'] ?>')){return valida_observacion($('#observac<?php echo $tipo['id_orden'] ?>'));}">
                <input type="hidden" id= "numsol" name="numsol" value="<?php echo $tipo['id_orden'] ?>">
            <div class="modal-body">
                    <div class="form-group">
                        <label class="control-label" for="observac">Observación</label>
                            <div class="col-lg-20">
                                <textarea rows="3" autocomplete="off" type="text" onKeyDown=" contador(this.form.observac,($('#restando<?php echo $tipo['id_orden'] ?>')),160);" onKeyUp="contador(this.form.observac,($('#restando<?php echo $tipo['id_orden'] ?>')),160);"
                                          value="" style="text-transform:uppercase;" onkeyup="javascript:this.value = this.value.toUpperCase();" class="form-control" id="observac<?php echo $tipo['id_orden'] ?>" name="observac" placeholder='Escriba aqui la observación...'></textarea>
                            </div>
                             <small><p  align="right" name="restando" id="restando<?php echo $tipo['id_orden'] ?>" size="4">0/160</p></small>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-primary" type="submit">Enviar</button>
                        <button type="button" class="btn btn-default" data-dismiss="modal" aria-hidden="true">Cancelar</button>
                    </div>
            </div>
                <table id="example" class="display" cellspacing="0" width="100%">
                    <thead>
                        <tr>
                            <th>Usuario</th>
                            <th>Observacion</th>
                        </tr>
                    </thead>
                    <tfoot></tfoot>
                    <tbody></tbody>
                </table>
            </form>
        </div>
    </div>
</div>

    <!--<div class="clearfix"></div>-->

<script>

    //funcion para validar que el input motivo no quede vacio(esta funcion se llama en el formulario de estatus de la solicitud)
    function valida_motivo(txt) {
        if($(txt).val().length < 1) {  
        $(txt).focus();
        swal({
            title: "Error",
            text: "El motivo es obligatorio",
            type: "error"
        });
       return false;  
   }
}
    function valida_observacion(txt) {
        if($(txt).val().length < 1) {  
        $(txt).focus();
        swal({
            title: "Error",
            text: "El comentario es obligatorio",
            type: "error"
        });
       return false;  
   }
}
    
</script>

<!--<script>
   
    function validateLetters(x,y)
      {
        var re = /[A-Za-z -']$/;
        if(re.test(document.getElementById(x).value))
        {
          document.getElementById(x).style.background ='#DFF0D8';
          document.getElementById(y).innerHTML = "";
          document.getElementById("hola").disabled=false;
          return true;
        }
        else
        {
          document.getElementById(x).style.background ='#F2DEDE';
          document.getElementById(y).innerHTML = "Solo se permiten letras";
          document.getElementById(x).focus();
          document.getElementById("hola").disabled=true;
          return false; 
        }
      }
      function validatePhone(x,y)
      {
        var phone = /[0-9]+/;
        if(phone.test(document.getElementById(x).value))
        {
          document.getElementById(x).style.background ='#DFF0D8';
          document.getElementById(y).innerHTML = "";
          document.getElementById("hola").disabled=false;
          return true;
        }
        else
        {
          document.getElementById(x).style.background ='#F2DEDE';
          document.getElementById(y).innerHTML = "Debe ser un numero de teléfono válido";
          document.getElementById(x).focus();
          document.getElementById("hola").disabled=true;
            return false;
        }
      }

      function validateEmail(x,y)
      {
        var mail = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;
        if(mail.test(document.getElementById(x).value))
        {
          document.getElementById(x).style.background ='#DFF0D8';
          document.getElementById(y).innerHTML = "";
          return true;
        }
        else
        {
          document.getElementById(x).style.background ='#F2DEDE';
          document.getElementById(y).innerHTML = "Correo invalido (ejemplo: 'usuario'@'servidor'.'dominio')";
          return false;
        }
      }</script>-->
