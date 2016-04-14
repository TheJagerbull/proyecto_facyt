<script src="<?php echo base_url() ?>assets/js/jquery-1.11.3.js"></script>
<script src="<?php echo base_url() ?>assets/js/sweet-alert.js" type="text/javascript"></script>

<style type="text/css">
    .head{ margin-top: 10px; margin-bottom: 10px; }
</style>

<div class="container">
    <div class="page-header text-center">
        <h1>Ausentismos - Agregados</h1>
    </div>
    <div class="row">
        <?php include_once(APPPATH.'modules/rhh_ausentismo/views/menu.php'); ?>
        <div class="col-lg-9 col-sm-9 col-xs-12">
        
            <div class="head">
                <a type="button" class="btn btn-primary" href="<?php echo site_url('ausentismo/configuracion') ?>"><i class="fa fa-plus fa-fw"></i> Agregar Ausentismo</a>
            </div>
        
            <?php if ($this->session->flashdata('mensaje') != FALSE) { echo $this->session->flashdata('mensaje'); } ?>

            <div class="panel panel-primary">
                <div class="panel-heading">Configuraciones de Ausentimos Agregadas</div>
            	<table class="table table-bordered table-striped">
            		<thead>
            			<tr>
                            <th class="text-center">#</th>
            				<th>Tipo</th>
            				<th>Nombre</th>
            				<th>Mín Días</th>
            				<th>Máx Días</th>
                            <th>Cant. Máx Mensual</th>
                            <th>Opciones</th>
            			</tr>
            		</thead>
            		<tbody>
                    <?php if(sizeof($ausentismos) == 0){ ?>
                        <tr class="text-center">
                            <td colspan="7"> No ha agregado ninguna configuración sobre los ausentismos y reposos</td>
                        </tr>
                    <?php } ?>
            		<?php $index = 1; foreach ($ausentismos as $key): ?>
            			<tr>
                            <td class="text-center"><?php echo $index; $index++; ?></td>
            				<td><?php echo $key['tipo']; ?></td>
            				<td><?php echo $key['nombre']; ?></td>
            				<td><?php echo $key['minimo_dias_permiso']; ?> días</td>
                            <td><?php echo $key['maximo_dias_permiso']; ?> días</td>
            				<td><?php echo $key['cantidad_maxima_mensual']; ?> veces</td>
                            <td class="text-center">
                                <a href="<?php echo site_url('ausentismo/configuracion/modificar/').'/'.$key['ID']; ?>" class="btn btn-primary btn-sm"><i class="fa fa-edit fa-fw"></i></a>
                                <a id="eliminar_confirmacion" href="<?php echo site_url('ausentismo/configuracion/eliminar/').'/'.$key['ID']; ?>" class="btn btn-danger btn-sm"><i class="fa fa-trash-o fa-fw"></i></a>
                            </td>
            			</tr>
            		<?php endforeach ?>
            		</tbody>
            	</table>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    $('[id="eliminar_confirmacion"]').click(function(e){
        e.preventDefault();
        var href = $(this).attr('href');
        swal({
            title: "¿Está seguro?",
            text: "Se eliminará este tipo de Ausentismo",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "Eliminar",
            closeOnConfirm: false
        },
        function(isConfirm){ if(isConfirm){ window.location.href = href; } });
    });
</script>