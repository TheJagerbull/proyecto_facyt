<?php include_once(APPPATH.'modules/rhh_cargo/forms/formulario_agregar_cargo.php'); ?>

<div class="mainy">
	<!-- Page title --> 
	<div class="page-title">
		<h2 class="text-right"><i class="fa fa-globe color"></i> Cargos</h2>
		<hr>
	</div>

	<!-- Page title -->
	<div class="row">
		<div class="col-md-12">

			<!-- Este debería ser el espacio para los flashbags -->
			<?php if ($this->session->flashdata('mensaje') != FALSE) { echo $this->session->flashdata('mensaje'); } ?>

			<div class="panel panel-default">
				<div class="panel-heading"><span class="negritas"><?php echo $titulo_panel ?></span></div>
				<div class="panel-body">
					<?php echo form_open($action, $form); ?>
						<input type="hidden" name="ID" value="<?php if (isset($cargo)) { echo $cargo['ID']; } ?>"></input>
						<div class="col-lg-12 col-sm-12 col-xs-12">
							<div class="form-group">
								<label class="col-sm-3 control-label">Código</label>
								<?php if(isset($cargo)){ $codigo_edit = $cargo['codigo']; }else{ $codigo_edit = ''; } ?>
								<div class="col-sm-9"><?php echo form_input($codigo, $codigo_edit); ?></div>
							</div>

							<div class="form-group">
								<label class="col-sm-3 control-label">Nombre</label>
								<?php if(isset($cargo)){ $nombre_edit = $cargo['nombre']; }else{ $nombre_edit = ''; } ?>
								<div class="col-sm-9"><?php echo form_input($nombre, $nombre_edit); ?></div>
							</div>

							<div class="form-group">
								<label class="col-sm-3 control-label">Tipo</label>
								<?php if(isset($cargo)){ $tipo_edit = $cargo['tipo']; }else{ $tipo_edit = ''; } ?>
								<div class="col-sm-9"><?php echo form_input($tipo, $tipo_edit); ?></div>
							</div>

							<div class="form-group">
								<label class="col-sm-3 control-label">Descripción</label>
								<?php if(isset($cargo)){ $descripcion_edit = $cargo['descripcion']; }else{ $descripcion_edit = ''; } ?>
								<div class="col-sm-9"><?php echo form_textarea($descripcion, $descripcion_edit); ?></div>
							</div>
							
							<div class="row">
								<div class="col-lg-4 col-lg-offset-3">
									<a class="btn btn-default btn-block" href="<?php echo site_url('cargo') ?>"><i class="fa fa-times fa-fw"></i> Cancelar</a>
								</div>
								<div class="col-lg-5">
									<button type="submit" class="btn btn-primary btn-block"><i class="fa fa-save fa-fw"></i>
									<?php if(isset($cargo)){ echo "Guardar Modificaciones"; }else{ echo "Guardar Cargo"; } ?>
									</button>
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