<script src="<?php echo base_url() ?>assets/js/jquery.min.js"></script>
<div class="mainy">
  <!-- Page title -->
  <div class="page-title">
    <h2 align="right"><i class="fa fa-inbox color"></i> Edición <small>de solicitud</small></h2>
    <hr />
  </div>
   <!-- Page title -->
   <div class="page-body">
   <div class="awidget full-width">
      <div class="awidget-head">
        <h2>Solicitud actual</h2>
      </div>
      <div class="awidget-body">
        <div class="controls-row">
          <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
          </div>
          <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
              <button id="call-art-modal" class="btn btn-primary btn-block" >Agregar articulo <i class="fa fa-plus"></i></button>
          </div>
        </div>
          <table id="articulos-cart" class="table table-hover table-bordered">
              <thead>
                  <tr>
                      <th><div align="center">Item</div></th>
                      <th><div align="center">Codigo</div></th>
                      <th>Unidad</th>
                      <th>Descripcion</th>
                      <th><div align="center">Cantidad</div></th>
                      <th class="danger" ><div align="center">Quitar</div></th>
                  </tr>
              </thead>
              <tbody></tbody>
              <tfoot></tfoot>
          </table>
      </div>
      <div class="awidget-foot">
      </div>
    </div>
   </div>
</div>

<div id="multPurpModal" class="modal modal-message modal-info fade" tabindex="-1" role="dialog" aria-labelledby="mod" aria-hidden="true">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <h3>Agregar artículos <i class="fa fa-plus color fa-fw"></i></h3>
              </div>
              <div class="modal-body table-responsive">
                <table id="act-inv" class="table table-hover table-bordered">
                    <thead>
                        <th><div align="center">Item</div></th>
                        <th><div align="center">Código</div></th>
                        <th>Descripcion</th>
                        <th><div align="center">Agregar/Remover</div></th>
                    </thead>
                    <tbody></tbody>
                    <tfoot></tfoot>
                </table>
              </div>
              <div class="modal-footer"></div>
            </div>
  </div>
</div>
<script type="text/javascript">
  base_url = '<?php echo base_url()?>';
  $(document).ready(function() {
      
      var selected =  new Array();//transicion de session a variable para la alteracion de la lista de articulos en solicitud
      //tabla de articulos en carrito
      var oTable = $('#articulos-cart').DataTable({
        "language": {
          "url": "<?php echo base_url() ?>assets/js/lenguaje_datatable/spanish.json"
        },
        "type": "POST",
        "sAjaxSource": base_url+"tablas/solicitud/paso2",
        "destroy": true,
        "sDom": '<"top"p>t',
        "autoWidth": false,
        "columns": [
          {"width": "10%", "data": "ID"},
          {"width": "10%", "data": "cod_articulo"},
          {"width": "10%", "data": "unidad"},
          {"width": "50%", "data": "descripcion"},
          {"width": "10%", "data": "agregar"},
          {"width": "10%", "data": "quitar"}
        ]
      });
      //evento de construccion de la tabla de articulos para agregar
      oTable.on('draw.dt', function(){
        console.log("BOOH!");
        aux = <?php echo json_encode($this->session->userdata('articulos')); ?>;//para cargar los articulos de la solicitud en la lista
        if(aux && typeof aux[0] ==='string')
        {
          // selected = aux;
          for (var i = aux.length - 1; i >= 0; i--)
          {
            if(typeof aux[i].descripcion !== 'undefined' && typeof aux[i].cant !== 'undefined' && typeof aux[i].id_articulo !== 'undefined')
            {
              selected[i]= "row_"+aux[i].id_articulo;
            }
            else
            {
              selected[i] = "row_"+aux[i];//para mantener una relacion entre las filas de la tabla de articulos activos, y los articulos en la variable selected
            }
          };
        }
      });
      //tabla de artitulos activos de inventario, para agregar
      var actTable = $('#act-inv').DataTable({
          "language": {
            "url": "<?php echo base_url() ?>assets/js/lenguaje_datatable/spanish.json"
          },
          "pagingType": "numbers",
          "info":false,
          "bProcessing": true,
          "bServerSide": true,
          "sServerMethod": "GET",
          "sAjaxSource": base_url+"tablas/inventario/solicitud/1",
          "rowCallback": function( row, data) {
                  if ( $.inArray(data.DT_RowId, selected) !== -1 ) {//si los articulos estan en el arreglo, cambio sus propiedades para que puedan ser retirados
                    $('i', row).attr("class", 'fa fa-minus');
                    $('i', row).attr("style", 'color:#D9534F');
              oTable.ajax.reload();
                  }
              },
          "iDisplayLength": 10,
          "aLengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
          "aaSorting": [[0, 'asc']],
          "aoColumns": [
            { "bVisible": true, "bSearchable": true, "bSortable": true },
            { "bVisible": true, "bSearchable": true, "bSortable": true },
            { "bVisible": true, "bSearchable": true, "bSortable": true },
            { "bVisible": true, "bSearchable": true, "bSortable": false }//la columna extra
                ]
      });
      //evento de seleccionar un articulo en la tabla de articulos activos
      $('#act-inv tbody').on( 'click', 'i', function () {
              var id = this.id;
              var articulos = <?php echo json_encode($this->session->userdata('articulos')) ?>;//precargo lo que tengo en session sobre los articulos seleccionados
              var index = $.inArray(id, selected);//si el articulo esta en el arreglo
              if( index === -1 )//si no esta en el arreglo...
              {
                  selected.push( id );//lo apilo al arreglo y...
                  $(this).attr("class", 'fa fa-minus');//cambio las propiedades para que pueda ser retirado
                  $(this).attr("style", 'color:#D9534F');//cambio las propiedades para que pueda ser retirado
              }
              else//sino
              {
                  selected.splice( index, 1 );//lo retiro del arreglo
                  $(this).attr("class", 'fa fa-plus color');//cambio las propiedades para que pueda ser agregado
                  $(this).removeAttr("style");//cambio las propiedades para que pueda ser agregado
              }
              var items =[];
              for (var i = selected.length - 1; i >= 0; i--)
              {
                var cod = selected[i].slice(4);
                  items.push( cod );

              };
              if(items.length===0)
              {
                items='/clear';//paso valor para desmontar articulos de session
              }
              $.post(base_url+"solicitud/pasos", { //se le envia la data por post al controlador respectivo
                  update: items  //variable a enviar
              });
              setTimeout(function(){
                oTable.ajax.reload();//aqui funciona
              }, 450);
      });
      $("#call-art-modal").click(function(){
          $("#multPurpModal").modal(
              backdrop=false
              );
          $("#multPurpModal").modal('show');
      });

      $("#multPurpModal").on('show.bs.modal', function(){
      });
  });
</script>