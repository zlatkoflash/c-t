<?php
	
	class RightForms
	{
		public static $RF=NULL;
		var $cheque;
		
		public function RightForms($cheque___)
		{
			$this->cheque = $cheque___;
			self::$RF = $this;
		}
		public function showMe()
		{
			$this->draw_ContactInfo();
			$this->draw_Quantity_and_Prices();
			$this->draw_LaserChequePositions();
			$this->draw_ChequeColors();
			$this->draw_CompanyInfo();
			$this->draw_delivery();
			$this->BillingShipingDetails(self::TYPE_BILLING);
			$this->BillingShipingDetails(self::TYPE_SHIPING);
			$this->draw_methodOfPayment();
			$this->draw_airmilesRewardMiles();
			$this->draw_totalAmount();
			$this->draw_SubmitOrderBTN();
			//RightForms::CREATE_INPUTS_INVISIBLE( array("save_order", "chequeType"), array("Yes i will save order", $cheque->type) );
			RightForms::CREATE_INPUTS_INVISIBLE( array("sendPDFandEmail", "chequeType"), array("SEND_EMAIL", $this->cheque->type));
		}
		function draw_ContactInfo()
		{
			?>
            	<div class="holderRightParceForm">
                	<div class="titleRightForm">Contact Info</div>
                    <div class="holderRightParceForm___intoForm">
                    	<div class="floatLEft">
                        	<div class="lineTextHeight22 marginBottom2px">Company Name:</div>
                        	<div class="lineTextHeight22 marginBottom2px">Contact Name*:</div>
                            <div class="lineTextHeight22 marginBottom2px">Phone*:</div>
                            <div class="lineTextHeight22 marginBottom2px">Email*:</div>
                        </div>
                        <div class="floatLEft marginLeftRightForms">
                        	<div class="lineTextHeight22 marginBottom2px"><input 
                            													onkeyup="BillingShipingModerator.BSM.setupBillingIinfoContactFromTopContact();" 
                    															type=text id="CICompanyName" name="CICompanyName" /></div>
                            <div class="lineTextHeight22 marginBottom2px"><input 
                            													onkeyup="BillingShipingModerator.BSM.setupBillingIinfoContactFromTopContact();" 
                    															type=text id="CIContactName" name="CIContactName" /></div>
                            <div class="lineTextHeight22 marginBottom2px"><input 
                            													onkeyup="BillingShipingModerator.BSM.setupBillingIinfoContactFromTopContact();" 
                    															type=text id="CIPhone" name="CIPhone" /></div>
                            <div class="lineTextHeight22 marginBottom2px"><input 
                            													onkeyup="BillingShipingModerator.BSM.setupBillingIinfoContactFromTopContact();" 
                    															type=text id="CIEmail" name="CIEmail" /></div>
                        </div>
                    	<div class="clearBoth"></div>
                        <div>Question / Comments</div>
                        <div>
                        	<textarea id="CIQuestionsAndCommentsTA" name="CIQuestionsAndCommentsTA" onchange="objContactInfo.CIQuestionsAndCommentsSet();" style="height:100px; width:230px;" ></textarea>
                        </div>
                    </div>
                    <div class="clearBoth"></div>
                </div>
            <?php
			RightForms::CREATE_INPUTS_INVISIBLE(array( "CIQuestionsAndComments"), array(""));
		}
		function draw_Quantity_and_Prices()
		{
			?>
            	<div class="holderRightParceForm">
                	<div class="titleRightForm">Quantity & Prices</div>
                    <div class="holderRightParceForm___intoForm alignCenter">
                    	<div>
                        	<select  style="width:100%;"  id="compInfoQuantity" name="compInfoQuantity" onChange="objQuantity_and_PRices.setQuantity();OrderTotalAmount.OTA.calculate();" >
                            <!--
                                <option>Select Pricing & Quantity</option>
                                <?php if($this->cheque->type == Cheque::TYPE_LASER){?>
                                <option>50 + 15 FREE $98</option>
                                <option>100 + 25 FREE $114</option>
                                <option>250 + 75 FREE $149</option>
                                <option>500 + 125 FREE $194</option>
                                <option>1000 + 250 FREE $283</option>
                                <option>2000 + 500 FREE $434</option>
                                <option>3000 + 750 FREE $536</option>
                                <option>4000 + 1000 FREE $650</option>
                                <option>5000 + 1250 FREE $718</option>
                                <option>Duplicates 250 + 75 FREE $213</option>
                                <option>Duplicates 500 + 125 FREE $275</option>
                                <option>Duplicates 1000 + 250 FREE $479</option>
                                <option>Duplicates 2000 + 500 FREE $691</option>
                                <option>Duplicates 3000 + 750 FREE $870</option>
                                <option>Duplicates 4000 + 1000 FREE $1027</option>
                                <option>Duplicates 5000 + 1250 FREE $1166</option>
                                <option>LARGER QUANTITIES AVAILABLE CALL FOR PRICING</option>
                                <option>NO CHEQUES NEEDED</option>
                                <?php } ?>
                                <?php if($this->cheque->type == Cheque::TYPE_MANUAL){?>
								<option>50 + 25 Free $73</option>
                                <option>100 + 50 Free $89</option>
								<option>200 + 100 Free $109</option>
								<option>400 + 200 Free $128</option>
								<option>600 + 300 Free $144</option>
								<option>1200 + 600 Free $221</option>
								<option>2400 + 1200 Free $295</option>
								<option>3600 + 1800 Free $369</option>
								<option>200 Duplicates 2 per page $115</option>
                                <option>400+100 Free Duplicates $136</option>	
                                <option>NO CHEQUES NEEDED</option>
								<?php } ?>
                                -->
                            </select>
                            <script>
                            	Quantity_and_Prices.QP.addQuantintyOptions("<?php print $this->cheque->type; ?>");
                            </script>
                        </div>
                    </div>
                    <div class="clearBoth"></div>
                </div>
            <?php
			RightForms::CREATE_INPUTS_INVISIBLE(array( "quantityINPUT", "quantityINPUTIndex"), array("", "0"));
		}
		function draw_ChequeColors()
		{
			?>
            	<div class="holderRightParceForm">
                	<div class="titleRightForm">Cheque Colour</div>
                    <div class="holderRightParceForm___intoForm alignCenter">
                    <?php
                    	for($i=1;$i<=10;$i++)
						{
							?>
								<img class="margin5px cursorPointer" 
                                	 src="<?php print HELPWordpress::template_url(); ?>/images/colours/<?php print $i; ?>.gif" 
                                     onClick="objChequeColor.change(<?php print $i; ?>);" id="chequeColor__<?php print $i; ?>" />
							<?php
							if($i == 5 && $this->cheque->type == Cheque::TYPE_LASER){?> <br/> <?php }
							else if($i == 5 && $this->cheque->type == Cheque::TYPE_MANUAL)
							{
								break;
							}
						}
					?>
                    <div id="chequeColorsAdditionalInfo"></div>
                    </div>
                    <div class="clearBoth"></div>
                </div>
            <?php
			RightForms::CREATE_INPUTS_INVISIBLE( array("chequeColor", "backgroundINdex") );
		}
		function draw_LaserChequePositions()
		{
			?>
            	<div class="holderRightParceForm">
                	<div class="titleRightForm">
                    	<?php
                        	if($this->cheque->type == Cheque::TYPE_LASER)
							{
								?>Cheque Position<?php
							}
							else
							{
								?>Cheque Style<?php
							}
						?>
                    </div>
                    <div class="holderRightParceForm___intoForm alignCenter">
                    <?php
						if($this->cheque->type == Cheque::TYPE_LASER)
						{
							for($i=1;$i<=3;$i++)
							{
								?>
									<img class="margin2px cursorPointer" id="imgPoz_id<?php print $i; ?>" 
									src="<?php print HELPWordpress::template_url(); ?>/images/styles/1-<?php print $i; ?>.png" 
									onClick="objChequePosition.changePosition(<?php print $i; ?>);" />
								<?php
							}
							RightForms::CREATE_INPUTS_INVISIBLE( array("chequePosition"), array("1") );
							?>
                            <div id="chequeBgPositionsAdditionalInfo"></div>
                            <?php
						}
						else
						{
							?>
                            	<div class="floatLEft">
                                	<div class="lineTextHeight22 marginBottom2px height22PX"><input type="checkbox" id="manualPosX1cheque" 
                                    onClick="objChequePosition.manualX2ChequesSet(this);" checked="checked" /></div>
                                	<div class="lineTextHeight22 marginBottom2px height22PX"><input type="checkbox" id="manualPosX2cheque" 
                                    onClick="objChequePosition.manualX2ChequesSet(this);" /></div>
                                </div>
                                <div class="floatLEft marginLeftRightForms">
                                	<div class="lineTextHeight22 marginBottom2px">One Per Page Manual Cheque</div>
                                    <div class="lineTextHeight22 marginBottom2px">Two Per Page Manual Cheque</div>
                                </div>
							<?php
							RightForms::CREATE_INPUTS_INVISIBLE( array("chequePosition"), array("false") );
						}
					?>
                    </div>
                    <div class="clearBoth"></div>
                </div>
            <?php
		}
		////////////////////////////////////////////////////////////////////////
		/////Company info forms
		////////////////////////////////////////////////////////////////////////
		function draw_CompanyInfo()
		{
			?>
            	<div class="holderRightParceForm">
                	<div class="titleRightForm">Company Info</div>
            <?php
			$this->draw_CI_companyNameAndAddress();
			$this->draw_CI_logo();
			$this->draw_CI_bankInfo();
			$this->draw_CICurrency();
			$this->draw_CIPricingQuantityChequeInfo();
			if($this->cheque->type == Cheque::TYPE_LASER)
			{
				$this->draw_CIboxing();
			}
			$this->draw_additionalProducts();
			?>
            
                    <div class="clearBoth"></div>
                </div>
            <?php
		}
		function draw_CI_companyNameAndAddress()
		{
			?>
            	<div>
                	<div class="subTitleRightForm">Company Name & Address</div>
                    <div class="holderRightParceForm___intoForm">
                    	<div class="floatLEft">
                        	<div class="lineTextHeight22 marginBottom2px">Name:</div>
                        	<div class="lineTextHeight22 marginBottom2px alignCenter height22PX">
                            	<input class="widthAUTO borderStyleNONE heightAUTO" type="checkbox" id="compInfoCBShowSecondLine" onclick="objCompanyInfo.CompanyNameAddress_showOnCheque();" />
                            </div>
                            <div class="lineTextHeight22 marginBottom2px">Line 1:</div>
                            <div class="lineTextHeight22 marginBottom2px">Line 2:</div>
                            <div class="lineTextHeight22 marginBottom2px">Line 3:</div>
                            <div class="lineTextHeight22 marginBottom2px">Line 4:</div>
                        </div>
                        <div class="floatLEft marginLeftRightForms">
                        	<div class="lineTextHeight22 marginBottom2px">
                                <input type="text" name="compInfoName" id="compInfoName" onkeyup="objCompanyInfo.CompanyNameAddress_showOnCheque();" maxlength=40 />
                            </div>
                            <div class="lineTextHeight22 marginBottom2px">
                            	<input type="text" name="compInfoSecondName" id="compInfoSecondName" onkeyup="objCompanyInfo.CompanyNameAddress_showOnCheque();" maxlength=40  />
                            </div>
                            <div class="lineTextHeight22 marginBottom2px">
                            	<input type=text id="compInfoAddressLine1" name="compInfoAddressLine1" onkeyup="objCompanyInfo.CompanyNameAddress_showOnCheque();" maxlength=40 />
                            </div>
                            <div class="lineTextHeight22 marginBottom2px">
                            	<input type=text id="compInfoAddressLine2" name="compInfoAddressLine2" onkeyup="objCompanyInfo.CompanyNameAddress_showOnCheque();" maxlength=40 />
                            </div>
                            <div class="lineTextHeight22 marginBottom2px">
                            	<input type=text id="compInfoAddressLine3" name="compInfoAddressLine3" onkeyup="objCompanyInfo.CompanyNameAddress_showOnCheque();" maxlength=40 />
                            </div>
                            <div class="lineTextHeight22 marginBottom2px">
                            	<input type=text id="compInfoAddressLine4" name="compInfoAddressLine4" onkeyup="objCompanyInfo.CompanyNameAddress_showOnCheque();" maxlength=40 />
                            </div>
                        </div>
                        <div class="clearBoth"></div>
                    </div>
                </div>
             <?php
			 //RightForms::CREATE_INPUTS_INVISIBLE(array("isBillToAlternativeName", "isShipToDifferentAddress", "comInfoIsSecondCompanyName"), array("", "", ""));
			 RightForms::CREATE_INPUTS_INVISIBLE(array("comInfoIsSecondCompanyName"), array(""));
			 //RightForms::CREATE_INPUTS_INVISIBLE( array(, "comInfoIsBillToNameOnCheque", "comInfoIsShiptToAddressOnCheque") );
		}
		function draw_CI_logo()
		{
			?>
            	<div>
                	<div class="subTitleRightForm">Logo</div>
                    <div class="holderRightParceForm___intoForm">
                     	By Clicking Below, Your logo will be emailed to us.<br />
                        Logo will not show on the cheque image to the left,<br />
                        A separate proof with your logo will be emailed to you.<br />
                                <input type="checkbox" class="widthAUTO borderStyleNONE heightAUTO" id="compInfoAttachLogo_1" onclick="objCompanyInfo.CBLogoOnClick(this);OrderTotalAmount.OTA.calculate();" />Attach Logo - Black Ink Only $15 one time charge. <br />
                                <input type="checkbox" class="widthAUTO borderStyleNONE heightAUTO" id="compInfoAttachLogo_2" onclick="objCompanyInfo.CBLogoOnClick(this);OrderTotalAmount.OTA.calculate();" />Attach Custom Color Logo - We will call you to go over pricing. Minimum Charge $90. <br />
                                <div id="compInfoLogoInputHolder">
                                	
                                </div>
                                Logos print best from working vector files.<br />
                                Accteptible file formats are:
                                <br />EPS, TIF, JPEG, PDF, AI, PS, CD 
                    </div>
                 </div>
             <?php
			 RightForms::CREATE_INPUTS_INVISIBLE( array("CILogoType"), array("-1") );
		}
		function draw_CI_bankInfo()
		{
			?>
            	<div>
                	<div class="subTitleRightForm">Bank Info</div>
                    <div class="holderRightParceForm___intoForm alignCenter">
                    	<div class="floatLEft">
                        	<div class="lineTextHeight22 marginBottom2px">Name:</div>
                        	<div class="lineTextHeight22 marginBottom2px">Line 1:</div>
                        	<div class="lineTextHeight22 marginBottom2px">Line 2:</div>
                        	<div class="lineTextHeight22 marginBottom2px">Line 3:</div>
                        	<div class="lineTextHeight22 marginBottom2px">Line 4:</div>
                        </div>
                        <div class="floatLEft marginLeftRightForms">
                        	<div class="lineTextHeight22 marginBottom2px">
                            	<input type=text id="compInfoBankName" name="compInfoBankName" onkeyup="objCompanyInfo.bankInfoShowToCheque();" />
                            </div>
                        	<div class="lineTextHeight22 marginBottom2px">
                            	<input type=text id="compInfoBankAddress1" name="compInfoBankAddress1" onkeyup="objCompanyInfo.bankInfoShowToCheque();" />
                            </div>
                        	<div class="lineTextHeight22 marginBottom2px">
                            	<input type=text id="compInfoBankAddress2" name="compInfoBankAddress2" onkeyup="objCompanyInfo.bankInfoShowToCheque();" />
                            </div>
                        	<div class="lineTextHeight22 marginBottom2px">
                            	<input type=text id="compInfoBankAddress3" name="compInfoBankAddress3" onkeyup="objCompanyInfo.bankInfoShowToCheque();" />
                            </div>
                        	<div class="lineTextHeight22 marginBottom2px">
                            	<input type=text id="compInfoBankAddress4" name="compInfoBankAddress4" onkeyup="objCompanyInfo.bankInfoShowToCheque();" />
                            </div>
                        </div>
                        <div class="clearBoth"></div>
                    </div>
                 </div>
             <?php
		}
		function draw_CICurrency()
		{
			?>
                <div>
                	<div class="subTitleRightForm">Currency</div>
                    <div class="holderRightParceForm___intoForm alignCenter">
                    	<div>
                        	<input type="checkbox" class="widthAUTO borderStyleNONE heightAUTO" id="compInfoCBUSFunds" onclick="objCompanyInfo.usFundsShowOnCheque();" />US FUNDS
                        </div>
                        <!--<div class="displayNone">-->
                       	<div id="add45OnAccountNumber">
                        	<input type="checkbox" class="widthAUTO borderStyleNONE heightAUTO" id="compInfoAdd45AfterAccount" onclick="objCompanyInfo.usFundsShowOnCheque();" />Add 45 After Account # on Cheques
                        </div>
                    </div>
                 </div>
             <?php
			 RightForms::CREATE_INPUTS_INVISIBLE(array("isCurrencyINPUT", "add45AfterAcountNumberInput"), array("false", "false"));
		}
		function draw_CIPricingQuantityChequeInfo()
		{
			?>
            	<div>
                	<div class="subTitleRightForm">Pricing, Quantity & Cheque Info</div>
                    <div class="holderRightParceForm___intoForm alignCenter">
                    	<?php if($this->cheque->type == Cheque::TYPE_LASER){ ?>
                    	<div>
                         	<div id="compInfoOtherSoftwer" class="alignLeft"></div>
                            <select style="width:100%;" id="compInfoSoftware" name="compInfoSoftware" onchange="objCompanyInfo.onSowtaferSELECTChanging();">
                                <option>Select Software</option>
                                <option>Simply Accounting</option>
                                <option>Buisiness Visions</option>
                                <option>Microsoft Money</option>
                                <option>Quick Books/Quicken</option>
                                <!--<option>Quicken</option>-->
                                <option>NetSuite</option>
                                <option>AcePac</option>
                                <option>MYOB</option>
                                <option>Other</option>
                              </select>
                        </div>
                        <br/>
                    	<div class="floatLEft alignLeft">
                        	<div class="lineTextHeight22 marginBottom2px height22PX">
                            	<input type="checkbox" class="widthAUTO borderStyleNONE heightAUTO" name="compInfoIncludeEnvelopes" id="compInfoIncludeEnvelopes" 
                            	onclick="objCompanyInfo.CBDWEOnClick();" />
                            </div>
                        </div>
                        <div class="floatLEft marginLeftRightForms alignLeft">
                        	<div class="lineTextHeight22 marginBottom2px" style="font-size:10px;">Do you currently use double window Envelopes?</div>
                        </div>
                        <?php } ?>
                        <div class="clearBoth"></div>
                        <div id="compInfoIncludeEnvelopes_supplierINPUT" class="alignLeft"></div>
                    	<div class="floatLEft alignLeft">
                        	<div class="lineTextHeight22 marginBottom2px height22PX">
                            	 <input type=checkbox class="widthAUTO borderStyleNONE heightAUTO" checked="checked" name="compInfoSecondSignatur" id="compInfoSecondSignatur" 
                                 	onclick="objCompanyInfo.showHideSecondSignature();" />
                            </div>
                            <div class="lineTextHeight22 marginBottom2px height22PX">
                            	<input name="compInfoShowStartNumber" id="compInfoShowStartNumber" type=checkbox 
                                onclick="objCompanyInfo.showStartNumber();" checked=checked />
                            </div>
                        </div>
                        <div class="floatLEft marginLeftRightForms alignLeft">
                            <div class="lineTextHeight22 marginBottom2px">Second Signature</div>
                            <div class="lineTextHeight22 marginBottom2px">Number Cheques</div>
                        </div>
                        <div class="clearBoth"></div>
                        <br/>
                    	<div class="floatLEft alignLeft">
                        	<div class="lineTextHeight22 marginBottom2px">Start At:</div>
                        	<div class="lineTextHeight22 marginBottom2px height22PX">Branch # (5 digits):</div>
                            <div class="lineTextHeight22 marginBottom2px height22PX">Institution # (3 Digits):</div>
                            <div class="lineTextHeight22 marginBottom2px height22PX">Account number:</div>
                        </div>
                        <div class="floatLEft marginLeftRightForms alignLeft">
                        	<div class="lineTextHeight22 marginBottom2px">
                            	<input type="text" id="compInfoStartAt" name="compInfoStartAt" 
                                					onkeyup="objCompanyInfo.showTheNumbers();" value=000000 maxlength=6 />
                            </div>
                            <div class="lineTextHeight22 marginBottom2px">
                            	<input type="text" id="compInfoBrunchNumber" name="compInfoBrunchNumber" 
                                					onkeyup="objCompanyInfo.showTheNumbers();" 
                                					onchange="" value="00000" maxlength=5 />
                            </div>
                            <div class="lineTextHeight22 marginBottom2px">
                            	<input type="text" id="compInfoTransitNumber" name="compInfoTransitNumber" 
                                					onkeyup="objCompanyInfo.showTheNumbers();" 
                                                    onchange="" value="000" maxlength=3 />
                                                    <!-- 
                                                    	Where we have onchange it was this line JS code ___objChequeSendToPFDandMAILGenerator.transitN_msgError();.
                                                        I think we do not use so i remove it.If my client ask to add this i will add.
                                                    -->
                            </div>
                            <div class="lineTextHeight22 marginBottom2px">
                            	<input type="text" id="compInfoAccountNumber" name="compInfoAccountNumber" 
                                					onkeyup="objCompanyInfo.showTheNumbers();"
                                 value="000000000000000" maxlength=15 />
                            </div>
                        </div>
                        <div class="clearBoth"></div>
                        <br/>
                        <div class="alignLeft">
                        	To enter a <b style="">space</b> press space bar, <br />
                            to enter a <b style=" font-family:specialenFont; font-size:12pt;">&nbsp;D </b> &nbsp;press - (dash) key.
                          <br /><br />
                          <span style="font-weight:bold;">**Prices Exclude Shipping & GST/HST</span>
                        </div>
                    </div>
                 </div>
             <?php
			 RightForms::CREATE_INPUTS_INVISIBLE( array("compInfoStartAtTrueOrFalse", "isThereSecondSignature", "softwareINPUT", "startAtNumber_plus_1", "softwareINPUTIndex"), 
			 array("true", "true",  "", "0", "0") );
		}
		function draw_CIboxing()
		{
			?>
            	<div>
                	<div class="subTitleRightForm">Boxing:(How cheques are placed in Printer)</div>
                    <div class="holderRightParceForm___intoForm alignCenter">
                    	<div class="floatLEft alignLeft">
                        	<div class="lineTextHeight22 marginBottom2px height22PX">
                            	<input type="checkbox" id="compInfoBoxingType0" checked=true />Low # on top, face up
                            </div>
                            <!--
                        	<div class="lineTextHeight22 marginBottom2px height22PX">
                            	<input type="checkbox" id="compInfoBoxingType2" />High # on top, face up
                            </div>
                            -->
                        </div>
                        <div class="floatLEft marginLeftRightForms alignLeft">
                        	<div class="lineTextHeight22 marginBottom2px height22PX">
                            	<input type="checkbox" id="compInfoBoxingType1" />Low # on top, face down<br /><br />
                            </div>
                            <!--
                        	<div class="lineTextHeight22 marginBottom2px height22PX">
                            	<input type="checkbox" id="compInfoBoxingType3" />High # on top, face down
                            </div>
                            -->
                        </div>
                        <script language="javascript">
                        	objCompanyInfo.BOXaddEventsToTheCB();
                        </script>
                        <div class="clearBoth"></div>
                    </div>
                 </div>
             <?php
			 RightForms::CREATE_INPUTS_INVISIBLE(array("boxingType"), array("Low # on top, face up"));
		}
		function draw_additionalProducts()
		{
			?>
            	<div>
                	<div class="subTitleRightForm">Additional Products</div>
                    <div class="holderRightParceForm___intoForm alignCenter">
                    	<div>
                        	<select  style="width:100%;"  id="compInfoDepositBooks" name="compInfoDepositBooks" onChange="objCompanyInfo.setADditionalProductsSetInputs();" >
                                <option>Deposit Books</option>
                                <option>2 Copies 100 $30</option>
                                <option>2 Copies 200 $47</option>
                                <option>2 Copies 300 $62</option>
                                <option>2 Copies 500 $88</option>
                                <option>2 Copies 1000 $143</option>
                                <option>2 Copies 1500 $210</option>
                                <option>3 Copies 100 $34</option>
                                <option>3 Copies 200 $53</option>
                                <option>3 Copies 300 $67</option>
                                <option>3 Copies 500 $95</option>
                                <option>3 Copies 1000 $149</option>
                                <option>3 Copies 1500 $203</option>
                            </select>
                        </div>
                        <?php if($this->cheque->type == Cheque::TYPE_LASER){ ?>
                        <div>
                            <select  style="width:100%;" id="compInfoDWE" name="compInfoDWE" onChange="objCompanyInfo.setADditionalProductsSetInputs();">
                                <option>Double Window Envelopes (DWE)</option>
                                <option>250 DWE $36.00</option>
                                <option>500 DWE $55.00</option>
                                <option>1000 DWE $90.00</option>
                                <option>2000 DWE $146.00</option>
                             </select>
                        </div>
                        <div>
                        	<select  style="width:100%;" id="compInfoSSDWE" name="compInfoSSDWE" onChange="objCompanyInfo.setADditionalProductsSetInputs();">
                                <option>Self Seal Double Window Envelopes (SSDWE)</option>
                                <option>250 SSDWE $40.00</option>
                                <option>500 SSDWE $65.00</option>
                                <option>1000 SSDWE $105.00</option>
                                <option>2000 SSDWE $170.00</option>
                            </select>
                        </div>
                        <?php } ?>
                        <?php if($this->cheque->type == Cheque::TYPE_MANUAL){ ?>
                        <div>
                        	<select  style="width:100%;"  id="compInfoChequeBinder" name="compInfoChequeBinder" onChange="objCompanyInfo.setADditionalProductsSetInputs();" >
                              <option>Cheque Binder</option>
                              <option>1 Per Page Binder $22.00</option>
                              <option>2 Per Page Binder $24.00</option>
                            </select>
                        </div>
                        <?php } ?>
                        <div>
                        <!--
                        	<input type="checkbox" id="compInfoSelfLinkingStamp" name="compInfoSelfLinkingStamp" 
                            			onClick="objCompanyInfo.setADditionalProductsSetInputs();" />Self Inking Stamp $34.90
                                        -->
                        	<select  style="width:100%;"  id="compInfoSelfLinkingStamp" name="compInfoSelfLinkingStamp" onChange="objCompanyInfo.setADditionalProductsSetInputs();" >
                              <option>Self Inking Stamp</option>	
                              <option>One - Self Inking Stamp $34.90</option>
                              <option>Two - Self Inking Stamps $65.50</option>
                              <option>Three - Self Inking Stamps $98.50</option>
                            </select>
                        </div>
                    </div>
               </div>
             <?php
			 RightForms::CREATE_INPUTS_INVISIBLE(array("depositBooksINPUT", "depositBooksINPUT_VARs", "DWEINPUT", "SSDWEINPUT", "chequeBinderINPUT", "SelfLinkStampINPUT"), 
			 									 array("","","","","",""));
		}
		////////////////////////////////////////////////////////////////////////
		////////////////////////////////////////////////////////////////////////
		function draw_delivery()
		{
			?>
            	<div class="holderRightParceForm">
                	<div class="titleRightForm">Delivery</div>
                    <div class="holderRightParceForm___intoForm">
                    	<div>
                        	<input type=radio id="delivery_5_7_days" onclick="deliveriOBJ.RBDeliveryOnClick(this);" checked="checked" /> Standard 5-7 bus days Production Time
                        </div>
                    	<div>
                        	<input type=radio id="delivery_24_48_days" onclick="deliveriOBJ.RBDeliveryOnClick(this);" /> 
                            Rush 24-48 hours Production Time<span style="font-size:15px; font-weight:bold; color:#900;">($25 Charge)</span>
                        </div>
                        <div>
                        	<br><span style="font-size:10px; font-weight:bold; color:black;">Please Note, Rush Charge of $25 is an extra charge in addition 
                            to the standard shipping charges.
                            <br>Overnight shipping is also available please call us for details.</span>
                        </div>
                    </div>
                    <div class="clearBoth"></div>
                </div>
            <?php
			RightForms::CREATE_INPUTS_INVISIBLE( array("deliveryINPUT"), array("Standard 5-7 bus days"));
		}
		////////////////////////////////////////////////////////////////////////
		////////////////////////////////////////////////////////////////////////
		const TYPE_SHIPING="TYPE_SHIPING";
		const TYPE_BILLING="TYPE_BILLING";
		function BillingShipingDetails($type)
		{
			?>
            	<script>
                	function BillingShipingModerator()
					{
						/*
						I use this varibales also into CompanyInfo into tools.js, so if i see a problem about this variables
						search into CompanyInfo into tools.js :D.
						*/
						this.TYPE_BILLING = "TYPE_BILLING";
						this.TYPE_SHIPING = "TYPE_SHIPING";
						this.setupINputsShipingEnabledDisabled = function()
						{
							var arrVars = ["companyName_", "contactName_", "address_1_", "address_2_", "address_3_", "city_", "CBProvince_", "province_", "postalCode_", "phone_", "email_"];							
							for(var i=0;i<arrVars.length;i++)
							{
								//document.getElementById(arrVars[i]+this.TYPE_SHIPING).disabled = document.getElementById("cbDoShippingSameAsBilling").checked;
							}
							if(document.getElementById("cbDoShippingSameAsBilling").checked)
							{
								this.ShipingSameAsBilling();
							}
							if(document.getElementById("cbDoShippingSameAsBilling").checked==true)
							{
								document.getElementById("SameAsBillingDetails").value = "true";
							}
							else
							{
								document.getElementById("SameAsBillingDetails").value = "false";
							}
						}
						this.ShipingSameAsBilling = function()
						{
							if(document.getElementById("cbDoShippingSameAsBilling").checked && 
							   document.getElementById("BSCombo_"+this.TYPE_SHIPING).checked)
							{
							/**/
								document.getElementById("companyName_"+this.TYPE_SHIPING).value = document.getElementById("companyName_"+this.TYPE_BILLING).value;
								
								document.getElementById("contactName_"+this.TYPE_SHIPING).value = document.getElementById("contactName_"+this.TYPE_BILLING).value;
								CompanyInfo.CI.comboShowShippingBilling( this.TYPE_SHIPING );
								
								document.getElementById("address_1_"+this.TYPE_SHIPING).value = document.getElementById("address_1_"+this.TYPE_BILLING).value;
								document.getElementById("address_2_"+this.TYPE_SHIPING).value = document.getElementById("address_2_"+this.TYPE_BILLING).value;
								document.getElementById("address_3_"+this.TYPE_SHIPING).value = document.getElementById("address_3_"+this.TYPE_BILLING).value;
								
								document.getElementById("city_"+this.TYPE_SHIPING).value = document.getElementById("city_"+this.TYPE_BILLING).value;
								
								document.getElementById("CBProvince_"+this.TYPE_SHIPING).selectedIndex = document.getElementById("CBProvince_"+this.TYPE_BILLING).selectedIndex;
								document.getElementById("province_"+this.TYPE_SHIPING).value = document.getElementById("province_"+this.TYPE_BILLING).value;
								this.setupProvince( this.TYPE_SHIPING );
								
								document.getElementById("postalCode_"+this.TYPE_SHIPING).value = document.getElementById("postalCode_"+this.TYPE_BILLING).value;
								document.getElementById("phone_"+this.TYPE_SHIPING).value = document.getElementById("phone_"+this.TYPE_BILLING).value;
								document.getElementById("email_"+this.TYPE_SHIPING).value = document.getElementById("email_"+this.TYPE_BILLING).value;
								
							
							}
						}
						this.setupProvince = function(forTypeOfAddress)
						{
							if(forTypeOfAddress == this.TYPE_BILLING)
							{
								document.getElementById("province_"+this.TYPE_BILLING).value = document.getElementById("CBProvince_"+this.TYPE_BILLING).options[
																										document.getElementById("CBProvince_"+this.TYPE_BILLING).selectedIndex
																										].text;
							}
							else if(forTypeOfAddress == this.TYPE_SHIPING)
							{
								document.getElementById("province_"+this.TYPE_SHIPING).value = document.getElementById("CBProvince_"+this.TYPE_SHIPING).options[
																										document.getElementById("CBProvince_"+this.TYPE_SHIPING).selectedIndex
																										].text;
							}
						}
						this.validate = function()
						{
							if(document.getElementById("BSCombo_"+this.TYPE_BILLING).checked==false)
							{
								alert("Please add Billing details.");
								return false;
							}
							if(document.getElementById("BSCombo_"+this.TYPE_SHIPING).checked==false)
							{
								alert("Please add Shipping details.");
								return false;
							}
							var arr_variables = ["companyName_","contactName_","address_1_","address_2_","address_3_",
													"city_","postalCode_","phone_","email_"];
							var billingIsOK=true;
							for(var i=0;i<arr_variables.length;i++)
							if(arr_variables[i] != "address_2_" && arr_variables[i] != "address_3_")
							{
								if(document.getElementById(arr_variables[i]+this.TYPE_BILLING).value=="")
								{
									billingIsOK = false;
								}
							}
							var shipingIsOK=true;
							for(var i=0;i<arr_variables.length;i++)
							if(arr_variables[i] != "address_2_" && arr_variables[i] != "address_3_")
							{
								if(document.getElementById(arr_variables[i]+this.TYPE_SHIPING).value=="")
								{
									shipingIsOK = false;
								}
							}
							if(document.getElementById("BSCombo_"+this.TYPE_BILLING).checked==true
								&& billingIsOK==false)
							{
								alert("Please add all Billing details.");
								return false;
							}
							if(document.getElementById("BSCombo_"+this.TYPE_SHIPING).checked==true
								&& shipingIsOK==false
								&& document.getElementById("cbDoShippingSameAsBilling").checked==false)
							{
								alert("Please add all Shipping details.");
								return false;
							}
							var cbProvince=document.getElementById("CBProvince_"+this.TYPE_BILLING);
							if(cbProvince.options[cbProvince.selectedIndex].text == "Provinces" ||
								cbProvince.options[cbProvince.selectedIndex].text== "States")
							{
								alert("Please add all Billing details.");
								return false;
							}
							var cbProvince=document.getElementById("CBProvince_"+this.TYPE_SHIPING);
							if(cbProvince.options[cbProvince.selectedIndex].text == "Provinces" ||
								cbProvince.options[cbProvince.selectedIndex].text== "States")
							{
								alert("Please add all Shipping details.");
								return false;
							}
							return true;
						}
						this.setupAdditional = function()
						{
							if(document.getElementById("residentialAddressBSMid").checked)
							{
								document.getElementById("residentialAddressBSM").value = "true";
							}
							else
							{
								document.getElementById("residentialAddressBSM").value = "false";
							}
							if(document.getElementById("noSignatureRequiredBSMid").checked)
							{
								document.getElementById("noSignatureRequiredBSM").value = "true";
							}
							else
							{
								document.getElementById("noSignatureRequiredBSM").value = "false";
							}
						}
						this.setupBillingIinfoContactFromTopContact = function()
						{
							document.getElementById("companyName_"+this.TYPE_BILLING).value 
													= StringHelper.SH.replaceAllStrings_intoString(document.getElementById("CICompanyName").value, ",", " ");
							document.getElementById("contactName_"+this.TYPE_BILLING).value 
													= StringHelper.SH.replaceAllStrings_intoString(document.getElementById("CIContactName").value, ",", " ");
							document.getElementById("phone_"+this.TYPE_BILLING).value 	  
													= StringHelper.SH.replaceAllStrings_intoString(document.getElementById("CIPhone").value, ",", " ");
							document.getElementById("email_"+this.TYPE_BILLING).value 	  
													= StringHelper.SH.replaceAllStrings_intoString(document.getElementById("CIEmail").value, ",", " ");	
						}
						this.ON_CHANGE = function(type)
						{
							if(type == this.TYPE_SHIPING)
							{
								document.getElementById("cbDoShippingSameAsBilling").checked = false;
							}
						}
					}
					BillingShipingModerator.BSM = new BillingShipingModerator();	
					function TekstHelperBSM()
					{
						this.removeComma = function(input)
						{
							input.value = input.value.replace (/\,/, '');
						}
						this.unchekOnChnage = function()
						{
							if(document.getElementById("cbDoShippingSameAsBilling").checked==false)return;
							BillingShipingModerator.BSM.setupINputsShipingEnabledDisabled();
						}
					}
					TekstHelperBSM.TH = new TekstHelperBSM();
                </script>
            	<div class="holderRightParceForm">
                	<div class="titleRightForm" style="line-height:12px;">
                        <input type="checkbox" id="BSCombo_<?php print $type; ?>" onclick="CompanyInfo.CI.comboShowShippingBilling('<?php print $type; ?>');" 
                        style="height:12px; padding:0px; padding-right:5px; padding-left:5px;" />
                    <?php
						if($type==self::TYPE_BILLING)
						{
							?>
                            Billing Details(Mandatory)
							<?php
						}
						else if($type==self::TYPE_SHIPING)
						{
							?>
                            Shipping Details(Mandatory)
							<?php
						}
					?>
                    </div>
                    <div class="holderRightParceForm___intoForm displayNone" id="billingShippingBlog_<?php print $type; ?>">
                    	<?php
                        	if($type == self::TYPE_SHIPING)
							{
								?>
								<div>
									<input type="checkbox" id="cbDoShippingSameAsBilling" onclick="BillingShipingModerator.BSM.setupINputsShipingEnabledDisabled();" /> Same as Billing Details
                                    <br />
                                    <input type="checkbox" id="residentialAddressBSMid" onclick="BillingShipingModerator.BSM.setupAdditional();" /> Residential Address
                                    <br />
                                    <input type="checkbox" id="noSignatureRequiredBSMid" onclick="BillingShipingModerator.BSM.setupAdditional();" /> No Signature Required
                                    <?php
                                    	RightForms::CREATE_INPUTS_INVISIBLE(array("SameAsBillingDetails", "residentialAddressBSM","noSignatureRequiredBSM"), 
										array("false", "false", "false"));
									?>
								</div>
                       			<br />
                                <?php
							}
						?>
                    	<div class="floatLEft alignLeft">
                        	<div class="lineTextHeight22 marginBottom2px">Company name*:</div>
                        	<div class="lineTextHeight22 marginBottom2px height22PX">Contact name*:</div>
                            <div class="lineTextHeight22 marginBottom2px height22PX">Address 1*:</div>
                            <div class="lineTextHeight22 marginBottom2px height22PX">Address 2:</div>
                            <div class="lineTextHeight22 marginBottom2px height22PX">Address 3:</div>
                            <div class="lineTextHeight22 marginBottom2px height22PX">City*:</div>
                            <div class="lineTextHeight22 marginBottom2px height22PX">Province*:</div>
                            <div class="lineTextHeight22 marginBottom2px height22PX">Postal Code*:</div>
                            <div class="lineTextHeight22 marginBottom2px height22PX">Phone*:</div>
                            <div class="lineTextHeight22 marginBottom2px height22PX">Email*:</div>
                        </div>
                        <div class="floatLEft marginLeftRightForms alignLeft">
                        	<div class="lineTextHeight22 marginBottom2px">
                            	<input type="text" id="companyName_<?php print $type; ?>" name="companyName_<?php print $type; ?>" value=""
                                	onkeyup="TekstHelperBSM.TH.removeComma(this);BillingShipingModerator.BSM.ON_CHANGE('<?php print $type; ?>');" />
                            </div>
                            <div class="lineTextHeight22 marginBottom2px">
                            	<input type="text" id="contactName_<?php print $type; ?>" name="contactName_<?php print $type; ?>" value=""
                                	onkeyup="CompanyInfo.CI.comboShowShippingBilling('<?php print $type; ?>');TekstHelperBSM.TH.removeComma(this);BillingShipingModerator.BSM.ON_CHANGE('<?php print $type; ?>');" />
                            </div>
                            <div class="lineTextHeight22 marginBottom2px">
                            	<input type="text" id="address_1_<?php print $type; ?>" name="address_1_<?php print $type; ?>" value=""
                                	onkeyup="TekstHelperBSM.TH.removeComma(this);BillingShipingModerator.BSM.ON_CHANGE('<?php print $type; ?>');" />
                            </div>
                            <div class="lineTextHeight22 marginBottom2px">
                            	<input type="text" id="address_2_<?php print $type; ?>" name="address_2_<?php print $type; ?>" value=""
                                	onkeyup="TekstHelperBSM.TH.removeComma(this);BillingShipingModerator.BSM.ON_CHANGE('<?php print $type; ?>');" />
                            </div>
                            <div class="lineTextHeight22 marginBottom2px">
                            	<input type="text" id="address_3_<?php print $type; ?>" name="address_3_<?php print $type; ?>" value=""
                                	onkeyup="TekstHelperBSM.TH.removeComma(this);BillingShipingModerator.BSM.ON_CHANGE('<?php print $type; ?>');" />
                            </div>
                            <div class="lineTextHeight22 marginBottom2px">
                            	<input type="text" id="city_<?php print $type; ?>" name="city_<?php print $type; ?>" value=""
                                	onkeyup="TekstHelperBSM.TH.removeComma(this);BillingShipingModerator.BSM.ON_CHANGE('<?php print $type; ?>');" />
                            </div>
                            <div class="lineTextHeight22 marginBottom2px">
                            	<select id="CBProvince_<?php print $type; ?>" class="width100Percent" 
                                		onchange="BillingShipingModerator.BSM.setupProvince('<?php print $type; ?>');BillingShipingModerator.BSM.ON_CHANGE('<?php print $type; ?>'); <?php
                                        
										if($type==self::TYPE_SHIPING)
										{
											print 'OrderTotalAmount.OTA.calculate();';
										}
										
										?>">
                                    <option>Provinces</option>
									<?php
										HELPWordpress::PRIN_ALL_CANADA_PROVINCIES_OPTIONS();
                                    ?>
                                    <option>States</option>
									<?php
										HELPWordpress::PRIN_ALL_USA_STATES_OPTIONS();
                                    ?>
                                </select>
                            	<!--
                            	<input type="text" id="province" name="province" value="" />
                                -->
                                	<?php
                                    	RightForms::CREATE_INPUTS_INVISIBLE(array("province_".$type), array("Provinces"));
									?>
                            </div>
                            <div class="lineTextHeight22 marginBottom2px">
                            	<input type="text" id="postalCode_<?php print $type; ?>" name="postalCode_<?php print $type; ?>" value=""
                                	onkeyup="TekstHelperBSM.TH.removeComma(this);BillingShipingModerator.BSM.ON_CHANGE('<?php print $type; ?>');" />
                            </div>
                            <div class="lineTextHeight22 marginBottom2px">
                            	<input type="text" id="phone_<?php print $type; ?>" name="phone_<?php print $type; ?>" value=""
                                	onkeyup="TekstHelperBSM.TH.removeComma(this);BillingShipingModerator.BSM.ON_CHANGE('<?php print $type; ?>');" />
                            </div>
                            <div class="lineTextHeight22 marginBottom2px">
                            	<input type="text" id="email_<?php print $type; ?>" name="email_<?php print $type; ?>" value=""
                                	onkeyup="TekstHelperBSM.TH.removeComma(this);BillingShipingModerator.BSM.ON_CHANGE('<?php print $type; ?>');" />
                            </div>
                        </div>
                    </div>
                    <?php
						if($type == self::TYPE_BILLING)
						{
			 				RightForms::CREATE_INPUTS_INVISIBLE(array("isBillToAlternativeName"), array(""));
						}
						else if($type == self::TYPE_SHIPING)
						{
			 				RightForms::CREATE_INPUTS_INVISIBLE(array("isShipToDifferentAddress"), array(""));
						}
					?>
                    <div class="clearBoth"></div>
                </div>
            <?php
		}
		////////////////////////////////////////////////////////////////////////
		////////////////////////////////////////////////////////////////////////
		public function draw_methodOfPayment()
		{
			?>
            	<div class="holderRightParceForm">
                	<div class="titleRightForm">Method Of Payment</div>
                    <div class="holderRightParceForm___intoForm">
                        <div>
                          	  <input type="checkbox" id="MOP_directDebit" onClick="objMOP.setVariablesForMOP();" />Direct Debit<br />
                              <div id="MOP_directDebit_signatureDIVHolder" class="displayNone">
                              		<div>
                                    	Signature:<input type="text" id="MOP_directDebit_signature" name="MOP_directDebit_signature" />
                                    </div>
                                    <div>
                                    	By entering my name above i agree to allow my Bank account listed on the cheque i created to be 
                                        Debit for the Total amount of my order.
                                    </div>
                                    <div class="separatorDIV"></div>
                              </div>
                              <input type="checkbox" id="MOP_Visa" onClick="objMOP.setVariablesForMOP();" />Visa &nbsp;&nbsp;&nbsp;&nbsp;
                              <input type="checkbox" id="MOP_Mastercart" onClick="objMOP.setVariablesForMOP();" />Mastercard 
                  		</div>
                        <br />
                        <div>
                          Card Number: <input type="text" id="MOP_cardNum" name="MOP_cardNum" maxlength="16" style="width:130px;" />&nbsp;&nbsp;
                          CSV: <input name="MOPcsv" id="MOPcsv" type="text" maxlength="3" style="text-align:center; width:30px;" />
                        </div>
                        <br />
                        <div>
                            Expiry Month: 
                                <select id="MOP_expMonth" onChange="objMOP.setVariablesForMOP();">
                                    <option>Jan</option>
                                    <option>Feb</option>
                                    <option>Mar</option>
                                    <option>Apr</option>
                                    <option>May</option>
                                    <option>Jun</option>
                                    <option>Jul</option>
                                    <option>Aug</option>
                                    <option>Sep</option>
                                    <option>Oct</option>
                                    <option>Nov</option>
                                    <option>Dec</option>
                                </select> &nbsp;&nbsp;&nbsp;&nbsp;
                            Expiry Year: 
                                <select id="MOP_expYear" onChange="objMOP.setVariablesForMOP();">
                                    <option>2011</option>
                                    <option>2012</option>
                                    <option>2013</option>
                                    <option>2014</option>
                                    <option>2015</option>
                                    <option>2016</option>
                                    <option>2017</option>
                                    <option>2018</option>
                                    <option>2019</option>
                                    <option>2020</option>
                                    <option>2021</option>
                                    <option>2022</option>
                                </select> 
                         </div>
               		   <br />
                       <div>
                          <input type="checkbox" id="MOP_pleaseCallMe" onClick="objMOP.setVariablesForMOP();" />Please call me for my Credit Card Number
                       </div>
                       <script>
                       		objMOP.addEventListenerToCB();
                       </script>
                    </div>
                    <div class="clearBoth"></div>
                </div>
            <?php
			RightForms::CREATE_INPUTS_INVISIBLE(array("mopINPUT", "mopExpirtyMonthINPUT", "mopExpirtyYearINPUT", "mopCallMe"), 
												array("", "Jan", "2011", "false"));
		}
		////////////////////////////////////////////////////////////////////////
		////////////////////////////////////////////////////////////////////////
		function draw_airmilesRewardMiles()
		{
			?>
            	<div class="holderRightParceForm">
                	<div class="titleRightForm">AIRMILES Reward Miles</div>
                    <div class="holderRightParceForm___intoForm">
                    	Card Number <input type="text" id="AIRMILES_cardNumber" name="AIRMILES_cardNumber" maxlength="11" onkeyup="this.value = this.value.replace (/\D/, '');" />
                    </div>
                    <div class="clearBoth"></div>
                </div>
            <?php
		}
		/////////////////////////////////////////////////////////////////////////
		//////////////////////////////////////////////////////////////////////////
		function draw_totalAmount()
		{
			//displayNone
			?>
            	<div class="holderRightParceForm orderTotalAmount displayNone">
                	<div class="titleRightForm">Order Total Amount</div>
                    <div class="holderRightParceForm___intoForm paddingLeft50px paddingRight50px">
                    	<div>
                        	Sub Total:<span class="floatRight" id="sub_total_products"><b>$0</b></span>
                        </div>
                        <div class="">
                        	Shipping:<span class="floatRight" id="shipping_price"><b>$0</b></span>
                        </div>
                    	<div>
                        	Taxes:<span class="floatRight" id="sub_total_taxes"><b>$0</b></span>
                        </div>
                        <div>
                        	Grand Total:<span class="floatRight" id="grand_total"><b>$0</b></span>
                        </div>
                    </div>
                    <div class="clearBoth"></div>
                </div>
                <script>
                	function OrderTotalAmount()
					{
						this.sub_total_products = function()
						{
							var total = Quantity_and_Prices.QP.quantityMONEY();
							if(document.getElementById("compInfoAttachLogo_1").checked == true){total += 15;}
							else if(document.getElementById("compInfoAttachLogo_2").checked == true){total += 90;}
							
							total += CompanyInfo.CI.getDepositObject().priceTotal;
							total += CompanyInfo.CI.getDWEObject().priceTotal;
							total += CompanyInfo.CI.getSSDWEObject().priceTotal;
							total += CompanyInfo.CI.getAPChequeBinderObject().priceTotal;
							total += CompanyInfo.CI.getAPSelfLinkingShtamp().priceTotal;
							
							if(document.getElementById("delivery_24_48_days").checked == true){total += 25;}
							
							return total;   
						}
						this.sub_total_taxes = function()
						{
							var percent=0;
							var selectedProvinceOrStateOnShiping = document.getElementById("CBProvince_TYPE_SHIPING").selectedIndex;
							selectedProvinceOrStateOnShiping = 
							document.getElementById("CBProvince_TYPE_SHIPING").options[selectedProvinceOrStateOnShiping].text
							switch(selectedProvinceOrStateOnShiping)
							{
								case "AB":{percent=5/100;}break;
								case "BC":{percent=12/100;}break;
								case "MB":{percent=5/100;}break;
								case "NB":{percent=13/100;}break;
								case "NL":{percent=13/100;}break;
								case "NS":{percent=15/100;}break;
								case "NT":{percent=5/100;}break;
								case "NU":{percent=5/100;}break;
								case "ON":{percent=13/100;}break;
								case "PE":{percent=5/100;}break;
								case "QC":{percent=5/100;}break;
								case "SK":{percent=5/100;}break;
								case "YT":{percent=5/100;}break;
							}
							return this.sub_total_products()*percent;
						}
						this.grand_total = function()
						{
							return this.sub_total_products()+this.shipping_price()+this.sub_total_taxes();
						}
						this.shipping_price = function()
						{
							return 0;
						}
						
						this.calculate = function()
						{
							$("#sub_total_products_INPUT").val(this.sub_total_products());
							$("#shipping_price_INPUT").val(this.shipping_price());
							$("#sub_total_taxes_INPUT").val(this.sub_total_taxes());
							$("#grand_total_INPUT").val(this.grand_total());
							document.getElementById("sub_total_products").innerHTML = "<b>$"+this.sub_total_products().toFixed(2)+"</b>";
							document.getElementById("shipping_price").innerHTML = "<b>$"+this.shipping_price().toFixed(2)+"</b>";
							document.getElementById("sub_total_taxes").innerHTML = "<b>$"+this.sub_total_taxes().toFixed(2)+"</b>";
							document.getElementById("grand_total").innerHTML = "<b>$"+this.grand_total().toFixed(2)+"</b>";
						}
					}
					OrderTotalAmount.OTA = new OrderTotalAmount();
                </script>
            <?php
			RightForms::CREATE_INPUTS_INVISIBLE(array("sub_total_products_INPUT", "shipping_price_INPUT", "sub_total_taxes_INPUT", "grand_total_INPUT"), 
												array("0", "0", "0", "0"));
		}
		/////////////////////////////////////////////////////////////////////////
		//////////////////////////////////////////////////////////////////////////
		public function draw_SubmitOrderBTN()
		{
			?>
            <div class="btnORDERCHEQUE">
            	<img align="absmiddle" onclick="objSentEmail.SEND();" 
                src="<?php print HELPWordpress::template_url(); ?>/images/SUBMIT-ORDER-BUTTON-GREEN.png" />
            </div>
            <?php
		}
		public function draw_AknowlegementsExplanations()
		{
			$widthAknowLefgementsDiv = 0;
			if($this->cheque->type == Cheque::TYPE_LASER)
			{
				$widthAknowLefgementsDiv = 305;
			}
			else if($this->cheque->type == Cheque::TYPE_MANUAL)
			{
				$widthAknowLefgementsDiv = 390;
			}
			?>
            <div id="" style="">
            	<div class="floatLEft" style="width:<?php print $widthAknowLefgementsDiv; ?>px;">
                	Ordering your business cheques couldnt be simpler ... fill out the information
                    on the RIGHT to see the changes to the demo cheque in the middle of the page.<br />
                    <!--Once complete please click Submit Order to complete the process!<br /><br />--><br />
                    To ensure the safety AND security of every order we will call to confirm the
                    details before printing your new business cheques!<br /><br /> You can also call us directly
                    at 1-866-760-2661 Ext 224 to discuss your cheque order in person.
                </div>
                <div class="floatRight" style="width:<?php print $widthAknowLefgementsDiv; ?>px;">
                	<div class="titleRightForm">Acknowledgement</div>
                    Please double check all information entered above is correct, by clicking send you agree that the information is correct 
                    and you will not receive another proof unless a logo is being sent.<br /><br />
                    Please note: the positions on this proof are approx, we will ensure all positions will match the software you are using.
                </div>
                <div class="clearBoth"></div>
            </div>
            <?php
		}
		/////////////////////////////////////////////////////////////////////////
		//////////////////////////////////////////////////////////////////////////
		/////////////////////////////////////////////////////////////////////////
		//////////////////////////////////////////////////////////////////////////
		/////////////////////////////////////////////////////////////////////////
		//////////////////////////////////////////////////////////////////////////
		static function CREATE_INPUTS_INVISIBLE($arr=NULL, $arrVALUES=NULL)
		{
			$value = "";
			for($i=0;$i<count($arr);$i++)
			{
				$value = "";
				if($arrVALUES != NULL && $arrVALUES[$i] != NULL){$value = $arrVALUES[$i];}
				?>
                	<input style="width:90%; font-size:10px;" type="hidden" name="<?php print $arr[$i]; ?>" id="<?php print $arr[$i]; ?>" value="<?php print $value; ?>">
                <?php
			}
		}
	}

?>