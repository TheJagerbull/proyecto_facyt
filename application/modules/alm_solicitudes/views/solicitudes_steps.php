<!-- http://vadimg.com/twitter-bootstrap-wizard-example/ -->
<div class="mainy">
              <!-- Page title -->
               <div class="page-title">
                  <h2 align="right"><i class="fa fa-tags color"></i> Generar solicitud <small>siga los pasos</small></h2>
                  <hr />
               </div>
              <!-- End Page title -->
    <!-- <div > -->
		<div id="rootwizard" class="awidget full-width">
			<div class="navbar">
				<div class="navbar-inner awidget-header">
					<div class="container">
						<ul><!-- buscar en el archivo bootstrap.min.css ".nav-pills>li.active>a:focus{color:#fff;background-color:#337ab7}" y cambiar #337ab7 por #777 o viceversa-->
							<li><a href="#paso1" data-toggle="tab">1er Paso</a></li>
							<li><a href="#paso2" data-toggle="tab">2do Paso</a></li>
							<li><a href="#paso3" data-toggle="tab">3er Paso</a></li>
							<li><a href="#paso4" data-toggle="tab">4to Paso</a></li>
						</ul>
					</div>
					<ul class="pager wizard">
						<!-- <li class="previous first" style="display:none;"><a href="#">1er Paso</a></li> -->
						<li class="previous"><a class="clickable" ><i class="glyphicon glyphicon-chevron-left"></i></a></li>
						<!-- <li class="next last" style="display:none;"><a href="#">Ultimo paso</a></li> -->
						<li class="next"><a class="clickable" ><i class="glyphicon glyphicon-chevron-right"></i></a></li>
					</ul>
				</div>
			</div>
			<div class="tab-content">
				<div class="tab-pane" id="paso1">
	<!-- Paso 1-->
					<div id="error_paso1">
					</div>
					<div class="awidget-body">
						<table id="act-inv" class="table table-hover table-bordered col-lg-8 col-md-8 col-sm-8">
							<thead>
								<tr>
									<th>Item</th>
									<th>Codigo</th>
									<th>Descripcion</th>
									<th>Agregar/Remover</th>
								</tr>
							</thead>
							<tbody></tbody>
							<tfoot></tfoot>
						</table>
					</div>
				</div>
				<div class="tab-pane" id="paso2">
	<!-- Paso 2-->
					<!-- <div class="awidget full-width"> -->
						<!-- <div id="error_paso2" class="awidget-header"> -->
						<div id="error_paso2">
							<!-- <div hidden id="agrega_error" class="alert alert-danger" style="text-align: center">
							</div> -->
							<div hidden id="agrega_msg" style="text-align: center">
							</div>
						</div>
						<!-- <form id="add_inv" class="form-horizontal"> -->
						<form id="agrega" class="form-horizontal">
						</form>
						<div  id="lista_paso2" class="awidget-body">
								<table id="selec-items" class="table table-hover table-bordered col-lg-8 col-md-8 col-sm-8">
									<thead>
										<tr>
											<th>Item</th>
											<th>Codigo</th>
											<th>Unidad</th>
											<th>Descripcion</th>
											<th>Cantidad</th>
											<th>Quitar</th>
										</tr>
									</thead>
									<tbody></tbody>
									<tfoot></tfoot>
								</table>
						</div>
						<div class="awidget-footer">
							<div class="col-lg-10 col-md-10 col-sm-10 col-xs-10"></div>
							<p style="text-align: -moz-right; padding-right: 2%;"><button id="agregaSubmit" form="agrega" type="submit" class="btn btn-primary">Generar</button></p>
						</div>
					<!-- </div> -->
				</div>
				<div class="tab-pane" id="paso3">
	<!-- Paso 3-->
					<div id="error_paso3">
					</div>
					<div class="awidget-body">
					</div>
					
				</div>
				<div class="tab-pane" id="paso4">
					<div class="awidget-body">
					</div>
				</div>
			</div>
		</div>
	<!-- </div> -->
	<div class="clearfix"></div>         
</div>
<script src="<?php echo base_url() ?>assets/js/jquery-1.11.3.js"></script>
<!-- <script src="<?php echo base_url() ?>assets/js/jquery.cookie.js"></script>-->
<script type="text/javascript">
	base_url = '<?php echo base_url()?>';
    $(document).ready(function () {
		var selected =  new Array();
		var list;
		aux = <?php echo json_encode($this->session->userdata('articulos')); ?>;
		// console.log(aux);
		if(aux)
		{
			selected = aux;
		}
		for (var i = selected.length - 1; i >= 0; i--)
		{
			selected[i] = "row_"+selected[i];//para mantener una relacion entre las filas de la tabla de articulos activos, y los articulos en la variable selected
		};
		// console.log(selected);
	  	$('#rootwizard').bootstrapWizard({
	  		onTabShow: function(tab, navigation, index) {
	  			// console.log(index);
				for (var i = navigation.find('li').length-1; i > index; i--)
				{
					$('#rootwizard').bootstrapWizard('disable', i);
				}

				$('#rootwizard li.disabled a[data-toggle]').removeAttr('data-toggle');//retiro los enlaces del bootstrapwizard
				if(selected.length)
		        {
		        	$('#rootwizard li a[href="#paso2"]').attr('data-toggle', 'tab');//agrego los enlaces del bootstrapwizard
		        	$('#rootwizard').bootstrapWizard('enable', 1);//y los habilito
		        }
		        if(index==0)
	  			{
	  				console.log("I'am at step1");
	  			}
		        if(index==1)
	  			{
			        console.log("I'am at step2");
	  			}
			},
	  		onTabChange: function(tab, navigation, index){
	  			if(index===0)
	  			{
	  				console.log("change from 1 to x");
	  			}
	  			if(index===1)
	  			{
	  				console.log("change from 2 to x");
	  			}
	  		}
		});
//para el PASO 1
		var actTable = $('#act-inv').DataTable({
			"language": {
			  "url": "<?php echo base_url() ?>assets/js/lenguaje_datatable/spanish.json"
			},
			"pagingType": "numbers",
			"bProcessing": true,
			"bServerSide": true,
			"sServerMethod": "GET",
			"sAjaxSource": base_url+"index.php/alm_articulos/getInventoryTable/1",
			"rowCallback": function( row, data) {
	            if ( $.inArray(data.DT_RowId, selected) !== -1 ) {//si los articulos estan en el arreglo, cambio sus propiedades para que puedan ser retirados
		            $('i', row).attr("class", 'fa fa-minus');
		            $('i', row).attr("style", 'color:#D9534F');
					oTable.ajax.reload();
	            }
	        },
			"iDisplayLength": 10,
			"aLengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
			"aaSorting": [[0, 'asc']],
			"aoColumns": [
			  { "bVisible": true, "bSearchable": true, "bSortable": true },
			  { "bVisible": true, "bSearchable": true, "bSortable": true },
			  { "bVisible": true, "bSearchable": true, "bSortable": true },
			  { "bVisible": true, "bSearchable": true, "bSortable": false }//la columna extra
			      ]
		});
//para el PASO 2
		var oTable = $('#selec-items').DataTable({
			"language": {
			  "url": "<?php echo base_url() ?>assets/js/lenguaje_datatable/spanish.json"
			},
			"type": "POST",
			"sAjaxSource": base_url+"index.php/alm_solicitudes/load_listStep2",
			"destroy": true,
			"sDom": '<"top"p>t',
			"autoWidth": false,
			"columns": [
				{"width": "10%", "data": "ID"},
				{"width": "10%", "data": "cod_articulo"},
				{"width": "10%", "data": "unidad"},
				{"width": "40%", "data": "descripcion"},
				{"width": "20%", "data": "agregar"},
				{"width": "10%", "data": "quitar"}
			]
		});
		// setInterval( function () {
		//     oTable.ajax.reload();
		// }, 3000 );
		$('#act-inv tbody').on( 'click', 'i', function () {//al seleccionar un item de la lista...
	        var id = this.id;
	        var articulos = <?php echo json_encode($this->session->userdata('articulos')) ?>;//precargo lo que tengo en session sobre los articulos seleccionados
	        // console.log(articulos);
	        // var cod = id.slice(4);
	        var index = $.inArray(id, selected);//si el articulo esta en el arreglo
	 		// console.log(index);
	        if( index === -1 )//si no esta en el arreglo...
	        {
	        	// console.log(cod);
	            selected.push( id );//lo apilo al arreglo y...
	            $(this).attr("class", 'fa fa-minus');//cambio las propiedades para que pueda ser retirado
	            $(this).attr("style", 'color:#D9534F');//cambio las propiedades para que pueda ser retirado
	        }
	        else//sino
	        {
	            selected.splice( index, 1 );//lo retiro del arreglo
	            $(this).attr("class", 'fa fa-plus color');//cambio las propiedades para que pueda ser agregado
	            $(this).removeAttr("style");//cambio las propiedades para que pueda ser agregado
	        }
	        if(!selected.length)//si el arreglo "selected" esta vacio, es para activar y desactivar los pasos y el boton 'next'
	        {
	        	$('#rootwizard').bootstrapWizard('disable', 1);
	        	$('#rootwizard li a[href="#paso2"]').removeAttr('data-toggle');
	        	$('#rootwizard li.next').attr('class', 'next disabled');
	        }
	        else//para activar y desactivar los pasos y el boton 'next'
	        {
	        	$('#rootwizard li a[href="#paso2"]').attr('data-toggle', 'tab');
	        	$('#rootwizard').bootstrapWizard('enable', 1);
	        	$('#rootwizard li.next').attr('class', 'next');
	        }
	        // console.log(selected);
	        var items =[];
			for (var i = selected.length - 1; i >= 0; i--)
			{
				var cod = selected[i].slice(4);
    			items.push( cod );

			};
///////////para actualizar en session
			//el siguiente post, es para actualizar la session con los articulos agregados, para posteriormente cargarlos en los pasos consecutivos.
	        $.post(base_url+"index.php/alm_solicitudes/solicitud_steps", { //se le envia la data por post al controlador respectivo
                update: items  //variable a enviar
			// }, function (data) { //aqui se evalua lo que retorna el post para procesarlo dependiendo de lo que se necesite
			// 	$("#error_paso1").html(data); //aqui regreso la respuesta de la funcion(uso como pruebas de evidencia que la session tiene los datos guardados)
		    });
		    if(selected.length>0)
		    {
		    	$("#cart_nr").html(selected.length);
		    	$("#cart_nr").attr("class", "label label-success");
		    }
		    else
		    {
		    	$("#cart_nr").html(0);
		    	$("#cart_nr").attr("class", "label label-default");
		    }
///////////para actualizar en session
			// oTable.ajax.reload();
			setTimeout(function(){
				oTable.ajax.reload();//aqui funciona
			}, 800);
			// oTable.ajax.reload();
			// oTable.fnReloadAjax();//dice TypeError: oTable.ajax is undefined
	    });
//para el PASO 3
		$('#selec-items tbody').on( 'click', 'i', function () {
			// console.log(this.id);//reviso el id del articulo en la lista
			// console.log(selected);//reviso los articulos seleccionados para la tabla de cantidades

			var index = $.inArray(this.id, selected);//tomo en variable, la posicion del id del articulo al cual le hago click
			// console.log(index);
			selected.splice( index, 1 );//lo retiro del arreglo
			// console.log(selected);
			var items =[];
			//actualizo el arreglo de articulos seleccionados
			for (var i = selected.length - 1; i >= 0; i--)
			{
				var cod = selected[i].slice(4);
				items.push( cod );
			};
			//la siguiente linea es para actualizar los articulos en sesion
			$.post(base_url+"index.php/alm_solicitudes/solicitud_steps", {
				update: items
			});
			//actualizo el header
			if(selected.length>0)
		    {
		    	$("#cart_nr").html(selected.length);
		    	$("#cart_nr").attr("class", "label label-success");
		    }
		    else
		    {
		    	$("#cart_nr").html(0);
		    	$("#cart_nr").attr("class", "label label-default");
		    }
			//actualizo la tabla
			setTimeout(function(){
				oTable.ajax.reload();//aqui funciona
			}, 800);
			//actualizo la tabla
			setTimeout(function(){
				actTable.ajax.reload();//aqui funciona
			}, 800);
			if(!selected.length)//si el arreglo "selected" esta vacio, es para activar y desactivar los pasos y el boton 'next'
	        {
	        	$('#rootwizard').bootstrapWizard('disable', 1);
	        	$('#rootwizard li a[href="#paso2"]').removeAttr('data-toggle');
	        	$('#rootwizard li.next').attr('class', 'next disabled');
	        	$('#rootwizard').bootstrapWizard('show',0);//envio al usuario al paso 1
	        }
		});

//////validacion sobre el formulario del paso 2
		$(function()
		{
			$("#agrega_msg").hide();
			$("#agrega").on("submit", function()
			{
				var step2Inputs = $('#selec-items tbody input[form="agrega"]');
				var InputsMsgs = $('#selec-items tbody span[id^="msg_"]');
				InputsMsgs.hide();
			    $("#agrega_msg").hide();
	    		// for (var i = 0; i < step2Inputs.length; i++)
	    		var error_flag= false;
	    		for (var i = step2Inputs.length - 1; i >= 0; i--)
	    		{
	    			var regex = /^[1-9]?[0-9]$/;
	    			console.log(step2Inputs[i].value);
	    			if(!regex.test(step2Inputs[i].value))
	    			{
	    				$('#msg_'+step2Inputs[i].id.slice(2)).html('Debe indicar una cantidad numerica');
	    				$('#msg_'+step2Inputs[i].id.slice(2)).show();
	    				error_flag = true;
	    			}
	    		}
	    		if(!error_flag)
	    		{
	    			console.log('dale gualla menol');
	    			var aux = step2Inputs.serializeArray();
	    			$.ajax(
                    {
                        type: "POST",
                        url: "alm_solicitudes/solicitud_steps",
                        data: aux,
                        success: function(response)
                        {
                            
                        },
                        error: function(jqXhr){
                            if(jqXhr.status == 400)
                            {
                                $("#agrega_msg").html(jqXhr.responseText);
                                $("#agrega_msg").show();
                                // var json = $.parseJSON(jqXhr.responseText);
                            }
                                console.log(jqXhr);
                        }
                    });
	    		}


				return(false);
			});
		});


//para el PASO 4

	});
</script>