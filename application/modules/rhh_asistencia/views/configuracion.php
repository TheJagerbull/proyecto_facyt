<div class="mainy">
    <!-- Page title --> 
    <div class="page-title">
        <h2 class="text-right"><i class="fa fa-desktop color"></i> Asistencia <small>Configuraciones </small></h2>
        <hr>
    </div>

    <!-- Page title -->
    <div class="row">
        <div class="col-lg-12 col-md-12">
            <!-- Este debería ser el espacio para los flashbags -->
            <?php if ($this->session->flashdata('mensaje') != FALSE) { echo $this->session->flashdata('mensaje'); } ?>
            <!-- Fin del espacio de los Flashbags -->

            <div class="panel panel-primary">
                <!-- <div class="panel-heading">
                    Horas Semanales que se deben Cumplir
                </div> -->
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
            <p>8 horas diarias de trabajo son 40 horas semanales </p>

        </div>
    </div>
</div>
<div class="clearfix"></div>