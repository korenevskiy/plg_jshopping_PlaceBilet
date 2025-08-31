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
use Joomla\CMS\Language\Text as JText;
use Joomla\CMS\Date\Date as JDate;
use Joomla\Component\Jshopping\Site\Lib\JSFactory;
use Joomla\Plugin\Jshopping\Placebilet\Helper\Helper as PlaceBiletHelper;
use Joomla\Component\Jshopping\Site\Helper\Helper as JSHelper;
defined('_JEXEC') or die('Restricted access');


//if(class_exists('PlaceBiletHelper'))
//    $params = PlaceBiletHelper::$param;//Registry ->toObject()

$param = &$this->param;

//$this->param

//\Joomla\CMS\Factory::$application->enqueueMessage("<pre>\$this->param ".print_r($this->param,true)."</pre>");
//\Joomla\CMS\Factory::$application->enqueueMessage("<pre>\$this->params ".print_r($this->params,true)."</pre>");

$currencies = JSFactory::getAllCurrency();
$cur_name = $currencies[$product->currency_id]->currency_name??JText::_('JSHOP_CURRENCY');//currency_id,currency_name,currency_code,currency_code_iso,currency_value
$cur_code = $currencies[$product->currency_id]->currency_code??JText::_('JSHOP_CUR');

$text_listprod_city = $param->text_listprod_city??'';
$text_listprod_order = $param->text_listprod_order??'';
$view_text = $param->view_text??'';
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
            <?php if ($this->config->product_list_show_product_code){?><span class="jshop_code_prod">(<?php print JText::_('JSHOP_EAN')?>: <span><?php print $product->product_ean;?></span>)</span><?php }?>
        </div>
		
		<?php if($text_listprod_city&&$view_text) { ?><div class="moskva city"><?=$text_listprod_city?></div><?php }?>
		
        <?php if ($product->image && !str_ends_with($product->image, 'noimage.png') && !str_ends_with($product->image, 'noimage.gif')){
		//echo $product->image;	?>
		
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

 

 
<div 
  class="product productitem_<?php print $product->product_id?>">
   


        <?php if ($product->product_old_price > 0){?>
	<div class="old_price"><?php if ($this->config->product_list_show_price_description) print JText::_('JSHOP_OLD_PRICE').": ";?><span><?php print JSHelper::formatprice($product->product_old_price)?></span></div>
        <?php }?>
		<?php print $product->_tmp_var_bottom_old_price;?>
        <?php if ($product->product_price_default > 0 && $this->config->product_list_show_price_default){?>

			<div class="default_price"><?php print JText::_('JSHOP_DEFAULT_PRICE').": ";?><span class="cost"><?php print JSHelper::formatprice($product->product_price_default)?><span></span></div>
        <?php }?>
        <?php if ($product->_display_price){?>
            <div class = "jshop_price"> 

                <?php if ($this->config->product_list_show_price_description) print JText::_('JSHOP_PRICE').": ";?>
                <?php if ($product->show_price_from) print JText::_('JSHOP_FROM')." ";?>
                <span class="cost"><?php print JSHelper::formatprice($product->product_price);?><?php print $product->_tmp_var_price_ext;?></span>
            </div>
        <?php }?>
			
        <?php print $product->_tmp_var_bottom_price;?>
			
        <?php if ($this->config->show_tax_in_product && $product->tax > 0){?>
            <span class="taxinfo"><?php print productTaxInfo($product->tax);?></span>
        <?php } ?>
			
			
		<?php
		
		$tz = PlacebiletHelper::getTimezone();
		
//toPrint(null,'',0,'');
        
//https://v3c.ru/obo-vsjom/name-day 
//		const monthsEn = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
//		const monthsRu = ['Янв', 'Фев', 'Мар', 'Апр', 'Май', 'Июн', 'Июл', 'Авг', 'Сен', 'Окт', 'Ноя', 'Дек'];
        
//        5/05/23-6/06/23
//toPrint($product->date_tickets,'$product->date_tickets',true, 'message',true );// 2023-04-24 01:00:00  // 0000-00-00 00:00:00

		
		

        $de = \JDate::getInstance($product->date_event, $tz);
		
        $d = \JDate::getInstance($product->date_tickets, $tz);
//		$tt = $d->getOffsetFromGmt();

//		$is_period = empty(in_array($product->date_tickets, [0, '0000-00-00 00:00:00'])) && 0<(int)$d->year && 0<(int)$d->month && 0<(int)$d->day && empty((int)$d->hour) && empty((int)$d->minute) && empty((int)$d->second);
        
		
        $is_event = in_array($product->date_tickets, [0, '0000-00-00 00:00:00']) ||			// 
				$d->year == $de->year && $d->month == $de->month && $d->day == $de->day ||	//
				$d->year == '-0001' && $d->month == '11' && $d->day == '30' ||				// 
				$d->year == -1 && $d->month == 11 && $d->day == 30 ||						// 
				$d->year == -1 && $d->month == 11 && $d->day == 30 ||						// 
				$d->year == 0 && $d->month == 0 && $d->day == 0;							// 
        
//toPrint($tt,'$tt',true, 'message',true );// 2023-04-24 01:00:00  // 0000-00-00 00:00:00
//toPrint(date("l", $t),  ':('.$product->date_tickets . ''
//		. ' 1:' .in_array($product->date_tickets, [0, '0000-00-00 00:00:00'])
//		. ' 2:' .($d->year == $de->year && $d->month == $de->month && $d->day == $de->day)
//		. ' 3:' .($d->year == '-0001' && $d->month == '11' && $d->day == '30' )
//		. ' 4:' .($d->year == -1 && $d->month == 11 && $d->day == 30)
//		. ' 5:' .($d->year == -1 && $d->month == 11 && $d->day == 30)
//		. ' 6:' .($d->year == 0 && $d->month == 0 && $d->day == 0)
//		.  ' '. $product->product_id,true, 'message',true );// 2023-04-24 01:00:00  // 0000-00-00 00:00:00

//toPrint($d,'Ticket '.$product->product_id,true, 'message',true );
//toPrint($d->toSql(true),'Ticket '.$product->product_id,true, 'message',true );
//toPrint($de->toSql(true),'Event '.$product->product_id,true, 'message',true );
         
		
        $t = strtotime($product->date_event); 
        $dt = $product->date_event;
//toPrint($de->format(' j: F  H:i        ', true),'Ticket '.$product->product_id,true, 'message',true);
        
        ?>

        <div class="date type<?= $is_event?'Event':'Period'?>">
        <a href="<?= $product->product_link;?>"  title="<?= $product->date_event ?>">
		
		<?php if($is_event): ?>
		<time datetime="<?= $product->date_event?>" class="date typeEvent"  title="<?= $product->date_event ?>">
            <span class="lbl jdate"><?= JText::_('JDATE')?>:</span> <span class="month"  title="<?= $dt ?>"><span class="day"><?= date("j", $t); ?></span> <?= JText::_('JSHOP_PLACE_BILET_MONTH_'.date("m", $t))?></span><br/>
            <span class="lbl jday"><?= JText::_('JDAY')?>:</span> <span class="weekday"><?= JText::_(date("l", $t))?></span><br/>
            <span class="lbl jtime"><?= JText::_('JTIME')?>:</span> <span class="time"><?= date("H:i", $t); ?></span><br/>
        </time>
		<?php else: ?>
		<time datetime="<?= $product->date_tickets?>" class="date typePeriod"  title="<?= $product->date_tickets ?>">
            <span class="lbl jdate first"><?= JText::_('JDATE')?>:</span>
			<span class="month"  title="<?= $dt ?>"><span class="day"><?= $d->format("j", true); ?></span> <?= JText::_('JSHOP_PLACE_BILET_MONTH_'.$d->format("m", true))?></span>
			<br/>
            <span class="dash"> — </span>
			<br/>
			<span class="lbl jdate last"><?= JText::_('JDATE')?>:</span> 
			<span class="month"  title="<?= $product->date_event ?>"><span class="day"><?= date("j", $t); ?></span> <?= JText::_('JSHOP_PLACE_BILET_MONTH_'.date("m", $t))?></span><br/>
        </time>
		<?php endif; ?>
		</a>
        <?php //print $product->date_event; ?>
        </div>

        <div class="description">
            <?php print $product->short_description?>
        </div>
        <?php if ($product->manufacturer->name){?>
            <div class="manufacturer_name"><?php print JText::_('JSHOP_MANUFACTURER');?>: <span><?php print $product->manufacturer->name?></span></div>
        <?php }?>
        <?php if ($product->product_quantity <=0 && !$this->config->hide_text_product_not_available){?>
            <div class="not_available"><?php print JText::_('JSHOP_PRODUCT_NOT_AVAILABLE');?></div>
        <?php }?>
        
        <?php if ($this->config->show_plus_shipping_in_product){?>
            <span class="plusshippinginfo"><?php print sprintf(JText::_('JSHOP_PLUS_SHIPPING'), $this->shippinginfo);?></span>
        <?php }?>
        <?php if ($product->basic_price_info['price_show']){?>
            <div class="base_price"><?php print JText::_('JSHOP_BASIC_PRICE')?>: <?php if ($product->show_price_from) print JText::_('JSHOP_FROM');?> <span><?php print JSHelper::formatprice($product->basic_price_info['basic_price'])?> / <?php print $product->basic_price_info['name'];?></span></div>
        <?php }?>
        <?php if ($this->config->product_list_show_weight && $product->product_weight > 0){?>
            <div class="productweight"><?php print JText::_('JSHOP_WEIGHT')?>: <span><?php print formatweight($product->product_weight)?></span></div>
        <?php }?>
        <?php if ($product->delivery_time != ''){?>
            <div class="deliverytime"><?php print JText::_('JSHOP_DELIVERY_TIME')?>: <span><?php print $product->delivery_time?></span></div>
        <?php }?>

        <?php if (is_array($product->extra_field)){?>
            <div class="extra_fields">
            <?php foreach($product->extra_field as $extra_field){?>
                <div><?php print $extra_field['name'];?>: <?php print $extra_field['value']; ?></div>
            <?php }?>
            </div>
        <?php }?>

        <?php if ($this->allow_review){?>
        <table class="review_mark"><tr><td><?php print JSHelper::showMarkStar($product->average_rating);?></td></tr></table>
        <div class="count_commentar">
            <?php print sprintf(JText::_('JSHOP_X_COMENTAR'), $product->reviews_count);?>
        </div>
        <?php }?>

        <?php print $product->_tmp_var_bottom_foto;?>

        <?php if ($product->vendor){?>
		<div class="vendorinfo"><?php print JText::_('JSHOP_VENDOR')?>: <a href="<?php print $product->vendor->products?>"><?php print $product->vendor->shop_name?></a></div>
        <?php }?>

        <?php if ($this->config->product_list_show_qty_stock){?>
		<div class="qty_in_stock"><?php print JText::_('JSHOP_QTY_IN_STOCK')?>: <span><?php print sprintQtyInStock($product->qty_in_stock)?></span></div>
        <?php }?>
        <?php print $product->_tmp_var_top_buttons;?>

        <?php print $product->_tmp_var_bottom_buttons;?>

		<?= $param->bilets_list_min_addprice ?
				" <div class='min_addprice $cur_code'>".PlaceBiletHelper::RoundPrice($product->min_addprice)." $cur_code</div>" : '' ?>
		<?php if($param->bilets_list_count) echo " <div class='count'>$product->count</div>"?>

</div>


 

<?php if($text_listprod_order&&$view_text) { ?>
	<div class="city order"> <a class="button_detail" href="<?= $product->product_link?>"><?=$text_listprod_order?></a></div>
<?php }?>
	
<div class="buttons">
    <?php if ($product->buy_link){?>
	<a class="button_buy" href="<?= $product->buy_link?>"><?php print JText::_('JSHOP_BUY')?></a> &nbsp;
    <?php }?>
			<a class="button_detail" href="<?php print $product->product_link?>">
				<?= $param->bilets_list_count_text ? "<span class='lbl'>{$param->bilets_list_count_text}</span>" : JText::_('JSHOP_BAY'); ?>
			</a>
    <?= $product->_tmp_var_buttons;?>
</div>

</div>
<?php print $product->_tmp_var_end?>