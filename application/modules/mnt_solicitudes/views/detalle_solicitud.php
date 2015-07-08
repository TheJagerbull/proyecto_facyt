<script type="text/javascript">
    base_url = '<?php echo base_url() ?>';
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

 .modal-message .modal-body, .modal-message .modal-footer, .modal-message .modal-header, .modal-message .modal-title {
    background: 0 0;
    border: none;
    margin: 0;
    padding: 0 20px;
    /*text-align: center!important;*/
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
/*.modal-backdrop {
    background-color: #fff;
}*/
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
<div class="page-title">
    <h2 align="right"><i class="fa fa-desktop color"></i> Solicitud<small>Detalles</small></h2>
        <hr /> 
      
</div>
<div class="mainy">
    <!-- Page title -->
    <div class="row">
        <div class="col-md-12">

            <div class="awidget full-width">
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
                            <a href="profile.html#"></a>
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
                                    <td><strong>Fecha de creación</strong></td>
                                    <td>:</td>
                                    <td><?php echo date("d/m/Y", strtotime($tipo['fecha'])); ?></td>
                                   <!--<td><?php echo $tipo->fecha; ?></td>-->
                                </tr>
                                <tr>    
                                    <td><strong>Tipo de Solicitud</strong></td>
                                    <td>:</td>
                                    <td><?php echo $tipo['tipo_orden']; ?></td>
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
                                    <td><strong>Dependencia</strong></td>
                                    <td>:</td>
                                    <td><?php echo $tipo['dependen']; ?></td>
                                </tr>
                                <tr>    
                                    <td><strong>Ubicación</strong></td>
                                    <td>:</td>
                                    <td><?php echo $tipo['oficina']; ?></td>
                                </tr>
                                <tr>    
                                    <td><strong>Cuadrilla</strong></td>
                                    <td>:</td>
                                    <?php if (empty($tipo['cuadrilla'])) { ?>
                                        <td> <?php echo ('<p class="text-muted">SIN ASIGNAR </p>'); ?></td>
                                    <?php } else { ?>
                                        <td> <?php
                                            echo ($tipo['cuadrilla']);
                                        }
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
                                        }
                                        ?></td>

                                </tr>
                                <tr>    
                                    <td><strong>Contacto</strong></td>
                                    <td>:</td>
                                    <td><?php echo $tipo['nombre_contacto']; ?></td>
                                </tr>
                                <tr>    
                                    <td><strong>Observación</strong></td>
                                    <td>:</td>
                                    <td><?php echo $tipo['observac']; ?></td>
                                </tr>

                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Button to trigger modal -->
            <?php if (isset($edit) && $edit && isset($tipo)) : ?>
                <a href="#modificar" class="btn btn-info" data-toggle="modal">Modificar Solicitud</a>
            <?php endif ?>
            
            <input onClick="javascript:window.history.back();" type="button" name="Submit" value="Regresar" class="btn btn-info"></>
            <!-- Modal -->
            <div id="modificar" class="modal modal-message modal-info fade" tabindex="-1" role="dialog" aria-labelledby="modificacion" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <span><i class="glyphicon glyphicon-edit"></i></span>
                        </div>
                        <div class="modal-body">
                            <div>
                                <!-- Edit profile form (not working)-->
                                <form class="form" action="<?php echo base_url() ?>index.php/mnt_solicitudes/mnt_solicitudes/editar_solicitud" method="post" name="modifica" id="modifica">
                                    <?php echo form_error('cod'); ?>
                                    <?php echo form_error('desc'); ?>
                                    <!-- codigo del tipo -->

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
                                            <input type="text" class="form-control" id="asunto" name="asunto" value='<?php echo ($tipo['asunto']) ?>'>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="control-label" for="asunto">Descripción</label>
                                        <div class="col-lg-24">
                                            <textarea class="form-control" id="descripcion_general" name="descripcion_general"><?php echo ($tipo['descripcion_general']) ?> </textarea>
                                        </div>
                                    </div>                 
                                    <!-- SELECT DE DEPENDENCIA-->
                                    <div class="form-group">   
                                        <label class="control-label" for = "dependencia">Dendendencia</label>
                                        <select class = "form-control select2" id = "dependencia" name="dependencia">
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
                                        <select class = "form-control" id = "ubicacion" name="ubicacion" enabled>
                                            <option selected="$tipo['oficina']" value = " <?php echo $tipo['id_ubicacion'] ?>"><?php echo $tipo['oficina'] ?></option>
                                        </select>

                                        <label class="checkbox-inline">
                                            <input type="checkbox" id="otro" value="opcion_1" onclick= "document.modifica.ubicacion.disabled = !document.modifica.ubicacion.disabled, document.modifica.oficina.disabled = !document.modifica.oficina.disabled">Otro
                                        </label>

                                        <div class="control-label">
                                            <input type="text" class="form-control" id="oficina" name="oficina" placeholder="Escriba la ubicación" disabled>
                                        </div>         
                                    </div>


                                    <?php if (isset($edit) && $edit && isset($tipo)) : ?>
                                        <input type="hidden" name="id" value="<?php echo $tipo['id_orden'] ?>" />
                                    <?php endif ?>
                                    <div class="modal-footer">
                                        <button type="submit" class="btn btn-primary">Guardar cambios</button>
                                        <button type="button" class="btn btn-default" data-dismiss="modal" aria-hidden="true">Cancelar</button>
                                    </div>
                                </form>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <div class="clearfix"></div>

</div>
</div>          