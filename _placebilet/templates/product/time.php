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
use Joomla\Plugin\Jshopping\Placebilet\Helper\Helper as PlaceBiletHelper;
defined('_JEXEC') or die();

extract($displayData) ;

//foreach ($displayData as $var => $val)
//	$this->$var = $val;

//toPrint(array(get_object_vars($product)),'Procuct Properies',true, 'message' );

//toPrint(null,'',0,'');
//toPrint($product->date_tickets,'$product->date_tickets',true, 'message',true );// 2023-04-24 01:00:00  // 0000-00-00 00:00:00


		$tz = PlacebiletHelper::getTimezone();

        $de = \JDate::getInstance($product->date_event, $tz);
		
        $dt = \JDate::getInstance($product->date_tickets,$tz);
//		$tt = $de->getOffsetFromGmt();

//		$is_period = empty(in_array($product->date_tickets, [0, '0000-00-00 00:00:00'])) && 0<(int)$de->year && 0<(int)$de->month && 0<(int)$de->day && empty((int)$de->hour) && empty((int)$de->minute) && empty((int)$de->second);
        
		
        $is_event = in_array($product->date_tickets, [0, '0000-00-00 00:00:00']) ||				// 1
				$de->year == $dt->year && $de->month == $dt->month && $de->day == $dt->day ||	// 
				$de->year == '-0001' && $de->month == '11' && $de->day == '30' ||				// 
				$de->year == -1 && $de->month == 11 && $de->day == 30 ||						// 
				$de->year == -1 && $de->month == 11 && $de->day == 30 ||						// 
				$de->year == 0 && $de->month == 0 && $de->day == 0;								//  


//toPrint($product->date_event,  ':('.$product->date_tickets . ''
//		. ' 1:' .in_array($product->date_tickets, [0, '0000-00-00 00:00:00'])
//		. ' 2:' .($de->year == $dt->year && $de->month == $dt->month && $de->day == $dt->day)
//		. ' 3:' .($de->year == '-0001' && $de->month == '11' && $de->day == '30' )
//		. ' 4:' .($de->year == -1 && $de->month == 11 && $de->day == 30)
//		. ' 5:' .($de->year == -1 && $de->month == 11 && $de->day == 30)
//		. ' 6:' .($de->year == 0 && $de->month == 0 && $de->day == 0)
//		.  ' '. $product->product_id,true, 'message',true );// 2023-04-24 01:00:00  // 0000-00-00 00:00:00

?>

<!-- <div class="bil"> -->
<div class="bilet">
        <?php if($params->text_prod_city&&$params->view_text)
		{ ?><div class="moskva Moscow city"><?=$params->text_prod_city?></div><?php }?>
        <?php if($params->text_prod_order && $params->view_text) 
		{ ?><div class="buttons controlZak order"><?=$params->text_prod_order?></div><?php }?>
        <h3><?php print $product->name?>
			<?php if ($config->show_product_code)
			{?> <span class="jshop_code_prod">(<?php print __('JSHOP_EAN')?>: <span id="product_code"><?php print $product->getEan();?></span>)</span><?php }?>
		</h3>
<!-- 		<div class="text_desc"> -->
<!-- 		<div class="date product"> -->
		<?php 
        $datetime = $t = strtotime($product->date_event);//Unix время
//        $dt = $product->date_event;// DateTime время
//toPrint($product->date_event,'$datetime',true, 'message' );
        ?>
<?php if($params->tagDateTimeWithLink ?? false){
	$product_url = $product->product_url ?: JRoute::_("index.php?option=com_jshopping&view=product&task=view&category_id=$product->main_category_id&product_id=$product->product_id");
	echo "<a href='$product_url'>" ;
}?>

<?php if($is_event): ?>
	<time datetime="<?= $product->date_event?>" class="date typeEvent"  title="<?= $product->date_event ?>">
		<?php if($params->tagDateTimeWithYear ?? false)
			echo "<span class='lbl jtime'>" .  JText::_('JYEAR'). ":</span> <span class='year'>". $de->format("Y") . "</span><br/>" ?>
		<span class="lbl jdate"><?= JText::_('JDATE')?>:</span> <span class="day"><?= $de->format("j"); ?></span><span class="month"  title="<?= $product->date_event ?>"> <?= JText::_($de->format("F"))?></span><br/>
		<span class="lbl jday"><?= JText::_('JDAY')?>:</span> <span class="weekday"><?= JText::_($de->format("l"))?></span><br/>
		<span class="lbl jtime"><?= JText::_('JTIME')?>:</span> <span class="time"><?= $de->format("H:i"); ?></span><br/>
	</time>
<?php else: ?>
	<time datetime="<?= $product->date_tickets?>" class="date typePeriod"  title="<?= $product->date_tickets ?>">
		<!--<span class="lbl jdate first"><?= JText::_('JDATE')?>:</span>-->
		<span class="month"  title="<?= $product->date_tickets ?>"><span class="day"><?= $dt->format("j", true); ?></span> <?= JText::_($dt->format("F", true))?></span>
		
		<span class="dash"> — </span>
		
		<!--<span class="lbl jdate last"><?= JText::_('JDATE')?>:</span>--> 
		<span class="month"  title="<?= $product->date_event ?>"><span class="day"><?= $de->format("j"); ?></span> <?= JText::_($de->format("F"))?></span>
		<span class="time"><?= $de->format("H:i"); ?></span>
    </time>
<?php endif; ?>

<?php if($params->tagDateTimeWithLink ?? false) echo "</a>" ?>
<!-- 			</div> -->
            <input type="hidden" name="date_event"   class="hide" value="<?= $product->date_event ?>" />
            <input type="hidden" name="date_modify"   class="hide" value="<?= $product->date_modify ?>" />
<!--         </div> -->
        <div class="jshop_short_description">
            <?= $product->short_description; ?>
        </div>
</div>
<!-- </div> -->