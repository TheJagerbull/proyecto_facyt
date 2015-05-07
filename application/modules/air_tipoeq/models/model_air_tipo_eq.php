<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Model_air_tipo_eq extends CI_Model
{
	//constructor predeterminado del modelo
	function __construct()
	{
		parent::__construct();
	}
	

	//verifica que el tipo existe en la base de datos

	public function exist($id)
    {
        $this->db->where('id',$id);
		$query = $this->db->get('air_tipo_eq');
        if($query->num_rows() > 0)
            return TRUE;

        return FALSE;
    }
	
	//la funcion se usa para mostrar los tipos...
	public function get_alltipo($field='id',$order='desc')
	{
		// SE EXTRAEN TODOS LOS DATOS DE TODOS LOS USUARIOS
		if(!empty($field))
			$this->db->order_by($field, $order); 
		$query = $this->db->get('air_tipo_eq');
		return $query->result();
	}
	
	public function get_onetipo($id='')
	{
		if(!empty($id))
		{
			$this->db->where('id',$id);
			// SE EXTRAEN TODOS LOS DATOS DE TODOS LOS USUARIOS
			$query = $this->db->get('air_tipo_eq');
			return $query->row();
		}
		return FALSE;
	}

	
	public function insert_tipo($data='')
	{
		if(!empty($data))
		{
			$this->db->insert('air_tipo_eq',$data);
			return $this->db->insert_id();
		}
		return FALSE;
	}
	
	public function edit_tipo($data='')
	{
		if(!empty($data))
		{
			$this->db->where('id',$data['id']);
			$this->db->update('air_tipo_eq',$data);
			return $data['id'];
		}
		return FALSE;
	}
	
	public function drop_tipo($id='')
	{
		if(!empty($id))
		{
			$this->db->where('id', $id);
			$this->db->delete('air_tipo_eq',array('id'=>$id));
			return TRUE;
		}
		return FALSE;
		
	}

	
	public function buscar_tipo($eq='')
	{
		if(!empty($eq))
		{
			$this->db->like('cod',$eq);
			$this->db->or_like('desc',$eq);
					
			return $this->db->get('air_tipo_eq')->result();
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
		$query = $this->db->get('air_tipo_eq');
		return $query->result();
	}
///no pertenece al proyecto


}