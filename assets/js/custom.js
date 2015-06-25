/* Admin sidebar starts */

$(document).ready(function () {

    $(window).resize(function ()
    {
        if ($(window).width() >= 991) {
            $(".sidey").slideDown(350);
        }
    });

});

$(document).ready(function () {

    $(".has_submenu > a").click(function (e) {
        e.preventDefault();
        var menu_li = $(this).parent("li");
        var menu_ul = $(this).next("ul");

        if (menu_li.hasClass("open")) {
            menu_ul.slideUp(350);
            menu_li.removeClass("open")
        }
        else {
            $(".nav > li > ul").slideUp(350);
            $(".nav > li").removeClass("open");
            menu_ul.slideDown(350);
            menu_li.addClass("open");
        }
    });

});

$(document).ready(function () {
    $(".sidebar-dropdown a").on('click', function (e) {
        e.preventDefault();

        if (!$(this).hasClass("dropy")) {
            // hide any open menus and remove all other classes
            $(".sidey").slideUp(350);
            $(".sidebar-dropdown a").removeClass("dropy");

            // open our new menu and add the dropy class
            $(".sidey").slideDown(350);
            $(this).addClass("dropy");
        }

        else if ($(this).hasClass("dropy")) {
            $(this).removeClass("dropy");
            $(".sidey").slideUp(350);
        }
    });

});



/* Admin sidebar navigation ends */

/* ********************************************************** */

/* Calendar starts */

$(document).ready(function () {

    var date = new Date();
    var d = date.getDate();
    var m = date.getMonth();
    var y = date.getFullYear();

    $('#calendar').fullCalendar({
        header: {
            left: 'prev',
            center: 'title',
            right: 'month,agendaWeek,agendaDay,next'
        },
        editable: true,
        events: [
            {
                title: 'All Day Event',
                start: new Date(y, m, 1)
            },
            {
                title: 'Long Event',
                start: new Date(y, m, d - 5),
                end: new Date(y, m, d - 2)
            },
            {
                id: 999,
                title: 'Repeating Event',
                start: new Date(y, m, d - 3, 16, 0),
                allDay: false
            },
            {
                id: 999,
                title: 'Repeating Event',
                start: new Date(y, m, d + 4, 16, 0),
                allDay: false
            },
            {
                title: 'Meeting',
                start: new Date(y, m, d, 10, 30),
                allDay: false
            },
            {
                title: 'Lunch',
                start: new Date(y, m, d, 12, 0),
                end: new Date(y, m, d, 14, 0),
                allDay: false
            },
            {
                title: 'Birthday Party',
                start: new Date(y, m, d + 1, 19, 0),
                end: new Date(y, m, d + 1, 22, 30),
                allDay: false
            },
            {
                title: 'Click for Google',
                start: new Date(y, m, 28),
                end: new Date(y, m, 29),
                url: 'http://google.com/'
            }
        ]
    });

});

/* Calendar ends */

/* ************************************** */

/* Progressbar animation starts */

setTimeout(function () {

    $('.progress-animated .progress-bar').each(function () {
        var me = $(this);
        var perc = me.attr("data-percentage");

        //TODO: left and right text handling

        var current_perc = 0;

        var progress = setInterval(function () {
            if (current_perc >= perc) {
                clearInterval(progress);
            } else {
                current_perc += 1;
                me.css('width', (current_perc) + '%');
            }

            me.text((current_perc) + '%');

        }, 600);

    });

}, 600);

/* Progressbar animation ends */

/* ************************************** */

/* Slider starts */

$(function () {
    // Horizontal slider
    $("#master1, #master2").slider({
        value: 60,
        orientation: "horizontal",
        range: "min",
        animate: true
    });

    $("#master4, #master3").slider({
        value: 80,
        orientation: "horizontal",
        range: "min",
        animate: true
    });

    $("#master5, #master6").slider({
        range: true,
        min: 0,
        max: 400,
        values: [75, 200],
        slide: function (event, ui) {
            $("#amount").val("$" + ui.values[ 0 ] + " - $" + ui.values[ 1 ]);
        }
    });


    // Vertical slider 
    $("#eq > span").each(function () {
        // read initial values from markup and remove that
        var value = parseInt($(this).text(), 10);
        $(this).empty().slider({
            value: value,
            range: "min",
            animate: true,
            orientation: "vertical"
        });
    });
});

/* Slider ends */

/* ************************************** */

/* Scroll to Top starts */

$(".totop").hide();

$(function () {
    $(window).scroll(function () {
        if ($(this).scrollTop() > 300)
        {
            $('.totop').fadeIn();
        }
        else
        {
            $('.totop').fadeOut();
        }
    });

    $('.totop a').click(function (e) {
        e.preventDefault();
        $('body,html').animate({scrollTop: 0}, 500);
    });

});

/* Scroll to top ends */

/* ************************************** */

/* jQuery Notification (Gritter) starts */

$(document).ready(function () {

    /* Auto notification */

    // setTimeout(function() {
// 
    // var unique_id = $.gritter.add({
    // // (string | mandatory) the heading of the notification
    // title: 'Howdy! User 1',
    // // (string | mandatory) the text inside the notification
    // text: 'Today you got some messages and new members. Please check it out!',
    // // (string | optional) the image to display on the left
    // image: './img/user.jpg',
    // // (bool | optional) if you want it to fade out on its own or just sit there
    // sticky: false,
    // // (int | optional) the time you want it to be alive for before fading out
    // time: '',
    // // (string | optional) the class name you want to apply to that specific message
    // class_name: 'gritter-custom'
    // });
// 
    // // You can have it return a unique id, this can be used to manually remove it later using
    // setTimeout(function () {
    // $.gritter.remove(unique_id, {
    // fade: true,
    // speed: 'slow'
    // });
    // }, 10000);
// 
    // }, 4000);


    /* On click notification. Refer ui.html file */

    /* Regulat notification */
    $(".notify").click(function (e) {

        e.preventDefault();
        var unique_id = $.gritter.add({
            // (string | mandatory) the heading of the notification
            title: 'Howdy! User 2',
            // (string | mandatory) the text inside the notification
            text: 'Today you got some messages and new members. Please check it out!',
            // (string | optional) the image to display on the left
            image: './img/user.jpg',
            // (bool | optional) if you want it to fade out on its own or just sit there
            sticky: false,
            // (int | optional) the time you want it to be alive for before fading out
            time: '',
            // (string | optional) the class name you want to apply to that specific message
            class_name: 'gritter-custom'
        });

        // You can have it return a unique id, this can be used to manually remove it later using
        setTimeout(function () {
            $.gritter.remove(unique_id, {
                fade: true,
                speed: 'slow'
            });
        }, 6000);

    });

    /* Sticky notification */
    $(".notify-sticky").click(function (e) {

        e.preventDefault();
        var unique_id = $.gritter.add({
            // (string | mandatory) the heading of the notification
            title: 'Howdy! User 3',
            // (string | mandatory) the text inside the notification
            text: 'Today you got some messages and new members. Please check it out!',
            // (string | optional) the image to display on the left
            image: './img/user.jpg',
            // (bool | optional) if you want it to fade out on its own or just sit there
            sticky: false,
            // (int | optional) the time you want it to be alive for before fading out
            time: '',
            // (string | optional) the class name you want to apply to that specific message
            class_name: 'gritter-custom'
        });

    });

    /* Without image notification */
    $(".notify-without-image").click(function (e) {

        e.preventDefault();
        var unique_id = $.gritter.add({
            // (string | mandatory) the heading of the notification
            title: 'Howdy! User 4',
            // (string | mandatory) the text inside the notification
            text: 'Today you got some messages and new members. Please check it out!',
            // (bool | optional) if you want it to fade out on its own or just sit there
            sticky: false,
            // (int | optional) the time you want it to be alive for before fading out
            time: '',
            // (string | optional) the class name you want to apply to that specific message
            class_name: 'gritter-custom'
        });

    });

    /* Remove notification */

    $(".notify-remove").click(function () {

        $.gritter.removeAll();
        return false;

    });
});

/* Notification ends */

/* ************************************** */

/* Date and picker starts */

$(function () {
    $('#datetimepicker1').datetimepicker();
});

$(function () {
    $('#datetimepicker2').datetimepicker();
});

$(function () {
    $('#datepicker2').datetimepicker({
        pickTime: false
    });
});

$(function () {
    $('#datepicker2').datetimepicker({
        pickTime: false
    });
});


$(function () {
    $('#timepicker1').datetimepicker({
        pickDate: false
    });
});


$(function () {
    $("#todaydate").datepicker();
});

/* Date and time picker ends */

/* ************************************** */




/* CL Editor starts */

$(".cleditor").cleditor({
    width: "auto",
    height: "auto"
});


/* CL Editor ends */

/* ************************************** */


/* prettyPhoto Gallery starts */

$(".prettyphoto").prettyPhoto({
    overlay_gallery: false, social_tools: false
});

/* prettyPhoto ends */

/* ************************************** */

/* Peity starts */

$(".peity-bar").peity("bar", {
    colours: ["white"],
    height: 50,
    width: 100
});

/* Peity ends */

//Para el buscador de solicitudes de mantenimiento
$(function () {

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

/////////////////opciones//puede ser usado en cualquier vista
$(function () {
    $('#' + $('#opciones').val()).show();
});
$(function () {
    $('#opciones').change(function () {
        $('.opcional').hide();//todo lo que tenga class="opcional" va a estar escondido
        $('#' + $(this).val()).show();
    });
});
//////para usarlo solo se debe crear un input de tipo <select> donde se le debe agregar el id='opciones'
//////luego a cada bloque que se desea mantener oculto se le debe anexar la palabra "opcional" a la class=""
//////ejemplo: class="col-md-5" pasa a ser class="col-md-5 opcional"
//////y los values="" de los <option> deben ser igual a cada id="" de los bloques que se deseen mostrar
//Para el uso de dataTables en mnt_solicitudes 
$(document).ready(function () {
    //para usar dataTable en la table solicitudes
    var table = $('#solicitudes').DataTable({
        "pagingType": "full_numbers", //se usa para la paginacion completa de la tabla
        "sDom": '<"top"lp<"clear">>rt<"bottom"ip<"clear">>', //para mostrar las opciones donde p=paginacion,l=campos a mostrar,i=informacion
        "order": [[1, "desc"]], //para establecer la columna a ordenar por defecto y el orden en que se quiere 
        "aoColumnDefs": [{"orderable": false, "targets": [0, 9]}]//para desactivar el ordenamiento en esas columnas
    });
    table.column(9).visible(false);//para hacer invisible una columna usando table como variable donde se guarda la funcion dataTable 
    //$('div.dataTables_filter').appendTo(".search-box");//permite sacar la casilla de busqueda a un div donde apppendTo se escribe el nombre del div destino
    $('#buscador').keyup(function () { //establece un un input para el buscador fuera de la tabla
        table.search($(this).val()).draw(); // escribe la busqueda del valor escrito en la tabla con la funcion draw
    });


    $('a.toggle-vis').on('click', function (e) {//esta funcion se usa para mostrar columnas ocultas de la tabla donde a.toggle-vis es el <a class> de la vista 
        e.preventDefault();

        // toma el valor que viene de la vista en <a data-column>para establecer la columna a mostrar
        var column = table.column($(this).attr('data-column'));

        // Esta es la funcion que hace el cambio de la columna
        column.visible(!column.visible());
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

//esta funcion sirve para agregar otro campo de busqueda anexo al que ya posee el datatable, en este caso lo uso para la busqueda por fechas            
$.fn.dataTableExt.afnFiltering.push(
        function (oSettings, aData, iDataIndex) {//oSettings es un valor de datatable, aData es la columna donde voy a buscar
            if (oSettings.nTable.id === 'solicitudes') {
                var valor = $('#fecha').val().split('al');//se toma el valor del input fecha, se guarda en una variable y se quita la palabra al para que quede solo la fecha
                $('#valor').val(valor);// se usa para monitorear el valor en un input
                var iMin_temp = valor[0];//al separar la variable valor con split queda como un array
                if (iMin_temp === '') { //en caso de que este vacia se establece una fecha de inicio general 
                    iMin_temp = '01/01/2015';//fecha de rango inferior
                }
                var iMax_temp = valor[1];
                if (typeof (iMax_temp) === "undefined") {// en caso de que la primera vez la variable valor no sea array se usa esto para evaluar la asignacion en la variable
                    iMax_temp = '31/12/2999'; // fecha de rango superior
                }
                $('#result1').val(iMin_temp);  //se usa para escribir las variables asignadas anteriormente en la vista
                $('#result2').val(iMax_temp);
                var arr_min = iMin_temp.split('/'); //aqui se vuelve aplicar el split para quitar el separador de la fecha y facilitar la busqueda
                var arr_max = iMax_temp.split('/');

                // aData  es la columna donde voy a establecer la busqueda por rango
                // 2 es la columna que estoy mostrando las fechas donde quiro buscar. La numeracion de la misma empieza en 0.
                var arr_date = aData[2].split('/'); //se toma el valor y se le quita el separador /
                var iMin = new Date(arr_min[2], arr_min[1] - 1, arr_min[0], 0, 0, 0, 0); //se usa date para cambiar a la fecha de timestamp
                var iMax = new Date(arr_max[2], arr_max[1] - 1, arr_max[0], 0, 0, 0, 0);
                var iDate = new Date(arr_date[2], arr_date[1] - 1, arr_date[0], 0, 0, 0, 0);
                //al aplicar el split las variables se convierten en array string por lo cual la numeracion es el orden en que aparecen las fechas
                //no se porque razon en los meses me mostraba el siguiente al que estaba, por eso le reste uno en la posicion 1 para que me diera el valor real
                if (iMin === "" && iMax === "")// se establecen las comparaciones para mostrar resultados
                {
                    return true; //todos los retornos van al input fecha que con la funcion draw escribe los valores finales de la busqueda en la tabla
                }
                else if (iMin === "" && iDate < iMax)
                {
                    return true;
                }
                else if (iMin <= iDate && "" === iMax)
                {
                    return true;
                }
                else if (iMin <= iDate && iDate <= iMax)
                {
                    return true;
                }
                return false;
            } else // en caso de no coincidir con el id de la tabla devuelve a su configuracion inicial
                return true;
        }
);

//fin del uso del dataTable en mnt_solicitudes



