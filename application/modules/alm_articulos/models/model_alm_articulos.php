<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Model_alm_articulos extends CI_Model
{
	//constructor predeterminado del modelo
	function __construct()
	{
		parent::__construct();
	}

	public function get_allArticulos($per_page='', $offset='')
	{
		$query = $this->db->get('alm_articulo', $per_page, $offset);
		return($query->result());
	}

	public function get_activeArticulos($field='',$order='',$per_page='', $offset='')
	{
		if(!empty($field))
		{
			if($field=='existencia')
			{
				$this->db->select('*');
				$this->db->select('(disp + reserv) AS existencia');
			}
			$this->db->order_by($field, $order);
		}
		$this->db->where('ACTIVE', '1');
		$query = $this->db->get('alm_articulo', $per_page, $offset);
		return($query->result());
	}

	public function get_articulo($articulo='')
	{

	}

	public function find_articulo($art='', $field='', $order='', $per_page='', $offset='')
	{
		if(!empty($art))
		{
			if(!empty($field))
			{
				if($field=='existencia')
				{
					$this->db->select('*');
					$this->db->select('(disp + reserv) AS existencia');
				}
				$this->db->order_by($field, $order);

			}
			$this->db->where('ACTIVE', '1');
			$this->db->like('descripcion',$art);

			return $this->db->get('alm_articulo', $per_page, $offset)->result();
		}
		return FALSE;
	}
	public function count_foundArt($art='')
	{
		if(!empty($art))
		{

			$this->db->like('descripcion',$art);
			// $this->db->or_like('apellido',$art);

			return $this->db->count_all_results('alm_articulo');
		}
		return FALSE;
	}

	public function count_articulos()
	{
		$this->db->where('ACTIVE', '1');
		return($this->db->count_all('alm_articulo'));
	}

	public function ajax_likeArticulos($data)
	{
		$this->db->like('descripcion', $data);
		$query = $this->db->get('alm_articulo');
		return $query->result();
	}

}