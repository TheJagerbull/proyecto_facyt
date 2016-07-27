<?php

	$this->load->model('model_rhh_funciones');

	$form = array(
		'id' 	=> 'rhh_asistencia_form_agregar_ausentismo',
		'name'  => 'rhh_asistencia_form_agregar_ausentismo',
		'class' => 'form-horizontal',
		//'onsubmit' => 'return validaciones();'
	);

	$tipo_ausentismo_attr = "class='form-control' required name='tipo_ausentismo' id='tipo_ausentismo'";
	$tipo_ausentismo = array(
		'' => 'Seleccione uno',
		'permiso' => 'Permiso',
		'reposo' => 'Reposo'
	);

	$id_trabajador = array(
		'id' => 'id_trabajador',
		'name' => 'id_trabajador',
		'class' => 'form-control',
		'type' => 'hidden',
		'value' => $this->session->userdata('user')['id_usuario'],
		'required' => 'true'
	);

	$estatus = array(
		'id' => 'estatus_ausentismo',
		'nombre' => 'estatus_ausentismo',
		'class' => 'form-control',
		'type' => 'hidden',
		'required' => 'true',
	);

	/* Para todos los formularios creare lo botones detro de las etiquetas form_open y form_close */
?>