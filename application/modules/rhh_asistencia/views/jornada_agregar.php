<?php include_once(APPPATH.'modules/rhh_asistencia/forms/formulario_agregar_jornada.php'); ?>
<div class="container">
	<div class="page-header text-center">
		<h1>Asistencias - Jornada - (Agregar|Modificar)</h1>
	</div>
	<div class="row">
		<?php include_once(APPPATH.'modules/rhh_ausentismo/views/menu.php'); ?>

		<div class="col-lg-9 col-sm-9 col-xs-12">
			<?php if ($this->session->flashdata('mensaje') != FALSE) { echo $this->session->flashdata('mensaje'); } ?>
			
			<?php echo form_open($action, $form); ?>
				<input type="hidden" name="ID" value="<?php if (isset($jornada)) { echo $jornada['ID']; } ?>"></input>
				<div class="col-lg-12 col-sm-12 col-xs-12">

					<div class="form-group">
						<label class="col-sm-3 control-label">Asociada al Cargo</label>
						<div class="col-sm-9">
						<?php if(isset($jornada)){ $cargo_edit = $jornada['cargo']; }else{ $cargo_edit = ''; } ?>
							<?php echo form_dropdown('cargo', $cargo, $cargo_edit, $cargo_attr); ?>
						</div>
					</div>

					<div class="form-group">
						<label class="col-sm-3 control-label">Hora Inicio</label>
						
						<div class="col-sm-9">
							<div class="row">
								<div class="col-sm-6">
								<?php if(isset($jornada)){
									$hora_inicio_edit = new DateTime($jornada['hora_inicio']);
									echo form_input($hora_inicio, $hora_inicio_edit->format('h:i'));
								}else{
									echo form_input($hora_inicio, null);
								} ?>
								</div>
								<div class="col-sm-6">
								<?php $d = new DateTime($jornada['hora_inicio']); ?>
								<?php echo form_dropdown('ampm_inicio', $ampm_inicio, $d->format('a'), $ampm_inicio_attr); ?></div>
							</div>
						</div>
					</div>

					<div class="form-group">
						<label class="col-sm-3 control-label">Hora Fin</label>
						<div class="col-sm-9">
							<div class="row">
								<div class="col-sm-6">
								<?php if(isset($jornada)){
									$hora_fin_edit = new DateTime($jornada['hora_fin']);
									echo form_input($hora_fin, $hora_fin_edit->format('h:i'));
								}else{
									echo form_input($hora_fin, null);
								} ?>
								</div>
								<?php $d = new DateTime($jornada['hora_fin']); ?>
								<div class="col-sm-6"><?php echo form_dropdown('ampm_fin', $ampm_fin, $d->format('a'), $ampm_fin_attr); ?></div>
							</div>
						</div>
					</div>

					<div class="form-group">
						<label class="col-sm-3 control-label">Tolerancia</label>
						<div class="col-sm-7">
							<?php if(isset($jornada)){ $tolerancia_edit = $jornada['tolerancia']; }else{ $tolerancia_edit = ''; } ?>
							<?php echo form_input($tolerancia, $tolerancia_edit); ?>
						</div>
						<div class="col-lg-2">horas</div>
					</div>

					<div class="form-group">
						<label class="col-sm-3 control-label">Tipo Jornada</label>
						<div class="col-sm-9">
						<?php if(isset($jornada)){ $tipo_edit = $jornada['tipo']; }else{ $tipo_edit = ''; } ?>
							<?php echo form_dropdown('tipo', $tipo, $tipo_edit, $tipo_attr); ?>
							<small>Por definir si se toma de la base de datos o es una lista desplegable de elementos que no varia</small>
						</div>
					</div>

					<div class="form-group">
						<label class="col-lg-3 control-label">Cantidad Horas Descanso</label>
						<div class="col-lg-7">
						<?php if(isset($jornada)){ $cantidad_horas_descanso_edit = $jornada['cantidad_horas_descanso']; }else{ $cantidad_horas_descanso_edit = ''; } ?>
							<?php echo form_input($cantidad_horas_descanso, $cantidad_horas_descanso_edit); ?>
						</div>
						<div class="col-lg-2">horas</div>
					</div>
					
					<div class="row">
						<div class="col-lg-4 col-lg-offset-3">
							<button type="submit" class="btn btn-primary btn-block">
							<i class="fa fa-save fa-fw"></i>
							<?php if(isset($jornada)){
								echo "Guardar Cambios";
							}else{
								echo "Guardar Jornada";
							}?>
							</button>
						</div>
						<div class="col-lg-4 col-sm-4 col-xs-4">
		                    <a class="btn btn-default btn-block" href="<?php echo site_url('asistencia/jornada') ?>"><i class="fa fa-th-list fa-fw"></i> Cancelar</a>
		                </div>
					</div>
				</div>
			<?php echo form_close(); ?>
		</div>
	</div>
</div>

<script src="<?php echo base_url() ?>assets/js/jquery-1.11.3.js"></script>
<script type="text/javascript">
	$('document').ready(function(){
		$('#tolerancia').keyup(function(){ this.value = this.value.replace(/[^\d]/,''); });
		$('#cantidad_horas_totales').keyup(function(){ this.value = this.value.replace(/[^\d]/,''); });
	});
</script>