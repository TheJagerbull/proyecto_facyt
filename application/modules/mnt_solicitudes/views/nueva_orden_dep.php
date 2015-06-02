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
                    <form class="form-horizontal" action="<?php echo base_url() ?>index.php/mnt_solicitudes/orden/nueva_orden_dep" method="post" name="nueva_orden_dep" id="nueva_orden" enctype="multipart/form-data">
                        <div class="col-lg-12" style="text-align: center">
                            <?php echo form_error('nombre_contacto'); ?>
                            <?php echo form_error('telefono_contacto'); ?>
                            <?php echo form_error('asunto'); ?>
                            <?php echo form_error('descripcion_general'); ?>
                            <?php echo form_error('observac'); ?>
                            <?php echo form_error('oficina'); ?>
                        </div>


                       
                        <!-- MUESTRA DATOS DEL USUARIO QUE INICIA SESION -->
                        <div class="form-group">
                             <!-- DEPENDENCIA A LA QUE PERTENECE -->
                            <h3 align='left'>Dependencia: <?php echo $nombre_depen; ?></h3>
                            <!-- NOMBRE Y APELLIDO DE USUARIO-->
                            <input type="hidden" value="<?php echo ucfirst($this->session->userdata('user')['nombre']) . ' ' . ucfirst($this->session->userdata('user')['apellido']) ?> " id="nombre_contacto" name="nombre_contacto" >
                        </div>
                        <div class="form-group">
                            <h3 align='left'>Persona de contacto: <?php echo ucfirst($this->session->userdata('user')['nombre']) . ' ' . ucfirst($this->session->userdata('user')['apellido']) ?>
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Teléfono: <?php echo ($this->session->userdata('user')['telefono']) ?>
                            </h3>
                          
                            <!-- TELEFONO DE USUARIO -->
                            <input type="hidden" id="telefono_contacto" 
                             name="telefono_contacto" value="<?php echo ($this->session->userdata('user')['telefono']) ?>">
                            
                        </div>
                        <!-- SELECT TIPO DE ORDEN -->
                        <div class="form-group">
                            <label class="control-label col-lg-2" style="text-align: left;" for = "id_tipo">Tipo de Solicitud:</label>
                                <div class="col-lg-4"> 
                                    <select class="form-control" id = "id_tipo" name="id_tipo">
                                        <option value="">--SELECCIONE--</option>
                                            <?php foreach ($tipo as $ord): ?>
                                        <option value = "<?php echo $ord->id_tipo ?>"><?php echo $ord->tipo_orden ?></option>
                                            <?php endforeach; ?>
                                    </select>
                                </div>
                        </div>
                        <!-- TITULO DE LA SOLICITUD -->
                        <div class="form-group">
                            <label class="control-label col-lg-2" style="text-align: left;" for="asunto">Titulo:</label>
                            <div class="col-lg-4">
                                <input type="text" onKeyDown=" contador(this.form.asunto,this.form.resto,25);" onKeyUp="contador(this.form.asunto,this.form.resto,25);"
                                title="No coloque caracteres especiales. Ejemplo: AIRE DAÑADO" value="" style="text-transform:uppercase;" onkeyup="javascript:this.value = this.value.toUpperCase();" 
                                class="form-control" id="asunto" name="asunto" placeholder='titulo de la solicitud'></input>
                            </div>
                             <label class="bg-default col-sm-1">Restan</label>
                                <div class="col-sm-1">
                                    <input type="text" class="form-control" name="resto" size="4" disabled="true" value="25">
                                </div>
                        </div>

                        <!-- DESCRIPCION-->
                        <div class="form-group">
                            <label class="control-label col-lg-2" style="text-align: left;" for="descripcion_general">Detalle:</label>
                            <div class="col-lg-6">
                                <textarea rows="3" type="text" title="No coloque caracteres especiales." onKeyDown=" contador(this.form.descripcion_general,this.form.resta,140);" 
                                onKeyUp="contador(this.form.descripcion_general,this.form.resta,140);"value="" style="text-transform:uppercase;" onkeyup="javascript:this.value = this.value.toUpperCase();" 
                                class="form-control" id="descripcion_general" name="descripcion_general" placeholder='detalle de la solicitud'></textarea>
                            </div>
                            <label class="awidget col-lg-1">Restan</label>
                                <div class="col-lg-2">
                                    <input type="text" class="awidget col-lg-4" name="resta" size="4" disabled="true" value="140">
                                </div>
                        </div>  

                        <!-- OBSERVACION 
                        <div class="form-group">
                            <label class="control-label col-lg-2" style="text-align: left;" for="observac">Observacion</label>
                            <div class="col-lg-6">
                                <textarea rows="3" type="text" value="" style="text-transform:uppercase;" 
                                onkeyup="javascript:this.value = this.value.toUpperCase();" class="form-control" id="observac" name="observac"></textarea>
                            </div>
                        </div> -->

                        <!-- SELECT DE UBICACION-->
                        <div class="form-group">
                            <label class="control-label col-lg-2" style="text-align: left;" for = "oficina">Ubicacion</label>
                            <div class="col-lg-4"> 
                                <select class="form-control" id="oficina_select" name="oficina_select" enabled>
                                    <option value="">--SELECCIONE--</option>
                                        <?php foreach ($ubica as $ubi): ?>
                                            <?php if ($id_depen == $ubi->id_dependencia):?>
                                                <option value = "<?php echo $ubi->id_ubicacion ?>"><?php echo $ubi->oficina ?></option>
                                            <?php endif; ?>
                                        <?php endforeach; ?>
                                    </select>
                            </div>
                        </div>
                            <div class="form-group">
                            
                                <label class="checkbox-inline col-lg-2"> <!-- se habilita el checkbox cuando el select se deshabilita -->
                                    <input type="checkbox" id="otro" value="opcion_1" 
                                    onclick= "document.nueva_orden_dep.oficina_select.disabled = !document.nueva_orden_dep.oficina_select.disabled, document.nueva_orden_dep.observac.disabled = !document.nueva_orden_dep.observac.disabled">&nbsp;&nbsp;&nbsp;Otra Ubicacion
                                </label>
                                <div class="col-lg-4" >
                                    <!-- OBSERVACION -->
                                    <input type="text" class="form-control" title="Indique el area afectada. Ejemplo: BAÑO" value="" 
                                    style="text-transform:uppercase;" onkeyup="javascript:this.value = this.value.toUpperCase();" class="form-control" id="observac" name="observac" disabled="true" placeholder="Escriba la ubicación">
                                </div>
                                    
                             </div>
                        

                        <!-- Fin de Formulario -->

                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary">Guardar</button>
                            <a href="<?php echo base_url() ?>index.php/mnt_solicitudes/lista" class="btn btn-default">Cancelar</a>
                        </div> 
                    </form>

                    <div class="clearfix"></div> 
                </div>
            </div>
        </div>
    </div>
</div>
