<!--  Para hacer que funcione el autocompletado de la vista -->
<script type="text/javascript">
    base_url = '<?=base_url()?>';
</script>

<!-- Page content -->
<div class="mainy">
	<!-- Page title -->
	<div class="page-title">
		<h2 align="right"><i class="fa fa-user color"></i> Cuadrillas<small> Seleccione el código o nombre para detalles</small></h2> 
		<hr />
	</div>
<nav class="navbar navbar-default">
  <div class="container-fluid">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
      <a class="navbar-brand"><span class="glyphicon glyphicon-cog"></span></a>
    </div>

    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
      <ul class="nav navbar-nav">
        <li class="active"><a href="#">Listar <span class="sr-only">(current)</span></a></li>
        <li><a href="#">Agregar</a></li>
        <li><a href="#">Editar</a></li>
      </ul>
      <form class="navbar-form navbar-left" role="search">
        <div class="form-group">
          <input type="text" class="form-control" placeholder="Search">
        </div>
        <button type="submit" class="btn btn-default">Submit</button>
      </form>
      <ul class="nav navbar-nav navbar-right">
        <li><a href="#">Link</a></li>
        <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Dropdown <span class="caret"></span></a>
          <ul class="dropdown-menu">
            <li><a href="#">Action</a></li>
            <li><a href="#">Another action</a></li>
            <li><a href="#">Something else here</a></li>
            <li role="separator" class="divider"></li>
            <li><a href="#">Separated link</a></li>
          </ul>
        </li>
      </ul>
    </div><!-- /.navbar-collapse -->
  </div><!-- /.container-fluid -->
</nav>
	
          <!-- Page title -->
			<div class="row">
				<div class="col-md-12">
					<div class="awidget full-width">
						<div class="awidget-head">
							<h3>Lista de Cuadrillas</h3>
								<a href="<?php echo base_url() ?>index.php/mnt_cuadrilla/cuadrilla/crear_cuadrilla" class="btn btn-success" data-toggle="modal">Agregar Cuadrilla</a>
								
								
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
										
										<?php foreach($item as $key => $cuadrilla ) : ?>
											<tr>
												<td>
													<a href="<?php echo base_url() ?>index.php/mnt_cuadrilla/detalle/<?php echo $cuadrilla->id ?>">
														<?php echo $cuadrilla->id ?>
													</a>
												</td>
												<td><?php echo ($cuadrilla->cuadrilla) ?></td>
												
												<td><?php echo ($cuadrilla->nombre) ?></td>
												
																								
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