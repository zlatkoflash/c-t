<?php

class AdminEditorAdditional {

    public static function XML_ORDER_PATH() {
        return
                SETTINGS::ORDERS_FOLDER_FOR_XML___ADMIN_SECTION . $_POST["fso_order_number"] . ".xml";
    }

    public static function ADD_ALL_VALUES_TO_POST() {
        if ($_POST["fso_order_number"] == "new-manual") {
            $_POST["chequeType"] = Cheque::TYPE_MANUAL;
        } else if ($_POST["fso_order_number"] == "new-laser") {
            $_POST["chequeType"] = Cheque::TYPE_LASER;
        } else {
            XMLParser::ADD_ORDER_XML_TO_POST(AdminEditorAdditional::XML_ORDER_PATH(), false);
            /*
             * */
            $counter = 0;
            foreach (XMLParser::$VARIABLES as $variable => $value) {
                //print "{".$variable."=>".$value."}";
                if (strpos($variable, "#") === false) {
                    $_POST[$variable] = $value;
                }
            }
        }
    }

    public static function SHOW_EDITING_FORM($cheque, $RightFObject) {
        ?>
        <script>
            //document.getElementById("adminSimpleUpdateForm").style.display = "none";
            $("#adminSimpleUpdateForm").removeClass("width500PX");
            $("#adminSimpleUpdateForm").addClass("width600PX");

            HELPER.H.URL = "<?php print HELPWordpress::url(); ?>";
            Cheque.C.setType("<?php print $cheque->type; ?>");
            Cheque.IS_FOR_ADMIN = true;
        </script>

        <form id="form" action="#" enctype="multipart/form-data" method="post">
            <!--Left part of form-->
            <div id="admin_left_part" class="floatLEft">
                <input type="hidden" name="user_is_logged" value="yes" />
                <input type="hidden" name="update_order_please" value="true" />
                <input type="hidden" id="fso_order_number" name="fso_order_number" value="<?php print $_POST["fso_order_number"]; ?>" />
                <!--
                <input type="text" id="fso_admin_submit_additions" name="fso_admin_submit_additions" value="0,0,0" />
                -->
        <?php
        RightForms::CREATE_INPUTS_INVISIBLE(array("fso_admin_submit_additions"), array("0,0,0"));
        ?>
        <?php
        //print_r( $_POST );
        if (isset($_POST["setupNewVariable_from_admin"])) {
            ?>
                    <input type="hidden" id="setupNewVariable" name="setupNewVariable" value="true" />
                    <?php
                } else {
                    ?>
                    <input type="hidden" id="setupNewVariable" name="setupNewVariable" value="false" />
                    <?php
                }
                ?>
                <div class="marginBottom10px">
                    <div>
                        <input type="checkbox" id="cb_update_current_order" name="order_action_type" value="update" class="validate[required]" 
                               />Update Current Order <b>
                <?php
                /*
                  print_r( $_POST );
                  print "[".$_POST["orderNumber"]."]";
                 */
                print OrdersDatabase::GET_ORDER_POWER($_POST["fso_order_number"]);
                ?></b>
                        <script>
                            $("#cb_update_current_order").click(function(me)
                            {
                                OrderNumber.ON.setupOrderForAdmin__newOrderYesOrNO(false);
                                CreatingInvoiceForAdditionalProducts.CIFAP.reset_approval_drop_box();
                            });
                        </script>
                    </div>
                    <div>
                        <input type="checkbox" id="cb_create_new_order" name="order_action_type" value="new_order" class="validate[required]" 
                               />
                        Create New Order
                        <script>
                            $("#cb_create_new_order").click(function(me)
                            {
                                OrderNumber.ON.setupOrderForAdmin__newOrderYesOrNO(true);
                                CreatingInvoiceForAdditionalProducts.CIFAP.reset_approval_drop_box_empthy();
                                RightAdminForms.RAF.put_inputs_empthy();
                                $("input[name=cheque_logo_proof_required]").prop("checked", false);
                                $("#file_approval_drop_down").prop("selectedIndex", 0);
                                $("#authorization_number").val("");
                                $("#batch_number").val("");
                                $('input[name=invoice_paid_or_outstanding]').attr('checked', false);
                                $("#order_updated_date_invoice").val("");
                                $("#invoice_approval_drop_down").prop("selectedIndex", 0);
                                $("#receipt_date").val("");
                                $("#receipt_number").val("");
                                $("#invoice_additiona_customer_code").val("");
                            });
                        </script>
                    </div>
                    <br />
                    <div>
                        <b>Send to PrintNow Email Below</b><br />
                        <div>
                            <div class="floatLEft">
                                <input type="checkbox" id="cbSendToPrintNowEmail" checked="checked" onclick="SubmitAdminAdditions.SAA.setupAdditions()" />
                            </div>
                            <script>

                                                            $(document).ready(function(e)
                                                            {
                                                                SubmitAdminAdditions.SAA.setupAdditions();
                                                            });

                            </script>
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
                        <script>
                                                            $(document).ready(function(e)
                                                            {
                                                                SubmitAdminAdditions.SAA.setupEmailForPrintNow();
                                                            });
                        </script>
                    </div>
                    <br />
                    <div>
                        <input class="validate[required]" type="checkbox" " value="send email to customer" name="cb__sendCustomer_Email" id="cbSentEmailToCustomer" onclick="SubmitAdminAdditions.SAA.setupAdditions();" />
                        <b>Send email to customer</b><br />
                        <input class="validate[required]" type="checkbox" value="second_email_for_customer" name="cb__sendCustomer_Email" id="cbSentSEcondEmailToCustomer" onclick="SubmitAdminAdditions.SAA.setupAdditions();" />
                        <input id="admin_second_email_for_customer" name="admin_second_email_for_customer" 
                               type="text" class="inputOnFocusInOut" value="2d email for customer" />
                        <br />
                        <input class="validate[required]" type="checkbox" value="do_not_send_customer_email" name="cb__sendCustomer_Email" id="cb_doNotSentEmailToCustomerFromAdmin" onclick="SubmitAdminAdditions.SAA.setupAdditions();" />
                        <b>Do Not Send Customer Email</b>
                        <script>
                                                            $("#admin_second_email_for_customer").attr("value_default", "2d email for customer");
                        </script>
                    </div>
                    <br />
                    <div>
                        <input value="A" class="validate[required] checkbox" type="checkbox" id="sales_person_code_show_cb" name="sales_person_code_show_cb" />
                        <select id="sales_person_code_show_select">
                            <option value="">SALES PERSON CODES</option>
                            <option value="IN11R">IN11R</option>
                            <option value="IN11R">IN12R</option>
                            <option value="IN13N">IN13N</option>
                            <option value="IN13R">IN13R</option>
                            <option value="IN14N">IN14N</option>
                            <option value="IN14R">IN14R</option>
                            <option value="JG10R">JG10R</option>
                            <option value="JG11R">JG11R</option>
                            <option value="JG12N">JG12N</option>
                            <option value="JG12R">JG12R</option>
                            <option value="JG13N">JG13N</option>
                            <option value="JG13R">JG13R</option>
                            <option value="JG14N">JG14N</option>
                            <option value="JG14R">JG14R</option>
                            <option value="PC13N">PC13N</option>
                            <option value="PC13R">PC13R</option>
                            <option value="PC14N">PC14N</option>
                            <option value="PC14R">PC14R</option>
                            <option value="TG10R">TG10R</option>
                            <option value="TG11R">TG11R</option>
                            <option value="TG12R">TG12R</option>
                            <option value="TG13N">TG13N</option>
                            <option value="TG13R">TG13R</option>
                            <option value="TG14N">TG14N</option>
                            <option value="TG14R">TG14R</option>
                        </select>
                        <br />
                        <input value="A" class="validate[required] checkbox" type="checkbox" id="order_entered_by_show_cb" name="order_entered_by_show_cb" />
                        <select id="order_entered_by_show_select">
                            <option value="">ORDER ENTERED BY</option>
                            <option value="EG">EG</option>
                            <option value="HJ">HJ</option>
                            <option value="JG">JG</option>
                            <option value="RB">RB</option>
                            <option value="RG">RG</option>
                            <option value="TG">TG</option>
                        </select>
        <?php
        RightForms::CREATE_INPUTS_INVISIBLE
                (
                array("sales_person_code_order_entered_by"), array("-1;;-1;")
        );
        ?>
                        <script>
                            $("#sales_person_code_show_select").change(function(e)
                            {
                                if ($("#sales_person_code_show_select").prop("selectedIndex") > 0)
                                {
                                    $("#sales_person_code_show_cb").validationEngine("hide");
                                    $("#sales_person_code_show_cb").prop("checked", true);
                                }
                            });
                            $("#order_entered_by_show_select").change(function(e)
                            {
                                if ($("#order_entered_by_show_select").prop("selectedIndex") > 0)
                                {
                                    $("#order_entered_by_show_cb").validationEngine("hide");
                                    $("#order_entered_by_show_cb").prop("checked", true);
                                }
                            });
                            function SalesPersonCodes__OrderEntered()
                            {
                                this.sales_person_code = function()
                                {
                                    if ($("#sales_person_code_show_cb").prop("checked") &&
                                            $("#sales_person_code_show_select").prop("selectedIndex") > 0
                                            )
                                    {
                                        return $("#sales_person_code_show_select").val();
                                    }
                                    else
                                    {
                                        return "";
                                    }
                                }
                                this.order_entered_by = function()
                                {
                                    if ($("#order_entered_by_show_cb").prop("checked") &&
                                            $("#order_entered_by_show_select").prop("selectedIndex") > 0
                                            )
                                    {
                                        return $("#order_entered_by_show_select").val();
                                    }
                                    else
                                    {
                                        return "";
                                    }
                                }
                                this.on_change = function()
                                {
                                    $("#sales_person_code_order_entered_by").val(
                                            $("#sales_person_code_show_select").prop("selectedIndex") + ";" + this.sales_person_code()
                                            + ";" + $("#order_entered_by_show_select").prop("selectedIndex") + ";" + this.order_entered_by());
                                    if ($("#sales_person_code_show_cb").prop("checked"))
                                    {
                                        $("#sales_person_code_show_select").addClass("validate[required]");
                                    }
                                    else
                                    {
                                        $("#sales_person_code_show_select").removeClass("validate[required]");
                                    }
                                    if ($("#order_entered_by_show_cb").prop("checked"))
                                    {
                                        $("#order_entered_by_show_select").addClass("validate[required]");
                                    }
                                    else
                                    {
                                        $("#order_entered_by_show_select").removeClass("validate[required]");
                                    }
                                }
                                $("#sales_person_code_show_cb").click(function(e)
                                {
                                    SalesPersonCodes__OrderEntered.SPCOE.on_change();
                                });
                                $("#sales_person_code_show_select").change(function(e)
                                {
                                    SalesPersonCodes__OrderEntered.SPCOE.on_change();
                                });
                                $("#order_entered_by_show_cb").click(function(e)
                                {
                                    SalesPersonCodes__OrderEntered.SPCOE.on_change();
                                });
                                $("#order_entered_by_show_select").change(function(e)
                                {
                                    SalesPersonCodes__OrderEntered.SPCOE.on_change();
                                });
                            }
                            SalesPersonCodes__OrderEntered.SPCOE = new SalesPersonCodes__OrderEntered();
        <?php
        $variables = explode(";", $_POST["sales_person_code_order_entered_by"]);
        ?>

                            $("#sales_person_code_show_select").prop("selectedIndex", "<?php print $variables[0]; ?>");
        <?php if ($variables[1] != "") { ?>
                                $("#sales_person_code_show_cb").prop("checked", true);
        <?php } ?>
                            $("#order_entered_by_show_select").prop("selectedIndex", "<?php print $variables[2]; ?>");
        <?php if ($variables[3] != "") { ?>
                                $("#order_entered_by_show_cb").prop("checked", true);
        <?php } ?>
                        </script>
                    </div>
                    <br />
                    <div>
                        <div>
                            <div class="floatLEft width100px alignCenter">ORDER SUBMITTED<br />DATE</div>
                            <div class="floatLEft "><input class="width100px" type="text" id="order_submited_date" /></div>
                            <div class="clearBoth"></div>
                        </div>
                        <div>
                            <div class="floatLEft width100px alignCenter">ORDER UPDATED<br />DATE</div>
                            <div class="floatLEft"><input class="width100px" type="text" id="order_updated_date" /></div>
                            <div class="clearBoth"></div>
                        </div>
        <?php
        RightForms::CREATE_INPUTS_INVISIBLE
                (
                array("order_submited_date_order_updated_date"), array(";")
        );
        ?>
                        <!--
                        var date;
                                                                date = $( "#searchDateFrom" ).datepicker( "getDate" );
                                                                data["FROM_DATE"] = date.getTime();
                        -->
                    </div>
                    <script>
                        //getDate is function for getting current date
                        $("#order_submited_date").datepicker();
                        $("#ui-datepicker-div").css("font-size", "65%");
                        $("#order_updated_date").datepicker();
                        $("#ui-datepicker-div").css("font-size", "65%");
                        <?php
                        $variables = explode(";", $_POST["order_submited_date_order_updated_date"]);
                        ?>
        <?php
        if (isset($_POST["date_for_new_submited_order"])) {
            /*
              $("#order_submited_date").datepicker("setDate",
              new Date(1000*<?php print $_POST["date_for_new_submited_order"]; ?>) );
             */
            $variables[0] = 1000 * $_POST["date_for_new_submited_order"];
            ?>
                            $("#order_submited_date_order_updated_date").val("<?php print $variables[0]; ?>;<?php print $variables[1]; ?>");
                            //alert(12);
            <?php
        }
        ?>
                        $("#order_submited_date_order_updated_date").val("<?php print $variables[0]; ?>;<?php print $variables[1]; ?>");
        <?php if ($variables[0] != "") { ?>
                            $("#order_submited_date").datepicker("setDate", new Date(<?php print $variables[0]; ?>));
        <?php } ?>
        <?php if ($variables[1] != "") { ?>
                            $("#order_updated_date").datepicker("setDate", new Date(<?php print $variables[1]; ?>));
        <?php } ?>
                        function set_submit_update_date()
                        {
                            var date_order_submited_date = $("#order_submited_date").datepicker("getDate");
                            var date_order_updated_date = $("#order_updated_date").datepicker("getDate");
                            var dateValue = ";";
                            if (date_order_submited_date != null) {
                                dateValue = date_order_submited_date.getTime() + dateValue;
                            }
                            if (date_order_updated_date != null) {
                                dateValue = dateValue + date_order_updated_date.getTime();
                            }
                            $("#order_submited_date_order_updated_date").val(dateValue);
                        }
                        $("#order_submited_date").change(function(e)
                        {
                            set_submit_update_date();
                        });
                        $("#order_updated_date").change(function(e)
                        {
                            set_submit_update_date();
                        });
                    </script>
                    <script>
                        function OrderNumber()
                        {
                            this.fso_order_number = "<?php print $_POST["fso_order_number"]; ?>";
                            this.setupOrderForAdmin__newOrderYesOrNO = function(setupNew)
                            {
                                if (setupNew == true && $("#cb_create_new_order").prop("checked") == true)
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
        <?php
        if (isset($_POST["setupNewVariable_from_admin"]) &&
                $_POST["setupNewVariable_from_admin"] == "true") {
            ?>
                                        document.getElementById("setupNewVariable").value = "it_is_empthy_new_created_from_admin";
            <?php
        }
        ?>
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
                                        this.sentToPrintNow() + "," + this.sentEmailToCustomer() + "," + this.sentToSecondEmailToCustomer();
                            }
                            this.sentToPrintNow = function()
                            {
                                if ($("#cbSendToPrintNowEmail").prop("checked") == true) {
                                    return "1";
                                }
                                return "0";
                            }
                            this.sentEmailToCustomer = function()
                            {
                                if ($("#cb_doNotSentEmailToCustomerFromAdmin").prop("checked")) {
                                    return "0";
                                }
                                if ($("#cbSentEmailToCustomer").prop("checked") == true) {
                                    return "1";
                                }
                                return "0";
                            }
                            this.sentToSecondEmailToCustomer = function()
                            {
                                if ($("#cb_doNotSentEmailToCustomerFromAdmin").prop("checked")) {
                                    return "0";
                                }
                                if ($("#cbSentSEcondEmailToCustomer").prop("checked") == true) {
                                    return "1";
                                }
                                return "0";
                            }
                            this.setupEmailForPrintNow = function()
                            {
                                var emailSelected = document.getElementById("cbEmailForSenrPrintNowOrder").options;
                                emailSelected = emailSelected[document.getElementById("cbEmailForSenrPrintNowOrder").selectedIndex];
                                emailSelected = emailSelected.text;
                                if (emailSelected == "other")
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
                        OrderNumber.ORDER_NUMBER_BASE = "<?php print $_POST["fso_order_number"]; ?>";
                    </script>
                </div>
        <?php
        RightForms::$IS_FOR_SHOWING_ORDER_FOR_ADMIN = true;
        
        //self::$IS_FOR_SHOWING_ORDER_FOR_ADMIN
        TaxesModerator::$TaxesModerator = new TaxesModerator($_POST["fso_order_number"]);
        TaxesModerator::$TaxesModerator->init_html_editor();
        ?>
        <script>
            TaxesModerator.TM.add_event( TaxesModerator.ON_TAX_CHANGED, function(e)
            {
                OrderTotalAmount.OTA.calculate();
            });
        </script>            
        <?php
        
        $RightFObject->showMe();
        ?>
            </div>
            <!--Left part of form-->

            <!--Right part of the form-->
            <style>
                #admin_right_part
                {
                    /*
                    border:solid 1px;
                    */
                }
                .admin_right_part_holder_relative
                {

                }
            </style>
            <div id="admin_right_part" class="floatRight">
                <div class="positionRelative admin_right_part_holder_relative">
                    <div class="positionAbsolute right_form_absolute_holder">
        <?php
        require_once("admin_right_editor.php");
        ?>
                    </div>
                </div>
            </div>
            <script>
                function setSizeOfRightPart()
                {
                    $(".admin_right_part_holder_relative").css("height", $("#admin_left_part").height() + "px");
                    $(".right_form_absolute_holder").stop();
                    var positionTop = $(window).scrollTop();
                    $(".right_form_absolute_holder").animate({top: positionTop + "px"}, 500);
                }
                $(window).resize(function(e)
                {
                    setSizeOfRightPart();
                });
                $(window).scroll(function(e)
                {
                    setSizeOfRightPart();
                });
                $(document).ready(function(e)
                {
                    setSizeOfRightPart();
                });
            </script>
            <!--Right part of the form end-->

            <!--Delimiter-->
            <div id="delimiter_admin_vertical" class="floatLEft delimiter_vertical_max"> 

            </div>

            <!--Delimiter-->

            <div class="clearBoth"></div>

            <script>
                $("#admin_left_part").addClass("width300px");
                $("#admin_right_part").addClass("width250px");
                $(document).ready(function(e)
                {
                    $("#delimiter_admin_vertical").css("height", $("#admin_left_part").height() + "px");
                });

            </script>

        </form>
        <?php
        if ($_POST["fso_order_number"] == "new-manual" || $_POST["fso_order_number"] == "new-laser") {
            $_POST["backgroundINdex"] = "1";
            ?>
            <script>
                document.getElementById("cb_update_current_order").disabled = true;
                document.getElementById("cb_update_current_order").checked = false;
                document.getElementById("cb_create_new_order").disabled = true;
                document.getElementById("cb_create_new_order").checked = true;
                $(document).ready(function(e)
                {
                    OrderNumber.ON.setupOrderForAdmin__newOrderYesOrNO(true);
                });
            </script>
            <?php
        } else {
            AdminEditorAdditional::ADD_VALUES_TO_INPUTS();
        }
        ?>       
        <script>
            document.getElementById("sendPDFandEmail").value = "FOR_ADMIN";
            ChequeColor.CC.arrayEventsAfterChanging.push(function()
            {
                /*
                 document.getElementById("chequeColorsAdditionalInfo").innerHTML = 
                 "Selected Color <b>"+ChequeColor.CC.pictureColor()+"</b>";*/
            });
        <?php
        //Client told me each time opened in editor background index selected to 0
        //$_POST["backgroundINdex"] = 1;
        ?>
        <?php if (!RightForms::IS_NEW_CREATED_ORDER()) { ?>
                ChequeColor.CC.change(<?php print $_POST["backgroundINdex"]; ?>);
        <?php } else { ?>
                //ChequeColor.CC.change( 1 );
                //when admin colour must be not selected
                /**/
                $("#color_info_for_hologram").html("");
                $("#color_info_for_hologram_cheque_position").html("Please select");

        <?php } ?>

            $(".inputOnFocusInOut").focus(function()
            {
                if ($(this).attr("value") == $(this).attr("value_default"))
                {
                    $(this).attr("value", "");
                    $(this).css("color", "#000000");
                }
            });
            $(".inputOnFocusInOut").focusout(function()
            {
                if ($(this).attr("value") == "")
                {
                    $(this).attr("value", $(this).attr("value_default"));
                    $(this).css("color", "#999");
                }
            });
        </script>  
        <?php
    }

    public static function ADD_VALUES_TO_INPUTS() {
        ?>
        <script>
            /*
             If order is opened for editing do discaunt
             */
            ProductEditor.IS_FOR = ProductEditor.IS_FOR_DISCAUNT;
        <?php
        foreach ($_POST as $variable => $value) {
            if (
                    $variable != "email_discount_code" &&
                    $variable != "order_submited_date_order_updated_date"
            ) {
                ?>
                    $("#<?php print $variable; ?>").val(<?php print json_encode($_POST[$variable]); ?>);
                <?php
            } else if ($variable == "shipping_price_INPUT_company") {
                ?>
                <?php
            }
        }
        /*
         * if shipping_to_bo_box is checked is parsing value to post
         * in another case it is not sending post....
         * so i am using this logics here.
         * */
        if (isset($_POST["shipping_to_bo_box"])) {
            ?>
                $("#shipping_to_bo_box").prop("checked", true);
            <?php
        }
        ?>
            $(document).ready(function(e)
            {
                CreatingInvoiceForAdditionalProducts.CIFAP.reset_approval_drop_box_empthy_init();
            });
        </script>
        <?php
        /*
          print_r($_POST);
          print "[".$_POST["quantityINPUTIndex"]."]";
         */
        ?>
        <script>
            //HELPER.H.setupComboBoxByIndex("compInfoQuantity", "<?php print $_POST["quantityINPUTIndex"] ?>");
        <?php
        if (!RightForms::IS_NEW_CREATED_ORDER()) {
            ?>
                ChequeColor.CC.change(<?php print $_POST["backgroundINdex"] ?>);
            <?php
        }
        ?>
        <?php
        if ($_POST["chequeType"] == Cheque::TYPE_LASER) {
            //Client told me to setup cheque position to 1 
            //$_POST["chequePosition"] = "1";
            ?>

            <?php
            if (!RightForms::IS_NEW_CREATED_ORDER()) {
                ?>
                    ChequePosition.CP.arrEventsAfterChanging.push(
                            function()
                            {
                                document.getElementById("chequeBgPositionsAdditionalInfo").innerHTML =
                                        "Background position <b>" + ChequePosition.CP.positionName() + "</b>";
                            });
                    ChequePosition.CP.changePosition("<?php print $_POST["chequePosition"]; ?>");
                <?php
            } else {
                ?>
                    $("#chequeBgPositionsAdditionalInfo").html("Background position <b>Not selected</b>");
                    $("#chequePosition").val("");
                <?php
            }
            ?>
            <?php
        } else if ($_POST["chequeType"] == Cheque::TYPE_MANUAL) {
            if (!RightForms::IS_NEW_CREATED_ORDER()) {
                ?>
                    //the client told me that on start manual position cheque will be not checked
                    ChequePosition.CP.setupCBs1OR2ChequesPerManual("<?php print $_POST["chequePosition"]; ?>");
                <?php
            } else {
                ?>
                    //it is default checked first check box, but on editor must be unchecked
                    $("#manualPosX1cheque").prop("checked", false);
                <?php
            }
        }
        ?>
            //$("#color_info_for_hologram_cheque_position").html("Please select a colour");

            if (document.getElementById("comInfoIsSecondCompanyName").value != "") {
                document.getElementById("compInfoCBShowSecondLine").checked = true;
            }
            if (document.getElementById("CILogoType").value == "0")
            {
                document.getElementById("compInfoAttachLogo_1").checked = true;
                CompanyInfo.CI.CBLogoOnClick(document.getElementById("compInfoAttachLogo_1"));
            }
            else if (document.getElementById("CILogoType").value == "1")
            {
                document.getElementById("compInfoAttachLogo_2").checked = true;
                CompanyInfo.CI.CBLogoOnClick(document.getElementById("compInfoAttachLogo_2"));
            }
            if (document.getElementById("isCurrencyINPUT").value == "true") {
                document.getElementById("compInfoCBUSFunds").checked = true;
            }
            /*
             if(document.getElementById("add45AfterAcountNumberInput").value == "true")
             {
             document.getElementById("compInfoAdd45AfterAccount").checked=true;
             }
             */
            if (document.getElementById("compInfoSoftware") != null)
            {
        <?php
        if (!isset($_POST["softwareINPUTIndex"])) {
            $_POST["softwareINPUTIndex"] = "0";
        }
        ?>
                document.getElementById("compInfoSoftware").selectedIndex = <?php print $_POST["softwareINPUTIndex"]; ?>;
        <?php
        if (isset($_POST["compInfoEnterOtherSoftware"])) {
            ?>
                    document.getElementById("compInfoSoftware").selectedIndex = 8;
            <?php
        }
        ?>
                CompanyInfo.CI.onSowtaferSELECTChanging();
        <?php
        if (isset($_POST["compInfoEnterOtherSoftware"])) {
            ?>
                    document.getElementById("compInfoEnterOtherSoftware").value =
                            "<?php print $_POST["compInfoEnterOtherSoftware"]; ?>";
            <?php
        }
        ?>
            }
        <?php
        if (isset($_POST["compInfoClientSupplier"])) {
            ?>
                document.getElementById("compInfoIncludeEnvelopes").checked = true;
                CompanyInfo.CI.CBDWEOnClick();
                document.getElementById("compInfoClientSupplier").value = "<?php print $_POST["compInfoClientSupplier"]; ?>";
            <?php
        }
        ?>
            /*
             document.getElementById("compInfoSecondSignatur").checked=false;
             document.getElementById("compInfoShowStartNumber").checked = true;
             if(document.getElementById("isThereSecondSignature").value=="true")
             {
             document.getElementById("compInfoSecondSignatur").checked=true;
             }*/
            $("#compInfox1Signatur").prop("checked", false);
            $("#compInfoSecondSignatur").prop("checked", false);
        <?php
        if (isset($_POST["isThereSecondSignature"])) {
            if ($_POST["isThereSecondSignature"] == "SIGNATURE_x2") {
                ?>
                    $("#compInfoSecondSignatur").prop("checked", true);
                <?php
            } else if ($_POST["isThereSecondSignature"] == "SIGNATURE_x1") {
                ?>
                    $("#compInfox1Signatur").prop("checked", true);
                <?php
            }
        }
        ?>
            if (document.getElementById("compInfoStartAtTrueOrFalse").value == "false") {
                document.getElementById("compInfoShowStartNumber").checked = false;
            }
        <?php
        if (isset($_POST["boxingType"])) {
            ?>
                CompanyInfo.CI.selectCBByBoxingTypeText("<?php print $_POST["boxingType"]; ?>");
            <?php
        } else {
            ?>
                $("#compInfoBoxingType0").prop("checked", false);
            <?php
        }
        ?>
        <?php
        if (isset($_POST["depositBooksINPUTIndex"])) {
            ?>
                HELPER.H.setupComboBoxByIndex("compInfoDepositBooks", "<?php print $_POST["depositBooksINPUTIndex"]; ?>");
            <?php
        } else {
            ?>
                HELPER.H.setupComboBoxByIndex("compInfoDepositBooks", 0);
            <?php
        }
        if (isset($_POST["DWEINPUTIndex"])) {
            ?>
                HELPER.H.setupComboBoxByIndex("compInfoDWE", "<?php print $_POST["DWEINPUTIndex"]; ?>");
            <?php
        } else {
            ?>
                HELPER.H.setupComboBoxByIndex("compInfoDWE", 0);
            <?php
        }
        if (isset($_POST["SSDWEINPUTIndex"])) {
            ?>
                HELPER.H.setupComboBoxByIndex("compInfoSSDWE", "<?php print $_POST["SSDWEINPUTIndex"]; ?>");
            <?php
        } else {
            ?>
                HELPER.H.setupComboBoxByIndex("compInfoSSDWE", 0);
            <?php
        }
        if (isset($_POST["chequeBinderINPUTIndex"])) {
            ?>
                HELPER.H.setupComboBoxByIndex("compInfoChequeBinder", "<?php print $_POST["chequeBinderINPUTIndex"]; ?>");
            <?php
        } else {
            ?>
                HELPER.H.setupComboBoxByIndex("compInfoChequeBinder", 0);
            <?php
        }
        if (isset($_POST["SelfLinkStampINPUTIndex"])) {
            ?>
                HELPER.H.setupComboBoxByIndex("compInfoSelfLinkingStamp", "<?php print $_POST["SelfLinkStampINPUTIndex"]; ?>");
            <?php
        } else {
            ?>
                HELPER.H.setupComboBoxByIndex("compInfoSelfLinkingStamp", 0);
            <?php
        }
        if (isset($_POST["deliveryINPUT"])) {
            ?>
                if (document.getElementById("deliveryINPUT").value == "Standard 8-10 Business Days")
                {
                    document.getElementById("standard_8to10_business_days").checked = true;
                    document.getElementById("rush_25charge_1to5_business_days").checked = false;
                }
                else if (document.getElementById("deliveryINPUT").value == "1-5 Business Days")
                {
                    document.getElementById("standard_8to10_business_days").checked = false;
                    document.getElementById("rush_25charge_1to5_business_days").checked = true;
                }
            <?php
        }
        ?>

            document.getElementById("BSCombo_" + BillingShipingModerator.BSM.TYPE_BILLING).checked = true;
            CompanyInfo.CI.comboShowShippingBilling(BillingShipingModerator.BSM.TYPE_BILLING);
            document.getElementById("BSCombo_" + BillingShipingModerator.BSM.TYPE_SHIPING).checked = true;
            CompanyInfo.CI.comboShowShippingBilling(BillingShipingModerator.BSM.TYPE_SHIPING);

            HELPER.H.setupComboBoxByText("CBProvince_TYPE_BILLING", "<?php print $_POST["province_TYPE_BILLING"]; ?>");
            HELPER.H.setupComboBoxByText("CBProvince_TYPE_SHIPING", "<?php print $_POST["province_TYPE_SHIPING"]; ?>");
            /**/
            if (document.getElementById("SameAsBillingDetails").value == "true")
            {
                document.getElementById("cbDoShippingSameAsBilling").checked = true;
                BillingShipingModerator.BSM.setupINputsShipingEnabledDisabled();
            }

            if (document.getElementById("residentialAddressBSM").value == "true")
            {
                document.getElementById("residentialAddressBSMid").checked = true;
            }
            if (document.getElementById("noSignatureRequiredBSM").value == "true")
            {
                document.getElementById("noSignatureRequiredBSMid").checked = true;
            }
            if (document.getElementById("mopINPUT").value == "Visa")
            {
                document.getElementById("MOP_Visa").checked = true;
                document.getElementById("MOP_Mastercart").checked = false;
            }
            else if (document.getElementById("mopINPUT").value == "Direct Debit")
            {
                document.getElementById("MOP_directDebit").checked = true;
                $("#MOP_directDebit_signatureDIVHolder").removeClass("displayNone");
            }
            else if (document.getElementById("mopINPUT").value == "Mastercard")
            {
                document.getElementById("MOP_Visa").checked = false;
                document.getElementById("MOP_Mastercart").checked = true;
            }
            if (document.getElementById("mopCallMe").value == "false")
            {
                document.getElementById("MOP_pleaseCallMe").checked = false;
            }
            else if (document.getElementById("mopCallMe").value == "true")
            {
                document.getElementById("MOP_pleaseCallMe").checked = true;
            }
            MOP.M.setVariablesForMOP();
            HELPER.H.setupComboBoxByText("MOP_expMonth", "<?php print $_POST["mopExpirtyMonthINPUT"]; ?>");
            HELPER.H.setupComboBoxByText("MOP_expYear", "<?php print $_POST["mopExpirtyYearINPUT"]; ?>");
            MOP.M.setVariablesForMOP();
            OrderTotalAmount.OTA.calculate();
        </script>  
        <script>
            $(document).ready(function(e)
            {
                Delivery.D.setup_delivery_details(true);
            });
        <?php
        if (RightForms::$IS_FOR_SHOWING_ORDER_FOR_ADMIN && isset($_POST["shipping_charge_select_company"])) {
            ?>
                Delivery.D.select_shipping_via_option("<?php print $_POST["shipping_charge_select_company"]; ?>");
            <?php
        }
        ?>
        </script> 
        <?php
    }

}

if (!file_exists(AdminEditorAdditional::XML_ORDER_PATH())) {
    ?>

    <form action="<?php print SETTINGS::URL_TO_ADMIN_PAGE; ?>&admin_action=<?php print PagesModerator::PAGE_ADMIN_DIRECTIONS; ?>" id="form_order_not_exists" method="post" enctype="multipart/form-data">
        <input type="hidden" name="user_is_logged" value="yes" />
        <input type="hidden" name="order_not_exists" />
        <input type="hidden" name="orderThatNotExist" value="<?php print $_POST["fso_order_number"]; ?>" />
    </form>
    <script>
        document.getElementById("form_order_not_exists").submit();
    </script>
    <?php
}
AdminEditorAdditional::ADD_ALL_VALUES_TO_POST();

$cheque = new Cheque($_POST["chequeType"]);
//print "[".Cheque::$cheque."]";
$RightFObject = new RightForms($cheque);
AdminEditorAdditional::SHOW_EDITING_FORM($cheque, $RightFObject);
?>
