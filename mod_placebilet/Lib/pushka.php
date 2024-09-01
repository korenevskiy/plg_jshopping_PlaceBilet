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
// VM716260066923  - номер билета в Organization.VMuzey.com
// sprintf("%u",crc32(md5('string')));
// 
//EAN13 - длина 12 цифр.
//QRcode -1бит, 
//Code128 Штрихкод -2бит, 
//EAN-13 Штрихкод -3бит 
//ITF	-4бит
//DataMatrix -5бит
//PDF417 -6бит
//	/(5 -QR, EAN13; 1 -QR; 4 -EAN13, 3 -QR,CODE128, )
/* 
 * 93x0ym7pznovkadof1lz - Обмен идентификаторами - API для обмена идентификаторами системы «PRO.Культура.РФ». Токен для тестирования
 * https://pro.culture.ru/api/v2.5/pushka?apiKey=93x0ym7pznovkadof1lz
 * 
 * 
 * \ArrayObject new \ArrayAccess;
 */
defined('_JEXEC') or die;


require_once __DIR__ . '/data.php';
require_once __DIR__ . '/bad.php';
require_once __DIR__ . '/event.php';
require_once __DIR__ . '/refund.php';
require_once __DIR__ . '/ticket.php';
require_once __DIR__ . '/visit.php';

class Pushka{
	
	private string $urlAPI = '';
	
	private string $token = '';
	
	private bool $errorShow = false;
	
	public static function new(string $token = '', string $urlAPI = '', bool $errorShow = false) : self{
		return new self($token, $urlAPI, $errorShow);
	}
	
	function __construct(string $token = '', string $urlAPI = '', $errorShow = false){
		$this->urlAPI	= $urlAPI ?: static::URLTest;
		$this->token	= $token;
		$this->errorShow= $errorShow;
	}
	
	/** Тестовый Url реестра  */
	const URLTest = 'https://pushka-uat.test.gosuslugi.ru/api/v1';	// UAT
	
	/** Боевой Url реестра  */
	const URLProdaction = 'https://pushka.gosuslugi.ru/api/v1';		// PROD
	
	//active, visited, refunded, canceled
	
	/** Добавление билета 
	 * Возвращает объект билета с {id} и {status} свойствами
	 * @param TicketData $bilet
	 * @return TicketData
	 */
	function AddTicket(Ticket $bilet): Ticket | Bad  { // Добавить Active
		
		$url = $this->urlAPI . "/tickets";
		
		$result = $this->callAPI('POST', $url, $bilet);
		
		if(isset($result['code']) || isset($result['success']))
			return Bad::new($result);
		
		return Ticket::new($result); // OK: [{"visit_date": 0,"status": "active"}] or  bad: {"code": "string","description": "string"}
	}
	
	/** Получение информации о билете  
     * @param string $bilet_id ИД билета, внутренний номер в системе ПроКультура
     */
	function GetTicket(string $bilet_id): Ticket | Bad { // Получить билет
		
		if(empty($bilet_id))
			return Bad::new(['message'=>'Not found bilet key. ']);
		
		$url = $this->urlAPI . "/tickets/{$bilet_id}";
		
		$result = $this->callAPI('GET', $url, []);
		
		if(isset($result['code']) || isset($result['success']))
			return Bad::new($result);
		
		return Ticket::new($result); // OK: [{"visit_date": 0,"status": "active"}] or  bad: {"code": "string","description": "string"}
	}
	
	/** Вернуть билет  */
	function RefundTicket(string $bilet_key, string $comment = ''): Refund | Bad { // Вернуть Refund
		
		if(empty($bilet_key))
			return Bad::new(['message'=>'Not found bilet key. ']);
		
		$url = $this->urlAPI . "/tickets/{$bilet_key}/refund";
//{
//  "refund_date": 0,
//  "refund_reason": "string",
//  "refund_rrn": "string",
//  "refund_ticket_price": "string",
//  "comment": "string"
//}
		$data = ['refund_date' => time()];
		
		if($comment)
			$data['comment'] = $comment;
		
		$result = $this->callAPI('PUT', $url, $data);
		
		if(isset($result['code']) || isset($result['success']))
			return Bad::new($result);
		
		return Refund::new($result); // OK: [{"visit_date": 0,"status": "active"}] or  bad: {"code": "string","description": "string"}
	}
	
	/** Погасить билет /visit_date должен быть больше или равен session_date — 2 часа */
	function VisitTicket(string $bilet_key, string $comment = ''): Visit | Bad { // Погасить Visit
		
		if(empty($bilet_key))
			return Bad::new(['message'=>'Not found bilet key. ']);
		
		$url = $this->urlAPI . "/tickets/{$bilet_key}/visit";
		
		$data = ['visit_date' => time()];
		
		if($comment)
			$data['comment'] = $comment;

		$result = $this->callAPI('PUT', $url, $data);
		
		if(isset($result['code']) || isset($result['success']))
			return Bad::new($result);
		
		return Visit::new($result); // OK: [{"visit_date": 0,"status": "active"}] or  bad: {"code": "string","description": "string"}
	}
	
	/** Получение события по ID билета */
	function GetEvent(int $event_id, string $bilet_QR): Event | Bad { // Получение события по ID билета
										
		$url = $this->urlAPI . "/events/{$event_id}/tickets/{$bilet_QR}";
		
		$result = $this->callAPI('GET', $url, '');
		
		if(isset($result['code']) || isset($result['success']))
			return Bad::new($result);
		
		return Event::new($result); // OK: [{"visit_date": 0,"status": "active"}] or  bad: {"code": "string","description": "string"}
	}
	
	/** Погасить билет /visit_date должен быть больше или равен session_date — 2 часа, visit_date должен быть меньше или равен текущему времени + 1 час.  */
	function VisitTicketByEvent(int $event_id, string $bilet_QR, int $visit_date = 0, string $comment = ''): Visit | Bad { // Погасить Refund
		$url = $this->urlAPI . "/events/{$event_id}/tickets/{$bilet_QR}/visit";
		
		$data = ['visit_date' => time()];
		if($visit_date || $visit_date != 'now')
			$data['visit_date'] = $visit_date;
		if($comment)
			$data['comment'] = $comment;
		
		$result = $this->callAPI('PUT', $url, $data);
		
		if(isset($result['code']) || isset($result['success']))
			return Bad::new($result);
		
		return Visit::new($result); // OK: [{"visit_date": 0,"status": "active"}] or  bad: {"code": "string","description": "string"}
	}

	
	/**
	 * Формат суфикса Урла
	 * @var string
	*/
//	public static string $ulrFormat = '';
	
	/**
	 * Получение суфикса Urla
	 * @return string
	 */
	private function getUrlSfx() : string{
		
		return strtr(static::$ulrFormat, (array)$this);

	}
	
	private function callAPI(string $method = 'GET', string $url = '', string|array|PushkaData $data = '')
	{	
		$curl = curl_init();
		$result = false;
		$data_result = [];
		$data_string = '';
		
		try {
			
			if(is_array($data) || is_object($data)){
				
				if($method == 'GET' && $data instanceof PushkaData){
					$data_string = $data->jsonSerialize();
				}
				if($method == 'GET' && is_array($data)){
					$data_string = http_build_query($data);
				}else{
					$data_string = json_encode($data);
				}
				
				if($data_string === FALSE){
					throw new \Exception("Ошибка Сиарилизации запроса к реестру ПроКультуры\n ".print_r($data,true));
				}
				
			}else{
				$data_string = $data;
			}
			
			switch ($method)
			{
				case "POST":
					curl_setopt($curl, CURLOPT_POST, 1);
					if ($data_string)
						curl_setopt($curl, CURLOPT_POSTFIELDS, $data_string);
					break;
				case "PUT":
					curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "PUT");
					if ($data_string)
						curl_setopt($curl, CURLOPT_POSTFIELDS, $data_string);
					break;
				default:
					if ($data_string)
						$url = sprintf("%s?%s", $url, $data_string);
					break;
			}
			// OPTIONS:
			curl_setopt($curl, CURLOPT_URL, $url);
			curl_setopt($curl, CURLOPT_HTTPHEADER, [
				'Authorization: Bearer ' . $this->token, //сюда пишем свой ключ
				'Content-Type: application/json',
				'accept: application/json',
			]);
			
			curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
			// EXECUTE:
			$result = curl_exec($curl);
			
			if(empty($result)){
				throw new \Exception("Ошибка подключения к реестру ПроКультуры\n $url");
			}
			
			$data_result = json_decode($result, true);
			
			if(empty($data_result)){
				throw new \Exception("Ошибка Десиарилизации ответа реестру ПроКультуры\n $result");
			}
				
		} catch (Exception $exc) {
			$log = $exc->getMessage() .' \n ' . $exc->getTraceAsString();
			
			if(empty($data_result)){
				$data_result = [];
				$data_result['code'] = 123;
				$data_result['result'] = $result;
			}
			
			if(isset($data_result['description']) == false)
				$data_result['description'] = '';
			
			$data_result['description'] .= $log;
				
			if($this->errorShow)
				echo "<pre>$log</pre>";
			curl_close($curl);
			return (array)$data_result;
		} 

		curl_close($curl);
		
		return $data_result;
	}
}

return;
?>