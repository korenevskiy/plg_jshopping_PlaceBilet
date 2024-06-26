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
use Joomla\Component\Jshopping\Site\Helper\Selects;
use \Joomla\CMS\Language\Text as JText;
defined('_JEXEC') or die();

JHtml::_('behavior.formvalidator');
?>
<div id="comjshop">
    <?php print $this->checkout_navigator?>
    <?php print $this->small_cart?>

    <div class="jshop address_block max-500">
        <?php 
        $config_fields = $this->config_fields;
        ?>
        <form action="<?php print $this->action ?>" method="post" name="loginForm" class="form-validate form-horizontal" autocomplete="off" enctype="multipart/form-data">
            <?php print $this->_tmp_ext_html_address_start?>
            <div class = "jshop_register">
                
                <?php if ($config_fields['title']['display'] ?? false) : ?>
                <div class="control-group">
                    <div class="control-label name">
                        <label for="title">
                        <?php print JText::_('JSHOP_REG_TITLE')?> <?php if ($config_fields['title']['require']) : ?><span>*</span><?php endif; ?>
                        </label>
                    </div>
                    <div class="controls">
                        <?php
                        if ($config_fields['title']['require']){
                            $attribs='class="inputbox form-control required"';
                        }else{
                            $attribs='class="inputbox form-control"';
                        }
                        ?>
                        <?php print Selects::getTitle($this->user->title, $attribs)?>
                    </div>
                </div>
                <?php endif; ?>                
				
                <?php if ($config_fields['f_name']['display'] ?? TRUE) : ?>
                <div class="control-group">
                  <div class="control-label name">
                    <label for="f_name">
                        <?php print JText::_('JSHOP_F_NAME')?> <?php if ($config_fields['f_name']['require']) : ?><span>*</span><?php endif; ?>
                    </label> 
                    </div>
                  <div class="controls">
                    <input type="text" name="f_name" id="f_name" value="<?php print $this->user->f_name??''?>" class="input form-control <?php if ($config_fields['f_name']['require']):?>required<?php endif?>">
                    </div>
                </div>
                <?php endif; ?>
                
                <?php if ($config_fields['l_name']['display'] ?? FALSE) : ?>
                <div class="control-group">
                  <div class="control-label name">
                    <label for="l_name">
                    <?php print JText::_('JSHOP_L_NAME')?> <?php if ($config_fields['l_name']['require']) : ?><span>*</span><?php endif; ?>
                    </label>
                    </div>
                  <div class="controls">
                    <input type="text" name="l_name" id="l_name" value="<?php print $this->user->l_name??''?>" class="input form-control <?php if ($config_fields['l_name']['require']):?>required<?php endif?>">
                    </div>
                </div>
                <?php endif; ?>
				
                <?php if ($config_fields['m_name']['display'] ?? FALSE) : ?>
                <div class="control-group">
                  <div class="control-label name">
                    <label for="m_name">
                    <?php print JText::_('JSHOP_M_NAME')?> <?php if ($config_fields['m_name']['require']) : ?><span>*</span><?php endif; ?>
                    </label>
                    </div>
                  <div class="controls">
                    <input type="text" name="m_name" id="m_name" value="<?php print $this->user->m_name??''?>" class="input form-control <?php if ($config_fields['m_name']['require']):?>required<?php endif?>">
                    </div>
                </div>
                <?php endif; ?>

                <?php if ($config_fields['FIO']['display']  ?? FALSE) : ?>
                <div class="control-group">
                    <div class="control-label name">
						<label for="FIO">
						<?php print JText::_('JSHOP_FIELD_FIO')?> <?php if (($config_fields['FIO']['require'] ?? TRUE) || ($config_fields['f_name']['require']??TRUE) || ($config_fields['l_name']['require']??TRUE)  || ($config_fields['m_name']['require']??TRUE) ) : ?><span>*</span><?php endif; ?>
						</label>
					</div>
					<div class="controls">
						<input type="text" name="FIO" id="FIO" value="<?php print $this->user->FIO??''?>" class="input form-control <?php if ($config_fields['FIO']['require'] ?? TRUE):?>required<?php endif?>">
					</div>
                </div>
                <?php endif; ?>
                
                
                <?php if ($config_fields['firma_name']['display'] ?? FALSE) : ?>
                <div class="control-group">
                    <div class="control-label name">
						<label for="firma_name">
						<?php print JText::_('JSHOP_FIRMA_NAME')?> <?php if ($config_fields['firma_name']['require']) : ?><span>*</span><?php endif; ?>
						</label>
					</div>
					<div class="controls">
						<input type="text" name="firma_name" id="firma_name" value="<?php print $this->user->firma_name??''?>" class="input form-control <?php if ($config_fields['firma_name']['require']):?>required<?php endif?>">
					</div>
                </div>
                <?php endif; ?>
                
                <?php if ($config_fields['client_type']['display'] ?? FALSE) : ?>
                <div class="control-group">
                  <div class="control-label name">
                    <label for="client_type">
                    <?php print JText::_('JSHOP_CLIENT_TYPE')?> <?php if ($config_fields['client_type']['require']) : ?><span>*</span><?php endif; ?>
                    </label>
                    </div>
                  <div class="controls">
                    <?php
                    if ($config_fields['client_type']['require']){
                        $attribs='class="inputbox form-control required"';
                    }else{
                        $attribs='class="inputbox form-control"';
                    }
                    ?>
                    <?php print Selects::getClientType($this->user->client_type??'', $attribs)?>
                    </div>
                </div>
                <?php endif; ?>
				
                <?php if ($config_fields['firma_code']['display'] ?? FALSE) : ?>
                <div class="control-group" id='tr_field_firma_code' >
                  <div class="control-label name">
                    <label for="firma_code">
                    <?php print JText::_('JSHOP_FIRMA_CODE')?> <?php if ($config_fields['firma_code']['require']) : ?><span>*</span><?php endif; ?>
                    </label>
                    </div>
                  <div class="controls">
                    <?php
                    if ($config_fields['tax_number']['require']){
                        if ($config_fields['client_type']['display']){
                            $class="required-company";
                        }else{
                            $class="required";
                        }
                    }else{
                        $class='';
                    }
                    ?>
                    <input type="text" name="firma_code" id="firma_code" value="<?php print $this->user->firma_code??''?>" class="input form-control <?php print $class;?>">
                    </div>
                </div>
                <?php endif; ?>
				
                <?php if ($config_fields['tax_number']['display'] ?? FALSE) : ?>
                <div class="control-group" id='tr_field_tax_number' >
                  <div class="control-label name">
                    <label for="tax_number">
                    <?php print JText::_('JSHOP_VAT_NUMBER')?> <?php if ($config_fields['tax_number']['require']) : ?><span>*</span><?php endif; ?>
                    </label>
                    </div>
                  <div class="controls">
                    <?php
                    if ($config_fields['tax_number']['require']){
                        if ($config_fields['client_type']['display']){
                            $class="required-company";
                        }else{
                            $class="required";
                        }
                    }else{
                        $class='';
                    }
                    ?>
                    <input type="text" name="tax_number" id="tax_number" value="<?php print $this->user->tax_number??''?>" class="input form-control <?php print $class?>">
                    </div>
                </div>
                <?php endif; ?>
				
                <?php if ($config_fields['email']['display'] ?? TRUE) : ?>
                <div class="control-group">
                  <div class="control-label name">
                    <label for="email">
                    <?php print JText::_('JSHOP_EMAIL')?> <?php if ($config_fields['email']['require']??TRUE) : ?><span>*</span><?php endif; ?>
                    </label>
                    </div>
                  <div class="controls">
                    <input type="text" name="email" id="email" value="<?php print $this->user->email??''?>" class="input form-control validate-email <?php if ($config_fields['email']['require']??TRUE):?>required<?php endif?>">
                    </div>
                </div>
                <?php endif; ?>
				
                <?php if ($config_fields['email2']['display'] ?? FALSE) : ?>
                <div class="control-group">
                  <div class="control-label name">
                    <label for="email2">
                    <?php print JText::_('JSHOP_EMAIL2')?> <?php if ($config_fields['email2']['require']) : ?><span>*</span><?php endif; ?>
                    </label>
                  </div>
                  <div class="controls">
                    <input type="text" name="email2" id="email2" value="<?php print $this->user->email2??''?>" class="input form-control validate-email <?php if ($config_fields['email2']['require']):?>required<?php endif?>">
                  </div>
                </div>
                <?php endif; ?>
                
                
                <?php if ($config_fields['phone']['display'] ?? TRUE) : ?>
                <div class="control-group">
                  <div class="control-label name">
                    <label for="phone">
                    <?php print JText::_('JSHOP_TELEFON')?> <?php if ($config_fields['phone']['require']) : ?><span>*</span><?php endif; ?>
                    </label>
                  </div>
                  <div class="controls">
                    <input type="text" name="phone" id="phone" value="<?php print $this->user->phone??''?>" class="input form-control <?php if ($config_fields['phone']['require']):?>required<?php endif?>">
                  </div>
                </div>
                <?php endif; ?>
                
                <?php if ($config_fields['mobil_phone']['display'] ?? FALSE) : ?>
                <div class="control-group">
                  <div class="control-label name">
                    <label for="mobil_phone">
                    <?php print JText::_('JSHOP_MOBIL_PHONE')?> <?php if ($config_fields['mobil_phone']['require']) : ?><span>*</span><?php endif; ?>
                    </label>
                  </div>
                  <div class="controls">
                    <input type="text" name="mobil_phone" id="mobil_phone" value="<?php print $this->user->mobil_phone??''?>" class="input form-control <?php if ($config_fields['mobil_phone']['require']):?>required<?php endif?>">
                  </div>
                </div>
                <?php endif; ?>
                
                <?php if ($config_fields['fax']['display'] ?? FALSE) : ?>
                <div class="control-group">
                  <div class="control-label name">
                    <label for="fax">
                    <?php print JText::_('JSHOP_FAX')?> <?php if ($config_fields['fax']['require']) : ?><span>*</span><?php endif; ?>
                    </label>
                  </div>
                  <div class="controls">
                    <input type="text" name="fax" id="fax" value="<?php print $this->user->fax??''?>" class="input form-control <?php if ($config_fields['fax']['require']):?>required<?php endif?>">
                  </div>
                </div>
                <?php endif; ?>
				
                
                <?php if ($config_fields['birthday']['display'] ?? FALSE) : ?>
                <div class="control-group">
                  <div class="control-label name">
                    <label for="birthday">
                    <?php print JText::_('JSHOP_BIRTHDAY')?> <?php if ($config_fields['birthday']['require']) : ?><span>*</span><?php endif; ?>
                    </label>
                  </div>
                  <div class="controls">
                    <?php 
                    $params=array('class'=>'input', 'size'=>'25', 'maxlength'=>'19','showTime'=>true);
                    if ($config_fields['birthday']['require']){
                        $params['class']='input required';
                    }
                    ?>
                    <?php echo \JHTML::_('calendar', $this->user->birthday??'', 'birthday', 'birthday', $this->config->field_birthday_format, $params);?>
                  </div>
                </div>
                <?php endif; ?>
				
				
				
                <?php echo $this->_tmpl_address_html_2?> 
				
				

                <?php if ($config_fields['shiping_date']['display'] ?? FALSE) : // Изменено добавлено поле?>
                <div class="control-group">
                  <div class="control-label name">
                    <label for="shiping_date">
                    <?php print JText::_('JSHOP_FIELD_SHIPING_DATE')?> <?php if ($config_fields['shiping_date']['require']) : ?><span>*</span><?php endif; ?>
                    </label>
                  </div>
                  <div class="controls">
                    <input type="text" name="shiping_date" id="shiping_date" value="<?php print $this->user->shiping_date??''?>" class="input form-control <?php if ($config_fields['shiping_date']['require']):?>required<?php endif?>">
                  </div>
                </div>
                <?php endif; ?>

                <?php if ($config_fields['shiping_time']['display'] ?? FALSE) : // Изменено добавлено поле?>
                <div class="control-group">
                  <div class="control-label name">
                    <label for="shiping_time">
                    <?php print JText::_('JSHOP_FIELD_SHIPING_TIME')?> <?php if ($config_fields['shiping_time']['require']) : ?><span>*</span><?php endif; ?>
                    </label>
                  </div>
                  <div class="controls">
                    <input type="text" name="shiping_time" id="shiping_time" value="<?php print $this->user->shiping_time??''?>" class="input form-control <?php if ($config_fields['shiping_time']['require']):?>required<?php endif?>">
                  </div>
                </div>
                <?php endif; ?>
				
                <?php if ($config_fields['home']['display'] ?? FALSE) : ?>
                <div class="control-group">
                  <div class="control-label name">
                    <label for="home">
                    <?php print JText::_('JSHOP_HOME')?> <?php if ($config_fields['home']['require']) : ?><span>*</span><?php endif; ?>
                    </label>
                  </div>
                  <div class="controls">
                    <input type="text" name="home" id="home" value="<?php print $this->user->home??''?>" class="input form-control <?php if ($config_fields['home']['require']):?>required<?php endif?>">
                  </div>
                </div>
                <?php endif; ?>
                
                <?php if ($config_fields['housing']['display'] ?? FALSE) :  // Изменено добавлено поле?>
                <div class="control-group">
                  <div class="control-label name">
                    <label for="housing">
                    <?php print JText::_('JSHOP_FIELD_HOUSING')?> <?php if ($config_fields['housing']['require']) : ?><span>*</span><?php endif; ?>
                    </label>
                  </div>
                  <div class="controls">
                    <input type="text" name="housing" id="housing" value="<?php print $this->user->housing??''?>" class="input form-control <?php if ($config_fields['housing']['require']):?>required<?php endif?>">
                  </div>
                </div>
                <?php endif; ?>
                <?php if ($config_fields['porch']['display'] ?? FALSE) :  // Изменено добавлено поле?>
                <div class="control-group">
                  <div class="control-label name">
                    <label for="porch">
                    <?php print JText::_('JSHOP_FIELD_PORCH')?> <?php if ($config_fields['porch']['require']) : ?><span>*</span><?php endif; ?>
                    </label>
                  </div>
                  <div class="controls">
                    <input type="text" name="porch" id="porch" value="<?php print $this->user->porch??''?>" class="input form-control <?php if ($config_fields['porch']['require']):?>required<?php endif?>">
                  </div>
                </div>
                <?php endif; ?>
				
                <?php if ($config_fields['intercom']['display'] ?? FALSE) :  // Изменено добавлено поле?>
                <div class="control-group">
                  <div class="control-label name">
                    <label for="intercom">
                    <?php print JText::_('JSHOP_FIELD_INTERCOM')?> <?php if ($config_fields['intercom']['require']) : ?><span>*</span><?php endif; ?>
                    </label>
                  </div>
                  <div class="controls">
                    <input type="text" name="intercom" id="intercom" value="<?php print $this->user->intercom??''?>" class="input form-control <?php if ($config_fields['intercom']['require']):?>required<?php endif?>">
                  </div>
                </div>
                <?php endif; ?>
				
                <?php if ($config_fields['level']['display'] ?? FALSE) :  // Изменено добавлено поле?>
                <div class="control-group">
                  <div class="control-label name">
                    <label for="level">
                    <?php print JText::_('JSHOP_FIELD_LEVEL')?> <?php if ($config_fields['level']['require']) : ?><span>*</span><?php endif; ?>
                    </label>
                  </div>
                  <div class="controls">
                    <input type="text" name="level" id="level" value="<?php print $this->user->level??''?>" class="input form-control <?php if ($config_fields['level']['require']):?>required<?php endif?>">
                  </div>
                </div>
                <?php endif; ?>
                
                
                

                <?php if ($config_fields['apartment']['display'] ?? FALSE) : ?>
                <div class="control-group">
                  <div class="control-label name">
                    <label for="apartment">
                    <?php print JText::_('JSHOP_APARTMENT')?> <?php if ($config_fields['apartment']['require']) : ?><span>*</span><?php endif; ?>
                    </label>
                  </div>
                  <div class="controls">
                    <input type="text" name="apartment" id="apartment" value="<?php print $this->user->apartment??''?>" class="input form-control <?php if ($config_fields['apartment']['require']):?>required<?php endif?>">
                  </div>
                </div>
                <?php endif; ?>
                
                
                
                
                
				

                <?php if ($config_fields['metro']['display'] ?? FALSE) : // Изменено добавлено поле?>
                <div class="control-group">
                  <div class="control-label name">
                    <label for="metro">
                    <?php print JText::_('JSHOP_FIELD_METRO')?> <?php if ($config_fields['metro']['require']) : ?><span>*</span><?php endif; ?>
                    </label>
                  </div>
                  <div class="controls">
                    <input type="text" name="metro" id="metro" value="<?php print $this->user->metro??''?>" class="input form-control <?php if ($config_fields['metro']['require']):?>required<?php endif?>">
                  </div>
                </div>
                <?php endif; ?>

                <?php if ($config_fields['transport_name']['display'] ?? FALSE) : // Изменено добавлено поле?>
                <div class="control-group">
                  <div class="control-label name">
                    <label for="transport_name">
                    <?php print JText::_('JSHOP_FIELD_TRANSPORT_NAME')?> <?php if ($config_fields['transport_name']['require']) : ?><span>*</span><?php endif; ?>
                    </label>
                  </div>
                  <div class="controls">
                    <input type="text" name="transport_name" id="transport_name" value="<?php print $this->user->transport_name??''?>" class="input form-control <?php if ($config_fields['transport_name']['require']):?>required<?php endif?>">
                  </div>
                </div>
                <?php endif; ?>
				
                <?php if ($config_fields['transport_no']['display'] ?? FALSE) : // Изменено добавлено поле?>
                <div class="control-group">
                  <div class="control-label name">
                    <label for="transport_no">
                    <?php print JText::_('JSHOP_FIELD_TRANSPORT_NO')?> <?php if ($config_fields['transport_no']['require']) : ?><span>*</span><?php endif; ?>
                    </label>
                  </div>
                  <div class="controls">
                    <input type="text" name="transport_no" id="transport_no" value="<?php print $this->user->transport_no??''?>" class="input form-control <?php if ($config_fields['transport_no']['require']):?>required<?php endif?>">
                  </div>
                </div>
                <?php endif; ?>

                <?php if ($config_fields['track_stop']['display'] ?? FALSE) : // Изменено добавлено поле?>
                <div class="control-group">
                  <div class="control-label name">
                    <label for="track_stop">
                    <?php print JText::_('JSHOP_FIELD_TRACK_STOP')?> <?php if ($config_fields['track_stop']['require']) : ?><span>*</span><?php endif; ?>
                    </label>
                  </div>
                  <div class="controls">
                    <input type="text" name="track_stop" id="track_stop" value="<?php print $this->user->track_stop??''?>" class="input form-control <?php if ($config_fields['track_stop']['require']):?>required<?php endif?>">
                  </div>
                </div>
                <?php endif; ?>
                
                
                
                
                
                
                
                
                
                
                
                
                
                
                
                
                <?php if ($config_fields['street']['display'] ?? FALSE) : ?>
                <div class="control-group">
                  <div class="control-label name">
                    <label for="street">
                    <?php print JText::_('JSHOP_STREET_NR')?> <?php if ($config_fields['street']['require']) : ?><span>*</span><?php endif; ?>
                    </label>
                  </div>
                  <div class="controls">
                    <input type="text" name="street" id="street" value="<?php print $this->user->street?>" class="input form-control <?php if ($config_fields['street']['require']):?>required<?php endif?>">
                    <?php if ($config_fields['street_nr']['display']){?>
                    <input type="text" name="street_nr" id="street_nr" value="<?php print $this->user->street_nr??''?>" class="input form-control <?php if ($config_fields['street_nr']['require']):?>required<?php endif?>"            >
                    <?php }?>
                  </div>
                </div>
                <?php endif; ?>
                
                <?php if ($config_fields['zip']['display'] ?? FALSE) : ?>
                <div class="control-group">
                  <div class="control-label name">
                    <label for="zip">
                    <?php print JText::_('JSHOP_ZIP')?> <?php if ($config_fields['zip']['require']) : ?><span>*</span><?php endif; ?>
                    </label>
                  </div>
                  <div class="controls">
                    <input type="text" name="zip" id="zip" value="<?php print $this->user->zip??''?>" class="input form-control <?php if ($config_fields['zip']['require']):?>required<?php endif?>">
                  </div>
                </div>
                <?php endif; ?>
				
                <?php if ($config_fields['city']['display'] ?? FALSE) : ?>
                <div class="control-group">
                  <div class="control-label name">
                    <label for="city">
                    <?php print JText::_('JSHOP_CITY')?> <?php if ($config_fields['city']['require']) : ?><span>*</span><?php endif; ?>
                  </div>
                  <div class="controls">
                    <input type="text" name="city" id="city" value="<?php print $this->user->city??''?>" class="input form-control <?php if ($config_fields['city']['require']):?>required<?php endif?>">
                  </div>
                </div>
                <?php endif; ?>
                
                <?php if ($config_fields['state']['display'] ?? FALSE) :  ?>
                <div class="control-group">
                  <div class="control-label name">
                    <label for="state">
                    <?php print JText::_('JSHOP_STATE')?> <?php if ($config_fields['state']['require']) : ?><span>*</span><?php endif; ?>
                    </label>
                  </div>
                  <div class="controls">
                    <input type="text" name="state" id="state" value="<?php print $this->user->state??''?>" class="input form-control <?php if ($config_fields['state']['require']):?>required<?php endif?>">
                  </div>
                </div>
                <?php endif; ?>
                
                <?php if ($config_fields['country']['display'] ?? FALSE) :  ?>
                <div class="control-group">
                  <div class="control-label name">
                    <label for="country">
                    <?php print JText::_('JSHOP_COUNTRY')?> <?php if ($config_fields['country']['require']) : ?><span>*</span><?php endif; ?>
                    </label>
                  </div>
                  <div class="controls">
                    <?php
                    if ($config_fields['country']['require']){
                        $attribs='class="inputbox form-control required"';
                    }else{
                        $attribs='class="inputbox form-control"';
                    }
                    ?>
                    <?php print Selects::getCountry($this->user->country??'', $attribs)?>
                  </div>
                </div>
                <?php endif; ?>
				
                <?php echo $this->_tmpl_address_html_3?>
                
                <?php if ($config_fields['ext_field_1']['display'] ?? FALSE) :  ?>
                <div class="control-group">
                  <div class="control-label name">
                    <label for="ext_field_1">
                    <?php print JText::_('JSHOP_EXT_FIELD_1')?> <?php if ($config_fields['ext_field_1']['require']) : ?><span>*</span><?php endif; ?>
                    </label>
                  </div>
                  <div class="controls">
                    <input type="text" name="ext_field_1" id="ext_field_1" value="<?php print $this->user->ext_field_1??''?>" class="input form-control <?php if ($config_fields['ext_field_1']['require']):?>required<?php endif?>">
                  </div>
                </div>
                <?php endif; ?>
                
                <?php if ($config_fields['ext_field_2']['display'] ?? FALSE) :  ?>
                <div class="control-group">
                  <div class="control-label name">
                    <label for="ext_field_2">
                    <?php print JText::_('JSHOP_EXT_FIELD_2')?> <?php if ($config_fields['ext_field_2']['require']) : ?><span>*</span><?php endif; ?>
                    </label>            
                  </div>
                  <div class="controls">
                    <input type="text" name="ext_field_2" id="ext_field_2" value="<?php print $this->user->ext_field_2??''?>" class="input form-control <?php if ($config_fields['ext_field_2']['require']):?>required<?php endif?>">
                  </div>
                </div>
                <?php endif; ?>
                
                <?php if ($config_fields['ext_field_3']['display'] ?? FALSE) :  ?>
                <div class="control-group">
                  <div class="control-label name">
                    <label for="ext_field_3">
                    <?php print JText::_('JSHOP_EXT_FIELD_3')?> <?php if ($config_fields['ext_field_3']['require']) : ?><span>*</span><?php endif; ?>
                    </label>
                  </div>
                  <div class="controls">
                    <input type="text" name="ext_field_3" id="ext_field_3" value="<?php print $this->user->ext_field_3??''?>" class="input form-control <?php if ($config_fields['ext_field_3']['require']):?>required<?php endif?>">
                  </div>
                </div>
                <?php endif; ?>
                
                
                
                <?php if ($config_fields['comment']['display']??TRUE){ // Изменено добавлено поле?>
                <div class = "control-group">
                    <div class = "control-label name">
                    <?php print JText::_('JSHOP_FIELD_COMMENT' )?> <?php if ($config_fields['comment']['require']??TRUE){?><span>*</span><?php } ?>
                    </div>
                    <div class = "controls">
                    <input type = "text" name= "comment" id = "comment" value = "<?php print $this->user->comment??'' ?>" class = "input form-control" />
                    </div>
                </div>
                <?php } ?>
                
                
                
                
                <?php echo $this->_tmpl_address_html_4?>
            </div>
            
            <?php if ($this->count_filed_delivery > 0){?>
            <div class = "control-group other_delivery_adress">
                <div class = "control-label name">
                    <?php print JText::_('JSHOP_DELIVERY_ADRESS')?>
                </div>
                <div class = "controls">
                    <input type = "radio" name = "delivery_adress" id = "delivery_adress_1" value = "0" <?php if (!$this->delivery_adress) {?> checked = "checked" <?php } ?>>
                    <label for = "delivery_adress_1"><?php print JText::_('JSHOP_NO')?></label>
                    <input type = "radio" name = "delivery_adress" id = "delivery_adress_2" value = "1" <?php if ($this->delivery_adress) {?> checked = "checked" <?php } ?>>
                    <label for = "delivery_adress_2"><?php print JText::_('JSHOP_YES')?></label>
                </div>
            </div>
            <?php }?>
            
            <div id = "div_delivery" class = "jshop_register" style="<?php if (!$this->delivery_adress){ ?>display:none;<?php } ?>">
            
                <?php if ($config_fields['d_title']['display'] ?? FALSE) :  ?>
                <div class="control-group">
                    <div class="control-label name">
                        <label for="d_title">
                        <?php print JText::_('JSHOP_REG_TITLE')?> <?php if ($config_fields['d_title']['require']) : ?><span>*</span><?php endif; ?>
                        </label>
                    </div>
                    <div class="controls">
                        <?php
                        if ($config_fields['d_title']['require']){
                            $attribs='class="inputbox form-control required-d"';
                        }else{
                            $attribs='class="inputbox form-control"';
                        }
                        ?>
                        <?php print Selects::getTitle($this->user->d_title??'', $attribs, 'd_title')?>
                    </div>
                </div>        
                <?php endif; ?>
				
                <?php if ($config_fields['d_f_name']['display'] ?? FALSE) :  ?>
                <div class="control-group">
                  <div class="control-label name">
                    <label for="d_f_name">
                        <?php print JText::_('JSHOP_F_NAME')?> <?php if ($config_fields['d_f_name']['require']) : ?><span>*</span><?php endif; ?>
                    </label>
                  </div>
                  <div class="controls">
                    <input type="text" name="d_f_name" id="d_f_name" value="<?php print $this->user->d_f_name??''?>" class="input form-control <?php if ($config_fields['d_f_name']['require']):?>required-d<?php endif?>">
                  </div>
                </div>
                <?php endif;?>
                
                <?php if ($config_fields['d_l_name']['display'] ?? FALSE) :  ?>
                <div class="control-group">
                  <div class="control-label name">
                    <label for="d_l_name">
                    <?php print JText::_('JSHOP_L_NAME')?> <?php if ($config_fields['d_l_name']['require']) : ?><span>*</span><?php endif; ?>
                    </label>
                  </div>
                  <div class="controls">
                    <input type="text" name="d_l_name" id="d_l_name" value="<?php print $this->user->d_l_name??''?>" class="input form-control <?php if ($config_fields['d_l_name']['require']):?>required-d<?php endif?>">
                  </div>
                </div>
                <?php endif; ?>
                
                <?php if ($config_fields['d_m_name']['display'] ?? FALSE) :  ?>
                <div class="control-group">
                  <div class="control-label name">
                    <label for="d_m_name">
                    <?php print JText::_('JSHOP_M_NAME')?> <?php if ($config_fields['d_m_name']['require']) : ?><span>*</span><?php endif; ?>
                    </label>
                  </div>
                  <div class="controls">
                    <input type="text" name="d_m_name" id="d_m_name" value="<?php print $this->user->d_m_name??''?>" class="input form-control <?php if ($config_fields['d_m_name']['require']):?>required-d<?php endif?>">
                  </div>
                </div>
                <?php endif; ?>
                
                
                                
                
                <?php if ($config_fields['d_FIO']['display'] ?? TRUE) : ?>
                <div class="control-group">
                  <div class="control-label name">
                    <label for="d_FIO">
                    <?php print JText::_('JSHOP_FIELD_FIO')?> <?php if ($config_fields['d_FIO']['require']??TRUE) : ?><span>*</span><?php endif; ?>
                    </label>
                  </div>
                  <div class="controls">
                    <input type="text" name="d_FIO" id="d_FIO" value="<?php print $this->user->d_FIO??''?>" class="input form-control <?php if ($config_fields['d_FIO']['require']??TRUE):?>required-d<?php endif?>">
                  </div>
                </div>
                <?php endif; ?>
                
                
                <?php if ($config_fields['d_firma_name']['display'] ?? FALSE) :  ?>
                <div class="control-group">
                  <div class="control-label name">
                    <label for="d_firma_name">
                    <?php print JText::_('JSHOP_FIRMA_NAME')?> <?php if ($config_fields['d_firma_name']['require']) : ?><span>*</span><?php endif; ?>
                    </label>
                  </div>
                  <div class="controls">
                    <input type="text" name="d_firma_name" id="d_firma_name" value="<?php print $this->user->d_firma_name??''?>" class="input form-control <?php if ($config_fields['d_firma_name']['require']):?>required-d<?php endif?>">
                  </div>
                </div>
                <?php endif; ?>
                
                <?php if ($config_fields['d_email']['display'] ?? TRUE) : ?>
                <div class="control-group">
                  <div class="control-label name">
                    <label for="d_email">
                    <?php print JText::_('JSHOP_EMAIL')?> <?php if ($config_fields['d_email']['require']??TRUE) : ?><span>*</span><?php endif; ?>
                    </label>
                  </div>
                  <div class="controls">
                    <input type="text" name="d_email" id="d_email" value="<?php print $this->user->d_email??''?>" class="input form-control validate-email <?php if ($config_fields['d_email']['require']??TRUE):?>required-d<?php endif?>">
                  </div>
                </div>
                <?php endif; ?>
				
                
                <?php if ($config_fields['d_phone']['display'] ?? TRUE) :  ?>
                <div class="control-group">
                  <div class="control-label name">
                    <label for="d_phone">
                    <?php print JText::_('JSHOP_TELEFON')?> <?php if ($config_fields['d_phone']['require']??TRUE) : ?><span>*</span><?php endif; ?>
                    </label>
                  </div>
                  <div class="controls">
                    <input type="text" name="d_phone" id="d_phone" value="<?php print $this->user->d_phone??''?>" class="input form-control <?php if ($config_fields['d_phone']['require']??TRUE):?>required-d<?php endif?>">
                  </div>
                </div>
                <?php endif; ?>
                
                <?php if ($config_fields['d_mobil_phone']['display'] ?? FALSE) :  ?>
                <div class="control-group">
                  <div class="control-label name">
                    <label for="d_mobil_phone">
                    <?php print JText::_('JSHOP_MOBIL_PHONE')?> <?php if ($config_fields['d_mobil_phone']['require']) : ?><span>*</span><?php endif; ?>
                    </label>
                  </div>
                  <div class="controls">
                    <input type="text" name="d_mobil_phone" id="d_mobil_phone" value="<?php print $this->user->d_mobil_phone??''?>" class="input form-control <?php if ($config_fields['d_mobil_phone']['require']):?>required-d<?php endif?>">
                  </div>
                </div>
                <?php endif; ?>
                
                <?php if ($config_fields['d_fax']['display'] ?? FALSE) :  ?>
                <div class="control-group">
                  <div class="control-label name">
                    <label for="d_fax">
                    <?php print JText::_('JSHOP_FAX')?> <?php if ($config_fields['d_fax']['require']) : ?><span>*</span><?php endif; ?>
                    </label>
                  </div>
                  <div class="controls">
                    <input type="text" name="d_fax" id="d_fax" value="<?php print $this->user->d_fax??''?>" class="input form-control <?php if ($config_fields['d_fax']['require']):?>required-d<?php endif?>">
                  </div>
                </div>
                <?php endif; ?>
                
                <?php if ($config_fields['d_birthday']['display'] ?? FALSE) :  ?>
                <div class="control-group">
                  <div class="control-label name">
                    <label for="d_birthday">
                    <?php print JText::_('JSHOP_BIRTHDAY')?> <?php if ($config_fields['d_birthday']['require']) : ?><span>*</span><?php endif; ?>
                    </label>
                  </div>
                  <div class="controls">
                    <?php 
                    $params=array('class'=>'input', 'size'=>'25', 'maxlength'=>'19','showTime'=>true);
                    if ($config_fields['d_birthday']['require']){
                        $params['class']='input required-d';
                    }
                    ?>
                    <?php echo \JHTML::_('calendar', $this->user->d_birthday??'', 'd_birthday', 'd_birthday', $this->config->field_birthday_format, $params);?>
                  </div>
                </div>
                <?php endif; ?>
				
                <?php echo $this->_tmpl_address_html_5?>
                
				
                
                <?php if ($config_fields['d_shiping_date']['display'] ?? FALSE) :  ?>
                <div class="control-group">
                  <div class="control-label name">
                    <label for="d_shiping_date">
                    <?php print JText::_('JSHOP_FIELD_SHIPING_DATE')?> <?php if ($config_fields['d_shiping_date']['require']) : ?><span>*</span><?php endif; ?>
                    </label>
                  </div>
                  <div class="controls">
                    <input type="text" name="d_shiping_date" id="d_shiping_date" value="<?php print $this->user->d_shiping_date??''?>" class="input form-control <?php if ($config_fields['d_shiping_date']['require']):?>required-d<?php endif?>">
                  </div>
                </div>
                <?php endif; ?>
                
                <?php if ($config_fields['d_shiping_time']['display'] ?? FALSE) :  ?>
                <div class="control-group">
                  <div class="control-label name">
                    <label for="d_shiping_time">
                    <?php print JText::_('JSHOP_FIELD_SHIPING_TIME')?> <?php if ($config_fields['d_shiping_time']['require']) : ?><span>*</span><?php endif; ?>
                    </label>
                  </div>
                  <div class="controls">
                    <input type="text" name="d_shiping_time" id="d_shiping_time" value="<?php print $this->user->d_shiping_time??''?>" class="input form-control <?php if ($config_fields['d_shiping_time']['require']):?>required-d<?php endif?>">
                  </div>
                </div>
                <?php endif; ?>
				
                <?php if ($config_fields['d_street']['display'] ?? FALSE) :  ?>
                <div class="control-group">
                  <div class="control-label name">
                    <label for="d_street">
                    <?php print JText::_('JSHOP_STREET_NR')?> <?php if ($config_fields['d_street']['require']) : ?><span>*</span><?php endif; ?>
                    </label>
                  </div>
                  <div class="controls">
                    <input type="text" name="d_street" id="d_street" value="<?php print $this->user->d_street?>" class="input form-control <?php if ($config_fields['d_street']['require']):?>required-d<?php endif?>">
                    <?php if ($config_fields['d_street_nr']['display']){?>
                    <input type="text" name="d_street_nr" id="d_street_nr" value="<?php print $this->user->d_street_nr??''?>" class="input form-control <?php if ($config_fields['d_street_nr']['require']):?>required-d<?php endif?>"            >
                    <?php }?>
                  </div>
                </div>
                <?php endif; ?>
                
                
                
                
                <?php if ($config_fields['d_home']['display'] ?? FALSE) :  ?>
                <div class="control-group">
                  <div class="control-label name">
                    <label for="d_home">
                    <?php print JText::_('JSHOP_HOME')?> <?php if ($config_fields['d_home']['require']) : ?><span>*</span><?php endif; ?>
                    </label>
                  </div>
                  <div class="controls">
                    <input type="text" name="d_home" id="d_home" value="<?php print $this->user->d_home??''?>" class="input form-control <?php if ($config_fields['d_home']['require']):?>required-d<?php endif?>">
                  </div>
                </div>
                <?php endif; ?>
                
                
                
                                
                
                <?php if ($config_fields['d_housing']['display'] ?? FALSE) :  ?>
                <div class="control-group">
                  <div class="control-label name">
                    <label for="d_housing">
                    <?php print JText::_('JSHOP_FIELD_HOUSING')?> <?php if ($config_fields['d_housing']['require']) : ?><span>*</span><?php endif; ?>
                    </label>
                  </div>
                  <div class="controls">
                    <input type="text" name="d_housing" id="d_housing" value="<?php print $this->user->d_housing??''?>" class="input form-control <?php if ($config_fields['d_housing']['require']):?>required-d<?php endif?>">
                  </div>
                </div>
                <?php endif; ?>
                
                <?php if ($config_fields['d_porch']['display'] ?? FALSE) :  ?>
                <div class="control-group">
                  <div class="control-label name">
                    <label for="d_porch">
                    <?php print JText::_('JSHOP_FIELD_PORCH')?> <?php if ($config_fields['d_porch']['require']) : ?><span>*</span><?php endif; ?>
                    </label>
                  </div>
                  <div class="controls">
                    <input type="text" name="d_porch" id="d_porch" value="<?php print $this->user->d_porch??''?>" class="input form-control <?php if ($config_fields['d_porch']['require']):?>required-d<?php endif?>">
                  </div>
                </div>
                <?php endif; ?>
                
                <?php if ($config_fields['d_intercom']['display'] ?? FALSE) :  ?>
                <div class="control-group">
                  <div class="control-label name">
                    <label for="d_intercom">
                    <?php print JText::_('JSHOP_FIELD_INTERCOM')?> <?php if ($config_fields['d_intercom']['require']) : ?><span>*</span><?php endif; ?>
                    </label>
                  </div>
                  <div class="controls">
                    <input type="text" name="d_intercom" id="d_intercom" value="<?php print $this->user->d_intercom??''?>" class="input form-control <?php if ($config_fields['d_intercom']['require']):?>required-d<?php endif?>">
                  </div>
                </div>
                <?php endif; ?>
                
                <?php if ($config_fields['d_level']['display'] ?? FALSE) :  ?>
                <div class="control-group">
                  <div class="control-label name">
                    <label for="d_level">
                    <?php print JText::_('JSHOP_FIELD_LEVEL')?> <?php if ($config_fields['d_level']['require']) : ?><span>*</span><?php endif; ?>
                    </label>
                  </div>
                  <div class="controls">
                    <input type="text" name="d_level" id="d_level" value="<?php print $this->user->d_level??''?>" class="input form-control <?php if ($config_fields['d_level']['require']):?>required-d<?php endif?>">
                  </div>
                </div>
                <?php endif; ?>
                
                
                
                
                
                
                
                <?php if ($config_fields['d_apartment']['display'] ?? FALSE) :  ?>
                <div class="control-group">
                  <div class="control-label name">
                    <label for="d_apartment">
                    <?php print JText::_('JSHOP_APARTMENT')?> <?php if ($config_fields['d_apartment']['require']) : ?><span>*</span><?php endif; ?>
                    </label>
                  </div>
                  <div class="controls">
                    <input type="text" name="d_apartment" id="d_apartment" value="<?php print $this->user->d_apartment??''?>" class="input form-control <?php if ($config_fields['d_apartment']['require']):?>required-d<?php endif?>">
                  </div>
                </div>
                <?php endif; ?>
                

                
                
                
                
                
                
                <?php if ($config_fields['d_metro']['display'] ?? FALSE) :  ?>
                <div class="control-group">
                  <div class="control-label name">
                    <label for="d_apartment">
                    <?php print JText::_('JSHOP_FIELD_METRO')?> <?php if ($config_fields['d_metro']['require']) : ?><span>*</span><?php endif; ?>
                    </label>
                  </div>
                  <div class="controls">
                    <input type="text" name="d_metro" id="d_metro" value="<?php print $this->user->d_metro??''?>" class="input form-control <?php if ($config_fields['d_metro']['require']):?>required-d<?php endif?>">
                  </div>
                </div>
                <?php endif; ?>
                
                <?php if ($config_fields['d_transport_name']['display'] ?? FALSE) :  ?>
                <div class="control-group">
                  <div class="control-label name">
                    <label for="d_transport_name">
                    <?php print JText::_('JSHOP_FIELD_TRANSPORT_NAME')?> <?php if ($config_fields['d_transport_name']['require']) : ?><span>*</span><?php endif; ?>
                    </label>
                  </div>
                  <div class="controls">
                    <input type="text" name="d_transport_name" id="d_transport_name" value="<?php print $this->user->d_transport_name??''?>" class="input form-control <?php if ($config_fields['d_transport_name']['require']):?>required-d<?php endif?>">
                  </div>
                </div>
                <?php endif; ?>
                
                <?php if ($config_fields['d_transport_no']['display'] ?? FALSE) :  ?>
                <div class="control-group">
                  <div class="control-label name">
                    <label for="d_transport_no">
                    <?php print JText::_('JSHOP_FIELD_TRANSPORT_NO')?> <?php if ($config_fields['d_transport_no']['require']) : ?><span>*</span><?php endif; ?>
                    </label>
                  </div>
                  <div class="controls">
                    <input type="text" name="d_transport_no" id="d_transport_no" value="<?php print $this->user->d_transport_no??''?>" class="input form-control <?php if ($config_fields['d_transport_no']['require']):?>required-d<?php endif?>">
                  </div>
                </div>
                <?php endif; ?>
                
                <?php if ($config_fields['d_track_stop']['display'] ?? FALSE) :  ?>
                <div class="control-group">
                  <div class="control-label name">
                    <label for="d_track_stop">
                    <?php print JText::_('JSHOP_FIELD_TRACK_STOP')?> <?php if ($config_fields['d_track_stop']['require']) : ?><span>*</span><?php endif; ?>
                    </label>
                  </div>
                  <div class="controls">
                    <input type="text" name="d_track_stop" id="d_track_stop" value="<?php print $this->user->d_track_stop??''?>" class="input form-control <?php if ($config_fields['d_track_stop']['require']):?>required-d<?php endif?>">
                  </div>
                </div>
                <?php endif; ?>
                
                
                
                
                
                
                
                
                
                
                
                
                
                <?php if ($config_fields['d_zip']['display'] ?? FALSE) :  ?>
                <div class="control-group">
                  <div class="control-label name">
                    <label for="d_zip">
                    <?php print JText::_('JSHOP_ZIP')?> <?php if ($config_fields['d_zip']['require']) : ?><span>*</span><?php endif; ?>
                    </label>
                  </div>
                  <div class="controls">
                    <input type="text" name="d_zip" id="d_zip" value="<?php print $this->user->d_zip??''?>" class="input form-control <?php if ($config_fields['d_zip']['require']):?>required-d<?php endif?>">
                  </div>
                </div>
                <?php endif; ?>
                
                <?php if ($config_fields['d_city']['display'] ?? FALSE) :  ?>
                <div class="control-group">
                  <div class="control-label name">
                    <label for="d_city">
                    <?php print JText::_('JSHOP_CITY')?> <?php if ($config_fields['d_city']['require']) : ?><span>*</span><?php endif; ?>
                  </div>
                  <div class="controls">
                    <input type="text" name="d_city" id="d_city" value="<?php print $this->user->d_city??''?>" class="input form-control <?php if ($config_fields['d_city']['require']):?>required-d<?php endif?>">
                  </div>
                </div>
                <?php endif; ?>
                
                <?php if ($config_fields['d_state']['display'] ?? FALSE) :  ?>
                <div class="control-group">
                  <div class="control-label name">
                    <label for="d_state">
                    <?php print JText::_('JSHOP_STATE')?> <?php if ($config_fields['d_state']['require']) : ?><span>*</span><?php endif; ?>
                    </label>
                  </div>
                  <div class="controls">
                    <input type="text" name="d_state" id="d_state" value="<?php print $this->user->d_state??''?>" class="input form-control <?php if ($config_fields['d_state']['require']):?>required-d<?php endif?>">
                  </div>
                </div>
                <?php endif; ?>
                
                <?php if ($config_fields['d_country']['display'] ?? FALSE) :  ?>
                <div class="control-group">
                  <div class="control-label name">
                    <label for="d_country">
                    <?php print JText::_('JSHOP_COUNTRY')?> <?php if ($config_fields['d_country']['require']) : ?><span>*</span><?php endif; ?>
                    </label>
                  </div>
                  <div class="controls">
                    <?php
                    if ($config_fields['d_country']['require']){
                        $attribs='class="inputbox form-control required-d"';
                    }else{
                        $attribs='class="inputbox form-control"';
                    }
                    ?>
                    <?php print Selects::getCountry($this->user->d_country??'', $attribs, 'd_country')?>
                  </div>
                </div>
                <?php endif; ?>
				
                <?php echo $this->_tmpl_address_html_6?>
                
                <?php if ($config_fields['d_ext_field_1']['display'] ?? FALSE) :  ?>
                <div class="control-group">
                  <div class="control-label name">
                    <label for="d_ext_field_1">
                    <?php print JText::_('JSHOP_EXT_FIELD_1')?> <?php if ($config_fields['d_ext_field_1']['require']) : ?><span>*</span><?php endif; ?>
                    </label>
                  </div>
                  <div class="controls">
                    <input type="text" name="d_ext_field_1" id="d_ext_field_1" value="<?php print $this->user->d_ext_field_1??''?>" class="input form-control <?php if ($config_fields['d_ext_field_1']['require']):?>required-d<?php endif?>">
                  </div>
                </div>
                <?php endif; ?>
                
                <?php if ($config_fields['d_ext_field_2']['display'] ?? FALSE) :  ?>
                <div class="control-group">
                  <div class="control-label name">
                    <label for="d_ext_field_2">
                    <?php print JText::_('JSHOP_EXT_FIELD_2')?> <?php if ($config_fields['d_ext_field_2']['require']) : ?><span>*</span><?php endif; ?>
                    </label>            
                  </div>
                  <div class="controls">
                    <input type="text" name="d_ext_field_2" id="d_ext_field_2" value="<?php print $this->user->d_ext_field_2??''?>" class="input form-control <?php if ($config_fields['d_ext_field_2']['require']):?>required-d<?php endif?>">
                  </div>
                </div>
                <?php endif; ?>
                
                <?php if ($config_fields['d_ext_field_3']['display'] ?? FALSE) :  ?>
                <div class="control-group">
                  <div class="control-label name">
                    <label for="d_ext_field_3">
                    <?php print JText::_('JSHOP_EXT_FIELD_3')?> <?php if ($config_fields['d_ext_field_3']['require']) : ?><span>*</span><?php endif; ?>
                    </label>
                  </div>
                  <div class="controls">
                    <input type="text" name="d_ext_field_3" id="d_ext_field_3" value="<?php print $this->user->d_ext_field_3??''?>" class="input form-control <?php if ($config_fields['d_ext_field_3']['require']):?>required-d<?php endif?>">
                  </div>
                </div>
                <?php endif; ?>  
                
                
                
                <?php if ($config_fields['d_comment']['display']??TRUE){ // Изменено добавлено поле?>
                <div class = "control-group">
                    <div class = "control-label name">
                    <?php print JText::_('JSHOP_FIELD_COMMENT' )?> <?php if ($config_fields['d_comment']['require']??TRUE){?><span>*</span><?php } ?>
                    </div>
                    <div class = "controls">
                    <input type = "text" name = "d_comment" id = "d_comment" value = "<?php print $this->user->d_comment??'' ?>" class = "input form-control" />
                    </div>
                </div>
                <?php } ?>
                
                <?php echo $this->_tmpl_address_html_7?>
            </div>
            
            <?php if ($config_fields['privacy_statement']['display'] ?? FALSE) :  ?>
            <div class="jshop_block_privacy_statement">
                <div class="control-group">
                  <div class="control-label name">
                    <label for="privacy_statement">
                    <a class="privacy_statement" href="#" onclick="window.open('<?php print \JSHelper::SEFLink('index.php?option=com_jshopping&controller=content&task=view&page=privacy_statement&tmpl=component', 1);?>','window','width=800, height=600, scrollbars=yes, status=no, toolbar=no, menubar=no, resizable=yes, location=no');return false;">
                    <?php print JText::_('JSHOP_PRIVACY_STATEMENT')?> <?php if ($config_fields['privacy_statement']['require']) : ?><span>*</span><?php endif; ?>
                    </a>            
                    </label>
                  </div>
                  <div class="controls">
                    <input type="checkbox" name="privacy_statement" id="privacy_statement" value="1" <?php if ($config_fields['privacy_statement']['require']):?>required<?php endif?> >
                  </div>
                </div>
            </div>
            <?php endif; ?>    
            
            <?php print $this->_tmp_ext_html_address_end?>
            
            <div class = "control-group box_button">
                <div class = "controls">
                    <?php echo $this->_tmpl_address_html_8?>
                    <div class="requiredtext">* <?php print JText::_('JSHOP_REQUIRED')?></div>
                    <?php echo $this->_tmpl_address_html_9?>
                    <input type = "submit" class="btn btn-success" name = "next" value = "<?php print JText::_('JSHOP_NEXT')?>" class = "btn btn-primary button" />
                </div>
            </div>
        </form>
    </div>
</div>