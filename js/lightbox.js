
	function LightBox()
	{
		this.show = function(iframe_src)
		{
			this.resize();
			$("#lightbox_div").removeClass("displayNone");
			$("#lightbox_div").animate({opacity:1}, function(e)
			{
			});
			$("#lightbox_iframe").attr("src", iframe_src);
		}
		this.hide = function()
		{
			$("#lightbox_div").animate({opacity:0}, function(e)
			{
				$("#lightbox_div").addClass("displayNone");
				$("#lightbox_iframe").attr("src", "");
			});
		}
		this.resize = function()
		{
			var padding = 100;
			var width = $(window).width()-2*padding;
			var height = $(window).height()-2*padding;
			$("#lightbox_iframe").css("width", width+"px");
			$("#lightbox_iframe").css("height", height+"px");
			var left = ($(window).width()-$("#lightbox_div").width())/2;
			var top = ($(window).height()-$("#lightbox_div").height())/2;
			$("#lightbox_div").css("left", left+"px");
			$("#lightbox_div").css("top", top+"px");
		}
		$(document).ready(function(e)
		{
			$(window).resize(function(e)
			{
				if(!$("#lightbox_div").is(".displayNone"))
				{
					LightBox.LB.resize();
				}
			});
			$("#lightbox_close").click(function(e)
			{
				LightBox.LB.hide();
			});
		});
	}
	LightBox.LB = new LightBox();
