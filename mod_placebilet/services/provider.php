<?php defined('_JEXEC') or die;
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



use Joomla\CMS\Extension\Service\Provider\HelperFactory;
use Joomla\CMS\Extension\Service\Provider\Module;
use Joomla\CMS\Extension\Service\Provider\ModuleDispatcherFactory;
use Joomla\DI\Container;
use Joomla\DI\ServiceProviderInterface;

/**
 * The quickicon module service provider.
 *
 * @since  4.0.0
 */
return new class implements ServiceProviderInterface
{
    /**
     * Registers the service provider with a DI container.
     *
     * @param   Container  $container  The DI container.
     *
     * @return  void
     *
     * @since   4.0.0
     */
    public function register(Container $container)
    {											
		
		if(file_exists(__DIR__.'/../src/Dispatcher/Dispatcher.php'))
		require_once  __DIR__.'/../src/Dispatcher/Dispatcher.php';
		
		$container->registerServiceProvider(new ModuleDispatcherFactory('\\Joomla\\Module\\Placebilet'));
		$container->registerServiceProvider(new           HelperFactory('\\Joomla\\Module\\Placebilet\\Administrator\\Helper'));
//		$container->registerServiceProvider(new           HelperFactory('\\Joomla\\Module\\Placebilet\\Site\\Helper'));
//		$container->registerServiceProvider(new           HelperFactory('\\Joomla\\Module\\Placebilet\\Administrator'));
//		$container->registerServiceProvider(new           HelperFactory('\\Joomla\\Module\\Placebilet'));
//																         \\Joomla\\Module\\Placebilet\\Administrator\\Helper;
		$container->registerServiceProvider(new Module());
    }
};
