<?php 

	
	/*
	$folder = "orders/laser_orders/completed_orders/T_L5864-C/";
	chdir( $folder );
	exec ("del *.* /s /q");
	unlink( $folder );
	SendEMail::delete_directory( $folder );
	*/
	//rmdir("orders/laser_orders/completed_orders/T_L5864-C/");
	//unlink("orders/laser_orders/completed_orders/T_L5864-C/");
	////////////////////////////////////////////////////////////////////////////////////////////////
	////////////////////////////////////////////////////////////////////////////////////////////////
	/////Order number creator
	////////////////////////////////////////////////////////////////////////////////////////////////
	class OrderNumber
	{
            const CREATOR_ADMIN="admin";
            const CREATOR_CLIENT="client";
            
		const LABEL_LASER_BEFORE="L";
		const LABEL_MANUAL_BEFORE="M";
		static $START_ORDER_INDEX=5000;
		private $cheque;
		private $orderIndex=0;
		public $orderFileName;
		public $orderLabel="";
		public static $CURR_ORDER = NULL;
		public $isCreatingAfterAdminInit=false;
		
		public function OrderNumber($chequ___=NULL, $setupYes=true, $orderLabel__=NULL, $isCreatingAfterAdminInit=false)
		{
			$this->isCreatingAfterAdminInit = $isCreatingAfterAdminInit;
			$this->cheque = $chequ___;
			if($setupYes == true)
			{
				$this->orderSet();
			}
			if($setupYes == false && $orderLabel__ != NULL)
			{
				$this->orderLabel = $orderLabel__;
				$this->orderFileName = $orderLabel__;
			}
		}
		function orderSet()
		{
			$lastORderNumberRow=NULL;
			if($this->cheque->type == Cheque::TYPE_LASER)
			{
				self::$START_ORDER_INDEX=5700;
				DB_DETAILS::ADD_ACTION("INSERT INTO orders_laser VALUES()", DB_DETAILS::$TYPE_ACTION);
				$lastORderNumberRow = DB_DETAILS::GET_LAST_ITEM("orders_laser", "id");
					$this->orderIndex = $lastORderNumberRow["id"]+self::$START_ORDER_INDEX;
				$this->orderFileName = SETTINGS::ORDER_SAVING_PLUS_LABEL.self::LABEL_LASER_BEFORE;
				$this->orderLabel = SETTINGS::ORDER_SAVING_PLUS_LABEL.OrderNumber::LABEL_LASER_BEFORE.$this->orderIndex;
			}
			else if($this->cheque->type == Cheque::TYPE_MANUAL)
			{
				self::$START_ORDER_INDEX=3500;
				DB_DETAILS::ADD_ACTION("INSERT INTO orders_manual VALUES()", DB_DETAILS::$TYPE_ACTION);
				$lastORderNumberRow = DB_DETAILS::GET_LAST_ITEM("orders_manual", "id");
					$this->orderIndex = $lastORderNumberRow["id"]+self::$START_ORDER_INDEX;
				$this->orderFileName = SETTINGS::ORDER_SAVING_PLUS_LABEL.self::LABEL_MANUAL_BEFORE;
				$this->orderLabel = SETTINGS::ORDER_SAVING_PLUS_LABEL.OrderNumber::LABEL_MANUAL_BEFORE.$this->orderIndex;;
			}
			//print $this->orderLabel;
			$this->orderFileName .= $this->orderIndex;
		}
		public function orderNumberLabelGet()
		{
			return $this->orderLabel;
		}
		public function orderHTML()
		{
			return '<p style=" background-color:#FF6600; font-family:Arial; font-size:10pt; text-align:left; margin:0px; padding:0px; ">Order Confirmation #:<b>'.$this->orderNumberLabelGet().'</b></p><br /><br />' ;
		}
		public function orderLabel_withPower()
		{
			//print $_POST["update_order_please"];
			if($GLOBALS["WHEN_UPDATING_CHEQUE_IS_NEW"] == true)
			{
				return $this->orderLabel;
			}
			else
			{
				return OrdersDatabase::GET_ORDER_POWER( $this->orderLabel );
			}
		}
		public static function CREATE_ORDER_NEW_ByChequeType()
		{
			$cheque = new Cheque( $_POST["CREATE_ORDER_NEW_ByChequeType"] );
			self::$CURR_ORDER = new OrderNumber($cheque, true);
			$_POST["chequeType"] = $cheque->type;
			XMLParser::SAVE_XML_ORDER();
			/*
			DB_DETAILS::ADD_ACTION("
					INSERT INTO orders_details_power(orderNumber, power) 
						   VALUES('".self::$CURR_ORDER->orderLabel."', 0)");
						   */
			print "<source><order_number>".self::$CURR_ORDER->orderLabel."</order_number><cheque_type>".$cheque->type."</cheque_type></source>";
		}
                
                public function set_admin_creator($order_number)
                {
                    $sql_action = "
                        UPDATE orders_details SET order_creator='".self::CREATOR_ADMIN."' 
                            WHERE orderNumber='".$order_number."'";
                    DB_DETAILS::ADD_ACTION($sql_action);
                    //print $sql_action;
                }
	}
	////////////////////////////////////////////////////////////////////////////////////////////////////////////
	////////////////////////////////////////////////////////////////////////////////////////////////////////////
	/////Class for saving the orders into the database
	////////////////////////////////////////////////////////////////////////////////////////////////////////////
	class OrdersDatabase
	{
		public static $arr_variables = array(
		"date_modify",
		"orderNumberEdited",
		"CICompanyName", "CIContactName", "CIPhone", "CIEmail", "CIQuestionsAndCommentsTA", "CIQuestionsAndComments", 
		"compInfoQuantity","quantityINPUT","quantityINPUTIndex",
		"chequePosition","chequeColor","backgroundINdex",
		"compInfoName","compInfoSecondName","compInfoAddressLine1","compInfoAddressLine2","compInfoAddressLine3","compInfoAddressLine4",
		"comInfoIsSecondCompanyName", /*"CILogoType",*/ 
		"compInfoBankName", "compInfoBankAddress1", "compInfoBankAddress2", "compInfoBankAddress3", "compInfoBankAddress4",
		"isCurrencyINPUT", "add45AfterAcountNumberInput", 
		"compInfoSoftware",//just for laser 
		"compInfoSecondSignatur", "compInfoShowStartNumber", "compInfoStartAt", "compInfoBrunchNumber", "compInfoTransitNumber", "compInfoAccountNumber", 
		"compInfoStartAtTrueOrFalse", "isThereSecondSignature", "softwareINPUT", /*"startAtNumber_plus_1",*/ /*"softwareINPUTIndex",*/ 
		"boxingType",//just for laser 
		"compInfoDepositBooks", 
		"compInfoDWE", "compInfoSSDWE",//just for laser
		"compInfoSelfLinkingStamp", "depositBooksINPUT", "compInfoChequeBinder", "depositBooksINPUT_VARs", "DWEINPUT", "SSDWEINPUT", "chequeBinderINPUT", 
		"SelfLinkStampINPUT", "deliveryINPUT", 
		"companyName_TYPE_BILLING", "contactName_TYPE_BILLING", "address_1_TYPE_BILLING", "address_2_TYPE_BILLING", "address_3_TYPE_BILLING", 
		"city_TYPE_BILLING", "province_TYPE_BILLING", "postalCode_TYPE_BILLING", "phone_TYPE_BILLING", "email_TYPE_BILLING", "isBillToAlternativeName", 
		/*"SameAsBillingDetails",*/ "residentialAddressBSM", "noSignatureRequiredBSM", "companyName_TYPE_SHIPING", "contactName_TYPE_SHIPING", 
		"address_1_TYPE_SHIPING", "address_2_TYPE_SHIPING", "address_3_TYPE_SHIPING", "city_TYPE_SHIPING", "province_TYPE_SHIPING", "postalCode_TYPE_SHIPING", 
		"phone_TYPE_SHIPING", "email_TYPE_SHIPING", "isShipToDifferentAddress", "MOP_directDebit_signature", "MOP_cardNum", 
		"MOPcsv", "mopINPUT", "mopExpirtyMonthINPUT", "mopExpirtyYearINPUT", "mopCallMe", "AIRMILES_cardNumber", "chequeType"/*, "orderNumber"*/,
		"sub_total_products_INPUT", "shipping_price_INPUT", "sub_total_taxes_INPUT", "grand_total_INPUT",
		"orderNumber"); 
		
		public static function SAVE_ORDERS()
		{
			if($GLOBALS["WHEN_UPDATING_CHEQUE_IS_NEW"] == false)
			{
				self::MAKE_POWER_ORDER_NUMBER(  );
			}
			else if($GLOBALS["WHEN_UPDATING_CHEQUE_IS_NEW"] == true)
			{
			}
			$getOrderFromDatabase = DB_DETAILS::ADD_ACTION("SELECT * FROM orders_details
															WHERE orderNumber='".$_POST["orderNumber"]."'
															", DB_DETAILS::$TYPE_SELECT);
			if(count($getOrderFromDatabase) == 0)
			{
				self::CREATE_NEW_ORDER();
			}
			else
			{
				self::UPDATE_ORDER();
			}
			$timeNowSeconds = time();
			$timeNowSeconds *= 1000;//to milliseconds
			DB_DETAILS::ADD_ACTION("UPDATE orders_details SET date_modify=".$timeNowSeconds." WHERE orderNumber='".$_POST["orderNumber"]."'");
		}
		private static function CREATE_NEW_ORDER()
		{
			$allVariables = "";
			$allvAlues = "";
			for($i=0;$i<count(self::$arr_variables);$i++)
			{
				if($i > 0)
				{
					$allVariables .= ",";
					$allvAlues .= ",";
				}
				$allVariables .= self::$arr_variables[$i];
				if(!isset($_POST[self::$arr_variables[$i]]))
				{
					$_POST[self::$arr_variables[$i]] = "is not set";
				}
				if(self::$arr_variables[$i]== "orderNumberEdited")
				{
					$allvAlues .= "'".self::GET_ORDER_POWER($_POST["orderNumber"])."'";
				}
				else
				{
					$allvAlues .= "'".$_POST[self::$arr_variables[$i]]."'";
				}
			}
			DB_DETAILS::ADD_ACTION(" INSERT INTO orders_details(".$allVariables.")
									 VALUES(".$allvAlues.") ");
		}
		private static function UPDATE_ORDER()
		{
			$allvAlues = "";
			for($i=0;$i<count(self::$arr_variables);$i++)
			{
				if($i > 0)
				{
					$allvAlues .= ",";
				}
				if(!isset($_POST[self::$arr_variables[$i]]))
				{
					$_POST[self::$arr_variables[$i]] = "is not set";
				}
				if(self::$arr_variables[$i]== "orderNumberEdited")
				{
					$allvAlues .= self::$arr_variables[$i]."='".self::GET_ORDER_POWER($_POST["orderNumber"])."'";
				}
				else
				{
					$allvAlues .= self::$arr_variables[$i]."='".$_POST[self::$arr_variables[$i]]."'";
				}
			}
			DB_DETAILS::ADD_ACTION(" UPDATE orders_details
									  SET ".$allvAlues."
									  WHERE orderNumber='".$_POST["orderNumber"]."'
									  ");
		}
		/*
		This is function that is for create order-A.....YZ
		*/
		private static function MAKE_POWER_ORDER_NUMBER()
		{
			$rowOrderPower = DB_DETAILS::ADD_ACTION("
									SELECT * FROM orders_details_power WHERE orderNumber='".$_POST["orderNumber"]."'
			", DB_DETAILS::$TYPE_SELECT);
			if(count($rowOrderPower) == 0)
			{
				DB_DETAILS::ADD_ACTION("INSERT INTO orders_details_power(orderNumber, power) VALUES('".$_POST["orderNumber"]."', 1)");
			}
			else
			{
				$orderPower = $rowOrderPower[0]["power"];
				$orderPower += 1;
				DB_DETAILS::ADD_ACTION("UPDATE orders_details_power 
										SET power=".$orderPower." 
										WHERE orderNumber='".$_POST["orderNumber"]."'");
			}
		}
		private static function getPowerPlusLabel($arr)
		{
			$str = "";
			for($i=0;$i<count($arr);$i++)
			if($arr[$i] != -1)
			{
				if($i > 0){$str .= "";}
				$str .= substr(HELPWordpress::UPPER_LETTERS, $arr[$i], 1);
			}
			if($str == "")
			{
				return "";
			}
			return "-".$str;
		}
		public static function GET_ORDER_POWER( $orderNumber=NULL, $setMinus1=false )
		{
			$rowOrderPower = DB_DETAILS::ADD_ACTION("
									SELECT * FROM orders_details_power WHERE orderNumber='".$orderNumber."'
			", DB_DETAILS::$TYPE_SELECT);
			if(count($rowOrderPower) == 0)
			{
				return  $orderNumber;
			}
			$endCombinations = $rowOrderPower[0]["power"];
			//print "[".$orderNumber."]";
			//print "[".$endCombinations."]";
			if($setMinus1 == true)
			{
				$endCombinations--;
				if($endCombinations == 0)
				{
					return $orderNumber;
				}
			}
			
			$stringLenhth = strlen( HELPWordpress::UPPER_LETTERS );
			$arrayIndexes = array();
			for($i=0;$i<strlen(HELPWordpress::UPPER_LETTERS);$i++)
			{
				$arrayIndexes[$i] = "-1";
			}
			//print_r( $arrayIndexes );
			//print "<br>";
			
			$columnWhereToPut = 0;
			for($i=0;$i<count($arrayIndexes);$i++)
			{
				if($arrayIndexes[$i])
				{
				}
			}
			for($i=1;$i<=$endCombinations;$i++)
			{
				$arrayIndexes[$columnWhereToPut]++;
				if($arrayIndexes[$columnWhereToPut] == $stringLenhth)
				{
					$tempColumnWhereIPut = $columnWhereToPut;
					$max = 0;
					$icanLook = true;
					/**/
					while($arrayIndexes[$columnWhereToPut]+1 >= $stringLenhth && $columnWhereToPut > 0)
					{
						$columnWhereToPut--;
					}
					$arrayIndexes[$columnWhereToPut]++;
					if($arrayIndexes[$columnWhereToPut] >= $stringLenhth && $columnWhereToPut==0)
					{
						for($k=0;$k<=$tempColumnWhereIPut+1;$k++)
						{
							$arrayIndexes[$k] = 0;
						}
						$columnWhereToPut = $tempColumnWhereIPut+1;	
					}
					else
					{
						for($k=$columnWhereToPut+1;$k<=$tempColumnWhereIPut;$k++)
						{
							$arrayIndexes[$k] = 0;
						}
						$columnWhereToPut = $tempColumnWhereIPut;
					}
				}
			}
			return $orderNumber.self::getPowerPlusLabel( $arrayIndexes );
		}
	}
	/*just for testing
	if(isset($_GET["GET_ORDER_POWER"]))
	{
		print OrdersDatabase::GET_ORDER_POWER( "T_M3532" );
		print "<br>this testing must be commented";
	}*/

?>