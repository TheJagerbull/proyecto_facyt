<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Mnt_asigna_cuadrilla extends MX_Controller {

    function __construct() { //constructor predeterminado del controlador
        parent::__construct(); //carga los helpers
        $this->load->helper('array');
        $this->load->library('form_validation');
        $this->load->library('pagination');
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
            $miembros = $this->model_miembros_cuadrilla->get_miembros();
            ?>
            <label class="control-label" for = "responsable">Miembros de la Cuadrilla</label>
            <table id="miembro" name="miembro" class="table table-hover table-condensed" cellspacing="0" width="5%">
                <thead>
                    <tr>
                        <th><div align="center">Seleccione</div> </th>
            <th>Nombre</th>
            </tr>
            </thead>
            <?php
            $i = 0;
            foreach ($miembros as $miemb):
                if ($id_cuadrilla == $miemb->id_cuadrilla):
                    $new[$i]['miembros'] = $this->model_user->get_user_cuadrilla($miemb->id_trabajador);
                    if (!empty($new[$i]['miembros'])):  //Valida que esto no retorne vacio, ya que al retornar vacio quiere decir que el trabajador esta inactivo
                        $miemb->miembros = $new[$i]['miembros'];
                        ?>
                        <tbody>
                            <tr>
                                <td>
                                    <div class="checkbox" align="center">
                                        <label>
                                            <input name="campo[]" id="campo[]" type="checkbox" checked="checked" value="<?php echo($miemb->id_trabajador); ?>">
                                        </label>
                                    </div>
                                </td>
                                <td> <?php echo($miemb->miembros); ?>   </td> 
                            </tr>
                        </tbody>
                        <?php
                    endif;
                    $i++;
                endif;
            endforeach;
            ?>
            </table>
            <?php
        endif;
    }

    public function asignar_cuadrilla() {

        if (isset($_POST['campo'])):
            ($user = $this->session->userdata('user')['id_usuario']);
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
            $this->model_estatus->change_status($datos2, $num_sol);
            foreach ($miembros as $miemb):
                $datos3 = array(
                'id_trabajador' => $miemb,
                'id_orden_trabajo' => $num_sol);
                $this->db->insert('mnt_ayudante_orden', $datos3);
            endforeach;
            $this->session->set_flashdata('asigna_cuadrilla', 'success');
            redirect(base_url() . 'index.php/mnt_solicitudes/listar');
        else:
            $this->session->set_flashdata('asigna_cuadrilla', 'error');
            redirect(base_url() . 'index.php/mnt_solicitudes/listar');
        endif;
    }

}
