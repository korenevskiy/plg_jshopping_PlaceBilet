/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

let readyBilet = function(){
//	let fields = document.querySelectorAll('.nextFocus');
//	for(let fld of fields){
//		fld.addEventListener("keypress", function(event) {// keypress, keyup, keydown
//			if (event.keyCode === 13 || event.which === 13) {
////console.log('KeyPressEnter');
//				event.preventDefault();
////				document.getElementById("id_of_button").click();
//				return false;
//			}
//		});
//	}
};
document.addEventListener("DOMContentLoaded", readyBilet); 

//return;




let btnsPlacePlusMinus = function(){
	if(document.querySelector('.jshop_places') == null)
		return;
//	return;
//'use strict';
//console.log('Start: btnsPlacePlusMinus');
	Array.from(document.querySelectorAll('.PlaceMinus'), function(btn){
		btn.addEventListener('click',function(){
			const fieldTarget = document.getElementById(btn.dataset.id);
			if(fieldTarget == null)
				return;
		
			let value = parseInt(fieldTarget.value, 10);
			
			if(value == 0)
				return;
			value = isNaN(value) ? 0 : value;
			value--;
			fieldTarget.value = value;
		});
	});
	
	Array.from(document.querySelectorAll('.PlacePlus'), function(btn){
		btn.addEventListener('click',function(){
			const fieldTarget = document.getElementById(btn.dataset.id);
			if(fieldTarget == null)
				return;
		
			let value = parseInt(fieldTarget.value, 10);
			value = isNaN(value) ? 0 : value;
			value++;
			fieldTarget.value = value;
		});
	});
};
document.addEventListener("DOMContentLoaded", btnsPlacePlusMinus); 

/*
 * Аккардион для страницы товаров
 * @returns {undefined}
 */
jQuery(function () {
    
    if(! jQuery().even ) {
        jQuery.fn.even = function() {
            return this.filter( ":even" );
        };
    }
    
//    jQuery('#placebilet').accordion({header: "> .ui-accordion-content > .ui-accordion-header",
//            heightStyle:'content', autoHeight:false,collapsible:true, active: 0}); 
    //return;
//    jQuery('.ui-accordion>*').even().css( "background-color", "red" );
    
    jQuery('#placebilet.ui-accordion > .ui-accordion-content > .attributes_side').animate({height:'0'}, 4000,  function(){
        //return;
        var width = jQuery('.ui-accordion').width(); 
//        console.log(width,'width');
        jQuery("<style>").prop("type", "text/css").html("#placebilet .ui-accordion-content{width:auto;}#placebilet .ui-accordion-content-active{width:"+width+"px;}")
				.appendTo("head");
        
        jQuery('.inpt_radio').remove();
        
        //console.log(jQuery('.ui-accordion').width());
        //jQuery('.ui-accordion').css('align-items','stretch');
        
        jQuery('#placebilet > .ui-accordion-content > .attributes_side').css('height','auto');//.css('display','none');
        jQuery('#placebilet').accordion({//'header': ".ui-accordion-header", // "> .ui-accordion-content > .ui-accordion-header"
            heightStyle:'content', autoHeight:false,collapsible:true, active: 0}); // !!!!!!!!!! <<-------------
        
        //jQuery('.ui-accordion-group').width('auto');
        
        //console.log(jQuery('.ui-accordion').width());
//        https://xn--80ajushact.xn--p1ai/templates/jquery-ui.min.js
//        jquery-ui.min.js /templates/jquery-ui.min.js
        //return;
            
        //jQuery('.ui-accordion-header').click(function(){
            
//            console.log(jQuery('.ui-accordion').width());
            //jQuery(this).parent().width(jQuery('.ui-accordion').width());
//            //jQuery('.ui-accordion-header').width('493px');
            //jQuery('.ui-state-default').width('493px');
//            jQuery('.ui-state-active').width(jQuery('.ui-accordion').width());
//            //.ui-state-active
//ui-accordion-header-collapsed ui-corner-all
//ui-accordion-header-active    ui-state-active
        //});
    });
    //return;
    
    //jQuery('table.accordion').accordion({header: '.category', autoHeight:false, fillSpace: true, collapsible:true, animate: 800 });// , active: 0, collapsible: false  active: 0,
    //jQuery('#placebilet').accordion({autoHeight:false,collapsible:true, active: 10});//,icons:{'header':'','headerSelected':''}
    //jQuery('.ui-accordion-content').hide(8000, function(){
        //alert("Wow");
    //    jQuery('#jshop').accordion({autoHeight:false,collapsible:true, active: 20});
    //}); 
    
    //jQuery('.ui-accordion-content').animate({height: 'hide'}, 8000, 'easeOutCirc');
    //jQuery('#jshop').accordion({autoHeight:false,collapsible:true, active: 20});
    // jQuery("#accordion1").accordion({autoHeight:false,event:"mouseover"});
    
    
});


/*
 * Калькулятор для страницы товаров
 */
document.addEventListener("DOMContentLoaded", function(){
	
	if(document.querySelector('.jshop_places') == null)
		return;

	const outputCountPlaces	= document.querySelectorAll('.outputCountPlaces');//.innerHTML = document.querySelectorAll('input.checkboxplace:checked').length;
	const outputSelectFields= document.querySelectorAll('.outputSelectFields');//.innerHTML = '';
	const outputPriceAll	= document.querySelectorAll('.outputPriceAll');//.innerHTML = sum + ' ' + cur_name;
	
	let checkboxesPushkaMode = document.querySelectorAll('.checkPushkaMode');
	
	document.querySelectorAll('input.btn-buy[type="submit"]').forEach(btn => {btn.setAttribute('readonly', true); btn.disabled = true;});
	
	
	let clickCheckboxPlace =  function(event, uncheckOther = true) {
//console.log('clickCheckbox()',event);
//console.log('uncheckOther',uncheckOther);
		
		let checkOnce = checkboxesPushkaMode.length && Array.from(checkboxesPushkaMode).at(0).checked;
//		let checkCurrent = event.target.checked;

		
		if(checkOnce){
			document.querySelectorAll('input.checkboxplace').forEach(function(chkBox){
				if(event.target != chkBox && uncheckOther) chkBox.checked = false;
			});
		}
		
//		let checkBoxes = Array.from(document.querySelectorAll('input.checkboxplace:checked'), box => box);
		let inputBoxes = Array.from(document.querySelectorAll('input.checkboxplace:checked,input.PlaceNumber'), function(box){
			if(box.type == 'number' && box.value < 1)
				return null;
//			let lbl = box.parentElement;
//			lbl.dataset.count = box.value;
			return box;
		}).filter(flt => flt);
		
		let inputBoxCount = inputBoxes.reduce((count, box) => count + parseInt(box.value), 0 );
		


		outputCountPlaces.forEach(outputCount => outputCount.innerHTML = inputBoxCount);

		let output = inputBoxes.reduce( (out, box) => out + box.parentElement.title + (box.value > 1 ? ' ' + box.value + box.dataset.pcs  : '') + '<br>', '');
		outputSelectFields.forEach(outputSelect => outputSelect.innerHTML = output);
		
		inputBoxes.forEach( (box) => 
		{
			console.log(box, box.dataset.price, box.value , '=',parseFloat(box.dataset.price) * parseInt(box.value)	);
				
		});
		
		
		let sum = inputBoxes.reduce( (sum, box) => sum + (parseFloat(box.dataset.price) * parseInt(box.value)), 0 );
		outputPriceAll.forEach(outputPrice => outputPrice.innerHTML = sum);
		
		if(inputBoxes.length)
			document.querySelectorAll('input.btn-buy[type="submit"]').forEach(btn => {btn.removeAttribute('readonly');btn.disabled = false;});
		else
			document.querySelectorAll('input.btn-buy[type="submit"]').forEach(btn => {btn.setAttribute('readonly', true);btn.disabled = true;});
//console.log('checkBoxes',checkBoxes);
	};
	
	document.querySelectorAll('input.checkboxplace,input.placebutton').forEach(checkbox => checkbox.addEventListener("click", clickCheckboxPlace));
	document.querySelectorAll('input[type=number].PlaceNumber').forEach(btnBox => btnBox.addEventListener("change", clickCheckboxPlace));
	
	
	checkboxesPushkaMode.forEach(checkboxMode => checkboxMode.addEventListener('change', 
		event => {
			if(event.currentTarget.checked){
				Array.from(document.querySelectorAll('input.checkboxplace:checked')).slice(1).forEach(chkBox => chkBox.checked = false);
			}
			checkboxesPushkaMode.forEach(chkboxMode => {
				if(event.currentTarget != chkboxMode && chkboxMode.checked != event.currentTarget.checked){
					chkboxMode.checked = event.currentTarget.checked;
				}else{
					event.preventDefault();
				}
			});
			clickCheckboxPlace(event, false);
//console.log('event',event);
		}
	));
	
	function uncheck() {
		document.querySelectorAll('input.checkboxplace').forEach(checkbox => checkbox.checked = false ); 
		clickCheckboxPlace();
	}
	document.querySelectorAll('input.btnClear').forEach(btnClear => btnClear.addEventListener("click", uncheck));
});