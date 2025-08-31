<?php namespace Joomla\Plugin\Jshopping\Placebilet\Lib;
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
    defined( '_JEXEC' ) or die( 'Restricted access' );
    defined('DS') || define('DS', DIRECTORY_SEPARATOR);
	
use \Joomla\CMS\Version as JVersion;
use \Joomla\CMS\Language\Text as JText;


use \Joomla\Component\Jshopping\Administrator\Helper\HelperAdmin as JSHelperAdmin ;
use \Joomla\Component\Jshopping\Site\Helper\Helper as JSHelper ;
use \Joomla\Component\Jshopping\Site\Lib\JSFactory as JSFactory;
use \Joomla\Component\Site\Helper\Error as  JSError ;

// Правлено 2021-19-17
 
//http://www.php.su/debug_backtrace
//http://www.php.su/functions/?func-get-arg
//http://www.php.su/functions/?cat=funchand
     
if(class_exists(JVersion::class) && JVersion::MAJOR_VERSION){
	function checkAccessController($name){
		return \JSHelperAdmin::checkAccessController($name);
	}
	function displayMainPanelIco(){
		return \JSHelperAdmin::displayMainPanelIco();
	}
	function displaySubmenuOptions($active=""){
		return \JSHelperAdmin::displaySubmenuOptions($active);
	}
	function getPatchProductImage($name, $prefix = '', $patchtype = 0){
		return \JSHelper::getPatchProductImage($name, $prefix, $patchtype); 
	}
	
	function showMarkStar($rating){
		return \JSHelper::showMarkStar($rating);
	}
	
    /**
    * set Sef Link
    *
    * @param string $link
    * @param int $useDefaultItemId - (0 - current itemid, 1 - shop page itemid, 2 -manufacturer itemid)
    * @param int $redirect
    */
    function SEFLink($link, $useDefaultItemId = 1, $redirect = 0, $ssl=null){
		return \JSHelper::SEFLink($link, $useDefaultItemId, $redirect, $ssl);
	}
	
    function formatprice($price, $currency_code = null, $currency_exchange = 0, $style_currency = 0) {
		return \JSHelper::formatprice($price, $currency_code, $currency_exchange, $style_currency);
	}
	
	function printContent(){
		return \JSHelper::printContent();
	}
	
	function sprintAtributeInCart($atribute){
		return \JSHelper::sprintAtributeInCart($atribute);
	}
	
	function sprintFreeAtributeInCart($freeatribute){
		return \JSHelper::sprintFreeAtributeInCart($freeatribute);
	}
	
	function sprintFreeExtraFiledsInCart($extra_fields){
		return \JSHelper::sprintFreeExtraFiledsInCart($extra_fields);
	}
	
	function displayTotalCartTaxName($display_price = null){
		return \JSHelper::displayTotalCartTaxName($display_price);
	}
}


//$defaines = get_defined_constants();
//$defaines = array_map(function($d){
//	
//}, $defaines);
 

function __($string = ''){
	if(JVersion::MAJOR_VERSION > 3)
		return JText::_ ($string);
	
	$string = "_$string";
	
	if(defined("_$string"))
		return $$string;
	return $string;
}



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

function functions(){
}
  



 