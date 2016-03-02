<div class="mainy">
               <!-- Page title -->
               <div class="page-title">
                  <h2 align="right"><i class="fa fa-tags color"></i>Opciones de Solicitud<small>guardada</small></h2>
                  <hr />
               </div>
               <!-- End Page title -->
               <!--stepwizard -->
               
                      <div class="stepwizard col-md-offset-3">
                        <div class="stepwizard-row setup-panel">
                          <div class="stepwizard-step">
                            <a href="<?php echo base_url() ?>index.php/solicitud/inventario" type="button" class="btn btn-default btn-circle">1</a>
                            <p>Paso 1</p>
                          </div>
                          <div class="stepwizard-step">
                            <a href="" type="button" class="btn btn-default btn-circle" disabled="disabled">2</a>
                            <p>Paso 2</p>
                          </div>
                          <div class="stepwizard-step">
                            <a href="<?php echo base_url() ?>index.php/solicitud/enviar" type="button" class="btn btn-primary btn-circle">3</a>
                            <p>Paso 3</p>
                          </div>
                        </div>
                      </div>
               <!-- end Stepwizard -->
            <?php if($this->session->flashdata('create_solicitud') == 'success') : ?>
              <div class="alert alert-success" style="text-align: center">Solicitud guardada con éxito</div>
            <?php endif ?>
            <?php if($this->session->flashdata('send_solicitud') == 'error') : ?>
              <div class="alert alert-danger" style="text-align: center">La solicitud no pudo ser enviada. <br> (Solo el creador de la solicitud la puede enviar). </div>
            <?php endif ?>
            <?php if($this->session->flashdata('send_solicitud') == 'success') : ?>
              <div class="alert alert-success" style="text-align: center">Solicitud enviada exitosamente</div>
            <?php endif ?>
            <div class="row">
              <div class="col-md-10">
                <?php if($enviada != TRUE && $this->session->flashdata('send_solicitud') != 'success'):?>
                  <div class="alert alert-warning" style="text-align: center">
                    Su solicitud debe ser enviada para poder ser aprobada por almacen. <br>
                    Puede enviarla o editarla desde las siguientes opciones.
                    <hr/>
                     <div class="row" >
                      <form id="enviar" action="<?php echo base_url() ?>index.php/solicitud/enviar" method="post">
                      </form>
                        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                            <input form="enviar" type="hidden" name="id_usuario" value="<?php echo $this->session->userdata('user')['id_usuario']; ?>" />
                            <input form="enviar" type="hidden" name="url" value="<?php echo $this->uri->uri_string(); ?>" />
                            <button form="enviar" type="submit" class="btn btn-success">Enviar</button>
                        </div>
                        <form id="cancel" action="<?php echo base_url() ?>index.php/solicitud/cancelar" method="post">
                        </form>
                          <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3">
                              <input form="cancel" type="hidden" name="id_usuario" value="<?php echo $this->session->userdata('user')['id_usuario']; ?>" />
                              <input form="cancel" type="hidden" name="id_carrito" value="<?php echo $this->session->userdata('id_carrito')?>" />
                              <input form="cancel" type="hidden" name="uri" value="<?php echo base_url() ?>index.php/solicitud/inventario" />
                              <!-- <button form ="cancel" type="submit" class="btn btn-danger">Cancelar</button> -->
                          </div>
                        <form id="editar" action="<?php echo base_url() ?>index.php/solicitud/editar" method="post">
                        </form>
                        <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3">
                            <a class="btn btn-primary" href="<?php echo base_url() ?>index.php/solicitud/editar/<?php echo $this->session->userdata('id_carrito')?>">Editar</a>
                          <!-- <form id="editar" action="<?php echo base_url() ?>index.php/solicitud/editar" method="post">
                            <input form="editar" type="hidden" name="id_dependencia" value="<?php echo $this->session->userdata('user')['id_dependencia']; ?>" />
                            <button form="editar" type="submit" class="btn btn-primary">Editar</button>
                          </form> -->
                        </div>
                     </div>
                     <hr/>
                     <p> &Oacute; desde las opciones en "solicitud actual" en la parte superior de la pagina.</p>
                  </div>
                <?php else:?>
                <?php if($this->session->flashdata('Cart') == 'true'):?>
                <div class="alert alert-info" style="text-align: center">
                    Usted ya posee una solicitud sin enviar
                </div>  
                <?php endif;?>
                <div class="alert alert-warning" style="text-align: center">
                  Disculpe, actualmente usted no posee permisos para enviar la solicitud
                  <hr>
                  <a class="btn btn-primary" href="<?php echo base_url() ?>index.php/solicitud/editar/<?php echo $this->session->userdata('id_carrito')?>">Editar</a>
                </div>
                <?php endif?>


            </div>
          </div>
            <div class="clearfix"></div>
            
</div>