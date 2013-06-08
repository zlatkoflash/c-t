<?php
	
	/*
	 * I will working with wordperss users id
	 * */
	class User
	{
		public static $LOGGED_USER=NULL;
		public static function INIT()
		{
			self::$LOGGED_USER = new User();
		}
		
		const VARIABLE_SESSION_USER = "user";
                const TYPE_ADMINISTRATOR = "admin";
                const TYPE_CONTRIBUTOR = "contributor";
		
		public $ID,
			   $user_login,
			   $user_pass,
			   $user_nicename,
			   $user_email,
			   $user_url,
			   $user_registered,
			   $user_activation_key,
			   $user_status,
			   $display_name;
		public $isloged = false;
		
		public function User()
		{
			/*
			 * If session is not setted then do setup
			 * */
			if(!isset($_SESSION))
			{
				session_start();
			}
			if(!isset($_SESSION[self::VARIABLE_SESSION_USER]))
			{
				$this->isloged = false;	
			}
			else
			{
				$this->isloged = true;
				$this->ID = $_SESSION[self::VARIABLE_SESSION_USER]["ID"];
				$this->user_login = $_SESSION[self::VARIABLE_SESSION_USER]["user_login"];
				$this->user_pass = $_SESSION[self::VARIABLE_SESSION_USER]["user_pass"];
                                $this->user_nicename = $_SESSION[self::VARIABLE_SESSION_USER]["user_nicename"];
				$this->display_name = $_SESSION[self::VARIABLE_SESSION_USER]["display_name"];
			}
		}
		
		/*
		 * This function will be activated after jquery post
		 * */
		public static function TRY_TO_LOGIN()
		{
			$wp_hasher = new PasswordHash(8, TRUE);
			//print $wp_hasher->HashPassword($_POST["user_pass"]);
			$SQLActionSelectUser = "
				SELECT * FROM wp_users
				WHERE user_login='".$_POST["user_login"]."'
			";
			//print_r( $_POST );
			$user_row = DB_DETAILS::ADD_ACTION($SQLActionSelectUser, DB_DETAILS::$TYPE_SELECT);
			
			if(count($user_row) == 1)
			{
				$user_row = $user_row[0];
				if(!$wp_hasher->CheckPassword($_POST["user_pass"], $user_row["user_pass"]))
				{
					print "error_login password do not match";
					return;
				}
				session_start();
				$_SESSION[self::VARIABLE_SESSION_USER] = 
				array
				(
					"ID"=>$user_row["ID"],
					"user_login"=>$user_row["user_login"],
					"user_pass"=>$user_row["user_pass"],
					"user_nicename"=>$user_row["user_nicename"],
					"display_name"=>$user_row["display_name"]
				);
				print "login_all_right";
			}
			else
			{
				print "error_login";
			}
		}
		/*
		 * This function will be activated after jquery post
		 * */
		 public static function DO_LOGOUT()
		 {
		 	session_start();
			unset( $_SESSION[self::VARIABLE_SESSION_USER] );
			$_SESSION[self::VARIABLE_SESSION_USER] = NULL;
		 }
	}

	if(isset($_POST["TRY_TO_LOGIN"]))
	{
		User::TRY_TO_LOGIN();
	}
	else if(isset($_POST["DO_LOGOUT"]))
	{
		User::DO_LOGOUT();
	}
	
?>