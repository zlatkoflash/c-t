<?php
	//////////////////////////////////////////////////////////////////
	//////BlankA4Cheque
	//////////////////////////////////////////////////////////////////
	class PA_Debit
	{
		var $pdf,
			$fileName = "deposit_slips.pdf",
			$outPutTOSErver=NULL,
			$iMReorderForm = false,
			$iMForCheque = false;
		var $chequeData;
		var $border = 0;
		private function TextForNumber()
		{
			return PDFHelper::get_branch_transit_Number($this->chequeData->brunchNumber(),$this->chequeData->transitNumber()).
												  " ".$this->chequeData->accountNumber__newFontWriteSTR();
		}
		
		public function PA_Debit( $chequeData____ )
		{
			$this->chequeData = $chequeData____;
			
			//$this->pdf = new FPDF('L','mm','Letter');//11x8.5 inches
			$this->pdf=new FPDF('P','mm',array(215.9,279.4));
			$this->pdf->AddFont("helvetica_bold", "", "../fonts/helvetica-bold/fpdf/3c41c8e6600e41512cbd6a118d2bdf41_helvetica_bold.php");
			$this->pdf->AddFont("helvetica", "", "../fonts/helvetica/fpdf/25e75292757c3eb4bba8a3ddd4e8fe3f_helvetica_lt.php");
			$this->pdf->AddFont("newFont","",'../fonts/micr/fpdf/f30e76a7a57ca16aaf2424921d10f4da_micr___.php');
			$this->pdf->AddFont("scriptFont","",'../fonts/typesetit_great-vibes/fpdf/407ce6a4562729cd8c1f777bea67dab8_greatvibes-regular.php');
			$this->pdf->SetDisplayMode(real,'default');//with this i can not do fill\
			$this->pdf->SetAutoPageBreak(false);
			$this->pdf->AddPage();
			
			$this->addBG();
			$this->drawTheTexts();
		}
		private function addBG()
		{
			$this->pdf->Image("pad-form-image.jpg", 0, 0, 210);
		}
		private function drawTheTexts()
		{
			//Company name billing
			$this->pdf->SetXY(151, 25.0);
			$this->pdf->SetFont("helvetica_bold", "", 10);
			$this->pdf->MultiCell(38,5,OrderNumber::$CURR_ORDER->orderLabel_withPower(),$this->border,"R");
			//Company name billing
			$this->pdf->SetXY(41, 33.5);
			$this->pdf->SetFont("helvetica_bold", "", 10);
			$this->pdf->MultiCell(148,5,$_POST["companyName_".ChequeData::TYPE_BILLING],$this->border,"L");
			//Address billing, a1-3, city, province, postal code
			$this->pdf->SetXY(41, 45.5);
			$this->pdf->SetFont("helvetica_bold", "", 10);
			$this->pdf->MultiCell(148,5,$_POST["address_1_".ChequeData::TYPE_BILLING].",".$_POST["address_2_".ChequeData::TYPE_BILLING].",".$_POST["address_3_".ChequeData::TYPE_BILLING]." | ".$_POST["city_".ChequeData::TYPE_BILLING]." | ".$_POST["province_".ChequeData::TYPE_BILLING]." | ".$_POST["postalCode_".ChequeData::TYPE_BILLING]."", $this->border,"L");
			//Telephone, billing
			$this->pdf->SetXY(41, 58);
			$this->pdf->SetFont("helvetica_bold", "", 10);
			$this->pdf->MultiCell(58,5,$_POST["phone_".ChequeData::TYPE_BILLING],$this->border,"C");
			//Email Address, billing
			$this->pdf->SetXY(132, 58);
			$this->pdf->SetFont("helvetica_bold", "", 10);
			$this->pdf->MultiCell(58,5,$_POST["email_".ChequeData::TYPE_BILLING],$this->border,"C");
			//Bank name from bank info
			$this->pdf->SetXY(87, 70);
			$this->pdf->SetFont("helvetica_bold", "", 10);
			$this->pdf->MultiCell(102,5,$this->chequeData->compInfoBankName(),$this->border,"L");
			//Bank Address from bank info
			$this->pdf->SetXY(41, 82);
			$this->pdf->SetFont("helvetica_bold", "", 10);
			$this->pdf->MultiCell(148,5,$this->chequeData->compInfoBankAddress1().", ".$this->chequeData->compInfoBankAddress2().", ".$this->chequeData->compInfoBankAddress3().", ".$this->chequeData->compInfoBankAddress4()."",$this->border,"L");
			
			
			//Bank number, institution 3 digits
			$this->pdf->SetXY(30, 94.5);
			$this->pdf->SetFont("helvetica_bold", "", 10);
			$this->pdf->MultiCell(28,5,$this->chequeData->transitNumber(),$this->border,"C");
			//Bank number, brunch number, 5 digits
			$this->pdf->SetXY(88, 94.5);
			$this->pdf->SetFont("helvetica_bold", "", 10);
			$this->pdf->MultiCell(28,5,$this->chequeData->brunchNumber(),$this->border,"C");
			//Bank number, account number
			$this->pdf->SetXY(148, 94.5);
			$this->pdf->SetFont("helvetica_bold", "", 10);
			$this->pdf->MultiCell(42,5,$this->chequeData->accountNumber(),$this->border,"C");
			
			if($this->chequeData->MOP() == "Direct Debit")
			{
				//Autorization name(Please print)
				$this->pdf->SetXY(15, 156.5);
				$this->pdf->SetFont("helvetica", "", 7.5);
				$this->pdf->MultiCell(88.5,5,$_POST["MOP_directDebit_signature"],$this->border,"L");
				//Autorizate Signature
				$this->pdf->SetXY(15, 176.2);
				$this->pdf->SetFont("scriptFont", "", 10);
				$this->pdf->MultiCell(88.5,5,$_POST["MOP_directDebit_signature"],$this->border,"L");
			}
			//Date
			$this->pdf->SetXY(117, 178.2);
			$this->pdf->SetFont("helvetica", "", 10);
			$this->pdf->MultiCell(75.5,5,date('l jS \of F Y'),$this->border,"C");
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
	if(!class_exists("XMLParser")){require_once("tools.php");}
	require_once('Mail.php');
	require_once('Mail/mime.php');
	require_once("pdf-tools/fpdf.php");
	require_once("pdf-tools/pdf-helper.php");
	require_once("mail_message_template.php");
	require_once("backupmessage.php");
	XMLParser::ADD_ORDER_XML_TO_POST( "orders/xml/L5107.xml" );
	$objCheque = new Cheque( $_POST["chequeType"] );
	$objChequeData = new ChequeData( $objCheque );
	$DepositSlips = new PA_Debit( $objChequeData );
	$DepositSlips->saveToLocal( "pa-debit-testing.pdf" );
	*/
?>