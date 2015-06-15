<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Model_air_cntrl_mp_equipo extends CI_Model
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
	
	//la funcion se usa para mostrar los controles...
	public function get_allcontrol($field='id',$order='desc')
	{
		// SE EXTRAEN TODOS LOS DATOS DE TODOS LOS USUARIOS
		if(!empty($field))
			$this->db->order_by($field, $order); 
		$query = $this->db->get('air_cntrl_mp_equipo');
		return $query->result();
	}
	
	public function get_onetipo($id='')
	{
		if(!empty($id))
		{
			$this->db->where('id',$id);
			// SE EXTRAEN TODOS LOS DATOS DE TODOS LOS USUARIOS
			$query = $this->db->get('air_cntrl_mp_equipo');
			return $query->row();
		}
		return FALSE;
	}

	
	public function insert_tipo($data='')
	{
		if(!empty($data))
		{
			$this->db->insert('air_cntrl_mp_equipo',$data);
			return $this->db->insert_id();
		}
		return FALSE;
	}
	
	public function edit_tipo($data='')
	{
		if(!empty($data))
		{
			$this->db->where('id',$data['id']);
			$this->db->update('air_cntrl_mp_equipo',$data);
			return $data['id'];
		}
		return FALSE;
	}
	
	public function drop_tipo($id='')
	{
		if(!empty($id))
		{
			$this->db->where('id', $id);
			$this->db->delete('air_cntrl_mp_equipo',array('id'=>$id));
			return TRUE;
		}
		return FALSE;
		
	}

	
	public function buscar_tipo($eq='')
	{
		 if (!empty($eq)) {

            $eq = preg_split("/[\s,]+/", $eq);
            $first = $eq[0];
            if (!empty($eq[1]))
            {
                $second = $eq[1];
                $this->db->like('desc', $second);
            }
          
            $this->db->like('cod', $first);
            $this->db->or_like('desc', $first);
            

            return $this->db->get('air_cntrl_mp_equipo')->result();
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
		$query = $this->db->get('air_cntrl_mp_equipo');
		return $query->result();
	}

  		 
}