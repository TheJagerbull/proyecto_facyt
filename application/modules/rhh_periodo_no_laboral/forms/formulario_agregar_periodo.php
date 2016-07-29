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

		/*llamar a un función para obtener los cargos y poblar las opciones del dropdown */
	$result = $this->model_rhh_funciones->obtener_todos('rhh_periodo');
	$periodo_w_attr = "class='form-control' name='periodo_global' id='periodo_global' required='required'";
	$periodo_w[''] = 'Seleccione uno';
	foreach ($result as $key) { $periodo_w[$key['ID']] = $key['nombre']; }

?>