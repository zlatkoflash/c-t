<?php

	if(!class_exists("SETTINGS"))
	{
		require_once("php/settings.php");
	}
	if(!class_exists("DB_DETAILS"))
	{
		require_once('php/db_details.php');
	}
	if(!class_exists("XMLParser"))
	{
		require_once('php/tools.php');
	}
	if
	(	!class_exists("SearchOrders") 
			&&
		$_POST["admin_action"] == PagesModerator::PAGE_ADMIN_DIRECTIONS
	)
	{
		?>
		<script>
			settings.IS_SEARCH_FORM = true;
		</script>
		<?php
		require_once('search.php');
	}
        
	//This form is for editing details of the products
	ProductsModerator::initTheHTMLForm();
	SettingsModerator::init_form();
	/*
	 * With this case we have settings for the 
	 * cheque application
	 * actualy is one object from SettingsModerator class that hold all
	 * information of row with id from MySQL table settings
	 * */
	SettingsModerator::init();

?>
	
<form id="form_menu_navigation" action="<?php print SETTINGS::URL_TO_ADMIN_PAGE; ?>" enctype="multipart/form-data" method="post">
	<input type="hidden" name="admin_action" id="admin_action" />
</form>
<script>
	
	function MenuAdmin()
	{
		this.action = 
		this.submit_menu = function(menu_name)
		{
			$("#admin_action").val( menu_name );
			$("#form_menu_navigation").submit();
		}
		$(document).ready(function(e)
		{
			$(".admin_menu_item").click(function(e)
			{
				MenuAdmin.MA.submit_menu( $(this).attr("menu_item_name") );
				return false;
			});
		});
	}
	MenuAdmin.MA = new MenuAdmin();
	
</script>

<div id="adminSimpleUpdateForm" class="margin__0___AUTO width500PX borderGrayDotted colorBGWhite padding30px">
	<?php
	
		User::INIT();
		if(!User::$LOGGED_USER->isloged)
		{
			require_once("templates/admin/login.php");	
		}
		else
		{
			if(isset($_POST["after_update_order_please"]))
			{
				$_POST["admin_action"] = PagesModerator::PAGE_ADMIN_ORDER_UPDATE_COMPLETE;
			}
			require_once("templates/admin/admin_user_status.php");
			if(!isset($_POST["admin_action"]))
			{
				require_once("templates/admin/admin_menu.php");
			}
			else if($_POST["admin_action"] == PagesModerator::PAGE_ADMIN)
			{
				require_once("templates/admin/admin.php");	
			}
			else if($_POST["admin_action"] == PagesModerator::PAGE_ADMIN_DIRECTIONS)
			{
				require_once("templates/admin/directions.php");	
			}
			else if($_POST["admin_action"] == PagesModerator::PAGE_ADMIN_ORDER_UPDATE_COMPLETE)
			{
				require_once("templates/admin/admin_order_complete.php");	
			}
			else
			{
				require_once("templates/admin/admin_menu.php");
			}
		}
	?>
</div>