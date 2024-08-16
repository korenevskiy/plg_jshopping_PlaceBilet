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

namespace Joomla\Component\Jshopping\Administrator\Controller;
defined('_JEXEC') or die(); 
//jimport('joomla.application.component.controller');
//class JshoppingControllerEmpty extends BaseadminController{
class InstructionModController extends BaseadminController{//JControllerLegacy  //JshoppingControllerBaseadmin
    
	function getFactory(){
		return $this->factory;
	}
	function setFactory($factory = null){
		if($factory)
			$this->factory = $factory;
	}

// Член требуемый для J4, для совместимости J3 отключен, но компенсируется $config['default_view'] в конструкторе
//	protected $name = 'Empty';
	
//	protected $default_view = 'Empty';
	
    function __construct( $config = array() ){
        $this->nameModel = 'empty';
        parent::__construct($config, $factory, $app, $input); 
//          $this->set('redirect', null);
//          echo "<pre>ControllerEmptyDisplay: ";
//          var_dump($this->get('redirect'));
//          echo "</pre>"; 
//        $this->registerTask( 'add',   'display' );
//        $this->registerTask( 'apply', 'display' );
//        $this->registerTask( 'edit',   'display' );
//        $this->registerTask( 'save', 'display' );
//        $this->registerTask( 'remove',   'display' );
//        $this->registerTask( 'order', 'display' );
//        $this->registerTask( 'saveorder','display' );
//        $this->registerTask( 'back', 'display' );
//        $this->registerTask( 'delete_foto','display' ); 

    }
    
    function display($cachable = false, $urlparams = false){
		
		
		
		
        $menu = array();
//        $menu['categories'] = array(\JText::_('JSHOP_MENU_CATEGORIES'), 'index.php?option=com_jshopping&controller=categories&catid=0', $vName == 'categories', 1);
//        $menu['products'] = array(\JText::_('JSHOP_MENU_PRODUCTS'), 'index.php?option=com_jshopping&controller=products&category_id=0', $vName == 'products', 1);
//        $menu['orders'] = array( \JText::_('JSHOP_MENU_ORDERS'), 'index.php?option=com_jshopping&controller=orders', $vName == 'orders', 1);
//        $menu['users'] = array(\JText::_('JSHOP_MENU_CLIENTS'), 'index.php?option=com_jshopping&controller=users', $vName == 'users', 1);
//        $menu['other'] = array(\JText::_('JSHOP_MENU_OTHER'), 'index.php?option=com_jshopping&controller=other', $vName == 'other', 1);
//        $menu['config'] = array( \JText::_('JSHOP_MENU_CONFIG'), 'index.php?option=com_jshopping&controller=config', $vName == 'config', $adminaccess );
//        $menu['update'] = array(\JText::_('JSHOP_PANEL_UPDATE'), 'index.php?option=com_jshopping&controller=update', $vName == 'update', $installaccess );
//        $menu['info'] = array(\JText::_('JSHOP_MENU_INFO'), 'index.php?option=com_jshopping&controller=info', $vName == 'info', 1);
        
        \JFactory::getApplication()->triggerEvent('onBeforeAdminMenuDisplay', array(&$menu, &$vName));
//        \JFactory::getApplication()->triggerEvent( 'onBeforeAdminMainPanelIcoDisplay', array(&$menu) );
        
        foreach($menu as $item){
            if ($item[3]){
                \JHtmlSidebar::addEntry( $item[0], $item[1], $item[2]);
            }
        }
		
		
		$tagLang = \Joomla\CMS\Factory::getLanguage()->getTag();
        
//		echo PlaceBiletPath . "/language/$tagLang/instruction.html";
		
		$fileInstruction = PlaceBiletPath . "/language/$tagLang/instruction.html";
		
		if(file_exists($fileInstruction) && filesize($fileInstruction))
			$fileContent = file_get_contents($fileInstruction);
		else
			$fileContent = '';
	
        $filesContent = \JFactory::getApplication()->triggerEvent('onBeforeDisplayInstruction', array('PlaceBiletInstructionController', &$this, &$fileContent));
		
		
		echo "<div class=''>" . $fileContent . implode('', $filesContent) . '</div>';
		
		
//        echo "<pre>ControllerEmptyDisplay: ";
//        var_dump($this->get('redirect'));
//        echo "</pre>"; 
    }
}
?>	