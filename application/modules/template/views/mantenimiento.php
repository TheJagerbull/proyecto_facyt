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
		<style type="text/css">
		.headerMNT{
		   height:75px;
		   /*background:#375A7F;*/
		   border-top:4px solid #444;
		   border-bottom:1px solid #444;
		   background-image: url("<?php echo base_url() ?>assets/img/offline/maintenance_flag2.png");
		   background-repeat: repeat-x;
		}
		footer{
		   background-image: url("<?php echo base_url() ?>assets/img/offline/maintenance_flag2.png");
		   background-repeat: repeat-x;
		   border-top:3px solid #ddd; 
		   box-shadow:inset 0px 0px 3px #111;
		   color:#ccc;
		   font-size:14px;
		   line-height:25px;
		   padding:10px 0px 10px 0px;

		    position: fixed;
		    bottom: 0;
		    width: 100%;
		    /* Set the fixed height of the footer here */
		    height: 70px;
		    background-color: #f5f5f5;
		}
		.caption {
				height: 60%;
		        width:100%;
		        bottom: .1rem;
		        position: absolute;
		        background:#000;
		        background: -webkit-linear-gradient(bottom, #000 40%, rgba(0, 0, 0, 0) 100%) repeat scroll 0 0 rgba(0, 0, 0, 0);
		        background: -moz-linear-gradient(bottom, #000 40%, rgba(0, 0, 0, 0) 100%) repeat scroll 0 0 rgba(0, 0, 0, 0);
		        background: -o-linear-gradient(bottom, #000 40%, rgba(0, 0, 0, 0) 100%) repeat scroll 0 0 rgba(0, 0, 0, 0);
		        background: linear-gradient(to top, #000 40%, rgba(0, 0, 0, 0) 100%) repeat scroll 0 0 rgba(0, 0, 0, 0);
		    }

		    .thumbnail {
		        border: 0 none;
		        box-shadow: none;
		        margin:0;
		        padding:0;
		    }

		    .caption h2 {
		        color: #fff;
		        -webkit-font-smoothing: antialiased;
		    }
		</style>
	</head>
	
	<body>

			
			<!-- Logo & Navigation starts -->
			
			<div class="headerMNT">
				 <div class="container">
						<div class="row">
							 <div class="col-md-12">
									<!-- Logo -->
									<div class="logo text-center">
										 <!--<img src="[mfassetpath]/Logo FACYT.png" style="width: 77px; height: 60px; top: 5px;"></img>-->
										 <!-- <h1 style="color:#fff">Bienvenido a SiSAI FACYT</h1> -->
									</div>
							 </div>
						</div>
				 </div>
			</div>
			
			<!-- Logo & Navigation ends -->
		 
			
			
			<!-- Page content -->
			
			<!-- <div class="page-content blocky error-page">
		        <div class="container">
					<div class="col-md-12 row"> -->
								<!-- Page title -->
						<!-- <div class="col-sm-12 thumbnail text-center">
							<img src="assets/img/offline/construction.jpeg" class="img-responsive" alt="">
							<div class="caption">
								<h2>Sistema en mantenimiento</h2>
								<h3 style="color: #FFFF00;">Disculpe, En estos momentos el sistema se encuentra en mantenimiento</h3>
								<br />
							</div>
						</div>
					</div>
				</div>
		    </div> -->
		 <div class="page-content blocky error-page">
		    <div class="container">
		             <div class="row">
		                <div class="col-md-12">
		                         	<br>
		                         	<br>
		                         	<br>
		                   <div class="awidget full-width">
		                      <div class="awidget-head">
		                      
		                      </div>
		                      <div class="awidget-body">
		                         <!-- Page title -->
		                         <div class="page-title text-center">
		                         	<h3><img src="<?php echo base_url() ?>assets/img/FACYT_1.png" class="img-rounded" alt="bordes redondeados" width="45" height="45">SiSAI</h3>
		                         	<br>
		                            <h2>Sistema <span class="color">en mantenimiento</span></h2>
		                            <hr />
		                         </div>
		                         <!-- Page title -->
		                         <div class="text-center">
		                         	<br>
		                            <p>Estimado usuario, Usted esta accediendo a la p&aacute;gina mientras se encuentra en mantenimiento.</p>
		                            <br />
		                         </div>
		                      </div>
		                      <div class="awidget-footer">
								<div class="copy text-center">
									Derechos reservados &copyFACYT - <a href="#">UST FACYT dep: Desarrollo</a>
								</div>
		                      </div>
		                   </div>
		                </div>
		             </div>
		    </div>
		 </div>

			<!-- Footer starts -->
			<footer>
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
		<!--<script src="assets/js/custom.js"></script>-->
	</body>	
</html>