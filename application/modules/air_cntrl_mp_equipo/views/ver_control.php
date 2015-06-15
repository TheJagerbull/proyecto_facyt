  <div class="mainy">
               
               <!-- Page title -->
               
                  <div class="row">
                     <div class="col-md-12">
                     
                        <div class="awidget full-width">
                           <div class="awidget-head">
                              <h3>Detalle del Equipo</h3>
                           </div>
                           <div class="awidget-body">
                            <?php if($this->session->flashdata('edit_tipo') == 'success') : ?>
                              <div class="alert alert-success" style="text-align: center">El equipo fue modificado con éxito</div>
                            <?php endif ?>
                            <?php if($this->session->flashdata('edit_tipo') == 'error') : ?>
                              <div class="alert alert-danger" style="text-align: center">Ocurrió un problema con la edición del equipo</div>
                            <?php endif ?>
                              <div class="row">
                                 <div class="col-md-3 col-sm-3">
                                    <a href="profile.html#"></a>
                                 </div>
                                 <div class="col-md-9 col-sm-9">
                                  <div class="col-lg-12" style="text-align: center">
                                  </div>
                                    <table class="table">
                                    
                                       <tr>
                                          <td><strong>Codigo</strong></td>
                                          <td>:</td>
                                          <td><?php echo $tipo->cod ?></td>
                                       </tr>
                                       <tr>
                                          <td><strong>Descripcion</strong></td>
                                          <td>:</td>
                                          <td><?php echo ucfirst($tipo->desc) ?></td>
                                       </tr>
                                       
                                       
                                                                                                                  
                                    </table>
                                 </div>
                              </div>
                           </div>
                        </div>
                        
                        


                                <!-- Button to trigger modal -->
                                 <?php if(isset($edit) && $edit && isset($tipo)) : ?>
                                  <a href="#modificar" class="btn btn-info" data-toggle="modal">Modificar Equipo</a>
                                 <?php endif ?>
                                <!-- Modal -->
                                <a href="<?php echo base_url() ?>index.php/air_tipoeq/tipoeq/index" class="btn btn-info">Regresar</a>
                                <div id="modificar" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="modificacion" aria-hidden="true">
                                     <div class="modal-dialog">
                                       <div class="modal-content">
                                           <div class="modal-header">
                                             <button type="button" class="close" data-dismiss="modal" aria-hidden="true">X</button>
                                             <h4 class="modal-title">Modificar</h4>
                                           </div>
                                           <div class="modal-body">
                                            
                                                <!-- Edit profile form (not working)-->
                                                <form class="form-horizontal" action="<?php echo base_url() ?>index.php/tipoeq/modificar" method="post">
                                                        <?php echo form_error('cod'); ?>
                                                        <?php echo form_error('desc'); ?>
                                                    <!-- codigo del tipo -->
                                                    <div class="form-group">
                                                      <label class="control-label col-lg-2" for="cod">Codigo</label>
                                                      <div class="col-lg-6">
                                                        <input type="text" class="form-control" id="cod" name="cod" value='<?php echo ucfirst($tipo->cod)?>'>
                                                      </div>
                                                    </div>
                                                    <!-- nombre del tipo -->
                                                    <div class="form-group">
                                                      <label class="control-label col-lg-2" for="desc">Descripcion</label>
                                                      <div class="col-lg-6">
                                                        <input type="text" class="form-control" id="desc" name="desc" value='<?php echo ucfirst($tipo->desc)?>'>
                                                      </div>
                                                    </div>                                                                                                                                         
                                                    
                                                    
                                                    <?php if(isset($edit) && $edit && isset($tipo)) : ?>
                                                      <input type="hidden" name="id" value="<?php echo $tipo->id ?>" />
                                                    <?php endif ?>

                                                   <div class="modal-footer">
                                                     <button type="submit" class="btn btn-primary">Guardar cambios</button>
                                                     <button type="button" class="btn btn-default" data-dismiss="modal" aria-hidden="true">Cancelar</button>
     
                                                   </div>
                                                   
                                                </form>
                                              </div>
                                           </div>
                                     </div>
                                 </div>
                                <hr />

                                </div>
                      </div>
                  
            </div>
            
            <div class="clearfix"></div>
            
         </div>
      </div>          