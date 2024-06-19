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

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

use \Joomla\CMS\Factory as JFactory;
use \Joomla\CMS\Document\HtmlDocument as JDocument;
use \Joomla\CMS\Language\Text as JText;
use \Joomla\CMS\HTML\HTMLHelper as JHtml;

defined('_JEXEC') or die;


if(JVersion::MAJOR_VERSION == 3){
	require_once (JPATH_SITE.'/components/com_jshopping/lib/factory.php'); 
	require_once (JPATH_SITE.'/components/com_jshopping/lib/functions.php');
}else{
	require_once (JPATH_SITE.'/components/com_jshopping/Lib/JSFactory.php');
	require_once (JPATH_SITE.'/components/com_jshopping/Helper/Helper.php');
}

JLoader::registerAlias('JSFactory', 'Joomla\\Component\\Jshopping\\Site\\Lib\\JSFactory');

defined('_') or define('_', ' ');
defined('DS') or define('DS', DIRECTORY_SEPARATOR);


if(!function_exists('toStr')){
function toStr( $value=''){//SimpleXMLElement
    //return $value;
//    if ($value->count()==0)                //toPrint($value);
//            return $value;
    //return (string)$value;
    return trim((string)$value);//->__toString()
}
}

if(!function_exists('array_sorting')){
function array_sorting($array = [], $field = ''){
    if(count($array) == 0)
        return [];
    if($field == '') 
        ksort($array); 
    else{
        $keys = array_column($array, $field);
        array_multisort($keys, SORT_ASC, $array);
    }
    return $array;
}
}




class PlacebiletHelper{
	
	
    
    /**
	 * Список объектов поддерживаемых языков JShopping, с ID локализации [en-GB => name_en-GB, ...]
	 * @var array
	 */
    public static $languageList = [];
    
    public static $template_name = '';
	
	/**
	 * 
	 * @var \Joomla\Component\Jshopping\Site\Table\ProductTable
	 */
	public static $product = null;
    
    /**
     * Параметры плагина
     * @var JRegistry 
     */
//    public static $params;
    /**
     * Параметры плагина
     * @var JRegistry 
     */
    public static $param;
    
    /**
     * Странситерация русской строки в латинскую с добавлением префикса и даты в начало строки
     * @staticvar string $tran_class
     * @param string $old_name
     * @param string $prefix
     * @return string
     */
    public static function Transliterate($old_name, $prefix =''){
//        static $tran_class;
//        if(empty($tran_class)){
//            foreach(\Joomla\CMS\Factory::getLanguage()->getTransliterator() as $t){
//                if(class_exists($t)){
//                    $tran_class = $t; 
//                }
//            } 
//        } 
//        if($tran_class)
//            $old_name = $tran_class::transliterate($old_name);
        $prefix = $prefix? ($prefix."_"):'';
        
        $old_name = \Joomla\CMS\Factory::getLanguage()->transliterate($old_name);
        
        
        $new_name = str_replace(' ','_', $prefix . date("YmdHis_") .'_'.$old_name);
        
        return  $new_name;
    }
    
    
    /**
     * Получить список языковых полей для одного вида поля
     * 
     * @param string $field_name имя поля для которого нужно получить поля на разных языках
     * @return array   поля на разных языках
     */
    public static function GetFieldsLangs($field_name='name'){ 
        $langs = PlaceBiletHelper::GetLanguages();
        $fields = [];
        foreach ($langs as $lang)
            $fields[$lang] = "{$field_name}_$lang";
        return $fields;
    }
    
    /**
     * Загрузка языков магазина
     * @staticvar array $langs Массив всех языков
     * @staticvar array $langs_publish Массив только опубликованных языков
     * @param bool $getCode TRUE:Получить только список кодов, FALSE:Получить массив с названиями 
     * @param bool $onlyPublish FALSE:Получить все языки, TRUE:Получить только опубликованные
     * @return array Список строк кодов языков или массив объектов с именами
     */
    public static function GetLanguages($getCode = TRUE, $onlyPublish=FALSE){
        
        static $langs;
        static $langs_publish;
        if (!is_array($langs)){
            $query = "SELECT `id`, `language`, `name`, `publish`, `ordering` FROM #__jshopping_languages ; ";//$db->escape($id)  WHERE publish = 1 
            $langs = JFactory::getDBO()->setQuery($query)->loadObjectList('language');// >loadAssocList('language');// execute(); // loadObject(); 
            $langs_publish = []; 
            foreach($langs as $key => &$l){
                if($l->publish){
                    $langs_publish[$key] = &$l;
                }
            }
        }
        if($onlyPublish){
            if($getCode)
                return array_keys ($langs_publish);
            else
                return $langs_publish;
        }
        
            if($getCode)
                return array_keys ($langs);
            else
                return $langs;
    }


    /*
     * Дополнение символами строки до нужной длины
     * Пример: $newstr= PlaceBiletHelper::mb_str_pad($str, 8, "0", STR_PAD_LEFT) 
     * получим строку из 8 симсолов дополненные нулями слева.
     */
    static function mb_str_pad($input, $pad_length, $pad_string=' ', $pad_type=STR_PAD_RIGHT,$encoding='UTF-8'){
        $mb_diff=mb_strlen($input, $encoding)-strlen($input);
        return str_pad($input,$pad_length-$mb_diff,$pad_string,$pad_type);
    } 
    
    public static function getView($name){
		$jshopConfig = JSFactory::getConfig();
		include_once(PlaceBiletPath."/View/".$name."/HtmlView.php");
		$config = array("template_path"=>$jshopConfig->template_path.$jshopConfig->template."/".$name);
//		$viewClass = 'JshoppingView'.$name;
		$viewClass = "\\Joomla\\Component\\Jshopping\\Site\\View\\$name\\HtmlView";
        $view = new $viewClass($config);
        return $view;
    }
    
    public static function JViewLegacy($name, $layout='', $base_path = ''){
        $config = array();
        
        $config['base_path'] = PlaceBiletPath;
        $config['name'] = $name;
        $config['layout'] = 'default';
        
        if($base_path)$config['base_path'] = $base_path;//$this->_basePath;//JPATH_COMPONENT
        if($name)$config['name'] = $name;//$this->_name;
        if($layout)$config['layout'] = $layout;//'default';
        //
        //$config['template_path'] = $this->_basePath . '/View/' . $this->getName() . '/tmpl';
        $config['template_path'] = $config['base_path'] . '/templates/' . $config['name'] . '';
        $view = new JViewLegacy($config);
        return $view;
    }


    public static function getLoadTemplate(&$pathTemplateFile){
        
        if(!file_exists ($pathTemplateFile))
            return FALSE;
        
        ob_start();
        include $pathTemplateFile;

        $output = ob_get_contents();
	ob_end_clean();

	return $output;
    }
    
    public static function getTemplate(&$nameTemplate, $type='Site', $file='default'){
        $type = ucfirst(strtolower($type));
        $path = PlaceBiletPath."/templates/".$nameTemplate.$type."/$file.php";
        return getLoadTemplate($path);
    }
    public static function getTemplateSite(&$nameTemplate, $file='default'){         
        return getTemplate($nameTemplate, 'Site', $file);
    }
    public static function getTemplateAdmin(&$nameTemplate, $file='default'){         
        return getTemplate($nameTemplate, 'Admin', $file);
    }
    
//    public static function getView($name, $prefix = '', $type = '', $config = array()){
//        		// Clean the view name
//		$viewName = preg_replace('/[^A-Z0-9_]/i', '', $name);
//		$classPrefix = preg_replace('/[^A-Z0-9_]/i', '', $prefix);
//		$viewType = preg_replace('/[^A-Z0-9_]/i', '', $type);
//
//		// Build the view class name
//		$viewClass = $classPrefix . $viewName;
//                //dirname(__FILE__).DIRECTORY_SEPARATOR.'ClassesView'.DIRECTORY_SEPARATOR.''.DIRECTORY_SEPARATOR.''.DIRECTORY_SEPARATOR.'';
//                
//		if (!class_exists($viewClass))
//		{
//			jimport('joomla.filesystem.path');
//			$path = JPath::find($this->paths['view'], $this->createFileName('view', array('name' => $viewName, 'type' => $viewType)));
//
//			if ($path)
//			{
//				require_once $path;
//
//				if (!class_exists($viewClass))
//				{
//					throw new Exception(JText::sprintf('JLIB_APPLICATION_ERROR_VIEW_CLASS_NOT_FOUND', $viewClass, $path), 500);
//				}
//			}
//			else
//			{
//				return null;
//			}
//		}
//
//		return new $viewClass($config);
//    }
	
	/**
	 * Удаляет билеты/места для представлений 
	 * @param string|array $id
	 */
    public static function PlacesProdValueDeleteId($product_attr_id2) {
		$where = " = $product_attr_id2 ";
		if(is_array($product_attr_id2))
			$where = " IN (". implode (',', $product_attr_id2) .')';
		
		$query = "
DELETE FROM #__jshopping_products_attr2 
WHERE id $where ;";
		
//toLog($query, '$query', 'finish.txt','',true);
//toPrint($query,'$query',0,'pre',true);
		
		JFactory::getDBO()->setQuery($query)->execute();
		

	}
	/**
	 * Удаляет билеты/места для несуществующих полей 
	 * @param string|array $id
	 */
    public static function PlacesProdValueDeleteNotExist($attribute_id = 0, $product_id = 0) {
		
		$where = '';
		
		if($product_id)
			$where .= " #__jshopping_products_attr2.product_id = $product_id AND ";
		
		if($attribute_id)
			$where .= " #__jshopping_products_attr2.attr_id = $attribute_id AND ";
		
		$query = "
DELETE #__jshopping_products_attr2
FROM #__jshopping_products_attr2  
LEFT JOIN #__jshopping_attr_values av ON av.attr_id = #__jshopping_products_attr2.attr_id AND #__jshopping_products_attr2.attr_value_id = av.value_id
WHERE $where av.value_ordering IS NULL;"; 
		
		JFactory::getDBO()->setQuery($query)->execute();
		
		return $query;
	}




	public static function PlacesAttrValueDeleteId($id){
        $db = JFactory::getDBO();
		$query = "DELETE FROM `#__jshopping_attr_values` WHERE `value_id` = ".$db->escape($id)."; ";
		$db->setQuery($query);
		$db->execute();
        return $query;
    }  
    
    public static function PlacesAttrValueRangeRemove($attr_id, $numberFirst=0, $numberLast=0){
        $numberFirst = intval($numberFirst);
        $numberLast = intval($numberLast);
        //if(PlaceBiletAdminDev)JFactory::getApplication()->enqueueMessage("<pre>Query: \t".$numberFirst.'-'.$numberLast."</pre>");//Warning,Error,Notice,Message
        
        $array = PlaceBiletHelper::getArrayFromRange($numberFirst, $numberLast);
        $query = PlaceBiletHelper::PlacesAttrValueDelete($attr_id, $array);        
        
        return $query;
    } 

    public static function PlacesAttrValueStringAdd($attr_id, $value){
         
         
        
        $nameLang = JSFactory::getLang()->get("name");
        $db = JFactory::getDBO();
        
        $query = "INSERT INTO `#__jshopping_attr_values` (attr_id, value_ordering, image, `$nameLang`) VALUES ";
        $query .= "(".$db->escape($attr_id).", 0, '','".$db->escape($value)."' ); ";
        
         
        
        //INSERT INTO #__jshopping_attr_values (attr_id,value_ordering,image,`name_en-GB`,`name_ru-RU`)
        //VALUES
        //(9631, 0, '','',2 ),
        //(9631, 0, '','',23 )
        
	$db->setQuery($query);
	$db->execute();
        return $query;
    }

    public static function PlacesAttrValueCountAdd($attr_id, $placeCountName){
		
        $nameLang = JSFactory::getLang()->get("name");
        $db = JFactory::getDBO();
        
        $query = "INSERT INTO `#__jshopping_attr_values` (attr_id, value_ordering, image, `$nameLang`) VALUES ";
        $query .= "(".$db->escape($attr_id).", 0, '','".$db->escape($value)."' ); ";
        
        //INSERT INTO #__jshopping_attr_values (attr_id,value_ordering,image,`name_en-GB`,`name_ru-RU`)
        //VALUES
        //(9631, 0, '','',2 ),
        //(9631, 0, '','',23 )
        
		$db->setQuery($query);
		$db->execute();
		return $query;
    }
    
    public static function PlacesAttrValueArrayAdd($attr_id, $arr_values){
        $isArray = is_array($arr_values);
        if($isArray && count($arr_values)==1){
            //$arr_values = $arr_values[0];
            $isArray = FALSE;
        }
        
        if($isArray && count($arr_values)==0){
            return '';
        }
        
        $nameLang = JSFactory::getLang()->get("name");
        $db = JFactory::getDBO();
        
        $query = "INSERT INTO `#__jshopping_attr_values` (attr_id, value_ordering, image, `$nameLang`) VALUES ";
        
        foreach ($arr_values as $value){
            $query .= "(".$db->escape($attr_id).", 0, '','".$db->escape($value)."' ),";
        }
        
        $query = substr($query,0,-1)."; ";
        
        //INSERT INTO #__jshopping_attr_values (attr_id,value_ordering,image,`name_en-GB`,`name_ru-RU`)
        //VALUES
        //(9631, 0, '','',2 ),
        //(9631, 0, '','',23 )
        
	$db->setQuery($query);
	$db->execute();
        return $query;
    }
    
    public static function PlacesAttrValueArrayRemove($attr_id, $arr_values){
        $isArray = is_array($arr_values);
        if($isArray && count($arr_values)==1){
            $arr_values = $arr_values[0];
            $isArray = FALSE;
        }
        
        if($isArray && count($arr_values)==0){
            return '';
        }
        
        $nameLang = JSFactory::getLang()->get("name");
        $db = JFactory::getDBO();
        $where = " WHERE `attr_id` = ".$db->escape($attr_id)." and ";
        
        if($isArray){
            $count = count($arr_values);
            
            $names = " '". implode("', '" , $arr_values )."' ";            
            $where .= " `".$nameLang."` IN (".$names.")";
        }
        else {
            $where .= " `".$nameLang."` = '".$db->escape($arr_values)."'"; 
        }
        
        $query = "DELETE FROM `#__jshopping_attr_values` ".$where." ; ";
        
		$db->setQuery($query);
		$db->execute();
        return $query;
    }

    /**
     * Получение массива чисел из строки. Пример: "5,8-11,15,19-32"
     * @param string $places Строка чисел и интервалов чисел через "-"
     * @return array Массив чисел (array<int>)
     */
    public static function getArrayFromString($places){
            $str_for_explode = str_replace(array(',', '.', ';'), ',', $places);             
            $tuples = explode(',', $str_for_explode);
            
            $arr = array();
            
            foreach ($tuples as $range){
                $t = trim($range);
                $range = explode('-', $t);
                $rng =  array();
                foreach ($range as $r){
                    $rng[] = intval(trim($r));
                }
                $range = $rng;
                $count = count($range);
                
                if($count == 0 || $count > 2 || ($count == 2 &&  $range[0] >= $range[1])){
                    JFactory::getApplication()->enqueueMessage("<pre>Ошибка в параметре: \t".$places.' ('.$t.")</pre>",'Error');
                    return '';
                }
                else if($count == 1){
                    $arr[] = intval(trim($range[0]));
                }
                else if($count == 2){
                    $first = $range[0];
                    $last = $range[1];
                    
                    $arr[] = intval(trim($first));
                    for(;$first<= $last;$first++){
                        $arr[] = intval(trim($first));
                    }
                }
            }
            
            $arr = array_unique($arr);
            sort ($arr);
        return $arr;
    }
    
    public static function getArrayFromRange($first, $last){ 
        $array = array(); 
        for(;$first<=$last;++$first){
            $array[]=$first;
        } 
        return $array;
    }
    
    /**
     * Сохранение значений атрибутов(цен для мест) в базу для Админки.
     * @param type $product
     * @param type $product_id
     * @param type $post
     * @return type
     */
    public static function saveAttributesPlace($product, $product_id, $post){
//        toPrint($post,'$post  0000000000',0,TRUE);
//        $dispatcher = \JFactory::getApplication();
        $nameLang = JSFactory::getLang()->get("name");
//        $product_id =  intval($post['product_id']); 
        
        $attrib_place_name      = $post['attrib_place_name'];                 //Список мест                    9, 11  / ID Value Атрибута     14991
        $attrib_place_value_id  = $post['attrib_place_value_id'];             //Список мест (без пробелов)     9__11 / ID Атрибутов для мест   9631
        $attrib_place_id        = $post['attrib_place_id'];                   //Список ID атрибутов для мест   9631
        $attrib_place_price_mod = $post['attrib_place_price_mod'];            //Знаки изменения цены           +
        $attrib_place_price     = $post['attrib_place_price'];                //Цены                           350
        $attrib_place_type      = $post['attrib_place_type'];                 //Тип места                      350
         
        
        
//        toPrint($attrib_place_Int_tuple,'$attrib_place_Int_tuple 11111111111111111111111111111111111111111111111111111111111',0,TRUE);
//        toPrint($post,'$post  111111',0,TRUE);
//toPrint(null,'',0,'message');
//toPrint($attrib_place_price_mod,'$attrib_place_price_mod',0,'message');
//toPrint($post,'$post',0,'message');
//toPrint(new \Reg($post),'Reg$post',0,'message');
        
        $attribs_id = $attrib_place_id;
//return; 
        \JFactory::getApplication()->triggerEvent('onBeforeProductAttributPlaceStore', array(&$product_id, &$attrib_place_name, &$attrib_place_value_id, &$attrib_place_id, 
            &$attrib_place_price_mod, $attrib_place_price, $attrib_place_type));
        
        $db = JFactory::getDBO();
        $arr_query = array();
        
        $query = "";
        $query = "DELETE pa2 FROM #__jshopping_products_attr2 pa2 LEFT JOIN #__jshopping_attr a ON a.attr_id= pa2.attr_id "
                 . "WHERE a.`attr_admin_type`=4 AND pa2.product_id=$product_id;";
        $query = "DELETE FROM #__jshopping_products_attr2 WHERE id IN (SELECT * FROM (SELECT pa2.id FROM #__jshopping_attr a, #__jshopping_products_attr2 pa2 "
                 . "WHERE a.`attr_admin_type`=4 AND pa2.product_id=$product_id AND a.attr_id= pa2.attr_id)  AS ids); ";
        $arr_query[] =$query;
        
        /** Создание скрипта запроса для мест интервалов
         */
        foreach($attrib_place_name as $key=>$place_Str){            
            if($attrib_place_type[$key] != 'Int')                
                continue;
            $arr_Ints   = PlaceBiletHelper::getArrayFromString($place_Str); //преобразование интервалов из строки в массив целых чисел
            if(empty($arr_Ints))                
                continue;
            $attr_id    = $attrib_place_id[$key];
            $mod        = $attrib_place_price_mod[$key];
            $price      = $attrib_place_price[$key];
            $price      = str_replace(",",".",$price);
            $query = "INSERT INTO #__jshopping_products_attr2 (product_id, attr_id, attr_value_id, price_mod, addprice) "
                    . "SELECT $product_id product_id, $attr_id attr_id, value_id attr_value_id, '$mod' price_mod, $price addprice FROM #__jshopping_attr_values v "
                    . "WHERE v.attr_id=$attr_id AND `$nameLang` IN ('".join("','", $arr_Ints)."'); ";
            $arr_query[] = $query; 
        }
        
                
        /** Создание скрипта запроса для мест имен
         */    
        $query = ''; 
        foreach($attrib_place_value_id as $key=>$value_id){
            if($attrib_place_type[$key] != 'Str')
                continue;
            if($query)
                $query .=", "; 
            $attr_id    = $attrib_place_id[$key];
            $mod        = $attrib_place_price_mod[$key];
            $price      = $attrib_place_price[$key];
			$count		= 1;
			
			if(is_numeric($mod)){
				$count = (int)$mod;
				$mod = '+';
			}
//			else{
//				$mod = '';
//			}
            
            $query .= "($product_id, $attr_id, $value_id, '$mod', $price, $count)";     
        }
        if($query)
            $arr_query[] = "INSERT INTO #__jshopping_products_attr2 (product_id, attr_id, attr_value_id, price_mod, addprice, count) VALUES $query ; ";
        
        
        
//        toPrint($attrib_place_Int_tuple,'$attrib_place_Int_tuple 11111111111111111111111111111111111111111111111111111111111',0,TRUE);
//        toPrint($arr_query,'$arr_query',0,TRUE);
        $times = [];
        $times[] = JFactory::getDate()->format(DATE_RFC3339_EXTENDED);// 'Y-m-d\TH:i:s.vP D d M Y - H:i');
        
        //$query = join("",$arr_query);
        //$query = "";
        $count_row = 0;
        foreach ($arr_query as $q){
            //$query .= $q;
            $db->setQuery($q);
            $db->execute(); 
            $times[] = JFactory::getDate()->format(JDate::RFC3339_EXTENDED);// 'Y-m-d\TH:i:s.vP D d M Y - H:i');
            $count_row += $db->getAffectedRows();
        }
        
//        $db->setQuery($query);
//        $db->queryBatch();
        
        $deletes = [];
        //Удаление дублей
        $deletes[] = "DELETE pa2_1 
            FROM #__jshopping_products_attr2 pa2_1, #__jshopping_products_attr2 pa2_2, #__jshopping_attr a 
            WHERE pa2_1.id < pa2_2.id AND a.attr_id = pa2_1.attr_id AND a.attr_admin_type = 4 
                AND pa2_1.product_id = pa2_2.product_id AND pa2_1.attr_id = pa2_2.attr_id AND pa2_1.attr_value_id = pa2_2.attr_value_id; ";
        //Удаление пустых 
        $deletes[] = "DELETE pa2 
            FROM #__jshopping_products_attr2 pa2
            WHERE pa2.attr_value_id = 0 OR pa2.attr_id = 0 OR pa2.product_id = 0; "; //OR pa2.addprice = 0 
        //$arr_query[]=$delete_double;
        
        if(PlaceBiletAdminDev) JFactory::getApplication()->enqueueMessage("<pre>Колличество затронутых строк: ".$count_row."<br>Count \$arr_query: ".(count($arr_query)-1)."<br>".$query."</pre>"); //print_r($query, TRUE)
        
        while($db->getAffectedRows()){
            foreach ($deletes as $q){
                $db->setQuery($q);
                $db->execute(); 
                $times[] = JFactory::getDate()->format(DATE_RFC3339_EXTENDED);// 'Y-m-d\TH:i:s.vP D d M Y - H:i');
                $count_row -= $db->getAffectedRows();
            }
        }
        
//        toPrint($arr_query,'$arr_query',0,TRUE);
//        toPrint($times,'$times',0,TRUE);
//        toPrint($delete_double,'$delete_double',0);
//        toPrint($attrib_place_Int_tuple,'$attrib_place_Int_tuple',0,TRUE);
//        toPrint($attrib_place_Str_value_id,'$attrib_place_Str_value_id',0);
        
        extract(\JSHelper::js_add_trigger(get_defined_vars(), "after"));    
        
        return $count_row;//$query;
        
        //https://www.ticketland.ru/cirki/cirk-nikulina-na-cvetnom-bulvare/bravo/
    }
    
    public static function getPlacesRequest(){
        $places = JFactory::getApplication()->input->getHtml('jshop_place_id');
//        $places = \Joomla\CMS\Factory::getApplication()->input->getHtml('jshop_place_id');
//			$app = Factory::getApplication();
//        $places = PlaceBiletHelper::JInput()->get('jshop_place_id');
        if (!is_array($places)) 
            $places = (array)$places;
        foreach($places as $k=>$v){
            $places[intval($k)] = intval($v);
		}
		return $places;
    }
    
    
    
    /**
     * Округление цены до круглой суммы
     * @param int $cost Сумма
     * @return int Округленная сумма 
     */
    public static function RoundPrice($cost = 0){
        
		static $roundBonus;
        
		if($roundBonus == null){
			$roundBonusExist = (bool)static::$param->get('roundBonus', FALSE); // Нужно ли округлять
		}
		
        if(empty($roundBonusExist))
            return $cost;
        
		static $CostRound;
		
		if($CostRound == null)
			$CostRound = (int)static::$param->get('costCarrency', 0); // Сумма округления

        if($CostRound ===0)
            return $cost;         
          
                $polovina =  $CostRound / 2;
                $ost = $cost % $CostRound;
                $newCost = 0;

            if ($polovina < $ost)
                $newCost = ceil($cost / $CostRound) * $CostRound; // Большее
            else if($polovina > $ost)
                $newCost = floor($cost / $CostRound) * $CostRound; // меньшее 
            else if($CostRound == $ost)
                $newCost = $cost; // меньшее 
            else
                $newCost = ceil($cost / $CostRound) * $CostRound; // Большее
            return $newCost; 
//            $seat->CostPrice = $Cost;
//            toPrint($seat->AgentPrice . " - $cost -$CostRound) " . $seat->CostPrice);
        //}
        
    }
    /**
     * Определение коэфициента скидки бонусов
     * @param DateTime $product_date_event Дата Спектакля
     * @return float коэфициент
     */
    public static function getBonusProduct($product_date_event){ 
        
        //return 1;
        
        if(empty($product_date_event))
            return 1;
        
        if(!($product_date_event instanceof DateTime))
            $product_date_event = JFactory::getDate($product_date_event);
        
        //toPrint(NULL,'  ');
        
        
        $bonusEnabled = static::$param->get('bonusEnabled',false);
        
        if(empty($bonusEnabled))
            return 1;
		
		
        $bonuses = static::$param->get('bonus','');
//toPrint(NULL,'  ');
//toPrint($bonuses,'$bonuses',true,'message');
//toPrint(get_class($bonuses),'$bonuses',true,'message');
        $bonuses = static::SplitStr2($bonuses);
        
        if($bonusEnabled || empty($bonuses) || count($bonuses)==0)
            return 1;
        //toPrint($bonuses,'$bonus',0);
        
        $bon = 1;
        
        foreach ($bonuses as $day => $bonus){
            $day1 = JFactory::getDate("NOW +{$day}days");
            $day2 = JFactory::getDate("NOW +{$day}days +1days");
            if($day1 < $product_date_event && $product_date_event < $day2)
                $bon = 1 - $bonus /100;
        }
        //toPrint($bon,'  $bonus');
        return $bon;
    }
    
    /**
     * Определение процентов скидки
     * возвращаемая сума будет всегда положительной.
     * @param int $coefficient Коэфициент
     * @return int процент скидок
     */
    public static function getBonusProductPercent($coefficient){
        return abs($coefficient * 100 - 100);
    }
    
    /**
     * Расщепление строки на массив параметров
     * Где элементы разделяются ;,|,/
     * @param string $string строка параметров
     * @return array массив параметров
     */
    public static function SplitStr(string $string){
        $messages = str_replace([';','|','/'], '|', $string);
        $messages = explode('|',$messages);
        
        if(empty($messages))
            return FALSE;
        
        foreach ($messages as $id => $message){
            $message = trim($message);
            $message = trim($message);
            if(empty($message)){
                unset($messages[$id]);
                continue;
            }
        }
        
        $messages = array_values($messages);
        
        return $messages;
    }
    /**
     * Расщепление строки на массив параметров
     * Где элементы разделяются ;,|,/
     * Где ключ-значения разделяются :,-
     * @param string $string строка параметров
     * @return array массив параметров
     */
    public static function SplitStr2(string $string){
        $string = str_replace(['\n','\r','\t'], '', $string);
        $messages = str_replace([';','|','/'], '|', $string);
        $messages = explode('|',$messages);
        
        if(empty($messages))
            return [];
        
        $arr = [];
        
        foreach ($messages as $id => $message){
            $message = trim($message);
            $ms = str_replace([':','-'], '-', $message);
            $ms = explode('-',$ms);
            
            $ms[0]=(int)trim($ms[0]);
            
            if(count($ms)<2 || empty($ms[1]=(int)trim($ms[1])))
                continue;
            
            $arr[$ms[0]] = $ms[1];
        }
        
        return $arr;
    }
    
    /*
     * Отсылка почты по макету
     * @param array $arguments аргументы для шаблона, если пусто тогда Return FALSE;
     * @param string $layout имя макета, если "" тогда будет "mail"
     * @param string $mail адрес почты, если "" тогда отсылка владельцу
     * @return bool успешность отсылки
     */
    public static function Mailing($arguments = [], string $layout = '', string $mail = ''){
         
//         toLog('','~Mailing 1','day');
         
        if(empty($arguments)) return FALSE;
        
        if(empty($layout))
            $layout = 'mail';
        if(empty($mail))
            $mail = JSFactory::getConfig()->contact_email;
        if(empty($mail))
            $mail = JFactory::getConfig()->get('mailfrom');
        $mailfrom = JFactory::getConfig()->get('mailfrom');
        $fromname = JFactory::getConfig()->get('fromname');
        
        
        $s = DIRECTORY_SEPARATOR;
        $template_name = static::$template_name; 
        
        $order_id = 0;
        foreach ($arguments as $arg){
            if(is_object($arg) && isset($arg->order_id)){
                $order_id = $arg->order_id;
                $order_id = str_pad($order_id, 8,'0');
                break;
            }
            if(is_array($arg) && isset($arg['order_id'])){
                $order_id = $arg['order_id'];
                $order_id = str_pad($order_id, 8,'0');
                break;
            } 
        }
        $title = JText::_($layout).": $order_id - $fromname";
        
        
//        toLog('','~Mailing 2','day');
//             , 'base_path' => PlaceBiletPath
        
//        toLog(PlaceBiletPath."{$s}templates{$s}mail",'~template_path','day'); 
//        toLog($layout,'~layout','day'); 
//        toLog(PlaceBiletPath.'{$s}templates','~base_path','day'); 
//        toLog(,'~','day'); 
//        toLog(,'~','day'); 
        try{    
        $viewmail = new JViewLegacy([
                    'name'=>'mail'
                    ,'template_path'=>PlaceBiletPath."{$s}templates{$s}mail"
                    ,'layout'=>$layout
                    ,'base_path' => PlaceBiletPath."{$s}templates"
                ]);  // Создание jubileeViewAjax
                //
//        toLog($viewmail,'~$viewmail','day'); 
//        toLog("|{$s}|",'~{$s}','day'); 
//        toLog($this->template_name,'~$this->template_name','day'); 
//        toLog(DS,'~DS','day');  
            
        $viewmail->addTemplatePath(JPATH_BASE."{$s}templates{$s}{$template_name}{$s}html{$s}com_jshopping{$s}mail"); //Новый шаблон  
        $viewmail->addTemplatePath(PlaceBiletPath."{$s}templates{$s}mail");//Новый шаблон
        $viewmail->addTemplatePath(JPATH_BASE."{$s}templates{$s}{$template_name}{$s}html{$s}com_jshopping{$s}mail"); //Новый шаблон   
//        toLog($viewmail,'~$viewmail','day');
//        toPrint($viewmail,'$viewmail',0);
            
        if(is_array($arguments))
            foreach ($arguments as $i => $arg)
                if(is_int($i))
                    $viewmail->{'arg'.$i} = $arg;
                else 
                    $viewmail->$i = $arg;
        else
            $viewmail->value = $arg;             
        $viewmail->mail     = $mail;
        $viewmail->fromname = $fromname;
        $viewmail->layout   = $layout;
        $viewmail->Date     = JFactory::getDate('now',JFactory::getConfig()->offset)->toSql();
//        $viewmail->Date     = \Joomla\CMS\Factory::getDate('now',JFactory::getConfig()->offset)->toSql();

//            $viewmail = $this->getView('mail', static::$param->mailNotification)
//            $viewmail = new JViewLegacy(['name'=>'mail','layout'=>static::$param->mailNotification]);
//            $viewmail->setModel($modelAjax,TRUE);    
//            $viewmail->setMessage('Уведомлений нет.');  
//            $title = JText::sprintf('MAIL_TITLE',$user->name);
//            toPrint($title,'$title');
//            toPrint([$mailfrom, $fromname, $user->email, $title]);
//        toLog('','~Mailing 3 ViewInstance','day');
        
//        toLog("mailfrom: $mailfrom, namefrom: $fromname, mail: $mail, title: ",'~MailParams SEND STATUS mail','day');
        $body = $viewmail->loadTemplate();//'mail'  
        
        
//        toLog($body,'~Mailing 4 LOAD TEMPLATE $body','day');
        
        
            $send = FALSE; 
            $send = JFactory::getMailer()->sendMail($mailfrom, $fromname, $mail, $title, $body, TRUE);
//            toLog($send,'~Mailing 5 SEND STATUS mail','day');   
		if(JDEBUG || ERROR_REPORTING_DEVELOPMENT)
			\Joomla\CMS\Factory::getApplication()->enqueueMessage( '~Mailing 5 SEND STATUS mail'.' <BR><b>'.($send?:'0').'</b>'); 
            return $send;
            

//                toPrint('Mail Send:'.($send?'sended':'no send'));
                
    //            $mailer = JFactory::getMailer();
    //            $mailer->setSender([$mailfrom,$fromname]);
    //            //$mailer->addAddress($mailfrom,$fromname);
    //            $mailer->addRecipient($mail,$user);
    //            $mailer->isHtml(true);
    //            $mailer->setSubject($title);
    //            $mailer->setBody($body);
    //            $send = $mailer->Send();
 
        }
        catch (Exception $ex) { 
            toLog($ex->getTraceAsString(),'~Exception MAIL','now');
            toLog($ex->getMessage(),'~Exception MAIL2','now');
            return FALSE;
        }
        
        return TRUE;
    }
    /**
     * Подгрузка ссылок для продукта выбранных для перезагрузки страницы если продукта не существует
     * @param array $products 
     */
    public static function addLinkToProducts(&$products){
        
//        return;
        /*
         * 1.Требуется решить проблему с опубликацией категорий, репертуар которой обратно появился.
         * 2.В списке продуктов (Категории, Список прдуктов), выводить только те продукты категории-репертуаров которых опубликованные.
         */
        
        static $prod_cuts_id;
        
        if($prod_cuts_id){
            foreach ($products as $prod)
                $prod->category_id = $prod_cuts_id[$prod->product_id]->category_id ?? $prod->category_id;
            return;
        }
        
        if(empty($products))
            return;
        
        $prods_id = array_column($products, 'product_id');
                
        $CategoriesRedirect = static::$param->get('CategoriesRedirect', FALSE);
        
        if(empty($CategoriesRedirect))
            return;
        
        $lang = JFactory::getLanguage()->getTag();
        
//        toPrint($CategoriesRedirect,'$CategoriesRedirect');
//        toPrint($products,'$products');
        
        $query = " SELECT pr_cat.product_id, cat.category_id, cat.category_parent_id /*, pr_cat.product_ordering, cat.category_image, cat.`name_$lang`, cat.`alias_$lang`*/
            FROM `#__jshopping_products_to_categories` AS pr_cat, #__jshopping_categories cat 
            WHERE cat.category_id = pr_cat.category_id AND pr_cat.product_id IN (". implode(',', $prods_id).")
                AND  $CategoriesRedirect IN (cat.category_id, cat.category_parent_id) AND cat.category_publish=1 AND cat.access IN (1,1,5)
            ORDER BY pr_cat.product_ordering
            LIMIT 0, 50; " ;
        
        $prod_cuts_id = JFactory::getDBO()->setQuery($query)->loadObjectList('product_id');
        
        if(empty($prod_cuts_id))
            return;
        
        foreach ($products as $prod){
            $prod->category_id = $prod_cuts_id[$prod->product_id]->category_id ?? $prod->category_id;
//            toPrint($prod->category_id,'$prod->category_id');
        }
        
        static::addLinkToProducts($products);
        //addLinkToProducts($products, $this->category_id);
        
//            toPrint($products_id,'$products_id');
//            toPrint($products,'$products');
    }
    
    
    public static function JInput(){
        //J Request::get();
        $input = JFactory::getApplication()->input;//->getHtml('jshop_place_id');
//        $places = \Joomla\CMS\Factory::getApplication()->input->getHtml('jshop_place_id');
        return $input;
    }
	
	
	/**
	 * Нужен для Удаление мест в магазине по достижении заказа определенного статуса
	 * @param int $order_id
	 * @param int $status_id
	 */
	public static function deletePlaces(int $order_id = 0, int $status_id = 0, $method = ''){
		
//		static::$param->place_old;
//		return;
//		toPrint($order,'deletePlaces($order)',0,'pre',true); 
//		return;
		//onAfterCreateOrderFull
		//onBeforeChangeOrderStatus
		//onBeforeChangeOrderStatusAdmin
		//onBeforeDisplayCheckoutFinish
		//onBeforeStoreTableOrder
		//onAfterDisplayCheckoutFinish
		
//		toPrint(empty($order_id),'empty($order_id)|'.$method,0,'pre',true);
//		toPrint(empty(static::$param->place_old),'empty(static::$param->place_old)|'.$method,0,'pre',true);
//		toPrint($status_id != 0 && !in_array($status_id, static::$param->place_old)  ,'$status_id != 0 && $status_id != static::$param->place_old|'.$method,0,'pre',true);
//		toPrint(in_array($status_id, static::$param->place_old),'$status_id == $order_status_id|'.$method,0,'pre',true);
//		toPrint(static::$param->place_old,'PlaceBiletHelper::$param->place_old',0,'pre',true);
		
		if(empty($order_id) || empty(static::$param->place_old) || $status_id != 0 && !in_array($status_id, static::$param->place_old))
			return false;
		
		$order_status_id = implode(',', static::$param->place_old);
		$places = null;
		$query = "SELECT $order_status_id ; ";
//try {	
		if(in_array($status_id, static::$param->place_old))
		{
			$query ="
SELECT json_keys(oi.place_prices) place_prices, oh.order_status_id, oh.status_date_added,oh.order_history_id
FROM  #__jshopping_orders o, #__jshopping_order_history oh, #__jshopping_order_item oi 
WHERE o.order_id = oh.order_id AND o.order_id = oi.order_id AND o.order_id = $order_id AND oh.order_status_id IN ( $order_status_id );";// AND oh.order_status_id = {static::$param->place_old}
		}
		if($status_id == 0){
			$query ="
SELECT s.place_prices, s.order_status_id,  s.status_date_added,s.order_history_id
FROM (SELECT json_keys(oi.place_prices) place_prices, oh.order_status_id , oh.status_date_added,oh.order_history_id  
/*, oi.product_attributes, oi.places,  oi.place_names, oh.order_status_id, oi.order_item_id, oh.status_date_added,  oh.order_history_id, o.order_id */
FROM #__jshopping_orders o,  #__jshopping_order_history oh,  #__jshopping_order_item oi
WHERE o.order_id = oh.order_id AND o.order_id = oi.order_id AND o.order_id = $order_id
ORDER BY oh.order_history_id DESC
LIMIT 1) s 
WHERE s.order_status_id IN ( $order_status_id ) ;";// AND oh.order_status_id = {static::$param->place_old}	
		}
		
//toPrint($query,'$query',0,'pre',true);
//toLog($query, '$query', 'finish.txt','',true);

			$places = JFactory::getDbo()->setQuery($query)->loadObject(); // ->loadObjectList('order_status_id');//>loadObjectList();//>loadObject();// >loadObjectList('order_history_id');
		
//} catch (Exception $exc) {
//			echo $exc->getTraceAsString();
//			
//	toPrint($exc->getTraceAsString(),'getTraceAsString()',0,'pre',true);
//toLog($exc->getTraceAsString(), '$exc->getTraceAsString()', 'finish.txt','',true);
//}

//		return false;
//toPrint($places,'$places',0,'pre',true);
//toLog($places, '$places', 'finish.txt','',true);
		
		if(empty($places) || empty($places->place_prices) || !is_string($places->place_prices))
			return false;
		
		$places_id = json_decode($places->place_prices);

//toLog($places_id, '$places_id', 'finish.txt','',true);
//toPrint($places_id,'$places_id',0,'pre',true);
		
		static::PlacesProdValueDeleteId($places_id);
		
//		toPrint($places_id,'$places',0,'pre',true);
//		toLog($places_id, '$places', 'finish.txt','',true);
		
		
//        $jshopConfig = JSFactory::getConfig();
//		$config = new JConfig;
		
		return true;
	}
	
	/**
	 * Замена jQuery на новую версию.
	 * @param boll $noConflict
	 * @param string $debug
	 * @param bool $migrate
	 * @return string Path file jquery script included in Joomla
	 */
	public static function addJQuery($noConflict = true, $debug = null, $migrate = true) {
		 
		
//		$funcJQ = function ($noConflict = true, $debug = null, $migrate = true) {
			
//			static $jquery_file;
//			if ($jquery_file){
//				return $jquery_file;
//			}
	
//			$headData = JFactory::getApplication()->getDocument()->getHeadData();
//			$scripts = []; 
//			foreach ($headData['scripts'] as $file => $script){
//				if($file == '/media/jui/js/jquery.js'){
//					$file = PlaceBiletPath.'/media/jquery.js';
//					$script['relative'] = false;
//					$jquery_file = PlaceBiletPath.'/media/jquery.js';
//				}
//				if($file == '/media/jui/js/jquery.min.js'){
//					$file = PlaceBiletPath.'/media/jquery.min.js';
//					$script['relative'] = false;
//					$jquery_file = PlaceBiletPath.'/media/jquery.min.js';
//				}
//				$scripts[$file] = $script;
//			}
//			$headData['scripts'] = $scripts; 
//			JFactory::getApplication()->getDocument()->setHeadData($headData);	
			if(empty($debug))
				$debug = (boolean) JFactory::getConfig()->get('debug');
		
//			JHtml::_('script', 'jui/jquery.min.js', array('version' => 'auto', 'relative' => true, 'detectDebug' => $debug));
//			JHtml::script(PlaceBiletPath.'/media/jquery.js',['version' => 'auto', 'relative' => false, 'detectDebug' => $debug]);
			if ($noConflict){
				JHtml::script('/media/legacy/js/jquery-noconflict.js', ['version' => 'auto', 'relative' => true]);
			}
			if ($migrate){
				JHtml::script(PlaceBiletPath . '/media/jquery-migrate-1.4.1.min.js', ['version' => 'auto', 'relative' => true, 'detectDebug' => $debug]);
				JHtml::script(PlaceBiletPath . '/media/jquery-migrate.min.js', ['version' => 'auto', 'relative' => true, 'detectDebug' => $debug]);
			}
		
			JHtml::script(PlaceBiletPath . '/media/jquery-ui.min.js', array('version' => 'auto', 'relative' => true, 'detectDebug' => $debug));
			JHtml::script(PlaceBiletPath . '/media/jquery.ui.sortable.min.js', array('version' => 'auto', 'relative' => true, 'detectDebug' => $debug));
			JHtml::stylesheet(PlaceBiletPath . '/media/jquery-ui.min.css', array('version' => 'auto', 'relative' => true, 'detectDebug' => $debug)); 
			 
			
//			if(empty($jquery_file)){
//				$jquery_file = $debug ? PlaceBiletPath.'/media/jquery.js' :  PlaceBiletPath.'/media/jquery.min.js';
//			}
			
//			return $jquery_file;
//		};

//		Joomla\CMS\HTML\HTMLHelper::unregister('jquery.framework');//'jquery.framework'
//		Joomla\CMS\HTML\HTMLHelper::register('jquery.framework', $funcJQ); 
//		Joomla\CMS\HTML\HTMLHelper::unregister('jquery.ui'); //'jquery.ui'
//		Joomla\CMS\HTML\HTMLHelper::register('jquery.ui', $funcJQ);
		
//		return $funcJQ($noConflict, $debug, $migrate);
	}
	
    /**
	 * Список объектов, Языки JShopping, с ID локализации  [en-GB => `name_en-GB`, ...]
	 * example: ('c.desc_', '`') return [en-GB => `c`.`desc_en-GB`, ...]
	 * @return array
	 */
    public static function getLanguageList($prefix = 'name_', $quote = '`'): array {
        
		if(empty(static::$languageList)){
			$query ="
SELECT CONCAT ('`','name_',language,'`') language, language lang  FROM #__jshopping_languages WHERE publish ORDER BY ordering, id DESC;
			";
			static::$languageList = JFactory::getDBO()->setQuery($query)->loadAssocList('lang', 'language');
			
			$admin_show_languages = \Joomla\Component\Jshopping\Site\Lib\JSFactory::getConfig()->admin_show_languages;
			$tag = JFactory::getApplication()->getLanguage()->getTag();
			
			if(empty($admin_show_languages) && isset(static::$languageList[$tag]) && count(static::$languageList) > 1){
				static::$languageList = array_filter(static::$languageList, function($k)use($tag) {return $k == $tag;},ARRAY_FILTER_USE_KEY);
			}
		}
		
		if($prefix == 'name_'){
			return static::$languageList;
		}
		
		$langs = [];
		foreach (static::$languageList as $lng => $_)
			$langs [$lng] = $quote . str_replace('.', "$quote.$quote", $prefix . $lng) . $quote;
		return $langs;
    }
	
	
	public static $eventList;
	/*
	 * Список объектов продуктов с ID событий из ПроКультура
	 * для вывода в Select`е в сканере
	 * @return array
	 */
	public static function getEventTitleList(): array {
		
		if(is_null(static::$eventList)){
			static::getLanguageList();
			if(empty(static::$languageList)){
				static::$eventList = [];
				return static::$eventList;
			}
			$param = static::$param;
			$filterOld		= ($param->pushka_event_interval_old ?? false) ? " AND DATE(date_event) > DATE(DATE_ADD(CURRENT_DATE, INTERVAL -$param->pushka_event_interval_old )) ":  '';
			$filterFuture	= ($param->pushka_event_interval_future ?? false) ? " AND DATE(date_event) < DATE(DATE_ADD(CURRENT_DATE, INTERVAL +$param->pushka_event_interval_future )) ":  '';
			
//			$langs = JFactory::getDBO()->qn(static::$languageList);
			$langs = implode(',', static::$languageList);
			$query = " 
SELECT event_id id, CONCAT_WS(' /', event_id,  $langs ) title, date_event date 
FROM #__jshopping_products 
WHERE  event_id != 0 
$filterOld 
$filterFuture 
ORDER BY date_event; ";

// toPrint($query, '$query',true,'message',true);
// toPrint($query, '$query',true,'message',true);
			
			static::$eventList = JFactory::getDBO()->setQuery($query)->loadObjectList('id');
			
			array_unshift(static::$eventList, (object)['id'=>0,'title'=>JText::_('JGLOBAL_AUTO'),'date'=>'']);
		}
		
		return static::$eventList;
	}

	public static array $statusList = [];
	
	/**
	 * Список статусов с ключём по ID и по Code
	 * @return array
	 */
	public static function getStatusAllList(): array {
		
		if(static::$statusList)
			return static::$statusList;
		
		$langs = static::getLanguageList(); //array_map(fn($lng)=>'s.'.$lng, $langs);
		$langs = implode(',', $langs);
		
		$query="
SELECT status_code id, status_id, status_code, CONCAT_WS(' /', $langs ) title
FROM #__jshopping_order_status
UNION
SELECT status_id id, status_id, status_code, CONCAT_WS(' /', $langs ) title
FROM #__jshopping_order_status;
		";
//toPrint($query,'$query',0,'message');	
//return [];
//echo str_replace('#__', JFactory::getApplication()->getConfig()->get('dbprefix'), $query);
		static::$statusList = JFactory::getDbo()->setQuery($query)->loadObjectList('id');
		
		return static::$statusList;
	}
	
	/*
	 * User timezone. Default value is NULL. get call metod \PlacebiletHelper::getTimezone();
     * @var string 
	 */
	public static $tz = null;

	public static function getTimezone(){
		
		if(static::$tz)
			return static::$tz;
		
		$timezone = 'GMT';
		$timezone = 'UTC';
		$timezone = JFactory::getApplication()->getConfig()->get('offset',$timezone);
		static::$tz = JFactory::getUser()->getParam('timezone',$timezone);
		return static::$tz;
	}
}