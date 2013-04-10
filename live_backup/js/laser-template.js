// JavaScript Document
//varriables will get from here:var cqRenderer = new ChequeRenderer();
//cqRenderer is created into index.html
function LaserTemplates()
{
	this.chequeWithBg = '<div style="border-style:dotted; border-width:1px; width:612px; height:275px; position:relative;"><img id="pozadinaCheckID" src="images/backgrounds/1.jpg" style="position:absolute; left:0px; top:0px;" /><div id="companyName_topleftID" style="font-family:Arial; font-size:10pt; font-weight:bold; position:absolute; top:20px; left:5px;  text-align:center; width:300px;">Your Company Name</div><div id="line1_topleftID" style="position:absolute; left:5px; top:40px; font-family:Arial; font-size:8pt;  text-align:center; width:300px;"></div><div id="PAY_ID" style=" position:absolute; left:10px; top:110px; font-family:Arial; font-size:10pt; font-weight:bold;">PAY</div><div id="TO_ID" style=" position:absolute; left:10px; top:160px; font-family:Arial; font-size:8pt;">TO</div><div id="THE_ID" style=" position:absolute; left:10px; top:175px; font-family:Arial; font-size:8pt;">THE</div><div id="ORDER_ID" style=" position:absolute; left:10px; top:190px; font-family:Arial; font-size:8pt;">ORDER</div><div id="OF_ID" style=" position:absolute; left:10px; top:205px; font-family:Arial; font-size:8pt;">OF</div><div id="nameOfYBank_sredinaID" style="font-family:Arial; font-size:9pt; font-weight:bold; position:absolute; top:25px; left:290px; width:240px;text-align:left;">Name Of Your Bank</div><div id="bank___x4__lines" style="position:absolute; left:290px; top:40px; width:170px;  font-family:Arial; font-size:6pt; text-align:left;">   </div><div id="brojceGoreDesnoID" style="position:absolute; top:19px; left:495px;font-family:Arial; font-size:18pt; text-align:right; width:100px; ">000000</div><div id="howMuchDollarsID" style="font-family:Arial; font-size:12pt; font-weight:bold; position:absolute; top:110px; left:460px; width:140px; text-align:left; visibility:hidden;">  $</div><div id="usFUNDSLabel" style="font-family:Arial; font-size:8pt; font-weight:bold; position:absolute; top:125px; right:15px; text-align:right;">US FUNDS</div><div id="PERImeNaKompanijaID" style="font-family:Arial; font-size:7pt; font-weight:bold; position:absolute; top:150px; left:360px; width:270px; text-align:center;">Your Company Name</div><div id="PER1_ID" style="font-family:Arial; font-size:9pt; position:absolute; top:180px; left:350px; width:240px;">PER_______________________________</div><div id="PER2_ID" style="font-family:Arial; font-size:9pt; position:absolute; top:210px; left:350px; width:240px;">PER_______________________________</div><img id="watermarkIMG" src="images/backgrounds/watermark.png" style="position:absolute; margin:0px; padding:0px; top:180px; left:310px;" /><div id="brojcheLevoID" style="font-family:specialenFont; font-size:12pt; position:absolute; top:247px; left:40px; width:190px; text-align:left;"></div><div id="brojcheCentarID" style="font-family:specialenFont; font-size:12pt; position:absolute; top:247px; left:160px; width:190px; text-align:center;"></div><div id="brojcheDesnoID" style="font-family:specialenFont; font-size:12pt; position:absolute; top:247px; left:375px; width:210px; text-align:left;"></div><div id="brojceDesno45" class="displayNone" style="font-family:specialenFont; font-size:12pt; position:absolute; top:247px; left:580px; width:30px; text-align:left;">45</div></div>';
	
	this.blank_1 = '<div style="border-style:dotted; border-width:1px; position:relative; width:612px; height:252px;"> <div id="desnoImeKompanija1ID" style="font-family:Arial; font-size:10pt; font-weight:bold; position:absolute; top:15px; left:20px; width:432px; text-align:left; text-align:left;">Your Company Name</div><div id="levoBrojce1ID" style="position:absolute; top:15px; left:495px;font-family:Arial; font-size:18pt; text-align:right; width:100px; ">001234</div></div>';
	
	this.blank_2 = '<div style="border-style:dotted; border-width:1px; position:relative; width:612px; height:288px;"><div id="desnoImeKompanija2ID" style="font-family:Arial; font-size:10pt; font-weight:bold; position:absolute; top:15px; left:20px; width:432px; text-align:left; text-align:left;">Your Company Name</div><div id="levoBrojce2ID" style="position:absolute; top:15px; left:495px;font-family:Arial; font-size:18pt; text-align:right; width:100px; ">001234</div></div>';
	
	this.draw = function(index, holder)
	{
		holder.innerHTML = "";
		switch(index)
		{
			case 1:
			{
				holder.innerHTML += this.chequeWithBg;
				holder.innerHTML += this.blank_1;
				holder.innerHTML += this.blank_2;
			}break;
			case 2:
			{
				holder.innerHTML += this.blank_1;
				holder.innerHTML += this.chequeWithBg;
				holder.innerHTML += this.blank_2;
			}break;
			case 3:
			{
				holder.innerHTML += this.blank_1;
				holder.innerHTML += this.blank_2;
				holder.innerHTML += this.chequeWithBg;
			}break;
		}
		document.getElementById("watermarkIMG").src = objHelper.PATH_TO_THEME+"/images/backgrounds/watermark.png";
	}
}