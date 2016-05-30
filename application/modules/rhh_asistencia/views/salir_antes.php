<style type="text/css">
	h3{ margin: 0px; }
	.negritas { font-weight: bold; }
</style>
<head>
	<meta charset="utf-8">
</head>
<div class="container">
	<div class="page-header text-center">
		<h1>Atención</h1>
	</div>
	<div class="col-lg-12 col-sm-12 col-xs-12">
		<div class="col-lg-8 col-sm-9 col-xs-12 center">
			<?php if ($this->session->flashdata('mensaje') != FALSE) { echo $this->session->flashdata('mensaje'); } ?>
		</div>
		<div class="col-lg-8 col-sm-9 col-xs-12 center">
			<h3>
			<p class="negritas text-center">¿Desea agregar definitivamente esta salida al registro?</p>
			<p class="text-info">
			Esto guardará la hora de salida como la actual y genenará una nota de salida indicando la diferencia de tiempo respecto a su salida.
			</h3></p><br>
		</div>
		<div class="col-lg-8 col-sm-9 col-xs-12 center">
			<?php 
			$form = array(
				'id' 	=> 'rhh_asistencia_salir_antes',
				'name'  => 'rhh_asistencia_salir_antes',
				'class' => 'form-horizontal',
			);
			echo form_open('asistencia/salir_antes_guardar', $form);
			?>
			
			<input type="text" name="id_asistencia" value="<?php echo $this->session->flashdata('id_asistencia'); ?>">
			<input type="text" name="cedula" value="<?php echo $this->session->flashdata('cedula') ?>">
			<input type="text" name="retraso" value="<?php echo $this->session->flashdata('retraso') ?>">
			<input type="text" name="hora_salida" value="<?php echo $this->session->flashdata('hora_salida') ?>">

			<div class="row">
				<div class="col-lg-6">
					<button type="submit" class="btn btn-default btn-block btn-lg"><i class="fa fa-times fa-fw"></i> Cancelar</button>
				</div>
				<div class="col-lg-6">
					<button type="submit" class="btn btn-success btn-block btn-lg"><i class="fa fa-plus fa-fw"></i> Marcar Salida</button>
				</div>
			</div>
			<?php echo form_close(); ?>
		</div>
	</div>
</div>