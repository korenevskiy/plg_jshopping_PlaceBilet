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

//namespace Joomla\CMS;

\defined('JPATH_PLATFORM') or die;

//use Joomla\CMS\Factory;

//use Joomla\CMS\Application\CMSApplicationInterface;
//use Joomla\CMS\Cache\Cache;
//use Joomla\CMS\Cache\CacheControllerFactoryInterface;
//use Joomla\CMS\Client\ClientHelper;
//use Joomla\CMS\Date\Date;
//use Joomla\CMS\Document\Document;
//use Joomla\CMS\Document\FactoryInterface;
//use Joomla\CMS\Filesystem\Stream;
//use Joomla\CMS\Input\Input;
//use Joomla\CMS\Language\Language;
//use Joomla\CMS\Language\LanguageFactoryInterface;
//use Joomla\CMS\Log\Log;
//use Joomla\CMS\Mail\Mail;
//use Joomla\CMS\Mail\MailHelper;
//use Joomla\CMS\Session\Session;
//use Joomla\CMS\User\User;
//use Joomla\Database\DatabaseDriver;
//use Joomla\Database\DatabaseInterface;
//use Joomla\DI\Container;
//use Joomla\Registry\Registry;
//use PHPMailer\PHPMailer\Exception as phpmailerException;
/**
 * Joomla Platform Factory class.
 *
 * @since  1.7.0
 */
class xRegistry extends Joomla\Registry\Registry
{
	/**
	 * Set a registry value.
	 *
	 * @param   string  $name       Registry Path (e.g. joomla.content.showauthor)
	 * @param   mixed   $value      Value of entry 
	 *
	 * @return  mixed  The value of the that has been set.
	 *
	 * @since   1.0
	 */
	public function __set($name = '', $value = null): void
	{
//		toPrint($value,'$value',0,'pre',true);
		$this->set($name, $value);
	}

	/**
	 * Get a registry value.
	 *
	 * @param   string  $name     Registry path (e.g. joomla.content.showauthor)
	 *
	 * @return  mixed  Value of entry or null
	 *
	 * @since   1.0
	 */
	public function __get( $name) //$path, $default = null
	{
		return $this->get($name, null);
	}

	/**
	 * Check if a registry path exists.
	 *
	 * @param   string  $name  Registry path (e.g. joomla.content.showauthor)
	 *
	 * @return  boolean
	 *
	 * @since   1.0
	 */
	public function __isset(string $name): bool
	{
		return $this->exists($name);
	}

	/** 
	 * Delete a registry value 
	 * @param   string  $name  Registry Path (e.g. joomla.content.showauthor) 
	 * @return void
	 */
	public function __unset(string $name): void
	{
		$this->remove($name);
	}

	public function __invoke($data): mixed
	{
		if($data instanceof \Joomla\Registry)
		{
			return $this->merge($data);
		}

		if(is_array($data))
		{
			return $this->loadArray($data);
		}

		if(is_a($data))
		{
			return $this->loadObject($data);
		}
	}
}

//JLoader::register('JRegistry', 'XRegistry',true);