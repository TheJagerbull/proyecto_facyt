<script type="text/javascript">
    base_url = '<?php echo base_url(); ?>'
</script>
<!-- Page content -->
<div class="mainy">
    <?php if ($this->session->flashdata('create_orden') == 'success') : ?>
        <div class="alert alert-success" style="text-align: center">Solicitud creada con éxito</div>
    <?php endif ?>
    <?php if ($this->session->flashdata('create_orden') == 'error') : ?>
        <div class="alert alert-danger" style="text-align: center">Ocurrió un problema creando su solicitud</div>
    <?php endif ?>

    <!-- Page title --> 
    <div class="page-title">
        <h2 align="right"><i class="fa fa-desktop color"></i> Mantenimiento <small>Seleccione la orden para detalles, y/o para realizar una solicitud</small></h2>
        <hr />
    </div>
    <!-- Page title -->
    <div class="row">
        <div class="col-md-12">
            <div class="awidget full-width">
                <div class="awidget-head">
                    <h3>Lista de Solicitudes</h3>
                    <a href="<?php echo base_url() ?>index.php/mnt_solicitudes/solicitud" class="btn btn-success" data-toggle="modal">Crear Solicitud</a>
                    <a href="<?php echo base_url() ?>index.php/mnt_solicitudes/lista" class="btn btn-info">Listar Solicitudes</a>
                    <!--href="<?php echo base_url() ?>index.php/mnt_solicitudes/lista_solicitudes"-->
                    <!-- Buscar solicitudes -->
                    <div class="col-lg-6">
                        <form id="ACquery3" class="input-group form" action="<?php echo base_url() ?>index.php/mnt_solicitudes/lista/busca" method="post">
                           <div class="container" id="sandbox-container">
                            <input id="autocompleteMant" type="search" name="solicitudes" class="form-control" placeholder="Orden... ó cuadrilla... ó ubicación...  ó estatus">
                            <div class="input-daterange input-group" id="datepicker">
                                <input type="text" id="start" class="input-sm form-control" name="start" readonly />
                                <span class="input-group-addon">a</span>
                                <input type="text" id="end" class="input-sm form-control" name="end" readonly/>
                                <span class="input-group-btn">
                                 <button type="submit" class="btn btn-info">
                                    <i class="fa fa-search"></i>
                                 </button>
                                </span>            
                            </div>
                           </div>
                        </form>
                    </div>
                    <!-- fin de Buscar solicitudes -->
                </div>
                <?php if (empty($mant_solicitudes)) : ?>
                    <div class="alert alert-info" style="text-align: center">No se encontraron Solicitudes</div>
                <?php endif ?>
                <div class="awidget-body">
                    <div class="list-group"></div>
                    <?php echo $links; ?>

                    <table class="table table-hover table-bordered ">
                        <thead>
                            <tr>
                                <th><a href="<?php echo base_url() ?>index.php/mnt_solicitudes/lista/orden/<?php echo $order ?>">Orden</a></th>
                                <th><a href="<?php echo base_url() ?>index.php/mnt_solicitudes/lista/fecha/<?php echo $order ?>">Fecha</a></th>
                                <th><a href="<?php echo base_url() ?>index.php/mnt_solicitudes/lista/dependencia/<?php echo $order ?>">Dependencia</a></th>
                                <th><?php echo 'Asunto'; ?></th>
                                <th><a href="<?php echo base_url() ?>index.php/mnt_solicitudes/lista/estatus/<?php echo $order ?>">Estatus</a></th>
                                <th align="center">
<!--                                    <a href="<?php// echo base_url() ?>index.php/mnt_solicitudes/lista/cuadrilla/<?php// echo $order ?>">Cuadrilla</a>-->
                        <div align="center"><img src="<?php echo base_url() ?>assets/img/mnt/tecn.png" class="img-rounded" alt="bordes redondeados" width="25" height="25"></div>
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
                                        <td>
                                            <?php
                                            if (!empty($sol->cuadrilla)):?>
                                                 <div align="center"> <img src="<?php echo base_url().$sol->icono;?>" class="img-rounded" alt="bordes redondeados" width="25" height="25"></div>
                                            <?php                                                
                                             else :
                                                ?><div align="center"><img src="<?php echo base_url() ?>assets/img/mnt/noo.jpg" class="img-rounded" alt="bordes redondeados" width="25" height="25"></div>
                                            <?php endif;
                                            ?>   
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>

                    <?php echo $links; ?>
                    <div class="clearfix"></div>
                </div>
            </div>
        </div>
    </div>
 </div>
<div class="clearfix"></div>