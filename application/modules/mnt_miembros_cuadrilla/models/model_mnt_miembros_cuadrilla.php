<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Model_mnt_miembros_cuadrilla extends CI_Model {

    //constructor predeterminado del modelo
    function __construct() {
        parent::__construct();
    }

    //Aporte de Juan Parra

    public function get_miembros() {
        return $this->db->get('mnt_miembros_cuadrilla')->result();
    }

    /**
     * get_miembros_cuadrilla
     * =====================
     * En este metodo, se hace una busqueda de todos los miembros de  
     * una cuadrilla especificada
     * Usada en: vista ver_cuadrilla y controlador cuadrilla/detalle_cuadrilla
     * @author Jhessica_Martinez  en fecha: 12/06/2015
     */
    public function get_miembros_cuadrilla($id) {
        if (!empty($id)) {
            $this->db->where('id_cuadrilla', $id);
            $this->db->select('id_trabajador');
            $miembros = $this->db->get('mnt_miembros_cuadrilla')->result();
            $i = 0;
            foreach ($miembros as $miemb):
                $new[$i]['miembros'] = $this->model_user->get_user_cuadrilla($miemb->id_trabajador);
                if (!empty($new[$i]['miembros'])):  //Valida que esto no retorne vacio, ya que al retornar vacio quiere decir que el trabajador esta inactivo
                    $miemb->trabajador = $new[$i]['miembros'];
                else:
                     unset($miembros[$i]);//elimina el registro del usuario que no este activo
                endif;
                $i++;
            endforeach;
            $miembros = array_values($miembros);//repara el indice que quedo mal distribuido al eliminar el trabajador de la cuadrilla inactivo
            return $miembros;
        }
        return FALSE;
    }

}
