<script src="<?php echo base_url() ?>assets/js/jquery.min.js"></script>
<script>
$(document).ready(function() {
    $('#articulos').DataTable({
    });
});
    base_url = '<?=base_url()?>';

$(document).ready(function()
{
	$('#data').dataTable({
		"bProcessing": true,
	        "bServerSide": true,
	        "sServerMethod": "GET",
	        "sAjaxSource": "alm_articulos/getSystemWideTable",
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
    "bProcessing": true,
          "bServerSide": true,
          "sServerMethod": "GET",
          "sAjaxSource": "alm_articulos/getSystemWideTable/1",
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
      { "bVisible": true, "bSearchable": true, "bSortable": false }//la columna extra
          ]
  })
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
						<li class="active"><a href="#home" data-toggle="tab">Articulos del sistema</a></li>
						<li><a href="#active" data-toggle="tab">Inventario actual</a></li>
						<li><a href="#add" data-toggle="tab">Agregar articulos</a></li>
						<li><a href="#rep" data-toggle="tab">Reportes</a></li>
					</ul>
					<div id="myTabContent" class="tab-content">
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
            <!-- Articulos activos del sistema -->
						<div id="active" class="tab-pane fade">
							
              <table id="act-inv" class="table table-hover table-bordered col-lg-8 col-md-8 col-sm-8">
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
						<div id="add" class="tab-pane fade">
                            <div class="awidget-body">
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
	                                    <button id="check_inv" type="submit" class="btn btn-info">
	                                      <i class="fa fa-plus"></i>
	                                    </button>
	                                  </span>
	                              </form>
                              </div>

                              <!--onclick='ayudantes(<?php echo json_encode($art['ID']) ?>, ($("#disponibles<?php echo $art['ID'] ?>")), ($("#asignados<?php echo $art['ID'] ?>")))'-->
                              <div id="resultado"><!--aqui construllo lo resultante de la busqueda del articulo, para su adicion a inventario -->
                  <!-- Subida de archivo de excel para agregar articulos a inventario -->
                            <!-- <div class="form-group">
                                <?php echo form_open_multipart('alm_articulos/excel_to_DB');?>
                                <label class="control-label" for="excel">Tabla de articulos nuevos de Excel:</label>
                                  <input type="file" name="userfile" size="20" />
                                  <br />
                                  <input type="submit" value="upload" />
                                </form>
                            </div> -->
                            <div class="form-group">
                                <?php echo form_open_multipart('alm_articulos/excel_to_DB');?>
                                <label class="control-label" for="New_inventario">Tabla de articulos nuevos de Excel:</label>
                                <div class="input-group col-md-5">
                                    <input id="New_inventario" type="file" name="userfile">
                                </div>
                              </form>
                            </div>
                  <!-- FIN DE Subida de archivo de excel para agregar articulos a inventario -->
                              </div>

                            </div>
						</div>
						<div id="rep" class="tab-pane fade">
              <div class="awidget-body">
                <!--formulario para reporte -->
                  <div id="reporte-form">
                      <!--<div class="alert alert-warning" style="text-align: center">
                        Fecha del &uacute;ltimo cierre de inventario: <?php echo $fecha_ultReporte; ?></br>
                        Fecha del cierre de ejercicio fiscal: agosto 31</br>
                        Debe haber m&iacute;nimo 1 a&ntilde;o entre el &uacute;ltimo cierre y el actual
                      </div>-->
                      <div>
                        <label class="control-label" for="cierreIn" id="cierre_label">Cierre de inventario</label>
                        <div id="cierreIn" class="input-group" ><!-- boton de cierre de inventario -->
                          <div id='cierre_inv'>
                            <!--<?php echo form_open_multipart('alm_articulos/inv_cierre');?>-->
                  <!-- Subida de archivo de excel para cierre de inventario-->
                            <div class="form-group">
                                <label class="control-label" for="excel">Insertar archivo de Excel:</label>
                                <div class="input-group col-md-5">
                                    <input id="excel" type="file" name="userfile">
                                </div>
                            </div>
                  <!-- FIN DE Subida de archivo de excel para cierre de inventario-->
                  <!-- Subida de archivo de excel para agregar articulos a inventario -->
                            <!--<div class="form-group">
                                <?php echo form_open_multipart('alm_articulos/excel_to_DB');?>
                                <label class="control-label" for="excel">Tabla de articulos nuevos de Excel:</label>
                                  <input type="file" name="userfile" size="20" />
                                  <br />
                                  <input type="submit" value="upload" />
                                </form>
                            </div>-->
                  <!-- FIN DE Subida de archivo de excel para agregar articulos a inventario -->
                            <!--</form>-->
                          </div>
                          <!-- <button id="generarPdf" class="btn btn-info addon" data-toggle="modal" data-target="#reporte" disabled='true'>  <img src="<?php echo base_url() ?>assets/img/alm/report2.png" class="img-rounded" alt="bordes redondeados" width="20" height="20">  </button> -->
                        </div>
                        <!-- <div class="dropdown">
                          <label class="control-label" for="dropdownMenu1">Historial de cierres de inventario</label></br>
                          <button class="btn btn-default dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                            <img src="<?php echo base_url() ?>assets/img/alm/history2(2).png" class="img-rounded" alt="bordes redondeados" width="20" height="20">
                            <span class="caret"></span>
                          </button>
                          <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
                            <?php foreach ($cierres as $key => $value):?>
                              <li><a class="btn" onclick="generarHistorial('<?php echo $value;?>')" >Reporte del a&ntilde;o: <?php echo date('Y', $value);?> </a></li>
                            <?php endforeach; ?>
                          </ul>
                        </div> -->
                        <label class="control-label" for="reporteIn" id="reporte_label">Estado actual de inventario</label>
                        <div id="reporteIn" class="input-group" >
                          <button class="btn btn-info addon" data-toggle="modal" data-target="#reporte" id="generarPdf" disabled='true'>  <img src="<?php echo base_url() ?>assets/img/alm/report2.png" class="img-rounded" alt="bordes redondeados" width="20" height="20">  </button>
                        </div>
                          
                      </div>
                      <!-- <?php echo mdate("%d-%m-%Y", strtotime($fecha_min)); ?> -->
                  </div>
              <!-- <button class="btn btn-info btn" data-toggle="modal" data-target="#reporte">  <img src="<?php echo base_url() ?>assets/img/alm/report2.png" class="img-rounded" alt="bordes redondeados" width="25" height="30">  </button> -->
                <!--fin del formulario -->
                

              </div>
						</div>
					</div>
          <!-- Modal para iframe del pdf -->
                <div class="modal fade" id="reporte" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                  <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                      <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h4 class="modal-title" id="reporteLabel"></h4>
                      </div>
                      <div class="modal-body" style="height: 768px">
                          <iframe id="reporte_pdf" src="" width="100%" height="100%" frameborder="0" allowtransparency="true"></iframe>  
                      </div>
                      <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <!-- <button type="button" class="btn btn-primary">Save changes</button> -->
                      </div>
                    </div>
                    <!-- /.modal-content -->
                  </div>
                  <!-- /.modal-dialog -->
                </div>
                <!-- /.modal -->
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
    $(function(){
      // console.log('<?php echo form_open_multipart("alm_articulos/inv_cierre");?>');
      $("#excel").fileinput({
          showCaption: false,
          showUpload: false,
          showRemove: false,
          autoReplace: true,
          maxFileCount: 1,
          uploadUrl: 'alm_articulos/upload_excel',
          previewFileType: "text",
          browseLabel: " Examinar...",
          browseIcon: '<i class="glyphicon glyphicon-file"></i>'
      });
      $("#New_inventario").fileinput({
          showCaption: false,
          showRemove: false,
          autoReplace: true,
          maxFileCount: 1,
          previewFileType: "text",
          browseLabel: " Examinar...",
          browseIcon: '<i class="glyphicon glyphicon-file"></i>'
      });
      $("#excel").on('fileuploaded', function(event, data, previewId, index){
        console.log(data.response);
        var aux = data.response;
        $.post(base_url + "index.php/alm_articulos/alm_articulos/read_excel", { //se le envia la data por post al controlador respectivo
                file: aux  //variable a enviar
            }, function (data) {
                console.log(data);
              $('#reporte_pdf').html(data);
              $('#reporte').modal('show');

            });
      });
    });
    function generarHistorial(year){
      console.log(year);
      //formato de src para iframe <?php echo base_url()?>/uploads/cierres/2015-12-22.pdf
      $('#reporte_pdf').attr("src", "alm_articulos/pdf_cierreInv/"+year);
      $('#reporte').modal('show');
    };


    $(function(){//boton del cierre del ano fiscal de inventario
        var desde = new Date();//el valor es el 1 de diciembre del agno actual
        desde.setMonth(11);
        desde.setDate(1);
        desde.setHours(00);
        desde.setMinutes(00);
        desde.setSeconds(1);
        var hasta = new Date();//el valor es el 31 de diciembre del agno actual
        hasta.setMonth(11);
        hasta.setDate(31);
        hasta.setHours(23);
        hasta.setMinutes(59);
        hasta.setSeconds(59);
        var hoy = new Date();//el valor es "hoy"
        // hoy.getTime();
  //para pruebas
              hoy.setMonth(11);
              hoy.setDate(22);
              hoy.setHours(23);
              hoy.setMinutes(59);
              hoy.setSeconds(59);
  //fin de prueba
        desde=Date.parse(desde);
        hasta=Date.parse(hasta);
        hoy=Date.parse(hoy);

        console.log(desde);
        console.log(hasta);
        console.log(hoy);

        if((desde < hoy) && (hoy < hasta))
        {
          console.log("Listo para realizar cierre");
          $('#generarPdf').removeAttr('disabled');
        }
        else
        {
          console.log("No esta listo para realizar cierre");
          $('#generarPdf').attr('disabled', 'disabled');
        }
    });

    $(function() {
      // $('input[name="cierre"]').daterangepicker({
      //   format: 'DD-MM-YYYY',
      //   singleDatePicker: true,
      //   showDropdowns: true,
      //   maxDate: moment()
      // }, 
      // function(start, end, label) {
      //   $('#cierre span').html(end);
      // }),
      $('#generarPdf').click(function(){
        var hoy = new Date();//el valor es "hoy"
        // hoy.getTime();
          //para pruebas
                      // hoy.setMonth(11);
                      // hoy.setDate(22);
                      // hoy.setHours(23);
                      // hoy.setMinutes(59);
                      // hoy.setSeconds(59);
          //fin de prueba
        // hoy=Date.parse(hoy)/1000;
        // console.log(hoy);
          $('#reporte_pdf').attr("src", "alm_articulos/pdf_cierreInv");
      });
    });

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