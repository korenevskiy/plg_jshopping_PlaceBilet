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

 
defined('_JEXEC') or die;

require_once __DIR__ . '/data.php';

/**
 * Гашение билета
 */
class Visit extends PushkaData{

	/** Дата погашения билета (unix timestamp)* */	
	public int $visit_date;

	/** Статус билета: active, visited, refunded, canceled (*Обязательный для возврата*) */	
	public string $status  = '';

	/** Комментарий */	
	public string $comment  = '';
	   
	
	/**
	 * @var array $filter POST: Добавление билета в реестр
	 * Добавить в реестр информацию о билете, купленном по Пушкинской карте
	 * /tickets
	 */
	public static array $filter = [
		"visit_date"=> "int",		// * Код ошибки
		"status"=> "string",		// active, visited, refunded, canceled
		"comment"=> "string",		// Комментарий
	];
}