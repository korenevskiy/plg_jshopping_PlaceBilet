

 
//DOMContentLoaded
//document.addEventListener("DOMContentLoaded", function(){
//	Array.from(document.querySelectorAll('.mod_placebiletFormQR'), form => DOMContentLoaded.call({},form,form.dataset.id)());
//});
//DOMContentLoaded
document.addEventListener("DOMContentLoaded", function(){Array.from(document.querySelectorAll('form.mod_placebiletFormQR'), form => (function(form, id){


this.form = form;
this.id = id;
this.debug = Boolean(Number(form.dataset.debug));

//if(this.debug){
//	console.clear();
//	console.log('РедиЛоад() 6');
//	console.log('form',form);
//	console.log('form.t',form.t);
//	console.log('token',token);
//}

const token = form.t ?? '';

const language = form.lang ?? '';



const select_EventID = document.getElementById('select_EventID_' + id);

const select_CameraQR = document.getElementById('select_CamerasQR_' + id);
select_CameraQR.addEventListener('change',selectChangeCameras);
select_CameraQR.addEventListener('click',function(){
	if (select_CameraQR.options.length < 2)
		cameraStart();
});

const btn_camera_start = document.getElementById('btn_camera_start_' + id);
btn_camera_start.addEventListener('click',cameraStart);

const btn_camera_stop = document.getElementById('btn_camera_stop_' + id);
btn_camera_stop.addEventListener('click',cameraStop);

if(!this.debug){
	btn_camera_stop.classList.add("hidden");
}
	



const btn_visit = document.getElementById('btn_visit_' + id);
btn_visit.addEventListener('click',clickBtnVisit);

const btn_refund = document.getElementById('btn_refund_' + id);
btn_refund.addEventListener('click',clickBtnRefund);

const btn_cancel = document.getElementById('btn_cancel_' + id);
btn_cancel.addEventListener('click',clickBtnCancel);

const input_CodeQR = document.getElementById('input_CodeQR_' + id);
input_CodeQR.addEventListener('keydown',function(event){
	if (event.key == 13 || event.which == 13)
		cameraScan.call(this, input_CodeQR.value, false);
});

const btn_Clear = document.getElementById('buttonClear_' + id);
btn_Clear.addEventListener('click',() => input_CodeQR.value = '');

const btn_GetStatus = document.getElementById('button_GetStatus_' + id);
btn_GetStatus.addEventListener('click', () => cameraScan.call(this, input_CodeQR.value, true));

const videoView = document.getElementById('videoView_' + id);

const messageTag = document.getElementById('message_' + id);
messageTag.addEventListener('click', clickMessage);

const aTagAjaxLinkTest = document.getElementById('aTagAjaxLinkTest' + id);
if(this.debug){
	aTagAjaxLinkTest.classList.remove("hidden");
}else{
	aTagAjaxLinkTest.classList.add("hidden");
}
	
	
const btn_FullScreen = document.getElementById('btn_fullscreen_' + id);
if(!jQuery.fullscreen.isNativelySupported())
	btn_FullScreen.style.display = 'none';
btn_FullScreen.addEventListener('click', function(){
	
	if(jQuery.fullscreen.isFullScreen()){
		jQuery.fullscreen.exit();
		document.querySelector('.mod-placebilet.placebilet.mod'+id).classList.remove("fullscreen");
	}else{
		jQuery('.mod-placebilet.placebilet.mod'+id).fullscreen();
		document.querySelector('.mod-placebilet.placebilet.mod'+id).classList.add("fullscreen");
	}
		
});
 

function storage(cameraIndex = null){
	if(localStorage.getItem("cameraIndex") === null)
		return -1;
		
	
	if(cameraIndex == -1){
		throw new Error('Поймался пустой индекс!');
	}
	
	if(cameraIndex != null)
		localStorage.cameraIndex = cameraIndex;
	
	
	
	return localStorage.cameraIndex;
}

//let form = document.getElementById('form_QR_' + id);
/*
 * Загрузка списка камер
 */
function loadCamsInSelect (cameras)
{
	
	for(let opt_i in select_CameraQR.options){
		select_CameraQR.remove(opt_i);
	}
	
		if(cameras.length == 0) {
			let opt = document.createElement('option');
			opt.value = '';
			opt.innerHTML = Joomla.JText._('JSHOP_PUSHKA_CAMERA_NONE');
			select_CameraQR.appendChild(opt);
			
				console.log(Joomla.Text._('JSHOP_PUSHKA_CAMERA_NONE'));
			
//			setTimeout(function(opt){
//				opt.innerHTML = Joomla.JText._('JSHOP_PUSHKA_CAMERA_SELECT');
//			},2000,opt);
			return;
		}
//		select_CameraQR.dataset.item = cameras[0].id ;//cameras.at();
//		select_CameraQR.camera = cameras[0].id;
//console.log('Камеры',cameras);
//select_CameraQR.scanner.start(cameras[0]);

		cameras.reverse();

		select_CameraQR.cameras = [];

		for (let cam of cameras) {
			select_CameraQR.cameras.push(cam);
			let opt = document.createElement('option');
			opt.camera = cam;
			opt.mirror = false;
			opt.value = cam.id;
			opt.innerHTML = cam.name ?? cam.id;
			select_CameraQR.appendChild(opt);

			select_CameraQR.cameras.push(cam);
			opt = document.createElement('option');
			opt.mirror = true;
			opt.value = cam.id;
			opt.innerHTML = '⇆ ' + (cam.name ?? cam.id);
			select_CameraQR.appendChild(opt);
		}
		
		
		select_CameraQR.selectedIndex = storage() > -1 ? storage() : 0;
		
		
		if(select_CameraQR.selectedIndex < 0)
			select_CameraQR.selectedIndex = 0;

		let selectOption = select_CameraQR.options[select_CameraQR.selectedIndex];
		select_CameraQR.selectCamera = select_CameraQR.cameras[select_CameraQR.selectedIndex];
		select_CameraQR.mirror = selectOption.mirror;
		
		
	let selectdefault = select_CameraQR.dataset.selectdefault ?? 'first';
	
	let cameraIndex = storage();
	
	if(cameraIndex < 0 && selectdefault == 'first'){
		select_CameraQR.selectedIndex = 0;
		storage(0);
	}
	
	if(cameraIndex < 0 && selectdefault == 'last'){
		select_CameraQR.selectedIndex = select_CameraQR.length - 1;
		storage(select_CameraQR.length - 1);
	}
	
	if(cameraIndex > -1 ){
		select_CameraQR.selectedIndex = storage();
	}
	
}


function cameraStart() {

//console.log('Form',form);

	let cameraIndex = storage();

	if(cameraIndex == -1 || select_CameraQR.selectedIndex == -1){
		// || select_CameraQR.options.length == 0 || select_CameraQR.cameras.length == 0 || !select_CameraQR.options.includes(cameraIndex) || !select_CameraQR.options.includes(cameraIndex)
		Instascan.Camera.getCameras().then(loadCamsInSelect).catch(function (e) {
			let alert = Joomla.Text._('JSHOP_PUSHKA_ALERT_NOCAMERA');
			console.error(alert + "\n" + Joomla.Text._('JSHOP_PUSHKA_ALERT_ERROR') + ": " + e.message);
//			console.log('Ошибка ' + e.name + ":" + e.message + "\n" + e.stack);
//			alert(alert);
			
		});
		return;
	}
	
	
	let start = function (cameras) {
console.log('XXX 1-2');
				
//console.log(select_CameraQR.selectedIndex,'select_CameraQR.selectedIndex');
//				if(select_CameraQR.selectedIndex == -1)
		
		if(select_CameraQR.options.length < 2)
			loadCamsInSelect(cameras);

		if(select_CameraQR.options.length < 2){
			alert(Joomla.JText._('JSHOP_PUSHKA_ALERT_NOCAMERA'));
			return;
		}
		

		let mirror = select_CameraQR.options[cameraIndex].mirror ?? false;
		let camera = select_CameraQR.cameras[select_CameraQR.selectedIndex];
		

		if (!form.scanner) {
			form.scanner = new Instascan.Scanner({video: videoView, backgroundScan: false,  mirror: mirror});
			form.scanner.id = id;
			form.scanner.mirror = mirror;
			form.scanner.addListener('scan', cameraScan);
		}

//		videoView.style.display = "block";
		form.scanner.mirror = mirror;
		form.scanner.start(camera).then(function(){
			videoView.style.display = "block";
			if(!this.debug){
				btn_camera_stop.classList.remove("hidden"); // btn_camera_start //btn_camera_stop
				btn_camera_start.classList.add("hidden");
			}			
		}).catch(function(err){
console.log('CameraQR: Error Start!');
			alert(Joomla.JText._('JSHOP_PUSHKA_ALERT_NOCAMERA'));
		});
	};
	
//		if(!this.debug){
//			btn_camera_stop.classList.remove("hidden"); // btn_camera_start //btn_camera_stop
//			btn_camera_start.classList.add("hidden");
//		}
	 
		
	Instascan.Camera.getCameras().then(start).catch(function (e) {
		let alert = Joomla.Text._('JSHOP_PUSHKA_ALERT_NOCAMERA');
		console.error(alert + "\n" + Joomla.Text._('JSHOP_PUSHKA_ALERT_ERROR') + ": " + e.message);
//		console.log('Ошибка ' + e.name + ":" + e.message + "\n" + e.stack);
//		alert(alert);
		return '';
	});


//console.log(select_CameraQR.selectedIndex,'select_CameraQR.selectedIndex');

//console.log(selectdefault,'selectdefault');
//console.log(select_CameraQR.selectedIndex,'select_CameraQR.selectedIndex');
//console.log(select_CameraQR.options.length,'select_CameraQR.options.length');



//	console.log('cameraStart() preview',videoView);
//	console.log('cameraStart() scanner',scanner);
//	console.log('cameraStart() select_CameraQR.value',select_CameraQR.value);



//	if(select_CameraQR.value){
//		console.log('camera CURRENT:',select_CameraQR.value);
				//select_CameraQR.cameras[selectControl.selectedIndex]

//		promisesLoadCams.push();

//		let currentCamera = select_CameraQR.cameras[select_CameraQR.selectedIndex];

//		let selectedIndex = select_CameraQR.selectedIndex;
//
//		if(selectedIndex != -1 && selectdefault == 'first')
//			select_CameraQR.selectedIndex = 0;
//		if(selectedIndex != -1 && selectdefault == 'last')
//			select_CameraQR.selectedIndex = select_CameraQR.options.length - 1; 
// 
//console.log(typeof select_CameraQR.selectCamera);
}

function cameraStop() {
	form.classList.remove("active");


	
	console.log('form.scanner', form.scanner);

	if (form.scanner) {
		form.scanner.stop().then(function () {
//			form.scanner._disableScan();
//			form.scanner.backgroundScan = false;
//console.log("Camera STOP");
			videoView.style.display = "none";
			if(!this.debug){
				btn_camera_stop.classList.add("hidden"); // btn_camera_start //btn_camera_stop
				btn_camera_start.classList.remove("hidden");
			}
		});
//		form.scanner = null;
	}
}

// Корректировка текста в поле QR, дополняется буквами.
function fixQRText(enterQR = '') {
	if (enterQR.length != 0 && enterQR.substring(0, 1).match(/[0-9]/i)) {
		return 'js' + enterQR;
	}
	return enterQR;
}


function selectChangeCameras() {

	
	if (select_CameraQR.options.length < 2) {
		
		
		select_CameraQR.mirror = true;
		return;
	}

	if (form.scanner) {
		form.scanner.stop();
		form.scanner = null;
	}

	let selectOption = select_CameraQR.options[select_CameraQR.selectedIndex];
//console.log(selectOption.mirror,'selectOption.mirror');
//console.log(selectOption,'selectOption');
//console.log(select_CameraQR.selectedIndex,'selectedIndex');
	form.scanner = new Instascan.Scanner({video: videoView, mirror: selectOption.mirror, backgroundScan: false});
	form.scanner.id = id;
	form.scanner.addListener('scan', cameraScan);
	form.scanner.start(select_CameraQR.cameras[select_CameraQR.selectedIndex]).then(function () {
		videoView.style.display = "block";
		if(!this.debug){
			btn_camera_stop.classList.remove("hidden"); // btn_camera_start //btn_camera_stop
			btn_camera_start.classList.add("hidden");
		}		
	});
	select_CameraQR.mirror = selectOption.mirror;
	
	storage(select_CameraQR.selectedIndex);
//	localStorage.cameraIndex = select_CameraQR.selectedIndex;
}

//document.addEventListener("DOMContentLoaded", loadCamsInSelect);

function clickBtnVisit() {
	if (input_CodeQR.value) {
		ajaxGetStatus(input_CodeQR.value, 'Visit');
	}
}
function clickBtnRefund() {
	if (input_CodeQR.value) {
		ajaxGetStatus(input_CodeQR.value, 'Refund');
	}
}
function clickBtnCancel() {
	if (input_CodeQR.value) {
		ajaxGetStatus(input_CodeQR.value, 'Cancel');
	}
}

function cameraScan(QRcode, noBeep = null) {

	if(QRcode == '')
		return;
	

//	let QRcode = input_CodeQR.value;
	console.log('CameraScan: ', QRcode);
	ajaxTestLinkUpdate(QRcode);
//this - Это обект сканера

	QRcode = fixQRText(QRcode);
console.log('CameraScan: ', QRcode);

	if (input_CodeQR.readOnly == true) {
		console.log('CameraScan DISABLED. ');
		return;
	}

	if (form && form.dataset.beep && form.dataset.beep != '0' && noBeep == null) {
		new Beep(22050).play(1000, 0.3, [Beep.utils.amplify(20000)]);
	}
//console.log('This',this);
//console.log(noBeep);

//	console.log(content);
	input_CodeQR.value = QRcode;

	ajaxGetStatus(QRcode);

	return false;
}



function ajaxGetStatus(QRcode, action = '') {


	console.log('ajaxGetStatus', QRcode, token);

//	let t = form ? form.t : '';
	if(!token){
		messageTag.innerHTML = Joomla.JText._('JSHOP_PUSHKA_ALERT_ERROR_SESSION');
//		message.innerHTML = response;
//		messageTag.style = 'display:block';
		messageTag.style = '';
		return;
	}
	
	
//	let t = form ? form.t : '';

	let data = {
			id: id,
			QRcode: QRcode,
			eventID: select_EventID ? select_EventID.value : '',
			format: 'json', // json|debug
			token: token,
			action: action,
			lang: language,
			[token]: 1,
	};
//	data[t] = 1;

//console.clear();
	console.log('data', data);
//	console.log('JSONdata', JSON.stringify(data));

	Joomla.request({
		headers: {
				'Cache-Control': 'no-cache',
				'Your-custom-header': 'custom-header-value',
				'Content-Type': 'application/json'
		},
		url: `?option=com_ajax&module=placebilet&method=&format=json&id=${id}&lang=${language}&token=${token}&${token}=1`, //index.php?option=mod_placebilet&view=example
		method: 'POST',
		data: JSON.stringify(data),
		onBefore: function (xhr){
//			Тут делаем что-то до отправки запроса. 
//			Если вернём false - запрос не выполнится
		},
		onSuccess: function (response, xhr) {
			if (response == '')
				return;

//			if(!this.debug)
//				input_CodeQR.readOnly = true;

console.log('CameraScan DISABLE... ');
 

//			response.messages;	// null
//			response.message;	// null
//			response.success;	// true

//console.log('response',response);
//console.log('xhr',xhr);

console.log('response',response);
		let jsonResponse = null;
		let dataResponse = null;
		
		try {
			jsonResponse = JSON.parse(response);
			dataResponse = jsonResponse.data ?? {};
		} catch (error) {
			
			messageTag.innerHTML = Joomla.JText._('JSHOP_PUSHKA_ALERT_ERROR_SESSION');
			messageTag.style = '';
			return false;
		}
		if (!jsonResponse || !dataResponse) {
			
			messageTag.innerHTML = Joomla.JText._('JSHOP_PUSHKA_ALERT_ERROR_SESSION');
			messageTag.style = '';
			return false;
		}

		if (!jsonResponse.data && jsonResponse.message) {
			messageTag.innerHTML = jsonResponse.message;
			messageTag.style = '';
			return false;
		}
		if (!dataResponse.data && dataResponse.message) {
			messageTag.innerHTML = dataResponse.message;
			messageTag.style = '';
			return false;
		}


			
console.log('jsonResponse',jsonResponse);
console.log('jsonResponse.data',jsonResponse.data);
console.log('---------------------');

			messageTag.innerHTML = dataResponse.content ?? '';
//			message.innerHTML = response;
//			messageTag.style = 'display:block';
			messageTag.style = '';
	
			dataResponse.status_code;

//		$statusBD->btnVisitWorkStatuses		= $param->btn_visit_work_statuses ?? ['O'];
//		$statusBD->btnRefundWorkStatuses	= $param->btn_refund_work_statuses ?? ['O'];
//		$statusBD->btnCancelWorkStatuses	= $param->btn_cancel_work_statuses ?? ['O'];

			let btnVisitStatuses = JSON.parse(form.dataset.btn_visit_statuses ?? '["O"]');
			let btnRefundStatuses = JSON.parse(form.dataset.btn_refund_statuses ?? '["O"]');
			let btnCancelStatuses = JSON.parse(form.dataset.btn_cancel_statuses ?? '["O"]');

	console.log('btnVisitStatuses', btnVisitStatuses);
	console.log('btnRefundStatuses', btnRefundStatuses);
	console.log('btnCancelStatuses', btnCancelStatuses);
	console.log('dataResponse.place_status_code', dataResponse.place_status_code);

			if (btnVisitStatuses && btnVisitStatuses.includes(dataResponse.place_status_code)) {
				btn_visit.style.display = 'block';
			} else {
				btn_visit.style.display = 'none';
			}
			if (btnRefundStatuses && btnRefundStatuses.includes(dataResponse.place_status_code)) {
				btn_refund.style.display = 'block';
			} else {
				btn_refund.style.display = 'none';
			}
			if (btnCancelStatuses && btnCancelStatuses.includes(dataResponse.place_status_code)) {
				btn_cancel.style.display = 'block';
			} else {
				btn_cancel.style.display = 'none';
			}
			console.log(btn_camera_start.style.display);

//			'status_code'		=> $statusBD->status_code,
//			'status_date_added'	=> $statusBD->status_date_added,
//			'status_title'		=> $statusBD->status_title,
//			'place_status_title'=> $statusBD->place_status_title,
//			'place_status_code'	=> $statusBD->place_status_code,
//			'place_status_date'	=> $statusBD->place_status_date,

//			setInterval(function() {
//				messageTag.style = 'display:none;';
//			}, 10000);
		},
		onError: function (response, xhr) {

	console.log('ERROR response', response);
	console.log('ERROR response Text', response.responseText);
	console.log('ERROR xhr', xhr);
		},
//		onBefore: function (xhr){},				// Тут делаем что-то до отправки запроса. Если вернём false - запрос не выполнится
//		onSuccess: function (response, xhr){},	// Тут делаем что-то с результатами. Проверяем пришли ли ответы
//		onError: function (response, xhr){},	// Тут делаем что-то в случае ошибки запроса. Получаем коды ошибок и выводим сообщения о том, что всё грустно.
//		onComplete: function (response, xhr){},	// Тут что-то делаем в любом случае после ajax-запроса. В не зависимости от результата.
	});
}

function ajaxTestLinkUpdate(QRcode) {
	if(!this.debug)
		return;
	let a = aTagAjaxLinkTest;
	let i = a.href.lastIndexOf('&QRcode=') + 8;
	let i2 = a.href.indexOf('&', i);
	a.href = a.href.substring(0, i) + QRcode + a.href.substring(i2 == -1 ? 1000 : i2);
//console.log(a.href);
}
 

function clickMessage() {
	messageTag.style = 'display:none;';
//	input_CodeQR.readOnly = false;
	console.log('CameraScan ENABLE. ');

//	form.scanner.backgroundScan = true;
}

//return function (){
//	console.clear();
//	console.log('Инициализация');
//};

}).call({},form,form.dataset.id));
});


let ready = function () {
	let fields = document.querySelectorAll('.nextFocus');
	for (let fld of fields) {
		fld.addEventListener("keypress", function (event) {// keypress, keyup, keydown
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
