<?php
ini_set('display_errors',1); 
error_reporting(E_ALL);
 
$ROOT = $_SERVER ["DOCUMENT_ROOT"];

require_once($ROOT . '/fpdf17/fpdf.php');
require_once($ROOT . '/fpdi152/fpdi.php');

// initiate FPDI
$pdf = new FPDI();

$pdf->AddFont('ocr','','OCR-a___.php');

$filename = "data";
$row = 0;
$marginLeft = 0;
$marginTop = 0;
$width = 210;
$fontSize = 8;
$fontName = "Arial";
if (($handle = fopen($filename . ".csv", "r")) !== FALSE) {

    while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {    
   	$num = count($data);  //echo "<p> $num fields in line $row: <br /></p>\n";
        $row++;
	if($row == 1)
		continue;

	if ($row == 50)
		break;

	$pdf->setSourceFile('test.pdf');	// set the sourcefile	
        $pdf->SetTextColor(0,0,0);            

	$col1 = $col2 = $col3 = "";

        for ($c=0; $c < $num; $c++) 
            {   
	    	if ($c==0){  
			$col1 = $data[$c];
		}elseif($c==1){
			$col2 = $data[$c];
		}elseif($c==2){
			$col3 = $data[$c];
		}

 		//$pdf->SetFont('ocr', '', 16);                    
            }

	//************	
	//First Page
	//************
	$pdf->AddPage('P', array(210, 297));	    
        $tplIdx = $pdf->importPage(1);
        $pdf->useTemplate($tplIdx, $marginLeft, $marginTop, $width);   // use the imported page and place it at point 10,10 with a width of 100 mm

	// Placement of column on data page1 
    	$pdf->SetFont($fontName, '', $fontSize);
        $pdf->SetXY(180, 43);
        $pdf->Write(0, $col1);

	//************       
	//Second Page
	//************
        $pdf->AddPage('P', array(210, 297));
        $tplIdx = $pdf->importPage(2);
        $pdf->useTemplate($tplIdx, $marginLeft, $marginTop, $width);

    	//$pdf->SetFont('Arial', '', 10);
        $pdf->SetXY(173, 43.7);
        $pdf->Write(0, $col1);

	$pdf->SetXY(31, 65.5);
        $pdf->Write(0, $col2);
	
        $pdf->SetXY(31, 96.6);
        $pdf->Write(0, $col3);

	//************   	    
	//Third Page 
	//************
        $pdf->AddPage('P', array(210, 297));
        $tplIdx = $pdf->importPage(3);
        $pdf->useTemplate($tplIdx, $marginLeft, $marginTop, $width);
        
	//$pdf->SetXY(32, 70);
        //$pdf->Write(0, $col3);
    }
    fclose($handle);
}

$pdf->Output($filename . '.pdf', 'D');
