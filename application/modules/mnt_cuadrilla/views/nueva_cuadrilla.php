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
       
             <?php if($this->session->flashdata('new_cuadrilla') == 'success') : ?>
              <div class="alert alert-success" style="text-align: center">La cuadrilla ha sido creada exitosamente.</div>
            <?php endif ?>
        <div class="awidget-body">
          <!-- FORMULARIO DE CREACION DE USUARIOS PARA CONTROL DE LA APLICACION -->
          <!-- Formulario -->
                       <form id="newuser"class="form-horizontal" action="<?php echo base_url() ?>index.php/mnt_cuadrilla/cuadrilla/crear_cuadrilla" method="post">
                          <div class="col-lg-12" style="text-align: center">
                                    <?php echo form_error('id_trabajador_responsable'); ?>
                                    <?php echo form_error('cuadrilla'); ?>
                                 
                                  </div>
                          <!-- nombre de la cuadrilla -->
                          <div class="form-group">
                            <label class="control-label col-lg-2" for="nombre">Nombre de la cuadrilla</label>
                            <div class="col-lg-6">
                              <input type="text" class="form-control" id="cuadrilla" name="cuadrilla" placeholder='Nombre de la cuadrilla'>
                            </div>
                          </div>
                                                                                                                                                                 
                          <!-- Cedula del responsable-->
                          <div class="form-group">
                            <label class="control-label col-lg-2" for="id_trabajador_responsable">Cédula del responsable</label>
                            <div class="col-lg-6">
                              <input type="text" class="form-control" id="id_trabajador_responsable" name="id_trabajador_responsable" placeholder='Cédula del responsable'>
                            </div>
                          </div>
                          
                       <!-- Fin de Formulario -->
                       </div>
                       <div class="modal-footer">
                         <button type="submit" class="btn btn-primary">Agregar</button>
                         <input onClick="javascript:window.history.back();" type="button" name="Submit" value="Regresar" class="btn btn-info"></>
                        
                       </div>
                      </form>

          <div class="clearfix"></div>
        </div>
      </div>
    </div>
  </div>
</div>
<div class="clearfix"></div>