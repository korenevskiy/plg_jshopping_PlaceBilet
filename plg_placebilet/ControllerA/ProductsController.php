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

defined( '_JEXEC' ) or die( 'Restricted access' );

    
use \Joomla\CMS\Language\Text as JText;
use \Joomla\CMS\Session\Session as JSession;
use \Joomla\Component\Jshopping\Site\Lib\JSFactory  as JSFactory;
use \Joomla\Component\Jshopping\Site\Helper\Error as JSError;
use \Joomla\Component\Jshopping\Site\Helper as JSHelper;

use \Joomla\CMS\Factory as JFactory;
    
jimport('joomla.application.component.controller');
    
    
class ProductsModController extends ProductsController{
//class JshoppingControllerProductsMod extends JshoppingControllerProducts {
    
	function getFactory(){
		return $this->factory;
	}
	function setFactory($factory = null){
		if($factory)
			$this->factory = $factory;
	}

// Член требуемый для J4, для совместимости J3 отключен, но компенсируется $config['default_view'] в конструкторе
//	protected $name = 'Products';
	
	protected $default_view = 'Products';
	
    function __construct($config = array(), \Joomla\CMS\MVC\Factory\MVCFactoryInterface $factory = null, $app = null, $input = null){
        $this->nameModel = 'products';
        parent::__construct($config, $factory, $app, $input); 
//        $this->registerTask('add', 'edit' );
//        $this->registerTask('apply', 'save');
        //checkAccessController("products");
//        echo JText::sprintf('JSHOP_PLACE_ADDED',123);
        //addSubmenu("products");
    }
//    
//    function display($cachable = false, $urlparams = false){
//        $mainframe = JFactory::getApplication();    
//        $db = JFactory::getDBO();
//        $jshopConfig = JSFactory::getConfig();
//        $products = JSFactory::getModel("products");
//        $id_vendor_cuser = getIdVendorForCUser();
//		
//		
//        $context = "jshoping.list.admin.product";
//        $limit = $mainframe->getUserStateFromRequest($context.'limit', 'limit', $mainframe->getCfg('list_limit'), 'int' );
//        $limitstart = $mainframe->getUserStateFromRequest($context.'limitstart', 'limitstart', 0, 'int' );
//        $filter_order = $mainframe->getUserStateFromRequest($context.'filter_order', 'filter_order', $jshopConfig->adm_prod_list_default_sorting, 'cmd');
//        $filter_order_Dir = $mainframe->getUserStateFromRequest($context.'filter_order_Dir', 'filter_order_Dir', $jshopConfig->adm_prod_list_default_sorting_dir, 'cmd');
//        
//        if (isset($_GET['category_id']) && $_GET['category_id']==="0"){            
//            $mainframe->setUserState($context.'category_id', 0);
//            $mainframe->setUserState($context.'manufacturer_id', 0);
//			$mainframe->setUserState($context.'vendor_id', -1);
//            $mainframe->setUserState($context.'label_id', 0);
//            $mainframe->setUserState($context.'publish', 0);
//            $mainframe->setUserState($context.'text_search', '');
//        }
//
//        $category_id = $mainframe->getUserStateFromRequest($context.'category_id', 'category_id', 0, 'int');
//        $manufacturer_id = $mainframe->getUserStateFromRequest($context.'manufacturer_id', 'manufacturer_id', 0, 'int');
//		$vendor_id = $mainframe->getUserStateFromRequest($context.'vendor_id', 'vendor_id', -1, 'int');
//        $label_id = $mainframe->getUserStateFromRequest($context.'label_id', 'label_id', 0, 'int');
//        $publish = $mainframe->getUserStateFromRequest($context.'publish', 'publish', 0, 'int');
//        $text_search = $mainframe->getUserStateFromRequest($context.'text_search', 'text_search', '');
//        if ($category_id && $filter_order=='category') $filter_order = 'product_id';
//		
//        $filter = array("category_id"=>$category_id, "manufacturer_id"=>$manufacturer_id, "vendor_id"=>$vendor_id, "label_id"=>$label_id, "publish"=>$publish, "text_search"=>$text_search);
//        if ($id_vendor_cuser){
//            $filter["vendor_id"] = $id_vendor_cuser;
//        }
//        
//        $show_vendor = $jshopConfig->admin_show_vendors;
//        if ($id_vendor_cuser) $show_vendor = 0;
//                
//        $total = $products->getCountAllProducts($filter);
//        
//        jimport('joomla.html.pagination');
//        $pagination = new JPagination($total, $limitstart, $limit);
//        
//        $rows = $products->getAllProducts($filter, $pagination->limitstart, $pagination->limit, $filter_order, $filter_order_Dir);
//        
//        if ($show_vendor){
//            $main_vendor = JSFactory::getTable('vendor', 'jshop');
//            $main_vendor->loadMain();
//			
//			$vendorsModel = JSFactory::getModel('vendors');
//            $vendors = $vendorsModel->getAllVendorsNames(1);
//            
//            $firstVendor = array();
//            $firstVendor[0] = new stdClass();
//            $firstVendor[0]->id = -1;
//            $firstVendor[0]->name = " - ".__('JSHOP_VENDOR')." - ";
//            $lists['vendors'] = JHTML::_('select.genericlist', array_merge($firstVendor, $vendors), 'vendor_id','class="chosen-select" onchange="document.adminForm.submit();"', 'id', 'name', $vendor_id);
//            
//            foreach($rows as $k=>$v){
//                if ($v->vendor_id){
//                    $rows[$k]->vendor_name = $v->v_f_name." ".$v->v_l_name;
//                }else{
//                    $rows[$k]->vendor_name = $main_vendor->f_name." ".$main_vendor->l_name;
//                }
//            }
//        }
//        
//        $parentTop = new stdClass();
//        $parentTop->category_id = 0;
//        $parentTop->name = "- ".__('JSHOP_CATEGORY')." -";
//        $categories_select = buildTreeCategory(0,1,0);
//        array_unshift($categories_select, $parentTop);    
//        $lists['treecategories'] = JHTML::_('select.genericlist', $categories_select, 'category_id', 'class="chosen-select" onchange="document.adminForm.submit();"', 'category_id', 'name', $category_id );
//        
//        $manuf1 = array();
//        $manuf1[0] = new stdClass();
//        $manuf1[0]->manufacturer_id = '0';
//        $manuf1[0]->name = " - ".__('JSHOP_NAME_MANUFACTURER')." - ";
//
//        $_manufacturer = JSFactory::getModel('manufacturers');
//        $manufs = $_manufacturer->getList();
//        $manufs = array_merge($manuf1, $manufs);
//        $lists['manufacturers'] = JHTML::_('select.genericlist', $manufs, 'manufacturer_id','class="chosen-select" onchange="document.adminForm.submit();"', 'manufacturer_id', 'name', $manufacturer_id);
//        
//        // product labels
//        if ($jshopConfig->admin_show_product_labels) {
//            $_labels = JSFactory::getModel("productLabels");
//            $alllabels = $_labels->getList();
//            $first = array();
//            $first[] = JHTML::_('select.option', '0', " - ".__('JSHOP_LABEL')." - ", 'id','name');
//            $lists['labels'] = JHTML::_('select.genericlist', array_merge($first, $alllabels), 'label_id','style="width: 100px;" class="chosen-select" onchange="document.adminForm.submit();"','id','name', $label_id);
//        }
//        //
//        
//        $f_option = array();
//        $f_option[] = JHTML::_('select.option', 0, " - ".__('JSHOP_SHOW')." - ", 'id', 'name');
//        $f_option[] = JHTML::_('select.option', 1, __('JSHOP_PUBLISH'), 'id', 'name');
//        $f_option[] = JHTML::_('select.option', 2, __('JSHOP_UNPUBLISH'), 'id', 'name');
//        $lists['publish'] = JHTML::_('select.genericlist', $f_option, 'publish', 'style="width: 100px;" class="chosen-select" onchange="document.adminForm.submit();"', 'id', 'name', $publish);
//        
//        foreach($rows as $key=>$v){
//            if ($rows[$key]->label_id){
//                $image = getNameImageLabel($rows[$key]->label_id);
//                if ($image){
//                    $rows[$key]->_label_image = $jshopConfig->image_labels_live_path."/".$image;
//                }
//                $rows[$key]->_label_name = getNameImageLabel($rows[$key]->label_id, 2);
//            }
//        }
//
//        $dispatcher = \JFactory::getApplication();
//        $dispatcher->triggerEvent('onBeforeDisplayListProducts', array(&$rows));
//        
//        
//        $view = $this->getView("product_list", 'html');
//        $view->set('rows', $rows);
//        $view->set('lists', $lists);
//        $view->set('filter_order', $filter_order);
//        $view->set('filter_order_Dir', $filter_order_Dir);
//        $view->set('category_id', $category_id);
//        $view->set('manufacturer_id', $manufacturer_id);
//        $view->set('pagination', $pagination);
//        $view->set('text_search', $text_search);
//        $view->set('config', $jshopConfig);
//        $view->set('show_vendor', $show_vendor);
//        $view->sidebar = JHtmlSidebar::render();
//        $dispatcher->triggerEvent('onBeforeDisplayListProductsView', array(&$view));
//        $view->display();        
//    }
//    
//    function edit(){
//        $jshopConfig = JSFactory::getConfig();
//        $db = JFactory::getDBO();
//        $lang = JSFactory::getLang();
//        
//        $dispatcher = \JFactory::getApplication();
//        $dispatcher->triggerEvent('onLoadEditProduct', array());
//        $id_vendor_cuser = getIdVendorForCUser();
//        $category_id = \PlaceBiletHelper::JInput('category_id') ;
//        
//        $tmpl_extra_fields = null;
//        
//        $product_id = \PlaceBiletHelper::JInput('product_id') ;
//        $product_attr_id = \PlaceBiletHelper::JInput('product_attr_id') ;        
//        
//        //parent product
//        if ($product_attr_id){
//            //\PlaceBiletHelper::JInput()->set("hidemainmenu", 1);
//            $product_attr = JSFactory::getTable('productAttribut', 'jshop');
//            $product_attr->load($product_attr_id);
//			if ($product_attr->ext_attribute_product_id){
//                $product_id = $product_attr->ext_attribute_product_id;
//            }else{
//                $product = JSFactory::getTable('product', 'jshop');
//                $product->parent_id = $product_attr->product_id;
//                $product->store();
//                $product_id = $product->product_id;
//                $product_attr->ext_attribute_product_id = $product_id;
//                $product_attr->store();
//            }            
//        }        
//        
//        if ($id_vendor_cuser && $product_id){
//            checkAccessVendorToProduct($id_vendor_cuser, $product_id);
//        }
//        
//        $products = JSFactory::getModel("products");
//        
//        $product = JSFactory::getTable('product', 'jshop');
//        $product->load($product_id);
//        $_productprice = JSFactory::getTable('productPrice', 'jshop');
//        $product->product_add_prices = $_productprice->getAddPrices($product_id);        
//        $product->product_add_prices = array_reverse($product->product_add_prices);        
//        $product->name = $product->getName();
//
//        $_lang = JSFactory::getModel("languages");
//        $languages = $_lang->getAllLanguages(1);
//        $multilang = count($languages)>1;
// 
//        $nofilter = array();
//        JFilterOutput::objectHTMLSafe( $product, ENT_QUOTES, $nofilter);
//
//        $edit = intval($product_id);
//
//        if (!$product_id) {
//            $rows = array();
//            $product->product_quantity = 1;
//            $product->product_publish = 1;
//        }
// 
//		$product->product_quantity = floatval($product->product_quantity);
//        $_tax = JSFactory::getModel("taxes");
//        $all_taxes = $_tax->getAllTaxes();
//        
//        if ($edit){
//            $images = $product->getImages();
//            $videos = $product->getVideos();
//            $files  = $product->getFiles();
//            $categories_select = $product->getCategories();
//            $categories_select_list = array();
//            foreach($categories_select as $v){
//                $categories_select_list[] = $v->category_id;
//            }
//            $related_products = $products->getRelatedProducts($product_id);
//        } else {
//            $images = array();
//            $videos = array();
//            $files = array();
//            $categories_select = null;
//            if ($category_id) {
//                $categories_select = $category_id;
//            }
//            $related_products = array();
//            $categories_select_list = array();
//        }
//        if ($jshopConfig->tax){
//            $list_tax = array();
//            foreach ($all_taxes as $tax){
//                $list_tax[] = JHTML::_('select.option', $tax->tax_id, $tax->tax_name . ' (' . $tax->tax_value . '%)','tax_id','tax_name');
//            }
//            $withouttax = 0;
//        }else{
//            $withouttax = 1;
//        }
//
//        $categories = buildTreeCategory(0,1,0);
//        if (count($categories)==0) JError::raiseNotice(0, __('JSHOP_PLEASE_ADD_CATEGORY'));
//        $lists['images'] = $images;
//        $lists['videos'] = $videos;
//        $lists['files'] = $files;
//
//        $manuf1 = array();
//        $manuf1[0] = new stdClass();
//        $manuf1[0]->manufacturer_id = '0';
//        $manuf1[0]->name = __('JSHOP_NONE');
//
//        $_manufacturer =JSFactory::getModel('manufacturers');
//        $manufs = $_manufacturer->getList();
//        $manufs = array_merge($manuf1, $manufs);
//
//        //Attributes
//        $_attribut = JSFactory::getModel('attribut');
//        $list_all_attributes = $_attribut->getAllAttributes(2, $categories_select_list);
//        $_attribut_value =JSFactory::getModel('attributValue');
//        $lists['attribs'] = $product->getAttributes();
//        $lists['ind_attribs'] = $product->getAttributes2();
//        $lists['attribs_values'] = $_attribut_value->getAllAttributeValues(2);
//        $all_attributes = $list_all_attributes['dependent'];
//
//        $lists['ind_attribs_gr'] = array();
//        foreach($lists['ind_attribs'] as $v){
//            $lists['ind_attribs_gr'][$v->attr_id][] = $v;
//        }
//        
//		foreach ($lists['attribs'] as $key => $attribs){
//            $lists['attribs'][$key]->count = floatval($attribs->count);
//        }
//		
//        $first = array();
//        $first[] = JHTML::_('select.option', '0',__('JSHOP_SELECT'), 'value_id','name');
//
//        foreach ($all_attributes as $key => $value){
//            $values_for_attribut = $_attribut_value->getAllValues($value->attr_id);
//            $all_attributes[$key]->values_select = JHTML::_('select.genericlist', array_merge($first, $values_for_attribut),'value_id['.$value->attr_id.']','class = "inputbox" size = "5" multiple="multiple" id = "value_id_'.$value->attr_id.'"','value_id','name');
//            $all_attributes[$key]->values = $values_for_attribut;
//        }        
//        $lists['all_attributes'] = $all_attributes;
//        $product_with_attribute = (count($lists['attribs']) > 0);
//        
//        //independent attribute
//        $all_independent_attributes = $list_all_attributes['independent'];
//        
//        $price_modification = array();
//        $price_modification[] = JHTML::_('select.option', '+','+', 'id','name');
//        $price_modification[] = JHTML::_('select.option', '-','-', 'id','name');
//        $price_modification[] = JHTML::_('select.option', '*','*', 'id','name');
//        $price_modification[] = JHTML::_('select.option', '/','/', 'id','name');
//        $price_modification[] = JHTML::_('select.option', '=','=', 'id','name');
//        $price_modification[] = JHTML::_('select.option', '%','%', 'id','name');
//        
//        foreach ($all_independent_attributes as $key => $value){
//            $values_for_attribut = $_attribut_value->getAllValues($value->attr_id);            
//            $all_independent_attributes[$key]->values_select = JHTML::_('select.genericlist', array_merge($first, $values_for_attribut),'attr_ind_id_tmp_'.$value->attr_id.'','class = "inputbox middle2" ','value_id','name');
//            $all_independent_attributes[$key]->values = $values_for_attribut;
//            $all_independent_attributes[$key]->price_modification_select = JHTML::_('select.genericlist', $price_modification,'attr_price_mod_tmp_'.$value->attr_id.'','class = "inputbox small3" ','id','name');
//            $all_independent_attributes[$key]->submit_button = '<input type = "button" class="btn" onclick = "addAttributValue2('.$value->attr_id.');" value = "'.__('JSHOP_ADD_ATTRIBUT').'" />';
//        }        
//        $lists['all_independent_attributes'] = $all_independent_attributes;
//		$lists['dep_attr_button_add'] = '<input type="button" class="btn" onclick="addAttributValue()" value="'.__('JSHOP_ADD').'" />';
//        // End work with attributes and values
//
//        // delivery Times
//        if ($jshopConfig->admin_show_delivery_time) {
//            $_deliveryTimes = JSFactory::getModel("deliveryTimes");
//            $all_delivery_times = $_deliveryTimes->getDeliveryTimes();                
//            $all_delivery_times0 = array();
//            $all_delivery_times0[0] = new stdClass();
//            $all_delivery_times0[0]->id = '0';
//            $all_delivery_times0[0]->name = __('JSHOP_NONE');        
//            $lists['deliverytimes'] = JHTML::_('select.genericlist', array_merge($all_delivery_times0, $all_delivery_times),'delivery_times_id','class = "inputbox" size = "1"','id','name',$product->delivery_times_id);        
//        }
//        //
//
//        // units
//        $_units = JSFactory::getModel("units");
//        $allunits = $_units->getUnits();
//        if ($jshopConfig->admin_show_product_basic_price){
//            $lists['basic_price_units'] = JHTML::_('select.genericlist', $allunits, 'basic_price_unit_id','class = "inputbox"','id','name',$product->basic_price_unit_id);
//        }
//        if (!$product->add_price_unit_id) $product->add_price_unit_id = $jshopConfig->product_add_price_default_unit;
//        $lists['add_price_units'] = JHTML::_('select.genericlist', $allunits, 'add_price_unit_id','class = "inputbox middle"','id','name', $product->add_price_unit_id);
//        //
//        
//        // product labels
//        if ($jshopConfig->admin_show_product_labels){
//            $_labels = JSFactory::getModel("productLabels");
//            $alllabels = $_labels->getList();
//            $first = array();
//            $first[] = JHTML::_('select.option', '0',__('JSHOP_SELECT'), 'id','name');        
//            $lists['labels'] = JHTML::_('select.genericlist', array_merge($first, $alllabels), 'label_id','class = "inputbox" size = "1"','id','name',$product->label_id);
//        }
//        //
//        
//        // access rights
//        $accessgroups = getAccessGroups();        
//        $lists['access'] = JHTML::_('select.genericlist', $accessgroups, 'access','class = "inputbox" size = "1"','id','title', $product->access);
//        
//        //currency
//        $current_currency = $product->currency_id;
//        if (!$current_currency) $current_currency = $jshopConfig->mainCurrency;
//        $_currency = JSFactory::getModel("currencies");
//        $currency_list = $_currency->getAllCurrencies();
//        $lists['currency'] = JHTML::_('select.genericlist', $currency_list, 'currency_id','class = "inputbox small2"','currency_id','currency_code', $current_currency);
//        
//        // vendors
//        $display_vendor_select = 0;
//        if ($jshopConfig->admin_show_vendors){
//            $_vendors = JSFactory::getModel("vendors");
//            $listvebdorsnames = $_vendors->getAllVendorsNames(1);
//            $first = array();
//            $lists['vendors'] = JHTML::_('select.genericlist', array_merge($first, $listvebdorsnames), 'vendor_id','class = "inputbox" size = "1"', 'id', 'name', $product->vendor_id);
//            
//            $display_vendor_select = 1;
//            if ($id_vendor_cuser > 0) $display_vendor_select = 0;            
//        }
//        //
//        
//        //product extra field
//        if ($jshopConfig->admin_show_product_extra_field) {
//            $categorys_id = array();
//            if (is_array($categories_select)){
//                foreach($categories_select as $tmp){
//                    $categorys_id[] = $tmp->category_id;
//                }        
//            }
//            $tmpl_extra_fields = $this->_getHtmlProductExtraFields($categorys_id, $product);
//        }
//        //
//        
//        //free attribute
//        if ($jshopConfig->admin_show_freeattributes){
//            $_freeattributes = JSFactory::getModel("freeattribut");        
//            $listfreeattributes = $_freeattributes->getAll();
//            $activeFreeAttribute = $product->getListFreeAttributes();
//            $listIdActiveFreeAttribute = array();
//            foreach($activeFreeAttribute as $_obj){
//                $listIdActiveFreeAttribute[] = $_obj->id;
//            }            
//            foreach($listfreeattributes as $k=>$v){
//                if (in_array($v->id, $listIdActiveFreeAttribute)){
//                    $listfreeattributes[$k]->pactive = 1;
//                }
//            }
//        }
//
//        $lists['manufacturers'] = JHTML::_('select.genericlist', $manufs,'product_manufacturer_id','class = "inputbox" size = "1"','manufacturer_id','name',$product->product_manufacturer_id);
//        
//        $tax_value = 0;
//        if ($jshopConfig->tax){
//            foreach($all_taxes as $tax){
//                if ($tax->tax_id == $product->product_tax_id){
//                    $tax_value = $tax->tax_value;
//                    break; 
//                }
//            }
//        }
//        
//        if ($product_id){
//            $product->product_price = formatEPrice($product->product_price);
//            
//            if ($jshopConfig->display_price_admin==0){
//                $product->product_price2 = formatEPrice($product->product_price / (1 + $tax_value / 100));
//            }else{
//                $product->product_price2 = formatEPrice($product->product_price * (1 + $tax_value / 100));
//            }
//        }else{
//            $product->product_price2 = '';
//        }
//        
//
//        $category_select_onclick = "";
//        if ($jshopConfig->admin_show_product_extra_field) $category_select_onclick = 'onclick="reloadProductExtraField(\''.$product_id.'\')"';
//        
//        if ($jshopConfig->tax){
//            $lists['tax'] = JHTML::_('select.genericlist', $list_tax,'product_tax_id','class = "inputbox" size = "1" onchange = "updatePrice2('.$jshopConfig->display_price_admin.');"','tax_id','tax_name',$product->product_tax_id);
//        }
//        $lists['categories'] = JHTML::_('select.genericlist', $categories, 'category_id[]', 'class="inputbox" size="10" multiple = "multiple" '.$category_select_onclick, 'category_id', 'name', $categories_select);
//        $lists['templates'] = getTemplates('product', $product->product_template);
//        
//        $_product_option = JSFactory::getTable('productOption', 'jshop');
//        $product_options = $_product_option->getProductOptions($product_id);
//        $product->product_options = $product_options;
//        
//        if ($jshopConfig->return_policy_for_product){ 
//            $_statictext = JSFactory::getModel("statictext");
//            $first = array();
//            $first[] = JHTML::_('select.option', '0', _JSHP_STPAGE_return_policy, 'id', 'alias');
//            $statictext_list = $_statictext->getList(1);
//            $lists['return_policy'] = JHTML::_('select.genericlist', array_merge($first, $statictext_list), 'options[return_policy]','class = "inputbox"','id','alias', $product_options['return_policy']);
//        }
//        
//        $dispatcher->triggerEvent('onBeforeDisplayEditProduct', array(&$product, &$related_products, &$lists, &$listfreeattributes, &$tax_value));
//
//        
//        //$view = $this->getView($viewName, 'html', '', array('base_path' => PlaceBiletPathAdmin, 'layout' => $viewLayout));
//        //$view = $this->getView($viewName, 'html', '', array('base_path' => PlaceBiletPathAdmin));
//        //$view = $this->getView('attributesvalues', 'html', '', array('base_path' => PlaceBiletPathAdmin));
//        //$view=$this->getView("product_edit", 'html', '', array('base_path' => PlaceBiletPathAdmin));
////        echo "<pre>Viewer: ";
////            var_dump($view);
////        echo "</pre>"; 
//
//        
//        $view=$this->getView("product_edit", 'html');
//        $view->setLayout("default");
//        $view->set('product', $product);
//        $view->set('lists', $lists);
//        $view->set('related_products', $related_products);
//        $view->set('edit', $edit);
//        $view->set('product_with_attribute', $product_with_attribute);
//        $view->set('tax_value', $tax_value);
//        $view->set('languages', $languages);
//        $view->set('multilang', $multilang);
//        $view->set('tmpl_extra_fields', $tmpl_extra_fields);
//        $view->set('withouttax', $withouttax);
//        $view->set('display_vendor_select', $display_vendor_select);
//        $view->set('listfreeattributes', $listfreeattributes);
//        $view->set('product_attr_id', $product_attr_id);
//        foreach($languages as $lang){
//            $view->set('plugin_template_description_'.$lang->language, '');
//        }
//        $view->set('plugin_template_info', '');
//        $view->set('plugin_template_attribute', '');
//        $view->set('plugin_template_freeattribute', '');
//        $view->set('plugin_template_images', '');
//        $view->set('plugin_template_related', '');
//        $view->set('plugin_template_files', '');
//        $view->set('plugin_template_extrafields', '');
//        $dispatcher->triggerEvent('onBeforeDisplayEditProductView', array(&$view) );
//        
////        echo "<pre>Viewer: ";
////            var_dump($view);
////        echo "</pre>"; 
//        
//		$view->display();
//    }
    function save(){
        \JSession::checkToken() or die('Invalid Token');
//        if ($this->checkToken['save']){
//            JSession::checkToken() or die('Invalid Token');
//        }
  
//toPrint('++++++++++++++++++++++++++++++','',0,TRUE);
//echo JFactory::getConfig()->;
//----------------------------------------------        
//$this->setRedirect("index.php?option=com_jshopping&controller=products&task=edit&product_id=".$product->product_id, __('JSHOP_PRODUCT_SAVED'));	

        $model = JSFactory::getModel("products");
        $post = $model->getPrepareDataSave($this->input); // Языковая адаптация полей для базы
        
        
	//Изменено: в 3 строках ниже заменено NULL на array()
//    if (!isset($post['attrib_ind_id']))			$post['attrib_ind_id'] = []; 				// NULL заменен на array();
    if (!isset($post['attrib_ind_price']))		$post['attrib_ind_price'] = [];			// NULL заменен на array();
    if (!isset($post['attrib_ind_price_mod']))	$post['attrib_ind_price_mod'] = [];	// NULL заменен на array();
    if (!isset($post['attrib_ind_price_mod']))	$post['attrib_ind_price_mod'] = [];	// NULL заменен на array();
	if (!isset($post['attrib_place_value_id']))	$post['attrib_place_value_id'] = [];   // Места интревалов ввиде строки (без пробелов и знаков припенания) 15o25 14991
	if (!isset($post['attrib_place_price']))	$post['attrib_place_price'] = [];      // Цена       9631 350
	if (!isset($post['attrib_place_price_mod']))$post['attrib_place_price_mod'] = []; // Знак модификации цены    +
	if (!isset($post['attrib_place_id']))		$post['attrib_place_id'] = null;       // ID Атрибута                    9631
	if (!isset($post['attrib_place_name']))		$post['attrib_place_name'] = [];      // Места интревалов ввиде строки   //attrib_place_Int_tuple   350    15-25
	if (!isset($post['attrib_place_type']))		$post['attrib_place_type'] = [];      // тип, числовой или строковое место
    
    //Изменено: Добавлены ниже 13 строк
    $post['date_event'] = $post['date_event'] ??  \JSHelper::getJsDate();                  // Дата показа спектакля, концерта и кино
	
	
	
//    $deb = [];
//    foreach ($post['attrib_place_type'] as $key=> $type)
//        if($type=='Str')
//        $deb[] = ['attrib_place_value_id' => $post['attrib_place_value_id'][$key],'attrib_place_id' => $post['attrib_place_id'][$key],'attrib_place_name' => $post['attrib_place_name'][$key],'attrib_place_price' => $post['attrib_place_price'][$key],'attrib_place_type' => $post['attrib_place_type'][$key]];
//    $deb[] = ['attrib_place_value_id' => $post['attrib_place_value_id'][0],'attrib_place_id' => $post['attrib_place_id'][0],'attrib_place_name' => $post['attrib_place_name'][0],'attrib_place_price' => $post['attrib_place_price'][0],'attrib_place_type' => $post['attrib_place_type'][0]];        
//    toPrint($deb,'$deb !!!!!!!',0,'message',TRUE); // attrib_place_value_id        attrib_place_name
        
    
//    $post['attrib_ind_id'] = array_merge($post['attrib_ind_id'], $post['attrib_place_value_id']);
    $post['attrib_ind_price_mod'] = array_merge($post['attrib_ind_price_mod'], $post['attrib_place_price_mod']);
    $post['attrib_ind_price'] = array_merge($post['attrib_ind_price'], $post['attrib_place_price']);
    //Изменено: Конец добавления 13 строк
//----------------------------------------------        
//$this->setRedirect("index.php?option=com_jshopping&controller=products&task=edit&product_id=".$product->product_id, __('JSHOP_PRODUCT_SAVED'));	        
//$this->setRedirect("index.php?option=com_jshopping&controller=products&task=edit&product_id=13043", __('JSHOP_PRODUCT_SAVED'));$this->redirect();return;//----------------------------------------------       
//toPrint($post,'$post',0,'message',TRUE);
//return;

        if (!$product = $model->save($post)){ // Метод $model->save($post) возвращает объект класса new Table("product")
//toPrint(2222222222222222222,'',0,'message',TRUE);
			JFactory::getApplication()->enqueueMessage($model->getError(), \Joomla\CMS\Application\CMSApplicationInterface::MSG_ERROR);
            \JSError::raiseWarning("100", $model->getError());
//            JError::raiseWarning("100", $model->getError());
            $this->setRedirect("index.php?option=com_jshopping&controller=products&task=edit&product_id=".$post['product_id']);
            print $model->getError(); die();
            return;
        }
        if ($product->parent_id!=0){
            print "<script type='text/javascript'>window.close();</script>";
            die();
        }
        
        //$product_id = \PlaceBiletHelper::JInput('product_id') ;
        $product_id = $product->product_id;
        
//        toPrint($product_id,'$product_id !!!!!!!',0,'message');
//        toPrint($product,'$product',0,'message');
//        toPrint($post,'$post',0,'message',true);
        

//$this->setRedirect("index.php?option=com_jshopping&controller=products&task=edit&product_id=13043", __('JSHOP_PRODUCT_SAVED'));$this->redirect();return;//----------------------------------------------       

//<br><input type="text" class="inputbox wide" name="deb" value="F!123">
//----------------------------------------------        
//$this->setRedirect("index.php?option=com_jshopping&controller=products&task=edit&product_id=".$product->product_id, __('JSHOP_PRODUCT_SAVED'));	
//        toPrint(6666666666666,'',0,TRUE);
//        $reflector = new ReflectionClass('PlaceBiletHelper');
//        toPrint(7777777777777,'',0,TRUE);
////        echo $reflector->getFileName();
////        echo $reflector->getStartLine();
//        toPrint($reflector->getFileName().' '.$reflector->getStartLine(),'PlaceBiletHelper->: ','',0,TRUE);
        
		
		
		/* 
		 * Сохранение значений атрибутов(цен для мест) в базу для Админки.
		 * PlaceBiletHelper::saveAttributesPlace($product, $product_id, $post)
		 */
        $count_row = (int)\PlaceBiletHelper::saveAttributesPlace($product, $product_id, $post);// Изменено добавлено строка
        
        
        if(PlaceBiletAdminDev){
            $tag = JFactory::getLanguage()->getTag();
            JFactory::getApplication()->enqueueMessage("<pre>Продукт : ".$product->{"name_$tag"}."  ИД: $product_id</pre>"); //print_r($query, TRUE)// Изменено: добавлена строка с условием		
            $name = "Name Product: ";
            $post_keys = array_keys($post);
            foreach ($post_keys as $key){
                if(substr($key, 0, 5)=='name_')
                    $name .= $post[$key].'|';
            }
            JFactory::getApplication()->enqueueMessage("<a href='/administrator/index.php?option=com_jshopping&controller=products&task=edit&product_id=$product_id'>$name</a>"); 
        }
		
//toPrint();
//toPrint($count_row,'$count_row',0,'message',true);
//toPrint(JText::_('JSHOP_PLACE_ADDED'),'JSHOP_PRODUCT_SAVED',0,'message',true);
		
        if ($this->getTask()=='apply'){
            $this->setRedirect("index.php?option=com_jshopping&controller=products&task=edit&product_id=".$product->product_id, 
					 \JText::_('JSHOP_PRODUCT_SAVED')
					.\JText::printf('JSHOP_PLACE_ADDED',$count_row)
					);
        }elseif ($this->getTask()=='save2new') {
            $this->setRedirect($this->getUrlEditItem());
        }else{
            $this->setRedirect("index.php?option=com_jshopping&controller=products",
					\JText::_('JSHOP_PRODUCT_SAVED').JText::sprintf('JSHOP_PLACE_ADDED',$count_row));
        }
		

    }
    
    function save_(){
        $jshopConfig = JSFactory::getConfig();
        require_once($jshopConfig->path.'lib/image.lib.php');
        require_once($jshopConfig->path.'lib/uploadfile.class.php');

        
        $dispatcher = \JFactory::getApplication();

        $db = JFactory::getDBO();
        $post = JFactory::getApplication()->input->post;//\PlaceBiletHelper::JInput()->get('post');
        $_products = JSFactory::getModel("products");//
        //$_products = JSFactory::getModel("products");//JshoppingModelProducts_mod
        $product = JSFactory::getTable('product', 'jshop');
        $_alias = JSFactory::getModel("alias");
        $_lang = JSFactory::getModel("languages");
        $id_vendor_cuser = getIdVendorForCUser();

        if ($id_vendor_cuser && $post['product_id']){
            checkAccessVendorToProduct($id_vendor_cuser, $post['product_id']);
        }
		$post['different_prices'] = 0;
        if (isset($post['product_is_add_price']) && $post['product_is_add_price']) $post['different_prices'] = 1;

        if (!isset($post['product_publish'])) $post['product_publish'] = 0;
        if (!isset($post['product_is_add_price'])) $post['product_is_add_price'] = 0;
        if (!isset($post['unlimited'])) $post['unlimited'] = 0;        
        $post['product_price'] = saveAsPrice($post['product_price']);
        $post['product_old_price'] = saveAsPrice($post['product_old_price']);
        if (isset($post['product_buy_price']))
            $post['product_buy_price'] = saveAsPrice($post['product_buy_price']);
        else 
            $post['product_buy_price'] = null;
        $post['product_weight'] = saveAsPrice($post['product_weight']);
        if(!isset($post['related_products'])) $post['related_products'] = array();
        if (!$post['product_id']) $post['product_date_added'] = getJsDate();
        if (!isset($post['attrib_price'])) $post['attrib_price'] = null;
    if (!isset($post['attrib_ind_id'])) $post['attrib_ind_id'] = array();
    if (!isset($post['attrib_ind_price'])) $post['attrib_ind_price'] = array();
    if (!isset($post['attrib_ind_price_mod'])) $post['attrib_ind_price_mod'] = array();
    
//toPrint($post,'$post',0);
    
    if (!$post['date_event']) $post['date_event'] = getJsDate();                                    // Дата показа спектакля, концерта и кино
    
    if (!isset($post['attrib_place_Int_tuple'])) $post['attrib_place_Int_tuple'] = array();            // Места интревалов ввиде строки                                    15-25
    if (!isset($post['attrib_place_Int_value_id'])) $post['attrib_place_Int_value_id'] = array();      // Места интревалов ввиде строки (без пробелов и знаков припенания) 15o25
    if (!isset($post['attrib_place_Int_id'])) $post['attrib_place_Int_id'] = null;                 // ID Атрибута                                                      9631
    if (!isset($post['attrib_place_Int_price_mod'])) $post['attrib_place_Int_price_mod'] = array();    // Знак модификации цены                                            +
    if (!isset($post['attrib_place_Int_price'])) $post['attrib_place_Int_price'] = array();            // Цена                                                             300
    
    
    if (!isset($post['attrib_place_Str_value_id'])) $post['attrib_place_Str_value_id'] = array();      // ID Value Атрибута            14991
    if (!isset($post['attrib_place_Str_id'])) $post['attrib_place_Str_id'] = array();                 // ID Атрибута                  9631
    if (!isset($post['attrib_place_Str_price_mod'])) $post['attrib_place_Str_price_mod'] = array();    // Знак модификации цены        +
    if (!isset($post['attrib_place_Str_price'])) $post['attrib_place_Str_price'] = array();            // Цена                         350
    
    // Изменено добавлено 3 строки
    $allids = array_merge($post['attrib_ind_id'], $post['attrib_place_Int_value_id'], $post['attrib_place_Str_value_id']);
    $allmods = array_merge($post['attrib_ind_price_mod'], $post['attrib_place_Int_price_mod'], $post['attrib_place_Str_price_mod']);
    $allprices = array_merge($post['attrib_ind_price'], $post['attrib_place_Int_price'], $post['attrib_place_Str_price']);
    
        if (!isset($post['freeattribut'])) $post['freeattribut'] = null;
        $post['date_modify'] = getJsDate();
        $post['edit'] = intval($post['product_id']);
        if (!isset($post['product_add_discount'])) $post['product_add_discount'] = 0;
    $post['min_price'] = $_products->getMinimalPrice($post['product_price'], $post['attrib_price'], array($allids, $allmods, $allprices), $post['product_is_add_price'], $post['product_add_discount']);// Изменено добавлено 3 массива в array
        if ($id_vendor_cuser){
            $post['vendor_id'] = $id_vendor_cuser;
        }
        
        if (isset($post['attr_count']) && is_array($post['attr_count'])){
            $qty = 0;
            foreach($post['attr_count'] as $key => $_qty) {
				$post['attr_count'][$key] = saveAsPrice($_qty);
                if ($_qty > 0) $qty += $post['attr_count'][$key];
            }

            $post['product_quantity'] = $qty;
        }
		
        if ($post['unlimited']){
            $post['product_quantity'] = 1;
        }
		
		$post['product_quantity'] = saveAsPrice($post['product_quantity']);
		
        if (isset($post['productfields']) && is_array($post['productfields'])){
            foreach($post['productfields'] as $productfield=>$val){
                if (is_array($val)){
                    $post[$productfield] = implode(',', $val);
                }
            }
        }
        if ($jshopConfig->admin_show_product_extra_field){
            $_productfields = JSFactory::getModel("productFields");
            $list_productfields = $_productfields->getList(1);
            foreach($list_productfields as $v){
                if ($v->type==0 && !isset($post['extra_field_'.$v->id])){
                    $post['extra_field_'.$v->id] = '';
                }
            }
        }

        if (is_array($post['attrib_price'])){
            if (count(array_unique($post['attrib_price']))>1) $post['different_prices'] = 1;
        }
        if (is_array($allprices)){// Изменено изменено содержимое условия
            $tmp_attr_ind_price = array();
            foreach($allprices as $k=>$v){
                $tmp_attr_ind_price[] = $allmods[$k].$allprices[$k];
            }
            if (count(array_unique($tmp_attr_ind_price))>1) $post['different_prices'] = 1;
        }
                
        $languages = $_lang->getAllLanguages(1);
        foreach($languages as $lang){
            $post['name_'.$lang->language] = trim($post['name_'.$lang->language]);
            if ($jshopConfig->create_alias_product_category_auto && $post['alias_'.$lang->language]=="") $post['alias_'.$lang->language] = $post['name_'.$lang->language];
            $post['alias_'.$lang->language] = JApplication::stringURLSafe($post['alias_'.$lang->language]);
            if ($post['alias_'.$lang->language]!="" && !$_alias->checkExistAlias2Group($post['alias_'.$lang->language], $lang->language, $post['product_id'])){
                $post['alias_'.$lang->language] = "";
                JError::raiseWarning("", __('JSHOP_ERROR_ALIAS_ALREADY_EXIST'));
            }            
             
            $post['description_'.$lang->language] = \PlaceBiletHelper::JInput()->getString('description'.$lang->id,'','post',"string", 2);
            $post['short_description_'.$lang->language] = \PlaceBiletHelper::JInput()->getString('short_description_'.$lang->language,'','post',"string", 2);
        }
        
        $dispatcher->triggerEvent('onBeforeDisplaySaveProduct', array(&$post, &$product) );
        
        if (!$product->bind($post)) {
            JError::raiseWarning("", __('JSHOP_ERROR_BIND'));
            $this->setRedirect("index.php?option=com_jshopping&controller=products");
            return 0;
        }
        
        if (($product->min_price==0 || $product->product_price==0) && !$jshopConfig->user_as_catalog && $product->parent_id==0){
            JError::raiseNotice("", __('JSHOP_YOU_NOT_SET_PRICE'));    
        }
        
        if (isset($post['set_main_image'])) {
            $image= JSFactory::getTable('image', 'jshop');
            $image->load($post['set_main_image']);
            if ($image->image_id){
                $product->image = $image->image_name;
            }
        }
 //return $product;       
        if (!$product->store()){
            JError::raiseWarning("", __('JSHOP_ERROR_SAVE_DATABASE')."<br>".$product->_error);
            $this->setRedirect("index.php?option=com_jshopping&controller=products&task=edit&product_id=".$product->product_id);
            return 0;
        }
 //return $product; 
        $product_id = $product->product_id;
        
        $dispatcher->triggerEvent('onAfterSaveProduct', array(&$product));

        if ($jshopConfig->admin_show_product_video && $product->parent_id==0) {
            $_products->uploadVideo($product, $product_id, $post);
        }

        $_products->uploadImages($product, $product_id, $post);

        if ($jshopConfig->admin_show_product_files){
            $_products->uploadFiles($product, $product_id, $post);
        }
//----------------------------------------------
        $_products->saveAttributes($product, $product_id, $post);
        
        if(PlaceBiletAdminDev) JFactory::getApplication()->enqueueMessage("<pre>Продукт : $product  ИД: ".$product_id."</pre>"); //print_r($query, TRUE)
        
    $count_row = \PlaceBiletHelper::saveAttributesPlace($product, $product_id, $post);// Изменено добавлено строка
        
        if ($jshopConfig->admin_show_freeattributes){
            $_products->saveFreeAttributes($product_id, $post['freeattribut']);
        }
        
        if ($post['product_is_add_price']){
            $_products->saveAditionalPrice($product_id, $post['product_add_discount'], $post['quantity_start'], $post['quantity_finish']);
        }
        
        if ($product->parent_id==0){
            $_products->setCategoryToProduct($product_id, $post['category_id']);
        }
        
        $_products->saveRelationProducts($product, $product_id, $post);
        $_products->saveProductOptions($product_id, (array)$post['options']);
        
        $dispatcher->triggerEvent('onAfterSaveProductEnd', array($product->product_id) );
        
        if ($product->parent_id!=0){
            print "<script type='text/javascript'>window.close();</script>";            
            die();
        }
        if(PlaceBiletAdminDev)JFactory::getApplication()->enqueueMessage("<a href='/administrator/index.php?option=com_jshopping&controller=products&task=edit&product_id=184'>Примадонны</a>"); 
        if ($this->getTask()=='apply'){
            $this->setRedirect("index.php?option=com_jshopping&controller=products&task=edit&product_id=".$product->product_id, __('JSHOP_PRODUCT_SAVED').JText::sprintf('JSHOP_PLACE_ADDED',$count_row));
        }else{
            $this->setRedirect("index.php?option=com_jshopping&controller=products", __('JSHOP_PRODUCT_SAVED').JText::sprintf('JSHOP_PLACE_ADDED',$count_row));
        }
    }   
}