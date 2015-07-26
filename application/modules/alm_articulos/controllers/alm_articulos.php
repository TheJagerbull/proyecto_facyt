<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Alm_articulos extends MX_Controller
{
	function __construct() //constructor predeterminado del controlador
    {
        parent::__construct();
        $this->load->library('form_validation');
		$this->load->model('model_alm_articulos');
    }

    public function index()
    {
    	if($this->session->userdata('user'))
		{
			$header['title'] = 'Articulos';
			$view['inventario'] = $this->model_alm_articulos->get_allArticulos();

	    	$this->load->view('template/header', $header);
	    	$this->load->view('principal', $view);
	    	$this->load->view('template/footer');
		}
		else
		{
			$header['title'] = 'Error de Acceso';
			$this->load->view('template/erroracc',$header);
		}
    }

    public function insertar_articulo()
    {
    	if($this->session->userdata('user'))
		{
			if($_POST)
			{
				echo 'HELL-O';
			}


			$header['title'] = 'Inserción de Articulos';
	    	$this->load->view('template/header', $header);

	    	$this->load->view('template/footer');
		}
		else
		{
			$header['title'] = 'Error de Acceso';
			$this->load->view('template/erroracc',$header);
		}
    }

    public function categoria_articulo()
    {
		if($this->session->userdata('user'))
		{
			$this->load->view('template/header');
	    	echo "evil, rule through the crazy";
	    	$this->load->view('template/footer');
		}
		else
		{
			$header['title'] = 'Error de Acceso';
			$this->load->view('template/erroracc',$header);
		}
    }

    public function get_artCount()
    {
    	return $this->model_alm_articulos->count_articulos();
    }
    public function listar_articulos()
    {
    	if($this->session->userdata('user'))
		{

			$this->load->view('template/header');

	    	$this->load->view('template/footer');
		}
		else
		{
			$header['title'] = 'Error de Acceso';
			$this->load->view('template/erroracc',$header);
		}
    }

    public function buscar_articulos($field='',$order='', $per_page='', $offset='')
	{
		if($this->session->userdata('query'))
		{
			//
			if($this->session->userdata('query')=='' ||$this->session->userdata('query')==' ')
			{
				$this->session->unset_userdata('query');
				
				redirect(base_url().'index.php/solicitud/inventario');
			}
			
			$header['title'] = 'Buscar articulos';
			return($this->model_alm_articulos->find_articulo($this->session->userdata('query'), $field, $order, $per_page, $offset));
			
		}
		else
		{
			redirect('/solicitud/inventario');
		}
	}

    public function ajax_likeArticulos()
	{
		// error_log("Hello", 0);
		$articulo = $this->input->post('articulos');
		header('Content-type: application/json');
		$query = $this->model_alm_articulos->ajax_likeArticulos($articulo);
		$query = objectSQL_to_array($query);
		echo json_encode($query);
	}

	public function getSystemWideTable()
    {
        /* Array of database columns which should be read and sent back to DataTables. Use a space where
         * you want to insert a non-database field (for example a counter or static image)
         */
        $aColumns = array('ID', 'cod_articulo', 'descripcion', 'exist', 'reserv', 'disp');
        
        // DB table to use
        $sTable = 'alm_articulo';
        //
    
        $iDisplayStart = $this->input->get_post('iDisplayStart', true);
        $iDisplayLength = $this->input->get_post('iDisplayLength', true);
        $iSortCol_0 = $this->input->get_post('iSortCol_0', true);
        $iSortingCols = $this->input->get_post('iSortingCols', true);
        $sSearch = $this->input->get_post('sSearch', true);
        $sEcho = $this->input->get_post('sEcho', true);
    
        // Paging
        if(isset($iDisplayStart) && $iDisplayLength != '-1')
        {
            $this->db->limit($this->db->escape_str($iDisplayLength), $this->db->escape_str($iDisplayStart));
        }
        
        // Ordering
        if(isset($iSortCol_0))
        {
            for($i=0; $i<intval($iSortingCols); $i++)
            {
                $iSortCol = $this->input->get_post('iSortCol_'.$i, true);
                $bSortable = $this->input->get_post('bSortable_'.intval($iSortCol), true);
                $sSortDir = $this->input->get_post('sSortDir_'.$i, true);
    
                if($bSortable == 'true')
                {
                    $this->db->order_by($aColumns[intval($this->db->escape_str($iSortCol))], $this->db->escape_str($sSortDir));
                }
            }
        }
        
        /* 
         * Filtering
         * NOTE this does not match the built-in DataTables filtering which does it
         * word by word on any field. It's possible to do here, but concerned about efficiency
         * on very large tables, and MySQL's regex functionality is very limited
         */
        if(isset($sSearch) && !empty($sSearch))
        {
            for($i=0; $i<count($aColumns); $i++)
            {
                if($i!=3)//para no buscar en la columna exist (arroja error si no la filtro)
                {
                    $bSearchable = $this->input->get_post('bSearchable_'.$i, true);
                    
                    // Individual column filtering
                    if(isset($bSearchable) && $bSearchable == 'true')
                    {
                        $this->db->or_like($aColumns[$i], $this->db->escape_like_str($sSearch));
                    }
                }
            }
        }
        
        // Select Data
        // $this->db->select('SQL_CALC_FOUND_ROWS '.str_replace(' , ', ' ', implode(', ', $aColumns)), false);
        if(!$this->hasPermissionClassA() && !$this->hasPermissionClassC)
        {
            $this->db->where('ACTIVE', 1);
        }
        $this->db->select('SQL_CALC_FOUND_ROWS *, disp + reserv as exist', false);
        $rResult = $this->db->get($sTable);
    
        // Data set length after filtering
        $this->db->select('FOUND_ROWS() AS found_rows');
        $iFilteredTotal = $this->db->get()->row()->found_rows;
    
        // Total data set length
        $iTotal = $this->db->count_all($sTable);
    
        // Output
        $output = array(
            'sEcho' => intval($sEcho),
            'iTotalRecords' => $iTotal,
            'iTotalDisplayRecords' => $iFilteredTotal,
            'aaData' => array()
        );
        $i=1+$iDisplayStart;
        foreach($rResult->result_array() as $aRow)//construccion a pie de los campos a mostrar en la lista, cada $row[] es una fila de la lista, y lo que se le asigna en el orden es cada columna
        {
            $row = array();
            
            // foreach($aColumns as $col)
            // {
            //     $row[] = $aRow[$col];
            // }
            $row[]= $i;//primera columna
            $i++;
            $row[]= $aRow['cod_articulo'];//segunda columna
            $row[]= $aRow['descripcion'];//tercera columna
            $row[]= $aRow['exist'];//cuarta columna
            $row[]= $aRow['reserv'];//quinta columna
            $row[]= $aRow['disp'];//sexta columna
            $aux = '<div id="art'.$aRow['ID'].'" class="modal modal-message modal-info fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h4 class="modal-title">Detalles</h4>
                                </div>
                                <div class="modal-body">
                                    <div>
                                        <h4><label>Solicitud Número: 
                                                 '.$aRow['cod_articulo'].'
                                            </label></h4>
                                            <table id="item'.$aRow['ID'].'" class="table">
                                                ';
                                                    foreach ($aRow as $key => $column)
                                                    {
                                                        $aux=$aux.'<tr>
                                                                        <td><strong>'.$key.'</strong></td>
                                                                        <td>:<td>
                                                                        <td>'.$column.'</td>
                                                                    </tr>';
                                                    }
                                                    $aux=$aux.'
                                            </table>
                                    </div>

                                    <div class="modal-footer">
                                         
                                    </div>
                                </div>
                            </div>
                        </div> 
                    </div>';
            $row[]='<a href="#art'.$aRow['ID'].'" data-toggle="modal"><i class="glyphicon glyphicon-zoom-in color"></i></a>'.$aux;//cuarta columna
            $output['aaData'][] = $row;
        }
    
        echo json_encode($output);
        // explore_code($output);
    }

    public function modal_detalles($ID)
    {
        $aRow = $this->model_alm_articulos->get_articulo($ID, TRUE);
        echo_pre($aRow, __LINE__, __FILE__);
        $aux = '<div id="art'.$aRow['ID'].'" class="modal modal-message modal-info fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h4 class="modal-title">Detalles</h4>
                                </div>
                                <div class="modal-body">
                                    <div>
                                        <h4><label>Solicitud Número: 
                                                 '.$aRow['cod_articulo'].'
                                            </label></h4>
                                            <table id="item'.$aRow['ID'].'" class="table">
                                                ';
                                                    foreach ($aRow as $key => $column)
                                                    {
                                                        $aux=$aux.'<tr>
                                                                        <td><strong>'.$key.'</strong></td>
                                                                        <td>:<td>
                                                                        <td>'.$column.'</td>
                                                                    </tr>';
                                                    }
                                                    $aux=$aux.'
                                            </table>
                                    </div>

                                    <div class="modal-footer">
                                         
                                    </div>
                                </div>
                            </div>
                        </div> 
                    </div>';
        return($aux);
    }
    public function ajax_formProcessing()
    {
        if ($this->input->post())
        {
            $aux = explode(" codigo=", $this->input->post('descripcion'));
            if(is_numeric($aux[0]))//verifica si la primera ocurrencia del dato recibido, es un numero (para asociar con el codigo del articulo)
            {
                $articulo['cod_articulo']=$aux[0];
            }
            else
            {
                $articulo['descripcion']=$aux[0];
                if(!empty($aux[1]))//verifica si al pasar la descripcion, viene en el formato del autocompletar
                {
                    $articulo['cod_articulo']=$aux[1];
                }
            }
            if(!$this->model_alm_articulos->exist_articulo($articulo))//aqui construllo el formulario de articulo nuevo
            {
            ?>
                <div class="alert alert-danger"> Debe agregar todos los detalles del articulo nuevo para inventario, definiendo un codigo unico para el articulo nuevo
                </div>
                <form class="form-horizontal">
                    <!-- cod_articulo -->
                    <div class="form-group">
                        <label class="control-label" for="cod_articulo">Codigo:</label>
                        <input type="text" class="form-control" id="cod_articulo" name="cod_articulo">
                    </div>
                    
                    <!-- unidad -->
                    <div class="form-group">
                        <label class="control-label" for="unidad">Unidad:</label>
                        <input type="text" class="form-control" id="unidad" name="unidad">
                    </div>
                    
                    <!-- descripcion -->
                    <div class="form-group">
                        <label class="control-label" for="descripcion">Descripcion:</label>
                        <input type="text" class="form-control" id="descripcion" name="descripcion">
                    </div>
                    
                    <!-- nuevo -->
                    <div class="form-group" style="text-align: center">
                        <label class="control-label" for="radio">Estado del articulo</label>
                        <label class="radio" for="radio-0">
                            <input name="nuevo" id="radio-0" value="1" checked="checked" type="radio">
                            Nuevo
                        </label>
                        <label class="radio" for="radio-1">
                            <input name="nuevo" id="radio-1" value="0" type="radio">
                            Usado
                        </label>
                    </div>
                    
                    <!-- imagen -->
                    <div class="form-group">
                        <label class="control-label" for="imagen">imagen:</label>
                        <input type="text" class="form-control" id="imagen" name="imagen">
                    </div>
                    
                    <!-- cantidad -->
                    <div class="form-group">
                        <label class="control-label" for="disponible">Cantidad:</label>
                        <input type="text" class="form-control" id="disponible" name="disponible">
                    </div>
                    
                    <!-- peso_kg -->
                    <div class="form-group">
                        <label class="control-label" for="peso_kg">Peso:</label>
                        <div class="input-group">
                            <input type="text" class="form-control" id="peso_kg" name="peso_kg">
                            <span class="input-group-addon">Kg</span>
                        </div>
                    </div>

                    <!-- dimension_cm -->
                    <div class="form-group">
                        <label class="control-label" for="dimensiones">Dimensiones:</label>
                        <input type="text" class="form-control" id="dimensiones" name="dimensiones">
                    </div>

                    <button type="submit" class="btn btn-default">Agregar</button>
                </form>
            <?php
            }
            else //aqui construllo el formulario para la cantidad de articulos que se agrega a inventario
            {
            ?>
            <?php
                echo_pre($this->model_alm_articulos->exist_articulo($articulo));
            }
        }
        
    }
    public function articulo_nuevo()
    {
        die_pre($this->input->post(), __LINE__, __FILE__);
        if ($this->input->post('id')):
            $id_orden_trabajo = $this->input->post('id');
            $articulos = $this->unassigned($id_orden_trabajo);
            ?>

            <?php if(!empty($ayudantes)) :?>
            
            <?php else: ?>
            <div class="alert alert-warning" style="text-align: center">No hay ayudantes disponibles para asignar</div>
            <?php endif ?>
            <?php 
        endif;
    }
    public function articulo_existente()
    {
        if ($this->input->post('id')):
            $id_orden_trabajo = $this->input->post('id');
            $articulos = $this->unassigned($id_orden_trabajo);
            ?>

            <?php if(!empty($ayudantes)) :?>
            
            <?php else: ?>
            <div class="alert alert-warning" style="text-align: center">No hay ayudantes disponibles para asignar</div>
            <?php endif ?>
            <?php 
        endif;
    }

    ////////////////////////Control de permisologia para usar las funciones
    public function hasPermissionClassA()//Solo si es usuario autoridad y/o Asistente de autoridad
    {
        return ($this->session->userdata('user')['sys_rol']=='autoridad'||$this->session->userdata('user')['sys_rol']=='asist_autoridad');
    }
    public function hasPermissionClassB()//Solo si es usuario "Director de Departamento" y/o "jefe de Almacen"
    {
        return ($this->session->userdata('user')['sys_rol']=='director_dep'||$this->session->userdata('user')['sys_rol']=='jefe_alm');
    }
    public function hasPermissionClassC()//Solo si es usuario "Jefe de Almacen"
    {
        return ($this->session->userdata('user')['sys_rol']=='jefe_alm');
    }
    public function hasPermissionClassD()//Solo si es usuario "Director de Departamento"
    {
        return ($this->session->userdata('user')['sys_rol']=='director_dep');
    }
    public function isOwner($user='')
    {
        if(!empty($user)||$this->session->userdata('user'))
        {
            return $this->session->userdata('user')['ID'] == $user['ID'];
        }
        else
        {
            return FALSE;
        }
    }
    ////////////////////////Fin del Control de permisologia para usar las funciones
}