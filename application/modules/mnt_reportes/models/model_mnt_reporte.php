<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Model_mnt_reporte extends CI_Model
{
	//constructor predeterminado del modelo
	function __construct()
	{
		parent::__construct();
	}
    
    function get_list($est='',$dep=''){
        $table = 'mnt_orden_trabajo'; //El nombre de la tabla que estamos usando
        $ayuEnSol = $this->model_mnt_ayudante->array_of_orders(); //Para consultar los ayudantes asignados a una orden
        $cuadri = $this->model_mnt_cuadrilla->get_cuadrillas();
        $estatus = $this->model_mnt_estatus->get_estatus2();
     
        /* Array de las columnas para la table que deben leerse y luego ser enviados al DataTables. Usar ' ' donde
         * se desee usar un campo que no este en la base de datos
         */
//        echo_pre($_GET['checkTrab']);
        if(($_GET['checkTrab'])=='si'):
            $aColumns = array('id_orden','fecha','dependen','asunto','descripcion','id_trabajador','nombre','apellido'); //cuando sea trabajador
        endif;
        if(($_GET['checkTrab'])=='respon'):
            $aColumns = array('id_orden','fecha','dependen','asunto','descripcion','nombre','apellido','id_responsable','tiene_cuadrilla','id_cuadrilla','cuadrilla'); //Cuando sea responsable
        endif;
        if(($_GET['checkTrab'])=='tipo'):
            $aColumns = array('id_orden','fecha','dependen','asunto','descripcion','tipo_orden','mnt_orden_trabajo.id_tipo');
        endif;
        if(($_GET['checkTrab'])=='no'):
            $aColumns = array('id_orden','fecha','dependen','asunto','descripcion','star');
        endif;
        
  
        /* Indexed column (se usa para definir la cardinalidad de la tabla) */
        $sIndexColumn = "id_orden";
        
//        /* $filtro (Se usa para filtrar por estatus de la solicitud) La intencion de usar esta variable
//        es para usarla en el query que se va a construir mas adelante. Este datos es modificable */
         if (isset($_GET['est']) && $_GET['est'] != ''): 
                $filtro = "WHERE estatus = '$_GET[est]' "; /* Para filtrar por estatus */
//         echo_pre('1');
         endif;
        if(((($_GET['checkTrab'])=='si') || ($_GET['checkTrab'])=='respon')):
//             echo_pre('check:'.($_GET['checkTrab']));
            if (isset($_GET['est']) && $_GET['est'] != ""): 
               $filtro = $filtro." AND estatus not in (1,6) ";
            else:
                $filtro = " WHERE estatus not in (1,6) ";
            endif;
//            echo_pre('2');
        endif;
       
//        echo_pre($filtro);
//        /* Se establece la cantidad de datos que va a manejar la tabla (el nombre ya esta declarado al inico y es almacenado en var table */
////        $sQuery = "SELECT COUNT('" . $sIndexColumn . "') AS row_count FROM $this->table $filtro"; Anterior
        $sQuery = "SELECT COUNT('" . $sIndexColumn . "') AS row_count FROM $table";
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
        if((($_GET['checkTrab'])=='si') || ($_GET['checkTrab'])=='respon'):
            if ($bSortable_ == "true"):
                if($aColumns[$sOrderIndex] != 'nombre,apellido'):
                  $sOrder .= "nombre,apellido,".$aColumns[$sOrderIndex]. ($sOrderDir === 'asc' ? ' asc' : ' desc');
                else:
                  $sOrder .= "nombre,apellido". ($sOrderDir === 'asc' ? ' asc' : ' desc');
                endif;
            else:
                $sOrder .= $aColumns[$sOrderIndex] . ($sOrderDir === 'asc' ? ' asc' : ' desc');
             endif;
        endif;
         if(($_GET['checkTrab'])=='tipo'):
             if ($bSortable_ == "true"):
                $sOrder .= "tipo_orden desc,".$aColumns[$sOrderIndex]. ($sOrderDir === 'asc' ? ' asc' : ' desc');
            else:
                $sOrder .= "tipo_orden". ($sOrderDir === 'asc' ? ' asc' : ' desc');
             endif;
        endif;     
        if(($_GET['checkTrab'])=='no'):
            if ($bSortable_ == "true"):
                $sOrder .= $aColumns[$sOrderIndex] . ($sOrderDir === 'asc' ? ' asc' : ' desc');
            endif;
        endif;
        $test =($aColumns[$sOrderIndex].' '. ($sOrderDir));
        
//        echo_pre($sOrder);
        /*
         * Filtros de busqueda(Todos creados con sentencias sql nativas ya que al usar las de framework daba errores)
         en la variable $sWhere se guarda la clausula sql del where y se evalua dependiendo de las situaciones */ 

        $sWhere = ""; // Se inicializa y se crea la variable
        $sSearchVal = $arr['search[value]']; //Se asigna el valor de la busqueda, este es el campo de busqueda de la tabla
        if (isset($sSearchVal) && $sSearchVal != ''): //SE evalua si esta vacio o existe
            if(isset($filtro)&& $filtro != ''):
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
            if(isset($filtro)&& $filtro != ""):
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
        if(($_GET['checkTrab'])=='si'):
            $table = 'mnt_ayudante_orden';
//            if (isset($_GET['trab']) AND $_GET['trab'] != "" ):
                $sJoin = "INNER JOIN mnt_orden_trabajo ON mnt_ayudante_orden.id_orden_trabajo=mnt_orden_trabajo.id_orden "
                    . "INNER JOIN mnt_estatus ON mnt_orden_trabajo.estatus=mnt_estatus.id_estado "
//                    . "LEFT JOIN mnt_estatus_orden ON mnt_estatus.id_estado=mnt_estatus_orden.id_estado "
                    . "INNER JOIN dec_usuario ON mnt_ayudante_orden.id_trabajador=dec_usuario.id_usuario "
                    . "INNER JOIN dec_dependencia ON mnt_orden_trabajo.dependencia=dec_dependencia.id_dependencia "
                    . "INNER JOIN mnt_tipo_orden ON mnt_orden_trabajo.id_tipo=mnt_tipo_orden.id_tipo ";
//                . "LEFT JOIN mnt_asigna_cuadrilla ON mnt_orden_trabajo.id_orden=mnt_asigna_cuadrilla.id_ordenes "
//                . "LEFT JOIN mnt_cuadrilla ON mnt_asigna_cuadrilla.id_cuadrilla=mnt_cuadrilla.id ";
//                . "LEFT JOIN mnt_responsable_orden ON mnt_orden_trabajo.id_orden=mnt_responsable_orden.id_orden_trabajo "
        endif;
        if(($_GET['checkTrab'])=='respon'):
                $table = 'mnt_responsable_orden';
                $sJoin = "INNER JOIN mnt_orden_trabajo ON mnt_responsable_orden.id_orden_trabajo=mnt_orden_trabajo.id_orden "
                        . "INNER JOIN mnt_estatus ON mnt_orden_trabajo.estatus=mnt_estatus.id_estado "             
                        . "LEFT JOIN mnt_asigna_cuadrilla ON mnt_responsable_orden.id_orden_trabajo=mnt_asigna_cuadrilla.id_ordenes "
                        . "LEFT JOIN mnt_cuadrilla ON mnt_asigna_cuadrilla.id_cuadrilla=mnt_cuadrilla.id "
                        . "INNER JOIN mnt_tipo_orden ON mnt_orden_trabajo.id_tipo=mnt_tipo_orden.id_tipo "
                        . "INNER JOIN dec_dependencia ON mnt_orden_trabajo.dependencia=dec_dependencia.id_dependencia " 
//                        . "LEFT JOIN mnt_ayudante_orden ON mnt_responsable_orden.id_orden_trabajo=mnt_ayudante_orden.id_orden_trabajo "
                        . "INNER JOIN dec_usuario ON mnt_responsable_orden.id_responsable=dec_usuario.id_usuario";
        endif;
        if(($_GET['checkTrab'])=='no' || $_GET['checkTrab'] =='tipo'):
                $sJoin = "INNER JOIN dec_dependencia ON mnt_orden_trabajo.dependencia=dec_dependencia.id_dependencia "
                . "INNER JOIN mnt_estatus ON mnt_orden_trabajo.estatus=mnt_estatus.id_estado "
                . "INNER JOIN mnt_tipo_orden ON mnt_orden_trabajo.id_tipo=mnt_tipo_orden.id_tipo ";
//                . "LEFT JOIN mnt_asigna_cuadrilla ON mnt_orden_trabajo.id_orden=mnt_asigna_cuadrilla.id_ordenes "
//                . "LEFT JOIN mnt_cuadrilla ON mnt_asigna_cuadrilla.id_cuadrilla=mnt_cuadrilla.id ";
//                . "LEFT JOIN mnt_ayudante_orden ON mnt_orden_trabajo.id_orden=mnt_ayudante_orden.id_orden_trabajo "
//                . "LEFT JOIN dec_usuario ON mnt_ayudante_orden.id_trabajador=dec_usuario.id_usuario";
//            endif;
        endif;
        $band =0;       
        if ($sWhere == ""):
            if (isset($filtro) && $filtro != ""):
                $sQuery = "SELECT SQL_CALC_FOUND_ROWS " . str_replace(" , ", " ", implode(", ", $aColumns)) . "
             FROM $table $sJoin $filtro ";
                $band = 1;
            else:
                $sQuery = "SELECT SQL_CALC_FOUND_ROWS " . str_replace(" , ", " ", implode(", ", $aColumns)) . "
             FROM $table $sJoin";
            endif;
            if (isset($_GET['trab']) AND $_GET['trab'] != ""):
                if ($band):
                    $sQuery = $sQuery . " AND id_trabajador = '$_GET[trab]' ";
                else:
                    $sQuery = $sQuery . " WHERE id_trabajador in ('$_GET[trab]') ";
                endif;
            endif;
            if (isset($_GET['respon']) AND $_GET['respon'] != ""):
                if ($band):
                    $sQuery = $sQuery . " AND id_responsable = '$_GET[respon]' ";
                else:
                    $sQuery = $sQuery . " WHERE id_responsable in ('$_GET[respon]') ";
                endif;
            endif;
            if (isset($_GET['tipo_orden']) AND $_GET['tipo_orden'] != ""):
                if ($band):
                    $sQuery = $sQuery . " AND mnt_orden_trabajo.id_tipo = '$_GET[tipo_orden]' $sOrder $sLimit";
                else:
                    $sQuery = $sQuery . " WHERE mnt_orden_trabajo.id_tipo in ('$_GET[tipo_orden]') $sOrder $sLimit";
                endif;
            else:
                $sQuery = $sQuery . " $sOrder $sLimit";
            endif;
        else:
            if (isset($filtro) && $filtro != ""):
                $sQuery = "SELECT SQL_CALC_FOUND_ROWS " . str_replace(" , ", " ", implode(", ", $aColumns)) . "
            FROM $table $sJoin $filtro $sWhere ";
                $band = 1;
            else:
                $sQuery = "SELECT SQL_CALC_FOUND_ROWS " . str_replace(" , ", " ", implode(", ", $aColumns)) . "
                FROM $table $sJoin $sWhere ";
            endif;
            if (isset($_GET['trab']) AND $_GET['trab'] != ""):
//            echo_pre(($_GET['trab'])); La idea es que en el if anterior se corte el query y se complete aqui para seguir 
//            la ejecucion segun lo que se necesita.
                if ($band):
                    $sQuery = $sQuery . " AND id_trabajador = '$_GET[trab]' ";
                else:
                    $sQuery = $sQuery . " AND id_trabajador in ('$_GET[trab]') ";
                endif;
            endif;
            if (isset($_GET['respon']) AND $_GET['respon'] != ""):
//            echo_pre(($_GET['trab'])); La idea es que en el if anterior se corte el query y se complete aqui para seguir 
//            la ejecucion segun lo que se necesita.
                if ($band):
                    $sQuery = $sQuery . " AND id_responsable = '$_GET[respon]' ";
                else:
                    $sQuery = $sQuery . " AND id_responsable in ('$_GET[respon]') ";
                endif;
            endif;
            if (isset($_GET['tipo_orden']) AND $_GET['tipo_orden'] != ""):
                if ($band):
                    $sQuery = $sQuery . " AND mnt_orden_trabajo.id_tipo = '$_GET[tipo_orden]' $sOrder $sLimit";
                else:
                    $sQuery = $sQuery . " AND mnt_orden_trabajo.id_tipo in ('$_GET[tipo_orden]') $sOrder $sLimit";
                endif;
            else:
                $sQuery = $sQuery . " $sOrder $sLimit";
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
//        echo_pre($rResult->result_array());
        if (($_GET['checkTrab'])=='respon'):
            foreach ($rResult->result_array() as $dat):
                $ayudantes[$dat['id_orden']] = $this->model_mnt_ayudante->ayudantes_DeOrden($dat['id_orden']);
            endforeach;
        endif;
//        echo_pre($ayudantes);
        //Aqui se crea el array que va a contener todos los datos que se necesitan para el datatable a medida que se obtienen de la tabla
        foreach ($rResult->result_array() as $i=>$sol):
            $cont=0;
            $row = array();
            /* aqui se evalua si es tiene permiso para ver el detalle de la solicitud */  
//            if($this->dec_permiso->has_permission ('mnt',13) || $this->dec_permiso->has_permission ('mnt',16)):
//                $row[] = '<div align="center"><a href="'.base_url().'index.php/mnt_solicitudes/detalle/'.$sol['id_orden'].'">'.$sol['id_orden'].'</a></div>';
//            else:
                $row[] = '<div align="center">'.$sol['id_orden'].'</div>';
//            endif; 
            $row[] = '<div align="center">'.date("d/m/Y", strtotime($sol['fecha'])).'</div>';
            if(!empty($est))://Evalua el est no este vacio
                $row[] = '<div align="center">'.date("d/m/Y", strtotime($this->model_mnt_estatus_orden->get_first_fecha($sol['id_orden']))).'</div>';
            endif;
            $row[] = $sol['dependen'];
            $row[] = $sol['asunto'];
            $row[] = '<div align="center">'.$sol['descripcion'].'</div>';  
            if((($_GET['checkTrab'])=='si') || $_GET['checkTrab']=='respon'):
                $row[]= $sol['nombre'].' '.$sol['apellido'];
            else:
                if(($_GET['checkTrab'])=='tipo'):
                    $row[] = $sol['tipo_orden'];
                else:
                    $row[] = '';
                endif;
            endif;
            if ($_GET['checkTrab']=='respon'):
                    foreach($ayudantes[$sol['id_orden']] as $id=>$ay): 
                        $aux[$id] = ucfirst(' '.$ay['nombre']).' '.$ay['apellido'];
                    endforeach;
                    $row[]= array_merge($aux);
            else:
                    $row[] = '';
            endif;       
            $output['data'][] = $row;
        endforeach;
        return $output;// Para retornar los datos al controlador
    }
}