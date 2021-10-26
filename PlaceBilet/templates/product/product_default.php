<?php 
/**
* @version      4.6.0 05.11.2013
* @author       MAXXmarketing GmbH
* @package      Jshopping
* @copyright    Copyright (C) 2010 webdesigner-profi.de. All rights reserved.
* @license      GNU/GPL
*/
defined('_JEXEC') or die('Restricted access');

//$accordions = ['jbootstrap','bootstrap','jQuery','none',''];
//$accordion = $accordions[1];

if(class_exists('PlaceBiletHelper'))
    $params = PlaceBiletHelper::$params->toObject();//Registry
    
$accordion = $params->accordion??'';
$text_prod_city = $params->text_prod_city??'';
$text_prod_order = $params->text_prod_order??'';

$view_text = $params->view_text??'';
$text_listprod_city = $params->text_listprod_city??'';
$text_listprod_order = $params->text_listprod_order??'';

$config = JSFactory::getConfig();
$price_show = $config->displayprice_bilet??'margin_left';//Показывать цены сбоку с местами
//toPrint(JSFactory::getConfig()->displayprice,'displayprice');
//toPrint(JSFactory::getConfig()->displayprice_bilet,'displayprice_bilet'); 
//toPrint($price_show,'$price_show');
//toPrint(JSFactory::getConfig()->product_hide_price_null,'product_hide_price_null'); 
//toPrint($accordion,'$accordion');
//$accordion = '';
//if($this->params)
//    $accordion = $this->params->get('accordion','');


$acc_jBS = ($accordion=='jbootstrap');
$acc_BS = ($accordion=='bootstrap');
$acc_jQuery = ($accordion=='jQuery');
$acc_none = ($accordion=='none' || empty($accordion));
 
$product = $this->product;
$this->product->_display_price = FALSE;

jimport ('joomla.html.html.bootstrap');
JHtml::_('bootstrap.framework');

JHtml::_('jquery.framework'); // загружаем jquery
JHtml::_('jquery.ui'); // загружаем jquery ui

$style= JUri::base(). "/plugins/jshopping/PlaceBilet/media/bilet.css";
JHtml::_('stylesheet', $style);

$id = rand(1, 1111);

//$script= JUri::base(). "/plugins/jshopping/PlaceBilet/media/bilet.js";
//if($acc_jQuery)JHtml::_('script', "//code.jquery.com/ui/1.12.1/jquery-ui.js");
if($acc_jQuery)JHtml::_('script', JUri::base(). "/plugins/jshopping/PlaceBilet/media/bilet.js");
//return;
?>
<?php include(dirname(__FILE__)."/load.js.php");?>
<div class="jshop productfull">
<form name="product" id="form_product" method="post" action="<?php print $this->action?>" enctype="multipart/form-data" autocomplete="off">
    <h1><?php print $this->product->name?><?php if ($this->config->show_product_code){?> <span class="jshop_code_prod">(<?php print _JSHOP_EAN?>: <span id="product_code"><?php print $this->product->getEan();?></span>)</span><?php }?></h1>
    <div class="bil">
        <?php if($text_prod_city&&$view_text) { ?><div class="moskva Moscow city"><?=$text_prod_city?></div><?php }?>
        <?php if($text_prod_order&&$view_text) { ?><div class="buttons controlZak order"><?=$text_prod_order?></div><?php }?>
        <h2><?php print $this->product->name?><?php if ($this->config->show_product_code){?> <span class="jshop_code_prod">(<?php print _JSHOP_EAN?>: <span id="product_code"><?php print $this->product->getEan();?></span>)</span><?php }?></h2>
        <div class="bilet">
        

        <div class="text_desc">
            
        <div class="date product">
        
     <?php 
        
        $datetime = $td = strtotime($product->date_event);
        $dt = $product->date_event;
        ?>
        <a href="<?= $product->product_link;?>">
        <time datetime="<?= $dt?>" class="date"  title="<?= $dt ?>">
            <span class="lbl jdate"><?= JText::_('JDATE')?>:</span> <span class="day"><?= date("j", $td); ?></span><span class="month"  title="<?php echo $dt ?>"> <?= JText::_(date("F", $td))?></span><br/>
            <span class="lbl jday"><?= JText::_('JDAY')?>:</span> <span class="weekday"><?= JText::_(date("l", $td))?></span><br/>
            <span class="lbl jtime"><?= JText::_('JTIME')?>:</span> <span class="time"><?= date("H:i", $td); ?></span><br/>
        </time> </a>  
        </div>
            <input type="hidden" name="date_event"   class="hide" value="<?php echo $product->date_event ?>" />
            <input type="hidden" name="date_modify"   class="hide" value="<?php echo $product->date_modify ?>" />
        </div>
        <div class="jshop_short_description">
            <?php print $this->product->short_description; ?>
        </div>  
    </div>
    <span id='list_product_image_middle'>
			<?php print $this->_tmp_product_html_body_image?>
            
            <?php foreach($this->images as $k=>$image){?>
            <a class="lightbox" id="main_image_full_<?php print $image->image_id?>" href="<?php print $this->image_product_path?>/<?php print $image->image_full;?>" <?php if ($k!=0){?>style="display:none"<?php }?> title="<?php print htmlspecialchars($image->_title)?>">
                <img id = "main_image_<?php print $image->image_id?>" src = "<?php print $this->image_product_path?>/<?php print $image->image_name;?>" alt="<?php print htmlspecialchars($image->_title)?>" title="<?php print htmlspecialchars($image->_title)?>" />
                <div class="text_zoom">
                    <img src="<?php print $this->path_to_image?>search.png" alt="zoom" /> <?php print _JSHOP_ZOOM_IMAGE?>
                </div>
            </a>
            <?php }?>
         
            <?php if(!count($this->images)){?>
            <a class="  noimage" >
                <img id = "main_image" src = "<?php print $this->image_product_path?>/<?php print $this->noimage?>" alt = "<?php print htmlspecialchars($this->product->name)?>" />
                </a>
            <?php }?>
        
    </span>
    </div>
    
    <?php print $this->_tmp_product_html_start;?>
    <?php if ($this->config->display_button_print) print printContent();?> 
    
    <?php include(dirname(__FILE__)."/ratingandhits.php");?>
        
    
        
    <div class="jshop">
    <div>
        <div class="image_middle">
            <?php print $this->_tmp_product_html_before_image;?>
            <?php if ($product->label_id){?>
                <div class="product_label">
                    <?php if ($product->_label_image){?>
                        <img src="<?php print $product->_label_image?>" alt="<?php print htmlspecialchars($product->_label_name)?>" />
                    <?php }else{?>
                        <span class="label_name"><?php print $product->_label_name;?></span>
                    <?php }?>
                </div>
            <?php }?>
            <?php if (count($this->videos)){?>
                <?php foreach($this->videos as $k=>$video){?>
					<?php if ($video->video_code){ ?>
					<div style="display:none" class="video_full" id="hide_video_<?php print $k?>"><?php echo $video->video_code?></div>
					<?php } else { ?>
					<a style="display:none" class="video_full" id="hide_video_<?php print $k?>" href=""></a>
					<?php } ?>
                <?php } ?>
            <?php }?>
            
            
            <?php print $this->_tmp_product_html_after_image;?>
            
            <?php if ($this->config->product_show_manufacturer_logo && $this->product->manufacturer_info->manufacturer_logo!=""){?>
            <div class="manufacturer_logo">
                <a href="<?php print SEFLink('index.php?option=com_jshopping&controller=manufacturer&task=view&manufacturer_id='.$this->product->product_manufacturer_id, 2);?>">
                    <img src="<?php print $this->config->image_manufs_live_path."/".$this->product->manufacturer_info->manufacturer_logo?>" alt="<?php print htmlspecialchars($this->product->manufacturer_info->name);?>" title="<?php print htmlspecialchars($this->product->manufacturer_info->name);?>" border="0" />
                </a>
            </div>
            <?php }?>
        </div>
        <div class="jshop_img_description">
            <?php print $this->_tmp_product_html_before_image_thumb;?>
            <span id='list_product_image_thumb'>
            <?php if ( (count($this->images)>1) || (count($this->videos) && count($this->images)) ) {?>
                <?php foreach($this->images as $k=>$image){?>
                    <img class="jshop_img_thumb" src="<?php print $this->image_product_path?>/<?php print $image->image_thumb?>" alt="<?php print htmlspecialchars($image->_title)?>" title="<?php print htmlspecialchars($image->_title)?>" onclick="showImage(<?php print $image->image_id?>)" />
                <?php }?>
            <?php }?>
            </span>
            <?php print $this->_tmp_product_html_after_image_thumb;?>
            <?php if (count($this->videos)){?>
                <?php foreach($this->videos as $k=>$video){?>
					<?php if ($video->video_code) { ?>
					<a href="#" id="video_<?php print $k?>" onclick="showVideoCode(this.id);return false;"><img class="jshop_video_thumb" src="<?php print $this->video_image_preview_path."/"; if ($video->video_preview) print $video->video_preview; else print 'video.gif'?>" alt="video" /></a>
					<?php } else { ?>
                    <a href="<?php print $this->video_product_path?>/<?php print $video->video_name?>" id="video_<?php print $k?>" onclick="showVideo(this.id, '<?php print $this->config->video_product_width;?>', '<?php print $this->config->video_product_height;?>'); return false;"><img class="jshop_video_thumb" src="<?php print $this->video_image_preview_path."/"; if ($video->video_preview) print $video->video_preview; else print 'video.gif'?>" alt="video" /></a>
					<?php } ?>
                <?php } ?>
            <?php }?>
            <?php print $this->_tmp_product_html_after_video;?>
        </div>
    </div>
    </div>

   <?php  /*     SELECT * FROM #__jshopping_products_attr2 pa, #__jshopping_attr_values v
WHERE pa.attr_value_id=v.value_id AND pa.product_id=184  -- AND v.attr_id=9630 AND pa.addprice=200.000
ORDER BY `name_ru-RU` LIMIT 100; */
    ?>
    
    <?php if ($this->product->product_url!=""){?>
    <div class="prod_url">
        <a target="_blank" href="<?php print $this->product->product_url;?>"><?php print _JSHOP_READ_MORE?></a>
    </div>
    <?php }?>

    <?php if ($this->config->product_show_manufacturer && $this->product->manufacturer_info->name!=""){?>
    <div class="manufacturer_name">
        <?php print _JSHOP_MANUFACTURER?>: <span><?php print $this->product->manufacturer_info->name?></span>
    </div>
    <?php }?>
    
    
    
    
<?php  //Отображени сылок категорий на странице продукта
//Хак для отображения сообщений, нужно еще выключить скрипты.
     if(FALSE && toPrint()) 
        echo "<style>#system-message-container{opacity: 1 !important; display: block !important;}"
                  . "#system-message{    overflow: scroll;    position: fixed;    z-index: 6666;    top: 0;    bottom: 0;    left: 0;    right: 0;}"
                  . "#system-message .alert{position:static; width: auto; margin: 10px;    text-align: left;}</style>";  
        
//        $this->category_id 
//        $this->product->product_categories 
//        $this->product->category_id   
if(TRUE && $count = count($this->product->product_categories)): 
    $text = $count > 1? JText::_('JPARTS') : JText::_('JPART');
    echo "<div class='jshop_prod_categories count$count '>";
    echo "<a class='label'>$text:</a><br>";
    foreach ($this->product->product_categories as $cat_id => $category):
        //echo "<a href='/category/view/$category->category_id.html'>$category->name</a>";
        echo " <a class='catid$cat_id' href='".SEFLink("index.php?option=com_jshopping&controller=category&task=view&category_id=$category->category_id")."'>$category->name</a><br>";
    endforeach;
    echo '</div>  ';
endif;
?>
    

    
    
    
    
        <?php print $this->_tmp_product_html_before_atributes;?>

        <?php if (count($this->attributes)) : ?>
            <div class="jshop_prod_attributes jshop">
                <?php foreach($this->attributes as $attribut) : ?>
                    <?php if ($attribut->grshow){?>
                        <div>
                            <span class="attributgr_name"><?php print $attribut->groupname?></span>
                        </div> 
                    <?php }?>               
                    <div class = "row-fluid">
                        <div class="span2 attributes_title">
                            <span class="attributes_name"><?php print $attribut->attr_name?>:</span>
                            <span class="attributes_description"><?php print $attribut->attr_description;?></span>
                        </div>
                        <div class = "span10">
                            <span id='block_attr_sel_<?php print $attribut->attr_id?>'>
                                <?php print $attribut->selects?>
                            </span>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?> 

<?php //echo count($this->attributes); print $this->_tmp_product_html_after_atributes; 
    if (count($this->places_sort)){ ?>
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
        
 $tagtitle = ['<h4 class=\'panel-title\'>','</h4>',''];

if($acc_jBS)                echo JHtml::_('bootstrap.startAccordion', 'slide-bilet', ['active' => 'slide1', 'toggle' => FALSE]); 
if($acc_BS)                 echo "<div class='panel-group accordion' id='accordion' role='tablist' aria-multiselectable='true'>";
if($acc_jQuery || $acc_none)echo "<div id='placebilet' class=' ui-accordion ui-widget ui-helper-reset ui-accordion-icons'>";

$acc_open = $acc_class = '';

        $currencies = JSFactory::getAllCurrency();
        $cur_name = $currencies[$product->currency_id]->currency_name??JText::_('JSHOP_CURRENCY');//currency_id,currency_name,currency_code,currency_code_iso,currency_value
        $cur_code = $currencies[$product->currency_id]->currency_code??JText::_('JSHOP_CUR');//currency_id,currency_name,currency_code,currency_code_iso,currency_value
    
    

        foreach($this->places_sort as $attr_id=> $attr_arr){
            
            if(empty($acc_open) && empty($acc_class))
                {$acc_open = 'true'; $acc_class = "show ";}
            else
                {$acc_open = 'false'; $acc_class = "collapse";}
            
            $attribut = $this->attributes_sort[$attr_id];
            $ttls = "<span class='ryad _btn'>$attribut->attr_name</span> <span class='descr'>$attribut->attr_description</span>";
            //$ttls =  "<span class='ryad _btn'>$attribut->attr_name <span class='descr'>$attribut->attr_description</span></span>";
            
if($acc_jBS)                echo JHtml::_('bootstrap.addSlide', 'slide-bilet', $ttls, "slide$attr_id");
if($acc_BS)                 echo "<div class='panel accordion-group'><div class='panel-heading accordion-heading' role='tab' id='heading$attr_id'>
        $tagtitle[2]
        <a  class='_btn collapsed {$acc_class}d accordion-toggle panel-title' role='button' 
            data-toggle='collapse' data-parent='#accordion' href='#collapse$attr_id' aria-expanded='$acc_open' aria-controls='collapse$attr_id'>
        $ttls</a>$tagtitle[2] </div>
        <div id='collapse$attr_id' class='panel-collapse $acc_class in accordion-body collapse in' role='tabpanel' aria-labelledby='heading$attr_id'>
        <div class='panel-body accordion-inner'>";
if($acc_jQuery || $acc_none)echo "<div class='ryad_ ui-accordion-content ui-widget-content ui-corner-bottom'>";
if($acc_jQuery || $acc_none)echo "<div class='ui-accordion-header ui-state-default  ui-corner-all '>$ttls</div>";//!!!!!!!!!!!!

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
                    $carency_marka = "<span class='carency ₽ $'>$cur_name</span>";
                    
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
    <?php }?>
        
        
        
        


        
        
        
        
        
        
    <?php if (($this->product->freeattributes)){?>
    <div class="prod_free_attribs">
        <table class="jshop">
        <?php foreach($this->product->freeattributes as $freeattribut){?>
        <tr>
            <td class="name"><span class="freeattribut_name"><?php print $freeattribut->name;?></span> <?php if ($freeattribut->required){?><span>*</span><?php }?><span class="freeattribut_description"><?php print $freeattribut->description;?></span></td>
            <td class="field"><?php print $freeattribut->input_field;?></td>
        </tr>
        <?php }?>
        </table>
        <?php if ($this->product->freeattribrequire) {?>
        <div class="requiredtext">* <?php print _JSHOP_REQUIRED?></div>
        <?php }?>
    </div>
    <?php }?>

    <?php if ($this->product->_display_price){?>
    <div class="prod_price">
        <?php print _JSHOP_PRICE?>: <span id="block_price"><?php print formatprice($this->product->getPriceCalculate())?>
            <?php print $this->product->_tmp_var_price_ext;?></span>
    </div>
    <?php }?>

    <?php print $this->product->_tmp_var_bottom_price;?>


      <?php if (!$this->hide_buy){?>           
        <div class="prod_buttons buttons" style="<?php print $this->displaybuttons?>">
                      
                <input type="submit" class="button" value="<?php print _JSHOP_ADD_TO_CART?>" onclick="jQuery('#to').val('cart');" />
                <?php if ($this->enable_wishlist){?>
                    <input type="submit" class="button" value="<?php print _JSHOP_ADD_TO_WISHLIST?>" onclick="jQuery('#to').val('wishlist');" />
                <?php }?>
                <?php print $this->_tmp_product_html_buttons;?>
          
        </div>
    <?php }?>
    <div class="jshop_prod_description">
        <?php print $this->product->description; ?>
    </div>  
    <?php if ($this->product->product_is_add_price){?>
    <div class="price_prod_qty_list_head"><?php print _JSHOP_PRICE_FOR_QTY?></div>
    <table class="price_prod_qty_list">
    <?php foreach($this->product->product_add_prices as $k=>$add_price){?>
        <tr>
            <td class="qty_from" <?php if ($add_price->product_quantity_finish==0){?>colspan="3"<?php } ?>>
                <?php if ($add_price->product_quantity_finish==0) print _JSHOP_FROM?>
                <?php print $add_price->product_quantity_start?> <?php print $this->product->product_add_price_unit?>
            </td>
            <?php if ($add_price->product_quantity_finish > 0){?>
            <td class="qty_line"> - </td>
            <?php } ?>
            <?php if ($add_price->product_quantity_finish > 0){?>
            <td class="qty_to">
                <?php print $add_price->product_quantity_finish?> <?php print $this->product->product_add_price_unit?>
            </td>
            <?php } ?>
            <td class="qty_price">            
                <span id="pricelist_from_<?php print $add_price->product_quantity_start?>"><?php print formatprice($add_price->price)?><?php print $add_price->ext_price?></span> <span class="per_piece">/ <?php print $this->product->product_add_price_unit?></span>
            </td>
        </tr>
    <?php }?>
    </table>
    <?php }?>
     
    
    <?php if ($this->product->product_price_default > 0 && $this->config->product_list_show_price_default){?>
        <div class="default_price"><?php print _JSHOP_DEFAULT_PRICE?>: <span id="pricedefault"><?php print formatprice($this->product->product_price_default)?></span></div>
    <?php }?>        
    

    
    <?php if ($this->config->show_tax_in_product && $this->product->product_tax > 0){?>
        <span class="taxinfo"><?php print productTaxInfo($this->product->product_tax);?></span>
    <?php }?>
    <?php if ($this->config->show_plus_shipping_in_product){?>
        <span class="plusshippinginfo"><?php print sprintf(_JSHOP_PLUS_SHIPPING, $this->shippinginfo);?></span>
    <?php }?>
    <?php if ($this->product->delivery_time != ''){?>
        <div class="deliverytime" <?php if ($product->hide_delivery_time){?>style="display:none"<?php }?>><?php print _JSHOP_DELIVERY_TIME?>: <?php print $this->product->delivery_time?></div>
    <?php }?>
    <?php if ($this->config->product_show_weight && $this->product->product_weight > 0){?>
        <div class="productweight"><?php print _JSHOP_WEIGHT?>: <span id="block_weight"><?php print formatweight($this->product->getWeight())?></span></div>
    <?php }?>
    
    <?php if ($this->product->product_basic_price_show){?>
        <div class="prod_base_price"><?php print _JSHOP_BASIC_PRICE?>: <span id="block_basic_price"><?php print formatprice($this->product->product_basic_price_calculate)?></span> / <?php print $this->product->product_basic_price_unit_name;?></div>
    <?php }?>
    
    <?php if (is_array($this->product->extra_field)){?>
        <div class="extra_fields">
        <?php $extra_field_group = "";
        foreach($this->product->extra_field as $extra_field){
            if ($extra_field_group!=$extra_field['groupname']){ 
                $extra_field_group = $extra_field['groupname'];
            ?>
            <div class='extra_fields_group'><?php print $extra_field_group?></div>
            <?php }?>
            <div><span class="extra_fields_name"><?php print $extra_field['name'];?></span><?php if ($extra_field['description']) {?> <span class="extra_fields_description"><?php print $extra_field['description'];?></span><?php } ?>: <span class="extra_fields_value"><?php print $extra_field['value'];?></span></div>
        <?php }?>
        </div>
    <?php }?>
    
    <?php if ($this->product->vendor_info){?>
        <div class="vendorinfo">
            <?php print _JSHOP_VENDOR?>: <?php print $this->product->vendor_info->shop_name?> (<?php print $this->product->vendor_info->l_name." ".$this->product->vendor_info->f_name;?>),
            ( 
            <?php if ($this->config->product_show_vendor_detail){?><a href="<?php print $this->product->vendor_info->urlinfo?>"><?php print _JSHOP_ABOUT_VENDOR?></a>,<?php }?> 
            <a href="<?php print $this->product->vendor_info->urllistproducts?>"><?php print _JSHOP_VIEW_OTHER_VENDOR_PRODUCTS?></a> )
        </div>
    <?php }?>
    
    <?php if (!$this->config->hide_text_product_not_available){ ?>
        <div class = "not_available" id="not_available"><?php print $this->available?></div>
    <?php }?>
    
    <?php if ($this->config->product_show_qty_stock){?>
        <div class="qty_in_stock"><?php print _JSHOP_QTY_IN_STOCK?>: <span id="product_qty"><?php print sprintQtyInStock($this->product->qty_in_stock);?></span></div>
    <?php }?>
    
    <?php print $this->_tmp_product_html_before_buttons;?>

    <?php print $this->_tmp_product_html_after_buttons;?>
    
<input type="hidden" name="to" id='to' value="cart" />
<input type="hidden" name="product_id" id="product_id" value="<?php print $this->product->product_id?>" />
<input type="hidden" name="category_id" id="category_id" value="<?php print $this->category_id?>" />
</form>

<?php print $this->_tmp_product_html_before_demofiles; ?>
<div id="list_product_demofiles"><?php include(dirname(__FILE__)."/demofiles.php");?></div>
<?php
if ($this->config->product_show_button_back){?>
<div class="button_back">
<input type="button" class="button" value="<?php print _JSHOP_BACK;?>" onclick="<?php print $this->product->button_back_js_click;?>" />
</div>
<?php }?>
<?php
    print $this->_tmp_product_html_before_related;
	
	
	$templates = [];			
	$templates[] = JPATH_ROOT.'/templates/'. JFactory::getApplication()->getTemplate().'/html/com_jshopping/product';
	$templates[] = JPATH_PLUGINS.'/jshopping/PlaceBilet/templates/product';
	$templates[] = JPATH_COMPONENT.'/com_jshopping/templates/'.JSFactory::getConfig()->template.'/product';
	$templates[] = dirname(__FILE__);	
	if($file = JPath::find($templates, 'related.php'))
		include($file);
	
	
    print $this->_tmp_product_html_before_review;
	
	
	$templates = [];			
	$templates[] = JPATH_ROOT.'/templates/'. JFactory::getApplication()->getTemplate().'/html/com_jshopping/product';
	$templates[] = JPATH_PLUGINS.'/jshopping/PlaceBilet/templates/product';
	$templates[] = JPATH_COMPONENT.'/com_jshopping/templates/'.JSFactory::getConfig()->template.'/product';
	$templates[] = dirname(__FILE__);	
	if($file = JPath::find($templates, 'review.php'))
		include($file);
?>
<?php print $this->_tmp_product_html_end;?>
</div>