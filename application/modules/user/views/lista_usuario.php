<!-- Page content -->
<div class="mainy">
	<!-- Page title -->
	<div class="page-title">
		<h2><i class="fa fa-user color"></i> Lista<small> De Usuarios</small></h2> 
		<hr />
	</div>
	<!-- Page title -->
	<div class="row">
		<div class="col-md-12">
			<div class="awidget full-width">
				<div class="awidget-head">
					<h3>Tabla de usuarios</h3>
				</div>
				<?php if($this->session->flashdata('create_user') == 'success') : ?>
					<div class="alert alert-success" style="text-align: center">Usuario creado con éxito</div>
				<?php endif ?>
				<?php if($this->session->flashdata('drop_user') == 'success') : ?>
					<div class="alert alert-success" style="text-align: center">Usuario eliminado con éxito</div>
				<?php endif ?>
				<?php if($this->session->flashdata('drop_user') == 'error') : ?>
					<div class="alert alert-danger" style="text-align: center">Ocurrió un problema con la eliminación del usuario</div>
				<?php endif ?>
				<?php if($this->session->flashdata('edit_user') == 'success') : ?>
					<div class="alert alert-success" style="text-align: center">Usuario modificado con éxito</div>
				<?php endif ?>
				<?php if($this->session->flashdata('edit_user') == 'error') : ?>
					<div class="alert alert-danger" style="text-align: center">Ocurrió un problema con la edición del usuario</div>
				<?php endif ?>
				<div class="awidget-body">
					<table class="table table-hover table-bordered ">
						<thead>
							<tr>
							<th><a href="index.php/usuarios/ver/orden_CI/<?php echo $order ?>">Cedula</a></th>
							<th><a href="index.php/usuarios/ver/orden_nombre/<?php echo $order ?>">Nombre</a></th>
							<!-- <th>Farmacia</th> -->
							<th><a href="index.php/usuarios/ver/orden_tipousuario/<?php echo $order ?>">Tipo de usuario</a></th>
							<?php if($this->session->userdata('user')->sys_rol == 'autoridad') : ?>
								<th style="text-align: center">Eliminar</th>
							<?php endif ?>
							</tr>
						</thead>
						<tbody>
							<?php foreach($users as $key => $user) : ?>
								<tr>
									<td>
										<a href="<?php echo base_url() ?>index.php/usuario/detalle/<?php echo $user->id_usuario ?>">
											<?php echo $user->id_usuario ?>
										</a>
									</td>
									<td><?php echo $user->nombre.' '.$user->apellido ?></td>
									<!-- <td><?php echo $user->nombre_farmacia ?></td> -->
									<td><?php echo ucfirst($user->sys_rol) ?></td>
									<?php if($this->session->userdata('user')->sys_rol == 'autoridad') : ?>
										<td style="text-align: center">
											<a href="index.php/usuarios/eliminar/<?php echo $user->id_usuario ?>">
												<span class="label label-danger">X</span>
											</a>
										</td>
									<?php endif ?>
								</tr>
							<?php endforeach; ?>                                                                   
						</tbody>
					</table>
					<div class="clearfix"></div>
				</div>
			</div>
		</div>
	</div>
</div>
<div class="clearfix"></div>