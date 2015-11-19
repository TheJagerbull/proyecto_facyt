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
				<div id="error_paso1">
				</div>
				<table id="act-inv" class="table table-hover table-bordered col-lg-8 col-md-8 col-sm-8">
					<thead>
						<tr>
							<th>Item</th>
							<th>codigo</th>
							<th>Descripcion</th>
							<th>Agregar/Remover</th>
						</tr>
					</thead>
					<tbody></tbody>
					<tfoot></tfoot>
				</table>
			</div>
			<div class="tab-pane" id="paso2">
			2
			</div>
<!-- Paso 2-->
				<div id="error_paso2">
				</div>
			<div class="tab-pane" id="paso3">
			3
			</div>
<!-- Paso 3-->
				<div id="error_paso3">
				</div>
			<div class="tab-pane" id="paso4">
			4
			</div>
		</div>
	</div>
	<div class="clearfix"></div>
            
</div>
<script src="<?php echo base_url() ?>assets/js/jquery-1.11.3.js"></script>
<!-- <script src="<?php echo base_url() ?>assets/js/jquery.cookie.js"></script>-->
<script type="text/javascript">
	base_url = '<?=base_url()?>';
    $(document).ready(function () {
		var selected =  new Array();
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
			},
	  		onNext: function(tab, navigation, index){
	  			console.log(index);
	  			if(index==0)
	  			{
	  				if(!selected.length)
	  				{
	  					return(false);
	  				}
	  			}
	  			if(index==1)
	  			{
	  				return true;
	  			}
	  			if(index==2)
	  			{
	  				
	  			}
	  			if(index==3)
	  			{
	  				
	  			}
	  		}
		});
		//PASO 1
		var oTable;
		$('#act-inv').dataTable({
			"pagingType": "numbers",
			"bProcessing": true,
			"bServerSide": true,
			"sServerMethod": "GET",
			"sAjaxSource": base_url+"index.php/alm_articulos/getInventoryTable/1",
			"rowCallback": function( row, data) {
	            if ( $.inArray(data.DT_RowId, selected) !== -1 ) {
	                // console.log(data[3]);
	                // console.log($('i', row).attr("class"));
	                // data[3] = '<span id="clickable"><i id="row_'+row['id']+'" class="fa fa-minus" style="color:#D9534F"></i></span>';
	                // $(row).addClass('selected');
		            $('i', row).attr("class", 'fa fa-minus');
		            $('i', row).attr("style", 'color:#D9534F');
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
		$('#act-inv tbody').on( 'click', 'i', function () {
	        var id = this.id;
	        // var cod = id.slice(4);
	        var index = $.inArray(id, selected);
	 
	        if ( index === -1 ) {
	        	// console.log(cod);
	            selected.push( id );
	            // console.log($(this).attr("class"));
	            $(this).attr("class", 'fa fa-minus');
	            $(this).attr("style", 'color:#D9534F');
	        } else {
	            selected.splice( index, 1 );
	            $(this).attr("class", 'fa fa-plus color');
	            $(this).removeAttr("style");
	        }
	        if(!selected.length)//para activar y desactivar los pasos y el boton 'next'
	        {
	        	$('#rootwizard').bootstrapWizard('disable', 1);
	        	$('#rootwizard li a[href="#paso2"]').removeAttr('data-toggle');
	        	$('#rootwizard li.next').attr('class', 'next disabled');
	        }
	        else//para activar y desactivar los pasos y el boton 'next'
	        {
	        	// console.log($('#rootwizard li a[data-toggle]'));
	        	$('#rootwizard li a[href="#paso2"]').attr('data-toggle', 'tab');
	        	$('#rootwizard').bootstrapWizard('enable', 1);
	        	$('#rootwizard li.next').attr('class', 'next');
	        }
	 		
	        // $(this).toggleClass('selected');
			console.log(selected);
	    } );
	});
    $(document).ready(function () {

	});
</script>