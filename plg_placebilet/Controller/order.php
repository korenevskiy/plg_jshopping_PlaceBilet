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
namespace Joomla\Component\Jshopping\Site\Controller;
//namespace Controller;
use Joomla\Component\Jshopping\Site\Helper\Metadata;
use Joomla\Component\Jshopping\Site\Helper\Request;
use Joomla\Component\Jshopping\Site\Controller;
defined('_JEXEC') or die(); 


include_once JPATH_COMPONENT_SITE . '/Controller/BaseController.php';

//jimport('joomla.html.pagination');

class OrderController extends \Joomla\Component\Jshopping\Site\Controller\BaseController{
//JshoppingControllerOrder_mod Controller\OrderController  Joomla\Component\Jshopping\Site\Controller\OrderController
//    public function init(){
//        \JPluginHelper::importPlugin('jshopping');
//        $obj = $this;
//        \JFactory::getApplication()->triggerEvent('onConstructJshoppingControllerOrder', array(&$obj));
//    }

    function display($cachable = false, $urlparams = false){
		
		echo "Проверка Заказа";
		
		return;
		
		
        $jshopConfig = \JSFactory::getConfig();
        $user = \JFactory::getUser();
		$dispatcher = \JFactory::getApplication();
		$model = \JSFactory::getModel('productShop', 'Site');
		
		$ajax = $this->input->getInt('ajax');
        $tmpl = $this->input->getVar("tmpl");
		$product_id = (int)$this->input->getInt('product_id');
        $category_id = (int)$this->input->getInt('category_id');
        $attr = $this->input->getVar("attr");
		
		\JSFactory::loadJsFilesLightBox();
		
        if ($tmpl!="component"){
			$model->storeEndPageBuy();
        }
		
        $back_value = $model->getBackValue($product_id, $attr);

        $dispatcher->triggerEvent('onBeforeLoadProduct', array(&$product_id, &$category_id, &$back_value));
        $dispatcher->triggerEvent('onBeforeLoadProductList', array());

        $product = \JSFactory::getTable('product');
        $product->load($product_id);
        $product->_tmp_var_price_ext = "";
        $product->_tmp_var_old_price_ext = "";
        $product->_tmp_var_bottom_price = "";
        $product->_tmp_var_bottom_allprices = "";
		
		$category = \JSFactory::getTable('category');
        $category->load($category_id);
        $category->name = $category->getName();
		
		$model->setProduct($product);
		
        $listcategory = $model->getCategories(1);
		
		$model->prepareView($back_value);
		$model->clearBackValue();
		
		$attributes = $model->getAttributes();
        $all_attr_values = $model->getAllAttrValues();

		if (!$product->checkView($category, $user, $category_id, $listcategory)){
            throw new \Exception(\JText::_('JSHOP_PAGE_NOT_FOUND'), 404);
            return;
        }
        
        Metadata::product($category, $product);
        
        $product->hit();
        		
		$allow_review = $model->getAllowReview();
		$text_review = $model->getTextReview();

        $hide_buy = $model->getHideBuy();        
        $available = $model->getTextAvailable();
		$default_count_product = $model->getDefaultCountProduct($back_value);
        $displaybuttons = $model->getDisplayButtonsStyle();
        $product_images = $product->getImages();
        $product_videos = $product->getVideos();
        $product_demofiles = $product->getDemoFiles();
        if ($jshopConfig->admin_show_product_related){
            $productlist = \JSFactory::getModel('related', 'Site\\Productlist');
            $productlist->setTable($product);
            $listProductRelated = $productlist->getLoadProducts();
        }else{
            $listProductRelated = [];
        }
		$dispatcher->triggerEvent('onBeforeDisplayProductList', array(&$listProductRelated));
        
        $view = $this->getView("product");
        $view->setLayout("product_".$product->product_template);
        $view->_tmp_product_html_start = "";
        $view->_tmp_product_html_before_image = "";
        $view->_tmp_product_html_body_image = "";
        $view->_tmp_product_html_after_image = "";
        $view->_tmp_product_html_before_image_thumb = "";
        $view->_tmp_product_html_after_image_thumb = "";
        $view->_tmp_product_html_after_video = "";
        $view->_tmp_product_html_before_atributes = "";
        $view->_tmp_product_html_after_atributes = "";
        $view->_tmp_product_html_after_freeatributes = "";
        $view->_tmp_product_html_before_price = "";
        $view->_tmp_product_html_after_ef = "";
        $view->_tmp_product_html_before_buttons = "";
        $view->_tmp_qty_unit = "";
        $view->_tmp_product_html_buttons = "";
        $view->_tmp_product_html_after_buttons = "";
        $view->_tmp_product_html_before_demofiles = "";
        $view->_tmp_product_html_before_review = "";
        $view->_tmp_product_html_before_related = "";
        $view->_tmp_product_html_end = "";
        $view->_tmp_product_review_before_submit = "";
        $view->_tmp_product_ext_js = "";
        $dispatcher->triggerEvent('onBeforeDisplayProduct', array(&$product, &$view, &$product_images, &$product_videos, &$product_demofiles) );
        $view->set('config', $jshopConfig);
        $view->set('image_path', $jshopConfig->live_path.'/images');
        $view->set('noimage', $jshopConfig->noimage);
        $view->set('image_product_path', $jshopConfig->image_product_live_path);
        $view->set('video_product_path', $jshopConfig->video_product_live_path);
        $view->set('video_image_preview_path', $jshopConfig->video_product_live_path);
        $view->set('product', $product);
        $view->set('category_id', $category_id);
        $view->set('images', $product_images);
        $view->set('videos', $product_videos);
        $view->set('demofiles', $product_demofiles);
        $view->set('attributes', $attributes);
        $view->set('all_attr_values', $all_attr_values);
        $view->set('related_prod', $listProductRelated);
        $view->set('path_to_image', $jshopConfig->live_path . 'images/');
        $view->set('live_path', \JURI::root());
        $view->set('enable_wishlist', $jshopConfig->enable_wishlist);
        $view->set('action', \JSHelper::SEFLink('index.php?option=com_jshopping&controller=cart&task=add',1));
        $view->set('urlupdateprice', \JSHelper::SEFLink('index.php?option=com_jshopping&controller=product&task=ajax_attrib_select_and_price&product_id='.$product_id.'&ajax=1',1,1));
        if ($allow_review){
			\JSFactory::loadJsFilesRating();
			$modelreviewlist = \JSFactory::getModel('productReviewList', 'Site');
			$modelreviewlist->setModel($product);
			$modelreviewlist->load();
			$review_list = $modelreviewlist->getList();
			$pagination = $modelreviewlist->getPagination();
			$pagenav = $pagination->getPagesLinks();
            $view->set('reviews', $review_list);
            $view->set('pagination', $pagenav);
			$view->set('pagination_obj', $pagination);
            $view->set('display_pagination', $pagenav!="");
        }
        $view->set('allow_review', $allow_review);
        $view->set('text_review', $text_review);
        $view->set('stars_count', floor($jshopConfig->max_mark / $jshopConfig->rating_starparts));
        $view->set('parts_count', $jshopConfig->rating_starparts);
        $view->set('user', $user);
        $view->set('shippinginfo', \JSHelper::SEFLink($jshopConfig->shippinginfourl,1));
        $view->set('hide_buy', $hide_buy);
        $view->set('available', $available);
        $view->set('default_count_product', $default_count_product);
        $view->set('folder_list_products', "list_products");
        $view->set('back_value', $back_value);
		$view->set('displaybuttons', $displaybuttons);
        $view->set('prod_qty_input_type', $jshopConfig->use_decimal_qty ? 'text' : 'number');

        $dispatcher->triggerEvent('onBeforeDisplayProductView', array(&$view));        
        $view->display();
        $dispatcher->triggerEvent('onAfterDisplayProduct', array(&$product));
        if ($ajax) die();
    }
     
}