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

use Joomla\CMS\Factory as JFactory;
use Joomla\CMS\Language\LanguageHelper as JLanguageHelper;
use Joomla\CMS\Form\FormField as JFormField;
use \Joomla\CMS\Language\Text as JText;
use \Joomla\CMS\HTML\HTMLHelper as JHtml;
use Joomla\Component\Jshopping\Site\Lib\JSFactory;

//$path = JPATH_PLUGINS.'/jshopping/placebilet';
//JFactory::getApplication()->getLanguage()->load('plg_jshopping_PlaceBilet', $path); 
//JFactory::getLanguage()->load('plg_jshopping_PlaceBilet', $path, NULL, TRUE);
//JFactory::getLanguage()->load('PlaceBilet', $path, NULL, TRUE);
//toPrint(JFactory::getLanguage(),'',0,true,true);
//JFactory::getLanguage()->load('PlaceBilet', $path, 'ru-RU', TRUE);

//if(file_exists(JPATH_PLUGINS.'/jshopping/placebilet/Addons/Zriteli.php'))   require_once (JPATH_PLUGINS.'/jshopping/placebilet/Addons/Zriteli.php');
//        $path = JPATH_PLUGINS.'/jshopping/placebilet';            
//	$language = JFactory::getLanguage();
//        $language->load('PlaceBilet', $path, 'ru-RU', TRUE);
//        $language->load('PlaceBilet', $path, 'ru-RU', TRUE);
//        $language->load('plg_jshopping_PlaceBilet', $path, 'ru-RU', TRUE);
//        toPrint($language);
//        toLog($language);

class JFormFieldCategories extends JFormField {

  protected $type = 'Categories';
  public $params = 'Categories';
  
 
  
  protected function getInput(){
      
//    define('DS', DIRECTORY_SEPARATOR);
//        require_once (JPATH_PLUGINS . '/jshopping/placebilet/src/Lib/SoapClientZriteli.php');
        
//        require_once (JPATH_SITE.DIRECTORY_SEPARATOR
//                .'components'.DIRECTORY_SEPARATOR
//                .'com_jshopping'.DIRECTORY_SEPARATOR
//                .'lib'.DIRECTORY_SEPARATOR.'factory.php');
      
        
//		$place_old = $this->form->getData()->toObject(); // = new \Joomla\CMS\Form\Form($name);
//		var_dump($place_old);
                
        //jimport( 'joomla.registry.registry' );
        //jimport( 'joomla.registry.format' ); 
           //$lang = JSFactory::getLang();
//           $lang = JFactory::getLanguage();
        $tag = JFactory::getLanguage()->getTag();
        $query = " SELECT CONCAT(category_id,'-',category_parent_id) val,category_id id, category_parent_id parent, CONCAT('id:',category_id,' ', `name_$tag`) title "
               . " FROM #__jshopping_categories WHERE category_parent_id = 0 ; ";//CONCAT_WS   ".$lang->get('name')."
        
        
        //toLog($query);
//        toPrint($query);
        $categories = JFactory::getDBO()->setQuery($query)->loadObjectList();
         
        //toPrint($categories); 
        //$this->params->loadJSON($params);
//        $params = $this->params;
        
//        toLog($categories);
//        toPrint($categories);
//        return '';
                
//        $params = json_decode($params);
//        $this->params = new JObject();
//        $this->params->setProperties($params);
        
//        echo "<pre>\$params: ".count($params)."<br>";
//        print_r($params);
//        echo "  </pre>";
        //return;
        
 
        //ksort($allStages);
//        echo "<pre>error: ".print_r(array_pop(SoapClientZriteli::$Errors),true)."<bt>";
//        //print_r($this);
//        echo "  </pre>";   
//        echo "<pre>AllStages: ".count($allStages)."<bt><table>";
//        foreach ($allStages as $k => $s){
////            if(!isset($s['title']))
////                $s['title'] = $s['Name'];
//            echo "<tr><td style='width: 40px;'>$k</td><td>".(isset($s['title'])?$s['title']:print_r($s,true))."</td></tr>";//".print_r($s,true)."
//        }
//        echo "  </table></pre>";      
        
        
//        return ;
//        echo "<pre>AllStages: ".count($allStages)."<br>";
//        print_r($allStages);
//        echo "  </pre>";  
        
//         echo "<pre>Errors: ".count(SoapClientZriteli::$Errors)."<bt>";
//        //print_r($this);
//         echo "  </pre>";          
      
        $notCategory = new stdClass();
        $notCategory->id=0;
        $notCategory->val=0;
        $notCategory->title= JText::_('JOPTION_DO_NOT_USE');// ' -- CategoriesAlls -- ';
        array_unshift($categories,$notCategory);
        //JFactory::getApplication()->enqueueMessage(print_r($query,true));
        //JEMPTY 
            
        
//        echo "<br><pre>\$this: <br>".print_r($this,true)."<bt>";
//        //print_r($this);
//        echo "  </pre>";  
//        toPrint($categories);
        $value  = empty($this->value) ? 0 : $this->value;  
        $html = JHtml::_('select.genericlist', $categories,$this->name,['class'=>' inputbox chzn-custom-value form-control form-select'],'val','title',$value);
        return $html;
        //toLog($html);
  }
}
?>