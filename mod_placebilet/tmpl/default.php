<?php
 /** ----------------------------------------------------------------------
 * plg_placebilet - Plugin Joomshopping Component for CMS Joomla
 * ------------------------------------------------------------------------
 * author    Sergei Borisovich Korenevskiy
 * @copyright (C) 2019 //explorer-office.ru. All Rights Reserved. 
 * @license GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 * @package		Jshopping,plg_placebilet
 * @subpackage  mod_placebilet
 * Websites: //explorer-office.ru/download/
 * Technical Support:  Forum - //fb.com/groups/multimodulefb.com/groups/placebilet/
 * Technical Support:  Forum - //vk.com/placebilet
 * -------------------------------------------------------------------------
 **/

defined('_JEXEC') or die;



use \Joomla\CMS\Factory as JFactory;
use \Joomla\CMS\HTML\HTMLHelper as JHtml;
use modPlaceBiletHelper as Helper;
//use \Joomla\Module\Placebilet\Administrator\Helper\PlaceBiletHelper as Helper; // Этот тип класса не поддерживается Ajax

$id		= (int)$module->id;
$doc	= $app->getDocument();

JHtml::_('form.csrf');

$param = Helper::$param;//$params->toObject(); // $this->params = new xRegistry($this->params); // $this->params->toObject();
		
// toPrint( Helper::getEventTitleList(), 'eventList',true,'message',true);
// toPrint($param, '$param',true,'message',true);

//JHtml::script($img);// register($img, $function);
//$wa = new \Joomla\CMS\WebAsset\WebAssetManager;
$wa = JFactory::getApplication()->getDocument()->getWebAssetManager();
//$wa->registerAndUseScript('Instascan', 'https://rawgit.com/schmich/instascan-builds/master/instascan.min.js', [], ['defer' => true]);
$wa->registerAndUseScript('Instascan', 'administrator/modules/mod_placebilet/media/instascan.min.js', [], ['defer' => true]);
$wa->registerAndUseScript('BeepJS', 'administrator/modules/mod_placebilet/media/beep.js', [], ['defer' => true]);
$wa->registerAndUseStyle('mod_placebilet.admin', 'administrator/modules/mod_placebilet/media/style.css');
//$wa->registerScript('jquery.ui', 'modules/mod_multi/media/jquery/jquery-ui-1.13.2/jquery-ui.min.js');
//$wa->registerStyle('jquery.ui', 'modules/mod_multi/media/jquery/jquery-ui-1.13.2/jquery-ui.min.css');
//JFactory::getApplication()->getDocument()->getWebAssetManager()->useStyle('jquery.ui')->useScript('jquery.ui');

$wa->addInlineScript('
	document.addEventListener("DOMContentLoaded", function(){form_QR_'.$id.'.t = "'.JFactory::getApplication()->getFormToken().'"}); 
');
//        array_unshift($languages, HTMLHelper::_('select.option', '', Text::_('JDEFAULTLANGUAGE')));
//        $select = JHtml::_('select.genericlist', Helper::getEventTitleList(), 'fieldEventID_'.$id, 'class="form-select"', 'id', 'title', null);
		
//JFactory::getApplication()->getDocument()->getWebAssetManager()->usePreset('jquery.ui');
//JFactory::getApplication()->getDocument()->getWebAssetManager()->usePreset('jquery.ui');
//$wa->useAsset($img, $link_title);
//$wa->useStyle('jquery.ui')->useScript('jquery.ui');

		
?>

<div class="mod-placebilet placebilet">
	
	<form id="form_QR_<?=$id?>" data-id="<?=$id?>" data-beep="<?=$param->pushka_camera_beep ?? 'yes'?>" 
		  data-btn_Visit_Statuses='<?=json_encode($param->btn_visit_statuses ?? ['O'])?>'
		  data-btn_Refund_Statuses='<?=json_encode($param->btn_refund_statuses ?? ['O'])?>'
		  data-btn_Cancel_Statuses='<?=json_encode($param->btn_cancel_statuses ?? ['O'])?>'
		  >
		
		<div>
			<?php echo JHTML::_('form.token');?>
<a id="ajaxTest<?=$id?>" target="_blank" href="?option=com_ajax&module=placebilet&method=getStatus&id=329&format=debug&<?=$app->getFormToken()?>=1&QRcode=js14.1444440871">
<?=$app->getFormToken()?></a>
		</div>
		
	<?php if($param->pushka_camera??true):?>
	<div class="controls camera">
		<button onclick="return cameraStart(<?=$id?>);" class=" btn btn-outline-primary _btn-primary  btn-sm" type="button"  id="camera_start_<?=$id?>"><?= JText::_('JSHOP_PUSHKA_START_CAMERAS')?></button>
		<select onclick="return cameraStart(<?=$id?>);"  id="select_QRcameras_<?=$id?>"  onchange='return selectChangeCameras(<?=$id?>,this)' 
				data-selectDefault="<?=$param->pushka_camera_select??'first'?>" class="form-select form-select-sm cameras"  aria-label="<?= JText::_('JSHOP_PUSHKA_CAMERAS_LIST')?>">
			<option value=""><?=JText::_('JSHOP_PUSHKA_CAMERA_SELECT')?></option>
		</select>
		<button onclick="return cameraStop(<?=$id?>);" class=" btn btn-outline-primary btn-sm" type="button"  id="camera_stop_<?=$id?>"><?= JText::_('JSHOP_PUSHKA_STOP_CAMERAS')?></button>
	</div>
	<?php endif;?>
	<video id="preview_<?=$id?>" class="video" style="display: none;"></video>
	
	<?php 
	if (($param->pushka_platform??'auto') == 'auto'){
		echo JHtml::_('select.genericlist', Helper::getEventTitleList(), 'eventID', ['id'=>'fieldEventID_'.$id, 'option.key'=>'id', 'option.text'=>'title',
			'list.attr'=>[
				'class'=>'form-select nextFocus',
				'data-nextFocus'=>'field_QRcode_'.$id
				]
			]);
	}
	if (($param->pushka_platform??'auto') == 'other'): ?>
		<div class='input-group _flex-nowrap'>
			<!--<label class='input-group-text  btn-outline-secondary' id='labelEventID_<?=$id?>' for='fieldEventID_<?=$id?>'><i class="fa fa-tag" aria-hidden="true"></i></label>-->
			<button onclick="return fieldEventID_<?=$id?>.value=''"  class="btn btn-outline-secondary" type="button"  label="<?= JText::_('JSHOP_PUSHKA_QR_CLEAR')?>"><i class="fa fa-times" aria-hidden="true"></i></button>
			<input id='fieldEventID_<?=$id?>' name='eventID' class='form-control nextFocus' aria-describedby='labelEventID_<?=$id?>' inputmode="numeric" type='text' data-nextFocus="field_QRcode_<?=$id?>" 
			   placeholder='<?=JText::_('JSHOP_PUSHKA_EVENTID')?>' aria-label='<?=JText::_('JSHOP_PUSHKA_EVENTID')?>'>
			<!--<button onclick="return fixQRText.call(form_QR_<?=$id?>,fieldEventID_<?=$id?>);"  class="btn btn-outline-secondary" type="button" id="buttonScan_<?=$id?>" label="<?= JText::_('JSHOP_PUSHKA_QR_CLEAR')?>"><i class="fa fa-tag" aria-hidden="true"></i></button>-->
		</div>
	<?php endif;?>
	<div class="input-group flex-nowrap">
		 <!--<span class="input-group-text" id="addon-wrapping">@</span>-->
		<!--<label class="qrcode-text-btn input-group-text  btn-outline-secondary" id="qr_label_<?=$id?>" for="field_QRcode_<?=$id?>">-->
			<!--<i class="fa fa-tag" aria-hidden="true"></i> -->
			<!--<i class="fa fa-barcode" aria-hidden="true"></i>-->
			<!--<i class="fa fa-qrcode fade" aria-hidden="true"></i>-->
		<!--</label>-->
		
		<button onclick="return field_QRcode_<?=$id?>.value=''"  class="btn btn-outline-secondary" type="button" id="buttonClear_<?=$id?>" label="<?= JText::_('JSHOP_PUSHKA_QR_CLEAR')?>"><i class="fa fa-times" aria-hidden="true"></i></button>
<!-- --><input id="field_QRcode_<?=$id?>" name='QRcode' class="form-control nextFocus" aria-describedby="qr_label_<?=$id?>" type="text" 
			   placeholder="<?= JText::_('JSHOP_PUSHKA_QR_CODE')?>"  aria-label="<?= JText::_('JSHOP_PUSHKA_QR_CODE')?>"
			   data-nextFocus="camera_start_<?=$id?>"
			   _onchange="fieldOnChangeQRcode.call(form_QR_<?=$id?>,this);" 
			   onkeydown="if(event.key==13 || event.which == 13)  cameraScan.call({id:<?=$id?>},this.value,false);"
			   _onkeyup="if(event.key==13 || event.which == 13){ event.preventDefault();cameraScan.call({id:<?=$id?>},this.value,true);return false; }  return true;" 
			   _onkeypress=" if(event.key==13 || event.which == 13){ event.preventDefault();cameraScan.call({id:<?=$id?>},this.value,false);return false; }  return true;" 
			   > 
		<button onclick="return cameraScan.call({id:<?=$id?>},field_QRcode_<?=$id?>.value, true);"  class="qrcode-text-btn  btn btn-outline-secondary" type="button" id="buttonScan_<?=$id?>" label="<?= JText::_('JSHOP_PUSHKA_QR_CLEAR')?>"><i class="fa fa-qrcode fade" aria-hidden="true"></i></button>
	</div>
	
	</form>
	
	
	<message id="message_<?=$id?>" class="message" style='display:none' onclick="return clickMessage(<?=$id?>,this);"
		data-nocameras="<?= JText::_('JSHOP_PUSHKA_NOT_CAMERAS')?>"
		data-active="<?= JText::_('JSHOP_PUSHKA_STATUS_ACTIVE')?>"
		data-visited="<?= JText::_('JSHOP_PUSHKA_STATUS_VISITED')?>"
		data-refunded="<?= JText::_('JSHOP_PUSHKA_STATUS_REFUNDED')?>"
		data-canceled="<?= JText::_('JSHOP_PUSHKA_STATUS_CANCELED')?>"
		>
	</message>
	
	<?php // echo $module->content; ?>
	
	<div class="controls action"> 
		<button onclick="return clickBtnVisit(<?=$id?>)" class="button-visit btn _btn-primary btn-action _btn-info -success btn-block btn-lg <?= $param->pushka_visit?'':'hidden' ?>" type="button" id="btn_visit_<?=$id?>" style='display:none'><?= $param->button_name_visit?:JText::_('JSHOP_PUSHKA_STATUS_VISIT')?></button>
		<button onclick="return clickBtnRefund(<?=$id?>)" readonly class="button-refund btn btn-warning   btn-lg <?= $param->pushka_refund?'':'hidden' ?>" type="button" id="btn_refund_<?=$id?>" style='display:none'><?= $param->button_name_refund ?:JText::_('JSHOP_PUSHKA_STATUS_REFUND')?></button>
		<button onclick="return clickBtnCancel(<?=$id?>)" readonly class="button-cancel btn btn-light  btn-lg <?= $param->pushka_cancel?'':'hidden' ?>" type="button" id="btn_cancel_<?=$id?>" style='display:none'><?= $param->button_name_cancel ?:JText::_('JSHOP_PUSHKA_STATUS_CANCEL')?></button>
	</div>
	
<!--JSHOP_PUSHKA_STATUS_ACTIVE="Активный"

JSHOP_PUSHKA_STATUS_VISIT="Посетить"
JSHOP_PUSHKA_STATUS_REFUND="Возместить"
JSHOP_PUSHKA_STATUS_CANCEL="Отменить"

JSHOP_PUSHKA_STATUS_VISITED="Посещён"
JSHOP_PUSHKA_STATUS_REFUNDED="Возмещён"
JSHOP_PUSHKA_STATUS_CANCELED="Отменён"-->
</div>

	
	
	
	
<script type="text/javascript" data-module='<?=$id?>'>
// <!-- Без ID -->
	
let loadCamsInSelect = function(id){
	
	let selectControl_QRcamera = document.getElementById('select_QRcameras_' + id);
	
	for(let opt_i in selectControl_QRcamera.options){
		selectControl_QRcamera.remove(opt_i);
	}
	
	return Instascan.Camera.getCameras().then(function (cameras) {
		if(cameras.length == 0){
			
		    let opt = document.createElement('option');
			opt.value = '';
			opt.innerHTML = "<?= JText::_('JSHOP_PUSHKA_CAMERA_NONE')?>";
			selectControl_QRcamera.appendChild(opt);
console.log("<?= JText::_('JSHOP_PUSHKA_CAMERA_NONE')?>");
			return '';
		}
//		selectControl_QRcamera.dataset.item = cameras[0].id ;//cameras.at();
//		selectControl_QRcamera.camera = cameras[0].id;
//console.log('Камеры',cameras);
//selectControl_QRcamera.scanner.start(cameras[0]);
		
		cameras.reverse();

		selectControl_QRcamera.cameras = [];

		for (let cam of cameras){
			selectControl_QRcamera.cameras.push(cam);
			let opt = document.createElement('option');
			opt.camera = cam;
			opt.mirror = false;
			opt.value = cam.id;
			opt.innerHTML = cam.name ?? cam.id;
			selectControl_QRcamera.appendChild(opt);
			
			selectControl_QRcamera.cameras.push(cam);
			opt = document.createElement('option');
			opt.mirror = true;
			opt.value = cam.id;
			opt.innerHTML = '⇆ ' + (cam.name ?? cam.id);
			selectControl_QRcamera.appendChild(opt);

		}
		
		let selectOption = selectControl_QRcamera.options[0];
		
		selectControl_QRcamera.selectCamera = selectControl_QRcamera.cameras[0];
		
		selectControl_QRcamera.mirror = selectOption.mirror;

	}).catch(function (e) {
		console.error(e);
		return '';
	});
};
	
let cameraStart = function(id){

//console.log('Form',form);

	let form = document.getElementById('form_QR_' + id);

	let select_QRcameras = document.getElementById('select_QRcameras_' + id);
	
	let preview = document.getElementById('preview_' + id);
	

	if(preview.classList.contains('active')){
		return;
	}

	let promiseLoadCams = null;

	if(select_QRcameras.options.length < 2){
		promiseLoadCams = loadCamsInSelect(id);
	}
	
	let selectdefault = select_QRcameras.dataset.selectdefault ?? 'first';
	
	let mirrorDefault = selectdefault == 'last';
//console.log(select_QRcameras.selectedIndex,'select_QRcameras.selectedIndex');
	
	
//console.log(selectdefault,'selectdefault');
//console.log(select_QRcameras.selectedIndex,'select_QRcameras.selectedIndex');
//console.log(select_QRcameras.options.length,'select_QRcameras.options.length');
	
	form.classList.add("active");

	if( ! form.scanner){
		form.scanner = new Instascan.Scanner({ video: preview, mirror: select_QRcameras.mirror ?? mirrorDefault });
		form.scanner.id = id;
		form.scanner.addListener('scan', cameraScan);
		form.scanner.mirror = mirrorDefault;
	}
	let scanner = form.scanner;
	
//	console.log('cameraStart() preview',preview);
//	console.log('cameraStart() scanner',scanner);
//	console.log('cameraStart() select_QRcameras.value',select_QRcameras.value);
	
	
	
//	if(select_QRcameras.value){
//		console.log('camera CURRENT:',select_QRcameras.value);
		//select_QRcameras.cameras[selectControl.selectedIndex]
		
//		promisesLoadCams.push();

//		let currentCamera = select_QRcameras.cameras[select_QRcameras.selectedIndex];

//		let selectedIndex = select_QRcameras.selectedIndex;
//
//		if(selectedIndex != -1 && selectdefault == 'first')
//			select_QRcameras.selectedIndex = 0;
//		if(selectedIndex != -1 && selectdefault == 'last')
//			select_QRcameras.selectedIndex = select_QRcameras.options.length - 1; 
//		
		if(promiseLoadCams){
			promiseLoadCams.then(function(){
//console.log(select_QRcameras.selectedIndex,'select_QRcameras.selectedIndex');
//				if(select_QRcameras.selectedIndex == -1)
				select_QRcameras.selectedIndex = selectdefault == 'first' ? 0 : select_QRcameras.length - 1;
				scanner.start(select_QRcameras.cameras[select_QRcameras.selectedIndex]);
			}).then(function(){
				preview.style.display = "block";
				
	
			});
		}else{
//console.log(select_QRcameras.selectedIndex,'select_QRcameras.selectedIndex');
//			if(select_QRcameras.selectedIndex == -1)
//			select_QRcameras.selectedIndex = selectdefault == 'first' ? 0 : select_QRcameras.length - 1;
			scanner.start(select_QRcameras.cameras[select_QRcameras.selectedIndex]).then(function(){
				preview.style.display = "block";
			});
		}
		
		
//	}
//	typeof r
//console.log(typeof select_QRcameras.selectCamera);
};

let cameraStop = function(id){
	
	let form = document.getElementById('form_QR_' + id);
	
	form.classList.remove("active");
	
	console.log('form.scanner',form.scanner);
	
	if(form.scanner){
		form.scanner.stop().then(function(){
//			form.scanner._disableScan();
			form.scanner.backgroundScan = false;
//console.log("Camera STOP");
			document.getElementById('preview_' + id).style.display = "none";
		});
//		form.scanner = null;
	}
};

// Корректировка текста в поле QR, дополняется буквами.
let fixQRText = function(enterQR = ''){
	if(enterQR.length != 0 && enterQR.substring(0, 1).match(/[0-9]/i)){
		return 'js' + enterQR;
	}
	return enterQR;
};

 
let selectChangeCameras = function(id, selectControl_QRcamera){
	
	
	let form = document.getElementById('form_QR_' + id);
	
	
	if(selectControl_QRcamera.options.length == 0){
		selectControl_QRcamera.mirror = true;
		return;
	}
	
	if(form.scanner){
		form.scanner.stop();
		form.scanner = null;
	}
	
	let selectOption = selectControl_QRcamera.options[selectControl_QRcamera.selectedIndex];
//console.log(selectOption.mirror,'selectOption.mirror');
//console.log(selectOption,'selectOption');
//console.log(selectControl_QRcamera.selectedIndex,'selectedIndex');
	form.scanner = new Instascan.Scanner({ video: document.getElementById('preview_' + id), mirror: selectOption.mirror });
	form.scanner.id = id;
	form.scanner.addListener('scan', cameraScan);
	form.scanner.start(selectControl_QRcamera.cameras[selectControl_QRcamera.selectedIndex]).then(function(){
			document.getElementById('preview_' + id).style.display = "block";
		});
	selectControl_QRcamera.mirror = selectOption.mirror;
};

//document.addEventListener("DOMContentLoaded", loadCamsInSelect);


	 
</script> 
<script type="text/javascript"  data-module='<?=$id?>'>
let cameraScan = function(QRcode, noBeep = null){
	
console.log('CameraScan: ',QRcode);
ajaxTestLinkUpdate(QRcode, this.id);
	//this - Это обект сканера
	
	QRcode = fixQRText(QRcode);
	
	
	let field_QRcode = document.getElementById('field_QRcode_' + this.id);
	
	if(field_QRcode.readOnly == true){
console.log('CameraScan DISABLED. ');
		return;
	}
		
	
	let form = document.getElementById('form_QR_' + this.id);
	
	if(form && form.dataset.beep && form.dataset.beep != '0' && noBeep == null){
		new Beep(22050).play(1000, 0.3, [Beep.utils.amplify(20000)]);
	}
//console.log('This',this);
//console.log(noBeep);

//	console.log(content);
	field_QRcode.value = QRcode;
	
	ajaxGetStatus(QRcode, this.id);
	
	return false;
};
 
let clickBtnVisit = function(id){
	let field_QRcode = document.getElementById('field_QRcode_' + id);
	if(field_QRcode.value){
		ajaxGetStatus(field_QRcode.value, id, 'Visit');
	}
}
let clickBtnRefund = function(id){
	let field_QRcode = document.getElementById('field_QRcode_' + id);
	if(field_QRcode.value){
		ajaxGetStatus(field_QRcode.value, id, 'Refund');
	}
}
let clickBtnCancel = function(id){
	let field_QRcode = document.getElementById('field_QRcode_' + id);
	if(field_QRcode.value){
		ajaxGetStatus(field_QRcode.value, id, 'Cancel');
	}
}

</script>

<script type="text/javascript"  data-module='<?=$id?>'>
	
let ajaxGetStatus = function(QRcode, id, action = ''){
	
	let form = document.getElementById('form_QR_' + id);
	let t =  form ? form.t : '';
	
	let data =  {
		id	: id,
		QRcode : QRcode,
		eventID : document.getElementById('fieldEventID_' + id) ? document.getElementById('fieldEventID_' + id).value : '',
		format: 'json', // json|debug
		token : t,
		action : action,
		[t] : 1,
	};
//	data[t] = 1;
	
console.log('data',data);
console.log('JSONdata',JSON.stringify(data));
	
	let GetToken = true ? '&token=' + t + '&' + t + '=1': '';
	Joomla.request({
		url: '?option=com_ajax&module=placebilet&method=&format=json&id=' + id + GetToken, //index.php?option=mod_placebilet&view=example
      	method: 'POST',
		headers: {
			'Cache-Control' : 'no-cache',
			'Your-custom-header' : 'custom-header-value',
			'Content-Type': 'application/json'
		},

		data:  JSON.stringify(data),
		
		onSuccess: function (response, xhr){
			if(response == '')
				return;
			
			
			document.getElementById('field_QRcode_' + id).readOnly = true;
	
console.log('CameraScan DISABLE... ');
			
			let message = document.getElementById('message_' + id);
			
//			response.messages;	// null
//			response.message;	// null
//			response.success;	// true
			
//console.log('response',response);
//console.log('xhr',xhr);
			
//console.log('response',response);
			let jsonResponse = JSON.parse(response);
			let dataResponse = jsonResponse.data ?? {};
//console.log('dataResponse',dataResponse);
//console.log('---------------------');
			
			message.innerHTML = dataResponse.content ?? '';
//			message.innerHTML = response;
			message.style = 'display:block';
			
			dataResponse.status_code;
			
//		$statusBD->btnVisitWorkStatuses		= $param->btn_visit_work_statuses ?? ['O'];
//		$statusBD->btnRefundWorkStatuses	= $param->btn_refund_work_statuses ?? ['O'];
//		$statusBD->btnCancelWorkStatuses	= $param->btn_cancel_work_statuses ?? ['O'];
			
			let btnVisitStatuses	= JSON.parse( form.dataset.btn_visit_statuses ?? '["O"]' );
			let btnRefundStatuses	= JSON.parse( form.dataset.btn_refund_statuses ?? '["O"]' );
			let btnCancelStatuses	= JSON.parse( form.dataset.btn_cancel_statuses ?? '["O"]' );

console.log('btnVisitStatuses',btnVisitStatuses);
console.log('btnRefundStatuses',btnRefundStatuses);
console.log('btnCancelStatuses',btnCancelStatuses);
console.log('dataResponse.place_status_code',dataResponse.place_status_code);
			if(btnVisitStatuses && btnVisitStatuses.includes(dataResponse.place_status_code)){
				document.getElementById('btn_visit_' + id).style.display = 'block';
			} else {
				document.getElementById('btn_visit_' + id).style.display = 'none';
			}
			if(btnRefundStatuses && btnRefundStatuses.includes(dataResponse.place_status_code)){
				document.getElementById('btn_refund_' + id).style.display = 'block';
			} else {
				document.getElementById('btn_refund_' + id).style.display = 'none';
			}
			if(btnCancelStatuses && btnCancelStatuses.includes(dataResponse.place_status_code)){
				document.getElementById('btn_cancel_' + id).style.display = 'block';
			} else {
				document.getElementById('btn_cancel_' + id).style.display = 'none';
			}
console.log(document.getElementById('camera_start_' + id).style.display);

//			'status_code'		=> $statusBD->status_code,
//			'status_date_added'	=> $statusBD->status_date_added,
//			'status_title'		=> $statusBD->status_title,
//			'place_status_title'=> $statusBD->place_status_title,
//			'place_status_code'	=> $statusBD->place_status_code,
//			'place_status_date'	=> $statusBD->place_status_date,
			
			
//			setInterval(function() {
//				document.getElementById('message_' + id).style = 'display:none;';
//				
//			}, 10000); 
		},
		onError: function (response, xhr){
			
			console.log('ERROR response',response);
			console.log('ERROR response Text',response.responseText);
			console.log('ERROR xhr',xhr);
		},
//		onBefore: function (xhr){},				// Тут делаем что-то до отправки запроса. Если вернём false - запрос не выполнится
//		onSuccess: function (response, xhr){},	// Тут делаем что-то с результатами. Проверяем пришли ли ответы
//		onError: function (response, xhr){},	// Тут делаем что-то в случае ошибки запроса. Получаем коды ошибок и выводим сообщения о том, что всё грустно.
//		onComplete: function (response, xhr){},	// Тут что-то делаем в любом случае после ajax-запроса. В не зависимости от результата.
    });
};

let ajaxTestLinkUpdate = function(QRcode, id){
	let a = document.getElementById('ajaxTest' + id);
	let i = a.href.lastIndexOf('&QRcode=') + 8;
	let i2 = a.href.indexOf('&', i);
	a.href = a.href.substring(0, i) + QRcode +  a.href.substring(i2 == -1 ? 1000 : i2);
//console.log(a.href);
};
//document.addEventListener("DOMContentLoaded", ajaxGetStatus); 

let clickMessage = function (id,panelMessage){
	panelMessage.style = 'display:none;';
	document.getElementById('field_QRcode_' + id).readOnly = false; 
	console.log('CameraScan ENABLE. ');
	
	let form = document.getElementById('form_QR_' + id);
	form.scanner.backgroundScan = true;
};



</script>

<script type="text/javascript"  data-module='<?=$id?>'>
let ready = function(){
	let fields = document.querySelectorAll('.nextFocus');
	for(let fld of fields){
		fld.addEventListener("keypress", function(event) {// keypress, keyup, keydown
			if (event.keyCode === 13 || event.which === 13) {
//console.log('KeyPressEnter');
				event.preventDefault();
//				document.getElementById("id_of_button").click();
				return false;
			}
		});
	}
};
document.addEventListener("DOMContentLoaded", ready); 
</script>

<?php return ?>
<?php  
 

?>

 