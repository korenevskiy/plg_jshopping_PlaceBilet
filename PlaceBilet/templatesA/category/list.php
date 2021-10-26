<?php 
/**
* @version      4.10.0 05.11.2013
* @author       MAXXmarketing GmbH
* @package      Jshopping
* @copyright    Copyright (C) 2010 webdesigner-profi.de. All rights reserved.
* @license      GNU/GPL
*/
defined('_JEXEC') or die('Restricted access');
$categories = $this->categories; 
$i = 0;
$text_search = $this->text_search;
$count = count($categories); 
$pageNav = $this->pagination;
$saveOrder = $this->filter_order_Dir=="asc" && $this->filter_order=="ordering";
?>
<div id="j-sidebar-container" class="span2">
    <?php echo $this->sidebar; ?>
</div>
<div id="j-main-container" class="span10">
<form action="index.php?option=com_jshopping&controller=categories" method="post" enctype="multipart/form-data" name="adminForm" id="adminForm">
<?php print $this->tmp_html_start?>

<div id="filter-bar" class="btn-toolbar">

    <?php print $this->tmp_html_filter?> 

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
<?php // "<pre>". print_r($categories[0],true)."</pre>" ?>
<table class="table table-striped">
<thead>
  <tr>
    <th class="title" width ="10">#</th>
    <th width="20">
      <input type="checkbox" name="checkall-toggle" value="" title="<?php echo JText::_('JGLOBAL_CHECK_ALL'); ?>" onclick="Joomla.checkAll(this)" />
    </th>
    <th width="200" align="left">
      <?php echo JHTML::_('grid.sort', _JSHOP_TITLE, 'name', $this->filter_order_Dir, $this->filter_order); ?>
    </th>
    <?php print $this->tmp_html_col_after_title?>
    <th align="left">
      <?php echo JHTML::_('grid.sort', _JSHOP_DESCRIPTION, 'description', $this->filter_order_Dir, $this->filter_order); ?>
    </th>
    <th width="80" align="left">
      <?php echo _JSHOP_CATEGORY_PRODUCTS;?>
    </th>    
    <th colspan="3" width="40">
      <?php echo JHTML::_( 'grid.sort', _JSHOP_ORDERING, 'ordering', $this->filter_order_Dir, $this->filter_order); ?>
      <?php if ($saveOrder){?>
      <?php echo JHtml::_('grid.order',  $categories, 'filesave.png', 'saveorder');?>
      <?php }?>
    </th>
    <th width="50" class="center">
      <?php echo _JSHOP_PUBLISH;?>
    </th>
    <th width="50" class="center">
        <?php echo _JSHOP_EDIT;?>
    </th>
    <th width="50" class="center">
        <?php echo _JSHOP_DELETE;?>
    </th>
    <th width="50" class="center">
        <?php echo JHTML::_( 'grid.sort', _JSHOP_ID, 'id', $this->filter_order_Dir, $this->filter_order); ?>
    </th>
  </tr>
  </thead>  
<?php foreach($categories as $category) { ?>
  <tr class="row<?php echo $i % 2;?>">
   <td>
     <?php echo $pageNav->getRowOffset($i);?>
   </td>
   <td>     
     <?php echo JHtml::_('grid.id', $i, $category->category_id);?>
   </td>
   <td>
     <?php print $category->space; ?><a href = "index.php?option=com_jshopping&controller=categories&task=edit&category_id=<?php echo $category->category_id; ?>"><?php echo $category->name;?></a>
     
     <?php //echo $category->category_parent_id ?> <div title="ID репертуара и сцены." style="margin-left:20px; opacity: 0.3; font-size: 12px;"><?= (isset($category->RepertoireId))?'RepertoireId: '.$category->RepertoireId:'';?><?= (isset($category->StageId))?', StageId: '.$category->StageId:'';?></div>
   </td>
   <?php print $category->tmp_html_col_after_title?>
   <td>
     <?php echo $category->short_description;?>
   </td>
   <td align="center">
     <?php if (isset($this->countproducts[$category->category_id])){?>
     <a href="index.php?option=com_jshopping&controller=products&category_id=<?php echo $category->category_id?>">
       (<?php print intval($this->countproducts[$category->category_id]);?>) <img src="components/com_jshopping/images/tree.gif" border="0" />
     </a>
     <?php }else{?>
     (0)
     <?php }?>
   </td>
   <td align = "right" width = "20">
        <?php if ($saveOrder && $category->isPrev) echo '<a class="btn btn-micro" href = "index.php?option=com_jshopping&controller=categories&task=order&id='.$category->category_id.'&move=-1"><i class="icon-uparrow"></i></a>'; ?>
    </td>
    <td align = "left" width = "20"> 
        <?php if ($saveOrder && $category->isNext) echo '<a class="btn btn-micro" href = "index.php?option=com_jshopping&controller=categories&task=order&id='.$category->category_id.'&move=1"><i class="icon-downarrow"></i></a>'; ?>
    </td>
    
   <td align="center" width="10">
    <input type="text" name="order[]" id="ord<?php echo $category->category_id;?>" value="<?php echo $category->ordering;?>"  <?php if (!$saveOrder) echo 'disabled'?> class="inputordering" />
   </td>
   <td class="center">     
     <?php echo JHtml::_('jgrid.published', $category->category_publish, $i);?>
   </td>
   <td class="center">
        <a class="btn btn-micro" href='index.php?option=com_jshopping&controller=categories&task=edit&category_id=<?php print $category->category_id?>'>
            <i class="icon-edit"></i>
        </a>
   </td>
   <td class="center">
        <a class="btn btn-micro" href='index.php?option=com_jshopping&controller=categories&task=remove&cid[]=<?php print $category->category_id?>' onclick="return confirm('<?php print _JSHOP_DELETE?>');">
            <i class="icon-delete"></i>
        </a>
   </td>
   <td class="center">
    <?php print $category->category_id?>
   </td>
  </tr>
<?php $i++; } ?>
<tfoot>
<tr>
    <?php print $this->tmp_html_col_before_td_foot?>
    <td colspan = "12">
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