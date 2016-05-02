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
        $this->db->join('mnt_orden_trabajo', 'mnt_orden_trabajo.id_orden = mnt_responsable_orden.id_orden_trabajo', 'INNER');
        $this->db->join('mnt_estatus', 'mnt_estatus.id_estado = mnt_orden_trabajo.estatus', 'INNER');
        $this->db->where($data);
        if($this->db->count_all_results('mnt_responsable_orden') > 0):
            return TRUE;
        endif;
        return FALSE;
    }
    
    public function existe_resp_2($id_usuario,$status,$fecha1,$fecha2) //funcion para verificar si existe un responsable en la solicitud con fechas
    {
        $this->db->join('mnt_orden_trabajo', 'mnt_orden_trabajo.id_orden = mnt_responsable_orden.id_orden_trabajo', 'INNER');
        $this->db->join('mnt_estatus', 'mnt_estatus.id_estado = mnt_orden_trabajo.estatus', 'INNER');
        if (!empty($fecha1 && $fecha2)):
            $this->db->where('fecha BETWEEN"' . $fecha1 . '"AND"' . $fecha2 . '"');
        endif;
        if (!empty($status)):
            $this->db->where('estatus', $status);
        endif;
        if (!empty($id_usuario)):
            $this->db->where('id_responsable', $id_usuario);
        endif;
        $query = $this->db->get('mnt_responsable_orden')->result();
        if (!empty($query)):
            return TRUE;
        else:
            return FALSE;
        endif;
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
    
     public function consul_respon_sol($id_usuario='',$status='',$fecha1='',$fecha2='',$band=''){
        $this->db->join('mnt_orden_trabajo', 'mnt_orden_trabajo.id_orden = mnt_responsable_orden.id_orden_trabajo', 'INNER');
        $this->db->join('mnt_estatus', 'mnt_estatus.id_estado = mnt_orden_trabajo.estatus', 'INNER');
        $this->db->join('mnt_asigna_cuadrilla', 'mnt_asigna_cuadrilla.id_ordenes = mnt_responsable_orden.id_orden_trabajo', 'INNER');
        $this->db->join('mnt_cuadrilla', 'mnt_cuadrilla.id = mnt_asigna_cuadrilla.id_cuadrilla', 'INNER');
//        $this->db->join('mnt_miembros_cuadrilla', 'mnt_miembros_cuadrilla.id_cuadrilla = mnt_asigna_cuadrilla.id_cuadrilla', 'INNER');
        $this->db->join('dec_usuario', 'dec_usuario.id_usuario = mnt_responsable_orden.id_responsable', 'INNER');
        $this->db->join('dec_dependencia', 'dec_dependencia.id_dependencia = mnt_orden_trabajo.dependencia', 'INNER');
        $this->db->select('id_responsable,tiene_cuadrilla,id_cuadrilla,cuadrilla,id_orden,nombre AS Nombre, apellido AS Apellido,id_orden_trabajo AS Orden,dependen AS Dependencia,asunto AS Asunto');
        if (!empty($fecha1 && $fecha2)):
            $this->db->where('fecha BETWEEN"' . $fecha1 . '"AND"' . $fecha2 . '"');
        endif;
        if (!empty($status)):
            $this->db->where('estatus', $status);
        endif;
        if (!empty($id_usuario)):
            $this->db->where('id_responsable', $id_usuario);
        else:
            $this->db->order_by('nombre,apellido');
            $this->db->group_by('id_responsable,id_orden_trabajo');
        endif;
        $query = $this->db->get('mnt_responsable_orden')->result_array();
//            echo_pre($query);
//        die_pre($query);
        if (!empty($query)):
            if ($band) {//Se evalua si la data necesita retornar datos o solo es consultar datos
                return $query;
            } else {
                return TRUE;
            }
        else:
            return FALSE;
        endif;
    }

}
