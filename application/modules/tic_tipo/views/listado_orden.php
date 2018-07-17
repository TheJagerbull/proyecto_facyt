<script src="<?php echo base_url() ?>assets/js/jquery.min.js"></script>
<script type="text/javascript">
    base_url = '<?php echo base_url() ?>';
    
    $(document).ready(function () {
        var groupColumn = 1;
        var table = $('#tipo_orden').DataTable({
            "language": {
                        "url": "<?php echo base_url() ?>assets/js/lenguaje_datatable/spanish.json"
                    },
                    "bProcessing": true,
                    //stateSave: true,
                    "stateLoadParams": function (settings, data) {
                        $("#buscar").val(data.search.search);
                    },
                    "bDeferRender": true,
                    "serverSide": true, //Feature control DataTables' server-side processing mode.
                    "pagingType": "first_last_numbers", //se usa para la paginacion completa de la tabla
                    "sDom": '<"row"<"col-sm-2"B><"col-sm-4"l><"col-sm-6"><"col-sm-12"p>>rt<"row"<"col-sm-4"i><"col-sm-8"p>>', //para mostrar las opciones donde p=paginacion,l=campos a mostrar,i=informacion
                    buttons: [
                        {
                            text: '<i class="fa fa-plus "></i> Agregar',"className": 'btn btn-primary btn-sm',
                                action: function ( e, dt, node, config ) {
                                    alert( 'Button activated' );
                                }
                        }
                    ],
                    "order": [[0, "asc"]], //para establecer la columna a ordenar por defecto y el orden en que se quiere 
                    "aoColumnDefs": [{"orderable": false, "targets": [-1]} , { "visible": false, "targets": groupColumn }], //para desactivar el ordenamiento en esas columnas
                         "drawCallback": function ( settings ) {
                            var api = this.api();
                            var rows = api.rows( {page:'current'} ).nodes();
                            var last=null;
 
                            api.column(groupColumn, {page:'current'} ).data().each( function ( group, i ) {
                             if ( last !== group ) {
                                $(rows).eq( i ).before(
                                '<tr class="group"><td colspan="5">'+group+'</td></tr>'
                            );
 
                                last = group;
                             }
                    } );
                },
                    "ajax": {
                        "url": "<?php echo site_url('tipos') ?>",
                        "type": "GET"
                    },
                    "columns": [
                        {"data": "id"},
                        {"data": "cuadrilla"},
                        {"data": "tipo_orden"},
                        {"data": "edit"}
                    ]
                });
        $('#buscar').keyup(function () { //establece un un input para el buscador fuera de la tabla
            table.search($(this).val()).draw(); // escribe la busqueda del valor escrito en la tabla con la funcion draw
        });
        // Order by the grouping
        $('#tipo_orden tbody').on( 'click', 'tr.group', function () {
        var currentOrder = table.order()[0];
        if ( currentOrder[0] === groupColumn && currentOrder[1] === 'asc' ) {
            table.order( [ groupColumn, 'desc' ] ).draw();
        }
        else {
            table.order( [ groupColumn, 'asc' ] ).draw();
        }
    } );

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
        <nav class="navbar navbar-default" role="navigation">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
                    <span class="sr-only">Desplegar navegación</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" >Tipos de Solicitud</a>
            </div>
            <div class="collapse navbar-collapse navbar-ex1-collapse">
                <ul class="nav navbar-nav navbar-right">
                    <li> 
                        <div class="navbar-brand btn-group btn-group-xs " role="group">
                          
                        </div>
                    </li>
                </ul>
            </div>
        </nav>

        <div class="panel-body">
            <div class="col-lg-12 col-md-12 col-sm-12">
                <div class="col-sm-6">
                    <div class="input-group">
                        <input id="buscar" name="buscar" class="form-control" placeholder="Buscar...">
                            <span class="input-group-addon">
                                 <i class="fa fa-search"></i>
                            </span>
                    </div>
                    <div class="col-sm-6"></div>
                </div>
                <table id="tipo_orden" class="table table-hover table-bordered table-condensed table-striped nowrap" cellspacing="0" align="center" width="100%">
                    <thead>
                        <tr class="active">
                            <th><div align="center"></div></th>
                            <th><div align="center">Grupo</div></th>
                            <th><div align="center">Tipo de Solicitud</div></th>
                            <th><div align="center">Acciones</div></th>
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
