<style type="text/css">
	h3{ margin: 0px; }
</style>
<div class="container">
	<div class="page-header text-center">
		<h1>Bienvenido Al Control de Asistencia</h1>
	</div>
	<div class="col-lg-12 col-sm-12 col-xs-12">
		<div class="col-lg-8 col-sm-9 col-xs-12 center">
			<?php echo $mensaje; ?>
		</div>
		<div class="col-lg-8 col-sm-9 col-xs-12 center">
			<?php if(isset($persona)) { ?>
			<div class="row">
				<div class="col-lg-4">
					<div class="panel panel-info">
						<div class="panel-heading">Datos Personales</div>
						<table class="table table-bordered">
							<tr>
								<td><h3><?php echo $persona->nombre.' '.$persona->apellido; ?></h3></td>
							</tr>
							<tr>
								<td><h3><?php echo $persona->id_usuario; ?></h3></td>
							</tr>
						</table>
					</div>
				</div>
				<div class="col-lg-8">
					<div class="panel panel-info">
						<div class="panel-heading">Entradas en la Asistencia del día <?php echo date('l, j \\d\\e F Y'); ?></div>
						<table class="table table-bordered">
							<tr>
								<th class="text-center">#</th>
								<th class="text-center">Hora Entrada:</th>
								<th class="text-center">Hora Salida:</th>
							</tr>
							<?php foreach ($asistencias as $entrada){ ?>
								<tr class="text-center">
									<td>i</td>
									<td><?php echo $entrada->hora_entrada; ?></td>
									<td><?php if($entrada->hora_salida == '00:00:00'){ echo "No marcado salida"; }else{ echo $entrada->hora_salida; } ?></td>
								</tr>
							<?php } ?>
						</table>
					</div>
				</div>
			</div>
			<?php } ?>
		</div>
		<div class="col-lg-8 col-sm-9 col-xs-12 center">
			<p class="text-center text-info">
				<a href="#" id="timer" class="button"></a> o <a href="<?php echo site_url('asistencia/agregar') ?>">regrese ya.</a>
			</p>
		</div>
	</div>
</div>
<script type="text/javascript">
	var downloadButton = document.getElementById("timer");
	var counter = 10;
	var newElement = document.createElement("p");
	newElement.innerHTML = "Regresará a la página anterior en 10 segundos.";
	var id;

	downloadButton.parentNode.replaceChild(newElement, downloadButton);

	id = setInterval(function() {
	    counter--;
	    if(counter < 1) {
	        window.location.replace("agregar");
	    } else {
	        newElement.innerHTML = "Regresará a la página anterior en " + counter.toString() + " segundos.";
	    }
	}, 1000);
</script>