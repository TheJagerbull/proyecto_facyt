<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Model_mnt_miembros_cuadrilla extends CI_Model {

    //constructor predeterminado del modelo
    function __construct() {
        parent::__construct();
    }	
	
	
	//Aporte de Juan Parra

    public function get_miembros() {
        return $this->db->get('mnt_miembros_cuadrilla')->result();
    }
    /**
     * get_miembros_cuadrilla
     * =====================
     * En este metodo, se hace una busqueda de todos los miembros de  
     * una cuadrilla especificada
     * Usada en: vista ver_cuadrilla y controlador cuadrilla/detalle_cuadrilla
     * @author Jhessica_Martinez  en fecha: 12/06/2015
     */
    public function get_miembros_cuadrilla($id){    
    	if(!empty($id))
		{
			$this->db->where('id_cuadrilla',$id);
			$this->db->select('id_trabajador');
			$query = $this->db->get('mnt_miembros_cuadrilla');
			return $query->result();
		}
		return FALSE;
    }
 }
