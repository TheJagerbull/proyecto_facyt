<script src="<?php echo base_url() ?>assets/js/jquery.min.js"></script>
<script type="text/javascript">
    base_url = '<?php echo base_url() ?>';
    $(document).ready(function () {
        //para usar dataTable en la table solicitudes
        var table = $('#ListadoEquipos').DataTable({
            "language": {
                "url": "<?php echo base_url() ?>assets/js/lenguaje_datatable/spanish.json"
            },
            "pagingType": "full_numbers", //se usa para la paginacion completa de la tabla
            "sDom": '<"top"lp<"clear">>rt<"bottom"ip<"clear">>', //para mostrar las opciones donde p=paginacion,l=campos a mostrar,i=informacion
            "order": [[1, "desc"]], //para establecer la columna a ordenar por defecto y el orden en que se quiere 
            "aoColumnDefs": [{"orderable": false, "targets": [0]}]//para desactivar el ordenamiento en esas columnas
        });

        $('#buscador').keyup(function () { //establece un un input para el buscador fuera de la tabla
            table.search($(this).val()).draw(); // escribe la busqueda del valor escrito en la tabla con la funcion draw
        });    
});    
</script>

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
				                        <div class="control-group col col-lg-3 col-md-3 col-sm-3">
					                            <div class="input-group">
					                                <input type="text" class="form-control input-sm" style="width: 350px" id="buscador">
					                                <span class="input-group-addon" id="basic-addon2"><i class="fa fa-search"></i></span>
					                            </div>
					                    </div>
		                    		</div>   
			                    </div>

			                <div class="awidget-body">
								<table id="ListadoEquipos" class="table table-hover table-bordered ">
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
						
						</div>
					</div>
				</div>
			</div>
		
			
	
</div>
<div class="clearfix"></div>