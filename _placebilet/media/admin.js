
        
         
/**
 * Изменено Добавленно добавлен метод
 * @param {Number} id
 * @param {HTMLElement} button
 * @returns {Number}
 */
function addAttributValueInt(id, button){//id=attrib_id           console.log(jQuery("#attr_place_Int_tuple_tmp_9631  :selected").val());   
                  
//                let attr_value_text = jQuery("button.buttons_"+id).val().trim();
                let attr_value_text = jQuery(button).val().trim();
                    attr_value_text = attr_value_text.replace(/\s+/g,'');
                    attr_value_text = attr_value_text.replace(/\s\s+/g,' ').replace(new RegExp(";", "g"),',').replace(/\./g,',').replace(new RegExp(" ,", "g"),',').replace(new RegExp(",", "g"),', ').replace(/\s\s+/g,' ');
                    attr_value_text = attr_value_text.replace(new RegExp(" ", "g"),'.').replace(/\./g,',').replace(new RegExp(",,", "g"),', ');
                let value_id=attr_value_text.replace(new RegExp("-", "g"),'o').replace(new RegExp(" ", "g"),'_').replace(new RegExp(",", "g"),'_');//array(' ',';',',','-'),array('_','d','d','i')
    
                jQuery('.spoller_chk_tbl.spoller_'+id).prop('checked', true);
//				var existcheck = jQuery('#attr_place_Int_'+id+'_'+value_id).val();
//				if (existcheck){
//					alert(jshopAdmin.lang_place_exist);
//					return 0;
//				}
                if (value_id=="0" || value_id==""){ 
                    alert(jshopAdmin.lang_error_place);
                    return 0;
                }
                html = "<tr id='attr_place_row_"+id+"_"+value_id+"' class='Int _row '>"; 
                places = "<input type='text' name='attrib_place_name[]' value='"+attr_value_text+"' class='inputbox form-control  form-control-sm wide2'>";//attrib_place_Int_tuple
                hidden = "<input type='hidden' name='attrib_place_id[]' value='"+id+"' id='attr_place_" + id + "_" + value_id + "'>";//attrib_place_Int_id
                hidden2 = "<input type='hidden' name='attrib_place_value_id[]' value='"+value_id+"'>";//attrib_place_Int_value_id
                hidden3 = "<input type='hidden' name='attrib_place_type[]' value='Int'>";//attrib_place_Int_value_id
                html += "<td class='col-auto'>" + places + hidden + hidden2 + hidden3 + "</td>";
                html += "<td class='col-auto text-center'><input type='text' name='attrib_place_price_mod[]' value='+' class='small2 text-center' readonly _disabled></td>";//attrib_place_Int_price_mod
                html += "<td class='col-auto'><input type='text' name='attrib_place_price[]' value='0' class='inputbox form-control  form-control-sm small3 text-end'></td>";//attrib_place_Int_price
//console.log(jshopAdmin.jstriggers);
                html += jshopAdmin.jstriggers.addAttributValue2Html;
                html +=" <td class='col-auto text-center'><a class='btn btn-micro btn-sm small3 text-center' href='#' onclick='jQuery('#attr_place_row_" + id + "_" + value_id + "').remove();event.preventDefault();return false;'><i class='icon-delete'></i></a></td>";
                html += "</tr>";    
                jQuery("#list_attr_value_place_"+id).append(html);
                    jQuery.each(jshopAdmin.jstriggers.addAttributValue2Events, function(key, handler){
                    handler.call(this, id);
                });
}

var CountAttributStr = 0;
   
//Изменено Добавленно добавлен метод // НЕ доделан по сути нужно добавлять комбобокс
function addAttributValueStr(id, button){//id=attrib_id           console.log(jQuery("#attr_place_Int_tuple_tmp_9631  :selected").val());   
                
                let attr_value_name = jQuery(button).val().trim();
                let attr_value_arr = jQuery(button).data('json');                
        //console.log(attr_value_json);
                //let attr_value_arr =  JSON.parse(attr_value_json);
                
//                var sel = jQuery("<select/>");
//                sel.attr('name','attrib_place_Str_id[]');
//                sel.attr('id','attr_place_Str_'+id+"_"+value_id);
//                sel.val(id);//sel.val(id);// sel.attr('value',id);
                
                jQuery('.spoller_chk_tbl.spoller_'+id).prop('checked', true);
                CountAttributStr += 1;
//                id = CountAttributStr;
console.log('CountAttributStr: '+ id);
                //console.log(attr_value_json);
//                console.log(attr_value_arr);
                //return;
//[Вип 1] => stdClass Object
//        (
//            [value_id] => 154
//            [image] => 
//            [name] => Вип 1
//            [attr_id] => 4
//            [value_ordering] => 0
//            [key] => Вип 1
//            [IsInt] => 
//        )
                var select = document.createElement("select");
                select.id = 'attr_place_S_'+id+"_"+CountAttributStr;  //-----
                select.name = 'attrib_place_value_id[]';
                select.value = CountAttributStr;                    //-----
//                select.classList.add('inputbox');//-----
//                select.classList.add('form-control');//-----
                select.classList.add('form-select');//-----
                select.classList.add('form-select-sm');//-----
                select.classList.add('wide2');//-----
                select.classList.add('inputbox');//-----
//                select.classList.add('col-1');//-----
                
                var option = document.createElement("option");
                option.value = 0;
                option.text = jshopAdmin.textNotUse;
                option.select = 'select';
                select.appendChild(option);
                
                for(var key in attr_value_arr){
                    //sel.append("<option value='"+attr_value_arr[key]['value_id']+"'>"+attr_value_arr[key]['name']+"</option>");
                    var option = document.createElement("option");
                    option.value = attr_value_arr[key]['value_id'];
                    option.text = attr_value_arr[key]['name'];
                    select.appendChild(option);
                    //console.log(attr_value_arr[key]);
                    //console.log("<option value='"+attr_value_arr[key]['value_id']+"'>"+attr_value_arr[key]['name']+"</option>");
                    //var s = attr_value_arr[i];
                    //sel.append("<option value='foo'>foo</option>");
                }
                
                var selectHTML = select.outerHTML;
                
//                console.log(selectHTML);
                //return;
                var attr_value_text = '';
                 
                var value_id = CountAttributStr; //id;//jQuery("#attr_place_Str_id_tmp_"+id+"  :selected").val();
                //var attr_value_text = id;//jQuery("#attr_place_Str_id_tmp_"+id+"  :selected").text(); 

//                var existcheck = jQuery('#attr_place_Str_'+id+'_'+value_id).val();
//                if (existcheck){
//                    alert(jshopAdmin.lang_place_exist);
//                    return 0;
//                }       attrib_place_value_id        attrib_place_name    attrib_place_id
                if (value_id=="0" || value_id==""){
                    alert(jshopAdmin.lang_error_place);
                    return 0;
                }
                html = `<tr id='attr_place_row_S_${id}_${value_id}' class='Str _row'>`; 
                //places = "<input type='text' name='attrib_place_Int_tuple[]' value='"+attr_value_text+"' class='wide'>";
				html	+=	`<td class='col-auto'>`;
				html	+=	selectHTML;
                html	+=	`<input type='hidden' name='attrib_place_id[]' value='${id}' id='attr_place_${id}_${value_id}'>`;//attrib_place_Str_id
                html	+=	`<input type='hidden' name='attrib_place_name[]' value='0'>`;//attrib_place_Str_value_id
                html	+=	`<input type='hidden' name='attrib_place_type[]' value='Str'>`;//attrib_place_Str_value_id
                html	+=	attr_value_text + `</td>`;
                html	+=	`<td class='col-auto text-center'>
			<input type='number' name='attrib_place_price_mod[]' value='' class='small2 text-center'  placeholder='+'></td>`;//attrib_place_Str_price_mod
                html+="<td class='col-auto'><input type='text' name='attrib_place_price[]' value='0' class='inputbox form-control form-control-sm small3 text-end'></td>";//attrib_place_Str_price
                html	+=	jshopAdmin.jstriggers.addAttributValue2Html;
                html	+=	`<td class='col-auto text-center'><a class='btn btn-micro  btn-sm small3 text-center' href='#' onclick="jQuery('#attr_place_row_S_${id}_${value_id}').remove();event.preventDefault(); return false;"><i class='icon-delete'></i></a></td>`;
                html	+=	'</tr>';
                jQuery('#list_attr_value_place_' + id).append(html);
                    jQuery.each(jshopAdmin.jstriggers.addAttributValue2Events, function(key, handler){
                    handler.call(this, id);
                });
}    


document.addEventListener("DOMContentLoaded", function(){
	
	let hashElement = document.querySelector('a[href="' + location.hash + '"]');
	
	if(! hashElement || ! bootstrap)
		return;
	
	let tab = new bootstrap.Tab(hashElement);
	tab.show();
}); 
