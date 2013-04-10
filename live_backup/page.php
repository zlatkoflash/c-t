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
?>

<?php require_once("php/db_details.php"); ?>
<?php require_once("php/tools.php"); ?>
<?php require_once("right_forms.php"); ?>

<?php
	/*For online*/
	$cheque = NULL;
	if($post->post_title == Cheque::TYPE_LASER)
	{
		$cheque = new Cheque( Cheque::TYPE_LASER );
	}
	else if($post->post_title == Cheque::TYPE_MANUAL)
	{
		$cheque = new Cheque( Cheque::TYPE_MANUAL );
	}
	//$cheque = new Cheque( Cheque::TYPE_LASER );
	//$cheque = new Cheque( Cheque::TYPE_MANUAL );
	//print "[+++".$post->post_title."]";
	//$post->post_title = "checkout";
?>

<?php get_header(); ?>
<?php 
	//echo Paypal_payment_accept(); 
?>

			
		 <?php
		 	$pageID = "28"; 
		 	$page = get_page( $pageID ); 
			//print $page->post_content;
		 ?>
        
<?php 
	/*
	if ( get_option('permalink_structure') != '' ) { echo 'permalinks enabled'; } 
	else{echo "Permalinks not enabled.";}
	*/
?>

<?php 
	require_once("preloader.php"); 
?>

<script>
    objHelper.PATH_TO_THEME = "<?php print HELPWordpress::template_url(); ?>";
</script>

<?php if($post->post_title == Cheque::TYPE_MANUAL || $post->post_title == Cheque::TYPE_LASER) {?>

	<?php $RightFObject = new RightForms( $cheque ); ?>
	
	<div id="headerTopSmall">
    	
    </div>
    <div id="headerTopBig">
    	<img src="<?php print HELPWordpress::template_url(); ?>/images/order-header.png" />
    </div>
    <div id="cheque_holder" class="<?php print $cheque->cssMainWidth; ?>"><!-- Main cheque holder start -->
        <div id="cheque_render_holder" class="floatLEft colorChequeSlidingHelp <?php print $cheque->cheque_render_holder_width; ?>">
       		 <div id="cheque_render_holderABSOLUTE" style="">
             	<?php
					$RightFObject->draw_AknowlegementsExplanations();
                	$RightFObject->draw_SubmitOrderBTN();
				?>
             	<div id="cheque_render_holderABSOLUTEForTEMPLATE" style="border-color:#FF0000;">
                </div>
             	<?php
					if($cheque->type == Cheque::TYPE_MANUAL)
					{
						$RightFObject->draw_AknowlegementsExplanations();
					}
                	$RightFObject->draw_SubmitOrderBTN();
				?>
             </div>
        </div>
        <div id="right_forms_holder" class="floatRight">
        	<form id="form" action="#" enctype="multipart/form-data" method="post">
        		<?php
					$RightFObject->showMe();
				?>
            </form>
        </div>
        <div class="clearBoth"></div>
    </div><!-- Main cheque holder end -->
	<script>
		objHelper.URL = "<?php print HELPWordpress::url(); ?>";
		objCheque.setType("<?php print $cheque->type; ?>");
		objCheque.render();
    </script>
    <?php 
		//require_once("form-go-to-checkout-by-order.php"); 
	?>
<?php } 
	else if($post->post_title == Cheque::CHECKOUT)
	{
		?>
        <div id="headerTopSmall">
        </div>
        <div id="headerTopBig">
            <img src="<?php print HELPWordpress::template_url(); ?>/images/order-header.png" />
        </div>
        <?php
		require_once("checkout.php");
	}
	else if($post->post_title == Cheque::TYPE_THANK_U) 
	{ 
		require_once("after-sending-emal-info.php");
	}
	else if($post->post_title == Cheque::TRANSACTION_STATUS)
	{
		?>
        <div id="headerTopSmall">
        </div>
        <div id="headerTopBig">
            <img src="<?php print HELPWordpress::template_url(); ?>/images/order-header.png" />
        </div>
        <?php
		require_once("trstat.php");
	}
	else if($post->post_title == "ADMIN")
	{
		require_once('admin.php');
		if(isset($_POST["show_editing_form"]))
		{
			$cheque = new Cheque( $_POST["chequeType"] );
			$RightFObject = new RightForms( $cheque );
			Admin::SHOW_EDITING_FORM($cheque, $RightFObject);
		}
	}
?>

<?php get_sidebar(); ?>
<?php get_footer(); ?>