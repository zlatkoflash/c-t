            <?php
            //print_r($_POST);
            ?>
            <div class="marginBottom10px">           
            	Order <b><?php print OrdersDatabase::GET_ORDER_POWER( $_POST["fso_order_number"] ); ?></b> is updated.
            </div>
            <div class="marginBottom10px">
            	<form action="../admin-order-editor/" method="post" enctype="multipart/form-data">
                	<input type="submit" value="Edit order <?php print OrdersDatabase::GET_ORDER_POWER( $_POST["fso_order_number"] ); ?> " />
                    <input type="hidden" name="user_is_logged" value="yes" />
                	<input type="hidden" name="show_editing_form" value="true" />
                    <input type="hidden" name="fso_order_number" value="<?php print $_POST["fso_order_number"]; ?>" />
                    <input type="hidden" name="admin_action" id="admin_action" value="<?php print PagesModerator::PAGE_ADMIN; ?>" />
                </form>
            </div>
            <div>
                <form action="../admin-orders-navigator/" method="post" enctype="multipart/form-data">
                	<input type="hidden" name="user_is_logged" value="yes" />
                	<input type="submit" value="Edit another order" />
                    <input type="hidden" name="admin_action" id="admin_action" value="<?php print PagesModerator::PAGE_ADMIN_DIRECTIONS; ?>" />
                </form>
            </div>