<?php
/**
* @version      4.10.0 13.08.2013
* @author       MAXXmarketing GmbH
* @package      Jshopping
* @copyright    Copyright (C) 2010 webdesigner-profi.de. All rights reserved.
* @license      GNU/GPL
*/
defined('_JEXEC') or die('Restricted access');

$rows = $this->rows;
$lists = $this->lists;
$pageNav = $this->pagination;
$text_search = $this->text_search;
$category_id = $this->category_id;
$manufacturer_id = $this->manufacturer_id;
$count = count($rows);
$eName = $this->eName;
$jsfname = $this->jsfname;
$i = 0;
JHtml::_('formbehavior.chosen', '.chosen-select');
?>

<form action="index.php?option=com_jshopping&controller=product_list_selectable&tmpl=component" method="post" name="adminForm" id="adminForm">

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
	<th width="93">
		<?php print _JSHOP_IMAGE; ?>
	</th>
	<th>
	  <?php echo _JSHOP_TITLE; ?>
	</th>
    <?php print $this->tmp_html_col_after_title?>
	<?php if (!$category_id){?>
	<th width="80">
	  <?php echo _JSHOP_CATEGORY;?>
	</th>
	<?php }?>
	<?php if (!$manufacturer_id){?>
	<th width="80">
	  <?php echo _JSHOP_MANUFACTURER;?>
	</th>
	<?php }?>
	<th width="60">
		<?php echo _JSHOP_PRICE;?>
	</th>
	<th width="60">
		<?php echo _JSHOP_DATE;?>
	</th>
	<th width="40" class="center">
	  <?php echo _JSHOP_PUBLISH;?>
	</th>
	<th width="30" class="center">
	  <?php echo _JSHOP_ID;?>
	</th>
  </tr>
</thead> 
<?php foreach ($rows as $row){?>
  <tr class="row<?php echo $i % 2;?>">
   <td>
	 <?php echo $pageNav->getRowOffset($i);?>
   </td>
   <td>
	<?php if ($row->image){?>
		<a href="#" onclick="window.parent.<?php print $jsfname?>(<?php echo $row->product_id; ?>, '<?php echo $eName; ?>')">
			<img src="<?php print getPatchProductImage($row->image, 'thumb', 1)?>" width="90" border="0" />
		</a>
	<?php }?>
   </td>
   <td>
     <b><a href="#" onclick="window.parent.<?php print $jsfname?>(<?php echo $row->product_id; ?>, '<?php echo $eName; ?>')"><?php echo $row->name;?></a></b>
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
   <td>		
    <?php echo formatprice($row->product_price, sprintCurrency($row->currency_id));?>
   </td>
   <td>
	<?php echo formatdate($row->product_date_added, 1);?>
   </td>
   <td class="center">
    <a class="btn btn-micro">
	    <?php if ($row->product_publish){;?>
            <i class="icon-publish"></i>
        <?php }else{?>
            <i class="icon-unpublish"></i>
        <?php }?>
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
	<td colspan="17">
		<div class = "jshop_list_footer"><?php echo $pageNav->getListFooter(); ?></div>
        <div class = "jshop_limit_box"><?php echo $pageNav->getLimitBox(); ?></div>
	</td>
    <?php print $this->tmp_html_col_after_td_foot?>
 </tr>
 </tfoot>   
</table>
<input type="hidden" name="task" value="" />
<input type="hidden" name="hidemainmenu" value="0" />
<input type="hidden" name="boxchecked" value="0" />
<input type="hidden" name="e_name" value="<?php print $eName?>" />
<input type="hidden" name="jsfname" value="<?php print $jsfname?>" />
<?php print $this->tmp_html_end?>
</form>