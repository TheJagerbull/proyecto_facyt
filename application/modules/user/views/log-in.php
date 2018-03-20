<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<base href="<?php echo base_url() ?>" />
		<!-- Title here -->
		<title>Login - SiSAI FACYT</title>
		<!-- Description, Keywords and Author -->
		<meta name="description" content="Your description">
		<meta name="keywords" content="Your,Keywords">
		<meta name="author" content="Jose Henriquez" >
		
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<link rel="icon" type="image/x-icon" href="<?php echo base_url() ?>assets/img/FACYT2.png" />
		
		<!-- Styles -->
		<!-- Bootstrap CSS -->
		<link href="assets/css/bootstrap.min.css" rel="stylesheet">
			<!-- Animate css -->
			<link href="assets/css/animate.min.css" rel="stylesheet">
			<!-- Gritter -->
			<link href="assets/css/jquery.gritter.css" rel="stylesheet">
			<!-- Calendar -->
			<link href="assets/css/fullcalendar.css" rel="stylesheet">
			<!-- Bootstrap toggable -->
			<link href="assets/css/bootstrap-switch.css" rel="stylesheet">
			<!-- Date and Time picker -->
			<link href="assets/css/bootstrap-datetimepicker.min.css" rel="stylesheet">
			<!-- Star rating -->
			<link href="assets/css/rateit.css" rel="stylesheet">
			<!-- Star rating -->
			<link href="assets/css/jquery.cleditor.css" rel="stylesheet">
			<!-- jQuery UI -->
			<link href="assets/css/jquery-ui.css" rel="stylesheet">
			<!-- prettyPhoto -->
			<link href="assets/css/prettyPhoto.css" rel="stylesheet">
		<!-- Font awesome CSS -->
		<link href="assets/css/font-awesome.min.css" rel="stylesheet">   
		<!-- Custom CSS -->
		<link href="assets/css/style.css" rel="stylesheet">
		
		<!-- Favicon -->
		<link rel="shortcut icon" href="form.html#">
	</head>
	
	<body>

			
			<!-- Logo & Navigation starts -->
			
			<div class="header">
				 <div class="container">
						<div class="row">
							 <div class="col-md-12">
									<!-- Logo -->
									<div class="logo text-center">
										 <!--<img src="[mfassetpath]/Logo FACYT.png" style="width: 77px; height: 60px; top: 5px;"></img>-->
										 <h1><a href="">Bienvenido a SiSAI FACYT</a></h1>
									</div>
							 </div>
						</div>
				 </div>
			</div>
			
			<!-- Logo & Navigation ends -->
		 
			
			
			<!-- Page content -->
			
			<div class="page-content">
				<div class="container">
					<div class="row">
						<div class="col-md-12">
							<div class="awidget login-reg">

								<div class="awidget-body">
									<!-- Page title -->
									<div class="page-title text-center">
										<h2>Iniciar Sesión</h2>
										<hr />
									</div>
									<!-- Page title -->
									<form class="form-horizontal" role="form" action="<?php echo base_url() ?>user/usuario/login" method="post">
										<div class="form-group">
											<div class="col-lg-12 text-center">
												<?php echo form_error('id'); ?>
												<?php echo form_error('password'); ?>
											</div>
											<label for="inputUser1" class="col-lg-2 control-label">Cédula</label>
											<div class="col-lg-10">
												<input type="text" class="form-control" name="id" placeholder="Cedula de identidad" >
											</div>
										</div>
										<div class="form-group">
											<label for="inputPassword1" class="col-lg-2 control-label">Contraseña</label>
											<div class="col-lg-10">
												<input type="password" class="form-control" name="password" placeholder="Contraseña">
											</div>
										</div>
										<hr />
										<div class="form-group">
											<div class="col-lg-12 text-center">
												<button type="submit" class="btn btn-info"><i class="fa fa-sign-in fa-fw"></i> Entrar</button>
											</div>
										</div>
									</form>
								</div>
							</div>
						</div>
					</div>
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
		<!-- jQuery -->
		<script src="assets/js/jquery.js"></script>
		<!-- Bootstrap JS -->
		<script src="assets/js/bootstrap.min.js"></script>  
			<!-- jQuery UI -->
			<script src="assets/js/jquery-ui-1.10.2.custom.min.js"></script>     
			<!-- jQuery Peity -->
			<script src="assets/js/peity.js"></script>  
			<!-- Calendar -->
			<script src="assets/js/fullcalendar.min.js"></script>  
			<!-- jQuery Star rating -->
			<script src="assets/js/jquery.rateit.min.js"></script>
			<!-- prettyPhoto -->
			<script src="assets/js/jquery.prettyPhoto.js"></script>  
			
			<!-- jQuery flot -->
			<!--[if lte IE 8]><script language="javascript" type="text/javascript" src="js/excanvas.min.js"></script><![endif]-->
			<script src="assets/js/jquery.flot.js"></script>     
			<script src="assets/js/jquery.flot.pie.js"></script>
			<script src="assets/js/jquery.flot.stack.js"></script>
			<script src="assets/js/jquery.flot.resize.js"></script>
			
			
			
			<!-- Gritter plugin -->
			<script src="assets/js/jquery.gritter.min.js"></script> 
			<!-- CLEditor -->
			<script src="assets/js/jquery.cleditor.min.js"></script> 
			<!-- Date and Time picker -->
			<script src="assets/js/bootstrap-datetimepicker.min.js"></script>  
			<!-- jQuery Toggable -->
			<script src="assets/js/bootstrap-switch.min.js"></script>
		<!-- Respond JS for IE8 -->
		<script src="assets/js/respond.min.js"></script>
		<!-- HTML5 Support for IE -->
		<script src="assets/js/html5shiv.js"></script>
		<!-- Custom JS -->
		<script src="assets/js/allviews.js"></script>
		<!--<script src="assets/js/custom.js"></script>-->
		<script type="text/javascript">
			var base_url = '<?php echo base_url(); ?>';
		$(function(){

			    var doc = $(this);
			    var bliss = $('h1');
			/////para captura de multiples teclas
			    var key = {};
			    doc.keydown(function(event){
			      key[event.which] = true;
			    });
			    doc.keyup(function(event){
			      delete key[event.which];
			    });
			/////Fin de para captura de multiples teclas
			    bliss.click(function(){
			      // console.log();
			      if(key[77] && key[81])//teclas "q" y "m"
			      {


			      	var Title = $("<h1/>");
	            Title.attr("class","panel-title text-center");
	            Title.html("Datos del administrador:");
	            head = $("<div/>");
	            head.append(Title);
			      	var body = $("<div/>");
							body.append(head);

			        console.log('abrir modal para instalar base de datos!');
			        buildModal('install', 'Instalación de la base de datos', body, '', 'lg', '500');
			        // console.log($('#home').attr('class'));
			        // $('#CatFile').toggle();
			      }
			    });


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
