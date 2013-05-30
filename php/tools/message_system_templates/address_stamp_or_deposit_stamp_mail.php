<?php

	class AddressDepositStampMail extends MailBase
	{
		private $dfs_stamp;
		
		public function AddressDepositStampMail($data)
		{
			//print_r( $data );
			$this->to = $data["to"];
			$this->from = $data["from"];
			$this->chequeData = $data["chequeData"];
			$this->dfs_stamp = $data["dfs_stamp"];
		}
		private function get_label_stamp()
		{
			if(Product::$SELF_INKING_STAMP->additional_type == "deposit")
			{
				return "Deposit Stamp Order";
			}
			else if(Product::$SELF_INKING_STAMP->additional_type == "name")
			{	
				return "Address Stamp Order";
			}
			else
			{
				return "1 Address Stamp and 1 Deposit Stamp";
			}
		}
		
		public function send()
		{
			$this->mime = new Mail_Mime();
			$this->mime->setHtmlBody( $this->email_html() );
			$this->mime->addAttachment($this->dfs_stamp->PDFContent(), 'application/pdf', "dfs-stamp.pdf", false, 'base64');
			$this->mailFactory = &Mail::factory('mail');
			$this->headers = array('From' => $this->from, 
				'Subject' => $this->get_label_stamp()." ".
				$this->chequeData->CINAComapanyNameLinivche()." Confirmation #".
				OrderNumber::$CURR_ORDER->orderLabel_withPower()."");
			$this->headers = $this->mime->headers( $this->headers );
			//print $this->email_html();
			$this->mailFactory->send($this->to, $this->headers, $this->mime->get());
		}
		private function email_html()
		{
			$shipingAddressX3Lines = "";
			if($_POST["address_1_".ChequeData::TYPE_SHIPING] != "")
			{
				$shipingAddressX3Lines .= '<p style="font-family:Arial; font-size:10pt; text-align:left; margin:0px; padding:0px;">Shipping Address 1:<b>'. $_POST["address_1_".ChequeData::TYPE_SHIPING] .'</b></p>';
			}
			if($_POST["address_2_".ChequeData::TYPE_SHIPING] != "")
			{
				$shipingAddressX3Lines .= '<p style="font-family:Arial; font-size:10pt; text-align:left; margin:0px; padding:0px;">Shipping Address 2:<b>'. $_POST["address_2_".ChequeData::TYPE_SHIPING] .'</b></p>';
			}
			if($_POST["address_3_".ChequeData::TYPE_SHIPING] != "")
			{
				$shipingAddressX3Lines .= '<p style="font-family:Arial; font-size:10pt; text-align:left; margin:0px; padding:0px;">Shipping Address 3:<b>'. $_POST["address_3_".ChequeData::TYPE_SHIPING] .'</b></p>';
			}
			
			$addresses = array(0=>"", 1=>"", 2=>"", 3=>"", 4=>"");
			if($this->chequeData->compInfoAddressLine1() != '')
			{
				$addresses[0] = 
				'<p style="font-family:Arial; font-size:10pt; text-align:left; margin:0px; padding:0px;">Company Address 1: <b>'. $this->chequeData->compInfoAddressLine1() .'</b></p>'; 
			}
			if($this->chequeData->compInfoAddressLine2() != '')
			{
				$addresses[1] = 
				'<p style="font-family:Arial; font-size:10pt; text-align:left; margin:0px; padding:0px;">Company Address 2: <b>'. $this->chequeData->compInfoAddressLine2() .'</b></p>';
			}
			if($this->chequeData->compInfoAddressLine3() != '')
			{
				$addresses[2] =
				'<p style="font-family:Arial; font-size:10pt; text-align:left; margin:0px; padding:0px;">Company Address 3: <b>'. $this->chequeData->compInfoAddressLine3() .'</b></p>';
			}
			if($this->chequeData->compInfoAddressLine4() != '')
			{
				$addresses[3] =
				'<p style="font-family:Arial; font-size:10pt; text-align:left; margin:0px; padding:0px;">Company Address 4: <b>'. $this->chequeData->compInfoAddressLine4() .'</b></p>';
			}
			
			$email_discount_code = "54";
			if($_POST["email_discount_code"] != "")
			{
				$email_discount_code = $_POST["email_discount_code"];
			}
			if(Product::$SELF_INKING_STAMP->additional_type == "address_and_deposit")
			{
				$style_text = " 1 Address Stamp ";
			}
			else
			{
				$style_text = Product::$SELF_INKING_STAMP->title;
			}
			return '
					<html>
					<head>
					<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
					</head>
                    <body bgcolor="#ffffff" style=""> 
					<div style="width:600px; border-style:solid;border-width:1px; background-color:#F7E8D7; padding:20px; font-family:Arial; font-size:12px;">
					
						<p style="font-family:Arial; font-size:10pt; text-align:left; margin:0px; padding:0px;">
						Hello,<br>
I need to place the following '.$this->get_label_stamp().' order:
						</p>
						<br><br>
						
                        <p style="text-align:left; font-size:10pt; margin:0px; padding:0px;">Quantity/Style: <b>W8824 '.$style_text.'</b></p>
						<p style="text-align:left; font-size:10pt; margin:0px; padding:0px;">
						Imprint<!--: Please take all required information from the attached PDF.-->
						</p>
                                                <p><b>DEPOSIT TO THE CREDIT OF</b></p>
						'.$this->company_info_address($addresses).'
						
						<p style="text-align:left; font-size:10pt; margin:0px; padding:0px;">
						Shipping: Please drop ship the order directly to the customer using the information Below:
						</p>
						<br>
						<p style="font-family:Arial; font-size:10pt; text-align:left; margin:0px; padding:0px;">Shipping Company Name:&nbsp;<b>'. $_POST["companyName_".ChequeData::TYPE_SHIPING] .'</b></p>
						<p style="font-family:Arial; font-size:10pt; text-align:left; margin:0px; padding:0px;">Shipping Contact Name:&nbsp;<b>'. $_POST["contactName_".ChequeData::TYPE_SHIPING] .'</b></p>
						
						'.$shipingAddressX3Lines.'
						
						<p style="font-family:Arial; font-size:10pt; text-align:left; margin:0px; padding:0px;">Shipping City:<b>'. $_POST["city_".ChequeData::TYPE_SHIPING] .'</b></p>
						<p style="font-family:Arial; font-size:10pt; text-align:left; margin:0px; padding:0px;">Shipping Province:<b>'. $_POST["province_".ChequeData::TYPE_SHIPING] .'</b></p>
						<p style="font-family:Arial; font-size:10pt; text-align:left; margin:0px; padding:0px;">Shipping Postal Code:<b>'. $_POST["postalCode_".ChequeData::TYPE_SHIPING] .'</b></p>
						
						<p style="font-family:Arial; font-size:10pt; text-align:left; margin:0px; padding:0px;">Shipping Phone:&nbsp;<b>'. $_POST["phone_".ChequeData::TYPE_SHIPING] .'</b></p>
						
						
						<br>
						<p style="font-family:Arial; font-size:10pt; text-align:left; margin:0px; padding:0px;">Thank you, any questions'." don't".' hesitate to call/email.</p>
						<br/>
						<p style="font-family:Arial; font-size:10pt; text-align:left; margin:0px; padding:0px;">** Please use discount code '.$email_discount_code.' for this NEW order. which is listed on your website **</p>
						<br>
						<p style="font-family:Arial; font-size:10pt; text-align:left; margin:0px; padding:0px;">
						Ryan Gilchrist<br>
Print & Cheques Now Inc.<br>
4319 - 54 Ave S.E.<br>
Calgary, Alberta  T2C 2A2<br>
<b>(403) 269-2661</b> Ext <b>224 F (403) 279-8082</b><br>
<a href="mailto:ryan@printnow.ca">ryan@printnow.ca</a>
						</p>
                	</div>
                    </body> 
                </html>
				';
		}
		private function company_info_address($addresses)
		{
				//<p style="font-family:Arial; font-size:10pt; text-align:left; margin:0px; padding:0px;">Bank Name:&nbsp;<b>
			//print_r($addresses);
			$deposit_details = '<p style="font-family:Arial; font-size:10pt; text-align:left; margin:0px; padding:0px;">
					Company Name: <b>'. $this->chequeData->CINACompanyName().'</b><br>
					Second Company Name:<b>'.$this->chequeData->CINACompanySecondName().'</b></p>
						<p style="font-family:Arial; font-size:10pt; text-align:left; margin:0px; padding:0px;"><b>'. 
						$this->chequeData->brunchNumber()." - ".$this->chequeData->transitNumber()
						." - ".$this->chequeData->accountNumber() .'</b></p>
						<br>';
			if(Product::$SELF_INKING_STAMP->additional_type == "deposit")
			return $deposit_details;
			else if(Product::$SELF_INKING_STAMP->additional_type == "name")
			return '<p style="font-family:Arial; font-size:10pt; text-align:left; margin:0px; padding:0px;">Company Name: <b>'. $this->chequeData->CINACompanyName()
			.'</b><br>Company Second Name:<b>'.$this->chequeData->CINACompanySecondName().'</b></p>
						<br/>
						
						
						'.$addresses[0].$addresses[1].$addresses[2].$addresses[3].'
						<br><br/>';
			else if(Product::$SELF_INKING_STAMP->additional_type == "address_and_deposit")
			{
			//print_r($addresses);
			$deposit_details = '<p style="font-family:Arial; font-size:10pt; text-align:left; margin:0px; padding:0px;">
					Company Name: <b>'. $this->chequeData->CINACompanyName().'</b><br>
					Second Company Name:<b>'.$this->chequeData->CINACompanySecondName().'</b></p>
						';
			return '
						<p style="font-family:Arial; font-size:10pt; text-align:left; margin:0px; padding:0px;">
							Company Name: <b>'.$this->chequeData->CINACompanyName().'</b>
							<br>
							Second Company Name: <b>'.$this->chequeData->CINACompanySecondName().'</b>
						</p>
						'.$addresses[0].$addresses[1].$addresses[2].$addresses[3].'
						<br/>
						<br/>
						<p style="text-align:left; font-size:10pt; margin:0px; padding:0px;">Quantity/Style: <b>W8824 1 Deposit Stamp</b></p>
						<br/>
						
						<p style="text-align:left; font-size:10pt; margin:0px; padding:0px;">
						Imprint<!--: Please take all required information from the attached PDF.-->
						</p>
						<br>'.$deposit_details.'
						<p style="font-family:Arial; font-size:10pt; text-align:left; margin:0px; padding:0px;"><b>'. 
						$this->chequeData->brunchNumber()." - ".$this->chequeData->transitNumber()
						." - ".$this->chequeData->accountNumber() .' '.$this->chequeData->currencyNumber45().'</b></p>
						<br/><br/>';
			}
		}
		public static function INIT_AND_SEND($email_moderator)
		{
			if(Product::$SELF_INKING_STAMP->invoice_amount() != 0)
			{
				$address_deposit_stamp_mail = new AddressDepositStampMail
				(
					array
					(
						"from"=>$email_moderator->from,
						"to"=>$email_moderator->to,
						"chequeData"=>$email_moderator->chequeData,
						"dfs_stamp"=>$email_moderator->SEmailObject->dfs_stamp
					)
				);
				$address_deposit_stamp_mail->send();
			}
		}
	}

?>