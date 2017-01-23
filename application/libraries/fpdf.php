<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
    // Incluimos el archivo fpdf
    require_once APPPATH."/third_party/fpdf/fpdf.php";
 
    //Extendemos la clase Pdf de la clase fpdf para que herede todas sus variables y funciones
    class Pdf extends FPDF {
        public function __construct() {
            parent::__construct();
        }
        var $ProcessingTable=false;
        var $cols = array();
        var $tmp = array();
        var $TableX;
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
            $this->Ln(20);
            if($this->ProcessingTable){
                $this->TableHeader();
            }
           
       }
       // El Footer del pdf
        public function Footer(){
           $this->SetY(-15);
           $this->SetFont('Arial','I',7);
           $this->Cell(0,10,utf8_decode('Página ').$this->PageNo().'/{nb}',0,0,'C');
        }
        
        function CalcWidths($width, $align) {
            //Compute the widths of the columns
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
            //Compute the abscissa of the table
            if ($align == 'C'){
                $this->TableX = max(($this->w - $TableWidth) / 2, 0);
            }elseif ($align == 'R'){
                $this->TableX = max($this->w - $this->rMargin - $TableWidth, 0);
            }else{
                $this->TableX = $this->lMargin;
            }
        }

    function AddCol($field = -1, $width = -1, $caption = '', $align = 'L') {
            //Add a column to the table
            if ($field == -1)
                $field = count($this->cols);
            $this->cols[] = array('f' => $field, 'c' => $caption, 'w' => $width, 'a' => $align);
        }

    // Tabla
      function tabla($header, $data, $colum, $tipo = '') {
        // Colores, ancho de línea y fuente en negrita
        $this->SetFont('', '', 7);
        // Cabecera
//        $w = $this->make_size_cel($data, $colum, $header);
//        $this->tmp = $w;
//        echo_pre($w);
//        $this->SetWidths($w);
//        $this->cols = $header;
        //Add all columns if none was specified
        if(count($this->cols)==0)
        {
            $number_col=count($header);
            for($i=0;$i<$number_col;$i++){
                $this->AddCol();
            }
        }
        //Retrieve column names when not specified
        foreach($this->cols as $i=>$col)
        {
            if($col['c']=='')
            {
                $this->cols[$i]['c']= $header[$i];
            }
        }
        $width = $this->w-$this->lMargin-$this->rMargin;
        $align = 'C';
        $this->CalcWidths($width,$align);
//        die_pre($this->cols);
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
//    if($data!= ''){
        foreach ($data as $key => $value) {
            foreach ($colum as $k => $val) {
              $nuevo[$k] = utf8_decode($value[$val]);
              
//              echo $value[$val].'<br>';
//            $this->Cell($this->cols[$k]['w'],6,utf8_decode($value[$val]),'1',0,'C');
//            if ($val == 'descripcion'){
//                echo_pre('si'.$val);
//                $this->MultiCell($w[$k],6,utf8_decode($value[$val]),'1',0,'C');
//            }
//              echo $this->cols[$k]['w'].'<br>';              
            }
//            $this->Ln();
            $this->ProcessingTable = true;
            $this->Row($nuevo);
            $this->ProcessingTable = false;
        }
    }

    function TableHeader(){
        $this->SetFillColor(190);
//        for($i=0;$i<count($this->cols);$i++){
//            $this->Cell($this->tmp[$i],7, utf8_decode ($this->cols[$i]),1,0,'C',true);   
//        }
        foreach($this->cols as $col){
            $this->Cell($col['w'],6,utf8_decode($col['c']),1,0,'C',true);
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
//                $h = $this->GetStringWidth($header[$c]);
//                $t = $this->GetStringWidth($dat[$col]);
                $h = ($width ) / $total;
                $t = ($width ) / $total;
//            echo_pre($h);
//            if($col == 'descripcion'){
//                $t = $t + 40;
//                $h = $h + 40;
//            }
//            echo $h.' '.$t.'<br>';
                if ($t > $w[$c]) {
                    if ($h > $t) {
                        $w[$c] = $h;
//                        $total = $total + $w[$c];
                    } else {
                        $w[$c] = $t;
                       
                    }
                    
                }
//            echo strlen($dat[$col]).'<br>';
            }
        }
        foreach ($w as $hh){
//            echo $hh.'<br>';
             $total = $total + $hh;
        }
//        echo_pre($total);
        
//    echo_pre($w);
        return($w);
    }

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
        for ($i = 0; $i < count($data); $i++)
            $nb = max($nb, $this->NbLines($this->widths[$i], $data[$i]));
        $h = 5 * $nb;
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
            $this->Rect($x, $y, $w, $h);
            //Print the text
            $this->MultiCell($w, 5, $data[$i], 0, $a);
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

}

