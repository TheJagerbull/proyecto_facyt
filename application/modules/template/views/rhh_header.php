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
	<link rel="icon" type="image/x-icon" href="<?php echo base_url() ?>assets/img/FACYT4.png" />

	<!-- Styles -->
	<!-- Select2 CSS -->
	<link href= "<?php echo base_url() ?>assets/css/select2.css" rel="stylesheet"/>
	<!-- Bootstrap CSS -->
	<link href="<?php echo base_url() ?>assets/css/bootstrap.min.css" rel="stylesheet">
	<link href="<?php echo base_url() ?>assets/css/bootstrap-touchspin.css" rel="stylesheet">
	<link href="<?php echo base_url() ?>assets/css/dataTables.bootstrap.css" rel="stylesheet">
	<link href= "<?php echo base_url() ?>assets/css/select2-bootstrap.css" rel="stylesheet"/>

	<!-- Modal by jcparra css -->
	<link href="<?php echo base_url() ?>assets/css/modal.css" rel="stylesheet">
	<!-- Animate css -->
	<link href="<?php echo base_url() ?>assets/css/animate.min.css" rel="stylesheet">
	<!-- Sweet-alert css -->
	<link href="<?php echo base_url() ?>assets/css/sweet-alert.css" rel="stylesheet">
	<!-- Gritter -->
	<link href="<?php echo base_url() ?>assets/css/jquery.gritter.css" rel="stylesheet">
	<!-- Calendar -->
	<link href="<?php echo base_url() ?>assets/css/fullcalendar.css" rel="stylesheet">
	<!-- Bootstrap toggable -->
	<link href="<?php echo base_url() ?>assets/css/bootstrap-switch.css" rel="stylesheet">
	<!-- Date and Time picker -->
	<link href="<?php echo base_url() ?>assets/css/bootstrap-datetimepicker.min.css" rel="stylesheet">
	<!--      <link href="<?php //echo base_url() ?>assets/css/bootstrap-datepicker.css" rel="stylesheet">-->
	<link href="<?php echo base_url() ?>assets/css/daterangepicker-bs3.css" rel="stylesheet">
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
	<!-- FileInput -->
	<link href= "<?php echo base_url() ?>assets/css/fileinput.min.css" media="all" rel="stylesheet" type="text/css">
	<!-- prettify for bootstrapWizard -->
	<link href="<?php echo base_url() ?>assets/css/prettify.css" rel="stylesheet">
</head>

<body>
	<!-- Logo & Navigation starts -->
	<!-- tamano de la session-->
	<!--<?php //echo 'tamaño de session: '.((strlen(serialize($this->session->all_userdata()))) * 8 / 1000).' KB';// para verificar cuanto espacio hay ocupado en la session?>-->
	<!-- fin de tamano de la session-->
	<div class="header">
		<div class="container">
			<div class="row">
				<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
					<!-- Logo -->
					<div class="logo">
						<h1><a href="<?php echo base_url() ?>index.php/inicio"><img src="<?php echo base_url() ?>assets/img/FACYT_1.png" class="img-rounded" alt="bordes redondeados" width="45" height="45">  SiSAI FACYT</a></h1>
					</div>
				</div>
			</div>
		</div>
	</div>

<!-- Logo & Navigation ends -->