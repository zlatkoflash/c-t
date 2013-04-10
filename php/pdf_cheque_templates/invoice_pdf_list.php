<?php 
	
	class InvoicePDFList
	{
		var $pdf;
		/*
		 * File should be saved into orders/invoices
		 * */
		var $fileName = "[order_number]-invoice.pdf";
		var $outPutTOSErver = NULL;
		var $showBorder = 0;
		var $before_testing_folder = "";
		private $width=215.9,$height=279.4;
		
		public function myName( $extraPartForTheName="" )
		{
			/*
			 * I will pass order number with post from create invoice from admin
			 * */
			return $_POST["orderNumber"].""."-invoice".$extraPartForTheName;
		}
		public function myFileName()
		{
			return $this->myName("").".pdf";
		}
		
		public function InvoicePDFList( $before_testing_folder="")
		{
			$this->before_testing_folder = $before_testing_folder;
			$this->pdf=new FPDF('P','mm',array($this->width, $this->height));
			$this->pdf->AddFont("helvetica_bold", "", $this->before_testing_folder."../fonts/helvetica-bold/fpdf/3c41c8e6600e41512cbd6a118d2bdf41_helvetica_bold.php");
			$this->pdf->AddFont("helvetica", "", $this->before_testing_folder."../fonts/helvetica/fpdf/25e75292757c3eb4bba8a3ddd4e8fe3f_helvetica_lt.php");
			$this->pdf->SetDisplayMode(real,'default');
			$this->pdf->SetAutoPageBreak(false);
			$this->pdf->AddPage();
			
			$this->Draw();
		}
		public function Draw()
		{			
			$left = 13;
			$top = 80;
			$height_products_column = 150;	
			$left_temp = $left;
			$total_width = 0;
			$last_width = 0;
			for($i=0;$i<count($this->columns);$i++)
			{
				if($i % 2==0)
				{
					$this->pdf->SetFillColor(255,255,255);
				}
				else
				{
					$this->pdf->SetFillColor(240,240,240);
				}
				$this->pdf->Rect($left_temp, $top+10, $this->columns[$i]["width"], $height_products_column, "F");
				$left_temp += $this->columns[$i]["width"];
				$total_width += $this->columns[$i]["width"];
				$last_width = $this->columns[$i]["width"];
			}
			$this->draw_outstanding_or_paid();					
			$this->draw_header_1();
			$this->draw_header_2();
			$this->draw_table();
			//$this->draw_outstanding_or_paid();
		}
		private function draw_header_1()
		{
			//left 
			$left = 13;
			$top = 13;
			$this->pdf->SetFont("helvetica_bold", "", 14);
			$this->pdf->SetXY($left, $top);
			$this->pdf->MultiCell(100,5,
								"Print and Cheques Now Inc."
														,$this->showBorder,"L");
			$this->pdf->SetFont("helvetica_bold", "", 9);
			$this->pdf->SetXY($left, $top+4);
			$this->pdf->MultiCell(100,5,
								"FORMERLY CHEQUES DIRECT LTD."
														,$this->showBorder,"L");
			$this->pdf->SetFont("helvetica_bold", "", 9);
			$this->pdf->SetXY($left, $top+8);
			$this->pdf->MultiCell(100,3,
								"4319 - 54 Ave. S.E., Calgary, AB T2C 2A2\nPh: 1-866-760-2661  Fx: 1-877-760-2435"
														,$this->showBorder,"L");
			//////////////////////
			//right
			$left = 134;
			$this->pdf->SetFont("helvetica_bold", "", 14);
			$this->pdf->SetXY($left, $top);
			$this->pdf->MultiCell(40,5,
								"INVOICE"
														,$this->showBorder,"L");
			$this->pdf->SetFont("helvetica", "", 8);
			$this->pdf->SetXY($left, $top+10);
			$this->pdf->MultiCell(30,5,
								"Invoice No.:\nDate:"
														,$this->showBorder,"L");
			$this->pdf->SetXY($left+30, $top+10);
			$this->pdf->MultiCell(40,5,
								$_POST["orderNumber"]."\n".
								//date("M d, Y")
								date("M d, Y", /*24*60*60+*/$_POST["invoice_update_date"]/1000)
														,$this->showBorder,"L");
		}
		private function draw_header_2()
		{
			//left 
			$left = 13;
			$top = 45;
			$width_texts_holders = 80;
			$this->pdf->SetFont("helvetica_bold", "", 8);
			$this->pdf->SetXY($left, $top);
			$this->pdf->MultiCell(40,5,
								"Sold to:"
														,$this->showBorder,"L");
			$this->pdf->SetFont("helvetica", "", 8);
			$this->pdf->SetXY($left+10, $top+5);
			$this->pdf->MultiCell($width_texts_holders,3,
								$_POST["companyName_TYPE_BILLING"]."\n"
								.$_POST["contactName_TYPE_BILLING"]."\n"
								.$_POST["address_1_TYPE_BILLING"]."\n"
								.$_POST["address_2_TYPE_BILLING"]."\n"
								.$_POST["address_3_TYPE_BILLING"]."\n".$_POST["city_TYPE_BILLING"].", ".$_POST["province_TYPE_BILLING"]." ".$_POST["postalCode_TYPE_BILLING"]
														,$this->showBorder,"L");
			///////////////////////////////////////////////////////////////////////////////
			//right
			$this->pdf->SetFont("helvetica_bold", "", 8);
			$this->pdf->SetXY($left+$width_texts_holders+10, $top);
			$this->pdf->MultiCell(40,5,
								"Ship to:"
														,$this->showBorder,"L");
			$this->pdf->SetFont("helvetica", "", 8);
			$this->pdf->SetXY($left+10+$width_texts_holders+10, $top+5);
			$this->pdf->MultiCell($width_texts_holders,3,
								$_POST["companyName_TYPE_SHIPING"]."\n"
								.$_POST["contactName_TYPE_SHIPING"]."\n"
								.$_POST["address_1_TYPE_SHIPING"]."\n"
								.$_POST["address_2_TYPE_SHIPING"]."\n"
								.$_POST["address_3_TYPE_SHIPING"]."\n".$_POST["city_TYPE_SHIPING"].", ".$_POST["province_TYPE_SHIPING"]." ".$_POST["postalCode_TYPE_SHIPING"]
														,$this->showBorder,"L");
		}
		private $columns = array(
			array("width"=>25,  "label"=>"Item No.", "align"=>"L", "product_reference"=>"item_code"),
			array("width"=>20,  "label"=>"Quantity", "align"=>"C", "product_reference"=>"qty_ordered"),
			array("width"=>105, "label"=>"Description", "align"=>"L", "product_reference"=>"item_description"),
			array("width"=>10,  "label"=>"Tax", "align"=>"C", "product_reference"=>"tax_code"),
			array("width"=>30,  "label"=>"Amount", "align"=>"R", "product_reference"=>"amount")
		);
		private function draw_table()
		{
			//left 
			$left = 13;
			$top = 80;
			$height_products_column = 150;
			$width_texts_holders = 80;
			$this->pdf->SetFont("helvetica", "", 8);
			$this->pdf->SetXY($left, $top);
			$this->pdf->MultiCell(120,5,
								"Business No.:          807361548RT0001"
														,$this->showBorder,"L");
														
			$this->pdf->SetFont("helvetica", "", 8);
			$this->pdf->SetDrawColor(120,120,120);
			$left_temp = $left;
			$total_width = 0;
			$last_width = 0;
			
			$invoice = new CreateInvoice_for_additionalProductsCSV();
			$invoice_products_detalized = $invoice->get_products_detalized();
			$total_price_amount = 0;
			
			
			for($i=0;$i<count($this->columns);$i++)
			{
				if($i % 2==0)
				{
					$this->pdf->SetFillColor(200,200,200);
				}
				else
				{
					$this->pdf->SetFillColor(150,150,150);
				}
				$this->pdf->SetXY($left_temp, $top+5);
				$this->pdf->MultiCell($this->columns[$i]["width"],5,
									$this->columns[$i]["label"]
															,1, $this->columns[$i]["align"],
															1);
				if($i % 2==0)
				{
					$this->pdf->SetFillColor(255,255,255);
				}
				else
				{
					$this->pdf->SetFillColor(240,240,240);
				}
				$this->pdf->Rect($left_temp, $top+10, $this->columns[$i]["width"], $height_products_column, "D");
				//////////////////////////////////////////////////////////////////////////////////
				////Columns for the products.
				//$array_results = array("text 1","text 2","text 3","text 4","text 5","text 6","text 7","text 8","text 9","text 10");
				$total_text_for_column = "";
				//for($k=0;$k<count($array_results);$k++)
				for($k=0;$k<count($invoice_products_detalized);$k++)
				{
					//$total_text_for_column .= $invoice_products_detalized[$k][$this->columns[$i]["product_reference"]]."\n";
					if($this->columns[$i]["product_reference"] == "amount")
					{
						$total_text_for_column .= number_format($invoice_products_detalized[$k][$this->columns[$i]["product_reference"]], 2)."\n";
						$total_price_amount += $invoice_products_detalized[$k]["amount"];
					}
					else
					{
						$total_text_for_column .= $invoice_products_detalized[$k][$this->columns[$i]["product_reference"]]."\n";
					}
				}
				if($i==2)
				{
					//$total_text_for_column .= "\nAB-GST 5%\nGST";
				}
				if($i==4)
				{
					//$total_text_for_column .= "\n27.03";
				}
				$this->pdf->SetXY($left_temp, $top+5+5);
				$this->pdf->MultiCell($this->columns[$i]["width"],3.5,
									$total_text_for_column
															,0, $this->columns[$i]["align"],
															0);
				//////////////////////////////////////////////////////////////////////////////////
				$left_temp += $this->columns[$i]["width"];
				$total_width += $this->columns[$i]["width"];
				$last_width = $this->columns[$i]["width"];
			}
			
			$height_footer = 25;
			$this->pdf->Rect($left, $top+10+$height_products_column, $total_width, $height_footer, "D");	
			$this->pdf->SetFont("helvetica", "", 8);
			$this->pdf->SetXY($left, $top+10+$height_products_column);
			$this->pdf->MultiCell(45,5,
									"Shipped By:"
															,$this->showBorder, "L",
															0);
			$this->pdf->SetXY($left+45, $top+10+$height_products_column);
			$this->pdf->MultiCell(45,5,
									"Tracking Number:"
															,$this->showBorder, "L",
															0);	
			$this->pdf->SetFont("helvetica_bold", "", 8);
			$this->pdf->SetXY($left, $top+10+4+$height_products_column);
			$this->pdf->MultiCell(45,5,
									"Comment:"
															,$this->showBorder, "L",
															0);	
			$this->pdf->SetFont("helvetica", "", 8);
			$this->pdf->SetXY($left+2, $top+10+8+$height_products_column);
			$this->pdf->MultiCell(125,2.2,
									$_POST["invoice_additiona_customer_code"]
															,$this->showBorder, "L",
															0);	
			$this->pdf->SetXY($left, $top+10+20+$height_products_column);
			$this->pdf->MultiCell(45,5,
									"Sold By:           ".$_POST["sales_person_code"]
															,$this->showBorder, "L",
															0);
			$this->pdf->SetFont("helvetica_bold", "", 8);
			$this->pdf->SetFillColor(240,240,240);
			$this->pdf->SetXY($left+$total_width-2*$last_width, $top+10+0+$height_products_column);
			$this->pdf->MultiCell($last_width,8,
									"Sub Total:"
															,1,"R",
															1);	
			$this->pdf->SetXY($left+$total_width-2*$last_width, $top+10+8+$height_products_column);
			$this->pdf->MultiCell($last_width,8,
									"Taxes:"
															,1,"R",
															1);	
			$this->pdf->SetXY($left+$total_width-2*$last_width, $top+10+16+$height_products_column);
			$this->pdf->MultiCell($last_width,9,
									"Grand Total:"
															,1,"R",
															1);	
			$this->pdf->SetFont("helvetica_bold", "", 9);
			$this->pdf->SetXY($left+$total_width-$last_width, $top+10+0+$height_products_column);
			$this->pdf->MultiCell($last_width,9,
									"$".number_format($_POST["sub_total_products_INPUT"],2)
															,1,"R",
															1);	
			$this->pdf->SetXY($left+$total_width-$last_width, $top+10+8+$height_products_column);
			$this->pdf->MultiCell($last_width,9,
									"$".number_format($_POST["sub_total_taxes_INPUT"],2)
															,1,"R",
															1);	
			$this->pdf->SetXY($left+$total_width-$last_width, $top+10+16+$height_products_column);
			$this->pdf->MultiCell($last_width,9,
									"$".number_format($_POST["grand_total_INPUT"],2)
															,1,"R",
															1);	
		}
		private function draw_outstanding_or_paid()
		{
			if($_POST["invoice_paid_or_outstanding"] == "Paid")
			{
				$this->pdf->SetFont("helvetica_bold", "", 75);
				$paid_or_outstanding = "PAID";
			}
			/*
			else if($_POST["invoice_paid_or_outstanding"] == "Outstanding")
			{
				//$paid_or_outstanding = "OUTSTANDING";
				$paid_or_outstanding = "Please Remit Payment";
			}*/
			else
			{
			$this->pdf->SetFont("helvetica_bold", "", 50);
				$paid_or_outstanding = "Please Remit Payment";
			}
			$this->pdf->SetTextColor(230,230,230);
			$this->pdf->SetXY(0, 80);
			$this->pdf->MultiCell(215,100,
								$paid_or_outstanding
														,$this->showBorder,"C");
			$this->pdf->SetTextColor(0,0,0);
			//print "AAAAAAAAAAAAAAAAAAAAAAAA";
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
		public function saveToFolder($folder_path)
		{
			$this->pdf->Output($folder_path.$this->myName( "" ).".pdf", "");
		}
		public function saveToLocal_into_invoices_folder(  )
		{
			$this->pdf->Output(SETTINGS::ORDERS_FOLDER."invoices/".$this->myName( "" ).".pdf", "");
		}
		public function view_on_browser()
		{
			$this->pdf->Output("invoice_viewing.pdf", "I");
		}
	}
	/* 	* 
	if(!class_exists("XMLParser")){require_once("../tools.php");}
	if(!class_exists("Product")){require_once("../products_moderator.php");}
	require_once("../pdf-tools/fpdf.php");
	require_once("../pdf-tools/pdf-helper.php");
	$_POST["products_indexes"] = "1,29,37";
	XMLParser::ADD_ORDER_XML_TO_POST( "../orders/xml/T_L5840.xml" );
	$objCheque = new Cheque( $_POST["chequeType"] );
	$objChequeData = new ChequeData( $objCheque );
	$objOrderForm = new InvoicePDFList( "../" );
	$objOrderForm->saveToLocal( "test" );
	*/
	 
	
	

?>