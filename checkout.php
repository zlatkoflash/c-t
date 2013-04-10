<?php require_once("php/payment/bluepay-gateway/bp-php5.php"); ?>
<?php require_once("php/payment/beanstream-gateway/beanstream-php5.php"); ?>
<?php require_once("php/tools-payment.php"); ?>

<style>
	div
	{
		border-style:none;
		border-width:1px;
	}
	body
	{
		padding-bottom:10px;
	}
</style>
<script>
	objHelper.PATH_TO_THEME = "<?php print HELPWordpress::template_url(); ?>";
</script>
<script>
	function GateWay()
	{
		this.selectedIndex = function(){return this.gateWayCB().selectedIndex;}
		this.gateWayCB = function(){return document.getElementById("gateWayCB");}
		this.gateWayImage = function(){return document.getElementById("gateWayImage");}
		this.showGateWay = function()
		{
			switch(this.gateWayCB().selectedIndex)
			{
				case 0:
				{
					this.gateWayImage().style.display = "none"; 
					document.getElementById("gateWayForm").style.display = "none";
					paymentMethodObject.paymentMethodSelect().selectedIndex = 0;
					paymentMethodObject.paymentMethodSelect().disabled = false;
				}break;
				case 1:
				{
					this.gateWayImage().style.display = ""; 
					this.gateWayImage().src = objHelper.PATH_TO_THEME+"/images/payment/beanstream.gif";
					document.getElementById("gateWayForm").style.display = "";
					this.showCreditCardBeanStream();
					paymentMethodObject.paymentMethodSelect().selectedIndex = 1;
					paymentMethodObject.paymentMethodSelect().disabled = false;
				}break;
				case 2:
				{
					this.gateWayImage().style.display = ""; 
					this.gateWayImage().src = objHelper.PATH_TO_THEME+"/images/payment/bluepay.jpg";
					document.getElementById("gateWayForm").style.display = "";
					paymentMethodObject.paymentMethodSelect().selectedIndex = 1;
					paymentMethodObject.paymentMethodSelect().disabled = true;
					this.showCreditCardBLuePay();
				}break;
			}
			document.getElementById("gateWayINPUT").value = this.gateWayCB().options[this.selectedIndex()].text;
			paymentMethodObject.setMethod();
		}
		this.countryPaymentOptions = function(){return document.getElementById("countryPaymentOptions");}
		this.countryPaymentOptionsselectedIndex = function(){return document.getElementById("countryPaymentOptions").selectedIndex;}
		this.setCountrie = function()
		{
			document.getElementById("countryPaymentINPUT").value = this.countryPaymentOptions().options[this.countryPaymentOptionsselectedIndex()].text;
		}
		this.showCreditCardBeanStream = function()
		{
			document.getElementById("creaditCartBeanStream").style.display = "";
			document.getElementById("CCLabelsCard").style.display = "";
			document.getElementById("CCInputsCard").style.display = "";
			document.getElementById("creaditCartBluePay").style.display = "none";
		}
		this.showInteracBeanStream = function()
		{
			document.getElementById("creaditCartBeanStream").style.display = "";
			document.getElementById("CCLabelsCard").style.display = "none";
			document.getElementById("CCInputsCard").style.display = "none";
			document.getElementById("creaditCartBluePay").style.display = "none";
		}
		this.showCreditCardBLuePay = function()
		{
			document.getElementById("creaditCartBeanStream").style.display = "none";
			document.getElementById("CCLabelsCard").style.display = "none";
			document.getElementById("CCInputsCard").style.display = "none";
			document.getElementById("creaditCartBluePay").style.display = "";
		}
	}
	var objGateWay = new GateWay();
	function PaymentMethod()
	{
		this.paymentMethodSelect = function(){return document.getElementById("paymentMethodSelect");}
		this.selectedIndex = function(){return this.paymentMethodSelect().selectedIndex;}
		this.setMethod = function()
		{
			document.getElementById("paymentMethodSelectINPUT").value = this.paymentMethodSelect().options[this.selectedIndex()].text;
			if(objGateWay.selectedIndex() == 1)
			{
				if(this.selectedIndex() == 1)
				{
					objGateWay.showCreditCardBeanStream();
				}
				else if(this.selectedIndex() == 2)
				{
					objGateWay.showInteracBeanStream();
				}
			}
		}
	}
	var paymentMethodObject = new PaymentMethod();
	function shippingAndHandlingType()
	{
		this.selectedIndex = function(){return this.shipingAndHendlinkTypeOptions().selectedIndex;}
		this.shipingAndHandlinkImage = function(){return document.getElementById("shipingAndHandlinkImage");}
		this.shipingAndHendlinkTypeOptions = function(){return document.getElementById("shipingAndHendlinkTypeOptions");}
		this.showAndSetShipping = function()
		{
			switch(this.shipingAndHendlinkTypeOptions().selectedIndex)
			{
				case 0:
				{
					this.shipingAndHandlinkImage().style.display = "none"; 
				}break;
				case 1:
				{
					this.shipingAndHandlinkImage().style.display = ""; 
					this.shipingAndHandlinkImage().src = objHelper.PATH_TO_THEME+"/images/payment/ups_logo.jpg";
				}break;
				case 2:
				{
					this.shipingAndHandlinkImage().style.display = ""; 
					this.shipingAndHandlinkImage().src = objHelper.PATH_TO_THEME+"/images/payment/canadapost.gif";
				}break;
				case 3:
				{
					this.shipingAndHandlinkImage().style.display = ""; 
					this.shipingAndHandlinkImage().src = objHelper.PATH_TO_THEME+"/images/payment/canadapost.gif";
				}break;
			}
			document.getElementById("shipingAndHendlinkTypeINPUT").value = this.shipingAndHendlinkTypeOptions().options[this.selectedIndex()].text;
		}
	}
	var objSAHT = new shippingAndHandlingType();
	function Checkout()
	{
		this.formAction = objHelper.PATH_TO_THEME + "/php/tools-payment.php";
		this.SUBMIT = function()
		{
			if(objGateWay.selectedIndex()==0)
			{
				alert("Please select Payment Gateway.");
				return;
			}
			this.sendNormal();
		}
		this.sendNormal = function()
		{
			document.getElementById("formMakePayment").action = this.formAction;
			document.getElementById("formMakePayment").submit();
		}
	}
	var objCheckout = new Checkout();
</script>
<div>
<?php
	//print "orderNumber=>".$_POST["orderNumber"]."<br/>";
	XMLParser::ADD_ORDER_XML_TO_POST( $_POST["orderNumberURL"] );
	$objCheque = new Cheque( $_POST["chequeType"] );
	$objData = new ChequeData( $objCheque );
	//print_r( $_POST );
	//print "orderNumber=>".$_POST["orderNumber"]."<br/>";
?>
</div>
<div class="margin__0___AUTO width900PX colorBGWhite border_style_dotted">
<form action="" id="formMakePayment" method="post" enctype="multipart/form-data">
	<?php
    	foreach($_POST as $key => $text)
		{
			print '<input type="hidden" name="'.$key.'" value="'.$text.'" />';
		}
		$cheque = new Cheque( $_POST["chequeType"] );
		$chequeData = new ChequeData( $cheque );
	?>
	<div class="padding30px">
    	<div class="holderRightParceForm">
        	<div class="titleRightForm">Total Price</div>
            <div class="holderRightParceForm___intoForm">
                <div class="floatLEft">
                	<div class="lineTextHeight22 marginBottom2px">
                	<?php
                    	if($chequeData->quantityMoney() != "0")
						{
							?>
                            Quantity & Prices:
                            <?php
						}
					?>
					</div>
                    <div class="lineTextHeight22 marginBottom2px">
                    <?php
						if($chequeData->deliveryPrice() != 0)
						{
							?>
                            For Rush 24-48 hours Production Time:
                            <?php
						}
					?>
                    </div>
                    <div class="lineTextHeight22 marginBottom2px">
                    	Total:
                    </div>
                </div>
                <div class="floatLEft marginLeftRightForms">
                	<div class="lineTextHeight22 marginBottom2px">
                	<?php
                    	if($chequeData->quantityMoney() != "0")
						{
							print '<b>'.$chequeData->quantityMoney()."$".'</b>';
						}
					?>
					</div>
                    <div class="lineTextHeight22 marginBottom2px">
                    <?php
						if($chequeData->deliveryPrice() != 0)
						{
							print '<b>'.$chequeData->deliveryPrice()."$".'</b>';
						}
					?>
                    </div>
                    <div class="lineTextHeight22 marginBottom2px">
                    	<b><?php print $chequeData->totalPrice(); ?>$</b>
                    </div>
                </div>
                <div class="clearBoth"></div>
            </div>
			<?php
                RightForms::CREATE_INPUTS_INVISIBLE(array("totalPRICE"), array( $chequeData->totalPrice() ));
            ?>
        </div>
        <div>
            <div class="holderRightParceForm floatLEft width48Percent">
                <div class="titleRightForm">Shipping Address</div>
                <div class="holderRightParceForm___intoForm" style="height:100px;">
                	<?php
                    	if($chequeData->isShipToDifferentAddress() == true)
						{
							print '<b>'.$chequeData->anotherAddressForShiping().'</b>';
						}
						else
						{
							print '<b>'.$chequeData->CINAComapanyNameLinivche().'</b><br/>
									'.$chequeData->compInfoAddressLine1().'<br/>
									'.$chequeData->compInfoAddressLine2().'<br/>
									'.$chequeData->compInfoAddressLine3().'<br/>
									'.$chequeData->compInfoAddressLine4().'
									';
						}
					?>
                </div>
            </div>
            <div class="holderRightParceForm floatRight width48Percent marginLeft10px">
                <div class="titleRightForm">Billing Address</div>
                <div class="holderRightParceForm___intoForm" style="height:100px;">
                	<?php
                    	if($chequeData->isBillToAlternativeName() == true)
						{
							print '<b>'.$chequeData->anotherNameForBIlling().'</b>';
						}
						else
						{
							print '<b>'.$chequeData->CINAComapanyNameLinivche().'</b><br/>
									'.$chequeData->compInfoAddressLine1().'<br/>
									'.$chequeData->compInfoAddressLine2().'<br/>
									'.$chequeData->compInfoAddressLine3().'<br/>
									'.$chequeData->compInfoAddressLine4().'
									';
						}
					?>
                </div>
            </div>
            <div class="clearBoth"></div>
        </div>
        <div class="holderRightParceForm">
        	<div class="titleRightForm">
           		Payment Gateway
            </div>
            <div class="holderRightParceForm___intoForm">
            	<div class="marginBottom10px">
                    <select id="gateWayCB" onchange="objGateWay.showGateWay();">
                        <option></option>
                        <option><?php print Payment::BEANSTREAM; ?></option>
                        <option><?php print Payment::BLUEPAY; ?></option>
                    </select>
                    <br />
                    <img id="gateWayImage" style="display:none;" src="<?php print HELPWordpress::template_url(); ?>/images/payment/beanstream.gif" />
					<?php
                        RightForms::CREATE_INPUTS_INVISIBLE(array( "gateWayINPUT"), array(""));
                    ?>
                </div>
                <div id="gateWayForm" style=" display:;">
                	<?php
                    	BluePayment::PRINT_FORM();
						BeanStream::PRINT_FORM_CREDIT_CART();
					?>
                </div>
            </div>
        </div>
        <div class="holderRightParceForm">
        	<div class="titleRightForm">
           		 Payment Method
            </div>
            <div class="holderRightParceForm___intoForm">
                <select id="paymentMethodSelect" onchange="paymentMethodObject.setMethod()">
                    <option></option>
                    <option><?php print Payment::PAYMENT_METHOD_CREDIT_CARD; ?></option>
                    <option><?php print Payment::PAYMENT_METHOD_INTERAC; ?></option>
                </select>
            </div>
            <?php
				RightForms::CREATE_INPUTS_INVISIBLE(array( "paymentMethodSelectINPUT"), array(""));
			?>
        </div>
        <div class="holderRightParceForm">
        	<div class="titleRightForm">
           		 Shipping and Handling Type
            </div>
            <div class="holderRightParceForm___intoForm">
                <select id="shipingAndHendlinkTypeOptions" onchange="objSAHT.showAndSetShipping();">
                    <option></option>
                    <?php Payment::SET_SHIPPING_METHODS(); ?>
                </select>
                <br />
                <img id="shipingAndHandlinkImage" src="<?php print HELPWordpress::template_url(); ?>/images/payment/ups_logo.jpg" style="display:none;">
            </div>
            <?php
				RightForms::CREATE_INPUTS_INVISIBLE(array( "shipingAndHendlinkTypeINPUT"), array(""));
			?>
        </div>
        <div class="btnORDERCHEQUE">
            <img align="absmiddle" onclick="objCheckout.SUBMIT();" 
                src="<?php print HELPWordpress::template_url(); ?>/images/SUBMIT-ORDER-BUTTON-GREEN.png" />
        </div>
    </div>
					<?php
                        RightForms::CREATE_INPUTS_INVISIBLE(array( "payment_go"), array("Yes i will go"));
                    ?>
</form>
</div>