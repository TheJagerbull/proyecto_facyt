<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Model_dec_dependencia extends CI_Model {

    //constructor predeterminado del modelo
    function __construct() {
        parent::__construct();
    }

    public function get_allDependencias()//Se obtienen todas las depedencias usando el active record del framework
    {
        return($this->db->get('dec_dependencia')->result_array());
    }

    public function get_dependencia() {// Se obtienen todas las dependencias pero ordenandolas de forma ascendente con active record del framework
        $this->db->order_by('dependen', 'asc');
        $query = $this->db->get('dec_dependencia');
        return $query->result();
    }
    
    public function get_total_dep() {// Se obtiene el total de las dependencias
        return($this->db->count_all('dec_dependencia'));
    }

    public function get_nombre_dependencia($id) { //Se obtiene el nombre de la dependencia al pasar el id de la misma
        $dat = $this->conect($id);
        return ($dat['dependen']);
    }

    public function conect($id) { //Esta funcion complementa la anterior, aqui se aplica el active record del framework
        $this->db->where('id_dependencia', $id);
        $this->db->select('dependen');
        $query = $this->db->get('dec_dependencia');
        return $query->row_array();
    }

    public function set_newDependencia($array='') //Aqui se guardara la nueva dependencia usando un array que contiene el id y el nombre
    {
        if(!empty($array))
        {
            $this->db->insert('dec_dependencia',$array);
            return $this->db->insert_id();
        }
        return FALSE;
    }

    public function edit_dependencia($array='') // Para editar la dependencia a la cual se le pasan los datos en array igual que el anterior 
    {
        if(!empty($array))
        {
            $this->db->where('id_dependencia',$array['id_dependencia']); // usando active record del framework
            $this->db->update('dec_dependencia',$array);
            return $array['id_dependencia'];
        }
        return FALSE;
    }
    
    public function exist($id_dependencia='',$dependen='')//Verifica que existe la dependencia pasando el id
    {
        if ($id_dependencia != ''):
            $query = $this->db->get_where('dec_dependencia',$id_dependencia);
        endif;
        if ($dependen != ''):
            $query = $this->db->get_where('dec_dependencia',$dependen);
        endif;
        if($query->num_rows() > 0):
            return TRUE;
        endif;
        return FALSE;
    }
}
