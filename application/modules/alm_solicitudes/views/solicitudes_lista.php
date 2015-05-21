            <div class="mainy">
               <!-- Page title -->
               <div class="page-title">
                  <h2><i class="fa fa-desktop color"></i> Tables <small>Subtext for header</small></h2>
                  <hr />
               </div>
               <!-- Page title -->
               
                  <div class="row">
                     <div class="col-md-12">

                        <div class="awidget full-width">
                           <div class="awidget-head">
                              <h3>Table #2</h3>
                           </div>
                           <div class="awidget-body">
                              
                              <table class="table table-hover table-bordered ">
                               <thead>
                                 <tr>
                                   <th>Solicitud</th>
                                   <th>Fecha Generada</th>
                                   <th>Generado por:</th>
                                   <th>Correo</th>
                                   <th>Rol en Sistema</th>
                                   <th>Estado de Solicitud</th>
                                 </tr>
                               </thead>
                               <tbody>

                                <?php foreach ($solicitudes as $key => $solicitud):?>
                                <tr>
                                   <td><a href='#sol<?php echo $solicitud['nr_solicitud'] ?>' data-toggle="modal"><?php echo $solicitud['nr_solicitud']; ?></a></td>
                                   <td><?php echo date("d/m/Y", strtotime($solicitud['fecha_gen'])); ?></td>
                                   <td><?php echo $solicitud['nombre']." ".$solicitud['apellido']; ?></td>
                                   <td><?php echo $solicitud['email']; ?></td>
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
                                              echo '<td>Director de Departamento</td>';
                                            break;
                                            case 'asistente_dep':
                                              echo '<td>Asistente de Departamento</td>';
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

                               <!-- Modal de articulos -->
                                 <div id="sol<?php echo $solicitud['nr_solicitud'] ?>" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                      <div class="modal-dialog">
                                        <div class="modal-content">
                                          <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">X</button>
                                            <h4 class="modal-title">Numero de Solicitud <?php echo $solicitud['nr_solicitud'];?></h4>
                                          </div>
                                          <div class="modal-body">
                                            <!-- Profile form -->
                                            <table id="tblGrid" class="table table-striped">
                                              <thead id="tblhead">
                                                <th>item</th>
                                                <th>Descripcion</th>
                                                <th>Cantidad Solicitada</th>
                                              </thead>
                                              <tbody>
                                              <?php foreach ($articulos[$solicitud['nr_solicitud']] as $i => $articulo) :?>
                                                <tr><?php echo $articulo['id_articulo']?></tr>
                                                <tr><?php echo $articulo['descripcion']?></tr>
                                                <tr><?php echo $articulo['cant']?></tr>
                                              <?php endforeach ?>
                                              </tbody>
                                            </table>
                                          </div>
                                        </div>
                                      </div>
                                  </div>
                                 <!-- FIN de Modal de articulos -->
                               <!-- Modal de Usuario -->
                                 <div id="sol<?php echo $solicitud['id_usuario'] ?>" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
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
                                                  <td><?php echo ucfirst($solicitud['nombre']).' '.ucfirst($solicitud['apellido']) ?></td>
                                               </tr>
                                               <tr>
                                                  <td><strong>Cedula de Identidad</strong></td>
                                                  <td>:</td>
                                                  <td><?php echo $solicitud['nombre'] ?></td>
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
                                                  <td><strong>Numero de Telefono</strong></td>
                                                  <td>:</td>
                                                  <td><?php echo $solicitud['telefono'] ?></td>
                                                   <?php endif?>
                                               </tr>
                                               <tr>
                                                  <td><strong>Rol Asignado en el Sistema</strong></td>
                                                  <td>:</td>
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
                                                      echo '<td>Director de Departamento</td>';
                                                    break;
                                                    case 'asistente_dep':
                                                      echo '<td>Asistente de Departamento</td>';
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
                                 <!-- FIN de Modal de Usuario -->
                               <?php endforeach ?>
                               </tbody>
                             </table>
                               
                               <div class="clearfix"></div>
                              
                           </div>
                        </div>
                      </div>
                    </div>
                  </div>