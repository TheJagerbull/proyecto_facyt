<script src="<?php echo base_url() ?>assets/js/jquery-1.11.3.js"></script>
<div class="mainy">
	<!-- Page title -->
	<div class="row">
		<div class="col-md-12">
			<!-- Sub Cabecera, preferencial -->
            <div class="page-title">
                <h2 class="text-right"><i class="fa fa-globe color"></i> Mis Ausentismos <small>Permisos y Reposos</small></h2>
                <hr />
            </div>

			<!-- Este debería ser el espacio para los flashbags -->
			<?php if ($this->session->flashdata('mensaje') != FALSE) { echo $this->session->flashdata('mensaje'); } ?>

			<div class="panel panel-default">
				<div class="panel-heading">
					<label class="control-label">Mis permisos y reposos solicitados</label>
					<div class="btn-group btn-group-sm pull-right">
						<a type="button" class="btn-success btn pull-right" href="<?php echo site_url('ausentismo/solicitar') ?>"><i class="fa fa-plus"></i> Solicitar Nuevo Ausentismo</a>
					</div>
				</div>
			</div>

			<div class="panel panel-primary">
				<div class="panel-body">
					<ul id="myTab" class="nav nav-tabs nav-justified">
						<li class="active"><a href="#permisos" data-toggle="tab">Permisos</a></li>
						<li><a href="#reposos" data-toggle="tab">Reposos</a></li>
					</ul>
					<div class="space-5px"></div>
					<div id="myTabContent" class="tab-content">
						<div id="permisos" class="tab-pane fade active in">
							<table class="table table-bordered">
								<thead>
									<th>Fecha Solicitud</th>
									<!-- <th>Permiso</th> -->
									<th>Nombre</th>
									<!-- <th>Descripcion</th> -->
									<th>Fecha Inicio</th>
									<th>Fecha Fin</th>
									<th>Estatus</th>
									<th>Opciones</th>
								</thead>
								<tbody>
									<?php foreach ($permisos as $element): ?>
										<tr>
											<td><?php echo $element->fecha_solicitud; ?></td>
											<!-- <td><?php echo $element->id_tipo_ausentismo; ?></td> -->
											<td><?php echo $element->nombre; ?></td>
											<!-- <td><?php echo $element->descripcion; ?></td> -->
											<td><?php echo $element->fecha_inicio; ?></td>
											<td><?php echo $element->fecha_final; ?></td>
											<td><?php echo $element->estatus; ?></td>
											<td class="col-lg-2" class="text-center">
												<a class="btn btn-info btn-sm" id="mostrar_detalles_ausentismo" data-action="<?php echo site_url('ausentismo/configuracion/ver/').'/'.$element->id_tipo_ausentismo; ?>"> <i class="fa fa-info fa-fw"></i></a>
												<!-- <a href="<?php echo site_url('ausentismo/configuracion/modificar/').'/'.$element->id_tipo_ausentismo; ?>" class="btn btn-primary btn-sm"><i class="fa fa-edit fa-fw"></i></a> -->
												<a id="eliminar_confirmacion" href="<?php echo site_url('ausentismo/configuracion/eliminar/').'/'.$element->id_tipo_ausentismo; ?>" class="btn btn-default btn-sm"><i class="fa fa-trash-o fa-fw"></i></a>
											</td>
										</tr>
									<?php endforeach ?>
								</tbody>
							</table>
						</div>
						<div id="reposos" class="tab-pane fade">
							<table class="table table-bordered">
								<thead>
									<th>Fecha Solicitud</th>
									<!-- <th>Permiso</th> -->
									<th>Nombre</th>
									<!-- <th>Descripcion</th> -->
									<th>Fecha Inicio</th>
									<th>Fecha Fin</th>
									<th>Estatus</th>
									<th>Opciones</th>
								</thead>
								<tbody>
									<?php foreach ($reposos as $element): ?>
										<tr>
											<td><?php echo $element->fecha_solicitud; ?></td>
											<!-- <td><?php echo $element->id_tipo_ausentismo; ?></td> -->
											<td><?php echo $element->nombre; ?></td>
											<!-- <td><?php echo $element->descripcion; ?></td> -->
											<td><?php echo $element->fecha_inicio; ?></td>
											<td><?php echo $element->fecha_final; ?></td>
											<td><?php echo $element->estatus; ?></td>
											<td class="col-lg-2" class="text-center">
												<a class="btn btn-info btn-sm" id="mostrar_detalles_ausentismo" data-action="<?php echo site_url('ausentismo/configuracion/ver/').'/'.$element->id_tipo_ausentismo; ?>"> <i class="fa fa-info fa-fw"></i></a>
												<!-- <a href="<?php echo site_url('ausentismo/configuracion/modificar/').'/'.$element->id_tipo_ausentismo; ?>" class="btn btn-primary btn-sm"><i class="fa fa-edit fa-fw"></i></a> -->
												<a id="eliminar_confirmacion" href="<?php echo site_url('ausentismo/configuracion/eliminar/').'/'.$element->id_tipo_ausentismo; ?>" class="btn btn-default btn-sm"><i class="fa fa-trash-o fa-fw"></i></a>
											</td>
										</tr>
									<?php endforeach ?>
								</tbody>
							</table>
						</div>
                    </div>
                    <!-- Fin del cuerpo del tab-->
				</div>
			</div>

		</div>
	</div>
</div>
<div class="clearfix"></div>
<script type="text/javascript">
    $(document).ready(function () {
        /*inicializar el data table*/
        $('.table').dataTable({
            "language": {
                "url": "<?php echo base_url() ?>assets/js/lenguaje_datatable/spanish.json"
            }
        });
    });
</script>