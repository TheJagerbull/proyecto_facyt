<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Actaspdf extends TCPDF
{
	//Page header
    public function Header()
    {
        //file properties
        // Logo
        // $image_file = base_url().'assets/img/facyt-mediano.gif';
        // $this->Image($image_file, 10, 10, 15, '', 'GIF', '', 'T', false, 300, '', false, false, 0, false, false, false);
        // Set font
        // $this->SetFont('helvetica', 'B', 20);
        // Title
        // $this->Cell(0, 15, '<< TCPDF Example 003 >>', 0, false, 'C', 0, '', 0, false, 'M', 'M');
        // $this->setBreakMargin(30);
        $this->SetTopMargin(60);
        // $this->SetBottomMargin(31);
        // get the current page break margin
        $bMargin = $this->getBreakMargin();
        // get current auto-page-break mode
        $auto_page_break = $this->AutoPageBreak;
        // disable auto-page-break
        $this->SetAutoPageBreak(false, 0);
        $UClogo = 'assets/img/LOGO-UC.png';
        $FACYTlogo = 'assets/img/facyt-mediano.gif';

        // $this->Image($UClogo, 37, 12, 20,27);
        $this->Image($UClogo, 37, 12, 20, 27, 'png', '', 'T', false, 300, '', false, false, 0, false, false, false);
        //Imagen derecha
        // $this->Image($FACYTlogo, 160, 12, 20, 22);
        $this->Image($FACYTlogo, 160, 12, 20, 22, 'gif', '', 'T', false, 300, '', false, false, 0, false, false, false);
        $this->SetFont('helvetica','B', 8);
        $this->Cell(0, 29, '', 0, true, 'L', 0, '', 0, false, 'T', 'T');
        $this->Cell(0, 0, '     Universidad de Carabobo', 0, true, 'L', 0, '', 0, false, 'T', 'T');
        $this->Cell(0, 0, 'Facultad Experimental de Ciencias y Tecnología', 0, true, 'L', 0, '', 0, false, 'T', 'T');
        // $this->Image('assets/img/alm/left-arrow.png', 183, 46.5, 28, 16);
        $this->Image('assets/img/alm/left-arrow.png', 183, 46.5, 28, 16, 'png', '', 'T', false, 300, '', false, false, 0, false, false, false);
        $this->SetFont('helvetica','B', 8);
        $this->SetTextColor(255, 255, 255);
        $this->Cell(0, 15, '     '.$this->getAliasNumPage().' / '.$this->getAliasNbPages(), 0, false, 'C', 0, '', 0, false, 'T', 'M');
        //Texto de Título
        // $this->Ln(1);
        // $this->Cell(18);
        // $this->Cell(0,24,'Universidad de Carabobo',0,'L');
        // $this->Cell(18,0,'Universidad de Carabobo',0,'L');
        // $this->Ln(4);
        // $this->Cell(14);
        // $this->Cell(0,24,'Facultad Experimental de Ciencias y Tecnología',0,'L');
        // $this->Cell(0,0,'Facultad Experimental de Ciencias y Tecnología',0,'L');
        
        // restore auto-page-break status
        $this->SetAutoPageBreak($auto_page_break, $bMargin);
        // set the starting point for the page content
        $this->setPageMark();
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
        $this->Cell(0,10,'Universidad de Carabobo, Facultad Experimental de Ciencias y Tecnología,',0,0,'C', 0, '', 0, false, 'T', 'M');
        // $this->Cell(0,10,'Universidad de Carabobo, Facultad Experimental de Ciencias y Tecnología,',0,0,'C');
        // $this->Ln();
        $this->SetY(-30);
        // $this->Cell(0,10,utf8_decode('Lado "B" Campus Universitario - Bárbula. Teléfonos 6004000- Extensión 315067 - 315070 ' ) ,0,0,'C');
        $this->Cell(0,10,'Lado "B" Campus Universitario - Bárbula. Teléfonos 6004000- Extensión 315067 - 315070 ',0,0,'C', 0, '', 0, false, 'T', 'M');
        // $this->Cell(0,10,'Lado "B" Campus Universitario - Bárbula. Teléfonos 6004000- Extensión 315067 - 315070 ',0,0,'C');
        // $this->Ln();
        $this->SetY(-25);
        $this->Cell(0,10,'E-mail: deccytuc@uc.edu.ve, Apartado postal 2001, Valencia - Carabobo',0,0,'C', 0, '', 0, false, 'T', 'M');
        // $this->Cell(0,10,'E-mail: deccytuc@uc.edu.ve, Apartado postal 2001, Valencia - Carabobo',0,0,'C');
        // $this->Ln();
        $this->SetY(-18);
        $this->SetFont('helvetica','I',7);
        date_default_timezone_set('America/Caracas');
        $this->Cell(0,10,utf8_decode('- - - -   Impreso el ') . date("d/m/y") . ' a las ' . date('h:i:s',time()+1800) . ' hora del servidor   - - - -',0,0,'C', 0, '', 0, false, 'T', 'M');
        // $this->Cell(0,10,utf8_decode('- - - -   Impreso el ') . date("d/m/y") . ' a las ' . date('h:i:s',time()+1800) . ' hora del servidor   - - - -',0,0,'C');
        // $this->Cell(0, 10, 'página: '.$this->getAliasNumPage().'/'.$this->getAliasNbPages(), 0, false, 'C', 0, '', 0, false, 'T', 'M');
    }

    public function table($array="")
    {
        /*array
            * pos
              *  columna => data
        */
        $header='';
        foreach ($array[0] as $column => $data)
        {
            $header.='<th>';
            $header.='<strong>'.$column.'</strong>';
            $header.='</th>';    
        }
        // echo $header;
        $table = '<br><br><table style="width:98%" border="1" cellpadding="2" cellspacing="2">';
        $table.= '<thead><tr>';
        $table.= $header;
        $table.= '</tr></thead><tbody>';
        foreach ($array as $key => $value)
        {
            $table.='<tr>';
            foreach ($value as $column => $data)
            {
                
                $table.='<td>';
                $table.=$data;
                $table.='</td>';
                // if($key==0)
                // {
                //     foreach ($value as $columns => $dirt)
                //     {
                //         $table.='<th>';
                //         $table.=$columns;
                //         $table.='</th>';
                //     }
                //     $table.='</tr>';
                //     $table.='</thead>';
                //     $table.='<tbody>';
                //     $table.='<tr>';
                // }
                // $table.='<td>';
                // $table.= $data;
                // $table.='</td>';
            }
            $table.='</tr>';
        }
        $table.='</tbody></table>';

        $this->writeHTML($table, true, false, false, false, '');
        // $this->writeHTML($table, true, false, false, false, '');
        // die_pre($table);
    }
    public function InventoryOfficials($array='')
    {
        $table = 'Es todo, se leyó, conforme firman.-<br><br><br><br><br><br><br><table>';
        $table.= '<tbody>';
        $table.= '<tr>';
        $table.= '<td>
                    Elaborado por:<br>'.$array['authors']['jefe_alm'].'<br>Jefe de Almacen.
                    </td>';
        $table.= '<td>
                    Revisado por:<br>'.$array['authors']['jefe_comp'].'<br>Jefe de Compras.
                    </td>';
        $table.= '<td>
                    Aprobado por:<br>'.$array['authors']['coord_adm'].'<br>Coordinadora Administrativa.
                    </td>';
        $table.= '</tr>';
        $table.= '</tbody>';
        $table .= '</table>';

        $this->SetFont('helvetica', 'B', 10);
        $this->writeHTML($table, true, false, false, false, '');

    }
}