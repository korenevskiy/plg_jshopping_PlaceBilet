<?php
 /** ----------------------------------------------------------------------
 * plg_PlaceBilet - Plugin Joomshopping Component for CMS Joomla
 * ------------------------------------------------------------------------
 * author    Sergei Borisovich Korenevskiy
 * @copyright (C) 2019 //explorer-office.ru. All Rights Reserved. 
 * @license GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 * @version 1.1.1
 * @package		Jshopping
 * @subpackage  plg_placebilet
 * Websites: //explorer-office.ru/download/
 * Technical Support:  Forum - //fb.com/groups/multimodulefb.com/groups/placebilet/
 * Technical Support:  Forum - //vk.com/placebilet
 * -------------------------------------------------------------------------
 **/
 
namespace Joomla\Module\Placebilet\Administrator\Input;

//TicketData
class InputObject{
	public int $id = 0;
	public int $eventID = 0;
	public int $orderID = 0;
	public string $method = '';
	public string $QRcode = '';
	public string $format = '';
	public string $token = '';
	public string $action = '';
	public string $language = '';
}