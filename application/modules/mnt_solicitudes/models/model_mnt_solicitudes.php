<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Model_mnt_solicitudes extends CI_Model {

    //constructor predeterminado del modelo
    function __construct() {
        parent::__construct();
    }
    
    var $table = 'mnt_orden_trabajo'; //El nombre de la tabla que estamos usando
            
    public function get_all() {
        return($this->db->count_all('mnt_orden_trabajo'));
    }

    //la funcion se usa para mostrar los usuarios de la base de datos en alguna tabla...
    //para filtrar los roles, y cualquier dato de alguna columna, se debe realizar con condicionales desde la vista en php
    public function get_allorden($field = '', $order = '', $per_page = '', $offset = '') {
        // SE EXTRAEN TODOS LOS DATOS DE LA TABLA 
        if ((!empty($field)) && (!empty($order))) {// evalua el campo orden tambien para poder ordenar por max_id
            $this->db->order_by($field, $order);
        } else {
            $this->db->order_by("id_orden", "desc");
        }
        $query = $this->unir_tablas($per_page, $offset);
        $query = $this->db->get('mnt_orden_trabajo', $per_page, $offset);
        //die_pre($query->result());
        return $query->result();
    }
    
    //Esta es la funcion que trabaja correctamente al momento de cargar los datos desde el servidor para el datatable 
    function get_list($est='',$dep=''){
        $ayuEnSol = $this->model_mnt_ayudante->array_of_orders(); //Para consultar los ayudantes asignados a una orden
        $cuadri = $this->model_cuadrilla->get_cuadrillas();
   
        /* Array de las columnas para la table que deben leerse y luego ser enviados al DataTables. Usar ' ' donde
         * se desee usar un campo que no este en la base de datos
         */
        $aColumns = array('id_orden','fecha','dependen','asunto','descripcion','cuadrilla','tiene_cuadrilla','tipo_orden','id_cuadrilla','estatus','icono','sugerencia');
  
        /* Indexed column (se usa para definir la cardinalidad de la tabla) */
        $sIndexColumn = "id_orden";
        
        /* $filtro (Se usa para filtrar la vista del Asistente de autoridad) La intencion de usar esta variable
        es para usarla en el query que se va a construir mas adelante. Este datos es modificable */
        if ($this->session->userdata('user')['sys_rol'] == 'asist_autoridad'): 
            $filtro = "WHERE estatus = 2"; /* asistente de autoridad solo va a mostrar las solicitudes que tengan estatus 2 */
        else:
            $filtro = "WHERE estatus NOT IN (3,4)";
        endif;
        if(($est=='close'))://Evalua el estado de las solicitudes para crear la vista en Solicitudes cerradas/anuladas
             $filtro = "WHERE estatus IN (3,4)";
        endif;
        if(isset($_GET['dep']))://Evalua si viene de un departamento y no es autoridad 
            $filtro = "WHERE dependencia = $_GET[dep] AND estatus NOT IN (3,4)";
        endif;
        if(isset($_GET['dep']) && $est=='close')://Evalua si viene de un departamento y no es autoridad y estan en la vista de sol cerradas/anuladas 
            $filtro = "WHERE dependencia = $_GET[dep] AND estatus IN (3,4)";
        endif;
        
        /* Se establece la cantidad de datos que va a manejar la tabla (el nombre ya esta declarado al inico y es almacenado en var table */
        $sQuery = "SELECT COUNT('" . $sIndexColumn . "') AS row_count FROM $this->table $filtro";
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
        for ($i = 0; $i < count($aColumns)-4; $i++):
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
        $sJoin = "INNER JOIN dec_dependencia ON mnt_orden_trabajo.dependencia=dec_dependencia.id_dependencia "
                . "INNER JOIN mnt_estatus ON mnt_orden_trabajo.estatus=mnt_estatus.id_estado "
                . "INNER JOIN mnt_tipo_orden ON mnt_orden_trabajo.id_tipo=mnt_tipo_orden.id_tipo "
                . "LEFT JOIN mnt_asigna_cuadrilla ON mnt_orden_trabajo.id_orden=mnt_asigna_cuadrilla.id_ordenes "
                . "LEFT JOIN mnt_cuadrilla ON mnt_asigna_cuadrilla.id_cuadrilla=mnt_cuadrilla.id "
                . "LEFT JOIN mnt_responsable_orden ON mnt_orden_trabajo.id_orden=mnt_responsable_orden.id_orden_trabajo "; 
   
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
            /* aqui se evalua si es autoridad o asistente de autoridad para dirigirlo a la vista respectiva */
            if (($this->session->userdata('user')['sys_rol'] == 'asist_autoridad')|| ($this->session->userdata('user')['sys_rol'] == 'autoridad')||($this->session->userdata('user')['sys_rol'] == 'jefe_mnt')):
                $row[] = '<div align="center"><a href="'.base_url().'index.php/mnt_solicitudes/detalle/'.$sol['id_orden'].'">'.$sol['id_orden'].'</a></div>';
            else:
                $row[] = '<div align="center"><a href="'.base_url().'index.php/mnt_solicitudes/detalles/'.$sol['id_orden'].'">'.$sol['id_orden'].'</a></div>';
            endif; 
            $row[] = '<div align="center">'.date("d/m/Y", strtotime($sol['fecha'])).'</div>';
            if(!empty($est))://Evalua el est no este vacio
                $row[] = '<div align="center">'.date("d/m/Y", strtotime($this->model_mnt_estatus_orden->get_first_fecha($sol['id_orden']))).'</div>';
            endif;
            $row[] = $sol['dependen'];
            $row[] = $sol['asunto'];
            if(empty($est)):
                $row[] = '<div align="center">'.$sol['descripcion'].'</div>';
                switch ($sol['descripcion']):
                    case 'EN PROCESO':
                        $row[] = '<a  href="#estatus_sol'.$sol['id_orden'].'" data-toggle="modal" data-id="'.$sol['id_orden'].'"class="open-Modal"><div align="center" title="En proceso"><img src="'.base_url()."assets/img/mnt/proceso.png".'" class="img-rounded" alt="bordes redondeados" width="25" height="25"></a>';
                    break;
                    case 'CERRADA':
                        $row[] = '<a  href="#estatus_sol'.$sol['id_orden'].'" data-toggle="modal" data-id="'.$sol['id_orden'].'"class="open-Modal"><div align="center" title="Cerrada"><img src="'.base_url()."assets/img/mnt/cerrar.png".'" class="img-rounded" alt="bordes redondeados" width="25" height="25"></a>';
                    break;
                    case 'ANULADA':
                        $row[] = '<a  href="#estatus_sol'.$sol['id_orden'].'" data-toggle="modal" data-id="'.$sol['id_orden'].'"class="open-Modal"><div align="center" title="Anulada"><img src="'.base_url()."assets/img/mnt/anulada.png".'" class="img-rounded" alt="bordes redondeados" width="25" height="25"></a>';
                    break;
                    case 'PENDIENTE POR MATERIAL':
                        $row[] = '<a  href="#estatus_sol'.$sol['id_orden'].'" data-toggle="modal" data-id="'.$sol['id_orden'].'"class="open-Modal"><div align="center" title="Pendiente por material"><img src="'.base_url()."assets/img/mnt/material.png".'" class="img-rounded" alt="bordes redondeados" width="25" height="25"></a>';
                    break;
                    case 'PENDIENTE POR PERSONAL':
                        $row[] = '<a  href="#estatus_sol'.$sol['id_orden'].'" data-toggle="modal" data-id="'.$sol['id_orden'].'"class="open-Modal"><div align="center" title="Pendiente por personal"><img src="'.base_url()."assets/img/mnt/empleado.png".'" class="img-rounded" alt="bordes redondeados" width="25" height="25"></a>';
                    break;
                    default: 
                        $row[]= '<a href="#estatus_sol'.$sol['id_orden'].'" data-toggle="modal" data-id="'.$sol['id_orden'].'" class="open-Modal" ><div align="center" title="Abierta"><img src="'.base_url()."assets/img/mnt/abrir.png".'" class="img-rounded" alt="bordes redondeados" width="25" height="25"></div>';
                endswitch;
            endif;
            $aux = '<div id="cuad'.$sol['id_orden'].'" class="modal modal-message modal-info fade" tabindex="-1" role="dialog" aria-labelledby="cuadrilla" >
                        <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                             <label class="modal-title">Asignar Cuadrilla</label>
                            <span><i class="glyphicon glyphicon-pushpin"></i></span>
                        </div>
                        <div class="modal-body row">
                            <div class="col-md-12">
                                <h4><label>Solicitud Número:
                                        <label name="data" id="data"></label>
                                    </label>
                                </h4>
                            </div>
                            <div class="col-md-6">
                                <label class="control-label" for = "tipo">Tipo:</label>
                                    <label class="control-label" id="tipo"></label>
                            </div>
                            <div class="col-md-6">
                                <label class="control-label" for = "tipo">Asunto:</label>
                                <label class="control-label" id="asunto"></label>
                            </div>
                             <form class="form" action="'.base_url().'index.php/mnt_asigna_cuadrilla/mnt_asigna_cuadrilla/asignar_cuadrilla" method="post" name="modifica" id="modifica">';
                                        if (($sol['tiene_cuadrilla']== 'si') || (empty($sol['tiene_cuadrilla'])))
                                        {
                                            if (empty($sol['cuadrilla']))
                                            {
                                            $aux=$aux.'<input type ="hidden" id="num_sol" name="num_sol" value="'.$sol['id_orden'].'">
                                                <div class="col-md-2">
                                                    <label class="control-label" for="cuadrilla">Cuadrilla</label>
                                                </div>
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <select class = "form-control select2" id = "cuadrilla_select'.$sol['id_orden'].'" name="cuadrilla_select" onchange="mostrar(this.form.num_sol, this.form.cuadrilla_select, this.form.responsable, ($(' . "'#".$sol['id_orden']."'" . ')))">
                                                            <option></option>';
                                                            foreach ($cuadri as $cuad)
                                                            {
                                                                $aux=$aux.'<option value = "'.$cuad->id.'">'.$cuad->cuadrilla.'</option>';
                                                            }
                                                        $aux=$aux.'</select>
                                                    </div>
                                                </div>
                                                <div class="col-md-12">
                                                    <label class="control-label" for = "responsable">Responsable de la orden</label>
                                                </div>
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <select class = "form-control select2" id = "responsable" name="responsable">
                                                            <option></option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div id= "test" class="col-md-12">
                                                    <br>
                                                    <div id="<'.$sol['id_orden'].'">
                                                    <!--aqui se muestra la tabla de las cuadrillas-->
                                                    </div>
                                                </div>';
                                            }
                                            else
                                            {
                                                $aux=$aux.'<input type ="hidden" id="cut" name="cut" value="'.$sol['id_orden'].'">
                                                    <input type ="hidden" id="cuadrilla" name="cuadrilla" value="'.$sol['id_cuadrilla'].'">'
                                                    . '<div class="col-md-6">
                                                            <label>Jefe de cuadrilla:</label>
                                                            <label name="respon" id="respon<'.$sol['id_orden'].'"></label>
                                                        </div>
                                                        <div class="col-md-3"></div>
                                                        <div class="col-md-12">
                                                            <div class="col-md-5">
                                                            <label>Responsable de la orden:</label>
                                                            </div>
                                                            <div class="input-group input-group">                                                   
                                                                <select title="Responsable de la orden" class = "form-control" id = "responsable'.$sol['id_orden'].'" name="responsable" disabled>
                                                    
                                                                </select>
                                                                <span class="input-group-addon">
                                                                    <label class="fancy-checkbox" title="Haz click para editar responsable">
                                                                        <input  type="checkbox"  id="mod_resp<'.$sol['id_orden'].'"/>
                                                                        <i class="fa fa-fw fa-edit checked" style="color:#D9534F"></i>
                                                                        <i class="fa fa-fw fa-pencil unchecked "></i>
                                                                    </label>
                                                                </span>
                                                </div><!-- /input-group--</div>-->
                                                <br>
                                            <!--<br>-->
                                                <div class="col-lg-12"></div>
                                                <div class="col-lg-14">
                                                <!--<div class="col-md-6"><label for = "responsable">Miembros de la Cuadrilla</label></div>-->
                                                    <div id="show_signed<'.$sol['id_orden'].'" >
                                                      <!--mostrara la tabla de la cuadrilla asignada-->   
                                                    </div>
                                                </div>
                                                <br>
                                                <div class="col-lg-12">
                                                    <div class="form-control alert-success" align="center">
                                                        <label class="checkbox-inline"> 
                                                            <input type="checkbox" id="otro'.$sol['id_orden'].'" value="opcion_1">Quitar asignación de la cuadrilla
                                                        </label>        
                                                    </div>
                                                </div>
                                                <br> 

                                                        </div>
                                                       </div>
                                                        ';
                                            }
                                        }
                                          $aux=$aux.'<div class="modal-footer">
                                                        <div class = "col-md-12">
                                                            <input  type="hidden" name="uri" value="<'.$this->uri->uri_string().'"/>
                                                            <button type="button" class="btn btn-default" data-dismiss="modal" aria-hidden="true">Cancelar</button>
                                                      
                                                                <button type="submit" id="'.$sol['id_orden'].'" class="btn btn-primary">Guardar cambios</button>
                                                     
                                                        </div>
                                                    </div>
                                                </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    </div>';
            if (!empty($sol['cuadrilla']))
            {
                $row[]= '<a href="#cuad'.$sol['id_orden'].'" data-toggle="modal" data-id="'.$sol['id_orden'].'" data-asunto="'.$sol['asunto'].'" data-tipo_sol="'.$sol['tipo_orden'].'" class="open-Modal" onclick="cuad_asignada($(' . "'".'#responsable'.$sol['id_orden']."'" . '),($(' . "'".'#respon'.$sol['id_orden']."'" . ')),' . "'".$sol['id_orden']."'" . ',' . "'".$sol['id_cuadrilla']."'" . ', ($(' . "'".'#show_signed'.$sol['id_orden']."'" . ')), ($(' . "'".'#otro'.$sol['id_orden']."'" . ')),($(' . "'".'#mod_resp'.$sol['id_orden']."'" . ')))" ><div align="center"> <img title="Cuadrilla asignada" src="'.base_url().$sol['icono'].'" class="img-rounded" alt="bordes redondeados" width="25" height="25"></div></a>'.$aux;
            }
            else
            {
                $row[]= '<a href="#cuad'.$sol['id_orden'].'" data-toggle="modal" data-id="'.$sol['id_orden'].'" data-asunto="'.$sol['asunto'].'" data-tipo_sol="'.$sol['tipo_orden'].'" class="open-Modal" onclick="cuad_asignada($(' . "'".'#responsable'.$sol['id_orden']."'" . '),($(' . "'".'#respon'.$sol['id_orden']."'" . ')),' . "'".$sol['id_orden']."'" . ',' . "'".$sol['id_cuadrilla']."'" . ', ($(' . "'".'#show_signed'.$sol['id_orden']."'" . ')), ($(' . "'".'#otro'.$sol['id_orden']."'" . ')),($(' . "'".'#mod_resp'.$sol['id_orden']."'" . ')))" ><div align="center"> <i title="Asignar cuadrilla" class="glyphicon glyphicon-pencil" style="color:#D9534F"></i></div></a>'.$aux;
            }
            if(in_array(array('id_orden_trabajo' => $sol['id_orden']), $ayuEnSol))
            {
                $a= ('<i title="Agregar ayudantes" class="glyphicon glyphicon-plus" style="color:#5BC0DE"></i>');
            }
            else
            {  
                $a = ('<i title="Asignar ayudantes" class="glyphicon glyphicon-pencil" style="color:#D9534F"></i>');
            }
                $row[]= '<a href="#ayudante'.$sol['id_orden'].'" data-toggle="modal" data-id="'.$sol['id_orden'].'" data-asunto="'.$sol['asunto'].'" data-tipo_sol="'.$sol['tipo_orden'].'" class="open-Modal" onclick="ayudantes($(' . "'".'#mod_resp'.$sol['id_orden']."'" . '),$(' . "'".'#responsable'.$sol['id_orden']."'" . '),' . "'".$sol['estatus']."'" . ',' . "'".$sol['id_orden']."'" . ', ($(' . "'".'#disponibles'.$sol['id_orden']."'" . ')), ($(' . "'".'#asignados'.$sol['id_orden']."'" . ')))"><div align="center">'.$a.'</div></a>';
            if(!empty($est))
            {
                if (($sol['descripcion'] == 'CERRADA') && empty($sol['sugerencia']))
                {
                    $row[] = '<a href="#sugerencias'.$sol['id_orden'].'" data-toggle="modal" data-id="'.$sol['id_orden'].'" class="open-Modal"><div align="center" title="Calificar"><img src="'.base_url()."assets/img/mnt/opinion.png".'" class="img-rounded" alt="bordes redondeados" width="25" height="25"></div></a>';
                }
                elseif (($sol['descripcion'] == 'CERRADA') && (!empty($sol['sugerencia'])))
                {
                    $row[] = '<a href="#sugerencias'.$sol['id_orden'].'" data-toggle="modal" data-id="'.$sol['id_orden'].'" class="open-Modal"><div align="center" title="Calificar"><img src="'.base_url()."assets/img/mnt/opinion1.png".'" class="img-rounded" alt="bordes redondeados" width="25" height="25"></div></a>';
                }
                else
                {
                    $row[] = '<div align="center"><span class="label label-warning">'.$sol['descripcion'].'</span></div>';
                }
            }
            $output['data'][] = $row;
        endforeach;
        return $output;// Para retornar los datos al controlador
    }
 
    public function get_ordenes() {//Para obtener todas las ordenes que sean diferentes de cerrada
        // SE EXTRAEN TODOS LOS DATOS DE LA TABLA 
        $this->db->order_by("id_orden", "desc");
//        $this->db->where_not_in('descripcion','CERRADA');
        $opciones = array('CERRADA', 'ANULADA');
        $this->db->where_not_in('descripcion',$opciones);
    if ($this->session->userdata('user')['sys_rol'] == 'asist_autoridad'): 
        $this->db->where('descripcion','EN PROCESO');
    endif;
        $query = $this->unir_tablas();
        $query = $this->db->get('mnt_orden_trabajo');
        //die_pre($query->result());
        return $query->result_array();
    }
    
      public function get_ordenes_close() {//Para obtener todas las ordenes que esten cerradas
        // SE EXTRAEN TODOS LOS DATOS DE LA TABLA 
        $this->db->order_by("id_orden", "desc");
        $opciones = array('ANULADA', 'CERRADA');
        $this->db->where_in('descripcion',$opciones);
//        $this->db->where('descripcion','CERRADA');
        $query = $this->unir_tablas();
        $query = $this->db->get('mnt_orden_trabajo')->result_array();
        //die_pre($query);
        foreach ($query as $key => $soli)
         {
            $result[$key] = $soli;
            $result[$key]['creada'] = $this->model_mnt_estatus_orden->get_first_fecha($soli['id_orden']);
        }
        //die_pre($result);
        if (!empty($result)):
          return $result;
        else:
          return $query;//valor temporal del query..Solo se usa para que no de error en la vista
        endif;
        
    }

   
     public function get_ordenes_dep($dep='') {//Para obtener todas las ordenes por departamento que sean diferentes de cerrada
        // SE EXTRAEN TODOS LOS DATOS DE LA TABLA CON RESPECTO A LA DEPENDENCIA DEL USUARIO
        $this->db->where('dependencia',$dep);
        $opciones = array('CERRADA', 'ANULADA');
        $this->db->where_not_in('descripcion',$opciones);
        $this->db->order_by("id_orden", "desc");
        $query = $this->unir_tablas();
        $query = $this->db->get('mnt_orden_trabajo');
        //die_pre($query->result());
        return $query->result_array();
    }
    
     public function get_ordenes_dep_close($dep='') {//Para obtener todas las ordenes por departamento que esten cerradas
        // SE EXTRAEN TODOS LOS DATOS DE LA TABLA CON RESPECTO A LA DEPENDENCIA DEL USUARIO
        $this->db->where('dependencia',$dep);
        $opciones = array('ANULADA', 'CERRADA');
        $this->db->where_in('descripcion',$opciones);
        $this->db->order_by("id_orden", "desc");
        $query = $this->unir_tablas();
        $query = $this->db->get('mnt_orden_trabajo')->result_array();
         foreach ($query as $key => $soli)
         {
            $result[$key] = $soli;
            $result[$key]['creada'] = $this->model_mnt_estatus_orden->get_first_fecha($soli['id_orden']);
        }
        //die_pre($result);
       if (!empty($result)):
          return $result;//retorna el valor con la fecha de creacion de la solicitud
        else:
          return $query;//valor temporal del query..Solo se usa para que no de error en la vista
        endif;
    }

    public function unir_tablas() {//funcion para unir las tablas con llaves foraneas y devuelve todo en una variable
//agregado el join, funciona de la siguiente manera:
//$this->db->join('tabla que contiene la clave','tabla que contiene la clave.campo que la relaciona'='tabla principal.campo de relacion̈́','INNER')
        $unir = $this->db->join('mnt_tipo_orden', 'mnt_tipo_orden.id_tipo = mnt_orden_trabajo.id_tipo', 'INNER');
        $this->db->join('dec_dependencia', 'dec_dependencia.id_dependencia = mnt_orden_trabajo.dependencia', 'INNER');
//        $this->db->join('mnt_ubicaciones_dep', 'mnt_ubicaciones_dep.id_dependencia = mnt_orden_trabajo.dependencia', 'INNER');
       // $this->db->join('mnt_observacion_orden', 'mnt_observacion_orden.id_orden_trabajo = mnt_orden_trabajo.id_orden', 'INNER');
//        $this->db->join('mnt_estatus_orden', 'mnt_estatus_orden.id_orden_trabajo = mnt_orden_trabajo.id_orden', 'INNER');
        $this->db->join('mnt_estatus', 'mnt_estatus.id_estado = mnt_orden_trabajo.estatus', 'INNER');
        $this->db->join('mnt_asigna_cuadrilla', 'mnt_asigna_cuadrilla.id_ordenes = mnt_orden_trabajo.id_orden', 'LEFT');
        $this->db->join('mnt_cuadrilla', 'mnt_cuadrilla.id = mnt_asigna_cuadrilla.id_cuadrilla ', 'LEFT');
        $this->db->join('mnt_responsable_orden', 'mnt_responsable_orden.id_orden_trabajo = mnt_orden_trabajo.id_orden ', 'LEFT');
//        $this->db->join('mnt_ayudante_orden', 'mnt_ayudante_orden.id_orden_trabajo = mnt_orden_trabajo.id_orden', 'LEFT');
        //$this->db->select('id_usuario','nombre','apellido');
        //$this->db->from('dec_usuario');
        //$this->db->join('dec_usuario', 'dec_usuario.id_usuario = mnt_cuadrilla.id_trabajador_responsable', 'LEFT');
        return $unir;
    }

    public function get_orden($id_orden = '') {
        if (!empty($id_orden)) {
            $this->db->where('id_orden', $id_orden);
            $query = $this->unir_tablas();
            $query = $this->db->get('mnt_orden_trabajo');
            return $query->row_array();
        }
        return FALSE;
    }

    public function buscar_sol($busca = '', $fecha = '', $field = '', $order = '', $per_page = '', $offset = '') {
        //die('llega');
        //echo_pre($busca);
        if (!empty($busca)) {

            if (!empty($field)) {
                $this->db->order_by($field, $order);
            }
            $busca = preg_split("/[,]+/", $busca);
            $first = $busca[0];
            if (!empty($busca[1])) {
                $second = $busca[1];
                $this->db->like('dependen', $second);
            }
            if (!empty($busca[2])) {
                $third = $busca[2];
                $this->db->like('descripcion', $third);
            }
            if (!empty($busca[3])) {
                $four = $busca[3];
                $this->db->like('cuadrilla', $four);
            }
//            if (!empty($orden[4])) {
//                $five = $orden[4];
//                $this->db->like('cuadrilla', $five);
//            }           

            $this->db->like('id_orden', $first);
            $this->db->or_like('dependen', $first);
            $this->db->or_like('descripcion', $first);
            $this->db->or_like('cuadrilla', $first);
            //echo_pre($orden);
            //echo_pre($first);
            $query = $this->unir_tablas();
            //die_pre($this->unir_tablas());
            if (!empty($per_page) && !empty($offset)) {
                $query = $this->db->get('mnt_orden_trabajo', $per_page, $offset);
                return $query->result();
            } else {
                //echo_pre($query);
                $query = $this->db->get('mnt_orden_trabajo', $per_page, $offset);
                return $query->result();
            }
        } else {
            //echo_pre('hola');
            if (!empty($fecha)):
                $fecha = preg_split("/al/", $fecha);
                $fecha11 = $fecha[0] . " 00:00:00";
                $fecha12 = $fecha[1] . " 23:59:59";
                $fecha11 = str_replace("/", "-", $fecha11);
                $fecha12 = str_replace("/", "-", $fecha12);
                $fecha1 = date("Y-m-d H:i:s ", strtotime($fecha11));
                $fecha2 = date("Y-m-d H:i:s", strtotime($fecha12));
                $query = $this->unir_tablas();
                $this->db->where("fecha_p BETWEEN '$fecha1' AND '$fecha2'");
                $query = $this->db->get('mnt_orden_trabajo', $per_page, $offset);
                //echo_pre($query->result());
                return $query->result();
            endif;
        }

        return FALSE;
    }

    public function buscar_solCount($orden = '', $fecha = '') {
        if (!empty($orden)) {
            $orden = preg_split("/[\s,]+/", $orden);
            $first = $orden[0];

            if (!empty($orden[1])) {
                $second = $orden[1];
                $this->db->like('dependen', $second);
            }
            if (!empty($orden[2])) {
                $third = $orden[2];
                $this->db->like('descripcion', $third);
            }
            if (!empty($orden[3])) {
                $four = $orden[3];
                $this->db->like('cuadrilla', $four);
            }
//            if (!empty($orden[4])) {
//                $five = $orden[4];
//                $this->db->like('cuadrilla', $five);
//            }
            $this->db->like('id_orden', $first);
            $this->db->or_like('dependen', $first);
            $this->db->or_like('descripcion', $first);
            $this->db->or_like('cuadrilla', $first);
            $query = $this->unir_tablas();
            return $this->db->count_all_results('mnt_orden_trabajo');
        } else {
            if (!empty($fecha)):
                //$fecha = $_POST['fecha'];
                $fecha = preg_split("/al/", $fecha);
                $fecha11 = $fecha[0] . "00:00:00";
                $fecha12 = $fecha[1] . "23:59:59";
                $fecha11 = str_replace("/", "-", $fecha11);
                $fecha12 = str_replace("/", "-", $fecha12);
                $fecha1 = date("Y-m-d H:i:s ", strtotime($fecha11));
                $fecha2 = date("Y-m-d H:i:s", strtotime($fecha12));
//                echo_pre($fecha1);
//                echo_pre($fecha2);
                //$where = "fecha_p = '2015-05-08 13:14:39' OR fecha_p = '2015-05-18 16:24:58'";
                //$where = "fecha_p = '2015-05-08 13:14:39'";
//                $this->db->where("fecha_p = '2015-05-08 13:14:39'");
//                $this->db->where("fecha_p = '2015-05-18 16:24:58'");
                $query = $this->unir_tablas();
                $this->db->where("fecha_p BETWEEN '$fecha1' AND '$fecha2'");
                $query = $this->db->get('mnt_orden_trabajo');
                //echo_pre($query->result());
                return $this->db->count_all_results('mnt_orden_trabajo');
            endif;
        }
        return FALSE;
    }

    // FUNCION PARA INSERTAR -- FORMULARIO NATALY
    public function insert_orden($data1 = '') {
        if (!empty($data1)) {
            //die_pre($data1);
            $this->db->insert('mnt_orden_trabajo', $data1);
            return $this->db->insert_id();
        }
        return FALSE;
    }

    public function actualizar_orden($data = '', $id_orden = '') {
        if (!empty($data)) {
            $this->db->where('id', $id_orden);
            $this->db->update('mnt_orden_trabajo', $data);//hay un error en la modificacion al momento de pasar la columna ubicacion, siendo un not null 
        }
        return FALSE;
    }

    public function ajax_likeSols($data) {
        $query = $this->unir_tablas();
        $this->db->like('id_orden', $data);
        $this->db->or_like('cuadrilla', $data);
        $this->db->or_like('dependen', $data);
        $this->db->or_like('descripcion', $data);
        //$this->db->or_like('estatus',$data);
        $query = $this->db->get('mnt_orden_trabajo');
        return $query->result();
    }

}
