<?php if(!isset($_SESSION))session_start();?>

<?php
/*
  Template Name: Thank You Page

 */
?>
<?php get_header(); ?>


<style>
	.positionFixced100Posto
	{
		position:fixed;
		width:100%;
		height:100%;
		background-color:#ffffff;
		padding:50px;
	}
	a
	{
		font-weight:bold;
		cursor:pointer;
		text-decoration:underline;
		color:Gray;
	} 
	a:hover
	{
		color:Black;
	}
</style>

<div class="positionFixced100Posto">
    <div style=" border-style:none; color:Gray; font-family:Arial; font-size:12pt; text-align:center; width:500px; margin:0 auto; ">
          Your online proof has been successfully submitted to: <br /><br />
          <img src="<?php print HELPWordpress::template_url(); ?>/images/order-submibtted-page.gif" /><br /><br />
          Your Order Confirmation # is <b><?php print $_POST["order_number"]; ?></b><br />
		  You will receive an order confirmation by email,<br />
          If you do not receive this email please call us at 1-866-760-2661<br />
          or<br />
          Email us at <a href="mailto:orders@chequesnow.ca">orders@chequesnow.ca</a><br /><br />
          <a href="http://chequesnow.ca">Click here to be taken back to ChequesNow homepage. </a>
          <br><br><br>  
          <span id="siteseal"><script type="text/javascript" src="https://seal.godaddy.com/getSeal?sealID=dMMcwOn8oJnqW5xgnVAwh19bWlgRjyYy3Y0tEmST08kRlLvTex"></script>
      </div>
    <script type="text/javascript">
        var _gaq = _gaq || [];
        _gaq.push(['_setAccount','UA-12885718-5']);
        _gaq.push(['_trackPageview']);
        (function() {
            var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
            ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
            var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
        })();
    </script>

		<!-- BEGIN LivePerson Monitor. --><script language='javascript'> var lpMTagConfig = {'lpServer' : "server.iad.liveperson.net",'lpNumber' : "39990179",'lpProtocol' : (document.location.toString().indexOf('https:')==0) ? 'https' : 'http'}; function lpAddMonitorTag(src){if(typeof(src)=='undefined'||typeof(src)=='object'){src=lpMTagConfig.lpMTagSrc?lpMTagConfig.lpMTagSrc:'/hcp/html/mTag.js';}if(src.indexOf('http')!=0){src=lpMTagConfig.lpProtocol+"://"+lpMTagConfig.lpServer+src+'?site='+lpMTagConfig.lpNumber;}else{if(src.indexOf('site=')<0){if(src.indexOf('?')<0)src=src+'?';else src=src+'&';src=src+'site='+lpMTagConfig.lpNumber;}};var s=document.createElement('script');s.setAttribute('type','text/javascript');s.setAttribute('charset','iso-8859-1');s.setAttribute('src',src);document.getElementsByTagName('head').item(0).appendChild(s);} if (window.attachEvent) window.attachEvent('onload',lpAddMonitorTag); else window.addEventListener("load",lpAddMonitorTag,false);</script><!-- END LivePerson Monitor. -->
        
        <!-- Google Code for Cheque Order Conversion Page -->
		<script type="text/javascript">
			/* <![CDATA[ */
			var google_conversion_id = 1033894780;
			var google_conversion_language = "en";
			var google_conversion_format = "2";
			var google_conversion_color = "3366ff";
			var google_conversion_label = "NxpDCPzYtwEQ_Pb_7AM";
			var google_conversion_value = 0;
			/* ]]> */
        </script>
        <script type="text/javascript" src="http://www.googleadservices.com/pagead/conversion.js"></script>
        <noscript>
            <div style="display:inline;">
            <img height="1" width="1" style="border-style:none;" alt="" src="http://www.googleadservices.com/pagead/conversion/1033894780/?label=NxpDCPzYtwEQ_Pb_7AM&amp;guid=ON&amp;script=0"/>
            </div>
        </noscript>
        
        <script type="text/javascript"> if (!window.mstag) mstag = {loadTag : function(){},time : (new Date()).getTime()};</script> <script id="mstag_tops" type="text/javascript" src="//flex.atdmt.com/mstag/site/db8cdfae-973e-4bf1-8b1a-0d42c7bb2a6b/mstag.js"></script> <script type="text/javascript"> mstag.loadTag("analytics", {dedup:"1",domainId:"951892",type:"1",actionid:"72041"})</script> <noscript> <iframe src="//flex.atdmt.com/mstag/tag/db8cdfae-973e-4bf1-8b1a-0d42c7bb2a6b/analytics.html?dedup=1&domainId=951892&type=1&actionid=72041" frameborder="0" scrolling="no" width="1" height="1" style="visibility:hidden;display:none"> </iframe> </noscript>
    
    
</div>

<?php get_footer(); ?>