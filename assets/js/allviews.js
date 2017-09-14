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

/* ************************************** */

/* ************************************** */

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
    // $(".notify").click(function (e) {

    //     e.preventDefault();
    //     var unique_id = $.gritter.add({
    //         // (string | mandatory) the heading of the notification
    //         title: 'Howdy! User 2',
    //         // (string | mandatory) the text inside the notification
    //         text: 'Today you got some messages and new members. Please check it out!',
    //         // (string | optional) the image to display on the left
    //         image: './img/user.jpg',
    //         // (bool | optional) if you want it to fade out on its own or just sit there
    //         sticky: false,
    //         // (int | optional) the time you want it to be alive for before fading out
    //         time: '',
    //         // (string | optional) the class name you want to apply to that specific message
    //         class_name: 'gritter-custom'
    //     });

    //     // You can have it return a unique id, this can be used to manually remove it later using
    //     setTimeout(function () {
    //         $.gritter.remove(unique_id, {
    //             fade: true,
    //             speed: 'slow'
    //         });
    //     }, 6000);

    // });

    /* Sticky notification */
    // $(".notify-sticky").click(function (e) {

    //     e.preventDefault();
    //     var unique_id = $.gritter.add({
    //         // (string | mandatory) the heading of the notification
    //         title: 'Howdy! User 3',
    //         // (string | mandatory) the text inside the notification
    //         text: 'Today you got some messages and new members. Please check it out!',
    //         // (string | optional) the image to display on the left
    //         image: './img/user.jpg',
    //         // (bool | optional) if you want it to fade out on its own or just sit there
    //         sticky: false,
    //         // (int | optional) the time you want it to be alive for before fading out
    //         time: '',
    //         // (string | optional) the class name you want to apply to that specific message
    //         class_name: 'gritter-custom'
    //     });

    // });

    /* Without image notification */
    // $(".notify-without-image").click(function (e) {

    //     e.preventDefault();
    //     var unique_id = $.gritter.add({
    //         // (string | mandatory) the heading of the notification
    //         title: 'Howdy! User 4',
    //         // (string | mandatory) the text inside the notification
    //         text: 'Esto es una prueba de notificaciones!',
    //         // (bool | optional) if you want it to fade out on its own or just sit there
    //         sticky: false,
    //         // (int | optional) the time you want it to be alive for before fading out
    //         time: '',
    //         // (string | optional) the class name you want to apply to that specific message
    //         class_name: 'gritter-custom'
    //     });

    // });

    /* Remove notification */

    $(".notify-remove").click(function () {

        $.gritter.removeAll();
        return false;

    });
});

/* Notification ends */

///////por luigi: tiempo del servidor a uso horario -4:00
//#currentTime es el area del header donde se muestra la hora
$(document).ready(function () {
    $.ajax({//consulto el tiempo en el servidor
        url: base_url + "template/template/get_serverTime",//direccion de la funcion que captura el tiempo en servidor
        type: 'POST',
        success: function(data) {
            var serverTime = new Date($.parseJSON(data)+450);//asigno la captura a la varitable serverTime
            // console.log('server = '+serverTime.toUTCString());
            function startInterval(){//funcion de induccion para iniciar el hilo
                setInterval('updateTime();', 1000);//ejecucion de un hilo para la funcion de actualizar tiempo, cada 1 segundo o 1000 milesimas de segundos
            }
            window.updateTime = function(){//funcion de ejecucion de hilo para actualizar el tiempo
                var clock = $('#currentTime');//capturo el elemento de la interfaz en una variable
                var aux = serverTime.getTime();//asigno el valor de milesimas entero de segundos del tiempo del servidor
                aux+=1000;//le sumo 1 segundo
                serverTime.setTime(aux);//lo actualizo en tiempo de servidor
                var rightNow = serverTime;//lo asigno a una variable para convertirlo a tiempo humano
                var hourAux = rightNow.getUTCHours();
                if(rightNow.getUTCHours() < 4)
                {
                    hourAux +=20;
                }
                else
                {
                    hourAux -=4;
                }
                var hours = hourAux;
                hours = hours % 12;
                // var hourAux = ((rightNow.getUTCHours() < 4 ? rightNow.getUTCHours()+=12 : rightNow.getUTCHours())-4);
                // var hours = ((rightNow.getUTCHours() < 4 ? rightNow.getUTCHours()+=12 : rightNow.getUTCHours())-4) % 12;//convierto a horas de UTC, y le resto el tiempo correspondiente del uso horario de "La Asuncion GMT -4:00", mientras lo mantengo en un margen menor a 12
                var minutes = rightNow.getUTCMinutes();//variable auxiliar para los minutos
                var seconds = rightNow.getUTCSeconds();//variable auxiliar para los segundos
                var ampm = hourAux >= 12 ? 'pm' : 'am';//variable que determina si las 12 horas estan por arriba, o por abajo del medio dia
                hours = hours ? hours : 12;//determino si las horas marcan 00 y escribe 12, de lo contrario la hora correspondiente
                hours = hours < 10 ? '0'+hours : hours;
                minutes = minutes < 10 ? '0'+minutes : minutes;//relleno con un '0' a la izquierda si los minutos estan debajo de 10
                seconds = seconds <10 ? '0'+seconds : seconds;//relleno con un '0' a la izquierda si los segundos estan debajo de 10
                var humanTime = hours + ':' + minutes + ':' + seconds + ' ' + ampm;//crea la variable auxiliar del string de la hora actualizada en formato leible
                // console.log(humanTime);
                clock.html(humanTime);//escribo el string en la interfaz
            },
            startInterval();
        }
    });
});
///////por luigi: para actualizar la session de carrito en momentos de ser enviado durante la session
$(document).ready(function() {
        //setInterval('update();', (60000*3));
        var uri = location.pathname;
        // var codeigniterPath = uri.slice(uri.lastIndexOf('index.php/')+10);
        var codeigniterPath = uri.slice(uri.lastIndexOf('edu.ve/')+7);
        if(codeigniterPath != 'solicitud/generar')
        {
            setInterval(function() {
                $.ajax({ url: base_url + "template/template/update_cart_session",
                    type: 'POST',
                    data: 'uri='+codeigniterPath,
                    success: function(data){
                        var response = $.parseJSON(data);
                        // console.log(response.cart);
                        if(response.cart==='empty')
                        {
                            var head = $('#cartContent .dropdown-head');
                            var body = $('#cartContent .dropdown-body');
                            var foot = $('#cartContent .dropdown-foot');
                            head.html('<span class="dropdown-title"><a class="btn-block no-hover-effect" href="<?php echo base_url() ?>solicitud/generar">Agregar artículos <i class="fa fa-plus color fa-fw"></i></a></span>');
                            body.html('<div id="cart" class="alert alert-info well-xs" style="margin-bottom: 0px !important;"><i>Debe generar una solicitud, para mostrar articulos agregados</i></div>');
                            if(response.permit)
                            {
                                foot.html('<a href="<?php echo base_url() ?>solicitudes/usuario">Ver solicitudes</a>');
                            }
                        }
                    },
                });
            }, (60000));
        }
        
});
///////por luigi: para agregar articulos en cualquier momento, desde el header (incompleto)
$(document).ready(function() {
    $("#call-modal").click(function(){
        console.log("booh!");
        $("#multPurpModal").modal(
            backdrop=false
            );
        var mhead = $("#multPurpModal .modal-header");
        var mbody = $("#multPurpModal .modal-body");
        var mfoot = $("#multPurpModal .modal-footer");
        mhead.html('<h3>Agregar artículos <i class="fa fa-plus color fa-fw"></i></h3>');

        $("#multPurpModal").modal('show');
    });
});
//Funcion dinamica para construir modal a travez de parametros Por: Luigi Palacios; Mod. Juan Parra para mostrar el footer
function buildModal(id, title, content, footer, size, height)
{ 
  var Modal = $('<div class="modal modal-message modal-info fade" id="'+id+'" tabindex="-1" role="dialog"/>');
  if(typeof(size) === "undefined" || size === '')
  {
    var modalDialog= $('<div class="modal-dialog" role="document"/>');
  }
  else
  {
    var modalDialog= $('<div class="modal-dialog modal-'+size+'"/>');
  }
  // var modalDialog= $('<div class="modal-dialog modal-lg"/>');
  // var modalDialog= $('<div class="modal-dialog modal-sm"/>');
  Modal.append(modalDialog);
  var modalContent= $('<div class="modal-content" />');
  modalDialog.append(modalContent);
  var modalHeader= $('<div class="modal-header" />');
  var modalTitle= $('<h4 class="modal-title"/>');
  var closeButton=$('<button class="close" data-dismiss="modal" aria-hidden="true"/>');
  closeButton.html('&times;');
  /*<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>*/
  modalTitle.append(title);
  modalHeader.append(modalTitle);
  if(typeof(height) === "undefined" || height=== '')
  {
    var modalBody = $('<div class="modal-body"/>');
  }
  else
  {
    var modalBody = $('<div class="modal-body" style="height: '+height+'px"/>');
  }

  var modalFooter= $('<div class="modal-footer" />');
  modalContent.append(modalHeader);
  modalContent.append(modalBody);
  modalContent.append(modalFooter);
  modalBody.empty();
  modalBody.append(content);
  if(footer !== '')
  {
    modalFooter.append(footer);
  }
  Modal.modal('show');
  Modal.on('hidden.bs.modal', function(){
    Modal.remove();
  });
  // return(Modal);
}

function buildTable(id, columns, columnAttr, dbTable)
{
    var tablerep = $('<table/>');
    //se construye la tabla
    var tableHeader = $('<thead/>');
    tablerep.attr('id', id);
    tablerep.attr('class', "table table-hover table-striped table-bordered table-condensed");
    var tableHead =  $('<tr/>');
    var tableBody = $('<tbody/>');
    console.log(columns);
      var columnas = [];
      var nombres = [];
      for (var i = 0; i < columns.length; i++)//para construir el header de la tabla para DataTable
      {
        columnas[i] = columns[i].value;
        // nombres[i] = columns[i].name;
        tableHead.append('<th>'+columns[i].name+'</th>');
      }
      console.log("columnas: ");
      console.log(columnas);
      // buildDataTable(columnas);
      tableHeader.append(tableHead);
      tablerep.append(tableHeader);
      tablerep.append(tableBody);
      return(tablerep);
}

