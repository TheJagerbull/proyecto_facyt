<script src="<?php echo base_url() ?>assets/js/jquery.min.js"></script>
<script type="text/javascript">
    base_url = '<?php echo base_url() ?>';

    $(document).ready(function () {
        //
// Pipelining function for DataTables. To be used to the `ajax` option of DataTables //
        $.fn.dataTable.pipeline = function (opts) {
            // Configuration options
            var conf = $.extend({
                pages: 5, // number of pages to cache
                url: "<?php echo base_url() ?>tic_solicitudes/solicitudes", // script url
                data: null, // function or object with parameters to send to the server
                // matching how `ajax.data` works in DataTables
                method: 'GET' // Ajax HTTP method
            }, opts);

            // Private variables for storing the cache
            var cacheLower = -1;
            var cacheUpper = null;
            var cacheLastRequest = null;
            var cacheLastJson = null;

            return function (request, drawCallback, settings) {
                var ajax = false;
                var requestStart = request.start;
                var drawStart = request.start;
                var requestLength = request.length;
                var requestEnd = requestStart + requestLength;

                if (settings.clearCache) {
                    // API requested that the cache be cleared
                    ajax = true;
                    settings.clearCache = false;
                } else if (cacheLower < 0 || requestStart < cacheLower || requestEnd > cacheUpper) {
                    // outside cached data - need to make a request
                    ajax = true;
                } else if (JSON.stringify(request.order) !== JSON.stringify(cacheLastRequest.order) ||
                        JSON.stringify(request.columns) !== JSON.stringify(cacheLastRequest.columns) ||
                        JSON.stringify(request.search) !== JSON.stringify(cacheLastRequest.search)
                        ) {
                    // properties changed (ordering, columns, searching)
                    ajax = true;
                }

                // Store the request for checking next time around
                cacheLastRequest = $.extend(true, {}, request);

                if (ajax) {
                    // Need data from the server
                    if (requestStart < cacheLower) {
                        requestStart = requestStart - (requestLength * (conf.pages - 1));

                        if (requestStart < 0) {
                            requestStart = 0;
                        }
                    }

                    cacheLower = requestStart;
                    cacheUpper = requestStart + (requestLength * conf.pages);

                    request.start = requestStart;
                    request.length = requestLength * conf.pages;

                    // Provide the same `data` options as DataTables.
                    if ($.isFunction(conf.data)) {
                        // As a function it is executed with the data object as an arg
                        // for manipulation. If an object is returned, it is used as the
                        // data object to submit
                        var d = conf.data(request);
                        if (d) {
                            $.extend(request, d);
                        }
                    } else if ($.isPlainObject(conf.data)) {
                        // As an object, the data given extends the default
                        $.extend(request, conf.data);
                    }

                    settings.jqXHR = $.ajax({
                        "type": conf.method,
                        "url": conf.url,
                        "data": request,
                        "dataType": "json",
                        "cache": false,
                        "success": function (json) {
                            cacheLastJson = $.extend(true, {}, json);

                            if (cacheLower !== drawStart) {
                                json.data.splice(0, drawStart - cacheLower);
                            }
                            if (requestLength >= -1) {
                                json.data.splice(requestLength, json.data.length);
                            }

                            drawCallback(json);
                        }
                    });
                } else {
                    json = $.extend(true, {}, cacheLastJson);
                    json.draw = request.draw; // Update the echo for each response
                    json.data.splice(0, requestStart - cacheLower);
                    json.data.splice(requestLength, json.data.length);

                    drawCallback(json);
                }
            };
        };

// Register an API method that will empty the pipelined data, forcing an Ajax
// fetch on the next draw (i.e. `table.clearPipeline().draw()`)
        $.fn.dataTable.Api.register('clearPipeline()', function () {
            return this.iterator('table', function (settings) {
                settings.clearCache = true;
            });
        });

        //para usar dataTable en la table solicitudes
        var table = $('#solicitudes').DataTable({
            "language": {
                "url": "<?php echo base_url() ?>assets/js/lenguaje_datatable/spanish.json"
            },
            "bProcessing": true,
            "serverSide": true, //Feature control DataTables' server-side processing mode.
            "bDeferRender": true,
//            stateSave: true,
            "stateLoadParams": function (settings, data) {
                $("#buscador").val(data.search.search);
            },
//        "searching": false,
            "pagingType": "full_numbers", //se usa para la paginacion completa de la tabla
            "sDom": '<"top"lp<"clear">>rt<"bottom"ip<"clear">>', //para mostrar las opciones donde p=paginacion,l=campos a mostrar,i=informacion
            "order": [[0, "desc"]], //para establecer la columna a ordenar por defecto y el orden en que se quiere 
            "aoColumnDefs": [{"orderable": false, "targets": [6, 7]}, //para desactivar el ordenamiento en esas columnas
                {"className": "dt-center", "targets": [0, 1, 4, 5,6,7]}],
            "ajax": $.fn.dataTable.pipeline({
                "url": "<?php echo base_url() ?>tic_solicitudes/solicitudes",
                "type": "GET",
                "data": function (d) {
                    d.uno = $('#result1').val();
                    d.dos = $('#result2').val();
                    d.dep = <?php echo $dep ?>;
                }
            })
        });
<?php if ($all_status && $edit_status) { ?>
            table.column(5).visible(true);//para hacer invisible una columna usando table como variable donde se guarda la funcion dataTable 
            table.column(4).visible(false);
<?php } elseif ($all_status || $status_proceso) { ?>
            table.column(5).visible(false);//para hacer invisible una columna usando table como variable donde se guarda la funcion dataTable 
            table.column(4).visible(true);
<?php } else { ?>
            table.column(5).visible(false);//para hacer invisible una columna usando table como variable donde se guarda la funcion dataTable 
            table.column(4).visible(false);
<?php };
if ($asig_per) {
    ?>
            table.column(6).visible(true);
            table.column(7).visible(true);
<?php } else { ?>
            table.column(6).visible(false);
            table.column(7).visible(false);
<?php } ?>
//        $('#buscador').text('');
        //$('div.dataTables_filter').appendTo(".search-box");//permite sacar la casilla de busqueda a un div donde apppendTo se escribe el nombre del div destino
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
                    table.search($('#result1').val(start.format('YYYY-MM-DD') + ' ' + '00:00:00') + ' ' + $('#result2').val(end.format('YYYY-MM-DD') + ' ' + '23:59:59')).draw();
        });
        $('#fecha1').on('click', function () {
            document.getElementById("fecha1").value = "";//se toma el id del elemento y se hace vacio el valor del mismo
            document.getElementById("result1").value = "";//se toma el id del elemento y se hace vacio el valor del mismo
            document.getElementById("result2").value = "";//se toma el id del elemento y se hace vacio el valor del mismo
            table.search($('#result1').val()).draw();//devuelve este valor a la escritura de la tabla para reiniciar los valores por defecto
        });
//        $('a.toggle-vis').on('click', function (e) {//esta funcion se usa para mostrar columnas ocultas de la tabla donde a.toggle-vis es el <a class> de la vista 
//            e.preventDefault();
//
//            // toma el valor que viene de la vista en <a data-column>para establecer la columna a mostrar
//            var column = table.column($(this).attr('data-column'));
//
//            // Esta es la funcion que hace el cambio de la columna
//            column.visible(!column.visible());
//        });       
    });
    
    function sel(select) {
//        console.log($("#cuadrilla_select"+sol));
        ($(select)).select2({ placeholder: "--SELECCIONE--", allowClear: true});     
//        ($("#cuadrilla_select"+sol)).select2({ placeholder: "--SELECCIONE--", allowClear: true});
    }
</script>
<!-- Page content -->
<style type="text/css">
    th.dt-center, td.dt-center { text-align: center; }

    .fancy-checkbox input[type="checkbox"],
    .fancy-checkbox .checked {
        display: none;
    }

    .fancy-checkbox input[type="checkbox"]:checked ~ .checked
    {
        display: inline-block;
    }

    .fancy-checkbox input[type="checkbox"]:checked ~ .unchecked
    {
        display: none;
    }
    /*a:link, a:visited{  
    text-decoration:none;  
    }  
    a span {text-decoration: underline;}*/
</style>
<div class="mainy">
    <!--<a href="'.base_url().'tic_cuadrilla/detalle/'. $r->id.'">'.$r->cuadrilla.'</a> Para cuadrillas get cuadrillas--> 

    <?php if ($this->session->flashdata('create_orden') == 'success') : ?>
        <div class="alert alert-success" style="text-align: center">Solicitud creada con éxito</div>
    <?php endif ?>
    <?php if ($this->session->flashdata('create_orden') == 'error') : ?>
        <div class="alert alert-danger" style="text-align: center">Ocurrió un problema creando su solicitud</div>
    <?php endif ?>
    <?php if ($this->session->flashdata('asigna_cuadrilla') == 'success') : ?>
        <div class="alert alert-success" style="text-align: center">Cuadrilla asignada con éxito</div>
    <?php endif ?>
    <?php if ($this->session->flashdata('asigna_cuadrilla') == 'responsable') : ?>
        <div class="alert alert-success" style="text-align: center">Responsable de la orden modificado con éxito</div>
    <?php endif ?>
    <?php if ($this->session->flashdata('asigna_cuadrilla') == 'error') : ?>
        <div class="alert alert-danger" style="text-align: center">Ocurrió un problema asignando la cuadrilla... Verifique los datos</div>
    <?php endif ?>
    <?php if ($this->session->flashdata('asigna_cuadrilla') == 'quitar') : ?>
        <div class="alert alert-success" style="text-align: center">Proceso realizado con éxito... Recuerde volver asignar la cuadrilla</div>
    <?php endif ?>
    <?php if ($this->session->flashdata('asign_help') == 'success') : ?>
        <div class="alert alert-success" style="text-align: center">Proceso realizado con éxito</div>
    <?php endif ?>
    <?php if ($this->session->flashdata('asign_help') == 'error') : ?>
        <div class="alert alert-danger" style="text-align: center">Ocurrió un problema Realizando el proceso</div>
    <?php endif ?>
    <?php if ($this->session->flashdata('estatus_orden') == 'success') : ?>
        <div class="alert alert-success" style="text-align: center">El cambio de estatus fué agregado con éxito</div>
    <?php endif ?>
    <?php if ($this->session->flashdata('estatus_orden') == 'error') : ?>
        <div class="alert alert-danger" style="text-align: center">Ocurrió un problema cambiando el estatus de la solicitud... Debe seleccionar una opción</div>
<?php endif ?>


    <!-- Page title --> 
    <div class="page-title">
        <h2 align="right">
            <!--<i class="fa fa-desktop color"></i>-->
            <img src="<?php echo base_url() ?>assets/img/tic/logo-dtic.png" class="img-rounded" alt="bordes redondeados" width="80" height="30">
            Consulta de solicitud 
            <small>Seleccione para ver detalles </small>
        </h2>
        <hr />
    </div>

    <!-- Page title -->
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
                <a class="navbar-brand" >Lista de Solicitudes</a>
            </div>
            <div class="collapse navbar-collapse navbar-ex1-collapse">
                <ul class="nav navbar-nav navbar-right">
                    <li> 
                        <div class="navbar-brand btn-group btn-group-xs " role="group">
                            <?php if ($close || $ver_asig) { ?> 
                                <a href="<?php echo base_url() ?>tic_solicitudes/cerrada" class="btn btn-default" title="Ver solicitudes cerradas">Cerradas</a>
                            <?php } ?>
                            <?php if ($anuladas || $ver_asig) { ?> 
                                <a href="<?php echo base_url() ?>tic_solicitudes/anulada" class="btn btn-warning" title="Ver solicitudes anuladas">Anuladas</a>
                            <?php } ?>
                            <?php if ($reportes) { ?>     
                                <a href="<?php echo base_url() ?>tic_solicitudes/reportes" class="btn btn-info" title="Generar reportes">Reportes</a>
                            <?php } ?>
                            <?php if ($crear || $crear_dep) { ?>     
                                <a href="<?php echo base_url() ?>tic_solicitudes/solicitud" class="btn btn-primary" title="Crea una nueva solicitud">Crear Solicitud</a>
<?php } ?>
                        </div>
                    </li>
                </ul>
            </div>
        </nav>
        <!--<div class="panel-heading"><label class="control-label">Lista de Solicitudes</label>-->
        <!--                <div class="btn-group btn-group-xs pull-right" role="group">
        <?php if ($close || $ver_asig) { ?> 
                                    <a href="<?php echo base_url() ?>tic_solicitudes/cerrada" class="btn btn-default">Cerradas</a>
        <?php } ?>
        <?php if ($anuladas || $ver_asig) { ?> 
                                    <a href="<?php echo base_url() ?>tic_solicitudes/anulada" class="btn btn-warning">Anuladas</a>
        <?php } ?>
        <?php if ($reportes) { ?>     
                                    <a href="<?php echo base_url() ?>tic_solicitudes/reportes" class="btn btn-info">Reportes</a>
        <?php } ?>
        <?php if ($crear || $crear_dep) { ?>     
                                    <a href="<?php echo base_url() ?>tic_solicitudes/solicitud" class="btn btn-primary">Crear Solicitud</a>
<?php } ?>
                        </div>-->
        <!--</div>-->
        <div class="panel-body">
            <input type="hidden" id="valor" name="valor">  <!--estos inputs vienen del custom js en la funcion externa de busqueda por -->
            <input type="hidden" id="result1" name="result1"><!-- rangos para mostrar los resultados, estan ocultos despues de probar -->
            <input type="hidden" id="result2" name="result1"><!--por lo cual se pueden cambiar a tipo text para ver como funciona la busqueda-->
            <!--<div class="table-responsive">-->

            <div class="controls-row">
                <div class="control-group col col-lg-3 col-md-3 col-sm-3"></div>
                <div class="col-xs-12 col-md-7 input-group input-group-sm">
                    <span class="input-group-addon" id="basic-addon1"><i class="fa fa-calendar"></i></span>
                    <input type="search"  class="form-control input-sm" name="fecha1" id="fecha1" placeholder="Buscar por fechas" title="Buscar por fechas" />
                    <span class="input-group-addon"></span>
                    <input type="text" class="form-control input-sm" id="buscador" placeholder="Búsqueda general" title="Búsqueda general">
                    <span class="input-group-addon" id="basic-addon2"><i class="fa fa-search"></i></span>
                </div>
                <!--                        <div class="control-group col col-lg-3 col-md-3 col-sm-3">
                                            <div class="input-group">
                                                <span class="input-group-addon" id="basic-addon1"><i class="fa fa-calendar"></i></span>
                                                <input type="search"  class="form-control input-sm" style="width: 200px" name="fecha1" id="fecha1" placeholder=" Búsqueda por Fechas" />
                                            </div>
                                        </div>
                                        <div class="control-group col col-lg-3 col-md-3 col-sm-3">
                                            <div class="input-group">
                                                <input type="text" class="form-control input-sm" style="width: 200px" id="buscador" placeholder=" Búsqueda general">
                                                <span class="input-group-addon" id="basic-addon2"><i class="fa fa-search"></i></span>
                                            </div>
                                        </div>-->
                <div class="control-group col col-lg-12 col-md-12 col-sm-12">
                    <!--                            <div class="form-control" align="center">
                                                    <a class="toggle-vis" data-column="8">Haz click aquí para cambiar el estatus de una solicitud</a>
                                                </div>-->
                </div>
            </div>
            <div class="col-lg-12">

            </div>
            <div class="col-lg-12 col-md-12 col-sm-12">
                <table id="solicitudes" class="table table-hover table-bordered table-condensed dt-responsive nowrap" cellspacing="0" align="center" width="100%">
                    <thead>
                        <tr>
                            <th rowspan="2" valign="middle"><div align="center">Orden</div></th>
                    <th colspan="5"></th>
                    <th colspan="2"><div align="center">Asignar personal</div></th>
                    </tr>
                    <tr>
                        <th>Fecha</th>
                        <th>Dependencia</th>
                        <th>Asunto</th>
                        <th>Estatus</th>
                        <th>Estatus</th>
                        <th><div align="center"><span title="Asignar cuadrillas"><img src="<?php echo base_url() ?>assets/img/mnt/tecn5.png" class="img-rounded" alt="bordes redondeados" width="30" height="30"></span></div></th>
                    <th><div align="center"><span title="Asignar ayudantes"><img src="<?php echo base_url() ?>assets/img/mnt/ayudantes4.png" class="img-rounded" alt="bordes redondeados" width="30" height="30"></span></div></th>
                    </tr>
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
<div id="cuad" class="modal modal-message modal-info fade" tabindex="-1" role="dialog" aria-labelledby="cuadrilla" >
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form class="form" action="'.base_url().'tic_asigna_cuadrilla/tic_asigna_cuadrilla/asignar_cuadrilla" method="post" name="modifica" id="modifica">
                <div class="modal-header">
                    <label class="modal-title">Asignar Cuadrilla</label>
                    <span><i class="glyphicon glyphicon-pushpin"></i></span>
                </div>
                <div class="modal-body">
                    <!--<div class="container-fluid">-->
                        <!--<div class="row">-->
                            <div class="col-md-12">
                                <h4><label>Solicitud Número:<label name="data" id="data"></label></h4>
                            </div>
                        <!--</div>-->
                        <!--<div class="row">-->
                            <div class="col-md-6">
                                <label class="control-label" for = "tipo">Tipo:</label>
                                <label class="control-label" id="tipo"></label>
                            </div>
                            <div class="col-md-6">
                                <label class="control-label" for = "asunto">Asunto:</label>
                                <label class="control-label" id="asunto"></label>
                            </div>
<!--                        </div>
                        <div class="row">-->
                            <div class="col-md-12">
                                <label class="control-label" for="cuadrilla">Cuadrilla</label>
<!--                            </div>
                            <div class="col-md-12">-->
                                <select class = "form-control input-sm" id = "cuadrilla_select" name="cuadrilla_select">
                                    <option>1</option>
                                    <option>2</option>                                                                                                         }
                                    <option>3</option>
                                </select>
                            </div>
                        <!--</div>-->
                        <!--<div class="row">-->
                           <div class="col-md-12"><label class="control-label" for = "responsable">Responsable de la orden</label>
                                <select class = "form-control input-sm" id = "responsable" name="responsable">
                                    <option></option>
                                </select>
                           </div>
                        <!--</div>-->
                    <!--</div>-->
                </div>
                <div class="modal-footer">
                            <div class = "col-md-12">
                                <br>
                                <input  type="hidden" name="uri" value="tic_solicitudes/lista_solicitudes"/>
                                <button type="button" class="btn btn-default" data-dismiss="modal" aria-hidden="true">Cancelar</button>
                                <button type="submit" id="'.$sol['id_orden'].'" class="btn btn-primary">Guardar cambios</button>
                            </div>
                        </div>
            </form>
        </div>   
    </div>
</div>
<!--<div id="cuad<?php $sol['id_orden'] ?>" class="modal modal-message modal-info fade" tabindex="-1" role="dialog" aria-labelledby="cuadrilla" >
    <div class="modal-dialog">
        <div class="modal-content">
            <form class="form" action="base_url().tic_asigna_cuadrilla/tic_asigna_cuadrilla/asignar_cuadrilla" method="post" name="modifica" id="modifica">
                <div class="modal-header">
<?php if (empty($est) && !(isset($band))) { ?>
                        <label class="modal-title">Asignar Cuadrilla</label>
                        <span><i class="glyphicon glyphicon-pushpin"></i></span>
                   
<?php } else { ?>
                    <label class="modal-title">Cuadrilla Asignada</label>
                    <span><i class="glyphicon glyphicon-pushpin"></i></span>
            </div>
<?php } ?>
        <div class="modal-body row">
            <div class="col-md-12">
                <h4><label>Solicitud Número:<label name="data" id="data"></label></h4>
            </div>
            <div class="col-md-6">
                <label class="control-label" for = "tipo">Tipo:</label>
                <label class="control-label" id="tipo"></label>
            </div>
            <div class="col-md-6">
                <label class="control-label" for = "asunto">Asunto:</label>
                <label class="control-label" id="asunto"></label>
            </div>                                                          
            <?php
            if (empty($est) && !(isset($band))) {
                if (($sol['tiene_cuadrilla'] == 'si') || (empty($sol['tiene_cuadrilla']))) {
                    if (empty($sol['cuadrilla'])) {?>
                        <input type ="hidden" id="num_sol" name="num_sol" value="<?php $sol['id_orden']?>">
                        <div class="col-md-12"></br></div>
                        <div class="col-md-12"></br></div>
                        <div class="col-md-12"><label class="control-label" for="cuadrilla">Cuadrilla</label></div>
                        <div class="col-md-12 col-sm-12">
                            <div class="form-group">
                                <select class = "form-control input-sm" id = "cuadrilla_select<?php $sol['id_orden'] ?>" name="cuadrilla_select" onchange="mostrar(this.form.num_sol, this.form.cuadrilla_select, this.form.responsable, ($(' . "'#".$sol['id_orden']."'" . ')),1)">
                                    <option></option>';
                                    <?php
                                    if (isset($id_cuad)) {
                                        foreach ($cuadri as $cuad) {
                                            if (isset($id_cuad) && $cuad->id == $id_cuad) {
                                                ?>
                                                <option value = "<?php $cuad->id ?>"><?php echo $cuad->cuadrilla ?></option>
                                                <?php
                                                }
                                        }
                                    } else{
                                        foreach ($cuadri as $cuad){?>
                                            <option value = "<?php $cuad->id ?>"><?php $cuad->cuadrilla ?></option>
                        <?php           }
                                    }
                        ?>
                                </select>
                            </div>   
                        </div>
                        <div class="col-md-12"><label class="control-label" for = "responsable">Responsable de la orden</label></div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <select class = "form-control input-sm" id = "responsable'.$sol['id_orden'].'" name="responsable">
                                        <option></option>
                                    </select>
                                </div>
                            </div>
                        <div id= "test" class="col-md-12">
                            <br>
                            <div id="<?php $sol['id_orden'] ?>">
                                aqui se muestra la tabla de las cuadrillas
                            </div>
                        </div>
                    <?php
                    }
                    else{?>
                        <input type ="hidden" id="cut" name="cut" value="<?php $sol['id_orden'] ?>">
                        <input type ="hidden" id="cuadrilla" name="cuadrilla" value="<?php $sol['id_cuadrilla'] ?>">'
                        <div class="col-md-12"><br></div>
                        <div class="col-md-12">
                            <label>Jefe de cuadrilla:</label>
                            <label name="respon" id="respon<?php $sol['id_orden'] ?>"></label>
                        </div>
                        <div class="col-md-3"><br></div>
                        <div class="col-md-12">
                            <div class="col-md-5">
                                <label>Responsable de la orden:</label>
                            </div>
                            <div class="input-group input-group">                                                   
                                <select title="Responsable de la orden" class = "form-control" id = "responsable<?php $sol['id_orden'] ?>" name="responsable" disabled>
                                </select>
                                <span class="input-group-addon">
                                    <label class="fancy-checkbox" title="Haz click para editar responsable">
                                        <input  type="checkbox"  id="mod_resp<?php $sol['id_orden'] ?>"/>
                                        <i class="fa fa-fw fa-edit checked" style="color:#D9534F"></i>
                                        <i class="fa fa-fw fa-pencil unchecked "></i>
                                    </label>
                                </span>
                            </div>
                            <br>
                            <div class="col-lg-12"></div>
                            <div class="col-lg-14">
                                <div id="show_signed<?php $sol['id_orden'] ?>" >
                                    mostrara la tabla de la cuadrilla asignada   
                                </div>
                            </div>
                            <br>
                            <div class="col-lg-12">
                                <div class="alert-success" align="center" style="text-align: center">
                                    <label class="checkbox-inline"> 
                                        <input type="checkbox" id="otro<?php echo $sol['id_orden'] ?>" value="opcion_1">Quitar asignación de la cuadrilla
                                    </label>        
                                </div>
                            </div>
                            <br> 
                        </div>
                                <?php
                    }
                } else {
                                $aux = $aux . '<div class="col-lg-12">
                                                    <div class="alert alert-warning" style="text-align: center">No se puede asignar cuadrillas ya que un ayudante es responsable de la orden</div>
                                                </div>';
                    }
            } else {
                            if (empty($sol['cuadrilla'])) {
                                ?>
                                <div class="col-md-12"><br></div>
                                <div class="col-md-12">
                                    <div class="alert alert-info" align="center"><strong>¡No hay cuadrilla asignada a esta solicitud</strong></div>
                                </div>
                <?php } else { ?>
                                <div class="col-md-12"><br></div><div class="col-md-12"><label>Jefe de cuadrilla:</label>
                                    <label name="respon" id="respon<?php $sol['id_orden'] ?>"></label>
                                </div>
                                <div class="col-md-12">
                                    <label class="control-label" for = "responsable">Responsable de la orden</label>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <select class = "form-control select2" id = "responsable<?php $sol['id_orden'] ?>" name="responsable" disabled>
                                            <option></option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-12"><br></div>
                                <div class="col-md-6"><label for = "miembros">Miembros de la Cuadrilla</label></div>
                                <div id="show_signed<?php $sol['id_orden'] ?>" class="col-md-12">
                                    mostrara la tabla de la cuadrilla asignada   
                                </div>
                                <?php }
                            }
                            ?>
                    </div>
                    <div class="modal-footer">
                        <div class = "col-md-12">
                            <input  type="hidden" name="uri" value="tic_solicitudes/lista_solicitudes"/>
                            <button type="button" class="btn btn-default" data-dismiss="modal" aria-hidden="true">Cancelar</button>';
            <?php if (empty($est) && !(isset($band))) { ?>
                                <button type="submit" id="<?php $sol['id_orden'] ?>" class="btn btn-primary">Guardar cambios</button>';
            <?php } ?>
            </div>
        </div>

        </form>

    </div>
</div>

</div>-->
<script>
                    // funcion para habilitar input segun algunas opciones del select de estatus de solicitudes
                            // function statusOnChange(sel,div,txt) {
                                    //    var test = sel.value;
                                            //    switch (test){
                                                    //      case '3':
                                                            //    case '4':     
                                                                    //  case '5':     
                                                                            // case '6':     
                                                                                    //var divC = ($(div));
                                                                                            //divC.show();
                                                                                                    //  $(txt).removeAttr('disabled');
                                                                                                            //  break;
                                                                                                                    // default:
                                                                                                                            //   divC = ($(div));
                                                                                                                                    //    divC.hide();
                                                                                                                                            //   $(txt).attr('disabled','disabled');
                                                                                                                                                    //   break;
                                                                                                                                                            //  }
                                                                                                                                                                    // }; -->
                                                                                                                                                                            //funcion para validar que el input motivo no quede vacio(esta funcion se llama en el formulario de estatus de la solicitud)
                                                                                                                                                                                    function valida_motivo(txt) {
                                                                                                                                                                                    if ($(txt).val().length < 1) {
                                                                                                                                                                                    $(txt).focus();
                                                                                                                                                                                            swal({
                                                                                                                                                                                            title: "Error",
                                                                                                                                                                                                    text: "El motivo es obligatorio",
                                                                                                                                                                                                    type: "error"
                                                                                                                                                                                            });
                                                                                                                                                                                            return false;
                                                                                                                                                                                    }
                                                                                                                                                                                    }

</script>