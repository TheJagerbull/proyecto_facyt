<!-- Page content -->
<div class="mainy">
	<!-- Page title -->
	<div class="page-title">
		<h2><i class="fa fa-user color"></i> Inventario<small> De Equipos</small></h2> 
		<hr />
	</div>

	
          <!-- Page title -->
			<div class="row">
				<div class="col-md-12">
					<div class="awidget full-width">
						<div class="awidget-head">
							<h3>Listado de Equipos</h3>
								<a href="<?php echo base_url() ?>index.php/inv_equipos/equipos/nuevo_equipo" class="btn btn-success" data-toggle="modal">Agregar Equipo</a>
								<!-- Buscar usuario -->
								<div class="col-lg-6">
									<div class="input-group form">
				                           <input type="text" class="form-control" placeholder="N° Inventario... o Nombre...">
				                           <span class="input-group-btn">
				                             <button class="btn btn-info" type="button">Buscar</button>
				                           </span>
				                    </div>
			                	</div>

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
									<th><a href="<?php echo base_url() ?>index.php/itemmp/orden/orden_codigo/<?php //echo $order ?>">Nombre</a></th>
									<th><a href="<?php echo base_url() ?>index.php/itemmp/orden/orden_descripcion/<?php //echo $order ?>">Inv. UC</a></th>
									<th><a href="<?php echo base_url() ?>index.php/itemmp/orden/orden_status/<?php //echo $order ?>">Marca</a></th>
									<th><a href="<?php echo base_url() ?>index.php/itemmp/orden/orden_status/<?php //echo $order ?>">Modelo</a></th>
									<th><a href="<?php echo base_url() ?>index.php/itemmp/orden/orden_status/<?php //echo $order ?>">Tipo Equipo</a></th>
										
									</tr>
								</thead>
								<tbody>
									<?php if(!empty($equipos)) : ?>
										<?php foreach($equipos as $key => $equipo) : ?>
											<tr>
												<td>
													<a href="<?php echo base_url() ?>index.php/itemmp/detalle/<?php echo $equipo->id ?>">
														<?php echo $equipo->nombre ?>
													</a>
												</td>
												<td style="text-align: center"><?php echo $equipo->inv_uc ?> </td>
												<td style="text-align: center"><?php echo $equipo->marca ?> </td>
												<td style="text-align: center"><?php echo $equipo->modelo ?> </td>
												<td style="text-align: center"><?php echo $equipo->tipo_eq ?> </td>
												
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
		
			
	
</div>
<div class="clearfix"></div>