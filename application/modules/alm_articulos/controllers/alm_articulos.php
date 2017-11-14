<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Alm_articulos extends MX_Controller
{
    function __construct() //constructor predeterminado del controlador
    {
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->library('excel');
        $this->load->model('model_alm_articulos');
        $this->load->module('dec_permiso/dec_permiso');
    }

    public function index()
    {
        // echo_pre('permiso para acceder a inventario', __LINE__, __FILE__);//modulo=alm, func=9
        if($this->session->userdata('user'))
        {
            if($this->dec_permiso->has_permission('alm', 1)||$this->dec_permiso->has_permission('alm', 4)||$this->dec_permiso->has_permission('alm', 5)||$this->dec_permiso->has_permission('alm', 6)||$this->dec_permiso->has_permission('alm', 7)||$this->dec_permiso->has_permission('alm', 8))
            {
                if($_POST)
                {
                    // echo_pre($_POST, __LINE__, __FILE__);
                }
    ////////seccion de banderas para filtrado de permisos sobre inventario
                $view = $this->dec_permiso->parse_permission('', 'alm');
    ////////fin de seccion de banderas para filtrado de permisos sobre inventario
                // $view['inventario'] = $this->model_alm_articulos->get_allArticulos();
    //fecha temporal del ultimo reporte generado
                $this->load->helper('date');
                $datestring = "%d-%m-%Y";
                $time = $this->model_alm_articulos->ult_cierre();
                 // = $aux['time'];
                // die_pre($aux['pastYear'], __LINE__, __FILE__);
                $view['cierres'] = $this->model_alm_articulos->todos_cierres();
                $view['fecha_ultReporte'] = mdate($datestring, $time);
    //fecha temporal del ultimo reporte generado
                $header = $this->dec_permiso->load_permissionsView();
                $header['title'] = 'Articulos';
                // echo_pre($view['alm'], __LINE__, __FILE__);
    // declaracion de biblioteca de estilos para la vista
                $header['link'] = '<!-- Bootstrap CSS -->
                <link href="'.base_url().'assets/css/bootstrap.min.css" rel="stylesheet">
                <link href="'.base_url().'assets/css/dataTables.bootstrap.css" rel="stylesheet">
                <link href="'.base_url().'assets/css/responsive.bootstrap.css" rel="stylesheet">
                <link href="'.base_url().'assets/css/buttons.bootstrap.min.css" rel="stylesheet">
                <link href= "'.base_url().'assets/css/bootstrap-vertical-tabs.css" rel="stylesheet"/>
                <!-- Bootstrap selectpicker -->
                <!-- Select2 CSS -->
                <link href= "'.base_url().'assets/css/select2.css" rel="stylesheet"/>
                <link href="'.base_url().'assets/css/bootstrap-select.css" rel="stylesheet">
                <link href= "'.base_url().'assets/css/select2-bootstrap.css" rel="stylesheet"/>
                <!-- Sweet-alert 2 css -->
                <link href="'.base_url().'assets/css/sweet-alert.css" rel="stylesheet">
                <!-- Modal by jcparra css -->
                <link href="'.base_url().'assets/css/modal.css" rel="stylesheet">
                <!-- Animate css -->
                <link href="'.base_url().'assets/css/animate.min.css" rel="stylesheet">
                <!-- jQuery UI -->
                <link href="'.base_url().'assets/css/jquery-ui.css" rel="stylesheet">
                <!-- prettyPhoto -->
                <link href="'.base_url().'assets/css/prettyPhoto.css" rel="stylesheet">
                <!-- Font awesome CSS -->
                <link href="'.base_url().'assets/css/font-awesome.min.css" rel="stylesheet">
                <!--DateRangePicker -->
                <link href="'.base_url().'assets/css/daterangepicker-bs3.css" rel="stylesheet">
                <!-- FileInput -->
                <link href= "'.base_url().'assets/css/fileinput.min.css" media="all" rel="stylesheet" type="text/css">
                <!-- Custom CSS -->
                <link href="'.base_url().'assets/css/style.css" rel="stylesheet">
                <link rel="stylesheet" type="text/css" href="'.base_url().'assets/css/sweetalert2.min.css">
                ';
    // Fin de declaracion de biblioteca de estilos para la vista
    // declaracion de biblioteca de scripts de javascripts
                $footer['script'] = '<script src="'.base_url().'assets/js/sweetalert2.min.js"></script>
                <!-- jQuery -->
                <script src="'.base_url().'assets/js/jquery-1.11.3.js"></script>      
                <!-- Bootstrap JS -->
                <script src="'.base_url().'assets/js/bootstrap.min.js"></script>
                <!-- jQuery UI -->
                <script src="'.base_url().'assets/js/jquery-ui.js"></script>      
                <!--File input-->
                <script src="'.base_url().'assets/js/fileinput.min.js" type="text/javascript"></script>
                <script src="'.base_url().'assets/js/fileinput_locale_es.js" type="text/javascript"></script>
                <script src="'.base_url().'assets/js/sweetalert2.min.js"></script>
                <!-- DataTables -->
                <script src="'.base_url().'assets/js/jquery.dataTables.min.js"></script>
                <script src="'.base_url().'assets/js/dataTables.responsive.js"></script>
                <script src="'.base_url().'assets/js/dataTables.buttons.min.js"></script>
                <script src="'.base_url().'assets/js/dataTables.select.min.js"></script>
                <script src="'.base_url().'assets/js/dataTables_altEditor.js"></script>
                <!-- Bootstrap DataTables -->
                <script src="'.base_url().'assets/js/dataTables.bootstrap.js"></script>
                <script src="'.base_url().'assets/js/responsive.bootstrap.js"></script>
                <script src="'.base_url().'assets/js/buttons.bootstrap.min.js"></script>
                <script src="'.base_url().'assets/js/buttons.html5.min.js"></script>
                <!-- prettyPhoto -->
                <script src="'.base_url().'assets/js/jquery.prettyPhoto.js"></script>
                <!-- Select2 JS -->
                <script src="'.base_url().'assets/js/select2.js"></script>
                <!-- CLEditor -->
                <script src="'.base_url().'assets/js/jquery.cleditor.min.js"></script> 
                <!-- Bootstrap select js -->
                <script src="'.base_url().'assets/js/bootstrap-select.min.js"></script>
                <!-- Date and Time picker -->
                <script src="'.base_url().'assets/js/bootstrap-datetimepicker.min.js"></script>
                <script src="'.base_url().'assets/js/moment.js"></script>
                <script src="'.base_url().'assets/js/daterangepicker.js"></script>      
                <!-- Respond JS for IE8 -->
                <script src="'.base_url().'assets/js/respond.min.js"></script>
                <!-- HTML5 Support for IE -->
                <script src="'.base_url().'assets/js/html5shiv.js"></script>
                <!-- js de principal -->
                <script src="'.base_url().'assets/js/alm/articulos/principal.js"></script>
                <script src="'.base_url().'assets/js/allviews.js"></script>
                      ';

    // Validación para el reporte de articulos fisicos, para mostrar la interfaz del cierre
                $view['RepInvFisico'] = $this->deploy_InvFisico();
                // die_pre($view['RepInvFisico']);
    // Fin de validación para el reporte de articulos fisicos, para mostrar la interfaz del cierre
                // echo_pre($this->session->all_userdata());
    // Fin de declaracion de biblioteca de scripts de javascripts
                $this->load->view('template/header', $header);
    			// $this->load->view('template/header');
                $this->load->view('principal', $view);
                // $this->load->view('reportes', $view);
                // $this->load->view('reportes3', $view);
                $this->load->view('template/footer', $footer);
                // $this->load->view('template/footer');
            }
            else
            {
                $header['title'] = 'Error de Acceso';
                $this->load->view('template/erroracc',$header);
            }
        }
        else
        {
            $header['title'] = 'Error de Acceso';
            $this->load->view('template/erroracc',$header);
        }
    }

    public function incongruencias_inv_reportado()//$this->dec_permiso->has_permission('alm', 8)
    {
        if($this->session->userdata('user') && ($this->input->post('link') && $this->input->post('link')=='inventario'))
        {
            // die_pre($this->input->get('link'));
            // $this->load->view('cierre/revision', $view);
            echo $this->load->view('modal_incongruencias', '', TRUE);

        }
        else
        {
            $header['title'] = 'Error de Acceso';
            $this->load->view('template/erroracc',$header);
        }
    }
    public function tabla_incongruencias()//datatable de incongurencias
    {
        if($this->session->userdata('user') && $this->dec_permiso->has_permission('alm', 8))
        {
            if($this->input->post())
            {
                if($this->input->post('action')=='editRow')
                {
                    $row = $this->input->post('raw')['data']['0'];
                    // die_pre($row, __LINE__, __FILE__);
                    $articuloID = $row['ID'];
                    $justification = $row['justificacion'];
                    // echo_pre($justification, __LINE__, __FILE__);
                    if($justification)
                    {
                        if($this->model_alm_articulos->update_justificarItem($articuloID, $justification))
                        {
                            echo json_encode("true");
                        }
                        else
                        {
                            echo json_encode("unchanged");
                        }
                    }
                    else
                    {
                        echo json_encode("false");
                    }
                }
            }
            else
            {

                $table = $this->model_alm_articulos->get_reportedTable();
                echo json_encode($table);
            }
        }
        else
        {
            $header['title'] = 'Error de Acceso';
            $this->load->view('template/erroracc',$header);
        }
    }

    public function deploy_InvFisico()
    {
        if($this->session->userdata('user'))
        {
            $aux = $this->model_alm_articulos->get_UnfinishedReporte();
            if($aux)
            {
                return($aux);
            }
            else
            {
                return(false);
            }
        }
        else
        {
            $header['title'] = 'Error de Acceso';
            $this->load->view('template/erroracc',$header);
        }
    }
    public function enable_closure()//para habilitar cierre de inventario
    {
        if($this->session->userdata('user') && $this->hasPermissionClassA())
        {

        }
        else
        {
            $header['title'] = 'Error de Acceso';
            $this->load->view('template/erroracc',$header);
        }
    }

    public function inventory_closure()
    {
        if($this->session->userdata('user') && $this->dec_permiso->has_permission('alm', 8))
        {
            // echo json_encode("value");
            $this->backup_Inventory();
            // $this->adjustRegister_Inventory();//completo, falta validar cuando ya el cierre fué realizado
            // $this->pdf_ActaDeCierre();//aqui quedé (lo hace desde el lado del cliente)
            // $this->validar_reporte();
        }
        else
        {
            $header['title'] = 'Error de Acceso';
            $this->load->view('template/erroracc',$header);
        }
    }

    public function backup_Inventory()
    {
        if($this->session->userdata('user') && $this->dec_permiso->has_permission('alm', 8))
        {
            echo json_encode($this->model_alm_articulos->makeSQLBackup());
        }
        else
        {
            $header['title'] = 'Error de Acceso';
            $this->load->view('template/erroracc',$header);
        }
    }
    public function adjustRegister_Inventory()
    {
        if($this->session->userdata('user') && $this->dec_permiso->has_permission('alm', 8))
        {
            echo json_encode($this->model_alm_articulos->insert_stockAdjustment());
        }
        else
        {
            $header['title'] = 'Error de Acceso';
            $this->load->view('template/erroracc',$header);
        }
    }
    public function print_closureReport()
    {
        if($this->session->userdata('user') && $this->dec_permiso->has_permission('alm', 8))
        {
            echo json_encode();
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
            // echo_pre('permiso para insertar articulos a inventario', __LINE__, __FILE__);//6
            if($this->dec_permiso->has_permission('alm', 6))
            {
                if($this->input->post())
                {
                    die_pre($this->input->post(null, true));
                }
                // if($_POST)//recordar, debes insertar en las tablas alm_articulos, alm_genera_hist_a, alm_historial_a
                // {
                //     // die_pre($_POST, __LINE__, __FILE__);
                //     $post=$_POST;
                //     //carga para alm_articulos
                //     $aux['cod_articulo'] = $post['cod_articulo'];
                //     $new = !$this->model_alm_articulos->exist_articulo($aux);
                //     if($new)
                //     {
                //         $articulo= array(
                //             'cod_articulo'=>$post['cod_articulo'],
                //             'unidad'=>$post['unidad'],
                //             'descripcion'=>strtoupper($post['descripcion']),
                //             'ACTIVE'=>1,
                //             'peso_kg'=>$post['peso_kg'],
                //             'dimension_cm'=>$post['alto']."x".$post['ancho']."x".$post['largo'],
                //             );
                //         if(!empty($post['imagen']))//aqui toca subir imagen cuando este listo
                //         {
                //             $articulo['imagen']= $post['imagen'];
                //         }

                //         if($post['nuevo'])
                //         {
                //             $articulo['nuevos'] = $post['cantidad'];
                //         }
                //         else
                //         {
                //             $articulo['usados'] = $post['cantidad'];
                //         }
                //     }
                //     else
                //     {
                //         $articulo = array(
                //             'cod_articulo' => $post['cod_articulo'],
                //             'ACTIVE'=>1
                //             );
                //         $exist=$this->model_alm_articulos->get_existencia($post['cod_articulo']);

                //         if($post['nuevo'])
                //         {
                //             $articulo['nuevos'] = $exist['nuevos']+$post['cantidad'];
                //         }
                //         else
                //         {
                //             $articulo['usados'] = $exist['usados']+$post['cantidad'];
                //         }
                //     }
                //     // die_pre($articulo, __LINE__, __FILE__);
                //     $historial= array(
                //         'id_historial_a'=>$this->session->userdata('user')['id_dependencia'].'00'.$this->session->userdata('user')['ID'].'0'.$this->model_alm_articulos->get_lastHistoryID(),//revisar, considerar eliminar la dependencia del codigo
                //         'entrada'=>$post['cantidad'],
                //         'nuevo'=>$post['nuevo'],
                //         'observacion'=>strtoupper($post['observacion']),
                //         'por_usuario'=>$this->session->userdata('user')['id_usuario']
                //         );
                //     if($new)
                //     {
                //         $success = $this->model_alm_articulos->add_newArticulo($articulo, $historial);
                //     }
                //     else
                //     {
                //         $success = $this->model_alm_articulos->update_articulo($articulo, $historial);
                //     }
                //     if($success)
                //     {
                //         echo '<div class="alert alert-success">
                //                 El articulo fue agregado exitosamente.
                //             </div>';
                //     }
                //     else
                //     {
                //         echo '<div class="alert alert-danger">
                //                 Ocurri&oacute; un problema al insertar el articulo.
                //             </div>';
                //     }
                // }
            }
            else
            {
                echo '<div class="alert alert-danger">
                        No tiene los permisos adecuados para guardar articulos.
                    </div>';
            }
        }
        else
        {
            $header['title'] = 'Error de Acceso';
            $this->load->view('template/erroracc',$header);
        }
    }
    public function actualizar_articulo()
    {

    }


    public function categoria_articulo()///todavia no
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
        if($this->session->userdata('user'))
        {
            return $this->model_alm_articulos->count_articulos();
        }
        else
        {
            $header['title'] = 'Error de Acceso';
            $this->load->view('template/erroracc',$header);
        }
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
        if($this->session->userdata('user'))
        {
            if($this->session->userdata('query'))
            {
                //
                if($this->session->userdata('query')=='' ||$this->session->userdata('query')==' ')
                {
                    $this->session->unset_userdata('query');
                    
                    redirect(base_url().'solicitud/inventario');
                }
                
                $header['title'] = 'Buscar articulos';
                return($this->model_alm_articulos->find_articulo($this->session->userdata('query'), $field, $order, $per_page, $offset));
                
            }
            else
            {
                redirect('/solicitud/inventario');
            }
        }
        else
        {
            $header['title'] = 'Error de Acceso';
            $this->load->view('template/erroracc',$header);
        }
    }

    public function ajax_likeArticulos()
    {
        if($this->session->userdata('user'))
        {
            // error_log("Hello", 0);
            $articulo = $this->input->post('articulos');
            header('Content-type: application/json');
            $query = $this->model_alm_articulos->ajax_likeArticulos($articulo);
            $query = objectSQL_to_array($query);
            echo json_encode($query);
        }
        else
        {
            $header['title'] = 'Error de Acceso';
            $this->load->view('template/erroracc',$header);
        }
    }

    public function getSystemWideTable($active='')
    {
        if($this->session->userdata('user'))
        {
            /* Array of database columns which should be read and sent back to DataTables. Use a space where
             * you want to insert a non-database field (for example a counter or static image)
             */
            $aColumns = array('ID', 'cod_articulo', 'descripcion', 'exist', 'reserv', 'nuevos', 'usados', 'stock_min');
            
            // DB table to use
            $sTable = 'alm_articulo';
            //
        
            // die_pre($this->input->get_post(NULL, true));
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
                    if($i!=0 && $i!=3 && $i!=5)//para no buscar en la columna exist y disp (arroja error si no la filtro)
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
            // if(($this->hasPermissionClassA() || $this->hasPermissionClassC) || $active==1)
            // {
            //     $this->db->where('ACTIVE', 1);
            // }
            $this->db->select('SQL_CALC_FOUND_ROWS *, usados + nuevos + reserv AS exist, usados + nuevos AS disp', false);
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
                $articulo['cod_articulo']=$aRow['cod_articulo'];
                $hist = $this->model_alm_articulos->get_ArtHistory($articulo);
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
                // $row[]= $aRow['disp'];//sexta columna
                // $row[]= 'nuevos: '.$aRow['nuevos'].' usados: '.$aRow['usados']; //sexta columna
                $row[]= $aRow['nuevos'];//sexta columna
                $row[]= $aRow['usados'];//septima columna
                $row[]= $aRow['stock_min'];//octava columna
                $aux = '<div id="art'.$aRow['cod_articulo'].'" class="modal modal-message modal-info fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h4 class="modal-title">Detalles</h4>
                                    </div>
                                    <div class="modal-body">
                                        <div>
                                            <h4><label>c&oacute;digo del articulo: 
                                                     '.$aRow['cod_articulo'].'
                                                </label></h4>
                                                <h4><label>Historial del Articulo</label></h4>
                                                <table id="hist_art'.$aRow['cod_articulo'].'" class="table" style="width:100%">
                                                    ';
                                                    $aux.='<thead>
                                                                    <tr>
                                                                        <th><strong>Fecha de movimiento</strong></th>
                                                                        <th><strong>Movimiento</strong></th>
                                                                        <th><strong>Cantidad</strong></th>
                                                                        <th><strong>Estado de articulo</strong></th>
                                                                        <th><strong>Observacion</strong></th>';
                                                    $aux.='</thead>
                                                    <tbody>';
                                                        // foreach ($hist as $key => $line)
                                                        // {
                                                        //     $aux.='<tr>
                                                        //             <td>'.$line['TIME'].'</td>';
                                                        //     if($line['entrada']!=0)
                                                        //     {
                                                        //         $aux.='<td>Entrada a inventario</td>
                                                        //         <td>'.$line['entrada'].'</td>';
                                                        //     }
                                                        //     else
                                                        //     {
                                                        //         $aux.='<td>Salida de inventario</td>
                                                        //         <td>'.$line['salida'].'</td>';
                                                        //     }
                                                        //     if($line['nuevo'])
                                                        //     {
                                                        //         $aux.='<td>Nuevo</td>';
                                                        //     }
                                                        //     else
                                                        //     {
                                                        //         $aux.='<td>Usado</td>';
                                                        //     }
                                                        //     $aux.='<td>'.$line['observacion'].'</td>';
                                                        // }
                                                        $aux=$aux.'</tbody>
                                                </table>
                                        </div>

                                        <div class="modal-footer">
                                             
                                        </div>
                                    </div>
                                </div>
                            </div> 
                        </div>';
                $row[]='<a href="#art'.$aRow['cod_articulo'].'" data-toggle="modal"><i class="glyphicon glyphicon-zoom-in color"></i></a>'.$aux;//cuarta columna
                $row['DT_RowId']='row_'.$aRow['cod_articulo'];//necesario para agregar un ID a cada fila, y para ser usado por una funcion del DataTable
                $output['aaData'][] = $row;
            }
        
            echo json_encode($output);
        }
        else
        {
            $header['title'] = 'Error de Acceso';
            $this->load->view('template/erroracc',$header);
        }
    }

    public function getArticulosHist($cod_articulo)//hace compania al modal en la linea 320 de este archivo
    {
        if($this->session->userdata('user'))
        {
            //columnas en tabla: fecha de movimiento, movimiento, cantidad, estado del articulo y observacion
            $aColumns = array('alm_genera_hist_a.TIME', 'nuevo', 'observacion', '', '');

            $sTable = 'alm_historial_a';

            $iDisplayStart = $this->input->get_post('iDisplayStart', true);
            $iDisplayLength = $this->input->get_post('iDisplayLength', true);
            $iSortCol_0 = $this->input->get_post('iSortCol_0', true);
            $iSortingCols = $this->input->get_post('iSortingCols', true);
            $sSearch = $this->input->get_post('sSearch', true);
            $sEcho = $this->input->get_post('sEcho', true);
            //paginacion
            if(isset($iDisplayStart) && $iDisplayLength != '-1')
            {
                $this->db->limit($this->db->escape_str($iDisplayLength), $this->db->escape_str($iDisplayStart));
            }
            //ordenamiento
            if(isset($iSortCol_0))
            {
                if($iSortCol_0!=1 && $iSortCol_0!=2)
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
                else
                {
                    switch ($iSortCol_0)
                    {
                        case 1:
                            $this->db->order_by('entrada' , $this->db->escape_str($this->input->get_post('sSortDir_0', true)));
                        break;
                        case 2:
                            $this->db->order_by('entrada' , $this->db->escape_str($this->input->get_post('sSortDir_0', true)));
                            $this->db->order_by('salida' , $this->db->escape_str($this->input->get_post('sSortDir_0', true)));
                        break;
                    }
                    // $mensaje = $this->input->get('sSortDir_0');
                }
            }
            //filtrado para busqueda
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

            $this->db->select('SQL_CALC_FOUND_ROWS *, alm_historial_a.ID AS id, alm_genera_hist_a.TIME AS tiempo', false);
            // $this->db->where(array('id_articulo'=>$cod_articulo));
            // $this->db->join('alm_genera_hist_a', 'alm_genera_hist_a.id_historial_a = alm_historial_a.id_historial_a AND alm_genera_hist_a.id_articulo ='.$cod_articulo);
            $this->db->join('alm_genera_hist_a', 'alm_genera_hist_a.id_historial_a = alm_historial_a.id_historial_a');
            $this->db->where('alm_genera_hist_a.id_articulo', $cod_articulo);

            $rResult = $this->db->get($sTable);

            $this->db->select('FOUND_ROWS() AS found_rows');

            $iFilteredTotal = $this->db->get()->row()->found_rows;

            $iTotal = $this->db->count_all($sTable);
                
                    // Output
                    $output = array(
                        'sEcho' => intval($sEcho),
                        'iTotalRecords' => $iTotal,
                        'iTotalDisplayRecords' => $iFilteredTotal,
                        'aaData' => array()
                    );
            foreach($rResult->result_array() as $aRow)//construccion a pie de los campos a mostrar en la lista, cada $row[] es una fila de la lista, y lo que se le asigna en el orden es cada columna
            {
                $row = array();
                $row[]=$aRow['tiempo'];
                if($aRow['entrada']!=0)
                {
                    $row[] = 'Entrada a inventario';
                    $row[] = $aRow['entrada'];
                }
                else
                {
                    if($aRow['salida']!=0)
                    {
                        $row[] ='Salida de inventario';
                        $row[] = $aRow['salida'];
                    }
                    else
                    {
                        $row[] ='Articulo Modificado';
                        $row[] = 'Data en observación';
                    }
                }
                if($aRow['nuevo'])
                {
                    $row[] = 'Nuevo';
                }
                else
                {
                    $row[] = 'Usado';
                }
                // $aux ='';
                //  $aux.= '<div id="DT'.$aRow['id'].'" class="modal modal-message modal-info fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                //             <div class="modal-dialog">
                //                 <div class="modal-content">
                //                     <div class="modal-header">
                //                         <h4 class="modal-title">Detalles</h4>
                //                     </div>
                //                     <div class="modal-body">
                //                         <div>
                //                             <h4><label>Atributos de DataTable
                //                                 </label></h4>
                //                                 <table id="item'.$aRow['id'].'" class="table">
                //                                     <thead>';
                //                                         foreach ($this->input->get() as $key => $val)
                //                                         {
                //                                             $aux.='<tr>
                //                                                         <th><strong>'.$key.'</strong></th>
                //                                                         <th><strong>:</strong></th>
                //                                                         <th><strong>'.$val.'</strong></th>
                //                                                     </tr>';
                //                                         }
                //                                         if(isset($mensaje))
                //                                         {
                //                                             $aux.='<tr>
                //                                                         <th><strong>mensaje</strong></th>
                //                                                         <th><strong>:</strong></th>
                //                                                         <th><strong>'.$mensaje.'</strong></th>
                //                                                     </tr>';
                //                                         }
                //                                         $aux.='</thead>
                //                                                 <tbody>';
                //                                         $aux=$aux.'</tbody>
                //                                 </table>
                //                         </div>

                //                         <div class="modal-footer">
                                             
                //                         </div>
                //                     </div>
                //                 </div>
                //             </div> 
                //         </div>';
                //         $aux.='<a href="#DT'.$aRow['id'].'" data-toggle="modal"><i class="glyphicon glyphicon-console color"></i></a>';
                // $row[] = $aRow['observacion'].' '.$aux;
                $row[] = $aRow['observacion'];
                
                $row['DT_RowId']='row_'.$aRow['ID'];//necesario para agregar un ID a cada fila, y para ser usado por una funcion del DataTable
                // $row[]='<a href="#art'.$aRow['ID'].'" data-toggle="modal"><i class="glyphicon glyphicon-zoom-in color"></i></a>';//cuarta columna
                $output['aaData'][] = $row;
            }
            echo json_encode($output);
        }
        else
        {
            $header['title'] = 'Error de Acceso';
            $this->load->view('template/erroracc',$header);
        }
    }

    public function getInventoryTable($active='')
    {
        if($this->session->userdata('user'))
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
            // $this->db->select('SQL_CALC_FOUND_ROWS '.str_replace(' , ', ' ', implode(', ', $aColumns)), false);
            if($active==1)
            {
                $this->db->where('ACTIVE', 1);
            }
            $this->db->select('SQL_CALC_FOUND_ROWS *, usados + nuevos + reserv AS exist, usados + nuevos AS disp', false);
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
            // $i=1+$iDisplayStart;
            $i=$iDisplayStart;
            foreach($rResult->result_array() as $aRow)//construccion a pie de los campos a mostrar en la lista, cada $row[] es una fila de la lista, y lo que se le asigna en el orden es cada columna
            {
                $row = array();
                
                // foreach($aColumns as $col)
                // {
                //     $row[] = $aRow[$col];
                // }
                $row[]= '<div align="center">'.$i.'</div>';//primera columna
                $i++;
                $row[]= '<div align="center">'.$aRow['cod_articulo'].'</div>';//segunda columna
                $row[]= $aRow['descripcion'];//tercera columna
                // if(!empty($this->session->userdata('articulos')) && in_array($aRow['ID'], $this->session->userdata('articulos')))
                // {
                  // $row[]='<span id="clickable"><i id="row_'.$aRow['ID'].'" class="fa fa-minus" style="color:#D9534F"></i></span>';
                // }
                // else
                // {
                    $row[]='<div align="center"><span id="clickable"><i id="row_'.$aRow['ID'].'" class="fa fa-plus color"></i></span></div>';
                // }
                $row['DT_RowId']='row_'.$aRow['ID'];//necesario para agregar un ID a cada fila, y para ser usado por una funcion del DataTable
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

    // public function ajax_formProcessing()//para agregar articulos
    // {
    //     if($this->session->userdata('user'))
    //     {
    //         if ($this->input->post())
    //         {
    //             $aux = explode(" codigo=", $this->input->post('descripcion'));
    //             if(is_numeric($aux[0]))//verifica si la primera ocurrencia del dato recibido, es un numero (para asociar con el codigo del articulo)
    //             {
    //                 $articulo['cod_articulo']=$aux[0];
    //             }
    //             else
    //             {
    //                 $articulo['descripcion']=$aux[0];
    //                 if(!empty($aux[1]))//verifica si al pasar la descripcion, viene en el formato del autocompletar
    //                 {
    //                     $articulo['cod_articulo']=$aux[1];
    //                 }
    //             }
    //             if(!$this->model_alm_articulos->exist_articulo($articulo))//aqui construllo el formulario de articulo nuevo
    //             {
                // echo '
                //     </br>
                //     <div id="inv">
                //         <div class="alert alert-warning" style="text-align: right"> Debe agregar todos los detalles del art&iacute;culo nuevo para inventario, definiendo un c&oacute;digo &uacute;nico para el art&iacute;culo nuevo
                //         </br>
                //         Recuerde consultar las condiciones de dise&ntilde;o para asignar un c&oacute;digo al articulo
                //         </div>
                //         <div class="row">
                //             <i class="color col-lg-8 col-md-8 col-sm-8" align="right" >(*)  Campos Obligatorios</i>
                //         </div>
                //         <div id="new_inv_error" class="alert alert-danger" style="text-align: center">
                //         </div>
                //         <form id="new_inv" class="form-horizontal">
                //             <!-- cod_articulo -->
                //             <div class="form-group">
                //                 <label class="control-label" for="cod_articulo"><i class="color">*  </i>C&oacute;digo:</label>
                //                 <div class="input-group col-md-5">
                //                     <input type="text" class="form-control" id="cod_articulo" name="cod_articulo" onkeyup="validateNumber(name)"><span id="loading"><img src="'.base_url().'assets/img/ajax-loader.gif" alt="Ajax Indicator" /></span>
                //                     <span id="cod_articulo_msg" class="label label-danger"></span>
                //                 </div>
                //             </div>
                            
                //             <!-- unidad -->
                //             <div class="form-group">
                //                 <label class="control-label" for="unidad"><i class="color">*  </i>Unidad:</label>
                //                 <div class="input-group col-md-5">
                //                     <input type="text" class="form-control" id="unidad" name="unidad" onkeyup="validateSingleWord(name)">
                //                     <span id="unidad_msg" class="label label-danger"></span>
                //                 </div>
                //             </div>
                            
                //             <!-- descripcion -->
                //             <div class="form-group">
                //                 <label class="control-label" for="descripcion"><i class="color">*  </i>Descripci&oacute;n:</label>
                //                 <div class="input-group col-md-5">
                //                     <input type="text" class="form-control" id="descripcion" name="descripcion">
                //                 </div>
                //             </div>
                            
                //             <!-- nuevo -->
                //             <div class="form-group" style="text-align: center">
                //                 <label class="control-label" for="radio">Estado del art&iacute;culo</label>
                //                 <label class="radio" for="radio-0">
                //                     <input name="nuevo" id="radio-0" value="1" checked="checked" type="radio">
                //                     Nuevo
                //                 </label>
                //                 <label class="radio" for="radio-1">
                //                     <input name="nuevo" id="radio-1" value="0" type="radio">
                //                     Usado
                //                 </label>
                //             </div>
                            
                //             <!-- imagen -->
                            
                //             <div class="form-group">
                //                 <label class="control-label" for="imagen">Imagen del articulo:</label>
                //                 <div class="input-group col-md-5">
                //                     <input id="imagen" type="file" multiple="true">
                //                 </div>
                //             </div>
                            
                //             <!-- cantidad -->
                //             <div class="form-group">
                //                 <label class="control-label" for="cantidad"><i class="color">*  </i>Cantidad:</label>
                //                 <div class="input-group col-md-1">
                //                     <input type="text" class="form-control" id="cantidad" name="cantidad" onkeyup="validateNumber(name)">
                //                     <span id="cantidad_msg" class="label label-danger"></span>
                //                 </div>
                //             </div>
                            
                //             <!-- peso_kg -->
                //             <div class="form-group">
                //                 <label class="control-label" for="peso_kg">Peso:</label>
                //                 <div class="input-group col-md-5">
                //                     <input type="text" class="form-control" id="peso_kg" name="peso_kg" onkeyup="validateRealNumber(name)">
                //                     <span id="peso_kg_msg" class="label label-danger"></span>
                //                     <span class="input-group-addon">Kg</span>
                //                 </div>
                //             </div>

                //             <!-- dimension_cm -->
                //             <div class="form-group">
                //                 <label class="control-label" for="dimensiones">Dimensiones:</label>
                //                 <div class="input-group col-md-6">
                //                     <input type="text" class="form-control" id="alto" name="alto" placeholder="Alto" onkeyup="validateRealNumber(name)">
                //                     <span class="input-group-addon"> cm x</span>
                //                     <input type="text" class="form-control" id="ancho" name="ancho" placeholder="Ancho" onkeyup="validateRealNumber(name)">
                //                     <span class="input-group-addon"> cm x</span>
                //                     <input type="text" class="form-control" id="largo" name="largo" placeholder="Largo" onkeyup="validateRealNumber(name)">
                //                     <span class="input-group-addon"> cm</span>
                //                 </div>
                //                 <span id="alto_msg" class="label label-danger"></span>
                //                 <span id="ancho_msg" class="label label-danger"></span>
                //                 <span id="largo_msg" class="label label-danger"></span>
                //             </div>
                //             <!-- observacion -->
                //             <div class="form-group">
                //                 <label class="control-label" for="observacion"><i class="color">*  </i>Observaci&oacute;n:</label>
                //                 <div class="input-group col-md-5">
                //                     <textarea type="text" class="form-control" id="observacion" name="observacion" onfocus="validateNotEmpty(name)"/> 
                //                     <span id="observacion_msg" class="label label-danger"></span>
                //                 </div>
                //             </div>

                //             <button id="new_invSub" type="submit" class="btn btn-default">Agregar</button>
                //         </form>
                //     </div>
                //     <script type="text/javascript">
                //         $("#imagen").fileinput({
                //             showCaption: false,
                //             previewFileType: "image",
                //             browseLabel: " Examinar...",
                //             browseIcon: \'<i class="glyphicon glyphicon-picture"></i>\',
                //             removeClass: "btn btn-danger",
                //             removeLabel: "Delete",
                //             removeIcon: \'<i class="glyphicon glyphicon-trash"></i>\',
                //             showUpload: false
                //         });
                //         $(function()
                //         {
                //             $("#new_inv_error").hide();
                //             $("#loading").hide();
                //             var flag=false;
                //             var valid =false;// auxiliar para validar on blur de la existencia del codigo
                //             $("#cod_articulo").keyup(function(){
                //                 if($("#cod_articulo").val().length>3)
                //                 {
                //                     var codigo = $("#cod_articulo").val();
                //                     $("#loading").show();
                //                     $.post("inventario/articulo/check", {
                //                         codigo : codigo
                //                     }, function(resp){
                //                         $("#loading").hide();
                //                         console.log(resp);
                //                         flag = resp.bool;
                //                         if(!resp.bool)
                //                         {
                //                             $("#cod_articulo").attr("style", "background-color: #F2DEDE");
                //                             $("#cod_articulo_msg").html(resp.message).show();
                //                             // $("#cod_articulo_msg").html(resp.message).show().delay(4000).fadeOut();
                //                         }
                //                             return false;
                //                     });
                //                 }
                //             });
                //             $("#new_invSub").click(function()
                //             {
                //                 $("#new_inv_error").hide();
                //                 console.log(flag);
                //                 if($("input#cod_articulo").val()=="")
                //                 {
                //                     $("#new_inv_error").html("el c&oacute;digo es obligatorio");
                //                     $("#new_inv_error").show();
                //                     $("input#cod_articulo").focus();
                //                     return false;
                //                 }
                //                 if(!flag)
                //                 {
                //                     $("#new_inv_error").html("el c&oacute;digo ya esta usado");
                //                     $("#new_inv_error").show();
                //                     $("input#cod_articulo").focus();
                //                     return false;
                //                 }
                                
                //                 if($("input#unidad").val()=="")
                //                 {
                //                     $("#new_inv_error").html("La unidad es obligatorio");
                //                     $("#new_inv_error").show();
                //                     $("input#unidad").focus();
                //                     return false;
                //                 }
                //                 if($("input#descripcion").val()=="")
                //                 {
                //                     $("#new_inv_error").html("La descripci&oacute;n es obligatorio");
                //                     $("#new_inv_error").show();
                //                     $("input#descripcion").focus();
                //                     return false;
                //                 }
                //                 if($("input#cantidad").val()=="")
                //                 {
                //                     $("#new_inv_error").html("La cantidad es obligatorio");
                //                     $("#new_inv_error").show();
                //                     $("input#cantidad").focus();
                //                     return false;
                //                 }
                //                 if($("textarea#observacion").val()=="")
                //                 {
                //                     $("#new_inv_error").html("Debe indicar la orden de compra en Observacion");
                //                     $("#new_inv_error").show();
                //                     $("textarea#observacion").focus();
                //                     return false;
                //                 }
                //                 var aux = $("#new_inv").serializeArray();
                //                 console.log($("#new_inv").serializeArray());
                //                 $.ajax(
                //                 {
                //                     type: "POST",
                //                     url: "inventario/articulo/agregar",
                //                     data: aux,
                //                     success: function(response)
                //                     {
                //                         $("#inv").html(response);
                //                     },
                //                     error: function(jqXhr){
                //                         if(jqXhr.status == 400)
                //                         {
                //                             $("#inv").html(jqXhr.responseText);
                //                             // var json = $.parseJSON(jqXhr.responseText);
                //                         }
                //                             console.log(jqXhr);
                //                     }
                //                 });
                //                 return(false);
                //             });
                //         });
                //     </script>
                // ';
                // }
                // else //aqui construllo el formulario para la cantidad de articulos que se agrega a inventario
                // {
                //     $art = $this->model_alm_articulos->exist_articulo($articulo);
                    // echo_pre($art, __LINE__, __FILE__);
                // echo '
                //     </br>
                //     <div id="inv">
                //         <div id="inv_error" class="alert alert-danger" style="text-align: center">
                //         </div>
                //         <div class="row">
                //             <i class="color col-lg-8 col-md-8 col-sm-8" align="right" >(*)  Campos Obligatorios</i>
                //         </div>
                //         <form id="add_inv" class="form-horizontal">
                //             <!-- nuevo -->
                //             <div class="form-group" style="text-align: center">
                //                 <label class="control-label" for="radio">Estado del art&iacute;culo</label>
                //                 <label class="radio" for="radio-0">
                //                     <input name="nuevo" id="radio-0" value="1" checked="checked" type="radio">
                //                     Nuevo
                //                 </label>
                //                 <label class="radio" for="radio-1">
                //                     <input name="nuevo" id="radio-1" value="0" type="radio">
                //                     Usado
                //                 </label>
                //             </div>
                //             <!-- cantidad -->
                //             <div class="form-group">
                //                 <label class="control-label" for="cantidad"><i class="color">*  </i>Cantidad:</label>
                //                 <div class="input-group col-md-8">
                //                     <input type="text" class="form-control" id="cantidad" name="cantidad" onkeyup="validateNumber(name)">
                //                     <span id="cantidad_msg" class="label label-danger"></span>
                                    // <span class="input-group-addon">x 1'.$art["unidad"].'</span>
                //                 </div>
                //             </div>
                //             <!-- observacion -->
                //             <div class="form-group">
                //                 <label class="control-label" for="observacion"><i class="color">*  </i>Observaci&oacute;n:</label>
                //                 <div class="input-group">
                //                     <textarea type="text" class="form-control" id="observacion" name="observacion" onfocus="validateNotEmpty(name)"/>
                //                     <span id="observacion_msg" class="label label-danger"></span>
                //                 </div>
                //             </div>
                //                     <input type="hidden" name="cod_articulo" value="'.$art['cod_articulo'].'"/>

                //             <button id="invSub" type="submit" class="btn btn-default">Agregar</button>
                //         </form>
                //     </div>
                //     <script type="text/javascript">
                //         $(function()
                //         {
                //             $("#inv_error").hide();
                //             $("#invSub").click(function()
                //             {
                //                 $("#inv_error").hide();
                //                 if($("input#cantidad").val()=="")
                //                 {
                //                     $("#inv_error").html("La cantidad es obligatorio");
                //                     $("#inv_error").show();
                //                     $("input#cantidad").focus();
                //                     return false;
                //                 }
                //                 if($("textarea#observacion").val()=="")
                //                 {
                //                     $("#inv_error").html("Debe indicar la orden de compra en Observacion");
                //                     $("#inv_error").show();
                //                     $("textarea#observacion").focus();
                //                     return false;
                //                 }
                //                 var aux = $("#add_inv").serializeArray();
                //                 console.log($("#add_inv").serializeArray());
                //                 $.ajax(
                //                 {
                //                     type: "POST",
                //                     url: "inventario/articulo/agregar",
                //                     data: aux,
                //                     success: function(response)
                //                     {
                //                         $("#inv").html(response);
                //                     },
                //                     error: function(jqXhr){
                //                         if(jqXhr.status == 400)
                //                         {
                //                             $("#inv").html(jqXhr.responseText);
                //                             // var json = $.parseJSON(jqXhr.responseText);
                //                         }
                //                             console.log(jqXhr);
                //                     }
                //                 });
                //                 return(false);
                //             });
                //         });
                //     </script>
                // ';

                    // echo_pre($this->model_alm_articulos->get_ArtHistory($art), __LINE__, __FILE__);
    //             }
    //         }
    //     }
    //     else
    //     {
    //         $header['title'] = 'Error de Acceso';
    //         $this->load->view('template/erroracc',$header);
    //     }
        
    // }
    // public function ajax_codeCheck()//verifica que el codigo de articulo exista o no
    // {
    //     if($this->session->userdata('user'))
    //     {
    //         if($this->input->is_ajax_request())
    //         {
    //             $codigo = $this->input->post('codigo');
    //             if(!$this->form_validation->is_unique($codigo, 'alm_articulo.cod_articulo'))
    //             { 
    //                 $aux= array(
    //                     'message' => 'El c&oacute;digo ya existe, elija otro', 
    //                     'bool' => false);
    //             }
    //             else
    //             {
    //                 $aux= array(
    //                     'message' => '', 
    //                     'bool' =>true);
    //             }
    //             header('Content-type: application/json');
    //             echo json_encode($aux);
    //         }
    //     }
    //     else
    //     {
    //         $header['title'] = 'Error de Acceso';
    //         $this->load->view('template/erroracc',$header);
    //     }
    // }
    // public function pdf_cierreInv($date='') //aqui quede //"disbanded"
    // {
    //     if(isset($date) && !empty($date))
    //     {
    //         // echo_pre(date('d-m-Y', time()));
    //         // die_pre(date('d-m-Y', $date), __LINE__, __FILE__);
    //         $view['cabecera']="reporte del cierre de inventario";
    //         $view['tabla']="reporte";
    //         $view['fecha_cierre']=$date;
    //         if($date<=$this->model_alm_articulos->ult_cierre())
    //         {
    //             $desde = $this->model_alm_articulos->ant_cierre($date);//reporte desde historial
    //             $flag='hist';
    //         }
    //         else
    //         {
    //             $desde = $this->model_alm_articulos->ult_cierre();//reporte  desde cierre
    //             $flag='cierre';
    //         }
    //         $hasta = $date;

    //         $rango['desde']= $desde;
    //         $rango['hasta']= $hasta;
    //         // die_pre($rango, __LINE__, __FILE__);
    //         if($desde==$hasta || empty($hasta))
    //         {
    //             die_pre("error de rangos de fecha", __LINE__, __FILE__);
    //         }
    //         else
    //         {
    //             $view['historial'] = $this->model_alm_articulos->get_histmovimiento($rango);
    //             $view['historial'] = $this->model_alm_articulos->build_report($rango);
    //             if($flag=='cierre')
    //             {
    //                 $this->model_alm_articulos->insert_cierre($rango);
    //             }
    //             // echo base_url()
    //             $file_to_save = 'uploads/cierres/'.date('Y-m-d',$date).'.pdf';
    //             // echo $file_to_save;
    //             $this->load->helper('file');
    //             // Load all views as normal
    //             $this->load->view('reporte_pdf', $view);
    //             // Get output html
    //             $html = $this->output->get_output();
    //             // Load library
    //             $this->load->library('dompdf_gen');

    //             // Convert to PDF
    //             $this->dompdf->load_html(utf8_decode($html));
    //             $this->dompdf->render();
    //             if(! write_file($file_to_save, $this->dompdf->output()))
    //             {
    //                 echo 'error';
    //             }
    //             else
    //             {
    //                 $this->dompdf->stream("solicitud.pdf", array('Attachment' => 0));
    //             }
    //         }
    //     }
    //     else
    //     {

    //     }
    // }
    public function pdf_reportesInv($extra='')//aqui estoy haciendo los reportes
    {
        if($this->session->userdata('user'))
        {
            // echo_pre('permiso para ver reportes', __LINE__, __FILE__);
            $date = time();
            $view['cabecera']="reporte del estado de inventario";//titulo acompanante de la cabecera del documento
            $view['nombre_tabla']="reporte";//nombre de la tabla que construira el modelo
            $view['fecha_cierre']=$date; //la fecha de hoy
            $view['tabla'] = $this->model_alm_articulos->build_report($extra);//construccion de la tabla

            // $file_to_save = 'uploads/cierres/'.date('Y-m-d',$date).'.pdf';
            // $this->load->helper('file');

                // Load all views as normal
                $this->load->view('reporte_pdf', $view);
                // Get output html
                $html = $this->output->get_output();
                // Load library
                $this->load->library('dompdf_gen');

                // Convert to PDF
                $this->dompdf->load_html(utf8_decode($html));
                $this->dompdf->render();
                // if(! write_file($file_to_save, $this->dompdf->output()))
                // {
                    // echo 'error';
                // }
                // else
                // {
                    $this->dompdf->stream("inventario.pdf", array('Attachment' => 0));
                // }
        }
        else
        {
            $header['title'] = 'Error de Acceso';
            $this->load->view('template/erroracc',$header);
        }
    }
    public function pdf_ActaDeCierre()
    {
        if($this->dec_permiso->has_permission('alm', 8))//permiso para insertar o hacer cierres de inventario
        {
            // die_pre($this->uri->uri_string(), __LINE__, __FILE__);
            /*
            Autores
                jefe de almacen
                jefe de compras
                coordinador administrativo
            fechas
                hora de inicio
                hora generado
            */
            $date = time();
            $done = date('h:i a',$date).' del '.readNumber(date('j',$date)).' ('.date('j',$date).')'.' de '.date('F',$date).' de '.date('Y',$date);
            $start = '';
            $vars = array(
                'authors' => array(
                    'jefe_alm' => 'Gabriel Hernandez',
                    'jefe_comp'=> 'Lic. Andreina Granados',
                    'coord_adm'=> 'Lic. Romali Kolster'
                    ),
                'dates' => array(
                    'start' => $start,
                    'done' => $done
                    )
                );

            $this->load->library('Pdf');
            ob_start();
            // $pdf = new Pdf('P', 'mm', 'A4', true, 'UTF-8', false);
            $pdf = new Actaspdf('P', 'mm', 'A4', true, 'UTF-8', false);
            $pdf->SetTitle('ActaCorrectiva');
            $pdf->SetHeaderMargin(30);
            $pdf->SetTopMargin(20);
            $pdf->setFooterMargin(20);
            $pdf->SetAutoPageBreak(true);
            $pdf->SetAuthor('Author');
            $pdf->SetDisplayMode('real', 'default');

            $pdf->AddPage();
            // $pdf->table();
                $pdf->Ln(38);
                // set font
                $pdf->SetFont('helvetica', 'B', 14);

                $pdf->Write(0, 'ACTA CORRECTIVA', '', 0, 'C', true, 0, false, false, 0);
                $pdf->Ln(3);
                $pdf->SetMargins(23, 30, 35);
                // create some HTML content
                $html = '<p style="text-align:justify;">En la Facultad Experimental de Ciencias y Tecnología, a las <b>'.$done.'</b>, Habiendose realizado un cotejo al inventario de Materiales y Suministros que reposan en el Almacén de la Facultad Experimental de Ciencias y Tecnología, se detectaron algunos errores en la contabilización de algunos artículos (Identificados adelante) procediendo a subsanar a través de la siguiente acta, con lo cual se deja constancia de haberse realizado la corrección respectiva, arrojando el siguiente resultado.</p>';
                // set core font
                $pdf->SetFont('helvetica', '', 12);
                // output the HTML content
                $pdf->writeHTML($html, true, 0, true, true);
                $pdf->Ln();

                // $html = '<span style="text-align:justify;">a <u>abc</u> abcdefghijkl (abcdef) abcdefg <b>abcdefghi</b> a ((abc)) abcd <img src="assets/img/FACYT.png" border="0" height="41" width="41" /> <img src="assets/img/FACYT.png" alt="test alt attribute" width="80" height="60" border="0" /> abcdef abcdefg <b>abcdefghi</b> a abc abcd abcdef abcdefg <b>abcdefghi</b> a abc abcd abcdef abcdefg <b>abcdefghi</b> a <u>abc</u> abcd abcdef abcdefg <b>abcdefghi</b> a abc \(abcd\) abcdef abcdefg <b>abcdefghi</b> a abc \\\(abcd\\\) abcdef abcdefg <b>abcdefghi</b> a abc abcd abcdef abcdefg <b>abcdefghi</b> a abc abcd abcdef abcdefg <b>abcdefghi</b> a abc abcd abcdef abcdefg abcdefghi a abc abcd <a href="http://tcpdf.org">abcdef abcdefg</a> start a abc before <span style="background-color:yellow">yellow color</span> after a abc abcd abcdef abcdefg abcdefghi a abc abcd end abcdefg abcdefghi a abc abcd abcdef abcdefg abcdefghi a abc abcd abcdef abcdefg abcdefghi a abc abcd abcdef abcdefg abcdefghi a abc abcd abcdef abcdefg abcdefghi a abc abcd abcdef abcdefg abcdefghi a abc abcd abcdef abcdefg abcdefghi a abc abcd abcdef abcdefg abcdefghi<br />abcd abcdef abcdefg abcdefghi<br />abcd abcde abcdef</span>';
                // set UTF-8 Unicode font
                // $pdf->SetFont('helvetica', '', 10);

                // output the HTML content
                // $pdf->writeHTML($html, true, 0, true, true);

                // reset pointer to the last page
                $pdf->lastPage();

                // ---------------------------------------------------------

                //Close and output PDF document
                // if($this->uri->uri_string()=='inventario/generar/acta')
                // {
                    $pdf->Output('example_039.pdf', 'I');
                // }
                // if($this->uri->uri_string()=='inventario/cerrar')
                // {
                //     $pdf->Output('example_039.pdf', 'I');

                // }
            // $pdf->Write(20, 'Some sample text');
            // $pdf->Output('My-File-Name.pdf', 'I');
            // readNumber();
            // for ($i=1; $i <=31 ; $i++)
            // {
            //     echo $i.': '.readNumber($i).'<br>';
            // }
            // die();
            // $this->pdf->AddActaPage();
            // $this->pdf->ActaCorrectiva($vars);
            // // $this->pdf->ActaHeader();
            // // $this->pdf->ActaFooter();
            // $this->pdf->SetDisplayMode(100,'default');

            // $this->pdf->AliasNbPages();

            // $this->pdf->SetMargins(8, 8 , 8);

            // $this->pdf->SetAutoPageBreak(true,15);
            
            // $this->pdf->SetTitle("Cierre de Inventario");

            // $this->pdf->Ln(7);
            // // $this->pdf->sumary($txt);

            // // $this->pdf->Cell($this->pdf->GetPageWidth(),6,iconv('UTF-8', 'windows-1252 //IGNORE',('boo')),0,0,'C');
            // $date = time();
            // // $file_to_save = './uploads/cierres/Cierre_'.date('Y-m-d',$date).'.pdf';
            // // $this->pdf->Output($file_to_save, 'F');
            // // $this->pdf->Output($file_to_save);
            // $this->pdf->CloseActaPage();
            // $this->pdf->Output();
            // echo $file_to_save;
        }
        else
        {
            $this->session->set_flashdata('permission', 'error');
            redirect('inicio');
        }
    }
    public function pdf_cierreFinal($array='')
    {
        // echo_pre('permiso para realizar cierres', __LINE__, __FILE__);
        if($this->dec_permiso->has_permission('alm', 13))
        {
            // $array =
            // echo('BOOM! goes the dynamite');
            // die_pre($array);
            $date = time();
            $sumary = $array['sumary'];
            unset($array['sumary']);
            $rResult = $array;
            $head_table = ['Código', 'Descripción', 'Existencia en sistema', 'Existencia en físico', 'Observación', 'Clasificacion'];
            $table_column = ['codigo', 'descripcion', 'existencia', 'fisico', 'observacion', 'clasifier'];
            $tipoDeReporte = 1;
            $view['title'] = 'Reporte de cierre de inventario '.date('Y',$date);
            $view['table_head'] = $head_table;
            $view['table_column'] = $table_column;
            $view['tipo'] = $tipoDeReporte;
            $view['tabla']=$rResult;

            $titulo = array('1' => $view['title']);
            $this->load->library('fpdf');

            $this->pdf = new PDF('P','mm','letter');

            $this->pdf->AddPage();
            $this->pdf->SetDisplayMode(100,'default');

            $this->pdf->AliasNbPages();

            $this->pdf->SetMargins(8, 8 , 8);

            $this->pdf->SetAutoPageBreak(true,15);
            
            $this->pdf->SetTitle("Cierre de Inventario");

            $this->pdf->Tabla($head_table,$rResult,$table_column,$titulo,$tipoDeReporte);
            
            /*Aqui tienes, donde Titulo, SUbtitulo y Alineacion son opcionales)
             * y los demas elementos debes establecerlo con Label y Text. 
             */
            // $txt = array(array());
            $i=0;
            $txt[$i]['Titulo'] = 'Resumen de cierre';
            $txt[$i]['a'] = 'C';
            $i++;
            foreach ($sumary as $key => $value)
            {
                if($key == 'sinRegistrar')
                {
                    // $txt[$i] = array('Label'=>'Artículos No-registrados en el sistema:','Text'=>$value['sinRegistrar']);
                    $txt[$i]['Text'] = 'Artículos sin registrar en el sistema.';
                    $txt[$i]['Label'] = $value;
                }
                if($key == 'sobrante')
                {
                    // $txt[$i] = array('Label'=>'Artículos con cantidades sobrantes en el sistema','Text'=>$value['sobrante']);
                    $txt[$i]['Text'] = 'Artículos con cantidad sobrante en el sistema.';
                    $txt[$i]['Label'] = $value;
                }
                if($key == 'faltante')
                {
                    // $txt[$i] = array('Label'=>'Artículos con cantidades faltantes en el sistema','Text'=>$value['faltante']);
                    $txt[$i]['Text'] = 'Artículos con cantidad faltante en el sistema.';
                    $txt[$i]['Label'] = $value;
                }
                if($key == 'sinReportar')
                {
                    // $txt[$i] = array('Label'=>'Artículos no reportados en el archivo suministrado','Text'=>$value['sinReportar']);
                    $txt[$i]['Text'] = 'Artículos no reportados en el archivo suministrado';
                    $txt[$i]['Label'] = $value;
                }
                if($key == 'sinProblemas')
                {
                    // $txt[$i] = array('Label'=>'Artículos sin incongruencias en el cuadre del cierre','Text'=>$value['sinProblemas']);
                    $txt[$i]['Text'] = 'Artículos sin incongruencias en el cuadre del cierre.';
                    $txt[$i]['Label'] = $value;
                }
                if($key == 'sobranteGlobal')
                {
                    // $txt[$i] = array('Label'=>'Cantidad global de artículos sobrantes','Text'=>$value['sobranteGlobal']);
                    $txt[$i]['Label'] = 'Total de artículos sobrantes:';
                    $txt[$i]['Text'] = $value.'.';
                }

                if($key == 'faltanteGlobal')
                {
                    // $txt[$i] = array('Label'=>'Cantidad global de articulos faltantes','Text'=>$value['faltanteGlobal']);
                    $txt[$i]['Label'] = 'Total de articulos faltantes:';
                    $txt[$i]['Text'] = $value.'.';
                }
                $i++;
            }
            // die_pre($txt);
            // $txt = array(array('Titulo'=> 'Resumen de cierre','Subtitulo'=>'','a'=>'C'),
            //     array('Label'=>'Texto:','Text'=>'Todo el parrafo que requieras escribir, hasta donde quieras y necesites.'),
            //     array('Label'=> 'Siguiente','Text'=>'Y asi sucesivamente,'),array('Label'=>'Hasta:','Text'=>'Que llegues a N.'));
            $this->pdf->Ln(7);
            $this->pdf->sumary($txt);

            // $this->pdf->Cell($this->pdf->GetPageWidth(),6,iconv('UTF-8', 'windows-1252 //IGNORE',('boo')),0,0,'C');
            $date = time();
            $file_to_save = './uploads/cierres/Cierre_'.date('Y-m-d',$date).'.pdf';
            $this->pdf->Output($file_to_save, 'F');
            echo $file_to_save;
            // echo $file_to_save;
            // $date = time();
            // $view['cabecera']="reporte del cierre de inventario al";//titulo acompanante de la cabecera del documento
            // $view['nombre_tabla']="cierre de inventario";//nombre de la tabla que construira el modelo
            // $view['fecha_cierre']=$date; //la fecha de hoy
            // $view['tabla'] = $array;//construccion de la tabla

            // $file_to_save = 'uploads/cierres/'.date('Y-m-d',$date).'.pdf';
            // $this->load->helper('file');

            // // Load all views as normal
            // $this->load->view('reporte_pdf', $view);
            // // Get output html
            // $html = $this->output->get_output();
            // // Load library
            // $this->load->library('dompdf_gen');

            // // Convert to PDF
            // $this->dompdf->load_html(utf8_decode($html));
            // $this->dompdf->render();
            // $output = $this->dompdf->output();
            // if(! write_file($file_to_save, $output))
            // {
            //     return('error');
            // }
            // else
            // {
            //     return($file_to_save);
            //     // $this->dompdf->stream("solicitud.pdf", array('Attachment' => 0));
            // }
        }
        else
        {
            $this->session->set_flashdata('permission', 'error');
            redirect('inicio');
        }

    }

    public function upload_excel($option='')//para subir un archivo de lista de inventario fisico
    {
        $date = time();
////////defino los parametros de la configuracion para la subida del archivo
        $config['upload_path'] = './uploads/';
        // $config['allowed_types'] = 'xls|xlsx|ods|csv|biff|pdf|html';//esta linea da conflictos en centos 7
        $config['allowed_types'] = '*';
        if($option)
        {
            $config['filename']= $option.'_'.date('Y-m', $date);
        }
        else
        {
            $config['file_name']= 'inv_fisico'.date('Y-m',$date);
        }
        // $config['file_name']= 'inv_fisico'.date('Y-m',$date);
        $config['overwrite']= true;
        $config['max_size'] = '2048';
////////defino los parametros de la configuracion para la subida del archivo
        $this->load->library('upload', $config);//llamo a la libreria y le paso la configuracion
        if ( ! $this->upload->do_upload())//si ocurre un error en la subida...
        {
            $error = array('error' => $this->upload->display_errors());
            echo json_encode($error);
            // $this->load->view('upload_form', $error);
        }
        else//si todo sube como debe
        {
            echo json_encode($this->upload->data()['full_path']);
            // return($this->upload->data()['full_path']);//retorno la direccion y nombre del archivo como string
        }
    }
    public function read_excel()//para leer un archivo de excel o compatible con excel y genera los datos para el reporte a partir de 2 funciones de BD
    {
        if($this->session->userdata('user'))
        {
            //lee un excell para cierre de inventario
            // echo $this->input->post("file");
            if($this->input->post("file"))
            {
                $file = $this->input->post("file");
                $objPHPExcel = PHPExcel_IOFactory::load($file);//llamo la libreria de excel para cargar el archivo de excel
                $cell_collection = $objPHPExcel->getActiveSheet()->getCellCollection();//recorrere el archivo por celdas

            ////version actual
                $verifica = true;
            ////version actual
                $arraycod=array();
                foreach ($cell_collection as $cell) //para cada celda
                {
                    $column = $objPHPExcel->getActiveSheet()->getCell($cell)->getColumn();//columna
                    $row = $objPHPExcel->getActiveSheet()->getCell($cell)->getRow();//fila
                    $data_value = $objPHPExcel->getActiveSheet()->getCell($cell)->getValue();//dato en la columna-fila
                    
                    if($row <= 1)//esto depende de la tabla, con o sin titulo(sin titulo)
                    {
                        if($data_value=='cod_articulo' || $data_value=='Codigo del articulo')
                        {
                            $col_articulo = $column;
                        }
                        if($data_value=='cantidad_existencia' || $data_value=='Cantidad en existencia')
                        {
                            $col_exist = $column;
                        }
                        if($data_value == 'descripcion' || $data_value == 'Descripción')
                        {
                            $col_descripcion = $column;
                        }
                    }
                    else
                    {
                        if($column == $col_articulo)//codigo del articulo
                        {
                            // $arr_data[$row][$column] = $data_value;
                            // $aux['linea'] = $row;
                            $array[$row-2]['linea'] = $row;
                            $array[$row-2]['cod_articulo'] = $data_value;
                            $arraycod[$row-2]=$array[$row-2]['cod_articulo'];
                        }
                        if($column == $col_descripcion)
                        {
                            $array[$row-2]['linea'] = $row;
                            if(!isset($array[$row-2]['cod_articulo']))
                            {
                                $array[$row-2]['cod_articulo'] = ' ';
                            }
                            // $aux['descripcion'] = $data_value;
                            $array[$row-2]['descripcion'] = $data_value;
                            // $aux['existencia'] = 'X';
                            $array[$row-2]['existencia'] = 'sin reportar';
                            $arraycod[$row-2]=$array[$row-2]['cod_articulo'];
                        }
                        if($column == $col_exist)//cantidad en existencia (tambien es la ultima columna a leer)
                        {
                            $array[$row-2]['linea'] = $row;
                            if(!isset($array[$row-2]['cod_articulo']))
                            {
                                $array[$row-2]['cod_articulo'] = ' ';
                            }
                            $array[$row-2]['existencia'] = $data_value;
                            $arraycod[$row-2]=$array[$row-2]['cod_articulo'];
                            
                        }
                        //inserto la data en la tabla alm_reporte
                        if(isset($array[$row-2]['cod_articulo']) && isset($array[$row-2]['existencia']) && $array[$row-2]['cod_articulo']!=' ' && $array[$row-2]['existencia']!='sin reportar')
                        {
                            // $this->model_alm_articulos->insert_reporte($array[$row-2]);
                            // $verifica *=true;
                            // $verifica *= $this->model_alm_articulos->insert_reporte($array[$row-2]);
                            $batch[] = $array[$row-2];
                        }

                    }
                }
                echo_pre($array, __LINE__, __FILE__);
                echo_pre($batch, __LINE__, __FILE__);
                $this->model_alm_articulos->insert_reporte($batch, TRUE);
            ////version actual
                if($verifica)
                {
                    $success['status']='success';
                    echo json_encode($success);
                }
                else
                {
                    $error['status']='error';
                    echo json_encode($error);
                }

            ////version actual
            ////version anterior
                // $arr_data = $this->model_alm_articulos->verif_arts($array, $arraycod);
                
                // $arr_data = $this->model_alm_articulos->art_notInReport($arr_data);//segunda funcion de base de datos
                // $sumary['sinRegistrar'] = 0;
                // $sumary['sobrante'] = 0;
                // $sumary['faltante'] = 0;
                // $sumary['sinReportar'] = 0;
                // $sumary['sinProblemas'] = 0;
                // $sumary['sobranteGlobal'] = 0;
                // $sumary['faltanteGlobal'] = 0;

                // foreach ($arr_data as $key => $value)
                // {
                //     // if(isset($value['sinRegistrar']))
                //     // {
                //         $sumary['sinRegistrar'] = $sumary['sinRegistrar'] + $value['sinRegistrar'];
                //         unset($value['sinRegistrar']);
                //     // }
                //     // if(isset($value['sobrante']))
                //     // {
                //         $sumary['sobrante'] = $sumary['sobrante'] + $value['sobrante'];
                //         unset($value['sobrante']);
                //     // }
                //     // if(isset($value['sobranteGlobal']))
                //     // {
                //         $sumary['sobranteGlobal'] = $sumary['sobranteGlobal'] + $value['sobranteGlobal'];
                //         unset($value['sobranteGlobal']);
                //     // }
                //     // if(isset($value['faltante']))
                //     // {
                //         $sumary['faltante'] = $sumary['faltante'] + $value['faltante'];
                //         unset($value['faltante']);
                //     // }
                //     // if(isset($value['faltanteGlobal']))
                //     // {
                //         $sumary['faltanteGlobal'] = $sumary['faltanteGlobal'] + $value['faltanteGlobal'];
                //         unset($value['faltanteGlobal']);
                //     // }
                //     // if(isset($value['sinReportar']))
                //     // {
                //         $sumary['sinReportar'] = $sumary['sinReportar'] + $value['sinReportar'];
                //         unset($value['sinReportar']);
                //     // }
                //     // if(isset($value['sinProblemas']))
                //     // {
                //         $sumary['sinProblemas'] = $sumary['sinProblemas'] + $value['sinProblemas'];
                //         unset($value['sinProblemas']);
                //     // }
                // }
                // $arr_data['sumary'] = $sumary;
                
                // $aux = $this->pdf_cierreFinal($arr_data);
            ////FIN de version anterior
                
            }
            else
            {
                return(false);
            }
        }
        else
        {
            $header['title'] = 'Error de Acceso';
            $this->load->view('template/erroracc',$header);
        }
    }

    public function excel_to_DB()//sube y lee un archivo de excel para cargar articulos que no esten en la BD
    {
        // echo_pre('permiso para agregar articulos desde archivo', __LINE__, __FILE__);
        if($this->dec_permiso->has_permission('alm', 8))
        {
    ////////defino los parametros de la configuracion para la subida del archivo
            $config['upload_path'] = './uploads/';
            // $config['allowed_types'] = 'xls|xlsx|ods|csv|biff|pdf|html';//esta linea da conflictos en el servidor
            $config['allowed_types'] = '*';
            $config['file_name']= 'inv_nuevo00'.$this->session->userdata('user')['ID'].'0'.$this->model_alm_articulos->get_lastHistoryID();
            $config['overwrite']= true;
            $config['max_size'] = '2048';
    ////////defino los parametros de la configuracion para la subida del archivo
            $this->load->library('upload', $config);//llamo a la libreria y le paso la configuracion
            if( ! $this->upload->do_upload())//si ocurre un error en la subida...
            {
                $error = array('error' => $this->upload->display_errors());
                print_r($error);
                // echo(octal_permissions(fileperms($config['upload_path']));
                if(is_file($config['upload_path']))
                {
                    chmod($config['upload_path'], 0777); //Para cambiar el permiso de la carpeta en caso de error de permisologia
                }
                // $this->load->view('upload_form', $error);
            }
            else//si todo sube como debe
            {
                // return($this->upload->data()['full_path']);//retorno la direccion y nombre del archivo como string

                $file = $this->upload->data()['full_path'];
                $objPHPExcel = PHPExcel_IOFactory::load($file);//llamo la libreria de excel para cargar el archivo de excel
                //get only the Cell Collection
                $cell_collection = $objPHPExcel->getActiveSheet()->getCellCollection();//recorrere el archivo por celdas
                $highestColumm = $objPHPExcel->getActiveSheet()->getHighestDataColumn();
                $highestRow = $objPHPExcel->getActiveSheet()->getHighestDataRow();
                $lastCell = $highestColumm.$highestRow;
                //extract to a PHP readable array format
                $i=0;//auxiliar para contabilizar articulos
                $repeatedItems = array();
                $success = 1;
                $items = 0;//variable auxiliar que contabiliza la cantidad de articulos que se podra almacenar a la vez, antes de insertarlo
                $aux = array();
                foreach ($cell_collection as $cell) //para cada celda
                {
                    $column = $objPHPExcel->getActiveSheet()->getCell($cell)->getColumn();//columna
                    $row = $objPHPExcel->getActiveSheet()->getCell($cell)->getRow();//fila
                    $data_value = $objPHPExcel->getActiveSheet()->getCell($cell)->getValue();//dato en la columna-fila
                    
                    //header will/should be in row 1 only. of course this can be modified to suit your need.
                    // echo $i.'<br>';
                    if($row <= 2)//en el recorrido, aparto las primeras 2 filas
                    {
                        $header[$row][$column] = $data_value;
                    }
                    else//a partir de la 3 fila empiezan los datos de articulos y cantidades
                    {
                        $attr = $header[2][$column];
                        // $aux[$attr] = strtoupper($data_value);
                        // $aux[$row-3][$attr] = htmlentities(strtoupper($data_value));
                        // $aux[$row-3][$attr] = strtoupper($data_value);
                        $aux[$i][$attr] = strtoupper($data_value);
                        if($column==$highestColumm)//pregunto si llegue al final de la linea
                        {
                            if(!(array_key_exists('cod_articulo', $aux[$i]) || array_key_exists('descripcion', $aux[$i])) && $row==3)
                            {
                                $error['error'] = "El archivo no cumple con el formato adecuado para la incorporación de articulos al sistema.";
                                        die(json_encode($error));
                            }
                            if(!$this->model_alm_articulos->exist_articulo($aux[$i]))//pregunto si el articulo no existe o no esta en el sistema
                            {
                                //aqui hago insercion en la base de datos
                                $items++;//cuento un articulo mas al arreglo de articulos
                                if($items==100 || $cell == $lastCell)//si tengo 100 articulos en la variable, o si llegue al final del archivo
                                {
                                    // $success = $this->model_alm_articulos->add_articulo($aux);//insertar individualmente articulo por articulo en la base de datos
                                    $success = $this->model_alm_articulos->add_batchArticulos($aux);//insertar por grupo en la base de datos
                                    if(!$success)//en caso de error en la insercion
                                    {
                                        // $error['error'] = "Ocurri&oacute; un error agregando el art&iacute;culo de la linea: ".($row-1);
                                        $error['error'] = "Ocurri&oacute; un error agregando uno de los art&iacute;culos entre las lineas: ".(($row)-$i)." y ".($row).".";
                                        die(json_encode($error));
                                    }
                                    $aux = array();//reinicio el arreglo de articulos
                                    $items = 0;//reinicio el contador de articulos
                                }
                            }
                            else//si existe, lo agrego a una arreglo auxiliar de articulos repetidos
                            {//construyo con linea de archivo y descripcion del articulo, para referenciar que se encuentra repetido en el sistema
                                
                                $aux1['linea'] = ($row);
                                // $aux1['codigo'] = $aux['cod_articulo'];
                                $aux1['codigo'] = $aux[$i]['cod_articulo'];
                                // $aux1['descripcion'] = $aux['descripcion'];
                                $aux1['descripcion'] = $aux[$i]['descripcion'];
                                $repeatedItems[] = $aux1;
                            }
                            $i++;
                        }//fin de la ultima columna
                    }//fin del ifelse de filas mayores a 2
                }//aqui termina el foreach
                if(isset($repeatedItems) && !empty($repeatedItems))
                {
                    echo json_encode($repeatedItems);
                }
                else
                {
                    // echo $i;
                    $inserted['success']=$i;
                    // print_r($inserted);
                    echo json_encode($inserted);
                }
                // echo "<br> articulos repetidos <br>";
                // echo_pre($repeatedItems);
                // $jsonFile['ArtRepetidos'] = $repeatedItems;
                // echo_pre('Tabla: '.$header[1]['A']);
                // die_pre($aux, __LINE__, __FILE__);
                // die_pre();
                
                // if($this->model_alm_articulos->add_batchArticulos($aux))
                // {
                //     $this->session->set_flashdata('add_articulos','success');
                //     redirect(base_url().'/inventario');
                // }
                // else
                // {
                //     $this->session->set_flashdata('add_articulos','error');
                //     redirect(base_url().'/inventario');   
                // }
            }
        }
        else
        {
            $this->session->set_flashdata('permission', 'error');
            redirect('inicio');
        }
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
    public function hasPermissionBasicAB()
    {
        return ($this->session->userdata('user')['sys_rol']=='asistente_dep');
    }
    public function hasPermissionBasicA()
    {
        return ($this->session->userdata('user')['sys_rol']=='asistente_dep_alm');
    }
    public function hasPermissionBasicM()
    {
        return ($this->session->userdata('user')['sys_rol']=='asistente_dep_mnt');
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
    //////////cierres de inventario y reportes
    public function build_dtConfig()//crea la configuracion del dataTable, para hacer las interacciones del mismo, por el lado del servidor
    {
        // echo_pre($this->input->post('columnas'));
        $columns = $this->input->post('columnas');
        $config = array(
            'oLanguage' => array(),
            'bProcessing' => true,
            'lengthChange' => false,
            'searching' => false,
            'info' => false,
            'stateSave' => true,
            'bServerSide' => true,
            'pagingType' => 'full_numbers',
            'sServerMethod' => 'GET',
            'sAjaxSource' => base_url().'tablas/inventario/reportes',
            'bDeferRender' => true,
            // 'fnServerData' => 
            'iDisplayLength' => 10,
            'aLengthMenu' => array(array(10, 25, 50, -1), array(10, 25, 50, 'ALL')),
            'aaSorting' => array(array(0, 'desc')),
            'aColumns' => array(), 
            'columns' => array()
            );
        $oLanguage = array(
            'sProcessing' => 'Procesando...',
            'sLengthMenu' => 'Mostrar _MENU_ registros',
            'sZeroRecords' => 'No se encontraron resultados',
            'sInfo' => 'Muestra desde _START_ hasta _END_ de _TOTAL_ registros',
            'sInfoEmpty' => 'Muestra desde 0 hasta 0 de 0 registros',
            'sInfoFiltered' => '(filtrado de _MAX_ registros en total)',
            'sInfoPostFix' => '',
            'sLoadingRecords' => 'Cargando...',
            'sEmptyTable' => 'No se encontraron datos',
            'sSearch' => 'Buscar:',
            'sUrl'=> '',  
            'oPaginate'=> array(
                'sNext' => 'Siguiente',
                'sPrevious' => 'Anterior',
              'sLast' => '<i class="glyphicon glyphicon-step-forward" title="Último"  ></i>',
              'sFirst' => '<i class="glyphicon glyphicon-step-backward" title="Primero"  ></i>'
                )
            );
        $config['oLanguage'] = $oLanguage;
        $aColumns = array();
        $scolumns = array();
        foreach ($columns as $key => $value)
        {
            $aColumns[$key] = array();
            $scolumns[$key] = array('name' => $value);
            $aux = array(
                'bVisible' => true,
                'bSearchable' => true,
                'bSortable' => true);
            $aColumns[$key] = $aux;
        }
        $config['aColumns'] = $aColumns;
        $config['columns'] = $scolumns;
        echo json_encode($config);
    }

    public function build_report()
    {
        // $aColumns = json_decode($this->input->get_post('aColumns'));
        $tipoDeReporte = $this->input->get('tipoReporte');
        switch ($tipoDeReporte)
        {
            default:
                $columns = $this->input->get_post('sColumns');
                break;
        }
        // echo_pre($this->input->get_post('sSearch', true));
        $aColumns = preg_split("/[',']+/", $columns);
        // echo_pre($aColumns);
        $sTable = 'alm_articulo';

        $iDisplayStart = $this->input->get_post('iDisplayStart', true);
        $iDisplayLength = $this->input->get_post('iDisplayLength', true);
        $iSortCol_0 = $this->input->get_post('iSortCol_0', true);
        $iSortingCols = $this->input->get_post('iSortingCols', true);
        $sSearch = $this->input->get_post('sSearch', true);
        $sEcho = $this->input->get_post('sEcho', true);
        //paginacion
        if(isset($iDisplayStart) && $iDisplayLength != '-1')
        {
            $this->db->limit($this->db->escape_str($iDisplayLength), $this->db->escape_str($iDisplayStart));
        }
        //ordenamiento
        if(isset($iSortCol_0))
        {
            for($i=0; $i<intval($iSortingCols); $i++)
            {
                $iSortCol = $this->input->get_post('iSortCol_'.$i, true);
                $bSortable = $this->input->get_post('bSortable_'.intval($iSortCol), true);
                $sSortDir = $this->input->get_post('sSortDir_'.$i, true);
                
            
                if($bSortable == 'true')
                {
                    if($aColumns[intval($this->db->escape_str($iSortCol))]=='art_cod_desc')
                    {
                        $this->db->order_by('descripcion', $this->db->escape_str($sSortDir));
                        // $this->db->order_by('cod_articulo', $this->db->escape_str($sSortDir));
                    }
                    elseif($aColumns[intval($this->db->escape_str($iSortCol))]=='cantidad')
                    {
                        $this->db->order_by('entrada', $this->db->escape_str($sSortDir));
                        $this->db->order_by('salida', $this->db->escape_str($sSortDir));
                    }
                    else
                    {
                        if($aColumns[intval($this->db->escape_str($iSortCol))]=='movimiento2' || $aColumns[intval($this->db->escape_str($iSortCol))]=='movimiento')
                        {
                            // echo_pre($this->db->escape_str($sSortDir));
                            if($this->db->escape_str($sSortDir)=='asc')
                            {
                                $this->db->order_by('entrada', 'desc');
                            }
                            else
                            {
                                $this->db->order_by('salida', 'desc');
                            }
                            // $this->db->order_by('salida, entrada', $this->db->escape_str($sSortDir));
                            // $this->db->order_by('salida', $this->db->escape_str($sSortDir));
                        }
                        else
                        {
                            $this->db->order_by($aColumns[intval($this->db->escape_str($iSortCol))], $this->db->escape_str($sSortDir));
                        }
                    }
                }
            }
        }

        if(isset($sSearch) && !empty($sSearch))
        {
            for($i=0; $i<count($aColumns); $i++)
            {
                $bSearchable = $this->input->get_post('bSearchable_'.$i, true);
                    
                // Individual column filtering
                if(isset($bSearchable) && $bSearchable == 'true')
                {
                    if($aColumns[$i] =='art_cod_desc')
                    {
                        $this->db->or_like('cod_articulo', $this->db->escape_like_str($sSearch));
                        $this->db->or_like('descripcion', $this->db->escape_like_str($sSearch));
                    }
                    else
                    {
                        if(strpos('salida', $sSearch) !== false)
                        {
                            $this->db->or_like('salida > 0');
                        }
                        if (strpos('entrada', $sSearch) !== false)
                        {
                            $this->db->or_like('entrada > 0');
                        }
                            if($aColumns[$i] =='movimiento2')
                            {
                                $this->db->or_like('cod_articulo', $this->db->escape_like_str($sSearch));
                            }
                            else
                            {
                                $this->db->or_like($aColumns[$i], $this->db->escape_like_str($sSearch));
                            }
                    }
                }
            }
        }

//////aqui van las consultas a los inputs externos al datatable
        if($this->input->get('fecha'))
        {
            $rang = preg_split("/[' al ']+/", $this->input->get('fecha'));
            $mes = array('january', 'february', 'march', 'april', 'may', 'june', 'july', 'august', 'september', 'october', 'november', 'december');
            $date1 = preg_split("/['\/']+/", $rang[0]);
            $stringA = $date1[0].' '.$mes[((int)$date1[1])-1].' '.$date1[2].'00:00:00';

            $date2 = preg_split("/['\/']+/", $rang[1]);
            $stringB = $date2[0].' '.$mes[((int)$date2[1])-1].' '.$date2[2].'23:59:59';
            // if($tipoDeReporte=='')
            // {
                $this->db->where('historial.TIME >=', date('Y-m-d H:i:s',strtotime($stringA)));
                $this->db->where('historial.TIME <=', date('Y-m-d H:i:s',strtotime($stringB)));
            // }
            // else
            // {
            //     if($tipoDeReporte=='xDependencia')
            //     {
            //         $this->db->where('historial.TIME >=', date('Y-m-d H:i:s',strtotime($stringA)));
            //         $this->db->where('historial.TIME <=', date('Y-m-d H:i:s',strtotime($stringB)));
            //     }
            //     else
            //     {

            //     }
            // }
        }
        if($this->input->get('move'))//mostrar por movimientos
        {
            $move = preg_split("/[',']+/", $this->input->get('move'));
            foreach ($move as $key => $value)
            {
                if($value=='Entradas')
                {
                    // $move[$key] = 'alm_historial_a.entrada';
                    $this->db->or_where('historial.entrada > 0');
                }
                if($value=='Salidas')
                {
                    // $move[$key] = 'alm_historial_a.salida';
                    $this->db->or_where('historial.salida > 0');
                }
            }
        }
//////FIN de las consultas a los inputs externos al datatable
//////Consultas para tipo de reporte
        switch ($tipoDeReporte)
        {
            case 'xDependencia':
                $flag = 'xDependencia';
                $this->db->select('SQL_CALC_FOUND_ROWS cod_articulo, descripcion, unidad, dependen, cant_aprobada AS despachado, alm_despacha.fecha_ej AS fechaA, alm_solicitud.nr_solicitud AS solicitud, historial.TIME AS fecha_desp, entrada, salida', false);
                $statusSol = array('enviado', 'completado');
                $this->db->where_in('alm_solicitud.status', $statusSol);
                $this->db->join('alm_historial_s AS alm_genera', 'alm_genera.nr_solicitud=alm_solicitud.nr_solicitud AND alm_genera.status_ej="carrito"', 'inner');
                $this->db->join('alm_historial_s AS alm_despacha', 'alm_despacha.nr_solicitud=alm_solicitud.nr_solicitud AND (alm_despacha.status_ej="completado" OR alm_despacha.status_ej="retirado")', 'inner');
                $this->db->join('alm_art_en_solicitud AS alm_contiene', 'alm_contiene.nr_solicitud = alm_solicitud.nr_solicitud AND alm_contiene.estado_articulo="activo" AND alm_contiene.cant_aprobada > 0');
                $this->db->join('dec_usuario', 'dec_usuario.id_usuario=alm_genera.usuario_ej');
                $this->db->join('dec_dependencia', 'dec_dependencia.id_dependencia=dec_usuario.id_dependencia', 'inner');
                $this->db->join('alm_articulo', 'alm_articulo.ID=alm_contiene.id_articulo');
                $this->db->join('alm_genera_hist_a', 'alm_genera_hist_a.id_articulo=alm_articulo.cod_articulo');
                $this->db->join('alm_historial_a AS historial', 'historial.id_historial_a = alm_genera_hist_a.id_historial_a AND historial.salida > 0 AND historial.TIME = alm_despacha.fecha_ej');
                $this->db->order_by('alm_articulo.descripcion, alm_solicitud.nr_solicitud');
                $sTable = 'alm_solicitud';
                break;
            case 'xArticulo':
                $flag = 'xArticulo';
                $this->db->select('SQL_CALC_FOUND_ROWS *, historial.TIME AS fecha_desp', false);
                $this->db->join('alm_genera_hist_a', 'alm_genera_hist_a.id_articulo = alm_articulo.cod_articulo');
                $this->db->join('alm_historial_a AS historial', 'alm_genera_hist_a.id_historial_a = historial.id_historial_a');
                $this->db->order_by('cod_articulo, entrada');
                break;
            case 'xMovimiento':
                $flag = 'xMovimiento';
                $this->db->select('SQL_CALC_FOUND_ROWS *, historial.ID AS id, alm_genera_hist_a.TIME AS fecha_desp', false);
                $this->db->join('alm_genera_hist_a', 'alm_genera_hist_a.id_articulo = alm_articulo.cod_articulo');
                $this->db->join('alm_historial_a AS historial', 'historial.id_historial_a = alm_genera_hist_a.id_historial_a');
                $this->db->order_by('cod_articulo, entrada');
                break;
            default:
                $flag = '';
                $this->db->select('SQL_CALC_FOUND_ROWS *, SUM(historial.entrada) as entradas, SUM(historial.salida) as salidas, usados + nuevos + reserv AS exist, MAX(historial.TIME) as fechaU', false);
                $this->db->join('alm_genera_hist_a', 'alm_genera_hist_a.id_articulo = alm_articulo.cod_articulo');
                if(in_array('salidas', $aColumns) && !in_array('entradas', $aColumns))
                {
                    $this->db->join('alm_historial_a AS historial', 'alm_genera_hist_a.id_historial_a = historial.id_historial_a AND historial.salida > 0');
                }
                else
                {
                    if(in_array('entradas', $aColumns) && !in_array('salidas', $aColumns))
                    {
                        $this->db->join('alm_historial_a AS historial', 'alm_genera_hist_a.id_historial_a = historial.id_historial_a AND historial.entrada > 0');
                    }
                    else
                    {
                        $this->db->join('alm_historial_a AS historial', 'alm_genera_hist_a.id_historial_a = historial.id_historial_a');
                    }
                }
                // $this->db->join('alm_historial_a AS alm_salidas', 'alm_genera_hist_a.id_historial_a = alm_salidas.id_historial_a AND alm_salidas.salida > 0');
                // $this->db->join('alm_historial_a AS alm_entradas', 'alm_genera_hist_a.id_historial_a = alm_entradas.id_historial_a AND alm_entradas.entrada > 0');
                $this->db->group_by('cod_articulo');

                break;
        }
//////FIN de Consultas para tipo de reporte

        $rResult = $this->db->get($sTable);
        $this->db->select('FOUND_ROWS() AS found_rows');

        $iFilteredTotal = $this->db->get()->row()->found_rows;

        $iTotal = $this->db->count_all($sTable);
                    
        // Output
        $output = array(
            'sEcho' => intval($sEcho),
            'iTotalRecords' => $iTotal,
            'iTotalDisplayRecords' => $iFilteredTotal,
            'aaData' => array()
        );
//        die_pre($rResult->result_array());
        foreach($rResult->result_array() as $aRow)//construccion a pie de los campos a mostrar en la lista, cada $row[] es una fila de la lista, y lo que se le asigna en el orden es cada columna
        {
            $row = array();
            foreach($aColumns as $col)
            {
                if(isset($flag) && $flag == 'xDependencia')
                {
                    if($col == 'dependen')
                    {
                        $row[] = 'Departamento: '.$aRow[$col];
                    }
                    else
                    {
                        $row[] = $aRow[$col];
                    }
                }
                if(isset($flag) && $flag == 'xArticulo')
                {
                    if($col == 'art_cod_desc')
                    {
                        $row[] = 'Articulo: '.$aRow['descripcion'].' código: '.$aRow['cod_articulo'];
                    }
                    else
                    {
                        if($col == 'movimiento')
                        {
                            if($aRow['entrada'] > 0)
                            {
                                $row[] = 'Entrada a inventario';
                            }
                            else
                            {
                                $row[] = 'Salida de inventario';
                            }
                        }
                        else
                        {
                            if($col == 'cantidad')
                            {
                                if($aRow['entrada'] > 0)
                                {
                                    $row[] = $aRow['entrada'];
                                }
                                else
                                {
                                    $row[] = $aRow['salida'];
                                }
                            }
                            else
                            {
                                if($col == 'nuevo')
                                {
                                    if($aRow['nuevo']== 1)
                                    {
                                        $row[] = 'nuevo';
                                    }
                                    else
                                    {
                                        $row[] = 'usado';
                                    }
                                }
                                else
                                {
                                    $row[] = $aRow[$col];
                                }
                            }
                        }
                    }
                }
                if(isset($flag) && $flag == 'xMovimiento')
                {
                    if($col == 'movimiento2')
                    {
                        if($aRow['entrada'] > 0)
                        {
                            $row[] = 'Entrada a inventario';
                        }
                        else
                        {
                            $row[] = 'Salida de inventario';
                        }
                    }
                    else
                    {
                        if($col == 'cantidad')
                        {
                            if($aRow['entrada'] > 0)
                            {
                                $row[] = $aRow['entrada'];
                            }
                            else
                            {
                                $row[] = $aRow['salida'];
                            }
                        }
                        else
                        {
                            if($col == 'nuevo')
                            {
                                if($aRow['nuevo']== 1)
                                {
                                    $row[] = 'nuevo';
                                }
                                else
                                {
                                    $row[] = 'usado';
                                }
                            }
                            else
                            {
                                $row[] = $aRow[$col];
                            }
                        }
                    }
                }
                if($flag == '')
                {
                    $row[] = $aRow[$col];
                }
            }
            $output['aaData'][] = $row;
        }
        echo json_encode($output);

    }
     public function test()
    {
              // Load all views as normal
            $this->load->view('reporte_pdf_1');
            // Get output html
            $html = $this->output->get_output();
            // Load library
            $this->load->library('dompdf_gen');

            // Convert to PDF
            $this->dompdf->load_html(utf8_decode($html));
            $this->dompdf->render();
            $this->dompdf->stream("asignaciones.pdf", array('Attachment' => 0));
    }
    
    public function print_dataTable()
    {
        
        $data = json_decode($this->input->get_post('columnas'),true);
        $sTable = 'alm_articulo';
        $tipoDeReporte = $data['tipo'];
        $orden = $data['orderState'];
        $columns = $data['columnas'];
        $buscador = $this->input->get_post('search');
//                echo_pre($data);
//consultas adicionales
        if(!empty($buscador))
        {
            for($i=0; $i<count($columns); $i++)
            {
                $bSearchable = $data['noBuscables'];
//                echo_pre($bSearchable);
                // Individual column filtering
                if(!in_array($i,$bSearchable))
                {
                    if($columns[$i]['sName'] =='art_cod_desc')
                    {
                        $this->db->or_like('descripcion', $this->db->escape_like_str($buscador));
                        $this->db->or_like('cod_articulo', $this->db->escape_like_str($buscador));
                    }
                    else
                    {
                        if(strpos('salida', $buscador) !== false)
                        {
                            $this->db->or_like('salida > 0');
                        }
                        if (strpos('entrada', $buscador) !== false)
                        {
                            $this->db->or_like('entrada > 0');
                        }
                            if($columns[$i] =='movimiento2')
                            {
                                $this->db->or_like('cod_articulo', $this->db->escape_like_str($buscador));
                            }
                            else
                            {
                                $this->db->or_like($columns[$i]['sName'], $this->db->escape_like_str($buscador));
                            }
                    }
                }
            }
        }
        
        if(!empty($data['fecha']))
        {
            $rang = preg_split("/[' al ']+/", $data['fecha']);
            $mes = array('january', 'february', 'march', 'april', 'may', 'june', 'july', 'august', 'september', 'october', 'november', 'december');
            $date1 = preg_split("/['\/']+/", $rang[0]);
            $stringA = $date1[0].' '.$mes[((int)$date1[1])-1].' '.$date1[2].'00:00:00';

            $date2 = preg_split("/['\/']+/", $rang[1]);
            $stringB = $date2[0].' '.$mes[((int)$date2[1])-1].' '.$date2[2].'23:59:59';
            $this->db->where('historial.TIME >=', date('Y-m-d H:i:s',strtotime($stringA)));
            $this->db->where('historial.TIME <=', date('Y-m-d H:i:s',strtotime($stringB)));
        }
        if(!empty($data['move']))//mostrar por movimientos
        {
//            $move = preg_split("/[',']+/", $this->input->get_post('move'));
             $move = ($data['move']);
//            die_pre($move);
            foreach ($move as $key => $value)
            {
                if($value=='Entradas')
                {
                    $this->db->or_where('historial.entrada > 0');
                }
                if($value=='Salidas')
                {
                    $this->db->or_where('historial.salida > 0');
                }
            }
        }
////FIN de consultas adicionales
////////Consultas para tipo de reporte

        switch ($tipoDeReporte)
        {
            case 'xDependencia':
////                $file_to_save = 'uploads/reportes/dependencias'.date('Y-m-d',time()).'.pdf';
                $view['title']='Reporte por departamento';
                $view['tipo']='dependencia';
                $flag = 'xDependencia';
                $this->db->select('SQL_CALC_FOUND_ROWS cod_articulo, descripcion, unidad, dependen, cant_aprobada AS despachado, alm_despacha.fecha_ej AS fechaA, alm_solicitud.nr_solicitud AS solicitud, historial.TIME AS fecha_desp, entrada, salida', false);
                $statusSol = array('enviado', 'completado');
                $this->db->where_in('alm_solicitud.status', $statusSol);
                $this->db->join('alm_historial_s AS alm_genera', 'alm_genera.nr_solicitud=alm_solicitud.nr_solicitud AND alm_genera.status_ej="carrito"', 'inner');
                $this->db->join('alm_historial_s AS alm_despacha', 'alm_despacha.nr_solicitud=alm_solicitud.nr_solicitud AND (alm_despacha.status_ej="completado" OR alm_despacha.status_ej="retirado")', 'inner');
                $this->db->join('alm_art_en_solicitud AS alm_contiene', 'alm_contiene.nr_solicitud = alm_solicitud.nr_solicitud AND alm_contiene.estado_articulo="activo" AND alm_contiene.cant_aprobada > 0');
                $this->db->join('dec_usuario', 'dec_usuario.id_usuario=alm_genera.usuario_ej');
                $this->db->join('dec_dependencia', 'dec_dependencia.id_dependencia=dec_usuario.id_dependencia', 'inner');
                $this->db->join('alm_articulo', 'alm_articulo.ID=alm_contiene.id_articulo');
                $this->db->join('alm_genera_hist_a', 'alm_genera_hist_a.id_articulo=alm_articulo.cod_articulo');
                $this->db->join('alm_historial_a AS historial', 'historial.id_historial_a = alm_genera_hist_a.id_historial_a AND historial.salida > 0 AND historial.TIME = alm_despacha.fecha_ej');
                if(!isset($orden))
                {
                    $this->db->order_by('alm_articulo.descripcion, alm_solicitud.nr_solicitud');
                }
                $sTable = 'alm_solicitud';
                break;
            case 'xArticulo':
//                $file_to_save = 'uploads/reportes/articulos'.date('Y-m-d',time()).'.pdf';
                $view['title']='Reporte por artículo';
                $view['tipo']='articulo';
                $flag = 'xArticulo';
                $this->db->select('SQL_CALC_FOUND_ROWS *, historial.TIME AS fecha_desp', false);
                $this->db->join('alm_genera_hist_a', 'alm_genera_hist_a.id_articulo = alm_articulo.cod_articulo');
                $this->db->join('alm_historial_a AS historial', 'alm_genera_hist_a.id_historial_a = historial.id_historial_a');
                if(!isset($orden))
                {
                    $this->db->order_by('cod_articulo, entrada');
                }
                break;
            case 'xMovimiento':
////                $file_to_save = 'uploads/reportes/movimiento'.date('Y-m-d',time()).'.pdf';
                $view['title']='Reporte por movimiento';
                $view['tipo']='movimiento';
                $flag = 'xMovimiento';
                // $this->db->select('SQL_CALC_FOUND_ROWS alm_genera_hist_a.TIME AS fecha_desp, cod_articulo, descripcion, entrada, salida, nuevo, observacion, historial.ID AS id', false);
                $this->db->select('SQL_CALC_FOUND_ROWS *, alm_genera_hist_a.TIME AS fecha_desp, historial.ID AS id', false);
                $this->db->join('alm_genera_hist_a', 'alm_genera_hist_a.id_articulo = alm_articulo.cod_articulo');
                $this->db->join('alm_historial_a AS historial', 'historial.id_historial_a = alm_genera_hist_a.id_historial_a');
                if(!isset($orden))
                {
                    $this->db->order_by('cod_articulo, entrada');
                }
                break;
            default:
//                $file_to_save = 'uploads/reportes/general'.date('Y-m-d',time()).'.pdf';
                $view['title']='Reporte estatus de Almacén';
                $view['tipo']='predeterminado';
                $flag = '';
                $this->db->select('SQL_CALC_FOUND_ROWS *, SUM(historial.entrada) as entradas, SUM(historial.salida) as salidas, usados + nuevos + reserv AS exist, MAX(historial.TIME) as fechaU', false);
                $this->db->join('alm_genera_hist_a', 'alm_genera_hist_a.id_articulo = alm_articulo.cod_articulo');
                if (in_array('salidas', $columns) && !in_array('entradas', $columns)) {
                    $this->db->join('alm_historial_a AS historial', 'alm_genera_hist_a.id_historial_a = historial.id_historial_a AND historial.salida > 0');
                } else {
                    if (in_array('entradas', $columns) && !in_array('salidas', $columns)) {
                        $this->db->join('alm_historial_a AS historial', 'alm_genera_hist_a.id_historial_a = historial.id_historial_a AND historial.entrada > 0');
                    } else {
                        $this->db->join('alm_historial_a AS historial', 'alm_genera_hist_a.id_historial_a = historial.id_historial_a');
                    }
                }
                // $this->db->join('alm_historial_a AS alm_salidas', 'alm_genera_hist_a.id_historial_a = alm_salidas.id_historial_a AND alm_salidas.salida > 0');
                // $this->db->join('alm_historial_a AS alm_entradas', 'alm_genera_hist_a.id_historial_a = alm_entradas.id_historial_a AND alm_entradas.entrada > 0');
                $this->db->group_by('cod_articulo');
                break;
        }
////////FIN de Consultas para tipo de reporte
        if(!empty($orden))
        {
//         die_pre($orden);
            foreach ($orden as $key => $value)
            {
                $column = $columns[$value[0]]['sName'];
//                die_pre($column);
                if($column=='art_cod_desc'){
                    $column = 'descripcion';
                }
                if($column=='movimiento'){
                    $column = 'entrada';
                }
                if($column=='movimiento2'){
                    $column = 'entrada';
                }
                $order = $value[1]; 
                if($column=='cantidad'){
                    $this->db->order_by('entrada',$order);
                    $this->db->order_by('salida',$order);
//                    $column = 'entrada,salida';
//                    die_pre($column);
                }
                  
//                 echo_pre ('('.$column.', ');
//                 echo_pre( $order.')');
                elseif($column != 'entrada'){
                    $this->db->order_by($column, $order);
                }else{
                    if ($order == 'asc'){
                        $this->db->order_by($column, 'desc');
                    }else{
                        $this->db->order_by($column, 'asc');
                    }
                }
            }
        }
        $rResult = $this->db->get($sTable)->result_array();
//        die_pre($rResult);
        switch ($tipoDeReporte)
        {
            case 'xArticulo':
                foreach ($rResult as $info => $i){
                    foreach ($i as $in => $z){
                        if($in == 'cod_articulo'){
                            $cod[] = $z;
                        }
                        if($in == 'descripcion'){
                            $desc[] = $z;
                        }
                        if($in == 'entrada'){
                            if($z > 0){
                               $movimiento[] = 'Entrada a inventario';
                               $cantidad[] = $z;
                            }else{
                               $movimiento[] = 'Salida de inventario';
                               $cantidad[] = $rResult[$info]['salida'];
                            }
                        }
                        if($in == 'nuevo'){
                            if($z == 1){
                                $tmp[] = 'nuevo';
                            }else{
                                $tmp[] = 'usado';
                            }
                        }
                    }
                    $rResult[$info]['nuevo'] = $tmp[$info];
                    $rResult[$info]['movimiento'] = $movimiento[$info];
                    $rResult[$info]['cantidad'] = $cantidad[$info];
                    $rResult[$info]['art_cod_desc'] = $desc[$info].' Código: '.$cod[$info];
                }
//                echo_pre($rResult);
//                echo_pre($cod);
            break;
            case 'xMovimiento':
                foreach ($rResult as $info => $i){
                    foreach ($i as $in => $z){
                        if($in == 'entrada'){
                            if($z > 0){
//                                echo_pre($rResult[$info]['entrada']);
                               $movimiento[] = 'Entrada a inventario';
                               $cantidad[] = $z;
                            }else{
//                                echo_pre($rResult[$info]['salida']);
                               $movimiento[] = 'Salida de inventario';
                               $cantidad[] = $rResult[$info]['salida'];
                            }
                        }
                        if($in == 'nuevo'){
                            if($z == 1){
                                $tmp[] = 'nuevo';
                            }else{
                                $tmp[] = 'usado';
                            }
                        }
                    }
                    $rResult[$info]['nuevo'] = $tmp[$info];
                    $rResult[$info]['cantidad'] = $cantidad[$info];
                    $rResult[$info]['movimiento2'] = $movimiento[$info];
                }
//                die_pre($rResult);
            break; 
            case '':
//                die_pre($columns);
                foreach ($columns as $c => $valor){
                    foreach ($valor as $r => $v){
                        if ($r == 'sName'){
                            switch ($v){
                                case 'cod_articulo':
                                    $column = (object)array('sName' =>$v,'column'=>'Código');
                                    $columns[$c]=$column;
                                break;
                                case 'descripcion':
                                    $column = (object)array('sName' =>$v,'column'=>'Descripción');
                                    $columns[$c]=$column;
                                break;
                                case 'entradas':
                                    $column = (object)array('sName' =>$v,'column'=>'Entradas');
                                    $columns[$c]=$column;
                                break;
                                case 'exist':
                                    $column = (object)array('sName' =>$v,'column'=>'Existencia');
                                    $columns[$c]=$column;
                                break;
                                case 'salidas':
                                    $column = (object)array('sName' =>$v,'column'=>'Salidas');
                                    $columns[$c]=$column;
                                break;
                                case 'fechaU':
                                    $column = (object)array('sName' =>$v,'column'=>'Último movimiento');
                                    $columns[$c]=$column;
                                break;
                                case 'unidad':
                                    $column = (object)array('sName' =>$v,'column'=>'Unidad');
                                    $columns[$c]=$column;
                                break;
                            }
                        }
                    }
                }
//                die_pre($columns);
            break;
        }
        foreach ($columns as $a => $value){
            foreach ($value as $s =>$i) {
                if($s=='column'){
                    $head_table[] = $i;
                }else{
                    $table_column[] = $i;
                }   
            } 
        }
        $view['table_head'] = $head_table;
        $view['table_column'] = $table_column;
        $view['tipo'] = $tipoDeReporte;
        $view['tabla']=$rResult;
        
        // Se carga la libreria fpdf
        $this->load->library('fpdf');
        /*
       // Creacion del PDF
 
    /*
     * Se crea un objeto de la clase Pdf, recuerda que la clase Pdf
     * heredó todos las variables y métodos de fpdf
     */
    $this->pdf = new PDF('P','mm','letter');
    // Agregamos una página
    $this->pdf->AddPage();
    $this->pdf->SetDisplayMode(100,'default');
    // Define el alias para el número de página que se imprimirá en el pie
    $this->pdf->AliasNbPages();
 
    /* Se define el titulo, márgenes izquierdo, derecho y
     * el color de relleno predeterminado
     */
    $this->pdf->SetTitle("Reporte Inventario");
//    $this->pdf->SetLeftMargin(10);
//    $this->pdf->SetRightMargin(10);
    $this->pdf->SetMargins(8, 8 , 8); 
//    $this->pdf->SetFillColor(200,200,200);
    #Establecemos el margen inferior: 
    $this->pdf->SetAutoPageBreak(true,15); 
    $titulo = array('1' => $view['title']);
//    die_pre($titles);
    // Se define el formato de fuente: Arial, negritas, tamaño 9
//    $this->pdf->SetFont('Arial', '', 6);
    /*
     * TITULOS DE COLUMNAS
     *
     * $this->pdf->Cell(Ancho, Alto,texto,borde,posición,alineación,relleno);
     */
    $titles = array();
//    $numItems = count($head_table);
//    if($tipoDeReporte == ''){
    $this->pdf->Tabla($head_table,$rResult,$table_column,$titulo,$tipoDeReporte);
//        foreach ($head_table as $k =>$val){
//            if($k == 0){
//                $w = strlen($val)+14;
//                $this->pdf->Cell(strlen($val)+14,7,utf8_decode($val),'TBL',0,'C','6');
//            }elseif($k == count($head_table)-1){
//                $this->pdf->Cell(50,7,utf8_decode($val),'TBLR',0,'C','6');
//            }else{
//                $this->pdf->Cell(40,7,utf8_decode($val),'TBLR',0,'C','6');
//            }
//        }
//        $this->pdf->Ln(7);
     /*
     * Se manda el pdf al navegador
     *
     * $this->pdf->Output(nombredelarchivo, destino);
     *
     * I = Muestra el pdf en el navegador
     * D = Envia el pdf para descarga
     *
     */
    $this->pdf->Output("reporte.pdf", 'I');
//        die_pre($head_table);
//         echo_pre($rResult);
//        ini_set("memory_limit","1024M");
////        set_time_limit(1000);
//        ini_set('max_execution_time', 1300);
//        // Load all views as normal
//        $this->load->view('reportes(j)_pdf',$view);
//         
//        // Get output html
//        $html = $this->output->get_output();
//             
//        // Load library
//        $this->load->library('dompdf_gen');
////die_pre($html);
//        $this->dompdf->set_paper('letter', 'portrait');
//        // Convert to PDF
//        $this->dompdf->load_html(utf8_decode($html));
//        $this->dompdf->render();
//        $this->dompdf->stream("reporte.pdf", array('Attachment' => 0));
    }

    public function test_sql()
    {
        $header = $this->dec_permiso->load_permissionsView();
        $header['title'] = 'Prueba de SQL';
        $this->load->view('template/header', $header);
        
        // $this->db->where_not_in('alm_historial_s.status_ej', $status_ej);
        // $this->db->where('alm_historial_s.status_ej', 'carrito');//solo para traer a quien creo la solicitud
        // $this->db->where('alm_genera.status_ej', 'carrito');//solo para traer a quien creo la solicitud
        // $this->db->select('SQL_CALC_FOUND_ROWS *, SUM(alm_historial_a.entrada) as entradas, SUM(alm_historial_a.salida) as salidas, usados + nuevos + reserv AS exist, MAX(alm_historial_a.TIME) as fecha', false);
////////PARA REPORTE POR ARTICULOS CON MOVIMIENTOS EN INVENTARIO (LISTO)
        $this->db->select('SQL_CALC_FOUND_ROWS *, alm_historial_a.TIME AS fecha_desp', false);
        $this->db->join('alm_genera_hist_a', 'alm_genera_hist_a.id_articulo = alm_articulo.cod_articulo');
        $this->db->join('alm_historial_a', 'alm_genera_hist_a.id_historial_a = alm_historial_a.id_historial_a');
        $this->db->order_by('cod_articulo, entrada');
        $rResult = $this->db->get('alm_articulo');
////////FIN DE -PARA REPORTE POR ARTICULOS CON MOVIMIENTOS EN INVENTARIO

////////PARA REPORTE POR DEPENDENCIA (Hay que hacer Pruebas, pero LISTO)
        // $this->db->select('SQL_CALC_FOUND_ROWS *, cant_aprobada AS despachado, historial.TIME AS fechaB', false);
        // $this->db->select('SQL_CALC_FOUND_ROWS cod_articulo, descripcion, dependen, cant_aprobada AS Despachado, alm_despacha.fecha_ej AS fechaA, alm_solicitud.nr_solicitud, historial.TIME AS fechaB', false);
        // $statusSol = array('enviado', 'completado');
        // $this->db->where_in('alm_solicitud.status', $statusSol);
        // $this->db->join('alm_historial_s AS alm_genera', 'alm_genera.nr_solicitud=alm_solicitud.nr_solicitud AND alm_genera.status_ej="carrito"', 'inner');
        // $this->db->join('alm_historial_s AS alm_despacha', 'alm_despacha.nr_solicitud=alm_solicitud.nr_solicitud AND (alm_despacha.status_ej="completado" OR alm_despacha.status_ej="retirado")', 'inner');
        // $this->db->join('alm_art_en_solicitud AS alm_contiene', 'alm_contiene.nr_solicitud = alm_solicitud.nr_solicitud AND alm_contiene.estado_articulo="activo" AND alm_contiene.cant_aprobada > 0');
        // $this->db->join('dec_usuario', 'dec_usuario.id_usuario=alm_genera.usuario_ej');
        // $this->db->join('dec_dependencia', 'dec_dependencia.id_dependencia=dec_usuario.id_dependencia', 'inner');
        // $this->db->join('alm_articulo', 'alm_articulo.ID=alm_contiene.id_articulo');
        // $this->db->join('alm_genera_hist_a', 'alm_genera_hist_a.id_articulo=alm_articulo.cod_articulo');
        // $this->db->join('alm_historial_a AS historial', 'historial.id_historial_a = alm_genera_hist_a.id_historial_a AND historial.salida > 0 AND historial.TIME = alm_despacha.fecha_ej');
        // $this->db->order_by('alm_articulo.descripcion, alm_solicitud.nr_solicitud');
        // $rResult = $this->db->get('alm_solicitud');
////////FIN DE -PARA REPORTE POR DEPENDENCIA
////////PARA REPORTE POR MOVIMIENTO DE HISTORIAL DE INVENTARIO (Para probar)
        // $this->db->select('SQL_CALC_FOUND_ROWS *, alm_historial_a.ID AS id, alm_genera_hist_a.TIME AS tiempo', false);
        // $this->db->join('alm_genera_hist_a', 'alm_genera_hist_a.id_articulo = alm_articulo.cod_articulo');
        // $this->db->join('alm_historial_a', 'alm_historial_a.id_historial_a = alm_genera_hist_a.id_historial_a');
        // $this->db->order_by('cod_articulo, entrada');
        // $rResult = $this->db->get('alm_articulo');
////////FIN DE -PARA REPORTE POR MOVIMIENTO DE HISTORIAL DE INVENTARIO
        echo_pre($rResult->result_array());
        echo_pre($this->db->last_query());
        // echo_pre($this->model_alm_solicitudes->get_solHistory('000000118'));
        $this->load->view('template/footer');

    }
    public function opciones_cierres()//para cargar la vista de los reportes y cierres
    {
        if($this->session->userdata('user'))//valida que haya una session iniciada
        {
            if($this->dec_permiso->has_permission('alm', 5))//($this->dec_permiso->has_permission('alm', '8'))//8 valida que tenga el permiso para revisar reportes y cierres
            {


                $view = $this->get_cierres();
                // die_pre($view['actDeInicio'], __LINE__, __FILE__);

                $header = $this->dec_permiso->load_permissionsView();
                $header['title'] = 'Reportes Y Cierres';
                $this->load->view('template/header', $header);
                $this->load->view('reportesCierres', $view);
                $this->load->view('template/footer');
            }
            else
            {
                $this->session->set_flashdata('permission', 'error');
                redirect('inicio');
            }
        }
        else
        {
            $header['title'] = 'Error de Acceso';
            $this->load->view('template/erroracc',$header);
        }
    }
    public function get_cierres()//para traer un arreglo de cierres de inventario del servidor de la carpeta "uploads"
    {
        if($this->session->userdata('user'))//valida que haya una session iniciada
        {
            if($this->dec_permiso->has_permission('alm', 5))//($this->dec_permiso->has_permission('alm', '8'))//8 valida que tenga el permiso para revisar reportes y cierres
            {
                $this->load->helper('directory');
                $aux['actDeIni']="
                <div class='form-group'>
                    <label class='col-sm-3 control-label text-center'>Acta de inicio</label>
                    <div class='col-sm-9'>
                        <select id='actDeIni' class='form-control' name='lista_deactDeInicio' onchange='load(value)'>";
                $aux['actDeIni']=$aux['actDeIni']."<option value='' selected >--SELECCIONE--</option>";
                foreach (directory_map('./uploads/cierres') as $file)
                {
                    $HN = str_replace('.pdf', '', $file);//HN = Human Name, nombre humano de interfaz
                    $aux['actDeIni']=$aux['actDeIni']."<option value = '".base_url()."uploads/cierres/".$file."#zoom=page-width'>".$HN."</option>";
                }
                $aux['actDeIni']=$aux['actDeIni']."</select></div></div>";
                return $aux;
            }
            else
            {
                $this->session->set_flashdata('permission', 'error');
                redirect('inicio');
            }
        }
        else
        {
            $header['title'] = 'Error de Acceso';
            $this->load->view('template/erroracc',$header);
        }
    }

    public function migrate()//migracion para version del 21/07/2016
    {
        if($this->session->userdata('user')&& ($this->session->userdata('user')['id_usuario']=='18781981' || $this->session->userdata('user')['id_usuario']=='14713134'))
        {
            $this->model_alm_articulos->rename_oldVersionTables();
            $this->model_alm_articulos->create_newVersionTables();
            $this->model_alm_articulos->migrate_ver1point3();
            // $this->model_alm_articulos->delete_oldVersionTables();
            die_pre("Listo!", __LINE__, __FILE__);
        }
    }

    public function alterDB($fecha)
    {
        // die_pre($fecha);
        if($this->session->userdata('user'))//valida que haya una session iniciada
        {
            if($this->session->userdata('user')['id_usuario'] == '18781981' || $this->session->userdata('user')['id_usuario']=='14713134')
            {
                $this->model_alm_articulos->alterarAlmacen($fecha);
                echo_pre("Listo!", __LINE__, __FILE__);
                $this->session->set_flashdata('mod_DB', 'success');
                redirect('inicio');
            }
            else
            {
                $this->session->set_flashdata('permission', 'error');
                redirect('inicio');
            }
        }
        else
        {
            $header['title'] = 'Error de Acceso';
            $this->load->view('template/erroracc',$header);
        }
    }
//////Sub_modulo de cierre de inventario
    public function form_excelDL()
    {
        $objPHPExcel = new PHPExcel();
        $objPHPExcel->setActiveSheetIndex(0);
        $rowCount = 2;
        $array = $this->model_alm_articulos->get_allArticulos();
        $objPHPExcel->getActiveSheet()->SetCellValue('A1', 'Codigo de ubicacion');
        $objPHPExcel->getActiveSheet()->SetCellValue('B1', 'Codigo del articulo');
        $objPHPExcel->getActiveSheet()->SetCellValue('C1', 'Descripción');
        $objPHPExcel->getActiveSheet()->SetCellValue('D1', 'Cantidad en existencia');
        foreach ($array as $key => $row)
        {
            $objPHPExcel->getActiveSheet()->SetCellValue('A'.$rowCount, $row['cod_ubicacion']);
            $objPHPExcel->getActiveSheet()->SetCellValue('B'.$rowCount, $row['cod_articulo']);
            $objPHPExcel->getActiveSheet()->SetCellValue('C'.$rowCount, $row['descripcion']);
            $objPHPExcel->getActiveSheet()->SetCellValue('D'.$rowCount, '');
            $rowCount++;
        }
        $objPHPExcel->getActiveSheet()->getColumnDimension("A")->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension("B")->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension("C")->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension("D")->setAutoSize(true);
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        ob_end_clean();
        $objWriter->setOffice2003Compatibility(true);
        header('Content-type: application/vnd.ms-excel');
        header('Content-Disposition: attachment; filename="ExistDeArticulos.xlsx"');
        header ('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT');
        $objWriter->save("php://output");

    }
    public function alm_reporte()//para construir la tabla en la base de datos
    {

    }
//////Fin de Sub_modulo de cierre de inventario

    //Esta funcion se una para construir el json para el llenado del datatable en la vista de modificar el cod del articulo
    public function mod_cod_art()
    {
        if($_POST)
        {
            // die_pre(json_encode("unchanged"));
            $articuloID = $_POST['raw']['data']['0']['ID'];
            $campo1 = $_POST['raw']['data']['0']['descripcion'];
            $campo2 = $_POST['raw']['data']['0']['cod_articulo'];
            $campo3 = $_POST['raw']['data']['0']['cod_ubicacion'];
            $aux = $this->model_alm_articulos->get_articulo($articuloID, true);
            $historial= array(
                    'id_historial_a'=>$this->session->userdata('user')['id_dependencia'].'00'.$this->session->userdata('user')['ID'].'0'.$this->model_alm_articulos->get_lastHistoryID(),//revisar, considerar eliminar la dependencia del codigo
                    'observacion'=>strtoupper('modificando articulo')."ID=".$articuloID." from:|".$aux['descripcion']."|-|".$aux['cod_articulo']."|-|".$aux['cod_ubicacion']." to:|".$campo1."|-|".$campo2."|-|".$campo3,
                    'por_usuario'=>$this->session->userdata('user')['id_usuario']
                    );
            switch($_POST['action']):
                case 'editRow':
                    // echo_pre($_POST['raw']['data']['0']);
                    if(!$this->model_alm_articulos->consul_cod($_POST['raw']['data']['0'])){
                        if($this->model_alm_articulos->update_cod_articulo($_POST['raw']['data']['0'], $historial))
                        {
                            echo json_encode("true");
                        }
                        else
                        {
                            echo json_encode("false");
                        }
                    }
                    else
                    {
                        echo json_encode("unchanged");
                    }
                    break;
            endswitch;
        
        }
        else
        {
            $results = $this->model_alm_articulos->get_art();//Va al modelo para tomar los datos para llenar el datatable
            echo json_encode($results); //genera la salida de datos
        }
    }
    
    public function tmp_mod_arti()
    {
        
        if($this->session->userdata('user'))
        {
            
    	    $this->load->view('template/header');
            $this->load->view('mod_cod_art');
            $this->load->view('template/footer');
            
        }
        else
        {
            $header['title'] = 'Error de Acceso';
            $this->load->view('template/erroracc');
        }
    }

    //Nueva funcion temporal
    public function excel_code_switch()//para cambiar los códigos de los articulos por otros, suministrado por un archivo de excel predeterminado
    {
        if($this->session->userdata('user'))
        {
            // echo $this->input->post("file");
            if($this->input->post("file"))
            {
                $file = $this->input->post("file");
                $objPHPExcel = PHPExcel_IOFactory::load($file);//llamo la libreria de excel para cargar el archivo de excel
                $cell_collection = $objPHPExcel->getActiveSheet()->getCellCollection();//recorrere el archivo por celdas

            ////version actual
                $verifica = true;
            ////version actual
                $arraycod=array();
                $errores=array();
                $affected=array();
                foreach ($cell_collection as $cell) //para cada celda
                {
                    $column = $objPHPExcel->getActiveSheet()->getCell($cell)->getColumn();//columna de la celda
                    $row = $objPHPExcel->getActiveSheet()->getCell($cell)->getRow();//fila de la celda
                    $data_value = $objPHPExcel->getActiveSheet()->getCell($cell)->getValue();//dato en la celda
                    
                    if($row <= 1)//esto depende de la tabla, con o sin titulo(sin titulo)
                    {
                        if($data_value=='cod_articulo')
                        {
                            $col_articulo = $column;
                        }
                        if($data_value=='codigo_NU')
                        {
                            $col_articuloNU = $column;
                        }
                        if($data_value == 'descripcion')
                        {
                            $col_descripcion = $column;
                        }
                        if($data_value == 'descripcion_NU')
                        {
                            $col_descripcionNU = $column;
                        }
                    }
                    else
                    {
                        if($column == $col_articulo)//codigo viejo del articulo
                        {
                            $i=$row;
                            $array[$i]['linea']=$row;
                            if(!empty($data_value))
                            {
                                $array[$i]['cod_artviejo'] = $data_value;
                                // $array[$i]['cod_artviejo'] = preg_replace('/\s+/', '', $data_value);
                            }
                        }
                        else
                        {
                            if(isset($i) && isset($array[$i]['cod_artviejo']) && $i==$row)
                            {
                                if($column == $col_articuloNU)//codigo del articulo basado en las naciones unidas
                                {
                                    $array[$i]['cod_articulo'] = $data_value;
                                }
                                else
                                {
                                    if($column == $col_descripcionNU)//descripcion correcta, basado en las naciones unidas
                                    {
                                        $array[$i]['descripcion'] = $data_value;
                                        if(isset($array[$i]['cod_artviejo']) && isset($array[$i]['cod_articulo']) && isset($array[$i]['descripcion']))
                                        {
                                            $aux['cod_articulo'] = $array[$i]['cod_articulo'];
                                            $aux['descripcion'] = $array[$i]['descripcion'];
                                            $cod_NU = preg_split("/[-]+/", $array[$i]['cod_articulo']);
                                            $aux['cod_articulonu'] = $cod_NU[0];
                                            // $cod['cod_artviejo'] = $array[$i]['cod_artviejo'];
                                            // if($this->model_alm_articulos->exist($cod))
                                            if($this->model_alm_articulos->edit_artCod($array[$i]['cod_artviejo'], $aux))
                                            {
                                                $affected[]=$row;
                                                $verifica *= 1;
                                            }
                                            else
                                            {
                                                $errores[]=$row;
                                                $verifica *= 0;
                                            }
                                            $arraycod[$i]['cod_artviejo'] = $array[$i]['cod_artviejo'];
                                            $arraycod[$i]['cod_articulo'] = $array[$i]['cod_articulo'];
                                            $arraycod[$i]['descripcion'] = $array[$i]['descripcion'];
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
                // die_pre($errores, __LINE__, __FILE__);
            ////version actual
                if($verifica)
                {
                    $success['status']='success';
                    $success['goodLines']= $affected;
                    echo json_encode($success);
                }
                else
                {
                    $error['status']='error';
                    $error['goodLines']= $affected;
                    $error['badLines']= $errores;
                    echo json_encode($error);
                }
            }
            else
            {
                return(false);
            }
        }
        else
        {
            $header['title'] = 'Error de Acceso';
            $this->load->view('template/erroracc',$header);
        }
    }

    public function excel_category_input()//para cambiar los códigos de los articulos por otros, suministrado por un archivo de excel predeterminado
    {
        if($this->session->userdata('user'))
        {
            // echo $this->input->post("file");
            if($this->input->post("file"))
            {
                $file = $this->input->post("file");
                $objPHPExcel = PHPExcel_IOFactory::load($file);//llamo la libreria de excel para cargar el archivo de excel
                $cell_collection = $objPHPExcel->getActiveSheet()->getCellCollection();//recorrere el archivo por celdas

            ////version actual
                $verifica = true;
            ////version actual
                $categoria = array();//'cod_categoria'=>array(), 'nombre'=>array());
                $familia = array();//'familia'=>array(), 'cod_familia'=>array());
                $segmento = array();//'segmento'=>array(), 'cod_segmento'=>array());
                $flag = '';
                $i=0;
                $j=0;
                $k=0;
                $arrayCat=array();
                $errores=array();
                $affected=array();
                $lines =0;
                foreach ($cell_collection as $cell) //para cada celda
                {
                    $column = $objPHPExcel->getActiveSheet()->getCell($cell)->getColumn();//columna de la celda
                    $row = $objPHPExcel->getActiveSheet()->getCell($cell)->getRow();//fila de la celda
                    $data_value = $objPHPExcel->getActiveSheet()->getCell($cell)->getValue();//dato en la celda
                    
                    if($row <= 1)//esto depende de la tabla, con o sin titulo(sin titulo)
                    {
                        if($data_value=='CODIGO')
                        {
                            $col_codigo = $column;
                        }
                        if($data_value=='DESCRIPCION')
                        {
                            $col_descripcion = $column;
                        }
                    }
                    else
                    {
                        if($column == $col_codigo)
                        {
                            if(strlen($data_value) == 2)
                            {
                                $flag = 'segmento';
                                $segmento[$i]['cod_segmento'] = $data_value;
                                $affected['Linea: '.$row] = '';
                                $affected['Linea: '.$row] .= 'cod_segmento: '.$data_value;
                            }
                            if(strlen($data_value) == 4)
                            {
                                $flag = 'familia';
                                $familia[$j]['cod_familia'] = $data_value;
                                $affected['Linea: '.$row] = '';
                                $affected['Linea: '.$row] .= 'cod_familia: '.$data_value;
                            }
                            if(strlen($data_value) == 6)
                            {
                                $flag = 'categoria';
                                $categoria[$k]['cod_categoria'] = $data_value;
                                $affected['Linea: '.$row] = '';
                                $affected['Linea: '.$row] .= 'cod_categoria: '.$data_value;
                            }
                        }
                        if($column == $col_descripcion)
                        {
                            if($flag == 'segmento')
                            {
                                $segmento[$i]['segmento'] = $data_value;
                                $affected['Linea: '.$row] .= ' segmento: '.$data_value;
                                $i++;
                            }
                            if($flag == 'familia')
                            {
                                $familia[$j]['familia'] = $data_value;
                                $affected['Linea: '.$row] .= ' familia: '.$data_value;
                                $j++;
                            }
                            if($flag == 'categoria')
                            {
                                $categoria[$k]['nombre'] = $data_value;
                                $affected['Linea: '.$row] .= ' nombre: '.$data_value;
                                $k++;
                            }
                            $flag = '';
                        }
                    }
                }
                // echo_pre(sizeof($segmento), __LINE__, __FILE__);
                // echo_pre(sizeof($familia), __LINE__, __FILE__);
                // echo_pre(sizeof($categoria), __LINE__, __FILE__);
                $aux = array();
                $piece1 = '';
                $piece2 = '';
                foreach ($categoria as $key => $value)
                {
                    $aux[$key] = array();
                    foreach ($familia as $key2 => $value2)
                    {
                        foreach ($segmento as $key3 => $value3)
                        {
                            $piece1 = substr($value['cod_categoria'], 0, 4);
                            $piece2 = substr($value2['cod_familia'], 0, 2);
                            if($piece1 == $value2['cod_familia'])
                            {
                                if($piece2==$value3['cod_segmento'])
                                {
                                    $aux[$key]['nombre'] = $value['nombre'];
                                    $aux[$key]['cod_categoria'] = $value['cod_categoria'];
                                    $aux[$key]['familia'] = $value2['familia'];
                                    $aux[$key]['cod_familia'] = $value2['cod_familia'];
                                    $aux[$key]['segmento'] = $value3['segmento'];
                                    $aux[$key]['cod_segmento'] = $value3['cod_segmento'];
                                }
                            }
                        }
                    }
                }
                // die_pre($aux);
                $verifica = $this->model_alm_articulos->insert_categoria($aux);
                $this->model_alm_articulos->relate_categoria();
                if($verifica)
                {
                    $success['status']='success';
                    $success['goodLines']= $affected;
                    echo json_encode($success);
                }
                else
                {
                    $error['status']='error';
                    $error['goodLines']= $affected;
                    $error['badLines']= $errores;
                    echo json_encode($error);
                }
            }
            else
            {
                return(false);
            }
        }
        else
        {
            $header['title'] = 'Error de Acceso';
            $this->load->view('template/erroracc',$header);
        }
    }

    public function json_categories()
    {
        if($this->session->userdata('user'))
        {
            if($_POST)
            {
                die_pre($_POST);
            }
            // echo_pre('helloWorld!');
            $categorias = $this->model_alm_articulos->get_allCategorias();
            // echo_pre($categorias);
            echo json_encode($categorias);
        }
        else
        {
            $header['title'] = 'Error de Acceso';
            $this->load->view('template/erroracc',$header);
        }

    }
}