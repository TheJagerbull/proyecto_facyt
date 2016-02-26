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
        $this->load->model('mnt_responsable_orden/model_mnt_responsable_orden', 'model_responsable');
    }

    public function get_responsable() {//esta funcion permite mostrar quien es el responsable de la cuadrilla, es usada por ajax en cuad_asignada en mainFunctions.js
        if ($this->input->post('id')): // se recibe el id de la cuadrilla, como se ve no se usa $_POST o $_GET ya que viene de jquery
            $id_cuadrilla = $this->input->post('id');//Se asigna el post a una variable
            $cuadrilla = $this->model_cuadrilla->get_oneitem($id_cuadrilla);//se obtiene la data de esa cuadrilla con esta funcion
            echo $this->model_user->get_user_cuadrilla($cuadrilla['id_trabajador_responsable']);//se muestra el nombre del responsable
        endif;
    }

    public function mostrar_cuadrilla() {// esta funcion se usa para mostrar los miembros de una cuadrilla por ajax en mostrar en mainFunctions.js
        if ($this->input->post('id')): // se recibe el id de la cuadrilla, como se ve no se usa $_POST o $_GET ya que viene de jquery
            $id_cuadrilla = $this->input->post('id');//Se asigna el post a una variable
            $num_sol = $this->input->post('sol');//Se asigna el post a una variable
            $miembros = $this->model_miembros_cuadrilla->get_miembros_cuadrilla($id_cuadrilla);//se obtienen los miembros de la cuadrilla
//            echo_pre($miembros);
            if (!empty($miembros))://En caso de que el resultado no sea vacio se muestran los datos
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
      <?php else:
                ?>
                <div class="alert alert-warning" style="text-align: center">No hay trabajadores en esta cuadrilla</div>
            <?php
            endif;
        endif;
    }

    public function asignar_cuadrilla() { //Se usa para asignar o quitar la cuadrilla de una orden
//         die_pre($_POST);
        $uri=$_POST['uri']; ///Se asigna el post a una variable la cual contiene la direccion de la pagina de donde viene
        ($user = $this->session->userdata('user')['id_usuario']); //se obtiene el id del usuario en sesion
        $this->load->helper('date'); // el helper de fecha para guardar en formato de sql
        $datestring = "%Y-%m-%d %h:%i:%s";
        $time = time();
        $fecha = mdate($datestring, $time);
        if (isset($_POST['campo'])): //En caso de que exista esta variable en el POST 
            $var = "2"; //Se establece el id del cambio de estatus para luego guardarlo
            $num_sol = $_POST['num_sol']; ///Se asigna el post a una variable que contiene el numero de la solicitud
            $cuadrilla = $_POST['cuadrilla_select']; //Se asigna el post a una variable que contiene el id de la cuadrilla seleccionada
//          $miembros = implode(',', $_POST['campo']);
            $miembros = $_POST['campo']; //estos son los miembros de la cuadrilla seleccionada
            $this->load->helper('date');
            $datestring = "%Y-%m-%d %h:%i:%s";
            $time = time();
            $fecha = mdate($datestring, $time);
            $guardar = array( //Se hace el primer guardado que es el responsable de la orden
                'id_responsable' => $_POST['responsable'],
                'tiene_cuadrilla' => 'si',
                'id_orden_trabajo' => $num_sol);
            $this->model_responsable->set_resp($guardar);//Se va para el modelo para guardar los datos
            $datos = array( //Se hace la asignacion de la cuadrilla
                'id_usuario' => $user,
                'id_cuadrilla' => $cuadrilla,
                'id_ordenes' => $num_sol);
            $this->model_asigna->set_cuadrilla($datos);
            $datos2 = array( // se hace el cambio de estatus
                'id_estado' => $var,
                'id_orden_trabajo' => $num_sol,
                'id_usuario' => $user,
                'fecha_p' => $fecha);
            $this->model_estatus->insert_orden($datos2);//Se guarda el cambio de estatus
//            $asignados = $this->model_ayudante->ayudantesDeCuadrilla_enOrden($num_sol,$cuadrilla);//Se obtienen a los ayudantes de cuadrilla asignados a esa orden
//            foreach ($miembros as $i=>$miemb): //Se recorren los datos con la finalidad de evaluar si hay alguno que no pertenezca a una cuadrilla
//                foreach ($asignados as $asig):
//                  if ($miemb == $asig['id_trabajador']):
//                      unset($miembros[$i]);
//                  endif;
//                endforeach;
//            endforeach;
//            $miembros = array_values($miembros);
            foreach ($miembros as $miemb)://Se recorre para guardar a cada uno de los miembros de la cuadrilla en la orden a asignar
                $guardar = array(
                    'id_trabajador' => $miemb,
                    'id_orden_trabajo' => $num_sol);    
                $this->model_ayudante->ayudante_a_orden($guardar);//Se guardan los datos en ayudante orden
            endforeach;       
            $datos4 = array(//Se usa para la modificacion de la fecha en la tabla de solicitudes para que mueste la fecha en que se modificó
                'fecha' => $fecha,
                'estatus' => $var);
            $this->model_sol->actualizar_orden($datos4, $num_sol);//Se actualiza la orden
            $this->session->set_flashdata('asigna_cuadrilla', 'success');//Mensaje de que la cuadrilla fue asignada
        elseif(isset($_POST['cut'])): //Para quitar la cuadrilla o editar el responsable      
            $num_sol = $_POST['cut']; //Se asigna el post a una variable
            $id_cuadrilla = $_POST['cuadrilla'];///Se asigna el post a una variable
            if(isset($_POST['responsable'])):  //Editar responsable de la orden
                $mod = array(
                    'id_orden_trabajo' => $num_sol);
                $this->model_responsable->edit_resp($mod,$_POST['responsable']);
                $this->session->set_flashdata('asigna_cuadrilla', 'responsable');
//                die_pre($_POST);
            else://En caso de que no exista el $_POST de responsable es que se va a quitar la asignacion de la cuadrilla
                $quitar2 = array(
//                'id_usuario' => $user,//borrar esta linea, no hace falta, y puede provocar errores al quitar
                    'id_cuadrilla' => $id_cuadrilla,
                    'id_ordenes' => $num_sol);
                $this->model_asigna->quitar_cuadrilla($quitar2); //quita la asignacion de la cuadrilla
                $this->model_responsable->del_resp($num_sol); //quita el responsable del orden
                $asignados = $this->model_ayudante->ayudantesDeCuadrilla_enOrden($num_sol,$id_cuadrilla);//Se obtienen los ayudantes de cuadrilla asignados
                foreach ($asignados as $asig):
                    $quitar = array(
                        'id_trabajador' => $asig['id_trabajador'],
                        'id_orden_trabajo' => $asig['id_orden_trabajo']);    
                    $this->model_ayudante->ayudante_fuera_deOrden($quitar); //Se remueven los ayudantes de cuadrilla de la orden
                endforeach;
                $asignados = $this->model_ayudante->ayudantes_DeOrden($num_sol);//Para comprobar si aun hay ayudantes asignados    
                if(!empty($asignados))://evalua si aun quedan ayudantes asignados para el estado de la solicitud
                    $var = "2"; //Si no esta vacio la orden esta en proceso
                else:
                    $var="1"; //Si esta vacio la orden pasa a estar abierta
                endif;
                //desde aqui se actualiza el estatus de la orden 
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
    }//Fin 
}
