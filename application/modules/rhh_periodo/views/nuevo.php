<?php include_once(APPPATH.'modules/rhh_periodo/forms/formulario_agregar_periodo.php'); ?>
<div class="mainy">
	<div class="row">
		<div class="col-md-12">
			<!-- Page title --> 
			<div class="page-title">
				<h2 class="text-right"><i class="fa fa-globe color"></i> Períodos</h2>
				<hr>
			</div>

			<!-- Este debería ser el espacio para los flashbags -->
			<?php if ($this->session->flashdata('mensaje') != FALSE) { echo $this->session->flashdata('mensaje'); } ?>

			<div class="panel panel-default">
				<div class="panel-heading">
					<label class="control-label">Agregar | Modificar</label>
				</div>
				<div class="panel-body">
					<?php echo form_open($action, $form); ?>
						<input type="hidden" name="ID" value="<?php if (isset($periodo)) { echo $periodo['ID']; } ?>"></input>

						<div class="col-sm-offset-3">
							<div class="col-sm-6">
								<div class="row">
									<div class="col-sm-12">
										<label class="col-sm-12 control-label text-left">Fecha Inicio</label>
									</div>
									<div class="col-sm-12">
										<div class="form-group">
											
											<?php if(isset($periodo)){ $fecha_inicio_edit = $periodo['fecha_inicio']; }else{ $fecha_inicio_edit = ''; } ?>
											<div class="col-sm-12 date">
												<div class="input-group input-append date">
													<?php echo form_input($fecha_inicio, $fecha_inicio_edit); ?>
													<span class="input-group-addon add-on"><span class="glyphicon glyphicon-calendar"></span></span>
												</div>
											</div>
										</div>
									</div>
								</div>
										
							</div>
							<div class="col-sm-6">
								<div class="row">
									<div class="col-lg-12">
										<label class="col-sm-12 control-label text-left">Fecha Fin</label>
									</div>
									<div class="col-lg-12">
										<div class="form-group">
											
											<?php if(isset($periodo)){ $fecha_fin_edit = $periodo['fecha_fin']; }else{ $fecha_fin_edit = ''; } ?>
											<div class="col-sm-12 date">
												<div class="input-group input-append date">
													<?php echo form_input($fecha_fin, $fecha_fin_edit); ?>
													<span class="input-group-addon add-on"><span class="glyphicon glyphicon-calendar"></span></span>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>

						<div class="col-lg-12 col-sm-12 col-xs-12">
							<div class="form-group">
								<label class="col-sm-3 control-label">Cantidad Días</label>
								<?php if(isset($periodo)){ $cant_edit = $periodo['cant_dias']; }else{ $cant_edit = 0; } ?>
								<div class="col-sm-9">
									<div class="input-group input-append">
										<?php echo form_input($cant_dias, $cant_edit); ?>
										<span class="input-group-addon add-on">días</span>
									</div>		
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-3 control-label">Nombre</label>
								<?php if(isset($periodo)){ $nombre_edit = $periodo['nombre']; }else{ $nombre_edit = ''; } ?>
								<div class="col-sm-9"><?php echo form_input($nombre, $nombre_edit); ?></div>
							</div>

							<div class="form-group">
								<label class="col-sm-3 control-label">Descripción</label>
								<?php if(isset($periodo)){ $descripcion_edit = $periodo['descripcion']; }else{ $descripcion_edit = ''; } ?>
								<div class="col-sm-9"><?php echo form_textarea($descripcion, $descripcion_edit); ?></div>
							</div>

							<div class="row">
								<div class="col-lg-4 col-lg-offset-3">
									<a class="btn btn-default btn-block" href="<?php echo site_url('periodo') ?>"><i class="fa fa-times fa-fw"></i> Cancelar</a>
								</div>
								<div class="col-lg-5">
									<button type="submit" class="btn btn-primary btn-block"><i class="fa fa-save fa-fw"></i>
									<?php if(isset($periodo)){
										echo "Guardar Modificaciones"; }else{
										echo "Guardar Período"; }?>
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

<script src="<?php echo base_url() ?>assets/js/jquery-1.11.3.js"></script>
<script type="text/javascript">
$('document').ready(function() {
	$('input[name="fecha_inicio_periodo"]').daterangepicker({
		autoUpdateInput: false,
		locale: {
			format: 'yyyy-mm-dd',
			autoApply: true,
	        fromLabel: "Desde",
	        toLabel: "Hasta",
	        customRangeLabel: "Custom",
	        daysOfWeek: [
	            "Dom","Lun","Mar","Mie","Jue","Vie","Sáb"
	        ],
	        monthNames: [
	            "Enero", "Febrero", "Mazro", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"
	        ],
	        firstDay: 1
	    }
	});

	$('input[name="fecha_inicio_periodo"]').on('hide.daterangepicker', function(ev, picker) {
		
        var inicio = picker.startDate.format('YYYY-MM-DD');
        var fin = picker.endDate.format('YYYY-MM-DD');
        var sD = new Date(inicio);
        var eD = new Date(fin);
        // var today = new Date();
        var range = eD.getTime() - sD.getTime();
        range = Math.floor(range / (1000 * 60 * 60 * 24));
        document.getElementById('cant_dias_periodo').value = range;
    });

    $('#cant_dias_periodo').on('change', function(){
    	picker = $('input[name="fecha_inicio_periodo"]');
    	var inicio = picker.val();
        var sD = new Date(inicio);
        function pad(s) { return (s < 10) ? '0' + s : s; }
    	sD.setTime( sD.getTime() + $( this ).val() * 86400000 );
    	$('input[name="fecha_fin_periodo"]').val(sD.getFullYear()+'-'+pad(sD.getMonth()+1)+'-'+pad(sD.getDate()));
    });

	$('input[name="fecha_inicio_periodo"]').on('apply.daterangepicker', function(ev, picker) {
		$(this).val(picker.startDate.format('YYYY-MM-DD'));
		$('input[name="fecha_fin_periodo"]').val(picker.endDate.format('YYYY-MM-DD'));
	});

	$('input[name="fecha_inicio_periodo"]').on('cancel.daterangepicker', function(ev, picker) {
		$(this).val('');
		$('input[name="fecha_fin_periodo"]').val('');
	});

});
</script>