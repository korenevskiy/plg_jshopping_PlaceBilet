<?php namespace Joomla\Module\Placebilet\Administrator;
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

use Joomla\CMS\Date\Date as JDate;
use Joomla\CMS\Factory as JFactory;

/*
 * Объект статуса события для отдельного места в отдельном заказе
 */
class StatusEventObject{	
	
	/** ID параметра места <br>
	 * @var int
	 */
	public int $index = 0;
	
	/** Код(буква) статуса заказа для одного места <br>
	 * @var string
	 */
	public string $code = '';		// ": "O",
	
	/** Дата изменения статус <br>
	 * @var int
	 */
	public int $date = 0;		// ": "2023-12-31 14:00:00",
	
	/**
	 * Время события статуса
	 * @return JDate
	 */
//	public function getDate() : JDate {
//		
//		//$secret = JFactory::getApplication()->getConfig()->get('secret');// as JRegisctry
//		
//			$timezone = 'GMT';
//			$timezone = 'UTC';
//			$timezone = JFactory::getApplication()->getConfig()->get('offset','UTC');
//			$timezone = JFactory::getApplication()->getIdentity()->getParam('timezone',$timezone);
//		
//		if($this->date)
//			return JDate::getInstance($this->date, $timezone);//JDate::setTimestamp($this->date);//->setTimezone($tz)
//		else 
//			return JDate::getInstance ('', $timezone);
//	}
	
	
	public function __toString() {
		$date = $this->date;
		if(empty($date)){
			$date = time();
		}
			
		return $this->index . ':' . $this->code . ':' . $date;
	}
	
	/**
	 * Новый статус события
	 * @param int $index Индекс в заказе 
	 * @param string $code Код статус заказа
	 * @param int|string|\DateTime $date Дата события статуса
	 * @return StatusEventObject
	 */
	public static function new(int $index = 0, string $code = '', int|string|\DateTime $date = '') : StatusEventObject{
		
		$obj = new StatusEventObject($index, $code, $date);
		return $obj;
	}
	
	/**
	 * Новый статус события
	 * @param int $index Индекс в заказе 
	 * @param string $code Код статус заказа
	 * @param int|string|\DateTime $date Дата события статуса
	 * @return StatusEventObject
	 */
	public function __construct(int $index = 0, string $code = '', int|string|\DateTime $date = '') {
		
		$this->index = $index;
		$this->code = $code;
		
		
			$timezone = 'GMT';
			$timezone = 'UTC';
			$timezone = JFactory::getApplication()->getConfig()->get('offset','UTC');
			$timezone = JFactory::getApplication()->getIdentity()->getParam('timezone',$timezone);
		
		if(is_string($date)){
			$this->date = JDate::getInstance($date,$timezone)->toUnix();
			return;
		}
		if(is_int($date)){
			$this->date = $date;
			return;
		}
		if(is_a($date,\DateTime::class)){
			$this->date = $date->format('U');
			return;
		}
	}
}
	