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
defined('_JEXEC') or die();
jimport('joomla.html.pagination');
// toPrint($file);
class JshoppingControllerSearch_mod extends JshoppingControllerSearch{
    
    function result(){
        $word = PlaceBiletHelper::JInput('search');
        return;
		
		parent::result();
         
    }
}