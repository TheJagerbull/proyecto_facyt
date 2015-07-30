<script type="text/javascript">
    base_url = '<?= base_url() ?>';
</script>
<style type="text/css">
.modal-content {
    -webkit-border-radius: 0;
    -webkit-background-clip: padding-box;
    -moz-border-radius: 0;
    -moz-background-clip: padding;
    border-radius: 6px;
    background-clip: padding-box;
    -webkit-box-shadow: 0 0 40px rgba(0,0,0,.5);
    -moz-box-shadow: 0 0 40px rgba(0,0,0,.5);
    box-shadow: 0 0 40px rgba(0,0,0,.5);
    color: #000;
    background-color: #fff;
    border: rgba(0,0,0,0);
}

 .modal-message .modal-body, .modal-message .modal-footer, .modal-message .modal-header, .modal-message .modal-title {
    background: 0 0;
    border: none;
    margin: 0;
    padding: 0 20px;
    text-align: center!important;
}
.modal-message .modal-title {
    font-size: 17px;
    color: #737373;
    margin-bottom: 3px;
}

.modal-message .modal-body {
    color: #737373;
}

.modal-message .modal-header {
    color: #fff;
    margin-bottom: 10px;
    padding: 15px 0 8px;
}
.modal-message .modal-header .fa, 
.modal-message .modal-header 
.glyphicon, .modal-message 
.modal-header .typcn, .modal-message .modal-header .wi {
    font-size: 20px;
}

.modal-message .modal-footer {
    margin: 25px 0 20px;
    padding-bottom: 10px;
}

.modal-backdrop.in {
    zoom: 1;
    filter: alpha(opacity=75);
    -webkit-opacity: .75;
    -moz-opacity: .75;
    opacity: .75;
}
/*.modal-backdrop {
    background-color: #fff;
}*/
.modal-message.modal-success .modal-header {
    color: #53a93f;
    border-bottom: 3px solid #a0d468;
}

.modal-message.modal-info .modal-header {
    color: #57b5e3;
    border-bottom: 3px solid #57b5e3;
}

.modal-message.modal-danger .modal-header {
    color: #d73d32;
    border-bottom: 3px solid #e46f61;
}

.modal-message.modal-warning .modal-header {
    color: #f4b400;
    border-bottom: 3px solid #ffce55;
}

</style>


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

