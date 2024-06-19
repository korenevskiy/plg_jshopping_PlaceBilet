<?php 
/**
* @version      4.10.0 13.08.2013
* @author       MAXXmarketing GmbH
* @package      Jshopping
* @copyright    Copyright (C) 2010 webdesigner-profi.de. All rights reserved.
* @license      GNU/GPL
*/
use \Joomla\CMS\Language\Text as JText;
defined('_JEXEC') or die('Restricted access');

        //  tuples,  itemsStr,  attr_name,  group_name,  attr_id,  config,  filter_order,  filter_order_Dir
        //$lang = JFactory::getLanguage();
	//$result = $lang->load('PlaceBilet', JPATH_SITE, 'ru-RU', true);
        //$lang->setDebug(TRUE);
//        echo "<pre>  getLanguage: ";
            //var_dump($lang->_('JSHOP_ADD_RANGE'));
            //echo $lang->_('JSHOP_ADD_RANGE');
            //var_dump($lang->get('strings'));
//        echo "</pre>"; 

//toPrint($this->tuples,'tuples');

        //JToolBarHelper::custom( "", '', '', JText::_('JSHOP_TITLE_EDIT_ROW'), TRUE);
        JToolBarHelper::title( JText::_('JSHOP_TITLE_EDIT_ROW'), 'generic.png' ); JToolBarHelper::spacer(); 
        JToolBarHelper::custom( "back", 'arrow-left', 'arrow-left', JText::_('JSHOP_BACK_TO_ATTRIBUTES'), false);
        JToolBarHelper::spacer(200);
        JToolBarHelper::divider();
//$rows=$this->rows;
$attr_id=$this->attr_id;
//$count=count ($rows);
$i=0;
$saveOrder = $this->filter_order_Dir == "asc" && $this->filter_order=="value_ordering";
?> 

<div id="j-sidebar-container" class="span2" >
    <?php echo $this->sidebar; ?>
</div>

<div id="j-main-container" class="span10">
<?php displaySubmenuOptions("attributes");?>
<form action="index.php?option=com_jshopping&controller=attributesvalues&attr_id=<?php echo $attr_id?>" method="post" name="adminForm" id="adminForm">
<?php print $this->tmp_html_start ?? ''?>
    <fieldset class="adminform">
        
        <?php $this->group_n = ($this->group_name)? '('.$this->group_name.')': $this->group_name;
        $btn_back = '';//"<button onclick=\"Joomla.submitbutton('back')\" class='btn ' style=' float: right;'><i class='icon-arrow-left'></i>".JText::_('JSHOP_BACK_TO_ATTRIBUTES')."</button>";
        $back = "<span class='back_btn' style='float: right;'> $attr_id </span>";
        echo "<legend  >$this->attr_name $this->group_n $btn_back $back </legend>"; ?>
         
    
        <table class="jssubmenu" style="width: 100%; background: #88a1; border-radius:10px;">
            <tr><td style="vertical-align: top; width: 30%;   padding: 20px 30px;">
                    <div style=' box-shadow: inset 0 1px 1px rgba(0,0,0,0.075);  padding: 1px;  border-radius: 5px;border: 1px solid #ccc;'>
        <?php //echo intval("Покрышка");
        //echo "<legend>$this->attr_name ($this->group_name)</legend>";   
            $a = "index.php?option=com_jshopping&controller=attributesvalues&attr_id=$this->attr_id&task";
                echo "<table class='table-striped' style='width: 100%;' >";
            if(count($this->tuples) ){    echo "<tr><td colspan='2' style='text-align:center; margrin:3px !important; overflow: hidden;'>".JText::_('JSHOP_NOM_SEATS')."</td></tr>";}
            foreach ($this->tuples as $tuple){
                echo "<tr><td style='text-align:right; width: 50px;'><a class='btn btn-mini' href='$a=RemoveRange&PlacesRangeRemove=$tuple->name'><i class='icon-remove'></i></a></td>"
                        . "<td style='text-align:right; padding-right: 30px;'>$tuple->name</td></tr>"; 
            }
            if( count($this->itemsStr)){    echo "<tr><td colspan='2' style='text-align:center;  '>".JText::_('JSHOP_NAME_SEATS')."</td></tr>";}
            foreach ($this->itemsStr as $tuple){
                echo "<tr><td style='text-align:right; width: 50px;'><a class='btn btn-mini' href='$a=RemoveString&PlacesStringRemove=id$tuple->value_id'><i class='icon-remove'></i></a></td>"
                . "<td style='text-align:right; padding-right: 30px;'>$tuple->name</td></tr>"; 
            }
                echo "</table>";
    
        ?></div></td>
        
        <td>
			<dl>
				<dt><?php echo JText::_('JSHOP_ADD_RANGE'); ?></dt>
				<dd  class="adminform">
					<input type="text" value="1-" name="PlacesRangeAdd"> 
                <button onclick="Joomla.submitbutton('AddsRange')" class="btn " style="margin-bottom: 9px;"><span class="icon-save-new"></span> <?php echo JText::_('JSHOP_ADD') ?></button><label></label>
                <br>
				<i>
                    <?php echo JText::_('JSHOP_ADD_RANGE_DESC') ?>  
                </i>
				</dd>
				
				<dt><hr><?php echo JText::_('JSHOP_ADD_STRING') ?></dt>
				
				<dd  class="adminform">
                <input type="text"	name="PlacesStringAdd"> 
                <button onclick="Joomla.submitbutton('AddString')" class="btn " style="margin-bottom: 9px;"><span class="icon-save-new"></span> <?php  echo JText::_('JSHOP_ADD') ?></button><label></label>
                <br>
				<i>
                    <?php echo  JText::_('JSHOP_ADD_STRING_DESC') ?>  
                </i>
				</dd>
				
				
				
<!--				
				<dt><hr><?php echo JText::_('JSHOP_ADD_COUNT') ?></dt>
				
				<dd  class="adminform">
                <input type="number"	name="PlacesCountNumAdd"> 
                <input type="text"	name="PlacesCountStrAdd">
                <button onclick="Joomla.submitbutton('AddCount')" class="btn " style="margin-bottom: 9px;"><span class="icon-save-new"></span> <?php  echo JText::_('JSHOP_ADD') ?></button><label></label>
                <br>
				<i>
                    <?php echo  JText::_('JSHOP_ADD_COUNT_DESC') ?>  
                </i>
				</dd>
				
				-->
				
				<dt><hr><hr><?php  echo JText::_('JSHOP_REMOVE_RANGE') ?> </dt>
				
				<dd  class="adminform">
                <input type="text" name="PlacesRangeRemove">
                <button onclick="Joomla.submitbutton('RemoveRange')" class="btn " style="margin-bottom: 9px;"><span class="icon-remove"></span> <?php  echo JText::_('JSHOP_REMOVE') ?></button><label></label>
                <br>
				<i>
                    <?php echo  JText::_('JSHOP_REMOVE_RANGE_DESC') ?>  
                </i>
				</dd>
								
				<dt><hr><?php  echo JText::_('JSHOP_REMOVE_STRING') ?></dt>
				
				<dd class="adminform">
                <select type='' name="PlacesStringRemove">
                    <?php 
                    if(count($this->tuples) && count($this->itemsStr)){    echo '<optgroup label="'.JText::_('JSHOP_NOM_SEATS').'">';}
                    foreach ($this->tuples as $tuple){
                        echo "<option value='rg$tuple->name'>$tuple->name</option>"; 
                    }
                    if(count($this->tuples) && count($this->itemsStr)){    echo '</optgroup><optgroup label="'.JText::_('JSHOP_NAME_SEATS').'">';}
                    foreach ($this->itemsStr as $tuple){
                        echo "<option value='id$tuple->value_id'>$tuple->name</option>"; 
                    }
                    
                    if(count($this->tuples) && count($this->itemsStr)){    echo '</optgroup>';} 
                    ?>
                </select>
                <button onclick="Joomla.submitbutton('RemoveString')" class="btn " style="margin-bottom: 9px;"><span class="icon-remove"></span> <?php  echo JText::_('JSHOP_REMOVE') ?></button><label></label>
                <br>
				<i>
                    <?php  echo JText::_('JSHOP_REMOVE_STRING_DESC') ?>
                </i>
				</dd>
			</dl>
			 
<!--            <a class="btn btn-micro" href="index.php?option=com_jshopping&controller=attributesvalues&task=edit&value_id=<?php echo $row->value_id; ?>&attr_id=<?php echo $attr_id?>">
            <i class="icon-edit"></i></a>-->

            
        </td>            
        </tr>
        </table>
    </fieldset>
<!--    <pre>-->
<?php //var_dump($this->rows)?>
<!--    </pre>-->
<input type="hidden" name="filter_order" value="<?php echo $this->filter_order?>" />
<input type="hidden" name="filter_order_Dir" value="<?php echo $this->filter_order_Dir?>" />
<input type="hidden" name="task" value="" />
<input type="hidden" name="hidemainmenu" value="0" />
<input type="hidden" name="boxchecked" value="0" />
<?php print $this->tmp_html_end ?? ''?>
</form>
</div>

<?php

$script = <<<SCRIPT
        
jQuery(function(){
    jQuery("input[name='PlacesStringAdd']").keydown(function(event) {
        if(event.keyCode==13) {
            event.preventDefault();
            console.log("PlacesStringAdd!!! "+this.value);
            Joomla.submitbutton('AddString');
        } 
    });
    jQuery("input[name='PlacesRangeAdd']").keydown(function(event) {
        if(event.keyCode==13) {
            event.preventDefault();
            console.log("PlacesRangeAdd!!! "+this.value);
            Joomla.submitbutton('AddsRange');
        } 
    }); 
    jQuery("input[name='PlacesRangeRemove']").keydown(function(event) {
        if(event.keyCode==13) {
            event.preventDefault();
            console.log("PlacesRangeAdd!!! "+this.value);
            Joomla.submitbutton('RemoveRange');
        } 
    }); 
    jQuery("select[name='PlacesStringRemove']").keydown(function(event) {
        if(event.keyCode==13) {
            event.preventDefault();
            console.log("PlacesRangeAdd!!! "+this.value);
            Joomla.submitbutton('RemoveString');
        } 
    }); 
});
        
        
SCRIPT;

JFactory::getDocument()->addScriptDeclaration($script);
