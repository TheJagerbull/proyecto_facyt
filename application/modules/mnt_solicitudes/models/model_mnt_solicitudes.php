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
        $query = $this->unir_todo($per_page,$offset);
        return $query;
    }
 
    public function unir_todo($per_page= '',$offset = ''){
        $this->db->join('mnt_tipo_orden', 'mnt_tipo_orden.id_tipo = mnt_orden_trabajo.id_tipo', 'INNER');
        $this->db->join('dec_dependencia', 'dec_dependencia.id_dependencia = mnt_orden_trabajo.dependencia', 'INNER');
        $this->db->join('mnt_ubicaciones_dep', 'mnt_ubicaciones_dep.id_ubicacion = mnt_orden_trabajo.ubicacion', 'INNER');
        $this->db->join('mnt_observacion_orden', 'mnt_observacion_orden.id_orden_trabajo = mnt_orden_trabajo.id_orden', 'INNER');
        $this->db->join('mnt_estatus_orden', 'mnt_estatus_orden.id_orden_trabajo = mnt_orden_trabajo.id_orden', 'INNER');
        $this->db->join('mnt_estatus', 'mnt_estatus.id_estado = mnt_estatus_orden.id_estado', 'INNER');
        $this->db->join('mnt_ayudante_orden', 'mnt_ayudante_orden.id_orden_trabajo = mnt_orden_trabajo.id_orden' , 'LEFT');
        $this->db->join('dec_usuario', 'dec_usuario.id_usuario = mnt_ayudante_orden.id_responsable', 'LEFT');
        $resultado = $this->db->get('mnt_orden_trabajo', $per_page, $offset);
        return $resultado->result();
    }
    
    public function unir_unaconsulta(){
        $this->db->join('mnt_tipo_orden', 'mnt_tipo_orden.id_tipo = mnt_orden_trabajo.id_tipo', 'INNER');
        $this->db->join('dec_dependencia', 'dec_dependencia.id_dependencia = mnt_orden_trabajo.dependencia', 'INNER');
        $this->db->join('mnt_ubicaciones_dep', 'mnt_ubicaciones_dep.id_ubicacion = mnt_orden_trabajo.ubicacion', 'INNER');
        $this->db->join('mnt_observacion_orden', 'mnt_observacion_orden.id_orden_trabajo = mnt_orden_trabajo.id_orden', 'INNER');
        $this->db->join('mnt_estatus_orden', 'mnt_estatus_orden.id_orden_trabajo = mnt_orden_trabajo.id_orden', 'INNER');
        $this->db->join('mnt_estatus', 'mnt_estatus.id_estado = mnt_estatus_orden.id_estado', 'INNER');
        $this->db->join('mnt_ayudante_orden', 'mnt_ayudante_orden.id_orden_trabajo = mnt_orden_trabajo.id_orden' , 'LEFT');
        $this->db->join('dec_usuario', 'dec_usuario.id_usuario = mnt_ayudante_orden.id_responsable', 'LEFT');
        $resultado = $this->db->get('mnt_orden_trabajo');
        return $resultado->row();
        
    }

    public function get_orden($id_orden = '') {
        if (!empty($id_orden)) {
            $this->db->where('id_orden', $id_orden);
            $query = $this->unir_unaconsulta();
            return $query;
        }
        return FALSE;
    }
    
    public function buscar_sol($usr = '', $field = '', $order = '', $per_page = '', $offset = '') {
        die('llega');
        if (!empty($usr)) {
            
            if (!empty($field)) {
                $this->db->order_by($field, $order);
            }
            $usr = preg_split("/[\s,]+/", $usr);
            $first = $usr[0];
            if (!empty($usr[1])) {
                $second = $usr[1];
                $this->db->like('id_orden', $second);
            }
            if (!empty($usr[2])) {
                $third = $usr[2];
                $this->db->like('id_tipo', $third);
            }
            $this->db->like('id_orden', $first);
            $this->db->or_like('id_tipo', $first);
            $this->db->or_like('id_usuario', $first);
            $this->db->or_like('sys_rol', $first);
            $this->db->or_like('dependencia', $first);
            $this->db->or_like('cargo', $first);
            $this->db->or_like('status', $first);

            return $this->db->get('mnt_orden_trabajo', $per_page, $offset)->result();
        }
        return FALSE;
    }
    
    public function ajax_likeSol($data)
    {        die('NADA');
	        $this->db->like('id_orden', $data);
//		$this->db->or_like('dependen',$data);
//		$this->db->or_like('descripcion',$data);
////		$query = $this->unir_todo();
//		return $query;
                $query = $this->db->get('mnt_orden_trabajo');
		return $query->result();
	}

}
