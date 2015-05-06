<script type="text/javascript">
    base_url = '<?=base_url()?>';
</script>

<div class="mainy">
               <!-- Page title -->
               <div class="page-title">
                  <h2><i class="fa fa-desktop color"></i> Articulos <small>Seleccione el articulo para detalles, y/o para agregar a solicitud</small></h2>
                  <hr />
               </div>
               <!-- Page title -->
               
                  <div class="row">
                     <div class="col-md-12">
                      <div class="awidget-head">
                        <h3>Lista de Articulos</h3>
                          <!-- Buscar usuario -->
                          <div class="col-lg-6">
                            <form id="ACquery2" class="input-group form" action="<?php echo base_url() ?>index.php/solicitud/inventario" method="post">
                               <input id="autocompleteArt" type="search" name="articulos" class="form-control" placeholder="Palabra clave de la descripcion del articulo">
                               <span class="input-group-btn">
                                  <button type="submit" class="btn btn-info">
                                    <i class="fa fa-search"></i>
                                  </button>
                                </span>
                            </form>
                          </div>
                                  <!-- fin de Buscar usuario -->
                      </div>      
                      <br>
                      </br>
                      <?php echo $links; ?>
                             <!--opcion 1 <div id="portfolio">-->
                            <!--opcion 2-->
                             <table class="table table-hover table-bordered ">
                                <thead>
                                  <tr>
                                  <th><strong>Codigo</strong></th>
                                  <th><strong>Descripcion</strong></th>
                                  <th><strong>Existencia</strong></th>
                                  <th><strong>Reservados</strong></th>
                                  <th><strong>Disponible</strong></th>
                                  <th><strong> </strong></th>
                                  </tr>
                                </thead>
                                <?php foreach($articulos as $key => $articulo) : ?>
                                    <?php //if($key % 3 == 0) :?>
                                    <tbody>
                                        <tr>
                                          <td>
                                            <?php echo $articulo->cod_articulo ?>
                                          </td>
                                          <td>
                                            <?php echo $articulo->descripcion ?>
                                          </td>
                                          <td>
                                            <?php echo ($articulo->disp + $articulo->reserv) ?>
                                          </td>
                                          <td>
                                            <?php echo $articulo->reserv ?>
                                          </td>
                                          <td>
                                            <?php echo $articulo->disp ?>
                                          </td>
                                          <td>
                                            <a href="#Modal<?php echo $articulo->ID ?>" class="btn btn-info" data-toggle="modal">Detalles</a>
                                          </td>
                                        </tr>
                                    </tbody>
                                    <!-- opcion 1<div class="clearfix"></div>
                                    <?php //endif ?>
                                    <div class="col-md-4">
                                    <div class="element">
                                        <div class="awidget">
                                           <div class="awidget-head">
                                              <h3><?php echo $articulo->cod_articulo; ?> </h3>
                                           </div>
                                           <div class="awidget-body">
                                                <ul class="project">
                                                <p><?php echo $articulo->descripcion?> </p>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                  </div> -->
                                  <!--opcion 2-->
                                  <!-- Modal -->
                                  <div id="Modal<?php echo $articulo->ID ?>" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                       <div class="modal-dialog">
                                         <div class="modal-content">
                                             <div class="modal-header">
                                               <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><span class="label label-danger">X</span></button>
                                               <h4 class="modal-title">Detalles</h4>
                                             </div>
                                             <div class="modal-body">
                                               <p>Codigo del articulo: <?php echo $articulo->cod_articulo ?></p>
                                               <p>Descripcion: <?php echo $articulo->descripcion ?></p>
                                               <p>Unidad: <?php echo $articulo->unidad ?></p>
                                                <?php if ($articulo->nuevo == 1) :?>
                                                <p class='label label-success'> Articulo Nuevo </p>
                                                <?php else :?>
                                                <p class='label label-info'> Articulo Usado </p>
                                                <?php endif ?>
                                                <?php if(($articulo->disp + $articulo->reserv) <= $articulo->stock_min) :?>
                                                <p class='label label-warning'> Alerta de Desabastecimiento </p>
                                                <?php endif; if(($articulo->disp + $articulo->reserv) >=$articulo->stock_max) :?>
                                                <p class='label label-warning'> Alerta de sobreabastecimiento </p>
                                                <?php endif ?>
                                                <p> Nivel de inventario </p>
                                                <div class="progress progress-striped active">
                                                  <div class="progress-bar progress-bar-info" role="progressbar" aria-valuenow="<?php echo ($articulo->disp + $articulo->reserv) ?>" aria-valuemin="<?php echo $articulo->stock_min ?>" aria-valuemax="100" style="width: <?php echo ($articulo->disp + $articulo->reserv) ?>%">
                                                  </div>
                                                </div>
                                                <form>
                                                  
                                                </form>

                                             </div>
                                             <div class="modal-footer">
                                               <button type="button" class="btn btn-default" data-dismiss="modal" aria-hidden="true">Close</button>
                                               <button type="button" class="btn btn-primary">Agregar a la solicitud</button>
                                             </div>
                                         </div>
                                       </div>
                                   </div>
                                   <!-- Modal -->
                                <?php endforeach ?>
                             <!--</div>-->
                           </table>
                     </div>
                            <?php echo '<br>'.$links; ?>
                  </div>
                  
            </div>
            
            <div class="clearfix"></div>
            
         </div>