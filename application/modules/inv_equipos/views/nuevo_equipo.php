    <!-- Page content -->
<div class="mainy">
  <!-- Page title -->
  <div class="page-title">
    <h2><i class="fa fa-user color"></i> Nuevo<small> Equipo</small></h2> 
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
                       <form id="newuser" class="form-horizontal" action="<?php echo base_url() ?>index.php/inv_equipos/equipos/nuevo_equipo" method="post">
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

                        <!-- Modelo -->
                          <div class="form-group">
                            <label class="control-label col-lg-2" for="marca">Modelo</label>
                            <div class="col-lg-6">
                              <input type="text" class="form-control" id="modelo" name="modelo" placeholder='Modelo'>
                            </div>
                          </div>
                          
                          <!-- SELECT TIPO DE EQUIPO -->
                         
                        <div class="form-group">
                            <label class="control-label col-lg-2" for = "tipo_eq">TipoEquipo:</label>
                                <div class="col-lg-4"> 
                                    <select class="form-control" id = "tipo_eq" name="tipo_eq">
                                        <option value="">--SELECCIONE--</option>
                                            <?php foreach ($tipoeqs as $eq): ?>
                                        <option value = "<?php echo $eq->id; ?>"><?php echo $eq->desc; ?></option>
                                            <?php endforeach; ?>
                                    </select>
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