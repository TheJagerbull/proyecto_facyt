<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Model_mnt_cuadrilla extends CI_Model {

    //constructor predeterminado del modelo
    function __construct() {
        parent::__construct();
    }
        var $table = 'mnt_miembros_cuadrilla';
        var $table2 = 'dec_usuario';
	var $column = array('nombre','apellido');
	var $order = array('nombre' => 'desc');

    //consulta si un id o nombre de cuadrilla existe en la base de datos
    public function exist($eq) {
        if (!empty($eq)) {
            $this->db->like('id', $eq);
            $this->db->or_like('cuadrilla', $eq);

            return TRUE;
        }
        return FALSE;
        //	funcion anterior
        //  $this->db->where('id',$id);
        //	$query = $this->db->get('mnt_cuadrilla');
        //  if($query->num_rows() > 0)
        //        return TRUE;
        //    return FALSE;
    }

    //la funcion se usa para mostrar los items de la tabla...
    //para filtrar los roles, y cualquier dato de alguna columna, 
    //se debe realizar con condicionales desde la vista en php
    public function get_allitem($field = '', $order = '') {
        // SE EXTRAEN TODOS LOS DATOS DE TODAS LAS CUADRILLAS DADO UN ORDEN
        if (!empty($field))
            $this->db->order_by($field, $order);
        $query = $this->db->get('mnt_cuadrilla');
        return $query->result();
    }

    // SE EXTRAEN TODOS LOS DATOS DE TODAS LAS CUADRILLAS SIN UN ORDEN ESPECIFICO
    public function get_cuadrillas() {
        $this->db->order_by("cuadrilla", "asc"); 
        return $this->db->get('mnt_cuadrilla')->result();
    }

    public function get_oneitem($id = '') {
        if (!empty($id)) {
            $this->db->where('id', $id);
            $query = $this->db->get('mnt_cuadrilla');
            return $query->row_array();
        }
        return FALSE;
    }

    public function insert_cuadrilla($data = '') {
        if (!empty($data)) { //verifica que no se haga una insercion vacia
            $this->db->insert('mnt_cuadrilla', $data);
            return $this->db->insert_id();
        }
        return FALSE;
    }

    public function edit_item($data = '') {
        if (!empty($data)) {
            $this->db->where('id', $data['id']);
            $this->db->update('mnt_cuadrilla', $data);
            return $data['id'];
        }
        return FALSE;
    }

    public function drop_item($id = '') {
        if (!empty($id)) {

            $this->db->where('id', $id);
            $this->db->update('mnt_cuadrilla', $data);
            return TRUE;
        }
        return FALSE;
    }

    //retorna los datos de una cuadrilla buscada
    public function buscar_cuadrilla($eq = '') {
        if (!empty($eq)) {
            $this->db->like('id', $eq);
            $this->db->or_like('cuadrilla', $eq);
            $this->db->or_like('id_trabajador_responsable', $eq);

            return $this->db->get('mnt_cuadrilla')->result();
        }
        return FALSE;
    }

    //------------------------------------------Para consulta del autocompletado de la vista
    public function ajax_likeSols($data) {
        $this->db->like('id', $data);
        $this->db->or_like('cuadrilla', $data);
        $query = $this->db->get('mnt_cuadrilla');
        return $query->result();
    }

    //Aporte de Juan Parra

    public function get_nombre_cuadrilla($id) {
        $dat = $this->conect($id);
        return ($dat['cuadrilla']);
    }

    public function conect($id) {
        $this->db->where('id', $id);
        $this->db->select('cuadrilla');
        $query = $this->db->get('mnt_cuadrilla');
        return $query->row_array();
    }

    //Juan Parra
    public function existe_cuadrilla($nombre = '') {
        $this->db->where('cuadrilla', $nombre);
        $this->db->select('cuadrilla');
        $query = $this->db->get('mnt_cuadrilla')->result();
        //die_pre($query);
        if (!empty($query)):
            return 'TRUE';
        else:
            return 'FALSE';
        endif;
    }
   /**
     * guardar_imagen
     * =====================
     * Esta funcion permite guardar la imagen usando codeigniter donde:
     * $ruta es donde se va a guardar la imagen
     * $tipo es la extension que se va a usar para guardar, en caso de ser una sola se debe enviar asi: $tipo = 'png', en caso de
     *    ser varias asi: $tipo = 'gif|jpg|png'; Tambien pueden ser archivos que nos sean imagenes
     * $nombre es el nombre que va a recibir la imagen
     * $mi_imagen va a ser igual al nombre del input que se usa para subir la imagen al servidor
     * $size se refiere al tamaño maximo en kilobytes de la imagen
     * $ width = ancho máximo (en pixeles) que el archivo puede tener. Establecer a cero para sin límite.
     * $height = Alto máximo (en pixeles) que el archivo puede tener. Establecer a cero para sin límite.   
     * @author Juan Parra  en fecha: 28/07/2015
     */

    public function guardar_imagen($ruta = '', $tipo = '', $nombre = '', $mi_imagen = '',$size='',$width = '',$height='') {
        $this->load->library('upload');
        $config['upload_path'] = $ruta;
//        echo_pre($ruta,__LINE__,__FILE__);
        $config['allowed_types'] = $tipo;
        if($nombre != ''):
            $config['file_name'] = $nombre;
        endif;
        $config['max_size'] = $size;
        $config['max_width'] = $width;
        $config['max_height'] = $height;
        $this->upload->initialize($config);
//        var_dump($this->upload->data());
        if (!$this->upload->do_upload($mi_imagen)) {
            return $error = $this->upload->display_errors();
        } else {
            $this->upload->data();
            return 'exito';
        }
    }
    
    private function _get_datatables_query($id = '') {
        $this->db->select('nombre,apellido,id_trabajador');
        $this->db->join('mnt_miembros_cuadrilla', 'mnt_miembros_cuadrilla.id_trabajador = dec_usuario.id_usuario', 'INNER');
        $this->db->from($this->table2);
        $i = 0;
        foreach ($this->column as $item) // loop column
        {
            if($_POST['search']['value'])
                ($i===0) ? $this->db->like($item, $_POST['search']['value']) : $this->db->or_like($item, $_POST['search']['value']);
            $column[$i] = $item;
            $i++;
//            Para cuando se actualice a C I 3.0
//            if($_POST['search']['value']) // if datatable send POST for search
//            {
//                 
//                if($i===0) // first loop
//                {
//                    $this->db->group_start(); // open bracket. query Where with OR clause better with bracket. because maybe can combine with other WHERE with AND.
//                    $this->db->like($item, $_POST['search']['value']);
//                }
//                else
//                {
//                    $this->db->or_like($item, $_POST['search']['value']);
//                }
// 
//                if(count($this->column) - 1 == $i) //last loop
//                    $this->db->group_end(); //close bracket
//            }
//            $column[$i] = $item; // set column array variable to order processing
//            $i++;
        }
         
        if(isset($_POST['order'])) // here order processing
        {
            $this->db->order_by($column[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        }
        else if(isset($this->order))
        {
            $order = $this->order;
            $this->db->order_by(key($order), $order[key($order)]);
        }
    }
    
    function get_datatables($id = '') {
        
        $this->db->where('id_cuadrilla', $id);
        $this->_get_datatables_query($id);
       if($_POST['length'] != -1)
        $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get();
        return $query->result();
    }
    
    function count_filtered($id = '') {
        $this->db->where('id_cuadrilla', $id);
        $this->_get_datatables_query();
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function count_all($id = '') {
        $this->db->where('id_cuadrilla', $id);
        $this->db->from($this->table);
        return $this->db->count_all_results();
    }
    
    public function get_datos($id=''){
        $todos = $this->model_miembros_cuadrilla->get_miembros_cuadrilla($id);
        foreach ($todos as $all):
            $id_trabajador[] = $all->id_trabajador;
        endforeach;
        $this->db->select('nombre,apellido,id_usuario,cargo');
        $this->db->where('tipo', 'obrero');
        $this->db->where('status', 'activo');
        $this->db->where_not_in('id_usuario', $id_trabajador);
        $query = $this->db->get('dec_usuario');
        return($query->result_array());
    }
    
    public function es_responsable($id='',$cuad='',$band=''){
        if($id != ''){
            $datos = array (
                'id_trabajador_responsable' =>$id
            );
        }
        if($cuad != ''){
            $datos = array (
                'id' => $cuad,
            );
        }
        if($id != '' && $cuad != '' ){
            $datos = array (
                'id' => $cuad,
                'id_trabajador_responsable' =>$id
            );
        }
        $query = $this->db->get_where('mnt_cuadrilla',$datos);
        if($query->num_rows() > 0){
            if($band){
                return $query->result_array();
            }
            else{
                return TRUE;
            }
        }
        return FALSE;
        
    }

}
