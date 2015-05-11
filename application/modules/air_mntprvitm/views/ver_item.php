  <div class="mainy">
               
               <!-- Page title -->
               
                  <div class="row">
                     <div class="col-md-12">
                     
                        <div class="awidget full-width">
                           <div class="awidget-head">
                              <h3>Detalle del Item</h3>
                           </div>
                           <div class="awidget-body">
                            <?php if($this->session->flashdata('edit_item') == 'success') : ?>
                              <div class="alert alert-success" style="text-align: center">Item modificado con éxito</div>
                            <?php endif ?>
                            <?php if($this->session->flashdata('edit_item') == 'error') : ?>
                              <div class="alert alert-danger" style="text-align: center">Ocurrió un problema con la edición del Item</div>
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
                                          <td><?php echo $item->cod ?></td>
                                       </tr>
                                       <tr>
                                          <td><strong>Descripcion</strong></td>
                                          <td>:</td>
                                          <td><?php echo ucfirst($item->desc) ?></td>
                                       </tr>
                                       
                                       
                                                                                                                  
                                    </table>
                                 </div>
                              </div>
                           </div>
                        </div>
                        
                        


                                <!-- Button to trigger modal -->
                                 <?php if(isset($edit) && $edit && isset($item)) : ?>
                                  <a href="<?php echo base_url() ?>index.php/itemmp/modificar/$item->id" class="btn btn-info" data-toggle="modal">Modificar Item</a>
                                 <?php endif ?>
                                <!-- Modal -->
                                <a href="<?php echo base_url() ?>index.php/air_mntprvitm/itemmp/index" class="btn btn-info">Regresar</a>
                                
                                <hr />

                                </div>
                      </div>
                  
            </div>
            
            <div class="clearfix"></div>
            
         </div>
      </div>          