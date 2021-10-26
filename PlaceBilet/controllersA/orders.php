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

class JshoppingControllerOrders_mod extends JshoppingControllerOrders{
    
    function __construct( $config = array() ){
        $this->nameModel = 'orders';
        parent::__construct($config);
    }
//
//    function __construct( $config = array() ){
//        parent::__construct( $config );
//        $this->registerTask('add', 'edit' );
//        checkAccessController("orders");
//        addSubmenu("orders");
//        JPluginHelper::importPlugin('jshoppingorder');
//    }

    
    /**
	 * Добавлен метод мной добавлено
	 */
	function DeletePlaces ($taskRedirect = ''){
        
        $cid = (array)$this->input->get("cid");
        
        foreach ($cid as $i => $ci){
            $cid[$i] = (int)$ci;
        }
        
        
//        $order = JSFactory::getTable('order', 'jshop');
//        $order->load($order_id);
//
//        $order_items = $order->getAllItems();
        
        if(!$cid)       {
            $this->setRedirect("index.php?option=com_jshopping&controller=orders&task=$taskRedirect");
            return;
        }
        
        $host = JFactory::getConfig()->get('host');
        
        $db = JFactory::getDBO();
        $query = "SELECT oi.order_item_id id, oi.order_item_id, oi.order_id, oi.product_id, oi.places, oi.place_prices "
                . " FROM #__jshopping_order_item oi "
                . " WHERE oi.order_id IN (". join(',', $cid).") ; ";
        $db->setQuery($query);

        $order_items = $db->loadObjectList();

        $ar = array();

        foreach ($order_items as $item) {
            $values_place = json_decode($item->places);// unserialize($item->places);
            foreach ($values_place as $attr_values_id => $attr_id) {
                $ar[$item->product_id][$attr_id][] = $attr_values_id;
            }
        }
        $row_delete = 0; 
        foreach ($ar as $product_id => $attrs) {
            foreach ($attrs as $attr_id => $places) {
                $query = "DELETE FROM `#__jshopping_products_attr2`  "
                        . " WHERE product_id = $product_id AND attr_id = $attr_id "
                        . " AND attr_value_id IN (" . join(', ', $places) . ") ; ";
                $db->setQuery($query);
                $db->query();
                $row_delete += $db->getAffectedRows();
            }
        }
        //$db->setQuery($query);
        //$result = $db->queryBatch(); 
        //$attributesSelected = json_decode($order->cart); 
        //JDispatcher::getInstance()->trigger('onAfterQueryGetAttributes2', array(&$query)); 

        //echo sprintf(_JSHOP_ORDER_DELETE_ATRIBUTE, $order_number)."<!-- <br/> Удалено ".$row_delete."--><br/>";//.($result?" Удалено ".$db->getAffectedRows():" Не удалено <br/>".__LINE__." ".$db->stderr()) ; 
        
        //$text =  sprintf('JSHOP_ORDER_DELETE_PLACES', $order_number)." <!--<br/> Удалено ".$row_delete."--><br/>";//.$query;
        $text = JText::_('JSHOP_ORDER_DELETE_PLACES_1'). $row_delete . JText::_('JSHOP_ORDER_DELETE_PLACES_2');
        
        if(!is_null($taskRedirect))
            $this->setRedirect("index.php?option=com_jshopping&controller=orders&task=$taskRedirect&order_id=".$order_id, $text);
        
        return $row_delete;
    }
    
//Добавлен Безполезный метод НЕ дописаный и не нужный мной добавлено     
//    function DeletePlacesEdit(){
//        $this->DeletePlaces(NULL);
//        
//        $order_id = PlaceBiletHelper::JRequest()->getInt("order_id");
//        $text = JText::_('JSHOP_ORDER_DELETE_PLACES_1'). $order_number.JText::_('JSHOP_ORDER_DELETE_PLACES_2')." <!--<br/> Удалено ".$db->getAffectedRows()."--><br/>";//.$query;
//        $this->setRedirect("index.php?option=com_jshopping&controller=orders&task=edit&order_id=".$order_id, $text);
//        
//    }
    

    function DeletePlacesView()
    {
        $this->DeletePlaces('show');
        
    } 
    
//    function display($cachable = false, $urlparams = false){
//        $jshopConfig = JSFactory::getConfig();
//        $mainframe = JFactory::getApplication();        
//        $context = "jshopping.list.admin.orders";
//        $limit = $mainframe->getUserStateFromRequest( $context.'limit', 'limit', $mainframe->getCfg('list_limit'), 'int' );
//        $limitstart = $mainframe->getUserStateFromRequest( $context.'limitstart', 'limitstart', 0, 'int' );
//        $id_vendor_cuser = getIdVendorForCUser();
//        $client_id = PlaceBiletHelper::JRequest()->getInt('client_id',0);
//        
//        $status_id = $mainframe->getUserStateFromRequest( $context.'status_id', 'status_id', 0 );
//        $year = $mainframe->getUserStateFromRequest( $context.'year', 'year', 0 );
//        $month = $mainframe->getUserStateFromRequest( $context.'month', 'month', 0 );
//        $day = $mainframe->getUserStateFromRequest( $context.'day', 'day', 0 );
//        $notfinished = $mainframe->getUserStateFromRequest( $context.'notfinished', 'notfinished', $jshopConfig->order_notfinished_default);
//        $text_search = $mainframe->getUserStateFromRequest( $context.'text_search', 'text_search', '' );
//        $filter_order = $mainframe->getUserStateFromRequest($context.'filter_order', 'filter_order', "order_number", 'cmd');
//        $filter_order_Dir = $mainframe->getUserStateFromRequest($context.'filter_order_Dir', 'filter_order_Dir', "desc", 'cmd');
//        
//        $filter = array("status_id"=>$status_id, 'user_id'=>$client_id, "year"=>$year, "month"=>$month, "day"=>$day, "text_search"=>$text_search, 'notfinished'=>$notfinished);
//        
//        if ($id_vendor_cuser){            
//            $filter["vendor_id"] = $id_vendor_cuser;
//        }
//        
//        $orders = JSFactory::getModel("orders");
//        
//        $total = $orders->getCountAllOrders($filter);        
//        jimport('joomla.html.pagination');
//        $pageNav = new JPagination($total, $limitstart, $limit);
//        
//        $_list_order_status = $orders->getAllOrderStatus();
//        $list_order_status = array();
//        foreach($_list_order_status as $v){
//            $list_order_status[$v->status_id] = $v->name;
//        }
//        $rows = $orders->getAllOrders($pageNav->limitstart, $pageNav->limit, $filter, $filter_order, $filter_order_Dir);
//        $lists['status_orders'] = $_list_order_status;
//        $_list_status0[] = JHTML::_('select.option', 0, _JSHOP_ALL_ORDERS, 'status_id', 'name');
//        $_list_status = $lists['status_orders'];
//        $_list_status = array_merge($_list_status0, $_list_status);
//        $lists['changestatus'] = JHTML::_('select.genericlist', $_list_status,'status_id','class="chosen-select" style="width: 170px;" ','status_id','name', $status_id );
//        $nf_option = array();
//        $nf_option[] = JHTML::_('select.option', 0, _JSHOP_HIDE, 'id', 'name');
//        $nf_option[] = JHTML::_('select.option', 1, _JSHOP_SHOW, 'id', 'name');
//        $lists['notfinished'] = JHTML::_('select.genericlist', $nf_option, 'notfinished','class="chosen-select" style="width: 100px;" ','id','name', $notfinished );
//        
//        $firstYear = $orders->getMinYear(); 
//        $y_option = array();
//        $y_option[] = JHTML::_('select.option', 0, " - - - ", 'id', 'name');
//        for($y=$firstYear;$y<=date("Y");$y++){
//            $y_option[] = JHTML::_('select.option', $y, $y, 'id', 'name');
//        }        
//        $lists['year'] = JHTML::_('select.genericlist', $y_option, 'year', 'class="chosen-select" style="width: 80px;" ', 'id', 'name', $year);
//        
//        $y_option = array();
//        $y_option[] = JHTML::_('select.option', 0, " - - ", 'id', 'name');
//        for($y=1;$y<=12;$y++){
//            if ($y<10) $y_month = "0".$y; else $y_month = $y;
//            $y_option[] = JHTML::_('select.option', $y_month, $y_month, 'id', 'name');
//        }        
//        $lists['month'] = JHTML::_('select.genericlist', $y_option, 'month', 'class="chosen-select" style="width: 80px;" ', 'id', 'name', $month);
//        
//        $y_option = array();
//        $y_option[] = JHTML::_('select.option', 0, " - - ", 'id', 'name');
//        for($y=1;$y<=31;$y++){
//            if ($y<10) $y_day = "0".$y; else $y_day = $y;
//            $y_option[] = JHTML::_('select.option', $y_day, $y_day, 'id', 'name');
//        }        
//        $lists['day'] = JHTML::_('select.genericlist', $y_option, 'day', 'class="chosen-select" style="width: 80px;" ', 'id', 'name', $day);
//		
//		$payments = JSFactory::getModel("payments");
//        $payments_list = $payments->getListNamePaymens(0);
//        
//        $shippings = JSFactory::getModel("shippings");
//        $shippings_list = $shippings->getListNameShippings(0);
//        
//        $show_vendor = $jshopConfig->admin_show_vendors;
//        if ($id_vendor_cuser) $show_vendor = 0;
//        $display_info_only_my_order = 0;
//        if ($jshopConfig->admin_show_vendors && $id_vendor_cuser){
//            $display_info_only_my_order = 1; 
//        }
//        
//        $total = 0;
//        foreach($rows as $k=>$row){
//            if ($row->vendor_id>0){
//                $vendor_name = $row->v_fname." ".$row->v_name;
//            }else{
//                $vendor_name = "-";
//            }
//            $rows[$k]->vendor_name = $vendor_name;
//            
//            $display_info_order = 1;
//            if ($display_info_only_my_order && $id_vendor_cuser!=$row->vendor_id) $display_info_order = 0;
//            $rows[$k]->display_info_order = $display_info_order;
//            
//            $blocked = 0;
//            if (orderBlocked($row) || !$display_info_order) $blocked = 1;
//            $rows[$k]->blocked = $blocked;
//			
//			$rows[$k]->payment_name = $payments_list[$row->payment_method_id];
//            $rows[$k]->shipping_name = $shippings_list[$row->shipping_method_id];
//			
//            $total += $row->order_total / $row->currency_exchange;
//        }
//
//        $dispatcher = JDispatcher::getInstance();
//        $dispatcher->trigger('onBeforeDisplayListOrderAdmin', array(&$rows));
//		
//		$view=$this->getView("orders", 'html');
//        $view->setLayout("list");
//        $view->assign('rows', $rows); 
//        $view->assign('lists', $lists); 
//        $view->assign('pageNav', $pageNav); 
//        $view->assign('text_search', $text_search); 
//        $view->assign('filter', $filter);        
//        $view->assign('show_vendor', $show_vendor);
//        $view->assign('filter_order', $filter_order);
//        $view->assign('filter_order_Dir', $filter_order_Dir);
//        $view->assign('list_order_status', $list_order_status);
//        $view->assign('client_id', $client_id);
//        $view->assign('total', $total);
//        $view->sidebar = JHtmlSidebar::render();
//        $view->_tmp_order_list_html_end = '';
//        $dispatcher->trigger('onBeforeShowOrderListView', array(&$view));
//		$view->displayList(); 
//    }
//    
//    function show(){
//        $order_id = PlaceBiletHelper::JRequest()->getInt("order_id");
//        $jshopConfig = JSFactory::getConfig();
//		
//        $orders = JSFactory::getModel("orders");
//        $order = JSFactory::getTable('order', 'jshop');
//        $order->load($order_id);
//        
//		$order->prepareOrderPrint('order_show');
//        
//        $id_vendor_cuser = getIdVendorForCUser();
//        
//		$order->loadItemsNewDigitalProducts();
//        $order_items = $order->getAllItems();
//		
//        if ($jshopConfig->admin_show_vendors){
//            $tmp_order_vendors = $order->getVendors();
//            $order_vendors = array();
//            foreach($tmp_order_vendors as $v){
//                $order_vendors[$v->id] = $v;
//            }
//        }
//
//        $lists['status'] = JHTML::_('select.genericlist', $orders->getAllOrderStatus(),'order_status','class = "inputbox" size = "1" id = "order_status"','status_id','name', $order->order_status);
//        
//        $tmp_fields = $jshopConfig->getListFieldsRegister();
//        $config_fields = $tmp_fields["address"];
//        $count_filed_delivery = $jshopConfig->getEnableDeliveryFiledRegistration('address');
//        
//        $display_info_only_product = 0;
//        if ($jshopConfig->admin_show_vendors && $id_vendor_cuser){
//            if ($order->vendor_id!=$id_vendor_cuser) $display_info_only_product = 1; 
//        }
//        
//        $display_block_change_order_status = $order->order_created;        
//        if ($jshopConfig->admin_show_vendors && $id_vendor_cuser){
//            if ($order->vendor_id!=$id_vendor_cuser) $display_block_change_order_status = 0;
//            foreach($order_items as $k=>$v){
//                if ($v->vendor_id!=$id_vendor_cuser){
//                    unset($order_items[$k]);
//                }
//            }
//        }
//        		
//		$stat_download = $order->getFilesStatDownloads(1);
//        
//        $dispatcher = JDispatcher::getInstance();
//        $dispatcher->trigger('onBeforeDisplayOrderAdmin', array(&$order, &$order_items, &$order_history));
//        
//        $print = PlaceBiletHelper::JRequest()->getInt("print");
//        
//        $view = $this->getView("orders", 'html');
//        $view->setLayout("show");
//        $view->assign('config', $jshopConfig); 
//        $view->assign('order', $order); 
//        $view->assign('order_history', $order->history);
//        $view->assign('order_items', $order_items); 
//        $view->assign('lists', $lists); 
//        $view->assign('print', $print);
//        $view->assign('config_fields', $config_fields);
//        $view->assign('count_filed_delivery', $count_filed_delivery);
//        $view->assign('display_info_only_product', $display_info_only_product);
//        $view->assign('current_vendor_id', $id_vendor_cuser);
//        $view->assign('display_block_change_order_status', $display_block_change_order_status);
//        $view->_tmp_ext_discount = '';
//        $view->_tmp_ext_shipping_package = '';
//		$view->assign('stat_download', $stat_download);
//        if ($jshopConfig->admin_show_vendors){ 
//            $view->assign('order_vendors', $order_vendors);
//        }
//        $dispatcher->trigger('onBeforeShowOrder', array(&$view));
//        $view->displayShow();
//    }
//
//    function printOrder(){
//        PlaceBiletHelper::JRequest()->set("print", 1);
//        $this->show();
//    }
//    
//    function update_one_status(){
//        $this->_updateStatus(PlaceBiletHelper::JRequest()->get('order_id'),PlaceBiletHelper::JRequest()->get('order_status'),PlaceBiletHelper::JRequest()->get('status_id'),PlaceBiletHelper::JRequest()->get('notify',0),PlaceBiletHelper::JRequest()->get('comments',''),PlaceBiletHelper::JRequest()->get('include',''),1);
//    }
//    
//    function update_status(){
//        $this->_updateStatus(PlaceBiletHelper::JRequest()->get('order_id'),PlaceBiletHelper::JRequest()->get('order_status'),PlaceBiletHelper::JRequest()->get('status_id'),PlaceBiletHelper::JRequest()->get('notify',0),PlaceBiletHelper::JRequest()->get('comments',''),PlaceBiletHelper::JRequest()->get('include',''),0);        
//    }    
//    
//    function _updateStatus($order_id, $status, $status_id, $notify, $comments, $include, $view_order){
//        $client_id = PlaceBiletHelper::JRequest()->getInt('client_id', 0);
//		$sendmessage = $notify;
//		
//		$model = JSFactory::getModel('orderChangeStatus', 'jshop');
//		$model->setData($order_id, $status, $sendmessage, $status_id, $notify, $comments, $include, $view_order);
//		$model->setAppAdmin(1);
//		$model->store();
//		
//		JSFactory::loadAdminLanguageFile();
//        
//        if ($view_order){
//            $this->setRedirect("index.php?option=com_jshopping&controller=orders&task=show&order_id=".$order_id, _JSHOP_ORDER_STATUS_CHANGED);
//        }else{
//            $this->setRedirect("index.php?option=com_jshopping&controller=orders&client_id=".$client_id, _JSHOP_ORDER_STATUS_CHANGED);
//		}
//    }
//    
//    function finish(){
//		$dispatcher = JDispatcher::getInstance();
//		$jshopConfig = JSFactory::getConfig();
//		
//        $order_id = PlaceBiletHelper::JRequest()->getInt("order_id");
//        $order = JSFactory::getTable('order', 'jshop');
//        $order->load($order_id);
//        $order->order_created = 1;
//        $dispatcher->trigger('onBeforeAdminFinishOrder', array(&$order));
//        $order->store();
//		$order->updateProductsInStock(1);
//        
//        JSFactory::loadLanguageFile($order->getLang());
//        $checkout = JSFactory::getModel('checkout', 'jshop');
//        if ($jshopConfig->send_order_email){
//            $checkout->sendOrderEmail($order_id, 1);
//        }
//        
//        JSFactory::loadAdminLanguageFile();
//        $this->setRedirect("index.php?option=com_jshopping&controller=orders", _JSHOP_ORDER_FINISHED);
//    }
//
//    function remove(){
//        $client_id = PlaceBiletHelper::JRequest()->getInt('client_id',0);
//        $cid = (array)PlaceBiletHelper::JRequest()->get("cid");
//        $dispatcher = JDispatcher::getInstance();        
//        $dispatcher->trigger('onBeforeRemoveOrder', array(&$cid));
//        
//		$order = JSFactory::getTable('order', 'jshop');
//        
//		foreach($cid as $key=>$id){
//			$order->delete($id);
//		}
//		$dispatcher->trigger('onAfterRemoveOrder', array(&$cid));
//        
//        $msg = sprintf(_JSHOP_ORDER_DELETED_ID, implode(", ", $cid));
//        $this->setRedirect("index.php?option=com_jshopping&controller=orders&client_id=".$client_id, $msg);
//    }
//    
//    function edit(){
//        $mainframe = JFactory::getApplication();
//        $order_id = PlaceBiletHelper::JRequest()->get("order_id");
//        $client_id = PlaceBiletHelper::JRequest()->getInt('client_id',0);
//        $lang = JSFactory::getLang();
//        $db = JFactory::getDBO();
//        $jshopConfig = JSFactory::getConfig();
//        $orders = JSFactory::getModel("orders");
//        $order = JSFactory::getTable('order', 'jshop');
//        $order->load($order_id);        
//        
//        $id_vendor_cuser = getIdVendorForCUser();
//        if ($jshopConfig->admin_show_vendors && $id_vendor_cuser){
//            if ($order->vendor_id!=$id_vendor_cuser) {
//                $mainframe->redirect('index.php', JText::_('ALERTNOTAUTH'));
//                return 0;
//            }
//        }
//
//        $order_items = $order->getAllItems();
//        
//        $_languages = JSFactory::getModel("languages");
//        $languages = $_languages->getAllLanguages(1);        
//        
//        $select_language = JHTML::_('select.genericlist', $languages, 'lang', 'class = "inputbox" style="float:none"','language', 'name', $order->lang);
//        
//		$select_countries = JshopHelpersSelects::getCountry($order->country);
//		$select_d_countries = JshopHelpersSelects::getCountry($order->d_country, 'class = "inputbox endes"', 'd_country');
//		$select_titles = JshopHelpersSelects::getTitle($order->title);
//		$select_d_titles = JshopHelpersSelects::getTitle($order->d_title, 'class = "inputbox endes"', 'd_title');
//		$select_client_types = JshopHelpersSelects::getClientType($order->client_type);
//
//        $order->prepareBirthdayFormat();
//        
//        $tmp_fields = $jshopConfig->getListFieldsRegister();
//        $config_fields = $tmp_fields["address"];
//        $count_filed_delivery = $jshopConfig->getEnableDeliveryFiledRegistration('address');
//        
//		$order->client_type_name = $order->getClientTypeName();
//        $order->payment_name = $order->getPaymentName();
//        $order->order_tax_list = $order->getTaxExt();
//        
//        $_currency = JSFactory::getModel("currencies");
//        $currency_list = $_currency->getAllCurrencies();
//        $order_currency = 0;
//        foreach($currency_list as $k=>$v){
//            if ($v->currency_code_iso==$order->currency_code_iso) $order_currency = $v->currency_id;
//        }
//        $select_currency = JHTML::_('select.genericlist', $currency_list, 'currency_id','class = "inputbox"','currency_id','currency_code', $order_currency);
//        
//        $display_price_list = array();
//        $display_price_list[] = JHTML::_('select.option', 0, _JSHOP_PRODUCT_BRUTTO_PRICE, 'id', 'name');
//        $display_price_list[] = JHTML::_('select.option', 1, _JSHOP_PRODUCT_NETTO_PRICE, 'id', 'name');
//        $display_price_select = JHTML::_('select.genericlist', $display_price_list, 'display_price', 'onchange="updateOrderTotalValue();"', 'id', 'name', $order->display_price);
//        
//        $shippings = JSFactory::getModel("shippings");
//        $shippings_list = $shippings->getAllShippings(0);
//        $first = array();
//        $first[] = JHTML::_('select.option', 0, "- - -", 'shipping_id', 'name');
//        $shippings_select = JHTML::_('select.genericlist', array_merge($first, $shippings_list), 'shipping_method_id', 'onchange="order_shipping_calculate()"', 'shipping_id', 'name', $order->shipping_method_id);
//        
//        $payments = JSFactory::getModel("payments");
//        $payments_list = $payments->getAllPaymentMethods(0);
//        $first = array();
//        $first[] = JHTML::_('select.option', 0, "- - -", 'payment_id', 'name');
//        $payments_select = JHTML::_('select.genericlist', array_merge($first, $payments_list), 'payment_method_id', 'onchange="order_payment_calculate()"', 'payment_id', 'name', $order->payment_method_id);
//        
//        $deliverytimes = JSFactory::getAllDeliveryTime();
//        $first = array(0=>"- - -");
//		$delivery_time_select = JHTML::_('select.genericlist', array_merge($first, $deliverytimes), 'order_delivery_times_id', '', 'id', 'name', $order->delivery_times_id);
//        
//        $users = JSFactory::getModel('users');
//        $users_list = $users->getUsers();        
//        $first = array();
//        $first[] = JHTML::_('select.option', -1, "- - -", 'user_id', 'name');
//        $users_list_select = JHTML::_('select.genericlist', array_merge($first, $users_list), 'user_id', 'onchange="updateBillingShippingForUser(this.value);"', 'user_id', 'name', $order->user_id);
//
//        filterHTMLSafe($order);
//        foreach($order_items as $k=>$v){
//            JFilterOutput::objectHTMLSafe($order_items[$k]);
//        }
//
//		JHTML::_('behavior.calendar');
//		
//        $view = $this->getView("orders", 'html');
//        $view->setLayout("edit");
//        $view->assign('config', $jshopConfig); 
//        $view->assign('order', $order);  
//        $view->assign('order_items', $order_items); 
//        $view->assign('config_fields', $config_fields);
//        $view->assign('etemplatevar', '');
//        $view->assign('count_filed_delivery', $count_filed_delivery);
//        $view->assign('order_id',$order_id);
//        $view->assign('select_countries', $select_countries);
//        $view->assign('select_d_countries', $select_d_countries);
//		$view->assign('select_titles', $select_titles);
//        $view->assign('select_d_titles', $select_d_titles);
//        $view->assign('select_client_types', $select_client_types);
//        $view->assign('select_currency', $select_currency);
//        $view->assign('display_price_select', $display_price_select);
//        $view->assign('shippings_select', $shippings_select);
//        $view->assign('payments_select', $payments_select);
//        $view->assign('select_language', $select_language);
//        $view->assign('delivery_time_select', $delivery_time_select);
//        $view->assign('users_list_select', $users_list_select);
//        $view->assign('client_id', $client_id);
//        $dispatcher = JDispatcher::getInstance();
//        $dispatcher->trigger('onBeforeEditOrders', array(&$view));
//        $view->displayEdit();
//    }
//
//    function save(){
//        $db = JFactory::getDBO();
//        $jshopConfig = JSFactory::getConfig();
//        $post = PlaceBiletHelper::JRequest()->get('post');
//        $client_id = PlaceBiletHelper::JRequest()->getInt('client_id',0);        
//        $file_generete_pdf_order = $jshopConfig->file_generete_pdf_order;
//        
//        $dispatcher = JDispatcher::getInstance();
//        
//        $order_id = intval($post['order_id']);
//        $orders = JSFactory::getModel("orders");
//        $order = JSFactory::getTable('order', 'jshop');
//        $order->load($order_id);
//        if (!$order_id){
//            $order->user_id = -1;
//            $order->order_date = getJsDate();
//            $orderNumber = $jshopConfig->next_order_number;
//            $jshopConfig->updateNextOrderNumber();
//            $order->order_number = $order->formatOrderNumber($orderNumber);
//            $order->order_hash = md5(time().$order->order_total.$order->user_id);
//            $order->file_hash = md5(time().$order->order_total.$order->user_id."hashfile");
//            $order->ip_address = $_SERVER['REMOTE_ADDR'];
//            $order->order_status = $jshopConfig->default_status_order;
//        }
//		$order->order_m_date = getJsDate();
//        $order_created_prev = $order->order_created;
//        if ($post['birthday']) $post['birthday'] = getJsDateDB($post['birthday'], $jshopConfig->field_birthday_format);
//        if ($post['d_birthday']) $post['d_birthday'] = getJsDateDB($post['d_birthday'], $jshopConfig->field_birthday_format);
//		if ($post['invoice_date']) $post['invoice_date'] = getJsDateDB($post['invoice_date'], $jshopConfig->store_date_format);
//        
//        if (!$jshopConfig->hide_tax){
//            $post['order_tax'] = 0;
//            $order_tax_ext = array();
//            if (isset($post['tax_percent'])){
//                foreach($post['tax_percent'] as $k=>$v){
//                    if ($post['tax_percent'][$k]!="" || $post['tax_value'][$k]!=""){
//                        $order_tax_ext[number_format($post['tax_percent'][$k],2)] = $post['tax_value'][$k];
//                    }
//                }
//            }
//            $post['order_tax_ext'] = serialize($order_tax_ext);
//            $post['order_tax'] = number_format(array_sum($order_tax_ext),2);
//        }
//        
//        $currency = JSFactory::getTable('currency', 'jshop');
//        $currency->load($post['currency_id']);
//        $post['currency_code'] = $currency->currency_code;
//        $post['currency_code_iso'] = $currency->currency_code_iso;
//        $post['currency_exchange'] = $currency->currency_value;
//
//        $dispatcher->trigger('onBeforeSaveOrder', array(&$post, &$file_generete_pdf_order, &$order));
//
//        $order->bind($post);
//		$order->delivery_times_id = $post['order_delivery_times_id'];
//        $order->store();
//        $order_id = $order->order_id;
//        $order_items = $order->getAllItems();
//        $orders->saveOrderItem($order_id, $post, $order_items);
//        
//        $order->items = null;
//        $vendor_id = $order->getVendorIdForItems();        
//        $order->vendor_id = $vendor_id;
//        $order->store();
//        
//        JSFactory::loadLanguageFile($order->getLang());
//		$lang = JSFactory::getLang($order->getLang());
//		$order->items = null;
//        
//        if ($order->order_created==1 && $order_created_prev==0){
//			$order->updateProductsInStock(1);
//            $checkout = JSFactory::getModel('checkout', 'jshop');
//            if ($jshopConfig->send_order_email){
//                $checkout->sendOrderEmail($order_id, 1);
//            }
//        }elseif($order->order_created==1 && $jshopConfig->generate_pdf){
//			$order->load($order_id);
//            $order->prepareOrderPrint('', 1);
//            $order->generatePdf($file_generete_pdf_order);
//		}
//        
//        JSFactory::loadAdminLanguageFile();
//        $dispatcher->trigger('onAfterSaveOrder', array(&$order, &$file_generete_pdf_order) );
//        $this->setRedirect("index.php?option=com_jshopping&controller=orders&client_id=".$client_id);
//    }
//    
//    function stat_file_download_clear(){        
//        $order_id = PlaceBiletHelper::JRequest()->getInt("order_id");
//        $order = JSFactory::getTable('order', 'jshop');
//        $order->load($order_id);
//        $order->file_stat_downloads = '';
//        $order->store();
//        $this->setRedirect("index.php?option=com_jshopping&controller=orders&task=show&order_id=".$order_id);
//    }
//    
//    function send(){
//        $order_id = PlaceBiletHelper::JRequest()->getInt("order_id");
//        $order = JSFactory::getTable('order', 'jshop');
//        $order->load($order_id);
//        JSFactory::loadLanguageFile($order->getLang());        
//        $checkout = JSFactory::getModel('checkout', 'jshop');
//        $checkout->sendOrderEmail($order_id, 1);
//        JSFactory::loadAdminLanguageFile();
//        $this->setRedirect("index.php?option=com_jshopping&controller=orders&task=show&order_id=".$order_id, _JSHOP_MAIL_HAS_BEEN_SENT);
//    }
//    
//    function transactions(){
//        $order_id = PlaceBiletHelper::JRequest()->getInt("order_id");
//        $jshopConfig = JSFactory::getConfig();
//        
//        $orders = JSFactory::getModel("orders");
//        $order = JSFactory::getTable('order', 'jshop');
//        $order->load($order_id);
//        $rows = $order->getListTransactions();
//        
//        $_list_order_status = $orders->getAllOrderStatus();
//        $list_order_status = array();
//        foreach($_list_order_status as $v){
//            $list_order_status[$v->status_id] = $v->name;
//        }
//        
//        $view = $this->getView("orders", 'html');
//        $view->setLayout("transactions");
//        $view->assign('config', $jshopConfig); 
//        $view->assign('order', $order);
//        $view->assign('rows', $rows);
//        $view->assign('list_order_status', $list_order_status);
//        
//        $dispatcher = JDispatcher::getInstance();
//        $dispatcher->trigger('onBeforeShowOrderTransactions', array(&$view));
//        $view->displayTrx();   
//    }
//    
//    function cancel(){
//        $client_id = PlaceBiletHelper::JRequest()->getInt('client_id',0);
//        $this->setRedirect("index.php?option=com_jshopping&controller=orders&client_id=".$client_id);
//    }
//    
//    function loadtaxorder(){
//        $post = PlaceBiletHelper::JRequest()->get('post');
//        $data_order = (array)$post['data_order'];
//        $products = (array)$data_order['product'];
//
//        $orders = JSFactory::getModel("orders");
//        $taxes_array = $orders->loadtaxorder($data_order, $products);
//        print json_encode($taxes_array);
//        die;
//    }
//    
//    function loadshippingprice(){
//        $post = PlaceBiletHelper::JRequest()->get('post');
//        $data_order = (array)$post['data_order'];
//        $products = (array)$data_order['product'];
//
//        $orders = JSFactory::getModel("orders");
//        $prices = $orders->loadshippingprice($data_order, $products);
//        print json_encode($prices);
//        die;
//    }
//    
//    function loadpaymentprice(){
//        $post = PlaceBiletHelper::JRequest()->get('post');
//        $data_order = (array)$post['data_order'];
//        $products = (array)$data_order['product'];
//
//        $orders = JSFactory::getModel("orders");
//        $price = $orders->loadpaymentprice($data_order, $products);
//        $prices = array('price'=>$price);
//        print json_encode($prices);
//        die;
//    }
    
}