<script type="text/javascript">
    base_url = '<?php echo base_url()?>';
</script>

<script src="<?php echo base_url() ?>assets/js/jquery.min.js"></script>
<script type="text/javascript">
    base_url = '<?php echo base_url() ?>';
    $(document).ready(function () {
        //para usar dataTable en la table solicitudes
        var table = $('#TypeList').DataTable({
            "language": {
                "url": "<?php echo base_url() ?>assets/js/lenguaje_datatable/spanish.json"
            },
            "pagingType": "full_numbers", //se usa para la paginacion completa de la tabla
            "sDom": '<"top"lp<"clear">>rt<"bottom"ip<"clear">>', //para mostrar las opciones donde p=paginacion,l=campos a mostrar,i=informacion
            "order": [[1, "desc"]], //para establecer la columna a ordenar por defecto y el orden en que se quiere 
            "aoColumnDefs": [{"orderable": false, "targets": [0]}]//para desactivar el ordenamiento en esas columnas
        });

        $('#searchinput').keyup(function () { //establece un un input para el buscador fuera de la tabla
            table.search($(this).val()).draw(); // escribe la busqueda del valor escrito en la tabla con la funcion draw
        });    
});    
</script>


<!-- Page content -->
<div class="mainy">
	<!-- Page title -->
	<div class="page-title">
		<h2><i class="fa fa-desktop color"></i> Tipos de Equipos<small> Consulte, agregue, modifique o elimine un equipo.</small></h2> 
		<hr />
	</div>

	
          <!-- Page title -->
			<div class="row">
				<div class="col-md-12">
					<div class="awidget full-width">
						<div class="awidget-head">
							<h3>Lista de Equipos</h3>
								<a href="<?php echo base_url() ?>index.php/air_tipoeq/tipoeq/nuevo_tipo" class="btn btn-success" data-toggle="modal">Agregar Equipo</a>
								<a href="<?php echo base_url() ?>index.php/air_tipoeq/tipoeq/index" class="btn btn-info">Lista de Equipos</a>
								<!--href="<?php echo base_url() ?>index.php/equipo/listar"-->
								<!-- Buscar equipo -->
								<div class="col-lg-6">
									<form id="ACquery" class="input-group form" action="<?php echo base_url() ?>index.php/air_tipoeq/tipoeq/index" method="post">
				                           <input id="searchinput"  type="search" name="tipo" class="form-control" placeholder="Codigo... o Descripcion...">
				                           
				                           
				                           <!-- Inputtext y Boton antiguo para buscar (verde)
				                           <input id="autocomplete"  type="search" name="tipo" class="form-control" placeholder="Codigo... o Descripcion...">
				                                <span class="input-group-btn">
				                           	<button type="submit" class="btn btn-info">
												<i class="fa fa-search"></i>
											</button>
				                           </span> 
				                           -->

				                           <span class="input-group-addon" id="basic-addon2"><i class="fa fa-search"></i></span>
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
							<table id="TypeList" class="table table-hover table-bordered ">
								<thead>
									<tr>
									<th><a href="<?php echo base_url() ?>index.php/tipoeq/orden/orden_codigo/<?php echo $order ?>">Codigo</a></th>
									<th><a href="<?php echo base_url() ?>index.php/tipoeq/orden/orden_descripcion/<?php echo $order ?>">Descripcion</a></th>
									<th style="text-align: center"><span class="label label-danger">X</span>Eliminar</th>
									<!--<th style="text-align: center">Generar Pdf</th>-->
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
												<td style="text-align: center"><a href="<?php echo base_url() ?>index.php/tipoeq/eliminar/<?php echo $tipo->id ?>">
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