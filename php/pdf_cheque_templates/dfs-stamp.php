<?php 
	
	class DFSStamp
	{
		var $pdf;
		var $fileName = "dfs_stamp.pdf";
		var $outPutTOSErver = NULL;
		var $border = 0;
		var $before_testing_folder = "";
		
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
		
		public function DFSStamp( $type, $chequeData , $before_testing_folder="")
		{
			$this->before_testing_folder = $before_testing_folder;
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
			$this->pdf->AddFont("helvetica", "", $this->before_testing_folder."../fonts/helvetica/fpdf/25e75292757c3eb4bba8a3ddd4e8fe3f_helvetica_lt.php");
			$this->pdf->SetDisplayMode(real,'default');
			$this->pdf->SetAutoPageBreak(false);
			$this->pdf->AddPage();
			
			$this->Draw();
		}
		public function Draw()
		{
			$this->pdf->SetFont("helvetica", "", 10);
			$theText = "Deposit to the Credit of\n".$this->chequeData->CINACompanyName();
			$liniiTotal = 3.5;
			/**/
			if($this->chequeData->CINACompanySecondName() != "")
			{
				//print "[THERE IS SECOND NAME]";
				$theText .= "\n".$this->chequeData->CINACompanySecondName();
				$liniiTotal++;
			}
			
			$theText .= "\nTR # ".$this->chequeData->brunchNumber()."-".$this->chequeData->transitNumber()."  A/C # ".$this->chequeData->accountNumber();
			$linijaVisina = 3.5;
			$visina = $liniiTotal*$linijaVisina;
			$this->pdf->SetXY(300,($this->height-$visina)/2);
			$totalLinii = $this->pdf->MultiCell($this->width,$linijaVisina,$theText,$this->border,"C");
			$visina = $totalLinii*$linijaVisina;
			if($visina > $this->height){$visina = $this->height;}
			$linijaVisina = $visina/$totalLinii;
			$new_y_position = ($this->height-$visina)/2;
			//$new_y_position = 0;
			//print "{totalLinii:[".$totalLinii."], new_y_position:[".$new_y_position."]}";
			$this->pdf->SetXY(0,$new_y_position);
			$totalLinii = $this->pdf->MultiCell($this->width,$linijaVisina,$theText,$this->border,"C");
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
	if(!class_exists("XMLParser")){require_once("../tools.php");}
	if(!class_exists("Product")){require_once("../products_moderator.php");}
	require_once("../pdf-tools/fpdf.php");
	require_once("../pdf-tools/pdf-helper.php");
	XMLParser::ADD_ORDER_XML_TO_POST( "../orders/xml/T_L5862.xml" );
	$objCheque = new Cheque( $_POST["chequeType"] );
	$objChequeData = new ChequeData( $objCheque );
	$objOrderForm = new DFSStamp( DFSStamp::BCT, $objChequeData, "../" );
	$objOrderForm->saveToLocal( "test" );
	 */
	

?>