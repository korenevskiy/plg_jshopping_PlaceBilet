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
use Joomla\CMS\Language\LanguageHelper as JLanguageHelper;
use Joomla\CMS\Form\FormField as JFormField;

//use Joomla\CMS\Form\Field\SpacerField as JFormFieldSpacer;

defined('_JEXEC') or die;
jimport('joomla.form.formfield');
//https://docs.joomla.org/Category:Standard_form_field_types
//https://docs.joomla.org/Text_form_field_type
//https://docs.joomla.org/Text_form_field_type/3.2
//https://docs.joomla.org/Standard_form_field_types


//toPrint('WOW','',0,'pre',true);
//                 JFactory::getLanguage()->load($extension)
//				$lang      = JFactory::getLanguage()->getPaths();//'Plg_' . $this->_type . '_' . $this->_name


//$path = JPATH_PLUGINS.'/jshopping/PlaceBilet/';
//JFactory::getApplication()->getLanguage()->load('plg_jshopping_PlaceBilet', $path, NULL, TRUE); 
//$path = JPATH_PLUGINS.'/jshopping/PlaceBilet/language/';
//JFactory::getApplication()->getLanguage()->load('', $path, NULL, TRUE); 
//echo "<pre>".print_r($path,true)."</pre>";
//echo "<pre>".print_r(JFactory::getApplication()->getLanguage(),true)."</pre>";
//JFactory::getApplication()->getLanguage()->load('ru-RU.PlaceBilet', $path);
//JFactory::getApplication()->getLanguage()->load('plg_jshopping_PlaceBilet', $path, 'ru-RU', TRUE);
//JFactory::getApplication()->getLanguage()->load('ru-RU.plg_jshopping_PlaceBilet', $path, 'ru-RU', TRUE);
//toPrint(JFactory::getApplication()->getLanguage(),'',0,'Message',true);
//$path = JLanguageHelper::getLanguagePath($path, 'ru-RU');
////echo "<pre>$path</pre>";
//$path1 =JFactory::getApplication()->getLanguage()->getPaths('Plg_jshopping_PlaceBilet');
//echo "<pre>".print_r($path1,true)."</pre>";
//$path1 =JFactory::getApplication()->getLanguage()->getPaths('ru-RU.PlaceBilet');
//echo "<pre>".print_r($path1,true)."</pre>";

//		echo JText::_('JSHOP_OLD_CAT_DESC');
//toPrint($path,'',0,true,true);
//toPrint(JFactory::getApplication()->getLanguage(),'',0,true,true);

//	JFactory::getLanguage()->load('PlaceBilet', $path, 'ru-RU', TRUE);

//if(file_exists(JPATH_PLUGINS.'/jshopping/PlaceBilet/Addons/Zriteli.php'))   require_once (JPATH_PLUGINS.'/jshopping/PlaceBilet/Addons/Zriteli.php');
//        $path = JPATH_PLUGINS.'/jshopping/PlaceBilet';            
//	$language = JFactory::getLanguage();
//        $language->load('PlaceBilet', $path, 'ru-RU', TRUE);
//        $language->load('PlaceBilet', $path, 'ru-RU', TRUE);
//        $language->load('plg_jshopping_PlaceBilet', $path, 'ru-RU', TRUE);
//        toPrint($language);
//        toLog($language);

JFormHelper::loadFieldClass('spacer');
    
//namespace Joomla\CMS\Form\Field {
//if(!class_exists('\\Joomla\\CMS\\Form\\Field\\SpacerField')){ // \\Joomla\\CMS\\Form\\Field   
//    class SpacerField extends JFormFieldSpacer {//Joomla\CMS\Form\Field
//        
//    }
//}   
//}
        
class JFormFieldDesc extends JFormFieldSpacer //FOFFormFieldSpacer JFormFieldSpacer //JFormField  // Joomla\CMS\Form\Field //Joomla\CMS\Form\Field\SpacerField
{
    
	/**
	 * The form field type.
	 *
	 * @var    string
	 * @since  11.1
	 */
    protected $type = 'Desc';

    public $params = NULL;
  
 
  
/**
	 * Method to get the field label markup for a spacer.
	 * Use the label text or name from the XML element as the spacer or
	 * Use a hr="true" to automatically generate plain hr markup
	 *
	 * @return  string  The field label markup.
	 *
	 * @since   11.1
	 */
    protected function getLabel()
    { 
		
		$this->params = $this->form->getData();// ->toObject() // = new \Joomla\CMS\Form\Form($name);
		
//        echo "<pre>\$this  <br>".print_r($this,true)."</pre>";
//        echo "<pre>\$this->value  <br>".print_r($this->value,true)."</pre>";
        $type = $this->type;
        $name = $this->fieldname;
        $value = $this->value ;
        $value = (string)$value;$f=4;$x=8;
        $id = $this->id;$s='7';$z='0';
        $class = $this->class; 
            
        $sfx = ''; 
        switch ($value){
            case "377219944$f": $sfx='_DEMO'; break;
            case "424591883$s": $sfx='_PRO';break;
            case "360567426$z": $sfx='_FULL';break;
            case "400835064$x": $sfx='_TEST';break;
            
            case "27464{$f}4292": $sfx='_D';break;
            case "31107150{$z}1": $sfx='_P';break;
            case "13{$z}4234792": $sfx='_F';break;
            case "31{$x}7964512": $sfx='_T';break;
            case "35685{$x}9458": $sfx='_E';break;
            default: $value="377219944$f"; $sfx='_DEMO'; break;
        }
            
            
	$html = [];

	// Get the label text from the XML element, defaulting to the element name.
	$text = $this->element['label'] ? (string) $this->element['label'] : (string) $this->element['name'];
        $text .= $sfx;

	// Build the class for the label. 
        if($this->description) $class .= ' hasTooltip';
	if($this->required)  $class .= ' required';
	if($this->class)  $class = " class=\"$class\" " ;
	if($this->translateLabel)  $text =  \JText::_($text);
        $sfx == '_E' && ($text = '');        
        $tooltip = $this->description ? ' title="' . \JHtml::_('tooltipText', '', \JText::_($this->description), 0) . '"' : '';
            
	$html[] = "<span class=\"$type\">";
	$html[] = '<span class="before"></span>';
	$html[] = '<span' . $class . '>';     
	$html[] = "<label id=\"$id-lbl\" $class $tooltip>$text</label>"; 
	$html[] = '</span>';
	$html[] = '<span class="after"></span>';
	$html[] = '</span>';
        $html[] = "<hr>";
        $sfx == '_E' && ($html = []);
        $html[] = "  "
                        . "<input type=\"hidden\" name=\"$this->name\" class=\" fide hide hiden hidden\"  id=\"$this->id\" "
        . "value=\"$value\" zoompage-fontsize=\"16\" default=\"$value\">";

		return implode('', $html);
    }
  
}
?>