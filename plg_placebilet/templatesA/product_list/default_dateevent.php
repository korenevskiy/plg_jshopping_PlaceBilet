<?php defined('_JEXEC') or die();
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
?>
<td class="date_event">
<?php 
use \Joomla\CMS\Language\Text as JText;
	extract($displayData);
	
//JFactory::getApplication()->enqueueMessage( count($displayData) . '<pre>' . print_r($displayData, true) . '</pre>');

//	$date_event = $date_event ?: Joomla\CMS\Date\Date::getInstance()->toSql();
    //echo formatdate($product_date_added, 1);
 
	if($date_event == '0000-00-00 00:00:00'){
		echo '<b style="font-size:24px;text-align: center;display:block;">00:00</b>';
		return;
	}
	
    $week_Days = date('N', strtotime($date_event));
    $opacity = 0.8;
    if($week_Days == 6)
        $opacity = 0.3;
    if($week_Days < 6)
        $opacity = 0.1*$week_Days;
    $color = ($week_Days < 6)? "rgba(255,226,148,$opacity)":"rgba(132,224,219,$opacity)";
    echo "<div style='text-align: center;line-height: initial;'>"
			. "<div style='background-color:$color;min-width: max-content;'>".date("j ",strtotime($date_event)). JText::_(date("F",strtotime($date_event))).''
			. '<br><small>'.date(" o",strtotime($date_event)). '</small></div>'
			
            . '<b style="font-size:24px;">'.date("H:i",strtotime($date_event))."</b>"
			. "<span style=' ' class=''>".JText::_(date("D",strtotime($date_event)))."</span>"
		. '</div>';//formatdate($date_event, 1). date("H:i",$date_event) Изменено product_date_added на date_event изменено-добавленно
    ?>
</td>


 