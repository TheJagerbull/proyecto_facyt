<script src="<?php echo base_url() ?>assets/js/jquery.min.js"></script>
<script type="text/javascript">
    base_url = '<?php echo base_url() ?>';
    $(document).ready(function () {
       var table = $('#trabajadores').DataTable({ 
        
        "processing": true, //Feature control the processing indicator.
        "serverSide": true, //Feature control DataTables' server-side processing mode.
         "ordering": false,
         "searching": false,
         "bLengthChange": false,
         'sDom': 'tp',
        // Load data for the table's content from an Ajax source
        "ajax": {
            "url": "<?php echo site_url('mnt_cuadrilla/cuadrilla/ajax_detalle/'.$item['id'])?>",
            "type": "POST"
        }

        //Set column definition initialisation properties.
       
//        "columnDefs": [
//        { 
//          "targets": [0,1,2 ], //last column
//          "orderable": false, //set not orderable
//        },
//        ],

      });
       function reload_table()
    {
      table.ajax.reload(null,false); //reload datatable ajax 
    }
        //para usar dataTable en la table solicitudes
//        $('#trabajadores').DataTable({
//            "ajax": "<?php echo base_url('index.php/mnt_cuadrilla/cuadrilla/get_json/'.$item['id']); ?>",
//             'sDom': 'tp',
//             "order": [[ 1, "asc" ]],
//           "bLengthChange": false,
//            "iDisplayLength": 5,
//             "aoColumnDefs": [{"orderable": false, "targets": [0],"visible": false,}]
//        });
       
        var tabla = $('#trabajadores2').DataTable({
            "ajax": "<?php echo base_url('index.php/mnt_cuadrilla/cuadrilla/get_json/'.$item['id']); ?>",
//           "pagingType": "full_numbers",
            "order": [[ 1, "asc" ]],
            "bLengthChange": false,
            "iDisplayLength": 5,
           'sDom': 'tp',
           "aoColumnDefs": [{"orderable": false, "targets": [0],"visible": false,}]
        });
        
        $('a.toggle-vis').on('click', function (e) {//esta funcion se usa para mostrar columnas ocultas de la tabla donde a.toggle-vis es el <a class> de la vista 
            e.preventDefault();

            // toma el valor que viene de la vista en <a data-column>para establecer la columna a mostrar
            var column = tabla.column($(this).attr('data-column'));

            // Esta es la funcion que hace el cambio de la columna
            column.visible(!column.visible());
        });
        

});    
</script>
<style type="text/css">
    .modal-message .modal-header .fa, 
    .modal-message .modal-header 
    .glyphicon, .modal-message 
    .modal-header .typcn, .modal-message .modal-header .wi {
        font-size: 30px;
    }
</style>
<!-- Page content -->
<div class="page-title">
    <h2 align="right"><i class="fa fa-desktop color"></i> Cuadrilla <small> detalles</small></h2>
        <hr /> 
      
</div>
<div class="mainy">
    <!-- Page title -->
    <div class="row">
        <div class="col-md-12">

            <div class="awidget full-width">
                <div class="awidget-head">

                </div>
                <div class="awidget-body">
                    <?php if ($this->session->flashdata('edit_item') == 'success') : ?>
                        <div class="alert alert-success" style="text-align: center">La cuadrilla fue modificada con éxito</div>
                    <?php endif ?>
                    <?php if ($this->session->flashdata('edit_item') == 'error') : ?>
                        <div class="alert alert-danger" style="text-align: center">Ocurrió un problema con la edición de la cuadrilla</div>
                    <?php endif ?>
                    <div class="row">
                        <div class="col-md-3 col-sm-3">

                        </div>
                        <div class="col-md-6 col-sm-6">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <div align="center"> <img src="<?php echo base_url() . $item['icono']; ?>" class="img-rounded" alt="bordes redondeados" width="125" height="125"></div>
                                </div>
                                <div class="panel-body">
                                    <p align="center"><strong><?php echo $item['cuadrilla'] ?></strong></p>
                                </div>
                                <div class="panel-footer">
                                    <p align="center"><strong>Responsable:&nbsp;</strong>
                                    <?php echo $item['nombre'] ?></p>
                                </div>
                            </div>
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <p><strong>Miembros:&nbsp;</strong></p>
                                </div>
                                <div class="panel-body">
                                    <div class="table-responsive">
                                    <button class="btn btn-success" onclick="add_person()"><i class="glyphicon glyphicon-plus"></i> Añadir</button>
                                    <table id="trabajadores" class="table table-hover table-bordered table-condensed" >
                                         <thead>
                                           <tr>
                                               <th></th>
                                               <th><div align="center">Trabajador</div></th>
                                               <th><div align="center">Acción</div></th>
                                           </tr>
                                        </thead>
                                        <tbody align="center">
                                         <?php // foreach ($miembros as $key => $trab) :?>
                                        <!--<tr>-->
                                            <!--<td align="center"> <?php // echo $key+1; ?> </td>--> 
                                            <!--<td align="center">-->
                                            <?php //  echo $trab->trabajador; ?>
                                            <!--</td>-->
                                    <?php // endforeach;?>
                                        </tbody>    
                                    </table> 
                                    </div>
                                </div>
                               
                            </div>
                           
                        </div>
<!--                        <table class="table">
                            <tr>    
                                <td><strong>Responsable</strong></td>
                                <td>:</td>
                                <td><?php echo $item['nombre'] ?></td>
                            </tr>
                            <tr>
                                <?php foreach ($miembros as $key => $trab_cuad) :
                                    if ($key == 0):
                                        ?>
                                        <td><strong>Miembros</strong></td>
                                        <td>:</td>
                                        <td><?php echo $trab_cuad->miembros ?></td>
                                    </tr>
                                    <?php else: ?>
                                    <tr>
                                        <td></td>
                                        <td>:</td>
                                        <td><?php echo $trab_cuad->miembros ?></td>
                                    </tr> 
                                <?php
                                endif;
                            endforeach;
                            ?>                                         
                        </table>-->
                    </div>
                </div>
            </div>
        </div>
        <div class='container'align="right">
                <div class="inline">
                    <button onClick="javascript:window.history.back();" type="button" name="Submit" class="btn btn-info">Regresar</button>
                    <!-- Button to trigger modal -->
                    <?php //  if (isset($edit) && $edit && isset($tipo)) : ?>
                        <a href="#modificar" class="btn btn-success" data-toggle="modal">Editar</a>
                    <?php //  endif ?>
                </div>
        </div>
            
            
    
            <!-- Modal -->
            <div id="modificar" class="modal modal-message modal-info fade" tabindex="-1" role="dialog" aria-labelledby="modificacion" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <span><i class="glyphicon glyphicon-check"></i></span>
                        </div>
                        <div class="modal-body">
                            <div>
                          <form class="form-horizontal" action="<?php echo base_url() ?>index.php/modificar" method="post" name="modifica" id="modifica">
                                 <!-- nombre de la cuadrilla -->
                          <div class="form-group">
                            <label class="control-label col-lg-4" for="cuadrilla">Nombre:</label>
                            <div class="col-lg-6">
                                <input type="text" value="<?php echo $item['cuadrilla'] ?>"class="form-control" id="cuadrilla" name="cuadrilla" placeholder='Nombre de la cuadrilla'>
                            </div>
                          </div>
                          <!-- SELECT RESPONSABLE -->
                          <?php // $total = count($obreros);
                          ?>
                        <div class="form-group">
                            <label class="control-label col-lg-4" for = "id_trabajador">Responsable:</label>
                                <div class="col-lg-6"> 
                                    <input type="hidden" id="cuad" value="<?php echo $item['id']?> ">
                                    <select class="form-control input-sm select2" id = "id_trabajador" name="name_trabajador">
                                        <option></option>
                                        <option selected="<?php echo $item['nombre'] ?>" value="<?php echo $item['nombre'] ?>"><?php echo $item['nombre'] ?></option>
                                            <?php foreach ($miembros as $obr): 
                                                if ($obr->trabajador != $item['nombre']):?>
                                        
                                          <option value = "<?php echo $obr->trabajador ?>"><?php echo $obr->trabajador ?></option>
                                            <?php endif;
                                            endforeach; ?>
                                    </select>
                                </div>
                                  
                        </div>
                        <div class="form-group">
                            <div id="mostrar">
                                <style>
                    .glyphicon:before {
                        visibility: visible;
                    }
                    .glyphicon.glyphicon-minus:checked:before {
                        content: "\e013";
                    }
                    input[type=checkbox].glyphicon{
                        visibility: hidden;        
                    }
                </style>
                               <table id="trabajadores2" class="table table-hover table-bordered table-condensed" >
                                         <thead>
                                           <tr>
                                           <th><div align="center">Seleccione</div></th>
                                           <th><div align="center"></div></th>
                                           <th><div align="center">Trabajador</div></th>
                                           </tr>
                                        </thead>
                                        <tbody align="center">
                                         <?php // foreach ($miembros as $key => $trab) :?>
<!--                                        <tr>
                                            <td align="center"> //<?php echo $key+1; ?> </td> 
                                            <td align="center">-->
                                            <?php //  echo $trab->trabajador; ?>
                                            <!--</td>-->
                                       <?php // endforeach;?>
                                        </tbody>    
                                    </table> 
                            </div>
                            <div class="control-group col col-lg-12 col-md-12 col-sm-12">
                            <div class="form-control" align="center">
                                <input type="hidden" value="<?php echo 'hola'?>" id="cualquiera" name="cualquiera">
                                <a onclick='listar_cargo($("#id_trabajador"),$("#otro"),$("#cuadrilla"))' class="toggle-vis" data-column="0">Haz click aquí para cambiar miembros de la cuadrilla</a>
                            </div>
                                <div id='otro'></div>
                        </div>
                        </div>
                        
                       <!-- Fin de Formulario -->
                       
                       <div class="modal-footer">
                        <button class="btn btn-default" type="reset">Reset</button>
<!--                        <input onClick="javascript:window.history.back();" type="button" value="Regresar" class="btn btn-info"></>-->
                         <button type="submit" class="btn btn-success">Agregar</button>
                       </div>
                               
                               </form>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>

    </div>

    <div class="clearfix"></div>

        