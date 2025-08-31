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

/**
 * Данные билета
 */
class Ticket extends PushkaData{
/** *ШК билета */	
public string $barcode = '';		
/** Тип сканера штрихкода
 * QRcode -1бит, Code128 Штрихкод -2бит, EAN-13 Штрихкод -3бит 
 * /(5 -QR, EAN13; 1 -QR; 4 -EAN13, 3 -QR,CODE128, )
 */	
public string $barcode_type = '5';

/** ФИО (целиком)* */	
public string $visitor_full_name;
/** Имя */	
public string $visitor_first_name = '';
/** Отчество */	
public string $visitor_middle_name = '';
/** Фамилия */	
public string $visitor_last_name = '';


/** Мобильный телефон (10 цифр)* */	
public string $buyer_mobile_phone;

/** ID мероприятия в PRO.Культура* */	
public string $session_event_id;

/** ID организации в Про.Культура* */	
public string $session_organization_id;

/** Дата/Время проведения сеанса (unix timestamp)* */	
public int	$session_date;

/** Адрес/описание места проведения мероприятия */	
public string $session_place = '';

/** Зал+Сектор+Ряд+Место	 */	
public string $session_params = '';

/** ID платежа у Билетного оператора */	
public string $payment_id = '';

/** RRN (Retrieval Reference Number) уникальный идентификатор транзакции */	
public string $payment_rrn = '';

/** *Дата/время совершения платежа (unix timestamp */	
public int	$payment_date;

/** Цена билета (номинал)* */	
public string	$payment_ticket_price = '';

/** Сумма платежа по Пушкинской карте* */	
public string	$payment_amount;			

/** ID билета (только при получении данных*) */	
public string	$id = '';	
/** Статус:  active, visited, refunded, canceled (только при получении данных*) */	
public string	$status = '';		
	   
	
	/**
	 * @var array $filter POST: Добавление билета в реестр
	 * Добавить в реестр информацию о билете, купленном по Пушкинской карте
	 * /tickets
	 */
	public static array $filter = [
		'id' => 'string',			// ID билета- (только при получении данных*)
		'status' => 'string',		// Статус:  active, visited, refunded, canceled (только при получении данных*)
		"barcode"=> "string",		// *ШК билета
		"barcode_type"=> "string",	// 9004881200123 
		"visitor"=> [			// Посетитель мероприятия
			"full_name"=> "string",		// *ФИО (целиком)
			"first_name"=> "string",	// Имя
			"middle_name"=> "string",	// Отчество
			"last_name"=> "string"		// Фамилия
		],
		"buyer"=> [				// Участник программы
			"mobile_phone"=> "string"	// *Мобильный телефон (10 цифр)
		],
		"session"=> [			// Сеанс
			"date"=> 'int',				// *Дата/Время проведения сеанса (unix timestamp)
			"event_id"=> "string",		// *ID мероприятия в PRO.Культура
			"organization_id"=> "string",//*ID организации в Про.Культура
			"place"=> "string",			// Адрес/описание места проведения мероприятия
			"params"=> "string",		// Зал+Сектор+Ряд+Место
		],
		"payment"=> [			// Платеж
			"date"=> 'int',				// *Дата/время совершения платежа (unix timestamp
			"id"=> "string",			// ID платежа у Билетного оператора
			"ticket_price"=> "string",	// Цена билета (номинал)
			"amount"=> "string",		// *Сумма платежа по Пушкинской карте
			"rrn"=> "string",			// RRN (Retrieval Reference Number) уникальный идентификатор транзакции
		],
		"comment"=> "string"

	];
}