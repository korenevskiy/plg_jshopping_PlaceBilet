<?php 
 /** ----------------------------------------------------------------------
 * plg_PlaceBilet - Plugin Joomshopping Component for CMS Joomla
 * ------------------------------------------------------------------------
 * author    Sergei Borisovich Korenevskiy
 * @copyright (C) 2019 //explorer-office.ru. All Rights Reserved. 
 * @license GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 * @package		Jshopping
 * @subpackage  plg_placebilet
 * Websites: //explorer-office.ru/download/
 * Technical Support:  Forum - //fb.com/groups/multimodulefb.com/groups/placebilet/
 * Technical Support:  Forum - //vk.com/placebilet
 * -------------------------------------------------------------------------
 **/
defined('_JEXEC') or die('Restricted access');
?>
<?php if ($this->display_list_products){?>
<div class="list_products _jshop_list_product">
<?php

	$templates = [];
	$templates[] = JPATH_ROOT.'/templates/'. JFactory::getApplication()->getTemplate().'/html/com_jshopping';
	$templates[] = JPATH_PLUGINS.'/jshopping/placebilet/templates';
	$templates[] = JPATH_COMPONENT.'/com_jshopping/templates/'.JSFactory::getConfig()->template;
	$templates[] = realpath(dirname(__FILE__)."/../");
	
	if($file = JPath::find($templates, $this->template_block_form_filter))
		include($file);
	
		$templates = [];
		$templates[] = JPATH_ROOT.'/templates/'. JFactory::getApplication()->getTemplate().'/html/com_jshopping';
		$templates[] = JPATH_PLUGINS.'/jshopping/placebilet/templates';
		$templates[] = JPATH_COMPONENT.'/com_jshopping/templates/'.JSFactory::getConfig()->template;
		$templates[] = realpath(dirname(__FILE__)."/../");
 
    if (count($this->rows)){
		if($file = JPath::find($templates, 'category/list_products.php'))
			include($file);
		
		elseif($file = JPath::find($templates, $this->template_block_list_product))
			include($file);
		
    }else{
		if($file = JPath::find($templates,$this->template_no_list_product))
			include($file);
    }
	
    if ($this->display_pagination){
		
		$templates = [];
		$templates[] = JPATH_ROOT.'/templates/'. JFactory::getApplication()->getTemplate().'/html/com_jshopping';
		$templates[] = JPATH_PLUGINS.'/jshopping/placebilet/templates';
		$templates[] = JPATH_COMPONENT.'/com_jshopping/templates/'.JSFactory::getConfig()->template;
		$templates[] = realpath(dirname(__FILE__)."/../");
		
		if($file = JPath::find($templates, $this->template_block_pagination))
			include($file);
    }
	
		
	if($file = JPath::find($templates, $this->template_block_form_filter))
		include($file);
	
 
	
?>
</div>
<?php }?>