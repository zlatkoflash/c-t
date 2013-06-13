
<?php
if (isset($_POST["order_not_exists"])) {
    ?>
    <div class="marginBottom10px colorRED">
        Order <b><?php print $_POST["orderThatNotExist"]; ?></b> not exist.
    </div>
    <?php
}
?>
<form action="../admin-order-editor/" 
      id="form_submit_order" method="post" enctype="multipart/form-data">
    <input type="hidden" name="user_is_logged" value="yes" />
    <input type="hidden" name="show_editing_form" value="yes" />
    <input type="hidden" name="setupNewVariable_from_admin" id="setupNewVariable_from_admin"  value="false" />
    <input type="hidden" name="admin_action" id="admin_action" value="<?php print PagesModerator::PAGE_ADMIN; ?>" />
    <div class="marginBottom10px">
        Enter Order Number:
        <div>
            <input type="text" name="fso_order_number" id="fso_order_number" class="width400px text_input_upper_case"  />
            <input id="btn_open_order_by_name" type="button" value="Open" class="floatRight buttonOpenBlackOrder" />
            <script>
                $("#btn_open_order_by_name").click(function(e)
                {
                    $("#fso_order_number").val($("#fso_order_number").val().toUpperCase());
                    $("#form_submit_order").submit();
                });
                <?php if (User::$LOGGED_USER->get_wp_user_role() == User::TYPE_CONTRIBUTOR){ ?>
                    $("#btn_open_order_by_name").val("Resubmit the csv.csv");
                    $("#btn_open_order_by_name").addClass("floatLEft");
                    $("#btn_open_order_by_name").removeClass("floatRight");
                    $("#form_submit_order").attr("action", settings.URL_TO_PHP_TOOLS);
                    $("#admin_action").val("UPDATE_CSVCSV_INTO__csv_files__FOLDER");
                <?php } ?>
            </script>
        </div>

    </div>
    <div>
        <style>
            .buttonOpenBlackOrder
            {
                background-color:#06C;
                color:#FFF;
                font-weight:bold;
            }
        </style>
        <div>
            <script>
                function new_manual()
                {
                    createNewOrder__byChequeType("manual");
                }
                function new_laser()
                {
                    createNewOrder__byChequeType("laser");
                }
                function createNewOrder__byChequeType(cheque_type)
                {
                    $.post(settings.URL_TO_PHP_TOOLS,
                            {
                                CREATE_ORDER_NEW_ByChequeType: cheque_type
                            }, function(data)
                    {
                        $("#setupNewVariable_from_admin").val("true");
                        var xmlfor = $.parseXML(data);
                        var orderNumber = $($(xmlfor).find("order_number").get(0)).text();
                        var cheque_type = $($(xmlfor).find("cheque_type").get(0)).text();
                        $("#fso_order_number").val(orderNumber);
                        document.getElementById("form_submit_order").submit();
                    });
                }
            </script>
            <?php if(User::$LOGGED_USER->get_wp_user_role() == User::TYPE_ADMINISTRATOR) { ?>
            <input class="buttonOpenBlackOrder" type="button" value="New Manual Order" onclick="new_manual();" />
            <input class="buttonOpenBlackOrder" type="button" value="New Laser Order" onclick="new_laser();" />
            <?php } ?>
        </div>
        <div class="clearBoth"></div>
    </div>
</form>


<?php
if (User::$LOGGED_USER->get_wp_user_role() == User::TYPE_ADMINISTRATOR) {
    SearchOrders::showSearchForm();
}

print ">>>>>>>>>>>>>>>>>>>>>".User::$LOGGED_USER->get_wp_user_role();
?>