<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
<script>
$(document).ready(function(){
	$("#h1").hide();
    $("#button").click(function(){
        $("#p").toggle();
        $("#h1").toggle();
    });
});
</script>
<div class="mainy">
	<div class="row">
       <!-- Page title -->
       <div class="page-title">
          <h2 align="right" id="h1"><i class="fa fa-pencil color"></i> Solicitud <small>De Almacen</small></h2>
          <h2 align="right" id="p"><i class="fa fa-file color"></i> Solicitud <small>De Almacen</small></h2>
          <hr />
       </div>
       <!-- Page title -->
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
						<td>
							<div class="form-group">
	                            <div class="col-lg-6 col-md-10 col-sm-10">
	                              <input form="main" type="text" class="form-control" name="qt<?php echo $key; ?>">
	                            </div>
                            </div>
                        </td>
						<!-- <td><?php echo $articulo['cant'] ?></td> -->
						<?php if($solicitud['status']!='carrito' && $solicitud['status']!='en_proceso'):?>
							<td><?php echo $articulo['cant_aprob'] ?></td>
						<?php endif ?>
					</tr>
				<?php endforeach ?>
				</tbody>
	        </table>

       <h3 id="button">X</h3>
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