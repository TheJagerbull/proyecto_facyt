<html lang="en">
   <head>
  <!--<link type="text/css" href="www/test/css/bootstrap.css" rel="stylesheet" /> -->
    <style type="text/css">
        @page {
            margin: 120px 50px 80px 50px;
        }
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
         text-align: left;
        }
        b{
         color: #333333;
         background-color: transparent;
         font-family: verdana,arial,sans-serif;
         font-weight: normal;
         text-align: right;
         padding-top:20px;
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
            text-align: center;
            color:#333333;
            border-width: 1px;
            border-color: #666666;
            border-collapse: collapse;
            width: 100%;
        }

        table.gridtable {
            font-family: verdana,arial,sans-serif;
            font-size:11px;
            color:#333333;
            border-width: 1px;
            border-color: #666666;
            border-collapse: collapse;
        }
        table.gridtable thead{
            margin-top: 150px;
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
            padding: 6px;
            border-style: solid;
            border-color: #666666;
            background-color: #ffffff;
        }
         #header {
            position: fixed;
            top: -115px;
            width: 100%;
            height: 109px;

        }
        footer {
            position: fixed;
            
        }
        footer .pagenum{
            text-align: center;
        }
        .pagenum:before {
            content: counter(page);
        }
        #content {
            margin-top: 130px;
        }
        .pater > div {
            display: inline-block;
            width: 39%;
    /*** Sólo a efectos de visualización ***/
            /*background: #F3F3A1;*/
            margin: 0;
        }
    </style>
  
     </head>
     <meta charset="utf-8">

    <body>
        <div id="header">
            <h1>Universidad de Carabobo<br> Facultad Experimental de Ciencias y Tecnologia<br> SiSAI Decanato<br> <?php echo ucfirst($cabecera)?></h1>
            <img align="right"src="assets/img/LOGO-UC.png" width="40" height="50">
            <img align="left"src="assets/img/facyt-mediano.gif" width="50" height="50">
        </div>
        <hr>
        <div>
      <?php if(!empty($tabla)):?>
            <?php if(isset($fecha1)&& isset($fecha2)):?>
            <h4 align="center">Desde: <?php echo $fecha1 ?> Hasta:<?php echo $fecha2 ?></h4>
            <?php endif;?>
            <?php if($tipo=='trabajador'):?>
                <?php if(isset($trabajador)):?>
                    <br/>
                    <div class="pater">
                        <div>Trabajador: <?php echo htmlentities("$trabajador"); ?></div>

                        <div></div>
                        <div>Estatus: <?php echo $estatus ?></div>
                    </div>
                    <table class="gridtable" align="align:center">
                        <thead>
                            <tr>
                                <th><strong>Orden</strong></th>
                                <th><strong>Asignada</strong></th>
                                <th><strong>Dependencia</strong></th>
                                <th><strong>Asunto</strong></th>
                                <?php if($estatus == 'Todos'): ?>
                                    <th><strong>Estatus</strong></th>
                                <?php endif;?>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($tabla as $key => $value): ?>
                                <tr>
                                    <?php // foreach ($value as $key => $row): ?>
                                    <td><?php echo $value['id_orden']; ?></td>
                                    <td><?php echo date("d/m/Y", strtotime($value['fecha']))?></td>
                                    <td><?php echo $value['dependen']; ?></td>
                                    <td><?php echo htmlentities($value['asunto']); ?></td>
                                    <?php if($estatus == 'Todos'): ?>
                                        <td><?php echo $value['descripcion'];?></td>
                                    <?php endif; ?>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                <?php else:?>
                    <div class="pater">
                        <div><?php echo 'Todos los trabajadores'; ?></div>
                  
                        <div></div>
                        <div>Estatus: <?php echo $estatus ?></div>
                    </div>
                    <table class="gridtable" align="align:center">
                        <thead>
                            <tr>
                                <?php // foreach ($tabla[0] as $key => $value): ?>
                                    <!--<th><strong><?php // echo ucfirst($key); ?></strong></th>-->
                                    <td><strong>Orden</strong></td>
                                    <td><strong>Asignada</strong></td>
                                    <td><strong>Dependencia</strong></td>
                                    <td><strong>Asunto</strong></td>
                                    <?php if($estatus == 'Todos'): ?>
                                        <td><strong>Estatus</strong></td>
                                    <?php endif;?>
                                <?php // endforeach; ?>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $old_id=0; 
                            foreach ($tabla as $key => $value){ ?>
                            <?php if($old_id != $value['id_trabajador']):?>
                                <?php if($estatus == 'Todos'): ?>
                                    <tr align="align:left"><th colspan="5"><?php echo strtoupper($value['nombre'].' '.$value['apellido']); ?></th></tr>
                                <?php else:?>
                                    <tr align="align:left"><th colspan="4"><?php echo strtoupper($value['nombre'].' '.$value['apellido']); ?></th></tr>
                                <?php endif;
                                $old_id=$value['id_trabajador'];?>
                                <tr>
                                    <td><?php echo $value['id_orden']; ?></td>
                                    <td><?php echo date("d/m/Y", strtotime($value['fecha']))?></td>
                                    <td><?php echo $value['dependen']; ?></td>
                                    <td><?php echo  htmlentities ($value['asunto']); ?></td>
                                    <?php if($estatus == 'Todos'): ?>
                                        <td><?php echo $value['descripcion'];?></td></tr>
                                    <?php endif;?>
                                <?php    else:?>
                                <tr>
                                    <td><?php echo $value['id_orden']; ?></td>
                                    <td><?php echo date("d/m/Y", strtotime($value['fecha']))?></td>
                                    <td><?php echo $value['dependen']; ?></td>
                                    <td><?php echo  htmlentities ($value['asunto']); ?></td>
                                    <?php if($estatus == 'Todos'): ?>
                                        <td><?php echo $value['descripcion'];?></td>
                                    <?php endif;?>
                                <?php endif;// endforeach; ?>
                                </tr>
                            <?php }?>
                        </tbody>
                    </table>
                <?php endif;?>
            <?php endif;?>
            <?php if($tipo=='responsable'):?>
                <?php if(isset($trabajador)):?>
                    <br/>
                    <div class="pater">
                        <div>Responsable: <?php echo htmlentities("$trabajador"); ?></div>

                        <div></div>
                        <div>Estatus: <?php echo $estatus ?></div>
                    </div>
                    <table class="gridtable" align="align:center">
                        <thead>
                            <tr>
                                <?php // foreach ($tabla[0] as $key => $value): ?>
                                <th><strong>Orden</strong></th>
                                <th><strong>Asignada</strong></th>
                                <th><strong>Dependencia</strong></th>
                                <th><strong>Asunto</strong></th>
                                <?php if($estatus == 'Todos'): ?>
                                    <th><strong>Estatus</strong></th>
                                <?php endif;?>
                                <th><strong>Trabajadores</strong></th> 
                                <?php // endforeach; ?>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($tabla as $key => $value): 
                                $cont=0;?>
                                <tr>
                                    <td><?php echo $value['id_orden']; ?></td>
                                    <td><?php echo date("d/m/Y", strtotime($value['fecha']))?></td>
                                    <td><?php echo $value['dependen']; ?></td>
                                    <td><?php echo htmlentities($value['asunto']); ?></td>
                                     <?php if($estatus == 'Todos'): ?>
                                        <td><?php echo $value['descripcion'];?></td>
                                    <?php endif;?>
                                    <td><div align="center">
                                        <?php foreach($ayudantes[$value['id_orden']] as $id=>$ay): 
                                            $cont++;
                                            $total_datos = count($ayudantes[$value['id_orden']]);
                                            echo ucfirst($ay['nombre']).' '.$ay['apellido'];
                                            if($cont<$total_datos):
                                                echo ', ';
                                            endif;
                                            endforeach ?>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                <?php else:?>
                    <div class="pater">
                        <div>Responsables</div>
                        <!--<div></div>-->
                        <div></div>
                        <div>Estatus: <?php echo $estatus ?></div>
                    </div>
                    <table class="gridtable" align="align:center">
                        <thead>
                            <tr>
                                <?php // foreach ($tabla[0] as $key => $value): ?>
                                    <!--<th><strong><?php // echo ucfirst($key); ?></strong></th>-->
                                    <td><strong>Orden</strong></td>
                                    <td><strong>Asignada</strong></td>
                                    <td><strong>Dependencia</strong></td>
                                    <td><strong>Asunto</strong></td>
                                    <?php if($estatus == 'Todos'): ?>
                                        <td><strong>Estatus</strong></td>
                                <?php endif;?>
                                    <td><strong>Trabajadores</strong></td>
                                <?php // endforeach; ?>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $old_id=0; 
                            foreach ($tabla as $key => $value){
                                $cont=0;?>
                            <?php if($old_id != $value['id_responsable']):?>
                                 <?php if($estatus == 'Todos'): ?>
                                    <tr align="align:left"><th colspan="6"><?php echo strtoupper($value['nombre'].' '.$value['apellido']); ?></th></tr>
                                <?php else:?>
                                    <tr align="align:left"><th colspan="5"><?php echo strtoupper($value['nombre'].' '.$value['apellido']); ?></th></tr>
                                <?php endif;
                                $old_id=$value['id_responsable'];?>
                                <tr>
                                    <td><?php echo $value['id_orden']; ?></td>
                                    <td><?php echo date("d/m/Y", strtotime($value['fecha']))?></td>
                                    <td><?php echo $value['dependen']; ?></td>
                                    <td><?php echo  htmlentities ($value['asunto']); ?></td>
                                     <?php if($estatus == 'Todos'): ?>
                                        <td><?php echo $value['descripcion'];?></td>
                                <?php endif;?>
                                    <td><div align="center">
                                        <?php foreach($ayudantes[$value['id_orden']] as $id=>$ay): 
                                            $cont++;
                                            $total_datos = count($ayudantes[$value['id_orden']]);
                                            echo ucfirst($ay['nombre']).' '.$ay['apellido'];
                                            if($cont<$total_datos):
                                                echo ', ';
                                            endif;
                                            endforeach ?>
                                        </div>
                                    </td>
                                </tr>
                                <?php else:?>
                                <tr>
                                    <td><?php echo $value['id_orden']; ?></td>
                                    <td><?php echo date("d/m/Y", strtotime($value['fecha']))?></td>
                                    <td><?php echo $value['dependen']; ?></td>
                                    <td><?php echo  htmlentities ($value['asunto']); ?></td>
                                     <?php if($estatus == 'Todos'): ?>
                                        <td><?php echo $value['descripcion'];?></td>
                                <?php endif;?>
                                    <td><div align="center">
                                        <?php foreach($ayudantes[$value['id_orden']] as $id=>$ay): 
                                            $cont++;
                                            $total_datos = count($ayudantes[$value['id_orden']]);
                                            echo ucfirst($ay['nombre']).' '.$ay['apellido'];
                                            if($cont<$total_datos):
                                                echo ', ';
                                            endif;
                                            endforeach ?>
                                        </div>
                                    </td>
                                <?php endif;// endforeach; ?>
                                </tr>
                            <?php }?>
                        </tbody>
                    </table>
                <?php endif;?>
            <?php endif;?>
            <?php if($tipo==''):?>
                <div class="pater">
                        <div>Reporte General</div>
                        <!--<div></div>-->
                        <div></div>
                        <div>Estatus: <?php echo $estatus ?></div>
                    </div>
                    <table class="gridtable" align="align:center">
                        <thead>
                            <tr>
                                <?php // foreach ($tabla[0] as $key => $value): ?>
                                    <!--<th><strong><?php // echo ucfirst($key); ?></strong></th>-->
                                    <th><strong>Orden</strong></th>
                                    <th><strong>Fecha</strong></th>
                                    <th><strong>Dependencia</strong></th>
                                    <th><strong>Asunto</strong></th>
                                    <?php if($estatus == 'Todos'): ?>
                                        <th><strong>Estatus</strong></th>
                                <?php endif;?>
                                    <!--<td><strong>Responsable</strong></td>-->
                                    <!--<td><strong>Trabajadores</strong></td>-->
                                <?php // endforeach; ?>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                            foreach ($tabla as $key => $value){?>
                                <tr>
                                    <td><?php echo $value['id_orden']; ?></td>
                                    <td><?php echo date("d/m/Y", strtotime($value['fecha']))?></td>
                                    <td><?php echo $value['dependen']; ?></td>
                                    <td><?php echo  htmlentities ($value['asunto']); ?></td>
                                     <?php if($estatus == 'Todos'): ?>
                                        <td><?php echo $value['descripcion'];?></td>
                                <?php endif;?>
                                    <!--<td><?php echo htmlentities($value['nombre'].' '.$value['apellido']); ?></td>-->
<!--                                    <td><div align="center">
                                        <?php foreach($ayudantes[$value['id_orden']] as $id=>$ay): 
                                            $cont++;
                                            $total_datos = count($ayudantes[$value['id_orden']]);
                                            echo ucfirst($ay['nombre']).' '.$ay['apellido'];
                                            if($cont<$total_datos):
                                                echo ', ';
                                            endif;
                                            endforeach ?>
                                        </div>
                                    </td>-->
                                </tr>
                               
                             
                                </tr>
                            <?php }?>
                        </tbody>
                    </table>
                <?php endif;?>
          
            <?php if($tipo=='tipo_orden'):?>
                <?php if(isset($tipo_de_orden)):?>
                    <br/>
                    <div class="pater">
                        <div>Tipo de Orden: <?php echo htmlentities("$tipo_de_orden"); ?></div>

                        <div></div>
                        <div>Estatus: <?php echo $estatus ?></div>
                    </div>
                    <table class="gridtable" align="align:center">
                        <thead>
                            <tr>
                                <?php // foreach ($tabla[0] as $key => $value): ?>
                                <th><strong>Orden</strong></th>
                                <th><strong>Fecha</strong></th>
                                <th><strong>Dependencia</strong></th>
                                <th><strong>Asunto</strong></th>
                                <?php if($estatus == 'Todos'): ?>
                                    <th><strong>Estatus</strong></th>
                                <?php endif;?>
<!--                                <th><strong>Trabajadores</strong></th> -->
                                <?php // endforeach; ?>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($tabla as $key => $value): 
                                $cont=0;?>
                                <tr>
                                    <td><?php echo $value['id_orden']; ?></td>
                                    <td><?php echo date("d/m/Y", strtotime($value['fecha']))?></td>
                                    <td><?php echo $value['dependen']; ?></td>
                                    <td><?php echo htmlentities($value['asunto']); ?></td>
                                    <?php if($estatus == 'Todos'): ?>
                                        <td><?php echo $value['descripcion'];?></td>
                                <?php endif;?>
                                    <!--<td><?php echo htmlentities($value['nombre'].' '.$value['apellido']); ?></td>-->
<!--                                    <td><div align="center">
                                        <?php foreach($ayudantes[$value['id_orden']] as $id=>$ay): 
                                            $cont++;
                                            $total_datos = count($ayudantes[$value['id_orden']]);
                                            echo ucfirst($ay['nombre']).' '.$ay['apellido'];
                                            if($cont<$total_datos):
                                                echo ', ';
                                            endif;
                                            endforeach ?>
                                        </div>
                                    </td>-->
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                <?php else:?>
                    <div class="pater">
                        <div>Tipo de Orden</div>
                        <!--<div></div>-->
                        <div></div>
                        <div>Estatus: <?php echo $estatus ?></div>
                    </div>
                    <table class="gridtable" align="align:center">
                        <thead>
                            <tr>
                                <?php // foreach ($tabla[0] as $key => $value): ?>
                                    <!--<th><strong><?php // echo ucfirst($key); ?></strong></th>-->
                                    <td><strong>Orden</strong></td>
                                    <td><strong>Fecha</strong></td>
                                    <td><strong>Dependencia</strong></td>
                                    <td><strong>Asunto</strong></td>
                                    <?php if($estatus == 'Todos'): ?>
                                        <td><strong>Estatus</strong></td>
                                <?php endif;?>
                                    <!--<td><strong>Responsable</strong></td>-->
                                    <!--<td><strong>Trabajadores</strong></td>-->
                                <?php // endforeach; ?>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $old_id=0; 
                            foreach ($tabla as $key => $value){
                                $cont=0;?>
                            <?php if($old_id != $value['id_tipo']):?>
                                    <?php if($estatus == 'Todos'): ?>
                                        <tr align="align:left"><th colspan="5"><?php echo strtoupper($value['tipo_orden']); ?></th></tr>
                                    <?php else:?>
                                        <tr align="align:left"><th colspan="4"><?php echo strtoupper($value['tipo_orden']); ?></th></tr>
                                    <?php endif;
                                    $old_id=$value['id_tipo'];?>
                                <tr>
                                    <td><?php echo $value['id_orden']; ?></td>
                                    <td><?php echo date("d/m/Y", strtotime($value['fecha']))?></td>
                                    <td><?php echo $value['dependen']; ?></td>
                                    <td><?php echo  htmlentities ($value['asunto']); ?></td>
                                     <?php if($estatus == 'Todos'): ?>
                                        <td><?php echo $value['descripcion'];?></td>
                                <?php endif;?>
                                    <!--<td><?php echo htmlentities($value['Nombre'].' '.$value['Apellido']); ?></td>-->
<!--                                    <td><div align="center">
                                        <?php foreach($ayudantes[$value['id_orden']] as $id=>$ay): 
                                            $cont++;
                                            $total_datos = count($ayudantes[$value['id_orden']]);
                                            echo ucfirst($ay['nombre']).' '.$ay['apellido'];
                                            if($cont<$total_datos):
                                                echo ', ';
                                            endif;
                                            endforeach ?>
                                        </div>
                                    </td>-->
                                </tr>
                                <?php  else:?>
                                <tr>
                                    <td><?php echo $value['id_orden']; ?></td>
                                    <td><?php echo date("d/m/Y", strtotime($value['fecha']))?></td>
                                    <td><?php echo $value['dependen']; ?></td>
                                    <td><?php echo  htmlentities ($value['asunto']); ?></td>
                                     <?php if($estatus == 'Todos'): ?>
                                        <td><?php echo $value['descripcion'];?></td>
                                <?php endif;?>
                                    <!--<td><?php echo htmlentities($value['nombre'].' '.$value['apellido']); ?></td>-->
<!--                                    <td><div align="center">
                                        <?php foreach($ayudantes[$value['id_orden']] as $id=>$ay): 
                                            $cont++;
                                            $total_datos = count($ayudantes[$value['id_orden']]);
                                            echo ucfirst($ay['nombre']).' '.$ay['apellido'];
                                            if($cont<$total_datos):
                                                echo ', ';
                                            endif;
                                            endforeach ?>
                                        </div>
                                    </td>-->
                                <?php endif;// endforeach; ?>
                                </tr>
                            <?php }?>
                        </tbody>
                    </table>
                <?php endif;?>
            <?php endif;?>
         <?php 
        else:
           echo '<div align="center"> No se encontraron resultados </div>';  
        endif;?>
        </div>
        <footer>
            <div id="footer">
                <script type="text/php">
                    if ( isset($pdf) ) {
                        $pdf->open_object();
                        $font = Font_Metrics::get_font("helvetica", "bold");
                        $pdf->page_text(280, 750, "Pagina: {PAGE_NUM} de {PAGE_COUNT}", $font, 6, array(0,0,0));
                        $pdf->close_object();
                    }
                </script>
            </div>
        </footer>
	</body>
</html>