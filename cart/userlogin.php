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

$return =  $input->getString('return');
$return = base64_decode($return);
if (!JURI::isInternal($return)) 
{
	 $return = '';
}		

$options = array();				
$options['remember'] = false;				
$options['return'] = $return;		
$credentials = array();				
$credentials['username'] =  $input->getString('username');				
$credentials['password'] =  $input->getString('passwd');				
$mainframe = JFactory::getApplication();
$response = $mainframe->login($credentials, $options);
if($response == false)
	echo "error";
else
	echo "success";
exit;