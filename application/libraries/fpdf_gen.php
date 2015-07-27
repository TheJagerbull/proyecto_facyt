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

}