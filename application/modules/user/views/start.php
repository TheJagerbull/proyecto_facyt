<div class="mainy">
	<div class="awidget-body">
		<?php if($this->session->flashdata('permission') == 'error') : ?>
              <div class="alert alert-danger" style="text-align: center">Disculpe... usted actualmente no posee permiso para realizar esa acci&oacute;n</div>
        <?php endif ?>
        <?php if($this->session->flashdata('mod_DB') == 'success') : ?>
              <div class="alert alert-success" style="text-align: center">Los cambios en la Base de datos, fueron realizados exitosamente</div>
        <?php endif ?>
		<div class="page-header">
    		<h1><span class="negritas">SiSAI</span><small>&nbsp;&nbsp;&nbsp;Sistema de solicitudes de administración e inventario</small></h1>
		</div>
		<div class="container">
			<div class="row">
				<div class="element">
		            <img class="img-responsive" align="left" src="<?php echo base_url() ?>assets/img/facyt-principal.png" alt=""/>
		        </div>

				<div class="element">
			        <img class="img-rounded"  align ="right" src="<?php echo base_url() ?>assets/img/principal1.jpg" alt=""/>
			    </div>
			    <div class="element">
				    <div class="col-lg-5 col-sm-5 col-sx-5" align="justify">
						<h3>SISAI tiene como objetivo brindarle a la FaCyT un conjunto de servicios  para llevar a cabo las tareas que corresponden a las ordenes de mantenimiento así como la gestión y control de inventario.</h3>
					</div>
				</div>
				<div class="element">
					<img class="img-responsive" align ="right" src="<?php echo base_url() ?>assets/img/facyt-mediano2.png" alt=""/>
				</div>
		    </div>
		</div>
		
		<b hidden><?php echo CI_VERSION;?></b>
		<div style="margin-top: 100px;">
			<div class="bg-3 text-left">
		        <div class="col-sm-5">
		        	<div class="well text-center">
		        		<h4><strong>UST</strong><br>Desarrollo y Programación<br>0241-6004000 Ext. 315191</h4> 
		        	</div>
		        </div>
			</div>
		</div>
	</div>
</div>