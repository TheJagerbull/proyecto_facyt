<script type="text/javascript">
  base_url = '<?=base_url()?>';
</script>
            <div class="mainy">
               <!-- Page title -->
               <div class="page-title">
                  <h2 align="right"><i class="fa fa-inbox color"></i> Solicitudes <small>de almacen</small></h2>
                  <hr />
               </div>
               <!-- Page title -->
               
                 <div class="row">
                  <div class="col-md-9 col-lg-9">
                      <form class="input-group form" action="<?php echo base_url() ?>index.php/administrador/solicitudes" method="post">
                              <div class="col-md-6 col-lg-6">  
                                <div class="form-group">
                                  <label class="col-lg-4 control-label">Opciones</label>
                                    <select name='command' class="form-control" onchange="form.submit();">
                                      <option >...Elija una opcion para mostrar...</option>
                                      <option value="dep" <?php echo (isset($command) && ($command == 'dep')) ? 'selected' : '' ?>>Por departamento</option>
                                      <option value="find_usr" <?php echo (isset($command) && ($command == 'find_usr')) ? 'selected' : '' ?>>Por usuario (Buscar usuario)</option>
                                      <option value="status" <?php echo (isset($command) && ($command == 'status')) ? 'selected' : '' ?>>Por estado de la solicitud</option>
                                    </select>
                                </div>
                              </div>
                              <div class="col-md-5 col-lg-5">
                              <table class="table">
                                  <tr>Fecha <?php echo $solicitudes[0]['fecha_gen'];?></tr>
                                  <tr>
                                    <th>Desde: 
                                      <div id="datetimepicker1" class="input-append">
                                         <input data-format="dd-MM-yyyy hh:mm:ss" name="desde" class="picker" type="text">
                                         <span class="add-on">
                                           &nbsp;<i data-time-icon="fa fa-clock-o" data-date-icon="fa fa-calendar">
                                           </i>
                                         </span>
                                      </div>
                                    </th>
                                    <th>Hasta: 
                                          <div id="datetimepicker2" class="input-append">
                                             <input data-format="dd-MM-yyyy hh:mm:ss" name="hasta" class="picker" type="text" onchange="form.submit();">
                                             <span class="add-on">
                                               &nbsp;<i data-time-icon="fa fa-clock-o" data-date-icon="fa fa-calendar">
                                               </i>
                                             </span>
                                          </div>
                                    </th>
                                  </tr>
                              </table>
                              
                      </form>
                  </div>
                 </div>
                    <?php if(isset($command) && ($command == 'find_usr')):?>
                      <div class="col-lg-8">
                        <form id="ACquery" class="input-group form" action="<?php echo base_url() ?>index.php/administrador/solicitudes/filtrar" method="post">
                          <input id="autocomplete" type="search" name="usuario" class="form-control" placeholder="Cedula... o Nombre... o Apellido...">
                           <span class="input-group-btn">
                              <button type="submit" class="btn btn-info">
                                <i class="fa fa-search"></i>
                              </button>
                           </span>
                        </form>
                      </div>
                    <?php endif ?>
                 <?php if($this->session->flashdata('solicitud_completada') == 'success') : ?>
                    <div class="alert alert-success" style="text-align: center">Solicitud completada con éxito</div>
                  <?php endif ?>
                  <?php if($this->session->flashdata('solicitud_completada') == 'error') : ?>
                    <div class="alert alert-danger" style="text-align: center">Ocurrió un problema con la culminacion de la solicitud</div>
                  <?php endif ?>
                  <div class="row">
                     <div class="col-md-12">

                        <div class="awidget full-width">
                           <div class="awidget-head">
                              <h3>Ultimas solicitudes recibidas</h3>
                           </div>
                           <div class="awidget-body">
                              <?php echo $links; ?>
                              <table class="table table-hover table-bordered ">
                               <thead>
                                 <tr>
                                   <th><a href="<?php echo base_url() ?>index.php/administrador/solicitudes/orden/<?php if($this->uri->segment(3)=='filtrar') echo 'filtrar/'; ?>orden_sol/<?php echo $order ?>/0">Solicitud</a></th>
                                   <th><a href="<?php echo base_url() ?>index.php/administrador/solicitudes/orden/<?php if($this->uri->segment(3)=='filtrar') echo 'filtrar/'; ?>orden_fecha/<?php echo $order ?>/0">Fecha generada</a></th>
                                   <th><a href="<?php echo base_url() ?>index.php/administrador/solicitudes/orden/<?php if($this->uri->segment(3)=='filtrar') echo 'filtrar/'; ?>orden_gen/<?php echo $order ?>/0">Generado por:</a></th>
                                   <th><a href="<?php echo base_url() ?>index.php/administrador/solicitudes/orden/<?php if($this->uri->segment(3)=='filtrar') echo 'filtrar/'; ?>orden_rol/<?php echo $order ?>/0">Rol en sistema</a></th>
                                   <th><a href="<?php echo base_url() ?>index.php/administrador/solicitudes/orden/<?php if($this->uri->segment(3)=='filtrar') echo 'filtrar/'; ?>orden_stad/<?php echo $order ?>/0">Estado de solicitud</a></th>
                                 </tr>
                               </thead>
                               <tbody>

                                <?php foreach ($solicitudes as $key => $solicitud):?>
                                <tr>
                                   <td><a href='#sol<?php echo $solicitud['nr_solicitud'] ?>' data-toggle="modal"><?php echo $solicitud['nr_solicitud']; ?></a></td>
                                   <td><?php echo date("d/m/Y", strtotime($solicitud['fecha_gen'])); ?></td>
                                   <td><a href='#us<?php echo $solicitud['id_usuario'] ?>' data-toggle="modal"><?php echo $solicitud['nombre']." ".$solicitud['apellido']; ?></a></td>
                                    <?php 
                                          switch($solicitud['sys_rol'])
                                          {
                                            case 'autoridad':
                                              echo '<td>Autoridad</td>';
                                            break;
                                            case 'asist_autoridad':
                                              echo '<td>Asistente de autoridad</td>';
                                            break;
                                            case 'jefe_alm':
                                              echo '<td>Jefe de almacen</td>';
                                            break;
                                            case 'director_dep':
                                              echo '<td>Director de departamento</td>';
                                            break;
                                            case 'asistente_dep':
                                              echo '<td>Asistente de departamento</td>';
                                            break;
                                            case 'ayudante_alm':
                                              echo '<td>Ayudante de almacen</td>';
                                            break;
                                          }?>
                                          <?php 
                                          switch($solicitud['status'])
                                          {
                                            case 'carrito':
                                              echo '<td><span class="label label-danger">sin enviar</span></td>';
                                            break;
                                            case 'en_proceso':
                                              echo '<td><span class="label label-warning">En proceso</span></td>';
                                            break;
                                            case 'aprobada':
                                              echo '<td><span class="label label-success">Aprobada</span></td>';
                                            break;
                                            case 'enviado':
                                              echo '<td><span class="label label-warning">Enviado a departamento</span></td>';
                                            break;
                                            case 'completado':
                                              echo '<td><span class="label label-info">Solicitud completada</span></td>';
                                            break;
                                          }?>
                                   
                                   <!--<td><span class="label label-success"> </span></td>-->
                                 </tr>
                               <?php endforeach ?>
                               </tbody>
                             </table>
                              <?php echo $links; ?>
                                <?php foreach ($solicitudes as $key => $solicitud):?>
                                <!-- Modal de articulos -->
                                 <div id="sol<?php echo $solicitud['nr_solicitud'] ?>" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                      <div class="modal-dialog">
                                        <div class="modal-content">
                                          <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">X</button>
                                            <h4 class="modal-title">Numero de solicitud <?php echo $solicitud['nr_solicitud'];?></h4>
                                          </div>
                                          <div class="modal-body">
                                            <!-- Profile form -->
                                            <table id="tblGrid" class="table table-bordered">
                                              <thead>
                                                <tr>
                                                  <th>item</th>
                                                  <th>Descripcion</th>
                                                  <th>Cantidad solicitada</th>
                                                </tr>
                                              </thead>
                                              <tbody>
                                              <?php foreach ($articulos[$solicitud['nr_solicitud']] as $i => $articulo) :?>
                                                <tr>
                                                  <td><?php echo $articulo['id_articulo']?></td>
                                                  <td><?php echo $articulo['descripcion']?></td>
                                                  <td><?php echo $articulo['cant']?></td>
                                                </tr>
                                              <?php endforeach ?>
                                              </tbody>
                                            </table>
                                            <?php if($solicitud['status']=='enviado' || $solicitud['status']=='aprobada') :?>
                                            <form id="completado" action="<?php echo base_url() ?>index.php/solicitud/completar" method="post">
                                              <input form="completado" type="hidden" name="nr_solicitud" value="<?php echo $solicitud['nr_solicitud']; ?>" />
                                              <button form="completado" type="submit" class="btn btn-success">Completado</button>
                                            </form>
                                            <?php endif?>
                                          </div>
                                        </div>
                                      </div>
                                  </div>
                                 <!-- FIN de Modal de articulos -->

                                 <!-- Modal de Usuario -->
                                 <div id="us<?php echo $solicitud['id_usuario'] ?>" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                      <div class="modal-dialog">
                                        <div class="modal-content">
                                          <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">X</button>
                                            <h4 class="modal-title">Perfil del usuario que genero la solicitud</h4>
                                          </div>
                                          <div class="modal-body">
                                            <!-- Profile form -->
                                            <table class="table">
                                               <tr>
                                                  <td><strong>Nombre</strong></td>
                                                  <td>:</td>
                                                  <td><?php echo ucfirst($solicitud['nombre']).' '.ucfirst($solicitud['apellido']) ?></td>
                                               </tr>
                                               <tr>
                                                  <td><strong>Cedula</strong></td>
                                                  <td>:</td>
                                                  <td><?php echo $solicitud['id_usuario'] ?></td>
                                               </tr>
                                               <tr>
                                                  <?php if($solicitud['email']!='') :?>
                                                    <td><strong>Email</strong></td>
                                                    <td>:</td>
                                                    <td><?php echo $solicitud['email'] ?></td>
                                                   <?php endif?>
                                               </tr>
                                               <tr>
                                                  <?php if($solicitud['telefono']) :?>
                                                  <td><strong>Numero</strong></td>
                                                  <td>:</td>
                                                  <td><?php echo $solicitud['telefono'] ?></td>
                                                   <?php endif?>
                                               </tr>
                                               <tr>
                                                  <td><strong>Rol asignado en el sistema</strong></td>
                                                  <td>:</td>
                                                  <?php 
                                                  switch($solicitud['sys_rol'])
                                                  {
                                                    case 'autoridad':
                                                      echo '<td>Autoridad</td>';
                                                    break;
                                                    case 'asist_autoridad':
                                                      echo '<td>Asistente de autoridad</td>';
                                                    break;
                                                    case 'jefe_alm':
                                                      echo '<td>Jefe de almacen</td>';
                                                    break;
                                                    case 'director_dep':
                                                      echo '<td>Director de departamento</td>';
                                                    break;
                                                    case 'asistente_dep':
                                                      echo '<td>Asistente de departamento</td>';
                                                    break;
                                                    case 'ayudante_alm':
                                                      echo '<td>Ayudante de almacen</td>';
                                                    break;
                                                  }?>
                                               </tr>
                                               
                                            </table>
                                          </div>
                                        </div>
                                      </div>
                                  </div>
                                 <!-- FIN de Modal de Usuario -->
                                <?php endforeach ?>
                               <div class="clearfix"></div>
                              
                           </div>
                        </div>
                      </div>
                    </div>
                  </div>
                 