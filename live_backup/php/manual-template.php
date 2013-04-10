<?php
	
	class CHEQUE_TEMPLATE
	{
		var $pdf,
			$chequeData,
			$cheque,
			$fileName = "cheques.pdf",
			$outPutTOSErver=NULL;
		
		public function CHEQUE_TEMPLATE($chequeData___, $cheque__)
		{
			$this->chequeData = $chequeData___;
			$this->cheque = $cheque__;
			
			if($this->chequeData->isManualX1() == true)
			{
				$this->pdf=new FPDF('L','mm','A5');
			}
			else
			{
				$this->pdf=new FPDF('L','mm','A4');
			}
			//$this->pdf=new FPDF('P','mm',array(165.1,279.4));//6.5x11
			//$this->pdf=new FPDF('P','mm',array(250,279.4));
			
			$this->pdf->AddFont('MICRFont','','../fonts/micr/fpdf/f30e76a7a57ca16aaf2424921d10f4da_micr___.php');//Povikuvanje na nov font za brojkite
			$this->pdf->AddFont('helvetica','','../fonts/helvetica/fpdf/25e75292757c3eb4bba8a3ddd4e8fe3f_helvetica_lt.php');//Povikuvanje na nov font za brojkite
			$this->pdf->AddFont('helveticaBold','','../fonts/helvetica-bold/fpdf/3c41c8e6600e41512cbd6a118d2bdf41_helvetica_bold.php');
			$this->pdf->SetDisplayMode(real,'default');
			$this->pdf->AddPage();
			$this->pdf->SetXY(0 , 0 ); 
			
			if($this->chequeData->isManualX1() == true)
			{
				$this->drawCheque($this->pdf, 40,170,250,280,170,0,true, false);
			}
			else
			{
				$this->drawCheque($this->pdf, 190,150,250,430,150,  0,false, false);
				$this->drawCheque($this->pdf, 190,420,250,430,420,1,false, true);
			}
			//$this->pdf->Output($this->fileName, "");//testing
		}
		function drawCheque($pdf, $tablePozX, $tablePozY, $tablePozWidth,  $chequePozX, $chequePozY, $aha_8_,$oneCheque, $showOneObjects)
		{
			$pdf->SetDrawColor(150,150,150);
				if($aha_8_ == 0)
				{
					$pdf->SetLineWidth( PDFHelper::pixels_to_MM(1) );
					$pozX = PDFHelper::pixels_to_MM($tablePozX  + $tablePozWidth - 15);
					$pozY = PDFHelper::pixels_to_MM($tablePozY);
					$helpWidth = PDFHelper::pixels_to_MM($tablePozWidth - 23) + $pozX;
				$pdf->Line($pozX,$pozY,$pozX,$pozY + PDFHelper::pixels_to_MM(250));
				}
				else
				{
					$pdf->SetLineWidth( PDFHelper::pixels_to_MM(1) );
					$pozX = PDFHelper::pixels_to_MM($tablePozX  + $tablePozWidth - 15);
					$pozY = PDFHelper::pixels_to_MM($tablePozY - 20);
					$helpWidth = PDFHelper::pixels_to_MM($tablePozWidth - 23) + $pozX;
				$pdf->Line($pozX,$pozY,$pozX,$pozY + PDFHelper::pixels_to_MM(270));
					$pdf->SetLineWidth( PDFHelper::pixels_to_MM(1) );
					$pozX = PDFHelper::pixels_to_MM($tablePozX  - 40);
					$pozY = PDFHelper::pixels_to_MM($tablePozY - 20);
				$pdf->Line($pozX,$pozY,$pozX + PDFHelper::pixels_to_MM(790),$pozY);
				}
			
				if($oneCheque == true)
				{
					$pozX = PDFHelper::pixels_to_MM($tablePozX - 40);
					$pozY = PDFHelper::pixels_to_MM($tablePozY + 0);
					$width = PDFHelper::pixels_to_MM(40);
					$height = PDFHelper::pixels_to_MM(242);
					if($oneCheque == true)
					$pdf->Image('../images/labelLeft.jpg' ,$pozX,$pozY,$width,$height);
				}
				else
				{		
					$pozX = PDFHelper::pixels_to_MM($tablePozX - 40);
					$pozY = PDFHelper::pixels_to_MM($tablePozY - 260);
					$width = PDFHelper::pixels_to_MM(40);
					$height = PDFHelper::pixels_to_MM(484);
					if($oneCheque == false && $showOneObjects == true)
					$pdf->Image('../images/labelLeft_big.jpg' ,$pozX,$pozY,$width,$height);
				}
			
				$pdf->SetDrawColor(0,0,0);
			
				/*Pozadina slika*/
				$pozX = PDFHelper::pixels_to_MM($chequePozX);
				$pozY = PDFHelper::pixels_to_MM($chequePozY);
				$width = PDFHelper::pixels_to_MM(515);
				$height = PDFHelper::pixels_to_MM(198);
				$pdf->Image($this->chequeData->backgroundURL() ,$pozX,$pozY,$width,$height);
			
				/*Belo pravoagolniche*/
				$pozX = PDFHelper::pixels_to_MM($chequePozX + 385);
				$pozY = PDFHelper::pixels_to_MM($chequePozY + 65);
				$width = PDFHelper::pixels_to_MM(110);
				$height = PDFHelper::pixels_to_MM(20);
				$pdf->Image('../images/whiteRectangle.jpg' ,$pozX,$pozY,$width,$height);
			
				/*Label Godina*/
				$pdf->SetFont('helveticaBold','',7);
				$pozX = PDFHelper::pixels_to_MM($chequePozX + 325);
				$pozY = PDFHelper::pixels_to_MM($chequePozY + 52);
				$pdf->SetXY($pozX, $pozY);
			$pdf->Cell(PDFHelper::pixels_to_MM(100),PDFHelper::points_to_MM(10),'DATE      Y    Y    Y    Y    M   M    D   D',0,0,'L');
			
			
				/*Site bukvi*/
				$plus = 0;
				for($i=0; $i<8; $i++)
				{
					/*Belo pravoagolniche*/
					$pozX = PDFHelper::pixels_to_MM($chequePozX + 363 + $plus);
					$pozY = PDFHelper::pixels_to_MM($chequePozY + 35);
					$width = PDFHelper::pixels_to_MM(15);
					$height = PDFHelper::pixels_to_MM(15);
					$pdf->Image('../images/whiteRectangle.jpg' ,$pozX,$pozY,$width,$height);
					$plus = $plus + 17; 
				}	
			$pdf->SetTextColor(204,204,204);
				$pdf->SetFont('helveticaBold','',7);
				$pozX = PDFHelper::pixels_to_MM($chequePozX + 363);
				$pozY = PDFHelper::pixels_to_MM($chequePozY + 35);
				$pdf->SetXY($pozX, $pozY);
			$pdf->Cell(PDFHelper::pixels_to_MM(100),PDFHelper::points_to_MM(10),'2',0,0,'L');	
				$pdf->SetFont('helveticaBold','',7);
				$pozX = PDFHelper::pixels_to_MM($chequePozX + 363 + 17);
				$pozY = PDFHelper::pixels_to_MM($chequePozY + 35);
				$pdf->SetXY($pozX, $pozY);
			$pdf->Cell(PDFHelper::pixels_to_MM(100),PDFHelper::points_to_MM(10),'0',0,0,'L');
			
				$pdf->SetTextColor(239,239,239);
				$pozX = PDFHelper::pixels_to_MM($chequePozX + 363 + 17 + 17);
				$pozY = PDFHelper::pixels_to_MM($chequePozY + 35);
				$pdf->SetXY($pozX, $pozY);
			$pdf->Cell(PDFHelper::pixels_to_MM(100),PDFHelper::points_to_MM(10),'Y    Y    M   M    D   D',0,0,'L');
			
				$pdf->SetLineWidth(0.01);
				$pdf->SetDrawColor(0,0,0);
				/*prva kolona levo, podatoci za kompanijata*/
			$pdf->SetTextColor(0,0,0);
				$pdf->SetFont('helveticaBold','',9);
				$pozX = PDFHelper::pixels_to_MM($chequePozX + 15);
				$pozY = PDFHelper::pixels_to_MM($chequePozY + 10);
				$pdf->SetXY($pozX, $pozY);
			$pdf->Cell(PDFHelper::pixels_to_MM(300),PDFHelper::points_to_MM(10),$this->chequeData->CINACompanyName(),0,0,'C');
			if($this->chequeData->CINACompanySecondName() != "")
			{
				$pozY += PDFHelper::points_to_MM(8);
				$pdf->SetFont('helveticaBold','',9);
				$pdf->SetXY($pozX, $pozY); 
				$pdf->Cell(PDFHelper::pixels_to_MM(300),PDFHelper::points_to_MM(10),$this->chequeData->CINACompanySecondName(),0,0,'C');
			}	
				$pdf->SetFont('helvetica','',7);
				$pozY = PDFHelper::pixels_to_MM($chequePozY + 25);
				$pdf->SetXY($pozX, $pozY);
			$pdf->Cell(PDFHelper::pixels_to_MM(300),PDFHelper::points_to_MM(10),$this->chequeData->compInfoAddressLine1(),0,0,'C');
				$pozY = PDFHelper::pixels_to_MM($chequePozY + 35);
				$pdf->SetXY($pozX, $pozY);
			$pdf->Cell(PDFHelper::pixels_to_MM(300),PDFHelper::points_to_MM(10),$this->chequeData->compInfoAddressLine2(),0,0,'C');
				$pozY = PDFHelper::pixels_to_MM($chequePozY + 45);
				$pdf->SetXY($pozX, $pozY);
			$pdf->Cell(PDFHelper::pixels_to_MM(300),PDFHelper::points_to_MM(10),$this->chequeData->compInfoAddressLine3(),0,0,'C');
				$pozY = PDFHelper::pixels_to_MM($chequePozY + 55);
				$pdf->SetXY($pozX, $pozY);
			$pdf->Cell(PDFHelper::pixels_to_MM(300),PDFHelper::points_to_MM(10),$this->chequeData->compInfoAddressLine4(),0,0,'C');
			
				/*Pay to variables*/
				$pdf->SetFont('helveticaBold','',9);
				$pozX = PDFHelper::pixels_to_MM($chequePozX + 20);
				$pozY = PDFHelper::pixels_to_MM($chequePozY + 70);
				$pdf->SetXY($pozX, $pozY);
			$pdf->Cell(PDFHelper::pixels_to_MM(30),PDFHelper::points_to_MM(10),'PAY',0,0,'L');
				$pdf->SetFont('helvetica','',9);
				$pozX = PDFHelper::pixels_to_MM($chequePozX + 50);
				$pozY = PDFHelper::pixels_to_MM($chequePozY + 70);
				$pdf->SetXY($pozX, $pozY);
			$pdf->Cell(PDFHelper::pixels_to_MM(700),PDFHelper::points_to_MM(10),'to_______________________________________________|',0,0,'L');
				$pdf->SetFont('helvetica','',9);
				$pozX = PDFHelper::pixels_to_MM($chequePozX +5);
				$pozY = PDFHelper::pixels_to_MM($chequePozY + 85);
				$pdf->SetXY($pozX, $pozY);
			$pdf->Cell(PDFHelper::pixels_to_MM(300),PDFHelper::points_to_MM(10),'the order of',0,0,'L');
			
				/*Linija ispod pay*/
				$pdf->SetFont('helvetica','',9);
				$pozX = PDFHelper::pixels_to_MM($chequePozX +15);
				$pozY = PDFHelper::pixels_to_MM($chequePozY + 100);
				$pdf->SetXY($pozX, $pozY);
			$pdf->Cell(PDFHelper::pixels_to_MM(700),PDFHelper::points_to_MM(10),'_____________________________________________________/100 DOLLARS',0,0,'L');
			
				/*Linija For*/
				$pdf->SetFont('helvetica','',9);
				$pozX = PDFHelper::pixels_to_MM($chequePozX +10);
				$pozY = PDFHelper::pixels_to_MM($chequePozY + 180);
				$pdf->SetXY($pozX, $pozY);
			$pdf->Cell(PDFHelper::pixels_to_MM(300),PDFHelper::points_to_MM(10),'FOR________________________',0,0,'L');
			
				/*Contact info address*/
				$pdf->SetFont('helveticaBold','',8);
				$pozX = PDFHelper::pixels_to_MM($chequePozX + 300);
				$pozY = PDFHelper::pixels_to_MM($chequePozY + 130);
				$pdf->SetXY($pozX, $pozY);
			$pdf->Cell(PDFHelper::pixels_to_MM(200),PDFHelper::points_to_MM(10),$this->chequeData->CINACompanyName(),0,0,'C');
			if($this->chequeData->CINACompanySecondName() != "" )
			{
				$pozY += PDFHelper::points_to_MM(8);
				$this->pdf->SetFont('helveticaBold','',8);
				$this->pdf->SetXY($pozX, $pozY); 
				$this->pdf->Cell(PDFHelper::pixels_to_MM(300),PDFHelper::points_to_MM(8),$this->chequeData->CINACompanySecondName(),0,0,'C');
			}
			
			if($this->chequeData->softwareIndex() == "4")
			{
				/*Dollar*/
				$pdf->SetFont('helveticaBold','',9);
				$pozX = PDFHelper::pixels_to_MM($chequePozX +375);
				$pozY = PDFHelper::pixels_to_MM($chequePozY + 130);
				$pdf->SetXY($pozX, $pozY);
				$pdf->Cell(PDFHelper::pixels_to_MM(50),PDFHelper::points_to_MM(10),"$",0,0,'C');
			}
			if($this->chequeData->isCurrency() == true)
			{
				/*US FUNDS*/
				$pdf->SetFont('helveticaBold','',7);
				$pozX = PDFHelper::pixels_to_MM($chequePozX +440);
				$pozY = PDFHelper::pixels_to_MM($chequePozY + 140);
				$pdf->SetXY($pozX, $pozY);
				$pdf->Cell(PDFHelper::pixels_to_MM(60),PDFHelper::points_to_MM(10),$this->chequeData->us_funds_label(),0,0,'C');
			}
				
				/*Linija per1*/
				$pdf->SetFont('helvetica','',9);
				$pozX = PDFHelper::pixels_to_MM($chequePozX +310);
				$pozY = PDFHelper::pixels_to_MM($chequePozY + 180);
				$pdf->SetXY($pozX, $pozY);
			$pdf->Cell(PDFHelper::pixels_to_MM(300),PDFHelper::points_to_MM(10),'PER________________________',0,0,'L');
			
				if($this->chequeData->thereIsSecondSignature() == true)
				{
					/*Linija per2*/
					$pdf->SetFont('helvetica','',9);
					$pozX = PDFHelper::pixels_to_MM($chequePozX +310);
					$pozY = PDFHelper::pixels_to_MM($chequePozY + 160);
					$pdf->SetXY($pozX, $pozY);
				$pdf->Cell(PDFHelper::pixels_to_MM(300),PDFHelper::points_to_MM(10),'PER________________________',0,0,'L');
				}
				/*Water mark*/
				$pozX = PDFHelper::pixels_to_MM($chequePozX + 240);
				$pozY = PDFHelper::pixels_to_MM($chequePozY + 150);
				$width = PDFHelper::pixels_to_MM(36);
				$height = PDFHelper::pixels_to_MM(36);
				$pdf->Image('../images/backgrounds/watermark.jpg' ,$pozX,$pozY,$width,$height);
			
				/*Bank Details*/
				$pdf->SetFont('helveticaBold','',8);
				$pozX = PDFHelper::pixels_to_MM($chequePozX +20);
				$pozY = PDFHelper::pixels_to_MM($chequePozY + 120);
				$pdf->SetXY($pozX, $pozY);
			$pdf->Cell(PDFHelper::pixels_to_MM(200),PDFHelper::points_to_MM(10),$this->chequeData->compInfoBankName() ,0,0,'L');
				$pdf->SetFont('helvetica','',7);
				$pozY = PDFHelper::pixels_to_MM($chequePozY + 135);
				$pdf->SetXY($pozX, $pozY);
			$pdf->Cell(PDFHelper::pixels_to_MM(170),PDFHelper::points_to_MM(10),$this->chequeData->compInfoBankAddress1() ,0,0,'L');
				$pozY = PDFHelper::pixels_to_MM($chequePozY + 145);
				$pdf->SetXY($pozX, $pozY);
			$pdf->Cell(PDFHelper::pixels_to_MM(170),PDFHelper::points_to_MM(10),$this->chequeData->compInfoBankAddress2() ,0,0,'L');
				$pozY = PDFHelper::pixels_to_MM($chequePozY + 155);
				$pdf->SetXY($pozX, $pozY);
			$pdf->Cell(PDFHelper::pixels_to_MM(170),PDFHelper::points_to_MM(10),$this->chequeData->compInfoBankAddress3() ,0,0,'L');
				$pozY = PDFHelper::pixels_to_MM($chequePozY + 165);
				$pdf->SetXY($pozX, $pozY);
			$pdf->Cell(PDFHelper::pixels_to_MM(170),PDFHelper::points_to_MM(10),$this->chequeData->compInfoBankAddress4() ,0,0,'L');
			
				/*Brojche gore desno*/
				if($this->chequeData->startAtNumberShow() == "true")
				{
					$pdf->SetFont('helveticaBold','',12);
					$pozX = PDFHelper::pixels_to_MM($chequePozX + 395);
					$pozY = PDFHelper::pixels_to_MM($chequePozY + 12);
					$pdf->SetXY($pozX, $pozY);
					if($aha_8_ == 0)
				$pdf->Cell(PDFHelper::pixels_to_MM(100),PDFHelper::points_to_MM(10),$this->chequeData->startAtNumber() ,0,0,'R');
					else $pdf->Cell(PDFHelper::pixels_to_MM(100),PDFHelper::points_to_MM(10),$this->chequeData->startAtNumber_plus_1() ,0,0,'R');
			
					/*Brojche dolu levo*/
					$pdf->SetFont('MICRFont','',11);
					$pozX = PDFHelper::pixels_to_MM($chequePozX - 70);
					$pozY = PDFHelper::pixels_to_MM($chequePozY + 220);
					$pdf->SetXY($pozX, $pozY);
					//print "[+]".$this->chequeData->startAtNumberDD($this->chequeData->startAtNumber());
					if($aha_8_ == 0)
				$pdf->Cell(PDFHelper::pixels_to_MM(190),PDFHelper::points_to_MM(10),$this->chequeData->startAtNumberDD($this->chequeData->startAtNumber()) ,0,0,'R');
					else $pdf->Cell(PDFHelper::pixels_to_MM(190),PDFHelper::points_to_MM(10),$this->chequeData->startAtNumberDD($this->chequeData->startAtNumber_plus_1()) ,0,0,'R');
				}
			
				$pdf->SetFont('MICRFont','',11);
			
				/*Na sredina brojce*/
				$pozX = PDFHelper::pixels_to_MM($chequePozX + 120);
				$pozY = PDFHelper::pixels_to_MM($chequePozY + 220);
				$pdf->SetXY($pozX, $pozY);
			$pdf->Cell(PDFHelper::pixels_to_MM(190),PDFHelper::points_to_MM(10),'A'.$this->chequeData->brunchNumber().'D'.$this->chequeData->transitNumber().'A' ,0,0,'C');
			
				/*Dolu desno brojche*/
				$pozX = PDFHelper::pixels_to_MM($chequePozX + 310);
				$pozY = PDFHelper::pixels_to_MM($chequePozY + 220);
				$pdf->SetXY($pozX, $pozY);
			$pdf->Cell(PDFHelper::pixels_to_MM(210),PDFHelper::points_to_MM(10),$this->chequeData->accountNumber__newFontWriteSTR() ,0,0,'L');
			
				/////////////////////////////////////////////////////////////////////////////////////////////////////////////
			
				//$tablePozX, $tablePozY, $tablePozWidth,
			
				/*Brojche gore desno*/
				$pdf->SetFont('helvetica','',12);
				$pozX = PDFHelper::pixels_to_MM($tablePozX + 130);
				$pozY = PDFHelper::pixels_to_MM($tablePozY + 0);
				$pdf->SetXY($pozX, $pozY);
				if($aha_8_ == 0)
			$pdf->Cell(PDFHelper::pixels_to_MM(100),PDFHelper::points_to_MM(10),$this->chequeData->startAtNumber() ,0,0,'R');
				else $pdf->Cell(PDFHelper::pixels_to_MM(100),PDFHelper::points_to_MM(10),$this->chequeData->startAtNumber_plus_1() ,0,0,'R');
			
				/*DATE*/
				$pdf->SetFont('helvetica','',7);
				$pozX = PDFHelper::pixels_to_MM($tablePozX + 0);
				$pozY = PDFHelper::pixels_to_MM($tablePozY + 0);
				$pdf->SetXY($pozX, $pozY);
				$pdf->Cell(PDFHelper::pixels_to_MM(300),PDFHelper::points_to_MM(10),'DATE',0,0,'L');
				/*Linija ispod DATE*/
				$pozX = PDFHelper::pixels_to_MM($tablePozX + 0);
				$pozY = PDFHelper::pixels_to_MM($tablePozY + 13);
				$helpWidth = PDFHelper::pixels_to_MM($tablePozWidth - 80) + $pozX;
			$pdf->Line($pozX,$pozY,$helpWidth,$pozY);
			
				/*TO*/
				$pdf->SetFont('helvetica','',7);
				$pozX = PDFHelper::pixels_to_MM($tablePozX + 0);
				$pozY = PDFHelper::pixels_to_MM($tablePozY + 20);
				$pdf->SetXY($pozX, $pozY);
				$pdf->Cell(PDFHelper::pixels_to_MM(300),PDFHelper::points_to_MM(10),'TO',0,0,'L');
				/*Linii ispod TO*/
				$pozX = PDFHelper::pixels_to_MM($tablePozX + 0);
				$pozY = PDFHelper::pixels_to_MM($tablePozY + 33);
				$helpWidth = PDFHelper::pixels_to_MM($tablePozWidth - 20) + $pozX;
			$pdf->Line($pozX,$pozY,$helpWidth,$pozY);
				$pozX = PDFHelper::pixels_to_MM($tablePozX + 0);
				$pozY = PDFHelper::pixels_to_MM($tablePozY + 53);
				$helpWidth = PDFHelper::pixels_to_MM($tablePozWidth - 20) + $pozX;
			$pdf->Line($pozX,$pozY,$helpWidth,$pozY);
			
				/*FOR*/
				$pdf->SetFont('helvetica','',7);
				$pozX = PDFHelper::pixels_to_MM($tablePozX + 0);
				$pozY = PDFHelper::pixels_to_MM($tablePozY + 60);
				$pdf->SetXY($pozX, $pozY);
				$pdf->Cell(PDFHelper::pixels_to_MM(300),PDFHelper::points_to_MM(10),'FOR',0,0,'L');
				/*line*/
				$pozX = PDFHelper::pixels_to_MM($tablePozX + 0);
				$pozY = PDFHelper::pixels_to_MM($tablePozY + 73);
				$helpWidth = PDFHelper::pixels_to_MM($tablePozWidth - 20) + $pozX;
			$pdf->Line($pozX,$pozY,$helpWidth,$pozY);
			
				/*Linija na sredina od pravoagolnikot*/
				$pozX = PDFHelper::pixels_to_MM($tablePozX + 80);
				$pozY = PDFHelper::pixels_to_MM($tablePozY + 100);
			$pdf->Line($pozX,$pozY,$pozX,$pozY + PDFHelper::pixels_to_MM(75));
			
				/*PST Amount*/
				$pdf->SetFillColor(255,255,255);
				$pdf->SetFont('helvetica','',7);
				$pozX = PDFHelper::pixels_to_MM($tablePozX + 25);
				$pozY = PDFHelper::pixels_to_MM($tablePozY + 102);
				$pdf->SetXY($pozX, $pozY);
				$pdf->Cell(PDFHelper::pixels_to_MM(120),PDFHelper::points_to_MM(10),'PST AMOUNT',0,0,'L',1);
			
				/*GST AMOUNT*/
				$pdf->SetFont('helvetica','',7);
				$pozX = PDFHelper::pixels_to_MM($tablePozX + 15);
				$pozY = PDFHelper::pixels_to_MM($tablePozY + 127);
				$pdf->SetXY($pozX, $pozY);
				$pdf->Cell(PDFHelper::pixels_to_MM(120),PDFHelper::points_to_MM(10),'GST/HST AMOUNT',0,0,'L',1);
			
				/*GST/HST NO.*/
				$pdf->SetFont('helvetica','',7);
				$pozX = PDFHelper::pixels_to_MM($tablePozX + 25);
				$pozY = PDFHelper::pixels_to_MM($tablePozY + 152);
				$pdf->SetXY($pozX, $pozY);
				$pdf->Cell(PDFHelper::pixels_to_MM(120),PDFHelper::points_to_MM(10),'GST/HST NO.',0,0,'L',1);
			
				/*Linija na srede od rectangle*/
				$pozX = PDFHelper::pixels_to_MM($tablePozX + 0);
				$pozY = PDFHelper::pixels_to_MM($tablePozY + 125);
				$helpWidth = PDFHelper::pixels_to_MM(110) + $pozX;
			$pdf->Line($pozX,$pozY,$helpWidth,$pozY);
				$pozX = PDFHelper::pixels_to_MM($tablePozX + 0);
				$pozY = PDFHelper::pixels_to_MM($tablePozY + 150);
				$helpWidth = PDFHelper::pixels_to_MM(110) + $pozX;
			$pdf->Line($pozX,$pozY,$helpWidth,$pozY);
			
				/*Rectangle*/
				$pozX = PDFHelper::pixels_to_MM($tablePozX + 0);
				$pozY = PDFHelper::pixels_to_MM($tablePozY + 100);
				$this->drawRectangle($pdf,2,$pozX,$pozY,PDFHelper::pixels_to_MM(110),PDFHelper::pixels_to_MM(77));
			
				/*GST/HST NO.*/
				$pdf->SetFont('helvetica','',5);
				$pozX = PDFHelper::pixels_to_MM($tablePozX + 110);
				$pozY = PDFHelper::pixels_to_MM($tablePozY + 100);
				$pdf->SetXY($pozX, $pozY);
				$pdf->Cell(PDFHelper::pixels_to_MM(300),PDFHelper::points_to_MM(10),'BALANCE',0,0,'L');
				$pozX = PDFHelper::pixels_to_MM($tablePozX + 110);
				$pozY = PDFHelper::pixels_to_MM($tablePozY + 107);
				$pdf->SetXY($pozX, $pozY);
				$pdf->Cell(PDFHelper::pixels_to_MM(300),PDFHelper::points_to_MM(10),'FORWARD',0,0,'L');
			
				/*THIS<br />CHEQUE*/
				$pdf->SetFont('helvetica','',5);
				$pozX = PDFHelper::pixels_to_MM($tablePozX + 112);
				$pozY = PDFHelper::pixels_to_MM($tablePozY + 121);
				$pdf->SetXY($pozX, $pozY);
				$pdf->Cell(PDFHelper::pixels_to_MM(300),PDFHelper::points_to_MM(10),'THIS',0,0,'L');
				$pozX = PDFHelper::pixels_to_MM($tablePozX + 112);
				$pozY = PDFHelper::pixels_to_MM($tablePozY + 128);
				$pdf->SetXY($pozX, $pozY);
				$pdf->Cell(PDFHelper::pixels_to_MM(300),PDFHelper::points_to_MM(10),'CHEQUE',0,0,'L');
			
				/*DEPOSIT*/
				$pdf->SetFont('helvetica','',5);
				$pozX = PDFHelper::pixels_to_MM($tablePozX + 112);
				$pozY = PDFHelper::pixels_to_MM($tablePozY + 142);
				$pdf->SetXY($pozX, $pozY);
				$pdf->Cell(PDFHelper::pixels_to_MM(300),PDFHelper::points_to_MM(10),'DEPOSIT',0,0,'L');
			
				/*DEPOSIT*/
				$pdf->SetFont('helvetica','',5);
				$pozX = PDFHelper::pixels_to_MM($tablePozX + 112);
				$pozY = PDFHelper::pixels_to_MM($tablePozY + 161);
				$pdf->SetXY($pozX, $pozY);
				$pdf->Cell(PDFHelper::pixels_to_MM(300),PDFHelper::points_to_MM(10),'DEPOSIT',0,0,'L');
			
				/*OTHER*/
				$pdf->SetFont('helvetica','',5);
				$pozX = PDFHelper::pixels_to_MM($tablePozX + 113);
				$pozY = PDFHelper::pixels_to_MM($tablePozY + 179);
				$pdf->SetXY($pozX, $pozY);
				$pdf->Cell(PDFHelper::pixels_to_MM(300),PDFHelper::points_to_MM(10),'OTHER',0,0,'L');
			
				/*OTHER*/
				$pdf->SetFont('helvetica','',5);
				$pozX = PDFHelper::pixels_to_MM($tablePozX + 113);
				$pozY = PDFHelper::pixels_to_MM($tablePozY + 200);
				$pdf->SetXY($pozX, $pozY);
				$pdf->Cell(PDFHelper::pixels_to_MM(300),PDFHelper::points_to_MM(10),'OTHER',0,0,'L');
			
				/*tzo lines*/
				$pdf->SetLineWidth( PDFHelper::pixels_to_MM(2) );
				$pozX = PDFHelper::pixels_to_MM($tablePozX + 112);
				$pozY = PDFHelper::pixels_to_MM($tablePozY + 100);
				$helpWidth = PDFHelper::pixels_to_MM($tablePozWidth - 135) + $pozX;
			$pdf->Line($pozX,$pozY,$helpWidth,$pozY);
				$pozX = PDFHelper::pixels_to_MM($tablePozX + 112);
				$pozY = PDFHelper::pixels_to_MM($tablePozY + 118.5);
				$helpWidth = PDFHelper::pixels_to_MM($tablePozWidth - 135) + $pozX;
			$pdf->Line($pozX,$pozY,$helpWidth,$pozY);
			
				/*sledna linija*/
				$pdf->SetLineWidth( PDFHelper::pixels_to_MM(1) );
				$pozX = PDFHelper::pixels_to_MM($tablePozX + 109);
				$pozY = PDFHelper::pixels_to_MM($tablePozY + 139.5);
				$helpWidth = PDFHelper::pixels_to_MM($tablePozWidth - 132) + $pozX;
			$pdf->Line($pozX,$pozY,$helpWidth,$pozY);
			
				/*sledna linija*/
				$pdf->SetLineWidth( PDFHelper::pixels_to_MM(1) );
				$pozX = PDFHelper::pixels_to_MM($tablePozX + 109);
				$pozY = PDFHelper::pixels_to_MM($tablePozY + 158.5);
				$helpWidth = PDFHelper::pixels_to_MM($tablePozWidth - 132) + $pozX;
			$pdf->Line($pozX,$pozY,$helpWidth,$pozY);
			
				/*sledna linija*/
				$pdf->SetLineWidth( PDFHelper::pixels_to_MM(1) );
				$pozX = PDFHelper::pixels_to_MM($tablePozX + 0);
				$pozY = PDFHelper::pixels_to_MM($tablePozY + 177);
				$helpWidth = PDFHelper::pixels_to_MM($tablePozWidth - 23) + $pozX;
			$pdf->Line($pozX,$pozY,$helpWidth,$pozY);
			
				/*sledna linija*/
				$pdf->SetLineWidth( PDFHelper::pixels_to_MM(2) );
				$pozX = PDFHelper::pixels_to_MM($tablePozX + 112);
				$pozY = PDFHelper::pixels_to_MM($tablePozY + 195.5);
				$helpWidth = PDFHelper::pixels_to_MM($tablePozWidth - 135) + $pozX;
			$pdf->Line($pozX,$pozY,$helpWidth,$pozY);
			
				/*sledna linija*/
				$pdf->SetLineWidth( PDFHelper::pixels_to_MM(2) );
				$pozX = PDFHelper::pixels_to_MM($tablePozX + 112);
				$pozY = PDFHelper::pixels_to_MM($tablePozY + 214);
				$helpWidth = PDFHelper::pixels_to_MM($tablePozWidth - 135) + $pozX;
			$pdf->Line($pozX,$pozY,$helpWidth,$pozY);
			
				/*Rect prva i vtora linija*/
				$pdf->SetLineWidth( PDFHelper::pixels_to_MM(1) );
				$pozX = PDFHelper::pixels_to_MM($tablePozX + 150);
				$pozY = PDFHelper::pixels_to_MM($tablePozY + 100);
				$helpWidth = PDFHelper::pixels_to_MM($tablePozWidth - 23) + $pozX;
			$pdf->Line($pozX,$pozY,PDFHelper::pixels_to_MM(60) + $pozX,$pozY);
				$pdf->SetLineWidth( PDFHelper::pixels_to_MM(1) );
				$pozX = PDFHelper::pixels_to_MM($tablePozX + 150);
				$pozY = PDFHelper::pixels_to_MM($tablePozY + 213);
				$helpWidth = PDFHelper::pixels_to_MM($tablePozWidth - 23) + $pozX;
			$pdf->Line($pozX,$pozY,PDFHelper::pixels_to_MM(60) + $pozX,$pozY);
			
				/*Rectangle*/
				$pozX = PDFHelper::pixels_to_MM($tablePozX + 110);
				$pozY = PDFHelper::pixels_to_MM($tablePozY + 100);
				$this->drawRectangle($pdf,2,$pozX,$pozY,PDFHelper::pixels_to_MM(40),PDFHelper::pixels_to_MM(114));
		}
		function drawRectangle($PDF,$lineWidth,$pozX,$pozY,$width,$height)
		{
			$PDF->SetLineWidth( PDFHelper::pixels_to_MM($lineWidth) );
			$PDF->Rect($pozX,$pozY,$width,$height);
		}
		public function PDFContent()
		{
			if($this->outPutTOSErver != NULL){return $this->outPutTOSErver;}
			$this->outPutTOSErver = $this->pdf->Output($this->fileName, "S");
			return $this->outPutTOSErver;
		}
		public function saveToLocal($PDFName)
		{
			$this->pdf->Output($PDFName, "");
		}
	}
//Test code

/*if(!class_exists("XMLParser")){require_once("tools.php");}
	require_once('Mail.php');
	require_once('Mail/mime.php');
	require_once("pdf-tools/fpdf.php");
	require_once("pdf-tools/pdf-helper.php");
	require_once("mail_message_template.php");
	require_once("backupmessage.php");
	XMLParser::ADD_ORDER_XML_TO_POST( "orders/M3014.xml" );
	$objCheque = new Cheque( $_POST["chequeType"] );
	$objChequeData = new ChequeData( $objCheque );
	$objOrderForm = new CHEQUE_TEMPLATE($objChequeData, $objCheque);
	$objOrderForm->saveToLocal( "manual-testing.pdf" );*/
	
	
?>