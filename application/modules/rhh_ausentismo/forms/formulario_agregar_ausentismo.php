<?php
	$form = array(
		'id' 	=> 'rhh_asistencia_form_agregar_ausentismo',
		'name'  => 'rhh_asistencia_form_agregar_ausentismo',
		'class' => 'form-horizontal'
	);

	$tipo_ausentismo_attr = "class='form-control' name='tipo_ausentismo' id='tipo_ausentismo'";
	$tipo_ausentismo = array(
		'permiso' => 'Perismo',
		'reposo' => 'Reposo'
	);

	$nombre = array(
		'id' => 'nombre',
		'name' => 'nombre',
		'class' => 'form-control'
	);

	$min_dias = array(
		'id' => 'min_dias',
		'name' => 'min_dias',
		'class' => 'form-control'
	);

	$max_dias = array(
		'id' => 'max_dias',
		'name' => 'max_dias',
		'class' => 'form-control'
	);

	$max_mensual = array(
		'id' => 'max_mensual',
		'name' => 'max_mensual',
		'class' => 'form-control'
	);

	

	/* Para todos los formularios creare lo botones detro de las etiquetas form_open y form_close */
?>