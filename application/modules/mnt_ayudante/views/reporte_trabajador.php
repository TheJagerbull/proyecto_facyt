<script src="<?php echo base_url() ?>assets/js/jquery.min.js"></script>
<script type="text/javascript">
    base_url = '<?= base_url() ?>'
   function format ( e ) {
    return 'Orden'+e.orden+'<br>Dependencia:'+e.dependencia+'<br>Asunto:'+e.asunto;
}
    $(document).ready(function() {
        $("#status_orden").select2({//Esto es para iniciar el select2 como clase, ejemplo en la clase del select:
            theme: "bootstrap",
            language: "es",
            placeholder: "--SELECCIONE ESTATUS--", // <input select = "nombre select" class =" Le agregas clase de boostrap y luego la terminas con clase2 para activarlo" 
            allowClear: true
        });
        load_asig_trab($('#worker'));
        load_cuadrillas_asig($('#cuad'));
        load_respon_asig($('#respon'));
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
//            scroller:       true,
  
        "order": [[1, "asc"]], //para establecer la columna a ordenar por defecto y el orden en que se quiere 
        "ajax": {
            "url": "<?php echo site_url('mnt_ayudante/mnt_ayudante/reportes')?>",
            "type": "GET",
            "data": function ( d ) {
                d.uno = $('#result1').val();
                d.dos = $('#result2').val();
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
//            $('#buscador').keyup(function () { //establece un un input para el buscador fuera de la tabla
//            table.search($(this).val()).draw(); // escribe la busqueda del valor escrito en la tabla con la funcion draw
//        });
     
  // Array to track the ids of the details displayed rows
    var detailRows = [];
 
    $('#trabajador tbody').on( 'click', 'tr td.details-control', function () {
        var tr = $(this).closest('tr');
        var row = table.row( tr );
        var idx = $.inArray( tr.attr('id_orden_trabajo'), detailRows );
 
        if ( row.child.isShown() ) {
            tr.removeClass( 'details' );
            row.child.hide();
 
            // Remove from the 'open' array
            detailRows.splice( idx, 1 );
        }
        else {
            tr.addClass( 'details' );
            row.child( format( row.data() ) ).show();
 
            // Add to the 'open' array
            if ( idx === -1 ) {
                detailRows.push( tr.attr('id_orden_trabajo') );
            }
        }
    } );
 
    // On each draw, loop over the `detailRows` array and show any child rows
    table.on( 'draw', function () {
        $.each( detailRows, function ( i, id ) {
            $('#'+id+' td.details-control').trigger( 'click' );
        } );
    } );
    
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
 
    <div class="panel panel-info">
        <div class="panel-heading">
            <label><strong></strong> </label>
            <div class="btn-group btn-group-sm pull-right">
                <label><strong></strong></strong> </label>
            </div>
        </div>
        <div class="panel-body">
            <input type="hidden" id="valor" name="valor">  <!--estos inputs vienen del custom js en la funcion externa de busqueda por -->
            <input type="hidden" id="result1" name="result1"><!-- rangos para mostrar los resultados, estan ocultos despues de probar -->
            <input type="hidden" id="result2" name="result1"><!--por lo cual se pueden cambiar a tipo text para ver como funciona la busqueda-->
            <div class="table-responsive">
                <div class="col-lg-12">
                    <div><br></div>
                    <div class="col-xs-3"> <!-- required for floating -->
                        <!-- Nav tabs -->
                        <ul id="myTab2" class="nav nav-tabs tabs-left">
                            <li class="active"><a href="#trabajadores" data-toggle="tab">Trabajador</a></li>
                            <li><a href="#cuadrilla" data-toggle="tab">Cuadrilla</a></li>
                            <li><a href="#responsable" data-toggle="tab">Responsable</a></li>
                            <!--<li><a href="#settings-r" data-toggle="tab">Settings</a></li>-->
                        </ul>
                    </div>
                    <div class="col-xs-9">
                        <!-- Tab panes -->
                        <div class="tab-content">
                            <div class="tab-pane fade in active" id="trabajadores" align="center">
                                <div class="form-group">
                                    <label class="control-label col-lg-2" for = "worker">Nombre:</label>
                                    <div class="col-lg-5"> 
                                        <select class="form-control input-sm" id = "worker" name="worker">
                                            <!--<option value=""></option>-->
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="cuadrilla" align="center">
                                <div class="form-group">
                                    <label class="control-label col-lg-2" for = "cuad">Cuadrilla:</label>
                                    <div class="col-lg-6"> 
                                        <select class="form-control input-sm" id = "cuad" name="cuad">
                                            <!--<option value=""></option>-->
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="responsable" align="center">
                                <div class="form-group">
                                    <label class="control-label col-lg-2" for = "respond">Responsable:</label>
                                    <div class="col-lg-5"> 
                                        <select class="form-control input-sm" id = "respon" name="respon">
                                            <!--<option value=""></option>-->
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <!--<div class="tab-pane" id="settings-r">Settings Tab.</div>-->
                        </div>
                    </div>
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
                            <!--<label class="control-label col-lg-2" for = "respond">Responsable:</label>-->
                            <div class="input-group"> 
                                <select class="form-control input-sm select2" id = "status_orden" name="status_orden">
                                    <option></option>
                                 <?php foreach ($estatus as $est){?>
                                    <option value="<?php echo $est['id_estado']?>"><?php echo $est['descripcion']?></option>
                                 <?php };?>
                                </select>
                                <span class="input-group-addon"><span class="fa fa-list-alt"></span></span>
                            </div>
                        </div>
                    </div>
                    <div class="control-group col col-lg-12 col-md-12 col-sm-12">
                     
                    </div>
                </div>
                    </div>
                </div>
                
                <!--                    <div class="col-lg-12 col-md-12 col-sm-12">
                                        <table id="trabajador" class="table table-hover table-bordered table-condensed" align="center" width="100%">
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
                                        </table>
                                    </div>-->
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