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
defined('_JEXEC') or die();

class JshoppingControllerCategory_mod extends JshoppingControllerCategory{
    
    function __construct($config = array()){
        parent::__construct($config);
//        JPluginHelper::importPlugin('jshoppingproducts');
//        \JFactory::getApplication()->triggerEvent('onConstructJshoppingControllerCategory', array(&$this));
        
        $this->registerTask('__default', 'display' );
        $this->registerTask('add', 'edit' );
        $this->registerTask('apply', 'save');
    }
    
//    function display($cachable = false, $urlparams = false){
//        
//        $mainframe = JFactory::getApplication();
//		$dispatcher = \JFactory::getApplication();
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
//        $dispatcher->triggerEvent('onBeforeDisplayMainCategory', array(&$category, &$categories, &$params));
//
//		JshopHelpersMetadata::mainCategory($category, $params);
//
//        $view = $this->getView('category');
//        $view->setLayout("maincategory");
//        $view->set('category', $category);
//        $view->set('image_category_path', $jshopConfig->image_category_live_path);
//        $view->set('noimage', $jshopConfig->noimage);
//        $view->set('categories', $categories);
//        $view->set('count_category_to_row', $category->getCountToRow());
//        $view->set('params', $params);
//        $dispatcher->triggerEvent('onBeforeDisplayCategoryView', array(&$view));
//          echo "<pre>\$view: $view <br>".print_r($classControllerMod, true)." ". "</pre>";
//        $view->display();
//    }
//
//    function view(){
//        $user = JFactory::getUser();
//        $jshopConfig = JSFactory::getConfig();
//		$dispatcher = \JFactory::getApplication();        
//        $category_id = PlaceBiletHelper::JRequest()->getInt('category_id');
//
//		JSFactory::getModel('productShop', 'jshop')->storeEndPages();
//
//        $category = JSFactory::getTable('category', 'jshop');
//        $category->load($category_id);
//        $category->getDescription();
//        $dispatcher->triggerEvent('onAfterLoadCategory', array(&$category, &$user));
//
//		if (!$category->checkView($user)){
//            JError::raiseError(404, __('JSHOP_PAGE_NOT_FOUND'));
//            return;
//        }
//        
//        $sub_categories = $category->getChildCategories($category->getFieldListOrdering(), $category->getSortingDirection(), 1);
//        $dispatcher->triggerEvent('onBeforeDisplayCategory', array(&$category, &$sub_categories) );
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
//        $view->set('config', $jshopConfig);
//        $view->set('template_block_list_product', $productlist->getTmplBlockListProduct());
//        $view->set('template_no_list_product', $productlist->getTmplNoListProduct());
//        $view->set('template_block_form_filter', $productlist->getTmplBlockFormFilter());
//        $view->set('template_block_pagination', $productlist->getTmplBlockPagination());
//        $view->set('path_image_sorting_dir', $jshopConfig->live_path.'images/'.$image_sort_dir);
//        $view->set('filter_show', 1);
//        $view->set('filter_show_category', 0);
//        $view->set('filter_show_manufacturer', 1);
//        $view->set('pagination', $pagenav);
//		$view->set('pagination_obj', $pagination);
//        $view->set('display_pagination', $pagenav!="");
//        $view->set('rows', $products);
//        $view->set('count_product_to_row', $productlist->getCountProductsToRow());
//        $view->set('image_category_path', $jshopConfig->image_category_live_path);
//        $view->set('noimage', $jshopConfig->noimage);
//        $view->set('category', $category);
//        $view->set('categories', $sub_categories);
//        $view->set('count_category_to_row', $category->getCountToRow());
//        $view->set('allow_review', $allow_review);
//        $view->set('product_count', $product_count_sel);
//        $view->set('sorting', $sorting_sel);
//        $view->set('action', $action);
//        $view->set('orderby', $orderby);
//        $view->set('manufacuturers_sel', $manufacuturers_sel);
//        $view->set('filters', $filters);
//        $view->set('willBeUseFilter', $willBeUseFilter);
//        $view->set('display_list_products', $display_list_products);
//        $view->set('shippinginfo', SEFLink($jshopConfig->shippinginfourl,1));
//        $dispatcher->triggerEvent('onBeforeDisplayProductListView', array(&$view) );
//        $view->display();
//    }
}