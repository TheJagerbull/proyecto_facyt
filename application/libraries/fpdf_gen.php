<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
	
	// Se indica la ruta del archivo fpdf-1.7.php
	require_once APPPATH.'third_party/fpdf/fpdf-1.7.php';

class Fpdf_gen extends FPDF
{

		
	public function __construct() 
	{   
		$pdf = new FPDF();
		$pdf->AddPage();
		
		$CI =& get_instance();
		$CI->fpdf = $pdf;

	}
	function Header()
	{
		$this->Ln(20);
        $this->SetFont('Courier','I',8);
        $this->Cell('','','Universidad de Carabobo','','','L');
        $this->Ln(2);
        $this->Cell('','',utf8_decode('Facultad Experimental de Ciencias y Tecnología'),'','','L');
        $this->Ln(15);
        $this->SetFont('Courier','B',12);
        $this->Ln(5);        
        $this->Cell('','','DETALLE DE LA SOLICITUD','','','C');
	}
	// Pie de página
	function Footer()
	{
    	// Posición: a 1,5 cm del final
    	$this->SetY(-15);
    	// Arial italic 8
    	$this->SetFont('Arial','I',8);
    	// Número de página
    	$this->Cell(0,10,'Page '.$this->PageNo().'/{nb}',0,0,'C');
	}
	    

}