<script src="<?php echo base_url() ?>assets/js/jquery.min.js"></script>
<style type="text/css">
	hr{ margin-top: 5px; margin-bottom: 5px; }

	tr.group,
	tr.group:hover {
			background-color: #ddd !important;
	}
  .alert-instruction{
    margin-top: 2%;
    background-color: #4682b4;
    border-color: #002147;
    color: #fafafa;
  }
  /*.alert-instruction + strong{
    font-size: 1em;
  }*/
  /*.alert-instruction::before{
    content: html('<i class="fa fa-info fa-2x"></i>';);
  }*/
</style>
<script>
$(document).ready(function() {
		$('#articulos').DataTable({
		});
});
		base_url = '<?php echo base_url()?>';
<?php if(!empty($alm[1])):?>
$(document).ready(function()
{
	$('#data').dataTable({
								"language": {
										"url": "<?php echo base_url() ?>assets/js/lenguaje_datatable/spanish.json"
								},
		"bProcessing": true,
					"bServerSide": true,
					"sServerMethod": "GET",
					"sAjaxSource": "<?php echo base_url() ?>tablas/inventario",
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
			{ "bVisible": false, "bSearchable": true, "bSortable": false }//la columna extra
					]
	});
});
<?php endif; ?>
//act-inv
<?php if(!empty($alm[4])):?>
$(document).ready(function()
{
	$('#act-inv').dataTable({
		"language": {
								"url": "<?php echo base_url() ?>assets/js/lenguaje_datatable/spanish.json"
		},
		"bProcessing": true,
					"bServerSide": true,
					"sServerMethod": "GET",
					"sAjaxSource": "<?php echo base_url() ?>tablas/inventario/1",
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
	});
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
										"sAjaxSource": "<?php echo base_url() ?>tablas/inventario/historial/"+art_cod,
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
<?php endif;?>

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
        
/////// Datatable para edicion e articulos por Juan Parra
<?php if(!empty($alm[10])):?>
 $(document).ready(function () {
    var editable;
    function get_cat()
    {
      return($('#cod_categoria').val());
    }
    $('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
      var target = $(e.target).attr("href"); // activated tab
      console.log(target);
      if(target==='#editArt')
      {
        if(!$.fn.DataTable.isDataTable(editable))
        {
          var columnDefs = [{
              id: "ID",
              data: "ID",
              "visible": false,
              "searchable": false
          },{
              title: "Código de Categoria",
              id: "cod_categoria",
              data: "categoria",
              type: "readonly"
                              
          },{
              title:"Categoria",
              id: "categoria",
              data: "categoriaN",
              type: "readonly"
          },{
              title: "Descripción del Artículo",
              id: "descripcion",
              data: "descripcion",
              type: "text",
              pattern:"^[a-zá-úA-Z0-9\r\n\t\f\v \"\/]+",
              errorMsg: "* Descripción invalida.",
              hoverMsg: "Descripcion del articulo",
              unique: true
              
          },{
              title: "Código",
              id: "cod_articulo",
              data: "cod_articulo",
              type: "text",
              // pattern: "^[0-9]{6,10}\-[A-Z0-9]{1,10}",
              pattern: "^(/(categoria)/)[0-9]{2,4}\-[A-Z0-9]{1,10}",
              errorMsg: "* Código invalido.",
              hoverMsg: "Ejemplo: /(categoria)/34-AFC",
              unique: true
          },{
              title: "Ubicación",
              id: "cod_ubicacion",
              data: "cod_ubicacion",
              type: "text",
              pattern: "^[0-9]*",
              errorMsg: "* Código invalido.",
              hoverMsg: "Ejemplo: 82848688",
              unique: true
          }];
          editable = $('#almacen').DataTable({
              "language": {
                  "url": "<?php echo base_url() ?>assets/js/lenguaje_datatable/spanish.json"
              },
              "aoColumns": columnDefs,
              "bProcessing": true,
               stateSave: true,
              "bDeferRender": true,
              "altEditor": true,      // Enable altEditor ****
              "buttons": [{
      //                            text: 'Añadir',
      //                            name: 'add'        // DO NOT change name
      //                        },
      //                        {
                      extend: 'selected', // Bind to Selected row
                      text: 'Editar',
                      className: 'btn btn-info',
                       name: 'edit'        // DO NOT change name
                  }
      //                        {
      //                            extend: 'selected', // Bind to Selected row
      //                            text: 'Borrar',
      //                            name: 'delete'      // DO NOT change name
      //                        }
              ],
              "select": 'single',     // enable single row selection
              "serverSide": true, //Feature control DataTables' server-side processing mode.
              "pagingType": "full_numbers", //se usa para la paginacion completa de la tabla
              "sDom": '<"row"<"col-sm-2"f><"col-sm-8"><"col-sm-2"B>>rt<"row"<"col-sm-2"l><"col-sm-10"p>>', //para mostrar las opciones donde p=paginacion,l=campos a mostrar,i=informacion
              "order": [[1, "asc"]], //para establecer la columna a ordenar por defecto y el orden en que se quiere 
              "columnDefs": [{"className": "dt-center","targets": [-1,-2,-3]}],//para centrar el texto en una columna
              "ajax": {
                  "url": "<?php echo site_url('tablas/inventario/editar') ?>",
                  "type": "GET"
                      }
              });
          
        }
      }
      else
      {
        var table = "";
      }
    });
       //Example of column definitions.
  });
 <?php endif;?>
//Fin 
</script>
<style> 
    th.dt-center, td.dt-center { text-align: center; }
</style>

<div class="mainy">
	<!-- Page title -->
	<div class="page-title">
		<!-- <h2 align="right"><i class="fa fa-file color"></i> Articulos <small>de almacen</small></h2> -->
		<h2 align="right"><img src="<?php echo base_url() ?>assets/img/alm/main.png" class="img-rounded" alt="bordes redondeados" width="45" height="45"> Artículos <small>de almacén</small></h2>
		<!-- <hr /> -->
	</div>
	<!-- Page title -->
	<div class="row">
		<div class="col-lg-12 col-nd-12 col-sm-12">
			<div class="full-width">
					<!-- <div class="awidget-head">
								<h3>Operaciones sobre inventario de almacén</h3>
								<button id="mail" align="right">enviar retroalimentaci&oacute;n</button>
					</div> -->
					<!-- <div class="space-5xp"></div>
					<hr> -->
					<div class="panel" style="border-radius: 10px;">
            <div class="panel-heading">
                <h3>Operaciones sobre inventario de almacén</h3>
            </div>
						<div class="panel-body">
								<?php if($this->session->flashdata('add_articulos') == 'error') : ?>
									<div class="alert alert-danger" style="text-align: center">Ocurrió un problema agregando art&iacute;culos desde el archivo</div>
								<?php endif ?>
								<?php if($this->session->flashdata('add_articulos') == 'success') : ?>
									<div class="alert alert-success" style="text-align: center">Art&iacute;culos agregados exitosamente</div>
								<?php endif ?>
						<div class="awidget-body">
								<ul id="myTab" class="nav nav-tabs nav-justified">
									<?php if(!empty($alm[1])):?><li class="active"><a href="#home" data-toggle="tab">Cat&aacute;logo</a></li><?php endif;?>
									<?php if(!empty($alm[4])):?><li><a href="#active" data-toggle="tab">Inventario</a></li><?php endif;?>
                  <?php if(!empty($alm[10])):?><li><a href="#editArt" data-toggle="tab">Editar Articulo</a></li><?php endif;?>
									<?php if(!empty($alm[6])):?><li><a href="#add" data-toggle="tab">Agregar articulos</a></li><?php endif;?>
									<?php if(!empty($alm[5])):?><li><a href="#rep" data-toggle="tab">Reportes</a></li><?php endif;?>
									<?php if(!empty($alm[8])||!empty($alm[7])):?><li><a href="#close" data-toggle="tab">Cierre</a></li><?php endif;?>
								</ul>
								<div class="space-5px"></div>
							<div id="myTabContent" class="tab-content">
										<?php if(!empty($alm[1])):?>
										<div id="home" class="tab-pane fade in active">
                      <!-- <a class="button" href="http://compras.snc.gob.ve/aplicacion/catalogo/"><img src="<?php echo base_url() ?>assets/img/logoUNSPSC.png" class="img-rounded" alt="bordes redondeados" width="45" height="45">Catálogo de productos y servicios de las naciones unidas</a> -->
                      <button class="btn btn-info callUN"><img src="<?php echo base_url() ?>assets/img/logoUNSPSC.png" width="45" height="45">Catálogo de productos y servicios de las naciones unidas</button>
                      <?php if(!empty($alm[6])):?>
                      <div hidden id="CatFile" class="form-group">
                          <label class="control-label" for="excelCAT">Insertar archivo de Excel con categorias(para usar solo una vez):</label>
                          <div class="input-group col-md-5">
                              <input id="excelCAT" type="file" name="userfile">
                          </div>
                      </div>
                      <?php endif;?>
                      <div class="space-5px"></div>
											<table id="data" class="table table-hover table-bordered">
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
											<table id="act-inv" class="table table-hover table-bordered">
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
                  <?php if(!empty($alm[10])):?>
                    <div id="editArt" class="tab-pane fade">

                      <div hidden id="ArtFile" class="form-group">
                          <label class="control-label" for="excelART">Insertar archivo de Excel para edicion de articulos(para usar solo una vez):</label>
                          <div class="input-group col-md-5">
                              <input id="excelART" type="file" name="userfile">
                          </div>
                      </div>
<!-- Edicion de codigo de articulos por JUAN PARRA-->
                       <div class="table-responsive">
                    <div class="col-lg-12 col-md-12 col-sm-12">
                        <table id="almacen" class="table table-hover table-bordered table-condensed" align="center" width="100%">
                            <thead>
                                <tr class="active">
                                    <th>ID</th>
                                    <th>Descripción</th>
                                    <th>Código</th>
                                    <th>Código de Categoria</th>
                                    <th>Categoria</th>
                                    <th>Ubicación</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                </div> 
                    </div>
                  <?php endif;?>
<!-- FIN DE Edicion de codigo de articulos por JUAN PARRA-->
<!-- Inserción de Articulos al sistema -->
                    <?php if(!empty($alm[6])):?>
                    <div id="add" class="tab-pane fade">
                                    <div class="awidget-body">
                                      <?php if(!empty($alm[6])):?> <!-- agregar articulos de forma individual -->
                                      <br>
                                      <button class="btn btn-info callUN"><img src="<?php echo base_url() ?>assets/img/logoUNSPSC.png" width="45" height="45">Catálogo de productos y servicios de las naciones unidas</button>
                                      <br><br>
                                      <form id="addArticulos" role="form">
                                      <label class="control-label" for="addArtcategoria">Categoría del artículo:</label>
                                        <input hidden id="addArtcategoria" class="form-control input-sm" name="categoria" type="text">
                                        <!-- <select hidden id="addArtcategoria" class="form-control input-sm"  name="categoria" tabindex="-1">
                                          <option></option>
                                        </select> -->
                                      </form>
                                      <div id="dynamicForm"></div>
                                      <!--<div class="alert alert-info" style="text-align: center">
                                          Escriba palabras claves de la descripci&oacute;n del art&iacute;culo &oacute; el c&oacute;digo.
                                      </div>
                                      <div class="alert alert-warning" style="text-align: center">
                                        S&iacute; el art&iacute;culo no aparece &oacute; no existe, deber&aacute; agregarlo manualmente.
                                      </div>
                                      <div id="error" class="alert alert-danger" style="text-align: center">
                                      </div>
                                      <div id="non_refreshForm">
                                        <form id="ACqueryAdmin" class="input-group form"> -->
                                           <!-- <label for="autocompleteAdminArt" id="articulos_label">Articulo</label> -->
                                           <!--<input id="autocompleteAdminArt" type="search" name="articulos" class="form-control" placeholder="Descripci&oacute;n del art&iacute;culo, &oacute; codigo s&iacute; ex&iacute;ste">
                                           <span class="input-group-btn">
                                              <button id="check_inv" type="button" class="btn btn-info">
                                                <i class="fa fa-plus"></i>
                                              </button>
                                            </span>
                                        </form>
                                      </div> -->
                                      <?php endif;?>
                                      <!-- <button id="add_fromFile" class="btn-lg btn-info glyphicon glyphicon-save-file">Agregar desde archivo</button> -->
                                      <?php if(!empty($alm[6])):?>
                                      <!-- Subida de archivo de excel para agregar articulos a inventario -->
                                        <div hidden id="add_file" class="form-group" align="center">
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
                                      <!--<div id="resultado"> aqui construllo lo resultante de la busqueda del articulo, para su adicion a inventario
                                      </div>-->
                                    </div>
                    </div>
                  <?php endif;?>
<!-- Fin de Inserción de Articulos al sistema -->
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
                                                                                                                                                                                                        <div class="navbar-form navbar-left">
                                                                                                                                                                                                                    <div class="btn-group" align="center">
                                                                                                                                                                                                                        <!--<div class="col-md-4">-->
																												<button class="btn btn-primary dropdown-toggle" id="selectReport" type="button" data-toggle="dropdown">Elija el tipo de reporte
																													<span class="caret"></span>
																												</button>
																												<ul class="dropdown-menu dropdown-menu-center" role="menu" aria-labelledby="menu1">
																													<li role="presentation"><a style="cursor: pointer !important;" onclick="repOption(1)" role="menuitem" tabindex="-1">Reporte general</a></li>
																													<!--<li role="presentation"><a style="cursor: pointer !important;" onclick="imprimirPDF()" role="menuitem" tabindex="-1">PRINTABLE!</a></li>-->
																													<li role="presentation"><a style="cursor: pointer !important;" onclick="repOption(2)" role="menuitem" tabindex="-1">Reporte por departamento</a></li>
																													<li role="presentation"><a style="cursor: pointer !important;" onclick="repOption(3)" role="menuitem" tabindex="-1">Reporte por artículo</a></li>
																													<li role="presentation"><a style="cursor: pointer !important;" onclick="repOption(4)" role="menuitem" tabindex="-1">Reporte por movimientos</a></li>
																													<!-- <li role="presentation" class="divider"></li>
																													<li role="presentation"><a style="cursor: pointer !important;" onclick="ayudaXtipos()" role="menuitem" tabindex="-1">Ayuda</a></li>     -->
																												</ul>
																												<button class="btn btn-warning" onclick="ayudaXtipos()" type="button" title="Ayuda de lista"><i class="fa fa-question fa-fw"></i></button>
                                                                                                                                                                                                        </div>
                                                                                                                                                                                                        <div class="btn-group" align="center">
                                                                                                                                                                                                    <!--<div id="nrColumns" class="dropdown col-md-5" style="padding-top: 1%;display: none;" align="center">-->
																									<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-3">
                                                                                                                                                                                                        <button style="display:none;" class="btn btn-primary dropdown-toggle" id="selectNrColumns" type="button" data-toggle="dropdown">Elija la cantidad de columnas
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
																														<!--<li role="presentation"><a style="cursor: pointer !important;" onclick="selectedColumns(8)" role="menuitem" tabindex="-1">8 columnas</a></li>-->
																														<li role="presentation" class="divider"></li>
																														<li role="presentation"><a style="cursor: pointer !important;" onclick="ayudaXcolumnas()" role="menuitem" tabindex="-1">Ayuda</a></li>    
																													</ul>
                                                                      <button class="btn btn-warning" onclick="ayudaXcolumnas()" id="ayuda_lista" style="display: none" type="submit" title="Ayuda de lista"><i class="fa fa-question fa-fw"></i></button>
																									<!-- Collect the nav links, forms, and other content for toggling -->
																									<!--</div> /.navbar-collapse -->
																							</div>
																								</div>
                                                                                                                                                                                                        </div>
                                                                                                                                                                                                </div>
                                                                                                                                                                                                </div>
																						</div>
																				</nav>
                                                                                                                                                                	
                                                                                                                                                                <nav hidden id="selectedRep" class="navbar navbar-default">
																						<div class="container-fluid">
																							<div class="navbar-header">
                                                                                                            <button hidden type="button" id="opt" title="Opciones de reporte general" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-3" aria-expanded="false">
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
																														<!--<li role="presentation"><a style="cursor: pointer !important;" onclick="selectedColumns(8)" role="menuitem" tabindex="-1">8 columnas</a></li>-->
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
																													<input name="date" readonly id="fecha" type="text"  class="form-control input-md" placeholder=" Búsqueda por Fechas" />
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
                                              <!-- <form id="print" class="form-horizontal" action="<?php echo base_url() ?>inventario/imprimir" method="post"> -->
                                              <!-- <form class="form-horizontal" action="<?php echo base_url() ?>inventario/imprimir" method="post" target="_blank"> -->
                                                  <!-- <input type="hidden" name="busca" id="busca"> -->
                                                  <!-- <input type="hidden" name="colum" id="columna"> -->
                                                  <button class="btn btn-danger btn-sm pull-right" onclick="imprimirPDF();" type="button" title="Crear PDF"><i class="fa fa-file-pdf-o fa-2x"></i></button>
                                              <!-- </form> -->
                                              <br>
                                              <br>
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
										<?php if(!empty($alm[7]) || !empty($alm[8])):?><!-- Permiso de insercion de Reporte de existencia física -->
										<div id="close" class="tab-pane fade">
												<div class="alert alert-instruction" style="text-align: center">
													<i class="fa fa-info-circle fa-2x pull-left"></i><strong class="h5"> Para realizar el cierre de inventario, debe llenar un archivo del inventario fisico con el siguiente formato...</strong>
												</div>
									<!-- formato para el archivo del cierre de inventario -->
												<a class="btn btn-sm btn-info" href="<?php echo base_url() ?>inventario/cierre/formato">Descargar formato de archivo...</a>
									<!-- fin del formato -->
                      <br>
                      <br>
                      <span class="color"><?php //print_r($RepInvFisico);?></span>
                    <!-- <?php// if($RepInvFisico):?> -->
                        <?php if (!empty($RepInvFisico['completed']) && ($RepInvFisico['completed']=='ADJUSTED' || $RepInvFisico['completed']=='NOADJUSTRQ')):?>
                            <div class="alert alert-warning" style="text-align: center;margin-top:10%;">
                              <i class="fa fa-info-circle fa-2x pull-left"></i><strong class="h5">El procedimiento de ajustes necesarios, sobre las cantidades del sistema, ya fué realizado (en los casos necesarios).</strong>
                            </div>
                            <?php if(!empty($alm[8])):?>
                              <button id="continueClosure" class="btn btn-lg btn-info" >Continuar el cierre</button>
                            <?php endif?>
                        <?php else:?>
                          <?php if(!empty($RepInvFisico['completed']) && $RepInvFisico['completed']=='BEGINING'):?>
                              <div class="alert alert-success" style="text-align: center">
                                <i class="fa fa-info-circle fa-2x pull-left"></i><strong class="h5">El proceso de cierre de año fiscal, ha sido habilitado.</strong>
                              </div>
                              <?php if(!empty($alm[7])):?>
                              <div id="RepInvFisico">
                                <div class="alert alert-instruction" style="text-align: center">
                                  <i class="fa fa-info-circle fa-2x pull-left"></i><strong class="h5">una vez llenado las cantidades en el archivo suministrado, debe insertarlo en el siguiente recuadro...</strong>
                                </div>
                          <!-- Subida de archivo de excel para cierre de inventario-->
                                <div class="form-group">
                                    <label class="control-label" for="excel">Insertar archivo de Excel:</label>
                                    <div class="input-group col-md-5">
                                        <input id="excel" type="file" name="userfile">
                                    </div>
                                </div>
                              </div>
                              <?php endif;?>
                              <?php if(!empty($alm[8])):?>
                                <div class="alert alert-warning" style="text-align: center;margin-top:10%;">
                                  <i class="fa fa-info-circle fa-2x pull-left"></i><strong class="h5">Las Cantidades en existencia física de inventario todavia no han sido reportadas.(solo el jefe de almacen puede reportar existencia física)</strong>
                                </div>
                              <?php endif?>
                          <?php else:?>
                            <?php if(!empty($RepInvFisico['completed']) && $RepInvFisico['completed']=='REPORTED'):?>
                                <div class="alert alert-warning" style="text-align: center;margin-top:10%;">
                                  <i class="fa fa-info-circle fa-2x pull-left"></i><strong class="h5">Las cantidades existentes en inventario físico ya fueron ingresadas al sistema.</strong>
                                </div>

                                <?php if(!empty($alm[8])):?>
                                  <button id="incongruencias" class="btn btn-lg btn-warning" >Revisión de incongruencias</button>
                                  <div id="divinco" hidden>
                                    <br>
                                    <div class="responsive-table">
                                        <table id="incongruityTable"  class="table table-hover table-bordered table-condensed">
                                            <thead>
                                                <tr class="active" ><th></th></tr>
                                            </thead>
                                            <tbody>
                                            </tbody>
                                            <tfoot>
                                            </tfoot>
                                        </table>
                                    </div>
                                  </div>
                                <?php endif?>

                            <?php else:?>
                              <?php if(!empty($RepInvFisico['completed']) && $RepInvFisico['completed']=='BACKUP'):?>
                                  <div class="alert alert-warning" style="text-align: center;margin-top:10%;">
                                    <i class="fa fa-info-circle fa-2x pull-left"></i><strong class="h5">Un respaldo de la Base de datos, ya ha sido guardada en el servidor, todavía faltan procesos en el cierre</strong>
                                  </div>
                                  <?php if(!empty($alm[8])):?>
                                    <button id="incongruencias" class="btn btn-lg btn-warning" >Revisión de incongruencias</button>
                                    <div id="divinco" hidden>
                                      <br>
                                      <div class="responsive-table">
                                          <table id="incongruityTable"  class="table table-hover table-bordered table-condensed">
                                              <thead>
                                                  <tr class="active" ><th></th></tr>
                                              </thead>
                                              <tbody>
                                              </tbody>
                                              <tfoot>
                                              </tfoot>
                                          </table>
                                      </div>
                                    </div>
                                  <?php endif?>
                              <?php  else:?>
                                <?php if(!empty($RepInvFisico['completed']) && $RepInvFisico['completed']=='ACTAS'):?>
                                    <div class="alert alert-warning" style="text-align: center;margin-top:10%;">
                                      <i class="fa fa-info-circle fa-2x pull-left"></i><strong class="h5">Ya fué generado las actas del cierre de inventario</strong>
                                    </div>
                                    <?php if(!empty($alm[8])):?>
                                      <button id="showLastActa" class="btn btn-lg btn-info" >Ver Actas</button>
                                    <?php endif?>
                                <?php else:?>
                                    <div class="alert alert-warning" style="text-align: center;margin-top:10%;">
                                      <i class="fa fa-info-circle fa-2x pull-left"></i><strong class="h5">No se ha habilitado el sistema, para realizar el cierre de año fiscal.</strong>
                                    </div>
                                    <?php if(!empty($alm[8])):?>
                                      <button id="showLastActa" class="btn btn-lg btn-info" >Ver últimas actas generadas</button>
                                    <?php endif;?>
                                <?php endif;?>
                              <?php  endif;?>
                            <?php endif;?>
                          <?php endif;?>
                        <?php endif;?>


                    <!-- <?php// else:?> -->



                    <!-- <?php// endif?> -->



                    </div>
                  <?php endif;?>
              </div>
            
            </div> <!-- end awidget-body -->
              
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
//////para validar la justificacion de la tabla de incongruencias
      var validateJustificate = function(x)
      {
        console.log(this);
        console.log($('#'+x).length);
        var input = $('#'+x);
        return false;
      }
      // window.onbeforeunload = function()
      // {
      //   // 'usuario/cerrar-session';
      // }
      // window.onbeforeunload = function()
      // {
      //   console.log('wtf!!!');
      //   // console.log(event.target);
      //   log_out();
      //     //if you return anything but null, it will warn the user.
      //     //optionally you can return a string which most browsers show to the user as the warning message.
      //   return true;
      // }
      // function log_out()
      // {
      //   console.log('log_out');
      //   window.location = ('usuario/cerrar-session');
      //   console.log('log_out done!');
      // }
        // $(window).bind("beforeunload", function(){
          // window.location = ('usuario/cerrar-session');
          // return true;
        // });
//////FIN de para validar la justificacion de la tabla de incongruencias
<?php if(!empty($alm[1])):?>
///////Funciones de la pestana de catalogo
      $(function(){
        $('.callUN').on('click', function(){
          var iframe = $("<iframe/>");//construyo un iframe para mostrar la pagina del catalogo de las naciones unidas
          // var link = 'http://compras.snc.gob.ve/aplicacion/catalogo/';
          var link = 'http://200.57.3.89/PyS/catPyS.aspx';
          iframe.attr('src', link);
          iframe.attr("width", "100%");
          iframe.attr("height", "100%");
          // iframe.html(data);
          var Modal = buildModal('reporte', 'Catálogo de las naciones unidas', iframe, '', 'lg', '500');
        });
        var doc = $(this);
        var bliss = $('div#navbar.navbar-collapse.collapse');
    /////para captura de multiples teclas
        var key = {};
        doc.keydown(function(event){
          key[event.which] = true;
        });
        doc.keyup(function(event){
          delete key[event.which];
        });
    /////Fin de para captura de multiples teclas
        bliss.click(function(){
          // console.log();
          if(key[77] && key[81])//teclas "q" y "m"
          {
            if($('#home.active').length)
            {
              $('#CatFile').toggle();
            }
            if($('#editArt.active').length)
            {
              $('#ArtFile').toggle();
              // console.log("here!");
            }
            if($('#add.active').length)
            {
              $('#add_file').toggle();
            }
            // console.log($('#home').attr('class'));
            // $('#CatFile').toggle();
          }
        });

      });
///////Fin de Funciones de la pestana de catalogo
<?php endif;?>
<?php if(!empty($alm[5])):?>
///////Funciones para reportes de la pestana reportes
	// $(function(){
			var base_url = '<?php echo base_url()?>';
			var opciones = {Columnas:"",
                      Código:"cod_articulo",
                      Descripción:"descripcion",
                      Entradas:"entradas",
                      Existencia:"exist",
                      'Partida presupuestaria': "partida_presupuestaria",
                      Salidas:"salidas",
                      Ubicación:"cod_ubicacion",
                      'Fecha de último movimiento':"fechaU",
                      Unidad:"unidad"};
			var dtOpciones = {movimiento2:{"bVisible": false, "bSearchable": false, "bSortable": true}, 
                        observacion:{"bVisible": true, "bSearchable": false, "bSortable": true},
                        nuevo:{"bVisible": true, "bSearchable": false, "bSortable": true},
                        movimiento:{"bVisible": true, "bSearchable": false, "bSortable": true},
                        cantidad:{"bVisible": true, "bSearchable": false, "bSortable": true},
                        art_cod_desc:{"bVisible": false, "bSearchable": true, "bSortable": true},
                        fecha_desp:{"bVisible": true, "bSearchable": false, "bSortable": true},
                        dependen:{"bVisible": false, "bSearchable": true, "bSortable": true},
                        solicitud:{"bVisible": true, "bSearchable": false, "bSortable": true},
                        unidad:{"bVisible": true, "bSearchable": true, "bSortable": true},
                        cod_articulo:{"bVisible": true, "bSearchable": true, "bSortable": true},
                        descripcion:{"bVisible": true, "bSearchable": true, "bSortable": true},
                        entradas:{"bVisible": true, "bSearchable": false, "bSortable": true},
                        salidas:{"bVisible": true, "bSearchable": false, "bSortable": true},
                        fechaU:{"bVisible": true, "bSearchable": false, "bSortable": true},
                        exist:{"bVisible": true, "bSearchable": false, "bSortable": true},
                        entrada:{"bVisible": true, "bSearchable": true, "bSortable": true},
                        salida:{"bVisible": true, "bSearchable": true, "bSortable": true},
                        cod_ubicacion:{"bVisible": true, "bSearchable": true, "bSortable": true},
                        partida_presupuestaria:{"bVisible": true, "bSearchable": true, "bSortable": true}};
			var selects = $("#columns > div > .input-group > select");
			var flag = false;
			var reporteTipo = '';
			var DataTableState = []; //variable para el estado total de la datatable
                        var nombres=[];//variable para nombres de columnas para el pdf
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
							stopTable();
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
							BuildDTable(columnas);//construlle la DataTable en funcion de las columnas y las variables globales
						}
				});
			}
			function repOption(option)
			{
				$("#selectNrColumns").hide();
                                $("#ayuda_lista").hide();
				$('#columnsMenu').hide();
				if(option==1)
				{
					console.log(option);
					$("#selectNrColumns").show();
                                        $("#ayuda_lista").show();
				}
				else
				{
					stopTable();
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
/////////para vaciar la tabla
			function stopTable()
			{
						$('#tablaReporte').DataTable().clear();
						$('#tablaReporte').DataTable().destroy();
			}
/////////FIN de para vaciar la tabla
			function reporteDependencia()//para reporte por dependencia
			{
				console.log("reporteDependencia");
				reporteTipo = "xDependencia";
				var selectedSelects = [{name:"Solicitud",  value:'solicitud'}, { name:"Código", value:'cod_articulo'}, {name:"Artículo", value:"descripcion"}, {name:"Unidad", value:"unidad"}, {name:"Despachados", value:"salida"}, {name:"Fecha", value:"fecha_desp"}, {name:"Departamento", value:"dependen"}];
				flag = true;
				buildTableHeader(selectedSelects);
			}
			function reporteArticuloMovimiento()//para reporte por articulo con movimientos de entrada y salida
			{
				console.log("reporteArticuloMovimiento");
				reporteTipo = "xArticulo";
				var selectedSelects = [{name:"Fecha",  value:'fecha_desp'}, {name:"Movimiento",  value:'movimiento'}, {name:"Cantidad",  value:'cantidad'}, {name:"Estado",  value:'nuevo'}, {name:"Observación",  value:'observacion'}, {name:"Artículo",  value:'art_cod_desc'}];
				flag = true;
				buildTableHeader(selectedSelects);
			}
			function reporteMovimiento()//para reporte por movimientos de entrada y salida
			{
				console.log("reporteMovimiento");
				reporteTipo = "xMovimiento";
				var selectedSelects = [{name:"Fecha",  value:'fecha_desp'}, {name:"Código",  value:'cod_articulo'}, {name:"Artículo", value:'descripcion'}, {name:"Cantidad",  value:'cantidad'}, {name:"Estado",  value:'nuevo'}, {name:"Observación",  value:'observacion'}, {name:"Movimiento",  value:'movimiento2'}];
				flag = true;
				buildTableHeader(selectedSelects);
			}
			function buildTableHeader(selectedColumns)//construye los titulos de las columnas de la DataTable
			{
						// stopTable();
				console.log(selectedColumns);
				var table = $('#tablaReporte > thead > tr');
				$('#tablaReporte > tbody').html('');
				$('#tablaReporte > thead > tr').html('');
				table.html('');
				console.log('LA TABLA antes: '+table.html());
				var columnas = [];
        nombres = [];
				for (var i = 0; i < selectedColumns.length; i++)//para construir el header de la tabla para DataTable
				{
					// console.log(selectedColumns[i].name);
					// console.log(selectedColumns[i].value);
					columnas[i] = selectedColumns[i].value;
					nombres[i] = selectedColumns[i].name;
						table.append('<th>'+selectedColumns[i].name+'</th>');
					// }
					// columnas.push(selectedColumns[i].value);
				}
				console.log('LA TABLA despues: '+table.html());
				// console.log("columnas: ");
				// console.log(columnas);
				BuildDTable(columnas);
			}

			function BuildDTable(columnas)//para construir la DataTable a partir de un conjunto de columnas seleccionadas
			{
				console.log('columnas: '+columnas);
					pdfcols = [];
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
						cols.push({'sName':columnas[i]});//columnas a consultar en bd
            //variable para el pdf
            pdfcols.push({'sName':columnas[i], 'column':nombres[i]});
						// console.log(dtOpciones[columnas[i]].bSearchable);
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
					// $('#tablaReporte').DataTable().destroy();//destruye la DataTable
						// stopTable();
					// setTimeout(function(){
						if(!$.fn.DataTable.fnIsDataTable( "#tablaReporte" ))
						{
							console.log("flag: "+flag);
							console.log("reporteTipo: "+reporteTipo);
							console.log("numberOfColumns:"+numberOfColumns);
                                                        console.log("notSearchable: "+notSearchable);
							console.log("notSortable: "+notSortable);
							console.log("notVisible: "+notVisible);
							console.log($('#tablaReporte > thead tr').html());
              var DTstyle = {
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
                              };
								oTable = $('#tablaReporte').DataTable({
														"oLanguage":DTstyle,
														"bProcessing":true,
														"lengthChange":false,
														"sDom": '<"top"lp<"clear">>rt<"bottom"ip<"clear">>',
														"info":false,
  													// "buttons": ['pdfHtml5'],
														// "stateSave":true,//trae problemas con la columna no visible
														"bServerSide":true,
														"pagingType":"full_numbers",
														"sServerMethod":"GET",
														"sAjaxSource":"<?php echo base_url();?>tablas/inventario/reportes",
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
																							'<tr class="group"><td colspan="'+colspan+'" style="cursor: pointer !important;">'+group+'</td></tr>'
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
						}

						$('#tablaReporte').on('draw.dt', function(){
							// console.log('BOOOOOOO!!!!!');
              // console.log(oTable.search());
							DataTableState = {'fecha': $('#fecha').val(), 'move': $('#move').val(), 'tipo': reporteTipo, 'columnas': pdfcols, 'noBuscables': notSearchable, 'noOrdenables': notSortable, 'noVisibles': notVisible, 'orderState': oTable.order()};
							$("#columna").val(JSON.stringify(DataTableState));//Se hace de esta forma para pasarlo por un input encapsulado
              $("#busca").val($('#search').val());
            });
					// }, 400);
			}
      $(function(){

  				$('#fecha').on('apply.daterangepicker', function(ev, picker){
  					oTable.ajax.reload();
  				});

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
  			///buscador del datable, externo al datatable
  				$('#search').on('keyup', function(){
  					oTable.search($(this).val()).draw();
  				});
  			///Filtro del datatable, para los atributos de entrada y/o salida de articulos del inventario
  				$('#move').change(function(){
  					oTable.ajax.reload();
  				});
  			///filtro para el input de fecha, externo al datatable
  				
  				$('#fecha').on('click', function(){
  					$('#fecha').val('');
  					oTable.ajax.reload();
  				});
      });
					// console.log(DTValues);
			function imprimirPDF()//para imprimir en un archivo de pdf basado en lo mostrado por la DataTable
			{
        console.log("IMPRIMEEEEEE!!!!!!!");
        var array = {"columnas": JSON.stringify(DataTableState), "search": $('#search').val()};
        var uri = $.param(array, true);
        var link= "<?php echo base_url();?>inventario/imprimir?"+uri;
        var iframe = $("<iframe/>");//construyo un iframe para mostrar el pdf guenerado por el sistema
        iframe.attr('src', link);
        iframe.attr("width", "100%");
        iframe.attr("height", "100%");
        // iframe.html(data);
        var Modal = buildModal('reporte', 'Reporte', iframe, '', 'lg', 768);
			}
			function ayudaXtipos()
			{
        var table = $('<table class="table table-hover table-striped table-bordered table-condensed"/>');
        var tableBody = $('<tbody/>');
        table.append(tableBody);
        var row1 = $('<tr/>');
        row1.append('<td><strong>Reporte general:</strong></td>');
        row1.append('<td><p>Permite la realizacion de un reporte a partir de una tabla, donde cada columna es elegida por el usuario</p></td>');

        var row2 = $('<tr/>');
        row2.append('<td><strong>Reporte por departamento:</strong></td>');
        row2.append('<td>Genera un reporte a partir de una tabla de consumo de artículos de cada departamento de la facultad</td>');

        var row3 = $('<tr/>');
        row3.append('<td><strong>Reporte por artículo:</strong></td>');
        row3.append('<td>Permite consultar el estado del inventario clasificado por cada artículo registrado en el sistema</td>');

        var row4 = $('<tr/>');
        row4.append('<td><strong>Reporte por movimientos:</strong></td>');
        row4.append('<td>Genera una tabla de movimientos de entradas y salidas de inventario, en base a solicitudes completadas en el sistema, y reabastecimiento del mismo</td>');

        tableBody.append(row1);
        tableBody.append(row2);
        tableBody.append(row3);
        tableBody.append(row4);

        buildModal('help', 'Tipos de Reportes', table);
			}

			function ayudaXcolumnas()
			{
        var table = $('<table class="table table-hover table-striped table-bordered table-condensed"/>');
        var tableBody = $('<tbody/>');
        table.append(tableBody);
        var row1 = $('<tr/>');
        row1.append('<td><strong>Primer paso:</strong></td>');
        row1.append('<td><p>Elije la cantidad de columnas que desea en el reporte</p></td>');
        var row2 = $('<tr/>');
        row2.append('<td><strong>Segundo paso:</strong></td>');
        row2.append('<td><p>Seleccione entre las opciones, las columnas que desea que aparezcan en el reporte</p></td>');

        tableBody.append(row1);
        tableBody.append(row2);

        buildModal('help', 'Columnas del Reporte', table);
			}
	// }
///////FIN de funciones para reportes de la pestana reportes
<?php endif; ?>
///////Edicion de codigo de articulos por JUAN PARRA

///////FIN de Edicion de codigo de articulos por JUAN PARRA
    $(function(){
    <?php if(!empty($alm[6])):?>
///////Para la adición de articulos al sistema, desde una archivo
			$.ajaxSetup({ cache:false });
			// console.log('<?php echo form_open_multipart("alm_articulos/inv_cierre");?>');
			$("#New_inventario").fileinput({//para ingresar nuevo inventario al sistema desde un archivo de excel, independiente de que exista los codigos o no
					language:'es',
					showCaption: false,
					showUpload: true,
					showRemove: false,
					autoReplace: true,
					maxFileCount: 1,
					previewFileType: "text",
					uploadUrl: "<?php echo base_url() ?>inventario/insertar/fromExcelFile",
					browseLabel: " Agregar desde archivo...",
					browseIcon: '<i class="glyphicon glyphicon-file"></i>'
			});
			$("#New_inventario").on('fileuploaded', function(event, data, previewId, index){//evento de subida de archivo
        var add_file = $("#add_file");
        var loadingIMG = $("<img>", {"class": "img-rounded", "style":"margin-left:15%;margin-top:15%;margin-bottom:15%;width:15%"});
        loadingIMG.attr('src', '<?php echo base_url() ?>assets/img/Loaders/gears.svg');
        add_file.html(loadingIMG);
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

            var title = "Art&iacute;culos repetidos:  <span class='badge badge-info'>"+data.response.length+"</span>";
            buildModal('log', title, errorlog);
					}
				}
				else
				{
          var title = "Art&iacute;culos repetidos:  <span class='badge badge-info'>"+data.response.length+"</span>";
          buildModal('log', title, errorlog);
				}

			});
///////FIN de Para la adición de articulos al sistema, desde una archivo

///////Proceso de adición de articulos a inventario
      //url: "<?php echo base_url() ?>inventario/articulo/agregar"
      var formArt = $('#addArticulos');
      // $("#addArtcategoria").select2({theme: "bootstrap", placeholder: "- - SELECCIONE - -", allowClear: true});
      var selectCAT = $("#addArtcategoria").select2({
          placeholder:"Indique la categoría del articulo que va a insertar (basado en el catálogo de las naciones unidas)",
          minimumInputLength: 1,
          maximumSelectionSize: 10,
          allowClear: true,
          id: function(e){
            // return({ cod_categoria: e.cod_categoria, nombre: e.nombre});
            // return(e.cod_categoria);
            return(e.cod_categoria+' '+e.nombre);
          },
          ajax: {
            url: '<?php echo base_url() ?>inventario/articulo/categorias',
            dataType: 'json',
            //http://select2.github.io/select2/
            quietMillis: 250,
            data: function(term, page){
              // console.log("data "+term);
              // console.log("data "+page);
              return { 
                q: term,
                page: page
               };
               // return {
               //  q: term
               // };
            },
            results: function(data, page){
              // console.log("results ");
              // console.log(data);
              var newCat = { ID: "0", TIME: "0", cod_categoria: "0", descripcion: "", nombre: "Agregar Categoría nueva", cod_segmento: "0", segmento: "RECUERDE USAR EL CATALOGO DE LAS NACIONES UNIDAS COMO REFERENCIA", cod_familia: "0", familia: "VISITE EL CATALOGO EN LA PESTAÑA 'catálogo'" }
              data.push(newCat);
              // console.log(data);
              // console.log(data[0]);
              // console.log(page);

              var plus = (page * 30) < data.total_count;
              return { results: data, more: plus };
              // return { results: data, page: page };
            }
            // cache: true
          },
          initSelection: function(element, callback){
            var id = $(element).val();
            // console.log('init!');
            if(id !== "")
            {
              // var split = id.split(/^<strong>/);
              // var split = id.split(' ');
              // for (var i = split.length - 1; i >= 0; i--)
              // {
              //   aux.push(split[i]);
              // }
              var aux = [];
              aux.push(id.slice(id.indexOf(' '), id.length));
              aux.push(id.slice(0, id.indexOf(' ')));
              // console.log(aux);
              var data = {cod_categoria: aux[1], nombre: aux[0]};
              callback(data);
              // console.log('selected...!');
            }
          },
          formatResult: function(object, container, query){
            // console.log('formatResult');
            // console.log(object);
            textpattern = query.term.toUpperCase();
            pattern = query.term;
            if(object.nombre.search(textpattern) !== -1 || object.cod_categoria.search(pattern) !== -1 || object.cod_segmento.search(pattern) !== -1 || object.cod_familia.search(pattern) !== -1 || object.familia.search(textpattern) !== -1 || object.segmento.search(textpattern) !== -1)
            {
              //parrafo
              return('<div><strong> '+object.cod_categoria+'</strong> '+object.nombre+' <p style="font-size:10px"><strong>[Seg.|'+object.cod_segmento+'|'+object.segmento+'| Fam.|'+object.cod_familia+'|'+object.familia+'|]</strong></p></div>');
              // return('<strong> '+object.cod_categoria+'</strong> ');
              //tabla
              // return('<table class="table table-bordered table-condensed" style="border: 1px solid black">\
              //           <tr><td><strong>Código:</strong> '+object.cod_categoria+'</td><td><strong>Categoria: </strong>'+object.nombre+'</td></tr>'+
              //   '<tr><td><strong>Familia:</strong> '+object.familia+'</td><td><strong>Segmento:</strong> '+object.segmento+'</td></tr></table>');
            }
            else
            {
              if(object.ID === "0")//para la opción de agregar una categoria nueva
              {
                return('<div><strong> '+object.nombre+'</strong>  <p style="font-size:10px"><strong>|'+object.segmento+' | '+object.familia+'|</strong></p></div>');
                // return('<strong> '+object.nombre+'</strong>');
              }
            }
          },
          formatSelection: function(object, container){
            // console.log('formatSelection');
            // console.log(object);
            // console.log(container);
            // var data = {id:object.cod_categoria, text: '<strong>'+object.cod_categoria+'</strong>'}
            // return(object.cod_categoria);
            return(object.cod_categoria+' '+object.nombre);
            // return(data);
            // console.log(container);
          },
          // dropdownCssClass: "dropdown-menu",
          // loadMorePadding: 5,
          escapeMarkup: function(m) {
            // console.log('escapeMarkup:');
            // console.log(m);
            return m; 
          },
          // processResults: function(data, page){

          // }
        });

        var _instance = 0;
        var panel = $("<div/>");
        panel.attr("class","panel panel-info");
        panel.attr("hidden","");
        
        var panelBody = $("<div/>");
        panelBody.attr("class","panel-body");

        var panelFoot = $("<div/>");
        panelFoot.attr("class", "panel-footer");
        // panelBody.html('<i class="color" >'+categoria+'</i>');
        var form = $('<form id="AddArtForm'+_instance+'" name="AddArtForm'+_instance+'" role="form" novalidate />');
        var catForm = $('<form id="AddCatForm'+_instance+'" name="AddCatForm'+_instance+'" role="form" novalidate />');
        var subform = $('<div/>');
        var insertion = '';
        $("#addArtcategoria").on("change clear select2-opening", function(){//evento para selector de categoria
          panel.html("");//panel donde se ensambla los formularios y sus secciones
          panelFoot.html("");
          form.html("");//formulario completo de codigo, articulo y categoria
          subform.html("");//subformulario para articulos
          catForm.html("");//subformulario para categoria nueva
          catForm.remove();
          subform.remove();
          form.remove();
          panelFoot.remove();
          panel.remove();

          categoria = $("#addArtcategoria").select2("val");//toma del valor de categoria
          var codigoCat = categoria.split(' ');
          // console.log(codigoCat[0]);//toma solo el codigo del valor en categoria
          if(categoria !== "")//si hay algun valor en el input...
          {
            if(codigoCat[0] !== "0")//si el codigo dentro del valor, no es "0"
            {
              panel = buildArtCode(codigoCat[0]);//construyo un formulario con selector de codigos de articulos derivados del codigo de categoria existente
              formArt.append(panel);

              $('html, body').animate({
                scrollTop: formArt.offset().top
              }, 1500, "swing");
              panel.show();
              //código de articulo
              $("#codArtExist").on("change clear", function(){//evento para selector de articulos
                var codigoArt = [0];//inicializa la variable para ser re-usada
                articulo = $("#codArtExist").select2("val");//captura del valor del input
                if(articulo !== '')//si hay valor en el input...
                {
                  var codigoArt = articulo.split(' ');
                  // console.log(codigoArt[0]);
                  panelFoot.html('');
                  if(codigoArt[0] !== "0")//si el codigo del articulo no es "0"...
                  {
                    subform.html('');//inicia el sub-formulario...
                    panel.append(buildAddArtForm(codigoCat[0], codigoArt[0]));//construyo un formulario para solo agregar la cantidad que se va a agregar al sistema
                    insertion = {action:'add_item', form: 0};
                  }
                  else
                  {
                    form.html('');
                    panel.append(buildNewArtForm(codigoCat[0]));//construyo un formulario para llenar los datos basicos del articulo nuevo(sin pedir la cantidad)
                    insertion = {action:'new_item', form: 0};
                    // console.log(form);
                    // console.log(panel);
                  }
                  $('html, body').animate({
                      scrollTop: form.offset().top
                      // scrollTop: $('#cod_articulo').offset().top
                      // scrollTop: $('#codArtExist').offset().top
                    }, 1500, "swing");

                    //Crea el botón de insertar para el submit del formulario
                      var button = $('<button/>');
                      //type='button' data-content='remove' class='btn btn-primary' 
                      button.attr('form', 'AddArtForm'+_instance);
                      button.attr('id', 'addFormButton'+_instance);
                      button.attr('type', 'button');
                      button.attr('data-content', 'remove');
                      button.attr('class', 'btn btn-xs btn-primary pull-right');
                      button.html('Agregar');
                      button.after('<div style="clear:both;">');
                      panelFoot.append(button);
                    //Fin de Crea el botón de insertar para el submit del formulario
                      panel.append(panelFoot);
                }
                else
                {
                  subform.html('');
                }
              });
            }
            else
            {
              panel = buildAddCatForm();
              formArt.append(panel);
              $('html, body').animate({
                scrollTop: formArt.offset().top
              }, 1500, "swing");

              $("#cod_segmento").on('keyup', function(){
                $(this).val(this.value);
                $("#cod_familia").val(this.value);
                $("#cod_categoria").val(this.value);

                $('#segmento').val('');
                $('#segmento').removeAttr('readonly');
                $('#familia').val('');
                $('#familia').removeAttr('readonly');
                $('#nombre').val('');
                $('#nombre').removeAttr('readonly');
                if(this.value.length ===2)
                {
                    $.ajax({
                      url: "<?php echo base_url() ?>inventario/segmento",
                      type: 'POST',
                      dataType: "json",
                      data: {"cod_segmento":this.value},
                      success: function (data) {
                        if(data.length>0)
                        {
                          art = data[0];
                          $('#segmento').val(art.segmento);
                          $('#segmento').attr('readonly', 'readonly');
                        }
                      }
                    });
                }
              });
              $("#cod_familia").on('keyup focus change', function(){
                console.log(this.id);
                // var seg = $("#cod_segmento").attr("value");
                var seg = $("#cod_segmento").val();
                // $(this).attr('value', this.value);
                $("#cod_categoria").val(this.value);
                // $("#cod_categoria").attr('value', this.value);
                  // $('#familia').removeAttr('value');
                  $('#familia').val('');
                  $('#familia').removeAttr('readonly');
                if(this.value.length ===2)
                {
                  $("#cod_segmento").val(this.value.slice(0, 2));
                  $("#cod_segmento").trigger('keyup');
                }

                if(this.value.length ===4)
                {
                    $.ajax({
                      url: "<?php echo base_url() ?>inventario/familia",
                      type: 'POST',
                      dataType: "json",
                      data: {"cod_familia":this.value},
                      success: function (data) {
                        if(data.length>0)
                        {
                          art = data[0];
                          // $('#familia').attr('value', art.familia);
                          $('#familia').val(art.familia);
                          $('#familia').attr('readonly', 'readonly');
                        }
                      }
                    });
                }
                $(this).attr('pattern', "^("+seg+")[0-9]{2}");
              });
              $("#cod_categoria").on('keyup focus change', function(){
                // var fam = $("#cod_familia").attr("value");
                var fam = $("#cod_familia").val();
                $(this).attr('pattern', "^("+fam+")[0-9]{2}");
                // $('#nombre').removeAttr('value');
                $('#nombre').val('');
                $('#nombre').removeAttr('readonly');
                if(this.value.length ===2)
                {
                  $("#cod_segmento").val(this.value.slice(0, 2));
                  $("#cod_segmento").trigger('keyup');
                }
                if(this.value.length ===4)
                {
                  $("#cod_familia").val(this.value.slice(0, 4));
                  $("#cod_familia").trigger('keyup');
                }
                if(this.value.length ===6)
                {
                    $.ajax({
                      url: "<?php echo base_url() ?>inventario/categoria",
                      type: 'POST',
                      dataType: "json",
                      data: {"cod_categoria":this.value},
                      success: function (data) {
                        if(data.length>0)
                        {
                          art = data[0];
                          // $('#nombre').attr('value', art.nombre);
                          $('#nombre').val(art.nombre);
                          $('#nombre').attr('readonly', 'readonly');
                        }
                      }
                    });
                }
              });
                insertion = {action:'new_categoria', form: 0};
              //Crea el botón de insertar para el submit del formulario
                var button = $('<button/>');
                //type='button' data-content='remove' class='btn btn-primary' 
                button.attr('form', 'AddCatForm'+_instance);
                button.attr('id', 'addFormButton'+_instance);
                button.attr('type', 'button');
                button.attr('data-content', 'remove');
                button.attr('class', 'btn btn-xs btn-primary pull-right');
                button.html('Agregar');
                button.after('<div style="clear:both;">');
                panelFoot.append(button);
              //Fin de Crea el botón de insertar para el submit del formulario
                panel.append(panelFoot);
              panel.show();
              console.log(panel);
            }
          }
          else
          {
            $('html, body').animate({
              scrollTop: $('.header').offset().top
            }, 200, "swing");
            setTimeout(function(){
              panel.html("");
              panelFoot.html("");
              form.html("");
              subform.html("");
              catForm.html("");
              catForm.remove();
              subform.remove();
              form.remove();
              panelFoot.remove();
              panel.remove();
            }, 300);
          }
        });

        function buildAddCatForm()
        {
          var panelHead = $("<div/>");
          var panelTitle = $("<h2/>");
          // var panelBody = $("<div/>");
          // var panelFoot = $("<div/>");
          // form.attr('id', "addCatForm"+_instance);
          // console.log(form.attr('id'));
            panelHead.attr("class", "panel panel-heading");
                  panelTitle.attr("class","panel-title text-center");
                  panelTitle.html("Ingrese los datos de artículo");
                panelHead.append(panelTitle);
              panel.append(panelHead);
                // panelBody.attr("class","panel-body");
                panelBody.html('<i class="color" >Nueva Categoría</i>');
              //Codigo de segmento:
              var id = "cod_segmento";
              var formgroup = $('<div/>');
              formgroup.attr('class', 'form-group');
                var label = $('<div/>');
                label.attr('class', 'col-sm-2 col-md-2 col-lg-2 text-right');
                label.html('<label for="'+id+'"><span class="color">* </span> Código de segmento:</label>');
                var aux = $('<div/>');
                aux.attr('class', "col-xm-10 col-sm-10 col-md-10 col-lg-10");
                  var input = $('<input/>');
                  input.attr('id', id);
                  input.attr('name', id);
                  input.attr('required', 'required');
                  input.attr('pattern', "^[1-9][0-9]{1}");
                  input.attr('title', "Debe agregar el segmento al cual la familia, y la categoría corresponden, en el catálogo.");
                  input.attr('placeholder', 'Segmento de la categoría (copiar del catálogo de las naciones unidas)');
                  input.attr('data-errormsg', "* Es el valor del \"Segmento\" en el catálogo(son 2 dígitos).");
                  input.attr('style', "overflow:hidden");
                  input.attr('class', "form-control  form-control-sm");
                  input.attr('type', 'text');
                  var errorlabel = $('<label/>');
                  errorlabel.attr('id', id+'label');
                  errorlabel.attr('class', "alert-danger");
                  aux.append(input);
                  aux.append(errorlabel);
                formgroup.append(label);
                formgroup.append(aux);
              catForm.append(formgroup);

              //segmento:
              var id = "segmento";
              var formgroup = $('<div/>');
              formgroup.attr('class', 'form-group');
                var label = $('<div/>');
                label.attr('class', 'col-sm-2 col-md-2 col-lg-2 text-right');
                label.html('<label for="'+id+'"><span class="color">* </span> Nombre del segmento:</label>');
                var aux = $('<div/>');
                aux.attr('class', "col-xm-10 col-sm-10 col-md-10 col-lg-10");
                  var input = $('<input/>');
                  input.attr('id', id);
                  input.attr('name', id);
                  input.attr('required', 'required');
                  input.attr('title', "Debe insertar el nombre ó descripción del segmento.");
                  input.attr('placeholder', 'Descripción del segmento (copiar del catálogo de las naciones unidas)');
                  // input.attr('data-errormsg', "* El formato debe ser: código de la categoria, seguido de dos a cuatro números (relacionados con el catalogo de las naciones unidas), un guion (-), y letras y/o numeros relacionados con la descripción.");
                  input.attr('style', "overflow:hidden");
                  input.attr('class', "form-control  form-control-sm");
                  input.attr('type', 'text');
                  var errorlabel = $('<label/>');
                  errorlabel.attr('id', id+'label');
                  errorlabel.attr('class', "alert-danger");
                  aux.append(input);
                  aux.append(errorlabel);
                formgroup.append(label);
                formgroup.append(aux);
              catForm.append(formgroup);

              //Codigo de familia:
              var id = "cod_familia";
              var formgroup = $('<div/>');
              formgroup.attr('class', 'form-group');
                var label = $('<div/>');
                label.attr('class', 'col-sm-2 col-md-2 col-lg-2 text-right');
                label.html('<label for="'+id+'"><span class="color">* </span> Código de familia:</label>');
                var aux = $('<div/>');
                aux.attr('class', "col-xm-10 col-sm-10 col-md-10 col-lg-10");
                  var input = $('<input/>');
                  input.attr('id', id);
                  input.attr('name', id);
                  input.attr('required', 'required');
                  // input.attr('pattern', "^[1-9][0-9]{3}");
                  // input.attr('pattern', "^(document.getElementById('cod_segmento').value){3}");
                  input.attr('title', "Debe agregar la familia del artículo basado en el catálogo de las naciones unidas, que corresponda con la clase en el catálogo.");
                  input.attr('placeholder', 'Familia de la categoría (copiar del catálogo de las naciones unidas)');
                  input.attr('data-errormsg', "* Es el valor del código \"Familia\" en el catálogo(son 4 dígitos, donde los primeros 2 son el código del segmento).");
                  input.attr('style', "overflow:hidden");
                  input.attr('class', "form-control  form-control-sm");
                  input.attr('type', 'text');
                  var errorlabel = $('<label/>');
                  errorlabel.attr('id', id+'label');
                  errorlabel.attr('class', "alert-danger");
                  aux.append(input);
                  aux.append(errorlabel);
                formgroup.append(label);
                formgroup.append(aux);
              catForm.append(formgroup);

              //segmento:
              var id = "familia";
              var formgroup = $('<div/>');
              formgroup.attr('class', 'form-group');
                var label = $('<div/>');
                label.attr('class', 'col-sm-2 col-md-2 col-lg-2 text-right');
                label.html('<label for="'+id+'"><span class="color">* </span> Nombre de la familia:</label>');
                var aux = $('<div/>');
                aux.attr('class', "col-xm-10 col-sm-10 col-md-10 col-lg-10");
                  var input = $('<input/>');
                  input.attr('id', id);
                  input.attr('name', id);
                  input.attr('required', 'required');
                  input.attr('title', "Debe insertar el nombre ó descripción de la familia.");
                  input.attr('placeholder', 'Descripción de la familia (copiar del catálogo de las naciones unidas)');
                  // input.attr('data-errormsg', "* El formato debe ser: código de la categoria, seguido de dos a cuatro números (relacionados con el catalogo de las naciones unidas), un guion (-), y letras y/o numeros relacionados con la descripción.");
                  input.attr('style', "overflow:hidden");
                  input.attr('class', "form-control  form-control-sm");
                  input.attr('type', 'text');
                  var errorlabel = $('<label/>');
                  errorlabel.attr('id', id+'label');
                  errorlabel.attr('class', "alert-danger");
                  aux.append(input);
                  aux.append(errorlabel);
                formgroup.append(label);
                formgroup.append(aux);
              catForm.append(formgroup);

              //Codigo de categoria:
              var id = "cod_categoria";
              var formgroup = $('<div/>');
              formgroup.attr('class', 'form-group');
                var label = $('<div/>');
                label.attr('class', 'col-sm-2 col-md-2 col-lg-2 text-right');
                label.html('<label for="'+id+'"><span class="color">* </span> Código de categoría(clase):</label>');
                var aux = $('<div/>');
                aux.attr('class', "col-xm-10 col-sm-10 col-md-10 col-lg-10");
                  var input = $('<input/>');
                  input.attr('id', id);
                  input.attr('name', id);
                  input.attr('required', 'required');
                  // input.attr('pattern', "^[1-9][0-9]{5}");
                  input.attr('pattern', "^[1-9][0-9]{5}");
                  input.attr('title', "Debe agregar la categoría del artículo basado en el catálogo de las naciones unidas, que corresponda con la clase encontrada en el catálogo.");
                  input.attr('placeholder', 'Clase del artículo que vaya a agregar posteriormente (copiar del catálogo de las naciones unidas)');
                  input.attr('data-errormsg', "* Es el valor del código \"Clase\" en el catálogo(son 6 dígitos, donde los primeros 4 son el código de la familia).");
                  input.attr('style', "overflow:hidden");
                  input.attr('class', "form-control  form-control-sm");
                  input.attr('type', 'text');
                  var errorlabel = $('<label/>');
                  errorlabel.attr('id', id+'label');
                  errorlabel.attr('class', "alert-danger");
                  aux.append(input);
                  aux.append(errorlabel);
                formgroup.append(label);
                formgroup.append(aux);
              catForm.append(formgroup);

              //categoria:
              var id = "nombre";
              var formgroup = $('<div/>');
              formgroup.attr('class', 'form-group');
                var label = $('<div/>');
                label.attr('class', 'col-sm-2 col-md-2 col-lg-2 text-right');
                label.html('<label for="'+id+'"><span class="color">* </span> Nombre de la categoría:</label>');
                var aux = $('<div/>');
                aux.attr('class', "col-xm-10 col-sm-10 col-md-10 col-lg-10");
                  var input = $('<input/>');
                  input.attr('id', id);
                  input.attr('name', id);
                  input.attr('required', 'required');
                  input.attr('title', "Debe insertar el nombre ó descripción de la categoría.");
                  input.attr('placeholder', 'Descripción de la categoría (copiar del catálogo de las naciones unidas)');
                  // input.attr('data-errormsg', "* El formato debe ser: código de la categoria, seguido de dos a cuatro números (relacionados con el catalogo de las naciones unidas), un guion (-), y letras y/o numeros relacionados con la descripción.");
                  input.attr('style', "overflow:hidden");
                  input.attr('class', "form-control  form-control-sm");
                  input.attr('type', 'text');
                  var errorlabel = $('<label/>');
                  errorlabel.attr('id', id+'label');
                  errorlabel.attr('class', "alert-danger");
                  aux.append(input);
                  aux.append(errorlabel);
                formgroup.append(label);
                formgroup.append(aux);
              catForm.append(formgroup);

                panelBody.append(catForm);
            panel.append(panelBody);
            return(panel);

        }
        function buildArtCode(categoria)//listo
        {
          var panelHead = $("<div/>");
          var panelTitle = $("<h2/>");
          // var panelBody = $("<div/>");
          // var panelFoot = $("<div/>");
          panelHead.attr("class", "panel panel-heading");
                  panelTitle.attr("class","panel-title text-center");
                  panelTitle.html("Ingrese los datos de artículo");
                panelHead.append(panelTitle);
              panel.append(panelHead);
                // panelBody.attr("class","panel-body");
                panelBody.html('<i class="color" >'+categoria+'</i>');
                // var form = $('<form id="AddArtForm'+_instance+'" name="AddArtForm" role="form" novalidate />');
                
          var artCodSelect = $('<input hidden id="codArtExist" class="form-control input-sm" name="" type="text">');
              var formgroup = $('<div/>');
              formgroup.attr('class', 'form-group');
              var label = $('<div/>');
              label.attr('class', 'col-sm-2 col-md-2 col-lg-2 text-right');
              label.html('<label for="codArtExist"><span class="color">* </span> Artículo:</label>');

              formgroup.append(label);
              formgroup.append(artCodSelect);
              form.append(formgroup);
          artCodSelect.select2({
              placeholder:"Seleccione el código del artículo, en caso de que no exista, agregue uno nuevo basado en el catálogo de las naciones unidas.",
              // minimumInputLength: 1,
              maximumSelectionSize: 10,
              allowClear: true,
              id: function(e){
                return(e.cod_articulo+' '+e.descripcion);
              },
              ajax: {
                url: '<?php echo base_url() ?>inventario/articulos/categoria/'+categoria,
                dataType: 'json',
                //http://select2.github.io/select2/
                quietMillis: 250,
                data: function(term, page){
                   return {
                    q: term
                   };
                },
                results: function(data, page){
                  // console.log("results ");
                  // var newCat = { ID: "0", TIME: "0", cod_articulo: "0", descripcion: "Agregar Categoría nueva", unidad: "", ACTIVE: "0", imagen: "", usados: "0", nuevos: "0", reserv: "0", peso_kg: "0", dimension_cm: "0", nivel_rehab: "0", stock_min: "0", stock_max: "0", partida_presupuestaria: "0", cod_ubicacion: "0", cod_artviejo: "0", cod_articulonu: "0" }
                  var newCat = {"ID":"0","TIME":"","cod_articulo":"0","unidad":"","descripcion":"Agregar Artículo nuevo","ACTIVE":"0","imagen":"NULL","usados":"0","nuevos":"0","reserv":"0","peso_kg":"0","dimension_cm":"NULL","nivel_reab":"0","stock_min":"0","stock_max":"0","partida_presupuestaria":"","cod_ubicacion":"","cod_artviejo":"0","cod_articulonu":"0","cod_categoria":"0"};
                  data.push(newCat);
                  return { results: data };
                }
              },
              initSelection: function(element, callback){
                var id = $(element).val();
                console.log('init!');
                if(id !== "")
                {
                  var aux = [];
                  aux.push(id.slice(id.indexOf(' '), id.length));
                  aux.push(id.slice(0, id.indexOf(' ')));
                  // console.log(aux);
                  var data = {cod_articulo: aux[1], descripcion: aux[0]};
                  callback(data);
                  // console.log('selected...!');
                }
              },
              formatResult: function(object, container, query){
                textpattern = query.term.toUpperCase();
                pattern = query.term;
                // if(object.descripcion.search(textpattern) !== -1 || object.cod_articulo.search(pattern) !== -1 || object.cod_segmento.search(pattern) !== -1 || object.cod_familia.search(pattern) !== -1 || object.familia.search(textpattern) !== -1 || object.segmento.search(textpattern) !== -1)
                if(object.descripcion.search(textpattern) !== -1 || object.cod_articulo.search(pattern) !== -1 )
                {
                  //parrafo
                  // return('<strong> '+object.cod_articulo+'</strong> '+object.descripcion+' <p style="font-size:10px"><strong>[Seg.|'+object.cod_segmento+'|'+object.segmento+'| Fam.|'+object.cod_familia+'|'+object.familia+'|]</strong></p>');
                  return('<strong> '+object.cod_articulo+'</strong> '+object.descripcion);
                }
                else
                {
                  if(object.ID === "0")//para la opción de agregar una categoria nueva
                  {
                    // return('<strong> '+object.nombre+'</strong>  <p style="font-size:10px"><strong>|'+object.segmento+' | '+object.familia+'|</strong></p>');
                    return('<strong> '+object.nombre+'</strong>  ');
                  }
                }
              },
              formatSelection: function(object, container){
                // console.log('formatSelection');
                // console.log(object);
                return(object.cod_articulo+' '+object.descripcion);
              },
              // dropdownCssClass: "bigdropdown",
              escapeMarkup: function(m) {
                // console.log('escapeMarkup:');
                // console.log(m);
                return m; 
              }
            });

            panelBody.append(form);
            panel.append(panelBody);
            return(panel);
        }
        function buildNewArtForm(categoria)//listo
        {
              // panel.html("");
              form.html("");
              subform.html("");
              subform.remove();
              form.remove();
              // panel.remove();
              //Codigo de Articulo:
              var id = "cod_articulo";
              var formgroup = $('<div/>');
              formgroup.attr('class', 'form-group');
                var label = $('<div/>');
                label.attr('class', 'col-sm-2 col-md-2 col-lg-2 text-right');
                label.html('<label for="'+id+'"><span class="color">* </span> Código del Articulo:</label>');
                var aux = $('<div/>');
                aux.attr('class', "col-xm-10 col-sm-10 col-md-10 col-lg-10");
                  var input = $('<input/>');
                  input.attr('id', id);
                  input.attr('name', id);
                  input.attr('required', 'required');
                  input.attr('pattern', "^("+categoria+")[0-9]{2,4}-[A-Z0-9]{1,10}");
                  input.attr('title', "Debe agregar el código del artículo basado en el catálogo de las naciones unidas, que corresponda en la categoría del catálogo.");
                  input.attr('placeholder', 'Código del artículo (revisar catálogo de las naciones unidas)');
                  input.attr('value', categoria);
                  input.attr('data-errormsg', "* El formato debe ser: código de la categoría, seguido de dos a cuatro números (basados en el catálogo de las naciones unidas), un guión (-), y letras y/o números relacionados con la descripción.");
                  input.attr('style', "overflow:hidden");
                  input.attr('class', "form-control  form-control-sm");
                  input.attr('type', 'text');
                  var errorlabel = $('<label/>');
                  errorlabel.attr('id', id+'label');
                  errorlabel.attr('class', "alert-danger");
                  aux.append(input);
                  aux.append(errorlabel);
                formgroup.append(label);
                formgroup.append(aux);
              subform.append(formgroup);

              //Descripción:
              var id = "descripcion";
              var formgroup = $('<div/>');
              formgroup.attr('class', 'form-group');
                var label = $('<div/>');
                label.attr('class', 'col-sm-2 col-md-2 col-lg-2 text-right');
                label.html('<label for="'+id+'"><span class="color">* </span> Descripción:</label>');
                var aux = $('<div/>');
                aux.attr('class', "col-xm-10 col-sm-10 col-md-10 col-lg-10");
                  var input = $('<input/>');
                  input.attr('id', id);
                  input.attr('name', id);
                  input.attr('required', 'required');
                  input.attr('title', "Debe insertar una descripción usando palabras alejadas del lenguaje informal.");
                  input.attr('placeholder', 'Descripción del artículo (revisar términos usados en el catálogo de las naciones unidas)');
                  // input.attr('data-errormsg', "* El formato debe ser: código de la categoria, seguido de dos a cuatro números (relacionados con el catalogo de las naciones unidas), un guion (-), y letras y/o numeros relacionados con la descripción.");
                  input.attr('style', "overflow:hidden");
                  input.attr('class', "form-control  form-control-sm");
                  input.attr('type', 'text');
                  var errorlabel = $('<label/>');
                  errorlabel.attr('id', id+'label');
                  errorlabel.attr('class', "alert-danger");
                  aux.append(input);
                  aux.append(errorlabel);
                formgroup.append(label);
                formgroup.append(aux);
              subform.append(formgroup);

              // unidad:
              var id = "unidad";
              var formgroup = $('<div/>');
              formgroup.attr('class', 'form-group');
                var label = $('<div/>');
                label.attr('class', 'col-sm-2 col-md-2 col-lg-2 text-right');
                label.html('<label for="'+id+'"><span class="color">* </span> Unidad:</label>');
                var aux = $('<div/>');
                aux.attr('class', "col-xm-10 col-sm-10 col-md-10 col-lg-10");
                  var input = $('<input/>');
                  input.attr('id', id);
                  input.attr('name', id);
                  input.attr('required', 'required');
                  // input.attr('pattern', "^("+codigoCat[0]+")[0-9]{2,4}-[A-Z0-9]{1,10}");
                  input.attr('title', "Ejemplo: UNIDAD, CAJA, PAQUETE, BIDÓN, GARRAFA, etc.");
                  input.attr('placeholder', 'Unidad de medida del artículo, para la cantidad que habitualmente se despacha en las solicitudes internas.');
                  // input.attr('data-errormsg', "* El formato debe ser: código de la categoria, seguido de dos a cuatro números (relacionados con el catalogo de las naciones unidas), un guion (-), y letras y/o numeros relacionados con la descripción.");
                  input.attr('style', "overflow:hidden");
                  input.attr('class', "form-control  form-control-sm");
                  input.attr('type', 'text');
                  var errorlabel = $('<label/>');
                  errorlabel.attr('id', id+'label');
                  errorlabel.attr('class', "alert-danger");
                  aux.append(input);
                  aux.append(errorlabel);
                formgroup.append(label);
                formgroup.append(aux);
              subform.append(formgroup);

              //ubicacion:
              var id = "cod_ubicacion";
              var formgroup = $('<div/>');
              formgroup.attr('class', 'form-group');
                var label = $('<div/>');
                label.attr('class', 'col-sm-2 col-md-2 col-lg-2 text-right');
                label.html('<label for="'+id+'">Código de ubicación:</label>');
                var aux = $('<div/>');
                aux.attr('class', "col-xm-10 col-sm-10 col-md-10 col-lg-10");
                  var input = $('<input/>');
                  input.attr('id', id);
                  input.attr('name', id);
                  // input.attr('required', 'required');
                  input.attr('title', "Siga el formato implementado por el jefe de despacho de almacén");
                  input.attr('placeholder', 'Indique el codigo que referencia la ubicación física del artículo(definido por el jefe de despacho de almacén).');
                  // input.attr('data-errormsg', "* El formato debe ser: código de la categoria, seguido de dos a cuatro números (relacionados con el catalogo de las naciones unidas), un guion (-), y letras y/o numeros relacionados con la descripción.");
                  input.attr('style', "overflow:hidden");
                  input.attr('class', "form-control  form-control-sm");
                  input.attr('type', 'text');
                  var errorlabel = $('<label/>');
                  errorlabel.attr('id', id+'label');
                  errorlabel.attr('class', "alert-danger");
                  aux.append(input);
                  aux.append(errorlabel);
                formgroup.append(label);
                formgroup.append(aux);
              subform.append(formgroup);

              //partida presupuestaria:
              var id = "partida_presupuestaria";
              var formgroup = $('<div/>');
              formgroup.attr('class', 'form-group');
                var label = $('<div/>');
                label.attr('class', 'col-sm-2 col-md-2 col-lg-2 text-right');
                label.html('<label for="'+id+'"><span class="color">* </span> Partida presupuesaria:</label>');
                var aux = $('<div/>');
                aux.attr('class', "col-xm-10 col-sm-10 col-md-10 col-lg-10");
                  var input = $('<input/>');
                  input.attr('id', id);
                  input.attr('name', id);
                  input.attr('required', 'required');
                  // input.attr('pattern', "^("+codigoCat[0]+")[0-9]{2,4}-[A-Z0-9]{1,10}");
                  input.attr('title', "Código de la partida presupuesaria a la cual pertenece el artículo.");
                  input.attr('placeholder', 'Código de la partida presupuestaria.');
                  // input.attr('data-errormsg', "* El formato debe ser: código de la categoria, seguido de dos a cuatro números (relacionados con el catalogo de las naciones unidas), un guion (-), y letras y/o numeros relacionados con la descripción.");
                  input.attr('style', "overflow:hidden");
                  input.attr('class', "form-control  form-control-sm");
                  input.attr('type', 'text');
                  var errorlabel = $('<label/>');
                  errorlabel.attr('id', id+'label');
                  errorlabel.attr('class', "alert-danger");
                  aux.append(input);
                  aux.append(errorlabel);
                formgroup.append(label);
                formgroup.append(aux);
              subform.append(formgroup);
              form.append(subform);
              panelBody.append(form);
              return(panelBody);
        }
        function buildAddArtForm(categoria, articulo)//listo
        {
          var cod_articulo = '';
          var descripcion = '';
          var unidad = '';
          var cod_ubicacion = '';
          var partida_presupuestaria = '';
          console.log("HERE");
            $.ajax({
                url: "<?php echo base_url() ?>inventario/articulo",
                type: 'POST',
                dataType: "json",
                data: {"cod_articulo":articulo},
                success: function (art) {
                    console.log(art);
                    console.log(art.ID);

                    cod_articulo = art.cod_articulo;
                    descripcion = art.descripcion;
                    unidad = art.unidad;
                    cod_ubicacion = art.cod_ubicacion;
                    partida_presupuestaria = art.partida_presupuestaria;
                    //Codigo:
                    var id = "cod_articulo";
                    var formgroup = $('<div/>');
                    formgroup.attr('class', 'form-group');
                      var label = $('<div/>');
                      label.attr('class', 'col-sm-2 col-md-2 col-lg-2 text-right');
                      label.html('<label for="'+id+'"><span class="color">* </span> Código del artículo:</label>');
                      var aux = $('<div/>');
                      aux.attr('class', "col-xm-10 col-sm-10 col-md-10 col-lg-10");
                        var input = $('<input/>');
                        input.attr('id', id);
                        input.attr('name', id);
                        input.attr('readonly', '');
                        input.attr('value', cod_articulo);
                        input.attr('style', "overflow:hidden");
                        input.attr('class', "form-control  form-control-sm");
                        input.attr('type', 'text');
                        var errorlabel = $('<label/>');
                        errorlabel.attr('id', id+'label');
                        errorlabel.attr('class', "alert-danger");
                        aux.append(input);
                        aux.append(errorlabel);
                      formgroup.append(label);
                      formgroup.append(aux);
                  subform.append(formgroup);
                    //Descripción:
                    var id = "descripcion";
                    var formgroup = $('<div/>');
                    formgroup.attr('class', 'form-group');
                      var label = $('<div/>');
                      label.attr('class', 'col-sm-2 col-md-2 col-lg-2 text-right');
                      label.html('<label for="'+id+'"><span class="color">* </span> Descripción:</label>');
                      var aux = $('<div/>');
                      aux.attr('class', "col-xm-10 col-sm-10 col-md-10 col-lg-10");
                        var input = $('<input/>');
                        input.attr('id', id);
                        input.attr('name', id);
                        input.attr('readonly', '');
                        input.attr('value', descripcion);
                        input.attr('style', "overflow:hidden");
                        input.attr('class', "form-control  form-control-sm");
                        input.attr('type', 'text');
                        var errorlabel = $('<label/>');
                        errorlabel.attr('id', id+'label');
                        errorlabel.attr('class', "alert-danger");
                        aux.append(input);
                        aux.append(errorlabel);
                      formgroup.append(label);
                      formgroup.append(aux);
                  subform.append(formgroup);

                    //ubicacion:
                    var id = "cod_ubicacion";
                    var formgroup = $('<div/>');
                    formgroup.attr('class', 'form-group');
                      var label = $('<div/>');
                      label.attr('class', 'col-sm-2 col-md-2 col-lg-2 text-right');
                      label.html('<label for="'+id+'"><span class="color">* </span> Código de ubicación:</label>');
                      var aux = $('<div/>');
                      aux.attr('class', "col-xm-10 col-sm-10 col-md-10 col-lg-10");
                        var input = $('<input/>');
                        input.attr('id', id);
                        input.attr('name', id);
                        input.attr('readonly', '');
                        input.attr('value', cod_ubicacion);
                        input.attr('style', "overflow:hidden");
                        input.attr('class', "form-control  form-control-sm");
                        input.attr('type', 'text');
                        var errorlabel = $('<label/>');
                        errorlabel.attr('id', id+'label');
                        errorlabel.attr('class', "alert-danger");
                        aux.append(input);
                        aux.append(errorlabel);
                      formgroup.append(label);
                      formgroup.append(aux);
                  subform.append(formgroup);

                    //partida presupuestaria:
                    var id = "partida_presupuestaria";
                    var formgroup = $('<div/>');
                    formgroup.attr('class', 'form-group');
                      var label = $('<div/>');
                      label.attr('class', 'col-sm-2 col-md-2 col-lg-2 text-right');
                      label.html('<label for="'+id+'"><span class="color">* </span> Partida presupuestaria:</label>');
                      var aux = $('<div/>');
                      aux.attr('class', "col-xm-10 col-sm-10 col-md-10 col-lg-10");
                        var input = $('<input/>');
                        input.attr('id', id);
                        input.attr('name', id);
                        input.attr('readonly', '');
                        input.attr('value', partida_presupuestaria);
                        input.attr('style', "overflow:hidden");
                        input.attr('class', "form-control  form-control-sm");
                        input.attr('type', 'text');
                        var errorlabel = $('<label/>');
                        errorlabel.attr('id', id+'label');
                        errorlabel.attr('class', "alert-danger");
                        aux.append(input);
                        aux.append(errorlabel);
                      formgroup.append(label);
                      formgroup.append(aux);
                  subform.append(formgroup);

                    // unidad:
                    var id = "unidad";
                    var formgroup = $('<div/>');
                    formgroup.attr('class', 'form-group');
                      var label = $('<div/>');
                      label.attr('class', 'col-sm-2 col-md-2 col-lg-2 text-right');
                      label.html('<label for="'+id+'"><span class="color">* </span> Unidad:</label>');
                      var aux = $('<div/>');
                      aux.attr('class', "col-xm-10 col-sm-10 col-md-10 col-lg-10");
                        var input = $('<input/>');
                        input.attr('id', id);
                        input.attr('name', id);
                        input.attr('readonly', '');
                        input.attr('value', unidad);
                        input.attr('style', "overflow:hidden");
                        input.attr('class', "form-control  form-control-sm");
                        input.attr('type', 'text');
                        var errorlabel = $('<label/>');
                        errorlabel.attr('id', id+'label');
                        errorlabel.attr('class', "alert-danger");
                        aux.append(input);
                        aux.append(errorlabel);
                      formgroup.append(label);
                      formgroup.append(aux);
                  subform.append(formgroup);

                  //cantidad
                  var id = "nuevos";
                  var formgroup = $('<div/>');
                  formgroup.attr('class', 'form-group');
                    var label = $('<div/>');
                    label.attr('class', 'col-sm-2 col-md-2 col-lg-2 text-right');
                    label.html('<label for="'+id+'"><span class="color">* </span> Cantidad:</label>');
                    var aux = $('<div/>');
                    aux.attr('class', "col-xm-10 col-sm-10 col-md-10 col-lg-10");
                      var input = $('<input/>');
                      input.attr('id', id);
                      input.attr('name', id);
                      input.attr('required', 'required');
                      input.attr('pattern', "^[1-9][0-9]{0,4}");
                      input.attr('title', "Cantidad en proceso de recepción por almacén");
                      input.attr('placeholder', 'Cantidad a agregar en inventario (tome en cuenta la unidad).');
                      input.attr('data-errormsg', "* Debe ingresar un valor numerico, entero(que no empieze por '0', y sea menor a 99999).");
                      input.attr('style', "overflow:hidden");
                      input.attr('class', "form-control  form-control-sm");
                      input.attr('type', 'text');
                      var errorlabel = $('<label/>');
                      errorlabel.attr('id', id+'label');
                      errorlabel.attr('class', "alert-danger");
                      aux.append(input);
                      aux.append(errorlabel);
                    formgroup.append(label);
                    formgroup.append(aux);
                  subform.append(formgroup);

                  form.append(subform);
                  panelBody.append(form);
                  return(panelBody);
                }
            });
            // console.log("end");
        }
        //submit del formulario
        $(document).on('click', '#addFormButton'+_instance, function(e)
        {
            // console.log($('#cod_articulolabel.alert-danger').length);
            // $('#cod_articulolabel.alert-danger').html('hello!');
            // $('#cod_articulolabel.alert-danger').show();
          console.log(this);
          var form = this.form.id;
          // console.log(form);
          // if(form.formValidate()){
          if(formValidate(form))
          {
            console.log('good!');
            e.preventDefault();
            e.stopPropagation();
            //here goes the submit
            insertion.form = ($("#"+form).serializeArray());
            // insertion.form.push($("#"+form).serializeArray());
            // console.log($("#"+form).serializeArray());
            // console.log(insertion);
            $.ajax({
                url: "<?php echo base_url() ?>inventario/insertar",
                type: 'POST',
                dataType: "json",
                // data: {"form":$("#"+form).serializeArray()},
                // data: [{form:$("#"+form).serializeArray()}],
                // data: $("#"+form).serializeArray(),
                data: insertion,
                success: function (resp) {//HILAZA, HILADO
                  console.log(typeof resp);
                  console.log(resp.art);
                  // var response = $.parseJSON(resp);
                  var response = resp;
                  if(response === "success")
                  {
                    swal(
                      'Éxito!',
                      'Inserción del dato realizado de forma exitosa.',
                      'success');
                    $("#addArtcategoria").select2("val", '');
                    $("#addArtcategoria").trigger('clear');
                  }
                  else
                  {
                    if(typeof response === "object")
                    {
                      if(response.cat === 'exist')
                      {
                        swal(
                          'Ya existe!',
                          'La categoria ya existe',
                          'info');
                      }
                      if(response.art === 'exist')
                      {
                        swal(
                              'Ya existe!',
                              'El código del artículo ya existe',
                              'info');
                      }
                    }
                    else
                    {
                      swal(
                        'ERROR!',
                        'Ha ocurrido un error inesperado, al intentar ingresar datos al sistema',
                        'error');
                    }
                  }
                }
            });
          }
          else
          {
            console.log('bad!');
            return(false);
          }
        });

        function formValidate(form)//para validar
        {
          // console.log('form validation');
          // console.log("form= "+$('#'+form).length);
          var isValid = false;
          var errorcount = 0;
          // console.log($('form[id="'+form+'"] *'));
          //Ciclo para recorrer todos los inputs
          // $('form[id="'+form+'"] *').filter(':input').each(function( i ){
          // console.log($('form[id="'+form+'"] *').filter(':input'));
          $('form[name="'+form+'"] *').filter(':input').each(function( i ){
            console.log(this);
            //para pasar las letras a mayúscula
            var aux = this.value;
            this.value = aux.toUpperCase();
            //para el mensaje de error
            var errorLabel = "#"+this.name+"label.alert-danger";
            console.log($(this).context.validity.patternMismatch);//ejecuta validacion del atributo pattern
            console.log($(this).context.validity.valueMissing);//ejecuta la validacion del atributo required
            // if(!$(this).context.checkValidity())
            if($(this).context.validity.valueMissing)
            {
              console.log("failed!");
              $(errorLabel).html('* Este campo es obligatorio');
              $(errorLabel).show();
              errorcount++;
            }
            else
            {
              if($(this).context.validity.patternMismatch)
              {
                console.log("failed!");
                $(errorLabel).html($(this).attr("data-errorMsg"));
                $(errorLabel).show();
                errorcount++;
              }
              else
              {
                // $(errorLabel).hide();
                $(errorLabel).empty();

              }
            }
          });

          if(errorcount === 0)
          {
            isValid = true;
          }

          // console.log('END form validation');
          return isValid;
        }
///////Fin del Proceso de adición de articulos a inventario
    <?php endif;?>
  
///////Para los procesos involucrados en el cierre de inventario
  //para la subida del archivo de excel necesario para el cierre de inventario
    <?php if(!empty($alm[7])):?>
      var cierre = $("#excel").fileinput({
          language:'es',
          showCaption: false,
          showUpload: false,
          showRemove: false,
          autoReplace: true,
          maxFileCount: 1,
          uploadUrl: "<?php echo base_url() ?>inventario/cierre/fromExcelFile",
          previewFileType: "text",
          browseLabel: " Examinar...",
          browseIcon: '<i class="glyphicon glyphicon-file"></i>'
      });
      cierre.fileinput('enable');
      cierre.on('fileloaded', function(event, data, previewId, index){//evento antes de subir el archivo
        swal({
                title: "Proceso irreversible",
                text: "Recuerde que una vez suministrado el archivo, no se puede revertir el proceso",
                type: "warning",
                showCancelButton: true,
                confirmButtonText: "Continuar",
                cancelButtonText: "Cancelar"
            }).then(function(){
              cierre.fileinput('upload');
              // swal(
              //   'Insertado a sistema',
              //   'Se ha suministrado el archivo de existencia física',
              //   'success')
            },function(dismiss){
              if(dismiss=='cancel'){
              $('#excel').fileinput('clear');
              swal(
                'cancelado!',
                'Se ha cancelado el proceso de subida del archivo',
                'error')
              }

            });
      });
			cierre.on('fileuploaded', function(event, data, previewId, index){//evento de subida de archivo
				// console.log(data.response);
        console.log("START!!!");
				var aux = data.response;
        var RepInvFisico = $("#RepInvFisico");
        var loadingIMG = $("<img>", {"class": "img-rounded", "style":"margin-left:15%;margin-top:15%;margin-bottom:15%;width:15%"});
        loadingIMG.attr('src', '<?php echo base_url() ?>assets/img/Loaders/gears.svg');
        RepInvFisico.html(loadingIMG);
        // console.log("loadingimages: "+loadingIMG.length);
        var readExcel = $.post("<?php echo base_url() ?>inventario/cierre/readExcelFile", { //se le envia la data por post al controlador respectivo
                file: aux  //variable a enviar que contiene la direccion del archivo de excell que fue subido #375a7f  #0fa6bc
            }, function (data) {////aqui quedé
                console.log(data);
            //version nueva
            var response = $.parseJSON(data);
            console.log(response.status);
              if( response.status === 'success')
              {
                swal(
                      'Insertado a sistema',
                      'Se ha suministrado el archivo de existencia física',
                      'success').then(function(){
                        loadingIMG.remove();
                        RepInvFisico.html('<div class="alert alert-warning" style="text-align: center;margin-top:10%;">\
                                <i class="fa fa-info-circle fa-2x pull-left"></i><strong class="h5">Las cantidades existentes en inventario físico ya fueron ingresadas al sistema.</strong>\
                              </div>');
                      });
              }
              else
              {
                if (response.status === 'error')
                {
                  swal(
                        'Ocurrió un error',
                        'Ha ocurrido un error al leer el archivo suministrado',
                        'error').then(function(){
                            loadingIMG.remove();
                            RepInvFisico.html('<div class="alert alert-warning" style="text-align: center;margin-top:10%;">\
                                    <i class="fa fa-info-circle fa-2x pull-left"></i><strong class="h5">En breve se actualizará la página para que intente nuevamente.</strong>\
                                  </div>');
                            setTimeout(function(){
                              location.reload();//aqui funciona
                            }, 3000);
                        });
                }
              }
            //version nueva
            });
      });
    <?php endif;?>
    ///revision de incongruencias
        // var closeInvPermit = '<?php echo (!empty($alm[8]) ? $alm[8] : 0); ?>';
        // console.log(closeInvPermit);
    <?php if(!empty($alm[8])):?>
        <?php if(!empty($RepInvFisico) && ($RepInvFisico['completed'] == 'ADJUSTED' || $RepInvFisico['completed'] == 'NOADJUSTRQ')): ?>
            
            var test1 = $("#divinco");
            var continueBtn = $("#continueClosure");
            continueBtn.click(function(){
              console.log("FAAAAK!");
              var close = $("#close");
              var loadingIMG = $("<img>", {"class": "img-rounded", "style":"margin-left:15%;margin-top:15%;margin-bottom:15%;width:15%"});
              loadingIMG.attr('src', '<?php echo base_url() ?>assets/img/Loaders/gears.svg');
              close.html(loadingIMG);
              $.ajax({
                  url:"<?php echo base_url() ?>inventario/cerrar",
                  type:"POST",
                  success: function(data)
                  {
                    // setTimeout(function ()
                    // {
                      console.log(data);
                      swal(
                        'Cierre exitoso',
                        'El proceso de cierre de inventario ha sido realizado con éxito',
                        'success'
                        ).then(function(){
                          //locura
                          var string = '<!DOCTYPE html>';
                          var pdf = $('<iframe/>');
                          pdf.attr('src', '<?php echo base_url() ?>inventario/generar/acta');
                          pdf.attr("width", "100%");
                          pdf.attr("height", "100%");
                          buildModal('pdfCierre', 'Actas Generadas', pdf, '', 'lg', '500');
                          // location.reload();
                        });
                    // }, 3000);
                }
              });
            });
        <?php else: ?>
          $("#incongruencias").on("click", function(){//hace una llamada a la interfaz de una datatable de los articulos con incongruencias referentes a las cantidades reportadas y del sistema
            console.log($(this).html());
            // $("#"+this.id).prop('disabled', true);
            $(this).prop('disabled', true);
            var server = '<?php echo base_url()?>cierre/revision';
          //primera opción
            // $.post(server, {link:"<?php echo uri_string()?>"}, function(data){
            //   buildModal('revision', 'Revisión', data, '', 'lg', 768);
            // });
          //segunda opción
            // var defColumnas = [{name:"Item",  value:'ID'}, {name:"Código",  value:'cod_articulo'}, {name:"Artículo", value:'descripcion'}, {name:"Cantidad reportada",  value:'exist_reportada'}, {name:"Existencia en sistema",  value:'exist_sistema'}, {name:"Observación",  value:'justificacion'}];
            var columnDefs = [
                {
                    title:"Item",
                    id: "ID",
                    data: "ID",
                    "visible": false,
                    "searchable": false
                },{
                    title: "Código del artículo",
                    id: "cod_articulo",
                    data: "cod_articulo",
                    type: "readonly"
                                    
                },{
                    title:"Descripción del Artículo",
                    id: "descripcion",
                    data: "descripcion",
                    type: "readonly"
                },{
                    title:"Cantidad Reportada",
                    id: "exist_reportada",
                    data: "exist_reportada",
                    type: "readonly"
                },{
                    title:"Cantidad en Sistema",
                    id: "exist_sistema",
                    data: "exist_sistema",
                    type: "readonly"
                },{
                    title: "Justificación",
                    id: "justificacion",
                    data: "justificacion",
                    type: "textarea",
                    pattern:"^[a-zá-úA-Z0-9\r\n\t\f\v \"\/]*",
                    required: true,
                    errorMsg: "* Debe Justificar la incongruencia.",
                    hoverMsg: "Ejemplo: ... a causa de extravío,... ",
                    placeholder: "Justifique la causa de la incongruencia"
                }
            ];
            var attrColumnas = {"ID":{"bVisible": true, "bSearchable": false, "bSortable": true},cod_articulo:{"bVisible": true, "bSearchable": false, "bSortable": true},descripcion:{"bVisible": true, "bSearchable": false, "bSortable": true},exist_reportada:{"bVisible": true, "bSearchable": false, "bSortable": true},exist_sistema:{"bVisible": true, "bSearchable": false, "bSortable": true},justificacion:{"bVisible": true, "bSearchable": true, "bSortable": true}};
            var tablas = ["alm_reporte", "alm_articulo"];
            var commonJoins = ["id_articulo", "ID"];
            var dbAbiguous = ["ID"];
            var UIlanguage = {
              "emptyTable":     "No hay incongruencias",
              "lengthMenu":     "Mostrar _MENU_ registros",
              "loadingRecords": "Cargando...",
              "processing":     "Procesando...",
              "search":         "Buscar:",
              "zeroRecords":    "No se encontraron incongruencias",
              "paginate": {
                  "first":      "Primero",
                  "last":       "Último",
                  "next":       "Siguiente",
                  "previous":   "Anterior"
                }
              };
            var Vars = {
              mother: "divinco",
              id: "incongruityTable",
              url: '<?php echo site_url("tablas/inventario/reportado") ?>',
              columns: columnDefs,
              columnAttr: attrColumnas,
              dbTable: tablas,
              dbCommonJoins: commonJoins,
              dbAbiguous: dbAbiguous,
              buttonName: 'Justificar',
              language: UIlanguage
            };
            // var tablerep = buildDataTable("incongTable", defColumnas, '', attrColumnas, tablas);
            // buildDataTable(Vars);
            var tablaEdit = buildEdiTable(Vars);
            var test1 = $("#divinco");//cuerpo de la tabla y control de actas(tabla y botones)

            var actaBtn = $("<button/>");
            <?php if(!empty($RepInvFisico) && $RepInvFisico['completed'] == 'REPORTED'): ?>
              actaBtn.html('Finalizar cierre');
            <?php else: ?>
              actaBtn.html('Continuar cierre');
            <?php endif; ?>
            actaBtn.attr("class", "btn btn-sm btn-primary pull-right");
            $(actaBtn).prop('disabled', true);
            test1.append(actaBtn);
            actaBtn.click(function(){
              console.log('finish!!');
              swal({
                      title: "Proceso irreversible",
                      text: "Una vez realizado el cierre, el sistema realizará ajustes sobre aquellos articulos que hayan reportado incongruencias con respecto al inventario físico y el sistema",
                      type: "warning",
                      showCancelButton: true,
                      confirmButtonText: "Continuar",
                      cancelButtonText: "Cancelar"
                  }).then(function(){

                    var close = $("#close");
                    var loadingIMG = $("<img>", {"class": "img-rounded", "style":"margin-left:15%;margin-top:15%;margin-bottom:15%;width:15%"});
                    loadingIMG.attr('src', '<?php echo base_url() ?>assets/img/Loaders/gears.svg');
                    close.html(loadingIMG);
                    $.ajax({
                        url:"<?php echo base_url() ?>inventario/cerrar",
                        type:"POST",
                        success: function(data)
                        {
                          // setTimeout(function ()
                          // {
                            console.log(data);
                            swal(
                              'Cierre exitoso',
                              'El proceso de cierre de inventario ha sido realizado con éxito',
                              'success'
                              ).then(function(){
                                //locura
                                var string = '<!DOCTYPE html>';
                                var pdf = $('<iframe/>');
                                pdf.attr('src', '<?php echo base_url() ?>inventario/generar/acta');
                                pdf.attr("width", "100%");
                                pdf.attr("height", "100%");
                                buildModal('pdfCierre', 'Actas Generadas', pdf, '', 'lg', '500');
                                // location.reload();
                              });
                          // }, 3000);
                        }
                      });
                  },function(dismiss){
                    if(dismiss=='cancel'){
                    swal(
                      'cancelado!',
                      'Se ha cancelado el proceso de Cierre, Los cambios no se han revertido, pero puede culminar este proceso en otro momento',
                      'error').then(function(){
                        location.reload();
                      })
                    }

                  });
              actaBtn.remove();
            })
            tablaEdit.on('xhr', function(e, settings, json)//para validar que lo que haya que justificar, esté justificado... Para crear las actas
            {
              // if(json.draw === 3)//solo para pruebas, BORRAR AL TERMINAR
              // {
              //   $(actaBtn).prop('disabled', false);
              // }
              if(json.POR_JUSTIFICAR === 0)//si no hay articulos incongruentes POR justificar...
              {
                //crear actas
                $(actaBtn).prop('disabled', false);
              }
            });
            // console.log(test1);
            test1.toggle("slow", function ()
            {
                if(test1.is(":hidden"))
                {
                  $('html, body').animate({
                    scrollTop: $('.header').offset().top
                  }, 500, "swing");
                  tablaEdit.DataTable().remove();
                  // tablaEdit.DataTable().clear();
                  // tablaEdit.DataTable().destroy();
                }
                else
                {
                  // if(test1.is(":hidden"))
                  if(test1.is(":visible"))
                  {
                    $('html, body').animate({
                      scrollTop: test1.offset().top
                    }, 500, "swing");
                  }
                }
            });
            function validateJustificate(X)
            {
              console.log(X);
            }
            // if(test1.is(":visible"))
            // test1.on('toggle', function()
            // {
              // console.log("toggle");
              // if(test1.is(":hidden"))
              // {
              //   $('html, body').animate({
              //     scrollTop: $('.header').offset().top
              //   }, 500, "swing");
              // }
              // else
              // {
              //   // if(test1.is(":hidden"))
              //   if(test1.is(":visible"))
              //   {
              //     $('html, body').animate({
              //       scrollTop: test1.offset().top
              //     }, 1500, "swing");
              //   }
              // }
            // });
            // var modal = buildModal('repInc', 'Incongruencias', test1, '', 'lg', '');
            // console.log(modal.length);
            // modal.on('hide.bs.modal', function(){
              // console.log("wtf!!!");
              // test1.toggle();
            // $('#incongruencias').after($("#divinco"));
            // });
            // test1.append(tablerep);
            //fin de construccion de la tabla
            // console.log(defColumnas);
            // console.log(attrColumnas);
            // console.log(tablerep);
            // var Modal = buildModal('repInc', 'Incongruencias', tablerep, '', 'lg', '');
            // var Modal = buildModal('repInc', 'Incongruencias', tablerep, '', 'lg', '');
          });
        <?php endif; ?>

        $('#showLastActa').on('click', function()//muestra las actas recientemente generadas
        {
          var string = '<!DOCTYPE html>';
          var pdf = $('<iframe/>');
          pdf.attr('src', '<?php echo base_url() ?>inventario/generar/acta');
          pdf.attr("width", "100%");
          pdf.attr("height", "100%");
          buildModal('pdfCierre', 'Actas Generadas', pdf, '', 'lg', '500');
          console.log($('#pdfCierre').length);
        });
    <?php endif;?>

    ///FIN revision de incongruencias
    <?php if(!empty($alm[10])):?>
    ////Edicion de codigos de articulos por excel
    	      var cambio = $("#excelART").fileinput({
    	          language:'es',
    	          showCaption: false,
    	          showUpload: false,
    	          showRemove: false,
    	          autoReplace: true,
    	          maxFileCount: 1,
    	          uploadUrl: "<?php echo base_url() ?>inventario/articulo/fromExcelFile/cambio_cod",
    	          previewFileType: "text",
    	          browseLabel: " Examinar...",
    	          browseIcon: '<i class="glyphicon glyphicon-file"></i>'
    	      });
    	      cambio.fileinput('enable');
    	      cambio.on('fileloaded', function(event, data, previewId, index){//evento antes de subir el archivo
    	        swal({
    	                title: "Proceso irreversible",
    	                text: "Recuerde que una vez suministrado el archivo, no se puede revertir el proceso",
    	                type: "warning",
    	                showCancelButton: true,
    	                confirmButtonText: "Continuar",
    	                cancelButtonText: "Cancelar"
    	            }).then(function(){
    	              cambio.fileinput('upload');
    	            },function(dismiss){
    	              if(dismiss=='cancel'){
    	              $('#excelART').fileinput('clear');
    	              swal(
    	                'cancelado!',
    	                'Se ha cancelado el proceso de subida del archivo',
    	                'error')
    	              }

    	            });
    	      });
    				cambio.on('fileuploaded', function(event, data, previewId, index){//evento de subida de archivo
    					// console.log(data.response);
    	        console.log("START!!!");
    					var aux = data.response;
    	        var ArtFile = $("#ArtFile");
    	        var loadingIMG = $("<img>", {"class": "img-rounded", "style":"margin-left:15%;margin-top:15%;margin-bottom:15%;width:15%"});
    	        loadingIMG.attr('src', '<?php echo base_url() ?>assets/img/Loaders/gears.svg');
    	        ArtFile.html(loadingIMG);
    	        // console.log("loadingimages: "+loadingIMG.length);
    	        var readExcel = $.post("<?php echo base_url() ?>inventario/articulo/cambioCod_excel", { //se le envia la data por post al controlador respectivo
    	                file: aux  //variable a enviar que contiene la direccion del archivo de excell que fue subido #375a7f  #0fa6bc
    	            }, function (data) {////aqui quedé
    	                console.log(data);
	    	            //version nueva
	    	            var response = $.parseJSON(data);
	    	            console.log(response);
	    	            if(response.status==='success')
	    	            {
	    	            	console.log(response.goodLines.length);
	    	            	console.log("Lineas insertadas");
	    	            }
	    	            if(response.status==='error')
	    	            {
	    	            	console.log(response.goodLines.length);
	    	            	console.log("Lineas insertadas.");
	    	            	console.log(response.badLines.length);
	    	            	console.log("Lineas ignoradas por errores.");

	    	            	console.log("NAAAT!");
	    	            }
    	            });
    	      });
    ////FIN de Edicion de codigos de articulos por excel
    <?php endif; ?>
    ////Adición de codigos de categorias por excel
            var categoria_input = $("#excelCAT").fileinput({
                language:'es',
                showCaption: false,
                showUpload: false,
                showRemove: false,
                autoReplace: true,
                maxFileCount: 1,
                uploadUrl: "<?php echo base_url() ?>inventario/articulo/fromExcelFile/insercionCategorias",
                previewFileType: "text",
                browseLabel: " Examinar...",
                browseIcon: '<i class="glyphicon glyphicon-file"></i>'
            });
            categoria_input.fileinput('enable');
            categoria_input.on('fileloaded', function(event, data, previewId, index){//evento antes de subir el archivo
              swal({
                      title: "Proceso irreversible",
                      text: "Recuerde que una vez suministrado el archivo, no se puede revertir el proceso",
                      type: "warning",
                      showCancelButton: true,
                      confirmButtonText: "Continuar",
                      cancelButtonText: "Cancelar"
                  }).then(function(){
                    categoria_input.fileinput('upload');
                  },function(dismiss){
                    if(dismiss=='cancel'){
                    $('#excelCAT').fileinput('clear');
                    swal(
                      'cancelado!',
                      'Se ha cancelado el proceso de subida del archivo',
                      'error')
                    }

                  });
            });
            categoria_input.on('fileuploaded', function(event, data, previewId, index){//evento de subida de archivo
              // console.log(data.response);
              console.log("START!!!");
              var aux = data.response;
              var CatFile = $("#CatFile");
              var loadingIMG = $("<img>", {"class": "img-rounded", "style":"margin-left:15%;margin-top:15%;margin-bottom:15%;width:15%"});
              loadingIMG.attr('src', '<?php echo base_url() ?>assets/img/Loaders/gears.svg');
              CatFile.html(loadingIMG);
              // console.log("loadingimages: "+loadingIMG.length);
              var readExcel = $.post("<?php echo base_url() ?>inventario/articulo/inputCat_excel", { //se le envia la data por post al controlador respectivo
                      file: aux  //variable a enviar que contiene la direccion del archivo de excell que fue subido #375a7f  #0fa6bc
                  }, function (data) {////aqui quedé
                      console.log(data);
                    //version nueva
                    var response = $.parseJSON(data);
                    console.log(response);
                    if(response.status==='success')
                    {
                      console.log(response.goodLines.length);
                      console.log("Lineas insertadas");
                    }
                    if(response.status==='error')
                    {
                      console.log(response.goodLines.length);
                      console.log("Lineas insertadas.");
                      console.log(response.badLines.length);
                      console.log("Lineas ignoradas por errores.");

                      console.log("NAAAT!");
                    }
                  });
            });
    ////FIN de Adición de codigos de categorias por excel
		});
///////FIN de para los procesos involucrados en el cierre de inventario

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