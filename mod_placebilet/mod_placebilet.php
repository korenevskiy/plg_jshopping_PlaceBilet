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

defined('_JEXEC') or die;

use Joomla\CMS\Helper\ModuleHelper;
use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Plugin\PluginHelper;
use modPlaceBiletHelper as Helper;
use Joomla\Registry\Registry as JRegistry;
use Joomla\CMS\Uri\Uri;
use Joomla\CMS\Factory as JFactory;
//use \Joomla\Module\Placebilet\Administrator\Helper\PlaceBiletHelper as Helper; // Этот тип класса не поддерживается Ajax

//if ($params->def('prepare_content', 1)) {
//    PluginHelper::importPlugin('content');
//    $module->content = HTMLHelper::_('content.prepare', $module->content, '', 'mod_custom.content');
//}

// require_once JPATH_ROOT . '/functions.php';


//require_once '_src/Helper/PlacebiletHelper.php';
require_once 'helper.php';

//$params = new JRegistry($module);
$params->loadObject($module);
//$params->loadObject($params);

Helper::$param = $params->toObject();

//toPrint(Helper::$param, '$param',true,'message',true);
 
// Replace 'images/' to '../images/' when using an image from /images in backend.
//$module->content = preg_replace('*src\=\"(?!administrator\/)images/*', 'src="../images/', $module->content);


require ModuleHelper::getLayoutPath('mod_placebilet', $params->get('layout', 'default'));

 return;

//$cacheparams = new \stdClass;
//$cacheparams->cachemode = 'safeuri';
//$cacheparams->class = 'Joomla\Module\MultiForm\Site\Helper\modMultiFormHelper';
//$cacheparams->method = 'getList';
//$cacheparams->methodparams = $params;
//$cacheparams->modeparams = array('id' => 'array', 'Itemid' => 'int');
//
//$list = JModuleHelper::moduleCache($module, $params, $cacheparams);