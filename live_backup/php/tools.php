<?php
	if(!class_exists("SETTINGS")){require_once("settings.php");}
	if(!class_exists("DB_DETAILS")){require_once( "db_details.php" );}
	
	global $WHEN_UPDATING_CHEQUE_IS_NEW;
	$GLOBALS["WHEN_UPDATING_CHEQUE_IS_NEW"] = true;
		
	class HELPWordpress
	{
		/*
		Page details:
		http://codex.wordpress.org/Function_Reference/get_page
		*/
		/*
		bloginfo
		name                 = Testpilot
		description          = Just another WordPress blog
		admin_email          = admin@example
		
		url                  = http://example/home
		wpurl                = http://example/home/wp
		
		stylesheet_directory = http://example/home/wp/wp-content/themes/child-theme
		stylesheet_url       = http://example/home/wp/wp-content/themes/child-theme/style.css
		template_directory   = http://example/home/wp/wp-content/themes/parent-theme
		template_url         = http://example/home/wp/wp-content/themes/parent-theme
		
		atom_url             = http://example/home/feed/atom
		rss2_url             = http://example/home/feed
		rss_url              = http://example/home/feed/rss
		pingback_url         = http://example/home/wp/xmlrpc.php
		rdf_url              = http://example/home/feed/rdf
		
		comments_atom_url    = http://example/home/comments/feed/atom
		comments_rss2_url    = http://example/home/comments/feed
		
		charset              = UTF-8
		html_type            = text/html
		language             = en-US
		text_direction       = ltr
		version              = 3.1
		*/
		public static function template_url()
		{
			$template_url = bloginfo("template_url");
			return $template_url;
		}
		public static function url(){return bloginfo("url");}
		
		public function HELPWordpress()
		{
		}
		///////////////////////////////////////////////////////
		static $ALL_COUNTRIES=NULL;
		public static function ALL_COUNTRIES_GET()
		{
			if(HELPWordpress::$ALL_COUNTRIES == NULL)
			{
				HELPWordpress::$ALL_COUNTRIES = DB_DETAILS::ADD_ACTION("SELECT * FROM countries", DB_DETAILS::$TYPE_SELECT);
			}
			return HELPWordpress::$ALL_COUNTRIES;
		}
		public static function ALL_COUNTRIES_OPTIONS_ADD()
		{
			$allCountries = HELPWordpress::ALL_COUNTRIES_GET();
			for($i=0;$i<count($allCountries);$i++)
			{
				print '
						<option>'.$allCountries[$i]["countries_name"].'</option>
					';
			}
		}
		
		static $ALL_CANADA_PROVINCIES=NULL;
		public static function GET_ALL_CANADA_PROVINCIES()
		{
			if(self::$ALL_CANADA_PROVINCIES==NULL)
			{
				self::$ALL_CANADA_PROVINCIES = DB_DETAILS::ADD_ACTION("SELECT * FROM canada_provincies ORDER BY abv", DB_DETAILS::$TYPE_SELECT);
			}
			return self::$ALL_CANADA_PROVINCIES;
		}
		public static function PRIN_ALL_CANADA_PROVINCIES_OPTIONS()
		{
			$allProvincies = self::GET_ALL_CANADA_PROVINCIES();
			for($i=0;$i<count($allProvincies);$i++)
			{
				print '
						<option>'.$allProvincies[$i]["abv"].'</option>
					';
			}
		}
		
		static $ALL_USA_STATES=NULL;
		public static function GET_ALL_USA_STATES()
		{
			if(self::$ALL_USA_STATES==NULL)
			{
				self::$ALL_USA_STATES = DB_DETAILS::ADD_ACTION("SELECT * FROM usa_states ORDER BY state_code", DB_DETAILS::$TYPE_SELECT);
			}
			return self::$ALL_USA_STATES;
		}
		public static function PRIN_ALL_USA_STATES_OPTIONS()
		{
			$allStates = self::GET_ALL_USA_STATES();
			for($i=0;$i<count($allStates);$i++)
			{
				print '
						<option>'.$allStates[$i]["state_code"].'</option>
					';
			}
		}
		
		const UPPER_LETTERS = "ABCDEFGHIKLMNOPQRSTVXYZ";
		//const UPPER_LETTERS = "ABCD";
		public static function delete_directory($dirname) 
		{
		   if (is_dir($dirname))
			  $dir_handle = opendir($dirname);
		   if (!$dir_handle)
			  return false;
		   while($file = readdir($dir_handle)) {
			  if ($file != "." && $file != "..") {
				 if (!is_dir($dirname."/".$file))
					unlink($dirname."/".$file);
				 else
					delete_directory($dirname.'/'.$file);    
			  }
		   }
		   closedir($dir_handle);
		   rmdir($dirname);
		   return true;
		}
	}
	class Cheque
	{
		public static $cheque;
		const TYPE_LASER   = "laser";
		const TYPE_MANUAL  = "manual";
		const TYPE_THANK_U = "thankyou";
		const TYPE_ADMIN   = "ADMIN";
		const CHECKOUT	   = "checkout";
		const TRANSACTION_STATUS="trstat";
		/////////////////////////////////////////////////////////////////////////
		var $type;
		var $cssMainWidth, $cheque_render_holder_width;
		
		public function Cheque($type_)
		{
			$this->type = $type_;
			$this->mainCSSSizeSet();
			$this->cheque_render_holderCSSSizeSet();
			Cheque::$cheque = $this;
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
		
		public function ChequeData($cheque____)
		{
			foreach($_POST as $variableVAL=>$variable)
			{
				$_POST[$variableVAL] = str_replace("\'", "'", $_POST[$variableVAL]);
				$_POST[$variableVAL] = str_replace('\"', '"', $_POST[$variableVAL]);
				//$_POST[$variableVAL] = htmlentities($_POST[$variableVAL] , ENT_QUOTES, "UTF-8");
			}
			
			$this->cheque = $cheque____;
		}
		public static $NORMAL_POST=NULL;
		public static function SETUP_POST_FOR_PDFs()
		{
			$NORMAL_POST = array();
			foreach($_POST as $variableVAL=>$variable)
			{
				ChequeData::$NORMAL_POST[$variableVAL]=$_POST[$variableVAL];
				$_POST[$variableVAL] = iconv("UTF-8", "ISO-8859-1", $_POST[$variableVAL]);
			}
		}
		public static function SETUP_POST_NORMAL()
		{
			foreach(ChequeData::$NORMAL_POST as $variableVAL=>$variable)
			{
				$_POST[$variableVAL]=ChequeData::$NORMAL_POST[$variableVAL];
			}
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
		var $quantityValueArr = NULL;
		function getQuantityValue()
		{
			if($_POST["quantityINPUT"] == "")
			{
				$this->quantityValueArr = array("0", "0","0","0");
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
		var $colors = array('DARK BLUE','TEAL GREEN','BURGUNOY','BROWN','GREY','SKY BLUE','REFLEX BLUE','GREEN','GOLD BUFF','RED');
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
		public function CILogoType(){return $_POST["CILogoType"];}
		public function CILogoLabel()
		{
			switch($this->CILogoType())
			{
				case "-1":{return "No logo Added";}break;
				case "0":{return "Black Ink Only $15 one time charge";}break;
				case "1":{return "We will call you to go over pricing. Minimum Charge $90";}break;
			}
		}
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
			return $_POST["compInfoStartAt"];
		}
		public function startAtNumber_plus_1(){return $_POST["startAtNumber_plus_1"];}
		public function startAtNumberDD($number){return "C".$number."C";}
		public function startAtNumberShow(){return $_POST["compInfoStartAtTrueOrFalse"];}
		public function thereIsSecondSignature(){if($_POST["isThereSecondSignature"] == "true")return true;else return false;}
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
		public function accountNumber(){return $_POST["compInfoAccountNumber"];}
		public function accountNumber__newFontWriteSTR()
		{
			$accountN = $this->accountNumber();
			$ACCOUNTN = "";
			for($iL=0;$iL<strlen($accountN);$iL++)
			{
				if($accountN[$iL] == '-')$ACCOUNTN = $ACCOUNTN."D";
				else if($accountN[$iL] == ' ')$ACCOUNTN = $ACCOUNTN."  ";
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
		////Additional PRoducts
		public function depositBooks(){return $_POST["depositBooksINPUT"];}
		private $depositBooksINPUT_VARs=NULL;
		public function depositBooksCopies()
		{
			if($this->depositBooksINPUT_VARs == NULL){$this->depositBooksINPUT_VARs = explode(";", $_POST["depositBooksINPUT_VARs"]);}
			return $this->depositBooksINPUT_VARs[0];
		} 
		public function depositBooksCount()
		{
			if($this->depositBooksINPUT_VARs == NULL){$this->depositBooksINPUT_VARs = explode(";", $_POST["depositBooksINPUT_VARs"]);}
			return $this->depositBooksINPUT_VARs[1];
		}
		public function depositBooksTotalPrice()
		{
			if($this->depositBooksINPUT_VARs == NULL){$this->depositBooksINPUT_VARs = explode(";", $_POST["depositBooksINPUT_VARs"]);}
			return $this->depositBooksINPUT_VARs[2];
		}
		public function DWE(){return $_POST["DWEINPUT"];}
		public function DWEHTML()
		{
			if($this->cheque->type == Cheque::TYPE_MANUAL){return "";}
			return '<p style="font-family:Arial; font-size:10pt; text-align:left; margin:0px; padding:0px;">Double Window Envelopes (DWE):<b>'. $this->DWE().'</b></p>';
		}
		public function SSDWE(){return $_POST["SSDWEINPUT"];}
		public function SSWEHTML()
		{
			if($this->cheque->type == Cheque::TYPE_MANUAL){return "";}
			return '<p style="font-family:Arial; font-size:10pt; text-align:left; margin:0px; padding:0px;">Self Seal Double Window Envelopes (SSDWE):<b>'.$this->SSDWE() .'</b></p>';
		}
		public function chequeBinder(){return $_POST["chequeBinderINPUT"];}
		public function chequeBinderHTML()
		{
			if($this->cheque->type == Cheque::TYPE_LASER){return "";}
			if($this->chequeBinder() == "")return "";
			return '<p style="font-family:Arial; font-size:10pt; text-align:left; margin:0px; padding:0px;">Cheque Binder: <b>'.$this->chequeBinder().'</b></p>';
		}
		public function SelfInkingStampLABEL(){return $_POST["SelfLinkStampINPUT"];}
		public function SelfInkingHTML()
		{
			if($this->SelfInkingStampLABEL()==""){return "";}
			return '<p style="font-family:Arial; font-size:10pt; text-align:left; margin:0px; padding:0px;">Self Inking Stamp:<b>'
			.$this->SelfInkingStampLABEL().'</b></p>';
		}
		////////////////////////////////////////////////////////////////////////
		///////Delivery
		public function delivery(){return $_POST["deliveryINPUT"];}
		public function deliveryHTML()
		{
			return '<p style="font-family:Arial; font-size:10pt; text-align:left; margin:0px; padding:0px; ">Delivery:&nbsp;<b>'.$this->delivery().'</b></p> ' ;
		}
		public function deliveryPrice()
		{
			if($this->delivery()=="Rush 24-48 hours($25 Charge)"){return 25;}
			return 0;
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
			$htmlTotal .= '<p style="font-family:Arial; font-size:10pt; text-align:left; margin:0px; padding:0px;">Quantity:&nbsp;<b>'. $this->quantity() .'</b></p>';
			$htmlTotal .= '<p style="font-family:Arial; font-size:10pt; text-align:left; margin:0px; padding:0px;">Start At:<b>'. $this->startAtNumber() .'</b></p>';
			$htmlTotal .= '<p style="font-family:Arial; font-size:8pt; text-align:left; margin:0px; padding:0px;">Second Signature: <b>'. $this->labelForSecondSignature() .'</b></p>';
			$htmlTotal .= '<p style="font-family:Arial; font-size:8pt; text-align:left; margin:0px; padding:0px;">Logo Status: <b>'. $this->CILogoLabel() .'</b></p>';
			$htmlTotal .= '<p style="font-family:Arial; font-size:10pt; text-align:left; margin:0px; padding:0px;">Cheque color:<b>'. $this->backgroundColor() .'</b><br/>Cheque style:<b>'.$this->chequePositionLABEL().'</b></p>';
			$htmlTotal .= $this->deliveryHTML();
			return $htmlTotal;
		}
		public function additionalProductsHTML()
		{
			if($this->depositBooks()=="" && $this->chequeBinderHTML()=="" &&$this->SelfInkingHTML()==""){return "";}
			$htmlTotal = '<p style="font-family:Arial; font-weight:bold; font-size:10pt; text-align:left; margin:0px; padding:0px; ">Cheque Info &nbsp;-&nbsp; Additional Products</p><br />';
			if($this->depositBooks()!="")
			$htmlTotal .= '<p style="font-family:Arial; font-size:10pt; text-align:left; margin:0px; padding:0px;">Deposit Books:<b> '. $this->depositBooks().' </b></p>';
			if($this->chequeBinderHTML()!="")
			$htmlTotal .= $this->chequeBinderHTML();
			if($this->SelfInkingHTML()!="")
			$htmlTotal .= $this->SelfInkingHTML();
			return $htmlTotal;
		}
	}
	class SendEMail
	{
		var $chequeTemplate,
			$chequePROrder,
			$chequeREOrder,
			$chequeOrderFormTemplate,
			$chequeDepositSlips,
			$chequPADebit,
			$dfs_stamp,
			$bct_stamp;
		var $cheque,
			$objChequeData,
			$emailTemplate;
		
		public function SendEMail( $objCheque__ , $sendEmailYes__)
		{
			require_once('Mail.php');
			require_once('Mail/mime.php');
			require_once("pdf-tools/fpdf.php");
			require_once("pdf-tools/pdf-helper.php");
			require_once("mail_message_template.php");
			require_once("backupmessage.php");
			
			$this->cheque = $objCheque__;
			$this->objChequeData = new ChequeData( $this->cheque );
			
			/////////////////////////////////////////////////////////////////////
			ChequeData::SETUP_POST_FOR_PDFs();
			/////////////////////////////////////////////////////////////////////
			switch($this->cheque->type)
			{
				case Cheque::TYPE_LASER:
				{
					/*
					require_once("laser-template.php");
					$this->chequeTemplate = new CHEQUE_TEMPLATE( $this->objChequeData, $this->cheque );
					*/
				}break;
				case Cheque::TYPE_MANUAL:
				{
					/*
					require_once("manual-template.php");
					$this->chequeTemplate = new CHEQUE_TEMPLATE( $this->objChequeData, $this->cheque );
					*/
				}break;
			}
			if($this->cheque->type == Cheque::TYPE_LASER)
			{
				require_once('blank-a4-ch-laser.php');
				$this->chequeTemplate = new BlankA4Cheque($this->objChequeData, false, true);
			}
			else
			{
				require_once('blank-a4-ch-manual.php');
				$this->chequeTemplate = new BlankA4Cheque( $this->objChequeData, false, true);
			}
			$this->chequePROrder = new BlankA4Cheque( $this->objChequeData, false );
			$this->chequeREOrder = new BlankA4Cheque( $this->objChequeData, true );
			require_once("order-form-template.php");
			require_once("deposit-slips.php");
			require_once("pa-debit.php");
			require_once("dfs-stamp.php");
			$this->chequeOrderFormTemplate = new OrderFormTemplate( $this->objChequeData, false );
			$this->chequeDepositSlips      = new DepositSlips( $this->objChequeData );
			$this->chequPADebit            = new PA_Debit( $this->objChequeData );
			$this->dfs_stamp               = new DFSStamp( DFSStamp::DFS, $this->objChequeData );
			$this->bct_stamp               = new DFSStamp( DFSStamp::BCT, $this->objChequeData );
			
			if(isset($_POST["after_updating_order"]))
			{
				$this->DELETE_CURR_ORDER_FOLDER_WHEN_UPDATING();
			}
			if(!is_dir(SETTINGS::ORDERS______URL().OrderNumber::$CURR_ORDER->orderLabel_withPower() ))
			{
				mkdir( SETTINGS::ORDERS______URL().OrderNumber::$CURR_ORDER->orderLabel_withPower() );
			}
			//print "[".SETTINGS::ORDERS______URL().OrderNumber::$CURR_ORDER->orderLabel_withPower()."]";
			$this->chequeTemplate->saveToLocal(SETTINGS::ORDERS______URL().OrderNumber::$CURR_ORDER->orderLabel_withPower()."/cheque.pdf");
			$this->chequePROrder->saveToLocal(SETTINGS::ORDERS______URL().OrderNumber::$CURR_ORDER->orderLabel_withPower()."/chequePROrder.pdf");
			$this->chequeREOrder->saveToLocal(SETTINGS::ORDERS______URL().OrderNumber::$CURR_ORDER->orderLabel_withPower()."/chequeREOrder.pdf");
			$this->chequeOrderFormTemplate->saveToLocal(SETTINGS::ORDERS______URL().OrderNumber::$CURR_ORDER->orderLabel_withPower()."/chequeOrderFormTemplate.pdf");
			$this->chequeDepositSlips->saveToLocal(SETTINGS::ORDERS______URL().OrderNumber::$CURR_ORDER->orderLabel_withPower()."/deposit_slips.pdf");
			$this->chequPADebit->saveToLocal(SETTINGS::ORDERS______URL().OrderNumber::$CURR_ORDER->orderLabel_withPower()."/PA_Debit.pdf");
			/////////////////////////////////////////////////////////////////////
			ChequeData::SETUP_POST_NORMAL();
			/////////////////////////////////////////////////////////////////////
			
			/*$this->chequeTemplate->saveToLocal("laser-test.pdf");
			
			$this->chequePROrder->saveToLocal("test-pdf/pr.pdf");
			$this->chequeREOrder->saveToLocal("test-pdf/re.pdf");
			*/
			/////$this->chequeOrderFormTemplate->saveToLocal("now_order_form_template.pdf");
			//return;
			$this->emailTemplate = new EmailTemplate( $this->chequeTemplate,  $this->chequePROrder, $this->chequeREOrder, $this->chequeOrderFormTemplate, $this->objChequeData, $this);
			if($sendEmailYes__ == false)
			{
				return;
			}
			//return;
			//print "Update and sent order setup links please......[into tools.php]";
			if(isset($_POST["after_updating_order"]))
			{
				$this->SEND_AFTER_UPDATE_INTO_ADMIN();
			?>
            	<form id="form_after_updating_order" action="<?php print SETTINGS::URL_TO_ADMIN_PAGE; ?>" method="post" enctype="multipart/form-data">
                	<input type="hidden" name="user_is_logged" value="yes" />
                	<input type="hidden" name="after_update_order_please" value="yes" />
                    <input type="hidden" name="fso_order_number" value="<?php print OrderNumber::$CURR_ORDER->orderLabel; ?>" />
                </form>
                <script>
                	document.getElementById("form_after_updating_order").submit();
                </script>
			<?php
			}
			else if(isset($_POST["sendPDFandEmail"]))
			{
				$this->SEND();
			?>
            	<form id="form_after_updating_order" action="<?php print SETTINGS::URL_TO_THANK_U; ?>" method="post" enctype="multipart/form-data">
                	<input type="hidden" name="order_number" value="<?php print OrderNumber::$CURR_ORDER->orderLabel; ?>" />
                </form>
                <script>
                	document.getElementById("form_after_updating_order").submit();
                </script>
			<?php
			}
		}
		function SEND()
		{
			$this->emailTemplate->SEND();
		}
		function SEND_AFTER_UPDATE_INTO_ADMIN()
		{
			$this->emailTemplate->SEND_AFTER_UPDATE_INTO_ADMIN();
		}
		/*
		This is function for removing the folders for orders, according to updating...
		*/
		function DELETE_CURR_ORDER_FOLDER_WHEN_UPDATING()
		{
			$orderMinus1 = OrdersDatabase::GET_ORDER_POWER( OrderNumber::$CURR_ORDER->orderLabel, true );
			$orderFolderIntoNew = SETTINGS::ORDERS______URL_BY_CHEQUE().$orderMinus1."/";
			$orderFolderIntoCompleted = SETTINGS::ORDERS______URL_BY_CHEQUE().SETTINGS::FOLDER_FOR_COMPLETED_ORDERS.$orderMinus1."/";
			
			/*
			print "[".$orderFolderIntoNew."]";
			print "[".$orderFolderIntoCompleted."]";
			*/
			
			if(is_dir( $orderFolderIntoNew ))
			{
				HELPWordpress::delete_directory( $orderFolderIntoNew );
			}
			if(is_dir( $orderFolderIntoCompleted ))
			{
				HELPWordpress::delete_directory( $orderFolderIntoCompleted );
			}
		}
	}
	/*
	$folder = "orders/laser_orders/completed_orders/T_L5864-C/";
	chdir( $folder );
	exec ("del *.* /s /q");
	unlink( $folder );
	SendEMail::delete_directory( $folder );
	*/
	//rmdir("orders/laser_orders/completed_orders/T_L5864-C/");
	//unlink("orders/laser_orders/completed_orders/T_L5864-C/");
	////////////////////////////////////////////////////////////////////////////////////////////////
	////////////////////////////////////////////////////////////////////////////////////////////////
	/////Order number creator
	////////////////////////////////////////////////////////////////////////////////////////////////
	class OrderNumber
	{
		const LABEL_LASER_BEFORE="L";
		const LABEL_MANUAL_BEFORE="M";
		static $START_ORDER_INDEX=5000;
		private $cheque;
		private $orderIndex=0;
		public $orderFileName;
		public $orderLabel="";
		public static $CURR_ORDER = NULL;
		public $isCreatingAfterAdminInit=false;
		
		public function OrderNumber($chequ___=NULL, $setupYes=true, $orderLabel__=NULL, $isCreatingAfterAdminInit=false)
		{
			$this->isCreatingAfterAdminInit = $isCreatingAfterAdminInit;
			$this->cheque = $chequ___;
			if($setupYes == true)
			{
				$this->orderSet();
			}
			if($setupYes == false && $orderLabel__ != NULL)
			{
				$this->orderLabel = $orderLabel__;
				$this->orderFileName = $orderLabel__;
			}
		}
		function orderSet()
		{
			$lastORderNumberRow=NULL;
			if($this->cheque->type == Cheque::TYPE_LASER)
			{
				self::$START_ORDER_INDEX=5700;
				DB_DETAILS::ADD_ACTION("INSERT INTO orders_laser VALUES()", DB_DETAILS::$TYPE_ACTION);
				$lastORderNumberRow = DB_DETAILS::GET_LAST_ITEM("orders_laser", "id");
					$this->orderIndex = $lastORderNumberRow["id"]+self::$START_ORDER_INDEX;
				$this->orderFileName = SETTINGS::ORDER_SAVING_PLUS_LABEL.self::LABEL_LASER_BEFORE;
				$this->orderLabel = SETTINGS::ORDER_SAVING_PLUS_LABEL.OrderNumber::LABEL_LASER_BEFORE.$this->orderIndex;
			}
			else if($this->cheque->type == Cheque::TYPE_MANUAL)
			{
				self::$START_ORDER_INDEX=3500;
				DB_DETAILS::ADD_ACTION("INSERT INTO orders_manual VALUES()", DB_DETAILS::$TYPE_ACTION);
				$lastORderNumberRow = DB_DETAILS::GET_LAST_ITEM("orders_manual", "id");
					$this->orderIndex = $lastORderNumberRow["id"]+self::$START_ORDER_INDEX;
				$this->orderFileName = SETTINGS::ORDER_SAVING_PLUS_LABEL.self::LABEL_MANUAL_BEFORE;
				$this->orderLabel = SETTINGS::ORDER_SAVING_PLUS_LABEL.OrderNumber::LABEL_MANUAL_BEFORE.$this->orderIndex;;
			}
			//print $this->orderLabel;
			$this->orderFileName .= $this->orderIndex;
		}
		public function orderNumberLabelGet()
		{
			return $this->orderLabel;
		}
		public function orderHTML()
		{
			return '<p style=" background-color:#FF6600; font-family:Arial; font-size:10pt; text-align:left; margin:0px; padding:0px; ">Order Confirmation #:<b>'.$this->orderNumberLabelGet().'</b></p><br /><br />' ;
		}
		public function orderLabel_withPower()
		{
			//print $_POST["update_order_please"];
			if($GLOBALS["WHEN_UPDATING_CHEQUE_IS_NEW"] == true)
			{
				return $this->orderLabel;
			}
			else
			{
				return OrdersDatabase::GET_ORDER_POWER( $this->orderLabel );
			}
		}
	}
	////////////////////////////////////////////////////////////////////////////////////////////////////////////
	////////////////////////////////////////////////////////////////////////////////////////////////////////////
	/////Class for saving the orders into the database
	////////////////////////////////////////////////////////////////////////////////////////////////////////////
	class OrdersDatabase
	{
		public static $arr_variables = array(
		"date_modify",
		"orderNumberEdited",
		"CICompanyName", "CIContactName", "CIPhone", "CIEmail", "CIQuestionsAndCommentsTA", "CIQuestionsAndComments", 
		"compInfoQuantity","quantityINPUT","quantityINPUTIndex",
		"chequePosition","chequeColor","backgroundINdex",
		"compInfoName","compInfoSecondName","compInfoAddressLine1","compInfoAddressLine2","compInfoAddressLine3","compInfoAddressLine4",
		"comInfoIsSecondCompanyName", /*"CILogoType",*/ 
		"compInfoBankName", "compInfoBankAddress1", "compInfoBankAddress2", "compInfoBankAddress3", "compInfoBankAddress4",
		"isCurrencyINPUT", "add45AfterAcountNumberInput", 
		"compInfoSoftware",//just for laser 
		"compInfoSecondSignatur", "compInfoShowStartNumber", "compInfoStartAt", "compInfoBrunchNumber", "compInfoTransitNumber", "compInfoAccountNumber", 
		"compInfoStartAtTrueOrFalse", "isThereSecondSignature", "softwareINPUT", /*"startAtNumber_plus_1",*/ /*"softwareINPUTIndex",*/ 
		"boxingType",//just for laser 
		"compInfoDepositBooks", 
		"compInfoDWE", "compInfoSSDWE",//just for laser
		"compInfoSelfLinkingStamp", "depositBooksINPUT", "compInfoChequeBinder", "depositBooksINPUT_VARs", "DWEINPUT", "SSDWEINPUT", "chequeBinderINPUT", 
		"SelfLinkStampINPUT", "deliveryINPUT", 
		"companyName_TYPE_BILLING", "contactName_TYPE_BILLING", "address_1_TYPE_BILLING", "address_2_TYPE_BILLING", "address_3_TYPE_BILLING", 
		"city_TYPE_BILLING", "province_TYPE_BILLING", "postalCode_TYPE_BILLING", "phone_TYPE_BILLING", "email_TYPE_BILLING", "isBillToAlternativeName", 
		/*"SameAsBillingDetails",*/ "residentialAddressBSM", "noSignatureRequiredBSM", "companyName_TYPE_SHIPING", "contactName_TYPE_SHIPING", 
		"address_1_TYPE_SHIPING", "address_2_TYPE_SHIPING", "address_3_TYPE_SHIPING", "city_TYPE_SHIPING", "province_TYPE_SHIPING", "postalCode_TYPE_SHIPING", 
		"phone_TYPE_SHIPING", "email_TYPE_SHIPING", "isShipToDifferentAddress", "MOP_directDebit_signature", "MOP_cardNum", 
		"MOPcsv", "mopINPUT", "mopExpirtyMonthINPUT", "mopExpirtyYearINPUT", "mopCallMe", "AIRMILES_cardNumber", "chequeType"/*, "orderNumber"*/,
		"sub_total_products_INPUT", "shipping_price_INPUT", "sub_total_taxes_INPUT", "grand_total_INPUT",
		"orderNumber"); 
		
		public static function SAVE_ORDERS()
		{
			if($GLOBALS["WHEN_UPDATING_CHEQUE_IS_NEW"] == false)
			{
				self::MAKE_POWER_ORDER_NUMBER(  );
			}
			else if($GLOBALS["WHEN_UPDATING_CHEQUE_IS_NEW"] == true)
			{
			}
			$getOrderFromDatabase = DB_DETAILS::ADD_ACTION("SELECT * FROM orders_details
															WHERE orderNumber='".$_POST["orderNumber"]."'
															", DB_DETAILS::$TYPE_SELECT);
			if(count($getOrderFromDatabase) == 0)
			{
				self::CREATE_NEW_ORDER();
			}
			else
			{
				self::UPDATE_ORDER();
			}
			$timeNowSeconds = time();
			$timeNowSeconds *= 1000;//to milliseconds
			DB_DETAILS::ADD_ACTION("UPDATE orders_details SET date_modify=".$timeNowSeconds." WHERE orderNumber='".$_POST["orderNumber"]."'");
		}
		private static function CREATE_NEW_ORDER()
		{
			$allVariables = "";
			$allvAlues = "";
			for($i=0;$i<count(self::$arr_variables);$i++)
			{
				if($i > 0)
				{
					$allVariables .= ",";
					$allvAlues .= ",";
				}
				$allVariables .= self::$arr_variables[$i];
				if(!isset($_POST[self::$arr_variables[$i]]))
				{
					$_POST[self::$arr_variables[$i]] = "is not set";
				}
				if(self::$arr_variables[$i]== "orderNumberEdited")
				{
					$allvAlues .= "'".self::GET_ORDER_POWER($_POST["orderNumber"])."'";
				}
				else
				{
					$allvAlues .= "'".$_POST[self::$arr_variables[$i]]."'";
				}
			}
			DB_DETAILS::ADD_ACTION(" INSERT INTO orders_details(".$allVariables.")
									 VALUES(".$allvAlues.") ");
		}
		private static function UPDATE_ORDER()
		{
			$allvAlues = "";
			for($i=0;$i<count(self::$arr_variables);$i++)
			{
				if($i > 0)
				{
					$allvAlues .= ",";
				}
				if(!isset($_POST[self::$arr_variables[$i]]))
				{
					$_POST[self::$arr_variables[$i]] = "is not set";
				}
				if(self::$arr_variables[$i]== "orderNumberEdited")
				{
					$allvAlues .= self::$arr_variables[$i]."='".self::GET_ORDER_POWER($_POST["orderNumber"])."'";
				}
				else
				{
					$allvAlues .= self::$arr_variables[$i]."='".$_POST[self::$arr_variables[$i]]."'";
				}
			}
			DB_DETAILS::ADD_ACTION(" UPDATE orders_details
									  SET ".$allvAlues."
									  WHERE orderNumber='".$_POST["orderNumber"]."'
									  ");
		}
		/*
		This is function that is for create order-A.....YZ
		*/
		private static function MAKE_POWER_ORDER_NUMBER()
		{
			$rowOrderPower = DB_DETAILS::ADD_ACTION("
									SELECT * FROM orders_details_power WHERE orderNumber='".$_POST["orderNumber"]."'
			", DB_DETAILS::$TYPE_SELECT);
			if(count($rowOrderPower) == 0)
			{
				DB_DETAILS::ADD_ACTION("INSERT INTO orders_details_power(orderNumber, power) VALUES('".$_POST["orderNumber"]."', 1)");
			}
			else
			{
				$orderPower = $rowOrderPower[0]["power"];
				$orderPower += 1;
				DB_DETAILS::ADD_ACTION("UPDATE orders_details_power 
										SET power=".$orderPower." 
										WHERE orderNumber='".$_POST["orderNumber"]."'");
			}
		}
		private static function getPowerPlusLabel($arr)
		{
			$str = "";
			for($i=0;$i<count($arr);$i++)
			if($arr[$i] != -1)
			{
				if($i > 0){$str .= "";}
				$str .= substr(HELPWordpress::UPPER_LETTERS, $arr[$i], 1);
			}
			return "-".$str;
		}
		public static function GET_ORDER_POWER( $orderNumber=NULL, $setMinus1=false )
		{
			$rowOrderPower = DB_DETAILS::ADD_ACTION("
									SELECT * FROM orders_details_power WHERE orderNumber='".$orderNumber."'
			", DB_DETAILS::$TYPE_SELECT);
			if(count($rowOrderPower) == 0)
			{
				return  $orderNumber;
			}
			$endCombinations = $rowOrderPower[0]["power"];
			//print "[".$orderNumber."]";
			//print "[".$endCombinations."]";
			if($setMinus1 == true)
			{
				$endCombinations--;
				if($endCombinations == 0)
				{
					return $orderNumber;
				}
			}
			
			$stringLenhth = strlen( HELPWordpress::UPPER_LETTERS );
			$arrayIndexes = array();
			for($i=0;$i<strlen(HELPWordpress::UPPER_LETTERS);$i++)
			{
				$arrayIndexes[$i] = "-1";
			}
			//print_r( $arrayIndexes );
			//print "<br>";
			
			$columnWhereToPut = 0;
			for($i=0;$i<count($arrayIndexes);$i++)
			{
				if($arrayIndexes[$i])
				{
				}
			}
			for($i=1;$i<=$endCombinations;$i++)
			{
				$arrayIndexes[$columnWhereToPut]++;
				if($arrayIndexes[$columnWhereToPut] == $stringLenhth)
				{
					$tempColumnWhereIPut = $columnWhereToPut;
					$max = 0;
					$icanLook = true;
					/**/
					while($arrayIndexes[$columnWhereToPut]+1 >= $stringLenhth && $columnWhereToPut > 0)
					{
						$columnWhereToPut--;
					}
					$arrayIndexes[$columnWhereToPut]++;
					if($arrayIndexes[$columnWhereToPut] >= $stringLenhth && $columnWhereToPut==0)
					{
						for($k=0;$k<=$tempColumnWhereIPut+1;$k++)
						{
							$arrayIndexes[$k] = 0;
						}
						$columnWhereToPut = $tempColumnWhereIPut+1;	
					}
					else
					{
						for($k=$columnWhereToPut+1;$k<=$tempColumnWhereIPut;$k++)
						{
							$arrayIndexes[$k] = 0;
						}
						$columnWhereToPut = $tempColumnWhereIPut;
					}
				}
			}
			return $orderNumber.self::getPowerPlusLabel( $arrayIndexes );
		}
	}
	/*just for testing
	if(isset($_GET["GET_ORDER_POWER"]))
	{
		print OrdersDatabase::GET_ORDER_POWER( "T_M3532" );
		print "<br>this testing must be commented";
	}*/
	////////////////////////////////////////////////////////////////////////////////////////////////////////////
	////////////////////////////////////////////////////////////////////////////////////////////////////////////
	/////Class for Saving the order of the cheque
	////////////////////////////////////////////////////////////////////////////////////////////////////////////
	class XMLParser
	{
		public static $VARIABLES = array();
		
		public function XMLParser()
		{
		}
		public static function SAVE_XML_ORDER(  )
		{
			$myFile = SETTINGS::ORDERS_FOLDER_FOR_XML.OrderNumber::$CURR_ORDER->orderFileName.".xml";
			$_POST["orderNumber"] = OrderNumber::$CURR_ORDER->orderFileName;
			$fh = fopen($myFile, 'w');
			fwrite($fh, self::GET_XML_ORDER());
			fclose($fh);
			//////////////////////////////////////////////////////////////////////////////
			//////////////////////////////////////////////////////////////////////////////
			/////Saving orders to database
			//////////////////////////////////////////////////////////////////////////////
			OrdersDatabase::SAVE_ORDERS();
		}
		public static function GET_XML_ORDER()
		{
			$XMLSource = '<source>
			';
			foreach($_POST as $key => $value)
			{
				$XMLSource .= '<'.$key.'><![CDATA['.$value.']]></'.$key.'>
							   ';
			}
			$XMLSource .= '
			</source>';
			return $XMLSource;
		}
		public static function ADD_ORDER_XML_TO_POST( $orderFilePath, $setupToPOST=true )
		{
			$xmlDocument = new DOMDocument();
			$xmlDocument->load( $orderFilePath );
			$x = $xmlDocument->documentElement;
			foreach($x->childNodes as $item)
			{
				//print "[".$item->nodeName . "] = [" . $item->nodeValue . "]<br />";
				if($setupToPOST == true)
				{
					$_POST[$item->nodeName] = $item->nodeValue;
				}
				else
				{
					XMLParser::$VARIABLES[$item->nodeName] = $item->nodeValue;
				}
			}
			//print "[".$orderFilePath."]";
		}
	}
	class CSVBase
	{
		protected $source;
		protected function generate($arrayVariablesOrdered, $CSVfileName)
		{
			$myFile = SETTINGS::ORDERS______URL().OrderNumber::$CURR_ORDER->orderLabel_withPower()."/".$CSVfileName.".csv";
			$textZaSnimanje = "";
			$variables="";
			$values="";
			$zapirkaBefore="";
			for($i=0;$i<count($arrayVariablesOrdered);$i++)
			{
				$variables .= $zapirkaBefore.$arrayVariablesOrdered[$i];
				$value = $_POST[$arrayVariablesOrdered[$i]];
				if($value==""){$value="-";}
				$values .= $zapirkaBefore.'"'.$value.'"';
				//$textZaSnimanje .= $key.",".$value."\n";
				$zapirkaBefore = ",";
				//print "[".$key."]=>".$value."<br/>";
			}
			/*
			foreach($_POST as $key => $value)
			{
				$variables .= $zapirkaBefore.$key;
				if($value==""){$value="-";}
				$values .= $zapirkaBefore.'"'.$value.'"';
				//$textZaSnimanje .= $key.",".$value."\n";
				$zapirkaBefore = ",";
				//print "[".$key."]=>".$value."<br/>";
			}
			*/
			$textZaSnimanje .= $variables."\n".$values;
			$this->source = $textZaSnimanje;
			//print $variables."<br/>".$values;
			///////////////////////////////////////////////////////////////////////////////////////
			///////////////////////////////////////////////////////////////////////////////////////
			///////////////////////////////////////////////////////////////////////////////////////
			if(!is_dir(SETTINGS::ORDERS______URL().OrderNumber::$CURR_ORDER->orderLabel_withPower()))
			{
				mkdir(SETTINGS::ORDERS______URL().OrderNumber::$CURR_ORDER->orderLabel_withPower());
			}
			$fh = fopen($myFile, 'w');
			fwrite($fh, $textZaSnimanje);
			fclose($fh);
			
			$myFile = SETTINGS::ORDERS_FOLDER_FOR_CSV.$CSVfileName.".csv";
			//$myFile = SETTINGS::ORDERS_FOLDER_FOR_CSV."csv.csv";
			$fh = fopen($myFile, 'w');
			fwrite($fh, $values);
			fclose($fh);
		}
		public function get_source()
		{
			return $this->source;
		}
	}
	class CSVCreator extends CSVBase 
	{
		public static $CSV=NULL;
		
		public function CSVCreator()
		{
			$_POST["orderNumber"] = OrderNumber::$CURR_ORDER->orderLabel_withPower();
			///////////////////////////////////////////////////////////////////////////////////////
			///////////////////////////////////////////////////////////////////////////////////////
			///////////////////////////////////////////////////////////////////////////////////////
			
			$tb = ChequeData::TYPE_BILLING;
			$ts = ChequeData::TYPE_SHIPING;
			$arrayVariablesOrdered = array("orderNumber",
						"companyName_".$ts,"address_1_".$ts,"address_2_".$ts,"address_3_".$ts,"city_".$ts,"province_".$ts,"postalCode_".$ts,"phone_".$ts,"email_".$ts,"contactName_".$ts,"Pieces","Weight",
						"companyName_".$tb,"address_1_".$tb,"address_2_".$tb,"address_3_".$tb,"city_".$tb,"province_".$tb,"postalCode_".$tb,"phone_".$tb,"email_".$tb,"contactName_".$tb,
						"CIQuestionsAndCommentsTA","CIQuestionsAndComments","compInfoQuantity","quantityINPUT",
						"chequeColor","backgroundINdex","chequePosition",
						"compInfoName","compInfoSecondName",/*"compInfoDifferentNameForBilling","compInfoDifferentAddressForShipping",*/"isBillToAlternativeName","isShipToDifferentAddress",
						"CILogoType",
						"compInfoBankName","compInfoBankAddress1","compInfoBankAddress2","compInfoBankAddress3","compInfoBankAddress4",
						"isCurrencyINPUT","compInfoSecondSignatur","compInfoShowStartNumber","compInfoStartAt","compInfoBrunchNumber","compInfoTransitNumber","compInfoAccountNumber",
						"compInfoStartAtTrueOrFalse","isThereSecondSignature","softwareINPUT","startAtNumber_plus_1","compInfoDepositBooks","chequeBinderINPUT",
						"compInfoSelfLinkingStamp","depositBooksINPUT","DWEINPUT","SSDWEINPUT","chequeBinderINPUT","SelfLinkStampINPUT","comInfoIsSecondCompanyName",
						"isBillToAlternativeName","isShipToDifferentAddress",
						"deliveryINPUT","MOP_cardNum","MOPcsv","mopINPUT","mopExpirtyMonthINPUT","mopExpirtyYearINPUT","mopCallMe","AIRMILES_cardNumber","sendPDFandEmail","chequeType"
						);
			
			$_POST["Pieces"] = "pieces";
			$_POST["Weight"] = "1";
			
			$this->generate($arrayVariablesOrdered, "csv");
			
			CSVCreator::$CSV = $this;
		}
		public static function INIT_AND_SAVE_CSV()
		{
			$objCSVCreator = new CSVCreator();
			$objPADCSV = new PADCSV();
		}
	}
	class PADCSV extends CSVBase
	{
		public static $CSV=NULL;
		
		public function PADCSV()
		{
			if(!is_numeric($_POST["compInfoTransitNumber"])){$_POST["compInfoTransitNumber"] = "000";}
			$_POST["orderNumber"] = OrderNumber::$CURR_ORDER->orderLabel_withPower();
			$arrayVariablesOrdered = array("PADColumn1", "PADColumn2", "compInfoTransitNumber", "compInfoBrunchNumber", "compInfoAccountNumber", "PADColum6is0", "orderNumber", "companyName_".ChequeData::TYPE_BILLING);
			$_POST["PADColumn1"] = "E";
			$_POST["PADColumn2"] = "D";
			$_POST["PADColum6is0"] = "0";
			$this->generate($arrayVariablesOrdered, "PA_Debit");
			self::$CSV = $this;
		}
	}
	////////////////////////////////////////////////////////////////////////////////////
	////////////////////////////////////////////////////////////////////////////////////
	////////////////////////////////////////////////////////////////////////////////////
	////////////////////////////////////////////////////////////////////////////////////
	////////////////////////////////////////////////////////////////////////////////////
	////////////////////////////////////////////////////////////////////////////////////
	////////////////////////////////////////////////////////////////////////////////////
	class SearchTool
	{
		public static function SEARCH_ORDERS_PLEASE()
		{
			//print_r($_POST);
			$resultsSearch = "SELECT COUNT(*) AS TOTAL_COUNT FROM orders_details 
								 ".self::SELECT_AND_CLAUSULE()." 
								".self::ORDER_BY_CLAUSULE();
			$resultsSearch = DB_DETAILS::ADD_ACTION($resultsSearch, DB_DETAILS::$TYPE_SELECT);
			$countPages = $resultsSearch[0]["TOTAL_COUNT"]/$_POST["rowsMaxCount"];
			$countPagesROUND = round( $countPages );
			if($countPagesROUND < $countPages)
			{
				$countPagesROUND ++;
			}
			$resultsSearch = "SELECT * FROM orders_details 
								 ".self::SELECT_AND_CLAUSULE()." 
								".self::ORDER_BY_CLAUSULE().""
								.self::LIMIT_CLAUSULE();
			$SQLForSearching = $resultsSearch;
			$resultsSearch = DB_DETAILS::ADD_ACTION($resultsSearch, DB_DETAILS::$TYPE_SELECT);
			/*
			print_r( $_POST );
			print "[".$resultsSearch."]";*/
			
			//print_r($resultsSearch[0]);
			/*
			print "[[[[[";
			print_r($resultsSearch);
			print "]]]]]";
			*/
			$xmlSource = "<source>";
			$xmlSource .= "<usedSQL><![CDATA[".$SQLForSearching."]]></usedSQL>";
			if(count($resultsSearch) > 0)
			{
				$xmlSource .= "<orders>";
				for($i=0;$i<count($resultsSearch);$i++)
				{
					$xmlSource .= "<order>".self::get_XML_variables_and_Values($resultsSearch[$i])."</order>";
				}
				$xmlSource .= "</orders>";
			}
			$xmlSource .= "<countPages>".$countPagesROUND."</countPages>";
			$xmlSource .= "</source>";
			print $xmlSource;
		}
		private static function SELECT_AND_CLAUSULE()
		{
			$brojac = 0;
			$AND_CLAUSULE = "";
			
			if(isset($_POST["SEARCH_ORDERS_PLEASE_BY_UNIVERSAL"]))
			{
				for($i=0;$i<count(OrdersDatabase::$arr_variables);$i++)
				{
						if($brojac > 0)
						{
							$AND_CLAUSULE .= " OR ";
						}
						$AND_CLAUSULE .= OrdersDatabase::$arr_variables[$i]." LIKE '%".$_POST["SEARCH_ORDERS_PLEASE_BY_UNIVERSAL"]."%'";
						$brojac++;
				}
			}
			else if(isset($_POST["SEARCH_BY_DATE"]))
			{
				$AND_CLAUSULE = " date_modify>=".$_POST["FROM_DATE"]." AND date_modify<=".$_POST["TO_DATE"]." ";
			}
			else if(isset($_POST["SEARCH_BY_ORDER_TOTAL_AMOUNT"]))
			{
				$arrayAndForTotal = array();
				$clausule = "";
				if($_POST["shippingAmountSearchInput"] != "")
				{
					$clausule = "shipping_price_INPUT=".$_POST["shippingAmountSearchInput"];
					array_push( $arrayAndForTotal, $clausule );
				}
				if($_POST["taxesAmountSearchInput"] != "")
				{
					$clausule = "sub_total_taxes_INPUT=".$_POST["taxesAmountSearchInput"];
					array_push( $arrayAndForTotal, $clausule );
				}
				if($_POST["grandTotalSearchInputFrom"] != "" && $_POST["grandTotalSearchInputTo"] != "")
				{
					$clausule = "(grand_total_INPUT>=".$_POST["grandTotalSearchInputFrom"]." AND grand_total_INPUT<=".$_POST["grandTotalSearchInputTo"].")";
					array_push( $arrayAndForTotal, $clausule );
				}
				for($i=0;$i<count($arrayAndForTotal);$i++)
				{
					if($i > 0)
					{
						$AND_CLAUSULE .= " AND ";
					}
					$AND_CLAUSULE .= $arrayAndForTotal[$i];
				}
			}
			else
			{
				for($i=0;$i<count(OrdersDatabase::$arr_variables);$i++)
				{
					if(isset($_POST[OrdersDatabase::$arr_variables[$i]]) && $_POST[OrdersDatabase::$arr_variables[$i]] != ""
					&& OrdersDatabase::$arr_variables[$i] != "chequeType")
					{
						if($brojac > 0)
						{
							$AND_CLAUSULE .= " AND ";
						}
						$AND_CLAUSULE .= OrdersDatabase::$arr_variables[$i]." LIKE '%".$_POST[OrdersDatabase::$arr_variables[$i]]."%'";
						$brojac++;
					}
				}
			}
			if($AND_CLAUSULE == ""){return "";}
			return " WHERE ".$AND_CLAUSULE;
		}
		private static function ORDER_BY_CLAUSULE()
		{
			if(isset($_POST["order_by"]))
			{
				return " ORDER BY ".$_POST["order_by"]." ".$_POST["order_type"]." ";
			}
			return "ORDER BY orderNumber";
		}
		private static function LIMIT_CLAUSULE()
		{
			$start = $_POST["currentPage"]*$_POST["rowsMaxCount"];
			$endLimit = $start+$_POST["rowsMaxCount"];
			return " LIMIT ".$start.", ".$_POST["rowsMaxCount"]." ";
		}
		
		private static function get_XML_variables_and_Values($row)
		{
			//print $row;
			$xmlSource = "";
			for($i=0;$i<count(OrdersDatabase::$arr_variables);$i++)
			{
				$xmlSource .= "<".OrdersDatabase::$arr_variables[$i]."><![CDATA[".$row[OrdersDatabase::$arr_variables[$i]]."]]></".OrdersDatabase::$arr_variables[$i].">";
			}
			return $xmlSource;
		}
		public static function ALL_VARIABLES_FOR_JAVASCRIPT()
		{
			$ALL_VARIABLES = "";
			for($i=0;$i<count(OrdersDatabase::$arr_variables);$i++)
			{
				if($i > 0)
				{
					$ALL_VARIABLES .= ",";
				}
				$ALL_VARIABLES .= '"'.OrdersDatabase::$arr_variables[$i].'"';
			}
			return $ALL_VARIABLES;
		}
	}
	if(isset($_POST["SEARCH_ORDERS_PLEASE"]))
	{
		SearchTool::SEARCH_ORDERS_PLEASE();
	}
	////////////////////////////////////////////////////////////////////////////////////
	////////////////////////////////////////////////////////////////////////////////////
	////////////////////////////////////////////////////////////////////////////////////
	////////////////////////////////////////////////////////////////////////////////////
	////////////////////////////////////////////////////////////////////////////////////
	if(isset($_POST["save_order"]) && !isset($_POST["payment_go"]))
	{
		require_once("db_details.php");
		$objCheque = new Cheque( $_POST["chequeType"] );
		$orderNumber = new OrderNumber( $objCheque );
		XMLParser::SAVE_XML_ORDER( );
		print $orderNumber->orderFileName;
	}
	/**/
	if(isset($_POST["sendPDFandEmail"]) && $_POST["sendPDFandEmail"]=="SEND_EMAIL")
	{
		$objCheque = new Cheque( $_POST["chequeType"] );
		OrderNumber::$CURR_ORDER = new OrderNumber( $objCheque );
		XMLParser::SAVE_XML_ORDER( );
		CSVCreator::INIT_AND_SAVE_CSV( );
		$objSendEMail = new SendEMail( $objCheque, true );
	}
	if(isset($_POST["update_order_please"]))
	{
		/*
		//print $_POST["countVariables"]."=======<br>";
		for($i=0;$i<$_POST["countVariables"];$i++)
		{
			$variable = $_POST["var__".$i];
			$_POST[$variable] = $_POST["val__".$i];
			unset( $_POST["var__".$i] );
			unset( $_POST["val__".$i] );
			//print "[".$variable."]=[".$_POST["val__".$i]."]<br>";
		}*/
		$objCheque = new Cheque( $_POST["chequeType"] );
		/**/
		if($_POST["setupNewVariable"] == "true")
		{
			//olf order number creating new when new cheque
			OrderNumber::$CURR_ORDER = new OrderNumber( $objCheque, true );
		}
		else
		{
			OrderNumber::$CURR_ORDER = new OrderNumber( $objCheque, false, $_POST["fso_order_number"], true );
			//print $_POST["fso_order_number"];
			$GLOBALS["WHEN_UPDATING_CHEQUE_IS_NEW"] = false;
		}
		
		/*
		Because of the pow of the orders, on update or new from admin this number will be same.
		*/
		//OrderNumber::$CURR_ORDER = new OrderNumber( $objCheque, false, $_POST["fso_order_number"], true );
		
		unset($_POST["user_is_logged"]);
		unset($_POST["update_order_please"]);
		unset($_POST["fso_order_number"]);
		unset($_POST["countVariables"]);
		unset($_POST["setupNewVariable"]);
		
		XMLParser::SAVE_XML_ORDER( );
		CSVCreator::INIT_AND_SAVE_CSV( );
		$_POST["after_updating_order"] = "true";
		$objSendEMail = new SendEMail( $objCheque, true );
	}
	if(isset($_GET["order_number_backup"]))
	{
		if(!class_exists("EmailTemplate")){require_once( "mail_message_template.php" );}
		if(!file_exists(SETTINGS::ORDERS_FOLDER_FOR_XML.$_GET["order_number_backup"].".xml"))
		{
			print "Order {".$_GET["order_number_backup"]."} don't exist!!!";
			return;
		}
		XMLParser::ADD_ORDER_XML_TO_POST( SETTINGS::ORDERS_FOLDER_FOR_XML.$_GET["order_number_backup"].".xml" );
		$objCheque = new Cheque( $_POST["chequeType"] );
		OrderNumber::$CURR_ORDER = new OrderNumber( $objCheque, false );
		OrderNumber::$CURR_ORDER->orderLabel = $_GET["order_number_backup"];
		?>
        <div style="text-align:center; width:600px; background-color:#FCC; font-family:Arial, Helvetica, sans-serif; padding:50px;">
        	<div>PDFs Files<br /></div>
        	<a href="<?php print "orders/".OrderNumber::$CURR_ORDER->orderLabel."/cheque.pdf"; ?>">cheque&nbsp;&nbsp;</a>
        	<a href="<?php print "orders/".OrderNumber::$CURR_ORDER->orderLabel."/chequePROrder.pdf"; ?>">chequePROrder&nbsp;&nbsp;</a>
        	<a href="<?php print "orders/".OrderNumber::$CURR_ORDER->orderLabel."/chequeREOrder.pdf"; ?>">chequeREOrder&nbsp;&nbsp;</a>
        	<a href="<?php print "orders/".OrderNumber::$CURR_ORDER->orderLabel."/chequeOrderFormTemplate.pdf"; ?>">chequeOrderFormTemplate</a>
        </div>
        
		<?php
		$objMMT = new EmailTemplate( $objCheque, NULL, NULL, NULL, new ChequeData($objCheque));
				print 'Message to me:<br/>';
				print $objMMT->emailMessageForMe();
				print '<br/>Message to client:<br/>';
				print $objMMT->emailMessageForClient();
	}
	
?>
