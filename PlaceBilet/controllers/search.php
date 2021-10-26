<?php
 
/**
* @version      4.11.0 10.08.2014
* @author       MAXXmarketing GmbH
* @package      Jshopping
* @copyright    Copyright (C) 2010 webdesigner-profi.de. All rights reserved.
* @license      GNU/GPL
*/
defined('_JEXEC') or die();
jimport('joomla.html.pagination');
// toPrint($file);
class JshoppingControllerSearch_mod extends JshoppingControllerSearch{
    
    function __construct($config = array()){
        parent::__construct($config);
        JPluginHelper::importPlugin('jshoppingproducts');
        JDispatcher::getInstance()->trigger('onConstructJshoppingControllerSearch', array(&$this));
    }
    
    function display($cachable = false, $urlparams = false){
        
        
//        $word = PlaceBiletHelper::JRequest()->getString('search');
//        print_r($word);
//        toPrint($word);
//        return;
        
    	$jshopConfig = JSFactory::getConfig();    	
        $Itemid = PlaceBiletHelper::JRequest()->getInt('Itemid');
		$category_id = PlaceBiletHelper::JRequest()->getInt('category_id');
		
		JHTML::_('behavior.calendar');
		
        $dispatcher = JDispatcher::getInstance();
        $dispatcher->trigger('onBeforeLoadSearchForm', array());
        		
		JshopHelpersMetadata::search();
		
		$list_categories =  JshopHelpersSelects::getSearchCategory();		        
        $list_manufacturers = JshopHelpersSelects::getManufacturer();        
        $characteristics = $this->load_tmpl_characteristics($category_id);        

        $view = $this->getView("search");
        $view->setLayout("form");
		$view->assign('list_categories', $list_categories);
        $view->assign('list_manufacturers', $list_manufacturers);
		$view->assign('characteristics', $characteristics);
        $view->assign('config', $jshopConfig);
        $view->assign('Itemid', $Itemid);
		$view->assign('action', SEFLink("index.php?option=com_jshopping&controller=search&task=result"));
        $dispatcher->trigger('onBeforeDisplaySearchFormView', array(&$view) );
		$view->display();
    }
    
    function result(){        
//    echo '123';
        $word = PlaceBiletHelper::JRequest()->getString('search');
//        print_r($word);
//        toPrint($word);
        return;
        
        $jshopConfig = JSFactory::getConfig();		

		JSFactory::getModel('productShop', 'jshop')->storeEndPages();

		JshopHelpersMetadata::searchResult();
		
		$modellist = JSFactory::getModel('productssearch', 'jshop');
		$productlist = JSFactory::getModel('productList', 'jshop');
        $productlist->setModel($modellist);
        $productlist->load();
		
		$orderby = $productlist->getOrderBy();
        $image_sort_dir = $productlist->getImageSortDir();        
        $action = $productlist->getAction();
        $products = $productlist->getProducts();
        $pagination = $productlist->getPagination();
        $pagenav = $productlist->getPagenav();
		$total = $productlist->getTotal();
		$filters = $productlist->getFilters();
        $sorting_sel = $productlist->getHtmlSelectSorting();
        $product_count_sel = $productlist->getHtmlSelectCount();                
        $allow_review = $productlist->getAllowReview();
		$search = $filters['search'];
		
        if (!$total){
            $this->noresult($search);
            return 0;
        }

        $view = $this->getView("search");
        $view->setLayout("products");
        $view->assign('search', $search);
        $view->assign('total', $total);
        $view->assign('config', $jshopConfig);
		$view->assign('template_block_list_product', $productlist->getTmplBlockListProduct());
        $view->assign('template_block_form_filter', $productlist->getTmplBlockFormFilter());
        $view->assign('template_block_pagination', $productlist->getTmplBlockPagination());
        $view->assign('path_image_sorting_dir', $jshopConfig->live_path.'images/'.$image_sort_dir);
        $view->assign('filter_show', 0);
        $view->assign('filter_show_category', 0);
        $view->assign('filter_show_manufacturer', 0);
        $view->assign('pagination', $pagenav);
		$view->assign('pagination_obj', $pagination);
        $view->assign('display_pagination', $pagenav!="");
        $view->assign('product_count', $product_count_sel);
        $view->assign('sorting', $sorting_sel);
        $view->assign('action', $action);
        $view->assign('orderby', $orderby);
        $view->assign('count_product_to_row', $productlist->getCountProductsToRow());
        $view->assign('rows', $products);
        $view->assign('allow_review', $allow_review);
        $view->assign('shippinginfo', SEFLink($jshopConfig->shippinginfourl,1));
        JDispatcher::getInstance()->trigger('onBeforeDisplayProductListView', array(&$view));
        $view->display();
    }
    
    function get_html_characteristics(){        
        $category_id = PlaceBiletHelper::JRequest()->getInt("category_id");
        print $this->load_tmpl_characteristics($category_id);
		die();    
    }
	
	private function noresult($search){
		$view = $this->getView('search');
		$view->setLayout("noresult");
		$view->assign('search', $search);
		$view->display();
	}
	
	private function load_tmpl_characteristics($category_id){
		$jshopConfig = JSFactory::getConfig();		
		if ($jshopConfig->admin_show_product_extra_field){
            $dispatcher = JDispatcher::getInstance();
            $characteristic_fields = JSFactory::getAllProductExtraField();			
            $characteristic_fieldvalues = JSFactory::getAllProductExtraFieldValueDetail();
            $characteristic_displayfields = JSFactory::getDisplayFilterExtraFieldForCategory($category_id);

            $view = $this->getView("search");
            $view->setLayout("characteristics");
            $view->assign('characteristic_fields', $characteristic_fields);
            $view->assign('characteristic_fieldvalues', $characteristic_fieldvalues);
            $view->assign('characteristic_displayfields', $characteristic_displayfields);
            $dispatcher->trigger('onBeforeDisplaySearchHtmlCharacteristics', array(&$view));
            $html = $view->loadTemplate();
        }else{
			$html = '';
		}
		return $html;
	}
	
}