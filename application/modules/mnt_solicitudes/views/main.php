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
        <h2><i class="fa fa-desktop color"></i> Mantenimiento <small>Seleccione la orden para detalles, y/o para realizar una solicitud</small></h2>
        <hr />
    </div>
    <!-- Page title -->
    <div class="row">
        <div class="col-md-12">
            <div class="awidget full-width">
                <div class="awidget-head">
                    <h3>Lista de Solicitudes</h3>
                    <a href="<?php echo base_url() ?>index.php/mnt_solicitudes/orden/crear_orden" class="btn btn-success" data-toggle="modal">Crear Solicitud</a>
                    <!--<a href="<?php echo base_url() ?>" class="btn btn-info">Listar Solicitudes</a>-->
                    <!--href="<?php echo base_url() ?>index.php/mnt_solicitudes/lista_solicitudes"-->
                    <!-- Buscar solicitudes -->
                    <div class="col-lg-6">
                        <form id="ACquery3" class="input-group form" action="<?php echo base_url() ?>index.php/mnt_solicitudes/mnt_solicitudes/lista_solicitudes/busca" method="post">
                            <input id="autocompleteMant" type="search" name="solicitudes" class="form-control" placeholder="Orden... ó Responsable... ó Ubicacion...  ó Estatus">
                            <span class="input-group-btn">
                                <button type="submit" class="btn btn-info">
                                    <i class="fa fa-search"></i>
                                </button>
                            </span>
                        </form>
                    </div>
                    <!-- fin de Buscar solicitudes -->

                </div>
                <?php if ($this->session->flashdata('create_user') == 'success') : ?>
                    <div class="alert alert-success" style="text-align: center">Usuario creado con éxito</div>
                <?php endif ?>
                <?php if ($this->session->flashdata('drop_user') == 'success') : ?>
                    <div class="alert alert-success" style="text-align: center">Usuario Desactivado con éxito</div>
                <?php endif ?>
                <?php if ($this->session->flashdata('drop_user') == 'error') : ?>
                    <div class="alert alert-danger" style="text-align: center">Ocurrió un problema Desactivando al usuario</div>
                <?php endif ?>
                <?php if ($this->session->flashdata('edit_user') == 'success') : ?>
                    <div class="alert alert-success" style="text-align: center">Usuario modificado con éxito</div>
                <?php endif ?>
                <?php if ($this->session->flashdata('edit_solicitud') == 'error') : ?>
                    <div class="alert alert-danger" style="text-align: center">Ocurrió un problema con la edición de la solicitud</div>
                <?php endif ?>
                <!--activate_user-->
                <?php if ($this->session->flashdata('activate_user') == 'success') : ?>
                    <div class="alert alert-success" style="text-align: center">Usuario Activado con éxito</div>
                <?php endif ?>
                <?php if ($this->session->flashdata('activate_user') == 'error') : ?>
                    <div class="alert alert-danger" style="text-align: center">Ocurrió un problema con la activacion del usuario</div>
                <?php endif ?>
                <?php if (empty($mant_solicitudes)) : ?>
                    <div class="alert alert-info" style="text-align: center">No se encontraron Solicitudes</div>
                <?php endif ?>
                <div class="awidget-body">

                    <?php echo $links; ?>

                    <table class="table table-hover table-bordered ">
                        <thead>
                            <tr>
                                <th><a href="<?php echo base_url() ?>index.php/mnt_solicitudes/lista_solicitudes/orden/<?php echo $order ?>">Orden</a></th>
                                <th><a href="<?php echo base_url() ?>index.php/mnt_solicitudes/lista_solicitudes/fecha/<?php echo $order ?>">Fecha</a></th>
                                <th><a href="<?php echo base_url() ?>index.php/mnt_solicitudes/lista_solicitudes/dependencia/<?php echo $order ?>">Dependencia</a></th>
                                <th><?php echo 'Asunto'; ?></th>
                                <th><a href="<?php echo base_url() ?>index.php/mnt_solicitudes/lista_solicitudes/cuadrilla/<?php echo $order ?>">Cuadrilla</a></th>
                                <th><a href="<?php echo base_url() ?>index.php/mnt_solicitudes/lista_solicitudes/estatus/<?php echo $order ?>">Estatus</a></th>


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
                                        <td>
                                            <?php
                                            if (!empty($sol->cuadrilla)):
                                                echo ($sol->cuadrilla);
                                            else :
                                                echo ('<p class="text-muted"><span class="label label-danger">SIN ASIGNAR</span></p>');
                                            endif;
                                            ?>   
                                        </td>
                                        <td> <?php echo $sol->descripcion; ?></td>
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
    <!-- CREAR USUARIO -->


</div>
<div class="clearfix"></div>