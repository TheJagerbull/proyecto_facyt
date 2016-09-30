<script src="<?php echo base_url() ?>assets/js/jquery.min.js"></script>
<!-- Bootstrap select -->
<link href="<?php echo base_url() ?>assets/css/bootstrap-select.css" rel="stylesheet">
<style type="text/css">
  hr{ margin-top: 5px; margin-bottom: 5px; }
</style>
<script>
$(document).ready(function() {
    $('#articulos').DataTable({
    });
});
    base_url = '<?php echo base_url()?>';

$(document).ready(function()
{
	$('#data').dataTable({
                "language": {
                    "url": "<?php echo base_url() ?>assets/js/lenguaje_datatable/spanish.json"
                },
		"bProcessing": true,
	        "bServerSide": true,
	        "sServerMethod": "GET",
	        "sAjaxSource": "<?php echo base_url() ?>index.php/tablas/inventario",
	        "iDisplayLength": 10,
	        "aLengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
	        "aaSorting": [[0, 'asc']],
	        "aoColumns": [
			{ "bVisible": true, "bSearchable": true, "bSortable": true },
			{ "bVisible": true, "bSearchable": true, "bSortable": true },
			{ "bVisible": true, "bSearchable": true, "bSortable": true },
			{ "bVisible": false, "bSearchable": false, "bSortable": true },
			{ "bVisible": false, "bSearchable": false, "bSortable": true },
			{ "bVisible": false, "bSearchable": false, "bSortable": true },
			{ "bVisible": true, "bSearchable": true, "bSortable": false }//la columna extra
	        ]
	})
});
//act-inv
$(document).ready(function()
{
  $('#act-inv').dataTable({
    "language": {
                "url": "<?php echo base_url() ?>assets/js/lenguaje_datatable/spanish.json"
    },
    "bProcessing": true,
          "bServerSide": true,
          "sServerMethod": "GET",
          "sAjaxSource": "<?php echo base_url() ?>index.php/tablas/inventario/1",
          "rowCallback": function( row, data) {
            console.log(data.DT_RowId);
          },
          "iDisplayLength": 10,
          "aLengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
          "aaSorting": [[0, 'asc']],
          "aoColumns": [
      { "bVisible": true, "bSearchable": true, "bSortable": true },
      { "bVisible": true, "bSearchable": true, "bSortable": true },
      { "bVisible": true, "bSearchable": true, "bSortable": true },
      { "bVisible": true, "bSearchable": true, "bSortable": true },
      { "bVisible": true, "bSearchable": true, "bSortable": true },
      { "bVisible": true, "bSearchable": true, "bSortable": true },
      { "bVisible": true, "bSearchable": true, "bSortable": true },
      { "bVisible": true, "bSearchable": true, "bSortable": true },
      { "bVisible": true, "bSearchable": true, "bSortable": false }//la columna extra
          ]
  })
    $('#act-inv tbody').on( 'click', 'a', function ()
    {
      var aux = this.href.substring(this.href.lastIndexOf('#'));
      var art_cod = aux.replace( /^\D+/g, '');
      // console.log(art_cod);
      // console.log($('#art'+art_cod).length);
      if (!$.fn.DataTable.isDataTable('#hist_art'+art_cod))
      {
        console.log(art_cod);
        var histArtTable = $('#hist_art'+art_cod).DataTable({
              "language": {
                  "url": "<?php echo base_url() ?>assets/js/lenguaje_datatable/spanish.json"
              },
              "bProcessing": true,
                    "bServerSide": true,
                    "sServerMethod": "GET",
                    "sAjaxSource": "<?php echo base_url() ?>index.php/tablas/inventario/historial/"+art_cod,
                    "bDeferRender": true,
                    "fnServerData": function (sSource, aoData, fnCallback, oSettings){
                        aoData.push({"name":"fecha", "value": $('#date').val()});//para pasar datos a la funcion que construye la tabla
                        oSettings.JqXHR = $.ajax({
                          "dataType": "json",
                          "type": "GET",
                          "url": sSource,
                          "data": aoData,
                          "success": fnCallback
                        });
                    },
                    "iDisplayLength": 10,
                    "aLengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
                    "aaSorting": [[0, 'asc']],
                    "aoColumns": [
                { "bVisible": true, "bSearchable": true, "bSortable": true },
                { "bVisible": true, "bSearchable": true, "bSortable": true },
                { "bVisible": true, "bSearchable": false, "bSortable": true },
                { "bVisible": true, "bSearchable": false, "bSortable": true },
                { "bVisible": true, "bSearchable": false, "bSortable": false }
                    ]
        });
      }
      

    });
});

//http://code.tutsplus.com/tutorials/submit-a-form-without-page-refresh-using-jquery--net-59
// $(function()
// {
//     $('#error').hide();
//     $("#check_inv").click(function(){
//         //validar y formulario
//         $('.error').hide();
// 		var articulo = $("input#autocompleteAdminArt").val();
// 		if (articulo == "") {
// 			$("label#name_error").show();
// 			$("input#autocompleteAdminArt").focus();
// 			return false;
// 		}
//     });
// });
$(document).ready(function() {
    $('#trigger').click(function(){
      $("#dialog").dialog();
    }); 
  });
</script>

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
            <?php if($this->session->flashdata('add_articulos') == 'error') : ?>
              <div class="alert alert-danger" style="text-align: center">Ocurrió un problema agregando art&iacute;culos desde el archivo</div>
            <?php endif ?>
            <?php if($this->session->flashdata('add_articulos') == 'success') : ?>
              <div class="alert alert-success" style="text-align: center">Art&iacute;culos agregados exitosamente</div>
            <?php endif ?>
		    <div class="awidget-body">
  					<ul id="myTab" class="nav nav-tabs">
  						<?php if(!empty($alm[1])):?><li class="active"><a href="#home" data-toggle="tab">Cat&aacute;logo</a></li><?php endif;?>
  						<?php if(!empty($alm[4])):?><li><a href="#active" data-toggle="tab">Inventario</a></li><?php endif;?>
  						<?php if(!empty($alm[6])||!empty($alm[7])):?><li><a href="#add" data-toggle="tab">Agregar articulos</a></li><?php endif;?>
  						<?php if(!empty($alm[5])):?><li><a href="#rep" data-toggle="tab">Reportes</a></li><?php endif;?>
              <?php if(!empty($alm[8])):?><li><a href="#close" data-toggle="tab">Cierre</a></li><?php endif;?>
  					</ul>
  				<div id="myTabContent" class="tab-content">
    						<?php if(!empty($alm[1])):?>
                <div id="home" class="tab-pane fade in active">
                  <table id="data" class="table table-hover table-bordered col-lg-8 col-md-8 col-sm-8">
    							    <thead>
    							        <tr>
    							            <th>Item</th>
    							            <th>codigo</th>
    							            <th>Descripcion</th>
    							            <th>Existencia</th>
    							            <th>Reservados</th>
    							            <th>Disponibles</th>
    							        	<th>Detalles</th>
    							        </tr>
    							    </thead>
    							    <tbody></tbody>
    							    <tfoot></tfoot>
    							</table>
    						</div>
              <?php endif;?>
                <!-- Articulos activos del sistema -->
    						<?php if(!empty($alm[4])):?>
                <div id="active" class="tab-pane fade">
    							
                  <table id="act-inv" class="table table-hover table-bordered col-lg-8 col-md-8 col-sm-8">
                      <thead>
                          <tr>
                              <th rowspan="2" ><div align="center">Item</div></th>
                              <th rowspan="2" ><div align="center">codigo</div></th>
                              <th rowspan="2" ><div align="center">Descripcion</div></th>
                              <th rowspan="2" ><div align="center">Existencia</div></th>
                              <th rowspan="2" ><div align="center">Por despachar</div></th>
                              <th colspan="2" ><div align="center">Disponibles</div></th>
                              <th rowspan="2" ><div align="center">Stock m&iacute;nimo</div></th>
                              <th rowspan="2" ><div align="center">Detalles</div></th>
                          </tr>
                          <tr>
                              <th><div align="left">Nuevos</div></th>
                              <th><div align="right">Usados</div></th>
                          </tr>
                      </thead>
                      <tbody></tbody>
                      <tfoot></tfoot>
                  </table>
    						</div>
              <?php endif;?>
    						<?php if(!empty($alm[6])||!empty($alm[7])):?>
                <div id="add" class="tab-pane fade">
                                <div class="awidget-body">
                                  <?php if(!empty($alm[6])):?>
                                  <div class="alert alert-info" style="text-align: center">
                                      Escriba palabras claves de la descripci&oacute;n del art&iacute;culo &oacute; el c&oacute;digo.
                                  </div>
                                  <div class="alert alert-warning" style="text-align: center">
                                  	S&iacute; el art&iacute;culo no aparece &oacute; no existe, deber&aacute; agregarlo manualmente.
                                  </div>
                                  <div id="error" class="alert alert-danger" style="text-align: center">
                                  </div>
                                  <div id="non_refreshForm">
    	                              <form id="ACqueryAdmin" class="input-group form">
    	                                 <!-- <label for="autocompleteAdminArt" id="articulos_label">Articulo</label> -->
    	                                 <input id="autocompleteAdminArt" type="search" name="articulos" class="form-control" placeholder="Descripci&oacute;n del art&iacute;culo, &oacute; codigo s&iacute; ex&iacute;ste">
    	                                 <span class="input-group-btn">
    	                                    <button id="check_inv" type="button" class="btn btn-info">
    	                                      <i class="fa fa-plus"></i>
    	                                    </button>
    	                                  </span>
    	                              </form>
                                  </div>
                                  <?php endif;?>
                                  <!-- <button id="add_fromFile" class="btn-lg btn-info glyphicon glyphicon-save-file">Agregar desde archivo</button> -->
                                  <?php if(!empty($alm[7])):?>
                                  <!-- Subida de archivo de excel para agregar articulos a inventario -->
                                    <div id="add_file" class="form-group" align="center">
                                        <!--<?php echo form_open_multipart('alm_articulos/excel_to_DB');?>--><!--metodo tradicional de codeigniter para formularios-->
                                        <!--<label class="control-label" for="New_inventario">Tabla de articulos nuevos de Excel:</label>
                                        <div class="input-group col-md-2" align="right">
                                            <input id="New_inventario" type="file" name="userfile">--><!-- el input debe llamarse userfile, siguiendo el formato de codeigniter-->
                                      <div class="form-group">
                                          <label class="control-label" for="excel">Tabla de articulos nuevos de Excel:</label>
                                          <div class="input-group col-md-5">
                                              <input id="New_inventario" type="file" name="userfile">
                                          </div>
                                      </div>
                                    </div>
                                      <!-- </form>
                                    </div> -->
                                  <!-- FIN DE Subida de archivo de excel para agregar articulos a inventario -->
                                  <?php endif;?>
                                  <div id="resultado"><!--aqui construllo lo resultante de la busqueda del articulo, para su adicion a inventario -->
                                  </div>

                                </div>
    						</div>
              <?php endif;?>
    						<?php if(!empty($alm[5])):?>
                <div id="rep" class="tab-pane fade">
                                <!-- Cuerpo del tab-->
                                <div class="awidget-body">
                                    <nav class="navbar navbar-default">
                                        <div class="container-fluid">
                                            <div id="nrColumns" class="dropdown col-lg-offset-4 col-md-offset-4 col-sm-offset-4 col-xs-offset-4" style="padding-top: 1%;">
                                                <button class="btn btn-primary dropdown-toggle" id="selectReport" type="button" data-toggle="dropdown">Elija el tipo de reporte
                                                  <span class="caret"></span>
                                                </button>
                                                <ul class="dropdown-menu" role="menu" aria-labelledby="menu1" style="right: 60%; left: 10%;">
                                                  <li role="presentation"><a style="cursor: pointer !important;" onclick="selectedColumns(0)" role="menuitem" tabindex="-1">-- Predeterminado --</a></li>
                                                  <li role="presentation"><a style="cursor: pointer !important;" onclick="selectedColumns(2)" role="menuitem" tabindex="-1">Reporte genérico</a></li>
                                                  <li role="presentation"><a style="cursor: pointer !important;" onclick="selectedColumns(3)" role="menuitem" tabindex="-1">Reporte por departamento</a></li>
                                                  <li role="presentation"><a style="cursor: pointer !important;" onclick="selectedColumns(4)" role="menuitem" tabindex="-1">4 columnas</a></li>
                                                  <li role="presentation"><a style="cursor: pointer !important;" onclick="selectedColumns(5)" role="menuitem" tabindex="-1">5 columnas</a></li>
                                                  <li role="presentation" class="divider"></li>
                                                  <li role="presentation"><a style="cursor: pointer !important;" onclick="ayuda()" role="menuitem" tabindex="-1">Ayuda</a></li>    
                                                </ul>
                                            </div>
                                        </div>
                                    </nav>
                                    <nav class="navbar navbar-default">
                                        <div class="container-fluid">
                                            <!-- Brand and toggle get grouped for better mobile display -->
                                            <div id="nrColumns" class="dropdown col-lg-offset-4 col-md-offset-4 col-sm-offset-4 col-xs-offset-4" style="padding-top: 1%;">
                                                <button class="btn btn-primary dropdown-toggle" id="selectNrColumns" type="button" data-toggle="dropdown">Elija la cantidad de columnas
                                                  <span class="caret"></span>
                                                </button>
                                                <ul class="dropdown-menu" role="menu" aria-labelledby="menu1" style="right: 60%; left: 10%;">
                                                  <li role="presentation"><a style="cursor: pointer !important;" onclick="selectedColumns(0)" role="menuitem" tabindex="-1">-- Predeterminado --</a></li>
                                                  <li role="presentation"><a style="cursor: pointer !important;" onclick="selectedColumns(2)" role="menuitem" tabindex="-1">2 columnas</a></li>
                                                  <li role="presentation"><a style="cursor: pointer !important;" onclick="selectedColumns(3)" role="menuitem" tabindex="-1">3 columnas</a></li>
                                                  <li role="presentation"><a style="cursor: pointer !important;" onclick="selectedColumns(4)" role="menuitem" tabindex="-1">4 columnas</a></li>
                                                  <li role="presentation"><a style="cursor: pointer !important;" onclick="selectedColumns(5)" role="menuitem" tabindex="-1">5 columnas</a></li>
                                                  <li role="presentation"><a style="cursor: pointer !important;" onclick="selectedColumns(6)" role="menuitem" tabindex="-1">6 columnas</a></li>
                                                  <li role="presentation" class="divider"></li>
                                                  <li role="presentation"><a style="cursor: pointer !important;" onclick="ayuda()" role="menuitem" tabindex="-1">Ayuda</a></li>    
                                                </ul>
                                            </div>
                                            <!-- Collect the nav links, forms, and other content for toggling -->
                                            <div id="columns" class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                                                <div class="navbar-form"  align="center">
                                                    <div class="input-group">
                                                    </div>
                                                </div>
                                                <ul class="nav navbar-nav navbar-right">
                                                    <li></li>
                                                </ul>
                                            </div><!-- /.navbar-collapse -->
                                        </div><!-- /.container-fluid -->
                                    </nav>
                                    <nav id="tableControl" hidden class="navbar navbar-default">
                                        <div class="container-fluid">
                                            <!-- Brand and toggle get grouped for better mobile display -->
                                            <div class="navbar-header">
                                            </div>
                                            <!-- Collect the nav links, forms, and other content for toggling -->
                                            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-4">
                                                <div class="navbar-form navbar-left">
                                                    <div class="input-group">
                                                      <span class="input-group-addon" id="basic-addon1"><i class="fa fa-calendar"></i></span>
                                                      <input name="fecha" id="fecha" type="search"  class="form-control input-md" placeholder=" Búsqueda por Fechas" />
                                                      <span class="input-group-addon" id="basic-addon2"><i class="fa fa-search"></i></span>
                                                      <input name="buscador" id="buscador" type="text" class="form-control input-md" placeholder=" Búsqueda general">
                                                      <span class="input-group-addon" id="basic-addon2"><i class="fa fa-history"></i></span>
                                                      <select class="selectpicker" multiple title="Clasificar por movimientos...">
                                                        <option>Entradas</option>
                                                        <option>Salidas</option>
                                                      </select>

                                                    </div>
                                                </div>
                                                <ul class="nav navbar-nav navbar-right">
                                                    <li></li>
                                                </ul>
                                            </div><!-- /.navbar-collapse -->
                                        </div><!-- /.container-fluid -->
                                    </nav>

                                    <div class="container">
                                          <div id="preview" hidden class="col-lg-12 col-md-12 col-sm-12 col-xm-12" align="center">
                                            <div class="responsive-table">
                                            <table id="tablaReporte"  class="table table-hover table-bordered">
                                              <thead>
                                                <tr><th></th></tr>
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
                </div>
              <?php endif;?>
                <!-- Cierre de inventario -->
                <?php if(!empty($alm[8])):?>
                <div id="close" class="tab-pane fade">

                    <div class="alert alert-warning" style="text-align: center">
                      Para realizar el cierre de inventario, debe cargar un archivo del inventario fisico con el siguiente formato...
                    </div>
              <!-- formato para el archivo del cierre de inventario -->
                    <label class="control-label" for="portfolio">Formato de archivo</label>
                    <div class="img-portfolio" > 
                        <div id="portfolio">                       
                          <div class="element">
                            <a href="<?php echo base_url() ?>assets/img/alm/ejemplo.png" class="prettyphoto">
                              <img src="<?php echo base_url() ?>assets/img/alm/ejemplo.png" alt=""/>
                            </a>
                          </div>
                        </div>
                    </div>
              <!-- fin del formato -->
              <!-- Subida de archivo de excel para cierre de inventario-->
                    <div class="form-group">
                        <label class="control-label" for="excel">Insertar archivo de Excel:</label>
                        <div class="input-group col-md-5">
                            <input id="excel" type="file" name="userfile">
                        </div>
                    </div>
                </div>
              <?php endif;?>
					</div>
          <!-- Modal para iframe del pdf -->
          <!--<div class="modal fade" id="reporte" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
              <div class="modal-content">
                <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                  <h4 class="modal-title" id="reporteLabel"></h4>
                </div>
                <div class="modal-body" style="height: 768px">
                    <iframe id="reporte_pdf" src="" width="100%" height="100%" frameborder="0" allowtransparency="true"></iframe>  
                    <p id="malta"></p>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
              </div>-->
              <!-- /.modal-content -->
            <!-- </div> -->
            <!-- /.modal-dialog -->
          <!-- </div> -->
          <!-- /.fin del modal -->
          <div class="modal fade" id="log" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog">
              <div class="modal-content">
                <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                  <h4 class="modal-title" id="log-title"></h4>
                </div>
                <div id="errorlog" class="modal-body">
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
              </div>
            </div>
          </div>


				</div>
		</div>
	</div>
  <!-- <div hidden id="mailto">
    <p><input id="subject" type="text" placeholder="escriba el asunto" class="form-control"></p>
    <p><input id="message" type="text" placeholder="escriba el mensaje" class="form-control"></p>
    <p><a id="mail-link" class="btn btn-primary">Create email</a></p>
  </div> -->
</div>
<script type="text/javascript">
///////Funciones para reportes de la pestana reportes
  var base_url = '<?php echo base_url()?>';
  //opciones es un arreglo de las distintas columnas consultables en la BD en formato de objeto, {nombre_humano: "nombre_enBD"}
  var opciones = {Columnas:"", Código:"cod_articulo", Descripción:"descripcion", Entradas:"entrada", Salidas:"salida", Fecha:"fecha", Existencia:"exist", bla1:"bla2"};
  //dtOpciones es un arreglo que acopla las opciones del dataTable a cada columna, esas opciones o atributos corresponden a visibilidad, "buscabilidad" y "ordenabilidad", formato nombre_enBD:{atributos}
  var dtOpciones = {cod_articulo:{bVisible: true, bSearchable: true, bSortable: true}, descripcion:{bVisible: true, bSearchable: true, bSortable: true}, entrada:{bVisible: true, bSearchable: false, bSortable: true}, salida:{bVisible: true, bSearchable: false, bSortable: true}, fecha:{bVisible: true, bSearchable: false, bSortable: true}, exist:{bVisible: true, bSearchable: false, bSortable: true}}
  // var selects = $("div[id^='input'] > select");
  var selects = $("#columns > div > .input-group > select");
  // console.log(dtOpciones[1]);
  function addSelect(divName)
  {
    var select = $("<select/>");
    $.each(opciones, function(a, b){
      select.append($("<option/>").attr("value", b).text(a));
    });
    // select.attr('class', 'btn-sm btn-info');
    console.log(select);
    // $(select).addClass("selectpicker");
    $("#"+divName).append(select);
  }

  function selectedColumns(numberOfColumns)//para reporte general
  {
    var oTable = $('#tablaReporte').dataTable();
    // console.log(numberOfColumns+" columnas selecciondas");
    if(numberOfColumns!=0)
    {
      var size = Math.round(12/numberOfColumns);
    }

    // console.log(size);
    $("#columns > div > .input-group").html('');
    $("#columns > div > .input-group").append('<hr><label>Seleccione las columnas en el orden como desee que aparezca en el reporte</label><hr>');
    for (var i = 0; i < numberOfColumns; i++)//agrego las columnas al html
    {
      var aux = "input"+i;      
      $("#columns > div > .input-group").append('<div id="input'+i+'" class="col-lg-'+size+' col-md-'+size+' col-sm-'+size+' col-xm-'+size+'">');
      addSelect(aux);
      $("#columns > div > .input-group").append('</div>');
    }
    // $("#columns").show();//las muestro
    
    // selects = $("div[id^='input'] > select");
    selects = $("#columns > div > .input-group > div > select");
    console.log(selects);
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
        $("#botones").append('<label class="control-label" for="tablaReporte" id="tablaReporte_label">Mostrar tabla:</label><button class="btn btn-block btn-lg btn-info addon">  <img src="<?php echo base_url() ?>assets/img/alm/report2.png" class="img-rounded" alt="bordes redondeados" width="20" height="20">  </button>');
        $("#botones").append('</div><hr>');
        // console.log($('#tablaReporte > thead').length);
        var table = $('#tablaReporte > thead tr');
        var selectedSelects = $("#columns > div > .input-group > div > select > option:selected");
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
        console.log("columnas: ");
        console.log(columnas);
/////////Opcion 2: construlle la datatable de una vez, con sus respectivos atributos, y la definicion de las interacciones de fncallback
        var acols = [];
        var cols = [];
        for (var i = 0; i < columnas.length; i++)//aqui construlle las columnas de la datatable junto con sus atributos de busqueda, ordenamiento y/o visibilidad en interfaz
        {
          console.log(columnas[i]);
          acols.push({'name':columnas[i]});//columnas a consultar en bd
          console.log(dtOpciones[columnas[i]]);
          cols.push(dtOpciones[columnas[i]]);//opciones de las columnas en bd
        }
        console.log(acols);
        console.log(cols);
        oTable.fnDestroy();
        oTable = $('#tablaReporte').dataTable({
                    "oLanguage":{
                      "sProcessing":"Procesando...",
                      "sLengthMenu":"Mostrar _MENU_ registros",
                      "sZeroRecords":"No se encontraron resultados",
                      "sInfo":"Muestra desde _START_ hasta _END_ de _TOTAL_ registros",
                      "sInfoEmpty":"Muestra desde 0 hasta 0 de 0 registros",
                      "sInfoFiltered":"(filtrado de _MAX_ registros en total)",
                      "sInfoPostFix":"",
                      "sLoadingRecords":"Cargando...",
                      "sEmptyTable":"No se encontraron datos",
                      "sSearch":"Buscar:",
                      "sUrl":"",
                      "oPaginate":{
                        "sNext":"Siguiente",
                        "sPrevious":"Anterior",
                        "sLast":"<\/i>",
                        "sFirst":"<\/i>"
                        }
                      },
                      "bProcessing":true,
                      "lengthChange":false,
                      "searching":false,
                      "info":false,
                      "stateSave":true,
                      "bServerSide":true,
                      "pagingType":"full_numbers",
                      "sServerMethod":"GET",
                      "sAjaxSource":"<?php echo base_url();?>/index.php/tablas/inventario/reportes",
                      "bDeferRender":true,
                      "iDisplayLength":10,
                      "aLengthMenu":[[10,25,50,-1],[10,25,50,"ALL"]],
                      "aaSorting":[[0,"desc"]],
                      "aColumns": cols,
                      "columns": acols
                  });
        $('#tablaReporte').attr('style', '');
        $("#preview").show();
        $('#tableControl').show();
/////////FIN de Opcion 2: construlle la datatable de una vez, con sus respectivos atributos, y la definicion de las interacciones de fncallback

/////////Opcion 1: realiza una interaccion con el servidor, para solicitar la configuracion del datatable con las columnas enviadas
        // console.log(oTable);
        // $.ajax({
        //     type: "POST",
        //     "url": base_url + 'index.php/inventario/tabla_config',
        //     // "url": base_url + 'index.php/inventario/reportes',
        //     "data": {columnas:columnas},
        //     "success": function(json){
        //       var config = json;
        //       console.log('hello!');
        //       console.log(json);
        //       // $.extend(config, {'fnServerData': function(){console.log('hello')}});
        //       console.log(config);
        //       oTable.fnDestroy();
        //       oTable = $('#tablaReporte').dataTable(json);

        //       // console.log(this);
        //       $('#tablaReporte').attr('style', '');
        //       // oTable.clear();
        //       // oTable.ajax.reload();
        //       // oTable.columns.adjust().draw();
        //       $("#preview").show();
        //       $('#tableControl').show();
        //       // $('#tablaReporte').dataTable(json);
        //     },
        //     "dataType": "json"
        // });
/////////FIN de Opcion 1: realiza una interaccion con el servidor, para solicitar la configuracion del datatable con las columnas enviadas
        // console.log($("button.btn.btn-block.btn-lg.btn-info.addon").length);
      }
    });
  }

  function ayuda()
  {
    alert("aqui va una explicacion de ayuda!");
  }
///////FIN de funciones para reportes de la pestana reportes
    $(function(){

      // console.log('<?php echo form_open_multipart("alm_articulos/inv_cierre");?>');
      $("#New_inventario").fileinput({//para ingresar nuevo inventario al sistema desde un archivo de excel, independiente de que exista los codigos o no
          language:'es',
          showCaption: false,
          showUpload: true,
          showRemove: false,
          autoReplace: true,
          maxFileCount: 1,
          previewFileType: "text",
          uploadUrl: "<?php echo base_url() ?>index.php/inventario/insertar/fromExcelFile",
          browseLabel: " Agregar desde archivo...",
          browseIcon: '<i class="glyphicon glyphicon-file"></i>'
      });
      $("#New_inventario").on('fileuploaded', function(event, data, previewId, index){//evento de subida de archivo

        // console.log(data.response['success']);
        // console.log(data.response.success);
        // console.log(data.response);
        if(data.response)
        {
          if(data.response.success)
          {
            console.log(data.response);

            swal({
                title: "Artículos agregados con Éxito",
                text: "Se han agregado "+data.response.success+" artículos nuevos al sistema.",
                type: "success"
            });
            
          }
          else
          {
            var errorlog = '<div class="error-log"><ul>';
            for (var i = 0; i < data.response.length; i++)
            {
              console.log(data.response[i]);
              var aux = data.response[i];
              errorlog += '<li>';
              errorlog += '<span class="label label-danger">linea: '+aux.linea+'</span> ';
              errorlog += '<span class="label label-success">codigo: '+aux.codigo+'</span> ';
              errorlog += aux.descripcion;
              errorlog +='</li>';

            }
            errorlog += '</ul></div>';
            // console.log(errorlog);
            $("#log-title").html("Art&iacute;culos repetidos:  <span class='badge badge-info'>"+data.response.length+"</span>");
            $("#errorlog").html(errorlog)
            $("#log").modal('show');
          }
        }
        else
        {
          $("#log-title").html("Art&iacute;culos repetidos:  <span class='badge badge-info'>"+data.response.length+"</span>");
          $("#errorlog").html("")
          $("#log").modal('show');
        }

      });




      $("#excel").fileinput({//para la subida del archivo de excel necesario para el cierre de inventario
          language:'es',
          showCaption: false,
          showUpload: false,
          showRemove: false,
          autoReplace: true,
          maxFileCount: 1,
          uploadUrl: "<?php echo base_url() ?>index.php/inventario/cierre/fromExcelFile",
          previewFileType: "text",
          browseLabel: " Examinar...",
          browseIcon: '<i class="glyphicon glyphicon-file"></i>'
      });
      $("#excel").on('fileuploaded', function(event, data, previewId, index){//evento de subida de archivo
        console.log(data.response);
        var aux = data.response;
        $.post("<?php echo base_url() ?>index.php/inventario/cierre/readExcelFile", { //se le envia la data por post al controlador respectivo
                file: aux  //variable a enviar
            }, function (data) {
                console.log(data);
                console.log();
                var hoy = new Date();
                var aux = hoy.getUTCFullYear()+'-'+("0"+hoy.getUTCMonth()+1).slice(-2)+'-'+("0"+hoy.getUTCDate()).slice(-2);
              // $('#reporte_pdf').html(data);
              // $('#malta').html(data);
              // $('#reporte_pdf').attr("src", "alm_articulos/pdf_reportesInv");
                console.log("<?php echo base_url() ?>uploads/cierres/"+aux+".pdf");
              $('#reporte_pdf').attr("src", "<?php echo base_url() ?>uploads/cierres/"+aux+".pdf");
              $('#reporte').modal('show');

            });
        var hoy = new Date();
        var aux = hoy.getUTCFullYear()+'-'+(hoy.getUTCMonth()+1)+'-'+hoy.getUTCDate();
        $('#reporte_pdf').attr("src", "<?php echo base_url() ?>uploads/cierres/"+aux+".pdf");
        $('#reporte').modal('show');
        var showModal = $('<button class="btn btn-primary">Mostrar</button>');
        $('#cierre_inventario .modal-body').append(showModal);
        showModal.on('click', function(){$('#reporte').modal('show')});
      });

    });
    // function generarHistorial(year){
    //   console.log(year);
    //   //formato de src para iframe <?php echo base_url()?>/uploads/cierres/2015-12-22.pdf
    //   $('#reporte_pdf').attr("src", "alm_articulos/pdf_cierreInv/"+year);
    //   $('#reporte').modal('show');
    // };


  //   $(function(){//boton del cierre del ano fiscal de inventario
  //       var desde = new Date();//el valor es el 1 de diciembre del agno actual
  //       desde.setMonth(11);
  //       desde.setDate(1);
  //       desde.setHours(00);
  //       desde.setMinutes(00);
  //       desde.setSeconds(1);
  //       var hasta = new Date();//el valor es el 31 de diciembre del agno actual
  //       hasta.setMonth(11);
  //       hasta.setDate(31);
  //       hasta.setHours(23);
  //       hasta.setMinutes(59);
  //       hasta.setSeconds(59);
  //       var hoy = new Date();//el valor es "hoy"
  //       // hoy.getTime();
  // //para pruebas
  //             hoy.setMonth(11);
  //             hoy.setDate(22);
  //             hoy.setHours(23);
  //             hoy.setMinutes(59);
  //             hoy.setSeconds(59);
  // //fin de prueba
  //       desde=Date.parse(desde);
  //       hasta=Date.parse(hasta);
  //       hoy=Date.parse(hoy);

  //       console.log(desde);
  //       console.log(hasta);
  //       console.log(hoy);

  //       if((desde < hoy) && (hoy < hasta))
  //       {
  //         console.log("Listo para realizar cierre");
  //         // $('#generarPdf').removeAttr('disabled');
  //         $('#excel').fileinput('enable');
  //       }
  //       else
  //       {
  //         console.log("No esta listo para realizar cierre");
  //         // $('#generarPdf').attr('disabled', 'disabled');
  //         $('#excel').fileinput('disable');
  //       }
  //   });

    // $(function(){
    //   // $('input[name="cierre"]').daterangepicker({
    //   //   format: 'DD-MM-YYYY',
    //   //   singleDatePicker: true,
    //   //   showDropdowns: true,
    //   //   maxDate: moment()
    //   // }, 
    //   // function(start, end, label) {
    //   //   $('#cierre span').html(end);
    //   // }),
    //   $('#reportePdf').click(function(){
    //     var hoy = new Date();//el valor es "hoy"
    //     // hoy.getTime();
    //       //para pruebas
    //                   // hoy.setMonth(11);
    //                   // hoy.setDate(22);
    //                   // hoy.setHours(23);
    //                   // hoy.setMinutes(59);
    //                   // hoy.setSeconds(59);
    //       //fin de prueba
    //     // hoy=Date.parse(hoy)/1000;
    //     // console.log(hoy);
    //       $('#reporte_pdf').attr("src", "<?php echo base_url() ?>index.php/inventario/reporte");
    //   });
    // });

    function validateNumber(x)
    {
        // var numb = /[0-9]$|[0-9]^|[0-9]*/;
        var numb = /^[0-9]+$/;
        var input = document.getElementById(x);
        var msg = document.getElementById(x+"_msg");
        	// console.log(input.value);
        if(numb.test(input.value))
        {
        	// console.log(input.value);
          input.style.background ='#DFF0D8';
          msg.innerHTML = "";
          // document.getElementById('numero_msg').innerHTML = "";
          return true;
        }
        else
        {
          input.style.background ='#F2DEDE';
          msg.innerHTML = "Debe ser un numero entero";
          // document.getElementById('numero_msg').innerHTML = "Debe ser un numero";
          return false;
        }
    }
    function validateNotEmpty(x)
    {
          var input = document.getElementById(x);
          var msg = document.getElementById(x+"_msg");
          if(input.value!='')
          {
            input.style.background ='#DFF0D8';
            msg.innerHTML = "";
            return true;
          }
          else
          {
            input.style.background ='#F2DEDE';
            msg.innerHTML = "Debe indicar la orden de compra con identificacion, fecha y monto";
            return false;
          }
    }
    function validateRealNumber(x)
    {
        var real = /^[0-9]+[.][0-9]*$/;
        var input = document.getElementById(x);
        var msg = document.getElementById(x+"_msg");
        if(real.test(document.getElementById(x).value))
        {
          input.style.background ='#DFF0D8';
          msg.innerHTML = "";
          return true;
        }
        else
        {
          input.style.background ='#F2DEDE';
          msg.innerHTML = "Debe ser un numero real Ej.: 0.123, 1.368, etc.";
          return false;
        }
    }
    function validateSingleWord(x)
    {
        var real = /^[A-Za-z]+$/;
        var input = document.getElementById(x);
        var msg = document.getElementById(x+"_msg");
        if(real.test(document.getElementById(x).value))
        {
          input.style.background ='#DFF0D8';
          msg.innerHTML = "";
          return true;
        }
        else
        {
          input.style.background ='#F2DEDE';
          msg.innerHTML = "Debe ser una palabra descriptiva Ej.: par, paquete, caja, gramos, etc.";
          return false;
        }
    }
    
</script>
<!-- Bootstrap select js -->
<script src="<?php echo base_url() ?>assets/js/bootstrap-select.min.js"></script>