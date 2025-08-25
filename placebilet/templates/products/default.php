<?php 
/**
* @version      4.3.1 13.08.2013
* @author       MAXXmarketing GmbH
* @package      Jshopping
* @copyright    Copyright (C) 2010 webdesigner-profi.de. All rights reserved.
* @license      GNU/GPL
*/

use Joomla\Component\Jshopping\Site\Lib\JSFactory;
defined('_JEXEC') or die('Restricted access');
?>
<div class="jshop" id="comjshop">
<?php if ($this->header){?>
<h1 class="listproduct<?php print $this->prefix;?>"><?php print $this->header?></h1>
<?php }?> 
<?php if ($this->display_list_products){ ?>
<div class="jshop_list_product">
<?php
			 

	$templates = [];
	$templates[] = JPATH_ROOT.'/templates/'. JFactory::getApplication()->getTemplate().'/html/com_jshopping';
	$templates[] = JPATH_PLUGINS.'/jshopping/placebilet/templates';
	$templates[] = JPATH_COMPONENT.'/com_jshopping/templates/'.JSFactory::getConfig()->template;		
	$templates[] = realpath(dirname(__FILE__)."/../");	
	
	
	if($file = JPath::find($templates, $this->template_block_form_filter))
		include($file); 
//    include(dirname(__FILE__)."/../".$this->template_block_form_filter);
			
	
    if (count($this->rows)){
		$templates = [];
		$templates[] = JPATH_ROOT.'/templates/'. JFactory::getApplication()->getTemplate().'/html/com_jshopping';
		$templates[] = JPATH_PLUGINS.'/jshopping/placebilet/templates';
		$templates[] = JPATH_COMPONENT.'/com_jshopping/templates/'.JSFactory::getConfig()->template;		
		$templates[] = realpath(dirname(__FILE__)."/../");	
			if($file = JPath::find($templates, $this->template_block_list_product))
				include($file);

//        include(dirname(__FILE__)."/../".$this->template_block_list_product);
    }elseif($this->willBeUseFilter){
		$templates = [];
		$templates[] = JPATH_ROOT.'/templates/'. JFactory::getApplication()->getTemplate().'/html/com_jshopping';
		$templates[] = JPATH_PLUGINS.'/jshopping/placebilet/templates';
		$templates[] = JPATH_COMPONENT.'/com_jshopping/templates/'.JSFactory::getConfig()->template;		
		$templates[] = realpath(dirname(__FILE__)."/../");	
			if($file = JPath::find($templates, $this->template_no_list_product))
				include($file);
//        include(dirname(__FILE__)."/../".$this->template_no_list_product);
    }
	
	
	
    if ($this->display_pagination){
		$templates = [];
		$templates[] = JPATH_ROOT.'/templates/'. JFactory::getApplication()->getTemplate().'/html/com_jshopping';
		$templates[] = JPATH_PLUGINS.'/jshopping/placebilet/templates';
		$templates[] = JPATH_COMPONENT.'/com_jshopping/templates/'.JSFactory::getConfig()->template;		
		$templates[] = realpath(dirname(__FILE__)."/../");	
			if($file = JPath::find($templates, $this->template_block_pagination))
				include($file);
//        include(dirname(__FILE__)."/../".$this->template_block_pagination); 
//components/com_jshopping/templates/default/products/../list_products/block_pagination.php
    }
    //echo dirname(__FILE__)."/../".$this->template_block_pagination;
?>
</div>
<?php }?>
</div>