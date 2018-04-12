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
							            <div class="panel-heading">
							                <h3>Operaciones sobre inventario de almacén</h3>
							                <h4>Memory usage: {memory_usage}</h4>
							            </div>
									<div class="panel-body">
										<div class="awidget-body">
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

      	$.ajax({
			url: "<?php echo base_url() ?>alm_datamining/fcm",
			type: 'POST',
			dataType: "json",
			// data: {"cod_segmento":this.value},
			success: function (data)
			{
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
				$('#CentersContent').append(table);
				var table2 = buildObjectArrayTable(data.membershipMatrix, true);
				$('#MatrixMContent').html('');
				$('#MatrixMContent').append(table2);
				var table3 = buildObjectArrayTable(data.distanceMatrix, true);
				$('#MatrixDContent').html('');
				$('#MatrixDContent').append(table3);
				var table4 = buildObjectArrayTable(data.sample, true, true);
				$('#SampleContent').html('');
				$('#SampleContent').append(table4);
				$('#PatternsContent').html('');
				$('#PatternsContent').append("<h2>Muestras pertenecen a centroide a X%</h2>");
				var table5 = buildObjectArrayTable(data.pattern1, false, true);
				$('#PatternsContent').append(table5);
				$('#PatternsContent').append("<h2>Centroides cerca a las muestras (coordenadas del centroide)</h2>");
				var table6 = buildObjectArrayTable(data.pattern2, false, true);
				$('#PatternsContent').append(table6);
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

      	$.ajax({//doesnt work, so, this will not be used
      		url: "<?php echo base_url() ?>alm_datamining/test",
      		type:'POST',
      		dataType:"json",
			data: limits,
      		success: function(data)
      		{
      			console.log(limits);
      			print(data.msg, 'testPrints');
      	// 		$('.panel-heading').append('<h4>Memory usage: {memory_usage}</h4>');
      		}
      	});
      	function print(message, where)
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
      				var title = "INFO:  <span class='badge badge-info'>"+message.length+"</span>";
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
      		$('#'+where).html('');
      		$('#'+where).append(title);
      		$('#'+where).append(log);
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