<script type="text/javascript">
    base_url = '<?php echo base_url() ?>';
</script>

<!-- Page content -->
<div class="page-title">
    <h2 align="right"><i class="fa fa-desktop color"></i> Cuadrilla <small> detalles</small></h2>
        <hr /> 
      
</div>
<div class="mainy">
    <!-- Page title -->
    <div class="row">
        <div class="col-md-12">

            <div class="awidget full-width">
                <div class="awidget-head">
                    <h3>Detalles de la cuadrilla </h3>
                </div>
                <div class="awidget-body">
                    <?php if ($this->session->flashdata('edit_item') == 'success') : ?>
                        <div class="alert alert-success" style="text-align: center">La cuadrilla fue modificada con éxito</div>
                    <?php endif ?>
                    <?php if ($this->session->flashdata('edit_item') == 'error') : ?>
                        <div class="alert alert-danger" style="text-align: center">Ocurrió un problema con la edición de la cuadrilla</div>
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
                                    <td><strong>Código:</strong></td>
                                    <td>:</td>
                                    <td><?php echo $item['id']; ?></td>
                                </tr>
                                <tr>
                                    <td><strong>Nombre:</strong></td>
                                    <td>:</td>
                                    <td><?php echo $item['cuadrilla'] ?></td>

                                </tr>
                                 <tr>    
                                    <td><strong>Responsable:</strong></td>
                                    <td>:</td>
                                    <td><?php echo $item['nombre'] ?></td>

                                </tr>
                                <tr>
                                	<td><strong>Miembros:</strong></td>
                                    <td>:</td>    
                                
                                    <?php foreach($miembros as $key => $trab_cuad ) : ?>
                                    	<td><?php echo $trab_cuad->miembros ?></td>
                                    	<tr> </tr>
                                    <?php endforeach; ?>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Button to trigger modal -->
            <?php if (isset($edit) && $edit && isset($tipo)) : ?>
                <a href="#modificar" class="btn btn-info" data-toggle="modal">Modificar cuadrilla</a>
<?php endif ?>
            
            <input onClick="javascript:window.history.back();" type="button" name="Submit" value="Regresar" class="btn btn-info"></>
            <!-- Modal -->
            <div id="modificar" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="modificacion" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">X</button>
                            <h4 class="modal-title">Modificar cuadrilla</h4>
                        </div>
                        <div class="modal-body">
                            <div>
                                <!-- Edit profile form (not working)-->
                                <form class="form-horizontal" action="<?php echo base_url() ?>index.php/tipoeq/modificar" method="post" name="modifica" id="modifica">
<?php echo form_error('id'); ?>
<?php echo form_error('cuadrilla'); ?>
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