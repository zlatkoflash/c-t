<?php

	class SETTINGS
	{
		/*TEST KAJ SLAVICA I JAS* */
		const db_server="localhost";
		const db_name="muhamed_cheque_wp";
		const db_user="root";
		const db_pass="";
                
		const AJAX_URL_TO_PHP_TOOLS_FOLDER = "wp-content/themes/c-t/php/";//for localhost
		
		////////////////////////////////////////////////////
		const URL_TO_CHECKOUT_PAGE="http://localhost/muhamed/cheque-wp/?page_id=82";//kaj slavica
		
		const URL_TO_THANK_U="http://localhost/muhamed/cheque/wp_cheque_appi/thankyou/";//kaj slavica i jas
		
		const URL_TO_TRANSACTION_STATUS_PAGE="http://chequesnow.ca/test/trstat/";
		
		const URL_TO_ADMIN_PAGE="http://localhost/muhamed/cheque/wp_cheque_appi/?page_id=3";//slavica
                
                //This is url that will show the form after submit from admin.
                const URL_TO_ADMIN_PAGE_AFTER_SUBMIT_ORDER = "http://localhost/muhamed/cheque/wp_cheque_appi/admin-after-submit-order/";
		
                const URL_TO_REDIRECTION_FOR_CONTRIBUTERS = "http://localhost/muhamed/cheque/wp_cheque_appi/admin-orders-navigator/";
		/*
			Set of pages after doing the transaction with BeanStream.
		*/
		/**/
		const BEANSTREAM_ERROR_PAGE = "http://localhost/muhamed/cheque-wp/wp-content/themes/c-t/php/tools-payment.php";
		const BEANSTREAM_APROVED_PAGE = "http://localhost/muhamed/cheque-wp/wp-content/themes/c-t/php/tools-payment.php";
		const BEANSTREAM_DECLINED_PAGE = "http://localhost/muhamed/cheque-wp/wp-content/themes/c-t/php/tools-payment.php";
                
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