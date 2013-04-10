<?php require_once("php/tools-payment.php"); ?>
<?php
	$objPayStatus = new PaymentTransactionStatus();
?>


<div class="margin__0___AUTO width900PX  colorBGWhite border_style_dotted">
	<div class="" style="">
    	<div class="titleRightForm">Transaction status: <b><?php print $objPayStatus->statusLabel(); ?></b></div>
        <div class="holderRightParceForm___intoForm">
            <div class="floatLEft">
                <div class="lineTextHeight22 marginBottom2px">Payment Gateway:</div>
                <div class="lineTextHeight22 marginBottom2px">Payment Method:</div>
                <div class="lineTextHeight22 marginBottom2px">Shipping and Handling Type:</div>
            </div>
            <div class="floatLEft marginLeftRightForms">
                <div class="lineTextHeight22 marginBottom2px"><?php print $objPayStatus->gatewayType; ?></div>
                <div class="lineTextHeight22 marginBottom2px"><?php print $objPayStatus->paymentMethod; ?></div>
                <div class="lineTextHeight22 marginBottom2px"><?php print $objPayStatus->shippingAndHandling; ?></div>
            </div>
            <div class="clearBoth"></div>
            <div class="lineTextHeight22 marginBottom2px">Status Message:</div>
            <div class="lineTextHeight22 marginBottom2px"><b><?php print $objPayStatus->statusMessage; ?></b></div>
            <div>
            	<input type="button" value="Go Back to Checkout Order" onClick="FGTCOBO.SEND('<?php print $objPayStatus->orderNumber; ?>')">
            </div>
            <?php require_once("form-go-to-checkout-by-order.php"); ?>
        </div>
    </div>
</div>