<?php
	require_once("php/tools.php");
?>

<!--
<form id="quick_reorder_form" action="../wp-content/themes/genesis/templates/php/tools.php" method="post" enctype="multipart/form-data">
  <input type="hidden" name="sent_email_please" />
-->
<!---->
<form id="quick_reorder_form" action="./wp-content/themes/c-t/templates/php/tools.php" method="post" enctype="multipart/form-data">
	<input type="hidden" name="sent_email_please" />

<div class="margin__0___AUTO colorBGWhite width500PX paddingTop20px" style="">
	<div class="padding25px">
    	<div style="padding-bottom:15px; color:#900; font-size:16px; font-weight:bold;">
        	EXPRESS RE-ORDER FORM
        </div>
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
                <select id="" class="width100Percent validate[required]" name="provincies" >
                    <option>Provinces</option>
                    <?php
                        //HELPWordpress::PRIN_ALL_CANADA_PROVINCIES_OPTIONS();
						$all_provines = DB_DETAILS::ADD_ACTION("SELECT * FROM canada_provincies ORDER BY abv", 
												DB_DETAILS::$TYPE_SELECT);
						for($i=0;$i<count($all_provines);$i++)
						{
							?>
                            <option value="<?php print $all_provines[$i]["abv"]; ?>"><?php print $all_provines[$i]["abv"]; ?></option>
                            <?php
						}
                    ?>
                    <!--<option>States</option>-->
                    <?php
                       //HELPWordpress::PRIN_ALL_USA_STATES_OPTIONS();
                    ?>
                </select>
            </div>
            <div class="clearBoth"></div>
        </div>
        <div class="marginBottom10px">
            <div class="floatLEft width180px">
            	Cheque Type
            </div>
            <div class="floatLEft">
                <input type="radio" name="cheque_type" checked="checked" value="Manual Cheques" />Manual Cheques
                <input type="radio" name="cheque_type" value="Laser Cheques" />Laser Cheques
            </div>
            <div class="clearBoth"></div>
        </div>
        <div class="marginBottom10px">
            <div class="floatLEft width180px">
                Previous Order#
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
                <span><input type="radio" name="i_will_scan_or_fax" value="Yes" />Yes</span>
                <span class="paddingLeft50px"><input name="i_will_scan_or_fax" type="radio" value="No" />No</span>
                <input type="radio" checked="checked" name="i_will_scan_or_fax" value="not selected" class="displayNone" />
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
                <textarea style="height:100px;" id="notes_text_area" name="notes_text_area"></textarea>
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
                    	<input type="radio" name="payment_method_cb_group" value="credit_card" checked="checked" />Credit Card(Visa/MC)
                    </div>
                    <div class="floatLEft marginLeft10px">
                    	<input type="radio" class="visibilityHidden" />Expiry
                    </div>
            		<div class="clearBoth"></div>
                    <div class="floatLEft">
                		<input type="text" name="credit_card_number" />
                    </div>
                    <div class="floatLEft marginLeft10px">
                		<input type="text" class="width40px" name="expire_credit_card" />
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