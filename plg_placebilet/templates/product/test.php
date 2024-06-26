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

use \Joomla\CMS\Factory as JFactory;
use \Joomla\CMS\Document\HtmlDocument as JDocument;

defined('_JEXEC') or die();


if(class_exists('PlaceBiletHelper'))
    $params = \PlaceBiletHelper::$param->toObject();//Registry
    
settype($displayData, 'object');

//toPrint($displayData,'$html',true,'message');

?>

<div class="testAttr">

<?php 

echo "<h4>$displayData->title</h4>";


echo "<b>$displayData->cost</b>";

echo "<p>$displayData->description</p>";

?>

</div>