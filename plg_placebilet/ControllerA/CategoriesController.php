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

jimport('joomla.application.component.controller');


class CategoriesModController extends CategoriesController{// extends JshoppingControllerBaseadmin
    
	function getFactory(){
		return $this->factory;
	}
	function setFactory($factory = null){
		if($factory)
			$this->factory = $factory;
	}

// Член требуемый для J4, для совместимости J3 отключен, но компенсируется $config['default_view'] в конструкторе
//	protected $name = 'Categories';
	
	protected $default_view = 'Categories';
	
    function __construct( $config = array(), \Joomla\CMS\MVC\Factory\MVCFactoryInterface $factory = null, $app = null, $input = null ){
        $this->nameController = 'categories';
        $this->nameModel = 'categories';
        parent::__construct($config, $factory, $app, $input); 
    }
    
    public function save(){ 
        $post = $this->input->post->getArray();
//        JDispatcher::getInstance()->trigger('onBeforeSaveCategory', array(&$post));		
        \JFactory::getApplication()->triggerEvent('onBeforeSaveCategory', array(&$post));
		
        parent::save();
    }
}