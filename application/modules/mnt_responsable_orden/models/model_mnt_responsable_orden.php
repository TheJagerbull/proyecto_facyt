<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Model_mnt_responsable_orden extends CI_Model {

    //constructor predeterminado del modelo
    function __construct() {
        parent::__construct();
    }

    public function set_resp($data = '') { //funcion para guardar el responsable de una solicitud
        if (!empty($data)) {
             if (!$this->existe_resp($data)):
            //die_pre($data4);
                $this->db->insert('mnt_responsable_orden', $data);
                return TRUE;
            endif;
        }
        return FALSE;
    }
    
    public function existe_resp($data='') //funcion para verificar si existe un responsable en la solicitud
    {
        $this->db->where($data);
        if($this->db->count_all_results('mnt_responsable_orden') > 0):
            return TRUE;
        endif;
        return FALSE;
    }
    
    function get_responsable($sol=''){ //funcion para obtener el responsable de la solicitud
        
        $this->db->where('id_orden_trabajo',$sol);
        if($this->db->count_all_results('mnt_responsable_orden') > 0):
           $this->db->where('id_orden_trabajo',$sol);
           $this->db->join('dec_usuario', 'dec_usuario.id_usuario = mnt_responsable_orden.id_responsable', 'inner');
           $this->db->select('id_responsable , nombre , apellido');
           $query = $this->db->get('mnt_responsable_orden');
           return $query->row_array();
        endif;
        return FALSE; 
    }
            
    function edit_resp($data = '',$resp_orden=''){ //funcion para editar el responsable de la solicitud
        $this->db->where($data);
        $this->db->update('mnt_responsable_orden',array('id_responsable' => $resp_orden));
    }

    function del_resp($sol=''){ //funcion para eliminar un responsable
        $this->db->delete('mnt_responsable_orden',array('id_orden_trabajo' => $sol));
    }
    
//    public function tiene_cuadrilla($id_orden_trabajo) {
//        $aux = array('id_ordenes' => $id_orden_trabajo);
//        $this->db->where($aux);
//        $this->db->group_by('id_ordenes');
//        $this->db->from('mnt_asigna_cuadrilla');
//        $cuadrilla = $this->db->get()->result_array()[0]['id_cuadrilla'];
//        if (!empty($cuadrilla)) {
//            return($cuadrilla);
//        } else {
//            return(FALSE);
//        }
//    }

    public function es_respon_orden($respon_orden='',$sol=''){ //funcion para verificar si es reponsable de una orden
        $datos = array (
            'id_responsable' => $respon_orden,
            'id_orden_trabajo' =>$sol
        );
        $query = $this->db->get_where('mnt_responsable_orden',$datos);
        if($query->num_rows() > 0)
            return TRUE;

        return FALSE;
        
    }

}
