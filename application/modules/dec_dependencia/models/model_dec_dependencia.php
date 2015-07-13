<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Model_dec_dependencia extends CI_Model {

    //constructor predeterminado del modelo
    function __construct() {
        parent::__construct();
    }

    public function get_allDependencias()
    {
        return($this->db->get('dec_dependencia')->result_array());
    }

    public function get_dependencia() {
        $this->db->order_by('dependen', 'asc');
        $query = $this->db->get('dec_dependencia');
        return $query->result();
    }
    
    public function get_total_dep() {
        return($this->db->count_all('dec_dependencia'));
    }

    public function get_nombre_dependencia($id) {
        $dat = $this->conect($id);
        return ($dat['dependen']);
    }

    public function conect($id) {
        $this->db->where('id_dependencia', $id);
        $this->db->select('dependen');
        $query = $this->db->get('dec_dependencia');
        return $query->row_array();
    }

    public function set_newDependencia($array='')
    {
        if(!empty($array))
        {
            $this->db->insert('dec_dependencia',$array);
            return $this->db->insert_id();
        }
        return FALSE;
    }

    public function edit_dependencia($array='')
    {
        if(!empty($array))
        {
            $this->db->where('id_dependencia',$array['id_dependencia']);
            $this->db->update('dec_dependencia',$array);
            return $array['id_dependencia'];
        }
        return FALSE;
    }
    public function exist($id_dependencia)
    {
        $query = $this->db->get_where('dec_dependencia',$id_dependencia);
        if($query->num_rows() > 0)
            return TRUE;

        return FALSE;
    }
}
