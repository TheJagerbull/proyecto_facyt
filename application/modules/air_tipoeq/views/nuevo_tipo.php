  <!-- Page content -->
<div class="mainy">
  <!-- Page title -->
  <div class="page-title">
    <h2><i class="fa fa-desktop color"></i> Agregar<small> Aguegue un equipo</small></h2> 
    <hr />
  </div>
  <!-- Page title -->
  <div class="row">
    <div class="col-md-12">
      <div class="awidget full-width">
        <?php if($this->session->flashdata('create_tipo') == 'error') : ?>
              <div class="alert alert-danger" style="text-align: center">Ocurrió un problema con la Creacion del tipo</div>
            <?php endif ?>
            
            
        <div class="awidget-body">
          <!-- FORMULARIO DE CREACION DE USUARIOS PARA CONTROL DE LA APLICACION -->
          <!-- Formulario -->
                       <form class="form-horizontal" action="<?php echo base_url() ?>index.php/air_tipoeq/tipoeq/nuevo_tipo" method="post">
                          <div class="col-lg-12" style="text-align: center">
                                    <?php echo form_error('cod'); ?>
                                    <?php echo form_error('desc'); ?>
                                    </div>
                          <!-- codigo -->
                          <div class="form-group">
                            <label class="control-label col-lg-2" for="cod">Codigo</label>
                            <div class="col-lg-6">
                              <input type="text" class="form-control" id="cod" name="cod" placeholder='Codigo'>
                            </div>
                          </div>
                          <!-- descripcion -->
                          <div class="form-group">
                            <label class="control-label col-lg-2" for="desc">Descripcion</label>
                            <div class="col-lg-6">
                              <input type="text" class="form-control" id="desc" name="desc" placeholder='Descripcion'>
                            </div>
                          </div>                                                                                                                                         
                          
                      <!-- Fin de Formulario -->
                       
                       <div class="modal-footer">
                         <button type="submit" class="btn btn-primary">Agregar</button>
                         <a href="<?php echo base_url() ?>index.php/air_tipoeq/tipoeq/index" class="btn btn-default">Cancelar</a>
                       </div> 
                      </form>

          <div class="clearfix"></div>
        </div>
      </div>
    </div>
  </div>
</div>
<div class="clearfix"></div>