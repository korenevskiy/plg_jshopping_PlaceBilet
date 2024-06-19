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
<form action="<?php print $this->action;?>" method="post" name="sort_count" id="sort_count">
<?php if ($this->config->show_sort_product || $this->config->show_count_select_products){?>
<div class="block_sorting_count_to_page">
    <?php if ($this->config->show_sort_product){?>
	<span class="box_products_sorting"><?php print __('JSHOP_ORDER_BY').": ".$this->sorting?><img src="<?php print $this->path_image_sorting_dir?>" alt="orderby" onclick="submitListProductFilterSortDirection()" /></span>
    <?php }?>
    <?php if ($this->config->show_count_select_products){?>
	<span class="box_products_count_to_page"><?php print __('JSHOP_DISPLAY_NUMBER').": ".$this->product_count?></span>
    <?php }?>
</div>
<?php }?>

<?php if ($this->config->show_product_list_filters && $this->filter_show){?>
    <?php if ($this->config->show_sort_product || $this->config->show_count_select_products){?>
    <div class="margin_filter"></div>
    <?php }?>
    
    <div class="jshop filters">    
        <?php if ($this->filter_show_category){?>
        <span class="box_category"><?php print __('JSHOP_CATEGORY').": ".$this->categorys_sel?></span>
        <?php }?>
        <?php if ($this->filter_show_manufacturer){?>
        <span class="box_manufacrurer"><?php print __('JSHOP_MANUFACTURER').": ".$this->manufacuturers_sel?></span>
        <?php }?>
        <?php print $this->_tmp_ext_filter_box;?>
        
        <?php if (getDisplayPriceShop()){?>
        <span class="filter_price"><?php print __('JSHOP_PRICE')?>:
            <span class="box_price_from"><?php print __('JSHOP_FROM')?> <input type="text" class="inputbox" name="fprice_from" id="price_from" size="7" value="<?php if ($this->filters['price_from']>0) print $this->filters['price_from']?>" /></span>
            <span class="box_price_to"><?php print __('JSHOP_TO')?> <input type="text" class="inputbox" name="fprice_to"  id="price_to" size="7" value="<?php if ($this->filters['price_to']>0) print $this->filters['price_to']?>" /></span>
            <?php print $this->config->currency_code?>
        </span>
        <?php }?>
        
        <?php print $this->_tmp_ext_filter;?>
        <input type="button" class="button" value="<?php print __('JSHOP_GO')?>" onclick="submitListProductFilters();" />
        <span class="clear_filter"><a href="#" onclick="clearProductListFilter();return false;"><?php print __('JSHOP_CLEAR_FILTERS')?></a></span>
    </div>
<?php }?>
<input type="hidden" name="orderby" id="orderby" value="<?php print $this->orderby?>" />
<input type="hidden" name="limitstart" value="0" />
</form>