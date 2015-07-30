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
         color: #040303;
         background-color: transparent;
         font-family: verdana,arial,sans-serif;
         font-size: 14px;
        }
 
        h1 {
         color: #444;
         border-bottom: 1px solid #D0D0D0;
         font-size: 20px;
         font-weight: bold;
         margin: 24px 0 2px 0;
         padding: 5px 0 6px 0;
        }
 
        h2 {
         color: #444;
         background-color: transparent;
         border-bottom: 1px solid #D0D0D0;
         font-size: 16px;
         font-weight: bold;
         margin: 24px 0 2px 0;
         padding: 5px 0 6px 0;
         text-align: center;
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

    </style>
  
     </head>
     <meta charset="utf-8">

    <body>

        <p><img align="right"src="assets/img/LOGO-UC.png" width="50" height="50"></p>
        <p><img src="assets/img/facyt-mediano.gif" width="50" height="50"></p>

        <div align="center" class="awidget-head">
            <h3>Detalles de la Solicitud </h3>
                <table>
                    <tr>
                        <td><strong>Número Solicitud:</strong></td>
                        <td><?php echo $tipo['id_orden']; ?></td>
                        <td>&nbsp;&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;&nbsp;</td>
                        <td><strong>Tipo de Solicitud:</strong></td>
                        <td><?php echo $tipo['tipo_orden']; ?></td>
                    </tr>
                </table>
                <table>
                    <tr>
                        <td><strong>Fecha Creación:</strong></td>
                        <td><?php echo date("d/m/Y", strtotime($creada)); ?></td>
                        <td>&nbsp;&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;&nbsp;</td>
                        <td><strong>Dependencia:</strong></td>
                        <td><?php echo $tipo['dependen']; ?></td>
                    </tr>
                                                                 
                </table>
            <hr>
        </div>
           <br>
           <br>
                <a>Información del contacto</a>
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
                                
                    </table>
                    <br>
                    <br>
                    <a>Información de solicitud</a>
                    <table class="gridtable">
                        <tr>
                            <th><strong>Asunto</strong></th>
                            <th><strong>Descripción</strong></th>
                            <th><strong>Última modificación</strong></th>
                            <th><strong>Estatus</strong></th>
                        </tr>
                        <tr>
                            <td><?php echo $tipo['asunto']; ?></td>
                            <td><?php echo $tipo['descripcion_general']; ?></td>
                            <td><?php echo date("d/m/Y", strtotime($tipo['fecha'])); ?></td>
                            <td><?php echo $tipo['descripcion']; ?></td>
                        </tr> 
                                    
                    </table>
                    <br>
                    <br>
                    <a>Empleados asignados</a>
                    <table class="gridtable">    
                    <?php if ($tipo['id_estado'] != '1' || !empty($cuadrilla)) { ?>
                        <tr>    
                            <th><strong>Cuadrilla</strong></th>
                            <th><strong>Responsable</strong></th>
                            <th><strong>Miembros</strong></th>
                        </tr>
                        <tr>    
                            
                            <?php if (empty($tipo['cuadrilla'])) { ?>
                                <td> <?php echo ('<p class="text-muted">SIN ASIGNAR </p>'); ?></td>
                            <?php } else { ?>
                                <td> <?php
                                    echo ($tipo['cuadrilla']);
                            };
                                ?></td>
                            <?php if (empty($nombre)) { ?>
                                <td> <?php echo ('<p class="text-muted">SIN ASIGNAR </p>'); ?></td>
                            <?php } else { ?>
                                <td> <?php
                                    echo ($nombre);
                                };
                                ?></td>
                            <td><?php
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
                    </table>
                    <br>
                    <br>
                    <table class="gridtable">
                        
                        <tr>
                            <?php
                                if (!empty($ayudantes)) {
                                echo '<th><strong>Ayudantes</strong></th>';
                                echo '<td>';
                                foreach ($ayudantes as $ayu):
                                    echo ($ayu) . '<br>';
                                endforeach;
                                    echo '</td>';
                                };
                    }else {

                                if (!empty($ayudantes)) {
                                    echo '<th><strong>Ayudantes</strong></th>';
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
    <body>
</html>


