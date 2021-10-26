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
    defined( '_JEXEC' ) or die( 'Restricted access' );
    defined('DS') || define('DS', DIRECTORY_SEPARATOR);
	
// Правлено 2021-19-17
 
//http://www.php.su/debug_backtrace
//http://www.php.su/functions/?func-get-arg
//http://www.php.su/functions/?cat=funchand
     

if(!function_exists('toStr')){
    function toStr( $value=''){//SimpleXMLElement
    //return $value;
//    if ($value->count()==0)
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

 



if(!function_exists('toLog')){
/**
 * Вывод значения в файл лога 
 * @param mixed $obj Объект для разложения
 * @param string $head Текст или наименование перед объектом (первый символ если не буква, первый символ служит для заполнения разделителя строк)
 * @param string $file Имя файла для сохранения. "/file.txt" - RootPath/file.txt, "./file.txt"  - __DIR__/file.txt
 * @param string $show Выводить инфу одновременно на экран. Вывода дампа ['pre','message','',],defult='', Если $show='1' тогда печать согласно параметрам.
 * @param bool $debug Если TRUE, при $_GET['deb']==F123 (or $_GET['deb']==PIN)(or )
 * Если нет то вывод будет всегда
 * @param object $plugin_params  Параметры плагина с параметрами конфига CMS
 * @return string Возвращает текст который должен отображаться на экране.
 * @version 0.1
 */
function toLog($obj = '', $head = '', $file='', $show = '', $debug = FALSE, $plugin_params = NULL):string{
     
    
    //JConfig  $config->error_reporting   $config->debug  JDEBUG
    //$pass = class_exists('JFactory')? JFactory::getApplication()->input->getString('deb',FALSE) : FALSE;
    
    static $params;
    
    if($head && $head[0]==="~"){
        
    }elseif($plugin_params){
        $params = $plugin_params; 
    } elseif(is_null($params) && class_exists('JFactory')){//Инициализация пустой вызов.
        $params = new stdClass();
        $params->deb                = JFactory::getApplication()->input->getString('deb','');
        $params->dev                = JFactory::getConfig()->get('error_reporting','none');
        $params->error_reporting    = JFactory::getConfig()->get('error_reporting','none');
        $params->debug              = JFactory::getConfig()->get('debug','0');
        $params->include_printlog_type = $show;
//        $params->include_printlog_view = 'dev';
        $params->include_printlog_pass = 'F123'; 
    }elseif(is_null($params)){
        $params = new stdClass();
        $params->deb                = $_GET['deb'];
        $params->dev                = 'simple';
        $params->error_reporting    = 'simple';
        $params->debug              = '0'; 
        $params->include_printlog_type = $show;
//        $params->include_printlog_view = 'dev';
        $params->include_printlog_pass = 'F123'; 
    }

    if(in_array($show, ['1',1,TRUE], TRUE))
        $show = $params->include_printlog_type;
    
    
    
//    if($obj==44)echo '<br>111$params->dev=>'.$params->dev;
//    if($obj==44)echo '<br>111$params->dev=>'.$obj.' HEAD-'.$head;
    
    if($plugin_params)
        return '';
    
    
    if(in_array ($params->dev, ['maximum','development'])){
        //$_GET['deb']=='3228'
    }elseif($params->deb==$params->include_printlog_pass && $debug ){
        
    }elseif($params->deb==$params->include_printlog_pass && $params->dev == 'simple'){
        
    }elseif(defined('JDEBUG') && JDEBUG || $params->debug){
        
    }else{
        return '';
    }

    $s = DIRECTORY_SEPARATOR;
    
    $separate = '';
    if($head && in_array($separate=substr($head, 0,1), ['-','_','*','|','+','=','.',' '], TRUE)){//'/','\\',
        $head=substr($head,1);
        if($separate == '.')
            $separate = '.';
        if($separate === ' ')
            $separate = '';
        elseif(substr($head, 0,2) === '  '){
            $separate = "\n";
            $head = substr($head, 2);
        }else {
            $separate = array_fill (0,80,$separate);
            $separate = join('',$separate)."\n ";
        } 
    }
    else
        $separate = ''; 
    
	
    $type_r = gettype($obj);
    
    if(is_object($obj) && class_exists('JDatabaseQuery') && is_a($obj, 'JDatabaseQuery'))//$obj instanceof JDatabaseQuery
    $obj = (string)$obj; 
    
    if(is_object($obj) && ($obj instanceof JDate))//$obj instanceof JDatabaseQuery
    {$obj = (string)$obj->toSQL();}
    elseif(is_object($obj) && ($obj instanceof DateTime))//$obj instanceof JDatabaseQuery
    {$obj = (string)$obj->format('YYYY-m-d H:i:s');}
    if(is_string($obj) && class_exists('JFactory'))  
        $obj = str_replace('#__',JFactory::getDbo()->getPrefix(),$obj);
    
    
    $head = (string)$head;
    $is_head = !empty($head);
    
	$prn_r = '';
	
    if($obj===TRUE)
        $prn_r .= 'TRUE';
    if($obj===FALSE)
        $prn_r .= 'FALSE';
    
    $prn_r = print_r($obj,true);
    
    
    $path = __DIR__;
    
    if(class_exists('JFactory'))
        $path = JFactory::getConfig()->get('log_path');
         
    
    $print = $separate.date("Y-m-d H:i:s").": ";
    
    
    $deb_tr = debug_backtrace(); 
    if(count($deb_tr)>1)
        list($_file,$_method) = $deb_tr;
    if(count($deb_tr)==1)
        $_method = $_file = $deb_tr[0];
    $paths = explode(DS, $_file['file']);
    if($deb_tr){
        $print .= ucfirst($_method['class']??'').ucfirst($_method['type']??'').ucfirst(isset($_method['function'])?$_method['function'].'()':'');
        $print .= " /".($paths[count($paths)-2]??'') .'/'.(end($paths)??'') .' ('.($_file['line']??'') .')'; // basename($_file['file']??'')
    }
    
    //echo "<br><br>$_file[file] $_file[line]<br>". strlen($separate).'-'.substr($separate,0,1).'-'."$separate-|-$head<br><br><br>";
     
    if($obj === ''){ 
        if($is_head)
            $print .= "$prn_r// ->$head\n"; 
        //    $print .= "$type_r-/ ->$head\n"; 
        else
            $print .= "$prn_r// \n";
        //    $print .= "$type_r-/ \n";
//        $print .= "''";
    }
    elseif($obj === '0' || $obj === 0){ 
        if($is_head)
            $print .= "$type_r:0// ->$head\n"; 
        //    $print .= "$type_r-/ ->$head\n"; 
        else
            $print .= "$type_r:0// \n";
        //    $print .= "$type_r-/ \n";
//        $print .= "''";
    }
    elseif(is_null($obj) && $head === ''){ // || is_null($obj)
            $print .= "\n";
    }
    elseif(empty($obj)){ // || is_null($obj)
        if($is_head)
            $print .= "$type_r:// ->$head";//\n
        //  $print .= "$type_r-/ ->$head\n";
        else
            $print .= "$type_r:// \n";
        //    $print .= "$type_r-/ \n";
//        $print .= "empty";
    }
    elseif (is_string($obj)) { 
        if($is_head)
            $print .= " $type_r:/ ->$head\n$prn_r\n";
        else 
            $print .= " $type_r:/\n$prn_r\n";
//        $print .= "is_string";
    }
    elseif (is_scalar($obj)) {
        if($is_head)
            $print .= " $type_r:$prn_r// ->$head\n"; 
        else 
            $print .= " $type_r:$prn_r//\n";
//        $print .= "is_scalar";
    }
    elseif (is_array($obj)) { 
        if($is_head)
            $print .= ' Count:'.count($obj)." ->\n$head $prn_r\n"; 
        else 
            $print .= ' Count:'.count($obj)."$prn_r\n"; 
//        $print .= "is_array";
    }
    elseif (is_object($obj)) {
        if($is_head)
            $print .= " ->$head $prn_r\n";
        else 
            $print .= "$prn_r\n";
//        $print .= "is_object";
    }
    elseif (is_resource($obj)) {
        if($is_head)
            $print .= " ->$head $prn_r\n";
        else 
            $print .= "$prn_r\n";
//        $print .= "is_resource";
    }
        
    
    $print .= $separate;
	if(strpos($file, '/') === 0 && defined('JPATH_ROOT'))
		$path = JPATH_ROOT;
	if(strpos($file, '.') === 0 && defined('JPATH_ROOT'))
		$path = __DIR__;
	
    if(empty($file))
        $file =  "_log.txt";
    elseif(strtolower ($file) == 'now')
        $file =  "_".(date("Ymd"))."_".(date("his")).".txt";
    elseif(strtolower ($file) == 'tohours' || strtolower ($file) == 'hours')
        $file =  "_".(date("Ymd"))."_".(date("h"))."h.txt";
    elseif(strtolower ($file) == 'today' || strtolower ($file) == 'day')
        $file =  "_".date("Ymd").".txt";
    elseif(strtolower ($file) == 'tomonth' || strtolower ($file) == 'month')
        $file =  "_".date("Y-m").".txt";
    elseif(strtolower ($file) == 'it' || strtolower ($file) == 'this' || strtolower ($file) == '$' || strtolower ($file) == '$this' || is_object ($file))
        $file =  "_$type_r.txt";
    elseif(is_array ($file))
        $file =  "_array.txt";
    else
        $file = "$file";
    
    
    if($show)
        toPrint ($obj, substr($separate,0,1). $file." ".$head, 0, $show, $debug, $params);
    
    //toPrint($path.$s.$file,'',0,TRUE,TRUE);
    
    if(is_null($obj) && $head === '')
		file_put_contents (realpath($path).$s.$file, "\n$print");
	else
		file_put_contents (realpath($path).$s.$file, "\n$print", FILE_APPEND );
    
    return $print;
    //JFactory::getApplication()->enqueueMessage(print_r($query,true));
}


}


if(!function_exists('toPrint')){
 
//$iii = 0;
/**
 * Вывод значения объектов на экран 
 * @param mixed $obj Объект для разложения
 * @param string $head Текст или наименование перед объектом (первый символ если не буква, первый символ служит для заполнения разделителя строк)
 * @param int $count Колличество выводимого элементов из массива для первого атрибута
 * @param string $show Переопределить способ вывода дампа ['pre','message','',],defult='pre', Если defult='' тогда функция будет просто возвращать результат без печати.
 * @param bool $debug Если параметр включен,  при параметре запроса адреса браузера $_GET['deb']=F123
 * Если нет то вывод будет всегда
 * @param object $plugin_params  
 * @return string Возвращает текст который должен отображаться на экране.
 */
function toPrint($obj = NULL, $head = '', $count = 1, $show = ' ', $debug = FALSE, $plugin_params = NULL):string{
    //
//    global $iii;
//    $iii += 1;
    //echo "1+2"; 
    //return ;
    
//echo "<pre>".JText::_($head)." $params->include_printlog_pass</pre>";
    //$pass = class_exists('JFactory')? JFactory::getApplication()->input->getString('deb',FALSE) : FALSE;
    
    
    
    static $params;
    
    if($head && $head[0]==="~"){
        
    }elseif($plugin_params){
        $params = $plugin_params; 
//    } elseif(is_null($params) && class_exists('JFactory') && JFactory::getConfig()->get('error_reporting','none')=='development'){
//        $params = JFactory::getConfig();
//        $params->include_printlog_type = 'pre';
    } elseif(is_null($params) && class_exists('JFactory')){//Инициализация пустой вызов.
        $params = new stdClass();
        $params->deb                = JFactory::getApplication()->input->getString('deb','');
        $params->dev                = JFactory::getConfig()->get('error_reporting','none');
        $params->error_reporting    = JFactory::getConfig()->get('error_reporting','none');
        $params->debug              = JFactory::getConfig()->get('debug','0');
        $params->include_printlog_type = $show = 'pre';
//        $params->include_printlog_view = 'dev';
        $params->include_printlog_pass = 'F123'; 
        $plugin_params = &$params;
    }elseif(is_null($params)){
        $params = new stdClass();
        $params->deb                = $_GET['deb'];
        $params->dev                = 'simple';
        $params->error_reporting    = 'simple';
        $params->debug              = '0'; 
        $params->include_printlog_type = $show = 'pre';
//        $params->include_printlog_view = 'dev';
        $params->include_printlog_pass = 'F123'; 
        $plugin_params = &$params;
    }
     
    if($show === ' ')
        $show = $params->include_printlog_type;
//    if($obj==44)echo '<br>111$params->dev=>'.$params->dev;
//    if($obj==44)echo '<br>111$params->dev=>'.$obj.' HEAD-'.$head;
//    echo$head .$params->include_printlog_type;
    if($plugin_params || empty($show))
        return ''; 
        //include_printlog_type = message,pre,0
        //include_printlog_view = dev,deb,and,or
        //include_printlog_pass = 'F123'
        //debug = 1, 0
        //error_reporting = none, simple, maximum, development
//    echo$head .$params->include_printlog_type;
//    
//    echo '<br>$params->dev=>'.$params->dev;
    
    if(in_array ($params->dev, ['maximum','development'])){
        //$_GET['deb']=='3228'
    }elseif($params->deb==$params->include_printlog_pass && $debug ){
        
    }elseif($params->deb==$params->include_printlog_pass && $params->dev == 'simple'){
        
    }elseif(defined('JDEBUG') && JDEBUG || $params->debug){
        
    }else{
        return '';
    }
//    echo '$params->dev=>'.$params->dev;
// echo "<pre>". print_r(JFactory::getConfig()->get('error_reporting'),TRUE)." ".$_GET['deb']." </pre>";
    
    $n = (isset($_SERVER['HTTP_USER_AGENT'] ))?"":"\n";
     
    $pref = '';
    $h = $head;
    
    if($head && in_array($separate=substr($head, 0,1), ['-','_','*','|','+','=','.',' '], TRUE)){//'/','\\',
        $head=substr($head,1);
        if($separate == '.')
            $separate = '.';
        if($separate === ' ')
            $separate = '';
        elseif(substr($head, 0,2) === '  '){
            $separate = "<br>";
            $head = substr($head, 2);
        }else {
            $separate = array_fill (0,80,$separate);
            $separate = join('',$separate);
        }
    }
    else 
        $separate = '';
    
    
//    echo $iii.",";
//    get debG deb    cont
//    0   0   0       1
//    0   0   1       0
//    0   1   0       1
//    0   1   1       1
//    1   0   0       1
//    1   0   1       1
//    1   1   0       1
//    1   1   1       1
 
    //JDatabaseQuery
    
    if(TRUE || empty($head)){
//        $f = func_get_args();
//        $f = func_get_arg(0);
        //func_get_args
        $deb_tr = debug_backtrace();
        if(count($deb_tr)>1)
            list($_file,$_method) = $deb_tr;
        if(count($deb_tr)==1)
            $_method = $_file = $deb_tr[0]; 
         
        
        $paths = explode(DS, $_file['file']) ;
        
//        print_r($paths);
//        print_r(count($paths));
        
        if($deb_tr){
            $head = "<span style='opacity:0.2'>".ucfirst($_method['class']??'').ucfirst($_method['type']??'').ucfirst($_method['function']??'')
                    //.ucfirst($_file['line']).ucfirst($_file['file']).ucfirst($_file['args']); 
                . "() /".($paths[count($paths)-2]??'') .'/'.(end($paths)??'') .' ('.($_file['line']??'') .')</span><br>'.$head; // basename($_file['file']??'')
    //        echo "<pre>".print_r($f,true)."</pre>"; 
    //         echo "<pre>".print_r($deb_tr,true)."</pre>";
            //JFactory::getApplication()->enqueueMessage("\$trigger_name: $trigger_name"  );
            //JDispatcher::getInstance()->trigger($trigger_name, array(&$caller['object'], &$vars));
        }
        if($h &&( $obj || $obj===0 || $obj==='0' || $obj===FALSE ))
            $head .= ':';
    }
    $isDbQuery = FALSE;
    if(is_object($obj) && is_a($obj, 'JDatabaseQuery')){//$obj instanceof JDatabaseQuery
        $obj = (string)$obj.' ; ';
        $isDbQuery = TRUE;
    }
    if(is_object($obj) && ($obj instanceof JDate))//$obj instanceof JDatabaseQuery
        $obj = (string)$obj->toSQL();
    elseif(is_object($obj) && ($obj instanceof DateTime))//$obj instanceof JDatabaseQuery
        $obj = (string)$obj->format('YYYY-m-d H:i:s');
    
    if(is_string($obj)&& class_exists('JFactory') && strpos($obj, '#__') ){
        $obj = str_replace('#__',JFactory::getDbo()->getPrefix(),$obj);
        $obj = (string)$obj.' ; ';
        $isDbQuery = TRUE;
    }
       
    
    if(is_array($obj)){
        $pref .= ' Count:'.count($obj).'  ';
        
        if(count($obj) && isset($obj[0]) && $count == 1 && is_scalar($obj[0]))
            $obj = array(''=>join(', ', $obj)) ;
        elseif($count>0)
            $obj = array_slice($obj, 0,$count, TRUE);
        elseif($count===-1)
            $obj = '';//[];//count($obj);
    }   
    if(is_object($obj)){ 
        //$getProperty = function ($name){return $this->$name;};
        if(is_string($count)){
            if(function_exists('runkit_method_add')){
                runkit_method_add ($obj,'__getProperty','$name','return $this->$name;');   
                $pref .= get_class($obj).":".$count;
                $obj = $obj->__getProperty($count);
                $pref .= ":". count($obj);
            }elseif (method_exists($obj, 'getArray')) {
                $pref .= get_class($obj).":".$count;
                $obj = $obj->getArray();
                $pref .= ":". count($obj);
            }
            
        }
        $pref .= ' '; 
    }
    
    $print  = ($separate)?"<br/>$separate":"";
    
    if((is_scalar ($obj) && $obj || $obj===0 ||  $obj===FALSE || $obj==='0') && $h)
        $pref .= " ";
    if(is_scalar ($obj) && $obj || $obj===0 ||  $obj===FALSE || $obj==='0')
        $pref .= gettype($obj);
    if(is_scalar ($obj))
        $pref .= ":";
    
    if($obj || $obj===0 ||  $obj===FALSE || $obj==='0')
        $pref .= "";
    else 
        $pref .= "-/";
    
    $posf = (is_scalar ($obj) && $obj  && !$isDbQuery  || $obj===0 ||  $obj===FALSE || $obj==='0')?"/":"";
    
    if($obj===TRUE)
        $obj = 'TRUE';
    if($obj===FALSE)
        $obj = 'FALSE';
    
//    $print .= ($head)?"<br/>$head":"";
    $print .= "<pre style='display:block; visibility:visible;'>$head$pref".print_r($obj,true)."$posf</pre>"; 
    $print .= $separate;
    
 
    if(strtolower($show) == 'pre')
        echo "<div clsss='debug $show' style='width: 0 px; overflow:visible;'>$n$print</div>";
    elseif(in_array(strtolower($show), ['message','notice','warning','error']))
        JFactory::getApplication()->enqueueMessage ("<div clsss='debug $show' style='width: 0 px; overflow:visible;'>$n$print</div>", ucfirst(strtolower($show))) ;
    elseif($show && class_exists('JFactory') //&& class_exists('JPluginHelper') //&& class_exists('JRegistry') 
            //&& $plugin = JPluginHelper::getPlugin('system', 'ContentBlogAnnounce') && $params = new JRegistry( $plugin->params ) 
            //&& $params->get('include_printlog_type',0) == 'message'
            && $params->include_printlog_type == 'message'
            )// $app = JFactory::getApplication();
            JFactory::getApplication()->enqueueMessage ("<div clsss='debug $show' style='width: 0 px; overflow:visible;'>$n$print</div>", ucfirst(strtolower($show))) ;
    elseif($show)// $app = JFactory::getApplication();
        echo "<div clsss='debug $show' style='width: 0 px; overflow:visible;'>$n$print</div>";
    
    return $n.$print;
}
    
}

