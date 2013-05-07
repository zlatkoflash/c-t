<?php

//print_r($_POST);
//print "[".OrderNumber::$CURR_ORDER->orderFileName."]";

class RightForms {

    public static $RF = NULL;
    var $cheque;
    public static $SHOW_ALL_PRODUCTS = false;
    public static $IS_FOR_SHOWING_ORDER_FOR_ADMIN = false;

    public static function IS_NEW_CREATED_ORDER() {
        if (isset($_POST["setupNewVariable_from_admin"]) &&
                $_POST["setupNewVariable_from_admin"] == "true") {
            return true;
        }
        return false;
    }

    public static function IS_NEW_CREATED_ORDER_FROM_EXISTING_ORDER() {
        if (isset($_POST["IS_NEW_CREATED_ORDER_FROM_EXISTING_ORDER"]) &&
                $_POST["IS_NEW_CREATED_ORDER_FROM_EXISTING_ORDER"] == "true") {
            return true;
        }
        return false;
    }

    public function RightForms($cheque___) {
        $this->cheque = $cheque___;
        self::$RF = $this;
    }

    public function showMe() {
        $this->setup_validation_tool();
        $this->setup_all_products_into_JS();
        $this->draw_Quantity_and_Prices();
        $this->draw_ContactInfo();
        $this->draw_LaserChequePositions();
        $this->draw_ChequeColors();
        $this->draw_CompanyInfo();
        $this->BillingShipingDetails(self::TYPE_BILLING);
        $this->BillingShipingDetails(self::TYPE_SHIPING);
        $this->draw_methodOfPayment();
        $this->draw_airmilesRewardMiles();
        $this->draw_delivery();
        if (RightForms::$IS_FOR_SHOWING_ORDER_FOR_ADMIN == true) {
            //$this->draw_Email_Discount_Code();
        }
        $this->draw_totalAmount();
        if (!self::$IS_FOR_SHOWING_ORDER_FOR_ADMIN) {
            $this->draw_SubmitOrderBTN();
        }
        if (RightForms::$IS_FOR_SHOWING_ORDER_FOR_ADMIN == true) {
            $this->draw_create_invoice_button();
        }
        //RightForms::CREATE_INPUTS_INVISIBLE( array("save_order", "chequeType"), array("Yes i will save order", $cheque->type) );
        RightForms::CREATE_INPUTS_INVISIBLE(array("sendPDFandEmail", "chequeType"), array("SEND_EMAIL", $this->cheque->type));
    }

    private function setup_validation_tool() {
        ?>
        <script>
            $(document).ready(function(e)
            {
                $("#form").validationEngine();
            });
        </script>
        <?php
    }

    private function setup_all_products_into_JS() {
        ?>
        <script>
        <?php
        ProductsModerator::setup_JSquantity_products();
        ProductsModerator::setup_JSdepositBooks_products();
        ProductsModerator::setup_JSDWE_products();
        ProductsModerator::setup_JSSSDWE_products();
        ProductsModerator::setup_JSchequeBinders_products();
        ProductsModerator::setup_JSSelfInkingStamp_products();
        ProductsModerator::setup_JSLogos_products();
        ProductsModerator::setup_JSRushShippingCharges_products();
        ProductsModerator::setup_JSShippingDiscount();
        ?>
        </script>
        <?php
    }

    function draw_ContactInfo() {
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
                            type=text id="CICompanyName" name="CICompanyName" class="validate[required]" /></div>
                    <div class="lineTextHeight22 marginBottom2px"><input 
                            onkeyup="BillingShipingModerator.BSM.setupBillingIinfoContactFromTopContact();" 
                            type=text id="CIContactName" name="CIContactName" class="validate[required]" /></div>
                    <div class="lineTextHeight22 marginBottom2px"><input 
                            onkeyup="BillingShipingModerator.BSM.setupBillingIinfoContactFromTopContact();" 
                            type=text id="CIPhone" name="CIPhone" class="validate[required]" /></div>
                    <div class="lineTextHeight22 marginBottom2px"><input 
                            onkeyup="BillingShipingModerator.BSM.setupBillingIinfoContactFromTopContact();" 
                            type=text id="CIEmail" name="CIEmail" class="validate[required,custom[email]]" /></div>
                </div>
                <div class="clearBoth"></div>
                <div>Question / Comments</div>
                <div>
                    <textarea id="CIQuestionsAndCommentsTA" name="CIQuestionsAndCommentsTA" onchange="objContactInfo.CIQuestionsAndCommentsSet();" style="height:100px; width:230px;" class="" ></textarea>
                </div>
            </div>
            <div class="clearBoth"></div>
        </div>
        <?php
        RightForms::CREATE_INPUTS_INVISIBLE(array("CIQuestionsAndComments"), array(""));
    }

    function draw_Quantity_and_Prices() {
        ?>
        <div class="holderRightParceForm">
            <div class="titleRightForm"><b>Quantity & Prices</b></div>
            <div class="holderRightParceForm___intoForm alignCenter">
                <div>
                    <select  style="width:100%;"  id="compInfoQuantity" name="compInfoQuantity" 
                             class="validate[required]" >
                    </select>
                    <script>
                    $("#compInfoQuantity").change(function(e)
                    {
                        CreatingInvoiceForAdditionalProducts.CIFAP.setupIDs_and_Indexes_ForSubmit();
                        OrderTotalAmount.OTA.calculate();
                        Delivery.D.tryToSetupAfterDelay();
                        CreatingInvoiceForAdditionalProducts.CIFAP.set_next_start_number();
                    });
        <?php ?>
                    Quantity_and_Prices.QP.addQuantintyOptions(  );
        <?php ?>
                    </script>
                </div>
            </div>
            <div class="clearBoth"></div>
        </div>
        <?php
        /*
          RightForms::CREATE_INPUTS_INVISIBLE(array( "quantityINPUT", "quantityINPUTIndex", "quantityTitle"), array("", "0", ""));
         */
    }

    function draw_ChequeColors() {
        ?>
        <div class="holderRightParceForm">
            <div class="titleRightForm">Cheque Colour</div>
            <div class="holderRightParceForm___intoForm alignCenter">

        <?php
        if (self::$IS_FOR_SHOWING_ORDER_FOR_ADMIN) {
            ?>
                    <div class="alignCenter">
                        <input type="text" id="chequeColour_predefined" value=""
                               class="validate[required] visibilityHidden" style=" width: 30px; height: 1px;" />
                    </div>
            <?php
        }
        for ($i = 1; $i <= 10; $i++) {
            ?>
                    <img class="margin5px cursorPointer colour_rect_click" 
                         src="<?php print HELPWordpress::template_url(); ?>/images/colours/<?php print $i; ?>.gif" 
                         onClick="objChequeColor.change(<?php print $i; ?>);" id="chequeColor__<?php print $i; ?>" />
            <?php if ($i == 5 && $this->cheque->type == Cheque::TYPE_LASER) { ?> <br/> <?php
            } else if ($i == 5 && $this->cheque->type == Cheque::TYPE_MANUAL) {
                break;
            }
        }
        ?>
                <?php
                if (self::$IS_FOR_SHOWING_ORDER_FOR_ADMIN) {
                    ?>
                    <div>
                        <span id="color_info_for_hologram_cheque_position">Middle Position</span>, <b id="color_info_for_hologram">TEAL GREEN</b> Colour 
                        <select id="hologram_U_P_no_yes" name="hologram_U_P_no_yes">
                            <option value="U">U</option><!--Foil-->
                            <option value="P">P</option><!--No Foil-->
                        </select>
                    </div>
                    <script>
                    $(document).ready(function(e)
                    {
                        /*
                         * On document ready always should be selected U
                         */
                        $("#hologram_U_P_no_yes").val("U");
                    <?php
                    /*
                     * For admin when there is post value add to the input please
                     * */
                    if (isset($_POST["hologram_U_P_no_yes"])) {
                        ?>
                            $("#hologram_U_P_no_yes").val("<?php print $_POST["hologram_U_P_no_yes"]; ?>");
                <?php
            }
            if (!self::IS_NEW_CREATED_ORDER()) {
                ?>

                            $("#color_info_for_hologram").html(ChequeColor.CH.pictureColor());
                            $("#color_info_for_hologram_cheque_position").html(ChequePosition.CP.positionName());
                <?php
            }
            ?>
                        $(".colour_rect_click").click(function(e)
                        {
                            $("#chequeColour_predefined").val("Now colour is selected and order can submit.");
                            $("#chequeColour_predefined").validationEngine("hide");
                        });
            <?php
            if (!self::IS_NEW_CREATED_ORDER()) {
                ?>
                            $("#chequeColour_predefined").val("Now colour is selected and order can submit.");
                <?php
            }
            ?>
                    });
                    </script>
        <?php
        } else {
            /*
             * On order form always need foil selected
             * */
            RightForms::CREATE_INPUTS_INVISIBLE(array("hologram_U_P_no_yes"), array("U"));
        }
        ?>
                <div id="chequeColorsAdditionalInfo"></div>
            </div>
            <div class="clearBoth"></div>
        </div>
        <?php
        RightForms::CREATE_INPUTS_INVISIBLE(array("chequeColor", "backgroundINdex"));
    }

    function draw_LaserChequePositions() {
        ?>
        <div class="holderRightParceForm">
            <div class="titleRightForm">
                <?php
                if ($this->cheque->type == Cheque::TYPE_LASER) {
                    ?>Cheque Position<?php
                } else {
                    ?>Cheque Style<?php
                }
                ?>
            </div>
            <div class="holderRightParceForm___intoForm alignCenter">
        <?php
        if ($this->cheque->type == Cheque::TYPE_LASER) {
            if (self::$IS_FOR_SHOWING_ORDER_FOR_ADMIN) {
                ?>
                        <div class="alignCenter">
                            <input type="text" id="chequePosition_predefined" value=""
                                   class="validate[required] visibilityHidden" style=" width: 30px; height: 1px;" />
                        </div>
                        <script>
                            $(document).ready(function(e)
                            {
                                $(".image_position_laser").click(function(e)
                                {
                                    $("#chequePosition_predefined").val("Now position for laser cheque is selected");
                                    $("#chequePosition_predefined").validationEngine("hide");
                                    $("#chequeBgPositionsAdditionalInfo").html("");
                                });
                            });
                        <?php
                        if (!self::IS_NEW_CREATED_ORDER()) {
                            ?>
                                $("#chequePosition_predefined").val("Now position for laser cheque is selected");
                        <?php } ?>
                        </script>
                        <?php
                    }
                    for ($i = 1; $i <= 3; $i++) {
                        ?>
                        <img class="margin2px cursorPointer image_position_laser" id="imgPoz_id<?php print $i; ?>" 
                             src="<?php print HELPWordpress::template_url(); ?>/images/styles/1-<?php print $i; ?>.png" 
                             onClick="objChequePosition.changePosition(<?php print $i; ?>);" />
                <?php
            }
            RightForms::CREATE_INPUTS_INVISIBLE(array("chequePosition"), array("1"));
            if (self::$IS_FOR_SHOWING_ORDER_FOR_ADMIN == true) {
                ?>

                <?php
            }
            ?>
                    <div id="chequeBgPositionsAdditionalInfo"></div>
            <?php
        } else {
            ?>
                    <div class="floatLEft">
                        <div class="lineTextHeight22 marginBottom2px height22PX">
                            <input type="checkbox" id="manualPosX1cheque" name="manualPosX1cheque_option" value="-1" 
                                   onClick="objChequePosition.manualX2ChequesSet(this);" checked="checked" /></div>
                        <div class="lineTextHeight22 marginBottom2px height22PX">
                            <input type="checkbox" id="manualPosX2cheque" name="manualPosX1cheque_option" value="-2"  
                                   onClick="objChequePosition.manualX2ChequesSet(this);" /></div>
                    </div>
                    <div class="floatLEft marginLeftRightForms">
                        <div class="lineTextHeight22 marginBottom2px">One Per Page Manual Cheque</div>
                        <div class="lineTextHeight22 marginBottom2px">Two Per Page Manual Cheque</div>
                    </div>
                         <?php
                         if (self::$IS_FOR_SHOWING_ORDER_FOR_ADMIN) {
                             ?>
                        <script>
                $("#manualPosX1cheque").addClass("validate[required]");
                $("#manualPosX2cheque").addClass("validate[required]");
                        </script>
                        <?php
                    }
                    RightForms::CREATE_INPUTS_INVISIBLE(array("chequePosition"), array("false"));
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
    function draw_CompanyInfo() {
        ?>
        <div class="holderRightParceForm">
            <div class="titleRightForm">Company Info</div>
        <?php
        $this->draw_CI_companyNameAndAddress();
        $this->draw_CI_logo();
        $this->draw_CI_bankInfo();
        $this->draw_CICurrency();
        $this->draw_CIPricingQuantityChequeInfo();
        if ($this->cheque->type == Cheque::TYPE_LASER) {
            $this->draw_CIboxing();
        }
        $this->draw_additionalProducts();
        ?>

            <div class="clearBoth"></div>
        </div>
                <?php
            }

            function draw_CI_companyNameAndAddress() {
                ?>
        <div>
            <div class="subTitleRightForm">Company Name & Address</div>
            <div class="holderRightParceForm___intoForm">
                <div class="floatLEft">
                    <div class="lineTextHeight22 marginBottom2px">Name:</div>
                    <div class="lineTextHeight22 marginBottom2px alignCenter height22PX">
                        Name 2:<input class="widthAUTO borderStyleNONE heightAUTO" type="checkbox" id="compInfoCBShowSecondLine" onclick="CompanyInfo.CI.CompanyNameAddress_showOnCheque();" />
                    </div>
                    <div class="lineTextHeight22 marginBottom2px">Line 1:</div>
                    <div class="lineTextHeight22 marginBottom2px">Line 2:</div>
                    <div class="lineTextHeight22 marginBottom2px">Line 3:</div>
                    <div class="lineTextHeight22 marginBottom2px">Line 4:</div>
                </div>
                <div class="floatRight width200px">
                    <div class="lineTextHeight22 marginBottom2px">
                        <input class="width100Percent" type="text" name="compInfoName" id="compInfoName" onkeyup="CompanyInfo.CI.CompanyNameAddress_showOnCheque();" />
                    </div>
                    <div class="lineTextHeight22 marginBottom2px">
                        <input class="width100Percent" type="text" name="compInfoSecondName" id="compInfoSecondName" onkeyup="CompanyInfo.CI.CompanyNameAddress_showOnCheque();"  />
                    </div>
                    <div class="lineTextHeight22 marginBottom2px">
                        <input class="width100Percent" type=text id="compInfoAddressLine1" name="compInfoAddressLine1" onkeyup="CompanyInfo.CI.CompanyNameAddress_showOnCheque();" />
                    </div>
                    <div class="lineTextHeight22 marginBottom2px">
                        <input class="width100Percent" type=text id="compInfoAddressLine2" name="compInfoAddressLine2" onkeyup="CompanyInfo.CI.CompanyNameAddress_showOnCheque();"  />
                    </div>
                    <div class="lineTextHeight22 marginBottom2px">
                        <input class="width100Percent" type=text id="compInfoAddressLine3" name="compInfoAddressLine3" onkeyup="CompanyInfo.CI.CompanyNameAddress_showOnCheque();"  />
                    </div>
                    <div class="lineTextHeight22 marginBottom2px">
                        <input class="width100Percent" type=text id="compInfoAddressLine4" name="compInfoAddressLine4" onkeyup="CompanyInfo.CI.CompanyNameAddress_showOnCheque();"  />
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

    function draw_CI_logo() {
        ?>
        <div>
            <div class="subTitleRightForm">Logo</div>
            <div class="holderRightParceForm___intoForm">
                By Clicking Below, Your logo will be emailed to us.<br />
                Logo will not show on the cheque image to the left,<br />
                <input type="checkbox" class="widthAUTO borderStyleNONE heightAUTO" id="compInfoAttachLogo_1" 
                       onclick="CreatingInvoiceForAdditionalProducts.CIFAP.setupIDs_and_Indexes_ForSubmit();
                                                    CompanyInfo.CI.CBLogoOnClick(this);
                                                    OrderTotalAmount.OTA.calculate();" />
                <span id="one_time_charge_label">
                    Attach Logo - Black Ink Only $<span class="logo_price_label">15</span> one time charge. 
                </span>
                <br />
                <input type="checkbox" class="widthAUTO borderStyleNONE heightAUTO" id="compInfoAttachLogo_2" onclick="CreatingInvoiceForAdditionalProducts.CIFAP.setupIDs_and_Indexes_ForSubmit();
                                                    CompanyInfo.CI.CBLogoOnClick(this);
                                                    OrderTotalAmount.OTA.calculate();" />
                <span id="custom_color_label">
                    Attach Custom Color Logo - We will call you to go over pricing. Minimum Charge $<span class="logo_price_label">90</span>.
                </span>
                <script>
                        $($("#one_time_charge_label").find(".logo_price_label").get(0)).html(
                                CompanyInfo.CI.list_logos_products["one_time_charge"].price);
                        $($("#custom_color_label").find(".logo_price_label").get(0)).html(
                                CompanyInfo.CI.list_logos_products["custom_color"].price_abs());
                </script>
                <br />
                <div id="compInfoLogoInputHolder">

                </div>
                Logos print best from working vector files.<br />
                Accteptible file formats are:
                <br />EPS, TIF, JPEG, PDF, AI, PS, CDR 
        <?php if (self::$IS_FOR_SHOWING_ORDER_FOR_ADMIN) { ?>
                    <div class="paddingTop20px">

                        <i>
                        </i>
                        <div class="floatLEft lineTextHeight23">
                            Proof Required?<b></b>
                        </div>
                        <div class="floatLEft marginLeft30px lineTextHeight23">
                            <b></b>
                            <input class="validate[required]" name="cheque_logo_proof_required" value="yes" type="radio" />Yes 
                            <input class="validate[required]" name="cheque_logo_proof_required" value="no" type="radio" />No

                        </div>
            <?php
            if
            (
                    isset($_POST["cheque_logo_proof_required"])
            /*
              &&
              !self::IS_NEW_CREATED_ORDER_FROM_EXISTING_ORDER() */
            ) {
                ?>
                            <script>
                                /**/
                                var value = "<?php print $_POST["cheque_logo_proof_required"]; ?>";
                                $("input[name=cheque_logo_proof_required][value=" + value + "]").prop('checked', true);

                            </script>
                        <?php
                    }
                    ?>
                    </div>
        <?php } ?>
                <div class="clearBoth"></div>
            </div>
        </div>
        <?php
        RightForms::CREATE_INPUTS_INVISIBLE(array("CILogoType"), array("-1"));
    }

    function draw_CI_bankInfo() {
        ?>
        <div>
            <div class="subTitleRightForm">Bank Info</div>
            <div class="holderRightParceForm___intoForm alignLeft">
                <div>
                    <div class="lineTextHeight22 marginBottom10px">
                        <a href="#" class="colorRED showTheExplanations">
                            <b>Click Here To See How To Enter Account Details</b>
                        </a>
                    </div>
                    <script>
                        $(".showTheExplanations").click(function(e)
                        {
                            $(".how_to_enter_micr_account_number").show(500);
                            return false;
                        });
                    </script>
                    <div class="lineTextHeight22 marginBottom2px">
                        <div class="floatLEft width110px">Branch # (5 digits):</div>
                        <div class="floatLEft width150px">
                            <input class="width100Percent cheque_numbers_key_up bank_info_number_keyup onkeyupload_bank_details" 
                                   type="text" id="compInfoBrunchNumber" name="compInfoBrunchNumber" 
                                   onchange="" value="" maxlength=5 />
                        </div>
                        <div class="clearBoth"></div>
                    </div>
                    <div class="lineTextHeight22 marginBottom2px">
                        <div class="floatLEft width110px">Institution # (3 Digits):</div>
                        <div class="floatLEft width150px">
                            <input class="width150px cheque_numbers_key_up bank_info_number_keyup onkeyupload_bank_details" 
                                   type="text" id="compInfoTransitNumber" name="compInfoTransitNumber" 
                                   onchange="" value="" maxlength=3 />
                        </div>
                        <div class="clearBoth"></div>
                    </div>
                    <div class="lineTextHeight22 marginBottom2px">
                        <div class="floatLEft width110px">Account number:</div>
                        <div class="floatLEft width150px">
                            <input 
                                class="width150px cheque_numbers_key_up bank_info_number_keyup validate[required, funcCall[checkAccountNumberFormat]]" 
                                type="text" id="compInfoAccountNumber" name="compInfoAccountNumber" 
                                value="" maxlength=15 />
                        </div>
                        <div class="clearBoth"></div>
                    </div>
                    
                    <div id="bank_info_number_validation_form" class="">
                        <div class="marginTop20px marginBottom2px">
                            <b class="colorRED">Please verify bank details by re-entering below</b> 
                        </div>
                        <div class="lineTextHeight22 marginBottom2px">
                            <div class="floatLEft width110px">Branch # (5 digits):</div>
                            <div class="floatLEft width150px">
                                <input class="width100Percent validate[funcCall[checkBrunchNumberValidated]]" 
                                       type="text" id="compInfoBrunchNumber_verify" 
                                       name="compInfoBrunchNumber_verify"
                                       onchange="" value="" maxlength=5 />
                            </div>
                            <div class="clearBoth"></div>
                        </div>
                        <div class="lineTextHeight22 marginBottom2px">
                            <div class="floatLEft width110px">Institution # (3 Digits):</div>
                            <div class="floatLEft width150px">
                                <input class="width150px  validate[funcCall[checkcompInfoTranzitNumberValidated]]" 
                                       type="text" id="compInfoTransitNumber_verify" name="compInfoTransitNumber_verify" 
                                       onchange="" value="" maxlength=3 />
                            </div>
                            <div class="clearBoth"></div>
                        </div>
                        <div class="lineTextHeight22 marginBottom2px">
                            <div class="floatLEft width110px">Account number:</div>
                            <div class="floatLEft width150px">
                                <input 
                                    class="width150px validate[required, funcCall[checkAccountNumberValidated]]" 
                                    type="text" id="compInfoAccountNumber_verify" name="compInfoAccountNumber_verify"
                                    value="" maxlength=15 />
                            </div>
                            <div class="clearBoth"></div>
                        </div>
                    </div>
                    
                    
                    <div class="lineTextHeight22 marginBottom2px marginTop20px">
                        <div class="floatLEft width110px">Bank Layout</div>
                        <div class="floatLEft width150px">
                            <input value="true" type="checkbox" id="cb_ovverride_default_bank_layout" 
                                   name="cb_ovverride_default_bank_layout">override default?
                            <?php
                            if (isset($_POST["cb_ovverride_default_bank_layout"])) {
                                ?>
                                                    <script>
                                                $("#cb_ovverride_default_bank_layout").prop("checked", true);
                                                    </script>
                                <?php
                            }
                            ?>
                        </div>
                        <div class="clearBoth"></div>
                    </div>
                    <script>
                        $(".bank_info_number_keyup").change(function(e)
                        {
                            $("#bank_info_number_validation_form").removeClass("displayNone");
                        });
                        function checkBrunchNumberValidated(field, rules, i, options)
                        {
                            if($("#compInfoBrunchNumber").val() != $("#compInfoBrunchNumber_verify").val())
                            {
                                return "Branch Numbers Dont Match."
                            }
                        }
                        $("#compInfoBrunchNumber").change(function(e)
                        {
                            if($("#compInfoBrunchNumber").val() == $("#compInfoBrunchNumber_verify").val())
                            {
                                $("#compInfoBrunchNumber_verify").validationEngine("hide");
                            } 
                            else
                            {
                                $("#compInfoBrunchNumber_verify").validationEngine("validate"); 
                            }
                        });
                        function checkcompInfoTranzitNumberValidated(field, rules, i, options)
                        {
                            if($("#compInfoTransitNumber").val() != $("#compInfoTransitNumber_verify").val())
                            {
                                return "Institution Numbers Dont Match."
                            }
                        }
                        $("#compInfoTransitNumber").change(function(e)
                        {
                            if($("#compInfoTransitNumber").val() == $("#compInfoTransitNumber_verify").val())
                            {
                                $("#compInfoTransitNumber_verify").validationEngine("hide");
                            } 
                            else
                            {
                                $("#compInfoTransitNumber_verify").validationEngine("validate");
                            }
                        });
                        function checkAccountNumberValidated(field, rules, i, options)
                        {
                            if($("#compInfoAccountNumber").val() != $("#compInfoAccountNumber_verify").val())
                            {
                                return "Account Numbers Dont Match."
                            }
                        }
                        $("#compInfoAccountNumber").change(function(e)
                        {
                            if($("#compInfoAccountNumber").val() == $("#compInfoAccountNumber_verify").val())
                            {
                                $("#compInfoAccountNumber_verify").validationEngine("hide");
                            } 
                            else
                            {
                                $("#compInfoAccountNumber_verify").validationEngine("validate");
                            }
                        });
                        $("#compInfoAccountNumber_verify").change(function(e)
                        {
                            if($("#compInfoAccountNumber").val() == $("#compInfoAccountNumber_verify").val())
                            {
                                $("#compInfoAccountNumber_verify").validationEngine("hide");
                            } 
                            else
                            {
                                $("#compInfoAccountNumber_verify").validationEngine("validate");
                            }
                            CompanyInfo.CI.get_reset_account_number_acording_to_live_transit_and_brunch
                            (
                                    $("#compInfoAccountNumber_verify").val()
                             );
                        });
                                $("#cb_ovverride_default_bank_layout").click(function(e)
                                {
                                    show_labels_for_account_numbers();
                                });
                                function checkAccountNumberFormat(field, rules, i, options)
                                {
                                    if (!CompanyInfo.CI.check_account_number_if_is_good())
                                    {
                                        /*
                                         return "Valid Format:<br/>"
                                         +CompanyInfo.CI.format_temp_account_number_info();
                                         */
                                        return "Please enter your " + CompanyInfo.CI.format_temp_account_length() + " Digit Account #";
                                    }
                                }
                                function show_labels_for_account_numbers()
                                {
                                    if ($("#cb_ovverride_default_bank_layout").prop("checked"))
                                    {
                                        //$(".account_number_label_explanation_ticked").addClass("displayNone");
                                        $(".account_number_label_explanation_ticked").removeClass("displayNone");
                                        $(".account_number_label_explanation_not_ticked").removeClass("displayNone");
                                        //$("#compInfoAccountNumber .input_just_numeric").removeNumeric();
                                        //$(".input_just_numeric").removeNumeric();
                                    }
                                    else
                                    {
                                        $(".account_number_label_explanation_ticked").removeClass("displayNone");
                                        $(".account_number_label_explanation_not_ticked").addClass("displayNone");
                                        //$("#compInfoAccountNumber .input_just_numeric").numeric();
                                        //$(".input_just_numeric").numeric();
                                    }
                                }
                      $("#compInfoAccountNumber").change(function(e)
                      {
                          CompanyInfo.CI.resetAccountNumber();
                          //CompanyInfo.CI.showTheNumbers();
                      });
                      CompanyInfo.CI.add_event
                      (
                              CompanyInfo.ON_GET_FORMATED_ACCOUNT_NUMBER_ACORDING_TO_INSTITUTION,
                      function(data)
                      {
                          $("#compInfoAccountNumber_verify").val( data.acc_number_formated );
                            
                            if($("#compInfoAccountNumber").val() == $("#compInfoAccountNumber_verify").val())
                            {
                                $("#compInfoAccountNumber_verify").validationEngine("hide");
                            } 
                            else
                            {
                                $("#compInfoAccountNumber_verify").validationEngine("validate");  
                            }
                      }
                       );
                       </script>
                    <div class="clearBoth"></div>
                </div>
                <br/>
                <div class="alignLeft">
                    <span class="account_number_label_explanation_not_ticked displayNone colorRED">	
                        To enter a <b style="">space</b> press space bar, <br />
                        to enter a <b style=" font-family:specialenFont; font-size:12pt;">&nbsp;D </b> 
                        &nbsp;press - (dash) key.
                        <br><br>
                    </span>
                    <span class="account_number_label_explanation_ticked displayNone">
                        If your bank account does not match the layout
                        specified please select the Override Default Tick
                        Box and enter it exactly as it appears on your
                        cheque.</span>
                    <!--
                  <br /><br />
                    -->
                    <!--
                    <span style="font-weight:bold;">**Prices Exclude Shipping & GST/HST</span>
                    -->
                    <script>
                        show_labels_for_account_numbers();
                    </script>
                </div>
                <hr>
                <div class="floatLEft">

                    <div class="lineTextHeight22 marginBottom2px">Bank Name:</div>
                    <div class="lineTextHeight22 marginBottom2px">Address Line 1:</div>
                    <div class="lineTextHeight22 marginBottom2px">Address Line 2:</div>
                    <div class="lineTextHeight22 marginBottom2px">Address Line 3:</div>
                    <div class="lineTextHeight22 marginBottom2px">Address Line 4:</div>
                </div>
                <div class="floatLEft marginLeftRightForms">

                    <div class="lineTextHeight22 marginBottom2px">
                        <input type=text id="compInfoBankName" name="compInfoBankName" 
                               onkeyup="CompanyInfo.CI.bankInfoShowToCheque();" />
                    </div>
                    <div class="lineTextHeight22 marginBottom2px">
                        <input type=text id="compInfoBankAddress1" name="compInfoBankAddress1" onkeyup="CompanyInfo.CI.bankInfoShowToCheque();" />
                    </div>
                    <div class="lineTextHeight22 marginBottom2px">
                        <input type=text id="compInfoBankAddress2" name="compInfoBankAddress2" onkeyup="CompanyInfo.CI.bankInfoShowToCheque();" />
                    </div>
                    <div class="lineTextHeight22 marginBottom2px">
                        <input type=text id="compInfoBankAddress3" name="compInfoBankAddress3" onkeyup="CompanyInfo.CI.bankInfoShowToCheque();" />
                    </div>
                    <div class="lineTextHeight22 marginBottom2px">
                        <input type=text id="compInfoBankAddress4" name="compInfoBankAddress4" onkeyup="CompanyInfo.CI.bankInfoShowToCheque();" />
                    </div>
                </div>
                <div class="clearBoth"></div>
                <div class="padding10px">
                    <b class="colorRED">Please Double Check<br/>Bank Address & Postal Code</b>
                </div>
            </div>
        </div>
        <?php
    }

    function draw_CICurrency() {
        ?>
        <div>
            <div class="subTitleRightForm">Currency</div>
            <div class="holderRightParceForm___intoForm alignCenter">
                <div>
                    <input type="checkbox" class="widthAUTO borderStyleNONE heightAUTO" id="compInfoCBUSFunds" onclick="CompanyInfo.CI.usFundsShowOnCheque();" />US FUNDS
                </div>
                <!--<div class="displayNone">-->
                <div id="add45OnAccountNumber">
                    <!--
                    <input type="checkbox" class="widthAUTO borderStyleNONE heightAUTO" id="compInfoAdd45AfterAccount" onclick="CompanyInfo.CI.usFundsShowOnCheque();CompanyInfo.CI.showTheNumbers();" />
                    -->
                    Add 45 After Account # on Cheques?
                    <br/>
                    <input onclick="CompanyInfo.CI.usFundsShowOnCheque();
                                          CompanyInfo.CI.showTheNumbers();" type="radio" value="yes" class="validate[required]" name="add_45_after_account" id="add_45_after_account_yes" />Yes 
                    <input onclick="CompanyInfo.CI.usFundsShowOnCheque();
                                          CompanyInfo.CI.showTheNumbers();" type="radio" value="no" class="validate[required]" name="add_45_after_account" id="add_45_after_account_no" />No
                    <script>
        <?php
        if (self::$IS_FOR_SHOWING_ORDER_FOR_ADMIN) {
            ?>
                      /**/
                      var value = "<?php print $_POST["add_45_after_account"]; ?>";
                      $("input[name=add_45_after_account][value=" + value + "]").prop('checked', true);

            <?php
        }
        ?>
                    </script>
                </div>
            </div>
        </div>
        <div>
        <?php
        RightForms::CREATE_INPUTS_INVISIBLE(array("isCurrencyINPUT", "add45AfterAcountNumberInput"), array("false", "false"));
        ?>
        </div>
        <?php
    }

    function draw_CIPricingQuantityChequeInfo() {
        ?>
        <div>
            <div class="subTitleRightForm">Signature Options</div>
            <div class="holderRightParceForm___intoForm alignCenter">
                <input type="radio" class="validate[required]" value="x1"  name="compInfoSecondSignatur" id="compInfox1Signatur"
                       onclick="CompanyInfo.CI.showHideSecondSignature();" /> One Signature Line 
                <input type="radio" class="validate[required]" value="x2"  name="compInfoSecondSignatur" id="compInfoSecondSignatur" 
                       onclick="CompanyInfo.CI.showHideSecondSignature();" /> Two Signature Lines
            </div>
            <div class="subTitleRightForm">Cheque Info & Starting Number</div>
            <div class="holderRightParceForm___intoForm alignCenter">
        <?php if ($this->cheque->type == Cheque::TYPE_LASER) { ?>
                    <div>
                        <select style="width:100%;" id="compInfoSoftware" name="compInfoSoftware" onchange="CompanyInfo.CI.onSowtaferSELECTChanging();" class="validate[required]">
                            <option value="">Select Software</option>
                            <option value="1">Simply Accounting</option>
                            <option value="2">Buisiness Visions</option>
                            <option value="3">Microsoft Money</option>
                            <option value="4">Quick Books/Quicken</option>
                            <!--<option value="?this is removed.">Quicken</option>-->
                            <option value="5">NetSuite</option>
                            <option value="6">AcePac</option>
                            <option value="7">MYOB</option>
                            <option value="8">Other</option>
                        </select>
                    </div>
                    <div id="compInfoOtherSoftwer" class="alignLeft"></div>
                    <br/>
                    <div class="floatLEft alignLeft">
                        <div class="lineTextHeight22 marginBottom2px height22PX">
                            <input type="checkbox" class="widthAUTO borderStyleNONE heightAUTO" name="compInfoIncludeEnvelopes" id="compInfoIncludeEnvelopes" 
                                   onclick="CompanyInfo.CI.CBDWEOnClick();" />
                        </div>
                    </div>
                    <div class="floatLEft marginLeftRightForms alignLeft">
                        <div class="lineTextHeight22 marginBottom2px" style="font-size:10px;">Do you currently use double window Envelopes?</div>
                    </div>
        <?php } ?>
                <div class="clearBoth"></div>
                <div id="compInfoIncludeEnvelopes_supplierINPUT" class="alignLeft"></div>
                <div class="floatLEft alignLeft">
                    <!--
                <div class="lineTextHeight22 marginBottom2px height22PX">
                     <input type=checkbox class="widthAUTO borderStyleNONE heightAUTO" checked="checked" name="compInfoSecondSignatur" id="compInfoSecondSignatur" 
                            onclick="CompanyInfo.CI.showHideSecondSignature();" />
                </div>
                    -->
                    <div class="lineTextHeight22 marginBottom2px height22PX">
                        <input name="compInfoShowStartNumber" id="compInfoShowStartNumber" type=checkbox 
                               onclick="CompanyInfo.CI.showStartNumber();" checked=checked />
                    </div>
                </div>
                <div class="floatLEft marginLeftRightForms alignLeft">
                    <!--
                    <div class="lineTextHeight22 marginBottom2px">Second Signature</div>
                    -->
                    <div class="lineTextHeight22 marginBottom2px">Number Cheques</div>
                </div>
                <div class="clearBoth"></div>
                <br/>
                <div class="floatLEft alignLeft">
                    <div class="lineTextHeight22 marginBottom2px">Starting Number:</div>
                    <div class="lineTextHeight22 marginBottom2px">Special Designation:</div>
                    <!--
                    <div class="lineTextHeight22 marginBottom2px height22PX">Branch # (5 digits):</div>
                    <div class="lineTextHeight22 marginBottom2px height22PX">Institution # (3 Digits):</div>
                    <div class="lineTextHeight22 marginBottom2px height22PX">Account number:</div>
                    -->
                </div>
                <div class="floatLEft marginLeftRightForms alignLeft">
                    <div class="lineTextHeight22 marginBottom2px">
                        <input class="width150px onfocus_select cheque_numbers_key_up" 
                               type="text" id="compInfoStartAt" name="compInfoStartAt" 
                               value="000000" maxlength=10 />

                    </div>
                    <div class="lineTextHeight22 marginBottom2px">
                        <input class="width150px onfocus_select cheque_numbers_key_up all_chars_upper_case" 
                               type="text" id="special_designation" name="special_designation" 
                               value="" maxlength=4
                               placeholder="Add designation in front of cheque #" />
                    </div>
                    <!--
                    <div class="lineTextHeight22 marginBottom2px">
                        <input class="width150px onfocus_select cheque_numbers_key_up onkeyupload_bank_details" 
                               type="text" id="compInfoBrunchNumber" name="compInfoBrunchNumber" 
                                                                onchange="" value="00000" maxlength=5 />
                    </div>
                    <div class="lineTextHeight22 marginBottom2px">
                        <input class="width150px onfocus_select cheque_numbers_key_up onkeyupload_bank_details" 
                               type="text" id="compInfoTransitNumber" name="compInfoTransitNumber" 
                                            onchange="" value="000" maxlength=3 />
                                            
                    </div>
                    <div class="lineTextHeight22 marginBottom2px">
                        <input class="width150px onfocus_select cheque_numbers_key_up" 
                               type="text" id="compInfoAccountNumber" name="compInfoAccountNumber" 
                         value="000000000000000" maxlength=15 />
                    </div>
                    -->
                </div>
                <script>
                      $(".onfocus_select").click(function(e)
                      {
                          $(this).select();
                      });
                      $(".cheque_numbers_key_up").keyup(function(e)
                      {
                          CompanyInfo.CI.showTheNumbers();

                          /*
                           This is just for Start At Number, but for less complication
                           and adding additional classes i put here the functions.
                           On keyup on other numbers input will working this, but it is not a problem.
                           */
                          CreatingInvoiceForAdditionalProducts.CIFAP.set_next_start_number();
                      });
                      $(".onkeyupload_bank_details").keyup(function(e)
                      {
                          CompanyInfo.CI.load_bank_details();
                      });
                </script>
                <div class="clearBoth"></div>
            </div>
        </div>
        <?php
        RightForms::CREATE_INPUTS_INVISIBLE(array("compInfoStartAtTrueOrFalse", "isThereSecondSignature", "softwareINPUT", "startAtNumber_plus_1", "softwareINPUTIndex"), array("true", "true", "", "0", "0"));
    }

    function draw_CIboxing() {
        ?>
        <div>
            <div class="subTitleRightForm">Boxing:(How cheques are placed in Printer)</div>
            <div class="holderRightParceForm___intoForm alignCenter">
                <div class="floatLEft alignLeft">
                    <div class="lineTextHeight22 marginBottom2px height22PX">
                        <input type="checkbox" id="compInfoBoxingType0" class="validate[required]"
                               name="face_up_face_down_cb" checked=true />
                        Low # on top, face up
                    </div>
                    <!--
                        <div class="lineTextHeight22 marginBottom2px height22PX">
                        <input type="checkbox" id="compInfoBoxingType2" />High # on top, face up
                    </div>
                    -->
                </div>
                <div class="floatLEft marginLeftRightForms alignLeft">
                    <div class="lineTextHeight22 marginBottom2px height22PX">
                        <input type="checkbox" class="validate[required]" id="compInfoBoxingType1"
                               name="face_up_face_down_cb" />
                        Low # on top, face down<br /><br />
                    </div>
                    <!--
                        <div class="lineTextHeight22 marginBottom2px height22PX">
                        <input type="checkbox" id="compInfoBoxingType3" />High # on top, face down
                    </div>
                    -->
                </div>
                <script language="javascript">
                    CompanyInfo.CI.BOXaddEventsToTheCB();
                </script>
                <div class="clearBoth"></div>
            </div>
        </div>
        <?php
        RightForms::CREATE_INPUTS_INVISIBLE(array("boxingType"), array("Low %23 on top, face up"));
    }

    function draw_additionalProducts() {
        ?>
        <div>
            <div class="subTitleRightForm">Additional Products</div>
            <div class="holderRightParceForm___intoForm alignCenter">
                <div>
                    <select  style="width:100%;"  id="compInfoDepositBooks" name="compInfoDepositBooks" onChange="CreatingInvoiceForAdditionalProducts.CIFAP.setupIDs_and_Indexes_ForSubmit();" >

                    </select>
                    <script>
                    CompanyInfo.CI.addAllDepositBooks();
                    </script>
                </div>
                <div>
                </div>
        <?php
        if ($this->cheque->type == Cheque::TYPE_LASER ||
                self::$SHOW_ALL_PRODUCTS == true
        ) {
            ?>
                    <div class="displayNone">
                        <select  style="width:100%;" id="compInfoDWE" name="compInfoDWE" onChange="CreatingInvoiceForAdditionalProducts.CIFAP.setupIDs_and_Indexes_ForSubmit();">
                            <!--
                                <option>Double Window Envelopes (DWE)</option>
                                <option>250 DWE $36.00</option>
                                <option>500 DWE $55.00</option>
                                <option>1000 DWE $90.00</option>
                                <option>2000 DWE $146.00</option>
                            -->
                        </select>
                        <script>
                       CompanyInfo.CI.addDWWEList();
                        </script>
                    </div>
                    <div>
                        <select  style="width:100%;" id="compInfoSSDWE" name="compInfoSSDWE" onChange="CreatingInvoiceForAdditionalProducts.CIFAP.setupIDs_and_Indexes_ForSubmit();">
                            <!--
                                <option>Self Seal Double Window Envelopes (SSDWE)</option>
                                <option>250 SSDWE $40.00</option>
                                <option>500 SSDWE $65.00</option>
                                <option>1000 SSDWE $105.00</option>
                                <option>2000 SSDWE $170.00</option>
                            -->
                        </select>
                        <script>
                        CompanyInfo.CI.addSSDWEList();
                        </script>
                    </div>
                <?php } ?>
                <?php
                if ($this->cheque->type == Cheque::TYPE_MANUAL ||
                        self::$SHOW_ALL_PRODUCTS == true
                ) {
                    ?>
                    <div>
                        <select  style="width:100%;"  id="compInfoChequeBinder" name="compInfoChequeBinder" onChange="CreatingInvoiceForAdditionalProducts.CIFAP.setupIDs_and_Indexes_ForSubmit();" >
                            <!--
                              <option>Cheque Binder</option>
                              <option>1 Per Page Binder $22.00</option>
                              <option>2 Per Page Binder $24.00</option>
                            -->
                        </select>
                        <script>
                        CompanyInfo.CI.addChesuwBinderList();
                        </script>
                    </div>
        <?php } ?>
                <div>
                    <!--
                            <input type="checkbox" id="compInfoSelfLinkingStamp" name="compInfoSelfLinkingStamp" 
                                            onClick="CreatingInvoiceForAdditionalProducts.CIFAP.setupIDs_and_Indexes_ForSubmit();" />Self Inking Stamp $34.90
                    -->
                    <select  style="width:100%;"  id="compInfoSelfLinkingStamp" name="compInfoSelfLinkingStamp" onChange="CreatingInvoiceForAdditionalProducts.CIFAP.setupIDs_and_Indexes_ForSubmit();" >
                        <!--
                          <option>Self Inking Stamp</option>	
                          <option>One - Self Inking Stamp $34.90</option>
                          <option>Two - Self Inking Stamps $65.50</option>
                          <option>Three - Self Inking Stamps $98.50</option>
                        -->
                    </select>
                    <script>
                    CompanyInfo.CI.addSelfIncingStampList();
                    </script>
                </div>
            </div>
        </div>
        <?php
        /*
          RightForms::CREATE_INPUTS_INVISIBLE(array("depositBooksINPUT", "depositBooksINPUT_VARs", "DWEINPUT", "SSDWEINPUT", "chequeBinderINPUT", "SelfLinkStampINPUT"),
          array("","","","","",""));
          RightForms::CREATE_INPUTS_INVISIBLE(array("depositBooksINPUTIndex", "depositBooksINPUTIndex", "DWEINPUTIndex", "SSDWEINPUTIndex", "chequeBinderINPUTIndex", "SelfLinkStampINPUTIndex"),
          array("0","0","0","0","0","0"));
         */
        RightForms::CREATE_INPUTS_INVISIBLE(array("additional_products_IDs", "additionalProducts_indexes"), array("-1;-1;-1;-1;-1;-1;-1;-1", "0;0;0;0;0;0;0;0"));
    }

    ////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////
    function draw_delivery() {
        ?>
        <!--
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
        -->
        <div class="holderRightParceForm">
            <div class="titleRightForm">Delivery</div>
            <div class="holderRightParceForm___intoForm positionRelative deliveryFormInto">
                <div id="loadingDeliveryDetails" class="positionAbsolute">
                    <div class="padding10px">
                        Please wait...<br />
                        Loading details for<br /><b class="loadingDeliveryDetailsText">(Standard 8-10 Business Days)</b>
                    </div>
                </div>
                <div>
                    <input type=radio name="deliveryTypeRadioOption" id="standard_8to10_business_days" checked="checked" onclick="CreatingInvoiceForAdditionalProducts.CIFAP.setupIDs_and_Indexes_ForSubmit();
                                        Delivery.D.setup_delivery_details();" /> Standard 8-10 Business Days
                </div>
                <div>
                    <input type=radio name="deliveryTypeRadioOption" id="rush_25charge_1to5_business_days" onclick="CreatingInvoiceForAdditionalProducts.CIFAP.setupIDs_and_Indexes_ForSubmit();
                                        Delivery.D.setup_delivery_details();" /> 
                    Rush<span style="font-size:15px; font-weight:bold; color:#900;"> ($<span id="chargeShippingRushPrice">25</span> Charge)</span> 1-5 Business Days 
                    <!--(Choose Delivery Speed Below)-->
                </div>
                <script>
                    $("#chargeShippingRushPrice").html(Delivery.D.getShippingRushChargeObject().price);
                </script>
                <!--displayNone-->
                <div class="">
                    <input type="checkbox" name="shipping_to_bo_box" id="shipping_to_bo_box" value="AAAAAA" 
                           onclick="Delivery.D.setup_delivery_details();" /> 
                    Shipping to P.O. Box
                </div>
                <div class="shippingChargeFormInfo">
                    <hr />
                    <div>
                        <span id="shipping_charge_info_price">Shipping Charge </span>
                        <b><span class="shippingChargeFormInfoPrice">$0.00</span></b>
                    </div>

                    <div class="<?php if (!self::$IS_FOR_SHOWING_ORDER_FOR_ADMIN) { ?>displayNone<?php } ?>">
                        Shipped Via 
                        <b class="shippingChargeFormInfoCompany displayNone">Not Selected.</b>
                        <select id="shipping_charge_select_company" name="shipping_charge_select_company">
                            <option value=""></option>
                            <option value="CANPAR">CANPAR</option>
                            <option value="CANADAPOST">CANADAPOST</option>
                            <option value="ZOOMSHIPPER">ZOOMSHIPPER</option>
                            <option value="FINANCIAL COURIER">FINANCIAL COURIER</option>
                            <option value="CALL FOR PICK UP">CALL FOR PICK UP</option>
                            <option value="FEDEX">FEDEX</option>
                            <option value="OTHER">OTHER</option>
                        </select>
                        <div>
                            <input type="text" class="width100Percent displayNone" id="shipping_price_INPUT_company" name="shipping_price_INPUT_company" />
                        </div>
                        <script>
            $("#shipping_charge_select_company").change(function(e)
            {
                /*
                 * Reseting the value for implementing other actions
                 * other input showing hiding
                 * */
                Delivery.D.select_shipping_via_option($(this).val());
            });
            $("#shipping_charge_select_company").change(function(e)
            {
                if ($(this).val() == "OTHER")
                {
                    $("#shipping_price_INPUT_company").val("");
                }
            });
        <?php if (!self::$IS_FOR_SHOWING_ORDER_FOR_ADMIN) { ?>
                Delivery.D.is_changing_manual_shipping_details = true;
        <?php } ?>
                        </script>
                    </div>

                </div>
            </div>
            <div class="clearBoth"></div>
        </div>
        <script>
            $(document).ready(function(e)
            {
                $("#loadingDeliveryDetails").addClass("bg_FFF");
                $("#loadingDeliveryDetails").css("left", "0px");
                $("#loadingDeliveryDetails").css("top", "0px");
                $("#loadingDeliveryDetails").css("width", $(".deliveryFormInto").innerWidth() + "px");
                $("#loadingDeliveryDetails").css("height", $(".deliveryFormInto").innerHeight() + "px");
                $("#loadingDeliveryDetails").css("opacity", "0");
                $("#loadingDeliveryDetails").addClass("displayNone");
            });
        </script>
        <?php
        RightForms::CREATE_INPUTS_INVISIBLE(array("deliveryINPUT"), array("Standard 5-7 bus days"));
    }

    ////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////

    const TYPE_SHIPING = "TYPE_SHIPING";
    const TYPE_BILLING = "TYPE_BILLING";

    function BillingShipingDetails($type) {
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
                    for (var i = 0; i < arrVars.length; i++)
                    {
                        //document.getElementById(arrVars[i]+this.TYPE_SHIPING).disabled = document.getElementById("cbDoShippingSameAsBilling").checked;
                    }
                    if (document.getElementById("cbDoShippingSameAsBilling").checked)
                    {
                        this.ShipingSameAsBilling();
                    }
                    if (document.getElementById("cbDoShippingSameAsBilling").checked == true)
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
                    if (document.getElementById("cbDoShippingSameAsBilling").checked &&
                            document.getElementById("BSCombo_" + this.TYPE_SHIPING).checked)
                    {
                        /**/
                        document.getElementById("companyName_" + this.TYPE_SHIPING).value = document.getElementById("companyName_" + this.TYPE_BILLING).value;

                        document.getElementById("contactName_" + this.TYPE_SHIPING).value = document.getElementById("contactName_" + this.TYPE_BILLING).value;
                        CompanyInfo.CI.comboShowShippingBilling(this.TYPE_SHIPING);

                        document.getElementById("address_1_" + this.TYPE_SHIPING).value = document.getElementById("address_1_" + this.TYPE_BILLING).value;
                        document.getElementById("address_2_" + this.TYPE_SHIPING).value = document.getElementById("address_2_" + this.TYPE_BILLING).value;
                        document.getElementById("address_3_" + this.TYPE_SHIPING).value = document.getElementById("address_3_" + this.TYPE_BILLING).value;

                        document.getElementById("city_" + this.TYPE_SHIPING).value = document.getElementById("city_" + this.TYPE_BILLING).value;

                        document.getElementById("CBProvince_" + this.TYPE_SHIPING).selectedIndex = document.getElementById("CBProvince_" + this.TYPE_BILLING).selectedIndex;
                        document.getElementById("province_" + this.TYPE_SHIPING).value = document.getElementById("province_" + this.TYPE_BILLING).value;
                        this.setupProvince(this.TYPE_SHIPING);

                        document.getElementById("postalCode_" + this.TYPE_SHIPING).value = document.getElementById("postalCode_" + this.TYPE_BILLING).value;
                        document.getElementById("phone_" + this.TYPE_SHIPING).value = document.getElementById("phone_" + this.TYPE_BILLING).value;
                        document.getElementById("email_" + this.TYPE_SHIPING).value = document.getElementById("email_" + this.TYPE_BILLING).value;


                    }
                    Delivery.D.setup_delivery_details();
                    for (var i = 0; i < $(document).find(".hide_validation_if_input_is_selected").length; i++)
                    {
                        var input_shipping = $(document).find(".hide_validation_if_input_is_selected").get(i);
                        $(input_shipping).validationEngine("hide");
                    }
                }
                this.setupProvince = function(forTypeOfAddress)
                {
                    if (forTypeOfAddress == this.TYPE_BILLING)
                    {
                        document.getElementById("province_" + this.TYPE_BILLING).value = document.getElementById("CBProvince_" + this.TYPE_BILLING).options[
                                document.getElementById("CBProvince_" + this.TYPE_BILLING).selectedIndex
                        ].text;
                    }
                    else if (forTypeOfAddress == this.TYPE_SHIPING)
                    {
                        document.getElementById("province_" + this.TYPE_SHIPING).value = document.getElementById("CBProvince_" + this.TYPE_SHIPING).options[
                                document.getElementById("CBProvince_" + this.TYPE_SHIPING).selectedIndex
                        ].text;
                    }
                }
                this.validate = function()
                {
                    if (document.getElementById("BSCombo_" + this.TYPE_BILLING).checked == false)
                    {
                        alert("Please add Billing details.");
                        return false;
                    }
                    if (document.getElementById("BSCombo_" + this.TYPE_SHIPING).checked == false)
                    {
                        alert("Please add Shipping details.");
                        return false;
                    }
                    var arr_variables = ["companyName_", "contactName_", "address_1_", "address_2_", "address_3_",
                        "city_", "postalCode_", "phone_", "email_"];
                    var billingIsOK = true;
                    for (var i = 0; i < arr_variables.length; i++)
                        if (arr_variables[i] != "address_2_" && arr_variables[i] != "address_3_")
                        {
                            if (document.getElementById(arr_variables[i] + this.TYPE_BILLING).value == "")
                            {
                                billingIsOK = false;
                            }
                        }
                    var shipingIsOK = true;
                    for (var i = 0; i < arr_variables.length; i++)
                        if (arr_variables[i] != "address_2_" && arr_variables[i] != "address_3_")
                        {
                            if (document.getElementById(arr_variables[i] + this.TYPE_SHIPING).value == "")
                            {
                                shipingIsOK = false;
                            }
                        }
                    if (document.getElementById("BSCombo_" + this.TYPE_BILLING).checked == true
                            && billingIsOK == false)
                    {
                        alert("Please add all Billing details.");
                        return false;
                    }
                    if (document.getElementById("BSCombo_" + this.TYPE_SHIPING).checked == true
                            && shipingIsOK == false
                            && document.getElementById("cbDoShippingSameAsBilling").checked == false)
                    {
                        alert("Please add all Shipping details.");
                        return false;
                    }
                    var cbProvince = document.getElementById("CBProvince_" + this.TYPE_BILLING);
                    if (cbProvince.options[cbProvince.selectedIndex].text == "Provinces" ||
                            cbProvince.options[cbProvince.selectedIndex].text == "States")
                    {
                        alert("Please add all Billing details.");
                        return false;
                    }
                    var cbProvince = document.getElementById("CBProvince_" + this.TYPE_SHIPING);
                    if (cbProvince.options[cbProvince.selectedIndex].text == "Provinces" ||
                            cbProvince.options[cbProvince.selectedIndex].text == "States")
                    {
                        alert("Please add all Shipping details.");
                        return false;
                    }
                    return true;
                }
                this.setupAdditional = function()
                {
                    if (document.getElementById("residentialAddressBSMid").checked)
                    {
                        document.getElementById("residentialAddressBSM").value = "true";
                    }
                    else
                    {
                        document.getElementById("residentialAddressBSM").value = "false";
                    }
                    if (document.getElementById("noSignatureRequiredBSMid").checked)
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
                    document.getElementById("companyName_" + this.TYPE_BILLING).value
                            = StringHelper.SH.replaceAllStrings_intoString(document.getElementById("CICompanyName").value, ",", " ");
                    document.getElementById("contactName_" + this.TYPE_BILLING).value
                            = StringHelper.SH.replaceAllStrings_intoString(document.getElementById("CIContactName").value, ",", " ");
                    document.getElementById("phone_" + this.TYPE_BILLING).value
                            = StringHelper.SH.replaceAllStrings_intoString(document.getElementById("CIPhone").value, ",", " ");
                    document.getElementById("email_" + this.TYPE_BILLING).value
                            = StringHelper.SH.replaceAllStrings_intoString(document.getElementById("CIEmail").value, ",", " ");
                }
                this.ON_CHANGE = function(type)
                {
                    if (type == this.TYPE_SHIPING)
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
                    input.value = input.value.replace(/\,/, '');
                }
                this.unchekOnChnage = function()
                {
                    if (document.getElementById("cbDoShippingSameAsBilling").checked == false)
                        return;
                    BillingShipingModerator.BSM.setupINputsShipingEnabledDisabled();
                }
            }
            TekstHelperBSM.TH = new TekstHelperBSM();
        </script>
        <div class="holderRightParceForm">
            <div class="titleRightForm" style="line-height:12px;">
                <input type="checkbox" id="BSCombo_<?php print $type; ?>" name="BSCombo_<?php print $type; ?>" onclick="CompanyInfo.CI.comboShowShippingBilling('<?php print $type; ?>');" value="yes_they_are_selected" 
                       style="height:12px; padding:0px; padding-right:5px; padding-left:5px;"  class="validate[required] checkbox" />
        <?php
        if ($type == self::TYPE_BILLING) {
            ?>
                    Billing Details(Mandatory)
            <?php
        } else if ($type == self::TYPE_SHIPING) {
            ?>
                    Shipping Details(Mandatory)
            <?php
        }
        ?>
            </div>
            <div class="holderRightParceForm___intoForm displayNone" id="billingShippingBlog_<?php print $type; ?>">
        <?php
        $additional_classes_for_shipping = "";
        if ($type == self::TYPE_SHIPING) {
            ?>
                    <div>
                        <!---->
                        <input type="checkbox" id="cbDoShippingSameAsBilling" checked="checked"  
                               class=" displayNone "
                               onclick="BillingShipingModerator.BSM.setupINputsShipingEnabledDisabled();" />

                        <span class="same_as_billing_link cursorPointer">
                            Same as Billing Details, click here.
                        </span> 
                        <script>
            $(".same_as_billing_link").click(function(e)
            {
            $("#cbDoShippingSameAsBilling").attr("checked", "checked");
            BillingShipingModerator.BSM.setupINputsShipingEnabledDisabled();
            return false;
            });
                        </script>
                        <br />
                        <input type="checkbox" id="residentialAddressBSMid" onclick="BillingShipingModerator.BSM.setupAdditional();" /> Residential Address
                        <br />
                        <input type="checkbox" id="noSignatureRequiredBSMid" onclick="BillingShipingModerator.BSM.setupAdditional();" /> No Signature Required
                    <?php
                    RightForms::CREATE_INPUTS_INVISIBLE(array("SameAsBillingDetails", "residentialAddressBSM", "noSignatureRequiredBSM"), array("false", "false", "false"));
                    ?>
                    </div>
                    <br />
            <?php
            $additional_classes_for_shipping = " hide_validation_if_input_is_selected text_shiping_key_up onchange_shipping_select  ";
        } else {
            /*
             * this is case when billing inputs, on keyp setup that
             * billing is not same as shipping
             * setup the checkbox hidden and input false value for same
             * as billing
             */
            $additional_classes_for_shipping = " text_shiping_key_up ";
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
                               onkeyup="TekstHelperBSM.TH.removeComma(this);
                                BillingShipingModerator.BSM.ON_CHANGE('<?php print $type; ?>');" 
                               class="validate[required] <?php print $additional_classes_for_shipping; ?> " />
                    </div>
                    <div class="lineTextHeight22 marginBottom2px">
                        <input type="text" id="contactName_<?php print $type; ?>" name="contactName_<?php print $type; ?>" value=""
                               onkeyup="CompanyInfo.CI.comboShowShippingBilling('<?php print $type; ?>');
                                TekstHelperBSM.TH.removeComma(this);
                                BillingShipingModerator.BSM.ON_CHANGE('<?php print $type; ?>');"
                               class="validate[required] <?php print $additional_classes_for_shipping; ?> " />
                    </div>
                    <div class="lineTextHeight22 marginBottom2px">
                        <input type="text" id="address_1_<?php print $type; ?>" name="address_1_<?php print $type; ?>" value=""
                               onkeyup="TekstHelperBSM.TH.removeComma(this);
                                BillingShipingModerator.BSM.ON_CHANGE('<?php print $type; ?>');"
                               class="validate[required] <?php print $additional_classes_for_shipping; ?> " />
                    </div>
                    <div class="lineTextHeight22 marginBottom2px">
                        <input type="text" id="address_2_<?php print $type; ?>" name="address_2_<?php print $type; ?>" value=""
                               onkeyup="TekstHelperBSM.TH.removeComma(this);
                                BillingShipingModerator.BSM.ON_CHANGE('<?php print $type; ?>');"
                               class=" <?php print $additional_classes_for_shipping; ?> " />
                    </div>
                    <div class="lineTextHeight22 marginBottom2px">
                        <input type="text" id="address_3_<?php print $type; ?>" name="address_3_<?php print $type; ?>" value=""
                               onkeyup="TekstHelperBSM.TH.removeComma(this);
                                BillingShipingModerator.BSM.ON_CHANGE('<?php print $type; ?>');"
                               class=" <?php print $additional_classes_for_shipping; ?> " />
                    </div>
                    <div class="lineTextHeight22 marginBottom2px">
                        <input type="text" id="city_<?php print $type; ?>" name="city_<?php print $type; ?>" value=""
                               onkeyup="TekstHelperBSM.TH.removeComma(this);
                                BillingShipingModerator.BSM.ON_CHANGE('<?php print $type; ?>');"
                               class="validate[required]  <?php print $additional_classes_for_shipping; ?>  " />
                    </div>
                    <div class="lineTextHeight22 marginBottom2px">
                        <select id="CBProvince_<?php print $type; ?>" name="CBProvince_<?php print $type; ?>" 
                                class="width100Percent validate[required]  <?php print $additional_classes_for_shipping; ?>  " 
                                onchange="BillingShipingModerator.BSM.setupProvince('<?php print $type; ?>');
                                BillingShipingModerator.BSM.ON_CHANGE('<?php print $type; ?>');
        <?php
        if ($type == self::TYPE_SHIPING) {
            print 'OrderTotalAmount.OTA.calculate();';
        }
        ?>" class="validate[required]" >
                            <option value="">Provinces</option>
        <?php
        HELPWordpress::PRIN_ALL_CANADA_PROVINCIES_OPTIONS();
        ?>
                            <option value="">States</option>
                               <?php
                               HELPWordpress::PRIN_ALL_USA_STATES_OPTIONS();
                               ?>
                        </select>
                        <!--
                        <input type="text" id="province" name="province" value="" />
                        -->
        <?php
        RightForms::CREATE_INPUTS_INVISIBLE(array("province_" . $type), array("Provinces"));
        ?>
                    </div>
                    <div class="lineTextHeight22 marginBottom2px">
                        <input type="text" id="postalCode_<?php print $type; ?>" name="postalCode_<?php print $type; ?>" value=""
                               onkeyup="TekstHelperBSM.TH.removeComma(this);
                                BillingShipingModerator.BSM.ON_CHANGE('<?php print $type; ?>');"
                               class="validate[required]   <?php print $additional_classes_for_shipping; ?> " />
                    </div>
                    <div class="lineTextHeight22 marginBottom2px">
                        <input type="text" id="phone_<?php print $type; ?>" name="phone_<?php print $type; ?>" value=""
                               onkeyup="TekstHelperBSM.TH.removeComma(this);
                                BillingShipingModerator.BSM.ON_CHANGE('<?php print $type; ?>');"
                               class="validate[required]  <?php print $additional_classes_for_shipping; ?>  " />
                    </div>
                    <div class="lineTextHeight22 marginBottom2px">
                        <input type="text" id="email_<?php print $type; ?>" name="email_<?php print $type; ?>" value=""
                               onkeyup="TekstHelperBSM.TH.removeComma(this);
                                BillingShipingModerator.BSM.ON_CHANGE('<?php print $type; ?>');"
                               class="validate[required]  <?php print $additional_classes_for_shipping; ?>  " />
                    </div>
                </div>
            </div>
            <script>
            $("#postalCode_TYPE_SHIPING").change(function()
            {
                //Delivery.D.setup_delivery_details();
            });
            $("#postalCode_TYPE_SHIPING").keyup(function()
            {
                Delivery.D.tryToSetupAfterDelay();
            });
            $(".text_shiping_key_up").keyup(function(e)
            {
                $(".cbDoShippingSameAsBilling").prop("checked", false);
                $("#SameAsBillingDetails").val("false");
            });
            $(".onchange_shipping_select").change(function(e)
            {
                $(".cbDoShippingSameAsBilling").prop("checked", false);
                $("#SameAsBillingDetails").val("false");
            });
            </script>
        <?php
        if ($type == self::TYPE_BILLING) {
            RightForms::CREATE_INPUTS_INVISIBLE(array("isBillToAlternativeName"), array(""));
        } else if ($type == self::TYPE_SHIPING) {
            RightForms::CREATE_INPUTS_INVISIBLE(array("isShipToDifferentAddress"), array(""));
        }
        ?>
            <div class="clearBoth"></div>
        </div>
        <?php
    }

    ////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////
    public function draw_methodOfPayment() {
        ?>
        <div class="holderRightParceForm">
            <div class="titleRightForm">Method Of Payment</div>
            <div class="holderRightParceForm___intoForm">
                <div>
                    <div>
                        <div class="floatLEft width100px">
                            <input class="invoice_details" type="checkbox" id="MOP_directDebit" onClick="MOP.M.setVariablesForMOP();" />
                            Direct Debit
                        </div>
        <?php
        if (self::$IS_FOR_SHOWING_ORDER_FOR_ADMIN) {
            ?>
                            <div class="floatLEft width100px">
                                <input type="checkbox" id="MOP_Cash" name="MOP_Cash" onClick="MOP.M.setVariablesForMOP();" /> Cash
                            </div>
                            <div class="floatLEft ">
                                <input type="checkbox" id="MOP_Cheque" name="MOP_Cheque" onClick="MOP.M.setVariablesForMOP();" /> Cheque
                            </div>
            <?php
        }
        ?>
                        <div class="clearBoth"></div>
                    </div>
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
                    <div class="">
                        <div class="floatLEft width100px">
                            <input class="invoice_details" type="checkbox" id="MOP_Visa" onClick="MOP.M.setVariablesForMOP();" />Visa
                        </div>
                        <div class="floatLEft width100px">
                            <input class="invoice_details" type="checkbox" id="MOP_Mastercart" onClick="MOP.M.setVariablesForMOP();" />Mastercard
                        </div>
                        <div class="clearBoth"></div>
                    </div>


                    <!--
                      on document ready invoice_details is adding event on click on the check boxes
                      when click that check boxes invoice comment got blank texts
                      PAID BY VISA #nnnn AUTH# ______
                                                      OR
                                                      PAID BY MC #nnnn AUTH# ______
                                                      OR
                                                      PAID PRE-AUTH DEBIT B# ______
                    -->
                </div>
                <br />
                <div>
                    Card Number: 
                    <input type="text" id="MOP_cardNum" name="MOP_cardNum" 
                           class=" input_just_numeric" maxlength="16" style="width:130px;" />&nbsp;&nbsp;
                    CSV: <input name="MOPcsv" id="MOPcsv" type="text" maxlength="3" style="text-align:center; width:30px;" />
                    <script>
        $("#MOP_cardNum").keyup(function(e)
        {
            if ($(this).val() != "")
            {
                $(this).addClass("validate[optional,minSize[16], maxSize[16]]");
            }
            else
            {
                $(this).removeClass("validate[optional,minSize[16], maxSize[16]]");
            }
        });
                    </script>
                </div>
                <br />
                <div>
                    Expiry Month: 
                    <select id="MOP_expMonth" onChange="MOP.M.setVariablesForMOP();">
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
                    <select id="MOP_expYear" onChange="MOP.M.setVariablesForMOP();">
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
                    <script>
        var date = new Date();
        $("#MOP_expMonth").prop("selectedIndex", date.getMonth());
        $("#MOP_expYear").prop("selectedIndex", date.getFullYear() - 2011);
                    </script>
                </div>
                <br />
                <div>
                    <input type="checkbox" id="MOP_pleaseCallMe" onClick="MOP.M.setVariablesForMOP();" />Please call me for my Credit Card Number
                </div>
                <script>
             MOP.M.addEventListenerToCB();
                </script>
            </div>
            <div class="clearBoth"></div>
        </div>
        <script>
            $("#MOP_cardNum").keyup(function(e)
            {
                if ($(this).val().substring(0, 1) == "4")
                {
                    MOP.M.selectPayment(0);
                }
                else if ($(this).val().substring(0, 1) == "5")
                {
                    MOP.M.selectPayment(1);
                }
                else
                {
                }
                MOP.M.setVariablesForMOP();
            });
        </script>
        <?php
        RightForms::CREATE_INPUTS_INVISIBLE(array("mopINPUT", "mopExpirtyMonthINPUT", "mopExpirtyYearINPUT", "mopCallMe"), array("", "Jan", "2011", "false"));
    }

    ////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////
    function draw_airmilesRewardMiles() {
        ?>
        <div class="holderRightParceForm">
            <div class="titleRightForm">AIRMILES Reward Miles</div>
            <div class="holderRightParceForm___intoForm">
                Card Number <input type="text" id="AIRMILES_cardNumber" name="AIRMILES_cardNumber" maxlength="11" 
                                   class="input_just_numeric " />
            </div>
            <script>
                $("#AIRMILES_cardNumber").keyup(function(e)
                {
                    if ($(this).val() != "")
                    {
                        $(this).addClass("validate[optional,minSize[11], maxSize[11]]");
                    }
                    else
                    {
                        $(this).removeClass("validate[optional,minSize[11], maxSize[11]]");
                    }
                });
            </script>
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
        <div class="holderRightParceForm orderTotalAmount">
            <div class="titleRightForm">Order Total Amount</div>
            <div class="holderRightParceForm___intoForm paddingLeft30px paddingRight30px">


                <div id="cheques_quantity_amount" class="displayNone">
                    <span class="label">200+100 free</span><span class="price floatRight"><b>$0.00</b></span>
                    <div class="clearBoth"></div>
                </div>
                <div id="deposit_books_amount" class="displayNone">
                    <span class="label">2 copies (Deposit)</span><span class="price floatRight"><b>$0.00</b></span>
                    <div class="clearBoth"></div>
                </div>
                <div id="double_window_enveloper_amount" class="displayNone">
                    <span class="label">250 (DWE)</span><span class="price floatRight"><b>$0.00</b></span>
                    <div class="clearBoth"></div>
                </div>
                <div id="self_seal_dwe" class="displayNone">
                    <span class="label">250 (SSDWE)</span><span class="price floatRight"><b>$0.00</b></span>
                    <div class="clearBoth"></div>
                </div>
                <div id="self_incing_stamp_amount" class="displayNone">
                    <span class="label">One self incing stamp</span><span class="price floatRight"><b>$0.00</b></span>
                    <div class="clearBoth"></div>
                </div>
                <div id="manual_binder_amount" class="displayNone">
                    <span class="label">2 per page binder(this will be for manual)</span><span class="price floatRight"><b>$0.00</b></span>
                    <div class="clearBoth"></div>
                </div>
                <div id="logo_amount" class="displayNone">
                    <span class="label">Attach Logo - Black Ink Only $15 one time charge.</span><span class="price floatRight"><b>$0.00</b></span>
                    <div class="clearBoth"></div> 
                </div>
                <div id="rush_amount_info" class="displayNone">
                    <span class="label">Rush Production</span><span class="price floatRight"><b>$25.00</b></span>
                    <div class="clearBoth"></div> 
                </div>



                <hr />
                <div class="">
                    Shipping:<span class="floatRight" id="shipping_price"><b>$0.00</b></span>
                    <div class="clearBoth"></div>
                </div>
                <div>
                    Sub Total:<span class="floatRight" id="sub_total_products"><b>$0.00</b></span>
                    <div class="clearBoth"></div>
                </div>
                <div>
                    Taxes:<span class="floatRight" id="sub_total_taxes"><b>$0.00</b></span>
                    <div class="clearBoth"></div>
                </div>


                <hr />
                <div>
                    Grand Total:<span class="floatRight" id="grand_total"><b>$0.00</b></span>
                </div>


            </div>
            <div class="clearBoth"></div>
        </div>
        <script>
            function OrderTotalAmount()
            {
                this.percentTaxes = 0;
                this.sub_total_products = function()
                {
                    var total = Quantity_and_Prices.QP.quantityObject().price_abs();

                    total += CompanyInfo.CI.getLogoObjectSelected().price_abs();

                    total += CompanyInfo.CI.getDepositObject().price_abs();
                    total += CompanyInfo.CI.getDWEObject().price_abs();
                    total += CompanyInfo.CI.getSSDWEObject().price_abs();
                    total += CompanyInfo.CI.getAPChequeBinderObject().price_abs();
                    total += CompanyInfo.CI.getAPSelfLinkingShtamp().price_abs();
                    /*
                     if(document.getElementById("rush_25charge_1to5_business_days").checked == true)
                     {
                     total += Delivery.D.getShippingRushChargeObject().price-Delivery.D.getShippingRushChargeObject().discount;
                     }
                     total += Delivery.D.price;
                     */
                    total += Delivery.D.getShipingObject().price_abs();
                    if (isNaN(total))
                    {
                        alert(Delivery.D.getShipingObject().discount);
                    }
                    if (Delivery.D.isRush())
                    {
                        total += Delivery.D.getShippingStandardChargeObject().price_abs();
                    }
                    return total;
                }
                this.sub_total_taxes = function()
                {
                    var percent = TaxesModerator.TM.tax_shipping()/100;
                    //alert(TaxesModerator.TM.tax_shipping());
                    /*
                    var selectedProvinceOrStateOnShiping = document.getElementById("CBProvince_TYPE_SHIPING").selectedIndex;
                    selectedProvinceOrStateOnShiping =
                            document.getElementById("CBProvince_TYPE_SHIPING").options[selectedProvinceOrStateOnShiping].text
                    switch (selectedProvinceOrStateOnShiping)
                    {
                        case "AB":
                            {
                                percent = 5 / 100;
                            }
                            break;
                        case "BC":
                            {
                                percent = 5 / 100;
                            }
                            break;
                        case "MB":
                            {
                                percent = 5 / 100;
                            }
                            break;
                        case "NB":
                            {
                                percent = 13 / 100;
                            }
                            break;
                        case "NL":
                            {
                                percent = 13 / 100;
                            }
                            break;
                        case "NS":
                            {
                                percent = 15 / 100;
                            }
                            break;
                        case "NT":
                            {
                                percent = 5 / 100;
                            }
                            break;
                        case "NU":
                            {
                                percent = 5 / 100;
                            }
                            break;
                        case "ON":
                            {
                                percent = 13 / 100;
                            }
                            break;
                        case "PE":
                            {
                                percent = 5 / 100;
                            }
                            break;
                        case "QC":
                            {
                                percent = 5 / 100;
                            }
                            break;
                        case "SK":
                            {
                                percent = 5 / 100;
                            }
                            break;
                        case "YT":
                            {
                                percent = 5 / 100;
                            }
                            break;
                    }*/
                    this.percentTaxes = Math.round(percent * 10000);
                    this.percentTaxes /= 100;
                    $("#percentTaxesInput").val(this.percentTaxes);
                    return Math.round(this.sub_total_products() * percent * 100) / 100;
                }
                this.grand_total = function()
                {
                    return this.sub_total_products() + this.sub_total_taxes();
                }
                this.shipping_price = function()
                {
                    return Delivery.D.getShippingStandardChargeObject().price_abs();
                }

                this.calculate = function()
                {
                    this.setupInfoAmountProducts();

                    $("#sub_total_products_INPUT").val(this.sub_total_products());
                    $("#shipping_price_INPUT").val(this.shipping_price());
                    $("#sub_total_taxes_INPUT").val(this.sub_total_taxes());
                    $("#grand_total_INPUT").val(this.grand_total());
                    $("#receipt_amount").val(this.grand_total().toFixed(2));
                    document.getElementById("sub_total_products").innerHTML = "<b>$" + this.sub_total_products().toFixed(2) + "</b>";
                    /*
                     if(this.shipping_price() != 0)
                     {
                     document.getElementById("shipping_price").innerHTML = "<b>$"+this.shipping_price().toFixed(2)+"</b>";
                     $("#shipping_price").html("<b>$"+this.shipping_price().toFixed(2)+"</b>");
                     }
                     */
                    /*
                     else if( Cheque.C.type == Cheque.MANUAL && Delivery.D.isRush())
                     {
                     $("#shipping_price").html("<b>We will call to go over pricing.</b>");
                     }*/
                    document.getElementById("shipping_price").innerHTML = "<b>$" + this.shipping_price().toFixed(2) + "</b>";
                    $("#shipping_price").html("<b>$" + this.shipping_price().toFixed(2) + "</b>");
                    if (Delivery.D.isRush())
                    {
        <?php
        if (self::$IS_FOR_SHOWING_ORDER_FOR_ADMIN) {
            ?>
                            //$("#shipping_price").html("<b>$0.00</b>");
        <?php } else { ?>
                            $("#shipping_price").html("<b>We will call to go over pricing.</b>");
        <?php } ?>
                    }
                    document.getElementById("sub_total_taxes").innerHTML = "<b>$" + this.sub_total_taxes().toFixed(2) + "</b>";
                    document.getElementById("grand_total").innerHTML = "<b>$" + this.grand_total().toFixed(2) + "</b>";
                }
                this.setupInfoAmountProducts = function()
                {
                    this.setupInfoAmountProductsPart("cheques_quantity_amount", Quantity_and_Prices.QP.quantityMONEY(),
                            Quantity_and_Prices.QP.quantityTitle() + "(Quantity & Prices)", Quantity_and_Prices.QP.quantityObject());
                    this.setupInfoAmountProductsPart("deposit_books_amount", CompanyInfo.CI.getDepositObject().price,
                            CompanyInfo.CI.APDepositBooks().text + "(Deposit Books)",
                            CompanyInfo.CI.getDepositObject());
                    this.setupInfoAmountProductsPart("double_window_enveloper_amount", CompanyInfo.CI.getDWEObject().price,
                            CompanyInfo.CI.getDWEObject().quantity + " Regular Double Envelopes",
                            CompanyInfo.CI.getDWEObject());
                    this.setupInfoAmountProductsPart("self_seal_dwe", CompanyInfo.CI.getSSDWEObject().price,
                            CompanyInfo.CI.getSSDWEObject().quantity + " Self Seal Double Envelopes",
                            CompanyInfo.CI.getSSDWEObject());
                    this.setupInfoAmountProductsPart("self_incing_stamp_amount", CompanyInfo.CI.getAPSelfLinkingShtamp().price,
                            CompanyInfo.CI.getAPSelfLinkingShtamp().title,
                            CompanyInfo.CI.getAPSelfLinkingShtamp());
                    this.setupInfoAmountProductsPart("manual_binder_amount", CompanyInfo.CI.getAPChequeBinderObject().price,
                            CompanyInfo.CI.getAPChequeBinderObject().title,
                            CompanyInfo.CI.getAPChequeBinderObject());
                    this.setupInfoAmountProductsPart("logo_amount", CompanyInfo.CI.logoPrice(),
                            CompanyInfo.CI.logoTitle(),
                            CompanyInfo.CI.getLogoObjectSelected()
                            );
                    if (Delivery.D.isRush() == true)
                    {
                        var priceRush = Delivery.D.getShippingRushChargeObject().price -
                                Delivery.D.getShippingRushChargeObject().discount;
                        $("#rush_amount_info").removeClass("displayNone");
                        $($("#rush_amount_info").find(".price").get(0)).html("<b>$" + parseFloat(priceRush).toFixed(2) + "</b>");
                        $(".shippingChargeFormInfoPrice").html("$0.00");
                    }
                    else
                    {
                        $("#rush_amount_info").addClass("displayNone");
                        var priceOrder = Delivery.D.getShippingStandardChargeObject().price -
                                Delivery.D.getShippingStandardChargeObject().discount;
                        //alert(parseFloat(priceOrder).toFixed(2));
                        //alert(Delivery.D.getShippingStandardChargeObject().discount);
                        $(".shippingChargeFormInfoPrice").html("$" + parseFloat(priceOrder).toFixed(2));
                        if (Delivery.D.getShippingStandardChargeObject().isWeWillCall == true)
                        {
                            $(".shippingChargeFormInfoPrice").html
                                    (
                                            "We will call to go over pricing."
                                            );
                        }
                    }
                }
                this.setupInfoAmountProductsPart = function(infoDivID, priceForTheProduct, LabelForTheProduct, objectDetails)
                {
                    if (objectDetails == null)
                    {
                    }
                    if (priceForTheProduct == 0)
                    {
                        $("#" + infoDivID).addClass("displayNone");
                    }
                    else
                    {
                        $("#" + infoDivID).removeClass("displayNone");
                        $($("#" + infoDivID).find(".label").get(0)).html(LabelForTheProduct);
                        /*
                         if(objectDetails.discount != null && objectDetails.discount != 0)
                         {
                         var newPrice = priceForTheProduct-objectDetails.discount;
                         $($("#"+infoDivID).find(".price").get(0)).html("<b>$"+parseFloat(newPrice).toFixed(2)+"</b>");
                         }
                         else
                         {
                         $($("#"+infoDivID).find(".price").get(0)).html("<b>$"+parseFloat(priceForTheProduct).toFixed(2)+"</b>");
                         }*/
                        $($("#" + infoDivID).find(".price").get(0)).html("<b>$" + parseFloat(objectDetails.price_abs()).toFixed(2) + "</b>");
                    }
                }
            }
            OrderTotalAmount.OTA = new OrderTotalAmount();
        </script>
        <?php
        RightForms::CREATE_INPUTS_INVISIBLE(array("sub_total_products_INPUT", "shipping_price_INPUT", "sub_total_taxes_INPUT", "grand_total_INPUT", "percentTaxesInput"), array("0", "0", "0", "0", "0"));
    }

    /////////////////////////////////////////////////////////////////////////
    /*
     * It is using just for search form
     * */
    public function draw_Email_Discount_Code() {
        ?>
        <div class="holderRightParceForm">
            <div class="titleRightForm">Email Discount Code </div>
            <div class="holderRightParceForm___intoForm paddingLeft30px paddingRight30px alignCenter">
                <input readonly label_for_pop_up="Email Discount Code" 
                       class="width70px alignCenter inputs_setting_editors" 
                       type="text" id="email_discount_code" name="email_discount_code"
                       value="<?php print SettingsModerator::$SETT->email_discount_code; ?>" />
                <!--
                        Value should be setup by loading post variables
                -->
            </div>
        </div>
        <?php
    }

    //////////////////////////////////////////////////////////////////////////
    public function draw_SubmitOrderBTN() {
        ?>
        <script>
            $(document).ready(function(e)
            {
                if (document.getElementById("form") != null)
                {
                    document.getElementById("form").action = SentEmail.SE.form_action();
                }
            });
        </script>
        <div class="btnORDERCHEQUE">
            <!--
            <img align="absmiddle" onclick="objSentEmail.SEND();" 
            src="<?php print HELPWordpress::template_url(); ?>/images/SUBMIT-ORDER-BUTTON-GREEN.png" />
            -->
            <input type="button" class="button_submit_order" value="" />
        </div>
        <script>
            $(".button_submit_order").click(function(e)
            {
                //alert($("#shipping_charge_select_company").val());
        <?php
        if (self::$IS_FOR_SHOWING_ORDER_FOR_ADMIN) {
            ?>
                    var message_extra = "";
                    if ($("#cb_update_current_order").prop("checked"))
                    {
                        message_extra = "Update Current Order";
                    }
                    else if ($("#cb_create_new_order").prop("checked"))
                    {
                        message_extra = "Create New Order";
                    }
                    else
                    {
                        $("#form").submit();
                        return;
                    }
                    if (confirm("Submit Order?\nCONFIRM THAT YOU WANT\n" + message_extra))
                    {
                        $("#form").submit();
                    }
            <?php
        } else {
            ?>
                    $("#form").submit();
            <?php
        }
        ?>
            });
        </script>
        <?php
    }

    public function draw_AknowlegementsExplanations() {
        $widthAknowLefgementsDiv = 0;
        if ($this->cheque->type == Cheque::TYPE_LASER) {
            $widthAknowLefgementsDiv = 305;
        } else if ($this->cheque->type == Cheque::TYPE_MANUAL) {
            $widthAknowLefgementsDiv = 390;
        }
        ?>
        <div style=" display: inline !important;" class="alignCenter">
            <!--
            <div class="floatLEft" style="width:<?php print $widthAknowLefgementsDiv; ?>px;">
                    Ordering your business cheques couldnt be simpler ... fill out the information
                on the RIGHT to see the changes to the demo cheque in the middle of the page.<br /><br />
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
            -->
        <?php
        if ($this->cheque->type == Cheque::TYPE_MANUAL) {
            ?>
                <div class="paddingLeft30px">
                    <img src="<?php print HELPWordpress::template_url(); ?>/images/manual-special-offer-button.png">
                    <img class="marginLeft30px" src="<?php print HELPWordpress::template_url(); ?>/images/to-place-an-order-button.png">
                </div>
            <?php
        } else if ($this->cheque->type == Cheque::TYPE_LASER) {
            ?>
                <img src="<?php print HELPWordpress::template_url(); ?>/images/to-place-an-order-large-blu.png">
            <?php
        }
        ?>
        </div>
        <script>

        </script>
        <?php
    }

    /////////////////////////////////////////////////////////////////////////
    //////////////////////////////////////////////////////////////////////////
    /////////////////////////////////////////////////////////////////////////
    public function draw_create_invoice_button() {
        ?>
        <div class="borderStyleSolid paddingTop20px">
            <div class="padding10px">
                <div class="">
                    <div class="floatLEft">
                        Authorization #
                    </div>	
                    <div class="floatRight">
                        <input type="text" name="authorization_number" id="authorization_number" class="width200px text_input_invoice_comment_setup" />
                    </div>
                    <div class="clearBoth"></div>
                </div>
                <div class="marginTop5px">
                    <div class="floatLEft">
                        Batch #
                    </div>	
                    <div class="floatRight">
                        <input type="text" name="batch_number" id="batch_number" class="width200px text_input_invoice_comment_setup" />
                    </div>
                    <div class="clearBoth"></div>
                </div>
                <div class="marginTop5px">
                    <div class="floatLEft">
                        Receipt #
                    </div>	
                    <div class="floatRight">
                        <input type="text" name="receipt_number" id="receipt_number" class="width200px text_input_invoice_comment_setup" />
                    </div>
                    <div class="clearBoth"></div>
                </div>
                <script>
                    $(".text_input_invoice_comment_setup").keyup(function(e)
                    {
                        CreatingInvoiceForAdditionalProducts.CIFAP.set_invoice_comment_depend_of_the_mop();
                    });
                </script>
                <!--
                <div class="marginTop5px">
                        <div class="floatLEft">
                                Comments
                        </div>	
                        <div class="floatRight">
                                <textarea name="receipt_comments" id="receipt_comments" style="height: 100px;"></textarea>
                        </div>
                        <div class="clearBoth"></div>
                </div>
                -->
                <div class="marginTop5px">
                    <div class="floatLEft">
                        Amount
                    </div>	
                    <div class="floatRight">
                        <input disabled="disabled" type="text" name="receipt_amount" id="receipt_amount" />
                    </div>
                    <div class="clearBoth"></div>
                </div>
            </div>
            <div class="alignCenter">
                <textarea style="height:100px; width:260px;" name="invoice_additiona_customer_code" id="invoice_additiona_customer_code"></textarea>
            </div>
            <div class="">
                <div class="padding25px ">
                    <input class="invoice_send_email_options" type="checkbox" name="invoice_email_sending_options" id="cb_invoice_send_to_billing_address" value="invoice to Billing Email address" /> invoice to Billing Email address
                    <br/>
                    <input class="invoice_send_email_options" type="checkbox" name="invoice_email_sending_options" id="cb_invoice_send_to_custom_email_address" value="custom email" /> <input class="inputOnFocusInOut" value="enter email address" name="enter_email_address_for_invoice" id="enter_email_address_for_invoice" type="text" />
                    <br/>
                    <input class="invoice_send_email_options" type="checkbox" name="invoice_email_sending_options" id="cb_invoice_do_not_sent_email" value="NO EMAIL SENT" /> NO EMAIL SENT
                    <div class="marginTop5px">
                        <div>
                            <div class="floatLEft">
                                <input value="Paid" type="radio" name="invoice_paid_or_outstanding" />Paid
                            </div>
                            <div class="floatLEft marginLeft30px">
                                <input value="Outstanding" type="radio" name="invoice_paid_or_outstanding" />Outstanding
                            </div>
                            <script>

                                //alert($("input:radio[name='invoice_paid_or_outstanding']:checked").val());
                                $(':radio[name=invoice_paid_or_outstanding][value="<?php print $_POST["invoice_paid_or_outstanding"]; ?>"]').prop('checked', true);
                            </script>
                        </div>
                        <div class="clearBoth"></div>
                    </div>
                </div>
                <div>
                    <div class="floatLEft width100px alignLeft line lineTextHeight22 paddingLeft10px">INVOICE DATE</div>
                    <div class="floatLEft">
                        <input class="width100px" type="text" id="order_updated_date_invoice" />
                    </div>
                    <div class="clearBoth"></div>
                </div>
                <!--
                    <div class="marginTop20px">
                        <div class="floatLEft width100px alignLeft lineTextHeight22 paddingLeft10px">FILE APPROVAL</div>
                            <div class="floatLEft">
                                    <select id="file_approval_drop_down" name="file_approval_drop_down">
                                        <option value=""></option>

                                        <option value="ONLINE-JG">ONLINE-JG</option>
                                        <option value="ONLINE-EG">ONLINE-EG</option>
                                        <option value="ONLINE-RB">ONLINE-RB</option>
                                        <option value="ONLINE-HJ">ONLINE-HJ</option>
                                        <option value="ONLINE-RG">ONLINE-RG</option>
                                        <option value="ONLINE-TG">ONLINE-TG</option>

                                        <option value="LOCAL-JG">LOCAL-JG</option>
                                        <option value="LOCAL-EG">LOCAL-EG</option>
                                        <option value="LOCAL-RB">LOCAL-RB</option>
                                        <option value="LOCAL-HJ">LOCAL-HJ</option>
                                        <option value="LOCAL-RG">LOCAL-RG</option>
                                        <option value="LOCAL-TG">LOCAL-TG</option>
                                    </select>
                                </div>
                        <div class="clearBoth"></div>
                    </div>
                -->
                <div>
                    <div class="floatLEft width100px alignLeft lineTextHeight22 paddingLeft10px fontSize10px">
                        INVOICE APPROVAL
                    </div>
                    <div class="floatLEft">
                        <select id="invoice_approval_drop_down" name="invoice_approval_drop_down">
                            <option value=""></option>

                            <option value="JG">JG</option>
                            <option value="EG">EG</option>
                            <option value="RB">RB</option>
                            <option value="HJ">HJ</option>
                            <option value="RG">RG</option>
                            <option value="TG">TG</option>
                        </select>
                    </div>
                    <div class="clearBoth"></div>
                </div>
                <div>
                    <div class="floatLEft width100px alignLeft lineTextHeight22 paddingLeft10px">
                        NEXT START #
                    </div>
                    <div class="floatLEft">
                        <input class="width100px" id="next_start_number_input" name="next_start_number_input"
                               type="text" readonly="readonly" />
                    </div>
                    <div class="clearBoth"></div>
                </div>
                <script>
                    $("#enter_email_address_for_invoice").attr("value_default", "enter email address");
                </script>
            </div>
            <script>
                //getDate is function for getting current date
                $("#order_updated_date_invoice").datepicker();
                $("#ui-datepicker-div").css("font-size", "65%");
                $("#order_updated_date_invoice").change(function(e)
                {
                    $("#order_updated_date_invoice_value").val($("#order_updated_date_invoice").datepicker("getDate").getTime());
                    $("#receipt_date").datepicker("setDate", $("#order_updated_date_invoice").datepicker("getDate"));
                });
        <?php if ($_POST["order_updated_date_invoice_value"] != "") { ?>
                    $("#order_updated_date_invoice").datepicker("setDate", new Date(<?php print $_POST["order_updated_date_invoice_value"]; ?>));
        <?php } ?>
            </script>
            <div class="btnORDERCHEQUE marginTop20px">
                <img align="absmiddle" 
                     onclick="CreatingInvoiceForAdditionalProducts.CIFAP.create(CreatingInvoiceForAdditionalProducts.TYPE_INVOICE);" 
                     src="<?php print HELPWordpress::template_url(); ?>/images/create-invoice-button.jpg" />
            </div>
            <div class="alignCenter">
                <input type="button" value="View Last Created Invoice" id="view_invoice_button" />
                <script>
                            $("#view_invoice_button").click(function(e)
                            {
                                LightBox.LB.show(CreatingInvoiceForAdditionalProducts.CIFAP.invoice_path_for_viewing());
                            });
                </script>
            </div>
            <hr />
            <div class="marginTop20px padding10px">
                <div class="marginTop5px">
                    <div class="floatLEft">
                        RECEIPT DATE
                    </div>	
                    <div class="floatRight">
                        <input type="text" name="receipt_date" id="receipt_date" />
                    </div>
                    <div class="clearBoth"></div>
                </div>
                <!--
                <div class="marginTop5px">
                        <div class="floatLEft">
                        </div>	
                        <div class="floatRight">
                                <select name="receipt_method_of_payment" id="receipt_method_of_payment">
                                        <option value="">Method of Payment</option>
                                        <option value="Visa">Visa</option>
                                        <option value="Mastercard">Mastercard</option>
                                        <option value="Cheque">Cheque</option>
                                        <option value="Cash">Cash</option>
                                        <option value="Email Transfer">Email Transfer</option>
                                </select>
                        </div>
                        <div class="clearBoth"></div>
                </div>
                -->
                <div class="marginTop20px alignCenter btnORDERCHEQUE btn_receipt_create">
                    <img src="<?php print HELPWordpress::template_url(); ?>/images/receipt-button.jpg" />
                </div>

                <div class="holderRightParceForm___intoForm paddingLeft30px paddingRight30px alignCenter">
                    Email Discount Code: <input label_for_pop_up="Email Discount Code" 
                                                class="width70px alignCenter" 
                                                type="text" id="email_discount_code" name="email_discount_code"
                                                value="<?php print SettingsModerator::$SETT->email_discount_code; ?>" />
                    <!--
                            Value should be setup by loading post variables
                    -->
                </div>
                <script>
                    $(".btn_receipt_create").click(function(e)
                    {
                        CreatingInvoiceForAdditionalProducts.CIFAP.create(CreatingInvoiceForAdditionalProducts.TYPE_RECEIPT);
                    });

                    $("#receipt_date").datepicker();
                    $("#ui-datepicker-div").css("font-size", "65%");
                    $("#receipt_date").change(function(e)
                    {
                        $("#receipt_date_value").val($("#receipt_date").datepicker("getDate").getTime());
                    });
        <?php if ($_POST["receipt_date_value"] != "") { ?>
                        $("#receipt_date").datepicker("setDate", new Date(<?php print $_POST["receipt_date_value"]; ?>));
        <?php } ?>
                </script>
            </div>
        </div>
        <script>

            function InvoiceModerator()
            {
                this.setup_email_indexes = function()
                {
                    $("#invoice_email_sent_to").val(this.send_to_billing_address() + "," + this.send_to_custom_address());
                }
                this.send_to_billing_address = function()
                {
                    if ($("#cb_invoice_do_not_sent_email").prop("checked")) {
                        return "0";
                    }
                    if ($("#cb_invoice_send_to_billing_address").prop("checked")) {
                        return "1";
                    }
                    return "0";
                }
                this.send_to_custom_address = function()
                {
                    if ($("#cb_invoice_do_not_sent_email").prop("checked")) {
                        return "0";
                    }
                    if ($("#cb_invoice_send_to_custom_email_address").prop("checked")) {
                        return "1";
                    }
                    return "0";
                }
                $(".invoice_send_email_options").click(function(e)
                {
                    InvoiceModerator.IM.setup_email_indexes();
                });
            }
            InvoiceModerator.IM = new InvoiceModerator();

        </script>
        <?php
        RightForms::CREATE_INPUTS_INVISIBLE(array("order_updated_date_invoice_value", "invoice_email_sent_to",
            "receipt_date_value"), array("", "0,0", ""));
        ?>
        <?php
    }

    //////////////////////////////////////////////////////////////////////////
    /////////////////////////////////////////////////////////////////////////
    //////////////////////////////////////////////////////////////////////////
    static function CREATE_INPUTS_INVISIBLE($arr = NULL, $arrVALUES = NULL) {
        $value = "";
        for ($i = 0; $i < count($arr); $i++) {
            $value = "";
            if ($arrVALUES != NULL && $arrVALUES[$i] != NULL) {
                $value = $arrVALUES[$i];
            }
            ?>
            <input style="width:90%; font-size:10px;" type="hidden" name="<?php print $arr[$i]; ?>" id="<?php print $arr[$i]; ?>" value="<?php print $value; ?>">
            <?php
        }
    }

}
?>