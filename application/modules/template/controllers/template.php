<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Template extends MX_Controller
{
	function __construct() //constructor predeterminado del controlador
    {
        parent::__construct();
        $this->load->model("alm_solicitudes/model_alm_solicitudes");
        $this->load->model("mnt_solicitudes/model_mnt_solicitudes");
        $this->load->module('dec_permiso/dec_permiso');
        $this->load->module('alm_solicitudes/alm_solicitudes');
    }
    //la egne &ntilde;
    //acento &acute;
    public function index()//sin usar todavia
    {

        $header['title'] = 'Comet Programing';
        $this->load->view('template/testjson',$header);
    }

    public function FSM_install()//faculty system manager instalador de bd para sisai    
    {
        if($this->session->userdata('user'))
        {
            
        }
    }

    public function under_construction()
    {
        $this->load->view('template/mantenimiento2');
    }

    public function check_alerts()//una funcion para las alertas del sistema
    {
        //para usarlo se declara una variable en el arreglo "$array", que se llevara algo del modelo, o nada
        //luego se consulta como lleno o vacio en el script "mainFunctions.js" linea 924
        if($this->dec_permiso->has_permission('alm', 3))
        {
            $array['depSol'] = $this->model_alm_solicitudes->get_depAprovedSolicitud();//solicitudes aprobadas de almacen (retorna vacio si no las hay)
        }
        if($this->dec_permiso->has_permission('alm', 14))
        {
            $array['despSol'] = $this->model_alm_solicitudes->get_depServedSolicitud();//solicitudes aprobadas de almacen (retorna vacio si no las hay)
        }
        // $array['sol'] = $this->model_alm_solicitudes->get_ownAprovedSolicitud();
        if($this->dec_permiso->has_permission('mnt', 7))
        {
            $array['calificar'] = $this->model_mnt_solicitudes->get_califica();// me retorna las calificaciones vacias
        }
        // $array['flag'] = "true";
        echo json_encode($array);
        //esta funcion consulta a travez del modelo aquellas solicitudes o funciones necesarias, para "fastidiar" al usuario para que este pendiente
    }
    public function not_found()
    {
        $this->load->view('template/error_404.php');
    }
    public function get_serverTime()
    {
        echo json_encode(time()*1000);
    }
    public function error_acceso()
    {
        $this->load->view('template/erroracc.php');
    }
    public function update_cart_session()
    {
        $uri = $this->input->post();
        // echo ($this->input->post('uri'));
        $permit = $this->dec_permiso->has_permission('alm', 9);
        if($this->session->userdata('id_carrito'))
        {
            $this->alm_solicitudes->updateUserCart();
        }
        else
        {
            if($permit)
            {
                $array['permit'] = 1;
            }
            $array['cart']='empty';
            echo json_encode($array);
        }
    }
    public function DataTable()
    {
        if($this->session->userdata('user'))
        {
            /* Array of database columns which should be read and sent back to DataTables. Use a space where
             * you want to insert a non-database field (for example a counter or static image)
             */
            $tables = preg_split("/[',']+/", $this->input->get_post('tablas'));
            $joins = preg_split("/[',']+/", $this->input->get_post('joins'));
            // die_pre($tables);
            $columns = $this->input->get_post('columnas');
            $aColumns = preg_split("/[',']+/", $columns);
            // DB table to use
            $sTable = $tables[0];
            //
            // echo_pre($sTable);
            // die_pre($aColumns);
            if($this->input->get_post('ambiguos'))
            {
                $amb = preg_split("/[',']+/", $this->input->get_post('ambiguos'));
                // die_pre($amb);
            }
        
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
                    if($i!=0 && $i!=3)//para no buscar en la columna exist y disp (arroja error si no la filtro)
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
            $ambiguous = '';
            $select = $aColumns;
            for ($i=1; $i < count($tables); $i++)
            {
                if($amb[$i-1])
                {
                    $ambiguous .= $tables[$i-1].".".$amb[$i-1]." AS ".$amb[$i-1].", ";
                    $aux = array_search($amb[$i-1], $aColumns);
                    unset($select[$aux]);
                }
                // echo "value: ".$tables[$i];
                $this->db->join($tables[$i], $tables[$i].'.'.$joins[$i].'='.$sTable.'.'.$joins[$i-1]);
            }
            // die_pre('SQL_CALC_FOUND_ROWS '.$ambiguous.str_replace(' , ', ' ', implode(', ', $aColumns)));
            $this->db->select('SQL_CALC_FOUND_ROWS '.$ambiguous.str_replace(' , ', ' ', implode(', ', $select)), false);
            // die();
            // if($active==1)
            // {
            //     $this->db->where('ACTIVE', 1);
            // }
            // $this->db->select('SQL_CALC_FOUND_ROWS *, usados + nuevos + reserv AS exist, usados + nuevos AS disp', false);
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
            // die_pre($rResult->result_array());
            // $i=1+$iDisplayStart;
            $i=$iDisplayStart;
            foreach($rResult->result_array() as $aRow)//construccion a pie de los campos a mostrar en la lista, cada $row[] es una fila de la lista, y lo que se le asigna en el orden es cada columna
            {
                $row = array();
                
                foreach($aColumns as $col)
                {
                    $row[] = $aRow[$col];
                }
                // $row[]= '<div align="center">'.$i.'</div>';//primera columna
                // $i++;
                // $row[]= '<div align="center">'.$aRow['cod_articulo'].'</div>';//segunda columna
                // $row[]= $aRow['descripcion'];//tercera columna
                // // if(!empty($this->session->userdata('articulos')) && in_array($aRow['ID'], $this->session->userdata('articulos')))
                // // {
                //   // $row[]='<span id="clickable"><i id="row_'.$aRow['ID'].'" class="fa fa-minus" style="color:#D9534F"></i></span>';
                // // }
                // // else
                // // {
                //     $row[]='<div align="center"><span id="clickable"><i id="row_'.$aRow['ID'].'" class="fa fa-plus color"></i></span></div>';
                // // }
                // $row['DT_RowId']='row_'.$aRow['ID'];//necesario para agregar un ID a cada fila, y para ser usado por una funcion del DataTable
                // $row[]='<a href="#art'.$aRow['ID'].'" data-toggle="modal"><i class="glyphicon glyphicon-zoom-in color"></i></a>';//cuarta columna
                $output['aaData'][] = $row;
            }
            // $row = array();
            // $row[] = '<script type="text/javascript"> $(document).ready(function () {console.log($("i").length);});</script>';
            // $output['aaData'][] = $row;
            // $output['aaData'][] = '<script type="text/javascript"> $(document).ready(function () {console.log($("i").length);});</script>';
            echo json_encode($output);
        }
        else
        {
            $header['title'] = 'Error de Acceso';
            $this->load->view('template/erroracc',$header);
        }
    }
}