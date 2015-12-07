<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Mnt_asigna_cuadrilla extends MX_Controller {

    function __construct() { //constructor predeterminado del controlador
        parent::__construct(); //carga los helpers
        $this->load->helper('array');
        $this->load->library('form_validation');
        $this->load->library('pagination');
        $this->load->model('mnt_solicitudes/model_mnt_solicitudes', 'model_sol');
        $this->load->model('model_mnt_asigna_cuadrilla', 'model_asigna');
        $this->load->model('mnt_tipo/model_mnt_tipo_orden', 'model_tipo');
        $this->load->model('dec_dependencia/model_dec_dependencia', 'model_dependen');
        $this->load->model('mnt_ubicaciones/model_mnt_ubicaciones_dep', 'model_ubicacion');
        $this->load->model('mnt_cuadrilla/model_mnt_cuadrilla', 'model_cuadrilla');
        $this->load->model('mnt_asigna_cuadrilla/model_mnt_asigna_cuadrilla', 'model_asigna');
        $this->load->model('mnt_miembros_cuadrilla/model_mnt_miembros_cuadrilla', 'model_miembros_cuadrilla');
        $this->load->model('user/model_dec_usuario', 'model_user');
        $this->load->model('mnt_estatus_orden/model_mnt_estatus_orden', 'model_estatus');
        $this->load->model('mnt_ayudante/model_mnt_ayudante', 'model_ayudante');
    }

    public function get_responsable() {
        if ($this->input->post('id')):
            $id_responsable = $this->input->post('id');
            //echo_pre($vienenombre);
            $cuadrilla = $this->model_cuadrilla->get_cuadrillas();
            $i = 0;
            foreach ($cuadrilla as $cua):
                if ($id_responsable == $cua->id):
                    $id[$i]['nombre'] = $this->model_user->get_user_cuadrilla($cua->id_trabajador_responsable);
                    $cua->nombre = $id[$i]['nombre'];
                    echo $cua->nombre;
                    $id_cuad = $cua->id;
                endif;
                $i++;
            endforeach;
        endif;
    }

    public function mostrar_cuadrilla() {
        if ($this->input->post('id')):
            $id_cuadrilla = $this->input->post('id');
            $num_sol = $this->input->post('sol');
            $miembros = $this->model_miembros_cuadrilla->get_miembros_cuadrilla($id_cuadrilla);
//            echo_pre($miembros);
            if (!empty($miembros)):
                ?>
                 
                <div align="center"><label for = "cuadrilla">Miembros de la cuadrilla seleccionada</label></div>
                <table id="miembro<?php echo $num_sol ?>" name="miembro" class="table table-hover table-bordered table-condensed">
                    <thead>
                        <tr>
                          <th><div align="center">Trabajador</div></th>
                </tr>
                </thead>

                <tbody>
                <?php foreach ($miembros as $miemb): ?>
                        <tr>
                            <td> <?php echo($miemb->trabajador);?>   </td> 
                            <input name="campo[]" id="campo[]" type="hidden" value="<?php echo($miemb->id_trabajador); ?>"
                        </tr>
                <?php endforeach; ?>
                </tbody>

                </table>

                <?php else :
                ?>
                <div class="alert alert-warning" style="text-align: center">No hay trabajadores en esta cuadrilla</div>
            <?php
            endif;
        endif;
    }

    public function asignar_cuadrilla() {
//         die_pre($_POST);
        $uri=$_POST['uri'];
        ($user = $this->session->userdata('user')['id_usuario']);
        $this->load->helper('date');
            $datestring = "%Y-%m-%d %h:%i:%s";
            $time = time();
            $fecha = mdate($datestring, $time);
        if (isset($_POST['campo'])):
            $var = "2";
            $num_sol = $_POST['num_sol'];
            $cuadrilla = $_POST['cuadrilla_select'];
//          $miembros = implode(',', $_POST['campo']);
            $miembros = $_POST['campo'];
            $this->load->helper('date');
            $datestring = "%Y-%m-%d %h:%i:%s";
            $time = time();
            $fecha = mdate($datestring, $time);
            $datos = array(
                'id_usuario' => $user,
                'id_cuadrilla' => $cuadrilla,
                'responsable_orden' => $_POST['responsable'],
                'id_ordenes' => $num_sol);
            $this->model_asigna->set_cuadrilla($datos);
            $datos2 = array(
                'id_estado' => $var,
                'id_orden_trabajo' => $num_sol,
                'id_usuario' => $user,
                'fecha_p' => $fecha);
            $this->model_estatus->insert_orden($datos2);
            $asignados = $this->model_ayudante->ayudantesDeCuadrilla_enOrden($num_sol,$cuadrilla);
            foreach ($miembros as $i=>$miemb):
                foreach ($asignados as $asig):
                  if ($miemb == $asig['id_trabajador']):
                      unset($miembros[$i]);
                  endif;
                endforeach;
            endforeach;
            $miembros = array_values($miembros);
            foreach ($miembros as $miemb):
                $guardar = array(
                    'id_trabajador' => $miemb,
                    'id_orden_trabajo' => $num_sol);    
                $this->model_ayudante->ayudante_a_orden($guardar);
            endforeach;       
            $datos4 = array(
                'fecha' => $fecha,
                'estatus' => $var);
            $this->model_sol->actualizar_orden($datos4, $num_sol);
            $this->session->set_flashdata('asigna_cuadrilla', 'success');
        elseif(isset($_POST['cut'])): //Para quitar la cuadrilla o edtar el responsable      
            $num_sol = $_POST['cut'];
            $id_cuadrilla = $_POST['cuadrilla'];
            if(isset($_POST['responsable'])):  //Editar responsable de la orden
                $mod = array(
                    'id_cuadrilla' => $id_cuadrilla,
                    'id_ordenes' => $num_sol);
                $this->model_asigna->edit_resp($mod,$_POST['responsable']);
                $this->session->set_flashdata('asigna_cuadrilla', 'responsable');
//                die_pre($_POST);
            else:
                $asignados = $this->model_ayudante->ayudantesDeCuadrilla_enOrden($num_sol,$id_cuadrilla);
                foreach ($asignados as $asig):
                    $quitar = array(
                        'id_trabajador' => $asig['id_trabajador'],
                        'id_orden_trabajo' => $asig['id_orden_trabajo']);    
                    $this->model_ayudante->ayudante_fuera_deOrden($quitar);
                endforeach;
                $asignados = $this->model_ayudante->ayudantes_DeOrden($num_sol);    
                if(!empty($asignados))://evalua si aun quedan ayudantes asignados para el estado de la solicitud
                    $var = "2";
                else:
                    $var="1";
                endif;
                $quitar2 = array(
//                'id_usuario' => $user,//borrar esta linea, no hace falta, y puede provocar errores al quitar
                    'id_cuadrilla' => $id_cuadrilla,
                    'id_ordenes' => $num_sol);
                $this->model_asigna->quitar_cuadrilla($quitar2); //quita la asignacion de la cuadrilla
                $actualizar = array(
                    'id_estado' => $var,
                    'id_orden_trabajo' => $num_sol,
                    'id_usuario' => $user,
                    'fecha_p' => $fecha);
                $this->model_estatus->insert_orden($actualizar);//inserta un nuevo estado de la solicitud
                $datos4 = array(
                    'fecha' => $fecha,
                    'estatus' => $var);
                $this->model_sol->actualizar_orden($datos4, $num_sol);//Actualizar la orden de trabajo
                $this->session->set_flashdata('asigna_cuadrilla', 'quitar');
            endif;

        else:
            $this->session->set_flashdata('asigna_cuadrilla', 'error');
        endif;
        redirect($uri);
    }

public function select_responsable() {
        if ($this->input->post('id')) {
            $id_cuadrilla = $this->input->post('id');
            $miembros = $this->model_miembros_cuadrilla->get_miembros_cuadrilla($id_cuadrilla);
            if ($this->input->post('sol')):
                foreach ($miembros as $fila) {
                    if ($this->model_asigna->es_respon_orden($id_cuadrilla,$fila->id_trabajador,$this->input->post('sol'))):?> 
                        <option selected value="<?= $fila->id_trabajador?>"><?= $fila->trabajador ?></option>
              <?php else:?>
                        <option value="<?= $fila->id_trabajador ?>"><?= $fila->trabajador ?></option>
              <?php endif;
                }
            else:
                foreach ($miembros as $fila) {
                    if($this->model_cuadrilla->es_responsable($fila->id_trabajador,$id_cuadrilla)):?> 
                        <option selected value="<?= $fila->id_trabajador?>"><?= $fila->trabajador ?></option>                     
              <?php else:?>
                        <option value="<?= $fila->id_trabajador ?>"><?= $fila->trabajador ?></option>
              <?php endif; 
                }
            endif;    
        }
    }
    
}
