<?php include_once(APPPATH.'modules/rhh_asistencia/forms/formulario_agregar_asistencia.php'); ?>
<style type="text/css">
	.alert{ padding: 7px !important; margin-top: 8px; }
	.panel-heading{ padding: 5px; }
	.i-pull { margin-top: 5px; }
	.btn-lg{ height: 44px !important; }
</style>
<div class="container">
	
	<div class="col-lg-9 center">
		<div class="page-header text-center">
			<h1>Bienvenido Al Control de Asistencia</h1>
		</div>

		<div class="row">
			<div class="col-lg-12 col-sm-12 col-xs-12">
				<div id="mensaje-a-esconder">
					<?php if ($this->session->flashdata('mensaje') != FALSE) { echo $this->session->flashdata('mensaje'); } ?>
				</div>
				<div id="numeros" class="alert alert-danger hidden"><i class="fa fa-exclamation fa-fw"></i> <b>Su cédula tiene pocos digitos.</b></div>
				<div id="vacio" class="alert alert-danger hidden"><i class="fa fa-exclamation fa-fw"></i> <b>Por favor, escriba una cédula.</b></div>
			</div>
		</div>
		<div class="row">
			<div class="col-lg-6 col-sm-6 col-xs-6">
				<div class="panel panel-primary">
					<?php 
					$dias = array("Domingo","Lunes","Martes","Miércoles","Jueves","Viernes","Sábado");
					$meses = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
					?>
					<div class="panel-heading text-center">Fecha <i class="fa fa-calendar fa-fw i-pull pull-right"></i></div>
					<div class="panel-body text-center"><h1><?php echo $dias[date('w')].", ".date('d')." de ".$meses[date('n')-1]. " ".date('Y'); ?></h1></div>
				</div>
			</div>
			<div class="col-lg-6 col-sm-6 col-xs-6">
				<div class="panel panel-primary">
					<div class="panel-heading text-center">Hora <i class="fa fa-clock-o fa-fw i-pull pull-right"></i></div>
					<div class="panel-body text-center"><h1><div id="time"></div></h1></div>
				</div>
			</div>
		</div>
		<?php echo form_open('asistencia/verificar', $form); ?>
		<div class="row">
			<div class="col-lg-8 col-sm-8 col-xs-8">
				<div class="input-group input-group-lg">
					<span class="input-group-addon" id="sizing-addon1">Cédula</span>
					<?php echo form_input($cedula,'',"class='form-control' placeholder='cédula de identidad' autocomplete='on'");?>
				</div>
			</div>
			<div class="col-lg-4 col-sm-4 col-xs-4">
				<button type="submit" class="btn btn-primary btn-block btn-lg"><i class="fa fa-plus fa-fw"></i> Agregar</button>
			</div>
		</div>
		<?php echo form_close(); ?>
	</div>
</div>
<script src="<?php echo base_url() ?>assets/js/jquery-1.11.3.js"></script>
<script type="text/javascript">
	$('document').ready(function(){
		$('#cedula').focus();
		setTimeout(function() { $("#mensaje-a-esconder").fadeOut('slow'); }, 6500);

		$('#cedula').keypress(function(){ 
			this.value = this.value.replace(/[^\d]/,''); 
			$('#vacio').addClass('hidden');
			$('#numeros').addClass('hidden');
		});

		$('#cedula').keyup(function(){ 
			this.value = this.value.replace(/[^\d]/,'');
		});

		$('#rhh_asistencia_form_agregar').submit(function(){
			var value = $('#cedula').val();
			var text = $('#cedula').val().length;
			if (value == '') { $('#vacio').removeClass('hidden'); event.preventDefault(); }
			if (text < 5 && text != 0) { $('#numeros').removeClass('hidden'); event.preventDefault(); }
		});
	});
</script>
<script>
	var ampm, hours, minutes, seconds, humanTime, clock, rightNow, nowMS;
	var serverTime = new Date(<?php echo time() * 1000 ?>);
	function startInterval(){   setInterval('updateTime();', 1000);  }
	startInterval();//start it right away
	function updateTime(){
		nowMS = serverTime.getTime();
		nowMS += 1000;
		serverTime.setTime(nowMS);
		rightNow = serverTime;
		
		if (rightNow.getUTCHours() >= 0 && rightNow.getUTCHours() < 4)
			hours = (20 + rightNow.getUTCHours()) % 12;
		else
			hours = (rightNow.getUTCHours() - 4) % 12;

		minutes = rightNow.getUTCMinutes();
		seconds = rightNow.getUTCSeconds();
		if (rightNow.getUTCHours() >= 0 && rightNow.getUTCHours()-4 < 12) { ampm = 'am' }else{ ampm = 'pm' }

		hours = hours < 10 ? '0'+hours : hours;
		minutes = minutes < 10 ? '0'+minutes : minutes;
		seconds = seconds < 10 ? '0'+seconds : seconds;
		
		humanTime = hours + ':' + minutes + ':' + seconds + ' ' + ampm;

		clock = document.getElementById('time');
		if(clock){ clock.innerHTML = humanTime; }
	} 
</script>