<?php
/**
* @version      4.11.1 18.12.2014
* @author       MAXXmarketing GmbH
* @package      Jshopping
* @copyright    Copyright (C) 2010 webdesigner-profi.de. All rights reserved.
* @license      GNU/GPL
*/
defined('_JEXEC') or die();
jimport('joomla.html.pagination');

class JshoppingControllerProduct_mod extends JshoppingControllerProduct{
    function __construct($config = array()){
        parent::__construct($config);
        //JPluginHelper::importPlugin('jshoppingproducts');
        //JDispatcher::getInstance()->trigger('onConstructJshoppingControllerProduct', array(&$this));
        
        //JPluginHelper::importPlugin('jshoppingproducts');
        //JDispatcher::getInstance()->trigger('onConstructJshoppingControllerProduct', array(&$this));
        $this->registerTask('__default', 'display' );
        $this->registerTask('add', 'edit' );
        $this->registerTask('apply', 'save');
    }
//    function display($cachable = false, $urlparams = false){
//        
//    }
}