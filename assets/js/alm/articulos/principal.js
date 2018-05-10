$(document).ready(function () {
    /* prettyPhoto Gallery starts */

    $(".prettyphoto").prettyPhoto({
        overlay_gallery: false, social_tools: false
    });

    /* prettyPhoto ends */
////autocompletado y formulario de articulos de Administrador sin redireccionamiento de vista
    var min = 2;
    $("#autocompleteAdminArt").autocomplete({
        minLenght: min,
        source: function (request, response) {
            $.ajax({
                request: $('#ACqueryAdmin'),
                // blah: console.log(request),
                url: base_url + "inventario/articulo/autocompletar",
                type: 'POST',
                dataType: "json",
                data: $('#ACqueryAdmin').serialize(),
                success: function (data) {
                    response($.map(data, function (item) {
                        return {
                            label: item.title,
                            value: [item.descripcion+" Codigo: "+item.cod_articulo]
                        }
                    }));
                }
            })
        }
    });
    $(function()
    {
        $('#error').hide();
        $("#autocompleteAdminArt").on('autocompleteselect', function(event, ui){
            $("input#autocompleteAdminArt").val(ui.item.value);
            //validar y formulario
            $('#error').hide();
            var articulo = $("input#autocompleteAdminArt").val();
            if (articulo == "")
            {
                $("#error").html("Debe escribir alguna descripci&oacute;n &oacute; c&oacute;digo de art&iacute;culo");
                $("#error").show();
                $("input#autocompleteAdminArt").focus();
                return false;
            }
            var aux = articulo.split(" Codigo: ");
            if(aux[1]==undefined)
            {
                // console.log("faaak");
                var dataString = 'descripcion=' + aux[0];
            }
            else
            {
                var dataString = 'descripcion=' + aux[0] + ' codigo=' + aux[1];
            }
            // var dataString = 'articulo='+ articulo;
            console.log(dataString);
            //alert (dataString);return false;
            $.ajax({
            type: "POST",
            url: base_url + "inventario/add/articulo",
            data: dataString,
            success: function(data) {
                $('#resultado').html(data),
                $('html, body').animate({
                    scrollTop: $("#resultado").offset().top
                }, 2000);
            }
            });
            return false;
        });
        $('#ACqueryAdmin').on('submit', function(){
            var dataString = $("input#autocompleteAdminArt").val();
            console.log(dataString);
            $.ajax({
            type: "POST",
            url: base_url + "inventario/add/articulo",
            data: dataString,
            success: function(data) {
                $('#resultado').html(data),
                $('html, body').animate({
                    scrollTop: $("#resultado").offset().top
                }, 2000);
            }
            });
            return false;
        });
        
    });
//// FIN DE autocompletado y formulario de articulos de Administrador sin redireccionamiento de vista

    $('#fecha span').html(moment().subtract(29, 'days').format('MMMM D, YYYY') + ' - ' + moment().format('MMMM D, YYYY'));

    $('#fecha').daterangepicker({
        format: 'DD/MM/YYYY',
        startDate: moment().subtract(29, 'days'),
        endDate: moment(),
        // minDate: '01/01/2012',
        // maxDate: '12/31/2021',
        dateLimit: {days: 90},
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
        opens: 'left',
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
        $('#fecha span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
    });


});
