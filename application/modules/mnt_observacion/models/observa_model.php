<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Observa_model extends CI_Model {
       
	var $table = 'mnt_observacion_orden';
        var $table2 = 'mnt_orden_trabajo';
	var $column = array('id_usuario','id_orden_trabajo','observac');
	var $order = array('id' => 'desc');

	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}

	private function _get_datatables_query($id='')
	{       
                $this->db->select('id_usuario,observac,id_orden_trabajo');
		$this->db->join('mnt_orden_trabajo', 'mnt_orden_trabajo.id_orden = mnt_observacion_orden.id_orden_trabajo', 'INNER');
		$this->db->where('id_usuario',$id);
                $this->db->from($this->table);
//                $this->db->from($this->table2);
		$i = 0;
	
		foreach ($this->column as $item) 
		{
			if($_POST['search']['value'])
				($i===0) ? $this->db->like($item, $_POST['search']['value']) : $this->db->or_like($item, $_POST['search']['value']);
			$column[$i] = $item;
			$i++;
		}
		
		if(isset($_POST['order']))
		{
			$this->db->order_by($column[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
		} 
		else if(isset($this->order))
		{
			$order = $this->order;
			$this->db->order_by(key($order), $order[key($order)]);
		}
	}

	function get_datatables($id='')
	{
		$this->_get_datatables_query($id);
		if($_POST['length'] != -1)
		$this->db->limit($_POST['length'], $_POST['start']);
		$query = $this->db->get();
		return $query->result();
	}

	function count_filtered($id='')
	{
		$this->_get_datatables_query();
                $this->db->where('id_usuario',$id);
		$query = $this->db->get();
		return $query->num_rows();
	}

	public function count_all($id='')
	{
                $this->db->where('id_usuario',$id);
		$this->db->from($this->table);
                return $this->db->count_all_results();
	}

	public function get_by_id($id)
	{
		$this->db->from($this->table);
		$this->db->where('id_orden_trabajo',$id);
		$query = $this->db->get();

		return $query->row();
	}

	public function save($data)
	{
		$this->db->insert($this->table, $data);
		return $this->db->insert_id();
	}

	public function update($where, $data)
	{
		$this->db->update($this->table, $data, $where);
		return $this->db->affected_rows();
	}

	public function delete_by_id($id)
	{
		$this->db->where('id_orden_trabajo', $id);
		$this->db->delete($this->table);
	}


}
