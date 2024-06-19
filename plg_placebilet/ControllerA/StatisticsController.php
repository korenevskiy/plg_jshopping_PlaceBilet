<?php
 /** ----------------------------------------------------------------------
 * plg_PlaceBilet - Plugin Joomshopping Component for CMS Joomla
 * ------------------------------------------------------------------------
 * author    Sergei Borisovich Korenevskiy
 * @copyright (C) 2019 //explorer-office.ru. All Rights Reserved. 
 * @license GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 * @package		Jshopping
 * @subpackage  plg_placebilet
 * Websites: //explorer-office.ru/download/
 * Technical Support:  Forum - //fb.com/groups/multimodulefb.com/groups/placebilet/
 * Technical Support:  Forum - //vk.com/placebilet
 * -------------------------------------------------------------------------
 **/

namespace Joomla\Component\Jshopping\Administrator\Controller;
defined('_JEXEC') or die(); 

use \Joomla\CMS\Factory as JFactory;
use \Joomla\CMS\Date\Date as JDate;
use Joomla\CMS\Form\FormHelper as JFormHelper;
use \Joomla\Component\Jshopping\Site\Lib\JSFactory  as JSFactory;
//JLoader::registerAlias('JForm', '\\Joomla\\CMS\\Form\\Form', '6.0');
//JLoader::registerAlias('JFormField', '\\Joomla\\CMS\\Form\\FormField', '6.0');
//JLoader::registerAlias('JFormHelper', '\\Joomla\\CMS\\Form\\FormHelper', '6.0');

//toPrint();

jimport( 'joomla.html.html.select' );
JFormHelper::loadFieldClass('radio');
jimport('joomla.form.helper');

//jimport('joomla.application.component.controller');
//class JshoppingControllerEmpty extends BaseadminController{
class StatisticsModController extends BaseadminController{//JControllerLegacy  //JshoppingControllerBaseadmin
    
	
    function init(){
        \JSHelperAdmin::checkAccessController("statistics");
        \JSHelperAdmin::addSubmenu("other");
    }
	
	function getFactory(){
		return $this->factory;
	}
	function setFactory($factory = null){
		if($factory)
			$this->factory = $factory;
	}

// Член требуемый для J4, для совместимости J3 отключен, но компенсируется $config['default_view'] в конструкторе
//	protected $name = 'Empty';
	
    protected $template_name;
	
//	protected $default_view = 'Empty';
	
    function __construct( $config = array(), \Joomla\CMS\MVC\Factory\MVCFactoryInterface $factory = null, $app = null, $input = null  ){
		
//        $this->nameModel = 'empty';
        parent::__construct($config, $factory, $app, $input); 
//          $this->set('redirect', null);
//          echo "<pre>ControllerEmptyDisplay: ";
//          var_dump($this->get('redirect'));
//          echo "</pre>"; 
        $this->registerTask( 'add',   'display' );
        $this->registerTask( 'apply', 'display' );
        $this->registerTask( 'edit',   'display' );
        $this->registerTask( 'save', 'display' );
        $this->registerTask( 'remove',   'display' );
        $this->registerTask( 'order', 'display' );
        $this->registerTask( 'saveorder','display' );
        $this->registerTask( 'back', 'display' );
        $this->registerTask( 'delete_foto','display' ); 
		
		$this->template_name = \PlaceBiletHelper::$template_name;
    }
    
    function display($cachable = false, $urlparams = false){
		
//		$host = JFactory::getConfig()->get('host');
        
        $db = \JFactory::getDBO();
        
		
        $viewName	= $this->input->get('view', 'statistics');			// $this->default_view-> 'displaymod'
        $viewLayout	= $this->input->get('layout', 'default', 'string');		// -> 'default'
        $taskView	= $this->input->get('task', '', 'string');		// -> 'default'
        $viewType	= $this->app->getDocument()->getType(); 
		
		
		if(file_exists(PlaceBiletPath."/View/$viewName"))
			$basePath = PlaceBiletPath."/";
		else
			$basePath = $this->basePath;
		
		if(file_exists(PlaceBiletPath."/View/".ucfirst($viewName)."/". ucfirst($viewType).'View.php'))
			require_once PlaceBiletPath."/View/".ucfirst($viewName)."/". ucfirst($viewType).'View.php';
		
        \JSHelperAdmin::checkAccessController("statistics");
//        \JSHelperAdmin::addSubmenu("");
		$view = $this->getView($viewName, $viewType, '', ['base_path' => $basePath, 'layout' => $viewLayout]);		// /View/Statistics/HtmlView.php
//toPrint(null,'',false,false,false);
//toPrint($view,'$view',true,'message',true);	
        $view->setLayout("default");						// /templatesA/statistics/default.php
        $view->addTemplatePath(\PlaceBiletPath."/templatesA/statistics");
        $view->addTemplatePath(\PlaceBiletPath."/templatesA/$viewName");//Новый шаблон
        $view->addTemplatePath(JPATH_BASE."/templates/$this->template_name/html/com_jshopping/statistics/"); //Новый шаблон   
        $view->addTemplatePath(JPATH_BASE."/templates/$this->template_name/html/com_jshopping/$viewName/"); //Новый шаблон   
//        $view->tmp_html_start = "";
//        $view->tmp_html_end = "";
		
			
//        $_currency = \JSFactory::getModel("currencies");
//        $view->currency_list = $_currency->getAllCurrencies();
//        $order_currency = 0;
//        foreach($currency_list as $k=>$v){
//            if ($v->currency_code==$order->currency_code) $order_currency = $v->currency_id;
//        } 
		
		
		
		$where = [];
		
			$timezone = 'GMT';
			$timezone = 'UTC';
			$timezone = JFactory::getApplication()->getConfig()->get('offset','UTC');
			$timezone = JFactory::getUser()->getParam('timezone',$timezone);
		
		$fieldDateStart	= $this->input->getString('field_date_start', 'now');		// -> 'default'
		$fieldDateStop	= $this->input->getString('field_date_stop', 'now');		// -> 'default'
		
		$fieldDateStart	= JDate::getInstance($fieldDateStart, $timezone)->setTime(0, 0);
		$fieldDateStop	= JDate::getInstance($fieldDateStop, $timezone)->setTime(0, 0);
		if($fieldDateStart > $fieldDateStop){
			$fieldTemp = $fieldDateStart;
			$fieldDateStart = $fieldDateStop;
			$fieldDateStop = $fieldTemp;
		}
		
		$view->fieldDateStart = $fieldDateStart;
		$view->fieldDateStop = clone $fieldDateStop;
		
		$fieldDateStart	= $view->fieldDateStart->toSql(true);
		$fieldDateStop	= $view->fieldDateStop->setTime(23, 59, 60)->toSql(true);
		
		$where[] =  "'$fieldDateStart' <= o.order_date AND o.order_date < '$fieldDateStop'"; //--  Покупка
		
		
//toPrint(null,'',0,'',true);
//toPrint($where,'$where',0,'pre',true);
		
		
			
		$view->fieldCategories = (array)$this->input->get('field_Categories', []);
		
		if($view->fieldCategories){
			$where[] = 'EXISTS (SELECT * FROM #__jshopping_products_to_categories c 
								WHERE i.product_id = c.product_id AND c.category_id IN (' . implode(',', $view->fieldCategories) . '))';
		}
		
		$view->fieldEvents = (array)$this->input->get('field_Events', []);
		
		if($view->fieldEvents){
			$where[] = 'i.event_id IN (' . implode(',', $view->fieldEvents) . ') '; //-- IDs событий из ПроКультура
		}
		
		
		$view->placePushka = (string)$this->input->getString('field_Card', 0);
		
		switch($view->placePushka){// : 0, pushka, bank
			case 'bank':
				$where[] = 'i.place_pushka = "" '; //-- Покупка по карте Банка
				break;
			case 'pushka':
				$where[] = 'i.place_pushka != "" '; //-- Покупка по карте Пушки
				break;
		}
		
//		$langs = implode(',', PlaceBiletHelper::getLanguageList('c.name_'));
//		$langs = implode(',', PlaceBiletHelper::getLanguageList('c.name_'));
		
		// "✔❌";
		
		$query = "
 SELECT 
	SUM(o.order_total) summ_tickets_buy, SUM(i.count_places) count_tickets_buy,
	i.product_id, i.product_name, 
	-- GROUP_CONCAT(o.order_status SEPARATOR ',') order_status,
	-- o.order_total,  o.order_status, o.order_id,o.order_date,i.count_places ,i.place_go,
	o.currency_code,
	0 summ_tickets_refund, 0 count_tickets_refund, 0 summ_tickets_visit, 0 count_tickets_visit
FROM #__jshopping_orders o 
INNER JOIN #__jshopping_order_item i ON o.order_id = i.order_id 
WHERE " . join("\n AND ", $where) . "
GROUP BY i.product_id 
ORDER BY i.date_event ; ";
//		return;
		$view->order_items = $db->setQuery($query)->loadObjectList('product_id');
		
		
//toPrint($query,'$query',0,'pre');		
		
		$query = "
SELECT * 
FROM (
	SELECT 
		o.order_date,
		i.date_tickets,
		i.order_item_id,
		i.product_id,
		i.count_places,
		i.product_name,
        i.place_counts,
		i.place_go,
		i.place_prices,  -- {4766:30.0000, 4771:30.0000}	value_id=>  addprice
		i.places,		 -- {17:1,21:1}						var_id  =>	attr_id
		o.currency_code,o.order_status,
		FROM_UNIXTIME(SUBSTRING_INDEX(SUBSTRING_INDEX(i.place_go,	',',  1),':',-1)) place_go_first,
		FROM_UNIXTIME(SUBSTRING_INDEX(SUBSTRING_INDEX(i.place_go,	',', -1),':',-1)) place_go_last
	FROM #__jshopping_orders o
    INNER JOIN #__jshopping_order_item i ON o.order_id = i.order_id
	WHERE 
		i.place_go ='' AND '$fieldDateStart' <= o.order_date AND o.order_date <= '$fieldDateStop' -- Покупка
		OR
        i.place_go!='' AND '$fieldDateStart' < i.date_event AND (i.date_tickets < '$fieldDateStop' AND i.date_tickets != 0 OR o.order_date < '$fieldDateStop' AND i.date_tickets = 0)  -- Визит,Отмена
    ) rawData
	-- , 	#__jshopping_order_item item
WHERE rawData.place_go_first AND '$fieldDateStart' < rawData.place_go_first 	AND rawData.place_go_last AND rawData.place_go_last <= '$fieldDateStop' 		OR rawData.place_go = ''
ORDER BY rawData.place_go DESC; ";

//toPrint($query,'$query',0,'pre');		
//return;
		
        $view->orders_all = $db->setQuery($query)->loadObjectList('order_item_id');
		
		\PlacebiletHelper::getStatusAllList();
		$view->statusList = \PlacebiletHelper::$statusList; // Все статусы $status_code => object(status_id,status_code,title)
		
		$view->columnStatus = [];							// Имеющиеся статусы  $status_code => object(status_id,status_code,title)
//		$view->columnSumm = 0;
//		$view->columnCount = 0;
		$view->rowAttributes = [];							// 
		
		
		$tickets_groups = [];
		foreach($view->orders_all as $item){
			$places_goes = str_getcsv($item->place_go);
			
			
			$item->place_prices	= json_decode($item->place_prices, JSON_OBJECT_AS_ARRAY);//-- {166:"30.0", 162:"30.0"}	array( ProdValID =>	price, ...)
//			$item->place_prices = array_map(fn($item)=>(int)$item, $item->place_prices);
			$prices				= array_values($item->place_prices);	//[30.0, 30.0]
			$item->places		= json_decode($item->places, JSON_OBJECT_AS_ARRAY);		// -- {166:"83,10",162:"72,10"}	array( ProdValID => "value_id,attr_id", ...)
//			$item->attributes_IDs= array_values($item->places);			//	index  =>	attr_id
			
			$item->place_counts	= json_decode($item->place_counts, JSON_OBJECT_AS_ARRAY);	//	array( ProdValID =>	count, ...)
//			$item->place_counts = array_map(fn($item)=>(int)$item, $item->place_counts);
//toPrint($item->place_counts,'$item->place_counts',0,'message');
//return;
//			$item->place_names	= serialize($item->place_names);	//	array( ProdValID => attr_Name . ' - ' . place_name,... )
			
//			$view->order_items[$item->product_id]->attributes_IDs		=   ;
					
			/* Определение названий мероприятий  */
			if(! isset($view->order_items[$item->product_id])){
				$view->order_items[$item->product_id] = new \stdClass ();
				$view->order_items[$item->product_id]->product_name		= $item->product_name;
				$view->order_items[$item->product_id]->product_id		= $item->product_id;
				$view->order_items[$item->product_id]->currency_code	= $item->currency_code;
			}
			
			/* Определение повторно суммы и количества Купленных билетов */
			if(! isset($view->order_items[$item->product_id]->summ_tickets_active))
				$view->order_items[$item->product_id]->summ_tickets_active = 0;
			if(! isset($view->order_items[$item->product_id]->count_tickets_active))
				$view->order_items[$item->product_id]->count_tickets_active = 0;
			
			if($view->fieldDateStart <= $item->order_date && $item->order_date <= $view->fieldDateStop){
//toPrint($item->order_date,'$item->order_date 1',0,'pre');
				
				$summ_tickets_active = 0;
				foreach ($item->place_prices as $ProdValID => $cost){
					$summ_tickets_active += $cost * $item->place_counts[$ProdValID];
				}
				
				$view->order_items[$item->product_id]->summ_tickets_active	+= $summ_tickets_active;//array_sum($item->place_prices) ?: 0;
				$view->order_items[$item->product_id]->count_tickets_active	+= $item->count_places;
				foreach ($item->places as $ProdValID => $str_valID_attrID){ //$item->attributes_IDs as $index => $attr_id
					[$value_id, $attr_id] = str_getcsv($str_valID_attrID);
					$item->places[$ProdValID] = (object)['value_id'=>$value_id,'attr_id'=>$attr_id];
					
//					if(!isset($view->order_items[$item->product_id]->attr_tickets_active[$attr_id][$ProdValID]))
//						$view->order_items[$item->product_id]->attr_tickets_active[$attr_id][$ProdValID][$item->order_item_id] = 0;
//					else
					$view->order_items[$item->product_id]->attr_tickets_active[$attr_id][$ProdValID][$item->order_item_id] = ($item->place_prices[$ProdValID] ?? 0) * ($item->place_counts[$ProdValID] ?? 0);
					$view->order_items[$item->product_id]->attr_tickets_active_counts[$attr_id][$ProdValID][$item->order_item_id] = $item->place_counts[$ProdValID] ?? 0;
					$view->order_items[$item->product_id]->attr_tickets_active_prices[$attr_id][$ProdValID][$item->order_item_id] = $item->place_prices[$ProdValID] ?? 0;
					
//					if(!isset($view->order_items[$item->product_id]->attr_tickets_active[$attr_id][$ProdValID]))
//						$view->order_items[$item->product_id]->attr_tickets_active[$attr_id][$ProdValID] = 0;
//					else
//						$view->order_items[$item->product_id]->attr_tickets_active[$attr_id][$ProdValID] += 1;
					$view->order_items[$item->product_id]->attributes[$attr_id] = [];
					$view->rowAttributes[$attr_id] = $attr_id;
					$view->order_items[$item->product_id]->currency_code = $item->currency_code;
				}
//				toPrint($view->order_items[$item->product_id]->attr_tickets_active,'$view->order_items[$item->product_id]->attr_tickets_active',0,'pre');	
			}
			
//			if($view->fieldDateStart <= JDate::getInstance($item->order_date) &&  JDate::getInstance($item->order_date) <= $view->fieldDateStart){
//toPrint($item->order_date,'$item->order_date 2',0,'pre');	
//				$view->order_items[$item->product_id]->summ_tickets_active	+= array_sum($prices) ?: 0;
//				$view->order_items[$item->product_id]->count_tickets_active	+= $item->count_places;
//				foreach ($item->attributes_IDs as $index => $attr_id){
////					$view->order_items[$item->product_id]->attributes[$attr_id][$view->statusList[$item->order_status]][$index][$item->order_item_id] = $prices[$index] ?? 0;
////					$item->attr_tickets_active_count[$attr_id] = 
//					if(!isset($view->order_items[$item->product_id]->attr_tickets_active_summa[$attr_id][$index]))
//						$view->order_items[$item->product_id]->attr_tickets_active_summa[$attr_id][$index] = 0;
//					else
//						$view->order_items[$item->product_id]->attr_tickets_active_summa[$attr_id][$index] += $prices[$index] ?? 0;
//					
//					if(!isset($view->order_items[$item->product_id]->attr_tickets_active_count[$attr_id][$index]))
//						$view->order_items[$item->product_id]->attr_tickets_active_count[$attr_id][$index] = 0;
//					else
//						$view->order_items[$item->product_id]->attr_tickets_active_count[$attr_id][$index] += 1;
//				}
//				
////					$view->order_items[$item->product_id]->tickets_cost[$go_status_code][$go_index][$item->order_item_id]	= $prices[$go_index] ?? 0;
////					$view->order_items[$item->product_id]->attributes[$attr_id][$go_status_code][$go_index][$item->order_item_id] = $prices[$go_index] ?? 0;
//			}
			
			if(! isset($view->order_items[$item->product_id]->tickets_cost))
				$view->order_items[$item->product_id]->tickets_cost = [];
//			$view->order_items[$item->product_id]->summ_tickets	= [];
//			$view->order_items[$item->product_id]->count_tickets = [];
			
			/* Определение сумм и количества по атрибутам */
			// <editor-fold defaultstate="_collapsed" desc="Определение сумм и количества по атрибутам">
			
//			if (! isset($view->order_items[$item->product_id]->attributes_IDs))
//				$view->order_items[$item->product_id]->attributes_IDs = $item->attributes_IDs;
			if (! isset($view->order_items[$item->product_id]->attributes))
				$view->order_items[$item->product_id]->attributes = [];
			

			// </editor-fold>

			
			$item->place_go = trim($item->place_go);

//toPrint(($item->place_go),'$item->place_go',0,'pre',true);
//toPrint(str_getcsv($item->place_go),'$item->place_go',0,'pre',true);
			
			

			if(empty($item->place_go))
				continue;

			/*  */
			foreach (str_getcsv($item->place_go) as $place_go){
				if(empty($place_go))
					continue;
				
				$place_go	= explode(':', $place_go);
				$go_date	= end($place_go);	// DateTime
				$date		= JDate::getInstance($go_date);
				
				/* Если статус билета входит в диапазон, то ведём подсчёт суммы, количества билетов и определение колонок для статусов  */
				if($view->fieldDateStart <= $date && $date <= $view->fieldDateStop){
					
					if(empty($view->order_items[$item->product_id])){
						$view->order_items[$item->product_id] = new \stdClass();
					}

					$go_status_code	= $place_go[1];		// status Code
					$go_index	= (int)reset($place_go);	// Index
//if(empty($go_status_code))
//toPrint(($item->place_go),'$place_go '.$item->order_item_id ,0,'message',true);
					
					$view->columnStatus[$go_status_code] = \PlacebiletHelper::$statusList[$go_status_code] ?? null;
//					$view->columnSumm	+= $prices[$go_index] ?? 0;
//					$view->columnCount	+= 1;
					
					
//					if(! isset($view->order_items[$item->product_id]->summ_tickets[$go_status_code]))
//						$view->order_items[$item->product_id]->summ_tickets[$go_status_code] = 0;
//					if(! isset($view->order_items[$item->product_id]->count_tickets[$go_status_code]))
//						$view->order_items[$item->product_id]->count_tickets[$go_status_code] = 0;
						
					if(!isset($view->order_items[$item->product_id]->tickets_cost[$go_status_code][$go_index]))
						$view->order_items[$item->product_id]->tickets_cost[$go_status_code][$go_index][$item->order_item_id] = 0;
					
					$view->order_items[$item->product_id]->tickets_cost[$go_status_code][$go_index][$item->order_item_id]	= $prices[$go_index] ?? 0;
//					$view->order_items[$item->product_id]->summ_tickets[$go_status_code]	+= $prices[$go_index] ?? 0;
//					$view->order_items[$item->product_id]->count_tickets[$go_status_code]	+= 1;
					
					
					
//					$view->order_items[$item->product_id]->attributes_IDs[]  ;
//					$view->order_items[$item->product_id]->attributes[]  ;
					
					foreach ($item->places as $ProdValID => $valID_attrID){// $item->attributes_IDs as $index => $attr_id
						
						if(is_string($valID_attrID)){
							[$value_id, $attr_id] = str_getcsv($valID_attrID);
							$item->places[$ProdValID] = (object)['value_id'=>$value_id,'attr_id'=>$attr_id];
						}else{
							$value_id	= $valID_attrID->value_id;
							$attr_id	= $valID_attrID->attr_id;
						}

//if(empty($attr_id)){
//	toPrint($item->places,'$item->order_item_id '.$item->order_item_id.':',0,'message');
//}
//						if(! isset($view->order_items[$item->product_id]->attributes[$attr_id][$go_status_code])){
//							$view->order_items[$item->product_id]->attributes[$attr_id][$go_status_code] = (object)['summ_tickets'=>0,'count_tickets'=>0];
//						}
//						summ_tickets_active
//						count_tickets_active
						$view->order_items[$item->product_id]->attributes[$attr_id][$go_status_code][$go_index][$item->order_item_id] = $prices[$go_index] ?? 0;
//						$view->order_items[$item->product_id]->attributes[$attr_id][$go_status_code]->summ_tickets += $prices[$go_index] ?? 0;
//						$view->order_items[$item->product_id]->attributes[$attr_id][$go_status_code]->count_tickets += 1;
						$view->rowAttributes[$attr_id] = $attr_id;
					}
					
//					$view->order_items[$item->product_id]->attributes_IDs[]  ;
//					$view->order_items[$item->product_id]->attributes[]  ;
					
//	0 summ_tickets_R, 0 count_tickets_R, 0 summ_tickets_P, 0 count_tickets_P
				}
			}
		}
		
		
//toPrint(null,'',0,'',true);
//toPrint($view->rowAttributes,'$view->rowAttributes',0,'message',true);
		
		
		$query = "
 SELECT 
	CONCAT_WS( ' /'," . implode(',', \PlacebiletHelper::getLanguageList()) . ") attr_name,
	attr_id,
	attr_admin_type,
	cats,
	`group`,
	attr_type,
	independent
FROM #__jshopping_attr
WHERE attr_id IN (" . join(",", $view->rowAttributes) . ")
ORDER BY attr_ordering ; ";

		if($view->rowAttributes){
			$view->rowAttributes = $db->setQuery($query)->loadObjectList('attr_id');
		}
		
			
        $view->db = $db;
		
        $dispatcher = \JFactory::getApplication()->triggerEvent('onBeforeDisplayStatistics', array(&$view));
//toPrint(null,'',0,'',true);
//toPrint($view->rowAttributes,'$view->rowAttributes',0,'message',true);
		$view->display();									// Имя функции в View/Statistics/HtmlView.php

		
//toPrint(null,'',0,'',true);
////toPrint($where,'$where',0,'message',true);
//toPrint($query,'$query',0,'pre',true);
//return;
//toPrint(null,'',0,'',true);
//toPrint($where,'$where',0,'message',true);
//toPrint($query,'$query',0,'pre',true);
//toPrint($this->input->getArray(),'$this->input',0,'message',true);
//toPrint($view->order_items,'$view->order_items',0,'pre',true);
//        echo "<pre>ControllerEmptyDisplay: ";
//        var_dump($this->get('redirect'));
//        echo "</pre>"; 
    }
	
//	function apply($cachable = false, $urlparams = false){
//		
//	}
}
?>	