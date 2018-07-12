<script src="<?php echo base_url() ?>assets/js/jquery.min.js"></script>
<script type="text/javascript">
    base_url = '<?php echo base_url() ?>';
    
    $(document).ready(function () {
        var table = $('#tipo_orden').DataTable({
            "language": {
                        "url": "<?php echo base_url() ?>assets/js/lenguaje_datatable/spanish.json"
                    },
                    "bProcessing": true,
                    //stateSave: true,
                    "stateLoadParams": function (settings, data) {
                        //$("#auto").val(data.search.search);
                    },
                    "bDeferRender": true,
                    "serverSide": true, //Feature control DataTables' server-side processing mode.
                    "pagingType": "full_numbers", //se usa para la paginacion completa de la tabla
                    "sDom": '<"row"<"col-sm-6"l><"col-sm-6">>rt<"row"<"col-sm-4"i><"col-sm-8"p>>', //para mostrar las opciones donde p=paginacion,l=campos a mostrar,i=informacion
                    //"order": [[0, "asc"]], //para establecer la columna a ordenar por defecto y el orden en que se quiere 
                    //"aoColumnDefs": [{"orderable": false, "targets": [-1]}], //para desactivar el ordenamiento en esas columnas
                    "ajax": {
                        "url": "<?php echo site_url('tipos') ?>",
                        "type": "GET"
                    },
                    "columns": [
                        {"data": "id"},
                        {"data": "cuadrilla"},
                        {"data": "tipo_orden"}
                    ]
                });

            });

</script>

<div class="mainy">

    <!-- Page title --> 
    <div class="page-title">
        <h2 align="right">
            <!--<i class="fa fa-desktop color"></i>-->
            <img src="<?php echo base_url() ?>assets/img/tic/logo-dtic.png" class="img-rounded" alt="bordes redondeados" width="80" height="30">
            Tipos de Solicitud
            <small>Seleccione para ver detalles </small>
        </h2>
        <hr />
    </div>
    <!--<div class="row">-->
    <div class="panel panel-default">


        <div class="panel-body">

            <div class="col-lg-12 col-md-12 col-sm-12">
                <table id="tipo_orden" class="table table-hover table-bordered table-condensed nowrap" cellspacing="0" align="center" width="100%">
                    <thead>
                        <tr>
                            <th><div align="center"></div></th>
                            <th><div align="center">Grupo</div></th>
                            <th><div align="center">Tipo de Solicitud</div></th>
                    </thead>
                    <tbody>

                    </tbody>
                </table>
            </div>
            <!--</div>-->
        </div>
    </div>
    <!--    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#cuad">
            Modal Prueba
        </button>-->
</div> 
