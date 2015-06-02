<!-- Page content -->
<div class="mainy">
  <!-- Page title -->
  <div class="page-title">
    <h2><i class="fa fa-user color"></i> Nueva<small> Cuadrilla</small></h2> 
    <hr />
  </div>
  <!-- Page title -->
  <div class="row">
    <div class="col-md-12">
      <div class="awidget full-width">
        <?php if($this->session->flashdata('nuevo_equipo') == 'error') : ?>
              <div class="alert alert-danger" style="text-align: center">Ocurrió un problema agregando el Equipo</div>
            <?php endif ?>
        <div class="awidget-body">
          <!-- FORMULARIO DE CREACION DE USUARIOS PARA CONTROL DE LA APLICACION -->
          <!-- Formulario -->
                       <form id="newuser"class="form-horizontal" action="<?php echo base_url() ?>index.php/inv_queipos/equipos/nuevo_equipo" method="post">
                          <div class="col-lg-12" style="text-align: center">
                                    <?php echo form_error('id_usuario'); ?>
                                    <?php echo form_error('nombre'); ?>
                                     <?php echo form_error('inv_uc'); ?>
                                  </div>
                          <!-- nombre -->
                          <div class="form-group">
                            <label class="control-label col-lg-2" for="nombre">Nombre del Equipo</label>
                            <div class="col-lg-6">
                              <input type="text" class="form-control" id="nombre" name="nombre" placeholder='Nombre del Equipo'>
                            </div>
                          </div>
                          <!-- inv_uc -->
                          <div class="form-group">
                            <label class="control-label col-lg-2" for="in">Inventario UC</label>
                            <div class="col-lg-6">
                              <input type="text" class="form-control" id="inv_uc" name="inv_uc" placeholder='Inventario UC'>
                            </div>
                          </div>                                                                                                                                         
                          <!-- Marca -->
                          <div class="form-group">
                            <label class="control-label col-lg-2" for="marca">Marca</label>
                            <div class="col-lg-6">
                              <input type="text" class="form-control" id="marca" name="marca" placeholder='Marca'>
                            </div>
                          </div>
                          
                          <!-- SELECT TIPO DE EQUIPO -->
                          <div class="form-group">
                            <label class="col-lg-2 control-label" for="tipo_equip">Tipo de Equipo</label>
                            <div class="col-lg-6">
                              <select id="tipo_equip" name="tipo_equip" class="form-control">
                                    <option value="autoridad" selected>
                                      Split - 8000 BTU
                                    </option>
                                  <option value="asist_autoridad">
                                    Split - 12000 BTU
                                  </option>
                                  
                                  <option value="jefe_alm">
                                    Split - 18000 BTU
                                  </option>
                                  <option value="director_dep">
                                    Split - 24000 BTU
                                  </option>
                                  <option value="ayudante_alm">
                                    5 Toneladas
                                  </option>
                                  
                                <option value="asistente_dep" >
                                  8 Toneladas
                                </option>
                              </select>
                            </div>
                          </div>

                          <!-- Ubicación -->
                          <div class="form-group">
                            <label class="control-label col-lg-2" for="ob">Ubicación</label>
                            <div class="col-lg-6">
                              <textarea rows="3" type="text" class="form-control" id="ob" name="ubicacion"></textarea>
                            </div>
                          </div>
                      <!-- Fin de Formulario -->
                       </div>
                       <div class="modal-footer">
                         <button type="submit" class="btn btn-primary">Agregar</button>
                         <button type="button" class="btn btn-default" data-dismiss="modal" aria-hidden="true"><a href="<?php echo base_url() ?>index.php/inv_equipos/equipos/listar_equipos">Cancelar</a></button>
                       </div>
                      </form>

          <div class="clearfix"></div>
        </div>
      </div>
    </div>
  </div>
</div>
<div class="clearfix"></div>