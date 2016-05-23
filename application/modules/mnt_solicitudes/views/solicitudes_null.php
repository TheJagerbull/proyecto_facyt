<script src="<?php echo base_url() ?>assets/js/jquery.min.js"></script>
<!--<script src="<?php echo base_url() ?>assets/js/star-ratings.js"></script>-->
<script type="text/javascript">
    base_url = '<?php echo base_url() ?>';
    $(document).ready(function () {
        //para usar dataTable en la table solicitudes
        var table = $('#solicitudes').DataTable({
            "language": {
                "url": "<?php echo base_url() ?>assets/js/lenguaje_datatable/spanish.json"
            },
            "bProcessing": true,
            "bDeferRender": true,
            stateSave: true,
            "stateLoadParams": function (settings, data) {
                $("#buscador").val(data.search.search);
            },
            "serverSide": true, //Feature control DataTables' server-side processing mode.
//        "searching": false,
            "pagingType": "full_numbers", //se usa para la paginacion completa de la tabla
            "sDom": '<"top"lp<"clear">>rt<"bottom"ip<"clear">>', //para mostrar las opciones donde p=paginacion,l=campos a mostrar,i=informacion
            "order": [[0, "desc"]], //para establecer la columna a ordenar por defecto y el orden en que se quiere 
//            "aoColumnDefs": [{"orderable": false, "targets": [0]}],//para desactivar el ordenamiento en esas columnas
        "ajax": {
            "url": "<?php echo site_url('mnt_solicitudes/mnt_solicitudes/list_sol/'.$est)?>",
            "type": "GET",
            "data": function ( d ) {
                d.uno = $('#result1').val();
                d.dos = $('#result2').val();
                d.dep = <?php echo $dep?>;
            }
        }
       
        });
  <?php if ($asig_per){?>
            table.column(5).visible(true);
            table.column(6).visible(true);
  <?php }else{?>
            table.column(5).visible(false);
            table.column(6).visible(false);
  <?php }?>
//        table.column(8).visible(false);//para hacer invisible una columna usando table como variable donde se guarda la funcion dataTable 
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
});    
</script>
<!-- Page content -->

<div class="mainy">
    
    <?php if ($this->session->flashdata('sugerencia') == 'success') : ?>
        <div class="alert alert-success" style="text-align: center">Calificación agregada con éxito</div>
    <?php endif ?>
    <?php if ($this->session->flashdata('sugerencia') == 'error') : ?>
        <div class="alert alert-danger" style="text-align: center">Ocurrió un problema agregando la calificación</div>
    <?php endif ?>
    
    <!-- Page title --> 
    <div class="page-title">
        <h2 align="right"><i class="fa fa-desktop color"></i> Consulta de solicitudes anuladas <small>Seleccione para ver detalles </small></h2>
        <hr />
    </div>

    <!-- Page title -->
    <div class="row">
        <div class="panel panel-default">
            <div class="panel-heading"><label class="control-label">Lista de Solicitudes Anuladas</label>
                <div class="btn-group btn-group-sm pull-right">
                    <?php if($close){?> 
                        <a href="<?php echo base_url() ?>index.php/mnt_solicitudes/cerrada" class="btn btn-default">Cerradas</a>
                    <?php } ?>
              <?php if ($ver){ ?>
                        <a href="<?php echo base_url() ?>index.php/mnt_solicitudes/lista_solicitudes" class="btn btn-success">En Proceso</a>
              <?php }
                    if($reportes){?>     
                        <a href="<?php echo base_url() ?>index.php/mnt_solicitudes/reportes" class="btn btn-info">Reportes</a>
                    <?php }
                    if ($crear || $crear_dep){?>
                        <a href="<?php echo base_url() ?>index.php/mnt_solicitudes/solicitud" class="btn btn-primary">Crear Solicitud</a>
              <?php } ?>
                    
                </div>
            </div>
            <div class="panel-body">
                <input type="hidden" id="valor" name="valor">  <!--estos inputs vienen del custom js en la funcion externa de busqueda por -->
                <input type="hidden" id="result1" name="result1"><!-- rangos para mostrar los resultados, estan ocultos despues de probar -->
                <input type="hidden" id="result2" name="result2"><!--por lo cual se pueden cambiar a tipo text para ver como funciona la busqueda-->
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
                    </div>
                    
                    <div class="col-lg-12 col-md-12 col-sm-12">
                        <table id="solicitudes" class="table table-hover table-bordered table-condensed" align="center" width="100%">
                            <thead>
                                <tr >
                                    <!--<th rowspan="2"></th>-->
                                    <th rowspan="2" valign="middle"><div align="center">Orden</div></th>
                            <th colspan="2"><div align="center">Fechas</div></th>
                            
                            <th colspan="2"></th>
                            <th colspan="2"><div align="center">Personal asignado</div></th>
                            <th></th>
                            
                            </tr>
                            <tr>
                                <th>Anulada</th>
                                <th>Creada</th>
                                <th>Dependencia</th>
                                <th>Asunto</th>
                                <th><span title="Cuadrillas asignadas"><img src="<?php echo base_url() ?>assets/img/mnt/tecn5.png" class="img-rounded" alt="bordes redondeados" width="30" height="30"></span></th>
                                <th><span title="Ayudantes asignados"><img src="<?php echo base_url() ?>assets/img/mnt/ayudantes4.png" class="img-rounded" alt="bordes redondeados" width="30" height="30"></span></th>
                                <th>Calificar</th>
                            </tr>
                            </thead>
                            <tbody>
                                <?php // foreach ($mant_solicitudes as $key => $sol) : ?>
<!--                                    <tr>
                                        <td><input type="checkbox"></td>
                                        <td>
                                            <a href="<?php echo base_url() ?>index.php/mnt_solicitudes/detalle/<?php echo $sol['id_orden'] ?>">
                                                <?php echo $sol['id_orden'] ?>
                                            </a>
                                        </td>
                                        <td><?php echo date("d/m/Y", strtotime($sol['fecha'])); ?></td>
                                        <td><?php echo date("d/m/Y", strtotime($sol['creada'])); ?></td>
                                        <td> <?php echo $sol['dependen']; ?></td>
                                        <td> <?php echo $sol['asunto']; ?></td>
                                        
                                        <td> <?php 
                                            if (!empty($sol['cuadrilla'])): ?>
                                               <a onclick='cuad_asignada($("#responsable<?php echo($sol['id_orden']) ?>"),($("#respon<?php echo($sol['id_orden']) ?>")),<?php echo json_encode($sol['id_orden']) ?>,<?php echo json_encode($sol['id_cuadrilla']) ?>, ($("#show_signed<?php echo $sol['id_orden'] ?>")), ($("#otro<?php echo $sol['id_orden'] ?>")),($("#mod_resp<?php echo $sol['id_orden'] ?>")))' href='#cuad<?php echo $sol['id_orden'] ?> ' data-toggle="modal" data-id="<?php echo $sol['id_orden']; ?>" data-asunto="<?php echo $sol['asunto'] ?>" data-tipo_sol="<?php echo $sol['tipo_orden']; ?>" class="open-Modal" >
                                                    <div align="center"> <img title="Cuadrilla asignada" src="<?php echo base_url() . $sol['icono']; ?>" class="img-rounded" alt="bordes redondeados" width="25" height="25"></div></a>
                                                <?php
                                            else :
                                                ?>
                                                <a href='#cuad<?php echo $sol['id_orden'] ?> ' data-toggle="modal" data-id="<?php echo $sol['id_orden']; ?>" data-asunto="<?php echo $sol['asunto'] ?>" data-tipo_sol="<?php echo $sol['tipo_orden']; ?>" class="open-Modal" >
                                                    <div align="center"><span title="Sin asignar"class="glyphicon glyphicon-minus" style="color:#D9534F"></span></div></a>
                                            <?php endif; ?>                      
                                        </td>
                                        <td><a onclick='ayudantes($("#mod_resp<?php echo $sol['id_orden'] ?>"),$("#responsable<?php echo($sol['id_orden']) ?>"),<?php echo json_encode($sol['estatus']) ?>,<?php echo json_encode($sol['id_orden']) ?>, ($("#disponibles<?php echo $sol['id_orden'] ?>")), ($("#asignados<?php echo $sol['id_orden'] ?>")))' href='#ayudante<?php echo $sol['id_orden'] ?>' data-toggle="modal" data-id="<?php echo $sol['id_orden']; ?>" data-asunto="<?php echo $sol['asunto'] ?>" data-tipo_sol="<?php echo $sol['tipo_orden']; ?>" class="open-Modal"><div align="center"><?php if(in_array(array('id_orden_trabajo' => $sol['id_orden']), $ayuEnSol)){ echo('<i title="Ayudantes asignados" class="glyphicon glyphicon-plus" style="color:#5BC0DE"></i>');} else { echo ('<i title="Ayudantes asignados" class="glyphicon glyphicon-pencil" style="color:#D9534F"></i>');}?></div></a></td>
                                          <td>
                                            <?php if (($sol['descripcion'] == 'CERRADA') && empty($sol['sugerencia'])) : ?>
                                                    <a href='#sugerencias<?php echo $sol['id_orden'] ?>' data-toggle="modal" data-id="<?php echo $sol['id_orden']; ?>" class="open-Modal">
                                                    <div align="center" title="Calificar"><img src="<?php echo base_url().'assets/img/mnt/opinion.png'?>" class="img-rounded" alt="bordes redondeados" width="25" height="25"></div></a>
                                                <?php elseif (($sol['descripcion'] == 'CERRADA') && (!empty($sol['sugerencia']))) : ?>
                                                    <a href='#sugerencias<?php echo $sol['id_orden'] ?>' data-toggle="modal" data-id="<?php echo $sol['id_orden']; ?>" class="open-Modal">
                                                    <div align="center" title="Calificar"><img src="<?php echo base_url().'assets/img/mnt/opinion1.png'?>" class="img-rounded" alt="bordes redondeados" width="25" height="25"></div></a>
                                            <?php endif ?>
                                        </td>
                                    </tr>-->
                                 <?php // endforeach ?>
                                </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        
        
        <!-- Modal -->
        <?php // foreach ($mant_solicitudes as $key => $sol) : ?>
<!--         modal de cuadrilla 
        <div id="cuad<?php echo $sol['id_orden'] ?>" class="modal modal-message modal-info fade" tabindex="-1" role="dialog" aria-labelledby="cuadrilla" >
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                             <label class="modal-title">Cuadrilla Asignada</label>
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
                        <form>
                                <?php if (empty($sol['cuadrilla'])): ?>
                            <div class="col-md-12">
                                <div class="alert alert-info" align="center"><strong>¡No hay cuadrilla asignada a esta solicitud</strong></div>
                            </div>
                                    <?php else: ?>
                                    
                                      <div class="col-md-12"><label>Jefe de cuadrilla:</label>
                                         <label name="respon" id="respon<?php echo $sol['id_orden'] ?>"></label>
                                      </div>
                                      <div class="col-md-12">
                                            <label class="control-label" for = "responsable">Responsable de la orden</label>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <select class = "form-control select2" id = "responsable<?php echo $sol['id_orden'] ?>" name="responsable" disabled>
                                                <option></option>
                                            </select>
                                        </div>
                                    </div>
                                      <div class="col-md-6"><label for = "miembros">Miembros de la Cuadrilla</label></div>
                                      <div id="show_signed<?php echo $sol['id_orden'] ?>" class="col-md-12">
                                      mostrara la tabla de la cuadrilla asignada   
                                      </div>
                                    
                               
                                 <?php                                     
                                endif;?>
                                      
                                <div class="modal-footer">
                                    <div class = "col-md-12">
                                    
                                    <button type="button" class="btn btn-default" data-dismiss="modal" aria-hidden="true">Cancelar</button>
                                    </div>
                                </div>
                        </form>
                        </div>
                    </div>
                </div>
        </div>
    </div>
      fin de modal de cuadrilla
     
      MODAL DE AYUDANTES
        <div id="ayudante<?php echo $sol['id_orden'] ?>" class="modal modal-message modal-info fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
             <div class="modal-dialog">
                 <div class="modal-content">
                     <div class="modal-header">
                         <h4 class="modal-title">Ayudantes asignados</h4>
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
                        <?php if (empty($sol['cuadrilla'])): ?>
                              <div class="col-md-5">
                                <label>Responsable de la orden:</label>
                             </div>                             
                        <?php if(empty($sol['id_responsable'])):?>
                              <div class="col-md-12">
                                <div class="alert alert-info" align="center"><strong>¡No hay responsable asignado a esta solicitud!</strong></div>
                            </div>

                            <?php
                             else:?>
                                <div class="col-md-12">
                                
                                    <select title="Responsable de la orden" class = "form-control input select2" id = "responsable<?php echo($sol['id_orden']) ?>" name="responsable" disabled>
                                        <option ></option>
                                    </select>
                                </div>
                            <?php endif;
                         else:?>
                               <div class="col-md-12">
                                <label>Responsable de la orden: <?php echo $sol['responsable'] ?></label>
                             </div>                              
                        <?php endif; ?>
                             <br>
                             <br>
                             
                             <div class="col-md-12">
                              
                                 <br>
                                 <div > <label>Ayudantes asignados</label> </div>
                                
                                
                            
                                              
                                 <div id='asignados<?php echo $sol['id_orden'] ?>'>
                                     AQUI CONSTRULLE UNA LISTA DE AYUDANTES ASIGNADOS A LA ORDEN (revisar script mainFunctions.js linea 208 en adelante)
                                    </div>
                                
                            </div>
                             </div>
                             <br>
                                                
                         </div>
                            
                            <div class="modal-footer">
                                <input form="ay<?php echo $sol['id_orden'] ?>" type="hidden" name="uri" value="<?php echo $this->uri->uri_string() ?>"/>
                                 <input form="ay<?php echo $sol['id_orden'] ?>" type="hidden" name="id_orden_trabajo" value="<?php echo $sol['id_orden'] ?>"/>
                                <button type="button" class="btn btn-default" data-dismiss="modal" aria-hidden="true">Cancelar</button>
                            </div>

                     </div>
                     
                 </div>
             </div> 
        </div>
     FIN DE MODAL DE AYUDANTES-->
    <!-- fin Modal --> 
    <!--modal de calificacion de solicitud-->
<!--         <div id="sugerencias<?php echo $sol['id_orden'] ?>" class="modal modal-message modal-info fade" tabindex="-1" role="dialog" style="display: none;">
            <div class="modal-dialog">
                <div class="modal-content">
                        <div class="modal-header">
                            <label class="modal-title">Calificar solicitud</label><img src="<?php echo base_url().'assets/img/mnt/opinion.png'?>" class="img-rounded" alt="bordes redondeados" width="25" height="25">
                        </div>
                    <form class="form" action="<?php echo base_url() ?>index.php/mnt_solicitudes/sugerencias" method="post" name="opinion" id="opinion" onsubmit="if ($('#<?php echo $sol['id_orden'] ?>')){return valida_calificacion($('#sugerencia<?php echo $sol['id_orden'] ?>'));}">
                        <?php if (empty($sol['sugerencia'])) : ?>
                            <input type="hidden" id= "id_orden" name="id_orden" value="<?php echo $sol['id_orden'] ?>">
                            <div class="modal-body">
                                    <div class="form-group">
                                        <label class="control-label" for="sugerencia">Califique la solicitud:</label>
                                            <div class="col-lg-20">
                                                <textarea rows="3" autocomplete="off" type="text" onKeyDown=" contador(this.form.sugerencia,($('#restar<?php echo $sol['id_orden'] ?>')),160);" onKeyUp="contador(this.form.sugerencia,($('#restar<?php echo $sol['id_orden'] ?>')),160);"
                                                          value="" style="text-transform:uppercase;" onkeyup="javascript:this.value = this.value.toUpperCase();" class="form-control" id="sugerencia<?php echo $sol['id_orden'] ?>" name="sugerencia" placeholder='CALIFIQUE EL SERVICIO COMO: SATISFECHO, BIEN, NO ME GUSTO E INDIQUE EL ¿POR QUE?'></textarea>
                                            </div>
                                            <small><p  align="right" name="restar" id="restar<?php echo $sol['id_orden'] ?>" size="4">0/160</p></small>
                                       
                                    </div>
                                    <?php else: ?>
                            <div class="form-group">
                                <div class="col-lg-12">
                                    <label class="control-label" for="sugerencia">Califique la solicitud:</label>
                                </div>
                                <div class="col-lg-12">
                                    <textarea class="form-control" rows="3" autocomplete="off" type="text" onKeyDown=" contador(this.form.sugerencia,($('#restar1<?php echo $sol['id_orden'] ?>')),160);" onKeyUp="contador(this.form.sugerencia,($('#restar1<?php echo $sol['id_orden'] ?>')),160);"
                                        id="sugerencia<?php echo $sol['id_orden'] ?>" name="sugerencia" disabled><?php echo $sol['sugerencia'] ?></textarea>
                                </div>
                                <div class="col-lg-12">
                                    <small><p  align="right" name="restar1" id="restar1<?php echo $sol['id_orden'] ?>" size="4">0/160</p></small>
                                </div>
                            </div>
                        <?php endif ?>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-default" data-dismiss="modal" aria-hidden="true">Cancelar</button>
                                <?php if (empty($sol['sugerencia'])) : ?>
                                    <button class="btn btn-primary" type="submit">Enviar</button>
                                <?php endif; ?>
                                <input  type="hidden" name="uri" value="<?php echo $this->uri->uri_string() ?>"/>
                            </div>
                        
                    </div>
                    </form>
                </div>
            </div>
        </div> FIN DE MODAL DE CALIFICAR SOLICITUD-->
    <?php // endforeach ?>
    </div>
  </div>

<script>
    // funcion para habilitar input segun algunas opciones del select de estatus de solicitudes
    function statusOnChange(sel,div,txt) {
        var test = sel.value;
        switch (test){
           case '3':
           case '4':     
           case '5':     
           case '6':     
            var divC = ($(div));
            divC.show();
            $(txt).removeAttr('disabled');
           break;
        default:
            divC = ($(div));
            divC.hide();
            $(txt).attr('disabled','disabled');
            break;
        }
    }; 
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
};
    //(funcion para validar la calificacion, valida el input de estrellas y el input de opinion)
   function valida_calificacion(txt,star) {
//        console.log($(star).val());
//        console.log($(txt).val().length);
        if($(star).val() > 0 && $(txt).val().length > 1)
        {
            return true;
        }
        else
        {
            if ($(star).val() < 1)
            {
                $(star).focus();
                    swal({
                        title: "Error",
                        text: "Debe calificar el servicio",
                        type: "error"
                    });
                   return false;
            }
            else
            {
                $(txt).focus();
                swal({
                    title: "Error",
                    text: "Debe colocar su opinión",
                    type: "error"
                });
               return false;
           }
           return false;
       }
   
};
    
</script>