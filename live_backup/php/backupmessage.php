<?php

	class BackUpMessage
	{
		var $htmlMessage;
		var $PDF;
		var $thedate;
		var $startfolder = 'messages_backup';
		var $dirthatineed = '';

		public function BackUpMessage($htmlMessage____, $PDF____)
		{
			$this->htmlMessage = $htmlMessage____;
			$this->PDF = $PDF____;
			$this->thedate = getdate();
			$this->setTheFolderIfNotExist();
			$this->saveTheHTMLMessage();
			$this->saveThePDF();
		}
		function setTheFolderIfNotExist()
		{
			$this->dirthatineed = $this->startfolder;
			if(!is_dir($this->dirthatineed))mkdir($this->dirthatineed);
			$this->dirthatineed .= '/'.$this->thedate['year'];
			if(!is_dir($this->dirthatineed))mkdir($this->dirthatineed);
			$this->dirthatineed .= '/'.$this->thedate['month'];
			if(!is_dir($this->dirthatineed))mkdir($this->dirthatineed);
			$this->dirthatineed .= '/'.$this->thedate['mday'];
			if(!is_dir($this->dirthatineed))mkdir($this->dirthatineed);
			$this->dirthatineed .= '/mail_source_'.$this->thedate['hours'].'_'.$this->thedate['minutes'].'_'.$this->thedate['seconds'];
			if(!is_dir($this->dirthatineed))mkdir($this->dirthatineed);
		}
		function saveTheHTMLMessage()
		{
			$fileobj = fopen($this->dirthatineed.'/chequehtml.html', 'w');
			fwrite($fileobj, $this->htmlMessage);
			fclose( $fileobj );
		}
		function saveThePDF()
		{
			$this->PDF->Output($this->dirthatineed.'/chequepdf.pdf', '');
		}
	}



?>