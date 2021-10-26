<?php
/**             array_unique()
* @version      4.9.0 13.08.2013
* @author       MAXXmarketing GmbH
* @package      Jshopping
* @copyright    Copyright (C) 2010 webdesigner-profi.de. All rights reserved.
* @license      GNU/GPL
*/
defined('_JEXEC') or die('Restricted access');
?>
<style>

    .table-striped{
        display: none;
        margin-bottom: 0;
    }
    .attrib_place{
        position: relative;
    }
    .spoller_chk_tbl,
    .spoller_chk_btn{
        position: absolute;
        top: 0;
        opacity: 0;
    }
    .spoller_chk_tbl{
        right: 0;
    }
    .spoller_chk_btn{
        right: 0;
    }
    .table-striped{     /*,     .input-inline*/
        transition: 0.4s;
        -height: 0;
        display: none;
        overflow-y: hidden;
    }
    .spoller_chk_tbl:checked +.table-striped{
        transition: 0.4s;
        height: auto;
        display: table;
    }
/*    .spoller_chk_btn:checked + .input-inline{
        transition: 0.4s;
        height: auto;        
        -display: block;
    }*/
    
    
    
    .buttons_0{
        transition: 0.4s;
    }
    .buttons_1{
        height: 0px;
        transition: 0.4s;
        overflow-y: hidden;
        margin-top: 0;
    }
    .buttons_2{
        height: 0px;
        transition: 0.4s;
        overflow-y: hidden;
        margin-top: 0;
    }
    .spoller_chk_btn:checked + .table-striped{
        margin-bottom: 18px;
    }
    .spoller_chk_btn:checked + .buttons_1{
        height: 63px;
        transition: 0.4s;
        margin-top: 18px;
    }
    .spoller_chk_btn:checked + .buttons_2{
        height: 108px;
        transition: 0.4s;
        margin-top: 18px;
    }
</style>
<div id="attribs-place" class="tab-pane active">
     
<?php 
//    $admin_show_attributes = $jshopConfig->admin_show_attributes;
//    $jshopConfig->admin_show_attributes = FALSE;
    $all_place_attributes=$lists['all_place_attributes']; //Все атрибуты для мест с типом 4
// echo "<pre>count \$all_place_attributes: ".count($all_place_attributes)."<br>";
//  print_r($all_place_attributes);
//  echo "</pre>";
	
	//    $all_place_attributes = array();
//    $all_independent_attributes = array();
//    $lists_new = array(); 
//    //LISTS: images, videos, files, attribs, ind_attribs, attribs_values, ind_attribs_gr, all_attributes, all_independent_attributes, dep_attr_button_add, add_price_units, access, currency, manufacturers, categories, templates
//    
//
//    
//    foreach($lists['all_independent_attributes'] as $key => $ind_attr){
//        if($ind_attr->attr_type==4){//$ind_attr->attr_admin_type
//            $all_place_attributes[$key] = $ind_attr;
//            //$values[]=
//            //$ind_attr = null;
//            //$lists['all_independent_attributes'][$key]=0; //new stdClass ();//null;
//            //clearVectorBullets();
//            //unset(  $lists['all_independent_attributes'][$key] );
//            //unset($ind_attr);
//        }
//        else{
//            $all_independent_attributes[$key] = $ind_attr;//2
//        }
//    }
//    
//
//    
//    foreach(array_keys((array)$lists) as $key=>$item){
//        if($key!='all_independent_attributes')
//            $lists_new[$key]=$item;
//    }
//    $lists_new['all_independent_attributes']=$all_independent_attributes;
//    $lists_new['all_place_attributes']=$all_place_attributes;
//    //unset($lists);
//    //$lists = $lists_new;
//    $this->set('lists',$lists_new);
//    $lists = $lists_new;
//    unset($lists_new);
//    $lists['all_place_attributes']=$all_place_attributes;
//    
//    if(count($lists['all_independent_attributes']))
//        $jshopConfig->admin_show_attributes = FALSE;
    
//    $atr = current($lists['all_independent_attributes']);
//    echo "<pre>count : ".count($lists['all_independent_attributes'])."<br>";
//    //print_r($atr);
//    print_r($atr);
//    echo "<pre>";
    
    //unset($lists['all_independent_attributes']);
    //$lists['all_independent_attributes'][1]= new stdClass();
    //$this->set()
    //$lists['all_independent_attributes']=(array)$all_independent_attributes;//get_class_methods
    
//    echo "<pre>".gettype($lists['all_independent_attributes'])." Counts \$lists['all_independent_attributes'] <br/>1:".count($lists['all_independent_attributes'] ).'<br/>2:';    
//    echo count($lists['all_independent_attributes'] );
//    echo "<br/>3: ".count($all_independent_attributes).' Методы: '.join(',',get_class_methods($lists['all_independent_attributes'][9631])).' Count^'.count((array)($lists['all_independent_attributes'][9631]))."</pre>"; 
//    
//            echo "<pre> view:  ".'';
//           echo implode(', ',  array_keys((array)$this ));
//           //*_name, *_models, *_basePath, *_defaultModel, *_layout, *_layoutExt, *_layoutTemplate, *_path, *_template, *_output, *_escape, *_charset, *_errors, baseurl, product, lists, related_products, edit, product_with_attribute, tax_value, languages, multilang, tmpl_extra_fields, withouttax, display_vendor_select, listfreeattributes, product_attr_id, plugin_template_description_ru-RU, plugin_template_info, plugin_template_attribute, plugin_template_freeattribute, plugin_template_images, plugin_template_related, plugin_template_files, plugin_template_extrafields
//           
//        echo "</pre>"; 

 




   



//        echo "<pre> array_keys \$lists   \tCount: ".count($lists ).'<br/>';
//           echo implode(', ',  array_keys($lists ));
//        echo "</pre>"; 
//        echo "<pre>product_template  \$lists['templates'] ";
//            var_dump( $lists['templates']);
//        echo "</pre>"; 
//        echo "<pre>attribs_values  \$lists['attribs_values'] \tCount: ".count($lists['attribs_values']).'  - - Все значения всех атрибутов<br/><br/>';
//            var_dump( $lists['attribs_values'][12438]);
//        echo "</pre>"; 
//        echo "<pre>attribs  \$lists['attribs'] \tCount: ".count($lists['attribs']).'<br/><br/>';
//            var_dump( $lists['attribs'][0]);
//        echo "</pre>"; 
//        echo "<pre>  \$lists['ind_attribs'] \tCount: ".count($lists['ind_attribs']).'   - - Значения продукта<br/><br/>';
//            var_dump( $lists['ind_attribs'][0]);
//        echo "</pre>"; 
//        
        
//        $a = new ArrayObject($lists['all_independent_attributes'][9631]);
//        $a= $a->getArrayCopy(); 
//        $va = new ArrayObject($a['values']);        
//        $va=$va->getArrayCopy(); 
        
//        $a['values']='count values: '.count($a['values']);
//        echo "<pre> Count независимый Атрибутов \$lists['all_independent_attributes']  \t Count: ".count($lists['all_independent_attributes']).'  - - Все атрибуты<br/>';
//            var_dump( $a);
//            echo "<br/><br/>Values count: \t ".count($va).'   - - Все значения для этого атрибута<br/>';//
//            var_dump( $va[0]);  
//        echo "</pre>"; 
//        echo "<pre>  \$lists['all_independent_attributes'] ";
////            var_dump($lang->_('JSHOP_ADD_RANGE'));
////            echo $lang->_('JSHOP_ADD_RANGE');
//            var_dump( $lists['all_independent_attributes']);
//        echo "</pre>"; 
    
   
	 
if (count($all_place_attributes)){ //echo count($all_place_attributes);
   ?>
    <?php 
    
    
//toPrint($all_place_attributes,'$all_place_attributes',10,'message',true); // Все Атрибуты с рядами
//toPrint($lists,'$lists',10,'message',true);
    $count_x = count($all_place_attributes);
    $count_i = 0;
    
foreach($all_place_attributes as $place_attr){
    $count_i++;
    if($place_attr->attr_admin_type!=4)        continue;
    
    $attribs_values = $lists['attribs_values'];//Count: 2502
    $lists['ind_attribs'];//Count: 12 - Присвоенные переменные в атрибуте в товаре
    $lists['all_independent_attributes'] ;// 	 Count: 39  - Все Атрибуты (все ряды)
    
     
//        toPrint($attribs_values,'$attribs_values',30,'message',true);
//    if($count_x==$count_i)    toPrint($lists['ind_attribs'],'$lists[ind_attribs]',50,'message',true);
//    if($count_x==$count_i)    toPrint($lists['all_independent_attributes'],'$lists[all_independent_attributes]',30,'message',true);
        
    //foreach($lists['ind_attribs_gr'][$place_attr->attr_id] as $ind_attr_val)
    //$lists['attribs_values'][$ind_attr_val->attr_value_id]->name;
    
    // Все все места этого атрибута
    // Создание коллекций числовых и строковых мест для этого атрибута
        $values = array();//Все места этого атрибута с ключем по ID
        $values_Int = array();// Все места только с цифрой в имени этого атрибута
        $values_Str = array();// Все места только со строкой в имени этого атрибута
//echo count($place_attr->values)."__";
        
        
        foreach ($place_attr->values as $attribs_value){
//        toPrint($attribs_value,'$attribs_value',0,'message',true);

            $attribs_value->name = trim($attribs_value->name);
            $name_Int=intval($attribs_value->name);
            $name_Str=strval($name_Int);
            $attribs_value->IsInt = $name_Str == $attribs_value->name;
            $attribs_value->type = $attribs_value->IsInt?'Int':'Str';
            
            $values[$attribs_value->value_id]=$attribs_value;
            if($name_Str == $attribs_value->name){
                $attribs_value->key=$name_Int; 
                $values_Int[$name_Int]=$attribs_value;
            }
            else{
                $attribs_value->key=$attribs_value->name; 
                $values_Str[$attribs_value->name]=$attribs_value; 
            }
        }
        ksort($values_Int);
        ksort($values_Str); 
        
        
//        toPrint($values,'$values',0,'message',true);
//        toPrint($values_Int,'$values_Int',0,'message',true);
//        toPrint($values_Str,'$values_Str',0,'message',true);
        
    // Создание коллекции кортежей для числовых мест для атрибута
        $tuple= array();// массив массивов подрят мест атрибута
        
        $i = current($values_Int)->key;//key
        $carriage = 0;
        foreach ($values_Int as $item){
            if($i != $item->key)
                ++$carriage;
            $tuple[$carriage][$item->key] = $item;
            $i = $item->key + 1;
        }
        $tuples= array(); // коллекция кортежей подрят идущих мест для атрибута 
        foreach ($tuple as $tup){
            $item = new stdClass();
            $item->tuple = $tup;
            $item->count = count($tup);
            $item->separate = " - ";
            reset($tup);
            $item->first = current($tup);
            $item->last = end($tup);
            reset($tup);
            if($item->count>1)
                $item->name = ($item->first->name).($item->separate).($item->last->name);
            else
                $item->name = $item->first->name;
            $tuples[$item->name] = $item; 
        } 
        
    // Строка всех мест доступного для создания цен этого атрибута .
        $valuesStrInt = implode(', ', array_keys($tuples)); 
        $valuesStrStr = implode(', ', array_keys($values_Str));
        $valuesStr=$valuesStrInt;
        if(count($values_Int) && count($values_Str))
            $valuesStr .= ', ';
        $valuesStr .= $valuesStrStr;
        
        
        
    // Места этого атрибута для этого продукта
    // Группировка мест товара по ценам этого атрибута
        


//                            $lists['ind_attribs_gr'][$place_attr->attr_id] - фореач формы
        $values_prod_Int = array();
        $values_prod_Str = array();
        $values_prod_cost_Int = array();
        $values_prod_cost_Str = array();
        $count_prod_cost_Int=0; // колличество цифровых мест с ценами для данного атрибута 
        $count_prod_cost_Str=0; // колличество строковых мест с ценами для данного атрибута 
        
        $lists['ind_attribs'];// все места Товара
    $valueses_attr_prod = $lists['ind_attribs_gr'][$place_attr->attr_id];
        if(!isset($lists['ind_attribs_gr'][$place_attr->attr_id]))
            $valueses_attr_prod = array();
//echo count($valueses_attr_prod)."__keys:".  print_r(array_keys($lists['ind_attribs_gr']),true)."__";
//echo "<pre>";
////echo print_r($lists['ind_attribs_gr'])."__";      
//echo print_r($lists['ind_attribs'])."__";    
//echo "</pre>";
        if(count($valueses_attr_prod)){
         
        $lists['ind_attribs_gr'][$place_attr->attr_id]= array();// обнуление основного массива значений для удаления дублей мест с разными ценами.
        foreach ($valueses_attr_prod as $prod_value){
            $prod_value->attr_value = $values[$prod_value->attr_value_id];
            $prod_value->name= $prod_value->attr_value->name;
            $prod_value->IsInt=$prod_value->attr_value->IsInt;
            $lists['ind_attribs_gr'][$place_attr->attr_id][$prod_value->name]=$prod_value;
            //unset($prod_value);
        }
        $valueses_attr_prod = $lists['ind_attribs_gr'][$place_attr->attr_id];
    
        foreach ($valueses_attr_prod as $prod_value){ 
            //$prod_value->key =
            
            if($prod_value->IsInt){
                $values_prod_Int[$prod_value->name]=$prod_value;
                $count_prod_cost_Int++;
                //if(!isset($values_prod_cost_Int[$prod_value->addprice][$prod_value->name]))
                $values_prod_cost_Int[$prod_value->addprice][$prod_value->name]=$values_prod_Int[$prod_value->name];
            }
            else{
                //$values_prod_Str[$prod_value->name]=$prod_value;
                $values_prod_Str[$prod_value->name]=$prod_value;//-->
                $values_prod_cost_Str[$prod_value->addprice][$prod_value->name]=$prod_value;
                $count_prod_cost_Str++;
            }
            $lists['ind_attribs_gr'][$place_attr->attr_id][$prod_value->name]=$prod_value;
        }
        }
        
         
//                    echo "<pre> ______Data \$values_prod_cost_Int   \t \t  \$addprice: \t".$addprice."\t\t Count \$items: ".count($items).' <br/>';
//                    print_r($values_prod_cost_Int);
//                    echo "</pre>"; 
        //$count_prod_cost_Int = count($values_prod_Int);
        //$count_prod_cost_Str = count($values_prod_Str);
        ksort($values_prod_Int);
        ksort($values_prod_Str); 
        ksort($values_prod_cost_Int);
        ksort($values_prod_cost_Str);
        
        $tuple= array();// массив массивов подрят мест в продукте атрибута
        $tuple_str= array();
        $tuples_prod= array(); // коллекция кортежей подрят идущих мест для продукта атрибута
        $tuples_str_Int = array(); // коллекция строк с цифровыми местами сгрупированные по ценам для атрибута
        $tuples_str_Str = array(); // коллекция строк с строковыми местами сгрупированные по ценам для атрибута ?
        $tuples_str_Str = $values_prod_Str;
            $currencies = JSFactory::getAllCurrency();
            $cur_code = $currencies[$product->currency_id]->currency_code??JText::_('JSHOP_CUR');//currency_id,currency_name,currency_code,currency_code_iso,currency_value
            $cur_code = strtolower($cur_code);
            
            
        foreach ($values_prod_cost_Int as $addprice => $items){
            $line_Int = new stdClass();
            $line_Int->$addprice = intval($addprice);//.'руб.'
            $line_Int->attr_id = $place_attr->attr_id;
            ksort($items); 
            $carriage = 0;
            $i = current($items)->name;//key
            reset($values_prod_Int);
            $t = array();// коллекция кортежей подрят идущих мест для опредленной цены мест в атрибута для продукте.
            foreach($items as $item){
                if($i != $item->name)
                    ++$carriage;
                $tuple[$addprice][$carriage][$item->name] = $item;
                //$t[$carriage][$item->name] = $item;
                $t[$carriage][$item->name] = $item;
                $i = $item->name + 1;
            }
            
            $line_Int->count=count($t);// .= ' (Мест.'.count($t).'): ';     
            $s = array();// коллекция промежутков мест для кортежа одного
            foreach($t as $_){
                $item = new stdClass();
                $item->addprice = $addprice;
                $item->tuple = $t;
                $item->count = count($_);
                $item->countTuple = count($_);
                $item->countPlace = count($items);
                $item->separate = " - ";
                reset($_);
                $item->first = current($_);
                $item->last = end($_);
                reset($_);
                if($item->count>1)
                    $item->name = ($item->first->name).($item->separate).($item->last->name);
                else
                    $item->name = $item->first->name;
                
                $tuples_prod[] = $item;                
                $s[] = $item->name;
                
//                echo "<pre> Keys12: $addprice<br/>";
//                //print_r(array_keys($t));
//                print_r($item->count);
//                echo "</pre>";
            }
            $line_Int->places = join(', ',$s);
            $tuples_str_Int[$addprice]=$line_Int;
            $tuple_str[$addprice]= floor( $line_Int->$addprice).$cur_code." (".JText::_('JSHOP_PLACE').$line_Int->count.'): '.$line_Int->places;
         
        }
         

    // Строка всех мест доступного для создания цен этого атрибута .
        $valuesIntStr_prod = implode('; &nbsp;  | ', ($tuple_str)); // места с ценами имеющиеся уже для вывода в строку
        $valuesStrStr_prod = "";// места с ценами имеющиеся уже для вывода в строку
        $qoma = FALSE;
            foreach($values_prod_cost_Str as $addprice=>$itemsprice){
                $keysname = array_keys($itemsprice);
                if($qoma)
                    $valuesStrStr_prod .= " | ";
                $qoma = TRUE;
//        echo "<pre> \$keysname  \t Count: ".count($keysname).' <br/>';
//        var_dump($itemsprice);
//        echo "</pre>"; 
                
                $valuesStrStr_prod .= floor($addprice).$cur_code." (".join(", &nbsp; ",$keysname)."): ".' ';//JText::_(JSHOP_PLACE).count($itemsprice)
            }        // 
//        if(count($values_prod_Int) && count($values_prod_Str))
//            $valuesStr_prod .= ', ';
//        $valuesStr_prod .= implode(', ', array_keys($values_prod_Str));
        
                $first = array();
                $first[] = JHTML::_('select.option', '0',JText::_('JOPTION_DO_NOT_USE'), 'value_id','name'); //_JSHOP_SELECT
        //      $values_select = JHTML::_('select.genericlist', array_merge($first, $values_for_attribut),'value_id['.$value->attr_id.']','class = "inputbox" size = "5" multiple="multiple" id = "value_id_'.$value->attr_id.'"','value_id','name');
        //      $values_select = JHTML::_('select.genericlist', array_merge($first, $values_for_attribut),'attr_ind_id_tmp_'.$value->attr_id.'','class = "inputbox wide " ','value_id','name');
                $values_select = JHTML::_('select.genericlist', array_merge($first, $values_Str),'attrib_place_name[]','class = "inputbox wide "   id = "attr_ind_id_tmp_'.$place_attr->attr_id.'"','value_id','name');
                
        //        $all_attributes[$key]->values = $values_for_attribut;
    
    ?>
        
    <div class="attrib_place attrib_<?=  $place_attr->attr_id ?>" style="padding-top:10px;overflow:hidden;padding-bottom: 10px; border: 1px solid #0088cc; border-radius: 20px; ">
            <?php  
        //echo "<pre>Count \$values: ".count($place_attr->values)."<br/>Count \$values_Int: ".count($values_Int)."<br/>Count \$values_Str: ".count($values_Str)."</pre>";
        //echo "<pre> \$lists['ind_attribs_gr'][$place_attr->attr_id]  \t Count: ".count($lists['ind_attribs_gr'][$place_attr->attr_id]).' <br/>';
        //var_dump($lists['ind_attribs_gr'][$place_attr->attr_id][0]);
        //echo "</pre>"; 
            ?>
            <div><h4 style=" margin: 0 10px; display: inline; "><?php print $place_attr->name; if (trim($place_attr->groupname) )print " ($place_attr->groupname) "?></h4><?php print $valuesStr.' ('.JText::_('JSHOP_PLACES') .': '.(count($values_Int)+count($values_Str)).')&#160;'?>
<?= $count_prod_cost_Int.'+'.$count_prod_cost_Str ?>
                <span style="float: right; opacity: 0.5; margin-right: 10px;"><?php print $place_attr->attr_id; ?></span>
                <span style="float: right; opacity: 0.5; margin-right: 10px;"><label  class="btn spoller_lbl_tbl spoller_<?=  $place_attr->attr_id ?> btn"   for="spoller_<?=  $place_attr->attr_id ?>"> <?= JText::_('PRICES'); ?></label></span>
                
                <button  style="top: -5px;position: relative; float: right; opacity: 0.5; margin-right: 10px;" type="button" 
                    onclick = "addAttributValueInt(<?= $place_attr->attr_id; ?>, this);" value = "<?= $valuesStrInt; ?>" class="btn btn-sm  btn-sm spoller_lbl_btn " ><?= JText::_('JSHOP_ADD_PLACES'); ?>  </button>

                <?php $valuesStrStr_json = json_encode($values_Str); ?>
<!--<div><?php toPrint($values_Str,'$values_Str',0,0,TRUE)?></div> 
<div><?= $values_prod_cost_Str?></div> 
<div><?= $valuesStrStr_json ?></div> -->
                <button style="top: -5px;position: relative; float: right; opacity: 0.5; margin-right: 10px;" value='<?=($place_attr->name)?>'   type="button" 
                    onclick="addAttributValueStr(<?=$place_attr->attr_id?>,this);" data-json='<?=($valuesStrStr_json)?>' class="btn btn-sm spoller_lbl_btn " > <?= JText::_('ADD'); ?> <?= JText::_('STRING'); ?></button>
                 
                
                <?php if(count($values_Int) || count($values_Str)) { ?>
                <div style=" opacity: 0.5; border-radius:3px; border: 1px solid #00b0e8; background-color: #b9def0; margin: 0 10px; padding: 0 10px;">
                <?php   if(count($values_Int)) print JText::_('JSHOP_INT_PLACE').": $count_prod_cost_Int ---   &#160;&#160;&#160;&#160; $valuesIntStr_prod";
                        if(count($values_Int) && count($values_Str)) print "<br>";
                        if(count($values_Str)) print JText::_('JSHOP_STR_PLACE').": $count_prod_cost_Str ---   &#160;&#160;&#160;&#160; $valuesStrStr_prod"; ?></div>
                <?php } ?>
                
            </div>
       <?php if(count($values_Int) || count($values_Str)) { ?>
        <input class="spoller_chk_tbl spoller_<?=  $place_attr->attr_id ?>" <?= ($count_prod_cost_Int || $count_prod_cost_Str)?'checked="checked"':'' ?>  type="checkbox"  id="spoller_<?=  $place_attr->attr_id ?>" style=" "/>
       <table class="table table-striped" id="list_attr_value_place_<?php print $place_attr->attr_id?>" style=" -margin: 0 20px; -width: auto;">
        <thead>
        <tr class="head row">
            <th width="320"><?php print JText::_('JSHOP_PLACES')?></th>
            <th width="120"><?php print _JSHOP_PRICE_MODIFICATION?></th>
            <th width="120"><?php print _JSHOP_PRICE; ?></th>
			<?php print $this->ind_attr_td_header?>
            <th><?php print _JSHOP_DELETE?></th>
        </tr>
        </thead>
        <?php 
        //if (isset($lists['ind_attribs_gr'][$place_attr->attr_id]) && is_array($lists['ind_attribs_gr'][$place_attr->attr_id]))
        if (count($tuples_str_Int)){
        foreach($tuples_str_Int as $addprice=> $place_attr_val){ 
            $tupleId = str_replace(array('-',' ',';',',','.'),array('o','_','_','_','_'),trim($place_attr_val->places));
            ?>
        <tr id='attr_place_row_<?php print $place_attr_val->attr_id?>_<?php print $tupleId?>' class="Int row">
            <td>
                
                <input type='text' name='attrib_place_name[]'  xname='attrib_place_Int_tuple[]' value='<?php print $place_attr_val->places?>' class='wide'>
                <input type='hidden' name='attrib_place_id[]' value='<?php print $place_attr_val->attr_id?>' 
                       id='attr_place_Int_<?php print $place_attr_val->attr_id?>_<?php print $tupleId?>' >
                <input type='hidden' name="attrib_place_value_id[]" value='<?php print $tupleId?>'>
                <input type='hidden' name="attrib_place_type[]" value='Int'>
            </td>
            <td><input type='text' name='attrib_place_price_mod[]' value='+' readonly disabled class='small3'></td>
            <td><input type='text' name='attrib_place_price[]' value='<?php print floatval($addprice)?>' class='small3'></td>
			<?php print $this->ind_attr_td_row[$tupleId]?>
            <td><a href='#' onclick="jQuery('#attr_place_row_<?php print $place_attr_val->attr_id?>_<?php print $tupleId?>').remove();event.preventDefault();return false;" class="btn btn-micro"><i class="icon-delete"></i></a></td>
        </tr>
        <?php } 
        }
         
        if (count($values_prod_Str)){
        foreach($values_prod_Str  as $place_attr_val){?>
        <tr id='attr_place_row_<?php print $place_attr_val->attr_id?>_<?php print $place_attr_val->attr_value_id?>' class="Str row">
            <td>
                <?php   // $lists['attribs_values'][$ind_attr_val->attr_value_id]->name;?>
                 
                <?php 
           
                $first = array();
                $first[] = JHTML::_('select.option', '0',JText::_('JOPTION_DO_NOT_USE'), 'value_id','name');  
                $values_select = JHTML::_('select.genericlist', array_merge($first, $values_Str),'attrib_place_value_id[]','class = "inputbox wide "   id = "attr_ind_id_tmp_'.$place_attr->attr_id.'"','value_id','name',$place_attr_val->attr_value_id);
                
                echo $values_select;
                
                //  attrib_place_value_id        attrib_place_name    attrib_place_id
                ?>
                
                
                <input type='hidden' name='attrib_place_id[]' xname='attrib_place_Str_id[]' value='<?php print $place_attr_val->attr_id?>' 
                       id='attr_place_Str_<?php print $place_attr_val->attr_id?>_<?= $place_attr_val->attr_value_id?>' >
                <input type='hidden' name="attrib_place_name[]" value='<?= $place_attr_val->name?>'>
                <input type='hidden' name="attrib_place_type[]" value='Str'>
            </td>
            <td><input type='text' name='attrib_place_price_mod[]' readonly disabled value='<?php print $place_attr_val->price_mod?>' class='small3' ></td>
            <td><input type='text' name='attrib_place_price[]' value='<?= floatval($place_attr_val->addprice)?>' class='small3'></td>
			<?php print $this->ind_attr_td_row[$place_attr_val->attr_value_id]?>
            <td><a href='#' onclick="jQuery('#attr_place_row_<?= $place_attr_val->attr_id?>_<?= $place_attr_val->attr_value_id?>').remove();event.preventDefault();return false;"  class="btn btn-micro"><i class="icon-delete"></i></a></td>
        </tr>
        <?php }
        }
        ?>
        </table>
        <?php } ?>
        
        

 
        


        </div><br/>
    <?php 
    
}?>
        <style>
            input[type="text"]{
                height: inherit;
                box-sizing: border-box;
            }
        </style>
   <br/><br/>
   <?php
}   


 

unset($valueses_attr_prod);
unset($all_independent_attributes);
unset($values_select);
unset($tuples_str_Str);
unset($tuples_str_Int);
unset($tuple_str);
unset($prod_value);
unset($tuples_prod);
unset($values_prod_cost_Str);
unset($values_prod_cost_Int);
unset($values_prod_Str);
unset($values_prod_Int);

unset($valuesStr);
unset($values_Int); 
unset($values_Str); 
unset($valuesStrStr); 
unset($valuesStrInt); 
unset($valuesStrStr_prod);
unset($valuesIntStr_prod);
unset($tuples);
unset($carriage);
unset($tuple);
unset($name_Str);
unset($name_Int);
unset($attribs_value);
unset($all_place_attributes); 
unset($line_Int); 
unset($tup); 
unset($count_prod_cost_Int); 
unset($count_prod_cost_Str); 
unset($tupleId); 
unset($first); 
unset($last); 
unset($_); 
unset($tup); 
unset($items); 
unset($t); 
unset($s); 
unset($ind_attr_val); 
unset($tupleId); 
unset($a); 
unset($va); 
unset($item); 
//unset($dt_DateTime); 
unset($i); 
//unset($count);  
unset($ind_attr);  
unset($key);  
//unset($values);  
unset($attribs_values);  


//$vars = get_defined_vars();
//echo "<pre>Count get_defined_vars(): ".count($vars)."<br/>   ";
//var_dump(array_keys($vars));
//echo " </pre>";

   ?>
   <?php $pkey='plugin_template_attribute'; if ($this->$pkey){ print $this->$pkey;}?>
   <a href="index.php?option=com_jshopping&controller=attributes" target="_blank"><img src="components/com_jshopping/images/jshop_attributes_s.png" border='0' align="left" style="margin-right:5px"><?php print _JSHOP_LIST_ATTRIBUTES;?></a>
</div>


<?php
$text = function ($str){
    JText::_($str);
};

// <editor-fold defaultstate="collapsed" desc="JavaScript">

//$JSHOP_ERROR_ADD_PLACE = $text('JSHOP_ERROR_ADD_PLACE');
//$JSHOP_PLACE_EXIST = $text('JSHOP_PLACE_EXIST');
//$JSHOP_ERROR_ADD_PLACE = JText::_('JSHOP_ERROR_ADD_PLACE');
//$JSHOP_PLACE_EXIST = JText::_('JSHOP_PLACE_EXIST');


//    <script type="text/javascript">
$script = <<<SCRIPT
        
        
        
var lang_error_place="{$text('JSHOP_ERROR_ADD_PLACE')}";
var lang_place_exist="{$text('JSHOP_PLACE_EXIST')}";
         
//Изменено Добавленно добавлен метод
function addAttributValueInt(id, button){//id=attrib_id           console.log(jQuery("#attr_place_Int_tuple_tmp_9631  :selected").val());   
                  
//                let attr_value_text = jQuery("button.buttons_"+id).val().trim();
                let attr_value_text = jQuery(button).val().trim();
                    attr_value_text = attr_value_text.replace(/\s+/g,'');
                    attr_value_text = attr_value_text.replace(/\s\s+/g,' ').replace(new RegExp(";", "g"),',').replace(/\./g,',').replace(new RegExp(" ,", "g"),',').replace(new RegExp(",", "g"),', ').replace(/\s\s+/g,' ');
                    attr_value_text = attr_value_text.replace(new RegExp(" ", "g"),'.').replace(/\./g,',').replace(new RegExp(",,", "g"),', ');
                let value_id=attr_value_text.replace(new RegExp("-", "g"),'o').replace(new RegExp(" ", "g"),'_').replace(new RegExp(",", "g"),'_');//array(' ',';',',','-'),array('_','d','d','i')
    
                jQuery('.spoller_chk_tbl.spoller_'+id).prop('checked', true);
//                var existcheck = jQuery('#attr_place_Int_'+id+'_'+value_id).val();
//                if (existcheck){
//                    alert(lang_place_exist);
//                    return 0;
//                }     
                if (value_id=="0" || value_id==""){ 
                    alert(lang_error_place);
                    return 0;
                }
                html = "<tr id='attr_place_row_"+id+"_"+value_id+"' class='Int row'>"; 
                places = "<input type='text' name='attrib_place_name[]' value='"+attr_value_text+"' class='wide'>";//attrib_place_Int_tuple
                hidden = "<input type='hidden' name='attrib_place_id[]' value='"+id+"' id='attr_place_"+id+"_"+value_id+"'>";//attrib_place_Int_id
                hidden2 = "<input type='hidden' name='attrib_place_value_id[]' value='"+value_id+"'>";//attrib_place_Int_value_id
                hidden3 = "<input type='hidden' name='attrib_place_type[]' value='Int'>";//attrib_place_Int_value_id
                html+="<td>"+ places + hidden + hidden2 + hidden3 + "</td>";
                html+="<td><input type='text' name='attrib_place_price_mod[]' value='+' class='small3' readonly disabled></td>";//attrib_place_Int_price_mod
                html+="<td><input type='text' name='attrib_place_price[]' value='0' class='small3'></td>";//attrib_place_Int_price
                html+=jstriggers.addAttributValue2Html;
                html+="<td><a class='btn btn-micro' href='#' onclick=\"jQuery('#attr_place_row_"+id+"_"+value_id+"').remove();event.preventDefault();return false;\"><i class=\"icon-delete\"></i></a></td>";
                html += "</tr>";    
                jQuery("#list_attr_value_place_"+id).append(html);
                    jQuery.each(jstriggers.addAttributValue2Events, function(key, handler){
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
                
                var option = document.createElement("option");
                option.value = 0;
                option.text = '{$text('JOPTION_DO_NOT_USE')}';
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
//                    alert(lang_place_exist);
//                    return 0;
//                }       attrib_place_value_id        attrib_place_name    attrib_place_id
                if (value_id=="0" || value_id==""){
                    alert(lang_error_place);
                    return 0;
                }
                html = "<tr id='attr_place_row_S_"+id+"_"+value_id+"' class='Str row'>"; 
                //places = "<input type='text' name='attrib_place_Int_tuple[]' value='"+attr_value_text+"' class='wide'>";
                hidden = "<input type='hidden' name='attrib_place_id[]' value='"+id+"' id='attr_place_"+id+"_"+value_id+"'>";//attrib_place_Str_id
                hidden2 = "<input type='hidden' name='attrib_place_name[]' value='0'>";//attrib_place_Str_value_id
                hidden3 = "<input type='hidden' name='attrib_place_type[]' value='Str'>";//attrib_place_Int_value_id
                html+="<td><span class='name_value'>"+ selectHTML + attr_value_text+"</span>" + hidden + hidden2 + hidden3 + "</td>";
                html+="<td><input type='text' name='attrib_place_price_mod[]' value='+' class='small3' readonly disabled></td>";//attrib_place_Str_price_mod
                html+="<td><input type='text' name='attrib_place_price[]' value='0' class='small3'></td>";//attrib_place_Str_price
                html+=jstriggers.addAttributValue2Html;
                html+="<td><a class='btn btn-micro' href='#' onclick=\"jQuery('#attr_place_row_S_"+id+"_"+value_id+"').remove();event.preventDefault(); return false;\"><i class=\"icon-delete\"></i></a></td>";
                html += "</tr>";    
                jQuery("#list_attr_value_place_"+id).append(html);
                    jQuery.each(jstriggers.addAttributValue2Events, function(key, handler){
                    handler.call(this, id);
                });
}                
SCRIPT;
//    </script>
JFactory::getDocument()->addScriptDeclaration($script); // </editor-fold>


//input-inline            
//<td width="320"><input type='text' id="attr_place_Int_tuple_tmp_{$place_attr->attr_id}" name='attr_place_Int_tuple_tmp_{$place_attr->attr_id}' value='{$valuesStrInt}' class='wide' ></td>
//<td width="120"><input type="text" id="attr_place_Int_mod_tmp_{$place_attr->attr_id}" name="attr_place_Int_mod_tmp_{$place_attr->attr_id}" class=" small3" value='+' readonly disabled ></td>
//<td width="120"><input type="text" id="attr_place_Int_price_tmp_{$place_attr->attr_id}" value="0" class='small3'></td>
//			{$this->ind_attr_td_footer[$place_attr->attr_id]}
//<td><input type="button" onclick = "addAttributValueInt({$place_attr->attr_id});" value = "{$text('JSHOP_ADD_PLACES')}" class="btn" /></td>    
    

//                <select name='attrib_place_Str_id[]' >
//                    < ? php //foreach ({$values_Str} as $val_str){
//                            echo "<option>Пункт 1</option";
//                        }
//                    ? >
//                </select>
