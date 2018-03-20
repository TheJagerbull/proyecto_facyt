///////por luigi: mensajes de alerta para solicitudes aprobadas
$(document).ready(function () {

    /* Auto notification */
    setTimeout(function() {
        $.ajax({
                // url: base_url + "alm_solicitudes/alm_solicitudes/check_aprovedDepSol",
                url: base_url + "template/template/check_alerts",
                type: 'POST',
                success: function (data) {
                       // console.log(data);
                        var response = $.parseJSON(data);
                        //response es una variable traida del json en el controlador linea:19 del archivo: modules/template/controllers/template.php.
                        //se utiliza para que de acuerdo con el objeto que trae, llama a la alerta correspondiente para avisar sobre el asunto que requiera atencion.
                        //para desreferenciar y consultar los atributos del objeto que trae response, es a travez del nombre que recibio el "key" del arreglo en template.php
                        //y la casilla numerica; en caso de ser varias, se debe hacer un loop, que recorra la primera referencia, ejemplo: response[key del array][numero de 0 a n].AtributoDeLaTablaSql
                        //ejemplos para ejecucion.
//                        console.log('arreglo del response= '+response);
//                        console.log('objeto "key" del array= '+response['depSol']);
//                        comento la linea 943 porque causa conflicto con las notificaciones
//                        console.log('valor del atributo de la consulta de sql= '+ response['depSol'][0].nr_solicitud);
                        var temp_id = [];//una variable de tipo arreglo, para los gritters que se desvaneceran solos
                        for (val in response)
                        {   
                            switch(true)
                            {
                                case val==='depSol' && response[val]!=0:
                                    temp_id[temp_id.length] = $.gritter.add({
                                        // (string | mandatory) the heading of the notification
                                        title: 'Solicitudes de almacen',
                                        // (string | mandatory) the text inside the notification
                                        text: 'Disculpe, usted posee solicitudes aprobadas en su departamento',
                                        // (string | optional) the image to display on the left
                                        // image: base_url+'/assets/img/alm/Art_check.png',
                                        image: base_url+'/assets/img/alm/status/aprobar.png',
                                        // (bool | optional) if you want it to fade out on its own or just sit there
                                        sticky: true,
                                        // (int | optional) the time you want it to be alive for before fading out
                                        time: '',
                                        // (string | optional) the class name you want to apply to that specific message
                                        class_name: 'gritter-custom'
                                    });
                                break;
                                case val==='despSol' && response[val]!=0:
                                    var unique_id = $.gritter.add({
                                        // (string | mandatory) the heading of the notification
                                        title: 'Solicitudes de almacen',
                                        // (string | mandatory) the text inside the notification
                                        text: 'Disculpe, usted posee articulos de una solicidud despachada y/o retirada por: <span class=\"text-primary\">'+response[val][0].nombre+' '+response[val][0].apellido+'</span> en su departamento, verifique que hayan sido recibidos.',
                                        // (string | optional) the image to display on the left
                                        // image: base_url+'/assets/img/alm/Art_check.png',
                                        image: base_url+'/assets/img/alm/status/retirado.png',
                                        // (bool | optional) if you want it to fade out on its own or just sit there
                                        sticky: true,
                                        // (int | optional) the time you want it to be alive for before fading out
                                        time: '',
                                        // (string | optional) the class name you want to apply to that specific message
                                        class_name: 'gritter-custom',
                                        before_close: function(e){
                                            swal({
                                                title: "Recuerde",
                                                html: "Debe verificar que los articulos de la solicitud, se encuentren en su oficina, antes de marcar como <span class=\"text-primary\">completada</span> la solicitud.",
                                                type: "warning"
                                            });
                                            return false;
                                        }
                                    });
                                break;
                                case val==='calificar' && response[val]!=0:
                                    var unique_id = $.gritter.add({
                                        // (string | mandatory) the heading of the notification
                                        title: 'Calificación',
                                        // (string | mandatory) the text inside the notification
                                        text: 'Disculpe, debe calificar las solicitudes de mantenimiento cerradas.',
                                        // (string | optional) the image to display on the left
                                        // image: base_url+'/assets/img/alm/Art_check.png',
                                        image: base_url+'/assets/img/mnt/star1.png',
                                        // (bool | optional) if you want it to fade out on its own or just sit there
                                        sticky: true,
                                        // (int | optional) the time you want it to be alive for before fading out
                                        time: '',
                                        // (string | optional) the class name you want to apply to that specific message
                                        class_name: 'gritter-custom',

                                        before_close: function(e){
                                            swal({
                                                title: "Recuerde",
                                                text: "Debe calificar las solicitudes cerradas para que no vuelva a aparecer este mensaje.",
                                                type: "warning"
                                            });
                                            return false;
                                        }
                                    });
                                break;
                                default:

//                                console.log("nope");
                                break;
                            }
                        };

                        // You can have it return a unique id, this can be used to manually remove it later using
                        setTimeout(function () {//para cerrar las alertas provicionales
                            for (var i = temp_id.length - 1; i >= 0; i--)
                            {
                                $.gritter.remove(temp_id[i], {
                                fade: true,
                                speed: 'slow'
                                });
                            };
                        }, 10000);
                        
                    }
        });
    }, 1);

});