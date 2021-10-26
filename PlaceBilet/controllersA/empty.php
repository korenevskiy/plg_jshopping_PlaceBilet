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

defined( '_JEXEC' ) or die( 'Restricted access' );
jimport('joomla.application.component.controller');

class JshoppingControllerEmpty extends JControllerLegacy{//JshoppingControllerBaseadmin
    
    function __construct( $config = array() ){
        $this->nameModel = 'empty';
        parent::__construct($config);
//          $this->set('redirect', null);
//          echo "<pre>ControllerEmptyDisplay: ";
//          var_dump($this->get('redirect'));
//          echo "</pre>"; 
        $this->registerTask( 'add',   'display' );
        $this->registerTask( 'apply', 'display' );
        $this->registerTask( 'edit',   'display' );
        $this->registerTask( 'save', 'display' );
        $this->registerTask( 'remove',   'display' );
        $this->registerTask( 'order', 'display' );
        $this->registerTask( 'saveorder','display' );
        $this->registerTask( 'back', 'display' );
        $this->registerTask( 'delete_foto','display' ); 

    }
    
    function display($cachable = false, $urlparams = false){
        
        $dispatcher = JDispatcher::getInstance()->trigger('onBeforeDisplayEmpty', array(&$this));
	
//        echo "<pre>ControllerEmptyDisplay: ";
//        var_dump($this->get('redirect'));
//        echo "</pre>"; 
    }
}
?>	