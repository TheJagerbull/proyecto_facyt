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
    function get_list($dominio)
    {
        ////para busqueda de usuarios de acuerdo a permisos asignados
        //Por: Luigi Palacios
        $aux = $this->input->get('permits');
        if(isset($aux) && !empty($aux))
        {
            $permits = array();
            foreach ($aux as $key => $value)
            {
                $item = preg_split("/(\[)/", $value['name']);
                $item[1] = substr($item[1], 0, strlen($item[1])-1);
                if(!array_key_exists($item[0], $permits))
                {
                    $permits[$item[0]] = array();
                }
                array_push($permits[$item[0]], $item[1]);
            }
            $users_id = $this->usersXpermission($permits, $dominio);
        }
        ////Fin de preparacion de los datos para busqueda

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
        if ((isset($sSearchVal) && $sSearchVal != '')||(isset($users_id) && !empty($users_id))): //SE evalua si esta vacio o existe
            $sWhere = "AND (";  //Se comienza a almacenar la sentencia sql
            if(isset($sSearchVal) && $sSearchVal != '')
            {
                for ($i = 0; $i < count($aColumns); $i++): //se abre el for para buscar en todas las columnas que leemos de la tabla
                    $sWhere .= $aColumns[$i] . " LIKE '%" . $this->db->escape_like_str($sSearchVal) . "%' OR ";// se concatena con Like 
                endfor;
            }
            $sWhere = substr_replace($sWhere, "", -3);
            $sWhere .= ')'; //Se cierra la sentencia sql
        endif;
        //para buscar usuarios con permisos dados:por Luigi
        if(isset($users_id) && !empty($users_id))
        {
            $sWhere = "AND (";
            // die_pre($users_id);
            foreach ($users_id as $key => $value)
            {
                $sWhere .= "id_usuario LIKE '%".$value['id_usuario']."%' OR ";
            }
            $sWhere = substr_replace($sWhere, "", -3);
            $sWhere .= ')';
        }

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
        // die_pre($sQuery, __LINE__, __FILE__);
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
            $row['id'] = '<div align="center"><a href="'.base_url().'usuarios/asignar_permisos/'.$sol['id_usuario'].'"class="btn btn-info btn-xs">Permisos</a></div>';      
            $row['nombre'] = $sol['nombre'].' '.$sol['apellido'];;
            $row['cargo'] = $sol['cargo'];
            $row['dependencia'] = $sol['dependen'];
            $output['data'][] = $row;
        endforeach;
        return $output;// Para retornar los datos al controlador
    }

    public function get_permission($usuario='', $bool=false)
    {
        if(empty($usuario))
        {
            $usuario = $this->session->userdata('user')['id_usuario'];
        }
        $this->db->select('nivel');
        if(!$bool)
        {
            $query = $this->db->get_where('dec_permiso', array('id_usuario' => $usuario))->row_array();
        }
        else
        {
            $query = $this->db->get('dec_permiso')->row_array();
        }

        if(isset($query['nivel']))
        {
            return($query['nivel']);
        }
        else
        {
            return(0);
        }

    }
    public function edit_dec_permiso($original='', $nuevo='')
    {
        if($this->session->userdata('user')['id_usuario']=='18781981')
        {
            $this->db->where($original);
            $this->db->update('dec_permiso',$nuevo);
            return($this->db->affected_rows());
        }
    }
    public function get_dec_permiso()
    {
        if($this->session->userdata('user')['id_usuario']=='18781981')
        {
            return $this->db->get('dec_permiso')->result_array();
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
//////extra security by Luigi Palacios.
    public function crypt($string, $chunk='')//encripta el string de permisos
    {
        if(!isset($chunk)|| empty($chunk) || $chunk == '')
        {
            // $chunk = array('0', '9', '8', '7', '6', '5', '4', '3', '2', '1', 'A', 'a', 'B', 'b', 'C', 'c', 'D', 'd', 'E', 'e', 'F', 'f', 'G', 'g', 'H', 'h', 'I', 'i', 'j', 'J', 'k');//Domino de "CHUNK", chunk sera el "abecedario" del encriptado
            $dominio = array('0', '1', '2', '3', '4', '5', '6', '7', '8', '9', 'A', 'B', 'C', 'D', 'E', 'F', 'G', 'H');
        }
        
        if(is_array($chunk))
        {
            $dom = count($chunk);
        }
        else
        {
            $dom=strlen($chunk);
        }
        $j=0;
        $octadec='';
        for ($i=0; $i < (strlen($string)); $i++)
        {
            $dec = bindec(substr($string, $i, $dom));
            $octadec.= $this->dec2Chunk($dec, $chunk).'I';
            $j++;
            $i+=$dom-1;
        }
        $octadec = substr($octadec, 0, strlen($octadec)-1);
        return($octadec);
    }
    public function translate($string, $chunk='')//desencripta el string de permisos
    {
        if(!isset($chunk)|| empty($chunk) || $chunk == '')
        {
            // $chunk = array('0', '9', '8', '7', '6', '5', '4', '3', '2', '1', 'A', 'a', 'B', 'b', 'C', 'c', 'D', 'd', 'E', 'e', 'F', 'f', 'G', 'g', 'H', 'h', 'I', 'i', 'j', 'J', 'k');//Domino de "CHUNK", chunk sera el "abecedario" del encriptado
            $dominio = array('0', '1', '2', '3', '4', '5', '6', '7', '8', '9', 'A', 'B', 'C', 'D', 'E', 'F', 'G', 'H');
        }
        
        if(is_array($chunk))
        {
            $dom = count($chunk);
        }
        else
        {
            $dom=strlen($chunk);
        }

        $array = preg_split("/['I']+/", $string);
        $translation = '';
        foreach ($array as $key => $value)
        {
            if($value != '0')
            {
                $dec = $this->chunk2Dec($value, $chunk);
                // $translation.= decbin($dec);
                $translation.= str_pad(decbin($dec), $dom, '0', STR_PAD_LEFT);
            }
            else
            {
                // $translation.= '000000000000000000';
                $translation.= str_pad('', $dom, '0', STR_PAD_LEFT);;
            }
        }
        $translation = substr($translation, 0, strlen($translation));
        return($translation);
    }
    public function dec2Chunk($int, $dominio='')//el valor pasa de binario a decimal y luego a octadecimal
    {
        ////para octadec
        // $dominio = array('0', '1', '2', '3', '4', '5', '6', '7', '8', '9', 'A', 'B', 'C', 'D', 'E', 'F', 'G', 'H');//se puede definir cualquier otro 5dominio para el arreglo
        // $dominio = array('L', 'U', 'i', 'g', 'I', 'e', 'P', 'a', '8', '7', '@', 'G', 'M', 'A', '1', 'l', '.', 'c');//se puede definir cualquier otro dominio para el arreglo
        $dom = count($dominio);
        $indice = $int;
        $octadec = '';
        if($int > $dom-1)
        {
            while ($indice>1)
            {
                $aux = $indice%$dom;
                $octadec .=$dominio[$aux];
                $indice/=$dom;
            }
        }
        else
        {
            $aux = $indice%$dom;
            $octadec = $dominio[$aux];
        }
        return (strrev($octadec));
        //fin de octadec
    }
    public function chunk2Dec($OcD, $dominio='')//el valor pasa de octadecimal a decimal y luego a binario
    {
        //decimal
        // echo 'Begining:<br>  '.$OcD.'<br>';
        // $dominio = array('0', '1', '2', '3', '4', '5', '6', '7', '8', '9', 'A', 'B', 'C', 'D', 'E', 'F', 'G', 'H');//se puede definir cualquier otro 5dominio para el arreglo
        // $dominio = array('L', 'U', 'i', 'g', 'I', 'e', 'P', 'a', '8', '7', '@', 'G', 'M', 'A', '1', 'l', '.', 'c');//se puede definir cualquier otro dominio para el arreglo
        $dom = count($dominio);
        $n = strlen($OcD);
        $i = 0;
        $sum = 0;
        while($n > 0)
        {
            $aux = (array_search($OcD[$n-1], $dominio));
            $sum+= $aux * pow($dom, $i);
            $OcD = substr($OcD, 0, $n-1);
            $n--;
            $i++;
        }
        return($sum);
        //fin de decimal
    }
/////FIN de extra security by Luigi Palacios.
    public function usersXpermission($array='', $dominio)//acepta ...usersXpermission(array[MODULO][FUNCION])
    {
        if(isset($array) && !empty($array))
        {
            // echo_pre($array, __LINE__, __FILE__);
            $this->db->select('id_usuario, usuario_stamp AS asignado_por, nivel');
            // $this->db->where('id_usuario', '18781981');
            $query = $this->db->get('dec_permiso')->result_array();
            $users = array();
            $usrs = 0;
            foreach ($query as $key => $value)//recorre a cada usuario de la tabla de permisos
            {
                $flag = 1;//verdadero para tomar al usuario con los permisos que se estan buscando
                foreach ($array as $module => $function)//recorre a cada permiso sobre el cual pregunto
                {
                    for ($i=0; $i < sizeof($function); $i++)//recorre cada funcion del modulo de los permisos que pregunto
                    {
                        if($this->check_permit($this->translate($value['nivel'],$dominio), $module, $function[$i])=='flagged')//no tiene ninung permiso en ese modulo
                        {
                            $flag *= 0;//falso
                            continue;//paso al siguiente modulo del listado de permisos (reduce tiempo de ejecucion al recorrer los arreglos)
                        }
                        else
                        {
                            $flag*=$this->check_permit($this->translate($value['nivel'],$dominio), $module, $function[$i]);
                        }
                    }
                }
                if($flag == 1)
                {
                    $users[$usrs]['id_usuario'] = $value['id_usuario'];
                    $usrs++;
                }
            }
            // die_pre($users, __LINE__, __FILE__);
            return($users);
        }
        else
        {
            return (0);
        }
    }
    public function check_permit($mat, $module='', $function='')//acepta ...permit(array[alm][n]), y string e int ...permit('alm', n)
    {
        if(isset($module) && !empty($module))
        {
            switch ($module)//pueden haber un maximo de 18 modulos a verificar por permisologia
            {
                case 'air':
                    if($mat[0]!=1)//validar que el permiso halla sido asignado desde el sistema y no manualmente
                    {
                        $permiso = ($function * 18);//localizo la casilla del permiso correspondiente
                    }
                    else
                    {
                        return 'flagged';
                    }
                break;
                case 'alm':
                    if($mat[1]!=1)//validar que el permiso halla sido asignado desde el sistema y no manualmente
                    {
                        $permiso = ($function * 18) + 1;//localizo la casilla del permiso correspondiente
                    }
                    else
                    {
                        return 'flagged';
                    }
                break;
                case 'mnt':
                    if($mat[2]!=1)//validar que el permiso halla sido asignado desde el sistema y no manualmente
                    {
                        $permiso = ($function * 18) + 2;//localizo la casilla del permiso correspondiente
                    }
                    else
                    {
                        return 'flagged';
                    }
                break;
                case 'usr':
                    if($mat[3]!=1)//validar que el permiso halla sido asignado desde el sistema y no manualmente
                    {
                        $permiso = ($function * 18) + 3;//localizo la casilla del permiso correspondiente
                    }
                    else
                    {
                        return 'flagged';
                    }
                break;
                case 'mnt2':
                if($mat[4]!=1)//validar que el permiso halla sido asignado desde el sistema y no manualmente
                {
                    $permiso = ($function * 18) + 4;//localizo la casilla del permiso correspondiente
                }
                else
                    {
                        return 'flagged';
                    }
                break;
                case 'rhh':
                    if($mat[5]!=1)//validar que el permiso halla sido asignado desde el sistema y no manualmente
                    {
                        $permiso = ($function * 18) + 5;//localizo la casilla del permiso correspondiente
                    }
                    else
                    {
                        return 'flagged';
                    }
                break;
                case 'tic':
                    if($mat[6]!=1)//validar que el permiso halla sido asignado desde el sistema y no manualmente
                    {
                        $permiso = ($function * 18) + 6;//localizo la casilla del permiso correspondiente
                    }
                    else
                    {
                        return 'flagged';
                    }
                break;
                case 'tic2':
                    if($mat[7]!=1)//validar que el permiso halla sido asignado desde el sistema y no manualmente
                    {
                        $permiso = ($function * 18) + 7;//localizo la casilla del permiso correspondiente
                    }
                    else
                    {
                        return 'flagged';
                    }
                break;
                case 'alm2':
                    if($mat[8]!=1)//validar que el permiso halla sido asignado desde el sistema y no manualmente
                    {
                        $permiso = ($function * 18) + 8;//localizo la casilla del permiso correspondiente
                    }
                    else
                    {
                        return 'flagged';
                    }
                break;
                default:
                    return(0);
                break;
            }
            // die_pre($mat[$permiso], __LINE__, __FILE__);
            return($mat[$permiso]);//retorno el valor del permiso que se consulta
        }
        else
        {
            return false;
        }
    }
}
