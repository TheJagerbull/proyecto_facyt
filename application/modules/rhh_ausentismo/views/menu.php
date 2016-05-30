<div class="col-lg-3 col-sm-3 col-xs-12">
    <div class="well well-sm" role="alert"><p class="text-center">con fines demostrativos ;)</p></div>

    <!--a href="<?php echo site_url('asistencia') ?>" class="btn btn-default btn-block">Asistencia</a-->
    
    <?php echo anchor('asistencia/agregar','Marcar Asistencia',array('class'=>'btn btn-default btn-block')); ?>
    <?php echo anchor('asistencia/configuracion','Asistencia Config',array('class'=>'btn btn-default btn-block')); ?>
    <?php echo anchor('asistencia/configuracion/agregar','Asistencia Add Config',array('class'=>'btn btn-default btn-block disabled')); ?>
    <?php echo anchor('ausentismo','Configuración Ausentismos',array('class'=>'btn btn-default btn-block')); ?>
    <?php echo anchor('cargo','Cargos',array('class'=>'btn btn-default btn-block')); ?>
    <?php echo anchor('jornada','Jornandas',array('class'=>'btn btn-default btn-block')); ?>
    <?php echo anchor('periodo-no-laboral', 'Periodo No Laboral', array('class' => 'btn btn-default btn-block')); ?>
    <?php echo anchor('nota', 'Nota Asistencia', array('class' => 'btn btn-primary btn-block')); ?>

    <br>
    <div class="well well-sm text-center"><?php echo $this->session->userdata('user')['ID'].' - '.$this->session->userdata('user')['id_usuario']; ?></div>

</div>