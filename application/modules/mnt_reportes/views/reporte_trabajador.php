<script src="<?php echo base_url() ?>assets/js/jquery.min.js"></script>
<script type="text/javascript">
    base_url = '<?php echo base_url() ?>';
    
    $(document).ready(function () {
      //para usar dataTable en la tabla reportes
        var check = 'no';
        var table = $('#reportes').DataTable({
            "bProcessing": true,
            "serverSide": true, //Feature control DataTables' server-side processing mode.
            "bDeferRender": true,
            "stateSave": true,
            "stateLoadParams": function (settings, data) {
                $("#buscador").val(data.search.search);
            },
//          "searching": false,
            "pagingType": "full_numbers", //se usa para la paginacion completa de la tabla
            "sDom": '<"top"lp<"clear">>rt<"bottom"ip<"clear">>', //para mostrar las opciones donde p=paginacion,l=campos a mostrar,i=informacion
            "order": [[0, "desc"]], //para establecer la columna a ordenar por defecto y el orden en que se quiere 
//          "aoColumnDefs": [{"orderable": false, "targets": [0]}],//para desactivar el ordenamiento en esas columnas
            "ajax": {
                "url": "<?php echo site_url('mnt_reportes/mnt_reportes/list_sol') ?>",
                "type": "GET",
                "data": function (d) {
                    d.uno = $('#result1').val();
                    d.dos = $('#result2').val();
                    d.est = $('#estatus').val();
                    d.trab = $('#trabajadores').val();
                    d.checkTrab = check;
//                  d.dep = <?php // echo $dep?>;
                }
            },
            "drawCallback": function (settings) {
                if ($('#test1').is(':checked')) {
//            check = 'si';  
//            console.log(check);
                    var api = this.api();
                    var rows = api.rows({page: 'current'}).nodes();
                    var last = null;
                    api.column(5, {page: 'current'}).data().each(function (group, i) {
                        if (last !== group) {
                            $(rows).eq(i).before(
                               '<tr class="group"><td colspan="5">Trabajador: ' + group + '</td></tr>'
                            );
                            last = group;
                        }
                    });
                }
            }
        });
        table.column(5).visible(false);
        $('#test1').change(function() {
            if($(this).is(':checked')) {
                check = 'si';
                table.columns(5).visible(false).draw();
                $('#trabajadores').prop('disabled', false);
            }
            else {
                $('#trabajadores').select2('val','');//borra la opcion seleccionada
                $('#trabajadores').prop('disabled', true);    
                check = 'no';
                table.columns(5).visible(false).draw();
            } 
        });
       
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
        $("#trabajadores").change(function () {//Evalua el cambio en el valor del select
            $("#trabajadores option:selected").each(function () { //en esta parte toma el valor del campo seleccionado
                table.column(5).visible(false);
                table.draw();   
            });
        });
        $('#estatus').select2({theme: "bootstrap",placeholder: "--ESTATUS--",allowClear: true}); 
});   
</script>
 <style>
                    tr.group,
                    tr.group:hover {
                        background-color: #ddd !important;
                    }
 </style>
<!-- Page content -->
<div class="mainy">
    <!-- Page title -->
    <div class="page-title">
        <h2 align="right"><i class="fa fa-paperclip color"></i> Reportes<small> Seleccione ver detalles</small></h2> 
        <hr />
    </div>
 
    <div class="row">
        <div class="col-md-12">
            <div class="awidget full-width">
                <div class="awidget-head">
                    <input type="hidden" id="valor" name="valor">  <!--estos inputs vienen del custom js en la funcion externa de busqueda por -->
                <input type="hidden" id="result1" name="result1"><!-- rangos para mostrar los resultados, estan ocultos despues de probar -->
                <input type="hidden" id="result2" name="result1"><!--por lo cual se pueden cambiar a tipo text para ver como funciona la busqueda-->
                </div>
                <div class="awidget-body">
                    <div class="table-responsive">
                        <nav class="navbar navbar-default">
                            <div class="container-fluid">
                                <!-- Brand and toggle get grouped for better mobile display -->
                                <div class="navbar-header">
                                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                                        <span class="sr-only">Toggle navigation</span>
                                        <span class="icon-bar"></span>
                                        <span class="icon-bar"></span>
                                        <span class="icon-bar"></span>
                                    </button>
                                </div>
                               <!-- Collect the nav links, forms, and other content for toggling -->
                                <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                                    <form class="navbar-form navbar-left" role="search">
                                        <div class="input-group">
                                            <span class="input-group-addon" id="basic-addon1"><i class="fa fa-calendar"></i></span>
                                                <input type="search"  class="form-control input-sm" style="width: 200px" name="fecha1" id="fecha1" placeholder=" Búsqueda por Fechas" />
                                            <span class="input-group-addon" id="basic-addon2"><i class="fa fa-search"></i></span>
                                                <input type="text" class="form-control input-sm" style="width: 250px" id="buscador" placeholder=" Búsqueda general">
                                            <span class="input-group-addon" id="basic-addon2"><i class="glyphicon glyphicon-stats"></i></span>
                                                <select class="form-control input-sm" id="estatus" name="estatus" style="width: 200px">
                                                    <option></option>
                                                    <?php foreach ($estatus as $all): ?>
                                                        <option value="<?php echo $all->id_estado ?>"><?php echo $all->descripcion ?></option>
                                                    <?php endforeach; ?>
                                                </select>
                                        </div>
                                    </form>
                                    <ul class="nav navbar-nav navbar-right">
                                        <li></li>
                                    </ul>
                                </div><!-- /.navbar-collapse -->
                            </div><!-- /.container-fluid -->
                        </nav>
                        <div class="panel panel-default">
                            <div class="panel-body">
                                <div class="controls-row">
                                    <div class="form-group">
                                        <div class="col-md-4">
                                            <label class="control-label" for="trabajadores">Por Trabajador:</label>
                                            <div class="make-switch switch-mini" id="test" data-off-label="<i class='glyphicon glyphicon-remove'></i>" data-on-label="<i class='glyphicon glyphicon-ok'></i>">
                                                <input id="test1" type="checkbox"  />
                                            </div>
                                            <select class="form-control input-sm select2" id="trabajadores" name="trabajadores" disabled>
                                                <option></option>
                                                <?php foreach ($trabajadores as $all): ?>
                                                    <option value="<?php echo $all['id_usuario'] ?>"><?php echo $all['nombre'] . ' ' . $all['apellido'] ?></option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>            
                                        
                                        <div class="col-md-3">  
                                            
                                        </div>
                                    </div>
                                    <div><br></div>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-12">
                        </div>
                        <div class="col-lg-12 col-md-12 col-sm-12">
                            <table id="reportes" class="table table-hover table-bordered table-condensed" align="center" width="100%">
                                <thead>
                                    <tr class="color">
                                        <th  valign="middle"><div align="center">Orden</div></th>                                       
                                        <th valign="middle"><div align="center">Fecha</div></th>
                                        <th>Dependencia</th>
                                        <th>Asunto</th>
                                        <th>Estatus</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>

                                </tbody>
                            </table>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>      
</div>
<div class="clearfix"></div>
<!-- Modal para trabajadores
    <div id="consultar1" class="modal modal-message modal-info fade" tabindex="-1" role="dialog" aria-labelledby="mod" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                     <label class="modal-title">Reporte por trabajador </label>
                </div>
                
              
                <form class="form-horizontal" action="<?php echo base_url() ?>index.php/mnt_solicitudes/reportes_pdf" method="post" target="_blank">
                    <div class="modal-body row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <div class="col-lg-12 col-md-12 col-sm-12">
                                    <div id="report" class="container-fluid"></div>
                                        <input type="hidden" name="tipo" value="trabajador"/>
<!--                                    <table id="trabajador" class="table table-hover table-bordered table-condensed" align="center" width="100%">
                                        <thead>
                                            <tr>
                                                <th></th>
                                                <th>Nombre</th>
                                                <th>Apellido</th>
                                                <th>Cargo</th>                             
                                            </tr>
                                        </thead>
                                        <tbody>
                                               
                                        </tbody>
                                    </table>-->
                                </div>
                            </div>  
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" data-dismiss="modal" aria-hidden="true">Cerrar</button>
                        <!--<button type="submit" class="btn btn-primary" id="" >Enviar</button>-->
                        <input type="hidden" name="uri" value="<?php echo $this->uri->uri_string() ?>"/>
                    </div>
                </form> <!-- /.fin de formulario -->
            </div> <!-- /.modal-content -->
        </div> <!-- /.modal-dialog -->
    </div><!-- /.Fin de modal reportes1-->
    
<!-- Modal para responsable-->
    <div id="consultar2" class="modal modal-message modal-info fade" tabindex="-1" role="dialog" aria-labelledby="mod" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <label class="modal-title">Reporte por responsable </label>
                </div>
                
              
                <form class="form-horizontal" action="<?php echo base_url() ?>index.php/mnt_solicitudes/reportes_pdf" method="post" target="_blank">
                    <div class="modal-body row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <div class="col-lg-12 col-md-12 col-sm-12">
                                    <div id="report2" class="container-fluid"></div>
                                        <input type="hidden" name="tipo" value="responsable"/>
<!--                                    <table id="trabajador" class="table table-hover table-bordered table-condensed" align="center" width="100%">
                                        <thead>
                                            <tr>
                                                <th></th>
                                                <th>Nombre</th>
                                                <th>Apellido</th>
                                                <th>Cargo</th>                             
                                            </tr>
                                        </thead>
                                        <tbody>
                                               
                                        </tbody>
                                    </table>-->
                                </div>
                            </div>  
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" data-dismiss="modal" aria-hidden="true">Cerrar</button>
                        <!--<button type="submit" class="btn btn-primary" id="" >Enviar</button>-->
                        <input type="hidden" name="uri" value="<?php echo $this->uri->uri_string() ?>"/>
                    </div>
                </form> <!-- /.fin de formulario -->
            </div> <!-- /.modal-content -->
        </div> <!-- /.modal-dialog -->
    </div><!-- /.Fin de modal reportes1-->
    
    <!-- Modal para tipo_orden-->
    <div id="consultar3" class="modal modal-message modal-info fade" tabindex="-1" role="dialog" aria-labelledby="mod" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <label class="modal-title">Reporte por Tipo de Orden </label>
                </div>
                
              
                <form class="form-horizontal" action="<?php echo base_url() ?>index.php/mnt_solicitudes/reportes_pdf" method="post" target="_blank">
                    <div class="modal-body row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <div class="col-lg-12 col-md-12 col-sm-12">
                                    <div id="report3" class="container-fluid"></div>
                                        <input type="hidden" name="tipo" value="tipo_orden"/>
<!--                                    <table id="trabajador" class="table table-hover table-bordered table-condensed" align="center" width="100%">
                                        <thead>
                                            <tr>
                                                <th></th>
                                                <th>Nombre</th>
                                                <th>Apellido</th>
                                                <th>Cargo</th>                             
                                            </tr>
                                        </thead>
                                        <tbody>
                                               
                                        </tbody>
                                    </table>-->
                                </div>
                            </div>  
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" data-dismiss="modal" aria-hidden="true">Cerrar</button>
                        <!--<button type="submit" class="btn btn-primary" id="" >Enviar</button>-->
                        <input type="hidden" name="uri" value="<?php echo $this->uri->uri_string() ?>"/>
                    </div>
                </form> <!-- /.fin de formulario -->
            </div> <!-- /.modal-content -->
        </div> <!-- /.modal-dialog -->
    </div><!-- /.Fin de modal reportes1-->