
	<!--
		Sirinata i visinata na lightbox 
		zavisat od 
		iframe
		-->
	<style>
		#lightbox_div
		{
			padding:10px;
			border: 1px solid #CCCCCC;
			background-color:#FFFFFF;
			position:fixed;
		}
		#lightbox_iframe
		{
			border: 1px solid #CCCCCC;
		}
	</style>
	<div id="lightbox_div" class="shadow zIndex666 displayNone">
		<div id="lightbox_close" class="floatRight padding10px cursorPointer">
			<img width="17" src="<?php bloginfo("template_url"); ?>/images/close.png" />
		</div>
		<div class="clearBoth"></div>
		<iframe id="lightbox_iframe" src=""></iframe>
		<script>
			//$("#lightbox_iframe").html("Ova e samo test");
		</script>
	</div>
        
        <div id="custom_validation">
            
        </div>
        
        
        <style>
            .how_to_enter_micr_account_number
            {
                position: fixed;
                z-index: 999;
                width: 100%;
                height: 100%;
                display: none;
            }
            .how_to_enter_micr_account_number_image
            {
                position: absolute;
                left:50px;
                top:10px;
            }
            .shadowBlack 
            {
                    -moz-box-shadow: 3px 3px 4px #000;
                    -webkit-box-shadow: 3px 3px 4px #000;
                    box-shadow: 3px 3px 4px #000;
                    /* For IE 8 */
                    -ms-filter: "progid:DXImageTransform.Microsoft.Shadow(Strength=4, Direction=135, Color='#000000')";
                    /* For IE 5.5 - 7 */
                    filter: progid:DXImageTransform.Microsoft.Shadow(Strength=4, Direction=135, Color='#000000');
            }
        </style>
        <div class="how_to_enter_micr_account_number">
            <div class="positionRelative">
                <img class="how_to_enter_micr_account_number_image shadowBlack"  width="650"
                     src="<?php bloginfo("template_url"); ?>/images/HOW-TO-ENTER-MICR-ACCOUNT-N.png">
            </div>
        </div>
        <script>
            $(".how_to_enter_micr_account_number").click(function(e)
            {
                $(this).hide(500);
            });
            
            $(document).ready(function(e)
            {
                $(".all_chars_upper_case").keyup(function(e)
                {
                    $(this).val( $(this).val().toUpperCase() );
                });
            });
        </script>