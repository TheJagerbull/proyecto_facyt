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
                                    <td><?php echo $tipo->id_orden; ?></td>
                                </tr>
                                <tr>
                                    <td><strong>Fecha de creación</strong></td>
                                    <td>:</td>
                                    <td><?php echo date("d/m/Y", strtotime($tipo->fecha_p)); ?></td>

                                </tr>
                                <tr>    
                                    <td><strong>Asunto</strong></td>
                                    <td>:</td>
                                    <td><?php echo $tipo->asunto; ?></td>
                                </tr>
                                <tr>    
                                    <td><strong>Descripción</strong></td>
                                    <td>:</td>
                                    <td><?php echo $tipo->descripcion_general; ?></td>
                                </tr>
                                <tr>    
                                    <td><strong>Dependencia</strong></td>
                                    <td>:</td>
                                    <td><?php echo $tipo->dependen; ?></td>
                                </tr>
                                <tr>    
                                    <td><strong>Ubicación</strong></td>
                                    <td>:</td>
                                    <td><?php echo $tipo->oficina; ?></td>
                                </tr>
                                <tr>    
                                    <td><strong>Responsable:</strong></td>
                                    <td>:</td>
                                       <?php if (empty($tipo->nombre)){ ?>
                                         <td> <?php echo ('<p class="text-muted">SIN ASIGNAR </p>'); ?></td>
                                        <?php }else {?>
                                        <td> <?php echo ($tipo->nombre).' '.($tipo->apellido);} ?></td>
                                    
                                </tr>
                                <tr>    
                                    <td><strong>Contacto</strong></td>
                                    <td>:</td>
                                    <td><?php echo $tipo->nombre_contacto; ?></td>
                                </tr>
                                <tr>    
                                    <td><strong>Observación</strong></td>
                                    <td>:</td>
                                    <td><?php echo $tipo->observac; ?></td>
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
            <!-- Modal -->
            <a href="<?php echo base_url() ?>index.php/mnt_solicitudes/mnt_solicitudes/lista_solicitudes" class="btn btn-info">Regresar</a>
            <div id="modificar" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="modificacion" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">X</button>
                            <h4 class="modal-title">Modificar</h4>
                        </div>
                        <div class="modal-body">

                            <!-- Edit profile form (not working)-->
                            <form class="form-horizontal" action="<?php echo base_url() ?>index.php/tipoeq/modificar" method="post">
                                <?php echo form_error('cod'); ?>
                                <?php echo form_error('desc'); ?>
                                <!-- codigo del tipo -->
                                <div class="form-group">
                                    <label class="control-label col-lg-2" for="cod">Codigo</label>
                                    <div class="col-lg-6">
                                        <input type="text" class="form-control" id="cod" name="cod" value='<?php echo ucfirst($tipo->cod) ?>'>
                                    </div>
                                </div>
                                <!-- nombre del tipo -->
                                <div class="form-group">
                                    <label class="control-label col-lg-2" for="desc">Descripcion</label>
                                    <div class="col-lg-6">
                                        <input type="text" class="form-control" id="desc" name="desc" value='<?php echo ucfirst($tipo->desc) ?>'>
                                    </div>
                                </div>                                                                                                                                         


                                <?php if (isset($edit) && $edit && isset($tipo)) : ?>
                                    <input type="hidden" name="id" value="<?php echo $tipo->id ?>" />
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
            <hr />

        </div>
    </div>

</div>

<div class="clearfix"></div>

</div>
</div>          