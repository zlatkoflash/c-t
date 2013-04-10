<?php
	/*comment when u are testing online dzabe sum stavil komentari za tebe.....
	require_once("phptools/pdf-helper.php");
	require('fpdf.php');
         * pr, re, and other laser cheque templates.
         */
	//////////////////////////////////////////////////////////////////
	//////BlankA4Cheque
	//////////////////////////////////////////////////////////////////
	class BlankA4Cheque
	{
		var $pdf,
			$fileName = "blank-a4-ch.pdf",
			$outPutTOSErver=NULL,
			$iMReorderForm = false,
			$iMForCheque=false;
		var $chequeData;
		const IT_IS_CHEQUE="IT_IS_CHEQUE";
		var $PLUS_y=0;
		private $showBorder=0;
		var $before_testing_folder = "";
		
		public function BlankA4Cheque( $chequeData____, $__iMReorderForm___=false, $iMForCheque__=false, $before_testing_folder="" )
		{
			$this->before_testing_folder = $before_testing_folder;
			$this->chequeData = $chequeData____;
			$this->iMReorderForm = $__iMReorderForm___;
			$this->iMForCheque = $iMForCheque__;
			if($this->iMReorderForm == true)
			{
				$this->fileName = "red-order-form.pdf";
			}
			if($this->iMForCheque == true)
			{
				switch($this->chequeData->chequePosition())
				{
					case "1":{}break;
					case "2":{$this->PLUS_y=89;}break;
					case "3":{$this->PLUS_y=190;}break;
				}
				$this->fileName = "cheque.pdf";
			}
			if($this->iMReorderForm == false)
			{
				switch($this->chequeData->chequePosition())
				{
					case "1":{}break;
					case "2":{$this->PLUS_y=89;}break;
					case "3":{$this->PLUS_y=190;}break;
				}
			}
			if($this->iMReorderForm == true && $this->iMForCheque == false)
			{
				switch($this->chequeData->chequePosition())
				{
					case "1":{}break;
					case "2":{$this->PLUS_y=89;}break;
					case "3":{}break;
				}
			}
			$this->pdf = new FPDF('P','mm','Letter');
			$this->pdf->AddFont("helvetica_bold", "", $this->before_testing_folder."../fonts/helvetica-bold/fpdf/3c41c8e6600e41512cbd6a118d2bdf41_helvetica_bold.php");
			$this->pdf->AddFont("helvetica", "", $this->before_testing_folder."../fonts/helvetica/fpdf/25e75292757c3eb4bba8a3ddd4e8fe3f_helvetica_lt.php");
			$this->pdf->AddFont("newFont","",$this->before_testing_folder.'../fonts/micr/fpdf/f30e76a7a57ca16aaf2424921d10f4da_micr___.php');
			$this->pdf->SetDisplayMode(real,'default');//with this i can not do fill\
			$this->pdf->SetAutoPageBreak(false);
			$this->pdf->AddPage();
			if($this->iMForCheque == true)
			{
				$this->addImageBGForCheque();
			}
			$this->addReorderFormBG();
			$this->addPinkBGLabel();
			if($this->iMReorderForm == true)
			{
				$this->selectQuantity_show();
			}
			
			//$pdfcontent = $this->pdf->Output($this->fileName, "S");//is done into function for getting pdf content
			if($this->iMForCheque == true)
			{
				//$pdfcontent = $this->pdf->Output("test-cheque-new.pdf", "");//kreirash se odkomentirvish ova i probuvash D: ajde probaj
			}
			//$pdfcontent = $this->pdf->Output($this->fileName, "");//kreirash se odkomentirvish ova i probuvash D: ajde probaj
		}
		///////////////////////////////////////////////////////////////////////////////////////////
		////////Samo vo ovaa funkcija sreduvash, jas gi imam vneseno site formi i tekstovi a ti treba da gi sredish poziciite i da se poklopuvaat so
		////////SIMPLY - 2 SIG Line Pixel Measurements copy.pdf.jasno e? da.
		/////////go testirash ovaj fajl na server 
		///////////////////////////////////////////////////////////////////////////////////////////
		public function addReorderFormBG()
		{
			if($this->iMReorderForm == true)
			{
				if($this->chequeData->chequePosition()=="1")
				{
					$this->pdf->Image($this->before_testing_folder."blank re order form 300 dpi_temp_new.jpg", 0, 0, 215.9);
				}
				else if($this->chequeData->chequePosition()=="2")
				{
					$this->pdf->Image($this->before_testing_folder."middle-re-order.jpg", 0, 0, 215.9);
				}
				else
				{
					$this->pdf->Image($this->before_testing_folder."blank re order form 300 dpi.jpg", 0, 0, 215.9);
				}
			}
		}
		function addChequeNumber()
		{
			$this->pdf->SetFont("helvetica", "", 15);
			switch($this->chequeData->chequePosition())
			{
				case "1":
				{
			$this->pdf->SetXY(173, 8);
			$this->pdf->MultiCell(37,PDFHelper::points_to_MM(11),
														$_POST["special_designation"]."  ".$this->chequeData->startAtNumber() 
														,$this->showBorder,"R");
			$this->pdf->SetXY(173, 93);
			$this->pdf->MultiCell(37,PDFHelper::points_to_MM(11),
														$_POST["special_designation"]."  ".$this->chequeData->startAtNumber()
														,$this->showBorder,"R");
			
			$this->show_order_number_on_top();
												
			$this->pdf->SetFont("helvetica", "", 15);
			$this->pdf->SetXY(173, 183);
			$this->pdf->MultiCell(37,PDFHelper::points_to_MM(11),
														$_POST["special_designation"]."  ".$this->chequeData->startAtNumber() 
														,$this->showBorder,"R");
				}break;
				case "2":
				{
			$this->pdf->SetXY(173, 8);
			$this->pdf->MultiCell(37,PDFHelper::points_to_MM(11),
														$_POST["special_designation"]."  ".$this->chequeData->startAtNumber() 
														,$this->showBorder,"R");
			$this->pdf->SetXY(176, 96);
			$this->pdf->MultiCell(37,PDFHelper::points_to_MM(11),
														$_POST["special_designation"]."  ".$this->chequeData->startAtNumber() 
														,$this->showBorder,"R");
			$this->pdf->SetXY(173, 183);
			$this->pdf->MultiCell(37,PDFHelper::points_to_MM(11),
														$_POST["special_designation"]."  ".$this->chequeData->startAtNumber() 
														,$this->showBorder,"R");
				}break;
				case "3":
				{
			$this->pdf->SetXY(173, 8);
			$this->pdf->MultiCell(37,PDFHelper::points_to_MM(11),
														$_POST["special_designation"]."  ".$this->chequeData->startAtNumber() 
														,$this->showBorder,"R");
			$this->pdf->SetXY(173, 105);
			$this->pdf->MultiCell(37,PDFHelper::points_to_MM(11),
														$_POST["special_designation"]."  ".$this->chequeData->startAtNumber() 
														,$this->showBorder,"R");
			$this->pdf->SetXY(173, 198);
			$this->pdf->MultiCell(37,PDFHelper::points_to_MM(11),
														$_POST["special_designation"]."  ".$this->chequeData->startAtNumber() 
														,$this->showBorder,"R");
				}break;
			}
		}
		private  function  show_order_number_on_top()
		{
			if($this->iMForCheque && !$this->iMReorderForm){return;}
			$this->pdf->SetFont("helvetica", "", 12);
			$this->pdf->SetXY(178.5, 104.5);
			$this->pdf->MultiCell(37,5,
														OrderNumber::$CURR_ORDER->orderLabel_withPower()
														,$this->showBorder,"C");
		}
		function addPinkBGLabel()
		{
			//PDFHelper::rect_fill($this->pdf, 82, 33, 340, 80,array(253,204,183));
			//PDFHelper::drawText();
			$compnay_x4_lines =  		 $this->chequeData->compInfoAddressLine1()."\n".
									     $this->chequeData->compInfoAddressLine2()."\n".
										 $this->chequeData->compInfoAddressLine3()."\n".
										 $this->chequeData->compInfoAddressLine4();
			$BoldTexts = explode("\n", $this->chequeData->CINACompanyName());
			$heightBoldTexts = count($BoldTexts)*11;
			$normalTexts = explode("\n", $compnay_x4_lines);
			$hieghtNormalTexts = count($normalTexts)*8;
			//$startYPinkTekst = (80-($heightBoldTexts+$hieghtNormalTexts))/2;//za vo sredina na pink box
			$startYPinkTekst = 10;
			$this->pdf->SetXY(5, PDFHelper::pixels_to_MM(26+$startYPinkTekst)+$this->PLUS_y);
			$this->pdf->SetFont("helvetica_bold", "", 9);
			$this->pdf->MultiCell(PDFHelper::pixels_to_MM(430),PDFHelper::points_to_MM(11),$this->chequeData->CINACompanyName(),$this->showBorder,"C");
			if($this->chequeData->CINACompanySecondName() != "")
			{
				$this->pdf->SetXY(5, PDFHelper::pixels_to_MM(26+$startYPinkTekst)+4+$this->PLUS_y);
				$this->pdf->MultiCell(PDFHelper::pixels_to_MM(430),PDFHelper::points_to_MM(11),$this->chequeData->CINACompanySecondName(),$this->showBorder,"C");
			}
			else
			{
			}
			$plusPOzY = 0;
			if($this->chequeData->CINACompanySecondName() != "")
			{
				$plusPOzY = 4;
			}
			$this->pdf->SetXY(5, PDFHelper::pixels_to_MM(32+$startYPinkTekst+$heightBoldTexts)+$plusPOzY+$this->PLUS_y);
			$this->pdf->SetFont("helvetica", "", 7.5);
			$this->pdf->MultiCell(PDFHelper::pixels_to_MM(430),PDFHelper::points_to_MM(8.8),$compnay_x4_lines,$this->showBorder,"C");
			
			$this->pdf->SetXY(PDFHelper::pixels_to_MM(419), PDFHelper::pixels_to_MM(31)+$this->PLUS_y);
			$this->pdf->SetFont("helvetica_bold", "", 7);
			$this->pdf->MultiCell(PDFHelper::pixels_to_MM(340),PDFHelper::points_to_MM(7),$this->chequeData->compInfoBankName(),$this->showBorder,"L");
			$this->pdf->SetXY(PDFHelper::pixels_to_MM(419), PDFHelper::pixels_to_MM(41)+$this->PLUS_y);
			$this->pdf->SetFont("helvetica", "", 5.5);
			$this->pdf->MultiCell(PDFHelper::pixels_to_MM(340),PDFHelper::points_to_MM(7),$this->chequeData->compInfoBankAddress1()."\n".$this->chequeData->compInfoBankAddress2()."\n".$this->chequeData->compInfoBankAddress3()."\n".$this->chequeData->compInfoBankAddress4(),$this->showBorder,"L");
			
			$this->PAYdraw();
			
			$this->pdf->SetXY(PDFHelper::pixels_to_MM(17), PDFHelper::pixels_to_MM(190)+$this->PLUS_y);
			$this->pdf->SetFont("helvetica", "", 7.5);
			$this->pdf->MultiCell(PDFHelper::pixels_to_MM(340),PDFHelper::points_to_MM(7.5),"TO\nTHE\nORDER\nOF",$this->showBorder,"L");
							
			////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
			//print "selectSoftwerIndex:".$_GET["selectSoftwerIndex"];]
			if($this->chequeData->softwareIndex() == "4")//QUICKBOOKS
			{
				//////////////////////////////////////////
				/*
				Gledash od PDFata kade ima objasnato i sreduvash spored niv i gledash na photoshop
				*/
				$this->pdf->SetXY(PDFHelper::pixels_to_MM(480), PDFHelper::pixels_to_MM(145)+$this->PLUS_y);
				$this->pdf->SetFont("helvetica", "", 10);
				$this->pdf->MultiCell(PDFHelper::pixels_to_MM(290),PDFHelper::points_to_MM(10),"$",$this->showBorder,"C");
			}
			////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
			////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
			////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
			$this->drawTwoLinesAndCompanyName();
			
			$this->pdf->SetFont("newFont", "", 12);
			if($this->iMForCheque == true)
			{
				$this->pdf->SetXY(PDFHelper::pixels_to_MM(0), PDFHelper::pixels_to_MM(298)+$this->PLUS_y);
				$this->pdf->MultiCell(PDFHelper::$widthA4,PDFHelper::points_to_MM(12),
								$this->chequeData->startAtNumberDD( $this->chequeData->startAtNumber() )."   ".
								PDFHelper::get_branch_transit_Number($this->chequeData->brunchNumber(),$this->chequeData->transitNumber()).
												  "".$this->chequeData->accountNumber__newFontWriteSTR().
												  " ".$this->chequeData->currencyNumber45(),$this->showBorder,"C");
				$this->addChequeNumber();
			}
			else
			{
				$this->pdf->SetXY(PDFHelper::pixels_to_MM(267), PDFHelper::pixels_to_MM(298)+$this->PLUS_y);
				$this->pdf->MultiCell(PDFHelper::$widthA4,PDFHelper::points_to_MM(12),
								PDFHelper::get_branch_transit_Number($this->chequeData->brunchNumber(),$this->chequeData->transitNumber()).
												  "".$this->chequeData->accountNumber__newFontWriteSTR().
												  " ".$this->chequeData->currencyNumber45(),$this->showBorder,"L");
				if($this->iMReorderForm == true )
				{
					if($this->chequeData->chequePosition()=="1")
					{
						$this->show_order_number_on_top();
					}
				}
			}
			
			$this->pdf->SetFont("helvetica_bold", "", 9);
			/**/
			$this->pdf->SetXY(PDFHelper::pixels_to_MM(24), PDFHelper::pixels_to_MM(338));
			if($this->chequeData->chequePosition() == "2" || $this->chequeData->chequePosition() == "3")
			{
				$this->pdf->SetXY(PDFHelper::pixels_to_MM(24), 3);
			}
			else
			{
				$this->pdf->SetXY(PDFHelper::pixels_to_MM(24), 91);
			}
			
			if(!$this->iMReorderForm)
			{
				if($this->chequeData->CINACompanySecondName() != "")
				{
					$this->pdf->MultiCell(PDFHelper::pixels_to_MM(800),4,$this->chequeData->CINAComapanyNameLinivche()."",$this->showBorder,"L");
				}
				else
				{
					$this->pdf->MultiCell(PDFHelper::pixels_to_MM(800),4,$this->chequeData->CINACompanyName(),$this->showBorder,"L");
				}	
			}
			$companyNamePOsitionYLinivche = 4;			
			
			/* */
			$pozYLinija = PDFHelper::pixels_to_MM(672);
			if($this->chequeData->chequePosition() == "1" && $this->iMReorderForm==false && $this->iMForCheque==false/**/)
			{
				$pozYLinija = 177.8;
			}
			else if($this->chequeData->chequePosition() == "3")
			{
				$pozYLinija = 101.5;
			}
			$sirinaLinija = PDFHelper::pixels_to_MM(14);
			$this->pdf->Line(PDFHelper::pixels_to_MM(28), $pozYLinija, 
							 PDFHelper::pixels_to_MM(6)+$sirinaLinija, $pozYLinija);
			$this->pdf->Line(PDFHelper::$widthA4-PDFHelper::pixels_to_MM(27), $pozYLinija, 
							 PDFHelper::$widthA4-PDFHelper::pixels_to_MM(33)+$sirinaLinija, $pozYLinija);
							 
							 
							
			
			
			$this->pdf->SetXY(PDFHelper::pixels_to_MM(24), PDFHelper::pixels_to_MM(678));
			$this->pdf->SetFont("helvetica_bold", "", 9);
			if($this->chequeData->chequePosition() == "3")
			{
				$this->pdf->SetXY(PDFHelper::pixels_to_MM(24), PDFHelper::pixels_to_MM(395));
			}
			if(!$this->iMReorderForm)
			{
				if($this->chequeData->CINACompanySecondName() != "")
				{
					$this->pdf->MultiCell(PDFHelper::pixels_to_MM(800),$companyNamePOsitionYLinivche,$this->chequeData->CINAComapanyNameLinivche(),$this->showBorder,"L");
				}
				else
				{
					$this->pdf->MultiCell(PDFHelper::pixels_to_MM(800),$companyNamePOsitionYLinivche,$this->chequeData->CINACompanyName(),$this->showBorder,"L");
				}
			}
			
			
			$this->pdf->SetXY(PDFHelper::pixels_to_MM(24), PDFHelper::pixels_to_MM(714+300));
			$this->pdf->SetFont("helvetica", "", 6);
			if($this->chequeData->chequePosition() == "3")
			{
				$this->pdf->SetXY(PDFHelper::pixels_to_MM(24), 185);
			}
			//$this->pdf->MultiCell(PDFHelper::pixels_to_MM(340),PDFHelper::points_to_MM(6),"PRINT & CHEQUES NOW INC. 1-866-760-2661",$this->showBorder,"L");
			if($this->iMReorderForm == true)
			{
			}
			else
			{
				$this->pdf->MultiCell(PDFHelper::pixels_to_MM(340),PDFHelper::points_to_MM(6),
				"www.chequesnow.ca/reorder 1-866-760-2661 Order # ".OrderNumber::$CURR_ORDER->orderLabel_withPower()."	",
				$this->showBorder,"L");
			}
					
			/*
			$this->pdf->SetXY(0, 20);
			$this->pdf->SetFontSize(20);
			$this->pdf->SetFont("Arial", "", 20);
			$this->pdf->Cell(100,100,"Zlatko Derkoski");
			*/
		}
		function drawTwoLinesAndCompanyName()
		{
			$this->pdf->SetFont("helvetica_bold", "", 7.5);
			if($this->chequeData->thereIsSecondSignature() == true)
			{
				$this->pdf->SetXY(PDFHelper::pixels_to_MM(504), PDFHelper::pixels_to_MM(178)+$this->PLUS_y);
			}
			else
			{
				$this->pdf->SetXY(PDFHelper::pixels_to_MM(504), PDFHelper::pixels_to_MM(200)+$this->PLUS_y);
			}
			if($this->chequeData->CINACompanySecondName() != "")
			{
				$this->pdf->MultiCell(PDFHelper::pixels_to_MM(290),PDFHelper::points_to_MM(4)*2,$this->chequeData->CINACompanyName()."\n".$this->chequeData->CINACompanySecondName(),$this->showBorder,"C");
			}
			else
			{
				$this->pdf->MultiCell(PDFHelper::pixels_to_MM(290),PDFHelper::points_to_MM(7.5),$this->chequeData->CINACompanyName(),$this->showBorder,"C");
			}
			if($this->chequeData->thereIsSecondSignature() == true)
			{
				$this->pdf->SetXY(PDFHelper::pixels_to_MM(506), PDFHelper::pixels_to_MM(213)+$this->PLUS_y);
				$this->pdf->SetFont("helvetica", "", 7.5);
				$this->pdf->MultiCell(PDFHelper::pixels_to_MM(290),PDFHelper::points_to_MM(7.5),"PER _____________________________________________",$this->showBorder,"L");
			}
			$this->pdf->SetXY(PDFHelper::pixels_to_MM(506), PDFHelper::pixels_to_MM(246)+$this->PLUS_y);
			$this->pdf->SetFont("helvetica", "", 7.5);
			$this->pdf->MultiCell(PDFHelper::pixels_to_MM(290),PDFHelper::points_to_MM(7.5),"PER _____________________________________________",$this->showBorder,"L");
			
			if($this->chequeData->isCurrency() == true)
			{
				if($this->chequeData->thereIsSecondSignature() == true)
				{
					$this->pdf->SetXY(PDFHelper::pixels_to_MM(715), PDFHelper::pixels_to_MM(163)+$this->PLUS_y);
				}
				else
				{
					$this->pdf->SetXY(PDFHelper::pixels_to_MM(715), PDFHelper::pixels_to_MM(182)+$this->PLUS_y);
				}
				$this->pdf->SetFont("helvetica_bold", "", 8);
				$this->pdf->MultiCell(PDFHelper::pixels_to_MM(290),PDFHelper::points_to_MM(10),"U.S. FUNDS",$this->showBorder,"L");
			}
		}
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
		////////////////////////////////////////////////////////////////////////////
		/////Pricing, Quantity & Cheque Info
		////////////////////////////////////////////////////////////////////////////
		function selectQuantity_show()
		{
			//if(Product::$QUANTITY_AND_PRICES->invoice_amount() == 0){return;}
			if($this->chequeData->chequePosition()=="1")
			{
				$this->pdf->SetXY(106, 117);
			}
			else if($this->chequeData->chequePosition()=="2")
			{
				$this->pdf->SetXY(57, 195);
			}
			else
			{
				$this->pdf->SetXY(74.5, 109.5);
			}
			$this->pdf->SetFont("helvetica_bold", "", 14);
			$this->pdf->MultiCell(PDFHelper::pixels_to_MM(100),6,Product::$QUANTITY_AND_PRICES->quantity."",$this->showBorder,"C");
		}
		function PAYdraw()
		{
			if($this->chequeData->softwareIndex() == "1")
			{
				$this->pdf->SetXY(PDFHelper::pixels_to_MM(17), PDFHelper::pixels_to_MM(135)+$this->PLUS_y);
			}
			else if($this->chequeData->softwareIndex() == "4")
			{
				$this->pdf->SetXY(PDFHelper::pixels_to_MM(17), PDFHelper::pixels_to_MM(145)+$this->PLUS_y);
			}
			else
			{
				$this->pdf->SetXY(PDFHelper::pixels_to_MM(17), PDFHelper::pixels_to_MM(145)+$this->PLUS_y);
			}
			$this->pdf->SetFont("helvetica", "", 11);
			$this->pdf->MultiCell(PDFHelper::pixels_to_MM(340),PDFHelper::points_to_MM(12),"PAY",$this->showBorder,"L");
		}
		function addImageBGForCheque()
		{
			$this->pdf->Image($this->before_testing_folder.$this->chequeData->getURLForLaserNewBG(), 0, 0, 215.9);
		}
	}
	if(isset($_GET["DO_TEST"]))
	{
	/*
	 * This is code just for testing* */ 
	if(!class_exists("XMLParser")){require_once("../tools.php");}
	if(!class_exists("Product")){require_once("../products_moderator.php");}
	require_once("../pdf-tools/fpdf.php");
	require_once("../pdf-tools/pdf-helper.php");
	XMLParser::ADD_ORDER_XML_TO_POST( "../orders/xml/T_L5840.xml" );
	$objCheque = new Cheque( $_POST["chequeType"] );
	$objChequeData = new ChequeData( $objCheque );
	OrderNumber::$CURR_ORDER = new OrderNumber($objCheque, false, "T_L5840");
	$objOrderForm = new BlankA4Cheque($objChequeData, false, true,  "../");
	$objOrderForm->saveToLocal( "blank-a4-ch-laser2.pdf" );
	
        
        }
	
?>