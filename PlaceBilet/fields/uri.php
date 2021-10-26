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
use Joomla\CMS\Factory as JFactory;

defined('_JEXEC') or die;
jimport('joomla.form.formfield');
//https://docs.joomla.org/Category:Standard_form_field_types
//https://docs.joomla.org/Text_form_field_type
//https://docs.joomla.org/Text_form_field_type/3.2
//https://docs.joomla.org/Standard_form_field_types


//if(file_exists(JPATH_PLUGINS.'/jshopping/PlaceBilet/Addons/Zriteli.php'))   require_once (JPATH_PLUGINS.'/jshopping/PlaceBilet/Addons/Zriteli.php');

$path = JPATH_PLUGINS.'/jshopping/PlaceBilet';
JFactory::getApplication()->getLanguage()->load('plg_jshopping_PlaceBilet', $path); 
//JFactory::getLanguage()->load('PlaceBilet', $path, NULL, TRUE);         
//JFactory::getLanguage()->load('plg_jshopping_PlaceBilet', $path, NULL, TRUE); 
//	JFactory::getLanguage()->load('PlaceBilet', $path, 'ru-RU', TRUE);
//        $language->load('PlaceBilet', $path, 'ru-RU', TRUE);
//        $language->load('plg_jshopping_PlaceBilet', $path, 'ru-RU', TRUE);
//        toPrint($language);
//        toLog($language);

class JFormFieldDomen extends JFormField {

  protected $type = 'Domen';
  public $params = 'Domen';
  
 
  
  protected function getInput(){
        
      
//    define('DS', DIRECTORY_SEPARATOR);
        
      $html = $_SERVER['REQUEST_SCHEME']."://".$_SERVER['HTTP_HOST'];//JUri::root();
      //$html = JHTML::_('input.hidden', 'domen', $html, 'domen');
        //$html = JHTML::_('input.text', 'domen', $html, ['class'=>'readonly'], '');
      
      $html = "<input type=\"text\" name=\"jform[params][domen]\" value=\"$html\" id=\"domen\" readonly disabled class=\"readonly\"/> ";
      
        return $html;
        //toLog($html);
  }
}
?>