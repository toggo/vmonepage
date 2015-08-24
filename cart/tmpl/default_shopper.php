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
				$display = str_replace('type="radio"','type="radio" class="opg-hidden" onclick="javascript:updateaddress();"',$payments);
				$display = str_replace('<label','<label class="opg-hidden"',$display);
				echo $display;
    }
	echo '</fieldset>';
   ?>
   <div id="otherpay_buttons" class="opg-panel-box opg-margin-top"> <!-- Panel Box Started -->
     
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
            <input type="hidden" name="option" value="<?php echo $comUserOption ?>" />
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
	?>
<div class="billto-shipto" style="<?php echo $displayreg; ?>">

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

		$userFields=array('agreed','name','username','password','password2');
		echo '<div id="div_billto">';
		echo '<table class="adminform opg-table"  id="table_user" style="'.$disvar.' ">' . "\n";

		foreach($this->cart->BTaddress["fields"] as $_field) {
		
			if(!in_array($_field['name'],$userFields)) {
				continue;
			}
			if($_field['name']=='agreed') {
				continue;
			}
	    	echo '		<tr>' . "\n";
		    echo '			<td class="key">' . "\n";
			if($_field['type'] == "select")
	        {	
		      echo '				<label class="' . $_field['name'] . '" for="' . $_field['name'] . '_field">' . "\n";
		      echo '					' . $_field['title'] . ($_field['required'] ? ' *' : '') . "\n";
		      echo '				</label>';
			}
			else
			{
			 $_field['formcode']=str_replace('<input','<input placeholder="'.$_field['title'].'"'. (VmConfig::get('oncheckout_only_registered') == 1 ? ' class="required"' : '') ,$_field['formcode']);
			 $_field['formcode']=str_replace('size="30"','' ,$_field['formcode']);
			}
		    echo '				' . $_field['formcode'] . "\n";
		    echo '			</td>' . "\n";
		    echo '		</tr>' . "\n";
		}
		echo '<tr><td><hr /></td></tr>';
		echo '	</table>' . "\n";
		echo '	<table class="adminform opg-table" id="table_billto" style="margin:0;">' . "\n";

		foreach($this->cart->BTaddress["fields"] as $_field) {
         
		 if($_field['formcode'] != "")
		 {
		  
		    if($_field['name']=='customer_note') {
	          continue;
			}
			if($_field['name']=='virtuemart_country_id') {
	          continue;
			}
			if($_field['name']=='virtuemart_state_id') {
			  continue;
			}
		
			if(in_array($_field['name'],$userFields)) {
				continue;
			}
			
			
			echo '		<tr>' . "\n";
		    echo '			<td class="key">' . "\n";
			if($_field['type'] == "select")
	        {	
		    echo '				<label class="' . $_field['name'] . '" for="' . $_field['name'] . '_field">' . "\n";
		    echo '					' . $_field['title'] . ($_field['required'] ? ' *' : '') . "\n";
		    echo '				</label>';
			}
			else
			{
			 $_field['formcode']=str_replace('<input','<input placeholder="'.$_field['title'].'"' ,$_field['formcode']);
			 $_field['formcode']=str_replace('size="30"','' ,$_field['formcode']);
			}

		    if($_field['name']=='zip') {
			     

				$replacetext = 'input onchange="javascript:updateaddress();"';
		    	$_field['formcode']=str_replace('input', $replacetext ,$_field['formcode']);
		    } 

			else if($_field['name']=='virtuemart_country_id') {
			
				/*
		    	$_field['formcode']=str_replace('<select','<select onchange="javascript:updateaddress();"',$_field['formcode']);
				$_field['formcode']=str_replace('vm-chzn-select','',$_field['formcode']);
				*/
				
		    } else if($_field['name']=='virtuemart_state_id') {
			
		    	//$uptask = "'custom'";
		        //$replacetext = '<select onchange="javascript:updateaddress('.$uptask.');"';
		    	//$_field['formcode']=str_replace('<select',$replacetext,$_field['formcode']);
				
				if($_field['required'])
				{
				 // $_field['formcode']=str_replace('vm-chzn-select','required',$_field['formcode']);
				}
				else
				{
				  // $_field['formcode']=str_replace('vm-chzn-select','',$_field['formcode']);
				} 
				
		    }
			else if($_field['name']=='title') {
				$_field['formcode']=str_replace('vm-chzn-select','',$_field['formcode']);
		    }
			
		    echo '				' . $_field['formcode'] . "\n";
		    echo '			</td>' . "\n";
		    echo '		</tr>' . "\n";
	      }
		}
	    echo '	</table>' . "\n";
	    echo '</div>';
		?>
  </div>
  <div class="opg-width-1-1 opg-margin-top" id="div_shipto"> 
    <div class="output-shipto">
	
		  
     <div class="opg-width-1-1">
	     <?php
		  $target = "{target:'#shiptopopup'}";
		  ?>
		 <a id="shiptobutton" class="opg-button opg-width-1-1" href="#" data-opg-modal="<?php echo $target; ?>"><i id="shiptoicon" style="display:none;" class="opg-icon opg-icon-check opg-margin-right"></i><?php echo JText::_('PLG_SYSTEM_VMUIKIT_CHANGE_SHIP_ADDRESS'); ?></a>
	 </div>
	
	
	<div id="shiptopopup" class="opg-modal"><!-- Shipto Modal Started -->
	 <div class="opg-modal-dialog"><!-- Shipto Modal Started -->
		<a class="opg-modal-close opg-close"></a>
    	   <div class="opg-modal-header"><strong><?php echo JText::_('PLG_SYSTEM_VMUIKIT_CHANGE_SHIP_ADDRESS_HEADING'); ?></strong></div>
      <label class="opg-text-small opg-hidden">
	  <?php 
	    $samebt = "";
		if($this->cart->STsameAsBT == 0)
		{
			$samebt = '';
			$shiptodisplay = "";
			
		}
	    else if($params->get('check_shipto_address') == 1)
		{
			$samebt = 'checked="checked"';
		}
		else
		{
		   $samebt = '';
		   $shiptodisplay = "";
		}
	  ?> 
      <input class="inputbox opg-hidden" type="checkbox" name="STsameAsBT" checked="checked" id="STsameAsBT" value="1"/>
	  
	  <?php
		if(!empty($this->cart->STaddress['fields'])){
			if(!class_exists('VmHtml'))require(JPATH_VM_ADMINISTRATOR.DS.'helpers'.DS.'html.php');
				echo JText::_('COM_VIRTUEMART_USER_FORM_ST_SAME_AS_BT');
		?>
		</label>
      <?php
		}
 		?>

    <?php if(!isset($this->cart->lists['current_id'])) $this->cart->lists['current_id'] = 0; ?>
    <?php
		echo '	<table class="adminform  opg-table" id="table_shipto" style="'.$shiptodisplay.'">' . "\n";
		

		foreach($this->cart->STaddress["fields"] as $_field) {
		  echo '		<tr>' . "\n";
	      echo '			<td class="key">' . "\n";
	     if($_field['type'] == "select")
	      {		
		    echo '				<label class="' . $_field['name'] . '" for="' . $_field['name'] . '_field">' . "\n";
		    echo '					' . $_field['title'] . ($_field['required'] ? ' *' : '') . "\n";
		    echo '				</label>';
		  }
		  else
		  {
		    $_field['formcode']=str_replace('<input','<input placeholder="'.$_field['title'].'"' ,$_field['formcode']);
		  }
		 
		  
		
    if($_field['name']=='shipto_zip') {
		  $replacetext = 'input onchange="javascript:updateaddress();"';
		  $_field['formcode']=str_replace('input', $replacetext ,$_field['formcode']);

    } 
	else if($_field['name']=='customer_note') {
	 
	}
	else if($_field['name']=='shipto_virtuemart_country_id') {
		    	$_field['formcode']=str_replace('<select','<select onchange="javascript:updateaddress();"',$_field['formcode']);
		    	$_field['formcode']=str_replace('class="virtuemart_country_id','class="shipto_virtuemart_country_id',$_field['formcode']);
				$_field['formcode']=str_replace('vm-chzn-select','',$_field['formcode']);

    } else if($_field['name']=='shipto_virtuemart_state_id') {

    	$_field['formcode']=str_replace('id="virtuemart_state_id"','id="shipto_virtuemart_state_id"',$_field['formcode']);

		        $replacetext = '<select onchange="javascript:updateaddress();"';
		    	$_field['formcode']=str_replace('<select',$replacetext,$_field['formcode']);
				if($_field['required'])
				{
				  $_field['formcode']=str_replace('vm-chzn-select','required',$_field['formcode']);
				}
				else
				{
				   $_field['formcode']=str_replace('vm-chzn-select','',$_field['formcode']);
				} 
	    }
    echo '				' . $_field['formcode'] . "\n";

    echo '			</td>' . "\n";
	echo ' </tr>';


 
}

    echo '</tr>	</table>' . "\n";

		?>
	  <div class="opg-modal-footer">
	  	 <a class="opg-button opg-button-primary" href="Javascript:void(0);" onclick="validateshipto();"><?php echo JText::_("PLG_SYSTEM_VMUIKIT_ONEPAGE_SUBMIT"); ?></a>
		 <a id="shiptoclose" class="opg-modal-close opg-button"><?php echo JText::_("PLG_SYSTEM_VMUIKIT_ONEPAGE_CANCEL"); ?></a>
		 
		 <a id="shiptoclose" onclick="removeshipto();" class="opg-modal-close opg-margin-left opg-button opg-button-danger"><?php echo JText::_("PLG_SYSTEM_VMUIKIT_ONEPAGE_REMOVE_SHIPTO"); ?></a>
	  </div>
    </div> <!-- Shipto Modal ended -->
</div><!-- Shipto Modal ended -->
		
  </div>
  <div class="clear"></div>
</div>