<?php 
/**
* @version      4.10.0 28.05.2015
* @author       MAXXmarketing GmbH
* @package      Jshopping
* @copyright    Copyright (C) 2010 webdesigner-profi.de. All rights reserved.
* @license      GNU/GPL
*/
defined('_JEXEC') or die('Restricted access');
$order = $this->order;
$order_history = $this->order_history;
$order_item = $this->order_items;
$lists = $this->lists;
$config_fields = $this->config_fields;
JHTML::_('behavior.modal');

        JToolBarHelper::title(JText::_('JSHOP_ORDER').' '.$this->order->order_number.' &nbsp;&nbsp;&nbsp;т.'
                .($this->order->d_phone ? $this->order->phone:$this->order->d_phone).','
                .($this->order->d_mobil_phone ? $this->order->d_mobil_phone:$this->order->mobil_phone)." (".($this->order->d_FIO ? $this->order->d_FIO:$this->order->FIO).")"
                , 'generic.png');

        $bar = JToolBar::getInstance('toolbar');
        $title = JText::_('JSHOP_FIELD_DELETE_PLACES'); 
        $dhtml = '<a href=\"index.php?option=com_jshopping&controller=orders&task=DeletePlacesEdit&order_id='.$this->order->order_id.'&client_id='.$this->client_id.'" class="btn btn-small " ><i class="icon-delete" title="$title"></i>'.$title.'</a>'; 
        $bar->appendButton('Custom', $dhtml, 'list');
        
?>
<script type="text/javascript">
var admin_show_attributes=<?php print $this->config->admin_show_attributes?>;
var admin_show_freeattributes=<?php print $this->config->admin_show_freeattributes?>;
var admin_order_edit_more = <?php print $this->config->admin_order_edit_more?>;
var hide_tax = <?php print intval($this->config->hide_tax)?>;
var lang_load='<?php print _JSHOP_LOAD?>';
var lang_price='<?php print _JSHOP_PRICE?>';
var lang_tax='<?php print _JSHOP_TAX?>';
var lang_weight='<?php print _JSHOP_PRODUCT_WEIGHT?>';
var lang_vendor='<?php print _JSHOP_VENDOR?>';
function selectProductBehaviour(pid, eName){
	var currency_id = jQuery('#currency_id').val();
    var display_price = jQuery('#display_price').val();
    var user_id = jQuery('#user_id').val();
    loadProductInfoRowOrderItem(pid, eName, currency_id, display_price, user_id, 1);    
}
var userinfo_fields = {};
<?php foreach ($config_fields as $k=>$v){
    if ($v['display']) echo "userinfo_fields['".$k."']='';";
}?>
var userinfo_ajax = null;
var userinfo_link = "<?php print "index.php?option=com_jshopping&controller=users&task=get_userinfo&ajax=1"?>";
</script>
<div class="jshop_edit form-horizontal">
<form action="index.php?option=com_jshopping" method="post" name="adminForm" id="adminForm">
        <?php echo JHtml::_('form.token');
        $token = JSession::getFormToken();
    
    ?>
<?php print $this->tmp_html_start?>
<?php if (!$this->display_info_only_product){?>

<?php if (!$order->order_created){?>
    <div class="row-fluid">
        <div class="span2"><?php print _JSHOP_FINISHED?>:</div>
        <div class="span10"><input type="checkbox" name="order_created" value="1"></div>
    </div>
<?php }?>

<div class="row-fluid">
    <div class="span2"><?php print _JSHOP_USER?>:</div>
    <div class="span10"><?php echo $this->users_list_select;?></div>
</div>


<?php if ($this->config->date_invoice_in_invoice){?>
    <div class="row-fluid">
        <div class="span2"><?php print _JSHOP_INVOICE_DATE?>:</div>
        <div class="span10"><?php echo JHTML::_('calendar', getDisplayDate($order->invoice_date, $this->config->store_date_format), 'invoice_date', 'invoice_date', $this->config->store_date_format , array('class'=>'inputbox', 'size'=>'25', 'maxlength'=>'19'));?></div>
    </div>
<?php }?>

<table class="jshop_address" width="100%">
<tr>
    <td width="50%" valign="top">
        <table width="100%" class="admintable table table-striped">
        <thead>
        <tr>
          <th colspan="2" align="center"><?php print _JSHOP_BILL_TO ?></th>
        </tr>
        </thead>
		<?php if ($config_fields['title']['display']){?>
        <tr>
          <td><b><?php print _JSHOP_USER_TITLE?>:</b></td>
          <td><?php print $this->select_titles?></td>
        </tr>
        <?php } ?>
        <?php if ($config_fields['firma_name']['display']){?>
        <tr>
          <td><b><?php print _JSHOP_FIRMA_NAME?>:</b></td>
          <td><input type="text" name="firma_name" value="<?php print $order->firma_name?>" /></td>
        </tr>
        <?php } ?>
        <?php if ($config_fields['f_name']['display']){?>
        <tr>
          <td width="40%"><b><?php print _JSHOP_FULL_NAME?>:</b></td>
          <td width="60%"><input type="text" name="f_name" value="<?php print $order->f_name?>" /> <input type="text" name="l_name" value="<?php print $order->l_name?>" /></td>
        </tr>
        <?php } ?>
        
        
        
        
        <?php if ($config_fields['FIO']['display']){ // Изменено Добавленно ?>
        <tr>
            <td width="40%"><b><?php print JText::_('JSHOP_FIELD_FIO')?>:</b></td>
          <td width="60%"><input type="text" name="FIO" value="<?php print $order->FIO?>" />  </td>
        </tr>
        <?php } ?>
        
        
        
        <?php if ($config_fields['client_type']['display']){?>
        <tr>
          <td><b><?php print _JSHOP_CLIENT_TYPE?>:</b></td>
          <td><?php print $this->select_client_types;?></td>
        </tr>
        <?php } ?>
        <?php if ($config_fields['firma_code']['display']){?>
        <tr id="tr_field_firma_code" <?php if ($config_fields['client_type']['display'] && $order->client_type!="2"){?>style="display:none;"<?php } ?>>
          <td><b><?php print _JSHOP_FIRMA_CODE?>:</b></td>
          <td><input type="text" name="firma_code" value="<?php print $order->firma_code?>" /></td>
        </tr>
        <?php } ?>
        <?php if ($config_fields['tax_number']['display']){?>
        <tr id="tr_field_tax_number" <?php if ($config_fields['client_type']['display'] && $order->client_type!="2"){?>style="display:none;"<?php } ?>>
          <td><b><?php print _JSHOP_VAT_NUMBER?>:</b></td>
          <td><input type="text" name="tax_number" value="<?php print $order->tax_number?>" /></td>
        </tr>
        <?php } ?>
		<?php if ($config_fields['birthday']['display']){?>
        <tr>
          <td><b><?php print _JSHOP_BIRTHDAY?>:</b></td>
          <td><?php echo JHTML::_('calendar', $order->birthday, 'birthday', 'birthday', $this->config->field_birthday_format, array('class'=>'inputbox', 'size'=>'25', 'maxlength'=>'19'));?></td>
        </tr>
        <?php } ?>
        <?php if ($config_fields['home']['display']){?>
        <tr>
          <td><b><?php print _JSHOP_FIELD_HOME?>:</b></td>
          <td><input type="text" name="home" value="<?php print $order->home?>" /></td>
        </tr>
        <?php } ?>
        
        
        
        <?php if ($config_fields['housing']['display']){ // Изменено Добавленно ?>
        <tr>
            <td width="40%"><b><?php print JText::_('JSHOP_FIELD_HOUSING')?>:</b></td>
          <td width="60%"><input type="text" name="housing" value="<?php print $order->housing?>" />  </td>
        </tr>
        <?php } ?>
        <?php if ($config_fields['porch']['display']){ // Изменено Добавленно ?>
        <tr>
            <td width="40%"><b><?php print JText::_('JSHOP_FIELD_PORCH')?>:</b></td>
          <td width="60%"><input type="text" name="porch" value="<?php print $order->porch?>" />  </td>
        </tr>
        <?php } ?>
        <?php if ($config_fields['level']['display']){ // Изменено Добавленно ?>
        <tr>
            <td width="40%"><b><?php print JText::_('JSHOP_FIELD_LEVEL')?>:</b></td>
          <td width="60%"><input type="text" name="level" value="<?php print $order->level?>" />  </td>
        </tr>
        <?php } ?>
        <?php if ($config_fields['intercom']['display']){ // Изменено Добавленно ?>
        <tr>
            <td width="40%"><b><?php print JText::_('JSHOP_FIELD_INTERCOM')?>:</b></td>
          <td width="60%"><input type="text" name="intercom" value="<?php print $order->intercom?>" />  </td>
        </tr>
        <?php } ?>
        <?php if ($config_fields['shiping_date']['display']){ // Изменено Добавленно ?>
        <tr>
            <td width="40%"><b><?php print JText::_('JSHOP_FIELD_SHIPING_DATE')?>:</b></td>
          <td width="60%"><input type="text" name="shiping_date" value="<?php print $order->shiping_date?>" />  </td>
        </tr>
        <?php } ?>
        <?php if ($config_fields['shiping_time']['display']){ // Изменено Добавленно ?>
        <tr>
            <td width="40%"><b><?php print JText::_('JSHOP_FIELD_SHIPING_TIME')?>:</b></td>
          <td width="60%"><input type="text" name="shiping_time" value="<?php print $order->shiping_time?>" />  </td>
        </tr>
        <?php } ?>
        <?php if ($config_fields['metro']['display']){ // Изменено Добавленно ?>
        <tr>
            <td width="40%"><b><?php print JText::_('JSHOP_FIELD_METRO')?>:</b></td>
          <td width="60%"><input type="text" name="metro" value="<?php print $order->metro?>" />  </td>
        </tr>
        <?php } ?>
        <?php if ($config_fields['transport_name']['display']){ // Изменено Добавленно ?>
        <tr>
            <td width="40%"><b><?php print JText::_('JSHOP_FIELD_TRANSPORT_NAME')?>:</b></td>
          <td width="60%"><input type="text" name="transport_name" value="<?php print $order->transport_name?>" />  </td>
        </tr>
        <?php } ?>
        <?php if ($config_fields['transport_no']['display']){ // Изменено Добавленно ?>
        <tr>
            <td width="40%"><b><?php print JText::_('JSHOP_FIELD_TRANSPORT_NO')?>:</b></td>
          <td width="60%"><input type="text" name="transport_no" value="<?php print $order->transport_no?>" />  </td>
        </tr>
        <?php } ?>
        <?php if ($config_fields['track_stop']['display']){ // Изменено Добавленно ?>
        <tr>
            <td width="40%"><b><?php print JText::_('JSHOP_FIELD_TRACK_STOP')?>:</b></td>
          <td width="60%"><input type="text" name="track_stop" value="<?php print $order->track_stop?>" />  </td>
        </tr>
        <?php } ?>
        
        
        
        
        
        
        
        
        <?php if ($config_fields['apartment']['display']){?>
        <tr>
          <td><b><?php print _JSHOP_FIELD_APARTMENT?>:</b></td>
          <td><input type="text" name="apartment" value="<?php print $order->apartment?>" /></td>
        </tr>
        <?php } ?>
        <?php if ($config_fields['street']['display']){?>
        <tr>
          <td><b><?php print _JSHOP_STREET_NR?>:</b></td>
          <td>
          <input type="text" name="street" value="<?php print $order->street?>" />
          <?php if ($config_fields['street_nr']['display']){?>
          <input type="text" name="street_nr" value="<?php print $order->street_nr?>" />
          <?php }?>
          </td>
        </tr>
        <?php } ?>
        <?php if ($config_fields['city']['display']){?>
        <tr>
          <td><b><?php print _JSHOP_CITY?>:</b></td>
          <td><input type="text" name="city" value="<?php print $order->city?>" /></td>
        </tr>
        <?php } ?>
        <?php if ($config_fields['state']['display']){?>
        <tr>
          <td><b><?php print _JSHOP_STATE?>:</b></td>
          <td><input type="text" name="state" value="<?php print $order->state?>" /></td>
        </tr>
        <?php } ?>
        <?php if ($config_fields['zip']['display']){?>
        <tr>
          <td><b><?php print _JSHOP_ZIP?>:</b></td>
          <td><input type="text" name="zip" value="<?php print $order->zip?>" /></td>
        </tr>
        <?php } ?>
        <?php if ($config_fields['country']['display']){?>
        <tr>
          <td><b><?php print _JSHOP_COUNTRY?>:</b></td>
          <td><?php print $this->select_countries;?></td>
        </tr>
        <?php } ?>
        <?php if ($config_fields['phone']['display']){?>
        <tr>
          <td><b><?php print _JSHOP_TELEFON?>:</b></td>
          <td><input type="text" name="phone" value="<?php print $order->phone?>" /></td>
        </tr>
        <?php } ?>
        <?php if ($config_fields['mobil_phone']['display']){?>
        <tr>
          <td><b><?php print _JSHOP_MOBIL_PHONE?>:</b></td>
          <td><input type="text" name="mobil_phone" value="<?php print $order->mobil_phone?>" /></td>
        </tr>
        <?php } ?>
        <?php if ($config_fields['fax']['display']){?>
        <tr>
          <td><b><?php print _JSHOP_FAX?>:</b></td>
          <td><input type="text" name="fax" value="<?php print $order->fax?>" /></td>
        </tr>
        <?php } ?>
        <?php if ($config_fields['email']['display']){?>
        <tr>
          <td><b><?php print _JSHOP_EMAIL?>:</b></td>
          <td><input type="text" name="email" value="<?php print $order->email?>" /></td>
        </tr>
        <?php } ?>
        
        <?php if ($config_fields['ext_field_1']['display']){?>
        <tr>
          <td><b><?php print _JSHOP_EXT_FIELD_1?>:</b></td>
          <td><input type="text" name="ext_field_1" value="<?php print $order->ext_field_1?>" /></td>
        </tr>
        <?php } ?>
        <?php if ($config_fields['ext_field_2']['display']){?>
        <tr>
          <td><b><?php print _JSHOP_EXT_FIELD_2?>:</b></td>
          <td><input type="text" name="ext_field_2" value="<?php print $order->ext_field_2?>" /></td>
        </tr>
        <?php } ?>
        <?php if ($config_fields['ext_field_3']['display']){?>
        <tr>
          <td><b><?php print _JSHOP_EXT_FIELD_3?>:</b></td>
          <td><input type="text" name="ext_field_3" value="<?php print $order->ext_field_3?>" /></td>
        </tr>
        <?php } ?>
        
        
        
        
        <?php if ($config_fields['comment']['display']){ // Изменено Добавленно ?>
        <tr>
            <td width="40%"><b><?php print JText::_('JSHOP_FIELD_COMMENT')?>:</b></td>
          <td width="60%"><input type="text" name="comment" value="<?php print $order->comment?>" />  </td>
        </tr>
        <?php } ?>
        
        
        
        
		<?php echo $this->tmp_fields?>
        </table>
    </td>
    <td width="50%"  valign="top">
    <?php if ($this->count_filed_delivery >0) {?>
        <table width="100%" class="admintable table table-striped">
        <thead>
        <tr>
          <th colspan="2" align="center"><?php print _JSHOP_SHIP_TO ?></th>
        </tr>
        </thead>
		<?php if ($config_fields['d_title']['display']){?>
        <tr>
          <td><b><?php print _JSHOP_USER_TITLE?>:</b></td>
          <td><?php print $this->select_d_titles?></td>
        </tr>
        <?php } ?>
        <?php if ($config_fields['d_firma_name']['display']){?>
        <tr>
          <td><b><?php print _JSHOP_FIRMA_NAME?>:</b></td>
          <td><input type="text" name="d_firma_name" value="<?php print $order->d_firma_name?>" /></td>
        </tr>
        <?php } ?>
        <?php if ($config_fields['d_f_name']['display']){?>
        <tr>
          <td width="40%"><b><?php print _JSHOP_FULL_NAME?>:</b></td>
          <td width="60%"><input type="text" name="d_f_name" value="<?php print $order->d_f_name?>" /> <input type="text" name="d_l_name" value="<?php print $order->d_l_name?>" /></td>
        </tr>
        <?php } ?>
        
        
        
        
        <?php if ($config_fields['d_FIO']['display']){ // Изменено Добавленно ?>
        <tr>
            <td width="40%"><b><?php print JText::_('JSHOP_FIELD_FIO')?>:</b></td>
          <td width="60%"><input type="text" name="d_FIO" value="<?php print $order->d_FIO?>" />  </td>
        </tr>
        <?php } ?>
        
        
        
		<?php if ($config_fields['d_birthday']['display']){?>
        <tr>
          <td><b><?php print _JSHOP_BIRTHDAY?>:</b></td>
          <td><?php echo JHTML::_('calendar', $order->d_birthday, 'd_birthday', 'd_birthday', $this->config->field_birthday_format, array('class'=>'inputbox', 'size'=>'25', 'maxlength'=>'19'));?></td>
        </tr>
        <?php } ?>
        <?php if ($config_fields['d_home']['display']){?>
        <tr>
          <td><b><?php print _JSHOP_FIELD_HOME?>:</b></td>
          <td><input type="text" name="d_home" value="<?php print $order->d_home?>" /></td>
        </tr>
        <?php } ?>
        
        
        
        <?php if ($config_fields['d_housing']['display']){ // Изменено Добавленно ?>
        <tr>
            <td width="40%"><b><?php print JText::_('JSHOP_FIELD_HOUSING')?>:</b></td>
          <td width="60%"><input type="text" name="d_housing" value="<?php print $order->d_housing?>" />  </td>
        </tr>
        <?php } ?>
        <?php if ($config_fields['d_porch']['display']){ // Изменено Добавленно ?>
        <tr>
            <td width="40%"><b><?php print JText::_('JSHOP_FIELD_PORCH')?>:</b></td>
          <td width="60%"><input type="text" name="d_porch" value="<?php print $order->d_porch?>" />  </td>
        </tr>
        <?php } ?>
        <?php if ($config_fields['d_level']['display']){ // Изменено Добавленно ?>
        <tr>
            <td width="40%"><b><?php print JText::_('JSHOP_FIELD_LEVEL')?>:</b></td>
          <td width="60%"><input type="text" name="d_level" value="<?php print $order->d_level?>" />  </td>
        </tr>
        <?php } ?>
        <?php if ($config_fields['d_intercom']['display']){ // Изменено Добавленно ?>
        <tr>
            <td width="40%"><b><?php print JText::_('JSHOP_FIELD_INTERCOM')?>:</b></td>
          <td width="60%"><input type="text" name="d_intercom" value="<?php print $order->d_intercom?>" />  </td>
        </tr>
        <?php } ?>
        <?php if ($config_fields['d_shiping_date']['display']){ // Изменено Добавленно ?>
        <tr>
            <td width="40%"><b><?php print JText::_('JSHOP_FIELD_SHIPING_DATE')?>:</b></td>
          <td width="60%"><input type="text" name="d_shiping_date" value="<?php print $order->d_shiping_date?>" />  </td>
        </tr>
        <?php } ?>
        <?php if ($config_fields['d_shiping_time']['display']){ // Изменено Добавленно ?>
        <tr>
            <td width="40%"><b><?php print JText::_('JSHOP_FIELD_SHIPING_TIME')?>:</b></td>
          <td width="60%"><input type="text" name="d_shiping_time" value="<?php print $order->d_shiping_time?>" />  </td>
        </tr>
        <?php } ?>
        <?php if ($config_fields['d_metro']['display']){ // Изменено Добавленно ?>
        <tr>
            <td width="40%"><b><?php print JText::_('JSHOP_FIELD_METRO')?>:</b></td>
          <td width="60%"><input type="text" name="d_metro" value="<?php print $order->d_metro?>" />  </td>
        </tr>
        <?php } ?>
        <?php if ($config_fields['d_transport_name']['display']){ // Изменено Добавленно ?>
        <tr>
            <td width="40%"><b><?php print JText::_('JSHOP_FIELD_TRANSPORT_NAME')?>:</b></td>
          <td width="60%"><input type="text" name="d_transport_name" value="<?php print $order->d_transport_name?>" />  </td>
        </tr>
        <?php } ?>
        <?php if ($config_fields['d_transport_no']['display']){ // Изменено Добавленно ?>
        <tr>
            <td width="40%"><b><?php print JText::_('JSHOP_FIELD_TRANSPORT_NO')?>:</b></td>
          <td width="60%"><input type="text" name="d_transport_no" value="<?php print $order->d_transport_no?>" />  </td>
        </tr>
        <?php } ?>
        <?php if ($config_fields['d_track_stop']['display']){ // Изменено Добавленно ?>
        <tr>
            <td width="40%"><b><?php print JText::_('JSHOP_FIELD_TRACK_STOP')?>:</b></td>
          <td width="60%"><input type="text" name="d_track_stop" value="<?php print $order->d_track_stop?>" />  </td>
        </tr>
        <?php } ?>
        
        
        
        
        
        
        
        
        <?php if ($config_fields['d_apartment']['display']){?>
        <tr>
          <td><b><?php print _JSHOP_FIELD_APARTMENT?>:</b></td>
          <td><input type="text" name="d_apartment" value="<?php print $order->d_apartment?>" /></td>
        </tr>
        <?php } ?>
        <?php if ($config_fields['d_street']['display']){?>
        <tr>
          <td><b><?php print _JSHOP_STREET_NR?>:</b></td>
           <td>
          <input type="text" name="d_street" value="<?php print $order->d_street?>" />
          <?php if ($config_fields['d_street_nr']['display']){?>
          <input type="text" name="d_street_nr" value="<?php print $order->d_street_nr?>" />
          <?php }?>
          </td>
        </tr>
        <?php } ?>
        <?php if ($config_fields['d_city']['display']){?>
        <tr>
          <td><b><?php print _JSHOP_CITY?>:</b></td>
          <td><input type="text" name="d_city" value="<?php print $order->d_city?>" /></td>
        </tr>
        <?php } ?>
        <?php if ($config_fields['d_state']['display']){?>
        <tr>
          <td><b><?php print _JSHOP_STATE?>:</b></td>
          <td><input type="text" name="d_state" value="<?php print $order->d_state?>" /></td>
        </tr>
        <?php } ?>
        <?php if ($config_fields['d_zip']['display']){?>
        <tr>
          <td><b><?php print _JSHOP_ZIP?>:</b></td>
          <td><input type="text" name="d_zip" value="<?php print $order->d_zip?>" /></td>
        </tr>
        <?php } ?>
        <?php if ($config_fields['d_country']['display']){?>
        <tr>
          <td><b><?php print _JSHOP_COUNTRY?>:</b></td>
          <td><?php print $this->select_d_countries?></td>
        </tr>
        <?php } ?>
        <?php if ($config_fields['d_phone']['display']){?>
        <tr>
          <td><b><?php print _JSHOP_TELEFON?>:</b></td>
          <td><input type="text" name="d_phone" value="<?php print $order->d_phone?>" /></td>
        </tr>
        <?php } ?>
        <?php if ($config_fields['d_mobil_phone']['display']){?>
        <tr>
          <td><b><?php print _JSHOP_MOBIL_PHONE?>:</b></td>
          <td><input type="text" name="d_mobil_phone" value="<?php print $order->d_mobil_phone?>" /></td>
        </tr>
        <?php } ?>
        <?php if ($config_fields['d_fax']['display']){?>
        <tr>
          <td><b><?php print _JSHOP_FAX?>:</b></td>
          <td><input type="text" name="d_fax" value="<?php print $order->d_fax?>" /></td>
        </tr>
        <?php } ?>
        <?php if ($config_fields['d_email']['display']){?>
        <tr>
          <td><b><?php print _JSHOP_EMAIL?>:</b></td>
          <td><input type="text" name="d_email" value="<?php print $order->d_email?>" /></td>
        </tr>
        <?php } ?>
        
        <?php if ($config_fields['d_ext_field_1']['display']){?>
        <tr>
          <td><b><?php print _JSHOP_EXT_FIELD_1?>:</b></td>
          <td><input type="text" name="d_ext_field_1" value="<?php print $order->d_ext_field_1?>" /></td>
        </tr>
        <?php } ?>
        <?php if ($config_fields['d_ext_field_2']['display']){?>
        <tr>
          <td><b><?php print _JSHOP_EXT_FIELD_2?>:</b></td>
          <td><input type="text" name="d_ext_field_2" value="<?php print $order->d_ext_field_2?>" /></td>
        </tr>
        <?php } ?>
        <?php if ($config_fields['d_ext_field_3']['display']){?>
        <tr>
          <td><b><?php print _JSHOP_EXT_FIELD_3?>:</b></td>
          <td><input type="text" name="d_ext_field_3" value="<?php print $order->d_ext_field_3?>" /></td>
        </tr>
        <?php } ?>
        
        
        
        
        <?php if ($config_fields['d_comment']['display']){ // Изменено Добавленно ?>
        <tr>
            <td width="40%"><b><?php print JText::_('JSHOP_FIELD_COMMENT')?>:</b></td>
          <td width="60%"><input type="text" name="d_comment" value="<?php print $order->d_comment?>" />  </td>
        </tr>
        <?php } ?>
        
        
        
        
		<?php echo $this->tmp_d_fields?>
        </table>
    <?php } ?>  
    </td>
</tr>
<?php print $this->_tmp_html_after_customer_info; ?>
</table>
<?php } ?>
<br/>
<div>
<?php print _JSHOP_CURRENCIES?>: <?php print $this->select_currency?> &nbsp;
<?php print _JSHOP_DISPLAY_PRICE?>: <?php print $this->display_price_select?> &nbsp;
<?php print _JSHOP_LANGUAGE_NAME?>: <?php print $this->select_language?>
</div>
<br/>



<table class="admintable table table-striped" width="100%" id='list_order_items'>
<thead>
<tr>
 <th>
   <?php echo _JSHOP_NAME_PRODUCT?>
 </th>
 <th>
   <?php echo JText::_('JSHOP_COUNT_PLACES')?>
 </th>
 <th>
   <?php echo JText::_('JSHOP_TIME_EVENT')?>
 </th> 
 <th width="16%">
   <?php echo _JSHOP_PRICE?>
 </th>
 <th width="4%">
   <?php echo _JSHOP_DELETE?>
 </th>
</tr>
</thead>
<?php $i=0; $countplaces = 0; //Изменено Добавленно переменная?>
<?php foreach ($order_item as $item){ $i++; ?>
<tr valign="top" id="order_item_row_<?php echo $i?>">
 <td>
   <input type="text" name="product_name[<?php echo $i?>]" value="<?php echo $item->product_name?>" size="44" title="<?php print _JSHOP_TITLE?>" />
   <a class="modal btn" rel="{handler: 'iframe', size: {x: 800, y: 600}}" href="index.php?option=com_jshopping&controller=product_list_selectable&tmpl=component&e_name=<?php echo $i?>"><?php print _JSHOP_LOAD?></a>
   <br />
   <?php if ($this->config->admin_show_attributes){?>
   <textarea rows="5" cols="24" name="product_attributes[<?php echo $i?>]" title="<?php print _JSHOP_ATTRIBUTES?>"><?php print $item->product_attributes?></textarea>   
   <br />
   <?php }?>
   <?php if ($this->config->admin_show_freeattributes){?>
   <textarea rows="2" cols="24" name="product_freeattributes[<?php echo $i?>]" title="<?php print _JSHOP_FREE_ATTRIBUTES?>"><?php print $item->product_freeattributes?></textarea>
   <?php }?>   
   <input type="hidden" name="product_id[<?php echo $i?>]" value="<?php echo $item->product_id?>" />
   <input type="hidden" name="delivery_times_id[<?php echo $i?>]" value="<?php echo $item->delivery_times_id?>" />
   <input type="hidden" name="thumb_image[<?php echo $i?>]" value="<?php echo $item->thumb_image?>" />
   <input type="hidden" name="attributes[<?php echo $i?>]" value="<?php echo $item->attributes?>" />
   <?php if ($this->config->admin_order_edit_more){?>
   <div>
   <?php echo _JSHOP_PRODUCT_WEIGHT?> <input type="text" name="weight[<?php echo $i?>]" value="<?php echo $item->weight?>" />
   </div>
   <div>   
   <?php echo _JSHOP_VENDOR?> ID <input type="text" name="vendor_id[<?php echo $i?>]" value="<?php echo $item->vendor_id?>" />
   </div>
   <?php }else{?>
   <input type="hidden" name="weight[<?php echo $i?>]" value="<?php echo $item->weight?>" />
   <input type="hidden" name="vendor_id[<?php echo $i?>]" value="<?php echo $item->vendor_id?>" />
   <?php }?>
 </td>
 <td>
   <input type="text" name="count_places[<?php echo $i?>]" class="middle" value="<?php echo $item->count_places; $countplaces += $item->count_places; ?>" />
 </td>
 <td>  
   <?php echo JHTML::_('behavior.calendar'); //Изменено Добавлено поле 
                $dt_DateTime= ($item->date_event)? $item->date_event: date("Y-m-d H:i:s");
         echo JHTML::_('calendar', $dt_DateTime, "date_event[$i]", "date_event[$i]", '%Y-%m-%d %H:%M:%S', array('class'=>'inputbox prettycheckbox middle', 'size'=>'25',  'maxlength'=>'19', 'onkeyup'=>'updateOrderSubtotalValue();')); ?>
 </td>
 <td>
   <div class="price"><?php print _JSHOP_PRICE?>: <input class="small3" type="text" name="product_item_price[<?php echo $i?>]" value="<?php echo $item->product_item_price;?>" onkeyup="updateOrderSubtotalValue();"/><?php echo ' '.$order->currency_code;?></div>
   <?php if (!$this->config->hide_tax){?>
   <div class="tax"><?php print _JSHOP_TAX?>: <input class="small3" type="text" name="product_tax[<?php echo $i?>]" value="<?php echo $item->product_tax?>" /> %</div>
   <?php }?>
   <input type="hidden" name="order_item_id[<?php echo $i?>]" value="<?php echo $item->order_item_id?>" />
 </td>
 <td>
    <a class="btn btn-micro" href='#' onclick="jQuery('#order_item_row_<?php echo $i?>').remove();updateOrderSubtotalValue();return false;">
        <i class="icon-delete"></i>
    </a>
 </td>
</tr>
<?php }?>
</table>


    
<div style="text-align:right;padding-top:3px;">
    <input type="button" class="btn" value="<?php print _JSHOP_ADD." "._JSHOP_PRODUCT?>" onclick="addOrderItemRow();">
</div>
<script>var end_number_order_item=<?php echo $i?>;</script>

<br/>


<table  class="admintable table table-striped" >
    <tr><td style="width: 35%;">
        <?= JText::_('JSHOP_BONUS') ?><br>
        <textarea rows="7" style="width: 90%;" name="bonus"  cols="50"><?= $order->bonus?></textarea><br>
            <br>
        <?= JText::_('JSHOP_ADDRESS') ?>    <br>
        <textarea rows="7"  name="address" style="width: 90%;" cols="50"><?= $order->address?></textarea>   <br> 
        </td><td style="width: 65%;">




<table class="table table-striped" width="100%">
<tr class="bold">
 <td class="right">
    <?php echo _JSHOP_SUBTOTAL?>
 </td>
 <td class="left">
   <input type="text" class="small3" name="order_subtotal" value="<?php echo $order->order_subtotal;?>" onkeyup="updateOrderTotalValue();"/> <?php echo $order->currency_code;?>
 </td>
</tr>
<?php print $this->_tmp_html_after_subtotal?>
<tr class="bold">
 <td class="right">
   <?php echo _JSHOP_COUPON_DISCOUNT?>
 </td>
 <td class="left">
   <input type="text" class="small3" name="order_discount" value="<?php echo $order->order_discount;?>" onkeyup="updateOrderTotalValue();"/> <?php echo $order->currency_code;?>
 </td>
</tr>

<?php if (!$this->config->without_shipping){?>
<tr class="bold">
 <td class="right">
    <?php echo _JSHOP_SHIPPING_PRICE?>
 </td>
 <td class="left">
    <input type="text" class="small3" name="order_shipping" value="<?php echo $order->order_shipping;?>" onkeyup="updateOrderTotalValue();"/> <?php echo $order->currency_code;?> 
 </td>
</tr>
<tr class="bold">
 <td class = "right">
    <?php echo _JSHOP_PACKAGE_PRICE?>
 </td>
 <td class = "left">
    <input type="text" class="small3" name="order_package" value="<?php echo $order->order_package;?>" onkeyup="updateOrderTotalValue();"/> <?php echo $order->currency_code;?> 
 </td>
</tr>
<?php }?>
<?php if (!$this->config->without_payment){?>
<tr class="bold">
 <td class="right">
     <?php print ($order->payment_name) ? $order->payment_name : _JSHOP_PAYMENT;?>
 </td>
 <td class="left">
   <input type="text" class="small3" name="order_payment" value="<?php echo $order->order_payment?>" onkeyup="updateOrderTotalValue();"/> <?php echo $order->currency_code;?>
 </td>
</tr>
<?php }?>

<?php $i=0; if (!$this->config->hide_tax){?>
<?php foreach($order->order_tax_list as $percent=>$value){ $i++;?>
  <tr class="bold">
    <td class="right">
      <?php print displayTotalCartTaxName($order->display_price);?>
      <input type="text" class="small3" name="tax_percent[]" value="<?php print $percent?>" /> %
    </td>
    <td class="left">
      <input type="text" class="small3" name="tax_value[]" value="<?php print $value; ?>" /> <?php print $order->currency_code?>
    </td>
  </tr>
<?php }?>
  <tr class="bold" id='row_button_add_tax'>
    <td></td>
    <td class="left">
    <input type="button" class="btn" value="<?php print _JSHOP_TAX_CALCULATE?>" onclick="order_tax_calculate();">
    <input type="button" class="btn" value="<?php print _JSHOP_ADD." "._JSHOP_TAX?>" onclick="addOrderTaxRow();">
    </td>
  </tr>
<?php }?>

<tr class="bold">
 <td class="right">
    <?php echo _JSHOP_TOTAL?>
 </td>
 <td class="left" width="20%">
   <input type="text" class="small3" name="order_total" value="<?php echo $order->order_total;?>" /> <?php echo $order->currency_code;?>
 </td>
</tr>
<?php print $this->_tmp_html_after_total?>
<?php $pkey="etemplatevar";if ($this->$pkey){print $this->$pkey;}?>
</table>


</td>
</tr>
</table>



<table class="table table-striped">
<thead>
<tr>
    <?php if (!$this->config->without_shipping){?>
    <th width="33%">
    <?php echo _JSHOP_SHIPPING_INFORMATION?>
    </th>
    <?php }?>
    <?php if (!$this->config->without_payment){?>
    <th width="33%">
    <?php echo _JSHOP_PAYMENT_INFORMATION?>
    </th>
    <?php } ?>
    <?php if ($this->config->show_delivery_time){?>
    <th width="33%">
    <?php echo _JSHOP_DELIVERY_TIME?>
    </th>
    <?php } ?>
</tr>
</thead>
<tr>
    <?php if (!$this->config->without_shipping){?>
    <td valign="top"><?php echo $this->shippings_select?></td>
    <?php } ?>
    <?php if (!$this->config->without_payment){?>
    <td valign="top">
        <div style="padding-bottom:4px;"><?php print $this->payments_select?></div>
        <div><textarea name="payment_params"><?php echo $order->payment_params?></textarea></div>
    </td>
    <?php } ?>
    <?php if ($this->config->show_delivery_time){?>
    <td valign="top"><?php echo $this->delivery_time_select?></td>
    <?php } ?>
</tr>
</table>

<input type="hidden" name="js_nolang" value="1" />
<input type="hidden" name="order_id" value="<?php echo $this->order_id;?>" />
<input type="hidden" name="controller" value="orders" />
<input type="hidden" name="task" value="" />
<input type="hidden" name="client_id" value="<?php echo $this->client_id?>" />
<?php print $this->tmp_html_end?>
</form>
</div>