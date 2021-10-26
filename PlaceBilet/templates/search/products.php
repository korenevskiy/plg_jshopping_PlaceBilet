<?php 
/**
* @version      4.3.1 13.08.2013
* @author       MAXXmarketing GmbH
* @package      Jshopping
* @copyright    Copyright (C) 2010 webdesigner-profi.de. All rights reserved.
* @license      GNU/GPL
*/
use \Joomla\CMS\Factory as JFactory;
use \Joomla\CMS\Filesystem\Path as JPath;
defined('_JEXEC') or die('Restricted access');


$title = JText::_('JSHOP_PANEL_SHOWING');

$date_from = JFactory::getApplication()->input->getString('date_from',NULL); 
if(strtotime($date_from) !== false){ 
    $title .= " - " . JHTML::_('date', $date_from) ;
} 

?>
<div class="jshop" id="comjshop">
<h1><?= $title?> <?php if ($this->search) print '"'.$this->search.'"';?></h1>

<?php if (count($this->rows)){ ?>
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
		$templates[] = JPATH_ROOT.'/templates/'. JFactory::getApplication()->getTemplate().'/html/com_jshopping/';
		$templates[] = JPATH_PLUGINS.'/jshopping/PlaceBilet/templates/';
		$templates[] = JPATH_COMPONENT.'/com_jshopping/templates/'.JSFactory::getConfig()->template; 
	$templates[] = realpath(dirname(__FILE__)."/../");	
		if($file = JPath::find($templates, $this->template_block_list_product))
			include($file);
    }
    if ($this->display_pagination){
        include(dirname(__FILE__)."/../".$this->template_block_pagination);
		$templates = [];
		$templates[] = JPATH_ROOT.'/templates/'. JFactory::getApplication()->getTemplate().'/html/com_jshopping/';
		$templates[] = JPATH_PLUGINS.'/jshopping/PlaceBilet/templates/';
		$templates[] = JPATH_COMPONENT.'/com_jshopping/templates/'.JSFactory::getConfig()->template; 
		$templates[] = realpath(dirname(__FILE__)."/../");	
		if($file = JPath::find($templates, $this->template_block_pagination))
			include($file);
    }
?>
</div>
<?php }?>
</div>