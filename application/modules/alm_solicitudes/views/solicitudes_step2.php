<div class="mainy">
               <!-- Page title -->
               <div class="page-title">
                  <h2><i class="fa fa-tags color"></i> Articulos <small>Indique la cantidad que solicita de cada articulo</small></h2>
                  <hr />
               </div>
               <!-- End Page title -->
               <!--stepwizard -->
               
                      <div class="stepwizard col-md-offset-3">
                        <div class="stepwizard-row setup-panel">
                          <div class="stepwizard-step">
                            <a href="<?php echo base_url() ?>index.php/solicitud/inventario" type="button" class="btn btn-default btn-circle">1</a>
                            <p>Step 1</p>
                          </div>

                          <div class="stepwizard-step">
                            <a href="" type="button" class="btn btn-primary btn-circle">2</a>
                            <p>Step 2</p>
                          </div>

                          <div class="stepwizard-step">
                            <a href="" type="button" class="btn btn-default btn-circle" disabled="disabled">3</a>
                            <p>Step 3</p>
                          </div>
                        </div>
                      </div>
               <!-- end Stepwizard -->
              <div class="row">
                <div class="col-md-12">
                  <!-- <div class="form-control"> -->
                  <div class="alert alert-info">
                      <span class="help-block">Su solicitud no sera guardada para la proxima vez que inicie secion, hasta que no haga clic en guardar</span>
                  </div>
                    <form action="<?php echo base_url() ?>index.php/solicitud/enviar" method="post">
                      <div class="col-md-10 col-sm-10">
                        <div class="col-lg-12" style="text-align: right">
                        </div>
                          <table class="table">
                            <tr>
                              <th>Item</th>
                              <th>Articulo</th>
                              <th>Cantidad</th>
                            </tr>
                            <input type="hidden" name="nr" value="<?php echo $nr; ?>" />
                            <?php echo form_error('nr'); ?>
                    <?php foreach ($articulos as $key => $articulo) :?>
                            <?php echo form_error('qt'.$key); ?>
                            <tr>
                              <td><?php echo $key+1;?> </td>
                              <td><div class="col-md-8"><?php echo $articulo->descripcion ?></div></td>
                              <td>
                                <div class="form-group">
                                    <div class="col-md-4">
                                      <input type="text" class="form-control" name="qt<?php echo $key; ?>">
                                    </div>
                                  </div>
                              </td>
                           </tr>

                            <input type="hidden" name="ID<?php echo $key; ?>" value="<?php echo $articulo->ID ?>" />
                    <?php endforeach?>
                          </table>
                      </div>
                      <div class="form-group">
                        <div class="col-lg-6">
                        <label class="control-label col-lg-2" for="ob">Observacion</label>
                          <textarea rows="3" type="text" class="form-control" id="ob" name="observacion"></textarea>
                        </div>
                      </div>
                      <div class="clearfix"></div>
                      <div class="col-md-10 col-sm-10">
                      <button type="submit" class="btn btn-primary">Guardar</button>
                      </div>
                    </form>
                  <!-- </div> -->
                </div>
              </div>


</div>