<?php
	$form = array(
		'id' 	=> 'rhh_asistencia_form_agregar_ausentismo',
		'name'  => 'rhh_asistencia_form_agregar_ausentismo',
		'class' => 'form-horizontal',
		//'onsubmit' => 'return validaciones();'
	);

	$tipo_ausentismo_attr = "class='form-control' name='tipo_ausentismo' id='tipo_ausentismo'";
	$tipo_ausentismo = array(
		'permiso' => 'Permiso',
		'reposo' => 'Reposo'
	);

	$tipo_dias_attr = "class='form-control' name='tipo_dias' id='tipo_dias'";
	$tipo_dias = array(
		'Hábiles' => 'Hábiles',
		'Continuos' => 'Continuos'
	);

	$nombre = array(
		'id' => 'nombre',
		'name' => 'nombre',
		'class' => 'form-control',
		'required' => 'true',
		'autocomplete' => 'off'
	);

	$min_dias = array(
		'id' => 'min_dias',
		'name' => 'min_dias',
		'class' => 'form-control',
		'required' => 'true',
		'autocomplete' => 'off'
	);

	$max_dias = array(
		'id' => 'max_dias',
		'name' => 'max_dias',
		'class' => 'form-control',
		'required' => 'true',
		'autocomplete' => 'off'
	);

	$max_mensual = array(
		'id' => 'max_mensual',
		'name' => 'max_mensual',
		'class' => 'form-control',
		'required' => 'true',
		'autocomplete' => 'off'
	);

	$soportes_form = array(
		'id' => 'soportes',
		'name' => 'soportes',
		'class' => 'form-control',
		'required' => 'true',
		'autocomplete' => 'off'
	);

	/* Para todos los formularios creare lo botones detro de las etiquetas form_open y form_close */
?>