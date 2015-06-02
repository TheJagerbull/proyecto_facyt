<!--  Para hacer que funcione el autocompletado de la vista -->
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
								
								
								<!-- Buscar cuadrilla -->
								<div class="col-lg-6">
									<form id="ACquery4" class="input-group form" action="<?php echo base_url() ?>index.php/mnt_cuadrilla/cuadrilla/index" method="post">
				                           <input id="autocomplete_cuadrilla" type="search" name="item" class="form-control" placeholder="Nombre de cuadrila... ">
				                           <span class="input-group-btn">
				                           	<button type="submit" class="btn btn-info">
												<i class="fa fa-search"></i>
											</button>
				                           </span>
				                    </form>
			                	</div>
			                	<!-- fin de Buscar cuadrilla -->

						</div>
						<?php if($this->session->flashdata('create_item') == 'success') : ?>
							<div class="alert alert-success" style="text-align: center">Cuadrilla creada con éxito</div>
						<?php endif ?>
						<?php if($this->session->flashdata('edit_item') == 'success') : ?>
							<div class="alert alert-success" style="text-align: center">Cuadrilla modificada con éxito</div>
						<?php endif ?>
						<?php if($this->session->flashdata('drop_item') == 'success') : ?>
							<div class="alert alert-success" style="text-align: center">Cuadrilla eliminada con éxito</div>
						<?php endif ?>
						<?php if($this->session->flashdata('drop_item') == 'error') : ?>
							<div class="alert alert-danger" style="text-align: center">Ocurrió un problema eliminando la cuadrilla</div>
						<?php endif ?>
						<?php if($this->session->flashdata('edit_item') == 'error') : ?>
							<div class="alert alert-danger" style="text-align: center">Ocurrió un problema con la edición de la cuadrilla</div>
						<?php endif ?>

						<?php if(empty($item)) : ?>
							<div class="alert alert-info" style="text-align: center">No se encontraron cuadrillas</div>
						<?php endif ?>
						<div class="awidget-body">
							<table class="table table-hover table-bordered ">
								<thead>
									<tr>
									<th><a href="<?php echo base_url() ?>index.php/mnt_cuadrilla/orden/orden_codigo/<?php echo $view ?>"> Codigo</a></th>
									<th><a href="<?php echo base_url() ?>index.php/mnt_cuadrilla/orden/orden_nombre/<?php echo $view ?>">Nombre</a></th>
									<th><a href="<?php echo base_url() ?>index.php/mnt_cuadrilla/orden/orden_responsable/<?php echo $view ?>">Responsable</a></th>
									</tr>
								</thead>
								<tbody>
									<?php if(!empty($item)) : ?>
										<?php foreach($item as $key => $cuadrilla) : ?>
											<tr>
												<td>
													<a href="<?php echo base_url() ?>index.php/mnt_cuadrilla/detalle/<?php echo $cuadrilla->id ?>">
														<?php echo $cuadrilla->id ?>
													</a>
												</td>
												<td><?php echo ucfirst($cuadrilla->cuadrilla) ?></td>
												<td style="text-align: center">
													<a>
													</a>
												</td>		
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