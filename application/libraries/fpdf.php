<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
    // Incluimos el archivo fpdf
    require_once APPPATH."/third_party/fpdf/fpdf.php";
 
    //Extendemos la clase Pdf de la clase fpdf para que herede todas sus variables y funciones
    class Pdf extends FPDF {
        public function __construct() {
            parent::__construct();
        }
        // El encabezado del PDF
        public function Header(){
//            $this->Image('assets/img/LOGO-UC.png',10,8,22);
//            $this->SetFont('Arial','B',13);
//            $this->Cell(30);
//            $this->Cell(120,10,'ESCUELA X',0,0,'C');
//            $this->Ln('5');
//            $this->SetFont('Arial','B',8);
//            $this->Cell(30);
//            $this->Cell(120,10,'INFORMACION DE CONTACTO',0,0,'C');
            //Imagen izquierda
            
            $this->Image('assets/img/facyt-mediano.gif', 10, 8, 12, 13);
            //Imagen derecha
            $this->Image('assets/img/LOGO-UC.png', 190, 8, 10,13);
            $this->SetFont('Arial','B', 7);
            //Texto de Título
            $this->Cell(70);
            $this->Cell(30,10,'Universidad de Carabobo',0,'C');
            $this->Ln(2);
            $this->Cell(55);
            $this->Cell(30,10,'Facultad Experimental de Ciencias y Tecnologia',0,'C');
            $this->Ln(2);
            $this->Cell(70);
            $this->Cell(30,10,'SiSAI Decanato',0,'C');
//            $this->MultiCell(65,5,utf8_decode('Universidad de Carabobo Facultad Experimental de Ciencias y Tecnologia SiSAI Decanato'),0,'C');
//            $this->SetXY(60, 25);
//            $this->MultiCell(65, 5, utf8_decode('Universidad de Carabobo Facultad Experimental de Ciencias y Tecnologia SiSAI Decanato'), 0, 'C');
            $this->Ln(20);
            
           
       }
       // El pie del pdf
       public function Footer(){
           $this->SetY(-15);
           $this->SetFont('Arial','I',8);
           $this->Cell(0,10,'Page '.$this->PageNo().'/{nb}',0,0,'C');
      }
    }
?>
