<?php

	
	class HELPWordpress
	{
		/*
		Page details:
		http://codex.wordpress.org/Function_Reference/get_page
		*/
		/*
		bloginfo
		name                 = Testpilot
		description          = Just another WordPress blog
		admin_email          = admin@example
		
		url                  = http://example/home
		wpurl                = http://example/home/wp
		
		stylesheet_directory = http://example/home/wp/wp-content/themes/child-theme
		stylesheet_url       = http://example/home/wp/wp-content/themes/child-theme/style.css
		template_directory   = http://example/home/wp/wp-content/themes/parent-theme
		template_url         = http://example/home/wp/wp-content/themes/parent-theme
		
		atom_url             = http://example/home/feed/atom
		rss2_url             = http://example/home/feed
		rss_url              = http://example/home/feed/rss
		pingback_url         = http://example/home/wp/xmlrpc.php
		rdf_url              = http://example/home/feed/rdf
		
		comments_atom_url    = http://example/home/comments/feed/atom
		comments_rss2_url    = http://example/home/comments/feed
		
		charset              = UTF-8
		html_type            = text/html
		language             = en-US
		text_direction       = ltr
		version              = 3.1
		*/
		public static function template_url()
		{
			$template_url = bloginfo("template_url");
			return $template_url;
		}
		public static function url(){return bloginfo("url");}
		
		public function HELPWordpress()
		{
		}
		///////////////////////////////////////////////////////
		static $ALL_COUNTRIES=NULL;
		public static function ALL_COUNTRIES_GET()
		{
			if(HELPWordpress::$ALL_COUNTRIES == NULL)
			{
				HELPWordpress::$ALL_COUNTRIES = DB_DETAILS::ADD_ACTION("SELECT * FROM countries", DB_DETAILS::$TYPE_SELECT);
			}
			return HELPWordpress::$ALL_COUNTRIES;
		}
		public static function ALL_COUNTRIES_OPTIONS_ADD()
		{
			$allCountries = HELPWordpress::ALL_COUNTRIES_GET();
			for($i=0;$i<count($allCountries);$i++)
			{
				print '
						<option value="'.$allCountries[$i]["countries_name"].'">'.$allCountries[$i]["countries_name"].'</option>
					';
			}
		}
		
		static $ALL_CANADA_PROVINCIES=NULL;
		public static function GET_ALL_CANADA_PROVINCIES()
		{
			if(self::$ALL_CANADA_PROVINCIES==NULL)
			{
				self::$ALL_CANADA_PROVINCIES = DB_DETAILS::ADD_ACTION("SELECT * FROM canada_provincies ORDER BY abv", DB_DETAILS::$TYPE_SELECT);
			}
			return self::$ALL_CANADA_PROVINCIES;
		}
		public static function PRIN_ALL_CANADA_PROVINCIES_OPTIONS()
		{
			$allProvincies = self::GET_ALL_CANADA_PROVINCIES();
			for($i=0;$i<count($allProvincies);$i++)
			{
				print '
						<option value="'.$allProvincies[$i]["abv"].'">'.$allProvincies[$i]["abv"].'</option>
					';
			}
		}
		
		static $ALL_USA_STATES=NULL;
		public static function GET_ALL_USA_STATES()
		{
			if(self::$ALL_USA_STATES==NULL)
			{
				self::$ALL_USA_STATES = DB_DETAILS::ADD_ACTION("SELECT * FROM usa_states ORDER BY state_code", DB_DETAILS::$TYPE_SELECT);
			}
			return self::$ALL_USA_STATES;
		}
		public static function PRIN_ALL_USA_STATES_OPTIONS()
		{
			$allStates = self::GET_ALL_USA_STATES();
			for($i=0;$i<count($allStates);$i++)
			{
				print '
						<option value="'.$allStates[$i]["state_code"].'">'.$allStates[$i]["state_code"].'</option>
					';
			}
		}
		
		const UPPER_LETTERS = "ABCDEFGHIKLMNOPQRSTVXYZ";
		//const UPPER_LETTERS = "ABCD";
		public static function delete_directory($dirname) 
		{
		   if (is_dir($dirname))
			  $dir_handle = opendir($dirname);
		   if (!$dir_handle)
			  return false;
		   while($file = readdir($dir_handle)) {
			  if ($file != "." && $file != "..") {
				 if (!is_dir($dirname."/".$file))
					unlink($dirname."/".$file);
				 else
					self::delete_directory($dirname.'/'.$file);    
			  }
		   }
		   closedir($dir_handle);
		   rmdir($dirname);
		   return true;
		}
		public static function CREATE_0777_DIR_IF_NOT_EXIST($dir_name)
		{
			if(!is_dir($dir_name))
			{
				$oldmask = umask(0);
				mkdir( $dir_name, 0777 );
				umask($oldmask);
			}
		}
		
		public static function ALL_GET_TO_POST()
		{
			foreach($_GET as $variableVAL=>$variable)
			{
				$_POST[$variableVAL] = stripslashes($_GET[$variableVAL]);
				//print "[".htmlentities($_POST[$variableVAL] , ENT_QUOTES, "UTF-8")."]<br>";
				
				/*
				 * Ovaa funkcija gi pecati za html ubavo, ama vo fpdf ne raboti dobro
				 * */
				//$_POST[$variableVAL] = htmlentities($_POST[$variableVAL] , ENT_QUOTES, "UTF-8");
				
				 /* 
				 * Raboti na html a isto i na pdfto gi pecati ubavo.
				 * */
				//print "[pred]".$_POST[$variableVAL]."[pred]<br/>";
				$_POST[$variableVAL] = iconv("UTF-8", "ISO-8859-1", $_POST[$variableVAL]);
				//print "[posle]".$_POST[$variableVAL]."[posle]<br/>";
				//print "[".$_POST[$variableVAL]."][-]<br>";
			}
		}
	}

?>