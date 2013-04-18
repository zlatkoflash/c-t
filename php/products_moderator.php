<?php
if (!class_exists("Cheque")) {
    require_once( "tools.php" );
}
if (!class_exists("SETTINGS")) {
    require_once( "settings.php" );
}
if (!class_exists("DB_DETAILS")) {
    require_once( "db_details.php" );
}

class ProductsModerator {

    public static function initTheHTMLForm() {
        ?>
        <script >
            function ProductEditor()
            {
                this.array_variables =
                        [
                            {type: "copies", id_div_input: "-not defined yet-", visible: false, type_value: "number"},
                            {type: "quantity", id_div_input: "-not defined yet-", visible: false, type_value: "number"},
                            {type: "free", id_div_input: "-not defined yet-", visible: false, type_value: "number"},
                            {type: "price", id_div_input: "price_product_updater", visible: false, type_value: "number"},
                            {type: "shipping_variable", id_div_input: "-not defined yet-", visible: false, type_value: "text"},
                            {type: "title", id_div_input: "-not defined yet-", visible: false, type_value: "text"}
                        ];
        <?php ?>
                /*
                 * if SELECTED_INPUT_ID = null then pop up can show, 
                 * in another case not showing pop up
                 * the problem is firefox....when on mouse over options of the 
                 * select firefox object....it is doing haos.
                 * Because of that i am showing the form once
                 * */
                this.SELECTED_INPUT_ID = null;
                this.productObject = null;
                this.input_id_roll_overed = null;
                this.array_js_products = null;

                this.setup = function(visibleInputs, _productObject_, _input_id_roll_overed_, _array_js_products_)
                {
                    this.input_id_roll_overed = _input_id_roll_overed_;
                    this.productObject = _productObject_;
                    this.array_js_products = _array_js_products_;
                    if (this.indexHideInterval != null) {
                        clearTimeout(this.indexHideInterval);
                    }
                    for (var i = 0; i < this.array_variables.length; i++)
                    {
                        $("#" + this.array_variables[i].id_div_input).addClass("displayNone");
                        this.array_variables[i].visible = false;
                    }
                    for (var i = 0; i < visibleInputs.length; i++)
                    {
                        $("#" + this.array_variables[visibleInputs[i]].id_div_input).removeClass("displayNone");
                        var inputFor = $("#" + this.array_variables[visibleInputs[i]].id_div_input).find("input").get(0);
                        if (this.array_variables[visibleInputs[i]].type == "price")
                        {
                            if (ProductEditor.IS_FOR == ProductEditor.IS_FOR_CHANGING_PRICES)
                            {
                                $(inputFor).val(this.productObject[this.array_variables[visibleInputs[i]].type]);
                            }
                            else if (ProductEditor.IS_FOR == ProductEditor.IS_FOR_DISCAUNT)
                            {
                                /*some of the objects will not have discaunts*/
                                if (this.productObject.discount == null)
                                {
                                    this.productObject.discount = 0;
                                }
                                $(inputFor).val(this.productObject.price);
                                /*
                                 price_products_form_moderator,
                                 price_discount_products_form_moderator,
                                 price_absolute_products_form_moderator
                                 */
                                $("#price_discount_products_form_moderator").val(this.productObject.discount);
                                $("#price_absolute_products_form_moderator").val(this.productObject.price_abs());
                            }
                        }
                        else
                        {
                            $(inputFor).val(this.productObject[this.array_variables[visibleInputs[i]].type]);
                        }
                        this.array_variables[visibleInputs[i]].visible = true;
                    }
                    $(".products_form_moderator").removeClass("displayNone");
                    $(".products_form_moderator").animate({opacity: 1}, 500, function()
                    {
                    });
                    this.setup_sizes();
                }
                this.setup_sizes = function()
                {
                    if ($("#products_editor_form .panelWhiteShadow_middleCenter").innerHeight() <
                            $("#products_editor_form .panelWhiteShadow_middleCenterRight").innerHeight())
                    {
                        $("#products_editor_form .panelWhiteShadow_middleCenter").css("height",
                                $("#products_editor_form .panelWhiteShadow_middleCenterRight").innerHeight() + "px");
                    }
                    var heightForRightPartsTopBottom = $("#products_editor_form .width250px").innerHeight();
                    heightForRightPartsTopBottom = heightForRightPartsTopBottom -
                            ($("#products_editor_form .panelWhiteShadow_middleCenterRight").innerHeight() +
                                    $("#products_editor_form .panelWhiteShadow_topRight").innerHeight()
                                    + $("#products_editor_form .panelWhiteShadow_bottomRight").innerHeight());
                    heightForRightPartsTopBottom = heightForRightPartsTopBottom / 2;
                    $("#products_editor_form .panelWhiteShadow_RightSimetric").css("height", heightForRightPartsTopBottom + "px");
                    $("#products_editor_form .panelWhiteShadow_Left").css("height",
                            $("#products_editor_form .panelWhiteShadow_middleCenter").innerHeight() + "px");
                }
                this.indexHideInterval = null;
                this.hide = function()
                {
                    if (this.indexHideInterval != null) {
                        clearTimeout(this.indexHideInterval);
                    }
                    this.indexHideInterval = setTimeout(ProductEditor.PE.hideAbs, 500);
                }
                this.hideAbs = function()
                {
                    $(".products_form_moderator").animate({opacity: 0}, 500, function()
                    {
                        $(".products_form_moderator").addClass("displayNone");
                        ProductEditor.PE.SELECTED_INPUT_ID = null;
                    });
                }
                this.hide_now = function()
                {
                    $(".products_form_moderator").css("opacity", 0);
                    $(".products_form_moderator").addClass("displayNone");
                }
                this.clearTimeoutForHide = function()
                {
                    if (this.indexHideInterval != null) {
                        clearTimeout(this.indexHideInterval);
                    }
                }
                this.update = function()
                {
                    if (!this.validate()) {
                        return;
                    }
                    if (ProductEditor.IS_FOR == ProductEditor.IS_FOR_CHANGING_PRICES)
                    {
                        for (var i = 0; i < this.array_variables.length; i++)
                        {
                            if (this.array_variables[i].visible)
                            {
                                var objectVariable = this.array_variables[i];
                                this.productObject[objectVariable.type] =
                                        $("#" + objectVariable.type + "_products_form_moderator").val();
                            }
                        }
                    }
                    else if (ProductEditor.IS_FOR == ProductEditor.IS_FOR_DISCAUNT)
                    {
                        this.productObject.discount = parseFloat($("#price_discount_products_form_moderator").val());
                    }
                    if ($("#" + this.input_id_roll_overed).is("select"))
                    {
                        if (this.productObject.price > 0)
                        {
                            $("#" + this.input_id_roll_overed).find(":selected").text(this.productObject.title + " $"
                                    + parseFloat(this.productObject.price).toFixed(2) + "");
                        }
                        else
                        {
                            $("#" + this.input_id_roll_overed).find(":selected").text(this.productObject.title);
                        }
                        this.productObject.array_holder[$("#" + this.input_id_roll_overed).find(":selected").text()] =
                                this.productObject;
                    }
                    /* for logos */
                    if (this.productObject.additional_type == "one_time_charge")
                    {
                        $($("#one_time_charge_label").find(".logo_price_label").get(0)).html(this.productObject.price_abs());
                    }
                    else if (this.productObject.additional_type == "custom_color")
                    {
                        $($("#custom_color_label").find(".logo_price_label").get(0)).html(this.productObject.price_abs());
                    }
                    /* for logos */
                    /*=======================================================================*/
                    /* for shipping rush charges */
                    else if (this.productObject.additional_type == "rush_shipping_charge")
                    {
                        $("#chargeShippingRushPrice").html(this.productObject.price);
                    }
                    /* for shipping rush charges */

        <?php ?>
                    /*If there are not opened order for editing, then please change the database */
                    if (ProductEditor.IS_FOR == ProductEditor.IS_FOR_CHANGING_PRICES)
                    {
                        if (this.productObject.id != null)
                        {
                            $.post(settings.URL_TO_PHP_PRODUCTS,
                                    {
                                        UPDATE_PRODUCT: "Yes i will do update",
                                        price: this.productObject.price,
                                        id: this.productObject.id
                                    }, function(data)
                            {
                                //alert("update is done");
                            });
                        }
                        else if (this.productObject.postal_code != null)
                        {
                            $.post(settings.URL_TO_PHP_PRODUCTS,
                                    {
                                        UPDATE_PRODUCT: "Yes i will do update",
                                        price: this.productObject.price,
                                        postal_code: this.productObject.postal_code,
                                        variable: this.productObject.variable
                                    }, function(data)
                            {
                                //alert(data);
                                Delivery.D.setup_delivery_details();
                                //just for refreshing
                            });
                        }
                    }
                    else if (ProductEditor.IS_FOR == ProductEditor.IS_FOR_DISCAUNT)
                    {
                        if (this.productObject.id == null) {
                            this.productObject.id = "-666";
                        }
                        $.post(settings.URL_TO_PHP_PRODUCTS,
                                {
                                    UPDATE_DISCAUNT_FOR_PRODUCT: "Yes i will do it now",
                                    discount: this.productObject.discount,
                                    product_id: this.productObject.id,
                                    //OrderNumber js class is into admin.php
                                    order_number: OrderNumber.ORDER_NUMBER_BASE
                                }, function(data)
                        {
                            //alert(data);
                        });
                    }
                    OrderTotalAmount.OTA.calculate();
                }
                this.validate = function()
                {
                    //alert(isNaN($("#price_products_form_moderator").val()));
                    for (var i = 0; i < this.array_variables.length; i++)
                        if (this.array_variables[i].visible)
                        {
                            var objectVariable = this.array_variables[i];
                            if (objectVariable.type_value == "number")
                            {
                                if (isNaN($("#" + objectVariable.type + "_products_form_moderator").val()))
                                {
                                    alert(objectVariable.type + " must be number.");
                                    return false;
                                }
                            }
                        }
                    return true;
                }
            }
            ProductEditor.PE = new ProductEditor();
            ProductEditor.PRICE = 3;
            ProductEditor.IS_FOR_CHANGING_PRICES = "IS_FOR_CHANGING_PRICES";
            ProductEditor.IS_FOR_DISCAUNT = "IS_FOR_DISCAUNT";
            ProductEditor.IS_FOR = ProductEditor.IS_FOR_CHANGING_PRICES;

            $(document).ready(function(e)
            {
                $(".products_form_moderator").mouseover(function(e)
                {
                    ProductEditor.PE.clearTimeoutForHide();
                });
                $(".products_form_moderator").mouseout(function(e)
                {
                    ProductEditor.PE.hide();
                });
                var variablesForEvents =
                        [
                            {object: Quantity_and_Prices.QP, objectProductVariable: "quantityObject", eventInputIdOrClass: "#compInfoQuantity"},
                            {object: CompanyInfo.CI, objectProductVariable: "getDepositObject", eventInputIdOrClass: "#compInfoDepositBooks"},
                            {object: CompanyInfo.CI, objectProductVariable: "getDWEObject", eventInputIdOrClass: "#compInfoDWE"},
                            {object: CompanyInfo.CI, objectProductVariable: "getSSDWEObject", eventInputIdOrClass: "#compInfoSSDWE"},
                            {object: CompanyInfo.CI, objectProductVariable: "getAPChequeBinderObject", eventInputIdOrClass: "#compInfoChequeBinder"},
                            {object: CompanyInfo.CI, objectProductVariable: "getAPSelfLinkingShtamp",
                                eventInputIdOrClass: "#compInfoSelfLinkingStamp"},
                            //logos products
                            {object: CompanyInfo.CI, objectProductVariable: "getOneTimeChargeLogoObject",
                                eventInputIdOrClass: "#compInfoAttachLogo_1"},
                            {object: CompanyInfo.CI, objectProductVariable: "getColoredLogoObject",
                                eventInputIdOrClass: "#compInfoAttachLogo_2"},
                            //rush shipping charges
                            {object: Delivery.D, objectProductVariable: "getShippingRushChargeObject",
                                eventInputIdOrClass: "#rush_25charge_1to5_business_days"},
                            //shipping charges, standard 8-10 days
                            {object: Delivery.D, objectProductVariable: "getShippingStandardChargeObject",
                                eventInputIdOrClass: "#standard_8to10_business_days"}


                        ];
                for (var i = 0; i < variablesForEvents.length; i++)
                {
                    //alert(variablesForEvents[i].object[variablesForEvents[i].objectProductVariable]());
                    $(variablesForEvents[i].eventInputIdOrClass).attr("index_object", i);

                    $(variablesForEvents[i].eventInputIdOrClass + " option").mouseover(function(e)
                    {
                        return false;
                    });
                    $(variablesForEvents[i].eventInputIdOrClass).mouseover(function(e)
                    {
                        //ProductEditor.PE.setup([ProductEditor.PRICE], Quantity_and_Prices.QP.quantityObject());
                        var object_product =
                                variablesForEvents[$(this).attr("index_object")].object[variablesForEvents[$(this).attr("index_object")].objectProductVariable]();
                        if (object_product == null/* && 
                         variablesForEvents[$(this).attr("index_object")].objectProductVariable=="getShippingStandardChargeObject"*/
                                )
                        {
                            return;
                        }
                        else if (object_product == null)
                        {
                        }
                        ProductEditor.PE.setup([ProductEditor.PRICE], object_product, $(this).attr("id")
                                );
                        var leftPosition = $(this).offset().left - $(".products_form_moderator").innerWidth();
                        var topPosition = $(this).offset().top - $(".products_form_moderator").innerHeight() / 2 +
                                $(this).innerHeight() / 2;
                        $(".products_form_moderator").css("left", leftPosition + "px");
                        $(".products_form_moderator").css("top", topPosition + "px");
                    });
                    $(variablesForEvents[i].eventInputIdOrClass).mouseout(function(e)
                    {
                        ProductEditor.PE.hide();
                    });
                }
                if (ProductEditor.IS_FOR == ProductEditor.IS_FOR_DISCAUNT)
                {
                    $("#product_moderator_update_button").text("Discount The Price");
                    $("#price_discount_product_updater").removeClass("displayNone");
                    $("#price_absolute_product_updater").removeClass("displayNone");
                    /*
                     price_products_form_moderator,
                     price_discount_products_form_moderator,
                     price_absolute_products_form_moderator
                     */
                    $("#price_products_form_moderator").prop("disabled", true);
                    $("#price_products_form_moderator").keyup(function(e)
                    {
                    });
                    $("#price_discount_products_form_moderator").keyup(function(e)
                    {
                        ProductEditor.PE.productObject.discount = parseFloat($("#price_discount_products_form_moderator").val());
                        if (isNaN(ProductEditor.PE.productObject.discount))
                        {
                            ProductEditor.PE.productObject.discount = 0;
                        }
                        $("#price_absolute_products_form_moderator").val(ProductEditor.PE.productObject.price_abs())
                    });
                    $("#price_absolute_products_form_moderator").keyup(function(e)
                    {
                        var absolutePrice = parseFloat($("#price_absolute_products_form_moderator").val());
                        if (isNaN(absolutePrice))
                        {
                            absolutePrice = 0;
                        }
                        ProductEditor.PE.productObject.discount = ProductEditor.PE.productObject.price - absolutePrice;
                        $("#price_discount_products_form_moderator").val(ProductEditor.PE.productObject.discount)
                    });
                }
            });

        </script>

        <div id="products_editor_form" class="positionAbsolute zIndex666 products_form_moderator displayNone">
            <div class="floatLEft">
                <div class="panelWhiteShadow_topLeft"></div>
                <div class="panelWhiteShadow_Left"></div>
                <div class="panelWhiteShadow_bottomLeft"></div>
            </div>
            <div class="floatLEft width250px">
                <div class="panelWhiteShadow_middleTop"></div>
                <div class="panelWhiteShadow_middleCenter">
                    <div id="price_product_updater" class="marginBottom2px">
                        <div class="floatLEft lineTextHeight19">Price:</div><div class="floatRight">
                            <input id="price_products_form_moderator" type="text" class="width40px" />
                        </div>
                        <div class="clearBoth"></div>
                    </div>
                    <div id="price_discount_product_updater" class="marginBottom2px displayNone">
                        <div class="floatLEft lineTextHeight19">Discount:</div><div class="floatRight">
                            <input id="price_discount_products_form_moderator" type="text" class="width40px" />
                        </div>
                        <div class="clearBoth"></div>
                    </div>
                    <div id="price_absolute_product_updater" class="displayNone">
                        <div class="floatLEft lineTextHeight19">Discounted Price:</div><div class="floatRight">
                            <input id="price_absolute_products_form_moderator" type="text" class="width40px" />
                        </div>
                        <div class="clearBoth"></div>
                    </div>
                    <hr />
                    <div class="alignRight padding15px">
                        <a href="javascript:ProductEditor.PE.hideAbs();">Cancel</a> | <a id="product_moderator_update_button" href="javascript:ProductEditor.PE.update();" class="colorbe1e2d">Update</a>
                    </div>
                </div>
                <div class="panelWhiteShadow_middleBottom"></div>
            </div>
            <div class="floatLEft">
                <div class="panelWhiteShadow_topRight"></div>
                <div class="panelWhiteShadow_RightSimetric"></div>
                <div class="panelWhiteShadow_middleCenterRight"></div>
                <div class="panelWhiteShadow_RightSimetric"></div>
                <div class="panelWhiteShadow_bottomRight"></div>
            </div>
            <div class="clearBoth"></div>
        </div>

        <script>
            //ProductEditor.PE.setup([ProductEditor.PRICE]);
            ProductEditor.PE.hide_now();
        </script>
        <?php
    }

    public static function UPDATE_PRODUCT() {
        if (isset($_POST["id"]))
            DB_DETAILS::ADD_ACTION("
				UPDATE products SET price=" . $_POST["price"] . " WHERE id=" . $_POST["id"] . "
			");
        else if (isset($_POST["postal_code"]))
            DB_DETAILS::ADD_ACTION("
				UPDATE canada_postal_codes_rates SET " . $_POST["variable"] . "='" . $_POST["price"] . "' WHERE postal_code='" . $_POST["postal_code"] . "'
			");
    }

    public static function UPDATE_DISCAUNT_FOR_PRODUCT() {
        $rowsDiscount = DB_DETAILS::ADD_ACTION("
				SELECT * FROM products_discount WHERE product_id=" . $_POST["product_id"] . " AND order_number='" . $_POST["order_number"] . "'
			", DB_DETAILS::$TYPE_SELECT);
        if (count($rowsDiscount) == 1) {
            DB_DETAILS::ADD_ACTION("
					UPDATE products_discount SET discount='" . $_POST["discount"] . "' 
					WHERE 
					product_id=" . $_POST["product_id"] . " AND order_number='" . $_POST["order_number"] . "'
				");
        } else if (count($rowsDiscount) == 0) {
            DB_DETAILS::ADD_ACTION("
					INSERT INTO products_discount(product_id, order_number, discount)
					VALUES(" . $_POST["product_id"] . ", '" . $_POST["order_number"] . "', '" . $_POST["discount"] . "')
				");
        } else {
            print "Or you have multi rows for same product and order, or you have error!!!";
        }
        /*
          UPDATE_DISCAUNT_FOR_PRODUCT:"Yes i will do it now",
          discount:this.productObject.discount,
          product_id:this.productObject.id,
          //OrderNumber js class is into admin.php
          order_number:OrderNumber.ON.fso_order_number
         */
    }

    /*
     * When were creating new orders from admin,
     * discaunts were not showing for new orders.
     * Now i will setup all discaunts for the new orders.
     * */

    public static function DUPLICATE_DISCOUNTS_FOR_NEW_ORDER($order_number_old, $order_number_new) {
        //print "[old:".$order_number_old.", new:".$order_number_new."]";

        $allDiscaounts = DB_DETAILS::ADD_ACTION("
					SELECT * FROM products_discount 
					WHERE order_number='" . $order_number_old . "'
				", DB_DETAILS::$TYPE_SELECT);
        for ($i = 0; $i < count($allDiscaounts); $i++) {
            DB_DETAILS::ADD_ACTION("
					INSERT INTO products_discount(product_id, order_number, discount)
					VALUES(" . $allDiscaounts[$i]["product_id"] . ", 
						  '" . $order_number_new . "', 
						   " . $allDiscaounts[$i]["discount"] . ")
				");
        }
    }

    public static function setup_JSquantity_products() {
        if (RightForms::$SHOW_ALL_PRODUCTS == true) {
            $allQuantityObjects = DB_DETAILS::ADD_ACTION("
					SELECT products.*, products_discount.discount FROM products 
					LEFT JOIN products_discount
					ON 
					products.id=products_discount.product_id AND products_discount.order_number='-1'
					WHERE products.array_name='quantity_variables'
				", DB_DETAILS::$TYPE_SELECT);
        } else {
            $allQuantityObjects = DB_DETAILS::ADD_ACTION("
					SELECT products.*, products_discount.discount FROM products 
					LEFT JOIN products_discount
					ON 
					products.id=products_discount.product_id AND products_discount.order_number='" . $_POST["fso_order_number"] . "'
					WHERE products.array_name='quantity_variables' AND products.cheque_type='" . Cheque::$cheque->type . "'
				", DB_DETAILS::$TYPE_SELECT);
        }
        for ($i = 0; $i < count($allQuantityObjects); $i++) {
            $product = new Product($allQuantityObjects[$i]);
            if ($product->price > 0) {
                ?>
                Quantity_and_Prices.QP.quantity_variables["<?php print $product->title; ?> $<?php print $product->price_formated(); ?>"] = <?php $product->js_object('Quantity_and_Prices.QP.quantity_variables'); ?>;
                <?php
            } else if ($product->price == 0) {
                $product->title = "Quantities and Prices";
                /*
                  if($product->cheque_type == Cheque::TYPE_LASER)
                  {
                  $product->title = "Quantities and Prices";
                  }
                  else if($product->cheque_type == Cheque::TYPE_MANUAL)
                  {
                  $product->title = "Quantities and Prices";
                  }
                 * */
                ?>
                Quantity_and_Prices.QP.quantity_variables["<?php print $product->title; ?>"] = <?php $product->js_object('Quantity_and_Prices.QP.quantity_variables'); ?>;
                <?php
            }
        }
    }

    public static function setup_JSdepositBooks_products() {
        $allQuantityObjects = DB_DETAILS::ADD_ACTION("
				SELECT products.*, products_discount.discount FROM products 
				LEFT JOIN products_discount
				ON 
				products.id=products_discount.product_id AND products_discount.order_number='" . $_POST["fso_order_number"] . "'
				WHERE products.array_name='depositBooks'
				AND (products.cheque_type='both' OR products.cheque_type='" . Cheque::$cheque->type . "')
			", DB_DETAILS::$TYPE_SELECT);
        for ($i = 0; $i < count($allQuantityObjects); $i++) {
            $product = new Product($allQuantityObjects[$i]);
            if ($product->price > 0) {
                ?>
                CompanyInfo.CI.depositBooks["<?php print $product->title; ?> $<?php print $product->price_formated(); ?>"] = <?php $product->js_object('CompanyInfo.CI.depositBooks'); ?>;
                <?php
            } else if ($product->price == 0) {
                ?>
                CompanyInfo.CI.depositBooks["<?php print $product->title; ?>"] = <?php $product->js_object('CompanyInfo.CI.depositBooks'); ?>;
                <?php
            }
        }
    }

    public static function setup_JSDWE_products() {
        $allQuantityObjects = DB_DETAILS::ADD_ACTION("
				SELECT products.*,products_discount.discount  FROM products  
				LEFT JOIN products_discount
				ON 
				products.id=products_discount.product_id AND products_discount.order_number='" . $_POST["fso_order_number"] . "'
				WHERE products.array_name='DWEList'
			", DB_DETAILS::$TYPE_SELECT);
        for ($i = 0; $i < count($allQuantityObjects); $i++) {
            $product = new Product($allQuantityObjects[$i]);
            if ($product->price > 0) {
                ?>
                CompanyInfo.CI.DWEList["<?php print $product->title; ?> $<?php print $product->price_formated(); ?>"] = <?php $product->js_object('CompanyInfo.CI.DWEList'); ?>;
                <?php
            } else if ($product->price == 0) {
                ?>
                CompanyInfo.CI.DWEList["<?php print $product->title; ?>"] = <?php $product->js_object('CompanyInfo.CI.DWEList'); ?>;
                <?php
            }
        }
    }

    public static function setup_JSSSDWE_products() {
        $allQuantityObjects = DB_DETAILS::ADD_ACTION("
				SELECT products.*, products_discount.discount FROM products 
				LEFT JOIN products_discount
				ON 
				products.id=products_discount.product_id AND products_discount.order_number='" . $_POST["fso_order_number"] . "'
				WHERE 
				products.array_name='SSDWEList' 
			", DB_DETAILS::$TYPE_SELECT);
        for ($i = 0; $i < count($allQuantityObjects); $i++) {
            $product = new Product($allQuantityObjects[$i]);
            if ($product->price > 0) {
                ?>
                CompanyInfo.CI.SSDWEList["<?php print $product->title; ?> $<?php print $product->price_formated(); ?>"] = <?php $product->js_object('CompanyInfo.CI.SSDWEList'); ?>;
                <?php
            } else if ($product->price == 0) {
                ?>
                CompanyInfo.CI.SSDWEList["<?php print $product->title; ?>"] = <?php $product->js_object('CompanyInfo.CI.SSDWEList'); ?>;
                <?php
            }
        }
    }

    public static function setup_JSchequeBinders_products() {
        $allQuantityObjects = DB_DETAILS::ADD_ACTION("
				SELECT products.*, products_discount.discount FROM products
				LEFT JOIN products_discount
				ON 
				products.id=products_discount.product_id AND products_discount.order_number='" . $_POST["fso_order_number"] . "' 
				WHERE products.array_name='chequeBinderList'
			", DB_DETAILS::$TYPE_SELECT);
        for ($i = 0; $i < count($allQuantityObjects); $i++) {
            $product = new Product($allQuantityObjects[$i]);
            if ($product->price > 0) {
                ?>
                CompanyInfo.CI.chequeBinderList["<?php print $product->title; ?> $<?php print $product->price_formated(); ?>"] = <?php $product->js_object('CompanyInfo.CI.chequeBinderList'); ?>;
                <?php
            } else if ($product->price == 0) {
                ?>
                CompanyInfo.CI.chequeBinderList["<?php print $product->title; ?>"] = <?php $product->js_object('CompanyInfo.CI.chequeBinderList'); ?>;
                <?php
            }
        }
    }

    public static function setup_JSSelfInkingStamp_products() {
        $allQuantityObjects = DB_DETAILS::ADD_ACTION("
				SELECT products.*, products_discount.discount FROM products
				LEFT JOIN products_discount
				ON 
				products.id=products_discount.product_id AND products_discount.order_number='" . $_POST["fso_order_number"] . "' 
				WHERE products.array_name='SelfIncingStampList'
			", DB_DETAILS::$TYPE_SELECT);
        for ($i = 0; $i < count($allQuantityObjects); $i++) {
            $product = new Product($allQuantityObjects[$i]);
            if ($product->price > 0) {
                ?>
                CompanyInfo.CI.SelfIncingStampList["<?php print $product->title; ?> $<?php print $product->price_formated(); ?>"] = <?php $product->js_object('CompanyInfo.CI.SelfIncingStampList'); ?>;
                <?php
            } else if ($product->price == 0) {
                ?>
                CompanyInfo.CI.SelfIncingStampList["<?php print $product->title; ?>"] = <?php $product->js_object('CompanyInfo.CI.SelfIncingStampList'); ?>;
                <?php
            }
        }
    }

    public static function setup_JSLogos_products() {
        $allQuantityObjects = DB_DETAILS::ADD_ACTION("
				SELECT products.*, products_discount.discount FROM products 
				LEFT JOIN products_discount
				ON 
				products.id=products_discount.product_id AND products_discount.order_number='" . $_POST["fso_order_number"] . "'
				WHERE products.array_name='list_logos_products'
			", DB_DETAILS::$TYPE_SELECT);
        ?>
        <?php
        for ($i = 0; $i < count($allQuantityObjects); $i++) {
            $product = new Product($allQuantityObjects[$i]);
            ?>
            CompanyInfo.CI.list_logos_products["<?php print $product->additional_type; ?>"] = <?php $product->js_object('CompanyInfo.CI.list_logos_products'); ?>;
            <?php
        }
    }

    public static function setup_JSRushShippingCharges_products() {
        $allQuantityObjects = DB_DETAILS::ADD_ACTION("
				SELECT products.*, products_discount.discount FROM products 
				LEFT JOIN products_discount
				ON 
				products.id=products_discount.product_id AND products_discount.order_number='" . $_POST["fso_order_number"] . "'
				WHERE products.array_name='list_of_rush_shipping'
			", DB_DETAILS::$TYPE_SELECT);
        for ($i = 0; $i < count($allQuantityObjects); $i++) {
            $product = new Product($allQuantityObjects[$i]);
            ?>
            Delivery.D.list_of_rush_shipping["<?php print $product->additional_type; ?>"] = <?php $product->js_object('CompanyInfo.CI.list_of_rush_shipping'); ?>;
            <?php
        }
    }

    public static function setup_JSShippingDiscount() {
        $discountShipping = DB_DETAILS::ADD_ACTION("
				SELECT * FROM products_discount WHERE 
				order_number='" . $_POST["fso_order_number"] . "' AND product_id=-666
			", DB_DETAILS::$TYPE_SELECT);
        if (count($discountShipping) == 1) {
            ?>
            Delivery.D.getShippingStandardChargeObject().discount = <?php print $discountShipping[0]["discount"]; ?>;
            <?php
        }
    }

}

if (isset($_POST["UPDATE_PRODUCT"])) {
    ProductsModerator::UPDATE_PRODUCT();
} else if (isset($_POST["UPDATE_DISCAUNT_FOR_PRODUCT"])) {
    ProductsModerator::UPDATE_DISCAUNT_FOR_PRODUCT();
}

class Product {

    public static $QUANTITY_AND_PRICES;
    //Additional Products
    public static $DEPOSIT_BOOK;
    public static $DWE;
    public static $SSDWE;
    public static $CHEQUE_BINDER;
    public static $SELF_INKING_STAMP;
    public static $LOGO;
    public static $RUSH_SHIPPING;
    public static $NORMAL_SHIPPING;

    public static function GET_BY_ID($product_id) {
        $the_product_row = DB_DETAILS::ADD_ACTION("
				SELECT * FROM products WHERE id=" . $product_id . "
			", DB_DETAILS::$TYPE_SELECT);
        if (count($the_product_row) == 1)
            return new Product($the_product_row[0]);
        else
            return new Product(NULL);
    }

    const TYPE_QUANTITY = "quantity_variables";
    const TYPE_DEPOSIT_BOOKS = "depositBooks";
    const TYPE_DWE_LIST = "DWEList";
    const TYPE_SSDWE_LIST = "SSDWEList";
    const TYPE_CHEQUE_BINDER_LIST = "chequeBinderList";
    const TYPE_SELF_INCING_STAMP = "SelfIncingStampList";
    const TYPE_LOGO_PRODUCT = "list_logos_products";
    const TYPE_RUSH_PRODUCT = "list_of_rush_shipping";

    public $id = -1,
            $copies = 0,
            $quantity = 0,
            $free = 0,
            $price = 0,
            $shipping_variable = "",
            $title = "",
            $array_name = "",
            $cheque_type = "",
            $additional_type = "",
            $code_id = "-666",
            $discount = 0;
    public $code;

    public function Product($row) {
        if ($row == "-666") {
            $this->id = "-666";
            $this->price = $_POST["shipping_price_INPUT"];
            $this->quantity = 1;
            $this->code = new ProductCode("-666", $this);
            return;
        } else if ($row == NULL) {
            return;
        }
        $this->id = $row["id"];
        $this->copies = $row["copies"];
        $this->quantity = $row["quantity"];
        $this->free = $row["free"];
        $this->price = $row["price"];
        $this->shipping_variable = $row["shipping_variable"];
        $this->title = $row["title"];
        $this->array_name = $row["array_name"];
        $this->cheque_type = $row["cheque_type"];
        $this->additional_type = $row["additional_type"];
        $this->code_id = $row["code_id"];
        $this->code = new ProductCode($this->code_id, $this);
        /*
          In case when no dicount loaded into the MySQL Query
         */
        if (!isset($row["discount"])) {
            //print "[".$_POST["fso_order_number"]."]";
            //print "[".$_POST["orderNumber"]."]";
            //print_r($_POST);
            if (isset($_POST["fso_order_number"]))
                $sqlForDiscount = "
					SELECT * FROM products_discount WHERE 
						product_id=" . $this->id . " AND order_number='" . $_POST["fso_order_number"] . "'
				";
            else if (OrderNumber::$CURR_ORDER != NULL)
                $sqlForDiscount = "
					SELECT * FROM products_discount WHERE 
						product_id=" . $this->id . " AND order_number='" . OrderNumber::$CURR_ORDER->orderLabel . "'
				";
            else if (isset($_POST["orderNumber"]))
                $sqlForDiscount = "
					SELECT * FROM products_discount WHERE 
						product_id=" . $this->id . " AND order_number='" . $_POST["orderNumber"] . "'
				";
            //print $sqlForDiscount;
            $discountForMe = DB_DETAILS::ADD_ACTION($sqlForDiscount, DB_DETAILS::$TYPE_SELECT);
            if (count($discountForMe) > 0) {
                $this->discount = $discountForMe[0]["discount"];
            } else if (count($discountForMe) == 0) {
                $this->discount = 0;
            }
        }
        /*
          In case when dicount id loaded into the MySQL Query
         */ else {
            $this->discount = $row["discount"];
        }
        if ($this->discount == NULL) {
            $this->discount = 0;
        }
        //print "[id:".$this->id.", price:".$this->price.", discount:".$this->discount."]";
    }

    public function js_object($referenceArray) {
        ?>
        {id:<?php print $this->id; ?>, copies:<?php print $this->copies; ?>, 
        quantity:<?php print $this->quantity; ?>,free:<?php print $this->free; ?>,price:<?php print $this->price; ?>,discount:<?php print $this->discount; ?>,shipping_variable:"<?php print $this->shipping_variable; ?>",title:"<?php print $this->title; ?>",array_name:"<?php print $this->array_name; ?>",cheque_type:"<?php print $this->cheque_type; ?>", additional_type:"<?php print $this->additional_type; ?>", array_holder:<?php print $referenceArray; ?>,
        price_abs:function()
        {
        return this.price-this.discount;
        }
        }
        <?php
    }

    public function price_formated() {
        return number_format($this->price, 2);
    }

    public function invoice_amount() {
        return $this->price - $this->discount;
    }

    public function invoice_amount_formated() {
        return number_format($this->invoice_amount(), 2);
    }

    public function total_quantity() {
        return $this->quantity + $this->free;
    }

    public function description() {
        switch ($this->array_name) {
            case self::TYPE_QUANTITY: {
                    if ($this->cheque_type == Cheque::TYPE_LASER) {
                        return "Laser Cheque Start #" . $_POST["compInfoStartAt"] . "";
                    } else if ($this->cheque_type == Cheque::TYPE_MANUAL) {
                        return "Manual Cheque Start #" . $_POST["compInfoStartAt"] . "";
                    }
                    return "Quantity & Prices";
                }break;
            case self::TYPE_DEPOSIT_BOOKS: {
                    return "Deposit Books";
                }break;
            case self::TYPE_DWE_LIST: {
                    return "Double Window Envelopes";
                }break;
            case self::TYPE_SSDWE_LIST: {
                    return "Self Seal Double Window Envelopes";
                }break;
            case self::TYPE_CHEQUE_BINDER_LIST: {
                    return "Cheque Binder";
                }break;
            case self::TYPE_SELF_INCING_STAMP: {
                    if ($this->additional_type == "name") {
                        return "Name & Address Stamp";
                    }
                    if ($this->additional_type == "deposit") {
                        return "Deposit Stamp";
                    }
                    return "Deposit Stamp";
                }break;
            case self::TYPE_LOGO_PRODUCT: {
                    return "Logo";
                }break;
            case self::TYPE_RUSH_PRODUCT: {
                    return "Rush Production";
                }break;
        }
        if ($this->id == "-666") {
            return "Shipping Details";
        }
        return "Not defined description.";
    }

}

class ProductCode {

    public $id = "-666",
            $code = "_empthy_code_",
            $additional_index = "-1";
    public $product;

    public function ProductCode($product_id, $product) {
        if (!isset($_POST["CREATE_INVOICE_FOR_ADDITIONAL_PRODUCTS"])) {
            return;
        }
        $this->product = $product;
        if ($product_id == "-666") {
            $this->id = $product_id;
            $this->code = "S1";
        }
        if ($this->product->array_name == "quantity_variables") {
            if ($this->product->cheque_type == "laser") {
                if ($_POST["chequePosition"] == "1") {
                    $product_result = DB_DETAILS::ADD_ACTION("
							SELECT * FROM product_codes WHERE additional_index='laser_t-" . $_POST["backgroundINdex"] . "'
						", DB_DETAILS::$TYPE_SELECT);
                } else if ($_POST["chequePosition"] == "2") {
                    $product_result = DB_DETAILS::ADD_ACTION("
							SELECT * FROM product_codes WHERE additional_index='laser_m-" . $_POST["backgroundINdex"] . "'
						", DB_DETAILS::$TYPE_SELECT);
                } else if ($_POST["chequePosition"] == "3") {
                    $product_result = DB_DETAILS::ADD_ACTION("
							SELECT * FROM product_codes WHERE additional_index='laser_b-" . $_POST["backgroundINdex"] . "'
						", DB_DETAILS::$TYPE_SELECT);
                }
            } else if ($this->product->cheque_type == "manual") {
                if ($_POST["chequePosition"] == "true") {//x2 cheques
                    $product_result = DB_DETAILS::ADD_ACTION("
							SELECT * FROM product_codes WHERE additional_index='manual_2-" . $_POST["backgroundINdex"] . "'
						", DB_DETAILS::$TYPE_SELECT);
                } else if ($_POST["chequePosition"] == "false") {//x1 cheque
                    $product_result = DB_DETAILS::ADD_ACTION("
							SELECT * FROM product_codes WHERE additional_index='manual_1-" . $_POST["backgroundINdex"] . "'
						", DB_DETAILS::$TYPE_SELECT);
                }
            }
        } else {
            $product_result = DB_DETAILS::ADD_ACTION("
					SELECT * FROM product_codes WHERE id=" . $product_id . "
				", DB_DETAILS::$TYPE_SELECT);
        }
        if (count($product_result) == 0) {
            return;
        }
        $this->id = $product_result[0]["id"];
        $this->code = $product_result[0]["code"];
        if ($this->product->array_name == "quantity_variables") {
            $this->code .= "-" . $_POST["hologram_U_P_no_yes"];
        }
        $this->additional_index = $product_result[0]["additional_index"];
    }

}
?>