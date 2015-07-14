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

	public function getTable()
    {
        /* Array of database columns which should be read and sent back to DataTables. Use a space where
         * you want to insert a non-database field (for example a counter or static image)
         */
        $aColumns = array('ID', 'cod_articulo', 'descripcion');
        
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
                $bSearchable = $this->input->get_post('bSearchable_'.$i, true);
                
                // Individual column filtering
                if(isset($bSearchable) && $bSearchable == 'true')
                {
                    $this->db->or_like($aColumns[$i], $this->db->escape_like_str($sSearch));
                }
            }
        }
        
        // Select Data
        $this->db->select('SQL_CALC_FOUND_ROWS '.str_replace(' , ', ' ', implode(', ', $aColumns)), false);
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
        
        foreach($rResult->result_array() as $aRow)
        {
            $row = array();
            
            // foreach($aColumns as $col)
            // {
            //     $row[] = $aRow[$col];
            // }
            $row[]= $aRow['ID'];
            $row[]= '<a href="">'.$aRow['cod_articulo'].'</a>';
            $row[]= $aRow['descripcion'];
            //$aux='<i style"color: #398439" class="fa fa-check">'.$aRow['ID'].'</i>';//aqui va la columna no relacionada con la BD
            $aux = '<div id="ayudante<?php echo $sol["id_orden"] ?>" class="modal modal-message modal-info fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                     <div class="modal-dialog">
                                         <div class="modal-content">
                                             <div class="modal-header">
                                                 <h4 class="modal-title">Detalles</h4>
                                             </div>
                                             <div class="modal-body">
                                                 <div>
                                                     <h4><label>Solicitud Número: 
                                                             <?php echo $sol["id_orden"] ?>
                                                         </label></h4>
                                                 </div>
                                                 <div id="disponibles<?php echo $sol["id_orden"] ?>">
                                                     <!-- AQUI CONSTRULLE UNA LISTA DE AYUDANTES DISPONIBLES NO ASIGNADOS A LA ORDEN (revisar script mainFunctions.js linea 208 en adelante)-->
                                                 </div>
                                                 <div id="asignados<?php echo $sol["id_orden"] ?>">
                                                     <!-- AQUI CONSTRULLE UNA LISTA DE AYUDANTES ASIGNADOS A LA ORDEN (revisar script mainFunctions.js linea 208 en adelante)-->
                                                 </div>

                                                 <div class="modal-footer">
                                                     <input form="ay<?php echo $sol["id_orden"] ?>" type="hidden" name="uri" value="<?php echo $this->uri->uri_string() ?>"/>
                                                     <input form="ay<?php echo $sol["id_orden"] ?>" type="hidden" name="id_orden_trabajo" value="<?php echo $sol["id_orden"] ?>"/>
                                                     <button form="ay<?php echo $sol["id_orden"] ?>" type="submit" class="btn btn-primary">Guardar cambios</button>

                                                     <button type="button" class="btn btn-default" data-dismiss="modal" aria-hidden="true">Cancelar</button>
                                                 </div>
                                             </div>
                                         </div>
                                     </div> 
                                </div>';
            $row[]=$aux;
            $output['aaData'][] = $row;
        }
    
        echo json_encode($output);
        // explore_code($output);
    }
}