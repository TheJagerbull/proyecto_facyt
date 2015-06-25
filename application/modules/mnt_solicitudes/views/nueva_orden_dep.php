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
                    <form class="form-horizontal" action="<?php echo base_url() ?>index.php/mnt_solicitudes/orden/nueva_orden_dep" method="post" name="nueva_orden_dep" id="nueva_orden" enctype="multipart/form-data">
                        <div class="col-lg-12" style="text-align: center">
                            <?php echo form_error('nombre_contacto'); ?>
                            <?php echo form_error('telefono_contacto'); ?>
                            <?php echo form_error('asunto'); ?>
                            <?php echo form_error('descripcion_general'); ?>
                            
                        </div>


                        <!-- MUESTRA DATOS DEL USUARIO QUE INICIA SESION -->
                       <div class="form-group">
                             <!-- DEPENDENCIA A LA QUE PERTENECE -->
                            <h3 align='left'>Dependencia: <?php echo $nombre_depen; ?></h3>
                            
                       <!-- NOMBRE CONTACTO -->
                        <div class="form-group">
                            <label class="control-label col-lg-2" for="nombre_contacto">Contacto:</label>
                            <div class="col-lg-4">
                                <input type="text" value="<?php echo ucfirst($this->session->userdata('user')['nombre']) . ' ' . ucfirst($this->session->userdata('user')['apellido']) ?>"
                                       style="text-transform:uppercase;" onkeyup="javascript:this.value = this.value.toUpperCase();" class="form-control" id="nombre_contacto" name="nombre_contacto"></input>
                            </div>
                            <div class="col-xs-6">
                             <small><p align="left">Persona de contacto</p></small>
                                </div>
                        </div>
                        <!-- TELEFONO CONTACTO -->
                        <div class="form-group">
                            <label class="control-label col-lg-2" for="telefono_contacto">Teléfono:</label>
                            <div class="col-lg-4">
                                <input type="text" value="<?php echo ($this->session->userdata('user')['telefono']) ?>"
                                       style="text-transform:uppercase;" onkeyup="javascript:this.value = this.value.toUpperCase();" class="form-control" id="telefono_contacto" name="telefono_contacto"></input>
                            </div>
                            <div class="col-xs-6">
                             <small><p align="left">Teléfono de contacto</p></small>
                                </div>
                        </div>
                        
                        <!-- SELECT TIPO DE ORDEN -->
                        <div class="form-group">
                            <label class="control-label col-lg-2" for = "id_tipo">Tipo de Solicitud:</label>
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
                            <label class="control-label col-lg-2" for="asunto">Título:</label>
                            <div class="col-lg-4">
                                <input type="text" onKeyDown=" contador(this.form.asunto,($('#restan')),25);" onKeyUp="contador(this.form.asunto,($('#restan')),25);" value="" 
                                       style="text-transform:uppercase;" onkeyup="javascript:this.value = this.value.toUpperCase();" class="form-control" id="asunto" name="asunto" placeholder='Titulo de la solicitud'></input>
                            </div>
                            <div class="col-xs-1">
                                <small><p align="right" name="resto" id="restan">0/25</p></small>
                            </div>
                        </div>

                        <!-- DESCRIPCION-->
                        <div class="form-group">
                            <label class="control-label col-lg-2" for="descripcion_general">Detalles:<span class="label label-warning" data-toggle="modal" href="#ayuda">?</span></label>
                            <div class="col-lg-6">
                                <textarea rows="3" type="text" onKeyDown=" contador(this.form.descripcion_general,($('#resta')),160);" onKeyUp="contador(this.form.descripcion_general,($('#resta')),160);"
                                          value="" style="text-transform:uppercase;" onkeyup="javascript:this.value = this.value.toUpperCase();" class="form-control" id="descripcion_general" name="descripcion_general" placeholder='Detalles de la solicitud'></textarea>
                            </div>
                            <div col-sm-4 col-lg-2>
                                <small><p name="resta" id="resta" size="4">0/160</p></small>
                                
                            </div> 
                        </div> 
                        <div id="ayuda" class="modal fade" tabindex="-1" role="dialog" style="display: none;">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <a class="close" data-dismiss="modal" >X</a>
                                        <h4><strong>Ayuda</strong></h4>
                                    </div>
                                    <div class="modal-body">
                                        <h5 align="justify"><strong>En detalles de la solicitud debe colocar lo siguiente:</strong><br><br>* Indicar cual es el problema.<br>* Desde cuando ocurre.
                                            <br>* Indicar la hora y el día que se pueda ubicar la persona de contacto.</h5>
                                        <p align="justify"><strong>* Ejemplo:</strong> El aire no enfría. Esta falla la presenta desde ayer en la mañana. Estoy de lunes a miércoles a partir de las 10am, jueves y viernes desde las 8am.</p>
                                    </div>
                                </div>
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
                            <label class="control-label col-lg-2" for = "oficina">Ubicación:<span class="label label-warning" data-toggle="modal" href="#ayuda2">?</span></label>
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
                         <div id="ayuda2" class="modal fade" tabindex="-1" role="dialog" style="display: none;">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <a class="close" data-dismiss="modal" >X</a>
                                        <h4><strong>Ayuda</strong></h4>
                                    </div>
                                    <div class="modal-body">
                                        <h5 align="justify"><strong>Si su ubicación no aparece en la lista debe hacer lo siguiente:</strong><br><br>=> Seleccione otra ubicación y deberá agregar una nueva.<br><br>
                                            * Si su dpto. se divide en 3 áreas por ejemplo: Laboratorio de Docencia II, Cubículo de recepción y baño. Y el área donde está el problema es laboratorio de Docencia II pero no aparece en la lista.<br>
                                            En la opción otra ubicación debe colocar Laboratorio Docencia II.</h5>
                                        
                                    </div>
                                </div>
                            </div>
                        </div>

                            <div class="form-group">
                                                            
                                <label class="checkbox-inline col-lg-2"> <!-- se habilita el checkbox cuando el select se deshabilita -->
                                    <input type="checkbox" id="otro" value="opcion_1" onclick="document.nueva_orden_dep.oficina_select.disabled = !document.nueva_orden_dep.oficina_select.disabled, document.nueva_orden_dep.observac.disabled = !document.nueva_orden_dep.observac.disabled">&nbsp;&nbsp;&nbsp;<strong>Otra Ubicación:</strong>
                                </label>
                                <div class="col-lg-4">
                                    <!-- OBSERVACION -->
                                    <input type="text" class="form-control" value="" style="text-transform:uppercase;" onkeyup="javascript:this.value = this.value.toUpperCase();" class="form-control" id="observac" name="observac" disabled="true" placeholder="Indique ubicación">                                </div>
                                  
                             </div>

                        <!-- Fin de Formulario -->

                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary">Guardar</button>
                            <a href="<?php echo base_url() ?>index.php/mnt_solicitudes/listar" class="btn btn-default">Cancelar</a>
                        </div> 
                    </form>

                    <div class="clearfix"></div> 
                </div>
            </div>
        </div>
        </div>
    </div>
</div>
