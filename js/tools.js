function Eventor()
{
    this.events = [];
    this.add_event = function(type, f)
    {
        this.set_events_array(type);
        this.events[type].push(f);
    }
    this.remove_event = function(type, f)
    {
    }
    this.dispatch_event = function(type, data)
    {
        this.set_events_array(type);
        for (var i = 0; i < this.events[type].length; i++)
        {
            this.events[type][i](data);
        }
    }
    this.set_events_array = function(type)
    {
        if (this.events[type] == null)
            this.events[type] = [];
    }
}

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
		if(document.getElementById(cbID) == null){return;}
		$("#"+cbID).prop("selectedIndex", index);
	}
	this.setupComboBoxByText = function(cbID, text)
	{
		if(document.getElementById(cbID)==null){return;}
		for(var i=0;i<document.getElementById(cbID).length;i++)
		{
			if(document.getElementById(cbID).options[i].text == text)
			{
				$("#"+cbID).prop("selectedIndex", i)
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
			//alert("Please complete Contact Info Form");
			return false;
		}
		if($("#compInfoQuantity").prop("selectedIndex") == 0)
		{
			//alert("Please select Quantity & Prices.");
			return false;
		}
		if(objCheque.type == Cheque.LASER && $("#compInfoSoftware").prop("selectedIndex") == 0)
		{
			//alert("Please select Software.");
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
	this.quantityText = function()
	{
		return document.getElementById("compInfoQuantity").options
		[
		$("#compInfoQuantity").prop("selectedIndex")
		].text;
	}
	this.quantity = function()
	{
		return {index:$("#compInfoQuantity").prop("selectedIndex"), 
				 text:this.quantityText(),
				 money:this.quantityMONEY(),
				 quantityCountFree:this.quantityCountFree()};
	}
	this.quantity_variables = [];
	
	this.quantityObject = function()
	{
		return this.quantity_variables[this.quantityText()]; 
	}
	this.quantityMONEY = function()
	{
		return this.quantity_variables[this.quantityText()].price;
	}
	this.quantityTitle = function()
	{
		return this.quantity_variables[this.quantityText()].title;
	}
	this.quantityCountFree = function()
	{
		return this.quantity_variables[this.quantityText()].quantity;
	}
	this.shipping_variable = function()
	{
		return this.quantity_variables[this.quantityText()].shipping_variable;
	}
	this.addQuantintyOptions = function(  )
	{
		var counter = 0;
		for(var i in this.quantity_variables)
		{
			var value="";
			if(counter > 0)
			{
				value = i;
			}
			if(i=="Manual Cheques" && settings.IS_SEARCH_FORM==true)
			{
				$("#compInfoQuantity").append("<option>-</option>");
			}
			//alert(value);
			$("#compInfoQuantity").append("<option>"+i+"</option>");
			counter++;
		}
		$("#compInfoQuantity").change(function(e)
		{
			//alert($(this).val());
		});
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
		$("#color_info_for_hologram").html( this.pictureColor() );
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
		if(objCheque.type == Cheque.LASER)
		{
			switch(this.positionsIndex)
			{
				case 1:{return "TOP";}break;
				case 2:{return "MIDDLE";}break;
				case 3:{return "BOTTOM";}break;
			}
		}
		else if(objCheque.type == Cheque.MANUAL)
		{
			if(this.manualX2Cheques())
			{
				return "Two Per page";
			}
			else if(!this.manualX2Cheques())
			{
				return "One Per Page";
			}
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
		$("#color_info_for_hologram_cheque_position").html( this.positionName() );
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
		$("#color_info_for_hologram_cheque_position").html( this.positionName() );
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
		if($("#compInfoSecondName").val() != "" && !$("#compInfoCBShowSecondLine").prop("checked"))
		{
			$("#compInfoCBShowSecondLine").prop("checked", true)
		}
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
				if(document.getElementById("line1_topleftID_2") != null)
				{
					document.getElementById("line1_topleftID_2").style.top = "40px";
				}
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
				if(document.getElementById("line1_topleftID_2") != null)
				{
					document.getElementById("line1_topleftID_2").style.top = "25px";
				}
			}
		}
		
		if(this.name() != "")
		{  
		   document.getElementById("companyName_topleftID").innerHTML = this.name_StringHTML();
		   if(document.getElementById("companyName_topleftID_2") != null)
		   {
			   document.getElementById("companyName_topleftID_2").innerHTML = this.name_StringHTML();
		   }
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
		   {
			   document.getElementById("companyName_topleftID_2").innerHTML = "Your Company Name";
		   }
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
		if(objCheque.type == Cheque.MANUAL && document.getElementById("line1_topleftID_2"))
		{
			document.getElementById("line1_topleftID_2").innerHTML = this.adress_1()+'<br/>'+this.adress_2()+'<br/>'+this.adress_3()+'<br/>'+this.adress_4();
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
	this.logoPrice = function()
	{
		if(document.getElementById("compInfoAttachLogo_1").checked == true){return 15;}
		if(document.getElementById("compInfoAttachLogo_2").checked == true){return 90;}
		return 0;
	}
	this.logoTitle = function()
	{
		if(document.getElementById("compInfoAttachLogo_1").checked == true)
		{
			return "Black Ink Only $15 one time charge.";
		}
		if(document.getElementById("compInfoAttachLogo_2").checked == true)
		{
			return "Custom Color Logo minimum charge.";
		}
		return "";
	}
	this.list_logos_products = [];
	this.getOneTimeChargeLogoObject = function()
	{
		return this.list_logos_products["one_time_charge"];
	}
	this.getColoredLogoObject = function()
	{
		return this.list_logos_products["custom_color"];
	}
	this.getLogoObjectSelected = function()
	{
		if(document.getElementById("compInfoAttachLogo_1").checked == true){return this.getOneTimeChargeLogoObject();}
		if(document.getElementById("compInfoAttachLogo_2").checked == true){return this.getColoredLogoObject();}
		return {id:-1,price:0, discount:0, price_abs:function()
                    {
                    	return this.price-this.discount;
                   	}};
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
        this.load_bank_details_interval_index = -1;
        this.format_temp_account_number = "0";
        this.format_temp_account_number_info = function()
        {
            var info = "";
            for(var i=0;i<this.format_temp_account_number.length;i++)
            {
                if(this.format_temp_account_number[i] == " ")
                {
                    info += "_";
                }
                else if(this.format_temp_account_number[i] == "-")
                {
                    info += "-";
                }
                else
                {
                    info += "N";
                }
            }
            return info;
        }
        this.format_temp_account_length = function()
        {
            var length = 0;
            for(var i=0;i<this.format_temp_account_number.length;i++)
            {
                if(!isNaN(parseFloat(this.format_temp_account_number[i])))
                {
                    length++;
                }
            }
            return length;
        }
        this.account_number_input_is_just_numbers = function()
        {
            for(var i=0;i<$("#compInfoAccountNumber").val().length;i++)
            {
                if(isNaN(parseFloat($("#compInfoAccountNumber").val()[i])))
                {
                    return false;
                }
            }
            return true;
        }
        this.check_account_number_if_is_good = function()
        {
            if($("#cb_ovverride_default_bank_layout").prop("checked")){return true;}
            if(this.format_temp_account_number == "0"){return true;}
            if(this.format_temp_account_length() == $("#compInfoAccountNumber").val().length
        && this.account_number_input_is_just_numbers())
            {
                return true;
            }
            for(var i=0;i<this.format_temp_account_number.length;i++)
            {
                if(this.format_temp_account_number[i] == " " && 
                        this.format_temp_account_number[i] != $("#compInfoAccountNumber").val()[i])
                {
                    return false;
                }
                else if(this.format_temp_account_number[i] == "-" &&
                        this.format_temp_account_number[i] != $("#compInfoAccountNumber").val()[i])
                {
                    return false;
                }
                else if(isNaN($("#compInfoAccountNumber").val()[i]) && 
                        $("#compInfoAccountNumber").val()[i] != " " && 
                        $("#compInfoAccountNumber").val()[i] != "-")
                {
                    return false;
                }
            }
            //$("#compInfoAccountNumber").val()
            //for(var i=0;i<this.format_temp_account_number){}
            return true;
        }
        this.load_bank_details = function()
        {
            clearTimeout(this.load_bank_details_interval_index);
            setTimeout("CompanyInfo.CI.load_bank_details_abs();", 500);
        }
        this.load_bank_details_abs = function()
        {
            $.post(settings.URL_TO_PHP_TOOLS, 
            {
                LOAD_DETAILS_FOR_THE_BANK:"true",
                institution:$("#compInfoTransitNumber").val(),
                brunch:$("#compInfoBrunchNumber").val()
                
            }, function(data)
            {
                var xml_data = $.parseXML(data);
                CompanyInfo.CI.format_temp_account_number = $(xml_data).find("base_account_number").text();
                //alert(CompanyInfo.CI.format_temp_account_number);
                if(CompanyInfo.CI.format_temp_account_number == "0")
                {
                }
                else
                {
                    $("#compInfoAccountNumber").val($(xml_data).find("base_account_number").text());
                }
                if($(xml_data).find("id").text() == "-1")
                {
                    $("#compInfoBankName").val( "" );
                    $("#compInfoBankAddress1").val( "" );
                    $("#compInfoBankAddress2").val( "" );
                    $("#compInfoBankAddress3").val( "" );
                    $("#compInfoBankAddress4").val( "" );
                }
                else
                {
                    $("#compInfoBankName").val( $(xml_data).find("bank_name").text() );
                    $("#compInfoBankAddress1").val( $(xml_data).find("address1").text() );
                    $("#compInfoBankAddress2").val( $(xml_data).find("address2").text() );
                    $("#compInfoBankAddress3").val( $(xml_data).find("address3").text() );
                    $("#compInfoBankAddress4").val( $(xml_data).find("address4").text() );
                }
                CompanyInfo.CI.bankInfoShowToCheque();
            });
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
			if($("#add_45_after_account_yes").prop("checked"))
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
			/*
			$("#brojceDesno45").removeClass("displayNone");
			if(document.getElementById("brojceDesno45_2") != null)
			{
				$("#brojceDesno45_2").removeClass("displayNone");
			}*/
		}
		else
		{
			/*
			$("#brojceDesno45").addClass("displayNone");
			if(document.getElementById("brojceDesno45_2") != null)
			{
				$("#brojceDesno45_2").addClass("displayNone");
			}*/
		}
	}
	////////////////////////////////////////////////////////////////////////////////
	////Pricing, Quantity & Cheque Info
								
	this.software = function()
	{
		return {index:$("#compInfoSoftware").prop("selectedIndex"), 
				 text:document.getElementById("compInfoSoftware").options[$("#compInfoSoftware").prop("selectedIndex")].text};
	}
	this.onSowtaferSELECTChanging = function()
	{
	   document.getElementById("softwareINPUT").value = this.software().text+";"+this.software().index;
	   document.getElementById("softwareINPUTIndex").value = this.software().index;
	   var selectedIndex = $("#compInfoSoftware").prop("selectedIndex");
	   if(document.getElementById("compInfoSoftware").options[selectedIndex].text == 'Other')
	   {
		   document.getElementById("compInfoOtherSoftwer").innerHTML = 'Enter Software<br> <input type=text id="compInfoEnterOtherSoftware" name="compInfoEnterOtherSoftware" class="validate[required]" style="width:100%; margin-bottom:2px;margin-top:2px;" />';
		   $("#form").validationEngine();
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
		if($("#compInfoSoftware").prop("selectedIndex") == 4)
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
		   document.getElementById("compInfoIncludeEnvelopes_supplierINPUT").innerHTML = 
                           'Enter Your Supplier<br> <input type=text id="compInfoClientSupplier" name="compInfoClientSupplier" \n\
                    style=" margin-bottom:10px; width:95%;" />';
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
	this.SIGNATURE_NONE = "SIGNATURE_NONE";
	this.SIGNATURE_x1 = "SIGNATURE_x1";
	this.SIGNATURE_x2 = "SIGNATURE_x2";
	this.isSecondSignature = function()
	{
		if($("#compInfox1Signatur").prop("checked"))
		{
			return this.SIGNATURE_x1;
		}
		else if($("#compInfoSecondSignatur").prop("checked"))
		{
			return this.SIGNATURE_x2;
		}
		return this.SIGNATURE_NONE;
	}
	this.showHideSecondSignature = function()
	{
		$("#isThereSecondSignature").val( ""+ this.isSecondSignature() );
		if(Cheque.IS_FOR_ADMIN==true){return;}
		$("#PER1_ID").css("visibility", "hidden");
		$("#PER1_ID_2").css("visibility", "hidden");
		$("#PER2_ID").css("visibility", "hidden");
		$("#PER2_ID_2").css("visibility", "hidden");
		$("#PERImeNaKompanijaID").css("visibility", "hidden");
		switch(this.isSecondSignature())
		{
			case this.SIGNATURE_NONE:
			{
			}break;
			case this.SIGNATURE_x1:
			{
				$("#PER2_ID").css("visibility", "visible");
				$("#PER2_ID_2").css("visibility", "visible");
				$("#PERImeNaKompanijaID").css("visibility", "visible");
				if(Cheque.C.type == Cheque.LASER)
				{
					$("#PERImeNaKompanijaID").css("top", "170px");
				}
			}break;
			case this.SIGNATURE_x2:
			{
				$("#PER1_ID").css("visibility", "visible");
				$("#PER1_ID_2").css("visibility", "visible");
				$("#PER2_ID").css("visibility", "visible");
				$("#PER2_ID_2").css("visibility", "visible");
				$("#PERImeNaKompanijaID").css("visibility", "visible");
				if(Cheque.C.type == Cheque.LASER)
				{
					$("#PERImeNaKompanijaID").css("top", "150px");
				}
			}break;
		}
		/*
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
		*/
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
        /*
         * this.account_number_situations is array that hold informations about 
         * account number acording to institution
         * 666 is dush
         * 0 is empthy space
         * It is loading from PHP class BankDetails::$ACCOUNT_NUMBER_SITUATIONS into file tools.php
         * @type Array
         */
        this.account_number_situations=[];
        /*
        this.account_number_situations["001"] = [4,666,3];
        this.account_number_situations["002"] = [5,666,2];
        this.account_number_situations["003"] = [3,666,3,666,1];
        this.account_number_situations["004"] = [4,666,7];
        this.account_number_situations["005"] = [4,666,3];
        this.account_number_situations["006"] = [2,666,3,666,2];
        this.account_number_situations["010"] = [2,666,5];
        */
	this.accountNumber = function(){return document.getElementById("compInfoAccountNumber").value;}
        this.resetAccountNumber_index_timer = -1;
        this.resetAccountNumber = function()
        {
            /*
            if($("#compInfoAccountNumber").val().length != 7)
            {
                return;
            }
            for(var i=0;i<$("#compInfoAccountNumber").val().length;i++)
            {
                if(isNaN($("#compInfoAccountNumber").val()[i])){return;}
                //if($("#compInfoAccountNumber").val().get)
            }
            var number = $("#compInfoAccountNumber").val().substring(0,3);
            number += "-";
            number += $("#compInfoAccountNumber").val().substring(3,6);
            number += "-";
            number += $("#compInfoAccountNumber").val().substring(6,7);
            */
           clearTimeout(this.resetAccountNumber_index_timer);
           this.resetAccountNumber_index_timer = setTimeout("CompanyInfo.CI.resetAccountNumber_abs();", 500);
            /*
            $("#compInfoAccountNumber").val(number);
            this.showTheNumbers();
            */
        }
        this.resetAccountNumber_abs = function()
        {
            $.post(settings.URL_TO_PHP_TOOLS, 
            {
                get_formated_account_number_acording_to_institution:"Yes i will do it now",
                institution:$("#compInfoTransitNumber").val(),
                account_number_not_resetted:$("#compInfoAccountNumber").val()
            },function(data)
            {
                var xml_data_result = $.parseXML(data);
                $("#compInfoAccountNumber").val($(xml_data_result).find("reseted_account_number").text());
                //alert($(xml_data_result).find("reseted_account_number").text());
                CompanyInfo.CI.showTheNumbers();
            });
        }
        this.get_reset_account_number_acording_to_live_transit_and_brunch 
        = function(not_reseted_account)
        {
            $.post(settings.URL_TO_PHP_TOOLS, 
            {
                get_formated_account_number_acording_to_institution:"Yes i will do it now",
                institution:$("#compInfoTransitNumber").val(),
                account_number_not_resetted:not_reseted_account
            },function(data)
            {
                var xml_data_result = $.parseXML(data);
                CompanyInfo.CI.dispatch_event
                (
                CompanyInfo.ON_GET_FORMATED_ACCOUNT_NUMBER_ACORDING_TO_INSTITUTION,
                {
                    acc_number_formated:$(xml_data_result).find("reseted_account_number").text()
                }
                );
            });
        }
	this.showTheNumbers = function()
	{
		document.getElementById("startAtNumber_plus_1").value = this.startAt_plus_1();
		if(Cheque.IS_FOR_ADMIN==true){return;}
                /*
                 * Number setting of top right cheque corner
                 */
		//document.getElementById("brojceGoreDesnoID").innerHTML = "AAAA  "+this.startAt();
		$("#brojceGoreDesnoID .special_designation").html($("#special_designation").val().toLocaleUpperCase());
		$("#brojceGoreDesnoID .compInfoStartAt").html(this.startAt());
                if(document.getElementById("brojceGoreDesnoID_2") != null)
		{
			//document.getElementById("brojceGoreDesnoID_2").innerHTML = "AAAA  "+this.startAt_plus_1();
                        $("#brojceGoreDesnoID_2 .special_designation").html($("#special_designation").val().toLocaleUpperCase());
                        $("#brojceGoreDesnoID_2 .compInfoStartAt").html(this.startAt());
		}
                
		var divNumber1 = document.getElementById("brojcheLevoID");
		var divNumber2 = document.getElementById("brojcheCentarID");
		var divNumber3 = document.getElementById("brojcheDesnoID");
		if(objCheque.type == Cheque.LASER)
		{
			document.getElementById("levoBrojce1ID").innerHTML = this.startAt();
			document.getElementById("levoBrojce2ID").innerHTML = this.startAt();
		}
		else if(objCheque.type == Cheque.MANUAL)
		{
                    /*
                     * brojceGoreDesnoIDnew is number of the left part of manual cheque
                     */
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
		var num2 = "A"+num2_p1 + "D" + num2_p2+"A";
		var num2_innerHTML = num2;
	
		var num3 = this.accountNumber();
		var NUM3 = "";
		
		for(var iL=0;iL<num3.length;iL++)
		{
		   if(num3.charAt(iL) == 'D')NUM3+=   "D";
		   if(num3.charAt(iL) == '-')NUM3 +=   "D";
		   if(num3.charAt(iL) == ' ')NUM3 +=   " ";
		   if(isNaN(num3.charAt(iL)) == false)
		   {
			   NUM3= NUM3+ num3.charAt(iL);
		   }
		}
		//NUM3 = $.trim(NUM3);
		var num3_innerHTML = NUM3 + "C";
		var isThere45AfterAccount = "";
		if($("#add_45_after_account_yes").is(":checked"))
		{
			isThere45AfterAccount = " 45";
		}
		
		divNumber1.innerHTML = num1_innerHTML;
		divNumber2.innerHTML = num2_innerHTML+"&nbsp;"+num3_innerHTML+isThere45AfterAccount;
		//divNumber3.innerHTML = num3_innerHTML;
		divNumber3.innerHTML = "";
		if(document.getElementById("brojcheLevoID_2") != null)
		{
			document.getElementById("brojcheLevoID_2").innerHTML = "C"+this.startAt_plus_1()+"C";
			document.getElementById("brojcheCentarID_2").innerHTML = num2_innerHTML+"&nbsp;"+num3_innerHTML+isThere45AfterAccount;
			//document.getElementById("brojcheDesnoID_2").innerHTML = num3_innerHTML;
			document.getElementById("brojcheDesnoID_2").innerHTML = "";
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
		return {index:$("#compInfoDepositBooks").prop("selectedIndex"), 
				 text:this.setADditionalProductsSetInputs__seeIfIsFirstSelected(document.getElementById("compInfoDepositBooks"))};
	}
	this.APDWE = function()
	{
		if(document.getElementById("compInfoDWE")==null)return {index:-1, text:""};
		return {index:$("#compInfoDWE").prop("selectedIndex"), 
				 text:this.setADditionalProductsSetInputs__seeIfIsFirstSelected(document.getElementById("compInfoDWE"))};
	}
	this.APSSDWE = function()
	{
		if(document.getElementById("compInfoSSDWE")==null)return {index:-1, text:""};
		return {index:$("#compInfoSSDWE").prop("selectedIndex"), 
				 text:this.setADditionalProductsSetInputs__seeIfIsFirstSelected(document.getElementById("compInfoSSDWE"))};
	}
	this.APChequeBinder = function()
	{
		if(document.getElementById("compInfoChequeBinder")==null)return {index:-1, text:""};
		return {index:$("#compInfoChequeBinder").prop("selectedIndex"), 
				 text:this.setADditionalProductsSetInputs__seeIfIsFirstSelected(document.getElementById("compInfoChequeBinder"))};
	}
	this.APSelfLinkingStamp = function()
	{
		if(document.getElementById("compInfoSelfLinkingStamp")==null)return {index:-1, text:""};
		return {index:$("#compInfoSelfLinkingStamp").prop("selectedIndex"), 
				 text:this.setADditionalProductsSetInputs__seeIfIsFirstSelected(document.getElementById("compInfoSelfLinkingStamp"))};
	}
	/*
	this.getDepositDetailized = function()
	{
		return this.getDepositObject().copies+";"+this.getDepositObject().quantity+";"+this.getDepositObject().price+";"+
		this.getDepositObject().title;
	}*/
	
	this.depositBooks = [];
	/*
	this.depositBooks["Deposit Books"] = {copies:0,quantity:0, free:0, price:0, shipping_variable:"", title:"Deposit Books"};
	*/
	this.addAllDepositBooks = function()
	{
            $("#compInfoDepositBooks").html("");
		var counter = 0;
		for(var i in this.depositBooks)
		{
			$("#compInfoDepositBooks").append("<option value='"+counter+"'>"+i+"</option>");
			counter++;
		}
	}
	this.getDepositObject = function()
	{
		if(this.APDepositBooks().text == "")return {copies:0,quantity:0, free:0, price:0,discount:0, shipping_variable:"", title:"",
		price_abs:function()
                    {
                    	return this.price-this.discount;
                   	}};
		return this.depositBooks[this.APDepositBooks().text];
	}
        this.addAllDepositBooks__exeptx2Copies = function()
        {
            $("#compInfoDepositBooks").html("");
		var counter = 0;
		for(var i in this.depositBooks)
		{
                    if(counter <1 || counter > 6)
                    {
			$("#compInfoDepositBooks").append("<option value='"+counter+"'>"+i+"</option>"); 
                    }
			counter++;
		}
        }
        
	this.DWEList = [];
	/*
	this.DWEList["Double Window Envelopes (DWE)"] = {quantity:0, free:0, price:0, shipping_variable:"", title:"Double Window Envelopes (DWE)"};
	*/

	this.addDWWEList = function()
	{
		var counter = 0;
		for(var i in this.DWEList)
		{
			$("#compInfoDWE").append("<option value='"+counter+"'>"+i+"</option>");
			counter++;
		}
	}
	/*
	this.getAPDWEDetalized = function()
	{
		return this.getDWEObject().quantity+";"+this.getDWEObject().price+";"+this.getDWEObject().title+";"+this.getDWEObject().price_abs();
	}*/
	this.getDWEObject = function()
	{
		if(this.APDWE().text == "")return {quantity:0, free:0, price:0, discount:0, shipping_variable:"", title:"",
			price_abs:function()
                    {
                    	return this.price-this.discount;
                   	}};
		return this.DWEList[this.APDWE().text];
	}
	this.SSDWEList = [];
	/*
	this.SSDWEList["Self Seal Double Window Envelopes (SSDWE)"] = {quantity:0, price:0, title:"Self Seal Double Window Envelopes"};
	this.SSDWEList["250 SSDWE $55.00"] = {quantity:250, price:55, title:"250 SSDWE"};
	this.SSDWEList["500 SSDWE $81.00"] = {quantity:500, price:81, title:"500 SSDWE"};
	this.SSDWEList["1000 SSDWE $122.00"] = {quantity:1000, price:122, title:"1000 SSDWE"};
	this.SSDWEList["2000 SSDWE $189.00"] = {quantity:2000, price:189, title:"2000 SSDWE"};
	this.SSDWEList["3000 SSDWE $247.00"] = {quantity:3000, price:247, title:"2000 SSDWE"};
	this.SSDWEList["4000 SSDWE $310.00"] = {quantity:4000, price:310, title:"2000 SSDWE"};
	this.SSDWEList["5000 SSDWE $380.00"] = {quantity:5000, price:380, title:"2000 SSDWE"};
	*/
	
	this.addSSDWEList = function()
	{
		var counter = 0;
		for(var i in this.SSDWEList)
		{
			$("#compInfoSSDWE").append("<option value='"+counter+"'>"+i+"</option>");
			counter++;
		}
	}
	this.getSSDWEObject = function()
	{
		if(this.APSSDWE().text == "")return {quantity:0, price:0,discount:0, title:"",
		price_abs:function()
                    {
                    	return this.price-this.discount;
                   	}};
		return this.SSDWEList[this.APSSDWE().text];
	}
	/*
	this.getAPSSDWEDetalized = function()
	{
		 return this.getSSDWEObject().quantity+";"+this.getSSDWEObject().price+";"+this.getSSDWEObject().title+";"+this.getSSDWEObject().price_abs();
	}*/
	this.chequeBinderList = [];
	/*
	this.chequeBinderList["Cheque Binder"] = {quantity:0, price:0, title:"Cheque Binder"};
	this.chequeBinderList["1 Per Page Binder $22.00"] = {quantity:1, price:22, title:"1 Per Page Binder"};
	this.chequeBinderList["2 Per Page Binder $24.00"] = {quantity:2, price:24, title:"2 Per Page Binder"};
	*/
	this.addChesuwBinderList = function()
	{
		var counter=0;
		for(var i in this.chequeBinderList)
		{
			$("#compInfoChequeBinder").append("<option value='"+counter+"'>"+i+"</option>");
			counter++;
		}
	}
	this.getAPChequeBinderObject = function()
	{
		if(this.APChequeBinder().text == "")return {quantity:0, price:0,discount:0, title:"", price_abs:function()
                    {
                    	return this.price-this.discount;
                   	}};
		return this.chequeBinderList[this.APChequeBinder().text];
	}
	/*
	this.APChequeBinderDetailized = function()
	{
		return this.getAPChequeBinderObject().quantity+";"+this.getAPChequeBinderObject().price+";"+this.getAPChequeBinderObject().title;
	}*/
	this.SelfIncingStampList = [];
	/*
	this.SelfIncingStampList["Self Inking Stamp"] = {price:0, title:"Self Inking Stamp"};
	this.SelfIncingStampList["One - Self Inking Stamp $34.90"] = {price:34.9, title:"One - Self Inking Stamp"};
	this.SelfIncingStampList["Two - Self Inking Stamps $65.50"] = {price:65.5, title:"Two - Self Inking Stamps"};
	this.SelfIncingStampList["Three - Self Inking Stamps $98.50"] = {price:98.5, title:"Three - Self Inking Stamps"};
	*/
	this.addSelfIncingStampList = function()
	{
		var counter=0;
		for(var i in this.SelfIncingStampList)
		{
			$("#compInfoSelfLinkingStamp").append("<option value='"+counter+"'>"+i+"</option>");
			counter++;
		}
	}
	this.getAPSelfLinkingShtamp = function()
	{
		return this.SelfIncingStampList[this.APSelfLinkingStamp().text];
	}
	/*
	this.APSelfLinkingStampDetalized = function()
	{
		return this.getAPSelfLinkingShtamp().price+";"+this.getAPSelfLinkingShtamp().title;
	}*/
	this.setADditionalProductsSetInputs__seeIfIsFirstSelected = function(cb)
	{
		if(cb == null)return "";
		if(cb.selectedIndex == -1){cb.selectedIndex=0;}
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
CompanyInfo.prototype = new Eventor();
CompanyInfo.CI = new CompanyInfo();
CompanyInfo.ON_GET_FORMATED_ACCOUNT_NUMBER_ACORDING_TO_INSTITUTION =
        "ON_GET_FORMATED_ACCOUNT_NUMBER_ACORDING_TO_INSTITUTION";
//////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////
////////CreatingInvoiceForAdditionalProducts
//////////////////////////////////////////////////////////////////////////////////
function CreatingInvoiceForAdditionalProducts()
{
	this.object_invoice_data_send = function(type_action)
	{
		var object_data = 
		{
			chequeType:$("#chequeType").val(),
			
			CIEmail:$("#CIEmail").val(),
			
			CREATE_INVOICE_FOR_ADDITIONAL_PRODUCTS:type_action,
			orderNumber:$("#fso_order_number").val(),
			products_indexes:this.get_products_indexes(),
			
			hologram_U_P_no_yes:$("#hologram_U_P_no_yes").val(),
			
			backgroundINdex:$("#backgroundINdex").val(),
			chequePosition:$("#chequePosition").val(),
			
			companyName_TYPE_BILLING:$("#companyName_TYPE_BILLING").val(),
			contactName_TYPE_BILLING:$("#contactName_TYPE_BILLING").val(),
			
			address_1_TYPE_BILLING:$("#address_1_TYPE_BILLING").val(),
			address_2_TYPE_BILLING:$("#address_2_TYPE_BILLING").val(),
			address_3_TYPE_BILLING:$("#address_3_TYPE_BILLING").val(),
			city_TYPE_BILLING:$("#city_TYPE_BILLING").val(),
			province_TYPE_BILLING:$("#province_TYPE_BILLING").val(),
			postalCode_TYPE_BILLING:$("#postalCode_TYPE_BILLING").val(),
			email_TYPE_BILLING:$("#email_TYPE_BILLING").val(),
			
			phone_TYPE_BILLING:$("#phone_TYPE_BILLING").val(),
			CIPhone:$("#CIPhone").val(),
			
			companyName_TYPE_SHIPING:$("#companyName_TYPE_SHIPING").val(),
			contactName_TYPE_SHIPING:$("#contactName_TYPE_SHIPING").val(),
			
			contactName_TYPE_SHIPING:$("#contactName_TYPE_SHIPING").val(),
			address_1_TYPE_SHIPING:$("#address_1_TYPE_SHIPING").val(),
			address_2_TYPE_SHIPING:$("#address_2_TYPE_SHIPING").val(),
			address_3_TYPE_SHIPING:$("#address_3_TYPE_SHIPING").val(),
			
			city_TYPE_SHIPING:$("#city_TYPE_SHIPING").val(),
			province_TYPE_SHIPING:$("#province_TYPE_SHIPING").val(),
			postalCode_TYPE_SHIPING:$("#postalCode_TYPE_SHIPING").val(),
			phone_TYPE_SHIPING:$("#phone_TYPE_SHIPING").val(),
			CIPhone:$("#CIPhone").val(),
			email_TYPE_SHIPING:$("#email_TYPE_SHIPING").val(),
			mopINPUT:$("#mopINPUT").val(),
			MOP_cardNum:$("#MOP_cardNum").val(),
		
			province_TYPE_SHIPING:$("#province_TYPE_SHIPING").val(),
			shipping_price_INPUT:Delivery.D.getShippingStandardChargeObject().price_abs(),
			compInfoStartAt:$("#compInfoStartAt").val(),
			sales_person_code:SalesPersonCodes__OrderEntered.SPCOE.sales_person_code(),
			invoice_additiona_customer_code:$("#invoice_additiona_customer_code").val(),
			enter_email_address_for_invoice:$("#enter_email_address_for_invoice").val(),
			invoice_email_sent_to:$("#invoice_email_sent_to").val(),
			invoice_update_date:this.invoice_update_date(),
			
			sub_total_products_INPUT:$("#sub_total_products_INPUT").val(),
			sub_total_taxes_INPUT:$("#sub_total_taxes_INPUT").val(),
			grand_total_INPUT:$("#grand_total_INPUT").val(),
			////////////////////////////////////////////////
			invoice_paid_or_outstanding:$("input:radio[name='invoice_paid_or_outstanding']:checked").val(),
			////////////////////////////////////////////////
			authorization_number:$("#authorization_number").val(),
			batch_number:$("#batch_number").val(),
			receipt_number:$("#receipt_number").val(),
			//receipt_comments:$("#receipt_comments").val(),//client told me to remove this and to use invoice comments...If he agree this after
			//longer time please remove this field
			receipt_amount:$("#receipt_amount").val(),
			receipt_date:$("#receipt_date").val(),
			//receipt_method_of_payment:$("#receipt_method_of_payment").val()
			receipt_method_of_payment:MOP.M.mop,
			email_discount_code:$("#email_discount_code").val(),
			
			AIRMILES_cardNumber:$("#AIRMILES_cardNumber").val(),
			CIContactName:$("#CIContactName").val()
			
		};
		return object_data;
	}
	this.file_approval_temp = "";
	this.invoice_approval_temp = "";
	this.reset_approval_drop_box_empthy_init = function()
	{
		this.file_approval_temp = $("#file_approval_drop_down").val();
		this.invoice_approval_temp = $("#invoice_approval_drop_down").val();
	}
	this.reset_approval_drop_box_empthy = function()
	{
		this.reset_approval_drop_box_empthy_init();
		$("#file_approval_drop_down").val("");
		$("#invoice_approval_drop_down").val("");
	}
	this.reset_approval_drop_box = function()
	{
		$("#file_approval_drop_down").val( this.file_approval_temp );
		$("#invoice_approval_drop_down").val( this.invoice_approval_temp );
	}
	this.set_next_start_number = function()
	{
		var start_number = parseFloat
		(
			$("#compInfoStartAt").val()
		);
		//alert($("#compInfoStartAt").val());
		//alert(start_number);
		var count_zeroes = $("#compInfoStartAt").val().length - start_number.toString().length;
		var start_number_next = start_number+Quantity_and_Prices.QP.quantityObject().quantity+
						Quantity_and_Prices.QP.quantityObject().free;
		start_number_next = start_number_next.toString();
		for(var i=0;i<count_zeroes;i++)
		{
			start_number_next = "0"+start_number_next;
		}
 		$("#next_start_number_input").val( start_number_next );
	}
	this.invoice_update_date = function()
	{
			var date_invoice_update_date = $( "#order_updated_date_invoice" ).datepicker( "getDate" );
			if($("#order_updated_date_invoice").val() == "")
			{
				date_invoice_update_date = new Date();
			}
			return date_invoice_update_date.getTime();
	}
	this.create = function( type_action )
	{
		CreatingInvoiceForAdditionalProducts.TYPE = type_action;
		
		if(CreatingInvoiceForAdditionalProducts.TYPE == CreatingInvoiceForAdditionalProducts.TYPE_INVOICE)
		{
			if(	
				$("input:radio[name='invoice_paid_or_outstanding']:checked").val() == null
			)
			{
				alert( "Please check Paid or Outstanding." );
				return;
			}
			if(
			   $("#file_approval_drop_down").val() == ""
			   ||
			   $("#invoice_approval_drop_down").val() == ""
			   )
			{
				alert("Approval file and invoice need to be selected.");
				return;
			}
		}
		$.post(settings.URL_TO_PHP_TOOLS,
				this.object_invoice_data_send(type_action),
				function(data)
		{
			//alert(data);
			switch(CreatingInvoiceForAdditionalProducts.TYPE)
			{
				case CreatingInvoiceForAdditionalProducts.TYPE_INVOICE:
				{
					alert("Invoice is Created.");
				}break;
				case CreatingInvoiceForAdditionalProducts.TYPE_RECEIPT:
				{
					alert("Receipt is Created.");
				}break;
			}
		});
	}
	this.get_products_indexes = function()
	{
		var arr_products = 
		[
			Quantity_and_Prices.QP.quantityObject(),
			CompanyInfo.CI.getLogoObjectSelected(),
			CompanyInfo.CI.getDepositObject(),
			CompanyInfo.CI.getDWEObject(),
			CompanyInfo.CI.getSSDWEObject(),
			CompanyInfo.CI.getAPChequeBinderObject(),
			CompanyInfo.CI.getAPSelfLinkingShtamp(),
			Delivery.D.getShippingRushChargeObject()
		];
		var arr_prices_not_0 = [];
		for(var i=0;i<arr_products.length;i++)
		{
			if(arr_products[i].price > 0 && arr_products[i].additional_type == "rush_shipping_charge")
			{
				if($("#rush_25charge_1to5_business_days").prop("checked"))
				{
					arr_prices_not_0.push( arr_products[i] );
				}
			}
			else if(arr_products[i].price > 0)
			{
				arr_prices_not_0.push( arr_products[i] );
			}
		}
		var products_indexes = "";
		for(var i=0;i<arr_prices_not_0.length;i++)
		{
			if(i>0)
			{
				products_indexes += ",";
			}
			products_indexes += arr_prices_not_0[i].id;
		}
		return products_indexes;
	}
	this.setupIDs_and_Indexes_ForSubmit = function()
	{
		var IDs = "";
		var selectedIndexes = "";
		IDs = Quantity_and_Prices.QP.quantityObject().id+";";
		IDs += CompanyInfo.CI.getDepositObject().id+";"+ CompanyInfo.CI.getDWEObject().id+ 
		";" +CompanyInfo.CI.getSSDWEObject().id;
		selectedIndexes =  $("#compInfoQuantity").prop("selectedIndex")+";"
		selectedIndexes +=  $("#compInfoDepositBooks").prop("selectedIndex")+";"+$("#compInfoDWE").prop("selectedIndex")+
		";"+$("#compInfoSSDWE").prop("selectedIndex")
		if(objCheque.type == Cheque.MANUAL)
		{
			IDs += ";"+ CompanyInfo.CI.getAPChequeBinderObject().id;
			selectedIndexes += ";"+$("#compInfoChequeBinder").prop("selectedIndex");
		}
		else
		{
			IDs += ";-1";
			selectedIndexes += ";-1";
		}
		IDs += ";"+ CompanyInfo.CI.getAPSelfLinkingShtamp().id;
		IDs += ";"+CompanyInfo.CI.getLogoObjectSelected().id;
		IDs += ";"+ Delivery.D.getShippingRushChargeObject().id;
		selectedIndexes += ";"+$("#compInfoSelfLinkingStamp").prop("selectedIndex");
		selectedIndexes += ";-1";
		selectedIndexes += ";-1";
		/*
		document.getElementById("depositBooksINPUT").value = this.APDepositBooks().text;
		document.getElementById("depositBooksINPUT_VARs").value = this.getDepositDetailized();
		document.getElementById("DWEINPUT").value = this.getAPDWEDetalized();
		document.getElementById("SSDWEINPUT").value = this.getAPSSDWEDetalized();
		*/
		
		//"", "", "", "", "", ""
		/*
		$("#depositBooksINPUTIndex").val( $("#compInfoDepositBooks").prop("selectedIndex") );
		$("#DWEINPUTIndex").val( $("#compInfoDWE").prop("selectedIndex") );
		$("#SSDWEINPUTIndex").val( $("#compInfoSSDWE").prop("selectedIndex") );
		
		if(objCheque.type == Cheque.MANUAL)
		{
			document.getElementById("chequeBinderINPUT").value = this.APChequeBinderDetailized();
			$("#chequeBinderINPUTIndex").val( $("#compInfoChequeBinder").prop("selectedIndex") );
		}
		else
		{
		}
		document.getElementById("SelfLinkStampINPUT").value = this.APSelfLinkingStampDetalized();
		$("#SelfLinkStampINPUTIndex").val( $("#compInfoSelfLinkingStamp").prop("selectedIndex") );
		*/
		$("#additional_products_IDs").val(IDs);
		$("#additionalProducts_indexes").val(selectedIndexes);
		OrderTotalAmount.OTA.calculate();
	}
	//this.setADditionalProductsSetInputs = function(){}
	this.invoice_path_for_viewing = function()
	{
		//var date = new Date();
		/*
		alert(settings.WEBSITE_TO_ORDERS_ORDERS_FOLDER_PATH);
		alert(date.valueOf());
		alert($("#fso_order_number").val());*/
		/*old path when i was loading created invoice file...now that file have not access, and i am creating temp pdf and i am opening it.
		 * A little complicated but that it is :).
		 
		var path =  
		settings.URL_TO_PDF_VIEWER_TOOL+"invoices/"+$("#fso_order_number").val()+"-invoice.pdf?"+date.valueOf();
		*/
		var object_for_sending = this.object_invoice_data_send("-");
		object_for_sending["pdf_type"] = "InvoicePDFList";
		/*
		for(var i in object_for_sending)
		{
			alert(i+":"+object_for_sending[i]);
		}
		*/
		var path = settings.URL_TO_PDF_VIEWER_TOOL+"?"+$.param(object_for_sending);
		//alert(path);
		return path;
	}
	this.set_invoice_comment_depend_of_the_mop = function()
	{
    		/*
    		 
	this.mop_vars = new Array({cb_id:'MOP_Visa', text:'Visa'},{cb_id:'MOP_Mastercart', text:'Mastercard'},
							  {cb_id:'MOP_directDebit', text:'Direct Debit'},
							  {cb_id:'MOP_Cash', text:'Cash'},
							  {cb_id:'MOP_Cheque', text:'Cheque'});
    		 * */
    		var tekst_for = "";
    		switch(MOP.M.mop)
    		{
    			case "Direct Debit":
    			{
    				tekst_for = "PAID PRE-AUTH DEBIT B#"+$("#batch_number").val();
    				//tekst_for = "PAID PRE-AUTH DEBIT B#"+$("#batch_number").val();
    				$("#receipt_number").val("B"+$("#batch_number").val());
    			}break;
    			case "Visa":
    			{
    				tekst_for = "PAID BY VISA #"+MOP.M.MOP_cardNum___last4Digits()+" AUTH#"+$("#authorization_number").val();
    				$("#receipt_number").val(MOP.M.MOP_cardNum___last4Digits()+"-"+$("#authorization_number").val());
    			}break;
    			case "Mastercard":
    			{
    				tekst_for = "PAID BY MC #"+MOP.M.MOP_cardNum___last4Digits()+" AUTH#"+$("#authorization_number").val();
    				$("#receipt_number").val(MOP.M.MOP_cardNum___last4Digits()+"-"+$("#authorization_number").val());
    			}break;
    		}
    		$("#invoice_additiona_customer_code").val( tekst_for );
	}
}
CreatingInvoiceForAdditionalProducts.CIFAP = new CreatingInvoiceForAdditionalProducts();
CreatingInvoiceForAdditionalProducts.TYPE_INVOICE = "TYPE_INVOICE";
CreatingInvoiceForAdditionalProducts.TYPE_RECEIPT = "TYPE_RECEIPT";
CreatingInvoiceForAdditionalProducts.TYPE = "";
//////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////
////////Delivery
//////////////////////////////////////////////////////////////////////////////////
function Delivery()
{
	this.enumDelivery = ["Standard 8-10 Business Days","1-5 Business Days"];
	this.delivery = function()
	{
		if(document.getElementById("standard_8to10_business_days").checked == true){return this.enumDelivery[0];}
		else if(document.getElementById("rush_25charge_1to5_business_days").checked == true){return this.enumDelivery[1];}
		else return "";
	}
	this.isRush = function(){return document.getElementById("rush_25charge_1to5_business_days").checked;}
	
	this.list_of_rush_shipping = [];
	this.getShippingRushChargeObject = function()
	{
		return this.list_of_rush_shipping["rush_shipping_charge"];
	}
	/*
		this list is always changable
	*/
	this.list_of_standard_shipping_products = [];
	this.list_of_standard_shipping_products["standard_shipping_object_price"] = {price:0, discount:0, 
		price_abs:function()
		{
			return this.price-this.discount;
		}}; 
	this.getShippingStandardChargeObject = function()
	{
		return this.list_of_standard_shipping_products["standard_shipping_object_price"];
	}
	this.getShipingObject = function()
	{
		if(this.isRush()){return this.getShippingRushChargeObject();}
		return this.getShippingStandardChargeObject();
	}
	
	this.price = 0;
	
	this.setup_delivery_details = function(  )
	{
		/*is for old
		if(rb == document.getElementById("delivery_5_7_days"))
		{
			document.getElementById("deliveryINPUT").value = this.enumDelivery[0];
			document.getElementById("delivery_24_48_days").checked = false;
		}
		else
		{
			document.getElementById("deliveryINPUT").value = this.enumDelivery[1];
			document.getElementById("delivery_5_7_days").checked = false;
		}*/
		/*is for new*/
		document.getElementById("deliveryINPUT").value = this.delivery();
		if(document.getElementById("standard_8to10_business_days").checked == true)
		{
			$(".loadingDeliveryDetailsText").html("Standard 8-10 Business Days");
			$(".shippingChargeFormInfo").removeClass("displayNone");
		}
		else if(document.getElementById("rush_25charge_1to5_business_days").checked == true)
		{
			Delivery.D.price = 0;
			$(".shippingChargeFormInfoPrice").html( "$"+Delivery.D.price.toFixed(2) );
			
			/*
			$(".shippingChargeFormInfoPrice").html( "We will call you to go over Rush Shipping Costs." );
			*/
			$(".shippingChargeFormInfoPrice").html( "$0.00" );
			$(".shippingChargeFormInfo").removeClass("displayNone");
			$(".loadingDeliveryDetailsText").html("Rush");
			OrderTotalAmount.OTA.calculate();
		}
		if( document.getElementById("shipping_to_bo_box").checked == true)
		{
			$(".loadingDeliveryDetailsText").html("Shipping to B.O. BOX");
		}
		this.load_shipping_charges_amount(); 
		//this.showPreloaderOnLoadingDeliveryDetails();
		
		OrderTotalAmount.OTA.calculate();
	}
	this.is_changing_manual_shipping_details = false;
	this.load_shipping_charges_amount = function()
	{
			$.post(settings.URL_TO_PHP_TOOLS, 
			{
				GET_ALL_RATES_FOR_8to10_business_days_for_postal_code:$("#postalCode_TYPE_SHIPING").val()
			}, function(data)
			{
				//alert(data);
				//alert("data_"+Quantity_and_Prices.QP.shipping_variable());
				var xmlData = $.parseXML(data);
				var xmlPrice = $(xmlData).find("data_"+Quantity_and_Prices.QP.shipping_variable()).get(0);
				var xmlPostalCode = $(xmlData).find("data_postal_code").get(0);
				Delivery.D.price = 0;
				//alert(Quantity_and_Prices.QP.shipping_variable());
				//alert($(xmlPrice).text());
				/*
				 * Additional variable to see if the shipping object is for we 
				 * Will call option
				 * that is when shipping existing but the price is "-"
				 *  */
				Delivery.D.getShippingStandardChargeObject().isWeWillCall = false;
				
				if($(xmlPrice).text() != "-" && !isNaN(parseFloat( $(xmlPrice).text() )))
				{
					Delivery.D.price += parseFloat( $(xmlPrice).text() );
					//$(".shippingChargeFormInfoPrice").html( "$"+Delivery.D.price.toFixed(2) );
					Delivery.D.getShippingStandardChargeObject().price = parseFloat( $(xmlPrice).text() );
					Delivery.D.getShippingStandardChargeObject().postal_code = $(xmlPostalCode).text();
					Delivery.D.getShippingStandardChargeObject().variable = Quantity_and_Prices.QP.shipping_variable();
					//alert(12);
				}
				else
				{
					if($(xmlPrice).text() == "-")
					{
						Delivery.D.getShippingStandardChargeObject().isWeWillCall = true;
					}
					Delivery.D.getShippingStandardChargeObject().price = 0;
					Delivery.D.price = 0;
					$(".shippingChargeFormInfoPrice").html( "We will call to go over pricing." );
					if(Cheque.C.type == Cheque.LASER)
					{
					}
					else if(Cheque.C.type == Cheque.MANUAL)
					{
						//$(".shippingChargeFormInfoPrice").html( "$0.00" );
					}
				}
				//Quantity_and_Prices.QP.shipping_variable()
				$(".shippingChargeFormInfoCompany").html( $($(xmlData).find("data_Shipping_Company").get(0)).text()+"" );
				//$("#shipping_charge_select_company").value( $($(xmlData).find("data_Shipping_Company").get(0)).text()+"" );
				if(Delivery.D.is_changing_manual_shipping_details == true)
				{
					var postal_company_shipping =
					$($(xmlData).find("data_Shipping_Company").get(0)).text()+"";
					if(postal_company_shipping != "")
					{
						Delivery.D.select_shipping_via_option(postal_company_shipping+"");
					}
					else
					{
						Delivery.D.select_shipping_via_option("OTHER");
					}
				}
				//alert(Delivery.D.is_changing_manual_shipping_details);
				OrderTotalAmount.OTA.calculate();
			});
	}
	this.select_shipping_via_option = function(shipping_via_value)
	{
		//alert(12);
		//alert(shipping_via_value);
		if($("#shipping_charge_select_company").val() != shipping_via_value)
		{
			$('#shipping_charge_select_company > option[value="'+shipping_via_value+'"]').attr("selected", "selected");
		}
		if(shipping_via_value == "OTHER")
		{
			$("#shipping_price_INPUT_company").removeClass("displayNone");
			//$("#shipping_price_INPUT_company").val( "" );
		}
		else
		{
			//alert(shipping_via_value);
			$("#shipping_price_INPUT_company").addClass("displayNone");
			$("#shipping_price_INPUT_company").val( shipping_via_value );	
		}
			//$("#shipping_price_INPUT_company").removeClass("displayNone");
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
	this.setTo0Dollars = function()
	{
		this.price = 0;
		document.getElementById("standard_8to10_business_days").checked = false;
		document.getElementById("rush_25charge_1to5_business_days").checked = false;
		document.getElementById("shipping_to_bo_box").checked = false;
		$(".shippingChargeFormInfo").addClass("displayNone");
	}
	this.index_tryToSetupAfterDelay = null;
	this.tryToSetupAfterDelay = function()
	{
		//alert(120000);
		Delivery.D.is_changing_manual_shipping_details = true;
		if(this.index_tryToSetupAfterDelay != null)
		{
			clearTimeout( this.index_tryToSetupAfterDelay );
		}
		this.index_tryToSetupAfterDelay = setTimeout(function()
		{
			Delivery.D.setup_delivery_details();
		}, 200);
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
							  {cb_id:'MOP_directDebit', text:'Direct Debit'},
							  {cb_id:'MOP_Cash', text:'Cash'},
							  {cb_id:'MOP_Cheque', text:'Cheque'});
	this.mop = "";//Method of payment
	this.mopCB = null;
	this.cardNumber = null; 
	this.expMonth = null;
	this.expYear = null;
	this.callMe = false;
	this.csv = "";
	
	this.selected_payment_index = -1;
	
	this.addEventListenerToCB = function()
	{
		for(var i=0;i<this.mop_vars.length;i++)
		{
			$("#"+this.mop_vars[i].cb_id).attr("index", i);
			$("#"+this.mop_vars[i].cb_id).click(function(e)
			{
				MOP.M.selectPayment( $(this).attr("index") );
				MOP.M.setVariablesForMOP();
				if($(this).attr("id") == "MOP_directDebit")
				{
					$("#MOP_directDebit_signatureDIVHolder").removeClass( "displayNone" );
				}
				else
				{
					$("#MOP_directDebit_signatureDIVHolder").addClass( "displayNone" );
				}
			});
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
		this.selected_payment_index = index;
		if(this.mopCB != null)this.mopCB.checked = false;
		document.getElementById(this.mop_vars[index].cb_id).checked = true;
		this.mopCB = document.getElementById(this.mop_vars[index].cb_id);
		this.mop = this.mop_vars[index].text;
	}
	this.getMOPVar = function()
	{
		if(this.mopCB == null)return 'No Payment Method Selected.';
		return this.mop_vars[this.selected_payment_index].text;
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
		if(document.getElementById('MOP_pleaseCallMe').checked)
		{
			return "true";
		}
		return "false";
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
	$(document).ready(function(e)
	{
		/*
		 PAID BY VISA #nnnn AUTH# ______
								OR
								PAID BY MC #nnnn AUTH# ______
								OR
								PAID PRE-AUTH DEBIT B# ______
		 * */
    	$(".invoice_details").click(function(e)
    	{
    		CreatingInvoiceForAdditionalProducts.CIFAP.set_invoice_comment_depend_of_the_mop();
    	});
	});
	this.MOP_cardNum___last4Digits = function()
	{
		var number = $("#MOP_cardNum").val();
		if(number.length <= 4)
		{
			alert("Method of Payment, Card Number Error.Card Number is wrong formatted.");
			return number;
		}
		number = number.substring( number.length-4,  number.length);
		return number;
	}
}
//var objMOP = new MOP();
MOP.M = new MOP();
//////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////
////////SentEmail will be used for creating and sending emails
//////////////////////////////////////////////////////////////////////////////////
function SentEmail()
{
	this.additionalMessageWhenSubMit = "Submit Order?";
	this.objAjaxTool = new AjaxTOOL();
	this.formAction = "/php/tools.php";
	this.form_action = function(){return objHelper.PATH_TO_THEME+this.formAction;}
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
												//window.location.href = objHelper.URL+"/after_submit_info/";
												FGTCOBO.SEND( objSentEmail.objAjaxTool.http.responseText );
												objPreloader.hide();
											}
											else
											{
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
		CompanyInfo.CI.showAllTextsOnCheque();
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