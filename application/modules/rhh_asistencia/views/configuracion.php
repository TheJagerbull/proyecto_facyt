<div class="container">
    <div class="page-header text-center">
        <h1>Asistencia - Configuraciones</h1>
    </div>
    <div class="row">
        <?php include_once(APPPATH.'modules/rhh_ausentismo/views/menu.php'); ?>
        <div class="col-lg-9 col-sm-9 col-xs-12">
        	<?php if(isset($mensaje)){ echo $mensaje; } ?>

        	Hora Semanales que se debe cumplir.<br>
        	
        	<table class="table table-bordered">
        		<thead>
	        		<tr>
	        			<th>Cantidad de Horas Semanales</th>
	        			<th>Opciones</th>
	        		</tr>
        		</thead>
        		<tbody>
        			<?php foreach ($configuraciones as $con): ?>
        			<tr>
        				<td><?php echo $con->minimo_horas_ausentes_sem; ?></td>
        				<td><a href="<?php echo site_url('asistencia/configuracion/modificar/'.$con->ID.'/'.$con->minimo_horas_ausentes_sem); ?>" class="btn btn-primary"><i class="fa fa-pencil fa-fw"></i></a></td>
        			</tr>
        			<?php endforeach ?>
        		</tbody>
        	</table>
        	8 horas diarias de trabajo son 40 horas semanales
        </div>
    </div>
</div>