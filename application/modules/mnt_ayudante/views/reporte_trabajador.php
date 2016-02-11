<script src="<?php echo base_url() ?>assets/js/jquery.min.js"></script>
<script type="text/javascript">
    base_url = '<?= base_url() ?>';
    $(document).ready(function() {
//        var panels = $('.user-infos');
//        var panelsButton = $('.dropdown-user');
//        panels.hide();
//
//        //Click dropdown
//        panelsButton.click(function() {
//        //get data-for attribute
//            var dataFor = $(this).attr('data-for');
//            var idFor = $(dataFor);
//
//        //current button
//            var currentButton = $(this);
//            idFor.slideToggle(400, function() {
//            //Completed slidetoggle
//                if(idFor.is(':visible'))
//                {
//                    currentButton.html('<i class="glyphicon glyphicon-chevron-up text-muted"></i>');
//                }
//                else
//                {
//                    currentButton.html('<i class="glyphicon glyphicon-chevron-down text-muted"></i>');
//                }
//            })
//        });
//        $('[data-toggle="tooltip"]').tooltip();
//    });

 var table = $('#trabajador').DataTable({
            "bProcessing": true,
            "bDeferRender": true,
            "serverSide": true, //Feature control DataTables' server-side processing mode.
//        "searching": false,
            "pagingType": "full_numbers", //se usa para la paginacion completa de la tabla
            "sDom": '<"top"lp<"clear">>rt<"bottom"ip<"clear">>', //para mostrar las opciones donde p=paginacion,l=campos a mostrar,i=informacion
            "order": [[1, "desc"]], //para establecer la columna a ordenar por defecto y el orden en que se quiere 
        "ajax": {
            "url": "<?php echo site_url('mnt_ayudante/mnt_ayudante/reportes')?>",
            "type": "GET",
            "data": function ( d ) {
                d.uno = $('#result1').val();
                d.dos = $('#result2').val();
            }
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
        $('#result1').val(start.format('YYYY-MM-DD')+' '+'00:00:00');
        $('#result2').val(end.format('YYYY-MM-DD')+' '+'23:59:59');
        $('#fecha1 span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
        table.draw();
    });
     $('#fecha1').on('click', function () {
            document.getElementById("fecha1").value = "";//se toma el id del elemento y se hace vacio el valor del mismo
            document.getElementById("result1").value = "";//se toma el id del elemento y se hace vacio el valor del mismo
            document.getElementById("result2").value = "";//se toma el id del elemento y se hace vacio el valor del mismo
            table.draw();//devuelve este valor a la escritura de la tabla para reiniciar los valores por defecto
        });
   });
    
</script>

<!-- Page content -->
<div class="mainy">
    <!-- Page title -->
    <div class="page-title">
        <h2 align="right"><i class="fa fa-user color"></i> Reportes por trabajador<small> Seleccione ver detalles</small></h2> 
        <hr />
    </div>
<!--    <nav class="navbar navbar-default">
        <div class="container-fluid">
             Brand and toggle get grouped for better mobile display 
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand"><span class="glyphicon glyphicon-cog"></span></a>
            </div>
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav">
                    <li class="active"><a href="<?php echo base_url() ?>index.php/mnt_cuadrilla/listar">Listar <span class="sr-only">(current)</span></a></li>
                </ul>
                <form class="navbar-form navbar-left" role="search">
                    <div class="form-group">
                        <input type="text" class="form-control" placeholder="Buscar" id="buscador">
                    </div>
                    <button type="reset" id="reset" class="btn btn-default">Reset</button>
                </form>
                <ul class="nav navbar-form navbar-right">
                    <a href="<?php echo base_url() ?>index.php/mnt_cuadrilla/crear" class="btn btn-success" data-toggle="modal">Agregar</a>
                </ul>

            </div> /.navbar-collapse 
        </div> /.container-fluid 
    </nav>-->

                             <div class="panel panel-info">
                                <div class="panel-heading">
                                    <label><strong></strong> </label>
                                    <div class="btn-group btn-group-sm pull-right">
                                        <label><strong></strong></strong> </label>
                                    </div>
                                </div>
                                <div class="panel-body">
<!--                                    <div align='center'><strong></strong></div>                   
                                    <div well class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                        <div class="row user-row">
                                            <div class="col-xs-11 col-sm-11 col-md-11 col-lg-11">
                                                <strong>Información del contacto</strong><br>
                                                <span class="text-muted"></span>
                                            </div>
                                            <div class="col-xs-1 col-sm-1 col-md-1 col-lg-1 dropdown-user" data-for=".uno">
                                                <i class="glyphicon glyphicon-chevron-up text-muted"></i>
                                            </div>
                                        </div>
                                        <div class="row user-infos uno">
                                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 ">
                                                <div class=" col-md-12 col-lg-12">
                                                    <table class="table table-hover table-bordered table-striped table-condensed">
                                                        <thead>
                                                            <tr>    
                                                                <th><strong></strong></th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <tr>
                                                                <td></td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row user-row">
                                            <div class="col-xs-11 col-sm-11 col-md-11 col-lg-11">
                                                <strong>Información de la solicitud</strong><br>
                                                <span class="text-muted"></span>
                                            </div>
                                            <div class="col-xs-1 col-sm-1 col-md-1 col-lg-1 dropdown-user" data-for=".dos">
                                                <i class="glyphicon glyphicon-chevron-up text-muted"></i>
                                            </div>
                                        </div>
                                        <div class="row user-infos dos">
                                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 ">
                                                <div class=" col-md-12 col-lg-12">
                                                    <table class="table table-hover table-bordered table-striped table-condensed">
                                                        <thead>
                                                            <tr>    
                                                                <th><strong></strong></th>
                                                                
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <tr>
                                                                <td></td>    
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row user-row">
                                            <div class="col-xs-11 col-sm-11 col-md-11 col-lg-11">
                                                <strong>Estatus</strong><br>
                                                <span class="text-muted"></span>
                                            </div>
                                            <div class="col-xs-1 col-sm-1 col-md-1 col-lg-1 dropdown-user" data-for=".tres">
                                                <i class="glyphicon glyphicon-chevron-up text-muted"></i>
                                            </div>
                                        </div>
                                        <div class="row user-infos tres">
                                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 ">
                                                <div class=" col-md-12 col-lg-12">
                                                    <table class="table table-hover table-bordered table-striped table-condensed">
                                                        <thead>
                                                            <tr>    
                                                                <th><strong></strong></th>
                                                    
                                                                
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <tr>
                                                                <td></td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                        
                                    </div>-->
                 <input type="hidden" id="valor" name="valor">  <!--estos inputs vienen del custom js en la funcion externa de busqueda por -->
                <input type="hidden" id="result1" name="result1"><!-- rangos para mostrar los resultados, estan ocultos despues de probar -->
                <input type="hidden" id="result2" name="result1"><!--por lo cual se pueden cambiar a tipo text para ver como funciona la busqueda-->
                <div class="table-responsive">

                    <div class="controls-row">
                        <div class="control-group col col-lg-3 col-md-3 col-sm-3"></div>
                        <div class="control-group col col-lg-3 col-md-3 col-sm-3">
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
                        </div>
                        <div class="control-group col col-lg-12 col-md-12 col-sm-12">
<!--                            <div class="form-control" align="center">
                                <a class="toggle-vis" data-column="8">Haz click aquí para cambiar el estatus de una solicitud</a>
                            </div>-->
                        </div>
                    </div>
                    <div class="col-lg-12">
                        
                    </div>
                    <div class="col-lg-12 col-md-12 col-sm-12">
                        <table id="trabajador" class="table table-hover table-bordered table-condensed" align="center" width="100%">
                            <thead>
                             <tr>
                                <!--<th></th>-->
                                <th>Nombre</th>
                                <th>Apellido</th>
                                <th>Cargo</th>
                                 
                            </tr>
                            </thead>
                            <tbody>
                               
                                </tbody>
                        </table>
                    </div>
                </div>                   
                                </div>                          
                                <div class="panel-footer">
                                    <div class='container'align="right">
                                        <div class="btn-group btn-group-sm pull-right">
                                            <button onClick="javascript:window.history.back();" type="button" name="Submit" class="btn btn-info">Regresar</button>
                                            <!--<button type="button" class="btn btn-primary" onclick="imprimir();">Imprimir</button> -->
                                            <a data-toggle="modal" data-target="#pdf" class="btn btn-default btn">Crear PDF</a> 
                                                   
                                        </div>
                                    </div>  
                                </div>
                            </div>
                          
                   
</div>
<div class="clearfix"></div>