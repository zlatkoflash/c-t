<?php
	
?>

<form id="quick_reorder_form" action="./wp-content/themes/c-t/templates/php/tools.php" method="post" enctype="multipart/form-data">
<div class="margin__0___AUTO colorBGWhite width500PX paddingTop20px" style="">
	<div class="padding25px">
        <div class="marginBottom10px">
            <div class="floatLEft width180px">
                Name*
            </div>
            <div class="floatLEft">
                <input type="text" name="name" class="validate[required]" />
            </div>
            <div class="clearBoth"></div>
        </div>
        <div class="marginBottom10px">
            <div class="floatLEft width180px">
                Company
            </div>
            <div class="floatLEft">
                <input type="text" name="company" />
            </div>
            <div class="clearBoth"></div>
        </div>
        <div class="marginBottom10px">
            <div class="floatLEft width180px">
                Phone*
            </div>
            <div class="floatLEft">
                <input type="text" class="validate[required]" name="phone" />
            </div>
            <div class="clearBoth"></div>
        </div>
        <div class="marginBottom10px">
            <div class="floatLEft width180px">
                E-mail*
            </div>
            <div class="floatLEft">
                <input type="text" class="validate[required]" name="email" />
            </div>
            <div class="clearBoth"></div>
        </div>
        <div class="marginBottom10px">
            <div class="floatLEft width180px">
                Province*
            </div>
            <div class="floatLEft">
                <select id="" class="width100Percent validate[required]" >
                    <option>Provinces</option>
                    <?php
                        //HELPWordpress::PRIN_ALL_CANADA_PROVINCIES_OPTIONS();
                    ?>
                    <option>States</option>
                    <?php
                       //HELPWordpress::PRIN_ALL_USA_STATES_OPTIONS();
                    ?>
                </select>
            </div>
            <div class="clearBoth"></div>
        </div>
        <div class="marginBottom10px">
            <div class="floatLEft width180px">
                Previus Order#
            </div>
            <div class="floatLEft">
                <input type="text" name="previus_order" />
            </div>
            <div class="clearBoth"></div>
        </div>
        <div class="marginBottom10px">
            <div class="floatLEft width180px">
                Attach Cheque Copy
            </div>
            <div class="floatLEft">
                <input type="file" name="logo_for_attachment" />
            </div>
            <div class="clearBoth"></div>
        </div>
        <div class="marginBottom10px">
            <div class="floatLEft width180px">
                I will scan/fax copy(optional)
            </div>
            <div class="floatLEft">
                <span><input type="radio" name="scan_fax_copy_yes_no" />Yes</span>
                <span class="paddingLeft50px"><input type="radio" name="scan_fax_copy_yes_no" />No</span>
            </div>
            <div class="clearBoth"></div>
        </div>
        <div class="marginBottom10px">
            <div class="floatLEft width180px">
                Start#*
            </div>
            <div class="floatLEft">
                <input type="text" class="validate[required]"  name="start_number" />
            </div>
            <div class="clearBoth"></div>
        </div>
        <div class="marginBottom10px">
            <div class="floatLEft width180px">
                Notes
            </div>
            <div class="floatLEft">
                <textarea style="height:100px;" id="notes_text_area"></textarea>
                <input type="hidden" name="notes" />
            </div>
            <div class="clearBoth"></div>
        </div>
        <div class="marginBottom10px">
            <div class="floatLEft width180px">
                Payment Method*
            </div>
            <div class="floatLEft">
            	<div>
                    <div class="floatLEft">
                    	<input type="radio" name="payment_method_cb_group" value="credit_card" />Credit Card(Visa/MC)
                    </div>
                    <div class="floatLEft marginLeft50px">
                    	<input type="radio" class="visibilityHidden" />Expiry
                    </div>
            		<div class="clearBoth"></div>
                    <div class="floatLEft">
                		<input type="text" />
                    </div>
                    <div class="floatLEft marginLeft10px">
                		<input type="text" class="width40px" />
                    </div>
            		<div class="clearBoth"></div>
                </div>
                <div>
                	<input type="radio" name="payment_method_cb_group" value="call_me" /> Call me for my credit card information
                </div>
                <div>
                	<input type="radio" name="payment_method_cb_group" value="debit" /> Debit my account
                </div>
                <div>
                	<input type="radio" name="payment_method_cb_group" value="other" /> (other)Please call me
                </div>
            </div>
            <div class="clearBoth"></div>
        </div>
        <div class="marginBottom10px">
            <div class="floatLEft width180px">
                <input type="submit" />
            </div>
            <div class="floatLEft">
                We will call you to confirm order details - Thank you!
            </div>
            <div class="clearBoth"></div>
        </div>
    </div>
</div>
</form>

<script>
	$(document).ready(function(e) 
	{
    	$("#quick_reorder_form").validationEngine();	    
    });
</script>