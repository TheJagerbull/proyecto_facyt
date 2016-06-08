<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Model_mnt_estatus_orden extends CI_Model {

    //constructor predeterminado del modelo
    function __construct() {
        parent::__construct();
    }

    public function insert_orden($data4 = '') { // funcion para guardar el estatus
        if (!empty($data4)) {
            // die_pre($data4);
            $this->db->insert('mnt_estatus_orden', $data4);
        }
        return FALSE;
    }
    
    public function change_status($data = '',$id_orden='') {
        if (!empty($data)) {
//            $this->db->where('id_orden_trabajo', $id_orden);
            $this->db->insert('mnt_estatus_orden', $data);
        }
        return FALSE;
    }
    
    public function get_first_fecha ($id=''){ // funcion que permite traer la primera fecha de la solicitud
        $this->db->select_min('fecha_p');
        $this->db->where('id_orden_trabajo',$id);
        $fecha = $this->db->get('mnt_estatus_orden')->result_array();
    return $fecha['0']['fecha_p'];
    }
    
    public function get_user_make_sol ($id_orden=''){ // funcion que permite obtener el usuario que creo la solicitud
        $this->db->select_min('fecha_p');
        $this->db->select('id_usuario');
        $this->db->where('id_orden_trabajo',$id_orden);
        $creada = $this->db->get('mnt_estatus_orden')->result_array();
    return $creada['0']['id_usuario'];
    }

}
