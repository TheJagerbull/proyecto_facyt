<?php include_once(APPPATH.'modules/rhh_ausentismo/forms/formulario_agregar_ausentismo.php'); ?>

<div class="mainy">
	<div class="row">
		<div class="col-md-12">
			<!-- Page title --> 
			<div class="page-title">
				<h2 class="text-right"><i class="fa fa-globe color"></i> Ausentismos <small>configuraciones</small></h2>
				<hr>
			</div>
			
			<!-- Este debería ser el espacio para los flashbags -->
			<?php if ($this->session->flashdata('mensaje') != FALSE) { echo $this->session->flashdata('mensaje'); } ?>

			<div class="panel panel-default">
				<div class="panel-heading negritas">Nueva Configuración</div>
				<div class="panel-body">
					<?php echo form_open('ausentismo/configuracion/verificar', $form); ?>
						<div class="col-lg-12 col-sm-12 col-xs-12">
							<div class="form-group">
								<label class="col-sm-3 control-label">Tipo Ausentismo:</label>
								<div class="col-sm-9">
									<?php if(isset($form_data)){ $tipo = $form_data['tipo']; }else{ $tipo = ''; } ?>
									<?php echo form_dropdown('tipo_ausentismo', $tipo_ausentismo, $tipo, $tipo_ausentismo_attr);?>
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-3 control-label">Nombre</label>
								<?php if(isset($form_data)){ $nom = $form_data['nombre']; }else{ $nom = ''; } ?>
								<div class="col-sm-9"><?php echo form_input($nombre, $nom); ?></div>
							</div>
							<div class="form-group">
								<label class="col-sm-3 control-label">Minimo Días</label>
								<?php if(isset($form_data)){ $min = $form_data['minimo_dias_permiso']; }else{ $min = ''; } ?>
								<div class="col-sm-9"><?php echo form_input($min_dias, $min); ?></div>
							</div>
							<div class="form-group">
								<label class="col-sm-3 control-label">Máximo Días</label>
								<?php if(isset($form_data)){ $max = $form_data['maximo_dias_permiso']; }else{ $max = ''; } ?>
								<div class="col-sm-9"><?php echo form_input($max_dias, $max); ?></div>
							</div>
							<div class="form-group">
								<label class="col-sm-3 control-label">Máximo Mensual</label>
								<?php if(isset($form_data)){ $maxmen = $form_data['cantidad_maxima_mensual']; }else{ $maxmen = ''; } ?>
								<div class="col-sm-9"><?php echo form_input($max_mensual, $maxmen); ?></div>
							</div>
							<div class="form-group">
								<label class="col-sm-3 control-label">Tipo Días:</label>
								<div class="col-sm-9">
									<?php if(isset($form_data)){ $tipodias = $form_data['tipo_dias']; }else{ $tipodias = ''; } ?>
									<?php echo form_dropdown('tipo_dias', $tipo_dias, $tipodias, $tipo_dias_attr);?>
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-3 control-label">
									Soportes Requeridos
									<p class="text-xs small text-info">Separe los elementos con comas (,)</p>
								</label>
								<?php if(isset($form_data)){ $soportes = $form_data['soportes']; }else{ $soportes = ''; } ?>
								<div class="col-sm-9"><?php echo form_textarea($soportes_form, $soportes); ?></div>
							</div>
						</div>
						<div class="col-lg-9 col-sm-9 col-xs-9 col-lg-offset-3 col-sm-offset-3">
							<div class="row">
								<div class="col-lg-6">
									<?php echo anchor('ausentismo', '<i class="fa fa-times fa-fw"></i> Cancelar', array('class' => 'btn btn-default btn-block')) ?>
								</div>
								<div class="col-lg-6">
									<button type="submit" class="btn btn-primary btn-block"><i class="fa fa-save fa-fw"></i> Agregar Ausentismo</button>
								</div>
							</div>
						</div>
					<?php echo form_close(); ?>
				</div>
			</div>
		</div>
	</div>
</div>
<div class="clearfix"></div>

<script src="<?php echo base_url() ?>assets/js/jquery-1.11.3.js"></script>
<script type="text/javascript">
	$('document').ready(function(){
		$('#min_dias').keypress(function(){ this.value = this.value.replace(/[^\d]/,''); });
		$('#min_dias').keyup(function(){ this.value = this.value.replace(/[^\d]/,''); });
		$('#max_dias').keypress(function(){ this.value = this.value.replace(/[^\d]/,''); });
		$('#max_dias').keyup(function(){ this.value = this.value.replace(/[^\d]/,''); });
		$('#max_mensual').keypress(function(){ this.value = this.value.replace(/[^\d]/,''); });
		$('#max_mensual').keyup(function(){ this.value = this.value.replace(/[^\d]/,''); });
	});
</script>