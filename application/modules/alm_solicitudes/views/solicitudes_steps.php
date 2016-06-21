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
							<!-- <li><a href="#paso4" data-toggle="tab">4to Paso</a></li> -->
						</ul>
					</div>
					<ul class="pager wizard">
						<!-- <li class="previous first" style="display:none;"><a href="#">1er Paso</a></li> -->
						<li class="previous"><a class="clickable" ><i class="glyphicon glyphicon-chevron-left"></i>Paso anterior</a></li>
						<!-- <li class="next last" style="display:none;"><a href="#">Ultimo paso</a></li> -->
						<li class="next"><a class="clickable" >Siguiente paso<i class="glyphicon glyphicon-chevron-right"></i></a></li>
					</ul>
				</div>
			</div>
			<div class="tab-content">
				<div class="tab-pane" id="paso1">
	<!-- Paso 1-->
					<div id="msg_paso1" hidden style="text-align: center">
					</div>
					<div class="awidget-body">
						<table id="act-inv" class="table table-hover table-bordered">
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
						<div hidden id="msg_paso2" hidden style="text-align: center">
						</div>
						<!-- <form id="add_inv" class="form-horizontal"> -->
						<form id="agrega" class="form-horizontal">
						</form>
						<div  id="lista_paso2" class="awidget-body">
								<table id="selec-items" class="table table-hover table-bordered">
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
							<div class="form-group" style="padding-inline-start: 10%;">
								<label  for="observacion" class="control-label">Observacion: 
								</label>
								<textarea class="form-control" form="agrega" id="observacion" name="step2[observacion]" style="width: inherit;">
								</textarea>
								<span hidden id="msg_observacion" class="label label-danger">
								</span>
							</div>
							<p style="text-align: -moz-right; padding-right: 2%; padding-bottom: 3%;"><button id="agregaSubmit" form="agrega" type="submit" class="btn btn-primary">Guardar</button></p>
						</div>
					<!-- </div> -->
				</div>
				<div class="tab-pane" id="paso3">
	<!-- Paso 3-->
					<div id="msg_paso3" hidden style="text-align: center">
					</div>
					<div class="awidget-body">
						<div class="alert alert-info" style="text-align: center">
						  Su solicitud debe ser enviada para poder ser aprobada por almacen.
						  <hr>
						  <div class="row" >
						    <?php if(empty($alm['14'])):?>
						    <div class="alert alert-danger" style="text-align: center">
						      Disculpe, actualmente usted no posee permisos para enviar la solicitud
						    </div>
						    <?php endif;?>
						    <form id="enviar" action="<?php echo base_url() ?>index.php/solicitud/enviar" method="post">
						    </form>
								<div class="col-lg-1 col-md-1 col-sm-1 col-xs-1">
								</div>
								<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
								</div>
					            <div class="col-lg-1 col-md-1 col-sm-1 col-xs-1">
					            </div>
						        <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3">
						            <button id="cancel" type="submit" class="btn btn-danger">Cancelar</button>
						        </div>
						      <!-- <form id="editar" action="<?php echo base_url() ?>index.php/solicitud/editar" method="post">
						      </form> -->
						        <!-- <form id="editar" action="<?php echo base_url() ?>index.php/solicitud/editar" method="post">
						          <input form="editar" type="hidden" name="id_dependencia" value="<?php echo $this->session->userdata('user')['id_dependencia']; ?>" />
						          <button form="editar" type="submit" class="btn btn-primary">Editar</button>
						        </form> -->
						  </div>
						</div>
					</div>
					
				</div>
				<!-- <div class="tab-pane" id="paso4">
					<div class="awidget-body">
					</div>
				</div> -->
			</div>
		</div>
	<!-- </div> -->
	<div class="clearfix"></div>         
</div>
<!--//var html='id="cartContent"';
// <div class="dropdown-head">
// <span class="dropdown-title">Artículos agregados</span>
// </div>
// <div class="dropdown-body">
// <li><i class="fa fa-chevron-right color"></i> <?php echo $articulo['descripcion']; ?><span class="label label-info pull-right"> <?php echo $articulo['cant']; ?></span></li>
// </div>
// <div class="dropdown-foot text-center">
//                                   <a href="<?php echo base_url() ?>index.php/solicitud/editar/<?php echo $this->session->userdata('id_carrito')?>">Ver solicitud</a>    
//                               </div>'; 
-->
<script src="<?php echo base_url() ?>assets/js/jquery-1.11.3.js"></script>
<!-- <script src="<?php echo base_url() ?>assets/js/jquery.cookie.js"></script>-->
<script type="text/javascript">
	base_url = '<?php echo base_url()?>';
    $(document).ready(function () {
    	//variables para ajustes del header, en tiempo real
	  	var head = $('#cartContent .dropdown-head');
	  	var body = $('#cartContent .dropdown-body');
	  	var foot = $('#cartContent .dropdown-foot');

		var selected =  new Array();
		var list;
		var flagstep2='';
		$("#msg_paso1").hide();
		$.post(base_url+"index.php/alm_solicitudes/solicitud_steps", {cart: 'foo'}, function(data)
		{
			cart = JSON.parse(data);
			console.log('cart: '+(typeof cart));
			if(typeof cart.id_carrito !== 'undefined')
			{
				console.log('tiene una solicitud en carrito');
				var carrito = cart.id_carrito;
				var articulos = cart.articulos;
				var string ='';
				for (var i = articulos.length - 1; i >= 0; i--) {
					string += '<li><i class="fa fa-chevron-right color"></i> '+articulos[i].descripcion+'<span class="label label-info pull-right"> '+articulos[i].cant+'</span></li>';
				}
				$("#cart_nr").html(articulos.length);
		    	$("#cart_nr").attr("class", "label label-success");
				head.html('<span class="dropdown-title">Artículos agregados</span>');
				body.html(string);
				foot.html('<div class="dropdown-foot text-center"><a href="'+base_url+'index.php/solicitud/editar/'+carrito+'">Ver solicitud</a></div>');
				// $("#msg_paso1").html('<div class="alert alert-info" style="text-align: center"> Usted todavia posee una solicitud sin enviar. <br> Si genera otra, la anterior ser&aacute; reemplazada.</div>');
    //             $("#msg_paso1").show();
			}
			else
			{
				console.log('puede hacer otra solicitud');
			}
		});
		aux = <?php echo json_encode($this->session->userdata('articulos')); ?>;
		console.log(typeof aux);
		console.log(aux);
		if(aux && typeof aux[0] ==='string')
		{
			console.log(typeof aux[0]);//string cuando viene del paso 1 - object cuando tiene cargado un carrito de la base de datos
			// selected = aux;
			for (var i = aux.length - 1; i >= 0; i--)
			{
				if(typeof aux[i].descripcion !== 'undefined' && typeof aux[i].cant !== 'undefined' && typeof aux[i].id_articulo !== 'undefined')
				{
					console.log('vas bien');
					selected[i]= "row_"+aux[i].id_articulo;
				}
				else
				{
					selected[i] = "row_"+aux[i];//para mantener una relacion entre las filas de la tabla de articulos activos, y los articulos en la variable selected
				}
			};
		}
	  	$('#rootwizard').bootstrapWizard({
	  		onTabShow: function(tab, navigation, index) {
	  			console.log(index);
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
					$("#msg_paso1").hide();
	  				console.log("I'am at step1");
	  			}
		        if(index==1)
	  			{
					$("#msg_observacion").hide();
			        console.log("I'am at step2");
	  			}
		        if(index==2)
	  			{
					$("#msg_observacion").hide();
			        console.log("I'am at step3");
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
	  			if(index===2)
	  			{
	  				console.log("change from 3 to x");
	  			}
	  		}
		});
		if(aux && typeof aux[0] === 'object')// para validar si ya se almaceno la solicitud en bd
		{
			console.log('wtf!!!');
			$('#msg_paso3').html('');
			$('#rootwizard li a[href="#paso3"]').attr('data-toggle', 'tab');
			$('#rootwizard').bootstrapWizard('disable', 0);
			// $('#rootwizard').bootstrapWizard('disable', 1);
        	$('#rootwizard').bootstrapWizard('enable', 1);
        	// $('#rootwizard li.next').attr('class', 'next');
        	$('#rootwizard').bootstrapWizard('show',1);
			$('#rootwizard li.previous').attr('class', 'previous disabled');
        	// $("#msg_paso3").html('<div class="alert alert-info" style="text-align: center"> Usted ya posee una solicitud sin enviar. <br> Si genera otra, la anterior ser&aacute; reemplazada.</div>');
         //    $("#msg_paso3").fadeIn(2000);
         //    	$("#msg_paso3").fadeOut(6000);
            setTimeout(function(){
		         swal({
		            title: "Recuerde",
		            text: "Usted ya posee una solicitud sin enviar.",
		            type: "info"
		        });
            }, 1500);
		}
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
				{"width": "50%", "data": "descripcion"},
				{"width": "10%", "data": "agregar"},
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
		    	body.html('<div id="cart" class="alert alert-warning"><i>Debe guardar la solicitud, para mostrar los articulos agregados</i></div>');
		    }
		    else
		    {
		    	$("#cart_nr").html(0);
		    	$("#cart_nr").attr("class", "label label-default");
		    	body.html('<div id="cart" class="alert alert-info"><i>Debe generar una solicitud, para mostrar articulos agregados</i></div>');
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
			$("#msg_paso2").hide();
			$("#agrega").on("submit", function()
			{
				var step2Inputs = $('#selec-items tbody input[form="agrega"]');
				var InputsMsgs = $('#selec-items tbody span[id^="msg_"]');
				InputsMsgs.hide();
			    $("#msg_paso2").hide();
	    		// for (var i = 0; i < step2Inputs.length; i++)
	    		var error_flag= false;
	    		for (var i = step2Inputs.length - 1; i >= 0; i--)//recorre cada input para verificar errores
	    		{
	    			var regex = /^[1-9]?[0-9]$/;//defino una expresion regular que indica que solo puede haber numeros enteros mayores a 0, y no puede
	    			console.log(step2Inputs[i].value);
	    			if(!regex.test(step2Inputs[i].value))
	    			{
	    				$('#msg_'+step2Inputs[i].id.slice(2)).html('Debe indicar una cantidad numerica');//y avisar respecto al error
	    				$('#msg_'+step2Inputs[i].id.slice(2)).show();
	    				error_flag = true;//la bandera de error cambia a verdadero, indicando que hay por lo menos 1 error
	    			}
	    		}
	    		if(!error_flag)//si no hay errores en los inputs del formulario...
	    		{
	    			var aux = $('#agrega').serializeArray();
	    			$.ajax(//se envia por ajax para ser procesado en el controlador y almacenado en la base de datos
                    {
                        type: "POST",
                        url: base_url+"index.php/alm_solicitudes/solicitud_steps",
                        data: aux,
                        success: function(response)
                        {
				        	swal({
					            title: "Solicitud guardada",
					            text: "Su solicitud fue guardada éxitosamente",
					            type: "success"
					        });
                        	$("#msg_paso3").html(response);
                            $("#msg_paso3").show();
                            console.log(response);
                            $('#rootwizard').bootstrapWizard('disable', 0);
                            $('#rootwizard').bootstrapWizard('disable', 1);
				        	$('#rootwizard li.previous').attr('class', 'previous disabled');
				        	$('#rootwizard li.next').attr('class', 'next');
	        				// setTimeout(function(){
	                            $('#rootwizard li a[href="#paso3"]').attr('data-toggle', 'tab');
					        	$('#rootwizard').bootstrapWizard('enable', 2);
					        	// $('#rootwizard li.next').attr('class', 'next');
					        	$('#rootwizard').bootstrapWizard('show',2);
	        				$('#rootwizard li a[href="#paso1"]').removeAttr('data-toggle');
	        				$('#rootwizard li a[href="#paso2"]').removeAttr('data-toggle');
				        		$('#rootwizard li.previous').attr('class', 'previous disabled');
	        				// }, 6000);
	        				$.post(base_url+"index.php/alm_solicitudes/solicitud_steps", {cart: 'foo'}, function(data){
	        					cart = JSON.parse(data);
	        					console.log(cart);
	        					var carrito = cart.id_carrito;
	        					var articulos = cart.articulos;
	        					head.html('<span class="dropdown-title">Artículos agregados</span>');
	        					var string ='';
	        					for (var i = articulos.length - 1; i >= 0; i--) {
	        						string += '<li><i class="fa fa-chevron-right color"></i> '+articulos[i].descripcion+'<span class="label label-info pull-right"> '+articulos[i].cant+'</span></li>';
	        					}
	        					body.html(string);
	        					foot.html('<div class="dropdown-foot text-center"><a href="'+base_url+'index.php/solicitud/editar/'+carrito+'">Ver solicitud</a></div>');
	        				});
                        },
                        error: function(jqXhr){
                            console.log(jqXhr.status);
                            if(jqXhr.status == 500)
                            {
                                $("#msg_paso2").html(jqXhr.responseText);
                                $("#msg_paso2").show();
                                // var json = $.parseJSON(jqXhr.responseText);
                            }
                        }
                    });
	    		}


				return(false);
			});
		});


//PASO 3
	/////Para cancelar la solicitud y volver a empezar
		$("#cancel").click(function(){
			console.log('cancelado');
			$.post(base_url+"index.php/alm_solicitudes/solicitud_steps", {cancel:'blah'}, function(data){
				console.log(data);
				if(data==='success')
				{
		        	$('#rootwizard').bootstrapWizard('disable', 1);
					$('#rootwizard li a[href="#paso3"]').removeAttr('data-toggle');
					$('#rootwizard li a[href="#paso1"]').attr('data-toggle', 'tab');
		        	$('#rootwizard').bootstrapWizard('enable', 0);
		        	// $('#rootwizard li.next').attr('class', 'next');
		        	swal({
			            title: "Solicitud cancelada",
			            text: "La solicitud fue cancelada con éxito",
			            type: "success"
			        });
		        	$('#rootwizard').bootstrapWizard('show',0);
				}
			});
		});
	});

//para filtrar el campo "observacion"
	$(document).ready(function()
  	{
  		$("span[id^='msg_'").on("show", function()
  		{
  			setTimeout(function ()
			{
				this.fadeOut();
				this.html("");
			}, 5500);
  		});
  		var intRegex = /^[a-zA-Z0-9\s\.\,]+$/;
  		//script
        $("textarea[id='observacion']").on("keyup change", function()
        {
        	console.log(this.value);
			if(!intRegex.test(this.value) && this.value!='')
			{
          		var aux = this.value;
				this.value = aux.replace(/[^\w\s]/gi, '');
				$("#msg_observacion").html("No puede usar caracteres especiales");
				$("#msg_observacion").show();
				setTimeout(function ()
				{
					$("#msg_observacion").fadeOut();
					$("#msg_observacion").html("");
				}, 5500);
			}
        });
  	});
</script>