      </div>
</div>
<!-- Footer starts -->
      <footer>
         <div class="container">
            <div class="text-center">
               Derechos reservados &copyFACYT - <a id="DevTeam" style="cursor: pointer;" >UST FACYT Dep: Desarrollo</a>
               <br><span class="negritas">versión 2.0.0</span>
            </div>
            <!--Formato para versiones: http://semver.org/  
            cambios sobre el estandar de versionamiento:
                  versión X.Y.Z
                        X: años desde que se empezó el proyecto
                        Y: adición de funcionalidades nuevas al sistema durante ese año (en caso de solo cambios en la BD, incrementar en funcion de cantidades de alteraciones)
                        Z: mes en el que se libera la versión a producción
                        -->
         </div>
      </footer>
      <!-- Footer ends -->
      
      <!-- Scroll to top -->
      <span class="totop"><a href="#"><i class="fa fa-chevron-up"></i></a></span> 
      
      <!-- Javascript files -->
      <!-- Para alijerar la carga de estilos y bibliotecas en el sistema by Luigiepa87-->
      <?php if(isset($script)&&!empty($script)):

            echo $script;?>
        
      <?php else:?>
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
      <!-- Bootstrap select js -->
      <script src="<?php echo base_url() ?>assets/js/bootstrap-select.min.js"></script>
      <!-- jQuery UI -->
      <script src="<?php echo base_url() ?>assets/js/jquery-ui.js"></script>
      <!-- sweet Alert -->
      <script src="<?php echo base_url() ?>assets/js/sweet-alert.js" type="text/javascript"></script>
      <!-- jQuery Peity -->
      <script src="<?php echo base_url() ?>assets/js/peity.js"></script>  
      <!-- Calendar -->
      <script src="<?php echo base_url() ?>assets/js/fullcalendar.min.js"></script>
      <!--File input-->
      <script src="<?php echo base_url() ?>assets/js/fileinput.min.js" type="text/javascript"></script>
      <script src="<?php echo base_url() ?>assets/js/fileinput_locale_es.js" type="text/javascript"></script>
      <!-- DataTables -->
      <script src="<?php echo base_url() ?>assets/js/jquery.dataTables.min.js"></script>
      <script src="<?php echo base_url() ?>assets/js/dataTables.responsive.js"></script>
      <script src="<?php echo base_url() ?>assets/js/dataTables.buttons.min.js"></script>
      <script src="<?php echo base_url() ?>assets/js/dataTables.select.min.js"></script>
      <script src="<?php echo base_url() ?>assets/js/dataTables_altEditor.js"></script>
      <!--<script src="<?php echo base_url() ?>assets/js/dataTables.rowGrouping.js"></script>-->
      <!--<script src="<?php echo base_url() ?>assets/js/jquery.dataTables.js"></script>-->
      
      <!-- Bootstrap DataTables -->
      <script src="<?php echo base_url() ?>assets/js/dataTables.bootstrap.js"></script>
      <script src="<?php echo base_url() ?>assets/js/responsive.bootstrap.js"></script>
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

      <?php endif;?>
      <script type="text/javascript">
      $(function(){
            $('#DevTeam').on('click', function(){
                  // var panel = $("<div/>");
                  // panel.attr("class","panel panel-info");
                  
                  // var panelHead = $("<div/>");
                  // panelHead.attr("class", "panel panel-heading");
                  
                  var Title = $("<h1/>");
                  Title.attr("class","panel-title text-center");
                  Title.html("Desarrollado por:");
                  head = $("<div/>");
                  head.append(Title);
                  // panelHead.append(panelTitle);
                  // panel.append(panelHead);

                  var body = $("<div/>");
                  body.append(head);
                  // var panelFoot = $("<div/>");
                  // panelBody.attr("class","panel-body");
                  
                  var rows = $("<div/>");
                  rows.attr("class","table-responsive");
                  
                  var teamTable = $("<table/>");
                  teamTable.attr('class', 'table table-condensed');
                  rows.append(teamTable);
                  // teamTable.attr('');
                  var row = $("<tr/>");
                  // row.attr('class', 'success');
                  row.attr('class', 'info');
                        var teamMember = $('<td/>');
                        teamMember.attr('class', 'col-lg-3 col-md-3 col-sm-3 col-xm-3');
                        teamMember.html('Idea y asesoría de Interfaz:');
                  row.append(teamMember);
                        var teamMember = $('<td/>');
                        teamMember.attr('class', 'col-lg-2 col-md-2 col-sm-2 col-xm-2');
                  row.append(teamMember);
                        var teamMember = $('<td/>');
                        teamMember.attr('class', 'col-lg-4 col-md-4 col-sm-4 col-xm-4');
                  row.append(teamMember);
                        // var teamMember = $('<td/>');
                  // row.append(teamMember);
                  teamTable.append(row);

                  var row = $("<tr/>");
                  // row.attr('class', 'info');
                        var teamMember = $('<td/>');
                  row.append(teamMember);
                        var teamMember = $('<td/>');
                        teamMember.html('Marylin Giugni');
                  row.append(teamMember);
                        var teamMember = $('<td/>');
                        teamMember.html('Email: marylin.giugni@gmail.com');
                  row.append(teamMember);
                  teamTable.append(row);
                  
                  var row = $("<tr/>");
                  // row.attr('class', 'success');
                  row.attr('class', 'info');
                        var teamMember = $('<td/>');
                        teamMember.html('Mantenimiento del sistema:');
                  row.append(teamMember);
                        var teamMember = $('<td/>');
                  row.append(teamMember);
                        var teamMember = $('<td/>');
                  row.append(teamMember);
                        // var teamMember = $('<td/>');
                  // row.append(teamMember);
                  teamTable.append(row);

                  var row = $("<tr/>");
                  // row.attr('class', 'info');
                        var teamMember = $('<td/>');
                  row.append(teamMember);
                        var teamMember = $('<td/>');
                        teamMember.html('Palacios, Luis');
                  row.append(teamMember);
                        var teamMember = $('<td/>');
                        teamMember.html('Email: luigiepa87@gmail.com');
                  row.append(teamMember);
                  teamTable.append(row);

                  var row = $("<tr/>");
                  // row.attr('class', 'info');
                        var teamMember = $('<td/>');
                  row.append(teamMember);
                        var teamMember = $('<td/>');
                        teamMember.html('Parra, Juan');
                  row.append(teamMember);
                        var teamMember = $('<td/>');
                        teamMember.html('Email: juantec2002@gmail.com');
                  row.append(teamMember);
                  teamTable.append(row);


                  var row = $("<tr/>");
                  row.attr('class', 'info');
                  var teamMember = $('<td/>');
                  teamMember.html('Desarrollo de los modulos:');
                  row.append(teamMember);
                  var teamMember = $('<td/>');
                  row.append(teamMember);
                        var teamMember = $('<td/>');
                  row.append(teamMember);
                  // var teamMember = $('<td/>');
                  // row.append(teamMember);
                  teamTable.append(row);

                  var row = $("<tr/>");
                  row.attr('class', 'success');
                        var teamMember = $('<td/>');
                        teamMember.html('Módulo de "Almacén":');
                  row.append(teamMember);
                        var teamMember = $('<td/>');
                  row.append(teamMember);
                        var teamMember = $('<td/>');
                  row.append(teamMember);
                  teamTable.append(row);

                  var row = $("<tr/>");
                  // row.attr('class', 'info');
                        var teamMember = $('<td/>');
                  row.append(teamMember);
                        var teamMember = $('<td/>');
                        teamMember.html('Palacios, Luis');
                  row.append(teamMember);
                        var teamMember = $('<td/>');
                        teamMember.html('Email: luigiepa87@gmail.com');
                  row.append(teamMember);
                  teamTable.append(row);

                  var row = $("<tr/>");
                  row.attr('class', 'success');
                        var teamMember = $('<td/>');
                        teamMember.html('Módulo de "Mantenimiento":');
                  row.append(teamMember);
                        var teamMember = $('<td/>');
                  row.append(teamMember);
                        var teamMember = $('<td/>');
                  row.append(teamMember);
                  teamTable.append(row);

                  var row = $("<tr/>");
                  // row.attr('class', 'info');
                        var teamMember = $('<td/>');
                  row.append(teamMember);
                        var teamMember = $('<td/>');
                        teamMember.html('Moreno, Ilse Nataly');
                  row.append(teamMember);
                        var teamMember = $('<td/>');
                        teamMember.html('Email: inatalymoreno@gmail.com');
                  row.append(teamMember);
                  teamTable.append(row);

                  var row = $("<tr/>");
                  // row.attr('class', 'info');
                        var teamMember = $('<td/>');
                  row.append(teamMember);
                        var teamMember = $('<td/>');
                        teamMember.html('Parra, Juan');
                  row.append(teamMember);
                        var teamMember = $('<td/>');
                        teamMember.html('Email: juantec2002@gmail.com');
                  row.append(teamMember);
                  teamTable.append(row);

                  var row = $("<tr/>");
                  row.attr('class', 'success');
                        var teamMember = $('<td/>');
                        teamMember.html('Módulo de "Usuario", "Permisología" y "Dependencias":');
                  row.append(teamMember);
                        var teamMember = $('<td/>');
                  row.append(teamMember);
                        var teamMember = $('<td/>');
                  row.append(teamMember);
                  teamTable.append(row);

                  var row = $("<tr/>");
                  // row.attr('class', 'info');
                        var teamMember = $('<td/>');
                  row.append(teamMember);
                        var teamMember = $('<td/>');
                        teamMember.html('Palacios, Luis');
                  row.append(teamMember);
                        var teamMember = $('<td/>');
                        teamMember.html('Email: luigiepa87@gmail.com');
                  row.append(teamMember);
                  teamTable.append(row);

                  var row = $("<tr/>");
                  // row.attr('class', 'info');
                        var teamMember = $('<td/>');
                  row.append(teamMember);
                        var teamMember = $('<td/>');
                        teamMember.html('Parra, Juan');
                  row.append(teamMember);
                        var teamMember = $('<td/>');
                        teamMember.html('Email: juantec2002@gmail.com');
                  row.append(teamMember);
                  teamTable.append(row);



                  var margen = $("<div/>");
                  margen.attr("class","col-lg-4 col-md-4 col-sm-4 col-xm-4");
                  rows.append(margen);
                  body.append(rows);
                  // panel.append(panelBody);
                  
                  // var button = $('<button/>');
                  // button.attr('class', 'btn btn-xs btn-info pull-right');
                  // button.html('cerrar');
                  // panelFoot.attr("class", "panel panel-footer");
                  // panelFoot.append(button);
                  // panel.append(panelFoot);
                  buildModal('pdfCierre', 'UST/DTIC FACYT Dep: Desarrollo', body, '', 'lg', '500');
            });
      });
      </script>
	</body>	
</html>