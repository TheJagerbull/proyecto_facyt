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

                <label class="control-label" for = "responsable">Miembros de la Cuadrilla</label>
                <table id="miembro<?php echo $num_sol ?>" name="miembro" class="table table-hover table-bordered table-condensed">
                    <thead>
                        <tr>
                            <th><div align="center">Seleccione</div> </th>
                <th>Trabajador</th>
                </tr>
                </thead>

                <tbody>
                <?php foreach ($miembros as $miemb): ?>
                        <tr>
                            <td>
                                <div align="center">
                                    <div class="checkbox">
                                        <label class="checkbox-inline">
                                            <input name="campo[]" id="campo[]" type="checkbox" checked="checked" value="<?php echo($miemb->id_trabajador); ?>">
                                        </label>
                                    </div>
                                </div>
                            </td>
                            <td> <?php echo($miemb->trabajador); ?>   </td> 
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
        // die_pre($_POST);
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
//          $responsable = $_POST['responsable'];
//          echo_pre($num_sol);
//          echo_pre($cuadrilla);
//          echo_pre($responsable);
            $datos = array(
                'id_usuario' => $user,
                'id_cuadrilla' => $cuadrilla,
                'id_ordenes' => $num_sol);
            $this->model_asigna->set_cuadrilla($datos);
            $datos2 = array(
                'id_estado' => $var,
                'id_orden_trabajo' => $num_sol,
                'id_usuario' => $user,
                'fecha_p' => $fecha);
            $this->model_estatus->insert_orden($datos2);
            foreach ($miembros as $miemb):
                $datos3 = array(
                    'id_trabajador' => $miemb,
                    'id_orden_trabajo' => $num_sol);
                $this->db->insert('mnt_ayudante_orden', $datos3);
            endforeach;
            $datos4 = array(
                'fecha' => $fecha,
                'estatus' => $var);
            $this->model_sol->actualizar_orden($datos4, $num_sol);
            $this->session->set_flashdata('asigna_cuadrilla', 'success');
        elseif(isset($_POST['cut'])): //Para quitar la cuadrilla
            $num_sol = $_POST['cut'];
            $id_cuadrilla = $_POST['cuadrilla'];
            $var = 1;
            $miembros = $this->db->get('mnt_ayudante_orden')->result();
            foreach ($miembros as $miem)://hay que validar que sean los que estan asignados a la orden que estan en la tabla trabajador responsable
                if ($miem->id_orden_trabajo == $num_sol):
                   $id_trabajador = $miem->id_trabajador;                 
                   $quitar = array(
                    'id_trabajador' => $id_trabajador,
                    'id_orden_trabajo' => $num_sol);
                $this->db->where($quitar);
                $this->db->delete('mnt_ayudante_orden');//quitar los miembros de la cuadrilla en esta tabla
                endif;
            endforeach;
            $quitar2 = array(
                'id_usuario' => $user,
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
        else:
            $this->session->set_flashdata('asigna_cuadrilla', 'error');
        endif;
        redirect(base_url() . 'index.php/mnt_solicitudes/lista_solicitudes');
    }

}
