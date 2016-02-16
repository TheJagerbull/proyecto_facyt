<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Model_dec_permiso extends CI_Model
{
	//constructor predeterminado del modelo
	function __construct()
	{
		parent::__construct();
	}
    
   //Esta es la funcion que trabaja correctamente al momento de cargar los datos desde el servidor para el datatable 
    function get_list(){//ojo aun no esta adaptada totalmente al modulo de 
       
        /* Array de las columnas para la table que deben leerse y luego ser enviados al DataTables. Usar ' ' donde
         * se desee usar un campo que no este en la base de datos
         */
        $aColumns = array('nombre', 'apellido', 'cargo', 'fecha', 'id_trabajador', 'id_orden_trabajo', 'dependen', 'tipo_orden','descripcion', 'asunto', 'descripcion_general','estatus');
  
        /* Indexed column (se usa para definir la cardinalidad de la tabla) */
        $sIndexColumn = "id_orden_trabajo";
        
        /* $filtro (Se usa para filtrar la vista del Asistente de autoridad) La intencion de usar esta variable
        es para usarla en el query que se va a construir mas adelante. Este datos es modificable */
        $filtro = "WHERE estatus NOT IN (3,4)";
          $sJoin = " INNER JOIN mnt_orden_trabajo ON mnt_orden_trabajo.id_orden=mnt_ayudante_orden.id_orden_trabajo "
                . "INNER JOIN dec_dependencia ON mnt_orden_trabajo.dependencia=dec_dependencia.id_dependencia "
                . "INNER JOIN mnt_estatus ON mnt_orden_trabajo.estatus=mnt_estatus.id_estado "
                . "INNER JOIN mnt_tipo_orden ON mnt_orden_trabajo.id_tipo=mnt_tipo_orden.id_tipo "
                . "INNER JOIN dec_usuario ON dec_usuario.id_usuario=mnt_ayudante_orden.id_trabajador "; 
//        if ($this->session->userdata('user')['sys_rol'] == 'asist_autoridad'): 
//            $filtro = "WHERE estatus = 2"; /* asistente de autoridad solo va a mostrar las solicitudes que tengan estatus 2 */
//        else:
//            $filtro = "WHERE estatus NOT IN (3,4)";
//        endif;
//        if(($est=='close'))://Evalua el estado de las solicitudes para crear la vista en Solicitudes cerradas/anuladas
//             $filtro = "WHERE estatus IN (3,4)";
//        endif;
//        if(isset($_GET['dep']))://Evalua si viene de un departamento y no es autoridad 
//            $filtro = "WHERE dependencia = $_GET[dep] AND estatus NOT IN (3,4)";
//        endif;
//        if(isset($_GET['dep']) && $est=='close')://Evalua si viene de un departamento y no es autoridad y estan en la vista de sol cerradas/anuladas 
//            $filtro = "WHERE dependencia = $_GET[dep] AND estatus IN (3,4)";
//        endif;
        
        /* Se establece la cantidad de datos que va a manejar la tabla (el nombre ya esta declarado al inico y es almacenado en var table */
        $sQuery = "SELECT COUNT('" . $sIndexColumn . "') AS row_count FROM $this->table $sJoin $filtro";
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
            $sWhere = "AND (";  //Se comienza a almacenar la sentencia sql
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
            $sWhere = "AND fecha BETWEEN '$_GET[uno]' AND '$_GET[dos]'"; //Se empieza a crear la sentencia sql al solo buscar por fecha
        endif;
        if($this->db->escape_like_str($sSearchVal) != "" AND $_GET['uno'] != "" AND $_GET['uno'] != ""):
            $sWhere = "AND fecha BETWEEN '$_GET[uno]' AND '$_GET[dos]' AND(";
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
      
   
        if ($sWhere == ""):
            $sQuery = "SELECT SQL_CALC_FOUND_ROWS " . str_replace(" , ", " ", implode(", ", $aColumns)) . "
            FROM $this->table $sJoin $filtro GROUP BY id_trabajador,id_orden_trabajo $sOrder $sLimit";
        else:
            $sQuery = "SELECT SQL_CALC_FOUND_ROWS " . str_replace(" , ", " ", implode(", ", $aColumns)) . "
            FROM $this->table $sJoin $filtro $sWhere GROUP BY id_trabajador,id_orden_trabajo $sOrder $sLimit";
        endif;
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
//            $row[] = $sol['id_orden_trabajo'];;      
            $row['nombre'] = $sol['nombre'];
            $row['apellido'] = $sol['apellido'];
            $row['cargo'] = $sol['cargo'];
            $row['orden'] = $sol['id_orden_trabajo'];
            $row['dependencia'] = $sol['dependen'];
            $row['asunto'] = $sol['asunto'];
            $row['tipo_orden'] = $sol['tipo_orden'];
            $row['problema'] = $sol['descripcion_general'];
            $output['data'][] = $row;
        endforeach;
        return $output;// Para retornar los datos al controlador
    }
	
}
