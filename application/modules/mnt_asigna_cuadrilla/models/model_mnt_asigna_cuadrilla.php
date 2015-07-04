<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Model_mnt_asigna_cuadrilla extends CI_Model {

    //constructor predeterminado del modelo
    function __construct() {
        parent::__construct();
    }

    public function get_allasigna() {
//        //$cuadrilla = $this->db->get('mnt_asigna_cuadrilla')->result();
////        echo_pre($cuadrilla);
//        $i = 0;
//        foreach ($cuadrilla as $cua):
//            $test = $this->model_cuadrilla->get_oneitem($cua->id_cuadrilla);
//            $id[$i]['nombre'] = $this->model_user->get_user_cuadrilla($test['id_trabajador_responsable']);
//            $cua->responsable = $id[$i]['nombre'];
//            $cua->nombre = $test['cuadrilla'];
////            $this->db->where('id_orden_trabajo', $cua->id_ordenes);
//            $miembros = $this->db->get('mnt_ayudante_orden')->result();
////            echo_pre($miembros);
////            $miembros = $this->model_miembros_cuadrilla->get_miembros_cuadrilla($cua->id_cuadrilla);
//            $z=0;
//            foreach ($miembros as $miem)://hay que validar que sean los que estan asignados a la orden que estan en la tabla trabajador responsable
//                if ($miem->id_orden_trabajo == $cua->id_ordenes):
//                $nom[$z]['nombre'] = $this->model_user->get_user_cuadrilla($miem->id_trabajador);
////               if (!empty($nom[$z]['nombre'])):
//                   $cua->miembros[] = $nom[$z]['nombre'];
//               endif;
//               $z++;
//            endforeach;
//           
//            $i++;
//        endforeach;
//        //die_pre('hola');
//
//
//        return $cuadrilla;
    }

    public function set_cuadrilla($data = '') {
        if (!empty($data)) {
            //die_pre($data4);
            $this->db->insert('mnt_asigna_cuadrilla', $data);
        }
        return FALSE;
    }

    public function get($id) {
        
    }

}
