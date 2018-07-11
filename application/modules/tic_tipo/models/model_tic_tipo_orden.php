<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Model_tic_tipo_orden extends CI_Model {

    //constructor predeterminado del modelo
    function __construct() {
        parent::__construct();
    }

    public function devuelve_tipo($id_tipo = '') { // funcion para obtener el tipo de solicitud
        //die_pre('hola');
        if($id_tipo == ''):
            $this->db->order_by('tipo_orden','asc');
        else:
            $this->db->where('id_tipo',$id_tipo);
        endif;
        $consulta = $this->db->get('tic_tipo_orden');
        return $consulta->result();
    }

    public function set_tipo_orden($data = '') { //funcion se usa para que tipo de solicitud sea igual al de la cuadrilla
        if (!empty($data)) { //verifica que no se haga una insercion vacia
            $this->db->insert('tic_tipo_orden', $data); // $data es el nombre del tipo de solicitud
            return $this->db->insert_id();
        }
        return FALSE;
    }

    public function devuelve_id_tipo($tipo_orden = '') { // funcion para obtener el tipo de solicitud
        //die_pre('hola');
        if($tipo_orden == ''):
            $this->db->order_by('tipo_orden','asc');
        else:
            $this->db->where('tipo_orden',$tipo_orden);
            $this->db->select('id_tipo');
        endif;
        $consulta = $this->db->get('tic_tipo_orden');
        if($consulta->num_rows() > 0):
            $id = $consulta->row_array();
//            die_pre($id);
            return $id['id_tipo'];
        else:
            return FALSE;
        endif;
    }
    
        var $table = 'tic_tipo_orden'; //El nombre de la tabla que estamos usando

    //Esta es la funcion que trabaja correctamente al momento de cargar los datos desde el servidor para el datatable 
    
    function get_list() {

        /* Array de las columnas para la table que deben leerse y luego ser enviados al DataTables. Usar ' ' donde
         * se desee usar un campo que no este en la base de datos
         */
        $aColumns = array('id_tipo', 'tipo_orden');

        /* Indexed column (se usa para definir la cardinalidad de la tabla) */
        $sIndexColumn = "id_tipo";
//        echo_pre($_GET['dep']);
        /* $filtro (Se usa para filtrar la vista del Asistente de autoridad) La intencion de usar esta variable
          es para usarla en el query que se va a construir mas adelante. Este datos es modificable */
//        if($this->dec_permiso->has_permission('usr', 3)):
//            $filtro = "WHERE dec_usuario.id_dependencia = $_GET[dep]";
//        endif;
//        $sJoin = " INNER JOIN dec_dependencia ON dec_usuario.id_dependencia=dec_dependencia.id_dependencia ";

        /* Se establece la cantidad de datos que va a manejar la tabla (el nombre ya esta declarado al inico y es almacenado en var table */
//        if(isset($filtro)):
//            $sQuery = "SELECT COUNT('" . $sIndexColumn . "') AS row_count FROM $this->table $sJoin $filtro ";
//        else:
//            $sQuery = "SELECT COUNT('" . $sIndexColumn . "') AS row_count FROM $this->table $sJoin ";
//        endif;
        $sQuery = "SELECT COUNT('" . $sIndexColumn . "') AS row_count FROM $this->table ";
        $rResultTotal = $this->db->query($sQuery);
        $aResultTotal = $rResultTotal->row();
        $iTotal = $aResultTotal->row_count;

        /*
         * Paginacion (no debe manipularse)
         */
        $sLimit = "";
        $iDisplayStart = $this->input->get_post('start', true);
        $iDisplayLength = $this->input->get_post('length', true);
        if (isset($iDisplayStart) && $iDisplayLength != '-1') :
            $sLimit = "LIMIT " . intval($iDisplayStart) . ", " .
                    intval($iDisplayLength);
        endif;
        /* estos parametros son de configuracion por lo tanto tampoco deben tocarse */
        $uri_string = $_SERVER['QUERY_STRING'];
        $uri_string = preg_replace("/\%5B/", '[', $uri_string);
        $uri_string = preg_replace("/\%5D/", ']', $uri_string);

        $get_param_array = explode("&", $uri_string);
        $arr = array();
        foreach ($get_param_array as $value):
            $v = $value;
            $explode = explode("=", $v);
            $arr[$explode[0]] = $explode[1];
        endforeach;

        $index_of_columns = strpos($uri_string, "columns", 1);
        $index_of_start = strpos($uri_string, "start");
        $uri_columns = substr($uri_string, 7, ($index_of_start - $index_of_columns - 1));
        $columns_array = explode("&", $uri_columns);
        $arr_columns = array();
        foreach ($columns_array as $value):
            $v = $value;
            $explode = explode("=", $v);
            if (count($explode) == 2):
                $arr_columns[$explode[0]] = $explode[1];
            else:
                $arr_columns[$explode[0]] = '';
            endif;
        endforeach;

        /*
         * Ordenamiento
         */
        $sOrder = "ORDER BY ";
        $sOrderIndex = $arr['order[0][column]'];
        $sOrderDir = $arr['order[0][dir]'];
        $bSortable_ = $arr_columns['columns[' . $sOrderIndex . '][orderable]'];
        if ($bSortable_ == "true"):
            $sOrder .= $aColumns[$sOrderIndex] .
                    ($sOrderDir === 'asc' ? ' asc' : ' desc');
        endif;

        /*
         * Filtros de busqueda(Todos creados con sentencias sql nativas ya que al usar las de framework daba errores)
          en la variable $sWhere se guarda la clausula sql del where y se evalua dependiendo de las situaciones */

        $sWhere = ""; // Se inicializa y se crea la variable
        $sSearchVal = $arr['search[value]']; //Se asigna el valor de la busqueda, este es el campo de busqueda de la tabla
        if (isset($sSearchVal) && $sSearchVal != ''): //SE evalua si esta vacio o existe
            if(isset($filtro)):
                $sWhere = " AND (";//Se comienza a almacenar la sentencia sql
            else:
                $sWhere = " WHERE (";//Se comienza a almacenar la sentencia sql
            endif; 
            for ($i = 0; $i < count($aColumns); $i++): //se abre el for para buscar en todas las columnas que leemos de la tabla
                $sWhere .= $aColumns[$i] . " LIKE '%" . $this->db->escape_like_str($sSearchVal) . "%' OR "; // se concatena con Like 
            endfor;
            $sWhere = substr_replace($sWhere, "", -3);
            $sWhere .= ')'; //Se cierra la sentencia sql
        endif;

        /* Filtro de busqueda individual */
        $sSearchReg = $arr['search[regex]'];
        for ($i = 0; $i < count($aColumns)-3; $i++):
            $bSearchable_ = $arr['columns[' . $i . '][searchable]'];
            if (isset($bSearchable_) && $bSearchable_ == "true" && $sSearchReg != 'false'):
                $search_val = $arr['columns[' . $i . '][search][value]'];
                if ($sWhere == ""):
                    $sWhere = "WHERE ";
                else:
                    $sWhere .= " AND ";
                endif;
                $sWhere .= $aColumns[$i] . " LIKE '%" . $this->db->escape_like_str($sSearchVal) . "%' ";
            endif;
        endfor;

        /*
         * SQL queries
         * Aqui se obtienen los datos a mostrar
         * sJoin creada para el proposito de unir las tablas en una sola variable 
         */

        if ($sWhere == ""):
            if(isset($filtro)):
                $sQuery = "SELECT SQL_CALC_FOUND_ROWS " . str_replace(" , ", " ", implode(", ", $aColumns)) . "
                FROM $this->table $sJoin $filtro $sOrder $sLimit";
            else:
//                $sQuery = "SELECT SQL_CALC_FOUND_ROWS " . str_replace(" , ", " ", implode(", ", $aColumns)) . "
//                FROM $this->table $sJoin $sOrder $sLimit";
                $sQuery = "SELECT SQL_CALC_FOUND_ROWS " . str_replace(" , ", " ", implode(", ", $aColumns)) . "
                FROM $this->table $sOrder $sLimit";
            endif; 
        else:
            if(isset($filtro)):
                $sQuery = "SELECT SQL_CALC_FOUND_ROWS " . str_replace(" , ", " ", implode(", ", $aColumns)) . "
            FROM $this->table $sJoin $filtro $sWhere $sOrder $sLimit";
            else:
                $sQuery = "SELECT SQL_CALC_FOUND_ROWS " . str_replace(" , ", " ", implode(", ", $aColumns)) . "
            FROM $this->table $sJoin $sWhere $sOrder $sLimit";
            endif;
            
        endif;
//        echo_pre($sQuery);
        $rResult = $this->db->query($sQuery);

        /* Para buscar la cantidad de datos filtrados */
        $sQuery = "SELECT FOUND_ROWS() AS length_count";
        $rResultFilterTotal = $this->db->query($sQuery);
        $aResultFilterTotal = $rResultFilterTotal->row();
        $iFilteredTotal = $aResultFilterTotal->length_count;

        /*
         * A partir de aca se envian los datos del query hecho anteriormente al controlador y la cantidad de datos encontrados
         */
        $sEcho = $this->input->get_post('draw', true);
        $output = array(
            "draw" => intval($sEcho),
            "recordsTotal" => $iTotal,
            "recordsFiltered" => $iFilteredTotal,
            "data" => array()
        );
       
        foreach ($rResult->result_array() as $sol):
            $row = array();
            $row['cuadrilla'] = '<div align="center">'.$sol['id_tipo'].'</div>';
            $row['tipo_orden'] = $sol['tipo_orden'];
           
            $output['data'][] = $row;
        endforeach;
        return $output; // Para retornar los datos al controlador
    }
}
