<style>
	#preloaderHolder
	{
		position:fixed;
		left:0px;
		top:0px;
		width:100%;
		height:100%;
		z-index:149;
		
		opacity:0;
		-moz-opacity:0;
		filter:alpha(opacity=0);
		
		visibility:hidden;
	}
	#preloaderHolderForms
	{
		position:relative;
	}
	#preloaderBG
	{
		background-color:#FFF;
		opacity:0.9;
		-moz-opacity:0.9;
		filter:alpha(opacity=90);
	}
	#preloaderIMAGE
	{
		position:absolute;
		z-index:150;
		left:0px;
		top:0px;
		visibility:visible;
	}
</style>

<div id="preloaderHolder" style="filter:Alpha(opacity=0);">
	<div id="preloaderHolderForms">
    	<div id="preloaderBG"></div>
        <img id="preloaderIMAGE" style="z-index:152;" src="<?php print bloginfo("template_url"); ?>/images/preloader.gif">
    </div>
</div>
<script language="javascript">
	function Preloader()
	{
		this.preloaderBG = function(){return document.getElementById("preloaderBG");}
		this.preloaderHolder = function(){return document.getElementById("preloaderHolder");}
		this.preloaderIMAGE = function(){return document.getElementById("preloaderIMAGE");}
		
		this.onEnterFrame = function()
		{
			this.setBGSize();
			this.setLogoPosition();
		}
		this.setBGSize = function()
		{
			if(this.preloaderBG().offsetWidth != this.preloaderHolder().offsetWidth)
			{
				this.preloaderBG().style.width = this.preloaderHolder().offsetWidth+"px";
			}
			if(this.preloaderBG().offsetHeight != this.preloaderHolder().offsetHeight)
			{
				this.preloaderBG().style.height = this.preloaderHolder().offsetHeight+"px";
			}
		}
		this.setLogoPosition = function()
		{
			//document.getElementById().offsetLeft
			//document.getElementById().offsetTop
			//document.getElementById().offsetWidth
			//document.getElementById().offsetHeight
			var pozX = (this.preloaderHolder().offsetWidth-this.preloaderIMAGE().offsetWidth)/2;
			var pozY = (this.preloaderHolder().offsetHeight-this.preloaderIMAGE().offsetHeight)/2;
			if(this.preloaderIMAGE().offsetLeft != pozX)
			{
				this.preloaderIMAGE().style.left = pozX+"px";
			}
			if(this.preloaderIMAGE().offsetTop != pozY)
			{
				this.preloaderIMAGE().style.top = pozY+"px";
			}
		}
		this.indexOneEE = setInterval("objPreloader.onEnterFrame();", 20);
		this.tweenAlpha = null;
		this.show = function()
		{
			this.preloaderHolder().style.visibility = "visible";
			if(this.tweenAlpha != null)this.tweenAlpha.stop();
			this.tweenAlpha = new OpacityTween(document.getElementById('preloaderHolder'),Tween.strongEaseOut, 0, 100, 1);
			this.tweenAlpha.start();
		}
		this.hide = function()
		{
			this.preloaderHolder().style.visibility = "hidden";
		}
	}
	var objPreloader = new Preloader();
</script>