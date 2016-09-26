<script src="<?php echo base_url() ?>assets/js/jquery.min.js"></script>
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
                                          <table id="reporte"  class="table table-hover table-bordered col-lg-12 col-md-12 col-sm-12 col-xs-12">
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
  var selects = $("div[id^='input'] > select");
  function addSelect(divName)
  {
    var select = $("<select/>");
    $.each(opciones, function(a, b){
      select.append($("<option/>").attr("value", b).text(a));
    });
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
        $("#botones").append('<label class="control-label" for="reporte" id="reporte_label">Mostrar tabla:</label>');
        $("#botones").append('<div class="input-group" >');
        $("#botones").append('<button class="btn btn-block btn-lg btn-info addon">  <img src="<?php echo base_url() ?>assets/img/alm/report2.png" class="img-rounded" alt="bordes redondeados" width="20" height="20">  </button>');
        $("#botones").append('</div>');
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
        console.log(columnas);
        $.ajax({
            type: "POST",
            "url": base_url + 'index.php/inventario/reportes',
            "data": {columnas:columnas},
            "success": function(json){
              console.log(json);
              $('#reporte').DataTable(json);
            },
            "dataType": "json"
        });

        // console.log($("button.btn.btn-block.btn-lg.btn-info.addon").length);
        $("button.btn.btn-block.btn-lg.btn-info.addon").click(function(){
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