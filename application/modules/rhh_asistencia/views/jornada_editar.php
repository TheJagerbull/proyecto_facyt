<?php include_once(APPPATH.'modules/rhh_asistencia/forms/formulario_agregar_jornada.php'); ?>
<div class="mainy">
	<!-- Page title -->
	<div class="row">
		<div class="col-md-12">

			<!-- Page title --> 
			<div class="page-title">
				<h2 class="text-right"><i class="fa fa-globe color"></i> Jornadas</h2>
				<hr>
			</div>

			<!-- Este debería ser el espacio para los flashbags -->
			<?php echo validation_errors(); ?>
			<?php echo $mensaje; ?>

			<div class="panel panel-default">
				<div class="panel-heading">
					<label class="control-label">Agregar una Nueva Jornada</label>
				</div>
				<div class="panel-body">
					<?php echo form_open($action, $form); ?>
						<div class="form-group">
							<label class="col-sm-3 control-label">Asociada al Cargo</label>
							<div class="col-sm-9">
							<?php if(isset($jornada)){ $cargo_edit = $jornada['id_cargo']; }else{ $cargo_edit = ''; } ?>
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
							<label class="col-sm-3 control-label">Cantidad Horas Descanso</label>
							<div class="col-sm-7">
							<?php if(isset($jornada)){ $cantidad_horas_descanso_edit = $jornada['cantidad_horas_descanso']; }else{ $cantidad_horas_descanso_edit = ''; } ?>
								<?php echo form_input($cantidad_horas_descanso, $cantidad_horas_descanso_edit); ?>
							</div>
							<div class="col-sm-2">horas</div>
						</div>

						<div class="form-group">
							<label class="col-sm-3 control-label">Días que aplica la Jornada</label>
							<div class="col-sm-9">
								<?php if(isset($jornada)){
									if($jornada['dias_jornada'] != ''){
										$dias_jornada_edit = unserialize($jornada['dias_jornada']);
									}
								} ?>
				                <fieldset id="fieldset">
				                <?php foreach ($semana as $dias): ?>
				                	<div class="checkbox checkbox-inline checkbox-success">
				                        <input <?php if(isset($dias_jornada_edit) && $dias_jornada_edit != ''){ if(in_array($dias[0], $dias_jornada_edit)){ echo "checked='true'"; }} ?> id="dias_jornada['<?php echo $dias[0]; ?>']" name="dias_jornada[]" value="<?php echo $dias[0]; ?>" type="checkbox">
				                        <label for="dias_jornada['<?php echo $dias[0]; ?>']"><?php echo $dias[1]; ?></label>
				                    </div>
				                <?php endforeach ?>
				                </fieldset>							
							</div>
						</div>
						
						<div class="row">
							<div class="col-sm-4 col-sm-offset-3">
								<a class="btn btn-default btn-block" href="<?php echo site_url('jornada') ?>"><i class="fa fa-times fa-fw"></i> Cancelar</a>
							</div>
							<div class="col-lg-4 col-sm-4 col-xs-4">
			                    <button type="submit" class="btn btn-primary btn-block">
								<i class="fa fa-save fa-fw"></i>
								<?php if(isset($jornada)){
									echo "Guardar Cambios";
								}else{
									echo "Guardar Jornada";
								}?>
								</button>
			                </div>
						</div>
					<?php echo form_close(); ?>
				</div>
			</div>
		</div>
	</div>
</div>
<div class="clearfix"></div>

<style type="text/css">
	.has-error{ background-color: #FFB0B0; }
	.checkbox { padding-left: 20px; }
	.checkbox label {
		display: inline-block;
		position: relative;
		padding-left: 5px; }
	.checkbox label::before {
		content: "";
		display: inline-block;
		position: absolute;
		width: 17px;
		height: 17px;
		left: 0;
		margin-left: -20px;
		border: 1px solid #cccccc;
		border-radius: 3px;
		background-color: #fff;
		-webkit-transition: border 0.15s ease-in-out, color 0.15s ease-in-out;
		-o-transition: border 0.15s ease-in-out, color 0.15s ease-in-out;
		transition: border 0.15s ease-in-out, color 0.15s ease-in-out; }
	.checkbox label::after {
		display: inline-block;
		position: absolute;
		width: 16px;
		height: 16px;
		left: 0;
		top: 0;
		margin-left: -20px;
		padding-left: 3px;
		padding-top: 1px;
		font-size: 11px;
		color: #555555; }
	.checkbox input[type="checkbox"] { opacity: 0; }
	.checkbox input[type="checkbox"]:focus + label::before {
		outline: thin dotted;
		outline: 5px auto -webkit-focus-ring-color;
		outline-offset: -2px; }
	.checkbox input[type="checkbox"]:checked + label::after {
		font-family: 'FontAwesome';
		content: "\f00c"; }
	.checkbox input[type="checkbox"]:disabled + label { opacity: 0.65; }
	.checkbox input[type="checkbox"]:disabled + label::before {
		background-color: #eeeeee;
		cursor: not-allowed; }
	.checkbox.checkbox-circle label::before {
		border-radius: 50%; }
	.checkbox.checkbox-inline {
		margin-top: 0; }
	.checkbox-success input[type="checkbox"]:checked + label::before {
		background-color: #5cb85c;
		border-color: #5cb85c; }
	.checkbox-success input[type="checkbox"]:checked + label::after { color: #fff; }
</style>

<script src="<?php echo base_url() ?>assets/js/jquery-1.11.3.js"></script>
<script type="text/javascript">
	function todos_tienen_valor(){
		var boolean = false;
		var x = document.getElementsByName("dias_jornada[]");
		for(var i = 0; i < x.length; i++){
			e = x[i];
			if (e.checked){ boolean = true; }
		}
		return boolean;
	}

	function validaciones()
	{
		var hora = new RegExp('^(01|02|03|04|05|06|07|08|09|10|11|12):[0-5][0-9]$');
		var verdad = true;

		$hora_inicio = $('#hora_inicio');
		$hora_fin = $('#hora_fin');
		$tolerancia = $('#tolerancia');
		$cantidad_horas_descanso = $('#cantidad_horas_descanso');
		$dias_jornada = $('#fieldset');	

		if(!todos_tienen_valor()){
			$dias_jornada.addClass('has-error');
			verdad = false;
		}else{
			$dias_jornada.removeClass('has-error');
		}

		if(!hora.test($hora_inicio.val())){
			$hora_inicio.addClass('has-error');
			verdad = false;
		}else{
			$hora_inicio.removeClass('has-error');
		}

		if(!hora.test($hora_fin.val())){
			$hora_fin.addClass('has-error');
			verdad = false;
		}else{
			$hora_fin.removeClass('has-error');
		}

		if(0 > $tolerancia.val() || $tolerancia.val() > 24 || (!$.isNumeric($tolerancia.val()))){
			$tolerancia.addClass('has-error');
			verdad = false;
		}else{
			$tolerancia.removeClass('has-error');
		}

		if(0 > $cantidad_horas_descanso.val() || $cantidad_horas_descanso.val() > 24 ||(!$.isNumeric($cantidad_horas_descanso.val()))){
			$cantidad_horas_descanso.addClass('has-error');
			verdad = false;
		}else{
			$cantidad_horas_descanso.removeClass('has-error');
		}

		return verdad;
	}
</script>