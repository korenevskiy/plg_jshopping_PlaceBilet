<?php namespace Joomla\Module\Placebilet\Administrator\Helper;
 /** ----------------------------------------------------------------------
 * mod_placebilet - Module Joomshopping Component for CMS Joomla
 * Joomla plugin for ticket sales for websites: for Theaters, Cinemas, Circuses, Museums, Exhibitions, Masterclasses, Doctor's Visits, Clubs, Discos, Coaching, Schools, Training Courses.
 * ------------------------------------------------------------------------
 * @author    Sergei Borisovich Korenevskiy
 * @copyright (C) 2025 http://explorer-office.ru. All Rights Reserved. 
 * @license GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 * @package		Jshopping,plg_placebilet
 * @subpackage  mod_placebilet
 * Websites: https://explorer-office.ru/download/
 * Technical Support:  Telegram - https://t.me/placebilet
 * Technical Support:  Forum	- https://vk.com/placebilet
 * Technical Support:  Github	- https://github.com/korenevskiy/plg_jshopping_PlaceBilet
 * Technical Support:  Max		- https://max.ru/join/l2YuX1enTVg2iJ6gkLlaYUvZ3JKwDFek5UXtq5FipLA
 * -------------------------------------------------------------------------
 **/


//namespace Joomla\Module\Placebilet;


use Joomla\CMS\Application\CMSApplication;
use Joomla\CMS\Plugin\PluginHelper;
use Joomla\CMS\Router\Route;
use Joomla\Module\Quickicon\Administrator\Event\QuickIconsEvent;
use Joomla\Registry\Registry;
use Joomla\Registry\Registry as JRegistry;
use Joomla\CMS\Factory as JFactory;
use Joomla\CMS\Factory;
use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Language\LanguageHelper;
use Joomla\CMS\Language\Text as JText;
use Joomla\CMS\Uri\Uri;
use Joomla\CMS\Helper\ModuleHelper as JModuleHelper;
use Joomla\CMS\Date\Date as JDate;
use Joomla\CMS\Layout\LayoutHelper as JLayoutHelper;
use API\Kultura\Pushka\Pushka;
use API\Kultura\Pushka\PushkaData;
use API\Kultura\Pushka\Ticket;
use API\Kultura\Pushka\Visit;
use API\Kultura\Pushka\Refund;
use API\Kultura\Pushka\Event;
use API\Kultura\Pushka\Bad;
use Joomla\Module\Placebilet\Administrator\Input\InputObject;
use Joomla\Module\Placebilet\Administrator\BD\StatusObject;
use Joomla\Module\Placebilet\Administrator\StatusEventObject;
use Joomla\CMS\Response\JsonResponse;
use Joomla\Component\Jshopping\Site\Lib\JSFactory;
use Reg;

//echo "<pre>PlaceBiletHelper.php</pre>";
// phpcs:disable PSR1.Files.SideEffects
defined('_JEXEC') or die;
// phpcs:enable PSR1.Files.SideEffects

ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

/**
 * Helper for mod_quickicon
 *
 * @since  1.6
 */

class PlacebiletHelper  { //implements \Joomla\CMS\Helper\HelperFactoryInterface
	
	public static $debug = false;
	
	/**
	 * Параметры модуля
	 * @var Array
	 */
	public static $param = [];
	
	
	public static $eventList;
	
	
	public static $languageList = [];
	
	public static $path = '';
	
	private static $module = [];
	
	
	public function __construct(array $config = []) {
		
		defined('JPATH_JOOMSHOPPING') || define('JPATH_JOOMSHOPPING', JPATH_ROOT.'/components/com_jshopping');
		defined('JPATH_JOOMSHOPPING_ADMIN') || define('JPATH_JOOMSHOPPING_ADMIN', JPATH_ADMINISTRATOR.'/components/com_jshopping');
		
		
		JText::script('JSHOP_PUSHKA_ALERT_ERROR_SESSION');
		
		static::$path = realpath(__DIR__ . '/../../');

		if(file_exists(JPATH_ROOT . '/functions.php'))
			require_once JPATH_ROOT . '/functions.php';
		
		require_once static::$path . '/Lib/reg.php';
		
		JFactory::getApplication()->getLanguage()->load('mod_placebilet', static::$path);
		
		if(isset($config['module']) && $config['module']->id){
			static::$module[$config['module']->id] = $config['module'];
			static::getParam($config['module']->id);
		}
		
//echo print_r(static::$param, true);
//echo "##123 <br>\n";
	}
	
//	public static function setParam($param = null, $module = null){
//		if($param)
//			static::$param = new \Reg($param);
//		if($module)
//			static::$param->loadObject($module);
//	}
//	public static function setModule($module = null){
//		if($module == null)
//			return;
//		
//		static::$param = new \Reg($module->params);
//		static::$param->loadObject($module);
//	}
	
	public function test(){
		return get_class();
	}
	
	
	public static function getQRAjax(int $order_id = 0, string $format = '',) {
		
		static::$debug = true;
		
		
//		$id = $module_id ?: $input->getInt('id', 0);
		$input = static::getInputObject();
		
		if(empty($input) && empty($order_id))
			return null;
		
		
		$format = $order_id ? $format : ($input->format ?: 'html');
		
		$orderID = $order_id ?: $input->orderID;
		
		$query = " 
SELECT i.count_places, i.order_item_id 
FROM #__jshopping_order_item i
WHERE i.order_id = $orderID; ";

// toPrint($query, '$query',true,'message',true);
			
		$order_item_IDs = JFactory::getDBO()->setQuery($query)->loadAssocList('order_item_id', 'count_places');
		
		$QRcodes = [];
		 
		foreach ($order_item_IDs as $order_item_id => $count_places){
			
			$QRcodes[$order_item_id] = [];
		
			if($count_places == 0)
				continue;
			
			/** Определение количества разрядов индекса */
			$index_length = strlen(($count_places - 1));
			
			foreach (range(0, $count_places - 1) as $index){
				
				$index_string = str_pad($index, $index_length, "0", STR_PAD_LEFT);
					
				$QRcodes[$order_item_id][$index] = static::getQRcode($order_item_id, $index_string);
			}
		} 
		
		switch ($format){
			case 'json': 
				return json_encode($QRcodes);
				break;
			case 'debug':
			case 'raw':
				return json_encode($QRcodes, JSON_PRETTY_PRINT);
				break;
			case 'html':
				$html = "OrderID: $orderID";
				$html .= "<dl>";
				foreach ($QRcodes as $order_item_id => $QRs){
					$count_places = $order_item_IDs[$order_item_id];
					$html .= "<dt>OrderItemID: $order_item_id  /count:$count_places</dt>";
					foreach ($QRs as $QR){
						$html .= "<dd>$QR</dd>";
					}
				}
				$html .= "</dl>";
				return $html;
				break;
			default:
				return $QRcodes;
		}
		
		return $QRcodes;
	}
	
	
	
	public static function getStatusAjax($param='') {
		
		static::$debug = true;
		
		return static::getAjax();
	}
	
	public static $debugMessage = '';
	
	public static function getAjax() {
//		usleep(1000);  // Задержка
//static::getHtmlDark();
		
		$html = '';
		
		/** @var \Joomla\CMS\Application\CMSApplication $app */
		$app = JFactory::getApplication();
		
//		$debugMessage = static::$debugMessage;
		 

//file_put_contents(__DIR__ . '/logHelper.txt', print_r($app->getInput()->getArray(),true)." 261 \n\n\n");
		$input = static::getInputObject();
//file_put_contents(__DIR__ . '/logHelper.txt', print_r($input,true)." 264 \n\n\n", FILE_APPEND);
		

		$app->getLanguage()->load('mod_placebilet', static::$path);
		$app->getLanguage()->load('mod_placebilet', static::$path.'/language');
//		$app->getLanguage()->load('mod_placebilet', static::$path.'src');
//		$app->getLanguage()->load('mod_placebilet', static::$path.'src/Language');
		
		
//		$langTag = $app->getLanguage()->getTag();
//		$app->enqueueMessage($langTag);
		
//echo "#01<br>\n";
//		return $language;
		
//		$html_prefix = $input->format == 'json' ? '' : "<html lang='ru-ru'>\n<meta charset='utf-8'>";
		
//		$langTag = $app->getLanguage()->getTag();


		if(empty($input)){
//echo "empty INPUT: 280<br>\n";
			$app->getLanguage()->load('mod_placebilet', static::$path);
			
			$app->getMessageQueue(true);
			$app->enqueueMessage(JText::_('JSHOP_PUSHKA_ERROR_REQUEST'));
			$app->enqueueMessage('Error Request - Please Reload Page');
//			$app->enqueueMessage(1);
			JText::script('Error Request - Please Reload Page');
			$app->input->set('ignoreMessages', false, 'bool');
//			return null;
//			return new JsonResponse(null,JText::_('JSHOP_PUSHKA_ERROR_REQUEST'), true);
			return '';
//			return '{"message":"'.JText::_('JSHOP_PUSHKA_ERROR_REQUEST').'","messages":["Error Request - Please Reload Page"]}';//, "data": {"content":"'.JText::_('JSHOP_PUSHKA_ERROR_REQUEST').'"}
		}
		
		
		$app->getLanguage()->load('mod_placebilet', static::$path, $input->language, true);
		$app->getLanguage()->load('mod_placebilet', static::$path.'/language', $input->language, true);
		
//echo "#02<br>\n";
		
		if(empty($input->QRcode)){
			$app->getMessageQueue(true);
			$app->enqueueMessage(JText::_('JSHOP_PUSHKA_ERROR_REQUEST_QR'));
			$app->enqueueMessage('Error QR - Please Reload Page');
//			$app->enqueueMessage(2);
			JText::script('Error QR - Please Reload Page');
			$app->input->set('ignoreMessages', false, 'bool');
			
			if($input->format == 'json')
				return JText::_('JSHOP_PUSHKA_ERROR_REQUEST_QR');
//				return '';// '{"message":"'.JText::_('JSHOP_PUSHKA_ERROR_REQUEST_QR').'","messages":["Error QR - Please Reload Page"]}';//,"data":{ "content":"'.JText::_('JSHOP_PUSHKA_ERROR_REQUEST_QR').'"}
			
			return new JsonResponse(null,JText::_('JSHOP_PUSHKA_ERROR_REQUEST_QR'), true);
			
		}
		
		
		require_once static::$path . '/Lib/status.php';
		require_once static::$path . '/Lib/status_event.php';
		require_once JPATH_SITE.'/components/com_jshopping/Lib/JSFactory.php';
		require_once JPATH_SITE.'/components/com_jshopping/Helper/Helper.php';
		
		\JLoader::registerAlias('JSFactory', 'Joomla\\Component\\Jshopping\\Site\\Lib\\JSFactory');
		

		/** $var \Reg $param Module ID param */
		$param = static::getParam($input->id); /** Module ID param */

		if(empty($param)){
			$app->getMessageQueue(true);
			$app->enqueueMessage(JText::_('JSHOP_PUSHKA_ERROR_PARAMS'));
			$app->enqueueMessage('Error Params - Please Reload Page');
//			$app->enqueueMessage(3);
			JText::script('Error Params - Please Reload Page');
			$app->input->set('ignoreMessages', false, 'bool');
			if($input->format == 'json')
				return JText::_('JSHOP_PUSHKA_ERROR_PARAMS');
			
			return new JsonResponse(null,JText::_('JSHOP_PUSHKA_ERROR_PARAMS'), true);
		}

		/** get Status ticket */
		$statusBD = static::getOrderDBbyQR($input->QRcode);
static::$debugMessage .= ' status_title267:'. ($statusBD->status_title??'');
		
//echo "#05<br>\n";
//file_put_contents(__DIR__ . '/logHelper.txt', print_r($statusBD,true)." \n\n\n", FILE_APPEND);
//return print_r($statusBD, true);
		if(empty($statusBD)){
			
			$app->getMessageQueue(true);
			$app->enqueueMessage(JText::_('JSHOP_PUSHKA_ERROR_EXIST_QR'));
			$app->enqueueMessage('Error QR - This QR Not Exist');
//			$app->enqueueMessage(4);
			JText::script('Error QR - This QR Not Exist');
			$app->input->set('ignoreMessages', false, 'bool');
			

			if($input->format == 'json')
				return JText::_('JSHOP_PUSHKA_ERROR_EXIST_QR');
			
			return new JsonResponse(null, JText::_('JSHOP_PUSHKA_ERROR_EXIST_QR'), true); 
//			return '{"message":"'.JText::_('JSHOP_PUSHKA_ERROR_EXIST_QR').'","msg":"Error QR - This QR Not Exist"}';
		}


//echo "#06<br>\n";
		$statusBD->place_index;
		$statusBD->place_name;
		
		$now = static::getDate('now')->getTimestamp();
		$date_event		= static::getDate($statusBD->date_event)->getTimestamp();
		$date_tickets	= static::getDate($statusBD->date_tickets)->getTimestamp();

		/** Новый статус */
		if($input->action && empty($statusBD->pushka_id)) {
static::$debugMessage .= ($input->action ?? '');

			if($param->ticketsPeriodVisit == 'all'
					|| $now + $param->ticketsPeriodVisit > $date_event
					|| $date_tickets > 0 && $statusBD->date_tickets != '0000-00-00 00:00:00' && $now > $date_tickets){
static::$debugMessage .= ' :action:TRUE.';
//return "#08 periodVisit ALL";
				$action = strtolower($input->action);
				$pushka_status_newID = in_array($input->action, ['Visit','Refund','Cancel',]) ? (int) ($param->{"pushka_{$action}_status"} ?? 0) : 0;

				static::addNewStatusBD($statusBD->order_item_id, $statusBD->place_index, $pushka_status_newID, $statusBD->place_name ?? '');

				$statusBD = static::getOrderDBbyQR($input->QRcode);
			}else{
//return "#08 periodVisit NOT ALL";
static::$debugMessage .= " :action:FALSE \n\n";
				$html .= JText::_('JSHOP_PUSHKA_MESSAGE_BAD');
			}
		}

		$html .= JLayoutHelper::render('status', (array)$statusBD, static::$path . '/templates/');

//echo "#10<br>\n";
//echo print_r($html,true)."<br>\n";
		
		$json_array_response = [
			'Debug' => static::$debugMessage,
			''					=> $statusBD->place_status_title,
			'order_id'			=> $statusBD->order_id,
			'order_item_id'		=> $statusBD->order_item_id,
			'event_id'			=> $statusBD->event_id,
			'date_event'		=> $statusBD->date_event,
			'status_code'		=> $statusBD->status_code,
			'status_date_added'	=> $statusBD->status_date_added,
			'status_title'		=> $statusBD->status_title,
			'place_status_title'=> $statusBD->place_status_title,
			'place_status_code'	=> $statusBD->place_status_code,
			'place_status_date'	=> $statusBD->place_status_date,
			'place_price'		=> $statusBD->place_price,
			'place_count'		=> $statusBD->place_count,
			'place_number'		=> $statusBD->place_number,
//			'place_index'		=> $statusBD->place_index,
			'place_velue_id'	=> $statusBD->place_velue_id,
			'place_prodVal_id'	=> $statusBD->place_prodVal_id,
			'place_attr_id'		=> $statusBD->place_attr_id,
			'count_places'		=> $statusBD->count_places,
			'content'			=> $html,
			];

		if(empty($statusBD->pushka_id)){ //empty($param->pushka_mode) || empty($statusBD->event_id)
			
			if($input->format == 'json')
				return $json_array_response;

			return (string) new JsonResponse($json_array_response); //json_encode
		}

		$bilet = new stdClass;
		
		$pushka = static::getPushka($param);
		/** Новый статус */
		switch ($input->action){//['Visit','Refund','Cancel',]
			case 'Visit':
				$bilet = $pushka->VisitTicketByEvent($statusBD->event_id, $statusBD->QRcode);
				break;
//			case 'Visit':
//				$answerBilet = $pushka->VisitTicket($statusBD->pushka_id);
//				break;
			case 'Refund':
			case 'Cancel':
				$bilet = $pushka->RefundTicket($statusBD->pushka_id);
				break;
			default :
				break;
		}

		/** Новый статус */
		if($input->action && !($bilet instanceof Bad)) {
			/** Новый статус */
			if($param->ticketsPeriodVisit == 'all'
					|| $now + 7200 > $date_event
					
					|| $now + $param->ticketsPeriodVisit > $date_event
					|| $date_tickets > 0 && $statusBD->date_tickets != '0000-00-00 00:00:00' && $now > $date_tickets
					
					){
				$action = strtolower($input->action);
				$pushka_status_newID = in_array($input->action, ['Visit','Refund','Cancel',]) ? (int) ($param->{"pushka_{$action}_status"} ?? 0) : 0;
				static::addNewStatusBD($statusBD->order_item_id, $statusBD->place_index, $pushka_status_newID, $statusBD->place_name ?? '');
				$statusBD = static::getOrderDBbyQR($input->QRcode);
			}else{
				$html .= JText::_('JSHOP_PUSHKA_MESSAGE_BAD');
			}
		}
		
		if($bilet instanceof Bad){
//			$pushka->GetTicket($bilet_id);
//			$pushka->GetEvent($statusBD->event_id, $statusBD->QRcode);
//			$html .= JText::printf('JSHOP_PUSHKA_MESSAGE_BAD_F',date("H:i j F o",$bilet->session_date - 7200));
			$html .= JText::_('JSHOP_PUSHKA_MESSAGE_BAD');
//			$response = $pushka->GetTicket('0000721b-3676-477d-b4f8-c153df3250a4');
//			$response = $pushka->GetEvent('1243159','js117.0116354476');
		}
		
//$html.= "\n\n<br> StatusNew: $input->action, QR: $statusBD->QRcode,  EventID: $statusBD->event_id, BiletID: $statusBD->pushka_id, AnswerBilet:". get_class($answerBilet)." $answerBilet->code, $answerBilet->message <br>\n\n" ;
		
		$bilet = $pushka->GetEvent($statusBD->event_id, $statusBD->QRcode);
		
//		$bilet = new API\Kultura\Pushka\Bad;
		$bilet->message .= ' message(' . $statusBD->QRcode . ' ' . $statusBD->event_id . ')';
				
		
		
		if($bilet instanceof Event){
			$html .= JLayoutHelper::render('status_pushka', (array)$bilet, static::$path . '/templates/');
		}
		if($bilet instanceof Bad){
			$html .= JLayoutHelper::render('status_pushka_bad', (array)$bilet, static::$path . '/templates/');
		}
		
		
//		$sessionData = $session->get(123);
//		$input = $app->get();
		
//		$clientId = $app->getClientId();
//		$modules = JModuleHelper::getModuleList();
		//$html .= "<pre>$clientId <br>sessionID: \t".$session->getId()."<br>sessionToken: \t" .$session->getFormToken().'<br>check: '. print_r($session->checkToken('get'),true) . "</pre>";
		
//		$html = str_replace("\n", "", $html);
//		$html = str_replace("\r", "", $html);
		 
		$json_array_response['bilet_session_place'] = $bilet->session_place;
		$json_array_response['bilet_status']		= $bilet->status;				//	active, visited, refunded, canceled*
		$json_array_response['bilet_session_event_id']= $bilet->session_event_id;
		$json_array_response['bilet_session_date']	= $bilet->session_date;
		$json_array_response['content']				= $html;
		
			
//			$app->getMessageQueue(true);
//			$app->input->set('ignoreMessages', false, 'bool');
			
		if($input->format == 'json')
			return $json_array_response;
		
		
		return new JsonResponse($json_array_response);
//		return ($json_array_response); //json_encode
	
		
//	htmlentities ($string) ;
		
//		return '{status:"' . $bilet->status . '", content:"' . htmlspecialchars($html) . '"}';
		
//		return '{"message":"Привет Дружище! / "}';
	}
	
	
	
	/*
	 * Список объектов продуктов с ID событий из ПроКультура
	 * для вывода в Select`е в сканере
	 * @return array
	 */
	public static function getEventTitleList(): array {
		
		if(! file_exists(JPATH_PLUGINS . '/jshopping/placebilet/placebilet.xml'))
			static::$eventList = [];
			
		
		if(is_null(static::$eventList)){
			static::getLanguageList();
			if(empty(static::$languageList)){
				static::$eventList = [];
				return static::$eventList;
			}
			$param = static::$param;
			$filterOld		= ($param->pushka_event_interval_old ?? false) ? " AND DATE(date_event) > DATE(DATE_ADD(CURRENT_DATE, INTERVAL -$param->pushka_event_interval_old )) ":  '';
			$filterFuture	= ($param->pushka_event_interval_future ?? false) ? " AND DATE(date_event) < DATE(DATE_ADD(CURRENT_DATE, INTERVAL +$param->pushka_event_interval_future )) ":  '';
			
//			$langs = JFactory::getDBO()->qn(static::$languageList);
			$langs = implode(',', static::$languageList);
			$query = " 
SELECT event_id id, CONCAT_WS(' /', event_id,  $langs ) title, date_event date 
FROM #__jshopping_products 
WHERE  event_id != 0 
$filterOld 
$filterFuture 
ORDER BY date_event; ";

// toPrint($query, '$query',true,'message',true);
// toPrint($query, '$query',true,'message',true);
			
			static::$eventList = JFactory::getDBO()->setQuery($query)->loadObjectList('id');
			
			
			array_unshift(static::$eventList, (object)['id'=>0,'title'=>JText::_('JGLOBAL_AUTO'),'date'=>'']);
			
		}
		
		return static::$eventList;
	}
	
    /**
	 * Список объектов поддерживаемых языков JShopping, с ID локализации  [en-GB => `name_en-GB`, ...]
	 * example: ('c.desc_', '`') return [en-GB => `c`.`desc_en-GB`, ...]
	 * @return array
	 */
    public static function getLanguageList($prefix = 'name_', $quote = '`') : array {
		
		if(empty(static::$languageList)){
			$query ="
SELECT CONCAT ('`','name_',language,'`') language, language lang  
FROM #__jshopping_languages 
WHERE publish 
ORDER BY ordering, id DESC;
			";
			static::$languageList = JFactory::getDBO()->setQuery($query)->loadAssocList('lang', 'language');
			
			$admin_show_languages = \Joomla\Component\Jshopping\Site\Lib\JSFactory::getConfig()->admin_show_languages;
			
			$tag = JFactory::getApplication()->getLanguage()->getTag();
			
			
//$language = JFactory::getApplication()->getInput()->getString('lang',JFactory::getApplication()->getLanguage()->getTag());
			
			if(empty($admin_show_languages) && isset(static::$languageList[$tag]) && count(static::$languageList) > 1){
				static::$languageList = array_filter(static::$languageList, function($k)use($tag) {return $k == $tag;},ARRAY_FILTER_USE_KEY);
			}
		}
		
		if($prefix == 'name_'){
			return static::$languageList;
		}
		
		$langs = [];
		foreach (static::$languageList as $lng => $_)
			$langs [$lng] = $quote . str_replace('.', "$quote.$quote", $prefix . $lng) . $quote;
		return $langs;
    }
	
	/**
	 * Получение статуса билета по QR.  
	 * @param string $QRcode QR код 
	 * @return StatusObject|null
	 */
	public static function getOrderDBbyQR($QRcode = '') : ?StatusObject {

		if(empty($QRcode)){
			return null;
		}
		
		$firt_letter = substr($QRcode, 0, 2);
		
		if($firt_letter != 'js'){
			return null;
		}

		$position_dot = strrpos($QRcode, '.');
		
		$order_item_id = substr($QRcode, 2, $position_dot - 2);
//return $order_item_id;
		
//		static::getLanguageList();
		
		
//		$langs = JFactory::getDBO()->qn(static::$languageList);
		$langs = static::getLanguageList('s.name_'); //array_map(fn($lng)=>'s.'.$lng, $langs);
		$langs = implode(',', $langs);
		
		
		$query="
SELECT  oi.order_item_id, oi.order_id, oi.count_places, oi.place_counts, oi.date_event, oi.date_tickets, oi.place_go, oi.places, oi.place_names, oi.place_prices, oi.product_name, oi.place_pushka,
	p.product_id, 
	s.status_id, s.status_code, h.status_date_added, CONCAT_WS(' /', $langs ) status_title,
	p.event_id,
	s.status_code order_status_id,
	o.order_date
FROM #__jshopping_order_item oi
LEFT JOIN #__jshopping_orders o ON o.order_id = oi.order_id 
LEFT JOIN #__jshopping_products p ON oi.product_id = p.product_id 
LEFT JOIN #__jshopping_order_history h ON h.order_id = oi.order_id 
LEFT JOIN #__jshopping_order_status s ON IF(h.order_status_id, s.status_id = h.order_status_id, s.status_id = o.order_status)
WHERE oi.order_item_id = $order_item_id
ORDER BY h.order_history_id DESC
LIMIT 1;
";
//JFactory::getApplication()->enqueueMessage($query);	
//file_put_contents(__DIR__ . '/logHelper.txt', "$query \n\n\n", FILE_APPEND);
//return null;
//echo str_replace('#__', JFactory::getApplication()->getConfig()->get('dbprefix'), $query) .'<br>';
//return null;
		$data = JFactory::getDbo()->setQuery($query)->loadAssoc();
		
		
		
		if(empty($data)){
			return null;
		}
		
//JFactory::getApplication()->enqueueMessage(trim($query),'info');
// throw new Exception('Error Message СООБЩЕНИЕ!! ');
//return null; 


		$event = StatusObject::new($data, $QRcode);
//echo str_replace('#__', JFactory::getApplication()->getConfig()->get('dbprefix'), $query) .'<br>';
//return null;	
//		$event->QRcode = $QRcode;
//static::$debugMessage .= ' status_title645:'. $event->status_title;
		
		//loadObjectList('order_item_id');		//Joomla\Module\Placebilet\Administrator\BD\
//		'\Joomla\Module\Placebilet\Administrator\BD\StatusObject'
		/** Определение количества разрядов индекса */
//		$index_length = strlen(($event->count_places - 1));
		/** Получение индекса из QR кода / С ведущими нулями */
//		$event->index = substr($QRcode, $position_dot + 1, $index_length); /* С ведущими нулями */
		
		
		$newQR = static::getQRcode($order_item_id, $event->index);
//return $newQR;
//echo "-$order_item_id, $index-";
//echo '<br>- QR: ';
//echo $QRcode;
//echo ' - newQR: ';
//echo $newQR;
//echo '  <br>';
		
		if($newQR != $QRcode){
			return null;
		}
//		$order_itemTable->places		= json_encode($places);		 // array( ProdValID => "value_id,attr_id", ...)
//		$order_itemTable->place_prices	= json_encode($place_prices);// array( ProdValID =>	price, ...)
//		$order_itemTable->place_counts	= json_encode($place_counts);// array( ProdValID =>	count, ...)
//		$order_itemTable->place_names	= serialize($place_names);	//	array( ProdValID => attr_Name . ' - ' . place_name,... )
		
//		$event->place_index = (int)$index;
		$place_counts	= (array) json_decode($event->place_counts??'{}', true);// ": "{\"17\":1,\"21\":1}",
		$places			= (array) json_decode($event->places??'{}', true);		// ": "{\"17\":1,\"21\":1}",
		$place_prices	= (array) json_decode($event->place_prices??'{}', true);// ": "{\"4625\":\"30.0000\",\"4629\":\"30.0000\"}",		// ProdValID	:	price
		$place_names	= (array) unserialize($event->place_names??'a:0:{}');	// ": "a:2:{i:17;s:31:\"\u0413\u0440\u0435\u0447\u0435\u0441\u043a\u0438\u0439 \u0437\u0430\u043b  - 17\";i:21;s:31:\"\u0413\u0440\u0435\u0447\u0435\u0441\u043a\u0438\u0439 \u0437\u0430\u043b  - 21\";}",
		
		
		/**  Определение ID ключа из ПроКультура / Выполняется внутри конструкора класса StatusObject объекта $event */
//		$place_pushka	= (array) str_getcsv($event->place_pushka);// 0000721b-be15-4bc2-a80a-f6c047417134,0000721b-b94d-418e-abdf-73a229404396
//		$event->pushka_id = $place_pushka[$event->index] ?? '';

		
//file_put_contents(__DIR__ . '/logHelper.txt', '$places : '.print_r($places,true). " \n\n"); //FILE_APPEND
//file_put_contents(__DIR__ . '/logHelper.txt', '$places : '.print_r($place_prices,true). " \n\n", FILE_APPEND); //FILE_APPEND
//file_put_contents(__DIR__ . '/logHelper.txt', '$place_names : '.print_r($place_names,true). " \n\n", FILE_APPEND); //FILE_APPEND
//file_put_contents(__DIR__ . '/logHelper.txt', '$event : '.print_r($event,true). " \n\n", FILE_APPEND); //FILE_APPEND

//		$values_id = array_keys($places);
//		$event->place_velue_id = $values_id[$event->place_index] ?? 0;
		
		
		/** @var int $event->place_index индекс билета в заказе */
		$event->place_index;
		/** @var int $event->place_number Номер билета в поле  , нумерация с 1 начинается */
		$event->place_number;
		/** @var int $event->place_count Количество билетов в поле  */
		$event->place_count;
		/** @var int $event->place_prodVal_id ID поля билета Продукта */
		$event->place_prodVal_id;
		
		
		$i = 0;
		
		foreach ($place_counts as $pr_attr_id => $count){
			foreach (range(1, $count) as $number){
				if($i++ == $event->place_index){
					$event->place_prodVal_id = $pr_attr_id;
					$event->place_number = $number;
				}
			}
		}
//		$prodVals_id = array_keys($place_prices);
//		$prodVals_id[$event->place_index] ?? '';

//		$event->place_attr_id = $places[$event->place_velue_id] ?? 0;
		list($event->place_velue_id, $event->place_attr_id) = str_getcsv($places[$event->place_prodVal_id] ?: '0,0');
		$event->place_price = $place_prices[$event->place_prodVal_id] ?? '';
		$event->place_name = $place_names[$event->place_prodVal_id] ?? '';
		$event->place_count = $place_counts[$event->place_prodVal_id] ?? 1;
		
		
		$statusEventObject = static::getStatusbyCSV($event->place_go, $event->place_index);
		
//echo '<br>$event->place_index: <pre>'.print_r($event->place_index,true).'</pre>  ';
//echo '<br>$event->place_go: <pre>'.print_r($event->place_go,true).'</pre><hr><br>';
//static::$debugMessage .= print_r($statusEventObject,true);		
		$event->place_status_code = $statusEventObject ? $statusEventObject->code : $event->order_status_id;
		$event->place_status_date = $statusEventObject ? $statusEventObject->getDate() : static::getDate($event->order_date);
//static::$debugMessage .= print_r($event->place_status_code,true);		
		
		
		
//echo '<pre>'.print_r(321213,true).'</pre>';
//echo '<pre>'.print_r($event,true).'</pre>';
//echo '<br>$event: <pre>'.print_r($event,true).'</pre><hr><br>';
//echo '<br>$statusEventObject: <pre>'.print_r($statusEventObject,true).'</pre><hr><br>';
		
		$query="
SELECT s.status_id, s.status_code, CONCAT_WS(' /', $langs , s.status_code) status_title
FROM #__jshopping_order_status s
WHERE s.status_code = '$event->place_status_code' OR s.status_id = '$event->place_status_code'
LIMIT 1;
		";
//echo str_replace('#__', JFactory::getApplication()->getConfig()->get('dbprefix'), $query);
		$status = JFactory::getDbo()->setQuery($query)->loadObject();
		

//echo '<br>$event: <pre>'.print_r($event,true).'</pre><hr><br>';
		$event->place_status_title = $status->status_title ?? '';
		$event->place_status_code = $status->status_code ?? '';
		
//static::$debugMessage .= print_r($event->place_status_title,true);	
//static::$debugMessage .= print_r($event->place_status_code,true);	
		
//echo '<br>$event: <pre>'.print_r($event,true).'</pre><hr><br>';
//echo '<br>$query: <pre>'.print_r($query,true).'</pre><hr><br>';
		return $event;
		
//		if(empty(static::$languageList)){
//			static::$eventList = [];
//			return static::$eventList;
//		}
			
		
//		str_starts_with($haystack, 'vm');
		
	}

	/**
	 * Преобразование строки статусов из формата CSV в объект статуса StatusEventObject
	 * Формат строки: 123:P:1676813832
	 * где 123 - индекс билета в заказе, P - статус-код заказа, 1676813832 - время смены статуса в Unix формате
	 *
	 * @param string $StringCSV строка CSV с логом изменения статусов для одного билета из заказа
	 * @param int $index индекс одного билета из заказа
	 * @return StatusEventObject|null
	 */
	public static function getStatusbyCSV(string $StringCSV, int $index = 0): ?StatusEventObject {
		
		$stats = array_reverse(str_getcsv($StringCSV));		
		
//echo '<br>$stats: <pre>'.print_r($stats,true).'</pre>  ';
		
		foreach ($stats as $stat){
			if(empty($stat))
				continue;
			$st_t = explode(':', $stat);
			
			$i = $st_t[0] ?? null;	// Индекс
			$c = $st_t[1] ?? null;	// Статаус-код
			$t = $st_t[2] ?? 0;		// Время по Unix
//echo '<br>$index: <pre>'.print_r($t,true).'</pre>  ';
//echo '<br>IF StatusEventObject: <pre>'.print_r(($i != null && $c && $i == $index),true).'#</pre>  ';
			
			if($i != null && $c && $i == $index){
				return StatusEventObject::new((int)$index, (string)$c, (int)$t);
			}
		}
		return null;
	}
	
	/**
	 * Узнать размер папки в байтах, не используется в модуле вообще
	 * @param type $path
	 * @return string
	 */
public static function getDirectorySize($path){
    $bytestotal = 0;
    $path = realpath($path);
    if($path!==false && $path!='' && file_exists($path)){
        foreach(new RecursiveIteratorIterator(new RecursiveDirectoryIterator($path, FilesystemIterator::SKIP_DOTS)) as $object){
            $bytestotal += $object->getSize();
        }
    }
    return ($bytestotal / 1024).' Kb';
}
public static function dirSize($path): int {
	$path = rtrim($path, '/');
	$size = 0;
	$dir = opendir($path);
	if (!$dir) {
		return 0;
	}
	
	while (false !== ($file = readdir($dir))) {
		if ($file == '.' || $file == '..') {
			continue;
		} elseif (is_dir($path . $file)) {
			$size += dirSize($path . DIRECTORY_SEPARATOR . $file);
		} else {
			$size += filesize($path . DIRECTORY_SEPARATOR . $file);
		}
	}
	closedir($dir);
	return $size;
}
	
	/**
	 * Возвращает Объект с значениями из Input, с проведёнными проверками
	 * @return InputObject|null
	 */
	public static function getInputObject(): ?InputObject {
		
//		$app = JFactory::getApplication();
		$input = JFactory::getApplication()->getInput();
		
		$clientId = JFactory::getApplication()->getClientId();
		
//		$session = JFactory::getApplication()->getSession();
		
		
		$id = $input->getInt('id', 0);
		$method  = static::$debug ? 'get' : 'post';
		//JFactory::getApplication()->checkToken($method)
		if(empty($clientId) || empty($id) || empty(\Joomla\CMS\Session\Session::checkToken($method))){//$app->getFormToken()
			return null;
		}
		
		
		require_once static::$path . '/Lib/input.php';
		
		$object = new InputObject;
		$object->method		= (string)$input->getString('method', '');
		
		if(empty(static::$debug))
			$input = $input->post;
		
		$object->id			= (int)$input->getInt('id', 0);
		$object->eventID	= (int)$input->getInt('eventID', 0);
		$object->orderID	= (int)$input->getInt('orderID', 0); // не используется. Для получения списка QR по ID заказа.
		$object->QRcode		= (string)$input->getString('QRcode', '');
		$object->format		= (string)$input->getCmd('format', '');
		$object->token		= (string)$input->getCmd('token', '');
		$object->action		= (string)$input->getWord('action', '');
		$object->action		= ucfirst($object->action);
		$object->language	= (string)$input->getString('lang', JFactory::getApplication()->getLanguage()->getTag());
		$object->language	= $object->language ?: JFactory::getApplication()->getLanguage()->getTag();
		
//file_put_contents(__DIR__ . '/logHelper.txt', print_r($object,true)." 960 \n\n\n", FILE_APPEND);
		$data = JFactory::getApplication()->input->json->getArray();
		foreach ($data as $var => $value){
			if(isset($object->$var)){
				$type = gettype($object->$var);
				settype($value, $type);
				$object->$var = $value;
//file_put_contents(__DIR__ . '/logHelper.txt', "$var: $type => $value \n", FILE_APPEND);
			}
//file_put_contents(__DIR__ . '/logHelper.txt', "$var => $value \n", FILE_APPEND);
		}
		
		$object->QRcode = trim($object->QRcode);
		
//		$object->clientId = $clientId;
		
		return $object;
		//'?option=com_ajax&method=placebilet&method=&format=debug'
		
	}



	/**
	 * Получение параметров настроек модуля.
	 * @param int $id ID модуля, не обязательно
	 * @return Reg|null
	 */
	public static function getParam($id_module = 0) : ?JRegistry {
		
		if(empty($id_module) || isset(static::$module[$id_module]) && empty(static::$module[$id_module]))
			return null;
		
		if($id_module && isset(static::$param[$id_module])){
			return static::$param[$id_module];
		}
		
//		static::$module[$id_module] = JModuleHelper::getModule('placebilet');
		static::$module[$id_module] = JModuleHelper::getModuleById((string)$id_module);
		
		
		if(empty(static::$module[$id_module]) || empty(static::$module[$id_module]->id)){
			static::$param[$id_module] = null;
			return null;
		}
		
		static::$param[$id_module] = new \Reg();
		static::$param[$id_module]->loadString(static::$module[$id_module]->params);
		static::$param[$id_module]->loadObject(static::$module[$id_module]);
		
		return static::$param[$id_module];
		
	}
	
	

	
	/**
	 * Генерация QR 
	 * @param type $order_item_id
	 * @param string $index
	 * @return string
	 */
	public static function getQRcode($order_item_id, string|int $index = '0', int $count_places = 0): string {
//		return sprintf("%u",crc32(md5('17.0.6hWthIyGp8mtY1hNhDZzOgdznhVvCqAw')));
		$secret = JFactory::getApplication()->getConfig()->get('secret');// as JRegisctry
		
		$index_string = $count_places ? 
				  str_pad($index, strlen($count_places - 1), "0", STR_PAD_LEFT) : $index;
		
		$hash = sprintf("%u",crc32(md5($order_item_id . '.' . $index_string . '.' . $secret)));
		return 'js' . $order_item_id . '.' . $index_string . $hash; 
	}
	
	public static function getPushka($param = null): ?Pushka {
		
		if(empty($param) && empty(static::$param))
			return null;
		
		if(! class_exists('\API\Kultura\Pushka\Pushka'))
		require_once static::$path . '/Lib/pushka.php';
		
		$param = $param ?? static::$param;
		
		$pushka = null;
		
		if($param->pushka_mode == 'uat')
			$pushka = Pushka::new($param->pushka_key_uat,  $param->pushka_url_uat, false);
		
		if($param->pushka_mode == 'prod')		
			$pushka = Pushka::new($param->pushka_key_prod, $param->pushka_url_prod, false);
		
		if(empty($param->pushka_mode))
			$pushka = Pushka::new();
		
		return $pushka;
	}
	
	public static function getHtmlDark() {
		?>
<style>
	html{
		color: lightgray;
		color: lightsteelblue;
		background-color: black;
		font-family: monospace;
	}
</style>
		<?php
		
	}
	
	public static function addNewStatusBD(int $order_item_id, int $place_index, int $status_ID = 0, string $place_name = '') {
		
		if(empty($status_ID))
			return false;
		
//		$place_name = JFactory::getDbo()->escape($place_name);
//		$action = JFactory::getDbo()->escape($action);

		
//echo str_replace('#__', JFactory::getApplication()->getConfig()->get('dbprefix'),  JFactory::getDbo()->getQuery(false)) .'<br><br>';
//toPrint($query->->getBounded(), 'Bounded',0,'pre',true);
//		JFactory::getDbo()->execute();
//		JFactory::getDbo()->getQuery(false)->clear();
//		JFactory::getDbo()->getQuery(true)->clear();
//echo str_replace('#__', JFactory::getApplication()->getConfig()->get('dbprefix'), $query) .'<br><br>';
//return '{"message":"'.JText::_('ERROR ACTION') .'"}';
		
			$timezone = 'GMT';
			$timezone = 'UTC';
			$timezone = JFactory::getApplication()->getConfig()->get('offset','UTC');
			$timezone = JFactory::getApplication()->getIdentity()->getParam('timezone',$timezone);
		
		$unix_timestamp = JDate::getInstance('now',$timezone)->getTimestamp();
		// UNIX_TIMESTAMP()
		$query = "
UPDATE #__jshopping_order_item oi 
INNER JOIN #__jshopping_order_status s ON s.status_id = $status_ID 
SET oi.place_go = CONCAT(IFNULL(oi.place_go,''), IF(oi.place_go,',',''), $place_index, ':', s.status_code, ':', $unix_timestamp) 
WHERE  oi.order_item_id = $order_item_id ;
		";
		$status = JFactory::getDbo()->setQuery($query)->execute();
static::$debugMessage .= $query ."     \n\n      ";
//echo str_replace('#__', JFactory::getApplication()->getConfig()->get('dbprefix'), $query) .'<br><br>';
		
//file_put_contents(__DIR__ . '/logHelper.txt', "$var: $type => $value \n", FILE_APPEND);
		
//		$query = "
//INSERT INTO #__jshopping_order_history
//(order_id,order_status_id,status_date_added,customer_notify,comments)
//SELECT oi.order_id order_id, s.status_id order_status_id, NOW() status_date_added, 0 customer_notify, CONCAT($place_index,') ',  '\n $place_name') status_name_comments
//FROM #__jshopping_order_status s, #__jshopping_order_item oi
//WHERE s.status_id = '$status_ID'  AND oi.order_item_id = $order_item_id;
//				"; //CONCAT_WS(' /', $langs ),
		
		
//		$query = "
//INSERT INTO #__jshopping_order_history
//(order_id,order_status_id,status_date_added,customer_notify,include_comment,comments)
//SELECT oi.order_id order_id, $status_ID order_status_id, NOW() status_date_added, 0 customer_notify, 0 include_comment, '$place_index ) \n $place_name' status_name_comments
//FROM #__jshopping_order_item oi
//WHERE oi.order_item_id = $order_item_id;
//		";
//		$status = JFactory::getDbo()->setQuery($query)->execute();
		
		return true;
	}
	
	public static function getDate($date = 'now', bool $timestamp = false){
		
//		$timezone = 'GMT';
//		$timezone = 'UTC';
		$timezone = JFactory::getApplication()->getConfig()->get('offset','UTC');
		$timezone = JFactory::getApplication()->getIdentity()->getParam('timezone',$timezone);
		$date = JDate::getInstance($date, $timezone);
		if($timestamp)
			return $date->getTimestamp();
		return $date;
	}
}
