<script src="<?php echo base_url() ?>assets/js/jquery.min.js"></script>
<script src="<?php echo base_url() ?>assets/js/bootstrap-touchspin.js"></script>
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
                      <form class="input-group form" action="<?php echo base_url() ?>index.php/administrador/solicitudes<?php echo (!empty($this->session->userdata('query'))) ? '/filtrar' : '' ?>" method="post">
                              <?php if(!empty($this->session->userdata('query'))):?>
                              <input type="hidden" name="<?php echo key($this->session->userdata('query'))?>" value="<?php echo (!empty($this->session->userdata('query'))) ? $this->session->userdata('query')[key($this->session->userdata('query'))] : '' ?>" />
                              <?php endif?>
                              <div class="col-md-6 col-lg-6">  
                                <div class="form-group">
                                  <label class="col-lg-4 control-label">Opciones</label>
                                    
                                    <select id="opciones" name='command' class="form-control">
                                      <option value="blah" selected >...Elija una opcion para mostrar...</option>
                                      <option value="dep" <?php echo (!empty($this->session->userdata('query')) && (key($this->session->userdata('query')) == 'id_dependencia')) ? 'selected' : '' ?>>Por departamento</option>
                                      <option value="find_usr" <?php echo (!empty($this->session->userdata('query')) && (key($this->session->userdata('query')) == 'id_usuario')) ? 'selected' : '' ?>>Por usuario (Buscar usuario)</option>
                                      <option value="status" <?php echo (!empty($this->session->userdata('query')) && (key($this->session->userdata('query')) == 'status')) ? 'selected' : '' ?>>Por estado de la solicitud</option>
                                    </select>
                                </div>
                              </div>
                              <div class="col-md-5 col-lg-5">
                              <table class="table">
                                  <tr>Por fecha</tr>
                                  <tr>
                                    <th>
                                      <div>
                                          <input type="text" readonly style="width: 200px" name="fecha" id="fecha" class="form-control" value="<?php echo (!empty($this->session->userdata('range'))) ? $this->session->userdata('range') : 'Fecha' ?>" />
                                          <span class="input-group-btn">
                                           <button type="submit" class="btn btn-info">
                                              <i class="fa fa-calendar"></i>
                                           </button>
                                          </span>            
                                      </div>
                                    </th>
                                  </tr>
                                  <tr>
                                    <th>
                                        <button type="submit" class="btn btn-primary">Consultar</button>
                                    </th>
                                    <th>
                                      <a class="btn btn-warning" href="<?php echo base_url() ?>index.php/administrador/solicitudes/reiniciar">reiniciar</a>
                                    </th>
                                    <th>
                                        <button onclick="change(); submit" type="button" class="btn btn-danger" align="right">Limpiar</button>
                                    </th>
                                  </tr>
                              </table>
                            </div>
                              
                      </form>
                  </div>
                 </div>
                 <!--<?php //if(isset($command) && ($command == 'find_usr')):?>-->
                 <div id="blah" style="display:none" class="opcional col-lg-5">
                  <!--esta Area es para control sobre el script de custom.js-->
                  </div>
                  <!-- Este de el campo de busqueda de usuario -->
                      <div id="find_usr" style="display:none" class="opcional col-lg-5">
                        <form id="ACquery" class="input-group form" action="<?php echo base_url() ?>index.php/administrador/solicitudes/filtrar" method="post">
                          <input type="hidden" name="command" value="find_usr" />
                          <input type="hidden" name="fecha" value="<?php echo (!empty($this->session->userdata('range'))) ? $this->session->userdata('range') : 'Fecha' ?>" />
                          <input id="autocomplete" type="search" name="usuarios" class="form-control" placeholder="Cedula... o Nombre... o Apellido...">
                            <span class="input-group-btn">
                              <button type="submit" class="btn btn-info">
                                <i class="fa fa-search"></i>
                              </button>
                            </span>
                        </form>
                      </div>
                      <!-- Este de el campo de busqueda por departamento -->
                      <div id="dep" style="display:none" class="opcional col-lg-5">
                        <form class="input-group form" action="<?php echo base_url() ?>index.php/administrador/solicitudes/filtrar" method="post">
                          <input type="hidden" name="command" value="dep" />
                          <input type="hidden" name="fecha" value="<?php echo (!empty($this->session->userdata('range'))) ? $this->session->userdata('range') : 'Fecha' ?>" />
                          <?php echo $dependencia ?>
                          <!-- <select name="id_dependencia" onchange="submit()">
                              <option value="" selected >--SELECCIONE--</option> -->
                              <?php //foreach ($dependencia as $dep): ?>
                                  <!-- <option value = "<?php echo $dep->id_dependencia ?>"><?php echo $dep->dependen ?></option> -->
                              <?php //endforeach; ?>
                          <!-- </select> -->
                        </form>
                      </div>
                      <!-- Este de el campo de busqueda por estado de solicitud -->
                      <div id="status" style="display:none" class="opcional col-lg-5">
                        <form class="input-group form" action="<?php echo base_url() ?>index.php/administrador/solicitudes/filtrar" method="post">
                          <input type="hidden" name="command" value="status" />
                          <input type="hidden" name="fecha" value="<?php echo (!empty($this->session->userdata('range'))) ? $this->session->userdata('range') : 'Fecha' ?>" />
                          <select name="status" class="form-control" >
                            <option value="en_proceso">En proceso</option>
                            <option value="aprobada">Aprobada</option>
                            <option value="enviado">Enviado a departamento</option>
                            <option value="completado">Solicitud completada</option>
                          </select>
                            <span class="input-group-btn">
                              <button type="submit" class="btn btn-info">
                                <i class="fa fa-search"></i>
                              </button>
                            </span>
                        </form>
                      </div>
                      <!--
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
                    -->
                    <!--<?php //endif ?>-->
                  <div class="row">
                     <div class="col-md-12">
                  <?php if($this->session->flashdata('solicitudes') == 'error') : ?>
                    <div class="alert alert-danger" style="text-align: center">No se encontraron solicitudes</div>
                  <?php endif ?>

                        <div class="awidget full-width">
                           <div class="awidget-head">
                              <h3>Ultimas solicitudes recibidas</h3>
                           </div>
                           <div class="awidget-body">
                              <?php echo $links; ?>
                              <table class="table table-hover table-bordered ">
                               <thead>
                                 <tr>
                                   <th><a href="<?php echo base_url() ?>index.php/administrador/solicitudes/orden/<?php if($this->uri->segment(3)=='filtrar' || $this->uri->segment(4)=='filtrar') echo 'filtrar/'; ?>orden_sol/<?php echo $order ?>/0">Solicitud</a></th>
                                   <th><a href="<?php echo base_url() ?>index.php/administrador/solicitudes/orden/<?php if($this->uri->segment(3)=='filtrar' || $this->uri->segment(4)=='filtrar') echo 'filtrar/'; ?>orden_fecha/<?php echo $order ?>/0">Fecha generada</a></th>
                                   <th><a href="<?php echo base_url() ?>index.php/administrador/solicitudes/orden/<?php if($this->uri->segment(3)=='filtrar' || $this->uri->segment(4)=='filtrar') echo 'filtrar/'; ?>orden_gen/<?php echo $order ?>/0">Generado por:</a></th>
                                   <th><a href="<?php echo base_url() ?>index.php/administrador/solicitudes/orden/<?php if($this->uri->segment(3)=='filtrar' || $this->uri->segment(4)=='filtrar') echo 'filtrar/'; ?>orden_rol/<?php echo $order ?>/0">Rol en sistema</a></th>
                                   <th><a href="<?php echo base_url() ?>index.php/administrador/solicitudes/orden/<?php if($this->uri->segment(3)=='filtrar' || $this->uri->segment(4)=='filtrar') echo 'filtrar/'; ?>orden_stad/<?php echo $order ?>/0">Estado de solicitud</a></th>
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
                                      <div class="modal-dialog modal-lg">
                                        <div class="modal-content">
                                          <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">X</button>
                                            <h4 class="modal-title">Numero de solicitud <?php echo $solicitud['nr_solicitud'];?></h4>
                                            <h3><i class="fa fa-time color"></i><?php echo date("d/m/Y", strtotime($solicitud['fecha_gen']))." a las".date(" H:i:s", strtotime($solicitud['fecha_gen'])); ?></h3>
                                          </div>
                                          <div class="modal-body">
                                                                     
                                                  <form class="form" id="aprueba" name="aprueba" action="<?php echo base_url() ?>index.php/alm_solicitudes/aprobar" method="post"> 
                                            <!-- Profile form -->
                                                <table id="tblGrid" class="table table-hover table-bordered table-condensed">
                                                <thead>
                                                    <tr>
                                                        <th>item</th>
                                                        <th>Descripcion</th>
                                                        <th>Solicitados</th>
                                                        <th>Disponibles</th>
                                                        <th>Aprobados</th>
                                                        <th>Por despachar</th>
                                                
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                  <?php foreach ($articulos[$solicitud['nr_solicitud']] as $i => $articulo) :?>
                                                    <tr>
                                                        <td><?php echo $articulo['id_articulo']?></td>
                                                        <td><?php echo $articulo['descripcion']?></td>
                                                        <td><?php echo $articulo['cant']?></td>
                                                        <td><?php echo $articulo['disp']?></td>
                                                        <td>
                                                            <div class="col-xs-6"><input class="form-control input-sm" id="aprob" type="text" value="" name="aprob[<?php echo $articulo['id_articulo']; ?>]"></div>
                                                            <script>//Este script es para hacer funcionar el TouchSpin
                                                                $("input[name='aprob[<?php echo $articulo['id_articulo']; ?>]']").TouchSpin({
                                                                    min:0, //Valor minimo del input 
                                                                   <?php if($articulo['cant_aprob']!=0):?> //Se evalua la cantidad de aprobados para el valor inicial del input
                                                                        initval: <?php echo $articulo['cant_aprob']?>,
                                                                    <?php else:?>
                                                                        initval: 0,
                                                                    <?php endif;?>
                                                                    max: <?php echo $articulo['cant']?>, //Se limita el valor maximo
                                                                });
                                                            </script>
                                                        </td>
                                                        <td><?php echo $articulo['reserv']?></td>
                                                    </tr>
                                                  <?php endforeach ?>
                                                </tbody>
                                                </table>
                                                <div class="modal-footer">                                                                                     
                                                    <input  type="hidden" name="nr_solicitud" value="<?php echo $solicitud['nr_solicitud']; ?>" />
                                                    <input  type="hidden" name="uri" value="<?php echo $this->uri->uri_string() ?>"/>
                                                    
                                                    <div align="center" class = "col-md-12">
                                                        <button type="button" class="btn btn-default" data-dismiss="modal" aria-hidden="true">Cancelar</button>
                                                        <button type="submit" class="btn btn-success">Aprobar</button>
                                                    </div>
                                                </div>
                                            </form>
                                            <?php // endif?>
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
                                            <h4 class="modal-title">Perfil del usuario que gener&oacute; la solicitud</h4>
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
                                                      echo '<td>Director de dependencia</td>';
                                                    break;
                                                    case 'asistente_dep':
                                                      echo '<td>Asistente de dependencia</td>';
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
                 <script>
                    function change(){
                      document.getElementById("fecha").value= "Fecha";
                      // document.getElementById("hasta").value= "";
                      document.getElementById("opciones").value= "blah";
                      $("#find_usr").hide();
                      $("#dep").hide();
                      $("#status").hide();
                    }
                    // function option(value){
                    //   $("#find_usr").hide();
                    //   console.log(value);
                    //   value='#'+value;
                    //   console.log(value);
                    //   $(value).show();

                    // }
                    </script>