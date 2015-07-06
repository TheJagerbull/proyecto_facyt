<script type="text/javascript">
    base_url = '<?=base_url()?>';
</script>
<!-- Page content -->
<div class="mainy">
	<!-- Page title -->
	<div class="page-title">
		<h2><i class="fa fa-desktop color"></i> Lista de Controles<small> Consulte, agregue, modifique o elimine un control.</small></h2> 
		<hr />
	</div>

	
          <!-- Page title -->
			<div class="row">
				<div class="col-md-12">
					<div class="awidget full-width">
						<div class="awidget-head">
							<h3>Lista de Equipos</h3>
								<a href="<?php echo base_url() ?>index.php/air_cntrl_mp_equipo/cntrlmp/crear_cntrl" class="btn btn-success" data-toggle="modal">Agregar Control</a>
								<a href="<?php echo base_url() ?>index.php/air_cntrl_mp_equipo/cntrlmp/index" class="btn btn-info">Lista de Controles</a>
								<!--href="<?php echo base_url() ?>index.php/equipo/listar"-->
								<!-- Buscar equipo -->
								<div class="col-lg-6">
									<form id="ACquery" class="input-group form" action="<?php echo base_url() ?>index.php/air_cntrl_mp_equipo/cntrlmp/index" method="post">
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
									<th><a href="<?php echo base_url() ?>index.php/cntrlmnt/orden/id/<?php echo $order ?>">ID</a></th>
									<th><a href="<?php echo base_url() ?>index.php/cntrlmnt/orden/orden_id_inv_equipo/<?php echo $order ?>">Equipo</a></th>
									<th><a href="<?php echo base_url() ?>index.php/tcntrlmnt/orden/orden_codigo/<?php echo $order ?>">Dependencia</a></th>
									<th><a href="<?php echo base_url() ?>index.php/cntrlmnt/orden/orden_descripcion/<?php echo $order ?>">Ubicai&oacute;n</a></th>
									<th><a href="<?php echo base_url() ?>index.php/cntrlmnt/orden/orden_fecha_mp/<?php echo $order ?>">Fecha Mantenimiento</a></th>
									<th style="text-align: center"><span class="label label-danger">X</span>Eliminar</th>
									<!--<th style="text-align: center">Generar Pdf</th>-->
									</tr>
								</thead>
								<tbody>
									<?php if(!empty($control)) : ?>
										<?php foreach($control as $key => $tipo) : ?>
											<tr>
												<td>
													<a href="<?php echo base_url() ?>index.php/cntrlmnt/detalle/<?php echo $tipo->id ?>">
														<?php echo $tipo->id ?>
													</a>
												</td>
												<td><?php echo ucfirst($tipo->id_inv_equipo) ?></td>
												<td><?php echo ucfirst($tipo->id_dec_dependencia) ?></td>
												<td><?php echo ucfirst($tipo->id_mnt_ubicaciones_dep) ?></td>
												<td><?php echo ucfirst($tipo->fecha_mp) ?></td>
												<td style="text-align: center"><a href="<?php echo base_url() ?>index.php/cntrlmnt/eliminar/<?php echo $tipo->id ?>">
												<span class="btn btn-danger">X</span></a>

													</td>	

														
														
					                            	
												
											</tr>
										<?php endforeach ?>
									<?php endif ?>
								</tbody>
							</table>
							
						</div>
					</div>
				</div>
			</div>
			
			
	
</div>
<div class="clearfix"></div>