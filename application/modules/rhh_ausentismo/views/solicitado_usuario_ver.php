<!-- <div class="row"> -->
	<div class="col-lg-6">
		<div class="panel panel-warning">
			<div class="panel-heading text-center">Detalles de su Solicitud</div>
			<table class="table table-bordered table-info">
				<tbody>
					<tr>
						<th>Fecha</th>
						<td><?php echo $solicitud['fecha_solicitud']; ?></td>
					</tr>
					<tr>
						<th>Nombre</th>
						<td><?php echo $solicitud['nombre'] ?></td>
					</tr>
					<tr>
						<th>Fecha Inicio</th>
						<td><?php echo $solicitud['fecha_inicio'] ?></td>
					</tr>
					<tr>
						<th>Fecha Final</th>
						<td><?php echo $solicitud['fecha_final'] ?></td>
					</tr>
					<tr>
						<th class="text-info">Estatus</th>
						<td><?php echo $solicitud['estatus']; ?></td>
					</tr>
				</tbody>
			</table>
		</div>
	</div>
	<div class="col-lg-6">
		<div class="panel panel-info">
			<div class="panel-heading text-center">Detalles del Ausentismo</div>
			<table class="table table-bordered none-margin-bottom">
				<tbody>
					<tr>
						<th>Tipo</th>
						<td colspan="3"><?php echo $ausentismo['tipo'] ?></td>
					</tr>
					<tr>
						<th>Máx Días</th>
						<td><?php echo $ausentismo['minimo_dias_permiso'] ?></td>
						<td><?php echo $ausentismo['tipo_dias'] ?></td>
					</tr>
					<tr>
						<th>Min Días</th>
						<td><?php echo $ausentismo['maximo_dias_permiso'] ?></td>
						<td><?php echo $ausentismo['tipo_dias'] ?></td>
					</tr>
					<tr>
						<th>Cant. Mensual</th>
						<td colspan="3"><?php echo $ausentismo['cantidad_maxima_mensual'] ?> veces</td>
					</tr>
					<tr>
						<?php
							$soportes = $ausentismo['soportes'];
							$soportes = explode(',', $soportes);
						?>
						<th>Soportes</th>
						<td colspan="3"><ul>
							<?php foreach ($soportes as $doc) { ?>
								<li><?php echo $doc ?></li>
							<?php } ?>
						</ul></td>
					</tr>
				</tbody>
			</table>
		</div>
	</div>
<!-- </div> -->