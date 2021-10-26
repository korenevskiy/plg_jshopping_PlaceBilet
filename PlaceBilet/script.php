<?php
 /** ----------------------------------------------------------------------
 * plg_PlaceBilet - Plugin Joomshopping Component for CMS Joomla
 * ------------------------------------------------------------------------
 * author    Sergei Borisovich Korenevskiy
 * @copyright (C) 2019 //explorer-office.ru. All Rights Reserved. 
 * @license GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 * @package plg_PlaceBilet
 * Websites: //explorer-office.ru/download/joomla/category/view/1
 * Technical Support:  Forum - //fb.com/groups/multimodulefb.com/groups/placebilet/
 * Technical Support:  Forum - //vk.com/placebilet
 * -------------------------------------------------------------------------
 **/ 
// Запрет прямого доступа.
defined('_JEXEC') or die; 
defined('DS') or define('DS', DIRECTORY_SEPARATOR);
//defined('DS') or define('DS', '\\');
/**
* Файл-скрипт для плагина PlaceBilet.
*/ 
class PlgjshoppingPlaceBiletInstallerScript{//PlgjshoppingPlaceBiletInstallerScript //PlgjshoppingPlaceBiletInstallerScript
//    function __construct($obj) {
//        
//        toPrint(array_keys($obj),'thisAdapter');
//    }
	 public function __construct(JAdapterInstance $adapter){
		 
			$lang = JFactory::getLanguage()->getTag(); 
			$lang = substr($lang,0,2);// reset(explode ('-', $lang));
			$this->isRU = in_array($lang, ['ru','uk','be','kz','by','ab','be','be']);  
	 }
    
	 private $isRU = false;
	 
	 private function existJShopping() {
		 
		$query = "SHOW TABLES   LIKE '#__jshopping_products';";
		$existJshopping = JFactory::getDbo()->setQuery($query)->loadObjectList('Field'); 
		
		if($existJshopping)
			return TRUE;
		
		
		$message = JText::_('JSHOP_PLACE_BILET_EXIST_JSHOPPING_INFO');
			
		if($message == 'JSHOP_PLACE_BILET_EXIST_JSHOPPING_INFO' && $this->isRU){
			$message = "<h1 style='color:red;'>Внимание! Вначале установите компонент JoomShopping! </h1><br><h2>Только потом устанавливайте ПЛАГИН</h2><br>"
				. "<h3><a href='https://korenevskiy.github.io/plg_jshopping_PlaceBilet/com_JoomShopping.zip' style='color:blue;text-decoration: underline;' target='_blank'> "
				. "Скачать компонент JoomShopping </a></h3>";
		}
		if($message == 'JSHOP_PLACE_BILET_EXIST_JSHOPPING_INFO' && ! $this->isRU){ 
			$message = "<h1 style='color:red;'>Attention! First install the JoomShopping component!</h1><br><h2>Only then install the PLUGIN</h2><br>"
				. "<h3><a href='https://korenevskiy.github.io/plg_jshopping_PlaceBilet/com_JoomShopping.zip' style='color:blue;text-decoration: underline;' target='_blank'> "
				. "Download the JoomShopping component </a></h3>";
		}
			
		JFactory::getApplication()->enqueueMessage($message);
		
		return FALSE;		
	 }


//    public static function toLog($obj)
//    public static function toLog($obj)
//    {
//        $print = print_r($obj,TRUE). '\n\n';
////        $s = DIRECTORY_SEPARATOR;
//        $s = '\\';
////        $s = DS;
////        $path = JFactory::getConfig()->get('log_path');
//        $path = "C:{$s}Downloads{$s}OpenServer{$s}OSPanel{$s}domains{$s}joomla2{$s}administrator{$s}logs{$s}";
//        $path = __DIR__;
//        $file='_log.txt';
//        file_put_contents ($path.$s.$file, "\n$print  ", FILE_APPEND);
        
    public function install(JAdapterInstance  $parent)
    { 
		if(! $this->existJShopping()){ 	
			return FALSE;
		}
        
		
		
		$queries = [
			'orders' => 'SHOW COLUMNS FROM #__jshopping_orders;',
			'order_item' => 'SHOW COLUMNS FROM #__jshopping_order_item;',
			'attr' => 'SHOW COLUMNS FROM #__jshopping_attr;',
			'products' => 'SHOW COLUMNS FROM #__jshopping_products;',
			'categories' => 'SHOW COLUMNS FROM #__jshopping_categories;',
			'products_attr2' => 'SHOW COLUMNS FROM #__jshopping_products_attr2;',
		];
		$all_columns = [];
		
		foreach($queries as $tbl => $query){
			$columns = JFactory::getDbo()->setQuery($query)->loadObjectList('Field');
			$all_columns[$tbl] = array_column($columns, 'Field');
		}
		
		
//		toPrint($all_columns,'$all_columns',0,'pre',true);
		
//file_put_contents(JPATH_ROOT. '/XXXzzz.txt', "\n\n");
//    }

////toLog($all_columns,'','/XXXzzzLog.txt');
//file_put_contents(JPATH_ROOT. '/XXXzzz.txt', print_r($all_columns,true). "\n\n",FILE_APPEND);
//

        
		$new_tbl_columns = [
			'orders' => [
				'bonus'			=>"ALTER TABLE #__jshopping_orders ADD bonus varchar(24) NOT NULL DEFAULT ''",
				'address'		=>"ALTER TABLE #__jshopping_orders ADD address varchar(24) NOT NULL DEFAULT ''",
				'FIO'			=>"ALTER TABLE #__jshopping_orders ADD FIO varchar(255) NOT NULL DEFAULT ''",
				'd_FIO'			=>"ALTER TABLE #__jshopping_orders ADD d_FIO varchar(255) NOT NULL DEFAULT ''; ",
				'comment'		=>"ALTER TABLE #__jshopping_orders ADD `comment` text NOT NULL DEFAULT ''; ",
				'd_comment'		=>"ALTER TABLE #__jshopping_orders ADD d_comment text NOT NULL DEFAULT ''; ",
				'housing'		=>"ALTER TABLE #__jshopping_orders ADD housing varchar(24) NOT NULL DEFAULT ''; ",
				'd_housing'		=>"ALTER TABLE #__jshopping_orders ADD d_housing varchar(24) NOT NULL DEFAULT ''; ",
				'porch'			=>"ALTER TABLE #__jshopping_orders ADD porch varchar(24) NOT NULL DEFAULT ''; ",
				'd_porch'		=>"ALTER TABLE #__jshopping_orders ADD d_porch varchar(24) NOT NULL DEFAULT ''; ",
				'level'			=>"ALTER TABLE #__jshopping_orders ADD level varchar(24) NOT NULL DEFAULT ''; ",
				'd_level'		=>"ALTER TABLE #__jshopping_orders ADD d_level varchar(24) NOT NULL DEFAULT ''; ",
				'intercom'		=>"ALTER TABLE #__jshopping_orders ADD intercom varchar(24) NOT NULL DEFAULT ''; ",
				'd_intercom'	=>"ALTER TABLE #__jshopping_orders ADD d_intercom varchar(24) NOT NULL DEFAULT ''; ",
				'shiping_date'	=>"ALTER TABLE #__jshopping_orders ADD shiping_date varchar(24) NOT NULL DEFAULT ''; ",
				'd_shiping_date'=>"ALTER TABLE #__jshopping_orders ADD d_shiping_date varchar(24) NOT NULL DEFAULT ''; ",
				'shiping_time'	=>"ALTER TABLE #__jshopping_orders ADD shiping_time varchar(24) NOT NULL DEFAULT ''; ",
				'd_shiping_time'=>"ALTER TABLE #__jshopping_orders ADD d_shiping_time varchar(24) NOT NULL DEFAULT ''; ",
				'metro'			=>"ALTER TABLE #__jshopping_orders ADD metro varchar(24) NOT NULL DEFAULT ''; ",
				'd_metro'		=>"ALTER TABLE #__jshopping_orders ADD d_metro varchar(24) NOT NULL DEFAULT ''; ",
				'transport_name'=>"ALTER TABLE #__jshopping_orders ADD transport_name varchar(24) NOT NULL DEFAULT ''; ",
				'd_transport_name'=>"ALTER TABLE #__jshopping_orders ADD d_transport_name varchar(24) NOT NULL DEFAULT ''; ",
				'transport_no'	=>"ALTER TABLE #__jshopping_orders ADD transport_no varchar(24) NOT NULL DEFAULT ''; ",
				'd_transport_no'=>"ALTER TABLE #__jshopping_orders ADD d_transport_no varchar(24) NOT NULL DEFAULT ''; ",
				'track_stop'	=>"ALTER TABLE #__jshopping_orders ADD track_stop varchar(24) NOT NULL DEFAULT ''; ",
				'd_track_stop'	=>"ALTER TABLE #__jshopping_orders ADD d_track_stop varchar(24) NOT NULL DEFAULT ''; ",
			],
			'order_item' => [
				'date_event'	=>"ALTER TABLE #__jshopping_order_item ADD `date_event` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP; ",
				'count_places'	=>"ALTER TABLE #__jshopping_order_item ADD `count_places` int(4) NOT NULL DEFAULT 0; ",
				'places'		=>"ALTER TABLE #__jshopping_order_item ADD `places` text NOT NULL DEFAULT ''; ",
				'place_prices'	=>"ALTER TABLE #__jshopping_order_item ADD `place_prices` text NOT NULL DEFAULT ''; ",
				'place_names'	=>"ALTER TABLE #__jshopping_order_item ADD `place_names` text NOT NULL DEFAULT ''; ",
			],
			'attr' => [
				'attr_admin_type'=>"ALTER TABLE #__jshopping_attr ADD attr_admin_type int(3) NOT NULL  DEFAULT 0; ",
				'StageCatId'	=>"ALTER TABLE #__jshopping_attr ADD StageCatId int(11) NOT NULL DEFAULT 0; ",
				'Row'			=>"ALTER TABLE #__jshopping_attr ADD `Row` varchar(24) NOT NULL DEFAULT ''; ",
				'SectorId'		=>"ALTER TABLE #__jshopping_attr ADD SectorId int(11) NOT NULL DEFAULT 0; ",
				'StageId'		=>"ALTER TABLE #__jshopping_attr ADD StageId int(11) NOT NULL DEFAULT 0; ",
			],
			'products' => [
				'date_event'	=>"ALTER TABLE #__jshopping_products ADD date_event datetime NOT NULL DEFAULT CURRENT_TIMESTAMP; ",
				'params'		=>"ALTER TABLE #__jshopping_products ADD params text NOT NULL DEFAULT ''; ",
				'RepertoireId'	=>"ALTER TABLE #__jshopping_products ADD RepertoireId int(11) NOT NULL DEFAULT 0; ",
				'StageId'		=>"ALTER TABLE #__jshopping_products ADD StageId int(11) NOT NULL DEFAULT 0; ",
			],
			'categories' => [
				'PlaceId'		=>"ALTER TABLE #__jshopping_categories ADD PlaceId int(11) NOT NULL DEFAULT 0; ",
				'StageId'		=>"ALTER TABLE #__jshopping_categories ADD StageId int(11) NOT NULL DEFAULT 0; ",
				'RepertoireId'	=>"ALTER TABLE #__jshopping_categories ADD RepertoireId int(11) NOT NULL DEFAULT 0; ",
			],
			'products_attr2' => [
				'OfferId'		=>"ALTER TABLE #__jshopping_products_attr2 ADD OfferId int(11) NOT NULL DEFAULT 0; ",
			],
		];
		
		$queries = [];
		
		foreach($new_tbl_columns as $tbl => $columns){
			foreach ($columns as $column => $query){
				if( isset($all_columns[$tbl]) && is_array($all_columns[$tbl]) && ! in_array($column, $all_columns[$tbl]) ){
					$queries[] = "$query; ";
				}
			}
		}
		
//file_put_contents(JPATH_ROOT. '/XXXzzz.txt', print_r($queries, true) . "\n\n", FILE_APPEND);
		
		foreach ($queries as $query){
			JFactory::getDbo()->setQuery($query)->loadObjectList('Field');
		}
        
//static::toLog('ERROR ????????????????????????????????????? -- 0','','',TRUE);
//        toPrint(array_keys($parent),'thisAdapter');
        
        static::moveControllers();
//return;
//        JApplicationCms::getInstance()->enqueueMessage('Installed TheatrBilet plugin for JoomShopping <br> Welcome in Theatr Bilet!' , 'info');

//static::toLog('ERROR ????????????????????????????????????? -- 1','','',TRUE);
        
//            JApplicationCms::getInstance()->enqueueMessage('ERROR ????????????????????????????????????? -- 1' , 'info');
//        //return;
//        $file = 'install.sql';
//
//JApplicationCms::getInstance()->enqueueMessage('ERROR ????????????????????????????????????? -- 11' , 'info');return;
//        static::executeScript($file);
        
//        $parent->getParent()->setRedirectURL('index.php?option=com_plugins&view=plugins&filter[folder]=jshopping'); 
        $parent->getParent()->setRedirectURL('index.php?option=com_jshopping&controller=attributes');
         	
		return TRUE;
    }
    
//    	/**
//	 * method to uninstall  
//	 *
//	 * @return void
//	 */
//    function uninstall($parent) 
//	{
////		echo '<p>' . JText::_('') . '</p>';
//	}
 
	/**
	 * method to update  
	 *
	 * @return void
	 */
    public function update(JAdapterInstance $parent) 
	{
//		$message = JText::_('JSHOP_PLACE_BILET_EXIST_JSHOPPING_INFO');
//		JFactory::getApplication()->enqueueMessage($message);
                    $query = "
                UPDATE #__update_sites us, #__extensions e,#__update_sites_extensions se 
                SET us.location = REPLACE(us.location, 'PlaceBilet_update.', 'PlaceBilet_update_prox.') 
                WHERE e.element = 'PlaceBilet' AND se.extension_id = e.extension_id AND se.update_site_id = us.update_site_id; ";
            JFactory::getDbo()->setQuery($query)->execute();
			
//		JFactory::getApplication()->enqueueMessage('Ok 0');
		return TRUE;
		
		if(! $this->existJShopping()){ 	
			return FALSE;
		}
		
//		JFactory::getApplication()->enqueueMessage('Ok 1');
		
		$this->install($parent);
//        $queries = [
//			'orders' => 'SHOW COLUMNS FROM #__jshopping_orders;',
//			'order_item' => 'SHOW COLUMNS FROM #__jshopping_order_item;',
//			'attr' => 'SHOW COLUMNS FROM #__jshopping_attr;',
//			'products' => 'SHOW COLUMNS FROM #__jshopping_products;',
//			'categories' => 'SHOW COLUMNS FROM #__jshopping_categories;',
//			'products_attr2' => 'SHOW COLUMNS FROM #__jshopping_products_attr2;',
//		];
//		$all_columns = [];
//		
//		foreach($queries as $tbl => $query){
//			$all_columns[$tbl] = JFactory::getDbo()->setQuery($query)->loadObjectList('Field');
//		}
//		
////		toPrint($all_columns,'$all_columns',0,'pre',true);
//		
////toLog('','','/XXXzzzLog.txt');
//file_put_contents(JPATH_ROOT. '/XXXzzz.txt', "\n\n");
//
////toLog($all_columns,'','/XXXzzzLog.txt');
//file_put_contents(JPATH_ROOT. '/XXXzzz.txt', print_r($all_columns,true). "\n\n",true);
//		
		
//		JFactory::getApplication()->enqueueMessage('Ok 2');
		
//static::toLog('ERROR ????????????????????????????????????? -- XXXXXXXXXXXXXXXXXXXX','','',TRUE);
            static::moveControllers();
//            $file = 'update.sql';
//            static::executeScript($file); 
//		echo '<p>' . JText::_('') . '</p>';

//		JFactory::getApplication()->enqueueMessage('Ok 3');
            $query = "
                UPDATE #__update_sites us, #__extensions e,#__update_sites_extensions se 
                SET us.location = REPLACE(us.location, 'PlaceBilet_update.', 'PlaceBilet_update_prox.') 
                WHERE e.element = 'PlaceBilet' AND se.extension_id = e.extension_id AND se.update_site_id = us.update_site_id; ";
            JFactory::getDbo()->setQuery($query)->execute();
 
//		JFactory::getApplication()->enqueueMessage('Ok 4');
            return TRUE;
	}
 
//	/**
//	 * method to run before an install/update/uninstall method
//	 *
//	 * @return void
//	 */
//    function preflight($type, $parent) 
//	{
//		echo '<p>' . JText::_('') . '</p>';
//	}
// 
//	/**
//	 * method to run after an install/update/uninstall method
//	 *
//	 * @return void
//	 */
//    function postflight($type, $parent) 
//	{
//		echo '<p>' . JText::_('') . '</p>';
//	}
//    
//    static function executeScript($file){
//        $file = __DIR__ . DS . $file;
//        
//        if(!file_exists($file)){
//static::toLog ('ERROR ????????????????????????????????????? -- 2');
//            return FALSE;
//        }
//static::toLog('ERROR ????????????????????????????????????? -- 33 <br>'.$file , 'info');return;
//        
//        $script = file_get_contents($file);
//        $scripts = explode(';', $script);
//static::toLog ('ERROR ????????????????????????????????????? -- 4 <br>'.print_r($scripts,true));        
//        
////        foreach ($scripts  as $query)
////            static::executeQuery($query);
//        
//    }
//    static function executeQuery($query){
//        try {
//static::toLog('ERROR ????????????????????????????????????? -- 4 <br>'.$query , 'info');
//            //JFactory::getDBO()->setQuery($query)->query(); 
//        } catch (Exception $exc) {
//            echo $exc->getTraceAsString().'<br>'.$query;
//        }
//
//    }
	public function uninstall(JAdapterInstance $adapter){
		return TRUE;
	}
    
    static function moveControllers(){
        $s = DIRECTORY_SEPARATOR;
        
        $pathS = __DIR__."{$s}controllers{$s}empty.php";
        $pathA = __DIR__."{$s}controllersA{$s}empty.php";
        
        $pathSite  = JPATH_SITE.         "{$s}components{$s}com_jshopping{$s}controllers{$s}empty.php";
        $pathAdmin = JPATH_ADMINISTRATOR."{$s}components{$s}com_jshopping{$s}controllers{$s}empty.php";
        
//        if(!file_exists($pathS))toPrint($pathS,'$pathS');
//        if(!file_exists($pathA))toPrint($pathA,'$pathA');
        
        $answS = JFile::move($pathS, $pathSite);
        $answA = JFile::move($pathA, $pathAdmin);
        
//        if(!$answS)toPrint($pathSite,'$pathSite');
//        if(!$answA)toPrint($pathAdmin,'$pathAdmin');
    }
}
