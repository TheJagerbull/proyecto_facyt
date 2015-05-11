<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Model_air_mant_prev_item extends CI_Model
{
	//constructor predeterminado del modelo
	function __construct()
	{
		parent::__construct();
	}
	
	
	//veifica que el item se encuentra en la base de datos
	public function exist($id)
    {
        $this->db->where('id',$id);
		$query = $this->db->get('air_mant_prev_item');
        if($query->num_rows() > 0)
            return TRUE;

        return FALSE;
    }

	//la funcion se usa para mostrar los items de la tabla...
	//para filtrar los roles, y cualquier dato de alguna columna, se debe realizar con condicionales desde la vista en php
	public function get_allitem($field='id',$order='desc')
	{
		// SE EXTRAEN TODOS LOS DATOS DE TODOS LOS ITEMS
		if(!empty($field))
			$this->db->order_by($field, $order); 
		$query = $this->db->get('air_mant_prev_item');
		return $query->result();
	}

	//la funcion se usa para mostrar los items de la tabla...
	//para filtrar los roles, y cualquier dato de alguna columna, se debe realizar con condicionales desde la vista en php
	public function get_allitemactv($field='id',$order='desc')
	{
		$this->db->where('status','1');
		if(!empty($field))
			$this->db->order_by($field, $order); 
		$query = $this->db->get('air_mant_prev_item');
		return $query->result();
	}
	
	public function get_oneitem($id='')
	{
		if(!empty($id))
		{
			$this->db->where('id',$id);
			$query = $this->db->get('air_mant_prev_item');
			return $query->row();
		}
		return FALSE;
	}

	
	public function insert_item($data='')
	{
		if(!empty($data))
		{
			$this->db->insert('air_mant_prev_item',$data);
			return $this->db->insert_id();
		}
		return FALSE;
	}
	
	public function edit_item($data='')
	{
		if(!empty($data))
		{
			$this->db->where('id',$data['id']);
			$this->db->update('air_mant_prev_item',$data);
			return $data['id'];
		}
		return FALSE;
	}
	
	public function drop_item($id='')
	{
		if(!empty($id))
		{
			$data['status']='0';
			$this->db->where('id',$id);
			$this->db->update('air_mant_prev_item',$data);
			return TRUE;
		}
		return FALSE;
		
	}

	public function activ_item($id='')
	{
		if(!empty($id))
		{
			$data['status']='1';
			$this->db->where('id',$id);
			$this->db->update('air_mant_prev_item',$data);
			return TRUE;
		}
		return FALSE;
		
	}

	
	public function buscar_item($eq='')
	{
		if(!empty($eq))
		{
			$this->db->like('cod',$eq);
			$this->db->or_like('desc',$eq);
					
			return $this->db->get('air_mant_prev_item')->result();
		}
		return FALSE;
	}

	public function sw_search($keyword)
    {
         $this->db->select('id, friendly_name');
         $this->db->from('business_category');
         $this->db->where('suppress', 0);
         $this->db->like('friendly_name', $keyword);
         $this->db->order_by("friendly_name", "asc");
         
         $query = $this->db->get();
         foreach($query->result_array() as $row){
             //$data[$row['friendly_name']];
             $data[] = $row;
         }
         //return $data;
         return $query;
     }

	public function ajax_likeUsers($data)
	{
		$this->db->like('cod', $data);
		$this->db->or_like('desc',$data);
		$query = $this->db->get('air_mant_prev_item');
		return $query->result();
	}
///no pertenece al proyecto


}