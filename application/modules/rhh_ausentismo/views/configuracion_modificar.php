<?php include_once(APPPATH.'modules/rhh_ausentismo/forms/formulario_agregar_ausentismo.php'); ?>
<div class="container">
	<div class="page-header text-center">
		<h1>Ausentismo - Configuraciones - <?php echo $form_data['nombre']; ?></h1>
	</div>
	<div class="row">
		<?php include_once(APPPATH.'modules/rhh_ausentismo/views/menu.php'); ?>
		<div class="col-lg-9 col-sm-9 col-xs-12">
			<?php if ($this->session->flashdata('mensaje') != FALSE) { echo $this->session->flashdata('mensaje'); } ?>
			
			<?php echo form_open('ausentismo/configuracion/actualizar/'.$form_data['ID'], $form); ?>
				<div class="col-lg-12 col-sm-12 col-xs-12">
					<div class="form-group">
						<label class="col-sm-3 control-label">Tipo Ausentismo:</label>
						<div class="col-sm-9">
							<?php if(isset($form_data)){ $tipo = strtolower($form_data['tipo']); }else{ $tipo = ''; } ?>
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
				</div>
				<div class="col-lg-9 col-sm-9 col-xs-9 col-lg-offset-3 col-sm-offset-3">
					<div class="row">
						<div class="col-lg-6"><button type="submit" class="btn btn-success btn-block"><i class="fa fa-plus fa-fw"></i> Guardar Cambios</button></div>
						<div class="col-lg-6"><a href="<?php echo site_url('ausentismo/configuracion/eliminar/').'/'.$form_data['ID']; ?>" class="btn btn-danger btn-block"><i class="fa fa-check fa-fw"></i> Eliminar Ausentismo</a></div>
					</div>
				</div>
			<?php echo form_close(); ?>
		</div>
	</div>
</div>
<script src="<?php echo base_url() ?>assets/js/jquery-1.11.3.js"></script>
<script type="text/javascript">
	$('document').ready(function(){
		$('#min_dias').keyup(function(){ this.value = this.value.replace(/[^\d]/,''); });
		$('#max_dias').keyup(function(){ this.value = this.value.replace(/[^\d]/,''); });
		$('#max_mensual').keyup(function(){ this.value = this.value.replace(/[^\d]/,''); });
	});
</script>