<script type="text/javascript">
    base_url = '<?php echo base_url() ?>';
</script>
<!-- Page content -->
<div class="mainy">
    <!-- Page title -->
    <div class="page-title">
        <h2 align="left">Solicitud</h2>
        <hr /> 
    </div>
    <div class="row">
        <div class="col-md-12">

            <div class="awidget full-width">
                <link href="<?php echo base_url() ?>assets/css/bootstrap.min.css" rel="stylesheet">
                <div class="awidget-head">
                    <h3>Detalles de la Solicitud </h3>
                </div>
                <div class="awidget-body">
                    
                    <div class="row">
                        <div class="col-md-3 col-sm-3">
                        </div>
                        <div class="col-md-9 col-sm-9">
                            
                            <table class="table">
                                <tr>
                                    <td><strong>Número Solicitud:</strong></td>
                                    <td>:</td>
                                    <td><?php echo $tipo['id_orden']; ?></td>
                                </tr>
                                <tr>    
                                    <td><strong>Contacto</strong></td>
                                    <td>:</td>
                                    <td><?php echo $tipo['nombre_contacto']; ?></td>
                                </tr>
                                <tr>    
                                    <td><strong>Teléfono</strong></td>
                                    <td>:</td>
                                    <td><?php echo $tipo['telefono_contacto']; ?></td>
                                </tr>
                                <tr>
                                    <td><strong>Creada por:</strong></td>
                                    <td>:</td>
                                    <td><?php echo $autor; ?></td>
                                </tr>
                                <tr>
                                    <td><strong>Fecha:</strong></td>
                                    <td>:</td>
                                    <td><?php echo date("d/m/Y", strtotime($creada)); ?></td>
                                </tr>
                                <tr>
                                    <td><strong>Última modificación</strong></td>
                                    <td>:</td>
                                    <td><?php echo date("d/m/Y", strtotime($tipo['fecha'])); ?></td>
                                </tr>
                                <tr>    
                                    <td><strong>Tipo de Solicitud</strong></td>
                                    <td>:</td>
                                    <td><?php echo $tipo['tipo_orden']; ?></td>
                                </tr>
                                <tr>    
                                    <td><strong>Dependencia</strong></td>
                                    <td>:</td>
                                    <td><?php echo $tipo['dependen']; ?></td>
                                </tr>
                                <tr>    
                                    <td><strong>Ubicación</strong></td>
                                    <td>:</td>
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
                                        ?></td>
                                </tr>
                                <tr>    
                                    <td><strong>Asunto</strong></td>
                                    <td>:</td>
                                    <td><?php echo $tipo['asunto']; ?></td>
                                </tr>
                                <tr>    
                                    <td><strong>Descripción</strong></td>
                                    <td>:</td>
                                    <td><?php echo $tipo['descripcion_general']; ?></td>
                                </tr>
                                <tr>    
                                    <td><strong>Estatus</strong></td>
                                    <td>:</td>
                                    <td><?php echo $tipo['descripcion']; ?></td>
                                </tr>
                                <?php if ($tipo['id_estado'] != '1' && !empty($cuadrilla)) { ?>
                                    <tr>    
                                        <td><strong>Cuadrilla</strong></td>
                                        <td>:</td>
                                        <?php if (empty($tipo['cuadrilla'])) { ?>
                                            <td> <?php echo ('<p class="text-muted">SIN ASIGNAR </p>'); ?></td>
                                        <?php } else { ?>
                                            <td> <?php
                                                echo ($tipo['cuadrilla']);
                                            };
                                            ?>
                                        </td>
                                    </tr>
                                    <tr>    
                                        <td><strong>Responsable</strong></td>
                                        <td>:</td>
                                        <?php if (empty($nombre)) { ?>
                                            <td> <?php echo ('<p class="text-muted">SIN ASIGNAR </p>'); ?></td>
                                        <?php } else { ?>
                                            <td> <?php
                                                echo ($nombre);
                                            };
                                            ?></td>
                                    </tr>
                                    <tr>    
                                        <td><strong>Miembros</strong></td>
                                        <td>:</td>
                                        <td>
                                            <?php
                                            if (!empty($cuadrilla)) {
                                                foreach ($cuadrilla as $cuad):
                                                    if ($cuad != $nombre):
                                                        echo ($cuad) . '<br>';
                                                    endif;
                                                endforeach;
                                            }else {
                                                echo ('<p class="text-muted">SIN ASIGNAR </p>');
                                            };
                                            ?>
                                        </td>

                                    </tr>
                                    <tr>
                                        <?php
                                        if (!empty($ayudantes)) {
                                            echo '<td><strong>' . 'Ayudantes' . '</strong></td>';
                                            echo '<td>' . ':' . '</td>';
                                            echo '<td>';
                                            foreach ($ayudantes as $ayu):
                                                echo ($ayu) . '<br>';
                                            endforeach;
                                            echo '</td>';
                                        };
                                    }else {
                                        if (!empty($ayudantes)) {
                                            echo '<td><strong>' . 'Ayudantes' . '</strong></td>';
                                            echo '<td>' . ':' . '</td>';
                                            echo '<td>';
                                            foreach ($ayudantes as $ayu):
                                                echo ($ayu) . '<br>';
                                            endforeach;
                                            echo '</td>';
                                        };
                                    };
                                    ?>
                                </tr>

                            </table>
                        </div>
                    </div>
                </div>
            </div>
          
        </div>

    </div>    

 

