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
                <a type="button" class="btn btn-primary" href="<?php echo site_url('ausentismo/configuracion') ?>"><i class="fa fa-plus fa-fw"></i> Ausentismos Agregar</a>
            </div>
        
            <div class="panel panel-primary">
                <div class="panel-heading">Configuraciones de Ausentimos Agregadas</div>
                <!--div class="panel-body"-->
                	<?php //var_dump($ausentismos); ?>
                	<table class="table table-bordered table-striped">
                		<thead>
                			<tr>
                                <th class="text-center">#</th>
                				<th>Tipo</th>
                				<th>Nombre</th>
                				<th>Máx Días</th>
                				<th>Mín Días</th>
                				<th>Cant. Máx Mensual</th>
                			</tr>
                		</thead>
                		<tbody>
                		<?php $index = 1; foreach ($ausentismos as $key): ?>
                			<tr>
                                <td class="text-center"><?php echo $index; $index++; ?></td>
                				<td><?php echo $key->tipo; ?></td>
                				<td><?php echo $key->nombre; ?></td>
                				<td><?php echo $key->maximo_dias_permiso; ?> días</td>
                				<td><?php echo $key->minimo_dias_permiso; ?> días</td>
                				<td><?php echo $key->cantidad_maxima_mensual; ?> veces</td>
                			</tr>
                		<?php endforeach ?>
                		</tbody>
                	</table>
                <!--/div-->
            </div>
        </div>
    </div>
</div>