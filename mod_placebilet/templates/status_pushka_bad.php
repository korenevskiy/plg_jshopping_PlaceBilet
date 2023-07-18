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
use API\Kultura\Pushka\Bad;
use Joomla\CMS\Language\Text as JText;
//use API\Kultura\Pushka\PushkaData;

 
extract($displayData);

/** 
 * @var API\Kultura\Pushka\Event
 * @param API\Kultura\Pushka\Event
 */

//$bilet = Bad::new();
$code;
$description;
$result;


//$status = strtoupper($status);
?>
<hr>
 

<h4>
	<?= JText::_('JSHOP_PUSHKA_STATUS_'.strtoupper($code)) ?>
</h4>
<div>
	<?= JText::_($description) ?> / <?= $message ?>  
</div>
