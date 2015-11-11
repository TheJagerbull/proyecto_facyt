<script src="<?php echo base_url() ?>assets/js/jquery.min.js"></script>
<script type="text/javascript">
    base_url = '<?= base_url() ?>';
    $(document).ready(function () {
        //para usar dataTable en la table solicitudes
        var table = $('#sol_dep').DataTable({
            "pagingType": "full_numbers", //se usa para la paginacion completa de la tabla
            "sDom": '<"top"lp<"clear">>rt<"bottom"ip<"clear">>', //para mostrar las opciones donde p=paginacion,l=campos a mostrar,i=informacion
            "order": [[1, "desc"]] //para establecer la columna a ordenar por defecto y el orden en que se quiere 
           
        });
        table.column(0).visible(false);//para hacer invisible una columna usando table como variable donde se guarda la funcion dataTable 
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

    <?php if ($this->session->flashdata('create_orden') == 'success') : ?>
        <div class="alert alert-success" style="text-align: center">Solicitud creada con éxito</div>
    <?php endif ?>
    <?php if ($this->session->flashdata('create_orden') == 'error') : ?>
        <div class="alert alert-danger" style="text-align: center">Ocurrió un problema creando su solicitud</div>
    <?php endif ?>
    <?php if ($this->session->flashdata('sugerencia') == 'success') : ?>
        <div class="alert alert-success" style="text-align: center">Calificación agregada con éxito</div>
    <?php endif ?>
    <?php if ($this->session->flashdata('sugerencia') == 'error') : ?>
        <div class="alert alert-danger" style="text-align: center">Ocurrió un problema agregando la calificación</div>
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
                        <table id="sol_dep" class="table table-hover table-bordered table-condensed" align="center" width="100%">
                            <thead>
                                <tr>
                                    <th></th>
                                    <th valign="middle"><div align="center">Orden</div></th>
                                    <th>Fecha</th>
                                    <th>Dependencia</th>
                                    <th>Asunto</th>
                                    <th>Estatus</th>
                                    <th>Calificar</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($mant_solicitudes as $key => $sol) : ?>
                                    <tr>
                                        <td><input type="checkbox"></td>
                                        <td>
                                            <a href="<?php echo base_url() ?>index.php/mnt_solicitudes/detalles/<?php echo $sol['id_orden'] ?>">
                                                <?php echo $sol['id_orden'] ?>
                                            </a>
                                        </td>
                                        <td><?php echo date("d/m/Y", strtotime($sol['fecha'])); ?></td>
                                        <td> <?php echo $sol['dependen']; ?></td>
                                        <td> <?php echo $sol['asunto']; ?></td>
                                        <td> <?php echo $sol['descripcion']; ?></td>
                                        <td><?php if (($sol['descripcion'] == 'ANULADA') && empty($sol['sugerencia'])) : ?>
                                            <a href='#sugerencias<?php echo $sol['id_orden'] ?>' data-toggle="modal" data-id="<?php echo $sol['id_orden']; ?>" class="open-Modal">
                                            <div align="center" title="Calificar"><img src="<?php echo base_url().'assets/img/mnt/calificar.png'?>" class="img-rounded" alt="bordes redondeados" width="25" height="25"></div></a>
                                        <?php endif ?>
                                        </td>
                                    </tr>
                                 <?php endforeach ?>
                                </tbody>
                        </table>
                    </div>
                    <?php foreach ($mant_solicitudes as $key => $sol) : ?>
                         <!--modal de calificacion de solicitud-->
                         <div id="sugerencias<?php echo $sol['id_orden'] ?>" class="modal modal-message modal-info fade" tabindex="-1" role="dialog" style="display: none;">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                            <label class="modal-title">Calificar solicitud</label><img src="<?php echo base_url().'assets/img/mnt/calificar.png'?>" class="img-rounded" alt="bordes redondeados" width="25" height="25">
                                        </div>
                                    <form class="form" action="<?php echo base_url() ?>index.php/mnt_solicitudes/sugerencias" method="post" name="opinion" id="opinion" onsubmit="if ($('#<?php echo $sol['id_orden'] ?>')){return valida_calificacion($('#sugerencia<?php echo $sol['id_orden'] ?>'));}">
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
                                            <div class="modal-footer">
                                                <button class="btn btn-default" type="reset" onMouseleave="contador(this.form.sugerencia,($('#restar<?php echo $sol['id_orden'] ?>')),160);">Borrar</button>
                                                <button class="btn btn-primary" type="submit">Enviar</button>
                                            </div>
                                    </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    <?php endforeach ?>
                </div>
            </div>
        </div>  
    </div>
</div>
<script>

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