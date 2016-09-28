<script src="<?php echo base_url() ?>assets/js/jquery.min.js"></script>
<!-- Bootstrap select 
<link href="<?php echo base_url() ?>assets/css/bootstrap-select.css" rel="stylesheet">-->
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
                      <div class="table-responsive">
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
                                          </div>
                                      </div>
                                      <ul class="nav navbar-nav navbar-right">
                                          <li></li>
                                      </ul>
                                  </div><!-- /.navbar-collapse -->
                              </div><!-- /.container-fluid -->
                          </nav>
                          <nav class="navbar navbar-default">
                              <div class="container-fluid">
                                  <!-- Brand and toggle get grouped for better mobile display -->
                                  <div class="navbar-header">
                                      <button type="button" title="Opciones de Búsqueda"class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-4" aria-expanded="false">
                                          <span class="sr-only">Toggle navigation</span>
                                          <span class="icon-bar"></span>
                                          <span class="icon-bar"></span>
                                          <span class="icon-bar"></span>
                                      </button>
                                  </div>
                                  <!-- Collect the nav links, forms, and other content for toggling -->
                                  <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-4">
                                      <div class="navbar-form navbar-left">
                                          <div class="input-group" align="center">
  <!--                                            <span class="input-group-addon" id="basic-addon1"></span>-->
                                              <span class="input-group-addon" id="basic-addon1"><i class="fa fa-search-plus"></i></span>
                                              <select class="form-control input-sm" id="menu" name="menu" style="width: 200px" align="center">
                                                  <option></option>
                                                  <option value=""></option>
                                                  <option value=""></option>
                                                  <option value=""></option>   
                                              </select>    
                                          </div>
                                      </div>
                                      <ul class="nav navbar-nav navbar-right">
                                          <li></li>
                                      </ul>
                                  </div><!-- /.navbar-collapse -->
                              </div><!-- /.container-fluid -->
                          </nav>

                          <div class="col-lg-12">
                          </div>
                          <button class="btn btn-danger btn-sm pull-right" id="reportePdf" type="submit" title="Crear PDF"><i class="fa fa-file-pdf-o fa-2x"></i></button>
                          <div class="col-lg-12 col-md-12 col-sm-12">
                              <table id="reportes" class="table table-hover table-bordered table-condensed" align="center" width="100%">
                                  <thead>
                                      <tr class="color">
                                          <th>Código</th>                                       
                                          <th>Descripción</th>
                                          <th>Movimiento</th>
                                          <th>Cantidad</th>
                                      </tr>
                                  </thead>
                                  <tbody>

                                  </tbody>
                              </table>
                          </div>
                      </div>
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
    var oTable = $('#reporte').dataTable();
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
        $.ajax({
            type: "POST",
            "url": base_url + 'index.php/inventario/tabla_config',
            // "url": base_url + 'index.php/inventario/reportes',
            "data": {columnas:columnas},
            "success": function(json){
              console.log('hello!');
              console.log(json);
              oTable.fnDestroy();
              oTable = $('#reporte').dataTable(json);
              // $('#reporte').dataTable(json);
            },
            "dataType": "json"
        });

        // console.log($("button.btn.btn-block.btn-lg.btn-info.addon").length);
        $("button.btn.btn-block.btn-lg.btn-info.addon").click(function()
        {
          console.log(this);
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

</script>
<!-- Bootstrap select js 
<script src="<?php echo base_url() ?>assets/js/bootstrap-select.min.js"></script>-->