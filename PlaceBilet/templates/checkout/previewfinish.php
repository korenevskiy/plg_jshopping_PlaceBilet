<?php 
/**
* @version      4.8.0 13.08.2013
* @author       MAXXmarketing GmbH
* @package      Jshopping
* @copyright    Copyright (C) 2010 webdesigner-profi.de. All rights reserved.
* @license      GNU/GPL
*/
defined('_JEXEC') or die('Restricted access');
?>
<div id="comjshop">
        <h2><?php print JText::_('JSHOP_ORDER_SUBMIT' )?></h2>
    <?php print $this->checkout_navigator?>
    <?php print $this->small_cart?>
    
    <div class="jshop checkout_pfinish_block">
        <?php print $this->_tmp_ext_html_previewfinish_start?>
        
        <div class="checkoutinfo">
            <div class="bill_address">
               <strong><?php print _JSHOP_BILL_ADDRESS?></strong>:
               <span>
               <?php if ($this->invoice_info['firma_name']) print $this->invoice_info['firma_name'].", ";?> 
               <?php print $this->invoice_info['f_name'] ?> 
               <?php print $this->invoice_info['l_name'];?> 
                    <?php echo  $this->user->FIO.", "; // Изменено Добавлено ?> 
                    
               <?php if ($this->invoice_info['street'] && $this->invoice_info['street_nr']) print $this->invoice_info['street']." ".$this->invoice_info['street_nr'].","?>
               <?php if ($this->invoice_info['street'] && !$this->invoice_info['street_nr']) print $this->invoice_info['street'].","?>
               
                    <?php if($this->invoice_info['home'] )      echo JText::_('JSHOP_HOME_S')           .$this->invoice_info['home'].","       // Изменено Изменено ?>
                    <?php if($this->invoice_info['apartment'])  echo JText::_('JSHOP_APARTMENT_S')  .$this->invoice_info['apartment'].","; // Изменено Изменено ?>
                    <?php if($this->user->housing)        echo JText::_('JSHOP_HOUSING_S')        .$this->user->housing.","; // Изменено Добавлено ?>
                    <?php if($this->user->porch)          echo JText::_('JSHOP_PORCH_S')          .$this->user->porch.","; // Изменено Добавлено ?>
                    <?php if($this->user->intercom)       echo JText::_('JSHOP_INTERCOM_S')       .$this->user->intercom.","; // Изменено Добавлено ?>
                    <?php if($this->user->level)          echo JText::_('JSHOP_LEVEL_S')          .$this->user->level.","; // Изменено Добавлено ?>
                    <?php if($this->user->metro)          echo JText::_('JSHOP_METRO_S')          .$this->user->metro.","; // Изменено Добавлено ?>
                    <?php if($this->user->transport_name) echo JText::_('JSHOP_TRANSPORT_NAME_S') .$this->user->transport_name.","; // Изменено Добавлено ?>
                    <?php if($this->user->transport_no)   echo JText::_('JSHOP_TRANSPORT_NO_S')   .$this->user->transport_no.","; // Изменено Добавлено ?>
                    <?php if($this->user->track_stop)     echo JText::_('JSHOP_TRANSPORT_STOP_S') .$this->user->track_stop.","; // Изменено Добавлено ?> 
               <?php if ($this->invoice_info['state']) print $this->invoice_info['state']."," ?> 
               <?php print $this->invoice_info['zip']." ".$this->invoice_info['city']." ".$this->invoice_info['country']?>
               </span>
            </div>
            
            <?php if ($this->count_filed_delivery){?>
                <div class="delivery_address">
                   <strong><?php print _JSHOP_FINISH_DELIVERY_ADRESS?></strong>: 
                   <span>
                <?php if ($this->delivery_info['firma_name']) print $this->delivery_info['firma_name'].", ";?> 
                <?php print $this->delivery_info['f_name'] ?> 
                <?php print $this->delivery_info['l_name'] ?>
                    <?php echo $this->user->d_FIO.", "; // Изменено Добавлено ?> 
                <?php if ($this->delivery_info['street'] && $this->delivery_info['street_nr']) print $this->delivery_info['street']." ".$this->delivery_info['street_nr'].","?>
                <?php if ($this->delivery_info['street'] && !$this->delivery_info['street_nr']) print $this->delivery_info['street'].","?>
                <?php // if ($this->delivery_info['home'] && $this->delivery_info['apartment']) print $this->delivery_info['home']."/".$this->delivery_info['apartment'].","?>
                <?php // if ($this->delivery_info['home'] && !$this->delivery_info['apartment']) print $this->delivery_info['home'].","?>
                    <?php if($this->delivery_info['home'] )     echo JText::_('JSHOP_HOME_S')      .$this->delivery_info['home'].","        // Изменено Изменено ?>
                    <?php if($this->delivery_info['apartment']) echo JText::_('JSHOP_APARTMENT_S') .$this->delivery_info['apartment'].",";  // Изменено Изменено ?>
                       
                       
                    <?php if($this->user->d_housing)        echo JText::_('JSHOP_HOUSING_S')        .$this->user->d_housing.","; // Изменено Добавлено ?>
                    <?php if($this->user->d_porch)          echo JText::_('JSHOP_PORCH_S')          .$this->user->d_porch.","; // Изменено Добавлено ?>
                    <?php if($this->user->d_intercom)       echo JText::_('JSHOP_INTERCOM_S')       .$this->user->d_intercom.","; // Изменено Добавлено ?>
                    <?php if($this->user->d_level)          echo JText::_('JSHOP_LEVEL_S')          .$this->user->d_level.","; // Изменено Добавлено ?>
                    <?php if($this->user->d_metro)          echo JText::_('JSHOP_METRO_S')          .$this->user->d_metro.","; // Изменено Добавлено ?>
                    <?php if($this->user->d_transport_name) echo JText::_('JSHOP_TRANSPORT_NAME_S') .$this->user->d_transport_name.","; // Изменено Добавлено ?>
                    <?php if($this->user->d_transport_no)   echo JText::_('JSHOP_TRANSPORT_NO_S')   .$this->user->d_transport_no.","; // Изменено Добавлено ?>
                    <?php if($this->user->d_track_stop)     echo JText::_('JSHOP_TRANSPORT_STOP_S') .$this->user->d_track_stop.","; // Изменено Добавлено ?> 
                <?php if ($this->delivery_info['state']) print $this->delivery_info['state']."," ?> 
                <?php print $this->delivery_info['zip']." ".$this->delivery_info['city']." ".$this->delivery_info['country']?>
                   </span>
                </div>
            <?php }?>
            
            <?php if (!$this->config->without_shipping){?>  
                <div class="shipping_info">
                    <strong><?php print _JSHOP_FINISH_SHIPPING_METHOD?></strong>: 
                    <span><?php print $this->sh_method->name?></span>
                    <?php if ($this->delivery_time){?>
                        <div class="delivery_time"><strong><?php print _JSHOP_DELIVERY_TIME?></strong>: 
                        <span><?php print $this->delivery_time?></span></div>
                    <?php }?>
                    <?php if ($this->delivery_date){?>
                        <div class="delivery_date"><strong><?php print _JSHOP_DELIVERY_DATE?></strong>: 
                        <span><?php print $this->delivery_date?></span></div>
                    <?php }?>
                </div>
            <?php } ?>
            
            <?php if (!$this->config->without_payment){?>  
                <div class="payment_info">
                   <strong><?php print _JSHOP_FINISH_PAYMENT_METHOD ?></strong>: <span><?php print $this->payment_name ?></span>
                </div>
            <?php } ?>
        </div>

        <form name = "form_finish" action = "<?php print $this->action ?>" method = "post" enctype="multipart/form-data">
            <div class="pfinish_comment_block">             
                <div class="name"><?php print _JSHOP_ADD_INFO ?></div>
                <div class="field"><textarea class = "inputbox" id = "order_add_info" name = "order_add_info"></textarea></div>

                <?php if ($this->config->display_agb){?>                 
                    <div class="row_agb">            
                        <input type = "checkbox" name="agb" id="agb" />        
                        <a class = "policy" href="#" onclick="window.open('<?php print SEFLink('index.php?option=com_jshopping&controller=content&task=view&page=agb&tmpl=component', 1);?>','window','width=800, height=600, scrollbars=yes, status=no, toolbar=no, menubar=no, resizable=yes, location=no');return false;"><?php print _JSHOP_AGB;?></a>
                        <?php print _JSHOP_AND;?>
                        <a class = "policy" href="#" onclick="window.open('<?php print SEFLink('index.php?option=com_jshopping&controller=content&task=view&page=return_policy&tmpl=component&cart=1', 1);?>','window','width=800, height=600, scrollbars=yes, status=no, toolbar=no, menubar=no, resizable=yes, location=no');return false;"><?php print _JSHOP_RETURN_POLICY?></a>
                        <?php print _JSHOP_CONFIRM;?>        
                    </div>
                <?php }?>
                
                <?php if($this->no_return){?>                
                    <div class="row_no_return">            
                        <input type = "checkbox" name="no_return" id="no_return" />        
                        <?php print _JSHOP_NO_RETURN_DESCRIPTION;?>     
                    </div>
                <?php }?>
                
                <?php print $this->_tmp_ext_html_previewfinish_agb?>
                <div class="box_button"> 
			        <?php print $this->_tmp_ext_html_previewfinish_before_button?>
                    <input class="btn btn-primary button" type="submit" name="finish_registration" value="<?php print _JSHOP_ORDER_FINISH?>" onclick="return checkAGBAndNoReturn('<?php echo $this->config->display_agb;?>','<?php echo $this->no_return?>');" />
                </div>
            </div> 
            <?php print $this->_tmp_ext_html_previewfinish_end?>
        </form>
        
    </div>
</div>