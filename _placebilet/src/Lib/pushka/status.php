<?php namespace Joomla\Module\Placebilet\Administrator\BD;
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

/**
 * Объект статуса билета 
 */
class StatusObject{	
	
	/**
	 * ID Пушки билета, получаемое только из ПроКультура,
	 * для отдельного билета 
	 * @var int
	 */
	public string $pushka_id = '';
	
	/**
	 * IDs Пушки билетов, получаемое только из ПроКультура,
	 *  через запятую
	 * @var int
	 */
	public string $place_pushka = '';
	
	/**
	 * ID Подзаказа продукта
	 * @var int
	 */
	public int $order_item_id = 0;		// ": 14,
	/**
	 * ID Заказа 
	 * @var int
	 */
    public int $order_id = 0;			// ": 29,
	/**
	 * Количество мест(билетов) в подзаказе
	 * @var int
	 */
    public int $count_places = 0;		// ": 2,
	
		public string $date_event = '';		// ": "2023-12-31 14:00:00",
		
		public string $date_tickets = '';		// ": "2023-12-31 14:00:00",
		
		/** массив как строковый CSV формат хранения смены статусов для всех билетов этого заказа продукта <br>
		 * формат: 123:P:1676813832,...
		 * где 123 - индекс билета в заказе, P - статус-код заказа, 1676813832 - время смены статуса в Unix формате
		 * @var string
		 */
		public string $place_go = '';		// ": "",
		
		
		/** строковый список массив количества билетов по каждому полю в JSON<br>
		 * array([ ProdValID => count])<br>
		 *		 { ProdValID :	count }<br>
		 * {"4625":3,"4629":1}<br>
		 * @var string
		 */
		public string $place_counts = '';
		/** строковый список массив  ID мест и атрибутов в JSON<br>
		 * array([ ProdValID => 'value_id,attrID', ...  ])<br>
		 *		 { ProdValID :	'value_id,attrID', ... }<br>
		 * {"4625":"17,1","4629":"21,1"}<br>
		 * @var string
		 */
		public string $places = '';			// {"4625":"17,1","4629":"21,1"}								// value_id:	attrID
		/** Строковый массив с ID мест и их названий рядов с именами мест<br>
		 * serialize array ключи ID мест, значения строка с именем ряда и именем места<br>
		 * array([ ProdValID => "attr_Name - place_name", ... ])<br>
		 *		 { ProdValID :  attr_Name . ' - ' . place_name, ... }<br>
		 * @var string
		 */
		public string $place_names = '';		// ": "a:2:{i:4625;s:31:\"\u0413\u0440\u0435\u0447\u0435\u0441\u043a\u0438\u0439 \u0437\u0430\u043b  - 17\";i:4629;s:31:\"\u0413\u0440\u0435\u0447\u0435\u0441\u043a\u0438\u0439 \u0437\u0430\u043b  - 21\";}",
		/** 
		 * строковый список массив c ID цены для товара и самой ценой в JSON<br>
		 * array([ ProdValID	=>	price ]) <br>
		 *		 { ProdValID	:	price, ... }<br>
		 * {"4625":"30.0000","4629":30.0000"}
		 * @var string
		 */
		public string $place_prices		= '';	// ": "{\"4625\":\"30.0000\",\"4629\":\"30.0000\"}",		// ProdValID	:	price
		public string $product_name		= '';	// ": "\u042d\u043a\u0441\u043f\u043e\u0437\u0438\u0446\u0438\u044f \u043c\u0430\u0441\u0442\u0435\u0440\u0441\u043a\u043e\u0439 \u0410. \u0418. \u041a\u0443\u0440\u043d\u0430\u043a\u043e\u0432\u0430  31-\u0434\u0435\u043a 14:00<\/span>",
    public int $product_id			= 0;			// ": 8,
    public int $status_id			= 0;			// ": 6,
		public string $status_code		= '';		// ": "O",
		public string $status_date_added= '';// ": "2023-02-07 19:40:05",
		public string $status_title		= '';	// ": "Paid \/Paid \/O",
		
	/** ID события в ПроКультура
	 * @var int
	 */ 
    public int $event_id = 0;			// ": 1243159
	
	/** ID параметра места <br>
	 * /Вычисляется из поля [places]<br>
	 * !С ведущими нулями  
	 * @var string
	 */
	public string $index = '';
	
	/** ID параметра места <br>
	 * /Вычисляется из поля [places]
	 * ID для #__attr_values
	 * @var int
	 */
	public int  $place_velue_id = 0;
	
	/** ID атрибута /ряда <br>
	 * /Вычисляется из поля [places]
	 * ID для #__attr
	 * @var int
	 */
	public int  $place_attr_id = 0;
	
	/** ID цены для параметра места Продукта <br>
	 * /Вычисляется из поля [places]
	 * ID для #__products_attr2
	 * @var int
	 */
	public int  $place_prodVal_id = 0;
	
	/** Номер билета в поле для полей с заказом количества белетов в поле,
	 *  Нумерация с 1 начинается <br>
	 * /Вычисляется из полей [count_places]
	 * @var int
	 */
	public int $place_number = 1;
	
	/** Количество билетов в поле
	 * /Вычисляется из полей [count_places]
	 * @var int
	 */
	public int $place_count = 0;
	
	
	/** Цена места <br>
	 * /Вычисляется из поля [place_prices]
	 * @var string
	 */
	public string $place_price = '';
	
	/** Цена билета места в покупке заказа представления <br>
	 * /Вычисляется из поля [place_prices]
	 * @var string
	 */
	public string $place_name = '';
	
	/** Буквенный статус билета в покупке заказа представления <br>
	 * /Вычисляется из поля [place_go]
	 * @var string
	 */
	public string $place_status_code = '';
	
	/** Наименование статуса билета в покупке заказа представления <br>
	 * /Вычисляется из поля [place_go]
	 * @var string
	 */
	public string $place_status_title = '';
	
	/** Дата изменения статуса билета<br>
	 * /Вычисляется из поля [place_go]
	 * @var \DateTime
	 */
	public ?\DateTime $place_status_date = null;
	
	/** Порядковый индекс билета в покупке заказа представления <br>
	 * /Без ведущих Нулей <br>
	 * /Вычисляется из поля [place_go]
	 * @var int
	 */
	public int $place_index = 0;
	
	/** QR код
	 * @var string
	 */
	public string $QRcode = '';
	
	
	public string $order_status_id = '';
	public string $order_date = '';
	
	
	public static function new($dataRowDB = [], $QRcode = '') : StatusObject{
		
		$dataRowDB = (array) $dataRowDB;
		
		$obj = new StatusObject;
		
		foreach ($dataRowDB as $prop => $val){
//file_put_contents(__DIR__ . '/logHelper.txt', "$prop => $val \n", FILE_APPEND);
			if(isset($obj->$prop))
				$obj->$prop = $val;
		}
		
		if($QRcode){
			$position_dot = strrpos($QRcode, '.');
		
			/** Определение общего количества разрядов индекса */
			$index_length = strlen($obj->count_places - 1);
			
			/** Получение индекса из QR кода / С ведущими нулями */
			$obj->index = substr($QRcode, $position_dot + 1, $index_length); /** С ведущими нулями */
		
			$obj->QRcode = $QRcode;
			
			$obj->place_index = (int)$obj->index;
		}
		
		/**  Определение ID ключа из ПроКультура */
		if($dataRowDB && isset($dataRowDB['place_pushka']) && $dataRowDB['place_pushka']){
			$place_pushka	= (array) str_getcsv($dataRowDB['place_pushka']);// 0000721b-be15-4bc2-a80a-f6c047417134,0000721b-b94d-418e-abdf-73a229404396
			$obj->pushka_id = $place_pushka[$obj->index] ?? '';
		}
		
		return $obj;
	}
	
}
	