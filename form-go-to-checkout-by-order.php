<form method="post" enctype="multipart/form-data" action="" id="formActionToCheckOut">
    <input type="hidden" value="" id="orderNumber" name="orderNumber" />
    <input type="hidden" value="" id="orderNumberURL" name="orderNumberURL" />
</form>
<script>
	function FormGoToCheckOutByOrder()
	{
		this.SEND = function(orderNumber)
		{
			document.getElementById("orderNumber").value = orderNumber;
			document.getElementById("orderNumberURL").value = 
			objHelper.PATH_TO_THEME+"/php/orders/"+orderNumber+".xml";
			document.getElementById("formActionToCheckOut").action = "<?php print SETTINGS::URL_TO_CHECKOUT_PAGE; ?>";
			document.getElementById("formActionToCheckOut").submit();
		}
	}
	var FGTCOBO = new FormGoToCheckOutByOrder();
</script>