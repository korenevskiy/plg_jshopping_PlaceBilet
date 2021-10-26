<?php
/**
* @version      4.11.1 18.12.2014
* @author       MAXXmarketing GmbH
* @package      Jshopping
* @copyright    Copyright (C) 2010 webdesigner-profi.de. All rights reserved.
* @license      GNU/GPL
*/
defined('_JEXEC') or die();

class JshoppingControllerCheckout_mod extends JshoppingControllerCheckout{
//    
//    function __construct($config = array()){
//        parent::__construct($config);
//        JPluginHelper::importPlugin('jshoppingcheckout');
//        JPluginHelper::importPlugin('jshoppingorder');
//        JDispatcher::getInstance()->trigger('onConstructJshoppingControllerCheckout', array(&$this));
//    }
//    
////    function display($cachable = false, $urlparams = false){
////        $this->step2();
////    }
//    
//    function step2(){
//        $checkout = JSFactory::getModel('checkout', 'jshop');
//        $checkout->checkStep(2);
//        $dispatcher = JDispatcher::getInstance();
//        $dispatcher->trigger('onLoadCheckoutStep2', array());
//        
//        $jshopConfig = JSFactory::getConfig();
//        
//        $checkLogin = PlaceBiletHelper::JRequest()->getInt('check_login');
//        if ($checkLogin){
//            JSFactory::getModel('userlogin', 'jshop')->setPayWithoutReg();
//            checkUserLogin();
//        }
//		
//		JshopHelpersMetadata::checkoutAddress();
//
//        $adv_user = JSFactory::getUser()->loadDataFromEdit();
//        
//        $config_fields = $jshopConfig->getListFieldsRegisterType('address');
//        $count_filed_delivery = $jshopConfig->getEnableDeliveryFiledRegistration('address');
//
//        $checkout_navigator = $checkout->showCheckoutNavigation(2);        
//        $small_cart = $checkout->loadSmallCart(2);
//		
//		$select_countries = JshopHelpersSelects::getCountry($adv_user->country);
//		$select_d_countries = JshopHelpersSelects::getCountry($adv_user->d_country, null, 'd_country');
//		$select_titles = JshopHelpersSelects::getTitle($adv_user->title);
//		$select_d_titles = JshopHelpersSelects::getTitle($adv_user->d_title, null, 'd_title');
//		$select_client_types = JshopHelpersSelects::getClientType($adv_user->client_type);
//        
//        filterHTMLSafe($adv_user, ENT_QUOTES);
//
//		if ($config_fields['birthday']['display'] || $config_fields['d_birthday']['display']){
//            JHTML::_('behavior.calendar');
//        }
//
//        $view = $this->getView("checkout");
//        $view->setLayout("adress");
//        $view->assign('select', $jshopConfig->user_field_title);		
//        $view->assign('config', $jshopConfig);
//        $view->assign('select_countries', $select_countries);
//        $view->assign('select_d_countries', $select_d_countries);
//        $view->assign('select_titles', $select_titles);
//        $view->assign('select_d_titles', $select_d_titles);
//        $view->assign('select_client_types', $select_client_types);
//        $view->assign('live_path', JURI::base());
//        $view->assign('config_fields', $config_fields);
//        $view->assign('count_filed_delivery', $count_filed_delivery);
//        $view->assign('user', $adv_user);
//        $view->assign('delivery_adress', $adv_user->delivery_adress);
//        $view->assign('checkout_navigator', $checkout_navigator);
//        $view->assign('small_cart', $small_cart);        
//        $view->assign('action', JSFactory::getModel('checkoutStep', 'jshop')->getCheckoutUrl('step2save', 0, 0));
//        $dispatcher->trigger('onBeforeDisplayCheckoutStep2View', array(&$view));
//        $view->display();
//    }
//    
//    function step2save(){
//		$jshopConfig = JSFactory::getConfig();
//		$dispatcher = JDispatcher::getInstance();
//		$model = JSFactory::getModel('useredit', 'jshop');
//		$adv_user = JSFactory::getUser();
//		$user = JFactory::getUser();
//		$checkoutStep = JSFactory::getModel('checkoutStep', 'jshop');
//		$checkout = JSFactory::getModel('checkout', 'jshop');
//        $checkout->checkStep(2);
//		
//		$post = PlaceBiletHelper::JRequest()->get('post');
//		$back_url = $checkoutStep->getCheckoutUrl('2');
//        
//        $dispatcher->trigger('onLoadCheckoutStep2save', array(&$post));
//
//        $cart = JSFactory::getModel('cart', 'jshop');
//        $cart->load();
//		
//		$model->setUser($adv_user);
//		$model->setData($post);
//		if (!$model->check("address")){
//            JError::raiseWarning('', $model->getError());
//            $this->setRedirect($back_url );
//            return 0;
//        }
//
//        $dispatcher->trigger('onBeforeSaveCheckoutStep2', array(&$adv_user, &$user, &$cart, &$model));
//
//		if (!$model->save()){
//            JError::raiseWarning('500', _JSHOP_REGWARN_ERROR_DATABASE);
//            $this->setRedirect($back_url );
//            return 0;
//        }
//        
//        setNextUpdatePrices();
//		$checkout->setCart($cart);
//		$checkout->setEmptyCheckoutPrices();
//			
//        $dispatcher->trigger('onAfterSaveCheckoutStep2', array(&$adv_user, &$user, &$cart));
//        		
//		$next_step = $checkoutStep->getNextStep(2);
//		$checkout->setMaxStep($next_step);
//		$this->setRedirect($checkoutStep->getCheckoutUrl($next_step));
//    }
//    
//    function step3(){
//		$jshopConfig = JSFactory::getConfig();
//		$checkoutStep = JSFactory::getModel('checkoutStep', 'jshop');
//        $checkout = JSFactory::getModel('checkoutPayment', 'jshop');
//    	$checkout->checkStep(3);
//		
//		$dispatcher = JDispatcher::getInstance();
//        $dispatcher->trigger('onLoadCheckoutStep3', array() );
//		
//		if ($jshopConfig->without_payment){			
//			$next_step = $checkoutStep->getNextStep(3);
//			$checkout->setMaxStep($next_step);
//			$this->setRedirect($checkoutStep->getCheckoutUrl($next_step));
//            return 0;
//        }
//        
//        $cart = JSFactory::getModel('cart', 'jshop');
//        $cart->load();
//		$checkout->setCart($cart);
//
//        $adv_user = JSFactory::getUser();
//        
//        JshopHelpersMetadata::checkoutPayment();
//        
//        $checkout_navigator = $checkout->showCheckoutNavigation(3);
//        $small_cart = $checkout->loadSmallCart(3);
//		
//		$paym = $checkout->getCheckoutListPayments();
//		$active_payment = $checkout->getCheckoutActivePayment($paym, $adv_user);
//		$first_payment_class = $checkout->getCheckoutFirstPaymentClass($paym);
//        
//        if ($jshopConfig->hide_payment_step){
//            if (!$first_payment_class){
//                JError::raiseWarning("", _JSHOP_ERROR_PAYMENT);
//                return 0;
//            }
//            $this->setRedirect($checkoutStep->getCheckoutUrl('step3save&payment_method='.$first_payment_class));
//            return 0;
//        }
//        
//        $view = $this->getView("checkout");
//        $view->setLayout("payments");
//        $view->assign('payment_methods', $paym);
//        $view->assign('active_payment', $active_payment);
//        $view->assign('checkout_navigator', $checkout_navigator);
//        $view->assign('small_cart', $small_cart);
//        $view->assign('action', $checkoutStep->getCheckoutUrl('step3save', 0, 0));
//        $dispatcher->trigger('onBeforeDisplayCheckoutStep3View', array(&$view));
//        $view->display();    
//    }
//    
//    function step3save(){
//        $checkout = JSFactory::getModel('checkoutPayment', 'jshop');
//        $checkout->checkStep(3);
//        
//		$dispatcher = JDispatcher::getInstance();        
//		$checkoutStep = JSFactory::getModel('checkoutStep', 'jshop');
//        $post = PlaceBiletHelper::JRequest()->get('post');
//        
//        $dispatcher->trigger('onBeforeSaveCheckoutStep3save', array(&$post) );
//        
//        $cart = JSFactory::getModel('cart', 'jshop');
//        $cart->load();
//		$checkout->setCart($cart);
//        
//        $adv_user = JSFactory::getUser();
//        
//        $payment_method = PlaceBiletHelper::JRequest()->get('payment_method'); //class payment method
//        $params = PlaceBiletHelper::JRequest()->get('params');
//
//		if (!$checkout->savePaymentData($payment_method, $params, $adv_user)){
//			JError::raiseWarning('', $checkout->getError());
//            $this->setRedirect($checkoutStep->getCheckoutUrl('3'));
//            return 0;
//		}
//		$paym_method = $checkout->getActivePaymMethod();
//        
//        $dispatcher->trigger('onAfterSaveCheckoutStep3save', array(&$adv_user, &$paym_method, &$cart));
//				
//		$next_step = $checkoutStep->getNextStep(3);
//		$checkout->setMaxStep($next_step);
//		$this->setRedirect($checkoutStep->getCheckoutUrl($next_step));
//    }
//    
//    function step4(){
//		$dispatcher = JDispatcher::getInstance();
//        $checkout = JSFactory::getModel('checkoutShipping', 'jshop');
//        $checkout->checkStep(4);        
//        $jshopConfig = JSFactory::getConfig();
//		$checkoutStep = JSFactory::getModel('checkoutStep', 'jshop');
//		
//		$dispatcher->trigger('onLoadCheckoutStep4', array());
//		
//		if ($jshopConfig->without_shipping){
//			$checkoutStep = JSFactory::getModel('checkoutStep', 'jshop');
//			$next_step = $checkoutStep->getNextStep(4);
//			$checkout->setMaxStep($next_step);
//			$this->setRedirect($checkoutStep->getCheckoutUrl($next_step));        	
//            return 0; 
//        }
//
//        JshopHelpersMetadata::checkoutShipping();
//        
//        $cart = JSFactory::getModel('cart', 'jshop');
//        $cart->load();
//		$checkout->setCart($cart);        
//        $adv_user = JSFactory::getUser();
//
//        $checkout_navigator = $checkout->showCheckoutNavigation(4);
//        $small_cart = $checkout->loadSmallCart(4);
//		
//		$shippings = $checkout->getCheckoutListShippings($adv_user);
//		if ($shippings===false){
//			JError::raiseWarning("", $checkout->getError());
//			return 0;
//		}
//		if (count($shippings)==0 && $jshopConfig->checkout_step4_show_error_shipping_config){
//			JError::raiseWarning("", _JSHOP_ERROR_SHIPPING);
//		}
//		$active_shipping = $checkout->getCheckoutActiveShipping($shippings, $adv_user);
//        
//        if ($jshopConfig->hide_shipping_step){
//            $first_shipping = $checkout->getCheckoutFirstShipping($shippings);
//            if (!$first_shipping){
//                JError::raiseWarning("", _JSHOP_ERROR_SHIPPING);
//                return 0;
//            }            
//            $this->setRedirect($checkoutStep->getCheckoutUrl('step4save&sh_pr_method_id='.$first_shipping));
//            return 0;
//        }
//        
//        $view = $this->getView("checkout");
//        $view->setLayout("shippings");
//        $view->assign('shipping_methods', $shippings);
//        $view->assign('active_shipping', $active_shipping);
//        $view->assign('config', $jshopConfig);        
//        $view->assign('checkout_navigator', $checkout_navigator);
//        $view->assign('small_cart', $small_cart);
//        $view->assign('action', $checkoutStep->getCheckoutUrl('step4save', 0, 0));
//        $dispatcher->trigger('onBeforeDisplayCheckoutStep4View', array(&$view));
//        $view->display();
//    }
//    
//    function step4save(){
//        $checkout = JSFactory::getModel('checkoutShipping', 'jshop');
//    	$checkout->checkStep(4);        
//		$checkoutStep = JSFactory::getModel('checkoutStep', 'jshop');
//		
//		$dispatcher = JDispatcher::getInstance();
//        $dispatcher->trigger('onBeforeSaveCheckoutStep4save', array());
//		
//		$sh_pr_method_id = PlaceBiletHelper::JRequest()->getInt('sh_pr_method_id');
//		$allparams = PlaceBiletHelper::JRequest()->get('params');
//
//        $cart = JSFactory::getModel('cart', 'jshop');
//        $cart->load();
//		$checkout->setCart($cart);        
//        $adv_user = JSFactory::getUser();
//		
//		if (!$checkout->saveShippingData($sh_pr_method_id, $allparams, $adv_user)){
//			JError::raiseWarning('', $checkout->getError());
//            $this->setRedirect($checkoutStep->getCheckoutUrl('4'));
//            return 0;
//		}
//		$sh_method = $checkout->getActiveShippingMethod();
//		$shipping_method_price = $checkout->getActiveShippingMethodPrice();
//        
//        $dispatcher->trigger('onAfterSaveCheckoutStep4', array(&$adv_user, &$sh_method, &$shipping_method_price, &$cart));
//				
//		$next_step = $checkoutStep->getNextStep(4);
//		if ($next_step==3){
//			$checkout->setMaxStep(4);
//		}else{
//			$checkout->setMaxStep($next_step);
//		}
//		$this->setRedirect($checkoutStep->getCheckoutUrl($next_step));
//    }
//    
//    function step5(){
//        $checkout = JSFactory::getModel('checkout', 'jshop');
//        $checkout->checkStep(5);
//        $dispatcher = JDispatcher::getInstance();
//        $dispatcher->trigger('onLoadCheckoutStep5', array());
//
//        JshopHelpersMetadata::checkoutPreview();
//
//        $cart = JSFactory::getModel('cart', 'jshop');
//        $cart->load();
//		$checkout->setCart($cart);
//
//        $jshopConfig = JSFactory::getConfig();
//        $adv_user = JSFactory::getUser();
//        $sh_method = $checkout->getShippingMethod();
//		$delivery_time = $checkout->getDeliveryTime();
//		$delivery_date = $checkout->getDeliveryDateShow();        
//        $pm_method = $checkout->getPaymentMethod();        
//        $invoice_info = $checkout->getInvoiceInfo($adv_user);
//        $delivery_info = $checkout->getDeliveryInfo($adv_user, $invoice_info);       
//        $no_return = $checkout->getNoReturn();
//        $count_filed_delivery = $jshopConfig->getEnableDeliveryFiledRegistration('address');
//        $sh_method->name = $sh_method->getName();
//		
//        $checkout_navigator = $checkout->showCheckoutNavigation(5);
//        $small_cart = $checkout->loadSmallCart(5);
//
//		$view = $this->getView("checkout");
//        $view->setLayout("previewfinish");
//        $dispatcher->trigger('onBeforeDisplayCheckoutStep5', array(&$sh_method, &$pm_method, &$delivery_info, &$cart, &$view));
//        $view->assign('no_return', $no_return);
//		$view->assign('sh_method', $sh_method );
//		$view->assign('payment_name', $pm_method->getName());
//        $view->assign('delivery_info', $delivery_info);
//		$view->assign('invoice_info', $invoice_info);
//        $view->assign('action', JSFactory::getModel('checkoutStep', 'jshop')->getCheckoutUrl('step5save', 0, 0));
//        $view->assign('config', $jshopConfig);
//        $view->assign('delivery_time', $delivery_time);
//        $view->assign('delivery_date', $delivery_date);
//        $view->assign('checkout_navigator', $checkout_navigator);
//        $view->assign('small_cart', $small_cart);
//		$view->assign('count_filed_delivery', $count_filed_delivery);
//        $dispatcher->trigger('onBeforeDisplayCheckoutStep5View', array(&$view));
//    	$view->display();
//    }
//
//    function step5save(){
//		$session = JFactory::getSession();
//        $jshopConfig = JSFactory::getConfig();
//		$checkoutStep = JSFactory::getModel('checkoutStep', 'jshop');
//        $checkout = JSFactory::getModel('checkoutOrder', 'jshop');
//        $checkout->checkStep(5);
//		
//		$checkagb = PlaceBiletHelper::JRequest()->get('agb');
//		$post = PlaceBiletHelper::JRequest()->get('post');
//		$back_url = $checkoutStep->getCheckoutUrl('5');
//		$cart_url = SEFLink('index.php?option=com_jshopping&controller=cart&task=view', 1, 1);
//		
//        $dispatcher = JDispatcher::getInstance();
//		$dispatcher->trigger('onLoadStep5save', array(&$checkagb));
//
//        $adv_user = JSFactory::getUser();
//        $cart = JSFactory::getModel('cart', 'jshop')->init();
//        $cart->setDisplayItem(1, 1);
//		
//		$checkout->setCart($cart);
//                
//                 
////        $config= new JConfig();
////        if($config->error_reporting == 'development'){
//////            JLog::add('Test message!', JLog::ALERT, 'PlaceBilet');
//////            JLog::add(JText::_('JTEXT_ERROR_MESSAGE'), JLog::WARNING);
////            JLog::add('step5save START'); 
////            JLog::add(''); 
////            JLog::add('\$adv_user:'); 
////            JLog::add(print_r($adv_user,true));
////            JLog::add('');
////            JLog::add('\$cart:');
////            JLog::add(print_r($cart,true));
////            JLog::add('');
////            JLog::add('\$checkout:');
////            JLog::add(print_r($checkout,true));
////            JLog::add('');
////            JLog::add('step5save END');
////        }  
//        
//        
//		if (!$checkout->checkAgb($checkagb)){
//			JError::raiseWarning("", $checkout->getError());
//            $this->setRedirect($back_url);
//            return 0;
//		}
//        if (!$cart->checkListProductsQtyInStore()){
//            $this->setRedirect($cart_url);
//            return 0;
//        }
//		if (!$checkout->checkCoupon()){
//			JError::raiseWarning("", $checkout->getError());
//            $this->setRedirect($cart_url);
//            return 0;
//		}
//		
//$order = $checkout->orderDataSave($adv_user, $post); 
//        
//        $dispatcher->trigger('onEndCheckoutStep5', array(&$order, &$cart));
//
//		$checkout->setSendEndForm(0); 
//        
//        if ($jshopConfig->without_payment || $order->order_total==0){
//            $checkout->setMaxStep(10);
//            $this->setRedirect($checkoutStep->getCheckoutUrl('finish'));
//            return 0;
//        }
//        
//        $pmconfigs = $checkout->getPaymentMethod()->getConfigs();
//        
//        $task = "step6";
//        if (isset($pmconfigs['windowtype']) && $pmconfigs['windowtype']==2){
//            $task = "step6iframe";
//            $session->set("jsps_iframe_width", $pmconfigs['iframe_width']);
//            $session->set("jsps_iframe_height", $pmconfigs['iframe_height']);
//        }
//        $checkout->setMaxStep(6);
//        $this->setRedirect($checkoutStep->getCheckoutUrl($task));
//    }
//
//    function step6iframe(){
//        $checkout = JSFactory::getModel('checkout', 'jshop');
//        $checkout->checkStep(6);
//        $session = JFactory::getSession();
//		$checkoutStep = JSFactory::getModel('checkoutStep', 'jshop');
//		
//        $width = $session->get("jsps_iframe_width");
//        $height = $session->get("jsps_iframe_height");
//        if (!$width) $width = 600;
//        if (!$height) $height = 600;
//		$url = $checkoutStep->getCheckoutUrl('step6&wmiframe=1');
//		
//        JDispatcher::getInstance()->trigger('onBeforeStep6Iframe', array(&$width, &$height, &$url));
//		
//		$view = $this->getView("checkout");
//        $view->setLayout("step6iframe");
//		$view->assign('width', $width);
//		$view->assign('height', $height);
//		$view->assign('url', $url);
//    	$view->display();
//    }
//
//    function step6(){
//        $checkout = JSFactory::getModel('checkoutOrder', 'jshop');
//        $checkout->checkStep(6);
//        $jshopConfig = JSFactory::getConfig();
//		$checkoutStep = JSFactory::getModel('checkoutStep', 'jshop');
//		
//        header("Cache-Control: no-cache, must-revalidate");
//        $order_id = $checkout->getEndOrderId();
//        $wmiframe = PlaceBiletHelper::JRequest()->getInt("wmiframe");
//
//        if (!$order_id){
//            JError::raiseWarning("", _JSHOP_SESSION_FINISH);
//            if (!$wmiframe){
//                $this->setRedirect($checkoutStep->getCheckoutUrl('5'));
//            }else{
//                $this->iframeRedirect($checkoutStep->getCheckoutUrl('5'));
//            }
//        }
//		
//		// user click back in payment system
//        if ($checkout->getSendEndForm() == 1){
//            $this->cancelPayOrder($order_id);
//            return 0;
//        }
//		
//		if (!$checkout->showEndFormPaymentSystem($order_id)){
//			$checkout->setMaxStep(10);
//            if (!$wmiframe){
//                $this->setRedirect($checkoutStep->getCheckoutUrl('finish'));
//            }else{
//                $this->iframeRedirect($checkoutStep->getCheckoutUrl('finish'));
//            }
//            return 0;
//		}
//    }
//
//    function step7(){
//        $checkout = JSFactory::getModel('checkoutBuy', 'jshop');
//        $wmiframe = PlaceBiletHelper::JRequest()->getInt("wmiframe");
//		$checkoutStep = JSFactory::getModel('checkoutStep', 'jshop');
//
//        JDispatcher::getInstance()->trigger('onLoadStep7', array());
//		
//		$act = PlaceBiletHelper::JRequest()->get("act");
//        $payment_method = PlaceBiletHelper::JRequest()->get("js_paymentclass");
//		$no_lang = PlaceBiletHelper::JRequest()->getInt('no_lang');
//        
//        $checkout->saveToLogPaymentData();
//		$checkout->setSendEndForm(0);
//		
//		$checkout->setAct($act);
//		$checkout->setPaymentMethodClass($payment_method);
//		$checkout->setNoLang($no_lang);		
//		if (!$checkout->loadUrlParams()){
//			JError::raiseWarning('', $checkout->getError());
//            return 0;
//		}
//        
//        if ($act == "cancel"){
//            $this->cancelPayOrder($checkout->getOrderId());
//            return 0;
//        }
//        
//        if ($act == "return" && !$checkout->getCheckReturnParams()){
//            $checkout->setMaxStep(10);
//            if (!$wmiframe){
//                $this->setRedirect($checkoutStep->getCheckoutUrl('finish'));
//            }else{
//                $this->iframeRedirect($checkoutStep->getCheckoutUrl('finish'));
//            }
//            return 1;
//        }
//        
//		$codebuy = $checkout->buy();
//
//		if ($codebuy==0){
//			JError::raiseWarning('', $checkout->getError());
//            return 0;
//		}
//		if ($codebuy==2){
//			die();
//		}
//
//        if ($checkout->checkTransactionNoBuyCode()){
//            JError::raiseWarning(500, $checkout->getCheckTransactionResText());
//            if (!$wmiframe){
//                $this->setRedirect($checkoutStep->getCheckoutUrl('5'));
//            }else{
//                $this->iframeRedirect($checkoutStep->getCheckoutUrl('5'));
//            }
//            return 0;
//        }else{
//            $checkout->setMaxStep(10);
//            if (!$wmiframe){
//                $this->setRedirect($checkoutStep->getCheckoutUrl('finish'));
//            }else{
//                $this->iframeRedirect($checkoutStep->getCheckoutUrl('finish'));
//            }
//            return 1;
//        }
//    }
//
//    function finish(){
//        $checkout = JSFactory::getModel('checkoutFinish', 'jshop');
//        $checkout->checkStep(10);
//        $jshopConfig = JSFactory::getConfig();
//        $order_id = $checkout->getEndOrderId();
//		$text = $checkout->getFinishStaticText();
//
//        JshopHelpersMetadata::checkoutFinish();
//
//        JDispatcher::getInstance()->trigger('onBeforeDisplayCheckoutFinish', array(&$text, &$order_id));
//
//        $view = $this->getView("checkout");
//        $view->setLayout("finish");
//        $view->assign('text', $text);
//        $view->display();
//
//        if ($order_id){
//			$checkout->paymentComplete($order_id, $text);
//        }
//
//        $checkout->clearAllDataCheckout();
//    }
//
//    function cancelPayOrder($order_id=""){
//        $jshopConfig = JSFactory::getConfig();
//        $checkout = JSFactory::getModel('checkout', 'jshop');
//		$checkoutStep = JSFactory::getModel('checkoutStep', 'jshop');
//        $wmiframe = PlaceBiletHelper::JRequest()->getInt("wmiframe");
//
//        if (!$order_id){
//			$order_id = $checkout->getEndOrderId();
//		}
//        if (!$order_id){
//            JError::raiseWarning("", _JSHOP_SESSION_FINISH);
//            if (!$wmiframe){
//                $this->setRedirect($checkoutStep->getCheckoutUrl('5'));
//            }else{
//                $this->iframeRedirect($checkoutStep->getCheckoutUrl('5'));
//            }
//            return 0;
//        }
//
//        $checkout->cancelPayOrder($order_id);
//        
//        JError::raiseWarning("", _JSHOP_PAYMENT_CANCELED);
//        if (!$wmiframe){ 
//            $this->setRedirect($checkoutStep->getCheckoutUrl('5'));
//        }else{
//            $this->iframeRedirect($checkoutStep->getCheckoutUrl('5'));
//        }
//        return 0;
//    }
//    
//    function iframeRedirect($url){
//        echo "<script>parent.location.href='$url';</script>\n";
//        $mainframe = JFactory::getApplication();
//        $mainframe->close();
//    }
    
}