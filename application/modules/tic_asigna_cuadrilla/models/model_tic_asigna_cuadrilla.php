<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Model_tic_asigna_cuadrilla extends CI_Model {

    //constructor predeterminado del modelo
    function __construct() {
        parent::__construct();
    }

    public function get_allasigna() {
        $this->db->select('id_cuadrilla , cuadrilla');
        $this->db->join('tic_cuadrilla', 'tic_cuadrilla.id = tic_asigna_cuadrilla.id_cuadrilla','right');
        $cuadrilla = $this->db->get('tic_asigna_cuadrilla')->result_array();
//        echo_pre($cuadrilla);
////        echo_pre($cuadrilla);
        return $cuadrilla;
    }

    public function set_cuadrilla($data = '') {//guarda la cuadrilla asignada en la base de datos
        if (!empty($data)) {
            //die_pre($data4);
            $this->db->insert('tic_asigna_cuadrilla', $data);
        }
        return FALSE;
    }

    public function quitar_cuadrilla($data = '') {//para eliminar la cuadrilla asignada a una orden, se le pasa un array('id_orden_trabajo'=> id de la orden con el cambio de estatus)
        if (!empty($data)) {
            $this->db->where($data);
            $this->db->delete('tic_asigna_cuadrilla');
        }
        return FALSE;
    }

    public function tiene_cuadrilla($id_orden_trabajo) {//Evalua si una orden tiene cuadrilla asignada
        $aux = array('id_ordenes' => $id_orden_trabajo);
        $this->db->where($aux);
        $this->db->group_by('id_ordenes');
        $this->db->from('tic_asigna_cuadrilla');
        $cuadrilla = $this->db->get()->result_array()[0]['id_cuadrilla'];
        if (!empty($cuadrilla)) {
            return($cuadrilla);
        } else {
            return(FALSE);
        }
    }

    function asignados_cuadrilla_ayudantes($cuadrilla, $ayudantes,&$final_ayudantes,&$miembros) {
        if (!empty($cuadrilla))://revisa si no esta vacio para buscar los miembros de la cuadrilla y ayudantes en caso de estar asignados
            foreach ($cuadrilla as $i => $miemb):
                foreach ($ayudantes as $z => $asig):
                    if ($miemb['id_trabajador'] == $asig['id_usuario']):
                        unset($ayudantes[$z]);
                    endif;
                endforeach;
            endforeach;
            $ayudantes = array_values($ayudantes);
            foreach ($cuadrilla as $cuad): //Para obtener los nombres de los miembros de la cuadrilla
                $miembros[] = $this->model_user->get_user_cuadrilla($cuad['id_trabajador']);
            endforeach;
            foreach ($ayudantes as $z => $asig):
                $final_ayudantes[] = $asig['nombre'] . (' ') . $asig['apellido'];
            endforeach;
        else:
            foreach ($ayudantes as $z => $asig):
                $final_ayudantes[] = $asig['nombre'] . (' ') . $asig['apellido'];
            endforeach;
        endif;
    }
    
    public function consul_cuad_sol($id_cuadrilla='',$status='',$fecha1='',$fecha2='',$band=''){
//         if(!empty($id_cuadrilla)):
            $this->db->join('tic_orden_trabajo', 'tic_orden_trabajo.id_orden = tic_asigna_cuadrilla.id_ordenes', 'INNER');
            $this->db->join('mnt_estatus', 'mnt_estatus.id_estado = tic_orden_trabajo.estatus', 'INNER');
            $this->db->join('tic_cuadrilla', 'tic_cuadrilla.id = tic_asigna_cuadrilla.id_cuadrilla', 'INNER');
            $this->db->join('tic_responsable_orden', 'tic_responsable_orden.id_orden_trabajo = tic_orden_trabajo.id_orden', 'INNER');
            $this->db->join('dec_usuario', 'dec_usuario.id_usuario = tic_responsable_orden.id_responsable', 'INNER');
            $this->db->join('dec_dependencia', 'dec_dependencia.id_dependencia = tic_orden_trabajo.dependencia', 'INNER');
            $this->db->select('id_responsable,tiene_cuadrilla,id_cuadrilla,cuadrilla,id_orden,fecha,nombre AS Nombre, apellido AS Apellido,id_orden_trabajo AS Orden,dependen AS Dependencia,asunto AS Asunto');
            if(!empty($fecha1) && ($fecha2)):
                $this->db->where('fecha BETWEEN"'. $fecha1 .'"AND"'. $fecha2.'"');
            endif;
            if(!empty($status)):
                $this->db->where('estatus', $status);
            endif;
            if(!empty($id_cuadrilla)):
                $this->db->where('id_cuadrilla', $id_cuadrilla);
            else:
                $this->db->order_by('cuadrilla');
                $this->db->group_by('id_cuadrilla,id_orden_trabajo');
            endif;
            $query = $this->db->get('tic_asigna_cuadrilla')->result_array();
            //die_pre($query);
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
