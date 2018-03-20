<!--PARA PROBAR LA CARGA DE VISTA A TRAVEZ DE MODAL -->
	<div class="full-width">
		<div class="panel" style="border-radius: 10px;">
            <div class="panel-heading">
                <h3>Artículos reportados de inventario físico</h3>
            </div>
			<div class="panel-body">
				<table id="revision" class="table table-hover table-bordered">
						<thead>
								<tr>
									<th>Item</th>
									<th>Código</th>
									<th>Descripción</th>
									<th>Cantidad reportada</th>
									<th>Cantidad en sistema</th>
									<th>Observación</th>
									<th>Acciones</th>
								</tr>
						</thead>
						<tbody></tbody>
						<tfoot></tfoot>
				</table>
			</div>
		</div>
	</div>
	<script type="text/javascript">
		$(function(){
			var revTable = $('#revision').dataTable({
				"language": {
						"url": "<?php echo base_url() ?>assets/js/lenguaje_datatable/spanish.json"
				},
				"bProcessing": true,
				"bServerSide": true,
				"sServerMethod": "GET",
				"sAjaxSource": "<?php echo base_url() ?>tablas/inventario/reportado",
				"iDisplayLength": 10,
				"aLengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
				"aaSorting": [[0, 'asc']],
				"aoColumns": [
					{ "bVisible": true, "bSearchable": true, "bSortable": true },
					{ "bVisible": true, "bSearchable": true, "bSortable": true },
					{ "bVisible": true, "bSearchable": true, "bSortable": true },
					{ "bVisible": true, "bSearchable": false, "bSortable": true },
					{ "bVisible": true, "bSearchable": false, "bSortable": true },
					{ "bVisible": true, "bSearchable": true, "bSortable": true },
					{ "bVisible": true, "bSearchable": false, "bSortable": false }//la columna extra
							]
			});
		});
	</script>