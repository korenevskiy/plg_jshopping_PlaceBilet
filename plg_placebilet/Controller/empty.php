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

defined( '_JEXEC' ) or die( 'Restricted access' );
jimport('joomla.application.component.controller');

class JshoppingControllerEmpty extends JshoppingControllerBase{//JControllerLegacy
    function __construct($config = array()){
        parent::__construct( $config );        
        //checkAccessController("addons");
        //addSubmenu("other");
        
        $this->registerTask( 'add',      'display' );
        $this->registerTask( 'apply',    'display' );
        $this->registerTask( 'edit',     'display' );
        $this->registerTask( 'save',     'display' );
        $this->registerTask( 'remove',   'display' );
        $this->registerTask( 'order',    'display' );
        $this->registerTask( 'saveorder','display' );
        $this->registerTask( 'back',     'display' );
        $this->registerTask( 'delete_foto','display' ); 
        $this->registerTask( 'view','display' ); 
        
        
        //JPluginHelper::importPlugin('jshoppingproducts');
        //\JFactory::getApplication()->triggerEvent('onConstructJshoppingControllerProduct', array(&$this));
        
    }
    
    
    
    function display($cachable = false, $urlparams = false){
        
        //$dispatcher = \JFactory::getApplication()->triggerEvent('onBeforeDisplayEmpty', array(&$this));
	    
        $this->redirect= FALSE;
//        echo "<pre>ControllerEmptyDisplay: ";
//        
//        var_dump($this->get('redirect'));
//        var_dump($this->task);
//        var_dump(PlaceBiletHelper::JRequest()->getCmd('task'));    
//        
//        echo "</pre>"; 
    }
    
    public function getView($name = '', $type = '', $prefix = '', $config = array()){
//	$jshopConfig = JSFactory::getConfig();
//	if ($type==''){
//            $type = getDocumentType();
//        }
//	if (empty($config)){
//            $config = array("template_path"=>$jshopConfig->template_path.$jshopConfig->template."/".$name);
//	}
//	return parent::getView($name, $type, $prefix, $config);
    }
}
?>