<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Model_mnt_solicitudes extends CI_Model {

    //constructor predeterminado del modelo
    function __construct() {
        parent::__construct();
    }

    public function get_all() {
        return($this->db->count_all('mnt_orden_trabajo'));
    }

    //la funcion se usa para mostrar los usuarios de la base de datos en alguna tabla...
    //para filtrar los roles, y cualquier dato de alguna columna, se debe realizar con condicionales desde la vista en php
    public function get_allorden($field = '', $order = '', $per_page = '', $offset = '') {
        // SE EXTRAEN TODOS LOS DATOS DE TODOS LOS USUARIOS
//$campos = $this->db->list_fields('mnt_orden_trabajo');

//foreach ($campos as $campo)
//{
//   echo $campo;
//   echo "<br>";
//   
//}
//$consulta = $this->db->query('SELECT * FROM mnt_orden_trabajo');
//
//foreach ($consulta->list_fields() as $campo)
//{
//   echo $campo;
//   echo "<br>";
//}
//        
//        $campos = $this->db->field_data('mnt_orden_trabajo');
//
//foreach ($campos as $campo)
//{
//   echo $campo->name . "/";
//   echo $campo->type . "/";
//   echo $campo->max_length . "/";
//   echo $campo->primary_key . "/";
//   echo "<br>";
//}
        
  
        if ((!empty($field)) && (!empty($order))) {// evalua el campo orden tambien para poder ordenar por max_id
            $this->db->order_by($field, $order);
            $query = $this->db->get('mnt_orden_trabajo', $per_page, $offset);
            return $query->result();
        } else {
            $this->db->order_by("id_orden", "desc");
            $query = $this->db->get('mnt_orden_trabajo', $per_page, $offset);
            return $query->result();
        }
    }

}


