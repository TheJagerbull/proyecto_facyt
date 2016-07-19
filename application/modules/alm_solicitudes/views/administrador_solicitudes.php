<script src="<?php echo base_url() ?>assets/js/jquery.min.js"></script>
<script type="text/javascript">
  base_url = '<?php echo base_url()?>';
  
  $(document).ready(function()
  {

    var adminTable = $('#admin').DataTable({
      "language": {
          "url": "<?php echo base_url() ?>assets/js/lenguaje_datatable/spanish.json"
      },
      "bProcessing": true,
      "lengthChange": false,
            "stateSave": true,
            "bServerSide": true,
            "sServerMethod": "GET",
            "sAjaxSource": "<?php echo base_url() ?>index.php/alm_solicitudes/build_tables/admin",
            "bDeferRender": true,
            "fnServerData": function (sSource, aoData, fnCallback, oSettings){
                aoData.push({"name":"fecha", "value": $('#date').val()}, {"name":"articulo", "value": $('#articulo').val()});//para pasar datos a la funcion que construye la tabla
                oSettings.JqXHR = $.ajax({
                  "dataType": "json",
                  "type": "GET",
                  "url": sSource,
                  "data": aoData,
                  "success": fnCallback
                });
            },
            "iDisplayLength": 10,
            "aLengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
            "aaSorting": [[0, 'asc']],
            "aoColumns": [
        { "bVisible": true, "bSearchable": true, "bSortable": true },
        { "bVisible": true, "bSearchable": true, "bSortable": true },
        { "bVisible": true, "bSearchable": true, "bSortable": true },
        { "bVisible": true, "bSearchable": true, "bSortable": true },
        { "bVisible": true, "bSearchable": true, "bSortable": true },
        { "bVisible": true, "bSearchable": false, "bSortable": false },
        { "bVisible": true, "bSearchable": false, "bSortable": false }//la columna extra
            ]
    });
    $('#date').change(function(){adminTable.ajax.reload();});
    
      //script
        $("input[type='numb']").keyup(function(){
          console.log(this.val());
        });
    $('#date span').html(moment().subtract(29, 'days').format('MMMM D, YYYY') + ' - ' + moment().format('MMMM D, YYYY'));

    $('#date').daterangepicker({
        format: 'DD/MM/YYYY',
        startDate: moment(),
        endDate: moment(),
        minDate: '12/31/2014',
        maxDate: '12/31/2021',
        // dateLimit: {days: 90},
        showDropdowns: true,
        showWeekNumbers: true,
        timePicker: false,
        timePickerIncrement: 1,
        timePicker12Hour: true,
        ranges: {
            'Hoy': [moment(), moment()],
            'Ayer': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
            'Últimos 7 días': [moment().subtract(6, 'days'), moment()],
            'Últimos 30 días': [moment().subtract(29, 'days'), moment()],
            'Este mes': [moment().startOf('month'), moment().endOf('month')],
            'Mes Pasado': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
        },
        opens: 'right',
        drops: 'down',
        buttonClasses: ['btn', 'btn-sm'],
        applyClass: 'btn-primary',
        cancelClass: 'btn-default',
        separator: ' al ',
        locale: {
            applyLabel: 'Listo',
            cancelLabel: 'Cancelar',
            fromLabel: 'Desde',
            toLabel: 'Hasta',
            customRangeLabel: 'Personalizado',
            daysOfWeek: ['Do', 'Lu', 'Ma', 'Mi', 'Ju', 'Vi', 'Sa'],
            monthNames: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
            firstDay: 1
        }

    }, function (start, end, label) {
        console.log(start.toISOString(), end.toISOString(), label);
        $('#date span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
    });
    $('#date').on('click', function(){
      $('#date').val('');
      adminTable.ajax.reload();
    });

    $('#art_inSol').on('click', function(){
      $('#art_inSol').val('');
      $('#art_inSol').removeAttr('readonly');
    });

    $('#art_inSol').autocomplete({
      minLength: 2,
      source: function (request, response) {
          $.ajax({
              request: $('#art_inSol').val(),
              blah: console.log(request),
              url: base_url + "index.php/alm_articulos/ajax_likeArticulos",
              type: 'POST',
              dataType: "json",
              data: {"articulos": $('#art_inSol').val()},
              success: function (data) {
                  // console.log("hello");
                  response($.map(data, function (item) {
                      console.log(item.cod_articulo);
                      $("#articulo").val(item.ID);
                      return {
                          label: 'Codigo: '+item.cod_articulo+' '+item.descripcion
                      };
                  }));
              }
          });
      }
    });
    $("#art_inSol").on('autocompleteselect', function(event, ui){
      // console.log(ui.item.value);
      $("#art_inSol").val(ui.item.label);
      // $("#articulo").val(ui.item.value);
      console.log($("#articulo").val());
      adminTable.ajax.reload();
    });
    $("#art_inSol").on('autocompletefocus', function(event, ui){
      $("#art_inSol").val(ui.item.label);
      // $("#articulo").val(ui.item.value);
      console.log("138");
    });

    $('#art_inSol').on('focusout', function(){
      $('#art_inSol').attr('readonly', '');
    });
    // swal({
    //   title: "Are you sure?",
    //   text: "Your will not be able to recover this imaginary file!",
    //   type: "warning",
    //   showCancelButton: true,
    //   confirmButtonClass: "btn-danger",
    //   confirmButtonText: "Yes, delete it!",
    //   closeOnConfirm: false
    // },
    // function(){
    //   swal("Deleted!", "Your imaginary file has been deleted.", "success");
    // });

  // swal({
  //   title: "An input!",
  //   text: "Write something interesting:",
  //   type: "input",
  //   showCancelButton: true,
  //   closeOnConfirm: false,
  //   inputPlaceholder: "Write something"
  // }, function (inputValue) {
  //   if (inputValue === false) return false;
  //   if (inputValue === "") {
  //     swal.showInputError("You need to write something!");
  //     return false
  //   }
  //   swal("Nice!", "You wrote: " + inputValue, "success");
  // });
  });
</script>
<?php $aux = $this->session->userdata('query');
      $aux2 = $this->session->userdata('range');
?>
            <div class="mainy">
              <!-- Page title -->
              <div class="page-title">
                <h2 align="right"><i class="fa fa-inbox color"></i> Solicitudes <small>de almacen</small></h2>
                <hr />
              </div>
               <!-- Page title -->
               <div class="awidget full-width">
                  <div class="awidget-head">
                    <h2>Solicitudes recibidas</h2>
                  </div>
                  <div class="awidget-body">
                    <div class="controls-row">
                      <!-- <div class="control-group"> -->
                      <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                        <div class="input-group">
                            <span id="basic-addon1" class="input-group-addon">
                                <i class="fa fa-calendar"></i>
                            </span>
                            <input class="form-control input-sm" name="fecha" id="date" readonly placeholder=" Búsqueda por Fechas" type="search">
                        </div>
                      </div>
                      <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                        <div class="input-group">
                            <input id="articulo" name="articulo" hidden />
                            <input class="form-control input-sm dropdown" id="art_inSol" readonly placeholder=" Búsqueda por articulos en solicitud" type="search">
                            <span id="basic-addon2" class="input-group-addon">
                                <i class="fa fa-search-plus"></i>
                            </span>
                            <div id="options" class="dropdown-content"></div>
                        </div>
                      </div>
                      <!-- </div> -->
                    </div>
                    <table id="admin" class="table table-hover table-bordered col-lg-8 col-md-8 col-sm-8">
                        <thead>
                            <tr>
                                <th>Solicitud</th>
                                <th>Fecha generada</th>
                                <th>Generada por:</th>
                                <th>Departamento</th>
                                <th>Estado actual</th>
                                <th>Detalles</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                        <tfoot></tfoot>
                    </table>
                  </div>
                </div>
            </div>