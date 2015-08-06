<script type="text/javascript">
    base_url = '<?= base_url() ?>';
</script>

<!-- Page content -->

<div class="mainy">

    <?php if ($this->session->flashdata('create_ubi') == 'success') : ?>
        <div class="alert alert-success" style="text-align: center">Ubicación agregada con éxito</div>
    <?php endif ?>
    <?php if ($this->session->flashdata('create_ubi') == 'error') : ?>
        <div class="alert alert-danger" style="text-align: center">Error al guardar... Verfique los datos</div>
    <?php endif ?>

        <!-- Page title --> 
    <div class="page-title">
        <h2 align="right"><i class="fa fa-desktop color"></i>Ubicaciones de Dependencias</h2>
        <hr />
    </div>

    <!-- Page title -->
    <div class="row">
        <div class="panel panel-default">
            <div class="panel-heading">
                <label class="control-label">Agregar Ubicaciones</label>                
            </div>
            <div class="panel-body">
                <form class="form-horizontal" action="<?php echo base_url() ?>index.php/mnt_ubicaciones/mnt_ubicaciones/guardar_ubicacion" method="post" name="orden" id="orden" enctype="multipart/form-data" onsubmit="return vali_ubicacion()">
                <!-- SELECT DE DEPENDENCIA-->
                            <div class="form-group">
                                <label class="col-lg-2 control-label " for = "dependencia_label">Dependencia:</label>
                                <div class="col-lg-4"> 
                                    <select class="form-control input-sm select2" id = "dependencia_agregar" name="dependencia_agregar">
                                        <option value=""></option>
                                        <?php foreach ($dependencia as $ubi): ?>
                                            <option value = "<?php echo $ubi->id_dependencia ?>"><?php echo $ubi->dependen ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>

                            <!-- UBICACION-->
                            <div class="form-group">
                                  <div id="ubica" class="col-lg-12">                
                                
                                  </div>
                            </div>
                            
                                 <div class="modal-footer">
                                     <button type="submit" id="guarda" class="btn btn-primary" disabled>Guardar</button>
                                <a href="<?php echo base_url() ?>index.php/" class="btn btn-default">Cancelar</a>

                            </div> 
                        </form>

            </div>
        </div>
    </div>
</div>

