<?php 
/**
* @version      4.8.0 13.08.2013
* @author       MAXXmarketing GmbH
* @package      Jshopping
* @copyright    Copyright (C) 2010 webdesigner-profi.de. All rights reserved.
* @license      GNU/GPL
*/
defined('_JEXEC') or die('Restricted access');
?>
<?php if ($this->display_list_products){?>
<div class="jshop_list_product">    
<?php

			$templates = [];
			$templates[] = JPATH_ROOT.'/templates/'. JFactory::getApplication()->getTemplate().'/html/com_jshopping';
			$templates[] = JPATH_PLUGINS.'/jshopping/PlaceBilet/templates';
			$templates[] = JPATH_COMPONENT.'/com_jshopping/templates/'.JSFactory::getConfig()->template;
			$templates[] = realpath(dirname(__FILE__)."/../");
			if($file = JPath::find($templates, $this->template_block_form_filter))
				include($file);
	
 
    if (count($this->rows)){
			$templates = [];
			$templates[] = JPATH_ROOT.'/templates/'. JFactory::getApplication()->getTemplate().'/html/com_jshopping';
			$templates[] = JPATH_PLUGINS.'/jshopping/PlaceBilet/templates/'.$this->template_block_list_product;
			$templates[] = JPATH_COMPONENT.'/com_jshopping/templates/'.JSFactory::getConfig()->template;
			$templates[] = realpath(dirname(__FILE__)."/../");
			if($file = JPath::find($templates, $this->template_block_list_product))
				include($file); 
    }else{
			$templates = [];
			$templates[] = JPATH_ROOT.'/templates/'. JFactory::getApplication()->getTemplate().'/html/com_jshopping/';
			$templates[] = JPATH_PLUGINS.'/jshopping/PlaceBilet/templates/';
			$templates[] = JPATH_COMPONENT.'/com_jshopping/templates/'.JSFactory::getConfig()->template;
			$templates[] = realpath(dirname(__FILE__)."/../");
			if($file = JPath::find($templates,$this->template_no_list_product))
				include($file);  
    }
    if ($this->display_pagination){
			$templates = [];
			$templates[] = JPATH_ROOT.'/templates/'. JFactory::getApplication()->getTemplate().'/html/com_jshopping';
			$templates[] = JPATH_PLUGINS.'/jshopping/PlaceBilet/templates';
			$templates[] = JPATH_COMPONENT.'/com_jshopping/templates/'.JSFactory::getConfig()->template;
			$templates[] = realpath(dirname(__FILE__)."/../");
			if($file = JPath::find($templates, $this->template_block_pagination))
				include($file);   
    }
?>
</div>
<?php }?>