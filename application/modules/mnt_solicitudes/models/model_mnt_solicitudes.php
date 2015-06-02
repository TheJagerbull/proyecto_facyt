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
        if ((!empty($field)) && (!empty($order))) {// evalua el campo orden tambien para poder ordenar por max_id
            $this->db->order_by($field, $order);
        } else {
            $this->db->order_by("id_orden", "desc");
        }

        $query = $this->unir_tablas($per_page, $offset);
        $query = $this->db->get('mnt_orden_trabajo', $per_page, $offset);
        //die_pre($query->result());
        return $query->result();
    }

    public function unir_tablas() {//funcion para unir las tablas con llaves foraneas y devuelve todo en una variable
//agregado el join, funciona de la siguiente manera:
//$this->db->join('tabla que contiene la clave','tabla que contiene la clave.campo que la relaciona'='tabla principal.campo de relacion̈́','INNER')
        $unir = $this->db->join('mnt_tipo_orden', 'mnt_tipo_orden.id_tipo = mnt_orden_trabajo.id_tipo', 'INNER');
        $this->db->join('dec_dependencia', 'dec_dependencia.id_dependencia = mnt_orden_trabajo.dependencia', 'INNER');
        $this->db->join('mnt_ubicaciones_dep', 'mnt_ubicaciones_dep.id_ubicacion = mnt_orden_trabajo.ubicacion', 'INNER');
        $this->db->join('mnt_observacion_orden', 'mnt_observacion_orden.id_orden_trabajo = mnt_orden_trabajo.id_orden', 'INNER');
        $this->db->join('mnt_estatus_orden', 'mnt_estatus_orden.id_orden_trabajo = mnt_orden_trabajo.id_orden', 'INNER');
        $this->db->join('mnt_estatus', 'mnt_estatus.id_estado = mnt_estatus_orden.id_estado', 'INNER');
        $this->db->join('mnt_asigna_cuadrilla', 'mnt_asigna_cuadrilla.id_ordenes = mnt_orden_trabajo.id_orden', 'LEFT');
        $this->db->join('mnt_cuadrilla', 'mnt_cuadrilla.id = mnt_asigna_cuadrilla.id_cuadrilla ', 'LEFT');
//        $this->db->join('mnt_ayudante_orden', 'mnt_ayudante_orden.id_orden_trabajo = mnt_orden_trabajo.id_orden', 'LEFT');
        //$this->db->select('id_usuario','nombre','apellido');
        //$this->db->from('dec_usuario');
        //$this->db->join('dec_usuario', 'dec_usuario.id_usuario = mnt_cuadrilla.id_trabajador_responsable', 'LEFT');
        return $unir;
    }

    public function get_orden($id_orden = '') {
        if (!empty($id_orden)) {
            $this->db->where('id_orden', $id_orden);
            $query = $this->unir_tablas();
            $query = $this->db->get('mnt_orden_trabajo');
            return $query->row_array();
        }
        return FALSE;
    }

    public function buscar_sol($orden = '', $field = '', $order = '', $per_page = '', $offset = '') {
        //die('llega');
       // echo_pre($order);
        if (!empty($orden)) {

            if (!empty($field)) {
                $this->db->order_by($field, $order);   
            }
            $orden = preg_split("/[,]+/", $orden);
            $first = $orden[0];
            if (!empty($orden[1])) {
                $second = $orden[1];
                $this->db->like('dependen', $second);
            }
            if (!empty($orden[2])) {
                $third = $orden[2];
                $this->db->like('descripcion', $third);
            }
            if (!empty($orden[3])) {
                $four = $orden[3];
                $this->db->like('cuadrilla', $four);
            }
//            if (!empty($orden[4])) {
//                $five = $orden[4];
//                $this->db->like('cuadrilla', $five);
//            }           
                    
            $this->db->like('id_orden', $first);
            $this->db->or_like('dependen', $first);
            $this->db->or_like('descripcion', $first);
            $this->db->or_like('cuadrilla', $first);
            //echo_pre($orden);
            //echo_pre($first);
            $query = $this->unir_tablas();
            //die_pre($this->unir_tablas());
            if (!empty($per_page) && !empty($offset)) {
                $query = $this->db->get('mnt_orden_trabajo', $per_page, $offset);
                return $query->result();
            } else {
                //echo_pre($query);
                $query = $this->db->get('mnt_orden_trabajo',$per_page, $offset);
                return $query->result();
            }
            
        }
       
        return FALSE;
    }
    
    public function buscar_solCount($orden='')
	{
           if (!empty($orden)) {
            $orden = preg_split("/[\s,]+/", $orden);
            $first = $orden[0];
           
            if (!empty($orden[1])) {
                $second = $orden[1];
                $this->db->like('dependen', $second);
            }
            if (!empty($orden[2])) {
                $third = $orden[2];
                $this->db->like('descripcion', $third);
            }
             if (!empty($orden[3])) {
                $four = $orden[3];
                $this->db->like('cuadrilla', $four);
            }
//            if (!empty($orden[4])) {
//                $five = $orden[4];
//                $this->db->like('cuadrilla', $five);
//            }
            $this->db->like('id_orden', $first);
            $this->db->or_like('dependen', $first);
            $this->db->or_like('descripcion', $first);
            $this->db->or_like('cuadrilla', $first);
            $query = $this->unir_tablas();
            return $this->db->count_all_results('mnt_orden_trabajo');
        }
        return FALSE;
    }

    // FUNCION PARA INSERTAR -- FORMULARIO NATALY
    public function insert_orden($data1 = '') {
        if (!empty($data1)) {
            //die_pre($data1);
            $this->db->insert('mnt_orden_trabajo', $data1);
            return $this->db->insert_id();
        }
        return FALSE;
    }

    public function get_last_id() {//retorna un entero resultante del ultimo registro del campo id de la tabla mnt_orden_trabajo
        $this->db->select_max('id');
        $query = $this->db->get('mnt_orden_trabajo');
        $row = $query->row();
        return($row->id); // actualmetne es utilizado para generar el numero de Solicitud
    }

    public function ajax_likeSols($data)
	{
            $query = $this->unir_tablas();
            $this->db->like('id_orden', $data);
            $this->db->or_like('cuadrilla',$data);
            $this->db->or_like('dependen',$data);
	    $this->db->or_like('descripcion',$data);
            //$this->db->or_like('estatus',$data);
             $query= $this->db->get('mnt_orden_trabajo');	
	     return $query->result();
	}

}
