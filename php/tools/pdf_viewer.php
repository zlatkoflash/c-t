<?php

	if(!class_exists("XMLParser")){require_once("../tools.php");}
	if(!class_exists("Product")){require_once("../products_moderator.php");}
	require_once("../pdf-tools/fpdf.php");
	require_once("../pdf-tools/pdf-helper.php");
	
	class PDFViewer
	{
		public static function PDF_INIT_AND_SHOW()
		{
			if(!isset($_GET["pdf_type"]))
			{
				$_GET["pdf_type"] = "not_defined";
			}
			/*
			 * All variables will come to iframe via get 
			 * but i should create them to post, because all my pdf tools are using post to create 
			 * the pdfs
			 * */
			HELPWordpress::ALL_GET_TO_POST();
			ChequeData::SET_POST_DATA_FOR_USING();
			switch($_POST["pdf_type"])
			{
				case "InvoicePDFList":
				{
					require_once("../pdf_cheque_templates/invoice_pdf_list.php");
					$invoice_pdf = new InvoicePDFList("../");
					$invoice_pdf->saveToFolder("temp_pdf_folder_viewer/");
					self::GO_TO( $invoice_pdf->myFileName() );
				}break;
			}
		}
		private static function GO_TO($file_name)
		{
			?>
			<script>
				
				window.location.href = "temp_pdf_folder_viewer/<?php print $file_name; ?>?<?php print rand(0,100000); ?>";
				
			</script>
			<?php
		}
	}
	
	/*
	$_POST["products_indexes"] = "1,29,37";
	XMLParser::ADD_ORDER_XML_TO_POST( "../orders/xml/T_L5840.xml" );
	$objCheque = new Cheque( $_POST["chequeType"] );
	$objChequeData = new ChequeData( $objCheque );
	*/
	
	PDFViewer::PDF_INIT_AND_SHOW();

?>