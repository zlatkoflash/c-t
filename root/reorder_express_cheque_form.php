<?php
	require_once("templates/php/tools.php");
?>
<?php
/**
 * This file adds the Portfolio template to our Child Theme.
 *
 * @author Greg Rickaby
 * @package Child
 * @subpackage Customizations
 */

/*
Template Name: Reorder Express Cheque Form
*/

// Add custom body class to the head
add_filter( 'body_class', 'add_body_class' );
function add_body_class( $classes ) {
   $classes[] = 'portfolio';
   return $classes;
}

add_filter( 'genesis_pre_get_option_site_layout', '__genesis_return_full_width_content' ); // Force Full-Width Layout
remove_action( 'genesis_before_loop', 'genesis_do_breadcrumbs' ); // Removes breadcrumbs
remove_action( 'genesis_post_title','genesis_do_post_title' ); // Removes post title
remove_action( 'genesis_post_content', 'genesis_do_post_content' ); // Removes content
add_action( 'genesis_post_content', 'child_do_content' ); // Adds your custom page code/content
function child_do_content() 
{?>
<style>
	.separatorDIV
{
	height:1px;
	background-color:#333;
	margin-top:10px;
	margin-bottom:10px;
}
.border_black_go{border-color:#000000;}
/*================================Standard css========================================*/
.holderRightParceForm
{
	border-style:solid;
	border-color:#000;
	border-width:1px;
	margin-bottom:10px;
}
.holderRightParceForm___intoForm
{
	padding:10px;
	padding-top:10px;
}
.titleRightForm
{
	color:#FFFFFF;
	background-color:#003399;
	padding:5px;
	border-bottom-style:solid;
	border-width:1px;
	border-color:#000000;
}
.subTitleRightForm
{
	color:#FFFFFF;
	background-color:#0033ff;
	padding:5px;
	border-width:1px;
	border-color:#000000;
	font-size:10px;
	text-align:left;
}
.btnORDERCHEQUE
{
	text-align:center;
	padding-top:10px;
	padding-bottom:10px;
}
.btnORDERCHEQUE img
{
	cursor:pointer;
}
.clearBoth{clear:both;}
.floatLEft{float:left;}
.floatRight{float:right;}
.fontSize14px
{
	font-size:14px;
}
.fontSize18px
{
	font-size:18px;
}
.alignCenter{text-align:center;}
.alignLeft{text-align:left;}
.alignRight{text-align:right;}

.textDecorationLineTrought{text-decoration:line-through;}

.borderStyleNONE{border-style:none;}
.borderStyleSolid{border-style:solid;}
.borderStyleSolid{border-style:dotted;}

.widthAUTO{width:auto;}
.width100Percent{width:100% !important;}
.width50Percent{width:50%;}
.width45Percent{width:45%;}
.width48Percent{width:48%;}
.width900PX{width:900px;}
.width700PX{width:700px;}
.width500PX{width:500px;}
.width40px{width:40px !important;}
.width70px{width:70px !important;}
.width100px{width:100px;}
.width126px{width:126px;}
.width150px{width:150px !important;}
.width180px{width:180px;}
.width200px{width:200px;}
.width250px{width:250px;}
.width300px{width:300px !important;}
.width400px{width:400px !important;}

.height22PX{height:22px;}
.heightAUTO{height:auto;}
.heigth100Percent{height:100%;}

.lineTextHeight15{line-height:15px;}
.lineTextHeight19{line-height:19px;}
.lineTextHeight22{line-height:22px;}
.lineTextHeight23{line-height:23px !important;}

.marginLeftRightForms{margin-left:2px;}
.margin2px{margin:2px;}
.margin3px{margin:3px;}
.margin5px{margin:5px;}
.marginBottom2px{margin-bottom:2px;}
.marginBottom10px{margin-bottom:10px;}
.marginLeft5px{margin-left:5px;}
.marginLeft7px{margin-left:7px;}
.marginLeft10px{margin-left:10px;}
.marginLeft30px{margin-left:30px;}
.marginLeft50px{margin-left:50px;}
.marginLeft55px{margin-left:55px;}
.margin__0___AUTO{margin:0 auto;}
.marginTop20px{margin-top:20px;}

.padding15px{padding:15px;}
.padding25px{padding:25px;}
.paddingLeft50px{padding-left:50px;}
.paddingRight50px{padding-right:50px;}
.paddingTop20px{padding-top:20px;}

.cursorPointer{cursor:pointer;}
.cursorDefault{cursor:default;}

.colorChequeSlidingHelp
{
	/*
	background-color:#3399FF;*/
}
.colorBGWhite{background-color:#FFFFFF;}

.positionRelative{position:relative;}
.positionAbsolute{position:absolute;}
.positionFixed{position:fixed;}

.zIndex666{z-index:666;}

.padding30px{padding:30px;}
.padding10px{padding:10px;}

.colorRED{color:#F00;}
.colorCCCCCC{color:#CCC !important;}
.colorbe1e2d{color:#be1e2d !important;}

.displayNone{display:none;}
.displayInline{display:inline;}

.visibilityHidden{visibility:hidden;}

.border_style_dotted
{
	border-style:dotted;
}
.borderGrayDotted
{
	border-style:dotted;
	border-color:Gray;
	border-width:1px;
}

.bg_E9E9E9{background-color:#E9E9E9;}
.bg_CCC{background-color:#CCC;}
.bg_0C9{background-color:#0C9;}
.bg_FFF{background-color:#FFF;}
.bg_1796ea{background-color:#1796ea;}
.bg_F5F5F5{background-color:#F5F5F5;}
.bg_DADADA{background-color:#DADADA;}

.positionTopLeft{left:0px; top:0px;}

.overflowAUTO{overflow:auto;}
.overflowSCROLL{overflow:scroll;}
.overflowHIDDEN{overflow:hidden;}

/*
*
*This is style for SEARCH
*/

.arrowSortingSIZE
{
	width:12px;
	height:11px;
}
.arrowSortingNagore
{
	background-image:url(images/dodatoci/270px-black_triangle2_w12_nagore.png);
}
.arrowSortingNadolu
{
	background-image:url(images/dodatoci/270px-black_triangle2_svg_w12_nadolu.png);
}
.navSearchGoToFirstPage{background-image:url(images/dodatoci/search-assets/search_assets_03.png);}
.navSearchGoBack{background-image:url(images/dodatoci/search-assets/search_assets_04.png);}
.navSearchGoNext{background-image:url(images/dodatoci/search-assets/search_assets_05.png);}
.navSearchGoToTheLast{background-image:url(images/dodatoci/search-assets/search_assets_06.png);}
.searchPreloader
{
	width:126px;
	height:22px;
	background-image:url(images/dodatoci/search-assets/ajax-loader.gif);
}

.fontWeightBOLD{font-weight:bold;}
/*
*
*This is style for SEARCH
*/

.panelWhiteShadow_topLeft
{
	width:14px;
	height:14px;
	background-image:url(images/products_editor_assets/cheque_admin_editings_03.png);
}
.panelWhiteShadow_Left
{
	width:14px;
	background-image:url(images/products_editor_assets/cheque_admin_editings_11.png);
	background-repeat:repeat-y;
}
.panelWhiteShadow_bottomLeft
{
	width:14px;
	height:11px;
	background-image:url(images/products_editor_assets/cheque_admin_editings_16.png);
}

.panelWhiteShadow_middleTop
{
	height:14px;
	background-image:url(images/products_editor_assets/cheque_admin_editings_04.png);
	background-repeat:repeat-x;
}
.panelWhiteShadow_middleCenter
{
	background-color:#FFF;
}
.panelWhiteShadow_middleBottom
{
	height:11px;
	background-image:url(images/products_editor_assets/cheque_admin_editings_18.png);
	background-repeat:repeat-x;
}

.panelWhiteShadow_topRight
{
	width:31px;
	height:14px;
	background-image:url(images/products_editor_assets/cheque_admin_editings_06.png);
}
.panelWhiteShadow_middleCenterRight
{
	background-image:url(images/products_editor_assets/cheque_admin_editings_13.png);
	width:31px;
	height:33px;
}
.panelWhiteShadow_bottomRight
{
	width:31px;
	height:11px;
	background-image:url(images/products_editor_assets/cheque_admin_editings_19.png);
}
.panelWhiteShadow_RightSimetric
{
	background-image:url(images/products_editor_assets/cheque_admin_editings_10.png);
	width:31px;
	background-repeat:repeat-y;
}
</style>

<form id="quick_reorder_form" action="../wp-content/themes/genesis/templates/php/tools.php" method="post" enctype="multipart/form-data">
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
                <input type="text" name="name" class="validate[required] border_black_go" />
            </div>
            <div class="clearBoth"></div>
        </div>
        <div class="marginBottom10px">
            <div class="floatLEft width180px">
                Company
            </div>
            <div class="floatLEft">
                <input type="text" name="company border_black_go" class="border_black_go" />
            </div>
            <div class="clearBoth"></div>
        </div>
        <div class="marginBottom10px">
            <div class="floatLEft width180px">
                Phone*
            </div>
            <div class="floatLEft">
                <input type="text" class="validate[required] border_black_go" name="phone" />
            </div>
            <div class="clearBoth"></div>
        </div>
        <div class="marginBottom10px">
            <div class="floatLEft width180px">
                E-mail*
            </div>
            <div class="floatLEft">
                <input type="text" class="validate[required] border_black_go" name="email" />
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
                <input type="text" name="previus_order" class="border_black_go" />
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
                <input type="text" class="validate[required] border_black_go"  name="start_number" />
            </div>
            <div class="clearBoth"></div>
        </div>
        <div class="marginBottom10px">
            <div class="floatLEft width180px">
                Notes
            </div>
            <div class="floatLEft">
                <textarea style="height:100px; width:230px;" id="notes_text_area" name="notes_text_area" class="border_black_go"></textarea>
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
                		<input type="text" name="credit_card_number" class="border_black_go" />
                    </div>
                    <div class="floatLEft marginLeft10px">
                		<input type="text" class="width40px border_black_go" name="expire_credit_card" />
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

<?php }
genesis();