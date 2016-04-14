<?php include_once(APPPATH.'modules/rhh_cargo/forms/formulario_agregar_cargo.php'); ?>
<div class="container">
	<div class="page-header text-center">
		<h1>Cargo - (Agregar|Modificar)</h1>
	</div>
	<div class="row">
		<?php include_once(APPPATH.'modules/rhh_ausentismo/views/menu.php'); ?>

		<div class="col-lg-9 col-sm-9 col-xs-12">
			<?php if ($this->session->flashdata('mensaje') != FALSE) { echo $this->session->flashdata('mensaje'); } ?>
			
			<?php echo form_open($action, $form); ?>
				<input type="hidden" name="ID" value="<?php if (isset($cargo)) { echo $cargo['ID']; } ?>"></input>
				<div class="col-lg-12 col-sm-12 col-xs-12">
					<div class="form-group">
						<label class="col-sm-3 control-label">Nombre</label>
						<?php if(isset($cargo)){ $nombre_edit = $cargo['nombre']; }else{ $nombre_edit = ''; } ?>
						<div class="col-sm-9"><?php echo form_input($nombre, $nombre_edit); ?></div>
					</div>

					<div class="form-group">
						<label class="col-sm-3 control-label">Descripción</label>
						<?php if(isset($cargo)){ $descripcion_edit = $cargo['descripcion']; }else{ $descripcion_edit = ''; } ?>
						<div class="col-sm-9"><?php echo form_input($descripcion, $descripcion_edit); ?></div>
					</div>
					
					<div class="row">
						<div class="col-lg-6 col-lg-offset-3">
							<button type="submit" class="btn btn-primary btn-block">
							<?php if(isset($cargo)){
								echo "Guardar Modificaciones";
							}else{
								echo "Guardar Nueva";
							}?>
							</button>
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
	});
</script>