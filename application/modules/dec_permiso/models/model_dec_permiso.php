<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Model_dec_permiso extends CI_Model
{
	//constructor predeterminado del modelo
	function __construct()
	{
		parent::__construct();
	}
     var $table = 'dec_usuario'; //El nombre de la tabla que estamos usando
   //Esta es la funcion que trabaja correctamente al momento de cargar los datos desde el servidor para el datatable 
    function get_list()
    { 
       
        /* Array de las columnas para la table que deben leerse y luego ser enviados al DataTables. Usar ' ' donde
         * se desee usar un campo que no este en la base de datos
         */
        $aColumns = array('nombre', 'cargo', 'dependen', 'apellido', 'id_usuario');
  
        /* Indexed column (se usa para definir la cardinalidad de la tabla) */
        $sIndexColumn = "id_usuario";
        
        /* $filtro (Se usa para filtrar la vista del Asistente de autoridad) La intencion de usar esta variable
        es para usarla en el query que se va a construir mas adelante. Este datos es modificable */
        $filtro = "WHERE status = 'activo' AND sys_rol != 'no_visible'";
        $sJoin = " INNER JOIN dec_dependencia ON dec_usuario.id_dependencia=dec_dependencia.id_dependencia "; 

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
                    $sWhere = "AND ";
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
            $sQuery = "SELECT SQL_CALC_FOUND_ROWS " . str_replace(" , ", " ", implode(", ", $aColumns)) . "
            FROM $this->table $sJoin $filtro $sOrder $sLimit";
        else:
            $sQuery = "SELECT SQL_CALC_FOUND_ROWS " . str_replace(" , ", " ", implode(", ", $aColumns)) . "
            FROM $this->table $sJoin $filtro $sWhere $sOrder $sLimit";
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
            $row['id'] = '<div align="center"><a href="'.base_url().'index.php/usuarios/asignar_permisos/'.$sol['id_usuario'].'"class="btn btn-info btn-xs">Permisos</a></div>';      
            $row['nombre'] = $sol['nombre'].' '.$sol['apellido'];;
            $row['cargo'] = $sol['cargo'];
            $row['dependencia'] = $sol['dependen'];
            $output['data'][] = $row;
        endforeach;
        return $output;// Para retornar los datos al controlador
    }

    public function get_permission($usuario='')
    {
        if(empty($usuario))
        {
            $usuario = $this->session->userdata('user')['id_usuario'];
        }
        $this->db->select('nivel');
        $query = $this->db->get_where('dec_permiso', array('id_usuario' => $usuario))->row_array();
        if(isset($query['nivel']))
        {
            return($query['nivel']);
        }
        else
        {
            return(0);
        }

    }

    public function set_permission($usuario)
    {
        $usuario['usuario_stamp'] = $this->session->userdata('user')['id_usuario'];//para registrar el usuario que realiza la operacion
        $query = $this->db->get_where('dec_permiso', array('id_usuario' => $usuario['id_usuario']))->row_array();
        if(!empty($query))//si el usuario ya esta en la tabla con permiso asignado
        {
            echo "si hay usuario </br>";
            $update_id = 0;
            $result = $query;
            $update_id = $result['ID'];
            // die_pre($result['ID'], __LINE__, __FILE__);
            $this->db->where(array('id_usuario' => $usuario['id_usuario']));
            $this->db->update('dec_permiso', $usuario);
            return($update_id);
        }
        else//si el usuario no esta en la tabla, se le asigna permisos por primera vez
        {
            echo "no hay usuario </br>";
            $this->db->insert('dec_permiso', $usuario);
            return ($this->db->insert_id());
        }
        die_pre($usuario, __LINE__, __FILE__);
        // $this->db->where();
    }

    public function get_Ptable()
    {
        return ($this->db->get('dec_permiso')->result_array());
    }
	
}
