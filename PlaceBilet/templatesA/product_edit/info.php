<?php
/**
* @version      4.9.0 13.08.2013
* @author       MAXXmarketing GmbH
* @package      Jshopping
* @copyright    Copyright (C) 2010 webdesigner-profi.de. All rights reserved.
* @license      GNU/GPL
*/
defined('_JEXEC') or die('Restricted access');
?>
<div id="main-page" class="tab-pane">
    <style>
        .checkbox input[type="checkbox"][value="1"] {
            background-color: green;
            color: green;
        }
    </style>
    <div class="col100">
     <table class="admintable" width="90%">
     <tr>
       <td class="key"  style="width:180px;">
           <label for="date_event"><?php echo _JSHOP_DATE;?></label>
       </td>
       <td>
           <?php echo JHTML::_('behavior.calendar'); //Изменено Добавлено поле 
                $dt_DateTime= ($row->date_event)? $row->date_event: date("Y-m-d H:i:s");
           ?>
           <?php echo JHTML::_('calendar', $dt_DateTime, 'date_event', 'date_event', '%Y-%m-%d %H:%M:%S', array('class'=>'inputbox prettycheckbox ', 'size'=>'25',  'maxlength'=>'19')); ?>
       </td>
     </tr>
     <tr>
       <td class="key">
           <label for="product_event"><?php echo _JSHOP_PUBLISH;?></label>
       </td>
       <td>
         <div class="btn-group checkbox" data-toggle="buttons">
            <label class="-btn -btn-primary active">
                <input type="checkbox" style="width: 34px; height: 34px;"  class=" checkbox large style3" name="product_publish" id="product_event" value="1" <?php if ($row->product_publish) echo 'checked="checked"'?> />
                
            </label>
         </div>
       </td>
     </tr>
     <tr>
       <td class="key">
         <?php echo _JSHOP_ACCESS;?>*
       </td>
       <td>
         <?php print $this->lists['access'];?>
       </td>
     </tr>     
     <tr>
       <td class="key">
         <?php echo _JSHOP_PRODUCT_PRICE;?>*
       </td>
       <td>
           <input class="" type="text" name="product_price" id="product_price" value="<?php echo $row->product_price?>" <?php if (!$this->withouttax){?> onkeyup="updatePrice2(<?php print $jshopConfig->display_price_admin;?>)" <?php }?>  readonly="readonly" /> <?php echo $this->lists['currency'];?>
       </td>
     </tr>
     <?php if (!$this->withouttax){?>
     <tr>
       <td class="key">
         <?php if ($jshopConfig->display_price_admin==0) echo _JSHOP_PRODUCT_NETTO_PRICE; else echo _JSHOP_PRODUCT_BRUTTO_PRICE;?>
       </td>
       <td>
         <input type="text" id="product_price2"  value="<?php echo $row->product_price2;?>" onkeyup="updatePrice(<?php print $jshopConfig->display_price_admin;?>)"  readonly="readonly"  />
       </td>
     </tr>
     <?php }?>
     <tr>
       <td class="key">
         <?php echo _JSHOP_PRODUCT_ADD_PRICE;?>
       </td>
       <td>
         <input type="checkbox" name="product_is_add_price" id="product_is_add_price" value="1" <?php if ($row->product_is_add_price) echo 'checked="checked"';?>  onclick="showHideAddPrice()"  readonly="readonly" disabled />
       </td>
     </tr>
     <tr id="tr_add_price" class="fide ">
        <td class="key"><?php echo _JSHOP_PRODUCT_ADD_PRICE;?></td>
         <td>
            <table id="table_add_price" class="table table-striped">
            <thead>
                <tr>
                    <th>
                        <?php echo _JSHOP_PRODUCT_QUANTITY_START;?>    
                    </th>
                    <th>
                        <?php echo _JSHOP_PRODUCT_QUANTITY_FINISH;?>    
                    </th>
                    <th>
                        <?php echo _JSHOP_DISCOUNT;?>
                        <?php if ($jshopConfig->product_price_qty_discount==2){?>
                            (%)
                        <?php }?>
                    </th>
                    <th>
                        <?php echo _JSHOP_PRODUCT_PRICE;?>
                    </th>                    
                    <th>
                        <?php echo _JSHOP_DELETE;?>    
                    </th>
                </tr>
                </thead>                
                <?php 
                $add_prices=$row->product_add_prices;
                $count=count($add_prices);
                for ($i=0; $i < $count; $i++){
                    if ($jshopConfig->product_price_qty_discount==1){
                        $_add_price=$row->product_price - $add_prices[$i]->discount;
                    }else{
                        $_add_price=$row->product_price - ($row->product_price * $add_prices[$i]->discount / 100);
                    }
                    $_add_price = formatEPrice($_add_price);
                    ?>
                    <tr id="add_price_<?php print $i?>">
                        <td>
                            <input type="text" class="small3" name="quantity_start[]" id="quantity_start_<?php print $i?>" value="<?php echo $add_prices[$i]->product_quantity_start;?>" />    
                        </td>
                        <td>
                            <input type="text" class="small3" name="quantity_finish[]" id="quantity_finish_<?php print $i?>" value="<?php echo $add_prices[$i]->product_quantity_finish;?>" />    
                        </td>
                        <td>
                            <input type="text" class="small3" name="product_add_discount[]" id="product_add_discount_<?php print $i?>" value="<?php echo $add_prices[$i]->discount;?>" onkeyup="productAddPriceupdateValue(<?php print $i?>)" />    
                        </td>
                        <td>
                            <input type="text" class="small3" id="product_add_price_<?php print $i?>" value="<?php echo $_add_price;?>" onkeyup="productAddPriceupdateDiscount(<?php print $i?>)" />
                        </td>
                        <td align="center">
                            <a class="btn btn-micro" href="#" onclick="delete_add_price(<?php print $i?>);return false;">
                                <i class="icon-delete"></i>
                            </a>
                        </td>
                    </tr>
                    <?php
                }
                ?>                
            </table>
            <table class="table table-striped">
            <tr>
                <td><?php echo $lists['add_price_units'];?> - <?php echo _JSHOP_UNIT_MEASURE;?></td>
                <td align="right" width="100">
                    <input class="btn button" type="button" name="add_new_price" onclick="addNewPrice()" value="<?php echo _JSHOP_PRODUCT_ADD_PRICE_ADD;?>" />
                </td>
            </tr>
            </table>
            <script type="text/javascript">
            <?php 
            print "var add_price_num=$i;";
            print "var config_product_price_qty_discount=".$jshopConfig->product_price_qty_discount.";";
            ?>             
            </script>
        </td>
     </tr>
     <tr>
       <td class="key">
         <?php echo _JSHOP_OLD_PRICE;?>
       </td>
       <td>
           <input type="text" name="product_old_price" id="product_old_price" value="<?php echo $row->product_old_price?>"  readonly="readonly" disabled="disabled" />
       </td>
     </tr>
     
     <?php if ($jshopConfig->admin_show_product_bay_price) { ?>
     <tr>
       <td class="key">
         <?php echo _JSHOP_PRODUCT_BUY_PRICE;?>
       </td>
       <td>
         <input type="text" name="product_buy_price" id="product_buy_price" value="<?php echo $row->product_buy_price?>" />
       </td>
     </tr>
     <?php } ?>
     <?php if ($jshopConfig->admin_show_weight){?>
     <tr>
       <td class="key">
         <?php echo _JSHOP_PRODUCT_WEIGHT;?>
       </td>
       <td>
         <input type="text" name="product_weight" id="product_weight" value="<?php echo $row->product_weight?>"  readonly="readonly" disabled="disabled"/> <?php print sprintUnitWeight();?>
       </td>
     </tr>
	 <?php }?>
     <tr>
       <td class="key">
         <?php echo _JSHOP_EAN_PRODUCT;?>
       </td>
       <td>
         <input type="text" name="product_ean" id="product_ean" value="<?php echo $row->product_ean?>" onkeyup="updateEanForAttrib()" />
       </td>
     </tr>
     <?php if ($jshopConfig->stock){?>
     <tr>
       <td class="key">
         <?php echo _JSHOP_QUANTITY_PRODUCT;?>*
       </td>
       <td>
         <div id="block_enter_prod_qty" style="padding-bottom:2px;<?php if ($row->unlimited) print "display:none;";?>">
             <input type="text" name="product_quantity" id="product_quantity" value="<?php echo $row->product_quantity?>" <?php if ($this->product_with_attribute){?>readonly="readonly"<?php }?> />
             <?php if ($this->product_with_attribute){ echo JHTML::tooltip(_JSHOP_INFO_PLEASE_EDIT_AMOUNT_FOR_ATTRIBUTE); } ?>
         </div>
         <div>         
            <input type="checkbox" name="unlimited" value="1" onclick="ShowHideEnterProdQty(this.checked)" <?php if ($row->unlimited) print "checked";?> />  <?php print _JSHOP_UNLIMITED;?>
         </div>         
       </td>
     </tr>
     <?php }?>
     <tr>
       <td class="key"><?php echo _JSHOP_URL; ?></td>
       <td>
         <input type="text" name="product_url" id="product_url" value="<?php echo $row->product_url?>" size="80" />
       </td>
     </tr>
     
     <?php if ($jshopConfig->use_different_templates_cat_prod) { ?>
     <tr>
       <td class="key">
         <?php echo _JSHOP_TEMPLATE_PRODUCT;?>
       </td>
       <td>
         <?php echo $lists['templates'];?>
       </td>
     </tr>
     <?php } ?>
     
     <?php if (!$this->withouttax){?>
     <tr>     
       <td class="key">
         <?php echo _JSHOP_TAX;?>*
       </td>
       <td>
         <?php echo $lists['tax'];?>
       </td>
     </tr>
     <?php }?>
     <tr>
       <td class="key">
         <?php echo _JSHOP_NAME_MANUFACTURER;?>
       </td>
       <td>
         <?php echo $lists['manufacturers'];?>
       </td>
     </tr>
     
     <?php if($row->RepertoireId): ?>
     <tr>
       <td class="key">
         <span  >RepertoireId</span>
       </td>
       <td class="">
       
            
            <input type="text" name="RepertoireId" id="RepertoireId" readonly  value="<?= $row->RepertoireId?>" style=""/>
          </td>
        </tr>
       <?php endif; ?>
     
      <tr>
       <td class="key">
         <?php echo _JSHOP_CATEGORIES;?>*
       </td>
       <td>
         <?php echo $lists['categories'];?>
       </td>
     </tr>
     <?php if ($jshopConfig->admin_show_vendors && $this->display_vendor_select) { ?>
     <tr>
       <td class="key">
         <?php echo _JSHOP_VENDOR;?>
       </td>
       <td>
         <?php echo $lists['vendors'];?>
       </td>
     </tr>
     <?php }?>
     
     <?php if ($jshopConfig->admin_show_delivery_time) { ?>
     <tr>
       <td class="key">
         <?php echo _JSHOP_DELIVERY_TIME;?>
       </td>
       <td>
         <?php echo $lists['deliverytimes'];?>
       </td>
     </tr>
     <?php }?>
     
     <?php if ($jshopConfig->admin_show_product_labels) { ?>
     <tr>
       <td class="key">
         <?php echo _JSHOP_LABEL;?>
       </td>
       <td>
         <?php echo $lists['labels'];?>
       </td>
     </tr>
     <?php }?>
     
     <?php if ($jshopConfig->admin_show_product_basic_price) { ?>
     <tr>
       <td class="key"><br/><?php echo _JSHOP_BASIC_PRICE;?></td>
     </tr>
     <tr>
       <td class="key">
         <?php echo _JSHOP_WEIGHT_VOLUME_UNITS;?>
       </td>
       <td>
         <input type="text" name="weight_volume_units" value="<?php echo $row->weight_volume_units?>" />
       </td>
     </tr>
     <tr>
       <td class="key">
         <?php echo _JSHOP_UNIT_MEASURE;?>
       </td>
       <td>
         <?php echo $lists['basic_price_units'];?>
       </td>
     </tr>
     <?php }?>
     <?php if ($jshopConfig->return_policy_for_product){?>
     <tr>
       <td class="key">
         <?php echo _JSHOP_RETURN_POLICY_FOR_PRODUCT;?>
       </td>
       <td>
         <?php echo $lists['return_policy'];?>
       </td>
     </tr>
     <?php if (!$jshopConfig->no_return_all){?>  
     <tr>
       <td class="key">
         <?php echo _JSHOP_NO_RETURN;?>
       </td>
       <td>
         <input type="hidden" name="options[no_return]"  value="0" />
         <input type="checkbox" name="options[no_return]" value="1" <?php if ($row->product_options['no_return']) echo 'checked = "checked"';?> />
       </td>
     </tr>
     <?php }?>
     <?php }?>
     <?php $pkey='plugin_template_info'; if ($this->$pkey){ print $this->$pkey;}?>
   </table>
   </div>
   <div class="clr"></div>
</div>