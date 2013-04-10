<?php 
	
	class DFSStamp
	{
		var $pdf;
		var $fileName = "dfs_stamp.pdf";
		var $outPutTOSErver = NULL;
		var $border = 0;
		
		const DFS="DFS";
		const BCT="BCT";
		
		private $height;
		private $width;
		
		private $type="";
		public function myName( $extraPartForTheName="" )
		{
			return $this->type."-stamp".$extraPartForTheName;
		}
		public function myFileName()
		{
			return $this->myName("").".pdf";
		}
		private $chequeData;
		
		public function DFSStamp( $type, $chequeData )
		{
			$this->chequeData = $chequeData;
			$this->type = $type;
			if($this->type==self::BCT)
			{
				$this->height = 17.399;
				$this->width = 53.975;
			}
			else if($this->type==self::DFS)
			{
				$this->height = 17.399;
				$this->width = 73.025;
			}
			$this->pdf=new FPDF('P','mm',array($this->width, $this->height));
			$this->pdf->AddFont("helvetica", "", "../fonts/helvetica/fpdf/25e75292757c3eb4bba8a3ddd4e8fe3f_helvetica_lt.php");
			$this->pdf->SetDisplayMode(real,'default');
			$this->pdf->SetAutoPageBreak(false);
			$this->pdf->AddPage();
			
			$this->Draw();
		}
		public function Draw()
		{
			$this->pdf->SetFont("helvetica", "", 10);
			$theText = "Deposit to the Credit of\n".$this->chequeData->CINACompanyName();
			$liniiTotal = 3;
			/**/
			if($this->chequeData->CINACompanySecondName() != "")
			{
				$theText .= "\n".$this->chequeData->CINACompanySecondName();
				$liniiTotal++;
			}
			
			$theText .= "\nTR # ".$this->chequeData->brunchNumber()."-".$this->chequeData->transitNumber()."  A/C # ".$this->chequeData->accountNumber();
			$linijaVisina = 4;
			$visina = $liniiTotal*$linijaVisina;
			$this->pdf->SetXY(0,($this->height-$visina)/2);
			$this->pdf->MultiCell($this->width,$linijaVisina,$theText,$this->border,"C");
			$visina *= $linijaVisina;
		}
		public function PDFContent()
		{
			if($this->outPutTOSErver == NULL)
			$this->outPutTOSErver = $this->pdf->Output($this->myFileName(), "S");
			return $this->outPutTOSErver;
		}
		public function saveToLocal( $extraPartForTheName="" )
		{
			$this->pdf->Output($this->myName( $extraPartForTheName ).".pdf", "");
		}
	}
	/* 	
	if(!class_exists("XMLParser")){require_once("tools.php");}
	require_once('Mail.php');
	require_once('Mail/mime.php');
	require_once("pdf-tools/fpdf.php");
	require_once("pdf-tools/pdf-helper.php");
	require_once("mail_message_template.php");
	require_once("backupmessage.php");
	XMLParser::ADD_ORDER_XML_TO_POST( "orders/xml/T_L5792.xml" );
	$objCheque = new Cheque( $_POST["chequeType"] );
	$objChequeData = new ChequeData( $objCheque );
	$objOrderForm = new DFSStamp( DFSStamp::BCT, $objChequeData );
	$objOrderForm->saveToLocal( "test" );
	 */

?>