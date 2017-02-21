<script src="<?php echo base_url() ?>assets/js/jquery.min.js"></script>
<script type="text/javascript">
    base_url = '<?php echo base_url() ?>';
    $(document).ready(function() {
        all_check($('#checkAll_1'),'alm_crea');
        all_check($('#checkAll_2'),'alm_consul');
        all_check($('#checkAll_3'),'alm_edit');
        all_check($('#checkAll_4'),'mnt_crea');
        all_check($('#checkAll_5'),'mnt_consul');
        all_check($('#checkAll_6'),'mnt_edit');
        all_check($('#checkAll_7'),'usr_edit');
        all_check($('#checkAll_8'),'tic_crea');
        all_check($('#checkAll_9'),'tic_consul');
        all_check($('#checkAll_10'),'tic_edits');
        var panels = $('.user-infos');
        var panelsButton = $('.dropdown-user');
        panels.hide();

        //Click dropdown
        panelsButton.click(function() {
        //get data-for attribute
            var dataFor = $(this).attr('data-for');
            var idFor = $(dataFor);

        //current button
            var currentButton = $(this);
            idFor.slideToggle(400, function() {
            //Completed slidetoggle
                if(idFor.is(':visible'))
                {
                    currentButton.html('<i class="glyphicon glyphicon-chevron-up text-muted"></i>');
                }
                else
                {
                    currentButton.html('<i class="glyphicon glyphicon-chevron-down text-muted"></i>');
                }
            });
        });
        $('[data-toggle="tooltip"]').tooltip();
           // add multiple select / deselect functionality

//           $('#select_all').on('click',function(){
//        if(this.checked){
//            $('.alm_crea').each(function(){
//                this.checked = true;
//            });
//        }else{
//             $('.alm_crea').each(function(){
//                this.checked = false;
//            });
//        }
//    });
//    
//    $('.alm_crea').on('click',function(){
//        if($('.alm_crea:checked').length === $('.alm_crea').length){
//            $('#select_all').prop('checked',true);
//        }else{
//            $('#select_all').prop('checked',false);
//        }
//    });
	
	/* ######################### AGREGADOR ṔOR LUIS #########################*/
	$('.collapse').collapse();
	/* ######################### AGREGADOR ṔOR LUIS #########################*/

});

</script>
<style type="text/css">
.table { margin-bottom: 0px !important; }
.modal-message .modal-header .fa, 
.modal-message .modal-header 
.glyphicon, .modal-message 
.modal-header .typcn, .modal-message .modal-header .wi {
	font-size: 30px;
}

.fancy-checkbox input[type="checkbox"],
.fancy-checkbox .checked { display: none; }
 
.fancy-checkbox input[type="checkbox"]:checked ~ .checked
{ display: inline-block; }
 
.fancy-checkbox input[type="checkbox"]:checked ~ .unchecked
{ display: none; }

.dropdown-user:hover { cursor: pointer; }
.table-user-information > tbody > tr { border-top: 1px solid rgb(221, 221, 221); }
.table-user-information > tbody > tr:first-child { border-top: 0; }
.table-user-information > tbody > tr > td { border-top: 0; }
</style>

<div class="mainy">
	<div class="page-title">
		<h2 align="right"><i class="fa fa-users color"></i> Control de acceso <small>Seleccione para asignar  </small></h2>
		<hr />
	</div>

	<div class="panel panel-default">
		<div class="panel-heading"><label class="control-label"><?php echo $title?>: <strong class="text-info"><?php echo $nombre; ?></strong></label></div> 
		<form class="form" action="<?php echo base_url() ?>dec_permiso/dec_permiso/asignar_permiso" method="post" name="permiso" id="permiso">   
			<input type="hidden" name="id_usuario" value="<?php echo $id ?>">
			<div class="panel-body">

				<!-- 1. PERMISOS DE ALAMACÉN -->
				<div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
					<div class="panel panel-default">
						<div class="panel-heading" role="tab" id="headingOne">
							<a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
								<h3 class="panel-title">
									<img src="<?php echo base_url() ?>assets/img/alm/main.png" class="img-responsive pull-left" alt="bordes redondeados" width="20" height="20" style="margin-right: 10px;"><span class="negritas permisos-nombre-grande">Almacén</span>
								</h3>
							</a>							
						</div>
						<div id="collapseOne" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingOne">
							<button class="btn btn-warning pull-right" onclick="ayudaXalmacen()" type="button" title="Ayuda para permisos de almacén" style="margin-right: 20px;margin-top: 4px;"><i class="fa fa-question fa-fw"></i></button>
							<ul id="myTab2" class="nav nav-tabs" role="tablist">
								<li class="active"><a href="#tab-table1" data-toggle="tab">Crear/Insertar</a></li>
								<li><a href="#tab-table2" data-toggle="tab">Consultar</a></li>
								<li><a href="#tab-table3" data-toggle="tab">Editar</a></li>
							</ul>
							<div class="tab-content">
								<div class="tab-pane active" id="tab-table1">
                                                                    <div class="table-responsive">
									<table id="test" class="table table-bordered table-condensed" align="center" width="100%">
										<thead>
											<tr class="active">
												<th valign="middle"><div align="center">Artículo</div></th>
												<th valign="middle"><div align="center">Solicitud</div></th>
												<th valign="middle"><div align="center">Inventario por archivo</div></th>
												<th valign="middle"><div align="center">Cierre Inventario</div></th>
												<th valign="middle"><div align="center">Todos</div></th>
											</tr>
										</thead>
										<tbody align="center">
											<td><input type="checkbox" class="alm_crea" name="alm[6]"<?php if(isset($alm[6])){ echo ' checked';}?>  id="agregar1" value="1"></td>
											<td><input type="checkbox" class="alm_crea" name="alm[9]"<?php if(isset($alm[9])){ echo ' checked';}?>  id="agregar4" value="1"></td>
											<td><input type="checkbox" class="alm_crea" name="alm[7]"<?php if(isset($alm[7])){ echo ' checked';}?>  id="agregar2" value="1"></td>
											<td><input type="checkbox" class="alm_crea" name="alm[8]"<?php if(isset($alm[8])){ echo ' checked';}?>  id="agregar3" value="1"></td>
											<td><input type="checkbox" id="checkAll_1" <?php if(isset($alm[6]) && isset($alm[7]) && isset($alm[8]) && isset($alm[9])){ echo ' checked';}?> ></td>
										</tbody>
									</table>
                                                                    </div>
								</div>
								<div class="tab-pane" id="tab-table2">
                                                                    <div class="table-responsive">
									<table id="test" class="table table-hover table-bordered table-condensed" align="center" width="100%">
										<thead>
											<tr class="active">
												<th valign="middle"><div align="center">Catálogo</div></th>
												<th valign="middle"><div align="center">Solicitudes en almac&eacute;n</div></th>
												<th valign="middle"><div align="center">Solicitudes por departamento</div></th>
												<th valign="middle"><div align="center">Inventario</div></th>
												<th valign="middle"><div align="center">Historial / Reportes </div></th>
												<th valign="middle"><div align="center">Todos</div></th>
											</tr>
										</thead>
										<tbody align="center">
											<td><input type="checkbox" class="alm_consul" name="alm[1]"<?php if(isset($alm[1])){ echo ' checked';}?> id="consultar1" value="1"></td>
											<td><input type="checkbox" class="alm_consul" name="alm[2]"<?php if(isset($alm[2])){ echo ' checked';}?>  id="consultar2"  value="1"></td>
											<td><input type="checkbox" class="alm_consul" name="alm[3]"<?php if(isset($alm[3])){ echo ' checked';}?>  id="consultar3" value="1"></td>
											<td><input type="checkbox" class="alm_consul" name="alm[4]"<?php if(isset($alm[4])){ echo ' checked';}?>  id="consultar4" value="1"></td>
											<td><input type="checkbox" class="alm_consul" name="alm[5]"<?php if(isset($alm[5])){ echo ' checked';}?>  id="consultar5"  value="1"></td>
											<td><input type="checkbox" id="checkAll_2" <?php if(isset($alm[1]) && isset($alm[2]) && isset($alm[3]) && isset($alm[4]) && isset($alm[5])){ echo ' checked';}?>></td>
										</tbody>
									</table>
                                                                    </div>
								</div>
								<div class="tab-pane" id="tab-table3">
                                                                    <div class="table-responsive">
									<table class="table table-hover table-bordered table-condensed" align="center" width="100%">
										<thead>
											<tr class="active">
												<th valign="middle"><div align="center">Anular solicitud</div></th>
												<th valign="middle"><div align="center">Aprobar solicitud</div></th>
												<th valign="middle"><div align="center">Artículo</div></th>
                                                                                                <th valign="middle"><div align="center">Retirar artículo</div></th>
												<th valign="middle"><div align="center">Cancelar solicitud</div></th>
												<th valign="middle"><div align="center">Despachar solicitud</div></th>
												<th valign="middle"><div align="center">Enviar solicitud</div></th>
												<th valign="middle"><div align="center">Solicitud</div></th>
												<th valign="middle"><div align="center">Todos</div></th>
											</tr>
										</thead>
										<tbody align="center">
											<td><input type="checkbox" class="alm_edit" name="alm[15]"<?php if(isset($alm[15])){ echo ' checked';}?> id="editar6" value="1"></td>
											<td><input type="checkbox" class="alm_edit" name="alm[12]"<?php if(isset($alm[12])){ echo ' checked';}?> id="editar4" value="1"></td>
											<td><input type="checkbox" class="alm_edit" name="alm[10]"<?php if(isset($alm[10])){ echo ' checked';}?> id="editar1" value="1"></td>
                                                                                        <td><input type="checkbox" class="alm_edit" name="alm[17]"<?php if(isset($alm[17])){ echo ' checked';}?> id="editar8" value="1"></td>
											<td><input type="checkbox" class="alm_edit" name="alm[16]"<?php if(isset($alm[16])){ echo ' checked';}?> id="editar7" value="1"></td>
											<td><input type="checkbox" class="alm_edit" name="alm[13]"<?php if(isset($alm[13])){ echo ' checked';}?> id="editar5" value="1"></td>
											<td><input type="checkbox" class="alm_edit" name="alm[14]"<?php if(isset($alm[14])){ echo ' checked';}?> id="editar3" value="1"></td>
											<td><input type="checkbox" class="alm_edit" name="alm[11]"<?php if(isset($alm[11])){ echo ' checked';}?> id="editar2" value="1"></td>
											<td><input type="checkbox" id="checkAll_3" <?php if(isset($alm[10]) && isset($alm[11]) && isset($alm[12]) && isset($alm[13]) && isset($alm[14]) && isset($alm[15]) && isset($alm[16]) && isset($alm[17])){ echo ' checked';}?> ></td>

										</tbody>
									</table>
                                                                    </div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<!-- 1. PERMISOS DE ALAMACÉN -->

				<!-- 4. PERMISOS DE ASISTENCIA -->
<!--				<div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
					<div class="panel panel-default">
						<div class="panel-heading" role="tab" id="headingOne">
							<a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapsFour" aria-expanded="true" aria-controls="collapsFour">
								<h3 class="panel-title">
									<i class="fa fa-th-list fw-2x" style="margin-right: 10px;"></i><span class="negritas permisos-nombre-grande">Recursos Humanos</span>
								</h3>
							</a>
						</div>
						<div id="collapsFour" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingOne">
							<button class="btn btn-warning pull-right" onclick="ayudaXasistencia()" type="button" title="Ayuda para permisos de recursos humanos" style="margin-right: 20px;margin-top: 4px;"><i class="fa fa-question fa-fw"></i></button>
							<ul id="myTab4" class="nav nav-tabs" role="tablist">
								<li class="active"><a href="#tab-table15" data-toggle="tab">Crear/Insertar</a></li>
								<li><a href="#tab-table16" data-toggle="tab">Consultar</a></li>
								<li><a href="#tab-table17" data-toggle="tab">Editar</a></li>
								<li><a href="#tab-table18" data-toggle="tab">Eliminar</a></li>
							</ul>
							<div class="tab-content">
								 Crear/Insertar 
								<div class="tab-pane active" id="tab-table15">
									<table id="test" class="table table-bordered table-condensed" align="center" width="100%">
										<thead>
											<tr class="active">
												<th valign="middle" class="text-center">Cargos</th>
												<th valign="middle" class="text-center">Jornadas</th>
												<th valign="middle" class="text-center">Periodo No Laboral</th>
												<th valign="middle" class="text-center">Notas Asistencia</th>
												<th valign="middle" class="text-center">Control Ausentismos</th>
											</tr>
										</thead>
										<tbody align="center">
											<td><input type="checkbox" class="alm_crea" name="alm[6]"<?php if(isset($alm[6])){ echo ' checked';}?>  id="agregar1" value="1"></td>
											<td><input type="checkbox" class="alm_crea" name="alm[9]"<?php if(isset($alm[9])){ echo ' checked';}?>  id="agregar4" value="1"></td>
											<td><input type="checkbox" class="alm_crea" name="alm[7]"<?php if(isset($alm[7])){ echo ' checked';}?>  id="agregar2" value="1"></td>
											<td><input type="checkbox" class="alm_crea" name="alm[8]"<?php if(isset($alm[8])){ echo ' checked';}?>  id="agregar3" value="1"></td>
											<td><input type="checkbox" id="checkAll_1" <?php if(isset($alm[6]) && isset($alm[7]) && isset($alm[8]) && isset($alm[9])){ echo ' checked';}?> ></td>
										</tbody>
									</table>
								</div>
								 Consultar 
								<div class="tab-pane" id="tab-table16">
									<table id="test" class="table table-hover table-bordered table-condensed" align="center" width="100%">
										<thead>
											<tr class="active">
												<th valign="middle" class="text-center">Cargos</th>
												<th valign="middle" class="text-center">Jornadas</th>
												<th valign="middle" class="text-center">Periodo No Laboral</th>
												<th valign="middle" class="text-center">Notas Asistencia</th>
												<th valign="middle" class="text-center">Control Ausentismos</th>
											</tr>
										</thead>
										<tbody align="center">
											<td><input type="checkbox" class="alm_consul" name="alm[1]"<?php if(isset($alm[1])){ echo ' checked';}?> id="consultar1" value="1"></td>
											<td><input type="checkbox" class="alm_consul" name="alm[2]"<?php if(isset($alm[2])){ echo ' checked';}?>  id="consultar2"  value="1"></td>
											<td><input type="checkbox" class="alm_consul" name="alm[3]"<?php if(isset($alm[3])){ echo ' checked';}?>  id="consultar3" value="1"></td>
											<td><input type="checkbox" class="alm_consul" name="alm[4]"<?php if(isset($alm[4])){ echo ' checked';}?>  id="consultar4" value="1"></td>
											<td><input type="checkbox" class="alm_consul" name="alm[5]"<?php if(isset($alm[5])){ echo ' checked';}?>  id="consultar5"  value="1"></td>
											<td><input type="checkbox" id="checkAll_2" <?php if(isset($alm[1]) && isset($alm[2]) && isset($alm[3]) && isset($alm[4]) && isset($alm[5])){ echo ' checked';}?>></td>
										</tbody>
									</table>                               
								</div>
								 Editar 
								<div class="tab-pane" id="tab-table17">
									<table class="table table-hover table-bordered table-condensed" align="center" width="100%">
										<thead>
											<tr class="active">
												<th valign="middle" class="text-center">Asistencia Configuración</th>
												<th valign="middle" class="text-center">Cargos</th>
												<th valign="middle" class="text-center">Jornadas</th>
												<th valign="middle" class="text-center">Periodo No Laboral</th>
												<th valign="middle" class="text-center">Notas Asistencia</th>
												<th valign="middle" class="text-center">Control Ausentismos</th>
											</tr>
										</thead>
										<tbody align="center">
											<td><input type="checkbox" class="alm_edit" name="alm[10]"<?php if(isset($alm[10])){ echo ' checked';}?> id="editar1" value="1"></td>
											<td><input type="checkbox" class="alm_edit" name="alm[12]"<?php if(isset($alm[12])){ echo ' checked';}?> id="editar4" value="1"></td>
											<td><input type="checkbox" class="alm_edit" name="alm[13]"<?php if(isset($alm[13])){ echo ' checked';}?> id="editar5" value="1"></td>
											<td><input type="checkbox" class="alm_edit" name="alm[14]"<?php if(isset($alm[14])){ echo ' checked';}?> id="editar3" value="1"></td>
											<td><input type="checkbox" class="alm_edit" name="alm[11]"<?php if(isset($alm[11])){ echo ' checked';}?> id="editar2" value="1"></td>
											<td><input type="checkbox" id="checkAll_3" <?php if(isset($alm[10]) && isset($alm[11]) && isset($alm[12]) && isset($alm[13]) && isset($alm[14])){ echo ' checked';}?> ></td>

										</tbody>
									</table>
								</div>
								 Eliminar 
								<div class="tab-pane" id="tab-table18">
									<table class="table table-hover table-bordered table-condensed" align="center" width="100%">
										<thead>
											<tr class="active">
												<th valign="middle" class="text-center">Cargos</th>
												<th valign="middle" class="text-center">Jornadas</th>
												<th valign="middle" class="text-center">Periodo No Laboral</th>
												<th valign="middle" class="text-center">Notas Asistencia</th>
												<th valign="middle" class="text-center">Control Ausentismos</th>
											</tr>
										</thead>
										<tbody align="center">
											<td><input type="checkbox" class="alm_edit" name="alm[10]"<?php if(isset($alm[10])){ echo ' checked';}?> id="editar1" value="1"></td>
											<td><input type="checkbox" class="alm_edit" name="alm[12]"<?php if(isset($alm[12])){ echo ' checked';}?> id="editar4" value="1"></td>
											<td><input type="checkbox" class="alm_edit" name="alm[13]"<?php if(isset($alm[13])){ echo ' checked';}?> id="editar5" value="1"></td>
											<td><input type="checkbox" class="alm_edit" name="alm[14]"<?php if(isset($alm[14])){ echo ' checked';}?> id="editar3" value="1"></td>
											<td><input type="checkbox" id="checkAll_3" <?php if(isset($alm[10]) && isset($alm[11]) && isset($alm[12]) && isset($alm[13]) && isset($alm[14])){ echo ' checked';}?> ></td>
										</tbody>
									</table>
								</div>
							</div>
						</div>
					</div>
				</div>-->
				<!-- 4. PERMISOS DE ASISTENCIA -->

				<!-- 2. PERMISOS DE MANTENIMIENTO -->
				<div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
					<div class="panel panel-default">
						<div class="panel-heading" role="tab" id="headingOne">
							<a class="negritas permisos-nombre-grande" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo">
								<h3 class="panel-title">
									<i class="fa fa-wrench fa-fw fa-2x" style="margin-right: 10px;"></i><span class="negritas permisos-nombre-grande">Mantenimiento</span>
								</h3>
							</a>
						</div>
						<div id="collapseTwo" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingOne">
							<button class="btn btn-warning pull-right" onclick="ayudaXmantenimiento()" type="button" title="Ayuda para permisos de mantenimiento" style="margin-right: 20px;margin-top: 4px;"><i class="fa fa-question fa-fw"></i></button>
							<ul id="myTab3" class="nav nav-tabs" role="tablist">
								<li class="active"><a href="#tab-table6" data-toggle="tab">Crear/Insertar</a></li>
								<li><a href="#tab-table7" data-toggle="tab">Consultar</a></li>
								<li><a href="#tab-table8" data-toggle="tab">Editar</a></li>
								<li><a href="#tab-table9" data-toggle="tab">Eliminar</a></li>
							</ul>
							<div class="tab-content">
								<div class="tab-pane active" id="tab-table6"><!--Crear-->
									<div class="table-responsive">
										<table id="test" class="table table-bordered table-condensed" align="center" width="100%">
											<thead>
												<tr class="active">
													<th valign="middle"><div align="center">Solicitudes</div></th>
													<th valign="middle"><div align="center">Sol. por departamento</div></th>
													<th valign="middle"><div align="center">Cuadrilla</div></th>
													<th valign="middle"><div align="center">Ubicación</div></th>
													<th valign="middle"><div align="center">Asignar personal</div></th>
													<th valign="middle"><div align="center">Agregar miembros de cuadrilla</div></th>
													<th valign="middle"><div align="center">Calificar solicitudes</div></th>
													<th valign="middle"><div align="center">Observaciones</div></th>
													<th valign="middle"><div align="center">Todos</div></th>
												</tr>                      
											</thead>
											<tbody align="center">
												<td><input type="checkbox" class="mnt_crea" name="mnt[1]"<?php if (isset($mnt[1])) {
													echo ' checked';
												} ?> id="mnt_crear1" value="1"></td>
												<td><input type="checkbox" class="mnt_crea" name="mnt[2]"<?php if (isset($mnt[2])) {
													echo ' checked';
												} ?> id="mnt_crear2" value="1"></td>
												<td><input type="checkbox" class="mnt_crea" name="mnt[3]"<?php if (isset($mnt[3])) {
													echo ' checked';
												} ?> id="mnt_crear2" value="1"></td>
												<td><input type="checkbox" class="mnt_crea" name="mnt[4]"<?php if (isset($mnt[4])) {
													echo ' checked';
												} ?> id="mnt_crear4" value="1"></td>
												<td><input type="checkbox" class="mnt_crea" name="mnt[5]"<?php if (isset($mnt[5])) {
													echo ' checked';
												} ?> id="mnt_crear5" value="1"></td>
												<td><input type="checkbox" class="mnt_crea" name="mnt[6]"<?php if (isset($mnt[6])) {
													echo ' checked';
												} ?> id="mnt_crear6" value="1"></td>
												<td><input type="checkbox" class="mnt_crea" name="mnt[7]"<?php if (isset($mnt[7])) {
													echo ' checked';
												} ?> id="mnt_crear7" value="1"></td>
												<td><input type="checkbox" class="mnt_crea" name="mnt[8]"<?php if (isset($mnt[8])) {
													echo ' checked';
												} ?> id="mnt_crear8" value="1"></td>
												<td><input type="checkbox" id="checkAll_4" <?php if (isset($mnt[1]) && isset($mnt[2]) && isset($mnt[3]) && isset($mnt[4]) && isset($mnt[5]) && isset($mnt[6]) && isset($mnt[7]) && isset($mnt[8])) {
													echo ' checked';
												} ?>></td>
											</tbody>
										</table>
									</div>
								</div>
								<div class="tab-pane" id="tab-table7"><!--<i class="fa fa-search fa-lg"></i> Consultar-->
									<div class="table-responsive">
										<table class="table table-hover table-bordered table-condensed" width="100%">
											<thead>
												<tr>
													<th colspan="9" valign="middle" class="active"><div align="center">Solicitudes</div></th>
												</tr>
												<tr>
													<th valign="middle"><div align="center">Todas Depend.</div></th>
													<th valign="middle"><div align="center">Estatus</div></th>
													<th valign="middle"><div align="center">En Proceso</div></th>
													<th valign="middle"><div align="center">Cerradas</div></th>
													<th valign="middle"><div align="center">Anuladas</div></th>
													<th valign="middle"><div align="center">Detalle</div></th>
													<th valign="middle"><div align="center">Asignación</div></th>
													<th valign="middle"><div align="center">Reportes</div></th>
													<th valign="middle"><div align="center">Todos</div></th>
												</tr>
											</thead>
											<tbody align="center">
												<td><input type="checkbox" class="mnt_consul" name="mnt[9]" <?php if (isset($mnt[9])){ echo ' checked';}?>  id="mnt_ver1" value="1"></td>
												<td><input type="checkbox" class="mnt_consul" name="mnt[10]"<?php if(isset($mnt[10])){ echo ' checked';}?>  id="mnt_ver2" value="1"></td>
												<td><input type="checkbox" class="mnt_consul" name="mnt[11]"<?php if(isset($mnt[11])){ echo ' checked';}?>  id="mnt_ver3" value="1"></td>
												<td><input type="checkbox" class="mnt_consul" name="mnt[12]"<?php if(isset($mnt[12])){ echo ' checked';}?>  id="mnt_ver4" value="1"></td>
												<td><input type="checkbox" class="mnt_consul" name="mnt2[3]"<?php if(isset($mnt2[3])){ echo ' checked';}?>  id="mnt_ver6" value="1"></td>
												<td><input type="checkbox" class="mnt_consul" name="mnt[13]"<?php if(isset($mnt[13])){ echo ' checked';}?>  id="mnt_ver7" value="1"></td>
												<td><input type="checkbox" class="mnt_consul" name="mnt[14]"<?php if(isset($mnt[14])){ echo ' checked';}?>  id="mnt_ver8" value="1"></td>
												<td><input type="checkbox" class="mnt_consul" name="mnt[15]"<?php if(isset($mnt[15])){ echo ' checked';}?>  id="mnt_ver9" value="1"></td>
												<td><input type="checkbox" id="checkAll_5" <?php if (isset($mnt[9]) && isset($mnt[10]) && isset($mnt[11]) && isset($mnt[12]) && isset($mnt[13]) && isset($mnt[14]) && isset($mnt[15]) && isset($mnt2[3])) {
													echo ' checked';
												} ?>></td>
											</tbody>
										</table>
									</div>
								</div>
								<div class="tab-pane" id="tab-table8"><!--<i class="fa fa-edit fa-lg"></i> Editar-->
									<table class="table table-bordered table-condensed">
										<thead>
											<tr class="active">
												<th valign="middle"><div align="center">Solicitudes abiertas</div></th>
												<th valign="middle"><div align="center">Estatus solicitud</div></th>
												<th valign="middle"><div align="center">Cuadrillas</div></th>
												<th valign="middle"><div align="center">Todos</div></th>
											</tr>                      
										</thead>
										<tbody align="center">
											<td><input type="checkbox" class="mnt_edit" name="mnt[16]"<?php if(isset($mnt[16])){ echo ' checked';}?> id="mnt_editar1" value="1"></td>
											<td><input type="checkbox" class="mnt_edit" name="mnt[17]"<?php if(isset($mnt[17])){ echo ' checked';}?> id="mnt_editar2" value="1"></td>
											<td><input type="checkbox" class="mnt_edit" name="mnt2[1]"<?php if(isset($mnt2[1])){ echo ' checked';}?> id="mnt_editar3" value="1"></td>
											<td><input type="checkbox" class="mnt_edit" id="checkAll_6"<?php if (isset($mnt[16]) && isset($mnt[17]) && isset($mnt2[1])){echo 'checked';} ?>></td>
										</tbody>
									</table>
								</div>
								<div class="tab-pane" id="tab-table9"><!--Eliminar-->
									<table class="table table-bordered table-condensed">
										<thead>
											<tr class="active">
												<th valign="middle"><div align="center">Miembros de cuadrilla</div></th>
												<!--<th valign="middle"><div align="center">Todo</div></th>-->
											</tr>                      
										</thead>
										<tbody align="center">
											<td><input type="checkbox" name="mnt2[2]"<?php if(isset($mnt2[2])){ echo ' checked';}?> id="mnt_eliminar" value="1"></td>
											<!--<td><div align="center"><input type="checkbox" id="checkAll_10" onclick="diferent('mnt_proceso')"></div></td>-->
										</tbody>
									</table>
								</div>  
							</div>
						</div>
					</div>
				</div>
				<!-- 2. PERMISOS DE MANTENIMIENTO -->

				<!-- 3. PERMISOS DE USUARIOS -->
				<div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
					<div class="panel panel-default">
						<div class="panel-heading" role="tab" id="headingOne">
							<a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseThree" aria-expanded="true" aria-controls="collapseThree">
								<h3 class="panel-title">
									<i class="fa fa-users fa-fw fa-2x" style="margin-right: 10px;"></i><span class="negritas permisos-nombre-grande">Usuarios</span>
								</h3>
							</a>
						</div>
						<div id="collapseThree" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingOne">
							<button class="btn btn-warning pull-right" onclick="ayudaXusuarios()" type="button" title="Ayuda para permisos de usuario" style="margin-right: 20px;margin-top: 4px;"><i class="fa fa-question fa-fw"></i></button>
							<ul id="myTab4"class="nav nav-tabs" role="tablist">
								<li class="active">
									<a href="#tab-table11" data-toggle="tab">Crear/Agregar</a>
								</li>
								<li>
									<a href="#tab-table12" data-toggle="tab">Consultar</a>
								</li>
								<li>
									<a href="#tab-table13" data-toggle="tab">Editar</a>
								</li>
                                <!-- <li>
									<a href="#tab-table14" data-toggle="tab">Procesos</a>
								</li> -->
							</ul>
							<div class="tab-content">
								<div class="tab-pane active" id="tab-table11">
									<table class="table table-bordered table-condensed" align="center" width="100%">
										<thead>
											<tr class="active">
												<th valign="middle"><div align="center">Usuarios</div></th>
											</tr>                      
										</thead>
										<tbody align="center">
											<td><input type="checkbox" name="usr[1]"<?php if(isset($usr[1])){ echo ' checked';}?>  id="usr_agregar1" value="1"></td>
										</tbody>
									</table>
								</div>
								<div class="tab-pane" id="tab-table12">
									<table id="test" class="table table-bordered table-condensed" align="center" width="100%">
										<thead>
											<tr class="active">
												<th valign="middle"><div align="center">Todos</div></th>
												<th valign="middle"><div align="center">Por dependencia</div></th>
												<!--<th valign="middle"><div align="center">Todo</div></th>-->
											</tr>
										</thead>
										<tbody align="center">
												<td><input type="checkbox" name="usr[2]"<?php if(isset($usr[2])){ echo ' checked';}?>  id="usr_ver1" value="1"></td>
												<td><input type="checkbox" name="usr[3]"<?php if(isset($usr[3])){ echo ' checked';}?>  id="usr_ver2" value="1"></td>
												<!--<td><div align="center"><input type="checkbox" id="checkAll_11" onclick="diferent('usr_ver')"></div></td>-->
										</tbody>
									</table>
								</div>
					 
								<div class="tab-pane" id="tab-table13">
									<table class="table table-bordered table-condensed" align="center" width="100%">
										<thead>
											<tr class="active">
												<th valign="middle"><div align="center">Usuarios</div></th>
												<th valign="middle"><div align="center">Activar/Desactivar usuarios</div></th>
												<th valign="middle"><div align="center">Todos</div></th>
											</tr>                      
										</thead>
										<tbody align="center">
												<td><input type="checkbox" class="usr_edit" name="usr[4]"<?php if(isset($usr[4])){ echo ' checked';}?>  id="usr_editar1" value="1"></td>
												<td><input type="checkbox" class="usr_edit" name="usr[5]"<?php if(isset($usr[5])){ echo ' checked';}?> id="usr_proceso1" value="1"></td>
												<td><input type="checkbox" id="checkAll_7" <?php if (isset($usr[4]) && isset($usr[5])){echo 'checked';} ?>></td>
										</tbody>
									</table>
								</div>
                                <!-- <div class="tab-pane" id="tab-table14">
									<table class="table table-hover table-bordered table-condensed" align="center" width="100%">
										<thead>
											<tr>
												<th valign="middle"><div align="center">Activar/Desactivar</div></th>
											</tr>                      
										</thead>
										<tbody>
												<td><div align="center"><input type="checkbox" name="usr[5]"<?php if(isset($usr[5])){ echo ' checked';}?> id="usr_proceso1" value="1"></div></td>
										</tbody>
									</table>
								</div> -->
							</div>
						</div>
					</div>
				</div>
				<!-- 3. PERMISOS DE USUARIOS -->
                                <?php if ($this->session->userdata('user')['id_usuario'] == '14713134'){?>
				<!-- 4. PERMISOS TIC -->
				<div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
					<div class="panel panel-default">
						<div class="panel-heading" role="tab" id="headingOne">
							<a class="negritas permisos-nombre-grande" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseFour" aria-expanded="true" aria-controls="collapseFour">
								<h3 class="panel-title">
									<i class="fa fa-desktop fa-fw fa-2x" style="margin-right: 10px;"></i><span class="negritas permisos-nombre-grande">TIC</span>
								</h3>
							</a>
						</div>
						<div id="collapseFour" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingOne">
							<ul id="myTab4" class="nav nav-tabs" role="tablist">
								<li class="active"><a href="#tab-table14" data-toggle="tab">Crear/Insertar</a></li>
								<li><a href="#tab-table15" data-toggle="tab">Consultar</a></li>
								<li><a href="#tab-table16" data-toggle="tab">Editar</a></li>
								<li><a href="#tab-table17" data-toggle="tab">Eliminar</a></li>
							</ul>
							<div class="tab-content">
								<div class="tab-pane active" id="tab-table14"><!--Crear-->
									<div class="table-responsive">
										<table id="test" class="table table-bordered table-condensed" align="center" width="100%">
											<thead>
												<tr class="active">
													<th valign="middle"><div align="center">Solicitudes</div></th>
													<th valign="middle"><div align="center">Sol. por departamento</div></th>
													<th valign="middle"><div align="center">Cuadrilla</div></th>
													<th valign="middle"><div align="center">Ubicación</div></th>
													<th valign="middle"><div align="center">Asignar personal</div></th>
													<th valign="middle"><div align="center">Agregar miembros de cuadrilla</div></th>
													<th valign="middle"><div align="center">Calificar solicitudes</div></th>
													<th valign="middle"><div align="center">Observaciones</div></th>
													<th valign="middle"><div align="center">Todos</div></th>
												</tr>                      
											</thead>
											<tbody align="center">
												<td><input type="checkbox" class="tic_crea" name="tic[1]"<?php if (isset($tic[1])) {
													echo ' checked';
												} ?> id="mnt_crear1" value="1"></td>
												<td><input type="checkbox" class="tic_crea" name="tic[2]"<?php if (isset($tic[2])) {
													echo ' checked';
												} ?> id="mnt_crear2" value="1"></td>
												<td><input type="checkbox" class="tic_crea" name="tic[3]"<?php if (isset($tic[3])) {
													echo ' checked';
												} ?> id="mnt_crear2" value="1"></td>
												<td><input type="checkbox" class="tic_crea" name="tic[4]"<?php if (isset($tic[4])) {
													echo ' checked';
												} ?> id="mnt_crear4" value="1"></td>
												<td><input type="checkbox" class="tic_crea" name="tic[5]"<?php if (isset($tic[5])) {
													echo ' checked';
												} ?> id="mnt_crear5" value="1"></td>
												<td><input type="checkbox" class="tic_crea" name="tic[6]"<?php if (isset($tic[6])) {
													echo ' checked';
												} ?> id="mnt_crear6" value="1"></td>
												<td><input type="checkbox" class="tic_crea" name="tic[7]"<?php if (isset($tic[7])) {
													echo ' checked';
												} ?> id="mnt_crear7" value="1"></td>
												<td><input type="checkbox" class="tic_crea" name="tic[8]"<?php if (isset($tic[8])) {
													echo ' checked';
												} ?> id="mnt_crear8" value="1"></td>
												<td><input type="checkbox" id="checkAll_8" <?php if (isset($tic[1]) && isset($tic[2]) && isset($tic[3]) 
                                                                                                        && isset($tic[4]) && isset($tic[5]) && isset($tic[6]) && isset($tic[7]) && isset($tic[8])) {
													echo ' checked';
												} ?>></td>
											</tbody>
										</table>
									</div>
								</div>
								<div class="tab-pane" id="tab-table15"><!--<i class="fa fa-search fa-lg"></i> Consultar-->
									<div class="table-responsive">
										<table class="table table-hover table-bordered table-condensed" width="100%">
											<thead>
												<tr>
													<th colspan="9" valign="middle" class="active"><div align="center">Solicitudes</div></th>
												</tr>
												<tr>
													<th valign="middle"><div align="center">Todas Depend.</div></th>
													<th valign="middle"><div align="center">Estatus</div></th>
													<th valign="middle"><div align="center">En Proceso</div></th>
													<th valign="middle"><div align="center">Cerradas</div></th>
													<th valign="middle"><div align="center">Anuladas</div></th>
													<th valign="middle"><div align="center">Detalle</div></th>
													<th valign="middle"><div align="center">Asignación</div></th>
													<th valign="middle"><div align="center">Reportes</div></th>
													<th valign="middle"><div align="center">Todos</div></th>
												</tr>
											</thead>
											<tbody align="center">
												<td><input type="checkbox" class="tic_consul" name="tic[9]" <?php if (isset($tic[9])){ echo ' checked';}?>  id="tic_ver1" value="1"></td>
												<td><input type="checkbox" class="tic_consul" name="tic[10]"<?php if(isset($tic[10])){ echo ' checked';}?>  id="tic_ver2" value="1"></td>
												<td><input type="checkbox" class="tic_consul" name="tic[11]"<?php if(isset($tic[11])){ echo ' checked';}?>  id="tic_ver3" value="1"></td>
												<td><input type="checkbox" class="tic_consul" name="tic[12]"<?php if(isset($tic[12])){ echo ' checked';}?>  id="tic_ver4" value="1"></td>
												<td><input type="checkbox" class="tic_consul" name="tic2[3]"<?php if(isset($tic2[3])){ echo ' checked';}?>  id="tic_ver6" value="1"></td>
												<td><input type="checkbox" class="tic_consul" name="tic[13]"<?php if(isset($tic[13])){ echo ' checked';}?>  id="tic_ver7" value="1"></td>
												<td><input type="checkbox" class="tic_consul" name="tic[14]"<?php if(isset($tic[14])){ echo ' checked';}?>  id="tic_ver8" value="1"></td>
												<td><input type="checkbox" class="tic_consul" name="tic[15]"<?php if(isset($tic[15])){ echo ' checked';}?>  id="tic_ver9" value="1"></td>
												<td><input type="checkbox" id="checkAll_9" <?php if (isset($tic[9]) && isset($tic[10]) && isset($tic[11]) && isset($tic[12]) && isset($tic[13]) 
                                                                                                        && isset($tic[14]) && isset($tic[15]) && isset($tic2[3])) {
													echo ' checked';
												} ?>></td>
											</tbody>
										</table>
									</div>
								</div>
								<div class="tab-pane" id="tab-table16"><!--<i class="fa fa-edit fa-lg"></i> Editar-->
									<table class="table table-bordered table-condensed">
										<thead>
											<tr class="active">
												<th valign="middle"><div align="center">Solicitudes abiertas</div></th>
												<th valign="middle"><div align="center">Estatus solicitud</div></th>
												<th valign="middle"><div align="center">Cuadrillas</div></th>
												<th valign="middle"><div align="center">Todos</div></th>
											</tr>                      
										</thead>
										<tbody align="center">
											<td><input type="checkbox" class="tic_edit" name="tic[16]"<?php if(isset($tic[16])){ echo ' checked';}?> id="tic_editar1" value="1"></td>
											<td><input type="checkbox" class="tic_edit" name="tic[17]"<?php if(isset($tic[17])){ echo ' checked';}?> id="tic_editar2" value="1"></td>
											<td><input type="checkbox" class="tic_edit" name="tic2[1]"<?php if(isset($tic2[1])){ echo ' checked';}?> id="tic_editar3" value="1"></td>
											<td><input type="checkbox" class="tic_edit" id="checkAll_10"<?php if (isset($tic[16]) && isset($tic[17]) && isset($tic2[1])){echo 'checked';} ?>></td>
										</tbody>
									</table>
								</div>
								<div class="tab-pane" id="tab-table17"><!--Eliminar-->
									<table class="table table-bordered table-condensed">
										<thead>
											<tr class="active">
												<th valign="middle"><div align="center">Miembros de cuadrilla</div></th>
												<!--<th valign="middle"><div align="center">Todo</div></th>-->
											</tr>                      
										</thead>
										<tbody align="center">
											<td><input type="checkbox" name="tic2[2]"<?php if(isset($tic2[2])){ echo ' checked';}?> id="tic_eliminar" value="1"></td>
											<!--<td><div align="center"><input type="checkbox" id="checkAll_10" onclick="diferent('mnt_proceso')"></div></td>-->
										</tbody>
									</table>
								</div>  
							</div>
						</div>
					</div>
				</div>
                                <?php } ?>
				<!-- 4. FIN PERMISOS TIC -->                                
			</div>
	  
			<div class="panel-footer">
				<div class='container'align="right">
					<div class="btn-group btn-group-sm pull-right">
						<button onClick="javascript:window.history.back();" type="button" name="Submit" class="btn btn-info">Regresar</button>
						<button type="submit" class="btn btn-primary">Guardar</button>
					</div>
				</div>  
			</div>
		</form>
	</div>
</div>
<script type="text/javascript">
	/* ######################### AGREGADOR ṔOR LUIGI #########################*/
	//Modal de ayuda para permiso de almacen
	function ayudaXalmacen()
	{
		// <div class="awidget-body">
		var content = $('<div class="awidget-body"/>');
		// 	<ul id="myTab" class="nav nav-tabs nav-justified">
		var tablist = $('<ul class="nav nav-tabs nav-justified" role="tablist"/>'); 
		tablist.append('<li class="active"><a href="#crearinsertar" data-toggle="tab">Crear/Insertar</a></li>');
		tablist.append('<li><a href="#consultar" data-toggle="tab">Consultar</a></li>');
		tablist.append('<li><a href="#editar" data-toggle="tab">Editar</a></li>');
		// 		<li class="active"><a href="#home" data-toggle="tab">Cat&aacute;logo</a></li>
		// 		<li><a href="#active" data-toggle="tab">Inventario</a></li>
		// 	</ul>
		var space = $('<div class="space-5px" />');
		// 	<div class="space-5px"></div>
		// 	<div id="myTabContent" class="tab-content">
		var tabcontent = $('<div class="tab-content" />');
		var crearinsertar = $('<div id="crearinsertar" class="tab-pane fade in active" />');
		
		var table = $('<table class="table table-hover table-striped table-bordered table-condensed"/>');
		var tableBody = $('<tbody/>');
		table.append(tableBody);
		var row1 = $('<tr/>');
		row1.append('<td><strong>Artículo</strong>(Insertar):</td>');
		row1.append('<td><p>Permite al usuario con el permiso asignado reponer e insertar articulos al inventario del sistema</p></td>');

		var row2 = $('<tr/>');
		row2.append('<td><strong>Solicitud</strong>(Generar):</td>');
		row2.append('<td><p>Permite al usuario con el permiso asignado generar solicitudes de almacen, desde el departamento que se encuentra registrado</p></td>');

		var row3 = $('<tr/>');
		row3.append('<td><strong>Inventario por archivo</strong>(Insertar):</td>');
		row3.append('<td><p>Permite al usuario con el permiso asignado insertar artículos al inventario desde un archivo de excel u hoja de calculo (formato .xls)</p></td>');

		var row4 = $('<tr/>');
		row4.append('<td><strong>Cierre de inventario</strong>(Generar):</td>');
		row4.append('<td><p>Permite al usuario con el permiso asignado generar un reporte de cierre de inventario</p></td>');

		tableBody.append(row1);
		tableBody.append(row2);
		tableBody.append(row3);
		tableBody.append(row4);



		crearinsertar.append(table);
		// 		<div id="home" class="tab-pane fade in active">
		// 		</div>
		var consultar = $('<div id="consultar" class="tab-pane fade"/>');
		consultar.append('consultar');
		// 		<div id="active" class="tab-pane fade">
		// 		</div>
		var editar = $('<div id="editar" class="tab-pane fade"/>');
		editar.append('editar');
		// 	</div>
		tabcontent.append(crearinsertar);
		tabcontent.append(consultar);
		tabcontent.append(editar);
		content.append(tablist);
		content.append(space);
		content.append(tabcontent);
		buildModal('almacen', 'Permisos de Almacen', content);
		// </div> <!-- end awidget-body -->

	}
	/* ######################### AGREGADOR ṔOR LUIGI #########################*/
</script>