<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Model_dec_usuario extends CI_Model
{
	//constructor predeterminado del modelo
	function __construct()
	{
		parent::__construct();
	}
	
	//verifica la combinacion de usuario y contrasena, y en case de que exista, devuelve todos los datos del usuario
	//se usa para las sesiones (Linea 43 del controlador usuario.php)
	public function existe($post)
	{
		$data = array
		(
			'id_usuario' => $post['id'],
			'password' => $post['password']
		);
		$query = $this->db->get_where('dec_usuario',$data);
		if($query->num_rows() == 1)
		{
			return $query->row();
		}
		else
		{
			return FALSE;
		}
	}
	//verifica si el usuario esta activo en el sistema, para el controlador, linea 14
	public function is_active($where)
	{
		$this->db->where_not_in('status', 'inactivo');
		$query = $this->db->get_where('dec_usuario',$where);
        if($query->num_rows() > 0)
            return TRUE;

        return FALSE;
	}
	//verifica si el usuario tiene un rol asignado en el sistema, para el controlador, linea 14
	public function rol_asign($where)
	{
		$this->db->where_not_in('sys_rol', 'no_visible');
		$query = $this->db->get_where('dec_usuario',$where);
        if($query->num_rows() > 0)
            return TRUE;

        return FALSE;
	}
	//verifica que el usuario se encuentra en la base de datos, para el controlador, linea 14
	public function exist($where)
    {
        $query = $this->db->get_where('dec_usuario',$where);
        if($query->num_rows() > 0)
            return TRUE;

        return FALSE;
    }
	public function get_userCount()
	{
		return($this->db->count_all('dec_usuario'));
	}
	//la funcion se usa para mostrar los usuarios de la base de datos en alguna tabla...
	//para filtrar los roles, y cualquier dato de alguna columna, se debe realizar con condicionales desde la vista en php
	public function get_allusers($field='',$order='', $per_page='', $offset='')
	{
		// SE EXTRAEN TODOS LOS DATOS DE TODOS LOS USUARIOS
		if(!empty($field))
			$this->db->order_by($field, $order);
		$query = $this->db->get('dec_usuario', $per_page, $offset);
		return $query->result();
	}
	
	public function get_oneuser($id_usuario='')
	{
		if(!empty($id_usuario))
		{
			$this->db->where('ID',$id_usuario);
			// SE EXTRAEN TODOS LOS DATOS DEl USUARIO
			$query = $this->db->get('dec_usuario');
			return $query->row();
		}
		return FALSE;
	}
    public function get_basicUserdata($id_usuario)
    {
    	$this->db->select('nombre, apellido, id_usuario, status');
    	if(is_array($id_usuario))
    	{
    		return($this->db->get_where('dec_usuario', $id_usuario)->row_array());
    	}
    	if(!is_array($id_usuario))
    	{
    		return($this->db->get_where('dec_usuario', array('id_usuario' => $id_usuario))->row_array());
    	}
    }
    //agregado por jcparra para mostrar datos de los usuarios de la cuadrilla
    public function get_user_cuadrilla($id_usuario='')
	{
        if (!empty($id_usuario)) {
            $this->db->where('id_usuario', $id_usuario);
            $this->db->where('status', 'activo');
            $this->db->select('nombre , apellido');
            $query = $this->db->get('dec_usuario');
            foreach ($query->result_array() as $prueb) {
                $completo = (($prueb['nombre']) . ' ' . ($prueb['apellido']));
            }
            if (!empty($completo)):
                return $completo;
            endif;
        }
        return FALSE;
    }

    public function insert_user($data='')
	{
		if(!empty($data))
		{
			$this->db->insert('dec_usuario',$data);
			return $this->db->insert_id();
		}
		return FALSE;
	}
	
	public function edit_user($data='')
	{
		if(!empty($data))
		{
                    if(isset($data['ID'])){
			$this->db->where('ID',$data['ID']);
                    }else{
                        $this->db->where('id_usuario',$data['id_usuario']);
                    }
			$this->db->update('dec_usuario',$data);
			return $data['ID'];
		}
		return FALSE;
	}
	
	public function drop_user($id='')
	{
		if(!empty($id))
		{
			//$this->db->delete('dec_usuario',array('ID'=>$id));
			$this->db->where('ID', $id);
			$data = array(
					'status'=> 'inactivo'
					);
			$this->db->update('dec_usuario', $data);
			return TRUE;
		}
		return FALSE;
	}

	public function activate_user($id='')
	{
		if(!empty($id))
		{
			//$this->db->delete('dec_usuario',array('ID'=>$id));
			$this->db->where('ID', $id);
			$data = array(
					'status'=> 'activo'
					);
			$this->db->update('dec_usuario', $data);
			return TRUE;
		}
		return FALSE;
	}
	public function buscar_usr($usr='', $field='', $order='', $per_page='', $offset='')//al modificar aqui hay que modificar en buscar_usrCount($usr='')
	{
		if(!empty($usr))
		{
			if(!empty($field))
			{
				$this->db->order_by($field, $order);
			}
			$usr=preg_split("/[',']+/", $usr);
			$first = $usr[0];
			if(!empty($usr[1]))
			{
				$second = $usr[1];
				$this->db->like('apellido',$second);
			}
			if(!empty($usr[2]))
			{
				$third = $usr[2];
				$this->db->like('id_usuario',$third);
			}
			if(strlen($first)>2)
			{
				$this->db->like('nombre',$first);
				$this->db->or_like('apellido',$first);
				$this->db->or_like('id_usuario',$first);
				$this->db->or_like('sys_rol',$first);
				// $this->db->or_like('dependencia',$first); //hay que acomodar, ahora dependencia es un codigo
				$this->db->or_like('cargo',$first);
				$this->db->or_like('status',$first);
				$this->db->or_like('tipo',$first);
			}
			else
			{
				$this->db->like('nombre', $first, 'after');
				$this->db->or_like('apellido',$first, 'after');
			}
			if(!empty($per_page)&& !empty($offset))
			{
				return $this->db->get('dec_usuario', $per_page, $offset)->result();
			}
			else
			{
				return $this->db->get('dec_usuario')->result();
			}
		}
		return FALSE;
	}
	public function buscar_usrCount($usr='')//
	{
		if(!empty($usr))
		{
			$usr=preg_split("/[',']+/", $usr);
			$first = $usr[0];
			if(!empty($usr[1]))
			{
				$second = $usr[1];
				$this->db->like('apellido',$second);
			}
			if(!empty($usr[2]))
			{
				$third = $usr[2];
				$this->db->like('id_usuario',$third);
			}
			if(strlen($first)>2)
			{
				$this->db->like('nombre',$first);
				$this->db->or_like('apellido',$first);
				$this->db->or_like('id_usuario',$first);
				$this->db->or_like('sys_rol',$first);
				// $this->db->or_like('dependencia',$first); //hay que acomodar, ahora dependencia es un codigo
				$this->db->or_like('cargo',$first);
				$this->db->or_like('status',$first);
				$this->db->or_like('tipo',$first);
			}
			else
			{
				$this->db->like('nombre', $first, 'after');
				$this->db->or_like('apellido',$first, 'after');
			}
			
			return $this->db->count_all_results('dec_usuario');
		}
		return FALSE;
	}

	public function get_userObrero()
	{
                $this->db->order_by('nombre','asc');
                $this->db->select('id_usuario,nombre,apellido,telefono,cargo');
		$this->db->where('tipo', 'obrero');
                $this->db->or_where('cargo', 'Jefe de Mantenimiento');
		$this->db->where('status', 'activo');
		$result = $this->db->get('dec_usuario')->result_array();
		return($result);
	}
        //by jcparra para mostrar en mnt crear solicitud de mantenimiento
        public function get_user_activos($id_dependen='')
	{
            $this->db->select('id_usuario,nombre,apellido,telefono,id_dependencia');
            if(!empty($id_dependen)){
                $this->db->where('id_dependencia', $id_dependen);   
            }
            $this->db->where('status', 'activo');
            $result = $this->db->get('dec_usuario')->result_array();
            return($result);
	}
         public function get_user_activos_dep($id_dep='')
	{
                $this->db->select('id_usuario,nombre,apellido,telefono,id_dependencia,cargo');
                $this->db->where('id_dependencia',$id_dep);
		$this->db->where('status', 'activo');
                $result = $this->db->get('dec_usuario')->result_array();
		return($result);
	}

	public function ajax_likeUsers($data)
	{
		$this->db->like('nombre', $data);
		$this->db->or_like('apellido',$data);
		$this->db->or_like('id_usuario',$data);
		$query = $this->db->get('dec_usuario');
		return $query->result();
	}
        
    var $table = 'dec_usuario'; //El nombre de la tabla que estamos usando

    //Esta es la funcion que trabaja correctamente al momento de cargar los datos desde el servidor para el datatable 

    function get_list() {

        /* Array de las columnas para la table que deben leerse y luego ser enviados al DataTables. Usar ' ' donde
         * se desee usar un campo que no este en la base de datos
         */
        $aColumns = array('id_usuario', 'nombre', 'sys_rol','status','status','apellido','cargo', 'dependen','ID');

        /* Indexed column (se usa para definir la cardinalidad de la tabla) */
        $sIndexColumn = "id_usuario";
//        echo_pre($_GET['dep']);
        /* $filtro (Se usa para filtrar la vista del Asistente de autoridad) La intencion de usar esta variable
          es para usarla en el query que se va a construir mas adelante. Este datos es modificable */
        if($this->dec_permiso->has_permission('usr', 3)):
            $filtro = "WHERE dec_usuario.id_dependencia = $_GET[dep]";
        endif;
        $sJoin = " INNER JOIN dec_dependencia ON dec_usuario.id_dependencia=dec_dependencia.id_dependencia ";

        /* Se establece la cantidad de datos que va a manejar la tabla (el nombre ya esta declarado al inico y es almacenado en var table */
        if(isset($filtro)):
            $sQuery = "SELECT COUNT('" . $sIndexColumn . "') AS row_count FROM $this->table $sJoin $filtro ";
        else:
            $sQuery = "SELECT COUNT('" . $sIndexColumn . "') AS row_count FROM $this->table $sJoin ";
        endif;
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
                $sQuery = "SELECT SQL_CALC_FOUND_ROWS " . str_replace(" , ", " ", implode(", ", $aColumns)) . "
                FROM $this->table $sJoin $sOrder $sLimit";
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
       
        //Aqui se crea el array que va a contener todos los datos que se necesitan para el datatable a medida que se obtienen de la tabla
        $aux='<script>'
                . '$("[name=' . "'".'my-checkbox' . "'".']").bootstrapSwitch()'
                . '</script>';

        foreach ($rResult->result_array() as $sol):
            $row = array();
            if($this->dec_permiso->has_permission('usr',4)):
                $row['id'] = '<div align="center"><a href="' . base_url() . 'usuario/detalle/' . $sol['ID'] . '">'.$sol['id_usuario'].'</a></div>';
            else:
                if($sol['id_usuario']== $this->session->userdata('user')['id_usuario']):
                    $row['id'] = '<div align="center"><a href="' . base_url() . 'usuario/detalle/' . $sol['ID'] . '">'.$sol['id_usuario'].'</a></div>';
                else:
                    $row['id'] = '<div align="center">'.$sol['id_usuario'].'</div>';
                endif;
            endif;
            $row['nombre'] = $sol['nombre'] . ' ' . $sol['apellido'];
            switch ($sol['sys_rol']) {
                case 'autoridad':
                    $row['rol'] = 'Autoridad';
                    break;
                case 'asist_autoridad':
                    $row['rol'] = 'Asistente de autoridad';
                    break;
                case 'jefe_alm':
                    $row['rol'] = 'Jefe de almacen';
                    break;
                case 'director_dep':
                    $row['rol'] = 'Director de dependencia';
                    break;
                case 'asistente_dep':
                    $row['rol'] = 'Asistente de dependencia';
                    break;
                case 'ayudante_alm':
                    $row['rol'] = 'Ayudante de almacen';
                    break;
                case 'resp_cuad':
                    $row['rol'] = 'Jefe de cuadrilla';
                    break;
                default:
                    $row['rol'] = 'No autorizado';
                    break;
            }
            $row['status'] = $sol['status'];
            if ($sol['status'] == 'activo'):
                $row['estatus'] = '<div align="center" title ="Activado"><img src="'.base_url().'assets/img/user/active.png" class="img-rounded" alt="bordes redondeados" width="25" height="25"></div>';
                $row['check'] = '<div align="center"><input data-on-text="I" data-off-text="O" value="NO" onChange="desacivar('.$sol['ID'].')" type="checkbox" name="my-checkbox" data-size="mini" checked></div>'.$aux;
            endif;
            if ($sol['status'] == 'inactivo'):
                $row['estatus'] = '<div align="center" title ="Desactivado"><img src="'.base_url().'assets/img/user/desactive.png" class="img-rounded" alt="bordes redondeados" width="25" height="25"></div>';
                $row['check'] = '<div align="center"><input data-on-text="I" data-off-text="O" value="NO" onChange="activar('.$sol['ID'].')" type="checkbox" name="my-checkbox" data-size="mini"></div>'.$aux;
            endif;
            $output['data'][] = $row;
        endforeach;
        return $output; // Para retornar los datos al controlador
    }

    // public function get_usersByDep($dependencia)
	// {

	// }

}