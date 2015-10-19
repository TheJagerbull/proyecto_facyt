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
     * En este metodo, se hace una busqueda de todos los miembros activos de  
     * una cuadrilla especificada
     * Usada en: vista ver_cuadrilla y controlador cuadrilla/detalle_cuadrilla
     * @author Jhessica_Martinez  en fecha: 12/06/2015
     * Modificada por Juan Parra en fecha: 02/07/2015 con la finalidad de extraer los 
     * miembros activos de la cuadrilla con sus nombres
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
                    unset($miembros[$i]); //elimina el registro del usuario que no este activo
                endif;
                $i++;
            endforeach;
            $miembros = array_values($miembros); //repara el indice que quedo mal distribuido al eliminar el trabajador de la cuadrilla inactivo
            return $miembros;
        }
        return FALSE;
    }

    public function guardar_miembros($datos = '') {
        if (!empty($datos)) { //verifica que no se haga una insercion vacia
            $this->db->insert('mnt_miembros_cuadrilla', $datos);
            return $this->db->insert_id();
        }
        return FALSE;
    }
    
    public function borrar_by_id($id)
	{
            $this->db->where('id_trabajador', $id);
	    $this->db->delete('mnt_miembros_cuadrilla');
	}

}
