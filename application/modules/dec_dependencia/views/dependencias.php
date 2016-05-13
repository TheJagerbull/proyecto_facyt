<script src="<?php echo base_url() ?>assets/js/jquery-1.11.2.js"></script>
<script type="text/javascript">
    base_url = '<?php echo base_url() ?>';
    $(document).ready(function () {
        //para usar dataTable en la table solicitudes
        var table = $('#lista_depen').DataTable({
            "ajax": "<?php echo base_url('index.php/dec_dependencia/dec_dependencia/all_Dependencias/'); ?>",
            "bProcessing": true,
            "bDeferRender": true,
            "pagingType": "full_numbers", //se usa para la paginacion completa de la tabla
            "sDom": '<"top"lfp<"clear">>rt<"bottom"ip<"clear">>' //para mostrar las opciones donde f=busqueda, p=paginacion,l=campos a mostrar,i=informacion
         });
        $('#reset').on('click', function () {
            $('#buscador').val("");//se toma el id del elemento y se hace vacio el valor del mismo
            table  //Aqui se hace el vaciado de la busqueda. 
             .search( '' )
             .columns().search( '' )
             .draw();
        });
});    
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
        <h2 align="right"><i class="fa fa-desktop color"></i>Control de Dependencias</h2>
        <hr />
    </div>

    <!-- Page title -->
    <div class="row">
        <div class="panel panel-default">
            <div class="panel-heading">
                <label class="control-label">Dependencias</label>                
            </div>
            <div class="panel-body">
                <!--<form class="form-horizontal" action="<?php echo base_url() ?>index.php/mnt_ubicaciones/mnt_ubicaciones/guardar_ubicacion" method="post" name="orden" id="orden" enctype="multipart/form-data" onsubmit="return vali_ubicacion()">-->
                    <div class="row">
                         <div class="col-md-3 col-sm-3">

                        </div>
                    <div class="col-md-6 col-sm-6">
                      <table id='lista_depen' class='table table-hover table-bordered table-condensed'>
                        <thead align="center">
                            <tr>
                                <th></th>
                                <th>Dependencia</th>
                            </tr>
                        </thead>
                        <tbody>
                            
                        </tbody>
                      </table>
<!--                    </div>
                            <div class="modal-footer">
                                     <button type="submit" id="guarda" class="btn btn-primary" disabled>Guardar</button>
                                <a href="<?php echo base_url() ?>index.php/" class="btn btn-default">Cancelar</a>

                            </div> 
                    </div>-->
                        <!--</form>-->
                    
                    </div>
                    </div>
        </div>
        </div>
    </div>

