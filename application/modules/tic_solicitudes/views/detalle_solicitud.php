<link href= "<?php echo base_url() ?>assets/css/fileinput.min.css" media="all" rel="stylesheet" type="text/css">
<script src="<?php echo base_url() ?>assets/js/jquery.min.js"></script>
<script type="text/javascript">
    base_url = '<?php echo base_url() ?>';
    $(document).ready(function() {
        var panels = $('.user-infos');
        var panelsButton = $('.dropdown-user');
        panels.show();

        //Click dropdown
        panelsButton.click(function() {
        //get data-for attribute
            var dataFor = $(this).attr('data-for');
            var idFor = $(dataFor);

        //current button
            var currentButton = $(this);
            idFor.slideToggle(400, function() {
            //Completed slidetoggle
                if(idFor.is(':visible'))
                {
                    currentButton.html('<i class="glyphicon glyphicon-chevron-up text-muted"></i>');
                }
                else
                {
                    currentButton.html('<i class="glyphicon glyphicon-chevron-down text-muted"></i>');
                }
            });
        });
        $('[data-toggle="tooltip"]').tooltip();
        var panels2 = $('.img-info');
        var panels2Button = $('.dropdown-img');
        panels2.hide();

        //Click dropdown
        panels2Button.click(function() {
        //get data-for attribute
            var dataImg = $(this).attr('data-img');
            var idFor1 = $(dataImg);

        //current button
            var currentButton1 = $(this);
            idFor1.slideToggle(400, function() {
            //Completed slidetoggle
                if(idFor1.is(':visible'))
                {
                    currentButton1.html('<i class="glyphicon glyphicon-chevron-up text-muted"></i>');
                }
                else
                {
                    currentButton1.html('<i class="glyphicon glyphicon-chevron-down text-muted"></i>');
                }
            });
        });
   
    $("#file-3").fileinput({
//            url: (base_url + 'tic_solicitudes/orden/nueva_orden_autor'),
            showUpload: false,
            language: 'es',
            showCaption: true,
            overwriteInitial: false,
            browseClass: "btn btn-warning btn-sm",
//            browseLabel: "Cambiar",
            allowedFileExtensions: ['png','jpg','gif'],
            maxImageWidth: 512,
            maxImageHeight: 512,
            <?php if($tipo['ruta'] != ''){?>
                'initialPreview': "<img style='height:160px' src= '<?php echo base_url().$tipo['ruta']?>' class='file-preview-image'>",
                 browseLabel: "Cambiar",
            <?php }?>
     });
    $('#example').DataTable( {
        "language": {
            "url": "<?php echo base_url() ?>assets/js/lenguaje_datatable/spanish.json"
        },
        "paging":  true,
        "ordering": false,
        "info":     false,
        "sDom":'tp',
        "iDisplayLength": 5,
        "processing": true, //Feature control the processing indicator.
        "serverSide": true, //Feature control DataTables' server-side processing mode.
        "searching": false,
        // Leer los datos desde la fuente para llenar la tabla por ajax
        "ajax": {
            "url": "<?php echo site_url('tic_observacion/tic_observacion_orden/ajax_detalle/'.$tipo['id_orden'])?>",
            "type": "POST"
        }
    });
});
</script>
<script>
    function imprimir()
    {
        var objeto = document.getElementById('imprime');  //obtenemos el objeto a imprimir
        var ventana = window.open('', '_blank');  //abrimos una ventana vacía nueva
        ventana.document.write(objeto.innerHTML);  //imprimimos el HTML del objeto en la nueva ventana
        ventana.document.close();  //cerramos el documento
        ventana.print();  //imprimimos la ventana
        ventana.close();  //cerramos la ventana
    }
</script>
<style type="text/css">
    .modal-message .modal-header .fa, 
    .modal-message .modal-header 
    .glyphicon, .modal-message 
    .modal-header .typcn, .modal-message .modal-header .wi {
        font-size: 20px;
    }

.fancy-checkbox input[type="checkbox"],
.fancy-checkbox .checked {
    display: none;
}
 
.fancy-checkbox input[type="checkbox"]:checked ~ .checked
{
    display: inline-block;
}
 
.fancy-checkbox input[type="checkbox"]:checked ~ .unchecked
{
    display: none;
}



.dropdown-user:hover {
    cursor: pointer;
}
.table-user-information > tbody > tr {
    border-top: 1px solid rgb(221, 221, 221);
}

.table-user-information > tbody > tr:first-child {
    border-top: 0;
}

.table-user-information > tbody > tr > td {
    border-top: 0;
}
</style>
<!-- Page content -->
<div class="mainy">
    <?php if ($this->session->flashdata('actualizar_orden') == 'success') : ?>
        <div class="alert alert-success" style="text-align: center">Solicitud actualizada con éxito</div>
    <?php endif ?>
    <?php if ($this->session->flashdata('actualizar_foto') == 'success') : ?>
        <div class="alert alert-success" style="text-align: center">Foto actualizada correctamente</div>
    <?php endif ?>
    <?php if ($this->session->flashdata('actualizar_foto') == 'error') : ?>
        <div class="alert alert-danger" style="text-align: center">Ocurrió un problema al tratar de actualizar la foto</div>
    <?php endif ?>
     <?php if ($this->session->flashdata('asigna_cuadrilla') == 'success') : ?>
        <div class="alert alert-success" style="text-align: center">Cuadrilla asignada con éxito</div>
    <?php endif ?>
    <?php if ($this->session->flashdata('asigna_cuadrilla') == 'responsable') : ?>
        <div class="alert alert-success" style="text-align: center">Responsable de la orden modificado con éxito</div>
    <?php endif ?>
    <?php if ($this->session->flashdata('asigna_cuadrilla') == 'error') : ?>
        <div class="alert alert-danger" style="text-align: center">Ocurrió un problema asignando la cuadrilla... Verifique los datos</div>
    <?php endif ?>
    <?php if ($this->session->flashdata('asigna_cuadrilla') == 'quitar') : ?>
        <div class="alert alert-success" style="text-align: center">Proceso realizado con éxito... Recuerde volver asignar la cuadrilla</div>
    <?php endif ?>
    <?php if ($this->session->flashdata('asign_help') == 'success') : ?>
        <div class="alert alert-success" style="text-align: center">Proceso realizado con éxito</div>
    <?php endif ?>
    <?php if ($this->session->flashdata('asign_help') == 'error') : ?>
        <div class="alert alert-danger" style="text-align: center">Ocurrió un problema Realizando el proceso</div>
    <?php endif ?>
    <?php if ($this->session->flashdata('estatus_orden') == 'success') : ?>
        <div class="alert alert-success" style="text-align: center">El cambio de estatus fué agregado con éxito</div>
    <?php endif ?>
    <?php if ($this->session->flashdata('estatus_orden') == 'error') : ?>
        <div class="alert alert-danger" style="text-align: center">Ocurrió un problema cambiando el estatus de la solicitud... Debe seleccionar una opción</div>
    <?php endif ?>
     <!--Page title--> 
    <div class="page-title">
        <h2 align="right">
            <!--<i class="fa fa-desktop color"></i>--> 
            <img src="<?php echo base_url() ?>assets/img/tic/logo-dtic.png" class="img-rounded" alt="bordes redondeados" width="80" height="30">
            Solicitud
            <small>Detalles</small></h2>
        <hr /> 
    </div>
    <div class="row">
        <div class="col-md-12">
            <div id='imprime' class="awidget full-width">
                <div class="awidget-head">
                    <h3>Detalles de la Solicitud </h3>
                </div>
                <div class="awidget-body"> 
                    <?php if ($this->session->flashdata('edit_solicitud') == 'success') : ?>
                        <div class="alert alert-success" style="text-align: center">La solicitud fue modificado con éxito</div>
                    <?php endif ?>
                    <?php if ($this->session->flashdata('edit_solicitud') == 'error') : ?>
                        <div class="alert alert-danger" style="text-align: center">Ocurrió un problema con la edición de la solicitud</div>
                    <?php endif ?>
                    <?php if ($this->session->flashdata('observacion') == 'success') : ?>
                    <div class="alert alert-success" style="text-align: center">La observación fué agregada con éxito</div>
                    <?php endif ?>
                    <?php if ($this->session->flashdata('observacion') == 'error') : ?>
                        <div class="alert alert-danger" style="text-align: center">Ocurrió un problema agregando la observación</div>
                    <?php endif ?>
               <!--Nuevo button Asignar personal -->
                    <div class="row">
                        <div class="col-md-2 col-sm-2">
                        </div>
                        <div class="col-md-10 col-sm-10">
                      <?php if ($asignar){ ?>
                          <?php if (($tipo['estatus'] != '3') && ($tipo['estatus'] != '4')){?>
                                    <div class="row">
                                        <div class="btn-group  pull-right " >
                                            <button class="btn btn-info btn-sm dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Asignar personal <span class="caret"></span></button>
                                        <ul class="dropdown-menu">
                                <?php       if (!empty($tipo['cuadrilla'])): ?>
                                              <?php $title = '<label class="modal-title">Asignar Cuadrilla</label>'
                                                              .'<span><i class="fa fa-users" aria-hidden="true"></i></span>';
                                                $cuerpo = '<div class="row">'
                                                    .'<div class="col-md-12 text-center">'
                                                        .'<div class="well well-sm">' 
                                                            .'Solicitud Número: <label name="data" id="data">'.$tipo['id_orden'].'</label>'
                                                        .'</div>'
                                                        .'</div>'
                                                    .'</div>'
                                                    .'<div class="row">'
                                                        .'<div class="col-md-6 text-center">'
                                                            .'<label class="control-label" for = "tipo">Tipo: '.$tipo['tipo_orden'].'</label>'
                                                        .'</div>'
                                                        .'<div class="col-md-6 text-center">'
                                                            .'<label class="control-label" for = "asunto">Asunto: '.$tipo['asunto'].'</label>'
                                                        .' </div>'
                                                    .'</div>'
                                                    .'<form class="form" action="'.base_url().'tic_asigna_cuadrilla/tic_asigna_cuadrilla/asignar_cuadrilla" method="post" name="modifica'.$tipo['id_orden'].'" id="modifica'.$tipo['id_orden'].'">'
                                                        .'<input type="hidden" name="uri" value="tic_solicitudes/detalle/'.$tipo['id_orden'].'">'
                                                        .'<input type="hidden" id="cut" name="cut" value="'.$tipo['id_orden'].'">'
                                                        .'<input type="hidden" id="cuadrilla" name="cuadrilla" value="'.$tipo['id_cuadrilla'].'">';
                                                    $footer = '<div class = "col-md-12">'
                                                            .'<button type="button" class="btn btn-default" data-dismiss="modal" aria-hidden="true">Cancelar</button>'
                                                            .'<button type="submit" form="modifica'.$tipo['id_orden'].'" class="btn btn-primary">Guardar cambios</button>'
                                                        .'</div>';
                                                ?>
                                                <li>
<!--                                                    <a onclick='cuad_asignada($("#responsable<?php echo($tipo['id_orden']) ?>"),($("#respon<?php echo($tipo['id_orden']) ?>")),<?php echo json_encode($tipo['id_orden']) ?>,<?php echo json_encode($tipo['id_cuadrilla']) ?>, ($("#show_signed<?php echo $tipo['id_orden'] ?>")), ($("#otro<?php echo $tipo['id_orden'] ?>")),($("#mod_resp<?php echo $tipo['id_orden'] ?>")),1)' href='#cuad<?php echo $tipo['id_orden'] ?> ' data-toggle="modal" data-id="<?php echo $tipo['id_orden']; ?>" data-asunto="<?php echo $tipo['asunto'] ?>" data-tipo_sol="<?php echo $tipo['tipo_orden']; ?>" class="open-Modal" >
                                                    <div align="center">Cuadrilla</div></a>                           -->
                                                    <a onclick='mod_cuad_asignada(<?php echo json_encode($tipo['id_orden']) ?>,<?php echo json_encode($tipo['id_cuadrilla']) ?>, <?php echo json_encode($title) ?>, <?php echo json_encode($cuerpo) ?>,<?php echo json_encode($footer) ?>,1,1)'>
                                                    <div align="center">Cuadrilla</div></a>  
                                                </li>
                                <?php       else:?>
                                                <li><a href='#cua<?php echo $tipo['id_orden'] ?> ' data-toggle="modal" data-id="<?php echo $tipo['id_orden']; ?>" data-asunto="<?php echo $tipo['asunto'] ?>" data-tipo_sol="<?php echo $tipo['tipo_orden']; ?>" class="open-Modal" >
                                                    <div align="center">Cuadrilla</div></a>
                                                </li>
                                      <?php endif; ?> 
                                            <!--<li class="divider" role="separador"></li>-->
                                         
                                    <?php
                                            $title2 =   '<label class="modal-title">Asignar Ayudantes</label>'
                                                        .'<span><i class="fa fa-user-plus" aria-hidden="true"></i></span>';
                                            $cuerpo2 =  '<div class="row" >'
                                                            .'<div class="col-md-12 text-center">'
                                                                .'<div class="well well-sm">'
                                                                    . 'Solicitud Número: <label name="data" id="data">' . $tipo['id_orden'] . '</label>'
                                                                .'</div>'
                                                            . ' </div>'
                                                        .'</div>'
                                                        .'<div class="row">'
                                                            .'<div class="col-md-6 text-center">'
                                                                .'<label class="control-label" for = "tipo">Tipo: ' . $tipo['tipo_orden'] . '</label>'
                                                            .'</div>'
                                                            .'<div class="col-md-6 text-center">'
                                                                . '<label class="control-label" for = "asunto">Asunto: ' . $tipo['asunto'] . '</label>'
                                                            .'</div>'
                                                        . '</div>'
                                                        . '<form id="ay' . $tipo['id_orden'] . '" class="form-horizontal" action="' . base_url() . 'tic/asignar/ayudante" method="post">'
                                                            . '<div class="well well-sm">'
                                                                . '<div class="row">';
                                                    if (empty($est) && !(isset($band))) {
                                                        if (empty($tipo['cuadrilla'])) {
                                                            $cuerpo2 .= '<div class="col-md-5 text-center">'
                                                                    . '<label>Responsable de la orden:</label>'
                                                                    . '</div>';
                                                            if (empty($tipo['id_responsable'])) {
                                                                $cuerpo2 .= '<div class="col-md-7">'
                                                                        . '<select title="Responsable de la orden"class = "form-control" id = "ayu_resp' . $tipo['id_orden'] . '" name="responsable">'
                                                                        . '</select>'
                                                                        . '</div>'
                                                                        . '<br>';
                                                            } else {
                                                                $cuerpo2.= '<div class="col-md-7">'
                                                                        . '<div class="input-group">'
                                                                        . '<select class = "form-control" id = "ayu_resp' . $tipo['id_orden'] . '" name="responsable" disabled>'
                                                                        . '</select>'
                                                                        . '<span class="input-group-addon">'
                                                                        . '<label class="fancy-checkbox" title="Haz click para editar responsable">'
                                                                        . '<input  type="checkbox"  id="mod_resp' . $tipo['id_orden'] . '"/>'
                                                                        . '<i class="fa fa-fw fa-edit checked" style="color:#D9534F"></i>'
                                                                        . '<i class="fa fa-fw fa-pencil unchecked"></i>'
                                                                        . '</label>'
                                                                        . '</span>'
                                                                        . '</div>'
                                                                        . '</div>';
                                                            }
                                                        } else {
                                                            $respon = $this->model_responsable->get_responsable($tipo['id_orden']);
                                                            $cuerpo2.= '<div class="col-md-12 text-center">'
                                                                    . '<label>Responsable de la orden: ' . $respon['nombre'] . ' ' . $respon['apellido'] . '</label>'
                                                                    . '</div>';
                                                        }
                                                        $cuerpo2.= '<br>'
                                                                . '<div class="col-md-12">'
                                                                . '<ul id="myTab3" class="nav nav-tabs" role="tablist">'
                                                                . '<li class="active">'
                                                                . '<a href="#tab-table1' . $tipo['id_orden'] . '" data-toggle="tab">Ayudantes asignados</a>'
                                                                . '</li>'
                                                                . '<li>'
                                                                . '<a href="#tab-table2' . $tipo['id_orden'] . '" data-toggle="tab">Ayudantes disponibles</a>'
                                                                . '</li>'
                                                                . '</ul>'
                                                                . '<div class="tab-content">'
                                                                . '<div class="tab-pane active" id="tab-table1' . $tipo['id_orden'] . '">'
                                                                . '<div id="asignados' . $tipo['id_orden'] . '">'
                                                                . '<!-- AQUI CONSTRULLE UNA LISTA DE AYUDANTES ASIGNADOS A LA ORDEN (revisar script mainFunctions.js linea 208 en adelante)-->'
                                                                . '</div>'
                                                                . '</div>'
                                                                . '<div class="tab-pane" id="tab-table2' . $tipo['id_orden'] . '">'
                                                                . '<div id="disponibles' . $tipo['id_orden'] . '">'
                                                                . '<!-- AQUI CONSTRULLE UNA LISTA DE AYUDANTES DISPONIBLES NO ASIGNADOS A LA ORDEN (revisar script mainFunctions.js linea 208 en adelante)-->'
                                                                . '</div>'
                                                                . '</div>'
                                                                . '</div>'
                                                                . '</div>';
                                                        if ($tipo['tiene_cuadrilla'] == 'no') {
                                                            $cuerpo2.= '<div class="col-lg-12">'
                                                                    . '<div class="alert-success" align="center">'
                                                                    . '<label class="checkbox-inline">'
                                                                    . '<input type="checkbox" id="otro' . $tipo['id_orden'] . '" name="cut" value="opcion_1">Quitar asignación de la orden'
                                                                    . '</label>'
                                                                    . '</div>'
                                                                    . '</div>';
                                                        }
                                                    } else {
                                                        if (empty($tipo['cuadrilla'])) {
                                                            $cuerpo2.= '<div class="col-md-5 text-center">'
                                                                    . '<label>Responsable de la orden:</label>'
                                                                    . '</div>';
                                                            if (empty($tipo['id_responsable'])) {
                                                                $cuerpo2.= '<div class="col-md-12">'
                                                                        . '<div class="alert alert-info" align="center">'
                                                                        . '<strong>¡No hay responsable asignado a esta solicitud!</strong>'
                                                                        . '</div>'
                                                                        . '</div>';
                                                            } else {
                                                                $cuerpo2.= '<div class="col-md-7">'
                                                                        . '<select title="Responsable de la orden" class = "form-control input select2" id = "ayu_resp' . ($tipo['id_orden']) . '" name="responsable" disabled>'
                                                                        . '<!--<option ></option>-->'
                                                                        . '</select>'
                                                                        . '</div>';
                                                            }
                                                        } else {
                                                            $respon = $this->model_responsable->get_responsable($tipo['id_orden']);
                                                            $cuerpo2 .= '<div class="col-md-12 text-center">'
                                                                    . 'Responsable de la orden: <label>' . $respon['nombre'] . ' ' . $respon['apellido'] . '</label>'
                                                                    . ' </div>';
                                                        }
                                                        $cuerpo2.= '<br>'
                                                                . '<div class="col-md-12">'
                                                                . '<div class="text-center" > <label>Ayudantes asignados</label> </div>'
                                                                . '<div id="asignados' . $tipo['id_orden'] . '">'
                                                                . '<!-- AQUI CONSTRULLE UNA LISTA DE AYUDANTES ASIGNADOS A LA ORDEN (revisar script mainFunctions.js linea 208 en adelante)-->'
                                                                . '</div>'
                                                                . '</div>';
                                                    }
                                                    $cuerpo2.= '<div>'
                                                            . '</div>'
                                                            . '</form>';
                                                    $footer2 = '<input form="ay' . $tipo['id_orden'] . '" type="hidden" name="uri" value="tic_solicitudes/detalle/' . $tipo['id_orden'] . '"/>'
                                                            . '<input form="ay' . $tipo['id_orden'] . '" type="hidden" name="id_orden_trabajo" value="' . $tipo['id_orden'] . '"/>'
                                                            . '<button type="button" class="btn btn-default" data-dismiss="modal" aria-hidden="true">Cancelar</button>';
                                                    if (empty($est) && !(isset($band))) {
                                                        $footer2.= '<button form="ay' . $tipo['id_orden'] . '" type="submit" class="btn btn-primary">Guardar cambios</button>';
                                                    }
                                                    $footer2 .= '</div>';
                                                    ?>    
                                            <li><a onclick='mod_ayudantes(<?php echo json_encode($tipo['estatus']) ?>,<?php echo json_encode($tipo['id_orden']) ?>, <?php echo json_encode($title2) ?>, <?php echo json_encode($cuerpo2) ?>,<?php echo json_encode($footer2) ?>,1)'><div align="center"><?php if(in_array(array('id_orden_trabajo' => $tipo['id_orden']), $ayuEnSol)){ echo('Ayudantes');} else { echo ('Ayudantes');}?></div></a>
                                        </ul>
                                        </div>
                                    </div>
                          <?php } ?>
                      <?php } ?>    
                            <br>
                            <!--<div class="row">-->
                            <div class="panel panel-info">
                                <div class="panel-heading">
                                    <div class="table-responsive">
                                        <label><strong>Solicitud Número:</strong> <?php echo $tipo['id_orden']; ?></label>
                                        <div class="btn-group btn-group-sm pull-right">
                                            <label><strong>Creada por:</strong></strong> <?php echo $autor; ?></label>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="panel-body">
                                    
                                    <div align='center'><strong>Tipo de Solicitud: <?php echo $tipo['tipo_orden']; ?></strong></div>                   
                                    <div well class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                        <div class="row user-row">
                                            <div class="col-xs-11 col-sm-11 col-md-11 col-lg-11">
                                                <strong>Información del contacto</strong><br>
                                                <span class="text-muted"></span>
                                            </div>
                                            <div class="col-xs-1 col-sm-1 col-md-1 col-lg-1 dropdown-user" data-for=".uno">
                                                <i class="glyphicon glyphicon-chevron-up text-muted"></i>
                                            </div>
                                        </div>
                                        <div class="row user-infos uno">
                                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 ">
                                                <div class="table-responsive col-md-12 col-lg-12">
                                                    <table class="table table-hover table-bordered table-striped table-condensed">
                                                        <thead>
                                                            <tr>    
                                                                <th><strong>Contactar a</strong></th>
                                                                <?php if (!empty($tipo['telefono_contacto'])): ?>
                                                                    <th><strong>Teléfono</strong></th>
                                                                <?php endif; ?>
                                                                <th><strong>Dependencia</strong></th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <tr>
                                                                <td><?php echo $tipo['nombre_contacto']; ?></td>
                                                                <?php if (!empty($tipo['telefono_contacto'])): ?> 
                                                                    <td><?php echo $tipo['telefono_contacto']; ?></td>
                                                                <?php endif; ?>
                                                                <td><?php echo $tipo['dependen']; ?></td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row user-row">
                                            <div class="col-xs-11 col-sm-11 col-md-11 col-lg-11">
                                                <strong>Información de la solicitud</strong><br>
                                                <span class="text-muted"></span>
                                            </div>
                                            <div class="col-xs-1 col-sm-1 col-md-1 col-lg-1 dropdown-user" data-for=".dos">
                                                <i class="glyphicon glyphicon-chevron-up text-muted"></i>
                                            </div>
                                        </div>
                                        <div class="row user-infos dos">
                                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 ">
                                                <div class="table-responsive col-md-12 col-lg-12">
                                                    <table class="table table-hover table-bordered table-striped table-condensed">
                                                        <thead>
                                                            <tr>    
                                                                <th><strong>Asunto</strong></th>
                                                                <th><strong>Descripción</strong></th>
                                                                <th><strong>Ubicación</strong></th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <tr>
                                                                <td><?php echo $tipo['asunto']; ?></td>
                                                                <td><?php echo $tipo['descripcion_general']; ?></td>
                                                                <td><?php
                                                                    if ($oficina != 'N/A'):
                                                                        echo $oficina;
                                                                    else:
                                                                        if (!empty($observacion)):
                                                                            echo $observacion;
                                                                        else:
                                                                            echo ('<p class="text-muted">No Agregada</p>');
                                                                        endif;
                                                                    endif;
                                                                    ?>
                                                                </td>    
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    <?php if (!empty($tipo['ruta'])){ ?> 
                                        <div class="row user-row">
                                            <div class="col-xs-11 col-sm-11 col-md-11 col-lg-11">
                                                <strong>Imagen del daño</strong><br>
                                                <span class="text-muted"></span>
                                            </div>
                                            <div class="col-xs-1 col-sm-1 col-md-1 col-lg-1 dropdown-user" data-for=".tres">
                                                <i class="glyphicon glyphicon-chevron-up text-muted"></i>
                                            </div>
                                        </div>
                                        <div class="row user-infos tres">
                                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 ">
                                                <div class=" col-md-12 col-lg-12">
                                                    <div align="center">
                                                        <img src="<?php echo base_url() .$tipo['ruta']?>" class="img-responsive" width="304" height="236"> 
                                                    </div>
                                                    <?php if($editar):
                                                        if (($tipo['estatus'] == '1')) : ?>
                                                            <div align="center"> <a href="#imagen" class="btn btn-primary btn-sm" data-toggle="modal">Cambiar</a></div>
                                                <?php   endif; 
                                                    endif;?>
                                                </div>
                                            </div>
                                        </div>
                                    <?php }else{?>
                                         <?php if($editar):
                                                        if (($tipo['estatus'] == '1')) : ?>
                                        <div class="row img-row">
                                            <div class="col-xs-11 col-sm-11 col-md-11 col-lg-11">
                                                <strong>Añadir imagen</strong><br>
                                                <span class="text-muted"></span>
                                            </div>
                                                <div class="col-xs-1 col-sm-1 col-md-1 col-lg-1 dropdown-img" data-img=".un">
                                                    <i class="glyphicon glyphicon-chevron-down text-muted"></i>
                                                </div>
                                        </div>
                                        <div class="row img-info un">
                                            <form class="form" action="<?php echo $action ?>" method="post" name="modifica" id="modifica" enctype="multipart/form-data">
                                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 ">
                                                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 "><br></div>
                                                    <div class="col-sm-3"></div>
                                                    <div class="col-sm-6">
                                                        <input id="file-3" name="archivo" type="file" multiple="true" data-show-caption="true" class="file-loading">
                                                    </div> 
                                                    <div class="col-sm-3"></div>
                                                    <input type="hidden" name="id" value="<?php echo $tipo['id_orden'] ?>" />
                                                    <input type="hidden" name="img" value="1" />
                                                    <div class="col-sm-12"><br></div>
                                                    <div class="col-sm-12">
                                                   
                                                        <div align="center"> <button class="btn btn-primary btn-sm">Agregar</button></div>
                                               
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                         <?php    endif; 
                                                        endif;?>
                                        <?php }?>
                                        <div class="row user-row">
                                            <div class="col-xs-11 col-sm-11 col-md-11 col-lg-11">
                                                <strong>Estatus</strong><br>
                                                <span class="text-muted"></span>
                                            </div>
                                            <div class="col-xs-1 col-sm-1 col-md-1 col-lg-1 dropdown-user" data-for=".cuatro">
                                                <i class="glyphicon glyphicon-chevron-up text-muted"></i>
                                            </div>
                                        </div>
                                        <div class="row user-infos cuatro">
                                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 ">
                                                <div class="table-responsive col-md-12 col-lg-12">
                                                    <table class="table table-hover table-bordered table-striped table-condensed">
                                                        <thead>
                                                            <tr> 
                                                                <?php if ($creada != $tipo['fecha']): ?>
                                                                    <th><strong>Creada</strong></th>
                                                                    <th><strong>Cambio</strong></th>
                                                                <?php else:?>
                                                                    <th><strong>Creada</strong></th>
                                                                <?php endif;?>
                                                                    <th><strong>Estatus</strong></th>
                                                                <?php if ($tipo['id_estado'] == '3' || $tipo['id_estado'] == '4' || $tipo['id_estado'] == '5' || $tipo['id_estado'] == '6') { ?>    
                                                                    <th><strong>Motivo del estatus</strong></th>
                                                                <?php }; ?>          
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <tr>
                                                          <?php if ($creada != $tipo['fecha']): ?>
                                                                <td><?php echo date("d/m/Y", strtotime($creada)); ?></td>
                                                                <td><?php echo date("d/m/Y", strtotime($tipo['fecha'])); ?></td>
                                                          <?php else:?>
                                                                     <td><?php echo date("d/m/Y", strtotime($creada)); ?></td>
                                                          <?php endif;?>
                                                                <td><?php echo $tipo['descripcion']; ?></td>
                                                                <?php if ($tipo['id_estado'] == '3' || $tipo['id_estado'] == '4' || $tipo['id_estado'] == '5' || $tipo['id_estado'] == '6') { ?>
                                                                    <td><?php echo $tipo['motivo'];}; ?></td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    
                                        <?php if (!empty($responsable['id_responsable'])) { ?>
                                            <div class="row user-row">
                                                <div class="col-xs-11 col-sm-11 col-md-11 col-lg-11">
                                                    <strong>Personal asignado</strong><br>
                                                    <span class="text-muted"></span>
                                                </div>
                                                <div class="col-xs-1 col-sm-1 col-md-1 col-lg-1 dropdown-user" data-for=".cinco">
                                                    <i class="glyphicon glyphicon-chevron-up text-muted"></i>
                                                </div>
                                            </div>
                                            <div class="row user-infos cinco">
                                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 ">
                                                    <div class="table-responsive col-md-12 col-lg-12">
                                                        <table class="table table-hover table-bordered table-striped table-condensed">
                                                            <thead>
                                                                <tr>                                 
                                                                    <th><strong>Responsable</strong></th>
                                                                    <?php if ($tipo['id_estado'] != '1' && !empty($cuadrilla)) { ?>
                                                                        <th><strong>Cuadrilla</strong></th>
                                                                        <th><strong>Miembros</strong></th>
                                                                        <?php
                                                                        if (!empty($ayudantes)) {
                                                                            echo '<th><strong>' . 'Ayudantes' . '</strong></th>';
                                                                        };
                                                                    } elseif (!empty($ayudantes)) {
                                                                        echo '<th><strong>' . 'Ayudantes' . '</strong></th>';
                                                                    };
                                                                    ?>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <tr>
                                                                    <td><?php echo ($responsable['nombre'] . ' ' . $responsable['apellido']); ?></td>
                                                                        <?php if ($tipo['id_estado'] != '1' && !empty($cuadrilla)) { ?>
                                                                            <td><?php echo ($tipo['cuadrilla']); ?></td>
                                                                            <td><?php
                                                                                foreach ($cuadrilla as $cuad):
//                                                                                    if ($cuad != $nombre):
                                                                                        echo ($cuad) . '<br>';
//                                                                                    endif;
                                                                                endforeach;
                                                                                ?>
                                                                            </td>
                                                                        <?php
                                                                                if (!empty($ayudantes)) {
                                                                                echo '<td>';
                                                                                foreach ($ayudantes as $ayu):
                                                                                    echo ($ayu) . '<br>';
                                                                                endforeach;
                                                                                echo '</td>';
                                                                                };
                                                                        }else {
                                                                            echo '<td>';
                                                                            foreach ($ayudantes as $ayu):
                                                                                echo ($ayu) . '<br>';
                                                                            endforeach;
                                                                            echo '</td>';
                                                                        };
                                                                    ?> 
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php } ?>
                                    </div>
                                </div>                          
                                <div class="panel-footer">
                                    <div class='table-responsive container'align="right">
                                        <div class="btn-group btn-group-sm pull-right">
                                            <a data-toggle="modal" data-target="#pdf" class="btn btn-default btn">Crear PDF</a> 
                                            <!--Button to trigger modal--> 
                                            <!--Button modal estatus--> 
                                            <?php if($edit_status):
                                                    if (($tipo['estatus'] != '3') && ($tipo['estatus'] != '4') &&($tipo['estatus'] != '1')) : ?>
                                                        <a data-toggle="modal" data-target="#estatus_sol<?php echo $tipo['id_orden'] ?>" class="btn btn-warning">Cambiar Estatus</a> 
                                            <?php   endif;
                                                  endif;?>
                                            <!--<button type="button" class="btn btn-primary" onclick="imprimir();">Imprimir</button> -->
                                            <!--Button modal comentarios-->
                                            <?php if($observac):
                                                    if (($tipo['estatus'] != '3')) : ?>
                                                        <a href="#comentarios<?php echo $tipo['id_orden'] ?>" class="btn btn-success" data-toggle="modal">Observaciones</a>
                                            <?php   endif;
                                                  endif;?>
                                            <?php if (($tipo['estatus'] != '3') && ($tipo['estatus'] != '4')):?>
                                                <a href="<?php echo base_url().'tic_solicitudes/lista_solicitudes'?>" class="btn btn-info">Regresar</a>
                                            <?php elseif($tipo['estatus'] == '3'): ?>
                                                <a href="<?php echo base_url().'tic_solicitudes/cerrada'?>" class="btn btn-info">Regresar</a>    
                                            <?php elseif($tipo['estatus'] == '4'): ?>
                                                <a href="<?php echo base_url().'tic_solicitudes/anulada'?>" class="btn btn-info">Regresar</a>    
                                            <?php endif; ?>
                                            <?php if($editar):
                                                    if (($tipo['estatus'] == '1')) : ?>
                                                        <a href="#modificar" class="btn btn-primary" data-toggle="modal">Modificar</a>
                                            <?php   endif; 
                                                  endif;?>
                                        </div>
                                    </div>  
                                </div>
                            </div>
                            <!--</div>-->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>  
  <!-- Modal -->
    <div id="modificar" class="modal modal-message modal-info fade" tabindex="-1" role="dialog" aria-labelledby="modificacion" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <span><i class="glyphicon glyphicon-edit"></i></span>
                </div>
                <form class="form" action="<?php echo $action?>" method="post" onsubmit="return validacion()" name="modifica" id="modifica" enctype="multipart/form-data">
                    <div class="modal-body row">
                        <div class="col-md-6">

                            <!-- NOMBRE CONTACTO -->
                            <div class="form-group">
                                <label class="control-label" for="nombre_contacto">Contacto:</label>
                                <div class="control-label">
                                    <select class="form-control input-sm select2" id="nombre_contacto" name="nombre_contacto">
                                        <option></option>
                                        <option selected="<?php echo ($tipo['nombre_contacto'])?>" value="<?php echo ($tipo['nombre_contacto'])?>"><?php echo ($tipo['nombre_contacto'])?></option>
                                        <?php foreach ($todos as $all):
                                            $nombre = strtoupper($all['nombre']) . ' ' . strtoupper($all['apellido']);
                                          echo $nombre;
                                            if (($tipo['nombre_contacto'])!= ($nombre)):?>
                                            <option value="<?php echo strtoupper($all['nombre']) . ' ' . strtoupper($all['apellido']) ?>"><?php echo strtoupper($all['nombre']) . ' ' . strtoupper($all['apellido']) ?></option>
                                        <?php 
                                           endif;
                                        endforeach; ?>
                                    </select>
                                </div>
                            </div>
                            <!-- TELEFONO CONTACTO -->
                            <div class="form-group">
                                <label class="control-label" for="telefono_contacto">Teléfono:</label>
                                <div class="control-label">
                                    <input autocomplete="off" onblur="validatePhone('telefono_contacto', 'phone_msg')" type="text" value="<?php echo ($tipo['telefono_contacto']) ?>"
                                           class="form-control input-sm" style="text-transform:uppercase;" onkeyup="javascript:this.value = this.value.toUpperCase();" class="form-control" id="telefono_contacto" name="telefono_contacto"></input>
                                <span id="phone_msg" class="label label-danger"></span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <!-- SELECT TIPO DE SOLICITUD -->
                            <div class="form-group">   
                                <label class="control-label" for = "tipo">Tipo de Solicitud</label>
                                <select class = "form-control input-sm select2" id = "id_tipo" name="id_tipo">
                                    <?php foreach ($tipo_solicitud as $ord): ?>
                                        <option value=""></option>
                                        <?php if ($tipo['tipo_orden'] != $ord->tipo_orden): ?>
                                            <option value = " <?php echo $ord->id_tipo ?>"><?php echo $ord->tipo_orden ?></option>
                                        <?php else: ?>
                                            <option selected="$tipo['tipo_orden']" value = " <?php echo $tipo['id_tipo'] ?>"><?php echo $tipo['tipo_orden'] ?></option>
                                        <?php endif; ?>
                                    <?php endforeach; ?>
                                </select>
                            </div>

                            <div class="form-group">
                                <label class="control-label" for="asunto">Asunto</label>
                                <div class="control-label">
                                    <input autocomplete="off" style="text-transform:uppercase;" onKeyDown=" contador(this.form.asunto, ($('#restan')), 25);" onblur="validateLetters('asunto', 'asunto_msg')" type="text" class="form-control input-sm" id="asunto" name="asunto" value='<?php echo ($tipo['asunto']) ?>'>
                                   <span id="asunto_msg" class="label label-danger"></span>
                                </div>
                                <?php $total= "<script type='text/javascript'>var uno = document.getElementById('asunto');var dos = uno.value.length;document.write(dos);</script>";?>
                                <small><p align="right" name="resto" id="restan"><?php echo $total;?>/25</p></small>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="asunto">Descripción</label>
                            <div class="col-lg-24">
                                <textarea autocomplete="off" style="text-transform:uppercase;" onblur="validateLetters('descripcion_general', 'descripcion_msg')" onKeyDown=" contador(this.form.descripcion_general, ($('#resta')), 160)"class="form-control" id="descripcion_general" name="descripcion_general"><?php echo ($tipo['descripcion_general']) ?> </textarea>
                                <span id="descripcion_msg" class="label label-danger"></span>
                            </div>
                            <?php $total= "<script type='text/javascript'>var uno = document.getElementById('descripcion_general');var dos = uno.value.length;document.write(dos);</script>";?>
                                <small><p align="right" name="resto" id="resta"><?php echo $total;?>/160</p></small>
                        </div>
                        <!-- SELECT DE DEPENDENCIA-->
                  <?php if($todas){?> 
                        <div class="form-group">
                            <label class="control-label" for = "dependencia">Dendendencia</label>
                            <select class = "form-control select2" id = "dependencia_select" name="dependencia">
                                <option value=""></option>
                                <option selected="$tipo['id_dependencia']" value = " <?php echo $tipo['id_dependencia'] ?>"><?php echo $tipo['dependen'] ?></option>
                                <?php foreach ($dependencia as $dep): ?>
                                    <?php if ($tipo['dependen'] != $dep->dependen): ?>
                                        <option value = " <?php echo $dep->id_dependencia ?>"><?php echo $dep->dependen ?></option>
                                    <?php endif; ?>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="form-group">   
                            <label class="control-label" for = "ubicacion">Ubicación</label>
                            <select class = "form-control" id = "oficina_select" name="ubicacion" enabled>
                                <option selected="$oficina" value = " <?php echo $tipo['ubicacion'] ?>"><?php echo $oficina?></option>
                            </select>
                        </div>
                  <?php }else{?>
                        <div class="form-group">   
                            <label class="control-label" for = "dependencia">Dependencia</label>
                             <input autocomplete="off" style="text-transform:uppercase;" type="text" class="form-control input-sm" id="dependencia" name="dependencia" value='<?php echo $tipo['dependen'] ?>' disabled>
                        </div>
                        <div class="form-group">   
                            <label class="control-label" for = "ubicacion">Ubicación</label>
                            <select class="form-control input select2" id="oficina_select" name="ubicacion" enabled>
                                    <option value=""></option>
                                    <option selected="<?php echo $tipo['ubicacion'] ?>"value="<?php echo $tipo['ubicacion'] ?>"><?php echo $oficina ?></option>
                                        <?php foreach ($ubica as $ubi): ?>
                                            <?php if (($tipo['ubicacion'] != $ubi->id_ubicacion) && ($ubi->oficina != 'N/A')):?>
                                                <option value = "<?php echo $ubi->id_ubicacion ?>"><?php echo $ubi->oficina ?></option>
                                            <?php endif; ?>
                                        <?php endforeach; ?>
                            </select>
                        </div>
                  <?php }?> 
                        <?php //  if (!empty($observacion)):?>
<!--                            <div class="form-group">
                                <label class="control-label" for="otra">Otra ubicación</label>
                                <div class="control-label">
                                    <input autocomplete="off" style="text-transform:uppercase;" type="text" class="form-control input-sm" id="observac" name="observac" value='<?php echo $observacion ?>'>
                                </div>
                                
                            </div>-->
                        <?php // endif ?>
                    </div>

                    <?php if (isset($edit) && $edit && isset($tipo)) : ?>
                        <input type="hidden" name="id" value="<?php echo $tipo['id_orden'] ?>" />
                        <input type="hidden" name="data" value="1" />;
                    <?php endif ?>
                    <div class="modal-footer">
                       <button type="button" class="btn btn-default" data-dismiss="modal" aria-hidden="true">Cancelar</button>
                       <button type="submit" id="hola"class="btn btn-primary">Guardar cambios</button>
                    </div>
                </form>


            </div>

        </div>
    </div>

    <!-- Modal para iframe del pdf -->
    <div class="modal fade" id="pdf" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-lg">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h4 class="modal-title"></h4>
          </div>
          <div class="modal-body" style="height: 768px">
               <?php if($todas):?>
                    <iframe  src="<?php echo base_url() ?>tic_solicitudes/pdf/<?php echo $tipo['id_orden']; ?>" width="100%" height="100%" frameborder="0" allowtransparency="true"></iframe>  
              <?php else:?>
                    <iframe src="<?php echo base_url() ?>tic_solicitudes/pdf_dep/<?php echo $tipo['id_orden']; ?>" width="100%" height="100%" frameborder="0" allowtransparency="true"></iframe> 
              <?php endif; ?>      
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            <!-- <button type="button" class="btn btn-primary">Save changes</button> -->
          </div>
        </div>
        <!-- /.modal-content -->
      </div>
      <!-- /.modal-dialog -->
    </div>  

<!-- Modal para cambiar el estatus de una solicitud-->
    <div id="estatus_sol<?php echo $tipo['id_orden'] ?>" class="modal modal-message modal-info fade" tabindex="-1" role="dialog" aria-labelledby="mod" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <label class="modal-title">Cambiar Estatus</label> <i class="fa fa-tasks" aria-hidden="true"></i>
                    
                </div>
                <form class="form" action="<?php echo base_url() ?>tic_estatus_orden/cambiar_estatus" method="post" name="edita" id="edita" onsubmit="if ($('#<?php echo $tipo['id_orden'] ?>')){return valida_motivo($('#motivo<?php echo $tipo['id_orden'] ?>'));}">
                    <div class="modal-body">
                        <div class="well well-sm">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="control-label" for = "estatus">Estatus:</label>
                                        <input type="hidden" id="orden" name="orden" value="<?php echo $tipo['id_orden'] ?>">
                                        <input type="hidden" id="id_cu" name="id_cu" value="<?php echo $tipo['id_cuadrilla'] ?>">
                                    <!-- SWITCH PARA EVALUAR OPCIONES DEL ESTATUS DE LA SOLICITUD-->
                                        <?php switch ($tipo['descripcion'])
                                        {
                                            case 'CERRADA':
                                                echo '<div class="alert alert-info" align="center"><strong>¡La solicitud fué cerrada. No puede cambiar de estatus!<strong></div>';
                                                break;
                                            case 'ANULADA':
                                                echo '<div class="alert alert-info" align="center"><strong>¡La solicitud fué anulada. No puede cambiar de estatus!<strong></div>';
                                                break;
                                            default:?>
                                            <?php if (($tipo['descripcion']!= 'EN PROCESO') && ($tipo['descripcion']!= 'PENDIENTE POR MATERIAL') && ($tipo['descripcion']!= 'PENDIENTE POR PERSONAL'))
                                            {
                                                echo '<div class="alert alert-warning" align="center"><strong>¡La solicitud está abierta. Debe asignar un personal!<strong></div>';
                                            }else{?>
                                            <select class="form-control select2" id = "sel<?php echo $tipo['id_orden'] ?>" name="select_estado" onchange="statusOnChange(this,$('#<?php echo $tipo['id_orden'] ?>'),$('#motivo<?php echo $tipo['id_orden'] ?>'))">
                                                    <?php if($tipo['descripcion']!= 'ABIERTA'):?>
                                                         <option value=""></option>
                                                    <?php endif; 
                                                foreach ($estatus as $est): ?>
                                                    <?php if ($tipo['descripcion'] != $est->descripcion): ?>
                                                        <option value = "<?php echo $est->id_estado ?>"><?php echo $est->descripcion ?></option>
                                                    <?php  endif;
                                                endforeach; ?>
                                            </select>
                                            <div id="<?php echo $tipo['id_orden'] ?>" name= "observacion">
                                                 <label class="control-label" for="observacion">Motivo:</label>
                                                    <div class="control-label">
                                                        <textarea rows="3" autocomplete="off" type="text" onKeyDown=" contador(this.form.motivo,($('#quitar<?php echo $tipo['id_orden'] ?>')),160);" onKeyUp="contador(this.form.motivo,($('#quitar<?php echo $tipo['id_orden'] ?>')),160);"
                                                        value="" style="text-transform:uppercase;" onkeyup="javascript:this.value = this.value.toUpperCase();" class="form-control" id="motivo<?php echo $tipo['id_orden'] ?>" name="motivo" placeholder='Indique el motivo..'></textarea>
                                                    </div> 
                                                    <small><p  align="right" name="quitar" id="quitar<?php echo $tipo['id_orden'] ?>" size="4">0/160</p></small>
                                            </div>
                                        <?php
                                            };
                                        break;
                                        } ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal" aria-hidden="true">Cancelar</button>
                        <?php if($tipo['descripcion']!= 'ABIERTA'):?>
                            <button type="submit" class="btn btn-primary" id="<?php echo $tipo['id_orden'] ?>" >Enviar</button>
                        <?php endif; ?>
                        <input  type="hidden" name="uri" value="<?php echo $this->uri->uri_string() ?>"/>
                    </div>
              
               </form> <!-- /.fin de formulario -->
           </div> <!-- /.modal-content -->
        </div> <!-- /.modal-dialog -->
    </div><!-- /.Fin de modal estatus-->
    <!-- modal nuevo de cuadrilla -->   
    <div id="cua<?php echo $tipo['id_orden'] ?>" class="modal modal-message modal-info fade" tabindex="-1" role="dialog" aria-labelledby="cuadrilla" >
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <!--<form class="form" action="'.base_url().'tic_asigna_cuadrilla/tic_asigna_cuadrilla/asignar_cuadrilla" method="post" name="modifica" id="modifica">-->
                <div class="modal-header">
                    <label class="modal-title">Asignar Cuadrilla</label>
                    <span><i class="fa fa-users" aria-hidden="true"></i></span>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12 text-center">
                                <div class="well well-sm"> 
                                    Solicitud Número: <label name="data" id="data"><?php echo $tipo['id_orden']?></label>
                                </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 text-center">
                            <label class="control-label" for = "tipo">Tipo: <?php echo $tipo['tipo_orden']?></label>
                        </div>
                        <div class="col-md-6 text-center">
                            <label class="control-label" for = "asunto">Asunto: <?php echo $tipo['asunto']?></label>
                        </div>
                    </div>
                    <form class="form" action="<?php echo base_url()?>tic_asigna_cuadrilla/tic_asigna_cuadrilla/asignar_cuadrilla" method="post" name="modific<?php echo $tipo['id_orden']?>" id="modific<?php echo $tipo['id_orden']?>">
                        <input  type="hidden" name="uri" value="tic_solicitudes/detalle/<?php echo $tipo['id_orden']?>">
                        <?php if (($tipo['tiene_cuadrilla']== 'si') || (empty($tipo['tiene_cuadrilla']))):?>
                            <?php if (empty($tipo['cuadrilla'])): ?>
                                    <div class="well well-sm">
                                        <input type ="hidden" id="num_sol" name="num_sol" value="<?php echo $tipo['id_orden']?>">
                                        <div class="row"> 
                                            <div class="col-md-12">
                                                <label class="control-label" for="cuadrilla">Cuadrilla</label>
                                            </div>
                                            <div class="col-md-12">
                                                <select class ="form-control input-sm select2" id = "cuadrilla_select<?php echo $tipo['id_orden']?>" name="cuadrilla_select" onchange="mostrar(this.form.num_sol,this.form.cuadrilla_select,this.form.responsable,$('#tab<?php echo $tipo['id_orden']?>'),'1')">
                                                    <option></option>
                                                <?php foreach ($miembros as $cuad): ?>
                                                    <option value = "<?php echo $cuad->id ?>"><?php echo $cuad->cuadrilla ?></option>
                                                <?php endforeach; ?>
                                                </select>
                                            </div>
                                            <div class="col-md-12">
                                                <label class="control-label" for = "responsable">Responsable de la orden</label>
                                            </div>
                                            <div class="col-md-12">
                                                <select class = "form-control input-sm select2" id = "responsable" name="responsable">
                                                    <option></option>
                                                </select>
                                            </div>
                                            <div id="test" class="col-md-12">
                                                <div id="tab<?php echo $tipo['id_orden']?>" name="tab<?php echo $tipo['id_orden']?> " class="new" >
                                                    <!--aqui se muestra la tabla de las cuadrillas-->   
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                            <?php endif;
                        else:?>
                            <div class="row">
                                <br/>
                                <div class="col-lg-12">
                                    <div class="alert alert-warning" style="text-align:center">No se puede asignar cuadrillas ya que un ayudante es responsable de la orden</div>
                                </div>
                            </div>
                <?php endif;?>
                    </form>
                </div>
            
                <div class="modal-footer">
                    <div class = "col-md-12">
                        <button type="button" class="btn btn-default" data-dismiss="modal" aria-hidden="true">Cancelar</button>
                        <button type="submit" form="modific<?php echo $tipo['id_orden']?>" id="<?php echo $tipo['id_orden']?>" class="btn btn-primary">Guardar cambios</button>
                    </div>
                </div>
            
        </div>   
    </div>
</div>
     <!-- fin de modal nuevo de cuadrilla-->
    <!-- modal de cuadrilla -->   
<!--    <div id="cuad" class="modal modal-message modal-info fade" tabindex="-1" role="dialog" aria-labelledby="cuadrilla" >
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
                           
                            <form class="form" action="<?php echo base_url() ?>tic_asigna_cuadrilla/tic_asigna_cuadrilla/asignar_cuadrilla" method="post" name="modifica" id="modifica">
                                <?php if (($tipo['tiene_cuadrilla']== 'si') || (empty($tipo['tiene_cuadrilla']))):?>
                                    <?php if (empty($tipo['cuadrilla'])): ?>
                                     <input type ="hidden" id="num_sol" name="num_sol" value="<?php echo $tipo['id_orden'] ?>">
                                     <div class="col-md-2">
                                            <label class="control-label" for="cuadrilla">Cuadrilla</label>
                                     </div>
                                     <div class="col-md-12">
                                        <div class="form-group">
                                            <select class = "form-control select2" id = "cuadrilla_select<?php echo $tipo['id_orden'] ?>" name="cuadrilla_select" onchange="mostrar(this.form.num_sol, this.form.cuadrilla_select, this.form.responsable, ($('#ss<?php echo $tipo['id_orden'] ?>')),'1')">
                                                <option></option>
                                                <?php foreach ($miembros as $cuad): ?>
                                                    <option value = "<?php echo $cuad->id ?>"><?php echo $cuad->cuadrilla ?></option>
                                                <?php endforeach; ?>
                                            </select>
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
                                        <div id="ss<?php echo $tipo['id_orden'] ?>">
                                            aqui se muestra la tabla de las cuadrillas
                                        </div>
                                    </div>
                            <?php else: ?>
                                     <input type ="hidden" id="cut" name="cut" value="<?php echo $tipo['id_orden'] ?>">
                                      <input type ="hidden" id="cuadrilla" name="cuadrilla" value="<?php echo $tipo['id_cuadrilla'] ?>">
                                      <div align="center"><label class="alert-danger">Esta cuadrilla ya fue asignada</label></div>
                                      <div class="col-md-6">
                                         <label>Jefe de cuadrilla:</label>
                                         <label name="respon" id="respon<?php echo $tipo['id_orden'] ?>"></label>
                                      </div>
                                      <div class="row">
                                          
                                          <div class="col-md-3">
                                               
                                          </div>
                                      
                                            <div class="col-md-12">
                                                <div class="col-md-5">
                                                    <label>Responsable de la orden:</label>
                                                </div>
                                                <div class="input-group input-group">                                                   
                                                    <select title="Responsable de la orden" class = "form-control" id = "responsable<?php echo($tipo['id_orden']) ?>" name="responsable" disabled>
                                                        <option selected=" " value = "">--Seleccione--</option>
                                                    </select>
                                                    <span class="input-group-addon">
                                                        <label class="fancy-checkbox" title="Haz click para editar responsable">
                                                            <input  type="checkbox"  id="mod_resp<?php echo $tipo['id_orden'] ?>"/>
                                                             <i class="fa fa-fw fa-edit checked" style="color:#D9534F"></i>
                                                             <i class="fa fa-fw fa-pencil unchecked "></i>
                                                        </label>
                                                        <input title="Haz click para editar responsable" class='glyphicon glyphicon-edit' style="color:#D9534F" type="checkbox" aria-label="..." id="mod_resp<?php echo $tipo['id_orden'] ?>">     
                                                    </span>
                                                </div> /input-group 
                                            </div><!-- /.col-lg-6 
                                      </div>
                                      <br>
                                      <br>
                                      <div class="col-lg-12"></div>
                                      <div class="col-lg-14">
                                         <div class="col-md-6"><label for = "responsable">Miembros de la Cuadrilla</label></div>
                                     
                                        <div id="show_signed<?php echo $tipo['id_orden'] ?>" >
                                        mostrara la tabla de la cuadrilla asignada   
                                        </div>
                                      </div>
                                    <br>
                                    <div class="col-lg-12">
                                      <div class="form-control alert-success" align="center">
                                       <label class="checkbox-inline"> 
                                           <input type="checkbox" id="otro<?php echo $tipo['id_orden'] ?>" value="opcion_1">Quitar asignación de la cuadrilla
                                      </label>        
                                      </div>
                                    </div>
                                    <br> 
                                 <?php                                     
                                endif;
                                else:
                                ?>
                                <div class="col-lg-12">
                                 <div class="alert alert-warning" style="text-align: center">No se puede asignar cuadrillas ya que un ayudante es responsable de la orden</div>
                                </div>
                                     <?php endif;?>
                                   <br>   
                                <div class="modal-footer">
                                    <div class = "col-md-12">
                                        <input  type="hidden" name="uri" value="<?php echo $this->uri->uri_string() ?>"/>
                                        <button type="button" class="btn btn-default" data-dismiss="modal" aria-hidden="true">Cancelar</button>
                                        <button type="submit" id="<?php echo $tipo['id_orden'] ?>" class="btn btn-primary">Guardar cambios</button>
                                    </div>
                                </div>
                             </div>
                            </form>
                        
                    </div>
                </div>
        </div>
    </div>-->
     <!-- fin de modal de cuadrilla-->
    <!-- MODAL DE AYUDANTES-->
<!--        <div id="ayudante<?php echo $tipo['id_orden'] ?>" class="modal modal-message modal-info fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
             <div class="modal-dialog">
                 <div class="modal-content">
                     <div class="modal-header">
                         <h4 class="modal-title">Asignar Ayudantes</h4>
                     </div>
                     <div class="modal-body">
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
                         <div>
                        <form id="ay<?php echo $tipo['id_orden'] ?>" class="form-horizontal" action="<?php echo base_url() ?>tic/asignar/ayudante" method="post">
     
                        <?php if (empty($tipo['cuadrilla'])): ?>
                              <div class="col-md-5">
                                <label>Responsable de la orden:</label>
                             </div>                             
                        <?php if(empty($tipo['id_responsable'])):?>
                             
                             <div class="col-md-7">
                                <div class="form-group">
                                    <select class = "form-control input" id = "responsable<?php echo($tipo['id_orden']) ?>" name="responsable">
                                        <option ></option>
                                    </select>
                                </div>
                             </div>  <?php
                             else:?>
                                <div class="col-md-7">
                                <div class="input-group input-group">
                                    <select title="Responsable de la orden" class = "form-control input select2" id = "responsable<?php echo($tipo['id_orden']) ?>" name="responsable" disabled>
                                        <option ></option>
                                    </select>
                                    <span class="input-group-addon">
                                        <label class="fancy-checkbox" title="Haz click para editar responsable">
                                            <input  type="checkbox"  id="mod_resp<?php echo $tipo['id_orden'] ?>"/>
                                            <i class="fa fa-fw fa-edit checked" style="color:#D9534F"></i>
                                            <i class="fa fa-fw fa-pencil unchecked "></i>
                                        </label>
                                     </span>
                                </div>
                                </div>
                            <?php endif;
                         endif;?>
                             <br>
                             <br>
                             <div class="col-md-12"></div>
                            <ul class="nav nav-tabs" role="tablist">
                                <li class="active">
                                    <a href="#tab-table1<?php echo $tipo['id_orden'] ?>" data-toggle="tab">Ayudantes asignados</a>
                                </li>
                                <li>
                                    <a href="#tab-table2<?php echo $tipo['id_orden'] ?>" data-toggle="tab">Ayudantes disponibles</a>
                                </li>
                            </ul>
                            <div class="tab-content">
                                <div class="tab-pane active" id="tab-table1<?php echo $tipo['id_orden'] ?>">
                                 <div id='asignados<?php echo $tipo['id_orden'] ?>'>
                                     AQUI CONSTRULLE UNA LISTA DE AYUDANTES ASIGNADOS A LA ORDEN (revisar script mainFunctions.js linea 208 en adelante)
                                    </div>
                                </div>
                                <div class="tab-pane" id="tab-table2<?php echo $tipo['id_orden'] ?>">
                                    <div id='disponibles<?php echo $tipo['id_orden'] ?>'>
                                     AQUI CONSTRULLE UNA LISTA DE AYUDANTES DISPONIBLES NO ASIGNADOS A LA ORDEN (revisar script mainFunctions.js linea 208 en adelante)
                                 </div>
                                    
                                </div>
                            </div>
                         <?php if ($tipo['tiene_cuadrilla']== 'no'):?>     
                             <div class="col-lg-12">
                                 <div class="form-control alert-success" align="center">
                                    <label class="checkbox-inline"> 
                                        <input type="checkbox" id="otro<?php echo $tipo['id_orden'] ?>" name="cut" value="opcion_1">Quitar asignación de la orden
                                    </label>        
                                 </div>
                            </div>
                        <?php endif; ?>
                             <br>
                            </form>                      
                         </div>
                            
                            <div class="modal-footer">
                                <input form="ay<?php echo $tipo['id_orden'] ?>" type="hidden" name="uri" value="<?php echo $this->uri->uri_string() ?>"/>
                                 <input form="ay<?php echo $tipo['id_orden'] ?>" type="hidden" name="id_orden_trabajo" value="<?php echo $tipo['id_orden'] ?>"/>
                                <button type="button" class="btn btn-default" data-dismiss="modal" aria-hidden="true">Cancelar</button>
                                <button form="ay<?php echo $tipo['id_orden'] ?>" type="submit" class="btn btn-primary">Guardar cambios</button>
                            </div>

                     </div>
                     
                 </div>
             </div> 
        </div>-->
    <!-- FIN DE MODAL DE AYUDANTES-->
     
<!--modal comentarios -->
 <div id="comentarios<?php echo $tipo['id_orden'] ?>" class="modal modal-message modal-info fade" tabindex="-1" role="dialog" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content">
                <div class="modal-header">
                    <label class="modal-title">Observaciones</label><i class="glyphicon glyphicon-comment"></i>
                </div>
            <form class="form" action="<?php echo base_url() ?>tic_solicitudes/observaciones" method="post" onsubmit="if ($('#<?php echo $tipo['id_orden'] ?>')){return valida_observacion($('#observac<?php echo $tipo['id_orden'] ?>'));}">
                <input type="hidden" id= "numsol" name="numsol" value="<?php echo $tipo['id_orden'] ?>">
                <div class="modal-body">
                    <div class="well well-sm">
                    <?php if($agre_observa){?>
                        <div class="form-group">
                            <label class="control-label" for="observac">Observación</label>
                                <div class="col-lg-20">
                                    <textarea rows="3" autocomplete="off" type="text" onKeyDown=" contador(this.form.observac,($('#restando<?php echo $tipo['id_orden'] ?>')),160);" onKeyUp="contador(this.form.observac,($('#restando<?php echo $tipo['id_orden'] ?>')),160);"
                                          value="" style="text-transform:uppercase;" onkeyup="javascript:this.value = this.value.toUpperCase();" class="form-control" id="observac<?php echo $tipo['id_orden'] ?>" name="observac" placeholder='Escriba aqui la observación...'></textarea>
                                </div>
                                <small><p align="right" name="restando" id="restando<?php echo $tipo['id_orden'] ?>" size="4">0/160</p></small>
                        </div>
                    <?php }?>
                    </div>
                <div class="modal-footer">
                    <?php if($agre_observa){?>
                        <button class="btn btn-primary" type="submit">Enviar</button>
                        <hr>
                    <?php }?>
                        <table id="example" class="table table-hover table-bordered table-condensed nowrap" cellspacing="0"  width="100%">
                            <thead class="alert">
                                <tr class="active" >
                                    <th><div align="center">Usuario</div></th>
                                    <th><div align="center">Observacion</div></th>
                                    <th><div align="center">Fecha</div></th>
                                    <th><div align="center">Hora</div></th>
                                </tr>
                            </thead>
                            <tfoot></tfoot>
                            <tbody></tbody>
                        </table>
                </div>
                <div class="modal-footer">
                    <input  type="hidden" name="uri" value="<?php echo $this->uri->uri_string() ?>"/>
                    <button type="button" class="btn btn-default" data-dismiss="modal" aria-hidden="true">Cancelar</button>
                </div>
            </div>
            </form>
        </div>
    </div>
</div>
<!--Modal para cambiar imagen-->
<div id="imagen" class="modal modal-message modal-info fade" tabindex="-1" role="dialog" aria-labelledby="modificacion" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <span><i class="fa fa-file-image-o"></i></span>
                </div>
                <form class="form" action="<?php echo $action?>" method="post" name="modifica" id="modifica" enctype="multipart/form-data">
                    <div class="modal-body row">
                        <div class="col-md-2"></div>
                        <div class="col-md-8">
                          <input id="file-3" name="archivo" type="file" multiple="true" data-show-caption="true" class="file-loading">
                        </div>
                        <div class="col-md-2"></div>
                        <input type="hidden" name="id" value="<?php echo $tipo['id_orden'] ?>" />
                        <input type="hidden" name="img" value="1" />
                        <input type="hidden" name="ruta" value="<?php echo $tipo['ruta']?>" />
                        <!--<br>-->
                    </div>
                    <div class="modal-footer">
                       <button type="button" class="btn btn-default" data-dismiss="modal" aria-hidden="true">Cancelar</button>
                       <button type="submit" id="hola"class="btn btn-primary">Guardar cambios</button>
                    </div>
                </form>


            </div>

        </div>
    </div>

    <!--<div class="clearfix"></div>-->

<script>

    //funcion para validar que el input motivo no quede vacio(esta funcion se llama en el formulario de estatus de la solicitud)
    function valida_motivo(txt) {
        if($(txt).val().length < 1) {  
        $(txt).focus();
        swal({
            title: "Error",
            text: "El motivo es obligatorio",
            type: "error"
        });
       return false;  
   }
}
    function valida_observacion(txt) {
        if($(txt).val().length < 1) {  
        $(txt).focus();
        swal({
            title: "Error",
            text: "La observación es obligatoria",
            type: "error"
        });
       return false;  
   }
}
    function mod_cuad_asignada(sol, id_cuadrilla,tit,cuer,foo,band,close) {
    var id = id_cuadrilla;
    var solicitud = sol;
    var uri,uri2,uri3;
//    console.log(id);
    var Modal;
        Modal = '<div id="cuad' + sol + '" class="modal modal-message modal-info fade" tabindex="-1" role="dialog" aria-hidden="true">'+
                    '<div class="modal-dialog">'+
                        '<div class="modal-content">'+
                            '<div class="modal-header">'+
                                tit+
                            '</div>'+
                            '<div class="modal-body">'+
                                cuer+
                                "<div class=\'well well-sm\'>"+ 
                                    "<div class=\'row\'>"+
                                        "<div class=\'col-md-12 text-center\'>"+
                                            "<label>Jefe de cuadrilla:<\/label>" + ' '+
                                            "<label name='respon' id='res" + sol + "'><\/label>"+
                                        "<\/div>"+
                                    "<\/div>"+
                                    "<div class=\'row\'>" +
                                        "<div class=\'col-md-5\'>" +
                                            "<label>Responsable de la orden:<\/label>" +
                                        "<\/div>" +
                                    "<div class=\'col-md-6\'>" +
                                        "<div class=\'input-group input-group\'>" +
                                            "<select title=\'Responsable de la orden\' class = \'form-control\' id = \'responsable" + sol + "\'\n\
                                                name=\'responsable\' disabled>" +
                                            "<\/select>";
                                        if(typeof(close) !== "undefined" && close !== ''){
                                            Modal = Modal+"<span class=\'input-group-addon\'>" +
                                                "<label class=\'fancy-checkbox\' title=\'Haz click para editar responsable\'>" +
                                                    "<input  type=\'checkbox\'  id=\'mod_resp" + sol + "\'>" +
                                                        "<i class=\'fa fa-fw fa-edit checked\' style=\'color:#D9534F\'><\/i>" +
                                                        "<i class=\'fa fa-fw fa-pencil unchecked\'><\/i>" +
                                                "<\/label>" +
                                            "<\/span>";
                                        }
                                    Modal = Modal+"<\/div>" +
                                    "<\/div>" +
                                    "<div class=\'col-md-12\'><br\/></div>" +
                                        "<div class=\'col-md-12\'>" +
                                            "<div id=\'show_signed" + sol + "\'>" +
                                                "<!--mostrara la tabla de la cuadrilla asignada-->" +
                                            "<\/div>";
//                                      "<br\/>";
                                        if(typeof(close) !== "undefined" && close !== ''){
                                            Modal = Modal+"<div class=\'col-md-12\'>" +
                                                "<div class=\'alert-success\' align=\'center\' style=\'text-align: center\'>" +
                                                    "<label class=\'checkbox-inline\'>" +
                                                        "<input type=\'checkbox\' id=\'otro" + sol + "\' value=\'opcion_1\'>Quitar asignación de la cuadrilla" +
                                                    "<\/label>" +
                                                "<\/div>" +
                                            "<\/div>"+
                                        "<br\/>";
                                    }
                                Modal=Modal+"<\/div>" +
                            "<\/div>" +
                            "<\/form>" +
                        "<\/div>"+
                        '<div class="modal-footer">'+
                            foo+
                        '</div>'+
                    '</div>'+
                '</div>';
        $('body').append(Modal);
        $("#cuad" + sol).modal();
        $("#cuad" + sol).modal('show');
        $("#cuad" + sol).on('hidden.bs.modal', function (e) {
            $(this).remove();
        });
    if (band === 1) {
//        console.log('tic');
        uri  = base_url + "tic_cuadrilla/responsable";
        uri2 = base_url + "tic_cuadrilla/seleccionar";
        uri3 = base_url + "tic_cuadrilla/miembros";
    }else{
        uri  = base_url + "mnt_cuadrilla/responsable";
        uri2 = base_url + "mnt_cuadrilla/seleccionar";
        uri3 = base_url + "mnt_cuadrilla/miembros";
    }
    $.post(uri, {
        id: id
    }, function (data) {
//        $(etiqueta).text(data);
        $('#res'+sol).text(data);
    });
    $.post(uri2, {
        sol: solicitud,
        id: id
    }, function (data) {
        $('#responsable'+sol).append(data);
        $('#responsable'+sol).select2({placeholder: "--SELECCIONE--",allowClear: true});
    });
    $.post(uri3, {
        id: id,
        solicitud: sol
    }, function (data) {
        $('#show_signed'+sol).append(data);
        $('a[data-toggle="tab"]').on( 'shown.bs.tab', function (e) {
            $.fn.dataTable.tables( {visible: true, api: true} ).columns.adjust();
        } );
        $('#cuad_assigned' + solicitud).DataTable({
            "language": {
                "url": base_url+"assets/js/lenguaje_datatable/spanish.json"
            },
//            scrollY:        200,
             scrollCollapse: true,
             'sDom': 'tp',
             responsive: true,
            "bLengthChange": false,
            "iDisplayLength": 5
        });
        $('#ayu_assigned'+ solicitud).DataTable({
            "language": {
                "url": base_url+"assets/js/lenguaje_datatable/spanish.json"
            },
//            scrollY:        200,
             scrollCollapse: true,
             responsive: true,
            'sDom': 'tp',
            "bLengthChange": false,
            "iDisplayLength": 5        
        });
        $('.modal .btn-primary').prop('disabled', true);// para deshabilitar el boton de guardar cambios con la finalidad de usar el checkbox...
        $('#otro'+sol).change(function () {//se verifica con el id del checkbox para habilitar el boton de guardar en el modal
            $('.modal .btn-primary').prop('disabled', !this.checked);
        });
        $('#mod_resp'+sol).change(function () {//se verifica con el id del checkbox para habilitar el boton de guardar en el modal
          $('.modal .btn-primary').prop('disabled', !this.checked);
          $('#responsable'+sol).prop('disabled', !this.checked);
        });
        $('.modal').on('hidden.bs.modal', function () {
            $('#responsable'+sol).prop('disabled', 'disabled');
            $(this).find('form')[0].reset(); //para borrar todos los datos que tenga los input, textareas, select.
            $('#show_signed'+sol).empty();//para vaciar el div donde se guarda la tabla para evitar errores
            $('.modal .btn-primary').prop('disabled', false);
        });

    });    
}

function mod_ayudantes(estatus,sol, tit, cuer, foo, band) {
    var id = sol;
    var table1;
    var table;
    var ayu = 'ayu';
    var uri,uri2,uri3;
    var Modal;
        Modal = '<div id="ayud' + sol + '" class="modal modal-message modal-info fade" tabindex="-1" role="dialog" aria-hidden="true">'+
                    '<div class="modal-dialog">'+
                        '<div class="modal-content">'+
                            '<div class="modal-header">'+
                                tit+
                            '</div>'+
                            '<div class="modal-body">'+
                                cuer+
                            "<\/div>" +
                        "<\/div>"+
                        '<div class="modal-footer">'+
                            foo+
                        '</div>'+
                    '</div>'+
                '</div>';
        $('body').append(Modal);
        $("#ayud" + sol).modal();
        $("#ayud" + sol).modal('show');
        $("#ayud" + sol).on('hidden.bs.modal', function (e) {
            $(this).remove();
        });
    if (band === 1){
        uri  = base_url + "tic/ayudantes/seleccionar";
        uri2 = base_url + "tic/ayudantes/sin_asignar";
        uri3 = base_url + "tic/ayudantes/asignados";
    }else{
        uri = base_url + "mnt/ayudantes/seleccionar";
        uri2= base_url + "mnt/ayudantes/sin_asignar";
        uri3= base_url + "mnt/ayudantes/asignados";
    }
    $('a[data-toggle="tab"]').on( 'shown.bs.tab', function (e) {
    $.fn.dataTable.tables( {visible: true, api: true} ).columns.adjust();
     } );
    $.post(uri, {
        sol: sol,
        id: ayu
    }, function (data) {
//        $(select).html(data);
        $("#ayu_resp"+sol).html(data);
        $("#ayu_resp"+sol).select2({placeholder: "--SELECCIONE--",allowClear: true});
    }); 
    $.post(uri2, {
        id: id
    }, function (data) {
//        $(div1).html(data);
            $('#disponibles' + sol).html(data); 
         
        // console.log('#ayudantes'+sol);
        table1 = $('#ayudisp' + sol).DataTable({
             responsive: true,
            "bLengthChange": false,
//            "sPaginationType": "numbers",
            "iDisplayLength": 4,
            "oLanguage": { 
                "sProcessing": "Procesando...",
                "sLengthMenu": "Mostrar _MENU_ registros",
                "sZeroRecords": "No se encontraron resultados",
                "sInfo": "Muestra desde _START_ hasta _END_ de _TOTAL_ registros",
                "sInfoEmpty": "Muestra desde 0 hasta 0 de 0 registros",
                "sInfoFiltered": "(filtrado de _MAX_ registros en total)",
                "sInfoPostFix": "",
                "sLoadingRecords": "Cargando...",
                "sEmptyTable": "No se encontraron datos",
                "sSearch": "Buscar:",
                "sUrl": "",  
                "oPaginate": 
                {
                    "sNext": '<i class="glyphicon glyphicon-menu-right" ></i>',
                    "sPrevious": '<i class="glyphicon glyphicon-menu-left" ></i>'
//                  "sLast": '<i class="glyphicon glyphicon-step-forward" ></i>',
//                  "sFirst": '<i class="glyphicon glyphicon-step-backward" ></i>'
                }
            }
        });
//        table1.columns.adjust();
    });
    $.post(uri3, {
        id: id,
        estatus: estatus
    }, function (data) {
//        $(div2).html(data);
        $('#asignados' + sol).html(data);
        table = $('#ayudasig' + sol).DataTable({
             responsive: true,
        "oLanguage": {
                "sLengthMenu": "Mostrar _MENU_ registros",
                "sProcessing": "Procesando...",
                "sZeroRecords": "No se encontraron resultados",
                "sInfo": "Muestra desde _START_ hasta _END_ de _TOTAL_ registros",
                "sInfoEmpty": "Muestra desde 0 hasta 0 de 0 registros",
                "sInfoFiltered": "(filtrado de _MAX_ registros en total)",
                "sInfoPostFix": "",
                "sLoadingRecords": "Cargando...",
                "sEmptyTable": "No se encontraron datos",
                "sSearch": "Buscar:",
                "sUrl": "",
        "oPaginate": 
                {
                     "sNext": '<i class="glyphicon glyphicon-menu-right" ></i>',
                    "sPrevious": '<i class="glyphicon glyphicon-menu-left" ></i>'
//                    "sLast": '&laquo',
//                    "sFirst": '&lt'
                }
            },
            "bLengthChange": false,
            "iDisplayLength": 4
        });
//        table.columns.adjust();
    });
//    $(check).change(function () {//se verifica con el id del checkbox para habilitar el boton de guardar en el modal
//        $(select).prop('disabled', !this.checked);
//    });
    $('#mod_resp'+sol).change(function () {//se verifica con el id del checkbox para habilitar el boton de guardar en el modal
        $('#ayu_resp'+sol).prop('disabled', !this.checked);
    });
    $('.modal .btn-primary').prop('disabled', false);
//    $('.modal').on('hidden.bs.modal', function () {
////            $(select).prop('disabled', 'disabled');
//            $(this).find('form')[0].reset(); //para borrar todos los datos que tenga los input, textareas, select.
//            $(div1).empty();//para vaciar el div donde se guarda la tabla para evitar errores   
//            $(div2).empty();//para vaciar el div donde se guarda la tabla para evitar errores 
//    });
}
                    // funcion para habilitar input segun algunas opciones del select de estatus de solicitudes
                            // function statusOnChange(sel,div,txt) {
                                    //    var test = sel.value;
                                            //    switch (test){
                                                    //      case '3':
                                                            //    case '4':     
                                                                    //  case '5':     
                                                                            // case '6':     
                                                                                    //var divC = ($(div));
                                                                                            //divC.show();
                                                                                                    //  $(txt).removeAttr('disabled');
                                                                                                            //  break;
                                                                                                                    // default:
                                                                                                                            //   divC = ($(div));
                                                                                                                                    //    divC.hide();
                                                                                                                                            //   $(txt).attr('disabled','disabled');
                                                                                                                                                    //   break;
                                                                                                                                                            //  }
                                                                                                                                                                    // }; -->
                                                                                                                                                                            //funcion para validar que el input motivo no quede vacio(esta funcion se llama en el formulario de estatus de la solicitud)
                                                                                                                                                                                    function valida_motivo(txt) {
                                                                                                                                                                                    if ($(txt).val().length < 1) {
                                                                                                                                                                                    $(txt).focus();
                                                                                                                                                                                            swal({
                                                                                                                                                                                            title: "Error",
                                                                                                                                                                                                    text: "El motivo es obligatorio",
                                                                                                                                                                                                    type: "error"
                                                                                                                                                                                            });
                                                                                                                                                                                            return false;
                                                                                                                                                                                    }
                                                                                                                                                                                    }


    
</script>

<!--<script>
   
    function validateLetters(x,y)
      {
        var re = /[A-Za-z -']$/;
        if(re.test(document.getElementById(x).value))
        {
          document.getElementById(x).style.background ='#DFF0D8';
          document.getElementById(y).innerHTML = "";
          document.getElementById("hola").disabled=false;
          return true;
        }
        else
        {
          document.getElementById(x).style.background ='#F2DEDE';
          document.getElementById(y).innerHTML = "Solo se permiten letras";
          document.getElementById(x).focus();
          document.getElementById("hola").disabled=true;
          return false; 
        }
      }
      function validatePhone(x,y)
      {
        var phone = /[0-9]+/;
        if(phone.test(document.getElementById(x).value))
        {
          document.getElementById(x).style.background ='#DFF0D8';
          document.getElementById(y).innerHTML = "";
          document.getElementById("hola").disabled=false;
          return true;
        }
        else
        {
          document.getElementById(x).style.background ='#F2DEDE';
          document.getElementById(y).innerHTML = "Debe ser un numero de teléfono válido";
          document.getElementById(x).focus();
          document.getElementById("hola").disabled=true;
            return false;
        }
      }

      function validateEmail(x,y)
      {
        var mail = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;
        if(mail.test(document.getElementById(x).value))
        {
          document.getElementById(x).style.background ='#DFF0D8';
          document.getElementById(y).innerHTML = "";
          return true;
        }
        else
        {
          document.getElementById(x).style.background ='#F2DEDE';
          document.getElementById(y).innerHTML = "Correo invalido (ejemplo: 'usuario'@'servidor'.'dominio')";
          return false;
        }
      }</script>-->
