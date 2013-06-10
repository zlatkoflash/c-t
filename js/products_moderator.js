/*
 * 
 * @returns {ProductEditor}
 * It is hard linked with the html from php/products_moderator.php
 */
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