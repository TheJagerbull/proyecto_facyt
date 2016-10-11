<html lang="en">
   <head>
  <!--<link type="text/css" href="www/test/css/bootstrap.css" rel="stylesheet" /> -->
    <style type="text/css">
        body {
         background-color: #fff;
         margin: 7px;
         font-family: verdana,arial,sans-serif;
         font-size: 14px;
         color: #4F5155;
        }
         a {
         color: #333333;
         background-color: transparent;
         font-family: verdana,arial,sans-serif;
         font-weight: normal;
        }
 
        h1 {
        text-align: center;
        color: #333333;
        background-color: transparent;
        font-size: 10px;
        font-family: verdana,arial,sans-serif;
        margin: 24px 0 2px 0;
        padding: 5px 0 6px 0;
         
        }
 
        table{
            font-family: verdana,arial,sans-serif;
            text-align: left;
            color:#333333;
            border-width: 1px;
            border-color: #666666;
            border-collapse: collapse;
            
        }

        table.gridtable {
            font-family: verdana,arial,sans-serif;
            font-size:11px;
            color:#333333;
            border-width: 1px;
            border-color: #666666;
            border-collapse: collapse;
        }       
        table.gridtable th {
            border-width: 1px;
            padding: 8px;
            border-style: solid;
            border-color: #666666;
            background-color: #dedede;
        }
        table.gridtable td {
            border-width: 1px;
            padding: 8px;
            border-style: solid;
            border-color: #666666;
            background-color: #ffffff;
        }
         #header {
            position: fixed;

        }
        #footer {
            position: fixed;
            
        }
        #footer .pagenum:before {
            content: counter(page); 
        }

    </style>
    <?php// die_pre($tipo);?>
     </head>
     <meta charset="utf-8">

    <body>
        <div id="header">
            <h1>Universidad de Carabobo<br> Facultad Experimental de Ciencias y Tecnologia</h1>
            <img align="right"src="assets/img/LOGO-UC.png" width="40" height="50">
            <img align="left"src="assets/img/facyt-mediano.gif" width="50" height="50">
                      
        </div>
        <div id="footer">
            <script type="text/php">
                if ( isset($pdf) ) {
                    $pdf->open_object();
                    $font = Font_Metrics::get_font("helvetica", "bold");
                    $pdf->page_text(280, 750, "Pagina: {PAGE_NUM} de {PAGE_COUNT}", $font, 6, array(0,0,0));
                    $pdf->close_object();
                }
            </script>
        </div><br><br><br><br><br><br>
        <div align="center" class="awidget-head">
            <h3>Detalles de la Solicitud </h3>
                <br><br><br>
                <table>
                    <tr>
                        <td><strong>Número Solicitud:</strong></td>
                        <td><?php echo $tipo['id_orden']; ?></td>
                        <td>&nbsp;&nbsp;&nbsp;</td><td>&nbsp;&nbsp;&nbsp;</td><td>&nbsp;&nbsp;&nbsp;</td>
                        <td><strong>Tipo de Solicitud:</strong></td>
                        <td><?php echo $tipo['tipo_orden']; ?></td>
                    </tr>
                </table>
                <table>
                    <tr>
                        <td><strong>Fecha Creación:</strong></td>
                        <td><?php echo date("d/m/Y", strtotime($creada)); ?></td>
                        <td>&nbsp;&nbsp;&nbsp;</td><td>&nbsp;&nbsp;&nbsp;</td><td>&nbsp;&nbsp;&nbsp;</td><td>&nbsp;&nbsp;&nbsp;</td>
                        <td><strong>Dependencia:</strong></td>
                        <td><?php echo $tipo['dependen']; ?></td>
                    </tr>
                                                                 
                </table>
            <hr>
        </div><br><br><br><br>
                <a>Información del contacto</a><br>
                <table class="gridtable">
                    <tr>
                        <th><strong>Contacto</strong></th>
                        <th><strong>Teléfono</strong></th>
                        <th><strong>Creada por</strong></th>
                        <th><strong>Ubicación</strong></th>
                    </tr>
                    <tr>
                        <td><?php echo $tipo['nombre_contacto']; ?></td>
                        <td><?php echo $tipo['telefono_contacto']; ?></td>
                        <td><?php echo $autor; ?></td>
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
                                
                    </table><br><br><br><br>
                    <a>Información de solicitud</a><br>
                    <table class="gridtable">
                        <tr>
                            <th><strong>Asunto</strong></th>
                            <th><strong>Descripción</strong></th>
                            <th><strong>Fecha cambio de estatus</strong></th>
                            <th><strong>Fecha de Creación</strong></th>
                            <th><strong>Estatus</strong></th>
                            <?php if ($tipo['id_estado'] == '3' || $tipo['id_estado'] == '4' || $tipo['id_estado'] == '5' || $tipo['id_estado'] == '6'): ?>
                                <th><strong>Motivo del estatus</strong></th>
                            <?php endif;?>
                        </tr>
                        <tr>
                            <td><?php echo $tipo['asunto']; ?></td>
                            <td><?php echo $tipo['descripcion_general']; ?></td>
                            <td><?php echo date("d/m/Y", strtotime($tipo['fecha'])); ?></td>
                            <td><?php echo date("d/m/Y", strtotime($creada)); ?></td>
                            <td><?php echo $tipo['descripcion']; ?></td>
                            <?php if ($tipo['id_estado'] == '3' || $tipo['id_estado'] == '4' || $tipo['id_estado'] == '5' || $tipo['id_estado'] == '6'): ?>
                                <td><?php echo $tipo['motivo'];?></td>
                            <?php endif;?>
                        </tr> 
                                    
                    </table><br><br><br><br>
                    <?php if ($tipo['id_estado'] != '1'):?>
                        <a>Empleados asignados</a>
                    <?php endif;?><br>
                    <table class="gridtable">    
                        <?php if ($tipo['id_estado'] != '1' || !empty($cuadrilla)) : ?>
                            <tr>    
                                <th><strong>Cuadrilla</strong></th>
                                <th><strong>Jefe de cuadrilla</strong></th>
                                <th><strong>Miembros</strong></th>
                                <?php if (!empty($responsable['id_responsable'])): ?>
                                    <th><strong>Responsable de la orden</strong></th>
                                <?php endif;?>
                            </tr>
                            <tr>    
                                <?php if (empty($tipo['cuadrilla'])) : ?>
                                        <td> <?php echo ('<p class="text-muted">SIN ASIGNAR </p>'); ?></td>
                                    <?php  else : ?>
                                        <td> <?php echo ($tipo['cuadrilla']);
                                endif;?></td>
                                <?php if (empty($nombre)) : ?>
                                        <td> <?php echo ('<p class="text-muted">SIN ASIGNAR </p>'); ?></td>
                                    <?php  else : ?>
                                        <td> <?php echo ($nombre);
                                endif;?></td>
                                <td><?php if (!empty($cuadrilla)) : 
                                         foreach ($cuadrilla as $cuad):
//                                            if ($cuad != $nombre): 
                                                echo ($cuad) . '<br>';
//                                            endif;
                                         endforeach;
                                     else : ?>
                                        <?php echo ('<p class="text-muted">SIN ASIGNAR </p>');
                                endif;?></td>
                                <?php if (!empty($responsable['id_responsable'])) : ?>
                                    <td><?php  echo ($responsable['nombre'].' '.$responsable['apellido']);  ?></td>
                                <?php endif;?>
                            </tr>
                    </table><br><br>
                    <table class="gridtable">
                            <tr>
                                <?php if (!empty($ayudantes)) :
                                    echo '<th><strong>Ayudantes</strong></th>';
                                    echo '<td>';
                                    foreach ($ayudantes as $ayu): 
                                        echo ($ayu) . '<br>';
                                    endforeach; 
                                        echo '</td>';
                                   endif; ?>
                              </tr>  
                       <?php else : ?>
                            <tr>
                                <?php if (!empty($ayudantes)) :
                                    echo '<th><strong>Ayudantes</strong></th>';
                                    echo '<td>';
                                foreach ($ayudantes as $ayu):
                                    echo ($ayu) . '<br>';
                                endforeach;
                                    echo '</td>';

                                endif; ?>
                        <?php endif; ?>

                            </tr>
                              
                    </table>
      
  <?php if ($tipo['id_estado'] == '2'){?>
            <br><br>
            <div align="right">Fecha de culminaci&oacute;n: ___ de ___________ de _______</div>
            <br><br><br>
            <div align="right">Recibida por:_____________________</div>
  <?php }?>
    
    </body>
</html>


