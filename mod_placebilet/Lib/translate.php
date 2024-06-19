<?php defined('_JEXEC') or die;
/**------------------------------------------------------------------------
 * field_cost - Fields for accounting and calculating the cost of goods
 * ------------------------------------------------------------------------
 * author    Sergei Borisovich Korenevskiy
 * Copyright (C) 2010 www./explorer-office.ru. All Rights Reserved.
 * @package  mod_multi_form
 * @license  GPL   GNU General Public License version 2 or later;
 * Websites: //explorer-office.ru/download/joomla/category/view/1
 * Technical Support:  Forum - //fb.com/groups/multimodule
 * Technical Support:  Forum - //vk.com/multimodule
 */

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

class JFormFieldTranslate extends JFormField  {

	public function __construct($form = null) {
		parent::__construct($form);

		$this->file = '';

		$this->path = dirname(__DIR__.'/');

		$option1 = basename(dirname(dirname(dirname(__DIR__))));
		$option2 = basename(dirname(dirname(__DIR__)));
		$option3 = basename(dirname(__DIR__));

		if($option2 == 'components')
			$this->file = $option3;
		if($option2 == 'modules')
			$this->file = $option3;
		if($option1 == 'plugins')
			$this->file = 'plg_'.$option2.'_'.$option3;

	}

	public function setup(\SimpleXMLElement $element, $value, $group = null) {

		$this->element = $element;

		if($element['path']){
			$this->path = (string)$element['path'];

			$option1 = basename(dirname(dirname(dirname($this->path))));
			$option2 = basename(dirname(dirname($this->path)));
			$option3 = basename(dirname($this->path));

			if($option2 == 'components')
				$this->file = $option3;
			if($option2 == 'modules')
				$this->file = $option3;
			if($option1 == 'plugins')
				$this->file = 'plg_'.$option2.'_'.$option3;
		}

		if($element['file'])
			$this->file =  (string)$element['file'];

		if($element['option'])
			$this->file =  (string)$element['option'];

		if(str_ends_with($this->file, '.ini'))
			$this->file = substr($this->file, 0, -4);

		$this->path = rtrim($this->path,'/');

		if(str_ends_with($this->path, '/language'))
			$this->path = substr($this->path, 0, -9);

		$lang = JFactory::getApplication()->getLanguage();

		$lang->load($this->file, $this->path);
		$lang->load($this->file, $this->path.'/language');
		$lang->load($this->file, JPATH_SITE);
		$lang->load($this->file, JPATH_ADMINISTRATOR);

		$pathsOption = $lang->getPaths($this->file);
		
		
//if(file_exists(JPATH_ROOT . '/functions.php'))
//	require_once  JPATH_ROOT . '/functions.php';
 
//toPrint($pathsOption,'$pathsOption',0,'pre',true);

//foreach ($pathsOption as $path => $is){
//	toPrint($path,'$pathsOption:'. (file_exists($path)).'='.($is),0,'pre',true);
//}
//
//toPrint(\Joomla\CMS\Language\LanguageHelper::parseIniFile(__DIR__ . '/../language/ru-RU/mod_multi_form.ini', true),'parseIniFile',0,'pre',true);
//toPrint(file_exists(__DIR__ . '/../language/ru-RU/mod_multi_form.ini'),'parseIniFile',0,'pre',true);
//\Joomla\Language\Language::parseLanguageFiles(__DIR__ . '/../language/ru-RU/'); 
//(new \Joomla\Language\LanguageHelper)->parseLanguageFiles(__DIR__ . '/../language/ru-RU/');
//toPrint((new \Joomla\Language\LanguageHelper)->parseLanguageFiles(__DIR__ . '/../language/ru-RU/'),'LanguageHelper',0,'pre',true);

		return true;
	}

	public $path = '';

	public $file = '';
	
	public $fieldname = '';

	public function getInput() {
		return '';
	}
	public function getLabel() {
		return '';
	}
	public function getTitle() {
		return '';
	}
	public function getId($fieldId, $fieldName) {
		return '';
	}
}
