<?php
class DB_DETAILS
{
	public static $db_conn;
	
	public static $TYPE_ACTION="TYPE_ACTION";
	public static $TYPE_SELECT="TYPE_SELECT";
	
	static function setConnection()
	{
		DB_DETAILS::$db_conn = mysql_connect(SETTINGS::db_server, 
											 SETTINGS::db_user, 
											 SETTINGS::db_pass, false, 65536);
		mysql_select_db(SETTINGS::db_name);
	}
	static function closeConnection()
	{
		mysql_close( DB_DETAILS::$db_conn );
	}
	public static function ADD_ACTION($SQLQuery="", $type="TYPE_ACTION", $setConnection=true)
	{
		if($setConnection == true)
		{
			DB_DETAILS::setConnection();
		}
		mysql_set_charset('utf8');
		$results = mysql_query($SQLQuery);
		
		$theArrayForReturn = array();
		if($setConnection == true)
		{
			DB_DETAILS::closeConnection();
		}
		if($type == DB_DETAILS::$TYPE_SELECT)
		{
			if($results)
			{
				while($row = mysql_fetch_array($results))
				array_push($theArrayForReturn, $row );
			} 	
		}
		return $theArrayForReturn;
	}
	public static function GET_LAST_ITEM($table, $id)
	{
		$results = DB_DETAILS::ADD_ACTION("SELECT * FROM ".$table." ORDER BY ".$id." DESC LIMIT 1", DB_DETAILS::$TYPE_SELECT);
		return $results[0];
	}
	public static $VARs;
	public static function PRINT_VARS()
	{
		http_build_query( self::$VARs );
	}
}

?>