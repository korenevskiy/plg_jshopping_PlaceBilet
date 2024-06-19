<?php
/**
* @version      5.0.0 15.09.2018
* @author       MAXXmarketing GmbH
* @package      Jshopping
* @copyright    Copyright (C) 2010 webdesigner-profi.de. All rights reserved.
* @license      GNU/GPL
*/

use \Joomla\CMS\Factory as JFactory;
use \Joomla\CMS\Date\Date as JDate;
use \Joomla\CMS\Language\Text as JText;
use \Joomla\CMS\Form\FormHelper as JFormHelper;
use \Joomla\CMS\HTML\HTMLHelper as JHtml;

defined('_JEXEC') or die();
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
           <label for="date_event"><?php echo JText::_('JSHOP_DATE_EVENT');?></label>
       </td>
       <td>
           <?php 
//toPrint(null,'',0,'',true);
			$timezone = 'GMT';
			$timezone = 'UTC';
			$timezone = JFactory::getApplication()->getConfig()->get('offset','UTC');
			$timezone = JFactory::getUser()->getParam('timezone',$timezone);
//			$zone = new \DateTimeZone( $timezone );
			$date_event = $row->date_event ?: 'now';
            $dt_DateTime= JDate::getInstance($date_event, $timezone ); 
			
			
            $dt_DateTime	= isset($row->date_event) &&  $row->date_event && $row->date_event != '0000-00-00 00:00:00' ? 
					JDate::getInstance($row->date_event, $timezone ) : JDate::getInstance('now', $timezone)->setTime(0, 0); 
			
//            $dt_DateTime= ($row->date_event)? JDate::getInstance($row->date_event) : JDate::getInstance();//date("Y-m-d H:i:s"); 
//		<field
//			name="created"
//			type="calendar"
//			label="COM_BANNERS_FIELD_CREATED_LABEL"
//			translateformat="true"
//			showtime="true"
//			filter="user_utc"          format="%Y-%m-%d"
//		/>
//			$formateDate =  $row->date_event != '0000-00-00 00:00:00' ? $dt_DateTime->toSql(true ) : '';
//			$formateDate = $dt_DateTime->toSql(true );
//			echo $formateDate;
//		/*     https://docs.joomla.org/Calendar_form_field_type
//			$field = new Joomla\CMS\Form\Field\CalendarField(); */
//		   	$field = JFormHelper::loadFieldType('calendar', true);  //Изменено Добавлено поле 
//			$field->setup(simplexml_load_string('<field  name="date_event" type="calendar" label="JSHOP_DATE"
//				filltable="true" minyear="-3" maxyear="5"  timeformat="24" default="NOW"
//				showtime="true" todaybutton="true" weeknumbers="true"  singleheader="true"  
//				XfilterFormat="Y-m-d H:i:00" filter="USER_UTC" translateformat="true" />'), // format=\"Y-m-d H:i:s\" "%Y-%m-%d %H:%M:%S" //filter="SERVER_UTC" or "USER_UTC"
//				 $formateDate);  //Изменено Добавлено поле // JDate::getInstance()
//			$field->format = '%Y-%m-%d %H:%M:%S';//'%Y-%m-%d %H:%M:%S'
//			$field->filterFormat = 'Y-m-d H:i:00'; // Y-m-d H:i:s
//			$field->setDatabase( JFactory::getDbo());//DatabaseInterface
////			$field->showtime = true;
////			$field->default = $dt_DateTime->toSql(false );//date('Y-m-d H:i:00', time());
////			$field->setValue($dt_DateTime);
//		    echo $field->input;
			
//echo JHTML::_('behavior.calendar'); //Изменено Добавлено поле 
			
			echo JHtml::calendar( $dt_DateTime, 'date_event', 'date_event', '%Y-%m-%d %H:%M:%S',
					['class'=>'inputbox prettycheckbox', 'size'=>'25',  'maxlength'=>'19', 'required'=>true,'showTime'=>true]);
			?>
       </td>
     </tr>
	 
	 
	 
	 
     <tr>
       <td class="key"  style="width:180px;">
           <label for="date_tickets"><?php echo JText::_('JSHOP_DATE_TICKETS_START');?></label>
       </td>
       <td>
           <?php 
//toPrint(null,'',0,'',true);
//			$zone = new \DateTimeZone( $timezone );
//			$date_tickets = $row->date_tickets ?: '';
//			echo $row->date_tickets."<br>";
            $dtTickets	= isset($row->date_tickets) &&  $row->date_tickets && $row->date_tickets != '0000-00-00 00:00:00' ? 
					JDate::getInstance($row->date_tickets, $timezone ) : ''; 

					
			
//			$formateDate =  $row->date_tickets && $row->date_tickets != '0000-00-00 00:00:00' ? $dtTickets->toSql(true ) : '';
//			$formateDate = $dtTickets->toSql(true );
//			echo $formateDate;
 
//			echo $dtTickets."<br>";
//echo JHTML::_('behavior.calendar'); //Изменено Добавлено поле 
			
			// '%Y-%m-%d'
			echo JHtml::calendar(    $dtTickets, 'date_tickets', 'date_tickets', '%Y-%m-%d %H:%M:%S', 
					['class'=>'inputbox prettycheckbox', 'size'=>'25',  'maxlength'=>'19', 'required'=>false,'showTime'=>true]);
			// hint, todaybutton, showtime, timeformat, helperPath, direction, dataAttribute, dataAttributes, calendar
			// return LayoutHelper::render('joomla.form.field.calendar', $data, null, null);
			
//			echo JHTML::_('calendar', $dtTickets, 'date_tickets', 'date_tickets', '%Y-%m-%d %H:%M:%S', 
//					['class'=>'inputbox prettycheckbox', 'size'=>'25',  'maxlength'=>'19', 'required'=>false,'showTime'=>true]); 
			?>
       </td>
     </tr>
	 
	 
     
    <tr>
       <td class="key" style="width:180px;">
         <label for="product_publish">
         <?php echo JText::_('JSHOP_PUBLISH')?>
         </label>
       </td>
       <td>
         <div class="btn-group checkbox" data-toggle="buttons">
         <label class="-btn -btn-primary active">
         <input type="checkbox" name="product_publish" id="product_publish" value="1" <?php if ($row->product_publish) echo 'checked="checked"'?> style="width: 34px; height: 34px;"  class=" checkbox large style3" />       
         </label>
         </div>
       </td>
    </tr>
	
	
<?php if($jshopConfig->pushka_mode ?? false):?>
    <tr>
       <td class="key" style="width:180px;">
         <label for="product_publish">
         <?php echo JText::_('JSHOP_PUSHKA_EVENT_ID')?>
         </label>
       </td>
       <td>
         <div class="btn-group text" data-toggle="buttons">
         <label class="-btn -btn-primary  ">
         <input type="text" name="event_id" id="event_id" value="<?php echo $row->event_id ?? 0 ?>"    class="form-control checkbox large style3" />       
         </label>
         </div>
       </td>
    </tr>
<?php endif; ?>	
	
	
    <tr>
       <td class="key">
         <?php echo JText::_('JSHOP_ACCESS')?>*
       </td>
       <td>
         <?php print $this->lists['access'];?>
       </td>
    </tr>     
    <tr>
       <td class="key">
         <?php echo JText::_('JSHOP_PRODUCT_PRICE')?>*
       </td>
       <td test>
       	 <input type="text" name="product_price" class="form-control" id="product_price" value="<?php echo $row->product_price?>" <?php if (!$this->withouttax){?> onkeyup="jshopAdmin.updatePrice2(<?php print $jshopConfig->display_price_admin;?>)" <?php }?>  readonly="readonly" /> <?php echo $this->lists['currency'];?>
       </td>
    </tr>
    <?php if (!$this->withouttax){?>
    <tr>
       <td class="key">
         <?php if ($jshopConfig->display_price_admin==0) echo JText::_('JSHOP_PRODUCT_NETTO_PRICE'); else echo JText::_('JSHOP_PRODUCT_BRUTTO_PRICE');?>
       </td>
       <td test>
         <input type="text" class="form-control" id="product_price2" value="<?php echo $row->product_price2;?>" onkeyup="jshopAdmin.updatePrice(<?php print $jshopConfig->display_price_admin;?>)"  readonly="readonly"  />
       </td>
    </tr>
    <?php }?>
    <?php $pkey='plugin_template_info_price'; if (isset($this->$pkey)){ print $this->$pkey;}?>
    <?php if ($jshopConfig->disable_admin['product_price_per_consignment'] == 0){?>
    <tr style="position: absolute; bottom: -50vh">
       <td class="key">
         <?php echo JText::_('JSHOP_PRODUCT_ADD_PRICE')?>
       </td>
       <td test>
         <input type="checkbox" name="product_is_add_price" id="product_is_add_price" value="1" <?php if ($row->product_is_add_price && false) echo 'checked="checked"';?>  onclick="jshopAdmin.showHideAddPrice()"  readonly="readonly" disabled />
       </td>
    </tr>
    <tr id="tr_add_price" class="fide ">
        <td test class="key"><?php echo JText::_('JSHOP_PRODUCT_ADD_PRICE')?></td>
         <td>
            <table style="margin-bottom:0" id="table_add_price" class="table table-striped">
            <thead>
                <tr>
                    <th>
                        <?php echo JText::_('JSHOP_PRODUCT_QUANTITY_START')?>    
                    </th>
                    <th>
                        <?php echo JText::_('JSHOP_PRODUCT_QUANTITY_FINISH')?>    
                    </th>
                    <th>
                        <?php echo JText::_('JSHOP_DISCOUNT')?>
                        <?php if ($jshopConfig->product_price_qty_discount==2){?>
                            (%)
                        <?php }?>
                    </th>
                    <th>
                        <?php echo JText::_('JSHOP_PRODUCT_PRICE')?>
                    </th>                    
                    <th>
                        <?php echo JText::_('JSHOP_DELETE')?>    
                    </th>
                </tr>
                </thead>  
                <tbody>              
                <?php 
                $add_prices=$row->product_add_prices;
                $count=count($add_prices);
                for ($i=0; $i < $count; $i++){
                    if ($jshopConfig->product_price_qty_discount==1){
                        $_add_price=$row->product_price - $add_prices[$i]->discount;
                    }else{
                        $_add_price=$row->product_price - ($row->product_price * $add_prices[$i]->discount / 100);
                    }
                    $_add_price = \JSHelper::formatEPrice($_add_price);
                    ?>
                    <tr id="add_price_<?php print $i?>">
                        <td>
                            <input type="text" class="form-control small3" name="quantity_start[]" id="quantity_start_<?php print $i?>" value="<?php echo $add_prices[$i]->product_quantity_start;?>" />    
                        </td>
                        <td>
                            <input type="text" class="form-control small3" name="quantity_finish[]" id="quantity_finish_<?php print $i?>" value="<?php echo $add_prices[$i]->product_quantity_finish;?>" />    
                        </td>
                        <td>
                            <input type="text" class="form-control small3" name="product_add_discount[]" id="product_add_discount_<?php print $i?>" value="<?php echo $add_prices[$i]->discount;?>" onkeyup="jshopAdmin.productAddPriceupdateValue(<?php print $i?>)" />
                        </td>
                        <td>
                            <input type="text" class="form-control small3" id="product_add_price_<?php print $i?>" value="<?php echo $_add_price;?>" onkeyup="jshopAdmin.productAddPriceupdateDiscount(<?php print $i?>)" />
                        </td>
                        <td align="center">
                            <a class="btn btn-danger" href="#" onclick="jshopAdmin.delete_add_price(<?php print $i?>);return false;">
                                <i class="icon-delete"></i>
                            </a>
                        </td>
                    </tr>
                    <?php
                }
                ?>     
              </tbody>           
            </table>
            <table class="table table-striped">
            <tr>
                <td><?php echo $lists['add_price_units'];?> - <?php echo JText::_('JSHOP_UNIT_MEASURE')?></td>
                <td align="right" width="100">
                    <input class="btn button btn-primary" type="button" name="add_new_price" onclick="jshopAdmin.addNewPrice()" value="<?php echo JText::_('JSHOP_PRODUCT_ADD_PRICE_ADD')?>" />
                </td>
            </tr>
            </table>
            <script type="text/javascript">
            <?php 
            print "jshopAdmin.add_price_num=$i;";
            print "jshopAdmin.config_product_price_qty_discount=".$jshopConfig->product_price_qty_discount.";";
            ?>             
            </script>
        </td>
     </tr>
    <?php }?>
    <?php if ($jshopConfig->disable_admin['product_old_price'] == 0){?>
    <tr>
       <td class="key">
         <?php echo JText::_('JSHOP_OLD_PRICE')?>
       </td>
       <td test>
         <input type="text" name="product_old_price" class="form-control" id="product_old_price" value="<?php echo $row->product_old_price?>"  readonly="readonly" disabled="disabled" />
       </td>
    </tr>
    <?php }?>
    <?php if ($jshopConfig->admin_show_product_bay_price) { ?>
    <tr>
       <td class="key">
         <?php echo JText::_('JSHOP_PRODUCT_BUY_PRICE')?>
       </td>
       <td>
         <input type="text" name="product_buy_price" class="form-control" id="product_buy_price" value="<?php echo $row->product_buy_price?>" />
       </td>
    </tr>
    <?php } ?>
    <?php if ($jshopConfig->admin_show_weight){?>
    <tr>
       <td class="key">
         <?php echo JText::_('JSHOP_PRODUCT_WEIGHT')?>
       </td>
       <td test>
         <input type="text" name="product_weight" class="form-control" id="product_weight" value="<?php echo $row->product_weight?>" readonly="readonly" disabled="disabled"/> <?php print \JSHelper::sprintUnitWeight();?>
       </td>
    </tr>
	<?php }?>
    <?php if ($jshopConfig->disable_admin['product_ean'] == 0){?>
    <tr>
       <td class="key">
         <?php echo JText::_('JSHOP_EAN_PRODUCT')?>
       </td>
       <td>
         <input type="text" name="product_ean" class="form-control" id="product_ean" value="<?php echo $row->product_ean?>" onkeyup="jshopAdmin.updateEanForAttrib()" />
       </td>
    </tr>
    <?php }?>
    <?php if ($jshopConfig->disable_admin['manufacturer_code'] == 0){?>
    <tr test delete>
       <td class="key">
         <?php echo JText::_('JSHOP_MANUFACTURER_CODE')?>
       </td>
       <td>
         <input type="text" name="manufacturer_code" class = "form-control" value="<?php echo $row->manufacturer_code?>" />
       </td>
    </tr>
    <?php }?>
    
    
    <?php if ($jshopConfig->stock){?>
    <tr>
       <td class="key">
         <?php echo JText::_('JSHOP_QUANTITY_PRODUCT')?>*
       </td>
       <td>
         <div id="block_enter_prod_qty" style="padding-bottom:2px;<?php if ($row->unlimited) print "display:none;";?>">
             <input type="text" name="product_quantity" class="form-control" id="product_quantity" value="<?php echo $row->product_quantity?>" <?php if ($this->product_with_attribute){?>readonly="readonly"<?php }?> />
             <?php if ($this->product_with_attribute){ echo \JSHelperAdmin::tooltip(JText::_('JSHOP_INFO_PLEASE_EDIT_AMOUNT_FOR_ATTRIBUTE')); } ?>
         </div>
         <div>         
            <input type="checkbox" name="unlimited"  value="1" onclick="jshopAdmin.ShowHideEnterProdQty(this.checked)" <?php if ($row->unlimited) print "checked";?> /> <?php print JText::_('JSHOP_UNLIMITED')?>
         </div>         
       </td>
    </tr>
    <?php }?>
    <?php if ($jshopConfig->disable_admin['product_url'] == 0){?>
    <tr>
       <td class="key"><?php echo JText::_('JSHOP_URL')?></td>
       <td>
         <input type="text" name="product_url" class = "form-control" id="product_url" value="<?php echo $row->product_url?>" size="80" />
       </td>
    </tr>
    <?php }?>
    <?php if ($jshopConfig->use_different_templates_cat_prod) { ?>
    <tr>
       <td class="key">
         <?php echo JText::_('JSHOP_TEMPLATE_PRODUCT')?>
       </td>
       <td>
         <?php echo $lists['templates'];?>
       </td>
    </tr>
    <?php } ?>
     
    <?php if (!$this->withouttax){?>
    <tr>     
       <td class="key">
         <?php echo JText::_('JSHOP_TAX')?>*
       </td>
       <td>
         <?php echo $lists['tax'];?>
       </td>
    </tr>
    <?php }?>
    <?php if ($jshopConfig->disable_admin['product_manufacturer'] == 0){?>
    <tr>
       <td class="key">
         <?php echo JText::_('JSHOP_NAME_MANUFACTURER')?>
       </td>
       <td>
         <?php echo $lists['manufacturers'];?>
       </td>
    </tr>
    <?php }?>


     <?php if($row->RepertoireId): ?>
     <tr >
       <td class="key">
         <span  >RepertoireId</span>
       </td>
       <td test>
       	 <input type="text" name="RepertoireId" id="RepertoireId" readonly  value="<?= $row->RepertoireId?>" style=""/>
       </td>
      </tr>
      <?php endif; ?>
     
     
     
    <tr>
       <td class="key">
         <?php echo JText::_('JSHOP_CATEGORIES')?>*
       </td>
       <td>
          <?php echo $lists['categories'];?>
       </td>
    </tr>
    <tr style="display: none">
       <td class="key">
        <?php echo JText::_('JSHOP_MAIN_CATEGORY')?>
       </td>
       <td class="main_category_select" val="<?php echo $row->main_category_id?>" test></td>
    </tr>
    
    <?php if ($jshopConfig->admin_show_vendors && $this->display_vendor_select) { ?>
    <tr>
       <td class="key">
         <?php echo JText::_('JSHOP_VENDOR')?>
       </td>
       <td>
         <?php echo $lists['vendors'];?>
       </td>
    </tr>
    <?php }?>
     
    <?php if ($jshopConfig->admin_show_delivery_time) { ?>
    <tr>
       <td class="key">
         <?php echo JText::_('JSHOP_DELIVERY_TIME')?>
       </td>
       <td>
         <?php echo $lists['deliverytimes'];?>
       </td>
    </tr>
    <?php }?>
     
    <?php if ($jshopConfig->admin_show_product_labels ?? FALSE) { ?>
    <tr>
       <td class="key">
         <?php echo JText::_('JSHOP_LABEL')?>
       </td>
       <td>
         <?php echo $lists['labels'];?>
       </td>
    </tr>
    <?php }?>
     
    <?php if ($jshopConfig->admin_show_product_basic_price) { ?>
    <tr>
       <td class="key"><br/><?php echo JText::_('JSHOP_BASIC_PRICE')?></td>
    </tr>
    <tr>
       <td class="key">
         <?php echo JText::_('JSHOP_WEIGHT_VOLUME_UNITS')?>
       </td>
       <td>
         <input type="text" name="weight_volume_units" class = "form-control" value="<?php echo $row->weight_volume_units?>" />
       </td>
    </tr>
    <tr>
       <td class="key">
         <?php echo JText::_('JSHOP_UNIT_MEASURE')?>
       </td>
       <td>
         <?php echo $lists['basic_price_units'];?>
       </td>
    </tr>
    <?php }?>
    <?php if ($jshopConfig->return_policy_for_product){?>
    <tr>
       <td class="key">
         <?php echo JText::_('JSHOP_RETURN_POLICY_FOR_PRODUCT')?>
       </td>
       <td>
         <?php echo $lists['return_policy'];?>
       </td>
    </tr>
    <?php if (!$jshopConfig->no_return_all){?>  
    <tr>
       <td class="key">
         <?php echo JText::_('JSHOP_NO_RETURN')?>
       </td>
       <td>
         <input type="hidden" name="options[no_return]"  value="0" />
         <input type="checkbox" name="options[no_return]" value="1" <?php if (isset($row->product_options['no_return']) && $row->product_options['no_return']) echo 'checked = "checked"';?> />
       </td>
    </tr>
    <?php }?>
    <?php }?>
    <?php $pkey='plugin_template_info'; if ($this->$pkey){ print $this->$pkey;}?>
   </table>
   </div>
   <div class="clr"></div>
</div>