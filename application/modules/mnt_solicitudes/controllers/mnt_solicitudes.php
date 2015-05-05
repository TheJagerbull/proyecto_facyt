<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Mnt_solicitudes extends MX_Controller {

	/**
	 * 
	 * Metodo Construct.
	 * =====================
	 * En este metodo, se hace el constructor
	 * @author José Henriquez en fecha: 28/04/2015
	 * 
	 */
	function __construct() //constructor predeterminado del controlador
    {
        parent::__construct();
        $this->load->library('form_validation');
		$this->load->model('model_mnt_solicitudes','model');
    }

	
	/**
	 * 
	 * Metodo Index.
	 * =====================
	 * En este metodo, se hace lista todos los Items de Mantenimiento Preventivo
	 * @author José Henriquez en fecha: 28/04/2015
	 * 
	 */
	public function general($field='',$order='')
	{
           //die("llega");
//		if($this->hasPermissionClassA())
//		{
                    
			// $HEADER Y $VIEW SON LOS ARREGLOS DE PARAMETROS QUE SE LE PASAN A LAS VISTAS CORRESPONDIENTES
			$header['title'] = 'Ver equipo';
			
			if(!empty($field))
			{
				switch ($field)
				{
					case 'id_orden': $field = 'cod'; break;
					case 'tipo_orden': $field = 'desc'; break;
					default: $field = 'id_orden'; break;
				}
			}
			$order = (empty($order) || ($order == 'asc')) ? 'desc' : 'asc';
			$item = $this->model->get_allitem($field,$order);
			// PARA VER LA INFORMACION DE LOS USUARIOS DESCOMENTAR LA LINEA DE ABAJO, GUARDAR Y REFRESCAR EL EXPLORADOR
			// die_pre($usuarios);
			if($_POST)
			{
				$view['item'] = $this->buscar_item();
			}
			else
			{
				$view['item'] = $item;
			}
			$view['order'] = $order;
			
			//CARGAR LAS VISTAS GENERALES MAS LA VISTA DE VER USUARIO
			$this->load->view('template/header',$header);
			$this->load->view('mnt_solicitudes/main',$view);
			$this->load->view('template/footer');
//		}else{
//			$header['title'] = 'Error de Acceso';
//			$this->load->view('template/erroracc',$header);
//		}
	}

}
