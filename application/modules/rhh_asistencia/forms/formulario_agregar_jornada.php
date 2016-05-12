<?php
	$form = array(
		'id' 	=> 'rhh_asistencia_form_agregar_jornada',
		'name'  => 'rhh_asistencia_form_agregar_jornada',
		'class' => 'form-horizontal',
		'onsubmit' => "return validaciones();"
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
		'required' => 'true',
		'autocomplete' => 'off'
	);

	/* Número (1-12)hr Permite formato: 12:45 am*/
	$hora_inicio = array(
		'id'	=> 'hora_inicio',
		'name'	=> 'hora_inicio',
		'class' => 'form-control',
		'required' => 'true',
		'placeholder' => '00:00',
		'autocomplete' => 'off'
	);

	/* Número (1-12)hr Permite formato: 12:45 am*/
	$hora_fin = array(
		'id'	=> 'hora_fin',
		'name'	=> 'hora_fin',
		'class' => 'form-control',
		'required' => 'true',
		'placeholder' => '00:00',
		'autocomplete' => 'off'
	);

	$tipo_attr = "class='form-control' name='tipo' id='tipo' required='true'";
	$tipo = array(
		'' => 'Seleccione una',
		'diurno' => 'Diurno',
		'nocturno' => 'Nocturno',
		'tiempo completo' => 'Tiempo Completo'
	);

	/*llamar a un función para obtener los cargos y poblar las opciones del dropdown */
	$this->load->model('model_rhh_funciones');
	$result = $this->model_rhh_funciones->obtener_todos('rhh_cargo');
	$cargo_attr = "class='form-control' name='cargo' id='cargo' required='required'";
	$cargo[''] = 'Seleccione uno';
	foreach ($result as $key) { $cargo[$key['ID']] = $key['nombre'].' '.$key['tipo']; }

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

	$semana = [];
	$semana['0'] = array('0', 'Domingo');
	$semana['1'] = array('1', 'Lunes');
	$semana['2'] = array('2', 'Martes');
	$semana['3'] = array('3', 'Miercoles');
	$semana['4'] = array('4', 'Jueves');
	$semana['5'] = array('5', 'Viernes');
	$semana['6'] = array('6', 'Sábado');

?>