<?php


	class Cheque
	{
		public static $cheque = NULL;
		const TYPE_LASER   = "laser";
		const TYPE_MANUAL  = "manual";
		const TYPE_THANK_U = "thankyou";
		const TYPE_ADMIN   = "ADMIN";
		const CHECKOUT	   = "checkout";
		const TRANSACTION_STATUS="trstat";
		const QUICK_RE_ORDER_FORM="Quick Re-Order Form";
		/////////////////////////////////////////////////////////////////////////
		var $type;
		var $cssMainWidth, $cheque_render_holder_width;
		
		public function Cheque($type_)
		{
			$this->type = $type_;
			$this->mainCSSSizeSet();
			$this->cheque_render_holderCSSSizeSet();
			self::$cheque = $this;
		}
		public function mainCSSSizeSet()
		{
			switch($this->type)
			{
				case Cheque::TYPE_LASER:
				{
					$this->cssMainWidth = "cheque_holder_width_laser";
				}break;
				case Cheque::TYPE_MANUAL:
				{
					$this->cssMainWidth = "cheque_holder_width_manual";
				}break;
			}
		}
		public function cheque_render_holderCSSSizeSet()
		{
			switch($this->type)
			{
				case Cheque::TYPE_LASER:
				{
					$this->cheque_render_holder_width = "cheque_render_holder_laser_width";
				}break;
				case Cheque::TYPE_MANUAL:
				{
					$this->cheque_render_holder_width = "cheque_render_holder_manual_width";
				}break;
			}
		}
	}
	class ChequeData
	{
		var $cheque;
		
		public static function SET_POST_DATA_FOR_USING()
		{
			foreach($_POST as $variableVAL=>$variable)
			{
				$_POST[$variableVAL] = stripslashes($_POST[$variableVAL]);
				//print "[".htmlentities($_POST[$variableVAL] , ENT_QUOTES, "UTF-8")."]<br>";
				
				/*
				 * Ovaa funkcija gi pecati za html ubavo, ama vo fpdf ne raboti dobro
				 * */
				//$_POST[$variableVAL] = htmlentities($_POST[$variableVAL] , ENT_QUOTES, "UTF-8");
				
				 /* 
				 * Raboti na html a isto i na pdfto gi pecati ubavo.
				 * */
				//print "[pred]".$_POST[$variableVAL]."[pred]<br/>";
				$_POST[$variableVAL] = iconv("UTF-8", "ISO-8859-1", $_POST[$variableVAL]);
				//print "[posle]".$_POST[$variableVAL]."[posle]<br/>";
				//print "[".$_POST[$variableVAL]."][-]<br>";
			}
		}
                
                public function get_order_number_reference()
                {
                    return $_POST["order_number_reference"];
                }
                
                public function  get_creator_type()
                {
                    $row_order_creator = DB_DETAILS::ADD_ACTION("
                    SELECT order_creator FROM orders_details WHERE orderNumber='".$this->get_order_number_reference()."'    
                    ", DB_DETAILS::$TYPE_SELECT);
                    if(count($row_order_creator) == 1){return $row_order_creator[0]["order_creator"];}
                    return OrderNumber::CREATOR_CLIENT;
                }


                /*
                 * When creating new order, i will define new time current,
                 * and will put into the order files.
                 * That variable for time of creating order will be used in future into order-form-template.php
                 */
                public static function SET_DATE_VALUE_FOR_NEW_ORDER__INTO_CHEQUE_DATA()
                {
                    $_POST["date_for_new_submited_order"] = time();
                }
                /*
                 * Getting the value
                 */
                public function date_for_new_submited_order()
                {
                    if(!isset($_POST["date_for_new_submited_order"])){return "";}
                    return $_POST["date_for_new_submited_order"];
                }
		
		public function ChequeData($cheque____)
		{
			self::SET_POST_DATA_FOR_USING();
			$this->cheque = $cheque____;
			$this->create_the_products();
		}
		private function create_the_products()
		{
			/*
			public static $DEPOSIT_BOOK;
			public static $DWE;
			public static $SSDWE;
			public static $CHEQUE_BINDER;
			public static $SELF_INKING_STAMP;
			*/
			if(!class_exists("Product")){require_once("products_moderator.php");}
			//Additional Products
			$additionalProductsIDs = explode(";", $_POST["additional_products_IDs"]);
			
			Product::$QUANTITY_AND_PRICES = Product::GET_BY_ID( $additionalProductsIDs[0] );
			
			Product::$DEPOSIT_BOOK = Product::GET_BY_ID( $additionalProductsIDs[1] );
			Product::$DWE = Product::GET_BY_ID( $additionalProductsIDs[2] );
			Product::$SSDWE = Product::GET_BY_ID( $additionalProductsIDs[3] );
			Product::$CHEQUE_BINDER = Product::GET_BY_ID( $additionalProductsIDs[4] );
			Product::$SELF_INKING_STAMP = Product::GET_BY_ID( $additionalProductsIDs[5] );
			
			Product::$LOGO = Product::GET_BY_ID( $additionalProductsIDs[6] );
			
			Product::$RUSH_SHIPPING = Product::GET_BY_ID( $additionalProductsIDs[7] );
		}
		
		public static $NORMAL_POST=NULL;
		public static function SETUP_POST_FOR_PDFs()
		{
			$NORMAL_POST = array();
			foreach($_POST as $variableVAL=>$variable)
			{
				ChequeData::$NORMAL_POST[$variableVAL]=$_POST[$variableVAL];
				//$_POST[$variableVAL] = iconv("UTF-8", "ISO-8859-1", $_POST[$variableVAL]);
			}
		}
		public static function SETUP_POST_NORMAL()
		{
			foreach(ChequeData::$NORMAL_POST as $variableVAL=>$variable)
			{
				$_POST[$variableVAL]=ChequeData::$NORMAL_POST[$variableVAL];
			}
		}
		public function sales_person_code()
		{
			$variables = explode(";", $_POST["sales_person_code_order_entered_by"]);
			return $variables[1];
		}
		public function order_entered_by()
		{
			$variables = explode(";", $_POST["sales_person_code_order_entered_by"]);
			return $variables[3];
		}
		
		public function order_submited_date()
		{
			$variables = explode(";", $_POST["order_submited_date_order_updated_date"]);
			return $variables[0];
		}
		public function order_updated_date()
		{
			$variables = explode(";", $_POST["order_submited_date_order_updated_date"]);
			return $variables[1];
		}
		////////////////////////////////////////////////////////////////////////
		///////ContactIfo
		public function CICompanyName(){return $_POST["CICompanyName"];}
		public function CIContactName(){return $_POST["CIContactName"];}
		public function CIPhone(){return $_POST["CIPhone"];}
		public function CIEmail(){return $_POST["CIEmail"];}
		public function CIQuestionsAndComments(){return $_POST["CIQuestionsAndComments"];}
		////////////////////////////////////////////////////////////////////////
		///////Pricing & Quantity
		/*
		var $quantityValueArr = NULL;
		function getQuantityValue()
		{
			if($_POST["quantityINPUT"] == "")
			{
				$this->quantityValueArr = array("0", "0","0","0", "");
			}
			else if($this->quantityValueArr == NULL){ $this->quantityValueArr = explode(";", $_POST["quantityINPUT"]);}
			return $this->quantityValueArr;
		} 
		public function quantity()
		{
			$values = $this->getQuantityValue();
			return $values[0];
		}
		public function quantityIndex()
		{
			$values = $this->getQuantityValue();
			return $values[1];
		}
		public function quantityMoney()
		{
			$values = $this->getQuantityValue();
			return $values[2];
		}
		public function quantityCountFree()
		{
			$values = $this->getQuantityValue();
			return $values[3];
		}
		public function quantityTitle()
		{
			return $_POST["quantityTitle"];
		}*/
		////////////////////////////////////////////////////////////////////////
		///////ChequeColors
		public function backgroundIndex(){return $_POST["backgroundINdex"];}
		public function backgroundURL()
		{
			if($this->cheque->type == Cheque::TYPE_LASER)
			{
				return "../images/backgrounds/".$this->backgroundIndex().".jpg";
			}
			else
			{
				return "../images/backgrounds-manual/".$this->backgroundIndex().".jpg";
			}
		}
		public function backgroundURLForOrder()
		{
			return "../images/backgrounds-manual-cheques-order/".$this->backgroundIndex().".jpg";
		}
		var $colors = array('DARK BLUE','TEAL GREEN','BURGUNDY','BROWN','GREY','SKY BLUE','REFLEX BLUE','GREEN','GOLD BUFF','RED');
		public function backgroundColor(){return $this->colors[$this->backgroundIndex()-1];}
		////////////////////////////////////////////////////////////////////////
		///////ChequePosition
		public function chequePosition(){return $_POST["chequePosition"];}
		public function chequePositionLABEL()
		{
			if($this->cheque->type == Cheque::TYPE_LASER)
			{
				switch($this->chequePosition())
				{
					case "1":{return "Top";}break;
					case "2":{return "Middle";}break;
					case "3":{return "Bottom";}break;
				}
			}
			else
			{
				if($_POST["chequePosition"] == "false")
				{
					return "x1 Cheques";
				}
				else
				{
					return "x2 Cheques";
				}
			}
		}
		function chequePosition__sufix()
		{
			switch($this->chequePosition())
			{
				case "1":{return "top";}break;
				case "2":{return "mid";}break;
				case "3":{return "bottom";}break;
			}
		}
		public function getURLForLaserNewBG()
		{
			return "../images/backgrounds-laser-new/".$this->backgroundIndex()."-".$this->chequePosition__sufix().".jpg";
		}
		public function isManualX1()
		{
			if($_POST["chequePosition"] == "false"){return true;}
			return false;
		}
		////////////////////////////////////////////////////////////////////////
		///////CompanyINfo
		///////CompanyINfocompanyNameAndAddress
		public function CINACompanyName(){return $_POST["compInfoName"];}
		public function CINACompanySecondName(){return $_POST["comInfoIsSecondCompanyName"];}
		public function CINAComapanyNameLinivche()
		{
			if($this->CINACompanySecondName() == ""){return $this->CINACompanyName();}
			return $this->CINACompanyName()." - ".$this->CINACompanySecondName();
		}
		public function companyPRPDFName(){return strtolower($this->CINAComapanyNameLinivche())."-pr.pdf";}
		public function companyREPDFName(){return strtolower($this->CINAComapanyNameLinivche())."-re.pdf";}
		
		public function compInfoAddressLine1(){return $_POST["compInfoAddressLine1"];}
		public function compInfoAddressLine2(){return $_POST["compInfoAddressLine2"];}
		public function compInfoAddressLine3(){return $_POST["compInfoAddressLine3"];}
		public function compInfoAddressLine4(){return $_POST["compInfoAddressLine4"];}
		
		const TYPE_BILLING="TYPE_BILLING";
		const TYPE_SHIPING="TYPE_SHIPING";
		public static $billingShipingVariables = array("companyName_","contactName_","address_1_","address_2_",
											    "address_3_","city_","province_","postalCode_","phone_","email_");
                
                public function province_TYPE_SHIPING(){return $_POST["province_TYPE_SHIPING"];}
		
		public function billingShippingParthHMTL($type)
		{
			return 'Company name:<b>'.$_POST["companyName_".$type].'</b><br/>
					Contact name:<b>'.$_POST["contactName_".$type].'</b><br/>
					Address:<br/>
					<b>'.$_POST["address_1_".$type].'</b><br/>
					<b>'.$_POST["address_2_".$type].'</b><br/>
					<b>'.$_POST["address_3_".$type].'</b><br/>
					City:<b>'.$_POST["city_".$type].'</b><br/>
					Province:<b>'.$_POST["province_".$type].'</b><br/>
					Postal Code:<b>'.$_POST["postalCode_".$type].'</b><br/>
					Phone:<b>'.$_POST["phone_".$type].'</b><br/>
					Email:<b>'.$_POST["email_".$type].'</b><br/>';
		}
		public function isBillToAlternativeName()
		{
			if($this->anotherNameForBIlling() == ""){return false;}
			return true;
		}
		public function anotherNameForBIlling()
		{
			return $_POST["isBillToAlternativeName"];
		}
		/*
		public function anotherNameForBillingHTML()
		{
			if($this->isBillToAlternativeName() == true)
			{
				return '<p style=" font-family:Arial; font-size:10pt;">Different Address For Billing: <b>'.$this->anotherNameForBIlling().'</b></p> '; 
			}
			return "";
		}
		*/
		public function anotherNameForBillingHTML()
		{
			if($this->isBillToAlternativeName() == false){return "";}
			if($this->isBillToAlternativeName() == true)
			{
				return '<p style=" font-family:Arial; font-size:10pt;">Different Address For Billing:<br/>
																								'.$this->billingShippingParthHMTL(self::TYPE_BILLING).'
																								</p> '; 
			}
		}
		public function isShipToDifferentAddress()
		{
			if($this->anotherAddressForShiping() == ""){return false;}
			return true;
		}
		
		public function isresidentialAddressBSM()
		{
			if($_POST["residentialAddressBSM"]=="true"){return true;}
			return false;
		}
		public function isnoSignatureRequiredBSM()
		{
			if($_POST["noSignatureRequiredBSM"]=="true"){return true;}
			return false;
		}
		public function additionalHTMLBSM()
		{
			$htmlFGOR = "";
			if($this->isresidentialAddressBSM()==true)
			{
				$htmlFGOR .= '<p style="font-family:Arial; font-size:10pt;"><b>Residential Address</b></p>';
			}
			if($this->isnoSignatureRequiredBSM()==true)
			{
				$htmlFGOR .= '<p style="font-family:Arial; font-size:10pt;"><b>No Signature Required</b></p>';
			}
			return $htmlFGOR;
		}
		public function anotherAddressForShiping()
		{
			return $_POST["isShipToDifferentAddress"];
		}
		/*
		public function anotherAddressForShipingHTML()
		{
			if($this->isShipToDifferentAddress() == true)
			{
				return  '<p style="font-family:Arial; font-size:10pt;">Different Address For Shipping: <b>'.$this->anotherAddressForShiping().'</b></p>';
			}
			return "";
		}
		*/
		public function anotherAddressForShipingHTML()
		{
			if($this->isShipToDifferentAddress() == false){return "";}
			if($this->shipingIsSameAsBilling()==true)
			{
				//return '<p style="font-family:Arial; font-size:10pt;">Different Address For Shipping: <b>Same as Billing Details</b></p>';
				return '<p style=" font-family:Arial; font-size:10pt;">Address For Shipping:<br/>
																								'.$this->billingShippingParthHMTL(self::TYPE_SHIPING).'
																								</p> ';
			}
			if($this->isShipToDifferentAddress() == true)
			{
				return '<p style=" font-family:Arial; font-size:10pt;">Different Address For Shipping:<br/>
																								'.$this->billingShippingParthHMTL(self::TYPE_SHIPING).'
																								</p> '; 
			}
		}
		public function shipingIsSameAsBilling()
		{
			if($_POST["SameAsBillingDetails"] == "true"){return true;}
			return false;
		}
		///////Logo
		/*
		public function CILogoType(){return $_POST["CILogoType"];}
		*/
		public function CILogoLabel()
		{
			switch(Product::$LOGO->title)
			{
				case "":{return "No logo Added";}break;
				case "one_time_charge":{return "Black Ink Only $".Product::$LOGO->invoice_amount_formated()." one time charge";}break;
				case "minimum_charge":{return "We will call you to go over pricing. Minimum Charge $".Product::$LOGO->invoice_amount_formated();}break;
			}
		}
		/*
		public function CILogoPrice()
		{
			switch($this->CILogoType())
			{
				case "-1":{return "0";}break;
				case "0":{return "15";}break;
				case "1":{return "90";}break;
			}
		}*/
		///////Bank Name and address
		public function compInfoBankName(){return $_POST["compInfoBankName"];}
		public function compInfoBankAddress1(){return $_POST["compInfoBankAddress1"];}
		public function compInfoBankAddress2(){return $_POST["compInfoBankAddress2"];}
		public function compInfoBankAddress3(){return $_POST["compInfoBankAddress3"];}
		public function compInfoBankAddress4(){return $_POST["compInfoBankAddress4"];}
		/////Us currency
		public function isCurrency()
		{
			if($_POST["isCurrencyINPUT"] == "true"){return true;}
			return false;
		}
		public function isCurrency45Number()
		{
			if($_POST["add45AfterAcountNumberInput"] == "true"){return true;}
			return false;
		}
		public function currencyNumber45()
		{
			if($this->isCurrency45Number()==true){return "45";}
			return "";
		}
		public function us_funds_label()
		{
			if($this->isCurrency() == true)
			{
				return "U.S. FUNDS";
			}
			else
			{
				return "Not SELECTED";
			}
		}
		/////Pricing, Quantity & Cheque Info
		public function softwareHTML()
		{
			if($this->cheque->type == Cheque::TYPE_MANUAL){return "";}
			return '<p style="font-family:Arial; font-size:10pt; text-align:left; margin:0px; padding:0px;">Software:&nbsp;<b></b>'. $this->software() .'</b></p>';
		}
		public function software()
		{
			$values = $this->getSoftwareValueArr();
			return $values[0];
		}
		public function softwareABS()
		{
			if($this->software() == "Other")return $_POST["compInfoEnterOtherSoftware"];
			return $this->software();
		}
		public function softwareIndex()
		{
			$values = $this->getSoftwareValueArr();
			return $values[1];
		}
		var $softwareValueArra = NULL;
		function getSoftwareValueArr()
		{
			if($_POST["softwareINPUT"] == "")
			{
				$softwareValueArra = array("", "0");
			}
			else if($this->softwareValueArra == NULL){ $this->softwareValueArra = explode(";", $_POST["softwareINPUT"]);}
			return $this->softwareValueArra;
		} 
		public function supplier()
		{
			if(!isset($_POST["compInfoClientSupplier"])){return "";}
			return $_POST["compInfoClientSupplier"];
		}
		public function supplierHTML()
		{
			//print "+".$this->supplier()."+";
			if($this->supplier() == ""){return "";}
			return '<p style="font-family:Arial; font-size:10pt; text-align:left; margin:0px; padding:0px;">Supplier: <b>'. $this->supplier().'</b></p>';
		}
		///
		public function startAtNumber()
		{
			if(!is_numeric($_POST["compInfoStartAt"])){return "000000";}
			return $_POST["compInfoStartAt"]."";
		}
		public function startAtNumber_plus_1(){return $_POST["startAtNumber_plus_1"];}
		public function startAtNumberDD($number){return "C".$number."C";}
		public function startAtNumberShow(){return $_POST["compInfoStartAtTrueOrFalse"];}
		public function thereIsSecondSignature()
		{
			if($_POST["isThereSecondSignature"] == "SIGNATURE_x2")return true;
			return false;
		}
		public function labelForSecondSignature(){if($this->thereIsSecondSignature()==true)return "YES";return "NO";}
		public function labelForSecondSignature__2(){if($this->thereIsSecondSignature()==true)return "2 SIGS";return "1 SIG";}
		public function brunchNumber()
		{
			if(!is_numeric($_POST["compInfoBrunchNumber"])){return "00000";}
			return $_POST["compInfoBrunchNumber"];
		}
		public function transitNumber()
		{
			if(!is_numeric($_POST["compInfoTransitNumber"])){return "000";}
			return $_POST["compInfoTransitNumber"];
		}
		public function accountNumber()
		{
			return $_POST["compInfoAccountNumber"];
		}
		public function accountNumber__newFontWriteSTR()
		{
			$accountN = $this->accountNumber();
			$ACCOUNTN = "";
			for($iL=0;$iL<strlen($accountN);$iL++)
			{
				if($accountN[$iL] == '-')$ACCOUNTN = $ACCOUNTN."D";
				else if($accountN[$iL] == ' ')$ACCOUNTN = $ACCOUNTN." ";
				else $ACCOUNTN = $ACCOUNTN.$accountN[$iL];
			}
			return $ACCOUNTN."C";
		}
		////Boxing
		public function boxingType()
		{
			if($this->cheque->type == Cheque::TYPE_MANUAL){return "";}
			return urldecode($_POST["boxingType"]);
		}
		public function boxingTypeHTML()
		{
			if($this->cheque->type == Cheque::TYPE_MANUAL){return "";}
			return '<p style="font-family:Arial; font-size:10pt; text-align:left; margin:0px; padding:0px;">Boxing Type:<b> '. $this->boxingType() .' </b></p>';
		}
		public function depositBooksHTML()
		{
			if(Product::$DEPOSIT_BOOK->invoice_amount()==0)
			{
				return "";
			}
			return '<p style="font-family:Arial; font-size:10pt; text-align:left; margin:0px; padding:0px;">Deposit Books:<b>  '.Product::$DEPOSIT_BOOK->title.' $'.Product::$DEPOSIT_BOOK->invoice_amount_formated().'</b></p><br/>';
		}
		public function DWEHTML()
		{
			if(Product::$DWE->invoice_amount()==0)
			{
				return "";
			}
			return '<p style="font-family:Arial; font-size:10pt; text-align:left; margin:0px; padding:0px;">Double Window Envelopes (DWE):<b>'. Product::$DWE->title.' $'.Product::$DWE->invoice_amount_formated().'</b></p>';
		}
		public function SSWEHTML()
		{
			if(Product::$SSDWE->invoice_amount()==0){return "";}
			return '<p style="font-family:Arial; font-size:10pt; text-align:left; margin:0px; padding:0px;">Self Seal Double Window Envelopes (SSDWE):<b>'.Product::$SSDWE->title .' $'.Product::$SSDWE->invoice_amount_formated().'</b></p>';
		}
		public function chequeBinderHTML()
		{
			if(Product::$CHEQUE_BINDER->invoice_amount()==0){return "";} 
			return '<p style="font-family:Arial; font-size:10pt; text-align:left; margin:0px; padding:0px;">Cheque Binder: <b>'.
			Product::$CHEQUE_BINDER->title.' $'.Product::$CHEQUE_BINDER->invoice_amount_formated().'</b></p>';
		}
		public function SelfInkingHTML()
		{
			if(Product::$SELF_INKING_STAMP->invoice_amount()==0){return "";}
			return '<p style="font-family:Arial; font-size:10pt; text-align:left; margin:0px; padding:0px;">Self Inking Stamp:<b>'
			.Product::$SELF_INKING_STAMP->title.' $'.Product::$SELF_INKING_STAMP->invoice_amount_formated().'</b></p>';
		}
		////////////////////////////////////////////////////////////////////////
		///////Delivery
		public function delivery(){return $_POST["deliveryINPUT"];}
		public function deliveryHTML()
		{
			if($this->delivery() == "Standard 8-10 Business Days")
			{
				return "";
			}
			return '<p style="font-family:Arial; font-size:10pt; text-align:left; margin:0px; padding:0px; ">Delivery:&nbsp;<b>($'.Product::$RUSH_SHIPPING->invoice_amount_formated().' Charge) '.$this->delivery().'</b></p> ' ;
		}
		public function deliveryShippingCompany()
		{
			return $_POST["shipping_price_INPUT_company"];
		}
		public function deliveryShippingCompanyLabel()
		{
			if($this->deliveryShippingCompany() == ""){return "-";}
			return $this->deliveryShippingCompany();
		}
		///////////////////////////////////////////////////////////////////////
		/////////AIRMILES Reward Miles
		public function airMilesCardNumber(){return $_POST["AIRMILES_cardNumber"];}
		///////////////////////////////////////////////////////////////////////
		/////////MOP
		public function MOP_cardNumber()
		{
			return $_POST['MOP_cardNum'];;
		}
		public function MOP_CSV()
		{
			return $_POST["MOPcsv"];
		}
		public function MOP()
		{
			return $_POST['mopINPUT'];
		}
		public function MOP_expMonth()
		{
			return $_POST['mopExpirtyMonthINPUT'];;
		}
		public $months = array("Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec");
		public function MOP_expMonth_number()
		{
			for($i=0;$i<count($this->months);$i++)
			{
				if($this->MOP_expMonth() == $this->months[$i])
				{
					$index = $i+1;
					if($index < 10)
					{
						return "0".$index;
					}
					return $index;
				}
			}
			return "";
		}
		public function MOP_expYear()
		{
			return $_POST['mopExpirtyYearINPUT'];
		}
		public function MOP_callMe()
		{
			if($_POST['mopCallMe'] == "true")return true;
			return false;
		}
		public function MOP_callMeOrNot()
		{
			if($this->MOP_callMe() == true){return "YES";}
			return "NO";
		}
		public function MOPHtml()
		{
			return '<p style="font-family:Arial; font-size:10pt; text-align:left; margin:0px; padding:0px;">Method Of Payment:<b>'.$this->MOP().'</b></p>
					<p style="font-family:Arial; font-size:10pt; text-align:left; margin:0px; padding:0px;">Card Number:<b>'.$this->MOP_cardNumber().'</b>, CSV:<b>'.$this->MOP_CSV().'</b></p><br/>
					<p style="font-family:Arial; font-size:10pt; text-align:left; margin:0px; padding:0px;">Expiry Month:<b>'.$this->MOP_expMonth().'</b></p>
					<p style="font-family:Arial; font-size:10pt; text-align:left; margin:0px; padding:0px;">Expiry Year:<b>'.$this->MOP_expYear().'</b></p><br/>
					<p style="font-family:Arial; font-size:10pt; text-align:left; margin:0px; padding:0px;">'.$this->MOP_callMeOrNot().'</p><br/><br/>';
		}
		public function totalPrice()
		{
			return $this->deliveryPrice()+$this->quantityMoney();
		}
		
		
		public function chequeInfoHTML()
		{
			$htmlTotal = '';
			$htmlTotal .= '<p style="font-family:Arial; font-size:10pt; text-align:left; margin:0px; padding:0px;"><b>Cheque Info &nbsp;-&nbsp; Cheque Info</b></p><br/>';
			$htmlTotal .= '<p style="font-family:Arial; font-size:10pt; text-align:left; margin:0px; padding:0px;">Quantity:&nbsp;<b>'. Product::$QUANTITY_AND_PRICES->title .'</b></p>';
			$htmlTotal .= '<p style="font-family:Arial; font-size:10pt; text-align:left; margin:0px; padding:0px;">Start At:<b>'. $this->startAtNumber() .'</b></p>';
			$htmlTotal .= '<p style="font-family:Arial; font-size:8pt; text-align:left; margin:0px; padding:0px;">Second Signature: <b>'. $this->labelForSecondSignature() .'</b></p>';
			$htmlTotal .= '<p style="font-family:Arial; font-size:8pt; text-align:left; margin:0px; padding:0px;">Logo Status: <b>'. $this->CILogoLabel() .'</b></p>';
			$htmlTotal .= '<p style="font-family:Arial; font-size:10pt; text-align:left; margin:0px; padding:0px;">Cheque color:<b>'. $this->backgroundColor() .'</b><br/>Cheque style:<b>'.$this->chequePositionLABEL().'</b></p>';
			$htmlTotal .= $this->deliveryHTML();
			return $htmlTotal;
		}
		/*
		public static $DEPOSIT_BOOK;
		public static $DWE;
		public static $SSDWE;
		public static $CHEQUE_BINDER;
		public static $SELF_INKING_STAMP;
		*/
		public function additionalProductsHTML()
		{
			if(Product::$DEPOSIT_BOOK->invoice_amount()==0 && Product::$CHEQUE_BINDER->invoice_amount()==0
			 && Product::$SELF_INKING_STAMP->invoice_amount()==0){return "";}
			$htmlTotal = '<p style="font-family:Arial; font-weight:bold; font-size:10pt; text-align:left; margin:0px; padding:0px; ">Cheque Info &nbsp;-&nbsp; Additional Products</p><br />';
			if(Product::$DEPOSIT_BOOK->invoice_amount()!=0)
			$htmlTotal .= $this->depositBooksHTML();
			if(Product::$CHEQUE_BINDER->invoice_amount()!=0)
			$htmlTotal .= $this->chequeBinderHTML();
			if(Product::$SELF_INKING_STAMP->invoice_amount()!=0)
			$htmlTotal .= $this->SelfInkingHTML();
			return $htmlTotal;
		}
	}

?>