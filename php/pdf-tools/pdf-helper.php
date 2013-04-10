<?php

	class PDFHelper
	{
		public function PDFHelper()
		{
		}
		///////////////////////////////////////////////////////////////////////
		///Metric unit is mm, but i have points.Because of that i need this...
		///////////////////////////////////////////////////////////////////////
		public static $widthA4=215.9;
		public static $heightA4=279.2;
		public static function pixels_to_MM($value){return $value/3.779527559;}//i will use this
		public static function points_to_MM($value){return $value/2.834645669;}//This is using for the texts, i think the texts are into points/millimeters
		public static function rect_fill($pdf,$x,$y,$w,$h,$fillcolor)
		{
			$pdf->SetFillColor($fillcolor[0], $fillcolor[1], $fillcolor[2]);
			$pdf->Rect(PDFHelper::pixels_to_MM($x),PDFHelper::pixels_to_MM($y),
								  PDFHelper::pixels_to_MM($w),PDFHelper::pixels_to_MM($h),"F");
		}
		public static function get_startAtN( $startAtN )
		{
			if(!is_numeric($startAtN))$startAtN = "000000";
			return 'C'.$startAtN.'C';
		}
		public static function get_branch_transit_Number($branchNumber, $transitNumber)
		{
			if(!is_numeric($branchNumber))$branchNumber = "00000";
			if(!is_numeric($transitNumber))$transitNumber = "000";
			return 'A'.$branchNumber.'D'.$transitNumber.'A';
		}
		public static function getWidthOfFontLetter($micLetter)
		{
			switch($micLetter)
			{
				case "1":return PDFHelper::pixels_to_MM(9);break;
				case "2":return PDFHelper::pixels_to_MM(10);break;
				case "3":return PDFHelper::pixels_to_MM(11);break;
				case "4":return PDFHelper::pixels_to_MM(12);break;
				case "5":return PDFHelper::pixels_to_MM(10);break;
				case "6":return PDFHelper::pixels_to_MM(12);break;
				case "7":return PDFHelper::pixels_to_MM(11);break;
				case "8":return PDFHelper::pixels_to_MM(14);break;
				case "9":return PDFHelper::pixels_to_MM(12);break;
				case "0":return PDFHelper::pixels_to_MM(13);break;
				case "-":return PDFHelper::pixels_to_MM(14);break;
				case "on-us":return PDFHelper::pixels_to_MM(14);break;
				case "Trans":return PDFHelper::pixels_to_MM(14);break;
			}
		}
		public static function draw_rect($pdf, $x, $y, $width, $height, $border_width)
		{
			$pdf->SetLineWidth(PDFHelper::pixels_to_MM($border_width));
			$pdf->Rect($x, $y, $width, $height, "D");
		}
	}

?>