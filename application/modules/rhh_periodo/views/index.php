<script src="<?php echo base_url() ?>assets/js/jquery-1.11.3.js"></script>
<script src="<?php echo base_url() ?>assets/js/sweet-alert.js" type="text/javascript"></script>
<script src="<?php echo base_url() ?>assets/js/jquery.dataTables.min.js"></script>

<div class="mainy">
    <div class="row">
        <div class="col-md-12">
            <!-- Page title --> 
            <div class="page-title">
                <h2 class="text-right"><i class="fa fa-globe color"></i> Períodos</h2>
                <hr>
            </div>

            <!-- Este debería ser el espacio para los flashbags -->
            <?php if ($this->session->flashdata('mensaje') != FALSE) { echo $this->session->flashdata('mensaje'); } ?>

            <div class="panel panel-default">
                <div class="panel-heading">
                    <label class="control-label">Períodos Agregados</label>
                    <a type="button" class="btn btn-sm btn-success pull-right" href="<?php echo site_url('periodo/nuevo') ?>"><i class="fa fa-plus fa-fw"></i> Agregar Período</a>
                </div>
                <div class="panel-body">
                    <table id="dataTable" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th class="text-center">#</th>
                                <th>Nombre</th>
                                <th>Descripción</th>
                                <th>Desde</th>
                                <th>Hasta</th>
                                <th>Días</th>
                                <th>Opciones</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php if(sizeof($periodos) == 0){ ?>
                            <tr class="text-center">
                                <td colspan="7"> No ha agregado ninguna configuración sobre los ausentismos y reposos</td>
                            </tr>
                        <?php } ?>
                        <?php $index = 1; foreach ($periodos as $key): ?>
                            <tr>
                                <td class="text-center"><?php echo $index; $index++; ?></td>
                                <td><?php echo $key['nombre']; ?></td>
                                <td><?php echo $key['descripcion']; ?></td>
                                <td><?php echo $key['fecha_inicio']; ?></td>
                                <td><?php echo $key['fecha_fin']; ?></td>
                                <td><?php echo $key['cant_dias']; ?> días</td>
                                <td class="text-center">
                                    <!-- Single button -->
                                    <div class="btn-group">
                                        <button type="button" class="btn btn-default btn-sm dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <i class="fa fa-cogs"></i> Opciones <span class="caret"></span>
                                        </button>
                                        <ul class="dropdown-menu">
                                            <li><a href="<?php echo site_url('periodo/modificar/').'/'.$key['ID']; ?>"><i class="fa fa-edit fa-fw"></i> Editar Período</a></li>

                                            <li><a id="duplicar_confirmacion" href="<?php echo site_url('periodo/duplicar').'/'.$key['ID']; ?>"><i class="fa fa-files-o"></i> Duplicar Período</a></li>
                                            
                                            <li role="separator" class="divider"></li>

                                            <li><a id="eliminar_confirmacion" href="<?php echo site_url('periodo/eliminar').'/'.$key['ID']; ?>"><i class="fa fa-trash-o fa-fw"></i> Eliminar Período</a></li>
                                        </ul>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="clearfix"></div>

<script type="text/javascript">
    $(document).ready(function() {
        $('#dataTable').DataTable({
            "language": {
                "url": "<?php echo base_url() ?>assets/js/lenguaje_datatable/spanish.json"
            },
            'lengthChange' : false,
            'info' : true,
        });
    });

    $('[id="eliminar_confirmacion"]').click(function(e){
        e.preventDefault();
        var href = $(this).attr('href');
        swal({
            title: "¿Está seguro?",
            text: "Se eliminará este Período",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "Seguro",
            closeOnConfirm: false
        },
        function(isConfirm){ if(isConfirm){ window.location.href = href; } });
    });
</script>