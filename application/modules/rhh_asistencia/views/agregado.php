<style type="text/css">
	h3{ margin: 0px; }
</style>
<head>
	<meta charset="utf-8">
</head>
<div class="container">
	<div class="page-header text-center">
		<h1>Bienvenido Al Control de Asistencia</h1>
	</div>
	<div class="col-lg-12 col-sm-12 col-xs-12">
		<div class="col-lg-8 col-sm-9 col-xs-12 center">
			<?php if ($this->session->flashdata('mensaje') != FALSE) { echo $this->session->flashdata('mensaje'); } ?>
		</div>
		<div class="col-lg-8 col-sm-9 col-xs-12 center">
			<?php if(isset($persona)) { ?>
			<div class="row">
				<div class="col-lg-4">
					<div class="panel panel-primary">
						<div class="panel-heading">Datos Personales <i class="fa fa-user fa-fw pull-right" style="margin-top: 5px;"></i></div>
						<table class="table table-bordered">
							<tr class="text-center">
								<td><?php echo $persona->nombre.' '.$persona->apellido; ?></td>
							</tr>
							<tr class="text-center">
								<td><h3><?php echo number_format($persona->id_usuario); ?></h3></td>
							</tr>
						</table>
					</div>
				</div>
				<div class="col-lg-8">
					<div class="panel panel-primary">
						<?php 
							$dias = array("Domingo","Lunes","Martes","Miércoles","Jueves","Viernes","Sábado");
							$meses = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
						?>
						<div class="panel-heading">Asistencia del día <?php echo $dias[date('w')].", ".date('d')." de ".$meses[date('n')-1]. " ".date('Y'); ?> <i class="fa fa-calendar fa-fw pull-right" style="margin-top: 5px;"></i></div>
						<table class="table table-bordered">
							<tr>
								<th class="text-center">Hora Entrada:</th>
								<th class="text-center">Hora Salida:</th>
							</tr>
							<?php foreach ($asistencias as $entrada){ ?>
								<tr class="text-center">
									<td><h3><?php echo date('h:i a', strtotime($entrada->hora_entrada)); ?></h3></td>
									<td><h3><?php if($entrada->hora_salida == '00:00:00'){ echo "No marcado salida"; }else{ echo date('h:i a', strtotime($entrada->hora_salida)); } ?></h3></td>
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
				<a href="#" id="timer" class="button"></a> o <a href="<?php echo site_url('asistencia/agregar') ?>">regresar ahora.</a>
			</p>
		</div>
	</div>
</div>
<script type="text/javascript">
	var downloadButton = document.getElementById("timer");
	//var counter = 7; //valor optimo mientras se enciende el monitor mas viejo de las oficionas XD
	var counter = 10; // para poder verificar lo que estoy haciendo
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