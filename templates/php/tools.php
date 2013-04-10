<?php

	if(!class_exists("SETTINGS")){require_once("settings.php");}
	if(!class_exists("DB_DETAILS")){require_once( "db_details.php" );}
	
	class QuickReorderFormEmail
	{
		private $from="orders@printnow.ca", $to="orders@printnow.ca", $subject="Quick Re-Order Form";
		private $headers;
		private $mimeToMe,
				$bodyForMe,
				$headersForMe,
				$mailFactory;
		
		public function QuickReorderFormEmail()
		{
			require_once('Mail.php');
			require_once('Mail/mime.php');
			/*
			print $this->emailMessageForMe();
			return;
			*/
			$this->headers = array('From' => $this->from, 'Subject' => $this->subject); 
			$this->mimeToMe = new Mail_Mime();
			$this->attach_the_logo();$this->mimeToMe->setHtmlBody( $this->emailMessageForMe() );
			$this->bodyForMe = $this->mimeToMe->get();
			$this->headersForMe = $this->mimeToMe->headers( $this->headers );
			$this->mailFactory = &Mail::factory('mail');
			if($this->mailFactory->send($this->to, $this->headersForMe, $this->bodyForMe))
			{
			}
			else
			{
			}
			?>
            <script>
            	//window.location.href = "http://www.chequesnow.ca/reorder/";
				window.location.href = "http://www.chequesnow.ca/reorder-thankyou/";
            </script>
			<?php
		}
		private function attach_the_logo()
		{
			if(isset($_FILES["logo_for_attachment"]["name"]))
			{
				$fileNameAttachment = $_FILES["logo_for_attachment"]["name"];
				$fileAttachedType = substr($fileNameAttachment, strrpos($fileNameAttachment, '.') + 1);
				$allowed_extensions = array("jpg", "jpeg", "gif", "bmp" , "png" , "psd", "pdf", "cdr", "ai", "eps", "tif", "tiff");
				$allowed_ext = false;
				for($i=0; $i<sizeof($allowed_extensions); $i++) 
				{ 
					if(strcasecmp($allowed_extensions[$i],$fileAttachedType) == 0)$allowed_ext = true;  
				}
				if($allowed_ext == true)
				{
					$this->mimeToMe->addAttachment($_FILES["logo_for_attachment"]["tmp_name"],'application/'.$fileAttachedType,$_FILES["logo_for_attachment"]["name"]);
				}
				else
				{
					//no extension allowed
				}
			}
			else
			{
			}
		}
		private function emailMessageForMe()
		{
			return '
			
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
</head>
<body bgcolor="#ffffff"> 
	<div style="width:600px; border-style:solid;border-width:1px; background-color:#F7E8D7; padding:20px;">
		<p style="font-family:Arial; font-size:10pt; text-align:left; margin:0px; padding:0px;">Name:&nbsp;<b>'.$_POST["name"].'</b></p>
		<p style="font-family:Arial; font-size:10pt; text-align:left; margin:0px; padding:0px;">Company:&nbsp;<b>'.$_POST["company"].'</b></p>
		<p style="font-family:Arial; font-size:10pt; text-align:left; margin:0px; padding:0px;">Phone:&nbsp;<b>'.$_POST["phone"].'</b></p>
		<p style="font-family:Arial; font-size:10pt; text-align:left; margin:0px; padding:0px;">E-mail:&nbsp;<b>'.$_POST["email"].'</b></p>
		<p style="font-family:Arial; font-size:10pt; text-align:left; margin:0px; padding:0px;">Province:&nbsp;<b>'.$_POST["provincies"].'</b></p>
		<p style="font-family:Arial; font-size:10pt; text-align:left; margin:0px; padding:0px;">Previous Order#:&nbsp;<b>'.$_POST["previus_order"].'</b></p>
		<p style="font-family:Arial; font-size:10pt; text-align:left; margin:0px; padding:0px;">Cheque Type:&nbsp;<b>'.$_POST["cheque_type"].'</b></p>
		<p style="font-family:Arial; font-size:10pt; text-align:left; margin:0px; padding:0px;">I will scan/fax copy(optional):&nbsp;<b>'.$_POST["i_will_scan_or_fax"].'</b></p>
		<p style="font-family:Arial; font-size:10pt; text-align:left; margin:0px; padding:0px;">Start#:&nbsp;<b>'.$_POST["start_number"].'</b></p>
		<p style="font-family:Arial; font-size:10pt; text-align:left; margin:0px; padding:0px;">Notes:&nbsp;<b>'.$_POST["notes_text_area"].'</b></p>
		<p style="font-family:Arial; font-size:10pt; text-align:left; margin:0px; padding:0px;">Payment Method:&nbsp;<b>'.$this->payment_method().'</b></p>
	</div>
</body> 
</html> 
				';
		}
		private function payment_method()
		{
			switch($_POST["payment_method_cb_group"])
			{
				case "credit_card":
				{
					return "Credit Card: ".$_POST["credit_card_number"].", Expiry:".$_POST["expire_credit_card"];
				}break;
				case "call_me":
				{
					return "Call me for my credit card information";
				}break;
				case "debit":
				{
					return "Debit my account";
				}break;
				case "other":
				{
					return "(Other)Please call me";
				}break;
			}
		}
	}
	if(isset($_POST["sent_email_please"]))
	{
		new QuickReorderFormEmail();
	}

?>