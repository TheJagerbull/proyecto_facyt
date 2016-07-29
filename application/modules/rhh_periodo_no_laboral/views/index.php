<script src="<?php echo base_url() ?>assets/js/jquery-1.11.3.js"></script>
<script src="<?php echo base_url() ?>assets/js/sweet-alert.js" type="text/javascript"></script>

<style type="text/css">
    .head{ margin-top: 10px; margin-bottom: 10px; }
</style>

<div class="mainy">
    <div class="row">
        <div class="col-md-12">
            <!-- Page title --> 
            <div class="page-title">
                <h2 class="text-right"><i class="fa fa-globe color"></i> Periodos No Laborables</h2>
                <hr>
            </div>

            <div class="alert well-sm alert-info">
                <p>Falta Agregar Función para Duplicar los Periodos no laborales, permitiendo elegir el perido para el cual quiero realizar el duplicado, como pre-condición el periodo tiene   que estar creado.</p>
            </div>

            <!-- Este debería ser el espacio para los flashbags -->
            <?php if ($this->session->flashdata('mensaje') != FALSE) { echo $this->session->flashdata('mensaje'); } ?>

            <div class="panel panel-default">
                <div class="panel-heading">
                    <label class="control-label">Periodos Agregados</label>
                    <a type="button" class="btn btn-sm btn-success pull-right" href="<?php echo site_url('periodo-no-laboral/nuevo') ?>"><i class="fa fa-plus fa-fw"></i> Agregar Periodo No Laborable</a>
                </div>
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th class="text-center">#</th>
                            <th>Nombre</th>
                            <th>Descripción</th>
                            <th>Desde</th>
                            <th>Hasta</th>
                            <th>Días</th>
                            <th>Período</th>
                            <th>Opciones</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php if(sizeof($periodos) == 0){ ?>
                        <tr class="text-center">
                            <td colspan="6"> No ha agregado ninguna configuración sobre los ausentismos y reposos</td>
                        </tr>
                    <?php } ?>
                    <?php $index = 1; foreach ($periodos as $key): ?>
                        <tr>
                            <td class="text-center"><?php echo $index; $index++; ?></td>
                            <td><?php echo $key['nombre']; ?></td>
                            <td class="col-md-5"><?php echo $key['descripcion']; ?></td>
                            <td><?php echo $key['fecha_inicio']; ?></td>
                            <td><?php echo $key['fecha_fin']; ?></td>
                            <td><?php echo $key['cant_dias']; ?> días</td>
                            <td>Período ID: <?php echo $key['periodo']; ?></td>
                            <td class="text-center">
                                <a href="<?php echo site_url('periodo-no-laboral/modificar/').'/'.$key['ID']; ?>" class="btn btn-primary btn-sm"><i class="fa fa-edit fa-fw"></i></a>
                                <a id="eliminar_confirmacion" href="<?php echo site_url('periodo-no-laboral/eliminar').'/'.$key['ID']; ?>" class="btn btn-default btn-sm"><i class="fa fa-trash-o fa-fw"></i></a>
                            </td>
                        </tr>
                    <?php endforeach ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<div class="clearfix"></div>

<script type="text/javascript">
    $('[id="eliminar_confirmacion"]').click(function(e){
        e.preventDefault();
        var href = $(this).attr('href');
        swal({
            title: "¿Está seguro?",
            text: "Se eliminará este Periodo No Laboral",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "Seguro",
            closeOnConfirm: false
        },
        function(isConfirm){ if(isConfirm){ window.location.href = href; } });
    });
</script>