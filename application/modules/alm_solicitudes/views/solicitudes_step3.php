<div class="mainy">
               <!-- Page title -->
               <div class="page-title">
                  <h2><i class="fa fa-tags color"></i> Articulos <small>Opciones del ultimo paso de la generacion de solicitud</small></h2>
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
              <div class="alert alert-success" style="text-align: center">Solicitud Guardada con éxito</div>
            <?php endif ?>
            <?php if($this->session->flashdata('send_solicitud') == 'error') : ?>
              <div class="alert alert-danger" style="text-align: center">La Solicitud No pudo ser Enviada</div>
            <?php endif ?>
            <div class="row">
              <div class="col-md-10">
                <div class="alert alert-warning" style="text-align: center">
                  Su solicitud debe ser Enviada para poder ser aprobada por Almacen. <br>
                  Puede enviarla o editarla desde las siguientes opciones.
                  <hr/>
                   <div class="row" >
                    <form id="enviar" action="<?php echo base_url() ?>index.php/solicitud/enviar" method="post">
                      <div class="col-md-7">
                        <?php if($enviada != TRUE):?>
                          <input form="enviar" type="hidden" name="id_usuario" value="<?php echo $this->session->userdata('user')['id_usuario']; ?>" />
                          <button type="submit" class="btn btn-success">Enviar</button>
                        <?php else : ?>
                          <button disabled="disabled" class="btn btn-default">Enviar</button>
                        <?php endif ?>
                      </div>
                      <form id="editar" action="<?php echo base_url() ?>index.php/solicitud/editar" method="post">
                      </form>
                      <div class="col-md-2">
                        <a class="btn btn-primary" href="<?php echo base_url() ?>index.php/solicitud/editar/<?php echo $this->session->userdata('nr_solicitud')?>">Editar</a>
                        <!-- <form id="editar" action="<?php echo base_url() ?>index.php/solicitud/editar" method="post">
                          <input form="editar" type="hidden" name="id_dependencia" value="<?php echo $this->session->userdata('user')['id_dependencia']; ?>" />
                          <button form="editar" type="submit" class="btn btn-primary">Editar</button>
                        </form> -->
                      </div>
                    </form>
                   </div>
                   <hr/>
                   <p> &Oacute; desde las opciones en "solicitud actual" en la parte superior de la pagina.</p>
                </div>


            </div>
          </div>
            <div class="clearfix"></div>
            
</div>