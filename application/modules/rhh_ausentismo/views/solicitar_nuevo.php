<?php include_once(APPPATH.'modules/rhh_ausentismo/forms/formulario_solicitar_ausentismo.php'); ?>

<div class="mainy">
	<div class="row">
		<div class="col-md-12">
			<div class="page-title">
				<h2 class="text-right"><i class="fa fa-globe color"></i> Ausentismos</h2>
				<hr>
			</div>
			
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
								<label for="lista_ausentismos" class="col-sm-3 control-label">Seleccione uno</label>
								<div class="col-sm-9">
									<select name="lista_ausentismos" class="form-control text-uppercase" id="lista_ausentismos">
										<option value="">Seleccione uno</option>
									</select>
								</div>
							</div>

							<div id="spaninfo" class="hidden">
								<p class="col-sm-offset-3 col-sm-9">
									<p class="text-center"><b class="text-info text-uppercase">Detalles de reporte/permiso</b></p>
									<p class="col-sm-offset-3" id="textoDetalles"></p>
								</p>
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
									<?php echo anchor('ausentismo/solicitar', '<i class="fa fa-times fa-fw"></i> Cancelar', array('class' => 'btn btn-default btn-block')) ?>
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
			if ($(this).val() != '') {
		        $('#spaninfo').addClass('hidden');

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
		                		.attr("value", '').text('Seleccione uno'));

		               			//[minimo_dias_permiso] => 12
					            // [maximo_dias_permiso] => 12
					            // [cantidad_maxima_mensual] => 1
		                	
		                	// Poblando el segundo select
		                	for (var i = data.length - 1; i >= 0; i--) {
		                		$("#lista_ausentismos")
		                		.append($("<option></option>")
			                		.attr("value", data[i].ID).text(data[i].nombre)
			                		.attr("data-tipodias", data[i].tipo_dias)
			                		.attr("data-minimodiaspermiso", data[i].minimo_dias_permiso)
			                		.attr("data-maxdiaspermiso", data[i].maximo_dias_permiso)
			                		.attr("data-cantmaxmens", data[i].cantidad_maxima_mensual)
			                		.attr("data-soporte", data[i].soportes)
		                		);
		                	}

		                	// Analogo a primer select para mostrar los detalles
		                	$('#lista_ausentismos').on('change', function(){
		                		if ($(this).val() != '') {
		                			$('#spaninfo').removeClass('hidden');
		                			var tabla = '';
		                			var soportes = $(this).find(':selected').attr('data-soporte');
		                			var tipo_dias = $(this).find(':selected').attr('data-tipodias');
		                			var minimo_dias_permiso = $(this).find(':selected').attr('data-minimodiaspermiso');
		                			var maximo_dias_permiso = $(this).find(':selected').attr('data-maxdiaspermiso');
		                			var cantidad_maxima_mensual = $(this).find(':selected').attr('data-cantmaxmens');
		                			if (soportes == '') { tabla = soportes = 'No se ha indicado soporte alguno'; }

		                			var tabla = "<table class='table table-bordered'><tr><td class='negritas'>Minimo Días Permiso</td><td>"+minimo_dias_permiso+" días</td></tr><tr><td class='negritas'>Máximo Días Permiso</td><td>"+cantidad_maxima_mensual+" días</td></tr><tr><td class='negritas'>Cantidad Máxima Mensual</td><td>"+cantidad_maxima_mensual+" veces</td></tr><tr><td class='negritas'>Tipo de Días</td><td>"+tipo_dias+"</td></tr><tr><td class='negritas'>Soportes Requeridos:</td><td>"+soportes+"</td></tr></table>";
		                			$('#textoDetalles').html(tabla);

		                		}else{
		                			$('#spaninfo').addClass('hidden');
		                		}
		                	});
		                }else{
		                	$('#form_lista_ausentismos').addClass('hidden');
		                }
	                }
	            });
			}else{
				// ocultar todos porque el primer select es vacio
				$('#form_lista_ausentismos').addClass('hidden');
		        $('#spaninfo').addClass('hidden');
			}
		});
	});
</script>