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
defined('_JEXEC') or die;
jimport('joomla.form.formfield');
//https://docs.joomla.org/Category:Standard_form_field_types
//https://docs.joomla.org/Text_form_field_type
//https://docs.joomla.org/Text_form_field_type/3.2
//https://docs.joomla.org/Standard_form_field_types

use \Joomla\CMS\Form\FormField as JFormField;

//$path = JPATH_PLUGINS.'/jshopping/placebilet';
//JFactory::getApplication()->getLanguage()->load('plg_jshopping_PlaceBilet', $path); 
//	JFactory::getLanguage()->load('PlaceBilet', $path, NULL, TRUE);
//JFactory::getLanguage()->load('plg_jshopping_PlaceBilet', $path, NULL, TRUE);
//	JFactory::getLanguage()->load('PlaceBilet', $path, 'ru-RU', TRUE);

//if(file_exists(JPATH_PLUGINS.'/jshopping/placebilet/Addons/Zriteli.php'))   require_once (JPATH_PLUGINS.'/jshopping/placebilet/Addons/Zriteli.php');
//        $path = JPATH_PLUGINS.'/jshopping/placebilet';            
//	$language = JFactory::getLanguage();
//        $language->load('PlaceBilet', $path, 'ru-RU', TRUE);
//        $language->load('PlaceBilet', $path, 'ru-RU', TRUE);
//        $language->load('plg_jshopping_PlaceBilet', $path, 'ru-RU', TRUE);
//        toPrint($language);
//        toLog($language);

class JFormFieldExtIp extends JFormField {

  protected $type = 'ExtIp';
  public $params = NULL;
  
  protected function getInput(){
        
      
$myip = file_get_contents('http://www.vanhost.ru/my_ip');
        
        //$value  = empty($this->value) ? 0 : $this->value;  
        //$html = JHTML::_('select.genericlist', $categories,$this->name,'class="inputbox chzn-custom-value"   ','id','title',$value);
        return "<input type=\"text\" name=\"jform[params][myip]\" readonly =\"readonly\" id=\"jform_params_myip\" "
        . "value=\"$myip\" zoompage-fontsize=\"16\">";
        //toLog($html);
  }
}
?>