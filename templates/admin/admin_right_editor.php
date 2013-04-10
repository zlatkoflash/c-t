
  <style>
    .input_bottom_border_line
    {
      border:none !important;
      border-bottom:solid 1px #000000 !important;
      width: 100px !important;
    }
    .holder_divs_right_admin_form .holder_divs_right_admin_form_divs
    {
      line-height: 17px;
      margin-bottom: 5px;
    }
  </style>

  <div class="marginTop20px">
      <div class="floatLEft width100px alignLeft lineTextHeight22">FILE APPROVAL</div>
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
  <div>
      <div class="floatLEft width100px alignLeft lineTextHeight22">Existing</div>
      <div class="floatLEft">
          <select id="existing_customer_or_contact" name="existing_customer_or_contact">
              <option value=""></option>

              <option value="Existing Customer">Customer</option>
              <option value="Existing Contact">Contact</option>
          </select>
      </div>
      <div class="clearBoth"></div>
  </div>
<div>
  <input type="radio" value="Exect Repeat" id="exect_repeat_check_box"
         name="x3options_admin_right_form" class="validate[required] maing_right_x3_radioboxes"
         class="validate[required]"> Exect Repeat
</div>
<div>
  <div>
    <input type="radio" value="New Order" id="new_order_right_column"
           name="x3options_admin_right_form"
           class="validate[required] maing_right_x3_radioboxes"> New Order
    <select id="new_order_right_column_type" name="new_order_right_column_type">
      <option value="">Select Layout</option>
      <option value="Copy Layout">Copy Layout</option>
      <option value="Reference Layout">Reference Layout</option>
    </select>
  </div>
  <div>
    <input color_temp="#cccccc" text_temp="Layout Details" class="width100Percent input_gray_text_on_start" 
           type="text" id="new_order_right_column_name_for_type" name="new_order_right_column_name_for_type" />
  
    <script>
    $(".input_gray_text_on_start").focus(function(e)
    {
        if($(this).val() == $(this).attr("text_temp"))
        {
            $(this).val("");
            $(this).css("color", "#000000");
        }
    });
    </script>
  </div>
</div>
<div class="marginBottom10px marginTop20px">
  <input type="radio" value="Change Repeat" id="change_repeat_cheques_cb" name="x3options_admin_right_form"
         class="validate[required] maing_right_x3_radioboxes"> Change Repeat
</div>
<div class="paddingLeft20px">
  <style>
    .right_form_change_repeat_help_input_validation
    {
      /* */
      width: 20px !important; height: 1px !important;
      visibility: hidden;
    }
  </style>
  <div>
    <input type="text" value=""
           class="right_form_change_repeat_help_input_validation validate[required]" />
  </div>
  <div class="floatLEft holder_divs_right_admin_form">
    <div class="holder_divs_right_admin_form_divs">
      <input type="checkbox" input_my="change_repeat_cheques_quantity" value="yes" class="change_repeat_cheques_cb_global" id="change_repeat_cheques_cb_quantity" name="change_repeat_cheques_cb_quantity"> Quantity
    </div>
    <div class="holder_divs_right_admin_form_divs">
      <input type="checkbox" input_my="change_repeat_cheques_start" value="yes" class="change_repeat_cheques_cb_global" id="change_repeat_cheques_cb_start" name="change_repeat_cheques_cb_start"> Start #
    </div>
    <div class="holder_divs_right_admin_form_divs">
      <input type="checkbox" input_my="change_repeat_cheques_stock" value="yes" class="change_repeat_cheques_cb_global" id="change_repeat_cheques_cb_stock" name="change_repeat_cheques_cb_stock"> Stock
    </div>
    <div class="holder_divs_right_admin_form_divs">
      <input type="checkbox" input_my="change_repeat_cheques_imprint" value="yes" class="change_repeat_cheques_cb_global" id="change_repeat_cheques_cb_imprint" name="change_repeat_cheques_cb_imprint"> Imprint
    </div>
    <div class="holder_divs_right_admin_form_divs">
      <input type="checkbox" input_my="change_repeat_cheques_other" value="yes" class="change_repeat_cheques_cb_global" id="change_repeat_cheques_cb_other" name="change_repeat_cheques_cb_other"> Other
    </div>
    <div class="holder_divs_right_admin_form_divs">
      <input type="checkbox" input_my="change_repeat_cheques_see_atchd" value="yes" class="change_repeat_cheques_cb_global" id="change_repeat_cheques_cb_see_atchd" name="change_repeat_cheques_cb_see_atchd"> See Atchd
    </div>
  </div>
  <div class="floatLEft marginLeft10px holder_divs_right_admin_form">
    <div class="holder_divs_right_admin_form_divs">
      <input type="text" class="input_bottom_border_line input_bottom_border_line_read_only"
           id="change_repeat_cheques_quantity" name="change_repeat_cheques_quantity"   />
    </div>
    <div class="holder_divs_right_admin_form_divs">
      <input type="text" class="input_bottom_border_line input_bottom_border_line_read_only"
           id="change_repeat_cheques_start" name="change_repeat_cheques_start"   />
    </div>
    <div class="holder_divs_right_admin_form_divs">
      <input type="text" class="input_bottom_border_line input_bottom_border_line_read_only"
           id="change_repeat_cheques_stock" name="change_repeat_cheques_stock" />
    </div>
    <div class="holder_divs_right_admin_form_divs">
      <input type="text" class="input_bottom_border_line input_bottom_border_line_read_only"
           id="change_repeat_cheques_imprint" name="change_repeat_cheques_imprint"  />
    </div>
    <div class="holder_divs_right_admin_form_divs">
      <input type="text" class="input_bottom_border_line input_bottom_border_line_read_only"
           id="change_repeat_cheques_other" name="change_repeat_cheques_other" />
    </div>
    <div class="holder_divs_right_admin_form_divs">
      <input type="text" class="input_bottom_border_line input_bottom_border_line_read_only"
           id="change_repeat_cheques_see_atchd" name="change_repeat_cheques_see_atchd"  />
    </div>
  </div>
  <div class="clearBoth"></div>
</div>
  <div class="marginTop20px">
      Job Name:
      <br>
      <textarea id="job_name_text" name="job_name_text" class="width100Percent" style="height:60px;">

      </textarea>
  </div>
<script>
    
    
  <?php
  if(isset($_POST["exect_repeat_check_box"]))
  {
    ?>
    $("#exect_repeat_check_box").prop("checked", true);
    <?php
  }
  ?>
  <?php
  if(isset($_POST["new_order_right_column"]))
  {
    ?>
    $("#new_order_right_column").prop("checked", true);
    <?php
  }
  ?>
  
  
  
  <?php
  if(isset($_POST["change_repeat_cheques_cb"]))
  {
    ?>
    $("#change_repeat_cheques_cb").prop("checked", true);
    <?php
  }
  ?>
  
  
  <?php
  if(isset($_POST["change_repeat_cheques_cb_quantity"]))
  {
    ?>
    $("#change_repeat_cheques_cb_quantity").prop("checked", true);
    <?php
  }
  ?>
  <?php
  if(isset($_POST["change_repeat_cheques_cb_start"]))
  {
    ?>
    $("#change_repeat_cheques_cb_start").prop("checked", true);
    <?php
  }
  ?>
  <?php
  if(isset($_POST["change_repeat_cheques_cb_stock"]))
  {
    ?>
    $("#change_repeat_cheques_cb_stock").prop("checked", true);
    <?php
  }
  ?>
  <?php
  if(isset($_POST["change_repeat_cheques_cb_imprint"]))
  {
    ?>
    $("#change_repeat_cheques_cb_imprint").prop("checked", true);
    <?php
  }
  ?>
  <?php
  if(isset($_POST["change_repeat_cheques_cb_other"]))
  {
    ?>
    $("#change_repeat_cheques_cb_other").prop("checked", true);
    <?php
  }
  ?>
  <?php
  if(isset($_POST["change_repeat_cheques_cb_see_atchd"]))
  {
    ?>
    $("#change_repeat_cheques_cb_see_atchd").prop("checked", true);
    <?php
  }
  ?>
  
  if($("#change_repeat_cheques_cb").prop("checked"))
  {
      //$(".input_bottom_border_line_read_only").addClass("validate[required]");
  }
  $("#exect_repeat_check_box").click(function(e)
  {
    $(this).prop("checked", true);
    $("#new_order_right_column").prop("checked", false);
    $("#change_repeat_cheques_cb").prop("checked", false);
    RightAdminForms.RAF.look_if_change_repeat_cheques_cb___is_checked();
    RightAdminForms.RAF.add_x3_options_right_form_validate_value();
  });
  $("#new_order_right_column").click(function(e)
  {
    $(this).prop("checked", true);
    $("#exect_repeat_check_box").prop("checked", false);
    $("#change_repeat_cheques_cb").prop("checked", false);
    RightAdminForms.RAF.look_if_change_repeat_cheques_cb___is_checked();
    RightAdminForms.RAF.add_x3_options_right_form_validate_value();
  });
  $("#change_repeat_cheques_cb").click(function(e)
  {
    $(this).prop("checked", true);
    $("#exect_repeat_check_box").prop("checked", false);
    $("#new_order_right_column").prop("checked", false);
    RightAdminForms.RAF.look_if_change_repeat_cheques_cb___is_checked();
    RightAdminForms.RAF.add_x3_options_right_form_validate_value();
  });
  $("#new_order_right_column_type").change(function(e)
  {
    RightAdminForms.RAF.set_new_order_right_column_name_for_type_visibility();
  });
  
  $(".change_repeat_cheques_cb_global").click(function(e)
  {
    RightAdminForms.RAF.add_validation_for_read_only_option_to_check_boxes();
    if($(this).prop("checked"))
    {
      $("#"+$(this).attr("input_my")).addClass("validate[required]");
    }
    else
    {
      $("#"+$(this).attr("input_my")).removeClass("validate[required]");
    }
  });
    
  function RightAdminForms()
  {
    this.look_if_change_repeat_cheques_cb___is_checked = function()
    {
      if($("#change_repeat_cheques_cb").prop("checked"))
      {
        $(".input_bottom_border_line_read_only").attr("readonly", false);
        $(".change_repeat_cheques_cb_global").prop("disabled", false);
        //$(".change_repeat_cheques_cb_global").prop("checked", true);
        //$(".input_bottom_border_line_read_only").addClass("validate[required]");
      }
      else
      {
        $(".input_bottom_border_line_read_only").attr("readonly", true);
        $(".change_repeat_cheques_cb_global").prop("disabled", true);
        //$(".input_bottom_border_line_read_only").removeClass("validate[required]");
      }
      this.add_validation_for_read_only_option_to_check_boxes();
      this.add_validation_for_read_only_option_to_check_boxes__input( "change_repeat_cheques_cb_quantity" );
      this.add_validation_for_read_only_option_to_check_boxes__input( "change_repeat_cheques_cb_start" );
      this.add_validation_for_read_only_option_to_check_boxes__input( "change_repeat_cheques_cb_stock" );
      this.add_validation_for_read_only_option_to_check_boxes__input( "change_repeat_cheques_cb_imprint" );
      this.add_validation_for_read_only_option_to_check_boxes__input( "change_repeat_cheques_cb_other" );
      this.add_validation_for_read_only_option_to_check_boxes__input( "change_repeat_cheques_cb_see_atchd" );
    }
    this.add_validation_for_read_only_option_to_check_boxes = function()
    {
      if(!$("#change_repeat_cheques_cb").prop("checked"))
      {
        $(".right_form_change_repeat_help_input_validation").val("Is ok");
        return;
      }
      if
      (
         $("#change_repeat_cheques_cb_quantity").prop("checked") || 
         $("#change_repeat_cheques_cb_start").prop("checked") || 
         $("#change_repeat_cheques_cb_stock").prop("checked") || 
         $("#change_repeat_cheques_cb_imprint").prop("checked") || 
         $("#change_repeat_cheques_cb_other").prop("checked") || 
         $("#change_repeat_cheques_cb_see_atchd").prop("checked")
      )
      {
        $(".right_form_change_repeat_help_input_validation").val("Is ok");
      }
      else
      {
        $(".right_form_change_repeat_help_input_validation").val("");
      }
    }
    this.add_validation_for_read_only_option_to_check_boxes__input = function(cb_id)
    {
      if($("#change_repeat_cheques_cb").prop("checked"))
      {
        if($("#"+cb_id).prop("checked"))
        {
          $("#"+$("#"+cb_id).attr("input_my")).addClass("validate[required]");
        }
        else
        {
          $("#"+$("#"+cb_id).attr("input_my")).removeClass("validate[required]");
        }
      }
      else
      {
        $("#"+$("#"+cb_id).attr("input_my")).removeClass("validate[required]");
      }
    }
    this.add_x3_options_right_form_validate_value = function()
    {
      $("#additional_help_right_admin_forms_x3_option_is_selected").val("Yes now there is selected one option.");
    }
    this.put_inputs_empthy = function()
    {
      //x3options_admin_right_form new_order_right_column_type new_order_right_column_name_for_type
      $("input[name=x3options_admin_right_form]").prop("checked", false);
      $("#new_order_right_column_type").prop("selectedIndex", 0);
      $("#new_order_right_column_name_for_type").val("");
      $(".change_repeat_cheques_cb_global").prop("checked", false);
      $(".input_bottom_border_line_read_only").val("");
    }
    this.setup_validation_for_NEW_ORDER_radio_button = function()
    {
        //new_order_right_column_type{cb}, new_order_right_column_name_for_type{text}
        if($("#new_order_right_column").prop("checked"))
        {   
            //$("#new_order_right_column_type").addClass("validate[required]");
            $("#new_order_right_column_name_for_type").addClass("validate[required]");
        }
        else
        {
            //$("#new_order_right_column_type").removeClass("validate[required]");
            $("#new_order_right_column_name_for_type").removeClass("validate[required]");
        }
    }
    this.set_new_order_right_column_name_for_type_visibility = function(is_visible)
    {
        if(is_visible != null)
        {
            if(is_visible)
            {
          $("#new_order_right_column_name_for_type").removeClass("displayNone"); 
            }
            else
            {
          $("#new_order_right_column_name_for_type").addClass("displayNone");
            }
            return;
        }
      if($("#new_order_right_column_type").val() != "")
      {
          $("#new_order_right_column_name_for_type").removeClass("displayNone");
      }
      else
      {
          $("#new_order_right_column_name_for_type").addClass("displayNone");
          $("#new_order_right_column_name_for_type").val($("#new_order_right_column_name_for_type").attr("text_temp"));
          $("#new_order_right_column_name_for_type").css("color", "#cccccc");
      }
    }
  }
  RightAdminForms.RAF = new RightAdminForms();
  RightAdminForms.RAF.look_if_change_repeat_cheques_cb___is_checked();
  
  if
  (
   $("#exect_repeat_check_box").prop("checked") ||
   $("#new_order_right_column").prop("checked") ||
   $("#change_repeat_cheques_cb").prop("checked")
  )
  {
    RightAdminForms.RAF.add_x3_options_right_form_validate_value();
  }
  $(".maing_right_x3_radioboxes").click(function(e)
  {
    RightAdminForms.RAF.add_validation_for_read_only_option_to_check_boxes();
    RightAdminForms.RAF.setup_validation_for_NEW_ORDER_radio_button();
  });
  <?php
  if(isset($_POST["x3options_admin_right_form"]))
  {
    ?>
  $("input:radio[name=x3options_admin_right_form][value='<?php print $_POST["x3options_admin_right_form"]; ?>']").attr("checked", true);
    <?php
  }
  ?>
  RightAdminForms.RAF.add_validation_for_read_only_option_to_check_boxes();
  if($("#change_repeat_cheques_cb").prop("checked"))
  {
      $(".change_repeat_cheques_cb_global").prop("disabled", false);
      $(".input_bottom_border_line_read_only").prop("readonly", false);
  }
  else
  {
      $(".change_repeat_cheques_cb_global").prop("disabled", true);
      $(".input_bottom_border_line_read_only").prop("readonly", true);  
  }
  <?php
    function check_the_check_box_for_input($input, $checkbox)
    {
        if($input && $input !="")
        {
            ?>
                $("#<?php print $checkbox; ?>").prop("checked", true);
            <?php
        } 
    }
    check_the_check_box_for_input($_POST["change_repeat_cheques_quantity"], 
                        "change_repeat_cheques_cb_quantity");
    check_the_check_box_for_input($_POST["change_repeat_cheques_start"], 
                        "change_repeat_cheques_cb_start");
    check_the_check_box_for_input($_POST["change_repeat_cheques_stock"], 
                        "change_repeat_cheques_cb_stock");
    check_the_check_box_for_input($_POST["change_repeat_cheques_imprint"], 
                        "change_repeat_cheques_cb_imprint");
    check_the_check_box_for_input($_POST["change_repeat_cheques_other"], 
                        "change_repeat_cheques_cb_other");
    check_the_check_box_for_input($_POST["change_repeat_cheques_see_atchd"], 
                        "change_repeat_cheques_cb_see_atchd");
  ?>
  RightAdminForms.RAF.setup_validation_for_NEW_ORDER_radio_button();
  <?php
  if(isset($_POST["new_order_right_column_type"]) && $_POST["new_order_right_column_type"] != "")
      {
      ?>
  RightAdminForms.RAF.set_new_order_right_column_name_for_type_visibility(true);
          <?php
      }
      else
          {
          ?>
  RightAdminForms.RAF.set_new_order_right_column_name_for_type_visibility(false);
              <?php
          }
  ?>
</script>

<div class="marginTop20px">
    <?php
  RightForms::$RF->draw_SubmitOrderBTN();
    ?>
</div>