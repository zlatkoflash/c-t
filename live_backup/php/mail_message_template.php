<?php
	if(!class_exists("OrderNumber")){require_once( "tools.php" );}
	
	class EmailTemplate
	{
		
		var $from="orders@chequesnow.ca",
			$to="orders@chequesnow.ca",
			//$to="zlatkoflash@yahoo.com",
			$headers,
			$subject="Laser Cheque Order Confirmation";
		var $mimeToMe,$bodyForMe,$headersForMe,$mimeToMeForDeposit,
			$mimeToClient,$bodyForClient,$headersForClient,
			$mailFactory,
			$cheque,$pr_order_form_CH,$re_order_form_CH,$order_form_tempalte_CH,
			$chequeData,
			$orderNumber;
		var $SEmailObject;
		
		public function EmailTemplate( $cheque___, $pr_order_form_CH_, $re_order_form_CH_ , $order_form_tempalte_CH__, $chequeData__, $SEmailObject)
		{
			$this->SEmailObject = $SEmailObject;
			$this->orderNumber = OrderNumber::$CURR_ORDER;
			$this->cheque = $cheque___;
			$this->pr_order_form_CH = $pr_order_form_CH_;
			$this->re_order_form_CH = $re_order_form_CH_;
			$this->order_form_tempalte_CH = $order_form_tempalte_CH__;
			$this->chequeData = $chequeData__;
			if($this->chequeData->cheque->type == Cheque::TYPE_LASER)
			{
				$this->subject = "Laser Cheques Order Confirmation #".OrderNumber::$CURR_ORDER->orderLabel_withPower();
			}
			else
			{
				$this->subject = "Manual Cheque Order Confirmation #".OrderNumber::$CURR_ORDER->orderLabel_withPower();
			}
			if($this->chequeData->deliveryPrice() == 25)
			{
				$this->subject = "RUSH - ".$this->subject;
			}
			
			$this->headers = array('From' => $this->from, 'Subject' => $this->subject); 
		}
		public function SetEmailForMe()
		{
			$this->mimeToMe = new Mail_Mime();
			$this->mimeToMe->addAttachment($this->cheque->PDFContent(), 'application/pdf', $this->cheque->fileName, false, 'base64');
			$this->mimeToMe->addAttachment($this->pr_order_form_CH->PDFContent(), 'application/pdf', $this->chequeData->companyPRPDFName(), false, 'base64');
			$this->mimeToMe->addAttachment($this->re_order_form_CH->PDFContent(), 'application/pdf', $this->chequeData->companyREPDFName(), false, 'base64');
			$this->mimeToMe->addAttachment($this->order_form_tempalte_CH->PDFContent(), 'application/pdf', "order-form-pdf.pdf", false, 'base64');
			/*
			$this->mimeToMe->addAttachment($this->SEmailObject->chequeDepositSlips->PDFContent(), 'application/pdf', "deposit_slips.pdf", false, 'base64');
			*/
			$this->mimeToMe->addAttachment($this->SEmailObject->dfs_stamp->PDFContent(), 'application/pdf', "dfs-stamp.pdf", false, 'base64');
			$this->mimeToMe->addAttachment($this->SEmailObject->bct_stamp->PDFContent(), 'application/pdf', "bct-stamp.pdf", false, 'base64');
			
			$this->mimeToMe->addAttachment($this->SEmailObject->chequPADebit->PDFContent(), 'application/pdf', "PA_Debit.pdf", false, 'base64');
			$this->mimeToMe->addAttachment(CSVCreator::$CSV->get_source(), 'text/plain', "csv_order.csv", false, 'base64');
			$this->mimeToMe->addAttachment(PADCSV::$CSV->get_source(), 'text/plain', "pad.csv", false, 'base64');
			$this->attachLogo( $this->mimeToMe );
			$this->mimeToMe->setHtmlBody( $this->emailMessageForMe() );
			$this->bodyForMe = $this->mimeToMe->get();
			$this->headersForMe = $this->mimeToMe->headers( $this->headers );
			
			$this->mimeToMeForDeposit = new Mail_Mime();
			//Attaching deposit slip disabled by user...
			//$this->mimeToMeForDeposit->addAttachment($this->SEmailObject->chequeDepositSlips->PDFContent(), 'application/pdf', "deposit_slips.pdf", false, 'base64');
			$this->mimeToMeForDeposit->setHtmlBody( $this->EmailMessageWhenDepositBooksSElected() );
		}
		function emailMessageForMe()
		{
			$addressesX4Lines = "";
			if($this->chequeData->compInfoAddressLine1() != '')
			{
				$addressesX4Lines .= '<p style="font-family:Arial; font-size:10pt; text-align:left; margin:0px; padding:0px;">Address 1: <b>'. $this->chequeData->compInfoAddressLine1() .'</b></p>';
			}
			if($this->chequeData->compInfoAddressLine2() != '')
			{
				$addressesX4Lines .= '<p style="font-family:Arial; font-size:10pt; text-align:left; margin:0px; padding:0px;">Address 2: <b>'. $this->chequeData->compInfoAddressLine2() .'</b></p>';
			}
			if($this->chequeData->compInfoAddressLine3() != '')
			{
				$addressesX4Lines .= '<p style="font-family:Arial; font-size:10pt; text-align:left; margin:0px; padding:0px;">Address 3: <b>'. $this->chequeData->compInfoAddressLine3() .'</b></p>';
			}
			if($this->chequeData->compInfoAddressLine4() != '')
			{
				$addressesX4Lines .= '<p style="font-family:Arial; font-size:10pt; text-align:left; margin:0px; padding:0px;">Address 4: <b>'. $this->chequeData->compInfoAddressLine4() .'</b></p>';
			}
						
			return ' 
			
                <html>
				<head>
				<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
				</head>
                <body bgcolor="#ffffff"> 
				<div style="width:600px; border-style:solid;border-width:1px; background-color:#F7E8D7; padding:20px;">
					'.OrderNumber::$CURR_ORDER->orderHTML().'
                    <p style="font-family:Arial; font-weight:bold; font-size:10pt; text-align:left; margin:0px; padding:0px; ">Contact Info</p><br />
                    <p style="font-family:Arial; font-size:10pt; text-align:left; margin:0px; padding:0px;">Company Name:&nbsp;<b>'.$this->chequeData->CICompanyName() .'</b></p>
                    <p style="font-family:Arial; font-size:10pt; text-align:left; margin:0px; padding:0px;">Contact Name:&nbsp;<b>'. $this->chequeData->CIContactName() .'</b></p>
                    <p style="font-family:Arial; font-size:10pt; text-align:left; margin:0px; padding:0px;">Phone:&nbsp;<b>'. $this->chequeData->CIPhone() .'</b></p>
                    <p style="font-family:Arial; font-size:10pt; text-align:left; margin:0px; padding:0px;">Email:&nbsp;<b>'. $this->chequeData->CIEmail() .'</b></p>
                    <p style="font-family:Arial; font-size:10pt; text-align:left; margin:0px; padding:0px;">Question / Comments:<br />'. $this->chequeData->CIQuestionsAndComments().'</p>
                	<br/>
                    '.$this->chequeData->anotherNameForBillingHTML() .'
					'.$this->chequeData->additionalHTMLBSM().'
                    '.$this->chequeData->anotherAddressForShipingHTML() .'
					'.$this->chequeData->supplierHTML() .'
                    
                    <br/>
                    <p style="font-family:Arial; font-weight:bold; font-size:10pt; text-align:left; margin:0px; padding:0px; ">Cheque Info &nbsp;-&nbsp; Cheque Info</p><br />
					'.$this->chequeData->softwareHTML().'
                    <p style="font-family:Arial; font-size:10pt; text-align:left; margin:0px; padding:0px;">Start At:<b>'. $this->chequeData->startAtNumber() .'</b></p>
                    <p style="font-family:Arial; font-size:8pt; text-align:left; margin:0px; padding:0px;">Second Signature: '. $this->chequeData->labelForSecondSignature() .'</p>
                    <p style="font-family:Arial; font-size:8pt; text-align:left; margin:0px; padding:0px;">Logo Status: <b>'. $this->chequeData->CILogoLabel() .'</b></p>
					'.$this->chequeData->boxingTypeHTML().'
                    <p style="font-family:Arial; font-size:10pt; text-align:left; margin:0px; padding:0px;">Cheque color:<b>'. $this->chequeData->backgroundColor() .'</b><br/>Cheque style:<b>'.$this->chequeData->chequePositionLABEL().'</b></p>
                    
                    '. $this->chequeData->deliveryHTML() .'
                    
                    
                        <p style="font-family:Arial; font-size:10pt; text-align:left; margin:0px; padding:0px;">Quantity:&nbsp;<b>'. $this->chequeData->quantity() .'</b></p><br />
                        <p style="font-family:Arial; font-weight:bold; font-size:10pt; text-align:left; margin:0px; padding:0px; ">Cheque Info &nbsp;-&nbsp; Additional Products</p><br />
                        <p style="font-family:Arial; font-size:10pt; text-align:left; margin:0px; padding:0px;">Deposit Books:<b> '. $this->chequeData->depositBooks().' </b></p><br/>
						'.$this->chequeData->chequeBinderHTML().'
						'.$this->chequeData->DWEHTML().'
						'.$this->chequeData->SSWEHTML().'
                        '.$this->chequeData->SelfInkingHTML().'
						<br/>
                        <p style="font-family:Arial; font-weight:bold; font-size:10pt; text-align:left; margin:0px; padding:0px;">Cheque Info &nbsp;-&nbsp; Company Info</p><br />
                        <p style="font-family:Arial; font-size:14pt; text-align:left; margin:0px; padding:0px;">Company Name: <b>'. $this->chequeData->CINAComapanyNameLinivche().'</b></p>
						
                       '.$addressesX4Lines.'
						
						<br/>
                
                    
                        <p style="font-family:Arial; font-weight:bold; font-size:10pt; text-align:left; margin:0px; padding:0px; ">Cheque Info &nbsp;-&nbsp; Bank Info</p><br />
                        <p style="font-family:Arial; font-size:12pt; text-align:left; margin:0px; padding:0px;">Bank Name: <b>'. $this->chequeData->compInfoBankName() .'</b></p>
                        <p style="font-family:Arial; font-size:8pt; text-align:left; margin:0px; padding:0px;">Bank adress 1: <b>'. $this->chequeData->compInfoBankAddress1() .'</b></p>
                        <p style="font-family:Arial; font-size:8pt; text-align:left; margin:0px; padding:0px;">Bank adress 2: <b>'. $this->chequeData->compInfoBankAddress2() .'</b></p>
                        <p style="font-family:Arial; font-size:8pt; text-align:left; margin:0px; padding:0px;">Bank adress 3: <b>'. $this->chequeData->compInfoBankAddress3() .'</b></p>
                        <p style="font-family:Arial; font-size:8pt; text-align:left; margin:0px; padding:0px;">Bank adress 4: <b>'. $this->chequeData->compInfoBankAddress4() .'</b></p>
                
                        <p style="font-family:Arial; font-size:10pt; text-align:left; margin:0px; padding:0px;">Branch number:<b>'. $this->chequeData->brunchNumber() .'</b></p>
                        <p style="font-family:Arial; font-size:10pt; text-align:left; margin:0px; padding:0px;">Transit number:<b>'. $this->chequeData->transitNumber() .'</b></p>
                        <p style="font-family:Arial; font-size:10pt; text-align:left; margin:0px; padding:0px;">Account number:<b>'. $this->chequeData->accountNumber() .'</b></p>
                <br/>
                        
                        <p style="font-family:Arial; font-size:10pt; text-align:left; margin:0px; padding:0px;">Currency:<b>'. $this->chequeData->us_funds_label() .'</b></p>
                        
                    
                        '.$this->chequeData->MOPHtml().'
                
                    
                
                        <p style="font-family:Arial; font-size:10pt; text-align:left; margin:0px; padding:0px;">AIRMILES Reward Miles Card Number:<b>'. $this->chequeData->airMilesCardNumber() .'</b></p>
            
                    </body> 
				</div>
                </html> 
			' ;
		}
		public function SetEmailForClient()
		{
			$this->mimeToClient =  new Mail_Mime();
			$this->mimeToClient->addAttachment($this->cheque->PDFContent(), 'application/pdf', $this->cheque->fileName, false, 'base64');
			//$this->mimeToClient->addAttachment(CSVCreator::$CSV->get_source(), 'text/plain', "csv_order.csv", false, 'base64');
			//$this->mimeToClient->addAttachment($this->pr_order_form_CH->PDFContent(), 'application/pdf', $this->chequeData->companyPRPDFName(), false, 'base64');
			//$this->mimeToClient->addAttachment($this->re_order_form_CH->PDFContent(), 'application/pdf', $this->chequeData->companyREPDFName(), false, 'base64');
			//$this->mimeToClient->addAttachment($this->order_form_tempalte_CH->PDFContent(), 'application/pdf', "order-form-pdf.pdf", false, 'base64');
			/**/
			$this->attachLogo( $this->mimeToClient );
			$this->mimeToClient->setHtmlBody( $this->emailMessageForClient() );
			$this->bodyForClient = $this->mimeToClient->get();
			$this->headersForClient = $this->mimeToClient->headers( $this->headers );
		}
		public function emailMessageForClient()
		{
			return '
				<html>
					<head>
					<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
					</head>
                    <body bgcolor="#ffffff" style=""> 
					<div style="width:600px; border-style:solid;border-width:1px; background-color:#F7E8D7; padding:20px; font-family:Arial; font-size:12px;">
						'.OrderNumber::$CURR_ORDER->orderHTML().'
                        <p style="text-align:left; margin:5px; padding:5px; padding-left:0px;">Thank you for ordering from Print and Cheques Now Inc  Formerly: Cheques Now/Cheques Direct Ltd</p>
                        <p style="text-align:left; margin:5px; padding:5px; padding-left:0px;">Your order has been submitted.</br></p>
                
                        <p style="text-align:left; margin:5px; padding:5px; padding-left:0px;">Please go over the attached PDF proof you</br>
                submitted for any errors or typos. </p>
                        <p style="text-align:left; margin:5px; padding:5px; padding-left:0px;">If there are no errors great, if you do see any mistakes please email us</br>
                immediately so we can update the file.</p>
				
                        '. $this->chequeData->chequeInfoHTML() .'<br/>
						'. $this->chequeData->additionalProductsHTML() .'<br/>
                        
						'. $this->chequeData->anotherNameForBillingHTML() .'
                        '. $this->chequeData->anotherAddressForShipingHTML() .'
                    
                
                        <p style="text-align:left; margin:5px; padding:5px;">Thank you again for your order.</p>
                        <p style="text-align:left; margin:5px; padding:5px;">Sincerely,</p>
                        <p style="text-align:left; margin:5px; padding:5px;">Jon Gilchrist</p>
                        <p style="text-align:left; margin:5px; padding:5px;">Print and Cheques Now Inc</p>
                        <p style="text-align:left; margin:5px; padding:5px;">4319 - 54th Ave SE</p>
                        <p style="text-align:left; margin:5px; padding:5px;">Calgary, AB T2C 2A2</p>
                        <p style="text-align:left; margin:5px; padding:5px;">Ph: 1-866-760-2661</p>
                	</div>
                    </body> 
                </html>
			';
		}
		function attachLogo($mime)
		{
			if(($this->chequeData->CILogoType() == "0" || $this->chequeData->CILogoType()=="1") && isset($_FILES["compInfoLogoInput"]["name"]))
			{
				$fileNameAttachment = $_FILES["compInfoLogoInput"]["name"];
				$fileAttachedType = substr($fileNameAttachment, strrpos($fileNameAttachment, '.') + 1);
				$allowed_extensions = array("jpg", "jpeg", "gif", "bmp" , "png" , "psd", "pdf", "cdr", "ai", "eps", "tif", "tiff");
				$allowed_ext = false;
				for($i=0; $i<sizeof($allowed_extensions); $i++) 
				{ 
					if(strcasecmp($allowed_extensions[$i],$fileAttachedType) == 0)$allowed_ext = true;  
				}
				if($allowed_ext == true)
				{
					$mime->addAttachment($_FILES["compInfoLogoInput"]["tmp_name"],'application/'.$fileAttachedType,$_FILES["compInfoLogoInput"]["name"]);
				}
				else
				{
					//no extension allowed
				}
			}
			else if($this->chequeData->CILogoType() == "0" || $this->chequeData->CILogoType()=="1")
			{
				//no logo attached
			}
			else
			{
			}
		}
		public function EmailMessageWhenDepositBooksSElected()
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
			
			$addressesX4Lines = "";
			if($this->chequeData->compInfoBankAddress1() != '')
			{
				$addressesX4Lines .= '<p style="font-family:Arial; font-size:10pt; text-align:left; margin:0px; padding:0px;">Address 1: <b>'. $this->chequeData->compInfoBankAddress1() .'</b></p>';
			}
			if($this->chequeData->compInfoBankAddress2() != '')
			{
				$addressesX4Lines .= '<p style="font-family:Arial; font-size:10pt; text-align:left; margin:0px; padding:0px;">Address 2: <b>'. $this->chequeData->compInfoBankAddress2() .'</b></p>';
			}
			if($this->chequeData->compInfoBankAddress3() != '')
			{
				$addressesX4Lines .= '<p style="font-family:Arial; font-size:10pt; text-align:left; margin:0px; padding:0px;">Address 3: <b>'. $this->chequeData->compInfoBankAddress3() .'</b></p>';
			}
			if($this->chequeData->compInfoBankAddress4() != '')
			{
				$addressesX4Lines .= '<p style="font-family:Arial; font-size:10pt; text-align:left; margin:0px; padding:0px;">Address 4: <b>'. $this->chequeData->compInfoBankAddress4() .'</b></p>';
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
I need to place the following deposit book order:
						</p>
						<br><br>
						
                        <p style="text-align:left; font-size:10pt; margin:0px; padding:0px;">Quantity/Style: <b>W487 '.$this->chequeData->depositBooksCopies().' Copies '.$this->chequeData->depositBooksCount().'</b></p>
						<br/>
						
						<p style="text-align:left; font-size:10pt; margin:0px; padding:0px;">
						Imprint<!--: Please take all required information from the attached PDF.-->
						</p>
						<br>
						
						<p style="font-family:Arial; font-size:10pt; text-align:left; margin:0px; padding:0px;">Company Name: <b>'. $this->chequeData->CINACompanyName().'<br>'.$this->chequeData->CINACompanySecondName().'</b></p>
						<br/>
						
						<p style="font-family:Arial; font-size:10pt; text-align:left; margin:0px; padding:0px;">Bank Name:&nbsp;<b>'. $this->chequeData->compInfoBankName() .'</b></p>
						'.$addressesX4Lines.'
						<br>
						
						<p style="font-family:Arial; font-size:10pt; text-align:left; margin:0px; padding:0px;"><b>'. 
						$this->chequeData->brunchNumber()." - ".$this->chequeData->transitNumber()." - ".$this->chequeData->accountNumber() .'</b></p>
						<br>
						
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
						<p style="font-family:Arial; font-size:10pt; text-align:left; margin:0px; padding:0px;">** Please use promo code GC256 for this NEW order. 20% off flyer we received by email **</p>
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
		public function SEND()
		{
			/*
			print $this->EmailMessageWhenDepositBooksSElected();
			//print $this->emailMessageForMe();
			print '<br/>';
			//print $this->emailMessageForClient();
			return;
			*/
			$this->SetEmailForMe();
			$this->SetEmailForClient();
			$this->mailFactory = &Mail::factory('mail');
			if($this->mailFactory->send($this->to, $this->headersForMe, $this->bodyForMe) &&
			   $this->mailFactory->send($this->chequeData->CIEmail(), $this->headersForClient, $this->bodyForClient))
			{
			}
			else
			{
			}
			if($this->chequeData->depositBooks() != "")
			{
				$this->headers = array('From' => $this->from, 'Subject' => "Deposit Slip Order ".$this->chequeData->CINAComapanyNameLinivche()." Confirmation #".OrderNumber::$CURR_ORDER->orderLabel_withPower().""); 
				$this->headersForMe = $this->mimeToMeForDeposit->headers( $this->headers );
				$this->mailFactory->send($this->to, $this->headersForMe, $this->mimeToMeForDeposit->get());
			}
		}
		public function SEND_AFTER_UPDATE_INTO_ADMIN()
		{
			//print "===>>>>".$_POST["fso_admin_submit_additions"];
			$this->mailFactory = &Mail::factory('mail');
			$arrayValuesAfterSubmitForSending = explode(",", $_POST["fso_admin_submit_additions"]);
			$this->SetEmailForMe();
			//$this->mailFactory->send($this->to, $this->headersForMe, $this->bodyForMe);
			if($arrayValuesAfterSubmitForSending[0] == "1")
			{
				$this->mailFactory->send($_POST["sendToPrintNowEmail"], $this->headersForMe, $this->bodyForMe);
			}
			$this->SetEmailForClient();
			if($arrayValuesAfterSubmitForSending[1] == "1")
			{
				$this->mailFactory->send($this->chequeData->CIEmail(), $this->headersForClient, $this->bodyForClient);
			}
			if($arrayValuesAfterSubmitForSending[2] == "1")
			{
				$this->mailFactory->send($_POST["admin_second_email_for_customer"], $this->headersForClient, $this->bodyForClient);
			}
			if($this->chequeData->depositBooks() != "")
			{
				$this->headers = array('From' => $this->from, 'Subject' => "Deposit Slip Order ".$this->chequeData->CINAComapanyNameLinivche()." Confirmation #".OrderNumber::$CURR_ORDER->orderLabel_withPower().""); 
				$this->headersForMe = $this->mimeToMeForDeposit->headers( $this->headers );
				$this->mailFactory->send($this->to, $this->headersForMe, $this->mimeToMeForDeposit->get());
			}
		}
	}

?>