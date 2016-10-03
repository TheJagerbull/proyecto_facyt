<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Mnt_reportes extends MX_Controller
{
	function __construct() //constructor predeterminado del controlador
    {
        parent::__construct();
        $this->load->library('form_validation');
	$this->load->model('model_mnt_reporte');
	$this->load->model('user/model_dec_usuario');
        $this->load->model('mnt_solicitudes/model_mnt_solicitudes');
        $this->load->model('mnt_estatus/model_mnt_estatus');
        $this->load->model('mnt_estatus_orden/model_mnt_estatus_orden');
        $this->load->model('mnt_cuadrilla/model_mnt_cuadrilla');
        $this->load->model('mnt_asigna_cuadrilla/model_mnt_asigna_cuadrilla');
        $this->load->model('mnt_responsable_orden/model_mnt_responsable_orden','model_responsable');
        $this->load->model('user/model_dec_usuario','model_user');
        $this->load->model('mnt_ayudante/model_mnt_ayudante');
        $this->load->module('dec_permiso/dec_permiso');
        $this->load->model('mnt_tipo/model_mnt_tipo_orden');
    }

      //Esta funcion se una para construir el json para el llenado del datatable en la vista de reportes
    function list_sol() {
        $results = $this->model_mnt_reporte->get_list();//Va al modelo para tomar los datos para llenar el datatable
        echo json_encode($results); //genera la salida de datos
    }
    
    public function reportes() {
        $results = $this->model_mnt_ayudante->get_list();//Va al modelo para tomar los datos para llenar el datatable
        echo json_encode($results); //genera la salida de datos
    }
    
    public function reporte() {
        if ($this->dec_permiso->has_permission('mnt', 15)) {
//            echo_pre ($this->model_responsable->existe_resp_2($this->session->userdata('user')['id_usuario']));
//            echo_pre ($this->model_mnt_cuadrilla->es_responsable($this->session->userdata('user')['id_usuario']));
//            echo_pre ($this->session->userdata('user'));
//            echo_pre($_GET);
//            echo_pre($this->model_mnt_cuadrilla->es_resp_no_jefe_cuad($this->session->userdata('user')['id_usuario']));

            if ($this->dec_permiso->has_permission('mnt', 9) || $this->dec_permiso->has_permission('mnt', 10) || $this->dec_permiso->has_permission('mnt', 11) || $this->dec_permiso->has_permission('mnt', 13)){
                $view['ver']=1;
            }else{
                $view['ver']=0;
            }
            if ($this->dec_permiso->has_permission('mnt', 12)) {
                $view['close']=1;
            }else{
                $view['close']=0;
            }
            if ($this->dec_permiso->has_permission('mnt', 14)) {
                $view['ver_asig']=1;
            }else{
                $view['ver_asig']=0;
            }
            if ($this->dec_permiso->has_permission('mnt',1)){
                 $view['crear']=1;
            }else{
                $view['crear']=0;
            }
            if ($this->dec_permiso->has_permission('mnt',2)){
                 $view['crear_dep']=1;
            }else{
                $view['crear_dep']=0;
            }
            $header['title'] = 'Reporte por trabajador';          //	variable para la vista
            $id_tipo = $this->model_mnt_cuadrilla->es_resp_no_jefe_cuad($this->session->userdata('user')['id_usuario']);//en caso de que sea jefe de cuadrilla devuelve el id tipo de orden
            if(isset($id_tipo))://se evalua si existe este valor para devolver el menu de busquedas a la vista.
                $view['estatus'] = $this->model_mnt_estatus->estatus_al_jefe_cuad();
                $view['trabajadores']=$this->model_mnt_ayudante->ayud_tipo_orden($id_tipo);
                $view['tipo'] = $this->model_mnt_tipo_orden->devuelve_tipo($id_tipo);
            else:
                $view['estatus'] = $this->model_mnt_estatus->get_estatus();
                $view['trabajadores'] = $this->model_user->get_userObrero();
                $view['tipo'] =$this->model_mnt_tipo_orden->devuelve_tipo();
            endif;
            
//            die_pre($view['estatus']);
            //CARGA LA VISTA PARA EL REPORTE
            $header = $this->dec_permiso->load_permissionsView();
			$this->load->view('template/header', $header);
            $this->load->view('mnt_reportes/reporte_trabajador',$view);
            $this->load->view('template/footer');
        } else {
            $this->session->set_flashdata('permission', 'error');
            redirect('inicio');
        }
    }
    
    public function load_ayu_asig(){
//        echo_pre($this->input->post('estatus'));
        $band = 0; //Esta variable se usa con la intencion de no repetir la funcion del modelo donde se obtienen los datos
        if ($this->input->post('fecha1') && $this->input->post('fecha2') && $this->input->post('estatus')):
            $cont = 0;//Esta se usa para contar la cantidad de datos encontrados
            $todos = $this->model_user->get_userObrero();
            ?><option></option><?php
            foreach ($todos as $all):
//                echo $this->model_mnt_ayudante->consul_trabaja_sol($all['id_usuario'],$this->input->post('estatus'),$this->input->post('fecha1'),$this->input->post('fecha2'),$band);
                if ($this->model_mnt_ayudante->consul_trabaja_sol($all['id_usuario'],$this->input->post('estatus'),$this->input->post('fecha1'),$this->input->post('fecha2'),$band)):
                $cont++;?>
                <option value="<?php echo $all['id_usuario']?>"><?php echo ($all['nombre']. ' '.$all['apellido']);?></option>
         <?php  endif;
            endforeach;
            if($cont > 1):
                ?><option value="all">Todos</option><?php
            endif;
        endif;
    }
    
    public function load_consult(){
        $band=1; //para que me muestre los datos consultados en el modelo
        ?>
            <style>
                .buttons-print {
                background-color: #f0ad4e ;
                color: black; 
                }
            </style>
        <div class="panel panel-info">
        <?php
        $estatus = $this->model_mnt_estatus->get_estatus_id($this->input->post('estatus'));
        if (is_numeric($this->input->post('id_trabajador'))):
            $datos = $this->model_mnt_ayudante->consul_trabaja_sol($this->input->post('id_trabajador'),$this->input->post('estatus'),$this->input->post('fecha1'),$this->input->post('fecha2'),$band);
            $total_datos = count($datos); //Para tener la cantidad de datos obtenidos
            ?>
            <div class="panel-heading">
            <?php
            foreach ($datos as $dat):
                if ($total_datos >= 1):
                    $total_datos=0;
                    ?>             
                        <label><strong><?php echo $dat['Nombre'].' '.$dat['Apellido']?></strong></label>
                        <div class="btn-group btn-group-sm pull-right">
                            <label><strong></strong> Estatus : <?php echo $estatus?></strong> </label>
                        </div>
                    <?php
                endif;
            endforeach;
            ?>
            </div>
            <div class="panel-body">
                <div class="col-md-12 col-xs-12">
                    <p>Desde: <strong><?php echo date("d/m/Y", strtotime($this->input->post('fecha1')))?></strong>
                       Hasta: <strong><?php echo date("d/m/Y", strtotime($this->input->post('fecha2')))?></strong></p>
                </div>
                <input type="hidden" name="fecha1" value="<?php echo $this->input->post('fecha1') ?>"/>
                <input type="hidden" name="fecha2" value="<?php echo $this->input->post('fecha2') ?>"/>
                <input type="hidden" name="estatus" value="<?php echo $this->input->post('estatus') ?>"/>
                <input type="hidden" name="id_trabajador" value="<?php echo $this->input->post('id_trabajador') ?>"/>
                <button class="btn btn-default pull-right" id="reportePdf" type="submit">Crear PDF</button>
                <div class="col-md-12 col-xs-12"><br></div>
                <table id="asignacion" class="table table-hover table-bordered table-condensed">
                    <thead>
                        <tr>
                            <th><div align="center">Orden</div></th>
                            <th><div align="center">Asignada</div></th>
                            <th><div align="center">Dependencia</div></th>
                            <th><div align="center">Asunto</div></th> 
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($datos as $index => $dat) : ?>  
                        <tr>
                            <td><div align="center"><?php echo ucfirst($dat['Orden'])?></div></td>
                            <td><div align="center"><?php echo date("d/m/Y", strtotime($dat['fecha']))?></div></td>
                            <td><div align="center"><?php echo ucfirst($dat['Dependencia'])?></div></td>
                            <td><div align="center"><?php echo ucfirst($dat['Asunto'])?></div></td>
                        </tr>
                        <?php endforeach ?>
                    </tbody>
                </table>
            </div>
            <?php
        elseif($this->input->post('id_trabajador')=='all'):
            $datos = $this->model_mnt_ayudante->consul_trabaja_sol('',$this->input->post('estatus'),$this->input->post('fecha1'),$this->input->post('fecha2'),$band);
//            die_pre($datos);
            ?>
                <style>
                    tr.group,
                    tr.group:hover {
                        background-color: #ddd !important;
                    }
                </style>
                <script type="text/javascript">
                    $(document).ready(function() {
                    var table = $('#trabajador').DataTable({
//                      buttons: [
//                      {
//                          extend: 'print',
//                          text: '<i class="glyphicon glyphicon-print"></i>',
//                          titleAttr: 'Imprimir',
//                          title: "Reporte por trabajador",
//                          message: "Desde: "+moment(<?php $this->input->post('fecha1')?>).format('Do MMM YYYY')+" ' ' "+"Hasta: "+moment(<?php $this->input->post('fecha2')?>).format('Do MMM YYYY'),
//                          customize: function ( win ) {
//                          $(win.document.body)
//                              .css( 'font-size', '10pt' );
////                            .prepend(
////                            '<img src="http://localhost/proyecto_facyt/assets/img/FACYT4.png"  style="position:absolute; top:0; left:0;" />'
////                        );
//                          $(win.document.body).find( 'table' )
//                              .addClass( 'compact' )
//                              .css( 'font-size', 'inherit' );
//                          },
//                          exportOptions: { orthogonal: 'export' }
//                      }
//                      ],
                    "pagingType": "full_numbers",
                    "columnDefs": [
                        { "visible": false, "targets": 0 }
                    ],
//                    "serverSide": true,
                    "order": [[ 0, 'asc' ]],
                    "sDom": '<"top"l<"clear">>rt<"bottom"ip<"clear">>',
                    "oLanguage": { 
                        "oPaginate": 
                        {
                            "sNext": '<i title="Siguiente" class="glyphicon glyphicon-forward" ></i>',
                            "sPrevious": '<i title="Anterior" class="glyphicon glyphicon-backward" ></i>',
                            "sLast": '<i title="Último" class="glyphicon glyphicon-step-forward"></i>',
                            "sFirst": '<i title="Primero" class="glyphicon glyphicon-step-backward"></i>'
                        }
                    },
//                    "ajax": {
//                        "url": "<?php echo site_url('mnt_ayudante/mnt_ayudante/reportes')?>",
//                        "type": "GET",
//                        "data": function ( d ) {
//                            d.uno = $('#result1').val();
//                            d.dos = $('#result2').val();
//                            d.status = $('#status_orden').val();
//                        }
//                    },
//                    "columns": [
//                        { "data": "nombre" },
//                        { "data": "orden" },
//                        { "data": "dependencia" },
//                        { "data": "tipo_orden" },
//                        { "data": "asunto" }
//                    ],
                    "drawCallback": function ( settings ) {
                        var api = this.api();
                        var rows = api.rows( {page:'current'} ).nodes();
                        var last=null; 
                        api.column(0, {page:'current'} ).data().each( function ( group, i ) {
                            if ( last !== group ) {
                                $(rows).eq( i ).before(
                                '<tr class="group"><td colspan="5">Trabajador: '+group+'</td></tr>'
                                ); 
                                last = group;
                            }
                        });
                    }
                    });
 
                     // Order by the grouping
                    $('#trabajador tbody').on( 'click', 'tr.group', function () {
                        var currentOrder = table.order()[0];
                        if ( currentOrder[0] === 0 && currentOrder[1] === 'asc' ) {
                            table.order( [ 0, 'desc' ] ).draw();
                        }
                        else {
                            table.order( [ 0, 'asc' ] ).draw();
                        }
                    });
                    });
                </script>
                <div class="panel-heading">
                    <label><strong>Todos los trabajadores</strong></label>
                        <div class="btn-group btn-group-sm pull-right">
                            <label><strong></strong> Estatus : <?php echo $estatus?></strong> </label>
                        </div>
                </div>
                <div class="panel-body">
                    <div class="col-md-12 col-xs-12">
                    <p>Desde: <strong><?php echo date("d/m/Y", strtotime($this->input->post('fecha1')))?></strong>
                       Hasta: <strong><?php echo date("d/m/Y", strtotime($this->input->post('fecha2')))?></strong></p>
                    </div>
                <div class="col-md-12 col-xs-12"><br></div>
                <input type="hidden" name="fecha1" value="<?php echo $this->input->post('fecha1') ?>"/>
                <input type="hidden" name="fecha2" value="<?php echo $this->input->post('fecha2') ?>"/>
                <input type="hidden" name="estatus" value="<?php echo $this->input->post('estatus') ?>"/>
                <button class="btn btn-default pull-right" id="reportePdf" type="submit">Crear PDF</button>
                <div class="col-md-12 col-xs-12"><br></div>
                <table id="trabajador" class="table table-hover table-bordered table-condensed" align="center" width="100%">
                    <thead>
                        <tr>
                            <!--<th></th>-->
                            <th>Nombre</th>
                            <th>Orden</th>
                            <th>Asignada</th>
                            <th>Dependencia</th>
                            <!--<th>Tipo de orden</th>-->
                            <th>Asunto</th>
                        </tr>
                    </thead>
                    <tbody>
                             <?php foreach($datos as $index => $dat) : ?>  
                        <tr>
                            <td><?php echo ucfirst($dat['Nombre'].' '.$dat['Apellido'])?></td>
                            <td><div align="center"><?php echo ucfirst($dat['Orden'])?></div></td>
                            <td><div align="center"><?php echo date("d/m/Y", strtotime($dat['fecha']))?></div></td>
                            <td><div align="center"><?php echo ucfirst($dat['Dependencia'])?></div></td>
                            <td><div align="center"><?php echo ucfirst($dat['Asunto'])?></div></td>
                        </tr>
                        <?php endforeach ?>                   
                    </tbody>
                </table>
                </div>
             <?php
        else:
            ?>
            <div class="panel-body">
                <div align='center' class='alert alert-danger' role='alert'><strong>Error... debe seleccionar un trabajador para mostrar el reporte</strong></div>
            </div>
            <?php
        endif;
    ?>
    </div><?php
    }
    
     public function pdf_reportes_worker()//aqui estoy haciendo los reportes
    {         
        $band = 1;
//        die_pre($_POST);
        
//        if($_POST['col_pdf'] != ''):
//           $sOrder = "ORDER BY ".$_POST['col_pdf'];
//        endif;  
//        die_pre($sOrder);
//         die_pre('permiso para ver reportes', __LINE__, __FILE__);
        if(!empty($id_tipo = $this->model_mnt_cuadrilla->es_resp_no_jefe_cuad($this->session->userdata('user')['id_usuario'])))//PARA evaluar si es responsable de una cuadrilla y que no sea jefe de mantenimiento
        {
            if(!empty($_POST['estatus'])){
                $estatus = $_POST['estatus'];
            }else{
                $estatus = '2,3,5';
            }
        }else{
            $estatus = $_POST['estatus'];
        }
        if(($_POST['menu'])== ''):
            $view['cabecera']="Reporte General";//titulo acompanante de la cabecera del documento
            $view['tipo'] = '';
        endif;
        if(($_POST['menu'])== 'trab'):
            $view['cabecera']="Reportes por trabajador";//titulo acompanante de la cabecera del documento
            $view['tipo'] = 'trabajador';
        endif;
        if(($_POST['menu'])== 'respon'):
            $view['cabecera']="Reportes por responsable";//titulo acompanante de la cabecera del documento
            $view['tipo'] = 'responsable';
        endif;
        if(($_POST['menu'])== 'tipo'):
            $view['cabecera']="Reportes por Tipo de Orden";//titulo acompanante de la cabecera del documento
            $view['tipo'] = 'tipo_orden';
        endif;
        $view['nombre_tabla']="reportes";//nombre de la tabla que construira el modelo
        if(($_POST['result1'] != "") && ($_POST['result2'] != "")):
            $view['fecha1']= date("d/m/Y", strtotime($_POST['result1']));
            $view['fecha2']= date("d/m/Y", strtotime($_POST['result2']));
        endif;
        if(($_POST['estatus']!="")):
            $status = $this->model_mnt_estatus->get_estatus_id($_POST['estatus']);
            if($status != 'PENDIENTE POR MATERIAL'):
                $view['estatus']=$status;
            else:
                $view['estatus']= 'Pend. Material';
            endif;
        else:
            $view['estatus'] = 'Todos';
        endif;
//        die_pre($view['estatus']); 
    
        if(($_POST['menu'])== 'trab'):
            if (($_POST['trabajadores'])):
                $view['tabla'] = $this->model_mnt_ayudante->consul_trabaja_sol($_POST['trabajadores'],$estatus,$_POST['result1'],$_POST['result2'],$band,$_POST['buscador'],$_POST['col_pdf'],$_POST['dir_span']);//construccion de la tabla    
                $view['trabajador'] = $this->model_user->get_user_cuadrilla($_POST['trabajadores']);
//            die_pre($view);
            else:
                $view['tabla'] = $this->model_mnt_ayudante->consul_trabaja_sol('',$estatus,$_POST['result1'],$_POST['result2'],$band,$_POST['buscador'],$_POST['col_pdf'],$_POST['dir_span']);//construccion de la tabla
            endif;
        endif;
//        die_pre($view);
        if(($_POST['menu'])== 'respon'):
            if (($_POST['responsable'])):
                $view['tabla'] = $this->model_responsable->consul_respon_sol($_POST['responsable'],$estatus,$_POST['result1'],$_POST['result2'],$band,$_POST['buscador'],$_POST['col_pdf'],$_POST['dir_span']);
                $view['trabajador'] = $this->model_user->get_user_cuadrilla($_POST['responsable']);
                foreach ($view['tabla'] as $dat):
                    $ayudantes[$dat['id_orden']] = $this->model_mnt_ayudante->ayudantes_DeOrden($dat['id_orden']);
                endforeach;
                $view['ayudantes']=$ayudantes;
//            echo_pre($view);
            else:
                $view['tabla'] = $this->model_responsable->consul_respon_sol('',$estatus,$_POST['result1'],$_POST['result2'],$band,$_POST['buscador'],$_POST['col_pdf'],$_POST['dir_span']);
                foreach ($view['tabla'] as $dat):
                    $ayudantes[$dat['id_orden']] = $this->model_mnt_ayudante->ayudantes_DeOrden($dat['id_orden']);
                endforeach;
                $view['ayudantes']=$ayudantes;
            endif;    
        endif;
        if(($_POST['menu'])== 'tipo'):
            if (($_POST['tipo_orden'])):
                $view['tabla'] = $this->model_mnt_solicitudes->consul_orden_tipo($_POST['tipo_orden'],$estatus,$_POST['result1'],$_POST['result2'],$band,$_POST['buscador'],$_POST['menu'],$_POST['col_pdf'],$_POST['dir_span'],$_POST['menu']);
                $tipo = $this->model_mnt_tipo_orden->devuelve_tipo($_POST['tipo_orden']);
                $view['tipo_de_orden'] = $tipo[0]->tipo_orden;
//                foreach ($view['tabla'] as $dat):
//                    $ayudantes[$dat['id_orden']] = $this->model_mnt_ayudante->ayudantes_DeOrden($dat['id_orden']);
//                endforeach;
//                $view['ayudantes']=$ayudantes;
//            echo_pre($view);
            else:
                if(isset($id_tipo)){//PARA evaluar si existe el id de la cuadrilla/tipo de orden cuando esta el usuario responsable de cuadrilla en sesion
                    $view['tabla'] = $this->model_mnt_solicitudes->consul_orden_tipo($id_tipo,$estatus,$_POST['result1'],$_POST['result2'],$band,$_POST['buscador'],$_POST['menu'],$_POST['col_pdf'],$_POST['dir_span'],$_POST['menu']);
                }else{
                    $view['tabla'] = $this->model_mnt_solicitudes->consul_orden_tipo('',$estatus,$_POST['result1'],$_POST['result2'],$band,$_POST['buscador'],$_POST['menu'],$_POST['col_pdf'],$_POST['dir_span'],$_POST['menu']);
                }
//                foreach ($view['tabla'] as $dat):
//                    $ayudantes[$dat['id_orden']] = $this->model_mnt_ayudante->ayudantes_DeOrden($dat['id_orden']);
//                endforeach;
//                $view['ayudantes']=$ayudantes;
            endif;    
        endif;
        if(($_POST['menu']) == ''){
            if(isset($id_tipo)){//PARA evaluar si existe el id de la cuadrilla/tipo de orden cuando esta el usuario responsable de cuadrilla en sesion
                $view['tabla'] = $this->model_mnt_solicitudes->consul_orden_tipo($id_tipo,$estatus,$_POST['result1'],$_POST['result2'],$band,$_POST['buscador'],'',$_POST['col_pdf']);
            }else{
                $view['tabla'] = $this->model_mnt_solicitudes->consul_orden_tipo('',$estatus,$_POST['result1'],$_POST['result2'],$band,$_POST['buscador'],'',$_POST['col_pdf']);
            }
            $view['general'] = 'Reporte General';
        }
//        die_pre($view);
            // Load all views as normal
            $this->load->view('reporte_pdf', $view);
            // Get output html
            $html = $this->output->get_output();
            // Load library
            $this->load->library('dompdf_gen');

            // Convert to PDF
            $this->dompdf->load_html(utf8_decode($html));
            $this->dompdf->render();
            $this->dompdf->stream("asignaciones.pdf", array('Attachment' => 0));
    }
    
    ////////////////////////Control de permisologia para usar las funciones
    public function hasPermissionClassA() 
    {//Solo si es usuario autoridad y/o Asistente de autoridad
        return ($this->session->userdata('user')['sys_rol'] == 'autoridad' || $this->session->userdata('user')['sys_rol'] == 'asist_autoridad' || $this->session->userdata('user')['sys_rol'] == 'jefe_mnt');
    }

    public function hasPermissionClassB() 
    {//Solo si es usuario "Director de Departamento" y/o "jefe de Almacen"
        return ($this->session->userdata('user')['sys_rol'] == 'director_dep' || $this->session->userdata('user')['sys_rol'] == 'jefe_alm');
    }

    public function hasPermissionClassC() 
    {//Solo si es usuario "Jefe de Almacen"
        return ($this->session->userdata('user')['sys_rol'] == 'jefe_alm');
    }

    public function hasPermissionClassD() 
    {//Solo si es usuario "Director de Dependencia y/o Asistente de dependencia"
        return ($this->session->userdata('user')['sys_rol'] == 'asistente_dep_alm' || $this->session->userdata('user')['sys_rol'] == 'asistente_dep_mnt'|| $this->session->userdata('user')['sys_rol'] == 'asistente_dep');
    }
    
    public function ayu_name($id='') {
     
        if ($this->input->post('id_trabajador')):
            $nombre = $this->model_user->get_user_cuadrilla($this->input->post('id_trabajador'));
//            echo_pre($nombre);
            echo $nombre; 
        elseif(!empty($id)):
            $nombre = $this->model_user->get_user_cuadrilla($id);  
           return $nombre;   
        else:
            return FALSE;
        endif;
        
    }

    ////////////////////////Fin del Control de permisologia para usar las funciones
}