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



class JshoppingControllerAttributes_mod extends JshoppingControllerAttributes{
    
    function display($cachable = false, $urlparams = false){
        $mainframe = JFactory::getApplication();
        $context = "jshoping.list.admin.attributes";
        $filter_order = $mainframe->getUserStateFromRequest($context.'filter_order', 'filter_order', "A.attr_ordering", 'cmd');
        $filter_order_Dir = $mainframe->getUserStateFromRequest($context.'filter_order_Dir', 'filter_order_Dir', "asc", 'cmd');
        
    	$attributes = JSFactory::getModel("attribut");
    	$attributesvalue = JSFactory::getModel("attributValue");
        $rows = $attributes->getAllAttributes(0, null, $filter_order, $filter_order_Dir);
        foreach ($rows as $key => $value){
            $rows[$key]->values = splitValuesArrayObject( $attributesvalue->getAllValues($rows[$key]->attr_id), 'name');
            $rows[$key]->count_values = count($attributesvalue->getAllValues($rows[$key]->attr_id));
        }        
        $view = $this->getView("attributes", 'html');
        $view->setLayout("list");
        $view->assign('rows', $rows);
        $view->assign('filter_order', $filter_order);
        $view->assign('filter_order_Dir', $filter_order_Dir);
        $view->sidebar = JHtmlSidebar::render();
		
        $dispatcher = JDispatcher::getInstance();
        $dispatcher->trigger('onBeforeDisplayAttributes', array(&$view));
        $view->displayList();
    }
    
    function edit() {
        $jshopConfig = JSFactory::getConfig();
        $db = JFactory::getDBO();
        $attr_id = PlaceBiletHelper::JRequest()->getInt("attr_id");
	
        $attribut = JSFactory::getTable('attribut', 'jshop');
        $attribut->load($attr_id);

        if (!$attribut->independent) $attribut->independent = 0;
    
        $_lang = JSFactory::getModel("languages");
        $languages = $_lang->getAllLanguages(1);
        $multilang = count($languages)>1;
	
        
//        var_dump($attribut->attr_admin_type);
//        var_dump($attribut->attr_type);

        if(is_null($attribut->attr_admin_type))$attribut->attr_admin_type=4;
        $types = array();
        $types[] = JHTML::_('select.option', '1',JText::_('JSHOP_INPUT_SELECT'),'attr_type_id','attr_type');
        $types[] = JHTML::_('select.option', '2',JText::_('JSHOP_INPUT_RADIO'),'attr_type_id','attr_type');
        //$types[] = JHTML::_('select.option', '3','Checkbox','attr_type_id','attr_type');
        $types[] = JHTML::_('select.option', '4',JText::_('JSHOP_INPUT_CHECKBOX'),'attr_type_id','attr_type');        
        $type_attribut = JHTML::_('select.genericlist', $types, 'attr_admin_type','class = "inputbox" size = "1"','attr_type_id','attr_type',($attribut->attr_admin_type?$attribut->attr_admin_type:$attribut->attr_type));
      //$type_attribut = JHTML::_('select.genericlist', $types, 'attr_type','class = "inputbox" size = "1"','attr_type_id','attr_type',$attribut->attr_type);
        
        
        $dependent[] = JHTML::_('select.option', '0',_JSHOP_YES,'id','name');
        $dependent[] = JHTML::_('select.option', '1',_JSHOP_NO,'id','name');
        $dependent_attribut = JHTML::_('select.radiolist', $dependent, 'independent','class = "inputbox" size = "1"','id','name', $attribut->independent);
        
        $all = array();
        $all[] = JHTML::_('select.option', 1, _JSHOP_ALL, 'id','value');
        $all[] = JHTML::_('select.option', 0, _JSHOP_SELECTED, 'id','value');
        if (!isset($attribut->allcats)) $attribut->allcats = 1;
        $lists['allcats'] = JHTML::_('select.radiolist', $all, 'allcats','onclick="PFShowHideSelectCats()"','id','value', $attribut->allcats);
        
        $categories_selected = $attribut->getCategorys();
        $categories = buildTreeCategory(0,1,0);
        $lists['categories'] = JHTML::_('select.genericlist', $categories,'category_id[]','class="inputbox" size="10" multiple = "multiple"','category_id','name', $categories_selected);
        
        $mgroups = JSFactory::getModel("attributesgroups");
        $groups = $mgroups->getList();
        $groups0 = array();
        $groups0[] = JHTML::_('select.option', 0, "- - -", 'id', 'name');        
        $lists['group'] = JHTML::_('select.genericlist', array_merge($groups0, $groups),'group','class="inputbox"','id','name', $attribut->group);
        
        JFilterOutput::objectHTMLSafe($attribut, ENT_QUOTES);  
        $view=$this->getView("attributes", 'html');
        $view->setLayout("edit");
        $view->assign('attribut', $attribut);
        $view->assign('type_attribut', $type_attribut);
        $view->assign('dependent_attribut', $dependent_attribut);
        $view->assign('etemplatevar', '');    
        $view->assign('languages', $languages);
        $view->assign('multilang', $multilang);
        $view->assign('lists', $lists);
        
        $dispatcher = JDispatcher::getInstance();
        $dispatcher->trigger('onBeforeEditAtribut', array(&$view, &$attribut));
//        
//	echo "<pre> ";
//        print_r($attribut);
//        echo "</pre>";   
        $view->displayEdit();
    }
    
    function save(){
        $db = JFactory::getDBO(); 
	$attr_id = PlaceBiletHelper::JRequest()->getInt('attr_id');

        $dispatcher = JDispatcher::getInstance();
        
        $attribut = JSFactory::getTable('attribut', 'jshop');    
        $post = JFactory::getApplication()->input->post;//PlaceBiletHelper::JRequest()->get("post");
        
                
        
        $_lang = JSFactory::getModel("languages");
        $languages = $_lang->getAllLanguages(1);
        foreach($languages as $lang){
            $post['description_'.$lang->language] = PlaceBiletHelper::JRequest()->getString('description_'.$lang->language, '', 'post', "string", 2);
        }
        
        $dispatcher->trigger('onBeforeSaveAttribut', array(&$post));
        
        if (!$attr_id){
            $query = "SELECT MAX(attr_ordering) AS attr_ordering FROM `#__jshopping_attr`";
            $db->setQuery($query);
            $row = $db->loadObject();
            $post['attr_ordering'] = $row->attr_ordering + 1;
        }
        
        if (!$attribut->bind($post)) {
            JError::raiseWarning("",_JSHOP_ERROR_BIND);
            $this->setRedirect("index.php?option=com_jshopping&controller=attributes");
            return 0;
        }
        
        if (isset($post['category_id'])) 
            $categorys = $post['category_id'];
        else
            $categorys = '';
        
        if (!is_array($categorys)) $categorys = array();
        
        $attribut->setCategorys($categorys);

        if (!$attribut->store()) {
            JError::raiseWarning("",_JSHOP_ERROR_SAVE_DATABASE);
            $this->setRedirect("index.php?option=com_jshopping&controller=attributes");
            return 0;
        }
        
        if (!$attr_id ){ //Изменено Добавлено условие && $attribut->attr_admin_type!=4
            $query="ALTER TABLE `#__jshopping_products_attr` ADD `attr_".$attribut->attr_id."` INT( 11 ) NOT NULL";
            $db->setQuery($query);
            $db->query();
            $attr_id = $attribut->attr_id;
        }
//        echo "<pre>Сохранение атрибута в базу: ";
//        var_dump($attribut);     
//        echo "</pre>"; 
        
        
        $dispatcher->trigger('onAfterSaveAttribut', array(&$attribut));
        
		if ($this->getTask()=='apply'){
            $this->setRedirect("index.php?option=com_jshopping&controller=attributes&task=edit&attr_id=".$attr_id); 
        }else{
            $this->setRedirect("index.php?option=com_jshopping&controller=attributes");
        }
    }
}