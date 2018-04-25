<script src="<?php echo base_url() ?>assets/js/jquery.min.js"></script>
<script type="text/javascript">
    base_url = '<?php echo base_url() ?>';

    $(document).ready(function () {
        //para usar dataTable en la tabla reportes
        var check = 'no';
        var table = $('#reportes').DataTable({
            "language": {
                "url": "<?php echo base_url() ?>assets/js/lenguaje_datatable/spanish.json"
            },
            "bProcessing": true,
            "serverSide": true, //Feature control DataTables' server-side processing mode.
            "bDeferRender": true,
//            "stateSave": true,
            "stateLoadParams": function (settings, data) {
                $("#buscador").val(data.search.search);
            },
//          "searching": false,
            "pagingType": "full_numbers", //se usa para la paginacion completa de la tabla
            "sDom": '<"top"lp<"clear">>rt<"bottom"ip<"clear">>', //para mostrar las opciones donde p=paginacion,l=campos a mostrar,i=informacion
            "order": [[0, "desc"]], //para establecer la columna a ordenar por defecto y el orden en que se quiere 
//          "aoColumnDefs": [{"orderable": false, "targets": [5]}],//para desactivar el ordenamiento en esas columnas
            "columnDefs": [
                {"className": "text-center","orderable": false, "targets": [6]},
                {"className": "dt-center","targets": [0,1,4]}//para centrar el texto en una columna}
            ],
            "ajax": {
                "url": "<?php echo site_url('tic_reportes/tic_reportes/list_sol') ?>",
                "type": "GET",
                "dataType": "json",
                "data": function (d) {
                    d.uno = $('#result1').val();
                    d.dos = $('#result2').val();
                    d.est = $('#estatus').val();
                    d.trab = $('#trabajadores').val();
                    d.respon = $('#responsable').val();
                    d.tipo_orden = $('#tipo_orden').val();
                    d.checkTrab = check;
                    d.dir_col = $('#dir_span').val();

//                  d.dep = <?php // echo $dep  ?>;
                },
                "dataSrc": function (json){
                    if(json.data.length > 0){ //Se evalua si la cantidad de datos pasados sea mayor que cero
//                        console.log((json.data[0].test));
                        $("#col_pdf").val(json.data[0].test);
                    }
                    return json.data;
                }
            },
         
            "drawCallback": function (settings) {
                if ((check) === 'si') {
//            check = 'si';  
//            console.log(check);
//                    table.order( [ 5, 'desc' ] );
                    var api = this.api();
                    var rows = api.rows({page: 'current'}).nodes();
                    var last = null;
                    api.column(5, {page: 'current'}).data().each(function (group, iDisplayIndex) {
                        if (last !== group) {
                            $(rows).eq(iDisplayIndex).before(
                                    '<tr class="group"><td colspan="5">Trabajador: ' + group + '</td></tr>'
                                    );
                            last = group;
                        }
                    });
                }
                if ((check) === 'respon') {
//            check = 'si';  
//            console.log(check);
                    var api = this.api();
                    var rows = api.rows({page: 'current'}).nodes();
                    var last = null;
                    api.column(5, {page: 'current'}).data().each(function (group, iDisplayIndex) {
                        if (last !== group) {
                            $(rows).eq(iDisplayIndex).before(
                                    '<tr class="group"><td colspan="6">Responsable: ' + group + '</td></tr>'
                                    );
                            last = group;
                        }
                    });
                }
                if ((check) === 'tipo') {
//            check = 'si';  
//            console.log(check);
                    var api = this.api();
                    var rows = api.rows({page: 'current'}).nodes();
                    var last = null;
                    api.column(5, {page: 'current'}).data().each(function (group, iDisplayIndex) {
                        if (last !== group) {
                            $(rows).eq(iDisplayIndex).before(
                                    '<tr class="group"><td colspan="6">Tipo de Orden: ' + group + '</td></tr>'
                                    );
                            last = group;
                        }
                    });
                }
            }
        });
        
        table.column(5).visible(false);
        table.column(6).visible(false);

        $('#buscador').keyup(function () { //establece un un input para el buscador fuera de la tabla
            table.search($(this).val()).draw(); // escribe la busqueda del valor escrito en la tabla con la funcion draw
        });

        $('#fecha1 span').html(moment().subtract(29, 'days').format('MMMM D, YYYY') + ' - ' + moment().format('MMMM D, YYYY'));

        $('#fecha1').daterangepicker({
            format: 'DD/MM/YYYY',
            startDate: moment().subtract(29, 'days'),
            endDate: moment(),
            // minDate: '01/01/2012',
            // maxDate: '12/31/2021',
            dateLimit: {days: 240},
            showDropdowns: true,
            showWeekNumbers: true,
            timePicker: false,
            timePickerIncrement: 1,
            timePicker12Hour: true,
            ranges: {
                'Hoy': [moment(), moment()],
                'Ayer': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                'Últimos 7 días': [moment().subtract(6, 'days'), moment()],
                'Últimos 30 días': [moment().subtract(29, 'days'), moment()],
                'Este mes': [moment().startOf('month'), moment().endOf('month')],
                'Mes Pasado': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
            },
            opens: 'left',
            drops: 'down',
            buttonClasses: ['btn', 'btn-sm'],
            applyClass: 'btn-primary',
            cancelClass: 'btn-default',
            separator: ' al ',
            locale: {
                applyLabel: 'Listo',
                cancelLabel: 'Cancelar',
                fromLabel: 'Desde',
                toLabel: 'Hasta',
                customRangeLabel: 'Personalizado',
                daysOfWeek: ['Do', 'Lu', 'Ma', 'Mi', 'Ju', 'Vi', 'Sa'],
                monthNames: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
                firstDay: 1
            }

        }, function (start, end, label) {
            console.log(start.toISOString(), end.toISOString(), label);
            $('#result1').val(start.format('YYYY-MM-DD') + ' ' + '00:00:00');
            $('#result2').val(end.format('YYYY-MM-DD') + ' ' + '23:59:59');
            $('#fecha1 span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
            table.draw();
        });
        $('#fecha1').on('click', function () {
            document.getElementById("fecha1").value = "";//se toma el id del elemento y se hace vacio el valor del mismo
            document.getElementById("result1").value = "";//se toma el id del elemento y se hace vacio el valor del mismo
            document.getElementById("result2").value = "";//se toma el id del elemento y se hace vacio el valor del mismo
            table.draw();//devuelve este valor a la escritura de la tabla para reiniciar los valores por defecto
        });

        $("#estatus").change(function () {//Evalua el cambio en el valor del select
            $("#estatus option:selected").each(function () { //en esta parte toma el valor del campo seleccionado
                table.draw();
            });
        });
//        $("#trabajadores").hide();
        $("#trabajadores").change(function () {//Evalua el cambio en el valor del select
            $("#trabajadores option:selected").each(function () { //en esta parte toma el valor del campo seleccionado
                table.column(5).visible(false);
                table.draw();
            });
        });
        $("#responsable").change(function () {//Evalua el cambio en el valor del select
            $("#responsable option:selected").each(function () { //en esta parte toma el valor del campo seleccionado
                table.column(5).visible(false);
                table.draw();
            });
        });
        $("#tipo_orden").change(function () {//Evalua el cambio en el valor del select
            $("#tipo_orden option:selected").each(function () { //en esta parte toma el valor del campo seleccionado
                table.column(5).visible(false);
                table.draw();
            });
        });
        $("#menu").change(function () {//Evalua el cambio en el valor del select
//            $("#menu option:selected").each(function () { //en esta parte toma el valor del campo seleccionado
            if ($("#menu").val() === '') {
                $('#responsable').select2('val', '');
                $('#tipo_orden').select2('val', '');
                $('#trabajadores').select2('val', '');
                $('#trabajadores').prop('disabled', true);
                $('#responsable').prop('disabled', true);
                $('#tipo_orden').prop('disabled', true);
                $('#worker').hide();
                $('#responsab').hide();
                $('#tipo_or').hide();
                check = 'no';
                table.order([0, 'desc']);
                table.columns(5).visible(false);
                table.columns(6).visible(false).draw();
            }
            if ($("#menu").val() === 'trab') {
                check = 'si';
//                 console.log('trab');
                $('#trabajadores').prop('disabled', false);
                $("#responsab").hide();
                $("#tipo_or").hide();
                $("#worker").show();
                $('#responsable').select2('val', '');
                $('#tipo_orden').select2('val', '');
                $('#responsable').prop('disabled', true);
                $('#tipo_orden').prop('disabled', true);
                $('#trabajadores').select2({theme: "bootstrap", placeholder: "- - SELECCIONE - -", allowClear: true});
//                table.order([5, 'asc']);
//                table.order([0,'desc']);
                table.columns(5).visible(false);
                table.columns(6).visible(false).draw();
//                table.draw();
            }
            if ($("#menu").val() === 'respon') {
                check = 'respon';
//                console.log('respon');
                $('#responsable').prop('disabled', false);
                $('#worker').hide();
                $('#tipo_or').hide();
                $('#trabajadores').select2('val', '');
                $('#tipo_orden').select2('val', '');
                $("#responsab").show();
                $('#trabajadores').prop('disabled', true);
                $('#tipo_orden').prop('disabled', true);
                mostrar_respon($('#responsable'));
                $('#responsable').select2({theme: "bootstrap", placeholder: "- - SELECCIONE - -", allowClear: true});
//                table.order([5, 'asc']);
                table.columns(5).visible(false);
                table.columns(6).visible(true).draw();
//                table.draw(); 
            }
            if ($("#menu").val() === 'tipo') {
                check = 'tipo';
                $('#tipo_orden').prop('disabled', false);
                $('#worker').hide();
                $('#responsab').hide();
                $('#responsable').select2('val', '');
                $('#trabajadores').select2('val', '');
                $("#tipo_or").show();
                $('#responsable').prop('disabled', true);
                $('#trabajadores').prop('disabled', true);
//                    mostrar_tipo_orden($('#tipo_orden'));
                $('#tipo_orden').select2({theme: "bootstrap", placeholder: "- - SELECCIONE - -", allowClear: true});
//                    table.draw();
                table.columns(5).visible(false);
                table.columns(6).visible(false).draw();
            }
        });
         // Order by the grouping
                var orden;
                $('#reportes tbody').on('click', 'tr.group', function () {
                    var currentOrder = table.order()[0];
                    if (currentOrder[0] === 5 && currentOrder[1] === 'desc') {
                        table.order([5, 'asc']).draw();
                       
                    } else {
                        table.order([5, 'desc']).draw();
                      
                    }
                    orden= table.order();
                $('#dir_span').val(orden[0][1]);
//                console.log(orden[0][0]);
                });
        $('#estatus').select2({theme: "bootstrap", placeholder: "- - ESTATUS - -", allowClear: true});
        $('#menu').select2({theme: "bootstrap", placeholder: "- - SELECCIONE - -",  minimumResultsForSearch: Infinity, allowClear: true});
//        var colum = [];
//        for (var i=0; i<table.context[0].aoColumns.length; i++) {
//            colum[i] = table.context[0].aoColumns[i].sTitle;
//        }
//        $("#header_table").val(JSON.stringify(colum));
//        console.log(table.context[0].aoColumns.length);
    });
</script>
<style>
    tr.group,
    tr.group:hover {
        background-color: #ddd !important;
    }
    th.dt-center, td.dt-center { text-align: center; }
    /*.input-group-addon {
            background-color: #fff;
    }*/
</style>
<!-- Page content -->
<div class="mainy">
    <!-- Page title -->
    <div class="page-title">
        <h2 align="right"> <img src="<?php echo base_url() ?>assets/img/tic/logo-dtic.png" class="img-rounded" alt="bordes redondeados" width="80" height="30"> <i class="fa fa-paperclip color"></i> Reportes<small> Seleccione ver detalles</small></h2> 
        <hr />
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="awidget full-width">
                <!--<form class="form-horizontal" action="<?php echo base_url() ?>mnt_solicitudes/reportes_pdf" method="post" target="_blank">-->
                <div class="awidget-head">

                </div>
                <div class="awidget-body">
                    <form class="form-horizontal" action="<?php echo base_url() ?>tic_solicitudes/reportes_pdf" method="post" target="_blank">
                        <!--<div class="table-responsive">-->
                            <input type="hidden" id="valor" name="valor">  <!--estos inputs vienen del custom js en la funcion externa de busqueda por -->
                            <input type="hidden" id="result1" name="result1"><!-- rangos para mostrar los resultados, estan ocultos despues de probar -->
                            <input type="hidden" id="result2" name="result2"><!--por lo cual se pueden cambiar a tipo text para ver como funciona la busqueda-->
                            <input type="hidden" id="col_pdf" name="col_pdf">
                            <!--<input type="hidden" id="header_table" name="header">-->
                            <input type="hidden" id="dir_span" name="dir_span">
                            <nav class="navbar navbar-default">
                                <div class="container-fluid">
                                    <!-- Brand and toggle get grouped for better mobile display -->
                                    <div class="navbar-header">
                                        <button type="button" title="Opciones de Búsqueda" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                                            <span class="sr-only">Toggle navigation</span>
                                            <span class="icon-bar"></span>
                                            <span class="icon-bar"></span>
                                            <span class="icon-bar"></span>
                                        </button>
                                    </div>
                                    <!-- Collect the nav links, forms, and other content for toggling -->
                                    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                                        <div class="navbar-form navbar-left" >
                                            <div class="input-group">
                                                <span class="input-group-addon" id="basic-addon1"><i class="fa fa-calendar"></i></span>
                                                <input type="search"  class="form-control input-sm" style="width: 200px" name="fecha1" id="fecha1" placeholder=" Búsqueda por Fechas" />
                                                <span class="input-group-addon" id="basic-addon2"><i class="fa fa-search"></i></span>
                                                <input type="text" class="form-control input-sm" style="width: 250px" id="buscador" name="buscador" placeholder=" Búsqueda general">
                                                <span class="input-group-addon" id="basic-addon2"><i class="glyphicon glyphicon-stats"></i></span>
                                                <select class="form-control input-sm" id="estatus" name="estatus" style="width: 200px" align="center">
                                                    <option></option>
                                                    <?php foreach ($estatus as $all): ?>
                                                        <option value="<?php echo $all->id_estado ?>"><?php echo $all->descripcion ?></option>
                                                    <?php endforeach; ?>
                                                </select>
                                            </div>
                                        </div>
<!--                                        <ul class="nav navbar-nav navbar-right">
                                            <li></li>
                                        </ul>-->
                                    </div><!-- /.navbar-collapse -->
                                </div><!-- /.container-fluid -->
                            </nav>
                            <nav class="navbar navbar-default">
                                <div class="container-fluid">
                                    <!-- Brand and toggle get grouped for better mobile display -->
                                    <div class="navbar-header">
                                        <button type="button" title="Opciones de Búsqueda" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-4" aria-expanded="false">
                                            <span class="sr-only">Toggle navigation</span>
                                            <span class="icon-bar"></span>
                                            <span class="icon-bar"></span>
                                            <span class="icon-bar"></span>
                                        </button>
                                    </div>
                                    <!-- Collect the nav links, forms, and other content for toggling -->
                                    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-4">
                                        <div class="navbar-form navbar-center">
                                            <div class="row">
                                                <!--<div class="col-md-2 col-xs-2"></div>-->
                                                <div class="col-md-4 col-xs-12">
                                                    <div class="input-group col-md-12 col-xs-12" align="center">
    <!--                                            <span class="input-group-addon" id="basic-addon1"></span>-->
                                                        <span class="input-group-addon" id="basic-addon1"><i class="fa fa-search-plus"></i></span>
                                                        <select class="form-control input-sm" id="menu" name="menu"  align="center">
                                                            <option></option>
                                                            <option value="trab">TRABAJADOR</option>
                                                            <option value="respon">RESPONSABLE</option>
                                                            <option value="tipo">TIPO DE ORDEN</option>   
                                                        </select>
                                                    </div>
                                                </div>
                                                <!--<div  class="col-md-4 col-xs-4" id="worker" style="display:none" align="center">-->
                                                    <div class="input-group col-md-4 col-xs-12" id="worker" style="display:none" align="center">
                                                        
                                                        <select class="form-control input-sm" id="trabajadores"  name="trabajadores"  disabled >
                                                            <option></option>
                                                            <?php foreach ($trabajadores as $all): ?>
                                                                <option value="<?php echo $all['id_usuario'] ?>"><?php echo $all['nombre'] . ' ' . $all['apellido'] ?></option>
                                                            <?php endforeach; ?>
                                                        </select>
                                                        <span class="input-group-addon" id="basic-addon1"><i class="fa fa-search-plus"></i></span>
                                                    </div>
                                                <!--</div>-->
                                                <!--<div class="col-md-4" id="responsab" style="display:none" align="center">-->
                                                    <div class="input-group col-md-4 col-xs-12" id="responsab" style="display:none" align="center" >
                                                        
                                                        <select class="form-control input-sm" id="responsable" name="responsable" disabled>
                                                            <option></option>
                                                        </select>
                                                        <span class="input-group-addon" id="basic-addon1"><i class="fa fa-search-plus"></i></span>
                                                    </div>
                                                <!--</div>-->
                                                <!--<div class="col-md-6" id="tipo_or" style="display:none" align="center">-->
                                                    <!--<div class="input-group">-->
    <!--                                                <span class="input-group-addon">
                                                        <input id="test3" type="checkbox" onclick="mostrar_tipo_orden($('#tipo_orden'))" />
                                                    </span>-->
                                                    <div class="input-group col-md-4 col-xs-12" id="tipo_or" style="display:none" align="center">
                                                        
                                                        <select class="form-control input-sm" id="tipo_orden" name="tipo_orden"  disabled>
                                                            <option></option>
                                                            <?php foreach ($tipo as $tip): ?>
                                                                <option value="<?php echo $tip->id_tipo ?>"><?php echo $tip->tipo_orden ?></option>
                                                            <?php endforeach; ?>   
                                                        </select>
                                                        <span class="input-group-addon" id="basic-addon1"><i class="fa fa-search-plus"></i></span>
                                                    </div>
                                                <!--</div>-->    
                                            </div>
                                        </div>
<!--                                        <ul class="nav navbar-nav navbar-right">
                                            <li></li>
                                        </ul>-->
                                    </div><!-- /.navbar-collapse -->
                                </div><!-- /.container-fluid -->
                            </nav>

                            <div class="col-lg-12">
                            </div>
                            <button class="btn btn-danger btn-sm pull-right" id="reportePdf" type="submit" title="Crear PDF"><i class="fa fa-file-pdf-o fa-2x"></i></button>
                            <div class="col-lg-12 col-md-12 col-sm-12">
                                <table id="reportes" class="table table-hover table-bordered table-condensed" cellspacing="0" align="center" width="100%">
                                    <thead>
                                        <tr class="color">
                                            <th>Orden</th>                                       
                                            <th>Fecha</th>
                                            <th>Dependencia</th>
                                            <th>Asunto</th>
                                            <th>Estatus</th>
                                            <th></th>
                                            <th>Trabajadores</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                    </tbody>
                                </table>
                            </div>
                        <!--</div>-->
                    </form>
                </div>
            </div>
        </div>
    </div>      
</div>
<div class="clearfix"></div>
