<script src="<?php echo base_url() ?>assets/js/jquery-1.11.3.js"></script>
<script src="<?php echo base_url() ?>assets/js/sweet-alert.js" type="text/javascript"></script>

<style type="text/css">
    .head{ margin-top: 10px; margin-bottom: 10px; }
    .long-words{
        -ms-word-break: break-all;
        word-break: break-all;
        /* Non standard for webkit */
        word-break: break-word;
        -webkit-hyphens: auto;
        -moz-hyphens: auto;
        hyphens: auto;
    }
</style>

<div class="container">
    <div class="page-header text-center">
        <h1>Notas de Retraso</h1>
    </div>
    <div class="row">
        <?php include_once(APPPATH.'modules/rhh_ausentismo/views/menu.php'); ?>
        <div class="col-lg-9 col-sm-9 col-xs-12">
        
            <?php if ($this->session->flashdata('mensaje') != FALSE) { echo $this->session->flashdata('mensaje'); } ?>

            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th class="text-center">#</th>
                        <th>Trabajador</th>
                        <th>ID Asistencia</th>
                        <th>Retraso</th>
                        <th>Cuerpo Nota</th>
                        <th>Fecha</th>
                        <th>Opciones</th>
                    </tr>
                </thead>
                <tbody>
                <?php if(sizeof($notas) == 0){ ?>
                    <tr class="text-center">
                        <td colspan="7"> No ha agregado ninguna configuración sobre los ausentismos y reposos</td>
                    </tr>
                <?php } ?>
                <?php $index = 1; foreach ($notas as $key): ?>
                    <tr>
                        <td class="text-center"><?php echo $index; $index++; ?></td>
                        <td><?php echo anchor('usuario/detalle/'.$key['idusuario'], '<i class="fa fa-user fa-fw"></i> '.$key['nombre'].' '.$key['apellido']); ?>
                        </td>
                        <td class="text-center"><?php echo $key['id_asistencia']; ?></td>
                        <td><?php echo $key['tiempo_retraso']; ?></td>
                        <td class="col-md-3 long-words"><?php echo $key['cuerpo_nota']; ?></td>
                        <td><?php echo $key['fecha']; ?></td>
                        <td class="text-center">
                            <a href="<?php echo site_url('nota/modificar/').'/'.$key['idnota']; ?>" class="btn btn-primary btn-sm"><i class="fa fa-edit fa-fw"></i></a>

                            <a id="eliminar_confirmacion" href="<?php echo site_url('nota/eliminar').'/'.$key['idnota']; ?>" class="btn btn-danger btn-sm"><i class="fa fa-trash-o fa-fw"></i></a>
                        </td>
                    </tr>
                <?php endforeach ?>
                </tbody>
            </table>
        </div>
        <div class="well well-sm"><p class="text-danger text-center"><i class="fa fa-exclamation fa-fw"></i> Vista para persona autorizada para poder visualizar las notas, bien sea el supervisor o recursos humanos, falta filtrar dependiendo del quien deba verlas..</p></div>
    </div>
</div>

<script type="text/javascript">
    $('[id="eliminar_confirmacion"]').click(function(e){
        e.preventDefault();
        var href = $(this).attr('href');
        swal({
            title: "¿Está seguro?",
            text: "Se eliminará este Cargo y la(s) Jornada(s) laboral(es) asociadas a el.",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#DD3333",
            confirmButtonText: "Eliminar",
            cancelButtonText: "Cancelar",
            closeOnConfirm: false
        },
        function(isConfirm){ if(isConfirm){ window.location.href = href; } });
    });
</script>