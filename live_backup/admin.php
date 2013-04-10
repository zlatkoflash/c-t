<?php

if(!class_exists("SETTINGS"))
{
	require_once("php/settings.php");
}
if(!class_exists("DB_DETAILS"))
{
	require_once('php/db_details.php');
}
if(!class_exists("XMLParser"))
{
	require_once('php/tools.php');
}
if(!class_exists("SearchOrders"))
{
	require_once('search.php');
}

class Admin
{
	/*
	private static function FOLDER_ORDERS()
	{
		return "orders/";//for testing
		if(strpos($_POST["fso_order_number"], "M") === false)
		{
			return "../orders/laser_orders/";
		}
		else
		{
			return "../orders/manual_orders/";
		}
	}
	*/
	private static function ORDER_PATH()
	{
		return SETTINGS::ORDERS_FOLDER_FOR_XML___ADMIN_SECTION.$_POST["fso_order_number"].".xml";
	}
	private static function showLoginForm()
	{
		?>
        	<form action="<?php print SETTINGS::URL_TO_ADMIN_PAGE; ?>" id="form_submit_login" method="post" enctype="multipart/form-data">
            	<input type="hidden" name="fst_try_to_login" value="yes" />
            	<div class="marginBottom10px">
                	User Name:<br />
                    <input type="text" name="fsl_username" id="fsl_username" class=""  />
                </div>
            	<div class="marginBottom10px">
                	Password:<br />
                    <input type="password" name="fsl_password" id="fsl_password" class="" />
                </div>
                <div>
                	<input type="submit" value="Login" />
                </div>
            </form>
        <?php
	}
	private static function showSubMitOrderForm()
	{
		if(isset($_POST["order_not_exists"]))
		{
			?>
            	<div class="marginBottom10px colorRED">
                	Order <b><?php print $_POST["orderThatNotExist"]; ?></b> not exist.
                </div>
            <?php
		}
		?>
        	<form action="<?php print SETTINGS::URL_TO_ADMIN_PAGE; ?>" id="form_submit_order" method="post" enctype="multipart/form-data">
            	<input type="hidden" name="user_is_logged" value="yes" />
                <input type="hidden" name="show_editing_form" value="yes" />
            	<div class="marginBottom10px">
                	Enter Order Number:
                    <div>
                    	<input type="text" name="fso_order_number" id="fso_order_number" class="width400px"  />
                        <input type="submit" value="Open" class="floatRight" />
                    </div>
                    
                </div>
                <div>
                	
                </div>
            </form>
        <?php
	}
	private static function showEditForm()
	{
		if(isset($_POST["IS_FOR_SEARCH_FORM"]))
		{
			Admin::showSubMitOrderForm();
			SearchOrders::showSearchForm();
		}
		else if(!file_exists(Admin::ORDER_PATH()))
		{
			?>
            	<form action="<?php print SETTINGS::URL_TO_ADMIN_PAGE; ?>" id="form_order_not_exists" method="post" enctype="multipart/form-data">
                    <input type="hidden" name="user_is_logged" value="yes" />
                	<input type="hidden" name="order_not_exists" />
                    <input type="hidden" name="orderThatNotExist" value="<?php print $_POST["fso_order_number"]; ?>" />
                </form>
                <script>
                	document.getElementById("form_order_not_exists").submit();
                </script>
            <?php
		}
		else
		{
			XMLParser::ADD_ORDER_XML_TO_POST( Admin::ORDER_PATH(), false);
			
			$counter=0;
			foreach(XMLParser::$VARIABLES as $variable=>$value)
			{
				if(strpos($variable, "#") === false)
				{
                     $_POST[$variable] = $value;
				}
			}
		}
	}
	public static function ADD_VALUES_TO_INPUTS()
	{
		?>
			<script>
		<?php
		foreach($_POST as $variable=>$value)
		{
			if($variable != "CIQuestionsAndCommentsTA" && $variable != "CIQuestionsAndComments")
			{
				?>
						if(document.getElementById("<?php print $variable; ?>") != null)
						{
							document.getElementById("<?php print $variable; ?>").value = "<?php print $value; ?>";
						}
				<?php
			}
			else if($variable == "CIQuestionsAndCommentsTA")
			{
				?>
				/**/
					var tekstFor = "";
					try
					{
						<?php
						$allLines = explode( "\n", $_POST["CIQuestionsAndComments"] );
						$newText = "";
						for($i=0;$i<count($allLines);$i++)
						{
							if($i>0)$newText .= "[new line]";
							$newText .= $allLines[$i];
						}
							
						?>
						tekstFor = "<?php print $newText; ?>";
						tekstFor = HELPER.H.text_single_line_to_multi_line(tekstFor);
					}
					catch(err)
					{
					}
					document.getElementById("CIQuestionsAndCommentsTA").value = tekstFor;
					
				<?php
			}
		}
		?>
		</script>
		
			<script>
				HELPER.H.setupComboBoxByIndex("compInfoQuantity", "<?php print $_POST["quantityINPUTIndex"] ?>");
				ChequeColor.CH.change(<?php print $_POST["backgroundINdex"] ?>);
				<?php if(isset($_POST["chequePosition"]) && $_POST["chequeType"]==Cheque::TYPE_LASER)
					{ ?>
					if(Cheque.C.type == Cheque.LASER)
					{
						ChequePosition.CP.arrEventsAfterChanging.push(
													function ()
													{
														document.getElementById("chequeBgPositionsAdditionalInfo").innerHTML = 
																		"Background position <b>"+ChequePosition.CP.positionName()+"</b>";
													});
						
					}
					ChequePosition.CP.changePosition("<?php print $_POST["chequePosition"]; ?>");
				<?php 
					}
					else if(isset($_POST["chequePosition"]) && $_POST["chequeType"]==Cheque::TYPE_MANUAL)
					{
						?>
						ChequePosition.CP.setupCBs1OR2ChequesPerManual("<?php print $_POST["chequePosition"]; ?>");
						<?php
					}
				?>
				
				if(document.getElementById("comInfoIsSecondCompanyName").value != ""){document.getElementById("compInfoCBShowSecondLine").checked = true;}
				if(document.getElementById("CILogoType").value == "0")
				{
					document.getElementById("compInfoAttachLogo_1").checked = true;
					objCompanyInfo.CBLogoOnClick( document.getElementById("compInfoAttachLogo_1") );
				}
				else if(document.getElementById("CILogoType").value == "1")
				{
					document.getElementById("compInfoAttachLogo_2").checked = true;
					objCompanyInfo.CBLogoOnClick( document.getElementById("compInfoAttachLogo_2") );
				}
				if(document.getElementById("isCurrencyINPUT").value == "true"){document.getElementById("compInfoCBUSFunds").checked=true;}
				if(document.getElementById("add45AfterAcountNumberInput").value == "true")
				{
					document.getElementById("compInfoAdd45AfterAccount").checked=true;
				}
				if(document.getElementById("compInfoSoftware") != null)
				{
					<?php
						if(!isset($_POST["softwareINPUTIndex"])){$_POST["softwareINPUTIndex"]="0";}
					?>
					document.getElementById("compInfoSoftware").selectedIndex = <?php print $_POST["softwareINPUTIndex"]; ?>;
					<?php
						if(isset($_POST["compInfoEnterOtherSoftware"]))
						{
							?>
							document.getElementById("compInfoSoftware").selectedIndex = 8;
							<?php
						}
					?>
					CompanyInfo.CI.onSowtaferSELECTChanging();
					<?php
						if(isset($_POST["compInfoEnterOtherSoftware"]))
						{
							?>
								document.getElementById("compInfoEnterOtherSoftware").value = 
											"<?php print $_POST["compInfoEnterOtherSoftware"]; ?>";
							<?php
						}
					?>
				}
				<?php
					if(isset($_POST["compInfoClientSupplier"]))
					{
						?>
						document.getElementById("compInfoIncludeEnvelopes").checked=true;
						CompanyInfo.CI.CBDWEOnClick();
						document.getElementById("compInfoClientSupplier").value = "<?php print $_POST["compInfoClientSupplier"]; ?>";
						<?php
					}
				?>
				document.getElementById("compInfoSecondSignatur").checked=false;
				document.getElementById("compInfoShowStartNumber").checked = true;
				if(document.getElementById("isThereSecondSignature").value=="true"){document.getElementById("compInfoSecondSignatur").checked=true;}
				if(document.getElementById("compInfoStartAtTrueOrFalse").value=="false"){document.getElementById("compInfoShowStartNumber").checked=false;}
				<?php
					if(isset($_POST["boxingType"]))
					{
						?>
							CompanyInfo.CI.selectCBByBoxingTypeText("<?php print $_POST["boxingType"]; ?>");
						<?php
					}
				?>
				<?php
					if(isset($_POST["depositBooksINPUT"]))
					{
						?>
							HELPER.H.setupComboBoxByText("compInfoDepositBooks","<?php print $_POST["depositBooksINPUT"]; ?>");
						<?php
					}
					if(isset($_POST["DWEINPUT"]))
					{
						?>
							HELPER.H.setupComboBoxByText("compInfoDWE","<?php print $_POST["DWEINPUT"]; ?>");
						<?php
					}
					if(isset($_POST["SSDWEINPUT"]))
					{
						?>
							HELPER.H.setupComboBoxByText("compInfoSSDWE","<?php print $_POST["SSDWEINPUT"]; ?>");
						<?php
					}
					if(isset($_POST["chequeBinderINPUT"]))
					{
						?>
							HELPER.H.setupComboBoxByText("compInfoChequeBinder","<?php print $_POST["chequeBinderINPUT"]; ?>");
						<?php
					}
					if(isset($_POST["SelfLinkStampINPUT"]))
					{
						?>
							HELPER.H.setupComboBoxByText("compInfoSelfLinkingStamp","<?php print $_POST["SelfLinkStampINPUT"]; ?>");
						<?php
					}
					if(isset($_POST["deliveryINPUT"]))
					{
						?>
							if(document.getElementById("deliveryINPUT").value=="Standard 5-7 bus days")
							{
								document.getElementById("delivery_5_7_days").checked=true;
								document.getElementById("delivery_24_48_days").checked=false;
							}
							else if(document.getElementById("deliveryINPUT").value=="Rush 24-48 hours($25 Charge)")
							{
								document.getElementById("delivery_5_7_days").checked=false;
								document.getElementById("delivery_24_48_days").checked=true;
							}
						<?php
					}
				?>	
				document.getElementById("BSCombo_"+BillingShipingModerator.BSM.TYPE_BILLING).checked = true;
				CompanyInfo.CI.comboShowShippingBilling( BillingShipingModerator.BSM.TYPE_BILLING );
				document.getElementById("BSCombo_"+BillingShipingModerator.BSM.TYPE_SHIPING).checked = true;
				CompanyInfo.CI.comboShowShippingBilling( BillingShipingModerator.BSM.TYPE_SHIPING );
				
				HELPER.H.setupComboBoxByText("CBProvince_TYPE_BILLING","<?php print $_POST["province_TYPE_BILLING"]; ?>");
				HELPER.H.setupComboBoxByText("CBProvince_TYPE_SHIPING","<?php print $_POST["province_TYPE_SHIPING"]; ?>");
				/*
				if(document.getElementById("SameAsBillingDetails").value=="true")
				{
					document.getElementById("cbDoShippingSameAsBilling").checked=true;
					BillingShipingModerator.BSM.setupINputsShipingEnabledDisabled();
				}
				*/
				if(document.getElementById("residentialAddressBSM").value=="true")
				{
					document.getElementById("residentialAddressBSMid").checked=true;
				}
				if(document.getElementById("noSignatureRequiredBSM").value=="true")
				{
					document.getElementById("noSignatureRequiredBSMid").checked=true;
				}
				if(document.getElementById("mopINPUT").value=="Visa")
				{
					document.getElementById("MOP_Visa").checked=true;
					document.getElementById("MOP_Mastercart").checked=false;
				}
				else if(document.getElementById("mopINPUT").value == "Direct Debit")
				{
					document.getElementById("MOP_directDebit").checked=true;
					$("#MOP_directDebit_signatureDIVHolder").removeClass( "displayNone" );
				}
				else if(document.getElementById("mopINPUT").value=="Mastercard")
				{
					document.getElementById("MOP_Visa").checked=false;
					document.getElementById("MOP_Mastercart").checked=true;
				}
				objMOP.setVariablesForMOP();
				HELPER.H.setupComboBoxByText("MOP_expMonth","<?php print $_POST["mopExpirtyMonthINPUT"]; ?>");
				HELPER.H.setupComboBoxByText("MOP_expYear","<?php print $_POST["mopExpirtyYearINPUT"]; ?>");
				if(document.getElementById("mopCallMe").value=="I do not like to call me.")
				{
					document.getElementById("MOP_pleaseCallMe").checked = false;
				}
				else if(document.getElementById("mopCallMe").value=="Please call me for my Credit Card Number.")
				{
					document.getElementById("MOP_pleaseCallMe").checked = true;
				}
				objMOP.setVariablesForMOP();
				OrderTotalAmount.OTA.calculate();
            </script>
		<?php
	}
	public function update_order()
	{
		?>
        	<div class="marginBottom10px">           
            	Order <b><?php print OrdersDatabase::GET_ORDER_POWER( $_POST["fso_order_number"] ); ?></b> is updated.
            </div>
            <div class="marginBottom10px">
            	<form action="<?php print SETTINGS::URL_TO_ADMIN_PAGE; ?>" method="post" enctype="multipart/form-data">
                	<input type="submit" value="Edit order <?php print OrdersDatabase::GET_ORDER_POWER( $_POST["fso_order_number"] ); ?> " />
                    <input type="hidden" name="user_is_logged" value="yes" />
                	<input type="hidden" name="show_editing_form" value="true" />
                    <input type="hidden" name="fso_order_number" value="<?php print $_POST["fso_order_number"]; ?>" />
                </form>
            </div>
            <div>
                <form action="<?php print SETTINGS::URL_TO_ADMIN_PAGE; ?>" method="post" enctype="multipart/form-data">
                	<input type="hidden" name="user_is_logged" value="yes" />
                	<input type="submit" value="Edit another order" />
                </form>
            </div>
        <?php
	}
	public function tryToLogin()
	{
		$rows = DB_DETAILS::ADD_ACTION("SELECT * FROM users_admin WHERE 
														username='".$_POST["fsl_username"]."' AND 
														password='".$_POST["fsl_password"]."'",
									DB_DETAILS::$TYPE_SELECT);
		if(count($rows) == 0)
		{
			return false;
		}
		else
		{
			return true;
		}
	}
	
	public function Admin()
	{
		?>
        	<div id="adminSimpleUpdateForm" class="margin__0___AUTO width500PX borderGrayDotted colorBGWhite padding30px" style="">
        <?php
		if(isset($_POST["fst_try_to_login"]))
		{
			if(Admin::tryToLogin() == true)
			{
				$_POST["user_is_logged"] = "true";
			}
		}
		if(!isset( $_POST["user_is_logged"] ))
		{
			Admin::showLoginForm();
		}
		else if(isset($_POST["after_update_order_please"]))
		{
			Admin::update_order();
		}
		else if(!isset($_POST["show_editing_form"]))
		{
			Admin::showSubMitOrderForm();
			SearchOrders::showSearchForm();
		}
		else if(isset($_POST["show_editing_form"]))
		{
			Admin::showEditForm();
		}
		?>
            </div>
        <?php
	}
	public static function SHOW_EDITING_FORM($cheque, $RightFObject)
	{
			?>
				<script>
					document.getElementById("adminSimpleUpdateForm").style.display = "none";
					objHelper.URL = "<?php print HELPWordpress::url(); ?>";
					objCheque.setType("<?php print $cheque->type; ?>");
					Cheque.IS_FOR_ADMIN=true;
				</script>
				<div class="margin__0___AUTO width300px borderGrayDotted colorBGWhite padding30px" style="">
					
                    <form id="form" action="#" enctype="multipart/form-data" method="post">
                        <input type="hidden" name="user_is_logged" value="yes" />
                        <input type="hidden" name="update_order_please" value="true" />
                        <input type="hidden" id="fso_order_number" name="fso_order_number" value="<?php print $_POST["fso_order_number"]; ?>" />
                        <input type="hidden" id="fso_admin_submit_additions" name="fso_admin_submit_additions" value="0,0,0" />
                        <input type="hidden" id="setupNewVariable" name="setupNewVariable" value="false" />
                        <div class="marginBottom10px">
                            <div>
                                <input type="checkbox" id="cb_update_current_order" onclick="OrderNumber.ON.setupOrderForAdmin__newOrderYesOrNO(false);" checked="checked" />Update Current Order <b><?php 
								//print $_POST["fso_order_number"]; 
								print OrdersDatabase::GET_ORDER_POWER( $_POST["fso_order_number"] );
								?></b>
                            </div>
                            <div>
                                <input type="checkbox" id="cb_create_new_order" onclick="OrderNumber.ON.setupOrderForAdmin__newOrderYesOrNO(true);" />Create New Order
                            </div>
                            <br />
                            <div>
                                <b>Send to PrintNow Email Below</b><br />
                                <div>
                                	<div class="floatLEft">
                                    	<input type="checkbox" id="cbSendToPrintNowEmail" onclick="SubmitAdminAdditions.SAA.setupAdditions()" />
                                    </div>
                                	<div class="floatLEft">
                                        <select id="cbEmailForSenrPrintNowOrder" onchange="SubmitAdminAdditions.SAA.setupEmailForPrintNow();">
                                            <option>jon@printnow.ca</option>
                                            <option>rene@printnow.ca</option>
                                            <option>ryan@printnow.ca</option>
                                            <option>hugues@printnow.ca</option>
                                            <option>derekprintnow@gmail.com</option>
                                            <option selected="selected">orders@printnow.ca</option>
                                            <option>tom@printnow.ca</option>
                                            <option>other</option>
                                        </select>
                                        <div id="sendToPrintNowEmailHolder" class="displayNone">
                                        	<input style="width:150px;" class="width" type="text" name="sendToPrintNowEmail" id="sendToPrintNowEmail"
                                                           value="orders@printnow.ca" />
                                        </div>
                                    </div>
                                	<div class="clearBoth"></div>
                                </div>
                            </div>
                            <br />
                            <div>
                                <input type="checkbox" id="cbSentEmailToCustomer" onclick="SubmitAdminAdditions.SAA.setupAdditions()" /><b>Send email to customer</b><br />
                                <input type="checkbox" id="cbSentSEcondEmailToCustomer" onclick="SubmitAdminAdditions.SAA.setupAdditions()" />
                                <input id="admin_second_email_for_customer" name="admin_second_email_for_customer" 
                                                type="text" class="inputOnFocusInOut" value="2d email for customer" />
                                <script>
                                    $("#admin_second_email_for_customer").attr("value_default", "2d email for customer");
                                </script>
                            </div>
                            <script>
                                function OrderNumber()
                                {
                                    this.fso_order_number = "";
                                    this.setupOrderForAdmin__newOrderYesOrNO = function(setupNew)
                                    {
                                        if(setupNew==true && $("#cb_create_new_order").prop("checked")==true)
                                        {
                                            this.fso_order_number = document.getElementById("fso_order_number").value;
                                            document.getElementById("fso_order_number").value = this.fso_order_number;
											document.getElementById("setupNewVariable").value = "true";
                                            $("#cb_update_current_order").attr("checked", false);
                                            SentEmail.SE.additionalMessageWhenSubMit = "Create New Order?";
                                        }
                                        else
                                        {
                                            document.getElementById("fso_order_number").value = this.fso_order_number;
                                            $("#cb_create_new_order").attr("checked", false);
											document.getElementById("setupNewVariable").value = "false";
                                            SentEmail.SE.additionalMessageWhenSubMit = "Update Current Order #<?php print OrdersDatabase::GET_ORDER_POWER($_POST["fso_order_number"]); ?>?";
                                        }
                                    }
                                }
                                OrderNumber.ON = new OrderNumber();
								function SubmitAdminAdditions()
								{
									this.setupAdditions = function()
									{
										document.getElementById("fso_admin_submit_additions").value = 
										this.sentToPrintNow()+","+this.sentEmailToCustomer()+","+this.sentToSecondEmailToCustomer();
									}
									this.sentToPrintNow = function()
									{
										if($("#cbSendToPrintNowEmail").prop("checked") == true){return "1";}
										return "0";
									}
									this.sentEmailToCustomer = function()
									{
										if($("#cbSentEmailToCustomer").prop("checked") == true){return "1";}
										return "0";
									}
									this.sentToSecondEmailToCustomer = function()
									{
										if($("#cbSentSEcondEmailToCustomer").prop("checked") == true){return "1";}
										return "0";
									}
									this.setupEmailForPrintNow = function()
									{
										var emailSelected = document.getElementById("cbEmailForSenrPrintNowOrder").options;
										emailSelected = emailSelected[document.getElementById("cbEmailForSenrPrintNowOrder").selectedIndex];
										emailSelected = emailSelected.text;
										if(emailSelected == "other")
										{
											document.getElementById("sendToPrintNowEmail").value = "";
											$("#sendToPrintNowEmailHolder").removeClass("displayNone");
										}
										else
										{
											document.getElementById("sendToPrintNowEmail").value = emailSelected;
											$("#sendToPrintNowEmailHolder").addClass("displayNone");
										}
									}
								}
								SubmitAdminAdditions.SAA = new SubmitAdminAdditions();
                                SentEmail.SE.additionalMessageWhenSubMit = "Update Current Order #<?php print OrdersDatabase::GET_ORDER_POWER($_POST["fso_order_number"]); ?>?";
                            </script>
                        </div>
                        <?php $RightFObject->showMe(); ?>	
                    </form>
				</div>
			<?php
			Admin::ADD_VALUES_TO_INPUTS();
			?>            
			<script>
                document.getElementById("sendPDFandEmail").value = "FOR_ADMIN";
				ChequeColor.CH.arrayEventsAfterChanging.push( function ()
												{
													document.getElementById("chequeColorsAdditionalInfo").innerHTML = "Selected Color <b>"+ChequeColor.CH.pictureColor()+"</b>";
												} );
				ChequeColor.CH.change( <?php print $_POST["backgroundINdex"];  ?> );
				$(".inputOnFocusInOut").focus(function()
				{
					if($(this).attr("value") == $(this).attr("value_default"))
					{
						$(this).attr("value", "");
						$(this).css("color", "#000000");
					}
				});
				$(".inputOnFocusInOut").focusout(function()
				{
					if($(this).attr("value") == "")
					{
						$(this).attr("value", $(this).attr("value_default"));
						$(this).css("color", "#999");
					}
				});
            </script>
            <?php
	}
}

$admin = new Admin();

?>