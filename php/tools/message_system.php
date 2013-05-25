<?php
require_once("message_system_templates/base_mail.php");
require_once("message_system_templates/address_stamp_or_deposit_stamp_mail.php");

class SendEMail {

    var $chequeTemplate,
            $chequePROrder,
            $chequeREOrder,
            $chequeOrderFormTemplate,
            $chequeDepositSlips,
            $chequPADebit,
            $dfs_stamp,
            $bct_stamp,
            $invoice_products_list;
    var $cheque,
            $objChequeData,
            $emailTemplate;

    public function SendEMail($objCheque__ = NULL, $sendEmailYes__ = NULL) {
        require_once('Mail.php');
        require_once('Mail/mime.php');
        /*
          require_once("mail_message_template.php");
          require_once("backupmessage.php");
         * */
        if ($objCheque__ == null && $sendEmailYes__ == NULL) {
            return;
        }
        $this->cheque = $objCheque__;
        $this->objChequeData = new ChequeData($this->cheque);

        /////////////////////////////////////////////////////////////////////
        ChequeData::SETUP_POST_FOR_PDFs();
        /////////////////////////////////////////////////////////////////////
        switch ($this->cheque->type) {
            case Cheque::TYPE_LASER: {
                    /*
                      require_once("laser-template.php");
                      $this->chequeTemplate = new CHEQUE_TEMPLATE( $this->objChequeData, $this->cheque );
                     */
                }break;
            case Cheque::TYPE_MANUAL: {
                    /*
                      require_once("manual-template.php");
                      $this->chequeTemplate = new CHEQUE_TEMPLATE( $this->objChequeData, $this->cheque );
                     */
                }break;
        }
        if ($this->cheque->type == Cheque::TYPE_LASER) {
            require_once('pdf_cheque_templates/blank-a4-ch-laser.php');
            $this->chequeTemplate = new BlankA4Cheque($this->objChequeData, false, true);
        } else {
            require_once('pdf_cheque_templates/blank-a4-ch-manual.php');
            $this->chequeTemplate = new BlankA4Cheque($this->objChequeData, false, true);
        }
        $this->chequePROrder = new BlankA4Cheque($this->objChequeData, false);
        $this->chequeREOrder = new BlankA4Cheque($this->objChequeData, true);
        require_once("pdf_cheque_templates/order-form-template.php");
        require_once("pdf_cheque_templates/deposit-slips.php");
        require_once("pdf_cheque_templates/pa-debit.php");
        require_once("pdf_cheque_templates/dfs-stamp.php");
        $this->chequeOrderFormTemplate = new OrderFormTemplate($this->objChequeData, false);
        $this->chequeDepositSlips = new DepositSlips($this->objChequeData);
        $this->chequPADebit = new PA_Debit($this->objChequeData);
        $this->dfs_stamp = new DFSStamp(DFSStamp::DFS, $this->objChequeData);
        $this->bct_stamp = new DFSStamp(DFSStamp::BCT, $this->objChequeData);

        if (isset($_POST["after_updating_order"])) {
            $this->DELETE_CURR_ORDER_FOLDER_WHEN_UPDATING();
        }
        if (!is_dir(SETTINGS::ORDERS______URL() . OrderNumber::$CURR_ORDER->orderLabel_withPower())) {
            mkdir(SETTINGS::ORDERS______URL() . OrderNumber::$CURR_ORDER->orderLabel_withPower());
        }
        //print "[".SETTINGS::ORDERS______URL().OrderNumber::$CURR_ORDER->orderLabel_withPower()."]";
        $this->chequeTemplate->saveToLocal(SETTINGS::ORDERS______URL() . OrderNumber::$CURR_ORDER->orderLabel_withPower() . "/cheque.pdf");
        $this->chequePROrder->saveToLocal(SETTINGS::ORDERS______URL() . OrderNumber::$CURR_ORDER->orderLabel_withPower() . "/chequePROrder.pdf");
        $this->chequeREOrder->saveToLocal(SETTINGS::ORDERS______URL() . OrderNumber::$CURR_ORDER->orderLabel_withPower() . "/chequeREOrder.pdf");
        $this->chequeOrderFormTemplate->saveToLocal(SETTINGS::ORDERS______URL() . OrderNumber::$CURR_ORDER->orderLabel_withPower() . "/chequeOrderFormTemplate.pdf");
        $this->chequeDepositSlips->saveToLocal(SETTINGS::ORDERS______URL() . OrderNumber::$CURR_ORDER->orderLabel_withPower() . "/deposit_slips.pdf");
        $this->chequPADebit->saveToLocal(SETTINGS::ORDERS______URL() . OrderNumber::$CURR_ORDER->orderLabel_withPower() . "/PA_Debit.pdf");
        /////////////////////////////////////////////////////////////////////
        ChequeData::SETUP_POST_NORMAL();
        /////////////////////////////////////////////////////////////////////

        /* $this->chequeTemplate->saveToLocal("laser-test.pdf");

          $this->chequePROrder->saveToLocal("test-pdf/pr.pdf");
          $this->chequeREOrder->saveToLocal("test-pdf/re.pdf");
         */
        /////$this->chequeOrderFormTemplate->saveToLocal("now_order_form_template.pdf");
        //return;
        $this->emailTemplate = new EmailTemplate($this->chequeTemplate, $this->chequePROrder, $this->chequeREOrder, $this->chequeOrderFormTemplate, $this->objChequeData, $this);
        if ($sendEmailYes__ == false) {
            return;
        }
        //return;
        //print "Update and sent order setup links please......[into tools.php]";
        //print_r($_POST);
        
        if (isset($_POST["after_updating_order"])) {
            $this->SEND_AFTER_UPDATE_INTO_ADMIN();
            ?>
            <!--
            [<?php print OrderNumber::$CURR_ORDER->orderLabel; ?>]
            -->
            <form id="form_after_updating_order" action="<?php print SETTINGS::URL_TO_ADMIN_PAGE; ?>" method="post" enctype="multipart/form-data">
                <input type="hidden" name="user_is_logged" value="yes" />
                <input type="hidden" name="after_update_order_please" value="yes" />
                <input type="hidden" name="fso_order_number" value="<?php print OrderNumber::$CURR_ORDER->orderLabel; ?>" />
                <input type="hidden" name="admin_action" id="admin_action" value="admin_order_complete" />
            </form>
            <script>
                document.getElementById("form_after_updating_order").submit();
            </script>
            <?php
        } else if (isset($_POST["sendPDFandEmail"])) {
            $this->SEND();
            ?>
            <form id="form_after_updating_order" action="<?php print SETTINGS::URL_TO_THANK_U; ?>" method="post" enctype="multipart/form-data">
                <input type="hidden" name="order_number" value="<?php print OrderNumber::$CURR_ORDER->orderLabel; ?>" />
            </form>
            <script>
                document.getElementById("form_after_updating_order").submit();
            </script>
            <?php
        }
    }

    function SEND() {
        $this->emailTemplate->SEND();
    }

    function SEND_AFTER_UPDATE_INTO_ADMIN() {
        $this->emailTemplate->SEND_AFTER_UPDATE_INTO_ADMIN();
    }

    /*
      This is function for removing the folders for orders, according to updating...
     */

    function DELETE_CURR_ORDER_FOLDER_WHEN_UPDATING() {
        $orderMinus1 = OrdersDatabase::GET_ORDER_POWER(OrderNumber::$CURR_ORDER->orderLabel, true);
        $orderFolderIntoNew = SETTINGS::ORDERS______URL_BY_CHEQUE() . $orderMinus1 . "/";
        $orderFolderIntoCompleted = SETTINGS::ORDERS______URL_BY_CHEQUE() . SETTINGS::FOLDER_FOR_COMPLETED_ORDERS . $orderMinus1 . "/";

        /*
          print "[".$orderFolderIntoNew."]";
          print "[".$orderFolderIntoCompleted."]";
         */

        if (is_dir($orderFolderIntoNew)) {
            HELPWordpress::delete_directory($orderFolderIntoNew);
        }
        if (is_dir($orderFolderIntoCompleted)) {
            HELPWordpress::delete_directory($orderFolderIntoCompleted);
        }
    }

    /*
     * This mail is sending when blue CREATE INVOICE BUTTON IS CLICKED
     * $invoice_pdf_list should be object of class InvoicePDFList
     * into file pdf_cheque_templates/invoice_pdf_list.php
     * */

    public function SEND_INVOICE_EMAIL($invoice_pdf_list) {
        $from = "orders@chequesnow.ca";
        $to = $_POST["CIEmail"];
        /*
          if($_POST["chequeType"] == Cheque::TYPE_LASER)
          {
          $subject = "Laser Cheques Order Confirmation #".$_POST["orderNumber"];
          }
          else
          {
          $subject = "Manual Cheque Order Confirmation #".$_POST["orderNumber"];
          }
         */
        $paid_or_outstanding = "";
        if ($_POST["invoice_paid_or_outstanding"] == "Paid") {
            $paid_or_outstanding = "Paid in Full";
        } else if ($_POST["invoice_paid_or_outstanding"] == "Outstanding") {
            $paid_or_outstanding = "Outstanding Invoice";
        }
        $subject = "**Cheque Order Receipt Attached Confirmation #" . $_POST["orderNumber"] . " **";
        $headers = array('From' => $from, 'Subject' => $subject);
        $mimeToMe = new Mail_Mime();
        $mimeToMe->addAttachment($invoice_pdf_list->PDFContent(), 'application/pdf', "invoice.pdf", false, 'base64');
        $mimeToMe->setHtmlBody(' <html>
				<head>
				<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
				</head>
                <body bgcolor="#ffffff"> 
				<div style="width:600px; border-style:solid;border-width:1px; background-color:#F7E8D7; padding:20px;">
				
					Please find your Invoice attached for your recent order.<br><br>
					
					Confirmation #' . $_POST["orderNumber"] . '-' . $_POST["companyName_TYPE_BILLING"] . '."' . $paid_or_outstanding . '"<br><br>

					If you have any questions please call us at 1-866-760-2661 Ext 224.<br><br><br>
					
					
					Thank You,<br><br>
					
					Print and Cheques Now Inc<br>
					Ph: 1-866-760-2661<br>
					Fx: 1-877-760-2435
				
				</div>
				</body>
				</html>
				');
        $bodyForMe = $mimeToMe->get();
        $headersForMe = $mimeToMe->headers($headers);

        $mailFactory = &Mail::factory('mail');
        /* When
          $mailFactory->send($to, $headersForMe, $bodyForMe);
         */
        $additional_emails = explode(",", $_POST["invoice_email_sent_to"]);
        if ($additional_emails[0] == "1") {
            $mailFactory->send($_POST["email_TYPE_BILLING"], $headersForMe, $bodyForMe);
        }
        if ($additional_emails[1] == "1") {
            $mailFactory->send($_POST["enter_email_address_for_invoice"], $headersForMe, $bodyForMe);
        }
    }

}

class EmailTemplate {

    var $from = "orders@chequesnow.ca",
            $to = "orders@chequesnow.ca",
            //$to="zlatkoflash@yahoo.com",
            $headers,
            $subject = "Laser Cheque Order Confirmation";
    var $mimeToMe, $bodyForMe, $headersForMe, $mimeToMeForDeposit,
            $mimeToClient, $bodyForClient, $headersForClient,
            $mailFactory,
            $cheque, $pr_order_form_CH, $re_order_form_CH, $order_form_tempalte_CH,
            $chequeData,
            $orderNumber;
    var $SEmailObject;
    private $address_deposit_stamp_mail;

    public function EmailTemplate($cheque___, $pr_order_form_CH_, $re_order_form_CH_, $order_form_tempalte_CH__, $chequeData__, $SEmailObject) {
        $this->SEmailObject = $SEmailObject;
        $this->orderNumber = OrderNumber::$CURR_ORDER;
        $this->cheque = $cheque___;
        $this->pr_order_form_CH = $pr_order_form_CH_;
        $this->re_order_form_CH = $re_order_form_CH_;
        $this->order_form_tempalte_CH = $order_form_tempalte_CH__;
        $this->chequeData = $chequeData__;
        if ($this->chequeData->cheque->type == Cheque::TYPE_LASER) {
            $this->subject = "Laser Cheques Order Confirmation #" . OrderNumber::$CURR_ORDER->orderLabel_withPower();
        } else {
            $this->subject = "Manual Cheque Order Confirmation #" . OrderNumber::$CURR_ORDER->orderLabel_withPower();
        }
        if ($this->chequeData->delivery() == "1-5 Business Days") {
            $this->subject = "RUSH - " . $this->subject;
        }

        $this->headers = array('From' => $this->from, 'Subject' => $this->subject);
    }

    public function SetEmailForMe() {
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
        if (isset($_POST["after_updating_order"])) {
            /* last info from client */
            $airmilesCSV = new AIRMILES_CSV();
            /* Client told me trigger on invoice clicking, and i think he think update master airmiles when 
             * invoice admin button is clicked */
            //$airmilesCSV->update_master_airmiles_field();
            //print $airmilesCSV->source;
            $this->mimeToMe->addAttachment($airmilesCSV->source, 'text/plain', "airmiles.csv", false, 'base64');
        }
        $this->attachLogo($this->mimeToMe);
        //print $this->emailMessageForMe();
        $this->mimeToMe->setHtmlBody($this->emailMessageForMe());
        $this->bodyForMe = $this->mimeToMe->get();
        $this->headersForMe = $this->mimeToMe->headers($this->headers);

        $this->mimeToMeForDeposit = new Mail_Mime();
        //Attaching deposit slip disabled by user...
        //$this->mimeToMeForDeposit->addAttachment($this->SEmailObject->chequeDepositSlips->PDFContent(), 'application/pdf', "deposit_slips.pdf", false, 'base64');
        $this->mimeToMeForDeposit->setHtmlBody($this->EmailMessageWhenDepositBooksSElected());
    }

    function emailMessageForMe() {
        $addressesX4Lines = "";
        if ($this->chequeData->compInfoAddressLine1() != '') {
            $addressesX4Lines .= '<p style="font-family:Arial; font-size:10pt; text-align:left; margin:0px; padding:0px;">Address 1: <b>' . $this->chequeData->compInfoAddressLine1() . '</b></p>';
        }
        if ($this->chequeData->compInfoAddressLine2() != '') {
            $addressesX4Lines .= '<p style="font-family:Arial; font-size:10pt; text-align:left; margin:0px; padding:0px;">Address 2: <b>' . $this->chequeData->compInfoAddressLine2() . '</b></p>';
        }
        if ($this->chequeData->compInfoAddressLine3() != '') {
            $addressesX4Lines .= '<p style="font-family:Arial; font-size:10pt; text-align:left; margin:0px; padding:0px;">Address 3: <b>' . $this->chequeData->compInfoAddressLine3() . '</b></p>';
        }
        if ($this->chequeData->compInfoAddressLine4() != '') {
            $addressesX4Lines .= '<p style="font-family:Arial; font-size:10pt; text-align:left; margin:0px; padding:0px;">Address 4: <b>' . $this->chequeData->compInfoAddressLine4() . '</b></p>';
        }

        return ' 
			
                <html>
				<head>
				<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
				</head>
                <body bgcolor="#ffffff"> 
				<div style="width:600px; border-style:solid;border-width:1px; background-color:#F7E8D7; padding:20px;">
					' . OrderNumber::$CURR_ORDER->orderHTML() . '
                    <p style="font-family:Arial; font-weight:bold; font-size:10pt; text-align:left; margin:0px; padding:0px; ">Contact Info</p><br />
                    <p style="font-family:Arial; font-size:10pt; text-align:left; margin:0px; padding:0px;">Company Name:&nbsp;<b>' . $this->chequeData->CICompanyName() . '</b></p>
                    <p style="font-family:Arial; font-size:10pt; text-align:left; margin:0px; padding:0px;">Contact Name:&nbsp;<b>' . $this->chequeData->CIContactName() . '</b></p>
                    <p style="font-family:Arial; font-size:10pt; text-align:left; margin:0px; padding:0px;">Phone:&nbsp;<b>' . $this->chequeData->CIPhone() . '</b></p>
                    <p style="font-family:Arial; font-size:10pt; text-align:left; margin:0px; padding:0px;">Email:&nbsp;<b>' . $this->chequeData->CIEmail() . '</b></p>
                    <p style="font-family:Arial; font-size:10pt; text-align:left; margin:0px; padding:0px;">Question / Comments:<br />' . $this->chequeData->CIQuestionsAndComments() . '</p>
                	<br/>
                    ' . $this->chequeData->anotherNameForBillingHTML() . '
					' . $this->chequeData->additionalHTMLBSM() . '
                    ' . $this->chequeData->anotherAddressForShipingHTML() . '
					' . $this->chequeData->supplierHTML() . '
                    
                    <br/>
                    <p style="font-family:Arial; font-weight:bold; font-size:10pt; text-align:left; margin:0px; padding:0px; ">Cheque Info &nbsp;-&nbsp; Cheque Info</p><br />
					' . $this->chequeData->softwareHTML() . '
                    <p style="font-family:Arial; font-size:10pt; text-align:left; margin:0px; padding:0px;">Start At:<b>' . $this->chequeData->startAtNumber() . '</b></p>
                    <p style="font-family:Arial; font-size:8pt; text-align:left; margin:0px; padding:0px;">Second Signature: ' . $this->chequeData->labelForSecondSignature() . '</p>
                    <p style="font-family:Arial; font-size:8pt; text-align:left; margin:0px; padding:0px;">Logo Status: <b>' . $this->chequeData->CILogoLabel() . '</b></p>
					' . $this->chequeData->boxingTypeHTML() . '
                    <p style="font-family:Arial; font-size:10pt; text-align:left; margin:0px; padding:0px;">Cheque color:<b>' . $this->chequeData->backgroundColor() . '</b><br/>Cheque style:<b>' . $this->chequeData->chequePositionLABEL() . '</b></p>
                    
                    ' . $this->chequeData->deliveryHTML() . '
                    
                    
                        <p style="font-family:Arial; font-size:10pt; text-align:left; margin:0px; padding:0px;">Quantity:&nbsp;<b>' . Product::$QUANTITY_AND_PRICES->title . '</b></p><br />
                        <p style="font-family:Arial; font-weight:bold; font-size:10pt; text-align:left; margin:0px; padding:0px; ">Cheque Info &nbsp;-&nbsp; Additional Products</p><br />
						' . $this->chequeData->depositBooksHTML() . '
						' . $this->chequeData->chequeBinderHTML() . '
						' . $this->chequeData->DWEHTML() . '
						' . $this->chequeData->SSWEHTML() . '
                        ' . $this->chequeData->SelfInkingHTML() . '
						<br/>
                        <p style="font-family:Arial; font-weight:bold; font-size:10pt; text-align:left; margin:0px; padding:0px;">Cheque Info &nbsp;-&nbsp; Company Info</p><br />
                        <p style="font-family:Arial; font-size:14pt; text-align:left; margin:0px; padding:0px;">Company Name: <b>' . $this->chequeData->CINAComapanyNameLinivche() . '</b></p>
						
                       ' . $addressesX4Lines . '
						
						<br/>
                
                    
                        <p style="font-family:Arial; font-weight:bold; font-size:10pt; text-align:left; margin:0px; padding:0px; ">Cheque Info &nbsp;-&nbsp; Bank Info</p><br />
                        <p style="font-family:Arial; font-size:12pt; text-align:left; margin:0px; padding:0px;">Bank Name: <b>' . $this->chequeData->compInfoBankName() . '</b></p>
                        <p style="font-family:Arial; font-size:8pt; text-align:left; margin:0px; padding:0px;">Bank adress 1: <b>' . $this->chequeData->compInfoBankAddress1() . '</b></p>
                        <p style="font-family:Arial; font-size:8pt; text-align:left; margin:0px; padding:0px;">Bank adress 2: <b>' . $this->chequeData->compInfoBankAddress2() . '</b></p>
                        <p style="font-family:Arial; font-size:8pt; text-align:left; margin:0px; padding:0px;">Bank adress 3: <b>' . $this->chequeData->compInfoBankAddress3() . '</b></p>
                        <p style="font-family:Arial; font-size:8pt; text-align:left; margin:0px; padding:0px;">Bank adress 4: <b>' . $this->chequeData->compInfoBankAddress4() . '</b></p>
                
                        <p style="font-family:Arial; font-size:10pt; text-align:left; margin:0px; padding:0px;">Branch number:<b>' . $this->chequeData->brunchNumber() . '</b></p>
                        <p style="font-family:Arial; font-size:10pt; text-align:left; margin:0px; padding:0px;">Transit number:<b>' . $this->chequeData->transitNumber() . '</b></p>
                        <p style="font-family:Arial; font-size:10pt; text-align:left; margin:0px; padding:0px;">Account number:<b>' . $this->chequeData->accountNumber() . '</b></p>
                <br/>
                        
                        <p style="font-family:Arial; font-size:10pt; text-align:left; margin:0px; padding:0px;">Currency:<b>' . $this->chequeData->us_funds_label() . '</b></p>
                        
                    
                        ' . $this->chequeData->MOPHtml() . '
                
                    
                
                        <p style="font-family:Arial; font-size:10pt; text-align:left; margin:0px; padding:0px;">AIRMILES Reward Miles Card Number:<b>' . $this->chequeData->airMilesCardNumber() . '</b></p>
            
                    </body> 
				</div>
                </html> 
			';
    }

    public function SetEmailForClient() {
        $this->mimeToClient = new Mail_Mime();
        $this->mimeToClient->addAttachment($this->cheque->PDFContent(), 'application/pdf', $this->cheque->fileName, false, 'base64');
        //$this->mimeToClient->addAttachment(CSVCreator::$CSV->get_source(), 'text/plain', "csv_order.csv", false, 'base64');
        //$this->mimeToClient->addAttachment($this->pr_order_form_CH->PDFContent(), 'application/pdf', $this->chequeData->companyPRPDFName(), false, 'base64');
        //$this->mimeToClient->addAttachment($this->re_order_form_CH->PDFContent(), 'application/pdf', $this->chequeData->companyREPDFName(), false, 'base64');
        //$this->mimeToClient->addAttachment($this->order_form_tempalte_CH->PDFContent(), 'application/pdf', "order-form-pdf.pdf", false, 'base64');
        /**/
        $this->attachLogo($this->mimeToClient);
        $this->mimeToClient->setHtmlBody($this->emailMessageForClient());
        $this->bodyForClient = $this->mimeToClient->get();
        $this->headersForClient = $this->mimeToClient->headers($this->headers);
    }

    public function emailMessageForClient() {
        return '
				<html>
					<head>
					<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
					</head>
                    <body bgcolor="#ffffff" style=""> 
					<div style="width:600px; border-style:solid;border-width:1px; background-color:#F7E8D7; padding:20px; font-family:Arial; font-size:12px;">
						' . OrderNumber::$CURR_ORDER->orderHTML() . '
                        <p style="text-align:left; margin:5px; padding:5px; padding-left:0px;">Thank you for ordering from Print and Cheques Now Inc  Formerly: Cheques Now/Cheques Direct Ltd</p>
                        <p style="text-align:left; margin:5px; padding:5px; padding-left:0px;">Your order has been submitted.</br></p>
                
                        <p style="text-align:left; margin:5px; padding:5px; padding-left:0px;">Please go over the attached PDF proof you</br>
                submitted for any errors or typos. </p>
                        <p style="text-align:left; margin:5px; padding:5px; padding-left:0px;">If there are no errors great, if you do see any mistakes please email us</br>
                immediately so we can update the file.</p>
				
                        ' . $this->chequeData->chequeInfoHTML() . '<br/>
						' . $this->chequeData->additionalProductsHTML() . '<br/>
                        
						' . $this->chequeData->anotherNameForBillingHTML() . '
                        ' . $this->chequeData->anotherAddressForShipingHTML() . '
                    
                
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

    function attachLogo($mime) {
        if (Product::$LOGO->invoice_amount() != 0 && isset($_FILES["compInfoLogoInput"]["name"])) {
            $fileNameAttachment = $_FILES["compInfoLogoInput"]["name"];
            $fileAttachedType = substr($fileNameAttachment, strrpos($fileNameAttachment, '.') + 1);
            $allowed_extensions = array("jpg", "jpeg", "gif", "bmp", "png", "psd", "pdf", "cdr", "ai", "eps", "tif", "tiff");
            $allowed_ext = false;
            for ($i = 0; $i < sizeof($allowed_extensions); $i++) {
                if (strcasecmp($allowed_extensions[$i], $fileAttachedType) == 0)
                    $allowed_ext = true;
            }
            if ($allowed_ext == true) {
                $mime->addAttachment($_FILES["compInfoLogoInput"]["tmp_name"], 'application/' . $fileAttachedType, $_FILES["compInfoLogoInput"]["name"]);
            } else {
                //no extension allowed
            }
        } else if (Product::$LOGO->invoice_amount() != 0) {
            //no logo attached
        } else {
            
        }
    }

    public function EmailMessageWhenDepositBooksSElected() {
        $shipingAddressX3Lines = "";
        if ($_POST["address_1_" . ChequeData::TYPE_SHIPING] != "") {
            $shipingAddressX3Lines .= '<p style="font-family:Arial; font-size:10pt; text-align:left; margin:0px; padding:0px;">Shipping Address 1:<b>' . $_POST["address_1_" . ChequeData::TYPE_SHIPING] . '</b></p>';
        }
        if ($_POST["address_2_" . ChequeData::TYPE_SHIPING] != "") {
            $shipingAddressX3Lines .= '<p style="font-family:Arial; font-size:10pt; text-align:left; margin:0px; padding:0px;">Shipping Address 2:<b>' . $_POST["address_2_" . ChequeData::TYPE_SHIPING] . '</b></p>';
        }
        if ($_POST["address_3_" . ChequeData::TYPE_SHIPING] != "") {
            $shipingAddressX3Lines .= '<p style="font-family:Arial; font-size:10pt; text-align:left; margin:0px; padding:0px;">Shipping Address 3:<b>' . $_POST["address_3_" . ChequeData::TYPE_SHIPING] . '</b></p>';
        }

        $addressesX4Lines = "";
        if ($this->chequeData->compInfoBankAddress1() != '') {
            $addressesX4Lines .= '<p style="font-family:Arial; font-size:10pt; text-align:left; margin:0px; padding:0px;">Address 1: <b>' . $this->chequeData->compInfoBankAddress1() . '</b></p>';
        }
        if ($this->chequeData->compInfoBankAddress2() != '') {
            $addressesX4Lines .= '<p style="font-family:Arial; font-size:10pt; text-align:left; margin:0px; padding:0px;">Address 2: <b>' . $this->chequeData->compInfoBankAddress2() . '</b></p>';
        }
        if ($this->chequeData->compInfoBankAddress3() != '') {
            $addressesX4Lines .= '<p style="font-family:Arial; font-size:10pt; text-align:left; margin:0px; padding:0px;">Address 3: <b>' . $this->chequeData->compInfoBankAddress3() . '</b></p>';
        }
        if ($this->chequeData->compInfoBankAddress4() != '') {
            $addressesX4Lines .= '<p style="font-family:Arial; font-size:10pt; text-align:left; margin:0px; padding:0px;">Address 4: <b>' . $this->chequeData->compInfoBankAddress4() . '</b></p>';
        }

        $email_discount_code = "54";
        if ($_POST["email_discount_code"] != "") {
            $email_discount_code = $_POST["email_discount_code"];
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
						
                        <p style="text-align:left; font-size:10pt; margin:0px; padding:0px;">Quantity/Style: <b>W487 ' . Product::$DEPOSIT_BOOK->copies . ' Copies ' . Product::$DEPOSIT_BOOK->total_quantity() . '</b></p>
						<br/>
						
						<p style="text-align:left; font-size:10pt; margin:0px; padding:0px;">
						Imprint
                                                <!--: Please take all required information from the attached PDF.-->
						</p>
                                                <br/>
                                                <p><b>DEPOSIT TO THE CREDIT OF</b></p>
						<br>
						
						<p style="font-family:Arial; font-size:10pt; text-align:left; margin:0px; padding:0px;">Company Name: <b>' . $this->chequeData->CINACompanyName() . '<br>' . $this->chequeData->CINACompanySecondName() . '</b></p>
						<br/>
						
						<p style="font-family:Arial; font-size:10pt; text-align:left; margin:0px; padding:0px;">Bank Name:&nbsp;<b>' . $this->chequeData->compInfoBankName() . '</b></p>
						' . $addressesX4Lines . '
						<br>
						
						<p style="font-family:Arial; font-size:10pt; text-align:left; margin:0px; padding:0px;"><b>' .
                $this->chequeData->brunchNumber() . " - " . $this->chequeData->transitNumber()
                . " - " . $this->chequeData->accountNumber() . ' ' . $this->chequeData->currencyNumber45() . '</b></p>
						<br>
						
						<p style="text-align:left; font-size:10pt; margin:0px; padding:0px;">
						Shipping: Please drop ship the order directly to the customer using the information Below:
						</p>
						<br>
						<p style="font-family:Arial; font-size:10pt; text-align:left; margin:0px; padding:0px;">Shipping Company Name:&nbsp;<b>' . $_POST["companyName_" . ChequeData::TYPE_SHIPING] . '</b></p>
						<p style="font-family:Arial; font-size:10pt; text-align:left; margin:0px; padding:0px;">Shipping Contact Name:&nbsp;<b>' . $_POST["contactName_" . ChequeData::TYPE_SHIPING] . '</b></p>
						
						' . $shipingAddressX3Lines . '
						
						<p style="font-family:Arial; font-size:10pt; text-align:left; margin:0px; padding:0px;">Shipping City:<b>' . $_POST["city_" . ChequeData::TYPE_SHIPING] . '</b></p>
						<p style="font-family:Arial; font-size:10pt; text-align:left; margin:0px; padding:0px;">Shipping Province:<b>' . $_POST["province_" . ChequeData::TYPE_SHIPING] . '</b></p>
						<p style="font-family:Arial; font-size:10pt; text-align:left; margin:0px; padding:0px;">Shipping Postal Code:<b>' . $_POST["postalCode_" . ChequeData::TYPE_SHIPING] . '</b></p>
						
						<p style="font-family:Arial; font-size:10pt; text-align:left; margin:0px; padding:0px;">Shipping Phone:&nbsp;<b>' . $_POST["phone_" . ChequeData::TYPE_SHIPING] . '</b></p>
						
						
						<br>
						<p style="font-family:Arial; font-size:10pt; text-align:left; margin:0px; padding:0px;">Thank you, any questions' . " don't" . ' hesitate to call/email.</p>
						<br/>
						<p style="font-family:Arial; font-size:10pt; text-align:left; margin:0px; padding:0px;">** Please use discount code ' . $email_discount_code . ' for this NEW order. which is listed on your website **</p>
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

    public function SEND() {
        /*
          //print $this->EmailMessageWhenDepositBooksSElected();
          print $this->emailMessageForMe();
          //print '<br/>';
          //print $this->emailMessageForClient();
          return;
         */
        $this->SetEmailForMe();
        $this->SetEmailForClient();
        $this->mailFactory = &Mail::factory('mail');
        if ($this->mailFactory->send($this->to, $this->headersForMe, $this->bodyForMe) &&
                $this->mailFactory->send($this->chequeData->CIEmail(), $this->headersForClient, $this->bodyForClient)) {
            
        } else {
            
        }
        if (Product::$DEPOSIT_BOOK->invoice_amount() != 0) {
            $this->headers = array('From' => $this->from, 'Subject' => "Deposit Slip Order " . $this->chequeData->CINAComapanyNameLinivche() . " Confirmation #" . OrderNumber::$CURR_ORDER->orderLabel_withPower() . "");
            $this->headersForMe = $this->mimeToMeForDeposit->headers($this->headers);
            $this->mailFactory->send($this->to, $this->headersForMe, $this->mimeToMeForDeposit->get());
        }
        AddressDepositStampMail::INIT_AND_SEND($this);
    }

    public function SEND_AFTER_UPDATE_INTO_ADMIN() {
        //print "===>>>>".$_POST["fso_admin_submit_additions"];
        $this->mailFactory = &Mail::factory('mail');
        $arrayValuesAfterSubmitForSending = explode(",", $_POST["fso_admin_submit_additions"]);
        $this->SetEmailForMe();
        //$this->mailFactory->send($this->to, $this->headersForMe, $this->bodyForMe);
        if ($arrayValuesAfterSubmitForSending[0] == "1") {
            $this->mailFactory->send($_POST["sendToPrintNowEmail"], $this->headersForMe, $this->bodyForMe);
        }
        $this->SetEmailForClient();
        if ($arrayValuesAfterSubmitForSending[1] == "1") {
            $this->mailFactory->send($this->chequeData->CIEmail(), $this->headersForClient, $this->bodyForClient);
        }
        if ($arrayValuesAfterSubmitForSending[2] == "1") {
            $this->mailFactory->send($_POST["admin_second_email_for_customer"], $this->headersForClient, $this->bodyForClient);
        }
        //$this->depositBooksHTML()
        /*
          public static $DEPOSIT_BOOK;
          public static $DWE;
          public static $SSDWE;
          public static $CHEQUE_BINDER;
          public static $SELF_INKING_STAMP;
         */
        if (Product::$DEPOSIT_BOOK->invoice_amount() != 0) {
            $this->headers = array('From' => $this->from, 'Subject' => "Deposit Slip Order " . $this->chequeData->CINAComapanyNameLinivche() . " Confirmation #" . OrderNumber::$CURR_ORDER->orderLabel_withPower() . "");
            $this->headersForMe = $this->mimeToMeForDeposit->headers($this->headers);
            $this->mailFactory->send($this->to, $this->headersForMe, $this->mimeToMeForDeposit->get());
        }
        AddressDepositStampMail::INIT_AND_SEND($this);
    }

}
?>