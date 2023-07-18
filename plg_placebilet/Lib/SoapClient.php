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
//error_reporting( E_ALL );
//echo "<br>?HELP!! <br>";
                
defined('deb_123') or require_once (__DIR__.'/functions.php');
    

/**
 * 
 * @see     http://market.zriteli.ru/docs/api_specification.pdf 
 */
class SoapClientZriteli //extends SoapClient
{
    
//    function __construct($url = '')
//    { 
//        
////        if($url)
////            parent::__construct($url);
////        else
////            parent::__construct('http://api.zriteli.ru/index.php?wsdl');
//    }
    private static $RequestXMLs = array();
    public static $ErrorId = 0;
    public static $Errors = array();
    public static $Error = '';
    private static $ErrorView = FALSE;
    private static $Client = null;
    
    public static $UserId = 0;
    public static $UserHash = '';
    
    public static $response;

	private static $path="";

    /**
    *  Выполение запроса и возврат XML данных из webservice
    * 
    * @param  string $userId MethodName  for request webservice
    * @param  string $userHash array Attrubtes data for request webservice
    * @param  bool $ErrorView array Attrubtes data for request webservice
    * @return string XML string response from webservice
    */
    public static function getInstance($userId = 111, $userHash = '698d51a19d8a121ce581499d7b701668', $ErrorView=FALSE)//
    {
//        if(class_exists('SoapClient'))
//            toLog (null,'class EXIST SoapClient()');
//        else
//            toLog (null,'class NOT EXIST SoapClient()');
 
//         return;    
        
        try {
//            toLog (static::$Client,'class Inicialization: static::$Client = NULL');
            if(is_null(static::$Client) && PlaceBiletHelper::$param->domen){ 
                static::$Client =  new SoapClient(PlaceBiletHelper::$param->domen);// new self('http://api.zriteli.ru/index.php?wsdl'); https://api.zriteli.ru/index.php?wsdl
                
				
                //static::$Client =  new SoapClient('https://api.direct.yandex.ru/v4/wsdl/');// new self('http://api.zriteli.ru/index.php?wsdl');
//84992482628
//            return;
//                toLog (static::$Client,'class Inicialization: static::$Client = NEW SoapClient()','','','',TRUE);
//                return;
            }
        } catch (Exception $exc) { 
            static::$Errors[]= $exc->getTraceAsString();
            static::$Errors[]= $exc->getMessage();
            static::$Error = $exc->getMessage();
//			toPrint($exc,'$Catch Erorr:',0,true);
            //toPrint($exc->getTraceAsString(),'',1,TRUE,TRUE);
            //toPrint($exc->getMessage(),'',1,TRUE,TRUE);
//            toLog ($exc->getTraceAsString(),'class Inicialization: SoapClient()','',1);
            //
            //echo $exc->getTraceAsString();
        }
//   
//toPrint(2,'TEST !!! ');
//        toPrint(self::$path);
//        toPrint((object)$userId);
//        return;
        
        $userHash = trim($userHash);
        $userId = (int)$userId;
        
        //toPrint('getInstanceZriteli: '.static::$UserId.' - '.static::$UserHash.'; '); 
        //toPrint('getInstanceZriteli: '.$userId.' - '.$userHash.'; '); 
        
        if(     $userId != static::$UserId && $userHash != static::$UserHash && 
                $userId != 111 &&           $userHash != '698d51a19d8a121ce581499d7b701668' && 
                $userId != 0 &&             $userHash != '' && 
                $userId != NULL &&          $userHash != NULL){
            static::$UserId = (int)$userId;
            static::$UserHash = trim($userHash);
            static::$RequestXMLs = array();
            
            //toPrint('getInstanceZriteli:! '.$userId.' - '.$userHash.'; '); 
        }
        static::$ErrorView = $ErrorView;
        
        
    
        if(count(static::$RequestXMLs)==0){
            static::$RequestXMLs['GetPlaceList']              ="<Request> <RequestAuthorization> <UserId>$userId</UserId> <Hash>$userHash</Hash> </RequestAuthorization> <RequestData/></Request>";
            static::$RequestXMLs['GetStageListByPlaceId']     ="<Request> <RequestAuthorization> <UserId>$userId</UserId> <Hash>$userHash</Hash> </RequestAuthorization> <RequestData> <RequestDataObject> <PlaceId>%d</PlaceId> </RequestDataObject> </RequestData> </Request>";
            static::$RequestXMLs['GetSectorListByStageId']    ="<Request> <RequestAuthorization> <UserId>$userId</UserId> <Hash>$userHash</Hash> </RequestAuthorization> <RequestData> <RequestDataObject> <StageId>%d</StageId> </RequestDataObject> </RequestData> </Request> ";
            static::$RequestXMLs['GetRepertoireListByStageId']="<Request> <RequestAuthorization> <UserId>$userId</UserId> <Hash>$userHash</Hash> </RequestAuthorization> <RequestData> <RequestDataObject> <StageId>%d</StageId> </RequestDataObject> </RequestData> </Request> ";
            static::$RequestXMLs['GetAgentList']              ="<Request> <RequestAuthorization> <UserId>$userId</UserId> <Hash>$userHash</Hash> </RequestAuthorization> </Request>";
            static::$RequestXMLs['GetOfferListByRepertoireId']="<Request> <RequestAuthorization> <UserId>$userId</UserId> <Hash>$userHash</Hash> </RequestAuthorization> <RequestData> <RequestDataObject> <RepertoireId>%d</RepertoireId> </RequestDataObject> </RequestData> </Request> ";
            static::$RequestXMLs['GetOfferById']              ="<Request> <RequestAuthorization> <UserId>$userId</UserId> <Hash>$userHash</Hash> </RequestAuthorization> <RequestData> <RequestDataObject> <OfferId>%d</OfferId > </RequestDataObject> </RequestData> </Request> ";
            static::$RequestXMLs['GetOfferListByEventInfo']   ="<Request> <RequestAuthorization> <UserId>$userId</UserId> <Hash>$userHash</Hash> </RequestAuthorization> <RequestData> <RequestDataObject> <RepertoireId>%d</RepertoireId> <EventDateTime>%s</EventDateTime> </RequestDataObject> </RequestData> </Request> ";
            static::$RequestXMLs['GetOfferIdBySeatInfo']      ="<Request> <RequestAuthorization> <UserId>$userId</UserId> <Hash>$userHash</Hash> </RequestAuthorization> <RequestData> <RequestDataObject> <RepertoireId>%d</RepertoireId> <EventDateTime>%s</EventDateTime> <SectorId>%d</SectorId> <Row>%s</Row> <Seat>%s</Seat> </RequestDataObject> </RequestData> </Request> ";
            static::$RequestXMLs['MakeOrder']                 ="<Request> <RequestAuthorization> <UserId>$userId</UserId> <Hash>$userHash</Hash> </RequestAuthorization> <RequestData> <RequestDataObject> <OfferId>%d</OfferId> <SeatList> %s </SeatList> </RequestDataObject> </RequestData> </Request>";
                   
            static::$RequestXMLs['CancelOrder']               ="<Request> <RequestAuthorization> <UserId>$userId</UserId> <Hash>$userHash</Hash> </RequestAuthorization> <RequestData> <RequestDataObject> <OrderId>%d</OrderId> </RequestDataObject> </RequestData> </Request> ";
        }
        
        
        //Call_GetPlaceList 
//        static::Call_GetPlaceList(FALSE);
        
        return static::$Client;
    }
    
    
    /**
    *  Выполение запроса и возврат XML данных из webservice
    * 
    * @param  string $methodName MethodName  for request webservice
    * @param  array $attributes array Attrubtes data for request webservice
    * @return string XML string response from webservice
    */
    private static function call($methodName, $attributes = array(),$getResultOrObject = FALSE){
        
        $xml = static::$RequestXMLs[$methodName];
        //toPrint(static::$RequestXMLs,"","<0>");
        $xml = '<?xml version="1.0" encoding="UTF-8" ?'.'>'.$xml; 
        
        //toPrint($xml,"","<1>");
        
        
        //$xml = sprintf ($xml,static::$UserId, static::$UserHash);
         
        //toPrint($xml,"","<2>");//.static::$UserId." ".static::$UserHash
        
        $xml = vsprintf ($xml,$attributes);
        
        //toPrint($xml,"","<3>"); 
        
        if($methodName == 'MakeOrder')  toLog ($xml,"XML_ReQuest -> $methodName ");
        
        try {
            static::$response = static::$Client->__soapCall($methodName, array($xml));
             
        if($methodName == 'MakeOrder')  toLog (static::$response,"XML_Response -> $methodName ");
            
        } catch (Exception $ex) {
            
            if($methodName == 'MakeOrder')  toLog (static::$response,"ERROR XML_Response -> $methodName ");
        
            $error = $methodName.'('.  join(',', $attributes).')toRecive:';
            $error .= $ex->getMessage();
             
            static::viewExceprtion($error);
            toLog($error."\n".$xml,"SoapClientZriteli::call($methodName)",'day');
            static::$response = "";
            
        if($methodName == 'MakeOrder')  toLog (static::$response,"XML_request -> $methodName ");
        } 
        
//        if($getResultOrObject)
//            return static::$response;
//        else
//            return $this;
            //return (is_object (static::$Client)? static::$Client: $this);
        
    }

    /**
    *  Преобразование XML в объект
    * 
    * @param  string $response XML для преобразования
    * @param  string $errorMessage  Message For Error Message (Method)
    * @param  array $errorAttributes  array Attrubtes For Error Message (Method)
    * @return array objects From Methods request 
    */
    private static function recive($response='', $errorMessage='', $errorAttributes=array()){
        if(empty($response))
            $response = static::$response;
            
        try {
            $result = simplexml_load_string($response);
        } catch (Exception $ex) {
            $error = $errorMessage.'('.  join(',', $errorAttributes).')toObjects:';
            $error .= 'XML_START-> '.$response.' XML_STOP';
            $error .= $ex->getMessage();
            static::viewExceprtion($error);
            toLog($error,"SoapClientZriteli::recive()",'day');
            $result = '';
        } 
        return $result;
    }
    
    /**
    *  Добавление(получение) последней ошибки 
    * 
    * @param  string $error exception adds new Error in array errors
    * @return string Error last message
    */
   public static function viewExceprtion($error = ""){
        
        if(static::$ErrorView){
                static::$Errors[]=$error;
                static::$Error=$error;
        }
        
        if($error != "") return '';
        
        return static::$Error;
    } 
    
     /**
     *  Выполнение метода интернет сервиса
     * 
     * @param   string  $methodName  Id площадка
     * @param   array $attributes  array Attrubtes
     * @return  array objects From Methods request 
    */
    private static function Call_Get($methodName, $attributes = array()){
        
        if(is_null(static::$Client))
            return array();
        
        
        //$data = static::$Client->call($methodName,$attributes,FALSE);         
        //toPrint($data,'Call_Get','<22>');
//        toPrint($methodName,'$methodName');
//        toPrint($attributes,'$attributes');
        $error='';
        try {
       
//       toLog(123,'123<br>','','',TRUE);
            static::call($methodName,$attributes);
        
//       toLog(static::$response,'Call_Get: static::$response:<br>'.static::$Error,'','',TRUE);
            $data = static::recive('',$methodName,$attributes);
            
                   
        //toPrint($data,'Call_Get','<22>');
        
                
            //$data = static::$Client->call($methodName,$attributes,FALSE)->recive('',$methodName,$attributes);         
        } catch (Exception $ex) {
            //$error = $methodName.'('.  join(',', $attributes).')toRecive:';
            $error .= $ex->getMessage();
                
        } 
        
//       toLog($data,'$data: Call_Get: $methodName:'.$methodName,'','',TRUE);
        
        //$data = static::$Client->call($methodName,$attributes,FALSE)->recive('',$methodName,$attributes);         
        
        //$response = static::$Client->call($methodName,$attributes,FALSE);
        //$data = static::$Client->recive($response,$methodName,$attributes);
        /* Вытаскивание ошибки и времени ответа */
        
        
        static::$ErrorId = (int)$data->ResponseResult->Code;
        
        if(static::$ErrorView){
            if($error)
                static::$Errors[]=$error;
            if($error)
                static::$Error=$error;
        
            $RCode = (int)$data->ResponseResult->Code;
            $RDateTime = toStr($data->ResponseResult->DateTime); // new DateTime( $data->ResponseResult->DateTime);
            $RDesc = $data->ResponseResult->Code;
        
            
            
            switch ($RCode){
                case 0: $RDesc .= ' успешное действие; ';break;
                case 1: $RDesc .= ' ошибка интерфейса, неверный формат данных; ';break;
                case 2: $RDesc .= ' ошибка авторизации; ';break;
                
                case 3: $RDesc .= ' предложение недоступно (закрыто или удалено); ';break;
                case 4: $RDesc .= ' агент недоступен (удален, забанен или отключен); ';break;
                case 5: $RDesc .= ' место недоступно (заказано или удалено); ';break;
                case 6: $RDesc .= ' ошибка удаления заказа (заказ не существует или чужой); ';break;
            
                //case 6: $RDesc = '';break;
            } 
            
            if($RCode){
                static::$Error = " $methodName (): errId:$RCode,errDateTime:$RDateTime, errDesc:$RDesc <br/>";
//                $err = toPrint(static::$Error,"$methodName:$RCode",'<-Error-><br>',FALSE);
                //static::$Errors[]=$err;
//                toLog(static::$Error, 'static::$Error');
//                file_put_contents (__DIR__. '/_log.txt'," \n\r $err \n\r ", FILE_APPEND );
            }
            
            
            static::$Errors[] = ['Code'=> $RCode,'DateTime'=>$RDateTime,'Desc'=>$RDesc];
        }
        //toPrint($data->ResponseResult,'Call_Get','<-Error->');
        //toPrint($data,'Call_Get','<22>');
        
        return $data;
    }        

    /**
     *  Получить список площадок(Театров)
     * 
     * @param  bool $IsArray  является ли элемент списка массивом, иначе объектом
     * @return  array Площадок Places object[PlaceId]  (Name,PlaceId, _url) 
    */
    public static function Call_GetPlaceList( $IsArray = TRUE){
        
        if(is_null(static::$Client))
            return array();
        
        $xmlData = static::Call_Get('GetPlaceList');
        
//        return toPrint($xmlData). toPrint(static::$Errors,'GetPlaceList',0);;
        if(is_null($xmlData->ResponseData->ResponseDataObject) 
                || $xmlData->ResponseData->ResponseDataObject->count()==0)
            return array(); 
        //$places = $xmlData->ResponseData->ResponseDataObject->{"ResponseDataObject"};//->{"Place"}
        //$places = $xmlData->ResponseData->ResponseDataObject->{"Place"};//
        $places = $xmlData->ResponseData->ResponseDataObject->Place ;//
        
        $pls=array(); 
        //toPrint($places,'Call_GetPlaceList','< -*- >');
        foreach ($places as $k=>$pl){
            
            $id = (int)toStr($pl->Id);
            $place = new Place();
            $place->Id      =$id;
            $place->Name    =toStr($pl->Name);
            $place->_url    ="<a href='?method=Call_GetStageListByPlaceId&id=$id' >GetStageListByPlaceId $id</a>"; 
            $pls[$id] = $place;
            //$pls[] =  ['Id'=>$pl->Id->__toString(),'Name'=>$pl->Name->__toString()];
        }
        //toPrint($pls);
        
        if($IsArray){
            foreach ($pls as $id => $pl)
                $pls[$id] = (array)$pl;
        }
        return $pls; //return array Places( Name, Id )
    }
    
    /**
     *  Получить список залов площадки (залов Театра)
     *
     * @param   int  $PlaceId  Id площадка 
     * @param  bool $IsArray  является ли элемент списка массивом, иначе объектом
     * @return  array Stages object[StageId]: (Name(StageName),Address,Id(StageId), PlaceId, _url_0, _url_1)
     */
    public static function Call_GetStageListByPlaceId($PlaceId, $IsArray = TRUE){
        
        if(is_null(static::$Client))
            return array();
        
                
        $xmlData =  static::Call_Get('GetStageListByPlaceId',array($PlaceId));
        
        
        if($xmlData->ResponseData->ResponseDataObject->count()==0)
            return array();   
        //toPrint($xmlData); 
        $stages = $xmlData->ResponseData->ResponseDataObject->Stage ;//

        //toPrint($xmlData->ResponseData->ResponseDataObject->count(),"CoUnT:"); 
        //toPrint($xmlData->ResponseData->ResponseDataObject); 
        $stgs=array();   
        $i='';
        try {
            foreach ($stages as $o){
              $i=$o;
//            if(!isset($o->Id) || empty($o->Id->__toString())){
//                throw new Exception(print_r($o,true));
//                continue;
//            }
		$id = (int)toStr($o->Id);
                $stage = new Stage();
                $stage->PlaceId     =toStr($o->PlaceId);
                $stage->Name        =toStr($o->Name);
                $stage->Address     =toStr($o->Address);
                $stage->Id          =$id;
		$stage->_url_0      ="<a href='?method=Call_GetSectorListByStageId&id=$id' >GetSectorListByStageId $id</a>";
                $stage->_url_1      ="<a href='?method=Call_GetRepertoireListByStageId&id=$id' >GetRepertoireListByStageId $id</a>";
		$stgs[$id] =  $stage;
            }
        
        
         
        
        } catch (Exception $ex) {
            static::$Error =     $ex->getMessage();
            static::$Errors[]=   $ex->getMessage();
            echo "<pre>Errors: ".ptrint_r($i,true)." $PlaceId - $name<br>".$ex->getMessage();       echo "  *</pre>";//print_r($PlaceId); 
            echo "<pre>Errors: ".ptrint_r(static::$Errors,true)." $PlaceId - $name<br>".$ex->getMessage();       echo "  *</pre>";//print_r($PlaceId); 
        }
//        
        //toPrint($stgs);
        
        if($IsArray){
            foreach ($stgs as $id => $stg)
                $stgs[$id] = (array)$stg;
        }
        return $stgs; //return array Stages(PlaceId, Name, Address, Id )
    }
    
    
    
    /** 
     * Получить список секторов зала 
     * 
     * @param  int $StageId    
     * @param  bool $IsArray  является ли элемент списка массивом, иначе объектом
     * @return array Sectors object[SectorId]: (Name(SectorName),Id(SectorId),StageId)
     */
    public static function Call_GetSectorListByStageId    ($StageId, $IsArray = TRUE){ 
        
        if(is_null(static::$Client))
            return array();
        
        $xmlData =  static::Call_Get('GetSectorListByStageId',     array($StageId));
        
        if($xmlData->ResponseData->ResponseDataObject->count()==0)
            return array();         
        //toPrint($xmlData); 
        //toPrint($xmlData->ResponseData->ResponseDataObject,'xml'); 
        $Sectors = $xmlData->ResponseData->ResponseDataObject->Sector ;// ->Sector
        
        $sctrs=array();  
        
        
        foreach ($Sectors as $k=>$o){
            $sector = new Sector();
            $sector->StageId=toStr($o->StageId);
            $sector->Name   =toStr($o->Name);
            $sector->Id     =toStr($o->Id);
            $sctrs[(int)toStr($o->Id)] = $sector;
        }
        //toPrint($sctrs,'obj');
        if($IsArray){
            foreach ($sctrs as $id => $sctr)
                $sctrs[$id] = (array)$sctr;
        }
        return $sctrs; //return array Sectors(StageId, Name, Id) 
    }
    
    /**   
     *   Получить список репертуара для зала 
     * 
     * @param  int $StageId    
     * @param  bool $IsArray  является ли элемент списка массивом, иначе объектом
     * @return array  Repertoiries object[RepertoireId](Name(RepertoireName),Id(RepertoireId),StageId, CategoryIdList)
     */     
    public static function Call_GetRepertoireListByStageId($StageId, $IsArray = TRUE){ 
        
        //static $count=0;        
        //$count +=  1;
        //toLog($StageId,'$StageId: '.$count);
        //toPrint($StageId,'$StageId: '.$count);
        
        if(is_null(static::$Client))
            return array();
        
        $xmlData = static::Call_Get('GetRepertoireListByStageId', array($StageId));        
        
//        echo "-";
        try {
            if($xmlData->ResponseData->ResponseDataObject->count()==0)
                return array(); 
        } catch (Exception $exc) {
            toLog($exc->getTraceAsString()."\n".$xmlData,'_','day');
        }
        
        if(empty($xmlData->ResponseData->ResponseDataObject)){ 
            toLog ($xmlData,'$Error: '.static::$Error, '',FALSE); //new SimpleXMLElement();
        }
        //echo "+ ".$xmlData->ResponseData->ResponseDataObject->Repertoire->count();
        //toLog($xmlData);
        //toPrint($xmlData); 
        //toPrint($xmlData->ResponseData->ResponseDataObject,'xml'); //->Repertoire
        $Repertoires = $xmlData->ResponseData->ResponseDataObject->Repertoire ;// ->Sector
        
        $rprtrs=array();
        foreach ($Repertoires as $k=>$o){
            $CategoryIds = array();
            foreach ($o->CategoryIdList->Item as $k => $item)
                $CategoryIds[] =  toStr($item);//->__toString(); 
            
            $id = (int)toStr($o->Id);
            $repertoire = new Repertoire();
            
            $repertoire->StageId        =toStr($o->StageId);
            $repertoire->Name           =toStr($o->Name);
            $repertoire->CategoryIdList =$CategoryIds;
            $repertoire->Id             =$id;
            $repertoire->_url_0         ="<a href='?method=Call_GetOfferListByRepertoireId&id=$id' >GetOfferListByRepertoireId $id</a>";
            $rprtrs[$id] = $repertoire;
            if(empty($repertoire->Name)){
                toLog ($xmlData,''); //new SimpleXMLElement();
                toLog (static::$response,'',__DIR__. '/_logXML.txt'); 
            }
        }
        if($IsArray){
            foreach ($rprtrs as $id => $repertoire)
                $rprtrs[$id] = (array)$repertoire;
        }
        //toPrint($sctrs,'obj');
        
        return $rprtrs; //return array  Repertoiries object[RepertoireId](Name(RepertoireName),Id(RepertoireId),StageId, CategoryIdList)
    }
    
    /**  
     *   Получить список агентов системы 
     *    
     * @param  bool $IsArray  является ли элемент списка массивом, иначе объектом
     * @return array objects Agents (AgentName,CompanyName,Email,Phone,Code,AgentId)
     */     
    public static function Call_GetAgentList( $IsArray = TRUE){ 
        
        if(is_null(static::$Client))
            return array();
        
        $xmlData =  static::Call_Get('GetAgentList',array());
                
         
        if($xmlData->ResponseData->ResponseDataObject->count()==0)
            return array(); 
        //toPrint($xmlData); 
        //toPrint($xmlData->ResponseData->ResponseDataObject,'xml'); //->Repertoire
        $Agents = $xmlData->ResponseData->ResponseDataObject->Agent ;// ->Sector
        
        $agnts=array();  
        foreach ($Agents as $k=>$o){
//            $CategoryIds = array();
//            foreach ($o->CategoryIdList->Item as $k => $item){
//                $CategoryIds[]=$item->__toString();//->__toString();
//            }
            
			$id = (int)toStr($o->Id);
            $agnts[$id] = [
                //'StageId'=>$o->StageId->__toString(),
                'Name'          => toStr($o->Name),
                'CompanyName'   => toStr($o->CompanyName),
                'Email'         => toStr($o->Email),
                'Phone'         => toStr($o->Phone),
                'Code'          => toStr($o->Code),
                //'CategoryIdList'=>$CategoryIds,
                'Id'            => $id];
        }
//
        //toPrint($agnts,'obj');
        
        if($IsArray){
            foreach ($agnts as $id => $agnt)
                $agnts[$id] = (array)$agnt;
        }
        return $agnts; //return array Agents(Name,CompanyName, Email, Phone, Code, Id)
    }
    
    /**   
     *   Получить список предложений агентов для мероприятия 
     * 
     * @param  int $RepertorieId   Repertorie Id 
     * @param  bool $IsArray  является ли элемент списка массивом, иначе объектом
     * @return array objects  Offers (SectorId, Row, SeatList, NominalPrice, AgentPrice, EventDateTime, RepertoreId, AgentId, ETicket, OfferId)
     */      
    public static function Call_GetOfferListByRepertoireId($RepertorieId, $IsArray = TRUE){ 
        
        if(is_null(static::$Client))
            return array();
        
        $xmlData = static::Call_Get('GetOfferListByRepertoireId', array($RepertorieId));
                
        
        
         
        if($xmlData->ResponseData->ResponseDataObject->count()==0)
            return array(); 
//        toPrint(static::$ErrorId); 
//        toPrint(static::$Error); 
        //toPrint($xmlData); 
//        toPrint($xmlData->ResponseData->ResponseDataObject,'xml:'.$RepertorieId); //->Repertoire
        $Offers = $xmlData->ResponseData->ResponseDataObject->Offer ;// ->Sector
        
        //toPrint($RepertorieId,' RepertorieId: ');
        //toPrint($Offers,'obj');
        $offrs=array();
        foreach ($Offers as $k=>$o){
            $Seats = array();
            foreach ($o->SeatList->Item as $k => $item){//
                $Seats[]=toStr($item);//->__toString();
            }
            
            $id = (int)toStr($o->Id);
                
            $offer = new Offer();
                    
            $offer->SectorId      = toStr($o->SectorId);
            $offer->Row           = toStr($o->Row);
            $offer->SeatList      = $Seats;//$o->SeatList->Item->count(),
            $offer->NominalPrice  = toStr($o->NominalPrice);
            $offer->AgentPrice    = toStr($o->AgentPrice);
            $offer->EventDateTime = toStr($o->EventDateTime);
            $offer->RepertoireId  = toStr($o->RepertoireId);
            $offer->AgentId       = toStr($o->AgentId);
            $offer->ETicket       = toStr($o->ETicket);
            //$offer->CategoryIdList=$CategoryIds;
            $offer->Id            = $id;
            $offer->_url_0        = "<a href='?method=Call_GetOfferById&id=$id' >GetOfferById $id</a>";
            $offrs[(int)toStr($o->Id)] = $offer;
            
        }
        if($IsArray){
            foreach ($offrs as $id => $offer)
                $offrs[$id] = (array)$offer;
        }
        //toPrint($offrs,'obj');
        
        
        return $offrs; //return array Offers(SectorId,Row,SeatList(id),NominalPrice,AgentPrice,EventDateTime, RepertoireId, AgentId, ETicket, Id)
    }
    
    /** 
     *   Получить предложение 
     * 
     * @param  int $OfferId    
     * @param  bool $IsArray  является ли элемент списка массивом, иначе объектом
     * @return object Offer (SectorId,Row,SeatList,NominalPrice,AgentPrice,EventDateTime,RepertoireId,AgentId,ETicket,OfferId)
     */     
    public static function Call_GetOfferById($OfferId, $IsArray = TRUE){ 
        
        if(is_null(static::$Client))
            return array();
        
        $xmlData = static::Call_Get('GetOfferById',               array($OfferId));
        
         
        if($xmlData->ResponseData->ResponseDataObject->count()==0)
            return array(); 
        //toPrint(static::$ErrorId); 
        //toPrint(static::$Error); 
        //toPrint($xmlData); 
        //toPrint($xmlData->ResponseData->ResponseDataObject,'xml'); //->Repertoire
        $Offers = $xmlData->ResponseData->ResponseDataObject->Offer ;// ->Sector
        
        //toPrint($Offers,'obj');
        $offrs=array();
        foreach ($Offers as $k=>$o){
            $Seats = array();
            foreach ($o->SeatList->Item as $k => $item){//
                $Seats[]=toStr($item);//->__toString();
            }
                
            $offer = new Offer();
                    
            $offer->SectorId      = toStr($o->SectorId);
            $offer->Row           = toStr($o->Row);
            $offer->SeatList      = $Seats;//$o->SeatList->Item->count(),
            $offer->NominalPrice  = toStr($o->NominalPrice);
            $offer->AgentPrice    = toStr($o->AgentPrice);
            $offer->EventDateTime = toStr($o->EventDateTime);
            $offer->RepertoireId  = toStr($o->RepertoireId);
            $offer->AgentId       = toStr($o->AgentId);
            $offer->ETicket       = toStr($o->ETicket);
            //$offer->CategoryIdList=$CategoryIds;
            $offer->Id            = (int)toStr($o->Id);
            $offrs[(int)toStr($o->Id)] = $offer; 
        }
       
        if($IsArray){
            foreach ($offrs as $id => $offer)
                $offrs[$id] = (array)$offer;
        }
        //toPrint($offrs,'obj');
        
        return $offrs; //return array Offer(SectorId,Row,SeatList(id),NominalPrice,AgentPrice,EventDateTime, RepertoireId, AgentId, ETicket, Id)
    }
    
    /** 
     *   Получить(загрузка) список предложений(Событий) агентов для события  
     * 
     * @param  int $RepertoireId
     * @param  int $EventDateTime
     * @param  bool $IsArray  является ли элемент списка массивом, иначе объектом
     * @return array objects Offers (SectorId,Row,SeatList,NominalPrice,AgentPrice,EventDateTime,RepertoireId,AgentId,ETicket,OfferId)
     */     
    public static function Call_GetOfferListByEventInfo($RepertoireId,$EventDateTime, $IsArray = TRUE): array{ 
        
        if(is_null(static::$Client))
            return array();
        
        if(PlaceBiletHelper::JRequest()->getInt('deb')==1)
            toLog('',  "\$xmlData $RepertoireId $EventDateTime ".static::$ErrorId."-ERROR:".static::$Error,  '', TRUE);
       // return array();
        
        $xmlData = static::Call_Get('GetOfferListByEventInfo',    array($RepertoireId,$EventDateTime));
        
        if(static::$ErrorId)
            toLog($xmlData,  "\$xmlData $RepertoireId $EventDateTime ".static::$ErrorId."-ERROR:".static::$Error,  '-', TRUE);
        
        
//        toLog($xmlData, '$xmlData+2'." $RepertoireId $EventDateTime", '', '', TRUE);
        
         
        try {
            if ($xmlData->ResponseData->ResponseDataObject->count() == 0)
                return array();

        } catch (Exception $exc) { 
            toLog($exc->getTraceAsString()."\n".$xmlData,'_','day');
        }


        try {
        //return array();
        //toPrint(static::$ErrorId); 
        //toPrint(static::$Error); 
        //toPrint($xmlData); 
        //toPrint($xmlData->ResponseData->ResponseDataObject,'xml'); //->Repertoire
        $Offers = $xmlData->ResponseData->ResponseDataObject->Offer ;// ->Sector
        
        //toPrint($Offers,'obj');
        $offrs=array();
        foreach ($Offers as $k=>$o){
            $Seats = array();
            foreach ($o->SeatList->Item as $k => $item){//
                $Seats[]=toStr($item);//->__toString();
            }
            
            $offer = new Offer();
                    
            $offer->SectorId      = toStr($o->SectorId);
            $offer->Row           = toStr($o->Row);
            $offer->SeatList      = $Seats;//$o->SeatList->Item->count(),
            $offer->NominalPrice  = toStr($o->NominalPrice);
            $offer->AgentPrice    = toStr($o->AgentPrice);
            $offer->EventDateTime = toStr($o->EventDateTime);
            $offer->RepertoireId  = toStr($o->RepertoireId);
            $offer->AgentId       = toStr($o->AgentId);
            $offer->ETicket       = toStr($o->ETicket);
            //$offer->CategoryIdList=$CategoryIds;
            $offer->Id            = (int)toStr($o->Id);
            $offrs[(int)toStr($o->Id)] = $offer;
        }
        if($IsArray){
            foreach ($offrs as $id => $offer)
                $offrs[$id] = (array)$offer;
        }
        //toPrint($offrs,'obj');
        } catch (Exception $exc) { 
            toLog($exc->getTraceAsString()."\n".$xmlData,'_','day');
        }
        
        return $offrs; //return array Offers(SectorId,Row,SeatList(id),NominalPrice,AgentPrice,EventDateTime, RepertoireId, AgentId, ETicket, Id)
    }
    
    /** 
     *   Получить Id предложения по информации о месте
     * 
     * @param   int $RepertoireId	
     * @param   int $EventDateTime	
     * @param   int $SectorId		
     * @param   int $Row				
     * @param   int $Seat			   
     * 
     * @return int Offer OfferId 
     */     
    public static function Call_GetOfferIdBySeatInfo($RepertoireId, $EventDateTime, $SectorId, $Row, $Seat){ 
        
        if(is_null(static::$Client))
            return array();
        
        $xmlData = static::Call_Get('GetOfferIdBySeatInfo',array($RepertoireId, $EventDateTime, $SectorId, $Row, $Seat));        
        
         
        if($xmlData->ResponseData->ResponseDataObject->count()==0)
            return array(); 
        //toPrint(static::$ErrorId); 
        //toPrint(static::$Error); 
        //toPrint($xmlData); 
        //toPrint($xmlData->ResponseData->ResponseDataObject,'xml'); //->Repertoire
        $OfferId = $xmlData->ResponseData->ResponseDataObject->OfferId ;// ->Sector
        
        //toPrint($Offers,'obj'); 
        return toStr($OfferId);//return int OfferId
    }
    
    /**  
     *   Сделать заказ билетов в предложении 
     * 
     * @param   int $OfferId  
     * @param   array $SeatList
     * @return object Order SeatList,Price,Comment,DateTime,ClientId,AgentId,OfferId,OrdrId
     * 0 - выполнено; 
     * 3 – предложение недоступно (закрыто или удалено); 
     * 4 – агент недоступен (удален, забанен или отключен); 
     * 5 – место недоступно (заказано или удалено);  
     */     
    public static function CallMod_MakeOrder( $OfferId, array $SeatList){ 
        
        if(is_null(static::$Client))
            return array();
        
        
        $Seats = '';
        foreach ($SeatList as $seat)
            $Seats .= "<Item>$seat</Item> ";
        
        toLog($Seats,'XML$Seats');
        
        $xmlData = static::Call_Get('MakeOrder',                  array($OfferId,$Seats));
        
        //toLog($xmlData,'XMLresponseData');
         
        if($xmlData->ResponseData->ResponseDataObject->count()==0)
            return array(); 
        //toPrint(static::$ErrorId); 
        //toPrint(static::$Error); 
        //toPrint($xmlData); 
        //toPrint($xmlData->ResponseData->ResponseDataObject,'xml'); //->Repertoire
        $Orders = $xmlData->ResponseData->ResponseDataObject->Order ;// ->Sector
        
        //toPrint($Offers,'obj');
        $ordrs=array();
        foreach ($Orders as $k=>$o){
            $Seats = array();
            foreach ($o->SeatList->Item as $k => $item){//
                $Seats[]=toStr($item);//->__toString();
            }
            
            $ordrs[(int)toStr($o->Id)] = [
                'SeatList' => $Seats,//$o->SeatList->Item->count(),
                'Price'    => toStr($o->Price),
                'Comment'  => toStr($o->Comment),
                'DateTime' => new DateTime( toStr($o->DateTime)),
                'ClientId' => (int)toStr($o->ClientId),
                'AgentId'  => (int)toStr($o->AgentId),
                'OfferId'  => (int)toStr($o->OfferId),
                'Id'       => (int)toStr($o->Id)];
        }

        //toPrint($ordrs,'obj');
        
        return $ordrs; //return array Offers(SectorId,Row,SeatList(id),NominalPrice,AgentPrice,EventDateTime, RepertoireId, AgentId, ETicket, Id)
    }
    
    /**  
     *  Отменить заказ билетов 
     * 
     * @param   int $OrderId    
     * @return bool Success run method 
     * 0 - выполнено; 
     * 6 - ошибка удаления заказа (заказ не существует или чужой);  
     */     
    public static function CallMod_CancelOrder               ($OrderId){ 
        
        if(is_null(static::$Client))
            return array();
        
        $xmlData = static::Call_Get('CancelOrder',                array($OrderId));
        
        
        $RCode = (int)$xmlData->ResponseResult->Code; 
        
        //toPrint($xmlData,'obj'); 
        //toPrint(static::$ErrorId); 
        if($RCode==0)
            return TRUE;
        
        return FALSE;//return bool Success
    }
    
    
     /**  
     *  Получить описание метода
     * 
     * @param  string Name method
     * @return string Descrtiption method   
     * @see http://php.net/manual/en/class.reflectionmethod.php
     * @see https://habrahabr.ru/post/139649/
     */    
    public static function GetDocComment($MethodName,$tag=''){//'@DocTag'
        
        $getDocComment = function  ($str, $tag = '') { 
                if (empty($tag)) {    
                    $str = str_replace([' * ','/**','*/'], '<br/>', $str);
                    return $str;  
                }

                $matches = array(); 
                preg_match("/".$tag.":(.*)(\\r\\n|\\r|\\n)/U", $str, $matches); 

                if (isset($matches[1]))     
                    return trim($matches[1]);    

                return ''; 
            };


        $method = new ReflectionMethod('SoapClientZriteli', $MethodName); 
        return $getDocComment($method->getDocComment(), $tag); //'@DocTag'
    }//http://php.net/manual/en/class.reflectionmethod.php
    
    public static function GetDocParams($MethodName,$tag=''){//'@DocTag'
        
        $getDocComment = function  ($str, $tag = '') { 
                if (empty($tag)) {    
                    $str = str_replace([' * ','/**','*/'], '<br/>', $str);
                    return  explode ('@param', trim(explode('@return', $str, 1))) ;    
                }

                $matches = array(); 
                preg_match("/".$tag.":(.*)(\\r\\n|\\r|\\n)/U", $str, $matches); 

                if (!isset($matches[1]))     
                    return ''; 
                
                $s = trim($matches[1]);
                $s = explode('@return', $s, 1) ;
                return explode ('<br/>', trim($s)) ;    

                
            };


        $method = new ReflectionMethod('SoapClientZriteli', $MethodName); 
        return $getDocComment($method->getDocComment(), $tag); //'@DocTag'
    }//http://php.net/manual/en/class.reflectionmethod.php
    
}


/**
 * Предложение событие, где есть время, цена, репертуар, ряд и группа мест по одной цене
 */
//class PieceAgent{
//    
//}
/**
 * Сцена
 */
class Place{
    
}
/**
 * Репертуар
 */
class Repertoire{
    
}


/**
 * Офера
 */
class Offer{
    
}
/**
 * Сектор из зрителей
 */
class Sector{
    
}

/**
 * 
 */
class Stage{
    
}
