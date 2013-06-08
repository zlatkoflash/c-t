<?php require_once("php/tools.php"); ?>
<?php require_once("php/products_moderator.php"); ?>
<?php require_once("right_forms.php"); ?>

<?php

/**
 * The main template file.
 *
 * This is the cheque template that will be using for manual and laser cheque
 *
 * @package WordPress
 * @subpackage c-t
 * @since c-t 1.0
 */
class PagesModerator {

    const PAGE_ADMIN = "admin";
    const PAGE_ADMIN_DIRECTIONS = "directions";
    const PAGE_ADMIN_LOGIN = "login";
    const PAGE_ADMIN_ORDER_UPDATE_COMPLETE = "admin_order_complete";

}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html <?php language_attributes(); ?>>
    <head>
        <meta charset="<?php bloginfo('charset'); ?>" />
        <title><?php the_title(); ?></title>
        <link rel="stylesheet" type="text/css" media="all" href="<?php bloginfo('stylesheet_url'); ?>" />

        <script language="javascript" src="<?php bloginfo("template_url"); ?>/js/jstween/tween.js"></script>
        <script language="javascript" src="<?php bloginfo("template_url"); ?>/js/jstween/opacitytween.js"></script>
        <script language="javascript" src="<?php bloginfo("template_url"); ?>/js/settings.js" type="text/javascript"></script>

        <script src="http://cdn.optimizely.com/js/137839470.js"></script>

        <script language="javascript" src="<?php bloginfo("template_url"); ?>/js/jquery.min.js" type="text/javascript"></script>
        <script language="javascript" src="<?php bloginfo("template_url"); ?>/js/jquery-ui.min.js" type="text/javascript"></script>
        <script src="<?php bloginfo("template_url"); ?>/js/jquery.numeric.js"></script>
        <script>
            $(document).ready(function(e)
            {
                $(".input_just_numeric").numeric();
            });
        </script>

        <link rel="stylesheet" type="text/css" href="<?php bloginfo("template_url"); ?>/css/validationEngine.jquery.css" />
        <script type="text/javascript" src="<?php bloginfo("template_url"); ?>/js/languages/jquery.validationEngine-en.js"></script>
        <script type="text/javascript" src="<?php bloginfo("template_url"); ?>/js/jquery.validationEngine.js"></script>

        <script src="<?php bloginfo("template_url"); ?>/js/lightbox.js"></script>

        <script>
            settings.URL_TO_PHP_FOLDER = "<?php bloginfo("template_url"); ?>/php/";
            settings.URL_TO_PHP_TOOLS = settings.URL_TO_PHP_FOLDER + "tools.php";
            settings.URL_TO_PDF_VIEWER_TOOL = settings.URL_TO_PHP_FOLDER + "tools/pdf_viewer.php";
            settings.URL_TO_PHP_PRODUCTS = settings.URL_TO_PHP_FOLDER + "products_moderator.php";
            settings.WEBSITE_TO_ORDERS_ORDERS_FOLDER_PATH = "<?php print SETTINGS::WEBSITE_TO_ORDERS_ORDERS_FOLDER_PATH; ?>";
            settings.ADMIN_PATH = "<?php print SETTINGS::URL_TO_ADMIN_PAGE; ?>";
        </script>
        <script language="javascript" src="<?php bloginfo("template_url"); ?>/js/tools.js" type="text/javascript"></script>
        <script>
            HELPER.H.PATH_TO_THEME = "<?php bloginfo("template_url"); ?>";
        </script>
        <script language="javascript" src="<?php bloginfo("template_url"); ?>/js/laser-template.js"></script>
        <script language="javascript" src="<?php bloginfo("template_url"); ?>/js/manual-template.js"></script>

    </head>

    <body class="cursorDefault">
        <?php
        if ($post->post_title == Cheque::TYPE_THANK_U) {
            ?>
            <script type="text/javascript"> if (!window.mstag)
                    mstag = {loadTag: function() {
                        }, time: (new Date()).getTime()};</script> <script id="mstag_tops" type="text/javascript" src="//flex.atdmt.com/mstag/site/db8cdfae-973e-4bf1-8b1a-0d42c7bb2a6b/mstag.js"></script> <script type="text/javascript"> mstag.loadTag("analytics", {dedup: "1", domainId: "951892", type: "1", actionid: "72041"})</script> <noscript> <iframe src="//flex.atdmt.com/mstag/tag/db8cdfae-973e-4bf1-8b1a-0d42c7bb2a6b/analytics.html?dedup=1&domainId=951892&type=1&actionid=72041" frameborder="0" scrolling="no" width="1" height="1" style="visibility:hidden;display:none"> </iframe> </noscript>
                <?php
            }
            ?>

        <div id="top_header">
            <!--Here need to go what is on top-->
            <?php
            /*
              bloginfo("template_url");
              print "/js/jquery.min.js";
             */
            ?>
        </div>

        <?php require_once("controls.php"); ?>
