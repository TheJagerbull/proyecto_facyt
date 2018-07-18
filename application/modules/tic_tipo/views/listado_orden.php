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
                                    //url = "<?php echo base_url() ?>tipo_orden/add";
                                   // $(location).attr('href',url);
                                   $('#tipo').modal('show');
                                }
                        }
                    ],
                    "order": [[1, "asc"]], //para establecer la columna a ordenar por defecto y el orden en que se quiere 
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
    <?php if ($this->session->flashdata('create_tipo') == 'success') : ?>
        <div class="alert alert-success alert-dismissible fade in" style="text-align: center">
        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>Tipo de orden agregada con éxito</div>
    <?php endif ?>
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
   <!-- modal agregar tipo -->   
    <div id="tipo" class="modal modal-message modal-info fade" tabindex="-1" role="dialog" aria-labelledby="f" >
    <div class="modal-dialog" role="document">
        <div class="modal-content">
                <div class="modal-header">
                    <label class="modal-title">Agregar tipo de solicitud</label>
                    <span><i class="fa fa-plus-square-o" aria-hidden="true"></i></span>
                </div>
                <div class="modal-body">
                    <!--<div class="row">
                        <div class="col-md-12 text-center">
                                <div class="well well-sm"> 
                                    Solicitud Número: 
                                </div>
                        </div>
                    </div>-->
                    <form class="form" action="<?php echo base_url() ?>tipo_orden/add" method="post" name="modific" id="modific">
                        <input  type="hidden" name="uri" value="tic_tipos_solicitud">
                                    <div class="well well-sm">
                                        <div class="row"> 
                                            <div class="col-md-12 text-center">
                                                <label class="control-label">Grupo de trabajo</label>
                                            </div>
                                            <div class="col-md-12">
                                                <select class ="form-control input-sm select2" id = "f_select" name="grupo_select">
                                                    <option></option>
                                                <?php foreach ($grupos as $group): ?>
                                                    <option value = "<?php echo $group->cuadrilla ?>"><?php echo strtoupper($group->cuadrilla)?></option>
                                                <?php endforeach; ?>
                                                </select>
                                            </div>
                                            <div class="col-md-12"><br></div>
                                            <div class="col-md-12 text-center">
                                                <label class="control-label">Tipo de Solicitud</label>
                                            </div>
                                            <div class="col-md-12">
                                                <input type="text" class="form-control" id="tipos" name="tipos"placeholder="Tipo de Solicitud">    
                                            </div>
                                            
                                        </div>
                                    </div>
                    </form>
                </div>
            
                <div class="modal-footer">
                    <div class = "col-md-12">
                        <button type="button" class="btn btn-default" data-dismiss="modal" aria-hidden="true">Cancelar</button>
                        <button type="submit" form="modific" id="" class="btn btn-primary">Guardar cambios</button>
                    </div>
                </div>
            
        </div>   
    </div>
</div>
     <!-- fin de modal agregar tipo-->