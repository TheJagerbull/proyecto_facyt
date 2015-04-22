<!DOCTYPE html>
<html>
   <head>
      <meta charset="utf-8">
      <!-- Title here -->
    <!-- en el controlador, se debe llenar una variable que contenga ['title'], y asignarle el nombre que tomara la pagina que va a cargar
    por ejemplo, $header['title']= 'solicitudes';luego, cuando se valla a cargar la vista, se le manda la variable de la siguiente forma
    $this->load->view('includes/header',$header);-->
      <title><?php echo (isset($title) && !empty($title)) ? $title.' | SiSAI FACYT' : 'SiSAI FACYT' ?></title>
      <!-- Description, Keywords and Author -->
      <meta name="description" content="Your description">
      <meta name="keywords" content="Your,Keywords">
      <meta name="author" content="ResponsiveWebInc">
      
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      
      <!-- Styles -->
      <!-- Bootstrap CSS -->
      <link href="<?php echo base_url() ?>assets/css/bootstrap.min.css" rel="stylesheet">
      <!-- Animate css -->
      <link href="<?php echo base_url() ?>assets/css/animate.min.css" rel="stylesheet">
      <!-- Gritter -->
      <link href="<?php echo base_url() ?>assets/css/jquery.gritter.css" rel="stylesheet">
      <!-- Calendar -->
      <link href="<?php echo base_url() ?>assets/css/fullcalendar.css" rel="stylesheet">
      <!-- Bootstrap toggable -->
      <link href="<?php echo base_url() ?>assets/css/bootstrap-switch.css" rel="stylesheet">
      <!-- Date and Time picker -->
      <link href="<?php echo base_url() ?>assets/css/bootstrap-datetimepicker.min.css" rel="stylesheet">
      <!-- Star rating -->
      <link href="<?php echo base_url() ?>assets/css/rateit.css" rel="stylesheet">
      <!-- Star rating -->
      <link href="<?php echo base_url() ?>assets/css/jquery.cleditor.css" rel="stylesheet">
      <!-- jQuery UI -->
      <link href="<?php echo base_url() ?>assets/css/jquery-ui.css" rel="stylesheet">
      <!-- prettyPhoto -->
      <link href="<?php echo base_url() ?>assets/css/prettyPhoto.css" rel="stylesheet">
      <!-- Font awesome CSS -->
      <link href="<?php echo base_url() ?>assets/css/font-awesome.min.css" rel="stylesheet">    
      <!-- Custom CSS -->
      <link href="<?php echo base_url() ?>assets/css/style.css" rel="stylesheet">
      
      <!-- Favicon -->
      <link rel="shortcut icon" href="#">
   </head>
   
   <body>

      
      <!-- Logo & Navigation starts -->
      
      <div class="header">
         <div class="container">
            <div class="row">
               <div class="col-md-12">
                  <!-- Logo -->
                  <div class="logo text-center">
                     <h1><a href=""<?php echo base_url() ?>index.php/usuario/login"">SiSAI FACYT</a></h1>
                  </div>
               </div>
            </div>
         </div>
      </div>
      
      <!-- Logo & Navigation ends -->
     
      
      
      <!-- Page content -->
      
      <div class="page-content blocky error-page">
         <div class="container">

                  
               
                  <div class="row">
                     <div class="col-md-12">
                        <div class="awidget login-reg">
                           <div class="awidget-head">
                           
                           </div>
                           <div class="awidget-body">
                              <!-- Page title -->
                              <div class="page-title text-center">
                                 <h2>404<span class="color">!!!</span></h2>
                                 <hr />
                              </div>
                              <!-- Page title -->
                              <div class="text-center">
                                 <p>Disculpe, Usted esta accediendo a la pagina sin <a href="<?php echo base_url() ?>index.php/usuario/login" > Iniciar sesión </a> </p>
                                 <br />
                                 <a class="btn btn-info" href="<?php echo base_url() ?>index.php/user/usuario/login"> Iniciar </a>
                                 <br />
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
                  
            
            
         </div>
      </div>
     
      
      
      <!-- Footer starts -->
      <footer>
         <div class="container">
         
            <div class="copy text-center">
               Derechos reservados &FACYT; - <a href="">Desarrollo</a>
            </div>
            
         </div>
      </footer>
      <!-- Footer ends -->
      
      <!-- Scroll to top -->
      <span class="totop"><a href="404.html#"><i class="fa fa-chevron-up"></i></a></span> 
      
		<!-- Javascript files -->
		<!-- jQuery -->
		<script src="js/jquery.js"></script>
		<!-- Bootstrap JS -->
		<script src="js/bootstrap.min.js"></script>  
      <!-- jQuery UI -->
      <script src="js/jquery-ui-1.10.2.custom.min.js"></script>     
      <!-- jQuery Peity -->
      <script src="js/peity.js"></script>  
      <!-- Calendar -->
      <script src="js/fullcalendar.min.js"></script>  
      <!-- jQuery Star rating -->
      <script src="js/jquery.rateit.min.js"></script>
      <!-- prettyPhoto -->
      <script src="js/jquery.prettyPhoto.js"></script>  
      
      <!-- jQuery flot -->
      <!--[if lte IE 8]><script language="javascript" type="text/javascript" src="js/excanvas.min.js"></script><![endif]-->
      <script src="js/jquery.flot.js"></script>     
      <script src="js/jquery.flot.pie.js"></script>
      <script src="js/jquery.flot.stack.js"></script>
      <script src="js/jquery.flot.resize.js"></script>
      
      
      
      <!-- Gritter plugin -->
      <script src="js/jquery.gritter.min.js"></script> 
      <!-- CLEditor -->
      <script src="js/jquery.cleditor.min.js"></script> 
      <!-- Date and Time picker -->
      <script src="js/bootstrap-datetimepicker.min.js"></script>  
      <!-- jQuery Toggable -->
      <script src="js/bootstrap-switch.min.js"></script>
		<!-- Respond JS for IE8 -->
		<script src="js/respond.min.js"></script>
		<!-- HTML5 Support for IE -->
		<script src="js/html5shiv.js"></script>
		<!-- Custom JS -->
		<script src="js/custom.js"></script>
	</body>	
</html>