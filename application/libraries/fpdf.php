<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
    // Incluimos el archivo fpdf
    require_once APPPATH."/third_party/fpdf/fpdf.php";
 
    //Extendemos la clase Pdf de la clase fpdf para que herede todas sus variables y funciones
    class Pdf extends FPDF {
        public function __construct() {
            parent::__construct();
        }
        var $ProcessingTable=false;
        var $borde=false;
        var $cols = array();
        var $tmp = array();
        var $TableX;
        var $HeaderColor;
        var $old_data;
        var $title;
        var $band;
        // El encabezado del PDF
        public function Header(){
            //Imagen izquierda
            $this->Image('assets/img/facyt-mediano.gif', 10, 8, 12, 13);
            //Imagen derecha
            $this->Image('assets/img/LOGO-UC.png', 190, 8, 10,13);
            $this->SetFont('Arial','', 8);
            //Texto de Título
            $this->Cell(78);
            $this->Cell(30,10,'Universidad de Carabobo',0,'C');
            $this->Ln(3);
            $this->Cell(64);
            $this->Cell(30,10,'Facultad Experimental de Ciencias y Tecnologia',0,'C');
            $this->Ln(3);
            $this->Cell(84);
            $this->Cell(30,10,'SiSAI Decanato',0,'C');
            $this->Ln(11);
            if($this->ProcessingTable){
                $this->TableHeader();
                if ($this->old_data != ''){
                    $this->SetFillColor(190);
                    $this->SetFont('Arial','', 9);
                    $this->Cell($this->w-$this->rMargin-$this->lMargin,6,utf8_decode($this->old_data),'1',0,'C',true);
                    $this->Ln();
                }
            }
           
       }
       // El Footer del pdf
        public function Footer(){
           $this->SetY(-20);
           $this->SetFont('Arial','I',7);
           $this->Cell(0,10,utf8_decode('Página ').$this->PageNo().'/{nb}',0,0,'C');
           $this->SetY(-15);
           $this->Cell(0,10,utf8_decode('Derechos reservados ©FACYT - UST FACYT Dep: Desarrollo.') ,0,0,'C');
           $this->Ln();
           $this->SetY(-10);
           date_default_timezone_set('America/Caracas');
           $this->Cell(0,10,utf8_decode('- - - -   Impreso el ') . date("d/m/y") . ' a las ' . date('h:i:s',time()+1800) . ' hora del servidor   - - - -',0,0,'C');
        }
        
        function CalcWidths($width, $align) {
            //Calcular el ancho de las columnas
            $TableWidth = 0;
            foreach ($this->cols as $i => $col) {
                $w = $col['w'];
                if ($w == -1){
                    $w = $width / count($this->cols);
                }elseif (substr($w, -1) == '%'){
                    $w = $w / 100 * $width;
                }
                $this->cols[$i]['w'] = $w;
                $TableWidth+=$w;
                
            }
            //Calcular la abscissa de la tabla para la alineacion del texto
            if ($align == 'C'){
                $this->TableX = max(($this->w - $TableWidth) / 2, 0);
            }elseif ($align == 'R'){
                $this->TableX = max($this->w - $this->rMargin - $TableWidth, 0);
            }else{
                $this->TableX = $this->lMargin;
            }
        }

    function AddCol($field = -1, $width = -1, $caption = '', $align = 'L') {
            //Añadir las columnas a la tabla
            if ($field == -1)
                $field = count($this->cols);
            $this->cols[] = array('f' => $field, 'c' => $caption, 'w' => $width, 'a' => $align);
        }

    // Tabla
     function tabla($header, $data, $colum, $titles, $tipo = '') {
//          $this->band = true;
        // Colores, ancho de línea y fuente en negrita
        $width = $this->w-$this->lMargin-$this->rMargin;
        $this->SetDrawColor('160');
        $this->Line($this->w-$this->rMargin, '26',  $this->lMargin,'26');
        if (isset($titles) && is_array($titles)){
            $titcount = count($titles);
//            echo_pre($titcount);
            $this->SetTextColor('90');
            $this->SetFont('', '',10);
            switch ($titcount){
                case '1':
                    $tot= ($width - $this->GetStringWidth($titles['1']))/2 ;
                    $this->Cell(($tot));
                    $this->Cell($width,6,iconv('UTF-8', 'windows-1252', $titles['1']),0,'C');
                break;
                case '2':
                    $tot= ($width - $this->GetStringWidth($titles['2']) - $this->GetStringWidth($titles['1']- $this->rMargin- $this->lMargin)/2);
                    $this->Cell($this->lMargin);
                    $this->Cell($this->GetStringWidth($titles['1']),6,iconv('UTF-8', 'windows-1252', $titles['1']),0);
                    $this->Cell($tot-$this->GetX());
                    $this->Cell($this->GetStringWidth($titles['2']),6,iconv('UTF-8', 'windows-1252', $titles['2']),0);
                break;
                case '3':
                      $tot['1'] = ($width - $this->lMargin)/$titcount;
                      $tot['2'] = ($width)/count($titles);
                      $tot['3'] = ($width - $this->rMargin)/$titcount;
                        $a['1'] = 'L';
                        $a['2'] = 'C';
                        $a['3'] = 'R';
                      for ($i = 1; $i <= $titcount; $i++) {
                        //Para guardar la posicion actual
                        $x = $this->GetX();
                        $y = $this->GetY();
                        //Escribir lo que se necesita
                        $this->MultiCell($tot[$i], 6, iconv('UTF-8', 'windows-1252',$titles[$i]), 0, $a[$i]);
                        //Ubica la posicion correcta para imprimir o mostrar la celda.
                        $this->SetXY($x + $tot[$i], $y);
                      }
                break;
            }
        }else{
            $this->Cell(30);
            $this->Cell(30,6,utf8_decode('Debe especificar el titulo del reporte como Array'),0,'C');
        }
        $this->SetTextColor('');
        $this->Ln();
        $this->SetFont('', '', 8);
        // Cabecera
//        $this->tmp = $w;
//        echo_pre($w);
//        $this->SetWidths($w);
//        $this->cols = $header;
        //Se evalua la cantidad de datos y si es cero se añaden las columnas de la tabla
        if(count($this->cols)==0)
        {
            if ($tipo == ''){
                $this->HeaderColor = array('192','192','192');
                $number_col=count($header);
                for($i=0;$i<$number_col;$i++){
                    $this->AddCol();
                }
            }else{
                $this->HeaderColor = array('255','255','255');
                $this->borde = true;
                $number_col=count($header)-1;
                for($i=0;$i<$number_col;$i++){
                    $this->AddCol();
                }
            }
        }
        //Para tomar los nombres de las columnas en el header
        
        foreach($this->cols as $i=>$col)
        {
            if($col['c']=='')
            {
                $this->cols[$i]['c']= $header[$i];
            }
        }
        
        $align = 'C';
//        $w = $this->make_size_cel($data, $colum, $header);
        $this->CalcWidths($width,$align);
//        foreach ($w as $t => $z){
//            $this->cols[$t]['w'] = $z;
////            echo $z.'<br>';
//        }
       // die_pre($this->cols);
        $this->TableHeader();
//        die();
        // Restauración de colores y fuentes
        $this->SetFillColor(224, 235, 255);
        $this->SetTextColor(0);
        $this->SetFont('');
//        die_pre($this->cols);
        foreach ($this->cols as $col){
            $size[] = $col['w'];
        }
//        echo_pre($size);
        $this->SetWidths($size);
        // Datos
//    $fill = false;
    if ($data != ''){
//        $w = $this->make_size_cel($data, $colum, $header);
        $this->old_data = ''; //Variable donde almacenaré la columna para el colspan en caso de existir.
        if($this->es_bidimensional($data)){
            foreach ($data as $key => $value) {
                    if ($tipo == '') {
                        foreach ($colum as $k => $val) {
                            $nuevo[$k] = ($value[$val]);
                        }
                    } else {
                        if ($this->old_data != $data[$key][$colum[($number_col)]]) {
                            $this->SetFillColor(190);
                            $this->Cell($width, 6, iconv('UTF-8', 'windows-1252', $data[$key][$colum[($number_col)]]), '1', 0, 'C', true);
                            $this->Ln();
                            $this->old_data = $data[$key][$colum[($number_col)]];
                        }
                        $i = 0;
                        while ($i < $number_col) {
                            $nuevo[$i] = ($data[$key][$colum[$i]]);
                            $i++;
                        }
                    }
                    $this->ProcessingTable = true;
                    $this->Row($nuevo);
                    $this->ProcessingTable = false;
                }
            }else{
                $this->SetFont('', 'B', '12');
                $this->SetTextColor(220,50,50);
                //$this->SetFillColor(200,220,255);
                $this->Cell($width, 5, 'Error... La variable data no es un array bidimensional','1','1','C',true);
                $this->SetTextColor('');
            }
    }else{
            $this->Cell($width, 6, utf8_decode('No se encontraron resultados...'), '1', '1', 'C', true);
        }
        $this->SetAuthor('Juan Carlos Parra');
    }

    function TableHeader(){
        $fill=!empty($this->HeaderColor);
        $this->SetFont('','B','9');
        if($fill){
            $this->SetFillColor($this->HeaderColor[0],$this->HeaderColor[1],$this->HeaderColor[2]);
        }
        foreach($this->cols as $col){
            $this->Cell($col['w'],6,iconv('UTF-8', 'windows-1252',($col['c'])),1,0,'C',true);
        }
        $this->Ln();
    }
    
    function make_size_cel($data, $columns, $header) {
//    echo_pre($columns);
        
        $w = $columns;
        $z = 0;
        $total =0;
        $total = count($columns);
        $width = $this->w-$this->lMargin-$this->rMargin;
        foreach ($data as $d => $dat) {

            foreach ($columns as $c => $col) {
//            $t = mb_strlen($dat[$col], 'utf8');
//            $h = mb_strlen($header[$c], 'utf8');
                
//            echo_pre($pag);
                $h[] = $this->GetStringWidth($header[$c]);
                $t[] = $this->GetStringWidth($dat[$col]);
                
//                $h = (($width - $this->GetStringWidth($header[$c])) / $total) ;
//                $t = (($width - $this->GetStringWidth($dat[$col]) ) / $total) ;
//            echo_pre($h);
//            if($col == 'descripcion'){
//                $t = $t + 40;
//                $h = $h + 40;
//            }
//            echo $h.' '.$t.'<br>';
                
//                echo_pre($this->cols);
//                $this->cols[$c]['w'] = $w[$c];
//            echo strlen($dat[$col]).'<br>';
               
            }
        }
        $val_Max_h = max($t);
//          echo_pre($val_Max_h);
        $totalwidth = array_sum($w);
//        echo_pre($w);
        $rest = $width - $totalwidth;
        $val_Max = max($w);
        $ind = array_search($val_Max, $w);
        $w[$ind] = $w[$ind] + $rest; 
//        echo $width - $totalwidth.'<br>';
//        echo max($w);
//        foreach ($w as $hh){
////            echo $hh.'<br>';
//             $wis = $wis + $hh;
//        }
        
//        echo_pre(($width - $wis)/$total);
        
//    echo_pre($w);
        return($w);
    }
//Este script es para realizar el multiceldas en tablas. No es echo por mi, pero me sirve para lo que se necesita y se adapta
    //al codigo modificando algunas cosas.
    var $widths;
    var $aligns;

    function SetWidths($w) {
        //Set the array of column widths
        $this->widths = $w;
    }

    function SetAligns($a) {
        //Set the array of column alignments
        $this->aligns = $a;
    }

    function Row($data) {
        //Calculate the height of the row
        $nb = 0;
//    die_pre($data);
        for ($i = 0; $i < count($data); $i++){
            $nb = max($nb, $this->NbLines($this->widths[$i], $data[$i]));
        }
        $h = 6 * $nb;
        //Issue a page break first if needed
        $this->CheckPageBreak($h);
        //Draw the cells of the row
        for ($i = 0; $i < count($data); $i++) {
            $w = $this->widths[$i];
            $a = isset($this->aligns[$i]) ? $this->aligns[$i] : 'C';
            //Save the current position
            $x = $this->GetX();
            $y = $this->GetY();
            //Draw the border
            $this->SetLineWidth(0.0);
            if ($this->borde){
                $this->Rect($x, $y, $w, 0);
            }
            else {
                $this->Rect($x, $y, $w, $h);
            }
            //Print the text
            $this->MultiCell($w, 6, iconv('UTF-8', 'windows-1252 //IGNORE',$data[$i]), 0, $a);
            //Put the position to the right of the cell
            $this->SetXY($x + $w, $y);
        }
        //Go to the next line
        $this->Ln($h);
    }

    function CheckPageBreak($h) {
        //If the height h would cause an overflow, add a new page immediately
        if ($this->GetY() + $h > $this->PageBreakTrigger)
            $this->AddPage($this->CurOrientation);
    }

    function NbLines($w, $txt) {
        //Computes the number of lines a MultiCell of width w will take
        $cw = &$this->CurrentFont['cw'];
        if ($w == 0)
            $w = $this->w - $this->rMargin - $this->x;
        $wmax = ($w - 2 * $this->cMargin) * 1000 / $this->FontSize;
        $s = str_replace("\r", '', $txt);
        $nb = strlen($s);
        if ($nb > 0 and $s[$nb - 1] == "\n")
            $nb--;
        $sep = -1;
        $i = 0;
        $j = 0;
        $l = 0;
        $nl = 1;
        while ($i < $nb) {
            $c = $s[$i];
            if ($c == "\n") {
                $i++;
                $sep = -1;
                $j = $i;
                $l = 0;
                $nl++;
                continue;
            }
            if ($c == ' ')
                $sep = $i;
            $l+=$cw[$c];
            if ($l > $wmax) {
                if ($sep == -1) {
                    if ($i == $j)
                        $i++;
                } else
                    $i = $sep + 1;
                $sep = -1;
                $j = $i;
                $l = 0;
                $nl++;
            } else
                $i++;
        }
        return $nl;
    }
    
    function sumary($text){
//        die_pre($text);
        if($this->es_bidimensional($text)){
            foreach ($text as $z => $t) {
                foreach ($t as $i => $txt) {
                    $w = $this->w - $this->lMargin - $this->rMargin;
                    if ($i == 'Titulo') {
                        // Arial 10
                        $this->SetFont('Arial', 'B', 10);
                        // Título
                        $this->Cell($w, 6, utf8_decode($txt), 0, 0, $text[$z]['a']);
                        if (array_key_exists('Subtitulo', $text[$z])) {
                            $this->SetFont('', 'I', 8);
                            $this->SetX(($this->lMargin));
                            $this->Cell($w, 14, utf8_decode($text[$z]['Subtitulo']), 0, 0, $text[$z]['a']);
                            $this->Ln(12);
                        } else {
                            $this->Ln(12);
                        }
                    } else {
                        if ($i == 'Label') {
                            $this->SetFont('', 'BI', 10);
                            $x = $this->GetX(); // Para mantener posiciones actuales y lograr imprimir el texto al lado de la etiqueta
                            $y = $this->GetY();
                            $this->MultiCell(0, 5, utf8_decode($txt));
                            $tot = $this->GetStringWidth($txt) + 1; //Me guarda el total de lo que acabo de escribir mas un espacio
                            $this->SetXY($x + $tot, $y); //Se ubica en las coordenadas totalizando donde quedo en x mas lo escrito
                            if (array_key_exists('Text', $text[$z])) {
                                $this->SetFont('', '', 10);
                                //Escribir lo que se necesita
                                $this->MultiCell(0, 5, utf8_decode($text[$z]['Text']));
                            }
                        }
                    }
                }
            }
        }else{
            if (is_array($text)){
                foreach ($text as $txt){
                    $this->MultiCell(0, 5, utf8_decode($txt));
                }
            }else{
                $this->SetFont('', 'B', 14);
                $this->SetFillColor(200,220,255);
                $this->SetTextColor(220,50,50);
                $this->Cell(0, 5, 'Error... La variable no es un array',0,1,'C',true);
                $this->SetTextColor('');
            }
        }
        // Salto de línea
        $this->Ln();
    }
    //Funcion que recorre el array para saber si es array y si es bidimensional
    function es_bidimensional($array) { 
        if (!is_array($array)){
            return false;
        }
        foreach ($array as $arreglo) { 
            if (!is_array($arreglo)) {
                return false;
            }
            foreach ($arreglo as $arre) { 
                if (is_array($arre)){ 
                    return false;
                }
            }	 
  	} 
        return true;
    }
}

