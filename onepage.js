/**
** Parts of this code is written by Joomlaproffs.se Copyright (c) 2012, 2015 All Right Reserved.
** Many part of this code is from VirtueMart Team Copyright (c) 2004 - 2015. All rights reserved.
** Some parts might even be Joomla and is Copyright (C) 2005 - 2014 Open Source Matters, Inc. All rights reserved. 
** http://www.gnu.org/copyleft/gpl.html GNU/GPL, see LICENSE.php
** This source is free software. This version may have been modified pursuant
** to the GNU General Public License, and as distributed it includes or
** is derivative of works licensed under the GNU General Public License or
** other free or open source software licenses.
**
** THIS CODE AND INFORMATION ARE PROVIDED "AS IS" WITHOUT WARRANTY OF ANY 
** KIND, EITHER EXPRESSED OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE
** IMPLIED WARRANTIES OF MERCHANTABILITY AND/OR FITNESS FOR A
** PARTICULAR PURPOSE.

** <author>Joomlaproffs / Virtuemart team</author>
** <email>info@joomlaproffs.se</email>
** <date>2015</date>
*/

window.selectedpaymentid = 0;
var action = "";

jQuery(document).ready(function(){
								
	
	jQuery(".uk-alert").hide();
	jQuery("#system-message-container").hide();
	
	jQuery('#shiptopopup').on({
		'show.uk.modal': function()
		{
			 jQuery('#STsameAsBT').prop('checked', false);
		},
		  'hide.uk.modal': function(){
		   value = validateshipto("yes");
		   
		   if(value == true)
		   {
			  
		   }
		   else
		   {
			 jQuery("#shiptoicon").hide();
			 jQuery("#shiptobutton").removeClass("opg-button-primary");
			 jQuery('#STsameAsBT').prop('checked', true);
		   }
		}
	});

	jQuery(".refreshbutton").each(function(){
	   jQuery(this).click(function(){
			update_product();	
	 	});
	});


	jQuery("#shipmentset").click(function(){
		setshipment();
	});

	jQuery("#paymentset").click(function(){
		setpayment();
	});
	jQuery(".removeproduct").each(function(){
	   jQuery(this).click(function(){
			removeproduct(jQuery(this).attr("data-itemid"));
	   });
	});
	
	if(jQuery('#checkoutForm').length  > 0)
	{
		window.firsttime = 1;
		update_prices();
		Virtuemart.product(jQuery("div.product"));
	}
});




function validatecomment()
{
  if(jQuery("#commentpopup #customer_note_field").hasClass("required"))
  {
  
     comval = jQuery("#commentpopup #customer_note_field").val();
	 if(comval == "")
	 {
	    jQuery("#commentpopup #customer_note_field").addClass("opg-form-danger");
		jQuery("#commenticon").hide();
		jQuery("#commentbutton").removeClass("opg-button-primary");
	 }
	 else
	 {
	 	 jQuery("#commenticon").show();
		 jQuery("#commentbutton").addClass("opg-button-primary");
	     jQuery("#commentpopup #customer_note_field").removeClass("opg-form-danger");
	     updatecart();   
    	 jQuery("#commentclose").click();
	 }

  }
  else
  {
  	comval = jQuery("#commentpopup #customer_note_field").val();
	 if(comval == "")
	 { 
		 jQuery("#commenticon").hide();
		 jQuery("#commentbutton").removeClass("opg-button-primary");
		 updatecart();   
	     jQuery("#commentclose").click();
	 }
	 else
	 {	
		 jQuery("#commenticon").show();
		 jQuery("#commentbutton").addClass("opg-button-primary");
	     jQuery("#commentpopup #customer_note_field").removeClass("opg-form-danger");
    	 updatecart();   
	     jQuery("#commentclose").click();
	 }
  }
}

function removeshipto()
{
	 jQuery('#shipto_fields_div input').each(function() 
     {
		  elementid = jQuery(this).attr("id");
		  jQuery("#"+elementid).val("");
	 });
     jQuery('#STsameAsBT').prop('checked', true);
	 updatecart();   
     jQuery("#shiptoclose").click();
}

function validateshipto(returnval)
{
	var shipaddress_valid = true;
	if(jQuery('#STsameAsBT').prop('checked') ==true)
	{
	   jQuery("#shiptoicon").hide();
       jQuery("#shiptobutton").removeClass("opg-button-primary");
	  
	}
	else
	{
		var validator=new JFormValidator();
		jQuery('#shipto_fields_div input').each(function() {
			var validatefield = validator.validate(this);
			elementid = jQuery(this).attr("id");
			if(validatefield == false)
			{
			  shipaddress_valid = false;	 
			  jQuery("#"+elementid).addClass("opg-form-danger");
			}
			else
			{
			  jQuery("#"+elementid).removeClass("opg-form-danger");
			}
		});
		
		 country_ele2 = jQuery('#shipto_virtuemart_country_id');
		 if(jQuery('#shipto_virtuemart_country_id').length > 0)
		 {
	    	 var validatefield = validator.validate(country_ele2);
			 if(validatefield == false)
			 {
				  shipaddress_valid = false;
				  jQuery("#shipto_virtuemart_country_id").addClass("opg-form-danger");
		 	 }
			 else
			 {
			  jQuery("#shipto_virtuemart_country_id").removeClass("opg-form-danger");
		  	 }
		 }
		 state_ele2 = jQuery('#shipto_virtuemart_state_id');
		 if(jQuery('#shipto_virtuemart_state_id').length > 0)
		 {
	    	 var validatefield=validator.validate(state_ele2);
			 if(validatefield == false)	
			 {
				  shipaddress_valid = false;
				  jQuery("#shipto_virtuemart_state_id").addClass("opg-form-danger");
		 	 }	
			 else
			 {
				  jQuery("#shipto_virtuemart_state_id").removeClass("opg-form-danger");
		  	 }
		 }
	}
	if(returnval == "yes")
	{
	   return shipaddress_valid;
	}
	if(!shipaddress_valid) 
	{
	     jQuery("#shiptoicon").hide();
	     jQuery("#shiptobutton").removeClass("opg-button-primary");
		 return false;
	}
	else
	{
	   jQuery("#shiptoicon").show();
	   jQuery("#shiptobutton").addClass("opg-button-primary");
	   updatecart();   
	   jQuery("#shiptoclose").click();
	}
}


function changecheckout(val)
{

 if(val == 1)
  {
    jQuery("#regtitle").slideUp();
	jQuery("#guesttitle").slideDown();

	jQuery("#guestchekcout").addClass("opg-button-primary");
	jQuery("#regcheckout").removeClass("opg-button-primary");
	jQuery("#regicon").removeClass("opg-icon-check");
	jQuery("#guesticon").addClass("opg-icon-check");

	   jQuery('#register').attr('checked', false);
	   jQuery('#user_fields_div').hide();
	   window.lastvalue = 1;

    
  }
  if(val == 2)
  {
     jQuery("#regtitle").slideDown();
	 jQuery("#guesttitle").slideUp();
	 
	 jQuery("#guestchekcout").removeClass("opg-button-primary");
	 jQuery("#regcheckout").addClass("opg-button-primary");
	 jQuery("#regicon").addClass("opg-icon-check");
	 jQuery("#guesticon").removeClass("opg-icon-check");
	
	   jQuery('#register').attr('checked', true);
	   jQuery('#user_fields_div').show();
	   window.lastvalue = 2;
	
  }
}

function changemode(val)
{
  if(val == 1)
  {
    jQuery("#logindiv").slideDown();
	jQuery("#loginbtn").addClass("opg-button-primary");
	jQuery("#regbtn").removeClass("opg-button-primary");
	jQuery("#old_payments").slideUp();
	jQuery(".all_shopper_fields").slideUp();
	jQuery("#other-things").slideUp();
  }
  if(val == 2)
  {
     jQuery("#logindiv").slideUp();
	 jQuery("#loginbtn").removeClass("opg-button-primary");
	 jQuery("#regbtn").addClass("opg-button-primary");
	 jQuery("#old_payments").slideDown();
	 jQuery(".all_shopper_fields").slideDown();
	 jQuery("#other-things").slideDown();
  }
}



function strip_tags(str, allow) {
  // making sure the allow arg is a string containing only tags in lowercase (<a><b><c>)
  allow = (((allow || "") + "").toLowerCase().match(/<[a-z][a-z0-9]*>/g) || []).join('');

  var tags = /<\/?([a-z][a-z0-9]*)\b[^>]*>/gi;
  var commentsAndPhpTags = /<!--[\s\S]*?-->|<\?(?:php)?[\s\S]*?\?>/gi;
  return str.replace(commentsAndPhpTags, '').replace(tags, function ($0, $1) {
    return allow.indexOf('<' + $1.toLowerCase() + '>') > -1 ? $0 : '';
  });
}

function applycoupon() {
	
	jQuery("#loadingbutton").click();
	
	couponcode = jQuery("#coupon_code").val();
	jQuery.ajax({
        	type: "POST",
	        cache: false,
	        dataType: "json",
				url: window.vmSiteurl + "index.php?&option=com_virtuemart&view=cart&vmtask=applycoupon&couponcode=" + couponcode
	        }).done(
		    function (data, textStatus){
			   if(data.wrongcoupon)
			   {
				   var r = '<div class="opg-margin-small-top opg-alert opg-alert-warning" data-opg-alert><a href="" class="opg-alert-close opg-close"></a><p>' + data.couponMessage + "</p></div>";
				   jQuery("#customerror").html("");
				   jQuery("#customerror").show();
				   jQuery("#customerror").html(r);
				   window.location.hash='customerror';
			   }
			   else
			   {
				   var r = '<div class="opg-margin-small-top opg-alert opg-alert-success" data-opg-alert><a href="" class="opg-alert-close opg-close"></a><p>' + data.couponMessage + "</p></div>";
				   jQuery("#customerror").html("");
				   jQuery("#customerror").show();
				   jQuery("#customerror").html(r);
				   window.location.hash='customerror';
				   updatecart();
			   }
			   
			    jQuery("#loadingbtnclose").click();
	        });
}


function ajaxlogin()
{
 jQuery("#userlogin_username").removeClass("opg-form-danger");
 jQuery("#userlogin_password").removeClass("opg-form-danger");
 usernameval = document.getElementById("userlogin_username").value;
 passwordval = document.getElementById("userlogin_password").value;
 returnurlval = document.getElementById("returnurl").value;
 loginempty = document.getElementById("loginempty").value; 
 loginerror = document.getElementById("loginerrors").value; 
 if(usernameval == "" || passwordval == "")
 {
   if(usernameval == "")
   {
     jQuery("#userlogin_username").addClass("opg-form-danger");
   }
   if(passwordval == "")
   {
     jQuery("#userlogin_password").addClass("opg-form-danger");
   }
    var r = '<div class="opg-alert opg-alert-danger" data-opg-alert><a href="" class="opg-alert-close opg-close"></a><p>' + loginempty + "</p></div>";
	jQuery("#loginerror").show();
	jQuery("#loginerror").html(r);
 }
  else
  {
     jQuery("#loginerror").hide();
     var url= vmSiteurl+"index.php?option=com_virtuemart&view=cart";
	 url += "&vmtask=userlogin&username=" + encodeURIComponent(usernameval) + "&passwd=" + encodeURIComponent(passwordval) + "&return=" + encodeURIComponent(returnurlval); 
	  jQuery.ajax({
        	type: "POST",
	        cache: false,
    	    url:  url,
	       }).done(
			function (data, textStatus) 
			{
			  if(data == "error")
			  {
			     jQuery("#userlogin_username").addClass("opg-form-danger");
				 jQuery("#userlogin_password").addClass("opg-form-danger");
				 var r = '<div class="opg-alert opg-alert-danger" data-opg-alert><a href="" class="opg-alert-close opg-close"></a><p>' + loginerror + "</p></div>";
				 jQuery("#loginerror").show();
				 jQuery("#loginerror").html(r);
			  }
			  else
			  {
			    window.location.reload();
			  }
		    });
  }
}



function submit_order() {	

   jQuery("#loadingbutton").click();
   
   jQuery("#customerror").html("");
   errormsg = "";
   if(agree_to_tos_onorder == 1)
   {
	  if(jQuery("#squaredTwo").prop("checked") == false) 
	  { 
	      jQuery("div.squaredTwo").addClass("opg-form-danger");
	      jQuery("div.squaredTwo").addClass("errorcheck");
		  errormsg += "<p>"+acceptmeessage+"</p>";
	  }
	  else
	  {
	      jQuery("div.squaredTwo").removeClass("opg-form-danger");
		  jQuery("div.squaredTwo").removeClass("errorcheck");
	  }
   }
   if(showextraterms)
   {
	  if(jQuery("#privacy_checkbox").prop("checked") == false ) 
	  { 
	        errormsg += "<p>"+privacymeessage+"</p>";
	  }
   }
   minpurchase =  parseFloat(document.getElementById("minmumpurchase").value);
   carttotalunformat  = parseFloat(document.getElementById("carttotalunformat").value);
   if(minpurchase > 0 )
	{ 
	  if(minpurchase > carttotalunformat)
	  { 
		    errormsg += '<p>' + minpurchaseerror + '</p>';
	  }
	}
	var selected_shipment = false;
	var selected_payment = false;
	
	if(jQuery('#shipment_selection').length > 0)
	{
		
		jQuery("#shipment_selection input").each(function(){
			if(jQuery(this).prop('checked') == true || jQuery(this).attr('checked') == "checked")
			{
				selected_shipment= true;
			}	
		});

		if(selected_shipment==false) 
		{
			  errormsg += '<p>' + selectshipment + '</p>';
		}
	}
	
	

   
		
	if(selected_payment==false) 
	{
		 errormsg += '<p>' + selectpayment + '</p>';
	}



	var validator = new JFormValidator();
	
    inputvalidation = true;
	if(onlyregistered)
	{
		jQuery('#user_fields_div input').each(function(){
			var validatefield = validator.validate(this);
			elementid = jQuery(this).attr("id");
			if(validatefield == false)
			{
			  inputvalidation = false;
			  jQuery("#"+elementid).addClass("opg-form-danger");
			}
			else
			{
			  jQuery("#"+elementid).removeClass("opg-form-danger");
			}
			
		});
     }

     jQuery('#billto_fields_div input').each(function(){
												 
		var validatefield = validator.validate(this);
		elementid = jQuery(this).attr("id");
		if(validatefield == false)
		{
		  inputvalidation = false;	 
		  jQuery("#"+elementid).addClass("opg-form-danger");
		}
		else
		{
		  jQuery("#"+elementid).removeClass("opg-form-danger");
		}
	 });
	 
   	 country_ele = jQuery('#virtuemart_country_id');
	 if(jQuery("#virtuemart_country_id").length > 0)
	 {
	     var validatefield = validator.validate(country_ele);
		 if(validatefield == false)
		 {
			  inputvalidation = false;
			  jQuery("#virtuemart_country_id").addClass("opg-form-danger");
 		 }
		 else
		 {
			  jQuery("#virtuemart_country_id").removeClass("opg-form-danger");
	  	 }
	 }
	 
	 state_ele = jQuery('#virtuemart_state_id');
	 if(jQuery("#virtuemart_state_id").length > 0)
	 {
	     var validatefield = validator.validate(state_ele);
		 if(validatefield == false)
		 {
			  inputvalidation = false;
			  jQuery("#virtuemart_state_id").addClass("opg-form-danger");
	 	 }
		 else
		 {
			  jQuery("#virtuemart_state_id").removeClass("opg-form-danger");
	  	 }
	}

    if(shipmentfileds > 0)
	{
		if(jQuery('#STsameAsBT').prop("checked") == true ) 
		{
			jQuery('#shipto_fields_div input').each(function() 
	   	    { 
			    inputid = jQuery(this).attr('id');
				var name= inputid.replace('shipto_','');
				if(jQuery("#billto_fields_div #"+name).length > 0)
				{
					jQuery(this).val(jQuery("#billto_fields_div #"+name).val());
				}

			});
		  	 if(jQuery("#virtuemart_country_id").length > 0 && jQuery("#shipto_virtuemart_country_id").length > 0)
		     {
				 jQuery("#shipto_virtuemart_country_id").val(jQuery("#virtuemart_country_id").val());
    		 }
		} 
		else
		{
			var validator=new JFormValidator();
			jQuery('#shipto_fields_div input').each(function(){
				var validatefield=validator.validate(this);
				elementid = jQuery(this).attr("id");
				if(validatefield == false)
				{
				  inputvalidation = false;	  
				  jQuery("#"+elementid).addClass("opg-form-danger");
				}
				else
				{
				  jQuery("#"+elementid).removeClass("opg-form-danger");
				}
			});
		
		 country_ele2 = jQuery('#shipto_virtuemart_country_id');
		 if(jQuery('#shipto_virtuemart_country_id').length > 0)
		 {
		     var validatefield =validator.validate(country_ele2);
			 if(validatefield == false)
			 {
				  inputvalidation = false;	  
				  jQuery("#shipto_virtuemart_country_id").addClass("opg-form-danger");
	 		 }
			 else
			 {
			  jQuery("#shipto_virtuemart_country_id").removeClass("opg-form-danger");
		  	 }
		 }
		 state_ele2 = jQuery('#shipto_virtuemart_state_id');
		 if(jQuery('#shipto_virtuemart_state_id').length > 0)
		 {
	    	 var validatefield=validator.validate(state_ele2);
			 if(validatefield == false)
			 {
				  inputvalidation = false;	  
				  jQuery("#shipto_virtuemart_state_id").addClass("opg-form-danger");
		 	 }	
			 else
			 {
				  jQuery("#shipto_virtuemart_state_id").removeClass("opg-form-danger");
		  	 }
		 }
	

		
	  }
	}
	if(!inputvalidation ||  errormsg != "") 
	{
		  if(!inputvalidation)
		  {
		 	  errormsg += "<p>"+invaliddata+"</p>";
		  }
		   var r = '<div class="opg-margin-small-top opg-alert opg-alert-warning" data-opg-alert><a href="" class="opg-alert-close opg-close"></a><p>' + errormsg + "</p></div>";
		   jQuery("#customerror").html("");
		   jQuery("#customerror").show();
		   jQuery("#customerror").html(r);
		   
		    jQuery("#loadingbtnclose").click();
		   
		    jQuery('html,body').animate({
	    	    scrollTop: jQuery("#customerror").offset().top},
    	    'slow');

			return;
	 }
		
	var register_state=true;

	if(jQuery('#register').prop("checked") == true ) {
		
	  register_state=false;
	  registerurl = "index.php?option=com_virtuemart&view=cart&vmtask=registeruser&"+token+"=1";	
	  jQuery.ajax({
        	type: "POST",
	        cache: false,
    	    url: window.vmSiteurl + registerurl,
			dataType: "json",
			data : jQuery("#billto_inputdiv :input").serialize()
       }).done(
	   function (data, textStatus) 
	   {
		   if(data.error && data.error==1) 
		   {
			      	erromsg = '<div data-opg-alert="" class="opg-alert opg-alert-warning"><a href="#" class="opg-alert-close opg-close"></a><p>'+data.message+'</p></div>';
					if(data.message != "")
					{
			 
					   jQuery("#customerror").html("");
					   jQuery("#customerror").show();
					   jQuery("#customerror").html(erromsg);
		   			   jQuery('html,body').animate({
				    	    scrollTop: jQuery("#customerror").offset().top},
    	    		   'slow');
					}
					jQuery("#loadingbtnclose").click();
					return false;
		   }
		   else
		   {
			     	 jQuery("#userlogin_username").removeClass("opg-form-danger");
				 	 jQuery("#userlogin_password").removeClass("opg-form-danger");
					 usernameval = document.getElementById("username_field").value;
					 passwordval = document.getElementById("password_field").value;
					 returnurlval = document.getElementById("returnurl").value;
					 
					 
				     var url= vmSiteurl+"index.php?option=com_virtuemart&view=cart";
					 url += "&vmtask=userlogin&username=" + encodeURIComponent(usernameval) + "&passwd=" + encodeURIComponent(passwordval) + "&return=" + encodeURIComponent(returnurlval); 
					  	datas = jQuery("#checkoutForm").serialize();
	 					datas = datas.replace("&task=confirm" , "");
	 					datas = datas.replace("&task=update" , "");
	 					datas = datas.replace("&task=user.login" , "");
					  jQuery.ajax({
					        	type: "POST",
						        cache: false,
					    	    url:  url,
						       }).done(
									function (data, textStatus) 
									{
										  if(data == "error")
										  {
											    jQuery("#loadingbtnclose").click();
										  }
										  else
										  {
											     jQuery.ajax({
					        							type: "POST",
												        cache: false,
														data : datas,
											    	    url: window.vmSiteurl + 'index.php?option=com_virtuemart&view=cart&vmtask=completecheckout',
														
												 }).done(
													 function (data, textStatus) 
													 {
														jQuery("#loadingbtnclose").click();
														jQuery("#checkoutForm").submit();
												     });
										  }
									});
			   
		   }
		   
	   });
	
   } // if register button checked else
   else
   {
	   datas = jQuery("#checkoutForm").serialize();
	 	datas = datas.replace("&task=confirm" , "");
	 	datas = datas.replace("&task=update" , "");
	 	datas = datas.replace("&task=user.login" , "");
       jQuery.ajax({
				type: "POST",
		        cache: false,
				data : datas,
	    	    url: window.vmSiteurl + 'index.php?option=com_virtuemart&view=cart&vmtask=completecheckout',
		 }).done(
			 function (data, textStatus) 
				 {
					jQuery("#loadingbtnclose").click();
					jQuery("#checkoutForm").submit();
		 });
   }

}
function update_product() 
{
	jQuery("#loadingbutton").click();
	jQuery.ajax({
				type: "POST",
		        cache: false,
	    	    url: window.vmSiteurl + 'index.php?option=com_virtuemart&view=cart&vmtask=ajaxupdate',
				dataType: "json",
				data : jQuery("#allproducts :input").serialize()
		 }).done(
			 function (data, textStatus){
				 if(data.error) 
				 {
				   qtytext = "#quantity_"+data.vmid;
				   jQuery(qtytext).val(data.defaultqty);
				   var r = '<div class="opg-margin-small-top opg-alert opg-alert-warning" data-opg-alert><a href="" class="opg-alert-close opg-close"></a><p>' + data.msg + "</p></div>";
				   jQuery("#customerror").html("");
				   jQuery("#customerror").show();
				   jQuery("#customerror").html(r);
				   jQuery('html,body').animate({
				    	    scrollTop: jQuery("#customerror").offset().top},
    	    	   'slow');
				   jQuery("#loadingbtnclose").click();
				 }
				 else
				 {
					if (jQuery(".vmCartModule")[0]) 
					{
						 currentview = "";
                    	 Virtuemart.productUpdate(jQuery(".vmCartModule"), currentview);
                    }  
					var r = '<div class="opg-margin-small-top opg-alert opg-alert-success" data-opg-alert><a href="" class="opg-alert-close opg-close"></a><p>' + productupdate + "</p></div>";
				   jQuery("#customerror").html("");
				   jQuery("#customerror").show();
				   jQuery("#customerror").html(r);
				   jQuery('html,body').animate({
				    	    scrollTop: jQuery("#customerror").offset().top},
    	    	   'slow')
				   update_prices();
				 }
	 	 });
}
function update_prices()
{
	window.firsttime = 2;
	jQuery.ajax({
				type: "POST",
		        cache: false,
	    	    url: window.vmSiteurl +  'index.php?option=com_virtuemart&view=cart&vmtask=ajaxprice',
				dataType: "json"
		 }).done(
			 function (data, textStatus){
				 if(data.error) 
				 {
				 }
				 else
				 {

					 jQuery.each(data.products, function(id, product) {
						 if(show_tax)
						 {
	    	                 if (jQuery('#subtotal_tax_amount_'+id).length > 0) 
							 {
								jQuery('#subtotal_tax_amount_'+id).html(data.products[id].subtotal_tax_amount); 
		             	     }
					     }
	                     if (jQuery('#subtotal_discount_'+id) ) 
						 {
	                        jQuery('#subtotal_discount_'+id).html(data.products[id].subtotal_discount);
		                 }
			             if (jQuery('#subtotal_with_tax_'+id) ) 
						 {
	                        jQuery('#subtotal_with_tax_'+id).html(data.products[id].subtotal_with_tax);
		                 }								 

					 });
				   
					if(data.salesPrice != "")
					{
					    jQuery("sales_pricefulldiv").show();
						jQuery('#sales_price').html(data.salesPrice);
			    	}
					else
					{
					   jQuery("sales_pricefulldiv").hide();
					}
				    if(show_tax)
				    {
			 		  jQuery('#shipment_tax').html(data.shipmentTax);
			 	    }
				    if(data.salesPriceShipment != "")
 				    { 
				      jQuery("#shipmentfulldiv").show();
					  jQuery('#shipment').html(data.salesPriceShipment);
			        }
			   	   else
				   {
				     jQuery("#shipmentfulldiv").hide();
				   }
				   if(show_tax)
				   {
				 	 jQuery('#payment_tax').html(data.paymentTax);
					 if(data.billTaxAmount != "")
				 	 {
				      	 jQuery("#total_taxfulldiv").show();
						 jQuery('#total_tax').html(data.billTaxAmount);
				     }
				     else
				     {
				        jQuery('#total_tax').html(data.billTaxAmount);
				        jQuery("#total_taxfulldiv").hide();
				     }
				 }
				jQuery('#payment').html(data.salesPricePayment);
				if(data.billDiscountAmount != "")
				{
				    jQuery("#total_amountfulldiv").show();
					jQuery('#total_amount').html(data.billDiscountAmount);
			    }
				else
				{
				   jQuery("#total_amountfulldiv").hide();
				}
				if(data.billTotal != "")
				{
				    jQuery("#bill_totalamountfulldiv").show();
					jQuery("#bottom_total").show();
					jQuery('#bill_total').html(data.billTotal);
					jQuery('#carttotal').html(data.billTotal);
					jQuery('#carttotalunformat').value = data.billTotalunformat;
				}
				else
				{
				    jQuery("#bill_totalamountfulldiv").hide();
					jQuery("#bottom_total").hide();
				}
				jQuery("#couponpricediv").hide();
				
				if(couponenable)
				{
					var coupontext = data.couponCode;
					if (data.couponDescr != '') 
					{
						coupontext += ' (' + data.couponDescr + ')';
					}
					if (data.salesPriceCoupon) 
					{
						 jQuery("#coupon_code_txt").html(coupontext);
						 jQuery("#couponpricediv").show();
					} 
					else 
					{
                        jQuery("#coupon_code_txt").html("");
						jQuery("#couponpricediv").hide();
					}
					if(show_tax)
					{
						if(data.couponTax) 
						{
							jQuery("#coupon_tax").html(data.couponTax);
						} 
						else 
						{
							jQuery("#coupon_tax").html('');
						}
					 }
					 if(data.salesPriceCoupon) 
					 {
						jQuery("#coupon_price").html(data.salesPriceCoupon);
					 }
					 else 
					 {
						jQuery("#coupon_price").html('');
					 }
			     } 
				 
				(function($){
				var klarna_id = $('#klarna_checkout_onepage').val();
				if (klarna_id != null) 
				{
					if (selected_payment == klarna_id) 
					{
					     if(customernote)
					     {
					        document.getElementById("extracommentss").style.display = "block";
				    	 }
					     $("#klarna-checkout-container").slideDown();
					     $('#otherpay_buttons').slideUp();
				  	     $('div.all_shopper_fields').slideUp();
					     $('div#other-things').slideUp();
					}
					else 
					{
					    $("#klarna-checkout-container").slideUp();
					    $('#otherpay_buttons').slideDown();
				        $('div.all_shopper_fields').slideDown();
					    $('div#other-things').slideDown();
					};
			  }
			  else
			  {
				   //jQuery("#klarnadiv").hide();
   	          }
			})(jQuery);
			if (typeof window._klarnaCheckout != 'undefined') 
			{
				window._klarnaCheckout(function (api) {
	        	api.resume();
			  	});
			};
				 
			
			jQuery("#loadingbtnclose").click();
		}
			
		 });
}
function removeproduct(vmproductid)
{
	     jQuery("#loadingbutton").click();
		 jQuery.ajax({
				type: "POST",
		        cache: false,
	    	    url: window.vmSiteurl + 'index.php?option=com_virtuemart&view=cart&vmtask=deleteproduct&vmproductid='+vmproductid,
				dataType: "json"
		 }).done(
			 function (data, textStatus){
				 if(data.error) 
				 {
				 }
				 else
				 {
				   deletemsg = removeprouct;
				   var r = '<div class="opg-alert opg-alert-warning" data-opg-alert><a href="" class="opg-alert-close opg-close"></a><p>' + deletemsg + "</p></div>";
				   jQuery("#customerror").html("");
				   jQuery("#customerror").show();
				   jQuery("#customerror").html(r);
					document.id('product_row_'+vmproductid).destroy();
					mod=jQuery(".vmCartModule");
					jQuery.getJSON(vmSiteurl+"index.php?option=com_virtuemart&nosef=1&view=cart&task=viewJS&format=json"+vmLang,
						function(datas, textStatus) {
							if (datas.totalProduct >0) {
								mod.find(".vm_cart_products").html("");
								jQuery.each(datas.products, function(key, val) {
									jQuery("#hiddencontainer .container").clone().appendTo(".vmCartModule .vm_cart_products");
									jQuery.each(val, function(key, val) {
										if (jQuery("#hiddencontainer .container ."+key)) 
										{
											mod.find(".vm_cart_products ."+key+":last").html(val) ;
										}
									});
								});
								updatecart();
								mod.find(".total").html(datas.billTotal);
								mod.find(".show_cart").html(datas.cart_show);
							} else {
							    window.location.reload();
								mod.find(".vm_cart_products").html("");
								mod.find(".total").html(datas.billTotal);
							}
							mod.find(".total_products").html(datas.totalProductTxt);
						}
					);
				 }
		 });
			
}
function update_shipment()
{
	jQuery("#loadingbutton").click();
	jQuery.ajax({
				type: "POST",
		        cache: false,
	    	    url: window.vmSiteurl + 'index.php?option=com_virtuemart&view=cart&vmtask=ajaxshipment',
				dataType: "json"
		 }).done(
			 function (data, textStatus){
				 if(data.error) 
				 {
				 }
				 else
				 {
				    document.id('shipment_selection').empty();
					var shipments="";
					if(data.length == 0)
					{
					     jQuery("#shipment_fulldiv").html("");
						 newhtml = '<p id="shipmentnill" class="opg-text-warning"></p>';
						 jQuery("#shipment_fulldiv").html(newhtml);
					     country_ele = document.id('virtuemart_country_id');
					     if(country_ele != null)
						 {
						     var validator = new JFormValidator();
						     var cval2 =validator.validate(country_ele);
							 if(cval2 == false)
 							 {
								  shipmentnil  = chosecountry;
								  jQuery("#shipmentnill").html("");
								  jQuery("#shipmentnill").html(shipmentnil); 
 			 				 } 
							 else
							 {
								  shipmentnil  = noshipmethod;
								  jQuery("#shipmentnill").html("");
								  jQuery("#shipmentnill").html(shipmentnil);
						  	 }
						 }
						 else
						 {
							  shipmentnil  = noshipmethod;
							  jQuery("#shipmentnill").html("");
							  jQuery("#shipmentnill").html(shipmentnil);
						 }
					}
					else
					{
						 jQuery("#shipment_fulldiv").html("");
						 newhtml = '<table class="opg-table opg-table-striped" id="shipmenttable"><tr id="shipmentrow"><td id="shipmentdetails"></td></tr></table>';
					 jQuery("#shipment_fulldiv").html(newhtml);
					}
					if(data)
					{
					    shipments+= '<ul class="opg-list" id="shipment_ul">';
					    for(var i=0;i<data.length;i++) {
						   inputstr = data[i].toString();
						   var n = inputstr.search("checked"); 
						   if(n > 0)
						   {
						     var activeclasss = "liselected";
						   }
						   else
						   {
						     var activeclasss = "";
						   }
						   if(activeclasss != "")
						   {
							  texxt = data[i];
							  tmptxt = strip_tags(texxt, '<span><img>');
							  tmptxt = tmptxt.replace('</span><span', '</span><br /><span');
							  tmptxt = tmptxt.replace('vmshipment_description', 'vmshipment_description opg-text-small');
							  tmptxt = tmptxt.replace('vmshipment_cost', 'vmshipment_cost opg-text-small');
							  
							  document.id('shipmentdetails').set('html', tmptxt);
							  if(data.length > 1)
							  {
							    if(document.getElementById("shipchange") == null)
								{
								     jQuery("#shipchangediv").remove();
								     temptext = "";
								  	 temptext =  '<td id="shipchangediv" class="opg-width-1-4">';
								     target = "{target:'#shipmentdiv'}";
							         temptext += '<a class="opg-button opg-button-primary" href="#" data-opg-modal="'+target+'">';
									 temptext += changetext;
									 temptext += '</a></td>';
									 jQuery("#shipmentrow").append(temptext);
							    }
							  }
							  else
							  {
							    jQuery("#shipchangediv").remove();
							  }
						    } 
						    texxts = "";
							texxts = data[i];
							texxts = strip_tags(texxts, '<span><img><input>');
							texxts = texxts.replace('</span><span', '</span><br /><span');
							texxts = texxts.replace('vmshipment_description', 'vmpayment_description opg-text-small');
							texxts = texxts.replace('vmshipment_cost', 'vmpayment_cost opg-text-small');
	                        shipments+='<li class="'+activeclasss+'">';
							shipments+='<label class="opg-width-1-1">'+texxts+'</label>';
							shipments+='<hr class="opg-margin-small-bottom opg-margin-small-top" /></li>';
					    }
						shipments+='</ul>';
						oneshipmenthide = document.getElementById("oneshipmenthide").value;
						if(oneshipmenthide == "yes")
						{
						  if(data.length == 1)
						  {
						    jQuery("#shipment_select").addClass("opg-hidden");
						  }
						  else if(data.length > 1 ||  data.length == 0)
						  {
						    jQuery("#shipment_select").removeClass("opg-hidden");
						  }
						}
						
						document.id('shipment_selection').set('html','');
						jQuery("#shipmentclose").click();
					    document.id('shipment_selection').set('html',shipments);
					}
					var shipmentchecked=false;
					if(document.id('shipment_selection')) 
					{
						for(var i=0;i<document.id('shipment_selection').getElements('input').length;i++) 
						{
							if(document.id('shipment_selection').getElements('input')[i].checked==true) 
							{
								shipmentchecked=true;
								break;
			    		    }	
					    }
					}
					if(shipmentchecked == false)
					{
						 if(document.id('shipment_selection').getElements('input').length > 1)
						  {
						     autoshipid = document.getElementById("auto_shipmentid").value;
							 if(autoshipid > 0)
							 {
							    jQuery("#shipments #shipment_id_"+autoshipid).attr('checked', true);
								updatecart();
							 }
							 else
							 {
							   document.id('shipment_selection').getElements('input')[0].checked=true;
							   updatecart();
							 }
						  }
						  else  if(document.id('shipment_selection').getElements('input').length > 0)
						  {
						      document.id('shipment_selection').getElements('input')[0].checked=true;
							  updatecart();
						  }
					}
				
					update_prices();
			   }
		});
}
function updatepayment()
{
	jQuery("#loadingbutton").click(); 
	jQuery.ajax({
				type: "POST",
		        cache: false,
	    	    url: window.vmSiteurl + 'index.php?option=com_virtuemart&view=cart&vmtask=ajaxpayment',
				data : datas,
				dataType: "json"
		 }).done(
			 function (data, textStatus){
				 
				jQuery("#paymentsdiv").html("");
				if(data.length == 0)
				{
				     jQuery("#payment_fulldiv").html("");
					 newhtml = '<p id="paymentnill" class="opg-text-warning"></p>';
					 jQuery("#payment_fulldiv").html(newhtml);
					 
				     country_ele = document.id('virtuemart_country_id');
				     if(country_ele != null)
					 { 
					     var validator=new JFormValidator();
					     var cval2 =validator.validate(country_ele);
						 if(cval2 == false)
						 {
							  paymentnil  = chosecountry;
							  jQuery("#paymentnill").html("");
							  jQuery("#paymentnill").html(paymentnil); 
 		 				 } 
						 else
						 {
							  paymentnil  = nopaymethod;
							  jQuery("#paymentnill").html("");
							  jQuery("#paymentnill").html(paymentnil);
					  	 }
					 }
					 else
					 {
					 
					     paymentnil  = nopaymethod;
						 jQuery("#paymentnill").html("");
						 jQuery("#paymentnill").html(paymentnil);
					 }
				}
				else
				{
					 jQuery("#payment_fulldiv").html("");
					 newhtml = '<table class="opg-table opg-table-striped" id="paymentable"><tr id="paymentrow"><td id="paymentdetails"></td></tr></table>';
					 jQuery("#payment_fulldiv").html(newhtml);
				}
				var payments="";
				if(data) 
				{
				    payments+= '<ul class="opg-list" id="payment_ul">';
				    for(var i=0;i<data.length;i++) 
					{
						   inputstr = data[i].toString();
						   var s = inputstr.search("klarna-checkout-container"); 
						   if(s > 0)
						   {
						      //jQuery("#klarna-checkout-container").appendTo("#klarnadiv");
						   }
						   var n = inputstr.search("checked"); 
						   if(n > 0)
						   {
						      var activeclasss = "liselected";
					   	   }
					   	   else
					       {
					   		  var activeclasss = "";
					       }
						   if(activeclasss != "")
						   {
						      texxt = data[i];
							  tmptxt = strip_tags(texxt, '<span><img><div>');
							  
							  tmptxt = tmptxt.replace('klarna-checkout-container', 'klarna-checkout-containers_div');
							  tmptxt = tmptxt.replace('</span><span', '</span><br /><span');
							  tmptxt = tmptxt.replace('vmpayment_description', 'vmpayment_description opg-text-small');
							  tmptxt = tmptxt.replace('vmpayment_cost', 'vmpayment_cost opg-text-small');
							  document.id('paymentdetails').set('html', tmptxt);
								  
						 	  if(data.length > 1)
							  {	
							     if(document.getElementById("shipchange") == null)
							 	 {
								     jQuery("#paychangediv").remove();
							 	     temptext = "";
								  	 temptext =  '<td id="paychangediv" class="opg-width-1-4">';
									 target = "{target:'#paymentdiv'}";
							         temptext += '<a class="opg-button opg-button-primary" href="#" data-opg-modal="'+target+'">';
									 temptext += changetext;
									 temptext += '</a></td>';
									 jQuery("#paymentrow").append(temptext);
							     }
						   	 }
						  	 else
						   	 {
						   		 jQuery("#paychangediv").remove();
						  	 }
						   } 
						    
						   texxts = "";
						   texxts = data[i];
						   tmptxts = strip_tags(texxts, '<span><img><input><div>');
						   tmptxts = tmptxts.replace('klarna-checkout-container', 'klarna-checkout-containers_div');
						   tmptxts = tmptxts.replace('</span><span', '</span><br /><span');
						   tmptxts = tmptxts.replace('vmpayment_description', 'vmpayment_description opg-text-small');
						   tmptxts = tmptxts.replace('vmpayment_cost', 'vmpayment_cost opg-text-small');
						   payments+='<li class="'+activeclasss+'">';
						   payments+='<label class="opg-width-1-1">'+tmptxts+'</label>';
						   payments+="<hr class='opg-margin-small-bottom opg-margin-small-top' /></li>";
						 
			         }
					payments += "</ul>";
					
					onepayementhide = document.getElementById("onepaymenthide").value;
					if(onepayementhide == "yes")
					{
					  if(data.length == 1)
					  {
					    jQuery("#payment_select").addClass("opg-hidden");
					  }
					  else if(data.length > 1 ||  data.length == 0)
					  {
					    jQuery("#payment_select").removeClass("opg-hidden");
					  }
					}
					jQuery("#paymentclose").click();
				    document.id('paymentsdiv').set('html',payments);
			   }		
			   
			   
			 paymentchecked  = false;
			if(document.id('paymentsdiv')) 
			{
		      for(var i=0;i<document.id('paymentsdiv').getElements('input').length;i++) 
			   {
				if(document.id('paymentsdiv').getElements('input')[i].checked==true)
				 {  
				   val_id = document.id('paymentsdiv').getElements('input')[i].value;
				   jQuery("#payments #payment_id_"+val_id).attr('checked', true);
				   document.id('paymentsdiv').getElements('input')[i].checked=true;
				   paymentchecked=true;
			 	   break;
			     }
			   }
			}
			
			
			if(paymentchecked == false)
			{
			  if(document.id('paymentsdiv').getElements('input').length > 1)
			  {
			     autopayid = document.getElementById("auto_paymentid").value;
				 if(autopayid > 0)
				 {
				   jQuery("#payments #payment_id_"+autopayid).attr('checked', true);
				   jQuery("#paymentsdiv #payment_id_"+autopayid).attr('checked', true);
				   updatecart();
				 }
				 else
				 {
				   val_id = document.id('paymentsdiv').getElements('input')[0].value;
				   jQuery("#payments #payment_id_"+val_id).attr('checked', true);
				   document.id('paymentsdiv').getElements('input')[0].checked=true;
				   updatecart();
				 }
			  }
			  else if(document.id('paymentsdiv').getElements('input').length > 0)
			  {
			       val_id = document.id('paymentsdiv').getElements('input')[0].value;
				   jQuery("#payments #payment_id_"+val_id).attr('checked', true);
				   document.id('paymentsdiv').getElements('input')[0].checked=true;
				   updatecart();
			  }
			}
			if(document.getElementById('klarna_checkout_onepage') != null)
			{
	            klarnapaymentid = document.getElementById('klarna_checkout_onepage').value;
				if(klarnapaymentid == selectedpaymentid)
				{ 
				  if(customernote)
				  {
				     document.getElementById("extracommentss").style.display = "block";
				  }
				  if(document.getElementById("klarna-checkout-iframe") == null)
				  {
					  document.location.reload(); 
				  }
			    }
				else
				 {
					  if(customernote)
					  {
					      document.getElementById("extracommentss").style.display = "none";
					  }
	   	         }
			}
			else
			{
				  if(customernote)
				  {
					  document.getElementById("extracommentss").style.display = "none";
				  }
			}
			
			if (action != "updateaddress")
			{
				update_prices();
			} 
			else 
			{
				update_shipment();
			}
				
			
			
		});
}

function setshipment()
{
	 jQuery("#shipmentclose").click();
	 jQuery("#loadingbutton").click();
	 
	 datas = jQuery("#checkoutForm").serialize();
	 datas = datas.replace("&task=confirm" , "");
	 datas = datas.replace("&task=update" , "");
	 datas = datas.replace("&task=user.login" , "");
	 

	jQuery.ajax({
				type: "POST",
		        cache: false,
	    	    url: window.vmSiteurl + 'index.php?option=com_virtuemart&view=cart&task=updatecartJS',
				data : datas,
				dataType: "json"
		 }).done(
			 function (data, textStatus){
				update_shipment();
				
		 });
}
function setpayment()
{
	 jQuery("#paymentclose").click();
	 jQuery("#loadingbutton").click();
	 
	 datas = jQuery("#checkoutForm").serialize();
	 datas = datas.replace("&task=confirm" , "");
	 datas = datas.replace("&task=update" , "");
	 datas = datas.replace("&task=user.login" , "");
	 jQuery.ajax({
				type: "POST",
		        cache: false,
	    	    url: window.vmSiteurl + 'index.php?option=com_virtuemart&view=cart&task=updatecartJS',
				data : datas,
				dataType: "json"
		 }).done(
			 function (data, textStatus){
				updatepayment();
		 });
}
function updatecart()
{
	 jQuery("#loadingbutton").click();
	 
	 datas = jQuery("#checkoutForm").serialize();
	 datas = datas.replace("&task=confirm" , "");
	 datas = datas.replace("&task=update" , "");
	 datas = datas.replace("&task=user.login" , "");
	 jQuery.ajax({
				type: "POST",
		        cache: false,
	    	    url: window.vmSiteurl + 'index.php?option=com_virtuemart&view=cart&task=updatecartJS',
				data : datas,
				dataType: "json"
		 }).done(
			 function (data, textStatus){
				update_prices();
		 });
}
function updateaddress()
{
	 action = "updateaddress";
	 jQuery("#loadingbutton").click();
	
	 datas = jQuery("#checkoutForm").serialize();
	 datas = datas.replace("&task=confirm" , "");
	 datas = datas.replace("&task=update" , "");
	 datas = datas.replace("&task=user.login" , "");
	 
	 jQuery.ajax({
				type: "POST",
		        cache: false,
	    	    url: window.vmSiteurl + 'index.php?option=com_virtuemart&view=cart&vmtask=updatecartaddress',
				data : datas,
				dataType: "json"
		 }).done(
			 function (data, textStatus){
				setpayment(); 
		 });
  	
}