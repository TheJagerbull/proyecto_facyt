<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Model_mnt_ubicaciones_dep extends CI_Model {

    //constructor predeterminado del modelo
    function __construct() {
        parent::__construct();
    }

    
    public function get_ubicaciones() 
    {
        $query = $this->db->get('mnt_ubicaciones_dep');
        return $query->result();
    }
    
    public function get_ubicaciones_dependencia($dependen) 
    {    
        $this->db->where('id_dependencia',$dependen);
	    $this->db->order_by('oficina','asc');
	    $oficina = $this->db->get('mnt_ubicaciones_dep');
	    if($oficina->num_rows()>0)
	   {
	       return $oficina->result();
	   }
	
    }

    // funcion para para devolver solo el id de ubicacion ya que a llamar funcion se obtiene un arreglo con el nombre y id de ubicacion
    public function get_oficina_null($dependen) 
    {   
        $oficina = $this->obtener($dependen);
        return ($oficina['id_ubicacion']);

    }

    //funcion para obtener el id de ubicacion en general 
    public function obtener_ubicacion($id_dependen,$id_oficina) {
        $this->db->where('id_ubicacion', $id_oficina);
        $this->db->where('id_dependencia', $id_dependen);
        $this->db->select('oficina');
        $oficina = $this->db->get('mnt_ubicaciones_dep')->row_array();
        return ($oficina['oficina']);
    }
    //funcion para obtener el id de ubicacion cuando la oficina sea igual a N/A
    public function obtener($id_dependen) {
        $this->db->where("oficina = 'N/A' AND id_dependencia = $id_dependen");
        $this->db->select('id_ubicacion');
        $oficina = $this->db->get('mnt_ubicaciones_dep');
        return ($oficina->row_array());
    }
    
    public function get_total_ubica() {
        return($this->db->count_all('mnt_ubicaciones_dep'));
    }

    

    public function insert_orden($data3 = '')
    {
        //die_pre($data3);
        if (!empty($data3))
        {
            $this->db->insert('mnt_ubicaciones_dep', $data3);
            return $this->db->insert_id();
            
        }
        return FALSE;
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
}
