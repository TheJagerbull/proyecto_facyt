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
    
    public function existe_resp_2($id_usuario='',$status='',$fecha1='',$fecha2='',$id_tipo='') //funcion para verificar si existe un responsable en la solicitud con fechas
    {
        $this->db->join('mnt_orden_trabajo', 'mnt_orden_trabajo.id_orden = mnt_responsable_orden.id_orden_trabajo', 'INNER');
        $this->db->join('mnt_estatus', 'mnt_estatus.id_estado = mnt_orden_trabajo.estatus', 'INNER');
        if (!empty($fecha1) && ($fecha2)):
            $this->db->where('fecha BETWEEN"' . $fecha1 . '"AND"' . $fecha2 . '"');
        endif;
        if (!empty($status)):
            $this->db->where('estatus', $status);
        endif;
        if (!empty($id_usuario)):
            $this->db->where('id_responsable', $id_usuario);
        endif;
        if (!empty($id_tipo)):
            $this->db->where('id_tipo', $id_tipo);
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
    
     public function consul_respon_sol($id_usuario='',$status='',$fecha1='',$fecha2='',$band='',$buscador='',$ordena='',$dir_span=''){
//        En esta funcion toco usar el query personalizado ya que los del active record no funcionaban bien cuando le aplicaba
//        el buscador, siempre se salian del estatus.
        $aColumns = array('id_orden','fecha','dependen','asunto','descripcion','nombre','apellido','id_responsable','tiene_cuadrilla','id_cuadrilla','cuadrilla');
        if(!empty($id_tipo = $this->model_mnt_cuadrilla->es_resp_no_jefe_cuad($this->session->userdata('user')['id_usuario'])))//PARA evaluar si es responsable de una cuadrilla y que no sea jefe de mantenimiento
        {
            $filtro = "WHERE mnt_orden_trabajo.id_tipo = $id_tipo";
        }
        if ($status != ''){
            if(isset($filtro)){
                $filtro .= " AND estatus in ($status) "; /* Para filtrar por estatus */
            }else{
                $filtro = " WHERE estatus = '$status'";
            }
        }else{
            $filtro = " WHERE estatus not in (1,6) ";
        }
//        die_pre($filtro,$status);
        if($id_usuario != ''):
            $filtro .= " AND id_usuario = '$id_usuario' ";
//                 echo_pre($filtro);
        endif;
        if($id_usuario != ''):
            $filtro .= " AND id_responsable = '$id_usuario' ";
//                 echo_pre($filtro);
        endif;
//        die_pre($filtro);
        $sWhere = ""; // Se inicializa y se crea la variable
        if ($buscador != ''):
            $sSearchVal = $buscador; //Se asigna el valor de la busqueda, este es el campo de busqueda de la tabla
            if (isset($sSearchVal) && $sSearchVal != ''): //SE evalua si esta vacio o existe
//                echo_pre($sSearchVal);
                if (isset($filtro) && $filtro != ''):
                    $sWhere = "AND (";
                else:
                    $sWhere = "WHERE (";  //Se comienza a almacenar la sentencia sql    
                endif;

                for ($i = 0; $i < count($aColumns); $i++): //se abre el for para buscar en todas las columnas que leemos de la tabla
                    $sWhere .= $aColumns[$i] . " LIKE '%" . $this->db->escape_like_str($sSearchVal) . "%' OR "; // se concatena con Like 
                endfor;
                $sWhere = substr_replace($sWhere, "", -3);
                $sWhere .= ')'; //Se cierra la sentencia sql
            endif;
        endif;
   
        /* Filtro de busqueda añadido en este caso es para buscar por el rango de fechas */
        if ($fecha1 != "" OR $fecha2 != ""):
            if(isset($filtro)&& $filtro != ""):
                $sWhere = "AND fecha BETWEEN '$fecha1' AND '$fecha2'"; //Se empieza a crear la sentencia sql al solo buscar por fecha   
            else:
                $sWhere = "WHERE fecha BETWEEN '$fecha1' AND '$fecha2'"; //Se empieza a crear la sentencia sql al solo buscar por fecha    
            endif;
            
        endif;
        
        if($this->db->escape_like_str($buscador) != "" AND $fecha1 != "" AND $fecha2 != ""):
            if(isset($filtro)&& $filtro != " "):
                $sWhere = "AND fecha BETWEEN '$fecha1' AND '$fecha2' AND(";
            else:
                $sWhere = "WHERE fecha BETWEEN '$fecha1' AND '$fecha2' AND(";
            endif;
            
            for ($i = 0; $i < count($aColumns); $i++):
                $sWhere .= $aColumns[$i] . " LIKE '%" . $this->db->escape_like_str($buscador) . "%' OR ";
            endfor;
            $sWhere = substr_replace($sWhere, "", -3);
            $sWhere .= ')';
        endif;
        
        $table = 'mnt_responsable_orden';
        $sJoin = "INNER JOIN mnt_orden_trabajo ON mnt_responsable_orden.id_orden_trabajo=mnt_orden_trabajo.id_orden "
                . "INNER JOIN mnt_estatus ON mnt_orden_trabajo.estatus=mnt_estatus.id_estado "
                . "LEFT JOIN mnt_asigna_cuadrilla ON mnt_responsable_orden.id_orden_trabajo=mnt_asigna_cuadrilla.id_ordenes "
                . "LEFT JOIN mnt_cuadrilla ON mnt_asigna_cuadrilla.id_cuadrilla=mnt_cuadrilla.id "
                . "INNER JOIN mnt_tipo_orden ON mnt_orden_trabajo.id_tipo=mnt_tipo_orden.id_tipo "
                . "INNER JOIN dec_dependencia ON mnt_orden_trabajo.dependencia=dec_dependencia.id_dependencia "
                . "INNER JOIN dec_usuario ON mnt_responsable_orden.id_responsable=dec_usuario.id_usuario";
        
        if ($sWhere == ""):
            if (isset($filtro) && $filtro != ""):
                $sQuery = "SELECT SQL_CALC_FOUND_ROWS " . str_replace(" , ", " ", implode(", ", $aColumns)) . "
             FROM $table $sJoin $filtro ";
            else:
                $sQuery = "SELECT SQL_CALC_FOUND_ROWS " . str_replace(" , ", " ", implode(", ", $aColumns)) . "
             FROM $table $sJoin";
            endif;
        else:
             if (isset($filtro) && $filtro != ""):
                $sQuery = "SELECT SQL_CALC_FOUND_ROWS " . str_replace(" , ", " ", implode(", ", $aColumns)) . "
            FROM $table $sJoin $filtro $sWhere ";
            else:
                $sQuery = "SELECT SQL_CALC_FOUND_ROWS " . str_replace(" , ", " ", implode(", ", $aColumns)) . "
                FROM $table $sJoin $sWhere ";
            endif;
        endif;
        $sOrder = "ORDER BY ";
        if($ordena != "nombre $dir_span"):
            if($dir_span != ''):
                $sOrder .= "nombre $dir_span,apellido,$ordena ";
            else:
                $sOrder .= "nombre,apellido,$ordena ";
            endif;
        else:
            $sOrder .= "nombre $dir_span,apellido";
        endif;
        $sQuery .= $sOrder;
//        die_pre($sQuery);
        $query = $this->db->query($sQuery)->result_array();
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
