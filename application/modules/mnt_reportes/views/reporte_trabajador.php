<script src="<?php echo base_url() ?>assets/js/jquery.min.js"></script>
<script type="text/javascript">
    base_url = '<?php echo base_url() ?>';
    $(document).ready(function () {
     //para usar dataTable en la table solicitudes
        var table = $('#reportes').DataTable({
            "bProcessing": true,
            "serverSide": true, //Feature control DataTables' server-side processing mode.
            "bDeferRender": true,
             stateSave: true,
            "stateLoadParams": function (settings, data) {
                $("#buscador").val(data.search.search);
            },
//        "searching": false,
            "pagingType": "full_numbers", //se usa para la paginacion completa de la tabla
            "sDom": '<"top"lp<"clear">>rt<"bottom"ip<"clear">>', //para mostrar las opciones donde p=paginacion,l=campos a mostrar,i=informacion
            "order": [[0, "desc"]], //para establecer la columna a ordenar por defecto y el orden en que se quiere 
//            "aoColumnDefs": [{"orderable": false, "targets": [0]}],//para desactivar el ordenamiento en esas columnas
        "ajax": {
            "url": "<?php echo site_url('mnt_reportes/mnt_reportes/list_sol')?>",
            "type": "GET",
            "data": function ( d ) {
                d.uno = $('#result1').val();
                d.dos = $('#result2').val();
                d.est = $('#estatus').val();
                d.trab = $('#trabajadores').val();
//                d.dep = <?php // echo $dep?>;
            }
        }  
        });
//        var order = table.order();
// 
//        alert( 'Column '+order+' is the ordering column' );

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
//        $('a.toggle-vis').on('click', function (e) {//esta funcion se usa para mostrar columnas ocultas de la tabla donde a.toggle-vis es el <a class> de la vista 
//            e.preventDefault();
//
//            // toma el valor que viene de la vista en <a data-column>para establecer la columna a mostrar
//            var column = table.column($(this).attr('data-column'));
//
//            // Esta es la funcion que hace el cambio de la columna
//            column.visible(!column.visible());
//        });    
        $("#estatus").change(function () {//Evalua el cambio en el valor del select
                $("#estatus option:selected").each(function () { //en esta parte toma el valor del campo seleccionado
                   table.draw();   
                });
            });
        $("#trabajadores").change(function () {//Evalua el cambio en el valor del select
                $("#trabajadores option:selected").each(function () { //en esta parte toma el valor del campo seleccionado
                   table.draw();   
                });
            });
});    
            
    function sel(select){
        $(select).select2({theme: "bootstrap",placeholder: "--SELECCIONE--",allowClear: true}); 
    }
</script>
<style>
    td.details-control {
     content:"\2212";
  font-family:"Glyphicons Halflings";
  line-height:1;
  margin:5px;
    cursor: pointer;
}
tr.details td.details-control {
   content:"\2b";
         font-family:"Glyphicons Halflings";
         line-height:1;
        margin:5px;
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
      <a class="navbar-brand" href="#">Brand</a>
    </div>

    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
      <ul class="nav navbar-nav">
        <li class="active"><a href="#">Link <span class="sr-only">(current)</span></a></li>
        <li><a href="#">Link</a></li>
<!--        <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Dropdown <span class="caret"></span></a>
          <ul class="dropdown-menu">
            <li><a href="#">Action</a></li>
            <li><a href="#">Another action</a></li>
            <li><a href="#">Something else here</a></li>
            <li role="separator" class="divider"></li>
            <li><a href="#">Separated link</a></li>
            <li role="separator" class="divider"></li>
            <li><a href="#">One more separated link</a></li>
          </ul>
        </li>-->
      </ul>
      <form class="navbar-form navbar-left" role="search">
          
           
                                <div class="input-group">
                                    <span class="input-group-addon" id="basic-addon1"><i class="fa fa-calendar"></i></span>
                                    <input type="search"  class="form-control input-sm" style="width: 200px" name="fecha1" id="fecha1" placeholder=" Búsqueda por Fechas" />
                                    </div>
                               
                               
                                    <div class="input-group">
                                        <input type="text" class="form-control input-sm" style="width: 200px" id="buscador" placeholder=" Búsqueda general">
                                        <span class="input-group-addon" id="basic-addon2"><i class="fa fa-search"></i></span>
                                    </div>
                              
      </form>
      <ul class="nav navbar-nav navbar-right">
          <li></li>
      </ul>
    </div><!-- /.navbar-collapse -->
  </div><!-- /.container-fluid -->
</nav>
                        <div class="well well-lg">
                            <div class="form-group">
                                <label class="control-label col-md-1" for="estatus"> Estatus:</label>
                                <div class="col-md-4"> 
                                    <select class="form-control input-sm select2" id="estatus" name="estatus">
                                        <option></option>
                                        <?php foreach ($estatus as $all): ?>
                                            <option value="<?php echo $all->id_estado ?>"><?php echo $all->descripcion ?></option>
                                            <?php endforeach; ?>
                                    </select>
                                </div>

                                <div class="col-md-1"></div>
                                <label class="control-label col-md-2" for="trabajadores">Por Trabajador:</label>
                                <div class="col-md-4">  
                                    <select class="form-control input-sm select2" id="trabajadores" name="trabajadores">
                                        <option></option>
                                        <?php foreach ($trabajadores as $all): ?>
                                            <option value="<?php echo $all['id_usuario'] ?>"><?php echo $all['nombre'] . ' ' . $all['apellido'] ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                            <div><br></div>
                        </div>

<!--                        <div class="controls-row">
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
                                                                <div class="form-control" align="center">
                                                                    <a class="toggle-vis" data-column="8">Haz click aquí para cambiar el estatus de una solicitud</a>
                                                                </div>
                                </div>
                            </div>-->
                            <div class="col-lg-12">

                            </div>
                              <div class="col-lg-12 col-md-12 col-sm-12">
                        <table id="reportes" class="table table-hover table-bordered table-condensed" align="center" width="100%">
                            <thead>
                                <tr class="color">
                                    <th  valign="middle"><div align="center">Orden</div></th>
<!--                                    <th colspan="5"></th>-->
                                    
                               
                                
                                    <th valign="middle"><div align="center">Fecha</div></th>
                                    <th>Dependencia</th>
                                    <th>Asunto</th>
                                    <th>Estatus</th>
                                    
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
<!-- Modal para trabajadores-->
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