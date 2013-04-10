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
        <div>
           <!--This is futer and will be empthy-->
        </div>

<?php
	/* Always have wp_footer() just before the closing </body>
	 * tag of your theme, or you will break many plugins, which
	 * generally use this hook to reference JavaScript files.
	 */
	//print "[".OrderNumber::$CURR_ORDER->orderFileName."]";
	wp_footer();
?>


<!-- BEGIN LivePerson Monitor. --><script language='javascript'> var lpMTagConfig = {'lpServer' :"server.iad.liveperson.net",'lpNumber' : "39990179",'lpProtocol' : (document.location.toString().indexOf('https:')==0) ? 'https' : 'http'}; function lpAddMonitorTag(src){if(typeof(src)=='undefined'||typeof(src)=='object'){src=lpMTagConfig.lpMTagSrc?lpMTagConfig.lpMTagSrc:'/hcp/html/mTag.js';}if(src.indexOf('http')!=0){src=lpMTagConfig.lpProtocol+"://"+lpMTagConfig.lpServer+src+'?site='+lpMTagConfig.lpNumber;}else{if(src.indexOf('site=')<0){if(src.indexOf('?')<0)src=src+'?';else src=src+'&';src=src+'site='+lpMTagConfig.lpNumber;}};var s=document.createElement('script');s.setAttribute('type','text/javascript');s.setAttribute('charset','iso-8859-1');s.setAttribute('src',src);document.getElementsByTagName('head').item(0).appendChild(s);} if (window.attachEvent) window.attachEvent('onload',lpAddMonitorTag); else window.addEventListener("load",lpAddMonitorTag,false);</script><!-- END LivePerson Monitor. -->


	<script type="text/javascript">
	
		setTimeout(function(){var a=document.createElement("script");
		var b=document.getElementsByTagName("script")[0];
		a.src=document.location.protocol+"//dnn506yrbagrg.cloudfront.net/pages/scripts/0013/0288.js?"+Math.floor(new Date().getTime()/3600000);
		a.async=true;a.type="text/javascript";b.parentNode.insertBefore(a,b)}, 1);
	
	</script>


</html>