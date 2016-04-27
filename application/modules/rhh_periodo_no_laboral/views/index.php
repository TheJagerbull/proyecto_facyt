<script src="<?php echo base_url() ?>assets/js/jquery-1.11.3.js"></script>
<script src="<?php echo base_url() ?>assets/js/sweet-alert.js" type="text/javascript"></script>

<style type="text/css">
    .head{ margin-top: 10px; margin-bottom: 10px; }
</style>

<div class="container">
    <div class="page-header text-center">
        <h1>Lista de Periodos Agregados</h1>
    </div>
    <div class="row">
        <?php include_once(APPPATH.'modules/rhh_ausentismo/views/menu.php'); ?>
        <div class="col-lg-9 col-sm-9 col-xs-12">
        
            <div class="head">
                <a type="button" class="btn btn-primary" href="<?php echo site_url('periodo-no-laboral/nuevo') ?>"><i class="fa fa-plus fa-fw"></i> Agregar Periodo No Laborable</a>
            </div>
        
            <?php if ($this->session->flashdata('mensaje') != FALSE) { echo $this->session->flashdata('mensaje'); } ?>

            <div class="panel panel-primary">
                <div class="panel-heading">Lista de Periodos Agregados</div>
            	<table class="table table-bordered table-striped">
            		<thead>
            			<tr>
                            <th class="text-center">#</th>
            				<th>Nombre</th>
                            <th>Descripción</th>
                            <th>Desde</th>
            				<th>Hasta</th>
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
                            <td class="text-center">
                                <a href="<?php echo site_url('periodo-no-laboral/modificar/').'/'.$key['ID']; ?>" class="btn btn-primary btn-sm"><i class="fa fa-edit fa-fw"></i></a>
                                <a id="eliminar_confirmacion" href="<?php echo site_url('periodo-no-laboral/eliminar').'/'.$key['ID']; ?>" class="btn btn-danger btn-sm"><i class="fa fa-trash-o fa-fw"></i></a>
                            </td>
            			</tr>
            		<?php endforeach ?>
            		</tbody>
            	</table>
            </div>
        </div>
        <div class="col-lg-9 text-info">
            <p>Falta Agregar Función para Duplicar los Periodos no laborales, permitiendo elegir el perido para el cual quiero realizar el duplicado, como pre-condición el periodo tiene   que estar creado.</p>
        </div>
    </div>
</div>

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