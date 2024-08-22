<?php defined('_JEXEC') or die;
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
 * Ошибка данных
 */
class Bad extends PushkaData{
	
	/** *Код ошибки */
	public string $code = '';
	
	/** *Успех */
	public bool	$success = false;
	
	/** Сообщение ошибки */
	public string $message = '';

	/** Описание ошибки */	
	public string $description = '';

	public $result = false;
	
	/**
	 * @var array $filter POST: Добавление билета в реестр
	 * Добавить в реестр информацию о билете, купленном по Пушкинской карте
	 */
	public static array $filter = [
		"code"=> "string",			// * Код ошибки
		"description"=> "string",	// Описание ошибки 
		"success"=> "bool",			// * Успех
		"message"=> "string",		// Сообщение ошибки
	];
}