<?php defined('_JEXEC') or die();
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

use \Joomla\CMS\Factory as JFactory;
use \Joomla\CMS\Document\HtmlDocument as JDocument;
use \Joomla\CMS\Language\Text as JText;




//if(class_exists('PlaceBiletHelper'))
//    $params = PlaceBiletHelper::$param->toObject();//Registry

if(isset($displayData ))
extract($displayData) ;
//settype($displayData, 'object');


//$param;
$count_Places;
$places_sort;
$attributes_sort;
$groups_sort;
$places;
$attributes;
$product;
$config;
 
$params->text_listprod_city;
$params->text_listprod_order;

//$config = JSFactory::getConfig();
$price_show = $config->displayprice_bilet ?? 'margin_left';//Показывать цены сбоку с местами
//toPrint(JSFactory::getConfig()->displayprice,'displayprice');
//toPrint(JSFactory::getConfig()->displayprice_bilet,'displayprice_bilet'); 
//toPrint($price_show,'$price_show');
//toPrint(JSFactory::getConfig()->product_hide_price_null,'product_hide_price_null'); 
//toPrint($accordion,'$accordion');
//$accordion = '';
//if($params)
//    $accordion = $params->get('accordion','');


//$accordions = ['jbootstrap','bootstrap','jQuery','none',''];
$acc_jBS	= ($params->accordion=='jbootstrap');
$acc_BS		= ($params->accordion=='bootstrap');
$acc_jQuery = ($params->accordion=='jQuery');
$acc_none	= ($params->accordion=='none' || empty($params->accordion));
 
//$product->_display_price = FALSE;



//jimport ('joomla.html.html.bootstrap');
//JHtml::_('bootstrap.framework');

//JHtml::_('jquery.framework'); // загружаем jquery
//JHtml::_('jquery.ui'); // загружаем jquery ui
//JHtml::_('jquery.ui', ['core', 'sortable']);

//PlaceBiletHelper::replaceJQuery();


//$id = rand(1, 1111);

//$script= JUri::root(). "/plugins/jshopping/placebilet/media/bilet.js";
//if($acc_jQuery)JHtml::_('script', "//code.jquery.com/ui/1.12.1/jquery-ui.js");

//if($acc_jQuery)JHtml::script("plugins/jshopping/placebilet/media/jquery-3.6.0.js");
//if($acc_jQuery)JHtml::script(JUri::root(). "plugins/jshopping/placebilet/media/jquery-migrate-3.3.2.js"); 
//if($acc_jQuery)JHtml::script(JUri::root(). "plugins/jshopping/placebilet/media/jquery-migrate-1.4.1.js"); 

//if($acc_jQuery)JHtml::stylesheet("plugins/jshopping/placebilet/media/jquery-ui.css");
//if($acc_jQuery)JHtml::stylesheet("plugins/jshopping/placebilet/media/jquery-ui.structure.css");
//if($acc_jQuery)JHtml::stylesheet("plugins/jshopping/placebilet/media/jquery-ui.theme.css");
//if($acc_jQuery)JHtml::script("plugins/jshopping/placebilet/media/jquery-ui.js");
//if($acc_jQuery)JHtml::script("plugins/jshopping/placebilet/media/bilet.js");


//$headData = JFactory::getApplication()->getDocument()->getHeadData();
//toPrint($headData['scripts'],'$headData[scripts]',0);





//Отображени сылок категорий на странице продукта
//Хак для отображения сообщений, нужно еще выключить скрипты.
//     if(FALSE && toPrint()) 
//        echo "<style>#system-message-container{opacity: 1 !important; display: block !important;}"
//                  . "#system-message{    overflow: scroll;    position: fixed;    z-index: 6666;    top: 0;    bottom: 0;    left: 0;    right: 0;}"
//                  . "#system-message .alert{position:static; width: auto; margin: 10px;    text-align: left;}</style>";  
        
//toPrint($product->product_categories,'$product->product_categories',true,'message',true);
//        $category_id 
//        $product->product_categories 
//        $product->category_id   
if(TRUE && $count = count($product->product_categories)): 
    $text = $count > 1? JText::_('JPARTS') : JText::_('JPART');
    echo "<div class='jshop_prod_categories count$count '>";
    echo "<a class='label'>$text:</a><br>";
    foreach ($product->product_categories as $cat_id => $category):
        //echo "<a href='/category/view/$category->category_id.html'>$category->name</a>";
        echo " <a class='catid$cat_id' href='".\JSHelper::SEFLink("index.php?option=com_jshopping&controller=category&task=view&category_id=$category->category_id")."'>$category->name</a><br>";
    endforeach;
    echo '</div>  ';
endif;





//	toPrint($params, '$params', 0, 'message', TRUE);
//	toPrint($product->event_id, '$product->event_id', 0, 'message', TRUE);
//	toPrint(array_keys((array)$product), '$product:'. get_class($product), 0, 'message', TRUE);
if($params->pushka_mode && $product->event_id){
	JHtml::script("plugins/jshopping/placebilet/media/bilet.js");

//if($acc_jQuery)JHtml::stylesheet("plugins/jshopping/placebilet/media/jquery-ui.css");
//echo "" . $params->pushka_mode; // uat,pro
	echo "
	<div class='pushka_mode form-check '> 
		<input type=checkbox id=checkPushka_$product->product_id name=place_pushka class='form-check-input btn-lg checkPushkaMode' />
		<label for=checkPushka_$product->product_id class='form-check-label'>" . JText::_('JSHOP_PUSHKA_TICKETS') . "</label>
			

	</div>"; //name=pushka_mode
}
//		<input type=checkbox id=checkPushka_1 name=pushka_mode class='form-check-input btn-lg checkPushkaMode' />
//		<input type=checkbox id=checkPushka_2 name=pushka_mode class='form-check-input btn-lg checkPushkaMode' />
//		<input type=checkbox id=checkPushka_3 name=pushka_mode class='form-check-input btn-lg checkPushkaMode' />
	
		//$config->currency_code
        $currencies = JSFactory::getAllCurrency();
        $cur_name = $currencies[$product->currency_id]->currency_name??JText::_('JSHOP_CURRENCY');//currency_id,currency_name,currency_code,currency_code_iso,currency_value
        $cur_code = $currencies[$product->currency_id]->currency_code??JText::_('JSHOP_CUR');//currency_id,currency_name,currency_code,currency_code_iso,currency_value
    
    
	
	
//$cur = $config->format_currency[$config->currency_format];
	
//echo count($this->attributes); print $this->_tmp_product_html_after_atributes; 
if ($places_sort){?>
    <div class="jshop_places" data-currency-short="<?=$cur_code?>" data-currency-name="<?=$cur_name?>" id="places_<?=$product->product_id?>">
             
<?php  
        
//        <script> //slideToggle gototop
////        $(document).ready(function(){
////            //$("#text").css("display", "none");
////            //var ryad = $(".attributes_ryad");
////            //ryad.find(".ryad").click(function(){
////            //    ryad.find(".attributes_side").toggle();
////            //});
////            //$(".ryad").on("click", function(event) {
////            //    $("#menu .attributes_side").removeClass("selected");
////            //});
////        });
//        </script> 

		$first_id_attribute = reset(array_keys($places_sort));
//echo "<pre>";
//var_dump($first_id_attribute);
//echo "</pre>";


$tagtitle = ['<h4 class=\'panel-title\'>','</h4>',''];

if($acc_jBS)                echo JHtml::_('bootstrap.startAccordion', 'slide-bilet', ['active' => 'slide'.$first_id_attribute, 'toggle' => FALSE]); 
if($acc_BS)                 echo "<div id='placebilet' class='panel-group accordion' role='tablist' aria-multiselectable='true'>";
if($acc_jQuery)				echo "<div id='placebilet' class='ui-accordion ui-widget ui-helper-reset ui-accordion-icons'>";
if($acc_none)				echo "<div id='placebilet' class='none-accordion'>";

$acc_open = $acc_class = '';

        foreach($places_sort as $attr_id=> $attr_arr){
            
            if(empty($acc_open) && empty($acc_class))
                {$acc_open = 'true'; $acc_class = "show ";}
            else
                {$acc_open = 'false'; $acc_class = "collapse";} 
            $attribut = $attributes_sort[$attr_id];
            $ttls = "<span class='name'>$attribut->attr_name</span> <span class='descr'>$attribut->attr_description</span>";
            //$ttls =  "<span class='name'>$attribut->attr_name <span class='descr'>$attribut->attr_description</span></span>";
            
if($acc_jBS)                echo JHtml::_('bootstrap.addSlide', 'slide-bilet', $ttls, 'slide'.$attr_id);
if($acc_BS)                 echo "<div class='panel accordion-group' data-aria-accordion><div class='panel-heading accordion-heading' role='tab' id='heading$attr_id'  data-aria-accordion-heading>
        $tagtitle[2]
        <a class='_btn title collapsed {$acc_class}d accordion-toggle panel-title' role='button' 
            data-toggle='collapse' data-parent='#accordion' href='#collapse$attr_id' aria-expanded='$acc_open' aria-controls='collapse$attr_id'>
        $ttls</a>$tagtitle[2] </div>
        <div id='collapse$attr_id' class='panel-collapse $acc_class in accordion-body collapse in' role='tabpanel' aria-labelledby='heading$attr_id' data-aria-accordion-panel>
        <div class='panel-body accordion-inner'>";
if($acc_jQuery )echo "<h3 class='title ui-accordion-header ui-state-default  ui-corner-all '  data-aria-accordion-heading>$ttls</h3>";//!!!!!!!!!!!!
if($acc_jQuery || $acc_none)echo "<div class='ryad ui-accordion-content ui-widget-content ui-corner-bottom'  data-aria-accordion-panel>";
if(				  $acc_none)echo "<h3 class='title ui-accordion-header ui-state-default  ui-corner-all'>$ttls</h3>";//!!!!!!!!!!!!
//echo "<pre>$attr_id $first_id_attribute</pre>";//JHtmlBootstrap::startAccordion __METHOD__
//echo "<pre>";
//var_dump($attr_id);
//echo "</pre>";
            //$places_sort['$attr_id']->attr_name;
                
                //var_dump($attr_arr);
//                $places_sort= array();
//                $attributes_sort= array();
//                $groups_sort= array();
   
            foreach($attr_arr as $group_id => $group_attr){
                $group = $groups_sort[$group_id];
               // var_dump($group_attr);
                echo "<div class='attributes_side'>  ";
					echo $group->group_name ? "<span class='side'>$group->group_name</span>" : '';
					echo "  <div class='side_ d-table'>";
						foreach($group_attr as $add_price=>$places_attr){
                    $add_price =  (int)$add_price; //$add_price = printf('%d',$add_price);
                    $carency_marka = "<span class='carency'>$cur_name</span>";//₽ $
                    
                    $cur = $config->format_currency[$config->currency_format];
//                    toPrint($cur,'$cur');
//                    toPrint($config->format_currency,'format_currency',0);
//                    toPrint($config->currency_format,'currency_format',0);
                    
					
                    echo "<div class='attributes_cost $price_show d-table-row'>";
					
                    //if($price_show && $add_price==80) echo "<span class='cost rub'>$add_price $carency_marka- </span>";
                    if($price_show) echo "<span class='cost rub d-table-cell'>".formatprice($add_price,NULL,0, 1)." - </span>";
					
					echo '<div class="d-table-cell">';

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
						
						$add_price =round($place->addprice);
						$inf= "$place->place_name ($place->attr_name $place->group_name) $add_price $cur_name";
						$info = strip_tags($inf);
						// title="36 ( 3й ряд Правая сторона ) 2500 руб" 
						$name = htmlspecialchars($place->place_name);
						$price = $cur_name.' '.round($add_price);
						
						
						//рендер количественных полей
						if($place->price_mod == '+'){
							echo "<label class='numbers' for='jshop_place_id_$place->id' title='$info'>";
							echo "<input type='button' class='PlaceMinus placebutton' data-id='jshop_place_id_$place->id' value='-' aria-label='".JText::_('JSHOP_PLACE_BILET_MINUS')."' >";
//						 name='jshop_place_id[$place->attr_value_id]' 
						echo "<input name='jshop_place_id[$place->id]' id='jshop_place_id_$place->id' class='PlaceNumber' value='0' type='number' min='0'  aria-label='".JText::_('JSHOP_PLACE_BILET_COUNT')."' "
						. "  data-price='$place->addprice' data-cur='$cur_name' data-av_id='$place->attr_value_id' data-pa_id='$place->product_attr2_id' data-tip='$place->attr_name $group->group_name $price ' data-pcs='".strip_tags(JText::_('JSHOP_PLACE_PCS'))."'>";
							echo "<input type='button' class='PlacePlus placebutton' data-id='jshop_place_id_$place->id' value='+' aria-label='".JText::_('JSHOP_PLACE_BILET_PLUS')."'>";
							echo "<span class='ext_price_place'>$place->place_name</span>";
							echo "</label>";
							continue;
						}
						
						
						echo "<label id='block_attr_sel_$place->product_attr2_id' class='checks $pl->type placebutton checkboxplace' title='$info' "
							. "data-name='$name'  data-pa_id='$place->product_attr2_id' data-price='$add_price' data-cur='$cur_name' " 
							. "data-scheme=\"{'price'=>'$place->addprice $cur_name','attr_value_id'=>$place->attr_value_id,'place_id'=>$place->id,'product_attr2_id'=>$place->product_attr2_id,'name'=>'$name'}\">";
						echo ""
//							. "<input type='hidden' name='jshop_place_price[$place->id]' id='jshop_place_price_$place->id' value='$add_price'>"
//							. "<input type='hidden' name='jshop_place_info[$place->id]' id='jshop_place_info_$place->id' value='$inf'>"
//							. "<input type='hidden' name='jshop_place_attr_id[$place->id]' id='jshop_attr_id_$place->id' value='$place->id'>"
//						 name='jshop_place_id[$place->attr_value_id]'
						. "<input type='checkbox' name='jshop_place_id[$place->id]' id='jshop_attr_id_$place->id' value='1' names='jshop_attr_id[]' class='checkboxplace  '  "
//							. "onclick=\"if (this.checked) setPlaceValue($place->attr_value_id, $place->id, $add_price, true); else setPlaceValue($place->attr_value_id, $place->id, $add_price, false); \" "
							. "data-tip='$place->attr_name $group->group_name $price '  data-price='$place->addprice' data-cur='$cur_name' data-av_id='$place->attr_value_id' data-pa_id='$place->product_attr2_id' "
							. " checkeds>"
//							. "$place->place_name"
							. "<span class='ext_price_place'>$place->place_name</span>"
//							. "<span class='ext_price_info hide'>$price</span>"
//							. "<span class='ext_info hide'>$inf</span>"
//							. "<span class='ext_price_ryad hide'>$add_price</span>"
//							. "<span class='ext_row hide'>$place->attr_name $group->group_name</span>"
//							. "<span class='ext__ryad hide'>$place->attr_name $group->group_name - $add_price $carency_marka </span>"
							. ""; 
						echo "</label>";
                            
                    }
                    
					
					echo "</div>";
					
					
					echo "</div>";
                }
					echo "</div>";
				echo "</div>";
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
    <?php 
	
	
	
	
if(true || $params->show_calculator_in_productshow){
$t = "JText";
//JSHOP_SELECTED_BILETS ="Выбрано билетов"
//JSHOP_SELECTED_PLACES ="Выбрано мест"
//JSHOP_CLEAR_FIELD_BILETS ="Очистить поле билетов"
//JSHOP_PLACES = Места
//JSHOP_NO_SELECTED = "не выбарны"
//JSHOP_ALL_PRICES = "Итого к оплате"
?>

<div class='billet-detail'> 
 <div class='price-place-calculator'> 
 <div> 
 <div class='billet-detail_input'> 
 <span class='font_detail'><?= $t::_('JSHOP_SELECTED_BILETS')?></span> 
 <span id='outputCountPlaces' class="outputCountPlaces">0</span> 
 <input alt='<?= $t::_('JSHOP_CLEAR_FIELD_BILETS')?>' title='<?= $t::_('JSHOP_CLEAR_FIELD_BILETS')?>'  aria-label='<?= $t::_('JSHOP_CLEAR_FIELD_BILETS')?>' 
	 type='button' value='X' class='button btn btn-danger btnClear' id='btnClear_<?=$product->product_id?>'> 
 </div> 
 </div> 
 <div class='places_detail'>
	<span class='places_lbl'><?= $t::_('JSHOP_PLACES')?></span>
	<span id='outputSelectFields' class='outputSelectFields'><?= $t::_('JSHOP_NO_SELECTED')?></span>
</div> 
 <div class='summ_detail'> 
	<span class=''><?= $t::_('JSHOP_ALL_PRICES')?></span>
	<span id='outputPriceAll' class='outputPriceAll'>0</span>
	<span class='cur_name'><?= $cur_name?></span>
 </div> 
 </div> 
</div>
 
<input type="submit" class="btn btn-success button btn-buy" value="<?php print JText::_('JSHOP_ADD_TO_CART')?>" onclick="jQuery('#to').val('cart');" >


<?php
}//end calculator
}//end places plugin
?>
