<?php 
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

defined('_JEXEC') or die('Restricted access');

   $plugin=JPluginHelper::getPlugin('system','onepage_generic');
   $params=new JRegistry($plugin->params);

   echo "<fieldset id='payments'>"; 
   foreach($this->paymentplugins_payments as $payments) {
				$display = str_replace('type="radio"','type="radio" class="opg-hidden" onclick="javascript:updateaddress(5);"',$payments);
				$display = str_replace('<label','<label class="opg-hidden"',$display);
				echo $display;
    }
	echo '</fieldset>';
	if($this->klarnapaymentid > 0)
	{
	   if($this->selectedPayment == $this->klarnapaymentid)
	   {
	     $otherpaycss = "display:none;";
	   }
	}
   ?>
   <div id="otherpay_buttons" class="opg-panel-box opg-margin-top" style="<?php echo $otherpaycss; ?>"> <!-- Panel Box Started -->
     
	 <?php
	  $onlyguest =  $params->get('show_onlyguest',0);
	  $activetab = 0;
	  if(!$onlyguest)
	  {
	    $activetab = $params->get('activetab',0);
	  }
	  $user = JFactory::getUser();
	  if($user->id == 0)	
	  { 
		 if (VmConfig::get('oncheckout_only_registered') == 1 && VmConfig::get('oncheckout_show_register') == 0)
	  	 {
			 $logindis = 'display:none;';
			 $logindiv = '';
	 	 }
		 else
		 {
		     $logindis = '';
			 $logindiv = 'display:none;';
			 if($onlyguest)
			 {
			 }
			 else if(VmConfig::get('oncheckout_only_registered') == 1)
			 {
			     echo '<div class="opg-width-1-1 opg-button-group " id="loginbtns" data-opg-button-radio>';
				 echo '<a id="regcheckout" onclick="changemode(2);"  class="opg-width-1-2 opg-button opg-button-primary"  href="javascript:void(0);">'.JText::_("PLG_SYSTEM_VMUIKIT_ONEPAGE_REGISTER").'</a>';
	    		 echo '<a id="loginbtn" href="javascript:void(0);" onclick="changemode(1);" class="opg-button opg-width-1-2">'.JText::_("COM_VIRTUEMART_LOGIN").'</a>';
				 echo '</div>';
				 echo '<hr />';
			 
			 }
			 else if($activetab == 1 || $activetab == 2 || $activetab == 0)
			 {
				 echo '<div class="opg-width-1-1 opg-button-group " id="loginbtns" data-opg-button-radio>';
				 echo '<a id="regbtn" href="javascript:void(0);"  onclick="changemode(2);" class="opg-button opg-width-1-2 opg-button-primary">'.JText::_("COM_VIRTUEMART_ORDER_REGISTER_GUEST_CHECKOUT").'</a>';
	    		 echo '<a id="loginbtn" href="javascript:void(0);" onclick="changemode(1);" class="opg-button opg-width-1-2">'.JText::_("COM_VIRTUEMART_LOGIN").'</a>';
				 echo '</div>';
				 echo '<hr />';
			 
			 }
			 else if($activetab == 3)
			 {
				 echo '<div class="opg-width-1-1 opg-button-group " id="loginbtns" data-opg-button-radio>';
				 echo '<a id="regbtn" href="javascript:void(0);"  onclick="changemode(2);" class="opg-button opg-width-1-2">'.JText::_("COM_VIRTUEMART_ORDER_REGISTER_GUEST_CHECKOUT").'</a>';
	    		 echo '<a id="loginbtn" href="javascript:void(0);" onclick="changemode(1);" class="opg-button opg-width-1-2 opg-button-primary">'.JText::_("COM_VIRTUEMART_LOGIN").'</a>';
				 echo '</div>';
				 echo '<hr />';
			 }
			 else  if($activetab == 4)
			 {
			     echo '<div class="opg-width-1-1 opg-button-group " id="loginbtns" data-opg-button-radio>';
				 echo '<a id="regbtn" href="javascript:void(0);"  onclick="changemode(2);" class="opg-button opg-width-1-2">'.JText::_("COM_VIRTUEMART_ORDER_REGISTER_GUEST_CHECKOUT").'</a>';
	    		 echo '<a id="loginbtn" href="javascript:void(0);" onclick="changemode(1);" class="opg-button opg-width-1-2">'.JText::_("COM_VIRTUEMART_LOGIN").'</a>';
				 echo '</div>';
				 echo '<hr />';
			 }
		 }
		 
		 
      }
	  else
	  {
        $logindis = '';
		$logindiv = 'display:none;';
	  }
	  
	  if($activetab == 3)
	  {
	    $logindis = '';
		$logindiv = '';
	  }
      else if($activetab == 4)
	  {
	    $logindis = 'display:none;';
		$logindiv = 'display:none;';
	  }
	  if($user->id  > 0)
	  {
	      $logindis = '';
		  $logindiv = '';
	  }
	  
	  $user = JFactory::getUser();
	  if (empty($this->url)){
		$uri = JFactory::getURI();
		$url = $uri->toString(array('path', 'query', 'fragment'));
	  } else{
		$url = $this->url;
	  }

	  if($user->id == 0)	
	  {
	  ?> 
	      <div id="logindiv" class="opg-margin-top" style="<?php echo $logindiv; ?>">
		  <strong><?php echo JText::_('COM_VIRTUEMART_ORDER_CONNECT_FORM') ?></strong>
		  <div id="loginerror" class="opg-width-1-1" style="display:none;">
		  </div>
		   <?php
		   $lang = JFactory::getLanguage();
		   $extension = 'com_users';
		   $lang->load($extension);
		   $show_forgot =  $params->get('show_forgot',1);
		   $loginwidth = "opg-width-1-1";
		   if($show_forgot)
		   {
		    	$loginwidth = "opg-width-8-10 opg-float-left opg-margin-bottom";
		   }
		  ?>
		 
            <div class="first-row opg-width-1-1">
                <div class="username  opg-width-small-1-1 opg-margin-small-top" id="com-form-login-username">
					<div class="<?php echo $loginwidth; ?>">
                	    <input id="userlogin_username" class="opg-width-1-1" type="text" name="username" size="18" alt="<?php echo JText::_('COM_VIRTUEMART_USERNAME'); ?>" value="" placeholder="<?php echo JText::_('COM_VIRTUEMART_USERNAME'); ?>" />
					</div>
					<?php
					if($show_forgot)
					{
					?>
					<div class="opg-width-1-10 opg-float-left">
					<a title="<?php echo JText::_('COM_USERS_LOGIN_REMIND'); ?>" class="opg-button" href="<?php echo JRoute::_('index.php?option=com_users&view=remind'); ?>"><i class="opg-icon-question"></i></a>
					</div>
					<?php
					}
					?>
                </div>
                <div class="password opg-width-large-1-1 opg-width-small-1-1 opg-margin-small-top" id="com-form-login-password">
					 <div class="<?php echo $loginwidth; ?>"> 
      	        	      <input id="userlogin_password" type="password" name="password" class="opg-width-1-1" size="18" alt="<?php echo JText::_('COM_VIRTUEMART_PASSWORD'); ?>" value="" placeholder="<?php echo JText::_('COM_VIRTUEMART_PASSWORD'); ?>" />
					 </div>
					 <?php
					if($show_forgot)
					{
					?>
					<div class="opg-width-1-10 opg-float-left">
					<a title="<?php echo JText::_('COM_USERS_LOGIN_RESET'); ?>" class="opg-button" href="<?php echo JRoute::_('index.php?option=com_users&view=reset'); ?>"><i class="opg-icon-question"></i></a>
					</div>
					<?php
					}
					?>
                </div>

                <div class="login opg-width-large-1-1 opg-width-small-1-1 opg-margin-small-top" id="com-form-login-remember">
				 <a class="opg-button opg-button-primary opg-width-1-1" href="javascript:void(0);" onclick="ajaxlogin()"><?php echo JText::_('COM_VIRTUEMART_LOGIN') ?></a>

                </div>
                <div class="clear"></div>
            </div>
            <input type="hidden" id="loginempty" value="<?php echo JText::_("PLG_SYSTEM_VMUIKIT_ONEPAGE_LOGIN_EMPTY"); ?>" /> 
            <input type="hidden" id="loginerrors" value="<?php echo JText::_("PLG_SYSTEM_VMUIKIT_ONEPAGE_LOGIN_ERROR"); ?>" />
            <input type="hidden" name="task" value="user.login" />
            <input type="hidden" name="return" value="<?php echo base64_encode($url) ?>" id="returnurl" />
           

		  </div>
	   <?php
	  }
     ?>

  <div id="old_payments" style="<?php echo $logindis; ?>">
    <?php if ( VmConfig::get('show_tax')) { ?>
    <div><?php echo "<span  class='priceColor2 opg-hidden' id='payment_tax'>".$this->currencyDisplay->createPriceDiv('paymentTax','', $this->cart->pricesUnformatted['paymentTax'],false)."</span>"; ?> </div>
    <?php } ?>
    <div id="payment" class="opg-hidden">
      <?php  echo $this->currencyDisplay->createPriceDiv('salesPricePayment','', $this->cart->pricesUnformatted['salesPricePayment'],false); ?>
    </div>
	<?php
      if($activetab == 3)
	  {
	 	 $displayreg = 'display:none;';
	  }
	  else
	  {
	    $displayreg = "";
	  }
	  if($user->id > 0)
	  {
	    $displayreg = "";
	  }
	?>
<div class="all_shopper_fields" style="<?php echo $displayreg; ?>">

   <?php  
   if($user->id == 0) 
   { 
   ?>
      <div class="opg-width-1-1 opg-margin-bottom" >
	  <?php
      if(VmConfig::get('oncheckout_show_register') == 0)
	  {
    
	  }
	  else if (VmConfig::get('oncheckout_only_registered') == 0)
	   {
	      if($onlyguest)
		  {
		   
		  }
		  else if($activetab == 1)
		 {
		   ?>
			 <div class="opg-button-group opg-width-1-1" data-opg-button-radio="">
			   <a id="guestchekcout" class="opg-button opg-width-1-2" onClick="changecheckout(1)" href="javascript:void(0);"><i id="guesticon" class="opg-margin-small-right"></i><?php echo JText::_("PLG_SYSTEM_VMUIKIT_ONEPAGE_GUEST"); ?></a>
		  	   <a id="regcheckout"  class="opg-button opg-width-1-2 opg-button-primary" onClick="changecheckout(2)" href="javascript:void(0);"><i id="regicon" class="opg-icon-check opg-margin-small-right"></i><?php echo JText::_("PLG_SYSTEM_VMUIKIT_ONEPAGE_REGISTER"); ?></a> 
      		</div>
	 	   <?php
		 
		 }
		 else if($activetab == 2)
		 {
		   ?>
			 <div class="opg-button-group opg-width-1-1" data-opg-button-radio="">
			   <a id="guestchekcout" class="opg-button opg-width-1-2 opg-button-primary" onClick="changecheckout(1)" href="javascript:void(0);"><i id="guesticon" class="opg-icon-check opg-margin-small-right"></i><?php echo JText::_("PLG_SYSTEM_VMUIKIT_ONEPAGE_GUEST"); ?></a>
		  	   <a id="regcheckout"  class="opg-button opg-width-1-2" onClick="changecheckout(2)" href="javascript:void(0);"><i id="regicon" class="opg-margin-small-right"></i><?php echo JText::_("PLG_SYSTEM_VMUIKIT_ONEPAGE_REGISTER"); ?></a> 
      		</div>
	 	   <?php
		 
		 }
		 else
		 {
	  	  ?>
			 <div class="opg-button-group opg-width-1-1" data-opg-button-radio="">
			   <a id="guestchekcout" class="opg-button opg-width-1-2 opg-button-primary" onClick="changecheckout(1)" href="javascript:void(0);"><i id="guesticon" class="opg-icon-check opg-margin-small-right"></i><?php echo JText::_("PLG_SYSTEM_VMUIKIT_ONEPAGE_GUEST"); ?></a>
		  	   <a id="regcheckout"  class="opg-button opg-width-1-2" onClick="changecheckout(2)" href="javascript:void(0);"><i id="regicon" class="opg-margin-small-right"></i><?php echo JText::_("PLG_SYSTEM_VMUIKIT_ONEPAGE_REGISTER"); ?></a> 
      		</div>
 	   <?php
	     }
	   }
	   else
	   {
	    if($onlyguest)
		  {
		   
		  }
		  else
		  { 
  	      ?>
		 
		  <?php
		  }
	    } 
		?>
	  </div>
	<?php	
	}
	$hidetitles = "";
    if($onlyguest)
    {
	  $hidetitles = "opg-hidden";	   
    }
	else if($activetab > 0)
	{
	  $hidetitles = "";	   
	}
	?>
    <div class="opg-width-1-1"> 
	
	   <?php  
	   if($user->id == 0) 
	   { 
	   
	         
	  		 if (VmConfig::get('oncheckout_only_registered') == 0)
	  		 {
			 
			     if(VmConfig::get('oncheckout_show_register') == 0)
				  {
				   ?>
				      <h4 id="guesttitle" class="opg-h4 opg-margin-top  <?php echo $hidetitles; ?>" style=""><?php echo JText::_('PLG_SYSTEM_VMUIKIT_ONEPAGE_GUEST_CHECKOUT') ?></h4>
				   <?php
				  }
				 else if($activetab == 1)
				  {
		   		 	  ?>
					 <h4 id="guesttitle" class="opg-h4 opg-margin-top  <?php echo $hidetitles; ?>" style="display:none"><?php echo JText::_('PLG_SYSTEM_VMUIKIT_ONEPAGE_GUEST_CHECKOUT') ?></h4>
					 <h4 id="regtitle" class="opg-h4 opg-margin-top  <?php echo $hidetitles; ?>" ><?php echo JText::_('PLG_SYSTEM_VMUIKIT_ONEPAGE_REG_CHECKOUT') ?></h4>
		   	 		<?php
			  	  }
				  else
				  {
				     ?>
				       <h4 id="guesttitle" class="opg-h4 opg-margin-top  <?php echo $hidetitles; ?>" ><?php echo JText::_('PLG_SYSTEM_VMUIKIT_ONEPAGE_GUEST_CHECKOUT') ?></h4>
					   <h4 id="regtitle" class="opg-h4 opg-margin-top  <?php echo $hidetitles; ?>" style="display:none" ><?php echo JText::_('PLG_SYSTEM_VMUIKIT_ONEPAGE_REG_CHECKOUT') ?></h4>
					<?php
				  }
	   		 }
			 else if(VmConfig::get('oncheckout_show_register') == 0)
			 {
			 ?>
			    <strong id="regtitle" class="opg-h4" style="<?php echo $hidetitles; ?>"><?php echo JText::_('PLG_SYSTEM_VMUIKIT_ONEPAGE_GUEST_CHECKOUT') ?></strong>
			 <?php
			 }
			 else
			 {
			 $regchecked = 'checked="checked"';
		    ?>
			    <strong id="regtitle" class="opg-h4" style="<?php echo $hidetitles; ?>"><?php echo JText::_('PLG_SYSTEM_VMUIKIT_ONEPAGE_REG_CHECKOUT') ?></strong>
	   <?php }
	   }
	   else
	   {
	   ?>

	   <?php
	   }
	   if($onlyguest)
	   {
	     $regchecked = '';   
	   }
	   else if($activetab == 1 && $user->id == 0)
		{
		   $regchecked = 'checked="checked"';  
		}
		else if($activetab == 2)
		{
		   $regchecked = '';  
		}
	   ?>
    
	<label class="opg-text-small opg-hidden" > 
    <input class="inputbox opg-hidden" type="checkbox" <?php echo $regchecked; ?> name="register" id="register" value="1" />
	<?php echo JText::_('COM_VIRTUEMART_USER_FORM_EDIT_BILLTO_LBL'); ?>&nbsp;<?php echo JText::_('COM_VIRTUEMART_REGISTER'); ?>
	</label>
  
    <?php
	if (VmConfig::get('oncheckout_only_registered') == 1)
	{
	  if($user->id == 0) 
	  {
	    $disvar = "";
	  }
	  else
	  {
	    $disvar = "display:none;";
	  }
	}
	else
	{
	  $disvar = "display:none;";
	}
	 if($onlyguest)
	 {
	     $disvar = 'display:none;';   
	 }
	  else if($activetab == 1)
		{
		   $disvar = '';   
		}
		else if($activetab == 2)
		{
		   $disvar = 'display:none;';   
		}

		$skippedfields_array =array('name','username','password','password2');
		echo '<div id="billto_inputdiv">';
		echo '<div class="adminform "  id="user_fields_div" style="'.$disvar.' ">';

		foreach($this->cart->BTaddress["fields"] as $singlefield) {
			if(!in_array($singlefield['name'],$skippedfields_array)) {
				continue;
			}
			echo '<div class="opg-width-1-1">';
			if($singlefield['type'] == "select")
	        {	
		      echo '<label class="' . $singlefield['name'] . '" for="' . $singlefield['name'] . '_field">';
		      echo $singlefield['title'] . ($singlefield['required'] ? ' *' : '');
		      echo '</label><br />';
			}
			else
			{
			 $singlefield['formcode']=str_replace('<input','<input placeholder="'.$singlefield['title'].'"'. (VmConfig::get('oncheckout_only_registered') == 1 ? ' class="required"' : '') ,$singlefield['formcode']);
			 $singlefield['formcode']=str_replace('size="30"','' ,$singlefield['formcode']);
			}
		    echo $singlefield['formcode'];
		    echo '</div>';
		}
		echo '<div><hr /></div>';
		echo '</div>';
		echo '<div class="adminform" id="billto_fields_div" style="margin:0;">';
		$skipped_fields_array = array('virtuemart_country_id' , 'customer_note', 'virtuemart_state_id', 'agreed','name','username','password','password2'); 
		foreach($this->cart->BTaddress["fields"] as $singlefield) {
		 if($singlefield['formcode'] != "")
		 {
			if(in_array($singlefield['name'],$skipped_fields_array)) {
				continue;
			}
			echo "<div class='opg-width-1-1'>";
			if($singlefield['type'] == "select")
	        {	
		      echo '<label class="' . $singlefield['name'] . '" for="' . $singlefield['name'] . '_field">';
		      echo $singlefield['title'] . ($singlefield['required'] ? ' *' : '');
		      echo '</label><br />';
		 	}
			else
			{
			  $singlefield['formcode']=str_replace('<input','<input placeholder="'.$singlefield['title'].'"' ,$singlefield['formcode']);
			  $singlefield['formcode']=str_replace('size="30"','' ,$singlefield['formcode']);
			}
		    if($singlefield['name']=='zip') {
				$replacetext = 'input onchange="javascript:updateaddress(3);"';
		    	$singlefield['formcode']=str_replace('input', $replacetext ,$singlefield['formcode']);
		    } 
			else if($singlefield['name']=='title') {
				$singlefield['formcode']=str_replace('vm-chzn-select','',$singlefield['formcode']);
		    }
			
		    echo $singlefield['formcode'];
			echo '</div>';
	      }
		}
	    echo '</div>';
		?>
  </div>
  <div class="opg-width-1-1 opg-margin-top" id="div_shipto"> 
    <div class="shipto_fields_div">
     <div class="opg-width-1-1">
	     <?php
		  $target = "{target:'#shiptopopup'}";
		  ?>
		 <a id="shiptobutton" class="opg-button opg-width-1-1" href="#" data-opg-modal="<?php echo $target; ?>"><i id="shiptoicon" style="display:none;" class="opg-icon opg-icon-check opg-margin-right"></i><?php echo JText::_('PLG_SYSTEM_VMUIKIT_CHANGE_SHIP_ADDRESS'); ?></a>
	 </div>
	
  </div>
  <div class="clear"></div>
</div>
 <?php
	  $user = JFactory::getUser();
	  $logindis = '';
	  $activetab = $params->get('activetab',0);
	  if($activetab == 3)
	  {
	    $logindis = 'display:none';
	  }
	  if($user->id > 0)
	  {
	    $logindis = "";
	  }

	?>

<div id="other-things" style="<?php echo $logindis; ?>">

	<?php //echo shopFunctionsF::getLoginForm($this->cart,false);

	if ($this->checkout_task) $taskRoute = '&task='.$this->checkout_task;

	else $taskRoute ='';

	?>

		<?php // Leave A Comment Field ?>
		
		<?php
  foreach($this->cart->BTaddress["fields"] as $singlefield) 
  {
     if($singlefield['name']=='customer_note') 
	 {
		if(!empty($this->cart->BT['customer_note']))
	 	{
		  $commenticon  = '';
		  $commentactive = 'opg-button-primary';
		}
		else
		{
		  $commenticon  = 'display:none';
		  $commentactive = '';
		}
		?>
		
	 <div class="opg-width-1-1">
		 <a id="commentbutton" class="opg-button <?php echo $commentactive; ?> opg-width-1-1" href="#commentpopup" data-opg-modal><i id="commenticon" style="<?php echo $commenticon; ?>" class="opg-icon opg-icon-check opg-margin-small-right"></i><?php echo JText::_('Add Notes and Special Requests'); ?></a>
	 </div>
	 <?php
	 }
  }
  ?>
		<div class="checkout-button-top">

			<?php // Terms Of Service Checkbox
			if (!class_exists('VirtueMartModelUserfields')){
				require(JPATH_VM_ADMINISTRATOR . DS . 'models' . DS . 'userfields.php');
			}
			if(!class_exists('VmHtml'))require(JPATH_VM_ADMINISTRATOR.DS.'helpers'.DS.'html.php');
			if(VmConfig::get('oncheckout_show_legal_info',1)){
			?>
                <section title=".squaredTwo">
					    <div class="squaredTwo">
						  <?php 
						  if($params->get('check_terms'))
							{
							 $checked = 1;
							}
							else
							{
							  $checked = 0;
							}
						  	echo VmHtml::checkbox('tos', $checked ,1,0, 'class="terms-of-service" id="squaredTwo"'); 

						  ?>
					      <label for="squaredTwo"></label>
					    </div>
				 </section>

			<a class="opg-link opg-text-small" style="cursor:pointer;" data-opg-modal="{target:'#full-tos'}"><?php echo JText::_('COM_VIRTUEMART_CART_TOS_READ_AND_ACCEPTED'); ?></a>
		<?php
		} 
		$showextraterms = $params->get('show_extraterms',0);	
		if($showextraterms)
		{
		?>
		  <div id="privcacy_div" class="opg-width-1-1 opg-margin-small">
		  <span class="comment opg-align-left"><?php echo JText::_ ('PLG_VMUIKITONEPAGE_PRIVACY_POLICY_TITLE'); ?></span>
		   <textarea id="privacy_textarea" rows="4" readonly="readonly" class="opg-width-1-1"><?php echo JText::_('PLG_VMUIKITONEPAGE_PRIVACY_POLICY_TEXT'); ?></textarea>
		   <label class="opg-margin-top" for="privacy_checkbox">
				<input type="checkbox" value="1" name="privacy_checkbox" id="privacy_checkbox" class="">
				<?php echo JText::_("PLG_VMUIKITONEPAGE_PRIVACY_POLICY_CHECKBOX"); ?>								
			</label>


		  </div>
		<?php
		}
		 $usecaptcha = $params->get("use_recaptcha", 0);
		 $captchakey = $params->get("recaptchakey", '');
	 	 if($usecaptcha && !empty($captchakey))
		 {
		  ?>
		  <div class="opg-width-1-1">
		   <div class="g-recaptcha opg-container-center" data-sitekey="<?php echo $captchakey; ?>" style="width:200px;"></div>
		   </div>
		   <style type="text/css">
		   .g-recaptcha {
    transform: scale(0.77);
    transform-origin: -76px 50% 0;
}

		   </style>
		  <?php
		  }
			if (!VmConfig::get('use_as_catalog')) {
			   echo '<p id="bottom_total" class="opg-text-large opg-text-primary opg-text-bold opg-text-center">'.JText::_("COM_VIRTUEMART_CART_TOTAL").'&nbsp;:&nbsp;<strong class="opg-text-large opg-text-primary opg-text-bold" id="carttotal"></strong></p>';
				echo '<a class="opg-button opg-button-primary opg-button-large opg-margin-top opg-width-1-1" href="javascript:void(0);" onclick="submit_order();"><span>' . JText::_('COM_VIRTUEMART_ORDER_CONFIRM_MNU') . '</span></a>';
			}
			$text = JText::_('COM_VIRTUEMART_ORDER_CONFIRM_MNU');
			?>
		</div>
	
        <?php
		$minimumpurhase = 0;
		if(isset($this->vendordata->vendor_min_pov))
			{
			   $minimumpurhase = $this->vendordata->vendor_min_pov;
		    }
			
		?>
		<input type='hidden' name='minmumpurchase' id='minmumpurchase' value='<?php echo $minimumpurhase; ?>'/>
		<input type='hidden' name='task' value='confirm'/ >
		<input type='hidden' name='option' value='com_virtuemart'/>
	    <input type="hidden" name="carttotalunformat" id="carttotalunformat" value="" />
		<input type='hidden' name='view' value='cart'/>
	</div>
   </div>

</div> <!-- Grid-div-end -->
</div>
</div>