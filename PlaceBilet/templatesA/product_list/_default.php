<?php
/**
* @version      4.10.0 09.04.2014
* @author       MAXXmarketing GmbH
* @package      Jshopping
* @copyright    Copyright (C) 2010 webdesigner-profi.de. All rights reserved.
* @license      GNU/GPL
*/
defined('_JEXEC') or die('Restricted access');

$rows=$this->rows;
$lists=$this->lists;
$pageNav=$this->pagination;
$text_search=$this->text_search;
$category_id=$this->category_id;
$manufacturer_id=$this->manufacturer_id;
$count=count ($rows);
$i=0;
$saveOrder=$this->filter_order_Dir=="asc" && $this->filter_order=="ordering";
JHtml::_('formbehavior.chosen', '.chosen-select');
?>
<div id="j-sidebar-container" class="span2">
    <?php echo $this->sidebar; ?>
</div>
<div id="j-main-container" class="span10">
<form action="index.php?option=com_jshopping&controller=products" method="post" name="adminForm" id="adminForm">
<?php print $this->tmp_html_start?>

<div class="js-stools clearfix jshop_block_filter">
    
    <div class="js-stools-container-bar">
        <div class="filter-search btn-group pull-left">
            <input type="text" id="text_search" name="text_search" placeholder="<?php print _JSHOP_SEARCH?>" value="<?php echo htmlspecialchars($text_search);?>" />
        </div>

        <div class="btn-group pull-left hidden-phone">
            <button class="btn hasTooltip" type="submit" title="<?php print _JSHOP_SEARCH?>">
                <i class="icon-search"></i>
            </button>
            <button class="btn hasTooltip" onclick="document.id('text_search').value='';this.form.submit();" type="button" title="<?php print _JSHOP_CLEAR?>">
                <i class="icon-remove"></i>
            </button>
        </div>
        
    </div>
    
    <div class="clearfix"></div>
    
    <div class="js-stools-container-filters">
    
        <?php print $this->tmp_html_filter?>
    
        <div class="js-stools-field-filter">
            <?php echo $lists['treecategories'];?>
        </div>
        <div class="js-stools-field-filter">
            <?php echo $lists['manufacturers'];?>
        </div>
        
        <?php if ($this->show_vendor) : ?>
            <div class="js-stools-field-filter">
                <?php echo $lists['vendors'];?>
            </div>
        <?php endif; ?>
        
        <?php if ($this->config->admin_show_product_labels){?>
            <div class="js-stools-field-filter">
                <?php echo $lists['labels']?>
            </div>
        <?php }?>
        
        <div class="js-stools-field-filter">
            <?php echo $lists['publish'];?>
        </div>
    </div>
    
</div>

<table class="table table-striped" >
<thead> 
  <tr>
    <th class="title" width ="10">
      #
    </th>
    <th width="20">
      <input type="checkbox" name="checkall-toggle" value="" title="<?php echo JText::_('JGLOBAL_CHECK_ALL'); ?>" onclick="Joomla.checkAll(this)" />
    </th>
    <th width="93">
        <?php echo JHTML::_('grid.sort', _JSHOP_IMAGE, 'product_name_image', $this->filter_order_Dir, $this->filter_order)?>
    </th>
    <th>
      <?php echo JHTML::_('grid.sort', _JSHOP_TITLE, 'name', $this->filter_order_Dir, $this->filter_order)?>
    </th>
    <?php print $this->tmp_html_col_after_title?>
    <?php if (!$category_id){?>
    <th width="80">
        <?php echo JHTML::_('grid.sort', _JSHOP_CATEGORY, 'category', $this->filter_order_Dir, $this->filter_order)?>
    </th>
    <?php }?>
    <?php if (!$manufacturer_id){?>
    <th width="80">
        <?php echo JHTML::_( 'grid.sort', _JSHOP_MANUFACTURER, 'manufacturer', $this->filter_order_Dir, $this->filter_order)?>
    </th>
    <?php }?>
    <?php if ($this->show_vendor){?>
    <th width="80">
      <?php echo JHTML::_( 'grid.sort', _JSHOP_VENDOR, 'vendor', $this->filter_order_Dir, $this->filter_order)?>
    </th>
    <?php }?>
    <th width="80">
        <?php echo JHTML::_( 'grid.sort', _JSHOP_EAN_PRODUCT, 'ean', $this->filter_order_Dir, $this->filter_order);?>
    </th>
    <?php if ($this->config->stock){?>
    <th width="60">
        <?php echo JHTML::_( 'grid.sort', _JSHOP_QUANTITY, 'qty', $this->filter_order_Dir, $this->filter_order);?>
    </th>
    <?php }?>
    <th width="80">
        <?php echo JHTML::_( 'grid.sort', _JSHOP_PRICE, 'price', $this->filter_order_Dir, $this->filter_order);?>
    </th>
    <th width="40">
        <?php echo JHTML::_( 'grid.sort', _JSHOP_HITS, 'hits', $this->filter_order_Dir, $this->filter_order);?>
    </th>
    <th width="60">
        <?php echo JHTML::_( 'grid.sort', _JSHOP_DATE, 'date', $this->filter_order_Dir, $this->filter_order);?>
    </th>
    <?php if ($category_id) {?>
    <th colspan="3" width="40">
      <?php echo JHTML::_( 'grid.sort', _JSHOP_ORDERING, 'ordering', $this->filter_order_Dir, $this->filter_order);?>      
      <?php if ($saveOrder){?>      
      <?php echo JHtml::_('grid.order',  $rows, 'filesave.png', 'saveorder');?>
      <?php }?>
    </th>
    <?php }?>
    <th width="40" class="center">
      <?php echo _JSHOP_PUBLISH;?>
    </th>    
    <th width="40" class="center">
        <?php echo _JSHOP_DELETE;?>
    </th>
    <th width="30" class="center">
      <?php echo JHTML::_( 'grid.sort', _JSHOP_ID, 'product_id', $this->filter_order_Dir, $this->filter_order);?>
    </th>
  </tr>
</thead> 
<?php foreach($rows as $row){?>
  <tr class="row<?php echo $i % 2;?>">
   <td>
     <?php echo $pageNav->getRowOffset($i);?>
   </td>
   <td>
     <?php echo JHtml::_('grid.id', $i, $row->product_id);?>
   </td>
   <td>
    <?php if ($row->label_id){?>
        <div class="product_label">
            <?php if (isset($row->_label_image) && $row->_label_image){?>
                <img src="<?php print $row->_label_image?>" width="25" alt="" />
            <?php }else{?>
                <span class="label_name"><?php print $row->_label_name;?></span>
            <?php }?>
        </div>
    <?php }?>
    <?php if ($row->image){?>
        <a href="index.php?option=com_jshopping&controller=products&task=edit&product_id=<?php print $row->product_id?>">
            <img src="<?php print getPatchProductImage($row->image, 'thumb', 1)?>" width="90" border="0" />
        </a>
    <?php }?>
   </td>
   <td>
     <b><a href="index.php?option=com_jshopping&controller=products&task=edit&product_id=<?php print $row->product_id?>"><?php echo $row->name;?></a></b>
     <div><?php echo $row->short_description;?></div>
   </td>
   <?php print $row->tmp_html_col_after_title?>
   <?php if (!$category_id){?>
   <td>
      <?php echo $row->namescats;?>
   </td>
   <?php }?>
   <?php if (!$manufacturer_id){?>
   <td>
      <?php echo $row->man_name;?>
   </td>
   <?php }?>
   <?php if ($this->show_vendor){?>
   <td>
        <?php echo $row->vendor_name;?>
   </td>
   <?php }?>
   <td>
    <?php echo $row->ean?>
   </td>
   <?php if ($this->config->stock){?>
   <td>
    <?php if ($row->unlimited){
        print _JSHOP_UNLIMITED;
    }else{
        echo floatval($row->qty);
    }
    ?>
   </td>
   <?php }?>
   <td>
    <?php echo formatprice($row->product_price, sprintCurrency($row->currency_id));?>
   </td>
   <td>
    <?php echo $row->hits;?>
   </td>
   <td>
    <?php echo formatdate($row->product_date_added, 1);?>
   </td>
   <?php if ($category_id) {?>
   <td align="right" width="20">
    <?php
      if ($i!=0 && $saveOrder) echo '<a class="btn btn-micro" href="index.php?option=com_jshopping&controller=products&task=order&product_id='.$row->product_id.'&category_id='.$category_id.'&order=up&number='.$row->product_ordering.'"><i class="icon-uparrow"></i></a>';
    ?>
   </td>
   <td align="left" width="20">
      <?php
        if ($i!=($count-1) && $saveOrder) echo '<a class="btn btn-micro" href="index.php?option=com_jshopping&controller=products&task=order&product_id='.$row->product_id.'&category_id='.$category_id.'&order=down&number='.$row->product_ordering.'"><i class="icon-downarrow"></i></a>';
      ?>
   </td>
   <td align="center" width="10">
    <input type="text" name="order[]" id="ord<?php echo $row->product_id;?>" value="<?php echo $row->product_ordering; ?>" <?php if (!$saveOrder) echo 'disabled'?> class="inputordering" />
   </td>
   <?php }?>   
   <td class="center">     
     <?php echo JHtml::_('jgrid.published', $row->product_publish, $i);?>
   </td>
      
   <td class="center">
    <a class="btn btn-micro" href='index.php?option=com_jshopping&controller=products&task=remove&cid[]=<?php print $row->product_id?>' onclick="return confirm('<?php print _JSHOP_DELETE?>')">
        <i class="icon-delete"></i>
    </a>
   </td>
   <td class="center">
     <?php echo $row->product_id; ?>
   </td>
  </tr>
<?php
$i++;
}
?>
<tfoot>
<tr>
    <?php print $this->tmp_html_col_before_td_foot?>
    <td colspan="18">
		<div class = "jshop_list_footer"><?php echo $pageNav->getListFooter(); ?></div>
        <div class = "jshop_limit_box"><?php echo $pageNav->getLimitBox(); ?></div>
	</td>
    <?php print $this->tmp_html_col_after_td_foot?>
</tr>
</tfoot>
</table>
<input type="hidden" name="filter_order" value="<?php echo $this->filter_order?>" />
<input type="hidden" name="filter_order_Dir" value="<?php echo $this->filter_order_Dir?>" />
<input type="hidden" name="task" value="" />
<input type="hidden" name="hidemainmenu" value="0" />
<input type="hidden" name="boxchecked" value="0" />
<?php print $this->tmp_html_end?>
</form>
</div>