<?php
 /** ----------------------------------------------------------------------
 * plg_placebilet - Plugin Joomshopping Component for CMS Joomla
 * ------------------------------------------------------------------------
 * author    Sergei Borisovich Korenevskiy
 * @copyright (C) 2019 //explorer-office.ru. All Rights Reserved. 
 * @license GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 * @package		Jshopping,plg_placebilet
 * @subpackage  mod_placebilet
 * Websites: //explorer-office.ru/download/
 * Technical Support:  Forum - //fb.com/groups/multimodulefb.com/groups/placebilet/
 * Technical Support:  Forum - //vk.com/placebilet
 * -------------------------------------------------------------------------
 **/

\defined('_JEXEC') or die;

use \Joomla\CMS\Language\Text as JText;
use Joomla\Module\Placebilet\Administrator\BD\StatusObject;

//echo "<pre>\n status:\t ". print_r($displayData, true)." </pre>";

extract($displayData);

// StatusObject;

$orderBilet = StatusObject::new();
//$orderBilet->status_code;

$QRcode;
$date_event;
$place_status_code;
$place_status_title;
$status_title;
$status_code;
$order_id;
$order_item_id;
$place_attr_id;
$place_velue_id;
$place_prodVal_id;
$place_name;
$place_price;
$count_places;
$place_index;
$place_count;
$place_number;
$index;
$place_go;
$product_id;
$product_name;
$place_status_date;



$int = explode('.', $place_price);
if(isset($int[1]) && $int[1] == 0){
	$place_price = (int)$place_price;
}

?> 

<h3 class="statusBilet <?=$place_status_code ?: $status_code ?>">
	<center class="status_name"><?= $place_status_title ?: '- '.$status_title ?></center>
	<center class="place_name"><span class="place_name_info"><?= JText::_('JSHOP_PUSHKA_STATUS_PLACE') ?>:</span> <?= $place_name ?></center>
	
</h3> 
<!--<hr>-->
<h5 class='number'>
	<big><?= $place_number ?></big>
	<small><?= $place_count?></small>
</h5>
<!--<hr>-->
<h4 class="product">
	<span class="date"><?= $date_event ?></span>
	<!--<br>-->
	<span class="product_name"><?= $product_name ?></span>
</h4>
<div> 
	<span class="count_places"><span class="count_places_info"><?= JText::_('JSHOP_PUSHKA_STATUS_COUNT') ?>:</span> <?= $index + 1 ?> /<?= $count_places ?></span>
	<span class="QRcode"><span class="QRcode_info"><?= JText::_('JSHOP_PUSHKA_STATUS_QRCODE') ?>:</span> <code><?= $QRcode ?></code></span>
	<span class="place_price"><span class="place_price_info"><?= JText::_('JSHOP_PUSHKA_STATUS_PRICE') ?>:</span> <?= $place_price ?></span>
		
	<span class="date_status"><span class="date_status_info"><?= JText::_('JSHOP_PUSHKA_STATUS_DATE') ?>:</span> <?= $place_status_date ?? $status_date_added ?></span>
</div>

<?php return; ?>

+ Добавить категорию: Льготный, детский, взрослый
- Убрать индекс билета, 
+ Добавить до какого числа действует билет.
		+ Добавить ФИО
+ Адрес
+ Минцифры организация придумала 
+ ID Заказа









"error":true,
"code":0,
"message":"Class \"Joomla\Module\Placebilet\Administrator\StatusObject\" not found",
"trace":"
#0 /home/e/exoffice/orelmusizo/public_html/administrator/modules/mod_placebilet/helper.php(154): modPlaceBiletHelper::getOrderDBbyQR('js13.1435031300')
#1 /home/e/exoffice/orelmusizo/public_html/components/com_ajax/ajax.php(102): modPlaceBiletHelper::getAjax()
#2 /home/e/exoffice/orelmusizo/public_html/administrator/components/com_ajax/ajax.php(13): require_once('/home/e/exoffic...')
#3 /home/e/exoffice/orelmusizo/public_html/libraries/src/Dispatcher/LegacyComponentDispatcher.php(71): require_once('/home/e/exoffic...')
#4 /home/e/exoffice/orelmusizo/public_html/libraries/src/Dispatcher/LegacyComponentDispatcher.php(73): Joomla\CMS\Dispatcher\LegacyComponentDispatcher::Joomla\CMS\Dispatcher\{closure}('/home/e/exoffic...')
#5 /home/e/exoffice/orelmusizo/public_html/libraries/src/Component/ComponentHelper.php(355): Joomla\CMS\Dispatcher\LegacyComponentDispatcher->dispatch()
#6 /home/e/exoffice/orelmusizo/public_html/libraries/src/Application/AdministratorApplication.php(143): Joomla\CMS\Component\ComponentHelper::renderComponent('com_ajax')
#7 /home/e/exoffice/orelmusizo/public_html/libraries/src/Application/AdministratorApplication.php(186): Joomla\CMS\Application\AdministratorApplication->dispatch()
#8 /home/e/exoffice/orelmusizo/public_html/libraries/src/Application/CMSApplication.php(294): Joomla\CMS\Application\AdministratorApplication->doExecute()
#9 /home/e/exoffice/orelmusizo/public_html/administrator/includes/app.php(61): Joomla\CMS\Application\CMSApplication->execute()
#10 /home/e/exoffice/orelmusizo/public_html/administrator/index.php(32): require_once('/home/e/exoffic...')\n#11 {main}"



