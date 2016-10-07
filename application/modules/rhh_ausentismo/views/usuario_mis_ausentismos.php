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
			<!-- <div class="alert well-sm alert-danger" role="alert"><i class="fa fa-times fa-2x pull-left"></i> Aquí se coloca el texto de la alerta.</div> -->
			<!-- <div class="alert well-sm alert-warning" role="alert"><i class="fa fa-times fa-2x pull-left"></i> Aquí se coloca el texto de la alerta.</div> -->

			<!-- Sub Cabecera, preferencial -->
			<!-- <h3>Cabecera de la Vaina</h3> -->
			<!-- <p>Cuerpo del Asunto.</p> -->

			<div class="panel panel-default">
				<div class="panel-heading">
                    <label class="control-label">Permisos y Reposos</label>
                    <div class="btn-group btn-group-sm pull-right">
                        <a type="button" class="btn btn-success" href="<?php echo site_url('ausentismo/solicitar') ?>"><i class="fa fa-plus fa-fw"></i> Solicitar Nuevo Ausentismo</a>
                    </div>
                </div>

				<div class="panel-body">
					<?php echo_pre($permisos); ?>
					<?php echo_pre($reposos); ?>
				</div>
			</div>

		</div>
	</div>
</div>
<div class="clearfix"></div>