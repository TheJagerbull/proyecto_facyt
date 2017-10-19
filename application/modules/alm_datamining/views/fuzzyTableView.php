<!--response table view-->
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
		<!-- Bootstrap selectpicker -->
		<link href="<?php echo base_url() ?>assets/css/bootstrap-select.css" rel="stylesheet">
		<!-- Bootstrap CSS -->
		<link href="<?php echo base_url() ?>assets/css/bootstrap.min.css" rel="stylesheet">
		<link href="<?php echo base_url() ?>assets/css/bootstrap-touchspin.css" rel="stylesheet">
		<link href="<?php echo base_url() ?>assets/css/dataTables.bootstrap.css" rel="stylesheet">
		<link href="<?php echo base_url() ?>assets/css/responsive.bootstrap.css" rel="stylesheet">
		<link href="<?php echo base_url() ?>assets/css/buttons.bootstrap.min.css" rel="stylesheet">
		<link href= "<?php echo base_url() ?>assets/css/select2-bootstrap.css" rel="stylesheet"/>
		<link href= "<?php echo base_url() ?>assets/css/bootstrap-vertical-tabs.css" rel="stylesheet"/>
		
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

		<div class="mainy">
		  <!-- Page title -->
		  <div class="page-title">
		    <h2 align="right"><i class="fa fa-inbox color"></i> Pruebas <small></small></h2>
		    <hr />
		  </div>
		   <!-- Page title -->
		    <div class="awidget full-width">
		      <div class="awidget-head">
		        <h2>Fuzzy C-means Table</h2>
		      </div>
		      <div class="awidget-body">
		<!-- tabla de columnas dinamicas -->
		        <!-- <div class="controls-row">
		          <div class="control-group">
		            <div class="input-group">
		                <span class="input-group-addon btn btn-info">
		                    <i class="fa fa-zoom"></i>
		                </span>
		                <input class="form-control input-sm" style="width: 20%" name="query" placeholder="el query" type="text">
		            </div>
		            <hr>
		          </div>
		        </div> -->
		        <div class="responsive-table">
					<table id="fuzzytable"  class="table table-hover table-bordered table-condensed">
						<thead>
							<tr><th></th></tr>
						</thead>
						<tbody>
						</tbody>
						<tfoot>
						</tfoot>
					</table>
				</div>
		<!-- fin de tabla de columnas dinamicas -->
		      </div>
		    </div>
		</div>
		<script>
		$(document).ready(function()
		{
			$('#fuzzytable').dataTable({
										"language": {
												"url": "<?php echo base_url() ?>assets/js/lenguaje_datatable/spanish.json"
										},
				"bProcessing": true,
							"bServerSide": true,
							"sServerMethod": "GET",
							"sAjaxSource": "<?php echo base_url() ?>alm_datamining/fcm",
							"iDisplayLength": 10,
							"aLengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
							"aaSorting": [[0, 'asc']],
							"aoColumns": [
					{ "bVisible": true, "bSearchable": true, "bSortable": true },
					{ "bVisible": true, "bSearchable": true, "bSortable": true },
					{ "bVisible": true, "bSearchable": true, "bSortable": true },
					{ "bVisible": false, "bSearchable": false, "bSortable": true },
					{ "bVisible": false, "bSearchable": false, "bSortable": true },
					{ "bVisible": false, "bSearchable": false, "bSortable": true },
					{ "bVisible": true, "bSearchable": true, "bSortable": false }//la columna extra
							]
			});
		});
		</script>

<!-- Footer starts -->
      <footer>
         <div class="container">
            <div class="text-center">
               Derechos reservados &copyLuigi - <a href="#">UST FACYT Dep: Desarrollo</a>
               <br><span class="negritas">versión 1.0.1</span>
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
      <!-- Bootstrap select js -->
      <script src="<?php echo base_url() ?>assets/js/bootstrap-select.min.js"></script>
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
      <script src="<?php echo base_url() ?>assets/js/dataTables.responsive.min.js"></script>
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
	</body>	
</html>