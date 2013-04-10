<?php


	////////////////////////////////////////////////////////////////////////////////////////////////////////////
	////////////////////////////////////////////////////////////////////////////////////////////////////////////
	/////Class for Saving the order of the cheque
	////////////////////////////////////////////////////////////////////////////////////////////////////////////
	class XMLParser
	{
		public static $VARIABLES = array();
		
		public function XMLParser()
		{
		}
		public static function SAVE_XML_ORDER(  )
		{
			$myFile = SETTINGS::ORDERS_FOLDER_FOR_XML.OrderNumber::$CURR_ORDER->orderFileName.".xml";
			$_POST["orderNumber"] = OrderNumber::$CURR_ORDER->orderFileName;
			$fh = fopen($myFile, 'w');
			fwrite($fh, self::GET_XML_ORDER());
			fclose($fh);
			//////////////////////////////////////////////////////////////////////////////
			//////////////////////////////////////////////////////////////////////////////
			/////Saving orders to database
			//////////////////////////////////////////////////////////////////////////////
			OrdersDatabase::SAVE_ORDERS();
		}
		public static function GET_XML_ORDER()
		{
			$XMLSource = '<source>
			';
			foreach($_POST as $key => $value)
			{
				$XMLSource .= '<'.$key.'><![CDATA['.$value.']]></'.$key.'>
							   ';
			}
			$XMLSource .= '
			</source>';
			return $XMLSource;
		}
		public static function ADD_ORDER_XML_TO_POST( $orderFilePath, $setupToPOST=true )
		{
			$xmlDocument = new DOMDocument();
			$xmlDocument->load( $orderFilePath );
			$x = $xmlDocument->documentElement;
			foreach($x->childNodes as $item)
			{
				//print "[".$item->nodeName . "] = [" . $item->nodeValue . "]<br />";
				if($setupToPOST == true)
				{
					$_POST[$item->nodeName] = stripslashes( $item->nodeValue );
				}
				else
				{
					XMLParser::$VARIABLES[$item->nodeName] = stripslashes( $item->nodeValue );
				}
			}
			//print "[".$orderFilePath."]";
		}
	}
	class CSVBase
	{
		public $source;
		
		protected function getHeaderAndValues($arrayVariablesOrdered)
		{
			$variables="";
			$values="";
			$zapirkaBefore="";
			for($i=0;$i<count($arrayVariablesOrdered);$i++)
			{
				$variables .= $zapirkaBefore.$arrayVariablesOrdered[$i];
				$value = $_POST[$arrayVariablesOrdered[$i]];
				if($value==""){$value="-";}
				$values .= $zapirkaBefore.'"'.$value.'"';
				//$textZaSnimanje .= $key.",".$value."\n";
				$zapirkaBefore = ",";
				//print "[".$key."]=>".$value."<br/>";
			}
			return array("header"=>$variables, "values"=>$values);
		}
		protected function getHeaderFromVariables($arrayVariablesHeader)
		{
			$header = "";
			for($i=0;$i<count($arrayVariablesHeader);$i++)
			{
				if($i>0)
				{
					$header .= ",";
				}
				$header .= $arrayVariablesHeader[$i];
			}
			return $header;
		}
		protected function getValuesRowForVariablesAndValuesByName($arrayVariablesHeader, $rowValuesFor)
		{
			/*
			print_r($arrayVariablesHeader);
			print "<br/>";
			print_r($rowValuesFor);
			print "<br/>";
			print $rowValuesFor[$arrayVariablesHeader[0]];
			print "<br/>==================================<br/>";
			*/
			$rowValues = "";
			for($i=0;$i<count($arrayVariablesHeader);$i++)
			{
				if($i>0)
				{
					$rowValues .= ",";
				}
				$rowValues .= '"'.$rowValuesFor[$arrayVariablesHeader[$i]].'"';
			}
			return $rowValues;
		}
		private function getAllValuesStrCSVFromValues($variables, $valuesArr)
		{
			$valuesCSVAll = "";
			for($i=0;$i<count($valuesArr);$i++)
			{
				if($i>0)
				{
					$valuesCSVAll .= "\n";
				}
				$valuesCSVAll.=$this->getValuesRowForVariablesAndValuesByName($variables, $valuesArr[$i]);
			}
			return $valuesCSVAll;
		}
		protected function create_csv_from_variables_values( $variables, $valuesArr, $csv_url )
		{
			$headerStr = $this->getHeaderFromVariables( $variables );
			$valuesStr = $this->getAllValuesStrCSVFromValues( $variables, $valuesArr );
			$textZaSnimanje = $headerStr."\n".$valuesStr;
			$fh = fopen($csv_url, 'w');
			fwrite($fh, $textZaSnimanje);
			fclose($fh);
		}
		protected function create_csv_file($source, $url)
		{
			$fh = fopen($url, 'w');
			fwrite($fh, $source);
			fclose($fh);
		}
		protected function update_csv_file($row___plus__source, $url)
		{
			$file_csv = fopen($url, "a");
			fwrite($file_csv, $row___plus__source);
			fclose($file_csv);
		}
		public function get_source_from_header_values( $variables, $valuesArr )
		{
			$headerStr = $this->getHeaderFromVariables( $variables );
			$valuesStr = $this->getAllValuesStrCSVFromValues( $variables, $valuesArr );
			$textZaSnimanje = $headerStr."\n".$valuesStr;
			return $textZaSnimanje;
		}
		protected function generateNormalToDestination($arrayVariablesOrdered, $CSVFileFolder, $CSVfileName, $showHeader=true)
		{
			$values = $this->getHeaderAndValues( $arrayVariablesOrdered );
			$header = $values["header"];
			$values = $values["values"];
			if($showHeader == true)
			{
				$textZaSnimanje = $header."\n".$values;
			}
			else if($showHeader == false)
			{
				$textZaSnimanje = $values;
			}
			if(!is_dir($CSVFileFolder))
			{
				mkdir($CSVFileFolder);
			}
			$fh = fopen($CSVFileFolder.$CSVfileName.".csv", 'w');
			fwrite($fh, $textZaSnimanje);
			fclose($fh);
		}
		protected function generate($arrayVariablesOrdered, $CSVfileName)
		{
			$myFile = SETTINGS::ORDERS______URL().OrderNumber::$CURR_ORDER->orderLabel_withPower()."/".$CSVfileName.".csv";
			$csvSource = $this->getHeaderAndValues( $arrayVariablesOrdered );
			$textZaSnimanje = "";
			$variables=$csvSource["header"];
			$values=$csvSource["values"];
			/*
			for($i=0;$i<count($arrayVariablesOrdered);$i++)
			{
				$variables .= $zapirkaBefore.$arrayVariablesOrdered[$i];
				$value = $_POST[$arrayVariablesOrdered[$i]];
				if($value==""){$value="-";}
				$values .= $zapirkaBefore.'"'.$value.'"';
				//$textZaSnimanje .= $key.",".$value."\n";
				$zapirkaBefore = ",";
				//print "[".$key."]=>".$value."<br/>";
			}*/
			$textZaSnimanje .= $variables."\n".$values;
			$this->source = $textZaSnimanje;
			//print $variables."<br/>".$values;
			///////////////////////////////////////////////////////////////////////////////////////
			///////////////////////////////////////////////////////////////////////////////////////
			///////////////////////////////////////////////////////////////////////////////////////
			if(!is_dir(SETTINGS::ORDERS______URL().OrderNumber::$CURR_ORDER->orderLabel_withPower()))
			{
				mkdir(SETTINGS::ORDERS______URL().OrderNumber::$CURR_ORDER->orderLabel_withPower());
			}
			$fh = fopen($myFile, 'w');
			fwrite($fh, $textZaSnimanje);
			fclose($fh);
			
			$myFile = SETTINGS::ORDERS_FOLDER_FOR_CSV.$CSVfileName.".csv";
			//$myFile = SETTINGS::ORDERS_FOLDER_FOR_CSV."csv.csv";
			$fh = fopen($myFile, 'w');
			fwrite($fh, $values);
			fclose($fh);
		}
		public function get_source()
		{
			return $this->source;
		}
	}
	class CSVCreator extends CSVBase 
	{
		public static $CSV=NULL;
		
		public function CSVCreator()
		{
			$_POST["orderNumber"] = OrderNumber::$CURR_ORDER->orderLabel_withPower();
			///////////////////////////////////////////////////////////////////////////////////////
			///////////////////////////////////////////////////////////////////////////////////////
			///////////////////////////////////////////////////////////////////////////////////////
			
			$tb = ChequeData::TYPE_BILLING;
			$ts = ChequeData::TYPE_SHIPING;
			$arrayVariablesOrdered = array("orderNumber",
						"companyName_".$ts,"address_1_".$ts,"address_2_".$ts,"address_3_".$ts,"city_".$ts,"province_".$ts,"postalCode_".$ts,"phone_".$ts,"email_".$ts,"contactName_".$ts,"Pieces","Weight",
						"companyName_".$tb,"address_1_".$tb,"address_2_".$tb,"address_3_".$tb,"city_".$tb,"province_".$tb,"postalCode_".$tb,"phone_".$tb,"email_".$tb,"contactName_".$tb,
						"CIQuestionsAndCommentsTA","CIQuestionsAndComments","compInfoQuantity","quantityINPUT",
						"chequeColor","backgroundINdex","chequePosition",
						"compInfoName","compInfoSecondName",/*"compInfoDifferentNameForBilling","compInfoDifferentAddressForShipping",*/"isBillToAlternativeName","isShipToDifferentAddress",
						"CILogoType",
						"compInfoBankName","compInfoBankAddress1","compInfoBankAddress2","compInfoBankAddress3","compInfoBankAddress4",
						"isCurrencyINPUT","compInfoSecondSignatur","compInfoShowStartNumber","compInfoStartAt","compInfoBrunchNumber","compInfoTransitNumber","compInfoAccountNumber",
						"compInfoStartAtTrueOrFalse","isThereSecondSignature","softwareINPUT","startAtNumber_plus_1","compInfoDepositBooks","chequeBinderINPUT",
						"compInfoSelfLinkingStamp","depositBooksINPUT","DWEINPUT","SSDWEINPUT","chequeBinderINPUT","SelfLinkStampINPUT","comInfoIsSecondCompanyName",
						"isBillToAlternativeName","isShipToDifferentAddress",
						"deliveryINPUT","MOP_cardNum","MOPcsv","mopINPUT","mopExpirtyMonthINPUT","mopExpirtyYearINPUT","mopCallMe","AIRMILES_cardNumber","sendPDFandEmail","chequeType"
						);
			
			$_POST["Pieces"] = "pieces";
			$_POST["Weight"] = "1";
			
			$this->generate($arrayVariablesOrdered, "csv");
			
			CSVCreator::$CSV = $this;
		}
		public static function INIT_AND_SAVE_CSV()
		{
			$objCSVCreator = new CSVCreator();
			$objPADCSV = new PADCSV();
		}
	}
	class PADCSV extends CSVBase
	{
		public static $CSV=NULL;
		
		public function PADCSV()
		{
			if(!is_numeric($_POST["compInfoTransitNumber"])){$_POST["compInfoTransitNumber"] = "000";}
			$_POST["orderNumber"] = OrderNumber::$CURR_ORDER->orderLabel_withPower();
			$arrayVariablesOrdered = array("PADColumn1", "PADColumn2", "compInfoTransitNumber", "compInfoBrunchNumber", "compInfoAccountNumber", "PADColum6is0", "orderNumber", "companyName_".ChequeData::TYPE_BILLING);
			$_POST["PADColumn1"] = "E";
			$_POST["PADColumn2"] = "D";
			$_POST["PADColum6is0"] = "0";
			$this->generate($arrayVariablesOrdered, "PA_Debit");
			
			if($_POST["mopINPUT"] == "Direct Debit")
			{
				$this->generateNormalToDestination($arrayVariablesOrdered, 
							SETTINGS::ORDERS_FOLDER_FOR_Debit_Files, 
							OrderNumber::$CURR_ORDER->orderLabel_withPower(), false);
			}
			self::$CSV = $this;
		}
	}
	
	class CreateInvoice_for_additionalProductsCSV extends CSVBase
	{
		const TYPE = "TYPE_INVOICE";
		
		public $variables = array("Invoice_number","UDF_1","Customer_Code","Invoice_Date","Order_number",
		"ship_date","Sales_person","WHS_Location","Currency",
		"Customer_name","Contact_name","Address1","Address2","city",
		"Province","Country","PostCode","email","Phone1","Phone2","Fax2","website","Shipto_Name",
		"Shipto_contact","ship_address1","ship_address2","ship_city","ship_province","ship_zip","ship_country",
		"ship_phone","ship_phone_2","ship_fax","ship_email","Net_Days","Net_disc_percent",
		"net_disc_days","invoice_comment","Header_GL_Account","Payment_method","CC_name",
		"payment_text","record_type","shipper","tracking_number","add_info1","add_Date","line_number",
		"item_code","item_description","UOM","qty_ordered","qty_shipped","qty_bo","base_price",
		"line_disc_percent","unit_price","amount","tax_code","Detail_GL_account","Department",
		"Project","Freight_Line");
		
		protected $id,
				  $date_value;
		
		public function CreateInvoice_for_additionalProductsCSV()
		{	
		}
		public function get_products_detalized()
		{
			$array_values = array();
			if($_POST["products_indexes"] != "")
			{
				$products_selected = explode( "," , $_POST["products_indexes"] );
				for($i=0;$i<count($products_selected);$i++)
				{
					array_push($array_values, $this->object_for_product_by_id( $products_selected[$i], $i+1 ));
				}
			}
			/*
			 * Shiping price object
			 * */
			array_push($array_values, $this->object_for_product_by_id( "-666", count($array_values)+1 ));
			return $array_values;
		}
		private function setup_new_invoice()
		{
			DB_DETAILS::ADD_ACTION("INSERT INTO invoices(date_value) VALUES('".time()."')");
			$last_invoice = DB_DETAILS::GET_LAST_ITEM("invoices", "id");
			$this->id = $last_invoice["id"];
			$this->date_value = time();
		}
		public function create_csv()
		{
			$this->setup_new_invoice();
			
			$array_values = $this->get_products_detalized();
			/*
			$array_values = array();
			if($_POST["products_indexes"] != "")
			{
				$products_selected = explode( "," , $_POST["products_indexes"] );
				for($i=0;$i<count($products_selected);$i++)
				{
					array_push($array_values, $this->object_for_product_by_id( $products_selected[$i], $i+1 ));
				}
			}
			//Shiping price object
			array_push($array_values, $this->object_for_product_by_id( "-666", count($array_values)+1 ));
			 * */
			
			$this->create_csv_from_variables_values($this->variables, $array_values, 
						SETTINGS::ORDERS_FOLDER."/simply_csv/simply_".$_POST["orderNumber"].".csv");
		}
		private function object_for_product_by_id($product_id, $line_number)
		{
			$row_product = DB_DETAILS::ADD_ACTION("
				SELECT * FROM products WHERE id=".$product_id."
			", DB_DETAILS::$TYPE_SELECT);
			/////////////////////////////////////////////////////////////////////////////
			/////////////////////////////////////////////////////////////////////////////
			/////////////////////////////////////////////////////////////////////////////
			////Load the file that hold Product class
			/////////////////////////////////////////////////////////////////////////////
			if(!class_exists("Product")){require_once("products_moderator.php");}
			/////////////////////////////////////////////////////////////////////////////
			/////////////////////////////////////////////////////////////////////////////
			/////////////////////////////////////////////////////////////////////////////
			/////////////////////////////////////////////////////////////////////////////
			/////////////////////////////////////////////////////////////////////////////
			if($product_id == "-666")
			{
				$product = new Product( "-666" );
			}
			else
			{
				$product = new Product( $row_product[0] );
			}
			$invoice_date_format = "d-M-Y";
			$invoice_date = date($invoice_date_format);
			if($_POST["invoice_update_date"] != "")
			{
				$invoice_date = date($invoice_date_format, /*24*60*60+*/$_POST["invoice_update_date"]/1000);
			}
			return array("Invoice_number"=>$_POST["orderNumber"], "UDF_1"=>"", "Customer_Code"=>$_POST["invoice_additiona_customer_code"], 
				"Invoice_Date"=>$invoice_date,"Order_number"=>$_POST["orderNumber"], "ship_date"=>"", 
				"Sales_person"=>$_POST["sales_person_code"], 
				"WHS_Location"=>"", "Currency"=>"CAD", "Customer_name"=>$_POST["companyName_TYPE_BILLING"], 
				"Contact_name"=>$_POST["contactName_TYPE_BILLING"], 
				"Address1"=>$_POST["address_1_TYPE_BILLING"],"Address2"=>$_POST["address_2_TYPE_BILLING"],
				"city"=>$_POST["city_TYPE_BILLING"], "Province"=>$_POST["province_TYPE_BILLING"], "Country"=>"", 
				"PostCode"=>$_POST["postalCode_TYPE_BILLING"], "email"=>$_POST["email_TYPE_BILLING"], 
				"Phone1"=>$_POST["phone_TYPE_BILLING"], "Phone2"=>$_POST["CIPhone"], "Fax2"=>"", "website"=>"",
				"Shipto_Name"=>$_POST["companyName_TYPE_SHIPING"], "Shipto_contact"=>$_POST["contactName_TYPE_SHIPING"], 
				"ship_address1"=>$_POST["address_1_TYPE_SHIPING"], "ship_address2"=>$_POST["address_2_TYPE_SHIPING"], 
				"ship_city"=>$_POST["city_TYPE_SHIPING"], "ship_province"=>$_POST["province_TYPE_SHIPING"], 
				"ship_zip"=>$_POST["postalCode_TYPE_SHIPING"], "ship_country"=>"", 
				"ship_phone"=>$_POST["phone_TYPE_SHIPING"], "ship_phone_2"=>$_POST["CIPhone"], "ship_fax"=>"", 
				"ship_email"=>$_POST["email_TYPE_SHIPING"], 
				"Net_Days"=>"", "Net_disc_percent"=>"", "net_disc_days"=>"", "invoice_comment"=>"", "Header_GL_Account"=>"", 
				"Payment_method"=>$_POST["mopINPUT"], "CC_name"=>$_POST["MOP_cardNum"], "payment_text"=>"", "record_type"=>"", "shipper"=>"", "tracking_number"=>"", 
				"add_info1"=>"", "add_Date"=>"", "line_number"=>$line_number, "item_code"=>"".$product->code->code."", "item_description"=>$product->description(), "UOM"=>"each", 
				"qty_ordered"=>$product->total_quantity(), "qty_shipped"=>"", "qty_bo"=>"", 
				"base_price"=>"", "line_disc_percent"=>"", "unit_price"=>"", 
				"amount"=>$product->invoice_amount(), "tax_code"=>$_POST["province_TYPE_SHIPING"],  
				"Detail_GL_account"=>"4200", "Department"=>"", "Project"=>"", "Freight_Line"=>"" );
		}
		public static function CREATE_INVOICE_FOR_ADDITIONAL_PRODUCTS()
		{
			$invoice = new CreateInvoice_for_additionalProductsCSV();
			$invoice->create_csv();
			/*
			 * InvoicePDFList is creating pdf
			 * the file for this is pdf_cheque_templates/invoice_pdf_list.php
			 * */
			$invoice_pdf_list = new InvoicePDFList();
			$invoice_pdf_list->saveToLocal_into_invoices_folder();
			/*
			 * public function SendEMail( $objCheque__=NULL , $sendEmailYes__=NULL)
			 * I create there a function for sending mail with this invoice.
			 * The variables must be null, null, in another case this class will do another acctions
			 * */
			$SEND_TO_MAIL = new SendEMail(null, null);
			$SEND_TO_MAIL->SEND_INVOICE_EMAIL( $invoice_pdf_list );
		}
	}
	
	class Create_Receipt__forAdditionalProductsCSV extends  CSVBase
	{
		const TYPE = "TYPE_RECEIPT";
		
		public $variables = array("Company_Name", "Invoice_Number", "Receipt_Number", "Commnets", 
		"Payment_Text", "Payment_Amount", "Payment_Date", "Payment_Method", "Account");
		
		public function Create_Receipt__forAdditionalProductsCSV()
		{
		}
		
		public function create_csv()
		{
			$account = "";
			switch($_POST["mopINPUT"])
			{
				case "Direct Debit":
				{
					$account = "1075";
				}break;
				case "Visa":
				{
					$account = "1080";
				}break;
				case "Mastercard":
				{
					$account = "1083";
				}break;
				case "Cash":
				{
					$account = "1060";
				}break;
				case "Cheque":
				{
					$account = "1060";
				}break;
			}
			$array_values = array(
			
			array(
				"Company_Name"=>$_POST["companyName_TYPE_BILLING"], 
				"Invoice_Number"=>$_POST["orderNumber"], 
				"Receipt_Number"=>$_POST["receipt_number"], 
				//"Commnets"=>$_POST["receipt_comments"], 
				//invoice_additiona_customer_code
				"Commnets"=>$_POST["invoice_additiona_customer_code"], 
				"Payment_Text"=>$_POST["receipt_amount"], 
				"Payment_Amount"=>$_POST["grand_total_INPUT"], 
				"Payment_Date"=>$_POST["receipt_date"], 
				"Payment_Method"=>$_POST["receipt_method_of_payment"], 
				"Account"=>$account
				)
			
			);
			$this->create_csv_from_variables_values($this->variables, $array_values, 
						SETTINGS::ORDERS_FOLDER."/simply_csv/receipts/receipt_".$_POST["orderNumber"].".csv");
		}
		
		
		private function get_products_detalized()
		{
		}
		
		private function object_for_product_by_id($product_id, $line_number)
		{
		}
		
		public static function CREATE_RECEIPT_FOR_ADDITIONAL_PRODUCT()
		{
			$receipt = new Create_Receipt__forAdditionalProductsCSV();
			$receipt->create_csv();
		}
	}
	class AIRMILES_CSV extends CSVBase
	{
		/*
		 * ,,,,,,
		 * */
		public $variables = array("Offer", "Award Date", "Collector Number", "Miles", 
		"First Name", "Last Name", "Location Name");
		public $values;
		
		public function AIRMILES_CSV()
		{
			$miles = round($_POST["sub_total_products_INPUT"]/25);
			$this->values = array(
				"0"=>
				array
				(
				"Offer"=>"AE420001",
				"Award Date"=>date("d/m/Y"),
				"Collector Number"=>$_POST["AIRMILES_cardNumber"],
				"Miles"=>$miles,
				"First Name"=>$_POST["CIContactName"],
				"Last Name"=>"Last Name",
				"Location Name"=>"Print & Cheques Now"
				)
			);
			$this->source = $this->get_source_from_header_values($this->variables, $this->values);
			//print $this->source;
		}
		/*
		 * We also need to create a csv file for airmiles.csv  that saves on the server..
		so that every new order that has an airmiles # in this field, it adds a new line
		to the same csv file
		so a single file contains a master list of all orders that had airmiles
		That means there should be a master airmiles.csv file on server, every time
		an order with Airmiles rewards is submitted it will add a new line in that file.
		There will be a file for every month. So for example
		/orders/AIRMILES/january13_airmiles.csv
		 * */
		public function update_master_airmiles_field($additional_folder_path="")
		{
			if(!isset($_POST["AIRMILES_cardNumber"]))
			{
				return;
			}
			$file_name = strtolower(date("F")).".csv";
			$folder_airmiles = $additional_folder_path.SETTINGS::ORDERS_FOLDER."airmiles/".date("Y")."/";
			HELPWordpress::CREATE_0777_DIR_IF_NOT_EXIST( $folder_airmiles );
			$this->see_if_exist_master_field_and_setup($folder_airmiles.$file_name);
			$this->update_csv_file
			(
				"\n".$this->getValuesRowForVariablesAndValuesByName($this->variables,$this->values[0]),//new row
				$folder_airmiles.$file_name//file path
			);
		}
		private function see_if_exist_master_field_and_setup($master_field_url)
		{
			if(file_exists($master_field_url))
			{
				return;
			}
			$source_temp_header = $this->getHeaderFromVariables($this->variables);
			$this->create_csv_file($source_temp_header, $master_field_url);
		}
	}
	/*
	 * Just for testing
	 * 
	if(!class_exists("HELPWordpress")){require_once("help.php");}
	if(!class_exists("SETTINGS")){require_once("../settings.php");} 
	$airmiles = new AIRMILES_CSV();
	$airmiles->update_master_airmiles_field("../");
	//$date = date("Y");
	//$date = date("F");
	//print $date;
	 * */

?>