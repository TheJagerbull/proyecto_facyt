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
			{ "bVisible": true, "bSearchable": true, "bSortable": true },
			{ "bVisible": true, "bSearchable": true, "bSortable": true },
			{ "bVisible": true, "bSearchable": true, "bSortable": true },
			{ "bVisible": true, "bSearchable": true, "bSortable": false }//la columna extra
	        ]
	}).fnSetFilteringDelay(700);
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
		          <h3 class="color" >Operaciones sobre inventario de almacen</h3>
		       </div>
		       <div class="awidget-body">
					<ul id="myTab" class="nav nav-tabs">
						<li class="active"><a href="#home" data-toggle="tab">Articulos del sistema</a></li>
						<li><a href="#ajustes" data-toggle="tab">Ajustes de articulos</a></li>
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
						<div id="ajustes" class="tab-pane fade">
							<p></p>
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
                              </div>

                            </div>
						</div>
						<div id="rep" class="tab-pane fade">
							<p></p>
						</div>
					</div>
				</div>
			</div>
	</div>
</div>
<script type="text/javascript">
	// $("#imagen").fileinput({
	// 	showCaption: false,
 //        browseClass: "btn btn-primary btn-sm"
 //    });
    function validateNumber(x)
    {
        var numb = /[^A-Za-z]+[0-9]$/;
        var aux = document.getElementById(x);
        	console.log(aux.value);
        if(numb.test(aux.value))
        {
        	// console.log(aux.value);
          aux.style.background ='#DFF0D8';
          aux.innerHTML = aux.innerHTML + "";
          // document.getElementById('numero_msg').innerHTML = "";
          return true;
        }
        else
        {
          document.getElementById(x).style.background ='#F2DEDE';
          document.getElementById(x).innerHTML = document.getElementById(x).innerHTML + "<span class='label label-danger'> Debe ser un numero</span>";
          // document.getElementById('numero_msg').innerHTML = "Debe ser un numero";
          return false;
        }
    }
    function validateRealNumber(x)
    {
        var real = /[0-9]+/;
        if(real.test(document.getElementById(x).value))
        {
          document.getElementById(x).style.background ='#DFF0D8';
          document.getElementById('numero_msg').innerHTML = "";
          return true;
        }
        else
        {
          document.getElementById(x).style.background ='#F2DEDE';
          document.getElementById('numero_msg').innerHTML = "Debe ser un numero";
          return false;
        }
    }
</script>