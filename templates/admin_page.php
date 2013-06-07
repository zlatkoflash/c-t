<?php
/*
  Template Name: Admin Page Template

 */
?>

<?php get_header(); ?>

<?php require_once 'admin/admin_see_if_there_is_logged_user.php'; ?>

<div id="adminSimpleUpdateForm" class="margin__0___AUTO width500PX borderGrayDotted colorBGWhite padding30px">
    <div>
        <div>MENU</div>
        <div class="floatLEft">
            <a href="./admin-orders-navigator/">Directions</a>
        </div>
        <!--
        <div class="floatLEft marginLeft30px">
                <a class="admin_menu_item" menu_item_name="<?php print PagesModerator::PAGE_ADMIN; ?>" href="#">Admin</a>
        </div>
        -->
        <div class="clearBoth"></div>

    </div>
</div>

<?php get_footer(); ?>