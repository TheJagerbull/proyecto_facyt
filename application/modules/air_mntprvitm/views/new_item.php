    <!-- Page content -->
<div class="mainy">
  <!-- Page title -->
  <div class="page-title">
    <h2><i class="fa fa-user color"></i> Agregar<small> Item Mantenimiento Preventivo</small></h2> 
    <hr />
  </div>
  <!-- Page title -->
  <div class="row">
    <div class="col-md-12">
      <div class="awidget full-width">
        <?php if($this->session->flashdata('create_item') == 'error') : ?>
              <div class="alert alert-danger" style="text-align: center">Ocurrió un problema con la Creacion del Item</div>
            <?php endif ?>
            <?php if($this->session->flashdata('create_item') == 'success') : ?>
              <div class="alert alert-success" style="text-align: center">Item Creado con éxito</div>
            <?php endif ?>
                            
        <div class="awidget-body">
          
          <!-- Formulario -->
                       <form id="newuser"class="form-horizontal" action="<?php echo base_url() ?>index.php/itemmp/crear" method="post">
                          <div class="col-lg-12" style="text-align: center">
                                    <?php echo form_error('cod'); ?>
                                    <?php echo form_error('desc'); ?>
                                    
                                  </div>
                          <!-- codigo -->
                          <div class="form-group">
                            <label class="control-label col-lg-2" for="cod">C&oacute;digo: </label>
                            <div class="col-lg-6">
                              <input type="text" class="form-control" id="cod" name="cod" placeholder='Codigo' value="">
                            </div>
                          </div>
                          <!-- descripcion -->
                          <div class="form-group">
                            <label class="control-label col-lg-2" for="desc">Descripci&oacute;n</label>
                            <div class="col-lg-6">
                              <input type="text" class="form-control" id="desc" name="desc" placeholder='Descripcion' value="">
                            </div>
                          </div>  
                                                                                                                                                             
                      <!-- Fin de Formulario -->
                       </div>
                       <div class="modal-footer">
                         <button type="submit" class="btn btn-primary">Crear</button>
                         <a href="<?php echo base_url() ?>index.php/air_mntprvitm/itemmp/index" class="btn btn-default">Cancelar</a>
                       </div>
                      </form>

          <div class="clearfix"></div>
        </div>
      </div>
    </div>
  </div>
</div>
<div class="clearfix"></div>