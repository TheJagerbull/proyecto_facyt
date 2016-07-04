<!--<link href= "<?php echo base_url() ?>assets/css/fileinput.min.css" media="all" rel="stylesheet" type="text/css">-->
<script src="<?php echo base_url() ?>assets/js/jquery.min.js"></script>

<script type="text/javascript">
    base_url = '<?php echo base_url() ?>';
    var table;
    var save_method;
    var tabla;
    var rows_selected = []; // Array donde se guardan los id de las columnas seleccionadas
    $(document).ready(function () {
       tabla = $('#trabajadores').DataTable({ 
        "language": {
                "url": "<?php echo base_url() ?>assets/js/lenguaje_datatable/spanish.json"
        },
//        responsive: true,
        "processing": true, //Feature control the processing indicator.
        "serverSide": true, //Feature control DataTables' server-side processing mode.
        "searching": false,
        "order": [[0, 'asc']],
        "iDisplayLength": 5,
        "sDom": 'tp',
        // Leer los datos desde la fuente para llenar la tabla por ajax
        "ajax": {
            "url": "<?php echo site_url('mnt_cuadrilla/cuadrilla/ajax_detalle/'.$item['id'])?>",
            "type": "POST"
        },
        //Para configurar la ultima columna.
        "columnDefs": [
        { 
          "className": 'dt-head-center',
          "targets": [2], //ultima columna
          "orderable": false, //para que no sea ordenable
          "searchable": false //deshabilita la busqueda
        }
        ]

      });
    <?php if ($eliminar){ ?>
       tabla.column(-1).visible(true);
    <?php } else { ?>
       tabla.column(-1).visible(false);
    <?php } ?>
});  
function add_trabajador()
{
       save_method = 'add';
       $('#modificar').modal('show'); // muestra bootstrap modal
       $('#modifica')[0].reset(); // para aplicar reset a los form en modals

// para actualizar el checkbox "Select all" control en el data table
    function updateDataTableSelectAllCtrl(table){
        var $table             = table.table().node();
        var $chkbox_all        = $('tbody input[type="checkbox"]', $table);
        var $chkbox_checked    = $('tbody input[type="checkbox"]:checked', $table);
        var chkbox_select_all = $('thead input[name="select_all"]', $table).get(0);

        // Si no hay checkboxes seleccionados 
            if ($chkbox_checked.length === 0) {
                chkbox_select_all.checked = false;
                if ('indeterminate' in chkbox_select_all) {
                    chkbox_select_all.indeterminate = false;
                }

        // Si todos los checkboxes son seleccionados
            } else if ($chkbox_checked.length === $chkbox_all.length) {
                chkbox_select_all.checked = true;
                if ('indeterminate' in chkbox_select_all) {
                    chkbox_select_all.indeterminate = false;
                }

        // Si algin checkboxes es seleccionado
            } else {
                chkbox_select_all.checked = true;
                if ('indeterminate' in chkbox_select_all) {
                    chkbox_select_all.indeterminate = true;
                }
            }
    }

    $(document).ready(function (){
        table = $('#trabajadores2').DataTable({
            responsive: true,
            "language": {
                "url": "<?php echo base_url() ?>assets/js/lenguaje_datatable/spanish.json"
            },
            "ajax": "<?php echo base_url('index.php/mnt_cuadrilla/cuadrilla/mostrar_unassigned/' . $item['id']); ?>",
            "bLengthChange": false,
            "aoColumnDefs": [{
                "orderable": false,
                "searchable": false,
                "className": 'dt-head-center',
                "targets": [0],
                'render': function (data, type, full, meta) {  //genera un checkbox en toda la columna 0 de la tabla
                    return '<input type="checkbox" class="icon-checkbox" value="' + $('<div/>').text(data).html() + '"><label for="checkbox1"><span style="color:#D9534F" id="clickable" class="glyphicon glyphicon-minus unchecked"></span><span id="clickable" class="glyphicon glyphicon-plus checked color"></span></label>';
                }
            }],
            "order": [[1, 'asc']],
            "iDisplayLength": 5,
            destroy: true,
            'rowCallback': function (row, data, dataIndex) {
                // Para obtener el ID de la columna 
                var rowId = data[0];
                // Si el ID de la columna esta en la lista de los id de la columna seleccionada
                if ($.inArray(rowId, rows_selected) !== -1) {
                    $(row).find('input[type="checkbox"]').prop('checked', true);
                    $(row).addClass('selected');
                }
            }
        });
//        table.columns.adjust();
        // Handle click on checkbox
        $('#trabajadores2 tbody').on('click', 'input[type="checkbox"]', function (e) {
            var $row = $(this).closest('tr');
            // Get row data
            var data = table.row($row).data();
            // Get row ID
            var rowId = data[0];
            // Determine whether row ID is in the list of selected row IDs 
            var index = $.inArray(rowId, rows_selected);
            // If checkbox is checked and row ID is not in list of selected row IDs
            if (this.checked && index === -1) {
                rows_selected.push(rowId);
               // Otherwise, if checkbox is not checked and row ID is in list of selected row IDs
            } else if (!this.checked && index !== -1) {
                rows_selected.splice(index, 1);
            }
            if (this.checked) {
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
        $('#trabajadores2').on('click', 'tbody td, thead th:first-child', function (e) {
            $(this).parent().find('input[type="checkbox"]').trigger('click');
        });
        // Handle click on "Select all" control
        $('#trabajadores2 thead input[name="select_all"]').on('click', function (e) {
            if (this.checked) {
                $('#trabajadores2 tbody input[type="checkbox"]:not(:checked)').trigger('click');
            } else {
                $('#trabajadores2 tbody input[type="checkbox"]:checked').trigger('click');
            }
            // Prevent click event from propagating to parent
            e.stopPropagation();
        });
        // Handle table draw event
        table.on('draw', function () {
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
//              console.log(data);
                if (data.status){
                    swal(" ","El trabajador ha sido removido de la cuadrilla", "success");
                    reload_table(); 
                }else{
                    swal(" ","Este trabajador es el responsable de la cuadrilla, por lo tanto no lo puede borrar ", "error"); 
                }
            }
        });
        
    });
}

function reload_table()
{
    tabla.ajax.reload(null,false); //reload datatable ajax 
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
        $.ajax({
            url : url,
            type: "POST",
            data: ($(form).serialize()),
            dataType: "JSON",
            success: function(data)
            {
                //if success close modal and reload ajax table
//              $(this).closest('form').get(0).reset();
                $('#modificar').modal('hide');
                reload_table();
            },
            error: function (jqXHR, textStatus, errorThrown)
            {
                swal(" ","Error agregando datos, por favor verifique y vuelva a intentarlo ", "error");
            }
        });
            // FOR DEMONSTRATION ONLY     
      
//      Output form data to a console     
//      $('#trabajadores2-console').text($(form).serialize());
//      console.log("Form submission", $(form).serialize());
       
        // Remove added elements
        $('input[name="id_ayudantes\[\]"]', form).remove();
        (form).get(0).reset();
        // Prevent actual form submission
        // ajax adding data to database
        e.preventDefault();
    });
}
     
function edit_var(id)
{
    save_method === 'update';
//    $('#form')[0].reset(); // reset form on modals
//    $('.form-group').removeClass('has-error'); // clear error class
   
    //Ajax Carga de datos desde ajax
    $.ajax({
        url : "<?php echo site_url('mnt_cuadrilla/cuadrilla/ajax_edit')?>/" + id,
        type: "POST",
        dataType: "JSON",
        success: function(data)
        {
            $('#cuadrilla').val(data.cuadrilla);       
            var selectObject = $('#id_trabajador_responsable');
            var jsonObject = eval(data.obreros);
            for (var n = 0; n < jsonObject.length; n++) {
              selectObject[0].options[n] = new Option(jsonObject[n].nombre +' '+ jsonObject[n].apellido,jsonObject[n].id_usuario);
            }
            $('#id_trabajador_responsable').select2({theme: "bootstrap"}).select2("val",data.id_trabajador_responsable);
            $("#file-3").fileinput({
                url: (base_url + 'index.php/mnt_cuadrilla/cuadrilla/crear_cuadrilla'),
                showUpload: false,
                overwriteInitial: false,
                showClose: false,
                showRemove: false, 
//              browseIcon: '<i class="glyphicon glyphicon-folder-open"></i>',   
                'initialPreview': "<img style='height:160px' src= '<?php echo base_url()?>"+data.icono+"' class='file-preview-image'>",
                language: 'es',
                showCaption: false,
                browseClass: "btn btn-primary btn-sm",
                allowedFileExtensions: ['png','jpg','gif'],
                maxImageWidth: 512,
                maxImageHeight: 512
            });
            var nomb = data.icono.split('/');
            var nomb_fin = nomb[3].split('.');
            $('#nombre_img').val(nomb_fin[0]);
            $('#editar').modal('show'); // show bootstrap modal when complete loaded         
        },
        error: function (jqXHR, textStatus, errorThrown)
        {
            alert('Error get data from ajax');
        }
    });
}
</script>
 <style>
  input[type='checkbox'].icon-checkbox{display:none}
  input[type='checkbox'].icon-checkbox+label .unchecked{display:inline}
  input[type='checkbox'].icon-checkbox+label .checked{display:none}
  input[type='checkbox']:checked.icon-checkbox{display:none}
  input[type='checkbox']:checked.icon-checkbox+label .unchecked{display:none}
  input[type='checkbox']:checked.icon-checkbox+label .checked{display:inline}
</style>
<style type="text/css">
    .modal-message .modal-header .fa, 
    .modal-message .modal-header 
    .glyphicon, .modal-message 
    .modal-header .typcn, .modal-message .modal-header .wi {
        font-size: 30px;
    }
    
</style>
<!--para que quede el file-input en el medio del modal-->
<style> 
.testing .file-preview-frame,.testing .file-preview-frame:hover {
    margin: 0;
    padding: 0;
    border: none;
    box-shadow: none;
    text-align: center;
}
.testing .file-input {
    display: table-cell;
    max-width: 220px;
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
                            <?php if ($editar){?>
                                <a class="btn btn btn-success pull-right"  title="Editar" onclick="edit_var(<?php echo $item['id']?>)"><i class="glyphicon glyphicon-pencil"></i></a>
                            <?php } ?>
                            <div class="panel panel-default">                      
                                <div class="panel-heading">
                                   <div align="center"> <img src="<?php echo base_url() . $item['icono']; ?>" class="img-rounded" alt="bordes redondeados" width="125" height="125"></div>
                                </div>
                                <div class="panel-body">
                                    <p align="center"><strong><?php echo strtoupper($item['cuadrilla']) ?></strong></p>
                                </div>
                                <div class="panel-footer">
                                    <p align="center"><strong>Jefe de cuadrilla:&nbsp;</strong>
                                    <?php echo $item['nombre'] ?></p>
                                </div>
                            </div>
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <p><strong>Miembros:&nbsp;</strong></p>
                                </div>
                                <div class="panel-body">
                                    <div class="table-responsive">
                                        <?php if ($agregar){?>
                                            <button class="btn btn-success" title="Agregar" onclick="add_trabajador()"><i class="glyphicon glyphicon-plus"></i></button>
                                        <?php } ?>
                                            <table id="trabajadores" class="table table-hover table-bordered table-condensed" >
                                            <thead align="center">
                                                <tr>
                                                    <!--<th></th>-->
                                                    <th><div align="center">Nombre</div></th>
                                                    <th><div align="center">Apellido</div></th>
                                                    <th>Acción</th>
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
    </div>
</div>
            <!-- Modal Agregar trabajadores-->
<div id="modificar" class="modal modal-message modal-info fade" tabindex="-1" role="dialog" aria-labelledby="modificacion" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <span><i class="glyphicon glyphicon-check"></i></span>
            </div>
            <div class="modal-body">
            <div align="center">
                <div align="center"><h3>Agregar trabajadores a la cuadrilla</h3></div>
                    <form action="#" class="form-horizontal" name="modifica" id="modifica">                      
                        <table id="trabajadores2" class="table table-hover table-bordered table-condensed display select" width="100%" >
                            <thead>
                                <tr>
                                    <th><input type="checkbox" value="1" name="select_all" class="icon-checkbox"><label for="checkbox1">
                                        <span id="clickable" style="color:#D9534F" class='glyphicon glyphicon-minus unchecked'></span>
                                        <span id="clickable" class='glyphicon glyphicon-plus checked color'></span></label></th>
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
                            <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
<!--                        <button class="btn btn-default" type="reset">Reset</button>-->
                        <button type="submit" onclick="guardar()" class="btn btn-success">Agregar</button>
                        </div>
                    </form>
            </div>
            </div>
        </div>
    </div>
</div>
<!-- Modal editar jefe/nombre e imagen-->
<div id="editar" class="modal modal-message modal-info fade" tabindex="-1" role="dialog" aria-labelledby="modificacion" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <span><i class="glyphicon glyphicon-edit"></i></span>
            </div>
            <div class="modal-body row">
                <form action="<?php echo base_url() ?>index.php/mnt_cuadrilla/cuadrilla/modificar_cuadrilla" class="form-horizontal" name="modifica" id="modifica" method="post" enctype="multipart/form-data">   
                    <div class="col-md-12">
                        <!--<div align="center"><h3>Editar</h3></div>-->
                        <input type="hidden" id="cuad_id" name="data[id]" value="<?php echo $item['id']?>">
                        <!-- nombre de la cuadrilla -->
                        <div class="form-group">
                            <label class="control-label col-lg-3" for="cuadrilla">Nombre:</label>
                            <div class="col-lg-7">
                                <input type="text" class="form-control input-sm" id="cuadrilla" name="data[cuadrilla]" placeholder='Nombre de la cuadrilla'>
                            </div>
                        </div>
                          <!-- SELECT RESPONSABLE -->
                        <div class="form-group">
                            <label class="control-label col-lg-3" for = "id_trabajador_responsable">Jefe de cuadrilla:</label>
                                <div class="col-lg-7"> 
                                    <select class="form-control" id = "id_trabajador_responsable" name="data[id_trabajador_responsable]">
                                        <option></option>
                                    </select>
                                    <!--<input class='form-control col-lg-5 itemSearch' id = "id_trabajador_responsable" type='text' placeholder='select item' />-->
                                </div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="testing center-block" align="center">
                            <label class="control-label">Imagen</label>
                            <input id="file-3" name="archivo" type="file" multiple=true class="file-loading">
                        </div>
                        <div class="col-md-12">
                            <br>  
                        </div>
                        <div class="col-md-2">
                     
                        </div>   
                        <div class="col-md-8">
                            <div class="input-group">
                                <span class="input-group-addon" id="basic-addon3">Nombre de la imagen:</span>
                                <input type="text" class="form-control input-sm" name="nombre_img" id="nombre_img" aria-describedby="basic-addon3">
                            </div>
                        </div>
                        <div class="col-xs-12">
                            <br>   
                        </div>
                    </div>               
                    <div class="modal-footer">
                        <input type="hidden" id="ruta" name ="ruta" value="<?php echo $item['icono']?>">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
<!--                    <button class="btn btn-default" type="reset">Reset</button>-->
<!--                    <input onClick="javascript:window.history.back();" type="button" value="Regresar" class="btn btn-info"></>-->
                        <button type="submit" class="btn btn-success">Guardar</button>
                    </div>
                <!-- Fin de Formulario -->
                </form>         
            </div>
        </div>
    </div>
</div>
<div class="clearfix"></div>

        