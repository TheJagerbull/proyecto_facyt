<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Model_mnt_cuadrilla extends CI_Model {

    //constructor predeterminado del modelo
    function __construct() {
        parent::__construct();
    }	
	
	//consulta si un id o nombre de cuadrilla existe en la base de datos
	public function exist($eq)
    {
    	if(!empty($eq))
		{
			$this->db->like('id',$eq);
			$this->db->or_like('cuadrilla',$eq);
					
			return TRUE;
		}
		return FALSE;
	//	funcion anterior
    //  $this->db->where('id',$id);
	//	$query = $this->db->get('mnt_cuadrilla');
    //  if($query->num_rows() > 0)
    //        return TRUE;
    //    return FALSE;
    }

	//la funcion se usa para mostrar los items de la tabla...
	//para filtrar los roles, y cualquier dato de alguna columna, 
	//se debe realizar con condicionales desde la vista en php
	public function get_allitem($field='',$order='')
	{
		// SE EXTRAEN TODOS LOS DATOS DE TODAS LAS CUADRILLAS DADO UN ORDEN
		if(!empty($field))
			$this->db->order_by($field, $order); 
		$query = $this->db->get('mnt_cuadrilla');
		return $query->result();
	}
	// SE EXTRAEN TODOS LOS DATOS DE TODAS LAS CUADRILLAS SIN UN ORDEN ESPECIFICO
	public function get_cuadrillas() {
        return $this->db->get('mnt_cuadrilla')->result();
    }

	public function get_oneitem($id='')
	{
		if(!empty($id))
		{
			$this->db->where('id',$id);
			$query = $this->db->get('mnt_cuadrilla');
			return $query->row_array();
		}
		return FALSE;
	}

	
	public function insert_cuadrilla($data='')
	{
		if(!empty($data))	//verifica que no se haga una insercion vacia
		{
			$this->db->insert('mnt_cuadrilla',$data);
			return $this->db->insert_id();	
		}
		return FALSE;
	}
	
	public function edit_item($data='')
	{
		if(!empty($data))
		{
			$this->db->where('id',$data['id']);
			$this->db->update('mnt_cuadrilla',$data);
			return $data['id'];
		}
		return FALSE;
	}
	
	public function drop_item($id='')
	{
		if(!empty($id))
		{
			 
			$this->db->where('id',$id);
			$this->db->update('mnt_cuadrilla',$data);
			return TRUE;
		}
		return FALSE;
		
	}
	
	//retorna los datos de una cuadrilla buscada
	public function buscar_cuadrilla($eq='')
	{
		if(!empty($eq))
		{
			$this->db->like('id',$eq);
			$this->db->or_like('cuadrilla',$eq);
			$this->db->or_like('id_trabajador_responsable',$eq);
					
			return $this->db->get('mnt_cuadrilla')->result();
		}
		return FALSE;
	}

	//------------------------------------------Para consulta del autocompletado de la vista
	public function ajax_likeSols($data)
	{
		$this->db->like('id', $data);
		$this->db->or_like('cuadrilla',$data);
		$query = $this->db->get('mnt_cuadrilla');
		return $query->result();
	}
    
    
	//Aporte de Juan Parra

    public function get_nombre_cuadrilla($id) {
        $dat = $this->conect($id);
        return ($dat['cuadrilla']);
    }

    public function conect($id) 
    {
        $this->db->where('id', $id);
        $this->db->select('cuadrilla');
        $query = $this->db->get('mnt_cuadrilla');
        return $query->row_array();
    }
    
    //Juan Parra
    public function existe_cuadrilla($nombre=''){
        $this->db->where('cuadrilla',$nombre);
        $this->db->select('cuadrilla');
        $query = $this->db->get('mnt_cuadrilla')->result();
        //die_pre($query);
        if (!empty($query)):
            return 'TRUE';
        else:
            return 'FALSE';
        endif;
        
    }

 }
