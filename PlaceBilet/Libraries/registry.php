<?php
/**
 * Joomla! Content Management System
 *
 * @copyright  (C) 2005 Open Source Matters, Inc. <https://www.joomla.org>
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

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
	public function __set(string $name = '', $value = null): void
	{
//		toPrint($value,'$value',0,'pre',true);
		$this->set($name, $value);
	}

	public function __get(string $name)
	{
		return $this->get($name);
	}

	public function __isset(string $name): bool
	{
		return $this->exists($name);
	}

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