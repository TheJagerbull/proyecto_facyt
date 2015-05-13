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
        <?php if($this->session->flashdata('create_orden') == 'error') : ?>
              <div class="alert alert-danger" style="text-align: center">Ocurrió un problema creando su solicitud</div>
            <?php endif ?>
            
            
        <div class="awidget-body">
          
          <!-- FORMULARIO DE CREACION DE UNA NUEVA ORDEN DE TRABAJO-->
          <!-- Formulario -->
                       <form class="form-horizontal" action="<?php echo base_url() ?>index.php/mnt_orden/orden/nueva_orden" method="post">
                          <div class="col-lg-12" style="text-align: center">
                                    <?php echo form_error('tipo'); ?>
                          </div>


                        <!-- SELECT TIPO DE ORDEN -->
                        <div class="form-group">
                            <label class="control-label col-lg-2" for="tipoO">Tipo de Orden</label>
                            <div class="col-lg-6">
                              <select id="tipoO" name="id_tipo" class="form-control">
                                <option value="">Seleccione</option>
                                  <option value="1">PLOMERIA</option>
                                  <option value="2">OBRAS CIVILES</option>
                                  <option value="3">ELECTRICIDAD</option>
                                  <option value="4">AREAS VERDES</option>
                                  <option value="5">MANTENIMIENTO GENERAL</option>
                              </select>
                            </div>
                          </div>

                        <!-- NOMBRE -->
                        <div class="form-group">
                            <label class="control-label col-lg-2" for="nombre_contacto">Nombre</label>
                            <div class="col-lg-6">
                              <input type="text" class="form-control" id="nombre_contacto" name="nombre_contacto" placeholder='Persona de Contacto'>
                            </div>
                        </div>

                        <!-- TELEFONO -->
                        <div class="form-group">
                            <label class="control-label col-lg-2" for="telefono_contacto">Telefono</label>
                            <div class="col-lg-6">
                              <input type="text" class="form-control" id="telefono_contacto" name="telefono_contacto" placeholder='Telefono de Contacto'>
                            </div>
                        </div>

                        <!-- ASUNTO -->
                        <div class="form-group">
                            <label class="control-label col-lg-2" for="asunto">Asunto</label>
                            <div class="col-lg-6">
                              <input type="text" class="form-control" id="asunto" name="asunto" placeholder='Asunto'>
                            </div>
                        </div>

                        <!-- DESCRIPCION-->
                        <div class="form-group">
                            <label class="control-label col-lg-2" for="descripcion_general">Descripcion</label>
                            <div class="col-lg-6">
                              <textarea rows="3" type="text" class="form-control" id="descripcion_general" name="descripcion_general" placeholder='Breve Descripcion'></textarea>
                            </div>
                        </div>  

                        <!-- OBSERVACION -->
                        <div class="form-group">
                            <label class="control-label col-lg-2" for="observac">Observacion</label>
                            <div class="col-lg-6">
                              <textarea rows="3" type="text" class="form-control" id="observac" name="observacion"></textarea>
                            </div>
                          </div> 

                         <!-- UBICACION-->
                        <div class="form-group">
                            <label class="control-label col-lg-2" for="oficina">Ubicacion</label>
                            <div class="col-lg-6">
                              <input type="text" class="form-control" id="oficina" name="oficina" placeholder='Indique la ubicacion'>
                            </div>
                        </div>

                                                                                                                                                               
                          
                      <!-- Fin de Formulario -->
                       
                       <div class="modal-footer">
                         <button type="submit" class="btn btn-primary">Guardar</button>
                         <button type="button" class="btn btn-default" data-dismiss="modal" aria-hidden="true">Cancelar</button>
                       </div> 
                      </form>

          <div class="clearfix"></div>
        </div>
      </div>
    </div>
  </div>
</div>
<div class="clearfix"></div>