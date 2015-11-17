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
            "aoColumnDefs": [{"orderable": false, "targets": [0]}]//para desactivar el ordenamiento en esas columnas
        });
//        table.column(8).visible(false);//para hacer invisible una columna usando table como variable donde se guarda la funcion dataTable 
        table.column(0).visible(false);
        //$('div.dataTables_filter').appendTo(".search-box");//permite sacar la casilla de busqueda a un div donde apppendTo se escribe el nombre del div destino
        $('#buscador').keyup(function () { //establece un un input para el buscador fuera de la tabla
            table.search($(this).val()).draw(); // escribe la busqueda del valor escrito en la tabla con la funcion draw
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
    
    <!-- Page title --> 
    <div class="page-title">
        <h2 align="right"><i class="fa fa-desktop color"></i> Consulta de solicitud <small>Seleccione para ver detalles </small></h2>
        <hr />
    </div>

    <!-- Page title -->
    <div class="row">
        <div class="panel panel-default">
            <div class="panel-heading"><label class="control-label">Lista de Solicitudes Cerradas / Anuladas</label>
                <div class="btn-group btn-group-sm pull-right">
                 <a href="<?php echo base_url() ?>index.php/mnt_solicitudes/lista_solicitudes" class="btn btn-info">En Proceso</a>
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
                      
                    </div>
                    <div class="col-lg-12 col-md-12 col-sm-12">
                        <table id="solicitudes" class="table table-hover table-bordered table-condensed" align="center" width="100%">
                            <thead>
                                <tr >
                                    <th rowspan="2"></th>
                                    <th rowspan="2" valign="middle"><div align="center">Orden</div></th>
                            <th colspan="3"></th>
                            <th colspan="2"><div align="center">Personal asignado</div></th>
                            <th></th>
                            
                            </tr>
                            <tr>
                                <th>Fecha</th>
                                <th>Dependencia</th>
                                <th>Asunto</th>
                                <th><span title="Asignar cuadrillas"><img src="<?php echo base_url() ?>assets/img/mnt/tecn5.png" class="img-rounded" alt="bordes redondeados" width="30" height="30"></span></th>
                                <th><span title="Asignar ayudantes"><img src="<?php echo base_url() ?>assets/img/mnt/ayudantes4.png" class="img-rounded" alt="bordes redondeados" width="30" height="30"></span></th>
                                <th>Calificar</th>
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
                                        <td>
                                            <?php if (($sol['descripcion'] == 'CERRADA') && empty($sol['sugerencia'])) : ?>
                                                    <a href='#sugerencias<?php echo $sol['id_orden'] ?>' data-toggle="modal" data-id="<?php echo $sol['id_orden']; ?>" class="open-Modal">
                                                    <div align="center" title="Calificar"><img src="<?php echo base_url().'assets/img/mnt/opinion.png'?>" class="img-rounded" alt="bordes redondeados" width="25" height="25"></div></a>
                                                <?php elseif (($sol['descripcion'] == 'CERRADA') && (!empty($sol['sugerencia']))) : ?>
                                                    <a href='#sugerencias<?php echo $sol['id_orden'] ?>' data-toggle="modal" data-id="<?php echo $sol['id_orden']; ?>" class="open-Modal">
                                                    <div align="center" title="Calificar"><img src="<?php echo base_url().'assets/img/mnt/opinion1.png'?>" class="img-rounded" alt="bordes redondeados" width="25" height="25"></div></a>
                                            <?php endif ?>
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
                                    
                                      <div align="center"><label>Jefe de cuadrilla:</label>
                                         <label name="respon" id="respon<?php echo $sol['id_orden'] ?>"></label>
                                      </div>
                                      <div class="col-md-6"><label for = "miembros">Miembros de la Cuadrilla</label></div>
                                      <div id="show_signed<?php echo $sol['id_orden'] ?>" class="col-md-12">
                                      <!--mostrara la tabla de la cuadrilla asignada-->   
                                      </div>
                                    
                               
                                 <?php                                     
                                endif;?>
                                      
                                <div class="modal-footer">
                                    <div class = "col-md-12">
                                    
                                    <button type="button" class="btn btn-default" data-dismiss="modal" aria-hidden="true">Cancelar</button>
                                    </div>
                                </div>
                            
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
    <!--modal de calificacion de solicitud-->
         <div id="sugerencias<?php echo $sol['id_orden'] ?>" class="modal modal-message modal-info fade" tabindex="-1" role="dialog" style="display: none;">
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
                                <button class="btn btn-primary" type="submit">Enviar</button>
                                <button type="button" class="btn btn-default" data-dismiss="modal" aria-hidden="true">Cancelar</button>
                            </div>
                        
                    </div>
                    </form>
                </div>
            </div>
        </div><!-- FIN DE MODAL DE CALIFICAR SOLICITUD-->
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
    //funcion para validar que el input motivo no quede vacio(esta funcion se llama en el formulario de estatus de la solicitud)
    function valida_calificacion(txt) {
        if($(txt).val().length < 1) {  
        $(txt).focus();
        swal({
            title: "Error",
            text: "La calificación es obligatoria",
            type: "error"
        });
       return false;  
   }
}
    
</script>