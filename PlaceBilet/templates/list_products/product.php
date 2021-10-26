<?php 
/**
* @version      4.5.0 05.11.2013
* @author       MAXXmarketing GmbH
* @package      Jshopping
* @copyright    Copyright (C) 2010 webdesigner-profi.de. All rights reserved.
* @license      GNU/GPL
*/
defined('_JEXEC') or die('Restricted access');


if(class_exists('PlaceBiletHelper'))
    $params = PlaceBiletHelper::$params->toObject();//Registry

$currencies = JSFactory::getAllCurrency();
$cur_name = $currencies[$product->currency_id]->currency_name??JText::_('JSHOP_CURRENCY');//currency_id,currency_name,currency_code,currency_code_iso,currency_value
$cur_code = $currencies[$product->currency_id]->currency_code??JText::_('JSHOP_CUR');

$text_listprod_city = $params->text_listprod_city??'';
$text_listprod_order = $params->text_listprod_order??'';
$view_text = $params->view_text??'';
?>
<?php print $product->_tmp_var_start?>
<div class="blockcard"> 
    <?php 
    $bonus = 0;
    if(class_exists('PlaceBiletHelper')){
        $bonus = (float )PlaceBiletHelper::getBonusProduct($product->date_event);
        $bonus = PlaceBiletHelper::getBonusProductPercent($bonus);
    } 
    if($bonus)
            echo "<span class='bonus'>&nbsp; &NonBreakingSpace; {$bonus}%</span>";
    //toPrint($bonus,'$bonus');
    //toPrint($text_listprod_city,'$text_listprod_city');
    //toPrint($view_text,'$view_text');
    ?>
    
        <div class="name">
            <a href="<?php print $product->product_link?>"><?php print $product->name?></a>
            <?php if ($this->config->product_list_show_product_code){?><span class="jshop_code_prod">(<?php print _JSHOP_EAN?>: <span><?php print $product->product_ean;?></span>)</span><?php }?>
        </div>
<?php if($text_listprod_city&&$view_text) { ?><div class="moskva city"><?=$text_listprod_city?></div><?php }?>
        <?php if ($product->image){?>
        <div class="image_block"> 
			<?php print $product->_tmp_var_image_block;?>
            <?php if ($product->label_id){?>
                <div class="product_label">
                    <?php if ($product->_label_image){?>
                        <img src="<?php print $product->_label_image?>" alt="<?php print htmlspecialchars($product->_label_name)?>" />
                    <?php }else{?>
                        <span class="label_name"><?php print $product->_label_name;?></span>
                    <?php }?>
                </div>
            <?php }?>
            <a href="<?php print $product->product_link?>">
                <img class="jshop_img <?= (substr($product->image, -11)=='noimage.gif')?'noimage':'' ?>" src="<?php print $product->image?>" alt="<?php print htmlspecialchars($product->name);?>" title="<?php print htmlspecialchars($product->name);?>" />
            </a>
        </div>
        <?php }?>
<div class="product productitem_<?php print $product->product_id?>">
    


        <?php if ($product->product_old_price > 0){?>
            <div class="old_price"><?php if ($this->config->product_list_show_price_description) print _JSHOP_OLD_PRICE.": ";?><span><?php print formatprice($product->product_old_price)?></span></div>
        <?php }?>
		<?php print $product->_tmp_var_bottom_old_price;?>
        <?php if ($product->product_price_default > 0 && $this->config->product_list_show_price_default){?>
            Цена: <div class="default_price"><?php print _JSHOP_DEFAULT_PRICE.": ";?><span class="cost"><?php print formatprice($product->product_price_default)?><span></span></div>
        <?php }?>
        <?php if ($product->_display_price){?>
            <div class = "jshop_price"> Цена: 
                <?php if ($this->config->product_list_show_price_description) print _JSHOP_PRICE.": ";?>
                <?php if ($product->show_price_from) print _JSHOP_FROM." ";?>
                <span class="cost"><?php print formatprice($product->product_price);?><?php print $product->_tmp_var_price_ext;?></span>
            </div>
        <?php }?>
        <?php print $product->_tmp_var_bottom_price;?>
        <?php if ($this->config->show_tax_in_product && $product->tax > 0){?>
            <span class="taxinfo"><?php print productTaxInfo($product->tax);?></span>
        <?php }
        
        
        
        
        
        
        
        
        
        
         
        
        $datetime = $td = strtotime($product->date_event); 
        $dt = $product->date_event;
        
        ?>
        <div class="date">
        <a href="<?= $product->product_link;?>">
            <time datetime="<?php print $product->date_event?>" class="date"  title="<?php echo $dt ?>">
            <span class="lbl jdate"><?= JText::_('JDATE')?>:</span> <span class="month"  title="<?php echo $dt ?>"><span class="day"><?= date("j", $td); ?></span> <?= JText::_(date("F", $td))?></span><br/>
            <span class="lbl jday"><?= JText::_('JDAY')?>:</span> <span class="weekday"><?= JText::_(date("l", $td))?></span><br/>
            <span class="lbl jtime"><?= JText::_('JTIME')?>:</span> <span class="time"><?= date("H:i", $td); ?></span><br/>
        </time></a>
        <?php //print $product->date_event; ?>
           
        </div>
        <div class="description">
            <?php print $product->short_description?>
        </div>
        <?php if ($product->manufacturer->name){?>
            <div class="manufacturer_name"><?php print _JSHOP_MANUFACTURER;?>: <span><?php print $product->manufacturer->name?></span></div>
        <?php }?>
        <?php if ($product->product_quantity <=0 && !$this->config->hide_text_product_not_available){?>
            <div class="not_available"><?php print _JSHOP_PRODUCT_NOT_AVAILABLE;?></div>
        <?php }?>
        
        <?php if ($this->config->show_plus_shipping_in_product){?>
            <span class="plusshippinginfo"><?php print sprintf(_JSHOP_PLUS_SHIPPING, $this->shippinginfo);?></span>
        <?php }?>
        <?php if ($product->basic_price_info['price_show']){?>
            <div class="base_price"><?php print _JSHOP_BASIC_PRICE?>: <?php if ($product->show_price_from) print _JSHOP_FROM;?> <span><?php print formatprice($product->basic_price_info['basic_price'])?> / <?php print $product->basic_price_info['name'];?></span></div>
        <?php }?>
        <?php if ($this->config->product_list_show_weight && $product->product_weight > 0){?>
            <div class="productweight"><?php print _JSHOP_WEIGHT?>: <span><?php print formatweight($product->product_weight)?></span></div>
        <?php }?>
        <?php if ($product->delivery_time != ''){?>
            <div class="deliverytime"><?php print _JSHOP_DELIVERY_TIME?>: <span><?php print $product->delivery_time?></span></div>
        <?php }?>
        <?php if (is_array($product->extra_field)){?>
            <div class="extra_fields">
            <?php foreach($product->extra_field as $extra_field){?>
                <div><?php print $extra_field['name'];?>: <?php print $extra_field['value']; ?></div>
            <?php }?>
            </div>
        <?php }?>
        <?php if ($this->allow_review){?>
        <table class="review_mark"><tr><td><?php print showMarkStar($product->average_rating);?></td></tr></table>
        <div class="count_commentar">
            <?php print sprintf(_JSHOP_X_COMENTAR, $product->reviews_count);?>
        </div>
        <?php }?>
        <?php print $product->_tmp_var_bottom_foto;?>
        <?php if ($product->vendor){?>
            <div class="vendorinfo"><?php print _JSHOP_VENDOR?>: <a href="<?php print $product->vendor->products?>"><?php print $product->vendor->shop_name?></a></div>
        <?php }?>
        <?php if ($this->config->product_list_show_qty_stock){?>
            <div class="qty_in_stock"><?php print _JSHOP_QTY_IN_STOCK?>: <span><?php print sprintQtyInStock($product->qty_in_stock)?></span></div>
        <?php }?>
        <?php print $product->_tmp_var_top_buttons;?>

        <?php print $product->_tmp_var_bottom_buttons;?>

		<?= $this->param->bilets_list_min_addprice ?
				" <div class='min_addprice $cur_code'>".PlaceBiletHelper::RoundPrice($product->min_addprice)." $cur_code</div" : '' ?>
		<?php if($this->param->bilets_list_count) echo " <div class='count'>$product->count</div>"?>
</div>
<?php if($text_listprod_order&&$view_text) { ?><div class="moskva order"> <a class="button_detail" href="<?= $product->product_link?>"><?=$text_listprod_order?></a></div><?php }?>
<div class="buttons">
    <?php if ($product->buy_link){?>
        <a class="button_buy" href="<?= $product->buy_link?>"><?php print _JSHOP_BUY?></a> &nbsp;
    <?php }?>
			<a class="button_detail" href="<?php print $product->product_link?>">
				<?= $this->param->bilets_list_count_text ? "<span class='lbl'>$this->param->bilets_list_count_text</span>" : JText::_('JSHOP_BAY'); ?>
				
				
			</a>
    <?= $product->_tmp_var_buttons;?>
</div>

</div>
<?php print $product->_tmp_var_end?>