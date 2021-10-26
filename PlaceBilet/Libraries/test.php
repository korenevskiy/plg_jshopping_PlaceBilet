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
echo file_get_contents('http://www.vanhost.ru/my_ip');
echo "<br>";
 define( '_JEXEC',TRUE );
 defined('_JEXEC') or die;
//UserId: 10267
//Hash: _____

error_reporting( E_ALL );
//TestID: 111
///TestHash: 698d51a19d8a121ce581499d7b701668





$method =   trim(htmlspecialchars($_GET["method"]));
$id =       trim(htmlspecialchars($_GET["id"]));
$DateTime = trim(htmlspecialchars($_GET["DateTime"]));
$SectorId = trim(htmlspecialchars($_GET["SectorId"]));
$Row =      trim(htmlspecialchars($_GET["Row"]));
$Seat =     trim(htmlspecialchars($_GET["Seat"]));

echo "<style>.dl{display:table;}.dt{float:left;} .dd{float:right;} </style>" ;
echo "<title>".  substr($method, 8)."</title> ";


if(!isset($method) || empty($method))
    $method = 'Call_GetPlaceList';

if(!isset($id) || empty($id))
    $id = 0;
$w = date("w")-1; $ws = ['Понедельник','Вторник','Среда','Четверг','Пятница','Суббота','Восресенье'];
 
echo date("Y-M-d $ws[$w] H:i:s").'<br>';
echo "<a href='test.php?method=$method&id=$id'>bolshoybilet.ru/test.php?method=$method&id=$id  </a> <br><br>";

 

defined('deb_123') or require_once (__DIR__.'/functions.php');

$fileSoap = dirname(__FILE__).'/SoapClient.php';
//echo (file_exists($fileSoap)?"Yes File":"No File")."<br>";

//toPrint($fileSoap,'.',1,TRUE,TRUE);

//echo "$fileSoap         ";
//include_once ($fileSoap);
require_once ($fileSoap);
 
//toPrint($fileSoap,'.',1,TRUE,TRUE);
$methods = get_class_methods('SoapClientZriteli');
//toPrint($methods,'Методы сервиса ЗРИТЕЛИ: ',0,true,true);
foreach ($methods as $k => $m) {
    if(substr($m,0, 5)!='Call_' && substr($m,0, 5)!='CallM')
        unset($methods[$k]);
}
$methods = array_values($methods);
//toPrint($methods,'Методы сервиса ЗРИТЕЛИ: ',0,true,true);

foreach ($methods as $k => $m){
    $sel = ($m == $method)?' selected ':'  ';
    $methods[$k] = "<option value='$m' $sel>$m</option>";
}
  

//toPrint(null,'TEST !!! ',0,true,true);
//echo "<br>".(class_exists("SoapClientZriteli")?"Yes SoapClientZriteli":"No SoapClientZriteli")."<br>";
try{
//    toPrint(123,'',0,TRUE);
//                ini_set("soap.wsdl_cache_enabled", "0"); // отключаем кэширование WSDL             
    toPrint(ini_get("soap.wsdl_cache_enabled"),'"soap.wsdl_cache_enabled"',0,TRUE,TRUE);
    
    $client= SoapClientZriteli::getInstance(10267,'36e4ab12c46fe1727b9faab042329a28', TRUE);//
    //$Call_Method = "Call_GetSectorListByStageId";
    
    $descrtiption = SoapClientZriteli::GetDocComment($method);

    $par  = explode('@return', $descrtiption,2);
     
//    echo "<pre>";
//    print_r($params);
//    echo "</pre>";
    $params = explode('<br/>', $par[0]);
    foreach ($params as $i => $p){
        if(empty (trim($p))  ){
            unset ($params[$i]);
            continue;
        }
////        $params[$id] .= strpos (trim($p), '@return');
//        if( strpos ("-".trim($params[$id]), '-@return'))
//            unset ($params[$id]);
    }
        
    
    $params = array_slice($params, 0);
           
 
     echo "<form action='test.php'><dl>";
if(count($params)>0)     echo " <dt>$params[0] </dt><dd><select style='width:300px;' name='method'>".join('',$methods)."</select></dd>";
if(count($params)>1)     echo " <dt>$params[1] </dt><dd><input  style='width:300px;' type='text'  value='$id' name='id'/></dd>";
if(count($params)>2)     echo " <dt>$params[2] </dt><dd><input  style='width:300px;' type='text'  value='$DateTime' name='DateTime'/></dd>";
if(count($params)>3)     echo " <dt>$params[3] </dt><dd><input  style='width:300px;' type='text'  value='$SectorId' name='SectorId'/></dd>";
if(count($params)>4)     echo " <dt>$params[4] </dt><dd><input  style='width:300px;' type='text'  value='$Row' name='Row'/></dd>";
if(count($params)>5)     echo " <dt>$params[5] </dt><dd><input  style='width:300px;' type='text'  value='$Seat' name='Seat'/></dd>";
    echo " <dt>- </dt>          <dd><input  style='width:300px;' type='submit' /></dd>";
    echo "</dl></form><br>$method(): $id, $DateTime, $SectorId, $Row, $Seat<br>";
echo "<br>$params[0]<br>$par[1]";
    
    
    
    
    
    
    
    $reponse = SoapClientZriteli::$method($id,$DateTime,$SectorId,$Row,$Seat);
    echo "<br>COUNT: ".count($reponse)."<br>";
    ksort($reponse);
    echo "RESPONSE:<pre>"; print_r($reponse);    echo "</pre><br>";
    
    toPrint(SoapClientZriteli::$Errors,'ERRORS',0,TRUE,TRUE);
    toPrint(SoapClientZriteli::$Error,'ERROR!',0,TRUE,TRUE);
     
    //$client = new SoapClient('http://api.zriteli.ru/index.php?wsdl');
}
 catch (Exception $e){
    echo "Exception:<pre>"; 
    print_r($e->getMessage());
    print_r($e->getTraceAsString());
    echo "</pre><br>";
 }
//SoapClientZriteli::getInstance();
//$r = SoapClient::Call_GetPlaceList();
 
//echo "-><pre>";
////print_r($r);
//echo "</pre><-/";