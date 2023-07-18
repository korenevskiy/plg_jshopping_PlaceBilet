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

 
namespace API\Kultura\Pushka;

require_once __DIR__ . '/data.php';

/**
 * Возврат билета
 */
class Refund extends PushkaData{
	

/** *Дата возврата билета (unix timestamp)* */	
public string $refund_date;
	
/** Причина возврата* */	
public string $refund_reason;
	
/** RRN (Retrieval Reference Number) - уникальный идентификатор транзакции возврата */	
public string $refund_rrn = '';
	
/** Сумма возврата */	
public string $refund_ticket_price = '';
	
/** Комментарий (только при отправке данных) */	
public string $comment = '';

/** Статус:  active, visited, refunded, canceled (только при получении данных) */	
public string $status = '';
	   
	
	/**
	 * @var array $filter POST: Добавление билета в реестр
	 * Добавить в реестр информацию о билете, купленном по Пушкинской карте
	 * /tickets
	 */
	public static array $filter = [
		"status"=> "string",				// *Статус:  active, visited, refunded, canceled (только при получении данных) 
		"refund_date"=> "int",				// * Дата возврата билета (unix timestamp)
		"refund_reason"=> "string",			// * Причина возврата
		"refund_rrn"=> "string",			// RRN (Retrieval Reference Number) - уникальный идентификатор транзакции возврата
		"refund_ticket_price"=> "string",	// Сумма возврата
		"comment"=> "string",				// Комментарий (только при отправке данных)
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