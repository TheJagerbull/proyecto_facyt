<script type="text/javascript">
    base_url = '<?=base_url()?>';
</script>
<!-- Page content -->
<div class="mainy">
	<!-- Page title -->
	<div class="page-title">
		<h2 align="right"><i class="fa fa-user color"></i> Control<small> De Usuarios</small></h2> 
		<hr />
	</div>

	
          <!-- Page title -->
			<div class="row">
				<div class="col-md-12">
					<div class="awidget full-width">
						<div class="awidget-head">
							<h3>Lista de usuarios</h3>
								<a href="<?php echo base_url() ?>index.php/user/usuario/crear_usuario" class="btn btn-success" data-toggle="modal">Agregar Usuario</a>
								<a href="<?php echo base_url() ?>index.php/usuario/listar" class="btn btn-info">Listar Usuarios</a>
								<!--href="<?php echo base_url() ?>index.php/usuario/listar"-->
								<!-- Buscar usuario -->
								<div class="col-lg-6">
									<form id="ACquery" class="input-group form" action="<?php echo base_url() ?>index.php/usuario/listar/buscar" method="post">
				                           <input id="autocomplete" type="search" name="usuarios" class="form-control" placeholder="Cedula... o Nombre... o Apellido...">
				                           <span class="input-group-btn">
				                           	<button type="submit" class="btn btn-info">
												<i class="fa fa-search"></i>
											</button>
				                           </span>
				                    </form>
			                	</div>
			                	<!-- fin de Buscar usuario -->

						</div>
						<?php if($this->session->flashdata('create_user') == 'success') : ?>
							<div class="alert alert-success" style="text-align: center">Usuario creado con éxito</div>
						<?php endif ?>
						<?php if($this->session->flashdata('drop_user') == 'success') : ?>
							<div class="alert alert-success" style="text-align: center">Usuario Desactivado con éxito</div>
						<?php endif ?>
						<?php if($this->session->flashdata('drop_user') == 'error') : ?>
							<div class="alert alert-danger" style="text-align: center">Ocurrió un problema Desactivando al usuario</div>
						<?php endif ?>
						<?php if($this->session->flashdata('edit_user') == 'success') : ?>
							<div class="alert alert-success" style="text-align: center">Usuario modificado con éxito</div>
						<?php endif ?>
						<?php if($this->session->flashdata('edit_user') == 'error') : ?>
							<div class="alert alert-danger" style="text-align: center">Ocurrió un problema con la edición del usuario</div>
						<?php endif ?>
						<!--activate_user-->
						<?php if($this->session->flashdata('activate_user') == 'success') : ?>
							<div class="alert alert-success" style="text-align: center">Usuario Activado con éxito</div>
						<?php endif ?>
						<?php if($this->session->flashdata('activate_user') == 'error') : ?>
							<div class="alert alert-danger" style="text-align: center">Ocurrió un problema con la activacion del usuario</div>
						<?php endif ?>
						<?php if(empty($users)) : ?>
							<div class="alert alert-info" style="text-align: center">No se encontraron Usuarios</div>
						<?php endif ?>
						<div class="awidget-body">

							<!-- <ul class="pagination pagination-sm">
							  <li><a href="#">1</a></li>
							  <li><a href="#">2</a></li>
							  <li><a href="#">3</a></li>
							  <li><a href="#">4</a></li>
							  <li><a href="#">5</a></li>
							</ul> -->
							<?php echo $links; ?>
							
							<table class="table table-hover table-bordered ">
								<thead>
									<tr>
									<th><a href="<?php echo base_url() ?>index.php/usuario/orden/<?php if($this->uri->segment(3)=='buscar') echo 'buscar/'; ?>orden_CI/<?php echo $order ?>/0">Cedula</a></th>
									<th><a href="<?php echo base_url() ?>index.php/usuario/orden/<?php if($this->uri->segment(3)=='buscar') echo 'buscar/'; ?>orden_nombre/<?php echo $order ?>/0">Nombre</a></th>
									<th><a href="<?php echo base_url() ?>index.php/usuario/orden/<?php if($this->uri->segment(3)=='buscar') echo 'buscar/'; ?>orden_tipousuario/<?php echo $order ?>/0">Rol En Sistema</a></th>
									<?php if($this->session->userdata('user')['sys_rol'] == 'autoridad' || $this->session->userdata('user')['sys_rol'] == 'asist_autoridad') : ?>
										<th><a href="<?php echo base_url() ?>index.php/usuario/orden/<?php if($this->uri->segment(3)=='buscar') echo 'buscar/'; ?>orden_status/<?php echo $order ?>/0">Estado en Sistema</a></th>
										<th style="text-align: center"><span class="label label-danger">O</span>Desactivar <span class="label label-info">I</span>Activar</th>
									<?php endif ?>
									</tr>
								</thead>
								<tbody>
									<?php if(!empty($users)) : ?>
										<?php foreach($users as $key => $user) : ?>
											<tr>
												<td>
													<a href="<?php echo base_url() ?>index.php/usuario/detalle/<?php echo $user->ID ?>">
														<?php echo $user->id_usuario ?>
													</a>
												</td>
												<td><?php echo ucfirst($user->nombre).' '.ucfirst($user->apellido) ?></td>
												<?php 
												switch($user->sys_rol)
												{
													case 'autoridad':
														echo '<td>Autoridad</td>';
													break;
													case 'asist_autoridad':
														echo '<td>Asistente de Autoridad</td>';
													break;
													case 'jefe_alm':
														echo '<td>Jefe de Almacen</td>';
													break;
													case 'director_dep':
														echo '<td>Director de Departamento</td>';
													break;
													case 'asistente_dep':
														echo '<td>Asistente de Departamento</td>';
													break;
													case 'ayudante_alm':
														echo '<td>Ayudante de Almacen</td>';
													break;
												}?>
												
												<?php if($this->session->userdata('user')['sys_rol'] == 'autoridad' || $this->session->userdata('user')['sys_rol'] == 'asist_autoridad') : ?>
													<!-- <td style="text-align: center"><?php echo ucfirst($user->status) ?></td> -->
													
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
							<!-- <ul class="pagination pagination-sm">
								  <li><a href="#">1</a></li>
								  <li><a href="#">2</a></li>
								  <li><a href="#">3</a></li>
								  <li><a href="#">4</a></li>
								  <li><a href="#">5</a></li>
							</ul> -->
							<?php echo $links; ?>
							<div class="clearfix"></div>
						</div>
					</div>
				</div>
			</div>
			<!-- CREAR USUARIO -->
			
	
</div>
<div class="clearfix"></div>