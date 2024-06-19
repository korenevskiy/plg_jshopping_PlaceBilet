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

use \Joomla\CMS\Language\Text as JText;
defined('_JEXEC') or die();

//require __DIR__ . '/places.php';

return;


//toPrint(array_keys(get_object_vars($this)) ,'TemplatePlaceAttr',true,'message');
//toPrint( $this->attribute  ,'TemplatePlaceAttr $this->attribute',true,'message');
//toPrint((get_class_methods($this)) ,'TemplatePlaceAttr',true);
//toPrint((($this->getProperties())) ,'TemplatePlaceAttr',true);
if(empty($this->options ?? false))
	return;
?> 
------------------------------------------------------------------------------------------
<?php $param = 'class="'.$this->config->frontend_attribute_select_class_css.'" size = "'.$this->config->frontend_attribute_select_size.'" onchange="jshop.setAttrValue(\''.$this->attr_id.'\', this.value);"';?>
<?php print \JHTML::_('select.genericlist', $this->options, 'jshop_attr_id['.$this->attr_id.']', $param, 'val_id', 'value_name', $this->active);?>
<span class='prod_attr_img'><img id="prod_attr_img_<?php print $this->attr_id?>" src="<?php print $this->url_attr_img?>" alt=""></span>



<!--
$this->attr_id;
$this->options;                    
$this->config;
$this->active;
$this->url_attr_img;
$this->attribute;

$this->getProperties()
[document] => 
    [option] => 
    [baseurl] => 
    [attr_id] => 1
    [options] => Array
        (
            [0] => stdClass Object
                (
                    [val_id] => 1
                    [value_name] => 1
                    [image] => 
                    [price_mod] => 
                    [addprice] => 12
                )-->




<div class="jshop_places">
<?php 
$this->config->product_attribute_accordion;// string: jbootstrap, bootstrap, jQuery, none


?>

</div>




 <div class="jshop_places">
             
        <script> //slideToggle gototop
//        $(document).ready(function(){
//            //$("#text").css("display", "none");
//            //var ryad = $(".attributes_ryad");
//            //ryad.find(".ryad").click(function(){
//            //    ryad.find(".attributes_side").toggle();
//            //});
//            //$(".ryad").on("click", function(event) {
//            //    $("#menu .attributes_side").removeClass("selected");
//            //});
//        });
        </script> 

    
<?php  
        

$first_id_attribute = reset(array_keys($this->places_sort));
//echo "<pre>";
//var_dump($first_id_attribute);
//echo "</pre>";

        $currencies = JSFactory::getAllCurrency();
        $cur_name = $currencies[$product->currency_id]->currency_name??JText::_('JSHOP_CURRENCY');//currency_id,currency_name,currency_code,currency_code_iso,currency_value
        $cur_code = $currencies[$product->currency_id]->currency_code??JText::_('JSHOP_CUR');//currency_id,currency_name,currency_code,currency_code_iso,currency_value
    
    

$tagtitle = ['<h4 class=\'panel-title\'>','</h4>',''];

if($acc_jBS)                echo JHtml::_('bootstrap.startAccordion', 'slide-bilet', ['active' => 'slide'.$first_id_attribute, 'toggle' => FALSE]); 
if($acc_BS)                 echo "<div class='panel-group accordion' id='accordion' role='tablist' aria-multiselectable='true'>";
if($acc_jQuery || $acc_none)echo "<div id='placebilet' class=' ui-accordion ui-widget ui-helper-reset ui-accordion-icons'>";

$acc_open = $acc_class = '';

        foreach($this->places_sort as $attr_id=> $attr_arr){
            
            if(empty($acc_open) && empty($acc_class))
                {$acc_open = 'true'; $acc_class = "show ";}
            else
                {$acc_open = 'false'; $acc_class = "collapse";} 
            $attribut = $this->attributes_sort[$attr_id];
            $ttls = "<span class='ryad _btn'>$attribut->attr_name</span> <span class='descr'>$attribut->attr_description</span>";
            //$ttls =  "<span class='ryad _btn'>$attribut->attr_name <span class='descr'>$attribut->attr_description</span></span>";
            
if($acc_jBS)                echo JHtml::_('bootstrap.addSlide', 'slide-bilet', $ttls, 'slide'.$attr_id);
if($acc_BS)                 echo "<div class='panel accordion-group' data-aria-accordion><div class='panel-heading accordion-heading' role='tab' id='heading$attr_id'  data-aria-accordion-heading>
        $tagtitle[2]
        <a  class='_btn collapsed {$acc_class}d accordion-toggle panel-title' role='button' 
            data-toggle='collapse' data-parent='#accordion' href='#collapse$attr_id' aria-expanded='$acc_open' aria-controls='collapse$attr_id'>
        $ttls</a>$tagtitle[2] </div>
        <div id='collapse$attr_id' class='panel-collapse $acc_class in accordion-body collapse in' role='tabpanel' aria-labelledby='heading$attr_id' data-aria-accordion-panel>
        <div class='panel-body accordion-inner'>";
if($acc_jQuery )echo "<h3 class='ui-accordion-header ui-state-default  ui-corner-all '  data-aria-accordion-heading>$ttls</h3>";//!!!!!!!!!!!!
if($acc_jQuery || $acc_none)echo "<div class='ryad_ ui-accordion-content ui-widget-content ui-corner-bottom'  data-aria-accordion-panel>";
if(				  $acc_none)echo "<h3 class='ui-accordion-header ui-state-default  ui-corner-all '>$ttls</h3>";//!!!!!!!!!!!!
//echo "<pre>$attr_id $first_id_attribute</pre>";//JHtmlBootstrap::startAccordion __METHOD__
//echo "<pre>";
//var_dump($attr_id);
//echo "</pre>";
            //$places_sort['$attr_id']->attr_name;
                
                //var_dump($attr_arr);
//                $places_sort= array();
//                $attributes_sort= array();
//                $groups_sort= array();
   
            foreach($attr_arr as $group_id=>$group_attr){
                $group = $this->groups_sort[$group_id];
               // var_dump($group_attr);
                echo "<div class='attributes_side'>  ".(($group->group_name)?"<span class='side'>$group->group_name</span>":'')."  <div class='side_'>";
                foreach($group_attr as $add_price=>$places_attr){
                    $add_price =  (int)$add_price; //$add_price = printf('%d',$add_price);
                    $carency_marka = "<span class='carency'>$cur_name</span>";//₽ $
                    
                    $cur = $config->format_currency[$config->currency_format];
//                    toPrint($cur,'$cur');
//                    toPrint($config->format_currency,'format_currency',0);
//                    toPrint($config->currency_format,'currency_format',0);
                    
                        echo "<div class='attributes_cost $price_show'>";
                    //if($price_show && $add_price==80) echo "<span class='cost rub'>$add_price $carency_marka- </span>";
                    if($price_show) echo "<span class='cost rub'>".formatprice($add_price,NULL,0, 1)." - </span>";

                    $places=array();
                    foreach ($places_attr as $pl){
                        $place_name = intval(trim($pl->place_name));
                        if($place_name!=0 && strlen(trim($pl->place_name))<4){
                            $pl->type='int';
                            $places[$place_name] = $pl;
                        }
                        else{
                            $places[strval($pl->place_name)] = $pl;
                            $pl->type='str';
                        }
                    }
                    ksort($places);
                    
                    
                    foreach ($places as $place){
                        echo "<span class='checks $pl->type' id='block_attr_sel_$place->product_attr2_id'>";
                            echo "<div class='checkboxplace'>";
                                    $add_price =round($place->addprice);
                                    $inf= "$place->place_name ($place->attr_name $place->group_name) $add_price $cur_name";
                                    $info = strip_tags($inf);
                                    // title="36 ( 3й ряд Правая сторона ) 2500 руб" 
                                    $name = htmlspecialchars($place->place_name);
                                echo "<label class='placebutton ' title='$inf' data-name=\"$name\"  data-pa_id=\"$place->product_attr2_id\" data-price=\"$add_price\" data-cur=\"$cur_name\" " 
                                    . "data-scheme=\"{'price'=>'$place->addprice $cur_name','attr_value_id'=>$place->attr_value_id,'place_id'=>$place->id,'product_attr2_id'=>$place->product_attr2_id,'name'=>'$name'}\">";
                                    $price = $cur_name.' '.round($add_price);
                                    echo ""
                                            //. "<input type='hidden' name='jshop_place_price[$place->id]' id='jshop_place_price_$place->id' value='$add_price'>"
                                            //. "<input type='hidden' name='jshop_place_info[$place->id]' id='jshop_place_info_$place->id' value='$inf'>"
                                            //. "<input type='hidden' name='jshop_place_attr_id[$place->id]' id='jshop_attr_id_$place->id' value='$place->id'>"
                                            . "<input type='checkbox' name='jshop_place_id[$place->attr_value_id]' value='$place->id' names='jshop_attr_id[]' id='jshop_attr_id_$place->id' class='checkboxplace  '  "
                                                . "onclick=\"if (this.checked) setPlaceValue($place->attr_value_id, $place->id, $add_price, true); else setPlaceValue($place->attr_value_id, $place->id, $add_price, false); \" "
                                                . "data-tip='$place->attr_name $group->group_name $price '  data-price='$place->addprice' data-cur='$cur_name' data-av_id='$place->attr_value_id' data-pa_id='$place->product_attr2_id' "
                                                . " alt='$inf' title='$inf' checkeds>"
                                            . "<span title='$info' class='ext_price_place'>$place->place_name</span>"
                                            . "<span class='ext_price_info hide'>$price</span>"
                                            . "<span class='ext_info hide'>$inf</span>"
                                            . "<span class='ext_price_ryad hide'>$add_price</span>"
                                            . "<span class='ext_row hide'>$place->attr_name $group->group_name</span>"
                                            . "<span class='ext__ryad hide'>$place->attr_name $group->group_name - $add_price $carency_marka </span>";
                                     
                                echo "</label>";
                            echo "</div>";                                               
                        echo "</span>";
                    }
                    echo "<br/></div>";
                }
                echo "</div></div>";
            }
            

if($acc_jBS)                echo JHtml::_('bootstrap.endSlide');
if($acc_BS)                 echo "</div></div></div>";
if($acc_jQuery || $acc_none)echo "</div>";

        }
if($acc_jBS)                echo JHtml::_('bootstrap.endAccordion'); 
if($acc_BS)                 echo "</div>";
if($acc_jQuery || $acc_none)echo "</div>";
?>
    
       
        </div>