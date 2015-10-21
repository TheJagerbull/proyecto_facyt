<script src="<?php echo base_url() ?>assets/js/jquery.min.js"></script>
<script type="text/javascript">
    base_url = '<?php echo base_url() ?>';
    var table;
    var save_method;
    $(document).ready(function () {
       table = $('#trabajadores').DataTable({ 
        
        "processing": true, //Feature control the processing indicator.
        "serverSide": true, //Feature control DataTables' server-side processing mode.
//         "ordering": false,
//         "searching": false,
         'order': [[1, 'asc']],
//         "bLengthChange": false,
//         "iDisplayLength": 5,
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

});  
function add_trabajador()
      {
       save_method = 'add';
       $('#modificar').modal('show'); // show bootstrap modal
       $('#modifica')[0].reset(); // reset form on modals
       var table = $('#trabajadores2').DataTable({
            "ajax":"<?php echo base_url('index.php/mnt_cuadrilla/cuadrilla/mostrar_unassigned/'.$item['id']); ?>",
            "bLengthChange": false,
             "aoColumnDefs": [{
                "orderable": false,
                'searchable':false,
                 "targets": [0],
                 'render': function (data, type, full, meta){
             return '<input type="checkbox" class="glyphicon glyphicon-minus" name="id_ayudantes[]" value="' + $('<div/>').text(data).html() + '">';}
             }],
             'order': [[1, 'asc']],
            "iDisplayLength": 5,
            destroy: true
          });
  

       }

    function delete_person(id)
    {
    swal({
        title: "",
        text: "¿Seguro que desea eliminar este registro?'",
        type: "warning",
        showCancelButton: true,
        confirmButtonClass: "btn-danger",
        confirmButtonText: "Si",
        closeOnConfirm: false
     },
     function()
//      if(confirm('¿Seguro que desea eliminar este registro?'))
      {
         var cuad = "<?php echo $item['id']?>";
         var dataString = 'id='+ id + '&cuad='+ cuad;
        // ajax delete data to database
          $.ajax({
            url : "<?php echo site_url('mnt_cuadrilla/cuadrilla/ajax_borrar')?>/"+id,
            type: "POST",
            data: dataString,
            dataType: "JSON",
            success: function(data)
            {
               reload_table();
            }
        });
       swal(" ","El trabajador ha sido removido de la cuadrilla", "success");  
      }
      )
    }

       function reload_table()
    {
      table.ajax.reload(null,false); //reload datatable ajax 
    }
     
   function guardar()
    {
      var url;
      if(save_method === 'add') 
      {
          url = "<?php echo site_url('mnt_cuadrilla/cuadrilla/ajax_guardar/'.$item['id'])?>";
      }
       // ajax adding data to database
          $.ajax({
            url : url,
            type: "POST",
            data: $('#modifica').serialize(),
            dataType: "JSON",
            success: function(data)
            {
               //if success close modal and reload ajax table
               $('#modificar').modal('hide');
               reload_table();
            },
            error: function (jqXHR, textStatus, errorThrown)
            {
                alert('Error agregando los datos');
            }
        });
    }
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
                                    <button class='btn btn-success' onclick='add_trabajador()'><i class='glyphicon glyphicon-plus'></i> Añadir</button>
                                    <table id="trabajadores" class="table table-hover table-bordered table-condensed" >
                                         <thead>
                                           <tr>
                                               <th></th>
                                               <th><div align="center">Trabajador</div></th>
                                               <th><div align="center">Acción</div></th>
                                           </tr>
                                        </thead>
                                        <tbody align="center">
                                        
                                        </tbody>    
                                    </table> 
                                    </div>
                                </div>
                               
                            </div>
                           
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class='container'align="right">
                <div class="inline">
                    <button onClick="javascript:window.history.back();" type="button" name="Submit" class="btn btn-info">Regresar</button>
                    <!-- Button to trigger modal -->
                    <?php if (isset($edit) && $edit && isset($tipo)) : ?>
                        <a href="#modificar" class="btn btn-success" data-toggle="modal">Editar</a>
                    <?php endif ?>
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
                                <div align="center"><h3>Agregar trabajadores a la cuadrilla</h3></div>
                          <form action="#" class="form-horizontal" name="modifica" id="modifica">
               
                  
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
                                           <th><div align="center">Nombre</div></th>
                                           <th><div align="center">Apellido</div></th>
                                           <th><div align="center">Cargo</div></th>
                                           </tr>
                                        </thead>
                                        <tbody align="center">
                                         
                                        </tbody>    
                        </table>
                
                        
                       <!-- Fin de Formulario -->
                       
                       <div class="modal-footer">
                        <button class="btn btn-default" type="reset">Reset</button>
<!--                        <input onClick="javascript:window.history.back();" type="button" value="Regresar" class="btn btn-info"></>-->
                        <button type="button" onclick="guardar()" class="btn btn-success">Agregar</button>
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

        