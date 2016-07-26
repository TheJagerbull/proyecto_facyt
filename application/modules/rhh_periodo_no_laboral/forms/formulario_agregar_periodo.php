<?php
	$form = array(
		'id' 	=> 'rhh_periodo_no_laboral_agregar',
		'name'  => 'rhh_periodo_no_laboral_agregar',
		'class' => 'form-horizontal'
	);

	$nombre = array(
		'id'	=> 'nombre_periodo',
		'name'	=> 'nombre_periodo',
		'class' => 'form-control',
		'required' => 'true',
		'autocomplete' => 'off'
	);

	$descripcion = array(
		'id'	=> 'descripcion_periodo',
		'name'	=> 'descripcion_periodo',
		'class' => 'form-control',
		'required' => 'true',
	);

	$cant_dias = array(
		'id'	=> 'cant_dias_periodo',
		'name'	=> 'cant_dias_periodo',
		'class' => 'form-control',
		'required' => 'true',
	);

	$fecha_inicio = array(
		'type'  => 'text',
		'class' => 'form-control',
		'name'  => 'fecha_inicio_periodo',
		'id'  	=> 'fecha_inicio_periodo',
		'required' => 'true'
	);

	$fecha_fin = array(
		'type'  => 'text',
		'class' => 'form-control',
		'name'  => 'fecha_fin_periodo',
		'id'  	=> 'fecha_fin_periodo',
		'required' => 'true'
	);

?>