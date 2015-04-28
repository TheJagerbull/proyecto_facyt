  <div class="mainy">
               
               <!-- Page title -->
               
                  <div class="row">
                     <div class="col-md-12">
                     
                        <div class="awidget full-width">
                           <div class="awidget-head">
                              <h3>Equipo</h3>
                           </div>
                           <div class="awidget-body">
                            <?php if($this->session->flashdata('edit_equipo') == 'success') : ?>
                              <div class="alert alert-success" style="text-align: center">Equipo modificado con éxito</div>
                            <?php endif ?>
                            <?php if($this->session->flashdata('edit_equipo') == 'error') : ?>
                              <div class="alert alert-danger" style="text-align: center">Ocurrió un problema con la edición del Equipo</div>
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
                                          <td><?php echo $equipo->id ?></td>
                                       </tr>
                                       <tr>
                                          <td><strong>Descripcion</strong></td>
                                          <td>:</td>
                                          <td><?php echo ucfirst($equipo->desc) ?></td>
                                       </tr>
                                       
                                       
                                                                                                                  
                                    </table>
                                 </div>
                              </div>
                           </div>
                        </div>
                        
                        


                                <!-- Button to trigger modal -->
                                 <?php if(isset($edit) && $edit && isset($equipo)) : ?>
                                  <a href="#modificar" class="btn btn-info" data-toggle="modal">Modificar Equipo</a>
                                 <?php endif ?>
                                <!-- Modal -->
                                <div id="modificar" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="modificacion" aria-hidden="true">
                                     <div class="modal-dialog">
                                       <div class="modal-content">
                                           <div class="modal-header">
                                             <button type="button" class="close" data-dismiss="modal" aria-hidden="true">X</button>
                                             <h4 class="modal-title">Modificar</h4>
                                           </div>
                                           <div class="modal-body">
                                            
                                                <!-- Edit profile form (not working)-->
                                                <form class="form-horizontal" action="<?php echo base_url() ?>index.php/air_equipos/equipo/modificar_equipo" method="post">
                                                        <?php echo form_error('id'); ?>
                                                        <?php echo form_error('desc'); ?>
                                                    <!-- codigo del equipo -->
                                                    <div class="form-group">
                                                      <label class="control-label col-lg-2" for="id">Codigo</label>
                                                      <div class="col-lg-6">
                                                        <input type="text" class="form-control" id="id" name="id" value='<?php echo ucfirst($equipo->id)?>'>
                                                      </div>
                                                    </div>
                                                    <!-- nombre del equipo -->
                                                    <div class="form-group">
                                                      <label class="control-label col-lg-2" for="desc">Descripcion</label>
                                                      <div class="col-lg-6">
                                                        <input type="text" class="form-control" id="desc" name="desc" value='<?php echo ucfirst($equipo->desc)?>'>
                                                      </div>
                                                    </div>                                                                                                                                         
                                                    
                                                    
                                                    <?php if(isset($edit) && $edit && isset($equipo)) : ?>
                                                      <input type="hidden" name="ID" value="<?php echo $equipo->ID ?>" />
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