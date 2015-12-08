<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Model_mnt_responsable_orden extends CI_Model {

    //constructor predeterminado del modelo
    function __construct() {
        parent::__construct();
    }

    public function set_resp($data = '') {
        if (!empty($data)) {
            //die_pre($data4);
            $this->db->insert('mnt_responsable_orden', $data);
        }
        return FALSE;
    }
    
    function edit_resp($data = '',$resp_orden=''){
        $this->db->where($data);
        $this->db->update('mnt_responsable_orden',array('id_responsable' => $resp_orden));
    }

    function del_resp($sol=''){
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

    public function es_respon_orden($respon_orden='',$sol=''){
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
