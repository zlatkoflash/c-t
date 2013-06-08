<?php
	if(!class_exists("SETTINGS")){require_once("settings.php");}
	if(!class_exists("DB_DETAILS")){require_once( "db_details.php" );}
	if(!class_exists("PasswordHash")){require_once("tools/password_hash_wordpress.php");}
	if(!class_exists("OrderNumber")){require_once("tools/cheque_order_moderator.php");}
	if(!class_exists("Cheque")){require_once("tools/cheque.php");}
	if(!class_exists("SendEMail")){require_once("tools/message_system.php");}
	if(!class_exists("SearchTool")){require_once("tools/search_orders.php");}
	if(!class_exists("XMLParser")){require_once("tools/order_files_moderator.php");}
	if(!class_exists("HELPWordpress")){require_once("tools/help.php");}
	if(!class_exists("User")){require_once("tools/user.php");}
	require_once("settings_moderator.php");
        require_once 'taxes_moderator.php';
	
	$user = new User();
	
	require_once("pdf-tools/fpdf.php");
	require_once("pdf-tools/pdf-helper.php");
	
	global $WHEN_UPDATING_CHEQUE_IS_NEW;
	$GLOBALS["WHEN_UPDATING_CHEQUE_IS_NEW"] = true;
	
	if(isset($_POST["SEARCH_ORDERS_PLEASE"]))
	{
		SearchTool::SEARCH_ORDERS_PLEASE();
	}
	
	/*
	 * On admin home page, when somebody click new cheque laser or manual
	 * this action is going and it is creating new blank order.
	 * */
	if(isset($_POST["CREATE_ORDER_NEW_ByChequeType"]))
	{
                ChequeData::SET_DATE_VALUE_FOR_NEW_ORDER__INTO_CHEQUE_DATA();
		OrderNumber::CREATE_ORDER_NEW_ByChequeType();
	}
	////////////////////////////////////////////////////////////////////////////////////
	////////////////////////////////////////////////////////////////////////////////////
	////////////////////////////////////////////////////////////////////////////////////
	////////////////////////////////////////////////////////////////////////////////////
	////////////////////////////////////////////////////////////////////////////////////
        //print_r($_POST);
	if(isset($_POST["save_order"]) && !isset($_POST["payment_go"]))
	{
                ChequeData::SET_DATE_VALUE_FOR_NEW_ORDER__INTO_CHEQUE_DATA();
		require_once("db_details.php");
		$objCheque = new Cheque( $_POST["chequeType"] );
		$orderNumber = new OrderNumber( $objCheque );
		XMLParser::SAVE_XML_ORDER( );
		print $orderNumber->orderFileName;
	}
	/**/
	if(isset($_POST["sendPDFandEmail"]) && $_POST["sendPDFandEmail"]=="SEND_EMAIL")
	{
                ChequeData::SET_DATE_VALUE_FOR_NEW_ORDER__INTO_CHEQUE_DATA();
		$objCheque = new Cheque( $_POST["chequeType"] );
		OrderNumber::$CURR_ORDER = new OrderNumber( $objCheque );
                $_POST["order_number_reference"] = OrderNumber::$CURR_ORDER->orderLabel;
		XMLParser::SAVE_XML_ORDER( );
		CSVCreator::INIT_AND_SAVE_CSV( );
		$objSendEMail = new SendEMail( $objCheque, true );
	}
	if(isset($_POST["update_order_please"]))
	{
                $_POST["order_number_reference"] = $_POST["fso_order_number"];
                
		/*
		//print $_POST["countVariables"]."=======<br>";
		for($i=0;$i<$_POST["countVariables"];$i++)
		{
			$variable = $_POST["var__".$i];
			$_POST[$variable] = $_POST["val__".$i];
			unset( $_POST["var__".$i] );
			unset( $_POST["val__".$i] );
			//print "[".$variable."]=[".$_POST["val__".$i]."]<br>";
		}*/
		//print_r( $_POST );
		$objCheque = new Cheque( $_POST["chequeType"] );
		//OrderNumber::$CURR_ORDER = new OrderNumber( $objCheque, false, $_POST["fso_order_number"], true );
		/*
		 * $GLOBALS["WHEN_UPDATING_CHEQUE_IS_NEW"] = false;
		 * if it is true it will not create -A, B....
		 * Always false and do -A,B,C.....xN
		 * */
		//$GLOBALS["WHEN_UPDATING_CHEQUE_IS_NEW"] = false;
		/**/
		//print $_POST["setupNewVariable"] ;
		/**/
		if($_POST["setupNewVariable"] == "true")
		{
                    ChequeData::SET_DATE_VALUE_FOR_NEW_ORDER__INTO_CHEQUE_DATA();
		    $_POST["IS_NEW_CREATED_ORDER_FROM_EXISTING_ORDER"] = "true";
		    //olf order number creating new when new cheque
		    OrderNumber::$CURR_ORDER = new OrderNumber( $objCheque, true );
		    if(!class_exists("ProductsModerator")){require_once("products_moderator.php");}
		    ProductsModerator::DUPLICATE_DISCOUNTS_FOR_NEW_ORDER($_POST["fso_order_number"], OrderNumber::$CURR_ORDER->orderLabel);
                    $_POST["order_number_reference"] = OrderNumber::$CURR_ORDER->orderLabel;
                    //print OrderNumber::$CURR_ORDER->orderLabel;
                    //print ">>>>>>>>>>>";
                    //print_r( $_POST );
		}
		else
		{
                    //print_r( $_POST );
			OrderNumber::$CURR_ORDER = new OrderNumber( $objCheque, false, $_POST["fso_order_number"], true );
			//print $_POST["fso_order_number"];
			if($_POST["setupNewVariable"] == "it_is_empthy_new_created_from_admin")
			{
			}
			else
			{
				$GLOBALS["WHEN_UPDATING_CHEQUE_IS_NEW"] = false;
			}
		}
		 
		
		/*
		Because of the pow of the orders, on update or new from admin this number will be same.
		*/
		//OrderNumber::$CURR_ORDER = new OrderNumber( $objCheque, false, $_POST["fso_order_number"], true );
                
		unset($_POST["user_is_logged"]);
		unset($_POST["update_order_please"]);
		unset($_POST["fso_order_number"]);
		unset($_POST["countVariables"]);
		unset($_POST["setupNewVariable"]);
		
		XMLParser::SAVE_XML_ORDER( );
		CSVCreator::INIT_AND_SAVE_CSV( );
                
                /*
                 * 
                 * If order is new created from admin,
                 * then add admin type of creator.
                 */
                if(isset($_POST["IS_NEW_CREATED_ORDER_FROM_EXISTING_ORDER"])
                        && $_POST["IS_NEW_CREATED_ORDER_FROM_EXISTING_ORDER"] == "true")
                {
                    OrderNumber::$CURR_ORDER->set_admin_creator( $_POST["order_number_reference"] ); 
                }
                
		$_POST["after_updating_order"] = "true";
		$objSendEMail = new SendEMail( $objCheque, true );
	}
        
        /*
         * This is comming from direction admin when use is contributor.
         * Actualy is resaving the csv files.Nothing special
         */
        if(isset($_POST["admin_action"]) && $_POST["admin_action"]=="UPDATE_CSVCSV_INTO__csv_files__FOLDER")
        {
            XMLParser::ADD_ORDER_XML_TO_POST( Settings::ORDERS_FOLDER."xml/".$_POST["fso_order_number"].".xml" );
            $objCheque = new Cheque( $_POST["chequeType"] );
            $objChequeData = new ChequeData( $objCheque );
            OrderNumber::$CURR_ORDER = new OrderNumber($objCheque, false, $_POST["fso_order_number"]);
            CSVCreator::INIT_AND_SAVE_CSV( );
            ?>
            <script>
                window.location.href = "<?php print SETTINGS::URL_TO_REDIRECTION_FOR_CONTRIBUTERS; ?>";
            </script>
            <?php
        }

	/*
	if(isset($_GET["order_number_backup"]))
	{
		if(!class_exists("EmailTemplate")){require_once( "mail_message_template.php" );}
		if(!file_exists(SETTINGS::ORDERS_FOLDER_FOR_XML.$_GET["order_number_backup"].".xml"))
		{
			print "Order {".$_GET["order_number_backup"]."} don't exist!!!";
			return;
		}
		XMLParser::ADD_ORDER_XML_TO_POST( SETTINGS::ORDERS_FOLDER_FOR_XML.$_GET["order_number_backup"].".xml" );
		$objCheque = new Cheque( $_POST["chequeType"] );
		OrderNumber::$CURR_ORDER = new OrderNumber( $objCheque, false );
		OrderNumber::$CURR_ORDER->orderLabel = $_GET["order_number_backup"];
		?>
        <div style="text-align:center; width:600px; background-color:#FCC; font-family:Arial, Helvetica, sans-serif; padding:50px;">
        	<div>PDFs Files<br /></div>
        	<a href="<?php print "orders/".OrderNumber::$CURR_ORDER->orderLabel."/cheque.pdf"; ?>">cheque&nbsp;&nbsp;</a>
        	<a href="<?php print "orders/".OrderNumber::$CURR_ORDER->orderLabel."/chequePROrder.pdf"; ?>">chequePROrder&nbsp;&nbsp;</a>
        	<a href="<?php print "orders/".OrderNumber::$CURR_ORDER->orderLabel."/chequeREOrder.pdf"; ?>">chequeREOrder&nbsp;&nbsp;</a>
        	<a href="<?php print "orders/".OrderNumber::$CURR_ORDER->orderLabel."/chequeOrderFormTemplate.pdf"; ?>">chequeOrderFormTemplate</a>
        </div>
        
		<?php
		$objMMT = new EmailTemplate( $objCheque, NULL, NULL, NULL, new ChequeData($objCheque));
				print 'Message to me:<br/>';
				print $objMMT->emailMessageForMe();
				print '<br/>Message to client:<br/>';
				print $objMMT->emailMessageForClient();
	}
	*/
	 
	class DeliveryModerator
	{
		public static function GET_ALL_RATES_FOR_8to10_business_days_for_postal_code()
		{
			$SQLAction = "
				call get_canada_postal_code_to_COMBINATION(
							'".$_POST["GET_ALL_RATES_FOR_8to10_business_days_for_postal_code"]."'
																);
			";
			$rows = DB_DETAILS::ADD_ACTION($SQLAction, DB_DETAILS::$TYPE_SELECT);
			//print "[".count($rows)."]";
			//print $SQLAction;
			$XMLdata = "<source>";
			if(count($rows) > 0)
			{
				$rows = $rows[0];
				foreach($rows as $key => $val)
				{
					$XMLdata .= "<data_".$key.">".$val."</data_".$key.">";
				}
			}
			$XMLdata .= "</source>";
			print $XMLdata;
		}
	}
	if(isset($_POST["GET_ALL_RATES_FOR_8to10_business_days_for_postal_code"]))
	{
		DeliveryModerator::GET_ALL_RATES_FOR_8to10_business_days_for_postal_code();
	}
	/*
	else if(isset($_GET["showDetailsForTestingGetRows"]))
	{
		$allrows = DB_DETAILS::ADD_ACTION("SELECT * FROM canada_postal_codes_rates", DB_DETAILS::$TYPE_SELECT);
		print_r( $allrows );
		$_POST["GET_ALL_RATES_FOR_8to10_business_days_for_postal_code"] = $_GET["showDetailsForTestingGetRows"];
		DeliveryModerator::GET_ALL_RATES_FOR_8to10_business_days_for_postal_code();
	}*/
	
	/**/
	if(isset($_POST["CREATE_INVOICE_FOR_ADDITIONAL_PRODUCTS"]))
	{
		ChequeData::SET_POST_DATA_FOR_USING();
		switch($_POST["CREATE_INVOICE_FOR_ADDITIONAL_PRODUCTS"])
		{
			case CreateInvoice_for_additionalProductsCSV::TYPE:
			{
				require_once("pdf_cheque_templates/invoice_pdf_list.php");
				$airmilesCSV = new AIRMILES_CSV();
				$airmilesCSV->update_master_airmiles_field();
				CreateInvoice_for_additionalProductsCSV::CREATE_INVOICE_FOR_ADDITIONAL_PRODUCTS();
			}break;
			case Create_Receipt__forAdditionalProductsCSV::TYPE:
			{
				Create_Receipt__forAdditionalProductsCSV::CREATE_RECEIPT_FOR_ADDITIONAL_PRODUCT();	
			}break;
		}
	}
	
	class CreditCardNumber
	{
		public static function formatCreditCard( $cc, $letter_between )  
		{  
			// Clean out extra data that might be in the cc  
			$cc = str_replace( array( $letter_between, ' ' ), '', $cc );  
			  
			// Get the CC Length  
			$cc_length = strlen( $cc );  
			  
			// Initialize the new credit card to contian the last four digits  
			$newCreditCard = substr( $cc, -4 );  
			  
			// Walk backwards through the credit card number  
			//and add a dash after every fourth digit  
			for ( $i = $cc_length - 5; $i >= 0; $i-- )  
			{  
			  
				// If on the fourth character add a dash  
				if ( (($i + 1) - $cc_length) % 4 == 0 )  
				{  
				$newCreditCard = '-' . $newCreditCard;  
				}  
			  
				// Add the current character to the new credit card  
				$newCreditCard = $cc[$i] . $newCreditCard;  
			}  
			  
			// Return the formatted credit card number  
			return $newCreditCard;  
		}  
 

		/**
		* Replaces all but the last for digits with x’s in the given credit card number
		* @param int|string $cc The credit card number to mask
		* @return string The masked credit card number
		*/

		function maskCreditCard( $cc )  
		{  
			// Get the cc Length  
			 $cc_length = strlen( $cc );  
			// Replace all characters of credit card except the last four and dashes  
			for ( $i = 0; $i < $cc_length - 4; $i++ )  
			{  
				if ( $cc[$i] == '-' )  
				{  
					continue;  
				}  
				$cc[$i] = 'X'; 
			}  
			  
			// Return the masked Credit Card #  
			return $cc;  
		}  
	}
	
        
        class BankDetails
        {
            public $id=-1, 
                   $institution=0,
                   $brunch=0,
                    $bank_name="",
                    $address1="",
                    $address2="",
                    $address3="",
                    $address4="";
                    
            public function BankDetails($row_data)
            {
                if($row_data == NULL)
                {
                    return;
                }
                $this->id = $row_data["id"];
                $this->institution = $row_data["institution"];
                $this->brunch = $row_data["brunch"];
                $this->bank_name = $row_data["bank_name"];
                $this->address1 = $row_data["address1"];
                $this->address2 = $row_data["address2"];
                $this->address3 = $row_data["address3"];
                $this->address4 = $row_data["address4"];
            }
            public function data()
            {
                $base_account_number = self::get_base_account_number( $this->institution );
                return "<source><id>".$this->id."</id><institution>".
                                      $this->institution."</institution><brunch>".
                                      $this->brunch."</brunch><bank_name><![CDATA[".
                                      $this->bank_name."]]></bank_name><address1><![CDATA[".
                        $this->address1."]]></address1><address2><![CDATA[".
                        $this->address2."]]></address2><address3><![CDATA[".
                        $this->address3."]]></address3><address4><![CDATA[".
                        $this->address4."]]></address4><base_account_number>".
                        $base_account_number."</base_account_number></source>";
            }
            
            public static function LOAD_DETAILS_FOR_THE_BANK()
            {
                $sql_select_details = "
                            SELECT * FROM bank_details
                            WHERE 
                            institution='".$_POST["institution"]."' AND
                            brunch='".$_POST["brunch"]."'
                ";
                $row_bank_details = 
                        DB_DETAILS::ADD_ACTION($sql_select_details, DB_DETAILS::$TYPE_SELECT);
                if(count($row_bank_details) == 0)
                {
                    $bank_details = new BankDetails( NULL );
                    $bank_details->institution = $_POST["institution"];
                }
                else
                {
                    $bank_details = new BankDetails( $row_bank_details[0] );
                } 
                print $bank_details->data();
            }
            
            public static function institution_details($institution, $account_number_not_resetted=0)
            {
                return "<institution_details><amount_account_numbers>".self::get_amount_letters_acording_to_institution($institution)
                        ."</amount_account_numbers><reseted_account_number>".self::get_account_number_acording_to_institution($institution, $account_number_not_resetted).
                        "</reseted_account_number></institution_details>";
            }
            const DASH = 666;
            const EMPTHY_SPACE = 0;
            /*
             * This array hold all information for account number according to institution
             * 666 is for dush, 0 is for empthy space
             */
            public static $ACCOUNT_NUMBER_SITUATIONS = array
            (
                "001"=>array(0,0,0,0,4,666,3),
                "002"=>array(0,5,666,2),
                "003"=>array(0,0,0,3,666,3,666,1),
                "004"=>array(0,4,666,7),
                "005"=>array(0,0,0,0,0,4,666,3),
                "006"=>array(0,0,0,2,666,3,666,2),
                "010"=>array(0,2,666,5),
                "219"=>array(0,7,666,0,2),
                "016"=>array(0,6,666,3),
                "030"=>array(0,2,666,3,666,3,666,1),
                "260"=>array(0,11),
                "809"=>array(0,0,2,666,3,666,3,666,1),
                "879"=>array(0,0,0,3,666,3,666,1),
                "828"=>array(0,0,0,5,666,3),//ontario non aligned credit union
                "828"=>array(0,7,666,3),//ontario, member of credit union central
                "845"=>array(6,666,3),
                "845"=>array(6,666,3)
            );
            private static function get_amount_letters_acording_to_institution($institution)
            {
                $need_amount_letters = 0;
                for($i=0;$i<count(self::$ACCOUNT_NUMBER_SITUATIONS[$institution]);$i++)
                {
                    if(self::$ACCOUNT_NUMBER_SITUATIONS[$institution][$i] != self::DASH && 
                            self::$ACCOUNT_NUMBER_SITUATIONS[$institution][$i] != self::EMPTHY_SPACE)
                    $need_amount_letters += self::$ACCOUNT_NUMBER_SITUATIONS[$institution][$i];
                }
                return $need_amount_letters;
            }
            private static function get_base_account_number($institution)
            {
                if(!isset(self::$ACCOUNT_NUMBER_SITUATIONS[$institution])){return "0";}
                $base_number = "";
                for($i=0;$i<count(self::$ACCOUNT_NUMBER_SITUATIONS[$institution]);$i++)
                {
                    if(self::$ACCOUNT_NUMBER_SITUATIONS[$institution][$i] == self::DASH)
                    {
                        $base_number .= "-";
                    }
                    else if(self::$ACCOUNT_NUMBER_SITUATIONS[$institution][$i] == self::EMPTHY_SPACE)
                    {
                        $base_number .= " ";
                    }
                    else
                    {
                        for($j=0;$j<self::$ACCOUNT_NUMBER_SITUATIONS[$institution][$i];$j++)
                        {
                            $base_number .= "0";
                        }
                    }
                }
                return $base_number;
            }
            public static function get_account_number_acording_to_institution($institution, $account_number_not_resetted)
            {
                if(!isset(self::$ACCOUNT_NUMBER_SITUATIONS[$institution])){return $account_number_not_resetted;}
                $need_amount_letters = self::get_amount_letters_acording_to_institution($institution, $account_number_not_resetted);
                if(strlen($account_number_not_resetted) != $need_amount_letters){return $account_number_not_resetted;}
                $account_number_edited = "";
                $account_number_edited_substr_start_index = 0;
                for($i=0;$i<count(self::$ACCOUNT_NUMBER_SITUATIONS[$institution]);$i++)
                {
                    if(self::$ACCOUNT_NUMBER_SITUATIONS[$institution][$i] == self::DASH)
                    {
                        $account_number_edited .= "-";
                    }
                    else if(self::$ACCOUNT_NUMBER_SITUATIONS[$institution][$i] == self::EMPTHY_SPACE)
                    {
                        $account_number_edited .= " ";
                    }
                    else
                    {
                        $length_number = self::$ACCOUNT_NUMBER_SITUATIONS[$institution][$i];
                        $account_number_edited .= substr($account_number_not_resetted, $account_number_edited_substr_start_index, $length_number);  
                        $account_number_edited_substr_start_index += $length_number;
                    }
                }
                return $account_number_edited;
            }
            public static function get_formated_account_number_acording_to_institution()
            {
                print self::institution_details($_POST["institution"], 
                        $_POST["account_number_not_resetted"]);
            }
        }
        if(isset($_POST["LOAD_DETAILS_FOR_THE_BANK"]))
        {
            BankDetails::LOAD_DETAILS_FOR_THE_BANK();
        }
        if(isset($_POST["get_formated_account_number_acording_to_institution"]))
        {
            BankDetails::get_formated_account_number_acording_to_institution();
        }
        //testing
        //print BankDetails::get_account_number_acording_to_institution("001", "1234567");
        //print BankDetails::get_account_number_acording_to_institution("809", "123456789");
?>
