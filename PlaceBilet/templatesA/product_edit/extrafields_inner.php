<?php
/**
* @version      4.3.1 13.08.2013
* @author       MAXXmarketing GmbH
* @package      Jshopping
* @copyright    Copyright (C) 2010 webdesigner-profi.de. All rights reserved.
* @license      GNU/GPL
*/
defined('_JEXEC') or die('Restricted access');
?>
<?php 
	
	$groupname="";
?>
<table class="admintable" >
<?php foreach($this->fields as $field){ ?>
<?php if ($groupname!=$field->groupname){ $groupname=$field->groupname;?>
<tr>
    <td><b><?php print $groupname;?></b></td>
</tr>
<?php }?>
<tr>
   <td class="key">
     <div style="padding-left:10px;"><?php echo $field->name;?></div>
   </td>
   <td>
     <?php echo $field->values;?>
   </td>
</tr>
<?php }?>
</table>