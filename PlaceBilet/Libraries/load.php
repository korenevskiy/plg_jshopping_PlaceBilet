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
//defined('_JEXEC') or die;
//return;

//https://github.com/anton-pribora/phpclassgen/blob/master/phpclassgen.php
//https://sourceforge.net/p/wsdl2php/wiki/Home/
//https://github.com/dragosprotung/php2wsdl


/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
			
$address = "http://api.zriteli.ru/index.php?wsdl";
//$address = "http://api.zriteli.ru/index.php";
//$address = 'http://www.vanhost.ru/my_ip';
//$address = 'https://yandex.ru/internet';
//$address = 'http://ip-api.com/json/';
//$address = 'http://api.zriteli.ru/index.php?wsdl';
//echo "$address";return;

//$client =  new SoapClient('http://api.zriteli.ru/index.php?wsdl');// new self('http://api.zriteli.ru/index.php?wsdl');

$wsdl = file_get_contents($address);

echo "<pre>";
//echo "<xmp>";

var_dump($wsdl);

//echo $wsdl;

//echo "</xmp>";
echo "</pre>";


