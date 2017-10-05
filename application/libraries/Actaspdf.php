<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Actaspdf extends TCPDF
{
	//Page header
    public function Header()
    {
        // Logo
        // $image_file = base_url().'assets/img/facyt-mediano.gif';
        // $this->Image($image_file, 10, 10, 15, '', 'GIF', '', 'T', false, 300, '', false, false, 0, false, false, false);
        // Set font
        // $this->SetFont('helvetica', 'B', 20);
        // Title
        // $this->Cell(0, 15, '<< TCPDF Example 003 >>', 0, false, 'C', 0, '', 0, false, 'M', 'M');

        $this->Image('assets/img/LOGO-UC.png', 37, 12, 20,27);
        //Imagen derecha
        $this->Image('assets/img/facyt-mediano.gif', 160, 12, 20, 22);
        $this->SetFont('helvetica','B', 8);
        //Texto de Título
        // $this->Ln(1);
        $this->Cell(18);
        $this->Cell(0,24,'Universidad de Carabobo',0,'L');
        $this->Ln(4);
        $this->Cell(14);
        $this->Cell(0,24,'Facultad Experimental de Ciencias y Tecnologia',0,'L');
        
    }

    // Page footer
    public function Footer()
    {
        // Position at 15 mm from bottom
        // $this->SetY(-15);
        // Set font
        // $this->SetFont('helvetica', 'I', 8);
        // Page number
        // $this->Cell(0, 10, 'Page '.$this->getAliasNumPage().'/'.$this->getAliasNbPages(), 0, false, 'C', 0, '', 0, false, 'T', 'M');
        $this->SetY(-35);
        $this->SetFont('helvetica','B',9);
        // $this->Cell(0,10,utf8_decode('Universidad de Carabobo, Facultad Experimental de Ciencias y Tecnología, Lado "B"').$this->PageNo().'/{nb}',0,0,'C');
        $this->Cell(0,10,'Universidad de Carabobo, Facultad Experimental de Ciencias y Tecnología,',0,0,'C');
        // $this->Ln();
        $this->SetY(-30);
        // $this->Cell(0,10,utf8_decode('Lado "B" Campus Universitario - Bárbula. Teléfonos 6004000- Extensión 315067 - 315070 ' ) ,0,0,'C');
        $this->Cell(0,10,'Lado "B" Campus Universitario - Bárbula. Teléfonos 6004000- Extensión 315067 - 315070 ',0,0,'C');
        // $this->Ln();
        $this->SetY(-25);
        $this->Cell(0,10,'E-mail: deccytuc@uc.edu.ve, Apartado postal 2001, Valencia - Carabobo',0,0,'C');
        // $this->Ln();
        $this->SetY(-18);
        $this->SetFont('helvetica','I',7);
        date_default_timezone_set('America/Caracas');
        $this->Cell(0,10,utf8_decode('- - - -   Impreso el ') . date("d/m/y") . ' a las ' . date('h:i:s',time()+1800) . ' hora del servidor   - - - -',0,0,'C');
        $this->Cell(0, 10, 'página: '.$this->getAliasNumPage().'/'.$this->getAliasNbPages(), 0, false, 'C', 0, '', 0, false, 'T', 'M');
    }
}