<?php

	////////////////////////////////////////////////////////////////////////////////////
	////////////////////////////////////////////////////////////////////////////////////
	////////////////////////////////////////////////////////////////////////////////////
	////////////////////////////////////////////////////////////////////////////////////
	////////////////////////////////////////////////////////////////////////////////////
	////////////////////////////////////////////////////////////////////////////////////
	////////////////////////////////////////////////////////////////////////////////////
	class SearchTool
	{
		public static function SEARCH_ORDERS_PLEASE()
		{
			//print_r($_POST);
			$resultsSearch = "SELECT COUNT(*) AS TOTAL_COUNT FROM orders_details 
								 ".self::SELECT_AND_CLAUSULE()." 
								".self::ORDER_BY_CLAUSULE();
			$resultsSearch = DB_DETAILS::ADD_ACTION($resultsSearch, DB_DETAILS::$TYPE_SELECT);
			$countPages = $resultsSearch[0]["TOTAL_COUNT"]/$_POST["rowsMaxCount"];
			$countPagesROUND = round( $countPages );
			if($countPagesROUND < $countPages)
			{
				$countPagesROUND ++;
			}
			$resultsSearch = "SELECT * FROM orders_details 
								 ".self::SELECT_AND_CLAUSULE()." 
								".self::ORDER_BY_CLAUSULE().""
								.self::LIMIT_CLAUSULE();
			$SQLForSearching = $resultsSearch;
			$resultsSearch = DB_DETAILS::ADD_ACTION($resultsSearch, DB_DETAILS::$TYPE_SELECT);
			/*
			print_r( $_POST );
			print "[".$resultsSearch."]";*/
			
			//print_r($resultsSearch[0]);
			/*
			print "[[[[[";
			print_r($resultsSearch);
			print "]]]]]";
			*/
			$xmlSource = "<source>";
			$xmlSource .= "<usedSQL><![CDATA[".$SQLForSearching."]]></usedSQL>";
			if(count($resultsSearch) > 0)
			{
				$xmlSource .= "<orders>";
				for($i=0;$i<count($resultsSearch);$i++)
				{
					$xmlSource .= "<order>".self::get_XML_variables_and_Values($resultsSearch[$i])."</order>";
				}
				$xmlSource .= "</orders>";
			}
			$xmlSource .= "<countPages>".$countPagesROUND."</countPages>";
			$xmlSource .= "</source>";
			print $xmlSource;
		}
		private static function SELECT_AND_CLAUSULE()
		{
			$brojac = 0;
			$AND_CLAUSULE = "";
			
			if(isset($_POST["SEARCH_ORDERS_PLEASE_BY_UNIVERSAL"]))
			{
				for($i=0;$i<count(OrdersDatabase::$arr_variables);$i++)
				{
						if($brojac > 0)
						{
							$AND_CLAUSULE .= " OR ";
						}
						$AND_CLAUSULE .= OrdersDatabase::$arr_variables[$i]." LIKE '%".$_POST["SEARCH_ORDERS_PLEASE_BY_UNIVERSAL"]."%'";
						$brojac++;
				}
			}
			else if(isset($_POST["SEARCH_BY_DATE"]))
			{
				$AND_CLAUSULE = " date_modify>=".$_POST["FROM_DATE"]." AND date_modify<=".$_POST["TO_DATE"]." ";
			}
			else if(isset($_POST["SEARCH_BY_ORDER_TOTAL_AMOUNT"]))
			{
				$arrayAndForTotal = array();
				$clausule = "";
				if($_POST["shippingAmountSearchInput"] != "")
				{
					$clausule = "shipping_price_INPUT=".$_POST["shippingAmountSearchInput"];
					array_push( $arrayAndForTotal, $clausule );
				}
				if($_POST["taxesAmountSearchInput"] != "")
				{
					$clausule = "sub_total_taxes_INPUT=".$_POST["taxesAmountSearchInput"];
					array_push( $arrayAndForTotal, $clausule );
				}
				if($_POST["grandTotalSearchInputFrom"] != "" && $_POST["grandTotalSearchInputTo"] != "")
				{
					$clausule = "(grand_total_INPUT>=".$_POST["grandTotalSearchInputFrom"]." AND grand_total_INPUT<=".$_POST["grandTotalSearchInputTo"].")";
					array_push( $arrayAndForTotal, $clausule );
				}
				for($i=0;$i<count($arrayAndForTotal);$i++)
				{
					if($i > 0)
					{
						$AND_CLAUSULE .= " AND ";
					}
					$AND_CLAUSULE .= $arrayAndForTotal[$i];
				}
			}
			else
			{
				for($i=0;$i<count(OrdersDatabase::$arr_variables);$i++)
				{
					if(isset($_POST[OrdersDatabase::$arr_variables[$i]]) && $_POST[OrdersDatabase::$arr_variables[$i]] != ""
					&& OrdersDatabase::$arr_variables[$i] != "chequeType")
					{
						if($brojac > 0)
						{
							$AND_CLAUSULE .= " AND ";
						}
						$AND_CLAUSULE .= OrdersDatabase::$arr_variables[$i]." LIKE '%".$_POST[OrdersDatabase::$arr_variables[$i]]."%'";
						$brojac++;
					}
				}
			}
			if($AND_CLAUSULE == ""){return "";}
			return " WHERE ".$AND_CLAUSULE;
		}
		private static function ORDER_BY_CLAUSULE()
		{
			if(isset($_POST["order_by"]))
			{
				return " ORDER BY ".$_POST["order_by"]." ".$_POST["order_type"]." ";
			}
			return "ORDER BY orderNumber";
		}
		private static function LIMIT_CLAUSULE()
		{
			$start = $_POST["currentPage"]*$_POST["rowsMaxCount"];
			$endLimit = $start+$_POST["rowsMaxCount"];
			return " LIMIT ".$start.", ".$_POST["rowsMaxCount"]." ";
		}
		
		private static function get_XML_variables_and_Values($row)
		{
			//print $row;
			$xmlSource = "";
			for($i=0;$i<count(OrdersDatabase::$arr_variables);$i++)
			{
				$xmlSource .= "<".OrdersDatabase::$arr_variables[$i]."><![CDATA[".$row[OrdersDatabase::$arr_variables[$i]]."]]></".OrdersDatabase::$arr_variables[$i].">";
			}
			return $xmlSource;
		}
		public static function ALL_VARIABLES_FOR_JAVASCRIPT()
		{
			$ALL_VARIABLES = "";
			for($i=0;$i<count(OrdersDatabase::$arr_variables);$i++)
			{
				if($i > 0)
				{
					$ALL_VARIABLES .= ",";
				}
				$ALL_VARIABLES .= '"'.OrdersDatabase::$arr_variables[$i].'"';
			}
			return $ALL_VARIABLES;
		}
	}

?>