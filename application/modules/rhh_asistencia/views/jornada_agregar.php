<?php include_once(APPPATH.'modules/rhh_asistencia/forms/formulario_agregar_jornada.php'); ?>
<div class="container">
	<div class="page-header text-center">
		<h1>Asistencias - Jornadas - Agregar</h1>
	</div>
	<div class="row">
		<?php include_once(APPPATH.'modules/rhh_ausentismo/views/menu.php'); ?>

		<div class="col-lg-9 col-sm-9 col-xs-12">
			<?php if(isset($mensaje)){ echo $mensaje; } ?>
			<?php echo form_open('asistencia/jornada/agregar', $form); ?>
				<div class="col-lg-12 col-sm-12 col-xs-12">
					<div class="form-group">
						<label class="col-sm-3 control-label">Nombre</label>
						<?php //if(isset($form_data)){ $maxmen = $form_data['cantidad_maxima_mensual']; }else{ $maxmen = ''; } ?>
						<div class="col-sm-9"><?php echo form_input($nombre, null); ?></div>
					</div>

					<div class="form-group">
						<label class="col-sm-3 control-label">Hora Inicio</label>
						<div class="col-sm-9">
							<div class="row">
								<div class="col-sm-6"><?php echo form_input($hora_inicio, null);  ?></div>
								<div class="col-sm-6"><?php echo form_dropdown('ampm_inicio', $ampm_inicio, null, $ampm_inicio_attr); ?></div>
							</div>
						</div>
					</div>

					<div class="form-group">
						<label class="col-sm-3 control-label">Hora Fin</label>
						<div class="col-sm-9">
							<div class="row">
								<div class="col-sm-6"><?php echo form_input($hora_fin, null);  ?></div>
								<div class="col-sm-6"><?php echo form_dropdown('ampm_fin', $ampm_fin, null, $ampm_fin_attr); ?></div>
							</div>
						</div>
					</div>

					<div class="form-group">
						<label class="col-sm-3 control-label">Tolerancia</label>
						<div class="col-sm-7">
							<?php echo form_input($tolerancia, null); ?>
						</div>
						<div class="col-lg-2">horas</div>
					</div>

					<div class="form-group">
						<label class="col-sm-3 control-label">Tipo Jornada</label>
						<div class="col-sm-9">
							<?php echo form_dropdown('tipo', $tipo, null, $tipo_attr); ?>
							<small>Por definir si se toma de la base de datos o es una lista desplegable de elementos que no varia</small>
						</div>
					</div>

					<div class="form-group">
						<label class="col-lg-3 control-label">Total Horas</label>
						<div class="col-lg-7">
							<?php echo form_input($cantidad_horas_totales, null); ?>
						</div>
						<div class="col-lg-2">horas</div>
					</div>

					<div class="form-group">
						<label class="col-lg-3 control-label">Cantidad Horas Descanso</label>
						<div class="col-lg-7">
							<?php echo form_input($cantidad_horas_descanso, null); ?>
						</div>
						<div class="col-lg-2">horas</div>
					</div>

				</div>
				<div class="col-lg-9 col-sm-9 col-xs-9 col-lg-offset-3 col-sm-offset-3">
					<button type="submit" class="btn btn-primary"><i class="fa fa-plus fa-fw"></i> Agregar Jornada</button>
				</div>
			<?php echo form_close(); ?>
		</div>
	</div>
</div>

<script src="<?php echo base_url() ?>assets/js/jquery-1.11.3.js"></script>
<script type="text/javascript">
	$('document').ready(function(){
		//$('#hora_inicio').keyup(function(){ this.value = this.value.replace(/[:^\]/,''); });
	});
</script>