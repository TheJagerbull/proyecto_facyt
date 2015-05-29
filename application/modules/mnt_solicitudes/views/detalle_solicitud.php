<script type="text/javascript">
    base_url = '<?php echo base_url() ?>';
</script>

<script type="text/javascript" src="<?php echo base_url() ?>assets/js/jquery.js"></script>
<script type="text/javascript">
    $(document).ready(function () {
        $("#dependencia_select").change(function () {
            $("#dependencia_select option:selected").each(function () {
                departamento = $('#dependencia_select').val();
                $.post("<?php echo base_url() ?>index.php/mnt_solicitudes/orden/select_oficina", {
                    departamento: departamento
                }, function (data) {
                    $("#oficina_select").html(data);
                });
            });
        })
    });
</script>
<!-- Page content -->


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
                                    <td><?php echo date("d/m/Y", strtotime($tipo['fecha_p'])); ?></td>
                                   <!--<td><?php echo $tipo->fecha_p; ?></td>-->

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
                                        <td> <?php echo ($tipo['cuadrilla']);
                                }
                                    ?></td>

                                </tr>
                                <tr>    
                                    <td><strong>Responsable</strong></td>
                                    <td>:</td>
                                    <?php if (empty($nombre['nombre'])) { ?>
                                        <td> <?php echo ('<p class="text-muted">SIN ASIGNAR </p>'); ?></td>
                                        <?php } else { ?>
                                        <td> <?php echo ($nombre['nombre']) . ' ' . ($nombre['apellido']);
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
            <div id="modificar" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="modificacion" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">X</button>
                            <h4 class="modal-title">Modificar Solicitud</h4>
                        </div>
                        <div class="modal-body">
                            <div>
                                <!-- Edit profile form (not working)-->
                                <form class="form-horizontal" action="<?php echo base_url() ?>index.php/tipoeq/modificar" method="post" name="modifica" id="modifica">
<?php echo form_error('cod'); ?>
<?php echo form_error('desc'); ?>
                                    <!-- codigo del tipo -->

                                    <div class="form-group">   
                                        <label class="control-label" for = "tipo">Tipo de Solicitud</label>
                                        <select class = "form-control" id = "tipo_orden" name="tipo_orden">
                                            <?php foreach ($tipo_solicitud as $ord): ?>
                                                <?php if ($tipo['tipo_orden'] != $ord->tipo_orden): ?>
                                                    <option value = " <?php echo $ord->tipo_orden ?>"><?php echo $ord->tipo_orden ?></option>
                                                <?php else: ?>
                                                    <option selected="$tipo['tipo_orden']" value = " <?php echo $tipo['tipo_orden'] ?>"><?php echo $tipo['tipo_orden'] ?></option>
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
                                            <textarea class="form-control" id="descripcion" name="descripcion"><?php echo ($tipo['descripcion_general']) ?> </textarea>
                                        </div>
                                    </div>                 
                                    <!-- SELECT DE DEPENDENCIA-->
                                    <div class="form-group">   
                                        <label class="control-label" for = "dependencia">Dendendencia</label>
                                        <select class = "form-control" id = "dependencia_select" name="dependencia_select">
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
                                        <select class = "form-control" id = "oficina_select" name="oficina_select" enabled>
                                           <option selected="$tipo['oficina']" value = " <?php echo $tipo['oficina'] ?>"><?php echo $tipo['oficina'] ?></option>
                                        </select>
                                        
                                        <label class="checkbox-inline">
                                            <input type="checkbox" id="otro" value="opcion_1" onclick= "document.modifica.ubicacion.disabled = !document.modifica.ubicacion.disabled, document.modifica.oficina.disabled = !document.modifica.ubicacion.disabled">Otro
                                        </label>

                                        <div class="control-label">
                                            <input type="text" class="form-control" id="oficina" name="oficina" placeholder="Escriba la ubicación" disabled>
                                        </div>         
                                    </div>
                                    
                                    <div class="form-group">
                                        <label class="control-label" for="cuadrilla">Cuadrilla</label>
                                        <div class="control-label">
                                            <select class = "form-control" id = "cuadrilla_select" name="cuadrilla_select">
                                            <option selected="$tipo['id_cuadrilla']" value = " <?php echo $tipo['id_cuadrilla'] ?>"><?php echo $tipo['cuadrilla'] ?></option>
                                            <?php foreach ($cuadrilla as $cuad): ?>
                                                <?php if ($tipo['cuadrilla'] != $cuad->cuadrilla): ?>
                                                    <option value = " <?php echo $cuad->id ?>"><?php echo $cuad->cuadrilla ?></option>
                                                                                          
                                                <?php endif; ?>
                                            <?php endforeach; ?>
                                        </select>
                                        </div>
                                    </div>
                                    
                                    <div class="form-group">   
                                        <label class="control-label" for = "responsable">Responsable</label>
                                        <input type="text" class="form-control" id="responsable" name="responsable"value="<?php echo ($nombre['nombre']) . ' ' . ($nombre['apellido']); ?>"> </input>
                                       
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
                <hr/>

            </div>
        </div>

    </div>

    <div class="clearfix"></div>

</div>
</div>          