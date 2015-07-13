<script src="<?php echo base_url() ?>assets/js/jquery.min.js"></script>
<script>
$(document).ready(function() {
    $('#articulos').DataTable({
    });
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

       	<div class="col-md-12">
                        
		    <div class="awidget full-width">
		       <div class="awidget-head">
		          <h3 class="color" >Operaciones sobre inventario de almacen</h3>
		       </div>
		       <div class="awidget-body">
					<ul id="myTab" class="nav nav-tabs">
						<li class="active"><a href="#home" data-toggle="tab">Principal</a></li>
						<li><a href="#ajustes" data-toggle="tab">Ajustes de articulos</a></li>
						<li><a href="#add" data-toggle="tab">Agregar articulos</a></li>
						<li><a href="#rep" data-toggle="tab">Reportes</a></li>
					</ul>
					<div id="myTabContent" class="tab-content">
						<div id="home" class="tab-pane fade in active">
							
				                <table id="articulos" class="table table-hover table-bordered">
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
</div>