<div class="container">
    <div class="page-header text-center">
        <h1>Asistencia - Jornadas</h1>
    </div>
    <div class="row">
        <?php include_once(APPPATH.'modules/rhh_ausentismo/views/menu.php'); ?>
        <div class="col-lg-9 col-sm-9 col-xs-12">

            <div style="margin-top: 10px; margin-bottom: 10px;">
                <a type="button" class="btn btn-success" href="<?php echo site_url('asistencia/jornada') ?>"><i class="fa fa-plus fa-fw"></i> Agregar Jornada</a>
            </div>
            
            <?php if (isset($mensaje)) { echo $mensaje; } ?>

            <div class="panel panel-success">
                <div class="panel-heading">Jornadas Existentes</div>
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th class="text-center">#</th>
                            <th>nombre</th>
                            <th>hora_inicio</th>
                            <th>hora_fin</th>
                            <th>tolerancia</th>
                            <th>tipo</th>
                            <th>cantidad_horas_totales</th>
                            <th>cantidad_horas_descanso</th>
                            <th>opciones</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php if (isset($jornadas)): ?>
                        <?php if (sizeof($jornadas) == 0): ?>
                            <tr>
                                <td colspan="9" class="text-success text-center">No ha agregado ninguna Jornada actualmente.</td>
                            </tr>
                        <?php endif ?>
                            <?php foreach ($jornadas as $key): ?>
                                <tr>
                                    <td class="text-center">n-a-m</td>
                                    <td>Cuerpos</td>
                                    <td class="text-center">
                                        <a href="<?php echo site_url('asistencia/jornada/modificar/').'/'.$key['ID']; ?>" class="btn btn-primary btn-xs"><i class="fa fa-edit fa-fw"></i></a>
                                        <a href="<?php echo site_url('asistencia/jornada/eliminar/').'/'.$key['ID']; ?>" class="btn btn-danger btn-xs"><i class="fa fa-trash-o fa-fw"></i></a>
                                    </td>
                                </tr>
                            <?php endforeach ?>
                        <?php endif ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>