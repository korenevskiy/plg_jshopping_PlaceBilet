<?php
/**
* @version      4.14.4 20.05.2016
* @author       MAXXmarketing GmbH
* @package      Jshopping
* @copyright    Copyright (C) 2010 webdesigner-profi.de. All rights reserved.
* @license      GNU/GPL
*/

defined('_JEXEC') or die();

jimport('joomla.application.component.controller');

class JshoppingControllerCategories_mod extends JshoppingControllerCategories{// extends JshoppingControllerBaseadmin
    
    function __construct( $config = array() ){
        $this->nameController = 'categories';
        $this->nameModel = 'categories';
        parent::__construct($config); 
    }
    
    public function save(){ 
        $post = $this->input->post->getArray();
        JDispatcher::getInstance()->trigger('onBeforeSaveCategory', array(&$post));
        parent::save();
    }
}