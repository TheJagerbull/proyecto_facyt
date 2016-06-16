<script src="<?php echo base_url() ?>assets/js/jquery-1.11.2.js"></script>
<script type="text/javascript">
    base_url = '<?php echo base_url() ?>';
    $(document).ready(function () {
        //para usar dataTable en la table solicitudes
        var table = $('#lista_depen').DataTable({
            "language": {
                "url": "<?php echo base_url() ?>assets/js/lenguaje_datatable/spanish.json"
            },
            "ajax": "<?php echo base_url('index.php/dec_dependencia/dec_dependencia/all_Dependencias/'); ?>",
            "bProcessing": true,
            "bDeferRender": true,
            "pagingType": "full_numbers", //se usa para la paginacion completa de la tabla
            // "sDom": '<"top"lfp<"clear">>rt<"bottom"ip<"clear">>', //para mostrar las opciones donde f=busqueda, p=paginacion,l=campos a mostrar,i=informacion
            "sDom": '<"row"<"col-sm-6"l><"col-sm-6"f>><"row"<"col-sm-12"p>><"row"<"col-lg-12 col-sm-12"rt>><"row"<"col-sm-4"i><"col-sm-8"p>>',
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

    <?php if ($this->session->flashdata('nueva_dependencia') == 'success') : ?>
        <div class="alert alert-success" style="text-align: center">Ubicación agregada con éxito</div>
    <?php endif ?>
    <?php if ($this->session->flashdata('nueva_dependencia') == 'existe') : ?>
        <div class="alert alert-danger" style="text-align: center">Error al guardar... La dependencia ya existe</div>
    <?php endif ?>

    <!-- Page title --> 
    <div class="page-title">
        <h2 align="right"><i class="fa fa-desktop color"></i>Control de Dependencias</h2>
        <hr />
    </div>

    <!-- Page title -->
    <div class="row">
        <div class="col-lg-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <label class="control-label">Dependencias</label>
                <div class="btn-group btn-group-sm pull-right">
                    <a href="#agregar" class="btn btn-primary" data-toggle="modal">Agregar</a>
                </div>         
            </div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-1 col-sm-1">
                    </div>
                    <div class="col-md- col-sm-10">
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
                    </div>
                    <div class="col-md-1 col-sm-1">
                    </div>
                </div>
            </div>
            <div class="panel-footer">

            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div id="agregar" class="modal modal-message modal-info fade" tabindex="-1" role="dialog" aria-labelledby="modificacion" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <span><i class="glyphicon glyphicon-save"></i></span>
            </div>
            <form class="form" action="<?php echo base_url() ?>index.php/dependencia/guardar" method="post" onsubmit="return valida_nomb($('#dependen'))" name="modifica" id="modifica">
                <div class="modal-body row">
                    <div class="col-md-12"><br></div>
                    <div class="col-md-1"></div>
                    <div class="col-md-10">                    
                        <div class="form-group">
                            <label class="control-label col-md-2" for="nombre">Nombre: </label>
                            <div class="col-md-8">
                                <input autocomplete="off" type="text" class="form-control input-sm" id="dependen" name="dependen">
                            </div>
                        </div>
                        <!--                        <div class="col-md-2"><br></div>-->
                    </div>  
                    <div class="col-md-2"><br></div>
                    <!--<hr>-->
                </div>
                <div class="modal-footer">
                    <input  type="hidden" name="uri" value="<?php echo 'index.php/'.$this->uri->uri_string();?>"/>
                    <button type="button" class="btn btn-default" data-dismiss="modal" aria-hidden="true">Cancelar</button>
                    <button type="submit" id="hola"class="btn btn-primary">Guardar cambios</button>
                </div>
            </form>

        </div>
    </div>
</div>
<script>

    //funcion para validar que el input motivo no quede vacio(esta funcion se llama en el formulario de estatus de la solicitud)
    function valida_nomb(txt) {
        var $nomb = $(txt).val().trim();

        if($nomb === '') {  
        $(txt).focus();
        swal({
            title: "Error",
            text: "El nombre es obligatorio",
            type: "error"
        });
        return false;  
        }else if ($nomb.length < 3) {
            $(txt).focus();
            swal({
                title: "Error",
                text: "El nombre debe ser de tres o mas caracteres",
                type: "error"
//            timer: 3000
            });
            return false;
        }
    }
</script>
    




