<?php
/**
** Copyright (c) 2012, 2015 All Right Reserved, http://www.joomlaproffs.se

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

** <author>Joomlaproffs</author>
** <email>info@joomlaproffs.se</email>
** <date>2015</date>
*/

defined('_JEXEC') or die('Restricted access');

JHTML::script('plugins/system/onepage_generic/onepage.js');
JHTML::script('plugins/system/onepage_generic/onepage_generic.js');
JHTML::stylesheet ( 'plugins/system/onepage_generic/onepage_generic.css');



$taskRoute = "";

$vendorModel = VmModel::getModel('vendor');
$vendordata = $vendorModel->getVendor($this->cart->vendor->virtuemart_vendor_id);
$vendorModel->addImages($vendordata,1);
if (VmConfig::get('enable_content_plugin', 0)) {
		shopFunctionsF::triggerContentPlugin($vendordata, 'vendor','vendor_terms_of_service');
}

vmJsApi::jPrice();
JHTML::script('plugins/system/onepage_generic/vmprices.js');


$plugin=JPluginHelper::getPlugin('system','onepage_generic');
$params=new JRegistry($plugin->params);

if($params->get("buttoncolour") != "")
{
  ?>
  <style type="text/css">
  .opg-button-primary
  {
    background:<?php echo $params->get("buttoncolour"); ?> !important;
  }
  .opg-progress-striped .opg-progress-bar {
  background-image: -webkit-linear-gradient(-45deg, <?php echo $params->get("buttoncolour"); ?> 25%, transparent 25%, transparent 50%, <?php echo $params->get("buttoncolour"); ?> 50%, <?php echo $params->get("buttoncolour"); ?> 75%, transparent 75%, transparent);
  background-image: linear-gradient(-45deg, <?php echo $params->get("buttoncolour"); ?> 25%, transparent 25%, transparent 50%, <?php echo $params->get("buttoncolour"); ?> 50%, <?php echo $params->get("buttoncolour"); ?> 75%, transparent 75%, transparent);
  background-size: 30px 30px;
}
  
  </style>
  <?php
}


JFactory::getLanguage()->load('plg_system_onepage_generic',JPATH_ADMINISTRATOR);

$userFieldsModel = VmModel::getModel('userfields');

$showextraterms = $params->get('show_extraterms',0);	

JHtml::_('behavior.formvalidation');

$document = JFactory::getDocument();
$document->addStyleDeclaration('#facebox .content {display: block !important; height: 480px !important; overflow: auto; width: 560px !important; }');
$customernote = 0;
 foreach($this->cart->BTaddress["fields"] as $_field) 
 {
     if($_field['name']=='customer_note') 
 	 {
	   $customernote = true;
	 }
 } 

$document->addScriptDeclaration("
      //<![CDATA[ 
      window.CARTPAGE = 'yes';
	  window.shipmentfileds = ".count($this->cart->STaddress['fields']).";
      window.agree_to_tos_onorder = ".VmConfig::get('agree_to_tos_onorder').";
	  window.acceptmeessage = '".JText::_('COM_VIRTUEMART_CART_PLEASE_ACCEPT_TOS')."';
	  window.privacymeessage = '".JText::_('PLG_VMUIKITONEPAGE_PRIVACY_POLICY_ERROR')."';
      window.minpurchaseerror = '".vmText::sprintf('COM_VIRTUEMART_CART_MIN_PURCHASE', $vendordata->vendor_min_pov)."';
	  window.selectshipment = '".JText::_('COM_VIRTUEMART_CART_SELECT_SHIPMENT')."';
	  window.selectpayment = '".JText::_('COM_VIRTUEMART_CART_SELECT_PAYMENT')."';	  
	  window.invaliddata = '".JText::_('COM_VIRTUEMART_CART_CHECKOUT_DATA_NOT_VALID')."';	  
	  window.productupdate = '".JText::_('COM_VIRTUEMART_PRODUCT_UPDATED_SUCCESSFULLY')."';	  
	  window.chosecountry = '".JText::_('PLG_SYSTEM_VMUIKIT_CHOOSE_COUNTRY')."';	  
	  window.removeprouct = '".JText::_('COM_VIRTUEMART_PRODUCT_REMOVED_SUCCESSFULLY')."';	  
	  window.changetext = '".JText::_('PLG_SYSTEM_VMUIKIT_ONEPAGE_CHNAGE')."';	  
	  window.noshipmethod = '".vmInfo('COM_VIRTUEMART_NO_SHIPPING_METHODS_CONFIGURED', '')."';	  
	  window.nopaymethod = '".vmInfo('COM_VIRTUEMART_NO_PAYMENT_METHODS_CONFIGURED', '')."';	  
	  window.onlyregistered = ".VmConfig::get('oncheckout_only_registered').";	  
	  window.couponenable = ".VmConfig::get('coupons_enable').";	  
	  window.showextraterms = ".$showextraterms.";
	  window.token = '".JSession::getFormToken()."';
	  window.show_tax = ".VmConfig::get('show_tax').";
	  window.customernote = ".$customernote.";
      //]]>
      ");
?>

<style>
input#register
{
 float:none !important;
}
.billto-shipto{
 border:none !important;
}
</style>

<?php 
if(count($this->cart->products) == 0)
{
?>
<div  class="opg-panel opg-panel-box">
		<strong><?php echo JText::_('COM_VIRTUEMART_EMPTY_CART') ?></strong>
			<?php if(!empty($this->continue_link_html)) : ?>
			<div class="opg-text-center">
				<?php 
				echo str_replace("continue_link", "opg-button opg-button-primary", $this->continue_link_html);
				?>
			</div>
			<?php endif; ?>		
	</div>	
<?php
}
else
{
?>

	
<div class="opg-width-1-1" id="fullerrordiv">
</div>
	

	<form method="post" id="checkoutForm" name="checkoutForm" action="<?php echo JRoute::_( 'index.php?option=com_virtuemart&view=cart'.$taskRoute,$this->useXHTML,$this->useSSL ); ?>" class="opg-form opg-width-1-1 ">
	<div id="cart-contents" class="opg-grid" data-opg-margin><!-- CART CONTENTS DIV START -->
		<div id="overlaydiv" class="overlaycss"> <!-- OVERLAY CSS DIV START -->
		 	<div id="loadingmsg" class="opg-width-1-3 opg-push-1-3  opg-panel opg-panel-box">
	    		<h3 class="opg-h3 opg-text-primary">
				<?php
				 if($params->get("loadingmsg") !== "")
				 {
				    echo $params->get("loadingmsg");
				 }
				 else
				 {
				   echo "Processing... ";
				 }
				?>
				</h3>
				<div class="opg-progress opg-progress-striped opg-active">
				    <div class="opg-progress-bar opg-text-center" style="width: 100%;">Loading...</div>
				</div>
			</div>
		</div><!-- OVERLAY CSS DIV END -->
		<?php
		$layoutwidth = $params->get("layout_width", 1);
		if($layoutwidth == 2)
		{
			 $leftdiv_width =  "opg-width-large-2-3 opg-width-medium-2-3";
			 $rightdiv_width = "opg-width-large-1-3 opg-width-medium-1-3";
		}
		else if($layoutwidth == 3)
		{
		     $leftdiv_width =  "opg-width-large-2-2 opg-width-medium-1-2";
			 $rightdiv_width = "opg-width-large-1-2 opg-width-medium-1-2";
		}
		else if($layoutwidth == 4)
		{
		     $leftdiv_width =  "opg-width-large-1-1 opg-width-medium-1-1";
			 $rightdiv_width = "opg-width-large-1-1 opg-width-medium-1-1";
		}
		else 
		{
			 $leftdiv_width =  "opg-width-large-3-5 opg-width-medium-3-5";
			 $rightdiv_width = "opg-width-large-2-5 opg-width-medium-2-5";
		}
		?>
		 <div id="leftdiv" class="opg-width-1-1 <?php echo $leftdiv_width; ?> opg-width-small-1-1 opg-float-left   opg-border-rounded">
			<?php echo $this->loadTemplate('left'); ?>
		 </div>
		 <div id="right_div" class="tm-sidebar-a opg-width-1-1 <?php echo $rightdiv_width; ?> opg-width-small-1-1 opg-float-right" >
		    <?php echo $this->loadTemplate('right'); ?>
		 </div>
      <?php
	  $user = JFactory::getUser();
	  if($user->id == 0)	
	  { 
	     $logindis = '';
	  }
	  else
	  {
	    $logindis = '';
	  }
	  $activetab = $params->get('activetab',0);
	  if($activetab == 3)
	  {
	    $logindis = 'display:none';
	  }

	?>



	



<div id="other-things" style="<?php echo $logindis; ?>">

	<?php //echo shopFunctionsF::getLoginForm($this->cart,false);

	if ($this->checkout_task) $taskRoute = '&task='.$this->checkout_task;

	else $taskRoute ='';

	?>

		<?php // Leave A Comment Field ?>
		
		<?php
  foreach($this->cart->BTaddress["fields"] as $_field) 
  {
     if($_field['name']=='customer_note') 
	 {
		if($this->cart->BT['customer_note'] != "")
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
	 
	 <div id="commentpopup" class="opg-modal"><!-- Comment Modal Started -->
	 <div class="opg-modal-dialog"><!-- Comment Modal Started -->
		<a class="opg-modal-close opg-close"></a>
    	   <div class="opg-modal-header"><strong><?php echo JText::_('COM_VIRTUEMART_COMMENT_CART'); ?></strong></div>
		   <div id="extracomments" class="customer-comments">
		   <?php
			   if($_field['required'])
			   {
			     $tmptext = "";
				 $tmptext = str_replace("<textarea", '<textarea onblur="javascript:updatecart();" ', $_field['formcode']);
				 $tmptext = str_replace("<textarea", '<textarea class="required"', $tmptext);
				 echo $tmptext;

			   }
			   else
			   {
			    	echo str_replace("<textarea", '<textarea onblur="javascript:updatecart();" ', $_field['formcode']);
			   }
			   ?>
		   </div>
		   <div class="opg-modal-footer">
	  			 <a class="opg-button opg-button-primary" href="Javascript:void(0);" onclick="validatecomment();">Submit</a>
				 <a id="commentclose" class="opg-modal-close opg-button">Cancel</a>
		   </div>
    </div> <!-- Shipto Modal ended -->
	</div><!-- Shipto Modal ended -->
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
		    <div id="full-tos" class="opg-modal">
			  <div class="opg-modal-dialog opg-text-left">
			        <a class="opg-modal-close opg-close"></a>
					<strong><?php echo JText::_('COM_VIRTUEMART_CART_TOS'); ?></strong>
				<?php echo $this->cart->vendor->vendor_terms_of_service;?>
			  </div>
			</div>


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
			if (!VmConfig::get('use_as_catalog')) {
			   echo '<p id="bottom_total" class="opg-text-large opg-text-primary opg-text-bold opg-text-center">'.JText::_("COM_VIRTUEMART_CART_TOTAL").'&nbsp;:&nbsp;<strong class="opg-text-large opg-text-primary opg-text-bold" id="carttotal"></strong></p>';
				echo '<a class="opg-button opg-button-primary opg-button-large opg-margin-top opg-width-1-1" href="javascript:void(0);" onclick="submit_order();"><span>' . JText::_('COM_VIRTUEMART_ORDER_CONFIRM_MNU') . '</span></a>';
			}
			$text = JText::_('COM_VIRTUEMART_ORDER_CONFIRM_MNU');
			?>
		</div>
	
        <?php
		if(isset($vendordata->vendor_min_pov))
			{
			  echo "<input type='hidden' name='minmumpurchase' id='minmumpurchase' value='".$vendordata->vendor_min_pov."'/>";
		    }
		?>
		<input type='hidden' name='task' value='confirm'/>
		<input type='hidden' name='option' value='com_virtuemart'/>
	    <input type="hidden" name="carttotalunformat" id="carttotalunformat" value="" />
		<input type='hidden' name='view' value='cart'/>
	</div>
   </div>

</div> <!-- Grid-div-end -->
</div>
</div>
</form>

<?php
}
?>