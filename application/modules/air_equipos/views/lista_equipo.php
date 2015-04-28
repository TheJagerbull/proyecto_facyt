<script type="text/javascript">
    base_url = '<?=base_url()?>';
</script>
<!-- Page content -->
<div class="mainy">
	<!-- Page title -->
	<div class="page-title">
		<h2><i class="fa fa-user color"></i> Control<small> De Equipos</small></h2> 
		<hr />
	</div>

	
          <!-- Page title -->
			<div class="row">
				<div class="col-md-12">
					<div class="awidget full-width">
						<div class="awidget-head">
							<h3>Lista de usuarios</h3>
								<a href="<?php echo base_url() ?>index.php/air_equipos/equipo/tipo_equipo" class="btn btn-success" data-toggle="modal">Agregar Equipo</a>
								<a href="<?php echo base_url() ?>index.php/equipo/listar" class="btn btn-info">Listar Equipo</a>
								<!--href="<?php echo base_url() ?>index.php/equipo/listar"-->
								<!-- Buscar equipo -->
								<div class="col-lg-6">
									<form id="ACquery" class="input-group form" action="<?php echo base_url() ?>index.php/air_equipos/equipo/lista_equipo" method="post">
				                           <input id="autocomplete" type="search" name="usuarios" class="form-control" placeholder="Codigo del Equipo... o Nombre...">
				                           <span class="input-group-btn">
				                           	<button type="submit" class="btn btn-info">
												<i class="fa fa-search"></i>
											</button>
				                           </span>
				                    </form>
			                	</div>
			                	<!-- fin de Buscar equipo -->

						</div>
						<?php if($this->session->flashdata('create_equipo') == 'success') : ?>
							<div class="alert alert-success" style="text-align: center">Equipo creado con éxito</div>
						<?php endif ?>
						<?php if($this->session->flashdata('edit_equipo') == 'success') : ?>
							<div class="alert alert-success" style="text-align: center">Equipo modificado con éxito</div>
						<?php endif ?>
						<?php if($this->session->flashdata('edit_equipo') == 'error') : ?>
							<div class="alert alert-danger" style="text-align: center">Ocurrió un problema con la edición del equipo</div>
						<?php endif ?>

						<?php if(empty($equipo)) : ?>
							<div class="alert alert-info" style="text-align: center">No se encontraron Equipos</div>
						<?php endif ?>
						<div class="awidget-body">
							<table class="table table-hover table-bordered ">
								<thead>
									<tr>
									<th><a href="<?php echo base_url() ?>index.php/usuario/orden/orden_CI/<?php echo $order ?>">Codigo del Equipo</a></th>
									<th><a href="<?php echo base_url() ?>index.php/usuario/orden/orden_nombre/<?php echo $order ?>">Nombre</a></th>
										<th><a href="<?php echo base_url() ?>index.php/usuario/orden/orden_status/<?php echo $order ?>">Estado en Sistema</a></th>
										<th style="text-align: center"><span class="label label-danger">O</span>Desactivar <span class="label label-info">I</span>Activar</th>
									<?php endif ?>
									</tr>
								</thead>
								<tbody>
									<?php if(!empty($equipo)) : ?>
										<?php foreach($equipo as $key => $equipo) : ?>
											<tr>
												<td>
													<a href="<?php echo base_url() ?>index.php/equipo/detalle/<?php echo $equipo->ID ?>">
														<?php echo $equipo->id ?>
													</a>
												</td>
												<td><?php echo ucfirst($equipo->nombre) ?></td>
																							
																									
														<?php if($user->status=='activo'):?>
														<td style="text-align: center"><span class="label label-info"> Activado </span></td>
														<td style="text-align: center"><a href="<?php echo base_url() ?>index.php/usuario/eliminar/<?php echo $user->ID ?>">
															<span class="btn btn-danger">O</span>
														</a></td>
														<?php endif;
														if($user->status=='inactivo'):?>
														<td style="text-align: center"><div class="label label-danger"> Desactivado </div></td>
														<td style="text-align: center"><a href="<?php echo base_url() ?>index.php/usuario/activar/<?php echo $user->ID ?>">
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