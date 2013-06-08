<?php if(!isset($_SESSION))session_start();?>

<?php
/*
  Template Name: Admin Page After Submit The Order

 */
?>


<?php get_header(); ?>

<div id="adminSimpleUpdateForm" class="margin__0___AUTO width500PX borderGrayDotted colorBGWhite padding30px">

<?php require_once("admin/admin_order_complete.php"); ?>
    
</div>

<?php get_footer(); ?>