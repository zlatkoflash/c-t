<?
/*
*
* Bluepay 2.0 PHP 4.3 API
* Main changes:
* -Added additional fields that were not addressed by API Phone, Email, CustomID 1, Custom ID 2
* -Added function for the processing of ACH Transactions
* -Created a http_build_query function since PHP v < 5 does not have one built in
* -Changed variable declarations (PHP v < 5 does not have public, private or protected)
* -Changed how constants are defined
* -Changed every occurance of self:: to BluePayment:: since PHP v < 5 do not have a self:: resolution operator.
* -There is no md5( $string, bool ) in PHP versions < 5 so the tamper proof seal function was changed from: return bin2hex( md5($hashstr, true) );
*   to: return md5($hashstr); Which works just the same.
*
*  IF YOU NEED SUPPORT ON THIS MODULE, PLEASE CONTACT BLUEPAY:
*  630-300-2396, or support@bluepay.com
*
*
*  This module provided courtesy of:
* 
*  Module Extended by
*  The InDesign Firm, Inc.
*  E-mail: support@indesignfirm.com
*  Phone: 803-233-2713
*  Address:  www.indesignfirm.com
*
*  Matthew Crinklaw-Vogt
*  E-mail address: matt.crinklaw@gmail.com
*  Phone: 757-871-7206
*  Address: 137 Meadowbrook
*               Williamsburg, VA 23188
*/
/*
Helper function for http_build_query
*/
function toString( $string ) {
	if ( preg_match( '/ /', $string ) ) {
		$elements = explode( ' ', $string );
		$string = '';
		$f = true;
		foreach( $elements as $elem ) {
			if ( $f ) {
				$string .= $elem;
				$f = false;
			}
			else
				$string .= '+' . $elem;
		}
	}
	return $string;
}

/*
Performs the exact same operations as the PHP5 'http_build_query' function
*/
function http_build_query( &$data ) {
	$keys = array_keys( $data );
	$string = '';
	$f = true;
	foreach ( $keys as $key ) {
		if ( $f ) {
			$string .= $key . '=' . toString($data[$key]);
			$f = false;
		}
		else
			$string .= '&' . $key . '=' . toString($data[$key]);
	}
	return $string;
}


/***
 * class BluePayment
 *
 * Written By:
 * Peter Finley 
 * peter.finley@gmail.com
 * 630.730.1178
 * (based on code by Chris Jansen)
 *
 * This class provides the ability to perform credit
 * card transactions through BluePay's v2.0 interface.
 * This is done by performing a POST (using PHP's 
 * CURL wrappers), then recieving and parsing the 
 * response.
 *
 * A few notes:
 *
 * - set tab spacing to 3, for optimal viewing
 *
 * - PAYMENT_TYPE of ACH is not dealt with at all
 *
 * - Rebilling could be further developed (i.e. 
 * automatically format parameters better, such 
 * as to be able to use UNIX timestamp for the 
 * first date parameter, etc.)
 *
 * - Level 2 qualification is in place, but I'm not 
 * really sure how it is used, so did not do any 
 * more than allow for the parameters to be set.
 *
 * - this class has not been fully tested
 *
 * - there is little to no parameter error 
 * checking (i.e. sending a NAME1 of over 16 
 * characters is allowed, but will yeild an 'E' 
 * (error) STATUS response)
 *
 * - this class is written in PHP 5 (and is _not_ 
 * compatable with any previous versions)
 */
 
 /*
 PHP 4.3 version of defining constants.
 */
  /* constants */
 define( 'MODE', 'TEST' ); // either TEST or LIVE
 //https://secure.bluepay.com/interfaces/bp20post
 //https://secure.bluepay.com/interfaces/bp10emu
 define( 'POST_URL', 'https://secure.bluepay.com/interfaces/bp20post' ); // the url to post to
 define( 'ACCOUNT_ID', 'INSERT GATEWAY ACCOUNT ID HERE' ); // the default account id
 define( 'SECRET_KEY', 'INSERT SECRET KEY HERE' ); // the default secret key

 /* STATUS response constants */
 define( 'STATUS_DECLINE', '0' ); // DECLINE
 define( 'STATUS_APPROVED', '1' ); // APPROVED
 define( 'STATUS_ERROR', 'E' ); // ERROR
 
class BluePayment {

/*
PHP 4.3 does not have 'public, private or protected, changed all variable declarations to 'var'
*/
 /* merchant supplied parameters */
 var $accountId; // ACCOUNT_ID
 var $userId; // USER_ID (optional)
 var $tps; // TAMPER_PROOF_SEAL
 var $transType; // TRANS_TYPE (AUTH, SALE, REFUND, or CAPTURE)
 var $payType; // PAYMENT_TYPE (CREDIT or ACH)
 var $mode; // MODE (TEST or LIVE)
 var $masterId; // MASTER_ID (optional)
 var $secretKey; // used to generate the TPS


 /* customer supplied fields, (not required if
 MASTER_ID is set) */
 var $account; // PAYMENT_ACCOUNT (i.e. credit card number)
 var $cvv2; // CARD_CVVS
 var $expire; // CARD_EXPIRE 
 var $ssn; // SSN (Only required for ACH)
 var $birthdate; // BIRTHDATE (only required for ACH)
 var $custId; // CUST_ID (only required for ACH)
 var $custIdState; // CUST_ID_STATE (only required for ACH)
 var $amount; // AMOUNT
 var $name1; // NAME1
 var $name2; // NAME2
 var $addr1; // ADDR1
 var $addr2; // ADDR2 (optional)
 var $city; // CITY
 var $state; // STATE
 var $zip; // ZIP
 var $country; // COUNTRY
 var $memo; // MEMO (optinal)


 /* feilds for level 2 qualification */
 var $orderId; // ORDER_ID
 var $invoiceId; // INVOICE_ID
 var $tip; // AMOUNT_TIP
 var $tax; // AMOUNT_TAX


 /* rebilling (only with trans type of SALE or AUTH) */
 var $doRebill; // DO_REBILL
 var $rebDate; // REB_FIRST_DATE
 var $rebExpr; // REB_EXPR
 var $rebCycles; // REB_CYCLES
 var $rebAmount; // REB_AMOUNT


 /* additional fraud scrubbing for an AUTH */
 var $doAutocap; // DO_AUTOCAP
 var $avsAllowed; // AVS_ALLOWED
 var $cvv2Allowed; // CVV2_ALLOWED


 /* bluepay response output */
 var $response;

 /* parsed response values */
 var $transId;
 var $status;
 var $avsResp;
 var $cvv2Resp;
 var $authCode;
 var $message;
 var $rebid;




 /***
 * __construct()
 *
 * Constructor method, sets the account, secret key, 
 * and the mode properties. These will default to 
 * the constant values if not specified.
 */
 function BluePayment($account = ACCOUNT_ID, 
 $key = SECRET_KEY, $mode = MODE) {
 $this->accountId = $account;
 $this->secretKey = $key;
 $this->mode = $mode;
 }




 /***
 * sale()
 *
 * Will perform a SALE transaction with the amount
 * specified.
 */
 function sale($amount) {

 $this->transType = "SALE";
 /*
 PHP 4.3 does not have a 'self::' operation so you have to use the actual class name
 */
 $this->amount = BluePayment::formatAmount($amount);
 }




 /***
 * rebSale()
 *
 * Will perform a sale based on a previous transaction.
 * If the amount is not specified, then it will use
 * the amount of the previous transaction.
 */
 function rebSale($transId, $amount = null) {

 $this->masterId = $transId;
 $this->sale($amount);
 }




 /***
 * auth()
 *
 * Will perform an AUTH transaction with the amount
 * specified.
 */
 function auth($amount) {

 $this->transType = "AUTH";
 $this->amount = BluePayment::formatAmount($amount);
 }




 /***
 * autocapAuth()
 *
 * Will perform an auto-capturing AUTH using the
 * provided AVS and CVV2 proofing.
 */
 function autocapAuth($amount, $avsAllow = null, $cvv2Allow = null) {

 $this->auth($amount);
 $this->setAutocap();
 $this->addAvsProofing($avsAllow);
 $this->addCvv2Proofing($avsAllow);
 }




 /***
 * addLevel2Qual()
 *
 * Adds additional level 2 qualification parameters.
 */
 function addLevel2Qual($orderId = null, $invoiceId = null, 
 $tip = null, $tax = null) {

 $this->orderId = $orderId;
 $this->invoiceId = $invoiceId;
 $this->tip = $tip;
 $this->tax = $tax;
 }




 /***
 * refund()
 *
 * Will do a refund of a previous transaction.
 */
 function refund($transId) {

 $this->transType = "REFUND";
 $this->masterId = $transId;
 }




 /***
 * capture()
 *
 * Will capture a pending AUTH transaction.
 */
 function capture($transId) {

 $this->transType = "CAPTURE";
 $this->masterId = $transId;
 }




 /***
 * rebAdd()
 *
 * Will add a rebilling cycle.
 */
 function rebAdd($amount, $date, $expr, $cycles) {

 $this->doRebill = '1';
 $this->rebAmount = BluePayment::formatAmount($amount);
 $this->rebDate = $date;
 $this->rebExpr = $expr;
 $this->rebCycles = $cycles;
 }




 /***
 * addAvsProofing()
 *
 * Will set which AVS responses are allowed (only
 * applicable when doing an AUTH)
 */
 function addAvsProofing($allow) {

 $this->avsAllowed = $allow;
 }




 /***
 * addCvv2Proofing()
 *
 * Will set which CVV2 responses are allowed (only
 * applicable when doing an AUTH)
 */
 function addCvv2Proofing($allow) {

 $this->cvv2Allowed = $allow;
 }




 /***
 * setAutocap()
 *
 * Will turn auto-capturing on (only applicable
 * when doing an AUTH)
 */
 function setAutocap() {

 $this->doAutocap = '1';
 }


 /***
 * setCustACHInfo()
 *
 * Sets the customer specified info.
 */
 function setCustACHInfo($routenum, $accntnum, $accttype, $name1, $name2, 
 $addr1, $city, $state, $zip, $country, $phone, $email, $customid1 = null, $customid2 = null,
 $addr2 = null, $memo = null) {

 $this->account = $accttype.":".$routenum.":".$accntnum;
 $this->payType = 'ACH';
 $this->name1 = $name1;
 $this->name2 = $name2;
 $this->addr1 = $addr1;
 $this->addr2 = $addr2;
 $this->city = $city;
 $this->state = $state;
 $this->zip = $zip;
 $this->country = "USA";
 $this->phone = $phone;
 $this->email = $email;
 $this->customid1 = $customid1;
 $this->customid2 = $customid2;
 $this->memo = $memo;
 }

 /***
 * setCustInfo()
 *
 * Sets the customer specified info.
 */
 function setCustInfo($account, $cvv2, $expire, $name1, $name2, 
 $addr1, $city, $state, $zip, $country, $phone, $email, $customid1 = null, $customid2 = null,
 $addr2 = null, $memo = null) {

 $this->account = $account;
 $this->cvv2 = $cvv2;
 $this->expire = $expire;
 $this->name1 = $name1;
 $this->name2 = $name2;
 $this->addr1 = $addr1;
 $this->addr2 = $addr2;
 $this->city = $city;
 $this->state = $state;
 $this->zip = $zip;
 $this->country = "USA";
 $this->phone = $phone;
 $this->email = $email;
 $this->customid1 = $customid1;
 $this->customid2 = $customid2;
 $this->memo = $memo;
 }




 /***
 * formatAmount()
 *
 * Will format an amount value to be in the
 * expected format for the POST.
 */
function formatAmount($amount) {
	return sprintf("%01.2f", (float)$amount);
}




 /***
 * setOrderId()
 *
 * Sets the ORDER_ID parameter.
 */
 //static
 function setOrderId($orderId) {

 $this->orderId = $orderId;
 }




 /***
 * calcTPS()
 *
 * Calculates & returns the tamper proof seal md5.
 */
 
 //final
 function calcTPS() {

 $hashstr = $this->secretKey . $this->accountId . $this->transType . 
 $this->amount . $this->masterId . $this->name1 . $this->account;
/*&&*/
// bin2hex( md5( str, true ) );
 return md5($hashstr);
 }

/***
 * processACH()
 *
 * Will first generate the tamper proof seal, then 
 * populate the POST query, then send it, and store 
 * the response, and finally parse the response.
 */
function processACH() {

	 /* calculate the tamper proof seal */
	 $tps = $this->calcTPS();
	
	 //echo $this->account;
	 
	 /* fill in the fields */
	 $fields = array (
	 'ACCOUNT_ID' => $this->accountId,
	 'USER_ID' => $this->userId,
	 'TAMPER_PROOF_SEAL' => $tps,
	 'TRANS_TYPE' => $this->transType,
	 'PAYMENT_TYPE' => $this->payType,
	 'MODE' => $this->mode,
	 'MASTER_ID' => $this->masterId,
	
	 'PAYMENT_ACCOUNT' => $this->account,
	 'SSN' => $this->ssn,
	 'BIRTHDATE' => $this->birthdate,
	 'CUST_ID' => $this->custId,
	 'CUST_ID_STATE' => $this->custIdState,
	 'AMOUNT' => $this->amount,
	 'NAME1' => $this->name1,
	 'NAME2' => $this->name2,
	 'ADDR1' => $this->addr1,
	 'ADDR2' => $this->addr2,
	 'CITY' => $this->city,
	 'STATE' => $this->state,
	 'ZIP' => $this->zip,
	 'PHONE' => $this->phone,
	 'EMAIL' => $this->email,
	 'COUNTRY' => $this->country,
	 'MEMO' => $this->memo,
	 'CUSTOM_ID' => $this->customid1,
	 'CUSTOM_ID2' => $this->customid2,
	
	 'ORDER_ID' => $this->orderId,
	 'INVOICE_ID' => $this->invoiceId,
	 'AMOUNT_TIP' => $this->tip,
	 'AMOUNT_TAX' => $this->tax,
	
	 'DO_REBILL' => $this->doRebill,
	 'REB_FIRST_DATE' => $this->rebDate,
	 'REB_EXPR' => $this->rebExpr,
	 'REB_CYCLES' => $this->rebCycles,
	 'REB_AMOUNT' => $this->rebAmount);
	 
	 
	 /* perform the transaction */
	 $ch = curl_init();
	
	 curl_setopt($ch, CURLOPT_URL, self::POST_URL); // Set the URL
	 curl_setopt($ch, CURLOPT_USERAGENT, "BluepayPHP SDK/2.0"); // Cosmetic
	 curl_setopt($ch, CURLOPT_POST, 1); // Perform a POST
	 // curl_setopt($ch, CURLOPT_CAINFO, "c:\\windows\\ca-bundle.crt"); // Name of the file to verify the server's cert against
	 curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0); // Turns off verification of the SSL certificate.
	 curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); // If not set, curl prints output to the browser
	 curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($fields));
	
	 $this->response = curl_exec($ch);
	
	 curl_close($ch); 
	
	 /* parse the response */
	 $this->parseResponse();
 }


 /***
 * process()
 *
 * Will first generate the tamper proof seal, then 
 * populate the POST query, then send it, and store 
 * the response, and finally parse the response.
 */
function process() {

	 /* calculate the tamper proof seal */
	 $tps = $this->calcTPS();
	
	 echo $this->account;
	 
	 /* fill in the fields */
	 $fields = array (
	 'ACCOUNT_ID' => $this->accountId,
	 'USER_ID' => $this->userId,
	 'TAMPER_PROOF_SEAL' => $tps,
	 'TRANS_TYPE' => $this->transType,
	 'PAYMENT_TYPE' => $this->payType,
	 'MODE' => $this->mode,
	 'MASTER_ID' => $this->masterId,
	
	 'PAYMENT_ACCOUNT' => $this->account,
	 'CARD_CVV2' => $this->cvv2,
	 'CARD_EXPIRE' => $this->expire,
	 'SSN' => $this->ssn,
	 'BIRTHDATE' => $this->birthdate,
	 'CUST_ID' => $this->custId,
	 'CUST_ID_STATE' => $this->custIdState,
	 'AMOUNT' => $this->amount,
	 'NAME1' => $this->name1,
	 'NAME2' => $this->name2,
	 'ADDR1' => $this->addr1,
	 'ADDR2' => $this->addr2,
	 'CITY' => $this->city,
	 'STATE' => $this->state,
	 'ZIP' => $this->zip,
	 'PHONE' => $this->phone,
	 'EMAIL' => $this->email,
	 'COUNTRY' => $this->country,
	 'MEMO' => $this->memo,
	 'CUSTOM_ID' => $this->customid1,
	 'CUSTOM_ID2' => $this->customid2,
	
	 'ORDER_ID' => $this->orderId,
	 'INVOICE_ID' => $this->invoiceId,
	 'AMOUNT_TIP' => $this->tip,
	 'AMOUNT_TAX' => $this->tax,
	
	 'DO_REBILL' => $this->doRebill,
	 'REB_FIRST_DATE' => $this->rebDate,
	 'REB_EXPR' => $this->rebExpr,
	 'REB_CYCLES' => $this->rebCycles,
	 'REB_AMOUNT' => $this->rebAmount,
	
	 'DO_AUTOCAP' => $this->doAutocap,
	 'AVS_ALLOWED' => $this->avsAllowed,
	 'CVV2_ALLOWED' => $this->cvv2Allowed
	 );
	
	
	 /* perform the transaction */
	 $ch = curl_init();
	
	 curl_setopt($ch, CURLOPT_URL, self::POST_URL); // Set the URL
	 curl_setopt($ch, CURLOPT_USERAGENT, "BluepayPHP SDK/2.0"); // Cosmetic
	 curl_setopt($ch, CURLOPT_POST, 1); // Perform a POST
	 // curl_setopt($ch, CURLOPT_CAINFO, "c:\\windows\\ca-bundle.crt"); // Name of the file to verify the server's cert against
	 curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0); // Turns off verification of the SSL certificate.
	 curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); // If not set, curl prints output to the browser
	 curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($fields));
	
	 $this->response = curl_exec($ch);
	
	 curl_close($ch); 
	
	 /* parse the response */
	 $this->parseResponse();
 }





 /***
 * parseResponse()
 *
 * This method will parse the response parameter values
 * into the respective properties.
 */
 function parseResponse() {

 parse_str($this->response, $array);


 /* TRANS_ID */
 $this->transId = $array['TRANS_ID'];

 /* STATUS */
 $this->status = $array['STATUS'];

 /* AVS */
 $this->avsResp = $array['AVS'];

 /* CVV2 */
 $this->cvv2Resp = $array['CVV2'];

 /* AUTH_CODE */
 $this->authCode = $array['AUTH_CODE'];

 /* MESSAGE */
 $this->message = $array['MESSAGE'];

 /* REBID */
 $this->rebid = $array['REBID'];
 }




 /***
 * get[property]()
 *
 * Getter methods, return the respective property
 * values.
 */
 function getResponse() { return $this->response; }
 function getTransId() { return $this->transId; }
 function getStatus() { return $this->status; }
 function getAvsResp() { return $this->avsResp; }
 function getCvv2Resp() { return $this->cvv2Resp; }
 function getAuthCode() { return $this->authCode; }
 function getMessage() { return $this->message; }
 function getRebid() { return $this->rebid; }

}



/* EXAMPLE

$bp = new BluePayment();
$bp->sale('25.00');
$bp->setCustInfo('4111111111111111',
 '123',
 '0606',
 'Chris',
 'Jansen',
 '123 Bluepay Ln',
 'Bluesville',
 'IL',
 '60563',
 'USA');
$bp->process();

echo 'Response: '. $bp->getResponse() .'<br />'.
 'TransId: '. $bp->getTransId() .'<br />'.
 'Status: '. $bp->getStatus() .'<br />'.
 'AVS Resp: '. $bp->getAvsResp() .'<br />'.
 'CVV2 Resp: '. $bp->getCvv2Resp() .'<br />'.
 'Auth Code: '. $bp->getAuthCode() .'<br />'.
 'Message: '. $bp->getMessage() .'<br />'.
 'Rebid: '. $bp->getRebid();

END EXAMPLE */

?>
