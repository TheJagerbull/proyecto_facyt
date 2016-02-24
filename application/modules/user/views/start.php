<div class="mainy">
	<div class="awidget-body">
		<?php if($this->session->flashdata('permission') == 'error') : ?>
              <div class="alert alert-danger" style="text-align: center">Actualmente no posee permiso para realizar esa acci&oacute;n</div>
        <?php endif ?>
		<div class="page-header">
    		<h1><strong>SiSAI</strong><small>&nbsp;&nbsp;&nbsp;Sistema de solicitudes de administración e inventario</small></h1>
		</div>
		<div class="container">
			<div class="row">
				<div class="element">
		            <img  align ="left" src="<?php echo base_url() ?>assets/img/facyt-principal.png" alt=""/>
		        </div>

				<div class="element">
			        <img  align ="right" src="<?php echo base_url() ?>assets/img/principal1.jpg" alt=""/>
			    </div>
			    <div class="col-sm-4" align="justify">
				<h3>SISAI tiene como
					objetivo brindarle a la FaCyT un conjunto de servicios  para llevar
					a cabo las tareas que corresponden a las ordenes de mantenimiento así como la
					gestión y control de inventario.</h3>
				</div>
		        <div class="element">
		            <img  align ="right" src="<?php echo base_url() ?>assets/img/facyt-mediano2.png" alt=""/>
		        </div>
		    </div>
		</div><br><br><br>
	        <b hidden><?php echo CI_VERSION;?></b>
			
		
		<div class="container-fluid bg-3 text-left">
		        <div class="col-sm-4">
		        	<div class="well">
		        		<h4><strong>UST</strong><br>Desarrollo y Programación<br>0241-6004000 Ext. 315191</h4> 
		        	</div>
		        </div>
		</div>
	</div>
</div>