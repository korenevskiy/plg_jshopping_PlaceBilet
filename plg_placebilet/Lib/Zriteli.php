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

use \Joomla\CMS\Language\Text as JText;

    defined( '_JEXEC' ) or die( );
//error_reporting( E_ALL );


require_once (JPATH_PLUGINS.'/jshopping/placebilet/Lib/SoapClient.php');

require_once (JPATH_PLUGINS.'/jshopping/placebilet/Lib/Helper.php');
//echo "<br>?HELP!! <br>";
class Zriteli{
    
    /** 
     * Максимальное значение рядов(атрибутов)(#__jshopping_attr) в базе, после которое произойдет очистка таблицы
     * @var int 
     */      
    public static $max_attr = 0;
    /** 
     * Максимальное значение мест(#__jshopping_attr_values) в базе, после которое произойдет очистка таблицы
     * @var int 
     */      
    public static $max_attr_values = 0;
    /** 
     * Максимальное значение билетов(#__jshopping_products_attr2) в базе, после которое произойдет очистка таблицы
     * @var int 
     */      
    public static $max_products_attr2 = 0;
    
    
    /** 
     * Разрешение Логирования ошибок в файл  при включенном атрибуте в toLog()
     * @var bool 
     */      
    public static $debug_off = FALSE;
    
    /**
     * Проценты наценки
     * @var int 
     */
    public static $Jackpot;
    /**
     * Сумма округления рублей
     * @var int 
     */
    public static $CostCurrency;
    
    /**
     * Параметры плагина
     * @var JObject 
     */
    public static $Params;
    /**
     * Массив площадок из параметров.
     * @var array teatrId, stageId, category_id
     */
    public static $StagePlaces = array();
    /**
     * Список репертуаров из ЗРИТЕЛЕЙ
     * @var array 
     */
    public static $Repertoires = array();
    /**
     * Список предложений
     * @var array
     */
    public static $Offers = array();
    
    /**
     * <b>ID категории</b> категорий репертуаров
     * @var int
     */
    public static $IdCategoryRepertoires = 0; 
    /**
     * <b>ID категории</b> категорий площадок
     * @var int
     */
    public static $IdCategoryStages = 0;
    /**
     * <b>ID категории</b> со всеми площадками
     * @var int
     */
    public static $IdCategoriesProducts = 0;
    
    
    /** 
     * ID пользователя сервиса ЗРИТЕЛИ
     * @var int 
     */   
    public static $UserId;
    /** 
     * Хэш пользователя сервиса ЗРИТЕЛИ
     * @var string 
     */   
    public static $UserHash;
    
    
    /** 
     * Включение модуля загрузки данных из ЗРИТЕЛИ
     * @var bool 
     */   
    public static $enabled=FALSE;
    /** 
     * Разрешение отображение ошибок
     * @var bool 
     */   
    public static $ErrorView=FALSE;
    
 
    
    /** 
     * время последнего обновления продуктов
     * @var DateTime 
     */   
    public static $dtUpdateProducts='';
    /** 
     * время последнего обновления предложений
     * @var DateTime 
     */   
    public static $dtUpdateOffers='';
    
    /** 
     * разрешение на обноление Представлений
     * @var bool 
     */    
//    public static $UpdateProducts=FALSE;
    /** 
     * разрешение на обноление Предложений
     * @var bool 
     */    
    public static $UpdateOffers=FALSE;
    /** 
     * разрешение на обноление Репертуаров
     * @var bool 
     */    
    public static $UpdateRepertoiries=FALSE;
    
    /** 
     * Разрешение загрузки репертуаров
     * @var bool 
     */    
    public static $Zriteli_repertoire_download_enabled = FALSE;
    /** 
     * Разрешение загрузки Мест и стоимсти
     * @var bool 
     */    
    public static $Zriteli_places_download_enabled = FALSE;
    
    /** 
     * Будущие, но изчезнувшие представления из ЗРИТЕЛИ будут: <br>
     * <b>cat</b>  - Хранить Категорию; <br>
     * <b>prod</b> - Хр.1 скрытое Представление; <br>
     * <b>hide</b> - Скрывать Все Представления;<br>
     * <b>del</b>  - Удалять Все Представления;<br>
     * <b>""</b>   - Ничего не делать";<br>
     * @var string
     */    
    public static $bilet_delete = "";
    /** 
     * Прошедшие представления будут удаляться, оставаться, скрываться или оставляться тольк один<br>
     * <b>cat</b>  - Хранить Категорию; <br>
     * <b>prod</b> - Хр.1 скрытое Представление; <br>
     * <b>hide</b> - Скрывать Все Представления;<br>
     * <b>del</b>  - Удалять Все Представления;<br>
     * <b>""</b>   - Ничего не делать";<br>
     * @var string
     */    
    public static $bilet_old = "";
    /** 
     * Новое описание новое описание будет копироваться того же репертуара из:<br>
     * <b>cat</b>  - Из Категории<br>
     * <b>prod</b> - Из Представлений<br>
     * <b>""</b>   - Не Копировать <br>
     * @var string 
     */    
    public static $bilet_new = "";
    /** 
     * Пустые категории будут удаляться, оставаться, скрываться <br>
     * <b>hide</b>  - Скрыть Категорию; <br>
     * <b>delete</b> - Удалить; <br>
     * <b>""</b> - Ничего;<br>
     * @var string
     */    
    public static $category_old = "";
    /** 
     * Новая категория для новых репертуаров будет:<br>
     * <b>show</b>  -Публиковать;<br>
     * <b>create</b> - Создать;<br>
     * <b>""</b>     - Ничего не делать;<br>
     * @var string 
     */    
    public static $category_new = "";


    public static function Instance(JRegistry $paramsPlugin, $ErrorView = FALSE){//JRegistry JObject
        
        //static::$debug_off  = (PlaceBiletHelper::JRequest()->getInt('deb', 0))? TRUE : FALSE;
        static::$debug_off = (new JInput())->getInt('deb',0);

//        toLog(static::$UpdateRepertoiries,'static::$UpdateRepertoiries (Instance():1)');
        if(static::$Params instanceof  JRegistry)
            return;
        static::$UpdateOffers = TRUE;
        static::$Params = $paramsPlugin;
        
        //Zriteli_repertoire_download_enabled
        static::$Zriteli_repertoire_download_enabled = (bool)$paramsPlugin->get('Zriteli_repertoire_download_enabled', 1);
        static::$Zriteli_places_download_enabled = (bool)$paramsPlugin->get('Zriteli_places_download_enabled', 1);
        

        
            static::$Jackpot = (int)$paramsPlugin->get('jackpot', 0);
            static::$CostCurrency = (int)$paramsPlugin->get('costCarrency', 0);
            static::$UserId = (int)$paramsPlugin->get('UserId', 111);
            static::$UserHash = $paramsPlugin->get('Hash', '698d51a19d8a121ce581499d7b701668');
//            toLog(static::$StagePlaces ,'static::$StagePlaces');
//AllSelected: 30-30, 357-30, 391-30, 1128-110
//  toPrint(static::$StagePlaces,'static::$StagePlaces','',0,1,TRUE);            
        if(count(static::$StagePlaces)==0){
            static::$StagePlaces = $paramsPlugin->get('StagePlaces', array());
            
            //toPrint(static::$StagePlaces,'static::$StagePlaces +');
            
            $StagePlaces = [];
            
            foreach (static::$StagePlaces as $Id => $stage){ 
//                $log = toLog($stage, '$stage', '', '', TRUE); 
//                toPrint($log,'$stage','',0,1,TRUE);
                list($stageId,$teatrId) = explode ('-',$stage);   
//                $stageId = (int)$stageId;
//                $teatrId = (int)$teatrId;
//                toPrint($stageId,'$stageId','',0,1,TRUE);
//                toPrint($teatrId,'$teatrId','',0,1,TRUE);
                
                $StagePlaces[(int)$stageId] = (object)
                        ['TeatrId'=>(int)$teatrId,'PlaceId'=>(int)$teatrId,'StageId'=>$stageId,'category_id'=>0, 'Name'=>'', 'Teatr'=>'', 'Title'=>''];
                
            }
            static::$StagePlaces = $StagePlaces;
        }
        
//        toPrint(static::$StagePlaces, 'static::$StagePlaces: '.count(static::$StagePlaces));        return;
        static::$enabled = TRUE;
        static::$ErrorView = $ErrorView;
//        CategoriesProducts     CategoriesStages
        static::$IdCategoryRepertoires = (int)$paramsPlugin->get('CategoriesProducts', 0); // ID категории категорий репертуаров
        static::$IdCategoryStages = (int)$paramsPlugin->get('CategoriesStages', 0);// ID категории категорий площадок
        static::$IdCategoriesProducts = (int)$paramsPlugin->get('CatCategoriesAlls', 0);// ID общей категории для всех представлений
        
        static::$dtUpdateProducts = new DateTime($paramsPlugin->get('dtUpdateProducts', 'now'));
//        static::$dtUpdateProducts -> modify('+1 day'); 
        static::$dtUpdateProducts -> modify("+23 hour");
        static::$dtUpdateProducts -> modify("+30 minutes"); 
        
        static::$dtUpdateOffers = new DateTime($paramsPlugin->get('dtUpdateOffers', 'now')); 
        
        static::$bilet_delete = $paramsPlugin->get('bilet_delete', '');  // Способ удаления изчезнувших представлений из ЗРИТЕЛИ
        static::$bilet_old = $paramsPlugin->get('bilet_old', '');        // Способ удаления старых представлений   
        static::$bilet_new    = $paramsPlugin->get('bilet_new', '');        // Копирование старых фотописаний
        static::$category_old = $paramsPlugin->get('category_old', '');  // Способ удаления старых представлений   
        static::$category_new = $paramsPlugin->get('category_new', '');  // Копирование старых фотописаний
        
//        static::$UpdateOffers = static::$enabled && static::$dtUpdateProducts < new DateTime();
        static::$UpdateRepertoiries = static::$enabled && static::$dtUpdateProducts < new DateTime();
        
        static::$max_attr = $paramsPlugin->get('max_attr', 0);              //Максимальное значение рядов, если больше то очистка таблицы базы
        static::$max_attr_values = $paramsPlugin->get('max_attr_values', 0);//Максимальное значение , если больше то очистка таблицы базы
        static::$max_products_attr2 = $paramsPlugin->get('max_products_attr2', 0);//Максимальное значение рядов, если больше то очистка таблицы базы
        
//        return;
//        toLog(static::$UpdateRepertoiries,'static::$UpdateRepertoiries (Instance():2)');
//        toPrint('ZriteliInstance: '.self::$UserId.' - '.self::$UserHash.'; '); 
        $soap = SoapClientZriteli::getInstance(static::$UserId,static::$UserHash, $ErrorView);
         
                    
        //toPrint('ZriteliInstance: '.SoapClientZriteli::$UserId.' - '.SoapClientZriteli::$UserHash.'; ->'.self::$UpdateProducts);
        return $soap;
    }
    /**
     * Обновление даты "последней даты обновления" продуктов в базе.
     * Занесение параметров с новой датой в параметры плагина.
     * @param JRegistry $paramsPlugin Парамеры плагина
     */
    public static function  ParamsSave(JRegistry $paramsPlugin = NULL){
        
        if(is_null($paramsPlugin))
            $paramsPlugin = static::$Params;
//        $user = '';
//        $user = JFactory::getUser()->getParam('timezone');
//        toPrint($user,'$user',0, TRUE, TRUE);
        //JDate::getInstance('now', $paramsPlugin);
        //DateTimeZone
//        JFactory::getDate($paramsPlugin, $tzOffset);
        $paramsPlugin->set('dtUpdateProducts', JDate::getInstance()->toSql(TRUE ));
        //JDate::getInstance('now');
        //JFactory::getDate();
//        toPrint($paramsPlugin->get('vkShareText'),'$paramsPlugin',0, TRUE, TRUE);
        $params = $paramsPlugin->toArray();
        
        $params = json_encode($params, JSON_UNESCAPED_UNICODE); 
//        toPrint($params1,'$params JSON_UNESCAPED_UNICODE',0, TRUE, TRUE);
//        $params2 = json_encode($params, JSON_UNESCAPED_SLASHES); 
//        toPrint($params2,'$params JSON_UNESCAPED_SLASHES',0, TRUE, TRUE);
        
//        $params = $paramsPlugin->toString();
        //$params = JFactory::getDBO()->quote($params);
        
//        toPrint($params,'$params toString()',0, TRUE, TRUE);
//        return;
        
        $query = " UPDATE #__extensions SET params = '$params' WHERE element='PlaceBilet'; "; 
        //toPrint($query);        return;
        JFactory::getDBO()->setQuery($query)->execute();
    }
    
    static function DisabledUpdateProductsAndRepertoires(){
        //self::$Params = $paramsPlugin;
        
        $date = JDate::getInstance()->toSql(TRUE);
//        toPrint($date,' $date' );
        static::$Params->set("dtUpdateProducts", $date);
        $params = self::$Params->toString();
        
        
        //$db = JFactory::getDbo(); 
        //$params = $db->quote($params);
        
//        self::$dtUpdateProducts = new DateTime($paramsPlugin->get('dtUpdateProducts', 'now'));
       
        //$query = " SELECT params FROM #__extensions WHERE element='PlaceBilet'; ";
        $query = " UPDATE #__extensions SET params = '$params' WHERE element='PlaceBilet'; ";
        JFactory::getDBO()->setQuery($query)->execute();

//        toPrint($query,' $query' );
//        
//        $params = json_decode($params);
//        $this->params = new JObject();
//        $this->params->setProperties($params);
                
//        $this->params = JRegistry::getInstance('PlaceBilet'); 
//        $this->params->loadString($params);
    }


    static $Products = array(); 
    /**
     * Продукты сформировланы из репертуаров,т.е. продукты загруженные с ЗРИТЕЛИ
     * @var array 
     */
    static $Prods = array();  

    
    /**
     * Загрузка Всех продуктов из сервисов
     * @global boolean $Zriteli_repertoire_download_enabled
     * @return array [$products_count_exist, $products_count_New, $products_count_onlyDB, $products_NOexist];
     */
    public static function LoadAllProducts(){
//toPrint('yes 0:');
//return;
        
        static::MaxDeleteCount();


//        if(!isset($_SERVER['HTTP_USER_AGENT'] ))            toLog($_SERVER,'$_SERVER LOG');
//        if(static::$debug_off)            toPrint($_SERVER,'$_SERVER','',0);
        
//   toPrint(static::$StagePlaces, 'static::$StagePlaces: x'.count(static::$StagePlaces)); 
        
//        toPrint('LoadAllProducts: '.self::$UserId.' - '.self::$UserHash.'; ->'.self::$UpdateProducts); 
         

//toPrint('yes 0:');

//   toPrint(array_slice(static::$StagePlaces, 0,3, TRUE), ' \static::$StagePlaces V Count:'.count(static::$StagePlaces));
        if(static::$Zriteli_repertoire_download_enabled){
//            toLog('LoadAllProducts Run:' );
//            toPrint('LoadAllProducts Run:' );
            static::$UpdateRepertoiries = TRUE;
        }
            
//           if(static::$debug_off)  toPrint(static::$UpdateRepertoiries,'static::$UpdateRepertoiries:'  );
//           if(static::$debug_off)  toPrint($Zriteli_repertoire_download_enabled,'$Zriteli_repertoire_download_enabled:'   );
//           if(static::$debug_off)  toPrint(static::$Zriteli_repertoire_download_enabled,'static::$Zriteli_repertoire_download_enabled:'  );
//           if(static::$debug_off)  toLog(static::$UpdateRepertoiries,'static::$UpdateRepertoiries:'  );
//           if(static::$debug_off)  toLog($Zriteli_repertoire_download_enabled,'$Zriteli_repertoire_download_enabled:'   );
//           if(static::$debug_off)  toLog(static::$Zriteli_repertoire_download_enabled,'static::$Zriteli_repertoire_download_enabled:'  );           
//           static::$debug_off = FALSE;
        
        if(!static::$UpdateRepertoiries)
            return [-1,-1,__LINE__];
        
//toPrint('yes 1:');
        
        if(!static::$Zriteli_repertoire_download_enabled)
            return [-1,-1,__LINE__];
        
   //          toPrint("Line:".__LINE__.", File:".__FILE__);   
//toPrint('yes 2:');
//        if(static::$Zriteli_repertoire_download_enabled) {
////            toLog('LoadAllProducts Start update:');
////            toPrint('LoadAllProducts Start update:');
//            
//        }
            
        
//            toPrint(static::$Zriteli_repertoire_download_enabled,'22 static::$Zriteli_repertoire_download_enabled:' );
         
        //toPrint('Обновление!!!');
        //toPrint('LoadAllProducts: '.self::$UserId.' - '.self::$UserHash.'; ->'.self::$UpdateProducts); 
        //toPrint('LoadAllProducts: '.SoapClientZriteli::$UserId.' - '.SoapClientZriteli::$UserHash.'; ->'.self::$UpdateProducts); 
        
        //static::$StagePlaces = static::UpdateLoadStages();
         
        //toPrint($log); 
//        toPrint(static::$StagePlaces," \$StagePlaces Count:".count(static::$StagePlaces)); 
        //toPrint(static::$StagePlaces,'static::$StagePlaces');
        //toPrint(static::$StagePlaces,'static::$StagePlaces');
        
        //******************************************* Закачка мероприятий с Зрители
        //$Repertoires = array();
        //*********************************** Закачка репертуаров
        foreach (static::$StagePlaces as $stageId => $stage){
            $Rprtrs = SoapClientZriteli::Call_GetRepertoireListByStageId($stageId, FALSE);
            // Получение репертуара  Repertoiries object[RepertoireId]:  (Name(RepertoireName),Id(RepertoireId),StageId, CategoryIdList)
//            foreach ($Rprtrs as $id=>$rprt)
//                $Rprtrs[$id]->StageId=$stageId;
//            toPrint($Rprtrs,'$Rprtrs'); 
            static::$Repertoires += $Rprtrs;
        }
        
        
//        static::ParamsSave();
        //return;
        
        // toPrint("Line:".__LINE__.", File:".__FILE__);       
        //static::$StagePlaces[(int)$stageId] = (object)['TeatrId'=>$teatrId,'PlaceId'=>$teatrId,'StageId'=>$stageId,'category_id'=>0, 'Name'=>'', 'Teatr'=>'', 'Title'=>''];
        //$Offers = array();
        // ********************************** Закачка предожений
        foreach (static::$Repertoires as $id => $repertoire){
            //self::$Repertoires[$id] = (object)$repertoire;
            $ffrs = SoapClientZriteli::Call_GetOfferListByRepertoireId($id, FALSE);
            //$ffrs->Repertoire = self::$Repertoires[$id];
            if(count($ffrs)==0){
                unset (static::$Repertoires[$id]);
                continue;
            }
            
            static::$Repertoires[$id]->PlaceId = static::$StagePlaces[$repertoire->StageId]->PlaceId;
            static::$Repertoires[$id]->Teatr = static::$StagePlaces[$repertoire->StageId]->Teatr; 
            
            static::$Repertoires[$id]->category_image = '';
            
            static::$Repertoires[$id]->category_image = '';
            static::$Repertoires[$id]->category_id = 0;
            static::$Repertoires[$id]->description = '';
            static::$Repertoires[$id]->Offers = &$ffrs;
            static::$Offers += $ffrs;
             
            
//        toPrint($ffrs, "$ffrs --- \$id:$id ".'  count:'.count($ffrs)); 
            foreach ($ffrs as $id_ffr => $ffr){
                static::$Offers[$id_ffr]->Name = $repertoire->Name;
                static::$Offers[$id_ffr]->description = '';
                static::$Offers[$id_ffr]->product_id = 0;
                  
                //$prod->Offers = $ffrs;
                if(!isset(static::$Products[$repertoire->Name][$ffr->EventDateTime][$repertoire->StageId])){
                    static::$Products[$repertoire->Name][$ffr->EventDateTime][$repertoire->StageId] = new stdClass();
                    static::$Products[$repertoire->Name][$ffr->EventDateTime][$repertoire->StageId]->EventDateTime = $ffr->EventDateTime;
                    static::$Products[$repertoire->Name][$ffr->EventDateTime][$repertoire->StageId]->Name = $repertoire->Name;
                    static::$Products[$repertoire->Name][$ffr->EventDateTime][$repertoire->StageId]->RepertoireId = $id;
                    
                    static::$Products[$repertoire->Name][$ffr->EventDateTime][$repertoire->StageId]->category_id  = 0;
                    static::$Products[$repertoire->Name][$ffr->EventDateTime][$repertoire->StageId]->product_id   = 0;
                    static::$Products[$repertoire->Name][$ffr->EventDateTime][$repertoire->StageId]->StageId   = $repertoire->StageId;
                    static::$Products[$repertoire->Name][$ffr->EventDateTime][$repertoire->StageId]->description  = '';
                    static::$Products[$repertoire->Name][$ffr->EventDateTime][$repertoire->StageId]->image        = '';
                    static::$Products[$repertoire->Name][$ffr->EventDateTime][$repertoire->StageId]->OffersCount  = 0;//count($ffrs);
                    
                    static::$Products[$repertoire->Name][$ffr->EventDateTime][$repertoire->StageId]->Offers[$id_ffr] = $ffr;
                    
                    static::$Repertoires[$id]->Prods[]  = & static::$Products[$repertoire->Name][$ffr->EventDateTime][$repertoire->StageId];
                    static::$Prods[]                    = & static::$Products[$repertoire->Name][$ffr->EventDateTime][$repertoire->StageId];
                }
                elseif(!isset (static::$Repertoires[$id]->Prods) || is_null(static::$Repertoires[$id]->Prods)){
                    static::$Repertoires[$id]->Prods = [];
                }
                //self::$Repertoires[$id]->Products 
            }
            static::$Repertoires[$id]->ProdsCount = count(static::$Repertoires[$id]->Prods);
        }
        
//        toPrint(static::$Prods,'static::$Prods');
//        toPrint(static::$Repertoires,'static::$Repertoires');
//        toPrint(SoapClientZriteli::$Errors,'SoapClientZriteli::$Errors');
        
//        toPrint(self::$Products, ' self::$Products '.count(self::$Products));
//        toPrint(self::$Prods, ' self::$Prods '.count(self::$Prods));
        
        $lang = JFactory::getLanguage()->getTag();  
        
//        if($lang != 'ru-RU') {
//            toLog ($_SERVER);
//            JFactory::getLanguage()->setDefault("ru-RU");
//            $lang = 'ru-RU';
//        }
         
        $db = JFactory::getDbo(); 
        $name = 'name_'.$lang;
        $short_desc = 'short_description_'.$lang;
        $description = 'description_'.JFactory::getLanguage()->getTag(); 
        
        //******************************************* Добавление в базу мероприятий
        
        // Сортировка репертуаров по имеющимся в базе и неимеющихся
        $RprtsCompare     = static::RepertoiresCompare(); 
        $Repertoires_exist          = $RprtsCompare->Repertoires_exist;
        $Repertoires_NOexist        = $RprtsCompare->Repertoires_NOexist;// не существующие в базе новые категории
        $Repertoires_existUnpublish = $RprtsCompare->Repertoires_existUnpublish;
        $Category_bd_only           = $RprtsCompare->Category_bd_only;
        // toPrint($repertoire->Name);
        static::$bilet_delete;//STRING: bilet_old: cat, prod, hide, del, ""; "" - Тип удаления изчезнувших представлений из ЗРИТЕЛИ
        static::$bilet_old;//STRING: bilet_old: cat, prod, hide, del, ""; "" - Тип действия с устаревшими представлениями
        static::$bilet_new;//STRING: bilet_new: cat, prod, "";  ""           - Копирование или нет новых представлений
        static::$category_old;//STRING: category_old: hide, delete, ""; "" - Тип действия с устаревшими категориями
        static::$category_new;//STRING: category_new: show, create, ""; "" - Публикация или создание новых категорий
        //Удалять не существующие категории, иначе публикацию снимать. 
        
//        toPrint($Repertoires_NOexist,'$Repertoires_NOexist');
//        toPrint($Repertoires_exist,'$Repertoires_exist');
//        toPrint($Repertoires_existUnpublish,'$Repertoires_existUnpublish');
        
        // Категории  - Удаление(Скрытие) категорий с отсутствующими репертуарами
        if(count($Category_bd_only)){
            $cats_id_only_db = array_column($Category_bd_only, 'category_id');
            if(static::$category_old == 'delete' && static::$bilet_old != 'cat' && static::$bilet_delete != 'cat')
                $query = " DELETE FROM `#__jshopping_categories` WHERE category_id IN (".join(',',$cats_id_only_db).") ; ";
            elseif(static::$category_old == 'hide')
                $query = " UPDATE `#__jshopping_categories` SET category_publish = 0 WHERE category_id IN (".join(',',$cats_id_only_db).") AND RepertoireId != 0 ; ";
            else 
                $query = " SELECT 123 ; ";
            JFactory::getDBO()->setQuery($query)->execute();
        }
         
        // Категории  - Публикация снятых категорий для которых имеются репертуары
        if(count($Repertoires_existUnpublish) && in_array(static::$category_new, ['show','all']) ){ // == 'show'
            $rprtrs_repId = array_keys($Repertoires_existUnpublish);
            
            $update = " UPDATE `#__jshopping_categories` SET `category_publish` = 1 " 
                    . " WHERE RepertoireId IN (".  join(',', $rprtrs_repId).") AND RepertoireId != 0; ";  
            JFactory::getDBO()->setQuery($update)->execute(); 
        }
        
        // Категории  - добавление отсутсвующих Репертуаров в категориии и получение их ID
        if(count($Repertoires_NOexist) && in_array(static::$category_new, ['create','all']) ){// == 'create'
            $IdCategoryRepertoires = static::$IdCategoryRepertoires;// ID категории для продуктов
            if($IdCategoryRepertoires > -1){
                $querys = array();
                foreach ($Repertoires_NOexist as $id => $repertoire)
                    $querys[] = " (".$db->quote($repertoire->Name??'').",$repertoire->Id, $IdCategoryRepertoires, 1, 1, 1, NOW(), 12, 2, 1, $repertoire->StageId, $repertoire->PlaceId ) ";//$db->quote($db->escape($repertoire->Name),false)
            
                $query_insert =" INSERT INTO `#__jshopping_categories` "
                    . "(`$name`,RepertoireId,`category_parent_id`,`category_publish`,`category_ordertype`,`ordering`,`category_add_date`,`products_page`,`products_row`,`access`,StageId,PlaceId) "
                    . " VALUES ".  join(', ', $querys)."; "; 
                if(count($querys)>0)
                    JFactory::getDBO()->setQuery($query_insert)->execute();
            }
            // загрузка добавление и определение категорий для площадок
            $IdCategoryStages = static::$IdCategoryStages;
            if($IdCategoryStages > -1){
                static::$StagePlaces = static::UpdateLoadStages();
//                toPrint(static::$StagePlaces," \$StagePlaces Count:".count(static::$StagePlaces)); 
            }
//            toPrint($query);
            
            $RepertoiresCompare     = static::RepertoiresCompare();
            $Repertoires_exist      = $RepertoiresCompare->Repertoires_exist;
            $Repertoires_NOexist    = $RepertoiresCompare->Repertoires_NOexist;
// toPrint($repertoire->Name);
        }
    
        //params        {"StageId":950,"category_id":485,"RepertoireId":6172,"OffersId":[981302]}
        
        
        
        foreach (static::$Prods as $id_prod => $prod){
            if($prod->RepertoireId == 0)
                continue;
            //static::$Prods[$id_prod]->RepertoireId;
            static::$Prods[$id_prod]->category_id = $Repertoires_exist[$prod->RepertoireId]->category_id;
            static::$Prods[$id_prod]->image = $Repertoires_exist[$prod->RepertoireId]->category_image;
            static::$Prods[$id_prod]->description = $Repertoires_exist[$prod->RepertoireId]->description;
            static::$Prods[$id_prod]->OffersCount  = count(static::$Prods[$id_prod]->Offers);
        }
//        foreach ($Repertoires_exist as $id_cat => $repertoire){
//            foreach (static::$Prods as $id_prod=> $prod){
//                if($prod->Name == $repertoire->Name){
//                    static::$Prods[$id_prod]->category_id = $repertoire->category_id;
//                    static::$Prods[$id_prod]->image = $repertoire->category_image;
//                    static::$Prods[$id_prod]->description = $repertoire->description;
//                    static::$Prods[$id_prod]->OffersCount  = count(static::$Prods[$id_prod]->Offers);
//                }
//            }
//        }
        
//        toPrint(self::$Products, ' self::$Products '.count(self::$Products));
//        toPrint(self::$Prods, ' self::$Prods '.count(self::$Prods));
        
        
        
        //**********************************************
//        $cats = array();
//        foreach (self::$Repertoires as $id => $repertoire){
//            $cats[] = $repertoire->category_id;
//        }
//        $query =" SELECT product_id, category_id, product_ordering FROM `#__jshopping_products_to_categories` WHERE category_id IN (".join(", ",$cats).") ORDER BY category_id, product_id, product_ordering; ";
//        $cats_prods = JFactory::getDBO()->setQuery($query)->loadObjectList();
//        
//        $query =" SELECT pc.category_id, product_ordering , p.* "
//                . "FROM `#__jshopping_products_to_categories` pc,`#__jshopping_products` p "
//                . "WHERE pc.product_id=p.product_id AND pc.category_id IN (".join(", ",$cats).") "
//                . "ORDER BY pc.category_id, pc.product_id, pc.product_ordering; ";
//        
//        $query =  "SELECT p1.* "
//                . "FROM `#__jshopping_products` p1, `#__jshopping_products` p2 "
//                . "WHERE p1."
//                . "ORDER BY category_id, product_id, product_ordering; ";
//        
        
//        toPrint(self::$Repertoires, ' self::$Repertoires! '.count(self::$Repertoires)); // 0 
        $products_count_exist = 0; 
        $products_count_New = 0;
        $products_count_onlyDB = 0;
            

//        toPrint(static::$Prods, ' static::$Prods '.count(static::$Prods)); 
        //Сравнение продуктов с предложениями, static::$Prods c базой
        list($products_exist, $products_NOexist, $products_onlyDB) = static::ProductsCompare();   
//        $products_onlyDB = $ProductsCompare->products_onlyBD;
    
            $products_count_exist = count($products_exist);
            $products_count_New = count($products_NOexist);
            $products_count_onlyDB = count($products_onlyDB);

//        toPrint(array_keys($products_exist) ,'$products_exist  [product_id]');
//        toPrint(array_keys($products_onlyDB),'$products_onlyDB  [product_id]');
//        toPrint(array_keys($products_NOexist),'$products_NOexist  [product_id]'); // Count^388  
        //0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23, 24, 25, 26, 27, 28, 29, 30, 31, 32, 33, 34, 35, 36, 37, 38, 39, 40, 41, 42, 43, 44, 45, 46, 47, 48, 49, 50, 51, 52, 53, 54, 55, 56, 57, 58, 59, 60, 61, 62, 63, 64, 65, 66, 67, 68, 69, 70, 71, 72, 73, 74, 75, 76, 77, 78, 79, 80, 81, 82, 83, 84, 85, 86, 87, 88, 89, 90, 91, 92, 93, 94, 95, 96, 97, 98, 99, 100, 101, 102, 103, 104, 105, 106, 107, 108, 109, 110, 111, 112, 113, 114, 115, 116, 117, 118, 119, 120, 121, 122, 123, 124, 125, 126, 127, 128, 129, 130, 131, 132, 133, 134, 135, 136, 137, 138, 139, 140, 141, 142, 143, 144, 145, 146, 147, 148, 149, 150, 151, 152, 153, 154, 155, 156, 157, 158, 159, 160, 161, 162, 163, 164, 165, 166, 167, 168, 169, 170, 171, 172, 173, 174, 175, 176, 177, 178, 179, 180, 181, 182, 183, 184, 185, 186, 187, 188, 189, 190, 191, 192, 193, 194, 195, 196, 197, 198, 199, 200, 201, 202, 203, 204, 205, 206, 207, 208, 209, 210, 211, 212, 213, 214, 215, 216, 217, 218, 219, 220, 221, 222, 223, 224, 225, 226, 227, 228, 229, 230, 231, 232, 233, 234, 235, 236, 237, 238, 239, 240, 241, 242, 243, 244, 245, 246, 247, 248, 249, 250, 251, 252, 253, 254, 255, 256, 257, 258, 259, 260, 261, 262, 263, 264, 265, 266, 267, 268, 269, 270, 271, 272, 273, 274, 275, 276, 277, 278, 279, 280, 281, 282, 283, 284, 285, 286, 287, 288, 289, 290, 291, 292, 293, 294, 295, 296, 297, 298, 299, 300, 301, 302, 303, 304, 305, 306, 307, 308, 309, 310, 311, 312, 313, 314, 315, 316, 317, 318, 319, 320, 321, 322, 323, 324, 325, 326, 327, 328, 329, 330, 331, 332, 333, 334, 335, 336, 337, 338, 339, 340, 341, 342, 343, 344, 345, 346, 347, 348, 349, 350, 351, 352, 353, 354, 355, 356, 357, 358, 359, 360, 361, 362, 363, 364, 365, 366, 367, 368, 369, 370, 371, 372, 373, 374, 375, 376, 377, 378, 379, 380, 381, 382, 383, 384, 385, 386, 387

        
        static::DeleteOldProducts();   
        
        // <editor-fold defaultstate="collapsed" desc="Удаление устарелых и не существующих спектаклей и которых уже нет в репертуаре.">
        // Удаление устарелых и не существующих спектаклей и которых уже нет в репертуаре.
        if ($products_onlyDB) {
            static::$bilet_old; //STRING: cat, prod, hide, del, ""; "" - Тип действия с устаревшими представлениями
            static::$bilet_delete; //STRING: bilet_old: cat, prod, hide, del, ""; "" - Тип удаления изчезнувших представлений из ЗРИТЕЛИ
            $ids = array_keys($products_onlyDB);
            $query = " SELECT NOW(); ";


            if (static::$bilet_delete == 'del' && $ids) {//Удаление из базы которых нет репертуаров
                $query = " DELETE FROM `#__jshopping_products` "
                        . " WHERE product_id IN (" . join(',', $ids) . " ) ; ";
                JFactory::getDBO()->setQuery($query)->execute();
            }

            if (static::$bilet_delete == 'hide' && $ids) { // Скрытие прошедших
                $query = "
                    UPDATE #__jshopping_products p SET p.product_publish = FALSE
                    WHERE product_id IN (" . join(',', $ids) . " ) ; ";
                JFactory::getDBO()->setQuery($query)->execute();
            }

            if (static::$bilet_delete == 'prod' && $ids) { // Удаление изчезнувших с сервиса кроме одного каждого репертуара, один каждого репертуара скрывается
                $query = "
                    UPDATE #__jshopping_products p SET p.product_publish = FALSE
                    WHERE product_id IN (" . join(',', $ids) . " ) ; ";
                JFactory::getDBO()->setQuery($query)->execute();
                
                $query = "
                    DELETE p1 FROM #__jshopping_products p1,  #__jshopping_products p2
                    WHERE p1.product_publish = FALSE AND p2.product_publish = FALSE 
                        AND p1.RepertoireId > p2.RepertoireId AND p1.RepertoireId !=0  AND p2.RepertoireId !=0; ";        
                JFactory::getDBO()->setQuery($query)->execute();
            }
        }

//**************************************************************************
//**************************************************************************
//**************************************************************************
//**************************************************************************
//**************************************************************************
//**************************************************************************
//**************************************************************************
//**************************************************************************
        
//static::ProductsDeleteFromDB();
        //Удаление дубликатов представлений
        $delete = " DELETE p1 FROM #__jshopping_products p1, #__jshopping_products p2
                WHERE p1.RepertoireId = p2.RepertoireId AND p1.date_event = p2.date_event AND p1.product_id > p2.product_id; ";
        JFactory::getDBO()->setQuery($delete)->execute();
        //Удаление лишних ключей из таблицы связей Продуктов с Категориями
        $delete = " DELETE FROM `#__jshopping_products_to_categories` WHERE product_id NOT IN (SELECT product_id FROM `#__jshopping_products` ); ";
        JFactory::getDBO()->setQuery($delete)->execute();
        // Удаление из таблицы картинок от несуществующих продуктов
        $delete = " DELETE FROM `#__jshopping_products_images` WHERE product_id NOT IN ( SELECT p.product_id FROM `#__jshopping_products` AS p ); ";
        JFactory::getDBO()->setQuery($delete)->execute();
        // </editor-fold>
//******-------------------------------------------------------------------

        
//     self::$Offers = 1446      
//        toPrint($products_NOexist, ' $products_NOexist '.count($products_NOexist));

        
//        toPrint(self::$Products, ' self::$Products '.count(self::$Products));
//        toPrint(self::$Prods, ' self::$Prods '.count(self::$Prods));
          
//        toPrint($products_NOexist, ' \$products_NOexist '.count($products_NOexist)); // 1472
//        toPrint($products_onlyDB, ' \$products_onlyDB '.count($products_onlyDB)); // 1472        184,188
//        toPrint($products_exist, ' \$products_exist '.count($products_exist)); // 0
        
    
//toPrint("\$products_NOexist-COUNT:".count($products_NOexist). ' - $products_exist-COUNT:'.count($products_exist)); 

           
        
        // ДОбавление спектаклей которых нет в базе
        if($products_NOexist){
//            toPrint(array_slice($Repertoires_NOexist, 0,2) , " \$Repertoires_NOexist Count:".count($Repertoires_NOexist));
//            toPrint(array_slice($products_NOexist, 0,2), " \$products_NOexist Count:".count($products_NOexist));
          
            
            $IdCategoryStages = static::$IdCategoryStages; // ID категории с площадками
            // Наполнение объектов площадок из параметров данными из базы.
            if(count($Repertoires_NOexist)==0 && $IdCategoryStages > -1){
                $query = " SELECT *, `$name` Name, `$short_desc` short_desc, `$description` description "
                       . " FROM `#__jshopping_categories` WHERE category_parent_id = $IdCategoryStages; ";
                $cats = JFactory::getDBO()->setQuery($query)->loadObjectList('StageId');//category_id   StageId  
                
                foreach (static::$StagePlaces  as $stageId => $stage){
                    static::$StagePlaces[$stageId]->category_id  = $cats[$stageId]->category_id;
                    static::$StagePlaces[$stageId]->StageCatId  = $cats[$stageId]->category_id;
                    static::$StagePlaces[$stageId]->Name        = $cats[$stageId]->Name;
                    static::$StagePlaces[$stageId]->Address     = $cats[$stageId]->short_desc;
                    static::$StagePlaces[$stageId]->Teatr       = $cats[$stageId]->Name;
                    static::$StagePlaces[$stageId]->Title       = $cats[$stageId]->Name;
                }
                
//                toPrint(array_slice(static::$StagePlaces, 0,3, TRUE), ' \static::$StagePlaces F Count:'.count(static::$StagePlaces));
//                static::$StagePlaces = static::UpdateLoadStages();
//                toPrint(static::$StagePlaces," \$StagePlaces Count:".count(static::$StagePlaces)); 
            }
        
            
            
            $query = "SELECT * FROM `#__jshopping_products` LIMIT 1; ";
            $first = JFactory::getDBO()->setQuery($query)->loadObject();
            if(is_null($first)) 
                $first = (object)['currency_id'=> 1 , 'add_price_unit_id'=> 1 , 'different_prices'=> 1];
        
            $querys = array();            
            foreach ($products_NOexist as $id => &$product){
//                $product->params['StageCatId'] = $cats[$product->StageId]->category_id;
                $product->params['StageCatId'] = static::$StagePlaces[$product->StageId]->StageCatId;
//                toPrint($product->params, ' \$product->params Count:'.count($product->params));
                $querys[] = " ('$product->EventDateTime','".json_encode($product->params)."',".$db->quote($product->image??'').",NOW(),1,$first->currency_id,$first->add_price_unit_id,$first->different_prices,'default',1,".$db->quote($product->Name??'').",".$db->quote($product->description??'').",$product->RepertoireId,$product->StageId) ";//$db->quote($db->escape($repertoire->Name),false)   
            }
            $query_insert = " INSERT INTO `#__jshopping_products` "
                    . "(`date_event`,`params`,`image`,`product_date_added`,`product_publish`,`currency_id`,`add_price_unit_id`,`different_prices`, `product_template`,`access`, `$name`,`$description`,RepertoireId,StageId) VALUES "
                    . join(', ', $querys). "; ";
            if(count($products_NOexist)>0)        JFactory::getDBO()->setQuery($query_insert)->execute();    //{"StageId":950,"category_id":482,"RepertoireId":3738,"OffersId":[986490]}
//            toPrint($products_NOexist, ' \$products_NOexist '.count($products_NOexist));
//            toPrint($query_insert, ' \$query_insert '.count($products_NOexist));
      
            //Наполнение новых продуктов(представлений из категорий или из продуктов)
            static::SetCatsToProds($products_NOexist); 
                       
            $products_count_exist = count($products_exist);
            $products_count_New = count($products_NOexist);
            $products_count_onlyDB = count($products_onlyDB);
            
            
            
            //$ProductsCompare = static::ProductsCompare(); // [ $products_exist, $products_NOexist, $products_bd];
            list($products_exist, $products_NOexist, $products_bd) = static::ProductsCompare(); // [ $products_exist, $products_NOexist, $products_bd];
//            $products_exist = $ProductsCompare->products_exist;
//            $products_NOexist = $ProductsCompare->products_NOexist; 
//            $products_onlyDB = $ProductsCompare->products_onlyBD;
            //foreach ($products_NOexist )
//            toPrint($products_NOexist, ' \$products_NOexist xx');
//            toPrint($ProductsCompare->products_exist, ' \$ProductsCompare->products_exist xx');
              
            $products_count_exist = count($products_exist); 
            $products_count_New = count($products_NOexist);
            $products_count_onlyDB = count($products_onlyDB);
            
        }
        
//        if(!PlaceBiletDev){
                //$products_id_bd = array_keys($products_onlyDB);
         static::ProductsDeleteFromDB();//Удаление несуществующих связей для категорий и продуктов.
//        }        
 
//toPrint("123", ' $count ');        
        static::SetCatsToProds();
        
//toPrint("123", ' $count ');      
//            $querys = array();
//            foreach ($prod_cats_NOexist as $id => $prod){
//                $querys[] = " (".$products_exist[$id]->product_id.", ".$products_exist[$id]->category_id.", 1 ) ";
//            }
//            $query_insert =" INSERT INTO `#__jshopping_products_to_categories` "
//                    . "(product_id, category_id, product_ordering) VALUES " .  join(',', $querys)."; ";
////            JFactory::getDBO()->setQuery($query_insert)->execute();
////            toPrint($query_insert, ' $query_insert '); 
//-------------------------------
        
//        foreach(self::$Repertoires as $id=>$repertoire){
//             $xx[]= $db->quote($repertoire->Name);
//        }
//        foreach($categories_bd as $id=>$repertoire){
////             $xx[]= $db->quote($repertoire->$name);
//             $xx[$id] = $repertoire->$name;
//        }
//        toPrint($xx, ' $xx ');
        
//        toPrint( ' $products_NOexist '.count($products_NOexist));
//        toPrint( ' $products_exist '.count($products_exist)); 
        
//        toPrint($prod_cats_NOexist, ' $prod_cats_NOexist '.count($prod_cats_NOexist));
//        toPrint($Repertoires_NOexist, ' $Repertoires_NOexist '.count($Repertoires_NOexist));
//        toPrint($Repertoires_exist, ' $Repertoires_exist '.count($Repertoires_exist));
//        toPrint($products_NOexist, ' $products_NOexist '.count($products_NOexist));
//        toPrint($products_exist, ' $products_exist '.count($products_exist));
//        toPrint($query, ' $name ');
//        self::$IdCategoryRepertoires = 0;
//        self::$IdCategoryStages = 0;
        //CategoriesProducts     CategoriesStages
    //    toPrint(self::$IdCategoryRepertoires, ' $IdCategoryRepertoires ');
        //self::$Offers ;
        
//      toPrint(self::$Repertoires,'LoadAllProducts(): Call_GetRepertoireListByStageId(): count:'.count(self::$Repertoires));
//        toPrint(self::$Offers,' self::$Offers: count:'.count(self::$Offers));
     
        
        
        if(static::$Zriteli_repertoire_download_enabled) {
//            toLog(count($products_NOexist),'New Repertoires --------->>>>>: Stop LoadAllProducts');
//            toPrint(count($products_NOexist),'New Repertoires --------->>>>>: Stop LoadAllProducts');  
            
            
            static::$UpdateRepertoiries = FALSE;
            static::$Zriteli_repertoire_download_enabled = FALSE;
        }
        
   
        
        
        //$products_NOexist RepertoireId product_id Name
        
//        $log = "";
//        foreach ($products_NOexist as $product)
//            $log .= "Id$product->product_id:R$product->RepertoireId, ";

        //toLog("---  New: $products_count_New -> $log","Write Products Count  ---  Exist: $products_count_exist  ---  Old: $products_count_onlyDB  ---");
        
        
//        toLog($Repertoires);
//        return; //удалить
//        CategoriesProducts
//        CategoriesStages
        static::UpdateLoadCostCarencys();
        static::UpdateInfoDescritpion();
        static::NewInfoInsertForProduct($products_NOexist);// Копирование картинок в новые продукты из таких же старых
        
//        static::DisabledUpdateProductsAndRepertoires();
        static::ParamsSave();
        
//        echo 'Done!!!!!!!!!!!!';
        static::$UpdateRepertoiries = FALSE;
        //list($products_count_exist, $products_count_NOexist, $products_count_onlyDB) = static::ProductsCompare();   //    return  [ $products_exist, $products_NOexist, $products_bd];
        
        return [$products_count_exist, $products_count_New, $products_count_onlyDB, $products_NOexist];
    }
         
    
    /*
     * Сравнение репертуаров с категориями 
     */
    private static function RepertoiresCompare(){
        
        $db = JFactory::getDbo(); 
        $name = 'name_'.JFactory::getLanguage()->getTag();
        $description = 'description_'.JFactory::getLanguage()->getTag(); 
        
	$IdCategoryRepertoires = static::$IdCategoryRepertoires;
        $query_select = " SELECT * , `$description` description  FROM `#__jshopping_categories` WHERE category_parent_id = $IdCategoryRepertoires ; ";
        $categories_bd = JFactory::getDBO()->setQuery($query_select)->loadObjectList('RepertoireId');
        // name_ru-RU, description_ru-RU, category_parent_id, category_id,    
        // ordering 1, products_page 12, products_row 2, access 1, category_add_date, category_publish 1, 
		
	$Repertoires_exist   = array();
	$Repertoires_existUnpublish   = array();
        $Repertoires_NOexist = array();
        $category_bd_only = array();
	
//        foreach($categories_bd as $repertoire_id => $repertoire_bd){  
//            if(isset(static::$Repertoires[$repertoire_id]))
//                $Repertoires_exist[$repertoire_id] = static::$Repertoires[$repertoire_id]; 
//            else {
//                static::$Repertoires[$repertoire_id] = new stdClass; 
//                $Repertoires_NOexist[$repertoire_id] = static::$Repertoires[$repertoire_id]; 
//            }
//            static::$Repertoires[$repertoire_id]->category_image = $repertoire_bd->category_image;
//            static::$Repertoires[$repertoire_id]->description    = $repertoire_bd->$description;
//            static::$Repertoires[$repertoire_id]->category_id    = $repertoire_bd->category_id;
//        }
        
        foreach(static::$Repertoires as $rep_id => $repertoire){ 
            if(!isset($categories_bd[$rep_id])){
                $Repertoires_NOexist[$rep_id] = static::$Repertoires[$rep_id]; 
                continue;    
            }
            else
                $Repertoires_exist[$rep_id] = static::$Repertoires[$rep_id]; 
            
            if($categories_bd[$rep_id]->category_publish==0)
                $Repertoires_existUnpublish[$rep_id] = static::$Repertoires[$rep_id]; 
            
            static::$Repertoires[$rep_id]->category_image = $categories_bd[$rep_id]->category_image;
            static::$Repertoires[$rep_id]->description    = $categories_bd[$rep_id]->description;//$categories_bd[$rep_id]->$description;
            static::$Repertoires[$rep_id]->category_id    = $categories_bd[$rep_id]->category_id;
            
            unset($categories_bd[$rep_id]);
        }
        
        
        
//        if(count($Repertoires_exist) < count($categories_bd)){
//            $only_db = [];
//            $ids = [];
//            foreach ($categories_bd as $cat_id => $categories_bd){
//                if(!isset(static::$Repertoires[$cat_id])){
//                    $only_db[$cat_id] = $categories_bd;
//                    $ids[] = $cat_id;
//                }
//            }
//            $delete = " DELETE FROM `#__jshopping_categories` c WHERE c.category_parent_id = $IdCategoryRepertoires AND c.Repertoire_Id IN ("
//                    . join(',', $ids). " ) ; ";
//            if(count($ids)>0)   JFactory::getDBO()->setQuery($delete)->execute();
//            
//            $delete = " DELETE FROM `#__jshopping_products` c WHERE c.Repertoire_Id IN ("
//                    . join(',', $ids). " ) ; ";
//            if(count($ids)>0)   JFactory::getDBO()->setQuery($delete)->execute();
//        }
        
//	foreach(static::$Repertoires as $id=>$repertoire){// Сортировка репертуаров по имеющимся в базе и неимеющихся 
////            foreach($categories_bd as $id_bd=>$repertoire_bd){ 
////                static::$Repertoires[$id]->category_id = 0;
////                if($repertoire->Name == trim($repertoire_bd->$name)){
//////                if($repertoire->Name ==  ($repertoire_bd->$name)){
////                    static::$Repertoires[$id]->category_image = $repertoire_bd->category_image;
////                    static::$Repertoires[$id]->description    = $repertoire_bd->$description;
////                    static::$Repertoires[$id]->category_id    = $id_bd;
////                    break;
////                } 
////            }
//            if($repertoire->category_id == 0)
//                $Repertoires_NOexist[$id] = static::$Repertoires[$id];  
//            else 
//                $Repertoires_exist[$id] = static::$Repertoires[$id]; 
//        }// toPrint($repertoire->Name);
		
	
	return (object)['Repertoires_NOexist' => $Repertoires_NOexist, 
                        'Repertoires_exist' => $Repertoires_exist, 
                        'Repertoires_existUnpublish'=>$Repertoires_existUnpublish,
                        'Category_bd_only'=>$categories_bd];
    } 
    /**
     * Сравнение продуктов с предложениями, static::$Prods c базой
     * @return array [ $products_exist, $products_NOexist, $products_bd]
     */
    static function ProductsCompare(){
        
        if(!static::$Prods){
            $select =  "SELECT p.product_id, p.RepertoireId FROM `#__jshopping_products` p ; ";
            $products_bd = JFactory::getDBO()->setQuery($select)->loadObjectList("product_id");
            //toPrint($products_bd,'count(static::$Prods) = 0 or NULL ',1,TRUE, TRUE);
            toLog(NULL,'ВНИМАНИЕ НЕТ ЗАГРУЖЕННЫХ ПРОДУКТОВ (БИЛЕТОВ)!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!','day',TRUE);
            //toLog($products_bd,'count(static::$Prods) = 0 or NULL ','day',TRUE);
            return [$products_bd, [], []];        
        } 
        
        $db = JFactory::getDbo(); 
        $name = 'name_'.JFactory::getLanguage()->getTag();
        $description = 'description_'.JFactory::getLanguage()->getTag(); 
		
        $querys = array();
        $rprtrs = array_column(static::$Prods, 'RepertoireId');
//        foreach(static::$Prods as $id=>$prod){//             $xx[]= $db->quote($repertoire->$name); 
//            $querys[] = "SELECT ".$db->quote($prod->Name)." Name, '$prod->EventDateTime' EventDateTime, $prod->RepertoireId RepertoireId, $prod->StageId StageId ";
//            //SELECT Name, EventDateTime FROM 
//        } 
        $query_select =  "SELECT p.*, p.`$name` AS Name, p.`$description` AS description "
                . "FROM `#__jshopping_products` p " 
//                . " , ( ".join(" UNION ",$querys)." ) sel "
                . "WHERE p.RepertoireId IN ( ".join(" , ",$rprtrs)." )"
                . " AND p.RepertoireId != 0 " 
//                . " AND p.date_event = sel.EventDateTime " 
//                . "WHERE p.`$name` = sel.Name AND p.date_event = sel.EventDateTime " 
                . "ORDER BY product_id; ";
//        toPrint($query, ' $query ',"<br><br>");
        $products_bd = JFactory::getDBO()->setQuery($query_select)->loadObjectList("product_id");
// toPrint($products_bd, ' $products_bd '.count($products_bd));
        
        $products_exist = array();
        $products_NOexist = array();

// toPrint(static::$Prods, ' $products_bd '.count(static::$Prods));
//		$i = 0;
        foreach (static::$Prods as $id=>$prod){
            foreach ($products_bd as $id_bd=>$product_bd){
                //4276134002019418 Зотова Наталья Леонидовна
                //if($prod->Name == $product_bd->$name && $prod->EventDateTime== $product_bd->date_event){
                if($prod->RepertoireId == $product_bd->RepertoireId && $prod->EventDateTime == $product_bd->date_event){
                    
                    if($id!=$id_bd){
                        static::$Prods[$id_bd] = static::$Prods[$id];                        
                        unset(static::$Prods[$id]);
                        $id = $id_bd;
                    }
                    static::$Prods[$id]->product_id = $id_bd;
                    
                    if(!empty($product_bd->description))    static::$Prods[$id]->description = $product_bd->description; 
                    if(!empty ($product_bd->image))         static::$Prods[$id]->image = $product_bd->image;//image ,   category_image
                    else                                    static::filecopy($prod->image);                            
                    
                    //static::$Prods[$id]->params['EventDateTime']    = static::$Prods[$id]->EventDateTime;
                    static::$Prods[$id]->params['StageId']          = (int)static::$Prods[$id]->StageId;
                    static::$Prods[$id]->params['category_id']      = (int)static::$Prods[$id]->category_id;
                    static::$Prods[$id]->params['RepertoireId']     = (int)static::$Prods[$id]->RepertoireId;
                    static::$Prods[$id]->params['OffersId']         = array_keys(static::$Prods[$id]->Offers);
                    
                    unset($products_bd[$id_bd]);
                }
            }
            if(static::$Prods[$id]->product_id == 0){//$offer->image = $offer->image; //image ,   category_image
                $prod->params = [];
                $prod->params['StageId']          = (int)$prod->StageId;
                $prod->params['category_id']      = (int)$prod->category_id;
                $prod->params['RepertoireId']     = (int)$prod->RepertoireId;
                $prod->params['OffersId']         = array_keys($prod->Offers);
                        
                $products_NOexist[$id] = $prod;
            }
            else
                $products_exist[$id] = $prod;
        }//     self::$Offers = 1446
        

// toPrint(static::$Prods, ' $products_bd '.count(static::$Prods));
        
//        $prods_onlyBD = [];
//        foreach ($products_bd as $id_bd=>&$product_bd){
//            if(!empty($product_bd->params))
//                $product_bd->params = json_decode($product_bd->params);
//            if(is_object($product_bd->params)){
//                $product_bd->StageId        = isset($product_bd->params->StageId)?$product_bd->params->StageId:0;
//                $product_bd->category_id    = $product_bd->params->category_id;
//                $product_bd->RepertoireId   = $product_bd->params->RepertoireId;
//                $product_bd->OffersId       = $product_bd->params->OffersId; 
//            //$product_bd->Name           = $product_bd->$name;
//            }
//            else{ 
//                $product_bd->params = '';
//                $product_bd->StageId        = 0;
//                $product_bd->category_id    = 0;
//                $product_bd->RepertoireId   = 0;
//                $product_bd->OffersId       = [];  
//            }
//            $product_bd->EventDateTime  = $product_bd->date_event;
//            //if(!isset(static::$Prods[$id_bd]))
//            if(!array_key_exists($id_bd, static::$Prods)){
//                $prods_onlyBD[$id_bd] = $product_bd; //184, 188
//                //toPrint($id_bd, ' $id_bd   $prods_onlyBD   ' );
//            }
//        }
//        toPrint(array_keys(static::$Prods), ' $id_bd   static::$Prods  KEYS ');
//        toPrint(array_keys($prods_onlyBD), ' $id_bd   $prods_onlyBD  KEYS ');
        
        
//        toPrint($prods_onlyBD, ' $prods_onlyBD   Count: '.count($prods_onlyBD),"<br><br>");
//        toPrint($products_bd, ' $products_bd   Count: '.count($products_bd),"<br><br>");
//        toPrint(static::$Prods, ' static::$Prods \t Count: '.count(static::$Prods),"<br><br>");
        
 
        
        return  [ $products_exist, $products_NOexist, $products_bd];
//        return  (object)['products_exist'=>$products_exist,'products_NOexist'=>$products_NOexist,'products_onlyDB'=>$products_bd];
 
    }

    /*
     * Удаление несуществующих сязей и создание новых на основе ID репертуаров и площадок
     * @return int Колличество добавленных строк связей для репертуаров
     */
    public static function SetCatsToProds(){
        
        $db = JFactory::getDbo(); 
        $name = 'name_'.JFactory::getLanguage()->getTag();
        $description = 'description_'.JFactory::getLanguage()->getTag(); 
        $count = 0;
        
//        $querys = array();
//        $cats_id = array();
        
//        if(count($products)==0)
//            $products = static::$Prods;
        //DELETE t1 FROM tbl_name t1, tbl_name t2 WHERE t1.userID=t2.userID AND t1.eventID=t2.eventID AND t1.ueventID < t2.ueventID
        //DELETE FROM LargeTable WHERE ID IN (SELECT ID FROM TemporarySmallTable);
        
        // Удаление несуществующих связей для категорий
        $delete = " DELETE FROM `#__jshopping_products_to_categories` WHERE category_id NOT IN (SELECT category_id FROM `#__jshopping_categories`); ";
        JFactory::getDBO()->setQuery($delete)->execute();
        // Удаление несуществующих связей для продуктов
        $delete = " DELETE FROM `#__jshopping_products_to_categories` WHERE product_id NOT IN (SELECT product_id FROM `#__jshopping_products` ); ";
        JFactory::getDBO()->setQuery($delete)->execute();

        //Установка связей новых продуктов с категориями репертуаров
        if(static::$IdCategoryRepertoires > -1){
            $IdCategoryRepertoires = static::$IdCategoryRepertoires;
//            foreach($products as $id=>$prod){//             $xx[]= $db->quote($repertoire->$name); 
//                $querys[] = "SELECT  $prod->category_id  category_id,  $prod->product_id  product_id, $prod->RepertoireId RepertoireId, $prod->StageId StageId, 1 product_ordering ";
//                            //SELECT Name, EventDateTime FROM 
//                $cats_id[] = $prod->category_id;
//            } 
            $insert  = " INSERT INTO `#__jshopping_products_to_categories` (`category_id`,`product_id`,`product_ordering`) "
                    . " SELECT exst.category_id, exst.product_id, 1 `product_ordering` FROM "
                    . "     (SELECT c.category_id, p.product_id FROM `#__jshopping_products` p, `#__jshopping_categories` c "
                    . "      WHERE c.category_parent_id = $IdCategoryRepertoires AND c.RepertoireId = p.RepertoireId ) exst"
                    . " LEFT JOIN  "
                    . "     (SELECT c.category_id, p.product_id FROM `#__jshopping_products` p, `#__jshopping_products_to_categories` pc, `#__jshopping_categories` c "
                    . "      WHERE c.category_parent_id = $IdCategoryRepertoires AND c.category_id = pc.category_id AND p.product_id = pc.product_id  ) ll "
                    . " ON exst.category_id = ll.category_id AND  exst.product_id = ll.product_id "
                    . " WHERE ll.category_id IS NULL AND ll.product_id IS NULL ; " ;

            JFactory::getDBO()->setQuery($insert)->execute();
            //JFactory::getDBO()->execute();
            $count = JFactory::getDBO()->getAffectedRows ();
            
            //JFactory::getDBO()->execute();
//toPrint($insert, ' $insert ');
//        JFactory::getDBO()->setQuery($insert)->execute();
//toPrint(0, ' $count ');        
//toPrint($count, ' $count ');      

        
//             //{"StageId":950,"category_id":485,"RepertoireId":6172,"OffersId":[981302]}
//            if(count($cats_id)>0){
//                
//                
//                $delete = "DELETE FROM `#__jshopping_products_to_categories` WHERE category_id IN (".  join(',', $cats_id)."); ";
//                
//                $delete = "DELETE FROM `#__jshopping_products_to_categories` WHERE category_id IN (".  join(',', $cats_id)."); ";
//                JFactory::getDBO()->setQuery($delete)->execute();
//            
//                $count = JFactory::getDBO()->getAffectedRows();
//            
//                $insert =  "INSERT INTO `#__jshopping_products_to_categories`( `category_id`, `product_id`, `product_ordering`) "
//                    . "SELECT * FROM ( ".join(" UNION ",$querys)." ) AS cp; ";
//                JFactory::getDBO()->setQuery($insert)->execute();
//            } 
        }
        // _products_to_categories: product_id, category_id, product_ordering
        // _jshopping_products:     RepertoireId, StageId, params
        // _jshopping_categories:   PlaceId, StageId, RepertoireId
        
        //Установка связей новых продуктов с категориями плодащок
        if(static::$IdCategoryStages>-1){      
            $IdCategoryStages = static::$IdCategoryStages;    
            $insert  = " INSERT INTO `#__jshopping_products_to_categories` (`category_id`,`product_id`,`product_ordering`) "
                    . " SELECT exst.category_id, exst.product_id, 1 FROM "
                    . "     (SELECT c.category_id, p.product_id FROM `#__jshopping_products` p, `#__jshopping_categories` c "
                    . "      WHERE c.category_parent_id = $IdCategoryStages AND c.StageId = p.StageId ) exst"
                    . " LEFT JOIN  " 
                    . "     (SELECT c.category_id, p.product_id FROM `#__jshopping_products` p, `#__jshopping_products_to_categories` pc, `#__jshopping_categories` c "
                    . "      WHERE c.category_parent_id = $IdCategoryStages AND c.category_id = pc.category_id AND p.product_id = pc.product_id  ) ll "
                    . " ON exst.category_id = ll.category_id AND  exst.product_id = ll.product_id "
                    . " WHERE ll.category_id IS NULL AND ll.product_id IS NULL ; " ; 
            JFactory::getDBO()->setQuery($insert)->execute();
        }
        
        if(static::$IdCategoriesProducts){
            $IdCategoriesProducts = static::$IdCategoriesProducts;
            $insert = " 
                INSERT INTO #__jshopping_products_to_categories 
                        ( product_id, category_id, product_ordering ) 
                SELECT p1.product_id, $IdCategoriesProducts, 1 FROM #__jshopping_products p1  
                WHERE p1.product_id NOT IN ( 
                    SELECT pc.product_id 
                    FROM #__jshopping_products p, #__jshopping_products_to_categories pc 
                    WHERE p.product_id = pc.product_id 
                        AND pc.category_id = $IdCategoriesProducts 
                        -- AND p.product_id IN ( 2234, 2238, 2266 ) -- (products IDs new products )
                ); " ;
            JFactory::getDBO()->setQuery($insert)->execute();
            
        }
        
        return $count;
    }
    /**
     * Удаление Продуктов, Категорий, Соотношений с несуществующими репертуарами, 
     * удаление несуществующих кроме RepertoireId = 0
     * @param array $products_delete products OR DEFAULT attribute
     * @return int $userId MethodName  for request webservice
     */ 
    public static function ProductsDeleteFromDB(array $products_delete = []){ 
        
//return;
        
        if(count($products_delete)>0){
         
        
            if(is_int($products_delete[0]))
                $prods_id = $products_delete;
            else
                //$prods_id = array_keys($products_delete);
                $prods_id = array_column($products_delete, 'product_id', 'product_id');
        
            $delete = " DELETE FROM `#__jshopping_products_to_categories` pc"
                    . " WHERE  pc.product_id IN "
                    . "(SELECT sel.product_id FROM `#__jshopping_products` p WHERE product_id IN (".  join(',', $prods_id).")) ; ";
            JFactory::getDBO()->setQuery($delete)->execute();
        
            $delete = "DELETE FROM `#__jshopping_products` WHERE product_id IN (".  join(',', $prods_id)."); ";
            JFactory::getDBO()->setQuery($delete)->execute();
            return JFactory::getDBO()->getAffectedRows();
        }    
        
        $rprtrs = array_column(static::$Prods, 'RepertoireId');    
            
            
        if(count($rprtrs)){
            $select = " SELECT NOW(); ";
            
            if(static::$category_old == 'delete')
                $select = " DELETE FROM `#__jshopping_categories` WHERE RepertoireId NOT IN (".  join(',', $rprtrs).") AND RepertoireId != 0; "; 
            elseif(static::$category_old == 'hide')
                $select = " UPDATE `#__jshopping_categories` SET `category_publish` = 0 WHERE RepertoireId NOT IN (".  join(',', $rprtrs).") AND RepertoireId != 0; "; 
            JFactory::getDBO()->setQuery($select)->execute();
         
            
            
            $select = " SELECT NOW(); ";
            if(static::$bilet_delete == 'del')//удаление продуктов удаленных с Репертуаров ЗРИТЕЛИ
                $select = " DELETE FROM `#__jshopping_products` WHERE RepertoireId NOT IN (".  join(',', $rprtrs).") AND RepertoireId != 0; "; 
            elseif(static::$bilet_delete == 'hide')
                $select = " UPDATE FROM `#__jshopping_products` SET `product_publish` = 0 WHERE RepertoireId NOT IN (".  join(',', $rprtrs).") AND RepertoireId != 0; "; 
            JFactory::getDBO()->setQuery($select)->execute();
            
            $ps = JFactory::getDBO()->getAffectedRows();
            //Удаление несуществуующих связей с категориями
            $select = " DELETE FROM `#__jshopping_products_to_categories` WHERE category_id NOT IN (SELECT category_id FROM `#__jshopping_categories`); ";
            JFactory::getDBO()->setQuery($select)->execute();
            //Удаление несуществуующих связей с продуктами
            $select = " DELETE FROM `#__jshopping_products_to_categories` WHERE product_id NOT IN (SELECT product_id FROM `#__jshopping_products` ); ";
            JFactory::getDBO()->setQuery($select)->execute();
            
            return $ps;
        }
             
    }

    
    //($fileCat, '', FALSE, TRUE);
    static function filecopy($fileName, $newName='',  $overWrite = FALSE, $OnlyFullImage = FALSE){ 
        $s = DIRECTORY_SEPARATOR;
        $fileCat = JPATH_ROOT . "{$s}components{$s}com_jshopping{$s}files{$s}img_categories{$s}$fileName"; 
        $file    = JPATH_ROOT . "{$s}components{$s}com_jshopping{$s}files{$s}img_products{$s}";
        if(file_exists($fileCat) && $overWrite ){
            copy($fileCat , $file.$newName.$fileName);
            copy($fileCat , $file."thumb_".$newName.$fileName);
            copy($fileCat , $file."full_".$newName.$fileName);
            return ;
        }
        else if(file_exists($fileCat) && !file_exists($file.$newName.$fileName)  && !$OnlyFullImage){
            copy($fileCat , $file.$newName.$fileName);
            copy($fileCat , $file."thumb_".$newName.$fileName);
            if(!file_exists($file."full_".$newName.$fileName))
                    copy($fileCat , $file."full_".$newName.$fileName);  
            return ;
        }
        else if($OnlyFullImage){
            copy($fileCat , $file."full_".$newName.$fileName); 
            return;
        } // otkrytie._gala-kontsert._novaya_volna1_1000x667-1_715_477_5_100_1_.jpg
//            toLog(JPATH_COMPONENT,'JPATH_COMPONENT');
//            toLog(file_exists($fileCat),'file_exists($fileCat)');
//            toLog(!file_exists($file.$fileName),'!file_exists($file.$fileName)');
//            toLog($fileCat,'$fileCat');
//            toLog($file.$fileName,'$file.$fileName');
//            toLog($file."thumb_".$fileName,'$file."thumb_".$fileName');
//            toLog($file."full_".$fileName,'$file."full_".$fileName');
    }
    



 
    





    
    /**
     * Получение(загрузка) секторов зала и присвоение каждой афере сектора
     * @return array 
     */
    static function UpdateOffersSectorName($StageId, &$Offers){
        $sectors = array();
        
      
        try{//print
            $sectors = SoapClientZriteli::Call_GetSectorListByStageId($StageId, FALSE);
        } catch (Exception $exc) {
//            toPrint($exc->getTraceAsString());
			
            echo "<pre>123\$controller: $controllerobject $controllername<br>".print_r($exc->getTraceAsString(),true)." </pre>";
        }






        $sectors = array_column($sectors, 'Name', 'Id');
        
        foreach ($Offers as $id => &$offer){ 
            $offer->SectorName = $sectors[$offer->SectorId];
            $offer->StageId = $StageId;
//            $offer->StageCatId = $StageCatId;
            $Offers[$offer->Id] = $offer;
            //unset($Offers[$id]);
        } 
        
        return $Offers;
    }

    static function UpdateSectorsFromOffers($StageId, $Offers){
        
    }

    /** 
     * Удаление устарелых и не существующих спектаклей в базе и которых уже нет в репертуаре. 
     */
    static function DeleteOldProducts($params = NULL){
        //$jshopConfig->
         
//return;
        
        $params = $params??static::$Params;
        $time_type = $params->get('bilet_old_hidetime','time')[0]=='t'?'time':'letter';// Тип интервала удаления 
        $time_hours = $h = (int)substr($params->get('bilet_old_hidetime',3), 1);        // Колличество часов
          
        $query = ""; 
        $where = " p.date_event < DATE( NOW()) "; 
        if($time_type == 'letter'){
            $time_event = JDate::getInstance("now -$time_hours")->toSql(TRUE);
            $where = " p.date_event < '$time_event' ";
//            $query = "
//                DELETE FROM #__jshopping_products p
//                WHERE  $where ; ";
            //JFactory::getDBO()->setQuery($query)->execute();
        }
        elseif($time_type == 'time'){
            $where = "
                (HOUR(NOW()) >= $h AND p.date_event < CONCAT(CURDATE(),' $h:00:00')) OR 
                (HOUR(NOW()) < $h AND p.date_event < CONCAT (YEAR(DATE_SUB(NOW(), INTERVAL 1 DAY)),'-',MONTH(DATE_SUB(NOW(), INTERVAL 1 DAY)),'-',DAYOFMONTH(DATE_SUB(NOW(),INTERVAL 1 DAY)),' $h:00:00'))"; 
//            $query = "
//                DELETE FROM #__jshopping_products p
//                WHERE $where ;";
            //JFactory::getDBO()->setQuery($query)->execute();
        }
//        $query = "
//                DELETE FROM #__jshopping_products p
//                WHERE  $where ; ";
        //JFactory::getDBO()->setQuery($query)->execute();
        
        
        
        
        $bilet_old      = $params->get('bilet_old'); //[ "cat","prod","hide","del",""]; //
        
        if ($bilet_old == 'del') { // Удаление прошедших
            $query = "
                    DELETE FROM `#__jshopping_products` 
                    WHERE $where /*AND p.RepertoireId !=0 */ ; ";
            JFactory::getDBO()->setQuery($query)->execute();
//            toPrint($query,'$query!',0,TRUE); 
        }
        
        if ($bilet_old == 'hide') { // Скрытие прошедших
            $query = "
                    UPDATE #__jshopping_products p SET p.product_publish = FALSE
                    WHERE $where /*AND p.RepertoireId !=0 */ ; ";
            JFactory::getDBO()->setQuery($query)->execute();
//            toPrint($query,'$query!  $bilet_old == \'hide\'',0,TRUE); 
        }

        
        //переименовать в one
        if ($bilet_old == 'prod') {// Удаление прошедших кроме одного каждого репертуара, один каждого репертуара скрывается
            $query = "
                    UPDATE #__jshopping_products p SET p.product_publish = FALSE
                    WHERE $where /*AND p.RepertoireId !=0 */ ; ";
            JFactory::getDBO()->setQuery($query)->execute();
//            toPrint($query,'$query!  $bilet_old == \'prod\' 1 ',0,TRUE); 
//            $query = "
//                    DELETE p1 FROM #__jshopping_products p1,  #__jshopping_products p2
//                    WHERE p1.product_publish = FALSE AND p2.product_publish = FALSE 
//                        AND p1.RepertoireId > p2.RepertoireId AND p1.RepertoireId !=0  AND p2.RepertoireId !=0; ";        
//            toPrint(class_exists('jshopConfig'),'class_exists(jshopConfig)',0,TRUE,TRUE);           
//            toPrint(class_exists('JSFactory'),'class_exists(JSFactory)',0,TRUE,TRUE);            
//            toPrint(class_exists('multiLangField'),'class_exists(multiLangField)',0,TRUE,TRUE);       
            $admin_show_languages = TRUE;//JSFactory::getConfig()->admin_show_languages;
            
            $langs = [];//(array)JSFactory::getLang()->lang; 
            if($admin_show_languages){
                $query = "SELECT language FROM #__jshopping_languages WHERE publish = 1; ";
                //toPrint($query,'$query!  $bilet_old == \'prod\' 2 ',0,TRUE); 
                $langs = JFactory::getDBO()->setQuery($query)->loadColumn();
            } 
             
            foreach ($langs as &$l){
                $l = " p.`name_$l` = p2.`name_$l` AND p.`alias_$l` = p2.`alias_$l` ";
            }
            $names_lang = implode(' AND ', $langs);            
            $query = "
                    DELETE p FROM #__jshopping_products p,  #__jshopping_products p2
                    WHERE p.product_id > p2.product_id AND 
                        p.product_publish = FALSE AND p2.product_publish = FALSE  AND $names_lang ; ";    //     AND $where
            JFactory::getDBO()->setQuery($query)->execute();
            
//            toPrint($query,'$query!  $bilet_old == \'prod\' 3 ',0,TRUE);
            
            //было бы неплохо сделать удаление скрытых представлений сгруппированных по категориям репертуара. с заранее обозначенной категорией репертуара
//            $query = "
//                    DELETE p1 FROM #__jshopping_products p1,  #__jshopping_products p2
//                    WHERE p1.product_publish = FALSE AND p2.product_publish = FALSE AND $where AND $names_lang
//                        AND p1.RepertoireId > p2.RepertoireId AND p1.RepertoireId !=0  AND p2.RepertoireId !=0; ";       
        } 
    }


    
    
    /**
     * Очистка всей таблицы для которой превышен порог колличества строк
     */
    static function MaxDeleteCount(){ 
//return;         
        $count_attr = $count_attr_values = $count_products_attr2 = 0;
        
        if($max_attr = static::$max_attr){
            $count_attr = " SELECT count(*) FROM  `#__jshopping_attr` ; ";
            $count_attr = JFactory::getDBO()->setQuery($count_attr)->loadResult();
            if($count_attr > $max_attr){
                $truncate = " TRUNCATE TABLE  `#__jshopping_attr` ; ";
                JFactory::getDBO()->setQuery($truncate)->execute();
            }
        }
        if($max_attr_values = static::$max_attr_values){
            $count_attr_values = " SELECT count(*) FROM  `#__jshopping_attr_values` ; ";
            $count_attr_values = JFactory::getDBO()->setQuery($count_attr_values)->loadResult();
            if($count_attr_values > $max_attr_values){
                $truncate = " TRUNCATE TABLE  `#__jshopping_attr_values` ; ";
                JFactory::getDBO()->setQuery($truncate)->execute();
            } 
        }
        if($max_products_attr2 = static::$max_products_attr2){
            $count_products_attr2 = " SELECT count(*) FROM  `#__jshopping_products_attr2` ; ";
            $count_products_attr2 = JFactory::getDBO()->setQuery($count_products_attr2)->loadResult();
            if($count_products_attr2 > $max_products_attr2){
                $truncate = " TRUNCATE TABLE  `#__jshopping_products_attr2` ; ";
                JFactory::getDBO()->setQuery($truncate)->execute();
            }  
        }
        
//        toPrint(NULL,"\$count_attr:$count_attr,\$count_attr_values:$count_attr_values,\$count_products_attr2:$count_products_attr2".
//                "<br>\$max_attr:$max_attr,\$max_attr_values:$max_attr_values,\$max_products_attr2:$max_products_attr2", 0, $viewText, TRUE);
    }
    
    
    /**
     * обновление картинки и описаний для пустых продуктов из их категорий.
     * Обновление каритнок и описани для продуктов из категории
     * @param int $cat_id Category ID or NULL
     * @return void
     */
    public static function UpdateInfoDescritpion(int $cat_id = 0){
        
        $cat = static::$IdCategoryRepertoires;
        
        if($cat == -1)            return;
         
        $words  = [];
        
        $lang = JFactory::getLanguage()->getTag();
        $words[] = $name           = 'name_'.$lang;
        $words[] = $short_desc     = 'short_description_'.$lang;
        $words[] = $description    = 'description_'.$lang; 
        $words[] = $meta_desc      = 'meta_description_'.$lang; 
        $words[] = $meta_keyword   = 'meta_keyword_'.$lang; 
        $words[] = $meta_title     = 'meta_title_'.$lang; 
        $words[] = $image     = (static::$bilet_new=='cat')?'category_image':'image'; 
        
        $set = [];
//        foreach ($words as $word)
//            $set[] = " p.`$word` = c.`$word` "; 
        
//        $set = join(',',$set);
        
        // short_description_ru-RU   description_ru-RU   meta_description_ru-RU      meta_keyword_ru-RU      meta_title_ru-RU         category_image
        //$update = " SELECT  SUBSTRING_INDEX(SUBSTRING_INDEX(`params`,',\"RepertoireId\"',1),'category_id\":',-1) AS category_id, p.* FROM `#__jshopping_products` AS p WHERE `image`='' AND `RepertoireId`!=0  ORDER BY category_id; ";
    try{ 
        
        static::$bilet_new;//STRING: bilet_new: cat, prod, "";  ""           - Копирование или нет новых представлений  
        
        if(static::$bilet_new=='cat')//Копирование описаний из Категорий
        foreach ($words as $word){
            $update = " UPDATE `#__jshopping_products` p, `#__jshopping_categories` c "
                    . " SET p.`$word` = c.`$word` "
                    . " WHERE p.`RepertoireId`!=0 AND c.`$word`!='' " //p.`$word`='' AND 
                    //. " AND p.RepertoireId = c.RepertoireId "
                    . " AND  SUBSTRING_INDEX(  SUBSTRING_INDEX(p.params,',\"RepertoireId\"',1)  ,'category_id\":',-1) = c.category_id ; ";
            JFactory::getDBO()->setQuery($update)->execute();
        }
        if(static::$bilet_new=='prod')// Копирование описаний из Продуктов
        foreach ($words as $word){
            $update = " UPDATE #__jshopping_products p 
                        JOIN ( 
                            SELECT MIN(p_r.product_id) pr_id, p_r.`$word` pr_name, p_w.product_id pw_id, p_w.`$word` pw_name, p_w.RepertoireId
                            FROM  `#__jshopping_products` p_w, `#__jshopping_products` p_r 
                            WHERE p_w.RepertoireId !=0 AND p_w.RepertoireId = p_r.RepertoireId AND p_r.`$word` != '' AND p_w.`$word`='' 
                            GROUP BY p_r.RepertoireId) g 
                        ON p.product_id = g.pw_id 
                        SET p.`$word` = g.pr_name ; " ; 
            JFactory::getDBO()->setQuery($update)->execute();
        }
        
        if(static::$bilet_new=='cat'){//Копирование Картинок из Категорий
            $insert = " INSERT INTO `#__jshopping_products_images` (product_id, image_name, `name`,`ordering`) "
                    . " SELECT pc.product_id, c.category_image, c.`$name`, 1 "
                    . " FROM `#__jshopping_categories` c, `#__jshopping_products_to_categories` pc, `#__jshopping_products` AS p"
                    . " WHERE p.product_id=pc.product_id AND pc.category_id = c.category_id "
                    . "    AND c.category_image NOT IN  ("
                    . "             SELECT i.image_name "
                    . "             FROM `#__jshopping_products_images` AS i "
                    . "             WHERE i.product_id=p.product_id ) "
                    . "    AND c.category_image!='' "
                //. " AND c.RepertoireId = p.RepertoireId AND c.category_parent_id = $cat "
                //. " AND p.image='' "
                //. " AND p.RepertoireId!=0 "
                    . " ; ";
            JFactory::getDBO()->setQuery($insert)->execute();
        }
        if(static::$bilet_new=='prod'){//Копирование Картинок из Продуктов
            $insert = " INSERT INTO `#__jshopping_products_images` (product_id, image_name, `name`,`ordering`) 
                        SELECT s.product_id , s.image_name, s.`name`, s.ordering
                        FROM (SELECT p_write.product_id , ir.image_name, ir.name, ir.ordering, p_write.RepertoireId , MIN(pr.product_id) 
                            FROM #__jshopping_products pr, #__jshopping_products_images ir, (
                                SELECT pw.product_id, i.image_name, pw.`name_ru-RU` , pw.RepertoireId
                                FROM #__jshopping_products pw 
                                LEFT JOIN #__jshopping_products_images i 
                                ON pw.product_id = i.product_id 
                                WHERE i.image_name IS NULL) p_write 
                            WHERE pr.product_id = ir.product_id AND p_write.RepertoireId = pr.RepertoireId --AND ir.image_name IS NOT NULL
                        GROUP BY p_write.product_id) s ; ";
            JFactory::getDBO()->setQuery($insert)->execute();
        }
        
        //toPrint($insert);
//        toLog($insert,2);
 
        return ;
        
        $update = " UPDATE `#__jshopping_products` p, `#__jshopping_categories` c, `#__jshopping_products_to_categories` pc  "
                . " SET p.image = c.category_image "
                . " WHERE  pc.product_id = p.product_id AND pc.category_id = c.category_id "
                //. " AND c.RepertoireId = p.RepertoireId AND p.`RepertoireId`!=0 "
                //. " AND c.category_parent_id = $cat "
                . " AND p.`image`='' AND c.category_image!='' ; ";
        JFactory::getDBO()->setQuery($update)->execute();
        
//        toLog($update,4);
            if($cat_id)
                $update = " UPDATE `#__jshopping_products` p, `#__jshopping_categories` c, `#__jshopping_products_to_categories` pc  "
                    . " SET p.image = CONCAT_WS('', '',c.category_image,'') "
                    . " WHERE  pc.product_id = p.product_id AND pc.category_id = c.category_id " 
                    //. " AND c.RepertoireId = p.RepertoireId AND p.`RepertoireId`!=0 "
                    . " AND c.category_id = $cat_id  "
                    //. " AND c.category_parent_id = $cat "
                    . " AND c.category_image!='' ";//. " AND p.`image`='' ; ";
            else
                $update = " UPDATE `#__jshopping_products` p, `#__jshopping_categories` c, `#__jshopping_products_to_categories` pc  "
                    . " SET p.image = CONCAT_WS('', '',c.category_image,'') "
                    . " WHERE  pc.product_id = p.product_id AND pc.category_id = c.category_id " 
                    . " AND c.RepertoireId = p.RepertoireId AND p.`RepertoireId`!=0 "
                    //. " AND c.category_id = $cat_id  "
                    . " AND c.category_parent_id = $cat "
                    . " AND c.category_image!='' ";//. " AND p.`image`='' ; ";
            JFactory::getDBO()->setQuery($update)->execute();
//        toLog($update,5);
        
            //Удаление картинок для которых нет продуктов.
            $delete = " DELETE FROM `#__jshopping_products_images` WHERE product_id NOT IN ( SELECT p.product_id FROM `#__jshopping_products` AS p ); ";
            JFactory::getDBO()->setQuery($delete)->execute();
        
            //Удаление дубликатов картинок для отдельных продуктов
            $delete = " DELETE i1 FROM #__jshopping_products_images i1, #__jshopping_products_images i2 "
                    . " WHERE i1.product_id = i2.product_id AND  i1.image_name = i2.image_name AND i1.image_id< i2.image_id; ";
            JFactory::getDBO()->setQuery($delete)->execute();
        
        
            $insert = " INSERT INTO #__jshopping_products_images (image_name,product_id,`name`,`ordering`)  " 
                    . " SELECT p.image image_name, p.product_id, p.`name_ru-RU` `name`,1 "
                    . " FROM #__jshopping_products p WHERE NOT EXISTS (" 
                    . "     SELECT * FROM  #__jshopping_products_images im "
                    . "     WHERE im.product_id = p.product_id)  AND  p.image!=''; ";  
            JFactory::getDBO()->setQuery($insert)->execute();

//        toLog($insert,6); 
//        toLog($images,7);
        
            //foreach ($images as $image)
                //static::filecopy($image->category_image);     
        }
        catch (Exception $e){ 
            toLog($e->getMessage(),'Exception ERROR!!! UpdateInfoDescritpion()');
        //toLog($images,'Exception ERROR!!! $images');
        }
        //UPDATE `#__jshopping_products` SET `image`='' WHERE 1;
        
        
//        toLog($select);
//        toLog($images);
        
//{"StageId":950,"category_id":1332,"RepertoireId":6226,"OffersId":[991762],"StageCatId":"1164"}
    }
    
    /**
     * Добавляет картинки к продктам взятые из других продуктов тогоже репертуара
     * @return array products Возвращает продукты в которых нет описания либо картинрок
     */
    public static function NewInfoInsertForProduct():array{
        
        //return;
        $lang = JFactory::getLanguage()->getTag();
        $words[] = $name           = 'name_'.$lang;
        $words[] = $short_desc     = 'short_description_'.$lang;
        $words[] = $description    = 'description_'.$lang; 
        $words[] = $meta_desc      = 'meta_description_'.$lang; 
        $words[] = $meta_keyword    = 'meta_keyword_'.$lang; 
        $words[] = $meta_title    = 'meta_title_'.$lang; 
         
        $update = " UPDATE #__jshopping_categories c, #__jshopping_products_to_categories pc, #__jshopping_products p 
                    SET p.image = c.category_image, 
                        p.`$name` = c.`$name` , p.`$short_desc` = c.`$short_desc` , p.`$description` = c.`$description` , 
                        p.`$meta_desc` = c.`$meta_desc` , p.`$meta_keyword` = c.`$meta_keyword` , p.`$meta_title` = c.`$meta_title`   
                    WHERE c.category_id = pc.category_id AND pc.product_id = p.product_id       AND (c.category_image !='' OR c.`description_ru-RU`) 
                        AND (p.image = '' OR p.`description_ru-RU` = '') ; ";
        
        
        JFactory::getDBO()->setQuery($update)->execute();
        
        //    $Pid = $prod->product_id;
        //    $Rid = $prod->RepertoireId;
//                $prod->params['StageId']          = (int)$prod->StageId;
//                $prod->params['category_id']      = (int)$prod->category_id;
//                $prod->params['RepertoireId']     = (int)$prod->RepertoireId;
//                $prod->params['OffersId']         = array_keys($prod->Offers);
        $insert = " INSERT INTO #__jshopping_products_images (image_name,product_id,`name`,`ordering`) 
                    SELECT pim.image_name, p_new.product_id, p_new.`name_ru-RU`, 1 
                    FROM `#__jshopping_products` p_new, ( 
                            SELECT p.product_id, p.RepertoireId, pi.image_name 
                            FROM #__jshopping_products_images pi,`#__jshopping_products` p 
                            WHERE p.product_id = pi.product_id ) pim 
                    WHERE   p_new.product_id NOT IN (SELECT product_id FROM #__jshopping_products_images) 
                        AND p_new.RepertoireId != 0 
                        AND p_new.RepertoireId  = pim.RepertoireId 
                    GROUP BY p_new.product_id 
                    ORDER BY p_new.product_id ; ";
        JFactory::getDBO()->setQuery($insert)->execute();
            
        $select = " SELECT p.`name_ru-RU` AS name,
                        p.*, p.product_id AS id, GROUP_CONCAT(c.category_id ORDER BY c.category_id SEPARATOR ',' ) AS cats 
                    FROM   #__jshopping_categories c, #__jshopping_products_to_categories pc, #__jshopping_products p  
                    WHERE  c.category_id = pc.category_id AND pc.product_id = p.product_id       AND (c.category_image !='' OR c.`description_ru-RU` = '') 
                        AND (p.image = '' OR p.`description_ru-RU` = '') 
                    GROUP BY p.product_id 
                    ORDER BY p.product_id ; ";
        $prods = JFactory::getDBO()->setQuery($select)->loadObjectList('id');
        
        return $prods;
    }


    /** 
     * Загрузка Площадок , Добавление площадок в базу, Обновление площадок из базы
     * @param JRegistry $params
     * @param type $gley
     * @return array Категории площадок если выбран родитель
     * @throws Exception
     */
    public static function UpdateLoadStages(JRegistry $params = NULL, $gley = " — "){
         

        
        if(is_null($params))
            $params = static::$Params;
        
        
        $catId_stages = (int)$params->get('CategoriesStages', 0);       // ID категории категорий площадок
        $StagePlaces_id = $params->get('StagePlaces', []);              //Массив площадок из параметров.
        $view_Name_Place = $params->get('view_Name_Place', 0);
        $gley = ($view_Name_Place)? $gley : '';
//toPrint($catId_stages, ' $catId_stages    ',0,TRUE,TRUE);
//toPrint($StagePlaces_id, ' $StagePlaces_id    '.count($StagePlaces_id),0,TRUE,TRUE);
        if($catId_stages < 1)
            return [];
       

        
        $db = JFactory::getDbo(); 
        $lang = JFactory::getLanguage()->getTag();
        $name = 'name_'.$lang;
        $short_desc = 'short_description_'.$lang;
        $description = 'description_'.$lang; 
        
        
        $cs = array();
        $cats = array();
        
        try { 
            //Загрузка площадок из базы
            $query = " SELECT  category_id, category_parent_id,category_publish,ordering,PlaceId,StageId,RepertoireId, `$name` Name, `$short_desc` short_desc, `$description` description "
                . " FROM `#__jshopping_categories` WHERE category_parent_id = $catId_stages; ";
            $cats = JFactory::getDBO()->setQuery($query)->loadObjectList('category_id'); //category_id   StageId
            $cs = array_column($cats, 'StageId', 'category_id');        //Площадки из базы на слу
//toPrint($cats, ' $cats    '.count($cats),0,TRUE,TRUE);
//toPrint($cs, ' $cs    '.count($cs),0,TRUE,TRUE);
        
        } catch (Exception $exc) {
//            toPrint($exc->getTraceAsString());
//            toLog($exc->getTraceAsString());
            echo "<pre> <br>".print_r($exc->getTraceAsString(),true)." </pre>";
            throw $exc;
        }





        try {//print
            if ($view_Name_Place)
                $NamePlaces = SoapClientZriteli::Call_GetPlaceList(FALSE); // Площадки(театры) из сервиса
            // array Площадок Places object[PlaceId]  (Name,PlaceId, _url) 
        } catch (Exception $exc) {
//            toPrint($exc->getTraceAsString());
//            toLog($exc->getTraceAsString());
            echo "<pre> <br>".print_r($exc->getTraceAsString(),true)." </pre>";
            
            throw $exc;
        }



        $newCats = [];
        $oldCats = [];
        $CatsDB = [];
        $querys = [];
        foreach ($StagePlaces_id as $Id => $stage){
                list($stageId,$teatrId) = explode ('-',$stage);
                $stageId = (int)$stageId;
                unset($StagePlaces_id[$Id]);
                $stgs = array();
                try {//print
                    $stgs = SoapClientZriteli::Call_GetStageListByPlaceId($teatrId, FALSE); //(int)$teatrId;   
                    //array Stages object[StageId] (Name(StageName),Address,Id(StageId), PlaceId, _url_0, _url_1)
                        
                } catch (Exception $exc) {
//                    toPrint($exc->getTraceAsString());
//                    toLog($exc->getTraceAsString());
            echo "<pre> <br>".print_r($exc->getTraceAsString(),true)." </pre>";
                    throw $exc;
                }

                if(isset($stgs[$stageId]))
                    $StagePlaces_id[$stageId] = $stgs[$stageId];
                else{
                    $StagePlaces_id[$stageId] = new stdClass();
                    $StagePlaces_id[$stageId]->Name = '';
                    $StagePlaces_id[$stageId]->Teatr = '';
                }
                $StagePlaces_id[$stageId]->StageId = (int)$stageId;
                $StagePlaces_id[$stageId]->TeatrId = $teatrId;
                $StagePlaces_id[$stageId]->category_id = 0;
                $StagePlaces_id[$stageId]->StageCatId  = 0;
                
                try {
                    $StagePlaces_id[$stageId]->Teatr = ($view_Name_Place)? $NamePlaces[ $stgs[$stageId]->PlaceId ]->Name : '' ;
                } catch (Exception $exc) {
            echo "<pre> <br>".print_r($exc->getTraceAsString(),true)." </pre>";
//                    toPrint($exc->getTraceAsString(),
//                            "\$view_Name_Place:$view_Name_Place, \$stageId:$stageId".(empty($stgs[$stageId])?'-':"$stgs[$stageId]->PlaceId"));
//                    toLog($exc->getTraceAsString(),
//                            "\$view_Name_Place:$view_Name_Place, \$stageId:$stageId".(empty($stgs[$stageId])?'-':"$stgs[$stageId]->PlaceId"));
                    
                    
                    throw $exc;
                }
                try {
                    $Address = "";//$StagePlaces_id[$stageId]->Address;
                    $StagePlaces_id[$stageId]->Title = trim($StagePlaces_id[$stageId]->Name) . ($view_Name_Place)? ("".trim($StagePlaces_id[$stageId]->Teatr)."" . $gley) : '';
                } catch (Exception $exc) {
            echo "<pre> <br>".print_r($exc->getTraceAsString(),true)." </pre>";
//                    toPrint($exc->getTraceAsString());
//                    toLog($exc->getTraceAsString());
                    
                    
                    throw $exc;
                }



                
                
                
//                $c = in_array($stageId, $cs);// $cs[$stageId];
            $c_id = array_search($stageId, $cs);// $cs[$stageId];
            if(!is_null($c_id)){
                $StagePlaces_id[$stageId]->category_id = $cats[$c_id]->category_id;
                $StagePlaces_id[$stageId]->StageCatId  = $cats[$c_id]->category_id;
                 unset($cats[$c_id]);
            }
//            else 
//                $StagePlaces_id[$stageId]->category_id = 0;
           
            
//                foreach ($cats as $category_id=>$cat){
//                    if(trim($cat->Name) == trim($StagePlaces_id[(int)$stageId]->Title)){
//                        $StagePlaces_id[(int)$stageId]->category_id = $cat->category_id;
//                    }
//                }
            if($StagePlaces_id[$stageId]->category_id == 0){
                $newCats[$stageId] = &$StagePlaces_id[$stageId];
            }else{
                $oldCats[$stageId] = &$StagePlaces_id[$stageId];
            }
        } 
        
        $f = reset($cats);
//        
        if(count($cats)>0){ 
            $query = "DELETE FROM `#__jshopping_categories` WHERE category_parent_id = $catId_stages AND category_id IN (".  join(',', array_keys($cats))."); ";
//            toPrint($query,'$query',0,true,true);
            JFactory::getDBO()->setQuery($query)->execute();
        }
        
        if(count($newCats)==0)
            return $StagePlaces_id;
        
         
        if(is_null($f) || !$f)
            $f = (object)['products_page'=>12,'products_row'=>2];
        
//        toPrint($f," \$f");
//        toPrint($cats," \$cats");
         
        foreach ($newCats as $cat){ 
            if($cat->PlaceId && $cat->Id)
            $querys[] = "\n($catId_stages,1,1,1,1,$f->products_page,$f->products_row,".$db->quote ("$cat->Teatr $gley $cat->Name") .",".$db->quote ($cat->Address??'') .",$cat->PlaceId,$cat->Id)";
        }
        
        $query_insert =" INSERT INTO `#__jshopping_categories` "//$f->product_page
                    . " (category_parent_id,category_publish,category_ordertype,ordering,access,products_page,products_row,`$name`,`$short_desc`, PlaceId, StageId)"
                    . " VALUES " .  join(',', $querys)."; "; 
//            toPrint($query_insert,"UpdateLoadStages(): \$query_insert - count:".count($querys));
        if($querys)
            JFactory::getDBO()->setQuery($query_insert)->execute();
        
//        toPrint($query_insert, ' $query_insert    '.count($newCats),"<br><br>");
//        toPrint($newCats, ' $query_insert    '.count($newCats),"<br><br>");
//        toPrint($f, ' $f    '.count($f),"<br><br>");
        $query = " SELECT *, `$name` Name, `$short_desc` short_desc, `$description` description "
               . " FROM `#__jshopping_categories` WHERE category_parent_id = $catId_stages; ";
        $cats = JFactory::getDBO()->setQuery($query)->loadObjectList('StageId');
        
//        toPrint($newCats,'$newCats');
        
        foreach($newCats as $stageId => $stage){
            if(!isset($stage)) 
//				toPrint ($stage,'$stage');
				echo "<pre> <br>".print_r($stage,true)." </pre>";
            if(!isset($cats[$stageId])) 
//				toPrint ($stage,'$stage');
				echo "<pre> <br>".print_r($stage,true)." </pre>";
            if(!isset($StagePlaces_id[$stageId])) 
//				toPrint ($stage,'$stage');
				echo "<pre> <br>".print_r($stage,true)." </pre>";
            
            $StagePlaces_id[$stageId]->category_id = $cats[$stageId]->category_id;//1786 ошибка в админке плагина, при отсутствующих родительских Категорий
            $StagePlaces_id[$stageId]->StageCatId  = $cats[$stageId]->category_id;
            
//            foreach ($cats as $category_id=>$cat) 
//                if(trim($cat->Name) == trim($StagePlaces_id[$stageId]->Title)) 
//                    $StagePlaces_id[$stageId]->category_id = $cat->category_id; 
        }
             
        
        return $StagePlaces_id;
    }

    /**
     * Обновление цен для изменяющихся цен продуктов.
     */
    public static function UpdateLoadCostCarencys(){
        
    }

    











    /**
     * Загрузка и обновление мест, цен и атрибутов и рядов для представления
     * @param type $productBD
     * @param type $productId
     * @param type $RepertoireId
     * @param type $eventDateTime
     * @return type
     */
    public static function LoadAllPiecesFromProducts( $productBD=null, $productId=0, $RepertoireId=0, $eventDateTime=''){
//        return;
        
        
        if(!static::$UpdateOffers)
            return;
        //global $Zriteli_repertoire_download_enabled
        if(!static::$Zriteli_places_download_enabled)
            return;
        //toPrint($productId, ' $productId    '.count($productId),"<br><br>");
        
        $db = JFactory::getDbo(); 
        $lang = JFactory::getLanguage()->getTag();
        $name = 'name_'.$lang;
        $description = 'description_'.$lang;
        $langs = PlaceBiletHelper::GetLanguages();
        
        
//        $path = JPATH_PLUGINS.'/jshopping/placebilet/';    //$path = JPATH_PLUGINS.'/jshopping/placebilet/language/'.'ru-RU';  
//        $l->load('PlaceBilet', $path, 'ru-RU', TRUE);
        
//        JFactory::getLanguage()->load('placebilet', $path, 'ru-RU', TRUE);
             
 // <editor-fold defaultstate="collapsed" desc="Инициализация параметров из атрибутов метода">

        if (is_object($productBD) && is_object($productBD->params)) {

            $params = $productBD->params;
            $RepertoireId = $productBD->RepertoireId;
            $StageId = $productBD->StageId;
            $productBD->EventDateTime = $productBD->date_event;

            $eventDateTime = $productBD->date_event;
            $StageCatId = $params->StageCatId;
        }else if (is_object($productBD) && !is_object($productBD->params)) {

            $params = json_decode($productBD->params);
            $productBD->params = $params;
            if (!is_object($params))
                return;
            $productBD->StageId = $params->StageId;
            $productBD->category_id = $params->category_id;
            $productBD->StageCatId = $params->StageCatId;
            $productBD->RepertoireId = $params->RepertoireId;
            $productBD->OffersId = $params->OffersId;

            $productBD->EventDateTime = $productBD->date_event;

            $RepertoireId = $productBD->RepertoireId;
            $StageId = $productBD->StageId;
            $eventDateTime = $productBD->date_event;

        }else if ($productId != 0 && !is_object($productBD)) {
            $query = "SELECT * FROM `#__jshopping_products` WHERE product_id=$productId LIMIT 1; ";
            $productBD = JFactory::getDBO()->setQuery($query)->loadObject();
            if (!isset($productBD))
                return;
            if (empty($productBD->params))
                return;
            $params = json_decode($productBD->params);
//            toPrint($offers, ' $offers    '.count($params) );
            $productBD->params = $params;

            if (is_object($params)) {
//                $productBD->StageId = $params->StageId;
                $productBD->category_id = $params->category_id;
//                $productBD->RepertoireId = $params->RepertoireId;
                $productBD->OffersId = $params->OffersId;
                $productBD->StageCatId = $params->StageCatId;

            }


            $RepertoireId = $productBD->RepertoireId;
            $StageId = $productBD->StageId;
            $productBD->EventDateTime = $productBD->date_event;

            $eventDateTime = $productBD->date_event;
        }else if ($productId == 0 && !is_object($productBD) && $RepertoireId != 0 && $eventDateTime != '') {
            $query = " SELECT * FROM `#__jshopping_products` p " // , `#__jshopping_products_to_categories` pc, `#__jshopping_categories` c
                    . " WHERE  p.`RepertoireId` = $RepertoireId  " // pc.product_id = p.product_id AND pc.category_id = c.category_id 
                    . " AND c.`date_event`= '$eventDateTime' LIMIT 1; "; //         {"StageId":"10","category_id":475,"RepertoireId":6210,"OffersId":[989086]}
            $productBD = JFactory::getDBO()->setQuery($query)->loadObject(); //      {"StageId":950,"category_id":485,"RepertoireId":6172,"OffersId":[981302]}
            if (!isset($productBD))
                return;
            if (empty($productBD->params))
                return;
            $params = json_decode($productBD->params);
            $productBD->params = $params;

            if (is_object($params)) {
//                $productBD->StageId = $params->StageId;
                $productBD->category_id = $params->category_id;
//                $productBD->RepertoireId = $params->RepertoireId;
                $productBD->OffersId = $params->OffersId;
                $productBD->StageCatId = $params->StageCatId;

            }
            $RepertoireId = $productBD->RepertoireId;
            $StageId = $productBD->StageId;
            $productBD->EventDateTime = $productBD->date_event;

            $eventDateTime = $productBD->date_event;
        }else
            return;
        // </editor-fold> 


        if($RepertoireId == 0 || $eventDateTime == '')
            return;
    
        static::$UpdateOffers = FALSE;
        
        $productId = $productBD->product_id;
        $StageCatId =(isset($productBD->StageCatId))? $productBD->StageCatId : 0;
        $category_id = (isset($productBD->category_id))? $productBD->category_id: 0;
        $OffersId = (isset($productBD->OffersId))? $productBD->OffersId: [];
        
// toPrint($OffersId, "\$RepertoireId:->  $RepertoireId  <br>\$eventDateTime:->  $eventDateTime    <br>\$category_id:->  $category_id    <br>\$StageCatId:->  $StageCatId       <br>\$StageId:->  $StageId   <br>\$OffersId"  ); 
//        toPrint($OffersId, ' $OffersId'  );
//    return;

        /**
         * Список предложений для предствления
         * @var array 
         */
        $offers = array();
        try {
            $offers = SoapClientZriteli::Call_GetOfferListByEventInfo($RepertoireId, $eventDateTime, FALSE); 
        } catch (Exception $exc) {
            toLog($exc->getTraceAsString());
        }

        
 //return;
//        toPrint($offers);
        
//         toPrint($offers, ' $offers    '.count($offers)."",0);
//        $sectors = SoapClientZriteli::Call_GetSectorListByStageId($productBD->StageId, FALSE);
  
/**
         * Добавление секторов для событий агентов.
         */
        static::UpdateOffersSectorName($productBD->StageId,$offers);
        //$offers = static::UpdateOffersSectorName($productBD->StageId,$offers);
        
// toPrint( $offers  , ' $offers    ','',2);
 
        /**
         * Места, только места с доп информацией, т.е. все места загруженные из ЗРИТЕЛЕЙ
         * @var array 
         */
        $SeatS = array();
        /**
         * Атрибуты (Ряды) сайта загруженные с ЗРИТЕЛИ
         * @var array 
         */
        $SeatsAttr = $MestaAttr = [];
 
        
// <editor-fold defaultstate="collapsed" desc="Инициализация Атрибутов. Создание Рядов(атрибутов) в каждом с местами(ценами, и др. в каждом)">

//        toPrint($offers,'$offers -  Предложения: ');

        foreach ($offers as &$offer) {
            $offer->category_id = $category_id;
            $offer->StageCatId = $StageCatId;
            
            $offerRow = $offer->Row; 
            $offerRowNum = (int)$offerRow;
            if($offerRowNum == 0 || strlen($offerRowNum) != strlen(trim($offerRow))){ 
//                $offerRowCode = (int)bin2hex(mb_convert_encoding($offerRow, 'UCS-2', 'UTF-8'));
//                $offerRowCode = bindec(mb_convert_encoding($offerRow, 'UCS-2', 'UTF-8'));
                $offerRowNum = ord(trim($offer->Row)); 
            }
            
            $OrderId = $offer->SectorId * 1000 + $offerRowNum;
            
//            if(is_string($offer->Row))
//                toPrint($offer,'Срока-Row'); 
//            toPrint($offer->Row,'$offer->Row');
//            toPrint($OrderId.' !! SectorId:'.$offer->SectorId.'! - Row:'.$offer->Row.'! '); 

            
            
 /** Проверка наличия ряда в только что созданном массиве, и если его нет то содается новый  */
            if (!isset($SeatsAttr[$OrderId])) {
                    $attr = new Attribute();
                    //$SeatsAttr[$Seat->SectorId][$Seat->Row]->             // Умолчания присвоить.
                    $attr->attr_admin_type = 4;
                    $attr->group = 0;
                    $attr->allcats = 0;
                    $attr->independent = 1;
                    $attr->attr_type = 0;
                    $attr->attr_ordering = 1;
                    //$attr->attr_id = 0;

                    $attr->OrderId = $OrderId;

                    $attr->SectorName = $offer->SectorName;
                    
                    $pr = ($offer->Row)? PlaceBiletHelper::mb_str_pad(trim((string)$offer->Row), 3, " ", STR_PAD_LEFT). JText::_('JSHOP_ROW'):'   ';
                        
                    //$attr->Name = $pr . (($offer->Row)?$offer->Row . JText::_('JSHOP_ROW'):'') . JText::sprintf('JSHOP_U1',$offer->Row) . $offer->SectorName . JText::_('JSHOP_U2');
                    $attr->Name = $pr .  ' '. $offer->SectorName ;
                    $attr->$name = $attr->Name;
                    $attr->cat_s = [$StageCatId]; //(array)
                    $attr->cats = serialize((array) $StageCatId);
                    $attr->Row = $offer->Row;


                    $attr->StageCatId = $StageCatId;
                    $attr->StageId = $offer->StageId;
                    $attr->_RepertoireId = $offer->RepertoireId;
                    $attr->_category_id = $offer->category_id;
                    $attr->SectorId = $offer->SectorId;
                    $attr->_EventDateTime = $offer->EventDateTime;
//                    $attr->AgentId = $offer->AgentId;
//                    $attr->ETicket = $offer->ETicket;
//                    $attr->SectorId = $offer->SectorId;


                    $attr->attr_id = 0;


//                    toPrint($Seat->Row ,' $row:   ' );  
//                    toPrint($Order  );   
//                    $MestaAttr[] =  $attr;
//                    $SeatsAttr[$offer->SectorId][$offer->Row] = $attr;
//                    $SeatsAttr[$offer->SectorId][$offer->Row]->SeatSCount = 0;
//                    $SeatsAttr[$offer->SectorId][$offer->Row]->SeatS = [];
                    $SeatsAttr[$OrderId] = $attr;
                    $SeatsAttr[$OrderId]->SeatSCount = 0;
                    $SeatsAttr[$OrderId]->SeatS = [];
            }

            foreach ($offer->SeatList as $_Seat) {
                /**
                 * Создане Места(объекта) с ценой и другой информацией для того чтобы добавить в массив, который лежит в ряду(атрибуте)
                 * @var object 
                 */
                $Seat = new Seat();
                            $Seat->OrderId =  $OrderId;
                            $Seat->StageId =  $offer->StageId;
                            $Seat->StageCatId =  $StageCatId;
                            $Seat->RepertoireId =  $offer->RepertoireId;
                            $Seat->category_id =  $offer->category_id;
                            $Seat->SectorId =  $offer->SectorId;
                            $Seat->SectorName =  $offer->SectorName;
                            $Seat->OfferId =  $offer->Id;
                            $Seat->EventDateTime =  $offer->EventDateTime;
                            $Seat->AgentId =  $offer->AgentId;
                            $Seat->ETicket =  $offer->ETicket;
                            $Seat->NominalPrice =  $offer->NominalPrice;
                            $Seat->AgentPrice =  $offer->AgentPrice;
                            $Seat->Row = $offer->Row;
                            $Seat->Seat          = $_Seat;
                /* ДОбавления места в массив всех мест*/
                $SeatS[] = $Seat;
                $SeatsAttr[$OrderId]->SeatSCount += 1;
                $SeatsAttr[$OrderId]->SeatS[] = $Seat;  //Раскоментировать!!!!!!!!!!!!!!!!
////                $SeatsAttr[$OrderId]->SeatSCount = count($SeatsAttr[$Seat->SectorId][$Seat->Row]->SeatS);
////                unset($SeatsAttr[$OrderId]->SeatS);
            }
        }
        // </editor-fold>
        
//        toPrint($SeatsAttr);
/**
         * Сортировка рядов (атрибутов)
         */
        ksort($SeatsAttr); 
        $MestaAttr = &$SeatsAttr;
 
      
//        toPrint($MestaAttr);
        
        
        
//toPrint($SeatsAttr ,' $SeatsAttr   ','',1 );    
//toPrint($MestaAttr ,' $MestaAttr   ','',1 );   
//toPrint($SeatS ,' $SeatS   '  );   
        
        
        
//        $attrs_new = [];
//        $attrs_exist = [];
//        $attrs_db = [];
        
        // Добавление атрибутов в базу

 
       
//--------------------------------------------------------------------------------------        
//                                  Добавление Атрибутов - добавление рядов
//--------------------------------------------------------------------------------------  

        
        //Сортировка загруженных атрибутов с ЗРИТЕЛИ на новые, имеющиеся, старые. 
        // $MestaAttr - загруженные атрибуты с ЗРИТЕЛИ
        // $StageCatId - ID категории категорий площадок, взято из конфига
        list($attrs_new, $attrs_exist, $attrs_db) = static::attribute_sorting_compare($StageCatId, $MestaAttr); 
      
//        toPrint($attrs_exist,'$attrs_exist');
//        toPrint($attrs_new,'$attrs_new');
//        toPrint($attrs_db,'$attrs_db');
  
       
//toPrint(JSFactory::getLang()->tableFields['attr'],'LangAttr',0);
//toPrint(JSFactory::getLang(),'JSLang');

// <editor-fold defaultstate="collapsed" desc="Запрос БД добавления в базу несуществующих атрибутов">

//  toPrint($langs,'$langs',0);
//  toPrint(PlaceBiletHelper::GetFieldsLangs('name'),'NAmes',0);
        $countLangs = count(PlaceBiletHelper::GetLanguages()); 
        $querys = [];
        foreach ($attrs_new as $sort => $attr){
            $querys[] = " ( $attr->StageId,'$attr->Row',$attr->SectorId,$attr->StageCatId, " . $db->quote($attr->cats) //??''
                . ",   4,0,0,1,0, '$attr->OrderId', " 
                . str_repeat('\'\',',$countLangs) 
                . implode(',', array_fill(0,$countLangs,$db->quote($attr->Name))) . " ) "; //$db->quote($db->escape($repertoire->Name),false)
        }
        if (count($querys) > 0)        
            $query_insert = " INSERT INTO `#__jshopping_attr` "
                . "( StageId,`Row`,SectorId,StageCatId,cats,     attr_admin_type,`group`,allcats,independent,attr_type,attr_ordering, "
                . implode(',', $db->qn(PlaceBiletHelper::GetFieldsLangs('description'))).', '
                . implode(',', $db->qn(PlaceBiletHelper::GetFieldsLangs('name'))).") "
                . " VALUES " . join(', ', $querys) . " ; ";
   
//        toPrint($query_insert,' $query_insert   ' );
        if (count($querys) > 0)            
            JFactory::getDBO()->setQuery($query_insert)->execute(); // 
        
        
//        toPrint($query_insert,' $query_insert   ' );

//            </editor-fold> 
 
//--------------------------------------------------------------------------------------        
//                                  Добавление мест для продукта
//--------------------------------------------------------------------------------------        
 
// <editor-fold defaultstate="collapsed" desc="$attr_values_compare(): функция сравнения мест">

        $attr_values_compare = function () use(&$MestaAttr, &$SeatS) {
 
            $name = 'name_' . JFactory::getLanguage()->getTag();
            //$tag_ = JSFactory::getLang()->get('name');//c.name_xxx c.name_name
//            toPrint($tag_,'$tag_');
 
            $attr_values_new = [];

            $attr_values_exist = [];
            $attr_values_db = [];
 
            $attrs_ids = array_column($MestaAttr, 'attr_id');
            $select = "SELECT *, `$name` Name, CAST(TRIM(`$name`) AS UNSIGNED)+0 Seat, 1*TRIM(`$name`) Seat2 FROM `#__jshopping_attr_values` WHERE attr_id IN ( " . join(',', $attrs_ids) . " ) ; "; //WHERE product_id=$productId 
            if (count($attrs_ids))
                $attr_values_db = JFactory::getDBO()->setQuery($select)->loadObjectList('value_id','attr_values_db');
//             toPrint($select, ' $select    '.count($select));
//toPrint ($MestaAttr);
//toPrint ($SeatS);

            foreach ($SeatS as $id => &$seat) {
                $seat->attr_id = $MestaAttr[$seat->OrderId]->attr_id;
                $seat->value_id = 0;
                
                if($seat->attr_id == 748 && $attr_value_db->attr_id == 748){
            echo "<pre> <br>".print_r($seat->Seat,true)." </pre>";
//                    toPrint ($seat->Seat);
//                    toPrint ($id);
//                    toPrint ($attr_value_db->Seat);
//                    toPrint ($id);
                }
 
                foreach ($attr_values_db as $value_id => &$attr_value_db) {
                    
                    if ((int)$seat->Seat == (int)trim($attr_value_db->Seat) && (int)$seat->attr_id == (int)$attr_value_db->attr_id) {
                        $seat->value_id = (int)$attr_value_db->value_id;
                        $attr_values_exist[$value_id] = $seat;
//                        unset($attr_values_db[$value_id]); // Почему то без комментирования не работает эта строчка, 
                    }
                }
            }
            foreach ($SeatS as $id => &$seat) {
                if ($seat->value_id != 0) continue;
                
                
//                continue;
                $SeatS[$id]->Seat = (int) trim($seat->Seat);
//                toPrint ($seat->Seat,  '$seat->Seat '.gettype ($seat->Seat));
                    $id = ($seat->OrderId*1000)+($seat->Seat);
                    $attr_values_new[$id] = $seat;
            }


            return [$attr_values_new, $attr_values_exist, $attr_values_db];
        }; 
// </editor-fold>
 
        list($attr_values_new,$attr_values_exist,$attr_values_db) = $attr_values_compare();

//        toPrint($attr_values_new,'$attr_values_new');
//        toPrint($attr_values_exist);
//        toPrint($attr_values_db);
        
 // <editor-fold defaultstate="collapsed" desc="Запрос БД добавления в базу несуществующих мест">
        //$this->LoadAllPiecesFromProducts();
        $attr_values_new = array_sorting($attr_values_new, 'Seat');
        $querys = [];
        foreach ($attr_values_new as $sort => $att_v)
            $querys[] = " ( $att_v->attr_id,$att_v->Seat,0) "; //$db->quote($db->escape($repertoire->Name),false)

        $query_insert = " INSERT INTO `#__jshopping_attr_values` "
                . "( attr_id,`$name`,       value_ordering ) "
                . " VALUES " . join(', ', $querys) . " ; ";
        if (count($attr_values_new) > 0)            
            JFactory::getDBO()->setQuery($query_insert)->execute(); // 
//             toPrint($query_insert,' $query_insert   ' );

//            </editor-fold> 
        

//--------------------------------------------------------------------------------------        
//                                  ДОбавление цен для продукта
//--------------------------------------------------------------------------------------

        if($productId == 0) 
            return;
        
// <editor-fold defaultstate="collapsed" desc="Вычисление наценки на билеты">

        $percent = static::$Jackpot / 100; 
        $CostRound = static::$CostCurrency;
 
        foreach ($SeatS as &$seat) {
            $Cost1 = $seat->AgentPrice * $percent + $seat->AgentPrice; 
            $seat->CostPrice = PlaceBiletHelper::RoundPrice($Cost1);
            
//                $polovina =  $CostRound / 2;$ost = $Cost1 % $CostRound;
//                
//            if ($polovina < $ost)
//                $seat->CostPrice = ceil($Cost1 / $CostRound) * $CostRound; // Большее
//            else if($polovina > $ost)
//                $seat->CostPrice = floor($Cost1 / $CostRound) * $CostRound; // меньшее 
//            else if($CostRound == $ost)
//                $seat->CostPrice = $Cost1; // меньшее 
//            else
//                $seat->CostPrice = ceil($Cost1 / $CostRound) * $CostRound; // Большее
//            
//            $seat->CostPrice = $Cost;
//            toPrint($seat->AgentPrice . " - $Cost1 -$CostRound) " . $seat->CostPrice);
        }
        // </editor-fold>
         
// <editor-fold defaultstate="collapsed" desc="$prod_values_compare(): метод сравнения цен с базой">

        $prod_values_compare = function () use (&$MestaAttr, &$SeatS, &$productId) { // _jshopping_products   product_id,    
            /**
             * Места новые добавленные 
             */
            $prod_values_new = []; 
            /**
             * Места существующие
             */
            $prod_values_exist = []; 
            /**
             * Места требующие удаления
             */
            $prod_values_db = []; 
            /**
             * Места требующие обновления цен
             */
            $prod_values_update = [];


            $select = " SELECT * "
                    . " FROM `#__jshopping_products_attr2` "
                    . " WHERE  	product_id = $productId ; "; //WHERE product_id=$productId  
            $prod_values_db = JFactory::getDBO()->setQuery($select)->loadObjectList('id');




            foreach ($SeatS as $id => $seat) {
                $seat->cost_id = 0;
                foreach ($prod_values_db as $id_db => $prod_val_db) {
                    if ($seat->attr_id == $prod_val_db->attr_id && $seat->value_id == $prod_val_db->attr_value_id) {

                        $seat->cost_id = $prod_val_db->id;
                        
                        if($seat->CostPrice != $prod_val_db->addprice){
                            $prod_values_update[$id] = $seat;
//                            toPrint($seat);
                        }

                        $prod_values_exist[$id] = $seat;
                        unset($prod_values_db[$id_db]);
                    }
                }
                if ($seat->cost_id == 0)
                    $prod_values_new[$id] = $seat;
            }

 

            return [$prod_values_new, $prod_values_exist, $prod_values_db, $prod_values_update];
        };
        // </editor-fold>
 
        list($prod_values_new, $prod_values_exist, $prod_values_db, $prod_values_update) = $prod_values_compare();
 
// <editor-fold defaultstate="collapsed" desc="Запрос БД добавления в базу несуществующих Цен">
        
        $prod_values_new = array_sorting($prod_values_new, 'Seat');
        $querys = [];
        foreach ($prod_values_new as $sort => $att_v)
            $querys[] = " ( $att_v->CostPrice, $att_v->value_id, $att_v->attr_id ,$att_v->OfferId , $productId, '+') "; //$db->quote($db->escape($repertoire->Name),false)

        $query_insert = " INSERT INTO `#__jshopping_products_attr2` "
                . "( addprice, attr_value_id, attr_id, OfferId, product_id, price_mod) "
                . " VALUES " . join(', ', $querys) . " ; ";
        if (count($prod_values_new) > 0)            
            JFactory::getDBO()->setQuery($query_insert)->execute(); // 
//             toPrint($query_insert,' $query_insert   ' );

//            </editor-fold> 
 

// <editor-fold defaultstate="collapsed" desc="Удаление остутсвующих цен из базы">

        if (count($prod_values_db) > 0) { 
            $keys = array_column($prod_values_db, 'id'); //'value_id'
            $delete = " DELETE FROM `#__jshopping_products_attr2` "
                . " WHERE id IN ( " . join(', ', $keys) . ") ; ";
            if (count($keys)) 
            JFactory::getDBO()->setQuery($delete)->execute(); 
        }
        // </editor-fold>
        
// <editor-fold defaultstate="collapsed" desc="обновление существующих цен в базе">

//        $prod_values_update[] = (object)['cost_id'=>5379,'CostPrice'=>123];
//        $prod_values_update[] = (object)['cost_id'=>5380,'CostPrice'=>321];
//        $prod_values_update[] = (object)['cost_id'=>5381,'CostPrice'=>666];
        
        if (count($prod_values_update) > 0) { 
            $update = "";
            $querys = [];
            
            foreach ($prod_values_update as $v)
                $querys[] = " SELECT $v->cost_id AS id, $v->CostPrice AS addprice " ;
            $update = " UPDATE `#__jshopping_products_attr2` at2, (". join(' UNION ',$querys ) .") AS sel   SET at2.addprice = sel.addprice WHERE at2.id = sel.id ; "; 
//            toPrint($update);
            if(count($prod_values_update))
                JFactory::getDBO()->setQuery($update)->execute();
        }
        // </editor-fold>

//        list($prod_values_new, $prod_values_exist, $prod_values_db, $prod_values_update) = $prod_values_compare();
     
        
  //    toPrint($prod_values_exist); 
//toPrint($prod_values_new ,' $prod_values_new   '  );      
//toPrint($prod_values_new ,' $prod_values_new   '  );
//toPrint($prod_values_exist ,' $prod_values_exist   ' );
//toPrint($prod_values_db,' $prod_values_db   ' );
 //    toPrint($SeatS ,' $SeatS   ' );   
        

 
        
        
//         toPrint($productBD, ' $productBD    '.count($productBD),"<br><br>");
        //toPrint(array_slice($sectors, -2), " \$sectors->  -  ID: $productBD->StageId  - Count: ".count($sectors) );
        //toPrint(array_slice($offers, -2), ' $offers    '.count($offers) );
//        toPrint($offers, ' $offers    '.count($offers) );
//        toPrint(array_slice($offers, -2), ' $offers    '.count($offers) );
        //отсортировать по группам чтобы ---------------------------------------------------------------------- 
        
         
        //  pac0x_jshopping_attr            Ряды,Сектор
        //  pac0x_jshopping_attr_groups     Стороны
        //  pac0x_jshopping_attr_values     Места
        //  pac0x_jshopping_products_attr2  Цены мест
        
        static::$UpdateOffers = FALSE;
    }
    
    
     
    /**
    * Сортировка загруженных атрибутов с ЗРИТЕЛИ на новые, имеющиеся, старые.
    * @param int $StageCatId ID категории площадки, берется из конфига
    * @param array $MestaAttr Массив Атрибутов загруженных из ЗРИТЕЛИ
    * @return array
    */
    private static function attribute_sorting_compare (&$StageCatId, &$MestaAttr)//, &$attrs_new, &$attrs_exist, &$attrs_db
    {
                $attrs_new = [];  
                $attrs_exist = [];
                $attrs_db = [];
            $select  = " SELECT * FROM `#__jshopping_attr` ";
            $select .= " WHERE attr_admin_type=4 ".(($StageCatId)?" AND StageCatId = $StageCatId   ":"  "); //WHERE product_id=$productId
            $select .= " ORDER BY attr_ordering, SectorId, Row ; ";
        $attrs_db  = array();
        //throw new Exception("$deb") ;
        try {
            $attrs_db = JFactory::getDBO()->setQuery($select)->loadObjectList('attr_id');
        } catch (Exception $exc) {
            toLog($select,'$select');
            throw $exc;
            //throw new Exception($exc->getTraceAsString());
        }
 
        foreach ($attrs_db as &$attr){
//                if(empty($attr->cats))
//                    $attr->cat_s = [];
//                else 
//                    $attr->cat_s = unserialize($attr->cats);
                
                foreach ($MestaAttr as $id=> &$mesto){
                    if($attr->StageCatId == $mesto->StageCatId && $attr->Row == $mesto->Row && $attr->SectorId == $mesto->SectorId){
                        $MestaAttr[$id]->attr_id = $attr->attr_id;//$mesto->attr_id
                        $attrs_exist[$attr->attr_id] = $mesto;
                        unset($attrs_db[$attr->attr_id]);
                    }
                }
            }
            
            foreach ($MestaAttr as $attr_id => &$mesto) {
                if ($mesto->attr_id == 0)
                    $attrs_new[] = $mesto;  
            }
 
//            toPrint($attrs_db,'$attrs_db COUNT:'.  count($attrs_db));
//        return; 
//            $tuple = (object)compact($attrs_new, $attrs_exist, $attrs_db);
//            $tuple = (object)compact('attrs_new', 'attrs_exist', 'attrs_db');
          //  $tuple = ['attrs_new'=>$attrs_new, 'attrs_exist'=>$attrs_exist, 'attrs_db'=>$attrs_db];
            
          //  toPrint($tuple,'$tuple COUNT:'.  count($tuple));
          //  return;
//            $tuple =  compact($attrs_new, $attrs_exist, $attrs_db);
//            
//              toPrint($tuple,'$tuple COUNT:'.  count($tuple));
             
//            $tuple = ['attrs_new'=>$attrs_new, 'attrs_exist'=>$attrs_exist, 'attrs_db'=>$attrs_db];
//                 toPrint($tuple,'$tuple 1 COUNT:'.  count($tuple));
//            
//              return;
//              return compact($attrs_new, $attrs_exist, $attrs_db);
//            return $tuple;
//               return (object)['attrs_new'=>$attrs_new, 'attrs_exist'=>$attrs_exist, 'attrs_db'=>$attrs_db];
//               return ['attrs_new'=>$attrs_new, 'attrs_exist'=>$attrs_exist, 'attrs_db'=>$attrs_db];
               return [ $attrs_new,  $attrs_exist,  $attrs_db];
    }
}


/**
 * Представление
 */
class Product{
    
}

/**
 * Ряд, атрибуты
 */
//class Attribute{
//    
//}
/**
 * Место в зале, 
 */
class AttrSeat{
    
}
/**
 * Место предложения
 */
class Seat{
    
}

class attr_values_db{
    
}
