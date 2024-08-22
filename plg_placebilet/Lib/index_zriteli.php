<?php \defined('_JEXEC') or die;
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
// cl166881 art-rf.ru
define( '_JEXEC',TRUE );

defined('DS') || define('DS', DIRECTORY_SEPARATOR);
return;


//define('toPrintTrue',TRUE);
//define('_JEXEC', 1); 
//defined('_JEXEC') or die;
$site_folder = "";
$is_local = $_SERVER['HOME']?:false;//Типа $is_local и $user_run взаимоисключаемы.
$user_run = $debug = isset($_SERVER['HTTP_USER_AGENT']);
 
$script = explode('/', $_SERVER['SCRIPT_FILENAME']);
$site_folder = $script[array_search($_SERVER['LOGNAME'],$script)+1]?:'';
//$site_folder =  explode($_SERVER['LOGNAME'],$_SERVER['SCRIPT_FILENAME']);
//$site_folder = explode('/',$site_folder[1]);
//$site_folder = $site_folder[0];

$show=0;


//    echo '<br>$user_run:'.$user_run;
//    echo '<br>$debug:'.$debug;
//    echo '<br>';
        
$error = '';
$log = '';
if($user_run)
    echo '<!DOCTYPE HTML><html lang="ru"><body style="width:100%;">';


try {

$time1 = new DateTime();
 

//        JFactory::getDBO()->setQuery($query)->execute();
//        JFactory::getDBO()->setQuery($query)->execute();
//        $db = JFactory::getDbo(); 
//        
//         $name = 'name_'.JFactory::getLanguage()->getTag();
//        $short_desc = 'short_description_'.JFactory::getLanguage()->getTag();
//        $description = 'description_'.JFactory::getLanguage()->getTag(); 
//        $cats = JFactory::getDBO()->setQuery($query)->loadObjectList('StageId');
//            $first = JFactory::getDBO()->setQuery($query)->loadObject();
//            $count = JFactory::getDBO()->getAffectedRows ();
        
        
        $viewText = TRUE;
        


//ini_set('display_errors', 1);
//ini_set('display_startup_errors', 1);
//error_reporting(E_ALL);
//error_reporting( E_ALL );
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
 


//function toPrnt($obj, $head = "",$separete='', $count = 1, $show = TRUE){
//    $pref = '';
//    
////    if(is_string($obj) && class_exists('JFactory'))        
////        $obj = str_replace('#__',JFactory::getDbo()->getPrefix(),$obj);
//    
//    if(is_array($obj))        {
//        $pref = ' Count:'.count($obj);
//        if($count>0)
//            $obj = array_slice($obj, 0,$count, TRUE);
//    }
//    $print  = ($separete)?"<br/>$separete":"";
////    $print .= ($head)?"<br/>$head":"";
//    $print .= "<pre>$head $pref ".print_r($obj,true)."</pre>\r\n";
//    $print .= $separete;
//    if($show)
//        echo $print;
//    
//    return $print;
//}
//
//function _toLog($obj = null, $string = ''){
//    if(isset($_GET['log'])) {
//		//$file = trim((string)$_GET['log']);
//		exit ("log");
//    }else{
//		$file = 'write_data.txt'; 
//    }
//        $path = __DIR__;
//        
////	echo "\$file: $file <br>";
//    toPrint($obj,$string.'<br>');
//    
//    if (!is_null($obj) && is_int($obj) && $obj != 0) {
//         
//        $string .= "\r\n" . print_r($obj, true) . " ";
//    }
//
//    
//    $t = date("Y-m-d H:i:s");
//    file_put_contents( "$path/$file", "$t : \t $string \r\n", FILE_APPEND);
//}

                        //throw new Exception("\nDir Path: exceprtion: ".__DIR__."/".'write_data.txt'."\n");
//bolshoybilet.ru/public_html/libraries/import.php on line 60
//bolshoybilet.ru/public_html/libraries/import.php on line 67

if($viewText && $user_run)echo 'PHP Version: '.phpversion()." \t <br>";

if($viewText && $user_run)echo $site_folder.'<br>';

//if( $viewText && $user_run)
//    echo "<br>";


defined('deb_123') or require_once (__DIR__.'/functions.php');


//$serverip = file_get_contents('http://www.vanhost.ru/my_ip');$t = date("Y_m");
//toLog(NULL, "Server IP: $serverip","_log_$t.txt"); 
//if($user_run) print "<br>Server IP: $serverip "; 

//if($viewText) toPrint(NULL,'PHP Version: '.phpversion(),1, TRUE, TRUE);
if($viewText) toLog(NULL, '----------------------------------------------------------------------------');
//if($viewText) toPrint(NULL, '----------------------------------------------------------------------------',1, TRUE, TRUE);
//if($user_run) toPrint(NULL, 'User Agent: '.file_get_contents('http://www.vanhost.ru/my_user_agent'),1,$user_run,$debug);
//toPrint($user_run,'$user_run',1, TRUE, TRUE);

$rootpath = __DIR__. "/../../../../";
if($viewText)toLog(NULL,$rootpath. " \$rootpath ");
$rootpath = realpath($rootpath);
define('JPATH_BASE', $rootpath);

// toLog(0,$rootpath. " \$rootpath");
// toLog(0,JPATH_BASE. " JPATH_BASE");
 //if (defined('JPATH_BASE')) {
 //    echo JPATH_BASE;
 //}
 //file_put_contents(__DIR__."/write_data.txt",$rootpath. " \$rootpath\r\n", FILE_APPEND);
 //file_put_contents(__DIR__."/write_data.txt",JPATH_BASE. " JPATH_BASE\r\n", FILE_APPEND);
$file = '';
$t = date("Y_m");
if($user_run) 
//    toPrint(NULL," _log_$t.txt",1,$user_run,$debug);
	echo "<pre> <br>".print_r($exc->getTraceAsString(),true)." </pre>";

//$fileconfig = JPATH_BASE. '/configuration.php';
//if(file_exists($fileconfig))
//    require_once $fileconfig;
//else 
//    exit ();
//if($user_run) toPrint(' '.$time1->format('Y-m-d h:i:s'),'Время запуска',1,$user_run,$debug);



//$gmt = new DateTimeZone('GMT');
//$t = (new DateTime('now',$gmt))->format($format);
if($viewText)toLog(null, "");
if($viewText)toLog(null, "Begin Write");
//teatr-chehova.ru/public_html/plugins/jshopping/placebilet/Lib/index.php?log=write_data123.txt


define('JPATH_PLATFORM', JPATH_BASE . '/libraries');
require_once JPATH_BASE . '/includes/defines.php';
require_once JPATH_BASE . '/includes/framework.php';
 
$date = JDate::getInstance()->toSql(TRUE);
//                
//        toPrint(JPATH_PLATFORM); /home/c/cirkbilet/teatr-chehova.ru/public_html/libraries

//echo ("Готово!");echo JPATH_BASE . '/includes/defines.php';exit("Готово!");


require_once JPATH_PLATFORM.'/import.php';
require_once __DIR__.'/registry.php';

jimport('joomla.environment.uri');
jimport('joomla.utilities.date');

$select = "SELECT params FROM #__extensions WHERE `element` = 'PlaceBilet' ; ";
//toLog($select, '\$select');
$str_params = JFactory::getDbo()->setQuery($select)->loadResult();
//toPrint($str_params,'$str_params',1,$viewText,TRUE);

$conf = JFactory::getConfig();
$conf->language = "ru-RU";
//C:\Games\NetBeansProjects\Cirk\language\ru-RU\ru-RU.localise.php

$lang = JLanguage::getInstance("ru-RU", 0);
JFactory::$language = $lang;
JFactory::getLanguage()->setDefault("ru-RU");
//JFactory::getLanguage()->setLanguage("ru-RU");
//JFactory::getLanguage()->load('joomla', '/home/c/cirkbilet/teatr-chehova.ru/public_html', "ru-RU", TRUE, TRUE);
//toPrint(JFactory::getLanguage() ,'JFactory::getLanguage(): ');
//toPrint(JFactory::getLanguage()->getTag(),'JFactory::getLanguage()->getTag(): ');
//toPrint($str_params,'JFactory::getDbo(): ');

//toLog($str_params, '\$str_params'); 

//toPrint(JDate::getInstance()->toSql(TRUE),'DateTime',1,$viewText,TRUE);

//$str_params = json_encode($str_params);
//$str_params = json_decode($str_params);
//toPrint($str_params,'$str_params',1, $viewText, TRUE);
$param = new JRegistry($str_params);// new \Joomla\Registry\Registry($str_params);
//toPrint($str_params,'$str_params',1, $viewText, TRUE);
//toPrint($param,'$param',1, $viewText, TRUE);
//$param->set('dtUpdateProducts', JDate::getInstance()->toSql(TRUE));
//$str_params = $param->toString();  
//$update = "UPDATE #__extensions SET params = $str_params WHERE element = 'PlaceBilet' ; ";
//JFactory::getDbo()->setQuery($update)->execute();

$param->Zriteli_repertoire_download_enabled = TRUE;

if($viewText)toLog(/*$param*/0, '$param after new Registry()'); 
//JFactory::getApplication();
//toLog(0, '123'); 
try{ 
//			toLog(JPATH_PLUGINS, 'JPATH_PLUGINS');
	$zriteliFile = JPATH_PLUGINS.'/jshopping/placebilet/Lib/Zriteli.php';
	
//		if($viewText)toLog($zriteliFile, '$zriteliFile: ');
//        echo "$zriteliFile -:".(file_exists($zriteliFile)?'TRUE':"false");
        
        if($viewText)
            toLog(file_exists($zriteliFile), "file_exists(\$zriteliFile): $zriteliFile "); 
	if(file_exists($zriteliFile))
            require_once ($zriteliFile);
        else  {
            $error .= "$date - ERROR!: not exist file: $zriteliFile";
            toLog(null, $error); 
            throw new Exception($error);
            exit ($error);
        }
}
 catch (Exception $ex) {
    $error .= $ex->getMessage();
             
//			toPrint($error, '$error');
    $log .= toLog($error, "$date - \$error->$zriteliFile"); 
        
    throw new Exception($log);
    exit ($log);
         
 } 

//$t = date("Y-m-d H:i:s");
//file_put_contents(__DIR__.'/write_data.txt', " Begin Write: $t\r\n", FILE_APPEND);
//toLog(" Begin Write: $t\r\n",'','',__DIR__.'/write_data.txt');

if($viewText)toLog(0, 'require_once: Zriteli.php '); 

$error_show = TRUE;// $debug;

$soap = Zriteli::Instance($param, $error_show);

if($user_run) {
//    $places = SoapClientZriteli::Call_GetPlaceList(FALSE);
    if($debug)echo "<details ><summary>CountPlaces:".count($places)."</summary>";
//    toPrint($places,'',0, TRUE, $debug);
	echo "<pre> <br>".print_r($places,true)." </pre>";
    if($debug)echo "</details>";
    
    $errors = [];
    foreach (SoapClientZriteli::$Errors as $error)
        $errors[] = implode (' || ', $error);
//    toPrint($errors,'SoapClientZriteli::$Errors',0, TRUE, TRUE);
//    echo "+++<pre style='background-color: red;'>".gettype ($errors).'-'.print_r($errors,true)."</pre>---"; 
    
    if($debug )echo "<details ><summary>SoapClientZriteli::\$Errors:".count($errors)."</summary>";
    if(count($errors)==1)
        $errors = array_shift ($errors);
//    toPrint($errors,'',0, TRUE, $debug);
	echo "<pre> <br>".print_r($errors,true)." </pre>";
    if($debug)echo "</details>";
}

//toPrint(Zriteli::$UserId,'$UserId');
//toPrint(Zriteli::$UserHash,'$UserHash');
	echo "<pre> <br>".print_r(Zriteli::$UserId,true)." </pre>";
	echo "<pre> <br>".print_r(Zriteli::$UserHash,true)." </pre>";
//toPrint($soap,'$soap');
//toPrint($soap,'$soap');

//if($viewText)toLog(/*$param*/0, '$param after Instance');
//	echo "<pre> <br>".print_r(Zriteli::$UserId,true)." </pre>";
//if($viewText)toPrint(Zriteli::$dtUpdateProducts->format('Y-m-d H:i:s'),'Date Update last products: ',1, TRUE, TRUE);

//toPrint(JFactory::getDate(),'JFactory::getDate()',1, TRUE, TRUE);
//toPrint(JFactory::getDate()->toSql(TRUE),'',1, TRUE, TRUE);
//toPrint(123,'',1, TRUE, TRUE);
//toPrint(NULL,'123',1, TRUE, TRUE);
//toPrint(NULL,'',1, TRUE, TRUE);
//toPrint(JFactory::getUser(),'JFactory::getUser()253',1, TRUE, TRUE);
//toPrint(JFactory::getDate('now',new DateTimeZone( JFactory::getUser()->getParam('timezone') )), 'X_JFactory::getDate()254',1, TRUE, TRUE); 



Zriteli::$UpdateRepertoiries = TRUE;
Zriteli::$Zriteli_repertoire_download_enabled = TRUE;

//$count = Zriteli::LoadAllProducts();


$prods = array();
try { 
    $prods = Zriteli::LoadAllProducts();
//    if($user_run && SoapClientZriteli::$Errors) 
//        toPrint($prods,'CountProdS',0);
//    if($user_run) 
//        $log .= toPrint(SoapClientZriteli::$Errors,'SoapClientZriteli::$Errors -//- CountProdS:'.count($prods),1); 
} catch (Exception $exc) {
    $errors = [];
    foreach (SoapClientZriteli::$Errors as $error)
        $errors[] = implode (' || ', $error);
//    toPrint($errors,'SoapClientZriteli::$Errors',0, TRUE, TRUE);
	echo "<pre> <br>".print_r($errors,true)." </pre>";
    
    $error .= $exc->getTraceAsString();
    if($log)
        $log .= toLog(SoapClientZriteli::$Errors,'SoapClientZriteli::$Errors');
    $log .= toLog($error,$date.' - Zriteli::LoadAllProducts()');
     //throw new Exception($log);
    //exit ($log);
}

//if($viewText)toPrint(Zriteli::$dtUpdateProducts,'   Zriteli::$dtUpdateProducts->Date Update last products: ',1, TRUE, TRUE);
//echo "+++<pre>".print_r($prods,true)."</pre>---";

 $products_count_exist  = $prods[0] ?? null;
 $products_count_New = $prods[1] ?? null;
 $products_count_onlyDB = $prods[2] ?? null;
 $products_NOexist = $prods[3] ?? null;


//$log = "";

$products_without_image = [];
try {
    $products_without_image =  Zriteli::NewInfoInsertForProduct();
} catch (Exception $exc) {
    $log .= $exc->getTraceAsString();
    $log .= toLog(NULL,$date.' - Zriteli::NewInfoInsertForProduct()');
     //throw new Exception($log);
}

//toLog($count, '\$count'); 

//if($viewText)
$time2 = new DateTime();

$interval = $time2->diff($time1);
$interval = $interval->format('%h:%i:%s');


//$log .= 
//        toLog  (NULL, " Time Start: $date   Interval: $interval  CountExist: $products_count_exist  CountNew: $products_count_New  CountDel: $products_count_onlyDB   Error:". ($log?"True":"False"),
//        "_log_$t.txt");
//if($viewText)toPrint ("--> Time Start: $date   Interval: $interval  CountExist: $products_count_exist  CountNew:  $products_count_New  CountDel: $products_count_onlyDB" ); 

//if($user_run) toPrint(NULL,"Конец загрузки репертуаров. <br>Представлений: Было: $products_count_exist Новых: $products_count_New Устарелых: $products_count_onlyDB",1,$user_run,$debug); 
//if($user_run) toPrint(NULL,"Общее время загрузки данных с ЗРИТЕЛИ: $interval",1,$user_run,$debug);

////if(isset($_SERVER['HTTP_USER_AGENT'] )) 
   // toPrint((string)(JFactory::getLanguage()->getTag()));
if($user_run) 
//    toPrint(NULL,'<form><input type="button" id="btnClose" value="Закрыть" onclick="window.close()"></form>',1,$user_run,$debug);
    echo(  '<form><input type="button" id="btnClose" value="Закрыть" onclick="window.close()"></form>' );
//	echo "<pre> <br>".print_r(Zriteli::$UserId,true)." </pre>";

 $beforedate = Zriteli::$dtUpdateProducts->format('Y-m-d H:i:s');
$domen = $param->get('domen');//($user_run)?$_SERVER['REQUEST_SCHEME']."://".$_SERVER['HTTP_HOST']:JUri::root() ;
$msg =  "Дата загрузки: $date ($beforedate) <br><br>";
$msg .= "Время Загрузки c ЗРИТЕЛИ: $interval <br><br>";
$msg .= "Представлений: Было: $products_count_exist Новых: $products_count_New Устарелых: $products_count_onlyDB<br>"; 
if(TRUE){
    
    $msg .= "<br>"
            . "Новые представления: $products_count_New<br>";
    if($products_count_New){
        usort($products_NOexist, function($a, $b){
            return $a->RepertoireId <=> $b->RepertoireId;
        });
        
        $msg .= "<table  style='border:1px solid gray; border-radius: 4px; padding: 4px;'>";
        $msg .= "<tr><th>&nbsp;ID&nbsp;</th><th>&nbsp;Name&nbsp;</th><th>&nbsp;RepertoireId&nbsp;</th><th>&nbsp;StageId&nbsp;</th><th>&nbsp;date_event&nbsp;</th><th>&nbsp;Categories №&nbsp;</th>";
        foreach ($products_NOexist as $prod){
            $cat = "&nbsp;<a target=\"_blank\" href=\"$domen/administrator/index.php?option=com_jshopping&controller=categories&task=edit&category_id=$prod->category_id\">" 
                    . "CatId: $prod->category_id </a>"; 
            $msg .= "<tr><td style=\"vertical-align: top;\">&nbsp;$prod->product_id&nbsp;</td>" ;
            $msg .= "<td style=\"vertical-align: top;\">&nbsp;<a target=\"_blank\" href=\"$domen/administrator/index.php?option=com_jshopping&controller=products&task=edit&product_id=$prod->product_id\">$prod->Name</a>&nbsp;</td>" ;
            $msg .= "<td style=\"vertical-align: top;\">&nbsp;$prod->RepertoireId&nbsp;</td>" ;
            $msg .= "<td style=\"vertical-align: top;\">&nbsp;$prod->StageId&nbsp;</td>" ;
            $msg .= "<td style=\"vertical-align: top;\">&nbsp;$prod->date_event&nbsp;</td>" ;
            $msg .= "<td style=\"vertical-align: top;\">$cat&nbsp;</td>" ;
        }
        $msg .= "</table>";
    }
    $msg .= ""; 
}
//$error .=toPrint($domen,'$domen',0,TRUE,TRUE);
 //throw new Exception(" Проверка!!!... <br>$msg");

if(TRUE){
    $msg .= "<br>Представления без картинок или описаний: ".count($products_without_image)."<br>";
    if($products_without_image){
        usort($products_without_image, function($a, $b){
            return $a->RepertoireId <=> $b->RepertoireId;
        });
        
        $msg .= "<table style='border:1px solid gray; border-radius: 4px;'>";
        $msg .= "<tr><th>&nbsp;ID&nbsp;</th><th>&nbsp;Name&nbsp;</th><th>&nbsp;RepertoireId&nbsp;</th><th>&nbsp;StageId&nbsp;</th><th>&nbsp;date_event&nbsp;</th><th>&nbsp;Categories №&nbsp;</th>";
        foreach ($products_without_image as &$prod){
            $cats = explode(',', $prod->cats);
            
            foreach ($cats as &$c)
                $c = "&nbsp;<a target=\"_blank\" href=\"$domen/administrator/index.php?option=com_jshopping&controller=categories&task=edit&category_id=$c\">" 
                    . "CatId: $c </a>"; 
            $cats = join('<br>',$cats); 
            $msg .= "<tr><td style=\"vertical-align: top;\">&nbsp;$prod->id&nbsp;</td>" 
                . "<td style=\"vertical-align: top;\">&nbsp;<a target=\"_blank\" href=\"$domen/administrator/index.php?option=com_jshopping&controller=products&task=edit&product_id=$prod->id\">$prod->name</a>&nbsp;</td>" 
                . "<td style=\"vertical-align: top;\">&nbsp;$prod->RepertoireId&nbsp;</td>" 
                . "<td style=\"vertical-align: top;\">&nbsp;$prod->StageId&nbsp;</td>" 
                . "<td style=\"vertical-align: top;\">&nbsp;$prod->date_event&nbsp;</td>" 
                . "<td style=\"vertical-align: top;\">$cats&nbsp;</td>" 
                . "</tr>"; 
        }
        $msg .= "</table>";
    }
} 


//if($user_run) 
//    toPrint(NULL,$msg,1,$user_run,$debug);

if($user_run && ($products_NOexist)){// $products_without_image
    $mail = JFactory::getConfig()->get("mailfrom");
    $fromname = JFactory::getConfig()->get("fromname");

    $mailer = JFactory::getMailer();
    //$mailer->RecipientsQueue
    $mailer->isHtml(true);
    $mailer->Encoding = 'base'.'64';
    $mailer->addRecipient($mail);
    //$mailer->addRecipient('79606424900@ya.ru');
    $mailer->setSubject(" Новых представлений: $products_count_New - $fromname ");
    $mailer->setBody("  $msg ");//<pre>$error</pre>
    $send = $mailer->Send();
}

if(!empty($log && !$user_run))
    throw new Exception($log);
//if(!empty($log && $user_run))
//    toPrint ($log,'$log',1, TRUE, TRUE);

//toPrint('',"$date End Write:   Count: $count" );


//echo "Load adds $count bilets.";
        
//toPrint($str_params); 
//toPrint($param);
//exit("Done!");
//echo ("Готово!");
//exit("Готово!");

//index.php?option=com_blog&view=item&task=getAjaxData&format=raw

//
//
//$fileFactory = __DIR__. "/../../../../includes/joomla/defines.php";
//$fileFactory = __DIR__. "/../../../../includes/joomla/framework.php";
//
//
////$fileFactory = __DIR__. "/../../../../libraries/joomla/factory.php";
////$fileFactory = __DIR__. "/../../../../libraries/vendor/joomla/registry/src/Registry.php";
////C:\Downloads\Joomla\libraries\vendor\joomla\compat\src\JsonSerializable.php_ini_loaded_file()
//////namespace Joomla\Registry;
//
//
//$conf = new JConfig();
//$bd_link = null;
//
//$bd_connect = function ()use(&$bd_link, &$conf){
//    $db_name = $conf->db;
//    $db_type = $conf->dbtype;
//    $db_host = $conf->host;
//    $db_user = $conf->user;
//    $db_password = $conf->password;
//    $db_dbprefix = $conf->db;
//    
//    /** Пароли базы 
//	$db = 'cirkbilet_teat';
//	$dbtype = 'mysqli';
//	$host = 'localhost';
//	$user = 'cirkbilet_teat';
//	$password = 'KCcj45yK';
//	$dbprefix = 'pac0x_';
//*/
//    $bd_link = mysqli_connect( $db_host, $db_user, $db_password, $db_dbprefix); 
//    
//    if (!$link) { 
//        printf("Невозможно подключиться к базе данных. Код ошибки: %s\n", mysqli_connect_error()); 
//        exit ("Невозможно подключиться к базе данных. Код ошибки: ". mysqli_connect_error().'\n'); 
//    }
//    
//    return $bd_link;
//};
//
//
// $bd_query = function ($query = '',$type='')use (&$bd_link){
//    if(!$query)         return '';
//    
//    $result = mysqli_query($link, $query); 
//    if(!$result) return ''; 
//            
//    $result = mysql_result ($result);
////    $arr= ['mysql_result',''];
//            
////    /* Выборка результатов запроса */ 
////    while( $row = mysqli_fetch_assoc($result) ){ 
////        printf("%s (%s)\n", $row['Name'], $row['Population']);
////    }
//
//    /* Освобождаем используемую память */ 
//    mysqli_free_result($result); 
//    return $result;
// };
//
// 
//$select = "SELECT params FROM pac0x_extensions WHERE `element` = 'PlaceBilet' ; ";
//$param = $bd_query($select);
//
//
//JFactory::getDbo();
} catch (Exception $ex) {
    
    $user_run = $user_run? '<br>':'\t\n';
    $message = "$site_folder ".$time1->format('Y-m-d h:i:s');
    $message .= "$user_run Message: ".$ex->getMessage();
    $message .= "$user_run ";
    $message .= "$user_run File: ".$ex->getFile();
    $message .= "$user_run Line: ".$ex->getLine();
    $message .= "$user_run Trace: ".$ex->getTraceAsString();
    $message .= "$user_run Code: ".$ex->getCode();
    $message .= "$user_run ";
     
    throw new Exception($message,$ex->getCode());
}



if($user_run)
    echo '</body></html>';

    
//throw new Exception(' Тестовая проверка ошибки.! ');


//return;
//
////    toPrint($errors,'SoapClientZriteli::$Errors',0, TRUE, TRUE);
//    echo "+++<pre style='background-color: #d1e4da;'>".gettype ($_SERVER).'-'.print_r($_SERVER,true)."</pre>---";
//
//$message = '';
//$message .= "SERVER_ADDR: $_SERVER[SERVER_ADDR] <br>";
//$message .= "REMOTE_ADDR: $_SERVER[REMOTE_ADDR] <br>";
//    
////ini_set('display_errors', 1);
////ini_set('display_startup_errors', 1); 
//error_reporting( E_ALL );