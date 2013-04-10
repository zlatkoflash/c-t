<?php

	class MailBase
	{
		protected $from,
				  $to,
				  $headers,
				  $subject,
				  $mime,
				  $mailFactory;
		protected $chequeData;
		
		public function MailBase()
		{
		}
	}

?>