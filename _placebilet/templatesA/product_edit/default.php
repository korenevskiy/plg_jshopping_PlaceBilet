<?php
/**
* @version      5.0.0 15.09.2018
* @author       MAXXmarketing GmbH
* @package      Jshopping
* @copyright    Copyright (C) 2010 webdesigner-profi.de. All rights reserved.
* @license      GNU/GPL
*/
use \Joomla\CMS\Language\Text as JText;
use Joomla\Component\Jshopping\Site\Lib\JSFactory;
defined('_JEXEC') or die();
$row=$this->product;
$lists=$this->lists;
$tax_value=$this->tax_value;
$jshopConfig=\JSFactory::getConfig();
$currency = $this->currency;

$dispatcher = \JFactory::getApplication();
?>
<div class="jshop_edit">
<script type="text/javascript">
    var lang_delete="<?= JText::_('JSHOP_DELETE')?>";
	jshopAdmin.lang_delete="<?= JText::_('JSHOP_DELETE')?>";
</script>
<form action="index.php?option=com_jshopping&controller=products" method="post" enctype="multipart/form-data" name="adminForm" id="adminForm">
<?php echo \JHTML::_('form.token');?>
<ul class="joomla-tabs nav nav-tabs">
    <?php if ($this->product->parent_id==0){?>
    <?php foreach($this->languages as $i => $lang){?>
        <li class="nav-item" >
            <a class="nav-link <?= $i ? '' : 'active'?>" href="#<?php print $lang->language.'-page'?>" data-toggle="tab">
                <?php echo JText::_('JSHOP_DESCRIPTION')?><?php if ($this->multilang){?> (<?php print $lang->lang?>)<img class="tab_image" src="components/com_jshopping/images/flags/<?php print $lang->lang?>.gif" /><?php }?>
            </a>
        </li>        
    <?php }?>
    <li class="nav-item"><a class="nav-link" href="#main-page" data-toggle="tab"><?php echo JText::_('JSHOP_INFO_PRODUCT')?></a></li>
    <?php }?>
    <?php if ($this->product->parent_id==0){
        $dispatcher->triggerEvent('onDisplayProductEditTabsTab', array(&$row, &$lists, &$tax_value));
    }?>
    <?php if (true || $this->product->parent_id==0 ){?>
		<li class="nav-item "><a href="#attribs-place" class="nav-link" data-toggle="tab"><?php echo JText::_('JSHOP_PLACES') ;?></a></li>
    <?php }?>
    <?php if ($jshopConfig->admin_show_attributes && $this->product->parent_id==0){?>
        <li class="nav-item"><a href="#attribs-page" class="nav-link" data-toggle="tab"><?php echo JText::_('JSHOP_ATTRIBUTES')?></a></li>
    <?php }?>
    <?php if ($jshopConfig->admin_show_freeattributes && $this->product->parent_id==0){?>
        <li class="nav-item"><a href="#product_freeattribute" class="nav-link" data-toggle="tab"><?php echo JText::_('JSHOP_FREE_ATTRIBUTES')?></a></li>
    <?php }?>
    <li class="nav-item"><a href="#product_images_tab" class="nav-link" data-toggle="tab"><?php echo JText::_('JSHOP_PRODUCT_IMAGES')?></a></li>
    <?php if ($jshopConfig->admin_show_product_video && $this->product->parent_id==0){?>
        <li class="nav-item"><a href="#product_videos" class="nav-link" data-toggle="tab"><?php echo JText::_('JSHOP_PRODUCT_VIDEOS')?></a></li>
    <?php }?>
    <?php if ($jshopConfig->admin_show_product_related && $this->product->parent_id==0){?>
        <li class="nav-item"><a href="#product_related" class="nav-link" data-toggle="tab"><?php echo JText::_('JSHOP_PRODUCT_RELATED')?></a></li>
    <?php }?>
    <?php if ($jshopConfig->admin_show_product_files){?>
        <li class="nav-item"><a href="#product_files" class="nav-link" data-toggle="tab"><?php echo JText::_('JSHOP_FILES')?></a></li>
    <?php }?>
    <?php if ($jshopConfig->admin_show_product_extra_field && $this->product->parent_id==0){?>
        <li class="nav-item"><a href="#product_extra_fields" class="nav-link" data-toggle="tab"><?php echo JText::_('JSHOP_EXTRA_FIELDS')?></a></li>
    <?php }?>
	<?php if ($this->product->parent_id==0){
		$dispatcher->triggerEvent('onDisplayProductEditTabsEndTab', array(&$row, &$lists, &$tax_value));	   
    }else{
		$dispatcher->triggerEvent('onDisplayExtAttributProductEditTabsEndTab', array(&$row, &$lists, &$tax_value));	   		
	}?>
</ul>
<div id="editdata-document" class="tab-content">
<?php
	$pane = null;
	if ($this->product->parent_id==0){
	   include(JPATH_COMPONENT . "/tmpl/product_edit/description.php"); //NOTrequared
	   include(dirname(__FILE__)."/info.php"); // Requaired
	}
	if ($this->product->parent_id==0){
	   $dispatcher->triggerEvent('onDisplayProductEditTabs', array(&$pane, &$row, &$lists, &$tax_value, &$currency));
	}

	if ($this->product->parent_id==0){
		include(dirname(__FILE__)."/attribute_place.php");  // Requaired
	}
	if ($jshopConfig->admin_show_attributes && $this->product->parent_id==0){
		include(JPATH_COMPONENT . "/tmpl/product_edit/attribute.php"); //NOTrequared
	}
	if ($jshopConfig->admin_show_freeattributes && $this->product->parent_id==0){
		include(JPATH_COMPONENT . "/tmpl/product_edit/freeattribute.php"); //NOTrequared
	}
	include(JPATH_COMPONENT . "/tmpl/product_edit/images.php"); // Requaired
	if ($jshopConfig->admin_show_product_video && $this->product->parent_id==0){
		include(JPATH_COMPONENT . "/tmpl/product_edit/videos.php"); //NOTrequared
	}
	if ($jshopConfig->admin_show_product_related && $this->product->parent_id==0){
		include(JPATH_COMPONENT . "/tmpl/product_edit/related.php"); //NOTrequared
	}
	if ($jshopConfig->admin_show_product_files) {
		include(JPATH_COMPONENT . "/tmpl/product_edit/files.php"); //NOTrequared
	}
	if ($jshopConfig->admin_show_product_extra_field && $this->product->parent_id==0){
		include(JPATH_COMPONENT . "/tmpl/product_edit/extrafields.php"); //NOTrequared
	}
	if ($this->product->parent_id==0){
		$dispatcher->triggerEvent('onDisplayProductEditTabsEnd', array(&$pane, &$row, &$lists, &$tax_value, &$currency));
	}else{
		$dispatcher->triggerEvent('onDisplayExtAttributProductEditTabsEnd', array(&$pane, &$row, &$lists, &$tax_value, &$currency));
	}
?>
</div>
<input type="hidden" name="task" value="save" />
<input type="hidden" name="current_cat" value="<?= \JFactory::getApplication()->input->getInt('current_cat', 0)?>" />
<input type="hidden" name="product_id" value="<?= (int)$row->product_id?>" />
<input type="hidden" name="parent_id" value="<?= (int)$row->parent_id?>" />
</form>
</div>

<script type="text/javascript">
var product_price_precision=<?php print intval($jshopConfig->product_price_precision)?>;
jshopAdmin.product_price_precision=<?php print intval($jshopConfig->product_price_precision)?>;
Joomla.submitbutton=function(task){
    if (task=='save' || task=='apply'){
        if (jshop.isEmpty(jQuery('#product_width_image').val()) && jshop.isEmpty(jQuery('#product_height_image'))){
           alert('<?php echo JText::_('JSHOP_WRITE_SIZE_BAD')?>');
           return false;
        }
        <?php if ($this->product->parent_id==0){?>
        if (jQuery('#category_id').val().length==0){
           alert('<?php echo JText::_('JSHOP_WRITE_SELECT_CATEGORY')?>');
           return false;
        }
        <?php }?>
    }
    Joomla.submitform(task, document.getElementById('adminForm'));
}
 
jshopAdmin.showHideAddPrice = function(){
    jQuery('#tr_add_price').style.display = (#product_is_add_price.checked  ? '' : 'none'); //(jQuery('#product_is_add_price').checked  ? '' : 'none');
}
jshopAdmin.showHideAddPrice();
<?php if ($jshopConfig->product_use_main_category_id) {?>
jshopAdmin.reloadSelectMainCategory(jQuery('select#category_id'));
<?php }?>
</script>