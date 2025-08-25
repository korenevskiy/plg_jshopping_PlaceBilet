<?php namespace Joomla\Module\Placebilet\Administrator\Dispatcher;
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


		  
use Joomla\CMS\Dispatcher\AbstractModuleDispatcher;
use Joomla\CMS\Helper\ModuleHelper;
use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Plugin\PluginHelper;
use modPlaceBiletHelper as Helper;
use Joomla\Registry\Registry as JRegistry;
use Joomla\CMS\Uri\Uri;
use Joomla\CMS\Factory as JFactory;
use Joomla\CMS\Helper\HelperFactoryAwareInterface;
use Joomla\CMS\Helper\HelperFactoryAwareTrait;
use Joomla\Module\Placebilet\Administrator\Helper\PlaceBiletHelper;

// phpcs:disable PSR1.Files.SideEffects
\defined('JPATH_PLATFORM') or die;
// phpcs:enable PSR1.Files.SideEffects
//ini_set('display_errors', '1');
//ini_set('display_startup_errors', '1');
//error_reporting(E_ALL);

/**
 * Dispatcher class for mod_quickicon
 *
 * @since  4.0.0
 */
class Dispatcher extends AbstractModuleDispatcher implements HelperFactoryAwareInterface
{
    use HelperFactoryAwareTrait;
	
    /**
     * Returns the layout data.
     *
     * @return  array
     *
     * @since   4.0.0
     */
//    protected function getLayoutData()
//    {
//		
//        echo $this->getApplication()->bootModule('mod_placebilet', 'administrator')->getHelper('PlacebiletHelper');//->test();
//        
////echo "<pre>123666</pre>";
//		return parent::getLayoutData();
		
//		JFactory::getLanguage()->load('mod_placebilet', __DIR__);
//		JFactory::getApplication()->getLanguage()->load('mod_placebilet', __DIR__);
//		\Joomla\CMS\Language\Text::script('JSHOP_PUSHKA_ALERT_ERROR_SESSION');

//require_once '../Helper/PlacebiletHelper.php';
	//$params = new JRegistry($module);

//$params->loadObject($params);

//Helper::$param = $params->toObject();
//require ModuleHelper::getLayoutPath('mod_placebilet', $params->get('layout', 'default'));
	
		
//		$data['params'] =  new \Reg($this->module->params);
//		$data['params']->loadObject($this->module);
//		$data['module'];
//		$data['app'];
//		$data['input'];
//		$data['params'];
//		$data['template'];
		
//Helper::$param = $params->toObject();


//        $this->module;
//        $this->app;
//        $this->input;
//        $this->app->getTemplate();
//		 $className = '\\' . trim($this->namespace, '\\') . '\\' . $name . '\\Dispatcher\\Dispatcher';
		
//        $data = parent::getLayoutData();
//		$this->getApplication();
//		$helper	= $this->app->bootModule('mod_placebilet', 'administrator')->getHelper('PlaceBiletHelper');
//		$helper::setModule($this->module);//$param	= $data['params']->toObject();
//		$data['param'] = $helper::$param;
//		$data['helper'] = $helper;
//
//        return $data;
//    }
}
