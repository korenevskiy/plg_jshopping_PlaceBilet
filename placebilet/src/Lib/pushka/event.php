<?php namespace API\Kultura\Pushka;
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

 
// phpcs:disable PSR1.Files.SideEffects
\defined('_JEXEC') or die;
// phpcs:enable PSR1.Files.SideEffects



require_once __DIR__ . '/data.php';

class Event extends PushkaData{
	
/** Статус: active, visited, refunded, canceled* */	
public string $status = '';
	
/** ID мероприятия в PRO.Культура* */	
public string $session_event_id = '';
	
/** ID организации в Про.Культура* */	
public string $session_organization_id = '';
	
/** Дата/Время проведения сеанса (unix timestamp)* */	
public int $session_date = 0;
	
/** Адрес/описание места проведения мероприятия */	
public string $session_place = '';

/** Зал+Сектор+Ряд+Место */	
public string $session_params = '';
	   
	
	/**
	 * @var array $filter POST: Добавление билета в реестр
	 * Добавить в реестр информацию о билете, купленном по Пушкинской карте
	 * /tickets
	 */
	public static array $filter = [
		"status"=> "string",		// * Статус
		"session"=> [
			"event_id"=> "string",		//  *ID мероприятия в PRO.Культура
			"organization_id"=> "string",//*ID организации в Про.Культура
			"date"=> "int",				//  *Дата/Время проведения сеанса (unix timestamp)
			"place"=> "string",			//  Адрес/описание места проведения мероприятия
			"params"=> "string",		//  Зал+Сектор+Ряд+Место
			
		],
	];
//{
// "status": "active",
//  "session": {
//    "event_id": "string",
//    "organization_id": "string",
//    "date": 0,
//    "place": "string",
//    "params": "string"
//  }
//}
}