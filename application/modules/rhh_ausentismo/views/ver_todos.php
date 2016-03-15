<div class="container">
    <div class="page-header text-center">
        <h1>Ausentismos - Agregados</h1>
    </div>
    <div class="row">
        <?php include_once(APPPATH.'modules/rhh_ausentismo/views/menu.php'); ?>
        <div class="col-lg-9 col-sm-9 col-xs-12">
            <div class="panel panel-primary">
                <div class="panel-heading">Configuraciones de Ausentimos Agregadas</div>
                <!--div class="panel-body"-->
                	<?php //var_dump($ausentismos); ?>
                	<table class="table table-bordered table-striped">
                		<thead>
                			<tr>
                				<th>Tipo</th>
                				<th>Nombre</th>
                				<th>Máx Días</th>
                				<th>Mín Días</th>
                				<th>Cant. Máx Mensual</th>
                			</tr>
                		</thead>
                		<tbody>
                		<?php foreach ($ausentismos as $key): ?>
                			<tr>
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