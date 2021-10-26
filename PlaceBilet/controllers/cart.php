<?php
/**
* @version      4.11.0 08.09.2015
* @author       MAXXmarketing GmbH
* @package      Jshopping
* @copyright    Copyright (C) 2010 webdesigner-profi.de. All rights reserved.
* @license      GNU/GPL
*/
defined('_JEXEC') or die();

class JshoppingControllerCart_mod extends JshoppingControllerCart{
    
//    function __construct($config = array()){
//        parent::__construct($config);
//        
//        $this->registerTask('apply', 'save');
//        
////        JPluginHelper::importPlugin('jshoppingcheckout');
////        JDispatcher::getInstance()->trigger('onConstructJshoppingControllerCart', array(&$this));
//    }
    
//    function display($cachable = false, $urlparams = false){ 
//        
//        
//        echo "<pre>CART ......:    <br/>".print_r("", TRUE);
//        echo "</pre>"; 
//        
//        $this->view();
//    }

    
    
    
    
    
//    function view(){
////                  echo "<pre>CART ......:    <br/>".print_r("", TRUE);
////        echo "</pre>";
////        
////        $this->add();
////        return;
//        
//        
//	    $jshopConfig = JSFactory::getConfig();		
//        if (!JshopHelpersCart::checkView()){
//			return 0;
//	}
//        
//        
//	$dispatcher = JDispatcher::getInstance();
//        $ajax = PlaceBiletHelper::JRequest()->getInt('ajax');
//		
//	JshopHelpersMetadata::cart();
//        
//	$cart = JSFactory::getModel('cart', 'jshop')->init('cart', 1);
//        
//	$cartpreview = JSFactory::getModel('cartPreview', 'jshop');
//        $cartpreview->setCart($cart);
//	$cartpreview->setCheckoutStep(0);
//        
//        
// 
//        
//        
//        $shopurl = $cartpreview->getBackUrlShop();
//        $cartdescr = $cartpreview->getCartStaticText();
//        $href_checkout = $cartpreview->getUrlCheckout();        
//		$show_percent_tax = $cartpreview->getShowPercentTax();
//        $hide_subtotal = $cartpreview->getHideSubtotal();
//        $checkout_navigator = JSFactory::getModel('checkout', 'jshop')->showCheckoutNavigation('0');
//
//        $view = $this->getView('cart');
//        $view->setLayout("cart");
//        $view->assign('config', $jshopConfig);
//		$view->assign('products', $cartpreview->getProducts());
//		$view->assign('summ', $cartpreview->getSubTotal());
//		$view->assign('image_product_path', $jshopConfig->image_product_live_path);
//		$view->assign('image_path', $jshopConfig->live_path);
//        $view->assign('no_image', $jshopConfig->noimage);
//		$view->assign('href_shop', $shopurl);
//        $view->assign('href_checkout', $href_checkout);
//        $view->assign('discount', $cartpreview->getDiscount());
//		$view->assign('free_discount', $cartpreview->getFreeDiscount());
//		$view->assign('use_rabatt', $jshopConfig->use_rabatt_code);
//		$view->assign('tax_list', $cartpreview->getTaxExt());
//        $view->assign('fullsumm', $cartpreview->getFullSum());
//        $view->assign('show_percent_tax', $show_percent_tax);
//        $view->assign('hide_subtotal', $hide_subtotal);
//        $view->assign('weight', $cartpreview->getWeight());
//        $view->assign('shippinginfo', SEFLink($jshopConfig->shippinginfourl, 1));
//        $view->assign('cartdescr', $cartdescr);
//		$view->assign('checkout_navigator', $checkout_navigator);
//        $dispatcher->trigger('onBeforeDisplayCartView', array(&$view));
//		$view->display();
//        if ($ajax) die();
//    }
    
    function add(){
        header("Cache-Control: no-cache, must-revalidate");
        
        if (!JshopHelpersCart::checkAdd()){
			return 0;
		}

//          echo "<pre>CART:  $attribut <br/>".print_r($attribut, TRUE);
//        echo "</pre>";
//        return 1;         
        
		$jshopConfig = JSFactory::getConfig();
        $ajax = PlaceBiletHelper::JRequest()->getInt('ajax');
        $product_id = PlaceBiletHelper::JRequest()->getInt('product_id');
        $category_id = PlaceBiletHelper::JRequest()->getInt('category_id');
		$quantity = JshopHelpersRequest::getQuantity();//int колличество quantity из JRequest
		$attribut = JshopHelpersRequest::getAttribute();//array массив jshop_attr_id и прогонка элементов по intval из JRequest
        $to = JshopHelpersRequest::getCartTo();// получение PlaceBiletHelper::JRequest()->get 'to' если нет то будет "cart" (бывает так же wishlist)
        $freeattribut = JshopHelpersRequest::getFreeAttribute();// получение freeattribut массива из JRequest
        
        $places_Ids = PlaceBiletHelper::getPlacesRequest();// Изменено Добавлено
        

        
        
        $checkout = JSFactory::getModel('checkout', 'jshop');
        $checkout->setMaxStep(2);
        
        $cart = JSFactory::getModel('cart', 'jshop');
        $cart->load($to);

      
        if (!$cart->add($product_id, $quantity, $attribut, $freeattribut)){
            if ($ajax){
                print getMessageJson();
                die();
            }
            $modelproduct = JSFactory::getModel('productShop', 'jshop');
            $modelproduct->setBackValue(array('pid'=>$product_id, 'attr'=>$attribut, 'freeattr'=>$freeattribut,'qty'=>$quantity));
            $this->setRedirect(SEFLink('index.php?option=com_jshopping&controller=product&task=view&category_id='.$category_id.'&product_id='.$product_id,1,1));
            return 0;
        }
        
//return 1;
        if ($ajax){
            print getOkMessageJson($cart);
            die();
        }

        if ($jshopConfig->not_redirect_in_cart_after_buy){
            $this->setRedirect($_SERVER['HTTP_REFERER'], $cart->getMessageAddToCart());
            return 1;
        }

        if ($to=="cart"){
            $defaultitemid = 0;
        }else{
            $defaultitemid = 1;
	}

	$this->setRedirect(SEFLink($cart->getUrlList(), $defaultitemid, 1));
    }

//
//    function delete(){
//        header("Cache-Control: no-cache, must-revalidate");
//        $ajax = PlaceBiletHelper::JRequest()->getInt('ajax');
//        $number_id = PlaceBiletHelper::JRequest()->getInt('number_id');
//        $checkout = JSFactory::getModel('checkout', 'jshop');
//        $checkout->setMaxStep(2);
//        $cart = JSFactory::getModel('cart', 'jshop');
//        $cart->load();    
//        $cart->delete($number_id);
//        if ($ajax){
//            print getOkMessageJson($cart);
//            die();
//        }
//        $this->setRedirect( SEFLink($cart->getUrlList(),0,1) );
//    }
//
//    function refresh(){
//        $ajax = PlaceBiletHelper::JRequest()->getInt('ajax');
//        $quantitys = PlaceBiletHelper::JRequest()->get('quantity');
//        $checkout = JSFactory::getModel('checkout', 'jshop');
//        $checkout->setMaxStep(2);
//        $cart = JSFactory::getModel('cart', 'jshop');
//        $cart->load();
//        $cart->refresh($quantitys);
//        if ($ajax){
//            print getOkMessageJson($cart);
//            die();
//        }
//        $this->setRedirect( SEFLink($cart->getUrlList(),0,1) );
//    }
//
//    function discountsave(){
//        $dispatcher = JDispatcher::getInstance();
//        $dispatcher->trigger('onLoadDiscountSave', array());
//        
//        $ajax = PlaceBiletHelper::JRequest()->getInt('ajax');
//        $code = PlaceBiletHelper::JRequest()->get('rabatt');
//        
//        $checkout = JSFactory::getModel('checkout', 'jshop');
//        $checkout->setMaxStep(2);
//        
//        $coupon = JSFactory::getTable('coupon', 'jshop');
//		$cart = JSFactory::getModel('cart', 'jshop');
//
//        if ($coupon->getEnableCode($code)){
//            $cart->load();
//            $dispatcher->trigger('onBeforeDiscountSave', array(&$coupon, &$cart));
//            $cart->setRabatt($coupon->coupon_id, $coupon->coupon_type, $coupon->coupon_value);
//            $dispatcher->trigger('onAfterDiscountSave', array(&$coupon, &$cart));
//            if ($ajax){
//                print getOkMessageJson($cart);
//                die();
//            }
//        }else{
//            JError::raiseWarning('', $coupon->error);
//            if ($ajax){
//                print getMessageJson();
//                die();
//            }
//        }
//        $this->setRedirect( SEFLink($cart->getUrlList(),0,1) );
//    }
}