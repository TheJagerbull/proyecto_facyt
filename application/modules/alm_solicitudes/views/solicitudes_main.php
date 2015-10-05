<script type="text/javascript">
    base_url = '<?=base_url()?>';
</script>

<div class="mainy">
              <!-- Page title -->
               <div class="page-title">
                  <h2 align="right"><i class="fa fa-tags color"></i> Generar solicitud <small>Seleccione los articulos a agregar</small></h2>
                  <hr />
               </div>
              <!-- End Page title -->
<!--stepwizard -->
               
                      <div class="stepwizard col-md-offset-3">
                        <div class="stepwizard-row setup-panel">
                          <div class="stepwizard-step">
                            <a href="<?php echo base_url() ?>index.php/solicitud/inventario" type="button" class="btn btn-primary btn-circle">1</a>
                            <p>Paso 1</p>
                          </div>
                          <?php if(!$this->session->userdata('articulos')) :?>
                          <div class="stepwizard-step">
                            <a href="" type="button" class="btn btn-default btn-circle" disabled="disabled">2</a>
                            <p>Paso 2</p>
                          </div>
                        <?php else :?>
                          <div class="stepwizard-step">
                            <a href="<?php echo base_url() ?>index.php/solicitud/confirmar" type="button" class="btn btn-default btn-circle">2</a>
                            <p>Paso 2</p>
                          </div>
                        <?php endif ?>
                          <div class="stepwizard-step">
                            <a href="" type="button" class="btn btn-default btn-circle" disabled="disabled">3</a>
                            <p>Paso 3</p>
                          </div>
                        </div>
                      </div>
<!-- end Stepwizard -->
                  <div class="row">
                     <div class="col-md-12">
                      <div class="awidget-head">
                        <h3>Lista de Articulos</h3>
<!-- Buscar articulo -->
                          <div class="col-md-10">
                            <div class="col-lg-6">
                              <form id="ACquery2" class="input-group form" action="<?php echo base_url() ?>index.php/solicitud/inventario/buscar" method="post">
                                 <input id="autocompleteArt" type="search" name="articulos" class="form-control" placeholder="Palabra clave de la descripcion del articulo">
                                 <span class="input-group-btn">
                                    <button type="submit" class="btn btn-info">
                                      <i class="fa fa-search"></i>
                                    </button>
                                  </span>
                              </form>
                            </div>
                          </div>
                          <?php if(!$this->session->userdata('articulos')) :?>
                          <div class="col-md-2">
                            <a class="btn btn-default" > Siguiente paso </a>
                          </div>
                          <?php else : ?>
                          <div class="col-md-2">
                            <a class="btn btn-info" href="<?php echo base_url() ?>index.php/solicitud/confirmar"> Siguiente paso </a>
                          </div>
                          <?php endif ?>
<!-- fin de Buscar articulo -->
                      </div>      
                      <br>
                      </br>
                      <?php echo $links; ?>
                             <!--opcion 1 <div id="portfolio">-->
                            <!--opcion 2-->
                             <table class="table table-hover table-bordered ">
                                <thead>
                                  <tr>
                                    <th>Agregar</th>
                                    <th><a href="<?php echo base_url() ?>index.php/solicitud/inventario/orden/<?php if($this->uri->segment(3)=='buscar'||$this->uri->segment(4)=='buscar') echo 'buscar/'; ?>orden_cod/<?php echo $order ?>/0">Codigo</a></th>
                                    <th><a href="<?php echo base_url() ?>index.php/solicitud/inventario/orden/<?php if($this->uri->segment(3)=='buscar'||$this->uri->segment(4)=='buscar') echo 'buscar/'; ?>orden_descr/<?php echo $order ?>/0">Descripcion</a></th>
                                    <!-- <th><a href="<?php echo base_url() ?>index.php/solicitud/inventario/orden/<?php if($this->uri->segment(3)=='buscar'||$this->uri->segment(4)=='buscar') echo 'buscar/'; ?>orden_exist/<?php echo $order ?>/0">Existencia</a></th> -->
                                    <!-- <th><a href="<?php echo base_url() ?>index.php/solicitud/inventario/orden/<?php if($this->uri->segment(3)=='buscar'||$this->uri->segment(4)=='buscar') echo 'buscar/'; ?>orden_reserv/<?php echo $order ?>/0">Reservados</a></th> -->
                                    <!-- <th><a href="<?php echo base_url() ?>index.php/solicitud/inventario/orden/<?php if($this->uri->segment(3)=='buscar'||$this->uri->segment(4)=='buscar') echo 'buscar/'; ?>orden_disp/<?php echo $order ?>/0">Disponible</a></th> -->
                                    <th><a> </a></th>
                                  </tr>
                                </thead>

                                            <!-- <?php echo_pre($this->session->userdata('articulos'));?> -->
                                <?php foreach($articulos as $key => $articulo) : ?>
                                    <tbody>
                                        <tr>
                                            <?php if(!empty($this->session->userdata('articulos')) && in_array($articulo->ID, $this->session->userdata('articulos'))) :?>
                                              <td align="center"><i class="fa fa-check"></i></td>
                                            <?php else: ?>
                                              <td align="center">
                                                <form class="form-horizontal" action="<?php echo base_url() ?>index.php/solicitud/agregar" method="post">
                                                  <input type="hidden" name="URI" value="<?php echo $this->uri->uri_string()?>"/>
                                                  <input type="hidden" name="ID" value="<?php echo $articulo->ID ?>" />
                                                  <button type="submit"><i class="fa fa-plus color"></i></button>
                                                </form>
                                              </td>
                                              <!--<td align="center"><a href="<?php echo base_url() ?>index.php/solicitud/agregar/<?php echo $articulo->ID ?>"><i class="fa fa-plus color"></i></a></td>-->
                                            <?php endif ?>
                                          <td>
                                            <?php echo $articulo->cod_articulo ?>
                                          </td>
                                          <td>
                                            <?php echo $articulo->descripcion ?>
                                          </td>
                                          <!-- <td>
                                            <?php echo ($articulo->disp + $articulo->reserv) ?>
                                          </td>
                                          <td>
                                            <?php echo $articulo->reserv ?>
                                          </td>
                                          <td>
                                            <?php echo $articulo->disp ?>
                                          </td> -->
                                          <td>
                                            <a href="#Modal<?php echo $articulo->ID ?>" class="btn btn-info" data-toggle="modal">Detalles</a>
                                          </td>
                                        </tr>
                                    </tbody>
                                  <!--opcion 2-->
                                  <!-- Modal -->
                                      <div id="Modal<?php echo $articulo->ID ?>" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                          <div class="modal-dialog">
                                            <div class="modal-content">
                                              <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">X</button>
                                                <h4 class="modal-title">Detalles</h4>
                                              </div>
                                              <div class="modal-body">
                                                <!-- Profile form -->
                                                <div class="alert alert-info">
                                                   <p>Descripcion : <?php echo $articulo->descripcion?> </p>
                                                   <p>Cantidad Disponible : <?php echo $articulo->disp?> </p>
                                                   <p>
                                                      <div class="progress progress-striped active">
                                                        <div class="progress-bar progress-bar-warning"  role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: <?php echo $articulo->disp ?>%">
                                                          <span class="sr-only"><?php echo $articulo->disp ?>% Complete</span>
                                                        </div>
                                                      </div> 
                                                  </p>
                                                  <?php if($articulo->stock_min > ($articulo->disp + $articulo->reserv)) :?>
                                                   <p>  <span class="label label-warning">Alerta de Subabastecimiento</span></p>
                                                  <?php endif ?>
                                                  <?php if($articulo->stock_max < ($articulo->disp + $articulo->reserv)) :?>
                                                   <p>  <span class="label label-warning">Alerta de Sobreabastecimiento</span></p>
                                                 <?php endif?>

                                                </div>
                                              </div>
                                            </div>
                                          </div>
                                      </div>
                                   <!-- Modal -->
                                <?php endforeach ?>
                             <!--</div>-->
                           </table>
                     </div>
                  </div>
                  <div class="row">
                      <div class="col-md-10">
                      <?php echo '<br>'.$links; ?>
                      </div>
                          <?php if(!$this->session->userdata('articulos')) :?>
                          <div class="col-md-2">
                            <a class="btn btn-default" > Siguiente paso </a>
                          </div>
                          <?php else : ?>
                          <div class="col-md-2">
                            <a class="btn btn-info" href="<?php echo base_url() ?>index.php/solicitud/confirmar"> Siguiente paso </a>
                          </div>
                          <?php endif ?>
                  </div>
                  
            </div>
            
            <div class="clearfix"></div>
            
         </div>