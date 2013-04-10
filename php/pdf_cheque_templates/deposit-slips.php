<?php
	//////////////////////////////////////////////////////////////////
	//////BlankA4Cheque
	//////////////////////////////////////////////////////////////////
	class DepositSlips
	{
		var $pdf,
			$fileName = "deposit_slips.pdf",
			$outPutTOSErver=NULL,
			$iMReorderForm = false,
			$iMForCheque = false;
		var $chequeData;
		var $border = 0;
		var $before_testing_folder = "";
		private function TextForNumber()
		{
			return PDFHelper::get_branch_transit_Number($this->chequeData->brunchNumber(),$this->chequeData->transitNumber()).
												  " ".$this->chequeData->accountNumber__newFontWriteSTR()." ".$this->chequeData->currencyNumber45();
		}
		
		public function DepositSlips( $chequeData____=NULL, $before_testing_folder="" )
		{
			$this->before_testing_folder = $before_testing_folder;
			$this->chequeData = $chequeData____;
			
			//print "[".$this->chequeData->currencyNumber45()."]";
			
			//$this->pdf = new FPDF('L','mm','Letter');//11x8.5 inches
			$this->pdf=new FPDF('P','mm',array(177.8,177.8));
			$this->pdf->AddFont("helvetica_bold", "", $before_testing_folder."../fonts/helvetica-bold/fpdf/3c41c8e6600e41512cbd6a118d2bdf41_helvetica_bold.php");
			$this->pdf->AddFont("helvetica", "", $before_testing_folder."../fonts/helvetica/fpdf/25e75292757c3eb4bba8a3ddd4e8fe3f_helvetica_lt.php");
			$this->pdf->AddFont("newFont","",$before_testing_folder.'../fonts/micr/fpdf/f30e76a7a57ca16aaf2424921d10f4da_micr___.php');
			$this->pdf->SetDisplayMode(real,'default');//with this i can not do fill\
			$this->pdf->SetAutoPageBreak(false);
			$this->pdf->AddPage();
			
			$this->addBG();
			$this->addCompnayName();
			$this->addBankName();
			$this->addAcountNumbers();
		}
		private function addBG()
		{
			$this->pdf->Image($this->before_testing_folder."deposit_slip.jpg", 0, 0, 177.8);
		}
		private function addCompnayName()
		{
			$this->pdf->SetXY(22, 9.2);
			$this->pdf->SetFont("helvetica_bold", "", 9.5);
			$visinaTekst = $this->pdf->MultiCell(70,3.5,$this->chequeData->CINACompanyName()."\n".$this->chequeData->CINACompanySecondName(),$this->border,"L");
			$visinaTekst*=3.5;
			$this->pdf->SetXY(22, 9.2+$visinaTekst);
			$this->pdf->SetFont("newFont", "", 8);
			$this->pdf->MultiCell(75,4,$this->TextForNumber(),$this->border,"L");
			
			$this->pdf->SetXY(100, 29);
			$this->pdf->SetFont("helvetica_bold", "", 9.5);
			$visinaTekst = $this->pdf->MultiCell(70,3.5,$this->chequeData->CINACompanyName()."\n".$this->chequeData->CINACompanySecondName(),$this->border,"L");
			$visinaTekst*=3.5;
			$this->pdf->SetXY(100, 29+$visinaTekst);
			$this->pdf->SetFont("newFont", "", 8);
			$this->pdf->MultiCell(75,4,$this->TextForNumber(),$this->border,"L");
		}
		private function addBankName()
		{
			$this->pdf->SetXY(100, 9.2);
			$this->pdf->SetFont("helvetica_bold", "", 10);
			$this->pdf->MultiCell(70,4,$this->chequeData->compInfoBankName(),$this->border,"L");
			
			$this->pdf->SetXY(100, 13);
			$this->pdf->SetFont("helvetica_bold", "", 7);
			$this->pdf->MultiCell(70,2.5,$this->chequeData->compInfoBankAddress1()."\n".$this->chequeData->compInfoBankAddress2()."\n".$this->chequeData->compInfoBankAddress3()."\n".$this->chequeData->compInfoBankAddress4()."",$this->border,"L");
		}
		private function addAcountNumbers()
		{
			/*
			$textForNumber = PDFHelper::get_startAtN($this->chequeData->startAtNumber()).
			
												  "   ".PDFHelper::get_branch_transit_Number($this->chequeData->brunchNumber(),$this->chequeData->transitNumber()).
												  "   ".$this->chequeData->accountNumber__newFontWriteSTR();*/
			$textForNumber = PDFHelper::get_branch_transit_Number($this->chequeData->brunchNumber(),$this->chequeData->transitNumber()).
												  " ".$this->chequeData->accountNumber__newFontWriteSTR()." ".$this->chequeData->currencyNumber45();
			$totalHeight = strlen( $textForNumber )*2.4;
			$this->pdf->SetFont("newFont", "", 10);
			$this->pdf->TextWithRotation(170, $totalHeight+(177.8-$totalHeight)/2, $textForNumber, 90, 0);
		}
		////////////////////////////////////////////////////////////////////////////////////////
		public function PDFContent()
		{
			if($this->outPutTOSErver == NULL)
			{
				$this->outPutTOSErver = $this->pdf->Output($this->fileName, "S");
			}
			return $this->outPutTOSErver;
		}
		public function saveToLocal($PDFName)
		{
			$this->pdf->Output($PDFName, "");
		}
	}
	/*	 
	if(!class_exists("XMLParser")){require_once("../tools.php");}	 
	require_once("../pdf-tools/fpdf.php");
	require_once("../pdf-tools/pdf-helper.php");
	require_once("../products_moderator.php");
	//require_once("mail_message_template.php");
	//require_once("backupmessage.php");
	XMLParser::ADD_ORDER_XML_TO_POST( "../orders/xml/T_L5872.xml" );
	$objCheque = new Cheque( $_POST["chequeType"] );
	$objChequeData = new ChequeData( $objCheque );
	$DepositSlips = new DepositSlips( $objChequeData, "../" );
	$DepositSlips->saveToLocal( "DepositSlips-testing.pdf" );
	 */
	

?>