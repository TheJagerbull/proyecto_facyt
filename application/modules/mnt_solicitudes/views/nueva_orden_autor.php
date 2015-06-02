<script type="text/javascript">
    base_url = '<?= base_url() ?>';
</script> 

<!-- Page content -->
<div class="mainy">
    <!-- Page title -->
    <div class="page-title">
        <h2 align="right"><i class="fa fa-desktop color"></i> Solicitud<small> Genere una nueva solicitud</small></h2>
        <hr /> 
    </div>

    <!-- Page title -->
    <div class="row">
    <div class="container-fluid">
        <div class="col-md-12">
            <div class="awidget full-width">
                <div class="awidget-body">

                    <!-- FORMULARIO DE CREACION DE UNA NUEVA ORDEN DE TRABAJO-->
                    <!-- Formulario -->
                    <form class="form-horizontal" action="<?php echo base_url() ?>index.php/mnt_solicitudes/orden/nueva_orden_autor" method="post" name="orden" id="orden" enctype="multipart/form-data">
                        <div class="col-lg-12" style="text-align: center">
                            <?php echo form_error('nombre_contacto'); ?>
                            <?php echo form_error('telefono_contacto'); ?>
                            <?php echo form_error('asunto'); ?>
                            <?php echo form_error('descripcion_general'); ?>
<?php// echo form_error('observac'); ?>
<?php echo form_error('oficina'); ?>
                        </div>



                       <!-- NOMBRE CONTACTO -->
                        <div class="form-group">
                            <label class="control-label col-lg-2" for="nombre_contacto">Contacto:</label>
                            <div class="col-lg-4">
                                <input type="text" value="<?php echo ucfirst($this->session->userdata('user')['nombre']) . ' ' . ucfirst($this->session->userdata('user')['apellido']) ?>"
                                       style="text-transform:uppercase;" onkeyup="javascript:this.value = this.value.toUpperCase();" class="form-control" id="nombre_contacto" name="nombre_contacto"></input>
                            </div>
                        </div>
                        <!-- TELEFONO CONTACTO -->
                        <div class="form-group">
                            <label class="control-label col-lg-2" for="telefono_contacto">Teléfono:</label>
                            <div class="col-lg-4">
                                <input type="text" value="<?php echo ($this->session->userdata('user')['telefono']) ?>"
                                       style="text-transform:uppercase;" onkeyup="javascript:this.value = this.value.toUpperCase();" class="form-control" id="telefono_contacto" name="telefono_contacto"></input>
                            </div>
                        </div>

                        <!-- SELECT TIPO DE ORDEN -->
                        <div class="form-group">
                            <label class="control-label col-lg-2" for = "id_tipo">    Tipo de solicitud:</label>
                            <div class="col-lg-4"> 
                                <select class="form-control" id = "id_tipo" name="id_tipo">
                                    <option value="">--SELECCIONE--</option>
                                    <?php foreach ($tipo as $ord): ?>
                                        <option value = "<?php echo $ord->id_tipo ?>"><?php echo $ord->tipo_orden ?></option>
<?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <!-- ASUNTO -->
                        <div class="form-group">
                            <label class="control-label col-lg-2" for="asunto">Titulo:</label>
                               
                            
                            
                            <div class="col-lg-4">
                                <input type="text" onKeyDown=" contador(this.form.asunto,($('#restan')),25);" onKeyUp="contador(this.form.asunto,($('#restan')),25);" value="" title="No coloque caracteres especiales. Ejemplo: AIRE DAÑADO"
                                       style="text-transform:uppercase;" onkeyup="javascript:this.value = this.value.toUpperCase();" class="form-control" id="asunto" name="asunto" placeholder='Titulo de la solicitud'></input>
                            </div>
                            <div class="col-xs-1">
                             <small><p align="right" name="resto" id="restan">0/25</p></small>
                                </div>
                            
                        </div>

                        <!-- DESCRIPCION-->
                        <div class="form-group">
                            <label class="control-label col-lg-2" for="descripcion_general">Detalles:</label>
                            <div class="col-lg-6">
                                <textarea rows="3" type="text" title="No coloque caracteres especiales." onKeyDown=" contador(this.form.descripcion_general,($('#resta')),160);" onKeyUp="contador(this.form.descripcion_general,($('#resta')),160);"
                                          value="" style="text-transform:uppercase;" onkeyup="javascript:this.value = this.value.toUpperCase();" class="form-control" id="descripcion_general" name="descripcion_general" placeholder='Detalles de la solicitud'></textarea>
                            </div>
                            <div col-sm-4 col-lg-2>
                                <small><p name="resta" id="resta" size="4">0/160</p></small>
                            
                            </div>
                        </div>  

                       <!-- SELECT DE DEPENDENCIA-->
                        <div class="form-group">
                            <label class="control-label col-lg-2" for = "dependencia_label">Dependencia:</label>
                            <div class="col-lg-4"> 
                                <select class="form-control" id = "dependencia_select" name="dependencia_select">
                                <option value="">--SELECCIONE--</option>
                                <?php foreach ($dependencia as $ubi): ?>
                                    <option value = "<?php echo $ubi->id_dependencia ?>"><?php echo $ubi->dependen ?></option>
                                <?php endforeach; ?>
                            </select>
                            </div>
                        </div>

                        <!-- SELECT DE UBICACION-->
                        <div class="form-group">
                            <label class="control-label col-lg-2" for = "oficina">Ubicación:</label>
                            <div class="col-lg-4"> 
                                <select class="form-control" id = "oficina_select" name="oficina_select">
                                <option value="">--SELECCIONE--</option>
                            </select>
                            </div>

                        </div>


                        <div class="form-group">
                            
                            <label class="checkbox-inline col-lg-2"> <!-- se habilita el checkbox cuando el select se deshabilita -->
                                    <input type="checkbox" id="otro" value="opcion_1" onclick= "document.orden.oficina_select.disabled = !document.orden.oficina_select.disabled, document.orden.observac.disabled = !document.orden.observac.disabled">&nbsp;&nbsp;&nbsp;Otra Ubicacion:
                                </label>
                           <div class="col-lg-4" >
                          <!-- OBSERVACION -->
                                      
                                <input type="text" class="form-control" value="" style="text-transform:uppercase;" onkeyup="javascript:this.value = this.value.toUpperCase();" class="form-control" id="observac" name="observac" disabled="true">                            </div>
                            
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
</div>
