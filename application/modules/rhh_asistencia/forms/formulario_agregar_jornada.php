<?php
	$form = array(
		'id' 	=> 'rhh_asistencia_form_agregar_jornada',
		'name'  => 'rhh_asistencia_form_agregar_jornada',
		'class' => 'form-horizontal'
	);

	$ampm_inicio_attr = "class='form-control' name='ampm_inicio' id='ampm_inicio'";
	$ampm_inicio = array(
		'am' => 'AM',
		'pm' => 'PM'
	);

	$ampm_fin_attr = "class='form-control' name='ampm_fin' id='ampm_fin'";
	$ampm_fin = array(
		'am' => 'AM',
		'pm' => 'PM'
	);

	$nombre = array(
		'id'	=> 'nombre_jornada',
		'name'	=> 'nombre_jornada',
		'class' => 'form-control',
		'required' => 'true'
	);

	/* Número (1-12)hr Permite formato: 12:45 am*/
	$hora_inicio = array(
		'id'	=> 'hora_inicio',
		'name'	=> 'hora_inicio',
		'class' => 'form-control',
		'required' => 'true',
		'placeholder' => '00:00'
	);

	/* Número (1-12)hr Permite formato: 12:45 am*/
	$hora_fin = array(
		'id'	=> 'hora_fin',
		'name'	=> 'hora_fin',
		'class' => 'form-control',
		'required' => 'true',
		'placeholder' => '00:00'
	);

	$tipo_attr = "class='form-control' name='tipo' id='tipo'";
	$tipo = array(
		'diurno' => 'Diurno',
		'nocturno' => 'Nocturno'
	);

	/* Numero (0-60) minutos * h */
	$tolerancia = array(
		'id'	=> 'tolerancia',
		'name'	=> 'tolerancia',
		'class' => 'form-control',
		'required' => 'true'
	);

	$cantidad_horas_totales = array(
		'id'	=> 'cantidad_horas_totales',
		'name'	=> 'cantidad_horas_totales',
		'class'		=> 'form-control',
		'required' => 'true'
	);

	$cantidad_horas_descanso = array(
		'id'	=> 'cantidad_horas_descanso',
		'name'	=> 'cantidad_horas_descanso',
		'class'		=> 'form-control',
		'required' => 'true'
	);

?>