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

<div class="mainy">
    <div class="row">
        <div class="col-md-12">

            <!-- Page title --> 
            <div class="page-title">
                <h2 class="text-right"><i class="fa fa-globe color"></i> Jornadas</h2>
                <hr>
            </div>

            <!-- Este debería ser el espacio para los flashbags -->
            <?php if ($this->session->flashdata('mensaje') != FALSE) { echo $this->session->flashdata('mensaje'); } ?>

            <div class="panel panel-default">
                <div class="panel-heading">
                    <label class="control-label">Jornadas Existentes</label>
                    <a type="button" class="btn btn-success btn-sm pull-right" href="<?php echo site_url('jornada/nueva') ?>"><i class="fa fa-plus fa-fw"></i> Agregar Jornada</a>
                </div>
                <table class="table table-bordered">
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
                                        <a href="<?php echo site_url('jornada/modificar/')."/".$key->ID; ?>" class="btn btn-primary btn-sm"><i class="fa fa-edit fa-fw"></i></a>
                                        <a id="eliminar_confirmacion" href="<?php echo site_url('jornada/eliminar/').'/'.$key->ID; ?>" class="btn btn-default btn-sm"><i class="fa fa-trash-o fa-fw"></i></a>
                                    </td>
                                </tr>
                                <?php $week = unserialize($key->dias_jornada); ?>
                                <tr class="text-center">
                                    <td colspan="6">
                                    <span class="th negritas">Dias:</span>
                                    <?php
                                    foreach ($week as $day) {
                                        echo $semana[$day][1].', ';
                                    }
                                    ?></td>
                                </tr>
                            <?php } ?>
                        <?php endif ?>
                    </tbody>
                </table>
                <!-- <div class="panel-footer"></div> -->
            </div>
        </div>
    </div>
</div>
<div class="clearfix"></div>

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