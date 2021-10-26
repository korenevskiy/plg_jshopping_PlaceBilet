<?php
/**
* @version      4.11.0 05.11.2013
* @author       MAXXmarketing GmbH
* @package      Jshopping
* @copyright    Copyright (C) 2010 webdesigner-profi.de. All rights reserved.
* @license      GNU/GPL
*/
defined('_JEXEC') or die();

class JshoppingControllerProducts_mod extends JshoppingControllerProducts{
    
    function __construct($config = array()){
        parent::__construct($config);
        JPluginHelper::importPlugin('jshoppingproducts');
        JDispatcher::getInstance()->trigger('onConstructJshoppingControllerProducts', array(&$this));
    }
	
//	function display($cachable = false, $urlparams = false){
//		$jshopConfig = JSFactory::getConfig();
//		$dispatcher = JDispatcher::getInstance();
//
//		JSFactory::getModel('productShop', 'jshop')->storeEndPages();
//        
//        $product = JSFactory::getTable('product', 'jshop');
//        $params = JFactory::getApplication()->getParams();
//
//        $header = getPageHeaderOfParams($params);
//        $prefix = $params->get('pageclass_sfx');
//		
//        JshopHelpersMetadata::allProducts();
//		
//		$productlist = JSFactory::getModel('productList', 'jshop');
//        $productlist->setModel($product);
//        $productlist->load();
//        
//        $orderby = $productlist->getOrderBy();
//        $image_sort_dir = $productlist->getImageSortDir();
//        $filters = $productlist->getFilters();
//        $action = $productlist->getAction();
//        $products = $productlist->getProducts();
//        $pagination = $productlist->getPagination();
//        $pagenav = $productlist->getPagenav();
//        $sorting_sel = $productlist->getHtmlSelectSorting();
//        $product_count_sel = $productlist->getHtmlSelectCount();        
//        $willBeUseFilter = $productlist->getWillBeUseFilter();
//        $display_list_products = $productlist->getDisplayListProducts();
//        $manufacuturers_sel = $productlist->getHtmlSelectFilterManufacturer(1);
//        $categorys_sel = $productlist->getHtmlSelectFilterCategory(1);
//        $allow_review = $productlist->getAllowReview();
//
//        $view = $this->getView('products');
//		$view->setLayout("products");
//        $view->assign('config', $jshopConfig);
//        $view->assign('template_block_list_product', $productlist->getTmplBlockListProduct());
//        $view->assign('template_no_list_product', $productlist->getTmplNoListProduct());
//        $view->assign('template_block_form_filter', $productlist->getTmplBlockFormFilter());
//        $view->assign('template_block_pagination', $productlist->getTmplBlockPagination());
//        $view->assign('path_image_sorting_dir', $jshopConfig->live_path.'images/'.$image_sort_dir);
//        $view->assign('filter_show', 1);
//        $view->assign('filter_show_category', 1);
//        $view->assign('filter_show_manufacturer', 1);
//        $view->assign('pagination', $pagenav);
//        $view->assign('pagination_obj', $pagination);
//        $view->assign('display_pagination', $pagenav!="");
//        $view->assign("header", $header);
//        $view->assign("prefix", $prefix);
//		$view->assign("rows", $products);
//		$view->assign("count_product_to_row", $productlist->getCountProductsToRow());
//        $view->assign('action', $action);
//        $view->assign('allow_review', $allow_review);
//		$view->assign('orderby', $orderby);		
//		$view->assign('product_count', $product_count_sel);
//        $view->assign('sorting', $sorting_sel);
//        $view->assign('categorys_sel', $categorys_sel);
//        $view->assign('manufacuturers_sel', $manufacuturers_sel);
//        $view->assign('filters', $filters);
//        $view->assign('willBeUseFilter', $willBeUseFilter);
//        $view->assign('display_list_products', $display_list_products);
//        $view->assign('shippinginfo', SEFLink($jshopConfig->shippinginfourl,1));
//        $dispatcher->trigger('onBeforeDisplayProductListView', array(&$view) );	
//		$view->display();
//	}
//    
//    function tophits(){
//        JshopHelpersMetadata::productsTophits();
//        $this->verySimpleProductList('tophits');        
//    }
//    
//    function toprating(){
//        JshopHelpersMetadata::productsToprating();
//        $this->verySimpleProductList('toprating');
//    }
//    
//    function label(){
//        JshopHelpersMetadata::productsLabel();
//        $this->verySimpleProductList('label');
//    }
//    
//    function bestseller(){
//        JshopHelpersMetadata::productsBestseller();
//        $this->verySimpleProductList('bestseller');
//    }
//    
//    function random(){
//        JshopHelpersMetadata::productsRandom();
//        $this->verySimpleProductList('random');
//    }
//    
//    function last(){
//        JshopHelpersMetadata::productsLast();
//        $this->verySimpleProductList('last');
//    }
//    
//    protected function verySimpleProductList($type){        
//        $jshopConfig = JSFactory::getConfig();        
//        
//		JSFactory::getModel('productShop', 'jshop')->storeEndPages();		
//
//        $params = JFactory::getApplication()->getParams();
//        $header = getPageHeaderOfParams($params);
//        $prefix = $params->get('pageclass_sfx');
//                
//        $modellist = JSFactory::getModel('products'.$type, 'jshop');
//        $productlist = JSFactory::getModel('productList', 'jshop');
//        $productlist->setMultiPageList(0);
//        $productlist->setModel($modellist);
//        $productlist->load();
//        $productlist->configDisableSortAndFilters();
//        
//        $products = $productlist->getProducts();        
//        $display_list_products = $productlist->getDisplayListProducts();        
//        $allow_review = $productlist->getAllowReview();
//
//        $view = $this->getView('products');
//        $view->setLayout("products");
//        $view->assign('config', $jshopConfig);
//		$view->assign('template_block_list_product', $productlist->getTmplBlockListProduct());
//        $view->assign('template_block_form_filter', $productlist->getTmplBlockFormFilter());
//        $view->assign('template_block_pagination', $productlist->getTmplBlockPagination());
//        $view->assign("header", $header);
//        $view->assign("prefix", $prefix);
//        $view->assign("rows", $products);
//        $view->assign("count_product_to_row", $productlist->getCountProductsToRow());
//        $view->assign('allow_review', $allow_review);
//        $view->assign('display_list_products', $display_list_products);
//        $view->assign('display_pagination', 0);
//        $view->assign('shippinginfo', SEFLink($jshopConfig->shippinginfourl,1));
//        JDispatcher::getInstance()->trigger('onBeforeDisplayProductListView', array(&$view));
//        $view->display();
//    }

}