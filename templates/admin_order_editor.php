<?php if(!isset($_SESSION))session_start();?>

<?php
/*
  Template Name: Admin Orders Editor

 */
?>

<?php get_header(); ?>

<?php require_once 'admin/admin_see_if_there_is_logged_user.php'; ?>

<?php
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

<div id="adminSimpleUpdateForm" class="margin__0___AUTO width500PX borderGrayDotted colorBGWhite padding30px">

<?php require_once(get_template_directory()."/templates/admin/admin_user_status.php"); ?>
    
<?php require_once(get_template_directory()."/templates/admin/admin.php"); ?>

</div>

<?php get_footer(); ?>