<?php
/**
* @version      4.6.1 13.08.2013
* @author       MAXXmarketing GmbH
* @package      Jshopping
* @copyright    Copyright (C) 2010 webdesigner-profi.de. All rights reserved.
* @license      GNU/GPL
*/
use Joomla\Component\Jshopping\Site\Lib\JSFactory;
defined('_JEXEC') or die('Restricted access');
jimport( 'joomla.application.component.view');

class JshoppingViewCategory extends JViewLegacy
{
    function displayList($tpl=null){        
        JToolBarHelper::title( JText::_('JSHOP_TREE_CATEGORY'), 'generic.png' ); 
        JToolBarHelper::addNew();
        JToolBarHelper::publishList();
        JToolBarHelper::unpublishList();
        JToolBarHelper::deleteList();        
        parent::display($tpl);
	}
    function displayEdit($tpl=null){
        JToolBarHelper::title( ($this->category->category_id) ? (JText::_('JSHOP_EDIT_CATEGORY').' / '.$this->category->{JSFactory::getLang()->get('name')}) : (JText::_('JSHOP_NEW_CAT')), 'generic.png' ); 
        JToolBarHelper::save();
        JToolBarHelper::spacer();
        JToolBarHelper::apply();
        JToolBarHelper::spacer();
        JToolBarHelper::cancel();        
        parent::display($tpl);
    }
}
?>