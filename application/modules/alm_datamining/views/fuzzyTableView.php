<!DOCTYPE html>
<html>
<head>
<!--response table view-->
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
		<?php echo $header;?>
	</head>

	<body>
		<nav class="navbar navbar-default navbar-static-top header">
			<div class="container">
				<div class="navbar-header">
					<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
						<span class="sr-only">Toggle navigation</span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
					</button>
					<div class="logo">
						<h1><a class="navbar-brand" href="<?php echo base_url() ?>inicio"> SiSAI FACYT
							<img src="<?php echo base_url() ?>assets/img/FACYT_1.png" class="pull-left img-rounded" alt="bordes redondeados" style="margin-top: -13px !important; margin-right: 5px;" width="45" height="45"></a></h1>
					</div>
				</div>
				<div id="navbar" class="navbar-collapse collapse">
					<ul class="nav navbar-nav navbar-right">
						<?php //if($this->session->userdata('user')['sys_rol']=='autoridad'||$this->session->userdata('user')['sys_rol']=='asist_autoridad'):?>
						<?php //endif?>
							<li class="dropdown">
								<a id="currentTime" class="dropdown-toggle negritas" data-toggle="dropdown">0:00:00 am
								</a>
							</li>
						</li>
					</ul>
				</div>
			</div>
		</nav>
		<div class="page-content blocky">
			<div class="container">
				<div class="mainy">
					<!-- Page title -->
					<div class="page-title">
						<!-- <h2 align="right"><i class="fa fa-file color"></i> Articulos <small>de almacen</small></h2> -->
						<h2 align="right"><img src="<?php echo base_url() ?>assets/img/alm/main.png" class="img-rounded" alt="bordes redondeados" width="45" height="45"> Almacén <small>estatus de inventario</small></h2>
						<!-- <hr /> -->
					</div>
					<!-- Page title -->
					<div class="row">
						<div class="col-lg-12 col-nd-12 col-sm-12">
							<div class="full-width">
								<div class="panel" style="border-radius: 10px;">
							            <div class="panel-heading clearfix">
							                <h3>Operaciones sobre inventario de almacén</h3>
							                <h4>Memory usage: {memory_usage}</h4>
							            </div>
									<div class="panel-body clearfix">
										<div class="awidget-body">
											<div class="input-group btn-group">
												<button id="runServerProcess" class="btn btn-xs btn-success"> Run</button>
												<button id="runClientReads" class="btn btn-xs btn-success"> Read</button>												
											</div>
											<hr>
											<ul id="myTab" class="nav nav-tabs nav-justified">
												<li class="active"><a href="#home" data-toggle="tab">Pruebas</a></li>
												<li><a href="#Sample" data-toggle="tab">Muestra</a></li>
												<li><a href="#MatrixD" data-toggle="tab">Matriz de distancia</a></li>
												<li><a href="#MatrixM" data-toggle="tab">Matriz de pertenencia</a></li>
												<li><a href="#Centers" data-toggle="tab">Centroides</a></li>
												<li><a href="#Patterns" data-toggle="tab">Patrones</a></li>
												<li><a href="#rep" data-toggle="tab">Reportes</a></li>
												<li><a href="#Info" data-toggle="tab">Informe</a></li>
											</ul>
											<div class="space-5px"></div>
											<div id="myTabContent" class="tab-content">
												<div id="home" class="tab-pane fade in active">
													<div id="homeContent" class="awidget-body">
														<div class="controls-row">
															<!-- <div class="control-group"> -->
															<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
																<div class="input-group">
																		<span id="basic-addon1" class="input-group-addon">
																				<i class="fa fa-calendar"></i>
																		</span>
																		<input class="form-control input-sm" name="fecha" id="date" readonly placeholder=" Búsqueda por Fechas" type="search">
																</div>
															</div>
														</div>
														<br>
														<br>
														<br>
														<div id='testPrints' class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
														Pruebas.
														</div>

													</div>
												</div>
												<div id="Sample" class="tab-pane fade">
													<div id="SampleContent" class="awidget-body">
													Muestra.
													</div>
												</div>
												<div id="MatrixD" class="tab-pane fade">
													<div id="MatrixDContent" class="awidget-body">
													Matriz de distancia.
													</div>
												</div>
												<div id="MatrixM" class="tab-pane fade">
													<div id="MatrixMContent" class="awidget-body">
													Matriz de pertenencia.
													</div>
												</div>
												<div id="Centers" class="tab-pane fade">
													<div id="CentersContent" class="awidget-body">
													Centroides.
													</div>
							                    </div>
												<div id="Patterns" class="tab-pane fade">
													<div id="PatternsContent" class="awidget-body">
													Patrones.
													</div>
												</div>
												<div id="rep" class="tab-pane fade">
													<div id="repContent" class="awidget-body">
													Reportes.
													</div>
												</div>
												<div id="Info" class="tab-pane fade">
													<div id="InfoContent" class="awidget-body">
													Informe.
													</div>
																						
												</div>

							            	</div>

							        	</div>
							 		</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		
      <!-- Footer ends -->
      
      <!-- Scroll to top -->
      <span class="totop"><a href="#"><i class="fa fa-chevron-up"></i></a></span> 
      
      <!-- Javascript files -->
	</body>	
<!-- Footer starts -->
      <footer>
         <div class="container">
            <div class="text-center">
               Derechos reservados &copyLuigi's Thesis - <a href="#">UST FACYT Dep: Desarrollo</a>
               <br><span class="negritas">versión 1.0.1</span>
            </div>
            <!--Formato para versiones: http://semver.org/  -->
         </div>
     <script type="text/javascript" >
	      	var base_url = '<? echo base_url(); ?>';
    </script>
    <?php echo $footer; ?>
    <script type="text/javascript" >
    $(document).ready(function()
    {
    	// $("#loading").hide();
    	// $("#loading").show();
    	var sample;
    	var centers;
    	var clusters;
    	var audioBad = new Audio('<?php echo base_url() ?>assets/sounds/bad.wav');
    	var audioBegin = new Audio('<?php echo base_url() ?>assets/sounds/begin.wav');
    	var audioDone = new Audio('<?php echo base_url() ?>assets/sounds/done.mp3');
    	var audioFinish = new Audio('<?php echo base_url() ?>assets/sounds/finish.wav');
    	var limits=0;
      	// $('#date span').html(moment().subtract(29, 'days').format('MMMM D, YYYY') + ' - ' + moment().format('MMMM D, YYYY'));
      	$('#date').daterangepicker({
				format: 'DD/MM/YYYY',
				startDate: moment(),
				endDate: moment(),
				// minDate: '12/31/2014',
				// maxDate: '12/31/2021',
				dateLimit: {months: 12},
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
				opens: 'right',
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
				var from = parseFloat(start._d.getTime()/1000).toFixed(0);
				var to = parseFloat(end._d.getTime()/1000).toFixed(0);
				console.log((from), (to), {'from': from, 'to': to});
				limits = ({'from': from, 'to': to});
				// $('#date span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
		});
		// setTimeout(function(){
			
		// }, 2000);
      	$("#runServerProcess").on('click', function(){
			
			swal({
				title:'Procesando...',
				text:'Esperando por respuesta del servidor',
				imageUrl: "<?php echo base_url() ?>assets/img/Loaders/gears.svg",
				showCancelButton: false,
				showConfirmButton: false,
				allowOutsideClick: false
			});

      		audioBegin.play();
	      	$.ajax({
			// 	// url: "<?php echo base_url() ?>uploads/engine/fuzzyPatterns/engine",
				url: "<?php echo base_url() ?>alm_datamining/fcm",
			// 	// type: 'POST',
				dataType: "json",
				// data: {"cod_segmento":this.value},
				success: function (data)
				{
					audioFinish.play();
					setTimeout(function(){audioDone.play();}, 3000);
					// audioDone.play();
					// console.log(data);
					swal.closeModal();
				},
				error: function (msg)
				{
					swal.closeModal();
					audioBad.play();
					console.log(msg);
				}
			});
      	});
      	$("#runClientReads").on('click', function(){

      		swal({
      			title:'Procesando...',
      			text:'Lectura de resultados del servidor',
      			imageUrl: "<?php echo base_url() ?>assets/img/ajax-loader.gif",
      			showCancelButton: false,
      			showConfirmButton: false,
      			allowOutsideClick: false
      		});
      		// var fs = require('fs');
      		// var files = fs.readdirSync('<?php echo base_url() ?>uploads/engine/fuzzyPatterns/json_files/');
      		$.get('<?php echo base_url() ?>uploads/engine/fuzzyPatterns/json_files', (data)=>
      		{
      			let listing = parseDirectoryListing(data);
      			// console.log(JSON.stringify(listing));
      			var files = JSON.stringify(listing);
      			if(listing[0] !== 'http')
      			{
      				console.log(listing[0]);
	      			audioBegin.play();

	      			// buildModal('log', 'json files dir', log, '', 'lg', '');
	      			// console.log(listing);
	      			read_files();
      			}
      			else
      			{
      				audioBad.play();
      				console.log('dir EMPTYYY!!!!');
					swal.closeModal();
      			}
      		});
      		function parseDirectoryListing(text) 
  		    {
  		        let docs = text
  		                     .match(/href="([\w]+)/g) // pull out the hrefs
  		                     .map((x) => x.replace('href="', '')); // clean up
  		        console.log(docs);
  		        return docs;
  		    }
  		    function read_files()
  		    {
    	//       	$.ajax({//used for testings
    	//       		url: "<?php echo base_url() ?>uploads/engine/fuzzyPatterns/json_files/centroides",
    	//       		cache: false,
    	//       		type:'POST',
    	//       		dataType:"json",
    	// 			// data: limits,
    	//       		success: function(data)
    	//       		{
    	//       			centers = data.centroides;
	  		//     		// console.log(data.centroides);i simply trust that everything will be okay, and "when my time comes, it will be, because it is my time to go", i try to make the best of things (even when i get mad at a situation or at someone), and trust that god has a plan, and me being alive or dead is part of it
					// 	var table = buildObjectArrayTable(data.centroides, false, true);
					// 	table.attr('class', 'table table-hover table-bordered dataTable');
					// 	$('#CentersContent').html('');
					// 	var log = $('<div>');//'<div class="error-log"><ul>';
					//     log.attr('class', 'error-log');
					//     var ul = $('<ul>');
					// 	var li = $('<li>');
					// 	li.append(table);
					//     ul.append(li);
	    //   				log.append(ul);
					// 	$('#CentersContent').append(log);
	    //   				audioFinish.play();
					// },
					// complete: function()
					// {
		   //  	      	$.ajax({//used for testings
		   //  	      		url: "<?php echo base_url() ?>uploads/engine/fuzzyPatterns/json_files/distanceMatrix",
		   //  	      		cache: false,
		   //  	      		type:'POST',
		   //  	      		dataType:"json",
		   //  				// data: limits,
		   //  	      		success: function(data)
		   //  	      		{
			  // 		    		// console.log(data.centroides);
					// 			var table = buildObjectArrayTable(data.distanceMatrix, true);
					// 			table.attr('class', 'table table-hover table-bordered dataTable');
					// 			$('#MatrixDContent').html('');
					// 			var log = $('<div>');//'<div class="error-log"><ul>';
					// 		    log.attr('class', 'error-log');
					// 		    var ul = $('<ul>');
					// 			var li = $('<li>');
					// 			li.append(table);
					// 		    ul.append(li);
			  //     				log.append(ul);
					// 			$('#MatrixDContent').append(log);
			  //     				audioFinish.play();
					// 		},
					// 		complete: function()
					// 		{
				 //    	      	$.ajax({//used for testings
				 //    	      		url: "<?php echo base_url() ?>uploads/engine/fuzzyPatterns/json_files/membershipMatrix",
				 //    	      		cache: false,
				 //    	      		type:'POST',
				 //    	      		dataType:"json",
				 //    				// data: limits,
				 //    	      		success: function(data)
				 //    	      		{
					//   		    		// console.log(data.centroides);
					// 					var table = buildObjectArrayTable(data.membershipMatrix, true);
					// 					table.attr('class', 'table table-hover table-bordered dataTable');
					// 					$('#MatrixMContent').html('');
					// 					var log = $('<div>');//'<div class="error-log"><ul>';
					// 				    log.attr('class', 'error-log');
					// 				    var ul = $('<ul>');
					// 					var li = $('<li>');
					// 					li.append(table);
					// 				    ul.append(li);
					//       				log.append(ul);
					// 					$('#MatrixMContent').append(log);
					//       				audioFinish.play();
					// 				},
					// 				complete: function()
					// 				{
					// 	    	      	$.ajax({//used for testings
					// 	    	      		url: "<?php echo base_url() ?>uploads/engine/fuzzyPatterns/vars/sample",
					// 	    	      		cache: false,
					// 	    	      		type:'POST',
					// 	    	      		dataType:"json",
					// 	    				// data: limits,
					// 	    	      		success: function(data)
					// 	    	      		{
					// 		  		    		// console.log(data.centroides);
					// 		  		    		sample = data.sample;
					// 							var table = buildObjectArrayTable(data.sample, false);
					// 							table.attr('class', 'table table-hover table-bordered dataTable');
					// 							$('#SampleContent').html('');
					// 							var log = $('<div>');//'<div class="error-log"><ul>';
					// 						    log.attr('class', 'error-log');
					// 						    var ul = $('<ul>');
					// 							var li = $('<li>');
					// 							li.append(table);
					// 						    ul.append(li);
					// 		      				log.append(ul);
					// 							$('#SampleContent').append(log);
					// 		      				audioFinish.play();
					// 						},
					// 						complete: function()
					// 						{

					// 			    	      	$.ajax({//used for testings
					// 			    	      		url: "<?php echo base_url() ?>uploads/engine/fuzzyPatterns/json_files/msg",
					// 			    	      		cache: false,
					// 			    	      		type:'POST',
					// 			    	      		dataType:"json",
					// 			    				// data: limits,
					// 			    	      		success: function(data)
					// 			    	      		{
					// 			    	      			$('#testPrints').html('');
					// 			    	      			print(data.msg, 'testPrints');
					// 				      				audioFinish.play();
					// 								},
					// 								complete: function()
													// {
										    	      	$.ajax({//used for testings
										    	      		url: "<?php echo base_url() ?>uploads/engine/fuzzyPatterns/json_files/pattern1",
										    	      		cache: false,
										    	      		type:'POST',
										    	      		dataType:"json",
										    				// data: limits,
										    	      		success: function(data)
										    	      		{
																$('#PatternsContent').html('');
																$('#PatternsContent').append("<h2>Muestras pertenecen a centroide a X%</h2>");
																var table = buildObjectArrayTable(data.pattern1, false, true);
																var log = $('<div>');//'<div class="error-log"><ul>';
															    log.attr('class', 'error-log');
															    var ul = $('<ul>');
																var li = $('<li>');
																li.append(table);
															    ul.append(li);
											      				log.append(ul);
																$('#PatternsContent').append(log);
											      				audioFinish.play();
															},
															complete: function()
															{
												    	      	$.ajax({//used for testings
												    	      		url: "<?php echo base_url() ?>uploads/engine/fuzzyPatterns/json_files/pattern2",
												    	      		cache: false,
												    	      		type:'POST',
												    	      		dataType:"json",
												    				// data: limits,
												    	      		success: function(data)
												    	      		{
												    	      			clusters = data.pattern2;
												    	      			$('#PatternsContent').append("<h2>Centroides cerca a las muestras (coordenadas del centroide)</h2>");
																		var table = buildObjectArrayTable(data.pattern2, false, true);
																		var log = $('<div>');//'<div class="error-log"><ul>';
																	    log.attr('class', 'error-log');
																	    var ul = $('<ul>');
																		var li = $('<li>');
																		li.append(table);
																	    ul.append(li);
													      				log.append(ul);
																		$('#PatternsContent').append(log);
													      				audioFinish.play();
																	},
																	complete: function()
																	{
    	      															console.log("done reading...");
    	      															// evaluate();
																		swal.closeModal();
																	}
												    	      	});
															}
										    	      	});
													// }
					// 			    	      	});
					// 						}
					// 	    	      	});
					// 				}
				 //    	      	});
					// 		}
		   //  	      	});
					// }
    	//       	});
  		    }
  		    function evaluate()
  		    {
  		    	console.log('evaluating...');
				minVal(centers, sample);
				console.log('...done evaluating!');
  		    }
      	});
      	/*$.ajax({
			// url: "<?php echo base_url() ?>uploads/engine/fuzzyPatterns/engine",
			url: "<?php echo base_url() ?>uploads/engine/fuzzyPatterns/results",
			// type: 'POST',
			dataType: "json",
			// data: {"cod_segmento":this.value},
			success: function (data)
			{
				// audio.play();
				$('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
					var target = $(e.target).attr("href"); // activated tab
					console.log(target);
					$('html, body').animate({
						scrollTop: $('div.panel-body').offset().top
					}, 1500, "swing");
				});
				
				var message = data.msg;
				// console.log(data);
				var table = buildObjectArrayTable(data.centroides, false, true);
				$('#CentersContent').html('');
					var log = $('<div>');//'<div class="error-log"><ul>';
				    log.attr('class', 'error-log');
				    var ul = $('<ul>');
					var li = $('<li>');
					li.append(table);
				    ul.append(li);
      				log.append(ul);
				$('#CentersContent').append(log);
				var table2 = buildObjectArrayTable(data.membershipMatrix, true);
				$('#MatrixMContent').html('');
					var log = $('<div>');//'<div class="error-log"><ul>';
				    log.attr('class', 'error-log');
				    var ul = $('<ul>');
					var li = $('<li>');
					li.append(table2);
				    ul.append(li);
      				log.append(ul);
				$('#MatrixMContent').append(log);
				var table3 = buildObjectArrayTable(data.distanceMatrix, true);
				$('#MatrixDContent').html('');
					var log = $('<div>');//'<div class="error-log"><ul>';
				    log.attr('class', 'error-log');
				    var ul = $('<ul>');
					var li = $('<li>');
					li.append(table3);
				    ul.append(li);
      				log.append(ul);
				$('#MatrixDContent').append(log);
				console.log(data.sample, data.pattern1, data.pattern2);//a partir de esta linea, hay un error
				// var table4 = buildObjectArrayTable(data.sample, true, true);
				$('#SampleContent').html('');
					// var log = $('<div>');
				    // log.attr('class', 'error-log');
				    // var ul = $('<ul>');
					// var li = $('<li>');
					// li.append(table4);
				    // ul.append(li);
      				// log.append(ul);
				// $('#SampleContent').append(log);
				$('#PatternsContent').html('');
				$('#PatternsContent').append("<h2>Muestras pertenecen a centroide a X%</h2>");
				console.log(data.pattern1, data.pattern2);
				var table5 = buildObjectArrayTable(data.pattern1, false, true);
				var log = $('<div>');
			    log.attr('class', 'error-log');
			    var ul = $('<ul>');
				var li = $('<li>');
				li.append(table5);
			    ul.append(li);
  				log.append(ul);
				// $('#PatternsContent').append(table5);
				$('#PatternsContent').append(log);
				$('#PatternsContent').append("<h2>Centroides cerca a las muestras (coordenadas del centroide)</h2>");
				minVal(data.centroides);
				var table6 = buildObjectArrayTable(data.pattern2, false, true);
				var log = $('<div>');
			    log.attr('class', 'error-log');
			    var ul = $('<ul>');
				var li = $('<li>');
				li.append(table6);
			    ul.append(li);
  				log.append(ul);
				// $('#PatternsContent').append(table6);
				$('#PatternsContent').append(log);
				table.attr('class', 'table table-hover table-bordered dataTable');
				table2.attr('class', 'table table-hover table-bordered dataTable');
				table3.attr('class', 'table table-hover table-bordered dataTable');
				table4.attr('class', 'table table-hover table-bordered dataTable');
				//'testPrints'
				print(message, 'repContent');
				$('.panel-heading').append('<h4>Memory usage: {memory_usage}</h4>');

			},
			error: function(a, stat, error)
			{
				console.log(a);
				console.log(stat);
				console.log(error);
				$('.panel-heading').append('<h4>Memory usage: {memory_usage}</h4>');
				// body...
			}
      	});
		*/
   //    	$.ajax({//used for testings
   //    		url: "<?php echo base_url() ?>alm_datamining/test",
   //    		type:'POST',
   //    		dataType:"json",
			// data: limits,
   //    		success: function(data)
   //    		{
   //    			console.log(limits);
   //    			print(data.msg.objects, 'testPrints');
   //    			print(data.msg.centroids, 'testPrints', false);
   //    			// audio.play();
   //    	// 		$('.panel-heading').append('<h4>Memory usage: {memory_usage}</h4>');
   //    		}
   //    	});
      	function print(message, where, rewrite=true)
      	{
      		var log = $('<div>');//'<div class="error-log"><ul>';
      		log.attr('class', 'error-log');
      		var ul = $('<ul>');
      		if(typeof message ==='object')
      		{
      			if(message.length>0)
      			{
      				// var log = '<div class="error-log"><ul>';
      				for (var i = 0; i < message.length; i++)
      				{
      					var li = $('<li>');
      					li.html('<h4>'+i+'</h4>');
      					li.append(objectTable(message[i]));
      					ul.append(li);
      					// // console.log(data.response[i]);
      					// // var aux = data.response[i];
      					// log += '<li>';
      					// // log += '<span class="label label-danger">linea: '+aux.linea+'</span> ';
      					// // log += '<span class="label label-success">codigo: '+aux.codigo+'</span> ';
      					// log += msglines[i];
      					// log +='</li>';
      				}

      				log.append(ul);
      				var title = "DATA SIZE:  <span class='badge badge-info'>"+message.length+"</span>";
      				// buildModal('log', title, log, '', 'lg', '');
      				//id, title, content, footer, size, height
      			}
      		}
      		if(typeof message ==='string')
      		{
      			var msglines = message.split('<br>');
      			if(typeof msglines === 'array')
      			{
      				for (var i = 0; i < msglines.length; i++)
      				{
      					var li = $('<li>');
      					li.html(msglines[i]);
      					ul.append(li);
      				}
      			}
      			else
      			{
      				if(message.length>0)
      				{
      					var li = $('<li>');
      					li.html(message);
      					ul.append(li);
      				}
      				var title = "INFO:  <span class='badge badge-info'>Message:</span>";
      			}
      			log.append(ul);
      		}
      		if(rewrite)
      		{
      			$('#'+where).html('');
      		}
      		else
      		{
      			$('#'+where).append('<br><br>');
      		}
      		$('#'+where).append(title);
      		$('#'+where).append(log);
      	}
      	function minVal(centroids, sample)
      	{
      		//No...don’t say your goodbyes, Rose. Don’t you give up. Don’t do it.
      		// You’re going to get out of this...you’re going to go on and you’re going to make babies and watch them grow and you’re going to die an old lady, warm in your bed. Not here...Not this night. Do you understand me?
      		// Rose, listen to me. Winning that ticket was the best thing that ever happened to me. It brought me to you. And I’m thankful, Rose. I’m thankful. You must do me this honor...promise me you will survive....that you will never give up...not matter what happens...no matter how hopeless...promise me now, and never let go of that promise.
      		var centroidkeys = Object.keys(centroids[0]);
      		var lowest = {};
      		var highest = {};
      		var tmp = {};

			console.log('here lowestAttr begins...');
			// lowestAttr('demanda', centroids);
			var lowAux = lowestAttr('demanda', centroids);
			var lowestCluster = clusters[lowAux];
			console.log('lowestCluster', lowestCluster);
			var lowscope = [];
			var aux;
			for(var key in lowestCluster)///quede por aquí
			{
				if(typeof key === "number")
				{
					aux = (lowestCluster[key]).replace( /[%]/, '');
					if(aux >= 50)
					{
						console.log('key:', key);
						console.log('value:', lowestCluster[key]);
						lowscope[key] = lowestCluster[key];
					}
				}
			}
			console.log(lowscope);
			var lowSamp = Object.keys(clusters[lowAux]);
			console.log(lowSamp);
			for (var i = lowSamp.length - 2; i >= 0; i--)
			{
				aux = sample[lowSamp[i]];
				// console.log(i, aux);
			}
			console.log('here lowestAttr ends...');
  			console.log('here highestAttr begins...');
  			// highestAttr('demanda', centroids);
  			var highAux = highestAttr('demanda', centroids);
  			var highSamp = Object.keys(clusters[highAux]);
  			console.log(highSamp);
  			for (var i = highSamp.length - 2; i >= 0; i--)
  			{
  				aux = sample[highSamp[i]];
  				console.log(aux);
  			}
  			console.log('here highestAttr ends...');

      	}
      	function lowestAttr(attr, object)
      	{
      		// console.log(attr);
      		// console.log(object);
      		var lowest = Number.POSITIVE_INFINITY;
      		var centroid = -1;
			for (var i = object.length - 1; i >= 0; i--)
			{
				// console.log(object[i][attr]);
				if(object[i][attr] < lowest)
				{
					lowest = object[i][attr];
					centroid = i;
				}
			}
			return(centroid);
      	}

      	function highestAttr(attr, object)
      	{
      		// console.log(attr);
      		// console.log(object);
      		var highest = Number.NEGATIVE_INFINITY;
      		var centroid = -1;
			for (var i = object.length - 1; i >= 0; i--)
			{
				// console.log(object[i][attr]);
				if(object[i][attr] > highest)
				{
					highest = object[i][attr];
					centroid = i;
				}
			}
			return(centroid);
      	}
		// $('#reset').click(function()
		// {
		// 	$('html, body').animate({
		// 		scrollTop: $('.header').offset().top
		// 	}, 1500, "swing");
		// });
    });
    </script>
    </footer>
</html>