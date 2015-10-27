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
            <h3><?php echo ucfirst($cabecera)." ".date('Y', $fecha_cierre);?></h3>
                <br><br><br>
		</div>
		<hr>
		<div>
			<h4><strong><?php echo ucfirst($tabla);?></strong></h4>
			<table class="gridtable">
				<thead>
                    <tr>
                        <?php foreach ($historial[0] as $key => $value):?>
                        <td><strong><?php echo ucfirst($key); ?></strong></td>
                        <?php endforeach;?>
                    </tr>
				</thead>
				<tbody>
					<?php foreach ($historial as $key => $value):?>
                    <tr>
                        <?php foreach ($value as $key => $row):?>
                        <td><?php echo $row; ?></td>
                        <?php endforeach;?>
                    </tr>
					<?php endforeach;?>
				</tbody>
			</table>
		</div>
	</body>
</html>