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
            <h1>Universidad de Carabobo<br> Facultad Experimental de Ciencias y Tecnologia<br> SiSAI Decanato<br> <?php echo ucfirst($title)?></h1>
            <img align="right" src="assets/img/LOGO-UC.png" width="40" height="50">
            <img align="left" src="assets/img/facyt-mediano.gif" width="50" height="50">
        </div>
        <hr>
	<table class="gridtable" align="align:center">
            <thead>
                <tr>
                    <?php foreach (($table_head) as $i =>$value){?>
                        <th><strong><?php echo ucfirst($value); ?></strong></th>
                    <?php }?>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($tabla as $key => $value):?>
                    <tr>
                        <?php foreach ($table_column as $k):?>
                            <td><?php  echo $value[$k]; ?></td>
                        <?php  endforeach;?>
                    </tr>
                <?php endforeach;?>
            </tbody>
	</table>
        
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