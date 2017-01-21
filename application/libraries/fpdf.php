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
      
      // Tabla
      function tabla($header, $data = '', $colum = '', $tipo = '') {
        // Colores, ancho de línea y fuente en negrita
        $this->SetFont('', '', 7);
        // Cabecera
        $w = $this->make_size_cel($data, $colum, $header);
        $this->tmp = $w;
        $this->SetWidths($w);
        $this->cols = $header;
        $this->TableHeader();

        // Restauración de colores y fuentes
        $this->SetFillColor(224, 235, 255);
        $this->SetTextColor(0);
        $this->SetFont('');
        // Datos
//    $fill = false;
//    if($data!= ''){
        foreach ($data as $key => $value) {
            foreach ($colum as $k => $val) {
              $nuevo[$k] = utf8_decode($value[$val]);
//            $this->Cell($w[$k],6,utf8_decode($value[$val]),'1',0,'C');
//            if ($val == 'descripcion'){
//                echo_pre('si'.$val);
//                $this->MultiCell($w[$k],6,utf8_decode($value[$val]),'1',0,'C');
//            }
            }
            $this->ProcessingTable = true;
            $this->Row($nuevo);
            $this->ProcessingTable = false;
        }
    }

    function TableHeader(){
        $this->SetFillColor(190);
        for($i=0;$i<count($this->cols);$i++){
            $this->Cell($this->tmp[$i],7, utf8_decode ($this->cols[$i]),1,0,'C',true);   
        }
        $this->Ln();
    }
    
    function make_size_cel($data, $columns, $header) {
//    echo_pre($columns);
        $total = count($columns);
        $w = $columns;
        $z = 0;
        foreach ($data as $d => $dat) {

            foreach ($columns as $c => $col) {
//            $t = mb_strlen($dat[$col], 'utf8');
//            $h = mb_strlen($header[$c], 'utf8');
                $pag = $this->GetPageWidth();
//            echo_pre($pag);
                $h = $this->GetStringWidth($header[$c]);
                $t = $this->GetStringWidth($dat[$col]);
//            echo_pre($h);
//            if($col == 'descripcion'){
//                $t = $t + 40;
//                $h = $h + 40;
//            }
//            echo $h.' '.$t.'<br>';
                if ($t > $w[$c]) {
                    if ($h > $t) {
                        $w[$c] = $h + 4;
                    } else {
                        $w[$c] = $t + 4;
                    }
                }
//            echo strlen($dat[$col]).'<br>';
            }
        }
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

