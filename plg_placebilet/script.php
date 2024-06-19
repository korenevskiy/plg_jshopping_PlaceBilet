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

use Joomla\CMS\Factory as JFactory;
use Joomla\CMS\Filesystem\File as JFile;
use Joomla\CMS\Installer\InstallerAdapter;
use Joomla\CMS\Version as JVersion;
use Joomla\CMS\Language\Text as JText;

$file_func = JPATH_ROOT . '/functions.php';
if (file_exists($file_func))
	require_once $file_func;

//JLoader::registerAlias('JAdapterInstance', '\\Joomla\\CMS\\Adapter\\AdapterInstance', '5.0');
//echo "<pre>{JVersion::MAJOR_VERSION}</pre>";
//toPrint(JVersion::MAJOR_VERSION,'Install $this',0,'message', true);
//JFactory::getApplication()->enqueueMessage(JVersion::MAJOR_VERSION); //->dump()

if (JVersion::MAJOR_VERSION == 4) {
//	class_alias( 'JAdapterInstance','\Joomla\CMS\Installer\InstallerAdapter');
	JLoader::registerAlias('JAdapterInstance', '\\Joomla\\CMS\\Installer\\InstallerAdapter', '5.0');
}
if (JVersion::MAJOR_VERSION == 3) {
//	JLoader::register('ContentHelperRoute', JPATH_ROOT . '/components/com_content/helpers/route.php');
//	JAdapterInstance

	class_alias('InstallerAdapter', '\Joomla\CMS\Installer\InstallerAdapter');
//	JLoader::registerAlias('InstallerAdapter',                  '\\Joomla\\CMS\\Adapter\\AdapterInstance', '5.0');
//  JLoader::registerAlias('JAdapterInstance',                  '\\Joomla\\CMS\\Adapter\\AdapterInstance', '5.0');
	JLoader::registerAlias('InstallerAdapter', '\\Joomla\\CMS\\Installer\\InstallerAdapter', '5.0');
	JLoader::registerAlias('JAdapterInstance', '\\Joomla\\CMS\\Adapter\\AdapterInstance', '5.0');
}

//        $this->isJ4 = JVersion::MAJOR_VERSION > 3; 
//defined('DS') or define('DS', '\\');
/**
 * Файл-скрипт для плагина PlaceBilet.
 */
class plgjshoppingPlaceBiletInstallerScript {//PlgjshoppingPlaceBiletInstallerScript //PlgjshoppingPlaceBiletInstallerScript //PlgjshoppingPlaceBiletInstallerScript
//    com_jshoppingInstallerScript
//    plg_jshoppinglaceBiletInstallerScript
//    plg_jshopping_laceBiletInstallerScript
//    function __construct($obj) {
//        
//        toPrint(array_keys($obj),'thisAdapter');
//    }

	private $InstallerAdapter = null;

	public function __construct($adapter = null, $parent = null) {// 3 JAdapterInstance  4 Joomla\CMS\Installer\InstallerAdapter 
//toPrint($parent,'Install $parent');
//JFactory::getApplication()->enqueueMessage(JVersion::MAJOR_VERSION.' ConstructorInstaller');
		$this->InstallerAdapter = $adapter;
		$lang = JFactory::getLanguage()->getTag();
		$lang = substr($lang, 0, 2); // reset(explode ('-', $lang));
		$this->isRU = in_array($lang, ['ru', 'uk', 'be', 'kz', 'by', 'ab', 'be', 'be']);
	}

	private $isRU = false;

	private function existJShopping() {
		$prefix = JFactory::getDbo()->getPrefix();

		$query = "SHOW TABLES   LIKE '{$prefix}jshopping_products'; ";

		$existJshopping = JFactory::getDbo()->setQuery($query)->loadResult(); // loadObjectList('Field'); 
//Factory::getDbo()->replacePrefix($sql);
//Factory::getDbo()->getPrefix(); 
//		JFactory::getApplication()->enqueueMessage("<pre>".$query."</pre>"); //->dump()
//		JFactory::getApplication()->enqueueMessage("<pre>".print_r($existJshopping,true)."</pre>");
//		JFactory::getApplication()->enqueueMessage("<pre>".($existJshopping?'Yes':'No')."</pre>");

		if ($existJshopping)
			return TRUE;


// JFactory::getApplication()->enqueueMessage("<pre>$query ". print_r($existJshopping, true)."</pre> ". gettype($existJshopping).' '. strlen($existJshopping).' PreFlightInstaller');		


		$message = JText::_('JSHOP_PLACE_BILET_EXIST_JSHOPPING_INFO');

		if ($message == 'JSHOP_PLACE_BILET_EXIST_JSHOPPING_INFO' && $this->isRU) {
			$message = "<h1 style='color:red;'>Внимание! Вначале установите компонент JoomShopping! </h1><br><h2>Только потом устанавливайте ПЛАГИН</h2><br>"
					. "<h3><a href='https://korenevskiy.github.io/plg_jshopping_PlaceBilet/com_JoomShopping.zip' style='color:blue;text-decoration: underline;' target='_blank'> "
					. "Скачать компонент JoomShopping </a></h3>";
		}
		if ($message == 'JSHOP_PLACE_BILET_EXIST_JSHOPPING_INFO' && !$this->isRU) {
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

	/**
	 * Вызов installation  - 4,3
	 *
	 * @param   InstallerAdapter  $adapter  The object responsible for running this script
	 *
	 * @return  boolean  True on success
	 */
	public function install($parent = null, $redirect = true) {//JAdapterInstance - 3, InstallerAdapter  - 4
//		JFactory::getDbo()->setQuery('SET GLOBAL innodb_strict_mode=OFF;')->execute();
//$params = JFactory::getDbo()->setQuery('
//SELECT extension_id,element, params 
//FROM #__extensions
//WHERE element IN ( "PlaceBilet", "placebilet");')->loadObject();
//JFactory::getApplication()->enqueueMessage(   '<pre>' . print_r($params, true) . '</pre>');
//JFactory::getApplication()->enqueueMessage(JVersion::MAJOR_VERSION.' InstallInstaller');
//toPrint($parent,'Install $parent');
		if (!$this->existJShopping()) {
			return FALSE;
		}
		
		$query = "
				UPDATE #__extensions e SET e.params= REPLACE(e.params, '3772199444', '4245918837') 
				WHERE e.element = 'PlaceBilet' or e.element = 'placebilet'; ";
		JFactory::getDbo()->setQuery($query)->execute();
		
		$prefix = JFactory::getDbo()->getPrefix();
		
		

		$all_columns = [];

		foreach ($this->queries_tbl_columns as $tbl => $query) {
//			if(JFactory::getConfig()->get('debug') || JFactory::getConfig()->get('error_reporting') == 'maximum')
//				JFactory::getApplication()->enqueueMessage(str_replace('#__', $prefix, $query));
//			$columns = JFactory::getDbo()->setQuery($query)->loadObjectList('Field');
//			$all_columns[$tbl] = array_column($columns, 'Field');
			$all_columns[$tbl] = JFactory::getDbo()->setQuery($query)->loadAssocList('Field', 'Type');
		}
		
		$srcNoImage = __DIR__.'/media/noimage.png';
		
		$catNoImage = JPATH_ROOT . '/components/com_jshopping/files/img_categories/noimage.png';
		$prodNoImage = JPATH_ROOT . '/components/com_jshopping/files/img_products/noimage.png';
		
		\Joomla\Filesystem\File::copy($srcNoImage, $catNoImage);
		\Joomla\Filesystem\File::copy($srcNoImage, $prodNoImage);
		
		
//JFactory::getApplication()->enqueueMessage('Show Columns: '. count($all_columns) . '<pre>' . print_r($all_columns, true) . '</pre>');
//JFactory::getApplication()->enqueueMessage( count($debugs_columns) . '<pre>' . print_r($debugs_columns, true) . '</pre>');
//$debugs_columns = JFactory::getDbo()->setQuery('SHOW COLUMNS FROM #__jshopping_orders;')->loadAssocList('Field', 'Type');
//JFactory::getApplication()->enqueueMessage( count($debugs_columns) . '<pre>' . print_r($debugs_columns, true) . '</pre>');
//		return;
//JFactory::getApplication()->enqueueMessage(JVersion::MAJOR_VERSION );
//		toPrint($all_columns,'$all_columns',0,'pre',true);
//file_put_contents(JPATH_ROOT. '/XXXzzz.txt', "\n\n");
//    }
////toLog($all_columns,'','/XXXzzzLog.txt');
//file_put_contents(JPATH_ROOT. '/XXXzzz.txt', print_r($all_columns,true). "\n\n",FILE_APPEND);
//



		$queries = [];

		foreach ($this->new_tbl_columns as $tbl => $columns) {
			if (empty($all_columns[$tbl])) {
				JFactory::getApplication()->enqueueMessage('Not Intalled JoomShopping component. Please install the <b>JoomShopping</b> component first. <br>
					Not Exist table: ' . str_replace('#__', $prefix, $tbl), Joomla\CMS\Application\CMSApplicationInterface::MSG_WARNING);
				continue;
			}

			$cols = [];

			foreach ($columns as $column => $query) {
				// Модифицирование существующих колонок
				if (isset($all_columns[$tbl][$column]) && isset($this->queries_tbl_mods[$tbl][$column])) {
//JFactory::getApplication()->enqueueMessage("Exist: ".str_replace('#__', $prefix, $query));
					$queries[] = $this->queries_tbl_mods[$tbl][$column];
					$cols[] = $column;
				}

				// Добавление не существующих колонок
				if (empty($all_columns[$tbl][$column])) {
					$queries[] = $query;
					$cols[] = $column;
//JFactory::getApplication()->enqueueMessage("Add!: ".str_replace('#__', $prefix, $query));
//JFactory::getApplication()->enqueueMessage("--------- [$tbl][$column]". '<pre>' . (isset($all_columns[$tbl][$column])?print_r($all_columns[$tbl][$column], true):'-/NoExist/-.') . '</pre>');
				}
			}

			if ($cols && (JFactory::getConfig()->get('debug')))// || JFactory::getConfig()->get('error_reporting') == 'maximum')
				JFactory::getApplication()->enqueueMessage('in table ' . str_replace('#__', $prefix, $tbl) . ' Add columns: ' . implode(',', $cols));
		}

//file_put_contents(JPATH_ROOT. '/XXXzzz.txt', print_r($queries, true) . "\n\n", FILE_APPEND);
//JFactory::getApplication()->enqueueMessage(str_replace('#__', $prefix, implode('<br>',$queries)));
//return;
		foreach ($queries as $query) {
//JFactory::getApplication()->enqueueMessage('Query:'.str_replace('#__', $prefix, $query));
			JFactory::getDbo()->setQuery($query)->execute();
		}



		JFactory::getDbo()->setQuery("UPDATE #__jshopping_attr SET attr_admin_type = 4 WHERE attr_type = 0;")->execute();

//return;
//static::toLog('ERROR ????????????????????????????????????? -- 0','','',TRUE);
//        toPrint(array_keys($parent),'thisAdapter');

		static::moveControllers();

		if ($redirect == false)
			return true;
//        JApplicationCms::getInstance()->enqueueMessage('Installed TheatrBilet plugin for JoomShopping <br> Welcome in Theatr Bilet!' , 'info');
//static::toLog('ERROR ????????????????????????????????????? -- 1','','',TRUE);
//            JApplicationCms::getInstance()->enqueueMessage('ERROR ????????????????????????????????????? -- 1' , 'info');
//        //return;
//        $file = 'install.sql';
//
//JApplicationCms::getInstance()->enqueueMessage('ERROR ????????????????????????????????????? -- 11' , 'info');return;
//        static::executeScript($file);
//        $parent->getParent()->setRedirectURL('index.php?option=com_plugins&view=plugins&filter[folder]=jshopping'); 
		if (JVersion::MAJOR_VERSION == 3) {
			$parent->getParent()->setRedirectURL('index.php?option=com_jshopping&controller=attributes');
		} else {
			$this->InstallerAdapter->getParent()->setRedirectURL('index.php?option=com_jshopping&controller=attributes');
		}

		header('Content-Type:  "text/html; charset=utf-8"');

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
	 * Called on update
	 *
	 * @param   InstallerAdapter  $adapter  The object responsible for running this script
	 *
	 * @return  boolean  True on success
	 */
	public function update($parent = null) { //JAdapterInstance  - 3, InstallerAdapter  - 4
//JFactory::getApplication()->enqueueMessage(JVersion::MAJOR_VERSION.' UpdateInstaller');
//		$message = JText::_('JSHOP_PLACE_BILET_EXIST_JSHOPPING_INFO');
//		JFactory::getApplication()->enqueueMessage($message);
		$prefix = JFactory::getDbo()->getPrefix();
//        $query = "
//                UPDATE #__update_sites us, #__extensions e,#__update_sites_extensions se 
//                SET us.location = REPLACE(us.location, 'PlaceBilet_update.', 'PlaceBilet_update_prox.') 
//                WHERE e.element = 'PlaceBilet' AND se.extension_id = e.extension_id AND se.update_site_id = us.update_site_id; ";
//        JFactory::getDbo()->setQuery($query)->execute();
//		JFactory::getApplication()->enqueueMessage('Ok 0');


		if (!$this->existJShopping()) {
			return FALSE;
		}

		$this->install($parent, false);
//		return TRUE;


		static::moveControllers();

		return TRUE;
//$debugs_columns = JFactory::getDbo()->setQuery('SHOW COLUMNS FROM #__jshopping_orders;')->loadAssocList('Field', 'Type');
//JFactory::getApplication()->enqueueMessage( count($debugs_columns) . '<pre>' . print_r($debugs_columns, true) . '</pre>');
// <editor-fold defaultstate="expanded" desc="Модификация типов колонок">
		$all_columns = [];
		//       $this->queries_tbl_columns - Show Columns
		foreach ($this->queries_tbl_columns as $tbl => $query) {
//			if(JFactory::getConfig()->get('debug') || JFactory::getConfig()->get('error_reporting') == 'maximum')
//				JFactory::getApplication()->enqueueMessage(str_replace('#__', $prefix, $query));
			$columns = JFactory::getDbo()->setQuery($query)->loadObjectList('Field');
			$all_columns[$tbl] = array_column($columns, 'Field');
		}
//JFactory::getApplication()->enqueueMessage( count($all_columns) . '<pre>' . print_r($all_columns, true) . '</pre>');

		/* Список не существующих полей */
		$cols = [];
		foreach ($this->new_tbl_columns as $tbl => $columns) {
			if (empty($all_columns[$tbl])) {
				JFactory::getApplication()->enqueueMessage('Not Intalled JoomShopping component. Please install the <b>JoomShopping</b> component first. <br>
					Not Exist table: ' . str_replace('#__', $prefix, $tbl), Joomla\CMS\Application\CMSApplicationInterface::MSG_WARNING);
				continue;
			}
			$cols[$tbl] = [];
			foreach ($columns as $column => $_) {
				// Поиск не существующих полей
				if (empty(in_array($column, $all_columns[$tbl])))
					$cols[$tbl][$column] = $column;
				// Модификация типов полей
				if (isset($this->queries_tbl_mods[$tbl][$column]) && (JFactory::getConfig()->get('debug') || JFactory::getConfig()->get('error_reporting') == 'maximum'))
					JFactory::getDbo()->setQuery($this->queries_tbl_mods[$tbl][$column])->execute();
			}

			if ($cols[$tbl])//)
				JFactory::getApplication()->enqueueMessage('in table ' . str_replace('#__', $prefix, $tbl) . ' Not Create columns: ' . implode(',', $cols[$tbl]), Joomla\CMS\Application\CMSApplicationInterface::MSG_WARNING);
		}
// </editor-fold>
//		JFactory::getApplication()->enqueueMessage('Ok 1');
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
//            $file = 'update.sql';
//            static::executeScript($file); 
//		echo '<p>' . JText::_('') . '</p>';
//		JFactory::getApplication()->enqueueMessage('Ok 3');
//            $query = "
//                UPDATE #__update_sites us, #__extensions e,#__update_sites_extensions se 
//                SET us.location = REPLACE(us.location, 'PlaceBilet_update.', 'PlaceBilet_update_prox.') 
//                WHERE e.element = 'PlaceBilet' AND se.extension_id = e.extension_id AND se.update_site_id = us.update_site_id; ";
//            JFactory::getDbo()->setQuery($query)->execute();
//		JFactory::getApplication()->enqueueMessage('Ok 4');
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
//            //JFactory::getApplication()->getDBO()->setQuery($query)->execute(); 
//        } catch (Exception $exc) {
//            echo $exc->getTraceAsString().'<br>'.$query;
//        }
//
//    }


	static function moveControllers() {
		$s = DIRECTORY_SEPARATOR;

		$pathS = __DIR__ . "{$s}controllers{$s}EmptyController.php";
		$pathA = __DIR__ . "{$s}controllersA{$s}EmptyController.php";

		$pathSite = JPATH_SITE . "{$s}components{$s}com_jshopping{$s}Controller{$s}EmptyController.php";
		$pathAdmin = JPATH_ADMINISTRATOR . "{$s}components{$s}com_jshopping{$s}Controller{$s}EmptyController.php";

		if (JVersion::MAJOR_VERSION == 3) {
			$pathS = __DIR__ . "{$s}controllers{$s}empty.php";
			$pathA = __DIR__ . "{$s}controllersA{$s}empty.php";

			$pathSite = JPATH_SITE . "{$s}components{$s}com_jshopping{$s}controllers{$s}empty.php";
			$pathAdmin = JPATH_ADMINISTRATOR . "{$s}components{$s}com_jshopping{$s}controllers{$s}empty.php";
		}

//        if(!file_exists($pathS))toPrint($pathS,'$pathS');
//        if(!file_exists($pathA))toPrint($pathA,'$pathA');

		$answS = JFile::move($pathS, $pathSite);
		$answA = JFile::move($pathA, $pathAdmin);

//        if(!$answS)toPrint($pathSite,'$pathSite');
//        if(!$answA)toPrint($pathAdmin,'$pathAdmin');
	}

	/**
	 * Вызывается после любого типа действия 4,3
	 *
	 * @param   string  $route  Which action is happening (install|uninstall|discover_install|update)
	 * @param   InstallerAdapter  $adapter  The object responsible for running this script
	 *
	 * @return  boolean  True on success
	 */
	public function postflight($type, $parent) {

//		JFactory::getDbo()->setQuery('SET GLOBAL innodb_strict_mode=ON;')->execute();
//JFactory::getApplication()->enqueueMessage(JVersion::MAJOR_VERSION.' PostFlightInstaller');
		$type; // update, install
//		$parent->get('manifest')->version;
//		$prefix = JFactory::getDbo()->getPrefix();

		$query = "UPDATE `#__extensions` SET enabled = 1 WHERE element IN ('PlaceBilet','placebilet') AND folder = 'jshopping'; ";

		if ($type == 'install')
			JFactory::getDbo()->setQuery($query)->execute(); // loadResult();// loadObjectList('Field');
//		JFactory::getApplication()->enqueueMessage("<pre>".print_r($type,true)."</pre>"); //->dump()
		JFactory::getApplication()->enqueueMessage(JText::_('JSHOP_PLACE_BILET_DESC')); //->dump()
		JFactory::getApplication()->enqueueMessage(JText::_('JSHOP_PLACE_BILET_INSTRUCTION')); //->dump()
		
		static::languageMinificationRaw();

		return true;
	}

	function onLibraries() {
		
	}

	/* 	-------------------------------------- Joomla 4 -------------------------------- */

	/**
	 * Called before any type of action
	 *
	 * @param   string  $route  Which action is happening (install|uninstall|discover_install|update)
	 * @param   InstallerAdapter  $adapter  The object responsible for running this script
	 *
	 * @return  boolean  True on success
	 */
	public function preflight($route, $adapter) {   //JAdapterInstance - 3, InstallerAdapter  - 4
//JFactory::getApplication()->enqueueMessage(JVersion::MAJOR_VERSION.' PreFlightInstaller');
		return true;
	}

	/**
	 * Вызов on uninstallation
	 *
	 * @param   InstallerAdapter  $adapter  The object responsible for running this script
	 */
	public function uninstall($adapter = null) { //JAdapterInstance - 3, InstallerAdapter  - 4
		$prefix = JFactory::getDbo()->getPrefix();
		$all_columns = [];

		foreach ($this->queries_tbl_columns as $tbl => $query) {
//JFactory::getApplication()->enqueueMessage(str_replace('#__', $prefix, $query));
			$columns = JFactory::getDbo()->setQuery(str_replace('#__', $prefix, $query))->loadObjectList('Field');
			$all_columns[$tbl] = array_column($columns, 'Field');
		}




		$queries = [];

		foreach ($this->new_tbl_columns as $tbl => $columns) {

			$cols = [];

			foreach ($columns as $column => $query) {
				if (isset($all_columns[$tbl]) && is_array($all_columns[$tbl]) && in_array($column, $all_columns[$tbl])) {
					$queries[] = "ALTER TABLE #__jshopping_$tbl  DROP COLUMN $column ; ";
					$cols[] = $column;
				}
			}

			if ($cols && (JFactory::getConfig()->get('debug')))// || JFactory::getConfig()->get('error_reporting') == 'maximum'
				JFactory::getApplication()->enqueueMessage('in table ' . str_replace('#__', $prefix, $tbl) . ' Delete columns: ' . implode(',', $cols));
		}

//file_put_contents(JPATH_ROOT. '/XXXzzz.txt', print_r($queries, true) . "\n\n", FILE_APPEND);

		foreach ($queries as $query) {
//JFactory::getApplication()->enqueueMessage(str_replace('#__', $prefix, $query));
			JFactory::getDbo()->setQuery(str_replace('#__', $prefix, $query))->execute();
		}

		return TRUE;
	}
	
	
	public static function languageMinificationRaw(){
		
		
		$lang = JFactory::getApplication()->getLanguage();
		
		$dir = getcwd();
		
		$dir = __DIR__;
		
		while(!file_exists($dir . '/language')){
			$dir = dirname($dir);
		}

		$dir .= '/language';
		
		$files = Joomla\Filesystem\Folder::files($dir, "raw.ini", true, true);
		
		foreach ($files as $file){
			$text = file_get_contents($file);
			$text = str_replace("\n[", "[{<!>}][", $text);
			$text = str_replace("]\n", "][{<!>}]", $text);
			$text = str_replace("\";\n", "\";[{<!>}]", $text);
			$text = str_replace("\"\n", "\"[{<!>}]", $text);
			$text = str_replace("\n", '', $text);
			$text = str_replace('[{<!>}]', PHP_EOL, $text);
			$file = str_replace(".raw.ini", '.ini', $file);
			$f = file_put_contents($file, $text);
		}
	}

	//ALTER TABLE `#__jshopping_users` ADD `FIO` TINYTEXT NULL AFTER `txt`; 
	private $new_tbl_columns = [
		'users' => [
			'FIO' => 'ALTER TABLE #__jshopping_users ADD FIO TINYTEXT NULL  ; ',
			'd_FIO' => 'ALTER TABLE #__jshopping_users ADD d_FIO TINYTEXT NULL  ; ',
			'comment' => 'ALTER TABLE #__jshopping_users ADD `comment` TINYTEXT NULL  ; ',
			'd_comment' => 'ALTER TABLE #__jshopping_users ADD `d_comment` TINYTEXT NULL  ; ',
			'bonus' => 'ALTER TABLE #__jshopping_users ADD bonus TINYTEXT NULL  ;  ',
			'address' => 'ALTER TABLE #__jshopping_users ADD address TINYTEXT NULL  ;  ',
			'd_address' => 'ALTER TABLE #__jshopping_users ADD d_address TINYTEXT NULL  ;  ',
			'shiping_date' => 'ALTER TABLE #__jshopping_users ADD shiping_date TINYTEXT NULL  ;  ',
			'd_shiping_date' => 'ALTER TABLE #__jshopping_users ADD d_shiping_date TINYTEXT NULL  ;  ',
			'shiping_time' => 'ALTER TABLE #__jshopping_users ADD shiping_time TINYTEXT NULL  ;  ',
			'd_shiping_time' => 'ALTER TABLE #__jshopping_users ADD d_shiping_time TINYTEXT NULL  ;  ',
			'housing' => 'ALTER TABLE #__jshopping_users ADD housing TINYTEXT NULL  ;  ',
			'd_housing' => 'ALTER TABLE #__jshopping_users ADD d_housing TINYTEXT NULL  ;  ',
			'porch' => 'ALTER TABLE #__jshopping_users ADD porch TINYTEXT NULL  ;  ',
			'd_porch' => 'ALTER TABLE #__jshopping_users ADD d_porch TINYTEXT NULL  ;  ',
			'level' => 'ALTER TABLE #__jshopping_users ADD level TINYTEXT NULL  ;  ',
			'd_level' => 'ALTER TABLE #__jshopping_users ADD d_level TINYTEXT NULL  ;  ',
			'intercom' => 'ALTER TABLE #__jshopping_users ADD intercom TINYTEXT NULL  ;  ',
			'd_intercom' => 'ALTER TABLE #__jshopping_users ADD d_intercom TINYTEXT NULL  ;  ',
			'metro' => 'ALTER TABLE #__jshopping_users ADD metro TINYTEXT NULL  ;  ',
			'd_metro' => 'ALTER TABLE #__jshopping_users ADD d_metro TINYTEXT NULL  ;  ',
			'transport_name' => 'ALTER TABLE #__jshopping_users ADD transport_name TINYTEXT NULL  ;  ',
			'd_transport_name' => 'ALTER TABLE #__jshopping_users ADD d_transport_name TINYTEXT NULL  ;  ',
			'transport_no' => 'ALTER TABLE #__jshopping_users ADD transport_no TINYTEXT NULL  ;  ',
			'd_transport_no' => 'ALTER TABLE #__jshopping_users ADD d_transport_no TINYTEXT NULL  ;  ',
			'track_stop' => 'ALTER TABLE #__jshopping_users ADD track_stop TINYTEXT NULL  ;  ',
			'd_track_stop' => 'ALTER TABLE #__jshopping_users ADD d_track_stop TINYTEXT NULL  ;  ',
		],
		'orders' => [
			'comment' => 'ALTER TABLE #__jshopping_orders ADD `comment` TINYTEXT NULL  ; ',
			'd_comment' => 'ALTER TABLE #__jshopping_orders ADD d_comment TINYTEXT NULL  ; ',
			'bonus' => 'ALTER TABLE #__jshopping_orders ADD bonus TINYTEXT NULL  ; ',
			'address' => 'ALTER TABLE #__jshopping_orders ADD address TINYTEXT NULL  ; ',
			'd_address' => 'ALTER TABLE #__jshopping_orders ADD d_address TINYTEXT NULL  ; ',
			'FIO' => 'ALTER TABLE #__jshopping_orders ADD FIO TINYTEXT NULL  ; ',
			'd_FIO' => 'ALTER TABLE #__jshopping_orders ADD d_FIO TINYTEXT NULL  ; ',
			'shiping_date' => 'ALTER TABLE #__jshopping_orders ADD shiping_date TINYTEXT NULL  ; ',
			'd_shiping_date' => 'ALTER TABLE #__jshopping_orders ADD d_shiping_date TINYTEXT NULL  ; ',
			'shiping_time' => 'ALTER TABLE #__jshopping_orders ADD shiping_time TINYTEXT NULL  ; ',
			'd_shiping_time' => 'ALTER TABLE #__jshopping_orders ADD d_shiping_time TINYTEXT NULL  ; ',
			'housing' => 'ALTER TABLE #__jshopping_orders ADD housing TINYTEXT NULL  ; ',
			'd_housing' => 'ALTER TABLE #__jshopping_orders ADD d_housing TINYTEXT NULL  ; ',
			'porch' => 'ALTER TABLE #__jshopping_orders ADD porch TINYTEXT NULL  ; ',
			'd_porch' => 'ALTER TABLE #__jshopping_orders ADD d_porch TINYTEXT NULL  ; ',
			'level' => 'ALTER TABLE #__jshopping_orders ADD level TINYTEXT NULL  ; ',
			'd_level' => 'ALTER TABLE #__jshopping_orders ADD d_level TINYTEXT NULL  ; ',
			'intercom' => 'ALTER TABLE #__jshopping_orders ADD intercom TINYTEXT NULL  ; ',
			'd_intercom' => 'ALTER TABLE #__jshopping_orders ADD d_intercom TINYTEXT NULL  ; ',
			'metro' => 'ALTER TABLE #__jshopping_orders ADD metro TINYTEXT NULL  ; ',
			'd_metro' => 'ALTER TABLE #__jshopping_orders ADD d_metro TINYTEXT NULL  ; ',
			'transport_name' => 'ALTER TABLE #__jshopping_orders ADD transport_name TINYTEXT NULL  ; ',
			'd_transport_name' => 'ALTER TABLE #__jshopping_orders ADD d_transport_name TINYTEXT NULL  ; ',
			'transport_no' => 'ALTER TABLE #__jshopping_orders ADD transport_no TINYTEXT NULL  ; ',
			'd_transport_no' => 'ALTER TABLE #__jshopping_orders ADD d_transport_no TINYTEXT NULL  ; ',
			'track_stop' => 'ALTER TABLE #__jshopping_orders ADD track_stop TINYTEXT NULL  ; ',
			'd_track_stop' => 'ALTER TABLE #__jshopping_orders ADD d_track_stop TINYTEXT NULL  ; ',
		],
		'order_item' => [
			'date_event'	=> 'ALTER TABLE #__jshopping_order_item ADD `date_event`	datetime NOT NULL DEFAULT CURRENT_TIMESTAMP; ',
			'date_tickets'	=> 'ALTER TABLE #__jshopping_order_item ADD `date_tickets`	datetime NOT NULL DEFAULT 0 COMMENT "DataTime Start Tickets change status" ; ',
			'count_places'	=> 'ALTER TABLE #__jshopping_order_item ADD `count_places`	int(4) NOT NULL DEFAULT 0; ',
			'places'		=> 'ALTER TABLE #__jshopping_order_item ADD `places`		TEXT NULL DEFAULT "" COMMENT "[{prodValId:\"value_id,attrID\"},...]"; ',
			'place_prices'	=> 'ALTER TABLE #__jshopping_order_item ADD `place_prices`	TEXT NULL DEFAULT "" COMMENT "[{prodValId:price},...]" ; ',
			'place_counts'	=> 'ALTER TABLE #__jshopping_order_item ADD `place_counts`	TEXT NULL DEFAULT "" COMMENT "[{prodValId:count},...]" ; ',
			'place_names'	=> 'ALTER TABLE #__jshopping_order_item ADD `place_names`	TEXT NULL DEFAULT "" COMMENT "[{prodValId:\"attrTitle.placeTitle\"},...] " ; ',
			'place_go'		=> 'ALTER TABLE #__jshopping_order_item ADD `place_go`		TEXT NULL DEFAULT "" COMMENT "[\"sequence number select Place in order item. Порядковый номер выбранного места в этом заказе этго товара\"...] " ; ',
			'place_pushka'	=> 'ALTER TABLE #__jshopping_order_item ADD `place_pushka`	TEXT NULL DEFAULT "" COMMENT "[\"QR ticlets and Puska key tickets.  QR билета и Пушка Ключ Билета\"...] " ; ',
			'event_id'		=> 'ALTER TABLE #__jshopping_order_item ADD event_id int(8) NOT NULL DEFAULT 0	COMMENT "Pushka Event ID" ; ',
		],
		'attr' => [
			'attr_admin_type'	=> 'ALTER TABLE #__jshopping_attr ADD attr_admin_type int(3) NOT NULL  DEFAULT 0; ',
			'StageCatId'		=> 'ALTER TABLE #__jshopping_attr ADD StageCatId int(11) NOT NULL DEFAULT 0; ',
			'Row'				=> 'ALTER TABLE #__jshopping_attr ADD `Row` varchar(24) NOT NULL DEFAULT ""; ',
			'SectorId'			=> 'ALTER TABLE #__jshopping_attr ADD SectorId int(11) NOT NULL DEFAULT 0; ',
			'StageId'			=> 'ALTER TABLE #__jshopping_attr ADD StageId int(11) NOT NULL DEFAULT 0; ',
		],
		'products' => [
			'date_event'	=> 'ALTER TABLE #__jshopping_products ADD date_event datetime NOT NULL DEFAULT CURRENT_TIMESTAMP	COMMENT "DataTime Start Event" ; ',
			'date_tickets'	=> 'ALTER TABLE #__jshopping_products ADD date_tickets datetime NOT NULL DEFAULT 0 COMMENT "DataTime Start Tickets change status" ; ',
			'params'		=> 'ALTER TABLE #__jshopping_products ADD params text   NULL  ; ',
			'RepertoireId'	=> 'ALTER TABLE #__jshopping_products ADD RepertoireId int(11) NOT NULL DEFAULT 0; ',
			'StageId'		=> 'ALTER TABLE #__jshopping_products ADD StageId int(11) NOT NULL DEFAULT 0; ',
			'event_id'		=> 'ALTER TABLE #__jshopping_products ADD event_id int(8) NOT NULL DEFAULT 0	COMMENT "Pushka Event ID" ; ',
		],
		'categories' => [
			'PlaceId'		=> 'ALTER TABLE #__jshopping_categories ADD PlaceId int(11) NOT NULL DEFAULT 0; ',
			'StageId'		=> 'ALTER TABLE #__jshopping_categories ADD StageId int(11) NOT NULL DEFAULT 0; ',
			'RepertoireId'	=> 'ALTER TABLE #__jshopping_categories ADD RepertoireId int(11) NOT NULL DEFAULT 0; ',
		],
		'products_attr2' => [
			'OfferId'		=> 'ALTER TABLE #__jshopping_products_attr2 ADD OfferId int(11) NOT NULL DEFAULT 0; ',
			'count'			=> 'ALTER TABLE #__jshopping_products_attr2 ADD count smallint(5) NOT NULL DEFAULT 1; ',
		],
	];
	private $queries_tbl_columns = [
		'orders' => 'SHOW COLUMNS FROM #__jshopping_orders;',
		'order_item' => 'SHOW COLUMNS FROM #__jshopping_order_item;',
		'attr' => 'SHOW COLUMNS FROM #__jshopping_attr;',
		'products' => 'SHOW COLUMNS FROM #__jshopping_products;',
		'categories' => 'SHOW COLUMNS FROM #__jshopping_categories;',
		'products_attr2' => 'SHOW COLUMNS FROM #__jshopping_products_attr2;',
		'users' => 'SHOW COLUMNS FROM #__jshopping_users;',
	];
	private $queries_tbl_mods = [
		'users' => [
//			'FIO'			=>'ALTER TABLE #__jshopping_users MODIFY FIO TINYTEXT NULL  ; ',
//			'd_FIO'			=>'ALTER TABLE #__jshopping_users MODIFY d_FIO TINYTEXT NULL  ; ',
//			
			'comment' => 'ALTER TABLE #__jshopping_users MODIFY `comment` TINYTEXT NULL  ; ',
			'd_comment' => 'ALTER TABLE #__jshopping_users MODIFY d_comment TINYTEXT NULL  ; ',
//
//			'bonus'			=> 'ALTER TABLE #__jshopping_users MODIFY bonus TINYTEXT NOT NULL ;  ',
//			'address'		=> 'ALTER TABLE #__jshopping_users MODIFY address TINYTEXT NOT NULL ;  ',
//			'd_address'		=> 'ALTER TABLE #__jshopping_users MODIFY d_address TINYTEXT NOT NULL ;  ',
//
//			'shiping_date'	=> 'ALTER TABLE #__jshopping_users MODIFY shiping_date TINYTEXT NOT NULL ;  ',
//			'd_shiping_date'=> 'ALTER TABLE #__jshopping_users MODIFY d_shiping_date TINYTEXT NOT NULL ;  ',
//			'shiping_time'	=> 'ALTER TABLE #__jshopping_users MODIFY shiping_time TINYTEXT NOT NULL ;  ',
//			'd_shiping_time'=> 'ALTER TABLE #__jshopping_users MODIFY d_shiping_time TINYTEXT NOT NULL ;  ',
//
//			'housing'		=> 'ALTER TABLE #__jshopping_users MODIFY housing TINYTEXT NOT NULL ;  ',
//			'd_housing'		=> 'ALTER TABLE #__jshopping_users MODIFY d_housing TINYTEXT NOT NULL ;  ',
//			'porch'			=> 'ALTER TABLE #__jshopping_users MODIFY porch TINYTEXT NOT NULL ;  ',
//			'd_porch'		=> 'ALTER TABLE #__jshopping_users MODIFY d_porch TINYTEXT NOT NULL ;  ',
//			'level'			=> 'ALTER TABLE #__jshopping_users MODIFY level TINYTEXT NOT NULL ;  ',
//			'd_level'		=> 'ALTER TABLE #__jshopping_users MODIFY d_level TINYTEXT NOT NULL ;  ',
//			'intercom'		=> 'ALTER TABLE #__jshopping_users MODIFY intercom TINYTEXT NOT NULL ;  ',
//			'd_intercom'	=> 'ALTER TABLE #__jshopping_users MODIFY d_intercom TINYTEXT NOT NULL ;  ',
//			'metro'			=> 'ALTER TABLE #__jshopping_users MODIFY metro TINYTEXT NOT NULL ;  ',
//			'd_metro'		=> 'ALTER TABLE #__jshopping_users MODIFY d_metro TINYTEXT NOT NULL ;  ',
//			'transport_name'=> 'ALTER TABLE #__jshopping_users MODIFY transport_name TINYTEXT NOT NULL ;  ',
//			'd_transport_name'=>'ALTER TABLE #__jshopping_users MODIFY d_transport_name TINYTEXT NOT NULL ;  ',
//			'transport_no'	=> 'ALTER TABLE #__jshopping_users MODIFY transport_no TINYTEXT NOT NULL ;  ',
//			'd_transport_no'=> 'ALTER TABLE #__jshopping_users MODIFY d_transport_no TINYTEXT NOT NULL ;  ',
//			'track_stop'	=> 'ALTER TABLE #__jshopping_users MODIFY track_stop TINYTEXT NOT NULL ;  ',
//			'd_track_stop'	=> 'ALTER TABLE #__jshopping_users MODIFY d_track_stop TINYTEXT NOT NULL ;  ',
		],
		'orders' => [
			'comment' => 'ALTER TABLE #__jshopping_orders MODIFY `comment` TINYTEXT NULL  ; ',
			'd_comment' => 'ALTER TABLE #__jshopping_orders MODIFY d_comment TINYTEXT NULL  ; ',
//			
//			'bonus'			=> 'ALTER TABLE #__jshopping_orders MODIFY bonus TINYTEXT NOT NULL ;  ',
//			'address'		=> 'ALTER TABLE #__jshopping_orders MODIFY address TINYTEXT NOT NULL ;  ',
//			'd_address'		=> 'ALTER TABLE #__jshopping_orders MODIFY d_address TINYTEXT NOT NULL ;  ',
//			
//			'FIO'			=> 'ALTER TABLE #__jshopping_orders MODIFY FIO TINYTEXT NOT NULL ;  ',
//			'd_FIO'			=> 'ALTER TABLE #__jshopping_orders MODIFY d_FIO TINYTEXT NOT NULL ; ',
//			
//			'shiping_date'	=> 'ALTER TABLE #__jshopping_orders MODIFY shiping_date TINYTEXT NOT NULL ;  ',
//			'd_shiping_date'=> 'ALTER TABLE #__jshopping_orders MODIFY d_shiping_date TINYTEXT NOT NULL ;  ',
//			'shiping_time'	=> 'ALTER TABLE #__jshopping_orders MODIFY shiping_time TINYTEXT NOT NULL ;  ',
//			'd_shiping_time'=> 'ALTER TABLE #__jshopping_orders MODIFY d_shiping_time TINYTEXT NOT NULL ;  ',
//			
//			'housing'		=> 'ALTER TABLE #__jshopping_orders MODIFY housing TINYTEXT NOT NULL ;  ',
//			'd_housing'		=> 'ALTER TABLE #__jshopping_orders MODIFY d_housing TINYTEXT NOT NULL ;  ',
//			'porch'			=> 'ALTER TABLE #__jshopping_orders MODIFY porch TINYTEXT NOT NULL ;  ',
//			'd_porch'		=> 'ALTER TABLE #__jshopping_orders MODIFY d_porch TINYTEXT NOT NULL ;  ',
//			'level'			=> 'ALTER TABLE #__jshopping_orders MODIFY level TINYTEXT NOT NULL ;  ',
//			'd_level'		=> 'ALTER TABLE #__jshopping_orders MODIFY d_level TINYTEXT NOT NULL ;  ',
//			'intercom'		=> 'ALTER TABLE #__jshopping_orders MODIFY intercom TINYTEXT NOT NULL ;  ',
//			'd_intercom'	=> 'ALTER TABLE #__jshopping_orders MODIFY d_intercom TINYTEXT NOT NULL ;  ',
//			'metro'			=> 'ALTER TABLE #__jshopping_orders MODIFY metro TINYTEXT NOT NULL ;  ',
//			'd_metro'		=> 'ALTER TABLE #__jshopping_orders MODIFY d_metro TINYTEXT NOT NULL ;  ',
//			'transport_name'=> 'ALTER TABLE #__jshopping_orders MODIFY transport_name TINYTEXT NOT NULL ;  ',
//			'd_transport_name'=>'ALTER TABLE #__jshopping_orders MODIFY d_transport_name TINYTEXT NOT NULL ;  ',
//			'transport_no'	=> 'ALTER TABLE #__jshopping_orders MODIFY transport_no TINYTEXT NOT NULL ;  ',
//			'd_transport_no'=> 'ALTER TABLE #__jshopping_orders MODIFY d_transport_no TINYTEXT NOT NULL ;  ',
//			'track_stop'	=> 'ALTER TABLE #__jshopping_orders MODIFY track_stop TINYTEXT NOT NULL ;  ',
//			'd_track_stop'	=> 'ALTER TABLE #__jshopping_orders MODIFY d_track_stop TINYTEXT NOT NULL ;  ',
		],
	];
}

return;
?>
-- Добавить в контроллер Корзины при вызове метода удалить товар, чтобы редирект был без ошибки
Сброс ItemID делать с проверкой на наличие пункта меню для корзины ,
если пункт меню с корзиной есть, то выполнять НЕ надо
JFactory::getApplication()->input->set('Itemid',0);
