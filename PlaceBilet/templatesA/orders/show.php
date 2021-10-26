<?php 
/**
* @version      4.11.0 22.10.2014
* @author       MAXXmarketing GmbH
* @package      Jshopping
* @copyright    Copyright (C) 2010 webdesigner-profi.de. All rights reserved.
* @license      GNU/GPL
*/
defined('_JEXEC') or die();
$order = $this->order;
$order_history = $this->order_history;
$order_item = $this->order_items;
$lists = $this->lists;
$print = $this->print;


        JToolBarHelper::title(JText::_('JSHOP_ORDER').' '.$this->order->order_number.' &nbsp;&nbsp;&nbsp;т.'
                .($this->order->d_phone ? $this->order->phone:$this->order->d_phone).','
                .($this->order->d_mobil_phone ? $this->order->d_mobil_phone:$this->order->mobil_phone)." (".($this->order->d_FIO ? $this->order->d_FIO:$this->order->FIO).' '.($this->order->d_f_name ? $this->order->d_f_name:$this->order->f_name) .")"
                , 'generic.png');
        
                $bar = JToolBar::getInstance('toolbar');
                $style="<style>
                @media print {
                    .navbar-inner,
                    .subhead,
                    #isisJsData,
                    .nav-tabs,
                    #second-page,
                    #first-page,
                    .packaging,
                    .printHide
                    {
                        display:none;
                    } 
                    body{
                        padding:0;
                    }
                    #third-page{
                        display: block;
                    }
                }</style>";
                
                
        $title = JText::_('JSHOP_FIELD_DELETE_PLACES');//&client_id=$this->client_id
        $dhtml = "<a href=\"index.php?option=com_jshopping&controller=orders&task=DeletePlacesView&cid[]=".$this->order->order_id."\" class=\"btn btn-small \" style=\"max-width:190px;overflow: hidden;\" ><i class=\"icon-delete\" title=\"$title\"></i> $title</a>"; 
        $bar->appendButton('Custom', $dhtml, 'list'); 
        
        //http://naelke.su/administrator/index.php?option=com_jshopping&controller=orders&task=show
        
        $title = JText::_('JSHOP_FIELD_EDIT_ORDER');//&client_id=$this->client_id
        $dhtml = "<a href=\"index.php?option=com_jshopping&controller=orders&task=edit&order_id=".$this->order->order_id."\" class=\"btn btn-small \"  style=\"max-width:150px;overflow: hidden;\" ><i class=\"icon-edit\" title=\"$title\"></i> $title</a>$style"; 
        $bar->appendButton('Custom', $dhtml, 'list'); 

?>
<div class="jshop_edit">
<form action="index.php?option=com_jshopping&controller=orders" method="post" name="adminForm" id="adminForm">
<?php print $this->tmp_html_start?>
<input type="hidden" name="order_id" value="<?php print $order->order_id?>">
<table class="adminlist" width="100%">
<tr>
  <td width="50%" style="vertical-align:top;padding-top:14px;">
    <table class="table table-striped">
    <thead>    
      <tr>
        <th colspan="2">
          <?php echo _JSHOP_ORDER_PURCHASE;?>
        </th>
      </tr>
     </thead> 
      <tr>
        <td width="50%">
          <b><?php echo _JSHOP_NUMBER;?></b>
        </td>
        <td>
          <?php echo $order->order_number;?>
        </td>
      </tr>
      <tr>
        <td width="50%">
          <b><?php echo _JSHOP_DATE;?></b> 
       </td>
        <td>
          <?php echo formatdate($order->order_date, 1);?>
        </td>
      </tr>
      <tr>
        <td>
          <b><?php echo _JSHOP_STATUS;?></b> 
       </td>
        <td>
          <?php echo $order->status_name;?>
        </td>
      </tr>
      <tr>
        <td>
          <b><?php echo _JSHOP_IPADRESS;?></b>
       </td>
        <td>
          <?php echo $order->ip_address;?>
        </td>
      </tr>
      <?php print $this->tmp_html_info?>
    </table>
  </td>
  <?php if (!$print){?>
  <td width="50%" style="vertical-align: top" class="input-inline">
      <ul class="nav nav-tabs">
        <li class="active"><a href="#first-page" data-toggle="tab"><?php echo _JSHOP_STATUS_CHANGE;?></a></li>
        <li><a href="#second-page" data-toggle="tab"><?php echo _JSHOP_ORDER_HISTORY;?></a></li>
        <li><a href="#third-page" data-toggle="tab"><?php echo JText::_('JSHOP_COURIER')?></a></li>
      </ul>
      <div id="editdata-document" class="tab-content">
        <div id="first-page" class="tab-pane active">
        <table>
          <tr>
            <th colspan="3" align="center">
                <?php echo _JSHOP_STATUS_CHANGE?>:
            </th>
          </tr>
          <tr>
            <td>
              <?php echo _JSHOP_ORDER_STATUS?>
            </td>
            <td>
              <?php echo $lists['status'];?>
            </td>
            <td style="padding-left:5px;">
              <input type="button" class="button btn btn-primary" name="update_status" onclick="verifyStatus(<?php echo $order->order_status?>, <?php echo $order->order_id?>, '<?php echo _JSHOP_CHANGE_ORDER_STATUS;?>', 1)" value="<?php echo _JSHOP_UPDATE_STATUS?>" />
            </td>
          </tr>
          <tr>
              <td>
                <?php echo _JSHOP_COMMENT;?>:
              </td>
              <td>
                <textarea id="comments" name="comments"></textarea>
              </td>
              <td style="padding-left:5px;">
                <input type="checkbox" class="inputbox"  name="notify" id="notify" /><label for="notify">  <?php echo _JSHOP_NOTIFY_USER;?></label><br />
                <input type="checkbox" class="inputbox"  name="include" id="include" /><label for="include">  <?php echo _JSHOP_INCLUDE_COMMENT;?></label>
              </td>
          </tr>
        </table>
      </div>
        <div id="second-page" class="tab-pane">
        <table class="table">
            <tr class="bold">
              <td>
                <?php echo _JSHOP_DATE_ADDED;?>
              </td>
              <td>
                <?php echo _JSHOP_NOTIFY_CUSTOMER;?>
              </td>
              <td>
                <?php echo _JSHOP_STATUS;?>
              </td>
              <td>
                <?php echo _JSHOP_COMMENT;?>
              </td>
			  <?php print $this->tmp_html_table_history_field?>
            </tr>
          <?php foreach($order_history as $history) {?>
            <tr>
              <td>
                <?php echo formatdate($history->status_date_added, 1)?>
              </td>
              <td>
                <?php $notify_customer=($history->customer_notify) ? ('tick.png'): ('publish_x.png');?>
                <img src="components/com_jshopping/images/<?php echo $notify_customer?>" alt="notify_customer" border="0" />
              </td>
              <td>
                <?php echo $history->status_name?>
              </td>
              <td>
                <?php echo $history->comments?>
              </td>
			  <?php echo $history->tmp_html_table_history_field?>
            </tr>
          <?php }?>
        </table>
      </div>
          <div id="third-page" class="tab-pane">
              <table style="width: 100%;">
                  <tr><th style="width: 50%;"><?= JText::_('JSHOP_BONUS') ?></th><th style="width: 50%;"><?= JText::_('JSHOP_ADDRESS') ?></th></tr>
                  <tr><td><textarea rows="7" style="width: 90%;" name="bonus" cols="50"><?= $order->bonus?></textarea></td><td><textarea name="address" rows="7" style="width: 90%;" cols="50"><?= $order->address?></textarea></td></tr>
              </table>
          </div>
      </div>
  </td>
  <?php }?>
</tr>
</table>
<br/>

<table width="100%">
<tr>
    <td width="50%" valign="top">
        <table width="100%" class="table table-striped">
        <thead>
        <tr>
          <th colspan="2" align="center"><?php print _JSHOP_BILL_TO ?></th>
        </tr>
        </thead>
        <?php if ($this->config_fields['title']['display']){?>
        <tr class="<?= $order->title? NULL:'printHide' ?>">
          <td><b><?php print _JSHOP_USER_TITLE?>:</b></td>
          <td><?php print $this->order->title?></td>
        </tr>
        <?php } ?>
        <?php if ($this->config_fields['firma_name']['display']){?>
        <tr class="<?= $order->firma_name? NULL:'printHide' ?>">
          <td><b><?php print _JSHOP_FIRMA_NAME?>:</b></td>
          <td><?php print $this->order->firma_name?></td>
        </tr>
        <?php } ?>
        <?php if ($this->config_fields['f_name']['display']){?>
        <tr class="<?= $order->f_name? NULL:'printHide' ?>">
          <td width="40%"><b><?php print _JSHOP_FULL_NAME?>:</b></td>
		  <td width="60%"><?php print $this->order->f_name?> <?php print $this->order->l_name?> <?php print $this->order->m_name?></td>
        </tr>
        <?php } ?>
        
        
        
        <?php if ($this->config_fields['FIO']['display']){  // Изменено добавлено узел?>
        <tr class="<?= $order->FIO? NULL:'printHide' ?>">
            <td width="40%"><b><?php print JText::_('JSHOP_FIELD_FIO') ?>:</b></td>
		  <td width="60%"><?php print $this->order->FIO?>  </td>
        </tr>
        <?php } ?>
        
        
        
        <?php if ($this->config_fields['client_type']['display']){?>
        <tr class="<?= $order->client_type? NULL:'printHide' ?>">
          <td><b><?php print _JSHOP_CLIENT_TYPE?>:</b></td>
          <td><?php print $this->order->client_type_name;?></td>
        </tr>
        <?php } ?>        
        <?php if ($this->config_fields['firma_code']['display'] && ($this->order->client_type==2 || !$this->config_fields['client_type']['display'])){?>
        <tr class="<?= $order->firma_code? NULL:'printHide' ?>">
          <td><b><?php print _JSHOP_FIRMA_CODE?>:</b></td>
          <td><?php print $this->order->firma_code?></td>
        </tr>
        <?php } ?>        
        <?php if ($this->config_fields['tax_number']['display'] && ($this->order->client_type==2 || !$this->config_fields['client_type']['display'])){?>
        <tr class="<?= $order->tax_number? NULL:'printHide' ?>">
          <td><b><?php print _JSHOP_VAT_NUMBER?>:</b></td>
          <td><?php print $this->order->tax_number?></td>
        </tr>
        <?php } ?>
		<?php if ($this->config_fields['birthday']['display']){?>
        <tr class="<?= $order->birthday? NULL:'printHide' ?>">
          <td><b><?php print _JSHOP_BIRTHDAY?>:</b></td>
          <td><?php print $this->order->birthday?></td>
        </tr>
        <?php } ?>
        <?php if ($this->config_fields['home']['display']){?>
        <tr class="<?= ($this->config_fields['home']['display']?null:'printHide'); echo $this->config_fields['home']['display'] ?>">
          <td><b><?php print _JSHOP_FIELD_HOME?>:</b></td>
          <td><?php print $this->order->home?></td>
        </tr>
        <?php } ?>
        
        
        
        
        
        
        
        <?php if ($this->config_fields['housing']['display']){  // Изменено добавлено узел?>
        <tr class="<?= ($this->config_fields['housing']['display']?null :'printHide');   ?>">
            <td width="40%"><b><?php print JText::_('JSHOP_FIELD_HOUSING') ?>:</b></td>
		  <td width="60%"><?php print $this->order->housing?>  </td>
        </tr>
        <?php } ?>
        <?php if ($this->config_fields['porch']['display']){  // Изменено добавлено узел?>
        <tr class="<?= $order->porch? NULL:'printHide' ?>">
            <td width="40%"><b><?php print JText::_('JSHOP_FIELD_PORCH') ?>:</b></td>
		  <td width="60%"><?php print $this->order->porch?>  </td>
        </tr>
        <?php } ?>
        <?php if ($this->config_fields['level']['display']){  // Изменено добавлено узел?>
        <tr class="<?= $order->level? NULL:'printHide' ?>">
            <td width="40%"><b><?php print JText::_('JSHOP_FIELD_LEVEL') ?>:</b></td>
		  <td width="60%"><?php print $this->order->level?>  </td>
        </tr>
        <?php } ?>
        <?php if ($this->config_fields['intercom']['display']){  // Изменено добавлено узел?>
        <tr class="<?= $order->intercom? NULL:'printHide' ?>">
            <td width="40%"><b><?php print JText::_('JSHOP_FIELD_INTERCOM') ?>:</b></td>
		  <td width="60%"><?php print $this->order->intercom?>  </td>
        </tr>
        <?php } ?>
        <?php if ($this->config_fields['shiping_date']['display']){  // Изменено добавлено узел?>
        <tr class="<?= $order->shiping_date? NULL:'printHide' ?>">
            <td width="40%"><b><?php print JText::_('JSHOP_FIELD_SHIPING_DATE') ?>:</b></td>
		  <td width="60%"><?php print $this->order->shiping_date?>  </td>
        </tr>
        <?php } ?>
        <?php if ($this->config_fields['shiping_time']['display']){  // Изменено добавлено узел?>
        <tr class="<?= $order->shiping_time? NULL:'printHide' ?>">
            <td width="40%"><b><?php print JText::_('JSHOP_FIELD_SHIPING_TIME') ?>:</b></td>
		  <td width="60%"><?php print $this->order->shiping_time?>  </td>
        </tr>
        <?php } ?>
        <?php if ($this->config_fields['metro']['display']){  // Изменено добавлено узел?>
        <tr class="<?= $order->metro? NULL:'printHide' ?>">
            <td width="40%"><b><?php print JText::_('JSHOP_FIELD_METRO') ?>:</b></td>
		  <td width="60%"><?php print $this->order->metro?>  </td>
        </tr>
        <?php } ?>
        <?php if ($this->config_fields['transport_name']['display']){  // Изменено добавлено узел?>
        <tr class="<?= $order->transport_name? NULL:'printHide' ?>">
            <td width="40%"><b><?php print JText::_('JSHOP_FIELD_TRANSPORT_NAME') ?>:</b></td>
		  <td width="60%"><?php print $this->order->transport_name?>  </td>
        </tr>
        <?php } ?>
        <?php if ($this->config_fields['transport_no']['display']){  // Изменено добавлено узел?>
        <tr class="<?= $order->transport_no? NULL:'printHide' ?>">
            <td width="40%"><b><?php print JText::_('JSHOP_FIELD_TRANSPORT_NO') ?>:</b></td>
		  <td width="60%"><?php print $this->order->transport_no?>  </td>
        </tr>
        <?php } ?>
        <?php if ($this->config_fields['track_stop']['display']){  // Изменено добавлено узел?>
        <tr class="<?= $order->track_stop? NULL:'printHide' ?>">
            <td width="40%"><b><?php print JText::_('JSHOP_FIELD_TRACK_STOP') ?>:</b></td>
		  <td width="60%"><?php print $this->order->track_stop?>  </td>
        </tr>
        <?php } ?>
        
        
        
        <?php if ($this->config_fields['apartment']['display']){?>
        <tr class="<?= $this->order->apartment? NULL:'printHide' ?>">
          <td><b><?php print _JSHOP_FIELD_APARTMENT?>:</b></td>
          <td><?php print $this->order->apartment?></td>
        </tr>
        <?php } ?>
        <?php if ($this->config_fields['street']['display']){?>
        <tr class="<?= $order->street? NULL:'printHide' ?>">
          <td><b><?php print _JSHOP_STREET_NR?>:</b></td>          
          <td><?php print $this->order->street?> <?php if ($this->config_fields['street_nr']['display']){?><?php print $this->order->street_nr?><?php }?></td>
        </tr>
        <?php } ?>
        <?php if ($this->config_fields['city']['display']){?>
        <tr class="<?= $order->city? NULL:'printHide' ?>">
          <td><b><?php print _JSHOP_CITY?>:</b></td>
          <td><?php print $this->order->city?></td>
        </tr>
        <?php } ?>
        <?php if ($this->config_fields['state']['display']){?>
        <tr class="<?= $order->state? NULL:'printHide' ?>">
          <td><b><?php print _JSHOP_STATE?>:</b></td>
          <td><?php print $this->order->state?></td>
        </tr>
        <?php } ?>
        <?php if ($this->config_fields['zip']['display']){?>
        <tr class="<?= $order->zip? NULL:'printHide' ?>">
          <td><b><?php print _JSHOP_ZIP?>:</b></td>
          <td><?php print $this->order->zip?></td>
        </tr>
        <?php } ?>
        <?php if ($this->config_fields['country']['display']){?>
        <tr class="<?= $order->country? NULL:'printHide' ?>">
          <td><b><?php print _JSHOP_COUNTRY?>:</b></td>
          <td><?php print $this->order->country?></td>
        </tr>
        <?php } ?>
        <?php if ($this->config_fields['phone']['display']){?>
        <tr class="<?= $order->phone? NULL:'printHide' ?>">
          <td><b><?php print _JSHOP_TELEFON?>:</b></td>
          <td><?php print $this->order->phone?></td>
        </tr>
        <?php } ?>
        <?php if ($this->config_fields['mobil_phone']['display']){?>
        <tr class="<?= $order->mobil_phone? NULL:'printHide' ?>">
          <td><b><?php print _JSHOP_MOBIL_PHONE?>:</b></td>
          <td><?php print $this->order->mobil_phone?></td>
        </tr>
        <?php } ?>
        <?php if ($this->config_fields['fax']['display']){?>
        <tr class="<?= $order->fax? NULL:'printHide' ?>">
          <td><b><?php print _JSHOP_FAX?>:</b></td>
          <td><?php print $this->order->fax?></td>
        </tr>
        <?php } ?>
        <?php if ($this->config_fields['email']['display']){?>
        <tr class="<?= $order->email? NULL:'printHide' ?>">
          <td><b><?php print _JSHOP_EMAIL?>:</b></td>
          <td><?php print $this->order->email?></td>
        </tr>
        <?php } ?>
        
        <?php if ($this->config_fields['ext_field_1']['display']){?>
        <tr class="<?= $order->ext_field_1? NULL:'printHide' ?>">
          <td><b><?php print _JSHOP_EXT_FIELD_1?>:</b></td>
          <td><?php print $this->order->ext_field_1?></td>
        </tr>
        <?php } ?>
        <?php if ($this->config_fields['ext_field_2']['display']){?>
        <tr class="<?= $order->ext_field_2? NULL:'printHide' ?>">
          <td><b><?php print _JSHOP_EXT_FIELD_2?>:</b></td>
          <td><?php print $this->order->ext_field_2?></td>
        </tr>
        <?php } ?>
        <?php if ($this->config_fields['ext_field_3']['display']){?>
        <tr class="<?= $order->ext_field_3? NULL:'printHide' ?>">
          <td><b><?php print _JSHOP_EXT_FIELD_3?>:</b></td>
          <td><?php print $this->order->ext_field_3?></td>
        </tr>
        <?php } ?>
        
        
        
        <?php if ($this->config_fields['comment']['display']){  // Изменено добавлено узел?>
        <tr class="<?= $order->comment? NULL:'printHide' ?>">
            <td width="40%"><b><?php print JText::_('JSHOP_FIELD_COMMENT') ?>:</b></td>
		  <td width="60%"><?php print $this->order->comment?>  </td>
        </tr>
        <?php } ?>
        
		<?php echo $this->tmp_fields?>		
        </table>
    </td>
    <td width="50%"  valign="top">
    <?php if ($this->count_filed_delivery >0) {?>
        <table width="100%" class="table table-striped">
        <thead>
        <tr  >
          <th colspan="2" align="center"><?php print _JSHOP_SHIP_TO ?></th>
        </tr>
        </thead>
        <?php if ($this->config_fields['d_title']['display']){?>
        <tr class="<?= $order->d_title? NULL:'printHide' ?>">
          <td><b><?php print _JSHOP_USER_TITLE?>:</b></td>
          <td><?php print $this->order->d_title?></td>
        </tr>
        <?php } ?>
        <?php if ($this->config_fields['d_firma_name']['display']){?>
        <tr class="<?= $order->d_firma_name? NULL:'printHide' ?>">
            <td><b><?php print _JSHOP_FIRMA_NAME?>:</b></td>
            <td><?php print $this->order->d_firma_name?></td>
        </tr>
        <?php } ?>
        <?php if ($this->config_fields['d_f_name']['display']){?>
        <tr class="<?= $order->d_f_name? NULL:'printHide' ?>">
            <td width="40%"><b><?php print _JSHOP_FULL_NAME?>:</b></td>
			<td width="60%"><?php print $this->order->d_f_name?> <?php print $this->order->d_l_name?> <?php print $this->order->d_m_name?></td>
        </tr>
        <?php } ?>
        
        
        
        <?php if (TRUE || $this->config_fields['FIO']['display']){  // Изменено добавлено узел?>
        <tr class="<?= $order->FIO? NULL:'printHide' ?>">
            <td width="40%"><b><?php print JText::_('JSHOP_FIELD_FIO') ?>:</b></td>
            <td width="60%"><?php print $this->order->d_FIO?>  </td>
        </tr>
        <?php } ?>
        
        
        
	<?php if ($this->config_fields['d_birthday']['display']){?>
        <tr class="<?= $order->d_birthday? NULL:'printHide' ?>">
          <td><b><?php print _JSHOP_BIRTHDAY?>:</b></td>
          <td><?php print $this->order->d_birthday?></td>
        </tr>
        <?php } ?>
        <?php if ($this->config_fields['d_home']['display']){?>
        <tr class="<?= $order->d_home? NULL:'printHide' ?>">
          <td><b><?php print _JSHOP_FIELD_HOME?>:</b></td>
          <td><?php print $this->order->d_home?></td>
        </tr>
        <?php } ?>
        
        
        
        
        
        
        
        <?php if ($this->config_fields['housing']['display']){  // Изменено добавлено узел?>
        <tr class="<?= $order->housing? NULL:'printHide' ?>">
            <td width="40%"><b><?php print JText::_('JSHOP_FIELD_HOUSING') ?>:</b></td>
		  <td width="60%"><?php print $this->order->d_housing?>  </td>
        </tr>
        <?php } ?>
        <?php if ($this->config_fields['porch']['display']){  // Изменено добавлено узел?>
        <tr class="<?= $order->porch? NULL:'printHide' ?>">
            <td width="40%"><b><?php print JText::_('JSHOP_FIELD_PORCH') ?>:</b></td>
		  <td width="60%"><?php print $this->order->d_porch?>  </td>
        </tr>
        <?php } ?>
        <?php if ($this->config_fields['level']['display']){  // Изменено добавлено узел?>
        <tr class="<?= $order->level? NULL:'printHide' ?>">
            <td width="40%"><b><?php print JText::_('JSHOP_FIELD_LEVEL') ?>:</b></td>
		  <td width="60%"><?php print $this->order->d_level?>  </td>
        </tr>
        <?php } ?>
        <?php if ($this->config_fields['intercom']['display']){  // Изменено добавлено узел?>
        <tr class="<?= $order->intercom? NULL:'printHide' ?>">
            <td width="40%"><b><?php print JText::_('JSHOP_FIELD_INTERCOM') ?>:</b></td>
		  <td width="60%"><?php print $this->order->d_intercom?>  </td>
        </tr>
        <?php } ?>
        <?php if ($this->config_fields['shiping_date']['display']){  // Изменено добавлено узел?>
        <tr class="<?= $order->shiping_date? NULL:'printHide' ?>">
            <td width="40%"><b><?php print JText::_('JSHOP_FIELD_SHIPING_DATE') ?>:</b></td>
		  <td width="60%"><?php print $this->order->d_shiping_date?>  </td>
        </tr>
        <?php } ?>
        <?php if ($this->config_fields['shiping_time']['display']){  // Изменено добавлено узел?>
        <tr class="<?= $order->shiping_time? NULL:'printHide' ?>">
            <td width="40%"><b><?php print JText::_('JSHOP_FIELD_SHIPING_TIME') ?>:</b></td>
		  <td width="60%"><?php print $this->order->d_shiping_time?>  </td>
        </tr>
        <?php } ?>
        <?php if ($this->config_fields['metro']['display']){  // Изменено добавлено узел?>
        <tr class="<?= $order->metro? NULL:'printHide' ?>">
            <td width="40%"><b><?php print JText::_('JSHOP_FIELD_METRO') ?>:</b></td>
		  <td width="60%"><?php print $this->order->d_metro?>  </td>
        </tr>
        <?php } ?>
        <?php if ($this->config_fields['transport_name']['display']){  // Изменено добавлено узел?>
        <tr class="<?= $order->transport_name? NULL:'printHide' ?>">
            <td width="40%"><b><?php print JText::_('JSHOP_FIELD_TRANSPORT_NAME') ?>:</b></td>
		  <td width="60%"><?php print $this->order->d_transport_name?>  </td>
        </tr>
        <?php } ?>
        <?php if ($this->config_fields['transport_no']['display']){  // Изменено добавлено узел?>
        <tr class="<?= $order->transport_no? NULL:'printHide' ?>">
            <td width="40%"><b><?php print JText::_('JSHOP_FIELD_TRANSPORT_NO') ?>:</b></td>
		  <td width="60%"><?php print $this->order->d_transport_no?>  </td>
        </tr>
        <?php } ?>
        <?php if ($this->config_fields['track_stop']['display']){  // Изменено добавлено узел?>
        <tr class="<?= $order->track_stop? NULL:'printHide' ?>">
            <td width="40%"><b><?php print JText::_('JSHOP_FIELD_TRACK_STOP') ?>:</b></td>
		  <td width="60%"><?php print $this->order->d_track_stop?>  </td>
        </tr>
        <?php } ?>
        
        
        
        <?php if ($this->config_fields['d_apartment']['display']){?>
        <tr class="<?= $order->d_apartment? NULL:'printHide' ?>">
          <td><b><?php print _JSHOP_FIELD_APARTMENT?>:</b></td>
          <td><?php print $this->order->d_apartment?></td>
        </tr>
        <?php } ?>
        <?php if ($this->config_fields['d_street']['display']){?>
        <tr class="<?= $order->d_street? NULL:'printHide' ?>">
            <td><b><?php print _JSHOP_STREET_NR?>:</b></td>            
            <td><?php print $this->order->d_street?> <?php if ($this->config_fields['d_street_nr']['display']){?><?php print $this->order->d_street_nr?><?php }?></td>
        </tr>
        <?php } ?>
        <?php if ($this->config_fields['d_city']['display']){?>
        <tr class="<?= $order->d_city? NULL:'printHide' ?>">
            <td><b><?php print _JSHOP_CITY?>:</b></td>
            <td><?php print $this->order->d_city?></td>
        </tr>
        <?php } ?>
        <?php if ($this->config_fields['d_state']['display']){?>
        <tr class="<?= $order->d_state? NULL:'printHide' ?>">
            <td><b><?php print _JSHOP_STATE?>:</b></td>
            <td><?php print $this->order->d_state?></td>
        </tr>
        <?php } ?>
        <?php if ($this->config_fields['d_zip']['display']){?>
        <tr class="<?= $order->d_zip? NULL:'printHide' ?>">
            <td><b><?php print _JSHOP_ZIP ?>:</b></td>
            <td><?php print $this->order->d_zip ?></td>
        </tr>
        <?php } ?>
        <?php if ($this->config_fields['d_country']['display']){?>
        <tr class="<?= $order->d_country? NULL:'printHide' ?>">
            <td><b><?php print _JSHOP_COUNTRY ?>:</b></td>
            <td><?php print $this->order->d_country ?></td>
        </tr>
        <?php } ?>
        <?php if ($this->config_fields['d_phone']['display']){?>
        <tr class="<?= $order->d_phone? NULL:'printHide' ?>">
            <td><b><?php print _JSHOP_TELEFON ?>:</b></td>
            <td><?php print $this->order->d_phone ?></td>
        </tr>
        <?php } ?>
        <?php if ($this->config_fields['d_mobil_phone']['display']){?>
        <tr class="<?= $order->d_mobil_phone? NULL:'printHide' ?>">
          <td><b><?php print _JSHOP_MOBIL_PHONE?>:</b></td>
          <td><?php print $this->order->d_mobil_phone?></td>
        </tr>
        <?php } ?>
        <?php if ($this->config_fields['d_fax']['display']){?>
        <tr class="<?= $order->d_fax? NULL:'printHide' ?>">
        <td><b><?php print _JSHOP_FAX ?>:</b></td>
        <td><?php print $this->order->d_fax ?></td>
        </tr>
        <?php } ?>
        <?php if ($this->config_fields['d_email']['display']){?>
        <tr class="<?= $order->d_email? NULL:'printHide' ?>">
        <td><b><?php print _JSHOP_EMAIL ?>:</b></td>
        <td><?php print $this->order->d_email ?></td>
        </tr>
        <?php } ?>                            
        <?php if ($this->config_fields['d_ext_field_1']['display']){?>
        <tr class="<?= $order->d_ext_field_1? NULL:'printHide' ?>">
          <td><b><?php print _JSHOP_EXT_FIELD_1?>:</b></td>
          <td><?php print $this->order->d_ext_field_1?></td>
        </tr>
        <?php } ?>
        <?php if ($this->config_fields['d_ext_field_2']['display']){?>
        <tr class="<?= $order->d_ext_field_2? NULL:'printHide' ?>">
          <td><b><?php print _JSHOP_EXT_FIELD_2?>:</b></td>
          <td><?php print $this->order->d_ext_field_2?></td>
        </tr>
        <?php } ?>
        <?php if ($this->config_fields['d_ext_field_3']['display']){?>
        <tr class="<?= $order->d_ext_field_3? NULL:'printHide' ?>">
          <td><b><?php print _JSHOP_EXT_FIELD_3?>:</b></td>
          <td><?php print $this->order->d_ext_field_3?></td>
        </tr>
        <?php } ?>
        
        
        
        <?php if ($this->config_fields['comment']['display']){  // Изменено добавлено узел?>
        <tr class="<?= $order->comment? NULL:'printHide' ?>">
            <td width="40%"><b><?php print JText::_('JSHOP_FIELD_COMMENT') ?>:</b></td>
		  <td width="60%"><?php print $this->order->d_comment?>  </td>
        </tr>
        <?php } ?>
        
		<?php echo $this->tmp_d_fields?>
      </table>
    <?php } ?>  
    </td>
</tr>
<?php print $this->_tmp_html_after_customer_info; ?>
</table>

<br/>
<table class="table table-striped" width="100%">
<thead>
<tr>
 <th>
   <?php echo JText::_('JSHOP_NAME_PRESENTATION') ?>
 </th>
 <?php if ($this->config->show_product_code_in_order){?>
 <th>
   <?php echo _JSHOP_EAN_PRODUCT?>
 </th>
 <?php }?>
 <?php if ($this->config->admin_show_vendors){?>
 <th>
   <?php echo _JSHOP_VENDOR?>
 </th>
 <?php }?>
 <th>
   <?php echo JText::_('JSHOP_TIME_EVENT')?>
 </th> 
 <th>
   <?php echo JText::_('JSHOP_COUNT_PLACES')?>
 </th>
 <th>
   <?php echo _JSHOP_TOTAL?>
 </th>
</tr>
</thead>
<?php 

if(PlaceBiletAdminDev)
    JFactory::getApplication()->enqueueMessage("<pre>\$order_item: \t".'<br/>'.print_r($order_item,true)."</pre>");

    $countplaces = 0;
    
foreach ($order_item as $item){
    $files = unserialize($item->files);
?>
<tr>
 <td>
   <a target="_blank" href="index.php?option=com_jshopping&controller=products&task=edit&product_id=<?php print $item->product_id?>">
    <?php echo $item->product_name?>
   </a><br /> 
   <?php print sprintAtributeInOrder($item->product_attributes).sprintFreeAtributeInOrder($item->product_freeattributes);?> 
   <?php print $item->_ext_attribute_html;?>
   <?php if (count($files)){?>
        <br/>
        <?php foreach($files as $file){?>
            <div><?php print $file->file_descr?> <a href="index.php?option=com_jshopping&controller=products&task=getfilesale&id=<?php print $file->id?>"><?php print _JSHOP_DOWNLOAD?></a></div>
        <?php }?>
    <?php }?>
    <?php print $item->_ext_file_html;?>
 </td>
 <?php if ($this->config->show_product_code_in_order){?>
 <td>
   <?php echo $item->product_ean?>
 </td>
 <?php }?>
 <?php if ($this->config->admin_show_vendors){?>
 <td>
   <?php echo $this->order_vendors[$item->vendor_id]->f_name." ".$this->order_vendors[$item->vendor_id]->l_name; ?>
 </td>
 <?php }?>
 <td>
   <?php if (isset($item->date_event))  //echo formatqty($item->date_event) 
    echo '<div style="width:100px">'.strftime("%e ",strtotime($item->date_event)). JText::_(strftime("%B",strtotime($item->date_event))). strftime(" %G",strtotime($item->date_event)). '</div><b style="font-size:24px;">'.strftime("%R",strtotime($item->date_event)).'</b> '.JText::_(strftime("%a",strtotime($item->date_event)));//formatdate($row->date_event, 1). strftime("%R:%M",$row->date_event) Изменено product_date_added на date_event изменено-добавленно
    ?>
 </td> 
 <td>
   <?php echo $item->count_places; 
   $countplaces += $item->count_places; ?>
 </td>
 <td>
   <?php echo formatprice($item->product_quantity * $item->product_item_price, $order->currency_code);?>
   <?php if (isset($item->_ext_price_total_html)) print $item->_ext_price_total_html?>
 </td>
</tr>
<?php }?>
</table>

<?php if (!$this->display_info_only_product){?>
<table class="table table-striped totalcost" width="100%">
<tr>
 <td colspan="5" style="height: 20px">
    <?php if ($this->config->show_weight_order){?>  
    <div style="text-align:right;">
        <i><?php print _JSHOP_WEIGHT_PRODUCTS?>: <span><?php print formatweight($this->order->weight);?></span></i>
    </div><br/>
  <?php }?>
 </td>
</tr>
<tr class="bold">
 <td colspan="4" class="right">
    <?php echo JText::_('JSHOP_COUNT_PLACES')?>
 </td>
 <td class="left" width="18%">
   <?php print $countplaces?>
 </td>
</tr>
<tr class="bold">
 <td colspan="4" class="right">
    <?php echo _JSHOP_SUBTOTAL?>
 </td>
 <td class="left" width="18%">
   <?php if (isset($order->order_subtotal) && isset($order->currency_code)) echo formatprice($order->order_subtotal, $order->currency_code);?><?php if (isset($this->_tmp_ext_subtotal)) print $this->_tmp_ext_subtotal?>
 </td>
</tr>
<?php print $this->_tmp_html_after_subtotal?>
<?php if ($order->order_discount > 0){?>
<tr class="bold">
 <td colspan="4" class="right">
    <?php echo _JSHOP_COUPON_DISCOUNT?>
    <?php if ($order->coupon_id){?>(<?php print $order->coupon_code?>)<?php }?>
	<?php print $this->_tmp_ext_discount_text?>
 </td>
 <td class="left">
   <?php echo formatprice(-$order->order_discount, $order->currency_code);?>
   <?php print $this->_tmp_ext_discount?>
 </td>
</tr>
<?php } ?>

<?php if (!$this->config->without_shipping || $order->order_shipping > 0){?>
<tr class="bold">
 <td colspan="4" class="right">
    <?php echo _JSHOP_SHIPPING_PRICE?>
 </td>
 <td class="left">
   <?php if (isset($order->order_shipping) && isset($order->currency_code)) echo formatprice($order->order_shipping, $order->currency_code);?><?php if (isset($this->_tmp_ext_shipping)) print $this->_tmp_ext_shipping?>
 </td>
</tr>
<?php } ?>
<?php if (!$this->config->without_shipping || $order->order_package > 0){?>
<tr class = "bold packaging">
 <td colspan = "4" class = "right">
    <?php echo _JSHOP_PACKAGE_PRICE?>
 </td>
 <td class = "left">
   <?php echo formatprice($order->order_package, $order->currency_code);?><?php print $this->_tmp_ext_shipping_package?>
 </td>
</tr>
<?php } ?>

<?php if ($order->order_payment > 0){?>
<tr class="bold">
 <td colspan="4" class="right">
     <?php print $order->payment_name;?>
 </td>
 <td class="left">
   <?php if (isset($order->order_payment) && isset($order->currency_code)) echo formatprice($order->order_payment, $order->currency_code);?><?php if (isset($this->_tmp_ext_payment)) print $this->_tmp_ext_payment?>
 </td>
</tr>
<?php } ?>

<?php if (!$this->config->hide_tax){?>
    <?php foreach($order->order_tax_list as $percent=>$value){?>
      <tr class="bold">
        <td  colspan="4" class="right">
          <?php print displayTotalCartTaxName($order->display_price);?>
          <?php print $percent."%"?>
        </td>
        <td  class="left">
          <?php if (isset($value) && isset($order->currency_code)) print formatprice($value, $order->currency_code);?><?php if (isset($this->_tmp_ext_tax[$percent])) print $this->_tmp_ext_tax[$percent]?>
        </td>
      </tr>
    <?php }?>
<?php }?>
<tr class="bold">
 <td colspan="4" class="right">
    <?php echo _JSHOP_TOTAL?>
 </td>
 <td class="left">
   <?php if (isset($order->order_total) && isset($order->currency_code)) echo formatprice($order->order_total, $order->currency_code);?><?php if (isset($this->_tmp_ext_total)) print $this->_tmp_ext_total?>
 </td>
</tr>
<?php print $this->_tmp_html_after_total?>
</table>
<?php }?>
<br/>

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
    <th width="34%">
    <?php echo _JSHOP_CUSTOMER_COMMENT?>
    </th>
</tr>
</thead>
<tr>
    <?php if (!$this->config->without_shipping){?>
    <td valign="top">
        <div style="padding-bottom:4px;"><?php echo $order->shipping_info?></div>
        <div><i><?php echo nl2br($order->shipping_params)?></i></div>
        <?php if ($order->delivery_time_name){?>
        <div><?php echo _JSHOP_DELIVERY_TIME.": ".$order->delivery_time_name?></div>
        <?php }?>
        <?php if ($order->delivery_date_f){?>
        <div><?php echo _JSHOP_DELIVERY_DATE.": ".$order->delivery_date_f?></div>
        <?php }?>
    </td>
    <?php } ?>
    <?php if (!$this->config->without_payment){?>
    <td valign="top">
        <div style="padding-bottom:4px;"><?php print $order->payment_name; ?></div>
        <div><i><?php echo nl2br($order->payment_params)?></i></div>
    </td>
    <?php } ?>
    <td valign="top"><?php echo $order->order_add_info?></td>    
</tr>
</table>

<?php if (count($this->stat_download)){?>
<br/>
<table class="adminlist order_stat_file_download">
<thead>
<tr>
    <th width="50%">
        <?php echo _JSHOP_FILE_SALE?>
    </th>
    <th>
        <?php echo _JSHOP_COUNT_DOWNLOAD?>
    </th>
    <th>
        <?php echo _JSHOP_DATE?>
    </th>
</tr>
</thead>
<?php 
foreach($this->stat_download as $v){?>
<tr>
    <td>
        <?php 
        if ($v->file_descr==''){
            print $v->file;
        }else{
            print $v->file_descr;
        }
        ?>
    </td>
    <td>
        <?php print $v->count_download?>
    </td>
    <td>
        <?php if ($v->time) print formatdate($v->time, 1)?>
    </td>
</tr>
<?php }?>
</table>
<div class="order_stat_file_download_clear">
    <a onclick="return confirm('<?php print _JSHOP_CLEAR?>')" href="index.php?option=com_jshopping&controller=orders&task=stat_file_download_clear&order_id=<?php print $order->order_id?>"><?php print _JSHOP_CLEAR?></a>
</div>
<?php }?>
<?php print $this->_ext_end_html?>
<input type="hidden" name="task" value="" />
<input type="hidden" name="js_nolang" id='js_nolang' value="0" />
<?php print $this->tmp_html_end?>
</form>
</div>
<script type = "text/javascript">
Joomla.submitbutton = function(task){
    if (task=='send'){
        document.getElementById('js_nolang').value='1';
    }
    Joomla.submitform(task, document.getElementById('adminForm'));
}
</script>