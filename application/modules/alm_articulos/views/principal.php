<script src="<?php echo base_url() ?>assets/js/jquery.min.js"></script>
<style type="text/css">
  hr{ margin-top: 5px; margin-bottom: 5px; }

  tr.group,
  tr.group:hover {
      background-color: #ddd !important;
  }

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
                                            <div class="navbar-header">
                                                <button type="button" title="Opciones de tipo de reporte" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-2" aria-expanded="false">
                                                    <span class="sr-only">Opciones de tipo de reporte</span>
                                                    <span class="icon-bar"></span>
                                                    <span class="icon-bar"></span>
                                                    <span class="icon-bar"></span>
                                                </button>
                                            </div>
                                            <div id="repTipos" class="dropdown" style="padding-top: 1%;">
                                                <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-2">
                                                    <button class="btn btn-primary dropdown-toggle" id="selectReport" type="button" data-toggle="dropdown">Elija el tipo de reporte
                                                      <span class="caret"></span>
                                                    </button>
                                                    <ul class="dropdown-menu dropdown-menu-center" role="menu" aria-labelledby="menu1">
                                                      <!-- <li role="presentation"><a style="cursor: pointer !important;" onclick="" role="menuitem" tabindex="-1">-- Predeterminado --</a></li> -->
                                                      <li role="presentation"><a style="cursor: pointer !important;" onclick="repOption(1)" role="menuitem" tabindex="-1">Reporte general</a></li>
                                                      <li role="presentation"><a style="cursor: pointer !important;" onclick="repOption(2)" role="menuitem" tabindex="-1">Reporte por departamento</a></li>
                                                      <li role="presentation"><a style="cursor: pointer !important;" onclick="repOption(3)" role="menuitem" tabindex="-1">Reporte por artículo</a></li>
                                                      <li role="presentation"><a style="cursor: pointer !important;" onclick="repOption(4)" role="menuitem" tabindex="-1">Reporte por movimientos</a></li>
                                                      <!-- <li role="presentation" class="divider"></li>
                                                      <li role="presentation"><a style="cursor: pointer !important;" onclick="ayudaXtipos()" role="menuitem" tabindex="-1">Ayuda</a></li>     -->
                                                    </ul>
                                                    <button class="btn btn-warning" onclick="ayudaXtipos()" type="submit" title="Ayuda de lista"><i class="fa fa-question fa-fw"></i></button>
                                                </div>
                                            </div>
                                        </div>
                                    </nav>
                                    <nav hidden id="selectedRep" class="navbar navbar-default">
                                        <div class="container-fluid">
                                          <div class="navbar-header">
                                              <button type="button" title="Opciones de reporte general" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-3" aria-expanded="false">
                                                  <span class="sr-only">Opciones de reporte general</span>
                                                  <span class="icon-bar"></span>
                                                  <span class="icon-bar"></span>
                                                  <span class="icon-bar"></span>
                                              </button>
                                          </div>
                                            <!-- Brand and toggle get grouped for better mobile display -->
                                          <div id="nrColumns" class="dropdown" style="padding-top: 1%;">
                                              <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-3">
                                                      <button class="btn btn-primary dropdown-toggle" id="selectNrColumns" type="button" data-toggle="dropdown">Elija la cantidad de columnas
                                                        <span class="caret"></span>
                                                      </button>
                                                      <ul class="dropdown-menu dropdown-menu-center" role="menu" aria-labelledby="menu1">
                                                        <li role="presentation"><a style="cursor: pointer !important;" onclick="selectedColumns(0)" role="menuitem" tabindex="-1">-- Predeterminado --</a></li>
                                                        <li role="presentation"><a style="cursor: pointer !important;" onclick="selectedColumns(2)" role="menuitem" tabindex="-1">2 columnas</a></li>
                                                        <li role="presentation"><a style="cursor: pointer !important;" onclick="selectedColumns(3)" role="menuitem" tabindex="-1">3 columnas</a></li>
                                                        <li role="presentation"><a style="cursor: pointer !important;" onclick="selectedColumns(4)" role="menuitem" tabindex="-1">4 columnas</a></li>
                                                        <li role="presentation"><a style="cursor: pointer !important;" onclick="selectedColumns(5)" role="menuitem" tabindex="-1">5 columnas</a></li>
                                                        <li role="presentation"><a style="cursor: pointer !important;" onclick="selectedColumns(6)" role="menuitem" tabindex="-1">6 columnas</a></li>
                                                        <li role="presentation"><a style="cursor: pointer !important;" onclick="selectedColumns(7)" role="menuitem" tabindex="-1">7 columnas</a></li>
                                                        <li role="presentation"><a style="cursor: pointer !important;" onclick="selectedColumns(8)" role="menuitem" tabindex="-1">8 columnas</a></li>
                                                        <li role="presentation" class="divider"></li>
                                                        <li role="presentation"><a style="cursor: pointer !important;" onclick="ayudaXcolumnas()" role="menuitem" tabindex="-1">Ayuda</a></li>    
                                                      </ul>
                                                      <button class="btn btn-warning" onclick="ayudaXcolumnas()" type="submit" title="Ayuda de lista"><i class="fa fa-question fa-fw"></i></button>
                                              <!-- Collect the nav links, forms, and other content for toggling -->
                                              </div><!-- /.navbar-collapse -->
                                          </div>
                                        </div><!-- /.container-fluid -->
                                    </nav>

                                    <nav id="columnsMenu" hidden class="navbar navbar-default">
                                      <div class="container-fluid">
                                        <!-- Brand and toggle get grouped for better mobile display -->
                                        <div class="navbar-header">
                                            <button type="button" title="Opciones de columnas de reporte" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#columns" aria-expanded="false">
                                                <span class="sr-only">Opciones de columnas de reporte</span>
                                                <span class="icon-bar"></span>
                                                <span class="icon-bar"></span>
                                                <span class="icon-bar"></span>
                                            </button>
                                        </div>
                                        <!-- Collect the nav links, forms, and other content for toggling -->
                                          <div id="columns" class="collapse navbar-collapse">
                                              <div class="navbar-form"  align="center">
                                                  <div class="input-group">
                                                  </div>
                                              </div>
                                              <ul class="nav navbar-nav navbar-right">
                                                  <li></li>
                                              </ul>
                                          </div>
                                      </div>
                                    </nav>

                                    <nav id="tableControl" hidden class="navbar navbar-default">
                                        <div class="container-fluid">
                                            <!-- Brand and toggle get grouped for better mobile display -->
                                            <div class="navbar-header">
                                                <button type="button" title="Opciones de Búsqueda" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-4" aria-expanded="false">
                                                    <span class="sr-only">Opciones de búsqueda</span>
                                                    <span class="icon-bar"></span>
                                                    <span class="icon-bar"></span>
                                                    <span class="icon-bar"></span>
                                                </button>
                                            </div>
                                            <!-- Collect the nav links, forms, and other content for toggling -->
                                            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-4">
                                                <div class="navbar-form navbar-left">
                                                    <div class="input-group">
                                                      <span class="input-group-addon" id="basic-addon1"><i class="fa fa-calendar"></i></span>
                                                      <input name="date" id="fecha" type="search"  class="form-control input-md" placeholder=" Búsqueda por Fechas" />
                                                      <span class="input-group-addon" id="basic-addon2"><i class="fa fa-search"></i></span>
                                                      <input name="search" id="search" type="text" class="form-control input-md" placeholder=" Búsqueda general">
                                                      <span class="input-group-addon" id="basic-addon2"><i class="fa fa-history"></i></span>
                                                      <select id="move" name="movimiento" class="selectpicker" multiple title="Clasificar por movimientos...">
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
                                            <table id="tablaReporte"  class="table table-hover table-bordered table-condensed">
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
  // $(function(){
      var base_url = '<?php echo base_url()?>';
      //opciones es un arreglo de las distintas columnas consultables en la BD en formato de objeto, {nombre_humano: "nombre_enBD"}
      var opciones = {Columnas:"", Código:"cod_articulo", Descripción:"descripcion", Entradas:"entradas", Existencia:"exist", Salidas:"salidas", 'Fecha de último movimiento':"fechaU", Unidad:"unidad", bla1:"bla2"};
      //dtOpciones es un arreglo que acopla las opciones del dataTable a cada columna, esas opciones o atributos corresponden a visibilidad, "buscabilidad" y "ordenabilidad", formato nombre_enBD:{atributos}
      var dtOpciones = {movimiento2:{"bVisible": false, "bSearchable": false, "bSortable": true}, observacion:{"bVisible": true, "bSearchable": false, "bSortable": true}, nuevo:{"bVisible": true, "bSearchable": false, "bSortable": true}, movimiento:{"bVisible": true, "bSearchable": false, "bSortable": true}, cantidad:{"bVisible": true, "bSearchable": false, "bSortable": true}, art_cod_desc:{"bVisible": false, "bSearchable": true, "bSortable": true}, fecha_desp:{"bVisible": true, "bSearchable": false, "bSortable": true}, dependen:{"bVisible": false, "bSearchable": true, "bSortable": true}, solicitud:{"bVisible": true, "bSearchable": false, "bSortable": true}, unidad:{"bVisible": true, "bSearchable": true, "bSortable": true}, cod_articulo:{"bVisible": true, "bSearchable": true, "bSortable": true}, descripcion:{"bVisible": true, "bSearchable": true, "bSortable": true}, entradas:{"bVisible": true, "bSearchable": false, "bSortable": true}, salidas:{"bVisible": true, "bSearchable": false, "bSortable": true}, fechaU:{"bVisible": true, "bSearchable": false, "bSortable": true}, exist:{"bVisible": true, "bSearchable": false, "bSortable": true}, entrada:{"bVisible": true, "bSearchable": true, "bSortable": true}, salida:{"bVisible": true, "bSearchable": true, "bSortable": true}};
      // var selects = $("div[id^='input'] > select");
      // var oTable = $('#tablaReporte').DataTable();
      var selects = $("#columns > div > .input-group > select");
      var flag = false;
      var reporteTipo = '';
      // var DTValues = ''; //variable para el estado total de la datatable
      // console.log(dtOpciones[1]);
      function addSelect(divName)//construye los select para las opciones de columnas seleccionables
      {
        var select = $("<select/>");
        // select.attr("class", "btn btn-info btn-xs");
        select.attr("class", "selectpicker form-control");
        select.attr("data-width", "fit");
        select.attr("id", divName);
        $.each(opciones, function(a, b){
          select.append($("<option/>").attr("value", b).text(a));
        });
        // select.append($("<span/>").attr("class", "caret"));
        // select.attr('class', 'btn-sm btn-info');
        console.log(select);
        // $(select).addClass("selectpicker");
        // $("#"+divName).append(select);
        $("#columns > div > .input-group").append(select);
      }

      function selectedColumns(numberOfColumns)//para reporte general
      {
        flag=false;
        reporteTipo = '';
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
          // $("#columns > div > .input-group").append('<div id="input'+i+'" class="col-lg-'+size+' col-md-'+size+' col-sm-'+size+' col-xm-'+size+'">');
          addSelect(aux);
          // $("#columns > div > .input-group").append('</div>');
        }
        // $("#columns").show();//las muestro
        $('.selectpicker').selectpicker('refresh');//sugerido por un foro, para recargar los estilocs sobre todos los selecpicker creados
        selects = $("select[id^='input']");
        // selects = $("#columns > div > .input-group > div > select");
        // selects = $("#columns > div > .input-group > select");
        console.log(selects);
        $('#columnsMenu').show();
        selects.change(function(){//para cada vez que algun select de columnas, sufra algun cambio...
            console.log('input change!');
            var validate = true;
            for (var i = 0; i < selects.length; i++)//para recorrer todos los selects, y verificar si ninguno está vacío
            {
              if(selects[i].value=='')
              {
                validate = false;
              }
            }
            if(validate)//si ninguno está vacío...
            {
              var selectedSelects = $("#columns > div > .input-group > div > select > option:selected");//selecciona las opciones seleccionadas por el usuario
              var table = $('#tablaReporte > thead tr');//selecciona las columnas de la cabecera/header de la tabla
              $(table).html('');//limpia la cabecera/header
              var columnas = [];
              for (var i = 0; i < selects.length; i++)//para construir el header de la tabla para DataTable
              {
                table.append('<th>'+$(selectedSelects[i]).text()+'</th>');
                columnas[i] = selectedSelects[i].value;//la variable columnas para cargar los nombres de las columnas en la base de datos
              }
              console.log("columnas: ");
              console.log(flag);
              console.log(columnas);
              buildDataTable(columnas);//construlle la DataTable en funcion de las columnas y las variables globales
            }
        });
      }
      function repOption(option)
      {
        $("#selectedRep").hide();
        $('#columnsMenu').hide();
        if(option==1)
        {
          console.log(option);
          $("#selectedRep").show();
        }
        else
        {
          if(option==2)
          {
            reporteDependencia();
          }
          else
          {
            if(option==3)
            {
                reporteArticuloMovimiento();
            }
            else
            {
              if(option==4)
              {
                reporteMovimiento();
              }
              else
              {
                
              }
            }
          }
        }
      }
      function reporteDependencia()//para reporte por dependencia
      {
        console.log("reporteDependencia");
        reporteTipo = "xDependencia";
        var selectedSelects = [{name:"Número de solicitud",  value:'solicitud'}, { name:"Código del articulo", value:'cod_articulo'}, {name:"Descripción", value:"descripcion"}, {name:"Unidad", value:"unidad"}, {name:"Cantidad despachada", value:"salida"}, {name:"Fecha", value:"fecha_desp"}, {name:"Departamento", value:"dependen"}];
        flag = true;
        buildTableHeader(selectedSelects);

      }
      function reporteArticuloMovimiento()//para reporte por articulo con movimientos de entrada y salida
      {
        console.log("reporteArticuloMovimiento");
        reporteTipo = "xArticulo";
        var selectedSelects = [{name:"Fecha de movimiento",  value:'fecha_desp'}, {name:"Movimiento",  value:'movimiento'}, {name:"Cantidad",  value:'cantidad'}, {name:"Estado de artículo",  value:'nuevo'}, {name:"Observación",  value:'observacion'}, {name:"Artículo",  value:'art_cod_desc'}];
        flag = true;
        buildTableHeader(selectedSelects);
      }
      function reporteMovimiento()//para reporte por movimientos de entrada y salida
      {
        console.log("reporteMovimiento");
        reporteTipo = "xMovimiento";
        var selectedSelects = [{name:"Fecha de movimiento",  value:'fecha_desp'}, {name:"Código del artículo",  value:'cod_articulo'}, {name:"Descripción", value:'descripcion'}, {name:"Cantidad",  value:'cantidad'}, {name:"Estado de artículo",  value:'nuevo'}, {name:"Observación",  value:'observacion'}, {name:"Movimiento",  value:'movimiento2'}];
        flag = true;
        buildTableHeader(selectedSelects);
      }
      function buildTableHeader(selectedColumns)//construye los titulos de las columnas de la DataTable
      {
        // $('#tablaReporte').DataTable().destroy();//destruye la DataTable
        var table = $('#tablaReporte > thead tr');
        $(table).html('');
        var columnas = [];
        for (var i = 0; i < selectedColumns.length; i++)//para construir el header de la tabla para DataTable
        {
          console.log(selectedColumns[i].name);
          console.log(selectedColumns[i].value);
          columnas[i] = selectedColumns[i].value;
          // if(dtOpciones[columnas[i]].bVisible)
          // {
            table.append('<th>'+selectedColumns[i].name+'</th>');
          // }
          // columnas.push(selectedColumns[i].value);
        }
        console.log("columnas: ");
        console.log(columnas);
        buildDataTable(columnas);
      }

      function buildDataTable(columnas)//para construir la DataTable a partir de un conjunto de columnas seleccionadas
      {
          acols = [];
          cols = [];
          notSearchable =[];
          notSortable =[];
          notVisible =[];
          numberOfColumns = columnas.length;
          console.log("tabla columnas:");
          console.log(numberOfColumns);
          for (var i = 0; i < columnas.length; i++)//aqui construlle las columnas de la datatable junto con sus atributos de busqueda, ordenamiento y/o visibilidad en interfaz
          {
            console.log(columnas[i]);
            cols.push({'name':columnas[i]});//columnas a consultar en bd
            console.log(dtOpciones[columnas[i]].bSearchable);
            if(!dtOpciones[columnas[i]].bSearchable)
            {
              notSearchable.push(i);
            }
            if(!dtOpciones[columnas[i]].bSortable)
            {
              notSortable.push(i);
            }
            if(!dtOpciones[columnas[i]].bVisible)
            {
              notVisible.push(i);
            }
            acols.push(dtOpciones[columnas[i]]);//opciones de las columnas en bd
          }
          console.log(cols);
          console.log(acols);
          $('#tablaReporte').DataTable().destroy();//destruye la DataTable
          oTable = $('#tablaReporte').DataTable({
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
                          "sLast":'<i class="glyphicon glyphicon-step-forward" title="Último"  ></i>',
                          "sFirst":'<i class="glyphicon glyphicon-step-backward" title="Primero"  ></i>'
                          }
                        },
                      "bProcessing":true,
                      "lengthChange":false,
                      "sDom": '<"top"lBp<"clear">>rt<"bottom"ip<"clear">>',
                      "info":false,
                      "buttons": ['pdfHtml5'],
                      // "stateSave":true,//trae problemas con la columna no visible
                      "bServerSide":true,
                      "pagingType":"full_numbers",
                      "sServerMethod":"GET",
                      "sAjaxSource":"<?php echo base_url();?>index.php/tablas/inventario/reportes",
                      "bDeferRender":true,
                      "fnServerData": function (sSource, aoData, fnCallback, oSettings){
                          aoData.push({"name":"fecha", "value": $('#fecha').val()}, {"name":"move", "value": $('#move').val()});//para pasar datos a la funcion que construye la tabla
                          if(flag == true)
                          {
                            aoData.push({"name":"tipoReporte", "value": reporteTipo});
                          }
                          oSettings.JqXHR = $.ajax({
                            "dataType": "json",
                            "type": "GET",
                            "url": sSource,
                            "data": aoData,
                            "success": fnCallback
                          });
                      },
                      "drawCallback": function ( settings ) {
                          if(flag == true)
                          {
                            var api = this.api();
                            var rows = api.rows( {page:'current'} ).nodes();
                            var last=null;
                            var hiddenColumn = numberOfColumns -1;
                            var colspan = numberOfColumns -1;
                            api.column( hiddenColumn, {page:'current'} ).data().each( function ( group, i )
                            {
                                if ( last !== group )
                                {
                                    $(rows).eq( i ).before(
                                        '<tr class="group"><td colspan="'+colspan+'">'+group+'</td></tr>'
                                    );
                 
                                    last = group;
                                }
                            });
                          }
                      },
                      "iDisplayLength":10,
                      "aLengthMenu":[[10,25,50,-1],[10,25,50,"ALL"]],
                      "aaSorting":[[0,"desc"]],
                      // "orderFixed": [notVisible[0], 'asc'],
                      "columns": cols,
                      "aoColumnDefs": [
                          {"searchable": false, "targets": notSearchable},
                          {"orderable": false, "targets": notSortable},
                          {"visible": false, "targets": notVisible},
                          {"orderData": [notVisible[0], 0], "targets": notVisible}
                      ]
                    });

          // DTValues = oTable.buttons.exportData();
          $('#tablaReporte').attr('style', '');
          $("#preview").show();
          $('#tableControl').show();
          if(flag==true)
          {
            $('#tablaReporte tbody').on( 'click', 'tr.group', function ()
            {
              var currentOrder = oTable.order()[0];
              if ( currentOrder[0] === numberOfColumns-1 && currentOrder[1] === 'asc' )
              {
                  oTable.order( [ numberOfColumns-1, 'desc' ] ).draw();
              }
              else
              {
                  oTable.order( [ numberOfColumns-1, 'asc' ] ).draw();
              }
            });
          }
        ///buscador del datable, externo al datatable        
          $('#search').on('keyup', function(){
            oTable.search($(this).val()).draw();
            // DTValues = oTable.buttons.exportData();
            // console.log(DTValues);
          });
        ///Filtro del datatable, para los atributos de entrada y/o salida de articulos del inventario
          $('#move').change(function(){
            oTable.ajax.reload();
            // DTValues = oTable.buttons.exportData();
            // console.log(DTValues);
          });
        ///filtro para el input de fecha, externo al datatable
          $('#fecha').change(function(){oTable.ajax.reload();});
          $('#fecha').on('click', function(){
            $('#fecha').val('');
            oTable.ajax.reload();
            // DTValues = oTable.buttons.exportData();
            // console.log(DTValues);
          });
            // console.log(DTValues);
      }

      function ayudaXtipos()
      {
        alert("aqui va una explicacion de ayuda para la explicación de tipos de reportes!");
      }

      function ayudaXcolumnas()
      {
        alert("aqui va una explicacion de ayuda para reportes genéricos!");
      }
  // }
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