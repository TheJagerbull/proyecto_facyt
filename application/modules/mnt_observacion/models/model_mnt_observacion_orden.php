<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Model_mnt_observacion_orden extends CI_Model
{
	//constructor predeterminado del modelo
	function __construct()
	{
		parent::__construct();
	}
         var $table = 'mnt_observacion_orden';
        var $table2 = 'dec_usuario';
	var $column = array('nombre','apellido');
	var $order = array('nombre' => 'desc');
		
	
	public function insert_orden($data2='')
	{
		if(!empty($data2))
		{
			//die_pre($data2);
			$this->db->insert('mnt_observacion_orden',$data2);
			
		}
		return FALSE;
	}
	public function actualizar_orden($data = '', $id_orden = '')
	{
        if (!empty($data))
        {
            $this->db->where('id_orden_trabajo', $id_orden);
            $this->db->update('mnt_observacion_orden', $data);
        }
        return FALSE;
    }
	
        public function get_observacion ($id=''){
            $this->db->where('id_orden_trabajo',$id);
            $this->db->select('observac');
            $campo = $this->db->get('mnt_observacion_orden')->result_array();  
           if (!empty($campo))
            return $campo[0]['observac'];   
        }
	//public function edit_orden($data='')
	//{
		//if(!empty($data))
		//{
			//$this->db->where('id',$data['id']);
			//$this->db->update('mnt_orden_trabajo',$data);
			//return $data['id'];
		//}
		//return FALSE;
	//}
  //para trabajar con el datatable por ajax
private function _get_datatables_query() {
        $this->db->select('nombre,apellido,observac');
        $this->db->join('mnt_observacion_orden', 'mnt_observacion_orden.id_usuario = dec_usuario.id_usuario', 'INNER');
        $this->db->from($this->table2);
        $i = 0;
        foreach ($this->column as $item) // loop column
        {
            if($_POST['search']['value']) // if datatable send POST for search
            {
                 
                if($i===0) // first loop
                {
                    $this->db->group_start(); // open bracket. query Where with OR clause better with bracket. because maybe can combine with other WHERE with AND.
                    $this->db->like($item, $_POST['search']['value']);
                }
                else
                {
                    $this->db->or_like($item, $_POST['search']['value']);
                }
 
                if(count($this->column) - 1 == $i) //last loop
                    $this->db->group_end(); //close bracket
            }
            $column[$i] = $item; // set column array variable to order processing
            $i++;
        }
         
        if(isset($_POST['order'])) // here order processing
        {
            $this->db->order_by($column[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        }
        else if(isset($this->order))
        {
            $order = $this->order;
            $this->db->order_by(key($order), $order[key($order)]);
        }
    }
    
    function get_datatables($id = '') {
        $this->db->order_by('id_observacion','desc');
        $this->db->where('id_orden_trabajo', $id);
        $this->_get_datatables_query();
       if($_POST['length'] != -1)
        $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get();
        return $query->result();
    }
    
    function count_filtered($id = '') {
        $this->db->where('id_orden_trabajo', $id);
        $this->_get_datatables_query();
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function count_all($id = '') {
        $this->db->where('id_orden_trabajo', $id);
        $this->db->from($this->table);
        return $this->db->count_all_results();
    }
        
}