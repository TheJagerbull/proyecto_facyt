<div class="mainy">
               <!-- Page title -->
               <div class="page-title">
                  <h2><i class="fa fa-tags color"></i> Articulos <small>Seleccione el articulo para detalles, y/o para agregar a solicitud</small></h2>
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
                            <a href="" type="button" class="btn btn-default btn-circle" disabled="disabled">2</a>
                            <p>Step 2</p>
                          </div>
                          <div class="stepwizard-step">
                            <a href="<?php echo base_url() ?>index.php/solicitud/enviar" type="button" class="btn btn-primary btn-circle">3</a>
                            <p>Step 3</p>
                          </div>
                        </div>
                      </div>
               <!-- end Stepwizard -->      
            <?php if($this->session->flashdata('create_solicitud') == 'success') : ?>
              <div class="alert alert-success" style="text-align: center">Solicitud Guardada con éxito</div>
            <?php endif ?>
            <div class="row">
              <div class="col-md-10">
                <div class="alert alert-warning">
                  Su solicitud esta guardada, pero debe ser Enviada para poder ser aprobada por Almacen
                  <hr/>
                   <div class="btn-group">

                      <button class="btn btn-success">Enviar</button>
                      <a class="btn btn-primary">Editar</a>
                    </div>
                </div>


            </div>
            <div class="clearfix"></div>
            
</div>