<script src="<?php echo base_url() ?>assets/js/jquery.min.js"></script>
<script type="text/javascript">
    base_url = '<?= base_url() ?>';
    $(document).ready(function () {
        //para usar dataTable en la table solicitudes
        var table = $('#solicitudes').DataTable({
            "bProcessing": true,
            "bDeferRender": true,
            "pagingType": "full_numbers", //se usa para la paginacion completa de la tabla
            "sDom": '<"top"lp<"clear">>rt<"bottom"ip<"clear">>', //para mostrar las opciones donde p=paginacion,l=campos a mostrar,i=informacion
            "order": [[1, "desc"]], //para establecer la columna a ordenar por defecto y el orden en que se quiere 
            "aoColumnDefs": [{"orderable": false, "targets": [0, 8]}]//para desactivar el ordenamiento en esas columnas
        });
        table.column(8).visible(false);//para hacer invisible una columna usando table como variable donde se guarda la funcion dataTable 
        table.column(0).visible(false);
        //$('div.dataTables_filter').appendTo(".search-box");//permite sacar la casilla de busqueda a un div donde apppendTo se escribe el nombre del div destino
        $('#buscador').keyup(function () { //establece un un input para el buscador fuera de la tabla
            table.search($(this).val()).draw(); // escribe la busqueda del valor escrito en la tabla con la funcion draw
        });


        $('a.toggle-vis').on('click', function (e) {//esta funcion se usa para mostrar columnas ocultas de la tabla donde a.toggle-vis es el <a class> de la vista 
            e.preventDefault();

            // toma el valor que viene de la vista en <a data-column>para establecer la columna a mostrar
            var column = table.column($(this).attr('data-column'));

            // Esta es la funcion que hace el cambio de la columna
            column.visible(!column.visible());
        });

        $('#fecha').change(function () {//este es el input que funciona con el dataranger para mostrar las fechas
            table.draw(); // la variable table, es la tabla a buscar la fecha

        });
        //esta funcion permite que al hacer click sobre el input de la fecha para borrar el valor que tenga 
        $('#fecha').on('click', function () {
            document.getElementById("fecha").value = "";//se toma el id del elemento y se hace vacio el valor del mismo
            table.draw();//devuelve este valor a la escritura de la tabla para reiniciar los valores por defecto
        });
});    
</script>
<!-- Page content -->

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
    <?php if ($this->session->flashdata('asigna_cuadrilla') == 'error') : ?>
        <div class="alert alert-danger" style="text-align: center">Ocurrió un problema asignando la cuadrilla... Verifique los datos</div>
    <?php endif ?>
    <?php if ($this->session->flashdata('asigna_cuadrilla') == 'quitar') : ?>
    <div class="alert alert-danger" style="text-align: center">Proceso realizado con éxito... Recuerde volver asignar la cuadrilla</div>
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
    <div class="row">
        <div class="panel panel-default">
            <div class="panel-heading"><label class="control-label">Lista de Solicitudes</label>
                <div class="btn-group btn-group-sm pull-right">
                 <a href="<?php echo base_url() ?>index.php/mnt_solicitudes/cerrada" class="btn btn-info">Cerradas</a>
                 <a href="<?php echo base_url() ?>index.php/mnt_solicitudes/solicitud" class="btn btn-success">Crear Solicitud</a>
                </div>
            </div>
            <div class="panel-body">
                <input type="hidden" id="valor" name="valor">  <!--estos inputs vienen del custom js en la funcion externa de busqueda por -->
                <input type="hidden" id="result1" name="result1"><!-- rangos para mostrar los resultados, estan ocultos despues de probar -->
                <input type="hidden" id="result2" name="result1"><!--por lo cual se pueden cambiar a tipo text para ver como funciona la busqueda-->
                <div class="table-responsive">

                    <div class="controls-row">
                        <div class="control-group col col-lg-3 col-md-3 col-sm-3">
                            <div class="input-group">
                                <span class="input-group-addon" id="basic-addon1"><i class="fa fa-calendar"></i></span>
                                <input type="search" readonly class="form-control input-sm" style="width: 200px" name="fecha" id="fecha" placeholder="Fecha" />
                            </div>
                        </div>
                        <div class="control-group col col-lg-3 col-md-3 col-sm-3">
                            <div class="input-group">
                                <input type="text" class="form-control input-sm" style="width: 200px" id="buscador">
                                <span class="input-group-addon" id="basic-addon2"><i class="fa fa-search"></i></span>
                            </div>
                        </div>
                        <div class="control-group col col-lg-12 col-md-12 col-sm-12">
                            <div class="form-control" align="center">
                                <a class="toggle-vis" data-column="8">Haz click aquí para cambiar el estatus de una solicitud</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-12 col-md-12 col-sm-12">
                        <table id="solicitudes" class="table table-hover table-bordered table-condensed" align="center" width="100%">
                            <thead>
                                <tr >
                                    <th rowspan="2"></th>
                                    <th rowspan="2" valign="middle"><div align="center">Orden</div></th>
                            <th colspan="4"></th>
                            <th colspan="2"><div align="center">Asignar personal</div></th>
                            <th rowspan="2"><div valign="middle" align="center">Cambio de estatus</div></th>
                            </tr>
                            <tr>
                                <th>Fecha</th>
                                <th>Dependencia</th>
                                <th>Asunto</th>
                                <th>Estatus</th>
                                <th><span title="Asignar cuadrillas"><img src="<?php echo base_url() ?>assets/img/mnt/tecn5.png" class="img-rounded" alt="bordes redondeados" width="30" height="30"></span></th>
                                <th><span title="Asignar ayudantes"><img src="<?php echo base_url() ?>assets/img/mnt/ayudantes4.png" class="img-rounded" alt="bordes redondeados" width="30" height="30"></span></th>
                            </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($mant_solicitudes as $key => $sol) : ?>
                                    <tr>
                                        <td><input type="checkbox"></td>
                                        <td>
                                            <a href="<?php echo base_url() ?>index.php/mnt_solicitudes/detalle/<?php echo $sol['id_orden'] ?>">
                                                <?php echo $sol['id_orden'] ?>
                                            </a>
                                        </td>
                                        <td><?php echo date("d/m/Y", strtotime($sol['fecha'])); ?></td>
                                        <td> <?php echo $sol['dependen']; ?></td>
                                        <td> <?php echo $sol['asunto']; ?></td>
                                        <td> <?php echo $sol['descripcion']; ?></td>
                                        <td> <?php 
                                            if (!empty($sol['cuadrilla'])): ?>
                                                <a onclick='cuad_asignada(($("#respon<?php echo($sol['id_orden']) ?>")),<?php echo json_encode($sol['id_orden']) ?>,<?php echo json_encode($sol['id_cuadrilla']) ?>, ($("#show_signed<?php echo $sol['id_orden'] ?>")), ($("#otro<?php echo $sol['id_orden'] ?>")))' href='#cuad<?php echo $sol['id_orden'] ?> ' data-toggle="modal" data-id="<?php echo $sol['id_orden']; ?>" data-asunto="<?php echo $sol['asunto'] ?>" data-tipo_sol="<?php echo $sol['tipo_orden']; ?>" class="open-Modal" >
                                                    <div align="center"> <img title="Cuadrilla asignada" src="<?php echo base_url() . $sol['icono']; ?>" class="img-rounded" alt="bordes redondeados" width="25" height="25"></div></a>
                                                <?php
                                            else :
                                                ?>
                                                <a href='#cuad<?php echo $sol['id_orden'] ?> ' data-toggle="modal" data-id="<?php echo $sol['id_orden']; ?>" data-asunto="<?php echo $sol['asunto'] ?>" data-tipo_sol="<?php echo $sol['tipo_orden']; ?>" class="open-Modal" >
                                                    <div align="center"><i title="Asignar cuadrilla"class="glyphicon glyphicon-pencil" style="color:#D9534F"></i></div></a>
                                            <?php endif; ?>                      
                                        </td>
                                        <td><a onclick='ayudantes(<?php echo json_encode($sol['id_orden']) ?>, ($("#disponibles<?php echo $sol['id_orden'] ?>")), ($("#asignados<?php echo $sol['id_orden'] ?>")))' href='#ayudante<?php echo $sol['id_orden'] ?>' data-toggle="modal"><div align="center"><?php if(in_array(array('id_orden_trabajo' => $sol['id_orden']), $ayuEnSol)){ echo('<i title="Agregar ayudantes" class="glyphicon glyphicon-plus" style="color:#5BC0DE"></i>');} else { echo ('<i title="Asignar ayudantes" class="glyphicon glyphicon-pencil" style="color:#D9534F"></i>');}?></div></a></td>
                                        <td> <!-- SELECT PARA CAMBIAR EL ESTATUS DE LA SOLICITUD-->
                                            <form class="form" action="<?php echo base_url() ?>index.php/mnt_estatus_orden/cambiar_estatus" method="post" name="edita" id="edita" onsubmit="if ($('#<?php echo $sol['id_orden'] ?>').is (':visible')){return valida_motivo($('#motivo<?php echo $sol['id_orden'] ?>'));}">
                                                <div class="form-group">
                                                    <div class="col-lg-1">
                                                        <input type="hidden" id="orden" name="orden" value="<?php echo $sol['id_orden'] ?>">
                                                        <input type="hidden" id="id_cu" name="id_cu" value="<?php echo $sol['id_cuadrilla'] ?>">
                                                        <!-- SWITCH PARA EVALUAR OPCIONES DEL ESTATUS DE LA SOLICITUD-->
                                                            <?php switch ($sol['descripcion'])
                                                            {
                                                                case 'CERRADA':                                                                   
                                                                case 'ANULADA':
                                                                    echo '<span class="label label-info">No puede cambiar el estatus</span>';
                                                                    break;
                                                                default:?>
                                                                <?php if (($sol['descripcion']!= 'EN PROCESO') && ($sol['descripcion']!= 'PENDIENTE POR MATERIAL') && ($sol['descripcion']!= 'PENDIENTE POR PERSONAL'))
                                                                {
                                                                    echo '<span class="label label-warning">Debe asignar personal</span>';
                                                                }else{?>
                                                                <select class="form-control input-sm" id = "sel<?php echo $sol['id_orden'] ?>" name="select_estado" onchange="statusOnChange(this,$('#<?php echo $sol['id_orden'] ?>'),$('#motivo<?php echo $sol['id_orden'] ?>'))">
                                                                        <option value="">--SELECCIONE--</option>
                                                                        <?php if($sol['descripcion']!= 'ABIERTA'):?>
                                                                            <option selected = "$sol['estatus']" value = "<?php echo $sol['estatus'] ?>"><?php echo $sol['descripcion'] ?></option>
                                                                        <?php endif; 
                                                                    foreach ($estatus as $est): ?>
                                                                        <?php if ($sol['descripcion'] != $est->descripcion): ?>
                                                                            <option value = "<?php echo $est->id_estado ?>"><?php echo $est->descripcion ?></option>
                                                                        <?php  endif;
                                                                    endforeach; ?>
                                                                </select>
                                                                <div id="<?php echo $sol['id_orden'] ?>" name= "observacion" style="display:none;">
                                                                    <div id="<?php // echo $sol['id_orden'] ?>">
                                                                        <label class="control-label" for="observacion">Motivo:</label>
                                                                        <input style="text-transform:uppercase;" onkeyup="javascript:this.value = this.value.toUpperCase();" type="text" name="motivo" id="motivo<?php echo $sol['id_orden'] ?>">
                                                                    </div> 
                                                                </div>
                                                                
                                                                    <button class="btn btn-primary pull-left btn-xs" id="<?php echo $sol['id_orden'] ?>" type="submit">Enviar</button>
                                                                
                                                            <?php
                                                            };

                                                                    break;
                                                                   

                                                            } ?>
                                                                                                                      
                                                    </div>
                                                </div>
                                               
                                            </form>                                           
                                        </td>           
                                    </tr>
                                 <?php endforeach ?>
                                </tbody>
                        </table>
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
                                <?php if (empty($sol['cuadrilla'])): ?>
                                     <input type ="hidden" id="num_sol" name="num_sol" value="<?php echo $sol['id_orden'] ?>">
                                     <div class="col-md-2">
                                            <label class="control-label" for="cuadrilla">Cuadrilla</label>
                                     </div>
                                     <div class="col-md-12">
                                        <div class="form-grouṕ">
                                            <select class = "form-control" id = "cuadrilla_select" name="cuadrilla_select" onchange="mostrar(this.form.num_sol, this.form.cuadrilla_select, this.form.responsable, ($('#<?php echo $sol['id_orden'] ?>')))">
                                                <option selected=" " value = "">--Seleccione--</option>
                                                <?php foreach ($cuadrilla as $cuad): ?>
                                                    <option value = "<?php echo $cuad->id ?>"><?php echo $cuad->cuadrilla ?></option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                            <label class="control-label" for = "responsable">Responsable</label>
                                    </div>
                                    <div class="col-md-12"> 
                                     <input type="text" readonly="true" class="form-control" id = "responsable" name = "responsable">
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
                                      <div align="center"><label class="alert-danger">Esta cuadrilla ya fue asignada</label></div>
                                      <div align="center"><label>Jefe de cuadrilla:</label>
                                         <label name="respon" id="respon<?php echo $sol['id_orden'] ?>"></label>
                                      </div>
                                      <div class="col-md-6"><label for = "responsable">Miembros de la Cuadrilla</label></div>
                                      <div id="show_signed<?php echo $sol['id_orden'] ?>" class="col-md-12">
                                      <!--mostrara la tabla de la cuadrilla asignada-->   
                                      </div>
                                    
                                    <div class="col-md-12">
                                      <div class="form-control alert-warning" align="center">
                                       <label class="checkbox-inline"> 
                                          <input type="checkbox" id="otro<?php echo $sol['id_orden'] ?>" value="opcion_1">Quitar asignación de la cuadrilla
                                      </label>        
                                      </div>
                                    </div>
                                 <?php                                     
                                endif;?>
                                      
                                <div class="modal-footer">
                                    <div class = "col-md-12">
                                    <button type="submit" id="<?php echo $sol['id_orden'] ?>" class="btn btn-primary">Guardar cambios</button>
                                    <button type="button" class="btn btn-default" data-dismiss="modal" aria-hidden="true">Cancelar</button>
                                    </div>
                                </div>
                            </form>
                        </div>
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
                         <div>
                             <h4><label>Solicitud Número: 
                                     <?php echo $sol['id_orden'] ?>
                                 </label></h4>
                         </div>
                         <div id='disponibles<?php echo $sol['id_orden'] ?>'>
                             <!-- AQUI CONSTRULLE UNA LISTA DE AYUDANTES DISPONIBLES NO ASIGNADOS A LA ORDEN (revisar script mainFunctions.js linea 208 en adelante)-->
                         </div>
                         <div id='asignados<?php echo $sol['id_orden'] ?>'>
                             <!-- AQUI CONSTRULLE UNA LISTA DE AYUDANTES ASIGNADOS A LA ORDEN (revisar script mainFunctions.js linea 208 en adelante)-->
                         </div>

                         <div class="modal-footer">
                             <input form="ay<?php echo $sol['id_orden'] ?>" type="hidden" name="uri" value="<?php echo $this->uri->uri_string() ?>"/>
                             <input form="ay<?php echo $sol['id_orden'] ?>" type="hidden" name="id_orden_trabajo" value="<?php echo $sol['id_orden'] ?>"/>
                             <button form="ay<?php echo $sol['id_orden'] ?>" type="submit" class="btn btn-primary">Guardar cambios</button>

                             <button type="button" class="btn btn-default" data-dismiss="modal" aria-hidden="true">Cancelar</button>
                         </div>
                     </div>
                 </div>
             </div> 
        </div>
    <!-- FIN DE MODAL DE AYUDANTES-->
    <!-- fin Modal --> 
    <?php endforeach ?>
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
}
    
</script>