<script type="text/javascript">
    base_url = '<?php echo base_url()?>';
</script>

<script src="<?php echo base_url() ?>assets/js/jquery.min.js"></script>
<script type="text/javascript">
    base_url = '<?php echo base_url() ?>';
    $(document).ready(function () {
        //para usar dataTable en la table solicitudes
        var table = $('#ItemList').DataTable({
            "language": {
                "url": "<?php echo base_url() ?>assets/js/lenguaje_datatable/spanish.json"
            },
            "pagingType": "full_numbers", //se usa para la paginacion completa de la tabla
            "sDom": '<"top"lp<"clear">>rt<"bottom"ip<"clear">>', //para mostrar las opciones donde p=paginacion,l=campos a mostrar,i=informacion
            "order": [[1, "desc"]], //para establecer la columna a ordenar por defecto y el orden en que se quiere 
            "aoColumnDefs": [{"orderable": false, "targets": [0]}]//para desactivar el ordenamiento en esas columnas
        });

        $('#buscador').keyup(function () { //establece un un input para el buscador fuera de la tabla
            table.search($(this).val()).draw(); // escribe la busqueda del valor escrito en la tabla con la funcion draw
        });    
});    
</script>



<!-- Page content -->
<div class="mainy">
	<!-- Page title -->
	<div class="page-title">
		<h2><i class="fa fa-user color"></i> Items<small> De Mantenimiento Preventivo</small></h2> 
		<hr />
	</div>

	
          <!-- Page title -->
			<div class="row">
				<div class="col-md-12">
					<div class="awidget full-width">
						<div class="awidget-head">
							<h3>Lista de Items</h3>
								<a href="<?php echo base_url() ?>index.php/air_mntprvitm/itemmp/crear_item" class="btn btn-success" data-toggle="modal">Agregar Equipo</a>
								<a href="<?php echo base_url() ?>index.php/air_mntprvitm/itemmp/index" class="btn btn-info">Lista Items</a>
								<!--href="<?php echo base_url() ?>index.php/equipo/listar"-->
								<!-- Buscar equipo -->
								<div class="col-lg-6">
									<form id="ACquery" class="input-group form" action="<?php echo base_url() ?>index.php/air_mntprvitm/itemmp/index" method="post">
				                           <!-- Lo que esta comentado debajo es con el input antiguo de autocompletado -->
				                           <!-- <input id="autocomplete" type="search" name="item" class="form-control" placeholder="Codigo... o Descripcion...">
				                           <span class="input-group-btn">
				                           	<button type="submit" class="btn btn-info">
												<i class="fa fa-search"></i>
											</button>
				                           </span> -->
				                           <input type="text" id="buscador" class="form-control input-sm" style="width: 365px">
					                       <span class="input-group-addon" id="basic-addon2"><i class="fa fa-search"></i></span>
				                    </form>
			                	</div>
			                	<!-- fin de Buscar equipo -->

						</div>
						<?php if($this->session->flashdata('create_item') == 'success') : ?>
							<div class="alert alert-success" style="text-align: center">Item creado con éxito</div>
						<?php endif ?>
						<?php if($this->session->flashdata('edit_item') == 'success') : ?>
							<div class="alert alert-success" style="text-align: center">Item modificado con éxito</div>
						<?php endif ?>
						<?php if($this->session->flashdata('drop_item') == 'success') : ?>
							<div class="alert alert-success" style="text-align: center">Item Eliminado con éxito</div>
						<?php endif ?>
						<?php if($this->session->flashdata('drop_item') == 'error') : ?>
							<div class="alert alert-danger" style="text-align: center">Ocurrió un problema Eliminando el Item</div>
						<?php endif ?>
						<?php if($this->session->flashdata('activ_item') == 'success') : ?>
							<div class="alert alert-success" style="text-align: center">Item Activado con éxito</div>
						<?php endif ?>
						<?php if($this->session->flashdata('activ_item') == 'error') : ?>
							<div class="alert alert-danger" style="text-align: center">Ocurrió un problema Activando el Item</div>
						<?php endif ?>	
						<?php if($this->session->flashdata('edit_item') == 'error') : ?>
							<div class="alert alert-danger" style="text-align: center">Ocurrió un problema con la edición del Item</div>
						<?php endif ?>

						<?php if(empty($item)) : ?>
							<div class="alert alert-info" style="text-align: center">No se encontraron Items</div>
						<?php endif ?>
						<div class="awidget-body">
							<table id="ItemList" class="table table-hover table-bordered ">
								<thead>
									<tr>
									<th><a href="<?php echo base_url() ?>index.php/itemmp/orden/orden_codigo/<?php echo $order ?>">Codigo</a></th>
									<th><a href="<?php echo base_url() ?>index.php/itemmp/orden/orden_descripcion/<?php echo $order ?>">Descripcion</a></th>
									<th><a href="<?php echo base_url() ?>index.php/itemmp/orden/orden_status/<?php echo $order ?>">Estado en Sistema</a></th>
									<th style="text-align: center"><span class="label label-danger">O</span>Desactivar <span class="label label-info">I</span>Activar</th>
										
									</tr>
								</thead>
								<tbody>
									<?php if(!empty($item)) : ?>
										<?php foreach($item as $key => $equipo) : ?>
											<tr>
												<td>
													<a href="<?php echo base_url() ?>index.php/itemmp/detalle/<?php echo $equipo->id ?>">
														<?php echo $equipo->cod ?>
													</a>
												</td>
												<td><?php echo ucfirst($equipo->desc) ?></td>
																							
																								
														<?php if($equipo->status==1):?>
														<td style="text-align: center"><span class="label label-info"> Activado </span></td>
														<td style="text-align: center"><a href="<?php echo base_url() ?>index.php/itemmp/eliminar/<?php echo $equipo->id ?>">
															<span class="btn btn-danger">O</span>
														</a></td>
														<?php else: ?>
														
														<td style="text-align: center"><div class="label label-danger"> Desactivado </div></td>
														<td style="text-align: center"><a href="<?php echo base_url() ?>index.php/itemmp/activar/<?php echo $equipo->id ?>">
															<span class="btn btn-info">I</span>
														</a></td>

														<?php endif; ?>
					                             	
												
											</tr>
										<?php endforeach; ?>
									<?php endif ?>
								</tbody>
							</table>
							
						</div>
					</div>
				</div>
			</div>
			
			
	
</div>
<div class="clearfix"></div>