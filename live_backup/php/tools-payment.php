
    <?php
	
	if(!class_exists("SETTINGS")){require_once("settings.php");}

	////////////////////////////////////////////////////////////////////////////////////////////////////////////
	////////////////////////////////////////////////////////////////////////////////////////////////////////////
	/////Class for Payment
	////////////////////////////////////////////////////////////////////////////////////////////////////////////
	class Payment
	{
		private $paymentMethod;
		//////////////////////////////////////////////////////////////////////////////////
		const BEANSTREAM="Beanstream";
		const BLUEPAY="BluePay";
		const PAYMENT_METHOD_CREDIT_CARD="Credit Card";
		const PAYMENT_METHOD_INTERAC="Interac";
		const SHIPPING_UPS="UPS";
		const SHIPPING_CANSHIP="CANSHIP";
		const SHIPPING_CANADA_POST="CANADA POST";
		public static function SET_SHIPPING_METHODS()
		{
			?>            
            <option>UPS</option>
            <option>CANSHIP</option>
            <option>CANADA POST</option>
            <?php
		}
		var $totalPrice,
			$paymentGateway,
			$shippingTYpe;
		var $gateway;
		
		public function Payment()
		{
			$this->setupPostVariables();	
			$this->REALIZE();
		}
		function setupPostVariables()
		{
			$this->paymentMethod = $_POST["paymentMethodSelectINPUT"];
			$this->shippingTYpe = $_POST["shipingAndHendlinkTypeINPUT"];
			$this->totalPrice = $_POST["totalPRICE"];
			$this->paymentGateway = $_POST["gateWayINPUT"];
		}
		function REALIZE()
		{
			switch($this->paymentGateway)
			{
				case Payment::BEANSTREAM:
				{
					$this->setBEANSTREAM();
				}break;
				case Payment::BLUEPAY:
				{
					$this->setBLUEPAY();
				}break;
			}
		}
		function setBLUEPAY()
		{	
			require_once("payment/bluepay-gateway/bp-php5.php");
			$this->gateway = new BluePayment(BluePayment::ACCOUNT_ID,BluePayment::SECRET_KEY,BluePayment::MODE);
			$this->gateway->setCustInfo($_POST["account"],$_POST["cvv2"],$_POST["expire"],$_POST["firstName"],
										$_POST["lastName"],$_POST["address"],$_POST["city"],
										$_POST["provinceBLuePay"], $_POST["ZIP"], $_POST["countryBluePay"], $_POST["phone"], $_POST["email"],
										"","","","");
			print "Please wait, BluePay is processing...";
			$this->transId = $_POST["orderNumber"];
			$this->gateway->sale( $this->totalPrice );
			$this->gateway->process();
			/*
			echo 'Response: '. $this->gateway->getResponse() .'<br />'.
			 'TransId: '. $this->gateway->getTransId() ."[".$_POST["orderNumber"].']<br />'.
			 'Status: '. $this->gateway->getStatus() .'<br />'.
			 'AVS Resp: '. $this->gateway->getAvsResp() .'<br />'.
			 'CVV2 Resp: '. $this->gateway->getCvv2Resp() .'<br />'.
			 'Auth Code: '. $this->gateway->getAuthCode() .'<br />'.
			 'Message: '. $this->gateway->getMessage() .'<br />'.
			 'Rebid: '. $this->gateway->getRebid();
			 */
			 Payment::DRAW_FORM_TO_NAVIGATE(Payment::BLUEPAY, "Credit Card", $_POST["shipingAndHendlinkTypeINPUT"], $this->gateway->getMessage(), $this->gateway->getStatus(), 
			 								$_POST["orderNumber"]);
		}
		function setBEANSTREAM()
		{
			require_once("payment/beanstream-gateway/beanstream-php5.php");
			$this->gateway = new BeanStream();
			if($this->paymentMethod == Payment::PAYMENT_METHOD_CREDIT_CARD)
			{
				$this->setBEANSTREAM_PAYMENT_METHOD_CREDIT_CARD();
			}
			else if($this->paymentMethod == Payment::PAYMENT_METHOD_INTERAC)
			{
				$this->setBEANSTREAM_PAYMENT_METHOD_INTERAC();
			}
			$this->gateway->trnAmount_set( $this->totalPrice );
			$this->gateway->process();
		}
		function setBEANSTREAM_PAYMENT_METHOD_CREDIT_CARD()
		{
			$this->gateway->setCreditCardPurchaseABS();
		}
		function setBEANSTREAM_PAYMENT_METHOD_INTERAC()
		{
			$this->gateway->setInteracABS();
		}
		public static function DRAW_FORM_TO_NAVIGATE($gatewayType, $paymentMethod, $shippingAndHandling, $statusMessage, $statusVALUE, $orderNumber)
		{
			?>
            	<form id="formGoToTransactionStatusPage" action="<?php print SETTINGS::URL_TO_TRANSACTION_STATUS_PAGE; ?>" method="post" enctype="multipart/form-data">
                	<input type="hidden" value="<?php print $gatewayType; ?>" name="gatewayType" />
                	<input type="hidden" value="<?php print $paymentMethod; ?>" name="paymentMethod" />
                	<input type="hidden" value="<?php print $shippingAndHandling; ?>" name="shippingAndHandling" />
                	<input type="hidden" value="<?php print $statusMessage; ?>" name="statusMessage" />
                	<input type="hidden" value="<?php print $statusVALUE; ?>" name="statusVALUE" />
                	<input type="hidden" value="<?php print $orderNumber; ?>" name="orderNumber" />
                </form>
                <script>
                	document.getElementById("formGoToTransactionStatusPage").submit();
                </script>
            <?php
		}
	}
	if(isset($_POST["gateWayINPUT"]))
	{
		$objPayment = new Payment();
	}
	//for beanstream
	if(isset($_GET["errorMessage"]) || isset($_GET["trnApproved"]))//for beanstream
	{
		Payment::DRAW_FORM_TO_NAVIGATE(Payment::BEANSTREAM, $_GET["paymentMethod"], "Not deffined for beanstream yet", $_GET["errorMessage"], "E", 
			 								$_GET["trnOrderNumber"]);
	}
	foreach($_GET as $key => $value)
	{
		//print $key."=".$_GET[$key]."<br/>";
	}
	////////////////////////////////////////////////////////////////////////////////////////////////////////////
	////////////////////////////////////////////////////////////////////////////////////////////////////////////
	//////////////////////This class is using into trstat.php for showing results of transaction
	////////////////////////////////////////////////////////////////////////////////////////////////////////////
	class PaymentTransactionStatus
	{
		var $gatewayType,
			$paymentMethod,
			$shippingAndHandling,
			$statusMessage,
			$statusVALUE,
			$orderNumber;
		var $odrerChequeNumber;
		const STATUS_ERROR="ERROR";
		const STATUS_APPROVED="APPROVED";
		const STATUS_DECLINE="DECLINE";
		
		public function PaymentTransactionStatus()
		{
			$this->gatewayType = $_POST["gatewayType"];
			$this->paymentMethod = $_POST["paymentMethod"];
			$this->shippingAndHandling = $_POST["shippingAndHandling"];
			$this->statusMessage = $_POST["statusMessage"];
			/*
			For Bean stream status
			else if(isset($_GET["errorMessage"]))
			{
				print $_GET["errorMessage"];
			}
			else if(isset($_GET["trnApproved"]))
			{
				//$_GET["trnApproved"] == 0(Transaction declined)
				//$_GET["trnApproved"] == 1(Transaction approved)
				print $_GET["messageText"];
			}*/
			/*
			BluePay Directly realisied the payment result and giving all messages here
			BluePay:
			 const STATUS_DECLINE = '0'; // DECLINE
			 const STATUS_APPROVED = '1'; // APPROVED
			 const STATUS_ERROR = 'E'; // ERROR
			*/
			
			$this->statusVALUE = $_POST["statusVALUE"];
			$this->orderNumber = $_POST["orderNumber"];
		}
		public function statusLabel()
		{
			if($this->statusVALUE == "0")
			{
				return self::STATUS_DECLINE;
			}
			if($this->statusVALUE == "1")
			{
				return self::STATUS_APPROVED;
			}
			if($this->statusVALUE == "E")
			{
				return self::STATUS_ERROR;
			}
		}
	}
?>