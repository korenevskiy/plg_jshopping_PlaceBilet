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
<script type="text/javascript">var liveurl = '<?php print JURI::root()?>';</script>
<div class = "jshop" id="comjshop">
    <h1><?php print _JSHOP_SEARCH ?></h1>
    
    <form action="<?php print $this->action?>" name="form_ad_search" method="post" onsubmit="return validateFormAdvancedSearch('form_ad_search')" class = "form-horizontal">
        <input type="hidden" name="setsearchdata" value="1">
        <div class = "jshop">
            <?php print $this->_tmp_ext_search_html_start;?>
            <div class = "control-group">
                <div class = "control-label">
                    <?php print _JSHOP_SEARCH_TEXT?>
                </div>
                <div class = "controls">
                    <input type = "text" name = "search" class = "input" />
                </div>
            </div>
            <div class = "control-group">
                <div class = "control-label">
                  <?php print _JSHOP_SEARCH_FOR?>
                </div>
                <div class = "controls">
                    <input type="radio" name="search_type" value="any" id="search_type_any" checked="checked" /> <label for="search_type_any"><?php print _JSHOP_ANY_WORDS?></label>
                    <input type="radio" name="search_type" value="all" id="search_type_all" /> <label for="search_type_all"><?php print _JSHOP_ALL_WORDS?></label>
                    <input type="radio" name="search_type" value="exact" id="search_type_exact" /> <label for="search_type_exact"><?php print _JSHOP_EXACT_WORDS?></label>
                </div>
            </div>
            <div class = "control-group">
                <div class = "control-label">
                    <?php print _JSHOP_SEARCH_CATEGORIES ?>
                </div>
                <div class = "controls">
                    <div><?php print $this->list_categories ?></div>
                    <div>
                        <input type = "checkbox" name = "include_subcat" id = "include_subcat" value = "1" />
                        <label for = "include_subcat"><?php print _JSHOP_SEARCH_INCLUDE_SUBCAT ?></label>
                    </div>
                </div>
            </div>
            <div class = "control-group">
                <div class = "control-label">
                    <?php print _JSHOP_SEARCH_MANUFACTURERS ?>    
                </div>
                <div class = "controls">
                    <?php print $this->list_manufacturers ?>
                </div>
            </div>
            <?php if (getDisplayPriceShop()){?>
            <div class = "control-group">
                <div class = "control-label">
                    <?php print _JSHOP_SEARCH_PRICE_FROM ?>      
                </div>
                <div class = "controls">
                    <input type = "text" class = "input" name = "price_from" id = "price_from" /> <?php print $this->config->currency_code?>
                </div>
            </div>
            <div class = "control-group">
                <div class = "control-label">
                    <?php print _JSHOP_SEARCH_PRICE_TO ?>      
                </div>
                <div class = "controls">
                    <input type = "text" class = "input" name = "price_to" id = "price_to" /> <?php print $this->config->currency_code?>
                </div>
            </div>
            <?php }?>
            <div class = "control-group">
                <div class = "control-label">
                    <?php print _JSHOP_SEARCH_DATE_FROM ?>      
                </div>
                <div class = "controls">
                    <?php echo JHTML::_('calendar','', 'date_from', 'date_from', '%Y-%m-%d', array('class'=>'inputbox', 'size'=>'25', 'maxlength'=>'19')); ?>
                </div>
            </div>
            <div class = "control-group">
                <div class = "control-label">
                    <?php print _JSHOP_SEARCH_DATE_TO ?>      
                </div>
                <div class = "controls">
                    <?php echo JHTML::_('calendar','', 'date_to', 'date_to', '%Y-%m-%d', array('class'=>'inputbox', 'size'=>'25', 'maxlength'=>'19')); ?>
                </div>
            </div>
            
            <div id="list_characteristics"><?php print $this->characteristics?></div>
            
            <?php print $this->_tmp_ext_search_html_end;?>
        </div>
        <div class = "control-group">
            <div class = "controls">
                <input type = "submit" class = "btn btn-primary button" value = "<?php print _JSHOP_SEARCH ?>" />  
            </div>
        </div>
    </form>
</div>