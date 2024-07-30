<?php namespace Joomla\Component\Jshopping\Administrator\Controller;
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

use Joomla\CMS\MVC\Controller\BaseController;


// phpcs:disable PSR1.Files.SideEffects
\defined('_JEXEC') or die;
// phpcs:enable PSR1.Files.SideEffects

jimport('joomla.application.component.controller');


class DisplayModController extends BaseController{

    function display($cachable = false, $urlparams = false){
		
		// $this->default_view -> "	joomla\component\jshopping\administrator\controller\display";
		//							Joomla\Component\Jshopping\Administrator\View\Statistics
//		$viewName = $this->input->get('view', $this->default_view);
//		$this->template_name = $this->getApplication()->getTemplate(); //JFactory::getDBO()->setQuery($query)->loadResult();       
        $this->template_name = \PlaceBiletHelper::$template_name;
		
        if((substr($this->default_view, -3) == 'mod'))
            $this->default_view = substr($this->default_view, 0, -3);
		
		if($this->default_view == 'display')
			$this->default_view = 'panel';
		
        $viewName = $this->input->get('view', $this->default_view);			// -> 'displaymod'
        $viewLayout = $this->input->get('layout', 'home', 'string');		// -> 'default'
        $taskView = $this->input->get('task', '', 'string');		// -> 'default'
		
		$taskView = 'display' . ucfirst($taskView);
		
        \JSHelperAdmin::checkAccessController($viewName); //"panel"
        \JSHelperAdmin::addSubmenu("");
        
        $viewType = $this->app->getDocument()->getType(); 
		
		
		if(file_exists(PlaceBiletPath."/View/$viewName"))
			$basePath = PlaceBiletPath."/";
		else
			$basePath = $this->basePath;
		
		if(file_exists(PlaceBiletPath."/View/".ucfirst($viewName)."/". ucfirst($viewType).'View.php'))
			require_once PlaceBiletPath."/View/".ucfirst($viewName)."/". ucfirst($viewType).'View.php';
		
//		$view = $this->getView($viewName, 'html');	//"panel"  $viewName
        $view = $this->getView($viewName, $viewType, '', ['base_path' => $basePath, 'layout' => $viewLayout]);
        $view->setLayout($viewLayout);	//"home" $viewLayout
		
        $view->addTemplatePath(\PlaceBiletPath.'/templatesA/panel');
        $view->addTemplatePath(\PlaceBiletPath."/templatesA/$viewName");//Новый шаблон
        $view->addTemplatePath(JPATH_BASE."/templates/$this->template_name/html/com_jshopping/panel/"); //Новый шаблон   
        $view->addTemplatePath(JPATH_BASE."/templates/$this->template_name/html/com_jshopping/$viewName/"); //Новый шаблон   
		//
        $view->app = $this->app;
//        $view->tmp_html_end = "";
//        \JFactory::getApplication()->triggerEvent('onBeforeDisplayHomePanel', array(&$view));
        \JFactory::getApplication()->triggerEvent('onBeforeDisplayHome'.ucfirst($viewName), array(&$view));
		$view->$taskView();
        
		
		
		
		
//        $document = $this->app->getDocument();
//        $viewType = $document->getType();
//        $view = $this->getView($viewName, $viewType, '', ['base_path' => $this->basePath, 'layout' => $viewLayout]);
//toPrint(null,'',false,false,false);
//toPrint($viewName,'$viewName',true,'message',true);								// -> ''
//toPrint($viewLayout,'$viewLayout',true,'message',true);							// -> 'default'
//toPrint($this->nameController,'$this->nameController',true,'message',true);		// -> ''
//toPrint($this->nameModel,'$this->nameModel',true,'message',true);				// -> ''
//toPrint($this->default_view,'$this->default_view',true,'message',true);			// -> 'joomla\component\jshopping\administrator\controller\display' 'displaymod'
//toPrint($basePath,'$this->basePath',true,'message',true);			// -> 'joomla\component\jshopping\administrator\controller\display' 'displaymod'
    }
}
