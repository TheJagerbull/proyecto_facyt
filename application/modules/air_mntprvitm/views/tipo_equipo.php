    <!-- Page content -->
<div class="mainy">
  <!-- Page title -->
  <div class="page-title">
    <h2><i class="fa fa-user color"></i> Tipo<small> de Equipo</small></h2> 
    <hr />
  </div>
  <!-- Page title -->
  <div class="row">
    <div class="col-md-12">
      <div class="awidget full-width">
        <?php if($this->session->flashdata('create_equipo') == 'error') : ?>
              <div class="alert alert-danger" style="text-align: center">Ocurrió un problema agregando el Equipo</div>
            <?php endif ?>
        <div class="awidget-body">
          <!-- FORMULARIO DE CREACION DE USUARIOS PARA CONTROL DE LA APLICACION -->
          <!-- Formulario -->
                       <form id="newuser"class="form-horizontal" action="<?php echo base_url() ?>air_equipos/equipo/tipo_equipo" method="post">
                          <div class="col-lg-12" style="text-align: center">
                                <?php echo form_error('id'); ?>
                                <?php echo form_error('desc'); ?>
                          </div>
                          <!-- codigo de equipo-->
                          <div class="form-group">
                            <label class="control-label col-lg-2" for="id">Codigo del Equipo</label>
                            <div class="col-lg-6">
                              <input type="text" class="form-control" id="id" name="id" placeholder='Codigo'>
                            </div>
                          </div>
                          <!-- nombre del equipo-->
                          <div class="form-group">
                            <label class="control-label col-lg-2" for="desc">Nombre del Equipo</label>
                            <div class="col-lg-6">
                              <input type="text" class="form-control" id="desc" name="desc" placeholder='Descripcion'>
                            </div>
                          </div>
                                     
                                                    
                      <!-- Fin de Formulario -->
                       </div>
                       <div class="modal-footer">
                         <button type="submit" class="btn btn-primary">Agregar</button>
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