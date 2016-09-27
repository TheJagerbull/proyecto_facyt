<script src="<?php echo base_url() ?>assets/js/jquery.min.js"></script>
<!-- Bootstrap select -->
<link href="<?php echo base_url() ?>assets/css/bootstrap-select.css" rel="stylesheet">
<style type="text/css">
  hr{ margin-top: 5px; margin-bottom: 5px; }
</style>
<div class="mainy">
  
  <!-- Page title -->
  <div class="page-title">
    <!-- <h2 align="right"><i class="fa fa-file color"></i> Articulos <small>de almacen</small></h2> -->
    <h2 align="right"><img src="<?php echo base_url() ?>assets/img/alm/main.png" class="img-rounded" alt="bordes redondeados" width="45" height="45"> Articulos <small>de almacen</small></h2>
    <hr />
  </div>
  <!-- Page title -->
  <div class="row">   
    <div class="awidget full-width">
        <div class="awidget-head">
              <h3>Operaciones sobre inventario de almacen</h3>
              <!-- <button id="mail" align="right">enviar retroalimentaci&oacute;n</button> -->
        </div>
        <div class="awidget-body">
            <ul id="myTab" class="nav nav-tabs">
              <!-- <?php if(!empty($alm[1])):?><li class="active"><a href="#home" data-toggle="tab">Cat&aacute;logo</a></li><?php endif;?> -->
              <!-- <?php if(!empty($alm[4])):?><li><a href="#active" data-toggle="tab">Inventario</a></li><?php endif;?> -->
              <!-- <?php if(!empty($alm[6])||!empty($alm[7])):?><li><a href="#add" data-toggle="tab">Agregar articulos</a></li><?php endif;?> -->
              <?php if(!empty($alm[5])):?><li class="active"><a href="#rep" data-toggle="tab">Reportes</a></li><?php endif;?>
              <!-- <?php if(!empty($alm[8])):?><li><a href="#close" data-toggle="tab">Cierre</a></li><?php endif;?> -->
            </ul>
          <div id="myTabContent" class="tab-content">


<!--LA ALTERACION SOBRE "principal.php"-->
          <?php if(!empty($alm[5])):?>
            <div id="rep" class="tab-pane fade in active">
                              <!-- Cuerpo del tab-->
                              <div class="awidget-body">
                                  <div class="container">
                                        <div id="nrColumns" class="col-lg-12 col-md-12 col-sm-12 col-xm-12 dropdown" align="center">
                                          <!-- <div class="dropdown"> -->
                                              <button class="btn btn-primary dropdown-toggle" id="selectNrColumns" type="button" data-toggle="dropdown">Elija la cantidad de columnas
                                                <span class="caret"></span>
                                              </button>
                                              <ul class="dropdown-menu" role="menu" aria-labelledby="menu1" style="right: 50%; left: 37%;">
                                                <li role="presentation"><a style="cursor: pointer !important;" onclick="selectedColumns(0)" role="menuitem" tabindex="-1">-- Predeterminado --</a></li>
                                                <li role="presentation"><a style="cursor: pointer !important;" onclick="selectedColumns(2)" role="menuitem" tabindex="-1">2 columnas</a></li>
                                                <li role="presentation"><a style="cursor: pointer !important;" onclick="selectedColumns(3)" role="menuitem" tabindex="-1">3 columnas</a></li>
                                                <li role="presentation"><a style="cursor: pointer !important;" onclick="selectedColumns(4)" role="menuitem" tabindex="-1">4 columnas</a></li>
                                                <li role="presentation"><a style="cursor: pointer !important;" onclick="selectedColumns(5)" role="menuitem" tabindex="-1">5 columnas</a></li>
                                                <li role="presentation"><a style="cursor: pointer !important;" onclick="selectedColumns(6)" role="menuitem" tabindex="-1">6 columnas</a></li>
                                                <li role="presentation" class="divider"></li>
                                                <li role="presentation"><a style="cursor: pointer !important;" onclick="ayuda()" role="menuitem" tabindex="-1">Ayuda</a></li>    
                                              </ul>
                                          <!-- </div> -->
                                        </div>
                                        <div id="columns" hidden class="col-lg-12 col-md-12 col-sm-12 col-xm-12" align="center">
                                        </div>
                                        <div id="botones" class="col-lg-4 col-md-4 col-sm-4 col-xm-4" align="center">
                                        </div>
                                        <div id="preview" hidden class="col-lg-12 col-md-12 col-sm-12 col-xm-12" align="center">
                                          <div class="responsive-table">
                                          <table id="reporte"  class="table table-hover table-bordered">
                                            <thead>
                                              <tr></tr>
                                            </thead>
                                            <tbody>
                                            </tbody>
                                            <tfoot>
                                            </tfoot>
                                          </table>
                                          </div>
                                        </div>
                                        
                                  </div>
                              </div>
                              <!-- Fin del cuerpo del tab-->
              <!-- Modal para cierre de inventario -->
                              <div class="modal fade" id="reporteModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                  <div class="modal-content">
                                    <div class="modal-header">
                                      <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                      <h4 class="modal-title"></h4>
                                    </div>
                                    <div class="modal-body">
                                              
                                    </div>
                                    <div class="modal-footer">
                                      <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                    </div>
                                  </div>
                                  <!-- /.modal-content -->
                                </div>
                                <!-- /.modal-dialog -->
                              </div>
              <!-- /.find del modal -->
            </div>
          <?php endif;?>
<!--FIN DE LA ALTERACION SOBRE "principal.php"-->

          </div>
        </div>
    </div>
  </div>
</div>
<script type="text/javascript">
  var base_url = '<?php echo base_url()?>';
  var opciones = {Columnas:"", Código:"cod_articulo", Descripción:"descripcion", Entradas:"entrada", Salidas:"salida", Fecha:"fecha", Existencia:"exist", bla1:"bla2"};
  // var dtOpciones = {{bVisible: false, bSearchable: false, bSortable: false}, {bVisible: true, bSearchable: true, bSortable: true}, {bVisible: true, bSearchable: true, bSortable: true}, {bVisible: true, bSearchable: true, bSortable: true}, {bVisible: true, bSearchable: true, bSortable: true}, {bVisible: true, bSearchable: false, bSortable: true}, {bVisible: true, bSearchable: false, bSortable: true}, {bVisible: true, bSearchable: false, bSortable: true}}
  var selects = $("div[id^='input'] > select");
  function addSelect(divName)
  {
    var select = $("<select/>");
    $.each(opciones, function(a, b){
      select.append($("<option/>").attr("value", b).text(a));
    });
    select.attr('class', 'btn-sm btn-info');
    console.log(select);
    // $(select).addClass("selectpicker");
    $("#"+divName).append(select);
  }

  function selectedColumns(numberOfColumns)
  {
    // console.log(numberOfColumns+" columnas selecciondas");
    if(numberOfColumns!=0)
    {
      var size = Math.round(12/numberOfColumns);
    }

    // console.log(size);
    $("#columns").html('');
    $("#columns").append('<hr><label>Seleccione las columnas en el orden como desee que aparezca en el reporte</label><hr>');
    for (var i = 0; i < numberOfColumns; i++)//agrego las columnas al html
    {
      var aux = "input"+i;      
      $("#columns").append('<div id="input'+i+'" class="col-lg-'+size+' col-md-'+size+' col-sm-'+size+' col-xm-'+size+'">');
      addSelect(aux);
      $("#columns").append('</div>');
    }
    $("#columns").show();//las muestro
    
    selects = $("div[id^='input'] > select");
    selects.change(function(){
      console.log('input change!')
      var flag = true;
      for (var i = 0; i < selects.length; i++)
      {
        if(selects[i].value=='')
        {
          flag = false;
        }
      }
      if(flag)
      {
        $("#botones").html('');
        $("#botones").append('<hr>');
        $("#botones").append('<div class="input-group" >');
        $("#botones").append('<label class="control-label" for="reporte" id="reporte_label">Mostrar tabla:</label><button class="btn btn-block btn-lg btn-info addon">  <img src="<?php echo base_url() ?>assets/img/alm/report2.png" class="img-rounded" alt="bordes redondeados" width="20" height="20">  </button>');
        $("#botones").append('</div><hr>');
        // console.log($('#reporte > thead').length);
        var table = $('#reporte > thead tr');
        var selectedSelects = $("option:selected");
        console.log(selectedSelects.length);
        $(table).html('');
        var columnas = [];
        for (var i = 0; i < selects.length; i++)
        {
          table.append('<th>'+$(selectedSelects[i]).text()+'</th>');
          // console.log($(selectedSelects[i]).text());
          console.log(selectedSelects[i].value);
          columnas[i] = selectedSelects[i].value;
          // columnas+={ i : selectedSelects[i].value};
        }
        // console.log(typeof oTable);

        // if(typeof oTable)
        console.log(columnas);
        console.log(typeof(oTable));
        // console.log(oTable);

        // if(typeof oTable === 'undefined' && oTable !==null)
        // if(! $.fn.DataTable.isDataTable('#reporte'))
        // {
        //   var oTable = $('#reporte').DataTable({
        //           "oLanguage": {
        //             "sProcessing": "Procesando...",
        //             "sLengthMenu": "Mostrar _MENU_ registros",
        //             "sZeroRecords": "No se encontraron resultados",
        //             "sInfo": "Muestra desde _START_ hasta _END_ de _TOTAL_ registros",
        //             "sInfoEmpty": "Muestra desde 0 hasta 0 de 0 registros",
        //             "sInfoFiltered": "(filtrado de _MAX_ registros en total)",
        //             "sInfoPostFix": "",
        //             "sLoadingRecords": "Cargando...",
        //             "sEmptyTable": "No se encontraron datos",
        //             "sSearch": "Buscar:",
        //             "sUrl": "",  
        //             "oPaginate": 
        //             {
        //                 "sNext": 'Siguiente',
        //                 "sPrevious": 'Anterior',
        //               "sLast": '<i class="glyphicon glyphicon-step-forward" title="Último"  ></i>',
        //               "sFirst": '<i class="glyphicon glyphicon-step-backward" title="Primero"  ></i>'
        //             }
        //           },
        //           "retrieve":true,
        //           "bProcessing": true,
        //           "lengthChange": false,
        //           "info": false,
        //           "stateSave": true,
        //           "bServerSide": true,
        //           "pagingType": "full_numbers",
        //           "sServerMethod": "GET",
        //           "sAjaxSource": "<?php echo base_url() ?>index.php/tablas/inventario/reportes",
        //           "bDeferRender": true,
        //           "fnServerData": function (sSource, aoData, fnCallback, oSettings){
        //               aoData.push({"name":"columnas", "value": JSON.stringify(columnas)});//para pasar datos a la funcion que construye la tabla
        //               oSettings.JqXHR = $.ajax({
        //                 "dataType": "json",
        //                 "type": "GET",
        //                 "url": sSource,
        //                 "data": aoData,
        //                 "success": fnCallback
        //               });
        //           },
        //           "iDisplayLength": 10,
        //           "aLengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
        //           "aaSorting": [[0, 'desc']]
        //   });
        // }
        // else
        // {
        //   console.log('is datatable');
        //   console.log(columnas);
        //   oTable.ajax.reload();
        // }
        $.ajax({
            type: "POST",
            "url": base_url + 'index.php/inventario/tabla_config',
            // "url": base_url + 'index.php/inventario/reportes',
            "data": {columnas:columnas},
            "success": function(json){
              console.log('hello!');
              console.log(json);
              var oTable = $('#reporte').dataTable(json);
            },
            "dataType": "json"
        });

        // console.log($("button.btn.btn-block.btn-lg.btn-info.addon").length);
        $("button.btn.btn-block.btn-lg.btn-info.addon").click(function(){

          $('#reporte').attr('style', '');
          // oTable.clear();
          // oTable.ajax.reload();
          // oTable.columns.adjust().draw();
          $("#preview").show();
        });

        // $('#reporteModal').on("show.bs.modal", function(){
        //   console.log("modal!");
        //     $("#formato.modal-title").html('');
        //     $("#formato.modal-body").html('');
        // });
      }
    });
  }

  function ayuda()
  {
    alert("aqui va una explicacion de ayuda!");
  }

  $(function()
  {
    //permite llenar el select oficina cuando tomas la dependencia en modulos mnt_solicitudes

        // $("#").change(function () {//Evalua el cambio en el valor del select
        //     $("# option:selected").each(function () { //en esta parte toma el valor del campo seleccionado
               
        //     });
        // });
////menu de columnas para generar el reporte
    // $(".dropdown").on("show.bs.dropdown", function(event){
    //     var x = $(event.relatedTarget).text(); // Toma el texto del elemento seleccionado
    //     alert(x);
    // });
////FIN del menu de columnas para generar el reporte

    
  });
</script>
<!-- Bootstrap select js -->
<script src="<?php echo base_url() ?>assets/js/bootstrap-select.min.js"></script>