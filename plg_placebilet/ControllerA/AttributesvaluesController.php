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

namespace Joomla\Component\Jshopping\Administrator\Controller;

defined('_JEXEC') or die();
jimport('joomla.application.component.controller');



use \Joomla\CMS\Factory as JFactory;
use \Joomla\Component\Jshopping\Administrator\Controller\AttributesValuesController; //JshoppingControllerAttributesvalues
use \Joomla\Component\Jshopping\Site\Lib\JSFactory;
use \Joomla\CMS\Language\Text as JText;
 

 
class AttributesvaluesModController extends AttributesvaluesController{ // JshoppingControllerAttributesvalues_mod

	function getFactory(){
		return $this->factory;
	}
	function setFactory($factory = null){
		if($factory)
			$this->factory = $factory;
	}

// Член требуемый для J4, для совместимости J3 отключен, но компенсируется $config['default_view'] в конструкторе
	protected $name = 'Attributesvalues';
	
//	protected $default_view = 'Attributesvalues';
	
	function __construct($config = array(), \Joomla\CMS\MVC\Factory\MVCFactoryInterface $factory = null, $app = null, $input = null){
        $this->nameModel = 'attributesvalues';
		
//		$config['default_view'] = 'Attributesvalues';
		
        parent::__construct($config, $factory, $app, $input); 
        
//        echo "<pre>ControllerAttributesValues_mod: ";
//        var_dump($this->get('taskMap'));
//        echo "</pre>"; 
        $this->registerTask( 'add',   'edit' );
        $this->registerTask( 'apply', 'save' );
        $this->registerTask( 'show', 'display' );
        
		
		
        checkAccessController("attributesvalues_mod");
    }
    function display($cachable = false, $urlparams = false){
		
		//	[{id,language=en-GB,name=English,publish=1,ordering=0,lang=en},...]
		$languages = JSFactory::getModel("languages")->getAllLanguages(0);	
		
//        $jshopConfig = JSFactory::getConfig(); 
//		$jshopConfig->getFrontLang();				//joomla Front lanugage
//		$jshopConfig->defaultLanguage;				//defaultLanguage
		
//		$jshopConfig->loadLang(); 
//		\JFactory::getLanguage()->getTag();
    
		$langFront = \JComponentHelper::getParams('com_languages')->get('site', 'en-GB');
		
//toPrint();
//toPrint($jshopConfig->getFrontLang(),'->getFrontLang()',0,'message',true);
//toPrint($jshopConfig->defaultLanguage,'->defaultLanguage',0,'message',true);
//toPrint($langFront,'$langFront',0,'message',true);
		
		
        //parent::display($cachable = false, $urlparams = false);
        if(\PlaceBiletHelper::JInput()->getCmd("attr_id")==""){
			JError::raiseError( 403, JText::_('JSHOP_NOT_SELECTED_ATRIBUTE') );
			$this->setRedirect("index.php?option=com_jshopping&controller=attributes", JText::_('JSHOP_NOT_SELECTED_ATRIBUTE'));
			return;                
        }   
        
        $attr_id = \PlaceBiletHelper::JInput('attr_id');
        $jshopConfig = \JSFactory::getConfig();
        $nameLang = \JSFactory::getLang()->get("name"); 
        
                $attribut = \JSFactory::getTable('attribut'); 
                $attribut->load($attr_id);
                $attr_name = $attribut->$nameLang;
                 
                if($attribut->attr_admin_type !=4){
                    parent::display($cachable, $urlparams);
                    return;
                }
                
                
                
                $attributGroup = \JSFactory::getTable('attributesgroup', 'jshop'); 
                $attributGroup->load($attribut->group); 
                $group_name = $attributGroup->$nameLang;
        
        $mainframe = JFactory::getApplication();
        $context = "jshoping.list.admin.attr_values";
        $filter_order = $mainframe->getUserStateFromRequest($context.'filter_order', 'filter_order', "value_ordering", 'cmd');
        $filter_order_Dir = $mainframe->getUserStateFromRequest($context.'filter_order_Dir', 'filter_order_Dir', "asc", 'cmd');
        
		$attributValues = JSFactory::getModel("AttributValue");
		$rows = $attributValues->getAllValues($attr_id, $filter_order, $filter_order_Dir);
                 
//                $attribut = JSFactory::getModel("attribut");
//		$attr_name = $attribut->getName($attr_id);
          
//toPrint(null,'<style>.debug{grid-area: content;margin-left: 0px;}</style>',0,'',false);
//toPrint($rows,'$rows',0,'message',true);

		
        //if(PlaceBiletAdminDev)JFactory::getApplication()->enqueueMessage("<pre>Task!!!: \t".print_r($attributGroup)."</pre>");
                
        $items = array();
        $itemsInt = array();
        $itemsStr = array();
$debugs = '';
        
        foreach ($rows as $row)
        {
            $key =  ($row->name); 
$debugs .= "|$key|";
            if(is_numeric($key)) {
                $itemsInt[$key] = $row;  
            } else{ 
                $itemsStr[$key] = $row;
            }     
            
            $items[$key] = $row;
        }
        
        ksort($items);
        ksort($itemsInt);
        ksort($itemsStr);
        
		/* Массив сгруппированных массиов по группам подрят идущих мест. */
        $tuple= array();
		
		/* Номер сравнения подрят идущих цифр мест */
		$number = 0;
		if($itemsInt)
			$number = reset($itemsInt)->name;//key
		/* Индекс массива для груп подрят идущих мест. */
        $carriage = 0;
//toPrint($i,'$i',0,'message',true);
 
		/* Группировка списка мест по группам в каждой которой места идут подрят. */
        foreach ($itemsInt as $item)
        {
            if($number != $item->name)
                ++$carriage;
          
            $tuple[$carriage][$item->name] = $item;
            
            $number = $item->name + 1;
        }
        
        
//toPrint($debugs,'$debugs');
//toPrint($rows,'$rows');
//toPrint($i,'$i',0,'message',true);
//toPrint($itemsInt,'$itemsInt',0,'message',true);
//toPrint($tuple,'$tuple',0,'message',true);
//toPrint($itemsInt,'$itemsInt',5);
//toPrint($tuple,'tuples',0);
        
        $tuples= array();
        
        foreach ($tuple as $tup)
        {
            $item = new \stdClass();
            $item->tuple = $tup;
            $item->count = count($tup);
            $item->separate = " - ";
            reset($tup);
            $item->first = current($tup);
            $item->last = end($tup);
            reset($tup);
            if($item->count>1){
                $item->name = ($item->first->name).($item->separate).($item->last->name);
            }
            else {
                $item->name = $item->first->name;
            }
            $tuples[$item->name] = $item;
        }
//"C:\Users\Sergei\AppData\Roaming\NetBeans\8.1\config\Databases\SQLCommands\SQL 3.sql"
        //$view = $this->getView($viewName, 'html', '', array('base_path' => PlaceBiletPathAdmin, 'layout' => $viewLayout));
        //$view = $this->getView($viewName, 'html', '', array('base_path' => PlaceBiletPathAdmin));
//        $view = $this->getView('Attributesvalues', 'html');
		
        $this->paths['view'][] = JPATH_COMPONENT_ADMINISTRATOR.'/View/';
		
        $document = $this->app->getDocument();
        $viewType = $document->getType();
        $viewName = $this->input->get('view', $this->default_view);
        $viewLayout = $this->input->get('layout', 'default', 'string');
//        $view = $this->getView($viewName, $viewType, '', array('base_path' => $this->basePath, 'layout' => $viewLayout));


//$deb_tr = debug_backtrace();
//if(count($deb_tr)==1)
//	$_method = $_file = $deb_tr[0];  
//else
//	list($_file,$_method) = $deb_tr;
//$paths = explode(DS, $_file['file']) ; 
//$head = "<br><span style='opacity:0.2'>".ucfirst($_method['class']??'').ucfirst($_method['type']??'').ucfirst($_method['function']??'')                    //.ucfirst($_file['line']).ucfirst($_file['file']).ucfirst($_file['args']); 
//	. "() /".(implode ('/', array_slice($paths,-6))) .' ('.($_file['line']??'') .')</span><br>'.$head; // basename($_file['file']??'')
//toPrint($head,'AttributesValuesCotntroller--------------------------' ,0,'message',true);

////'Joomla\\Component\\Jshopping\\Administrator\\View\\Attributesvalues\\HtmlView'

//class name Joomla\Component\Jshopping\Administrator\View\Jshopping\HtmlView
//class name Joomla\Component\Jshopping\Administrator\View\Product_list\HtmlView;
//class name Joomla\Component\Jshopping\Administrator\View\Attributesvalues\HtmlView;
//toPrint($this->default_view,'$this->default_view:' ,0,'message',true);
//toPrint($viewName,'$viewName:' ,0,'message',true);
//toPrint(get_class($this->mvcFactory),'dispatch() -Factory',0,'message',true); 
//		return "TEST BAD!!";

//toPrint($attr_id,'$attr_id',0,'message',true);
        $view = $this->getView($viewName, $viewType, '', array('base_path' => JPATH_COMPONENT_ADMINISTRATOR, 'layout' => $viewLayout));
//        $view = $this->getView($viewName, $viewType, '', array('base_path' => JPATH_COMPONENT_ADMINISTRATOR, 'layout' => $viewLayout));
//        $view = $this->getView('Attributesvalues', 'html', '', array('base_path' => JPATH_COMPONENT_ADMINISTRATOR.'/View/'));
//        $view = $this->getView('attributesvalues', 'html', 'Administrator', array('base_path' => PlaceBiletPathAdmin));
        //$view->setLayout("product_default");//Имя файла
        $view->addTemplatePath(PlaceBiletPath.'/templatesA/attributesvalues/'); //Новый шаблон 
//    if(PlaceBiletAdminDev) JFactory::getApplication()->enqueueMessage("<pre>Task!!!: \t".print_r($view->get('_path'))."</pre>");
        $view->sidebar = \JHtmlSidebar::render();
        $view->set('tuples', $tuples);      
        $view->set('itemsStr', $itemsStr);      
        $view->set('attr_name', $attr_name);   
        $view->set('group_name', $group_name);   
        $view->set('attr_id', $attr_id);
//        $view->attr_id = $attr_id;
        $view->set('config', $jshopConfig);
        $view->set('languages', $languages);
        $view->set('filter_order', $filter_order);
        $view->set('filter_order_Dir', $filter_order_Dir);   
        $view->display(); 
//        echo "<pre>IsController: ";
//            var_dump($this);
//        echo "</pre>"; 
//        echo "<pre>IsView: ";
//            var_dump($view);
//        echo "</pre>"; 
        
        
    }
    
    function remove(){// недействительный метод
//		$cid = \PlaceBiletHelper::JInput("cid") ;        
//		$dispatcher = \JFactory::getApplication();	
//		$model = JSFactory::getModel("attribut");
//        
//            $dispatcher->triggerEvent('onBeforeRemoveAttribut', array(&$cid));
//        
//		$text = '';
//		foreach($cid as $key => $value){            
//			$model->delete(intval($value));
//            $text = __('JSHOP_ATTRIBUT_DELETED');
//		}
//        
//            $dispatcher->triggerEvent('onAfterRemoveAttribut', array(&$cid));
        
        $this->setRedirect("index.php?option=com_jshopping&controller=attributes", $text);
    }
            
    function AddsRange(){
            $attr_id = \PlaceBiletHelper::JInput("attr_id") ;  
            $places = \PlaceBiletHelper::JInput("PlacesRangeAdd");
            
            //if(PlaceBiletAdminDev)JFactory::getApplication()->enqueueMessage("Places: ".print_r($places, TRUE));
            
            
            $arr = \PlaceBiletHelper::getArrayFromString($places);
        $count = count($arr);    
        
        
        
        
            if($arr == '' || (count($arr)==0)){
                JError::raiseError( 403, JText::_('JSHOP_NOT_SELECTED_STRING') );
                $this->setRedirect("index.php?option=com_jshopping&controller=attributes", JText::_('JSHOP_NOT_SELECTED_STRING'));
                return;
            }                
            $query = \PlaceBiletHelper::PlacesAttrValueArrayAdd($attr_id, $arr);
            
            
            
            //if(PlaceBiletAdminDev)JFactory::getApplication()->enqueueMessage("AddsRange: ".print_r($places, TRUE));
            //if(PlaceBiletAdminDev)JFactory::getApplication()->enqueueMessage("AddsRange: ".print_r($arr, TRUE));
            //if(PlaceBiletAdminDev)JFactory::getApplication()->enqueueMessage("<pre>Query: \t".$query."</pre>");//Warning,Error,Notice,Message
            unset($query);
        $this->setRedirect("index.php?option=com_jshopping&controller=attributesvalues&attr_id=$attr_id", JText::_('JSHOP_ADDED_SEATS_1').$count.JText::_('JSHOP_ADDED_SEATS_2'). $places.JText::_('JSHOP_ADDED_SEATS_3'));
    }
    
    function AddString(){
		$attr_id = \PlaceBiletHelper::JInput("attr_id") ;  
		$places = \PlaceBiletHelper::JInput("PlacesStringAdd") ;
//		$places = trim($places);
//		$places = JFactory::getApplication()->input->get("PlacesStringAdd");



toPrint();
toPrint($places,'$places',0,'message',true);
//toPrint($input->get("PlacesStringAdd"),'$input->get(PlacesStringAdd)',0,'message',true);
//$input = new \Joomla\Input\Input();
//$input->get("PlacesStringAdd");


//toPrint($input->getArray(["PlacesStringAdd"=>'STRING']),'$input->getArray(["PlacesStringAdd"=>STRING])',0,'message',true);

//toPrint($_SERVER['PlacesStringAdd'],'$places',0,'message',true);
//toPrint(JFactory::getApplication()->input,'JFactory::getApplication()->input',0,'message',true);
//$this->setRedirect("index.php?option=com_jshopping&controller=attributesvalues&attr_id=$attr_id", JText::_('JSHOP_ADDED_SEATS_1').$count.JText::_('JSHOP_ADDED_SEATS_2'). $places.JText::_('JSHOP_ADDED_SEATS_3'));
//return;

            
		$query = \PlaceBiletHelper::PlacesAttrValueStringAdd($attr_id, $places);
		//if(PlaceBiletAdminDev)JFactory::getApplication()->enqueueMessage("AddsRange: ".print_r($places, TRUE));
		//if(PlaceBiletAdminDev)JFactory::getApplication()->enqueueMessage("<pre>Query: \t".$query."</pre>");//Warning,Error,Notice,Message
		unset($query);
		
		$count = '1';
			 
        $this->setRedirect("index.php?option=com_jshopping&controller=attributesvalues&attr_id=$attr_id", JText::_('JSHOP_ADDED_SEATS_1').$count.JText::_('JSHOP_ADDED_SEATS_2'). $places.JText::_('JSHOP_ADDED_SEATS_3'));
    }
	
//	function AddCount(){
//		$attr_id = \PlaceBiletHelper::JInput("attr_id") ;
//		$placeCountName = \PlaceBiletHelper::JInput('PlacesCountStrAdd') ;
//		
//		$placeCountName = trim($placeCountName);
//		
//		$count = ' 0 ';
//		
//		if($placeCountName){
//			$query = \PlaceBiletHelper::PlacesAttrValueCountAdd($attr_id, $placeCountName);
//			
//			$count = '1';
//		} 
//		$this->setRedirect("index.php?option=com_jshopping&controller=attributesvalues&attr_id=$attr_id", JText::_('JSHOP_ADDED_SEATS_1').$count.JText::_('JSHOP_ADDED_SEATS_2'). $places.JText::_('JSHOP_ADDED_SEATS_3'));
//	}
    
    function RemoveRange(){
            $attr_id = \PlaceBiletHelper::JInput("attr_id") ;  
            $places = \PlaceBiletHelper::JInput("PlacesRangeRemove") ;
            //if(PlaceBiletAdminDev)JFactory::getApplication()->enqueueMessage("Places: ".print_r($places, TRUE));
            //$range = explode (",",$places);              

            $arr_numerics = \PlaceBiletHelper::getArrayFromString($places);
            $count = count($arr_numerics);
            \PlaceBiletHelper::PlacesAttrValueArrayRemove($attr_id, $arr_numerics);
			
			\PlaceBiletHelper::PlacesProdValueDeleteNotExist($attr_id);
            
//if(PlaceBiletAdminDev)JFactory::getApplication()->enqueueMessage("RemoveRange: ".print_r($places, TRUE));
//if(PlaceBiletAdminDev)JFactory::getApplication()->enqueueMessage("RemoveRange: ".print_r($arr, TRUE));
//if(PlaceBiletAdminDev)JFactory::getApplication()->enqueueMessage("<pre>Query: \t".$query."</pre>");//Warning,Error,Notice,Message
            unset($query);
        $this->setRedirect("index.php?option=com_jshopping&controller=attributesvalues&attr_id=$attr_id", 
				JText::sprintf('JSHOP_DELETED_SEATS',$count, $places));
    }
    
    function RemoveString(){
            $attr_id = \PlaceBiletHelper::JInput("attr_id") ;  
            $places = \PlaceBiletHelper::JInput("PlacesStringRemove") ;
            
            $type = substr($places, 0, 2);            
            $places =strval ( substr($places, 2));
            $count = 0;
            
            if($type!='rg' && $type!='id'){
                JError::raiseError( 403, JText::_('JSHOP_NOT_SELECTED_STRING') ); 
                $this->setRedirect("index.php?option=com_jshopping&controller=attributesvalues&attr_id=$attr_id", JText::_('JSHOP_NOT_SELECTED_STRING'));
                return;
            }
                
            if($type=='rg'){
                $range = \PlaceBiletHelper::getArrayFromString($places);
                 
                $count = count($range);   
                
                //if(PlaceBiletAdminDev)JFactory::getApplication()->enqueueMessage("Range: ".print_r($places, TRUE).' _'.print_r($range, TRUE));
                
//                if($count>2 || ($count == 2 && $range[0]>$range[1])){
//                    JError::raiseError( 403, JText::_('Ошибка промежутков') );
//                    $this->setRedirect("index.php?option=com_jshopping&controller=attributes", JText::_('Ошибка промежутков'));
//                    return;
//                }
                 
//                if($count==1){
//                    $numberFirst = $range[0];
//                    $numberLast = $range[0];
//                }
//                else {
//                    $numberFirst = $range[0];
//                    $numberLast = $range[1];
//                }                          
                $query = \PlaceBiletHelper::PlacesAttrValueArrayRemove($attr_id,$range);
                //$query = \PlaceBiletHelper::PlacesAttrValueRangeRemove($attr_id,$numberFirst,$numberLast);
                //if(PlaceBiletAdminDev)JFactory::getApplication()->enqueueMessage("<pre>Query: \t".$query."</pre>");//Warning,Error,Notice,Message
                unset($query);
            }
            else if($type=='id'){            
                
                $placId = intval(trim($places));
                $count = 1;
                $places = "";
                $query = \PlaceBiletHelper::PlacesAttrValueDeleteId($placId);
                //if(PlaceBiletAdminDev)JFactory::getApplication()->enqueueMessage("<pre>Query: \t".$query."</pre>");//Warning,Error,Notice,Message
                unset($query);
            }
            
            //if(PlaceBiletAdminDev)JFactory::getApplication()->enqueueMessage("<pre>Places: \t".\PlaceBiletHelper::JInput("Places") ."</pre>",'Notice');//Warning,Error,Notice,Message        
        $this->setRedirect("index.php?option=com_jshopping&controller=attributesvalues&attr_id=$attr_id",  
				JText::sprintf('JSHOP_DELETED_SEATS',$count, $places));
    }
    
        

}