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
        // SE EXTRAEN TODOS LOS DATOS DE LA TABLA 
        // 
        //agregado el join, funciona de la siguiente manera:
//$this->db->join('tabla que contiene la clave','tabla que contiene la clave.campo que la relaciona'='tabla principal.campo de relacion̈́','INNER')
        if ((!empty($field)) && (!empty($order))) {// evalua el campo orden tambien para poder ordenar por max_id
            $this->db->order_by($field, $order);
        } else {
            $this->db->order_by("id_orden", "desc");
        }
        $this->db->join('mnt_tipo_orden', 'mnt_tipo_orden.id_tipo = mnt_orden_trabajo.id_tipo', 'INNER');
        $this->db->join('dec_dependencia', 'dec_dependencia.id_dependencia = mnt_orden_trabajo.dependencia', 'INNER');
        $this->db->join('mnt_ubicaciones_dep', 'mnt_ubicaciones_dep.id_ubicacion = mnt_orden_trabajo.ubicacion', 'INNER');
        $this->db->join('mnt_observacion_orden', 'mnt_observacion_orden.id_orden_trabajo = mnt_orden_trabajo.id_orden', 'INNER');
        $this->db->join('mnt_estatus_orden', 'mnt_estatus_orden.id_orden_trabajo = mnt_orden_trabajo.id_orden', 'INNER');
        $this->db->join('mnt_estatus', 'mnt_estatus.id_estado = mnt_estatus_orden.id_estado', 'INNER');
        $this->db->join('mnt_ayudante_orden', 'mnt_ayudante_orden.id_orden_trabajo = mnt_orden_trabajo.id_orden' , 'LEFT');
        $this->db->join('dec_usuario', 'dec_usuario.id_usuario = mnt_ayudante_orden.id_responsable', 'LEFT');
        $query = $this->db->get('mnt_orden_trabajo', $per_page, $offset);
        return $query->result();
    }

    public function get_orden($id_orden = '') {
        if (!empty($id_orden)) {
            $this->db->where('id_orden', $id_orden);
           // SE EXTRAEN TODOS LOS DATOS DE LA SOLICITUD
            $this->db->order_by("id_orden", "desc");
            $this->db->join('mnt_tipo_orden', 'mnt_tipo_orden.id_tipo = mnt_orden_trabajo.id_tipo', 'INNER');
            $this->db->join('dec_dependencia', 'dec_dependencia.id_dependencia = mnt_orden_trabajo.dependencia', 'INNER');
            $this->db->join('mnt_ubicaciones_dep', 'mnt_ubicaciones_dep.id_ubicacion = mnt_orden_trabajo.ubicacion', 'INNER');
            $this->db->join('mnt_observacion_orden', 'mnt_observacion_orden.id_orden_trabajo = mnt_orden_trabajo.id_orden', 'INNER');
            $this->db->join('mnt_estatus_orden', 'mnt_estatus_orden.id_orden_trabajo = mnt_orden_trabajo.id_orden', 'INNER');
            $this->db->join('mnt_estatus', 'mnt_estatus.id_estado = mnt_estatus_orden.id_estado', 'INNER');
            $this->db->join('mnt_ayudante_orden', 'mnt_ayudante_orden.id_orden_trabajo = mnt_orden_trabajo.id_orden', 'LEFT');
            $this->db->join('dec_usuario', 'dec_usuario.id_usuario = mnt_ayudante_orden.id_responsable', 'LEFT');
            $query = $this->db->get('mnt_orden_trabajo');
            return $query->row();
        }
        return FALSE;
    }
 
}
