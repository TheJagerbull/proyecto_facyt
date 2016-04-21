<script src="<?php echo base_url() ?>assets/js/jquery.min.js"></script>
<script type="text/javascript">
    base_url = '<?= base_url() ?>'
   function format ( e ) {
    return 'Orden'+e.orden+'<br>Dependencia:'+e.dependencia+'<br>Asunto:'+e.asunto;
}
    $(document).ready(function() {

 var table = $('#trabajador').DataTable({
            "bProcessing": true,
            "bDeferRender": true,
            "serverSide": true, //Feature control DataTables' server-side processing mode.
            "searching": false,
            "pagingType": "full_numbers", //se usa para la paginacion completa de la tabla
            lengthChange: false,
             buttons: [ 'print', 'pdf'],
//             dom: 'Bfrtip',
            "sDom": '<"top"Blp<"clear">>rt<"bottom"ip<"clear">>', //para mostrar las opciones donde p=paginacion,l=campos a mostrar,i=informacion
            scroller:       true,
  
        "order": [[1, "asc"]], //para establecer la columna a ordenar por defecto y el orden en que se quiere 
        "ajax": {
            "url": "<?php echo site_url('mnt_ayudante/mnt_ayudante/reportes')?>",
            "type": "GET",
            "data": function ( d ) {
                d.uno = $('#result1').val();
                d.dos = $('#result2').val();
                d.status = $('#status_orden').val();
            }
        },
        "columns": [
            {
                "class":          "details-control",
                "orderable":      false,
                "data":           null,
                "defaultContent": ""
            },
                { "data": "nombre" },
                { "data": "apellido" },
                { "data": "cargo" }
        ]
        });
        table.buttons().container()
        .appendTo( '#trabajador_wrapper .col-sm-6:eq(0)' );
//            $('#buscador').keyup(function () { //establece un un input para el buscador fuera de la tabla
//            table.search($(this).val()).draw(); // escribe la busqueda del valor escrito en la tabla con la funcion draw
//        });
     
  
    
    $('#fecha1 span').html(moment().subtract(29, 'days').format('MMMM D, YYYY') + ' - ' + moment().format('MMMM D, YYYY'));

    $('#fecha1').daterangepicker({
        format: 'DD/MM/YYYY',
        startDate: moment().subtract(29, 'days'),
        endDate: moment(),
         minDate: '01/01/2015',
         maxDate: '12/31/2021',
        dateLimit: {days: 360},
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
        status_change_repor($('#worker'),$('#respon'),$('#cuad'),$('#status_orden'),$('#result1'),$('#result2'));
        table.draw();
    });
     $('#fecha1').on('click', function () {
            document.getElementById("fecha1").value = "";//se toma el id del elemento y se hace vacio el valor del mismo
            document.getElementById("result1").value = "";//se toma el id del elemento y se hace vacio el valor del mismo
            document.getElementById("result2").value = "";//se toma el id del elemento y se hace vacio el valor del mismo
            table.draw();//devuelve este valor a la escritura de la tabla para reiniciar los valores por defecto
        });
     $("#status_orden").change(function () {
        $("#status_orden option:selected").each(function () {
            table.draw();//devuelve este valor a la escritura de la tabla para reiniciar los valores por defecto
        });
    });
   });
   
   
    
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
    <form action="<?php echo base_url() ?>index.php/mnt_ayudante/mnt_ayudante/test" method="post" name="edita" id="edita">
    <div class="panel panel-info">
        <div class="panel-heading">
            <label><strong>Opciones para generar reportes</strong> </label>
            <div class="btn-group btn-group-sm pull-right">
                <label><strong></strong></strong> </label>
            </div>
        </div>
        <div class="panel-body">
            <input type="hidden" id="valor" name="valor">  <!--estos inputs vienen del custom js en la funcion externa de busqueda por -->
            <input type="hidden" id="result1" name="result1"><!-- rangos para mostrar los resultados, estan ocultos despues de probar -->
            <input type="hidden" id="result2" name="result2"><!--por lo cual se pueden cambiar a tipo text para ver como funciona la busqueda-->
            <!--<div class="table-responsive">-->
                <div class="col-md-12">   
                    <div class="controls-row">
                        <div class="control-group col col-lg-3 col-md-3 col-sm-3"></div>
                        <div class="control-group col col-lg-4 col-md-4 col-sm-4">
                            <div class="input-group">
                                <span class="input-group-addon" id="basic-addon1"><i class="fa fa-calendar"></i></span>
                                <input type="search"  class="form-control input-sm"  name="fecha1" id="fecha1" placeholder="Búsqueda por Fechas" />
                            </div>
                        </div>
                    <div class="control-group col col-lg-4 col-md-4 col-sm-4">
                        <div class="form-group">
                            <div class="input-group"> 
                                <select class="form-control input-sm select2" id = "status_orden" name="status_orden" onchange="status_change_repor($('#worker'),$('#respon'),$('#cuad'),$('#status_orden'),$('#result1'),$('#result2'))">
                                    <option></option>
                                 <?php foreach ($estatus as $est){?>
                                    <option value="<?php echo $est['id_estado']?>"><?php echo $est['descripcion']?></option>
                                 <?php };?>
                                </select>
                                <span class="input-group-addon"><span class="fa fa-list-alt"></span></span>
                            </div>
                        </div>
                    </div>
                    </div>
                </div>
                <div class="col-md-12">
                    <div><br></div>
                    <div class="col-lg-3 col-md-4 col-xs-5"> <!-- required for floating -->
                        <!-- Nav tabs -->
                        <ul id="myTab2" class="nav nav-tabs tabs-left">
                            <li class="active"><a href="#trabajadores" data-toggle="tab">Trabajador</a></li>
                            <li><a href="#responsable" data-toggle="tab">Responsable</a></li>
                            <li><a href="#cuadrilla" data-toggle="tab">Tipo Orden</a></li>  
                        </ul>
                    </div>
                    <div class="col-lg-9 col-md-8 col-xs-7">
                        <!-- Tab panes -->
                        <div class="tab-content">
                            <div class="tab-pane fade in active" id="trabajadores" >
                                <div class="form-group" align="center">
                                    <label class="control-label col-lg-2" for = "worker">Nombre:</label>
                                    <div class="col-lg-5"> 
                                        <select class="form-control input-sm select2" id = "worker" name="worker" disabled>
                                            <option></option>
                                        </select>
                                    </div>
                                    <div class="col-lg-5"></div>
                                </div>
                                <div class="col-lg-12"><br/></div>
                                <div class="col-lg-3"></div>
                                <div class="col-lg-6">
                                   <button id="openModal" data-target="#consultar1" data-toggle="modal" type="button" class="btn btn-warning" disabled onclick="show_resp_worker($('#worker'),'trabajador',$('#report'),$('#result1'),$('#result2'),$('#status_orden'))">Consultar</button>
                                </div> 
                            </div>
                            <div class="tab-pane fade" id="responsable">
                                <div class="form-group" align="center">
                                    <label class="control-label col-lg-2" for = "respond">Responsable:</label>
                                    <div class="col-lg-5"> 
                                        <select class="form-control input-sm select2" id = "respon" name="respon">
                                            <option></option>
                                        </select>
                                    </div>
                                    <div class="col-lg-5"></div>
                                </div>
                                <div class="col-lg-12"><br/></div>
                                <div class="col-lg-3"></div>
                                <div class="col-lg-6">
                                    <a data-toggle="modal" data-target="#consultar1" class="btn btn-default btn">Consultar</a>
                                </div> 
                            </div>
                            <div class="tab-pane fade" id="cuadrilla">
                                <div class="form-group" align="center">
                                    <label class="control-label col-lg-2" for = "cuad">Solicitud:</label>
                                    <div class="col-lg-5"> 
                                        <select class="form-control input-sm select2" id = "cuad" name="cuad">
                                           <option></option>
                                        </select>
                                    </div>
                                    <div class="col-lg-5"></div>
                                </div>
                                <div class="col-lg-12"><br/></div>
                                <div class="col-lg-3"></div>
                                <div class="col-lg-6">
                                    <a data-toggle="modal" data-target="#consultar2" class="btn btn-default btn">Consultar</a>
                                </div> 
                            </div>
                        </div>
                    </div>            
                </div>                 
        </div>                          
        <div class="panel-footer">
            <div class='container'align="right">
                <div class="btn-group btn-group-sm pull-right">
                    <button onClick="javascript:window.history.back();" type="button" name="Submit" class="btn btn-info">Regresar</button>
                    <!--<button type="button" class="btn btn-primary" onclick="imprimir();">Imprimir</button> -->
                    <!--<button type="submit" class="btn btn-warning" id="prueba">TEST</button>-->   
                </div>
            </div>  
        </div>
    </div>
     </form>

</div>
<div class="clearfix"></div>
<!-- Modal para reportes_1-->
    <div id="consultar1" class="modal modal-message modal-info fade" tabindex="-1" role="dialog" aria-labelledby="mod" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <label class="modal-title">Consultas 1</label>
                </div>
                
              
                <form class="form">
                    <div class="modal-body row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <div class="col-lg-12 col-md-12 col-sm-12">
                                    <div id="report"></div>
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