<script type="text/javascript">
    base_url = '<?php echo base_url() ?>';
</script>
<script>
    function imprimir()
    {
        var objeto = document.getElementById('imprime');  //obtenemos el objeto a imprimir
        var ventana = window.open('', '_blank');  //abrimos una ventana vacía nueva
        ventana.document.write(objeto.innerHTML);  //imprimimos el HTML del objeto en la nueva ventana
        ventana.document.close();  //cerramos el documento
        ventana.print();  //imprimimos la ventana
        ventana.close();  //cerramos la ventana
    }
</script>
<style type="text/css">
    .modal-content {
        -webkit-border-radius: 0;
        -webkit-background-clip: padding-box;
        -moz-border-radius: 0;
        -moz-background-clip: padding;
        border-radius: 6px;
        background-clip: padding-box;
        -webkit-box-shadow: 0 0 40px rgba(0,0,0,.5);
        -moz-box-shadow: 0 0 40px rgba(0,0,0,.5);
        box-shadow: 0 0 40px rgba(0,0,0,.5);
        color: #000;
        background-color: #fff;
        border: rgba(0,0,0,0);
    }

    .modal-message .modal-body {
        background: 0 0;
        border: none;
        margin: 0;
        padding: 0 20px;

    }
    .modal-message .modal-footer, .modal-message .modal-header, .modal-message .modal-title {
        background: 0 0;
        border: none;
        margin: 0;
        padding: 0 20px;
        text-align: center!important;
    }
    .modal-message .modal-title {
        font-size: 17px;
        color: #737373;
        margin-bottom: 3px;
    }

    .modal-message .modal-body {
        color: #737373;
    }

    .modal-message .modal-header {
        color: #fff;
        margin-bottom: 10px;
        padding: 15px 0 8px;
    }
    .modal-message .modal-header .fa, 
    .modal-message .modal-header 
    .glyphicon, .modal-message 
    .modal-header .typcn, .modal-message .modal-header .wi {
        font-size: 30px;
    }

    .modal-message .modal-footer {
        margin: 25px 0 20px;
        padding-bottom: 10px;
    }

    .modal-backdrop.in {
        zoom: 1;
        filter: alpha(opacity=75);
        -webkit-opacity: .75;
        -moz-opacity: .75;
        opacity: .75;
    }
    .modal-backdrop {
        background-color: #fff;
    }
    .modal-message.modal-success .modal-header {
        color: #53a93f;
        border-bottom: 3px solid #a0d468;
    }

    .modal-message.modal-info .modal-header {
        color: #57b5e3;
        border-bottom: 3px solid #57b5e3;
    }

    .modal-message.modal-danger .modal-header {
        color: #d73d32;
        border-bottom: 3px solid #e46f61;
    }

    .modal-message.modal-warning .modal-header {
        color: #f4b400;
        border-bottom: 3px solid #ffce55;
    }
</style>
<!-- Page content -->
<div class="mainy">
    <!-- Page title -->
    <div class="page-title">
        <h2 align="right"><i class="fa fa-desktop color"></i> Solicitud<small>Detalles</small></h2>
        <hr /> 
    </div>
    <div class="row">
        <div class="col-md-12">

            <div id='imprime' class="awidget full-width">
                <link href="<?php echo base_url() ?>assets/css/bootstrap.min.css" rel="stylesheet">
                <div class="awidget-head">
                    <h3>Detalles de la Solicitud </h3>
                </div>
                <div class="awidget-body">
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
                            <div class="col-lg-12" style="text-align: center">
                            </div>
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
                                        <td><strong>Responsable</strong></td>
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
<!--                                <tr>    
                                    <td><strong>Observación</strong></td>
                                    <td>:</td>
                                    <td><?php // echo $tipo['observac'];   ?></td>
                                </tr>-->

                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class='container'align="right">
                <div class="inline">
                    <button onClick="javascript:window.history.back();" type="button" name="Submit" class="btn btn-info">Regresar</button>
                    <button type="button" class="btn btn-primary" onclick="imprimir();">Imprimir</button>
                    <a href="<?php echo base_url() ?>index.php/mnt_solicitudes/pdf/<?php echo $tipo['id_orden']; ?>" class="btn btn-default btn">Crear PDF</a>
                    <!-- Button to trigger modal -->
                    <?php if (($tipo['estatus'] == '1')) : ?>
                        <a href="#modificar" class="btn btn-success" data-toggle="modal">Modificar</a>
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
                <form class="form" action="<?php echo base_url() ?>index.php/mnt_solicitudes/mnt_solicitudes/editar_solicitud" method="post" onsubmit="return validacion_dep()" name="modifica" id="modifica">
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
                                    <input autocomplete="off" type="text" value="<?php echo ($tipo['telefono_contacto']) ?>"
                                           class="form-control input-sm" class="form-control" id="telefono_contacto" name="telefono_contacto"></input>
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
                                    <input autocomplete="off" onKeyDown=" contador(this.form.asunto, ($('#restan')), 25);" onblur="validateLetters('asunto', 'asunto_msg')" type="text" class="form-control input-sm" id="asunto" name="asunto" value='<?php echo ($tipo['asunto']) ?>'>
                                   <span id="asunto_msg" class="label label-danger"></span>
                                </div>
                                <?php $total= "<script type='text/javascript'>var uno = document.getElementById('asunto');var dos = uno.value.length;document.write(dos);</script>";?>
                                <small><p align="right" name="resto" id="restan"><?php echo $total;?>/25</p></small>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="asunto">Descripción</label>
                            <div class="col-lg-24">
                                <textarea autocomplete="off" onblur="validateLetters('descripcion_general', 'descripcion_msg')" onKeyDown=" contador(this.form.descripcion_general, ($('#resta')), 160)"class="form-control" id="descripcion_general" name="descripcion_general"><?php echo ($tipo['descripcion_general']) ?> </textarea>
                                <span id="descripcion_msg" class="label label-danger"></span>
                            </div>
                            <?php $total= "<script type='text/javascript'>var uno = document.getElementById('descripcion_general');var dos = uno.value.length;document.write(dos);</script>";?>
                                <small><p align="right" name="resto" id="resta"><?php echo $total;?>/160</p></small>
                        </div>
                        <div class="form-group" align ="center">   
                            <label class="control-label" for = "dependencia">Dendendencia:</label>
                            <label class="control-label" for = "dependencia"><?php echo $tipo['dependen'] ?></label> 
<!--                            <input type="hidden" name="dependendia_select" value="<?php echo $tipo['dependencia'] ?>">-->
                        
                        </div>
                        <div class="form-group">   
                            <label class="control-label" for = "ubicacion">Ubicación</label>
                            <select class="form-control input select2" id="oficina_select" name="ubicacion" enabled>
                                    <option value=""></option>
                                    <option selected="<?php echo $tipo['ubicacion'] ?>"value="<?php echo $tipo['ubicacion'] ?>"><?php echo $oficina ?></option>
                                        <?php foreach ($ubica as $ubi): ?>
                                            <?php if ($tipo['ubicacion'] != $ubi->id_ubicacion):?>
                                                <option value = "<?php echo $ubi->id_ubicacion ?>"><?php echo $ubi->oficina ?></option>
                                            <?php endif; ?>
                                        <?php endforeach; ?>
                            </select>
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


    <div class="clearfix"></div>

</div>
