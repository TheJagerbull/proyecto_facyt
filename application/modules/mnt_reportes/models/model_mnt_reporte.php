<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Model_mnt_reporte extends CI_Model
{
	//constructor predeterminado del modelo
	function __construct()
	{
		parent::__construct();
	}
        var $table = 'mnt_orden_trabajo'; //El nombre de la tabla que estamos usando
    
    public function consul_trabaja_sol($id_usuario='',$status='',$fecha1='',$fecha2='',$band=''){
        $this->db->join('mnt_orden_trabajo', 'mnt_orden_trabajo.id_orden = mnt_ayudante_orden.id_orden_trabajo', 'INNER');
        $this->db->join('mnt_estatus', 'mnt_estatus.id_estado = mnt_orden_trabajo.estatus', 'INNER');
//        $this->db->join('mnt_estatus_orden', 'mnt_estatus_orden.id_estado = mnt_estatus.id_estado', 'INNER');
        $this->db->join('dec_usuario', 'dec_usuario.id_usuario = mnt_ayudante_orden.id_trabajador', 'INNER');
        $this->db->join('dec_dependencia', 'dec_dependencia.id_dependencia = mnt_orden_trabajo.dependencia', 'INNER');
        $this->db->select('id_usuario,fecha,nombre AS Nombre, apellido AS Apellido,id_orden_trabajo AS Orden,dependen AS Dependencia,asunto AS Asunto');
        if (!empty($fecha1) && ($fecha2)):
            $this->db->where('fecha BETWEEN"' . $fecha1 . '"AND"' . $fecha2 . '"');
        endif;
        if (!empty($status)):
            $this->db->where('estatus', $status);
        endif;
        if (!empty($id_usuario)):
            $this->db->where('id_trabajador', $id_usuario);
        else:
            $this->db->order_by('nombre,apellido');
            $this->db->group_by('id_trabajador,id_orden_trabajo');
        endif;
        $query = $this->db->get('mnt_ayudante_orden')->result_array();
//            echo_pre($query);
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
    
    function get_list($est='',$dep=''){
        $ayuEnSol = $this->model_mnt_ayudante->array_of_orders(); //Para consultar los ayudantes asignados a una orden
        $cuadri = $this->model_mnt_cuadrilla->get_cuadrillas();
        $estatus = $this->model_mnt_estatus->get_estatus2();
     
        /* Array de las columnas para la table que deben leerse y luego ser enviados al DataTables. Usar ' ' donde
         * se desee usar un campo que no este en la base de datos
         */
        $aColumns = array('id_orden','fecha','dependen','asunto','descripcion');
  
        /* Indexed column (se usa para definir la cardinalidad de la tabla) */
        $sIndexColumn = "id_orden";
        
//        /* $filtro (Se usa para filtrar la vista del Asistente de autoridad) La intencion de usar esta variable
//        es para usarla en el query que se va a construir mas adelante. Este datos es modificable */
        if (isset($_GET['est']) AND $_GET['est'] != ""): 
            $filtro = "WHERE estatus = '$_GET[est]' "; /* Para filtrar por estatus en proceso */
//            echo_pre('hola');
        endif;

//        /* Se establece la cantidad de datos que va a manejar la tabla (el nombre ya esta declarado al inico y es almacenado en var table */
////        $sQuery = "SELECT COUNT('" . $sIndexColumn . "') AS row_count FROM $this->table $filtro"; Anterior
        $sQuery = "SELECT COUNT('" . $sIndexColumn . "') AS row_count FROM $this->table";
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
        /* estos parametros son de configuracion por lo tanto tampoco deben tocarse*/
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
            if(isset($filtro)&& $filtro != " "):
                $sWhere = "AND (";
            else:
                $sWhere = "WHERE (";  //Se comienza a almacenar la sentencia sql    
            endif;
            
            for ($i = 0; $i < count($aColumns); $i++): //se abre el for para buscar en todas las columnas que leemos de la tabla
                $sWhere .= $aColumns[$i] . " LIKE '%" . $this->db->escape_like_str($sSearchVal) . "%' OR ";// se concatena con Like 
            endfor;
            $sWhere = substr_replace($sWhere, "", -3);
            $sWhere .= ')'; //Se cierra la sentencia sql
        endif;
        
        /* Filtro de busqueda individual */
        $sSearchReg = $arr['search[regex]'];
        for ($i = 0; $i < count($aColumns)-9; $i++):
            $bSearchable_ = $arr['columns[' . $i . '][searchable]'];
            if (isset($bSearchable_) && $bSearchable_ == "true" && $sSearchReg != 'false'):
                $search_val = $arr['columns[' . $i . '][search][value]'];
                if ($sWhere == ""):
//                    $sWhere = "WHERE ";
                else:
                    $sWhere .= " AND ";
                endif;
                $sWhere .= $aColumns[$i] . " LIKE '%" . $this->db->escape_like_str($sSearchVal) . "%' ";
            endif;
        endfor;
        /* Filtro de busqueda añadido en este caso es para buscar por el rango de fechas 
         * las variables $_GET vienen de la vista pasados por ajax por medio de una funcion data en jquery al
         * al construir el datatable por medio de customvar (opcion de pasar datos de datatable al usarlo en server side) */
        if ($_GET['uno'] != "" OR $_GET['dos'] != ""):
            if(isset($filtro)&& $filtro != " "):
                $sWhere = "AND fecha BETWEEN '$_GET[uno]' AND '$_GET[dos]'"; //Se empieza a crear la sentencia sql al solo buscar por fecha   
            else:
                $sWhere = "WHERE fecha BETWEEN '$_GET[uno]' AND '$_GET[dos]'"; //Se empieza a crear la sentencia sql al solo buscar por fecha    
            endif;
            
        endif;
        if($this->db->escape_like_str($sSearchVal) != "" AND $_GET['uno'] != "" AND $_GET['uno'] != ""):
            if(isset($filtro)&& $filtro != " "):
                $sWhere = "AND fecha BETWEEN '$_GET[uno]' AND '$_GET[dos]' AND(";
            else:
                $sWhere = "WHERE fecha BETWEEN '$_GET[uno]' AND '$_GET[dos]' AND(";
            endif;
            
            for ($i = 0; $i < count($aColumns); $i++):
                $sWhere .= $aColumns[$i] . " LIKE '%" . $this->db->escape_like_str($sSearchVal) . "%' OR ";
            endfor;
            $sWhere = substr_replace($sWhere, "", -3);
            $sWhere .= ')';
        endif;    
 
         /*
         * SQL queries
         * Aqui se obtienen los datos a mostrar
          * sJoin creada para el proposito de unir las tablas en una sola variable 
         */
        $sJoin = "INNER JOIN dec_dependencia ON mnt_orden_trabajo.dependencia=dec_dependencia.id_dependencia "
                . "INNER JOIN mnt_estatus ON mnt_orden_trabajo.estatus=mnt_estatus.id_estado "
                . "INNER JOIN mnt_tipo_orden ON mnt_orden_trabajo.id_tipo=mnt_tipo_orden.id_tipo "
                . "LEFT JOIN mnt_asigna_cuadrilla ON mnt_orden_trabajo.id_orden=mnt_asigna_cuadrilla.id_ordenes "
                . "LEFT JOIN mnt_cuadrilla ON mnt_asigna_cuadrilla.id_cuadrilla=mnt_cuadrilla.id "
                . "LEFT JOIN mnt_responsable_orden ON mnt_orden_trabajo.id_orden=mnt_responsable_orden.id_orden_trabajo "
                . "INNER JOIN mnt_ayudante_orden ON mnt_orden_trabajo.id_orden=mnt_ayudante_orden.id_orden_trabajo"; 
        $band =0;       
        if ($sWhere == ""):
            if(isset($filtro) && $filtro != " "):
             $sQuery = "SELECT SQL_CALC_FOUND_ROWS " . str_replace(" , ", " ", implode(", ", $aColumns)) . "
             FROM $this->table $sJoin $filtro ";
             $band = 1;
            else:
                $sQuery = "SELECT SQL_CALC_FOUND_ROWS " . str_replace(" , ", " ", implode(", ", $aColumns)) . "
             FROM $this->table $sJoin";
            endif;            
        else:
             if(isset($filtro)&& $filtro != " "):
            $sQuery = "SELECT SQL_CALC_FOUND_ROWS " . str_replace(" , ", " ", implode(", ", $aColumns)) . "
            FROM $this->table $sJoin $filtro $sWhere ";
             $band = 1;
             else:
                $sQuery = "SELECT SQL_CALC_FOUND_ROWS " . str_replace(" , ", " ", implode(", ", $aColumns)) . "
                FROM $this->table $sJoin $sWhere ";
            endif;
//        echo_pre($sQuery); $sOrder $sLimit
        endif;
        
        if (isset($_GET['trab']) AND $_GET['trab'] != "" ):
//            echo_pre(($_GET['trab'])); La idea es que en el if anterior se corte el query y se complete aqui para seguir 
//            la ejecucion segun lo que se necesita.
            if ($band):
                $sQuery = $sQuery." AND id_trabajador = '$_GET[trab]' $sOrder $sLimit"; 
            else:
                $sQuery = $sQuery." WHERE id_trabajador  in('$_GET[trab]') $sOrder $sLimit"; 
            endif;
             
        endif;
//         echo_pre($sQuery);
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
        //Aqui se crea el array que va a contener todos los datos que se necesitan para el datatable a medida que se obtienen de la tabla
        foreach ($rResult->result_array() as $sol):
            $row = array();
            /* aqui se evalua si es tiene permiso para ver el detalle de la solicitud */  
            if($this->dec_permiso->has_permission ('mnt',13) || $this->dec_permiso->has_permission ('mnt',16)):
                $row[] = '<div align="center"><a href="'.base_url().'index.php/mnt_solicitudes/detalle/'.$sol['id_orden'].'">'.$sol['id_orden'].'</a></div>';
            else:
                $row[] = '<div align="center">'.$sol['id_orden'].'</div>';
            endif; 
            $row[] = '<div align="center">'.date("d/m/Y", strtotime($sol['fecha'])).'</div>';
            if(!empty($est))://Evalua el est no este vacio
                $row[] = '<div align="center">'.date("d/m/Y", strtotime($this->model_mnt_estatus_orden->get_first_fecha($sol['id_orden']))).'</div>';
            endif;
            $row[] = $sol['dependen'];
            $row[] = $sol['asunto'];
                 $row[] = '<div align="center">'.$sol['descripcion'].'</div>';         
            $output['data'][] = $row;
        endforeach;
        return $output;// Para retornar los datos al controlador
    }
}