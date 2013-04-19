<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
class TaxesModerator
{
    const TAXES_UNIVERSAL = "universal";
    public $data, $data_discaount=NULL;
    public static $TaxesModerator;
    public $array_provinces_labels = array("AB", "BC", "MB", "NB", "NL", 
                                "NS", "NT", "ON", "PE", "NU", "QC", "SK", "YT");
    public $IS_FOR_DISCOUNT = false;
    
    public function TaxesModerator($order_number="universal")
    {
        if($order_number != self::TAXES_UNIVERSAL)
        {
            $this->IS_FOR_DISCOUNT = true;
        }
        $data = DB_DETAILS::ADD_ACTION("
            SELECT * FROM taxes WHERE order_number='".self::TAXES_UNIVERSAL."'
        ", DB_DETAILS::$TYPE_SELECT);
        $this->data = $data[0];
        if($order_number != self::TAXES_UNIVERSAL)
        {
            //print "[".$order_number."]";
            $data_discaount = DB_DETAILS::ADD_ACTION("
                SELECT * FROM taxes WHERE order_number='".$order_number."'
            ", DB_DETAILS::$TYPE_SELECT);
            if(count($data_discaount) == 0)
            {
                //print "---------------->>>>>>>>[".$order_number."]";
                DB_DETAILS::ADD_ACTION("
                    INSERT INTO taxes(AB, BC, MB, NB, NL, 
                                NS, NT, taxes.ON, PE, NU, QC, SK, YT, order_number)
                     VALUES(0,0,0,0,0,0,0,0,0,0,0,0,0,'".$order_number."')
                ");
                $this->data_discaount = DB_DETAILS::GET_LAST_ITEM("taxes", "id");
            }
            else
            {
                $this->data_discaount = $data_discaount[0];
            }
        }
        else
        {
            $this->data_discaount = array();
            for($i=0;$i<count($this->array_provinces_labels);$i++)
            {
                $this->data_discaount[$this->array_provinces_labels[$i]] = 0;
            }
        }
        
        $this->init_js_script();
        /*$this->init_html_editor();
        */
    }
    private function init_js_script()
    {
        ?>
<script>
    function TaxesModerator(is_for_discount)
    {
        this.is_for_discount = (is_for_discount == true);
        this.array_taxes = [];
        this.hide_after_index = -1;
        this.tax_base = function()
        {
            if(this.array_taxes[$("#CBProvince_TYPE_SHIPING").val()] == null)return 0;
            return this.array_taxes[$("#CBProvince_TYPE_SHIPING").val()].tax_base;
        }
        this.discount = function()
        {
            if(this.array_taxes[$("#CBProvince_TYPE_SHIPING").val()] == null)return 0;
            return this.array_taxes[$("#CBProvince_TYPE_SHIPING").val()].discount;
        }
        this.tax_shipping = function()
        {
            return this.tax_base()-this.discount();
        }
        this.set_sizes_editor = function()
        {
            var height = 150;
            if(ProductEditor.IS_FOR == ProductEditor.IS_FOR_CHANGING_PRICES)
            {
                height = 70;
            }
           $("#taxes_editor_form .panelWhiteShadow_Left").height(height);
           $("#taxes_editor_form .panelWhiteShadow_middleCenter").height(height);
           $("#taxes_editor_form .panelWhiteShadow_RightSimetric").height
           (
                   (
                   $("#taxes_editor_form .width250px").height()-
                   
                   ($("#taxes_editor_form .panelWhiteShadow_middleCenterRight").innerHeight() +
                   $("#taxes_editor_form .panelWhiteShadow_topRight").innerHeight()
                  + $("#taxes_editor_form .panelWhiteShadow_bottomRight").innerHeight())
                    )/2
           );
        }
        this.show = function( mouse_over_holder )
        {
            console.log("form show");
            
            //alert(ProductEditor.IS_FOR_CHANGING_PRICES);
            //alert();
            clearTimeout( this.hide_after_index );
            if(ProductEditor.IS_FOR == ProductEditor.IS_FOR_CHANGING_PRICES)
            {
                $("#tax_shipping_form_moderator").prop("disabled", false);
                $("#tax_discount_updater").addClass("displayNone");
                $("#tax_absolute_updater").addClass("displayNone");
            }
            else if(ProductEditor.IS_FOR == ProductEditor.IS_FOR_DISCAUNT)
            {
                $("#tax_shipping_form_moderator").prop("disabled", true);
                $("#tax_discount_updater").removeClass("displayNone");
                $("#tax_absolute_updater").removeClass("displayNone");
            }
            if(this.tax_base() == 0){return;}
            $("#taxes_editor_form").removeClass("displayNone");
            clearTimeout( this.hide_after_index );
            this.set_sizes_editor();
            var left_position = $(mouse_over_holder).offset().left - $("#taxes_editor_form").width();
            var top_position = $(mouse_over_holder).offset().top
            -$("#taxes_editor_form").height()/2+$(mouse_over_holder).height()/2;
            $("#taxes_editor_form").css("left", left_position+"px");
            $("#taxes_editor_form").css("top", top_position+"px");
            $("#taxes_editor_form").stop().animate({opacity:1}, 500);
            
            $("#tax_shipping_form_moderator").val(this.tax_base());
            $("#tax_discount_shipping_form_moderator").val(this.discount());
            $("#tax_absolute_shipping_form_moderator").val(this.tax_shipping());
        }
        this.hide = function()
        {
            $("#taxes_editor_form").stop().animate({opacity:0}, 500,
            function()
            {
                $(this).addClass("displayNone");
            });
        }
        this.hide_after = function()
        {
            this.hide_after_index = setTimeout("TaxesModerator.TM.hide();", 500);
        }
        this.calculate_base = function(input_key_up)
        {
            if($(input_key_up).attr("id") == "tax_discount_shipping_form_moderator")
            {
                var absolute_tax_percent = this.tax_base()-
                        parseFloat( $("#tax_discount_shipping_form_moderator").val() );
                if(isNaN(absolute_tax_percent))
                {
                    absolute_tax_percent = 0;
                    $("#tax_discount_shipping_form_moderator").val("0");
                }
                $("#tax_absolute_shipping_form_moderator").val( absolute_tax_percent );
            }
            else if($(input_key_up).attr("id") == "tax_absolute_shipping_form_moderator")
            {
                var discount_temp = parseFloat($("#tax_absolute_shipping_form_moderator").val())
                        -this.tax_base();
                if(isNaN(discount_temp))
                {
                    discount_temp = 0;
                    $("#tax_absolute_shipping_form_moderator").val( this.tax_base() );
                }
                $("#tax_discount_shipping_form_moderator").val(discount_temp);
            }
        }
        this.update = function()
        {
            if(isNaN(parseFloat($("#tax_shipping_form_moderator").val())) || 
               isNaN(parseFloat($("#tax_absolute_shipping_form_moderator").val())) || 
               isNaN(parseFloat($("#tax_discount_shipping_form_moderator").val())))
       {
           alert("Taxes inputs are wrong.");
            return;
       }
            this.array_taxes[$("#CBProvince_TYPE_SHIPING").val()].tax_base = parseFloat($("#tax_shipping_form_moderator").val());
            this.array_taxes[$("#CBProvince_TYPE_SHIPING").val()].discount = parseFloat($("#tax_discount_shipping_form_moderator").val());
            //this.array_taxes[$("#CBProvince_TYPE_SHIPING").val()].tax_base = parseFloat($("#tax_shipping_form_moderator").val());
        
            //OrderNumber.ORDER_NUMBER_BASE
            var object_update = 
            {
                UPDATE_TAXES_PLEASE:"Yes i will do it now",
                 province_variable:$("#CBProvince_TYPE_SHIPING").val()
            };
            if(ProductEditor.IS_FOR == ProductEditor.IS_FOR_CHANGING_PRICES)
            {
                object_update.order_number = "<?php print TaxesModerator::TAXES_UNIVERSAL; ?>";
                object_update.value = $("#tax_shipping_form_moderator").val();
            }
            else if(ProductEditor.IS_FOR == ProductEditor.IS_FOR_DISCAUNT)
            {
                object_update.order_number = OrderNumber.ORDER_NUMBER_BASE;
                object_update.value = $("#tax_discount_shipping_form_moderator").val();
            }
            $.post(settings.URL_TO_PHP_PRODUCTS, object_update, function(data)
            {
                //alert(data)
                TaxesModerator.TM.dispatch_event(TaxesModerator.ON_TAX_CHANGED, {});
            });
        }
    }
    TaxesModerator.ON_TAX_CHANGED = "ON_TAX_CHANGED";
    TaxesModerator.prototype = new Eventor();
    TaxesModerator.TM = new TaxesModerator( <?php if($this->IS_FOR_DISCOUNT)print "true"; ?> );
    <?php
    for($i=0;$i<count($this->array_provinces_labels);$i++)
    {
        ?>
   TaxesModerator.TM.array_taxes["<?php print $this->array_provinces_labels[$i]; ?>"] = 
           {
       tax_base:parseFloat( <?php print $this->data[$this->array_provinces_labels[$i]]; ?> ),
       discount:parseFloat( <?php print $this->data_discaount[$this->array_provinces_labels[$i]]; ?> )
           };
            <?php
    }
    ?>
        $(document).ready(function(e)
        {
            $("#CBProvince_TYPE_SHIPING").mouseover(function(e)
            {
                TaxesModerator.TM.show($(this));
            });
            $("#CBProvince_TYPE_SHIPING").mouseout(function(e)
            {
                TaxesModerator.TM.hide_after();
            });
            $("#cancel_edit_taxes").click(function(e)
            {
                TaxesModerator.TM.hide();
                return false;
            });
            $("#tax_moderator_update_button").click(function(e)
            {
                TaxesModerator.TM.update();
                return false;
            });
            $("#taxes_editor_form").mouseover(function(e)
            {
                clearTimeout(TaxesModerator.TM.hide_after_index); 
            });
            $("#taxes_editor_form").mouseout(function(e)
            {
                TaxesModerator.TM.hide_after(); 
            });
            $(".tax_input_shipping_moderator").keyup(function()
            {
                TaxesModerator.TM.calculate_base($(this));
            });
        });
</script>
        <?php
    }
    public function init_html_editor()
    {
        ?>
        <div id="taxes_editor_form" class="positionAbsolute zIndex666 taxes_form_moderator displayNone">
            <div class="floatLEft">
                <div class="panelWhiteShadow_topLeft"></div>
                <div class="panelWhiteShadow_Left"></div>
                <div class="panelWhiteShadow_bottomLeft"></div>
            </div>
            <div class="floatLEft width250px">
                <div class="panelWhiteShadow_middleTop"></div>
                <div class="panelWhiteShadow_middleCenter">
                    <div id="tax_updater" class="marginBottom2px">
                        <div class="floatLEft lineTextHeight19">Tax Percent:</div><div class="floatRight">
                            <input id="tax_shipping_form_moderator" type="text" class="width40px tax_input_shipping_moderator" />
                            %
                        </div>
                        <div class="clearBoth"></div>
                    </div>
                    <div id="tax_discount_updater" class="marginBottom2px">
                        <div class="floatLEft lineTextHeight19">Discount:</div><div class="floatRight">
                            <input id="tax_discount_shipping_form_moderator" type="text" class="width40px tax_input_shipping_moderator" />
                            %
                        </div>
                        <div class="clearBoth"></div>
                    </div>
                    <div id="tax_absolute_updater" class="">
                        <div class="floatLEft lineTextHeight19">Discounted Tax:</div><div class="floatRight">
                            <input id="tax_absolute_shipping_form_moderator" type="text" class="width40px tax_input_shipping_moderator" />
                            %
                        </div>
                        <div class="clearBoth"></div>
                    </div>
                    <hr />
                    <div class="alignRight padding15px">
                        <a href="#" id="cancel_edit_taxes">Cancel</a> | 
                        <a id="tax_moderator_update_button" 
                           href="#" class="colorbe1e2d">Update</a>
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
        <?php
    }
    
    public static function UPDATE_TAXES_PLEASE()
    {
        DB_DETAILS::ADD_ACTION("
            UPDATE taxes SET ".$_POST["province_variable"]."='".$_POST["value"]."'
                WHERE order_number='".$_POST["order_number"]."'
        ");
    }
}

if(isset($_POST["UPDATE_TAXES_PLEASE"]))
{
    TaxesModerator::UPDATE_TAXES_PLEASE();
}
?>