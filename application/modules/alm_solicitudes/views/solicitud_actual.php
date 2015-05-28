<div class="mainy">
	<div class="row">
	     <div class="col-md-8 col-sm-8">
	     <!-- <div class="col-md-9 col-sm-9"> -->
	        <table class="table-striped">
	        	<tr>
	              <td><strong>Fecha: </strong></td>
	              <td><?php echo date("d/m/Y", strtotime($solicitud['fecha_gen'])) ?></td>
	           </tr>	
	           <tr>
	           		<td><strong>Dependencia: </strong></td>
	           		<td><?php echo $solicitud['dependencia'] ?></td>
	           </tr>
	           <tr>
	            	<td><strong>Generada por: </strong></td>
	            	<td><?php echo ucfirst($solicitud['nombre']).' '.ucfirst($solicitud['apellido']) ?></td>
	           </tr>
	           <tr>
	           		<td></td>
	              <td style="text-align: right"><strong>Email: </strong></td>
	              <td style="text-align: right"><?php echo $solicitud['email'] ?></td>
	           </tr>
	           <tr>
	           		<td></td>
	              <td style="text-align: right"><strong>Telefono: </strong></td>
	              <td style="text-align: right"><?php echo $solicitud['telefono'] ?></td>
	           </tr>
	        </table>
	    </div>
	    <div class="col-md-9 col-sm-9">
	    	<td style="text-align: right"><strong>Estado de la solicitud</strong> 
	              <?php switch($solicitud['status'])
	              {
	                case 'carrito':
	                  echo ' <span class="label label-danger">sin enviar</span></td>';
	                break;
	                case 'en_proceso':
	                  echo ' <span class="label label-warning">En Proceso</span></td>';
	                break;
	                case 'aprobada':
	                  echo ' <span class="label label-success">Aprobada</span></td>';
	                break;
	                case 'enviado':
	                  echo ' <span class="label label-warning">Enviado a Departamento</span></td>';
	                break;
	                case 'completado':
	                  echo ' <span class="label label-info">Solicitud Completada</span></td>';
	                break;
	              }?>
	        <table class="table table-hover table-bordered ">
	        	<thead>
					<tr>
						<th>Item</th>
						<th>Unidad</th>
						<th>Descripcion</th>
						<th>Cantidad Solicitada</th>
						<?php if($solicitud['status']!='carrito' && $solicitud['status']!='en_proceso'):?>
							<th>Cantidad Aprobada</th>
						<?php endif ?>
					</tr>
				</thead>
				<tbody>
					<?php foreach ($articulos as $key => $articulo) :?>
					<tr>
						<td><?php echo $key+1; ?></td>
						<td><?php echo $articulo['unidad'] ?></td>
						<td><?php echo $articulo['descripcion'] ?></td>
						<td><?php echo $articulo['cant'] ?></td>
						<?php if($solicitud['status']!='carrito' && $solicitud['status']!='en_proceso'):?>
							<td><?php echo $articulo['cant_aprob'] ?></td>
						<?php endif ?>
					</tr>
				<?php endforeach ?>
				</tbody>
	        </table>
	        <!-- <td><strong>Estado de la solicitud</strong> 
	              <?php switch($solicitud['status'])
	              {
	                case 'carrito':
	                  echo ' <span class="label label-danger">sin enviar</span></td>';
	                break;
	                case 'en_proceso':
	                  echo ' <span class="label label-warning">En Proceso</span></td>';
	                break;
	                case 'aprobada':
	                  echo ' <span class="label label-success">Aprobada</span></td>';
	                break;
	                case 'enviado':
	                  echo ' <span class="label label-warning">Enviado a Departamento</span></td>';
	                break;
	                case 'completado':
	                  echo ' <span class="label label-info">Solicitud Completada</span></td>';
	                break;
	              }?> -->
	   </div>
	</div>
</div>