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
namespace Joomla\Component\Jshopping\Administrator\View\Statistics;
use Joomla\CMS\MVC\View\HtmlView as BaseHtmlView;
use Joomla\CMS\Toolbar\ToolbarHelper as JToolbarHelper;
use Joomla\Component\Jshopping\Site\Lib\JSFactory;
use Joomla\Component\Jshopping\Site\Helper\Helper as JSHelper;
use Joomla\Component\Jshopping\Administrator\Helper\HelperAdmin as JSHelperAdmin;

defined('_JEXEC') or die();

class HtmlView extends BaseHtmlView{
//Joomla\Component\Jshopping\Administrator\View\Panel\HtmlView
	
    function display($tpl=null){
		
//		echo "<div style='margin: 20px 0px; font:bold 18pt  \"Helvetica Neue\", Helvetica, Arial, sans-serif;'>
//						<img width='170' height='30' src='https://orelmusizo.ru//plugins/jshopping/placebilet/media/images/logo_site-.png' alt='Плагин'>
//						<nobr><a href='//explorer-office.ru' target='_blank'><b>'Билеты-ТеатрКино'</b></a></nobr></div>";
//		return;
        $title = \JText::_('JSHOP_PLACE_BILET_STATISTICS');
//        if (isset($this->edit) && $this->edit){
//            $title = \JText::_('JSHOP_EDIT_PRODUCT');
//            if (!$this->product_attr_id) $title .= ' "'.$this->product->name.'"';
//        }
		
//		$btn = new \Joomla\CMS\Toolbar\Button\CustomButton;
		
        \JToolBarHelper::title($title, 'generic.png' );//jshop_stats_b.png
        \JToolBarHelper::save('display',\JText::_('JTOOLBAR_ASSIGN'));
//        \JToolBarHelper::apply('display',\JText::_('JTOOLBAR_ASSIGN'));
//        \JToolBarHelper::addNew('display',\JText::_('JTOOLBAR_ASSIGN'));
		
		\Joomla\CMS\Toolbar\Toolbar::getInstance('toolbar')->standardButton('home')
            ->text('JOOMSHOPPING')
            ->task('home')
            ->buttonClass('btn btn-info')
            ->listCheck(false);
		
//        \JToolBarHelper::assign();
		
//        if (!isset($this->product_attr_id) || !$this->product_attr_id){
//            \JToolBarHelper::spacer();
//            \JToolBarHelper::apply();
//            \JToolBarHelper::spacer();
//            \JToolBarHelper::save2new();
//            \JToolBarHelper::spacer();
//            \JToolBarHelper::cancel();
//        }
        parent::display($tpl);
	}
	
//    function displayList($tpl=null){    
//		
//		echo "<div style='margin: 20px 0px; font:bold 18pt  \"Helvetica Neue\", Helvetica, Arial, sans-serif;'>
//						<img width='170' height='30' src='https://orelmusizo.ru//plugins/jshopping/placebilet/media/images/logo_site-.png' alt='Плагин'>
//						<nobr><a href='//explorer-office.ru' target='_blank'><b>'Билеты-ТеатрКино'</b></a></nobr></div>";
//		return;    
//        \JToolBarHelper::title( \JText::_('JSHOP_TREE_CATEGORY'), 'generic.png' );
//        \JToolBarHelper::addNew();
//        \JToolBarHelper::publishList();
//        \JToolBarHelper::unpublishList();
//        \JToolBarHelper::deleteList(\JText::_('JSHOP_DELETE')."?");
//        JSHelperAdmin::btnHome();
//        parent::display($tpl);
//	}
//    function displayEdit($tpl=null){
//		
//		echo "<div style='margin: 20px 0px; font:bold 18pt  \"Helvetica Neue\", Helvetica, Arial, sans-serif;'>
//						<img width='170' height='30' src='https://orelmusizo.ru//plugins/jshopping/placebilet/media/images/logo_site-.png' alt='Плагин'>
//						<nobr><a href='//explorer-office.ru' target='_blank'><b>'Билеты-ТеатрКино'</b></a></nobr></div>";
//		return;
//		
//        \JToolBarHelper::title( ($this->category->category_id) ? (\JText::_('JSHOP_EDIT_CATEGORY').' / '.$this->category->{\JSFactory::getLang()->get('name')}) : (\JText::_('JSHOP_NEW_CATEGORY')), 'generic.png' );
//        \JToolBarHelper::save();
//        \JToolBarHelper::apply();
//        \JToolBarHelper::save2new();
//        \JToolBarHelper::cancel();
//        parent::display($tpl);
//    }
}