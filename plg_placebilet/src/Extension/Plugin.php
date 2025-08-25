<?php namespace Joomla\Plugin\Jshopping\Placebilet\Extension;
 /** ----------------------------------------------------------------------
 * plg_placebilet - Plugin Joomshopping Component for CMS Joomla
 * Joomla plugin for ticket sales for websites: for Theaters, Cinemas, Circuses, Museums, Exhibitions, Masterclasses, Doctor's Visits, Clubs, Discos, Coaching, Schools, Training Courses.
 * ------------------------------------------------------------------------
 * @author    Sergei Borisovich Korenevskiy
 * @copyright (C) 2019 http://explorer-office.ru. All Rights Reserved. 
 * @license GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 * @package Jshopping
 * @subpackage  plg_placebilet
 * Websites: https://explorer-office.ru/download/
 * Technical Support:  Telegram - https://t.me/placebilet
 * Technical Support:  Forum	- https://vk.com/placebilet
 * Technical Support:  Github	- https://github.com/korenevskiy/plg_jshopping_PlaceBilet
 * Technical Support:  Max		- https://max.ru/join/l2YuX1enTVg2iJ6gkLlaYUvZ3JKwDFek5UXtq5FipLA
 * -------------------------------------------------------------------------
 **/

defined('_JEXEC') or die();


//toPrint(null,'',0,'');



// No direct access allowed to this file

// Плагин TypeScript для NetBeans 
// https://jaxenter.com/typescript-angular-2-and-netbeans-ide-an-unbeatable-trio-125443.html
// 
// Import Joomla! Plugin library file
// https://habrahabr.ru/post/187390/ -  Пишем SOAP клиент-серверное приложение на PHP

//jimport( 'joomla.registry.registry' );
//jimport( 'joomla.registry.format' );

//use Joomla\String\StringHelper;
use Joomla\CMS\Factory as JFactory;
use Joomla\CMS\Date\Date as JDate;
use Joomla\CMS\HTML\HTMLHelper as JHtml;
use Joomla\CMS\Language\Language as JLanguage;
use Joomla\CMS\Language\Text as JText;
use Joomla\CMS\Plugin\CMSPlugin as JPlugin;
use Joomla\CMS\Plugin\PluginHelper as JPluginHelper;
use Joomla\CMS\MVC\View\HtmlView as JViewLegacy;
use Joomla\CMS\Version as JVersion;
use Joomla\Component\Jshopping\Site\Helper\Error as JError;
use Joomla\Registry\Registry as JRegistry;
use Joomla\Input\Input as JInput;

use Joomla\Component\Jshopping\Site\Helper\Helper as JSHelper;
use Joomla\Component\Jshopping\Administrator\Helper\HelperAdmin as JSHelperAdmin;
use Joomla\Component\Jshopping\Site\Lib\JSFactory  as JSFactory;
use Joomla\Component\Jshopping\Site\Helper\Error as JSError;

use Joomla\CMS\Layout\BaseLayout as JLayoutBase;
use Joomla\CMS\Layout\FileLayout as JLayoutFile;
use Joomla\CMS\Layout\LayoutHelper as JLayoutHelper;
use Joomla\CMS\Layout\LayoutInterface as JLayout;
use Joomla\CMS\Uri\Uri as JUri;
use Joomla\CMS\Router\Route as JRoute;
use Joomla\Component\Jshopping\Site\Helper\Request as JshopRequest;
use Joomla\Component\Jshopping\Site\Lib\ImageLib;
use Joomla\Component\Jshopping\Site\Table\MultilangTable;
use Joomla\Event\SubscriberInterface;
use Joomla\CMS\Plugin\PluginHelper;
use Joomla\Database\DatabaseAwareTrait;
use JLoader;
use Joomla\Event\DispatcherAwareInterface;
use Joomla\Event\DispatcherAwareTrait;
use Joomla\Event\DispatcherInterface;
use stdClass;

//use PlacebiletHelper;
//use Zriteli;
use Joomla\CMS\Log\Log as JLog;
use Joomla\CMS\MVC\Model\BaseDatabaseModel as JModelLegacy;
use Joomla\Event\Event;
use Joomla\Plugin\Jshopping\Placebilet\Lib\Zriteli;
use Joomla\Plugin\Jshopping\Placebilet\Lib\SoapClientZriteli;
use Joomla\Plugin\Jshopping\Placebilet\Lib\Reg;
use function Joomla\Plugin\Jshopping\Placebilet\Lib\__;
//use Joomla\Plugin\Jshopping\Placebilet\Lib\Helper as PlacebiletHelper;
//use Joomla\Plugin\Jshopping\Placebilet\Helper as PlacebiletHelper;
use Joomla\Plugin\Jshopping\Placebilet\Helper\Helper as PlaceBiletHelper;
//Joomla\Plugin\Jshopping\Placebilet\Helper
//Joomla\Plugin\Jshopping\Placebilet\Extension\PlaceBiletHelper
use Joomla\Plugin\Jshopping\Placebilet\Lib\functions;
use Joomla\CMS\Form\FormHelper as JFormHelper;
use Joomla\CMS\Form\Field\EditorField as JFormFieldEditor; 
use Joomla\CMS\HTML\Helpers\Select as JHtmlSelect;
use QRcode;
use Joomla\CMS\Toolbar\ToolbarHelper as JToolbarHelper;
use Joomla\Component\Jshopping\Administrator\Controller\BaseadminController as JshoppingControllerBase;
//JTable::addIncludePath(JPATH_ADMINISTRATOR.'/components/com_spidervideoplayer/tables');
//JHTML::_('behavior.modal');

//if(JFactory::getApplication()->input->getCmd('format')!='json')
//if(!in_array(JFactory::getApplication()->input->getCmd('format'), ['json','debug']))


//require_once (JPATH_PLUGINS.'/components/com_jshopping/Helper/Error.php');

/*
$lang = & JFactory::getApplication()->getLanguage()->load('com_spidervideoplayer',JPATH_BASE);
*/ 

//class Plugin extends CMSPlugin implements SubscriberInterface
class Plugin extends JPlugin  implements DispatcherAwareInterface  , SubscriberInterface // final 
{
    use DatabaseAwareTrait;
    use DispatcherAwareTrait;
	
    protected $basePath;
    protected $pluginPath;
	
	
    /**
     * Объект реестра, параметры плагина
     *
     * @var    Reg
     * @since  1.5
     */
    public $params = null;
	
	/**
	 * Конфигурация Joomlы
	 * @var JConfig
	 */
    protected $config;
    protected $template_name;
//    protected $params;
	/**
	 * Параметры Плагина
	 * @var \Joomla\Registry\Registry
	 */
	
	
	/*
	 * Дополнительные поля пользователя для покупки ФИО, этаж, корпус, подъезд и пр.
	 * @var array
	 */
	protected $fields = [];
			
    function __construct($config = array()){
		
		
		JLoader::registerNamespace('Joomla\\Component\\Jshopping\\Site', JPATH_SITE . '/components/com_jshopping',true);
		JLoader::registerNamespace('Joomla\\Component\\Jshopping\\Administrator', JPATH_ADMINISTRATOR . '/components/com_jshopping', true);
		
//		JLoader::registerAlias('JSHelper', 'Joomla\\Component\\Jshopping\\Site\\Helper\\Helper');
//		JLoader::registerAlias('JSHelperAdmin', 'Joomla\\Component\\Jshopping\\Administrator\\Helper\\HelperAdmin');
		
//		JLoader::registerPrefix('JS', JPATH_COMPONENT . '/com_jshopping');
//		JLoader::registerPrefix('JS', JPATH_COMPONENT_ADMINISTRATOR . '/com_jshopping');
		
		
		if(file_exists(JPATH_PLUGINS.'/jshopping/placebilet/Lib/reg.php'))
			require_once (JPATH_PLUGINS.'/jshopping/placebilet/Lib/reg.php');
		
		if(file_exists(JPATH_PLUGINS.'/jshopping/placebilet/Lib/functions.php'))
			require_once (JPATH_PLUGINS.'/jshopping/placebilet/Lib/functions.php');
		
		        
		JLoader::registerAlias('JRegistry','\\Reg', '5.0');
//		$this->params = new \Reg($this->params); // $this->params->toObject();
		
		if($config instanceof DispatcherInterface){
			
            $this->setDispatcher($config);

            $config = \func_num_args() > 1 ? func_get_arg(1) : [];
		}
		
		
        //$config['params']= array();
//toPrint( (($config)),'$config',0,'message');
        parent::__construct($config);//$dispatcher = null, $config = array()
		
        // Get the parameters.
        if (isset($config['params'])) {
            if ($config['params'] instanceof Reg) {
                $this->params = $config['params'];
            } else {
                $this->params = new Reg($config['params']);
            }
        }
		
		
		$this->pluginPath = realpath(__DIR__ . '/../../');
        $this->basePath = $this->pluginPath;
		
        define('PlaceBiletPathAdmin', $this->pluginPath);
        define('PlaceBiletPath', $this->pluginPath);
		
		
		$this->setApplication(\JFactory::getApplication());
        $this->config = new Reg($this->getApplication()->getConfig());


		
//JFactory::getApplication()->enqueueMessage(JText::_('JSHOP_OF'));
		
		defined('ERROR_REPORTING_DEVELOPMENT') || define('ERROR_REPORTING_DEVELOPMENT', $this->config->error_reporting == 'development');
        
        
        define('PlaceBiletDev', FALSE && $this->config->error_reporting == 'development' || FALSE);
        define('PlaceBiletAdminDev', FALSE && $this->config->error_reporting == 'development' || FALSE);
        define('PlaceBiletPathView', $this->pluginPath);
		
		
        //JHtml::stylesheet('com_mycomponent/admin.stylesheet.css', array(), true, false, false);    
    }

    /*
     * Вызывается при обращении к конфигурации 
     * Как правило это происходит вначале контролера.
     */
    function onBeforeLoadJshopConfig(Event $event){//$config
		$config = $event->getArgument(0);
		$config->noimage = 'noimage.png';
		
//\Joomla\CMS\Factory::$application->enqueueMessage("<pre>".print_r('beforeConfig',true)."</pre>");//Prodaction
//JFactory::getApplication()->enqueueMessage("<pre>(". get_class($this->params).')-'.print_r($this->params,true)."</pre>");
		
		$config->organization_id	= $this->params->organization_id ?? 0;
		$config->pushka_url			= $this->params->pushka_url ?? '';
		$config->pushka_key			= $this->params->pushka_key ?? '';
		$config->pushka_mode		= $this->params->pushka_mode ?? '';
//        $config
//        static $ZriteliProductsUpdate = TRUE;
//toPrint($config,'$config',true,'message',true);
//        toPrint($ZriteliProductsUpdate,'$ZriteliProductsUpdate');
//        toPrint("-{$_SERVER['REQUEST_URI']}-",'WOW REQUEST_URI'); 
        //toPrint($_SERVER['PHP_SELF'],'WOW PHP_SELF'); 
//toPrint($config->fields_client_only_check,'$config->fields_client_only_check', TRUE,'pre',true);
//        $date = JDate::getInstance()->modify('+3 hour')->toSql();
//        toPrint($date,' $date' );
        //toPrint('Обновление!!!---0');
        if($_SERVER['REQUEST_URI'] == '/'){
//            toPrint($_SERVER['REQUEST_URI']=="/",'REQUEST_URI==/'); 
            
            try {
//                if($this->params->Zriteli_repertoire_download_enabled)
				
				
		if(file_exists(JPATH_PLUGINS.'/jshopping/placebilet/Lib/Zriteli.php'))   
			require_once (JPATH_PLUGINS.'/jshopping/placebilet/Lib/Zriteli.php');
				
            Zriteli::LoadAllProducts(); //расскоментировать.
            } catch (Exception $exc) { 
				
	echo "<pre> <br>".print_r($exc->getTraceAsString(),true)." </pre>";
//                toPrint($exc->getTraceAsString(),'!!! ОШИБКА !!! ... ,plgJshoppingPlaceBilet::onBeforeLoadJshopConfig() => Zriteli::LoadAllProducts(): ') ;
//                toLog($exc->getTraceAsString(),'!!! ОШИБКА !!! ... ,plgJshoppingPlaceBilet::onBeforeLoadJshopConfig() => Zriteli::LoadAllProducts(): ') ;
            }

            
        }
            
        //if(PlaceBiletAdminDev)
        //    JFactory::getApplication()->enqueueMessage("\$config: <pre>".print_r($config, TRUE)."</pre>");
            
		$this->onLoadJshopConfig($event); 
    }
	
    /**
     * Сайт - изменение конфигурации компонента
     * @param object $config Конфигурация компонента
     * @return type
     */
    function onLoadJshopConfig(Event $event){ // $config
//toPrint($config,'$config');
		$config = $event->getArgument(0);
		
//\Joomla\CMS\Factory::$application->enqueueMessage("<pre>".print_r('Config',true)."</pre>");

		
		$config->organization_id	= $this->params->organization_id ?? 0;
		$config->pushka_url			= $this->params->pushka_url ?? '';
		$config->pushka_key			= $this->params->pushka_key ?? '';
		$config->pushka_mode		= $this->params->pushka_mode ?? '';

		if(JFactory::getApplication()->getDocument()){
			$style = "plugins/jshopping/placebilet/media/bilet.css";//JUri::root(). 
			\Joomla\CMS\HTML\HTMLHelper::stylesheet($style);
		}
		
		$config->product_attribute_type_template[0] = 'attribute_input_place';// 'attribute_input_place';
		
		$config->product_attribute_accordion = $this->params->get('accordion',false);
		
        $config->show_delivery_time_checkout = 0;
		$config->disable_admin['product_manufacturer'] = true;
		$config->disable_admin['product_ean'] = true;
		$config->hide_buy_not_avaible_stock = false;
		$config->hide_product_not_avaible_stock = false;
		$config->hide_text_product_not_available = true;
		$config->enable_wishlist = false;
		$config->stock = true;
//		$config->product_list_show_manufacturer = false;
				
//        if(PlaceBiletAdminDev)
//            JFactory::getApplication()->enqueueMessage("\$config: <pre>".print_r($config->sorting_products_field_select, TRUE)."</pre>");
        foreach ($config->sorting_products_field_s_select as  $id=>$fieldSort) {
            if($fieldSort == 'prod.product_date_added')
                $config->sorting_products_field_s_select[$id] = 'prod.date_event';
        }       
        
        foreach ($config->sorting_products_field_select as $id=>$fieldSort){
            if($fieldSort == 'prod.product_date_added')
                $config->sorting_products_field_select[$id] = 'prod.date_event';
        }
        
        if(JFactory::getApplication()->isClient('administrator'))//Если Админпанель то возврат //site
            return;
        
        foreach(array_fill(65,26,'')+array_fill(97,26,'') as $_=>$v)
            ${chr($_)}=chr($_);

        //product_hide_price_null
        $config->displayprice_bilet = 'margin_left';
        $config->displayprice_bilet = (($config->displayprice ?? 0) == 0) ? 'margin_left' : '';//Показать цену в каждом ряду(0-ДА, 1-Нет, 2-Только для зарегистрированных)
        $config->displayprice_bilet = (($config->displayprice ?? 2) == 2 && empty(JFactory::getUser()->guest)) ? 'margin_left'
				: $config->displayprice_bilet;//Показать цену в каждом ряду(0-ДА, 1-Нет, 2-Только для зарегистрированных)
        
		$clss = "fa{$d}e";
//toPrint($config->displayprice,'$config->displayprice', TRUE,'pre',true);
//toPrint($config->fields_client_only_check,'$config->fields_client_only_check', TRUE,'pre',true);

        $config->displayprice = 0;                      //Показывать цену в Списке товаров (0-ДА, 1-Нет, 2-Только для зарегистрированных)
        $config->product_list_show_price_default = 0;   //Показывать цену без скидки
        $config->product_list_show_product_code=0;      //Показать Код товара
        $config->product_list_show_price_description=0; //Показывать описание цены
        $config->show_product_code_in_cart=0;           //Показать Код товара
        $config->show_product_code=0;                   //Показать Код товара
        $config->product_list_show_weight=0;            //Показать вес товара
        $config->show_weight_order=0;                   //Показать вес товара
        $config->product_show_weight=0;                 //Показать вес товара
        $config->show_buy_in_category=0;                //Показать кнопку купить для списка товаров
        $config->product_list_show_min_price=0;         //Показать Минимальную цену в Списке
        $config->show_count_select_products=0;          //Выбор количества товаров на странице
        $config->product_list_show_qty_stock=0;         //Колличество товаров на складе
        $config->product_show_qty_stock=0;              //Колличество товара на складе
        
        
        $config->sorting_products_field_select[3] = 'prod.date_event';        
        $config->sorting_products_field_s_select[3] = 'prod.date_event';
        $config->product_search_fields[] = 'prod.product_id';
        $config->count_product_select['100'] = 100;
        $config->count_product_select['200'] = 200;
        $config->count_product_select['500'] = 500;
        $config->count_product_select['1000'] = 1000;
        $config->count_product_select['2000'] = 2000;
        $config->count_product_select['5000'] = 5000;
        $config->count_line = JText::_('VER');   
        $config->admin_show_weight = FALSE;
        $config->stock = TRUE;
        $config->admin_show_product_bay_price = FALSE;
        $config->display_price_admin = 0;
        extract(['_'=>' ','clss'=>'m'.'x'.'c'.'p'.'r',]);
        
        $config_line = $this->params->get(strtolower($config->count_line), str_replace(['.',',','-'],'',"3.7,7-2.1.9-9.4.4.4"));
        $po = "c{$o}pyr{$i}gh{$t}Text"; 
        if(str_replace(['.',',','-'],'',$config_line) != str_replace(['.',',','-'],'',"3.7,7-2.1.9-9.4.4.4"))
            return;
        
        $site_plugin = $this->params->get('site_plugin', '');
        $site = $this->params->get('site', '');
        $site = str_replace('//','//.',$site);
        $site = 'w'.str_replace('/','w',$site);
        //$config->$po .= $config_line;
		if(empty($config->$po))
			$config->$po = '';
		$config->$po .= "<sp{$a}n{$_}cl{$a}ss='$clss'><{$a}{$_}hr{$e}f='$site_plugin'{$_}t{$a}rget='_blank'>"
                . "C{$o}pyr{$i}ght{$_}$site K{$O}R{$E}{$S}H{$S}{$_}Pl{$u}g{$i}n{$_}Pl{$a}c{$e}B{$i}let{$_}Th{$e}at{$e}r{$_}for{$_}JS</{$a}></sp{$a}n>";
        
        
        
        
        
//        $conf = JSFactory::getConfig();
                
//        JHtml::stylesheet('//cdn.jsdelivr.net/gh/kenwheeler/slick@1.8.1/slick/slick-theme.css');
//        JHtml::script('//cdn.jsdelivr.net/gh/kenwheeler/slick@1.8.1/slick/slick.min.js');
    }
    
	
	
	
	/**
	 * Returns an array of events this subscriber will listen to.
	 *
	 * @return  array
	 *
	 * @since   4.0.0
	 */
	public static function getSubscribedEvents(): array
	{
//		if (JFactory::getApplication()->isClient('site')) 
//			return []; 

		return [
//				'onAfterModuleList' => 'switchModPositionsByAlias',
//				'' => '',
//				'' => '',
//				'' => ''
'onAfterLoadShopParams'=>'onAfterLoadShopParams', 
'onAfterGetJsFrontRequestController'=>'onAfterGetJsFrontRequestController', 
//	'onBeforeDisplayEmpty'=>'onBeforeDisplayEmpty',
'onConstructJshoppingControllerCategory'=>'onConstructJshoppingControllerCategory',
//	'onBeforeQueryCountProductList'=>'onBeforeQueryCountProductList',
//	'onGetSubCategoriesCategoryTable'=>'onGetSubCategoriesCategoryTable',
//	'onBeforeDisplayMainCategory'=>'onBeforeDisplayMainCategory',
'onBeforeDisplayCategory'=>'onBeforeDisplayCategory',
'onAfterGetBuildFilterListProduct'=>'onAfterGetBuildFilterListProduct',
'onBeforeQueryGetProductList'=>'onBeforeQueryGetProductList',
//	'onBeforeExeQueryGetProductList'=>'onBeforeExeQueryGetProductList',
'onBeforeDisplayCategoryView'=>'onBeforeDisplayCategoryView',
'onBeforeLoadProductList'=>'onBeforeLoadProductList',
'onConstructJshoppingControllerProducts'=>'onConstructJshoppingControllerProducts',
'onListProductUpdateDataProduct'=>'onListProductUpdateDataProduct',
//	'onListProductUpdateData'=>	'onListProductUpdateData',
'onBeforeDisplayProductList'=>'onBeforeDisplayProductList',
'onBeforeDisplayProductListView'=>'onBeforeDisplayProductListView',
'onBeforeLoadProduct'=>'onBeforeLoadProduct',
'onBeforeDisplayProduct'=>'onBeforeDisplayProduct',
'onBuildSelectAttributeView'=>'onBuildSelectAttributeView',
'onAfterLoadCategory'=>'onAfterLoadCategory',
'onBeforeCheckProductPublish'=>'onBeforeCheckProductPublish',
'onBeforeDisplayProductView'=>'onBeforeDisplayProductView',
//	'onBeforeAddProductToCart'=>'onBeforeAddProductToCart',
//	'onConstructJshoppingControllerCart'=>'onConstructJshoppingControllerCart',
'onBeforeSaveUpdateProductToCart'=>'onBeforeSaveUpdateProductToCart',
'onBeforeSaveNewProductToCart'=>'onBeforeSaveNewProductToCart',
'onBeforeGetListFieldCopyUserToOrder'=>'onBeforeGetListFieldCopyUserToOrder',
//	'onBeforeCartLoad'=>'onBeforeCartLoad',
//	'onAfterCartLoad'=>'onAfterCartLoad',
'onBeforeDisplayCheckoutCartView'=>'onBeforeDisplayCheckoutCartView',
'onAfterCreateOrder'=>'onAfterCreateOrder',
'onBeforeSaveOrderItem'=>'onBeforeSaveOrderItem',
'onAfterCreateOrderFull'=>'onAfterCreateOrderFull',
'onAfterLoadPriceAndCountProducts'=>'onAfterLoadPriceAndCountProducts',
'onAfterGetUserShopJSFactory'=>'onAfterGetUserShopJSFactory',
'onBeforeDisplayCartView'=>'onBeforeDisplayCartView',
'onBeforeDisplayCheckoutStep2View'=>'onBeforeDisplayCheckoutStep2View',
'onBeforeDisplayCheckoutStep5'=>'onBeforeDisplayCheckoutStep5',
'onBeforeDisplayCheckoutStep5View'=>'onBeforeDisplayCheckoutStep5View',
//	'onJshopProductGetAttributesDatasAfter'=>'onJshopProductGetAttributesDatasAfter',
  
'onEndCheckoutStep5'=>'onEndCheckoutStep5',
'onBeforeChangeOrderStatus'=>'onBeforeChangeOrderStatus',
'onAfterDisplayCheckoutFinish'=>'onAfterDisplayCheckoutFinish',
'onBeforeStoreTableOrder'=>'onBeforeStoreTableOrder',
'onBeforeDisplayCheckoutFinish'=>'onBeforeDisplayCheckoutFinish',
'onAfterInitialise'=>'onAfterInitialise',
'onAjaxPlaceBilet'=>'onAjaxPlaceBilet',
//	'getAjax'=>'getAjax',
//			];
//		}

//		if (JFactory::getApplication()->isClient('administrator')) {
//			return [
'onLoadJshopConfig'=>'onLoadJshopConfig',	
'onAfterGetJsAdminRequestController'=>'onAfterGetJsAdminRequestController',																				
'onBeforeLoadJshopConfig'=>'onBeforeLoadJshopConfig',

'onAfterQueryGetAttributes2'=>'onAfterQueryGetAttributes2',
'onAfterLoadShopParamsAdmin'=>'onAfterLoadShopParamsAdmin',
	'onJshopProductGetAttributesDatasAfter'=>'onJshopProductGetAttributesDatasAfter',

'onBeforeShowOrder'=>'onBeforeShowOrder',
'onBeforeEditOrders'=>'onBeforeEditOrders',
	'onBeforeRemoveOrder'=>'onBeforeRemoveOrder',
	'onBeforeRemoveAttribut'=>'onBeforeRemoveAttribut',
'onBeforeEditAtribut'=>'onBeforeEditAtribut',
	'onBeforeSaveAttribut'=>'onBeforeSaveAttribut',
'onAfterSaveAttribut'=>'onAfterSaveAttribut',
'onBeforeShowOrderListView'=>'onBeforeShowOrderListView',
'onBeforeDisplayListProductsView'=>'onBeforeDisplayListProductsView',
'onBeforeEditCategories'=>'onBeforeEditCategories',
'onBeforeDisplayListCategoryView'=>'onBeforeDisplayListCategoryView',
'onJshoppingModelCategoriesGetTreeAllCategoriesBefore'=>'onJshoppingModelCategoriesGetTreeAllCategoriesBefore',
'onBeforeDisplayEditProduct'=>'onBeforeDisplayEditProduct',
'onJoomlaComponentJshoppingAdministratorModelAttributModelGetAllAttributesBefore'=>'onJoomlaComponentJshoppingAdministratorModelAttributModelGetAllAttributesBefore',
'onBeforeDisplayEditProductView'=>'onBeforeDisplayEditProductView',
'onJshoppingModelAttributGetAllAttributesBefore'=>'onJshoppingModelAttributGetAllAttributesBefore',
'onBeforeDisplayListProductsGetAllProducts'=>'onBeforeDisplayListProductsGetAllProducts',
'onBeforeDisplayAttributes'=>'onBeforeDisplayAttributes',
'onJSFactoryGetModel'=>'onJSFactoryGetModel',
'onAfterJSFactoryGetModel'=>'onAfterJSFactoryGetModel',
	'JshoppingControllerattributesvalues'=>'JshoppingControllerattributesvalues',
	'onLoadJshopUserGust'=>'onLoadJshopUserGust',
	'onLoadCheckoutStep2save'=>'onLoadCheckoutStep2save',
	'onAfterSaveCheckoutStep2'=>'onAfterSaveCheckoutStep2',
'onBeforeSaveCheckoutStep2'=>'onBeforeSaveCheckoutStep2',
'onBeforeCreateTemplateOrderPartMail'=>'onBeforeCreateTemplateOrderPartMail',
'onBeforeCreateTemplateOrderMail'=>'onBeforeCreateTemplateOrderMail',
	'onJoomlaComponentJshoppingSiteModelOrderMailModelGetSubjectMailAfter'=>'onJoomlaComponentJshoppingSiteModelOrderMailModelGetSubjectMailAfter',
'onBeforeSendOrderEmailClient'=>'onBeforeSendOrderEmailClient',
'onBeforeChangeOrderStatusAdmin'=>'onBeforeChangeOrderStatusAdmin',
'onAfterSaveCategory'=>'onAfterSaveCategory',
'onAfterUploadCategoryImage'=>'onAfterUploadCategoryImage',
//	'onAfterSaveProductFolerImage'=>'onAfterSaveProductFolerImage',
//	'onAfterSaveCategoryImage'=>'onAfterSaveCategoryImage',

'onBeforeDisplayLoginView'=>'onBeforeDisplayLoginView',

'onBeforeAdminOptionPanelIcoDisplay'=>'onBeforeAdminOptionPanelIcoDisplay',
'onBeforeAdminOptionPanelMenuDisplay'=>'onBeforeAdminOptionPanelMenuDisplay',

'onBeforeAdminMainPanelIcoDisplay'=>'onBeforeAdminMainPanelIcoDisplay',
'onBeforeDisplayInfo'=>'onBeforeDisplayInfo',
'onBeforeDisplayHomePanel'=>'onBeforeDisplayHomePanel',
	'onGetIcons'=>'onGetIcons',
'onBeforeDisplayCheckoutStep3View'=>'onBeforeDisplayCheckoutStep3View',
'onBeforeDisplayCheckoutStep4View'=>'onBeforeDisplayCheckoutStep4View',
'onConstructJshoppingControllerCheckout'=>'onConstructJshoppingControllerCheckout',
'onBeforeDisplaySaveProduct'=>'onBeforeDisplaySaveProduct',
//'onBeforeSaveCategory'=>'onBeforeSaveCategory',
'onBeforeEditConfigAdminFunction'=>'onBeforeEditConfigAdminFunction',
//	'onBeforeEditConfigGeneral'=>'onBeforeEditConfigGeneral',
'onBeforeEditConfigCatProd'=>'onBeforeEditConfigCatProd',
'onBeforeEditConfigCheckout'=>'onBeforeEditConfigCheckout',
//	'onBeforeEditConfigFieldRegister'=>'onBeforeEditConfigFieldRegister',
//	'onBeforeEditConfigOtherConfig'=>'onBeforeEditConfigOtherConfig',
//	'onExtensionBeforeSave'=>'onExtensionBeforeSave',
		];
	}

	
    static $contr;// = FALSE;   
	
	function onAfterLoadShopParams(){
		$this->init();
//JFactory::getApplication()->enqueueMessage(JText::_('onAfterLoadShopParams'));
//echo "<pre>1</pre>";
	}
	
	function init(){
//echo "<pre>1</pre>";
		jimport('joomla.application.component.controller');
	}
	
	/**
	 *       Переопределение контроллера
	 * @var \Joomla\Event\Event $event
	 */   
    function onAfterGetJsFrontRequestController(Event $event){//$controllerName

        $controllername = $event->getArgument(0);
		
		PlaceBiletHelper::$param  = $this->params;
		
		
        if (file_exists(PlaceBiletPath.'/Controller/'.$controllername.'.php'))
            require_once(PlaceBiletPath.'/Controller/'.$controllername.'.php' );
	
		
//		$this->loadLanguage();
		
		$this->getApplication()->getLanguage()->load('plg_jshopping_placebilet', JPATH_ADMINISTRATOR);
//		$this->getApplication()->getLanguage()->load('plg_jshopping_placebilet', $this->pluginPath);
		
      return;// установлено в связи отсутсвии необходиомсти переопределения контроллеров.
	  
//			 onAfterLoadShopParamsAdmin
//\Joomla\CMS\Factory::$application->enqueueMessage("<pre>".print_r('RequestControllerFront',true)."</pre>");
        //$log = SoapClientZriteli::$UserId." --- ".SoapClientZriteli::$UserHash;
        //$controller/toPrint($log, 'User');
        //toPrint(Zriteli::$Params, 'Params');
//toPrint(NULL,'',0,'',false);
		
		
//\Joomla\CMS\Factory::$application->enqueueMessage("<pre>".print_r($this->pluginPath,true)."</pre>");
		
//        toPrint($controllername, '$controllername');
        
//        if(PlaceBiletDev)JFactory::getApplication()->enqueueMessage(  "Controller: ".print_r($controllername,TRUE));
//        if(PlaceBiletDev)JFactory::getApplication()->enqueueMessage(  "Controller: ".print_r($this->JInput()->getCmd('task' ),TRUE));
        
        
       // echo "<pre>\$controllername-: $controllername<br>".print_r(is_object(self::$contr),true)."  </pre>";
        if(is_object(self::$contr)){
//             echo "<pre>\$controllername-: +++++++++  </pre>";
            return;
           
        }  else {
//            echo "<pre>\$controllername-: ---------  </pre>";
        }
        
//		die(666666);
		
//		return;  
        if (file_exists(JPATH_COMPONENT.'/Controller/'.$controllername.'.php'))
            require_once(JPATH_COMPONENT.'/Controller/'.$controllername.'.php' );
        else
            JError::raiseError( 403, JText::_('Access Forbidden'));
		  
        
        $file = JPATH_PLUGINS.'/jshopping/placebilet/Controller/'.$controllername.'.php';
        if(file_exists($file)){
            require_once($file);
            //require_once( JPATH_COMPONENT.DS.'controllers'.DS.$controllername.'.php' );
        }
        
        //$controllername =$controllername.'_mod';
        
        $classControllerMod = 'JshoppingController'.$controllername.'_mod';
        $Controllername = $controllername;
        $methodCode = '';
              
//		return;
		
        if(false && PlaceBiletDev){
            echo "<table style='margin-left:230px;'><tr><td>\$controllername: ".$controllername. "</td></tr>"
               //     . "<tr><td>\$contr: ".print_r($contr, true). "</td></tr>"
          //          . "<tr><td>\$classControllerMod: ".class_exists($classControllerMod)." ".$classControllerMod. "</td></tr>"
          //          . "<tr><td>getCmd('task'): ".(!empty($this->JInput()->getCmd('task'))?"1":"0")." ".$this->JInput()->getCmd('task'). "</td></tr>"
                    . "<tr><td>getCmd('view'): ".(!(PlaceBiletHelper::JInput('view'))?"1":"0")." ".PlaceBiletHelper::JInput('view'). "</td></tr>"
                    . "<tr><td>Exist $classControllerMod: ".(class_exists($classControllerMod)?"1":"0")." ".  "</td>"
                    //. "<tr><td>is_object $contr: ".(is_object($contr)?"1":"0")." ".  "</td></tr>"
                    //. "<tr><td>Error Reporting: ".print_r($this->config->error_reporting,true)." ".  "</td></tr>"
                    . "</table><br><a href='http://site.teatr-chehova.ru/component/jshopping/product/view/12/196'>Зойкина квартира</a><br><br><br><br><br><br>";
            
            
        }
        

        
            if(!is_object(self::$contr) && class_exists($classControllerMod) ){
		    return;   		
		//		$controllername = 'empty';     
                //                $this->JInput()->set('controller', $controllername);
                                // echo "<pre>\$controllername+: <br> ".print_r($controllername,true)." </pre>";
                //if(PlaceBiletDev)					JFactory::getApplication()->enqueueMessage( $classController."_mod-: ".print_r($controllername,TRUE));//->get('redirect')
				
                //define('placebilet', TRUE);
//                $config = array();
                //$config['view_path']    = $pathView = PlaceBiletPath.'/View';//.DS.strtolower($controllername).DS.'view.html.php';
                //$config['default_view'] = $pathView = PlaceBiletPath.DS.'View';//.DS.strtolower($controllername).DS.'view.html.php';
                
//                        if(is_object(self::$contr)){
//             echo "<pre>\$controllername-: +++++++++  </pre>";
//            return;
//           
//        }  else {
//            echo "<pre>\$controllername-: ---------  </pre>";
//        }                
                         
                self::$contr = new $classControllerMod();
 		self::$contr->execute(PlaceBiletHelper::JInput('task')); 
                self::$contr->redirect();
                
                self::$contr->addViewPath(JPATH_BASE."/templates/$this->template_name/html/");
                self::$contr->addPath('template',JPATH_BASE."/templates/$this->template_name/html/");
//                        if(is_object(self::$contr)){
//             echo "<pre>\$controllername-: +++++++++  </pre>";
//            return;
//           
//        }  else {
//            echo "<pre>\$controllername-: ---------  </pre>";
//        }
                //$controllername->addViewPath(PlaceBiletPath.'/View1/'.$Controllername);
                
//                $paths=  $controllername->get('_path');
//                if(!is_array($paths))$paths= array();
//                if(!is_array($paths['template']))$paths['template']= array();
//                   echo "<pre>\$paths: $paths <br>".print_r($paths,true)." </pre>";
//                array_unshift ($paths['template'],PlaceBiletPath.'/View1/'.$Controllername);
//                $controllername->set('_path',$paths); 
                
                if(PlaceBiletDev){
//                    toPrint(self::$contr->get("taskMap"),"\$controllername-: $controllername<br>\$contr->taskMap");
	echo "<pre> <br>".print_r(self::$contr->get("taskMap"),true)." </pre>";
//                echo "<pre>\$controllername-: $controllername<br>\$contr->taskMap:  <br>".print_r($contr->get("taskMap"),true)." </pre>";
////                echo "<pre>\$contr->methods:  <br>".print_r($contr->get("methods"),true)." </pre>";
//                echo "<a href='http://naelke.su/product/view/7/184'><b>Примадонны...............</b></a><br><br>";
                }
//                

                
                //$controllername = 'other';

                //echo '</pre>';
        

					
				$this->getApplication()->input->set('task', NULL);//, 'GET', true
				
//        echo "<pre>".$classController."_mod: ";
//        var_dump($controllername->get('redirect'));
//        echo "</pre>"; 
                 
//                if(PlaceBiletDev)JFactory::getApplication()->enqueueMessage(  "Task overwrite: ".print_r($this->JInput()->getCmd('task' ),TRUE));
//                echo "<pre>TASK: ";
//                var_dump($this->JInput()->getCmd('task' ));
//                echo "</pre>";
                
                
            }
            //$methodCode = file_get_contents($file);
            //$this->JInput()->getCmd('task','show');
            //$this->JInput()->set($name, $value = null, $hash = 'method', $overwrite = true)
            //$this->JInput()->set('task', $task.'mod', 'GET', true);
            //runkit_method_redefine ($classController, $methodController, $args, $methodCode, RUNKIT_ACC_PUBLIC);//" return code;"
            //runkit_method_add ($classController, $methodController.'mod', $args, $methodCode, RUNKIT_ACC_PUBLIC);//" return code;"
       
        
    } 
   
    function onBeforeDisplayEmpty(Event $event){
        
        $controller = &$event->getArgument(0);
    }
    /** 
     * Конструктор котролерров : Site/Admin
     * @param Event $event
     */
    function onConstructJshoppingControllerCategory(Event $event){
		
		/**
		 * @var Joomla\Component\Jshopping\Site\Controller\CategoryController $controller;
		 */
        $controller = &$event->getArgument(0);
		$controllername = $controller->getName();//strtolower(substr((string)$controller, 19));
		$file=PlaceBiletPath."/templates/$controllername/";
		
		$controller->addViewPath(JPATH_BASE."/templates/$this->template_name/html/com_jshopping/$controllername/");
		$controller->addViewPath($file); 
		$controller->addViewPath(JPATH_BASE."/templates/$this->template_name/html/com_jshopping/$controllername/");
            
            
		JHtml::stylesheet(JUri::root() . "/plugins/jshopping/placebilet/media/" . $this->params->themefile ?: 'theme_default.css');
           
    }
    
    /** При вызове количества из модели всех продуктов
     * 
     * @param type $type
     * @param type $adv_result
     * @param type $adv_from
     * @param type $adv_query
     * @param type $filters
     */
    function onBeforeQueryCountProductList(Event $event){//$type, &$adv_result, &$adv_from, &$adv_query, &$filters//   $type = "category"
                return;
//      $types = ['all_products', 'manufacturer', 'related_products', 'rand_products', 'bestseller_products', 'label_products',
//          'top_rating_products', 'top_hits_products', 'vendor', 'search',];
//        
//        
//        if(in_array($type, $types) && $CategoriesRedirect = $this->params->get('CategoriesRedirect', 0)){
//
//            list($CategoriesRedirect) = explode('-', $CategoriesRedirect);
//            settype($CategoriesRedirect, 'int');
////            toPrint($CategoriesRedirect,'$CategoriesRedirect',0);
//            $adv_query .= " AND $CategoriesRedirect IN (cat.category_parent_id, cat.category_id) ";
//        }
//        if($type == 'category' && $CategoriesRedirect = $this->params->get('CategoriesRedirect', 0)){
//
//            list($CategoriesRedirect) = explode('-', $CategoriesRedirect);
//            settype($CategoriesRedirect, 'int');
////            toPrint($CategoriesRedirect,'$CategoriesRedirect',0);
//            $adv_result .= ", cat2.category_id category_id";
//            $adv_query .= " AND $CategoriesRedirect IN (cat2.category_parent_id, cat2.category_id)  ";
//            $adv_from .= " LEFT JOIN #__jshopping_products_to_categories AS pr_cat2 USING (product_id) ";
//            $adv_from .= " LEFT JOIN #__jshopping_categories AS cat2 ON pr_cat2.category_id = cat2.category_id ";
//        }
//        //all_products, manufacturer, related_products, rand_products, bestseller_products, label_products, top_rating_products, top_hits_products
//        //vendor, search, 
//        
//        if($this->params->get('bilets_list_count', FALSE)){            
////Добавить в SELECT запроса
////sum (case when order.id is null then 0 else 1 end) order,
////sum (case when cat.id is null then 0 else 1 end) cat,
////prod.name, 
////prod.product_id  
//            $adv_result .= ", count(prod_attr.id) count";
//            $adv_from .= " LEFT JOIN #__jshopping_products_attr2 prod_attr USING (product_id)  ";
//        }
    }
  
	
	
	/**
	 * Клиент - Вызывается при отображении списка подкатегорий для отображения продуктов(Пункт меню Категория). Перез запросом БД на список категоррий
	 * @param \Joomla\Component\Jshopping\Site\Table\CategoryTable $tableCategory
	 * @param string $queryAllCategories
	 */
	function onGetSubCategoriesCategoryTable(Event $event){// \Joomla\Component\Jshopping\Site\Table\CategoryTable &$tableCategory, string &$queryAllCategories

//		toPrint();
//		toPrint($queryAllCategories);
	}
    
	/**
	 * Клиент - Вызывается в контроллере после получения категорий из БД
	 * @param type $tableCategory
	 * @param type $categoriesDB
	 * @param type $appParams
	 */
	function onBeforeDisplayMainCategory(Event $event){//&$tableCategory, &$categoriesDB, &$appParams
		
//		toPrint();
//		toPrint($appParams);
	}
	
	/**
	 * Клиент - Выполняется после получения категорий до формирования запроса БД и фильтра к этому запросу
	 * @param type $tableCategory
	 * @param type $sub_categoriesDB
	 */
	function onBeforeDisplayCategory( Event $event){// &$tableCategory, &$sub_categoriesDB
		$sub_categoriesDB = $event->getArgument(1);
//		toPrint();
//		toPrint(array_column($sub_categoriesDB, 'category_id'));
		
		$this->sub_categoriesDBforCategoryPageClient = array_filter(array_column($sub_categoriesDB, 'category_id'));
//		toPrint($this->sub_categoriesDBforCategoryPageClient,'$this->sub_categoriesDBforCategoryPageClient');
	}
	
	private $sub_categoriesDBforCategoryPageClient = [];
	
	/**
	 * Клиент - Вызывается после создания фильтра до формирования условий запроса получения списка продуктов.
	 * @param array $filters
	 * @param type $no_filter
	 */
	function onAfterGetBuildFilterListProduct(Event $event){//&$filters, &$no_filter
		$filters	= &$event->getArgument(0);
		$filters['categorys'] = array_merge($filters['categorys'],$this->sub_categoriesDBforCategoryPageClient);
//		toPrint($filters['categorys'], '$filters[categorys]');
//		toPrint();
//		toPrint(array_column($sub_categoriesDB, 'category_id'));
	}
    /** 
     * При вызове из модели всех продуктов
     * @param type $type
     * @param type $adv_result
     * @param type $adv_from
     * @param type $adv_query
     * @param type $order_query
     * @param type $filters
     */
    function onBeforeQueryGetProductList(Event $event){//$type, &$adv_result, &$adv_from, &$adv_query, &$order_query, &$filters//$type="all_products"
        $type		= &$event->getArgument(0);
        $adv_result = &$event->getArgument(1);
        $adv_from	= &$event->getArgument(2);
        $adv_query	= &$event->getArgument(3);
        $order_query = &$event->getArgument(4);
        $filters	= &$event->getArgument(5);
		
        //$order_query = str_replace( 'pr.product_date_added,', 'pr.date_event, pr.product_date_added, ',$order_query);
        //prod.product_date_added
        $adv_query = str_replace( 'prod.product_date_added', 'prod.date_event ',$adv_query);
        $order_query = str_replace( 'prod.product_date_added,', 'prod.date_event, ',$order_query);
        $adv_result = str_replace( 'prod.product_ean,', 'prod.date_event, prod.date_tickets, prod.event_id, prod.product_ean,  prod.params, prod.RepertoireId, prod.StageId, ',$adv_result);
        //count(prod_attr.id) count,
		
//toPrint($adv_result);
//toPrint($adv_query);
		$adv_result .= " , GROUP_CONCAT(DISTINCT cat.category_id) category_ids ";
/*
z2a3x_jshopping_products_attr2 (product_id, attr_id, attr_value_id, price_mod, addprice) ;



SELECT prod.product_id, pr_cat.category_id, prod.`name_ru-RU` as name, prod.`short_description_ru-RU` as short_description, prod.date_event, prod.product_ean, 
  prod.params,prod.RepertoireId,prod.StageId, prod.image, prod.product_price, prod.currency_id, prod.product_tax_id as tax_id, prod.product_old_price, 
  prod.product_weight, prod.average_rating, prod.reviews_count, prod.hits, prod.weight_volume_units, prod.basic_price_unit_id, prod.label_id, 
  prod.product_manufacturer_id, prod.min_price, prod.product_quantity, prod.different_prices 
    
FROM `pac0x_jshopping_products` AS prod 
LEFT JOIN `pac0x_jshopping_products_to_categories` AS pr_cat USING (product_id)
LEFT JOIN `pac0x_jshopping_categories` AS cat ON pr_cat.category_id = cat.category_id
            LEFT OUTER JOIN z2a3x_jshopping_products_attr2 prod_attr USING (product_id) 
                   FULL OUTER JOIN `pac0x_jshopping_products_attr2` AS pr_attr USING (product_id)
WHERE prod.product_publish=1 AND cat.category_publish=1  AND prod.access IN (1,1,5) AND cat.access IN (1,1,5)
GROUP BY prod.product_id  ORDER BY prod.date_event ASC ; */

		$category_id = PlaceBiletHelper::JInput('category_id', 0);
		
        $types = ['all_products', 'manufacturer', 'related_products', 'rand_products', 'bestseller_products', 'label_products',
            'top_rating_products', 'top_hits_products', 'vendor', 'search',];
        
        $CategoriesRedirect = $this->params->get('CategoriesRedirect', 0);
        if(in_array($type, $types) && $CategoriesRedirect && $category_id){

            list($CategoriesRedirect) = explode('-', $CategoriesRedirect);
            settype($CategoriesRedirect, 'int');
//            toPrint($CategoriesRedirect,'$CategoriesRedirect',0);
            $adv_query .= " AND $CategoriesRedirect IN (cat.category_parent_id, cat.category_id) ";
        }
		
        if($type === 'category' && $CategoriesRedirect)// && $category_id
		{

            list($CategoriesRedirect) = explode('-', $CategoriesRedirect);
            settype($CategoriesRedirect, 'int');
//            toPrint($CategoriesRedirect,'$CategoriesRedirect',0);
            $adv_result .= ", cat2.category_id category_id";
            $adv_query .= " AND $CategoriesRedirect IN (cat2.category_parent_id, cat2.category_id)  ";
            $adv_from .= " LEFT JOIN #__jshopping_products_to_categories AS pr_cat2 USING (product_id) ";
            $adv_from .= " LEFT JOIN #__jshopping_categories AS cat2 ON pr_cat2.category_id = cat2.category_id ";
        }
        //all_products, manufacturer, related_products, rand_products, bestseller_products, label_products, top_rating_products, top_hits_products
        //vendor, search, 
//toPrint($type,'$type');
        if($this->params->get('bilets_list_count', FALSE) || $this->params->get('bilets_list_min_addprice', FALSE)){
			
//			echo$type; 
//Добавить в SELECT запроса
//sum (case when order.id is null then 0 else 1 end) order,
//sum (case when cat.id is null then 0 else 1 end) cat,
//prod.name, 
//prod.product_id  
//			$costCarrency = $this->params->get('costCarrency', 1);
//			
//			$min_addprice = '';
//			switch ($this->params->get('bilets_list_min_addprice', FALSE)){
//				case '2':
//					$min_addprice = " min(if(prod_attr.addprice=0, NULL, prod_attr.addprice)) min_addprice "; break;
//				case '1':
//					$min_addprice = " min(prod_attr.addprice) min_addprice "; break;
//				default :
//					$min_addprice = " NULL min_addprice "; break;
//					
//			}
//toPrint($type);
			
            $adv_result .= ', count(prod_attr.id) count ';//", count(prod_attr.id) count"; //count(prod_attr.product_id) 'count',  //   ', "count(prod_attr.id) count" ';//
            if($this->params->get('bilets_list_min_addprice', 1))
				$adv_result .= ", min(prod_attr.addprice) min_addprice ";
			$adv_from .= " LEFT JOIN #__jshopping_products_attr2 prod_attr ON prod_attr.product_id = prod.product_id     "; //  USING (product_id) --USING (product_id)
            if($this->params->get('bilets_list_min_addprice', 1)==2)
				$adv_from .= " AND prod_attr.addprice != 0 ";
            if( in_array($type, ['random',])) // !in_array($type, ['all_products','search','x-equals_products','products']) // all_products 
                    $order_query = " GROUP BY prod.product_id ". $order_query;
//            toPrint($adv_result,'$adv_result');
//            toPrint($adv_from,'$adv_from');
        }
		
		
        
//        echo "<div style='display:table;'><br><br>$adv_result<div style='display:table-cell;'><br><br><br><pre>Запрос получения всех товаров: ";
//        echo "</pre></div></div>"; 
        //var_dump($adv_result);
        //toPrint($adv_query);
    }

	
	/**
	 * Клиент - Вызывается после создания запроса BD для получения продуктов
	 * @param type $typeName
	 * @param type $query
	 * @param type $filters
	 * @param type $obj
	 */
	function onBeforeExeQueryGetProductList(Event $event){//$typeName, &$query, &$filters, &$obj = NULL
		
		
		
//		toPrint();
//		toPrint($query, $typeName );
	}
	
    /**
     * Сайт - Вьювер категории - контролер 
     * @param JViewLegacy $viewobject
     */
    function onBeforeDisplayCategoryView(Event $event){//&$viewobject // случается в конце работы контролера перед визуализацией представления
        $viewobject	= &$event->getArgument(0);
//         return;
//		https://tickets.hc-grad.ru/components/com_jshopping/files/img_products	/plugins/jshopping/placebilet/media/noimage.png
		$viewobject->set('noimage', 'noimage.png');
        
        if (FALSE) {// Реорганизация
            $view = new JViewLegacy(array('name' => 'category', 'base_path' => PlaceBiletPath)); //, 'template_path'=>PlaceBiletPath."/view/category/category_default.php"
            //$view = $this->getView('category', 'html', '', array('base_path' => PlaceBiletPathAdmin));
            //$view->sidebar = JHtmlSidebar::render();
            $view->set('category', $viewobject->get('category'));
            $view->set('image_category_path', $viewobject->get('image_category_path'));
            $view->set('noimage', $viewobject->get('noimage'));
            $view->set('categories', $viewobject->get('categories'));
            $view->set('count_category_to_row', $viewobject->get('count_category_to_row'));
            $view->set('params', $viewobject->get('params'));

            $view->addTemplatePath(PlaceBiletPath . "/View/category/tmpl");

            $viewobject = $view;
        }
        
        $viewobject->setLayout("maincategory");//Имя файла php
        $name = $viewobject->get('_name');
				
		$viewobject->set('param', $this->params);
        $viewobject->addTemplatePath(JPATH_BASE."/templates/$this->template_name/html/com_jshopping/$name/"); //Новый шаблон  
        $viewobject->addTemplatePath(PlaceBiletPath.'/templates/category');//Новый шаблон
        $viewobject->addTemplatePath(JPATH_BASE."/templates/$this->template_name/html/com_jshopping/$name/"); //Новый шаблон   
    }
    
    
    /**
     * Модель списка товаров
     * вызывается в самом начале загрузки модели списка товаров
     **/
    function onBeforeLoadProductList(){
//        if($this->params->Zriteli_repertoire_download_enabled)
		if(class_exists('Zriteli'))
			Zriteli::LoadAllProducts(); 
    }
    /**
     * Конструктор котроллера списка товаров
     **/
    function onConstructJshoppingControllerProducts(Event $event){//$controllerProductsList=null
        Zriteli::DeleteOldProducts($this->params);
//        if($this->params->Zriteli_repertoire_download_enabled)
        Zriteli::LoadAllProducts(); //Удаление/Скрытие прошедших представлений согласно интервалу 
    }
    
                

    /**
     * Клиент -  Подгрузка метаданных для каждого из списка продуктов для Table(Category)->getProducts()
     * @param array $products
     * @param int $key
     * @param var $product
     * @param int $use_userdiscount
     */
    function onListProductUpdateDataProduct(Event $event){//&$products, &$key, &$product, &$use_userdiscount//trigger('onBeforeDisplayProductList', array(&$products))
		
		$products			= &$event->getArgument(0);
		$key				= &$event->getArgument(1);
		$product			= &$event->getArgument(2);
		$use_userdiscount	= &$event->getArgument(3);
		
		foreach ($products as &$prod){
			if(isset($prod->category_ids) && is_string($prod->category_ids)){
				$prod->category_ids = str_getcsv($prod->category_ids);
			}
		}
    }
    /**
     * Клиент - Изменение в ссылках продуктов ID категорий для редиректа перед отображением списка продуктов  категории
     * @param array $products
     */
    function onListProductUpdateData(Event $event){//&$products
//        toPrint($products,'$products');
//        PlaceBiletHelper::addLinkToProducts($products);
//        toPrint($products,'$products');
    }
    
    /**
     * Сайт - Изменение в ссылках продуктов ID категорий для редиректа перед отображением списка продуктов  категории
     * @param array $products
     */
    function onBeforeDisplayProductList(Event $event){//&$products
		
		$products			= &$event->getArgument(0);
		
        
        //Скрытие цены на странице списка товаров
        foreach ($products as &$prod)
            $prod->_display_price = FALSE;
//        toPrint(array_keys((array)$viewobject->rows[0]),'$viewobject');
//        toPrint($products[0]->_display_price,'$viewobject');
        //_display_price
        
//        toPrint($products,'$products'); 
        PlaceBiletHelper::addLinkToProducts($products);//addLinkToProducts
//        toPrint($products,'$products');
    } 


    /**
     * Сайт - Вьювер товаров в котролере
     * При представление таблицы отображения товаров. 
     * Вьювер при просмотре списка товаров 
     * @param JViewLegacy $viewobject
     * @param array $productlist
     */
    function onBeforeDisplayProductListView(Event $event){// &$viewobject// случается в конце работы контролера перед визуализацией представления 
		
		$viewobject		= &$event->getArgument(0);

		$viewobject->set('noimage', 'noimage.png');
//        return;
//        toPrint('УУУУУУУУУУУРРРРРРРРРРАААА!!!!!!!!!!!'); 
        if (FALSE) {// Реорганизация products products
        // с новым представлением шаблонизируется файл DEFAULT а без новгого шаблона шаблонизируется файл PRODUCTS    
            $view = new JViewLegacy(array('name' => 'products', 'base_path' => PlaceBiletPath)); //, 'template_path'=>PlaceBiletPath."/view/category/category_default.php"
            //$view = $this->getView('category', 'html', '', array('base_path' => PlaceBiletPathAdmin));

            $view->set('category', $viewobject->get('category'));
            $view->set('image_category_path', $viewobject->get('image_category_path'));
            $view->set('noimage', $viewobject->get('noimage'));
            $view->set('categories', $viewobject->get('categories'));
            $view->set('count_category_to_row', $viewobject->get('count_category_to_row'));
            $view->set('params', $viewobject->get('params'));

            $view->set('config', $viewobject->get('config'));
            $view->set('template_block_list_product', $viewobject->get('template_block_list_product'));
            $view->set('template_no_list_product', $viewobject->get('template_no_list_product'));
            $view->set('template_block_form_filter', $viewobject->get('template_block_form_filter'));
            $view->set('template_block_pagination', $viewobject->get('template_block_pagination'));
            $view->set('path_image_sorting_dir', $viewobject->get('path_image_sorting_dir'));

            $view->set('filter_show', $viewobject->get('filter_show'));
            $view->set('filter_show_category', $viewobject->get('filter_show_category'));
            $view->set('filter_show_manufacturer', $viewobject->get('filter_show_manufacturer'));
            $view->set('pagination', $viewobject->get('pagination'));
            $view->set('pagination_obj', $viewobject->get('pagination_obj'));
            $view->set('display_pagination', $viewobject->get('display_pagination'));

            $view->set('header', $viewobject->get('header'));
            $view->set('prefix', $viewobject->get('prefix'));
            $view->set('rows', $viewobject->get('rows'));
            $view->set('count_product_to_row', $viewobject->get('count_product_to_row'));
            $view->set('action', $viewobject->get('action'));
            $view->set('allow_review', $viewobject->get('allow_review'));
            $view->set('orderby', $viewobject->get('orderby'));
            $view->set('product_count', $viewobject->get('product_count'));

            $view->set('sorting', $viewobject->get('sorting'));
            $view->set('categorys_sel', $viewobject->get('categorys_sel'));
            $view->set('manufacuturers_sel', $viewobject->get('manufacuturers_sel'));
            $view->set('filters', $viewobject->get('filters'));
            $view->set('willBeUseFilter', $viewobject->get('willBeUseFilter'));
            $view->set('display_list_products', $viewobject->get('display_list_products'));
            $view->set('shippinginfo', $viewobject->get('shippinginfo'));

            $view->addTemplatePath(PlaceBiletPath . "/templates/products/");

                    $viewobject = $view;

        }
//        toPrint($viewobject->get('_layout'),'_layout','',0);
//        toPrint($viewobject->get('_name'),'_name','',0);
//        toPrint($viewobject->get(''),'','',0);
//        toPrint($viewobject->get(''),'','',0);
        
//        toPrint($template,'$template','',0);
        //$view->setLayout("product_default");//Имя файла
          
//        $templateCurrent = JFactory::getApplication()->getInstance();//->getTemplate(TRUE);
//        toPrint($templateCurrent);
        // current()
//$layout =$viewobject->get('_layout'); 
//return; 
        $name =$viewobject->get('_name'); 

//        toPrint(array_keys((array)$viewobject->rows[0]),'$viewobject');
//        //_display_price
        
        //$templates = $viewobject->get('_path','')['template']; 
//        Jfactory::getApplication();
        //$template = current($templates);
		
//		$viewobject->set('param',$this->params); 
		$viewobject->set('param', $this->params); 
        
        //$viewobject->addTemplatePath(JPATH_BASE."/templates/$this->template_name/html/com_jshopping/$name/0/"); //Новый шаблон  
        $viewobject->addTemplatePath(PlaceBiletPath . "/templates/$name/"); //Новый шаблон    
        //$viewobject->addTemplatePath($template); //Новый шаблон  
   
        $viewobject->addTemplatePath(JPATH_BASE."/templates/$this->template_name/html/com_jshopping/$name/"); //Новый шаблон  
        
        $products = &$viewobject->rows; 
        PlaceBiletHelper::addLinkToProducts($products);
        
        $viewobject->rows = &$products;
        //$productlist->setProducts($products);
        
        //toPrint($viewobject);
            //[0] => /home/c/cirkbilet/naelke.su/public_html/plugins/jshopping/placebilet/templates/products/
            //[1] => /home/c/cirkbilet/naelke.su/public_html/plugins/jshopping/placebilet//templates/products/
            //[2] => /home/c/cirkbilet/naelke.su/public_html/templates/rsmetro/html/com_jshopping/products/
            //[3] => /home/c/cirkbilet/naelke.su/public_html/plugins/jshopping/placebilet/View/products/tmpl/
                    
            //[0] => /home/c/cirkbilet/naelke.su/public_html/plugins/jshopping/placebilet/templates/products/
            //[1] => /home/c/cirkbilet/naelke.su/public_html/templates/rsmetro/html/com_jshopping/products/
            //[2] => /home/c/cirkbilet/naelke.su/public_html/components/com_jshopping/templates/default/products/
                
            ///home/c/cirkbilet/naelke.su/public_html/plugins/jshopping/placebilet/templates/products/
            
    }



	/**
	 * Сайт - Шаблон отображение рядов с местами в продукте.
	 * Затычка для JoomShoppint для J4. 
	 * Нет прямой передачи объекта продукта в представление Атрибута/ряда с местами.
	 */
	function onBuildSelectAttributeView(Event $event){//$view
		$view = $event->getArgument(0);
		$product = PlaceBiletHelper::$product;
		
        $templates = &$view->get('_path','')['template']; 
        $name = $view->get('_name');  
        $view->set('product', $product);
        $template = current($templates);
        $view->addTemplatePath(JPATH_BASE."/templates/$this->template_name/html/com_jshopping/$name/"); //Новый шаблон   
        $view->addTemplatePath(PlaceBiletPath . "/templates/$name/"); //Новый шаблон  
        $view->addTemplatePath(JPATH_BASE."/templates/$this->template_name/html/com_jshopping/$name/"); //Новый шаблон  
                
		
        $view->addTemplatePath($template); //Новый шаблон
        $templates = $view->get('_path','')['template']; 
	}
    /**
     * Проверка категории на показ $category->checkView()
     */
    function onAfterLoadCategory(Event $event){//$category, &$user
		$category	= $event->getArgument(0);
		$user		= $event->getArgument(1);
        if (!$category->category_id || $category->category_publish==0 || !in_array($category->access, $user->getAuthorisedViewLevels())){
            //$link = JUri::root().JSHelper::SEFLink("index.php?option=com_jshopping&controller=category&task=view&category_id=$category_id");
            //$link = JUri::root().JSHelper::SEFLink("index.php?option=com_jshopping&controller=product&task=view&category_id=$category_id&product_id=$product->product_id", 1);
            $link = JUri::root().JSHelper::SEFLink("index.php?option=com_jshopping&controller=category", 1);
            $link = JUri::root().JSHelper::SEFLink("index.php?option=com_jshopping", 1);
            $app = JFactory::getApplication();
            //$app->enqueueMessage(JText::_('JINVALID_TOKEN_NOTICE'), 'warning');
            $app->redirect($link);      
            //return 0;
        }else{
            return 1;
        }
    }
    /**
     * Проверка продукта на показ $product->checkView()
     */
    function onBeforeCheckProductPublish(Event $event){//$product, $category, $category_id, $listcategory
        $product = $event->getArgument(0);
		$category = $event->getArgument(1);
		$category_id = $event->getArgument(2);
		$listcategory = $event->getArgument(3);
        
//	toPrint($category_id,'$category_id');
//	toPrint($category->category_parent_id,'$category_parent_id');
//	toPrint($category->name,'$category->name');
//	toPrint($product->name,'$product->name');
//	toPrint($product->product_id,'$product->product_id');
//        
//	toPrint($category->category_publish,'$category->category_publish');
//	toPrint($product->product_publish,'$product->product_publish');
//	toPrint($listcategory,'$listcategory');
//	toPrint(($category->category_publish==0 || $product->product_publish==0 || !in_array($category_id, $listcategory)),'($category->category_publish==0 || $product->product_publish==0 || !in_array($category_id, $listcategory))');
        
        
//        return 1;
        
        if ($category->category_publish==0 || $product->product_publish==0 || !in_array($category_id, $listcategory)){// || !in_array($product->access, $this->usershop->getAuthorisedViewLevels())
            
        $link = JUri::root().JSHelper::SEFLink("index.php?option=com_jshopping&controller=category&task=view&category_id=$category_id");
        //$link = JUri::root().JSHelper::SEFLink("index.php?option=com_jshopping&controller=product&task=view&category_id=$category_id&product_id=$product->product_id", 1);
        
          
            $app = JFactory::getApplication();
            //$app->enqueueMessage(JText::_('JINVALID_TOKEN_NOTICE'), 'warning');
            $app->redirect($link);      
            //return 0;
		}else{
            return 1;
		}
    }
	
	
    /**
     * Сайт - Котроллер товара перед загрузкой товара из БД.
     * перед заполненим его переменными
     **/
    function onBeforeLoadProduct(Event $event){//&$product_id, &$category_id, &$back_value
		$product_id = $event->getArgument(0);
//        toPrint($product_id,'$product_id',0);
//        toPrint($category_id,'$category_id',0);
//        toPrint($back_value,'$back_value',0);
        try {
            if(class_exists('Zriteli'))
				Zriteli::LoadAllPiecesFromProducts(NULL, $product_id); //расскоментировать. 
        } catch (Exception $exc) { 
            toLog($exc->getTraceAsString(),'Zriteli::LoadAllPiecesFromProducts()');
            //toPrint($exc->getTraceAsString(),'!!! ОШИБКА !!! ... ,plgJshoppingPlaceBilet::onBeforeDisplayProduct() => Zriteli::LoadAllPiecesFromProducts(): ') ;
        }
    }

    /**
     * Сайт - Вьювер товара в котролере
     * перед заполненим его переменными
	 * 
	 * @param \Joomla\Component\Jshopping\Site\Table\ProductTable $product
	 * @param type $view
	 * @param type $product_images
	 * @param type $product_videos
	 * @param type $product_demofiles
	 */
    function onBeforeDisplayProduct(Event $event){ //&$product, &$view, &$product_images, &$product_videos, &$product_demofiles
		$product	= $event->getArgument(0);
		$view		= $event->getArgument(1);
		
//        return;
//		$x = new Joomla\CMS\MVC\Factory\LegacyFactory(); 
//		$x->createView($name, $prefix);
		PlaceBiletHelper::$product = $product;
		
//toPrint(get_class($view->get('product')), ' $product    '.  "<br><br>",true,'message'); 
//toPrint($product->product_id, '- $product->product_id    ',true,'message'); 
//toPrint($product->_display_price, '- $product->_display_price    ',true,'message'); 
//toPrint(array_keys((array)$product), '- $product    ',true,'message'); 
//toPrint(array_keys((array)$view->get('product')), ' $product    '.  "<br><br>",true,'message'); 

		// Отключение вывода цены для продукта
		$product->_display_price = FALSE; 

//		$view->get('product')->_display_price = FALSE; 

		$accordion = $this->params->get('accordion',false);
		$acc_jQuery = ($accordion=='jQuery');
//		$acc_jBS	= ($param->accordion=='jbootstrap');
//		$acc_BS		= ($accordion=='bootstrap');
//		$acc_none	= ($accordion=='none' || empty($accordion));

		if($acc_jQuery)JHtml::stylesheet("plugins/jshopping/placebilet/media/jquery-ui.css");
		if($acc_jQuery)JHtml::stylesheet("plugins/jshopping/placebilet/media/jquery-ui.structure.css");
		if($acc_jQuery)JHtml::stylesheet("plugins/jshopping/placebilet/media/jquery-ui.theme.css");
		if($acc_jQuery)JHtml::script("plugins/jshopping/placebilet/media/jquery-ui.js"); 
		JHtml::script("plugins/jshopping/placebilet/media/bilet.js");

		jimport ('joomla.html.html.bootstrap');
		JHtml::_('bootstrap.framework');
		JHtml::_('jquery.framework');
		
//        try {
//            $params = json_decode($product->params);
//            if(is_object($params)){
//                $product->StageId = $params->StageId;
//                $product->category_id = $params->category_id;
//                $product->RepertoireId = $params->RepertoireId;
//                $product->OffersId = $params->OffersId; 
//                $product->EventDateTime = $product->date_event; 
//                Zriteli::LoadAllPiecesFromProducts($product,0, $params->RepertoireId,$product->date_event); //расскоментировать.
//            }
//            else  {
//                Zriteli::LoadAllPiecesFromProducts($product,$product->product_id); //расскоментировать.
//            }
//        } catch (Exception $exc) { 
//            toLog($exc->getTraceAsString(),'Zriteli::LoadAllPiecesFromProducts()');
//            //toPrint($exc->getTraceAsString(),'!!! ОШИБКА !!! ... ,plgJshoppingPlaceBilet::onBeforeDisplayProduct() => Zriteli::LoadAllPiecesFromProducts(): ') ;
//        }
        $view->setLayout("product_default");//Имя файла
        $view->addTemplatePath(PlaceBiletPath.'/templates/product/'); //Новый шаблон 
        $view->addTemplatePath(JPATH_BASE."/templates/$this->template_name/html/com_jshopping/product/");//Новый шаблон 
		
		
		$view->set('param', $this->params);
                
		
		
    
//        if (FALSE) {
//            $viewname = strtolower(substr((string) $view, 13));
//            //echo "<pre>\$view: $viewobject $viewname<br>".print_r($viewobject,true)." </pre>";     
////            $paths = $controllerobject->get("paths"); 
//        
//            $view = new JViewLegacy(array('name' => 'product', 'base_path' => PlaceBiletPath)); //, 'template_path'=>PlaceBiletPath."/view/category/category_default.php"
//            //$view = $this->getView('category', 'html', '', array('base_path' => PlaceBiletPathAdmin));
////        $view->sidebar = JHtmlSidebar::render(); 
//        }
        

        
//                echo "<div style='display:table;'><br><br><div style='display:table-cell;'><br><br><pre>Запрос получения всех товаров: ".$viewobject->getName()
//                        ."<br>_layout: ".$viewobject->get('_layout')."<br>_layoutTemplate: ".$viewobject->get('_layoutTemplate')."<br>".print_r($viewobject->get('_path'),TRUE)."";
//                echo "</pre></div></div>"; 
    }

    /** Сайт - Вывод списка мест на экран в товаре
     * 
     * @param JViewLegacy $view
     */
    function  onBeforeDisplayProductView(Event $event){//$view
		$view = $event->getArgument(0);
		$view->product->_display_price = FALSE; 
		
        $view->show_plus_shipping_in_product = 0;	// Показать "плюс доставка"
        $view->hide_buy = TRUE;		// Скрыть Кнопку КУПИТЬ
        $view->set('hide_buy',TRUE);	// Скрыть Кнопку КУПИТЬ
        $view->show_delivery_time = 0;				// Показать "Срок поставки"    
        $view->product_show_weight = 0;				//Показать вес товара
        $view->hide_product_not_avaible_stock = FALSE;	// Скрыть товары, которые не доступны на складе 
		$view->hide_buy_not_avaible_stock = FALSE;		//Скрыть кнопку купить, если товара нет на складе
        $view->hide_text_product_not_available = TRUE; // Скрыть текст "Товар не доступен"	
		
		$render_prod_buttons = JLayoutHelper::render('prod_buttons', (array)$view, PlaceBiletPath . '/templates/product/');
		
//		$view->set('_tmp_product_html_before_buttons', $render_prod_buttons . $view->get('_tmp_product_html_before_buttons',''));
		$view->_tmp_product_html_before_buttons = $render_prod_buttons . $view->_tmp_product_html_before_buttons;
		/** @var \Joomla\CMS\WebAsset\WebAssetManager $wa */
//		$wa = JFactory::getApplication()->getDocument()->getWebAssetManager();
//		$wa->addInlineStyle(".prod_buttons:not(.buttons){display: none !important;}");

//		$this->onPrepare($view);

		
		$view->set('displaybuttons', 'display:none !important');
		
		$lang = JSFactory::getLang()->lang;
        $db = JFactory::getDBO();

        
        $attributes = $view->get('attributes');
        $places = array();
        $product_id = $view->get('product')->product_id;
        
        $product_date_event = $view->get('product')->date_event;
//        $product_date_tickets = $view->get('product')->date_tickets;
                
        
        $bonusEnabled = $this->params->get('bonusEnabled', FALSE);
        $bonus = 1;
        if($bonusEnabled)
			$bonus = PlaceBiletHelper::getBonusProduct($product_date_event);
        //toPrint($bonus,'  $bonus');
        if($bonusEnabled)
			$view->_tmp_product_html_before_atributes .= '<span class="bonusText">'.(JText::_('BONUS')).'</span>';
        if($bonusEnabled)
			$view->_tmp_product_html_before_atributes .= '<span class="bonusPercent">'.(PlaceBiletHelper::getBonusProductPercent($bonus)).'%</span>';
        if($bonusEnabled)
			$view->set('bonus',PlaceBiletHelper::getBonusProductPercent($bonus));
        
        
//toPrint();
//toPrint($attributes,'$attributes',0,'message',true);
        
//        $query = "SELECT g.id, g.ordering, g.`".$lang->get('name')."` FROM #__jshopping_attr_groups g  ORDER BY g.ordering; ";
//        $db->setQuery($query); 
//        $groups_place = $db->loadObjectList('id');
        
         
//        $query = "SELECT a.attr_id, a.attr_ordering, a.cats, a.`group` group_id, a.`".$lang->get('name')."` attr_name, a.`".$lang->get('description')."` attr_description, count(pa2.id) place_count 
//                            FROM #__jshopping_products_attr2 pa2, #__jshopping_attr a 
//                            WHERE  a.`attr_type`=4 AND  pa2.product_id=184 AND pa2.attr_id = a.attr_id  
//                            GROUP BY a.attr_id; ";
//        $db->setQuery($query); 
//        $attributes_place = $db->loadObjectList('attr_id');
        //return;
        
        
//        toPrint($view->get('product')->product_categories,'$view->get(\'product\')->product_categories',0);
        //***Подгрузка названий категорий в объект товара для вывода списка категорий в представлении.
        if($cats_id = array_column($view->get('product')->product_categories,'category_id')){
            $query = "SELECT c.`name_$lang` name, c.category_id, c.category_parent_id, c.ordering FROM #__jshopping_categories c WHERE c.category_id IN (".join(",",$cats_id).") ORDER BY c.ordering,c.category_id;";
            
//toPrint($query,'$query',true,'message');
            $db->setQuery($query);
            
            $cats = $db->loadObjectList('category_id'); 
            $cs = []; 
            $sort = [];
            foreach ($view->get('product')->product_categories as &$cat){
                $cat->name = $cats[$cat->category_id]->name ?? '';
                $cat->category_parent_id = $cats[$cat->category_id]->category_parent_id ?? '';
                $cat->category_ordering = $cats[$cat->category_id]->ordering ?? 1;
                $cs[$cat->category_id] = &$cat;
                $sort[$cat->category_id] = $cat->category_ordering;
            }
//            array_multisort($sort, SORT_ASC, $cs);
            $view->get('product')->product_categories = $cs;
            
//            toPrint($view->get('product')->product_categories,'$view->get(\'product\')->product_categories',0);
//            toPrint($this->params->get('CategoriesRedirect', FALSE),'$this->params->get(\'CategoriesRedirect\', FALSE)',0);
        }
        
		
//*** Подключение ссылок Социльной раздачи
		// <editor-fold defaultstate="collapsed" desc="Подключение ссылок Социльной раздачи">
		$data_social = [
			'product_categories' => $view->get('product')->product_categories,
			'date_event' => $view->get('product')->date_event ?? '',
			'product_id' => $view->get('product')->product_id ?? '',
			'product_image' => $view->get('product')->image ?? '',
			'product_description' => $view->get('product')->description ?? '',
			'product_name' => $view->get('product')->name,
			'params' => $this->params,
		];
		$_tmp_product_html = JLayoutHelper::render('social_share', $data_social, PlaceBiletPath . '/templates/product/', $options = null);
		
		switch ($this->params->socialposition ?? 2) {
			case 1 :
				$view->_tmp_product_html_start .= $_tmp_product_html;
//				$view->set('_tmp_product_html_start', $_tmp_product_html . $view->get('_tmp_product_html_start'));
				break;
			case 3 :
				$view->_tmp_product_html_end .= $_tmp_product_html;
//				$view->set('_tmp_product_html_end', $_tmp_product_html . $view->get('_tmp_product_html_end'));
				break;
			default:
				$view->_tmp_product_html_after_buttons .= $_tmp_product_html;
//				$view->set('_tmp_product_html_after_buttons', $_tmp_product_html . $view->get('_tmp_product_html_after_buttons'));
				break;

		}
		// </editor-fold>





		if($CategoriesRedirect = $this->params->get('CategoriesRedirect', FALSE) && $cats_id){ 
            $product_categories = $view->get('product')->product_categories;        
//            toPrint($product_categories,'$product_categories',0);
        }
        
		
		
		
        
        $db = JFactory::getDBO();
        $lang = JSFactory::getLang()->lang;
		
//places_sort[(int)$place->attr_id][(int)$place->group_id][$place->addprice][]
		$query = "
SELECT pa2.attr_id,  pa2.product_id,	pa2.id id,	pa2.id product_attr2_id,a.cats,	 pa2.attr_value_id, pa2.price_mod,pa2.addprice, pa2.OfferId, 
	av.`name_$lang` place_name,  IF( (av.`name_$lang` REGEXP '^[0-9]+$'), 'int', 'str') type, 
	a.attr_ordering, a.`name_$lang` attr_name, a.`description_$lang` attr_description, a.attr_type, 
	a.`group` group_id, ag.`name_$lang` group_name, ag.ordering group_order 
FROM #__jshopping_products_attr2 AS pa2, #__jshopping_attr_values av,  #__jshopping_attr a 
LEFT JOIN #__jshopping_attr_groups ag 
ON a.`group` = ag.id 
WHERE  pa2.attr_id = a.attr_id AND pa2.attr_value_id=av.value_id AND pa2.product_id = $product_id AND a.attr_type IN (4,5) 
ORDER BY a.attr_ordering, ag.ordering, pa2.addprice, av.`name_$lang`; ";
//echo "<pre>\$query: $query <br>"." </pre>";
        
//\Joomla\CMS\Factory::$application->enqueueMessage("<pre>plg 1529 <b>\$query</b> ".print_r($query,true)."</pre>");
//return; // IF( LENGTH(CAST(av.`name_ru-RU` AS UNSIGNED)) = LENGTH(av.`name_ru-RU`)   , 'int', 'str') `typex`,
		$db->setQuery($query);
        $places = $db->loadObjectList('id');
        
        //$db->query ();
        //$places = $db->loadObjectList('product_attr2_id');
        //$places = $db->loadObjectList('addprice');         
        //ksort($places);
        $var_attr_id  = -1;
        $var_group_id = -1;
        $var_addprice = -1;
        
        $places_sort	= [];
        $attributes_sort= [];
        $groups_sort	= [];
        
        
           
//toPrint($attributes,'$attributes',true,'message');
//\Joomla\CMS\Factory::$application->enqueueMessage("<pre>1578 \$attributes".print_r($attributes,true)."</pre>");
        
        foreach ($places as $id=>$place){
			
            $place->cats = unserialize($place->cats); // 
            
          //  $place->addprice *= $bonus; // Отключаем отображение цен со скидками на странице товара
            
            $bonusEnabled = $this->params->bonusEnabled; 
            
//            $roundBonusExist = (bool)$this->params->get('roundBonus', FALSE); // Нужно ли округлять // Условие перенесен в Helper            
//            if($roundBonusExist)
            //Округление цены до круглой
            $place->addprice = PlaceBiletHelper::RoundPrice($place->addprice);
            
            $places_sort[(int)$place->attr_id][(int)$place->group_id][$place->addprice][] = $place;
            if(isset($attributes[(int)$place->attr_id]))
                unset($attributes[$place->attr_id]);
            
            //toPrint($place->addprice,'$place->addprice');
            
            if($var_attr_id != (int)$place->attr_id){
                $var_attr_id = (int)$place->attr_id;
                $attributes_sort[(int)$place->attr_id] = (object)['id' => $place->attr_id,'name' => $place->attr_name, 'description' => $place->attr_description];
            }
            if($var_group_id != (int)$place->group_id){
                $var_group_id = (int)$place->group_id;
                $groups_sort[(int)$place->group_id] = $place->group_name;
            }
            if($var_addprice != $place->addprice){
                    
                $var_addprice = $place->addprice;
                $groups_sort[$place->addprice] = $place->group_name;
            }
        }
		
        $count_Places = 0;
        foreach ($places_sort as $attrs){
            foreach ($attrs as $groups){
                foreach ($groups as $prices){
                   $count_Places += count( $prices);
				}
			}
		}
//        echo '<br><br>';
//        foreach($places_sort as $key=> $attr){ 
//            echo "<pre>\$places_sort: $key count(".count($attr).') <br>';
//            foreach ($attr as $key => $group){
//                echo "____\$group $key count(".count($group).') <br>';
//                foreach ($group as $key => $addprice){
//                    echo "____ ____\$addprice $key count(".count($addprice).') <br>';
//                
//                }
//            }
//            echo '</pre><br>';
//        } 
        
//        $attributes = []; 
		$view->set('param',$this->params);
		$view->set('count_places', $count_Places);
		$view->set('places_sort', $places_sort);
		$view->set('attributes_sort', $attributes_sort);
		$view->set('groups_sort', $groups_sort);
//		$view->set('places', $places);
		$view->set('attributes',$attributes); 
		
//toPrint();
//toPrint($attributes,'$attributes',0,'message',true);
//\Joomla\CMS\Factory::$application->enqueueMessage("<pre>plg 1642 <b>\$places</b> ".count($places).' '.print_r($places,true)."</pre>");
//\Joomla\CMS\Factory::$application->enqueueMessage("<pre>plg 1644 <b>\$places_sort</b> ".count($places_sort).' '.print_r($places_sort,true)."</pre>");
//        $view->set('category', $view->get('category'));   
        
//                $templateCurrent = JFactory::getApplication()->getInstance();//->getTemplate(TRUE);
//        toPrint($templateCurrent);
//          toPrint($view);
//        $templates = array();
//        $templates= [PlaceBiletPath . "/templates/$this->template_name/"];
//        
//        $name =$view->get('_name'); 
//        $templates = array_merge($view->get('_path','')['template']);
        $templates = &$view->get('_path','')['template'];
        $template = current($templates);
//		$view->addTemplatePath(JPATH_BASE."/templates/$this->template_name/html/product");//Новый шаблон
//		$template_path=PlaceBiletPath . "/templates/$this->template_name/";
//		$template_path=JPATH_BASE . "/templates/$this->template_name/html/com_jshopping/product/";
//		array_unshift($templates,$template_path);
//		$template = current($templates);
//		$view->addTemplatePath(PlaceBiletPath . "/templates/$this->template_name/"); //Новый шаблон  
//		$view->addTemplatePath($template_path); //Новый шаблон 
//		$view->addTemplatePath($template_path); //Новый шаблон 
        $name =$view->get('_name'); 
//        Jfactory::getApplication();
        $view->addTemplatePath(JPATH_BASE."/templates/$this->template_name/html/com_jshopping/$name/"); //Новый шаблон  
//        $view->addTemplatePath(JPATH_BASE."/templates/$this->template_name/html/"); //Новый шаблон  
        $view->addTemplatePath(PlaceBiletPath . "/templates/$name/"); //Новый шаблон  
        $view->addTemplatePath(JPATH_BASE."/templates/$this->template_name/html/com_jshopping/$name/"); //Новый шаблон  
        $view->addTemplatePath($template); //Новый шаблон  
		
		
//		$templates = $view->get('_path','')['template']; 
//		toPrint($templates,'','',0); 
//		toPrint($view,'','',0);
//		$view->addTemplatePath(PlaceBiletPath."/templates/product/");
		
        $templates = &$view->get('_path','')['template'];
        $template = current($templates);
		
		$config = JSFactory::getConfig();
		
//\Joomla\CMS\Factory::$application->enqueueMessage("<pre>plg 1663 <b>\$places_attr</b> ".print_r($places_attr,true)."</pre>");
				
		$data_places = [
			'params'		=> $this->params,
			'count_places'	=> $count_Places,
			'places_sort'	=> $places_sort,
			'attributes_sort' => $attributes_sort,
			'groups_sort'	=> $groups_sort,
			'places'		=> $places,
			'attributes'	=> $attributes,
			'product'		=> $view->get('product'),
			'config'		=> $config,
		];
		
        $layout = new JLayoutFile('places', PlaceBiletPath . '/templates/product/', $options = null);
        $layout->addIncludePaths($template);
//        $layout->addIncludePath(PlaceBiletPath . '/templates/product/'); //Новый шаблон  
        $html_places = $layout->render($data_places);
		
//		$view->_tmp_product_html_after_buttons .= $html_places;
		if($this->params->show_places_BeforeAfterDescription == 'after')
			$view->get('product')->description .= $html_places;
		else
			$view->get('product')->description = $html_places . $view->get('product')->description;
		
		
		
				
		$data_places = [
			'params'		=> $this->params,
			'product'		=> $view->get('product'),
			'config'		=> $config,
//			'count_places'	=> $count_Places,
//			'places_sort'	=> $places_sort,
//			'attributes_sort' => $attributes_sort,
//			'groups_sort'	=> $groups_sort,
//			'places'		=> $places,
//			'attributes'	=> $attributes,
		];
		
        $layout = new JLayoutFile('time', PlaceBiletPath . '/templates/product/', $options = null);
        $layout->addIncludePaths($template);
//        $layout->addIncludePath(PlaceBiletPath . '/templates/product/'); //Новый шаблон  
        $html_places = $layout->render($data_places);
		
		$view->_tmp_product_html_before_atributes .= $html_places;// _tmp_product_html_before_atributes   _tmp_product_html_start
//		if($this->params->show_places_BeforeAfterDescription == 'after')
//			$view->get('product')->description .= $html_places;
//		else
//			$view->get('product')->description = $html_places . $view->get('product')->description;
        
//        <span class="review"><?php print JText::_('JSHOP_ADD_REVIEW_PRODUCT')</span>
    }
    

    
    /** Пусто
     * 
     * @param type $this
     * @param plgJshoppingPlaceBilet $this
     * @param type $product_id
     * @param type $quantity
     * @param type $attr_id
     * @param type $freeattributes
     * @param type $updateqty
     * @param type $errors
     * @param type $displayErrorMessage
     * @param type $additional_fields
     * @param type $usetriggers
     */
    function onBeforeAddProductToCart(Event $event){
        //&$jshopCart, &$product_id, &$quantity, &$attr_id, &$freeattributes, &$updateqty, &$errors, &$displayErrorMessage, &$additional_fields, &$usetriggers
        
//        onBeforeAddProductToCart

		
//toPrint(null,'',0,'',true);
//        $place_pushka = JFactory::getApplication()->getInput()->getBool('place_pushka',false);
		
		
             
        if($this->config->error_reporting == 'development'){
            //echo "<pre>\PlaceBilet: onBeforeAddProductToCart <br>"." </pre>";
            //JLog::add('Test message!');
        }
//        if(JDEBUG){
//    //whatever debugging code you want to run
//        }
        
//        jimport('joomla.error.log');
//        jimport('joomla.log.log');
////        $log = JLog::getInstance('view.txt','{DATE}\t \n{Name}\t \n{Count}\t \n{Object}');
//        
////        $log->addEntry(array( 'Name' => ': '.strval($ojb),'Count' => ': '.Count($ojb),'Object' => print_r($ojb,true)));
//        
////        JLog::addLogger(array('text_file' => 'view.log','text_entry_format' => '{DATETIME} {PRIORITY} {MESSAGE}'.print_r($ojb,true)), JLog::ALL);//plgJshoppingPlaceBilet
//        
//        
//        $ojb= $product_id;
//        $message = 'Name: '.strval($ojb).' \t \n Count: '.Count($ojb).' \t \n Object: \t \n '.print_r($ojb,true);
//        echo "<pre>\$ojb: $ojb <br>".print_r($ojb,true)." </pre>";
//        //class="alert alert-notice"
//        
//        //JError::raiseNotice(101, 'Name: '.strval($ojb).' \t \n Count: '.Count($ojb).' \t \n Object: \t \n ');
//
//        JLog::addLogger(array('text_file' => 'view.txt'            // (optional) you can change the directory            'text_file_path' => 'somewhere/logs'
//         ));
//
//// start logging...
//        JLog::add('Name: '); 
        //JLog::add($message); 
        
        
        
        
//        $config = array(    'text_file' => 'view.log');
//        jimport('joomla.log.logger.formattedtext');
//        $logger = new JLogLoggerFormattedtext($config);
//        $entry = new JLogEntry($comment, $status);
//        $logger->addEntry($entry);

        //JPATH_BASE
    }
     
    /**
     * уменьшение атриб
     * @param type $jshopCart
     */
    function onConstructJshoppingControllerCart(Event $event){//&$jshopCart
        define('PlaceBilet', TRUE);
        //echo "<pre>\$jshopCart:  <br>".print_r((int)PlaceBilet,true)." </pre>";
    } 
    /**
     * Админка - Уменьшение атриб
     * @param type $jshopCart
     */
    function onAfterQueryGetAttributes2(Event $event){ //&$query
		$query = &$event->getArgument(0);
        //$query = "SELECT * FROM `#__jshopping_products_attr2` WHERE product_id = '".$this->product_id."' ORDER BY id";
        if(defined('PlaceBilet'))// Сработает только при корзине
			$query = " SELECT pa2.* FROM ($query) AS pa2, #__jshopping_attr AS a " 
               . " WHERE a.attr_type!=4 AND pa2.attr_id = a.attr_id  ORDER BY pa2.id "; 
		$event->setArgument(0, $query);
        //toPrint($query);
        //toPrint(defined('PlaceBilet'),"defined('PlaceBilet')");
    }
    
    

    
//    function _onBeforeCheckFreeAttrAddProductToCart(&$jshopModelCart, &$productTable, &$freeattributes, &$allfreeattributes, &$errors, &$displayErrorMessage){
//        foreach($jshopModelCart->products as $key=> $productCart){
//            if($productCart['product_id'] == $productTable->product_id){
//                
//                $places= JshopRequest::getAttribute('jshop_place_id');
//                ksort($places);
//                $placesJson = json_encode($places); 
//                if(isset($productCart['places']) && $productCart['places'] == $placesJson)
//                    return; 
//                $jshopModelCart->products[$key]['attributes']=$placesJson;
//                
//                
////                $placesCart=  json_decode($productCart['places']);
////                                    echo "<pre>    \$product->product_id:".print_r( $product->product_id,true)              
////                    ."<br> \$productCart:  <br>".print_r( $productCart,true)  ." </pre>";
//            }
//        }
//    }


    /** Суммирование нового товара в корзине с существующими товарами
     * 
     * @param type $jshopModelCart
     * @param type $productTable
     * @param type $key
     * @param type $errors
     * @param type $displayErrorMessage
     * @param type $product_in_cart
     * @param type $quantity
     * @return type
     */
    function onBeforeSaveUpdateProductToCart(Event $event){
        //&$jshopModelCart, &$productTable, $key,           &$errors, &$displayErrorMessage, &$product_in_cart, &$quantity
		//&$jshopModelCart, &$temp_product, &$productTable, &$errors, &$displayErrorMessage
		$jshopModelCart = $event->getArgument(0);
		$productTable	= $event->getArgument(1);
		$key			= $event->getArgument(2);
		
        $productCart['quantity'] = 1;
		$event->setArgument(6, 1);
		
        $bonus = 1;
        $bonusEnabled = $this->params->bonusEnabled;
        if($bonusEnabled)
			$bonus = PlaceBiletHelper::getBonusProduct($productTable->date_event);
        
        $productCart = $jshopModelCart->products[$key];
		
        if($productCart['product_id'] != $productTable->product_id)
            return;
        
		
		$prod_attrIDs = array_map(fn($el) => $el->attr_id, $productCart['attributes_value'] ?? []);
		$prod_attrIDs = array_flip($prod_attrIDs);
		
//		$places		= JshopRequest::getAttribute('jshop_place_id');
//		$places		= JshopRequest::getAttribute('jshop_attr_id');
		$attributesIDs	= (array)PlaceBiletHelper::JInput('jshop_attr_id');
		
		$places = [];
		$places_val_attr_IDs = [];
		
		foreach ($attributesIDs as $attrID => $vals){
			if(! is_array($vals) || ! $vals || $attrID < 0){
				unset($attributesIDs[$attrID]);
				continue;
			}
		
			if(isset($prod_attrIDs[$attrID])){
				$i = $prod_attrIDs[$attrID];
				unset($productCart['attributes_value'][$i]);
			}
				
			foreach ($vals as $valID => $quantity){
				$quantity = (int)$quantity;
				if(! $quantity || $valID < 0 || $quantity < 0){
					unset($attributesIDs[$attrID][$valID]);
					continue;
				}
				
				$attributesIDs[$attrID][$valID] = $quantity;
				$places_val_attr_IDs[(int)$valID] = (int)$attrID;
//				$places[] = (object)['attrID'=>(int)$attrID, 'valID'=>(int)$valID, 'quantity'=>$quantity];
			}
		}

		if(! $places_val_attr_IDs)
			return;
		
//\Joomla\CMS\Factory::$application->enqueueMessage("<pre>plgProdUpd 1887 <b>\$places</b> ".print_r($places,true)."</pre>");
//\Joomla\CMS\Factory::$application->enqueueMessage("<pre>plgProdUpd 1888 <b>\$attribut[".print_r($key,true)."]</b> ".print_r($attribut,true)."</pre>");
		

//toPrint($attributesIDs,'$attributesIDs',0,'message',true);
		
        
if(PlaceBiletDev)
JFactory::getApplication()->enqueueMessage(  "\$places-: ".print_r($places,TRUE));

//        ksort($places);
        $placesJson = json_encode($attributesIDs); 
        if(isset($productCart->places) && $productCart->places == $placesJson)
            return; 
        
		
//        $values_ids = array_keys($places); 
        
		$place_pushka = JFactory::getApplication()->getInput()->getBool('place_pushka', false);
		
		$productTable->place_pushka = $place_pushka;
		$productCart['place_pushka'] = $place_pushka;

//toPrint($places,'',0,'',true);
//toPrint($values_ids,'$values_ids ->UpdCart()',0,'message',true); 
//toPrint($places,'$places ->UpdCart()',0,'message',true);
//toPrint($productCart,'$productCart ->UpdCart()',0,'message',true);
        
        if($places_val_attr_IDs){
			
			$lang = JSFactory::getLang()->lang;
            $query = "
SELECT   
    pa2.count, pa2.addprice, pa2.attr_id, pa2.attr_value_id, pa2.id id, pa2.OfferId, 
    pa2.id product_attr2_id,  a.cats,  /* pa2.product_id, pa2.price_mod, */
	av.`name_$lang` place_name, 
	a.attr_ordering, a.`name_$lang` attr_name, a.`description_$lang` attr_description, a.attr_type,  
	a.`group` group_id, ag.`name_$lang` group_name, ag.ordering group_order 
FROM #__jshopping_products_attr2 AS pa2, #__jshopping_attr_values av,  #__jshopping_attr a 
LEFT JOIN #__jshopping_attr_groups ag ON a.`group`=ag.id 
WHERE  pa2.attr_id = a.attr_id AND pa2.attr_value_id=av.value_id AND pa2.product_id=$productTable->product_id AND a.attr_type IN (4,5)
	AND pa2.attr_id IN (".join(',',		array_unique($places_val_attr_IDs)) .") 
	AND pa2.attr_value_id IN (".join(',', array_keys($places_val_attr_IDs)) .")
ORDER BY a.attr_ordering, ag.ordering, pa2.addprice, av.`name_$lang`; "; 

//toPrint($query,'$query ->plgProdUpdate()',0,'message',true);

		
			$places = JFactory::getDBO()->setQuery($query)->loadObjectList('product_attr2_id'); //attr_value_id
			
//toPrint($places,'$places ->plgProdUpdate()',0,'message',true);
				
//toPrint($_places,'$_places',0,'message',true);
//toPrint($places,'$places',0,'message',true);
            //$places = $db->loadObjectList('id'); 
            
			if(PlaceBiletDev)JFactory::getApplication()->enqueueMessage(  "\$places-: ".print_r($places,TRUE));        
			if(PlaceBiletDev)JFactory::getApplication()->enqueueMessage(  "\$query-: ".print_r($query,TRUE));
        
        }else{
            //JRoute::_( JSHelper::SEFLink($cart->getUrlList(),0,1) );
            $category_id = PlaceBiletHelper::JInput('category_id', 1);
            $product_id = PlaceBiletHelper::JInput('product_id', 1);
            
            JRoute::_(JSHelper::SEFLink('index.php?option=com_jshopping&controller=product&task=view&category_id='.$category_id.'&product_id='.$product_id,1,1));
            return;
        }
		
		$summ_price = FALSE;
		
        $unsearializeplace = json_decode( $productCart['places']);
		foreach ($unsearializeplace as $av_id=> $place){
			unset($productCart['attributes_value'][$av_id]);
		}
        //$productCart['attributes_value']=array_diff_key($productCart['attributes_value'],$unsearializeplace);
        
        $arr_attr_places = array();
        $price = 0;
        $roundBonusExist = (bool)$this->params->roundBonus; // Нужно ли округлять
        
//toPrint($productCart,'$productCart ->plgProdUpdate()',0,'message',true);
        foreach($places as $prod_attr2_id => $place){ // $av_id
            if($bonusEnabled)
                $place->addprice *= $bonus;   
            
//            if($roundBonusExist)// условие перенесен в Helper:RoundPrice
            $place->addprice = PlaceBiletHelper::RoundPrice($place->addprice);
            
			$quantity = $attributesIDs[$place->attr_id][$place->attr_value_id] ?? 0;
			
            //$place->addprice *=
//			if($summ_price)
			$price += $place->addprice * $quantity;
			
            //$arr_attr_places[intval($place->attr_value_id)]=  intval($place->id);
            $arr_attr_places[$prod_attr2_id] = (int)$place->product_attr2_id;
            
//$i = $place->product_attr2_id;
			$productCart['attributes_value'][$prod_attr2_id] = new stdClass();
                    
			$productCart['attributes_value'][$prod_attr2_id]->attr_id	= $place->attr_id;
			$productCart['attributes_value'][$prod_attr2_id]->value_id	= $place->attr_value_id;
                                        
			$productCart['attributes_value'][$prod_attr2_id]->attr		= $place->attr_name.' '.$place->group_name;
			$productCart['attributes_value'][$prod_attr2_id]->value		= $place->place_name;
			$productCart['attributes_value'][$prod_attr2_id]->id		= $place->id;
			$productCart['attributes_value'][$prod_attr2_id]->addprice	= $place->addprice;
			$productCart['attributes_value'][$prod_attr2_id]->count		= $quantity;
            if(isset($place->OfferId))
				$productCart['attributes_value'][$prod_attr2_id]->OfferId = $place->OfferId;
			
			if($quantity > 1)
				$productCart['attributes_value'][$prod_attr2_id]->value	.= ' - ' . $quantity . JText::_('JSHOP_PLACE_PCS');
        }
//toPrint($productCart['attributes_value'],'$productCart[attributes_value]',0,'message',true);
//toPrint($productCart,'$productCart ->plgProdUpdate()',0,'message',true);
		
		
//        if($summ_price)
            $productCart['price'] += $price;
		
        ksort($arr_attr_places);
        $placesJson = json_encode($arr_attr_places);
        $productCart['places']=$placesJson;
		
		
        
        //$productCart['product_name']= $productCart['product_name']." <span class='datetime'> ".new JDate($productTable->date_event)."</span>";
                 
        //if(PlaceBiletDev)JFactory::getApplication()->enqueueMessage(  "\$productCart: ".print_r($productCart,TRUE));
        
        
//                            echo "<BR><BR><BR><pre>\COUNT COUNT:  <br>".print_r( $arr_attr_places,true)       
//                                    ."<br> \$unsearialize:".print_r( $unsearializeplace,true)
//                    ."<br> \$productCart:".print_r( $productCart,true)." </pre><BR><BR><BR>"; 
        $jshopModelCart->products[$key] = $productCart;
		$event->setArgument(0, $jshopModelCart);
        
 // $jshopModelCart->products=array();
//
//        JFactory::getApplication()->enqueueMessage('$jshopCart debug string(s)');
//        JFactory::getApplication()->enqueueMessage('Some debug string(s)');
    }
    
    function onBeforeSaveNewProductToCart(Event $event){ //$productTable $product
		//&$jshopModelCart, &$temp_product, &$productTable, &$errors, &$displayErrorMessage
		$jshopModelCart = $event->getArgument(0);
		$temp_product	= $event->getArgument(1);
		$productTable	= $event->getArgument(2);
		
		
		
        //$temp_product
		$bonus = 1;  
		$bonusEnabled = $this->params->bonusEnabled; 
		if($bonusEnabled)
			$bonus = PlaceBiletHelper::getBonusProduct($productTable->date_event);
        
//		$places = JshopRequest::getAttribute('jshop_place_id');
//		$places = PlaceBiletHelper::JInput('jshop_attr_id');
//		$places = array_filter($places);
		
		$attributesIDs	= (array)PlaceBiletHelper::JInput('jshop_attr_id');
//		$attribut	= JFactory::getApplication()->input->getVar($key);
		
		$prod_attrIDs = array_map(fn($el) => $el->attr_id, $temp_product['attributes_value'] ?? []);
		$prod_attrIDs = array_flip($prod_attrIDs);
		
		$places = [];
		$places_val_attr_IDs = [];
		
		foreach ($attributesIDs as $attrID => $vals){
			if(! is_array($vals) || ! $vals || $attrID < 0){
				unset($attributesIDs[$attrID]);
				continue;
			}
			
			if(isset($prod_attrIDs[$attrID])){
				$i = $prod_attrIDs[$attrID];
				unset($temp_product['attributes_value'][$i]);
			}
				
			foreach ($vals as $valID => $quantity){
				$quantity = (int)$quantity;
				if(! $quantity || $valID < 0 || $quantity < 0){
					unset($attributesIDs[$attrID][$valID]);
					continue;
				}
				
				$attributesIDs[$attrID][$valID] = $quantity;
				$places_val_attr_IDs[(int)$valID] = (int)$attrID;
//				$places[] = (object)['attrID'=>(int)$attrID, 'valID'=>(int)$valID, 'quantity'=>$quantity];
			}
		}
		
		
		
//\Joomla\CMS\Factory::$application->enqueueMessage("<pre>plgProdNew 2073 <b>\$places</b> ".print_r($attributesIDs,true)."</pre>");
//\Joomla\CMS\Factory::$application->enqueueMessage("<pre>plg 1888 <b>\$attribut</b> ".print_r($attribut,true)."</pre>");
		
//toPrint($places,'$places ->NewCart()',0,'message',true);
        
        if(PlaceBiletDev)JFactory::getApplication()->enqueueMessage(  "\$places: ".print_r($places,TRUE));
        
//        $placesSerialize = json_encode($places); 
        if(! $attributesIDs){
			
            $category_id = PlaceBiletHelper::JInput('category_id', 1);
            $product_id = PlaceBiletHelper::JInput('product_id', 1);
            JRoute::_(JSHelper::SEFLink('index.php?option=com_jshopping&controller=product&task=view&category_id='.$category_id.'&product_id='.$product_id,1,1));
            return;
        }
		
        $temp_product['quantity']=1;
		
		$place_pushka = JFactory::getApplication()->getInput()->getBool('place_pushka', false);
		
		$productTable->place_pushka = $place_pushka;
		$temp_product['place_pushka'] = $place_pushka;
		
//toPrint($places,'$places ->NewCart()',0,'message',true);
//toPrint($temp_product,'$temp_productNEW ->NewCart()',0,'message',true);
        
        
		
//        $values_ids = array_keys($places);
//        $prod_value_price_ids = array_values ($places);
//        $prod_value_price_ids = array_keys ($places);

        
        if($places_val_attr_IDs){
			
			$lang = JSFactory::getLang()->lang;
			
            $query = "
SELECT        
	pa2.id id, pa2.attr_id,pa2.attr_value_id, pa2.price_mod,  pa2.count, pa2.addprice, pa2.OfferId,
	pa2.id product_attr2_id,      a.cats,  	/* pa2.*, pa2.product_id,  */
 av.`name_$lang` place_name, 
 a.attr_ordering, a.`name_$lang` attr_name, a.`description_$lang` attr_description, a.attr_type,  
 a.`group` group_id, ag.`name_$lang` group_name, ag.ordering group_order 
FROM #__jshopping_products_attr2 AS pa2, #__jshopping_attr_values av,  #__jshopping_attr a 
LEFT JOIN #__jshopping_attr_groups ag ON a.`group`=ag.id 
WHERE  pa2.attr_id = a.attr_id AND pa2.attr_value_id=av.value_id AND pa2.product_id=" . ((int)$temp_product['product_id']) . " AND a.attr_type IN (4,5)
	AND pa2.attr_id IN (".join(',',     array_unique($places_val_attr_IDs)) .") 
	AND pa2.attr_value_id IN (".join(',', array_keys($places_val_attr_IDs)) .")
ORDER BY a.attr_ordering, ag.ordering, pa2.addprice, av.`name_$lang`; ";
        
//if(PlaceBiletDev)JFactory::getApplication()->enqueueMessage(  "\$places: ".print_r($query,TRUE));   
 
//toPrint($query,'$query ->plgProdNew()',0,'message',true);
            //$places = $db->loadObjectList('id');
            $places = JFactory::getDBO()->setQuery($query)->loadObjectList('product_attr2_id');// attr_value_id
			
//			foreach($places as $prod_attr2_id => $count)
//				$places[$prod_attr2_id]->count = $_places[$prod_attr2_id] ?? 0;
			
            unset($query);
        }else{
            //JRoute::_( JSHelper::SEFLink($cart->getUrlList(),0,1) );
            $category_id = PlaceBiletHelper::JInput('category_id', 1);
            $product_id = PlaceBiletHelper::JInput('product_id', 1);
            JRoute::_(JSHelper::SEFLink('index.php?option=com_jshopping&controller=product&task=view&category_id='.$category_id.'&product_id='.$product_id,1,1));
        }
//\Joomla\CMS\Factory::$application->enqueueMessage("<pre>plgProdNew 2139 <b>\$places</b> ".print_r($places,true)."</pre>");
                   
// if(PlaceBiletDev)JFactory::getApplication()->enqueueMessage(  "\$placesDB: ".print_r($places,TRUE));                    
        $arr_attr_places = array();
        
        $summ_price = FALSE;
        $temp_product['price_places'] = 0;
        $price = 0;
        $roundBonusExist = (bool)$this->params->roundBonus; // Нужно ли округлять
        
//toPrint($temp_product,'$temp_product ->plgProdUpdate()',0,'message',true);
        foreach($places as $prod_attr2_id => $place){
			
            if($bonusEnabled)
                $place->addprice *= $bonus;
            
            if($roundBonusExist)
                $place->addprice = PlaceBiletHelper::RoundPrice($place->addprice);
				
			$quantity = abs((int)$attributesIDs[$place->attr_id][$place->attr_value_id] ?? 0);
			
			if($quantity == 0){
				
			}
				
				
//			if($summ_price)
			$price += $place->addprice * $quantity;
//			$arr_attr_places[intval($place->attr_value_id)]=  intval($place->id);
			$arr_attr_places[$prod_attr2_id] = (int)$place->product_attr2_id;
            
                    //$i = $place->product_attr2_id; 
			$temp_product['attributes_value'][$prod_attr2_id] = new stdClass();
			$temp_product['attributes_value'][$prod_attr2_id]->attr_id	= $place->attr_id;
			$temp_product['attributes_value'][$prod_attr2_id]->value_id	= $place->attr_value_id;
			$temp_product['attributes_value'][$prod_attr2_id]->attr		= $place->attr_name . ' ' . $place->group_name;
			$temp_product['attributes_value'][$prod_attr2_id]->value	= $place->place_name;
			$temp_product['attributes_value'][$prod_attr2_id]->id		= $place->id;
			$temp_product['attributes_value'][$prod_attr2_id]->addprice	= $place->addprice;
			$temp_product['attributes_value'][$prod_attr2_id]->count	= $quantity;
                    
			if(isset($place->OfferId))
				$temp_product['attributes_value'][$prod_attr2_id]->OfferId = $place->OfferId;
					
			if($quantity > 1)
				$temp_product['attributes_value'][$prod_attr2_id]->value .= ' - ' . $quantity . JText::_('JSHOP_PLACE_PCS'); 
        }
//toPrint($temp_product,'$temp_product ->plgProdUpdate()',0,'message',true);
        //if($summ_price)
        //    $temp_product['price'] += $price;
        //$temp_product['price'] = $price;
        
        $temp_product['date_event']		= $productTable->date_event;
        $temp_product['date_tickets']	= $productTable->date_tickets;
        $temp_product['event_id']		= $productTable->event_id;
        //Y-M-D G:i    j       F      H:i      D
        //$date_event = ((new JDate($temp_product['date_event']))->format('d-M H:i'));
        //$date_event = (date( 'd-M H:i', $temp_product['date_event']));
        //$date_event = ($temp_product['date_event']);//2016-03-31 19:00:00
        $date_event = JFactory::getDate($temp_product['date_event'])->format('d-M H:i');
        $temp_product['product_name'] .= " <span class='datetime'> $date_event</span>"; //<span class='datetime'> $date_event</span>
		
        if($bonusEnabled)
			$temp_product['product_name'] .=  $bonus===1 ? " " : " <span class='bonus'> ". JText::_('BONUS') ."</span>";
        
//        if(PlaceBiletDev)JFactory::getApplication()->enqueueMessage(  "\$productCart: ".print_r($temp_product,TRUE));
        
        $temp_product['price_places'] = $price;
        ksort($arr_attr_places);
        $placesJson = json_encode($arr_attr_places);//serialize()
        $temp_product['places'] = $placesJson;
		
		
        $event->setArgument(0, $jshopModelCart);
        $event->setArgument(1, $temp_product);
		
                
    }
    
    /** 
     * Метод указания полей которые нужно копировать из юзера в ордер.
     * @param type $fieldsUserList
     */
    function  onBeforeGetListFieldCopyUserToOrder(Event $event){//$fieldsUserList
        $fieldsUserList = $event->getArgument(0);
    //toPrint($fieldsUserList);
    //toLog($fieldsUserList);
        
        foreach($this->fields as $field => $attrib){
            $fieldsUserList[] = $field;
        }
    }


    /**
     * Корзина, инициализация модели корзины в контролере корзины перед загрузкой сессии
     * @param type $jshopCart 
     */
    function onBeforeCartLoad(Event $event){ //&$modelCart
        
    }
    /**
     * Корзина, инициализация модели корзины в контролере корзины После загрузкой сессии 
     * @param type $jshopCart
     */
    function onAfterCartLoad(Event $event){//&$jshopModelCart
//                    echo "<pre>\$jshopModelCart:  <br>".print_r( count($jshopModelCart->products),true)
//                    ."<br> \$jshopModelCart:".print_r( $jshopModelCart->products,true)." </pre>";  
        
    }
    
    
    /**
     * 
     * @param JViewLegacy $viewCart
     */
    function onBeforeDisplayCheckoutCartView(Event $event){//&$viewCart
		$viewCart = $event->getArgument(0);
          
        $viewCart->addTemplatePath(PlaceBiletPath.'/templates/cart');//Новый шаблон
        //$viewCart->set('User',$this->usershop);
        //return;
        
//        toPrint(5555555);
        
        $products = $viewCart->products;
        $summ = 0;
        
        foreach ($products as $key => $product){
            //$pdoduct['price'] 
            //$viewCart->products[$key]['price'] = 0;
            //$product['price'] = 0;
            $viewCart->products[$key]['price_places'] = 0;
            //$viewCart->products[$key]['price_places_not_bonus'] = 0;
            
//toPrint($viewCart->products[$key]['price_places_not_bonus']);
//toPrint($product['attributes_value'],'$product[attributes_value]',0,'message');
            
            foreach ($product['attributes_value'] as $prod_attr_value){
                if(isset($prod_attr_value->addprice) && $prod_attr_value->addprice && $prod_attr_value->count){
                    //$product['price'] += $prod_attr_value->addprice;
                    $viewCart->products[$key]['price'] += $prod_attr_value->addprice * $prod_attr_value->count;
                    $summ += $prod_attr_value->addprice;
                    $viewCart->products[$key]['price_places'] += $prod_attr_value->addprice * $prod_attr_value->count;
                    //toPrint($viewCart->products[$key],'$viewCart->products[$key]');
                    //$viewCart->products[$key]['price_places_not_bonus'] += PlaceBiletHelper::getBonusProduct($viewCart->products[$key]['date_event'])*$prod_attr_value->addprice;
                    //var_dump($viewCart->products[$key]['price']);
                }
            }
        }
        //$viewCart->products = $products;
//        $viewCart->summ += $summ;
//        $viewCart->fullsumm += $summ;
        
        if(isset($prod_attr_value->summ_payment))
            $viewCart->summ_payment += $summ;
        if(isset($prod_attr_value->shipping_price))
            $viewCart->shipping_price += $summ;
        if(isset($prod_attr_value->summ_package))
            $viewCart->summ_package += $summ;
        
        
    }
    
	
    function onAfterLoadPriceAndCountProducts(Event $event){//&$modelCart 
        $modelCart = $event->getArgument(0);
		
		
		
		$jshopConfig = JSFactory::getConfig();
		$modelCart->price_product = 0;
		$modelCart->price_product_brutto = 0;
		$modelCart->count_product = 0;
		$modelCart->count_places = 0;
		
//toPrint();
//toPrint($modelCart->products,'$modelCart->products',0,'message');
        
		$new_prods= array();
        
		if ($modelCart->products){
            
			foreach ($modelCart->products as $prod){  
				$prod['quantity']=1;
				$new_prods[$prod['product_id']] = $prod;
			}
			$modelCart->products = $new_prods;   
			
			foreach($modelCart->products as $key => $prod){
                
                $modelCart->products[$key]['count_places'] = 0;
//                $modelCart->products[$key]['AbraCadabra'] = $place_pushka;
                //$modelCart->products[$key]['price'] = 0;
                $prod_price = $prod['price'] ?? 0; // 0 ;
                $prod_price_places = 0;
                    //$modelCart->count_places += count($prod['attributes_value']);

//toPrint($prod['attributes_value'],'$prod[attributes_value]',0,'message');
                
                foreach ($prod['attributes_value'] ?? [] as $prod_attr_value){
                    if(isset($prod_attr_value->addprice)){
                        //$product['price'] += $prod_attr_value->addprice;
                        //$modelCart->products[$key]['price'] += $prod_attr_value->addprice;
                        $prod_price_places += $prod_attr_value->addprice * $prod_attr_value->count;
                        $modelCart->products[$key]['count_places'] += $prod_attr_value->count;
//                        $prod_attr_value->value .= ' - ' . $prod_attr_value->count . JText::_('JSHOP_PLACE_PCS');
                        //$modelCart->price_product += $prod_attr_value->addprice;
                        //var_dump($viewCart->products[$key]['price']);
                        //$prod['price_places']+=$price;
                    }
                }
                $modelCart->count_places += $modelCart->products[$key]['count_places'];
                
                $prod['price_places'] = $prod_price_places;
                $modelCart->products[$key]['price_places'] = $prod_price_places;
                //$modelCart->products[$key]['product_name'] .= " ". $prod['count_places'];
                //---------------------
                
                $modelCart->price_product += $prod['price'] + $prod_price_places;// * $prod['quantity'];
                if ($jshopConfig->display_price_front_current == 1){
                    $modelCart->price_product_brutto += (($prod_price + $prod_price_places) * (1 + $prod['tax'] / 100));// * $prod['quantity'];
                }else{
                    $modelCart->price_product_brutto += $prod_price + $prod_price_places;// * $prod['quantity'];
                }
                $modelCart->count_product += 1;//$prod['quantity'];
                
                //$prod['price'] +=$prod_price_places;
                //$modelCart->products[$key]['price'] += $prod_price_places;
            }
        }
    }


    public $usershop;
	
    function onAfterGetUserShopJSFactory(Event $event){// &$usershop
		$usershop = $event->getArgument(0);
		
        if(!is_object($this->usershop))
            $this->usershop = $usershop;
    }
    /**
     * 
     * @param JViewLegacy $viewCart
     */
    function onBeforeDisplayCartView(Event $event){// &$viewCart
        
		$viewCart = $event->getArgument(0);
		
		
		$viewCart->_tmp_ext_html_cart_start = "<h1>" . JText::_('COM_JSHOPPING_CART_VIEW_DEFAULT_TITLE') . "</h1>" . $viewCart->_tmp_ext_html_cart_start ;
		
		$viewCart->get('config')->show_cart_clear = false;
		
		foreach ($viewCart->get('products') as $key_id => &$prod){
//			$prod->
		}
		
		$wa = JFactory::getApplication()->getDocument()->getWebAssetManager();
		$wa->getAsset('style', 'fontawesome')->setAttribute('rel', 'lazy-stylesheet');
		
        $products = & $viewCart->products;
        $bonusEnabled = $this->params->bonusEnabled; 
        
        foreach ($products as &$prod){
			
            $prod['price_places_not_bonus'] = $prod['price_places'];
			
			
			if($bonusEnabled){
                $prod['price_places_not_bonus'] = $prod['price_places'] / PlaceBiletHelper::getBonusProduct($prod['date_event']) ;
				
                if($prod['price_places_not_bonus'] ?? false)
                    $prod['_ext_price_total_html'] .= JText::sprintf('COST_NOT_BONUS',$prod['price_places_not_bonus']); 
                                    //toPrint($prod['price_places'],'$prod[\'price_places\']');
                
                $prod['_ext_price_total_html'] .= JText::sprintf('COST_BONUS',JSHelper::formatprice($prod['price'] * $prod['quantity'] + $prod['price_places']));               
			}
			
			$prod['price'] = $prod['price'] + $prod['price_places'];
			
//			$prod['_ext_price_total_html'] = 
        }
            
//        toPrint($viewCart->products,'$viewCart');
        //$prods
        $viewCart->bonusEnabled= $bonusEnabled = $this->params->bonusEnabled; 
        
		$viewCart->set('param',$this->params);
        $viewCart->addTemplatePath(PlaceBiletPath.'/templates/cart');//Новый шаблон
//        $viewCart->addTemplatePath(PlaceBiletPath.'/templates/checkout');//Новый шаблон
        
        //$viewCart->addTemplatePath(PlaceBiletPath.'/templates/cart');//Новый шаблон
        $viewCart->addTemplatePath(JPATH_BASE."/templates/$this->template_name/html/com_jshopping/cart/"); //Новый шаблон   
//        $viewCart->addTemplatePath(JPATH_BASE."/templates/$this->template_name/html/com_jshopping/checkout/"); //Новый шаблон   
        //
        //$viewCart->set('User',$this->usershop);
//toPrint(555555555);
    }
	
    /**
     * Сайт - Страница ввода Адреса Address
     * @param JViewLegacy $viewCheckOut2
     */
    function onBeforeDisplayCheckoutStep2View(Event $event){ // &$viewCheckOut2
		
		$viewCheckOut2 = $event->getArgument(0);
		
		
		
		
		
		$viewCheckOut2->checkout_navigator = "<h2>" . JText::_('JSHOP_ADDRESS' ) . "</h2>" . $viewCheckOut2->checkout_navigator;
		
        $viewCheckOut2->addTemplatePath(PlaceBiletPath.'/templates/checkout');//Новый шаблон
        $viewCheckOut2->addTemplatePath(JPATH_BASE."/templates/$this->template_name/html/com_jshopping/cart/"); //Новый шаблон
        //$viewCheckOut5->set('User',$this->usershop);
        
		$viewCheckOut2->set('param',$this->params);
        
        foreach ($this->fields as $field=> $attrib){
            $viewCheckOut2->config_fields[$field] = $attrib;
        }
        
//        toLog($viewCheckOut2->config_fields);
    }
            
    function onBeforeDisplayCheckoutStep5(Event $event){//&$sh_method, &$pm_method, &$delivery_info, &$cartModel, &$viewCheckOut5
//		$sh_method		= $event->getArgument(0);
//		$pm_method		= $event->getArgument(1);
//		$delivery_info	= $event->getArgument(2);
//		$cartModel		= $event->getArgument(3);
		$viewCheckOut5	= $event->getArgument(4);
		
        $viewCheckOut5->addTemplatePath(PlaceBiletPath.'/templates/checkout');//Новый шаблон
        $viewCheckOut5->addTemplatePath(JPATH_BASE."/templates/$this->template_name/html/com_jshopping/cart/"); //Новый шаблон   
        $viewCheckOut5->set('user',$this->usershop);
		$viewCheckOut5->set('param',$this->params);
		
		
		
        $adv_user = \JSFactory::getUser();
		
		
		$viewCheckOut5->set('adv_user',$adv_user);
//        $info['f_name'] = $adv_user->f_name;
        
                
        foreach ($this->fields as $field=> $attrib){
            $viewCheckOut5->config_fields[$field] = $attrib;
        }
        //$viewCheckOut5->addHelperPath(PlaceBiletPath.'/templates/checkout');
//       $existHelper=  $viewCheckOut5->loadHelper('Helper');// ищит файлHelper.php
//        $paths = $viewCheckOut5->get('_path');
//        
//        
//                    echo "<pre>Count \$paths:  ".$helper
//                    ."<br> \helper:".print_r( $paths,true)." <br></pre>";  
    }
    
    /**
     * 
     * @param JViewLegacy $viewCart
     */
    function onBeforeDisplayCheckoutStep5View(Event $event){//&$viewCart
		$viewCart = $event->getArgument(0);
        $viewCart->checkout_navigator = "<h2>" . JText::_('JSHOP_ORDER_SUBMIT' ) . "</h2>" . $viewCart->checkout_navigator;
    }
    
	//ProductTable->getAttributesDatas() 
	// onJoomlaComponentJshoppingSiteTableProductTableGetAttributesDatasAfter
    function onJshopProductGetAttributesDatasAfter(Event $event){//&$Attributes
//selected
//app
//obj
//JshopConfig
//data
//attr_list
//allAttribute
//requireAttribute
//actived
//attr_id
//options
        //toPrint($Attributes,'$Attributes');
    }
	
    /**
     * Происходит при подтеврждении заказа (условия) после всех этапов оформления товаров - После Покупка
     * Офомрление резервации товаров в ЗРИТЕЛИ
     * @param type $order
     * @param type $cart
     */
    function onEndCheckoutStep5(Event $event){//&$order, &$cart
		$order	= $event->getArgument(0);
		$cart	= $event->getArgument(1);
		
//        toPrint($order,'$order');
//        toPrint($cart,'$cart');
        //return;    
        $products = $cart->products;
        $values_db = [];
        $values = [];
        $Offers = [];
        
        foreach ($products as $prod){//            $prod->SeatList = [];
            $values += $prod ['attributes_value']; 
            
            foreach ($prod ['attributes_value'] as $k => $v)
                $Offers[$v->OfferId][ $v->value_id]=$v->value;
        }
                
        $Offers_count = count($Offers); 
//        toLog($msg, "~Заказов $Offers_count", 'day'); 
        
        
        if($this->params->Zriteli_enabled){
			foreach ($Offers as $OfferId => $SeatList){
                //Сделать заказ билетов в предложении 
                SoapClientZriteli::CallMod_MakeOrder($OfferId, $SeatList);
            }
		}
//            PlaceBiletHelper::$template_name = $this->template_name;
//            toLog($this->template_name,'~$this->template_name','day');
//            toLog(PlaceBiletHelper::$template_name,'~PlaceBiletHelper::$template_name','day');
                        try {
//            toLog('','~Mailing 0','day');
        $status = PlaceBiletHelper::Mailing(['Offers'=>$Offers,'order'=>$order,'cart'=>$cart], 'order');

        } catch (Exception $exc) {
            $msg = '';
            $msg .= $exc->getTraceAsString();
            $msg .= $exc->getMessage();

        } 
    }
	
//    function onBeforeCreateOrder(&$order, &$cart, &$checkout){
//        oi.product_item_price  146
//        o.order_total 466
//        o.order_subtotal 466
//    }
	
	/**
	 * Клиент: Происходит при смене статуса заказа при оформлении заказа на клиенте 
	 * @param type $order_id
	 * @param type $status
	 * @param type $sendmessage
	 * @param type $comments
	 */
	function onBeforeChangeOrderStatus(Event $event ){ // &$order_id = 0, &$status = null, &$sendmessage = '', &$comments = null
		$order_id		= $event->getArgument(0,0);
		$status			= $event->getArgument(1,null);
		$sendmessage	= $event->getArgument(2,'');
		$comments		= $event->getArgument(3,null);
		
		if(empty($order_id) || empty($status))
			return;
		
		$r = PlaceBiletHelper::deletePlaces($order_id, $status);
//		toPrint($status,'$status '.($r?'True':'False'),0,'pre',true);
//		toLog($status, '$status '.($r?'True':'False'), 'finish.txt','',true);
//		$filename = $this->pluginPath.'/finish.txt';
		
//		file_put_contents($filename, "\n\nonBeforeChangeOrderStatus()2850 "."\n\n", FILE_APPEND);
//		
//		$t = print_r($order_id,true);
//		file_put_contents($filename, '$order_id: '.$t."\n\n", FILE_APPEND);
//		
//		$t = print_r($status,true);
//		file_put_contents($filename, '$status: '.$t."\n\n", FILE_APPEND);
//		
//		$t = print_r($sendmessage,true);
//		file_put_contents($filename, '$sendmessage: '.$t."\n\n", FILE_APPEND);
//		
//		$t = print_r($comments,true);
//		file_put_contents($filename, '$comments: '.$t."\n\n", FILE_APPEND);
	}

	/*
	 * Клиент: Выполняется перед сохранением Ордера при покупке товара
	 */
	function onAfterCreateOrder(Event $event){//&$order, &$cart
		$order	= $event->getArgument(0);
		$cart	= $event->getArgument(1);
		 
		 
		$order->f_name .= ' ' . $order->phone;
		$order->f_name .= ' ' . $order->mobile_phone;
		$order->l_name .= ' ' . $order->d_FIO ?: $order->FIO;
		
	}
	
	/**
	 * Клиент: Вызывается при первом сохранении заказа.
	 * @param Event $tableOrder
	 */
	function onBeforeStoreTableOrder(Event $event){//&$orderTable
		
		$orderTable		= $event->getArgument(0, '');
		
		
		
//toPrint($orderTable->FIO,'$orderTable->FIO ',0,'message',true);
		if(empty($orderTable->order_id) || empty($orderTable->order_status))
			return;
		
		$r = PlaceBiletHelper::deletePlaces($orderTable->order_id,$orderTable->order_status); 
//		toPrint($orderTable->order_status,'$orderTable->order_status '.($r?'True':'False'),0,'pre',true);
//		toLog($orderTable, '$orderTable '.($r?'True':'False'), 'finish.txt','',true);
	}
	
	
	/**
	 * Клиент: При покупе товара
	 *  - Указать поля которые будут сохранены в таблицу заказа продукта в БД
	 * Выполняется после onAfterCreateOrder
	 */
    function onBeforeSaveOrderItem (Event $event){//&$order_itemTable, &$productItemOrderSession = []	//$productItemOrderSession 
		$order_itemTable			= $event->getArgument(0);
		$productItemOrderSession	= $event->getArgument(1, []);
		
		
		$productItemOrderSession['price'] += $productItemOrderSession['price_places'];
		$order_itemTable->product_item_price+= $productItemOrderSession['price_places'];
		$order_itemTable->date_event	= $productItemOrderSession['date_event'];
		$order_itemTable->date_tickets	= $productItemOrderSession['date_tickets'];
		$order_itemTable->event_id		= $productItemOrderSession['event_id'];
		$order_itemTable->count_places	= $productItemOrderSession['count_places'];
            
		$places			= array();
		$place_prices	= array();
		$place_counts	= array();
		$place_names	= array();
		
		$summ = 0;
		
		
//toPrint($order_itemTable,'$order_itemTable '.($r?'True':'False'),0,'pre',true); 
//toLog(array_keys((array)$order_itemTable), get_class($order_itemTable). ' '.($r?'True':'False'), 'finish.txt','',true);
//toLog(array_keys((array)$productItemOrderSession), ' '.($r?'True':'False'), 'finish.txt','',true);
//toPrint($productItemOrderSession['attributes_value'],'$productItemOrderSession[attributes_value]',0,'message');
		
        foreach ($productItemOrderSession['attributes_value'] as $prod_attr_value){ 
			if(isset($prod_attr_value->addprice) && $prod_attr_value->addprice && $prod_attr_value->count){

//toPrint($prod_attr_value,'$prod_attr_value ->plgOrderItem()',0,'message',true);
				$places			[$prod_attr_value->id]	= $prod_attr_value->value_id . ',' . $prod_attr_value->attr_id;
                $place_prices	[$prod_attr_value->id]	= $prod_attr_value->addprice; // !
				$place_counts	[$prod_attr_value->id]	= $prod_attr_value->count; // !
                $place_names	[$prod_attr_value->id]	= $prod_attr_value->attr.' - '.$prod_attr_value->value;
//				if($prod_attr_value->count > 1)
//					$place_names[$prod_attr_value->id]	.= ' ' . $prod_attr_value->count . JText::_('JSHOP_PLACE_PCS');
                //$product['price'] += $prod_attr_value->addprice;
                //$viewCart->products[$key]['price'] += $prod_attr_value->addprice;
                $summ += $prod_attr_value->addprice;
//                 $viewCart->products[$key]['price_places'] += $prod_attr_value->addprice;
                $productItemOrderSession['price_places'] += $prod_attr_value->addprice * $prod_attr_value->count;
				$productItemOrderSession['price'] += $prod_attr_value->addprice * $prod_attr_value->count;
		
                //var_dump($viewCart->products[$key]['price']);
            }
        }
            
		$order_itemTable->places		= json_encode($places);		 // array( ProdValID => "value_id,attr_id", ...)
		$order_itemTable->place_prices	= json_encode($place_prices);// array( ProdValID =>	price, ...)
		$order_itemTable->place_counts	= json_encode($place_counts);// array( ProdValID =>	count, ...)
		$order_itemTable->place_names	= \serialize($place_names);	//	array( ProdValID => attr_Name . ' - ' . place_name,... )
        
		$order_itemTable->product_attributes .= " <a href='https://orelmusizo.ru/bilety/punkty/product/view/1/1'><b>Виртуальная выставка Go`у!</b></a> ";
		
		if(empty($order_itemTable->order_id) || empty($order_itemTable->order_status))
			return;
		
		PlaceBiletHelper::deletePlaces($order_itemTable->order_id,$order_itemTable->order_status); 
		
		
//		toPrint($places,'$places',0,'pre',true); 
//		toPrint($place_prices,'$place_prices',0,'pre',true); 
//		toPrint($place_names,'$place_names',0,'pre',true); 
//		
//		
//		toLog($places, '$places', 'finish.txt','',true);
//		toLog($place_prices, '$place_prices', 'finish.txt','',true);
//		toLog($place_names, '$place_names', 'finish.txt','',true);
             
		
//                $file=JPATH_BASE."/log.txt";$fl = fopen($file, "w"); fclose($fl); 
//        $config= new JConfig();
//        if($config->error_reporting == 'development'){
////            JLog::add('Test message!', JLog::ALERT, 'PlaceBilet');
////            JLog::add(JText::_('JTEXT_ERROR_MESSAGE'), JLog::WARNING);
//            JLog::add('createOrder START'); 
//            JLog::add(''); 
////            JLog::add('\$adv_user:'); 
////            JLog::add(print_r($adv_user,true));
////            JLog::add('');
////            JLog::add('\$order_itemTable:'); 
////            JLog::add(print_r($order_itemTable,true));
//            JLog::add(''); 
//            JLog::add('\$productItemOrderSession:'); 
//            JLog::add(print_r($productItemOrderSession,true));
//            JLog::add(''); 
//            JLog::add('createOrder END'); 
//        }   
    }
            
	
	/**
	 * Клиент:  После сохранения Ордера после сохранения ->onBeforeSaveOrderItem()
	 * @param type $orderTable
	 * @param type $cartModel
	 */
	function onAfterCreateOrderFull(Event $event){// &$orderTable=null, &$cartModel=null
        $orderTable = $event->getArgument(0);
		$cartModel	= $event->getArgument(1);
		
		
		
//		$orderTable->f_name .= ' ' . $orderTable->phone;
//		$orderTable->f_name .= ' ' . $orderTable->mobile_phone;
//		$orderTable->l_name .= ' ' . $orderTable->d_FIO ?: $orderTable->FIO;
		
		
		$place_go = '';
		$i = 0;
		
		$timezone = PlacebiletHelper::getTimezone();
		$unix_timestamp = JDate::getInstance('now',$timezone)->getTimestamp();
		
		
//		$order_itemTable->place_go		= $place_go; // Default Status tickets   
//		$place_go += ',' . $i++ . ':' . '' . ':' . $unix_timestamp;// Index:Status:Time
		
//            $orderTable->places	   ;	// array( value_id  => attr_id,...)	//JSON
//            $orderTable->place_prices;	// array( ProdValID =>	price,...)	//JSON
//            $orderTable->place_names ;	// array( value_id => attr_Name . ' - ' . place_name,... )//serializeArray
//            $orderTable->place_go	   ;	// Index:StatusCode:TimeUnix,...   //CSV	123:P:1676813832,... 
		
//			PlaceBiletHelper::$param;
		
		$idProds = array_column($cartModel->products, 'product_id');
			
		$query = "
SELECT i.product_id, i.order_item_id 
FROM #__jshopping_order_item i
WHERE i.product_id IN (" . implode(',', $idProds) . ") AND i.order_id = $orderTable->order_id ;
		";
		if (count($idProds))
			$idProds = JFactory::getDBO()->setQuery($query)->loadAssocList('product_id', 'order_item_id');
			
		
//toPrint(null,'',0,false,false);
		/** Определение QRcode для места */
		foreach ($cartModel->products as $prod_i => $prod){
				
			if (empty($prod['attributes_value'])){
				continue;
			}
			
			/** ID подзаказа для продукта */
			$order_item_id = $idProds[$prod['product_id']] ?? 0;
				
//toPrint($prod['attributes_value'],'$prod[attributes_value]',0,'message',true);
			/** Определение количества разрядов индекса */
//			$index_length = strlen(($prod['count_places'] - 1));
			$index = 0;
				
			foreach($prod['attributes_value'] as $av_id => $attr){
				
//				$index_string = str_pad($index, $index_length, "0", STR_PAD_LEFT);
				
//toPrint($av_id,'$index',0,'message',true);
//toPrint($prod['count_places'],'$prod[count_places]',0,'message',true);
				$QRcode = PlaceBiletHelper::getQRcode($order_item_id, $index++, $prod['count_places']);
				
//toPrint($QRcode,'$QRcode',0,'message',true);
				/** QR код билета */
				$cartModel->products[$prod_i]['attributes_value'][$av_id]->QRcode = $QRcode;
			}
		}
		
//toPrint(null,'',0,false,false);
//toPrint($this->params,'$Plugin->param:',0,'message',true);
//return;
		
		$idKeysPuska = []; // $idKeysPuska[orderItemID][index] = key

		$pushka = PlaceBiletHelper::getPushka();
//toPrint($pushka,'$pushka:',0,'message',true);
			
		if($pushka && $this->params->organization_id ?? false){
			$phone = $orderTable->d_mobil_phone ?: $orderTable->d_phone ?: $orderTable->mobil_phone ?: $orderTable->phone;
			$phone = str_replace(['-','(',')',' ','#','.',',','tel','t','тел','т'], '', trim($phone));
			$phone = substr($phone, strlen($phone) - 10);
		
			$name_FIO = $orderTable->d_FIO ?: $orderTable->FIO;
			$name_F = $orderTable->d_f_name ?: $orderTable->f_name;
			$name_L = $orderTable->d_l_name ?: $orderTable->l_name;
			$name_M = $orderTable->d_m_name ?: $orderTable->m_name;
			
//toPrint($pushka,'$pushka',0,'message',true);
//toPrint($this->params->organization_id,'$organization_id',0,'message',true);
				
//toPrint($cartModel->products,'$prods Item:',0,'message',true);
			
			/** Публикация билета Пушка в системе ПроКультураРФ  */
			foreach ($cartModel->products as $prod_i => $prod){
//toPrint($prod['event_id'],'$event_id',0,'message',true);
				if(empty($prod['event_id']) || empty($prod['attributes_value'])){
					continue;
				}
//toPrint($prod_i,'$prod_i',0,'message',true);
				$order_item_id = $idProds[$prod['product_id']] ?? 0;
				$prod['order_item_id'] = $order_item_id;
				
//continue;
//toPrint(count($prod['attributes_value']),'count(attributes_value)',0,'message',true);
				foreach($prod['attributes_value'] as $av_id => $attr){
//					$attributes_value .= $attr->attr.': '.$attr->value."\n";	$attributes_value .= $attr->attr.': '.$attr->value."\n";

//toPrint(null,'',0,''); //2023-01-01 12:00:00
//toPrint($prod['date_tickets'],  ':('.  ''
//		. ' 1:' .empty($prod['date_tickets'])
//		. ' 2:' .$prod['date_tickets'] == '0000-00-00 00:00:00'
//		.  ' -'. $prod['product_id'],true, 'message',true );// 2023-04-24 01:00:00  // 0000-00-00 00:00:00

					$dataPushka = \API\Kultura\Pushka\Ticket::new();

					// Публикация Билета */
					$dataPushka->buyer_mobile_phone		= $phone;//'9004881200'; // *Мобильный телефон (10 цифр)

					$dataPushka->payment_ticket_price	= (int)$attr->addprice; //'30';		// *Цена билета (номинал)
					$dataPushka->payment_amount			= (int)$attr->addprice; //30; // *Сумма платежа по Пушкинской карте
					$dataPushka->payment_date			= $unix_timestamp; //time();//0;//time();		// *Дата/время совершения платежа (unix timestamp
					
					$dataPushka->session_event_id		= $prod['event_id']; //1299361; //*ID мероприятия в PRO.Культура   1299361	1243159		1241531
					$dataPushka->session_organization_id= $this->params->organization_id; //666666; //*ID организации в Про.Культура
					$dataPushka->session_date			= 
							(empty($prod['date_tickets']) || $prod['date_tickets'] == '0000-00-00 00:00:00') ?
							JDate::getInstance($prod['date_event'],$timezone)->getTimestamp() :
							JDate::getInstance($prod['date_tickets'],$timezone)->getTimestamp();//mktime(10, 00, 00, 01, 31, 2023);	//*Дата/Время проведения сеанса (unix timestamp)
//	https://orelmusizo.ru/bilety/punkty/product/view/1/9
//toPrint($dataPushka->session_date,  ':'
//		. JDate::getInstance($dataPushka->session_date)
//		.  ' -'. $prod['product_id'],true, 'message',true );// 2023-04-24 01:00:00  // 0000-00-00 00:00:00
//continue;
					$dataPushka->barcode				= $attr->QRcode;// $QRcode;//'9004881200123';
					$dataPushka->barcode_type			= '5'; //EAN-13 Штрихкод -3бит,  Code128 Штрихкод -2бит,  QRcode -1бит,(5- QR и EAN13; 1 - QR; 4 - EAN13, 3 -QRиCODE128, ) 
					$dataPushka->visitor_full_name		= $name_FIO ?? '';//"Kornelius";// Серджио Великий
					$dataPushka->visitor_first_name		= $name_F ?? '';
					$dataPushka->visitor_last_name		= $name_L ?? '';
					$dataPushka->visitor_middle_name	= $name_M ?? '';

					// Необязательные свойства
					$dataPushka->comment				= "OrderID:$orderTable->order_id,ProdID:$prod[product_id]";
					$dataPushka->payment_id				= $orderTable->order_id;//getNewId('payment_id');  // ID платежа у Билетного оператора
					$dataPushka->payment_rrn			= $orderTable->order_id;//getNewId('payment_rrn');	// RRN (Retrieval Reference Number) уникальный идентификатор транзакции
					$dataPushka->session_place			= $prod['product_name'] ?? '';
					$dataPushka->session_params			= $attr->attr . ' - ' . $attr->value;

//toPrint($dataPushka,'$dataPushka:',0,'message',true);
		//			$orderTable->places		= json_encode($places);	
					// str_getcsv
//					$orderTable->order_id; 
//toPrint($dataPushka,'$dataPushka Request:',0,'message',true);
					
					if(isset($prod['place_pushka']) && $prod['place_pushka']){
						$dataPushka = $pushka->AddTicket($dataPushka);
						$idKeysPuska[$order_item_id][$av_id] = $dataPushka->id ?? '';
					}
						
//toPrint($dataPushka,'$dataPushka Response:',0,'message',true);
					// номер билета в системе ПушКарта */
					
					$cartModel->products[$prod_i]['attributes_value'][$av_id]->pushka_id = $dataPushka->id ?? '';
					$cartModel->products[$prod_i]['attributes_value'][$av_id]->status	 = $dataPushka->status ?? '';
				}
			}
//return;
//toPrint($idKeysPuska,'$idKeysPuska:',0,'message',true);
			
			foreach ($idKeysPuska as $order_item_id => $keys){
//				$keys = array_filter($keys);
				
				if(empty($keys)){
					continue;
				}
				
				$keys_string = implode(',', $keys);
				
				$query = "
UPDATE #__jshopping_order_item
SET place_pushka = '$keys_string'
WHERE order_item_id = $order_item_id;
				";
//toPrint($query,'$query:',0,'message',true);
				JFactory::getDBO()->setQuery($query)->execute();
			}
			
			
			
		}
		
		
//toPrint($cartModel->products,'$prods Item:',0,'message',true);
		
		
		
		
        
        foreach($cartModel->products as $key => $prod){
            $cartModel->products[$key]['price'] += $prod['price_places'];
        } 
		
		if(empty($orderTable) || empty($orderTable->order_id) || empty($orderTable->order_status))
			return; 
		
// return;
		$r = PlaceBiletHelper::deletePlaces($orderTable->order_id,$orderTable->order_status);
		
//		toPrint($orderTable,'$orderTable '.($r?'True':'False'),0,'pre',true);
//		toLog($orderTable, '$orderTable '.($r?'True':'False'), 'finish.txt','',true);
    }

	
	
	function onBeforeSendOrderEmailClient(Event $event){//&$mailer, &$order, &$manuallysend, &$pdfsend, &$vendor, &$vendors_send_message, &$vendor_send_order
		
//		$mailer = \JFactory::getMailer();
		/** @var \Joomla\CMS\Mail\Mail $mailer */
		$mailer		= $event->getArgument(0);
		$order		= $event->getArgument(1);
		$bodyTickets = '';
		
		
//<style>
//.inner-wrapper-sticky {
//    position: relative !important;
//    left: 0 !important;
//    top: 0 !important;
//    bottom: auto !important;
//    transform: none !important;
//}
//</style>', TRUE,'pre',true);
//		$currencies = JSFactory::getAllCurrency();
//		$cur_name = $currencies[$product->currency_id]->currency_name ?? JText::_('JSHOP_CURRENCY');//currency_id,currency_name,currency_code,currency_code_iso,currency_value
//      $cur_code = $currencies[$product->currency_id]->currency_code ?? JText::_('JSHOP_CUR');//currency_id,currency_name,currency_code,currency_code_iso,currency_value
    
		
		$mailer->setSubject(sprintf(\JText::_('JSHOP_NEW_ORDER'), $order->order_number, ($order->phone ?: $order->mobile_phone ?: $order->email)) . ' ' .($order->d_FIO ?: $order->FIO));
		
//		$timezone = 'GMT';
//		$timezone = 'UTC';
//		$timezone = JFactory::getApplication()->getConfig()->get('offset','UTC');
//		$timezone = JFactory::getUser()->getParam('timezone',$timezone);
		
		$timezone = PlacebiletHelper::getTimezone();
//		$unix_timestamp = JDate::getInstance('now',$timezone)->getTimestamp();
		
		
		
		
		$pathTemp	= JFactory::getConfig()->get('tmp_path');
		$siteName	= JFactory::getConfig()->get('sitename');
		$siteUrl	= JFactory::getConfig()->get('live_site')  ?: $_SERVER['SERVER_NAME'];

		include_once $this->pluginPath.'/src/Lib/phpqrcode/qrlib.php';
		
		$db = JFactory::getDBO();
		
//		$order = $order;
		$products = $order->products;
        
		$prodIDs = array_column($products, 'product_id');
		
//toPrint($prodIDs,'$prodIDs:'.$pr_id, TRUE,'message',true);
		$lang = JSFactory::getLang()->lang;
		$langs = implode(',', PlaceBiletHelper::getLanguageList('c.name_'));
		
		$query = "
SELECT pc.product_id, c.category_id, c.`name_$lang`  name
FROM #__jshopping_products_to_categories pc, #__jshopping_categories c
WHERE pc.category_id = c.category_id AND c.category_publish AND pc.product_id IN (" . implode(',', $prodIDs) . ");
		";//CONCAT_WS(' /', $langs )
//toPrint($query,'$query:'.$pr_id, TRUE,'message',true);
//return;
		$prodCatNames = [];
		$categories = [];
        if ($prodIDs && $langs) 
            $categories = JFactory::getDBO()->setQuery($query)->loadObjectList();
		
//toPrint($categories,'$categories:'.$pr_id, TRUE,'message',true);
//return;
		foreach ($categories as $cat){
			$prodCatNames[$cat->product_id][$cat->category_id] = $cat->name;
		}
		
		$tickets_html = '';
		$tickets	  = [];
		
//toPrint($prodCatNames,'$prodCatNames:'.$pr_id, TRUE,'message',true);
		
		//дублирующий текст для письма который отображается перед билетами, для отображения подсказки в списке писем онлайн почты
		$dates_email_print = '';
		
		
		$attributeIDs	= [];
		$variableIDs	= [];
		foreach($products as $prod){
			foreach(unserialize($prod->attributes) as $attr_id => $var_id){
				$attributeIDs[] = $attr_id;
				$variableIDs[$var_id] = $attr_id;
			}
		}
		
		$query = "	
SELECT av.value_id, av.attr_id, av.`name_$lang` var_name, a.`name_$lang` attr_name
FROM #__jshopping_attr_values av, #__jshopping_attr a  
WHERE av.value_id IN (" . implode(',', array_keys($variableIDs)) . ") 
	AND (a.`name_$lang` OR av.`name_$lang`)
	AND a.attr_id = av.attr_id AND a.attr_type NOT IN (4,5) -- AND a.attr_id IN (9,10,1,2,3)
ORDER BY av.value_ordering;
		";
        $attributes_vars = JFactory::getDBO()->setQuery($query)->loadObjectList('value_id');
		
//toPrint($attributes_vars,	'$attributes_vars ->plgOrderMail()',0,'message',true);
		
		foreach ($products as $pr_id => $product_order_item){
//			$product_name = $product['product_name'];
//			$product_name = $product->product_name;
//			$product_name = $product->product_name;
			
//toPrint($product_order_item,'$product_order_item ->plgOrderEmail()',0,'message',true);
			$dates_email_print .= "<h2 style='width:100%;text-align: center;'>" . JSHelper::formatdate($product_order_item->date_event, true) . '  ';
			
			$dates_email_print .= $product_order_item->product_name. ',</h2> ';
			
//toPrint($product_order_item,'$product_order_item:'.$pr_id, TRUE,'message',true);
			
			$place_attr_var = json_decode($product_order_item->places, true);// [$prod_attr_value->id => "value_id,attr_id"]
			$place_prices	= json_decode($product_order_item->place_prices, true);	// [$prod_attr_value->id => addprice]
			$place_counts	= json_decode($product_order_item->place_counts, true);	// [$prod_attr_value->id => count]
			$place_names	= unserialize($product_order_item->place_names); //[$prod_attr_value->id]	= $prod_attr_value->attr.' - '.$prod_attr_value->value;
			$pushka_IDs		= str_getcsv($product_order_item->place_pushka??''); // IDs Билетов = Массив Токенов кючей билетов
			
//toPrint($product_order_item->attributes,	'$product_order_item->attributes ->plgOrderMail()',0,'message',true);
			$product_attributes		= unserialize($product_order_item->attributes);	// [$attr_id => $var_id] 
			
			$product_attributes = array_intersect_key($attributes_vars, array_flip($product_attributes));
			
			foreach($product_attributes as $value_id => $attr_id){
				if(empty($attributes_vars[$value_id]))
					continue;
				$product_attributes[$value_id] = $attributes_vars[$value_id];
			}
//			$place_counts_objs = array_map(function($attr_prod_id,$count){return (object)['attr_prod_id'=>$attr_prod_id,'count'=>$count];}, $place_counts);
			
			//Индекс порядка билетов
			$index = 0;
			//Индекс для получения названий атрибутов 
			
			$product_order_item->count_places;

//toPrint($place_prices,	'$place_prices ->plgOrderMail()',0,'message',true);
//toPrint($place_counts,	'$place_counts ->plgOrderMail()',0,'message',true);
//toPrint($place_prices,	'$place_prices ->plgOrderMail()',0,'message',true);
//toPrint($place_names,	'$place_names ->plgOrderMail()',0,'message',true);
//toPrint($pushka_IDs,	'$pushka_IDs ->plgOrderMail()',0,'message',true);
//toPrint($attributes,	'$attributes ->plgOrderMail()',0,'message',true);
//toPrint($place_attr_var,	'$place_attr_var ->plgOrderMail()',0,'message',true);
			
//			foreach ($place_names as $value_id => $place_name ){ // $index = 33;
			foreach ($place_counts as $attr_prod_id => $count){// field
//				current($product_attributes);next($product_attributes);
				$place_name			= $place_names[$attr_prod_id];
				$place_price		= $place_prices[$attr_prod_id] ?? 0;
//				$quantity			= $place_counts[$attr_prod_id];
				
				list($var_id, $attr_id) = explode(',', $place_attr_var[$attr_prod_id]);
				
				
				$attr_var = $attributes[$var_id];
				 
				
//toPrint($var_id,	'$var_id ->plgOrderMail()',0,'message',true);
//toPrint($attr_id,	'$attr_id ->plgOrderMail()',0,'message',true);

//				$attributes[];
				
				
				foreach (range(1, $count) as $i){
					
	//				[attr_id] => 1
	//				[value_id] => 5
	//				[attr] => Греческий зал 
	//				[value] => 5
	//				[addprice] => 30.0000
	//				[id] => 4770
	//				[OfferId] => 0
	//				[QRcode] => js71.52365263574
	//				[pushka_id] => 0000721b-69de-41e4-8ccb-69b0f8d5a868
	//				[status] => active
				
//toPrint($index,'$index Mail',0,'message',true);
//toPrint($product_order_item->count_places,'$product_order_item->count_places Mail',0,'message',true);

					$QRcode	= (string) PlaceBiletHelper::getQRcode($product_order_item->order_item_id, $index, $product_order_item->count_places);
//toPrint($QRcode,'$QRcode Mail',0,'message',true);
	//				$product_order_item->product_attributes;

					$data = [];

					$data['QRcode']			= $QRcode;

					$data['pushka_id']		= $pushka_IDs[$index] ?? '';
					$data['addprice']		= $place_price;
					$data['place_name']		= $place_name;
					$data['product_attributes']	= $product_attributes ?? null;
//						$data['placeName']		= $placeName ?? '';
					$data['placeCount']		= $count;
					$data['placeIndex']		= $i;



					
					
					$imagePath = $pathTemp . '/del_' . (time()  + 100 ) . '_' . md5($QRcode) . uniqid() . '.png';
					
					QRcode::png($QRcode, $imagePath, QR_ECLEVEL_L, 4, 2);
					
//					$imageMimeData = mime_content_type($imagePath);
	//				$imageData = base64_encode(file_get_contents($imagePath));
	//				$data['QRsrc']			= 'data: ' . $imageMimeData . ';base64,' . $imageData;
	//				unlink($imagePath);
//					$imageName = $place_name . '_' . $QRcode;
//					$data['imageAlias']		= md5($QRcode);
//					$mailer->AddEmbeddedImage($imagePath, $data['imageAlias'], $place_name . '_' . $QRcode.'.png', 'base64', $imageMimeData);
					
					
					
					$data['imageAlias']		= md5($QRcode);
					ob_start();
					QRcode::png($QRcode, NULL, QR_ECLEVEL_L, 5, 2);
					$base64					= ob_get_clean();
//					$base64					= base64_encode( ob_get_clean() );
					
//					$prod['imageAlias']	= 'data:image/png;base64,' . base64_encode( ob_get_clean() );
					$mailer->addStringEmbeddedImage($base64, $data['imageAlias'], $place_name . '_' . $QRcode.'.png', 'base64', 'image/png');

					$data['siteName']		= $siteName;
					$data['siteUrl']		= $siteUrl;
					$data['categories_name']	= $prodCatNames[$product_order_item->product_id] ?? [];

					$data['product_name']	= $product_order_item->product_name;
					$data['count_places']	= $product_order_item->count_places;
					$data['date_event']		= $product_order_item->date_event;
					$data['date_event_print']= JSHelper::formatdate($order->order_date, true) ;
					$data['date_event_unix']= JDate::getInstance($product_order_item->date_event,$timezone)->getTimestamp();
//					$data['date_tickets']	= $product_order_item->date_tickets ?? 0;
					$data['date_tickets_print']	= str_replace('00:00:00', '', JSHelper::formatdate($product_order_item->date_tickets ?? 0)) ;//PlaceBiletHelper
					$data['event_id']		= $product_order_item->event_id ?? '';
	//				$data['order_id']		= $order->manufacturer;

					$data['order_id']		= $order->order_id;
					$data['order_number']	= $order->order_number;
					$data['order_date']		= $order->order_date;
					$data['order_datetime_print']= $order->order_datetime_print;
	//				$data['order_date_unix']= JDate::getInstance($order->order_date,$timezone)->getTimestamp();
					$data['phone']			= $order->d_mobil_phone ?: $order->d_phone ?: $order->mobil_phone ?: $order->phone;
					$data['email']			= $order->d_email ?: $order->email;
	//				$data['order_id']		= $product_order_item->event_id ?? '';


					$data['f_name']			= $order->d_f_name ?: $order->f_name;
					$data['l_name']			= $order->d_l_name ?: $order->l_name;
					$data['m_name']			= $order->d_m_name ?: $order->m_name;
					$data['FIO']			= $order->d_FIO ?: $order->FIO;
					
					$data['currency_code']	= $order->currency_code;


					$layout = new JLayoutFile('tickets_mail', PlaceBiletPath . '/templates/checkout/', $options = null);

					$layout->addIncludePaths($order->templates);
					$renderTickets = $layout->render($data);
//					$bodyTickets .= \Joomla\CMS\Mail\MailHelper::cleanText($layout->render($data));
					
//					$query = "
//UPDATE #__jshopping_order_item 
//SET product_attributes = CONCAT(product_attributes, '".$db->escape("<div class='tickets'>".$renderTickets.'</div>')."') 
//WHERE order_item_id=$product_order_item->order_item_id;
//					";
//file_put_contents(__DIR__.'/deb.txt', "\n\n".$query."\n\n", FILE_APPEND);
//toPrint($query,'$query',0,'message',true);
//					$db->setQuery($query)->execute();
//					$order->products[$pr_id]->product_attributes .= \Joomla\CMS\Mail\MailHelper::cleanText($renderTickets);
					$bodyTickets .= \Joomla\CMS\Mail\MailHelper::cleanText($renderTickets);
					$index += 1;
				} 
			}
			
//			$order->products[$pr_id]->product_attributes .= " 321__БИЛЕТЫ__$!+ ";
//			$bodyTickets .= $order->products[$pr_id]->product_attributes;
//			$bodyTickets .= \Joomla\CMS\Mail\MailHelper::cleanText($order->products[$pr_id]->product_attributes);
		}
		
		$urlName = str_starts_with($siteUrl,'http:') ? substr($siteUrl,5) : $siteUrl;
		$planformLabel = JText::_('JSHOP_PLACE_BILET_PLATFORM');
		
		$mailer->Body = '<div class="tickets" style="
	margin:auto; display: flex;
    justify-content: center;
	flex-wrap: wrap;
    align-items: flex-start;"> ' . $dates_email_print . ' <br>' . $bodyTickets . '</div>' . $mailer->Body.
			"<br><center style='
					margin-top: 5px;
					word-wrap: break-word;
					word-break: break-word;
					font-size: xx-small;
					line-height: xx-small;'>
				<a target='_blank'  href='$siteUrl'>$urlName</a> /$siteName
				<br><a href='https://explorer-office.ru/download/' target='_blank'>$planformLabel //explorer-office.ru</a>
			</center>";
		
//		echo '<div class="tickets">' . $bodyTickets . '</div>';
//		$ticketsRenderBilet = '<div class="tickets">' . $bodyTickets . '</div>';

		$event->setArgument(1,$order);
  
//        $layout->addIncludePath(PlaceBiletPath . '/templates/product/'); //Новый шаблон  
		
//toPrint($mailer->Subject,'$mailer->Subject',0,'message',true);
    }
	 
	
	
	/**
	 * Сайт Клиент - Страница с благодарностью об успешном заказе, Последняя страница
	 * Происходит после оплаты товара.
	 * Происходит после заказа без оплаты товара. При сообщении благодарности за заказ.
	 * @param string $text		Текст для вывода пользователю
	 * @param int $order_id		ID Заказа
	 */
	function onBeforeDisplayCheckoutFinish(Event $event){//&$text = '', &$order_id = 0, &$text_end
//		$text = $event->getArgument(0, '');
		$event->setArgument(0, '');
		$order_id  = $event->getArgument(1,0);
	
		$pathTemp	= JFactory::getConfig()->get('tmp_path');
		$siteName	= JFactory::getConfig()->get('sitename');
		$siteUrl	= JFactory::getConfig()->get('live_site')  ?: $_SERVER['SERVER_NAME'];
		$urlName	= str_starts_with($siteUrl,'http:') ? substr($siteUrl,5) : $siteUrl;
		$planformLabel = JText::_('JSHOP_PLACE_BILET_PLATFORM');
		// Pushka Пушка 
//		toPrint(null,'',0,'pre',true);
		
		echo "<h2>" . JText::_('JSHOP_THANK_YOU_ORDER') . "</h2>";
		
//		$order_status_id = (int)$this->params->place_old;
		
		echo "<div class='descriptionFinish'>" . JText::_('JSHOP_THANK_YOU_ORDER_TEXT_') . "</div>";

		if(empty($order_id))
			return;
		
		
		include_once $this->pluginPath.'/src/Lib/phpqrcode/qrlib.php';
		
//		$timezone = 'GMT';
//		$timezone = 'UTC';
//		$timezone = JFactory::getApplication()->getConfig()->get('offset','UTC');
//		$timezone = JFactory::getUser()->getParam('timezone',$timezone);
//		$unix_timestamp = JDate::getInstance('now',$timezone)->getTimestamp();
		$timezone = PlacebiletHelper::getTimezone();
		
		$r = PlaceBiletHelper::deletePlaces($order_id); 

		$lang = JSFactory::getLang()->lang;
		
		echo "<div class='ticketsFinish'>" . JText::_('JSHOP_PLACE_BILET_ORDER_TEXT_TICKETS') . "</div>";
		
		$query = "
SELECT o.order_number, o.order_date,   o.f_name, o.l_name, o.m_name, o.currency_code, o.FIO
FROM omii_jshopping_orders o
WHERE o.order_id = $order_id
		";
        $order = JFactory::getDBO()->setQuery($query)->loadObject();
		
		$query = "
SELECT oi.product_name, oi.product_attributes, oi.attributes, oi.date_event, oi.date_tickets, oi.place_counts, oi.place_names, oi.place_prices, oi.places, oi.count_places,oi.place_pushka, 
	GROUP_CONCAT(DISTINCT cat.`name_$lang` SEPARATOR '<br>') categories, oi.product_id, oi.order_item_id
FROM #__jshopping_order_item AS oi, #__jshopping_products_to_categories pc, #__jshopping_categories cat
WHERE pc.product_id = oi.product_id AND pc.category_id=cat.category_id  AND oi.order_id=$order_id
GROUP BY oi.order_item_id;
		";
//toPrint($query,'$query:'.$pr_id, TRUE,'message',true);
        $products = JFactory::getDBO()->setQuery($query)->loadAssocList('order_item_id');
		
		$places = [];
		$attributes = [];
		$productIDs	= [];
		$product_attributes = [];
		
		
		$query = "
SELECT pc.product_id, c.category_id, c.`name_$lang`  name /*, GROUP_CONCAT(c.`name_$lang` SEPARATOR '||') */
FROM #__jshopping_products_to_categories pc, #__jshopping_categories c
WHERE pc.category_id = c.category_id AND c.category_publish AND pc.product_id IN (" . implode(',', array_column($products,'product_id')) . ");
/* GROUP BY pc.product_id */
		";
        $categories = JFactory::getDBO()->setQuery($query)->loadObjectList();// loadObjectList('value_id');
		
		
		foreach ($products as $prod){
			$place_names	= unserialize($prod['place_names']);
			$place_counts	= json_decode($prod['place_counts'],true);
			$place_prices	= json_decode($prod['place_prices'],true);
			
			$place_name			= $place_names[$attr_prod_id];
			
//toPrint($prod['attributes'],'$prod[attributes] ', TRUE,'message',true);
//toPrint($prod,'$prod ', TRUE,'message',true);
//return;

			$product_attributes	+= array_flip(unserialize($prod['attributes'])) ;//$attr_id => $var_id
			$productIDs[]		= $prod['product_id'];
			
			
			foreach (json_decode($prod['places'],true) as $prodValID => $attr_vall_id){
				list($valID,$attrID) = explode(',',$attr_vall_id);
				$attributes[$valID] = $attrID;
				$places[$prod['product_id']][$prodValID] = (object)[
					'name'	=> $place_names[$prodValID],
					'count' => $place_counts[$prodValID],
					'price' => $place_prices[$prodValID],
					'valID'	=> $valID,
					'attrID'=> $attrID,
				];
			}
//			$prod['places'] = $places[$prod['product_id']];
		}
		
		
		$query = "
SELECT (a.attr_type = 4 OR a.attr_type = 5) as `type`,
	av.`name_$lang` var_name,  a.`name_$lang` attr_name,
	a.attr_ordering, a.attr_type,  av.value_id, a.attr_id,
	a.`group` group_id , ag.ordering group_order  , ag.`name_$lang` group_name /* */
FROM #__jshopping_attr_values av,  #__jshopping_attr a 
 LEFT JOIN #__jshopping_attr_groups ag ON a.`group`=ag.id  /* */
WHERE  av.attr_id = a.attr_id /* AND a.attr_type IN (4,5)  */
	AND (a.`name_$lang` OR av.`name_$lang`)
	AND (av.value_id IN (". implode(',', array_keys($attributes)).") AND a.attr_id IN (". implode(',', $attributes).")
		OR av.value_id IN (". implode(',', array_keys($product_attributes)).") AND a.attr_id IN (". implode(',', $product_attributes).")
	)
ORDER BY a.attr_ordering , ag.ordering, /* */ av.`name_$lang`; 
		";
//toPrint($query,'$query:'.$pr_id, TRUE,'message',true);
//return;
        $attributes = JFactory::getDBO()->setQuery($query)->loadObjectList('value_id');
		
		
		echo '<ul class="tickets">';
		
//toPrint($categories,'$categories ', TRUE,'message',true);
		foreach ($products as $prod){
			
			$prod['categories_name'] = [];
			foreach ($categories as $cat){
				if($prod['product_id'] == $cat->product_id)
				$prod['categories_name'][$cat->category_id] = $cat->name;
			}
			
//toPrint($prod,'$prod ', TRUE,'message',true);
			$index = 0;
			
//			$count_places	= $prod['count_places'];
			$pushka_IDs		= str_getcsv($prod['place_pushka']??'');
			$prod['place_pushka'] = $pushka_IDs;
			$prod['product_attributes'] = array_intersect_key($attributes, $product_attributes);
//toPrint($attributes,'$attributes', TRUE,'message',true);
//toPrint($product_attributes,'$product_attributes', TRUE,'message',true);
//toPrint($prod['product_attributes'],'$prod[product_attributes] ', TRUE,'message',true);
//			$prod['categories_name'] = $prodCatNames;
			$prod['siteUrl']	= $siteUrl;
			$prod['siteName']	= $siteName;


//			$prod['date_event']			= $prod['date_event'];
//			$prod['date_tickets']		= $prod['date_tickets'] ?? 0;
			$prod['date_event_print']	= JSHelper::formatdate($order->order_date, true) ;
			$prod['date_event_unix']	= JDate::getInstance($prod['date_event'],$timezone)->getTimestamp();
//			$prod['order_datetime_print']= $order->order_datetime_print; //JDate::getInstance();//
			$prod['order_datetime_print']= JSHelper::formatdate($order->order_date, 1);
		
//			$this->order_date_print = Helper::formatdate($this->order_date);
			$prod['date_tickets_print']	= str_replace('00:00:00', '', JSHelper::formatdate($prod['date_tickets'])) ;//PlaceBiletHelper
			$prod['order_id']			= $order_id;
			$prod['order_number']		= $order->order_number;
			$prod['f_name']				= $order->f_name;
			$prod['l_name']				= $order->l_name;
			$prod['m_name']				= $order->m_name;
			$prod['FIO']				= $order->FIO;
			$prod['currency_code']		= $order->currency_code;
			$prod['pushka_id']			= $pushka_IDs[$index] ?? '';
			
			foreach ($places[$prod['product_id']] as $prodValID => $place){
				
				$prod['addprice']	= $place->price;
				$prod['place_name'] = $place->name;
				$prod['place']		= $place;
				$prod['placeCount']	= $place->count;
				
				foreach (range(1, $place->count) as $i){
				

					$QRcode	= (string) PlaceBiletHelper::getQRcode($prod['order_item_id'], $index, $prod['count_places']);
					

//					$imagePath = '/del_' . (time()  + 100 ) . '_' . md5($QRcode) . uniqid() . '.png';
//					$prod['imageAlias']	= $siteUrl . '/tmp'. $imagePath;
//					QRcode::png($QRcode, $pathTemp . $imagePath, QR_ECLEVEL_L, 5,2);
					
					
					ob_start();
					QRcode::png($QRcode, NULL, QR_ECLEVEL_L, 5, 2);
					$prod['imageAlias']	= 'data:image/png;base64,' . base64_encode( ob_get_clean() );
					
					
					
//					$imageMimeData = mime_content_type($imagePath);
	//				$imageData = base64_encode(file_get_contents($imagePath));
	//				$prod['QRsrc']			= 'data: ' . $imageMimeData . ';base64,' . $imageData;
	//				unlink($imagePath);
//					$imageName = $place->name . ' ' . $QRcode;

					$prod['QRcode']		= $QRcode;
					
//					$prod['attribute'] = $attributes[$place->valID];
//					$prod['attributes'] = $attributes;
					$prod['placeIndex']	= $i;
				
					$layout = new JLayoutFile('tickets', PlaceBiletPath . '/templates/checkout/', $options = null);
					$layout->addIncludePaths(PlaceBiletPath . '/templates/checkout');
					echo $layout->render($prod);
//					place		= product_id [name, count, price,]
//					attributes	= vallue_id [place_name, attr_name, attr_id, value_id, group_name, group_id]
			$index += 1;
				}
			}
		}
		
		echo '</ul>';
		
//var_name
//attr_name
		
		
//		$query = "	
//SELECT oi.product_attributes, oi.order_item_id
//FROM #__jshopping_order_item oi
//WHERE oi.order_id = $order_id;
//		";
//toPrint($query,'$query',0,'message',true);
//        $product_attributes = JFactory::getDBO()->setQuery($query)->loadAssocList('order_item_id','product_attributes');
//toPrint($product_attributes,'$product_attributes',0,'message',true);
		
		
//		echo '<div class="tickets" style="
//	margin:auto; display: flex;
//    justify-content: center;
//	flex-wrap: wrap;
//    align-items: flex-start;"> ' . $dates_email_print . ' <br>'; 
		
//		foreach($product_attributes as $prod_attrs){
//			echo $prod_attrs;// $prod_attrs['product_attributes'];
//		}
//		echo "</div><br><center style='
//					margin-top: 5px;
//					word-wrap: break-word;
//					word-break: break-word;
//					font-size: xx-small;
//					line-height: xx-small;'>
//				<a target='_blank'  href='$siteUrl'>$urlName</a> /$siteName
//				<br><a href='https://explorer-office.ru/download/' target='_blank'>$planformLabel //explorer-office.ru</a>
//			</center>";
		
//		echo '<div class="tickets">' . $bodyTickets . '</div>';
		
		 
	}

	/**
	 * Клиент: Выполняется после сохранения заказа, при отображении благодарности за заказ.
	 * @param type $text
	 * @param type $order
	 * @param type $pm_method
	 */
	function onAfterDisplayCheckoutFinish(Event $event ){//&$text='', &$orderTable=null, &$pm_method=null
		$text				= $event->getArgument(0, '');
		$orderTable			= $event->getArgument(1, null);
		$pm_method			= $event->getArgument(2, null);
		
		if(empty($orderTable->order_id) || empty($orderTable->order_status))
			return;
		
		$r = PlaceBiletHelper::deletePlaces($orderTable->order_id,$orderTable->order_status);
		
//		toPrint($orderTable->order_status,'$orderTable->order_status '.($r?'True':'False'),0,'pre',true);
//		toLog($orderTable, '$orderTable '.($r?'True':'False'), 'finish.txt','',true);
	}

    function onAfterInitialise(){
        $input = JFactory::getApplication()->input;
    //перехватываем событие
        if ( $input->getCmd( 'action', '' ) === 'getTitle' ) {
            $id = $input->getInt( 'id', 0 );
            $db = JFactory::getDbo();
            $query = $db->getQuery( true );
            $query->select( 'id, title' )->from( '#__content' )->where( 'id=' . $id );
            $row = $db->setQuery( $query )->loadObject();
            if ( !empty( $row->id ) ) {
                echo 'Запись с ID ' . $id . ' имеет заголовок: ' . $row->title;
            } else {
                echo 'Запись с ID ' . $id . ' не найдена: ';
            }
            exit; //выходим из приложения
        }
    }

    /**  ***************************************** АДМИН ПАНЕЛЬ  ************************************************************** */
	
	
	/**
	 * Админка - Вызывается перед инициализацией конроллера компонента
     * Админка - При получении контроллера из адресной строки. строка имени контролера Переопределение контроллера администратора админки
	 * 
	 * return void
	 */
	//onAfterLoadShopParams
	function onAfterLoadShopParamsAdmin(Event $event){
		$this->init();
//\Joomla\CMS\Factory::$application->enqueueMessage("<pre>".print_r('ParamsAdmin',true)."</pre>");
		$controller = $event->getArgument('controller', null);
		
//JFactory::getApplication()->enqueueMessage(JText::_('JSHOP_OF').'1');
		
		$app =  $this->getApplication();//\JFactory::getApplication();//
		if(empty($controller))
			$controller = PlaceBiletHelper::JInput('controller','');
		
		if(empty($controller))
			$controller = 'display';
		
		$controller = strtolower($controller);
//		$controller = $this->onAfterGetControllerAdmin($controller);//$dispatcherTestDelete

//		$dipsetcher = new Joomla\Component\Jshopping\Administrator\Dispatcher($app,  $input, $mvcFactory);
//		$dipsetcher
		
//\Joomla\CMS\Factory::$application->enqueueMessage("<pre>".print_r($controller,true)."</pre>");
//	JFactory::getApplication()->enqueueMessage("\$this->params<br/><pre>Controller:  ".'<br/>'.print_r($this->params,true)."</pre>");
        if((substr($controller, -4)=='_mod'))
            $controller = substr ($controller, 0, -4);
		
        if((substr($controller, -3)=='mod'))
            $controller = substr ($controller, 0, -3);
 
        define( 'PlaceBiletPathViewAmdin', $this->pluginPath);

		
			
		if(in_array($controller, ['products','ProductsMod','categories','CategoriesMod']))
			PlaceBiletHelper::uploadFilesRename();
			
		
        $file			= JPATH_PLUGINS . '/jshopping/placebilet/ControllerA/' . ucfirst($controller) . 'Controller.php';
        $fileTeplate	= JPATH_PLUGINS . '/jshopping/placebilet/templatesA/'  . $controller . '/default.php';
		
		$template = $controller;
		
		$fileComponent = JPATH_COMPONENT."/Controller/".ucfirst($controller)."Controller.php"; //AttributesvaluesController.php
		
//\Joomla\CMS\Factory::$application->enqueueMessage("<pre>plg: ".print_r($fileComponent,true)."</pre>");

		if (file_exists($file)){
			require_once($file); //JshoppingControllerProductsMod
			$this->getApplication()->input->set('controller', ucfirst($controller).'Mod');
			return;
		}

		if(file_exists($fileComponent)){
			
			require_once($fileComponent);
			
		}else{
			
//\Joomla\CMS\Factory::$application->enqueueMessage("<pre>plg: ".print_r($file,true)."</pre>");
			$fileComponent	= JPATH_PLUGINS . '/jshopping/placebilet/ControllerA/EmptyController.php';
			require_once($fileComponent);
            $controller = 'empty';
			$this->getApplication()->input->set('controller','empty');
			
			if(file_exists($fileTeplate))
				$this->getApplication()->input->set('view',$template);
			else
				echo JText::_('JSHOP_PLACE_BILET_'. strtoupper($template));
			
			return;
		}
		

		
//\Joomla\CMS\Factory::$application->enqueueMessage("<pre>com: ".print_r($fileComponent,true)."</pre>");
//\Joomla\CMS\Factory::$application->enqueueMessage("<pre>plg: ".print_r($file,true)."</pre>");

//        if(!file_exists($fileComponent))
//            JError::raiseError( 403, JText::_('Access is! denied'));
		
		if($controller == 'display'){
			$controller = '';
		}
		
		
		
//		$classController = 'JshoppingController'.$controller;
//		$classControllerMod = $classController.'_mod';
//		$classControllerMod = ucfirst($controller).'ModController';
		$classControllerMod = '\\Joomla\\Component\\Jshopping\\Administrator\\Controller\\'. ucfirst($controller).'ModController';
//\Joomla\CMS\Factory::$application->enqueueMessage("<pre>plg: $classControllerMod ".print_r(class_exists($classControllerMod)?1:0,true)."</pre>");

		
//		JLoader::registerAlias("\\Joomla\\Component\\Jshopping\\Administrator\\Controller\\EmptyController", "\\Joomla\\Component\\Jshopping\\Administrator\\Controller\\EmptyModController");

		if(class_exists($classControllerMod) ){
            
            define( 'PlaceBiletPathViewAmdin', $this->pluginPath);
                
                
            $config = array();
            $controller_mod = new $classControllerMod($config);
            $controller_mod->execute(PlaceBiletHelper::JInput('task','display'));
            $controller_mod->redirect();
				
  
                
                PlaceBiletHelper::JInput()->set('task', NULL);
                
                $controller = 'empty';
				
			$this->getApplication()->input->set('controller',$controller);
			return;
		}
//toPrint($controller,'$controller',0,'message',true);
//		return;
		
//toPrint(get_class($app),'$controller',0,'message',true);
//toPrint(null,'',false,false,false);
//toPrint($controller,'$controller',0,'message',true);
//toPrint($controller,'$controller',0,'message',true);
//        if(PlaceBiletAdminDev)JFactory::getApplication()->enqueueMessage("<pre>Controller: \t".$controller.'<br/>'."Task: \t\t".$this->JInput()->getCmd('task')."</pre>");
//        if(PlaceBiletAdminDev)JFactory::getApplication()->enqueueMessage("Controller file: &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;  /administrator/components/com_jshopping/Controller/".$controller.'.php', 'message');//message,notice,warning,error        
        //if(PlaceBiletAdminDev)JFactory::getApplication()->enqueueMessage("Controller file: ".JPATH_COMPONENT.'/Controller/'.$controller.'.php', 'message');//message,notice,warning,error        

//toPrint($controller,'$controller',0,'message',true);
//        echo "<pre>runkit_method_add: ";
//            var_dump(function_exists('runkit_method_add'));
//        echo "</pre>"; 

		

        
			
        

        //Joomla\Component\Jshopping\Administrator\Controller\AttributesValuesController
		//JshoppingControllerAttributesValues
		
		
		
//		Joomla\Component\Jshopping\Administrator\Controller\AttributesValuesController; //JshoppingControllerAttributesvalues
		
		
//          $controller .= '_mod';
//                return;
//if(PlaceBiletAdminDev)JFactory::getApplication()->enqueueMessage("function Exist in file: &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".(function_exists("onBeforeDisplayListProductsView")?"True\t":"False\t")."&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;onBeforeDisplayListProductsView");
        
//toPrint($controller,'$controller',0,'message',true);
		
		
		//JshoppingControllerAttributesvalues	
//		$class_alias = '\\Joomla\\Component\\Jshopping\\Administrator\\Controller\\JshoppingController'.ucfirst($controller).'ModController';
		
//		class_alias( 'JshoppingController'.ucfirst($controller).'Mod', $class_alias);

//toPrint('JshoppingController'.ucfirst($controller).'Mod '.(class_exists('JshoppingController'.ucfirst($controller).'Mod')?" Exist ":" Noexist "),'ClassController:',0,'message',true); 
//toPrint('JshoppingControllerAttributesvaluesMod '.(class_exists('JshoppingControllerAttributesvaluesMod')?" Exist ":" Noexist "),'ClassController:',0,'message',true); 
//toPrint('\\Joomla\\Component\\Jshopping\\Administrator\\Controller\\JshoppingController'.ucfirst($controller).'ModController:'.(class_exists($class_alias)?" Exist ":" Noexist "),'ALiasController:',0,'message',true); 
//		if($controller)
//toPrint($class_alias,'$class_alias',0,'message',true); 
//toPrint($class_alias,'$class_alias',0,'message',true);
//			$controller = 'JshoppingController'.ucfirst($controller).'ModController'; //"JshoppingController". ucfirst($controller).'Mod';
//			$controller = ''.ucfirst($controller).'Mod';
//			$this->getApplication()->input->set('controller',$controller);
			
//			if($controller)
        
		
//        if(PlaceBiletAdminDev)JFactory::getApplication()->enqueueMessage("function Exist in file: &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".(function_exists("onBeforeDisplayListProductsView")?"True\t":"False\t")."&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;onBeforeDisplayListProductsView");
        
        
//        if (file_exists(JPATH_COMPONENT_SITE."/Lib/".$v->alias."/config.tmpl.php"))
//        include_once(JPATH_COMPONENT_ADMINISTRATOR."/importexport/".$alias."/".$alias.".php");
        //$file = JPATH_PLUGINS.'/jshoppingadmin/placebilet/Methods/'.$classController.'_'.$methodController.'.txt';            

		
                //$config['view_path']    = $pathView = PlaceBiletPathAdmin.'/View';//.DS.strtolower($controller).DS.'view.html.php';
                //$config['default_view'] = $pathView = PlaceBiletPathAdmin.DS.'View';//.DS.strtolower($controller).DS.'view.html.php';
            
			
                //toLog($classControllerMod,'$classControllerMod');  
//static $i;
//settype($i, 'int');
//toPrint($this->JInput()->getCmd('task'),'Input -> Task',0,'message',true);
//toPrint(get_class($controller_mod),$classControllerMod,0,'message',true);
//toPrint($classControllerMod,'$classControllerMod',0,'message',true);
//			$controller_mod->setFactory($dispatcherTestDelete->getFactory());
//toPrint(get_class($dispatcherTestDelete->getFactory()),'dispatch()-Factory ->>>>>>>>>>'.++ $i,0,'message',true);
//toPrint(get_class($controller_mod->getFactory()),'dispatch()-Factory ->>>>>>>>>>'.++ $i,0,'message',true);
                //$this->JInput()->set('task', NULL, 'GET', true);
                //echo '</pre>';
//                if(PlaceBiletAdminDev)JFactory::getApplication()->enqueueMessage( $classController."_mod: ".print_r($controller->get('redirect'),TRUE));
//                if(PlaceBiletAdminDev)JFactory::getApplication()->enqueueMessage(  "Task overwrite: ".print_r($this->JInput()->getCmd('task' ),TRUE));

            //$methodCode = file_get_contents($file);
            //$this->JInput()->getCmd('task','show');
            //$this->JInput()->set($name, $value = null, $hash = 'method', $overwrite = true)
            //$this->JInput()->set('task', $task.'mod', 'GET', true);
            //runkit_method_redefine ($classController, $methodController, $args, $methodCode, RUNKIT_ACC_PUBLIC);//" return code;"
            //runkit_method_add ($classController, $methodController.'mod', $args, $methodCode, RUNKIT_ACC_PUBLIC);//" return code;"
       
            
//echo "<pre>Класс: \t  ".$classController;
//echo "\n".(class_exists($classControllerMod)?'Есть':"Нет");
//echo "\nМетод: \t  ".$methodController; 
//echo "</pre>";         
        
            
//            if(PlaceBiletAdminDev)JFactory::getApplication()->enqueueMessage("<pre>Class_Mod: &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".(class_exists($classController.'_mod')?"True\t":"False\t").$classControllerMod."</pre>");
//        echo "<pre>файл: \t\t".(file_exists($file)?"True\t":"False\t").$file;
//        echo "\nМод Класс: \t".(class_exists($classController.'_mod')?"True\t":"False\t").$classControllerMod;    
//        //echo "\nМодМетод Класс: ".(method_exists($this,$classController)?"True\t":"False\t").$classController;    
//        echo "</pre>"; 
        
//        if(method_exists($this,$classController)){
//            $this->$classController($methodController);
//        }
    }

	 
	/**  
	 * Вызывается перед котроллеров в диспетчере компонента 
	 * 
	 * @var \Joomla\Event\Event $event
	 */
	function onAfterGetJsAdminRequestController(Event $event){//$name
				
//\Joomla\CMS\Factory::$application->enqueueMessage("<pre>".print_r('RequestControllerAdmin',true)."</pre>");
		
        $controllername = $event->getArgument(0);
		
		if(file_exists(JPATH_ROOT . '/libraries/fof40/Utils/helpers.php'))
			require_once JPATH_ROOT . '/libraries/fof40/Utils/helpers.php';
		
		if(file_exists(JPATH_ROOT . '/libraries/vendor/voku/portable-utf8/src/voku/helper/UTF8.php'))
			require_once JPATH_ROOT . '/libraries/vendor/voku/portable-utf8/src/voku/helper/UTF8.php';
		
		jimport('joomla.plugin.plugin');
		jimport('joomla.filesystem.file');
		jimport('joomla.filesystem.folder');
		
		if(file_exists(JPATH_PLUGINS.'/jshopping/placebilet/Lib/Helper.php'))
			require_once (JPATH_PLUGINS.'/jshopping/placebilet/Lib/Helper.php');
		
		if(file_exists(JPATH_PLUGINS.'/jshopping/placebilet/Lib/Zriteli.php'))   
			require_once (JPATH_PLUGINS.'/jshopping/placebilet/Lib/Zriteli.php');
				
		if(file_exists(JPATH_ROOT . '/functions.php'))
			require_once JPATH_ROOT . '/functions.php';

		if(function_exists('toPrint') == false){
			function toPrint($text = ''){}
		}
 
		if(function_exists('toLog') == false){
			function toLog($text = ''){}
		}
		
//JFactory::getApplication()->enqueueMessage(JText::_('JSHOP_OF'));
//JFactory::getApplication()->enqueueMessage($controllername);
//		$this->loadLanguage('plg_jshopping_placebilet');
//		$this->loadLanguage('plg_jshopping_placebilet');
		$this->loadLanguage();
//\Joomla\CMS\Factory::$application->enqueueMessage("<pre>".print_r($this->pluginPath,true)."</pre>");
//		$path = JPATH_PLUGINS.'/jshopping/placebilet/';
		$this->getApplication()->getLanguage()->load('plg_jshopping_placebilet', $this->pluginPath);

//		$lang = JFactory::getApplication()->getLanguage();
//		toPrint($lang->getPaths(),'$lang->getPaths()',0,'pre',true);
//$path = JPATH_PLUGINS.'/jshopping/placebilet/language/';
//JFactory::getApplication()->getLanguage()->load('', $path, NULL, TRUE); 
		
		
		//$this->params->organization_id;
		$this->params->pushka_url = '';
		$this->params->pushka_key = '';
		if($this->params->pushka_mode == 'uat'){
			$this->params->pushka_url = $this->params->pushka_url_uat;
			$this->params->pushka_key = $this->params->pushka_key_uat;
		}
		if($this->params->pushka_mode == 'prod'){
			$this->params->pushka_url = $this->params->pushka_url_prod;
			$this->params->pushka_key = $this->params->pushka_key_prod;
		}
		
		if(is_string($this->params->place_old) && strpos($this->params->place_old, '[') == 0){
			$this->params->place_old = trim($this->params->place_old,'[]');
			$this->params->place_old = explode(',', $this->params->place_old);
			$this->params->place_old = $this->params->place_old ?: [6,7];
		}
		
		PlaceBiletHelper::$param  = $this->params;
		
		if(PlaceBiletHelper::$param->jquery){
			PlaceBiletHelper::addJQuery();
		}
		
//        $query = " SELECT template FROM #__template_styles WHERE home=1 AND client_id=0; ";
        $this->template_name = $this->getApplication()->getTemplate(); //JFactory::getDBO()->setQuery($query)->loadResult();       
        PlaceBiletHelper::$template_name = $this->template_name;
		
        global $Zriteli_repertoire_download_enabled;
        
        $this->params->Zriteli_repertoire_download_enabled = PlaceBiletHelper::JInput('Zriteli_repertoire_download_enabled', FALSE);
        
		$fields = [
			'FIO','comment','housing','porch','level','intercom','shiping_date',
			'shiping_time',	'metro','transport_name','transport_no','track_stop',
			'd_FIO','d_comment','d_housing','d_porch','d_level','d_intercom',
			'd_shiping_date','d_shiping_time','d_metro','d_transport_name',
			'd_transport_no','d_track_stop'
		];
				
        foreach($fields as $field){
            $this->fields[$field] = PlaceBiletHelper::paramsGet($field);
        }
	      

 
        if(JDEBUG || $this->config->error_reporting == 'development'){ 
            jimport('joomla.log.log');
            $options = array( 'logger' => 'formattedtext', 'text_entry_format' => '{DATE}' . chr(9) . '{TIME}' . chr(9) . '{PRIORITY}' . chr(9) . '{CATEGORY}' . chr(9) . '{MESSAGE}', 'text_file_path' => JPATH_BASE, 'text_file' => 'log.txt' );
            $category = array('placebilet');
            Jlog::addLogger($options, JLog::ALL, $category);
        }
        if((bool)$this->params->Zriteli_enabled){ 
            try {
                Zriteli::Instance($this->params); //расскоментировать.
            } catch (Exception $exc) {
//                toLog($exc->getTraceAsString(),'!!! ОШИБКА !!! ... ,plgJshoppingPlaceBilet::__construct() => Zriteli::Instance(): ');
//                toPrint($exc->getTraceAsString(),'!!! ОШИБКА !!! ... ,plgJshoppingPlaceBilet::__construct() => Zriteli::Instance(): ') ;
	echo "<pre> <br>".print_r($exc->getTraceAsString(),true)." </pre>";
            }
            //toPrint($this->params, 'EnabledZriteli');
        }
		
		$this->onAfterGetJsFrontRequestController($event);
	}
    
	
	
	


    /**
     * 
     * @param JViewLegacy $OrderViewViewer
     */
    function onBeforeShowOrder(Event $event) {//&$OrderViewViewer
        $OrderViewViewer = $event->getArgument(0);
		
		$OrderViewViewer->addTemplatePath(PlaceBiletPath . '/templatesA/orders'); //Новый шаблон 
		
        foreach ($this->fields as $field=> $attrib){
			$OrderViewViewer->config_fields[$field] = $attrib;
		}
    }
	
    /**
     * 
     * @param JViewLegacy $OrderViewViewer
     */
    function onBeforeEditOrders(Event $event){ //&$OrderViewViewer
        $OrderViewViewer = $event->getArgument(0);
		
		$OrderViewViewer->addTemplatePath(PlaceBiletPath . '/templatesA/orders'); //Новый шаблон 
         
        foreach ($this->fields as $field=> $attrib){
            $OrderViewViewer->config_fields[$field] = $attrib;
        }
    }
    /*
     * Админка: Вызывается в моделе перед удалением элемента заказа
     */
    function onBeforeRemoveOrder(Event $event){//&$cid //=order_id
		
        return;
        $db = JFactory::getDBO();
        $query = "SELECT oi.order_item_id id, oi.order_item_id, oi.order_id, oi.product_id, oi.place_prices, oi.place_counts " // oi.places, 
                . " FROM #__jshopping_order_item oi "
                . " WHERE oi.order_id IN ( ".join(",",$cid)." ); ";
        $db->setQuery($query);
        $order_items = $db->loadObjectList();

        $ar = array();

        foreach ($order_items as $item) {
            $place_counts = json_decode($item->place_counts); //unserialize
            foreach ($place_counts as $prod_attr2_id => $place_count) {
                $ar[$item->product_id][$attr_id][] = $prod_attr2_id;
            }
        }
        $row_delete = 0; 
        foreach ($ar as $product_id => $attrs) {
            foreach ($attrs as $attr_id => $places) {
                $query = "DELETE FROM `#__jshopping_products_attr2`  "
                        . " WHERE product_id = $product_id AND attr_id = $attr_id "
                        . " AND attr_value_id IN (" . join(', ', $places) . ") ; ";
                $db->setQuery($query);
                $db->execute();
                $row_delete += $db->getAffectedRows();
            }
        }
        $text = JText::_('JSHOP_ORDER_DELETE_PLACES_1'). $row_delete . JText::_('JSHOP_ORDER_DELETE_PLACES_2');
        $app = JFactory::getApplication();
        $app->enqueueMessage($text, 'message'); 
        
        $msg = sprintf(JText::_('JSHOP_ORDER_DELETED_ID'), implode(", ", array_column($order_items, 'order_id')));
        $app->enqueueMessage($msg, 'message');
        
    }


    /**
     * При вызывается в котролере атрибуты при редактировании атрибута  
     * @param JViewLegacy $view
     * @param type $attribut
     */
    function onBeforeEditAtribut(Event $event){// &$view, &$attribut
        $view		= $event->getArgument(0);
		$attribut	= $event->getArgument(1);
		
		jimport( 'joomla.html.html.select' );
        JFormHelper::loadFieldClass('radio');
        jimport('joomla.form.helper');

//		if(is_null($attribut->attr_type)){
//			$attribut->attr_type=4; 
//			$attribut->independent=1;
//		}

        $types	 = [];
        $types[] = JHTML::_('select.option', '1','≡'.JText::_('JSHOP_INPUT_SELECT'),'attr_type_id','attr_type');
        $types[] = JHTML::_('select.option', '2','☼'.JText::_('JSHOP_INPUT_RADIO'),'attr_type_id','attr_type');
        $types[] = JHTML::_('select.option', '3','☺'.JText::_('JSHOP_INPUT_CHECKBOX'),'attr_type_id','attr_type');
        $types[] = JHTML::_('select.option', '4','♪'.JText::_('JSHOP_INPUT_CHECKBOX_PLACE'),'attr_type_id','attr_type');
//        $type_attribut = JHTML::_('select.genericlist', $types, 'attr_admin_type','class = "inputbox" size = "1"','attr_type_id','attr_type',($attribut->attr_admin_type?$attribut->attr_admin_type:$attribut->attr_type));
		$type_attribut = JHTML::_('select.genericlist', $types, 'attr_type','class = "inputbox" size = "1"','attr_type_id','attr_type', $attribut->attr_type );
//		$type_attribut = JHTML::_('select.genericlist', $types, 'attr_type','class = "inputbox" size = "1"','attr_type_id','attr_type',$attribut->attr_type);
//		$type_attribut = HTMLHelper::_('select.genericlist', SelectOptions::getAttributeType(), 'attr_type','class = "inputbox form-select"','attr_type_id','attr_type',$attribut->attr_type);
//		$view->type_attribut = $type_attribut;
		
		$view->set('type_attribut', $type_attribut); 
        
        
        $text_disabled = JText::_('JSHOP_PLACES_DISABLED');
        //$dependent = array();
        //$dependent[] = JHTML::_('select.option', '0', JText::_('JSHOP_YES'),'id','name');
        //$dependent[] = JHTML::_('select.option', '1', JText::_('JSHOP_NO'), 'id','name');
        //$attribs = array('class' => 'btn-group btn-group-yesno inputbox','hiddenLabel'=>true,'option.attr'=>' readonly ');//'class = "inputbox radio btn-group btn-group-yesno" title="'.JText::_('JSHOP_PLACES_DISABLED').'"  readonly size = "1"',
        //$dependent_attribut = JHTML::_('select.radiolist', $dependent, 'independent',$attribs, 'id','name', $attribut->independent);
        //disabled
        
        //$state[] = JHTML::_('select.option', '0', JText::_('JSHOP_YES'));
        //$state[] = JHTML::_('select.option', '1', JText::_('JSHOP_NO'));
        $attribs = array('class' => 'btn-group btn-group-yesno ','title'=>$text_disabled,'hiddenLabel'=>true);//inputbox, 'readonly'=>'readonly' //inputbox
        //$dependent_attribut = JHTML::_('select.booleanlist', 'independent', $attribs, $attribut->independent, JText::_('JSHOP_NO'), JText::_('JSHOP_YES'));
        $dependent_attribut = JHtmlSelect::booleanlist('independent',$attribs,$attribut->independent,'JSHOP_NO','JSHOP_YES');
        
        $dependent_attribut="<div style=' display: inline-block; position: relative;'>$dependent_attribut<div alt='$text_disabled' style='position: absolute; left:0; right: 0; top:0;bottom: 0; opacity:0.5; background: white;'></div></div>
                <style type='text/css'>#independent1,#independent0{width: auto;}</style>";
        
        //if(PlaceBiletAdminDev)JFactory::getApplication()->enqueueMessage("JHTML::_: $dependent_attribut<pre>".print_r($dependent_attribut, TRUE)."</pre>");
				
		$view->set('dependent_attribut', $dependent_attribut);
    }
    
    /**
     * Перед сохранением POST запроса Атрибута в базу админки.
     * @param object $post
     */
    function onBeforeSaveAttribut(Event $event){//&$post
        
//        if(PlaceBiletAdminDev)JFactory::getApplication()->enqueueMessage("POST: <pre>".print_r($post, TRUE)."</pre>");
                
        //JRoute::_(JSHelper::SEFLink('index.php?option=com_jshopping&controller=product&task=view&category_id='.$category_id.'&product_id='.$product_id,1,1));
    }
    
    /**
     * При вызове Атрибут который в админке создается новый или сохраняется в таблице.
     * @param JTable $attribut
     **/
    function onAfterSaveAttribut(Event $event){//&$attribut
		$attribut = $event->getArgument(0);
//        echo "<pre>Сохранение атрибута в базу: ";
//        var_dump($attribut->attr_type,$attribut->attr_id,$attribut->group);     
//        echo "</pre>"; 
        if ($attribut->attr_type==4){ //Изменено Добавлено условие && $attribut->attr_type!=4 
            //$query="ALTER TABLE `#__jshopping_products_attr` ADD `attr_".$attribut->attr_id."` INT( 11 ) NOT NULL";
            $query="SHOW COLUMNS FROM #__jshopping_products_attr LIKE 'attr_$attribut->attr_id'; ";
            $existColumn = JFactory::getDBO()->setQuery($query)->loadResult(); 
            
//toPrint($existColumn,'$existColumn',0,'message',true);
            if(empty($existColumn))                
                return;
            
            //$query="ALTER TABLE `#__jshopping_products_attr` ADD `attr_".$attribut->attr_id."` INT( 11 ) NOT NULL";
            //$query = "ALTER TABLE `#__jshopping_products_attr` ADD `attr_".$this->attr_id."` INT(11) NOT NULL";
			
            $query = "ALTER TABLE #__jshopping_products_attr DROP COLUMN `attr_$attribut->attr_id` ;  ";
//toPrint($query,'$query',0,'message',true); 
            JFactory::getDBO()->setQuery($query)->execute();
        }
    }
    
	/**
	* Админка: Переопределение метода удаления атрибутов в админке чтобы не было ошикби при удалении колонки
	* @param type $cid
	* @return type 
 */
    function onBeforeRemoveAttribut(Event $event ){//&$cid
		$cid = &$event->getArgument(0);
		
//		&$event->removeArgument($name);
		
//JFactory::getApplication()->enqueueMessage("plg3655 <pre>\$cid: ".print_r($cid, TRUE)."</pre>");
	
		if(!$cid)
            return;
		
        $db = JFactory::getDBO();
        $select = "SELECT  a.attr_id "//a.attr_type, a.attr_type,
                . "FROM `#__jshopping_attr` AS a "
                . "WHERE a.attr_id IN (". implode(',',$cid).") AND a.attr_type=4 ";
        $db->setQuery($select);
        $rows = $db->loadColumn();// loadAssocList('attr_id','attr_id');
		
		if(!$rows)
            return;
        
        $model = JSFactory::getModel('attribut');//JModelLegacy::getInstance('attribut');
        
//		toLog($rows,'$rows');
//		toLog($cid,'$cid');
        
        foreach ($cid as $i => $attr_id) {
            if(!in_array($attr_id, $rows)) {
                continue;
            }
//JFactory::getApplication()->enqueueMessage(" <pre>plg3676 \$cid: ".print_r($cid, TRUE)."</pre>");
			
			//toLog($attr_id,'$attr_id');
			//toLog($model,'$model');
			$model->deleteAttribute($attr_id);
			$model->deleteAttributeValues($attr_id);
			$model->deleteProductAttributeNotDependent($attr_id);
			
			unset ($cid[$i]);
        }
		$event->setArgument(0, $cid);
//JFactory::getApplication()->enqueueMessage(" <pre>plg3689 \$cid: ".print_r($cid, TRUE)."</pre>");
//JFactory::getApplication()->enqueueMessage(" <pre>plg3690 \$cid: ".print_r($rows, TRUE)."</pre>");
        
//	$db = JFactory::getDBO();
//	$query = "DELETE FROM `#__jshopping_attr` WHERE `attr_id`='".$db->escape($id)."'";
//	$db->setQuery($query);
//	$db->execute();
        
        
        
        //ALTER TABLE `#__jshopping_products_attr` DROP
        //        $query = "SELECT  FROM `#__jshopping_products_attr` 
        //        WHERE ".join(',',$cid)."
        //        FROM #__jshopping_products_attr2 pa2, #__jshopping_attr a 
        //          a.attr_id, a.attr_ordering, a.cats, a.`group` group_id, a.`".$lang->get('name')."` attr_name, a.`".$lang->get('description')."` attr_description, count(pa2.id) place_count 
//                            FROM #__jshopping_products_attr2 pa2, #__jshopping_attr a 
//                            WHERE  a.`attr_type`=4 AND  pa2.product_id=184 AND pa2.attr_id = a.attr_id  
//                            GROUP BY a.attr_id; ";
//        $db->setQuery($query); 
//        $attributes_place = $db->loadObjectList('attr_id');
        
        
//        if(PlaceBiletAdminDev)JFactory::getApplication()->enqueueMessage("POST: <pre>".print_r($post, TRUE)."</pre>");
        
        //JRoute::_(JSHelper::SEFLink('index.php?option=com_jshopping&controller=product&task=view&category_id='.$category_id.'&product_id='.$product_id,1,1));
    }    
    /**
     * 
     * @param JViewLegacy $view
     */
    function onBeforeShowOrderListView(Event $event){ //&$view
		$view = $event->getArgument(0);
        $view->addTemplatePath(PlaceBiletPath . '/templatesA/orders'); //Новый шаблон 
    }

    /**
     * При представление таблицы отображения товаров в админке. 
     * Вьювер при просмотре списка товаров 
     * @param JViewLegacy $view
     */
    function onBeforeDisplayListProductsView(Event $event){ //&$view // случается в конце работы контролера перед визуализацией представления
        
		$view = $event->getArgument(0);
		
        //$view->setLayout("default");//Имя файла
        $view->addTemplatePath(PlaceBiletPath . '/templatesA/product_list'); //Новый шаблон 
        $view->set('param',$this->params);//->toObject()
		
		$col_after_title = '<th width="60">';
		$col_after_title .= \JHTML::_( 'grid.sort', JText::_('JSHOP_DATE'), 'date_event', $view->get('filter_order_Dir',''), $view->get('filter_order',''));
		$col_after_title .= '</th>';
		
		$view->set('tmp_html_col_after_title', $col_after_title . $view->get('tmp_html_col_after_title',''));
//		$view->set('tmp_html_col_after_td_foot', '<td></td>' . $view->get('tmp_html_col_after_td_foot',''));
			
			
    
		$rows = &$view->get('rows');

		foreach ($rows as &$row){
			$row->date = $row->date_event;
//			$row->product_date_added = $row->date_event;
//			$displayData = [ ...((array)$row)
//				
//			];
//JFactory::getApplication()->enqueueMessage("\$row: <pre>".print_r($row, TRUE)."</pre>");
			$row->tmp_html_col_after_title .= JLayoutHelper::render('default_dateevent', (array)$row, $this->pluginPath . '/templatesA/product_list/');
		}
		
		
//		   echo JSHelper::formatdate($row->product_date_added, 1); 
		
//        if(PlaceBiletAdminDev)JFactory::getApplication()->enqueueMessage("Класс представления: ".print_r(get_class($view), TRUE));
//                ModuleHelper::getLayoutPath('mod_category_tags', '_childs');
//                $layoutAttr = [
//					'src'	=> $src,
//					'class' => 'tag-image ' . (empty($item->images->float_intro) ? $item->params->get('float_intro',false) : $item->images->float_intro),
//					'alt'	=> empty($item->images->image_intro_alt) && empty($item->images->image_intro_alt_empty) ? false : $item->images->image_intro_alt,
//				];

//				echo LayoutHelper::render('joomla.html.image', array_merge($layoutAttr, ['itemprop' => 'thumbnail',]));
//toPrint(000000000);
        //if(PlaceBiletAdminDev)JFactory::getApplication()->enqueueMessage("Класс представления: <pre>".print_r(($view->get('_layout')), TRUE)."<br>".print_r(($view->get('_layoutTemplate')), TRUE)."<br>".print_r(($view->get('_path')), TRUE)."</pre>");
                
    }
	
   /**
    * Админка Редактор категорий
    * @param JViewLegacy $view
    */
    function onBeforeEditCategories(Event $event){  //&$view
		$view = $event->getArgument(0);
        $view->addTemplatePath(PlaceBiletPath . '/templatesA/category'); //Новый шаблон 
		
		JToolBarHelper::title( ($view->category->category_id) ? (JText::_('JSHOP_EDIT_CATEGORY').' / '.$view->category->{JSFactory::getLang()->get('name')}) : (JText::_('JSHOP_NEW_CATEGORY')), 'generic.png' ); 
//		JToolBarHelper::save();
//		JToolBarHelper::spacer();
//		JToolBarHelper::apply();
//		JToolBarHelper::spacer();
//		JToolBarHelper::cancel();
	} 
   /**
    * Админка Список категорий
    * @param JViewLegacy $view
    */
    function onBeforeDisplayListCategoryView(Event $event){   //&$view
		$view = $event->getArgument(0);
        $view->addTemplatePath(PlaceBiletPath . '/templatesA/category'); //Новый шаблон 
		
		
//		JToolBarHelper::title( JText::_('JSHOP_TREE_CATEGORY'), 'generic.png' ); 
//		JToolBarHelper::addNew();
//		JToolBarHelper::publishList();
//		JToolBarHelper::unpublishList();
//		JToolBarHelper::deleteList();  
		
		
//        if(PlaceBiletAdminDev)
//            JFactory::getApplication()->enqueueMessage("Класс представления: ".print_r(get_class($view), TRUE));
                
//        if(PlaceBiletAdminDev)
//            JFactory::getApplication()->enqueueMessage("Класс представления: <pre>".print_r(($view->get('_layout')), TRUE)."<br>".print_r(($view->get('_layoutTemplate')), TRUE)."<br>".print_r(($view->get('_path')), TRUE)."</pre>");
    }
    
    function onJshoppingModelCategoriesGetTreeAllCategoriesBefore(Event $event){//&$modelCategories,&$variables
//        $modelCategories = $event->getArgument(0);
		$variables = $event->getArgument(1);
		
		$query = &$variables['query'];
        
//            JFactory::getApplication()->enqueueMessage("\$query: ".print_r($query, TRUE));
            
//        if((bool)$this->params->get('Zriteli_enabled', FALSE))
            $query = str_replace( 'SELECT ', 'SELECT RepertoireId, StageId,    ',$query);
    
            
//            JFactory::getApplication()->enqueueMessage("\$query: ".print_r($query, TRUE));
    }


    /**  
     * Админка - Данные для вьювера при редактировании товара
     **/  
    function onBeforeDisplayEditProduct(Event $event){// &$product, &$related_products, &$lists, &$listfreeattributes, &$tax_value
        
		$product			=  $event->getArgument('0');
//		$related_products	= &$event->getArgument('1');
//		$lists				= &$event->getArgument('2');
//		$listfreeattributes = &$event->getArgument('3');
//		$tax_value			=  $event->getArgument('4');
		
		
        //Колличество товаров безлимитно
        if( !isset($product->unlimited))
            $product->unlimited = TRUE;
        
        $product->unlimited = TRUE;
        
        
//        $product->product_price = 0;
        $product->product_price2 = 0;
        
        $product->product_is_add_price  = FALSE;
        $product->product_old_price = 0;
        $product->product_weight = 0;
        $product->product_quantity = 0;
        
          //onLoadJshopConfig
        $jshopConfig = JSFactory::getConfig();
        $jshopConfig->display_price_admin = 0;
                $jshopConfig->admin_show_weight = FALSE;
                $jshopConfig->stock = TRUE;
                $jshopConfig->admin_show_product_bay_price = FALSE;
				
				$jshopConfig->disable_admin['product_old_price'] = TRUE;
//				$jshopConfig->product_old_price = false;
				
//        toPrint($product,'$product');
//        toPrint($product->product_price,'$product->product_price');
        
//        $all_place_attributes = array();
//        $all_independent_attribs = array();
//        $all_independent_attributes = $lists['all_independent_attributes'];
//        //echo "<pre>".gettype($lists['all_independent_attributes'])." Counts \$lists['all_independent_attributes'] <br/>1:".count($lists['all_independent_attributes'] ).'<br/>2:';    
//        foreach($all_independent_attributes as $key => $ind_attr){
//            if($ind_attr->attr_type==4){
//                $all_place_attributes[] = $ind_attr;
//                //$values[]=
//                //$ind_attr = null;
//                //$lists['all_independent_attributes'][$key]=0; //new stdClass ();//null;
//                //clearVectorBullets();
//                
//                echo $key.', ' ;
//                
//                unset($all_independent_attributes[$key]);
//                //unset($ind_attr);
//            }
//            else{
//                $all_independent_attribs[] = $ind_attr;
//                //unset(  $lists['all_independent_attributes'][$key] );
//                
//            }
//        }
            //$view->asign('lists',)
//        echo ' '.count($all_independent_attributes).' ';
        //$lists['all_independent_attributes']=array();
        
//        echo "<pre>lists!!!  : ";
//        var_dump(count($all_independent_attributes));
//        echo "</pre>"; 
        
        
    }
    
	
	/**
	 * Админка, Запрос/Скрипт получения всех атрибутов/рядов
	 * @param type $attributeModel
	 * @param array $arrayVars
	 */
	public function onJoomlaComponentJshoppingAdministratorModelAttributModelGetAllAttributesBefore(Event $event) {//$attributeModel=null, &$arrayVars = []
		return;
//		$attributeModel = $event->getArgument(0);
		$arrayVars		= &$event->getArgument(1);
		
		//$attributeModel	Joomla\Component\Jshopping\Administrator\Model\AttributModel/
		//$arrayVars		ключи([result][categorys][order][orderDir][lang][db][ordering][query] )
		
		$arrayVars['query'] = str_replace( 'A.attr_type, ', 'A.attr_type, A.attr_admin_type,  ',$arrayVars['query']);
		
//		$event->setArgument(0, $attributeModel);
		$event->setArgument(1, $arrayVars);
		
		
//toPrint($query ,'$query',0,'message');
		
//toPrint(get_class( func_get_arg(0)),'onJoomlaComponentJshoppingAdministratorModelAttributModelGetAllAttributesBefore',0,'message');
//toPrint(array_keys ( func_get_arg(1)),'onJoomlaComponentJshoppingAdministratorModelAttributModelGetAllAttributesBefore',0,'message');
//toPrint(array_keys( func_get_args()),'onJoomlaComponentJshoppingAdministratorModelAttributModelGetAllAttributesBefore',0,'message');
	} 
	
	
    /** 
     * Админка - Данные в вьювере редактирования товара
     * Вьювер при редактировании товара 
     * @param JViewLegacy $viewProductEdit
     */
    function onBeforeDisplayEditProductView(Event $event){//onDisplayProductEditTabsTab(&$row, &$lists, &$tax_value)
//echo "<pre>Abra</pre>";
		
		$viewProductEdit	= &$event->getArgument(0);

//$alert = "<pre>onBeforeDisplayEditProductView()    ". print_r(get_class($viewProductEdit), true) ."</pre>";
//	\Joomla\CMS\Factory::getApplication()->enqueueMessage($alert);

        $viewProductEdit->addTemplatePath(PlaceBiletPath . '/templatesA/product_edit'); //Новый шаблон 
		
        if(PlaceBiletAdminDev)
            JFactory::getApplication()->enqueueMessage("Класс представления: <pre>".print_r(($view->get('_layout')), TRUE)."<br>".print_r(($view->get('_layoutTemplate')), TRUE)."<br>".print_r(($view->get('_path')), TRUE)."</pre>");
        
//return;
		$lists=$viewProductEdit->get('lists');
		

//    echo "<pre>count \$lists['all_independent_attributes']: ".count($lists['all_independent_attributes'])."<br>";
//    print_r($lists['all_independent_attributes']);
//    echo "</pre>";
		
         $jshopConfig = JSFactory::getConfig();
         //$jshopConfig->admin_show_attributes = FALSE;
         $all_place_attributes = [];
         $all_independent_attributes = [];
		 
		 
        $lists['all_place_attributes'] = [];
		
        foreach($lists['all_independent_attributes'] as $i => $ind_attr){
            if($ind_attr->attr_type == 4){
                $lists['all_place_attributes'][$i] = $ind_attr;
				unset($lists['all_independent_attributes'][$i]);
            }
        }
//		$lst_counts = [];
//		foreach($lists as $prop => $rows){
//			if(is_array($rows))
//			$lst_counts[$prop] =  count($rows);
//		}
//JFactory::getApplication()->enqueueMessage('<pre>plg3941 \$lists: '. print_r($lst_counts, TRUE).'</pre>');    
		
//JFactory::getApplication()->enqueueMessage('<pre>plg3961 \all_place_attributes: '. print_r($lists['all_place_attributes'], TRUE).'</pre>'); 
//JFactory::getApplication()->enqueueMessage('<pre>plg3961 \all_independent_attributes: '. print_r(array_slice($lists['all_independent_attributes'], 0,1) , TRUE).'</pre>');
		
        $jshopConfig->admin_show_attributes = count($lists['all_independent_attributes']) != 0;

		$viewProductEdit->set('lists', $lists);
		$event->setArgument(0, $viewProductEdit);
		
    }
	//onJoomlaComponentJshoppingAdministratorModelAttributModelGetAllAttributesBefore
    function onJshoppingModelAttributGetAllAttributesBefore(Event $event){//&$AttributeModel, &$vars
		return;
		$vars = $event->getArgument(1);
//extract(JSHelper::js_add_trigger(get_defined_vars(), "before")); // on + ClassName + MethodName + 'Before' 

//\Joomla\CMS\Factory::$application->enqueueMessage("<pre>!!!1111 ".print_r($vars['query'],true)."</pre>");
		
		$vars['query'] = str_replace( 'A.attr_type, ', 'A.attr_type, A.attr_admin_type,  ',$vars['query']);
		$event->setArgument(1, $vars);
		//echo "<pre>\$vars: ";
        //var_dump(array_keys($vars));     
		//var_dump($vars['query']); 
        //echo "</pre>"; 
	}
    // запрос получения значений из базы для атрубитов товара
//    function  onAfterQueryGetAttributes2(&$query){
//        if(PlaceBiletAdminDev)JFactory::getApplication()->enqueueMessage(print_r("\$query: ".$query, TRUE));    
//    }



    /**
     * При вызове из модели всех продуктов
     **/
    function onBeforeDisplayListProductsGetAllProducts(Event $event){//$model=null, &$query='', $filter=[], $limitstart=0, $limit=0, $order='', $orderDir=''
        //Zriteli::LoadAllProducts();
        $query = &$event->getArgument(1);
		
        $query = str_replace( 'pr.product_date_added,',  'pr.date_event, pr.date_tickets, pr.event_id, pr.product_date_added, pr.params, pr.RepertoireId, pr.StageId, ',$query);//pr.attr_type, 
        $query = str_replace( 'order by pr.product_date_added', 'order by pr.date_event ',$query);
		
//SELECT pr.product_id, pr.product_publish, pr.`name_ru-RU` as name, pr.`short_description_ru-RU` as short_description, man.`name_ru-RU` as man_name, pr.product_ean as ean, pr.product_quantity as qty, pr.image as image, pr.product_price, pr.currency_id, pr.hits, pr.unlimited, pr.date_event, pr.date_tickets, pr.event_id, pr.product_date_added, pr.params, pr.RepertoireId, pr.StageId, pr.attr_type,  pr.label_id, GROUP_CONCAT(cat.`name_ru-RU` SEPARATOR '
//') AS namescats FROM `omii_jshopping_products` AS pr
//LEFT JOIN `omii_jshopping_products_to_categories` AS pr_cat ON pr_cat.product_id=pr.product_id
//LEFT JOIN `omii_jshopping_categories` AS cat ON pr_cat.category_id=cat.category_id
//LEFT JOIN `omii_jshopping_manufacturers` AS man ON pr.product_manufacturer_id=man.manufacturer_id        
//WHERE pr.parent_id=0  
//GROUP BY pr.product_id order by pr.product_id asc  LIMIT 0, 100
		
		
//\Joomla\CMS\Factory::$application->enqueueMessage("<pre>plg4001 \$query".print_r($query,true)."</pre>");
		$event->setArgument(1, $query);
        
//toPrint($query,'$query', TRUE,'pre',true);
//        echo "<pre>Запрос получения всех товаров: ";
//        var_dump($query);     
//        echo "</pre>"; 
    }
    


    /**
     * Отображается список атрибутов в админке.
     * @param JViewLegacy $view
     */
    function onBeforeDisplayAttributes(Event $event){  //&$view
		$view = $event->getArgument(0);
		
		
        
		if($this->params->show_help_in_plugin)
			JFactory::getApplication()->enqueueMessage(JText::_('JSHOP_PLACE_BILET_INSTRUCTION'));
		
        $atributes = $view->get('rows');
        
        $db = JFactory::getDBO();
        $query = "SELECT a.attr_type, a.attr_id " //a.attr_admin_type, 
                . "FROM `#__jshopping_attr` AS a ";
        $db->setQuery($query);
        $rows = $db->loadObjectList('attr_id');
        
        foreach ($atributes as $attr){
            $a = $rows[$attr->attr_id];
            $sufix = ' ';
            switch ($a->attr_type){
                case 1:
                    $sufix .='≡';
                    break;
                case 2:
                    $sufix .='☼';
                    break;
                case 3:
                    $sufix .='☺';
                    break;
                case 4:
                    $sufix .='♪';
                    break;
                default:
                    break;
            }
            
            //$attr->name = $sufix.$attr->name;
            $attr->name .= $sufix;
        }
		$view->set('rows', $atributes); 
		
    }

//    /**
//     * Отображается список мест (переменных) атрибута в админке.
//     **/
//    function onBeforeDisplayAttributesValues(&$view){
//        
//        return;
//        
//        $file = JPATH_PLUGINS.'/jshoppingadmin/PlaceBiletAdmin/View/ViewEmpty.php';     
//        require_once( $file );
//        $view = new JshoppingViewEmpty(array());
//        //$view=$this->getView("attributesvalues", 'html');
//        $view->setLayout("list");
//        //$view->set('rows', $rows);        
//        //$view->set('attr_id', $attr_id);
//        //$view->set('config', $jshopConfig);
//        //$view->set('attr_name', $attr_name);
//        //$view->set('filter_order', $filter_order);
//        //$view->set('filter_order_Dir', $filter_order_Dir);
//        //$view->sidebar = JHtmlSidebar::render();
//        
////        echo "<pre>Сохранение атрибута в базу: ";
////        var_dump($view);     
////        echo "</pre>"; 
////        ["template_path"]=>     string(75) "/home/c/cirkbilet/naelke.su/public_html/components/com_jshopping/templates/"
////        ["default_template_block_list_product"]=>    string(31) "list_products/list_products.php"
////        ["default_template_no_list_product"]=>    string(29) "list_products/no_products.php"
////        ["default_template_block_form_filter_product"]=>    string(30) "list_products/form_filters.php"
////        ["default_template_block_pagination_product"]=>    string(34) "list_products/block_pagination.php"
////      array(2) 
////      [0]=>
////      string(109) "/home/c/cirkbilet/naelke.su/public_html/administrator/templates/red_isis/html/com_jshopping/attributesvalues/"
////      [1]=>
////      string(107) "/home/c/cirkbilet/naelke.su/public_html/administrator/components/com_jshopping/View/attributesvalues/tmpl/"
//    }


    /**
     * При вызове списка всех товаров в конролере 
     **/
//    function onBeforeDisplayListProducts(&$rows){
//        //
//        echo "<pre>Запрос получения всех товаров: ";
//        var_dump($rows[0]);     
//        echo "</pre>"; 
//    }
    //onJSFactoryGetTable
    //onAfterJSFactoryGetTable
    
    //onJSFactoryGetModel
    //onAfterJSFactoryGetModel
    /**
     * Вызывается перед вызовом Модели
     * @param type $type
     * @param type $prefix
     * @param type $config
     */
    function onJSFactoryGetModel(Event $event){//&$type, &$prefix, &$config&$type, &$prefix, &$config
		
//\Joomla\CMS\Factory::$application->enqueueMessage("<pre>".print_r($event,true)."</pre>");
		$type	=  $event->getArgument('0');
		$prefix =  $event->getArgument('1');
		$config =  $event->getArgument('2');
		
        //$is_model_mod = substr($type, -4) == "_mod";
        $is_model_mod = strpos($type,'_mod');
        
        $path = PlaceBiletPath."/models/";
        \JModelLegacy::addIncludePath($path, $prefix);
        
        if(strpos($type,'_mod'))
            $type = substr($type, -4); 
        
        $model_file = strtolower($type.".php");
        
        if(file_exists($path.$model_file)){
            require_once $path.$model_file;
            $type .= '_mod';
            
            //toPrint($type,'FileExist MODEL---!!!!!!!!');
        }
        
        //toPrint($path.$model_file,'$path.$model_file');
        //toPrint($type,'$type');
    }
    /**
     * Вызывается после создания модели
     */
    function onAfterJSFactoryGetModel(Event $event){//&$model, &$type, &$prefix, &$config
		
		$model	= &$event->getArgument('0');
		$type	=  $event->getArgument('1');
		$prefix =  $event->getArgument('2');
		$config = &$event->getArgument('3');

        //toPrint($type,'$type');
        //return;
         //toLog($model,'$model');
        //$is_model_mod = substr($type, -4) == "_mod";
        if(strpos($type,'_mod'))
            $type = substr($type, -4);
        
        
        
//        if(strpos($model->nameModel,'_mod'))
//            $model->nameModel = substr($model->nameModel, -4);
        
        $type = strtolower($type);
        //$model->nameModel = strtolower($model->nameModel);
        return;
        
        
        
        
        if(!$is_model_mod)
            return;
                
        $model = substr($type, 0, -4);
        $model_file = $model.".php";
        
        $path = PlaceBiletPath."/models/";
        $files = scandir ($path);
        
        foreach($files as $f => $file){
//            $first = substr($file, 0,1);
//            if($first == "." || $first == "_")
//                unset ($files[$f]); 
            if($model_file == $file){
                JModelLegacy::addIncludePath($path, $prefix);
                require_once $path.$model_file;
//                toPrint($path);
//                toLog($path,'$path');
//                JFactory::getApplication()->enqueueMessage($path, 'message'); 
                $class = "JshoppingModel$type";
                $model = new $class($config);
                $model->nameModel = strtolower($type);
            }
        }
    }
	
           
	
	
    function JshoppingControllerattributesvalues($methodController = "display")
    { 
    }
	
	
	
	function onLoadJshopUserGust(&$userGuest){
		
//toPrint($userGuest,'$userGuest', TRUE,'message',true);
	}
    function onLoadCheckoutStep2save(&$post){
//toPrint($post,'$post', TRUE,'message',true);
        //JLog::add('Test message!',array('PlaceBilet'));
        //if(PlaceBiletAdminDev)JFactory::getApplication()->enqueueMessage("POST: <pre>".print_r($postAdress, TRUE)."</pre>");
    }
	
	
	
	
	function onAfterSaveCheckoutStep2(Event $event){//&$adv_user, &$user, &$cart

//toPrint($config->displayprice,'$config->displayprice', TRUE,'pre',true);onAfterSaveCheckoutStep2
//toPrint($config->fields_client_only_check,'$config->fields_client_only_check', TRUE,'pre',true);
	}
	
    function onBeforeSaveCheckoutStep2(Event $event){//&$adv_user, &$user, &$cart, &$modelUseredit
//        if(PlaceBiletAdminDev)JFactory::getApplication()->enqueueMessage("\$adv_user: <pre>".print_r($adv_user, TRUE)."</pre>");
//        if(PlaceBiletAdminDev)JFactory::getApplication()->enqueueMessage("\$model: <pre>".print_r($modelUseredit, TRUE)."</pre>");
		
//        $style = JUri::root(). "/plugins/jshopping/placebilet/media/bilet.css";//JUri::root(). 
//        JHtml::stylesheet($style);
		
    }
    
    

	
	
    /**
     * 
     * @param JViewLegacy $view
     */
    function  onBeforeCreateTemplateOrderPartMail(Event $event){//&$view
		$view = $event->getArgument(0);
        $this->onBeforeCreateTemplateOrderMail($view);
    }
	
    /**
     * Макет отсылки письма
     * @param JViewLegacy $view
     */
    function  onBeforeCreateTemplateOrderMail(Event $event){ //&$view
		$view = $event->getArgument(0);
        $view->addTemplatePath(PlaceBiletPath . '/templates/checkout'); //Новый шаблон 
         
        foreach ($this->fields as $field=> $attrib){
            $view->config_fields[$field] = $attrib;
        } 
		
		$order = &$view->get('order');
		
		$order->templates = &$view->get('_path','')['template'];
		
	}
	
	/*
	 * Переименование Темы письма
	 * Вызов в: components\com_jshopping\Model\OrdermailModel.php OrderMailModel->getSubjectMail()
	 */
	function onJoomlaComponentJshoppingSiteModelOrderMailModelGetSubjectMailAfter(Event $event){//$orderMailModel, $, $order, $subject
	
//\Joomla\CMS\Factory::$application->enqueueMessage("<pre>".print_r($event,true)."</pre>");
		$orderMailModel = $event->getArgument('orderMailModel');
		$vars = $event->getArgument('vars', []);
//		$vars['type'];
//		$vars['order'];
//		$vars['subject'];
//		JFactory::getMailer();
//toPrint(array_keys(func_get_args()),'$order type:'.$type, 0,'message',true);
//toPrint(array_keys(get_object_vars($vars['order'])),'$order type:'.$vars['type'], 0,'message',true);
//toPrint($vars['subject'],'$subject type:'.$vars['type'], 0,'message',true);
//$order = $vars['order'];
//toPrint("order_number:$order->order_number / f_name:$order->f_name / l_name:$order->l_name ",'$order:subject type:'.$vars['type'], 0,'message',true);
	}
	
//	function onBeforeSendOrderEmailAdmin(&$mailer, &$order, &$manuallysend, &$pdfsend, &$vendor, &$vendors_send_message, &$vendor_send_order){
//	}
	
//	function onBeforeSendOrderEmailVendor(&$mailer, &$order, &$manuallysend, &$pdfsend, &$vendor, &$vendors_send_message, &$vendor_send_order){
//		
//	}
	
	
//	function onAfterSendEmailsOrder(&$order, &$orderMailModel, &$sendMailResult){
		
//	}
	
	/**
	 * Админ: Происходит при смене статуса заказа при оформлении заказа администратором
	 * @param type $order_id
	 * @param type $status
	 * @param type $status_id
	 * @param type $notify
	 * @param type $comments
	 * @param type $include_comment
	 * @param type $view_order
	 */
	function onBeforeChangeOrderStatusAdmin(Event $event){//$order_id = 0,$status = 0,$status_id = 0,	$notify = 1,$comments = '',	$include_comment = 0,$view_order = 0
		$order_id = $event->getArgument(0);
		$status_id = $event->getArgument(1);
		
		if(empty($order_id) || empty($status_id))
			return;
		
		$r = PlaceBiletHelper::deletePlaces($order_id, $status_id); 
//		toPrint($status,'$status '.($r?'True':'False'),0,'pre',true);
//		toPrint($status_id,'$status_id '.($r?'True':'False'),0,'pre',true);
//		toLog($status, '$status '.($r?'True':'False'), 'finish.txt','',true);
//		toLog( $status_id, '$status_id  '.($r?'True':'False'), 'finish.txt','',true);
	}

	/**
     * Происходит сохранения данных в модели категорий для администратора
     * Обновление каритнок и описани для продуктов из категории
     * @param JTable $category
     * @param array $post
     */
    function onAfterSaveCategory(Event $event){//MultilangTable &$category, &$post
        //toLog(2,'***');
        $category = $event->getArgument(0);
		
		Zriteli::UpdateInfoDescritpion($category->category_id);
    }

              
    function  onAfterUploadCategoryImage(Event $event){//&$post, &$fileName
        $post		= $event->getArgument(0);
		$fileName	= $event->getArgument(1);
        $lang ='name_'.(JFactory::getLanguage()->getTag());
        
        
        $s		= DIRECTORY_SEPARATOR;
        $Cat    = JPATH_ROOT . "{$s}components{$s}com_jshopping{$s}files{$s}img_categories{$s}";
        
        if($ext = strtolower(substr($fileName, -1,4)) == 'jpeg' ){
            $fn = substr ($fileName, 0, -5).'.jpg'; 
            if(rename($Cat.$fileName, $Cat.$fn))
                    $fileName = $fn;
        }
            
        $localizer = ucfirst(JFactory::getLanguage()->getTag().'Localise');
        
        if(class_exists( $localizer ))
            $NewName = ($localizer::transliterate($post[$lang]))."_".$fileName;
        else 
            $NewName = $fileName;
         
        $NewName = str_replace (array(" ","\"","'","`","\\","/","+","*","^","%","№","#","$","₽","&","@","#","—","|","«","»","?","!",":",
            "(",")","<",">","[","]","{","}"),"_",$NewName);
        $NewName = preg_replace('/[_]{2,}/', '_', $NewName);
        
        
        //toLog($post);
        
        $fileCat = $Cat . "$fileName"; 
        $fileNew = $Cat . "$NewName"; 
    
        rename($fileCat, $fileNew);
          
        $fileName = $NewName;
        
        //Zriteli::filecopy($fileCat, '', FALSE, TRUE);
        //Zriteli::filecopy($NewName);
        $image_prod = PlaceBiletHelper::imageCopyToProductFolder($NewName);
        //toLog($NewName,'$fileNew');
        
        //JFactory::getApplication()->enqueueMessage("cat_image = ".$fileNew, 'message');
        
        JFactory::getApplication()->enqueueMessage("image = ".$image_prod, 'message');
//        JFactory::getApplication()->enqueueMessage("<pre>$lang ".print_r($post,TRUE)."</pre>", 'message');
    }
	
    /**
     *  
     * @param array $post
     * @param string $category_image
     * @param string $path_full
     * @param string $path_thumb
     */
    function onAfterSaveCategoryImage(Event $event){//&$post, &$category_image, &$path_full, &$path_thumb
        //Zriteli::UpdateInfoDescritpion($category->category_id);
        ///lagnuage/ru-RU/ru-RU.localise.php (+ administrator/lagnuage/ru-RU/ru-RU.localise.php)
        //Zriteli::filecopy($fileName, $newName, $overWrite, $OnlyFullImage);
//        ru_RULocalise::
    }


    
    //index.php?option=com_ajax&plugin=JshoppingPlaceBilet&format=raw&var1... 
    function getAjax(){
        
    }
    function onAjaxPlaceBilet(){
        
    }
    /**
     * 
     * @param JViewLegacy $view
     */
    function onBeforeDisplayLoginView(Event $event){//&$view
//                $path = JPATH_PLUGINS.'/jshoppingplacebilet';            
//	$language = JFactory::getLanguage();
//        $language->load('placebilet', $path, 'ru-RU', TRUE);
    }
    
    /**
     * Главная страница ОПЦИЙ
     * @param type $menu
     */
    function onBeforeAdminOptionPanelIcoDisplay(Event $event){//&$menu
		$menu = $event->getArgument(0);
//        define('_JSHOP_PANEL_ROWS', JText::_('JSHOP_PANEL_ROWS'));
        //JSHOP_PANEL_ROWS - Ряды
        //JSHOP_PANEL_SHOWING_EXTRA_FIELDS - Характеристики представления
        //JSHOP_PANEL_SHOWING - Представления
        //JSHOP_PANEL_SHOWING_LABELS - Метки представлений
        $menu['attributes'] = [JText::_('JSHOP_PANEL_ROWS'), 'index.php?option=com_jshopping&controller=attributes', 'jshop_attributes_b.png', 1];
        $menu['productfields'] = [JText::_('JSHOP_PANEL_SHOWING_EXTRA_FIELDS'), 'index.php?option=com_jshopping&controller=productfields', 'jshop_charac_b.png', $jshopConfig->admin_show_product_extra_field ?? ''];
        $menu['productlabels'] = [JText::_('JSHOP_PANEL_SHOWING_LABELS'), 'index.php?option=com_jshopping&controller=productlabels', 'jshop_label_b.png', $jshopConfig->admin_show_product_labels ?? ''];
        $menu_add = [];
        $menu_add['groups'] = [ JText::_('JSHOP_PANEL_GROPUS'), 'index.php?option=com_jshopping&controller=attributesgroups', 'jshop_mein_page_b.png', 1];
        array_splice($menu, array_search('attributes', array_keys($menu))+1, 0, $menu_add);
    }


    /**
     * Верхняя панель ОПЦИЙ
     * @param type $menu
     */
    function onBeforeAdminOptionPanelMenuDisplay(Event $event){//&$menu
		$menu = $event->getArgument(0);
//        define('_JSHOP_PANEL_ROWS', JText::_('JSHOP_PANEL_ROWS'));
        //JSHOP_PANEL_ROWS - Ряды
        //JSHOP_PANEL_SHOWING_EXTRA_FIELDS - Характеристики представления
        //JSHOP_PANEL_SHOWING - Представления
        //JSHOP_PANEL_SHOWING_LABELS - Метки представлений
        $menu['attributes'] = [JText::_('JSHOP_PANEL_ROWS'), 'index.php?option=com_jshopping&controller=attributes', 'jshop_attributes_b.png', 1];
        $menu['productfields'] = [JText::_('JSHOP_PANEL_SHOWING_EXTRA_FIELDS'), 'index.php?option=com_jshopping&controller=productfields', 'jshop_charac_b.png', 
			$jshopConfig->admin_show_product_extra_field ?? false];
        $menu['productlabels'] = [JText::_('JSHOP_PANEL_SHOWING_LABELS'), 'index.php?option=com_jshopping&controller=productlabels', 'jshop_label_b.png', 
			$jshopConfig->admin_show_product_labels ?? false];
        $menu_add = [];
        $menu_add['groups'] = [ JText::_('JSHOP_PANEL_GROPUS'), 'index.php?option=com_jshopping&controller=attributesgroups', 'jshop_mein_page_b.png', 1];
        array_splice($menu, array_search('attributes', array_keys($menu))+1, 0, $menu_add);
    }
    /**
     * Стартовая панель магазина
     * @param type $menu
     */
    function onBeforeAdminMainPanelIcoDisplay(Event $event){//&$menu
		$menu = $event->getArgument(0);
//        define('_JSHOP_PANEL_ROWS', JText::_('JSHOP_PANEL_ROWS'));
        //JSHOP_PANEL_ROWS - Ряды
        //JSHOP_PANEL_SHOWING_EXTRA_FIELDS - Характеристики представления
        //JSHOP_PANEL_SHOWING - Представления
        //JSHOP_PANEL_SHOWING_LABELS - Метки представлений
        
        JFactory::getLanguage()->load('com_admin',JPATH_ADMINISTRATOR);
        JFactory::getLanguage()->load('com_plugins',JPATH_ADMINISTRATOR);
        //C:\Downloads\OpenServer\OSPanel\domains\localhost\joomla\administrator\language\ru-RU\ru-RU.com_admin.ini
        
//toPrint( );
//echo "5555555";
        $menu['products']	= [JText::_('JSHOP_PANEL_SHOWING'), 'index.php?option=com_jshopping&controller=products&category_id=0', 'jshop_products_b.png', 1];
//		$menu['test']		= [JText::_('Test WOrk'), 'index.php?option=com_jshopping&controller=products&category_id=0', 'jshop_products_b.png', 1];
        
        $menu_add = [];
        $menu_add['attributes'] = [JText::_('JSHOP_PANEL_ROWS'), 'index.php?option=com_jshopping&controller=attributes', 'jshop_attributes_b.png', 1];
        //$menu_add['productfields'] = [JText::_('JSHOP_PANEL_SHOWING_EXTRA_FIELDS'), 'index.php?option=com_jshopping&controller=productfields', 'jshop_charac_b.png', $jshopConfig->admin_show_product_extra_field];
        $menu_add['groups'] = [ JText::_('JSHOP_PANEL_GROPUS'), 'index.php?option=com_jshopping&controller=attributesgroups', 'jshop_mein_page_b.png', 1];
        
        array_splice($menu, 2, 0, $menu_add);
        $menu_add = [];
		
        $menu_add['modules_cat'] = [ JText::_('COM_ADMIN_HELP_MODULES').' Cat', 'index.php?option=com_modules&filter[module]=mod_jshopping_categories', 'jshop_options_b.png', 1];
        
        $menu_add['plugins'] = [ JText::_('COM_PLUGINS_PLUGIN').' PlaceBilet', 'index.php?option=com_plugins&view=plugins&filter[folder]=jshopping', 'jshop_general_b.png', 1];
		$menu_add['statistics'] = [ JText::_('JSHOP_PLACE_BILET_STATISTICS'), 'index.php?option=com_jshopping&controller=statistics', 'jshop_stats_b.png', 1];
		
		$tagLang = \Joomla\CMS\Factory::getLanguage()->getTag();
		$fileInstruction = $this->pluginPath . "/language/$tagLang/instruction.html";
		if(file_exists($fileInstruction) && filesize($fileInstruction))
			$menu_add['instruction'] = [ JText::_('JSHOP_PANEL_INSTRUCTION'), 'index.php?option=com_jshopping&controller=instruction', 'mail.png', 1];
		
		
//		$tagLang = \Joomla\CMS\Factory::getLanguage()->getTag();
//		$fileInstruction = $this->pluginPath . "/language/$tagLang/instruction.html";
//		if(file_exists($fileInstruction) && filesize($fileInstruction))
//			$menu['instruction'] = [ JText::_('JSHOP_PANEL_INSTRUCTION'), 'index.php?option=com_jshopping&controller=instruction', $images.'mail.png', 1];
		
        array_splice($menu, -1, 0, $menu_add);
//toPrint($menu_add,'$menu',0,'message',true);
//toPrint($menu_add,'$menu',0,'message',true);
    }
    /**
     * Боковая левая панель-Меню Админки
     * @param type $menu
     */
    function onBeforeAdminMenuDisplay(Event $event){//&$menu, $vName = ''
		$menu = $event->getArgument(0);
		$vName = $event->getArgument(1);
//        define('_JSHOP_PANEL_ROWS', JText::_('JSHOP_PANEL_ROWS'));
        //JSHOP_PANEL_ROWS - Ряды
        //JSHOP_PANEL_SHOWING_EXTRA_FIELDS - Характеристики представления
        //JSHOP_PANEL_SHOWING - Представления
        //JSHOP_PANEL_SHOWING_LABELS - Метки представлений
        
        if(PlaceBiletHelper::JInput('ajax',FALSE))
            return;
        
        
        if(PlaceBiletHelper::JInput('task',FALSE) == 'printOrder')
            return;
		
		
        $count_line = JText::_('VER');
        $config_line = $this->params->get(strtolower($count_line), str_replace(['.',',','-'],'',"3.7,7-2.1.9-9.4.4.4")); 
        if(empty($this->params->get('panel_new',true)) && str_replace(['.',',','-'],'',$config_line) != str_replace(['.',',','-'],'',"3.7,7-2.1.9-9.4.4.4"))
            return;
        
        $s = '/';// DIRECTORY_SEPARATOR;
        $images = JUri::root().'/administrator/components/com_jshopping/images/';
//        $images = JUri::root()."plugins{$s}jshopping{$s}PlaceBilet{$s}media{$s}images{$s}";
//toPrint();		
//toPrint($menu,'$menu',0,'message',true);
        
        foreach ($menu as $type => &$item ){
            $item['type'] = $type;
            $item[2] = $images."jshop_{$type}_b.png";
        }
        
//        $query = " SELECT template FROM #__template_styles WHERE home=1 AND client_id=0; ";
//        $this->template_name = $this->getApplication()->getTemplate(); // 
		$plugin_id = JFactory::getDBO()->setQuery("SELECT extension_id FROM #__extensions WHERE type = 'plugin' AND element='placebilet'; ")->loadResult(); 
        
		
        $menu['categories'] = array(\JText::_('JSHOP_MENU_CATEGORIES'), 'index.php?option=com_jshopping&controller=categories&catid=0', $images.'jshop_categories_b.png', 1);
//		$menu['products'] = ['Проверка', 'index.php?option=com_jshopping&controller=products&category_id=0', $images.'jshop_products_b.png', 1, 'type'=>'testing'];

		
        $menu['products'] = array(JText::_('JSHOP_PANEL_SHOWING'), 'index.php?option=com_jshopping&controller=products&category_id=0', $images.'jshop_products_b.png', 1,'type'=>'products');
        $menu['other'] = array(JText::_('JSHOP_MENU_OTHER'), 'index.php?option=com_jshopping&controller=other', $images.'jshop_options_b.png', 1,'type'=>'other');
        $menu['config'] = array(JText::_('JSHOP_MENU_CONFIG') , 'index.php?option=com_jshopping&controller=config', $images.'jshop_configuration_b.png', 1,'type'=>'config' );
//        $menu['plugin'] = array(JText::_('JPLUGIN') , 'index.php?option=com_plugins&task=plugin.edit&extension_id='.$plugin_id, $images.'jshop_general_b.png', 1,'type'=>'plugin' );
    
        $menu_add = [];
		
        $menu_add['attributes'] = [JText::_('JSHOP_PANEL_ROWS'), 'index.php?option=com_jshopping&controller=attributes', $images.'jshop_attributes_b.png', 1,'type'=>'attributes'];
        //$menu_add['productfields'] = [JText::_('JSHOP_PANEL_SHOWING_EXTRA_FIELDS'), 'index.php?option=com_jshopping&controller=productfields', 'jshop_charac_b.png', $jshopConfig->admin_show_product_extra_field];
        $menu_add['groups'] = [JText::_('JSHOP_PANEL_GROPUS'), 'index.php?option=com_jshopping&controller=attributesgroups', $images.'jshop_mein_page_b.png', 1,'type'=>'groups'];
        $menu_add['orders'] = array( \JText::_('JSHOP_MENU_ORDERS'), 'index.php?option=com_jshopping&controller=orders', $images.'jshop_orders_b.png', 1);
		
        $menu_add['users'] = array(\JText::_('JSHOP_MENU_CLIENTS'), 'index.php?option=com_jshopping&controller=users', $images.'jshop_users_b.png', 1);
        array_splice($menu, 2, 0, $menu_add);
        $menu_add = ['jshopping' => [ JText::_('JSHOP_OC_CART_BACK_TO_SHOP_HOME'), 'index.php?option=com_jshopping', JUri::root()."plugins{$s}jshopping{$s}placebilet{$s}media{$s}images{$s}shop.png", 1,'type'=>'jshopping']];
        array_splice($menu, 0, 0, $menu_add);
		
		$menu_add = ['statistics' => [JText::_('JSHOP_PLACE_BILET_STATISTICS'), 'index.php?option=com_jshopping&controller=statistics', $images.'jshop_stats_b.png', 1]];
        array_splice($menu, -2, 0, $menu_add);
//toPrint($menu_add,'$menu',0,'message',true);
		
		$tagLang = \Joomla\CMS\Factory::getLanguage()->getTag();
		$fileInstruction = $this->pluginPath . "/language/$tagLang/instruction.html";
		if(file_exists($fileInstruction) && filesize($fileInstruction))
			$menu['instruction'] = [ JText::_('JSHOP_PANEL_INSTRUCTION'), 'index.php?option=com_jshopping&controller=instruction', $images.'mail.png', 1];
		
        
//		echo "Hello!";
        jimport('cms.view.legacy');
        jimport('legacy.view.legacy');
        
        $ds = DIRECTORY_SEPARATOR;
        $template = PlaceBiletPath."/templatesA/panel/sidebar.php";
//        toPrint(file_exists($template),'file_exists');
        
//        toPrint($template,'$template');
        jimport( 'joomla.application.component.view' );
        
         JLayoutHelper::render($template);
         
        
        $view = new JViewLegacy([
            'name' => 'panel', 
            'layout'=>'sidebar',
            'base_path' => PlaceBiletPath,
            //'template'=>PlaceBiletPath."{$ds}templatesA{$ds}panel{$ds}sidebar.php",
            'template_path'=>PlaceBiletPath."{$ds}templatesA{$ds}panel"
            ]); //, 
        //$view->setLayout("sidebar");//Имя файла php
        $view->menu = &$menu;
        try {
            $view->display();
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }

//        toPrint($view,'$view');
        
//        $files = new SplPriorityQueue();
//        $files->insert($files, $view);
//        $html = new JViewHtml(NULL);
//        $html->setLayout('sidebar');
//        $view->loadTemplate($template);
        
        
        $menu = [];
    }
//http://localhost/joomla/administrator/index.php?option=com_jshopping
    
    /**
     * Замена страницы Инфы Администратора
     * @param JViewLegacy $viewInfo
     */
    function onBeforeDisplayInfo(Event $event){//$viewInfo
        $viewInfo = $event->getArgument(0);
		
        $count_line = JText::_('VER');
        $config_line = $this->params->get(strtolower($count_line), str_replace(['.',',','-'],'',"3.7,7-2.1.9-9.4.4.4")); 
        if(empty($this->params->get('panel_new',true)) && str_replace(['.',',','-'],'',$config_line) != str_replace(['.',',','-'],'',"3.7,7-2.1.9-9.4.4.4"))
            return;
        
        
        $viewInfo->addTemplatePath(PlaceBiletPath.'/templatesA/panel');//Новый шаблон
        
        //$viewCart->addTemplatePath(PlaceBiletPath.'/templates/cart');//Новый шаблон
        $viewInfo->addTemplatePath(JPATH_BASE."/templates/$this->template_name/html/com_jshopping/panel/"); //Новый шаблон   
				
		if(JVersion::MAJOR_VERSION == 3){
			$viewInfo->assign('param', $this->params);
        }else{
			$viewInfo->set('param', $this->params);
		} 
//        toPrint($viewInfo->get('_path'),'$viewInfo',0);
//        toPrint($viewInfo->get('data'),'$viewInfo',0);
    }
	
    /**
     * Замена главной страницы Администратора
     * @param JViewLegacy $viewPanel
     */
    function onBeforeDisplayHomePanel(Event $event){//$viewPanel
        $viewPanel = $event->getArgument(0);
//toPrint($this->params,'$this->params',0,'message',true);
        $count_line = JText::_('VER');
        $config_line = $this->params->get(strtolower($count_line), str_replace(['.',',','-'],'',"3.7,7-2.1.9-9.4.4.4"));
        if(empty($this->params->get('panel_new',true)) && str_replace(['.',',','-'],'',$config_line) != str_replace(['.',',','-'],'',"3.7,7-2.1.9-9.4.4.4"))
            return;
        
		if(JVersion::MAJOR_VERSION == 3){
			$viewPanel->assign('param', $this->params);
        }else{
			$viewPanel->set('param', $this->params);
		}  
        $viewPanel->addTemplatePath(PlaceBiletPath.'/templatesA/panel');//Новый шаблон
        
        //$viewCart->addTemplatePath(PlaceBiletPath.'/templates/cart');//Новый шаблон
        $viewPanel->addTemplatePath(JPATH_BASE."/templates/$this->template_name/html/com_jshopping/panel/"); //Новый шаблон   
//        toPrint($viewInfo->get('_path'),'$viewPanel',0);
//        toPrint($viewInfo->get('data'),'$viewPanel',0);
        
//		$document = $this->getApplication()->getDocument();
//		$viewType = $document->getType();
//		$viewName = $this->input->get('view', $this->default_view);
//		$viewLayout = $this->input->get('layout', 'default', 'string');
//		$view = $this->getView($viewName, $viewType, '', ['base_path' => $this->pluginPath, 'layout' => $viewLayout]);
        
//        toPrint($this->params->get('site_plugin'),'$this->params');
    }
    public function onGetIcons(Event $event){//$context
        $context = $event->getArgument(0);
//        return [];
//        toPrint($list_links,'$list_links',0);
        
        $links = [];
        
        $links[]  = [
            'link'  => 'index.php?option=',// 'index.php?option=com_jshopping',
            'image' => 'featured',
            'icon'  => 'header/icon-48-credit.png',
            'text'  => JText::_(' &#9733; '. JText::_('JCategory')),
            'id'    => 'plgJshoppingPlaceBilet_25',
            'access'=> '',//array('core.manage', 'com_jshopping'),
            'group' => 'MOD_QUICKICON_EXTENSIONS'
            ];
        return $links;
    }
	
    /**
     * Страница выбора способа оплаты.
     * @param JViewLegacy $viewcheckout
     */
    public function onBeforeDisplayCheckoutStep3View(Event $event){//&$viewcheckout
        $viewcheckout = $event->getArgument(0);
        $viewcheckout->checkout_navigator = "<h1>".JText::_('JSHOP_STEP_ORDER_3')."</h1>".$viewcheckout->checkout_navigator;
//        $viewcheckout->checkout_navigator = "<h1>"._JSHOP_STEP_ORDER_4.JText::_('')."</h1>".$viewcheckout->checkout_navigator;
        
//toPrint(null, '', 0, '', true);
        $payment_methods    = $viewcheckout->get('payment_methods');
        $active_payment     = $viewcheckout->get('active_payment');
        $checkout_navigator = $viewcheckout->get('checkout_navigator');
        $small_cart         = $viewcheckout->get('small_cart');
        $action             = $viewcheckout->get('action'); // url
		
//		$paymentsIDs = array_column($payment_methods, 'payment_id');
        
//toPrint(array_keys(get_object_vars ($viewcheckout)), '$payment_methods', 0, 'message', true);
//toPrint(array_keys(get_object_vars ($payment_methods[1])), '$payment_methods 0', 0, 'message', true);
//toPrint(array_keys($payment_methods), '$payment_methods', 0, 'message', true);
//toPrint(($active_payment), '$active_payment', 0, 'message', true);
//toPrint(($small_cart), '$small_cart', 0, 'message', true);


//        $checkout = \JSFactory::getModel('checkoutOrder', 'Site');

        $cart = \JSFactory::getModel('cart', 'Site');
        $cart->load();
//toPrint(array_keys(get_object_vars ($cart)), '$cart', 0, 'message', true);
//toPrint($cart->products, '$cart->products', 0, 'message', true);

		$prodIDs = [];
		
		$countProducts = count($cart->products);
		$countPushkaProducts = 0;

//toPrint(($cart->products), '$cart->products', 0, 'message', true);
		foreach ($cart->products as $prod){
			$countPushkaProducts += ($prod['place_pushka'] && $prod['event_id'] > 0) ? 1 : 0;
			//event_id
			//place_pushka
			//product_id
//			$prodIDs[$prod->product_id] = (object)['event_id'=>$prod->event_id,'place_pushka'=>$prod->place_pushka,'paymentPushka'=>($prod->event_id>0&&$prod->place_pushka)];
		}
		$paymentPushka = $countProducts == $countPushkaProducts && $this->params->pushka_mode;
		$paymentWithoutPushka = 0 == $countPushkaProducts && $this->params->pushka_mode;
//toPrint(($countPushkaProducts), '$countPushkaProducts', 0, 'message', true);
//toPrint(($countProducts), '$countProducts', 0, 'message', true);
		
//toPrint(($this->params->pushka_pays), '$this->params->pushka_pays', 0, 'message', true);
//toPrint(($paymentPushka), '$paymentPushka По ПУшке', 0, 'message', true);
//toPrint(($paymentWithoutPushka), '$paymentPushka Без Пушки', 0, 'message', true);
//toPrint(($paymentWithoutPushka), '$paymentWithoutPushka', 0, 'message', true);
//		$this->params->pushka_pays;
//		$this->params->nopushka_pays;
		
		$new_payments= [];
		$new_active_payment = false;
		
		// Покупка по ПушКарте
		if($paymentPushka && is_array($this->params->pushka_pays)){
			foreach ($payment_methods as $i => $pm){
				if(in_array($pm->payment_id, $this->params->pushka_pays)){
					$new_payments[$pm->payment_id] = $pm;
				}elseif(in_array($pm->payment_id, $this->params->only_pushka_pays)){
					$new_payments[$pm->payment_id] = $pm;
				}else{
//					unset($payment_methods[$i]);
				}
			}
			if(!in_array($active_payment, $this->params->pushka_pays) && $new_payments )
				$active_payment = $new_payments[0]->payment_id;
				
		}
		// Покупка без ПушКарты
		if($paymentWithoutPushka && is_array($this->params->only_pushka_pays) && $this->params->only_pushka_pays != [0]){
			foreach ($payment_methods as $i => $pm){
				if(in_array($pm->payment_id, $this->params->only_pushka_pays)){
//					unset($payment_methods[$i]);
				}elseif(in_array($pm->payment_id, $this->params->pushka_pays)){
//					$new_payments[$pm->payment_id] = $pm;
				}else{
					$new_payments[$pm->payment_id] = $pm;
				}
			}
			if(!in_array($active_payment, $this->params->only_pushka_pays) && $new_payments )
				$active_payment = $new_payments[0]->payment_id;
		}
		if(empty($new_payments)){
			$new_payments = $payment_methods;
		}
		if(empty($new_payments[$active_payment]) && $new_payments){
			$active_payment = (reset($new_payments))->payment_id;
		}
		
//toPrint(($active_payment), '$active_payment', 0, 'message', true);
		
		
		if($this->params->pushka_mode && ($paymentPushka || $paymentWithoutPushka))
			$viewcheckout->set('active_payment', $active_payment);
		
		if($this->params->pushka_mode)
			$viewcheckout->set('payment_methods',$new_payments);
        
//define('_JSHOP_STEP_ORDER_2', 'Адрес');
//define('_JSHOP_STEP_ORDER_3', 'Способ оплаты');
//define('_JSHOP_STEP_ORDER_4', 'Способ доставки');
//define('_JSHOP_STEP_ORDER_5', 'Подтвердить заказ');
    }
	
    /**
     * Добавление заголовка к странице выбора способа доставки.
     * @param JViewLegacy $viewcheckout
     */
    public function onBeforeDisplayCheckoutStep4View(Event $event){//&$viewcheckout
        $viewcheckout = $event->getArgument(0);
		$viewcheckout->checkout_navigator = "<h1>".JText::_('JSHOP_STEP_ORDER_4')."</h1>".$viewcheckout->checkout_navigator; 
    }
	
    /**
     *  
     * @param JshoppingControllerCheckout $controllerCheckout
     */
    public function onConstructJshoppingControllerCheckout(Event $event){//&$controllerCheckout
		$controllerCheckout = $event->getArgument(0);
		
        //
        $path = PlaceBiletPath . '/templates/checkout/'; //Новый шаблон 
        $controllerCheckout->addViewPath($path);
//        toPrint($controllerCheckout->getName(),'name');
//        toPrint($controllerCheckout->getTask(),'task'); 
//        toPrint($controllerCheckout->getTask(),'task'); 
        $view = $controllerCheckout->getView('checkout');//     JshoppingViewCheckout 
        $view->addTemplatePath($path);
//        toPrint($view,'$viewCreate');
        //$viewName= $controllerCheckout->input->get('view', $this->default_view);
        //toPrint($viewName,'$viewName');
        //
    }
          
    /**
     *  Перед сохранением Продукта в редакторе админки
     * Изменяем имена загруженных картинок на уникальные
     * @param type $post
     * @param type $product
     */
    public function  onBeforeDisplaySaveProduct (Event $event){//&$post, &$product
//        $post		= $event->getArgument(0);
//        $product	= $event->getArgument(1);
		
        JSFactory::getConfig()->user_as_catalog = 1;
	}
	

	
	public function onAfterSaveProduct(Event $event){//onAfterSaveProduct
//		$product		= $event->getArgument(0);
	}
	public function onAfterSaveProductFolerImage(Event $event){//$product_id, $name_full, $name_image, $name_thumb
//		$product_id		= $event->getArgument(0);
//		$name_full		= $event->getArgument(1);
//		$name_image		= $event->getArgument(2);
//		$name_thumb		= $event->getArgument(3);
	}
	
    /**
     * Перед сохранением Категории в редакторе админки
     * <b>Изменяем имена загруженных картинок на уникальные</b>
     * @param type $post
     */
    public function onBeforeSaveCategory(Event $event) { //&$post
//		$post		= $event->getArgument(0);
    }



	
	// <editor-fold defaultstate="collapsed" desc="Страница настроек компонента">

	/**
	 * Перед выводом редактора конфигурации(Первая вкладка ФУНКЦИИ МАГАЗИНА)
	 */
	public function onBeforeEditConfigAdminFunction(&$view) {
		
        $view->stock = TRUE;				// склад
        $view->without_shipping = TRUE; // Доставка
        $view->enable_wishlist = FALSE;		// Включить список пожеланий
		
		JFactory::getApplication()->getDocument()->addScriptDeclaration("
jQuery(function(){ /* Plugin PlaceBilet */
			document.getElementsByName('stock')[1].disabled = true;
			document.getElementsByName('without_shipping')[1].disabled = true;
			document.getElementsByName('enable_wishlist')[1].disabled = true;
				
Object.keys(adminForm.stock).forEach(function(key, index) {
  adminForm.stock[key].disabled = true; adminForm.stock[key].readOnly = true;
});
Object.keys(adminForm.without_shipping).forEach(function(key, index) {
  adminForm.without_shipping[key].disabled = true; adminForm.without_shipping[key].readOnly = true;
});
Object.keys(adminForm.enable_wishlist).forEach(function(key, index) {
  adminForm.enable_wishlist[key].disabled = true; adminForm.enable_wishlist[key].readOnly = true;
});
			});");
	}

	/**
	 * Перед выводом редактора конфигурации(Вторая вкладка ОСНОВНОЕ)
	 */
	public function onBeforeEditConfigGeneral(&$view) {
		
	}

	/**
	 * Перед выводом редактора конфигурации(Третья вкладка ТОВАР)
	 */
	public function onBeforeEditConfigCatProd(&$view) { 
        $view->show_plus_shipping_in_product = 0;	// Показать "плюс доставка"
        $view->hide_buy = 0;		// Скрыть Кнопку КУПИТЬ
        $view->set('hide_buy',0);	// Скрыть Кнопку КУПИТЬ
        $view->show_delivery_time = 0;				// Показать "Срок поставки"    
        $view->product_show_weight = 0;				//Показать вес товара
        $view->hide_product_not_avaible_stock = FALSE;	// Скрыть товары, которые не доступны на складе 
		$view->hide_buy_not_avaible_stock = FALSE;		//Скрыть кнопку купить, если товара нет на складе
        $view->hide_text_product_not_available = TRUE; // Скрыть текст "Товар не доступен"	
//toPrint($view->hide_buy_not_avaible_stock,'$view->hide_buy_not_avaible_stock',0,'message');
		
		JFactory::getApplication()->getDocument()->addScriptDeclaration("
jQuery(function(){ /* Plugin PlaceBilet */
document.getElementsByName('show_plus_shipping_in_product')[0].disabled = true;
document.getElementsByName('show_delivery_time')[0].disabled = true;
document.getElementsByName('product_show_weight')[0].disabled = true;
document.getElementsByName('hide_text_product_not_available')[1].disabled = true;
document.getElementsByName('hide_product_not_avaible_stock')[1].disabled = true;
document.getElementsByName('hide_buy_not_avaible_stock')[1].disabled = true;
document.getElementsByName('hide_text_product_not_available')[1].disabled = true;
				
Object.keys(adminForm.enable_wishlist).forEach(function(key, index) {
  adminForm.enable_wishlist[key].disabled = true; adminForm.enable_wishlist[key].readOnly = true;
});
Object.keys(adminForm.hide_buy_not_avaible_stock).forEach(function(key, index) {
  adminForm.hide_buy_not_avaible_stock[key].disabled = true; adminForm.hide_buy_not_avaible_stock[key].readOnly = true;
});
Object.keys(adminForm.hide_product_not_avaible_stock).forEach(function(key, index) {
  adminForm.hide_product_not_avaible_stock[key].disabled = true; adminForm.hide_product_not_avaible_stock[key].readOnly = true;
});
Object.keys(adminForm.hide_text_product_not_available).forEach(function(key, index) {
  adminForm.hide_text_product_not_available[key].disabled = true; adminForm.hide_text_product_not_available[key].readOnly = true;
});
			});");
		
		; 
//toPrint($view->attributes,'$view->attributes',0,'message',true);
		
		
//		$view->product->_display_price = FALSE; 
		
//		onBeforeDisplayProductView
		
        $view->set('hide_buy',1);	// Скрыть Кнопку КУПИТЬ
        $view->hide_buy = 1;		// Скрыть Кнопку КУПИТЬ
//		$displayData = [
//			'' => '', 
//		];
		
//		JFactory::getApplication()->getDocument()->addScriptDeclaration("jQuery(function(){ /* Plugin PlaceBilet */
//if(document.getElementById('adminForm'))
//
//});"); 
		
		
	}

	/**
	 * Перед выводом редактора конфигурации(Четвертая вкладка ЗАКАЗ)
	 */
	public function onBeforeEditConfigCheckout(&$view) {
        $view->show_delivery_time_checkout = 0;		// Показать "Срок поставки"
        $view->show_delivery_time_step5 = 0;		// Показать "Срок поставки"
        $view->display_delivery_time_for_product_in_order_mail = 0; //Показывать время доставки продукта в заказе (электронная почта)
        $view->show_delivery_date = 0;				// Показать "Дата поставки"
		
		JFactory::getApplication()->getDocument()->addScriptDeclaration("jQuery(function(){ /* Plugin PlaceBilet */
				document.getElementsByName('show_delivery_time_checkout')[1].disabled = true;
				document.getElementsByName('show_delivery_time_step5')[1].disabled = true;
				document.getElementsByName('display_delivery_time_for_product_in_order_mail')[1].disabled = true;
				document.getElementsByName('show_delivery_date')[1].disabled = true; 

Object.keys(adminForm.show_delivery_time_checkout).forEach(function(key, index) {
  adminForm.show_delivery_time_checkout[key].disabled = true; adminForm.show_delivery_time_checkout[key].readOnly = true;
});
			});");
	}

	public function onBeforeEditConfigFieldRegister(&$view) {
		
	}

	public function onBeforeEditConfigOtherConfig(&$view) {
		
	}

	// </editor-fold>
	
	
	/**
	 * 
	 * Метод должен вызыватся при сохранении Расширения в Админке
	 * Но для этого надо подписать плагин к диспетчеру. где нибудь в начале этого файла
	 * JPluginHelper::importPlugin('extension');
	 * 
	 * Save Extension for Save seting plugin
	 * @param string $context
	 * @param object $pluginTable
	 * @param bool $isNew
	 * @param array $data
	 * @return bool
	 */
	public function onExtensionBeforeSave(Event $event){//$context, $pluginTable, $isNew = false, $data = null
		
//		if($context != 'com_plugins.plugin')
//			return true;
//		
//		if(JFactory::getApplication()->getConfig()->get('debug'))
//			static::languageMinificationRaw();
		

//toPrint();
//toPrint($context, '$context',0, 'message',true);// 


		return true;
	}
	
}


// 
//http://naelke.su/checkout/step5
//
//http://icloudfaq.com/question/336885/logging-in-joomla-platform-jlog


 
