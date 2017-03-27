<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Model_tic_tipo_orden extends CI_Model {

    //constructor predeterminado del modelo
    function __construct() {
        parent::__construct();
    }

    public function devuelve_tipo($id_tipo = '') { // funcion para obtener el tipo de solicitud
        //die_pre('hola');
        if($id_tipo == ''):
            $this->db->order_by('tipo_orden','asc');
        else:
            $this->db->where('id_tipo',$id_tipo);
        endif;
        $consulta = $this->db->get('tic_tipo_orden');
        return $consulta->result();
    }

    public function set_tipo_orden($data = '') { //funcion se usa para que tipo de solicitud sea igual al de la cuadrilla
        if (!empty($data)) { //verifica que no se haga una insercion vacia
            $this->db->insert('tic_tipo_orden', $data); // $data es el nombre del tipo de solicitud
            return $this->db->insert_id();
        }
        return FALSE;
    }

    public function devuelve_id_tipo($tipo_orden = '') { // funcion para obtener el tipo de solicitud
        //die_pre('hola');
        if($tipo_orden == ''):
            $this->db->order_by('tipo_orden','asc');
        else:
            $this->db->where('tipo_orden',$tipo_orden);
            $this->db->select('id_tipo');
        endif;
        $consulta = $this->db->get('tic_tipo_orden');
        if($consulta->num_rows() > 0):
            $id = $consulta->row_array();
//            die_pre($id);
            return $id['id_tipo'];
        else:
            return FALSE;
        endif;
    }
}
