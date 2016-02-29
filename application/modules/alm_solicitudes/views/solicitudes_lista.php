            <div class="mainy">
               <!-- Page title -->
               <div class="page-title">
                  <h2 align="right"><i class="fa fa-inbox color"></i>Consulta <small>de  solicitudes</small></h2>
                  <hr />
               </div>
               <!-- Page title -->
               
                 <div class="row">
                  <div class="col-md-12">
                    <div class="alert alert-success" style="text-align: center">
                      <p> Recuerde que para las solicitudes aprobadas, debe ir a almacen a retirar los art&iacute;culos</p>
                    </div>
                  </div>
                 </div>
                  <?php if(empty($solicitudes)):?>
                    <div class="row">
                      <div class="col-md-12">
                        <div class="alert alert-warning" style="text-align: center">
                          <p> Actualmente No hay Solicitudes en su departamento</p>
                        </div>
                      </div>
                   </div>
                  <?php endif?>
                 <?php if($this->session->flashdata('solicitud_completada') == 'success') : ?>
                    <div class="alert alert-success" style="text-align: center">Solicitud completada con éxito</div>
                  <?php endif ?>
                  <?php if($this->session->flashdata('solicitud_completada') == 'error') : ?>
                    <div class="alert alert-danger" style="text-align: center">Ocurrió un problema con la Culminacion de la solicitud</div>
                  <?php endif ?>
                  <?php if($this->session->flashdata('saved') == 'success') : ?>
                    <div class="alert alert-success" style="text-align: center">Solicitud guardada con éxito</div>
                  <?php endif ?>
                  <div class="row">
                     <div class="col-md-12">

                        <div class="awidget full-width">
                           <div class="awidget-head">
                              <h3>Solicitudes del Departamento</h3>
                           </div>
                           <div class="awidget-body">
                              
                              <table class="table table-hover table-bordered ">
                               <thead>
                                 <tr>
                                   <th>Solicitud</th>
                                   <th>Fecha Generada</th>
                                   <th>Generado por:</th>
                                   <th>Rol en Sistema</th>
                                   <th>Estado de Solicitud</th>
                                 </tr>
                               </thead>
                               <tbody><!-- 
                                 <tr>
                                   <form method="post" action="<?php echo base_url() ?>index.php/alm_solicitudes/alm_solicitudes/generar" />
                                          <td align="center" colspan="7">
                                                 
                                                   <input type="submit" value="Crear PDF" title="Crear PDF" />
                                          </td>
                                    </form>
                                  </tr> -->
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
                                              echo '<td>Asistente de Autoridad</td>';
                                            break;
                                            case 'jefe_alm':
                                              echo '<td>Jefe de Almacen</td>';
                                            break;
                                            case 'director_dep':
                                              echo '<td>Director de dependencia</td>';
                                            break;
                                            case 'asistente_dep':
                                              echo '<td>Asistente de dependencia</td>';
                                            break;
                                            case 'ayudante_alm':
                                              echo '<td>Ayudante de Almacen</td>';
                                            break;
                                          }?>
                                          <?php 
                                          switch($solicitud['status'])
                                          {
                                            case 'carrito':
                                              echo '<td><span class="label label-danger">sin enviar</span></td>';
                                            break;
                                            case 'en_proceso':
                                              echo '<td><span class="label label-warning">En Proceso</span></td>';
                                            break;
                                            case 'aprobada':
                                              echo '<td><span class="label label-success">Aprobada</span></td>';
                                            break;
                                            case 'enviado':
                                              echo '<td><span class="label label-warning">Enviado a Departamento</span></td>';
                                            break;
                                            case 'completado':
                                              echo '<td><span class="label label-info">Solicitud Completada</span></td>';
                                            break;
                                          }?>
                                   
                                   <!--<td><span class="label label-success"> </span></td>-->
                                 </tr>
                               <?php endforeach ?>
                               </tbody>
                             </table>
                            <div class="clearfix"></div>
                              
                           </div>
                        </div>
                        <div class="awidget full-width">
                           <div class="awidget-head">
                              <h3>Solicitudes <span class="label label-danger">sin enviar</span></h3>
                           </div>
                           <div class="awidget-body">
                             <table class="table table-hover table-bordered ">
                               <thead>
                                 <tr>
                                   <th># Control</th>
                                   <th>Fecha Generada</th>
                                   <th>Generado por:</th>
                                   <th>Rol en Sistema</th>
                                   <!-- <th>Estado de Solicitud</th> -->
                                 </tr>
                               </thead>
                               <tbody>
                                <?php foreach ($carritos as $key => $carrito):?>
                                  <tr>
                                    <td><a href='#cart<?php echo $carrito['id_carrito'] ?>' data-toggle="modal"><?php echo $carrito['id_carrito']; ?></a></td>
                                    <td><?php echo date("d/m/Y", strtotime($carrito['fecha_gen'])); ?></td>
                                    <td><a href='#us<?php echo $carrito['id_usuario'] ?>' data-toggle="modal"><?php echo $carrito['nombre']." ".$carrito['apellido']; ?></a></td>
                                      <?php 
                                            switch($carrito['sys_rol'])
                                            {
                                              case 'autoridad':
                                                echo '<td>Autoridad</td>';
                                              break;
                                              case 'asist_autoridad':
                                                echo '<td>Asistente de Autoridad</td>';
                                              break;
                                              case 'jefe_alm':
                                                echo '<td>Jefe de Almacen</td>';
                                              break;
                                              case 'director_dep':
                                                echo '<td>Director de dependencia</td>';
                                              break;
                                              case 'asistente_dep':
                                                echo '<td>Asistente de dependencia</td>';
                                              break;
                                              case 'ayudante_alm':
                                                echo '<td>Ayudante de Almacen</td>';
                                              break;
                                            }
                                      ?>
                                    <!-- <td><span class="label label-danger">sin enviar</span></td> -->
                                   
                                   <!--<td><span class="label label-success"> </span></td>-->
                                  </tr>
                               <?php endforeach ?>
                               </tbody>
                             </table>
                                <!-- Modal de articulos de solicitudes -->
                                <?php foreach ($solicitudes as $key => $solicitud):?>
                                 <div id="sol<?php echo $solicitud['nr_solicitud'] ?>" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                      <div class="modal-dialog">
                                        <div class="modal-content">
                                          <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">X</button>
                                            <h4 class="modal-title">Numero de Solicitud <?php echo $solicitud['nr_solicitud'];?></h4>
                                          </div>
                                          <div class="modal-body">
                                            <!-- Profile form -->
                                            <table id="tblGrid" class="table table-bordered">
                                              <thead>
                                                <tr>
                                                  <th>item</th>
                                                  <th>Descripcion</th>
                                                  <th>Cantidad Solicitada</th>
                                                  <?php if($solicitud['status']=='aprobada'):?>
                                                    <th>Cantidad aprobada</th>
                                                  <?php endif;?>
                                                </tr>
                                              </thead>
                                              <tbody>
                                              <?php foreach ($articulosSol[$solicitud['nr_solicitud']] as $i => $articulo) :?>
                                                <tr>
                                                  <td><?php echo $articulo['id_articulo']?></td>
                                                  <td><?php echo $articulo['descripcion']?></td>
                                                  <td><?php echo $articulo['cant']?></td>
                                                  <?php if($solicitud['status']=='aprobada'):?>
                                                    <td><?php echo $articulo['cant_aprob']?></td>
                                                  <?php endif;?>
                                                </tr>
                                              <?php endforeach ?>
                                              </tbody>
                                            </table>
                                <!-- Observacion de la solicitud -->
                                            <?php if(isset($solicitud['observacion']) && !empty($solicitud['observacion'])):?>
                                                <label class="control-label col-lg-2 col-md-2 col-sm-2" for="observacion">Nota: </label>
                                                <div class="col-lg-4 col-md-4 col-sm-4" align="left"><?php echo $solicitud['observacion'];?></div>
                                                <br>
                                                <br>
                                                <hr>
                                            <?php endif;?>
                                            <!--<?php if($solicitud['status']=='carrito') :?>
                                            <form id="enviar" action="<?php echo base_url() ?>index.php/solicitud/enviar" method="post">
                                              <input form="enviar" type="hidden" name="nr_solicitud" value="<?php echo $solicitud['nr_solicitud']; ?>" />
                                              <input form="enviar" type="hidden" name="url" value="<?php echo $this->uri->uri_string(); ?>" />
                                              <input form="enviar" type="hidden" name="id_usuario" value="<?php echo $this->session->userdata('user')['id_usuario']; ?>" />
                                              <button form="enviar" type="submit" class="btn btn-success">Enviar</button>
                                            </form>
                                              <a class="btn btn-primary" href="<?php echo base_url() ?>index.php/solicitud/editar/<?php echo $solicitud['nr_solicitud'];?>">Editar</a>
                                            <?php endif?>-->
                                            <?php if($solicitud['status']=='enviado' || $solicitud['status']=='aprobada') :?>
                                            <form id="completado" action="<?php echo base_url() ?>index.php/solicitud/completar" method="post">
                                              <input form="completado" type="hidden" name="nr_solicitud" value="<?php echo $solicitud['nr_solicitud']; ?>" />
                                              <input form="completado" type="hidden" name="url" value="<?php echo $this->uri->uri_string(); ?>" />
                                              <!-- <button form="completado" type="submit" class="btn btn-success">Completado</button> -->
                                            </form>
                                            <?php endif?>
                                          </div>
                                        </div>
                                      </div>
                                  </div>                                
                                <?php endforeach ?>
                                 <!-- FIN de Modal de articulos de solicitudes --> 

                                 <!-- Modal de articulos de carritos -->
                                 <?php foreach ($carritos as $key => $carrito):?>
                                 <div id="cart<?php echo $carrito['id_carrito'] ?>" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                      <div class="modal-dialog">
                                        <div class="modal-content">
                                          <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">X</button>
                                            <h4 class="modal-title">Articulos en solicitud </h4>
                                          </div>
                                          <div class="modal-body">
                                            <!-- Profile form -->
                                            <table id="tblGrid" class="table table-bordered">
                                              <thead>
                                                <tr>
                                                  <th>item</th>
                                                  <th>Descripcion</th>
                                                  <th>Cantidad Solicitada</th>
                                                </tr>
                                              </thead>
                                              <tbody>
                                              <?php foreach ($articulosCart[$carrito['id_carrito']] as $i => $articulo) :?>
                                                <tr>
                                                  <td><?php echo $articulo['id_articulo']?></td>
                                                  <td><?php echo $articulo['descripcion']?></td>
                                                  <td><?php echo $articulo['cant']?></td>
                                                </tr>
                                              <?php endforeach ?>
                                              </tbody>
                                            </table>
                                <!-- Observacion de la solicitud -->
                                            <?php if(isset($carrito['observacion']) && !empty($carrito['observacion'])):?>
                                                <label class="control-label col-lg-2 col-md-2 col-sm-2" for="observacion">Nota: </label>
                                                <div class="col-lg-4 col-md-4 col-sm-4" align="left"><?php echo $carrito['observacion'];?></div>
                                                <br>
                                                <br>
                                                <hr>
                                            <?php endif;?>
                                            <div class="modal-footer">
                                            <form id="enviar" action="<?php echo base_url() ?>index.php/solicitud/enviar" method="post">
                                              <input form="enviar" type="hidden" name="id_carrito" value="<?php echo $carrito['id_carrito']; ?>" />
                                              <input form="enviar" type="hidden" name="url" value="<?php echo $this->uri->uri_string(); ?>" />
                                              <input form="enviar" type="hidden" name="id_usuario" value="<?php echo $this->session->userdata('user')['id_usuario']; ?>" />
                                              <button form="enviar" type="submit" class="btn btn-success">Enviar</button>
                                            </form>
                                              <a class="btn btn-primary" href="<?php echo base_url() ?>index.php/solicitud/editar/<?php echo $carrito['id_carrito'];?>">Editar</a>
                                            </div>
                                          </div>
                                        </div>
                                      </div>
                                  </div>
                                 <?php endforeach; ?>
                                 <!-- FIN de Modal de articulos de carritos -->

                                  <!-- Modal de Usuario -->
                                <?php foreach ($usuarios as $key => $usuario):?>
                                 <div id="us<?php echo $usuario['id_usuario'] ?>" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                      <div class="modal-dialog">
                                        <div class="modal-content">
                                          <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">X</button>
                                            <h4 class="modal-title">Perfil del Usuario que genero la solicitud</h4>
                                          </div>
                                          <div class="modal-body">
                                            <!-- Profile form -->
                                            <table class="table">
                                               <tr>
                                                  <td><strong>Nombre y Apellido</strong></td>
                                                  <td>:</td>
                                                  <td><?php echo ucfirst($usuario['nombre']).' '.ucfirst($usuario['apellido']) ?></td>
                                               </tr>
                                               <tr>
                                                  <td><strong>Cedula de Identidad</strong></td>
                                                  <td>:</td>
                                                  <td><?php echo $usuario['id_usuario'] ?></td>
                                               </tr>
                                               <tr>
                                                  <?php if($usuario['email']!='') :?>
                                                    <td><strong>Email</strong></td>
                                                    <td>:</td>
                                                    <td><?php echo $usuario['email'] ?></td>
                                                   <?php endif?>
                                               </tr>
                                               <tr>
                                                  <?php if($usuario['telefono']) :?>
                                                  <td><strong>Numero de Telefono</strong></td>
                                                  <td>:</td>
                                                  <td><?php echo $usuario['telefono'] ?></td>
                                                   <?php endif?>
                                               </tr>
                                               <tr>
                                                  <td><strong>Rol Asignado en el Sistema</strong></td>
                                                  <td>:</td>
                                                  <?php 
                                                  switch($usuario['sys_rol'])
                                                  {
                                                    case 'autoridad':
                                                      echo '<td>Autoridad</td>';
                                                    break;
                                                    case 'asist_autoridad':
                                                      echo '<td>Asistente de Autoridad</td>';
                                                    break;
                                                    case 'jefe_alm':
                                                      echo '<td>Jefe de Almacen</td>';
                                                    break;
                                                    case 'director_dep':
                                                      echo '<td>Director de dependencia</td>';
                                                    break;
                                                    case 'asistente_dep':
                                                      echo '<td>Asistente de dependencia</td>';
                                                    break;
                                                    case 'ayudante_alm':
                                                      echo '<td>Ayudante de Almacen</td>';
                                                    break;
                                                  }?>
                                               </tr>

                                            </table>
                                          </div>
                                        </div>
                                      </div>
                                  </div>
                                <?php endforeach;?>
                                 <!-- FIN de Modal de Usuario -->
                               <div class="clearfix"></div>
                              
                           </div>
                        </div>
                      </div>
                    </div>
                  </div>