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
use Joomla\Component\Jshopping\Site\Helper\Helper as JSHelper;
defined('_JEXEC') or die;

//toPrint($this->invoice_info,'$this->invoice_info:', 0,'message',true);
//toPrint($this->delivery_info,'$this->delivery_info:', 0,'message',true);
?>
<div id="comjshop">
    <?php print $this->checkout_navigator?>
    <?php print $this->small_cart?>
    
    <div class="jshop checkout_pfinish_block">
        <?php print $this->_tmp_ext_html_previewfinish_start??''?>
        
        <div class="checkoutinfo">
            <div class="bill_address">
               <strong><?php print JText::_('JSHOP_BILL_ADDRESS')?></strong>:
               <span>
               <?php if ($this->invoice_info['firma_name']??'') print $this->invoice_info['firma_name'].", ";?> 

<?php echo $this->adv_user->d_FIO ?: $this->adv_user->FIO ?: ''; // Изменено Добавлено ?> 

               <?php print $this->invoice_info['f_name']??'' ?> 
               <?php print $this->invoice_info['l_name']??'' ?>, 
<?php echo $this->adv_user->d_email ?: $this->adv_user->email ?: ''; // Изменено Добавлено ?> 
               <?php if (($this->invoice_info['street']??'') && $this->invoice_info['street_nr']??'') print $this->invoice_info['street']." ".$this->invoice_info['street_nr'].","?>
               <?php if (($this->invoice_info['street']??'') && !$this->invoice_info['street_nr']??'') print $this->invoice_info['street'].","?>
               
                    <?php if($this->invoice_info['home']??'')      echo JText::_('JSHOP_HOME_S')           .$this->invoice_info['home'].","       // Изменено Изменено ?>
                    <?php if($this->invoice_info['apartment']??'')  echo JText::_('JSHOP_APARTMENT_S')  .$this->invoice_info['apartment'].","; // Изменено Изменено ?>
                    <?php if($this->user->housing??'')        echo JText::_('JSHOP_FIELD_HOUSING')        .$this->user->housing.","; // Изменено Добавлено ?>
                    <?php if($this->user->porch??'')          echo JText::_('JSHOP_PORCH_S')          .$this->user->porch.","; // Изменено Добавлено ?>
                    <?php if($this->user->intercom??'')       echo JText::_('JSHOP_INTERCOM_S')       .$this->user->intercom.","; // Изменено Добавлено ?>
                    <?php if($this->user->level??'')          echo JText::_('JSHOP_LEVEL_S')          .$this->user->level.","; // Изменено Добавлено ?>
                    <?php if($this->user->metro??'')          echo JText::_('JSHOP_METRO_S')          .$this->user->metro.","; // Изменено Добавлено ?>
                    <?php if($this->user->transport_name??'') echo JText::_('JSHOP_TRANSPORT_NAME_S') .$this->user->transport_name.","; // Изменено Добавлено ?>
                    <?php if($this->user->transport_no??'')   echo JText::_('JSHOP_TRANSPORT_NO_S')   .$this->user->transport_no.","; // Изменено Добавлено ?>
                    <?php if($this->user->track_stop??'')     echo JText::_('JSHOP_TRANSPORT_STOP_S') .$this->user->track_stop.","; // Изменено Добавлено ?> 
               <?php if ($this->invoice_info['state']??'') print $this->invoice_info['state']."," ?> 
               <?php print $this->invoice_info['zip']." ".$this->invoice_info['city']." ".$this->invoice_info['country']?>
			   <?php if ($this->invoice_info['email'] && $this->config->checkout_step5_show_email) print $this->invoice_info['email']?>
               <?php if ($this->invoice_info['phone'] && $this->config->checkout_step5_show_phone) print $this->invoice_info['phone']?> 
               </span>
            </div>
            
            <?php if ($this->count_filed_delivery){?>
            <div class="delivery_address">
                <strong><?php print JText::_('JSHOP_FINISH_DELIVERY_ADRESS')?></strong>: 
                <span>
                <?php if ($this->delivery_info['firma_name']) print $this->delivery_info['firma_name'].", ";?> 
<?php echo $this->adv_user->d_FIO ?: $this->adv_user->FIO ?: ''; // Изменено Добавлено ?> 
                <?php print $this->delivery_info['f_name'] ?> 
                <?php print $this->delivery_info['l_name'] ?>,
<?php echo $this->adv_user->d_email ?: $this->adv_user->email ?: ''; // Изменено Добавлено ?> 
                <?php if ($this->delivery_info['street'] && $this->delivery_info['street_nr']) print $this->delivery_info['street']." ".$this->delivery_info['street_nr'].","?>
                <?php if ($this->delivery_info['street'] && !$this->delivery_info['street_nr']) print $this->delivery_info['street'].","?>
                <?php // if ($this->delivery_info['home'] && $this->delivery_info['apartment']) print $this->delivery_info['home']."/".$this->delivery_info['apartment'].","?>
                <?php // if ($this->delivery_info['home'] && !$this->delivery_info['apartment']) print $this->delivery_info['home'].","?>
                    <?php if($this->delivery_info['home'] )     echo JText::_('JSHOP_HOME_S')      .$this->delivery_info['home'].","        // Изменено Изменено ?>
                    <?php if($this->delivery_info['apartment']) echo JText::_('JSHOP_APARTMENT_S') .$this->delivery_info['apartment'].",";  // Изменено Изменено ?>
                       
                       
                    <?php if($this->user->d_housing??'')        echo JText::_('JSHOP_FIELD_HOUSING')        .$this->user->d_housing.","; // Изменено Добавлено ?>
                    <?php if($this->user->d_porch??'')          echo JText::_('JSHOP_PORCH_S')          .$this->user->d_porch.","; // Изменено Добавлено ?>
                    <?php if($this->user->d_intercom??'')       echo JText::_('JSHOP_INTERCOM_S')       .$this->user->d_intercom.","; // Изменено Добавлено ?>
                    <?php if($this->user->d_level??'')          echo JText::_('JSHOP_LEVEL_S')          .$this->user->d_level.","; // Изменено Добавлено ?>
                    <?php if($this->user->d_metro??'')          echo JText::_('JSHOP_METRO_S')          .$this->user->d_metro.","; // Изменено Добавлено ?>
                    <?php if($this->user->d_transport_name??'') echo JText::_('JSHOP_TRANSPORT_NAME_S') .$this->user->d_transport_name.","; // Изменено Добавлено ?>
                    <?php if($this->user->d_transport_no??'')   echo JText::_('JSHOP_TRANSPORT_NO_S')   .$this->user->d_transport_no.","; // Изменено Добавлено ?>
                    <?php if($this->user->d_track_stop??'')     echo JText::_('JSHOP_TRANSPORT_STOP_S') .$this->user->d_track_stop.","; // Изменено Добавлено ?> 
                <?php if ($this->delivery_info['state']??'') print $this->delivery_info['state']."," ?> 
                <?php print $this->delivery_info['zip']." ".$this->delivery_info['city']." ".$this->delivery_info['country']?>
                </span>
            </div>
            <?php }?>
            
            <?php if (!$this->config->without_shipping){?>  
                <div class="shipping_info">
                    <strong><?php print JText::_('JSHOP_FINISH_SHIPPING_METHOD')?></strong>: 
                    <span><?php print $this->sh_method->name?></span>
                    <?php if ($this->delivery_time){?>
                        <div class="delivery_time"><strong><?php print JText::_('JSHOP_DELIVERY_TIME')?></strong>: 
                        <span><?php print $this->delivery_time?></span></div>
                    <?php }?>
                    <?php if ($this->delivery_date){?>
                        <div class="delivery_date"><strong><?php print JText::_('JSHOP_DELIVERY_DATE')?></strong>: 
                        <span><?php print $this->delivery_date?></span></div>
                    <?php }?>
                </div>
            <?php } ?>
            
            <?php if (!$this->config->without_payment){?>  
                <div class="payment_info">
                   <strong><?php print JText::_('JSHOP_FINISH_PAYMENT_METHOD')?></strong>: <span><?php print $this->payment_name ?></span>
                </div>
            <?php } ?>
        </div>

        <form name = "form_finish" action = "<?php print $this->action ?>" method = "post" enctype="multipart/form-data">
            <div class="pfinish_comment_block">             
                <div class="name"><?php print JText::_('JSHOP_ADD_INFO')?></div>
                <div class="field"><textarea class = "inputbox form-control" id = "order_add_info" name = "order_add_info"></textarea></div>

                <?php if ($this->config->display_agb){?>                 
                    <div class="row_agb">            
                        <input type = "checkbox" name="agb" id="agb" />        
                        <a class = "policy" href="#" onclick="window.open('<?php print JSHelper::SEFLink('index.php?option=com_jshopping&controller=content&task=view&page=agb&tmpl=component', 1);?>','window','width=800, height=600, scrollbars=yes, status=no, toolbar=no, menubar=no, resizable=yes, location=no');return false;"><?php print JText::_('JSHOP_AGB')?></a>
                        <?php print JText::_('JSHOP_AND')?>
                        <a class = "policy" href="#" onclick="window.open('<?php print JSHelper::SEFLink('index.php?option=com_jshopping&controller=content&task=view&page=return_policy&tmpl=component&cart=1', 1);?>','window','width=800, height=600, scrollbars=yes, status=no, toolbar=no, menubar=no, resizable=yes, location=no');return false;"><?php print JText::_('JSHOP_RETURN_POLICY')?></a>
                        <?php print JText::_('JSHOP_CONFIRM')?>        
                    </div>
                <?php }?>
                
                <?php if($this->no_return){?>                
                    <div class="row_no_return">            
                        <input type = "checkbox" name="no_return" id="no_return" />        
                        <?php print JText::_('JSHOP_NO_RETURN_DESCRIPTION')?>     
                    </div>
                <?php }?>
                
                <?php print $this->_tmp_ext_html_previewfinish_agb?>
                <div class="box_button"> 
			        <?php print $this->_tmp_ext_html_previewfinish_before_button?>
                    <input class="btn btn-success button" id="previewfinish_btn" type="submit" name="finish_registration" value="<?php print JText::_('JSHOP_ORDER_FINISH')?>" data-agb="<?php echo $this->config->display_agb;?>" data-noreturn="<?php echo $this->no_return?>">
                </div>
            </div> 
            <?php print $this->_tmp_ext_html_previewfinish_end?>
        </form>
        
    </div>
</div>