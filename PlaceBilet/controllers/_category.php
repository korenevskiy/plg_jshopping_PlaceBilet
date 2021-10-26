<?php
/**
* @version      4.11.0 05.11.2013
* @author       MAXXmarketing GmbH
* @package      Jshopping
* @copyright    Copyright (C) 2010 webdesigner-profi.de. All rights reserved.
* @license      GNU/GPL
*/
defined('_JEXEC') or die();

class JshoppingControllerCategory_mod extends JshoppingControllerCategory{
    
    function __construct($config = array()){
        parent::__construct($config);
        JPluginHelper::importPlugin('jshoppingproducts');
        JDispatcher::getInstance()->trigger('onConstructJshoppingControllerCategory', array(&$this));
        
        $this->registerTask('__default', 'display' );
        $this->registerTask('add', 'edit' );
        $this->registerTask('apply', 'save');
    }
    
//    function display($cachable = false, $urlparams = false){
//        
//        $mainframe = JFactory::getApplication();
//		$dispatcher = JDispatcher::getInstance();
//        $jshopConfig = JSFactory::getConfig();
//        $params = $mainframe->getParams();
//        $category_id = 0;
//        
//        $category = JSFactory::getTable('category', 'jshop');
//        $category->load($category_id);
//        $category->getDescription();
//        
//        $categories = $category->getChildCategories($category->getFieldListOrdering(), $category->getSortingDirection(), 1);
//
//        $dispatcher->trigger('onBeforeDisplayMainCategory', array(&$category, &$categories, &$params));
//
//		JshopHelpersMetadata::mainCategory($category, $params);
//
//        $view = $this->getView('category');
//        $view->setLayout("maincategory");
//        $view->assign('category', $category);
//        $view->assign('image_category_path', $jshopConfig->image_category_live_path);
//        $view->assign('noimage', $jshopConfig->noimage);
//        $view->assign('categories', $categories);
//        $view->assign('count_category_to_row', $category->getCountToRow());
//        $view->assign('params', $params);
//        $dispatcher->trigger('onBeforeDisplayCategoryView', array(&$view));
//          echo "<pre>\$view: $view <br>".print_r($classControllerMod, true)." ". "</pre>";
//        $view->display();
//    }
//
//    function view(){
//        $user = JFactory::getUser();
//        $jshopConfig = JSFactory::getConfig();
//		$dispatcher = JDispatcher::getInstance();        
//        $category_id = PlaceBiletHelper::JRequest()->getInt('category_id');
//
//		JSFactory::getModel('productShop', 'jshop')->storeEndPages();
//
//        $category = JSFactory::getTable('category', 'jshop');
//        $category->load($category_id);
//        $category->getDescription();
//        $dispatcher->trigger('onAfterLoadCategory', array(&$category, &$user));
//
//		if (!$category->checkView($user)){
//            JError::raiseError(404, _JSHOP_PAGE_NOT_FOUND);
//            return;
//        }
//        
//        $sub_categories = $category->getChildCategories($category->getFieldListOrdering(), $category->getSortingDirection(), 1);
//        $dispatcher->trigger('onBeforeDisplayCategory', array(&$category, &$sub_categories) );
//		
//		JshopHelpersMetadata::category($category);
//        
//        $productlist = JSFactory::getModel('productList', 'jshop');
//        $productlist->setModel($category);
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
//        $manufacuturers_sel = $productlist->getHtmlSelectFilterManufacturer();
//        $allow_review = $productlist->getAllowReview();
//
//        $view = $this->getView('category');
//        $view->setLayout("category_".$category->category_template);
//        $view->assign('config', $jshopConfig);
//        $view->assign('template_block_list_product', $productlist->getTmplBlockListProduct());
//        $view->assign('template_no_list_product', $productlist->getTmplNoListProduct());
//        $view->assign('template_block_form_filter', $productlist->getTmplBlockFormFilter());
//        $view->assign('template_block_pagination', $productlist->getTmplBlockPagination());
//        $view->assign('path_image_sorting_dir', $jshopConfig->live_path.'images/'.$image_sort_dir);
//        $view->assign('filter_show', 1);
//        $view->assign('filter_show_category', 0);
//        $view->assign('filter_show_manufacturer', 1);
//        $view->assign('pagination', $pagenav);
//		$view->assign('pagination_obj', $pagination);
//        $view->assign('display_pagination', $pagenav!="");
//        $view->assign('rows', $products);
//        $view->assign('count_product_to_row', $productlist->getCountProductsToRow());
//        $view->assign('image_category_path', $jshopConfig->image_category_live_path);
//        $view->assign('noimage', $jshopConfig->noimage);
//        $view->assign('category', $category);
//        $view->assign('categories', $sub_categories);
//        $view->assign('count_category_to_row', $category->getCountToRow());
//        $view->assign('allow_review', $allow_review);
//        $view->assign('product_count', $product_count_sel);
//        $view->assign('sorting', $sorting_sel);
//        $view->assign('action', $action);
//        $view->assign('orderby', $orderby);
//        $view->assign('manufacuturers_sel', $manufacuturers_sel);
//        $view->assign('filters', $filters);
//        $view->assign('willBeUseFilter', $willBeUseFilter);
//        $view->assign('display_list_products', $display_list_products);
//        $view->assign('shippinginfo', SEFLink($jshopConfig->shippinginfourl,1));
//        $dispatcher->trigger('onBeforeDisplayProductListView', array(&$view) );
//        $view->display();
//    }
}