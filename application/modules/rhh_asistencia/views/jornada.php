<script src="<?php echo base_url() ?>assets/js/jquery-1.11.3.js"></script>
<script src="<?php echo base_url() ?>assets/js/sweet-alert.js" type="text/javascript"></script>

<style type="text/css">
    .table > thead > tr> th { vertical-align: middle; }
    .thin-row { padding: 4px !important; }
</style>

<?php
    $semana = [];
    $semana['0'] = array('0', 'Domingo');
    $semana['1'] = array('1', 'Lunes');
    $semana['2'] = array('2', 'Martes');
    $semana['3'] = array('3', 'Miercoles');
    $semana['4'] = array('4', 'Jueves');
    $semana['5'] = array('5', 'Viernes');
    $semana['6'] = array('6', 'Sábado');
?>

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
                            <th class="text-center thin-row" rowspan="2">Cargo</th>
                            <th class="text-center thin-row" rowspan="2">Tipo</th>
                            <th class="text-center thin-row" colspan="2">Hora</th>
                            <th class="text-center thin-row" rowspan="2">Tolerancia</th>
                            <th class="text-center thin-row" rowspan="2">Horas Descanso</th>
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
                                <tr class="text-center">
                                    <td class="text-center" rowspan="2"><?php echo $index; $index++; ?></td>
                                    <td><?php echo $key->nombre_cargo; ?></td>
                                    <td><?php echo $key->tipo; ?></td>
                                    <td><?php $date = new DateTime($key->hora_inicio); echo $date->format('h:i a'); ?></td>
                                    <td><?php $date = new DateTime($key->hora_fin); echo $date->format('h:i a'); ?></td>
                                    <td><?php echo $key->tolerancia; ?> horas</td>
                                    <td><?php echo $key->cantidad_horas_descanso; ?> horas</td>
                                    <td class="text-center" rowspan="2">
                                        <a href="<?php echo site_url('asistencia/jornada/modificar/').'/'.$key->ID; ?>" class="btn btn-primary btn-sm"><i class="fa fa-edit fa-fw"></i></a>
                                        <a id="eliminar_confirmacion" href="<?php echo site_url('asistencia/jornada/eliminar/').'/'.$key->ID; ?>" class="btn btn-danger btn-sm"><i class="fa fa-trash-o fa-fw"></i></a>
                                    </td>
                                </tr>
                                <?php $week = unserialize($key->dias_jornada); ?>
                                <tr class="text-center">
                                    <td colspan="6"><?php
                                    foreach ($week as $day) {
                                        echo $semana[$day][1].', ';
                                    }
                                    ?></td>
                                </tr>
                            <?php } ?>
                        <?php endif ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    $('[id="eliminar_confirmacion"]').click(function(e){
        e.preventDefault();
        var href = $(this).attr('href');
        swal({
            title: "¿Está seguro?",
            text: "Se eliminará esta jornada",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "Eliminar",
            closeOnConfirm: false
        },
        function(isConfirm){ if(isConfirm){ window.location.href = href; } });
    });
</script>