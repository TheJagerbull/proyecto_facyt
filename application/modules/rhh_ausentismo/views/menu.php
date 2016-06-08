<?php 
	/* ESTE MENU SERÁ ELIMINADO POSTERIORMENTE, AL TERMINAR LA IMPLEMENTACION SE ADAPTARA A LA PLANTILLA PINCIPAL */
 ?>
<div class="col-lg-3 col-sm-3 col-xs-12">
	<!-- <div class="well well-sm" role="alert"><p class="text-center">con fines demostrativos ;)</p></div>
	<a href="<?php echo site_url('asistencia') ?>" class="btn btn-default btn-block">Asistencia</a> -->

	<div class="sidey" style="">
		<div class="side-cont">
			<ul class="nav">
				<!-- Main menu -->
				<li class="has_submenu">
					<a href="#">
						<i class="fa fa-list fa-fw"></i> Asistencia
						<span class="caret pull-right"></span>
					</a>
					<!-- Sub menu -->
					<ul style="display: none;">
						<li><?php echo anchor('asistencia/agregar','Marcar Asistencia'); ?></li>
						<li><?php echo anchor('asistencia/configuracion','Asistencia Config'); ?></li>
						<li><?php echo anchor('asistencia/configuracion/agregar','Asistencia Add Config',array('class'=>'disabled')); ?></li>
						<li><?php echo anchor('ausentismo','Configuración Ausentismos'); ?></li>
						<li><?php echo anchor('cargo','Cargos'); ?></li>
						<li><?php echo anchor('jornada','Jornandas'); ?></li>
						<li><?php echo anchor('periodo-no-laboral', 'Periodo No Laboral'); ?></li>
						<li><?php echo anchor('nota', 'Nota Asistencia'); ?></li>
						<li><?php echo $this->session->userdata('user')['ID'].' - '.$this->session->userdata('user')['id_usuario']; ?></li>
					</ul>
				</li>
			</ul>
		</div>
	</div>
</div>