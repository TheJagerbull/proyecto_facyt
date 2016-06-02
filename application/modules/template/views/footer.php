      </div>
</div>
<!-- Footer starts -->
      <footer>
         <div class="container">
            <div class="copy text-center">
               Derechos reservados &copyFACYT - <a href="">UST FACYT dep: Desarrollo</a></br>
               version 1.0.1
            </div>
            <!--Formato para versiones: http://semver.org/  -->
         </div>
      </footer>
      <!-- Footer ends -->
      
      <!-- Scroll to top -->
      <span class="totop"><a href="#"><i class="fa fa-chevron-up"></i></a></span> 
      
      <!-- Javascript files -->
      <!-- jQuery -->
      <!--<script src="<?php echo base_url() ?>assets/js/jquery-1.11.2.js"></script>-->
      <script src="<?php echo base_url() ?>assets/js/jquery-1.11.3.js"></script>
      <!-- jQuery min? -->
      <script src="<?php echo base_url() ?>assets/js/jquery-1.11.1.min.js"></script>
      <!-- Bootstrap JS -->
      <script src="<?php echo base_url() ?>assets/js/bootstrap.min.js"></script>
      <!-- Bootstrap touchspin JS -->
      <script src="<?php echo base_url() ?>assets/js/bootstrap-number-input.js"></script>
      <script src="<?php echo base_url() ?>assets/js/bootstrap-touchspin.js"></script>
      <!-- BootstrapWizard-->
      <script src="<?php echo base_url() ?>assets/js/jquery.bootstrap.wizard.js"></script>
      <script src="<?php echo base_url() ?>assets/js/prettify.js"></script>
      <!-- Select2 JS -->
      <script src="<?php echo base_url() ?>assets/js/select2.js"></script>
      <!-- jQuery UI -->
      <script src="<?php echo base_url() ?>assets/js/jquery-ui.js"></script>
      <!-- jQuery Peity -->
      <script src="<?php echo base_url() ?>assets/js/peity.js"></script>  
      <!-- Calendar -->
      <script src="<?php echo base_url() ?>assets/js/fullcalendar.min.js"></script>
      <!--File input-->
      <script src="<?php echo base_url() ?>assets/js/fileinput.min.js" type="text/javascript"></script>
      <script src="<?php echo base_url() ?>assets/js/fileinput_locale_es.js" type="text/javascript"></script>
      <!-- sweet Alert -->
      <script src="<?php echo base_url() ?>assets/js/sweet-alert.js" type="text/javascript"></script>
      <!-- DataTables -->
      <script src="<?php echo base_url() ?>assets/js/jquery.dataTables.min.js"></script>
      <!--<script src="<?php echo base_url() ?>assets/js/dataTables.responsive.js"></script>-->
      <script src="<?php echo base_url() ?>assets/js/dataTables.buttons.min.js"></script>
      <!--<script src="<?php echo base_url() ?>assets/js/dataTables.rowGrouping.js"></script>-->
      <!--<script src="<?php echo base_url() ?>assets/js/jquery.dataTables.js"></script>-->
      
      <!-- Bootstrap DataTables -->
      <script src="<?php echo base_url() ?>assets/js/dataTables.bootstrap.js"></script>
      <!--<script src="<?php echo base_url() ?>assets/js/responsive.bootstrap.js"></script>-->
      <script src="<?php echo base_url() ?>assets/js/buttons.bootstrap.min.js"></script>
      <script src="<?php echo base_url() ?>assets/js/buttons.html5.min.js"></script>
      <!--<script src="<?php echo base_url() ?>assets/js/pdfmake.min.js"></script>-->
      <script src="<?php echo base_url() ?>assets/js/vfs_fonts.js"></script>
      <script src="<?php echo base_url() ?>assets/js/buttons.print.min.js"></script>
      <!-- jQuery Star rating -->
      <script src="<?php echo base_url() ?>assets/js/jquery.rateit.min.js"></script>
      <!-- prettyPhoto -->
      <script src="<?php echo base_url() ?>assets/js/jquery.prettyPhoto.js"></script>
      <!-- jQuery flot -->
      <!--[if lte IE 8]><script language="javascript" type="text/javascript" src="js/excanvas.min.js"></script><![endif]-->
      <script src="<?php echo base_url() ?>assets/js/jquery.flot.js"></script>     
      <script src="<?php echo base_url() ?>assets/js/jquery.flot.pie.js"></script>
      <script src="<?php echo base_url() ?>assets/js/jquery.flot.stack.js"></script>
      <script src="<?php echo base_url() ?>assets/js/jquery.flot.resize.js"></script>
      <!-- Gritter plugin -->
      <script src="<?php echo base_url() ?>assets/js/jquery.gritter.min.js"></script> 
      <!-- CLEditor -->
      <script src="<?php echo base_url() ?>assets/js/jquery.cleditor.min.js"></script> 
      <!-- Date and Time picker -->
      <script src="<?php echo base_url() ?>assets/js/bootstrap-datetimepicker.min.js"></script>  
      <!--      <script src="<?php //echo base_url() ?>assets/js/bootstrap-datepicker.js"></script> -->
      <script src="<?php echo base_url() ?>assets/js/moment.js"></script>
      <script src="<?php echo base_url() ?>assets/js/daterangepicker.js"></script>
      <!-- jQuery Toggable -->
      <script src="<?php echo base_url() ?>assets/js/bootstrap-switch.min.js"></script>
      <!-- Respond JS for IE8 -->
      <script src="<?php echo base_url() ?>assets/js/respond.min.js"></script>
      <!-- HTML5 Support for IE -->
      <script src="<?php echo base_url() ?>assets/js/html5shiv.js"></script>
      <!-- Custom JS -->
      <script src="<?php echo base_url() ?>assets/js/custom.js"></script>
      <script src="<?php echo base_url() ?>assets/js/mainFunctions.js"></script>
      <?php if($this->uri->uri_string()=='inicio'):?>
      <script type="text/javascript">
            ///////por luigi: mensajes de alerta para solicitudes aprobadas
            $(document).ready(function () {

                /* Auto notification */
                setTimeout(function() {
                    $.ajax({
                            // url: base_url + "index.php/alm_solicitudes/alm_solicitudes/check_aprovedDepSol",
                            url: base_url + "index.php/template/template/check_alerts",
                            type: 'POST',
                            success: function (data) {
            //                        console.log(data);
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
                                                temp_id[1] = $.gritter.add({
                                                    // (string | mandatory) the heading of the notification
                                                    title: 'Solicitudes',
                                                    // (string | mandatory) the text inside the notification
                                                    text: 'Disculpe, usted posee solicitudes aprobadas en su departamento',
                                                    // (string | optional) the image to display on the left
                                                    // image: base_url+'/assets/img/alm/Art_check.png',
                                                    image: base_url+'/assets/img/alm/item_list_c_verde.png',
                                                    // (bool | optional) if you want it to fade out on its own or just sit there
                                                    sticky: true,
                                                    // (int | optional) the time you want it to be alive for before fading out
                                                    time: '',
                                                    // (string | optional) the class name you want to apply to that specific message
                                                    class_name: 'gritter-custom'
                                                });
                                            break;
            //                                case val==='sol' && response[val]!=0:
            //                                    var unique_id = $.gritter.add({
            //                                        // (string | mandatory) the heading of the notification
            //                                        title: 'Solicitudes',
            //                                        // (string | mandatory) the text inside the notification
            //                                        text: 'Disculpe, su solicitud ya ha sido aprobada',
            //                                        // (string | optional) the image to display on the left
            //                                        // image: base_url+'/assets/img/alm/Art_check.png',
            //                                        image: base_url+'/assets/img/alm/item_list_c_verde.png',
            //                                        // (bool | optional) if you want it to fade out on its own or just sit there
            //                                        sticky: true,
            //                                        // (int | optional) the time you want it to be alive for before fading out
            //                                        time: '',
            //                                        // (string | optional) the class name you want to apply to that specific message
            //                                        class_name: 'gritter-custom',
            //
            //                                        before_close: function(e){
            //                                            swal({
            //                                                title: "Recuerde",
            //                                                text: "Debe retirar los articulos en almacen para que no vuelva a aparecer este mensaje",
            //                                                type: "warning"
            //                                            });
            //                                            return false;
            //                                        }
            //                                    });
                                                // You can have it return a unique id, this can be used to manually remove it later using
                                                // setTimeout(function () {
                                                //     $.gritter.remove(unique_id, {
                                                //     fade: true,
                                                //     speed: 'slow'
                                                //     });
                                                // }, 10000);
            //                                break;
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
      </script>
      <?php endif; ?>
	</body>	
</html>