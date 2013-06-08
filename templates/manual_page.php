<?php if(!isset($_SESSION))session_start();?>

<?php
/*
  Template Name: Manual Page Template

 */
?>

<?php get_header(); ?>

<?php require_once(get_template_directory()."/js/manual_template.php"); ?>

<?php require_once get_template_directory().'/templates/cheques/top_header_banners.php'; ?>

<?php $cheque = new Cheque(Cheque::TYPE_MANUAL); ?>

<?php RightForms::$RF = new RightForms($cheque); ?>


<div id="cheque_holder" class="<?php print $cheque->cssMainWidth; ?>"><!-- Main cheque holder start -->
    <div id="cheque_render_holder" class="floatLEft colorChequeSlidingHelp <?php print $cheque->cheque_render_holder_width; ?>">
        <div id="cheque_render_holderABSOLUTE">
            <div></div>	
            <?php
            RightForms::$RF->draw_AknowlegementsExplanations();
            RightForms::$RF->draw_SubmitOrderBTN();
            ?>
            <div id="cheque_render_holderABSOLUTEForTEMPLATE" style="border-color:#FF0000;">
            </div>
            <?php
            RightForms::$RF->draw_SubmitOrderBTN();
            ?>
        </div>
    </div>
    <div id="right_forms_holder" class="floatRight">
        <form id="form" action="#" enctype="multipart/form-data" method="post">
            <?php
            TaxesModerator::$TaxesModerator = new TaxesModerator();
            RightForms::$RF->showMe();
            ?>
        </form>
    </div>
    <div class="clearBoth"></div>
</div><!-- Main cheque holder end -->
<script>
    HELPER.H.URL = "<?php print HELPWordpress::url(); ?>";
    Cheque.C.setType("<?php print $cheque->type; ?>");
    Cheque.C.render();
</script>


<?php get_footer(); ?>