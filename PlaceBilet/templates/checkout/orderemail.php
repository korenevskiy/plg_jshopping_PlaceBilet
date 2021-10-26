<?php 
/**
* @version      4.11.2 18.08.2013
* @author       MAXXmarketing GmbH
* @package      Jshopping
* @copyright    Copyright (C) 2010 webdesigner-profi.de. All rights reserved.
* @license      GNU/GPL
*/
defined('_JEXEC') or die();
?>
<?php $order = $this->order;?>
<html>
<title></title>
<head>
<style type = "text/css">
html{
    font-family:Tahoma;
    line-height:100%;
}
body, td{
    font-size:12px;
    font-family:Tahoma;
}
td.bg_gray, tr.bg_gray td {
    background-color: #CCCCCC;
}
table {
    border-collapse:collapse;
    border:0;
}
td{
    padding-left:3px;
    padding-right: 3px;
    padding-top:0px;
    padding-bottom:0px;
}
tr.bold td{
    font-weight:bold;
}
tr.vertical td{
    vertical-align:top;
    padding-bottom:10px;
}
h3{
    font-size:14px;
    margin:2px;
}
.jshop_cart_attribute{
    padding-top: 5px;
    font-size:11px;
}
.taxinfo{
    font-size:11px;
}
</style>
</head>
<body>
<?= $this->_tmp_ext_html_ordermail_start?>

<table width="794px" align="center" border="0" cellspacing="0" cellpadding="0" style="line-height:100%;">
  <tr valign="top">
     <td colspan = "2">
       <?= $this->info_shop;?>
     </td>
  </tr>
  <?php if ($this->client){?>
  <tr>
     <td colspan = "2" style="padding-bottom:10px;">
       <?= $this->order_email_descr;?>
     </td>
  </tr>
  <?php }?>
  <tr class = "bg_gray">
     <td colspan = "2">
        <h3><?= _JSHOP_EMAIL_PURCHASE_ORDER?></h3>
     </td>
  </tr>
  <tr><td style="height:10px;font-size:1px;">&nbsp;</td></tr>
  <tr>
     <td width="50%">
        <?= _JSHOP_ORDER_NUMBER?>:
     </td>
     <td width="50%">
        <?= $this->order->order_number?>
     </td>
  </tr>
  <tr>
     <td>
        <?= _JSHOP_ORDER_DATE?>:
     </td>
     <td>
        <?= $this->order->order_date?>
     </td>
  </tr>
  <tr>
     <td>
        <?= _JSHOP_ORDER_STATUS?>:
     </td>
     <td>
        <?= $this->order->status?>
     </td>
  </tr>
<?php if ($this->show_customer_info){?>
  <tr><td style="height:10px;font-size:1px;">&nbsp;</td></tr>
  <tr class="bg_gray">
    <td colspan="2" width = "50%">
       <h3><?= _JSHOP_CUSTOMER_INFORMATION?></h3>
    </td>
  </tr>
  <tr>
    <td  style="vertical-align:top;padding-top:10px;" width = "50%">
      <table cellspacing="0" cellpadding="0" style="line-height:100%;">
        <tr style=" outline: 1px solid gainsboro;">
          <td colspan="2"><b><?= _JSHOP_EMAIL_BILL_TO?></b></td>
        </tr>
        <?php if ($this->config_fields['title']['display']){?>
        <tr style=" outline: 1px solid gainsboro;">
          <td width="100"><?= _JSHOP_REG_TITLE?>:</td>
          <td><?= $this->order->title?></td>
        </tr>
        <?php } ?>
        <?php if ($this->config_fields['firma_name']['display']){?>
        <tr style=" outline: 1px solid gainsboro;">
          <td width="100"><?= _JSHOP_FIRMA_NAME?>:</td>
          <td><?= $this->order->firma_name?></td>
        </tr>
        <?php } ?>
        <?php if ($this->config_fields['f_name']['display']){?>
        <tr style=" outline: 1px solid gainsboro;">
          <td width="100"><?= _JSHOP_FULL_NAME?>:</td>
          <td><?= $this->order->f_name?> <?= $this->order->l_name?> <?= $this->order->m_name?></td>
        </tr>
        <?php } ?>
        
        
        
        
        <?php if ($this->config_fields['FIO']['display']){//Изменено Добавлено?>
        <tr style=" outline: 1px solid gainsboro;">
            <td width="100"><?= JText::_('JSHOP_FIELD_FIO')?>:</td>
          <td><?= $this->order->FIO ?></td>
        </tr>
        <?php } ?>
        
        
        
        <?php if ($this->config_fields['birthday']['display']){?>
        <tr style=" outline: 1px solid gainsboro;">
          <td><?= _JSHOP_BIRTHDAY?>:</td>
          <td><?= $this->order->birthday;?></td>
        </tr>
        <?php } ?>
        <?php if ($this->config_fields['client_type']['display']){?>
        <tr style=" outline: 1px solid gainsboro;">
          <td><?= _JSHOP_CLIENT_TYPE?>:</td>
          <td><?= $this->order->client_type_name;?></td>
        </tr>
        <?php } ?>        
        <?php if ($this->config_fields['firma_code']['display'] && ($this->order->client_type==2 || !$this->config_fields['client_type']['display'])){?>
        <tr style=" outline: 1px solid gainsboro;">
          <td><?= _JSHOP_FIRMA_CODE?>:</td>
          <td><?= $this->order->firma_code?></td>
        </tr>
        <?php } ?>
        <?php if ($this->config_fields['tax_number']['display'] && ($this->order->client_type==2 || !$this->config_fields['client_type']['display'])){?>
        <tr style=" outline: 1px solid gainsboro;">
          <td><?= _JSHOP_VAT_NUMBER?>:</td>
          <td><?= $this->order->tax_number?></td>
        </tr>
        <?php } ?>
        
        <?php if ($this->config_fields['home']['display']){?>
        <tr style=" outline: 1px solid gainsboro;">
          <td><?= _JSHOP_HOME?>:</td>
          <td><?= $this->order->home?></td>
        </tr>
        <?php } ?>
        
        
        
        
        <?php if ($this->config_fields['housing']['display']){//Изменено Добавлено?>
        <tr style=" outline: 1px solid gainsboro;">
            <td width="100"><?= JText::_('JSHOP_FIELD_HOUSING')?>:</td>
          <td><?= $this->order->housing ?></td>
        </tr>
        <?php } ?>
        <?php if ($this->config_fields['porch']['display']){//Изменено Добавлено?>
        <tr style=" outline: 1px solid gainsboro;">
            <td width="100"><?= JText::_('JSHOP_FIELD_PORCH')?>:</td>
          <td><?= $this->order->porch ?></td>
        </tr>
        <?php } ?>
        <?php if ($this->config_fields['level']['display']){//Изменено Добавлено?>
        <tr style=" outline: 1px solid gainsboro;">
            <td width="100"><?= JText::_('JSHOP_FIELD_LEVEL')?>:</td>
          <td><?= $this->order->level ?></td>
        </tr>
        <?php } ?>
        <?php if ($this->config_fields['intercom']['display']){//Изменено Добавлено?>
        <tr style=" outline: 1px solid gainsboro;">
            <td width="100"><?= JText::_('JSHOP_FIELD_INTERCOM')?>:</td>
          <td><?= $this->order->intercom ?></td>
        </tr>
        <?php } ?>
        <?php if ($this->config_fields['shiping_date']['display']){//Изменено Добавлено?>
        <tr style=" outline: 1px solid gainsboro;">
            <td width="100"><?= JText::_('JSHOP_FIELD_SHIPING_DATE')?>:</td>
          <td><?= $this->order->shiping_date ?></td>
        </tr>
        <?php } ?>
        <?php if ($this->config_fields['shiping_time']['display']){//Изменено Добавлено?>
        <tr style=" outline: 1px solid gainsboro;">
            <td width="100"><?= JText::_('JSHOP_FIELD_SHIPING_TIME')?>:</td>
          <td><?= $this->order->shiping_time ?></td>
        </tr>
        <?php } ?>
        <?php if ($this->config_fields['metro']['display']){//Изменено Добавлено?>
        <tr style=" outline: 1px solid gainsboro;">
            <td width="100"><?= JText::_('JSHOP_FIELD_METRO')?>:</td>
          <td><?= $this->order->metro ?></td>
        </tr>
        <?php } ?>
        <?php if ($this->config_fields['transport_name']['display']){//Изменено Добавлено?>
        <tr style=" outline: 1px solid gainsboro;">
            <td width="100"><?= JText::_('JSHOP_FIELD_TRANSPORT_NAME')?>:</td>
          <td><?= $this->order->transport_name ?></td>
        </tr>
        <?php } ?>
        <?php if ($this->config_fields['transport_no']['display']){//Изменено Добавлено?>
        <tr style=" outline: 1px solid gainsboro;">
            <td width="100"><?= JText::_('JSHOP_FIELD_TRANSPORT_NO')?>:</td>
          <td><?= $this->order->transport_no ?></td>
        </tr>
        <?php } ?>
        <?php if ($this->config_fields['track_stop']['display']){//Изменено Добавлено?>
        <tr style=" outline: 1px solid gainsboro;">
            <td width="100"><?= JText::_('JSHOP_FIELD_TRACK_STOP')?>:</td>
          <td><?= $this->order->track_stop ?></td>
        </tr>
        <?php } ?>
        
        
        
        
        
        <?php if ($this->config_fields['apartment']['display']){?>
        <tr style=" outline: 1px solid gainsboro;">
          <td><?= _JSHOP_APARTMENT?>:</td>
          <td><?= $this->order->apartment?></td>
        </tr>
        <?php } ?>
        <?php if ($this->config_fields['street']['display']){?>
        <tr style=" outline: 1px solid gainsboro;">
          <td><?= _JSHOP_STREET_NR?>:</td>
          <td><?= $this->order->street?> <?php if ($this->config_fields['street_nr']['display']){?><?= $this->order->street_nr?><?php }?></td>
        </tr>
        <?php } ?>
        <?php if ($this->config_fields['city']['display']){?>
        <tr style=" outline: 1px solid gainsboro;">
          <td><?= _JSHOP_CITY?>:</td>
          <td><?= $this->order->city?></td>
        </tr>
        <?php } ?>
        <?php if ($this->config_fields['state']['display']){?>
        <tr style=" outline: 1px solid gainsboro;">
          <td><?= _JSHOP_STATE?>:</td>
          <td><?= $this->order->state?></td>
        </tr>
        <?php } ?>
        <?php if ($this->config_fields['zip']['display']){?>
        <tr style=" outline: 1px solid gainsboro;">
          <td><?= _JSHOP_ZIP?>:</td>
          <td><?= $this->order->zip?></td>
        </tr>
        <?php } ?>
        <?php if ($this->config_fields['country']['display']){?>
        <tr style=" outline: 1px solid gainsboro;">
          <td><?= _JSHOP_COUNTRY?>:</td>
          <td><?= $this->order->country?></td>
        </tr>
        <?php } ?>
        <?php if ($this->config_fields['phone']['display']){?>
        <tr style=" outline: 1px solid gainsboro;">
          <td><?= _JSHOP_TELEFON?>:</td>
          <td><?= $this->order->phone?></td>
        </tr>
        <?php } ?>
        <?php if ($this->config_fields['mobil_phone']['display']){?>
        <tr style=" outline: 1px solid gainsboro;">
          <td><?= _JSHOP_MOBIL_PHONE?>:</td>
          <td><?= $this->order->mobil_phone?></td>
        </tr>
        <?php } ?>
        <?php if ($this->config_fields['fax']['display']){?>
        <tr style=" outline: 1px solid gainsboro;">
          <td><?= _JSHOP_FAX?>:</td>
          <td><?= $this->order->fax?></td>
        </tr>
        <?php } ?>
        <?php if ($this->config_fields['email']['display']){?>
        <tr style=" outline: 1px solid gainsboro;">
          <td><?= _JSHOP_EMAIL?>:</td>
          <td><?= $this->order->email?></td>
        </tr>
        <?php } ?>
        
        <?php if ($this->config_fields['ext_field_1']['display']){?>
        <tr style=" outline: 1px solid gainsboro;">
          <td><?= _JSHOP_EXT_FIELD_1?>:</td>
          <td><?= $this->order->ext_field_1?></td>
        </tr>
        <?php } ?>
        <?php if ($this->config_fields['ext_field_2']['display']){?>
        <tr style=" outline: 1px solid gainsboro;">
          <td><?= _JSHOP_EXT_FIELD_2?>:</td>
          <td><?= $this->order->ext_field_2?></td>
        </tr>
        <?php } ?>
        <?php if ($this->config_fields['ext_field_3']['display']){?>
        <tr style=" outline: 1px solid gainsboro;">
          <td><?= _JSHOP_EXT_FIELD_3?>:</td>
          <td><?= $this->order->ext_field_3?></td>
        </tr>
        <?php } ?>
        
        
        
        <?php if ($this->config_fields['comment']['display']){//Изменено Добавлено?>
        <tr style=" outline: 1px solid gainsboro;">
            <td width="100"><?= JText::_('JSHOP_FIELD_COMMENT')?>:</td>
          <td><?= $this->order->comment ?></td>
        </tr>
        <?php } ?>
        
        
        
        
        
        
        
		<?php echo $this->_tmp_fields?>
      </table>
    </td>
    <td style="vertical-align:top;padding-top:10px;" width = "50%">
    <?php if ($this->count_filed_delivery >0) {?>
    <table cellspacing="0" cellpadding="0" style="line-height:100%;">
        <tr style=" outline: 1px solid gainsboro;">
            <td colspan=2><b><?= _JSHOP_EMAIL_SHIP_TO?></b></td>
        </tr>
        <?php if ($this->config_fields['d_title']['display']){?>
        <tr style=" outline: 1px solid gainsboro;">
          <td width="100"><?= _JSHOP_REG_TITLE?>:</td>
          <td><?= $this->order->d_title?></td>
        </tr>
        <?php } ?>      
        <?php if ($this->config_fields['d_firma_name']['display']){?>
        <tr style=" outline: 1px solid gainsboro;">
            <td width="100"><?= _JSHOP_FIRMA_NAME?>:</td>
            <td ><?= $this->order->d_firma_name?></td>
        </tr>
        <?php } ?>
        <?php if ($this->config_fields['d_f_name']['display']){?>
        <tr style=" outline: 1px solid gainsboro;">
            <td width="100"><?= _JSHOP_FULL_NAME?> </td>
            <td><?= $this->order->d_f_name?> <?= $this->order->d_l_name?> <?= $this->order->d_m_name?></td>
        </tr>
        <?php } ?>
        
        
        
        
        <?php if ($this->config_fields['d_FIO']['display']){//Изменено Добавлено?>
        <tr style=" outline: 1px solid gainsboro;">
            <td width="100"><?= JText::_('JSHOP_FIELD_FIO')?>:</td>
          <td><?= $this->order->d_FIO ?></td>
        </tr>
        <?php } ?>
        
        
        
        <?php if ($this->config_fields['birthday']['display']){?>
        <tr style=" outline: 1px solid gainsboro;">
          <td><?= _JSHOP_BIRTHDAY?>:</td>
          <td><?= $this->order->d_birthday;?></td>
        </tr>
        <?php } ?>
        <?php if ($this->config_fields['d_home']['display']){?>
        <tr style=" outline: 1px solid gainsboro;">
          <td><?= _JSHOP_HOME?>:</td>
          <td><?= $this->order->d_home?></td>
        </tr>
        <?php } ?>
        
        
        
        
        <?php if ($this->config_fields['d_housing']['display']){//Изменено Добавлено?>
        <tr style=" outline: 1px solid gainsboro;">
            <td width="100"><?= JText::_('JSHOP_FIELD_HOUSING')?>:</td>
          <td><?= $this->order->d_housing ?></td>
        </tr>
        <?php } ?>
        <?php if ($this->config_fields['d_porch']['display']){//Изменено Добавлено?>
        <tr style=" outline: 1px solid gainsboro;">
            <td width="100"><?= JText::_('JSHOP_FIELD_PORCH')?>:</td>
          <td><?= $this->order->d_porch ?></td>
        </tr>
        <?php } ?>
        <?php if ($this->config_fields['d_level']['display']){//Изменено Добавлено?>
        <tr style=" outline: 1px solid gainsboro;">
            <td width="100"><?= JText::_('JSHOP_FIELD_LEVEL')?>:</td>
          <td><?= $this->order->d_level ?></td>
        </tr>
        <?php } ?>
        <?php if ($this->config_fields['d_intercom']['display']){//Изменено Добавлено?>
        <tr style=" outline: 1px solid gainsboro;">
            <td width="100"><?= JText::_('JSHOP_FIELD_INTERCOM')?>:</td>
          <td><?= $this->order->d_intercom ?></td>
        </tr>
        <?php } ?>
        <?php if ($this->config_fields['d_shiping_date']['display']){//Изменено Добавлено?>
        <tr style=" outline: 1px solid gainsboro;">
            <td width="100"><?= JText::_('JSHOP_FIELD_SHIPING_DATE')?>:</td>
          <td><?= $this->order->d_shiping_date ?></td>
        </tr>
        <?php } ?>
        <?php if ($this->config_fields['d_shiping_time']['display']){//Изменено Добавлено?>
        <tr style=" outline: 1px solid gainsboro;">
            <td width="100"><?= JText::_('JSHOP_FIELD_SHIPING_TIME')?>:</td>
          <td><?= $this->order->d_shiping_time ?></td>
        </tr>
        <?php } ?>
        <?php if ($this->config_fields['d_metro']['display']){//Изменено Добавлено?>
        <tr style=" outline: 1px solid gainsboro;">
            <td width="100"><?= JText::_('JSHOP_FIELD_METRO')?>:</td>
          <td><?= $this->order->d_metro ?></td>
        </tr>
        <?php } ?>
        <?php if ($this->config_fields['d_transport_name']['display']){//Изменено Добавлено?>
        <tr style=" outline: 1px solid gainsboro;">
            <td width="100"><?= JText::_('JSHOP_FIELD_TRANSPORT_NAME')?>:</td>
          <td><?= $this->order->d_transport_name ?></td>
        </tr>
        <?php } ?>
        <?php if ($this->config_fields['d_transport_no']['display']){//Изменено Добавлено?>
        <tr style=" outline: 1px solid gainsboro;">
            <td width="100"><?= JText::_('JSHOP_FIELD_TRANSPORT_NO')?>:</td>
          <td><?= $this->order->d_transport_no ?></td>
        </tr>
        <?php } ?>
        <?php if ($this->config_fields['d_track_stop']['display']){//Изменено Добавлено?>
        <tr style=" outline: 1px solid gainsboro;">
            <td width="100"><?= JText::_('JSHOP_FIELD_TRACK_STOP')?>:</td>
          <td><?= $this->order->d_track_stop ?></td>
        </tr>
        <?php } ?>
        
        
        
        
        
        <?php if ($this->config_fields['d_apartment']['display']){?>
        <tr style=" outline: 1px solid gainsboro;">
          <td><?= _JSHOP_APARTMENT?>:</td>
          <td><?= $this->order->d_apartment?></td>
        </tr>
        <?php } ?>
        <?php if ($this->config_fields['d_street']['display']){?>
        <tr style=" outline: 1px solid gainsboro;">
            <td><?= _JSHOP_STREET_NR?>:</td>
            <td><?= $this->order->d_street?> <?php if ($this->config_fields['d_street_nr']['display']){?><?= $this->order->d_street_nr?><?php }?></td>
        </tr>
        <?php } ?>
        <?php if ($this->config_fields['d_city']['display']){?>
        <tr style=" outline: 1px solid gainsboro;">
            <td><?= _JSHOP_CITY?>:</td>
            <td><?= $this->order->d_city?></td>
        </tr>
        <?php } ?>
        <?php if ($this->config_fields['d_state']['display']){?>
        <tr style=" outline: 1px solid gainsboro;">
            <td><?= _JSHOP_STATE?>:</td>
            <td><?= $this->order->d_state?></td>
        </tr>
        <?php } ?>
        <?php if ($this->config_fields['d_zip']['display']){?>
        <tr style=" outline: 1px solid gainsboro;">
            <td><?= _JSHOP_ZIP ?>:</td>
            <td><?= $this->order->d_zip ?></td>
        </tr>
        <?php } ?>
        <?php if ($this->config_fields['d_country']['display']){?>
        <tr style=" outline: 1px solid gainsboro;">
            <td><?= _JSHOP_COUNTRY ?>:</td>
            <td><?= $this->order->d_country ?></td>
        </tr>
        <?php } ?>
        <?php if ($this->config_fields['d_phone']['display']){?>
        <tr style=" outline: 1px solid gainsboro;">
            <td><?= _JSHOP_TELEFON ?>:</td>
            <td><?= $this->order->d_phone ?></td>
        </tr>
        <?php } ?>
        <?php if ($this->config_fields['d_mobil_phone']['display']){?>
        <tr style=" outline: 1px solid gainsboro;">
          <td><?= _JSHOP_MOBIL_PHONE?>:</td>
          <td><?= $this->order->d_mobil_phone?></td>
        </tr>
        <?php } ?>
        <?php if ($this->config_fields['d_fax']['display']){?>
        <tr style=" outline: 1px solid gainsboro;">
        <td><?= _JSHOP_FAX ?>:</td>
        <td><?= $this->order->d_fax ?></td>
        </tr>
        <?php } ?>
        <?php if ($this->config_fields['d_email']['display']){?>
        <tr style=" outline: 1px solid gainsboro;">
        <td><?= _JSHOP_EMAIL ?>:</td>
        <td><?= $this->order->d_email ?></td>
        </tr>
        <?php } ?>                            
        <?php if ($this->config_fields['d_ext_field_1']['display']){?>
        <tr style=" outline: 1px solid gainsboro;">
          <td><?= _JSHOP_EXT_FIELD_1?>:</td>
          <td><?= $this->order->d_ext_field_1?></td>
        </tr>
        <?php } ?>
        <?php if ($this->config_fields['d_ext_field_2']['display']){?>
        <tr style=" outline: 1px solid gainsboro;">
          <td><?= _JSHOP_EXT_FIELD_2?>:</td>
          <td><?= $this->order->d_ext_field_2?></td>
        </tr>
        <?php } ?>
        <?php if ($this->config_fields['d_ext_field_3']['display']){?>
        <tr style=" outline: 1px solid gainsboro;">
          <td><?= _JSHOP_EXT_FIELD_3?>:</td>
          <td><?= $this->order->d_ext_field_3?></td>
        </tr>
        <?php } ?>
        
        
        
        <?php if ($this->config_fields['d_comment']['display']){//Изменено Добавлено?>
        <tr style=" outline: 1px solid gainsboro;">
            <td width="100"><?= JText::_('JSHOP_FIELD_COMMENT')?>:</td>
          <td><?= $this->order->d_comment ?></td>
        </tr>
        <?php } ?>
        
        
        
        
        
        
        
		<?php echo $this->_tmp_d_fields?>
    </table>
    <?php }?> 
    </td>
  </tr>
<?php }?>
<?= $this->_tmp_ext_html_ordermail_after_customer_info; ?>
  <tr>
    <td colspan = "2">&nbsp;</td>
  </tr>
  <tr>
    <td colspan = "2" class="bg_gray">
      <h3><?= _JSHOP_ORDER_ITEMS ?></h3>
    </td>
  </tr>
  <tr>
    <td colspan="2" style="padding:0px;padding-top:10px;">
       <table width="100%" cellspacing="0" cellpadding="0" class="table_items">
        <tr><td colspan="5" style="vertical-align:top;padding-bottom:5px;font-size:1px;"><div style="height:1px;border-top:1px solid #999;"></div></td></tr>
         <tr class = "bold">            
            <td width="45%" style="padding-left:10px;padding-bottom:5px;"><?= _JSHOP_NAME_PRODUCT?></td>            
            <td width="15%" style="padding-bottom:5px;"><?php if ($this->config->show_product_code_in_order){?><?= _JSHOP_EAN_PRODUCT?><?php } ?></td>
            <td width="10%" style="padding-bottom:5px;"><?php echo JText::_('JSHOP_TIME_EVENT')?></td>
            <td width="15%" style="padding-bottom:5px;"><?= _JSHOP_SINGLEPRICE?></td>
            <td width="15%" style="padding-bottom:5px;"><?= _JSHOP_PRICE_TOTAL?></td>
         </tr>
         <tr><td colspan="5" style="vertical-align:top;padding-bottom:10px;font-size:1px;"><div style="height:1px;border-top:1px solid #999;"></div></td></tr>
         <?php 
         foreach($this->products as $key_id=>$prod){
             $files = unserialize($prod->files);
         ?>
         <tr class="vertical">
           <td>
                <img src="<?= $this->config->image_product_live_path?>/<?php if ($prod->thumb_image) print $prod->thumb_image; else print $this->noimage;?>" align="left" style="margin-right:5px;">
                <?= $prod->product_name;?>
                <?php if ($prod->manufacturer!=''){?>
                <div class="manufacturer"><?= _JSHOP_MANUFACTURER?>: <span><?= $prod->manufacturer?></span></div>
                <?php }?>
                <div class="jshop_cart_attribute">
                <?= sprintAtributeInOrder($prod->product_attributes)?>
                <?= sprintFreeAtributeInOrder($prod->product_freeattributes)?>
                <?= sprintExtraFiledsInOrder($prod->extra_fields)?>
                </div>
                <?= $prod->_ext_attribute_html;?>
                <?php if ($this->config->display_delivery_time_for_product_in_order_mail && $prod->delivery_time){?>
                <div class="deliverytime"><?= _JSHOP_DELIVERY_TIME?>: <?= $prod->delivery_time?></div>
                <?php }?>
           </td>           
           <td><?php if ($this->config->show_product_code_in_order){?><?= $prod->product_ean;?><?php } ?></td>
           <td>
           
   <?php if (isset($prod->date_event))  //echo formatqty($item->date_event) 
    echo '<div style="width:100px">'.strftime("%e ",strtotime($prod->date_event)). JText::_(strftime("%B",strtotime($prod->date_event))). strftime(" %G",strtotime($prod->date_event)). '</div><b style="font-size:24px;">'.strftime("%R",strtotime($prod->date_event)).'</b> '.JText::_(strftime("%a",strtotime($prod->date_event)));//formatdate($row->date_event, 1). strftime("%R:%M",$row->date_event) Изменено product_date_added на date_event изменено-добавленно
    ?>
           </td>
           <td>
                <?= formatprice($prod->product_item_price, $order->currency_code) ?>
                <?= $prod->_ext_price_html?>
                <?php if ($this->config->show_tax_product_in_cart && $prod->product_tax>0){?>
                    <div class="taxinfo"><?= productTaxInfo($prod->product_tax, $order->display_price);?></div>
                <?php }?>
				<?php if ($this->config->cart_basic_price_show && $prod->basicprice>0){?>
                    <div class="basic_price"><?= _JSHOP_BASIC_PRICE?>: <span><?= sprintBasicPrice($prod);?></span></div>
                <?php }?>
           </td>
           <td>
                <?= formatprice($prod->product_item_price*$prod->product_quantity, $order->currency_code); ?>
                <?= $prod->_ext_price_total_html?>
                <?php if ($this->config->show_tax_product_in_cart && $prod->product_tax>0){?>
                    <div class="taxinfo"><?= productTaxInfo($prod->product_tax, $order->display_price);?></div>
                <?php }?>
            </td>
         </tr>
         <?php if (count($files)){?>
         <tr>
            <td colspan="5">
            <?php foreach($files as $file){?>
                <div><?= $file->file_descr?> <a href="<?= JURI::root()?>index.php?option=com_jshopping&controller=product&task=getfile&oid=<?= $this->order->order_id?>&id=<?= $file->id?>&hash=<?= $this->order->file_hash?>&rl=1"><?= _JSHOP_DOWNLOAD?></a></div>
            <?php }?>    
            </td>
         </tr>
         <?php }?>
         <tr><td colspan="5" style="vertical-align:top;padding-bottom:10px;font-size:1px;"><div style="height:1px;border-top:1px solid #999;"></div></td></tr>
         <?php } ?>
         <?php if ($this->show_weight_order && $this->config->show_weight_order){?>
         <tr>
            <td colspan="5" style="text-align:right;font-size:11px;">            
                <?= _JSHOP_WEIGHT_PRODUCTS?>: <span><?= formatweight($this->order->weight);?></span>
            </td>
         </tr>   
         <?php }?>
      <?php if ($this->show_total_info){?>
         <tr>
           <td colspan="5">&nbsp;</td>
         </tr>
         <?php if (!$this->hide_subtotal){?>
         <tr>
           <td colspan="4" align="right" style="padding-right:15px;"><?= _JSHOP_SUBTOTAL ?>:</td>
           <td class="price"><?= formatprice($this->order->order_subtotal, $order->currency_code); ?><?= $this->_tmp_ext_subtotal?></td>
         </tr>
         <?php } ?>
		 <?= $this->_tmp_html_after_subtotal?>
         <?php if ($this->order->order_discount > 0){?>
         <tr>
           <td colspan="4" align="right" style="padding-right:15px;"><?= _JSHOP_RABATT_VALUE ?><?= $this->_tmp_ext_discount_text?>: </td>
           <td class="price">-<?= formatprice($this->order->order_discount, $order->currency_code); ?><?= $this->_tmp_ext_discount?></td>
         </tr>
         <?php } ?>
         <?php if (!$this->config->without_shipping){?>
         <tr>
           <td colspan="4" align="right" style="padding-right:15px;"><?= _JSHOP_SHIPPING_PRICE ?>:</td>
           <td class="price"><?= formatprice($this->order->order_shipping, $order->currency_code); ?><?= $this->_tmp_ext_shipping?></td>
         </tr>
         <?php } ?>
         <?php if (!$this->config->without_shipping && ($order->order_package>0 || $this->config->display_null_package_price)){?>
         <tr>
           <td colspan="4" align="right" style="padding-right:15px;"><?= _JSHOP_PACKAGE_PRICE?>:</td>
           <td class="price"><?= formatprice($this->order->order_package, $order->currency_code); ?><?= $this->_tmp_ext_shipping_package?></td>
         </tr>
         <?php } ?>
         <?php if ($this->order->order_payment != 0){?>
         <tr>
           <td colspan="4" align="right" style="padding-right:15px;"><?= $this->order->payment_name;?>:</td>
           <td class="price"><?= formatprice($this->order->order_payment, $order->currency_code); ?><?= $this->_tmp_ext_payment?></td>
         </tr>
         <?php } ?>
         <?php if (!$this->config->hide_tax){ ?>                           
         <?php foreach($this->order->order_tax_list as $percent=>$value){?>
         <tr>
           <td colspan="4" align="right" style="padding-right:15px;"><?= displayTotalCartTaxName($order->display_price);?><?php if ($this->show_percent_tax) print " ".formattax($percent)."%";?>:</td>
             <td class="price"><?= formatprice($value, $order->currency_code); ?><?= $this->_tmp_ext_tax[$percent]?></td>
         </tr>
         <?php } ?>
         <?php } ?>
         <tr>
           <td colspan="4" align="right" style="padding-right:15px;"><b><?= $this->text_total ?>:</b></td>
           <td class="price"><b><?= formatprice($this->order->order_total, $order->currency_code)?><?= $this->_tmp_ext_total?></b></td>
         </tr>
		 <?= $this->_tmp_html_after_total?>
         <tr>
           <td colspan="5">&nbsp;</td>
         </tr>
         <?php if (!$this->client){?>
         <tr>
           <td colspan="5" class="bg_gray"><?= _JSHOP_CUSTOMER_NOTE ?></td>
         </tr>
         <tr>
           <td colspan="5" style="padding-top:10px;"><?= $this->order->order_add_info ?></td>
         </tr>
         <tr><td>&nbsp;</td></tr>
         <?php } ?>
      <?php }?>
       </table>
    </td>
  </tr>
<?php if ($this->show_payment_shipping_info){?>
  <?php if (!$this->config->without_payment || !$this->config->without_shipping){?>  
  <tr class = "bg_gray">
    <?php if (!$this->config->without_payment){?>
    <td>
        <h3><?= _JSHOP_PAYMENT_INFORMATION ?></h3>
    </td>    
    <?php }?>
    <td <?php if ($this->config->without_payment){?> colspan="2" <?php }?>>
        <?php if (!$this->config->without_shipping){?>
        <h3><?= _JSHOP_SHIPPING_INFORMATION ?></h3>
        <?php } ?>
    </td>    
  </tr>
  <tr><td style="height:5px;font-size:1px;">&nbsp;</td></tr>
  <tr>
    <?php if (!$this->config->without_payment){?>
    <td valign="top">    
        <div style="padding-bottom:4px;"><?= $this->order->payment_name;?></div>
        <div style="font-size:11px;">
        <?php
            print nl2br($this->order->payment_information);
            print $this->order->payment_description;
        ?>
        </div>
    </td>
    <?php }?>
    <td valign="top" <?php if ($this->config->without_payment){?> colspan="2" <?php }?>>
        <?php if (!$this->config->without_shipping){?>
            <div style="padding-bottom:4px;">
                <?= nl2br($this->order->shipping_information);?>
            </div>
            <div style="font-size:11px;">
                <?= nl2br($this->order->shipping_params)?>
            </div>
            <?php if ($this->config->show_delivery_time_checkout && $this->order->order_delivery_time){
                print "<div>"._JSHOP_ORDER_DELIVERY_TIME.": ".$this->order->order_delivery_time."</div>";
            }            
            if ($this->config->show_delivery_date && $order->delivery_date_f){
                print "<div>"._JSHOP_DELIVERY_DATE.": ".$order->delivery_date_f."</div>";
            }
        }
        ?>
    </td>  
  </tr>
  <?php }?>
<?php }?>
  <?php if ($this->config->show_return_policy_in_email_order){?>
  <tr>
    <td colspan="2"><br/><br/><a class = "policy" target="_blank" href="<?= $this->liveurlhost.SEFLink('index.php?option=com_jshopping&controller=content&task=view&page=return_policy&tmpl=component&order_id='.$this->order->order_id, 1);?>"><?= _JSHOP_RETURN_POLICY?></a></td>
  </tr>
  <?php }?>
  <?php if ($this->client){?>
  <tr>
     <td colspan = "2" style="padding-bottom:10px;">
       <?= $this->order_email_descr_end;?>
     </td>
  </tr>
  <?php }?>
</table>
<?= $this->_tmp_ext_html_ordermail_end?> 
<br>    
</body>
</html>