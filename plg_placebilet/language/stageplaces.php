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
use \Joomla\CMS\Factory as JFactory;
use \Joomla\CMS\Language\Text as JText;

defined('_JEXEC') or die;
jimport('joomla.form.formfield');
//https://docs.joomla.org/Category:Standard_form_field_types
//https://docs.joomla.org/Text_form_field_type
//https://docs.joomla.org/Text_form_field_type/3.2
//https://docs.joomla.org/Standard_form_field_types


$path = JPATH_PLUGINS.'/jshopping/placebilet/language/';
JFactory::getApplication()->getLanguage()->load('', $path); 
//JFactory::getLanguage()->load('PlaceBilet', $path, NULL, TRUE);         
//JFactory::getLanguage()->load('plg_jshopping_PlaceBilet', $path, NULL, TRUE);  
//JFactory::getLanguage()->load('PlaceBilet', $path, 'ru-RU', TRUE);

/**
 * Поле для настройки плагина, выводящий список названий ПЛОЩАДОК сервиса ЗРИТЕЛЕЙ
 */
class JFormFieldStagePlaces extends JFormField {

  protected $type = 'StagePlaces';
  public $params = NULL;
  public $plugin = NULL;
  
 
  
  protected function getInput(){
      defined('DS') or define('DS', DIRECTORY_SEPARATOR);
        require_once (JPATH_SITE.DS.'plugins'.DS.'jshopping'.DS.'placebilet'.DS.'Lib'.DS.'SoapClient.php'); 
        require_once (JPATH_SITE.DS.'plugins'.DS.'jshopping'.DS.'placebilet'.DS.'Lib'.DS.'Zriteli.php'); 
         
        jimport( 'joomla.registry.registry' );
        //jimport( 'joomla.registry.format' );
      
//        $query = " SELECT params, enabled  FROM #__extensions WHERE element='PlaceBilet'; ";
//        $plugin = JFactory::getDBO()->setQuery($query)->loadObject();
        
//		$this->params =  JRegistry::getInstance('PlaceBilet')->loadString($params);
//		$this->params = PlaceBiletHelper::$param; // JRegistry::getInstance('PlaceBilet')->loadString($params);
		$this->plugin = $this->form->getData();// ->toObject() // = new \Joomla\CMS\Form\Form($name);
        $this->params = new JRegistry($this->plugin->get('params'));//,$plugin->params //$this->plugin->loadString($this->plugin->get('params'));
        
        //$this->params->loadJSON($params);
//        $params = $this->params;
        
//        toLog($params);
                
//        $params = json_decode($params);
//        $this->params = new JObject();
//        $this->params->setProperties($params);
        
//        echo "<pre>\$params: ".count($params)."<br>";
//        print_r($params);
//        echo "  </pre>";
//        return;
        
        $UserId = $this->params->get('UserId', '111');
        $UserHash = $this->params->get('Hash', '698d51a19d8a121ce581499d7b701668');
        $Enabled = (bool)$this->params->get('Zriteli_enabled', FALSE) && (bool)$plugin->enabled;
        $StagePlaces = $this->params->get('StagePlaces', []);
        //$places = $this->params->get('places', FALSE);
//        if(!$Enabled && !$places){
//            $items = ['disabled'=>'Выключено'];
//            //return JHTML::_('select.genericlist', $fields, $this->name,'class="inputbox" id = "category_ordering"  ','Field','Title', $value );
//            //return JHTML::_('select.genericlist', $categories_select,$ctrl,'class="inputbox" id = "category_ordering" multiple="multiple"','category_id','name', $value );
//        }
        
        $value        = empty($this->value) ? 0 : $this->value;  
            
        if(!$Enabled){
            $allStages= array();
//            $allStages[0]=['id'=>0,'title'=>(string)JText::_('JALL')];
            foreach ($StagePlaces as $stage){
                list($stageId,$placeId) = explode('-', $stage);
                
                //950-10
                $allStages[$stageId]=['id'=>(string)$stage,'title'=>(string)"Place Id: $placeId - Stage Id: $stageId"];
            }
            
            
            return JHTML::_('select.genericlist', $allStages,$this->name,'class="inputbox chzn-custom-value"  multiple="multiple"','id','title',$value);
        }
         

        
        $config = new JConfig();
        SoapClientZriteli::getInstance($UserId,$UserHash, TRUE);// $config->error_reporting == 'development'
        
        
        try {
            $places = SoapClientZriteli::Call_GetPlaceList();
            $places_count = count($places);
            $count_errors = count(SoapClientZriteli::$Errors);
            if(( $count_errors > 1)  || $count_errors == 1 && ((SoapClientZriteli::$Errors[0]['Code']) !== 0)){
                JFactory::getApplication()->enqueueMessage("<pre>CountPlaces: $places_count</pre>",'error'); 
                JFactory::getApplication()->enqueueMessage("<pre>".print_r(SoapClientZriteli::$Errors,true)."</pre>",'error'); 
            }
        } catch (Exception $exc) {
            return $exc->getTraceAsString();
        }

        
        
        
        if(empty($places)){
            
            

//            SoapClientZriteli::$
             
//            echo "<pre>".print_r($this->value,true)."</pre>";
            JFactory::getApplication()->enqueueMessage("<pre>".JText::_('JSHOP_NOT_LOADED')."</pre>".print_r($this->value,true),'error'); 
        
            $html = "<div  type=\"text\" class=\alert alert-danger\" role=\"alert\""
            . " style=\"background-color:#bd362f; color:white; padding: 2px 0; border-radius: 3px; font-size: 13px;"
                . "box-shadow: 0 1px 2px rgba(0,0,0,0.05);border: 1px solid rgba(0,0,0,0.2);text-align: center;\" >"
                .JText::_('JSHOP_NOT_LOADED')."</div><br>";
              //  . "<input name=\"StagePlaces\" type=\"text\" readonly=\"1\" value=\"$this->value\" />"
                foreach ($this->value as $i => $v)
                    $this->value[$i] = (object)['id'=>$v,'title'=>$v];
            
            $html .= JHTML::_('select.genericlist', $this->value,$this->name.'','class="inputbox chzn-custom-value"  multiple="multiple"','id','title',$this->value);
        
            return $html;
        }

         
            Zriteli::UpdateLoadStages($this->params);        
          //return $places;
        
//        toPrint(array_slice($places, 0, 2), ' $places    '.count($places) );
//        echo "<pre>\$StagePlaces: ".count($StagePlaces)."<br>";
//        print_r($StagePlaces);
//        echo "  </pre>";
//        
//        $keys = array_keys($places);
        
        
        $pls = array_column($places, 'Name','Id');
        
            
//        $pls = array();
//        foreach ($places as $PlaceId => $name)
//            $pls[$name['Id']] = $name['Name'];

//        toPrint(array_slice($places, -2), ' $places    '.count($places) );
//        echo "<div><br>";
//        print_r(join(', ',$keys));//print_r($keys));
//        echo "  *</div>";
//        return;
        
//        $i = 10;
        
        $allStages=array();
        foreach ($pls as $PlaceId => $PlaceName ){
            //echo "<pre>Errors: $PlaceId - ".$PlaceName."<br>".$ex->getMessage();       echo "  *</pre>";//print_r($PlaceId); 
//            echo " -*- $PlaceId - ".$PlaceName." ";//print_r($PlaceId); 
            try {
                $Stages = SoapClientZriteli::Call_GetStageListByPlaceId($PlaceId);
//                $allStages += $Stages;
                //$Stages = SoapClientZriteli::Call_GetStageListByPlaceId($PlaceId);
            } catch (Exception $ex) {
                echo "<pre>Errors: $PlaceId - ".$PlaceName."<br>".$ex->getMessage();       echo "  *</pre>";//print_r($PlaceId); 
                continue;
            }
       
        
//            $i--;
//            if($i==0){
////                $i=200;
////                sleep(5);
////                
////                SoapClientZriteli::getInstance($UserId,$UserHash, $config->error_reporting == 'development');
//            }
//            if(count($Stages)>1)
//                echo "<pre>$PlaceId - $PlaceName <br> Stages: ".count($Stages)."</pre><br>";
//            if(count($Stages)==0){
//                        echo "<pre>Stages : $PlaceId - $PlaceName - ".count($Stages)."<br>";
//                        //print_r($Stages);
//                        echo "  </pre>";  
//            }
            foreach ($Stages as $stageId => $stage ){
//                if(!isset($PlaceName))
//                    $PlaceName = '';
//                if(!isset($stage['Name']))
//                    $stage['Name'] = '';
//                if(!isset($stage['Address']))
//                    $stage['Address'] = '';
                //$stage['id']=(int)$stage['Id'];
                $stage['id']=(string)"{$stage['Id']}-$PlaceId";
                $stage['title']=$PlaceName." :$PlaceId - ".$stage['Name'].($stage['Address']?' ('.$stage['Address'].')':'').' :'.$stage['Id'];
                $stageId = (int)$stageId;
                if($stageId<1 || !isset($stage['title']))
                    echo "<pre>0: $PlaceId - $PlaceName </pre><br>";
                $allStages[$stageId] = $stage;
            }  
        }
//toPrint(array_slice($places, -2), ' $places    '.count($places) );

//        //        echo "<pre>".JText::_('AllPlaces').": ".count($places)."<br>".JText::_('AllStages').": ".count($allStages)."";
//        //print_r($this);
//        echo "  </pre>";
        
        //JFactory::getApplication()->enqueueMessage(print_r($query,true));
        JFactory::getApplication()->enqueueMessage("<pre>"
                .JText::_('AllSelected').": ".join(', ',$StagePlaces)."<br>"
                .JText::_('AllSelected').": ".count($StagePlaces)."<br>"
                .JText::_('AllPlaces').": ".count($places)."<br>"
                .JText::_('AllStages').": ".count($allStages)." </pre>"
                );
        //ksort($allStages);
//        echo "<pre>error: ".print_r(array_pop(SoapClientZriteli::$Errors),true)."<bt>";
//        //print_r($this);
//        echo "  </pre>";   
//        echo "<pre>AllStages: ".count($allStages)."<bt><table>";
//        foreach ($allStages as $k => $s){
////            if(!isset($s['title']))
////                $s['title'] = $s['Name'];
//            echo "<tr><td style='width: 40px;'>$k</td><td>".(isset($s['title'])?$s['title']:print_r($s,true))."</td></tr>";//".print_r($s,true)."
//        }
//        echo "  </table></pre>";      
        
        
//        return ;
//        echo "<pre>AllStages: ".count($allStages)."<br>";
//        print_r($allStages);
//        echo "  </pre>";  
        
//         echo "<pre>Errors: ".count(SoapClientZriteli::$Errors)."<bt>";
//        //print_r($this);
//         echo "  </pre>";          
      
 
        
        //JFactory::getApplication()->enqueueMessage(print_r($query,true));
        
//        echo "<br><pre>\$this: <br>".print_r($this,true)."<bt>";
//        //print_r($this);
//        echo "  </pre>";  
        $html = JHTML::_('select.genericlist', $allStages,$this->name.'','class="inputbox chzn-custom-value"  multiple="multiple"','id','title',$value);
        //toLog($html);
        return $html;
  }
}
?>