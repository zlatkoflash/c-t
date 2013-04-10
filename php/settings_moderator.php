<?php

	class SettingsModerator
	{
		public static function init_form()
		{
			?>
            	<div id="settings_form_moderator" class="positionAbsolute zIndex666 displayNone" style="">
                	<div class="floatLEft">
                    	<div class="panelWhiteShadow_topLeft"></div>
                    	<div class="panelWhiteShadow_Left"></div>
                        <div class="panelWhiteShadow_bottomLeft"></div>
                    </div>
                	<div class="floatLEft width250px">
                    	<div class="panelWhiteShadow_middleTop"></div>
                        <div class="panelWhiteShadow_middleCenter">
                        	<div id="price_product_updater" class="marginBottom2px">
                            	<div class="floatLEft lineTextHeight19 label_for_pop_up">Label what should do</div><div class="floatRight">
                                	<input id="input_settings_updater" type="text" class="width70px" />
                                </div>
                            	<div class="clearBoth"></div>
                            </div>
                            <hr />
                        	<div class="alignRight padding15px">
                            	<a href="#" class="cancel_save_settings">Cancel</a> | 
                            	<a id="product_moderator_update_button" href="#" class="colorbe1e2d update_settings_btn">Update</a>
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
                	function FormSettingsEditor()
                	{
                		this.actual_idvar_for_editing = null;
						this.setup_sizes = function()
						{
							$("#settings_form_moderator .panelWhiteShadow_middleCenter").css("height", "80px");
							if($("#settings_form_moderator .panelWhiteShadow_middleCenter").innerHeight() < 
							$("#settings_form_moderator .panelWhiteShadow_middleCenterRight").innerHeight())
							{
								$("#settings_form_moderator .panelWhiteShadow_middleCenter").css("height", 
									$("#settings_form_moderator .panelWhiteShadow_middleCenterRight").innerHeight()+"px");
							}
							var heightForRightPartsTopBottom = $("#settings_form_moderator .width250px").innerHeight();
							heightForRightPartsTopBottom = 
								heightForRightPartsTopBottom
								-
								($("#settings_form_moderator .panelWhiteShadow_middleCenterRight").innerHeight()+
							$("#settings_form_moderator .panelWhiteShadow_topRight").innerHeight()
							+$("#settings_form_moderator .panelWhiteShadow_bottomRight").innerHeight());
							heightForRightPartsTopBottom = heightForRightPartsTopBottom/2;
							$("#settings_form_moderator .panelWhiteShadow_RightSimetric").css("height", heightForRightPartsTopBottom+"px");
							$("#settings_form_moderator .panelWhiteShadow_Left").css("height", 
								$("#settings_form_moderator .panelWhiteShadow_middleCenter").innerHeight()+"px");	
						}
						this.setup = function(actual_variable, id_input)
						{
							$("#input_settings_updater").val( actual_variable );
							this.actual_idvar_for_editing = id_input;
							clearTimeout(this.setup_timeout_to_hide_index);
							$("#settings_form_moderator").removeClass("displayNone");
							this.setup_sizes();
						}
						this.setup_timeout_to_hide_index = -1;
						this.setup_timeout_to_hide = function()
						{
							clearTimeout(this.setup_timeout_to_hide_index);
							this.setup_timeout_to_hide_index = setTimeout("FormSettingsEditor.FSE.hide();", 200);
						}
						this.hide = function()
						{
							$("#settings_form_moderator").addClass("displayNone");
						}
						this.show = function()
						{
							clearTimeout(this.setup_timeout_to_hide_index);
							$("#settings_form_moderator").removeClass("displayNone");
						}
						this.update = function()
						{
							$("#"+this.actual_idvar_for_editing).val($("#input_settings_updater").val());
							$.post(settings.URL_TO_PHP_PRODUCTS,
								{
									DO_UPDATE_SETTINGS_PLEASE:"YES I WILL DO IT NOW",
									VARIABLE:this.actual_idvar_for_editing,
									VALUE:$("#input_settings_updater").val()
								},function(data)
							{
								//after updating the settings
							});
						}
						/*
						 *	just for testing
						 *  */
						//this.setup_sizes();
						$(document).ready(function(e)
						{
							$(".inputs_setting_editors").mouseover(function(e)
							{
								$(".label_for_pop_up").html($(this).attr("label_for_pop_up"));
								FormSettingsEditor.FSE.setup($(this).val(), $(this).attr("id"));
								var leftPosition = $(this).offset().left-$("#settings_form_moderator").innerWidth();
								var topPosition = $(this).offset().top-$("#settings_form_moderator").innerHeight()/2+
									$(this).innerHeight()/2;
								$("#settings_form_moderator").css("left", leftPosition+"px");
								$("#settings_form_moderator").css("top", topPosition+"px");
							});
							$(".inputs_setting_editors").mouseout(function(e)
							{
								FormSettingsEditor.FSE.setup_timeout_to_hide();
							});
							$("#settings_form_moderator").mouseover(function(e)
							{
								FormSettingsEditor.FSE.show();
							});
							$("#settings_form_moderator").mouseout(function(e)
							{
								FormSettingsEditor.FSE.setup_timeout_to_hide();
							});
							$(".cancel_save_settings").click(function(e)
							{
								FormSettingsEditor.FSE.hide();
								return false;
							});
							$(".update_settings_btn").click(function(e)
							{
								FormSettingsEditor.FSE.update();
								return false;	
							});
						});
                	}
                	FormSettingsEditor.FSE = new FormSettingsEditor();
                </script>
			<?php
		}
		public static $SETT=NULL;
		
		public $email_discount_code, $email_discount_code_var="email_discount_code";
		
		public function SettingsModerator($settings_data)
		{
			$this->email_discount_code = $settings_data["email_discount_code"];
		}
		public static function init()
		{
			$sett_row = DB_DETAILS::ADD_ACTION("
				SELECT * FROM settings
				WHERE id=1
			", DB_DETAILS::$TYPE_SELECT);
			self::$SETT = new SettingsModerator($sett_row[0]);
		}
		
		public static function DO_UPDATE_SETTINGS_PLEASE()
		{
			DB_DETAILS::ADD_ACTION("
				UPDATE settings SET ".$_POST["VARIABLE"]."='".$_POST["VALUE"]."'
				WHERE id=1
			");
		}
	}

	if(isset($_POST["DO_UPDATE_SETTINGS_PLEASE"]))
	{
		SettingsModerator::DO_UPDATE_SETTINGS_PLEASE();
	}

?>