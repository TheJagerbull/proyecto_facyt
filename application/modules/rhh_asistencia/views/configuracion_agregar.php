<div class="mainy">
	<!-- Page title --> 
	<div class="page-title">
		<h2 class="text-right"><i class="fa fa-globe color"></i> Asistencia <small>configuraciones </small></h2>
		<hr>
	</div>

	<!-- Page title -->
	<div class="row">
		<div class="col-md-12">
			<!-- Este debería ser el espacio para los flashbags -->
			<?php if ($this->session->flashdata('mensaje') != FALSE) { echo $this->session->flashdata('mensaje'); } ?>
			<!-- Fin del espacio de los Flashbags -->

			<div class="panel panel-default">
				<div class="panel-heading"><i class="fa fa-pencil fa-fw color"></i>Agregar/Modificar</div>
				<div class="panel-body">
					<div id="mensaje-error" class='alert alert-danger text-center hidden' role='alert'><i class='fa fa-exclamation fa-2x pull-left'></i> Por favor intenta escribir algo.<br></div>

					<form class="form" method="POST" action="<?php echo site_url('asistencia/configuracion/verificar');?>" id="agregar_configuracion" name="agregar_configuracion">
						<input type="hidden" value="<?php if(isset($id)){ echo $id; } ?>" name="id"></input>
		            	<div class="form-group">
			            	<label class="col-sm-3 control-label">Cantidad de Horas Semanales de Trabajo</label>
			            	<div class="col-lg-9">
			            		<input type="text" value="<?php if(isset($cantidad)){ echo $cantidad; } ?>" autocomplete="off" id="cantidad" name="cantidad" class="form-control"></input>
			            	</div>
			            </div>
			            <div class="col-lg-9 col-sm-9 col-xs-9 col-lg-offset-3 col-sm-offset-3">
							<button type="submit" class="btn btn-primary pull-right"><i class="fa fa-save fa-fw"></i> Guardar Configuración</button>
						</div>
		            </form>
				</div>
			</div>
		</div>
	</div>
</div>
<div class="clearfix"></div>

<script src="<?php echo base_url() ?>assets/js/jquery-1.11.3.js"></script>
<script type="text/javascript">
	$('document').ready(function(){
		$('#cantidad').keyup(function(){ this.value = this.value.replace(/[^\d]/,''); $('#mensaje-error').addClass('hidden'); });

		$('#agregar_configuracion').submit(function(){
			var action = $('#agregar_configuracion').val();
			var cantidad = $('#cantidad').val();

			if (cantidad.length == 0) {
				$('#mensaje-error').removeClass('hidden');
				return false;
			}
		});
	});
</script>