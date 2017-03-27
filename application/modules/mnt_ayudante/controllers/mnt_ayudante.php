<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Mnt_ayudante extends MX_Controller {

    function __construct() { //constructor predeterminado del controlador
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->library('pagination');
        $this->load->model('model_mnt_ayudante');
        $this->load->model('user/model_dec_usuario');
        $this->load->model('mnt_solicitudes/model_mnt_solicitudes');
        $this->load->model('mnt_estatus/model_mnt_estatus');
        $this->load->model('mnt_estatus_orden/model_mnt_estatus_orden');
        $this->load->model('mnt_cuadrilla/model_mnt_cuadrilla');
        $this->load->model('mnt_asigna_cuadrilla/model_mnt_asigna_cuadrilla');
        $this->load->model('mnt_responsable_orden/model_mnt_responsable_orden', 'model_responsable');
        $this->load->model('user/model_dec_usuario', 'model_user');
        $this->load->module('dec_permiso/dec_permiso');
    }

    public function asign_help() {//puede ser usado desde cualquier vista, siempre y cuando el post contenga:
//        die_pre($_POST);
        //un campo que se llame 'uri' que tenga anexo este valor $this->uri->uri_string(), para redireccionar a la vista de donde viene
        //un campo que se llame 'id_trabajador' que es el id del trabajador que se asignara a la orden y
        //un campo que se llame 'id_orden_trabajo' que es el id de la orden de trabajo a la cual se le asigna el ayudante
        if ($_POST) {
//            die_pre($_POST);
            $uri = $_POST['uri'];
            $num_sol = $_POST['id_orden_trabajo'];
            unset($_POST['uri']);
            $this->load->helper('date');
            $datestring = "%Y-%m-%d %h:%i:%s";
            $time = time();
            $fecha = mdate($datestring, $time);

            $i = 0; //para recorrer los "indices" de los inputs del formulario
            $asignados = FALSE; //variable auxiliar para validar que todos los ayudantes fueron asignados existosamente
            $removidos = FALSE; //variable auxiliar para validar que todos los ayudantes fueron removidos existosamente
            $a = 0; //contabiliza la cantidad de asignados
            $r = 0; //contabiliza la cantidad de removidos
            if (!empty($_POST['responsable'])) {
                $guardar = array(
                    'id_responsable' => $_POST['responsable'],
                    'tiene_cuadrilla' => 'no',
                    'id_orden_trabajo' => $_POST['id_orden_trabajo']);
                if (!($this->model_responsable->existe_resp(array('id_orden_trabajo' => $_POST['id_orden_trabajo'])))) {
                    $this->model_responsable->set_resp($guardar);
                    $insert = array(
                            'id_estado' => 1,
                            'id_orden_trabajo' => $num_sol,
                            'id_usuario' => $this->session->userdata('user')['id_usuario'],
                            'fecha_p' => $fecha,
                            'motivo_cambio' => 'asig_resp_ayud');
                        $this->model_mnt_estatus_orden->insert_orden($insert);
                } else {
                    $responsable = $this->model_responsable->get_responsable($_POST['id_orden_trabajo']);
                    $data = array(
                        'id_orden_trabajo' => $_POST['id_orden_trabajo']);
                    $this->model_responsable->edit_resp($data, $_POST['responsable']);
                    $this->model_mnt_ayudante->ayudante_fuera_deOrden(array('id_trabajador' => $responsable['id_responsable'], 'id_orden_trabajo' => $_POST['id_orden_trabajo']));
                };
                if (!$this->model_mnt_ayudante->ayudante_en_orden($_POST['responsable'], $_POST['id_orden_trabajo'])) {
                    $a = 1;
                    $guardar2 = array(
                        'id_trabajador' => $_POST['responsable'],
                        'id_orden_trabajo' => $_POST['id_orden_trabajo']);
                    $asignados = $asignados + $this->model_mnt_ayudante->ayudante_a_orden($guardar2);
                }
            };
            unset($_POST['responsable']);
            if (isset($_POST['cut'])){
                $responsable = $this->model_responsable->get_responsable($_POST['id_orden_trabajo']);
                $this->model_responsable->del_resp($_POST['id_orden_trabajo']);
                $this->model_mnt_ayudante->ayudante_fuera_deOrden(array('id_trabajador' => $responsable['id_responsable'], 'id_orden_trabajo' => $_POST['id_orden_trabajo']));
                $this->model_mnt_ayudante->ayudante_fuera_deOrden(array('id_orden_trabajo' => $_POST['id_orden_trabajo']));
                $update = array(
                    'fecha' => $fecha,
                    'estatus' => 1);
                $this->model_mnt_solicitudes->actualizar_orden($update, $num_sol);
                $insert = array(
                    'id_estado' => 1,
                    'id_orden_trabajo' => $num_sol,
                    'id_usuario' => $this->session->userdata('user')['id_usuario'],
                    'fecha_p' => $fecha,
                    'motivo_cambio' => 'cut_resp_ayud');
                $this->model_mnt_estatus_orden->insert_orden($insert);
                unset($_POST);
            };
            while (sizeof($_POST) > 1) {//pasa el arreglo del post completo, para luego separar los id's de los trabajadores a asignar, y los trabajadores a remover de la orden
                if (array_key_exists('assign' . $i, $_POST)) {//aqui agarra los que van a ser asignados
                    $a++;
                    $aux = array(
                        'id_trabajador' => $_POST['assign' . $i],
                        'id_orden_trabajo' => $_POST['id_orden_trabajo']
                    );
                    // echo_pre($aux, __LINE__, __FILE__);
                    if (!$this->model_mnt_ayudante->ayudante_en_orden($aux['id_trabajador'], $aux['id_orden_trabajo'])) {
                        $asignados = $asignados + $this->model_mnt_ayudante->ayudante_a_orden($aux);
                        // $asignados=$asignados+TRUE;
                    }
                    unset($_POST['assign' . $i]); //desmonta del arreglo
                }
                if (array_key_exists('remove' . $i, $_POST)) {//aqui agarra los que van a ser removidos de la orden
                    $r++;
                    $aux = array(
                        'id_trabajador' => $_POST['remove' . $i],
                        'id_orden_trabajo' => $_POST['id_orden_trabajo']
                    );
                    // echo_pre($aux, __LINE__, __FILE__);
                    $removidos = $removidos + $this->model_mnt_ayudante->ayudante_fuera_deOrden($aux);
                    unset($_POST['remove' . $i]); //desmonta del arreglo
                }
                $i++;
            }
////////////////////////opcional
            if (array_key_exists('id_trabajador', $_POST)) {//por si se quiere asignar un ayudante desde otra vista, y solo 1
                if (!$this->model_mnt_ayudante->ayudante_en_orden($_POST['id_trabajador'], $_POST['id_orden_trabajo'])) {
                    $a = 1;
                    $asignados = $asignados + $this->model_mnt_ayudante->ayudante_a_orden($_POST);
                }
            }
/////////////////////////fin de opcional


            if ($a > 0) {
                if ($asignados) {
                    //actualizar en mnt_solicitudes
                    //fecha (fecha de timestamp), y estatus (2 correspondiente a "EN_PROCESO")
                    $update = array(
                        'fecha' => $fecha,
                        'estatus' => 2);
                    $this->model_mnt_solicitudes->actualizar_orden($update, $num_sol);
                    //guardar en mnt_estatus_orden con valores de:
                    //id_estado (respectivo a "EN_PROCESO"), id_orden_trabajo (id de la orden de trabajo), id_usuario (el id del usuario de session), fecha_p (formato timestamp)
                    $insert = array(
                        'id_estado' => 2,
                        'id_orden_trabajo' => $num_sol,
                        'id_usuario' => $this->session->userdata('user')['id_usuario'],
                        'fecha_p' => $fecha,
                        'motivo_cambio' => 'asig_ayud');
                    $this->model_mnt_estatus_orden->insert_orden($insert);
                    $this->session->set_flashdata('asign_help', 'success');
                } else {
                    $this->session->set_flashdata('asign_help', 'error');
                }
            }
            if ($r > 0) {
                if ($removidos) {
                    $cuadrilla = $this->model_mnt_asigna_cuadrilla->tiene_cuadrilla(intval($num_sol));
                    if ($cuadrilla) {//si tiene una cuadrilla asignada
                        $aux = $this->model_mnt_ayudante->ayudantesDeCuadrilla_enOrden($num_sol, $cuadrilla);
                        if (empty($aux)) {
                            $array = array('id_ordenes' => intval($num_sol), 'id_cuadrilla' => $cuadrilla);
                            $this->quitar_cuadrilla($array);
                        }
                    }
                    if ($this->model_mnt_ayudante->ayudantes_enOrden($num_sol) == 0) {
                        $update = array(
                            'fecha' => $fecha,
                            'estatus' => 1);
                        $this->model_mnt_solicitudes->actualizar_orden($update, $num_sol);
                        $insert = array(
                            'id_estado' => 1,
                            'id_orden_trabajo' => $num_sol,
                            'id_usuario' => $this->session->userdata('user')['id_usuario'],
                            'fecha_p' => $fecha,
                            'motivo_cambio' => 'cut_ayud');
                        $this->model_mnt_estatus_orden->insert_orden($insert);
                    }
                    $this->session->set_flashdata('asign_help', 'success');
                } else {
                    $this->session->set_flashdata('asign_help', 'error');
                }
            }
            redirect($uri);
        } else {
            $header['title'] = 'Error de Acceso';
            $this->load->view('template/erroracc', $header);
        }
    }

    public function assigned($id_orden_trabajo) {
        // echo_pre($id_orden_trabajo, __LINE__, __FILE__);
        // die_pre($this->model_mnt_ayudante->ayudantes_DeOrden($id_orden_trabajo), __LINE__, __FILE__);
        return($this->model_mnt_ayudante->ayudantes_DeOrden($id_orden_trabajo));
    }

    public function unassigned($id_orden_trabajo) {
        // echo_pre($id_orden_trabajo, __LINE__, __FILE__);
        // die_pre($this->model_mnt_ayudante->ayudantes_NoDeOrden($id_orden_trabajo), __LINE__, __FILE__);
        return($this->model_mnt_ayudante->ayudantes_NoDeOrden($id_orden_trabajo));
    }

    public function mostrar_unassigned() {
        if ($this->input->post('id')):
            $id_orden_trabajo = $this->input->post('id');
            $ayudantes = $this->unassigned($id_orden_trabajo);
            ?>

            <?php if (!empty($ayudantes)) : ?>
                <!--<h4> Lista de ayudantes disponibles </h4>-->
                <table id="ayudisp<?php echo $id_orden_trabajo ?>" class="table table-hover table-bordered table-condensed" width="100%">
                    <thead>
                        <tr>
                            <th><div align="center">Trabajador</div></th>
                <th><div align="center">Agregar</div></th>
                </tr>
                </thead>
                <tbody>

                <?php foreach ($ayudantes as $index => $worker) : ?>
                        <tr>
                            <td><?php echo ucfirst($worker['nombre']) . '  ' . ucfirst($worker['apellido']) ?></td>
                            <td align="center">
                                <input form="ay<?php echo $id_orden_trabajo ?>" type="checkbox" name="assign<?php echo $index ?>" value="<?php echo $worker['id_usuario'] ?>"/>
                            </td>
                        </tr>
                <?php endforeach ?>
                </tbody>
                </table>

            <?php else: ?>
                <div class="alert alert-warning" style="text-align: center">No hay ayudantes disponibles para asignar</div>
            <?php endif ?>
            <?php
        endif;
    }

    public function mostrar_assigned() {
        if ($this->input->post('id')):
            $id_orden_trabajo = $this->input->post('id');
            $estatus = $this->input->post('estatus');
            $ayudantes = $this->assigned($id_orden_trabajo);
            ?>

            <?php if (!empty($ayudantes)) : ?>
                <form id="ay<?php echo $id_orden_trabajo ?>" class="form-horizontal" action="<?php echo base_url() ?>mnt/desasignar/ayudante" method="post">
                    <!--<h4>Lista de ayudantes asignados </h4>-->
                    <table id="ayudasig<?php echo $id_orden_trabajo ?>" class="table table-hover table-bordered table-condensed" width="100%">
                        <thead>
                            <tr>
                                <th><div align="center">Trabajador</div></th>
                <?php if (($estatus != '3') && ($estatus != '4')) : //evaluar el estatus de la solicitud con el fin de mostrar o no la asignacion-->
                      if (strtoupper($this->session->userdata('user')['cargo']) != 'JEFE DE CUADRILLA') {?>
                        <th><div align="center">Quitar</div></th>
                      <?php }endif; ?>   <!-- evaluar el estatus de la solicitud con el fin de mostrar o no la asignacion-->
                        </tr>
                        </thead>
                        <tbody>

                <?php foreach ($ayudantes as $index => $worker) : ?>
                                <tr>
                                    <td><?php echo ucfirst($worker['nombre']) . '  ' . ucfirst($worker['apellido']) ?></td>
                    <?php if (($estatus != '3') && ($estatus != '4')) : // evaluar el estatus de la solicitud con el fin de mostrar o no la asignacion-->
                                 if (strtoupper($this->session->userdata('user')['cargo']) != 'JEFE DE CUADRILLA') {?>   
                                        <td align="center">
                                            <input form="ay<?php echo $id_orden_trabajo ?>" type="checkbox" name="remove<?php echo $index ?>" value="<?php echo $worker['id_usuario'] ?>"/>
                                        </td>
                                 <?php }
                        endif; ?> <!-- evaluar el estatus de la solicitud con el fin de mostrar o no la asignacion-->

                                </tr>
                <?php endforeach ?>
                        </tbody>
                    </table>
                </form>
            <?php else: ?>
                <div class="alert alert-warning" style="text-align: center">No hay ayudantes asignados a esta solicitud</div>
                    <?php endif ?>
                    <?php
                endif;
            }

            public function quitar_cuadrilla($array) {//cut, cuadrilla
                $this->model_mnt_asigna_cuadrilla->quitar_cuadrilla($array); //quita la asignacion de la cuadrilla
                $this->session->set_flashdata('asigna_cuadrilla', 'quitar');
            }

            /* End of file mnt_ayudante.php */
            /* Location: ./application/modules/mnt_ayudante/controllers/mnt_ayudante.php */

            public function reportes() {
                $results = $this->model_mnt_ayudante->get_list(); //Va al modelo para tomar los datos para llenar el datatable
                echo json_encode($results); //genera la salida de datos
            }

            public function reporte() {
                if ($this->dec_permiso->has_permission('mnt', 15)) {
                    if ($this->dec_permiso->has_permission('mnt', 9) || $this->dec_permiso->has_permission('mnt', 10) || $this->dec_permiso->has_permission('mnt', 11) || $this->dec_permiso->has_permission('mnt', 13)) {
                        $view['ver'] = 1;
                    } else {
                        $view['ver'] = 0;
                    }
                    if ($this->dec_permiso->has_permission('mnt', 12)) {
                        $view['close'] = 1;
                    } else {
                        $view['close'] = 0;
                    }
                    if ($this->dec_permiso->has_permission('mnt', 14)) {
                        $view['ver_asig'] = 1;
                    } else {
                        $view['ver_asig'] = 0;
                    }
                    if ($this->dec_permiso->has_permission('mnt', 1)) {
                        $view['crear'] = 1;
                    } else {
                        $view['crear'] = 0;
                    }
                    if ($this->dec_permiso->has_permission('mnt', 2)) {
                        $view['crear_dep'] = 1;
                    } else {
                        $view['crear_dep'] = 0;
                    }
                    $header['title'] = 'Reporte por trabajador';          //	variable para la vista
                    $view['estatus'] = $this->model_mnt_estatus->get_estatus3();
//            echo_pre($view['estatus']);
                    //CARGA LA VISTA PARA EL REPORTE
                    $header = $this->dec_permiso->load_permissionsView();
                    $this->load->view('template/header', $header);
                    $this->load->view('mnt_ayudante/reporte_trabajador', $view);
                    $this->load->view('template/footer');
                } else {
                    $this->session->set_flashdata('permission', 'error');
                    redirect('inicio');
                }
            }

            public function load_ayu_asig() {
//        echo_pre($this->input->post('estatus'));
                $band = 0; //Esta variable se usa con la intencion de no repetir la funcion del modelo donde se obtienen los datos
                if ($this->input->post('fecha1') && $this->input->post('fecha2') && $this->input->post('estatus')):
                    $cont = 0; //Esta se usa para contar la cantidad de datos encontrados
                    $todos = $this->model_user->get_userObrero();
                    ?><option></option><?php
            foreach ($todos as $all):
//                echo $this->model_mnt_ayudante->consul_trabaja_sol($all['id_usuario'],$this->input->post('estatus'),$this->input->post('fecha1'),$this->input->post('fecha2'),$band);
                if ($this->model_mnt_ayudante->consul_trabaja_sol($all['id_usuario'], $this->input->post('estatus'), $this->input->post('fecha1'), $this->input->post('fecha2'), $band)):
                    $cont++;
                    ?>
                    <option value="<?php echo $all['id_usuario'] ?>"><?php echo ($all['nombre'] . ' ' . $all['apellido']); ?></option>
                <?php
                endif;
            endforeach;
            if ($cont > 1):
                ?><option value="all">Todos</option><?php
            endif;
        endif;
    }

    public function load_consult() {
        $band = 1; //para que me muestre los datos consultados en el modelo
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
            $datos = $this->model_mnt_ayudante->consul_trabaja_sol($this->input->post('id_trabajador'), $this->input->post('estatus'), $this->input->post('fecha1'), $this->input->post('fecha2'), $band);
            $total_datos = count($datos); //Para tener la cantidad de datos obtenidos
            ?>
                <div class="panel-heading">
            <?php
            foreach ($datos as $dat):
                if ($total_datos >= 1):
                    $total_datos = 0;
                    ?>             
                            <label><strong><?php echo $dat['Nombre'] . ' ' . $dat['Apellido'] ?></strong></label>
                            <div class="btn-group btn-group-sm pull-right">
                                <label><strong></strong> Estatus : <?php echo $estatus ?></strong> </label>
                            </div>
                    <?php
                endif;
            endforeach;
            ?>
                </div>
                <div class="panel-body">
                    <div class="col-md-12 col-xs-12">
                        <p>Desde: <strong><?php echo date("d/m/Y", strtotime($this->input->post('fecha1'))) ?></strong>
                            Hasta: <strong><?php echo date("d/m/Y", strtotime($this->input->post('fecha2'))) ?></strong></p>
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
            <?php foreach ($datos as $index => $dat) : ?>  
                                <tr>
                                    <td><div align="center"><?php echo ucfirst($dat['Orden']) ?></div></td>
                                    <td><div align="center"><?php echo date("d/m/Y", strtotime($dat['fecha'])) ?></div></td>
                                    <td><div align="center"><?php echo ucfirst($dat['Dependencia']) ?></div></td>
                                    <td><div align="center"><?php echo ucfirst($dat['Asunto']) ?></div></td>
                                </tr>
            <?php endforeach ?>
                        </tbody>
                    </table>
                </div>
            <?php
        elseif ($this->input->post('id_trabajador') == 'all'):
            $datos = $this->model_mnt_ayudante->consul_trabaja_sol('', $this->input->post('estatus'), $this->input->post('fecha1'), $this->input->post('fecha2'), $band);
//            die_pre($datos);
            ?>
                <style>
                    tr.group,
                    tr.group:hover {
                        background-color: #ddd !important;
                    }
                </style>
                <script type="text/javascript">
                    $(document).ready(function () {
                        var table = $('#trabajador').DataTable({
            //                      buttons: [
            //                      {
            //                          extend: 'print',
            //                          text: '<i class="glyphicon glyphicon-print"></i>',
            //                          titleAttr: 'Imprimir',
            //                          title: "Reporte por trabajador",
            //                          message: "Desde: "+moment(<?php $this->input->post('fecha1') ?>).format('Do MMM YYYY')+" ' ' "+"Hasta: "+moment(<?php $this->input->post('fecha2') ?>).format('Do MMM YYYY'),
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
                            "language": {
                                "url": "<?php echo base_url() ?>assets/js/lenguaje_datatable/spanish.json"
                            },
                            "pagingType": "full_numbers",
                            "columnDefs": [
                                {"visible": false, "targets": 0}
                            ],
            //                    "serverSide": true,
                            "order": [[0, 'asc']],
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
            //                        "url": "<?php echo site_url('mnt_ayudante/mnt_ayudante/reportes') ?>",
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
                            "drawCallback": function (settings) {
                                var api = this.api();
                                var rows = api.rows({page: 'current'}).nodes();
                                var last = null;
                                api.column(0, {page: 'current'}).data().each(function (group, i) {
                                    if (last !== group) {
                                        $(rows).eq(i).before(
                                                '<tr class="group"><td colspan="5">Trabajador: ' + group + '</td></tr>'
                                                );
                                        last = group;
                                    }
                                });
                            }
                        });

                        // Order by the grouping
                        $('#trabajador tbody').on('click', 'tr.group', function () {
                            var currentOrder = table.order()[0];
                            if (currentOrder[0] === 0 && currentOrder[1] === 'asc') {
                                table.order([0, 'desc']).draw();
                            }
                            else {
                                table.order([0, 'asc']).draw();
                            }
                        });
                    });
                </script>
                <div class="panel-heading">
                    <label><strong>Todos los trabajadores</strong></label>
                    <div class="btn-group btn-group-sm pull-right">
                        <label><strong></strong> Estatus : <?php echo $estatus ?></strong> </label>
                    </div>
                </div>
                <div class="panel-body">
                    <div class="col-md-12 col-xs-12">
                        <p>Desde: <strong><?php echo date("d/m/Y", strtotime($this->input->post('fecha1'))) ?></strong>
                            Hasta: <strong><?php echo date("d/m/Y", strtotime($this->input->post('fecha2'))) ?></strong></p>
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
            <?php foreach ($datos as $index => $dat) : ?>  
                                <tr>
                                    <td><?php echo ucfirst($dat['Nombre'] . ' ' . $dat['Apellido']) ?></td>
                                    <td><div align="center"><?php echo ucfirst($dat['Orden']) ?></div></td>
                                    <td><div align="center"><?php echo date("d/m/Y", strtotime($dat['fecha'])) ?></div></td>
                                    <td><div align="center"><?php echo ucfirst($dat['Dependencia']) ?></div></td>
                                    <td><div align="center"><?php echo ucfirst($dat['Asunto']) ?></div></td>
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

            public function pdf_reportes_worker() {//aqui estoy haciendo los reportes
                $band = 1;
                die_pre($_POST);
                // echo_pre('permiso para ver reportes', __LINE__, __FILE__);
                if (($_POST['tipo']) == 'trabajador'):
                    $view['cabecera'] = "Reportes por trabajador"; //titulo acompanante de la cabecera del documento
                endif;
                if (($_POST['tipo']) == 'responsable'):
                    $view['cabecera'] = "Reportes por responsable"; //titulo acompanante de la cabecera del documento
                endif;
                if (($_POST['tipo']) == 'tipo_orden'):
                    $view['cabecera'] = "Reportes por Tipo de Orden"; //titulo acompanante de la cabecera del documento
                endif;
                $view['nombre_tabla'] = "reportes"; //nombre de la tabla que construira el modelo
                $view['fecha1'] = date("d/m/Y", strtotime($_POST['fecha1']));
                $view['fecha2'] = date("d/m/Y", strtotime($_POST['fecha2']));
                $view['estatus'] = $this->model_mnt_estatus->get_estatus_id($_POST['estatus']);
                $view['tipo'] = $_POST['tipo'];
                if (($_POST['tipo']) == 'trabajador'):
                    if (isset($_POST['id_trabajador'])):
                        $view['tabla'] = $this->model_mnt_ayudante->consul_trabaja_sol($_POST['id_trabajador'], $_POST['estatus'], $_POST['fecha1'], $_POST['fecha2'], $band); //construccion de la tabla
                        $view['trabajador'] = $this->model_user->get_user_cuadrilla($_POST['id_trabajador']);
//            echo_pre($view);
                    else:
                        $view['tabla'] = $this->model_mnt_ayudante->consul_trabaja_sol('', $_POST['estatus'], $_POST['fecha1'], $_POST['fecha2'], $band); //construccion de la tabla
                    endif;
                endif;
                if (($_POST['tipo']) == 'responsable'):
                    if (isset($_POST['id_trabajador'])):
                        $view['tabla'] = $this->model_responsable->consul_respon_sol($_POST['id_trabajador'], $_POST['estatus'], $_POST['fecha1'], $_POST['fecha2'], $band);
                        $view['trabajador'] = $this->model_user->get_user_cuadrilla($_POST['id_trabajador']);
                        foreach ($view['tabla'] as $dat):
                            $ayudantes[$dat['id_orden']] = $this->model_mnt_ayudante->ayudantes_DeOrden($dat['id_orden']);
                        endforeach;
                        $view['ayudantes'] = $ayudantes;
//            echo_pre($view);
                    else:
                        $view['tabla'] = $this->model_responsable->consul_respon_sol('', $_POST['estatus'], $_POST['fecha1'], $_POST['fecha2'], $band);
                        foreach ($view['tabla'] as $dat):
                            $ayudantes[$dat['id_orden']] = $this->model_mnt_ayudante->ayudantes_DeOrden($dat['id_orden']);
                        endforeach;
                        $view['ayudantes'] = $ayudantes;
                    endif;
                endif;
                if (($_POST['tipo']) == 'tipo_orden'):
                    if (isset($_POST['id_cuad'])):
                        $view['tabla'] = $this->model_mnt_asigna_cuadrilla->consul_cuad_sol($_POST['id_cuad'], $_POST['estatus'], $_POST['fecha1'], $_POST['fecha2'], $band);
                        $view['cuadrilla'] = $this->model_mnt_cuadrilla->get_nombre_cuadrilla($_POST['id_cuad']);
                        foreach ($view['tabla'] as $dat):
                            $ayudantes[$dat['id_orden']] = $this->model_mnt_ayudante->ayudantes_DeOrden($dat['id_orden']);
                        endforeach;
                        $view['ayudantes'] = $ayudantes;
//            echo_pre($view);
                    else:
                        $view['tabla'] = $this->model_mnt_asigna_cuadrilla->consul_cuad_sol('', $_POST['estatus'], $_POST['fecha1'], $_POST['fecha2'], $band);
                        foreach ($view['tabla'] as $dat):
                            $ayudantes[$dat['id_orden']] = $this->model_mnt_ayudante->ayudantes_DeOrden($dat['id_orden']);
                        endforeach;
                        $view['ayudantes'] = $ayudantes;
                    endif;
                endif;
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
            public function hasPermissionClassA() {//Solo si es usuario autoridad y/o Asistente de autoridad
                return ($this->session->userdata('user')['sys_rol'] == 'autoridad' || $this->session->userdata('user')['sys_rol'] == 'asist_autoridad' || $this->session->userdata('user')['sys_rol'] == 'jefe_mnt');
            }

            public function hasPermissionClassB() {//Solo si es usuario "Director de Departamento" y/o "jefe de Almacen"
                return ($this->session->userdata('user')['sys_rol'] == 'director_dep' || $this->session->userdata('user')['sys_rol'] == 'jefe_alm');
            }

            public function hasPermissionClassC() {//Solo si es usuario "Jefe de Almacen"
                return ($this->session->userdata('user')['sys_rol'] == 'jefe_alm');
            }

            public function hasPermissionClassD() {//Solo si es usuario "Director de Dependencia y/o Asistente de dependencia"
                return ($this->session->userdata('user')['sys_rol'] == 'asistente_dep_alm' || $this->session->userdata('user')['sys_rol'] == 'asistente_dep_mnt' || $this->session->userdata('user')['sys_rol'] == 'asistente_dep');
            }

            public function isOwner($user = '') {
                if (!empty($user) || $this->session->userdata('user')) {
                    return $this->session->userdata('user')['ID'] == $user['ID'];
                } else {
                    return FALSE;
                }
            }

            public function ayu_name($id = '') {

                if ($this->input->post('id_trabajador')):
                    $nombre = $this->model_user->get_user_cuadrilla($this->input->post('id_trabajador'));
//            echo_pre($nombre);
                    echo $nombre;
                elseif (!empty($id)):
                    $nombre = $this->model_user->get_user_cuadrilla($id);
                    return $nombre;
                else:
                    return FALSE;
                endif;
            }

            ////////////////////////Fin del Control de permisologia para usar las funciones
        }
        