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
            "bServerSide": true,
            "sServerMethod": "GET",
            "sAjaxSource": "alm_solicitudes/build_tables/admin",
            "bDeferRender": true,
            "fnServerData": function (sSource, aoData, fnCallback, oSettings){
                aoData.push({"name":"fecha", "value": $('#date').val()});//para pasar datos a la funcion que construye la tabla
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
        { "bVisible": true, "bSearchable": false, "bSortable": true },
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
                      <div class="control-group">
                        <div class="input-group">
                            <span class="input-group-addon btn btn-info">
                                <i class="fa fa-calendar"></i>
                            </span>
                            <input class="form-control input-sm" style="width: 20%" name="fecha" id="date" readonly placeholder=" Búsqueda por Fechas" type="search">
                        </div>
                        <hr>
                      </div>
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