<?php
	
	class CHEQUE_TEMPLATE
	{
		var $pdf,
			$chequeData,
			$cheque,
			$fileName = "cheques.pdf",
			$outPutTOSErver=NULL;
		
		public static $pdfPocetokY = 0;
		public static $pdfPocetokX = 0;
		public static $check_pozY_plus = 0;
		
		
		public function CHEQUE_TEMPLATE($chequeData___, $cheque___)
		{
			$this->cheque = $cheque___;
			$this->chequeData = $chequeData___;
			CHEQUE_TEMPLATE::$pdfPocetokX = (PDFHelper::$widthA4-PDFHelper::pixels_to_MM(612))/2-5;
			CHEQUE_TEMPLATE::$pdfPocetokY = CHEQUE_TEMPLATE::$pdfPocetokX;
			switch($this->chequeData->chequePosition())
			{
				case "1":
				{
					CHEQUE_TEMPLATE::$check_pozY_plus = 0;
				}break;
				case "2":
				{
					CHEQUE_TEMPLATE::$check_pozY_plus = 252;
				}break;
				case "3":
				{
					CHEQUE_TEMPLATE::$check_pozY_plus = 540;
				}break;
			}
				
			$this->pdf=new FPDF('P','mm','A4');
			$this->pdf->AddFont('MICRFont','','../fonts/micr/fpdf/f30e76a7a57ca16aaf2424921d10f4da_micr___.php');//Povikuvanje na nov font za brojkite
			$this->pdf->AddFont('helvetica','','../fonts/helvetica/fpdf/25e75292757c3eb4bba8a3ddd4e8fe3f_helvetica_lt.php');//Povikuvanje na nov font za brojkite
			$this->pdf->AddFont('helveticaBold','','../fonts/helvetica-bold/fpdf/3c41c8e6600e41512cbd6a118d2bdf41_helvetica_bold.php');
			$this->pdf->AddFont('arial_moj','','../fonts/arial/fpdf/5c7883f46367d27bdea7be339987594e_arial.php');
			$this->pdf->AddFont('arial_bold_moj','','../fonts/arial-bold/fpdf/e91750ea4b8abc39e7d49ec50fdc4fcc_arialbd.php');
			$this->pdf->SetDisplayMode(real,'default');
			$this->pdf->AddPage();
			$this->pdf->SetXY(0 , 0 ); 
			
			$this->setBG();
			$this->writeCompanyName();
			$this->watermarkAdd();
			$this->payToTheOrderOf();
			$this->bankNameAndAddress();
			$this->numbersDraw();
			$this->drawPerLines();
			switch($this->chequeData->chequePosition())
			{
				case "1":
				{
					$this->drawBlock(290);
					$this->drawBlock(540);
					$this->drawDashedBorders(275, 252, 288);
				}break;
				case "2":
				{
					$this->drawBlock(15);
					$this->drawBlock(542);
					$this->drawDashedBorders(252, 275, 288);
				}break;
				case "3":
				{
					$this->drawBlock(15);
					$this->drawBlock(303);
					$this->drawDashedBorders(288, 252, 275);
				}break;
			}
			if($this->chequeData->softwareIndex() == "4")
			{
				$this->drawDolarche();
			}
			if($this->chequeData->isCurrency()==true)
			{
				$this->drawTheFUNDS();
			}
			
			$this->pdf->Output($this->fileName, "");//testing
		}
		function setBG()
		{
			$this->pdf->Image($this->chequeData->backgroundURL() ,CHEQUE_TEMPLATE::$pdfPocetokX,CHEQUE_TEMPLATE::$pdfPocetokY+CHEQUE_TEMPLATE::$check_pozY_plus,
																PDFHelper::pixels_to_MM(612),PDFHelper::pixels_to_MM(235));
		}
		function writeCompanyName()
		{
			$companyName_pozX = PDFHelper::pixels_to_MM(25)+CHEQUE_TEMPLATE::$pdfPocetokX;
			$companyName_pozY = PDFHelper::pixels_to_MM(20)+CHEQUE_TEMPLATE::$pdfPocetokY+CHEQUE_TEMPLATE::$check_pozY_plus;
			$this->pdf->SetFont('arial_bold_moj','',10);
			$this->pdf->SetXY($companyName_pozX, $companyName_pozY); 
			$this->pdf->Cell(PDFHelper::pixels_to_MM(300),PDFHelper::points_to_MM(10),$this->chequeData->CINACompanyName(),0,0,'C');
			if($this->chequeData->CINACompanySecondName() != "" )
			{
				$companyName_pozY += PDFHelper::points_to_MM(10);
				$this->pdf->SetFont('arial_bold_moj','',10);
				$this->pdf->SetXY($companyName_pozX, $companyName_pozY); 
				$this->pdf->Cell(PDFHelper::pixels_to_MM(300),PDFHelper::points_to_MM(10),$this->chequeData->CINACompanySecondName(),0,0,'C');
			}
			$this->pdf->SetFont('arial_moj','',8);
			$this->pdf->SetXY($companyName_pozX  , $companyName_pozY + PDFHelper::pixels_to_MM(20));
			$this->pdf->Cell(PDFHelper::pixels_to_MM(300),PDFHelper::points_to_MM(8),$this->chequeData->compInfoAddressLine1(),0,0,'C');
			$this->pdf->SetXY($companyName_pozX  , $companyName_pozY + PDFHelper::pixels_to_MM(20+15));
			$this->pdf->Cell(PDFHelper::pixels_to_MM(300),PDFHelper::points_to_MM(8),$this->chequeData->compInfoAddressLine2(),0,0,'C');
			$this->pdf->SetXY($companyName_pozX  , $companyName_pozY + PDFHelper::pixels_to_MM(20+15+15));
			$this->pdf->Cell(PDFHelper::pixels_to_MM(300),PDFHelper::points_to_MM(8),$this->chequeData->compInfoAddressLine3(),0,0,'C');
			$this->pdf->SetXY($companyName_pozX  , $companyName_pozY + PDFHelper::pixels_to_MM(20+15+15+15));
			$this->pdf->Cell(PDFHelper::pixels_to_MM(300),PDFHelper::points_to_MM(8),$this->chequeData->compInfoAddressLine4(),0,0,'C');
			
			$this->pdf->SetFont('arial_bold_moj','',8);
			$pozXInfotxt = CHEQUE_TEMPLATE::$pdfPocetokX + PDFHelper::pixels_to_MM(360);
			$pozYInfotxt = CHEQUE_TEMPLATE::$pdfPocetokY + CHEQUE_TEMPLATE::$check_pozY_plus + PDFHelper::pixels_to_MM(150);
			$this->pdf->SetXY($pozXInfotxt  , $pozYInfotxt);
			$this->pdf->Cell(PDFHelper::pixels_to_MM(240),PDFHelper::points_to_MM(8),$this->chequeData->CINACompanyName(),0,0,'C',0);
			if($this->chequeData->CINACompanySecondName() != "")
			{
				$this->pdf->SetXY($pozXInfotxt  , $pozYInfotxt+PDFHelper::points_to_MM(8));
				$this->pdf->Cell(PDFHelper::pixels_to_MM(240),PDFHelper::points_to_MM(8),$this->chequeData->CINACompanySecondName(),0,0,'C',0);
			}
		}
		function watermarkAdd()
		{
			$this->pdf->Image('../images/backgrounds/watermark.jpg',CHEQUE_TEMPLATE::$pdfPocetokX + PDFHelper::pixels_to_MM(310),
												CHEQUE_TEMPLATE::$pdfPocetokY + CHEQUE_TEMPLATE::$check_pozY_plus + PDFHelper::pixels_to_MM(180),
												PDFHelper::pixels_to_MM(36),PDFHelper::pixels_to_MM(37),'','', false/*, $maskImg*/); 
		}
		function payToTheOrderOf()
		{
			$PAY_x = CHEQUE_TEMPLATE::$pdfPocetokX + PDFHelper::pixels_to_MM(10);
			$PAY_y = CHEQUE_TEMPLATE::$pdfPocetokY + CHEQUE_TEMPLATE::$check_pozY_plus + PDFHelper::pixels_to_MM(130);
			$this->pdf->SetXY($PAY_x   , $PAY_y);
			$this->pdf->SetFont('arial_bold_moj','',10);
			$this->pdf->Cell(0,PDFHelper::points_to_MM(10),"PAY");
			$this->pdf->SetFont('arial_moj','',8);
			$this->pdf->SetXY($PAY_x   , $PAY_y+PDFHelper::pixels_to_MM(30));
			$this->pdf->Cell(0,PDFHelper::points_to_MM(8),"TO");
			$this->pdf->SetXY($PAY_x   , $PAY_y+PDFHelper::pixels_to_MM(30+15));
			$this->pdf->Cell(0,PDFHelper::points_to_MM(8),"THE");
			$this->pdf->SetXY($PAY_x   , $PAY_y+PDFHelper::pixels_to_MM(30+15+15));
			$this->pdf->Cell(0,PDFHelper::points_to_MM(8),"ORDER");
			$this->pdf->SetXY($PAY_x   , $PAY_y+PDFHelper::pixels_to_MM(30+15+15+15));
			$this->pdf->Cell(0,PDFHelper::points_to_MM(8),"OF");
		}
		function bankNameAndAddress()
		{
			$pozX_bankInfoRect = CHEQUE_TEMPLATE::$pdfPocetokX + PDFHelper::pixels_to_MM(340);
			$pozY_bankInfoRect = CHEQUE_TEMPLATE::$pdfPocetokY + CHEQUE_TEMPLATE::$check_pozY_plus + PDFHelper::pixels_to_MM(25);
			$this->pdf->SetFont('arial_bold_moj','',8);
			$this->pdf->SetXY($pozX_bankInfoRect   , $pozY_bankInfoRect);
			$this->pdf->Cell(PDFHelper::pixels_to_MM(170),PDFHelper::points_to_MM(8),$this->chequeData->compInfoBankName(),0,0,'L',0);
			$this->pdf->SetFont('arial_moj','',6);
			$this->pdf->SetXY($pozX_bankInfoRect   , $pozY_bankInfoRect+PDFHelper::pixels_to_MM(15));
			$this->pdf->Cell(PDFHelper::pixels_to_MM(170),PDFHelper::points_to_MM(6),$this->chequeData->compInfoBankAddress1(),0,0,'L',0);
			$this->pdf->SetXY($pozX_bankInfoRect   , $pozY_bankInfoRect+PDFHelper::pixels_to_MM(15+10));
			$this->pdf->Cell(PDFHelper::pixels_to_MM(170),PDFHelper::points_to_MM(6),$this->chequeData->compInfoBankAddress2(),0,0,'L',0);
			$this->pdf->SetXY($pozX_bankInfoRect   , $pozY_bankInfoRect+PDFHelper::pixels_to_MM(15+10+10));
			$this->pdf->Cell(PDFHelper::pixels_to_MM(170),PDFHelper::points_to_MM(6),$this->chequeData->compInfoBankAddress3(),0,0,'L',0);
			$this->pdf->SetXY($pozX_bankInfoRect   , $pozY_bankInfoRect+PDFHelper::pixels_to_MM(15+10+10+10));
			$this->pdf->Cell(PDFHelper::pixels_to_MM(170),PDFHelper::points_to_MM(6),$this->chequeData->compInfoBankAddress4(),0,0,'L',0);
		}
		function numbersDraw()
		{
			//[Desno gore]
			$SAN_pozX = CHEQUE_TEMPLATE::$pdfPocetokX + PDFHelper::pixels_to_MM(495);
			$SAN_pozY = CHEQUE_TEMPLATE::$pdfPocetokY + CHEQUE_TEMPLATE::$check_pozY_plus + PDFHelper::pixels_to_MM(19);
			$this->pdf->SetXY($SAN_pozX  , $SAN_pozY);
			$this->pdf->SetFont('arial_moj','',18);
			if($this->chequeData->startAtNumberShow() == "true")
			{
				$this->pdf->Cell(PDFHelper::pixels_to_MM(100),PDFHelper::points_to_MM(18),$this->chequeData->startAtNumber(),0,0,'R',0);
			}
			////
			$pozX_charSAN = CHEQUE_TEMPLATE::$pdfPocetokX + PDFHelper::pixels_to_MM(20+190);
			$pozY_charSAN = CHEQUE_TEMPLATE::$pdfPocetokY + CHEQUE_TEMPLATE::$check_pozY_plus + PDFHelper::pixels_to_MM(238);
		
			$this->pdf->SetFont('MICRFont','',12);
			$this->pdf->SetXY(CHEQUE_TEMPLATE::$pdfPocetokX + PDFHelper::pixels_to_MM(20) , CHEQUE_TEMPLATE::$pdfPocetokY + PDFHelper::pixels_to_MM(247)+CHEQUE_TEMPLATE::$check_pozY_plus);
			$this->pdf->Cell(PDFHelper::pixels_to_MM(190),PDFHelper::points_to_MM(12),'C'.$this->chequeData->startAtNumber().'C',0,0,'R',0);
	  
			$this->pdf->SetFont('MICRFont','',12);
			$this->pdf->SetXY(CHEQUE_TEMPLATE::$pdfPocetokX + PDFHelper::pixels_to_MM(204) , CHEQUE_TEMPLATE::$pdfPocetokY + PDFHelper::pixels_to_MM(247)+CHEQUE_TEMPLATE::$check_pozY_plus);
			$this->pdf->Cell(PDFHelper::pixels_to_MM(190),PDFHelper::points_to_MM(12),'A'.$this->chequeData->brunchNumber().'D'.$this->chequeData->transitNumber().'A',0,0,'C',0);
			
			$this->pdf->SetFont('MICRFont','',12);
			$this->pdf->SetXY(CHEQUE_TEMPLATE::$pdfPocetokX + PDFHelper::pixels_to_MM(388) , CHEQUE_TEMPLATE::$pdfPocetokY + PDFHelper::pixels_to_MM(247)+CHEQUE_TEMPLATE::$check_pozY_plus);
			$this->pdf->Cell(PDFHelper::pixels_to_MM(210),PDFHelper::points_to_MM(12),$this->chequeData->accountNumber__newFontWriteSTR().'C',0,0,'L',0);
		}
		function drawTheFUNDS()
		{
			$this->pdf->SetFont('arial_bold_moj','',10);
			$this->pdf->SetXY(CHEQUE_TEMPLATE::$pdfPocetokX + PDFHelper::pixels_to_MM(590) , CHEQUE_TEMPLATE::$pdfPocetokY + PDFHelper::pixels_to_MM(240)+ CHEQUE_TEMPLATE::$check_pozY_plus);
			$this->pdf->Cell(PDFHelper::pixels_to_MM(140),PDFHelper::points_to_MM(12),$this->chequeData->us_funds_label(),0,0,'L',0);
		}
		function drawDolarche()
		{
			$this->pdf->SetFont('arial_bold_moj','',12);
			$this->pdf->SetXY(CHEQUE_TEMPLATE::$pdfPocetokX + PDFHelper::pixels_to_MM(510) , CHEQUE_TEMPLATE::$pdfPocetokY + PDFHelper::pixels_to_MM(220)+ CHEQUE_TEMPLATE::$check_pozY_plus);
			$this->pdf->Cell(PDFHelper::pixels_to_MM(140),PDFHelper::points_to_MM(12),'$',0,0,'L',0);
		}
		function drawPerLines()
		{
			$pozXInfotxt = CHEQUE_TEMPLATE::$pdfPocetokX + PDFHelper::pixels_to_MM(360);
			$this->pdf->SetFont('arial_moj','',9);
			$this->pdf->SetXY($pozXInfotxt - PDFHelper::pixels_to_MM(10)  , CHEQUE_TEMPLATE::$pdfPocetokY + PDFHelper::pixels_to_MM(180)+ CHEQUE_TEMPLATE::$check_pozY_plus);
			if($this->chequeData->thereIsSecondSignature() == true)
			{
				$this->pdf->Cell(PDFHelper::pixels_to_MM(240),PDFHelper::points_to_MM(9),'PER_______________________________',0,0,'C',0);
			}
			$this->pdf->SetXY($pozXInfotxt - PDFHelper::pixels_to_MM(10)  , CHEQUE_TEMPLATE::$pdfPocetokY + PDFHelper::pixels_to_MM(210)+ CHEQUE_TEMPLATE::$check_pozY_plus);
			$this->pdf->Cell(PDFHelper::pixels_to_MM(240),PDFHelper::points_to_MM(9),'PER_______________________________',0,0,'C',0);	
		}
		function drawBlock($startY)
		{	
			$textWidth = PDFHelper::pixels_to_MM(432);$numberWidth = PDFHelper::pixels_to_MM(100);
			$textLeft1 = PDFHelper::pixels_to_MM(20);
			$textTop1 = PDFHelper::pixels_to_MM($startY);
			$numberLeft1 = PDFHelper::pixels_to_MM(495);
			$numberTop1 = PDFHelper::pixels_to_MM($startY);
			$this->pdf->SetFont('arial_bold_moj','',10);
			$this->pdf->SetXY($textLeft1 + CHEQUE_TEMPLATE::$pdfPocetokX, $textTop1 + CHEQUE_TEMPLATE::$pdfPocetokY);
			if($this->chequeData->CINACompanySecondName() != "")
			{
				$this->pdf->Cell($textWidth,PDFHelper::points_to_MM(10),$this->chequeData->CINAComapanyNameLinivche(),0,0,'L',0);
			}
			else
			{
				$this->pdf->Cell($textWidth,PDFHelper::points_to_MM(10),$this->chequeData->CINACompanyName(),0,0,'L',0);
			}
			
			$this->pdf->SetFont('arial_moj','',18);
			$this->pdf->SetXY($numberLeft1 + CHEQUE_TEMPLATE::$pdfPocetokX, $numberTop1 + CHEQUE_TEMPLATE::$pdfPocetokY);
			$this->pdf->Cell($numberWidth,PDFHelper::points_to_MM(18),$this->chequeData->startAtNumber(),0,0,'R',0);
		}
		function drawDashedBorders($rect1Height, $rect2Height, $rect3Height)
		{
			$this->pdf->SetDrawColor(200,200,200);
			$widthRect = PDFHelper::pixels_to_MM(612);
			$left1 = 0;$top1 = 0;$heightRect1 = PDFHelper::pixels_to_MM($rect1Height);
		 	$left2 = 0;$top2 = $heightRect1;$heightRect2 = PDFHelper::pixels_to_MM($rect2Height);
		 	$left3 = 0;$top3 = $heightRect1 + $heightRect2;$heightRect3 = PDFHelper::pixels_to_MM($rect3Height);
			$this->pdf->Rect($left1 + CHEQUE_TEMPLATE::$pdfPocetokX,$top1 + CHEQUE_TEMPLATE::$pdfPocetokY,$widthRect,$heightRect1,'D');
			$this->pdf->Rect($left2 + CHEQUE_TEMPLATE::$pdfPocetokX,$top2 + CHEQUE_TEMPLATE::$pdfPocetokY,$widthRect,$heightRect2,'D');
			$this->pdf->Rect($left3 + CHEQUE_TEMPLATE::$pdfPocetokX,$top3 + CHEQUE_TEMPLATE::$pdfPocetokY,$widthRect,$heightRect3,'D');
		}
		public function PDFContent()
		{
			if($this->outPutTOSErver != NULL){return $this->outPutTOSErver;}
			$this->outPutTOSErver = $this->pdf->Output($this->fileName, "S");
			return $this->outPutTOSErver;
		}
	}
	
?>