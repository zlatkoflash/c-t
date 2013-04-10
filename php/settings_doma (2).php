<?php

	class SETTINGS
	{
		//database 
		/*TEST KAJ MAMA*/
		const db_server="localhost";
		const db_name="cheque_wp";
		const db_user="";
		const db_pass="";
		/*TEST KAJ SLAVICA I JAS
		const db_server="localhost";
		const db_name="wordpress";
		const db_user="zlatkoflash";
		const db_pass="zlatkoflash";
		 * */
		
		/*TEST site
		const db_server="che1204503221289.db.6023255.hostedresource.com";
		const db_name=  "che1204503221289";
		const db_user="che1204503221289";
		const db_pass="Cheques1";
		*/
		/**/
		/*LIVE site
		const db_server="che1010705003791.db.6023255.hostedresource.com";
		const db_name=  "che1010705003791";
		const db_user="che1010705003791";
		const db_pass="Prastish12453";
		*/
		/*174.120.175.22
		const db_server="localhost";
		const db_name=  "chequesn_fewp";
		const db_user="chequesn_mnusrac";
		const db_pass="?1k+IX8HVHL1";
		*/
		/*https://chequesnow.ca/test/ test
		const db_server="localhost";
		const db_name=  "chequesn_test";
		const db_user="chequesn_mnusrac";
		const db_pass="?1k+IX8HVHL1";*/
		
		const AJAX_URL_TO_PHP_TOOLS_FOLDER = "wp-content/themes/c-t/php/";//for localhost
		//const AJAX_URL_TO_PHP_TOOLS_FOLDER = "../wp-content/themes/c-t/php/";//for online
		
		////////////////////////////////////////////////////
		//const URL_TO_CHECKOUT_PAGE="http://localhost/muhamed/cheque-wp/?page_id=82";//kaj slavica
		//const URL_TO_CHECKOUT_PAGE="http://chequesnow.ca/test/checkout/";
		const URL_TO_CHECKOUT_PAGE="http://localhost/muhamed/cheque-wp/?page_id=13";//doma
		
		const URL_TO_THANK_U="http://localhost/muhamed/cheque-wp/?page_id=16";//kaj slavica i jas
		
		//const URL_TO_THANK_U="http://174.120.175.22/cheques/thankyou/";
		//const URL_TO_THANK_U="https://chequesnow.ca/cheques/thankyou/";
		
		//const URL_TO_THANK_U="http://174.120.175.22/test/thankyou/";
		//const URL_TO_THANK_U="https://chequesnow.ca/test/thankyou/";
		
		//const URL_TO_TRANSACTION_STATUS_PAGE="http://localhost/muhamed/cheque-wp/?page_id=86";
		//const URL_TO_TRANSACTION_STATUS_PAGE="http://chequesnow.ca/cheques/trstat/";
		const URL_TO_TRANSACTION_STATUS_PAGE="http://chequesnow.ca/test/trstat/";
		
		const URL_TO_ADMIN_PAGE="http://localhost/muhamed/cheque-wp/?page_id=88";//doma
		//const URL_TO_ADMIN_PAGE="http://localhost/muhamed/cheque-wp/?page_id=22";//slavica
		
		//const URL_TO_ADMIN_PAGE="http://174.120.175.22/cheques/admin/";
		//const URL_TO_ADMIN_PAGE="https://chequesnow.ca/cheques/admin/";
		
		//const URL_TO_ADMIN_PAGE="http://174.120.175.22/test/admin/";
		//const URL_TO_ADMIN_PAGE="https://chequesnow.ca/test/admin/";
		/*
			Set of pages after doing the transaction with BeanStream.
		*/
		/**/
		const BEANSTREAM_ERROR_PAGE = "http://localhost/muhamed/cheque-wp/wp-content/themes/c-t/php/tools-payment.php";
		const BEANSTREAM_APROVED_PAGE = "http://localhost/muhamed/cheque-wp/wp-content/themes/c-t/php/tools-payment.php";
		const BEANSTREAM_DECLINED_PAGE = "http://localhost/muhamed/cheque-wp/wp-content/themes/c-t/php/tools-payment.php";
		/*
		const BEANSTREAM_ERROR_PAGE = "http://www.chequesnow.ca/test/wp-content/themes/c-t/php/tools-payment.php";
		const BEANSTREAM_APROVED_PAGE = "http://www.chequesnow.ca/test/wp-content/themes/c-t/php/tools-payment.php";
		const BEANSTREAM_DECLINED_PAGE = "http://www.chequesnow.ca/test/wp-content/themes/c-t/php/tools-payment.php";
		*/
		/*For online
		const WEBSITE_TO_ORDERS_ORDERS_FOLDER_PATH = "Need settings here";
		const ORDERS_LASER_URL  = "../../../../../orders/laser_orders/";
		const ORDERS_MANUAL_URL = "../../../../../orders/manual_orders/";
		const ORDERS_FOLDER_FOR_CSV = "../../../../../orders/csv_files/";
		const ORDERS_FOLDER_FOR_XML = "../../../../../orders/xml/";
		const ORDERS_FOLDER_FOR_XML___ADMIN_SECTION = "../orders/xml/";
		const ORDERS_FOLDER_FOR_Debit_Files = "../../../../../orders/debit_files/";
		*/
		/*For testing*/
		const WEBSITE_TO_ORDERS_ORDERS_FOLDER_PATH = "./wp-content/themes/c-t/php/orders/";
		const ORDERS_FOLDER = "orders/";
		const ORDERS_LASER_URL  = "orders/laser_orders/";
		const ORDERS_MANUAL_URL = "orders/manual_orders/";
		const ORDERS_FOLDER_FOR_CSV = "orders/csv_files/";
		const ORDERS_FOLDER_FOR_XML = "orders/xml/";
		const ORDERS_FOLDER_FOR_XML___ADMIN_SECTION = "./wp-content/themes/c-t/php/orders/xml/";
		const ORDERS_FOLDER_FOR_Debit_Files = "orders/debit_files/";
		
		const ORDER_SAVING_PLUS_LABEL="T_";//for testing
		//const ORDER_SAVING_PLUS_LABEL="";//for normal
		
		const FOLDER_FOR_COMPLETED_ORDERS = "completed_orders/";
		
		private static function COMPLETED_ORDERS_FOLDER_NAME()
		{
			if($GLOBALS["WHEN_UPDATING_CHEQUE_IS_NEW"] == true)
			{
				return "";
			}
			return self::FOLDER_FOR_COMPLETED_ORDERS;
		}
		
		public static function ORDERS______URL_BY_CHEQUE()
		{
			if(Cheque::$cheque->type == Cheque::TYPE_LASER)
			{
				return self::ORDERS_LASER_URL;
			}
			else if(Cheque::$cheque->type == Cheque::TYPE_MANUAL)
			{
				return self::ORDERS_MANUAL_URL;
			}
			else
			{
				return "This case should not be done, because of that we have just laser and manual cheques.";
			}
		}
		
		public static function ORDERS______URL()
		{
			return self::ORDERS______URL_BY_CHEQUE().self::COMPLETED_ORDERS_FOLDER_NAME();
		}
	}
?>