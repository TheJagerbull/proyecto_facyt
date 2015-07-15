<div class="mainy">
	<?php echo_pre($dependencias); ?>
	 <?php if(!empty($this->session->flashdata('edit_dependencia')))  {echo $this->session->flashdata('edit_dependencia');} ?>
	 <?php if(!empty($this->session->flashdata('add_dependencia')))  {echo $this->session->flashdata('add_dependencia');} ?>
</div>