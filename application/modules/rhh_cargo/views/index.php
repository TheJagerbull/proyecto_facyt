<script src="<?php echo base_url() ?>assets/js/jquery-1.11.3.js"></script>
<script src="<?php echo base_url() ?>assets/js/sweet-alert.js" type="text/javascript"></script>

<style type="text/css">
    .head{ margin-top: 10px; margin-bottom: 10px; }
    .long-words{
        -ms-word-break: break-all;
        word-break: break-all;
        /* Non standard for webkit */
        word-break: break-word;
        -webkit-hyphens: auto;
        -moz-hyphens: auto;
        hyphens: auto;
    }
</style>

<div class="mainy">
    <!-- Page title -->
    <div class="row">
        <div class="col-md-12">
            <!-- Sub Cabecera, preferencial -->
            <div class="page-title">
                <h2 class="text-right"><i class="fa fa-globe color"></i> Cargos</h2>
                <hr />
            </div>

            <!-- Este debería ser el espacio para los flashbags -->
            <?php if ($this->session->flashdata('mensaje') != FALSE) { echo $this->session->flashdata('mensaje'); } ?>

            <div class="panel panel-default">
                <div class="panel-heading">
                    <label class="control-label">Cargos Agregados</label>
                    <div class="btn-group btn-group-sm pull-right">
                        <a type="button" class="btn btn-default" href="<?php echo site_url('cargo/nuevo') ?>"><i class="fa fa-plus fa-fw"></i> Agregar Cargo</a>
                    </div>
                </div>
                <table class="table table-bordered table-hover">
                    <thead>
                        <tr>
                            <th class="text-center">#</th>
                            <th>Código</th>
                            <th>Nombre</th>
                            <th>Tipo</th>
                            <th>Descripción</th>
                            <th>Opciones</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php if(sizeof($cargos) == 0){ ?>
                        <tr class="text-center">
                            <td colspan="7"> No ha agregado ninguna configuración sobre los ausentismos y reposos</td>
                        </tr>
                    <?php } ?>
                    <?php $index = 1; foreach ($cargos as $key): ?>
                        <tr>
                            <td class="text-center"><?php echo $index; $index++; ?></td>
                            <td><?php echo $key['codigo']; ?></td>
                            <td><?php echo $key['nombre']; ?></td>
                            <td><?php echo $key['tipo']; ?></td>
                            <td class="col-md-4 long-words"><?php echo $key['descripcion']; ?></td>
                            <td class="text-center">
                                <a href="<?php echo site_url('cargo/modificar/').'/'.$key['ID']; ?>" class="btn btn-default btn-sm"><i class="fa fa-edit fa-fw"></i></a>
                                <a id="eliminar_confirmacion" href="<?php echo site_url('cargo/eliminar').'/'.$key['ID']; ?>" class="btn btn-danger btn-sm"><i class="fa fa-trash-o fa-fw"></i></a>
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
            text: "Se eliminará este Cargo y la(s) Jornada(s) laboral(es) asociadas a el.",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#DD3333",
            confirmButtonText: "Eliminar",
            cancelButtonText: "Cancelar",
            closeOnConfirm: false
        },
        function(isConfirm){ if(isConfirm){ window.location.href = href; } });
    });
</script>