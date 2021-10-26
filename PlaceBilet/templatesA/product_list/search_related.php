<?php
/**
* @version      4.9.0 13.08.2013
* @author       MAXXmarketing GmbH
* @package      Jshopping
* @copyright    Copyright (C) 2010 webdesigner-profi.de. All rights reserved.
* @license      GNU/GPL
*/
defined('_JEXEC') or die('Restricted access');

$start=intval(PlaceBiletHelper::JRequest()->getInt("start")/$this->limit)+1;
print $this->tmp_html_start;
foreach($this->rows as $row){ ?>      
<div class="block_related" id="serched_product_<?php print $row->product_id;?>">
    <div class="block_related_inner">
        <div class="name"><?php echo $row->name;?> (ID:&nbsp;<?php print $row->product_id?>)</div>
        <div class="image">
            <a href="index.php?option=com_jshopping&controller=products&task=edit&product_id=<?php print $row->product_id?>">
            <?php if ( strlen($row->image) > 0 ) { ?>
                <img src="<?php print getPatchProductImage($row->image, 'thumb', 1)?>" width="90" border="0" />
            <?php } else { ?>
                <img src="<?php print getPatchProductImage($this->config->noimage, '', 1)?>" width="90" border="0" />
            <?php } ?>
            </a>
        </div>
        <div style="padding-top:5px;"><input type="button" class="btn btn-small btn-success" value="<?php print _JSHOP_ADD;?>" onclick="add_to_list_relatad(<?php print $row->product_id;?>)"></div>
    </div>
</div>
<?php
}
?>
<div class="clr"></div>

<?php if ($this->pages>1){?>
<table align="center">
<tr>
    <td><?php print _JSHOP_PAGE?>: </td>
    <td>
    <div class="pagination">
        <div class="button2-left">
        <div class="page">
            <?php
            $pstart=$start - 9;
            if ($pstart<1) $pstart=1;
            $pfinish=$start + 9;
            if ($pfinish>$this->pages) $pfinish=$this->pages;
            ?>
            <?php if ($pstart>1){?>
                <a onclick="return false;" href="#">...</a>
            <?php }?>
            <?php for($i=$pstart;$i<=$pfinish; $i++){?>
                <a onclick="releted_product_search(<?php print ($i-1)*$this->limit;?>, <?php print $this->no_id?>);return false;" href="#"><?php print $i;?></a>
            <?php } ?>
            <?php if ($pfinish<$this->pages){?>
                <a onclick="return false;" href="#">...</a>
            <?php }?>
        </div>
        </div>
    </div>
    </td>
</tr>    
</table>
<div class="clr"></div>
<?php }?>
<?php print $this->tmp_html_end?>