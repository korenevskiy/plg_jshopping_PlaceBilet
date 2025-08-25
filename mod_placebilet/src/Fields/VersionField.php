<?php namespace Joomla\Module\Placebilet\Administrator\Fields;
defined('_JEXEC') or die;
/**------------------------------------------------------------------------
 * field_translate - minification of INI language files, removal of hyphenation
 * ------------------------------------------------------------------------
 * @author    Sergei Borisovich Korenevskiy
 * @copyright (C) 2025 http://explorer-office.ru. All Rights Reserved. 
 * @license GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 * @license GNU General Public License version 2 or later; see LICENSE.txt
 * @package plg_placebilet
 * @subpackage  plg_placebilet
 * Websites: https://explorer-office.ru/download/
 * Technical Support:  Telegram - https://t.me/placebilet
 * Technical Support:  Forum	- https://vk.com/placebilet
 * Technical Support:  Github	- https://github.com/korenevskiy/plg_jshopping_PlaceBilet
 * Technical Support:  Max		- https://max.ru/join/l2YuX1enTVg2iJ6gkLlaYUvZ3JKwDFek5UXtq5FipLA
 * -------------------------------------------------------------------------
 **/

use Joomla\CMS\Plugin\PluginHelper as JPluginHelper;
use Joomla\Registry\Registry as JRegistry;
use Joomla\CMS\Form\Field\ListField as JFormFieldList;
use \Joomla\CMS\Form\FormField as JFormField;
use Joomla\CMS\Language\Text as JText;
use Joomla\CMS\HTML\HTMLHelper as JHtml;
use Joomla\CMS\Factory as JFactory;

use Joomla\CMS\Helper\ModuleHelper as JModuleHelper;
use Joomla\CMS\Layout\LayoutHelper as JLayoutHelper;
use Joomla\CMS\Layout\FileLayout as JLayoutFile;
use \Joomla\CMS\Version as JVersion;
use Joomla\CMS\Form\Form as JForm;
use Joomla\CMS\Language\Language as JLanguage;

class VersionField extends JFormField{
//class JFormFieldVersion extends JFormField  {
	
//	public $fieldname = '';
//	public $name = '';
	
	public $version = '';
	public $creationDate = '';
	public $modificationDate = '';
	public $modificationsDate = '';
	public $author = '';
	public $authorEmail = '';
	public $copyright = '';
	public $maintainerurl = '';
	
//	<version>5.2</version>
//	<name>Jshopping-PlaceBilet</name>
//	<license>GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html</license>
//	<creationDate>2018-06-01</creationDate>
//	<modificationDate>2024-08-16</modificationDate>
//	<modificationsDate>2023-07-18,2024-06-19,2024-08-16</modificationsDate>
//	<author>Korenevskiy Sergei Borisovich</author>
//	<authorEmail>korenevskiys@ya.ru</authorEmail>
//	<authorUrl>http://explorer-office.ru/download</authorUrl>
//	<copyright>Copyright (C) Explorer-Office</copyright>
//	<maintainerurl>https://t.me/placebilet</maintainerurl>

	
//	public function setup(\SimpleXMLElement $element, $value, $group = null) {
//		
////JFactory::getApplication()->enqueueMessage("<h1>3 ".$element->getName()."</h1>");
//        // Make sure there is a valid FormField XML element.
//
//		
//        $this->element = $element;
//JFactory::getApplication()->enqueueMessage("<h1>2 $this->name</h1>");
//JFactory::getApplication()->enqueueMessage("<h1>1 $this->fieldname</h1>");
//$this->hidden = true;
//		return true; 
//	}
		
	protected function getInput() {
		
//JFactory::getApplication()->enqueueMessage("<h1>3 $this->name</h1>");
//JFactory::getApplication()->enqueueMessage("<h1>4 $this->fieldname</h1>");
		$ext = '';
		$path = dirname(__DIR__);
		
		$isComponents	= strpos($path, '/components/');
		$isModules		= strpos($path, '/modules/');
		$isPlugins		= strpos($path, '/plugins/');
		
		if($isPlugins){
			$last	= strpos($path, '/', $isModules + 9);
			$ext	= substr($path, $isModules + 9, $last - $isModules - 9);
			$path	= substr($path, 0, $last);
		}
		if($isModules){
			$last	= strpos($path, '/', $isModules + 9);
			$ext	= substr($path, $isModules + 9, $last - $isModules - 9);
			$path	= substr($path, 0, $last);
		}
		if($isComponents){
			$last	= strpos($path, '/', $isModules + 12);
			$ext	= substr($path, $isModules + 12, $last - $isModules - 12);
			$path	= substr($path, 0, $last);
		}
		
		$xml = '';
		
		
		if(file_exists($path . '/' . $ext . '.xml')){
			$xml = simplexml_load_file($path . '/' . $ext . '.xml');
		}
		
		if(file_exists($path . '/manifest.xml')){
			$xml = simplexml_load_file($path . '/manifest.xml');
		} 
		
		if($xml){
			foreach ($xml->children() as $k => $child) {
				$name = $child->getName();
				if(property_exists($this, $child->getName()))
					$this->$name = (string)$child;
			}
		}

		$format = (string)($this->element['format'] ?? '');
//JFactory::getApplication()->enqueueMessage($html);
//return "<pre>123</pre>";
		if($format){
			
			foreach (get_object_vars($this) as $prop => $value){
				$format = str_replace($prop, $value, $format);
			}
			return "<pre style='font-size:small'>$format</pre>";
		}
		
		$html = "<code style='font-size:small'>$this->version / $this->copyright </code>";
		
		if($this->maintainerurl)
			$html .= "<a href='$this->maintainerurl' target='_blank'>$this->maintainerurl</a>";
		if($this->authorUrl)
			$html .= "<a href='$this->authorUrl' target='_blank'>$this->authorUrl</a>";
		
		return $html;
		
//		\Joomla\Component\Content\Site\Model\FormModel::getInstance($xml);
		
//JFactory::getApplication()->enqueueMessage("<pre>\$path:".' '. print_r($path,true)."</pre>");
//JFactory::getApplication()->enqueueMessage("<pre>\$path:".' '. print_r($path . '/' . $ext . '.xml',true)."</pre>");
		
		return $html;
	}
	
	
	public function getLabel() {
		return JText::_('JVERSION');
	}
	public function getTitle() {
		return '';
	}
	public function getId($fieldId, $fieldName) {
		return '';
	}
}