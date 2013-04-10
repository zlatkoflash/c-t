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
<?php require_once("php/settings.php"); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>" />
    <title><?php the_title(); ?></title>
    <link rel="stylesheet" type="text/css" media="all" href="<?php bloginfo( 'stylesheet_url' ); ?>" />
	
	<script language="javascript" src="<?php bloginfo("template_url"); ?>/js/jstween/tween.js"></script>
    <script language="javascript" src="<?php bloginfo("template_url"); ?>/js/jstween/opacitytween.js"></script>
	<script language="javascript" src="<?php bloginfo("template_url"); ?>/js/laser-template.js"></script>
	<script language="javascript" src="<?php bloginfo("template_url"); ?>/js/manual-template.js"></script>
	<script language="javascript" src="<?php bloginfo("template_url"); ?>/js/tools.js" type="text/javascript"></script>
    <script language="javascript" src="<?php bloginfo("template_url"); ?>/js/jquery.min.js" type="text/javascript"></script>
    <script language="javascript" src="<?php bloginfo("template_url"); ?>/js/jquery-ui.min.js" type="text/javascript"></script>
    
</head>

<body class="cursorDefault">
	<?php
    	if($post->post_title == Cheque::TYPE_THANK_U)
		{
			?>
			<script type="text/javascript"> if (!window.mstag) mstag = {loadTag : function(){},time : (new Date()).getTime()};</script> <script id="mstag_tops" type="text/javascript" src="//flex.atdmt.com/mstag/site/db8cdfae-973e-4bf1-8b1a-0d42c7bb2a6b/mstag.js"></script> <script type="text/javascript"> mstag.loadTag("analytics", {dedup:"1",domainId:"951892",type:"1",actionid:"72041"})</script> <noscript> <iframe src="//flex.atdmt.com/mstag/tag/db8cdfae-973e-4bf1-8b1a-0d42c7bb2a6b/analytics.html?dedup=1&domainId=951892&type=1&actionid=72041" frameborder="0" scrolling="no" width="1" height="1" style="visibility:hidden;display:none"> </iframe> </noscript>
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


