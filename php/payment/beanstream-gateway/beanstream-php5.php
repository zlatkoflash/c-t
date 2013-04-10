<?php

class BeanStream
{
	protected $requestType="BACKEND";//R
	protected $merchant_id="223200041";//R
	/////////////////////////////////////////////////////////////////////////////////////////////
	/////////////////////////////////////////////////////////////////////////////////////////////
	/*
	30 alphanumeric (a/n) characters
	*/
	protected $trnOrderNumber;//R
	
	/*
	In the format 0.00. Max 2 decimal places. Max 9 digits total.
	This is the total dollar value of the purchase. This should represent the total of all taxes, shipping charges and other product/service costs as applicable.
	*/
	protected $trnAmount;//R
	public function trnAmount_set($amount)
	{
		$this->trnAmount = $amount;
	}
	
	/*
	URL (encoded). Max 128 a/n characters.
	Not for use with server to server integrations. If a standard transaction request contains errors in billing or credit card information, the customer’s browser will be re-directed to 	
	this page. Error messages will prompt the user to correct their data.
	*/
	protected $errorPage;//R
	public function errorPage_set()
	{
		$this->errorPage = "";
	}
	
	/*
	URL (encoded). Unlimited a/n characters.
	Beanstream provides default approved or declined transaction pages. For a seamless transaction flow, design unique pages and specify the approved transaction redirection URL here.
	*/
	protected $approvedPage;//O
	
	/*
	URL (encoded). Unlimited a/n characters.
	Specify the URL for your custom declined transaction notification page here.
	*/
	protected $declinedPage;//O
	/////////////////////////////////////////////////////////////////////////////////////////////
	/////////////////////////////////////////////////////////////////////////////////////////////
	
	/////////////////////////////////////////////////////////////////////////////////////////////
	/////////////////////////////////////////////////////////////////////////////////////////////
	/*
	Max 64 a/n characters
	This field must contain the full name of the card holder exactly as it appears on their credit card.
	*/
	protected $trnCardOwner;//R*
	
	/*
	Max 20 digits
	Capture the customer’s credit card number.
	*/
	protected $trnCardNumber;//R
	
	/*
	2 digits (January = 01)
	The card expiry month with January as 01 and December as 12.
	*/
	protected $trnExpMonth;//R
	
	/*
	2 digits (2011=11)
	Card expiry years must be entered as a number less than 50. In combination, trnExpYear and trnExpMonth must reflect a date in the future.
	*/
	protected $trnExpYear;//R
	
	/*
	4 digits Amex, 3 digits all other cards
	Include the three or four-digit CVD number from the back of the customer's credit card. This information may be made mandatory using the "Require CVD" 
	option in the Beanstream Order Settings module.
	*/
	protected $trnCardCvd;//O
	
	/*
	Max 64 a/n characters.
	Capture the first and last name of the customer placing the order. This may be different from trnCardOwner.
	*/
	protected $ordName;//R*
	
	/*
	Max 64 a/n characters in the format a@b.com.
	The email address specified here will be used for sending automated email receipts.
	*/
	protected $ordEmailAddress;//R
	
	/*
	Min 7 a/n characters Max 32 a/n characters
	Collect a customer phone number for order follow-up.
	*/
	protected $ordPhoneNumber;//R*
	
	/*
	Max 64 a/n characters
	Collect a unique street address for billing purposes.
	*/
	protected $ordAddress1;//R*
	
	/*
	Max 64 a/n characters
	An optional variable is available for longer addresses.
	*/
	protected $ordAddress2;//O
	
	/*
	Max 32 a/n characters
	The customer's billing city.
	*/
	protected $ordCity;//R*
	/*
	2 characters
	Province and state ID codes in this variable must match one of the available province and state codes.
	tabelata so kodovi se naoga na stranica 74 od BEAN_API_Integration.pdf
	*/
	protected $ordProvince;//R*
	
	/*
	16 a/n characters
	Indicates the customer’s postal code for billing purposes.
	*/
	protected $ordPostalCode;//R*
	
	/*
	2 characters
	Country codes must match one of the available ISO country codes.
	Na stranica 69 se naogaat kodovite za ova
	*/
	protected $ordCountry;//R*
	/////////////////////////////////////////////////////////////////////////////////////////////
	/////////////////////////////////////////////////////////////////////////////////////////////
	
	/////////////////////////////////////////////////////////////////////////////////////////////
	/////////////////////////////////////////////////////////////////////////////////////////////
	/*
	URL (encoded)
	Specify the URL where the bank response codes will be collected after enters their VBV or SecureCode pin on the banking portal.
	*/
	protected $termURL;//R
	
	/*
	1 digit
	When VBV service has been activated, Beanstream will attempt VBV authentication on all transactions. Use this variable to override our default settings and process VBV on selected transactions only. Pass vbvEnabled=1 to enable VBV authentication with an order. Pass vbvEnabled=0 to bypass VBV authentication on specific orders.
	*/
	protected $vbvEnabled;//O
	
	/*
	1 digit
	When SecureCode service has been activated, Beanstream will attempt SC authentication on all transactions. Use this variable to override our default settings and process SC on selected transactions only. Pass scEnabled=1 to enable SC authentication with an order. Pass scEnabled=0 to bypass SC authentication on specific orders.
	*/
	protected $scEnabled;//O
	/////////////////////////////////////////////////////////////////////////////////////////////
	/////////////////////////////////////////////////////////////////////////////////////////////
	
	/////////////////////////////////////////////////////////////////////////////////////////////
	/////////////////////////////////////////////////////////////////////////////////////////////
	/*
	Include the 3D secure transaction identifier as issued by the bank following VBV or SecureCode authentication.
	20 digits
	*/
	protected $SecureXID;//R
	/*
	1 digit
	Provide the ECI status. 5=transaction authenticated. 6= authentication attempted but not completed.
	*/
	protected $SecureECI;//R
	/*
	40 a/n characters
	Include the cardholder authentication verification value as issued by the bank.
	*/
	protected $SecireCAVV;//R
	
	public function __construct()
	{
	}
	private function setCreditCardPurchase($trnOrderNumber,$trnAmount,$errorPage,$approvedPage,$declinedPage,$trnCardOwner,$trnCardNumber,$trnExpMonth,
	$trnExpYear,$trnCardCvd,$ordName,$ordEmailAddress,$ordPhoneNumber,$ordAddress1,$ordAddress2,$ordCity,$ordProvince,
	$ordPostalCode,$ordCountry,$termURL,$vbvEnabled,$scEnabled,$SecureXID,$SecureECI,$SecireCAVV)
	{
		$this->paymentMethod = "CC";
		$this->trnOrderNumber = $trnOrderNumber;
		$this->trnAmount = $trnAmount;
		$this->errorPage = $errorPage;
		$this->approvedPage = $approvedPage;
		$this->declinedPage = $declinedPage;
		$this->trnCardOwner = $trnCardOwner;
		$this->trnCardNumber = $trnCardNumber;
		$this->trnExpMonth = $trnExpMonth;
		$this->trnExpYear = $trnExpYear;
		$this->trnCardCvd = $trnCardCvd;
		$this->ordName = $ordName;
		$this->ordEmailAddress = $ordEmailAddress;
		$this->ordPhoneNumber = $ordPhoneNumber;
		$this->ordAddress1 = $ordAddress1;
		$this->ordAddress2 = $ordAddress2;
		$this->ordCity = $ordCity;
		$this->ordProvince = $ordProvince;
		$this->ordPostalCode = $ordPostalCode;
		$this->ordCountry = $ordCountry;
		$this->termURL = $termURL;
		$this->vbvEnabled = $vbvEnabled;
		$this->scEnabled = $scEnabled;
		$this->SecureXID = $SecureXID;
		$this->SecureECI = $SecureECI;
		$this->SecireCAVV = $SecireCAVV;
	}
	
	public function setCreditCardPurchaseABS()
	{
		$this->setCreditCardPurchase($_POST["orderNumber"],$_POST["trnAmount"],SETTINGS::BEANSTREAM_ERROR_PAGE,SETTINGS::BEANSTREAM_APROVED_PAGE,SETTINGS::BEANSTREAM_DECLINED_PAGE,
									 $_POST["trnCardOwner"],$_POST["trnCardNumber"],$_POST["trnExpMonth"],$_POST["trnExpYear"],$_POST["trnCardCvd"],$_POST["ordName"],
									 $_POST["ordEmailAddress"],$_POST["ordPhoneNumber"],$_POST["ordAddress1"],$_POST["ordAddress2"],$_POST["ordCity"],$_POST["ordProvince"],
									 $_POST["ordPostalCode"],$_POST["ordCountry"],$_POST["termURL"],
									 $_POST["vbvEnabled"],$_POST["scEnabled"],$_POST["SecureXID"],$_POST["SecureECI"],$_POST["SecireCAVV"]);
	}
	
	/*
	2 characters (IO)
	Specify paymentMethod=IO to indicate that a transaction is an INTERAC online order. If this value is not passed, 
	the transaction will default to CC for credit card.
	*/
	protected $paymentMethod="IO";//R
	
	private function setInterac($trnOrderNumber, $errorPage, $approvedPage, $declinedPage, $ordName, $ordEmailAddress,
							   $ordPhoneNumber, $ordAddress1, $ordAddress2="", $ordCity, $ordProvince, $ordPostalCode, $ordCountry)
	{
		$this->paymentMethod = "IO";
		$this->trnOrderNumber = $trnOrderNumber;
		$this->errorPage = $errorPage;
		$this->approvedPage = $approvedPage;
		$this->declinedPage = $declinedPage;
		$this->ordName = $ordName;
		$this->ordEmailAddress = $ordEmailAddress;
		$this->ordPhoneNumber = $ordPhoneNumber;
		$this->ordAddress1 = $ordAddress1;
		$this->ordAddress2 = $ordAddress2;
		$this->ordCity = $ordCity;
		$this->ordProvince = $ordProvince;
		$this->ordPostalCode = $ordPostalCode;
		$this->ordCountry = $ordCountry;
	}
	public function setInteracABS()
	{
		$this->setInterac($_POST["orderNumber"],SETTINGS::BEANSTREAM_ERROR_PAGE,SETTINGS::BEANSTREAM_APROVED_PAGE,SETTINGS::BEANSTREAM_DECLINED_PAGE,
									 $_POST["ordName"],
									 $_POST["ordEmailAddress"],$_POST["ordPhoneNumber"],$_POST["ordAddress1"],$_POST["ordAddress2"],$_POST["ordCity"],$_POST["ordProvince"],
									 $_POST["ordPostalCode"],$_POST["ordCountry"]);
	}
	/***
	 * formatAmount()
	 *
	 * Will format an amount value to be in the
	 * expected format for the POST.
	 */
	 public function process()
	 {
		 /*
		 &errorFields=,,,,,,,,,,,,&=223200041&=500&=localhost*/
		 /* fill in the fields */
		 if($this->paymentMethod == "CC")
		 {
			 $fields = array 
			 (
			    "trnOrderNumber"  => $this->trnOrderNumber,
				"paymentMethod"   => $this->paymentMethod,
				"trnCardOwner"    => $this->trnCardOwner,
				"trnCardNumber"   => $this->trnCardNumber,
				"trnExpMonth" 	  => $this->trnExpMonth,
				"trnExpYear" 	  => $this->trnExpYear,
				"ordName" 		  => $this->ordName,
				"ordEmailAddress" => $this->ordEmailAddress,
				"ordPhoneNumber"  => $this->ordPhoneNumber,
				"ordAddress1" 	  => $this->ordAddress1,
				//"ordAddress1" => $this->ordAddress1,
				"ordCity" 		  => $this->ordCity,
				"ordProvince" 	  => $this->ordProvince,
				"ordCountry" 	  => $this->ordCountry,
				
				"merchant_id" 	  => $this->merchant_id,
				
				"trnAmount" 	  => $this->trnAmount,
				"errorPage" 	  => $this->errorPage,
				"approvedPage"    => $this->approvedPage,
				"declinedPage"    => $this->declinedPage
			 );
		 }
		 else if($this->paymentMethod == "IO")
		 {
			 $fields = array 
			 (
			 	"trnOrderNumber"  => $this->trnOrderNumber,
				"paymentMethod"   => $this->paymentMethod,
				//"trnCardOwner"    => $this->trnCardOwner,
				//"trnCardNumber"   => $this->trnCardNumber,
				//"trnExpMonth" 	  => $this->trnExpMonth,
				//"trnExpYear" 	  => $this->trnExpYear,
				"ordName" 		  => $this->ordName,
				"ordEmailAddress" => $this->ordEmailAddress,
				"ordPhoneNumber"  => $this->ordPhoneNumber,
				"ordAddress1" 	  => $this->ordAddress1,
				//"ordAddress1" => $this->ordAddress1,
				"ordCity" 		  => $this->ordCity,
				"ordProvince" 	  => $this->ordProvince,
				"ordCountry" 	  => $this->ordCountry,
				
				"merchant_id" 	  => $this->merchant_id,
				
				"trnAmount" 	  => $this->trnAmount,
				"errorPage" 	  => $this->errorPage,
				"approvedPage"    => $this->approvedPage,
				"declinedPage"    => $this->declinedPage
			 );
		 }
		 
		 /*
		 trnCardOwner,trnCardNumber,trnExpMonth,trnExpYear,ordName,ordEmailAddress,ordPhoneNumber,ordAddress1,ordCity,
		 ordProvince,ordCountry,trnExpYear,trnExpMonth&merchant_id=223200041&trnAmount=500&errorPage=http://www.yahoo.com
		 */
		// print_r($fields);
		 ?>
         <script language="javascript">
         	window.location.href = "<?php print $this->BEAN_STREAM_TRANSACTION_URL_GET($fields); ?>";
         </script>
         <?php
	 } 
	 const BEAN_STREAM_TRANSACTION_URL="https://www.beanstream.com/scripts/process_transaction.asp";
	 function BEAN_STREAM_TRANSACTION_URL_GET($fields)
	 {
		 return self::BEAN_STREAM_TRANSACTION_URL."?".http_build_query($fields);
	 }
	 /////////////////////////////////////////////////////////////////////////////////////////////////////////
	 /////////////////////////////////////////////////////////////////////////////////////////////////////////
	 /////////////////////////////////////////////////////////////////////////////////////////////////////////
	 static function ORDER_NUMBER_LABEL()
	 {
		 ?>
		 <div class="lineTextHeight22 marginBottom2px height22PX">Order Number:</div>
		 <?php
	 }
	 static function ORDER_NUMBER_INPUT()
	 {
		 ?>
         <div class="lineTextHeight22 marginBottom2px height22PX"><input type="text" name="trnOrderNumber" disabled="disabled" id="trnOrderNumber" 
         value="<?php print $_POST["orderNumber"]; ?>" /></div>
         <?php
	 }
	 static function ORDER_NAME_LABEL()
	 {
		 ?>
         <div class="lineTextHeight22 marginBottom2px height22PX">Name:</div>
         <?php
	 }
	 static function ORDER_NAME_INPUT()
	 {
		 ?>
         <div class="lineTextHeight22 marginBottom2px height22PX"><input type="text" name="ordName" id="ordName" value="Muhamad Nasim" /></div>
         <?php
	 }
	 static function EMAIL_LABEL()
	 {
		 ?>
         <div class="lineTextHeight22 marginBottom2px height22PX">Email Address:</div>
         <?php
	 }
	 static function EMAIL_INPUT()
	 {
		 ?>
         <div class="lineTextHeight22 marginBottom2px height22PX"><input type="text" name="ordEmailAddress" id="ordEmailAddress" value="muhamad.nasim@gmail.com" /></div>
         <?php
	 }
	 static function PHONE_NUMBER_LABEL()
	 {
		 ?>
         <div class="lineTextHeight22 marginBottom2px height22PX">Phone Number:</div>
         <?php
	 }
	 static function PHONE_NUMBER_INPUT()
	 {
		 ?>
         <div class="lineTextHeight22 marginBottom2px height22PX"><input type="text" name="ordPhoneNumber" id="ordPhoneNumber" value="+384222555666222" /></div>
         <?php
	 }
	 static function ADDRESS_1__LABEL()
	 {
		 ?>
         <div class="lineTextHeight22 marginBottom2px height22PX">Address1:</div>
         <?php
	 }
	 static function ADDRESS_1__INPUT()
	 {
		 ?>
         <div class="lineTextHeight22 marginBottom2px height22PX"><input type="text" name="ordAddress1" id="ordAddress1" value="Address 1" /></div>
         <?php
	 }
	 static function ADDRESS_2__LABEL()
	 {
		 ?>
         <div class="lineTextHeight22 marginBottom2px height22PX">Address2:</div>
         <?php
	 }
	 static function ADDRESS_2__INPUT()
	 {
		 ?>
         <div class="lineTextHeight22 marginBottom2px height22PX"><input type="text" name="ordAddress2" id="ordAddress2" value="Address 2(optional)" /></div>
         <?php
	 }
	 static function CITIE_LABEL()
	 {
		 ?>
         <div class="lineTextHeight22 marginBottom2px height22PX">City:</div>
         <?php
	 }
	 static function CITIE_INPUT()
	 {
		 ?>
         <div class="lineTextHeight22 marginBottom2px height22PX"><input type="text" name="ordCity" id="ordCity" value="Pakistan" /></div>
         <?php
	 }
	 static function PROVINCE_LABEL()
	 {
		 ?>
         <div class="lineTextHeight22 marginBottom2px height22PX">Province:</div>
         <?php
	 }
	 static function PROVINCE_INPUT()
	 {
		 ?>
         <div class="lineTextHeight22 marginBottom2px height22PX">
              <!--
              /*
              2 characters
              Province and state ID codes in this variable must match one of the available province and state codes.
              tabelata so kodovi se naoga na stranica 74 od BEAN_API_Integration.pdf
              */
              -->
              <select id="provinceBeanstreamSelect">
                  <option>-Select state code please-</option>
                  <?php
                      HELPWordpress::ALL_US_CANADA_OPTIONS_ADD();
                  ?>
                  <option>Outside U.S./Canada</option>
              </select>
          </div>
         <?php
            RightForms::CREATE_INPUTS_INVISIBLE(array( "ordProvince"), array("01"));
	 }
	 static function POSTAL_CODE_LABEL()
	 {
		 ?>
         <div class="lineTextHeight22 marginBottom2px height22PX">Postal Code:</div>
         <?php
	 }
	 static function POSTAL_CODE_INPUT()
	 {
		 ?>
         <div class="lineTextHeight22 marginBottom2px height22PX"><input type="text" name="ordPostalCode" id="ordPostalCode" value="6000" /></div>
         <?php
	 }
	 static function COUNTRY_LABEL()
	 {
		 ?>
         <div class="lineTextHeight22 marginBottom2px height22PX">Country:</div>
         <?php
	 }
	 static function COUNTRY_INPUT()
	 {
		 ?>
         <div class="lineTextHeight22 marginBottom2px height22PX">                	
              <select id="countryBeanStreamSelect" onchange="objGateWay.setCountrie();">
                  <option>-Country-</option>
                  <?php HELPWordpress::ALL_COUNTRIES_OPTIONS_ADD(); ?>
              </select>
          </div>
         <?php
            RightForms::CREATE_INPUTS_INVISIBLE(array( "ordCountry"), array("01"));
	 }
	 //$ordPostalCode, $ordCountry
	 /////////////////////////////////////////////////////////////////////////////////////////////////////////
	 /////////////////////////////////////////////////////////////////////////////////////////////////////////
	 /////////////////////////////////////////////////////////////////////////////////////////////////////////
	 public static function PRINT_FORM_CREDIT_CART()
	 {
		 ?>
         <div id="creaditCartBeanStream" style="border-style:none; border-color:#F00; display:none;">
         	<div class="floatLEft">
            	<div id="CCLabelsCard">
                    <div class="lineTextHeight22 marginBottom2px height22PX">Amount:</div>
                    <div class="lineTextHeight22 marginBottom2px height22PX">Error Page:</div>
                    <div class="lineTextHeight22 marginBottom2px height22PX">Approved Page:</div>
                    <div class="lineTextHeight22 marginBottom2px height22PX">Declined Page:</div>
                    <div class="lineTextHeight22 marginBottom2px height22PX">Card Owner:</div>
                    <div class="lineTextHeight22 marginBottom2px height22PX">Card Number:</div>
                    <div class="lineTextHeight22 marginBottom2px height22PX">Exp. Month:</div>
                    <div class="lineTextHeight22 marginBottom2px height22PX">Exp. Year:</div>
                    <div class="lineTextHeight22 marginBottom2px height22PX">Card Cvd:</div>
                </div>
                <?php print self::ORDER_NUMBER_LABEL(); ?>
            	<?php print self::ORDER_NAME_LABEL(); ?>
            	<?php print self::EMAIL_LABEL(); ?>
            	<?php print self::PHONE_NUMBER_LABEL(); ?>
            	<?php print self::ADDRESS_1__LABEL(); ?>
            	<?php print self::ADDRESS_2__LABEL(); ?>
            	<?php print self::CITIE_LABEL(); ?>
            	<?php print self::PROVINCE_LABEL(); ?>
            	<?php print self::POSTAL_CODE_LABEL(); ?>
            	<?php print self::COUNTRY_LABEL(); ?>
                <div style="display:none;">
                    <div class="lineTextHeight22 marginBottom2px height22PX">Term URL:</div>
                    <div class="lineTextHeight22 marginBottom2px height22PX">VBV Enabled:</div>
                    <div class="lineTextHeight22 marginBottom2px height22PX">SC Enabled:</div>
                    <div class="lineTextHeight22 marginBottom2px height22PX">Secure XID:</div>
                    <div class="lineTextHeight22 marginBottom2px height22PX">Secure ECI:</div>
                    <div class="lineTextHeight22 marginBottom2px height22PX">Secire CAVV:</div>
                </div>
            </div>
            <div class="floatLEft">
            	<div id="CCInputsCard">
                    <div class="lineTextHeight22 marginBottom2px height22PX"><input type="text" name="trnAmount" id="trnAmount" value="10.00" /></div>
                    <div class="lineTextHeight22 marginBottom2px height22PX"><input type="text" name="errorPage" id="errorPage" value="http://" /></div>
                    <div class="lineTextHeight22 marginBottom2px height22PX"><input type="text" name="approvedPage" id="approvedPage" value="http://" /></div>
                    <div class="lineTextHeight22 marginBottom2px height22PX"><input type="text" name="declinedPage" id="declinedPage" value="http://" /></div>
                    <div class="lineTextHeight22 marginBottom2px height22PX"><input type="text" name="trnCardOwner" id="trnCardOwner" value="Muhamed Nasem" /></div>
                    <div class="lineTextHeight22 marginBottom2px height22PX"><input type="text" name="trnCardNumber" id="trnCardNumber" value="12121323214545465" /></div>
                    <div class="lineTextHeight22 marginBottom2px height22PX">
                        <select>
                            <option>01</option>
                            <option>02</option>
                            <option>03</option>
                            <option>04</option>
                            <option>05</option>
                            <option>06</option>
                            <option>07</option>
                            <option>08</option>
                            <option>09</option>
                            <option>10</option>
                            <option>11</option>
                            <option>12</option>
                        </select>
                        <?php
                            RightForms::CREATE_INPUTS_INVISIBLE(array( "trnExpMonth"), array("01"));
                        ?>
                    </div>
                    <!--2 digits (2011=11)-->
                    <div class="lineTextHeight22 marginBottom2px height22PX"><b>20</b><input type="text" name="trnExpYear" maxlength="2" id="trnExpYear" value="12" /></div>
                    <div class="lineTextHeight22 marginBottom2px height22PX"><input type="text" name="trnCardCvd" id="trnCardCvd" value="1234" /></div>
                </div>
                <?php print self::ORDER_NUMBER_INPUT(); ?>
            	<?php print self::ORDER_NAME_INPUT(); ?>
            	<?php print self::EMAIL_INPUT(); ?>
            	<?php print self::PHONE_NUMBER_INPUT(); ?>
            	<?php print self::ADDRESS_1__INPUT(); ?>
            	<?php print self::ADDRESS_2__INPUT(); ?>
            	<?php print self::CITIE_INPUT(); ?>
            	<?php print self::PROVINCE_INPUT(); ?>
            	<?php print self::POSTAL_CODE_INPUT(); ?>
            	<?php print self::COUNTRY_INPUT(); ?>
                <div style="display:none;">
                    <div class="lineTextHeight22 marginBottom2px height22PX"><input type="text" name="termURL" id="termURL" value="http://" /></div>
                    <div class="lineTextHeight22 marginBottom2px height22PX"><input type="text" name="vbvEnabled" id="vbvEnabled" value="http://" /></div>
                    <div class="lineTextHeight22 marginBottom2px height22PX"><input type="text" name="scEnabled" id="scEnabled" value="http://" /></div>
                    <div class="lineTextHeight22 marginBottom2px height22PX"><input type="text" name="SecureXID" id="SecureXID" value="http://" /></div>
                    <div class="lineTextHeight22 marginBottom2px height22PX"><input type="text" name="SecureECI" id="SecureECI" value="http://" /></div>
                    <div class="lineTextHeight22 marginBottom2px height22PX"><input type="text" name="SecireCAVV" id="SecireCAVV" value="http://" /></div>
                </div>
            </div>
            <div class="clearBoth"></div>
         </div>
         <?php
	 }
}

?>
<!--

/*TEST END TEST*/
/*
$trnOrderNumber,$trnAmount,$errorPage,$approvedPage,$declinedPage,$trnCardOwner,$trnCardNumber,$trnExpMonth,
	$trnExpYear,$trnCardCvd,$ordName,$ordEmailAddress,$ordPhoneNumber,$ordAddress1,$ordAddress2,$ordCity,$ordProvince,
	$ordPostalCode,$ordCountry,$termURL,$vbvEnabled,$scEnabled,$SecureXID,$SecureECI,$SecireCAVV
*/
if(!isset($_GET["errorMessage"]) && !isset($_GET["trnApproved"]))
{
	$objBean = new BeanStream();
	/*
	$objBean->setCreditCardPurchase( "0000000000001",300,
	"http://localhost/muhamed/cheque-wp/wp-content/themes/c-t/php/payment/beanstream-gateway/beanstream-php5.php",
	"http://localhost/muhamed/cheque-wp/wp-content/themes/c-t/php/payment/beanstream-gateway/beanstream-php5.php",
	"http://localhost/muhamed/cheque-wp/wp-content/themes/c-t/php/payment/beanstream-gateway/beanstream-php5.php",
	"Zlatko Derkoski",
	"5160111222120489", "01","15","1000","Zlatko Derkoski","zlatkoflash@yahoo.com", "+38970529556", "Adresa 1", "Adresa 2", 
	"Ohrid", "AB", "6000", "AX", "http://termURL.com", "vbv is enabled or not??", "scIsEnabledOrNOt ??", "security XID is enabled or not??",
	"Security ECI", "Secire SiAVV");
	*/
	/**/
	$objBean->setInterac( "00000000000000000000000001", 
	"http://localhost/muhamed/cheque-wp/wp-content/themes/c-t/php/payment/beanstream-gateway/beanstream-php5.php",
	"http://localhost/muhamed/cheque-wp/wp-content/themes/c-t/php/payment/beanstream-gateway/beanstream-php5.php",
	"http://localhost/muhamed/cheque-wp/wp-content/themes/c-t/php/payment/beanstream-gateway/beanstream-php5.php",
	"Zlatko Derkoski",
	"zlatkoflash@yahoo.com",
	"+38970529556",
	"Address 1 test",
	"ADdress 2 test",
	"Ohrid","AB","6000","AX");
		
	$objBean->trnAmount_set( 500 );
	$objBean->process();
}
else if(isset($_GET["errorMessage"]))
{
	print $_GET["errorMessage"];
}
else if(isset($_GET["trnApproved"]))
{
	//$_GET["trnApproved"] == 0(Transaction declined)
	//$_GET["trnApproved"] == 1(Transaction approved)
	print $_GET["messageText"];
}
-->

