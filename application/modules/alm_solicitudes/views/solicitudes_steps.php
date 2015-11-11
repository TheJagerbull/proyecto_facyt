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
					<ul>
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
		<div id="bar" class="progress">
	      <div class="progress-bar" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%;"></div>
	    </div>
		<div class="tab-content">
			<div class="tab-pane" id="paso1">
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
			<div class="tab-pane" id="paso3">
			3
			</div>
			<div class="tab-pane" id="paso4">
			4
			</div>
		</div>
	</div>
	<div class="clearfix"></div>
            
</div>
<script src="<?php echo base_url() ?>assets/js/jquery-1.11.3.js"></script>
<script type="text/javascript">
	base_url = '<?=base_url()?>';
    $(document).ready(function () {
    	  	$('#rootwizard').bootstrapWizard({onTabShow: function(tab, navigation, index) {
				var $total = navigation.find('li').length;
				var $current = index+1;
				var $percent = ($current/$total) * 100;
				$('#rootwizard .progress-bar').css({width:$percent+'%'});
				if($percent===100)
				{
					console.log('100%');
					// console.log(aux);
					$('#rootwizard .progress-bar').attr("class", 'progress-striped progress-bar')
				}
				else
				{
					$('#rootwizard .progress-bar').attr("class", 'progress-striped progress-bar progress-bar-warning');
				}
			}});
			//PASO 1
			  $('#act-inv').dataTable({
			    "bProcessing": true,
			          "bServerSide": true,
			          "sServerMethod": "GET",
			          "sAjaxSource": base_url+"index.php/alm_articulos/getInventoryTable/1",
			          "iDisplayLength": 10,
			          "aLengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
			          "aaSorting": [[0, 'asc']],
			          "aoColumns": [
			      { "bVisible": true, "bSearchable": true, "bSortable": true },
			      { "bVisible": true, "bSearchable": true, "bSortable": true },
			      { "bVisible": true, "bSearchable": true, "bSortable": true },
			      { "bVisible": true, "bSearchable": true, "bSortable": false }//la columna extra
			          ]
			  })
	});
</script>