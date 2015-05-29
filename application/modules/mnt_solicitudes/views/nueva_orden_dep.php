<script type="text/javascript">
    base_url = '<?= base_url() ?>';
</script> 
<!-- Page content -->
<div class="mainy">
    <!-- Page title -->
    <div class="page-title">
        <h2><i class="fa fa-desktop color"></i> Solicitud<small> Genere una nueva solicitud</small></h2>
        <hr /> 
    </div>
    
    <!-- Page title -->
    <div class="row">
        <div class="col-md-12">
            <div class="awidget full-width">
                <?php if ($this->session->flashdata('create_orden') == 'success') : ?>
                    <div class="alert alert-success" style="text-align: center">Solicitud creada con éxito</div>
                <?php endif ?>
                <!-- <?php if ($this->session->flashdata('create_orden') == 'error') : ?>
                           <div class="alert alert-danger" style="text-align: center">Ocurrió un problema creando su solicitud</div>
                <?php endif ?> -->


                <div class="awidget-body">

                    <!-- FORMULARIO DE CREACION DE UNA NUEVA ORDEN DE TRABAJO-->
                    <!-- Formulario -->
                    <form class="form-horizontal" action="<?php echo base_url() ?>index.php/mnt_solicitudes/orden/nueva_orden_dep" method="post" name="nueva_orden_dep" id="nueva_orden">
                        <div class="col-lg-12" style="text-align: center">
                            <?php echo form_error('nombre_contacto'); ?>
                            <?php echo form_error('telefono_contacto'); ?>
                            <?php echo form_error('asunto'); ?>
                            <?php echo form_error('descripcion_general'); ?>
                            <?php echo form_error('observac'); ?>
                            <?php echo form_error('oficina'); ?>
                        </div>


                        
                        <div class="form-group">
                            <div class="control-label col-lg-6" style="text-align: left;"><h5><strong>DEPENDENCIA:</strong>  
                                <label><?php echo $nombre_depen; ?></h5></label></div>
                        </div>
                        
                        <!-- SELECT TIPO DE ORDEN -->
                        <div class="form-group">
                            <label class="control-label col-lg-2" style="text-align: left;" for = "id_tipo">Tipo de Orden</label>
                            <select id = "id_tipo" name="id_tipo">
                                <option value="">--SELECCIONE--</option>
                                <?php foreach ($tipo as $ord): ?>
                                    <option value = "<?php echo $ord->id_tipo ?>"><?php echo $ord->tipo_orden ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <!-- NOMBRE -->
                        <div class="form-group">
                            <label class="control-label col-lg-2" style="text-align: left;" for="nombre_contacto">Contacto</label>
                            <div class="col-lg-6"> <!-- el uppercase coloca el texto en mayusculas -->
                                <input type="text" title="No coloque caracteres especiales. Ejemplo: MARIA PEREZ" value="" 
                                style="text-transform:uppercase;" onkeyup="javascript:this.value = this.value.toUpperCase();" 
                                class="form-control" id="nombre_contacto" name="nombre_contacto" placeholder='indique el nombre'></input>
                            </div>
                        </div>

                        <!-- TELEFONO -->
                        <div class="form-group">
                            <label class="control-label col-lg-2" style="text-align: left;" for="telefono_contacto">Telefono Contacto</label>
                            <div class="col-lg-6">
                                <input type="text" class="form-control" title="No coloque puntos ni guiones. Ejemplo: 02418667496" 
                                id="telefono_contacto" name="telefono_contacto" placeholder='INDIQUE TELEFONO'></input>
                            </div>
                        </div>

                        <!-- ASUNTO -->
                        <div class="form-group">
                            <label class="control-label col-lg-2" style="text-align: left;" for="asunto">Asunto</label>
                            <div class="col-lg-6">
                                <input type="text" title="No coloque caracteres especiales. Ejemplo: AIRE DAÑADO" value="" 
                                style="text-transform:uppercase;" onkeyup="javascript:this.value = this.value.toUpperCase();" 
                                class="form-control" id="asunto" name="asunto" placeholder='INDIQUE ASUNTO'></input>
                            </div>
                        </div>

                        <!-- DESCRIPCION-->
                        <div class="form-group">
                            <label class="control-label col-lg-2" style="text-align: left;" for="descripcion_general">Descripcion</label>
                            <div class="col-lg-6">
                                <textarea rows="3" type="text" title="No coloque caracteres especiales." value="" 
                                style="text-transform:uppercase;" onkeyup="javascript:this.value = this.value.toUpperCase();" 
                                class="form-control" id="descripcion_general" name="descripcion_general" placeholder='Breve Descripcion'></textarea>
                            </div>
                        </div>  

                        <!-- OBSERVACION -->
                        <div class="form-group">
                            <label class="control-label col-lg-2" style="text-align: left;" for="observac">Observacion</label>
                            <div class="col-lg-6">
                                <textarea rows="3" type="text" value="" style="text-transform:uppercase;" 
                                onkeyup="javascript:this.value = this.value.toUpperCase();" class="form-control" id="observac" name="observac"></textarea>
                            </div>
                        </div> 

                        <!-- SELECT DE UBICACION-->
                        <div class="form-group">
                            <label class="control-label col-lg-2" style="text-align: left;" for = "oficina">Ubicacion</label>
                            <select id = "oficina_select" name="oficina_select" enabled>
                                <option value="">--SELECCIONE--</option>
                                <?php foreach ($ubica as $ubi): ?>
                                   <?php if ($id_depen == $ubi->id_dependencia):?>
                                    <option value = "<?php echo $ubi->id_ubicacion ?>"><?php echo $ubi->oficina ?></option>
                                    <?php endif; ?>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <div class="col-lg-6" >
                                <label class="checkbox-inline"> <!-- se habilita el checkbox cuando el select se deshabilita -->
                                    <input type="checkbox" id="otro" value="opcion_1" 
                                    onclick= "document.nueva_orden_dep.oficina_select.disabled = !document.nueva_orden_dep.oficina_select.disabled, document.nueva_orden_dep.oficina_txt.disabled = !document.nueva_orden_dep.oficina_txt.disabled">Otra Ubicacion
                                </label>

                                <div class="control-label">
                                    <input type="text" class="form-control" title="Indique el area afectada. Ejemplo: BAÑO" value="" 
                                    style="text-transform:uppercase;" onkeyup="javascript:this.value = this.value.toUpperCase();" id="oficina_txt" name="oficina_txt" placeholder="Escriba la ubicación" disabled>
                                </div>
                                    
                             </div>
                        </div>

                        <!-- Fin de Formulario -->

                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary">Guardar</button>
<<<<<<< HEAD
                            <a href="<?php echo base_url() ?>index.php/mnt_solicitudes/mnt_solicitudes/lista_solicitudes" class="btn btn-default">Cancelar</a>
=======
                            <a href="<?php echo base_url() ?>index.php/mnt_solicitudes/mnt_solicitudes/lista" class="btn btn-default">Cancelar</a>
>>>>>>> bd283f20612877f7fa78a27a59e3fe71be937e9d

                        </div> 
                    </form>

                    <div class="clearfix"></div> 
                </div>
            </div>
        </div>
    </div>
</div>
