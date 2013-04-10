function HELPER()
{
	this.arrayFUNCTIONs = [];
	this.addFunctionOnEnterFrame = function(object)
	{
		this.arrayFUNCTIONs.push(object);
	}
	this.onEnterFrame = function()
	{
		for(var i=0;i<this.arrayFUNCTIONs.length;i++)
		{
			this.arrayFUNCTIONs[i].fOnEnterFrame();
		}
	}
	this.indexOnENTERFRAME = -1;
	this.setOnEnterFrameEvent = function()
	{
		this.indexOnENTERFRAME = setInterval("objHelper.onEnterFrame()", 100);
	}
	this.setOnEnterFrameEvent();
	///////////////////////////////////////////////////////////////////////////////////////////
	this.emailValidarot = function(emailTekst)
	{
		if(emailTekst == "" || emailTekst.indexOf("@")==-1 || emailTekst.indexOf(".") == "")
		{
			return false;
		}
		return true;
	}
	this.nizaAvailableImages = [".jpeg",".jpg",".png",".gif",".bmp"];
	this.validateImageFileStr = function(value)
	{
		var last4Letters = value.substring(value.length-4,value.length);
		last4Letters = last4Letters.toLowerCase();
		this.izbranoLogo_set(value);
		for(var i=0;i<5;i++)
		{
		   if(nizaExt[i] == last4Letters)return true;
		}
		if(value.substring(value.length-5,value.length)==this.nizaExt[0])return true;
		document.getElementById("browseImageID").value = "";
		return false;
	}
	////////////////////////////////////////////////////////////////////////////////////
	this.PATH_TO_THEME = "";////////////////////////////////////////////////////////////
	this.URL = "";//////////////////////////////////////////////////////////////////////
	////////////////////////////////////////////////////////////////////////////////////
	////////////////////////////////////////////////////////////////////////////////////
	////////////////////////////////////////////////////////////////////////////////////
	////////////////////////////////////////////////////////////////////////////////////
	this.onTekstFocus = function(tekstSTR, INPUT)
	{
		if(tekstSTR == INPUT.value)
		{
			INPUT.value = "";
			INPUT.style.fontStyle = "normal";
		}
	}
	this.onTekstFOcusOut = function(tekstSTR, INPUT)
	{
		if(INPUT.value == "")
		{
			INPUT.value = tekstSTR;
			INPUT.style.fontStyle = "italic";
		}
	}
	this.setupComboBoxByIndex = function(cbID, index)
	{
		if(index=="")return;
		index = parseInt(index);
		if(document.getElementById(cbID) != null){return;}
		document.getElementById(cbID).selectedIndex = index;
	}
	this.setupComboBoxByText = function(cbID, text)
	{
		if(document.getElementById(cbID)==null){return;}
		for(var i=0;i<document.getElementById(cbID).length;i++)
		{
			if(document.getElementById(cbID).options[i].text == text)
			{
				document.getElementById(cbID).selectedIndex = i;
			}
		}
	}
	this.text_multiline_to_single_line = function(tekst)
	{
		var arrTeksts = tekst.split("\n");
		var newtext = "";
		for(var i=0;i<arrTeksts.length;i++)
		{
			if(i > 0){newtext += "[new line]";}
			newtext += arrTeksts[i];
		}
		return newtext;
	}
	this.text_single_line_to_multi_line = function(tekst)
	{
		var arrTeksts = tekst.split("[new line]");
		var newtext = "";
		for(var i=0;i<arrTeksts.length;i++)
		{
			if(i > 0){newtext += "\n";}
			newtext += arrTeksts[i];
		}
		return newtext;
	}
	////////////////////////////////////////////////////////////////////////////////////
	////////////////////////////////////////////////////////////////////////////////////
	////////////////////////////////////////////////////////////////////////////////////
	////////////////////////////////////////////////////////////////////////////////////
	this.absPositionY = function(HTMLObject)
	{
		var Ypoz = HTMLObject.offsetTop;
		while(HTMLObject.offsetParent != null)
		{
			HTMLObject = HTMLObject.offsetParent;
			Ypoz += HTMLObject.offsetTop;
		}
		return Ypoz;
	}
	this.scrollingYPoz = function()
	{
		return this.f_filterResults 
		(
			window.pageYOffset ? window.pageYOffset : 0,
			document.documentElement ? document.documentElement.scrollTop : 0,
			document.body ? document.body.scrollTop : 0
		);
	}
	this.f_filterResults = function(n_win, n_docel, n_body) 
	{
		var n_result = n_win ? n_win : 0;
		if (n_docel && (!n_result || (n_result > n_docel)))
			n_result = n_docel;
		return n_body && (!n_result || (n_result > n_body)) ? n_body : n_result;
	}
	this.realiseEvents = function(arr)
	{
		for(var i=0;i<arr.length;i++)
		{
			arr[i]();
		}
	}
}
var objHelper = new HELPER();
HELPER.H = objHelper;
function StringHelper()
{
	this.replaceAllStrings_intoString = function(string, stringForReplacment, newStringIntoREplacment)
	{
		if(!string.replace || !string.indexOf)
		{
			alert("StringHelper do no support javascript replaceAllStrings_intoString, into tools.js");
			return string;
		}
		while(string.indexOf( stringForReplacment )!=-1)
		{
			string = string.replace( stringForReplacment , newStringIntoREplacment);
		}
		return string;
	}
}
StringHelper.SH = new StringHelper();

//////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////
////////Contact Info
//////////////////////////////////////////////////////////////////////////////////
function ContactInfo()
{
	this.companyName = function(){return document.getElementById("CICompanyName").value;}
	this.contactName = function(){return document.getElementById("CIContactName").value;}
	this.phone = function(){return document.getElementById("CIPhone").value;}
	this.email = function(){return document.getElementById("CIEmail").value;}
	this.message = function(){return document.getElementById("CIQuestionsAndComments").value;}
	
	this.validate = function()
	{
		this.CIQuestionsAndCommentsSet();
		if(/*this.companyName()=="" || */this.contactName()=="" ||/* this.message()=="" ||*/ this.phone()==""|| objHelper.emailValidarot(this.email())==false/* */)
		{
			alert("Please complete Contact Info Form");
			return false;
		}
		if(document.getElementById("compInfoQuantity").selectedIndex == 0)
		{
			alert("Please select Quantity & Prices.");
			return false;
		}
		if(objCheque.type == Cheque.LASER && document.getElementById("compInfoSoftware").selectedIndex == 0)
		{
			alert("Please select Software.");
			return false;
		}
		return true;
	}
	this.CIQuestionsAndCommentsSet = function()
	{
		document.getElementById("CIQuestionsAndComments").value = document.getElementById("CIQuestionsAndCommentsTA").value;
		document.getElementById("CIQuestionsAndComments").value = 
		HELPER.H.text_multiline_to_single_line(
		document.getElementById("CIQuestionsAndComments").value
		);
	}
}
var objContactInfo = new ContactInfo();
//////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////
////////Quantity and prices
//////////////////////////////////////////////////////////////////////////////////
function Quantity_and_Prices()
{
	this.quantityText = function(){return document.getElementById("compInfoQuantity").options[document.getElementById("compInfoQuantity").selectedIndex].text;}
	this.quantity = function()
	{
		return {index:document.getElementById("compInfoQuantity").selectedIndex, 
				 text:this.quantityText(),
				 money:this.quantityMONEY(),
				 quantityCountFree:this.quantityCountFree()};
	}
	this.quantity_variables = [];
	this.quantity_variables["laser"] = [];
	this.quantity_variables["manual"] = [];
	////////For Laser
	this.quantity_variables["laser"]["Select Pricing & Quantity"] = {quantity:0, free:0, price:0};
	this.quantity_variables["laser"]["50 + 15 FREE $98"] = {quantity:50, free:15, price:98};
	this.quantity_variables["laser"]["100 + 25 FREE $114"] = {quantity:100, free:25, price:114};
	this.quantity_variables["laser"]["250 + 75 FREE $149"] = {quantity:250, free:75, price:149};
	this.quantity_variables["laser"]["500 + 125 FREE $194"] = {quantity:500, free:125, price:194};
	this.quantity_variables["laser"]["1000 + 250 FREE $283"] = {quantity:1000, free:250, price:283};
	this.quantity_variables["laser"]["2000 + 500 FREE $434"] = {quantity:2000, free:500, price:434};
	this.quantity_variables["laser"]["3000 + 750 FREE $536"] = {quantity:3000, free:750, price:536};
	this.quantity_variables["laser"]["4000 + 1000 FREE $650"] = {quantity:4000, free:1000, price:650};
	this.quantity_variables["laser"]["5000 + 1250 FREE $718"] = {quantity:5000, free:1250, price:718};
	this.quantity_variables["laser"]["Duplicates 250 + 75 FREE $213"] = {quantity:250, free:75, price:213};
	this.quantity_variables["laser"]["Duplicates 500 + 125 FREE $275"] = {quantity:500, free:125, price:275};
	this.quantity_variables["laser"]["Duplicates 1000 + 250 FREE $479"] = {quantity:1000, free:250, price:479};
	this.quantity_variables["laser"]["Duplicates 2000 + 500 FREE $691"] = {quantity:2000, free:500, price:691};
	this.quantity_variables["laser"]["Duplicates 3000 + 750 FREE $870"] = {quantity:3000, free:750, price:870};
	this.quantity_variables["laser"]["Duplicates 4000 + 1000 FREE $1027"] = {quantity:4000, free:1000, price:1027};
	this.quantity_variables["laser"]["Duplicates 5000 + 1250 FREE $1166"] = {quantity:5000, free:1250, price:1166};
	this.quantity_variables["laser"]["LARGER QUANTITIES AVAILABLE CALL FOR PRICING"] = {quantity:0, free:0, price:0};
	this.quantity_variables["laser"]["NO CHEQUES NEEDED"] = {quantity:0, free:0, price:0};
	////////For Manual
	this.quantity_variables["manual"]["Select Pricing & Quantity"] = {quantity:0, free:0, price:0};
	this.quantity_variables["manual"]["50 + 25 Free $73"] = {quantity:50, free:25, price:73};
	this.quantity_variables["manual"]["100 + 50 Free $89"] = {quantity:100, free:50, price:89};
	this.quantity_variables["manual"]["200 + 100 Free $109"] = {quantity:200, free:100, price:109};
	this.quantity_variables["manual"]["400 + 200 Free $128"] = {quantity:400, free:200, price:128};
	this.quantity_variables["manual"]["600 + 300 Free $144"] = {quantity:600, free:300, price:144};
	this.quantity_variables["manual"]["1200 + 600 Free $221"] = {quantity:1200, free:600, price:221};
	this.quantity_variables["manual"]["1800 + 900 Free $291"] = {quantity:1800, free:900, price:291}; 
	this.quantity_variables["manual"]["2400 + 1200 Free $363"] = {quantity:2400, free:1200, price:363};
	this.quantity_variables["manual"]["3000 + 1500 Free $439"] = {quantity:3000, free:1500, price:439};
	this.quantity_variables["manual"]["3600 + 1800 Free $505"] = {quantity:3600, free:1800, price:505};
	this.quantity_variables["manual"]["4200 + 2100 Free $577"] = {quantity:4200, free:2100, price:577};
	this.quantity_variables["manual"]["4800 + 2400 Free $650"] = {quantity:4800, free:2400, price:650};
	this.quantity_variables["manual"]["200 Duplicates 2 per page $115"] = {quantity:200, free:0, price:115};
	this.quantity_variables["manual"]["400+100 Free Duplicates $136"] = {quantity:400, free:100, price:136};
	this.quantity_variables["manual"]["NO CHEQUES NEEDED"] = {quantity:0, free:0, price:0};
	
	this.quantityMONEY = function()
	{
		return this.quantity_variables[Cheque.C.type][this.quantityText()].price;
	}
	this.quantityCountFree = function()
	{
		return this.quantity_variables[Cheque.C.type][this.quantityText()].quantity;
	}
	
	this.setQuantity = function()
	{
		document.getElementById("quantityINPUT").value = this.quantity().text+";"+this.quantity().index+";"+this.quantity().money+
		";"+this.quantity().quantityCountFree;
		document.getElementById("quantityINPUTIndex").value = document.getElementById("compInfoQuantity").selectedIndex;
	}
	this.addQuantintyOptions = function( chequeType )
	{
		for(var i in this.quantity_variables[chequeType])
		{
			$("#compInfoQuantity").append("<option>"+i+"</option>");
		}
	}
}
var objQuantity_and_PRices = new Quantity_and_Prices();
Quantity_and_Prices.QP = objQuantity_and_PRices;
//////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////
////////Cheque color
//////////////////////////////////////////////////////////////////////////////////
function ChequeColor()
{
	this.index = 1;
	this.getChequePozadina = function(){return document.getElementById("pozadinaCheckID");}
	this.getManualPozadina_1 = function(){return document.getElementById("background");}
	this.getManualPozadina_2 = function(){return document.getElementById("background_2");}
	this.bgURL = function(){return objHelper.PATH_TO_THEME+"/images/backgrounds/"+this.index+".jpg";}
	this.bgURLManual = function(){return objHelper.PATH_TO_THEME+"/images/backgrounds-manual/"+this.index+".jpg";}
	this.picturesColors = ['DARK BLUE','TEAL GREEN','BURGUNOY','BROWN','GREY','SKY BLUE','REFLEX BLUE','GREEN','GOLD BUFF','RED'];
	this.pictureColor = function(){return this.picturesColors[this.index-1];}
	this.arrayEventsAfterChanging = [];
	
	this.change = function( indexColor )
	{
		if(this.enabled == false && indexColor>3)
		{
			return;
		}
		this.index = indexColor;
		if(objCheque.type == Cheque.LASER)
		{
			objChequePosition.changeImages( this.index );
			document.getElementById("chequeColor").value = ""+this.index+";"+this.bgURL()+";"+this.pictureColor();
		}
		else if(objCheque.type == Cheque.MANUAL)
		{
			document.getElementById("chequeColor").value = ""+this.index+";"+this.bgURLManual()+";"+this.pictureColor();
		}
		this.changeBG();
		HELPER.H.realiseEvents( this.arrayEventsAfterChanging );
	}
	this.changeBG = function()
	{
		if(objCheque.type == Cheque.LASER)
		{
			if(Cheque.IS_FOR_ADMIN==false)
			{
				this.getChequePozadina().src = objHelper.PATH_TO_THEME+"/images/backgrounds/"+this.index+".jpg";
			}
		}
		else if(objCheque.type == Cheque.MANUAL)
		{
			$("#background").css("background-image", "url("+objHelper.PATH_TO_THEME+"/images/backgrounds-manual/"+this.index+".jpg)");
			if(this.getManualPozadina_2() != null)
			{
				$("#background_2").css("background-image", "url("+objHelper.PATH_TO_THEME+"/images/backgrounds-manual/"+this.index+".jpg)");
			}
		}
		document.getElementById("backgroundINdex").value = this.index;
	}
	this.enabled = true;
	this.disable__colors = function()
	{
		var index=1;
		while(document.getElementById("chequeColor__"+index) != null)
		{
			if(index >3)
			{
				$("#chequeColor__"+index).animate({opacity: 0.4}, 500 );
				$("#chequeColor__"+index).css('cursor','default');
			}
			index++;
		}
		this.enabled = false;
	}
	this.enable__colors = function()
	{
		var index=1;
		while(document.getElementById("chequeColor__"+index) != null)
		{
			if(index >3)
			{
				$("#chequeColor__"+index).animate({opacity: 1}, 500 );
				$("#chequeColor__"+index).css('cursor','pointer');
			}
			index++;
		}
		this.enabled = true;
	}
	this.setupToDarkBlueIfIsSelectedAnotherThenFour = function()
	{
		if(this.index != 1 && this.index !=2 && this.index !=3
		  && Cheque.C.type == Cheque.LASER)
		{
			this.change( 1 );
		}
	}
}
var objChequeColor = new ChequeColor();
ChequeColor.CH = objChequeColor;
function ChequePosition()
{
	this.arrEventsAfterChanging = [];
	this.positionsIndex = 1;
	this.manualX2Cheques = function()
	{
		return document.getElementById("manualPosX2cheque").checked;
	}
	this.imgPoz_id1 = function(){return document.getElementById("imgPoz_id1");}
	this.imgPoz_id2 = function(){return document.getElementById("imgPoz_id2");}
	this.imgPoz_id3 = function(){return document.getElementById("imgPoz_id3");}
	this.positionName = function()
	{
		switch(this.positionsIndex)
		{
			case 1:{return "TOP";}break;
			case 2:{return "MIDDLE";}break;
			case 3:{return "BOTTOM";}break;
		}
	}
		
	this.changeImages = function(index)
	{
	    this.imgPoz_id1().src = objHelper.PATH_TO_THEME+"/images/styles/"+index+"-1.png";
	    this.imgPoz_id2().src = objHelper.PATH_TO_THEME+"/images/styles/"+index+"-2.png";
	    this.imgPoz_id3().src = objHelper.PATH_TO_THEME+"/images/styles/"+index+"-3.png";
	}
	this.changePosition = function(index)
	{
		if(index=="")return;
		index=parseInt(index);
		this.positionsIndex = index;
		document.getElementById("chequePosition").value = this.positionsIndex;
		
		if(objCheque.type == Cheque.LASER)
		{
			if(index == 3)
			{
				objChequeColor.disable__colors();
				ChequeColor.CH.setupToDarkBlueIfIsSelectedAnotherThenFour();
			}
			else
			{
				objChequeColor.enable__colors();
			}
		}
		HELPER.H.realiseEvents( this.arrEventsAfterChanging );
		if(Cheque.IS_FOR_ADMIN==true){return;}
		objCheque.render();
	}
	this.manualX2ChequesSet = function(meCB)
	{
		if(meCB == document.getElementById("manualPosX1cheque"))
		{
			document.getElementById("manualPosX1cheque").checked = true;
			document.getElementById("manualPosX2cheque").checked = false;
			document.getElementById("chequePosition").value = "false";
		}
		else
		{
			document.getElementById("manualPosX1cheque").checked = false;
			document.getElementById("manualPosX2cheque").checked = true;
			document.getElementById("chequePosition").value = "true";
		}
		if(Cheque.IS_FOR_ADMIN == false)
		{
			objCheque.render();
		}
	}
	this.setupCBs1OR2ChequesPerManual = function(istrue)
	{
		if(istrue=="true")
		{
			document.getElementById("manualPosX1cheque").checked = false;
			document.getElementById("manualPosX2cheque").checked = true;
		}
		else if(istrue=="false")
		{
			document.getElementById("manualPosX1cheque").checked = true;
			document.getElementById("manualPosX2cheque").checked = false;
		}
		else
		{
		}
	}
}
var objChequePosition = new ChequePosition();
ChequePosition.CP = objChequePosition;
//////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////
////////CompanyInfo
//////////////////////////////////////////////////////////////////////////////////
function CompanyInfo()
{
	///Company Name & Address
	this.showSecondName = function(){return document.getElementById("compInfoCBShowSecondLine").checked;}
	/*
	this.billToNameOnCheque = function(){return document.getElementById("compInfoBillToNameOnCheque").checked;}
	this.shipToAddressOfCheque = function(){return document.getElementById("compInfoShipToAddressOnCheque").checked;}
	*/
	this.billToNameOnCheque = function(){return document.getElementById("BSCombo_"+this.TYPE_BILLING).checked;}
	this.shipToAddressOfCheque = function(){return document.getElementById("BSCombo_"+this.TYPE_SHIPING).checked;}
	
	this.name = function(){return document.getElementById("compInfoName").value;}
	this.secondName = function()
	{
		if(this.showSecondName() == false){return "";}
		return document.getElementById("compInfoSecondName").value;
	}
	this.adress_1 = function(){return document.getElementById("compInfoAddressLine1").value;}
	this.adress_2 = function(){return document.getElementById("compInfoAddressLine2").value;}
	this.adress_3 = function(){return document.getElementById("compInfoAddressLine3").value;}
	this.adress_4 = function(){return document.getElementById("compInfoAddressLine4").value;}
	this.differentNameForBilling = function()
	{
		if(this.billToNameOnCheque() == false){return "";}
		//return document.getElementById("compInfoDifferentNameForBilling").value;
		return document.getElementById("contactName_"+this.TYPE_BILLING).value;
	}
	this.differentAddressForShipping = function()
	{
		if(this.shipToAddressOfCheque() == false){return "";}
		//return document.getElementById("compInfoDifferentAddressForShipping").value;
		return document.getElementById("contactName_"+this.TYPE_SHIPING).value;
	}
	this.TYPE_BILLING = "TYPE_BILLING";
	this.TYPE_SHIPING = "TYPE_SHIPING";
	this.comboShowShippingBilling = function(typeIs)
	{
		if(document.getElementById("BSCombo_"+typeIs).checked == true && 
			$("#billingShippingBlog_"+typeIs).is(".displayNone"))
		{
			$("#billingShippingBlog_"+typeIs).removeClass("displayNone");
		}
		else if(document.getElementById("BSCombo_"+typeIs).checked == false)
		{
			$("#billingShippingBlog_"+typeIs).addClass("displayNone");
		}
		if(typeIs == this.TYPE_SHIPING)
		{
			this.shipToAnotherAdressaCBClick(  );
		}
		else if(typeIs == this.TYPE_BILLING)
		{
			this.billToAnotherNameCBClick(  );
		}
	}
	this.billToAnotherNameCBClick = function( )
	{
		document.getElementById("isBillToAlternativeName").value = this.differentNameForBilling();
		/*
		var cb1 = document.getElementById("compInfoBillToNameOnCheque");
		var cb2 = document.getElementById("compInfoBillToDifferentNameCheckBox");
		
		if(cb != null)
		{
			if(cb.checked && cb1==cb)cb2.checked = false;
			else if(!cb.checked && cb1==cb)cb2.checked = true;
			else if(cb.checked && cb2==cb)cb1.checked = false;
			else if(!cb.checked && cb2==cb)cb1.checked = true;
		}
		document.getElementById("isBillToAlternativeName").value = this.differentNameForBilling();
		*/
	}
	this.shipToAnotherAdressaCBClick = function(  )
	{
		document.getElementById("isShipToDifferentAddress").value = this.differentAddressForShipping();
		/*
		var cb1 = document.getElementById("compInfoShipToAddressOnCheque");
		var cb2 = document.getElementById("compInfoShipToDifferentAddress");
	
		if(cb != null)
		{
			if(cb.checked && cb1==cb)cb2.checked = false;
			else if(!cb.checked && cb1==cb)cb2.checked = true;
			else if(cb.checked && cb2==cb)cb1.checked = false;
			else if(!cb.checked && cb2==cb)cb1.checked = true;
		}
		document.getElementById("isShipToDifferentAddress").value = this.differentAddressForShipping();
		*/
	}
	
	this.name_StringHTML = function()
	{
		if(this.secondName() != "" && this.showSecondName() == true)
		{
			return this.name()+"<br/>"+this.secondName();
		}
		return this.name();
	}
	this.name_StringCrticka = function()
	{
		if(this.secondName() != "" && this.showSecondName() == true)
		{
			return this.name()+" - "+this.secondName();
		}
		return this.name();
	}
	
	this.thereIsSecondNameAvailable = function()
	{
		if(this.secondName() != "" && this.showSecondName() == true)return true;
		return false;
	}
	this.CompanyNameAddress_showOnCheque = function()
	{
		if( this.thereIsSecondNameAvailable()==true )
		{
			document.getElementById("comInfoIsSecondCompanyName").value = this.secondName();
		}
		else
		{
			document.getElementById("comInfoIsSecondCompanyName").value = "";
		}
		if(Cheque.IS_FOR_ADMIN==true)
		{
			return;
		}
		if( this.thereIsSecondNameAvailable()==true )
		{
			if(objCheque.type == Cheque.LASER)
			{
				document.getElementById("line1_topleftID").style.top = "50px";
			}
			else
			{
				document.getElementById("line1_topleftID").style.top = "40px";
				if(document.getElementById("line2_topleftID") != null){document.getElementById("line2_topleftID").style.top = "40px";}
			}
		}
		else
		{
			if(objCheque.type == Cheque.LASER)
			{
				document.getElementById("line1_topleftID").style.top = "35px";
			}
			else
			{
				document.getElementById("line1_topleftID").style.top = "25px";
				if(document.getElementById("line2_topleftID") != null){document.getElementById("line2_topleftID").style.top = "25px";}
			}
		}
		
		if(this.name() != "")
		{  
		   document.getElementById("companyName_topleftID").innerHTML = this.name_StringHTML();
		   if(document.getElementById("companyName_topleftID_2") != null)
		   {document.getElementById("companyName_topleftID_2").innerHTML = this.name_StringHTML();}
		   if(objCheque.type == Cheque.LASER)
		   {
			   document.getElementById("desnoImeKompanija1ID").innerHTML = this.name_StringCrticka();
			   document.getElementById("desnoImeKompanija2ID").innerHTML = this.name_StringCrticka();
		   }
		   document.getElementById("PERImeNaKompanijaID").innerHTML = this.name_StringHTML();
		   if(document.getElementById("PERImeNaKompanijaID_2") != null)
		   {
			   document.getElementById("PERImeNaKompanijaID_2").innerHTML = this.name_StringHTML();
		   }
		}
		else
		{  
		   document.getElementById("companyName_topleftID").innerHTML = "Your Company Name";
		   if(document.getElementById("companyName_topleftID_2") != null)
		   {document.getElementById("companyName_topleftID_2").innerHTML = "Your Company Name";}
		   if(objCheque.type == Cheque.LASER)
		   {
			   document.getElementById("desnoImeKompanija1ID").innerHTML = "Your Company Name";
			   document.getElementById("desnoImeKompanija2ID").innerHTML = "Your Company Name";
		   }
		   document.getElementById("PERImeNaKompanijaID").innerHTML = "Your Company Name";
		   if(document.getElementById("PERImeNaKompanijaID_2") != null)
		   {
			   document.getElementById("PERImeNaKompanijaID_2").innerHTML = "Your Company Name";
		   }
		}
		document.getElementById("line1_topleftID").innerHTML = this.adress_1()+'<br/>'+this.adress_2()+'<br/>'+this.adress_3()+'<br/>'+this.adress_4();
		if(objCheque.type == Cheque.MANUAL && document.getElementById("line2_topleftID"))
		{
			document.getElementById("line2_topleftID").innerHTML = this.adress_1()+'<br/>'+this.adress_2()+'<br/>'+this.adress_3()+'<br/>'+this.adress_4();
		}
	}
	///////////////////////////////////////////////////////////////////
	///Logo
	this.logoType = function()
	{
		if(document.getElementById("compInfoAttachLogo_1").checked == true)
		{
			return "0";
		}
		else if(document.getElementById("compInfoAttachLogo_2").checked == true)
		{
			return "1";
		}
		else
		{
			return "-1";
		}
	}
	this.CBLogoOnClick = function(CB)
	{
		if(CB == document.getElementById("compInfoAttachLogo_1"))
		{
			document.getElementById("compInfoAttachLogo_2").checked = false;
		}
		else
		{
			document.getElementById("compInfoAttachLogo_1").checked = false;
		}
		if(CB.checked == true)
		{
			this.showButtonForAttachImage();
		}
		else
		{
			this.hideButtonForAttachImage();
		}
		document.getElementById("CILogoType").value = this.logoType();
	}
	this.showButtonForAttachImage = function()
	{
		document.getElementById("compInfoLogoInputHolder").innerHTML = '<input name="compInfoLogoInput" id="compInfoLogoInput" type=file value="Choose File" onchange="validateImageFileStr(this.value)" accept="image/gif, image/jpeg" />';
	}
	this.hideButtonForAttachImage = function()
	{
		document.getElementById("compInfoLogoInputHolder").innerHTML = "";
	}
	///////////////////////////////////////////////////////////////////
	///Bank Info
	this.bankName = function(){return document.getElementById("compInfoBankName").value;}
	this.bankAddress1 = function(){return document.getElementById("compInfoBankAddress1").value;}
	this.bankAddress2 = function(){return document.getElementById("compInfoBankAddress2").value;}
	this.bankAddress3 = function(){return document.getElementById("compInfoBankAddress3").value;}
	this.bankAddress4 = function(){return document.getElementById("compInfoBankAddress4").value;}
	this.bankInfoShowToCheque = function()
	{
		if(Cheque.IS_FOR_ADMIN == true)
		{
			return;
		}
		if(this.bankName() != "")
		{
			document.getElementById("nameOfYBank_sredinaID").innerHTML = this.bankName();
			if(document.getElementById("nameOfYBank_sredinaID_2") != null)
			{
				document.getElementById("nameOfYBank_sredinaID_2").innerHTML = this.bankName();
			}
		}
		else
		{
			document.getElementById("nameOfYBank_sredinaID").innerHTML = "Name Of Your Bank";
			if(document.getElementById("nameOfYBank_sredinaID_2") != null)
			{
				document.getElementById("nameOfYBank_sredinaID_2").innerHTML = "Name Of Your Bank";
			}
		}
		
		document.getElementById("bank___x4__lines").innerHTML = this.bankAddress1()+"<br/>"+this.bankAddress2()+"<br/>"+this.bankAddress3()+"<br/>"+this.bankAddress4();
		if(objCheque.type == Cheque.MANUAL && document.getElementById("bank___x4__lines_2") != null)
		{
			document.getElementById("bank___x4__lines_2").innerHTML = this.bankAddress1()+"<br/>"+this.bankAddress2()+"<br/>"+this.bankAddress3()+"<br/>"+this.bankAddress4();
		}
	}
	////////////////////////////////////////////////////////////////////////////////
	////Currency info
	this.showUS_FUNDS_label = function()
	{
		if(document.getElementById("compInfoCBUSFunds").checked == true)
		{
			document.getElementById("usFUNDSLabel").style.visibility = "visible";
		}
		else
		{
			document.getElementById("usFUNDSLabel").style.visibility = "hidden";
		}
		if(document.getElementById("usFUNDSLabel_2") != null)
		{
			document.getElementById("usFUNDSLabel_2").style.visibility = document.getElementById("usFUNDSLabel").style.visibility;
		}
	}
	this.us_funds = function()
	{
		return document.getElementById("compInfoCBUSFunds").checked;
	}
	this.usFundsShowOnCheque = function()
	{
		if(this.us_funds() == true)
		{
			document.getElementById("isCurrencyINPUT").value = "true";
			$("#add45OnAccountNumber").removeClass("displayNone");
			if($("#compInfoAdd45AfterAccount").is(":checked"))
			{
				$("#add45AfterAcountNumberInput").attr("value", "true");
			}
			else
			{
				$("#add45AfterAcountNumberInput").attr("value", "false");
			}
		}
		else
		{
			document.getElementById("isCurrencyINPUT").value = "false";
			$("#compInfoAdd45AfterAccount").attr("checked", false);
			$("#add45AfterAcountNumberInput").attr("value", "false");
			$("#add45OnAccountNumber").addClass("displayNone");
		}
		if(Cheque.IS_FOR_ADMIN==true){return;}
		if(this.us_funds() == true){document.getElementById("usFUNDSLabel").style.visibility = "visible";}
		else{document.getElementById("usFUNDSLabel").style.visibility = "hidden";}
		if(document.getElementById("usFUNDSLabel_2") != null)//for manual cheque when x2 cheques is selected
		{
			document.getElementById("usFUNDSLabel_2").style.visibility = document.getElementById("usFUNDSLabel").style.visibility;
		}
		if($("#compInfoAdd45AfterAccount").is(":checked"))
		{
			$("#brojceDesno45").removeClass("displayNone");
			if(document.getElementById("brojceDesno45_2") != null)
			{
				$("#brojceDesno45_2").removeClass("displayNone");
			}
		}
		else
		{
			$("#brojceDesno45").addClass("displayNone");
			if(document.getElementById("brojceDesno45_2") != null)
			{
				$("#brojceDesno45_2").addClass("displayNone");
			}
		}
	}
	////////////////////////////////////////////////////////////////////////////////
	////Pricing, Quantity & Cheque Info
								
	this.software = function()
	{
		return {index:document.getElementById("compInfoSoftware").selectedIndex, 
				 text:document.getElementById("compInfoSoftware").options[document.getElementById("compInfoSoftware").selectedIndex].text};
	}
	this.onSowtaferSELECTChanging = function()
	{
	   document.getElementById("softwareINPUT").value = this.software().text+";"+this.software().index;
	   document.getElementById("softwareINPUTIndex").value = this.software().index;
	   var selectedIndex = document.getElementById("compInfoSoftware").selectedIndex;
	   if(document.getElementById("compInfoSoftware").options[selectedIndex].text == 'Other')
	   {
		   document.getElementById("compInfoOtherSoftwer").innerHTML = 'Enter Software<br> <input type=text id="compInfoEnterOtherSoftware" name="compInfoEnterOtherSoftware" style="width:100%; margin-bottom:2px;margin-top:2px;" />';
	   }
	   else
	   {
		   document.getElementById("compInfoOtherSoftwer").innerHTML = "";
	   }
	   if(Cheque.IS_FOR_ADMIN==true){return;}
	   this.showDOLLAR();
	}
	this.showDOLLAR = function()
	{
		if(document.getElementById("compInfoSoftware").selectedIndex == 4)
		{
			document.getElementById("howMuchDollarsID").style.visibility = "visible";
		}
		else
		{
			document.getElementById("howMuchDollarsID").style.visibility = "hidden";
		}
		if(document.getElementById("howMuchDollarsID_2") != null)
		{
			document.getElementById("howMuchDollarsID_2").style.visibility = document.getElementById("howMuchDollarsID").style.visibility;
		}
	}
	this.useDWE = function(){return document.getElementById("compInfoIncludeEnvelopes").checked;}
	this.CBDWEOnClick = function()
	{
		if(this.useDWE())
		{
		   document.getElementById("compInfoIncludeEnvelopes_supplierINPUT").innerHTML = 'Enter Your Supplier<br> <input type=text id="compInfoClientSupplier" name="compInfoClientSupplier" style=" margin-bottom:10px; width:95%;" />';
		}
		else
		{
		   document.getElementById("compInfoIncludeEnvelopes_supplierINPUT").innerHTML = "";
		}
	}
	this.CBDeGetSupplier = function()
	{
		if(document.getElementById("compInfoClientSupplier") == null){return "";}
		return document.getElementById("compInfoClientSupplier").value;
	}
	this.isSecondSignature = function(){return document.getElementById("compInfoSecondSignatur").checked;}
	this.showHideSecondSignature = function()
	{
		if(this.isSecondSignature() == true)
		{
			document.getElementById("isThereSecondSignature").value = "true";
		}
		else
		{
			document.getElementById("isThereSecondSignature").value = "false";
		}
		if(Cheque.IS_FOR_ADMIN==true){return;}
		if(this.isSecondSignature() == true)
		{
			document.getElementById("PER1_ID").style.visibility = "visible";
			if(objCheque.type == Cheque.LASER)
			{
				document.getElementById("PERImeNaKompanijaID").style.top = "150px";
			}
		}
		else
		{
			document.getElementById("PER1_ID").style.visibility = "hidden";
			if(objCheque.type == Cheque.LASER)
			{
				document.getElementById("PERImeNaKompanijaID").style.top = "170px";
			}
		}
		if(document.getElementById("PER1_ID_2") != null)
		{
			document.getElementById("PER1_ID_2").style.visibility = document.getElementById("PER1_ID").style.visibility;
		}
	}
	this.isStartNumber = function(){return document.getElementById("compInfoShowStartNumber").checked;}
	this.startAt = function()
	{
		return document.getElementById("compInfoStartAt").value;
	}
	this.startAt_plus_1 = function()
	{
		var starAtINtStr = this.startAt();
		var starAtINt = parseFloat( this.startAt() );
		starAtINt++;
		starAtINtStr = String(starAtINt); 
		while(starAtINtStr.length < this.startAt().length)
		{
			starAtINtStr = "0"+starAtINtStr;
		}
		if(isNaN(starAtINt)){return "000000";}
		return starAtINtStr;
	}
	this.showStartNumber = function()
	{
		if(this.isStartNumber() == true)
		{
			document.getElementById("compInfoStartAtTrueOrFalse").value = "true";
		}
		else
		{
			document.getElementById("compInfoStartAtTrueOrFalse").value = "false";
		}
		if(Cheque.IS_FOR_ADMIN==true){return;}
		if(this.isStartNumber() == true)
		{
			document.getElementById("brojceGoreDesnoID").style.visibility = "visible";
			document.getElementById("brojcheLevoID").style.visibility = "visible";
			document.getElementById("levoBrojce1ID").style.visibility = "visible";
			document.getElementById("levoBrojce2ID").style.visibility = "visible";
		}
		else
		{
			document.getElementById("brojceGoreDesnoID").style.visibility = "hidden";
			document.getElementById("brojcheLevoID").style.visibility = "hidden";
			document.getElementById("levoBrojce1ID").style.visibility = "hidden";
			document.getElementById("levoBrojce2ID").style.visibility = "hidden";
		}
	}
	this.brunchNumber = function(){return document.getElementById("compInfoBrunchNumber").value;}
	this.transitNumber = function(){return document.getElementById("compInfoTransitNumber").value;}
	this.accountNumber = function(){return document.getElementById("compInfoAccountNumber").value;}
	this.showTheNumbers = function()
	{
		document.getElementById("startAtNumber_plus_1").value = this.startAt_plus_1();
		if(Cheque.IS_FOR_ADMIN==true){return;}
		document.getElementById("brojceGoreDesnoID").innerHTML = this.startAt();
		if(document.getElementById("brojceGoreDesnoID_2") != null)
		{
			document.getElementById("brojceGoreDesnoID_2").innerHTML = this.startAt_plus_1();
		}
		var divNumber1 = document.getElementById("brojcheLevoID");
		var divNumber2 = document.getElementById("brojcheCentarID");
		var divNumber3 = document.getElementById("brojcheDesnoID");
		if(objCheque.type == Cheque.LASER)
		{
			document.getElementById("levoBrojce1ID").innerHTML = this.startAt();
			document.getElementById("levoBrojce2ID").innerHTML = this.startAt();
		}
		else
		{
			document.getElementById("brojceGoreDesnoIDnew").innerHTML = this.startAt();
			if(document.getElementById("brojceGoreDesnoIDnew_2") != null)
			{
				document.getElementById("brojceGoreDesnoIDnew_2").innerHTML = this.startAt_plus_1();
			}
		}
	
		var num1 = this.startAt();if(isNaN(num1))num1 = "000000";
		var num1_innerHTML = "C"+num1+"C";
	
		var num2_p1 = this.brunchNumber();if(isNaN(num2_p1))num2_p1 = "00000";
		var num2_p2 = this.transitNumber();if(isNaN(num2_p2))num2_p2 = "000";
		var num2 = "A"+num2_p1 + " D " + num2_p2+"A";
		var num2_innerHTML = num2;
	
		var num3 = this.accountNumber();
		var NUM3 = "";
		
		for(var iL=0;iL<num3.length;iL++)
		{
		   if(num3.charAt(iL) == 'D')NUM3+=   "D";
		   if(num3.charAt(iL) == '-')NUM3 +=   "D";
		   if(num3.charAt(iL) == ' ')NUM3 +=   "<span style='font-family:Arial;'>&nbsp;</span>";
		   if(isNaN(num3.charAt(iL)) == false)
		   {
			   NUM3= NUM3+ num3.charAt(iL);
		   }
		}
		var num3_innerHTML = NUM3 + "C";
		
		divNumber1.innerHTML = num1_innerHTML;
		divNumber2.innerHTML = num2_innerHTML;
		divNumber3.innerHTML = num3_innerHTML;
		if(document.getElementById("brojcheLevoID_2") != null)
		{
			document.getElementById("brojcheLevoID_2").innerHTML = "C"+this.startAt_plus_1()+"C";
			document.getElementById("brojcheCentarID_2").innerHTML = num2_innerHTML;
			document.getElementById("brojcheDesnoID_2").innerHTML = num3_innerHTML;
		}
	}
	//////////////////////////////////////////////////////////
	////Boxing:(How cheques are placed in Printer)
	this.BOXselectedCB = null;
	this.BOXarrayCB = new Array({cb_id:'compInfoBoxingType0',text:'Low %23 on top, face up'},
							    {cb_id:'compInfoBoxingType1',text:'Low %23 on top, face down'},
							    {cb_id:'compInfoBoxingType2',text:'High %23 on top, face up'},
							    {cb_id:'compInfoBoxingType3',text:'High %23 on top, face down'});
	this.BOXaddEventsToTheCB = function()
	{
		for(var i=0;i<this.BOXarrayCB.length;i++)
		if(document.getElementById(this.BOXarrayCB[i].cb_id) != null)
		{
			document.getElementById(this.BOXarrayCB[i].cb_id).box = this;
			document.getElementById(this.BOXarrayCB[i].cb_id).index = i;
			document.getElementById(this.BOXarrayCB[i].cb_id).onclick = function()
			{
				this.box.BOXselectedCurrentCB(this.index);
			}
		}
	}
	this.BOXselectedCurrentCB = function(index)
	{
		for(var i=0;i<this.BOXarrayCB.length;i++)
		if(document.getElementById(this.BOXarrayCB[i].cb_id) != null)
		{
			document.getElementById(this.BOXarrayCB[i].cb_id).checked = false;
		}
		this.BOXselectedCB = document.getElementById(this.BOXarrayCB[index].cb_id);
		this.BOXselectedCB.checked = true;
		document.getElementById("boxingType").value = this.BOXarrayCB[index].text;
	}
	this.BOXgetVariableForSever = function()
	{
		if(this.BOXselectedCB == null)return 'boxingType=No option selected.';
		return 'boxingType='+this.BOXarrayCB[this.BOXselectedCB.index].text;
	}
	this.selectCBByBoxingTypeText = function(text)
	{
		for(var i=0;i<this.BOXarrayCB.length;i++)
		if(document.getElementById(this.BOXarrayCB[i].cb_id) != null)
		{
			document.getElementById(this.BOXarrayCB[i].cb_id).checked = false;
			if(text == this.BOXarrayCB[i].text)
			{
				document.getElementById(this.BOXarrayCB[i].cb_id).checked = true;
			}
		}
	}
	//////////////////////////////////////////////////////////////////////
	/////Additional Products
	this.APDepositBooks = function()
	{
		if(document.getElementById("compInfoDepositBooks")==null)return {index:-1, text:""};
		return {index:document.getElementById("compInfoDepositBooks").selectedIndex, 
				 text:this.setADditionalProductsSetInputs__seeIfIsFirstSelected(document.getElementById("compInfoDepositBooks"))};
	}
	this.APDWE = function()
	{
		if(document.getElementById("compInfoDWE")==null)return {index:-1, text:""};
		return {index:document.getElementById("compInfoDWE").selectedIndex, 
				 text:this.setADditionalProductsSetInputs__seeIfIsFirstSelected(document.getElementById("compInfoDWE"))};
	}
	this.APSSDWE = function()
	{
		if(document.getElementById("compInfoSSDWE")==null)return {index:-1, text:""};
		return {index:document.getElementById("compInfoSSDWE").selectedIndex, 
				 text:this.setADditionalProductsSetInputs__seeIfIsFirstSelected(document.getElementById("compInfoSSDWE"))};
	}
	this.APChequeBinder = function()
	{
		if(document.getElementById("compInfoChequeBinder")==null)return {index:-1, text:""};
		return {index:document.getElementById("compInfoChequeBinder").selectedIndex, 
				 text:this.setADditionalProductsSetInputs__seeIfIsFirstSelected(document.getElementById("compInfoChequeBinder"))};
	}
	this.APSelfLinkingStamp = function()
	{
		if(document.getElementById("compInfoSelfLinkingStamp")==null)return {index:-1, text:""};
		return {index:document.getElementById("compInfoSelfLinkingStamp").selectedIndex, 
				 text:this.setADditionalProductsSetInputs__seeIfIsFirstSelected(document.getElementById("compInfoSelfLinkingStamp"))};
	}
	this.setADditionalProductsSetInputs = function()
	{
		document.getElementById("depositBooksINPUT").value = this.APDepositBooks().text;
		document.getElementById("depositBooksINPUT_VARs").value = this.getDepositDetailized();
		document.getElementById("DWEINPUT").value = this.APDWE().text;
		document.getElementById("SSDWEINPUT").value = this.APSSDWE().text;
		if(objCheque.type == Cheque.MANUAL)
		{
			document.getElementById("chequeBinderINPUT").value = this.APChequeBinder().text;
		}
		document.getElementById("SelfLinkStampINPUT").value = this.APSelfLinkingStamp().text;
		OrderTotalAmount.OTA.calculate();
	}
	this.getDepositDetailized = function()
	{
		return this.getDepositObject().copies+";"+this.getDepositObject().count+";"+this.getDepositObject().priceTotal;
	}
	this.getDepositObject = function()
	{
		switch(this.APDepositBooks().text)
		{
			case "2 Copies 100 $30":{return {copies:"2", count:"100", priceTotal:30};}break;
			case "2 Copies 200 $47":{return {copies:"2", count:"200", priceTotal:47};}break;
			case "2 Copies 300 $62":{return {copies:"2", count:"300", priceTotal:62};}break;
			case "2 Copies 500 $88":{return {copies:"2", count:"500", priceTotal:88};}break;
			case "2 Copies 1000 $143":{return {copies:"2", count:"1000", priceTotal:143};}break;
			case "2 Copies 1500 $210":{return {copies:"2", count:"1500", priceTotal:210};}break;
			case "3 Copies 100 $34":{return {copies:"3", count:"100", priceTotal:34};}break;
			case "3 Copies 200 $53":{return {copies:"3", count:"200", priceTotal:53};}break;
			case "3 Copies 300 $67":{return {copies:"3", count:"300", priceTotal:67};}break;
			case "3 Copies 500 $95":{return {copies:"3", count:"500", priceTotal:95};}break;
			case "3 Copies 1000 $149":{return {copies:"3", count:"1000", priceTotal:149};}break;
			case "3 Copies 1500 $203":{return {copies:"3", count:"1500", priceTotal:203};}break;
		}
		return {copies:"", count:"", priceTotal:0};
	}
	this.getDWEObject = function()
	{
		switch(this.APDWE().text)
		{
			case "250 DWE $36.00":{return {priceTotal:36};}break;
			case "500 DWE $55.00":{return {priceTotal:55};}break;
			case "1000 DWE $90.00":{return {priceTotal:90};}break;
			case "2000 DWE $146.00":{return {priceTotal:146};}break;
		}
		return {priceTotal:0};
	}
	this.getSSDWEObject = function()
	{
		switch(this.APSSDWE().text)
		{
			case "250 SSDWE $40.00":{return {priceTotal:40};}break;
			case "500 SSDWE $65.00":{return {priceTotal:65};}break;
			case "1000 SSDWE $105.00":{return {priceTotal:105};}break;
			case "2000 SSDWE $170.00":{return {priceTotal:170};}break;
		}
		return {priceTotal:0};
	}
	this.getAPChequeBinderObject = function()
	{
		switch(this.APChequeBinder().text)
		{
			case "1 Per Page Binder $22.00":{return {priceTotal:22};}break;
			case "2 Per Page Binder $24.00":{return {priceTotal:24};}break;
		}
		return {priceTotal:0};
	}
	this.getAPSelfLinkingShtamp = function()
	{
		switch(this.APSelfLinkingStamp().text)
		{
			case "One - Self Inking Stamp $34.90":{return {priceTotal:34.9};}break;
			case "Two - Self Inking Stamps $65.50":{return {priceTotal:65.5};}break;
			case "Three - Self Inking Stamps $98.50":{return {priceTotal:98.5};}break;
		}
		return {priceTotal:0};
	}
	this.setADditionalProductsSetInputs__seeIfIsFirstSelected = function(cb)
	{
		if(cb == null)return "";
		if(cb.selectedIndex == 0)return "";
		return cb.options[cb.selectedIndex].text;
	}
	//////////////////////////////////////////////////////////////////////////////////////////////////////////////
	/////Showing all texts from CompanyInfo to cheque
	this.showAllTextsOnCheque = function()
	{
		this.CompanyNameAddress_showOnCheque();
		this.bankInfoShowToCheque();
		this.usFundsShowOnCheque();
		this.showHideSecondSignature();
		this.showTheNumbers();
	} 
}
var objCompanyInfo = new CompanyInfo();
CompanyInfo.CI = objCompanyInfo;
//////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////
////////Delivery
//////////////////////////////////////////////////////////////////////////////////
function Delivery()
{
	this.enumDelivery = ["Standard 5-7 bus days","Rush 24-48 hours($25 Charge)"];
	this.delivery = function()
	{
		if(document.getElementById("delivery_5_7_days").checked == true){return this.enumDelivery[0];}
		else if(document.getElementById("delivery_24_48_days").checked == true){return this.enumDelivery[1];}
		else return "";
	}
	
	this.RBDeliveryOnClick = function(rb)
	{
		/*is for old*/
		if(rb == document.getElementById("delivery_5_7_days"))
		{
			document.getElementById("deliveryINPUT").value = this.enumDelivery[0];
			document.getElementById("delivery_24_48_days").checked = false;
		}
		else
		{
			document.getElementById("deliveryINPUT").value = this.enumDelivery[1];
			document.getElementById("delivery_5_7_days").checked = false;
		}
		/*is for new
		if(rb == document.getElementById("standard_8to10_business_days"))
		{
			$(".loadingDeliveryDetailsText").html("Standard 8-10 Business Days");
			$.post(HELPER.H.PATH_TO_THEME+"/php/tools.php", {}, function(data)
			{
			});
		}
		else if(rb == document.getElementById("rush_25charge_1to5_business_days"))
		{
			$(".loadingDeliveryDetailsText").html("Rush");
		}
		else if(rb == document.getElementById("shipping_to_bo_box"))
		{
			$(".loadingDeliveryDetailsText").html("Shipping to B.O. BOX");
		}
		this.showPreloaderOnLoadingDeliveryDetails();
		*/
		OrderTotalAmount.OTA.calculate();
	}
	this.RBDelivery = function()
	{
	}
	this.showPreloaderOnLoadingDeliveryDetails = function()
	{
		$("#loadingDeliveryDetails").removeClass("displayNone");
		$("#loadingDeliveryDetails").animate({opacity:1}, 500, function()
		{
			setTimeout(function()
			{
				Delivery.D.hideThePreloaderAfterLoadingTheDetails();
			}, 1000);
		});
	}
	this.hideThePreloaderAfterLoadingTheDetails = function()
	{
		$("#loadingDeliveryDetails").animate({opacity:0}, 500, function()
		{
			$("#loadingDeliveryDetails").addClass("displayNone");
		});
	}
}
var deliveriOBJ = new Delivery();
Delivery.D = deliveriOBJ;
//////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////
////////MOP
//////////////////////////////////////////////////////////////////////////////////
function MOP()
{
	this.mop_vars = new Array({cb_id:'MOP_Visa', text:'Visa'},{cb_id:'MOP_Mastercart', text:'Mastercard'},
							  {cb_id:'MOP_directDebit', text:'Direct Debit'});
	this.mop = "";//Method of payment
	this.mopCB = null;
	this.cardNumber = null; 
	this.expMonth = null;
	this.expYear = null;
	this.callMe = false;
	this.csv = "";

	this.addEventListenerToCB = function()
	{
		for(var i=0;i<this.mop_vars.length;i++)
		{
			document.getElementById(this.mop_vars[i].cb_id).mopObj = this;
			document.getElementById(this.mop_vars[i].cb_id).index = i;
			document.getElementById(this.mop_vars[i].cb_id).onclick = function()
			{
				this.mopObj.selectPayment(this.index);
				this.mopObj.setVariablesForMOP();
				if(this.mopObj.mop_vars[this.index].cb_id == "MOP_directDebit")
				{
					$("#MOP_directDebit_signatureDIVHolder").removeClass( "displayNone" );
				}
				else
				{
					$("#MOP_directDebit_signatureDIVHolder").addClass( "displayNone" );
				}
			}
		}
		document.getElementById('MOP_cardNum').onkeyup = function()
		{
			this.value = this.value.replace (/\D/, '');
		}
		document.getElementById('MOPcsv').onkeyup = function()
		{
			this.value = this.value.replace (/\D/, '');
		}
	}
	this.selectPayment = function(index)
	{
		if(this.mopCB != null)this.mopCB.checked = false;
		document.getElementById(this.mop_vars[index].cb_id).checked = true;
		this.mopCB = document.getElementById(this.mop_vars[index].cb_id);
		this.mop = this.mop_vars[index].text;
	}
	this.getMOPVar = function()
	{
		if(this.mopCB == null)return 'No Payment Method Selected.';
		return this.mop_vars[this.mopCB.index].text;
	}
	this.getCardNumberVar =  function(){return ''+document.getElementById('MOP_cardNum').value;}
	this.getexpMonthVar = function()
	{
		var selectedIndex = document.getElementById('MOP_expMonth').selectedIndex;
		return document.getElementById('MOP_expMonth').options[selectedIndex].text;
	}
	this.getExpYearVar = function()
	{
		var selectedIndex = document.getElementById('MOP_expYear').selectedIndex;
		return document.getElementById('MOP_expYear').options[selectedIndex].text;
	}
	this.getCallMe = function()
	{
		var callMeText;
		document.getElementById('MOP_pleaseCallMe').checked == true?callMeText='Please call me for my Credit Card Number.':callMeText='I do not like to call me.';
		return callMeText;
	}
	this.getCSV = function()
	{
		this.csv = document.getElementById("MOPcsv").value;
		return this.csv;
	}
	this.getMOPCSVVar = function()
	{
		return 'MOP_CSV='+this.getCSV();
	}
	this.setVariablesForMOP = function()
	{
		//"mopINPUT", "mopExpirtyMonthINPUT", "mopExpirtyYearINPUT", "mopCallMe"
		document.getElementById("mopINPUT").value = this.getMOPVar();
		document.getElementById("mopExpirtyMonthINPUT").value = this.getexpMonthVar();
		document.getElementById("mopExpirtyYearINPUT").value = this.getExpYearVar();
		document.getElementById("mopCallMe").value = this.getCallMe();
	}
}
var objMOP = new MOP();
//////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////
////////SentEmail will be used for creating and sending emails
//////////////////////////////////////////////////////////////////////////////////
function SentEmail()
{
	this.additionalMessageWhenSubMit = "Submit Order?";
	this.objAjaxTool = new AjaxTOOL();
	this.formAction = "/php/tools.php";
	this.validate = function()
	{
		if(objContactInfo.validate() == false){return false;}
		if(BillingShipingModerator.BSM.validate()==false){return false;}
		return true;
	}
	this.SEND = function()
	{
		if(this.validate() == false){return;}
		if(confirm(this.additionalMessageWhenSubMit+""))
		{
			this.sendNormal();
			//this.sentAjax();
			//this.createOrder();	
		}
	}
	this.sendNormal = function()
	{
		document.getElementById("form").action = objHelper.PATH_TO_THEME+this.formAction;
		document.getElementById("form").submit();
	}
	this.sentAjax = function()
	{
		objPreloader.show();
		this.objAjaxTool = new AjaxTOOL( objHelper.PATH_TO_THEME+this.formAction, 
								function(e) 
								{
									if(objSentEmail.objAjaxTool.http.readyState == 4 && objSentEmail.objAjaxTool.http.status == 200) 
									{
										window.location.href = objHelper.URL+"/thankyou/";
										//window.location.href = "http://localhost/muhamed/cheque-wp/?page_id=70";
									}
									else
									{
										//alert(objSentEmail.objAjaxTool.http.readyState);
									}
								} );
		this.objAjaxTool.SEND();
	}
	this.createOrder = function()
	{
		objPreloader.show();
		this.objAjaxTool = new AjaxTOOL( objHelper.PATH_TO_THEME+this.formAction, 
										function(e)
										{
											if(objSentEmail.objAjaxTool.http.readyState == 4 && objSentEmail.objAjaxTool.http.status == 200) 
											{
												//alert(objSentEmail.objAjaxTool.http.responseText);
												//window.location.href = objHelper.URL+"/after_submit_info/";
												FGTCOBO.SEND( objSentEmail.objAjaxTool.http.responseText );
												objPreloader.hide();
											}
											else
											{
												//alert(objSentEmail.objAjaxTool.http.readyState);
											}
										} );
		this.objAjaxTool.SEND();
	}
}
function AjaxTOOL(urlTo_, event__onreadystatechange__)
{
	this.event__onreadystatechange = event__onreadystatechange__;
	this.http = new XMLHttpRequest();
	this.urlTo = urlTo_;
	this.params = function()
	{
		var pars = "";
		var inputs = document.getElementsByTagName('input');
		for (index = 0; index < inputs.length; ++index) 
		{
			pars += inputs[index].name+"="+inputs[index].value+"&";
		}
		return pars;
	}
	this.SEND = function()
	{
		this.http.open("POST", this.urlTo, true);
		this.http.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
		this.http.setRequestHeader("Content-length", this.params().length);
		this.http.setRequestHeader("Connection", "close");
		this.http.onreadystatechange = event__onreadystatechange__;
		this.http.send( this.params() );
	}
}
var objSentEmail = new SentEmail();
SentEmail.SE = objSentEmail;
//////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////
////////Cheque for creating and setting the mail
//////////////////////////////////////////////////////////////////////////////////
function Cheque()
{
	this.type = Cheque.LASER;
	this.cheque_render_holder = function(){return document.getElementById("cheque_render_holder");}
	this.cheque_render_holderHEIGHT = function(){return this.right_forms_holder().offsetHeight}
	this.cheque_holder = function(){return document.getElementById("cheque_holder");}
	this.right_forms_holder = function(){return document.getElementById("right_forms_holder");}
	this.cheque_render_holderABSOLUTE = function(){return document.getElementById("cheque_render_holderABSOLUTE");}
	this.cheque_render_holderABSOLUTEForTEMPLATE = function(){return document.getElementById("cheque_render_holderABSOLUTEForTEMPLATE");}
	
	this.setType = function(type_)
	{
		this.type = type_;
		switch(this.type)
		{
			case Cheque.LASER:{this.template = new LaserTemplates();}break;
			case Cheque.MANUAL:{this.template = new ManualTemplate();}break;
		}
	}
	this.render = function()
	{
		switch(this.type)
		{
			case Cheque.LASER:{this.renderLASER();}break;
			case Cheque.MANUAL:{this.renderMANUAL();}break;
		}
		objChequeColor.changeBG();
		objCompanyInfo.showAllTextsOnCheque();
	}
	this.renderLASER = function()
	{
		this.template.draw(objChequePosition.positionsIndex, this.cheque_render_holderABSOLUTEForTEMPLATE());
	}
	this.renderMANUAL = function()
	{
		this.template.draw(objChequePosition.manualX2Cheques(), this.cheque_render_holderABSOLUTEForTEMPLATE());
	}
	this.setSizeChequeHolder = function()
	{
		if(this.cheque_render_holder() == null){return;}
		if(this.cheque_render_holder().offsetHeight != this.cheque_render_holderHEIGHT())
		{
			this.cheque_render_holder().style.height = this.cheque_render_holderHEIGHT()+"px";
		}
	}
	this.tweenY = null;
	this.cheque_render_holderABSOLUTE_endY = function()
	{
		if(objHelper.scrollingYPoz()<=objHelper.absPositionY(this.cheque_render_holder())){return 0;}
		var endPozition = objHelper.scrollingYPoz()-objHelper.absPositionY(this.cheque_render_holder());
		if(endPozition + this.cheque_render_holderABSOLUTE().offsetHeight > this.cheque_render_holder().offsetHeight)
		{
			endPozition = this.cheque_render_holder().offsetHeight-this.cheque_render_holderABSOLUTE().offsetHeight;
		}
		return endPozition;
	}
	this.posicionSetAnimation = function()
	{
		if(this.cheque_render_holderABSOLUTE() == null)return;
		if(this.tweenY != null){this.tweenY.stop();}
		this.tweenY = new Tween(this.cheque_render_holderABSOLUTE().style,'top',Tween.strongEaseInOut,
		this.cheque_render_holderABSOLUTE().offsetTop,
			this.cheque_render_holderABSOLUTE_endY(),1,'px');
		this.tweenY.start();
	}
	this.fOnEnterFrame = function()
	{
		this.setSizeChequeHolder();
	}
}
Cheque.LASER = "laser";
Cheque.MANUAL = "manual";
var objCheque = new Cheque();
Cheque.C = objCheque;
Cheque.IS_FOR_ADMIN=false;

objHelper.addFunctionOnEnterFrame( objCheque );
window.onscroll = function()
{
	if(objCheque != null)
	{
		objCheque.posicionSetAnimation();
	}
}