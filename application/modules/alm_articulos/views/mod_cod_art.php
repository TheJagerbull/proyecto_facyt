<script src="<?php echo base_url() ?>assets/js/jquery.min.js"></script>
<!--<script src="<?php echo base_url() ?>assets/js/dataTables_altEditor.js"></script>-->
<script type="text/javascript">
    base_url = '<?php echo base_url() ?>';
    $(document).ready(function () {
       //Example of column definitions.
var columnDefs = [{
    id: "ID",
    data: "ID",
    "visible": false,
    "searchable": false
  },{
      title: "Descripcion",
      id: "descripcion",
      data: "descripcion",
      type: "label"
      
     
    }, {
      title: "Código del Articulo",
      id: "cod_articulo",
      data: "cod_articulo",
      type: "text",
      pattern: "^((?:(?:25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\){3}(?:25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)){0,1}$",
      errorMsg: "*Invalid address - Enter valid ip.",
      hoverMsg: "(Optional) - Ex: 82.84.86.88",
      unique: true
      
     
    
    }];
        var table = $('#almacen').DataTable({
                    "language": {
                        "url": "<?php echo base_url() ?>assets/js/lenguaje_datatable/spanish.json"
                    },
                    "aoColumns": columnDefs,
                    "bProcessing": true,
                     stateSave: true,
                    "bDeferRender": true,
                    "altEditor": true,      // Enable altEditor ****
                    "buttons": [{
//                            text: 'Añadir',
//                            name: 'add'        // DO NOT change name
//                        },
//                        {
                            extend: 'selected', // Bind to Selected row
                            text: 'Editar',
                            className: 'btn btn-info',
                             name: 'edit'        // DO NOT change name
                        }
//                        {
//                            extend: 'selected', // Bind to Selected row
//                            text: 'Borrar',
//                            name: 'delete'      // DO NOT change name
//                        }
                    ],
                    "select": 'single',     // enable single row selection
                    "serverSide": true, //Feature control DataTables' server-side processing mode.
                    "pagingType": "full_numbers", //se usa para la paginacion completa de la tabla
                    "sDom": '<"row"<"col-sm-2"f><"col-sm-8"><"col-sm-2"B>>rt<"row"<"col-sm-2"l><"col-sm-10"p>>', //para mostrar las opciones donde p=paginacion,l=campos a mostrar,i=informacion
                    "order": [[0, "asc"]], //para establecer la columna a ordenar por defecto y el orden en que se quiere 
                    "aoColumnDefs": [{"className": "dt-center","targets": "2"}],//para desactivar el ordenamiento en esas columnas
                    "ajax": {
                        "url": "<?php echo site_url('tablas/inventario/editar') ?>",
                        "type": "GET"
                            }
                     
                    });
                   
    });     
</script>
<!-- Page content -->
<style>
    .table th {
  text-align: center;
}
</style>
<div class="mainy">
<!-- Page title --> 
    <div class="page-title">
        <h2 align="right"><i class="fa fa-edit color"></i> Articulos <small>Seleccione para modificar  </small></h2>
        <hr />
    </div>
    
    <!-- Page title -->
    <!--<div class="row">-->
        <div class="panel panel-default">
            <div class="panel-heading"><label class="control-label">Listado de Artículos</label>
            <!--<button class="btn btn-warning pull-right" id="Ayuda" type="submit" title="Ayuda de lista"><i class="fa fa-question fa-fw"></i></button>-->
            </div>
            <div class="panel-body">
                <div class="table-responsive">
                    <div class="col-lg-12 col-md-12 col-sm-12">
                        <table id="almacen" class="table table-hover table-bordered table-condensed" align="center" width="100%">
                            <thead>
                                <tr class="active">
                                    <th>ID</th>
                                    <th>Descripcion</th>
                                    <th>Código</th>
                                </tr>
                            </thead>
                            <tbody align="center"></tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
</div>
<script type="text/javascript">
    $("#Ayuda").on('click', function (e)
    {
        swal({
            title: "Listado de artículos",
            text: "- \n ",
            imageUrl: base_url+"assets/img/info.png"
            // type: "warning"
        });
        return false;
    });
</script>
 