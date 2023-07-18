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

use API\Kultura\Pushka\Event;
use Joomla\CMS\Language\Text as JText;
//use API\Kultura\Pushka\PushkaData;

 
extract($displayData);

/** 
 * @var API\Kultura\Pushka\Event
 * @param API\Kultura\Pushka\Event
 */

//$bilet = Event::new();
//$status;
//$session_place;
//$session_params;
//$session_date;
//$session_event_id;
//$session_organization_id;

//$status = strtoupper($status);
 
echo "<hr>";

if($session_date == 0){
	echo "<h4 class='statusPushka none'>";
	echo JText::_('JSHOP_PUSHKA_STATUS_NONE');
	echo "</h4>";
	return;
	// <pre><?= print_r($displayData, true) ? >  </pre>
}

?>
<h4 class="statusPushka <?= $status?>">
	<?= JText::_('JSHOP_PUSHKA_STATUS_'.strtoupper($status)) ?>
</h4>
<div>
	<?= $session_date ?> <br>
	<?= $session_params ?>  <br>
	<?= $session_place ?>  <br>
</div>
