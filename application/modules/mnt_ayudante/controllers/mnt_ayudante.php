<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Mnt_ayudante extends MX_Controller
{
	function __construct() //constructor predeterminado del controlador
    {
        parent::__construct();
        $this->load->library('form_validation');
		$this->load->library('pagination');
		$this->load->model('model_mnt_ayudante');
		$this->load->model('user/model_dec_usuario');
        $this->load->model('mnt_solicitudes/model_mnt_solicitudes');
        $this->load->model('mnt_estatus_orden/model_mnt_estatus_orden');
    }

    public function asign_help()//puede ser usado desde cualquier vista, siempre y cuando el post contenga:
	{
		//un campo que se llame 'uri' que tenga anexo este valor $this->uri->uri_string(), para redireccionar a la vista de donde viene
		//un campo que se llame 'id_trabajador' que es el id del trabajador que se asignara a la orden y
		//un campo que se llame 'id_orden_trabajo' que es el id de la orden de trabajo a la cual se le asigna el ayudante
		if($_POST)
		{
        	// echo_pre($_POST);
        	$uri=$_POST['uri'];
            $num_sol=$_POST['id_orden_trabajo'];
        	unset($_POST['uri']);
            // $this->unassigned($num_sol);//para probar funciones
            // die_pre($_POST);
            $i=0;//para recorrer los "indices" de los inputs del formulario
            $asignados=FALSE;//variable auxiliar para validar que todos los ayudantes fueron asignados existosamente
            $removidos=FALSE;//variable auxiliar para validar que todos los ayudantes fueron removidos existosamente
            $a=0;//contabiliza la cantidad de asignados
            $r=0;//contabiliza la cantidad de removidos
            while ( sizeof($_POST)> 1)//pasa el arreglo del post completo, para luego separar los id's de los trabajadores a asignar, y los trabajadores a remover de la orden
            {
                if(array_key_exists('assign'.$i, $_POST))//aqui agarra los que van a ser asignados
                {
                    $a++;
                    $aux = array(
                            'id_trabajador'=>$_POST['assign'.$i],
                            'id_orden_trabajo'=>$_POST['id_orden_trabajo']
                            );
                    echo_pre($aux, __LINE__, __FILE__);
                    if(!$this->model_mnt_ayudante->ayudante_en_orden($aux['id_trabajador'], $aux['id_orden_trabajo']))
                    {
                        // $asignados=$asignados+$this->model_mnt_ayudante->ayudante_a_orden($aux);
                        $asignados=$asignados+TRUE;
                    }
                    unset($_POST['assign'.$i]);//desmonta del arreglo
                }
                if(array_key_exists('remove'.$i, $_POST))//aqui agarra los que van a ser removidos de la orden
                {
                    $r++;
                    $aux = array(
                            'id_trabajador'=>$_POST['remove'.$i],
                            'id_orden_trabajo'=>$_POST['id_orden_trabajo']
                            );
                    echo_pre($aux, __LINE__, __FILE__);
                    $removidos=$removidos+TRUE;
                    unset($_POST['remove'.$i]);//desmonta del arreglo
                }
                $i++;
            }
////////////////////////opcional
            if(array_key_exists('id_trabajador', $_POST))//por si se quiere asignar un ayudante desde otra vista
            {
                if(!$this->model_mnt_ayudante->ayudante_en_orden($_POST['id_trabajador'], $_POST['id_orden_trabajo']))
                {
                    $a=1;
                    $asignados=$asignados+$this->model_mnt_ayudante->ayudante_a_orden($_POST);
                }
            }
/////////////////////////fin de opcional
            $this->load->helper('date');
            $datestring = "%Y-%m-%d %h:%i:%s";
            $time = time();
            $fecha = mdate($datestring, $time);
            if($a>0)
            {
            	if($asignados)
            	{
                    //actualizar en mnt_solicitudes
                    //fecha (fecha de timestamp), y estatus (2 correspondiente a "EN_PROCESO")
                    $update = array(
                    'fecha' => $fecha,
                    'estatus'=> 2);
                    // $this->model_mnt_solicitudes->actualizar_orden($update, $num_sol);
                    //guardar en mnt_estatus_orden con valores de:
                    //id_estado (respectivo a "EN_PROCESO"), id_orden_trabajo (id de la orden de trabajo), id_usuario (el id del usuario de session), fecha_p (formato timestamp)
                    $insert = array(
                        'id_estado' => 2,
                        'id_orden_trabaj' => $num_sol,
                        'id_usuario' => $this->session->userdata('user')['id_usuario'],
                        'fecha_p' => $fecha);
                    // $this->model_mnt_estatus_orden->insert_orden($insert);
                    echo_pre("asignados".$a, __LINE__, __FILE__);
                // die_pre($a);
            		$this->session->set_flashdata('asign_help','success');
            	}
            	else
            	{
            		$this->session->set_flashdata('asign_help','error');
            	}
            }
            if($r>0)
            {
                if($removidos)
                {
                    $update = array(
                    'fecha' => $fecha,
                    'estatus'=> 1);
                    // $this->model_mnt_solicitudes->actualizar_orden($update, $num_sol);
                    echo_pre("removidos".$r, __LINE__, __FILE__);
                die_pre($r);
                    $this->session->set_flashdata('asign_help','success');
                }
                else
                {
                    $this->session->set_flashdata('asign_help','error');
                }
            }
            // die_pre($this->session->flashdata('asign_help'), __LINE__, __FILE__);
            redirect($uri);
        }
        else
        {
            $header['title'] = 'Error de Acceso';
            $this->load->view('template/erroracc',$header);
        }
	}
    public function assigned($id_orden_trabajo)
    {
        // echo_pre($id_orden_trabajo, __LINE__, __FILE__);
        // die_pre($this->model_mnt_ayudante->ayudantes_DeOrden($id_orden_trabajo), __LINE__, __FILE__);
        return($this->model_mnt_ayudante->ayudantes_DeOrden($id_orden_trabajo));
    }
    public function unassigned($id_orden_trabajo)
    {
        // echo_pre($id_orden_trabajo, __LINE__, __FILE__);
        // die_pre($this->model_mnt_ayudante->ayudantes_NoDeOrden($id_orden_trabajo), __LINE__, __FILE__);
        return($this->model_mnt_ayudante->ayudantes_NoDeOrden($id_orden_trabajo));
    }

    public function mostrar_unassigned()
    {
        if ($this->input->post('id')):
            $id_orden_trabajo = $this->input->post('id');
            $ayudantes = $this->unassigned($id_orden_trabajo);
            ?>

            <?php if(!empty($ayudantes)) :?>
            <form id="ay<?php echo $id_orden_trabajo ?>" class="form-horizontal" action="<?php echo base_url() ?>index.php/mnt/asignar/ayudante" method="post">
                <h4><span class="label label-info"> Disponibles </span></h4>
                <table id="ayudisp<?php echo $id_orden_trabajo ?>" class="table table-hover table-bordered">
                      <thead>
                        <tr>
                          <th>Agregar</th>
                          <th>Nombre</th>
                          <th>Apellidos</th>
                        </tr>
                      </thead>
                      <tbody>
                        
                      <?php foreach($ayudantes as $index => $worker) : ?>
                          <tr>
                            <td align="center">
                                <input form="ay<?php echo $id_orden_trabajo ?>" type="checkbox" name="assign<?php echo $index?>" value="<?php echo $worker['id_usuario'] ?>"/>
                            </td>
                            <td><?php echo ucfirst($worker['nombre']) ?></td>
                            <td><?php echo ucfirst($worker['apellido']) ?></td>
                          </tr>
                      <?php endforeach ?>
                      </tbody>
                </table>
            </form>
            <?php else: ?>
            <div class="alert alert-warning" style="text-align: center">No hay ayudantes disponibles para asignar</div>
            <?php endif ?>
            <?php 
        endif;
    }
    public function mostrar_assigned()
    {
        if ($this->input->post('id')):
            $id_orden_trabajo = $this->input->post('id');
            $ayudantes = $this->assigned($id_orden_trabajo);
            ?>

            <?php if(!empty($ayudantes)) :?>
            <form id="ay<?php echo $id_orden_trabajo ?>" class="form-horizontal" action="<?php echo base_url() ?>index.php/mnt/desasignar/ayudante" method="post">
                <h4><span class="label label-success"> Asignados </span></h4>
                <table id="ayudasig<?php echo $id_orden_trabajo ?>" class="table table-hover table-bordered">
                      <thead>
                        <tr>
                          <th>Separar</th>
                          <th>Nombre</th>
                          <th>Apellidos</th>
                        </tr>
                      </thead>
                      <tbody>
                        
                      <?php foreach($ayudantes as $index => $worker) : ?>
                          <tr>
                            <td align="center">
                                <input form="ay<?php echo $id_orden_trabajo ?>" type="checkbox" name="remove<?php echo $index?>" value="<?php echo $worker['id_usuario'] ?>"/>
                            </td>
                            <td><?php echo ucfirst($worker['nombre']) ?></td>
                            <td><?php echo ucfirst($worker['apellido']) ?></td>
                          </tr>
                      <?php endforeach ?>
                      </tbody>
                </table>
            </form>
            <?php else: ?>
            <div class="alert alert-warning" style="text-align: center">Aún no hay ayudantes asignados a esta orden</div>
            <?php endif ?>
            <?php 
        endif;
    }

/* End of file mnt_ayudante.php */
/* Location: ./application/modules/mnt_ayudante/controllers/mnt_ayudante.php */
}