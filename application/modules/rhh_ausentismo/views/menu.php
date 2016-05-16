<div class="col-lg-3 col-sm-3 col-xs-12">
    <div class="well well-sm" role="alert"><p class="text-center">con fines demostrativos ;)</p></div>

    <!--a href="<?php echo site_url('asistencia') ?>" class="btn btn-default btn-block">Asistencia</a-->
    <a href="<?php echo site_url('asistencia/agregar') ?>" class="btn btn-default btn-block">Marcar Asistencia</a>

    <a type="button" href="<?php echo site_url('asistencia/configuracion'); ?>" class="btn btn-block btn-default">Asistencia Config</a>
    <a type="button" href="<?php echo site_url('asistencia/configuracion/agregar'); ?>" class="btn btn-block btn-default disabled">Asistencia Add Config</a>
    
    <a type="button" class="btn btn-default btn-block" href="<?php echo site_url('ausentismo') ?>"> Configuración Ausentismos</a>

    <a class="btn btn-default btn-block" href="<?php echo site_url('cargo') ?>">Cargos</a>
    
    <a href="<?php echo site_url('jornada') ?>" class="btn btn-default btn-block" type="button">Jornadas</a>
    
    <a class="btn btn-default btn-block" href="<?php echo site_url('periodo-no-laboral') ?>">Perido No Laboral</a>

</div>