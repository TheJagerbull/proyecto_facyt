y<script src="<?php echo base_url() ?>assets/js/jquery.min.js"></script>
<script>
$(document).ready(function() {
    $('#articulos').DataTable({
    });
});

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
							<p></p>
						</div>
						<div id="rep" class="tab-pane fade">
							<p></p>
						</div>
					</div>
				</div>
			</div>
	</div>
</div>