<div class="col-lg-3 col-sm-3 col-xs-12">
    <div class="well well-sm" role="alert"><p class="text-center">con fines demostrativos ;)</p></div>

    <!--a href="<?php echo site_url('asistencia') ?>" class="btn btn-success btn-block">Asistencia</a-->
    <a href="<?php echo site_url('asistencia/agregar') ?>" class="btn btn-success btn-block">Marcar Asistencia</a>

    <a type="button" href="<?php echo site_url('asistencia/configuracion'); ?>" class="btn btn-block btn-success">Asistencia Config</a>
    <a type="button" href="<?php echo site_url('asistencia/configuracion/agregar'); ?>" class="btn btn-block btn-success disabled">Asistencia Add Config</a>

    <a href="<?php echo site_url('asistencia/jornada') ?>" class="btn btn-success btn-block" type="button">Jornadas</a>
    
    <a type="button" class="btn btn-primary btn-block" href="<?php echo site_url('ausentismo') ?>">Ausentismos</a>

    <a class="btn btn-warning btn-block" href="<?php echo site_url('cargo') ?>">Cargos</a>

</div>