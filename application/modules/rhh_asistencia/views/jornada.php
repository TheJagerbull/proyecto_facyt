<style type="text/css">
    .table > thead > tr> th { vertical-align: middle; }
    .thin-row { padding: 4px !important; }
</style>

<script type="text/javascript">
    function aviso()
    {
        swal({
            title: 'Hola'
        });
        //alert('aqui muestro el swal');
        return true;
    }
</script>

<div class="container">
    <div class="page-header text-center">
        <h1>Asistencia - Jornadas Existentes</h1>
    </div>
    <div class="row">
        <?php include_once(APPPATH.'modules/rhh_ausentismo/views/menu.php'); ?>
        <div class="col-lg-9 col-sm-9 col-xs-12">

            <div style="margin-top: 10px; margin-bottom: 10px;">
                <a type="button" class="btn btn-success" href="<?php echo site_url('asistencia/jornada/nueva') ?>"><i class="fa fa-plus fa-fw"></i> Agregar Jornada</a>
            </div>
            
            <?php if ($this->session->flashdata('mensaje') != FALSE) { echo $this->session->flashdata('mensaje'); } ?>

            <div class="panel panel-success">
                <div class="panel-heading">Jornadas Existentes</div>
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th class="text-center middle" rowspan="2">#</th>
                            <th class="text-center thin-row" rowspan="2">Nombre</th>
                            <th class="text-center thin-row" colspan="2">Hora</th>
                            <th class="text-center thin-row" rowspan="2">Tolerancia</th>
                            <th class="text-center thin-row" rowspan="2">Tipo</th>
                            <th class="text-center thin-row" rowspan="2">Horas Descanso</th>
                            <th class="text-center thin-row" rowspan="2">Cargo</th>
                            <th class="text-center thin-row" rowspan="2">Opciones</th>
                        </tr>
                        <tr>
                            <th class="text-center thin-row">Inicio</th>
                            <th class="text-center thin-row">Fin</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php if (isset($jornadas)): ?>
                        <?php if (sizeof($jornadas) == 0): ?>
                            <tr>
                                <td colspan="9" class="text-success text-center">No ha agregado ninguna Jornada actualmente.</td>
                            </tr>
                        <?php endif ?>
                            <?php $index = 1; foreach ($jornadas as $key){ ?>
                                <tr>
                                    <td class="text-center"><?php echo $index; $index++; ?></td>
                                    <td><?php echo $key->nombre_jornada; ?></td>
                                    <td><?php $date = new DateTime($key->hora_inicio); echo $date->format('h:i a'); ?></td>
                                    <td><?php $date = new DateTime($key->hora_fin); echo $date->format('h:i a'); ?></td>
                                    <td><?php echo $key->tolerancia; ?> horas</td>
                                    <td><?php echo 'Jornada '.$key->tipo; ?></td>
                                    <td><?php echo $key->cantidad_horas_descanso; ?> horas</td>
                                    <td><?php echo $key->nombre_cargo; ?></td>
                                    <td class="text-center">
                                        <a href="<?php echo site_url('asistencia/jornada/modificar/').'/'.$key->ID; ?>" class="btn btn-primary btn-sm"><i class="fa fa-edit fa-fw"></i></a>
                                        <a href="<?php echo site_url('asistencia/jornada/eliminar/').'/'.$key->ID; ?>" class="btn btn-danger btn-sm"><i class="fa fa-trash-o fa-fw" onclick="aviso();"></i></a>
                                    </td>
                                </tr>
                            <?php } ?>
                        <?php endif ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>