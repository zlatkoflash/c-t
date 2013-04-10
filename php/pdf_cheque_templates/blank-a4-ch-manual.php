<?php
	//////////////////////////////////////////////////////////////////
	//////BlankA4Cheque
	//////////////////////////////////////////////////////////////////
	class BlankA4Cheque
	{
		var $pdf,
			$fileName = "cheque-proof.pdf",
			$outPutTOSErver=NULL,
			$iMReorderForm = false,
			$iMForCheque = false;
		var $chequeData;
		var $border = 0;
		const PLUS_Y_FOR_BOTTOM=82.5;
		const PLUS_Y_FOR_TOP=-0.2;
                private  $before_testing_folder;

                public function BlankA4Cheque( $chequeData____, $__iMReorderForm___=false, $iMForCheque___=false, $before_testing_folder=""  )
		{
			$this->before_testing_folder = $before_testing_folder;
			$this->chequeData = $chequeData____;
			$this->iMReorderForm = $__iMReorderForm___;
			$this->iMForCheque = $iMForCheque___;
			if($this->iMReorderForm == true)
			{
				$this->fileName = "red-order-form.pdf";
			}
			
			//$this->pdf = new FPDF('L','mm','Letter');//11x8.5 inches
			if($this->chequeData->chequePosition()=="false" && $this->iMForCheque==true)
			{
				$this->pdf=new FPDF('P','mm',array(279.4,82.55));//3.25x11
			}
			else
			{
				$this->pdf=new FPDF('P','mm',array(279.4,165.1));//6.5x11
			}
			$this->pdf->AddFont("helvetica_bold", "", $this->before_testing_folder."../fonts/helvetica-bold/fpdf/3c41c8e6600e41512cbd6a118d2bdf41_helvetica_bold.php");
			$this->pdf->AddFont("helvetica", "", $this->before_testing_folder."../fonts/helvetica/fpdf/25e75292757c3eb4bba8a3ddd4e8fe3f_helvetica_lt.php");
			$this->pdf->AddFont("newFont","",$this->before_testing_folder."../fonts/micr/fpdf/f30e76a7a57ca16aaf2424921d10f4da_micr___.php");
			$this->pdf->SetDisplayMode(real,'default');//with this i can not do fill\
			$this->pdf->SetAutoPageBreak(false);
			$this->pdf->AddPage();
			
			if($this->iMForCheque==true)
			{
				$this->addBgImages();
			}
			/////////////////////////////////////////////////////////////////////////////////////////////////////////
			/////////////////////////////////////////////////////////////////////////////////////////////////////////
			/////////////////////////////////////////////////////////////////////////////////////////////////////////
			else if($this->iMReorderForm == true)
			{
				$this->addBGReorder();
				
				$this->pdf->SetXY(122, 73.2);
				$this->pdf->SetFont("helvetica_bold", "", 12);
				$this->pdf->MultiCell(100,50,Product::$QUANTITY_AND_PRICES->quantity,$this->border,"C");
			}
			/////////////////////////////////////////////////////////////////////////////////////////////////////////
			/////////////////////////////////////////////////////////////////////////////////////////////////////////
			/////////////////////////////////////////////////////////////////////////////////////////////////////////
			
			$this->addPinkBGLabel();
			
			//$pdfcontent = $this->pdf->Output($this->fileName, "S");//is done into function for getting pdf content
			//$pdfcontent = $this->pdf->Output("ch-manual-testing.pdf", "");//local
		}
		/*
		*/
		///////////////////////////////////////////////////////////////////////////////////////
		/////////Odish po red prijatele uredno i si proveruvash.
		///////////////////////////////////////////////////////////////////////////////////////
		function addPinkBGLabel()
		{
			$this->pdf->SetDrawColor(0,0,0);
			$startY=-7.0;
			
			///////////////////////////////////////////////////////////////////////////////////////////////
			///////////////////////////////////////////////////////////////////////////////////////////////
			///////////////////////////////////////////////////////////////////////////////////////////////
			$this->LEFT_BLOCK( false, $startY );
			$this->RIGHT_BLOCK( false, $startY );
			if($this->iMReorderForm == true && $this->iMForCheque==false)
			{
				//$this->addBGReorder();
				//return;
			}
			else
			{
				$this->LEFT_BLOCK( true, $startY );
				$this->RIGHT_BLOCK( true, $startY );
			}
			///////////////////////////////////////////////////////////////////////////////////////////////
			///////////////////////////////////////////////////////////////////////////////////////////////
			///////////////////////////////////////////////////////////////////////////////////////////////
			PDFHelper::draw_rect($this->pdf, 93.5,89.3+$startY,1.5,0,0.7);//mala crticka
		}
		function drawLeftVerticalText( $plusYDistance )
		{
			//$this->pdf->SetTextColor(255,0,0);
			$this->pdf->SetFont('helvetica_bold','',5.8);
			$leftPosition = 5.0;
			/*for verical text new style*/
			$plusYDistance -= 7.1;
			$leftPosition = 9;
			$this->pdf->TextWithRotation($leftPosition,67.0+$plusYDistance,"PRINT AND CHEQUES", 90, 0);
			$this->pdf->TextWithRotation($leftPosition+2.5,61+$plusYDistance,"NOW INC.", 90, 0);
			$this->pdf->TextWithRotation($leftPosition,36.5+$plusYDistance,"CALL TO RE-ORDER", 90, 0);
			$this->pdf->TextWithRotation($leftPosition+2.5,34+$plusYDistance,"1-866-760-2661", 90, 0);
			
			//$this->pdf->TextWithRotation($leftPosition,69.0+$plusYDistance,"PRINT AND CHEQUES NOW INC.  CALL TO RE-ORDER 1-866-760-2661", 90, 0);
		}
		function addBGReorder()
		{
			$this->pdf->Image("manual_reorder_form.jpg", 0, 0, 280);
		}
		function addBgImages()
		{
			$startY = 0;
			$this->pdf->Image($this->before_testing_folder.$this->chequeData->backgroundURLForOrder(), 0, 0, 280);
			/*
			$this->pdf->Image($this->chequeData->backgroundURL(), 101, 4+$startY, 175);
			$this->pdf->Image($this->chequeData->backgroundURL(), 101, 86+$startY, 175);
			*/
		}
		function addCompanyNameOnCenter($isBottom)
		{
			$plusY=11.5;
			if($isBottom == true)
			{
				$pozYFor = self::PLUS_Y_FOR_BOTTOM+$plusY;
			}
			else
			{
				$pozYFor = self::PLUS_Y_FOR_TOP+$plusY;
			}
			$compINfoXPosition=100;
			$compINfoWIDTH = 112;
			if($this->chequeData->CINACompanySecondName() == "")
			{
				$plusYForMe = 2;
				$this->pdf->SetXY($compINfoXPosition, $pozYFor-5+$plusYForMe);
				$this->pdf->SetFont("helvetica_bold", "", 10);
				$this->pdf->MultiCell($compINfoWIDTH,PDFHelper::points_to_MM(12),$this->chequeData->CINACompanyName(),$this->border,"C");
				
				$this->pdf->SetXY($compINfoXPosition, $pozYFor+$plusYForMe);
				$this->pdf->SetFont("helvetica", "", 8);
				$this->pdf->MultiCell($compINfoWIDTH,2.8,$this->chequeData->compInfoAddressLine1()."\n".$this->chequeData->compInfoAddressLine2()."\n".$this->chequeData->compInfoAddressLine3()."\n".$this->chequeData->compInfoAddressLine4(),$this->border,"C");
			}
			else if($this->chequeData->CINACompanySecondName() != "")
			{
				$plusYForMe=0;
				$this->pdf->SetXY($compINfoXPosition, $pozYFor-5.2);
				$this->pdf->SetFont("helvetica_bold", "", 10);
				$this->pdf->MultiCell($compINfoWIDTH,PDFHelper::points_to_MM(12),$this->chequeData->CINACompanyName(),$this->border,"C");
				$this->pdf->SetFont('helvetica_bold','',10);
				$this->pdf->SetXY($compINfoXPosition, $pozYFor-1.7); 
				$this->pdf->MultiCell($compINfoWIDTH,PDFHelper::points_to_MM(12),$this->chequeData->CINACompanySecondName()."",$this->border,"C");
				
				$this->pdf->SetXY($compINfoXPosition, $pozYFor+3.0);
				$this->pdf->SetFont("helvetica", "", 8);
				$this->pdf->MultiCell($compINfoWIDTH,2.8,$this->chequeData->compInfoAddressLine1()."\n".$this->chequeData->compInfoAddressLine2()."\n".$this->chequeData->compInfoAddressLine3()."\n".$this->chequeData->compInfoAddressLine4(),$this->border,"C");
			}
			
			$plusYForBottomNames = 35.5;
			$leftPosition = 193;
			$plusXSetting=0;
			$plusYWhenSecondSignature = 0;
			if($this->chequeData->thereIsSecondSignature() == true)
			{
				$plusYWhenSecondSignature = -1.5;
			}
			$cellLineHeight = 2;
			if($this->chequeData->CINACompanySecondName() != "")
			{	
				$this->pdf->SetFont("helvetica_bold", "", 6.75);
				$this->pdf->SetXY($leftPosition+$plusXSetting, $pozYFor+$plusYForBottomNames+$plusYWhenSecondSignature);
				$this->pdf->MultiCell(PDFHelper::pixels_to_MM(340),$cellLineHeight,$this->chequeData->CINACompanyName(),$this->border,"C");
				
				$this->pdf->SetFont('helvetica_bold','',6.75);
				$this->pdf->SetXY($leftPosition+$plusXSetting, $pozYFor+$plusYForBottomNames+2.5+$plusYWhenSecondSignature); 
				$this->pdf->MultiCell(PDFHelper::pixels_to_MM(340),$cellLineHeight,$this->chequeData->CINACompanySecondName(),$this->border,"C");
			}
			else
			{
				$this->pdf->SetXY($leftPosition, $pozYFor+$plusYForBottomNames+0.0);
				$this->pdf->SetFont("helvetica_bold", "", 6.75);
				$this->pdf->MultiCell(PDFHelper::pixels_to_MM(340),$cellLineHeight,$this->chequeData->CINACompanyName(),$this->border,"C");
			}
		}
		function drawBankDetails( $isBottom )
		{
			$pozYPLus = 45.5;
			if($isBottom==true)
			{
				$pozYPlus = self::PLUS_Y_FOR_BOTTOM+$pozYPLus;
			}
			else
			{
				$pozYPlus = self::PLUS_Y_FOR_TOP+$pozYPLus;
			}
			$posLeft = 103;
			$this->pdf->SetXY($posLeft, $pozYPlus);
			$this->pdf->SetFont("helvetica_bold", "", 7);
			$this->pdf->MultiCell(PDFHelper::pixels_to_MM(340),PDFHelper::points_to_MM(7),$this->chequeData->compInfoBankName(),$this->border,"L");
			$this->pdf->SetXY($posLeft, $pozYPlus+2.5);
			$this->pdf->SetFont("helvetica", "", 6.5);
			$this->pdf->MultiCell(PDFHelper::pixels_to_MM(340),2.5,$this->chequeData->compInfoBankAddress1()."\n".$this->chequeData->compInfoBankAddress2()."\n".$this->chequeData->compInfoBankAddress3()."\n".$this->chequeData->compInfoBankAddress4(),$this->border,"L");
		}
		function LEFT_BLOCK( $isBottom, $startY )
		{
			if($isBottom==true)
			{
				$plusYForAdding = self::PLUS_Y_FOR_BOTTOM;
			}
			else
			{
				$plusYForAdding = self::PLUS_Y_FOR_TOP;
			}
			
			$this->pdf->SetXY(15.5, 15.3+$startY+$plusYForAdding);
			$this->pdf->SetFont("helvetica", "", 7);
			$this->pdf->MultiCell(300,1,"DATE",0,"L");
			$this->pdf->SetXY(15.5, 22+$startY+$plusYForAdding);
			$this->pdf->SetFont("helvetica", "", 7);
			$this->pdf->MultiCell(300,1,"TO",0,"L");
			$this->pdf->SetXY(15.5, 35.3+$startY+$plusYForAdding);
			$this->pdf->SetFont("helvetica", "", 7);
			$this->pdf->MultiCell(300,1,"FOR",$this->border,"L");
			$this->pdf->SetXY(21, 45.5+$startY+$plusYForAdding);
			$this->pdf->SetFont("helvetica", "", 7);
			$this->pdf->MultiCell(300,1,"PST AMOUNT",$this->border,"L");
			$this->pdf->SetXY(17.5, 54.5+$startY+$plusYForAdding);
			$this->pdf->SetFont("helvetica", "", 7);
			$this->pdf->MultiCell(300,1,"GST / HST AMOUNT",$this->border,"L");
			$this->pdf->SetXY(20.7, 63+$startY+$plusYForAdding);
			$this->pdf->SetFont("helvetica", "", 7);
			$this->pdf->MultiCell(300,1,"GST / HST NO.",$this->border,"L");
			$this->pdf->SetXY(30.2, 45.5+$startY+$plusYForAdding);
			$this->pdf->SetFont("helvetica_bold", "", 7);
			$this->pdf->MultiCell(40,2.5,"BALANCE\nFORWARD",$this->border,"C");
			$this->pdf->SetXY(30.2, 51.5+$startY+$plusYForAdding);
			$this->pdf->SetFont("helvetica", "", 7);
			$this->pdf->MultiCell(40,2.8,"THIS\nCHEQUE",$this->border,"C");
			$this->pdf->SetXY(30.2, 60+$startY+$plusYForAdding);
			$this->pdf->SetFont("helvetica", "", 7);
			$this->pdf->MultiCell(40,2.5,"DEPOSIT",$this->border,"C");
			$this->pdf->SetXY(30.2, 66.7+$startY+$plusYForAdding);
			$this->pdf->SetFont("helvetica", "", 7);
			$this->pdf->MultiCell(40,2.5,"DEPOSIT",$this->border,"C");
			$this->pdf->SetXY(30.2, 73.3+$startY+$plusYForAdding);
			$this->pdf->SetFont("helvetica", "", 7);
			$this->pdf->MultiCell(40,2.5,"OTHER",$this->border,"C");
			$this->pdf->SetXY(30.2, 79.8+$startY+$plusYForAdding);
			$this->pdf->SetFont("helvetica_bold", "", 7);
			$this->pdf->MultiCell(40,2.5,"BALANCE",$this->border,"C");
			
			$this->drawLeftVerticalText( $startY+15+$plusYForAdding );
			
			PDFHelper::draw_rect($this->pdf, 16.5,17.5+$startY+$plusYForAdding,54,0,0.7);
			PDFHelper::draw_rect($this->pdf, 16.5,24+$startY+$plusYForAdding,76,0,0.7);
			PDFHelper::draw_rect($this->pdf, 16.5,30.5+$startY+$plusYForAdding,76,0,0.7);
			PDFHelper::draw_rect($this->pdf, 16.5,37+$startY+$plusYForAdding,76,0,0.7);
			PDFHelper::draw_rect($this->pdf, 16.5,43+$startY+$plusYForAdding,76,0,0.7);
			PDFHelper::draw_rect($this->pdf, 17,44.5+$startY+$plusYForAdding,26.5,26.5,1.5);
			PDFHelper::draw_rect($this->pdf, 43.5,44.5+$startY+$plusYForAdding,13.5,40,1.5);
			PDFHelper::draw_rect($this->pdf, 17,44.5+$startY+$plusYForAdding,75.5,0,1.5);
			PDFHelper::draw_rect($this->pdf, 43.5,51+$startY+$plusYForAdding,49,0,1.5);
			PDFHelper::draw_rect($this->pdf, 43.5,57.5+$startY+$plusYForAdding,49,0,0.7);
			PDFHelper::draw_rect($this->pdf, 43.5,64.5+$startY+$plusYForAdding,49,0,0.7);
			PDFHelper::draw_rect($this->pdf, 43.5,71+$startY+$plusYForAdding,49,0,0.7);
			PDFHelper::draw_rect($this->pdf, 43.5,77.5+$startY+$plusYForAdding,49,0,1.5);
			PDFHelper::draw_rect($this->pdf, 43.5,84.5+$startY+$plusYForAdding,49,0,1.5);
			PDFHelper::draw_rect($this->pdf, 81.5,44.5+$startY+$plusYForAdding,0,40,0.7);
			PDFHelper::draw_rect($this->pdf, 17,53.5+$startY+$plusYForAdding,26.5,0,0.7);
			PDFHelper::draw_rect($this->pdf, 17,62+$startY+$plusYForAdding,26.5,0,0.7);
			PDFHelper::draw_rect($this->pdf, 35.5,47.5+$startY+$plusYForAdding,0,6,0.7);
			PDFHelper::draw_rect($this->pdf, 35.5,56+$startY+$plusYForAdding,0,6,0.7);
		}
		function RIGHT_BLOCK( $isBottom, $startY )
		{
			if($isBottom==true)
			{
				$plusYForAdding = self::PLUS_Y_FOR_BOTTOM;
			}
			else
			{
				$plusYForAdding = self::PLUS_Y_FOR_TOP;
			}
			$plus_plus_comapanyNameAnd4Lines=5.5;
			$this->addCompanyNameOnCenter( $isBottom );
			
			$this->drawBankDetails( $isBottom );
			
			$posYBottomForPER = 66.5;
			//$posYBottomForPER = 0;
			$plusPOsitionFOR____PER = 2;
			$this->pdf->SetXY(PDFHelper::pixels_to_MM(388), $posYBottomForPER+$startY+$plusYForAdding+$plusPOsitionFOR____PER);
			$this->pdf->SetFont("helvetica", "", 7);
			$this->pdf->MultiCell(PDFHelper::pixels_to_MM(340),PDFHelper::points_to_MM(7),"FOR ___________________________________________________",$this->border,"L");
			if($this->chequeData->thereIsSecondSignature() == true)
			{
				$this->pdf->SetXY(PDFHelper::pixels_to_MM(755), PDFHelper::pixels_to_MM(227.5)+$startY+$plusYForAdding+$plusPOsitionFOR____PER);
				$this->pdf->SetFont("helvetica", "", 7);
				$this->pdf->MultiCell(PDFHelper::pixels_to_MM(340),PDFHelper::points_to_MM(7),"PER _________________________________________________",$this->border,"L");
			}
			$this->pdf->SetXY(PDFHelper::pixels_to_MM(755), $posYBottomForPER+$startY+$plusYForAdding+$plusPOsitionFOR____PER);
			$this->pdf->SetFont("helvetica", "", 7);
			$this->pdf->MultiCell(PDFHelper::pixels_to_MM(340),PDFHelper::points_to_MM(7),"PER _________________________________________________",$this->border,"L");
			
			if($this->chequeData->thereIsSecondSignature() == true)
			{
				$plusYPOsicionForCompanyNameWHenWeHaveSecondLine = 0;
			}
			else
			{
				$plusYPOsicionForCompanyNameWHenWeHaveSecondLine = 1;
			}
			/**/
			$this->pdf->SetXY(PDFHelper::pixels_to_MM(876), PDFHelper::pixels_to_MM(183)+$startY+$plusYForAdding);
			$this->pdf->SetFont("helvetica", "", 9);
			$this->pdf->MultiCell(PDFHelper::pixels_to_MM(340),PDFHelper::points_to_MM(9),"  100 DOLLARS",$this->border,"L");
			$this->pdf->SetXY(PDFHelper::pixels_to_MM(387), PDFHelper::pixels_to_MM(162)+$startY+$plusYForAdding);
			$this->pdf->SetFont("helvetica", "", 7);
			$this->pdf->MultiCell(PDFHelper::pixels_to_MM(340),PDFHelper::points_to_MM(7),"the order of",$this->border,"L");
			$this->pdf->SetXY(PDFHelper::pixels_to_MM(386), 39+$startY+$plusYForAdding);
			$this->pdf->SetFont("helvetica_bold", "", 10);
			$this->pdf->MultiCell(PDFHelper::pixels_to_MM(340),PDFHelper::points_to_MM(10),"PAY",$this->border,"L");
			$this->pdf->SetXY(PDFHelper::pixels_to_MM(415), PDFHelper::pixels_to_MM(152)+$startY+$plusYForAdding);
			$this->pdf->SetFont("helvetica", "", 7);
			$this->pdf->MultiCell(PDFHelper::pixels_to_MM(340),PDFHelper::points_to_MM(7),"to",$this->border,"L");
			
			
			$this->pdf->SetFont("newFont", "", 12);
			$this->addAccountsNumbers( $isBottom );
			
			if($this->chequeData->isCurrency() == true)
			{
				//US FUNDS
				$this->pdf->SetFont('helvetica_bold','',7);
				$this->pdf->SetXY(257, 40.5+$plusYForAdding);
				$this->pdf->Cell(PDFHelper::pixels_to_MM(60),PDFHelper::points_to_MM(10),$this->chequeData->us_funds_label(),0,$this->border,'C');
			}
			/**/
			//$this->pdf->Line(118.5+114,42.5+$startY+$plusYForAdding,118.5+114,42.5+$startY+$plusYForAdding-4);
			$this->pdf->Line(114,42.0+$startY+$plusYForAdding,118.5+114,42.0+$startY+$plusYForAdding);
			$this->pdf->Line(118.5+114,42+$startY+$plusYForAdding,118.5+114,39.0+$startY+$plusYForAdding);
			//PDFHelper::draw_rect($this->pdf, 114,42.5+$startY+$plusYForAdding,118.5,0,0.7);
			//PDFHelper::draw_rect($this->pdf, 232.5,38+$startY+$plusYForAdding,0,4.7,0.7);
			//PDFHelper::draw_rect($this->pdf, 104,51+$startY+$plusYForAdding,127,0,0.7);
			$this->pdf->Line(104.0,51+$startY+$plusYForAdding,118.5+114,51+$startY+$plusYForAdding);
			$this->pdf->Line(233,51+$startY+$plusYForAdding,235,48.0+$startY+$plusYForAdding);
		}
		function addAccountsNumbers( $isBottom )
		{
			$minusY = 74.5;
			if($isBottom == true)
			{
				$pozPlusY = self::PLUS_Y_FOR_BOTTOM+$minusY;
			}
			else
			{
				$pozPlusY = self::PLUS_Y_FOR_TOP+$minusY;
			}
			$minusYWhen1ChequePerManual = 0;
			$minusXWhen1ChequePerManual = 0;
			if($this->chequeData->chequePosition() == "false")
			{
				$minusYWhen1ChequePerManual = -0.5;
				//$minusXWhen1ChequePerManual = -2;
			}
			$absYPositionNumbers = $pozPlusY+$minusYWhen1ChequePerManual-2;
			if($this->iMForCheque==true)
			{
				$this->pdf->SetXY(117.8+6+$minusXWhen1ChequePerManual, $absYPositionNumbers);
				$startAtNUmberForCheque = PDFHelper::get_startAtN($this->chequeData->startAtNumber());
				if($isBottom != true)
				{
				}
				else
				{
					$startAtNUmberForCheque = PDFHelper::get_startAtN($this->chequeData->startAtNumber_plus_1());
				}
				$this->pdf->MultiCell(170,PDFHelper::points_to_MM(12), $startAtNUmberForCheque.
													  "   ".PDFHelper::get_branch_transit_Number($this->chequeData->brunchNumber(),$this->chequeData->transitNumber()).
													  "".$this->chequeData->accountNumber__newFontWriteSTR().
													  " ".$this->chequeData->currencyNumber45(),$this->border,"L");
			}
			else
			{
				$this->pdf->SetXY(129+6+$minusXWhen1ChequePerManual, $absYPositionNumbers);
				$this->pdf->MultiCell(110,PDFHelper::points_to_MM(12),
															PDFHelper::get_branch_transit_Number($this->chequeData->brunchNumber(),$this->chequeData->transitNumber()).
													  "".$this->chequeData->accountNumber__newFontWriteSTR().
													  " ".$this->chequeData->currencyNumber45(),$this->border,"L");
			}
			if($this->iMForCheque==true)
			{
				$this->pdf->SetFont("helvetica", "", 18);
				$this->pdf->SetXY(195, $pozPlusY-70);
				if($isBottom==false)
				{
					$this->pdf->MultiCell(80,PDFHelper::points_to_MM(20),$_POST["special_designation"]."  ".$this->chequeData->startAtNumber(),$this->border,"R");
				}
				else
				{
					$this->pdf->MultiCell(80,PDFHelper::points_to_MM(20),$_POST["special_designation"]."  ".$this->chequeData->startAtNumber_plus_1(),$this->border,"R");
				}
                                /*
                                 * For left side of the cheque
                                 */
				$this->pdf->SetFont("helvetica", "", 16);
				$this->pdf->SetXY(53, $pozPlusY-70);
				if($isBottom==false)
				{
					$this->pdf->MultiCell(40,PDFHelper::points_to_MM(20),$this->chequeData->startAtNumber(),$this->border,"R");
				}
				else
				{
					$this->pdf->MultiCell(40,PDFHelper::points_to_MM(20),$this->chequeData->startAtNumber_plus_1(),$this->border,"R");
				}
			}
		}
		////////////////////////////////////////////////////////////////////////////////////////
		public function PDFContent()
		{
			if($this->outPutTOSErver == NULL)
			$this->outPutTOSErver = $this->pdf->Output($this->fileName, "S");
			return $this->outPutTOSErver;
		}
		public function saveToLocal($PDFName)
		{
			$this->pdf->Output($PDFName, "");
		}
	}
        
        if(isset($_GET["DO_TEST"]))
        {
            /*
             * This is just for testing.
             */
            if(!class_exists("XMLParser")){require_once("../tools.php");}
            if(!class_exists("Product")){require_once("../products_moderator.php");}
            require_once("../pdf-tools/fpdf.php");
            require_once("../pdf-tools/pdf-helper.php");
            XMLParser::ADD_ORDER_XML_TO_POST( "../orders/xml/M5369.xml" );
            $objCheque = new Cheque( $_POST["chequeType"] );
            $objChequeData = new ChequeData( $objCheque );
            OrderNumber::$CURR_ORDER = new OrderNumber($objCheque, false, "M5369");
            $objOrderForm = new BlankA4Cheque($objChequeData, true, true, "../");
            $objOrderForm->saveToLocal( "blank-a4-ch-manual.pdf" );
        }

?>