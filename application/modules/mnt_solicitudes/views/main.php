<script type="text/javascript">
    base_url = '<?= base_url() ?>';
</script><!-- Page content -->

<div class="mainy">
    <?php if ($this->session->flashdata('create_orden') == 'success') : ?>
        <div class="alert alert-success" style="text-align: center">Solicitud creada con éxito</div>
    <?php endif ?>
    <?php if ($this->session->flashdata('create_orden') == 'error') : ?>
        <div class="alert alert-danger" style="text-align: center">Ocurrió un problema creando su solicitud</div>
    <?php endif ?>

    <!-- Page title --> 
    <div class="page-title">
        <h2 align="right"><i class="fa fa-desktop color"></i> Consulta de solicitud <small>Seleccione para ver detalles </small></h2>
        <hr />
    </div>
          
    <!-- Page title -->
    <div class="row">
        <div class="col-md-12">
            <div class="awidget full-width">
                <div class="awidget-head">
                    <h3>Lista de Solicitudes</h3>
                </div>
                 <!-- Buscar solicitudes -->
                    <div class="form-group">
                        <div class="col-lg-5">
                         <form id="ACquery3" class="input-group form" action="<?php echo base_url() ?>index.php/mnt_solicitudes/listar/buscar" method="post">
                            <div class="container" id="sandbox-container">
                              <div>
                                <input type="search" readonly style="width: 200px" name="fecha" id="fecha" class="form-control" placeholder="Fecha" /> 
                                <span class="input-group-btn">
                                  <button type="reset" class="btn-info">
                                    <i class="fa fa-chevron-left"></i>
                                  </button>
                               </span>            
                            </div>
                                <input id="autocompleteMant" type="search" name="solicitudes" class="form-control" placeholder="Orden... ó cuadrilla... ó ubicación...  ó estatus">
                             <fieldset>
                               <span class="input-group-btn">
                                 <button type="submit" class="btn btn-info">
                                    <i class="fa fa-search"></i>
                                 </button>
                               </span>            
                            </fieldset>
                                
                           </div>
                        </form>
                        </div>
                        <div class="col-lg-4">
                            <a href="<?php echo base_url() ?>index.php/mnt_solicitudes/listar" class="btn btn-info">Listar</a>
                            <a href="<?php echo base_url() ?>index.php/mnt_solicitudes/solicitud" class="btn btn-success" data-toggle="modal">Crear Solicitud</a>
                            <!--href="<?php echo base_url() ?>index.php/mnt_solicitudes/lista_solicitudes"-->
                        </div>
                    </div>
                    <!-- fin de Buscar solicitudes -->
                
                <?php if (empty($mant_solicitudes)) : ?>
                    <div class="alert alert-info" style="text-align: center">No se encontraron Solicitudes</div>
                <?php endif ?>
                <div class="awidget-body">
                    <div class="list-group" align="right"><?php echo $links; ?></div>
                    

                    <table class="table table-hover table-bordered ">
                        <thead>
                            <tr>
                                <th><a href="<?php echo base_url() ?>index.php/mnt_solicitudes/orden/<?php if($this->uri->segment(3)=='buscar') echo 'buscar/'; ?>orden/<?php echo $order ?>/0">Orden</a></th>
                                <th><a href="<?php echo base_url() ?>index.php/mnt_solicitudes/orden/<?php if($this->uri->segment(3)=='buscar') echo 'buscar/'; ?>fecha/<?php echo $order ?>/0">Fecha</a></th>
                                <th><a href="<?php echo base_url() ?>index.php/mnt_solicitudes/orden/<?php if($this->uri->segment(3)=='buscar') echo 'buscar/'; ?>dependencia/<?php echo $order ?>/0">Dependencia</a></th>
                                <th><?php echo 'Asunto'; ?></th>
                                <th><a href="<?php echo base_url() ?>index.php/mnt_solicitudes/orden/<?php if($this->uri->segment(3)=='buscar') echo 'buscar/'; ?>estatus/<?php echo $order ?>/0">Estatus</a></th>
                                <th colspan="3"><div align="center"> Asignar personal</div>
<!--                                    <a href="<?php// echo base_url() ?>index.php/mnt_solicitudes/lista/cuadrilla/<?php// echo $order ?>">Cuadrilla</a>-->
<!--                        <div align="center"><img src="<?php //echo base_url() ?>assets/img/mnt/tecn.png" class="img-rounded" alt="bordes redondeados" width="25" height="25"></div>-->
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                              
                            <?php if (!empty($mant_solicitudes)) : ?>

                                <?php foreach ($mant_solicitudes as $key => $sol) : ?>

                                    <tr>
                                        <td>
                                            <a href="<?php echo base_url() ?>index.php/mnt_solicitudes/detalle/<?php echo $sol->id_orden ?>">
                                                <?php echo $sol->id_orden ?>
                                            </a>
                                        </td>

                                        <td><?php echo date("d/m/Y", strtotime($sol->fecha_p)); ?></td>

                                        <td> <?php echo $sol->dependen; ?></td>
                                        <td> <?php echo $sol->asunto; ?></td>
                                        <td> <?php echo $sol->descripcion; ?></td>
                                        
                                            <th>
                                            <?php
                                            if (!empty($sol->cuadrilla)):?>
                                                 <div align="center"> <img src="<?php echo base_url().$sol->icono;?>" class="img-rounded" alt="bordes redondeados" width="25" height="25"></div>
                                            <?php                                                
                                             else :
                                                ?><div align="center"><img src="<?php echo base_url() ?>assets/img/mnt/noo.jpg" class="img-rounded" alt="bordes redondeados" width="25" height="25"></div>
                                            <?php endif;
                                            ?> 
                                             </th>
                                             <th>i2</th>
                                             <th>i3</th>
                                         
                                    </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>

                    <div class="list-group" align="right"><?php echo $links; ?></div>
                    <div class="clearfix"></div>
                </div>
            </div>
        </div>
    </div>
 </div>
<div class="clearfix"></div>