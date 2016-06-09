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
        if($this->dec_permiso->has_permission('alm', 1)||$this->dec_permiso->has_permission('alm', 4)||$this->dec_permiso->has_permission('alm', 5)||$this->dec_permiso->has_permission('alm', 6)||$this->dec_permiso->has_permission('alm', 7)||$this->dec_permiso->has_permission('alm', 8))
        {
            if($_POST)
            {
                // echo_pre($_POST, __LINE__, __FILE__);
            }
////////seccion de banderas para filtrado de permisos sobre inventario
            $view = $this->dec_permiso->parse_permission('', 'alm');
////////fin de seccion de banderas para filtrado de permisos sobre inventario
            $view['inventario'] = $this->model_alm_articulos->get_allArticulos();
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
        // echo_pre('permiso para insertar articulos a inventario', __LINE__, __FILE__);//6
        if($$this->dec_permiso->has_permission('alm', 6))
        {
            if($_POST)//recordar, debes insertar en las tablas alm_articulos, alm_genera_hist_a, alm_historial_a
            {
                // die_pre($_POST, __LINE__, __FILE__);
                $post=$_POST;
                //carga para alm_articulos
                $aux['cod_articulo'] = $post['cod_articulo'];
                $new = !$this->model_alm_articulos->exist_articulo($aux);
                if($new)
                {
                    $articulo= array(
                        'cod_articulo'=>$post['cod_articulo'],
                        'unidad'=>$post['unidad'],
                        'descripcion'=>strtoupper($post['descripcion']),
                        'ACTIVE'=>1,
                        'peso_kg'=>$post['peso_kg'],
                        'dimension_cm'=>$post['alto']."x".$post['ancho']."x".$post['largo'],
                        );
                    if(!empty($post['imagen']))//aqui toca subir imagen cuando este listo
                    {
                        $articulo['imagen']= $post['imagen'];
                    }

                    if($post['nuevo'])
                    {
                        $articulo['nuevos'] = $post['cantidad'];
                    }
                    else
                    {
                        $articulo['usados'] = $post['cantidad'];
                    }
                }
                else
                {
                    $articulo = array(
                        'cod_articulo' => $post['cod_articulo'],
                        'ACTIVE'=>1
                        );
                    $exist=$this->model_alm_articulos->get_existencia($post['cod_articulo']);

                    if($post['nuevo'])
                    {
                        $articulo['nuevos'] = $exist['nuevos']+$post['cantidad'];
                    }
                    else
                    {
                        $articulo['usados'] = $exist['usados']+$post['cantidad'];
                    }
                }
                // die_pre($articulo, __LINE__, __FILE__);
                $historial= array(
                    'id_historial_a'=>$this->session->userdata('user')['id_dependencia'].'00'.$this->session->userdata('user')['ID'].'0'.$this->model_alm_articulos->get_lastHistoryID(),//revisar, considerar eliminar la dependencia del codigo
                    'entrada'=>$post['cantidad'],
                    'nuevo'=>$post['nuevo'],
                    'observacion'=>strtoupper($post['observacion']),
                    'por_usuario'=>$this->session->userdata('user')['id_usuario']
                    );
                if($new)
                {
                    $success = $this->model_alm_articulos->add_newArticulo($articulo, $historial);
                }
                else
                {
                    $success = $this->model_alm_articulos->update_articulo($articulo, $historial);
                }
                if($success)
                {
                    echo '<div class="alert alert-success">
                            El articulo fue agregado exitosamente.
                        </div>';
                }
                else
                {
                    echo '<div class="alert alert-danger">
                            Ocurri&oacute; un problema al insertar el articulo.
                        </div>';
                }
            }
        }
        else
        {
            echo '<div class="alert alert-danger">
                    No tiene los permisos adecuados para guardar articulos.
                </div>';
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

    public function getSystemWideTable($active='')
    {
        /* Array of database columns which should be read and sent back to DataTables. Use a space where
         * you want to insert a non-database field (for example a counter or static image)
         */
        $aColumns = array('ID', 'cod_articulo', 'descripcion', 'exist', 'reserv', 'nuevos', 'usados', 'stock_min');
        
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
            $aux = '<div id="art'.$aRow['ID'].'" class="modal modal-message modal-info fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h4 class="modal-title">Detalles</h4>
                                </div>
                                <div class="modal-body">
                                    <div>
                                        <h4><label>c&oacute;digo del articulo: 
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
    }
    public function getInventoryTable($active='')
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
        if((!$this->hasPermissionClassA() && !$this->hasPermissionClassC) || $active==1)
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
            $row[]= $i;//primera columna
            $i++;
            $row[]= $aRow['cod_articulo'];//segunda columna
            $row[]= $aRow['descripcion'];//tercera columna
            // if(!empty($this->session->userdata('articulos')) && in_array($aRow['ID'], $this->session->userdata('articulos')))
            // {
              // $row[]='<span id="clickable"><i id="row_'.$aRow['ID'].'" class="fa fa-minus" style="color:#D9534F"></i></span>';
            // }
            // else
            // {
                $row[]='<span id="clickable"><i id="row_'.$aRow['ID'].'" class="fa fa-plus color"></i></span>';
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

    public function ajax_formProcessing()//para agregar articulos
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
                </br>
                <div id="inv">
                    <div class="alert alert-warning" style="text-align: right"> Debe agregar todos los detalles del art&iacute;culo nuevo para inventario, definiendo un c&oacute;digo &uacute;nico para el art&iacute;culo nuevo
                    </br>
                    Recuerde consultar las condiciones de dise&ntilde;o para asignar un c&oacute;digo al articulo
                    </div>
                    <div class="row">
                        <i class="color col-lg-8 col-md-8 col-sm-8" align="right" >(*)  Campos Obligatorios</i>
                    </div>
                    <div id="new_inv_error" class="alert alert-danger" style="text-align: center">
                    </div>
                    <form id="new_inv" class="form-horizontal">
                        <!-- cod_articulo -->
                        <div class="form-group">
                            <label class="control-label" for="cod_articulo"><i class="color">*  </i>C&oacute;digo:</label>
                            <div class="input-group col-md-5">
                                <input type="text" class="form-control" id="cod_articulo" name="cod_articulo" onkeyup="validateNumber(name)"><span id="loading"><img src="<?php echo base_url(); ?>assets/img/ajax-loader.gif" alt="Ajax Indicator" /></span>
                                <span id="cod_articulo_msg" class="label label-danger"></span>
                            </div>
                        </div>
                        
                        <!-- unidad -->
                        <div class="form-group">
                            <label class="control-label" for="unidad"><i class="color">*  </i>Unidad:</label>
                            <div class="input-group col-md-5">
                                <input type="text" class="form-control" id="unidad" name="unidad" onkeyup="validateSingleWord(name)">
                                <span id="unidad_msg" class="label label-danger"></span>
                            </div>
                        </div>
                        
                        <!-- descripcion -->
                        <div class="form-group">
                            <label class="control-label" for="descripcion"><i class="color">*  </i>Descripci&oacute;n:</label>
                            <div class="input-group col-md-5">
                                <input type="text" class="form-control" id="descripcion" name="descripcion">
                            </div>
                        </div>
                        
                        <!-- nuevo -->
                        <div class="form-group" style="text-align: center">
                            <label class="control-label" for="radio">Estado del art&iacute;culo</label>
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
                            <label class="control-label" for="imagen">Imagen del articulo:</label>
                            <div class="input-group col-md-5">
                                <input id="imagen" type="file" multiple="true">
                            </div>
                        </div>
                        
                        <!-- cantidad -->
                        <div class="form-group">
                            <label class="control-label" for="cantidad"><i class="color">*  </i>Cantidad:</label>
                            <div class="input-group col-md-1">
                                <input type="text" class="form-control" id="cantidad" name="cantidad" onkeyup="validateNumber(name)">
                                <span id="cantidad_msg" class="label label-danger"></span>
                            </div>
                        </div>
                        
                        <!-- peso_kg -->
                        <div class="form-group">
                            <label class="control-label" for="peso_kg">Peso:</label>
                            <div class="input-group col-md-5">
                                <input type="text" class="form-control" id="peso_kg" name="peso_kg" onkeyup="validateRealNumber(name)">
                                <span id="peso_kg_msg" class="label label-danger"></span>
                                <span class="input-group-addon">Kg</span>
                            </div>
                        </div>

                        <!-- dimension_cm -->
                        <div class="form-group">
                            <label class="control-label" for="dimensiones">Dimensiones:</label>
                            <div class="input-group col-md-6">
                                <input type="text" class="form-control" id="alto" name="alto" placeholder="Alto" onkeyup="validateRealNumber(name)">
                                <span class="input-group-addon"> cm x</span>
                                <input type="text" class="form-control" id="ancho" name="ancho" placeholder="Ancho" onkeyup="validateRealNumber(name)">
                                <span class="input-group-addon"> cm x</span>
                                <input type="text" class="form-control" id="largo" name="largo" placeholder="Largo" onkeyup="validateRealNumber(name)">
                                <span class="input-group-addon"> cm</span>
                            </div>
                            <span id="alto_msg" class="label label-danger"></span>
                            <span id="ancho_msg" class="label label-danger"></span>
                            <span id="largo_msg" class="label label-danger"></span>
                        </div>
                        <!-- observacion -->
                        <div class="form-group">
                            <label class="control-label" for="observacion">Observaci&oacute;n:</label>
                            <div class="input-group col-md-5">
                                <textarea type="text" class="form-control" id="observacion" name="observacion"/>
                            </div>
                        </div>

                        <button id="new_invSub" type="submit" class="btn btn-default">Agregar</button>
                    </form>
                </div>
                <script type="text/javascript">
                    $("#imagen").fileinput({
                        showCaption: false,
                        previewFileType: "image",
                        browseLabel: " Examinar...",
                        browseIcon: '<i class="glyphicon glyphicon-picture"></i>',
                        removeClass: "btn btn-danger",
                        removeLabel: "Delete",
                        removeIcon: '<i class="glyphicon glyphicon-trash"></i>',
                        showUpload: false
                    });
                    $(function()
                    {
                        $("#new_inv_error").hide();
                        $("#loading").hide();
                        var flag=false;// auxiliar para validar on blur de la existencia del codigo
                        var valid =false;
                        $("#cod_articulo").keyup(function(){
                            if($("#cod_articulo").val().length>3)
                            {
                                var codigo = $("#cod_articulo").val();
                                $("#loading").show();
                                $.post("alm_articulos/ajax_codeCheck", {
                                    codigo : codigo
                                }, function(resp){
                                    $("#loading").hide();
                                    console.log(resp);
                                    flag = resp.bool;
                                    if(!resp.bool)
                                    {
                                        $("#cod_articulo").attr("style", "background-color: #F2DEDE");
                                        $("#cod_articulo_msg").html(resp.message).show();
                                        // $("#cod_articulo_msg").html(resp.message).show().delay(4000).fadeOut();
                                    }
                                        return false;
                                });
                            }
                        });
                        $("#new_invSub").click(function()
                        {
                            $("#new_inv_error").hide();
                            console.log(flag);
                            if(!flag)
                            {
                                $("#new_inv_error").html("el c&oacute;digo ya esta usado");
                                $("#new_inv_error").show();
                                $("input#cod_articulo").focus();
                                return false;
                            }
                            if($("input#cod_articulo").val()=="")
                            {
                                $("#new_inv_error").html("el c&oacute;digo es obligatorio");
                                $("#new_inv_error").show();
                                $("input#cod_articulo").focus();
                                return false;
                            }
                            
                            if($("input#unidad").val()=="")
                            {
                                $("#new_inv_error").html("La unidad es obligatorio");
                                $("#new_inv_error").show();
                                $("input#unidad").focus();
                                return false;
                            }
                            if($("input#descripcion").val()=="")
                            {
                                $("#new_inv_error").html("La descripci&oacute;n es obligatorio");
                                $("#new_inv_error").show();
                                $("input#descripcion").focus();
                                return false;
                            }
                            if($("input#cantidad").val()=="")
                            {
                                $("#new_inv_error").html("La cantidad es obligatorio");
                                $("#new_inv_error").show();
                                $("input#cantidad").focus();
                                return false;
                            }
                            var aux = $("#new_inv").serializeArray();
                            console.log($("#new_inv").serializeArray());
                            $.ajax(
                            {
                                type: "POST",
                                url: "alm_articulos/insertar_articulo",
                                data: aux,
                                success: function(response)
                                {
                                    $("#inv").html(response);
                                },
                                error: function(jqXhr){
                                    if(jqXhr.status == 400)
                                    {
                                        $("#inv").html(jqXhr.responseText);
                                        // var json = $.parseJSON(jqXhr.responseText);
                                    }
                                        console.log(jqXhr);
                                }
                            });
                            return(false);
                        });
                    });
                </script>
            <?php
            }
            else //aqui construllo el formulario para la cantidad de articulos que se agrega a inventario
            {
                $art = $this->model_alm_articulos->exist_articulo($articulo);
                // echo_pre($art, __LINE__, __FILE__);
            ?>
                </br>
                <div id="inv">
                    <div id="inv_error" class="alert alert-danger" style="text-align: center">
                    </div>
                    <div class="row">
                        <i class="color col-lg-8 col-md-8 col-sm-8" align="right" >(*)  Campos Obligatorios</i>
                    </div>
                    <form id="add_inv" class="form-horizontal">
                        <!-- nuevo -->
                        <div class="form-group" style='text-align: center'>
                            <label class="control-label" for="radio">Estado del art&iacute;culo</label>
                            <label class="radio" for="radio-0">
                                <input name="nuevo" id="radio-0" value="1" checked="checked" type="radio">
                                Nuevo
                            </label>
                            <label class="radio" for="radio-1">
                                <input name="nuevo" id="radio-1" value="0" type="radio">
                                Usado
                            </label>
                        </div>
                        <!-- cantidad -->
                        <div class="form-group">
                            <label class="control-label" for="cantidad"><i class="color">*  </i>Cantidad:</label>
                            <div class="input-group col-md-8">
                                <input type="text" class="form-control" id="cantidad" name="cantidad" onkeyup="validateNumber(name)">
                                <span id="cantidad_msg" class="label label-danger"></span>
                                <span class="input-group-addon"><?php echo 'x 1 '.$art['unidad']; ?></span>
                            </div>
                        </div>
                        <!-- observacion -->
                        <div class="form-group">
                            <label class="control-label" for="observacion">Observaci&oacute;n:</label>
                            <div class="input-group">
                                <textarea type="text" class="form-control" id="observacion" name="observacion"/>
                            </div>
                        </div>
                                <input type="hidden" name="cod_articulo" value="<?php echo $art['cod_articulo'];?>"/>

                        <button id="invSub" type="submit" class="btn btn-default">Agregar</button>
                    </form>
                </div>
                <script type="text/javascript">
                    $(function()
                    {
                        $("#inv_error").hide();
                        $("#invSub").click(function()
                        {
                            $("#inv_error").hide();
                            if($("input#cantidad").val()=="")
                            {
                                $("#inv_error").html("La cantidad es obligatorio");
                                $("#inv_error").show();
                                $("input#cantidad").focus();
                                return false;
                            }
                            var aux = $("#add_inv").serializeArray();
                            console.log($("#add_inv").serializeArray());
                            $.ajax(
                            {
                                type: "POST",
                                url: "alm_articulos/insertar_articulo",
                                data: aux,
                                success: function(response)
                                {
                                    $("#inv").html(response);
                                },
                                error: function(jqXhr){
                                    if(jqXhr.status == 400)
                                    {
                                        $("#inv").html(jqXhr.responseText);
                                        // var json = $.parseJSON(jqXhr.responseText);
                                    }
                                        console.log(jqXhr);
                                }
                            });
                            return(false);
                        });
                    });
                </script>
            <?php

                // echo_pre($this->model_alm_articulos->get_ArtHistory($art), __LINE__, __FILE__);
            }
        }
        
    }
    public function ajax_codeCheck()//verifica que el codigo de articulo exista o no
    {
        if($this->input->is_ajax_request())
        {
            $codigo = $this->input->post('codigo');
            if(!$this->form_validation->is_unique($codigo, 'alm_articulo.cod_articulo'))
            { 
                $aux= array(
                    'message' => 'El c&oacute;digo ya existe, elija otro', 
                    'bool' => false);
            }
            else
            {
                $aux= array(
                    'message' => '', 
                    'bool' =>true);
            }
            header('Content-type: application/json');
            echo json_encode($aux);
        }
    }
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

    public function pdf_cierreFinal($array='')
    {
        // echo_pre('permiso para realizar cierres', __LINE__, __FILE__);
        if($this->dec_permiso->has_permission('alm', 13))
        {
            $date = time();
            $view['cabecera']="reporte del cierre de inventario al";//titulo acompanante de la cabecera del documento
            $view['nombre_tabla']="cierre de inventario";//nombre de la tabla que construira el modelo
            $view['fecha_cierre']=$date; //la fecha de hoy
            $view['tabla'] = $array;//construccion de la tabla

            $file_to_save = 'uploads/cierres/'.date('Y-m-d',$date).'.pdf';
            $this->load->helper('file');

            // Load all views as normal
            $this->load->view('reporte_pdf', $view);
            // Get output html
            $html = $this->output->get_output();
            // Load library
            $this->load->library('dompdf_gen');

            // Convert to PDF
            $this->dompdf->load_html(utf8_decode($html));
            $this->dompdf->render();
            $output = $this->dompdf->output();
            if(! write_file($file_to_save, $output))
            {
                return('error');
            }
            else
            {
                return($file_to_save);
                // $this->dompdf->stream("solicitud.pdf", array('Attachment' => 0));
            }
        }
        else
        {
            $this->session->set_flashdata('permission', 'error');
            redirect('inicio');
        }

    }

    public function upload_excel()//para subir un archivo de lista de inventario fisico
    {
////////defino los parametros de la configuracion para la subida del archivo
        $config['upload_path'] = './uploads/';
        // $config['allowed_types'] = 'xls|xlsx|ods|csv|biff|pdf|html';//esta linea da conflictos en centos 7
        $config['allowed_types'] = '*';
        $config['file_name']= 'inv_fisico';
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
        // echo $this->input->post("file");
        if($this->input->post("file"))
        {
            $file = $this->input->post("file");
            $objPHPExcel = PHPExcel_IOFactory::load($file);//llamo la libreria de excel para cargar el archivo de excel
            //get only the Cell Collection
            $cell_collection = $objPHPExcel->getActiveSheet()->getCellCollection();//recorrere el archivo por celdas
            //extract to a PHP readable array format
            foreach ($cell_collection as $cell) //para cada celda
            {
                $column = $objPHPExcel->getActiveSheet()->getCell($cell)->getColumn();//columna
                $row = $objPHPExcel->getActiveSheet()->getCell($cell)->getRow();//fila
                $data_value = $objPHPExcel->getActiveSheet()->getCell($cell)->getValue();//dato en la columna-fila
                //header will/should be in row 1 only. of course this can be modified to suit your need.
                if($row <= 2)//en el recorrido, aparto las primeras 2 filas
                {
                    $header[$row][$column] = $data_value;
                }
                else//a partir de la 3 fila empiezan los datos de articulos y cantidades
                {
                    if($column == 'A')//codigo del articulo
                    {
                        // $arr_data[$row][$column] = $data_value;
                        $aux['linea'] = $row;
                        $aux['cod_articulo'] = $data_value;
                    }
                    if($column == 'B')//cantidad en existencia (tambien es la ultima columna a leer)
                    {
                        // $arr_data[$row][$column] = $data_value;
                        $aux['existencia'] = $data_value;
                        //a partir de aqui se puede mandar $aux completa para procesar en modelo
                        // echo_pre($aux);
                        $arr_data[$row-3] = $this->model_alm_articulos->verif_art($aux);//primera funcion de base de datos
                    }
                }
            }
            //send the data in an array format
            $arr_data = $this->model_alm_articulos->art_notInReport($arr_data);//segunda funcion de base de datos
            // $data['header'] = $header;
            // $data['values'] = $arr_data;
            // return($data);
            // echo_pre($data['values']);
            // $this->pdf_cierreFinal($data['values']);
            // echo json_encode($this->pdf_cierreFinal($data['values']));
            $aux = $this->pdf_cierreFinal($arr_data);
            // echo $aux;
            // $this->pdf_cierreFinal($data['values']);
        }
        else
        {
            return(false);
        }
    }

    public function excel_to_DB()//sube y lee un archivo de excel para cargar articulos que no esten en la BD
    {
        // echo_pre('permiso para agregar articulos desde archivo', __LINE__, __FILE__);
        if($this->dec_permiso->has_permission('alm', 7))
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
                $lastRow = 3;
                $repeatedItems = array();
                $success = 1;
                foreach ($cell_collection as $cell) //para cada celda
                {
                    $column = $objPHPExcel->getActiveSheet()->getCell($cell)->getColumn();//columna
                    $row = $objPHPExcel->getActiveSheet()->getCell($cell)->getRow();//fila
                    $data_value = $objPHPExcel->getActiveSheet()->getCell($cell)->getValue();//dato en la columna-fila
                    
                    if((($row>2) && ($row!=$lastRow)) || $cell == $lastCell)//verifica el salto a la siguiente linea (o siguiente articulo)
                    {//en resumen, pregunta si la fila es mayor a 3
                        //(primera fila es nombre de la tabla, segunda fila es nombre de las columnas, y la tercera fila es la primera ronda siendo almacenada antes de poder ser mostrada)
                        //y la fila es diferente a la fila anterior
                        //(es decir si ya paso a la siguiente fila para poder mostrar la anterior)
                        //o si ya llegue a la ultima celda del documento
                        //(para mostrar la ultima fila construida por las iteraciones).
                        // echo $i."<br>".$row;
                        // if(!$this->model_alm_articulos->exist_articulo($aux[$i]))//pregunto si el articulo no existe o no esta en el sistema
                        if(!$this->model_alm_articulos->exist_articulo($aux))//pregunto si el articulo no existe o no esta en el sistema
                        {
    //aqui hago insercion en la base de datos
//para insertar por grupos
//fin de para insertar por grupos
                            // echo_pre($aux);
                            // echo_pre($aux[$i]);
////para insertar uno por uno durante la ejecucion
                            $success = $this->model_alm_articulos->add_articulo($aux);
                            if(!$success)
                            {
                                $error['error'] = "Ocurri&oacute; un error agregando el art&iacute;culo de la linea: ".($row-1);
                                die(json_encode($error));
                            }
////fin de para insertar uno por uno durante la ejecucion
                            // die('stop');
                        }
                        else
                        {//construyo un arreglo de linea de archivo y descripcion del articulo, para referenciar que se encuentra repetido en el sistema
                            //$repeatedItems['L&iacute;nea: '.($row-1)] = 'c&oacute;digo: '.$aux['cod_articulo'].' descripci&oacute;n: '.$aux['descripcion'];
                            $aux1['linea'] = ($row-1);
                            $aux1['codigo'] = $aux['cod_articulo'];
                            // $aux1['codigo'] = $aux[$i]['cod_articulo'];
                            $aux1['descripcion'] = $aux['descripcion'];
                            // $aux1['descripcion'] = $aux[$i]['descripcion'];
                            $repeatedItems[] = $aux1;
                        }
                        $i++;
                        $lastRow = $row;//guardo la fila para verificar la siguiente iteracion
                    }
                    //header will/should be in row 1 only. of course this can be modified to suit your need.
                    // echo $i.'<br>';
                    if($row <= 2)//en el recorrido, aparto las primeras 2 filas
                    {
                        $header[$row][$column] = $data_value;
                    }
                    else//a partir de la 3 fila empiezan los datos de articulos y cantidades
                    {
                        $attr = $header[2][$column];
                        $aux[$attr] = strtoupper($data_value);
                        // $aux[$row-3][$attr] = htmlentities(strtoupper($data_value));
                    }
                }
                if(isset($repeatedItems))
                {
                    echo json_encode($repeatedItems);
                }
                else
                {
                    // echo $i;
                    $inserted['success']=$i;
                    // print_r($inserted);
                    echo json_encode('success');
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
                //     redirect(base_url().'index.php/inventario');
                // }
                // else
                // {
                //     $this->session->set_flashdata('add_articulos','error');
                //     redirect(base_url().'index.php/inventario');   
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
}