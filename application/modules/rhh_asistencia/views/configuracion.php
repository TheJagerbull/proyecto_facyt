<div class="container">
    <div class="page-header text-center">
        <h1>Asistencia - Configuraciones</h1>
    </div>
    <div class="row">
        <?php include_once(APPPATH.'modules/rhh_ausentismo/views/menu.php'); ?>
        <div class="col-lg-9 col-sm-9 col-xs-12">
        	<?php if ($this->session->flashdata('mensaje') != FALSE) { echo $this->session->flashdata('mensaje'); } ?>

        	<div class="panel panel-primary">
                <div class="panel-heading">
                    Horas Semanales que se deben Cumplir
                </div>
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Cantidad de Horas Semanales</th>
                            <th>Opciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($configuraciones as $con): ?>
                        <tr>
                            <td class="text-center"><?php echo $con->minimo_horas_ausentes_sem; ?> horas</td>
                            <td class="text-center"><a href="<?php echo site_url('asistencia/configuracion/modificar/'.$con->ID.'/'.$con->minimo_horas_ausentes_sem); ?>" class="btn btn-primary btn-sm"><i class="fa fa-pencil fa-fw"></i> Modificar</a></td>
                        </tr>
                        <?php endforeach ?>
                    </tbody>
                </table>
            </div>
        	8 horas diarias de trabajo son 40 horas semanales
        </div>
    </div>
</div>