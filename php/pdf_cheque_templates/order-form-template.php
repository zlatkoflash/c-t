<?php
/////////////////////////////////////////////////////////////
//////////// Order form cheque class
////////////////////////////////////////////////////////////
class OrderFormTemplate
{	
	var $pdf,
	    $fileName = 'order-form-template.pdf',
		$outPutTOSErver=NULL,
		$iMReorderForm = false; 
	var $chequeData;
	var $showBorder = 0;
	var $fontSize = 10;
	var $smallerFontSize = 9.5;
	var $before_testing_folder = "";
	
	public function OrderFormTemplate($chequeData____, $__iMReorderForm___=false, $before_testing_folde="")
	{
		$this->before_testing_folder = $before_testing_folde;
		
		$this->chequeData = $chequeData____;
		$this->iMReorderForm = $__iMReorderForm___;
		
		$this->pdf = new FPDF('P','mm','Letter');
		$this->pdf->AddFont("helvetica_bold", "", $this->before_testing_folder."../fonts/helvetica-bold/fpdf/3c41c8e6600e41512cbd6a118d2bdf41_helvetica_bold.php");
		$this->pdf->AddFont("helvetica", "", $this->before_testing_folder."../fonts/helvetica/fpdf/25e75292757c3eb4bba8a3ddd4e8fe3f_helvetica_lt.php");
		$this->pdf->AddFont("newFont","",$this->before_testing_folder."../fonts/micr/fpdf/f30e76a7a57ca16aaf2424921d10f4da_micr___.php");
		$this->pdf->SetDisplayMode('real','default');//with this i can not do fill\
		$this->pdf->SetAutoPageBreak(false);
		$this->pdf->AddPage();
		$this->addReorderFormBG();
		$this->SetHeaderData();
		$this->SetContactInformation();
		$this->SetOrderType();
		$this->SetOrderDetails();
		$this->SetShippingDetails();
		$this->SetBillingDetails();
		$this->SetCustomerComments();
		
	}
	
	//Set background method
	public function addReorderFormBG()
	{
		$this->pdf->Image($this->before_testing_folder."order_form.jpg", 0, 0, 215.9);
	}
	
	//Write Order Type, Ship By Date, Order Submitted Date, Actual Ship Date in pdf file
	public function SetHeaderData()
	{
		//Set font
		//Order type field
		$this->pdf->SetXY(24, 7);
                $text_for___HP = "";
                if($this->chequeData->province_TYPE_SHIPING() == "NS" ||
                $this->chequeData->province_TYPE_SHIPING() == "NT" ||
                $this->chequeData->province_TYPE_SHIPING() == "YK" ||
                $this->chequeData->province_TYPE_SHIPING() == "PE" ||
                $this->chequeData->province_TYPE_SHIPING() == "NB" ||
                $this->chequeData->province_TYPE_SHIPING() == "NU"||
                $this->chequeData->province_TYPE_SHIPING() == "NL"||
                $this->chequeData->province_TYPE_SHIPING() == "YT") 
                {
                    $text_for___HP .= "HP";
                }
		if($this->chequeData->delivery()=="1-5 Business Days")
		{
                    if($text_for___HP != "")$text_for___HP = " ".$text_for___HP;
			$this->pdf->SetFont("helvetica", "", 12);
			$this->pdf->MultiCell(PDFHelper::pixels_to_MM(120),PDFHelper::points_to_MM(18),
                                "R".$text_for___HP,$this->showBorder,"C");
		}
                else
                {
			$this->pdf->SetFont("helvetica", "", 12);
			$this->pdf->MultiCell(PDFHelper::pixels_to_MM(120),PDFHelper::points_to_MM(18),
                                $text_for___HP,$this->showBorder,"C");
                }
                        
		$this->pdf->SetFont("helvetica", "", $this->fontSize);

		$this->pdf->SetFont("helvetica", "", 8);
		//Ship by date field
		$this->pdf->SetXY(50, 7.5);
		if($this->chequeData->order_updated_date() != "")
		{
			$this->pdf->MultiCell(PDFHelper::pixels_to_MM(120),PDFHelper::points_to_MM(18),
					date("F j, Y", /*24*60*60+*/$this->chequeData->order_updated_date()/1000),
                                $this->showBorder,"C");
		}
		else
		{
                    /*
			$this->pdf->MultiCell(PDFHelper::pixels_to_MM(120),PDFHelper::points_to_MM(18),"",
                                $this->showBorder,"C");
                        */
		}
		//Order submitted date
		$this->pdf->SetXY(PDFHelper::pixels_to_MM(285), PDFHelper::pixels_to_MM(28));
		if($this->chequeData->date_for_new_submited_order() != "")
		{
			$this->pdf->MultiCell(PDFHelper::pixels_to_MM(120),PDFHelper::points_to_MM(18), 
					date("F j, Y", /*24*60*60+*/$this->chequeData->date_for_new_submited_order()) ,$this->showBorder,"C");
		}
		else
		{
			$this->pdf->MultiCell(PDFHelper::pixels_to_MM(120),PDFHelper::points_to_MM(18), date("F j, Y"),$this->showBorder,"C");
		}
		//Actual ship date
		$this->pdf->SetXY(PDFHelper::pixels_to_MM(405), PDFHelper::pixels_to_MM(28));
		$this->pdf->MultiCell(PDFHelper::pixels_to_MM(120),PDFHelper::points_to_MM(18),"",$this->showBorder,"C");
		$this->pdf->SetXY(PDFHelper::pixels_to_MM(405), PDFHelper::pixels_to_MM(28));
		
		if($this->chequeData->sales_person_code() != "" && $this->chequeData->order_entered_by() != "")
		{
			$this->pdf->SetFont("helvetica", "", 12);
			$this->pdf->SetXY(PDFHelper::pixels_to_MM(515), 2);
			$this->pdf->MultiCell(PDFHelper::pixels_to_MM(300),PDFHelper::points_to_MM(18),
						$this->chequeData->sales_person_code()." - ".$this->chequeData->order_entered_by(),$this->showBorder,"L");
		}
		
		$this->pdf->SetFont("helvetica", "", 10);
		$this->pdf->SetXY(140, 7);
		/*
		if($this->chequeData->cheque->type == Cheque::TYPE_LASER)
		{
			$this->pdf->MultiCell(PDFHelper::pixels_to_MM(300),PDFHelper::points_to_MM(18),"LASER ORDER FORM",$this->showBorder,"C");
		}
		else
		{
			$this->pdf->MultiCell(PDFHelper::pixels_to_MM(300),PDFHelper::points_to_MM(18),"MANUAL ORDER FORM",$this->showBorder,"C");
		}*/
		if($_POST["file_approval_drop_down"] != "" && $_POST["invoice_approval_drop_down"] != "")
		{
			$this->pdf->MultiCell
			(
			 100,3.7, "FILE APPROVAL: ".$_POST["file_approval_drop_down"]."\nINVOICE APPROVAL: ".
																  $_POST["invoice_approval_drop_down"],
						$this->showBorder, "L"
		    );	
		}
		
	}
	
	//Contact information
	public function SetContactInformation()
	{
		//Set font
		$this->pdf->SetFont("helvetica", "", $this->fontSize);
		//Existing customer field
		$this->pdf->SetXY(PDFHelper::pixels_to_MM(114), PDFHelper::pixels_to_MM(84));
		$this->pdf->MultiCell(PDFHelper::pixels_to_MM(13),PDFHelper::points_to_MM(5),"",$this->showBorder,"C");
		//Company field
		$this->pdf->SetXY(PDFHelper::pixels_to_MM(210), PDFHelper::pixels_to_MM(79));
		$this->pdf->MultiCell(PDFHelper::pixels_to_MM(340),PDFHelper::points_to_MM(12),$this->chequeData->CICompanyName(),$this->showBorder,"L");
		//Phone field
		$this->pdf->SetXY(PDFHelper::pixels_to_MM(580), PDFHelper::pixels_to_MM(79));
		$this->pdf->MultiCell(59,PDFHelper::points_to_MM(12),$this->chequeData->CIPhone(),$this->showBorder,"L");
		//Fax field
		/*
		$this->pdf->SetXY(PDFHelper::pixels_to_MM(705), PDFHelper::pixels_to_MM(79));
		$this->pdf->MultiCell(PDFHelper::pixels_to_MM(95),PDFHelper::points_to_MM(12),"",$this->showBorder,"L");
		*/
		
                //existing customer or contact
                //$_POST["existing_customer_or_contact"] = "Existing customer";
		$this->pdf->SetXY(0, 7);
		$this->pdf->SetFont("helvetica", "", 14);
		$this->pdf->MultiCell(PDFHelper::pixels_to_MM(123),PDFHelper::points_to_MM(12), 
                        $_POST["orderNumber"],$this->showBorder,"L");
		//Job/order field
                //$_POST["existing_customer_or_contact"] = "Test text";
		$this->pdf->SetXY(0, 21);
                $this->pdf->SetFont("helvetica", "", 8);
                $this->pdf->MultiCell(26, PDFHelper::points_to_MM(18), 
                        $_POST["existing_customer_or_contact"], 
                        $this->showBorder, "L");
                //Job Name text
		$this->pdf->SetXY(15, 27);
		$this->pdf->SetFont("helvetica", "", 7);
		$this->pdf->MultiCell(40,2, 
                        $_POST["job_name_text"],$this->showBorder,"L");
		
		$this->pdf->SetFont("helvetica", "", $this->fontSize);
		//Name field
		$this->pdf->SetXY(PDFHelper::pixels_to_MM(245), PDFHelper::pixels_to_MM(102));
		$this->pdf->MultiCell(PDFHelper::pixels_to_MM(305),PDFHelper::points_to_MM(12),$this->chequeData->CIContactName(),$this->showBorder,"L");
		//Email field
		$this->pdf->SetXY(PDFHelper::pixels_to_MM(589), PDFHelper::pixels_to_MM(102));
		$this->pdf->MultiCell(PDFHelper::pixels_to_MM(213),PDFHelper::points_to_MM(12),$this->chequeData->CIEmail(),$this->showBorder,"L");
	}
	
	public function SetOrderType()
	{
		//$_POST["x3options_admin_right_form"] = "Exect Repeat";
		//$_POST["x3options_admin_right_form"] = "New Order";
		//$_POST["x3options_admin_right_form"] = "Change Repeat";
		if($_POST["x3options_admin_right_form"] == "Exect Repeat")
		{
				//Set font
				$this->pdf->SetFont("helvetica_bold", "", $this->fontSize);
				//Exact Repeat field
				$this->pdf->SetXY(4.0, PDFHelper::pixels_to_MM(165));
				$this->pdf->MultiCell(PDFHelper::pixels_to_MM(18),PDFHelper::points_to_MM(10),"X",$this->showBorder,"C");
		}			
		if($_POST["x3options_admin_right_form"] == "New Order")
		{
				//New Order field
				$this->pdf->SetXY(18, PDFHelper::pixels_to_MM(165));
				$this->pdf->MultiCell(PDFHelper::pixels_to_MM(18),PDFHelper::points_to_MM(10),"X",$this->showBorder,"C");//Copy Layout field
				
				$this->pdf->SetXY(24, 37);
				$this->pdf->SetFillColor(255,255,255);
				$this->pdf->MultiCell(PDFHelper::pixels_to_MM(175),PDFHelper::points_to_MM(12),
															$_POST["new_order_right_column_type"],$this->showBorder,"C", true);
				//Set font
				$this->pdf->SetFont("helvetica", "", 8);
				$this->pdf->SetXY(24, PDFHelper::pixels_to_MM(160));
				$this->pdf->MultiCell(PDFHelper::pixels_to_MM(175),3,
															$_POST["new_order_right_column_name_for_type"],$this->showBorder,"L");
		}
		$this->pdf->SetFont("helvetica", "", $this->fontSize);
		/*
		*/
		if($_POST["x3options_admin_right_form"] == "Change Repeat")
		{
				//Change Repeat field
				$this->pdf->SetXY(76, PDFHelper::pixels_to_MM(165));
				$this->pdf->MultiCell(PDFHelper::pixels_to_MM(18),PDFHelper::points_to_MM(10),"X",$this->showBorder,"C");
				//QTY field
				if(isset($_POST["change_repeat_cheques_cb_quantity"]))
				{
				$this->pdf->SetXY(102, PDFHelper::pixels_to_MM(146));
				$this->pdf->MultiCell(PDFHelper::pixels_to_MM(14),PDFHelper::points_to_MM(7),
															"X",$this->showBorder,"L");
				$this->pdf->SetXY(106, PDFHelper::pixels_to_MM(146));
				$this->pdf->MultiCell(50,3,
															$_POST["change_repeat_cheques_quantity"],$this->showBorder,"L");
				}
				//Start field
				if(isset($_POST["change_repeat_cheques_cb_start"]))
				{
				$this->pdf->SetXY(102, PDFHelper::pixels_to_MM(160));
				$this->pdf->MultiCell(PDFHelper::pixels_to_MM(14),PDFHelper::points_to_MM(7),
															"X",$this->showBorder,"L");
				$this->pdf->SetXY(106, PDFHelper::pixels_to_MM(160));
				$this->pdf->MultiCell(50,3,
															$_POST["change_repeat_cheques_start"],$this->showBorder,"L");
				}
				//Stock field
				if(isset($_POST["change_repeat_cheques_cb_stock"]))
				{
				$this->pdf->SetXY(102, PDFHelper::pixels_to_MM(175));
				$this->pdf->MultiCell(PDFHelper::pixels_to_MM(14),PDFHelper::points_to_MM(7),
															"X",$this->showBorder,"L");
				$this->pdf->SetXY(106, PDFHelper::pixels_to_MM(175));
				$this->pdf->MultiCell(50,3,
															$_POST["change_repeat_cheques_stock"],$this->showBorder,"L");
				}
				//************************************************************
				//Imprint field
				if(isset($_POST["change_repeat_cheques_cb_imprint"]))
				{
				$this->pdf->SetXY(166, PDFHelper::pixels_to_MM(146));
				$this->pdf->MultiCell(PDFHelper::pixels_to_MM(14),PDFHelper::points_to_MM(7),
															"X",$this->showBorder,"L");
				$this->pdf->SetXY(170, PDFHelper::pixels_to_MM(146));
				$this->pdf->MultiCell(50,3,
															$_POST["change_repeat_cheques_imprint"],$this->showBorder,"L");
				}
				//OTHER field
				if(isset($_POST["change_repeat_cheques_cb_other"]))
				{
				$this->pdf->SetXY(166, PDFHelper::pixels_to_MM(160));
				$this->pdf->MultiCell(PDFHelper::pixels_to_MM(14),PDFHelper::points_to_MM(7),
															"X",$this->showBorder,"L");
				$this->pdf->SetXY(170, PDFHelper::pixels_to_MM(160));
				$this->pdf->MultiCell(50,3,
															$_POST["change_repeat_cheques_other"],$this->showBorder,"L");
				}
				//SEE ATCHD field
				if(isset($_POST["change_repeat_cheques_cb_see_atchd"]))
				{
				$this->pdf->SetXY(166, PDFHelper::pixels_to_MM(175));
				$this->pdf->MultiCell(PDFHelper::pixels_to_MM(14),PDFHelper::points_to_MM(7),
															"X",$this->showBorder,"L");
				$this->pdf->SetXY(170, PDFHelper::pixels_to_MM(175));
				$this->pdf->MultiCell(50,3,
															$_POST["change_repeat_cheques_see_atchd"],$this->showBorder,"L");
				}
		}
		//*************************************************************
		/*
		//*************************************************************
		//*************************************************************
		//*************************************************************
		//QTY text field
		$this->pdf->SetXY(PDFHelper::pixels_to_MM(600), PDFHelper::pixels_to_MM(143));
		$this->pdf->MultiCell(PDFHelper::pixels_to_MM(75),PDFHelper::points_to_MM(12),"",$this->showBorder,"L");
		//Start text field
		$this->pdf->SetXY(PDFHelper::pixels_to_MM(600), PDFHelper::pixels_to_MM(157));
		$this->pdf->MultiCell(PDFHelper::pixels_to_MM(75),PDFHelper::points_to_MM(12),"",$this->showBorder,"L");
		//Stock text field
		$this->pdf->SetXY(PDFHelper::pixels_to_MM(600), PDFHelper::pixels_to_MM(172));
		$this->pdf->MultiCell(PDFHelper::pixels_to_MM(75),PDFHelper::points_to_MM(12),"",$this->showBorder,"L");
		//*************************************************************
		//Imprint text field
		$this->pdf->SetXY(PDFHelper::pixels_to_MM(736), PDFHelper::pixels_to_MM(143));
		$this->pdf->MultiCell(PDFHelper::pixels_to_MM(77),PDFHelper::points_to_MM(12),"",$this->showBorder,"L");
		//OTHER text field
		$this->pdf->SetXY(PDFHelper::pixels_to_MM(736), PDFHelper::pixels_to_MM(157));
		$this->pdf->MultiCell(PDFHelper::pixels_to_MM(77),PDFHelper::points_to_MM(12),"",$this->showBorder,"L");
		//SEE ATCHD text field
		$this->pdf->SetXY(PDFHelper::pixels_to_MM(736), PDFHelper::pixels_to_MM(172));
		$this->pdf->MultiCell(PDFHelper::pixels_to_MM(77),PDFHelper::points_to_MM(12),"",$this->showBorder,"L");
		*/
	}
	
	//Order details method
	public function SetOrderDetails()
	{
		/*
		//Set font
		$this->pdf->SetFont("helvetica_bold", "", $this->fontSize);
		//QTY field
		*/
		$this->pdf->SetXY(PDFHelper::pixels_to_MM(2), PDFHelper::pixels_to_MM(225));
		$this->pdf->MultiCell(PDFHelper::pixels_to_MM(150),PDFHelper::points_to_MM(12),Product::$QUANTITY_AND_PRICES->title,$this->showBorder,"C");
		/**/
		//Foil field
		if($_POST["hologram_U_P_no_yes"] == "U")
		{
			$this->pdf->SetXY(PDFHelper::pixels_to_MM(196), PDFHelper::pixels_to_MM(216));
			$this->pdf->MultiCell(PDFHelper::pixels_to_MM(14),PDFHelper::points_to_MM(7),"X",$this->showBorder,"C");
		}
		else
		{
			//No Foil field
			$this->pdf->SetXY(PDFHelper::pixels_to_MM(196), PDFHelper::pixels_to_MM(233));
			$this->pdf->MultiCell(PDFHelper::pixels_to_MM(14),PDFHelper::points_to_MM(7),"X",$this->showBorder,"C");
		}
		
		//Position field
		$this->pdf->SetFont("helvetica", "", 12);
		$this->pdf->SetXY(PDFHelper::pixels_to_MM(213), PDFHelper::pixels_to_MM(225));
		$this->pdf->MultiCell(PDFHelper::pixels_to_MM(100),PDFHelper::points_to_MM(12),$this->chequeData->chequePositionLABEL(),$this->showBorder,"C");
		//Colour field
		$this->pdf->SetFont("helvetica", "", 9);
		$this->pdf->SetXY(PDFHelper::pixels_to_MM(305), PDFHelper::pixels_to_MM(225));
		$this->pdf->MultiCell(25,PDFHelper::points_to_MM(12),$this->chequeData->backgroundColor(),$this->showBorder,"C");
		//Software field
		$this->pdf->SetXY(PDFHelper::pixels_to_MM(413), PDFHelper::pixels_to_MM(226));
		$this->pdf->MultiCell(PDFHelper::pixels_to_MM(100),PDFHelper::points_to_MM(12),$this->chequeData->softwareABS(),$this->showBorder,"C");
		$this->pdf->SetFont("helvetica", "", $this->fontSize);
		//Sig Lines field
		$this->pdf->SetXY(PDFHelper::pixels_to_MM(523), PDFHelper::pixels_to_MM(226));
		$this->pdf->MultiCell(PDFHelper::pixels_to_MM(100),PDFHelper::points_to_MM(12),$this->chequeData->labelForSecondSignature__2(),$this->showBorder,"C");
		//Email checkbox field
		$this->pdf->SetXY(PDFHelper::pixels_to_MM(716), PDFHelper::pixels_to_MM(213));
		$this->pdf->MultiCell(PDFHelper::pixels_to_MM(14),PDFHelper::points_to_MM(7),"",$this->showBorder,"C");
		//ON FILE checkbox field
		$this->pdf->SetXY(PDFHelper::pixels_to_MM(716), PDFHelper::pixels_to_MM(233));
		$this->pdf->MultiCell(PDFHelper::pixels_to_MM(14),PDFHelper::points_to_MM(7),"",$this->showBorder,"C");
		//Logo Added field
		
                if(Product::$LOGO->invoice_amount() != 0 || Product::$LOGO->discount != 0 )
		{
			$this->pdf->SetFont("helvetica_bold", "", 15);
			$this->pdf->SetXY(PDFHelper::pixels_to_MM(688), PDFHelper::pixels_to_MM(225));
			$this->pdf->MultiCell(20,PDFHelper::points_to_MM(12),"X",$this->showBorder,"L");
		}
                
		if($this->chequeData->isCurrency() == true)
		{
			$this->pdf->SetFont("helvetica_bold", "", 9);
			$this->pdf->SetXY(PDFHelper::pixels_to_MM(595), PDFHelper::pixels_to_MM(226));
			$this->pdf->MultiCell(PDFHelper::pixels_to_MM(100),PDFHelper::points_to_MM(12),$this->chequeData->us_funds_label(),$this->showBorder,"C");
		}
		$this->pdf->SetFont("helvetica", "", 12);
		
		//Set font
		/*
		$this->pdf->SetFont("helvetica", "", $this->smallerFontSize);
		//Logo Added field
		$this->pdf->SetXY(PDFHelper::pixels_to_MM(643), PDFHelper::pixels_to_MM(239));
		$this->pdf->MultiCell(PDFHelper::pixels_to_MM(163),PDFHelper::points_to_MM(12),$this->chequeData->CILogoLabel(),$this->showBorder,"L");
		*/
		//*********************************************************************************************
		/**/
		//Set font
		$this->pdf->SetFont("helvetica", "", 12);
		//Special Designation field
		$this->pdf->SetXY(5, PDFHelper::pixels_to_MM(275));
		$this->pdf->MultiCell(15,PDFHelper::points_to_MM(12),$_POST["special_designation"],$this->showBorder,"C");
		//Start field
		
		$this->pdf->SetFont("helvetica", "", 12);
		$this->pdf->SetXY(20, PDFHelper::pixels_to_MM(275));
		$this->pdf->MultiCell(20,PDFHelper::points_to_MM(12),$this->chequeData->startAtNumber(),$this->showBorder,"C");
		$this->pdf->SetFont("helvetica", "", $this->fontSize);
		/*
		//STD checkbox field
		$this->pdf->SetXY(PDFHelper::pixels_to_MM(191), PDFHelper::pixels_to_MM(269));
		$this->pdf->MultiCell(PDFHelper::pixels_to_MM(14),PDFHelper::points_to_MM(7),"X",$this->showBorder,"C");
		//Special checkbox field
		$this->pdf->SetXY(PDFHelper::pixels_to_MM(191), PDFHelper::pixels_to_MM(284));
		$this->pdf->MultiCell(PDFHelper::pixels_to_MM(14),PDFHelper::points_to_MM(7),"X",$this->showBorder,"C");
		//TMB field
		$this->pdf->SetXY(PDFHelper::pixels_to_MM(215), PDFHelper::pixels_to_MM(280));
		$this->pdf->MultiCell(PDFHelper::pixels_to_MM(50),PDFHelper::points_to_MM(12),"TMB text",$this->showBorder,"L");
		*/
		//Sequence field
		$this->pdf->SetFont("helvetica", "", 7);
		$this->pdf->SetXY(70, PDFHelper::pixels_to_MM(275));
		$this->pdf->MultiCell(37,PDFHelper::points_to_MM(12),$this->chequeData->boxingType(),$this->showBorder,"C");
		$this->pdf->SetFont("helvetica", "", $this->fontSize);
		//Custom Color field
		/*
		$this->pdf->SetXY(PDFHelper::pixels_to_MM(420), PDFHelper::pixels_to_MM(280));
		$this->pdf->MultiCell(PDFHelper::pixels_to_MM(160),PDFHelper::points_to_MM(12),"Custom Colour Min. $90.00",$this->showBorder,"L");
		//MATCH SAMPLE checkbox field
		$this->pdf->SetXY(PDFHelper::pixels_to_MM(603), PDFHelper::pixels_to_MM(258));
		$this->pdf->MultiCell(PDFHelper::pixels_to_MM(14),PDFHelper::points_to_MM(7),"X",$this->showBorder,"C");
		*/
		//DWE USED
		if($this->chequeData->supplier() != "")
		{
			$this->pdf->SetXY(PDFHelper::pixels_to_MM(720), PDFHelper::pixels_to_MM(256));
			$this->pdf->MultiCell(PDFHelper::pixels_to_MM(110),PDFHelper::points_to_MM(12),"X",$this->showBorder,"L");
			//SUPPLIER
			$this->pdf->SetXY(PDFHelper::pixels_to_MM(689), PDFHelper::pixels_to_MM(280));
			$this->pdf->MultiCell(PDFHelper::pixels_to_MM(110),PDFHelper::points_to_MM(12), $this->chequeData->supplier(),$this->showBorder,"L");
		}
		
		///////////////////////////////////////////////////////
		//////////// Company info
		//////////////////////////////////////////////////////
		//Company name text field
		$this->pdf->SetXY(PDFHelper::pixels_to_MM(20), PDFHelper::pixels_to_MM(312));
		$this->pdf->MultiCell(PDFHelper::pixels_to_MM(290),PDFHelper::points_to_MM(12),$this->chequeData->CINACompanyName(),$this->showBorder,"L");
		//Address text field
		$this->pdf->SetXY(PDFHelper::pixels_to_MM(20), PDFHelper::pixels_to_MM(336));
		$this->pdf->MultiCell(PDFHelper::pixels_to_MM(290),PDFHelper::points_to_MM(12),$this->chequeData->CINACompanySecondName(),$this->showBorder,"L");
		//Address 2 text field
		$this->pdf->SetXY(PDFHelper::pixels_to_MM(20), PDFHelper::pixels_to_MM(360));
		$this->pdf->MultiCell(PDFHelper::pixels_to_MM(290),PDFHelper::points_to_MM(12),$this->chequeData->compInfoAddressLine1(),$this->showBorder,"L");
		//Address 3 text field
		$this->pdf->SetXY(PDFHelper::pixels_to_MM(20), PDFHelper::pixels_to_MM(384));
		$this->pdf->MultiCell(PDFHelper::pixels_to_MM(290),PDFHelper::points_to_MM(12),$this->chequeData->compInfoAddressLine2(),$this->showBorder,"L");
		//Address 4 text field
		$this->pdf->SetXY(PDFHelper::pixels_to_MM(20), PDFHelper::pixels_to_MM(408));
		$this->pdf->MultiCell(PDFHelper::pixels_to_MM(290),PDFHelper::points_to_MM(12),$this->chequeData->compInfoAddressLine3(),$this->showBorder,"L");
		//Address 5 text field
		$this->pdf->SetXY(PDFHelper::pixels_to_MM(20), PDFHelper::pixels_to_MM(432));
		$this->pdf->MultiCell(PDFHelper::pixels_to_MM(290),PDFHelper::points_to_MM(12),$this->chequeData->compInfoAddressLine4(),$this->showBorder,"L");
		
                //Logo truck "LOGO ADDED" label, if logo is selected
                /*
                 * This just in case when invoice amount is not 0 and dicount is not 0
                 * In another case not show this label
                 */
                if(Product::$LOGO->invoice_amount() != 0 || Product::$LOGO->discount != 0 )
                {
                    $this->pdf->SetFont("helvetica", "", 11);
                    $this->pdf->SetXY(5, PDFHelper::pixels_to_MM(463));
                    $this->pdf->MultiCell(PDFHelper::pixels_to_MM(120),PDFHelper::points_to_MM(12),"LOGO ADDED",$this->showBorder,"C"); 
                }
                $this->pdf->SetFont("helvetica", "", 16);
                //BRANCH number
		$this->pdf->SetXY(40, PDFHelper::pixels_to_MM(463));
		$this->pdf->MultiCell(PDFHelper::pixels_to_MM(120),PDFHelper::points_to_MM(12),$this->chequeData->brunchNumber(),$this->showBorder,"C");
		//TRANSIT number
		$this->pdf->SetXY(77, PDFHelper::pixels_to_MM(463));
		$this->pdf->MultiCell(PDFHelper::pixels_to_MM(130),PDFHelper::points_to_MM(12),$this->chequeData->transitNumber(),$this->showBorder,"C");
		//////////////////////////////////////////////////////////////////////////////
		//////////////////////////////////////////////////////////////////////////////
		//////////////////////////////////////////////////////////////////////////////
		$this->pdf->SetFont("helvetica", "", 9);
		//Bank Name text field
		$this->pdf->SetXY(PDFHelper::pixels_to_MM(360), PDFHelper::pixels_to_MM(312));
		$this->pdf->MultiCell(PDFHelper::pixels_to_MM(280),PDFHelper::points_to_MM(12),$this->chequeData->compInfoBankName(),$this->showBorder,"L");
		//Bank adress 1 text field
		$this->pdf->SetXY(PDFHelper::pixels_to_MM(360), PDFHelper::pixels_to_MM(336));
		$this->pdf->MultiCell(PDFHelper::pixels_to_MM(280),PDFHelper::points_to_MM(12),$this->chequeData->compInfoBankAddress1(),$this->showBorder,"L");
		//Bank adress 2 text field
		$this->pdf->SetXY(PDFHelper::pixels_to_MM(360), PDFHelper::pixels_to_MM(360));
		$this->pdf->MultiCell(PDFHelper::pixels_to_MM(280),PDFHelper::points_to_MM(12),$this->chequeData->compInfoBankAddress2(),$this->showBorder,"L");
		//Bank adress 3 text field
		$this->pdf->SetXY(PDFHelper::pixels_to_MM(360), PDFHelper::pixels_to_MM(384));
		$this->pdf->MultiCell(PDFHelper::pixels_to_MM(280),PDFHelper::points_to_MM(12),$this->chequeData->compInfoBankAddress3(),$this->showBorder,"L");
		//Bank adress 4 text field
		$this->pdf->SetXY(PDFHelper::pixels_to_MM(360), PDFHelper::pixels_to_MM(408));
		$this->pdf->MultiCell(PDFHelper::pixels_to_MM(280),PDFHelper::points_to_MM(12),$this->chequeData->compInfoBankAddress4(),$this->showBorder,"L");
		//Bank adress 5 text field
		$this->pdf->SetXY(PDFHelper::pixels_to_MM(360), PDFHelper::pixels_to_MM(432));
		$this->pdf->MultiCell(PDFHelper::pixels_to_MM(280),PDFHelper::points_to_MM(12),"",$this->showBorder,"L");
		$this->pdf->SetFont("helvetica", "", 13);
		//Account number text field
		$TextItIs45 = "   ".$this->chequeData->currencyNumber45();
		if($this->chequeData->currencyNumber45() == "")
		{
			$TextItIs45 = "";
		}
                
                //unset($_POST["cb_ovverride_default_bank_layout"]);
                if(isset($_POST["cb_ovverride_default_bank_layout"]))
                {
		//$this->pdf->SetFont("helvetica", "", $this->fontSize);
		$this->pdf->SetXY(115, 122);
		$this->pdf->MultiCell(55,4,
					"ACCT # OVERRIDE\n".$this->chequeData->accountNumber().$TextItIs45."",
                        $this->showBorder,"C", 1);
                }
                else
                {
		$this->pdf->SetXY(115, 123);
		$this->pdf->MultiCell(55,PDFHelper::points_to_MM(12),
					$this->chequeData->accountNumber().$TextItIs45."",$this->showBorder,"C");    
                }
                
		$this->pdf->SetFont("helvetica", "", $this->fontSize);
		//////////////////////////////////////////////////////////////////////////////
		///////////////////PROOF
		//////////////////////////////////////////////////////////////////////////////
		
		//P.O FIRST ROW
		//P.O 1 field
		
		$this->pdf->SetFont("helvetica_bold", "", 15);
		/**/
		if($_POST["cheque_logo_proof_required"] == "yes")
		{
			$this->pdf->SetXY(182.3, 80.8);
			$this->pdf->MultiCell(10,5,"X",$this->showBorder,"C");
		}
		else if($_POST["cheque_logo_proof_required"] == "no")
		{
			$this->pdf->SetXY(188.4,80.8);
			$this->pdf->MultiCell(10,5,"X",$this->showBorder,"C");
		}
		/*
			$this->pdf->SetXY(182.3, 80.8);
			$this->pdf->MultiCell(10,5,"X",$this->showBorder,"C");
			$this->pdf->SetXY(188.4,80.8);
			$this->pdf->MultiCell(10,5,"X",$this->showBorder,"C");
		 */
		
		//Set font
		$this->pdf->SetFont("helvetica", "", 7.5);
		/*
		$this->pdf->SetXY(PDFHelper::pixels_to_MM(687), PDFHelper::pixels_to_MM(369));
		$this->pdf->MultiCell(PDFHelper::pixels_to_MM(35),PDFHelper::points_to_MM(12),"P.O 1",$this->showBorder,"L");
		 * */
		/*//P.O 2 field
		$this->pdf->SetXY(PDFHelper::pixels_to_MM(718), PDFHelper::pixels_to_MM(369));
		$this->pdf->MultiCell(PDFHelper::pixels_to_MM(35),PDFHelper::points_to_MM(12),"P.O 2",$this->showBorder,"L");
		//P.O 3 field
		$this->pdf->SetXY(PDFHelper::pixels_to_MM(754), PDFHelper::pixels_to_MM(369));
		$this->pdf->MultiCell(PDFHelper::pixels_to_MM(35),PDFHelper::points_to_MM(12),"P.O 3",$this->showBorder,"L");
		/////////////////////////////////////////////////////////////////////////////////////////////////////////////
		//P.O SECOND ROW
		//P.O 1 field
		$this->pdf->SetXY(PDFHelper::pixels_to_MM(687), PDFHelper::pixels_to_MM(389));
		$this->pdf->MultiCell(PDFHelper::pixels_to_MM(35),PDFHelper::points_to_MM(12),"P.O 1",$this->showBorder,"L");
		//P.O 2 field
		$this->pdf->SetXY(PDFHelper::pixels_to_MM(718), PDFHelper::pixels_to_MM(389));
		$this->pdf->MultiCell(PDFHelper::pixels_to_MM(35),PDFHelper::points_to_MM(12),"P.O 2",$this->showBorder,"L");
		//P.O 3 field
		$this->pdf->SetXY(PDFHelper::pixels_to_MM(754), PDFHelper::pixels_to_MM(389));
		$this->pdf->MultiCell(PDFHelper::pixels_to_MM(35),PDFHelper::points_to_MM(12),"P.O 3",$this->showBorder,"L");
		/////////////////////////////////////////////////////////////////////////////////////////////////////////////
		//R.E 1 field
		$this->pdf->SetXY(PDFHelper::pixels_to_MM(687), PDFHelper::pixels_to_MM(408));
		$this->pdf->MultiCell(PDFHelper::pixels_to_MM(35),PDFHelper::points_to_MM(12),"R.E 1",$this->showBorder,"L");
		//R.E 2 field
		$this->pdf->SetXY(PDFHelper::pixels_to_MM(718), PDFHelper::pixels_to_MM(408));
		$this->pdf->MultiCell(PDFHelper::pixels_to_MM(35),PDFHelper::points_to_MM(12),"R.E 2",$this->showBorder,"L");
		//R.E 3 field
		$this->pdf->SetXY(PDFHelper::pixels_to_MM(754), PDFHelper::pixels_to_MM(408));
		$this->pdf->MultiCell(PDFHelper::pixels_to_MM(35),PDFHelper::points_to_MM(12),"R.E 3",$this->showBorder,"L");
		/////////////////////////////////////////////////////////////////////////////////////////////////////////////
		
		$this->pdf->SetFont("helvetica_bold", "",6.5);
		//ABC field
		$this->pdf->SetXY(PDFHelper::pixels_to_MM(687), PDFHelper::pixels_to_MM(427));
		$this->pdf->MultiCell(PDFHelper::pixels_to_MM(35),PDFHelper::points_to_MM(12),"ABC 1",$this->showBorder,"L");
		//ABC 2 field
		$this->pdf->SetXY(PDFHelper::pixels_to_MM(718), PDFHelper::pixels_to_MM(427));
		$this->pdf->MultiCell(PDFHelper::pixels_to_MM(35),PDFHelper::points_to_MM(12),"ABC 2",$this->showBorder,"L");
		//ABC 3 field
		$this->pdf->SetXY(PDFHelper::pixels_to_MM(754), PDFHelper::pixels_to_MM(427));
		$this->pdf->MultiCell(PDFHelper::pixels_to_MM(35),PDFHelper::points_to_MM(12),"ABC 3",$this->showBorder,"L");*/
		
		//////////////////////////////////////////////////////////////////////////////
		///////////////////PRODUCTION
		//////////////////////////////////////////////////////////////////////////////
		//Setup 1 field
		/*
		$this->pdf->SetXY(PDFHelper::pixels_to_MM(687), PDFHelper::pixels_to_MM(457));
		$this->pdf->MultiCell(PDFHelper::pixels_to_MM(33),PDFHelper::points_to_MM(12),"setup",$this->showBorder,"L");
		//Setup 2 field
		$this->pdf->SetXY(PDFHelper::pixels_to_MM(722), PDFHelper::pixels_to_MM(457));
		$this->pdf->MultiCell(PDFHelper::pixels_to_MM(33),PDFHelper::points_to_MM(12),"setup",$this->showBorder,"L");
		//Setup 3 field
		$this->pdf->SetXY(PDFHelper::pixels_to_MM(760), PDFHelper::pixels_to_MM(457));
		$this->pdf->MultiCell(PDFHelper::pixels_to_MM(33),PDFHelper::points_to_MM(12),"setup",$this->showBorder,"L");
		//OK 1 field
		$this->pdf->SetXY(PDFHelper::pixels_to_MM(687), PDFHelper::pixels_to_MM(477));
		$this->pdf->MultiCell(PDFHelper::pixels_to_MM(33),PDFHelper::points_to_MM(12),"ok 1",$this->showBorder,"L");
		//OK 2 field
		$this->pdf->SetXY(PDFHelper::pixels_to_MM(722), PDFHelper::pixels_to_MM(477));
		$this->pdf->MultiCell(PDFHelper::pixels_to_MM(33),PDFHelper::points_to_MM(12),"ok 2",$this->showBorder,"L");
		//OK 2 field
		$this->pdf->SetXY(PDFHelper::pixels_to_MM(760), PDFHelper::pixels_to_MM(477));
		$this->pdf->MultiCell(PDFHelper::pixels_to_MM(33),PDFHelper::points_to_MM(12),"ok 3",$this->showBorder,"L");*/
		
		
	}
	
	//Shipping Details
	public function SetShippingDetails()
	{
		//Set font
		$this->pdf->SetFont("helvetica", "", $this->fontSize);
		//Set font
		$this->pdf->SetFont("helvetica", "", 7);
		
		//print "[".$this->chequeData->deliveryShippingCompanyLabel()."]";
		//Ship by CAN PAR field
		$this->pdf->SetXY(18, PDFHelper::pixels_to_MM(512));
		$this->pdf->MultiCell(35,PDFHelper::points_to_MM(12),
					$this->chequeData->deliveryShippingCompanyLabel(),
					$this->showBorder,"L");
		/*
		//Ship by CP field
		$this->pdf->SetXY(PDFHelper::pixels_to_MM(75), PDFHelper::pixels_to_MM(527));
		$this->pdf->MultiCell(PDFHelper::pixels_to_MM(40),PDFHelper::points_to_MM(12),"C.P.",$this->showBorder,"L");
		//Ship by UPS field
		$this->pdf->SetXY(PDFHelper::pixels_to_MM(120), PDFHelper::pixels_to_MM(527));
		$this->pdf->MultiCell(PDFHelper::pixels_to_MM(45),PDFHelper::points_to_MM(12),"UPS",$this->showBorder,"L");
		 * */
		//Ship by PURO field
		/*
		$this->pdf->SetXY(PDFHelper::pixels_to_MM(170), PDFHelper::pixels_to_MM(527));
		$this->pdf->MultiCell(PDFHelper::pixels_to_MM(45),PDFHelper::points_to_MM(12),"PURO",$this->showBorder,"L");
		*/
		if(isset($_POST["shipping_to_bo_box"]))
		{
			$this->pdf->SetXY(45, 144);
			$this->pdf->MultiCell(25,3,"Ship to P.O. Box",$this->showBorder,"L");
		}
		/*
		//Ship by P/U field
		$this->pdf->SetXY(PDFHelper::pixels_to_MM(217), PDFHelper::pixels_to_MM(527));
		$this->pdf->MultiCell(PDFHelper::pixels_to_MM(45),PDFHelper::points_to_MM(12),"P/U",$this->showBorder,"L");
		
		
		
		
		//Serv type NBD -AM field
		/*$this->pdf->SetXY(PDFHelper::pixels_to_MM(270), PDFHelper::pixels_to_MM(527));
		$this->pdf->MultiCell(PDFHelper::pixels_to_MM(50),PDFHelper::points_to_MM(12),'NBD -AM',$this->showBorder,"L");
		//Serv type NBD field
		$this->pdf->SetXY(PDFHelper::pixels_to_MM(321), PDFHelper::pixels_to_MM(527));
		$this->pdf->MultiCell(PDFHelper::pixels_to_MM(46),PDFHelper::points_to_MM(12),"NBD",$this->showBorder,"L");
		//Serv type GROUND field
		$this->pdf->SetXY(PDFHelper::pixels_to_MM(367), PDFHelper::pixels_to_MM(527));
		$this->pdf->MultiCell(PDFHelper::pixels_to_MM(50),PDFHelper::points_to_MM(12),"GROUND",$this->showBorder,"L");
		//Serv type EMPTY field
		$this->pdf->SetXY(PDFHelper::pixels_to_MM(420), PDFHelper::pixels_to_MM(527));
		$this->pdf->MultiCell(PDFHelper::pixels_to_MM(50),PDFHelper::points_to_MM(12),"EMPTY",$this->showBorder,"L");
		//Serv type NSR field
		
		$this->pdf->SetXY(PDFHelper::pixels_to_MM(472), PDFHelper::pixels_to_MM(528));
		$this->pdf->MultiCell(PDFHelper::pixels_to_MM(30),PDFHelper::points_to_MM(12),"NSR",$this->showBorder,"L");*/
		if($this->chequeData->isresidentialAddressBSM()==true)
		{
			$this->pdf->SetXY(PDFHelper::pixels_to_MM(23), PDFHelper::pixels_to_MM(542));
			$this->pdf->MultiCell(PDFHelper::pixels_to_MM(300),PDFHelper::points_to_MM(12),"Residential Address",$this->showBorder,"L");
		}
		if($this->chequeData->isnoSignatureRequiredBSM()==true)
		{
			$this->pdf->SetFont("helvetica_bold", "", 16);
			$this->pdf->SetXY(PDFHelper::pixels_to_MM(472), PDFHelper::pixels_to_MM(527));
			$this->pdf->MultiCell(PDFHelper::pixels_to_MM(30),PDFHelper::points_to_MM(12),"X",$this->showBorder,"C");
		}
		//////////////////////////////////////////////////////////////////////////////////////
		////////////////////////////////////////Multiple order
		/////////////////////////////////////////////////////////////////////////////////////
		/*
		//Ship  with 1 field
		$this->pdf->SetXY(PDFHelper::pixels_to_MM(670), PDFHelper::pixels_to_MM(520));
		$this->pdf->MultiCell(PDFHelper::pixels_to_MM(130),PDFHelper::points_to_MM(12),"Ship  with 1",$this->showBorder,"L");
		//Ship  with 2 field
		$this->pdf->SetXY(PDFHelper::pixels_to_MM(670), PDFHelper::pixels_to_MM(543));
		$this->pdf->MultiCell(PDFHelper::pixels_to_MM(130),PDFHelper::points_to_MM(12),"Ship  with 2",$this->showBorder,"L");
		//Ship  with 3 field
		$this->pdf->SetXY(PDFHelper::pixels_to_MM(670), PDFHelper::pixels_to_MM(564));
		$this->pdf->MultiCell(PDFHelper::pixels_to_MM(130),PDFHelper::points_to_MM(12),"Ship  with 3",$this->showBorder,"L");
		*/
		$this->pdf->SetFont("helvetica", "", 7);
		//////////////////////////////////////////////////////////////////////////////////////
		//Ship to   name on chq checkbox field
		$this->pdf->SetXY(PDFHelper::pixels_to_MM(46), PDFHelper::pixels_to_MM(569));
		$this->pdf->MultiCell(PDFHelper::pixels_to_MM(14),PDFHelper::points_to_MM(7),"X",$this->showBorder,"C");
		
		//Ship to   name on chq field
		$this->pdf->SetXY(PDFHelper::pixels_to_MM(100), PDFHelper::pixels_to_MM(560));
		$this->pdf->MultiCell(PDFHelper::pixels_to_MM(200),PDFHelper::points_to_MM(7),$_POST["companyName_".ChequeData::TYPE_SHIPING],$this->showBorder,"L");
		///////////////////////////////////////////////////////////////////////////////
		$this->pdf->SetXY(PDFHelper::pixels_to_MM(100), PDFHelper::pixels_to_MM(573));
		$this->pdf->MultiCell(PDFHelper::pixels_to_MM(200),PDFHelper::points_to_MM(7),$_POST["contactName_".ChequeData::TYPE_SHIPING],$this->showBorder,"L");
		///////////////////////////////////////////////////////////////////////////////
		$this->pdf->SetXY(PDFHelper::pixels_to_MM(340), PDFHelper::pixels_to_MM(573));
		$this->pdf->MultiCell(PDFHelper::pixels_to_MM(150),PDFHelper::points_to_MM(7),$_POST["phone_".ChequeData::TYPE_SHIPING],$this->showBorder,"L");
		//Ship to   line two field
		//different address for shiping
		if($this->chequeData->isShipToDifferentAddress())
		{
			$this->pdf->SetXY(PDFHelper::pixels_to_MM(48), PDFHelper::pixels_to_MM(596));
		    $this->pdf->MultiCell(PDFHelper::pixels_to_MM(450),PDFHelper::points_to_MM(7),$_POST["address_1_".ChequeData::TYPE_SHIPING],$this->showBorder,"L");
			////////////////////////////////////////////////////////////////////////////////
			$this->pdf->SetXY(PDFHelper::pixels_to_MM(48), PDFHelper::pixels_to_MM(608));
		    $this->pdf->MultiCell(PDFHelper::pixels_to_MM(450),PDFHelper::points_to_MM(7),$_POST["address_2_".ChequeData::TYPE_SHIPING],$this->showBorder,"L");
			////////////////////////////////////////////////////////////////////////////////
			$this->pdf->SetXY(PDFHelper::pixels_to_MM(48), PDFHelper::pixels_to_MM(621));
		    $this->pdf->MultiCell(PDFHelper::pixels_to_MM(450),PDFHelper::points_to_MM(7),$_POST["address_3_".ChequeData::TYPE_SHIPING],$this->showBorder,"L");
			////////////////////////////////////////////////////////////////////////////////
			$this->pdf->SetXY(PDFHelper::pixels_to_MM(40), PDFHelper::pixels_to_MM(635));
		    $this->pdf->MultiCell(PDFHelper::pixels_to_MM(100),PDFHelper::points_to_MM(7),$_POST["city_".ChequeData::TYPE_SHIPING],$this->showBorder,"L");
			////////////////////////////////////////////////////////////////////////////////
			$this->pdf->SetXY(PDFHelper::pixels_to_MM(150), PDFHelper::pixels_to_MM(635));
		    $this->pdf->MultiCell(PDFHelper::pixels_to_MM(80),PDFHelper::points_to_MM(7),"Province:".$_POST["province_".ChequeData::TYPE_SHIPING],$this->showBorder,"L");
			////////////////////////////////////////////////////////////////////////////////
			$this->pdf->SetXY(PDFHelper::pixels_to_MM(240), PDFHelper::pixels_to_MM(635));
		    $this->pdf->MultiCell(PDFHelper::pixels_to_MM(80),PDFHelper::points_to_MM(7),$_POST["postalCode_".ChequeData::TYPE_SHIPING],$this->showBorder,"L");
			////////////////////////////////////////////////////////////////////////////////
			$this->pdf->SetXY(PDFHelper::pixels_to_MM(325), PDFHelper::pixels_to_MM(635));
		    $this->pdf->MultiCell(PDFHelper::pixels_to_MM(170),PDFHelper::points_to_MM(7),$_POST["email_".ChequeData::TYPE_SHIPING],$this->showBorder,"L");
		}
		
		/*
		//Special instructions field
		$this->pdf->SetXY(PDFHelper::pixels_to_MM(577), PDFHelper::pixels_to_MM(602));
		$this->pdf->MultiCell(PDFHelper::pixels_to_MM(200),PDFHelper::points_to_MM(7),"Special instructions",$this->showBorder,"L");
		//Ship on customer account checkbox field
		$this->pdf->SetXY(PDFHelper::pixels_to_MM(570), PDFHelper::pixels_to_MM(626));
		$this->pdf->MultiCell(PDFHelper::pixels_to_MM(14),PDFHelper::points_to_MM(7),"X",$this->showBorder,"C");
		//Ship on customer account field
		$this->pdf->SetXY(PDFHelper::pixels_to_MM(592), PDFHelper::pixels_to_MM(625));
		$this->pdf->MultiCell(PDFHelper::pixels_to_MM(200),PDFHelper::points_to_MM(7),"customer account",$this->showBorder,"L");
		*/
		
		/////////////////////////////////////////////////////////////////////////////////
		///////////////////////////Products
		////////////////////////////////////////////////////////////////////////////////
		//Product 1
		//label
		/*Sakal da se pojavuva quantity i ako centata e 0$....pa napraviv toa chim sakal :)
		if(Product::$QUANTITY_AND_PRICES->invoice_amount() != 0)
		{
			$this->pdf->SetXY(32, 174.1);
			$this->pdf->MultiCell(PDFHelper::pixels_to_MM(220),PDFHelper::points_to_MM(12),Product::$QUANTITY_AND_PRICES->title,$this->showBorder,"L");
			//price
			$this->pdf->SetXY(94, 174.1);
			$this->pdf->MultiCell(25,PDFHelper::points_to_MM(12),Product::$QUANTITY_AND_PRICES->invoice_amount_formated(),$this->showBorder,"L");
		}*/
			$this->pdf->SetXY(32, 174.1);
			$this->pdf->MultiCell(PDFHelper::pixels_to_MM(220),PDFHelper::points_to_MM(12),
								  Product::$QUANTITY_AND_PRICES->title,$this->showBorder,"L");
			//price
			$this->pdf->SetXY(94, 174.1);
			$this->pdf->MultiCell(25,PDFHelper::points_to_MM(12),Product::$QUANTITY_AND_PRICES->invoice_amount_formated(),$this->showBorder,"L");
		//$this->pdf->MultiCell(PDFHelper::pixels_to_MM(220),PDFHelper::points_to_MM(12),"\+++++---",$this->showBorder,"L");
		//print $this->chequeData->quantity();
		/*
		//Product 1 price
		$this->pdf->SetXY(PDFHelper::pixels_to_MM(355), PDFHelper::pixels_to_MM(658));
		$this->pdf->MultiCell(PDFHelper::pixels_to_MM(90),PDFHelper::points_to_MM(12),"100",$this->showBorder,"L");
		//Product 1 ORDERED 1
		$this->pdf->SetXY(PDFHelper::pixels_to_MM(510), PDFHelper::pixels_to_MM(658));
		$this->pdf->MultiCell(PDFHelper::pixels_to_MM(25),PDFHelper::points_to_MM(12),"10",$this->showBorder,"L");
		//Product 1 ORDERED 2
		$this->pdf->SetXY(PDFHelper::pixels_to_MM(540), PDFHelper::pixels_to_MM(658));
		$this->pdf->MultiCell(PDFHelper::pixels_to_MM(25),PDFHelper::points_to_MM(12),"10",$this->showBorder,"L");
		*/
		/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		//Product 2
		/*
		if(Product::$DEPOSIT_BOOK->invoice_amount() != 0)
		{
			$this->pdf->SetXY(32, 180.6);
			$this->pdf->MultiCell(PDFHelper::pixels_to_MM(220),PDFHelper::points_to_MM(12),Product::$DEPOSIT_BOOK->title,$this->showBorder,"L");
			//price
			$this->pdf->SetXY(94, 180.6);
			$this->pdf->MultiCell(25,PDFHelper::points_to_MM(12),Product::$DEPOSIT_BOOK->invoice_amount_formated(),$this->showBorder,"L");
		}
		*/
		if(  Product::$DEPOSIT_BOOK->discount !=0  || Product::$DEPOSIT_BOOK->invoice_amount() != 0)
		{
			$this->pdf->SetXY(32, 180.6);
			$this->pdf->MultiCell(PDFHelper::pixels_to_MM(220),PDFHelper::points_to_MM(12),
								  Product::$DEPOSIT_BOOK->title,$this->showBorder,"L");
			//price
			$this->pdf->SetXY(94, 180.6);
			$this->pdf->MultiCell(25,PDFHelper::points_to_MM(12),Product::$DEPOSIT_BOOK->invoice_amount_formated(),$this->showBorder,"L");	
		}
		/*
		//Product 2 Price
		$this->pdf->SetXY(PDFHelper::pixels_to_MM(355), PDFHelper::pixels_to_MM(682));
		$this->pdf->MultiCell(PDFHelper::pixels_to_MM(90),PDFHelper::points_to_MM(12),"100",$this->showBorder,"L");
		//Product 2 ORDERED 1
		$this->pdf->SetXY(PDFHelper::pixels_to_MM(510), PDFHelper::pixels_to_MM(682));
		$this->pdf->MultiCell(PDFHelper::pixels_to_MM(25),PDFHelper::points_to_MM(12),"10",$this->showBorder,"L");
		//Product 2 ORDERED 2
		$this->pdf->SetXY(PDFHelper::pixels_to_MM(540), PDFHelper::pixels_to_MM(682));
		$this->pdf->MultiCell(PDFHelper::pixels_to_MM(25),PDFHelper::points_to_MM(12),"10",$this->showBorder,"L");
		*/
		/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		//Product 3
		/*
		if(Product::$SSDWE->invoice_amount() != 0)
		{
			$this->pdf->SetXY(32, 187.0);
			$this->pdf->MultiCell(PDFHelper::pixels_to_MM(220),PDFHelper::points_to_MM(12),Product::$SSDWE->title,$this->showBorder,"L");
			//price
			$this->pdf->SetXY(94, 187.0);
			$this->pdf->MultiCell(25,PDFHelper::points_to_MM(12),Product::$SSDWE->invoice_amount_formated(),$this->showBorder,"L");
		}*/
		if(Product::$SSDWE->invoice_amount() != 0 ||  Product::$SSDWE->discount !=0 )
		{
			$this->pdf->SetXY(32, 187.0);
			$this->pdf->MultiCell(PDFHelper::pixels_to_MM(220),PDFHelper::points_to_MM(12),
								  Product::$SSDWE->title,$this->showBorder,"L");
			//price
			$this->pdf->SetXY(94, 187.0);
			$this->pdf->MultiCell(25,PDFHelper::points_to_MM(12),Product::$SSDWE->invoice_amount_formated(),$this->showBorder,"L");	
		}
		/*
		//Product 3 Price
		$this->pdf->SetXY(PDFHelper::pixels_to_MM(355), PDFHelper::pixels_to_MM(707));
		$this->pdf->MultiCell(PDFHelper::pixels_to_MM(90),PDFHelper::points_to_MM(12),"100",$this->showBorder,"L");
		//Product 3 ORDERED 1
		$this->pdf->SetXY(PDFHelper::pixels_to_MM(510), PDFHelper::pixels_to_MM(707));
		$this->pdf->MultiCell(PDFHelper::pixels_to_MM(25),PDFHelper::points_to_MM(12),"10",$this->showBorder,"L");
		//Product 3 ORDERED 2
		$this->pdf->SetXY(PDFHelper::pixels_to_MM(540), PDFHelper::pixels_to_MM(707));
		$this->pdf->MultiCell(PDFHelper::pixels_to_MM(25),PDFHelper::points_to_MM(12),"10",$this->showBorder,"L");
		*/
		/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		//Product 4
		/*
		if(Product::$SELF_INKING_STAMP->invoice_amount() != 0)
		{
			$this->pdf->SetXY(32, 193.2);
			$this->pdf->MultiCell(PDFHelper::pixels_to_MM(220),PDFHelper::points_to_MM(12),Product::$SELF_INKING_STAMP->title,$this->showBorder,"L");
			//price
			$this->pdf->SetXY(94, 193.2);
			$this->pdf->MultiCell(25,PDFHelper::points_to_MM(12),Product::$SELF_INKING_STAMP->invoice_amount_formated(),$this->showBorder,"L");
		}*/
		if(Product::$SELF_INKING_STAMP->invoice_amount() != 0 || Product::$SELF_INKING_STAMP->discount !=0 )
		{
			$this->pdf->SetXY(32, 193.2);
			$this->pdf->MultiCell(PDFHelper::pixels_to_MM(220),PDFHelper::points_to_MM(12),Product::$SELF_INKING_STAMP->title,$this->showBorder,"L");
			//price
			$this->pdf->SetXY(94, 193.2);
			$this->pdf->MultiCell(25,PDFHelper::points_to_MM(12),Product::$SELF_INKING_STAMP->invoice_amount_formated(),$this->showBorder,"L");
		}
		/*
		//Product 4 Price
		$this->pdf->SetXY(PDFHelper::pixels_to_MM(355), PDFHelper::pixels_to_MM(732));
		$this->pdf->MultiCell(PDFHelper::pixels_to_MM(90),PDFHelper::points_to_MM(12),"100",$this->showBorder,"L");
		//Product 4 ORDERED 1
		$this->pdf->SetXY(PDFHelper::pixels_to_MM(510), PDFHelper::pixels_to_MM(732));
		$this->pdf->MultiCell(PDFHelper::pixels_to_MM(25),PDFHelper::points_to_MM(12),"10",$this->showBorder,"L");
		//Product 4 ORDERED 2
		$this->pdf->SetXY(PDFHelper::pixels_to_MM(540), PDFHelper::pixels_to_MM(732));
		$this->pdf->MultiCell(PDFHelper::pixels_to_MM(25),PDFHelper::points_to_MM(12),"10",$this->showBorder,"L");
		*/
		/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		//Product 5
		/*
		if(Product::$DWE->invoice_amount())
		{
			$this->pdf->SetXY(32, 199.4);
			$this->pdf->MultiCell(PDFHelper::pixels_to_MM(220),PDFHelper::points_to_MM(12), Product::$DWE->title,$this->showBorder,"L");
			//price
			$this->pdf->SetXY(94, 199.4);
			$this->pdf->MultiCell(25,PDFHelper::points_to_MM(12),Product::$DWE->invoice_amount_formated(),$this->showBorder,"L");
		}*/
		if(Product::$DWE->invoice_amount() != 0 || Product::$DWE->discount !=0 )
		{
			$this->pdf->SetXY(32, 199.4);
			$this->pdf->MultiCell(PDFHelper::pixels_to_MM(220),PDFHelper::points_to_MM(12), Product::$DWE->title,$this->showBorder,"L");
			//price
			$this->pdf->SetXY(94, 199.4);
			$this->pdf->MultiCell(25,PDFHelper::points_to_MM(12),Product::$DWE->invoice_amount_formated(),$this->showBorder,"L");
		}
		/*
		//Product 5 Price
		$this->pdf->SetXY(PDFHelper::pixels_to_MM(355), PDFHelper::pixels_to_MM(757));
		$this->pdf->MultiCell(PDFHelper::pixels_to_MM(90),PDFHelper::points_to_MM(12),"100",$this->showBorder,"L");
		//Product 5 ORDERED 1
		$this->pdf->SetXY(PDFHelper::pixels_to_MM(510), PDFHelper::pixels_to_MM(757));
		$this->pdf->MultiCell(PDFHelper::pixels_to_MM(25),PDFHelper::points_to_MM(12),"10",$this->showBorder,"L");
		//Product 5 ORDERED 2
		$this->pdf->SetXY(PDFHelper::pixels_to_MM(540), PDFHelper::pixels_to_MM(757));
		$this->pdf->MultiCell(PDFHelper::pixels_to_MM(25),PDFHelper::points_to_MM(12),"10",$this->showBorder,"L");
		*/
		/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		
		/*
		if(Product::$CHEQUE_BINDER->invoice_amount())
		{
			//Product 6
			$this->pdf->SetXY(32, 206);
			$this->pdf->MultiCell(PDFHelper::pixels_to_MM(220),PDFHelper::points_to_MM(12),Product::$CHEQUE_BINDER->title,$this->showBorder,"L");
			//price
			$this->pdf->SetXY(94, 206);
			$this->pdf->MultiCell(25,PDFHelper::points_to_MM(12),Product::$CHEQUE_BINDER->invoice_amount_formated(),$this->showBorder,"L");
		}*/
		if(Product::$CHEQUE_BINDER->invoice_amount() != 0 || Product::$CHEQUE_BINDER->discount !=0 )
		{
			//Product 6
			$this->pdf->SetXY(32, 206);
			$this->pdf->MultiCell(PDFHelper::pixels_to_MM(220),PDFHelper::points_to_MM(12),Product::$CHEQUE_BINDER->title,$this->showBorder,"L");
			//price
			$this->pdf->SetXY(94, 206);
			$this->pdf->MultiCell(25,PDFHelper::points_to_MM(12),Product::$CHEQUE_BINDER->invoice_amount_formated(),$this->showBorder,"L");
		}
		/*//Product 6 Price
		$this->pdf->SetXY(PDFHelper::pixels_to_MM(355), PDFHelper::pixels_to_MM(780));
		$this->pdf->MultiCell(PDFHelper::pixels_to_MM(90),PDFHelper::points_to_MM(12),"100",$this->showBorder,"L");
		//Product 6 ORDERED 1
		$this->pdf->SetXY(PDFHelper::pixels_to_MM(510), PDFHelper::pixels_to_MM(780));
		$this->pdf->MultiCell(PDFHelper::pixels_to_MM(25),PDFHelper::points_to_MM(12),"10",$this->showBorder,"L");
		//Product 6 ORDERED 2
		$this->pdf->SetXY(PDFHelper::pixels_to_MM(540), PDFHelper::pixels_to_MM(780));
		$this->pdf->MultiCell(PDFHelper::pixels_to_MM(25),PDFHelper::points_to_MM(12),"10",$this->showBorder,"L");
		*/
		/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		
		//Rush charge
		if($this->chequeData->delivery() == "1-5 Business Days")
		{
			$this->pdf->SetXY(32, 212.2);
			$this->pdf->MultiCell(PDFHelper::pixels_to_MM(220),PDFHelper::points_to_MM(12),"".$this->chequeData->delivery(),$this->showBorder,"L");
			//price
			$this->pdf->SetXY(94, 212.2);
			$this->pdf->MultiCell(25,PDFHelper::points_to_MM(12),Product::$RUSH_SHIPPING->invoice_amount_formated(),$this->showBorder,"L");
		}
		//shiping
		/*
		if($_POST["shipping_price_INPUT"] != "0")
		{
			$this->pdf->SetXY(32, 218.3);
			$this->pdf->MultiCell(PDFHelper::pixels_to_MM(220),PDFHelper::points_to_MM(12),$_POST["shipping_price_INPUT_company"],$this->showBorder,"L");
			//price
			$this->pdf->SetXY(94, 218.3);
			$this->pdf->MultiCell(25,PDFHelper::points_to_MM(12),number_format($_POST["shipping_price_INPUT"],2),$this->showBorder,"L");
		}*/
		if($_POST["shipping_price_INPUT_company"] != "")
		{
			$this->pdf->SetXY(32, 218.3);
			$this->pdf->MultiCell(PDFHelper::pixels_to_MM(220),PDFHelper::points_to_MM(12),$_POST["shipping_price_INPUT_company"],$this->showBorder,"L");
			//price
			$this->pdf->SetXY(94, 218.3);
			$this->pdf->MultiCell(25,PDFHelper::points_to_MM(12),number_format($_POST["shipping_price_INPUT"],2),$this->showBorder,"L");	
		}
		/*//Product 7 Price
		$this->pdf->SetXY(PDFHelper::pixels_to_MM(355), PDFHelper::pixels_to_MM(803));
		$this->pdf->MultiCell(PDFHelper::pixels_to_MM(90),PDFHelper::points_to_MM(12),"100",$this->showBorder,"L");
		//Product 7 ORDERED 1
		$this->pdf->SetXY(PDFHelper::pixels_to_MM(510), PDFHelper::pixels_to_MM(803));
		$this->pdf->MultiCell(PDFHelper::pixels_to_MM(25),PDFHelper::points_to_MM(12),"10",$this->showBorder,"L");
		//Product 7 ORDERED 2
		$this->pdf->SetXY(PDFHelper::pixels_to_MM(540), PDFHelper::pixels_to_MM(803));
		$this->pdf->MultiCell(PDFHelper::pixels_to_MM(25),PDFHelper::points_to_MM(12),"10",$this->showBorder,"L");
		*/
		/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		//Product 8
		/*
		$this->pdf->SetXY(PDFHelper::pixels_to_MM(119), PDFHelper::pixels_to_MM(828));
		$this->pdf->MultiCell(PDFHelper::pixels_to_MM(220),PDFHelper::points_to_MM(12),"",$this->showBorder,"L");
		
		//Product 8 Price
		$this->pdf->SetXY(PDFHelper::pixels_to_MM(355), PDFHelper::pixels_to_MM(828));
		$this->pdf->MultiCell(PDFHelper::pixels_to_MM(90),PDFHelper::points_to_MM(12),"",$this->showBorder,"L");
		//Product 8 ORDERED 1
		$this->pdf->SetXY(PDFHelper::pixels_to_MM(510), PDFHelper::pixels_to_MM(828));
		$this->pdf->MultiCell(PDFHelper::pixels_to_MM(25),PDFHelper::points_to_MM(12),"10",$this->showBorder,"L");
		//Product 8 ORDERED 2
		$this->pdf->SetXY(PDFHelper::pixels_to_MM(540), PDFHelper::pixels_to_MM(828));
		$this->pdf->MultiCell(PDFHelper::pixels_to_MM(25),PDFHelper::points_to_MM(12),"10",$this->showBorder,"L");
		*/
		
		
		//Product 9
		/*
		if(Product::$LOGO->invoice_amount() != 0)
		{
			$this->pdf->SetXY(32, 224.3);
			$this->pdf->MultiCell(PDFHelper::pixels_to_MM(220),PDFHelper::points_to_MM(12),$this->chequeData->CILogoLabel(),$this->showBorder,"L");
			//price
			$this->pdf->SetXY(94, 224.3);
			$this->pdf->MultiCell(25,PDFHelper::points_to_MM(12),Product::$LOGO->invoice_amount_formated(),$this->showBorder,"L");
		}
		*/
		if(Product::$LOGO->invoice_amount() != 0)
		{
			$this->pdf->SetXY(32, 224.3);
			$this->pdf->MultiCell(PDFHelper::pixels_to_MM(220),PDFHelper::points_to_MM(12),$this->chequeData->CILogoLabel(),$this->showBorder,"L");
			//price
			$this->pdf->SetXY(94, 224.3);
			$this->pdf->MultiCell(25,PDFHelper::points_to_MM(12),Product::$LOGO->invoice_amount_formated(),$this->showBorder,"L");	
		}
		/*//Product 9 Price
		$this->pdf->SetXY(PDFHelper::pixels_to_MM(355), PDFHelper::pixels_to_MM(852));
		$this->pdf->MultiCell(PDFHelper::pixels_to_MM(90),PDFHelper::points_to_MM(12),"",$this->showBorder,"L");
		*/
		
		/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		//AMT 1 
		
		$this->pdf->SetFont("helvetica_bold", "", 11);
		$this->pdf->SetXY(PDFHelper::pixels_to_MM(660), PDFHelper::pixels_to_MM(655));
		$this->pdf->MultiCell(PDFHelper::pixels_to_MM(138),PDFHelper::points_to_MM(12),number_format($_POST["grand_total_INPUT"], 2),$this->showBorder,"C");
		/*//AUTH 1
		$this->pdf->SetXY(PDFHelper::pixels_to_MM(660), PDFHelper::pixels_to_MM(674));
		$this->pdf->MultiCell(PDFHelper::pixels_to_MM(138),PDFHelper::points_to_MM(12),"AUTH",$this->showBorder,"L");
		//DATE 1
		$this->pdf->SetXY(PDFHelper::pixels_to_MM(660), PDFHelper::pixels_to_MM(693));
		$this->pdf->MultiCell(PDFHelper::pixels_to_MM(138),PDFHelper::points_to_MM(12),"DATE",$this->showBorder,"L");
		//COMMENT 1
		$this->pdf->SetXY(PDFHelper::pixels_to_MM(660), PDFHelper::pixels_to_MM(712));
		$this->pdf->MultiCell(PDFHelper::pixels_to_MM(138),PDFHelper::points_to_MM(12),"COMMENT",$this->showBorder,"L");
		///////////////////////////////////////////////////////////////////
		//AMT 2 
		$this->pdf->SetXY(PDFHelper::pixels_to_MM(660), PDFHelper::pixels_to_MM(741));
		$this->pdf->MultiCell(PDFHelper::pixels_to_MM(138),PDFHelper::points_to_MM(12),"100",$this->showBorder,"L");
		//AUTH 2
		$this->pdf->SetXY(PDFHelper::pixels_to_MM(660), PDFHelper::pixels_to_MM(760));
		$this->pdf->MultiCell(PDFHelper::pixels_to_MM(138),PDFHelper::points_to_MM(12),"AUTH 2",$this->showBorder,"L");
		//DATE 2
		$this->pdf->SetXY(PDFHelper::pixels_to_MM(660), PDFHelper::pixels_to_MM(779));
		$this->pdf->MultiCell(PDFHelper::pixels_to_MM(138),PDFHelper::points_to_MM(12),"DATE 2",$this->showBorder,"L");
		//COMMENT 2
		$this->pdf->SetXY(PDFHelper::pixels_to_MM(660), PDFHelper::pixels_to_MM(796));
		$this->pdf->MultiCell(PDFHelper::pixels_to_MM(138),PDFHelper::points_to_MM(12),"COMMENT 2",$this->showBorder,"L");
		/////////////////////////////////////////////////////////////////////
		//TOTAL
		$this->pdf->SetXY(PDFHelper::pixels_to_MM(460), PDFHelper::pixels_to_MM(855));
		$this->pdf->MultiCell(PDFHelper::pixels_to_MM(90),PDFHelper::points_to_MM(12),"800",$this->showBorder,"C");
		//TAX %
		$this->pdf->SetXY(PDFHelper::pixels_to_MM(568), PDFHelper::pixels_to_MM(855));
		$this->pdf->MultiCell(PDFHelper::pixels_to_MM(35),PDFHelper::points_to_MM(12),"20",$this->showBorder,"C");
		//TAX $
		$this->pdf->SetXY(PDFHelper::pixels_to_MM(620), PDFHelper::pixels_to_MM(855));
		$this->pdf->MultiCell(PDFHelper::pixels_to_MM(70),PDFHelper::points_to_MM(12),"200",$this->showBorder,"C");
		//GRAND TOTAL
		$this->pdf->SetXY(PDFHelper::pixels_to_MM(706), PDFHelper::pixels_to_MM(855));
		$this->pdf->MultiCell(PDFHelper::pixels_to_MM(90),PDFHelper::points_to_MM(12),"1000",$this->showBorder,"C");
		*/
		//total price 
		$this->pdf->SetXY(122, 226);
		$this->pdf->MultiCell(23,PDFHelper::points_to_MM(12),number_format( $_POST["sub_total_products_INPUT"], 2),$this->showBorder,"C");
		//tax percent 
		$this->pdf->SetXY(150, 226);
		$this->pdf->MultiCell(10,PDFHelper::points_to_MM(12),$_POST["percentTaxesInput"],$this->showBorder,"C");
		//tax price 
		$this->pdf->SetXY(165, 226);
		$this->pdf->MultiCell(18,PDFHelper::points_to_MM(12),number_format($_POST["sub_total_taxes_INPUT"], 2),$this->showBorder,"C");
		//total amount
		$this->pdf->SetXY(187, 226);
		$this->pdf->MultiCell(23,PDFHelper::points_to_MM(12),number_format($_POST["grand_total_INPUT"], 2),$this->showBorder,"C");
		
		$this->pdf->SetFont("helvetica", "", 7);
	}
	
	//Billing details
	public function SetBillingDetails()
	{
		
		//Bill to   name on chq checkbox field
		$this->pdf->SetXY(PDFHelper::pixels_to_MM(46), PDFHelper::pixels_to_MM(890));
		$this->pdf->MultiCell(PDFHelper::pixels_to_MM(14),PDFHelper::points_to_MM(7),"X",$this->showBorder,"C");
		
		//Bill to   name on chq field
		$this->pdf->SetXY(PDFHelper::pixels_to_MM(100), PDFHelper::pixels_to_MM(881));
		$this->pdf->MultiCell(PDFHelper::pixels_to_MM(150),PDFHelper::points_to_MM(7),$_POST["companyName_".ChequeData::TYPE_BILLING],$this->showBorder,"L");
		///////////////////////////////////////////////////////////////////////////////
		$this->pdf->SetXY(PDFHelper::pixels_to_MM(100), PDFHelper::pixels_to_MM(895));
		$this->pdf->MultiCell(PDFHelper::pixels_to_MM(150),PDFHelper::points_to_MM(7),$_POST["contactName_".ChequeData::TYPE_BILLING],$this->showBorder,"L");
		//////////////////////////////////////////////////////////////////////////////
		$this->pdf->SetXY(PDFHelper::pixels_to_MM(280), PDFHelper::pixels_to_MM(895));
		$this->pdf->MultiCell(PDFHelper::pixels_to_MM(170),PDFHelper::points_to_MM(7),$_POST["phone_".ChequeData::TYPE_BILLING],$this->showBorder,"L");
		//Bill to   line two field
		$this->pdf->SetXY(PDFHelper::pixels_to_MM(48), PDFHelper::pixels_to_MM(917));
		$this->pdf->MultiCell(PDFHelper::pixels_to_MM(400),PDFHelper::points_to_MM(7),$_POST["address_1_".ChequeData::TYPE_BILLING],$this->showBorder,"L");
		//////////////////////////////////////////////////////////////////////////
		$this->pdf->SetXY(PDFHelper::pixels_to_MM(48), PDFHelper::pixels_to_MM(930));
		$this->pdf->MultiCell(PDFHelper::pixels_to_MM(400),PDFHelper::points_to_MM(7),$_POST["address_2_".ChequeData::TYPE_BILLING],$this->showBorder,"L");
		//Bill to   line tree field
		$this->pdf->SetXY(PDFHelper::pixels_to_MM(48), PDFHelper::pixels_to_MM(940));
		$this->pdf->MultiCell(PDFHelper::pixels_to_MM(400),PDFHelper::points_to_MM(7),$_POST["address_3_".ChequeData::TYPE_BILLING],$this->showBorder,"L");
		////////////////////////////////////////////////////////////////////////
		$this->pdf->SetXY(PDFHelper::pixels_to_MM(40), PDFHelper::pixels_to_MM(955));
		$this->pdf->MultiCell(PDFHelper::pixels_to_MM(100),PDFHelper::points_to_MM(7),$_POST["city_".ChequeData::TYPE_BILLING],$this->showBorder,"L");
		//////////////////////////////////////////////////////////////////////////
		$this->pdf->SetXY(PDFHelper::pixels_to_MM(150), PDFHelper::pixels_to_MM(955));
		$this->pdf->MultiCell(PDFHelper::pixels_to_MM(70),PDFHelper::points_to_MM(7),"Province:".$_POST["province_".ChequeData::TYPE_BILLING],$this->showBorder,"L");
		//////////////////////////////////////////////////////////////////////////
		$this->pdf->SetXY(PDFHelper::pixels_to_MM(225), PDFHelper::pixels_to_MM(955));
		$this->pdf->MultiCell(PDFHelper::pixels_to_MM(65),PDFHelper::points_to_MM(7),$_POST["postalCode_".ChequeData::TYPE_BILLING],$this->showBorder,"L");
		//////////////////////////////////////////////////////////////////////////
		$this->pdf->SetXY(PDFHelper::pixels_to_MM(300), PDFHelper::pixels_to_MM(955));
		$this->pdf->MultiCell(PDFHelper::pixels_to_MM(165),PDFHelper::points_to_MM(7),$_POST["email_".ChequeData::TYPE_BILLING],$this->showBorder,"L");
		
		//AIRMILES
		$this->pdf->SetXY(PDFHelper::pixels_to_MM(680), PDFHelper::pixels_to_MM(943));
		$this->pdf->MultiCell(PDFHelper::pixels_to_MM(110),PDFHelper::points_to_MM(12),$this->chequeData->airMilesCardNumber(),$this->showBorder,"L");
		
		//PYMT TYPE
		$this->pdf->SetFont("helvetica", "", 12);
		$this->pdf->SetXY(PDFHelper::pixels_to_MM(510), PDFHelper::pixels_to_MM(919));
		$this->pdf->MultiCell(PDFHelper::pixels_to_MM(90),PDFHelper::points_to_MM(12),$this->chequeData->MOP(),$this->showBorder,"L");
		//INVOICE checkbox  
		
		$this->pdf->SetFont("helvetica", "", 14); 
		$this->pdf->SetXY(PDFHelper::pixels_to_MM(657), PDFHelper::pixels_to_MM(917));
		$this->pdf->MultiCell(PDFHelper::pixels_to_MM(14),PDFHelper::points_to_MM(7),"x",$this->showBorder,"C");
		//EMAIL checkbox
		$this->pdf->SetXY(PDFHelper::pixels_to_MM(490), PDFHelper::pixels_to_MM(946));
		$this->pdf->MultiCell(PDFHelper::pixels_to_MM(14),PDFHelper::points_to_MM(7),"x",$this->showBorder,"C");
		
		//EMAIL field
		$this->pdf->SetFont("helvetica", "", 5);
		$this->pdf->SetXY(PDFHelper::pixels_to_MM(510), PDFHelper::pixels_to_MM(945));
		$this->pdf->MultiCell(PDFHelper::pixels_to_MM(120),PDFHelper::points_to_MM(12),$this->chequeData->CIEmail(),$this->showBorder,"L");
		
		//CC field
		$this->pdf->SetFont("helvetica", "", 12);
		$this->pdf->SetXY(PDFHelper::pixels_to_MM(480), PDFHelper::pixels_to_MM(890));
		$this->pdf->MultiCell(PDFHelper::pixels_to_MM(190),PDFHelper::points_to_MM(12),
					CreditCardNumber::formatCreditCard($this->chequeData->MOP_cardNumber(), " "),
							$this->showBorder,"L");
		$this->pdf->SetFont("helvetica", "", $this->fontSize);
		//EXP MONTH field
		$this->pdf->SetXY(PDFHelper::pixels_to_MM(712), PDFHelper::pixels_to_MM(890));
		$this->pdf->MultiCell(PDFHelper::pixels_to_MM(44),PDFHelper::points_to_MM(12),$this->chequeData->MOP_expMonth_number(),$this->showBorder,"R");
		$this->pdf->SetFont("helvetica", "", 12);
		//EXP 2 field
		$this->pdf->SetXY(PDFHelper::pixels_to_MM(757), PDFHelper::pixels_to_MM(890));
		$this->pdf->MultiCell(PDFHelper::pixels_to_MM(50),PDFHelper::points_to_MM(12),$this->chequeData->MOP_expYear(),$this->showBorder,"L");
		//CSV field
		$this->pdf->SetXY(PDFHelper::pixels_to_MM(725), PDFHelper::pixels_to_MM(918));
		$this->pdf->MultiCell(PDFHelper::pixels_to_MM(70),PDFHelper::points_to_MM(12),$this->chequeData->MOP_CSV(),$this->showBorder,"C");
		$this->pdf->SetFont("helvetica", "", $this->fontSize);
	}
	
	//Customer comments
	public function SetCustomerComments()
	{
		
		//Set font
		$this->pdf->SetFont("helvetica", "", 9);
		//CUSTOMER COMMENTS
		//Line 1
		$this->pdf->SetXY(PDFHelper::pixels_to_MM(24), PDFHelper::pixels_to_MM(970));
		$this->pdf->MultiCell(PDFHelper::pixels_to_MM(380),PDFHelper::points_to_MM(14),$this->chequeData->CIQuestionsAndComments(),$this->showBorder,"L");
		/*//Line 2
		$this->pdf->SetXY(PDFHelper::pixels_to_MM(24), PDFHelper::pixels_to_MM(992));
		$this->pdf->MultiCell(PDFHelper::pixels_to_MM(380),PDFHelper::points_to_MM(12),"Comment Line 2",$this->showBorder,"L");
		//Line 3
		$this->pdf->SetXY(PDFHelper::pixels_to_MM(24), PDFHelper::pixels_to_MM(1011));
		$this->pdf->MultiCell(PDFHelper::pixels_to_MM(380),PDFHelper::points_to_MM(12),"Comment Line 3",$this->showBorder,"L");
		//Line 4
		$this->pdf->SetXY(PDFHelper::pixels_to_MM(24), PDFHelper::pixels_to_MM(1030));
		$this->pdf->MultiCell(PDFHelper::pixels_to_MM(380),PDFHelper::points_to_MM(12),"Comment Line 4",$this->showBorder,"L");
		
		//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		//PRINT & CHEQUES NOW COMMENTS
		//Line 1
		$this->pdf->SetXY(PDFHelper::pixels_to_MM(412), PDFHelper::pixels_to_MM(972));
		$this->pdf->MultiCell(PDFHelper::pixels_to_MM(385),PDFHelper::points_to_MM(12),"Cheques comment 1",$this->showBorder,"L");
		//Line 2
		$this->pdf->SetXY(PDFHelper::pixels_to_MM(412), PDFHelper::pixels_to_MM(992));
		$this->pdf->MultiCell(PDFHelper::pixels_to_MM(385),PDFHelper::points_to_MM(12),"Cheques comment 2",$this->showBorder,"L");
		//Line 3
		$this->pdf->SetXY(PDFHelper::pixels_to_MM(412), PDFHelper::pixels_to_MM(1011));
		$this->pdf->MultiCell(PDFHelper::pixels_to_MM(385),PDFHelper::points_to_MM(12),"Cheques comment 3",$this->showBorder,"L");
		//Line 4
		$this->pdf->SetXY(PDFHelper::pixels_to_MM(412), PDFHelper::pixels_to_MM(1030));
		$this->pdf->MultiCell(PDFHelper::pixels_to_MM(385),PDFHelper::points_to_MM(12),"Cheques comment 4",$this->showBorder,"L");
		*/
	}
	
	//Save pdf file 
	public function saveToLocal($PDFName)
	{
		$this->pdf->Output($PDFName, "");
	}
	public function PDFContent()
	{
		if($this->outPutTOSErver == NULL)
		$this->outPutTOSErver = $this->pdf->Output($this->fileName, "S");
		return $this->outPutTOSErver;
	}
}

  //Test code
	if(isset($_GET["DO_TEST"]))
	{
		if(!class_exists("Product")){require_once("../products_moderator.php");}
		if(!class_exists("XMLParser")){require_once("../tools.php");}
		require_once("../pdf-tools/fpdf.php");
		require_once("../pdf-tools/pdf-helper.php");
		
		//require_once('../Mail.php');
		//require_once('../Mail/mime.php');
		//require_once("../tools/mail_message_template.php");
		 
			//XMLParser::ADD_ORDER_XML_TO_POST( "../orders/xml/M5366.xml" );
			//XMLParser::ADD_ORDER_XML_TO_POST( "../orders/xml/M5369.xml" );
		XMLParser::ADD_ORDER_XML_TO_POST( "../orders/xml/T_L5840.xml" );
		//XMLParser::ADD_ORDER_XML_TO_POST( "../orders/xml/T_L6189.xml" );
		//XMLParser::ADD_ORDER_XML_TO_POST( "../orders/xml/T_L6143.xml" );
		//XMLParser::ADD_ORDER_XML_TO_POST( SETTINGS::ORDERS_FOLDER_FOR_XML."T_M3932.xml" );
		$objCheque = new Cheque( $_POST["chequeType"] );
		$objChequeData = new ChequeData( $objCheque );
		$objOrderForm = new OrderFormTemplate( $objChequeData, true, "../" );
		$objOrderForm->saveToLocal("oft-testing.pdf");
	}
	
?>