<?php \defined('_JEXEC') or die;
 /** ----------------------------------------------------------------------
 * plg_placebilet - Plugin Joomshopping Component for CMS Joomla
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

use Joomla\Event\DispatcherInterface;
use Joomla\CMS\Extension\PluginInterface;
use Joomla\CMS\Plugin\PluginHelper as JPluginHelper;
use Joomla\Plugin\Jshopping\Placebilet\Extension\Placebilet;
use Joomla\Plugin\Jshopping\Placebilet\Extension\Plugin;
use Joomla\CMS\Factory as JFactory;

/**
 * The placebilet plubin service provider.
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
        $container->set(
            PluginInterface::class,
            function (Container $container) {
				$plugin     =  new Plugin(
					$container->get(DispatcherInterface::class),
					(array) JPluginHelper::getPlugin('jshopping', 'placebilet')
				);
				
                $plugin->setApplication(JFactory::getApplication());
                return $plugin;
            }
        );
    }
};