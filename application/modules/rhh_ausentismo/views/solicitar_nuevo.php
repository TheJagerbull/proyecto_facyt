<?php include_once(APPPATH.'modules/rhh_ausentismo/forms/formulario_solicitar_ausentismo.php'); ?>

<div class="mainy">
	<div class="row">
		<div class="col-md-12">
			<!-- Page title --> 
			<div class="page-title">
				<h2 class="text-right"><i class="fa fa-globe color"></i> Ausentismos</h2>
				<hr>
			</div>
			
			<!-- Este debería ser el espacio para los flashbags -->
			<?php if ($this->session->flashdata('mensaje') != FALSE) { echo $this->session->flashdata('mensaje'); } ?>

			<div class="panel panel-primary">
				<div class="panel-body">
					<?php echo form_open('ausentismo/solicitar/agregar', $form); ?>
						<div class="col-lg-12 col-sm-12 col-xs-12">
							<?php if(isset($form_data)){ $idtrabajador = $form_data['nombre']; }else{ $idtrabajador = ''; } ?>
							<?php echo form_input($id_trabajador, $idtrabajador); ?>
							<?php echo form_input($estatus); ?>

							<div class="form-group">
								<label class="col-sm-3 control-label">Tipo Ausentismo</label>
								<div class="col-sm-9">
									<?php if(isset($form_data)){ $tipo = $form_data['tipo']; }else{ $tipo = ''; } ?>
									<?php echo form_dropdown('tipo_ausentismo', $tipo_ausentismo, $tipo, $tipo_ausentismo_attr);?>
								</div>
							</div>

							<div id="form_lista_ausentismos" class="form-group hidden">
								<label for="lista_ausentismos" class="col-sm-3 control-label">Añadidos</label>
								<div class="col-sm-9">
									<select name="lista_ausentismos" class="form-control" id="lista_ausentismos">
										<option value="">Seleccione uno</option>
									</select>
								</div>
							</div>

							<!-- <div class="form-group">
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
							</div> -->
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
<script>
	$('document').ready(function(){
		$('#tipo_ausentismo').on("change", function(){
			$.ajax({
                url: 'obtener/tipo',
                type: "POST",
                data: { 
                    tipo: this.value },
                success: function(data, textStatus, xhr){
                	$("#lista_ausentismos").empty();
                	
                	if(data.length != 0){
	                	$('#form_lista_ausentismos').removeClass('hidden');
	                	$('#form_lista_ausentismos').focus();
	                	$("#lista_ausentismos")
	                		.append($("<option></option>")
	                		.attr("value", '').text('Selecciones uno'));

	                	for (var i = data.length - 1; i >= 0; i--) {
	                		$("#lista_ausentismos")
	                		.append($("<option></option>")
	                		.attr("value", data[i].ID).text(data[i].nombre));
	                	}
	                }else{
	                	$('#form_lista_ausentismos').addClass('hidden');
	                }
                }
            });
		});
	});
</script>