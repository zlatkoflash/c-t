<div>
	<div class="floatRight marginLeft30px">
		<a href="#" class="do_logout_btn">Do Logout?</a>
	</div>
	<div class="floatRight marginLeft30px">
		Logged User: <a href="#"><b><?php print User::$LOGGED_USER->display_name; ?></b></a>
	</div>
        <?php if(User::$LOGGED_USER->user_nicename == User::TYPE_ADMINISTRATOR) { ?>
	<div class="floatRight">
		<a href="../admin/">Back To Menu</a>
	</div>
        <?php } ?>
	<div class="clearBoth"></div>
	<hr />
</div>
<script>
	$(".do_logout_btn").click(function(e)
	{
		$.post(settings.URL_TO_PHP_TOOLS, 
			{
				DO_LOGOUT:"Yes i will do it now"
			}, function(data)
			{
				window.location.href = "../admin/";
			});
		return false;
	});
</script>