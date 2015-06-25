<script src="<?php echo base_url() ?>assets/js/jquery.min.js"></script>
<script type="text/javascript">
    base_url = '<?= base_url() ?>';

    //Para el uso de dataTables en mnt_solicitudes 
$(document).ready(function () {
   //para usar dataTable en la table solicitudes
    var table = $('#solicitudes').DataTable({
        "pagingType": "full_numbers", //se usa para la paginacion completa de la tabla
        "sDom": '<"top"lp<"clear">>rt<"bottom"ip<"clear">>',//para mostrar las opciones donde p=paginacion,l=campos a mostrar,i=informacion
        "order": [[1, "desc"]],  //para establecer la columna a ordenar por defecto y el orden en que se quiere 
        "aoColumnDefs": [{"orderable": false, "targets": [0,9]}]//para desactivar el ordenamiento en esas columnas
    });
    table.column( 9 ).visible( false );//para hacer invisible una columna usando table como variable donde se guarda la funcion dataTable 
//$('div.dataTables_filter').appendTo(".search-box");//permite sacar la casilla de busqueda a un div donde apppendTo se escribe el nombre del div destino
$('#buscador').keyup(function(){ //establece un un input para el buscador fuera de la tabla
      table.search($(this).val()).draw() ; // escribe la busqueda del valor escrito en la tabla con la funcion draw
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
    $('#fecha').on('click', function (){
          document.getElementById("fecha").value= "";//se toma el id del elemento y se hace vacio el valor del mismo
          table.draw();//devuelve este valor a la escritura de la tabla para reiniciar los valores por defecto
     });
   
});

//esta funcion sirve para agregar otro campo de busqueda anexo al que ya posee el datatable, en este caso lo uso para la busqueda por fechas            
$.fn.dataTableExt.afnFiltering.push(
        function (oSettings, aData, iDataIndex) {//oSettings es un valor de datatable, aData es la columna donde voy a buscar
            var valor = $('#fecha').val().split('al');//se toma el valor del input fecha, se guarda en una variable y se quita la palabra al para que quede solo la fecha
            //$('#valor').val(valor);// se usa para monitorear el valor en un input
            var iMin_temp = valor[0];//al separar la variable valor con split queda como un array
            if (iMin_temp === '') { //en caso de que este vacia se establece una fecha de inicio general 
                iMin_temp = '01/01/2015';//fecha de rango inferior
            }
            var iMax_temp = valor[1];
            if (typeof (iMax_temp) === "undefined") {// en caso de que la primera vez la variable valor no sea array se usa esto para evaluar la asignacion en la variable
                iMax_temp = '31/12/2999'; // fecha de rango superior
            }
           // $('#result1').val(iMin_temp);  //se usa para escribir las variables asignadas anteriormente en la vista
          //  $('#result2').val(iMax_temp);
            var arr_min = iMin_temp.split('/'); //aqui se vuelve aplicar el split para quitar el separador de la fecha y facilitar la busqueda
            var arr_max = iMax_temp.split('/');

            // aData  es la columna donde voy a establecer la busqueda por rango
            // 2 es la columna que estoy mostrando las fechas donde quiro buscar. La numeracion de la misma empieza en 0.
            var arr_date = aData[2].split('/'); //se toma el valor y se le quita el separador /
            var iMin = new Date(arr_min[2], arr_min[1] - 1, arr_min[0], 0, 0, 0, 0); //se usa date para cambiar a la fecha de timestamp
            var iMax = new Date(arr_max[2], arr_max[1] - 1, arr_max[0], 0, 0, 0, 0);
            var iDate = new Date(arr_date[2], arr_date[1] - 1, arr_date[0], 0, 0, 0, 0);
            //al aplicar el split las variables se convierten en array string por lo cual la numeracion es el orden en que aparecen las fechas
            //no se porque razon en los meses me mostraba el siguiente al que estaba, por eso le reste uno en la posicion 1 para que me diera el valor real
            if (iMin === "" && iMax === "")// se establecen las comparaciones para mostrar resultados
            {
                return true; //todos los retornos van al input fecha que con la funcion draw escribe los valores finales de la busqueda en la tabla
            }
            else if (iMin === "" && iDate < iMax)
            {
                return true;
            }
            else if (iMin <= iDate && "" === iMax)
            {
                return true;
            }
            else if (iMin <= iDate && iDate <= iMax)
            {
                return true;
            }
            return false;
        }

);

//fin del uso del dataTable en mnt_solicitudes
</script>


<!-- Page content -->

<div class="mainy">


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

    <!-- Page title --> 
    <div class="page-title">
        <h2 align="right"><i class="fa fa-desktop color"></i> Consulta de solicitud <small>Seleccione para ver detalles </small></h2>
        <hr />
    </div>

    <!-- Page title -->
    <div class="row">
        <div class="panel panel-default">
            <div class="panel-heading"><label class="control-label">Lista de Solicitudes</label>
                <a href="<?php echo base_url() ?>index.php/mnt_solicitudes/solicitud" class="btn btn-success pull-right btn-sm">Crear Solicitud</a>
            </div>
            <div class="panel-body">
                <input type="hidden" id="valor" name="valor">  <!--estos inputs vienen del custom js en la funcion externa de busqueda por -->
                <input type="hidden" id="result1" name="result1"><!-- rangos para mostrar los resultados, estan ocultos despues de probar -->
                <input type="hidden" id="result2" name="result1"><!--por lo cual se pueden cambiar a tipo text para ver como funciona la busqueda-->
                <div class="table-responsive">

                    <div class="controls-row">
                        <div class="control-group col col-lg-3">
                            <div class="input-group">
                                <span class="input-group-addon" id="basic-addon1"><i class="fa fa-calendar"></i></span>
                                <input type="search" readonly class="form-control input-sm" style="width: 200px" name="fecha" id="fecha" placeholder="Fecha" />
                            </div>
                        </div>
                        <div class="control-group col col-lg-3">
                            <div class="input-group">
                                <input type="text" class="form-control input-sm" style="width: 200px" id="buscador">
                                <span class="input-group-addon" id="basic-addon2"><i class="fa fa-search"></i></span>
                            </div>
                        </div>
                        <div class="control-group col col-lg-12">
                            <div class="input-group">
                                <a class="toggle-vis" data-column="9">Haz click aquí para cambiar el estatus de una solicitud</a>
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-12">
                        <table id="solicitudes" class="table table-hover table-bordered table-condensed" align="center" width="100%">
                            <thead>
                                <tr >
                                    <th rowspan="2"></th>
                                    <th rowspan="2" valign="middle"><div align="center">Orden</div></th>
                            <th colspan="4"></th>
                            <th colspan="3"><div align="center">Asignar personal</div></th>
                            <th rowspan="2"><div valign="middle" align="center">Cambio de estatus</div></th>
                            </tr>
                            <tr>

                                <th>Fecha</th>
                                <th>Dependencia</th>
                                <th>Asunto</th>
                                <th>Estatus</th>
                                <th><img src="<?php echo base_url() ?>assets/img/mnt/tecn.png" class="img-rounded" alt="bordes redondeados" width="25" height="25"></th>
                                <th>c+a</th>
                                <th>ayu</th>
                            </tr>
                            </thead>
    <!--                        <tfoot>
                            <tr>
                                <th>Orden</th>
                                <th>Fecha</th>
                                <th>Dependencia</th>
                                <th>Asunto</th>
                                <th>Estatus</th>
                                <th>cua</th>
                                <th>c+a</th>
                                <th>ayu</th>
                                <th>Cambio</th>
                                </tr>
                            </tfoot>-->
                            <tbody>
                                <?php foreach ($mant_solicitudes as $key => $sol) : ?>
                                    <tr>
                                        <td><input type="checkbox"></td>
                                        <td>

                                            <a href="<?php echo base_url() ?>index.php/mnt_solicitudes/detalle/<?php echo $sol['id_orden'] ?>">
                                                <?php echo $sol['id_orden'] ?>
                                            </a>
                                        </td>
                                        <td><?php echo date("d/m/Y", strtotime($sol['fecha_p'])); ?></td>
                                        <td> <?php echo $sol['dependen']; ?></td>
                                        <td> <?php echo $sol['asunto']; ?></td>
                                        <td> <?php echo $sol['descripcion']; ?></td>
                                        <td> <?php if (!empty($sol['cuadrilla'])): ?>
                                                <div align="center"> <img src="<?php echo base_url() . $sol['icono']; ?>" class="img-rounded" alt="bordes redondeados" width="25" height="25"></div>
                                                <?php
                                            else :
                                                ?>

                                                <a href='#cuad<?php echo $sol['id_orden'] ?> ' data-toggle="modal" data-id="<?php echo $sol['id_orden']; ?>" data-asunto="<?php echo $sol['asunto'] ?>" data-tipo_sol="<?php echo $sol['tipo_orden']; ?>" class="open-Modal" >
                                                    <div align="center"><img src="<?php echo base_url() ?>assets/img/mnt/noo.png" class="img-rounded" alt="bordes redondeados" width="15" height="15"></div></a>
                                            <?php endif; ?>                      
                                        </td>
                                        <td>i2</td>
                                        <td>i3</td>
                                        <td><div class="form-group">
                                                <div class="col-xs-3"> 
                                                    <select size="1"id = "select_estado" name="select_estado">
                                                        <option value="">--SELECCIONE--</option>
                                                        <?php foreach ($estatus as $est): ?>
                                                            <option value = "<?php echo $est->id_estado ?>"><?php echo $est->descripcion ?></option>
                                                        <?php endforeach; ?>
                                                    </select>
                                                </div>
                                            </div></td>                
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
            <div id="cuad<?php echo $sol['id_orden'] ?>" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="cuadrilla" >
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">X</button>
                            <h3 class="modal-title" align="center">Asignar Cuadrilla</h3>
                        </div>
                        <div class="modal-body">
                            <div align="center">
                                <h4><label>Solicitud Número:
                                        <label name="data" id="data"></label>
                                    </label></h4>
                                <label class="control-label" for = "tipo">Tipo de Solicitud:</label>
                                <label class="control-label" id="tipo"></label>
                                <br>
                                <label class="control-label" for = "tipo">Asunto:</label>
                                <label class="control-label" id="asunto"></label>

                            </div>
                            <form class="form" action="<?php echo base_url() ?>index.php/mnt_asigna_cuadrilla/mnt_asigna_cuadrilla/asignar_cuadrilla" method="post" name="modifica" id="modifica">
                                <div class="form-group">   

                                </div>
                                <input type="hidden" id="num_sol" name="num_sol" value="">
                                <div class="form-group">

                                    <label class="control-label" for="cuadrilla">Cuadrilla</label>
                                    <div class="control-label">
                                        <select class = "form-control" id = "cuadrilla_select" name="cuadrilla_select" onchange="mostrar(this.form.cuadrilla_select, this.form.responsable, ($('#<?php echo $sol['id_orden'] ?>')))">
                                            <option selected=" " value = "">--Seleccione--</option>
                                            <?php foreach ($cuadrilla as $cuad): ?>
                                                <?php //if ($tipo['cuadrilla'] != $cuad->cuadrilla): ?>
                                                <option value = "<?php echo $cuad->id ?>"><?php echo $cuad->cuadrilla ?></option>
                                                <?php // endif;  ?>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group">   
                                    <label class="control-label" for = "responsable">Responsable</label>
                                    <input type="text" readonly="true" class="form-control" id = "responsable" name = "responsable">

                                </div>
                                <div class="form-group">   
                                    <div id="<?php echo $sol['id_orden'] ?>">

                                    </div>

                                </div>
                                <?php if (isset($edit) && $edit && isset($tipo)) : ?>
                                    <input type="hidden" name="id" value="<?php echo $tipo['id_orden'] ?>" />
                                <?php endif ?>
                                <div class="modal-footer">
                                    <button type="submit" class="btn btn-primary">Guardar cambios</button>
                                    <button type="button" class="btn btn-default" data-dismiss="modal" aria-hidden="true">Cancelar</button>
                                </div>
                            </form>


                        </div>
                    </div>
                </div>


            </div>
            <!-- fin Modal --> 
        <?php endforeach ?>
    </div>