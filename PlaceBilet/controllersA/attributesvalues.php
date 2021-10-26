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

defined('_JEXEC') or die();
jimport('joomla.application.component.controller');








class JshoppingControllerAttributesValues_mod extends JshoppingControllerAttributesValues{

    function __construct( $config = array() ){
        $this->nameModel = 'attributesvalues';
        parent::__construct($config); 
        
//        echo "<pre>ControllerAttributesValues_mod: ";
//        var_dump($this->get('taskMap'));
//        echo "</pre>"; 
        $this->registerTask( 'add',   'edit' );
        $this->registerTask( 'apply', 'save' );
        
        checkAccessController("attributesvalues_mod");
        
    }
    function display($cachable = false, $urlparams = false){
        //parent::display($cachable = false, $urlparams = false);
        if(PlaceBiletHelper::JRequest()->getCmd("attr_id")==""){
                JError::raiseError( 403, JText::_('JSHOP_NOT_SELECTED_ATRIBUTE') );
                $this->setRedirect("index.php?option=com_jshopping&controller=attributes", JText::_('JSHOP_NOT_SELECTED_ATRIBUTE'));
                return;                
        }   
        
        $attr_id = PlaceBiletHelper::JRequest()->getInt("attr_id");
        $jshopConfig = JSFactory::getConfig();
        $nameLang = JSFactory::getLang()->get("name"); 
        
                $attribut = JSFactory::getTable('attribut', 'jshop'); 
                $attribut->load($attr_id);
                $attr_name = $attribut->$nameLang;
                 
                if($attribut->attr_admin_type !=4){ 
                    parent::display($cachable, $urlparams);
                    return;
                }
                    
                
                
                
                $attributGroup = JSFactory::getTable('attributesgroup', 'jshop'); 
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
        
        $tuple= array();
        $i = current($itemsInt)->key;//key
        $carriage = 0;

        foreach ($itemsInt as $item)
        {
            if($i == $item->name){
                
            }
            else {
                ++$carriage;
            }
          
            $tuple[$carriage][$item->name] = $item;
            
            $i = $item->name + 1;
        }
        
        
//toPrint($debugs,'$debugs');
//toPrint($rows,'$rows');
//toPrint($itemsInt,'$itemsInt',5);
//toPrint($tuple,'tuples',0);
        
        $tuples= array();
        
        foreach ($tuple as $tup)
        {
            $item = new stdClass();
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
        $view = $this->getView('attributesvalues', 'html', '', array('base_path' => PlaceBiletPathAdmin));
        //$view->setLayout("product_default");//Имя файла
        $view->addTemplatePath(PlaceBiletPath.'/templatesA/attributesvalues/'); //Новый шаблон 
//    if(PlaceBiletAdminDev) JFactory::getApplication()->enqueueMessage("<pre>Task!!!: \t".print_r($view->get('_path'))."</pre>");
        $view->sidebar = JHtmlSidebar::render();
        $view->assign('tuples', $tuples);      
        $view->assign('itemsStr', $itemsStr);      
        $view->assign('attr_name', $attr_name);   
        $view->assign('group_name', $group_name);   
        $view->assign('attr_id', $attr_id);
        $view->assign('config', $jshopConfig);
        $view->assign('filter_order', $filter_order);
        $view->assign('filter_order_Dir', $filter_order_Dir);   
        $view->display(); 
//        echo "<pre>IsController: ";
//            var_dump($this);
//        echo "</pre>"; 
//        echo "<pre>IsView: ";
//            var_dump($view);
//        echo "</pre>"; 
        
        
    }
    
    function remove(){// недействительный метод
//		$cid = PlaceBiletHelper::JRequest()->get("cid");        
//		$dispatcher = JDispatcher::getInstance();	
//		$model = JSFactory::getModel("attribut");
//        
//            $dispatcher->trigger('onBeforeRemoveAttribut', array(&$cid));
//        
//		$text = '';
//		foreach($cid as $key => $value){            
//			$model->delete(intval($value));
//            $text = _JSHOP_ATTRIBUT_DELETED;
//		}
//        
//            $dispatcher->trigger('onAfterRemoveAttribut', array(&$cid));
        
        $this->setRedirect("index.php?option=com_jshopping&controller=attributes", $text);
    }
            
    function AddsRange(){
            $attr_id = PlaceBiletHelper::JRequest()->getInt("attr_id");  
            $places = PlaceBiletHelper::JRequest()->getString("PlacesRangeAdd");
            
            //if(PlaceBiletAdminDev)JFactory::getApplication()->enqueueMessage("Places: ".print_r($places, TRUE));
            
            
            $arr = PlaceBiletHelper::getArrayFromString($places);
        $count = count($arr);    
        
        
        
        
            if($arr == '' || (count($arr)==0)){
                JError::raiseError( 403, JText::_('JSHOP_NOT_SELECTED_STRING') );
                $this->setRedirect("index.php?option=com_jshopping&controller=attributes", JText::_('JSHOP_NOT_SELECTED_STRING'));
                return;                
            }                
            $query = PlaceBiletHelper::PlacesAttrValueArrayAdd($attr_id, $arr);
            
            
            
            //if(PlaceBiletAdminDev)JFactory::getApplication()->enqueueMessage("AddsRange: ".print_r($places, TRUE));
            //if(PlaceBiletAdminDev)JFactory::getApplication()->enqueueMessage("AddsRange: ".print_r($arr, TRUE));
            //if(PlaceBiletAdminDev)JFactory::getApplication()->enqueueMessage("<pre>Query: \t".$query."</pre>");//Warning,Error,Notice,Message
            unset($query);
        $this->setRedirect("index.php?option=com_jshopping&controller=attributesvalues&attr_id=$attr_id", JText::_('JSHOP_ADDED_SEATS_1').$count.JText::_('JSHOP_ADDED_SEATS_2'). $places.JText::_('JSHOP_ADDED_SEATS_3'));
    }
    
    function AddString(){
            $attr_id = PlaceBiletHelper::JRequest()->getInt("attr_id");  
            $places = PlaceBiletHelper::JRequest()->getString("PlacesStringAdd");
//            $places = trim($places);
            
            $query = PlaceBiletHelper::PlacesAttrValueStringAdd($attr_id, $places);
            //if(PlaceBiletAdminDev)JFactory::getApplication()->enqueueMessage("AddsRange: ".print_r($places, TRUE));
            //if(PlaceBiletAdminDev)JFactory::getApplication()->enqueueMessage("<pre>Query: \t".$query."</pre>");//Warning,Error,Notice,Message
            unset($query);
			 
        $this->setRedirect("index.php?option=com_jshopping&controller=attributesvalues&attr_id=$attr_id", JText::_('JSHOP_ADDED_SEATS_1').$count.JText::_('JSHOP_ADDED_SEATS_2'). $places.JText::_('JSHOP_ADDED_SEATS_3'));
    }
    
    function RemoveRange(){
            $attr_id = PlaceBiletHelper::JRequest()->getInt("attr_id");  
            $places = PlaceBiletHelper::JRequest()->getString("PlacesRangeRemove");
            //if(PlaceBiletAdminDev)JFactory::getApplication()->enqueueMessage("Places: ".print_r($places, TRUE));
            //$range = explode (",",$places);              

            $arr = PlaceBiletHelper::getArrayFromString($places);
            $count = count($arr);
            $query = PlaceBiletHelper::PlacesAttrValueArrayRemove($attr_id, $arr);
            
            //if(PlaceBiletAdminDev)JFactory::getApplication()->enqueueMessage("RemoveRange: ".print_r($places, TRUE));
            //if(PlaceBiletAdminDev)JFactory::getApplication()->enqueueMessage("RemoveRange: ".print_r($arr, TRUE));
            //if(PlaceBiletAdminDev)JFactory::getApplication()->enqueueMessage("<pre>Query: \t".$query."</pre>");//Warning,Error,Notice,Message
            unset($query);
        $this->setRedirect("index.php?option=com_jshopping&controller=attributesvalues&attr_id=$attr_id", JText::_('JSHOP_DELETED_SEATS_1').$count.JText::_('JSHOP_DELETED_SEATS_2'). $places.JText::_('JSHOP_DELETED_SEATS_3'));
    }
    
    function RemoveString(){
            $attr_id = PlaceBiletHelper::JRequest()->getInt("attr_id");  
            $places = PlaceBiletHelper::JRequest()->getCmd("PlacesStringRemove");
            
            $type = substr($places, 0, 2);            
            $places =strval ( substr($places, 2));
            $count = 0;
            
            if($type!='rg' && $type!='id'){
                JError::raiseError( 403, JText::_('JSHOP_NOT_SELECTED_STRING') ); 
                $this->setRedirect("index.php?option=com_jshopping&controller=attributesvalues&attr_id=$attr_id", JText::_('JSHOP_NOT_SELECTED_STRING'));
                return;
            }
                
            if($type=='rg'){
                $range = PlaceBiletHelper::getArrayFromString($places);
                 
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
                $query = PlaceBiletHelper::PlacesAttrValueArrayRemove($attr_id,$range);
                //$query = PlaceBiletHelper::PlacesAttrValueRangeRemove($attr_id,$numberFirst,$numberLast);
                //if(PlaceBiletAdminDev)JFactory::getApplication()->enqueueMessage("<pre>Query: \t".$query."</pre>");//Warning,Error,Notice,Message
                unset($query);
            }
            else if($type=='id'){            
                
                $placId = intval(trim($places));
                $count = 1;
                $places = "";
                $query = PlaceBiletHelper::PlacesAttrValueDeleteId($placId);
                //if(PlaceBiletAdminDev)JFactory::getApplication()->enqueueMessage("<pre>Query: \t".$query."</pre>");//Warning,Error,Notice,Message
                unset($query);
            }
            
            //if(PlaceBiletAdminDev)JFactory::getApplication()->enqueueMessage("<pre>Places: \t".PlaceBiletHelper::JRequest()->getCmd("Places")."</pre>",'Notice');//Warning,Error,Notice,Message        
        $this->setRedirect("index.php?option=com_jshopping&controller=attributesvalues&attr_id=$attr_id",  JText::_('JSHOP_DELETED_SEATS_1').$count.JText::_('JSHOP_DELETED_SEATS_2'). $places.JText::_('JSHOP_DELETED_SEATS_3'));
    }
    
        

}