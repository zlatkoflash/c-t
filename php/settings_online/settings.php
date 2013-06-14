<?php

	class SETTINGS
	{
		const db_server="localhost";
		const db_name=  "chequesn_chqswp";
		const db_user="chequesn_mnusrac";
		const db_pass="?1k+IX8HVHL1";
		
		const AJAX_URL_TO_PHP_TOOLS_FOLDER = "../wp-content/themes/c-t/php/";//for online
		
		const URL_TO_CHECKOUT_PAGE="http://localhost/muhamed/cheque-wp/?page_id=13";//doma
                
		const URL_TO_THANK_U="https://chequesnow.ca/cheques/thankyou/";
		
		const URL_TO_TRANSACTION_STATUS_PAGE="http://chequesnow.ca/test/trstat/";
		
		const URL_TO_ADMIN_PAGE="https://chequesnow.ca/cheques/admin/";
                
                const URL_TO_ADMIN_PAGE_AFTER_SUBMIT_ORDER = "https://chequesnow.ca/cheques/admin-after-submit-order/";
                
                const URL_TO_REDIRECTION_FOR_CONTRIBUTERS = "https://chequesnow.ca/cheques/admin-orders-navigator/";
                        
		/*
			Set of pages after doing the transaction with BeanStream.
		*/
		/**/
		const BEANSTREAM_ERROR_PAGE = "http://localhost/muhamed/cheque-wp/wp-content/themes/c-t/php/tools-payment.php";
		const BEANSTREAM_APROVED_PAGE = "http://localhost/muhamed/cheque-wp/wp-content/themes/c-t/php/tools-payment.php";
		const BEANSTREAM_DECLINED_PAGE = "http://localhost/muhamed/cheque-wp/wp-content/themes/c-t/php/tools-payment.php";
                
		/*For online*/
		const WEBSITE_TO_ORDERS_ORDERS_FOLDER_PATH = "../../orders/";
		const ORDERS_FOLDER = "../../../../../orders/";
		const ORDERS_LASER_URL  = "../../../../../orders/laser_orders/";
		const ORDERS_MANUAL_URL = "../../../../../orders/manual_orders/";
		const ORDERS_FOLDER_FOR_CSV = "../../../../../orders/csv_files/";
		const ORDERS_FOLDER_FOR_XML = "../../../../../orders/xml/";
		const ORDERS_FOLDER_FOR_XML___ADMIN_SECTION = "../orders/xml/";
		const ORDERS_FOLDER_FOR_Debit_Files = "../../../../../orders/debit_files/";
		
		const ORDER_SAVING_PLUS_LABEL="";//for normal
		
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