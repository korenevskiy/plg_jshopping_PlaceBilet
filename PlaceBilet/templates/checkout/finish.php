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
<div id="comjshop">
<h2><?= JText::_('JSHOP_THANK_YOU_ORDER')?></h2>
<?php if ($this->text){
    echo $this->text;
    }else{
?>
<p> <?= JText::_('JSHOP_THANK_YOU_ORDER_TEXT')?></p>
<?php }?>
</div>