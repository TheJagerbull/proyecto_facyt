<table class="table table-bordered none-margin-bottom">
	<tbody>
		<tr>
			<th>Tipo</th>
			<td colspan="3"><?php echo $ausentismo['tipo'] ?></td>
		</tr>
		<tr>
			<th>Nombre</th>
			<td colspan="3"><?php echo $ausentismo['nombre'] ?></td>
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