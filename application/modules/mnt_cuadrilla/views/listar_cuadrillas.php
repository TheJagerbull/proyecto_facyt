<script type="text/javascript">
    base_url = '<?=base_url()?>';
</script>
<!-- Page content -->
<div class="mainy">
	<!-- Page title -->
	<div class="page-title">
		<h2><i class="fa fa-user color"></i> Cuadrillas<small> De Mantenimiento</small></h2> 
		<hr />
	</div>

	
          <!-- Page title -->
			<div class="row">
				<div class="col-md-12">
					<div class="awidget full-width">
						<div class="awidget-head">
							<h3>Lista de Cuadrillas</h3>
								<a href="<?php echo base_url() ?>index.php/mnt_cuadrilla/crear_cuadrilla" class="btn btn-success" data-toggle="modal">Agregar Cuadrilla</a>
								<a href="<?php echo base_url() ?>index.php/mnt_cuadrilla/index" class="btn btn-info">Listar Cuadrillas</a>
								
								<!-- Buscar cuadrilla -->
								<div class="col-lg-6">
									<form id="ACquery" class="input-group form" action="<?php echo base_url() ?>index.php/mnt_cuadrilla/cuadrilla/index" method="post">
				                           <input id="autocomplete" type="search" name="item" class="form-control" placeholder="Nombre de cuadrila... ">
				                           <span class="input-group-btn">
				                           	<button type="submit" class="btn btn-info">
												<i class="fa fa-search"></i>
											</button>
				                           </span>
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
							<table class="table table-hover table-bordered ">
								<thead>
									<tr>
									<th><a href="<?php echo base_url() ?>index.php/mnt_cuadrilla/orden/orden_codigo/<?php echo $view ?>"> Codigo</a></th>
									<th><a href="<?php echo base_url() ?>index.php/mnt_cuadrilla/orden/orden_descripcion/<?php echo $view ?>">Nombre</a></th>
									</tr>
								</thead>
								<tbody>
									<?php if(!empty($item)) : ?>
										<?php foreach($item as $key => $equipo) : ?>
											<tr>
												<td>
													<a href="<?php echo base_url() ?>index.php/itemmp/detalle/<?php echo $equipo->id ?>">
														<?php echo $equipo->id ?>
													</a>
												</td>
												<td><?php echo ucfirst($equipo->cuadrilla) ?></td>
														
														<td style="text-align: center"><span class="label label-info"> Activado </span></td>
														<td style="text-align: center"><a href="<?php echo base_url() ?>index.php/cuadrilla/eliminar/<?php echo $equipo->id ?>">
															<span class="btn btn-danger">O</span>
														</a></td>		
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