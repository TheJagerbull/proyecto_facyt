<script type="text/javascript">
    base_url = '<?=base_url()?>';
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
								<a href="<?php echo base_url() ?>index.php/air_mntprvitm/itemmp/nuevoi" class="btn btn-success" data-toggle="modal">Agregar Equipo</a>
								<a href="<?php echo base_url() ?>index.php/air_mntprvitm/itemmp/index" class="btn btn-info">Lista Items</a>
								<!--href="<?php echo base_url() ?>index.php/equipo/listar"-->
								<!-- Buscar equipo -->
								<div class="col-lg-6">
									<form id="ACquery" class="input-group form" action="<?php echo base_url() ?>index.php/air_mntprvitm/itemmp/index" method="post">
				                           <input id="autocomplete" type="search" name="item" class="form-control" placeholder="Codigo... o Descripcion...">
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
														s
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