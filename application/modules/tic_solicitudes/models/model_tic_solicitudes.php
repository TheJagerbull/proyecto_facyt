<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Model_tic_solicitudes extends CI_Model {

    //constructor predeterminado del modelo
    function __construct() {
        parent::__construct();
        $this->load->module('dec_permiso/dec_permiso');
    }
    
    var $table = 'tic_orden_trabajo'; //El nombre de la tabla que estamos usando
            
    public function get_all() {
        return($this->db->count_all('tic_orden_trabajo'));
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
        $query = $this->db->get('tic_orden_trabajo', $per_page, $offset);
        //die_pre($query->result());
        return $query->result();
    }
    
    //Esta es la funcion que trabaja correctamente al momento de cargar los datos desde el servidor para el datatable 
    function get_list($est='',$dep=''){
        $ayuEnSol = $this->model_tic_ayudante->array_of_orders(); //Para consultar los ayudantes asignados a una orden
        $cuadri = $this->model_cuadrilla->get_cuadrillas();
        $estatus = $this->model_estatus->get_estatus2();
        /* Array de las columnas para la table que deben leerse y luego ser enviados al DataTables. Usar ' ' donde
         * se desee usar un campo que no este en la base de datos
         */
        $aColumns = array('id_orden','fecha','dependen','asunto','descripcion','cuadrilla','tiene_cuadrilla','tipo_orden','id_cuadrilla','estatus','icono','sugerencia','id_responsable','star');
  
        /* Indexed column (se usa para definir la cardinalidad de la tabla) */
        $sIndexColumn = "id_orden";
        
        /* $filtro (Se usa para filtrar la vista del Asistente de autoridad) La intencion de usar esta variable
        es para usarla en el query que se va a construir mas adelante. Este datos es modificable */
        if ($this->dec_permiso->has_permission('tic',11)): 
            $filtro = "WHERE estatus = 2"; /* Para filtrar por estatus en proceso */
        else:
            $filtro = "WHERE estatus NOT IN (3,4)";
        endif;
        if(($est=='close'))://Evalua el estado de las solicitudes para crear la vista en Solicitudes cerradas
             $filtro = "WHERE estatus IN (3)";
        endif;
         if(($est=='anuladas'))://Evalua el estado de las solicitudes para crear la vista en Solicitudes anuladas
             $filtro = "WHERE estatus IN (4)";
        endif;
        if(!$this->dec_permiso->has_permission('tic',9))://Evalua si viene de un departamento
            $filtro = "WHERE estatus NOT IN (3,4) AND dependencia = $_GET[dep]";
        endif;
        if(!$this->dec_permiso->has_permission('tic',9) && $this->dec_permiso->has_permission('tic',11))://Evalua si viene de un departamento y estatus en proceso 
            $filtro = "WHERE dependencia = $_GET[dep] AND estatus = 2";
        endif;
        if(!$this->dec_permiso->has_permission('tic',9) && $est=='close')://Evalua si viene de un departamento y no es autoridad y estan en la vista de sol cerradas/anuladas 
            $filtro = "WHERE dependencia = $_GET[dep] AND estatus IN (3)";
        endif;
          if(!$this->dec_permiso->has_permission('tic',9) && $est=='anuladas')://Evalua si viene de un departamento y no es autoridad y estan en la vista de sol cerradas/anuladas 
            $filtro = "WHERE dependencia = $_GET[dep] AND estatus IN (4)";
        endif;
        if ($this->model_cuadrilla->es_responsable($this->session->userdata('user')['id_usuario'])) {//PARA evaluar si es responsable de una cuadrilla
            if (strtoupper($this->session->userdata('user')['cargo']) != 'JEFE DE MANTENIMIENTO') {//Evalua si no es el jefe de mantenimiento
                $band = 1;
                $info = $this->model_cuadrilla->es_responsable($this->session->userdata('user')['id_usuario'], '', $band);
                $id_cuad = $info[0]['id'];
                $cuadrilla = ($info[0]['cuadrilla']);
                if($this->model_tipo->devuelve_id_tipo($cuadrilla)):
                    $id_tipo = $this->model_tipo->devuelve_id_tipo($cuadrilla);
                else:
                    $id_tipo = 0;
                endif;
//                echo_pre($id_tipo);
                if (isset($filtro)):
                    $filtro .= " AND tic_orden_trabajo.id_tipo = $id_tipo";
                else:
                    $filtro = "WHERE tic_orden_trabajo.id_tipo = $id_tipo";
                endif;
            }
        }
//        die_pre($filtro);
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
        if (isset($sSearchVal) && $sSearchVal != '[object+Object]+[object+Object]'): //SE evalua si esta vacio o existe
            $sWhere = "AND (";  //Se comienza a almacenar la sentencia sql
            for ($i = 0; $i < count($aColumns); $i++): //se abre el for para buscar en todas las columnas que leemos de la tabla
                $sWhere .= $aColumns[$i] . " LIKE '%" . $this->db->escape_like_str($sSearchVal) . "%' OR ";// se concatena con Like 
            endfor;
            $sWhere = substr_replace($sWhere, "", -3);
            $sWhere .= ')'; //Se cierra la sentencia sql
        endif;
        
        /* Filtro de busqueda individual */
        $sSearchReg = $arr['search[regex]'];
        for ($i = 0; $i < count($aColumns)-6; $i++):
            $bSearchable_ = $arr['columns[' . $i . '][searchable]'];
            if (isset($bSearchable_) && $bSearchable_ == "true" && $sSearchReg != 'false'):
                $sSearchVal = $arr['columns[' . $i . '][search][value]'];
                if ($sWhere == ""):
                    $sWhere = " AND ";
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
        if($this->db->escape_like_str($sSearchVal) != "[object+Object]+[object+Object]" AND $_GET['uno'] != "" AND $_GET['uno'] != ""):
            $sWhere = "AND fecha BETWEEN '$_GET[uno]' AND '$_GET[dos]' AND(";
            for ($i = 0; $i < count($aColumns); $i++):
                $sWhere .= $aColumns[$i] . " LIKE '%" . $this->db->escape_like_str($sSearchVal) . "%' OR ";
            endfor;
            $sWhere = substr_replace($sWhere, "", -3);
            $sWhere .= ')';
        endif;    
//        echo_pre($sWhere);
         /*
         * SQL queries
         * Aqui se obtienen los datos a mostrar
          * sJoin creada para el proposito de unir las tablas en una sola variable 
         */
        $sJoin = "INNER JOIN dec_dependencia ON tic_orden_trabajo.dependencia=dec_dependencia.id_dependencia "
                . "INNER JOIN mnt_estatus ON tic_orden_trabajo.estatus=mnt_estatus.id_estado "
                . "INNER JOIN tic_tipo_orden ON tic_orden_trabajo.id_tipo=tic_tipo_orden.id_tipo "
                . "LEFT JOIN tic_asigna_cuadrilla ON tic_orden_trabajo.id_orden=tic_asigna_cuadrilla.id_ordenes "
                . "LEFT JOIN tic_cuadrilla ON tic_asigna_cuadrilla.id_cuadrilla=tic_cuadrilla.id "
                . "LEFT JOIN tic_responsable_orden ON tic_orden_trabajo.id_orden=tic_responsable_orden.id_orden_trabajo "; 
               
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
//        echo_pre($rResult->result_array());
        //Aqui se crea el array que va a contener todos los datos que se necesitan para el datatable a medida que se obtienen de la tabla
        foreach ($rResult->result_array() as $sol):
            $row = array();
            /* aqui se evalua si es tiene permiso para ver el detalle de la solicitud */  
            if($this->dec_permiso->has_permission ('tic',13) || $this->dec_permiso->has_permission ('tic',16)):
                $row[] = '<a href="'.base_url().'tic_solicitudes/detalle/'.$sol['id_orden'].'">'.$sol['id_orden'].'</a>';
            else:
                $row[] = $sol['id_orden'];
            endif; 
            $row[] = date("d/m/Y", strtotime($sol['fecha']));
            if(!empty($est))://Evalua el est no este vacio
                $row[] = date("d/m/Y", strtotime($this->model_tic_estatus_orden->get_first_fecha($sol['id_orden'])));
            endif;
            $row[] = $sol['dependen'];
            $row[] = $sol['asunto'];

            if(empty($est))
            {
                $row[] = '<div align="center">'.$sol['descripcion'].'</div>';
//            Modal para cambiar el estatus de una solicitud-->
//                Mod by jcparra 28/03/2017
                $title1 = "<label class=\'modal-title\'>Cambiar Estatus<\/label><i class=\'fa fa-tasks\' aria-hidden=\'true\'><\/i>";
                $cuerpo1 = "<div class=\'well well-sm\'>";
                $cuerpo1 .= "<form class=\'form\' action=\'".base_url()."tic_estatus_orden\/cambiar_estatus\' method=\'post\' name=\'edita\' id=\'edita".$sol['id_orden']."\' onsubmit= if($(\'#".$sol['id_orden']."\')){return(valida_motivo($(\'#motivo".$sol['id_orden']."\')));}>";
                $cuerpo1 .= "<input type=\'hidden\' name=\'uri\' value=\'tic_solicitudes\/lista_solicitudes\'\/>";
                $cuerpo1 .= "<div class=\'row\'>"
                                ."<div class=\'col-md-12\'>"
                                    ."<div class=\'form-group\'>"
                                        ."<label class=\'control-label\' for = \'estatus\'>Estatus:<\/label>"
                                        ."<input type=\'hidden\' id=\'orden\' name=\'orden\' value=\'".$sol['id_orden']."\'>"
                                        ."<input type=\'hidden\' id=\'id_cu\' name=\'id_cu\' value=\'".$sol['id_cuadrilla']."\'>";
//                                     SWITCH PARA EVALUAR OPCIONES DEL ESTATUS DE LA SOLICITUD
                                        $estatus = $this->model_estatus->get_estatus2();
                                        switch ($sol['descripcion'])
                                        {
                                            case 'ANULADA':
                                                $cuerpo1.="<div class=\'alert alert-info\' align=\'center\'><strong>¡La solicitud fué anulada. No puede cambiar de estatus!<\/strong><\/div>";
                                                break;
                                            default:
                                            case 'PENDIENTE POR PERSONAL':
                                                $estatus_change = $this->model_estatus->get_estatus_pendpers();                                    
                                                $cuerpo1.="<select onmousemove=\'sel(this.form.select_estado)\' class=\'form-control\' id = \'sel".$sol['id_orden']."\' name=\'select_estado\'>"
                                                    ."<option value=\'\'><\/option>";
                                                foreach ($estatus_change as $es){ 
                                                    $cuerpo1.="<option value = \'".$es->id_estado."\'>".$es->descripcion."<\/option>";                                                   
                                                };
                                                $cuerpo1.= "<\/select><div id=\'".$sol['id_orden']."\' name= \'observacion\'>"
                                                ."<label class=\'control-label\' for=\'observacion\'>Motivo:<\/label>"
                                                    ."<div class=\'control-label col-md-12\'>"
                                                        ."<textarea rows=\'3\' autocomplete=\'off\' type=\'text\' onKeyDown=contador(this.form.motivo,($(\"#quitar".$sol['id_orden']."\')),160); onKeyUp=contador(this.form.motivo,($(\'#quitar".$sol['id_orden']."\')),160);"
                                                        ."value=\'\' style=\'text-transform:uppercase;\' onkeyup=javascript:this.value = this.value.toUpperCase(); class=\'form-control\' id=\'motivo".$sol['id_orden']."\' name=\'motivo\' placeholder=\'Indique el motivo...\'><\/textarea>"
                                                    ."<\/div>" 
                                                    ."<small><p align=\'right\' name=\'quitar\' id=\'quitar".$sol['id_orden']."\' size=\'4\'>0/160<\/p><\/small>"
                                                    ."<\/div>";
                                                break;
                                            default:    
                                            if (($sol['descripcion']!= 'EN PROCESO') && ($sol['descripcion']!= 'PENDIENTE POR MATERIAL') && ($sol['descripcion']!= 'PENDIENTE POR PERSONAL'))
                                            {
                                                $cuerpo1.="<div class=\'alert alert-warning\' align=\'center\'><strong>¡La solicitud está abierta. Debe asignar un personal!<\/strong><\/div>";
                                            }else{
                                                $cuerpo1.="<select onmousemove=\'sel(this.form.select_estado)\' class=\'form-control select2\' id = \'sel".$sol['id_orden']."\' name=\'select_estado\'>";
                                                    if($sol['descripcion']!= 'ABIERTA'){
                                                        $cuerpo1.="<option value=\'\'><\/option>";
                                                    }; 
                                                foreach ($estatus as $es){ 
                                                    if ($sol['descripcion'] != $es->descripcion){
                                                        $cuerpo1.="<option value = \'".$es->id_estado."\'>".$es->descripcion."<\/option>";
                                                    };
                                                };
                                            $cuerpo1.="<\/select>"
                                                ."<div id=\'".$sol['id_orden']."\' name= \'observacion\'>"
                                                    ."<label class=\'control-label\' for=\'observacion\'>Motivo:<\/label>"
                                                    ."<div class=\'control-label col-md-12\'>"
                                                        ."<textarea rows=\'3\' autocomplete=\'off\' type=\'text\' onKeyDown=contador(this.form.motivo,($(\'#quitar".$sol['id_orden']."\')),160); onKeyUp=contador(this.form.motivo,($(\'#quitar".$sol['id_orden']."\')),160); value=\'\'"
                                                        ."style=\'text-transform:uppercase;\' onkeyup=javascript:this.value = this.value.toUpperCase(); class=\'form-control\' id=\'motivo".$sol['id_orden']."\' name=\'motivo\' placeholder=\'Indique el motivo...\'><\/textarea>"
                                                            ."<small><p align=\'right\' name=\'quitar\' id=\'quitar".$sol['id_orden']."\' size=\'4\'>0/160<\/p><\/small>"
                                                    ."<\/div>"
                                                ."<\/div>";
                                            };
                                        break;
                                        }
                $cuerpo1.="<\/div>"
                    ."<\/div>";
                $footer1= "<button type=\'button\' class=\'btn btn-default\' data-dismiss=\'modal\' aria-hidden=\'true\'>Cancelar<\/button>";
                        if($sol['descripcion']!= 'ABIERTA'){
                            $footer1.="<button form=\'edita".$sol['id_orden']."\' type=\'submit\' class=\'btn btn-primary\' id=\'uno".$sol['id_orden']."\' >Enviar<\/button>";
                        };
//               <!-- /.Fin de modal estatus-->
                switch ($sol['descripcion'])
                {
                    case 'EN PROCESO':
                        $row[] = '<a title="En proceso" class="btn btn-link btn-xs" role="button" onclick="buildModal(('. "'est".$sol['id_orden']."'" . '),('. "'".$title1."'" . '),('. "'".$cuerpo1."'" . '),('."'" .$footer1."'" .'))"><img src="'.base_url()."assets/img/mnt/proceso.png".'" class="img-rounded" alt="bordes redondeados" width="25" height="25"></img></a>';
                    break;
                    case 'PENDIENTE POR MATERIAL':
                        $row[] = '<a title="Pendiente por material" class="btn btn-link btn-xs" role="button" onclick="buildModal(('. "'est".$sol['id_orden']."'" . '),('. "'".$title1."'" . '),('. "'".$cuerpo1."'" . '),('."'" .$footer1."'" .'))"><img src="'.base_url()."assets/img/mnt/material.png".'" class="img-rounded" alt="bordes redondeados" width="25" height="25"></img></a>';
                    break;
                    case 'PENDIENTE POR PERSONAL':
                        $row[] = '<a title="Pendiente por personal" class="btn btn-link btn-xs" role="button" onclick="buildModal(('. "'est".$sol['id_orden']."'" . '),('. "'".$title1."'" . '),('. "'".$cuerpo1."'" . '),('."'" .$footer1."'" .'))"><img src="'.base_url()."assets/img/mnt/empleado.png".'" class="img-rounded" alt="bordes redondeados" width="25" height="25"></img></a>';
                    break;
                    default: 
                        $row[]= '<a title="Abierta" class="btn btn-link btn-xs" role="button" onclick="buildModal(('. "'est".$sol['id_orden']."'" . '),('. "'".$title1."'" . '),('. "'".$cuerpo1."'" . '),('."'" .$footer1."'" .'))"><img src="'.base_url()."assets/img/mnt/abrir.png".'" class="img-rounded" alt="bordes redondeados" width="25" height="25"></img></a>';
                    break;
                }
            }
            //Mod construccion de modal para cuadrillas 06/03/2017 by jcparra
            if(empty($est) && !(isset($band))){
                $title = "<label class=\'modal-title\'>Asignar Cuadrilla<\/label>"
                        ."<span><i class=\'fa fa-users\' aria-hidden=\'true\'><\/i><\/span>";
            }else{
                $title="<label class=\'modal-title\'>Cuadrilla Asignada<\/label>"
                      ."<span><i class=\'fa fa-users\' aria-hidden=\'true\'><\/i><\/span>";
            }
            $cuerpo =   "<div class=\'row\' >"
                            ."<div class=\'col-md-12 text-center\'>"
                                ."<div class=\'well well-sm\'>" 
                                    ."Solicitud Número: <label name=\'data\' id=\'data\'>".$sol['id_orden']."<\/label>"
                                ."<\/div>"
                          ." <\/div>"
                        ."<\/div>"
                        ."<div class=\'row\'>"
                            ."<div class=\'col-md-6 text-center\'>"
                               ."<label class=\'control-label\' for = \'tipo\'>Tipo: ".$sol['tipo_orden']."<\/label>"
                            ."<\/div>"
                        ."<div class=\'col-md-6 text-center\'>"
                              ."<label class=\'control-label\' for = \'asunto\'>Asunto: ".$sol['asunto']."<\/label>"
                        ." <\/div>"
                        ."<\/div>"
                    . "<form class=\'form\' action=\'".base_url()."tic_asigna_cuadrilla\/tic_asigna_cuadrilla\/asignar_cuadrilla\' method=\'post\' name=\'modifica".$sol['id_orden']."\' id=\'modifica".$sol['id_orden']."\'>"
                    ."<input  type=\'hidden\' name=\'uri\' value=\'tic_solicitudes\/lista_solicitudes\'>";
            if(empty($est) && !(isset($band))){
                if (($sol['tiene_cuadrilla']== 'si') || (empty($sol['tiene_cuadrilla']))){
                    if (empty($sol['cuadrilla'])){
                        $cuerpo.= "<div class=\'well well-sm\'>"
                                        ."<input type =\'hidden\' id=\'num_sol\' name=\'num_sol\' value=\'" . $sol['id_orden'] . "\'>"
                                               ." <div class=\'row\'>" 
                                                 ."   <div class=\'col-md-12\'>"
                                                 ."       <label class=\'control-label\' for=\'cuadrilla\'>Cuadrilla<\/label>"
                                                  ."  <\/div>"
                                                   ." <div class=\'col-md-12\'>"
                                                       ."<select class = \'form-control input-sm select2\' onmousemove=\'sel(this.form.cuadrilla_select)\' id = \'cuadrilla_select".$sol['id_orden']."\' name=\'cuadrilla_select\' onchange=mostrar(this.form.num_sol,this.form.cuadrilla_select,this.form.responsable,$(\'#tab".$sol['id_orden']."\'),\'1\')>"
                                                     ."       <option><\/option>";
                                           
                        foreach ($cuadri as $c=>$cuad) {
                            if (isset($id_cuad)) {
                                if ($cuad->id == $id_cuad) {
                                    $cuerpo .= "<option value = \'".$cuadri[$c]->id."\'>".$cuadri[$c]->cuadrilla."<\/option>";
                                }
                            }else {
                                $cuerpo .= "<option value = \'".$cuad->id."\'>".$cuad->cuadrilla."<\/option>";
                            }
                        }
                        $cuerpo .= "<\/select>"
//                                                    
                                            ."      <\/div>"
                                            ."    <\/div>"
                                            ."    <div class=\'row\'>"
                                            ."        <div class=\'col-md-12\'>"
                                            ."            <label class=\'control-label\' for = \'responsable\'>Responsable de la orden<\/label>"
                                            ."        <\/div>"
                                            ."        <div class=\'col-md-12\'>"
                                            ."            <select class = \'form-control input-sm select2\' id = \'responsable".$sol['id_orden']."\' name=\'responsable\'>"
                                            ."                <option><\/option>"
                                            ."            <\/select>"
                                            ."   <\/div>"
                                            ."        <div id= \'test\' class=\'col-md-12\'>"
                                            ."            <div id=\'tab". $sol['id_orden']. "\' name=\'tab". $sol['id_orden']. "\' class=\'new\' >"
                                            ."              <!--aqui se muestra la tabla de las cuadrillas-->   "
                                            ."            <\/div>"
                                            ."        <\/div>"
                                            ."    <\/div>"
                        ."</div>";
                    }else{
                         $cuerpo.=  "<input type =\'hidden\' id=\'cut\' name=\'cut\' value=\'".$sol['id_orden']."\'>"
                                  ."<input type =\'hidden\' id=\'cuadrilla\' name=\'cuadrilla\' value=\'".$sol['id_cuadrilla']."\'>";  
                    }
                }else{
                    $cuerpo .= "<div class=\'row\'>"
                               ."<br\/>"
                               ."<div class=\'col-lg-12\'>"
                                    ."<div class=\'alert alert-warning\' style=\'text-align:center\'>No se puede asignar cuadrillas ya que un ayudante es responsable de la orden<\/div>"
                                    ."<\/div>"
                               ."<\/div>";
                }  
            }else{
                if (empty($sol['cuadrilla'])){
                    $cuerpo.="<div class=\'row\'>"
                                ."<div class=\'col-md-12\'>"
                                    ."<div class=\'alert alert-info\' align=\'center\'><strong>¡No hay cuadrilla asignada a esta solicitud<\/strong><\/div>"
                                ."<\/div>"
                            ."<\/div>";
                }
            }
//            $cuerpo.= "</form>";
            $footer = "<div class = \'col-md-12\'>"
                          ."<button type=\'button\' class=\'btn btn-default\' data-dismiss=\'modal\' aria-hidden=\'true\'>Cancelar<\/button>";
                            if(empty($est)&& !(isset($band))){
                                $footer.="<button type=\'submit\' form=\'modifica".$sol['id_orden']."\' class=\'btn btn-primary\'>Guardar cambios<\/button>";
                        }
            $footer.="<\/div>";
            //Fin Mod construccion de modal para cuadrillas 06/03/2017 by jcparra
        if(empty($est)&&!(isset($band))){                                           
            if (!empty($sol['cuadrilla']))
            {
                $row[]= '<a class="btn btn-link btn-xs" role="button" onclick="cuad_asignada((' . "'".$sol['id_orden']."'" . '),((' . "'".$sol['id_cuadrilla']."'" . ')),('. "'".$title."'" . '),('."'" .$cuerpo."'" .'),('."'" .$footer."'" .'),1,('."'1'" .'))" ><div align="center"> <img title="Cuadrilla asignada: '.$sol['cuadrilla'].'" src="'.base_url().$sol['icono'].'" class="img-rounded" alt="bordes redondeados" width="25" height="25"></div></a>';  
            }
            else
            {
                $row[]= '<a class="btn btn-link btn-xs" role="button" onclick="buildModal(('. "'".$sol['id_orden']."'" . '),('. "'".$title."'" . '),('. "'".$cuerpo."'" . '),('."'" .$footer."'" .'));sel('. "'"."#cuadrilla_select".$sol['id_orden']."'".')"><div align="center">  <i title="Asignar cuadrilla" class="glyphicon glyphicon-pencil fa-lg" style="color:#D9534F"></i></div></a>';
            }
        }else{
            if (!empty($sol['cuadrilla']))
            {
                $row[]= '<a class="btn btn-link btn-xs" role="button" onclick="cuad_asignada((' . "'".$sol['id_orden']."'" . '),(' . "'".$sol['id_cuadrilla']."'" . '), ('. "'".$title."'" . '),('."'" .$cuerpo."'" .'),('."'" .$footer."'" .'),1)" ><div align="center"> <img title="Cuadrilla asignada: '.$sol['cuadrilla'].'" src="'.base_url().$sol['icono'].'" class="img-rounded" alt="bordes redondeados" width="25" height="25"></div></a>';
            }
            else
            {
                $row[]= '<a class="btn btn-link btn-xs" role="button" onclick="buildModal(('. "'".$sol['id_orden']."'" . '),('. "'".$title."'" . '),('. "'".$cuerpo."'" . '),('."'" .$footer."'" .'))"><div align="center">  <i title="Sin asignar" class="glyphicon glyphicon-minus" style="color:#D9534F"></i></div></a>';
            }
            
        }
//            MODAL DE AYUDANTES
           //Mod jcparra 29/03/2017  
        if(empty($est)&&!(isset($band))){
            $titulo2 = "<label class=\'modal-title\'>Asignar Ayudantes<\/label>"
                    ."<span><i class=\'fa fa-user-plus\' aria-hidden=\'true\'><\/i><\span>";
        }else{
            $titulo2 = "<h4 class=\'modal-title\'>Ayudantes Asignados<\/h4>";
        }
        $cuerpo2 =  "<div class=\'row\' >"
                        ."<div class=\'col-md-12 text-center\'>"
                            ."<div class=\'well well-sm\'>" 
                                ."Solicitud Número: <label name=\'data\' id=\'data\'>".$sol['id_orden']."<\/label>"
                            ."<\/div>"
                        ." <\/div>"
                    ."<\/div>"
                    ."<div class=\'row\'>"
                        ."<div class=\'col-md-6 text-center\'>"
                            ."<label class=\'control-label\' for = \'tipo\'>Tipo: ".$sol['tipo_orden']."<\/label>"
                        ."<\/div>"
                        ."<div class=\'col-md-6 text-center\'>"
                            ."<label class=\'control-label\' for = \'asunto\'>Asunto: ".$sol['asunto']."<\/label>"
                        ." <\/div>"
                    ."<\/div>"
                    . "<form id=\'ay".$sol['id_orden']."\' class=\'form-horizontal\' action=\'".base_url()."tic/asignar/ayudante\' method=\'post\'>"
                    ."<div class=\'well well-sm\'>"
                    ."<div class=\'row\'>";
        if(empty($est) && !(isset($band))){
                $cuerpo2 .= "<div class=\'col-md-12\'>";
            if (empty($sol['cuadrilla'])){
                $cuerpo2 .= "<div class=\'col-md-5 text-center\'>"
                                . "<label>Responsable de la orden:<\/label>"
                            ."<\/div>";                             
                if(empty($sol['id_responsable'])){
                    $cuerpo2 .= "<div class=\'col-md-7\'>"
                                    ."<select title=\'Responsable de la orden\' class = \'form-control\' id = \'ayu_resp".$sol['id_orden']."\' name=\'responsable\'>"
                                      
                                    ."<\/select>"
                                ."<\/div>"
                            . "<br>";  
                }
                else{
                    $cuerpo2.=  "<div class=\'col-md-7\'>"
                                    ."<div class=\'input-group\'>"
                                        ."<select class = \'form-control\' id = \'ayu_resp".$sol['id_orden']."\' name=\'responsable\' disabled>"
                                        
                                        ."<\/select>"
                                        ."<span class=\'input-group-addon\'>"
                                            ."<label class=\'fancy-checkbox\' title=\'Haz click para editar responsable\'>"
                                                ."<input  type=\'checkbox\'  id=\'mod_resp".$sol['id_orden']."\'\/>"
                                                ."<i class=\'fa fa-fw fa-edit checked\' style=\'color:#D9534F\'><\/i>"
                                                ."<i class=\'fa fa-fw fa-pencil unchecked\'><\/i>"
                                            ."<\/label>"
                                        ."<\/span>"
                                    ."<\/div>"
                                ."<\/div>";
                }
            }
            else{
                $respon = $this->model_responsable->get_responsable($sol['id_orden']);
                $cuerpo2.= "<div class=\'col-md-12 text-center\'>"
                                ."<label>Responsable de la orden: ".$respon['nombre']." ".$respon['apellido']."<\/label>"
                            ."<\/div>";                              
            }
            $cuerpo2.=  "</div>";
            $cuerpo2.=  "<br>"
                        ."<div class=\'col-md-12\'>"
                            ."<ul id=\'myTab3\' class=\'nav nav-tabs\' role=\'tablist\'>"
                                ."<li class=\'active\'>"
                                    ."<a href=\'#tab-table1".$sol['id_orden']."\' data-toggle=\'tab\'>Ayudantes asignados<\/a>"
                                ."<\/li>"
                                ."<li>"
                                    ."<a href=\'#tab-table2".$sol['id_orden']."\' data-toggle=\'tab\'>Ayudantes disponibles<\/a>"
                                ."<\/li>"
                            ."<\/ul>"
                            ."<div class=\'tab-content\'>"
                                ."<div class=\'tab-pane active\' id=\'tab-table1".$sol['id_orden']."\'>"
                                    ."<div id=\'asignados".$sol['id_orden']."\'>"
                                        ."<!-- AQUI CONSTRULLE UNA LISTA DE AYUDANTES ASIGNADOS A LA ORDEN (revisar script mainFunctions.js linea 208 en adelante)-->"
                                    ."<\/div>"
                                ."<\/div>"
                                ."<div class=\'tab-pane\' id=\'tab-table2".$sol['id_orden']."\'>"
                                    ."<div id=\'disponibles".$sol['id_orden']."\'>"
                                        ."<!-- AQUI CONSTRULLE UNA LISTA DE AYUDANTES DISPONIBLES NO ASIGNADOS A LA ORDEN (revisar script mainFunctions.js linea 208 en adelante)-->"
                                    ."<\/div>"
                                ."<\/div>"
                            ."<\/div>"
                        ."<\/div>";    
            if ($sol['tiene_cuadrilla']== 'no'){     
                $cuerpo2.=  "<div class=\'col-lg-12\'>"
                                ."<div class=\'alert-success\' align=\'center\'>"
                                    ."<label class=\'checkbox-inline\'>" 
                                        ."<input type=\'checkbox\' id=\'otro".$sol['id_orden']."\' name=\'cut\' value=\'opcion_1\'>Quitar asignación de la orden"
                                    ."<\/label>"        
                                ."<\/div>"
                            ."<\/div>";
            }
        }else{
            if (empty($sol['cuadrilla'])){
                $cuerpo2.=  "<div class=\'col-md-5 text-center\'>"
                                ."<label>Responsable de la orden:<\/label>"
                            ."<\/div>";
                if(empty($sol['id_responsable'])){
                    $cuerpo2.= "<div class=\'col-md-12\'>"
                                    ."<div class=\'alert alert-info\' align=\'center\'>"
                                        . "<strong>¡No hay responsable asignado a esta solicitud!<\/strong>"
                                    ."<\/div>"
                                ."<\/div>"; 
                }else {
                    $cuerpo2.= "<div class=\'col-md-7\'>"
                                    ."<select title=\'Responsable de la orden\' class = \'form-control input select2\' id = \'ayu_resp".($sol['id_orden'])."\' name=\'responsable\' disabled>"
                                        ."<!--<option ><\/option>-->"
                                    ."<\/select>"
                                ."<\/div>";
                }
            }else{
                $respon = $this->model_responsable->get_responsable($sol['id_orden']);
                $cuerpo2 .= "<div class=\'col-md-12 text-center\'>"
                                ."Responsable de la orden: <label>".$respon['nombre']." ".$respon['apellido']."<\/label>"
                            ." <\/div>";                              
            }
            $cuerpo2.= "<br>"
                    ."<div class=\'col-md-12\'>"
                        ."<div class=\'text-center\' > <label>Ayudantes asignados<\/label> <\/div>"                                             
                        ."<div id=\'asignados".$sol['id_orden']."\'>"
                            ."<!-- AQUI CONSTRULLE UNA LISTA DE AYUDANTES ASIGNADOS A LA ORDEN (revisar script mainFunctions.js linea 208 en adelante)-->"
                        ."<\/div>"
                    ."<\/div>";
        }
        $cuerpo2.= "<\div>"
        ."</div>"
        ."<\/form>";            
        $footer2 =  "<input form=\'ay".$sol['id_orden']."\' type=\'hidden\' name=\'uri\' value=\'tic_solicitudes\/lista_solicitudes\'\/>"
                    ."<input form=\'ay".$sol['id_orden']."\' type=\'hidden\' name=\'id_orden_trabajo\' value=\'".$sol['id_orden']."\'\/>"
                    ."<button type=\'button\' class=\'btn btn-default\' data-dismiss=\'modal\' aria-hidden=\'true\'>Cancelar<\/button>";
                    if(empty($est) && !(isset($band))){
                        $footer2.= "<button form=\'ay".$sol['id_orden']."\' type=\'submit\' class=\'btn btn-primary\'>Guardar cambios<\/button>";
                    }
        $footer2 .= "<\/div>";       
   //   FIN DE MODAL DE AYUDANTES-->
        if(empty($est) && !(isset($band))){
            if(in_array(array('id_orden_trabajo' => $sol['id_orden']), $ayuEnSol))
            {
                $a= ('<i title="Agregar ayudantes" class="glyphicon glyphicon-plus" style="color:#5BC0DE"></i>');
            }
            else
            {  
                $a = ('<i title="Asignar ayudantes" class="glyphicon glyphicon-pencil fa-lg" style="color:#D9534F"></i>');
            }
        }else{
             if(in_array(array('id_orden_trabajo' => $sol['id_orden']), $ayuEnSol))
            {
                $a= ('<i title="Ayudantes asignados" class="glyphicon glyphicon-plus" style="color:#5BC0DE"></i>');
            }
            else
            {  
                $a = ('<i title="Sin asignar ayudantes" class="glyphicon glyphicon-minus" style="color:#D9534F"></i>');
            }
            
        }
        $row[]= '<a class="btn btn-link btn-xs" role="button" onclick="ayudantes(' . "'".$sol['estatus']."'" . ',' . "'".$sol['id_orden']."'" . ', ((' . "'".$titulo2."'" . ')), ((' . "'".$cuerpo2."'" . ')), ((' . "'".$footer2."'" . ')),1)">'.$a.'</a>';
        if(!empty($est))
            {
//                <!--modal de calificacion de solicitud-->
                //Mod jcparra 04/04/2017  
            $title3 =  "<label class=\'modal-title\'>Calificar solicitud ".$sol['id_orden']."<\/label><img src=\'".base_url()."assets\/img\/tic\/opinion.png\' class=\'img-rounded\' alt=\'bordes redondeados\' width=\'25\' height=\'25\'>";
            $cuerpo3 = "<form class=\'form\' action=\'".base_url()."tic_solicitudes\/sugerencias\' method=\'post\' name=\'opinion\' id=\'opinion".$sol['id_orden']."\' onsubmit= if($(\'#".$sol['id_orden']."\')){return(valida_calificacion($(\'#sugerencia".$sol['id_orden']."\'),star));}>"
                        ."<input type=\'hidden\' name=\'uri\' value=\'tic_solicitudes\/cerrada\'\/>"
                        ."<div class=\'row\'>"
                            ."<div class=\'col-md-6 text-center\'>"
                                ."<label class=\'control-label\' for = \'asunto\'>Asunto: ".$sol['asunto']."<\/label>"
                            ." <\/div>";
                        
                if (empty($sol['sugerencia'])){
                    $cuerpo3.=  "<input type=\'hidden\' id= \'id_orden\' name=\'id_orden\' value=\'".$sol['id_orden']."\'>"
                            ."<div class=\'form-group text-center\'>"
                                ."<input id=\'star".$sol['id_orden']."\' name=\'star\' data-size=\'xl\' data-max=\'5\' data-step=\'1\' class=\'rating rating-loading\'>"
                                ."<div class=\'col-md-12\'>"
                                    ."<br>"
                                    ."<textarea rows=\'3\' autocomplete=\'off\' type=\'text\' onKeyDown=contador(this.form.sugerencia,($(\'#restar".$sol['id_orden']."\')),160); onKeyUp=contador(this.form.sugerencia,($(\'#restar".$sol['id_orden']. "\')),160);"
                                        . " value=\'\' style=\'text-transform:uppercase;\' onkeyup=javascript:this.value = this.value.toUpperCase(); class=\'form-control\' id=\'sugerencia".$sol['id_orden']."\' name=\'sugerencia\' placeholder=\'Escriba su opinion aquí\'><\/textarea>"
                                    ."<\/div>"
                                    ."<small><p name=\'restar\' id=\'restar".$sol['id_orden']."\' size=\'4\'>0/160<\/p><\/small>"
                                ."</div>";
                }else{
                    $cuerpo3.=  "<div class=\'form-group text-center\'>"
                                    ."<input id=\'star".$sol['id_orden']."\' disabled value=\'".$sol['star']."\' data-size=\'xl\' name=\'star\' class=\'rating rating-loading\'>"
                                    ."<div class=\'col-md-12\'>"
                                         ."<br>"
                                        ."<textarea class=\'form-control\' rows=\'3\' autocomplete=\'off\' type=\'text\' id=\'sugerencia".$sol['id_orden']."\' name=\'sugerencia\' disabled>"
                                            .$sol['sugerencia']
                                        . "<\/textarea>"
                                    ."<\/div>";
                }
            $cuerpo3 .= "<\/form>"
                        ."<\/div>";
            $footer3 =  "<button type=\'button\' class=\'btn btn-default\' data-dismiss=\'modal\' aria-hidden=\'true\'>Cancelar<\/button>";
                            if (empty($sol['sugerencia'])){
                                $footer3.= "<button form=\'opinion".$sol['id_orden']."\' class=\'btn btn-primary\' type=\'submit\'>Enviar<\/button>";
                            }
                                   
            $aux4='<div id="sugerencias'.$sol['id_orden'].'" class="modal modal-message modal-info fade" tabindex="-1" role="dialog" style="display: none;">
            <div class="modal-dialog">
                <div class="modal-content">
                        <div class="modal-header">
                            <label class="modal-title">Calificar solicitud</label><img src="'.base_url()."assets/img/tic/opinion.png".'" class="img-rounded" alt="bordes redondeados" width="25" height="25">
                        </div>
                    <form class="form" action="'.base_url().'tic_solicitudes/sugerencias" method="post" name="opinion" id="opinion" onsubmit="if ($('."'#".$sol['id_orden']."'".')){return valida_calificacion($('."'".'#sugerencia'.$sol['id_orden']."'".') ,  star);}">';
                        if (empty($sol['sugerencia'])){
                          $aux4=$aux4.'<input type="hidden" id= "id_orden" name="id_orden" value="'.$sol['id_orden'].'">
                            <div class="modal-body">
                                    <div class="form-group">
                                        <label class="control-label" for="sugerencia">Califique la solicitud:</label>
                                            <input id="star'.$sol['id_orden'].'" name="star" type="text" class="rating rating-loading">
                                            <div class="col-lg-20">
                                                <textarea cols="71" rows="3" autocomplete="off" type="text" onKeyDown=" contador(this.form.sugerencia,($(' . "'".'#restar'.$sol['id_orden']. "'".')),160);" onKeyUp="contador(this.form.sugerencia,($(' . "'".'#restar'.$sol['id_orden']. "'".')),160);"
                                                          value="" style="text-transform:uppercase;" onkeyup="javascript:this.value = this.value.toUpperCase();" class="form-control" id="sugerencia'.$sol['id_orden'].'" name="sugerencia" placeholder="Escriba su opinion aquí"></textarea>
                                            </div>
                                            <small><p  align="right" name="restar" id="restar'.$sol['id_orden'].'" size="4">0/160</p></small>
                                    </div>';
                                }else{
                                    $aux4=$aux4.'<div class="form-group">
                                        <div class="col-lg-12">
                                            <label class="control-label" for="sugerencia">Califique la solicitud:</label>
                                        </div>
                                        <input id="star'.$sol['id_orden'].'" disabled value="'.$sol['star'].'" name="star" type="text" class="rating rating-loading">
                                        <div class="col-lg-12">
                                            <textarea cols="72" class="form-control" rows="3" autocomplete="off" type="text" onKeyDown=" contador(this.form.sugerencia,($("#restar1'.$sol['id_orden'].'")),160);" onKeyUp="contador(this.form.sugerencia,($("#restar1'.$sol['id_orden'].'")),160);"
                                        id="sugerencia'.$sol['id_orden'].'" name="sugerencia" disabled>'.$sol['sugerencia'].'</textarea>
                                </div>
                                <div class="col-lg-12">
                                    <small><p  align="right" name="restar1" id="restar1'.$sol['id_orden'].'" size="4">0/160</p></small>
                                </div>
                            </div>';
                           };
                            $aux4=$aux4.'<div class="modal-footer">
                                <button type="button" class="btn btn-default" data-dismiss="modal" aria-hidden="true">Cancelar</button>';
                                if (empty($sol['sugerencia'])){
                                    $aux4=$aux4.'<button class="btn btn-primary" type="submit">Enviar</button>';
                                }
                                $aux4=$aux4.'<input type="hidden" name="uri" value="tic_solicitudes/cerrada"/>
                            </div>
                        
                    </div>
                    </form>
                </div>
            </div>
        </div>';
//<!-- FIN DE MODAL DE CALIFICAR SOLICITUD-->'
                if (($sol['descripcion'] == 'CERRADA') && empty($sol['sugerencia']))
                {
                    $row[] = '<a class="btn btn-link btn-xs" role="button" onclick="calificar(('. "'".$sol['id_orden']."'" . '),('. "'".$title3."'" . '),('. "'".$cuerpo3."'" . '),('."'" .$footer3."'" .'))"><div align="center" title="Calificar"><img src="'.base_url()."assets/img/tic/opinion1.png".'" class="img-rounded" alt="bordes redondeados" width="25" height="25"></div></a>';
//                    $row[] = '<a href="#sugerencias'.$sol['id_orden'].'" data-toggle="modal" data-id="'.$sol['id_orden'].'" class="open-Modal"><div align="center" title="Calificar"><img src="'.base_url()."assets/img/tic/opinion.png".'" class="img-rounded" alt="bordes redondeados" width="25" height="25"></div></a>'.$aux4.'<script src="'.base_url().'assets/js/star-rating.js"></script>';
                }
                elseif (($sol['descripcion'] == 'CERRADA') && (!empty($sol['sugerencia'])))
                {
//                    $row[] = '<a href="#sugerencias'.$sol['id_orden'].'" data-toggle="modal" data-id="'.$sol['id_orden'].'" class="open-Modal"><div align="center" title="Calificada"><img src="'.base_url()."assets/img/tic/opinion1.png".'" class="img-rounded" alt="bordes redondeados" width="25" height="25"></div></a>'.$aux4.'<script src="'.base_url().'assets/js/star-rating.js"></script>';
//                    $row[] = '<a class="btn btn-link btn-xs" role="button" onclick="buildModal(('. "'".$sol['id_orden']."'" . '),('. "'".$title3."'" . '),('. "'".$cuerpo3."'" . '),('."'" .$footer3."'" .'))"><div align="center" title="Calificada"><img src="'.base_url()."assets/img/tic/opinion1.png".'" class="img-rounded" alt="bordes redondeados" width="25" height="25"></div></a>'.'<script src="'.base_url().'assets/js/star-rating.js"></script>';
                    $row[] = '<a class="btn btn-link btn-xs" role="button" onclick="calificar(('. "'".$sol['id_orden']."'" . '),('. "'".$title3."'" . '),('. "'".$cuerpo3."'" . '),('."'" .$footer3."'" .'))"><div align="center" title="Calificada"><img src="'.base_url()."assets/img/tic/opinion.png".'" class="img-rounded" alt="bordes redondeados" width="25" height="25"></div></a>';
                }
                else
                {
                    $row[] = '<div align="center"><span class="label label-warning">'.$sol['descripcion'].'</span></div>'.$aux4.'<script src="'.base_url().'assets/js/star-rating.js"></script>';
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
        $query = $this->db->get('tic_orden_trabajo');
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
        $query = $this->db->get('tic_orden_trabajo')->result_array();
        //die_pre($query);
        foreach ($query as $key => $soli)
         {
            $result[$key] = $soli;
            $result[$key]['creada'] = $this->model_tic_estatus_orden->get_first_fecha($soli['id_orden']);
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
        $query = $this->db->get('tic_orden_trabajo');
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
        $query = $this->db->get('tic_orden_trabajo')->result_array();
         foreach ($query as $key => $soli)
         {
            $result[$key] = $soli;
            $result[$key]['creada'] = $this->model_tic_estatus_orden->get_first_fecha($soli['id_orden']);
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
        $unir = $this->db->join('tic_tipo_orden', 'tic_tipo_orden.id_tipo = tic_orden_trabajo.id_tipo', 'INNER');
        $this->db->join('dec_dependencia', 'dec_dependencia.id_dependencia = tic_orden_trabajo.dependencia', 'INNER');
//        $this->db->join('mnt_ubicaciones_dep', 'mnt_ubicaciones_dep.id_dependencia = tic_orden_trabajo.dependencia', 'INNER');
       // $this->db->join('tic_observacion_orden', 'tic_observacion_orden.id_orden_trabajo = tic_orden_trabajo.id_orden', 'INNER');
//        $this->db->join('tic_estatus_orden', 'tic_estatus_orden.id_orden_trabajo = tic_orden_trabajo.id_orden', 'INNER');
        $this->db->join('mnt_estatus', 'mnt_estatus.id_estado = tic_orden_trabajo.estatus', 'INNER');
        $this->db->join('tic_asigna_cuadrilla', 'tic_asigna_cuadrilla.id_ordenes = tic_orden_trabajo.id_orden', 'LEFT');
        $this->db->join('tic_cuadrilla', 'tic_cuadrilla.id = tic_asigna_cuadrilla.id_cuadrilla ', 'LEFT');
        $this->db->join('tic_responsable_orden', 'tic_responsable_orden.id_orden_trabajo = tic_orden_trabajo.id_orden ', 'LEFT');
//        $this->db->join('tic_ayudante_orden', 'tic_ayudante_orden.id_orden_trabajo = tic_orden_trabajo.id_orden', 'LEFT');
        //$this->db->select('id_usuario','nombre','apellido');
        //$this->db->from('dec_usuario');
        //$this->db->join('dec_usuario', 'dec_usuario.id_usuario = tic_cuadrilla.id_trabajador_responsable', 'LEFT');
        return $unir;
    }

    public function get_orden($id_orden = '') {
        if (!empty($id_orden)) {
            $this->db->where('id_orden', $id_orden);
            $query = $this->unir_tablas();
            $query = $this->db->get('tic_orden_trabajo');
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
                $query = $this->db->get('tic_orden_trabajo', $per_page, $offset);
                return $query->result();
            } else {
                //echo_pre($query);
                $query = $this->db->get('tic_orden_trabajo', $per_page, $offset);
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
                $query = $this->db->get('tic_orden_trabajo', $per_page, $offset);
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
            return $this->db->count_all_results('tic_orden_trabajo');
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
                $query = $this->db->get('tic_orden_trabajo');
                //echo_pre($query->result());
                return $this->db->count_all_results('tic_orden_trabajo');
            endif;
        }
        return FALSE;
    }

    // FUNCION PARA INSERTAR -- FORMULARIO NATALY
    public function insert_orden($data1 = '') {
        if (!empty($data1)) {
            //die_pre($data1);
            $this->db->insert('tic_orden_trabajo', $data1);
            return $this->db->insert_id();
        }
        return FALSE;
    }

    public function actualizar_orden($data = '', $id_orden = '') {
        if (!empty($data)) {
            $this->db->where('id', $id_orden);
            $this->db->update('tic_orden_trabajo', $data);//hay un error en la modificacion al momento de pasar la columna ubicacion, siendo un not null 
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
        $query = $this->db->get('tic_orden_trabajo');
        return $query->result();
    }
    
    public function get_califica() // funcion para traer las calificaciones vacias que esten en las solicitudes cerradas, esta funcion la llamo en template
	{
            $where = array('estatus' => '3',
                            'dependencia' => $this->session->userdata('user')['id_dependencia']);
            $this->db->where($where);
            $this->db->select('sugerencia');   
            $query = $this->db->get_where('tic_orden_trabajo',array('sugerencia' => '')); // aqui me traigo la tabla y el dato que deseo
//            echo_pre($query->num_rows()); 
            if($query->num_rows() > 0):
                return $query->result_array();
            else:
                return array();
            endif;
		
	}
        
    public function consul_orden_tipo($id_tipo='',$status='',$fecha1='',$fecha2='',$band='',$buscador='',$menu='',$ordena='',$dir_span='',$menu=''){
//        En esta funcion toco usar el query personalizado ya que los del active record no funcionaban bien cuando le aplicaba
//        el buscador, siempre se salian del estatus.
        $aColumns = array('id_orden','fecha','dependen','asunto','descripcion','tipo_orden','tic_orden_trabajo.id_tipo');     
        if ($status != ''):
            $filtro = "WHERE estatus in ($status) "; /* Para filtrar por estatus */
//         die_pre($filtro);
        endif;
        if(isset($filtro)):
            if($id_tipo != ''):
                $filtro = $filtro. " AND tic_orden_trabajo.id_tipo = '$id_tipo' ";
//                 echo_pre($filtro);
            endif;
        else:
            if($id_tipo != ''):
                $filtro = " WHERE tic_orden_trabajo.id_tipo = '$id_tipo' ";
            endif;
        endif;
        $id_tipo = $this->model_tic_cuadrilla->es_resp_no_jefe_cuad($this->session->userdata('user')['id_usuario']);//PARA evaluar si es responsable de una cuadrilla y que no sea jefe de mantenimiento
        if(!empty($id_tipo))
        {
            if (isset($filtro)):
                $filtro .= " AND tic_orden_trabajo.id_tipo = $id_tipo";
            else:
                $filtro = "WHERE tic_orden_trabajo.id_tipo = $id_tipo";
            endif; 
        }
        $sWhere = ""; // Se inicializa y se crea la variable
        if ($buscador != ''):
            $sSearchVal = $buscador; //Se asigna el valor de la busqueda, este es el campo de busqueda de la tabla
            if (isset($sSearchVal) && $sSearchVal != ''): //SE evalua si esta vacio o existe
//                echo_pre($sSearchVal);
                if (isset($filtro) && $filtro != ''):
                    $sWhere = "AND (";
                else:
                    $sWhere = "WHERE (";  //Se comienza a almacenar la sentencia sql    
                endif;

                for ($i = 0; $i < count($aColumns); $i++): //se abre el for para buscar en todas las columnas que leemos de la tabla
                    $sWhere .= $aColumns[$i] . " LIKE '%" . $this->db->escape_like_str($sSearchVal) . "%' OR "; // se concatena con Like 
                endfor;
                $sWhere = substr_replace($sWhere, "", -3);
                $sWhere .= ')'; //Se cierra la sentencia sql
            endif;
        endif;
   
        /* Filtro de busqueda añadido en este caso es para buscar por el rango de fechas */
        if ($fecha1 != "" OR $fecha2 != ""):
            if(isset($filtro)&& $filtro != ""):
                $sWhere = "AND fecha BETWEEN '$fecha1' AND '$fecha2'"; //Se empieza a crear la sentencia sql al solo buscar por fecha   
            else:
                $sWhere = "WHERE fecha BETWEEN '$fecha1' AND '$fecha2'"; //Se empieza a crear la sentencia sql al solo buscar por fecha    
            endif;
            
        endif;
        
        if($this->db->escape_like_str($buscador) != "" AND $fecha1 != "" AND $fecha2 != ""):
            if(isset($filtro)&& $filtro != " "):
                $sWhere = "AND fecha BETWEEN '$fecha1' AND '$fecha2' AND(";
            else:
                $sWhere = "WHERE fecha BETWEEN '$fecha1' AND '$fecha2' AND(";
            endif;
            
            for ($i = 0; $i < count($aColumns); $i++):
                $sWhere .= $aColumns[$i] . " LIKE '%" . $this->db->escape_like_str($buscador) . "%' OR ";
            endfor;
            $sWhere = substr_replace($sWhere, "", -3);
            $sWhere .= ')';
        endif;    
        $table = 'tic_orden_trabajo';
         $sJoin = "INNER JOIN dec_dependencia ON tic_orden_trabajo.dependencia=dec_dependencia.id_dependencia "
                . "INNER JOIN mnt_estatus ON tic_orden_trabajo.estatus=mnt_estatus.id_estado "
                . "INNER JOIN tic_tipo_orden ON tic_orden_trabajo.id_tipo=tic_tipo_orden.id_tipo ";
      
        if ($sWhere == ""):
            if (isset($filtro) && $filtro != ""):
                $sQuery = "SELECT SQL_CALC_FOUND_ROWS " . str_replace(" , ", " ", implode(", ", $aColumns)) . "
             FROM $table $sJoin $filtro ";
            else:
                $sQuery = "SELECT SQL_CALC_FOUND_ROWS " . str_replace(" , ", " ", implode(", ", $aColumns)) . "
             FROM $table $sJoin";
            endif;
        else:
             if (isset($filtro) && $filtro != ""):
                $sQuery = "SELECT SQL_CALC_FOUND_ROWS " . str_replace(" , ", " ", implode(", ", $aColumns)) . "
            FROM $table $sJoin $filtro $sWhere ";
            else:
                $sQuery = "SELECT SQL_CALC_FOUND_ROWS " . str_replace(" , ", " ", implode(", ", $aColumns)) . "
                FROM $table $sJoin $sWhere ";
            endif;
        endif;
//        die_pre($ordena);
        $sOrder = "ORDER BY ";
        if($menu == 'tipo'):
            if($ordena != "tipo_orden $dir_span"):
                if($dir_span != ''):
                    $sOrder .= "tipo_orden $dir_span,$ordena ";
                else:
                    $sOrder .= "tipo_orden,$ordena ";
                endif;
            else:
                 $sOrder .= "tipo_orden $dir_span";
            endif;
        else:
            $sOrder .= $ordena;
        endif;
//        echo_pre($sOrder);
        $sQuery .= $sOrder;
//        die_pre($sQuery);
        $query = $this->db->query($sQuery)->result_array();
        if (!empty($query)){
            if ($band) {//Se evalua si la data necesita retornar datos o solo es consultar datos
                return $query;
            } else {
                return TRUE;
            }
        }else{
            return FALSE;
        }
    }
}
