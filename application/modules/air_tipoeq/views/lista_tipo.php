<script type="text/javascript">
    base_url = '<?=base_url()?>';
</script>
<!-- Page content -->
<div class="mainy">
	<!-- Page title -->
	<div class="page-title">
		<h2><i class="fa fa-user color"></i> Tipo<small> De Equipos</small></h2> 
		<hr />
	</div>

	
          <!-- Page title -->
			<div class="row">
				<div class="col-md-12">
					<div class="awidget full-width">
						<div class="awidget-head">
							<h3>Lista de usuarios</h3>
								<a href="<?php echo base_url() ?>index.php/air_tipoeq/tipoeq/nuevot" class="btn btn-success" data-toggle="modal">Agregar Tipo</a>
								<a href="<?php echo base_url() ?>index.php/air_tipoeq/tipoeq/index" class="btn btn-info">Lista de Equipos</a>
								<!--href="<?php echo base_url() ?>index.php/equipo/listar"-->
								<!-- Buscar equipo -->
								<div class="col-lg-6">
									<form id="ACquery" class="input-group form" action="<?php echo base_url() ?>index.php/air_tipoeq/tipoeq/index" method="post">
				                           <input id="autocomplete" type="search" name="tipo" class="form-control" placeholder="Codigo... o Descripcion...">
				                           <span class="input-group-btn">
				                           	<button type="submit" class="btn btn-info">
												<i class="fa fa-search"></i>
											</button>
				                           </span>
				                    </form>
			                	</div>
			                	<!-- fin de Buscar tipo -->

						</div>
						<?php if($this->session->flashdata('create_tipo') == 'success') : ?>
							<div class="alert alert-success" style="text-align: center">Tipo de equipo creado con éxito</div>
						<?php endif ?>
						<?php if($this->session->flashdata('edit_tipo') == 'success') : ?>
							<div class="alert alert-success" style="text-align: center">Tipo de equipo modificado con éxito</div>
						<?php endif ?>
						<?php if($this->session->flashdata('drop_tipo') == 'success') : ?>
							<div class="alert alert-success" style="text-align: center">Tipo de equipo Eliminado con éxito</div>
						<?php endif ?>
						<?php if($this->session->flashdata('drop_tipo') == 'error') : ?>
							<div class="alert alert-danger" style="text-align: center">Ocurrió un problema Eliminando el tipo</div>
						<?php endif ?>
						<?php endif ?>
						<?php if($this->session->flashdata('edit_tipo') == 'error') : ?>
							<div class="alert alert-danger" style="text-align: center">Ocurrió un problema con la edición del tipo</div>
						<?php endif ?>

						<?php if(empty($tipo)) : ?>
							<div class="alert alert-info" style="text-align: center">No se encontro ningun tipo</div>
						<?php endif ?>
						<div class="awidget-body">
							<table class="table table-hover table-bordered ">
								<thead>
									<tr>
									<th><a href="<?php echo base_url() ?>index.php/tipoeq/orden/orden_codigo/<?php echo $order ?>">Codigo</a></th>
									<th><a href="<?php echo base_url() ?>index.php/tipoeq/orden/orden_descripcion/<?php echo $order ?>">Descripcion</a></th>
										<th><a href="<?php echo base_url() ?>index.php/tipoeq/orden/orden_status/<?php echo $order ?>">Estado en Sistema</a></th>
										<th style="text-align: center"><span class="label label-danger">O</span>Desactivar <span class="label label-info">I</span>Activar</th>
									<?php endif ?>
									</tr>
								</thead>
								<tbody>
									<?php if(!empty($tipo)) : ?>
										<?php foreach($tipo as $key => $tipo) : ?>
											<tr>
												<td>
													<a href="<?php echo base_url() ?>index.php/tipoeq/detalle/<?php echo $tipo->id ?>">
														<?php echo $tipo->cod ?>
													</a>
												</td>
												<td><?php echo ucfirst($tipo->desc) ?></td>
																							
																									
														<?php if($tipo->status=='activo'):?>
														<td style="text-align: center"><span class="label label-info"> Activado </span></td>
														<td style="text-align: center"><a href="<?php echo base_url() ?>index.php/tipoeq/eliminar/<?php echo $tipo->id ?>">
															<span class="btn btn-danger">O</span>
														</a></td>
														<?php else: ?>
														s
														<td style="text-align: center"><div class="label label-danger"> Desactivado </div></td>
														<td style="text-align: center"><a href="<?php echo base_url() ?>index.php/tipoeq/activar/<?php echo $tipo->id ?>">
															<span class="btn btn-info">I</span>
														</a></td> 

														<?php endif; ?>
					                             	
												<?php endif ?> 
											</tr>
										<?php endforeach; ?>
									<?php endif ?>
								</tbody>
							</table>
							<div class="clearfix"></div>
						</div>
					</div>
				</div>
			</div>
			<!-- CREAR USUARIO -->
			
	
</div>
<div class="clearfix"></div>