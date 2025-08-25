<?php
/**             array_unique()
* @version      4.9.0 13.08.2013
* @author       MAXXmarketing GmbH
* @package      Jshopping
* @copyright    Copyright (C) 2010 webdesigner-profi.de. All rights reserved.
* @license      GNU/GPL
*/

use \Joomla\CMS\HTML\HTMLHelper as JHtml;
use Joomla\CMS\Uri\Uri as JUri;
use \Joomla\CMS\Language\Text as JText;
use Joomla\Component\Jshopping\Site\Lib\JSFactory;

defined('_JEXEC') or die();


//        JHtml::stylesheet('//cdn.jsdelivr.net/gh/kenwheeler/slick@1.8.1/slick/slick-theme.css');

/* Все атрибуты для мест с типом 4 */
$lists['all_place_attributes']; 

JHtml::script(JUri::root() . 'plugins/jshopping/placebilet/media/admin.js'); 
JHtml::stylesheet(JUri::root() . 'plugins/jshopping/placebilet/media/admin.css');
//toPrint();
//JFactory::getApplication()->enqueueMessage('<pre>$this->product: '. print_r($lists, TRUE).'</pre>');

if(empty($lists['all_place_attributes']))
	return;



//toPrint();
?>
<style>
</style>
<div id="attribs-place" class="tab-pane">
     
<?php 
	 
 //echo count($all_place_attributes);
 
    
    
//toPrint($lists['all_place_attributes'],' all_place_attributes ',10,'message',true); // Все Атрибуты с рядами
//toPrint($lists,'$lists',10,'message',true);
    $count_x = count($lists['all_place_attributes']);
    $count_i = 0;
	
    $attribs_values = $lists['attribs_values'];//Count: 2502
    $lists['ind_attribs'];//Count: 12 - Присвоенные переменные в атрибуте в товаре
    $lists['all_independent_attributes'] ;// 	 Count: 39  - Все Атрибуты (все ряды)

    
foreach($lists['all_place_attributes'] as $place_attribute){
    $count_i++;
    if($place_attribute->attr_type != 4)
		continue;

	
//toPrint($place_attribute,'$place_attribute',0,'message');

     
//        toPrint($attribs_values,'$attribs_values',30,'message',true);
//    if($count_x==$count_i)    toPrint($lists['ind_attribs'],'$lists[ind_attribs]',50,'message',true);
//    if($count_x==$count_i)    toPrint($lists['all_independent_attributes'],'$lists[all_independent_attributes]',30,'message',true);
        
    //foreach($lists['ind_attribs_gr'][$place_attribute->attr_id] as $ind_attr_val)
    //$lists['attribs_values'][$ind_attr_val->attr_value_id]->name;
    
    // Все все места этого атрибута
    // Создание коллекций числовых и строковых мест для этого атрибута
        $values = array();//Все места этого атрибута с ключем по ID
        $values_Int = array();// Все места только с цифрой в имени этого атрибута
        $values_Str = array();// Все места только со строкой в имени этого атрибута
//echo count($place_attribute->values)."__";
        
//toPrint($place_attribute->values,'$place_attribute->values',0,'message');
        
        foreach ($place_attribute->values as $attribs_value){
//        toPrint($attribs_value,'$attribs_value',0,'message',true);

            $attribs_value->name = trim($attribs_value->name);
            $name_Int = intval($attribs_value->name);
            $name_Str = strval($name_Int);
            $attribs_value->IsInt = $name_Str == $attribs_value->name;
            $attribs_value->type = $attribs_value->IsInt ? 'Int' : 'Str';
            
            $values[$attribs_value->value_id] = $attribs_value;
            if($name_Str == $attribs_value->name){
                $attribs_value->key = $name_Int; 
                $values_Int[$name_Int] = $attribs_value;
            }
            else{
                $attribs_value->key=$attribs_value->name;
                $values_Str[$attribs_value->name]=$attribs_value;
            }
        }
        ksort($values_Int);
        ksort($values_Str); 
        
//toPrint($values_Int,'$values_Int',0,'message');
//toPrint($valueses_attr_prod,'$valueses_attr_prod',0,'message');
        
//        toPrint($values,'$values',0,'message',true);
//        toPrint($values_Int,'$values_Int',0,'message',true);
//        toPrint($values_Str,'$values_Str',0,'message',true);
        
    // Создание коллекции кортежей для числовых мест для атрибута
        $tuple= array();// массив массивов подрят мест атрибута
        /* Номер места сравнения для определения подрят идущих */
		$numberName = 0;
		if($values_Int)
			$numberName = current($values_Int)->key;//key
        $carriage = 0;
        foreach ($values_Int as $item){
            if($numberName != $item->key)
                ++$carriage;
            $tuple[$carriage][$item->key] = $item;
            $numberName = $item->key + 1;
        }
		
//toPrint($tuple,'$tuple',0,'message');
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
//toPrint($values_Int,'$values_Int',0,'message');
//toPrint($tuples,'$tuples',0,'message');
        
    // Строка всех мест доступного для создания цен этого атрибута .
        $valuesStrInt = implode(', ', array_keys($tuples)); 
        $valuesStrStr = implode(', ', array_keys($values_Str));
        $valuesStr=$valuesStrInt;
        if(count($values_Int) && count($values_Str))
            $valuesStr .= ', ';
        $valuesStr .= $valuesStrStr;
        
        
//toPrint($valuesStrInt,'$valuesStrInt',0,'message');
        
    // Места этого атрибута для этого продукта
    // Группировка мест товара по ценам этого атрибута
    
	

//                            $lists['ind_attribs_gr'][$place_attribute->attr_id] - фореач формы
        $values_prod_Int = array();
        $values_prod_Str = array();
        $values_prod_cost_Int = array();
        $values_prod_cost_Str = array();
        $count_prod_cost_Int=0; // колличество цифровых мест с ценами для данного атрибута 
        $count_prod_cost_Str=0; // колличество строковых мест с ценами для данного атрибута 
        
//toPrint($lists,$place_attribute->attr_id.' Все места Товара $lists',0,'message');
        $lists['ind_attribs']; /* все места Товара */
		$valueses_attr_prod = $lists['ind_attribs_gr'][$place_attribute->attr_id] ?? [];
        if(!isset($lists['ind_attribs_gr'][$place_attribute->attr_id]))
            $valueses_attr_prod = array();
//toPrint($lists,'$lists',0,'message');
//toPrint($valueses_attr_prod,'$valueses_attr_prod',0,'message');
//echo count($valueses_attr_prod)."__keys:".  print_r(array_keys($lists['ind_attribs_gr']),true)."__";
//echo "<pre>";
////echo print_r($lists['ind_attribs_gr'])."__";      
//echo print_r($lists['ind_attribs'])."__";    
//echo "</pre>";
        if(count($valueses_attr_prod)){
         
        $lists['ind_attribs_gr'][$place_attribute->attr_id]= array();// обнуление основного массива значений для удаления дублей мест с разными ценами.
        foreach ($valueses_attr_prod as $prod_value){
            $prod_value->attr_value = $values[$prod_value->attr_value_id];
            $prod_value->name= $prod_value->attr_value->name;
            $prod_value->IsInt=$prod_value->attr_value->IsInt;
            $lists['ind_attribs_gr'][$place_attribute->attr_id][$prod_value->name]=$prod_value;
            //unset($prod_value);
        }
        $valueses_attr_prod = $lists['ind_attribs_gr'][$place_attribute->attr_id];
    
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
            $lists['ind_attribs_gr'][$place_attribute->attr_id][$prod_value->name]=$prod_value;
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
//toPrint($values_prod_Int,'$values_prod_Int',0,'message');
        
        $tuple= array();// массив массивов подрят мест в продукте атрибута
        $tuple_str= array();
        $tuples_prod= array(); // коллекция кортежей подрят идущих мест для продукта атрибута
        $tuples_str_Int = array(); // коллекция строк с цифровыми местами сгрупированные по ценам для атрибута
        $tuples_str_Str = array(); // коллекция строк с строковыми местами сгрупированные по ценам для атрибута ?
        $tuples_str_Str = $values_prod_Str;
            $currencies = JSFactory::getAllCurrency();
            $cur_code = $currencies[$this->product->currency_id]->currency_code 
					?? JText::_('JSHOP_CUR');//currency_id,currency_name,currency_code,currency_code_iso,currency_value
            $cur_code = strtolower($cur_code);
            
            
        foreach ($values_prod_cost_Int as $addprice => $items){
            $line_Int = new stdClass();
            $line_Int->addprice = intval($addprice);//.'руб.' // исправил $addprice на addprice в объекте stdClass
            $line_Int->attr_id = $place_attribute->attr_id;
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
				$line_Int->price_mod = $item->price_mod;
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
            $tuple_str[$addprice]= floor( $addprice).$cur_code." (".JText::_('JSHOP_PLACE').$line_Int->count.'): '.$line_Int->places;
         
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
                $first[] = JHTML::_('select.option', '0',JText::_('JOPTION_DO_NOT_USE'), 'value_id','name'); //JSHOP_SELECT
        //      $values_select = JHTML::_('select.genericlist', array_merge($first, $values_for_attribut),'value_id['.$value->attr_id.']','class = "inputbox" size = "5" multiple="multiple" id = "value_id_'.$value->attr_id.'"','value_id','name');
        //      $values_select = JHTML::_('select.genericlist', array_merge($first, $values_for_attribut),'attr_ind_id_tmp_'.$value->attr_id.'','class = "inputbox wide " ','value_id','name');
                $values_select = JHTML::_('select.genericlist', array_merge($first, $values_Str),'attrib_place_name[]','class = "inputbox wide "   id = "attr_ind_id_tmp_'.$place_attribute->attr_id.'"','value_id','name');
                
        //        $all_attributes[$key]->values = $values_for_attribut;
    
    ?>
        
    <div class="attrib_place  attrib_<?=  $place_attribute->attr_id ?>" style="padding-top:10px;overflow:hidden;padding-bottom: 10px; border: 1px solid #0088cc; border-radius: 20px; ">
            <?php  
        //echo "<pre>Count \$values: ".count($place_attribute->values)."<br/>Count \$values_Int: ".count($values_Int)."<br/>Count \$values_Str: ".count($values_Str)."</pre>";
        //echo "<pre> \$lists['ind_attribs_gr'][$place_attribute->attr_id]  \t Count: ".count($lists['ind_attribs_gr'][$place_attribute->attr_id]).' <br/>';
        //var_dump($lists['ind_attribs_gr'][$place_attribute->attr_id][0]);
        //echo "</pre>"; 
            ?>
            <div><h4 style=" margin: 0 10px; display: inline; "><?php print $place_attribute->name; 
				if (trim($place_attribute->groupname ?? '') )
					print " ($place_attribute->groupname) "?></h4>
				<?= ' ('.JText::_('JSHOP_PLACES_TOTAL') .': '.(count($values_Int)+count($values_Str)).')&#160;' //$valuesStr.?>
				<?= ' '.JText::_('JSHOP_STR_PLC') .': '.count($values_Str) ?>
				<?= ' '.JText::_('JSHOP_INT_PLC') .': '.count($values_Int) ?>

                <span style="float: right; opacity: 0.5; margin-right: 10px;"><?php print $place_attribute->attr_id; ?></span>
                <span style="float: right; opacity: 0.5; margin-right: 10px;">
					<label  class="btn spoller_lbl_tbl spoller_<?=  $place_attribute->attr_id ?> btn"   for="spoller_<?=  $place_attribute->attr_id ?>"> 
						<?= JText::_('PRICES'); ?> ↓</label></span>
                
                <button  style="top: -5px;position: relative; float: right; opacity: 0.9; margin-right: 10px;" type="button" 
                    onclick="addAttributValueInt(<?= $place_attribute->attr_id; ?>, this);" value="<?= $valuesStrInt; ?>" 
					class="btn  btn-success btn-sm  btn-sm spoller_lbl_btn" ><?= JText::_('JSHOP_ADD_PLACES'); ?>  </button>

                <?php $valuesStrStr_json = json_encode($values_Str); ?>
<!--<div><?php // toPrint($values_Str,'$values_Str',0,0,TRUE)?></div> 
<div><?= $values_prod_cost_Str?></div> 
<div><?= $valuesStrStr_json ?></div> -->
                <button style="top: -5px;position: relative; float: right; opacity: 0.9; margin-right: 10px;" value='<?=($place_attribute->name)?>'   type="button" 
                    onclick="addAttributValueStr(<?=$place_attribute->attr_id?>,this);" data-json='<?=($valuesStrStr_json)?>' 
					class="btn  btn-success btn-sm spoller_lbl_btn " > <?= JText::_('JSHOP_ADD_PLACE'); ?></button>
                 
                
                <?php if(count($values_Int) || count($values_Str)) { ?>
                <div style=" opacity: 0.5; border-radius:3px; border: 1px solid #00b0e8; background-color: #bde2; margin: 0 10px; padding: 0 10px;font-size: 0.8rem;">
                <?php   if(count($values_Int)) print JText::_('JSHOP_INT_PLACE').": $count_prod_cost_Int   &#160;&#160;&#160; &emsp;$valuesIntStr_prod";
                        if(count($values_Int) && count($values_Str)) print "<br>";
                        if(count($values_Str)) print JText::_('JSHOP_STR_PLACE').": $count_prod_cost_Str   &#160;&#160;&#160; &emsp;$valuesStrStr_prod"; ?></div>
                <?php } ?>
                
            </div>
       <?php if(count($values_Int) || count($values_Str)) { ?>
        <input class="spoller_chk_tbl spoller_<?=  $place_attribute->attr_id ?>" <?= ($count_prod_cost_Int || $count_prod_cost_Str)?'checked="checked"':'' ?>  type="checkbox"  id="spoller_<?=  $place_attribute->attr_id ?>" style=" "/>
        <table class="_table table-striped" id="list_attr_value_place_<?php print $place_attribute->attr_id?>" style=" margin: 0 10px; -width: auto;border-spacing:10px 0px;border-collapse: separate;">
        <thead>
        <tr class="head _row">
            <th _width="320" class="col-auto"><?php print JText::_('JSHOP_PLACES')?></th>
            <th _width="120" class="col-auto"><?php print JText::_('JSHOP_TYPE')?></th>
            <th _width="120" class="col-auto"><?php print JText::_('JSHOP_PRICE'); ?></th>
			<?php print $this->ind_attr_td_header?>
            <th class="col-auto"><?php print JText::_('JSHOP_DELETE')?></th>
        </tr>
        </thead>
        <?php 
//toPrint($tuples_str_Int,'$tuples_str_Int',0,'message');
        //if (isset($lists['ind_attribs_gr'][$place_attribute->attr_id]) && is_array($lists['ind_attribs_gr'][$place_attribute->attr_id]))
        if (count($tuples_str_Int)){
        foreach($tuples_str_Int as $addprice=> $place_attr_val){ 
            $tupleId = str_replace(array('-',' ',';',',','.'),array('o','_','_','_','_'),trim($place_attr_val->places));
			
//toPrint($place_attr_val,'$place_attr_val',0,'message');
			$price_mod = '';
			$price_mod = $place_attr_val->count;
//			
			if(empty($place_attr_val->price_mod))
				$price_mod = '';
			
            ?>
        <tr id='attr_place_row_<?php print $place_attr_val->attr_id?>_<?php print $tupleId?>' class="Int _row">
            <td class="col-auto">
                <input type='text' name='attrib_place_name[]'  xname='attrib_place_Int_tuple[]' value='<?php print $place_attr_val->places?>' class=' form-control form-control-sm wide2'>
                <input type='hidden' name='attrib_place_id[]' value='<?php print $place_attr_val->attr_id?>' 
                       id='attr_place_Int_<?= $place_attr_val->attr_id?>_<?php print $tupleId?>' >
                <input type='hidden' name="attrib_place_value_id[]" value='<?php print $tupleId?>'>
                <input type='hidden' name="attrib_place_type[]" value='Int'>
            </td>
			<td class="col-auto">
	<input type='text' name='attrib_place_price_mod[]' _value='<?= $price_mod?>+' placeholder='+'  readonly  class='small2 text-center'></td>
            <td class="col-auto"><input type='text' name='attrib_place_price[]' value='<?php print floatval($addprice)?>' class='small3 text-end inputbox form-control  form-control-sm '></td>
			<?php //print $this->ind_attr_td_row[$tupleId]?>
            <td class="col-auto text-center"><a  class='small3 text-center' href='#' onclick="jQuery('#attr_place_row_<?php print $place_attr_val->attr_id?>_<?php print $tupleId?>').remove();event.preventDefault();return false;" class="btn btn-micro btn-sm"><i class="icon-delete"></i></a></td>
        </tr>
        <?php } 
        }
         
        if (count($values_prod_Str)){
        foreach($values_prod_Str  as $place_attr_val){

			$price_mod = $place_attr_val->count;
			
			if(empty($place_attr_val->price_mod))
				$price_mod = '';
			
			
//$place_attr_val->count;
			?>
        <tr id='attr_place_row_<?php print $place_attr_val->attr_id?>_<?php print $place_attr_val->attr_value_id?>' class="Str _row">
            <td class="col-auto">
                <?php   // $lists['attribs_values'][$ind_attr_val->attr_value_id]->name;?>
                 
                <?php 
           
                $first = array();
                $first[] = JHTML::_('select.option', '0',JText::_('JOPTION_DO_NOT_USE'), 'value_id','name');  
                $values_select = JHTML::_('select.genericlist', array_merge($first, $values_Str),'attrib_place_value_id[]',' class="inputbox wide2 form-select  form-select-sm "   id="attr_ind_id_tmp_'.$place_attribute->attr_id.'"','value_id','name',$place_attr_val->attr_value_id);
                
                echo $values_select;
                
                //  attrib_place_value_id        attrib_place_name    attrib_place_id
                ?>
                
                
                <input type='hidden' name='attrib_place_id[]' xname='attrib_place_Str_id[]' value='<?php print $place_attr_val->attr_id?>' 
                       id='attr_place_Str_<?php print $place_attr_val->attr_id?>_<?= $place_attr_val->attr_value_id?>' >
                <input type='hidden' name="attrib_place_name[]" value='<?= $place_attr_val->name?>'>
                <input type='hidden' name="attrib_place_type[]" value='Str'>
            </td>
            <td class="col-auto">
<input  type='number' name='attrib_place_price_mod[]' value='<?= $price_mod?>' placeholder='+' class='small2 text-center' ></td>
            <td class="col-auto"><input type='text' name='attrib_place_price[]' value='<?= floatval($place_attr_val->addprice)?>' class='small3 text-end  inputbox form-control  form-control-sm '></td>
			<?php //print $this->ind_attr_td_row[$place_attr_val->attr_value_id]?>
            <td class="col-auto text-center"><a href='#' class='small3 text-center'  onclick="jQuery('#attr_place_row_<?= $place_attr_val->attr_id?>_<?= $place_attr_val->attr_value_id?>').remove();event.preventDefault();return false;"  class="btn btn-micro btn-sm"><i class="icon-delete"></i></a></td>
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
   <a href="index.php?option=com_jshopping&controller=attributes" target="_blank"><img src="components/com_jshopping/images/jshop_attributes_s.png" border='0' align="left" style="margin-right:5px"><?php print JText::_('JSHOP_LIST_ATTRIBUTES');?></a>
</div>


<?php
//$text = function ($str){
//    JText::_($str);
//};

// <editor-fold defaultstate="collapsed" desc="JavaScript">

//$JSHOP_ERROR_ADD_PLACE = $text('JSHOP_ERROR_ADD_PLACE');
//$JSHOP_ERROR_ADD_PLACE = JText::_('JSHOP_ERROR_ADD_PLACE');
//$JSHOP_PLACE_EXIST = $text('JSHOP_PLACE_EXIST');
//$JSHOP_PLACE_EXIST = JText::_('JSHOP_PLACE_EXIST');


//    <script type="text/javascript">
$JOPTION_DO_NOT_USE = JText::_('JOPTION_DO_NOT_USE');
$JSHOP_ERROR_ADD_PLACE = JText::_('JSHOP_ERROR_ADD_PLACE');
$JSHOP_PLACE_EXIST = JText::_('JSHOP_PLACE_EXIST');

$script = <<<SCRIPT
jshopAdmin.textNotUse="$JOPTION_DO_NOT_USE";
jshopAdmin.lang_error_place="$JSHOP_ERROR_ADD_PLACE";
jshopAdmin.lang_place_exist="$JSHOP_PLACE_EXIST";
SCRIPT;
//    </script>
JFactory::getDocument()->addScriptDeclaration($script); // </editor-fold>


//input-inline            
//<td width="320"><input type='text' id="attr_place_Int_tuple_tmp_{$place_attribute->attr_id}" name='attr_place_Int_tuple_tmp_{$place_attribute->attr_id}' value='{$valuesStrInt}' class='wide' ></td>
//<td width="120"><input type="text" id="attr_place_Int_mod_tmp_{$place_attribute->attr_id}" name="attr_place_Int_mod_tmp_{$place_attribute->attr_id}" class=" small3" value='+' readonly disabled ></td>
//<td width="120"><input type="text" id="attr_place_Int_price_tmp_{$place_attribute->attr_id}" value="0" class='small3'></td>
//			{$this->ind_attr_td_footer[$place_attribute->attr_id]}
//<td><input type="button" onclick = "addAttributValueInt({$place_attribute->attr_id});" value = "{$text('JSHOP_ADD_PLACES')}" class="btn" /></td>    
    

//                <select name='attrib_place_Str_id[]' >
//                    < ? php //foreach ({$values_Str} as $val_str){
//                            echo "<option>Пункт 1</option";
//                        }
//                    ? >
//                </select>
return; 
?>
<template id="templateRowInt">
<tr id='attr_place_row_"+id+"_"+value_id+"' class='Int _row '>
	<td class='col-auto'>
		<input type='text' name='attrib_place_name[]' value='"+attr_value_text+"' class='inputbox form-control  form-control-sm wide2'>
		<input type='hidden' name='attrib_place_id[]' value='"+id+"' id='attr_place_" + id + "_" + value_id + "'>
		<input type='hidden' name='attrib_place_value_id[]' value='"+value_id+"'>
		<input type='hidden' name='attrib_place_type[]' value='Int'>
</td>
<td class='col-auto text-center'><input type='text' name='attrib_place_price_mod[]' value='+' class='small2 text-center' readonly disabled></td>
<td class='col-auto'><input type='text' name='attrib_place_price[]' value='0' class='inputbox form-control  form-control-sm small3 text-end'></td>
//console.log(jshopAdmin.jstriggers);
html += jshopAdmin.jstriggers.addAttributValue2Html;
<td class='col-auto text-center'>
	<a class='btn btn-micro btn-sm small3 text-center' href='#' 
				onclick="jQuery('#attr_place_row_" + id + "_" + value_id + "').remove();event.preventDefault();return false;">
		<i class="icon-delete"></i></a>
</td>";
</tr>
</template>

<template id="templateRowStr">
<tr id='attr_place_row_S_"+id+"_"+value_id+"' class='Str _row'>
<td class='col-auto'>
	<input type='text' name='attrib_place_Int_tuple[]' value='"+attr_value_text+"' class='wide'>
	<input type='hidden' name='attrib_place_id[]' value='"+id+"' id='attr_place_"+id+"_"+value_id+"'>
	<input type='hidden' name='attrib_place_name[]' value='0'>
	<input type='hidden' name='attrib_place_type[]' value='Str'>
                selectHTML + attr_value_text+"" + hidden + hidden2 + hidden3 + "
</td>";
<td class='col-auto text-center'><input type='text' name='attrib_place_price_mod[]' value='+' class='small2 text-center' readonly disabled></td>
<td class='col-auto'><input type='text' name='attrib_place_price[]' value='0' class='inputbox form-control  form-control-sm small3 text-end'></td>
                html+=jshopAdmin.jstriggers.addAttributValue2Html;
<td class='col-auto text-center'>
	<a class='btn btn-micro  btn-sm small3 text-center' href='#' 
	   onclick="jQuery('#attr_place_row_S_"+id+"_"+value_id+"').remove();event.preventDefault(); return false;"><i class="icon-delete"></i>
	</a>
</td>
</tr>
</template>