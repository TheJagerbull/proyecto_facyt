<script src="<?php echo base_url() ?>assets/js/jquery-1.11.3.js"></script>
<script src="<?php echo base_url() ?>assets/js/sweet-alert.js" type="text/javascript"></script>
<style type="text/css">
	.head{ margin-top: 10px; margin-bottom: 10px; }
</style>

<div class="mainy">
	<!-- Page title -->
	<div class="row">
		<div class="col-md-12">

			<!-- Page title --> 
			<div class="page-title">
				<h2 class="text-right"><i class="fa fa-globe color"></i> Ausentismos</h2>
				<hr>
			</div>

			<!-- Este debería ser el espacio para los flashbags -->
			<?php if ($this->session->flashdata('mensaje') != FALSE) { echo $this->session->flashdata('mensaje'); } ?>

			<!-- Sub Cabecera, preferencial -->
			<div class="panel panel-default">
				<div class="panel-heading">
					<label class="control-label">Lista de Ausentismos Agregados</label>
					<div class="btn-group btn-group-sm pull-right">
						<a type="button" class="btn btn-success pull-right" href="<?php echo site_url('ausentismo/configuracion/nueva') ?>"><i class="fa fa-plus fa-fw"></i> Agregar Ausentismo</a>
					</div>
				</div>
				<table class="table table-bordered">
					<thead>
						<tr>
							<th class="text-center">#</th>
							<th>Tipo</th>
							<th>Nombre</th>
							<!-- <th class="hidden">Mín Días</th>
							<th class="hidden">Máx Días</th>
							<th class="hidden">Cant. Máx Mensual</th> 
							<th>Tipos Días</th> -->
							<th>Opciones</th>
						</tr>
					</thead>
					<tbody>
					<?php if(sizeof($ausentismos) == 0){ ?>
						<tr class="text-center">
							<td colspan="7"> No ha agregado ninguna configuración sobre los ausentismos y reposos</td>
						</tr>
					<?php } ?>
					<?php $index = 1; foreach ($ausentismos as $key): ?>
						<tr>
							<td class="text-center"><?php echo $index; $index++; ?></td>
							<td><?php echo $key['tipo']; ?></td>
							<td class="col-lg-3"><a class="link" id="mostrar_detalles_ausentismo" data-action="<?php echo site_url('ausentismo/configuracion/ver/').'/'.$key['ID']; ?>"><?php echo $key['nombre']; ?></a></td>
							<!-- <td class="hidden"><?php echo $key['minimo_dias_permiso']; ?> días</td>
							<td class="hidden"><?php echo $key['maximo_dias_permiso']; ?> días</td>
							<td class="hidden"><?php echo $key['cantidad_maxima_mensual']; ?> veces</td>
							<td><?php echo $key['tipo_dias']; ?></td> -->
							<td class="text-center">
								<a href="<?php echo site_url('ausentismo/configuracion/modificar/').'/'.$key['ID']; ?>" class="btn btn-primary btn-sm"><i class="fa fa-edit fa-fw"></i></a>
								<a id="eliminar_confirmacion" href="<?php echo site_url('ausentismo/configuracion/eliminar/').'/'.$key['ID']; ?>" class="btn btn-default btn-sm"><i class="fa fa-trash-o fa-fw"></i></a>
							</td>
						</tr>
					<?php endforeach ?>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>
<div class="clearfix"></div>

<div id="configuracion_detalles" class="modal fade" tabindex="-1" role="dialog">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title">Detalles del Ausentismo</h4>
			</div>
			<span id="cuerpo"></span>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-times"></i> Cerrar</button>
			</div>
		</div>
	</div>
</div>

<script type="text/javascript">
	$(document).ready(function(){

		/* AJAX PARA CARGAR LOS DETALLES DE UNA CONFIGURACIÓN */
		$('body').on('click', '#mostrar_detalles_ausentismo', function() {
		    url = $(this).data('action');
			$('#configuracion_detalles').modal('show');
			$.ajax({
				url: url,
				type: "GET",
				complete: function(data, textStatus, xhr){
					str = JSON.parse(data.responseText)
					$('#cuerpo').html(str)
				},
			});
		});
		
	});

	$('#configuracion_detalles').on('hidden.bs.modal', function (e) {
		$('#cuerpo').children().replaceWith("<div class='well well-sm'>Obteniendo formulario ... espere!</div>")
	});

	$('[id="eliminar_confirmacion"]').click(function(e){
		e.preventDefault();
		var href = $(this).attr('href');
		swal({
			title: "¿Está seguro?",
			text: "Se eliminará este tipo de Ausentismo",
			type: "warning",
			showCancelButton: true,
			confirmButtonText: "Eliminar",
			cancelButtonText: "Cancelar",
			closeOnConfirm: false
		},
		function(isConfirm){ if(isConfirm){ window.location.href = href; } });
	});
</script>