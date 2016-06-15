<!-- http://vadimg.com/twitter-bootstrap-wizard-example/ -->
<div class="mainy">
              <!-- Page title -->
               <div class="page-title">
                  <h2 align="right"><i class="fa fa-tags color"></i> Generar solicitud <small>siga los pasos</small></h2>
                  <hr />
               </div>
              <!-- End Page title -->
	<div id="rootwizard">
		<div class="navbar">
			<div class="navbar-inner">
				<div class="container">
					<ul><!-- buscar en el archivo bootstrap.min.css ".nav-pills>li.active>a:focus{color:#fff;background-color:#337ab7}" y cambiar #337ab7 por #777 o viceversa-->
						<li><a href="#paso1" data-toggle="tab">1er Paso</a></li>
						<li><a href="#paso2" data-toggle="tab">2do Paso</a></li>
						<li><a href="#paso3" data-toggle="tab">3er Paso</a></li>
						<li><a href="#paso4" data-toggle="tab">4to Paso</a></li>
					</ul>
				</div>
				<ul class="pager wizard">
					<li class="previous first" style="display:none;"><a href="#">1er Paso</a></li>
					<li class="previous"><a href="#"><i class="glyphicon glyphicon-chevron-left"></i></a></li>
					<li class="next last" style="display:none;"><a href="#">Ultimo paso</a></li>
					<li class="next"><a href="#"><i class="glyphicon glyphicon-chevron-right"></i></a></li>
				</ul>
			</div>
		</div>
		<div class="tab-content">
			<div class="tab-pane" id="paso1">
<!-- Paso 1-->
				<div id="error_paso1" class="panel">
				</div>
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
			<div class="tab-pane" id="paso2">
<!-- Paso 2-->
				<div id="error_paso2">
				</div>

				<div id="lista_paso2" class="panel">
				<table id="selec-items" class="table table-hover table-bordered col-lg-8 col-md-8 col-sm-8">
					<thead>
						<tr>
							<th>Item</th>
							<th>Codigo</th>
							<th>Unidad</th>
							<th>Descripcion</th>
							<th>Cantidad</th>
						</tr>
					</thead>
					<tbody></tbody>
					<tfoot></tfoot>
				</table>
				</div>

			</div>
			<div class="tab-pane" id="paso3">
<!-- Paso 3-->
				<div id="error_paso3">
				</div>
				
			</div>
			<div class="tab-pane" id="paso4">
				
			</div>
		</div>
	</div>
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
		console.log(aux);
		if(aux)
		{
			selected = aux;
		}
		for (var i = selected.length - 1; i >= 0; i--)
		{
			selected[i] = "row_"+selected[i];
		};
		console.log(selected);
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
	  				
	  			}
		        if(index==1)
	  			{
			        console.log("step2");
	  			}
			},
	  		onTabChange: function(tab, navigation, index){
	  			if(index==0)
	  			{
				///////////para actualizar en session
	  				// var items =[];
	  				// for (var i = selected.length - 1; i >= 0; i--)
	  				// {
	  				// 	var cod = selected[i].slice(4);
	      //       		items.push( cod );

	  				// };
	  				// $.post(base_url+"index.php/alm_solicitudes/solicitud_steps", { //se le envia la data por post al controlador respectivo
		     //            step1: items  //variable a enviar
		     //        }, function (data) { //aqui se evalua lo que retorna el post para procesarlo dependiendo de lo que se necesite
		     //            list = data;
		     //            $("#lista_paso2").html(list); //aqui regreso la respuesta de la funcion
		     //        });

				///////////para actualizar en session
	  			}
	  		}
		});
//para el PASO 1
		$('#act-inv').dataTable({
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
				{"width": "30%", "data": "agregar"}
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
	 		console.log(index);
	        if( index === -1 )//si no es verdad...
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
	        console.log(selected);
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


	});
</script>