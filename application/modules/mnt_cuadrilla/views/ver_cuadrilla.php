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
//       var table = $('#trabajadores2').DataTable({
//            "ajax":"<?php echo base_url('index.php/mnt_cuadrilla/cuadrilla/mostrar_unassigned/'.$item['id']); ?>",
//            "bLengthChange": false,
//             "aoColumnDefs": [{
//                "orderable": false,
//                'searchable':false,
//                 "targets": [0],
//                 'render': function (data, type, full, meta){
//             return '<input type="checkbox" class="glyphicon glyphicon-minus" name="id_ayudantes[]" value="' + $('<div/>').text(data).html() + '">';}
//             }],
//             'order': [[1, 'asc']],
//            "iDisplayLength": 5,
//            destroy: true
//          });
  //
// Updates "Select all" control in a data table
//
function updateDataTableSelectAllCtrl(table){
   var $table             = table.table().node();
   var $chkbox_all        = $('tbody input[type="checkbox"]', $table);
   var $chkbox_checked    = $('tbody input[type="checkbox"]:checked', $table);
   var chkbox_select_all  = $('thead input[name="select_all"]', $table).get(0);

   // If none of the checkboxes are checked
   if($chkbox_checked.length === 0){
      chkbox_select_all.checked = false;
      if('indeterminate' in chkbox_select_all){
         chkbox_select_all.indeterminate = false;
      }

   // If all of the checkboxes are checked
   } else if ($chkbox_checked.length === $chkbox_all.length){
      chkbox_select_all.checked = true;
      if('indeterminate' in chkbox_select_all){
         chkbox_select_all.indeterminate = false;
      }

   // If some of the checkboxes are checked
   } else {
      chkbox_select_all.checked = true;
      if('indeterminate' in chkbox_select_all){
         chkbox_select_all.indeterminate = true;
      }
   }
}

$(document).ready(function (){
   // Array holding selected row IDs
   var rows_selected = [];
   var table = $('#trabajadores2').DataTable({
       "ajax": "<?php echo base_url('index.php/mnt_cuadrilla/cuadrilla/mostrar_unassigned/'.$item['id']); ?>",
       "bLengthChange": false,
             "aoColumnDefs": [{
                "orderable": false,
                'searchable':false,
                 "targets": [0],
                 'render': function (data, type, full, meta){
             return '<input type="checkbox" value="' + $('<div/>').text(data).html() + '">';}
             }],
             'order': [[1, 'asc']],
            "iDisplayLength": 5,
            destroy: true,
      'rowCallback': function(row, data, dataIndex){
         // Get row ID
         var rowId = data[0];

         // If row ID is in the list of selected row IDs
         if($.inArray(rowId, rows_selected) !== -1){
            $(row).find('input[type="checkbox"]').prop('checked', true);
            $(row).addClass('selected');
         }
      }
   });

   // Handle click on checkbox
   $('#trabajadores2 tbody').on('click', 'input[type="checkbox"]', function(e){
      var $row = $(this).closest('tr');

      // Get row data
      var data = table.row($row).data();

      // Get row ID
      var rowId = data[0];

      // Determine whether row ID is in the list of selected row IDs 
      var index = $.inArray(rowId, rows_selected);

      // If checkbox is checked and row ID is not in list of selected row IDs
      if(this.checked && index === -1){
         rows_selected.push(rowId);

      // Otherwise, if checkbox is not checked and row ID is in list of selected row IDs
      } else if (!this.checked && index !== -1){
         rows_selected.splice(index, 1);
      }

      if(this.checked){
         $row.addClass('selected');
      } else {
         $row.removeClass('selected');
      }

      // Update state of "Select all" control
      updateDataTableSelectAllCtrl(table);

      // Prevent click event from propagating to parent
      e.stopPropagation();
   });

   // Handle click on table cells with checkboxes
   $('#trabajadores2').on('click', 'tbody td, thead th:first-child', function(e){
      $(this).parent().find('input[type="checkbox"]').trigger('click');
   });

   // Handle click on "Select all" control
   $('#trabajadores2 thead input[name="select_all"]').on('click', function(e){
      if(this.checked){
         $('#example tbody input[type="checkbox"]:not(:checked)').trigger('click');
      } else {
         $('#example tbody input[type="checkbox"]:checked').trigger('click');
      }

      // Prevent click event from propagating to parent
      e.stopPropagation();
   });

   // Handle table draw event
   table.on('draw', function(){
      // Update state of "Select all" control
      updateDataTableSelectAllCtrl(table);
   });
    

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
         // Handle form submission event 
   $('#modifica').on('submit', function(e){
      var form = this;

      // Iterate over all selected checkboxes
      $.each(rows_selected, function(index, rowId){
         // Create a hidden element 
         $(form).append(
             $('<input>')
                .attr('type', 'hidden')
                .attr('name', 'id_ayudantes[]')
                .val(rowId)
         );
      });

      // FOR DEMONSTRATION ONLY     
      
      // Output form data to a console     
      $('#trabajadores2-console').text($(form).serialize());
      console.log("Form submission", $(form).serialize());
       
      // Remove added elements
      $('input[name="id_ayudantes\[\]"]', form).remove();
       
      // Prevent actual form submission
      e.preventDefault();
   });
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
               
                  
<!--                  <style>
                    .glyphicon:before {
                        visibility: visible;
                    }
                    .glyphicon.glyphicon-minus:checked:before {
                        content: "\e013";
                    }
                    input[type=checkbox].glyphicon{
                        visibility: hidden;        
                    }
                </style>-->
                        
                        <table id="trabajadores2" class="table table-hover table-bordered table-condensed" >
                                         <thead>
                                           <tr>
                                           <th><div align="center"><input type="checkbox" value="1" name="select_all"></div></th>
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
                        <button type="submit" onclick="guardar()" class="btn btn-success">Agregar</button>
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

        