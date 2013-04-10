<?php

class TesterFonts
{	
	var $pdf;
	
	public function TesterFonts(  )
	{
		$this->pdf = new FPDF('P','mm','Letter');
		$this->pdf->AddFont("helvetica_bold", "", "../fonts/helvetica-bold/fpdf/3c41c8e6600e41512cbd6a118d2bdf41_helvetica_bold.php");
		$this->pdf->AddFont("helvetica", "", "../fonts/helvetica/fpdf/25e75292757c3eb4bba8a3ddd4e8fe3f_helvetica_lt.php");
		//$this->pdf->AddFont("arial_new", "", "../fonts/helvetica/fpdf/5c7883f46367d27bdea7be339987594e_arial.php");
		//$this->pdf->AddFont("arial_bold", "", "../fonts/helvetica/fpdf/25e75292757c3eb4bba8a3ddd4e8fe3f_helvetica_lt.php");
		$this->pdf->AddFont("newFont","",'../fonts/micr/fpdf/f30e76a7a57ca16aaf2424921d10f4da_micr___.php');
		$this->pdf->SetDisplayMode('real','default');//with this i can not do fill\
		$this->pdf->SetAutoPageBreak(false);
		$this->pdf->AddPage();
		
		//Set font
		$this->pdf->SetFont("helvetica_bold", "", 12);
		//Ship by field
		$this->pdf->SetXY(PDFHelper::pixels_to_MM(100), PDFHelper::pixels_to_MM(100));
		$this->pdf->MultiCell(PDFHelper::pixels_to_MM(180),PDFHelper::points_to_MM(12),iconv("UTF-8", "ISO-8859-1", "èé^çà èé^çà èé^çà èé^çà !@#)#&*!#@&*^#!&^^^^)!@#^&*££££&@#^£££"),1,"L");
		
		$this->pdf->SetFont("helvetica", "", 12);
		//Ship by field
		$this->pdf->SetXY(PDFHelper::pixels_to_MM(100), PDFHelper::pixels_to_MM(200));
		$this->pdf->MultiCell(PDFHelper::pixels_to_MM(180),PDFHelper::points_to_MM(12),iconv("UTF-8", "ISO-8859-1", "èé^çà èé^çà èé^çà èé^çà !@#)#&*!#@&*^#!&^^^^)!@#^&*&@#^£££££"),1,"L");
		
		
		$this->pdf->Output("font-tester.pdf", "");
	}
}
	require_once("pdf-tools/fpdf.php");
	require_once("pdf-tools/pdf-helper.php");
$testerFonts = new TesterFonts();

?>