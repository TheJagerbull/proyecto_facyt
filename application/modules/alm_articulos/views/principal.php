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
	        "sAjaxSource": "alm_articulos/getTable",
	        "iDisplayLength": 10,
	        "aLengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
	        "aaSorting": [[0, 'asc']],
	        "aoColumns": [
			{ "bVisible": true, "bSearchable": true, "bSortable": true },
			{ "bVisible": true, "bSearchable": true, "bSortable": true },
			{ "bVisible": true, "bSearchable": true, "bSortable": true },
			{ "bVisible": true, "bSearchable": true, "bSortable": false }//la columna extra
	        ]
	}).fnSetFilteringDelay(700);
});
</script>
<div class="mainy">
	<div class="row">
       <!-- Page title -->
       <div class="page-title">
          <h2 align="right"><i class="fa fa-file color"></i> Articulos <small>de almacen</small></h2>
          <hr />
       </div>
       <!-- Page title -->

       	<div class="col-lg-12 col-md-12 col-sm-12">
                        
		    <div class="awidget full-width">
		       <div class="awidget-head">
		          <h3 class="color" >Operaciones sobre inventario de almacen</h3>
		       </div>
		       <div class="awidget-body col-lg-12 col-md-12 col-sm-12">
					<ul id="myTab" class="nav nav-tabs">
						<li class="active"><a href="#home" data-toggle="tab">Articulos del sistema</a></li>
						<li><a href="#ajustes" data-toggle="tab">Ajustes de articulos</a></li>
						<li><a href="#add" data-toggle="tab">Agregar articulos</a></li>
						<li><a href="#rep" data-toggle="tab">Reportes</a></li>
					</ul>
					<?php if(!empty($crap)){ echo_pre($crap); } ?>
					<div id="myTabContent" class="tab-content">
						<div id="home" class="tab-pane fade in active">
				               <!--  <table id="articulos" class="table table-hover table-bordered col-lg-12 col-md-12 col-sm-12">
				                      <thead>
				                        <tr>
				                          <th>Agregar</th>
				                          <th>Codigo</th>
				                          <th>Descripcion</th>
				                        </tr>
				                      </thead>
				                      <tbody>
				                      <?php foreach($inventario as $key => $item) : ?>
				                          <tr>
				                            <td align="center">
				                                <i style"color: #398439" class="fa fa-check"></i>
				                            </td>
				                            <td><a href="#Modal<?php echo $item->ID ?>" ><?php echo $item->cod_articulo ?></a></td>
				                            <td><?php echo $item->descripcion ?></td>
				                          </tr>
				                      <?php endforeach ?>
				                      </tbody>
				                </table> -->
				                <table id="data" class="table table-hover table-bordered col-lg-12 col-md-12 col-sm-12">
								    <thead>
								        <tr>
								            <th>ID</th>
								            <th>codigo</th>
								            <th>Descripcion</th>
								        	<th>Detalles</th>
								        </tr>
								    </thead>
								    <tbody></tbody>
								    <tfoot></tfoot>
								</table>
								<!-- <div id="ayudante<?php echo $sol['id_orden'] ?>" class="modal modal-message modal-info fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
						             <div class="modal-dialog">
						                 <div class="modal-content">
						                     <div class="modal-header">
						                         <h4 class="modal-title">Detalles</h4>
						                     </div>
						                     <div class="modal-body">
						                         <div>
						                             <h4><label>Solicitud Número: 
						                                     <?php echo $sol['id_orden'] ?>
						                                 </label></h4>
						                         </div>
						                         <div id='disponibles<?php echo $sol['id_orden'] ?>'>
						                             <!-- AQUI CONSTRULLE UNA LISTA DE AYUDANTES DISPONIBLES NO ASIGNADOS A LA ORDEN (revisar script mainFunctions.js linea 208 en adelante)-->
						                         </div>
						                         <div id='asignados<?php echo $sol['id_orden'] ?>'>
						                             <!-- AQUI CONSTRULLE UNA LISTA DE AYUDANTES ASIGNADOS A LA ORDEN (revisar script mainFunctions.js linea 208 en adelante)-->
						                         </div>

						                         <div class="modal-footer">
						                             <input form="ay<?php echo $sol['id_orden'] ?>" type="hidden" name="uri" value="<?php echo $this->uri->uri_string() ?>"/>
						                             <input form="ay<?php echo $sol['id_orden'] ?>" type="hidden" name="id_orden_trabajo" value="<?php echo $sol['id_orden'] ?>"/>
						                             <button form="ay<?php echo $sol['id_orden'] ?>" type="submit" class="btn btn-primary">Guardar cambios</button>

						                             <button type="button" class="btn btn-default" data-dismiss="modal" aria-hidden="true">Cancelar</button>
						                         </div>
						                     </div>
						                 </div>
						             </div> 
						        </div> -->
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
</div>