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
    #dataTable_length, #dataTable_info {
        margin-left: 15px;
        margin-top: 10px;
    }
    #dataTable_filter, #dataTable_paginate{
        margin-right: 15px;
        margin-top: 10px;
    }
</style>

<div class="mainy">
    <div class="row">
        <div class="col-md-12">
            <!-- Page title --> 
            <div class="page-title">
                <h2 class="text-right"><i class="fa fa-globe color"></i> Notas de Asistencia</h2>
                <hr>
            </div>

            <!-- Este debería ser el espacio para los flashbags -->
            <?php if ($this->session->flashdata('mensaje') != FALSE) { echo $this->session->flashdata('mensaje'); } ?>

            <div class="panel panel-default">
                <div class="panel-heading">
                    <label class="control-label">Notas de Asistencia Agregadas</label>
                </div>
                <table id="dataTable" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th class="text-center">#</th>
                            <th>Trabajador</th>
                            <th class="hidden">AsisID</th>
                            <th>Retraso</th>
                            <th>Cuerpo Nota</th>
                            <th>Tipo</th>
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
                            <td class="text-center hidden"><?php echo $key['id_asistencia']; ?></td>
                            <td><?php echo $key['tiempo_retraso']; ?></td>
                            <td class="col-md-3 long-words"><?php echo $key['cuerpo_nota']; ?></td>
                            <td><?php echo strtoupper($key['tipo']) ?></td>
                            <td><?php echo $key['fecha']; ?></td>

                            <td class="text-center">
                                <a href="<?php echo '#'; ?>" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#modificarnota" data-idnota="<?php echo $key['idnota']; ?>" data-trabajadornombre="<?php echo $key['nombre'].' '.$key['apellido']; ?>" data-notafecha="<?php echo $key['fecha']; ?>" data-nota="<?php echo $key['cuerpo_nota']; ?>" ><i class="fa fa-edit fa-fw"></i></a>

                                <a id="eliminar_confirmacion" href="<?php echo site_url('nota/eliminar').'/'.$key['idnota']; ?>" class="btn btn-default btn-sm"><i class="fa fa-trash-o fa-fw"></i></a>
                            </td>
                        </tr>
                    <?php endforeach ?>
                    </tbody>
                </table>
            </div>
            <div class="well well-sm">
                <p class="text-danger text-center">
                    <i class="fa fa-exclamation fa-fw"></i> Vista para persona autorizada para poder visualizar las notas, bien sea el supervisor o recursos humanos, falta filtrar dependiendo de quien deba verlas..</p>
            </div>
        </div>
    </div>
</div>
<div class="clearfix"></div>

<div class="modal modal-message modal-info fade in" id="modificarnota" tabindex="-1" role="dialog" aria-labelledby="modificarnota" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <label class="modal-title">Modificar Nota de Retraso</label>
                <i class="fa fa-file-text fa-fw"></i>
            </div>
            <div class="modal-body">
                <div class="col-lg-6"><label class="text-center text-info" id="trabajadornombre"></label></div>
                <div class="col-lg-6"><label class="text-center text-info">Día de la Asistencia: </label><span id="notafecha"></span></div>
                <form action="nota/actualizar" method="POST">
                    <input type="hidden" name="nota_id" id="nota_id">
                    <div class="form-group">
                      <label class="form-control-label">Nota:</label>
                      <textarea class="form-control" name="nota_cuerpo" id="nota"></textarea>
                    </div>
            </div>
            <div class="modal-footer">
                <p class="text-right">
                    <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-times fa-fw"></i> Cancelar</button>
                    </form>
                    <button type="submit" class="btn btn-primary"><i class="fa fa-save fa-fw"></i> Guardar</button>
                </p>
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

<script type="text/javascript">
    $(document).ready(function () {
        /*inicializar el data table*/
        $('#dataTable').dataTable({
            "language": {
                "url": "<?php echo base_url() ?>assets/js/lenguaje_datatable/spanish.json"
            }
        });

        /* el modal de eliminar*/
        $('#modificarnota').on('show.bs.modal', function (event) {
          var button = $(event.relatedTarget)
          var idnota = button.data('idnota')
          var trabajadornombre = button.data('trabajadornombre')
          var notafecha = button.data('notafecha')
          var nota = button.data('nota')
          
          var modal = $(this)

          modal.find('#nota_id').val(idnota)
          modal.find('#trabajadornombre').text(trabajadornombre)
          modal.find('#notafecha').text(' '+notafecha)
          modal.find('#nota').text(nota)
        });
    });
</script>