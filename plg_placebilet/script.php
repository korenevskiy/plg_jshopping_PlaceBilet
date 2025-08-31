<?php  defined('_JEXEC') or die;


use Joomla\CMS\Application\AdministratorApplication;
use Joomla\CMS\Factory;
use Joomla\CMS\Installer\InstallerAdapter;
use Joomla\CMS\Installer\InstallerScriptInterface;
use Joomla\CMS\Language\Text;
use Joomla\CMS\Version;
use Joomla\Database\DatabaseDriver;
use Joomla\DI\Container;
use Joomla\DI\ServiceProviderInterface;
use Joomla\CMS\Factory as JFactory;
use Joomla\CMS\Filesystem\File as JFile;
use Joomla\CMS\Installer\InstallerAdapter;
use Joomla\CMS\Installer\InstallerAdapter as JAdapterInstance;
use Joomla\CMS\Version as JVersion;
use Joomla\CMS\Language\Text as JText;

/** -----------------------------------------------------------------------
 * plg_PlaceBilet - Plugin Joomshopping Component for CMS Joomla
 * ------------------------------------------------------------------------
 * author    Sergei Borisovich Korenevskiy
 * @copyright (C) 2019 //explorer-office.ru. All Rights Reserved. 
 * @license GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 * @package plg_PlaceBilet
 * Websites: //explorer-office.ru/download/
 * Technical Support:  Telegram - //t.me/placebilet
 * Technical Support:  Forum	- //vk.com/placebilet
 * Technical Support:  Github	- https://github.com/korenevskiy/plg_jshopping_PlaceBilet
 * Technical Support:  Max		- https://max.ru/join/l2YuX1enTVg2iJ6gkLlaYUvZ3JKwDFek5UXtq5FipLA
 * -------------------------------------------------------------------------
 **/



$file_func = JPATH_ROOT . '/functions.php';
if (file_exists($file_func))
	require_once $file_func;


return new class () implements ServiceProviderInterface {

    public function register(Container $container)
    {    
		$container->set(InstallerScriptInterface::class,
/**
 * Файл-скрипт для плагина PlaceBilet.
 */
new class ($container->get(AdministratorApplication::class)) implements InstallerScriptInterface { // class PlgJshoppingPlacebiletInstallerScript


	private $isRU = false;
	
			
	/**
	 * The application object
	 *
	 * @var  AdministratorApplication
	 *
	 * @since  2.0.0
	 */
	protected AdministratorApplication $app;

	/**
	 * The Database object.
	 *
	 * @var   DatabaseDriver
	 *
	 * @since  2.0.0
	 */
	protected DatabaseDriver $db;

	/**
					 * Minimum PHP version required to install the extension.
					 *
					 * @var  string
					 *
					 * @since  2.0.0
					 */
	protected string $minimumPhp = '7.4';

	/**
	 * Minimum Joomla version required to install the extension.
	 *
	 * @var  string
	 *
	 * @since  2.0.0
	 */
	protected string $minimumJoomla = '4.2';

	/**
	 * Constructor.
	 *
	 * @param   AdministratorApplication  $app  The application object.
	 * @param   InstallerAdapter  $adapter  The adapter calling this method
	 *
	 * @since 2.0.0
	 */
	public function __construct(AdministratorApplication $app = null, $adapter = null) {// 3 JAdapterInstance  4 Joomla\CMS\Installer\InstallerAdapter 
//toPrint($adapter,'Install $adapter');
//JFactory::getApplication()->enqueueMessage(JVersion::MAJOR_VERSION.' ConstructorInstaller');
		$this->app = $app;
		$lang = $app->getLanguage()->getTag();
		$lang = substr($lang, 0, 2); // reset(explode ('-', $lang));
		$this->db  = Factory::getContainer()->get('DatabaseDriver');
		$this->isRU = in_array($lang, ['ru', 'uk', 'be', 'kz', 'by', 'ab', 'be', 'be']);
	}
 
				
	/**
	 * Вызов installation  - 4,3
	 * Function called after the extension is installed.
	 *
	 * @param   InstallerAdapter  $adapter  The adapter calling this method
	 *
	 * @return  boolean  True on success
	 * @since   2.0.0
	 */
	public function install(InstallerAdapter $adapter = null) {//JAdapterInstance - 3, InstallerAdapter  - 4
//		$this->db->setQuery('SET GLOBAL innodb_strict_mode=OFF;')->execute();
//$params = $this->db->setQuery('
//SELECT extension_id,element, params 
//FROM #__extensions
//WHERE element IN ( "PlaceBilet", "placebilet");')->loadObject();
//JFactory::getApplication()->enqueueMessage(   '<pre>' . print_r($params, true) . '</pre>');
//JFactory::getApplication()->enqueueMessage(JVersion::MAJOR_VERSION.' InstallInstaller');
//toPrint($adapter,'Install $adapter');
		if (!$this->existJShopping()) {
			return FALSE;
		}
//		$this->enablePlugin($adapter);
		
		$query = "
				UPDATE #__extensions e SET e.params= REPLACE(e.params, '3772199444', '4245918837') 
				WHERE e.element = 'PlaceBilet' or e.element = 'placebilet'; ";
		$this->db->setQuery($query)->execute();
		
		$prefix = $this->db->getPrefix();
		
		

		$all_columns = [];

		foreach ($this->queries_tbl_columns as $tbl => $query) {
//			if(JFactory::getConfig()->get('debug') || JFactory::getConfig()->get('error_reporting') == 'maximum')
//				JFactory::getApplication()->enqueueMessage(str_replace('#__', $prefix, $query));
//			$columns = $this->db->setQuery($query)->loadObjectList('Field');
//			$all_columns[$tbl] = array_column($columns, 'Field');
			$all_columns[$tbl] = $this->db->setQuery($query)->loadAssocList('Field', 'Type');
		}
		
		$srcNoImage = __DIR__.'/media/noimage.png';
		
		$catNoImage = JPATH_ROOT . '/components/com_jshopping/files/img_categories/noimage.png';
		$prodNoImage = JPATH_ROOT . '/components/com_jshopping/files/img_products/noimage.png';
		
		\Joomla\Filesystem\File::copy($srcNoImage, $catNoImage);
		\Joomla\Filesystem\File::copy($srcNoImage, $prodNoImage);
		
		$queries = [];

		foreach ($this->new_tbl_columns as $tbl => $columns) {
			if (empty($all_columns[$tbl])) {
				$this->app->enqueueMessage('Not Intalled JoomShopping component. Please install the <b>JoomShopping</b> component first. <br>
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
				$this->app->enqueueMessage('in table ' . str_replace('#__', $prefix, $tbl) . ' Add columns: ' . implode(',', $cols));
		}

//file_put_contents(JPATH_ROOT. '/XXXzzz.txt', print_r($queries, true) . "\n\n", FILE_APPEND);
//JFactory::getApplication()->enqueueMessage(str_replace('#__', $prefix, implode('<br>',$queries)));
//return;
		foreach ($queries as $query) {
//JFactory::getApplication()->enqueueMessage('Query:'.str_replace('#__', $prefix, $query));
			$this->db->setQuery($query)->execute();
		}



		$this->db->setQuery("UPDATE #__jshopping_attr SET attr_type = 4 WHERE attr_type = 0;")->execute();

//return;
//static::toLog('ERROR ????????????????????????????????????? -- 0','','',TRUE);
//        toPrint(array_keys($adapter),'thisAdapter');

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
//        $adapter->getParent()->setRedirectURL('index.php?option=com_plugins&view=plugins&filter[folder]=jshopping'); 
		if (JVersion::MAJOR_VERSION == 3) {
			$adapter->getParent()->setRedirectURL('index.php?option=com_jshopping&controller=attributes');
		} else {
			$$adapter->getParent()->setRedirectURL('index.php?option=com_jshopping&controller=attributes');
		}

		header('Content-Type:  "text/html; charset=utf-8"');

		return TRUE;
	}

	/**
	 * Function called after the extension is updated.
	 * Called on update
	 *
	 * @param   InstallerAdapter  $adapter  The adapter calling this method
	 *
	 * @return  boolean  True on success
	 *
	 * @since   2.0.0
	 */
	public function update(InstallerAdapter $adapter = null): bool {
		//JFactory::getApplication()->enqueueMessage(JVersion::MAJOR_VERSION.' UpdateInstaller');
//		$message = JText::_('JSHOP_PLACE_BILET_EXIST_JSHOPPING_INFO');
//		JFactory::getApplication()->enqueueMessage($message);
		$prefix = $this->db->getPrefix();
//        $query = "
//                UPDATE #__update_sites us, #__extensions e,#__update_sites_extensions se 
//                SET us.location = REPLACE(us.location, 'PlaceBilet_update.', 'PlaceBilet_update_prox.') 
//                WHERE e.element = 'PlaceBilet' AND se.extension_id = e.extension_id AND se.update_site_id = us.update_site_id; ";
//		$this->db->setQuery($query)->execute();
//		JFactory::getApplication()->enqueueMessage('Ok 0');


		if (!$this->existJShopping()) {
			return FALSE;
		}

		$this->install($adapter, false);
//		return TRUE;


		static::moveControllers();

		return TRUE;
	}

	/**
	 * Function called after the extension is uninstalled.
	 * Вызов on uninstallation
	 *
	 * @param   InstallerAdapter  $adapter  The object responsible for running this script
	 *
	 * @return  boolean  True on success
	 *
	 * @since   2.0.0
	 */
	public function uninstall(InstallerAdapter $adapter = null): bool{ //JAdapterInstance - 3, InstallerAdapter  - 4
				$prefix = $this->db->getPrefix();
		$all_columns = [];

		foreach ($this->queries_tbl_columns as $tbl => $query) {
//JFactory::getApplication()->enqueueMessage(str_replace('#__', $prefix, $query));
			$columns = $this->db->setQuery(str_replace('#__', $prefix, $query))->loadObjectList('Field');
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
			$this->db->setQuery(str_replace('#__', $prefix, $query))->execute();
		}

		return TRUE;
	}

	/**
	 * Function called before extension installation/update/removal procedure commences.
	 *
	 * @param   string            $type     The type of change (install|uninstall|discover_install|update)
	 * @param   InstallerAdapter  $adapter  The adapter calling this method
	 *
	 * @return  boolean  True on success
	 *
	 * @since   2.0.0
	 */
	public function preflight(string $type, InstallerAdapter $adapter): bool {   //JAdapterInstance - 3, InstallerAdapter  - 4
//JFactory::getApplication()->enqueueMessage(JVersion::MAJOR_VERSION.' PreFlightInstaller');
		// Check compatible
		if (!$this->checkCompatible()) {
			return false;
		}

		return true;
	}
	
	/**
	 * Вызывается после любого типа действия 4,3: installation/update/removal
	 * Function called after extension installation/update/removal procedure commences.
	 *
	 * @param   string            $type     The type of change (install or discover_install, update, uninstall)
	 * @param   InstallerAdapter  $adapter  The object responsible for running this script
	 *
	 * @return  boolean  True on success
	 *
	 * @since   2.0.0
	 */
	public function postflight(string $type, InstallerAdapter $adapter): bool {
		
//		$this->db->setQuery('SET GLOBAL innodb_strict_mode=ON;')->execute();
//JFactory::getApplication()->enqueueMessage(JVersion::MAJOR_VERSION.' PostFlightInstaller');
		$type; // update, install
//		$adapter->get('manifest')->version;
//		$prefix = $this->db->getPrefix();
		
		

		$query = "UPDATE `#__extensions` SET enabled = 1 WHERE element IN ('PlaceBilet','placebilet') AND folder = 'jshopping'; ";

		if ($type == 'install')
			$this->app->setQuery($query)->execute(); // loadResult();// loadObjectList('Field');
//		JFactory::getApplication()->enqueueMessage("<pre>".print_r($type,true)."</pre>"); //->dump()
		JFactory::getApplication()->enqueueMessage(JText::_('JSHOP_PLACE_BILET_DESC')); //->dump()
		JFactory::getApplication()->enqueueMessage(JText::_('JSHOP_PLACE_BILET_INSTRUCTION')); //->dump()
		
		static::languageMinificationRaw();

		return true;
	}

	/**
	  * Enable plugin after installation.
	  *
	  * @param   InstallerAdapter  $adapter  Parent object calling object.
	  *
	  * @since  2.0.0
	  */
	 protected function enablePlugin(InstallerAdapter $adapter): void{
	 	// Prepare plugin object
		$plugin          = new \stdClass();
		$plugin->type    = 'plugin';
		$plugin->element = $adapter->getElement();
		$plugin->folder  = (string)$adapter->getParent()->manifest->attributes()['group'];
		$plugin->enabled = 1;

		// Update record
		$this->db->updateObject('#__extensions', $plugin, ['type', 'element', 'folder']);
	}

	/**
	 * Method to check compatible.
	 *
	 * @throws  \Exception
	 *
	 * @return  bool True on success, False on failure.
	 *
	 * @since  1.0.0
	 */
	protected function checkCompatible(): bool
	{
		$app = Factory::getApplication();

		// Check joomla version
		if (!(new Version())->isCompatible($this->minimumJoomla)) {
			$app->enqueueMessage(Text::sprintf('PLG_QUICKICON_RESETMEDIAVERSION_WRONG_JOOMLA', $this->minimumJoomla), 'error');

			return false;
		}

		// Check PHP
		if (!(version_compare(PHP_VERSION, $this->minimumPhp) >= 0)) {
			$app->enqueueMessage(Text::sprintf('PLG_QUICKICON_RESETMEDIAVERSION_WRONG_PHP', $this->minimumPhp), 'error');

			return false;
		}

		return true;
	}

	
	private function existJShopping() {
		$prefix = $this->db->getPrefix();

		$query = "SHOW TABLES   LIKE '{$prefix}jshopping_products'; ";

		$existJshopping = $this->db->setQuery($query)->loadResult(); // loadObjectList('Field'); 
//$this->db->replacePrefix($sql);
//$this->db->getPrefix(); 
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
			'date_event'	=> 'ALTER TABLE #__jshopping_order_item ADD `date_event`	DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP; ',
			'date_tickets'	=> 'ALTER TABLE #__jshopping_order_item ADD `date_tickets`	DATETIME NOT NULL DEFAULT 0 COMMENT "DataTime Start Tickets status change" ; ',
			'date_activity'	=> 'ALTER TABLE #__jshopping_order_item ADD `date_activity`	DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT "DataTime of the last status change" ; ',
			'count_places'	=> 'ALTER TABLE #__jshopping_order_item ADD `count_places`	INT(4) NOT NULL DEFAULT 0; ',
			'places'		=> 'ALTER TABLE #__jshopping_order_item ADD `places`		TEXT NULL COMMENT "[{prodValId:\"value_id,attrID\"},...]"; ',
			'place_prices'	=> 'ALTER TABLE #__jshopping_order_item ADD `place_prices`	TEXT NULL COMMENT "[{prodValId:price},...]" ; ',
			'place_counts'	=> 'ALTER TABLE #__jshopping_order_item ADD `place_counts`	TEXT NULL COMMENT "[{prodValId:count},...]" ; ',
			'place_names'	=> 'ALTER TABLE #__jshopping_order_item ADD `place_names`	TEXT NULL COMMENT "[{prodValId:\"attrTitle.placeTitle\"},...] " ; ',
			'place_go'		=> 'ALTER TABLE #__jshopping_order_item ADD `place_go`		TEXT NOT NULL DEFAULT "" COMMENT "[\"sequence number select Place in order item. Порядковый номер выбранного места в этом заказе этго товара\"...] " ; ',
			'place_pushka'	=> 'ALTER TABLE #__jshopping_order_item ADD `place_pushka`	TEXT NULL COMMENT "[\"QR ticlets and Puska key tickets.  QR билета и Пушка Ключ Билета\"...] " ; ',
			'event_id'		=> 'ALTER TABLE #__jshopping_order_item ADD `event_id`		INT(8) NOT NULL DEFAULT 0	COMMENT "Pushka Event ID" ; ',
		],
		'attr' => [
			'attr_admin_type'	=> 'ALTER TABLE #__jshopping_attr ADD attr_admin_type int(3) NOT NULL  DEFAULT 0; ',
			'StageCatId'		=> 'ALTER TABLE #__jshopping_attr ADD StageCatId int(11) NOT NULL DEFAULT 0; ',
			'Row'				=> 'ALTER TABLE #__jshopping_attr ADD `Row` varchar(24) NOT NULL DEFAULT ""; ',
			'SectorId'			=> 'ALTER TABLE #__jshopping_attr ADD SectorId int(11) NOT NULL DEFAULT 0; ',
			'StageId'			=> 'ALTER TABLE #__jshopping_attr ADD StageId int(11) NOT NULL DEFAULT 0; ',
		],
		'products' => [
			'date_event'	=> 'ALTER TABLE #__jshopping_products ADD date_event	DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP	COMMENT "DataTime Start Event" ; ',
			'date_tickets'	=> 'ALTER TABLE #__jshopping_products ADD date_tickets	DATETIME NOT NULL DEFAULT 0 COMMENT "DataTime Start Tickets change status" ; ',
			'params'		=> 'ALTER TABLE #__jshopping_products ADD params		TEXT   NULL  ; ',
			'RepertoireId'	=> 'ALTER TABLE #__jshopping_products ADD RepertoireId	int(11) NOT NULL DEFAULT 0; ',
			'StageId'		=> 'ALTER TABLE #__jshopping_products ADD StageId		int(11) NOT NULL DEFAULT 0; ',
			'event_id'		=> 'ALTER TABLE #__jshopping_products ADD event_id		int(8) NOT NULL DEFAULT 0	COMMENT "Pushka Event ID" ; ',
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
			'ALTER TABLE #__jshopping_order_item MODIFY date_activity datetime NOT NULL  DEFAULT CURRENT_TIMESTAMP; ',
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
});
	}
};
return;
?>
