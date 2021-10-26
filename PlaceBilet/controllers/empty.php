<?php
/**
* @version      4.10.0 05.11.2013
* @author       MAXXmarketing GmbH
* @package      Jshopping
* @copyright    Copyright (C) 2010 webdesigner-profi.de. All rights reserved.
* @license      GNU/GPL
*/

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
        //JDispatcher::getInstance()->trigger('onConstructJshoppingControllerProduct', array(&$this));
        
    }
    
    
    
    function display($cachable = false, $urlparams = false){
        
        //$dispatcher = JDispatcher::getInstance()->trigger('onBeforeDisplayEmpty', array(&$this));
	    
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