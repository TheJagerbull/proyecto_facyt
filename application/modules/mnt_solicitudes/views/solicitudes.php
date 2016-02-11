<script src="<?php echo base_url() ?>assets/js/jquery.min.js"></script>
<script type="text/javascript">
    base_url = '<?= base_url() ?>';
    $(document).ready(function () {
     //para usar dataTable en la table solicitudes
        var table = $('#solicitudes').DataTable({
            "bProcessing": true,
            "serverSide": true, //Feature control DataTables' server-side processing mode.
            "bDeferRender": true,
//        "searching": false,
            "pagingType": "full_numbers", //se usa para la paginacion completa de la tabla
            "sDom": '<"top"lp<"clear">>rt<"bottom"ip<"clear">>', //para mostrar las opciones donde p=paginacion,l=campos a mostrar,i=informacion
            "order": [[0, "desc"]], //para establecer la columna a ordenar por defecto y el orden en que se quiere 
//            "aoColumnDefs": [{"orderable": false, "targets": [0]}],//para desactivar el ordenamiento en esas columnas
        "ajax": {
            "url": "<?php echo site_url('mnt_solicitudes/mnt_solicitudes/list_sol')?>",
            "type": "GET",
            "data": function ( d ) {
                d.uno = $('#result1').val();
                d.dos = $('#result2').val();
            }
        }
       
        });
  <?php if ($this->session->userdata('user')['sys_rol'] == 'asist_autoridad'): ?>
          table.column(5).visible(false);//para hacer invisible una columna usando table como variable donde se guarda la funcion dataTable 
          table.column(6).visible(false);
          table.column(7).visible(false);
  <?php else:?>
//          table.column(4).visible(false);//para hacer invisible una columna usando table como variable donde se guarda la funcion dataTable   
  <?php endif ?>
//        table.column(4).visible(false);//para hacer invisible una columna usando table como variable donde se guarda la funcion dataTable 
//        table.column(0).visible(false);
        //$('div.dataTables_filter').appendTo(".search-box");//permite sacar la casilla de busqueda a un div donde apppendTo se escribe el nombre del div destino
        $('#buscador').keyup(function () { //establece un un input para el buscador fuera de la tabla
            table.search($(this).val()).draw(); // escribe la busqueda del valor escrito en la tabla con la funcion draw
        });

    $('#fecha1 span').html(moment().subtract(29, 'days').format('MMMM D, YYYY') + ' - ' + moment().format('MMMM D, YYYY'));

    $('#fecha1').daterangepicker({
        format: 'DD/MM/YYYY',
        startDate: moment().subtract(29, 'days'),
        endDate: moment(),
        // minDate: '01/01/2012',
        // maxDate: '12/31/2021',
        dateLimit: {days: 240},
        showDropdowns: true,
        showWeekNumbers: true,
        timePicker: false,
        timePickerIncrement: 1,
        timePicker12Hour: true,
        ranges: {
            'Hoy': [moment(), moment()],
            'Ayer': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
            'Últimos 7 días': [moment().subtract(6, 'days'), moment()],
            'Últimos 30 días': [moment().subtract(29, 'days'), moment()],
            'Este mes': [moment().startOf('month'), moment().endOf('month')],
            'Mes Pasado': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
        },
        opens: 'left',
        drops: 'down',
        buttonClasses: ['btn', 'btn-sm'],
        applyClass: 'btn-primary',
        cancelClass: 'btn-default',
        separator: ' al ',
        locale: {
            applyLabel: 'Listo',
            cancelLabel: 'Cancelar',
            fromLabel: 'Desde',
            toLabel: 'Hasta',
            customRangeLabel: 'Personalizado',
            daysOfWeek: ['Do', 'Lu', 'Ma', 'Mi', 'Ju', 'Vi', 'Sa'],
            monthNames: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
            firstDay: 1
        }

    }, function (start, end, label) {
        console.log(start.toISOString(), end.toISOString(), label);
        $('#result1').val(start.format('YYYY-MM-DD')+' '+'00:00:00');
        $('#result2').val(end.format('YYYY-MM-DD')+' '+'23:59:59');
        $('#fecha1 span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
        table.draw();
    });
     $('#fecha1').on('click', function () {
            document.getElementById("fecha1").value = "";//se toma el id del elemento y se hace vacio el valor del mismo
            document.getElementById("result1").value = "";//se toma el id del elemento y se hace vacio el valor del mismo
            document.getElementById("result2").value = "";//se toma el id del elemento y se hace vacio el valor del mismo
            table.draw();//devuelve este valor a la escritura de la tabla para reiniciar los valores por defecto
        });
//        $('a.toggle-vis').on('click', function (e) {//esta funcion se usa para mostrar columnas ocultas de la tabla donde a.toggle-vis es el <a class> de la vista 
//            e.preventDefault();
//
//            // toma el valor que viene de la vista en <a data-column>para establecer la columna a mostrar
//            var column = table.column($(this).attr('data-column'));
//
//            // Esta es la funcion que hace el cambio de la columna
//            column.visible(!column.visible());
//        });

       
});    
</script>
<!-- Page content -->
<style>
.fancy-checkbox input[type="checkbox"],
.fancy-checkbox .checked {
    display: none;
}
 
.fancy-checkbox input[type="checkbox"]:checked ~ .checked
{
    display: inline-block;
}
 
.fancy-checkbox input[type="checkbox"]:checked ~ .unchecked
{
    display: none;
}
</style>
<div class="mainy">
    <!--<a href="'.base_url().'index.php/mnt_cuadrilla/detalle/'. $r->id.'">'.$r->cuadrilla.'</a> Para cuadrillas get cuadrillas--> 

    <?php if ($this->session->flashdata('create_orden') == 'success') : ?>
        <div class="alert alert-success" style="text-align: center">Solicitud creada con éxito</div>
    <?php endif ?>
    <?php if ($this->session->flashdata('create_orden') == 'error') : ?>
        <div class="alert alert-danger" style="text-align: center">Ocurrió un problema creando su solicitud</div>
    <?php endif ?>
    <?php if ($this->session->flashdata('asigna_cuadrilla') == 'success') : ?>
        <div class="alert alert-success" style="text-align: center">Cuadrilla asignada con éxito</div>
    <?php endif ?>
    <?php if ($this->session->flashdata('asigna_cuadrilla') == 'responsable') : ?>
        <div class="alert alert-success" style="text-align: center">Responsable de la orden modificado con éxito</div>
    <?php endif ?>
    <?php if ($this->session->flashdata('asigna_cuadrilla') == 'error') : ?>
        <div class="alert alert-danger" style="text-align: center">Ocurrió un problema asignando la cuadrilla... Verifique los datos</div>
    <?php endif ?>
    <?php if ($this->session->flashdata('asigna_cuadrilla') == 'quitar') : ?>
    <div class="alert alert-success" style="text-align: center">Proceso realizado con éxito... Recuerde volver asignar la cuadrilla</div>
    <?php endif ?>
    <?php if ($this->session->flashdata('asign_help') == 'success') : ?>
        <div class="alert alert-success" style="text-align: center">Proceso realizado con éxito</div>
    <?php endif ?>
    <?php if ($this->session->flashdata('asign_help') == 'error') : ?>
        <div class="alert alert-danger" style="text-align: center">Ocurrió un problema Realizando el proceso</div>
    <?php endif ?>
    <?php if ($this->session->flashdata('estatus_orden') == 'success') : ?>
        <div class="alert alert-success" style="text-align: center">El cambio de estatus fué agregado con éxito</div>
    <?php endif ?>
    <?php if ($this->session->flashdata('estatus_orden') == 'error') : ?>
        <div class="alert alert-danger" style="text-align: center">Ocurrió un problema cambiando el estatus de la solicitud... Debe seleccionar una opción</div>
    <?php endif ?>
    

    <!-- Page title --> 
    <div class="page-title">
        <h2 align="right"><i class="fa fa-desktop color"></i> Consulta de solicitud <small>Seleccione para ver detalles </small></h2>
        <hr />
    </div>

    <!-- Page title -->
    <!--<div class="row">-->
        <div class="panel panel-default">
            <div class="panel-heading"><label class="control-label">Lista de Solicitudes</label>
                <div class="btn-group btn-group-sm pull-right">
                 <a href="<?php echo base_url() ?>index.php/mnt_solicitudes/cerrada" class="btn btn-warning">Cerradas/Anuladas</a>
                 <a href="<?php echo base_url() ?>index.php/mnt_solicitudes/solicitud" class="btn btn-success">Crear Solicitud</a>
                </div>
            </div>
            <div class="panel-body">
                <input type="hidden" id="valor" name="valor">  <!--estos inputs vienen del custom js en la funcion externa de busqueda por -->
                <input type="hidden" id="result1" name="result1"><!-- rangos para mostrar los resultados, estan ocultos despues de probar -->
                <input type="hidden" id="result2" name="result1"><!--por lo cual se pueden cambiar a tipo text para ver como funciona la busqueda-->
                <div class="table-responsive">

                    <div class="controls-row">
                        <div class="control-group col col-lg-3 col-md-3 col-sm-3"></div>
                        <div class="control-group col col-lg-3 col-md-3 col-sm-3">
                            <div class="input-group">
                                <span class="input-group-addon" id="basic-addon1"><i class="fa fa-calendar"></i></span>
                                <input type="search"  class="form-control input-sm" style="width: 200px" name="fecha1" id="fecha1" placeholder=" Búsqueda por Fechas" />
                            </div>
                        </div>
                        <div class="control-group col col-lg-3 col-md-3 col-sm-3">
                            <div class="input-group">
                                <input type="text" class="form-control input-sm" style="width: 200px" id="buscador" placeholder=" Búsqueda general">
                                <span class="input-group-addon" id="basic-addon2"><i class="fa fa-search"></i></span>
                            </div>
                        </div>
                        <div class="control-group col col-lg-12 col-md-12 col-sm-12">
<!--                            <div class="form-control" align="center">
                                <a class="toggle-vis" data-column="8">Haz click aquí para cambiar el estatus de una solicitud</a>
                            </div>-->
                        </div>
                    </div>
                    <div class="col-lg-12">
                        
                    </div>
                    <div class="col-lg-12 col-md-12 col-sm-12">
                        <table id="solicitudes" class="table table-hover table-bordered table-condensed" align="center" width="100%">
                            <thead>
                                <tr >
                                    <!--<th rowspan="2"></th>-->
                                    <th rowspan="2" valign="middle"><div align="center">Orden</div></th>
                            <th colspan="3"></th>
                            <th colspan="1"></th>
                            <!--<th colspan="1"></th>-->
                    <?php //if ($this->session->userdata('user')['sys_rol'] == 'autoridad'): ?>
                            <th colspan="2"><div align="center">Asignar personal</div></th>
                    <?php // endif ?>      
                            </tr>
                            <tr>
                                <th>Fecha</th>
                                <th>Dependencia</th>
                                <th>Asunto</th>
<!--                                <th>Estatus</th>-->
                                <th>Estatus</th>
                     <?php // if ($this->session->userdata('user')['sys_rol'] == 'autoridad'):?>
                                <th><span title="Asignar cuadrillas"><img src="<?php echo base_url() ?>assets/img/mnt/tecn5.png" class="img-rounded" alt="bordes redondeados" width="30" height="30"></span></th>
                                <th><span title="Asignar ayudantes"><img src="<?php echo base_url() ?>assets/img/mnt/ayudantes4.png" class="img-rounded" alt="bordes redondeados" width="30" height="30"></span></th>
                     <?php // endif ?>
                            </tr>
                            </thead>
                            <tbody>
                               
                                </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
</div>    
        
        <!-- Modal -->
        <?php foreach ($mant_solicitudes as $key => $sol) : ?>
        <!-- modal de cuadrilla -->
        <div id="cuad<?php echo $sol['id_orden'] ?>" class="modal modal-message modal-info fade" tabindex="-1" role="dialog" aria-labelledby="cuadrilla" >
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                             <label class="modal-title">Asignar Cuadrilla</label>
                            <span><i class="glyphicon glyphicon-pushpin"></i></span>
                        </div>
                        <div class="modal-body row">
                            <div class="col-md-12">
                                <h4><label>Solicitud Número:
                                        <label name="data" id="data"></label>
                                    </label>
                                </h4>
                            </div>
                            <div class="col-md-6">
                                <label class="control-label" for = "tipo">Tipo:</label>
                                    <label class="control-label" id="tipo"></label>
                            </div>
                            <div class="col-md-6">
                                <label class="control-label" for = "tipo">Asunto:</label>
                                <label class="control-label" id="asunto"></label>
                            </div>
                           
                            <form class="form" action="<?php echo base_url() ?>index.php/mnt_asigna_cuadrilla/mnt_asigna_cuadrilla/asignar_cuadrilla" method="post" name="modifica" id="modifica">
                              <?php if (($sol['tiene_cuadrilla']== 'si') || (empty($sol['tiene_cuadrilla']))):?>
                                  <?php if (empty($sol['cuadrilla'])): ?>
                                            <input type ="hidden" id="num_sol" name="num_sol" value="<?php echo $sol['id_orden'] ?>">
                                            <div class="col-md-2">
                                                <label class="control-label" for="cuadrilla">Cuadrilla</label>
                                            </div>
                                            <div class="col-md-12">
                                            <div class="form-group">
                                                <select class = "form-control select2" id = "cuadrilla_select<?php echo $sol['id_orden'] ?>" name="cuadrilla_select" onchange="mostrar(this.form.num_sol, this.form.cuadrilla_select, this.form.responsable, ($('#<?php echo $sol['id_orden'] ?>')))">
                                                    <option></option>
                                              <?php foreach ($cuadrilla as $cuad): ?>
                                                        <option value = "<?php echo $cuad->id ?>"><?php echo $cuad->cuadrilla ?></option>
                                              <?php endforeach; ?>
                                                </select>
                                            </div>
                                            </div>
                                            <div class="col-md-12">
                                                <label class="control-label" for = "responsable">Responsable de la orden</label>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <select class = "form-control select2" id = "responsable" name="responsable">
                                                        <option></option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div id= "test" class="col-md-12">
                                                <br>
                                                <div id="<?php echo $sol['id_orden'] ?>">
                                                <!--aqui se muestra la tabla de las cuadrillas-->
                                                </div>
                                            </div>
                                  <?php else: ?>
                                            <input type ="hidden" id="cut" name="cut" value="<?php echo $sol['id_orden'] ?>">
                                            <input type ="hidden" id="cuadrilla" name="cuadrilla" value="<?php echo $sol['id_cuadrilla'] ?>">
                                            <!--<div align="center"><label class="alert-danger">Esta cuadrilla ya fue asignada</label></div>-->
                                            <div class="col-md-6">
                                                <label>Jefe de cuadrilla:</label>
                                                <label name="respon" id="respon<?php echo $sol['id_orden'] ?>"></label>
                                            </div>
                                            <!--<div class="row">-->
                                            <div class="col-md-3"></div>
                                                <div class="col-md-12">
                                                    <div class="col-md-5">
                                                        <label>Responsable de la orden:</label>
                                                    </div>
                                                <div class="input-group input-group">                                                   
                                                    <select title="Responsable de la orden" class = "form-control" id = "responsable<?php echo($sol['id_orden']) ?>" name="responsable" disabled>
                                                    <!--<option selected=" " value = "">--Seleccione--</option>-->
                                                    </select>
                                                    <span class="input-group-addon">
                                                        <label class="fancy-checkbox" title="Haz click para editar responsable">
                                                            <input  type="checkbox"  id="mod_resp<?php echo $sol['id_orden'] ?>"/>
                                                            <i class="fa fa-fw fa-edit checked" style="color:#D9534F"></i>
                                                            <i class="fa fa-fw fa-pencil unchecked "></i>
                                                        </label>
                                                    </span>
                                                </div><!-- /input-group 
                                                --</div>-->
                                                <br>
                                            <!--<br>-->
                                                <div class="col-lg-12"></div>
                                                <div class="col-lg-14">
                                                <!--<div class="col-md-6"><label for = "responsable">Miembros de la Cuadrilla</label></div>-->
                                                    <div id="show_signed<?php echo $sol['id_orden'] ?>" >
                                                      <!--mostrara la tabla de la cuadrilla asignada-->   
                                                    </div>
                                                </div>
                                                <br>
                                                <div class="col-lg-12">
                                                    <div class="form-control alert-success" align="center">
                                                        <label class="checkbox-inline"> 
                                                            <input type="checkbox" id="otro<?php echo $sol['id_orden'] ?>" value="opcion_1">Quitar asignación de la cuadrilla
                                                        </label>        
                                                    </div>
                                                </div>
                                                <br> 
                                 <?php  endif;
                                    else:
                                ?>
                                        <div class="col-lg-12">
                                            <div class="alert alert-warning" style="text-align: center">No se puede asignar cuadrillas ya que un ayudante es responsable de la orden</div>
                                        </div>
                              <?php endif;?>
                                                <br>   
                                                    <div class="modal-footer">
                                                        <div class = "col-md-12">
                                                            <input  type="hidden" name="uri" value="<?php echo $this->uri->uri_string() ?>"/>
                                                            <button type="button" class="btn btn-default" data-dismiss="modal" aria-hidden="true">Cancelar</button>
                                                      <?php if (($sol['tiene_cuadrilla']== 'si') || (empty($sol['tiene_cuadrilla']))):?>
                                                                <button type="submit" id="<?php echo $sol['id_orden'] ?>" class="btn btn-primary">Guardar cambios</button>
                                                      <?php endif;?>
                                                        </div>
                                                    </div>
                                                </div>
                            </form>
                        </div>
                    </div>
                </div>
        </div>
     <!-- fin de modal de cuadrilla-->
     
     <!-- MODAL DE AYUDANTES-->
        <div id="ayudante<?php echo $sol['id_orden'] ?>" class="modal modal-message modal-info fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
             <div class="modal-dialog">
                 <div class="modal-content">
                     <div class="modal-header">
                         <h4 class="modal-title">Asignar Ayudantes</h4>
                     </div>
                     <div class="modal-body">
                         <div class="col-md-12">
                                <h4><label>Solicitud Número:
                                        <label name="data" id="data"></label>
                                    </label>
                                </h4>
                            </div>
                            <div class="col-md-6">
                                <label class="control-label" for = "tipo">Tipo:</label>
                                    <label class="control-label" id="tipo"></label>
                            </div>
                            <div class="col-md-6">
                                <label class="control-label" for = "tipo">Asunto:</label>
                                <label class="control-label" id="asunto"></label>
                            </div>
                         <div>
                        <form id="ay<?php echo $sol['id_orden'] ?>" class="form-horizontal" action="<?php echo base_url() ?>index.php/mnt/asignar/ayudante" method="post">
     
                        <?php if (empty($sol['cuadrilla'])): ?>
                              <div class="col-md-5">
                                <label>Responsable de la orden:</label>
                             </div>                             
                        <?php if(empty($sol['id_responsable'])):?>
                             
                             <div class="col-md-7">
                                <div class="form-group">
                                    <select class = "form-control input" id = "responsable<?php echo($sol['id_orden']) ?>" name="responsable">
                                        <!--<option ></option>-->
                                    </select>
                                </div>
                             </div>  <?php
                             else:?>
                                <div class="col-md-7">
                                <div class="input-group input-group">
                                    <select title="Responsable de la orden" class = "form-control input select2" id = "responsable<?php echo($sol['id_orden']) ?>" name="responsable" disabled>
                                        
                                    </select>
                                    <span class="input-group-addon">
                                        <label class="fancy-checkbox" title="Haz click para editar responsable">
                                            <input  type="checkbox"  id="mod_resp<?php echo $sol['id_orden'] ?>"/>
                                            <i class="fa fa-fw fa-edit checked" style="color:#D9534F"></i>
                                            <i class="fa fa-fw fa-pencil unchecked "></i>
                                        </label>
                                     </span>
                                </div>
                                </div>
                            <?php endif;
                            else:?>
                               <div class="col-md-12">
                                <label>Responsable de la orden: <?php echo $sol['responsable'] ?></label>
                             </div>                              
                        <?php endif; ?>
                             <br>
                             <br>
                             <div class="col-md-12"></div>
                            <ul class="nav nav-tabs" role="tablist">
                                <li class="active">
                                    <a href="#tab-table1<?php echo $sol['id_orden'] ?>" data-toggle="tab">Ayudantes asignados</a>
                                </li>
                                <li>
                                    <a href="#tab-table2<?php echo $sol['id_orden'] ?>" data-toggle="tab">Ayudantes disponibles</a>
                                </li>
                            </ul>
                            <div class="tab-content">
                                <div class="tab-pane active" id="tab-table1<?php echo $sol['id_orden'] ?>">
                                 <div id='asignados<?php echo $sol['id_orden'] ?>'>
                                    <!-- AQUI CONSTRULLE UNA LISTA DE AYUDANTES ASIGNADOS A LA ORDEN (revisar script mainFunctions.js linea 208 en adelante)-->
                                    </div>
                                </div>
                                <div class="tab-pane" id="tab-table2<?php echo $sol['id_orden'] ?>">
                                    <div id='disponibles<?php echo $sol['id_orden'] ?>'>
                                    <!-- AQUI CONSTRULLE UNA LISTA DE AYUDANTES DISPONIBLES NO ASIGNADOS A LA ORDEN (revisar script mainFunctions.js linea 208 en adelante)-->
                                 </div>
                                    
                                </div>
                            </div>
                         <?php if ($sol['tiene_cuadrilla']== 'no'):?>     
                             <div class="col-lg-12">
                                 <div class="form-control alert-success" align="center">
                                    <label class="checkbox-inline"> 
                                        <input type="checkbox" id="otro<?php echo $sol['id_orden'] ?>" name="cut" value="opcion_1">Quitar asignación de la orden
                                    </label>        
                                 </div>
                            </div>
                        <?php endif; ?>
                             <br>
                            </form>                      
                         </div>
                            
                            <div class="modal-footer">
                                <input form="ay<?php echo $sol['id_orden'] ?>" type="hidden" name="uri" value="<?php echo $this->uri->uri_string() ?>"/>
                                 <input form="ay<?php echo $sol['id_orden'] ?>" type="hidden" name="id_orden_trabajo" value="<?php echo $sol['id_orden'] ?>"/>
                                <button type="button" class="btn btn-default" data-dismiss="modal" aria-hidden="true">Cancelar</button>
                                <button form="ay<?php echo $sol['id_orden'] ?>" type="submit" class="btn btn-primary">Guardar cambios</button>
                            </div>

                     </div>
                     
                 </div>
             </div> 
        </div>
    <!-- FIN DE MODAL DE AYUDANTES-->
    <!-- fin Modal --> 
     <!-- Modal para cambiar el estatus de una solicitud-->
    <div id="estatus_sol<?php echo $sol['id_orden'] ?>" class="modal modal-message modal-info fade" tabindex="-1" role="dialog" aria-labelledby="mod" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <label class="modal-title">Cambiar Estatus</label>
                    
                </div>
                <form class="form" action="<?php echo base_url() ?>index.php/mnt_estatus_orden/cambiar_estatus" method="post" name="edita" id="edita" onsubmit="if ($('#<?php echo $sol['id_orden'] ?>')){return valida_motivo($('#motivo<?php echo $sol['id_orden'] ?>'));}">
                    <div class="modal-body row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="control-label" for = "estatus">Estatus:</label>
                                    <input type="hidden" id="orden" name="orden" value="<?php echo $sol['id_orden'] ?>">
                                    <input type="hidden" id="id_cu" name="id_cu" value="<?php echo $sol['id_cuadrilla'] ?>">
                                    <!-- SWITCH PARA EVALUAR OPCIONES DEL ESTATUS DE LA SOLICITUD-->
                                        <?php switch ($sol['descripcion'])
                                        {
                                            case 'ANULADA':
                                                echo '<div class="alert alert-info" align="center"><strong>¡La solicitud fué anulada. No puede cambiar de estatus!<strong></div>';
                                                break;
                                            default:?>
                                            <?php if (($sol['descripcion']!= 'EN PROCESO') && ($sol['descripcion']!= 'PENDIENTE POR MATERIAL') && ($sol['descripcion']!= 'PENDIENTE POR PERSONAL'))
                                            {
                                                echo '<div class="alert alert-warning" align="center"><strong>¡La solicitud está abierta. Debe asignar un personal!<strong></div>';
                                            }else{?>
                                            <select class="form-control select2" id = "sel<?php echo $sol['id_orden'] ?>" name="select_estado">
                                                    <?php if($sol['descripcion']!= 'ABIERTA'):?>
                                                         <option value=""></option>
                                                    <?php endif; 
                                                foreach ($estatus as $est): ?>
                                                    <?php if ($sol['descripcion'] != $est->descripcion): ?>
                                                        <option value = "<?php echo $est->id_estado ?>"><?php echo $est->descripcion ?></option>
                                                    <?php  endif;
                                                endforeach; ?>
                                            </select>
                                            <div id="<?php echo $sol['id_orden'] ?>" name= "observacion">
                                                 <label class="control-label" for="observacion">Motivo:</label>
                                                    <div class="control-label">
                                                        <textarea rows="3" autocomplete="off" type="text" onKeyDown=" contador(this.form.motivo,($('#quitar<?php echo $sol['id_orden'] ?>')),160);" onKeyUp="contador(this.form.motivo,($('#quitar<?php echo $sol['id_orden'] ?>')),160);"
                                                        value="" style="text-transform:uppercase;" onkeyup="javascript:this.value = this.value.toUpperCase();" class="form-control" id="motivo<?php echo $sol['id_orden'] ?>" name="motivo" placeholder='Indique el motivo..'></textarea>
                                                    </div> 
                                                    <small><p  align="right" name="quitar" id="quitar<?php echo $sol['id_orden'] ?>" size="4">0/160</p></small>
                                            </div>
                                        <?php
                                            };
                                        break;
                                        } ?>
                                </div>
                            </div>
                        </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal" aria-hidden="true">Cancelar</button>
                        <?php if($sol['descripcion']!= 'ABIERTA'):?>
                            <button type="submit" class="btn btn-primary" id="<?php echo $sol['id_orden'] ?>" >Enviar</button>
                        <?php endif;?>
                        <input  type="hidden" name="uri" value="<?php echo $this->uri->uri_string() ?>"/>
                    </div>
              
               </form> <!-- /.fin de formulario -->
           </div> <!-- /.modal-content -->
        </div> <!-- /.modal-dialog -->
    </div><!-- /.Fin de modal estatus-->
    <?php endforeach ?>
<!--</div>-->


<script>
    // funcion para habilitar input segun algunas opciones del select de estatus de solicitudes
  // function statusOnChange(sel,div,txt) {
    //    var test = sel.value;
    //    switch (test){
     //      case '3':
       //    case '4':     
         //  case '5':     
          // case '6':     
            //var divC = ($(div));
            //divC.show();
          //  $(txt).removeAttr('disabled');
         //  break;
       // default:
         //   divC = ($(div));
        //    divC.hide();
         //   $(txt).attr('disabled','disabled');
         //   break;
      //  }
   // }; -->
    //funcion para validar que el input motivo no quede vacio(esta funcion se llama en el formulario de estatus de la solicitud)
    function valida_motivo(txt) {
        if($(txt).val().length < 1) {  
        $(txt).focus();
        swal({
            title: "Error",
            text: "El motivo es obligatorio",
            type: "error"
        });
       return false;  
   }
}
    
</script>