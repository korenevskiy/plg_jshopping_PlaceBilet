<?php
/**
* @version      4.9.0 13.08.2013
* @author       MAXXmarketing GmbH
* @package      Jshopping
* @copyright    Copyright (C) 2010 webdesigner-profi.de. All rights reserved.
* @license      GNU/GPL
*/
defined('_JEXEC') or die('Restricted access');

$i=0;
foreach($this->languages as $lang){
   $i++;
   $name="name_".$lang->language;
   $alias="alias_".$lang->language;
   $description="description_".$lang->language;
   $short_description="short_description_".$lang->language;
   $meta_title="meta_title_".$lang->language;
   $meta_keyword="meta_keyword_".$lang->language;
   $meta_description="meta_description_".$lang->language;   
   ?>
   <div id="<?php print $lang->lang.'-page'?>" class="tab-pane<?php if ($i==1){?> <?php }?>">
     <div class="col100">
     <table class="admintable" >
       <tr>
         <td class="key" style="width:180px;">
           <?php echo _JSHOP_TITLE;?>*
         </td>
         <td>
           <input type="text" class="inputbox wide" name="<?php echo $name?>" value="<?php echo $row->$name?>" />
         </td>
       </tr>
       <tr>
         <td class="key">
           <?php echo _JSHOP_ALIAS;?>
         </td>
         <td>
           <input type="text" class="inputbox wide" name="<?php echo $alias?>" value="<?php echo $row->$alias?>" />
         </td>
       </tr>
       <tr>
         <td  class="key">
           <?php echo _JSHOP_SHORT_DESCRIPTION;?>
         </td>
         <td>
           <textarea name="<?php print $short_description;?>" class="wide" rows="5"><?php echo $row->$short_description ?></textarea>
         </td>
       </tr>
       <tr>
         <td  class="key">
           <?php echo _JSHOP_DESCRIPTION;?>
         </td>
         <td>
           <?php
              $editor=JFactory::getEditor();
              print $editor->display('description'.$lang->id,  $row->$description , '100%', '350', '75', '20' ) ;
           ?>
         </td>
       </tr>
       <tr>
         <td  class="key">
           <?php echo _JSHOP_META_TITLE; ?>
         </td>
         <td>
           <input type="text" class="inputbox w100" name="<?php print $meta_title; ?>" value="<?php echo $row->$meta_title;?>" />
         </td>
       </tr>
       <tr>
         <td  class="key">
           <?php echo _JSHOP_META_DESCRIPTION; ?>
         </td>
         <td>
           <input type="text" class="inputbox w100" name="<?php print $meta_description?>" value="<?php echo $row->$meta_description?>" />
         </td>
       </tr>
       <tr>
         <td  class="key">
           <?php echo _JSHOP_META_KEYWORDS; ?>
         </td>
         <td>
           <input type="text" class="inputbox w100" name="<?php print $meta_keyword?>" value="<?php print $row->$meta_keyword?>" />
         </td>
       </tr>
       <?php $pkey='plugin_template_description_'.$lang->language; if ($this->$pkey){ print $this->$pkey;}?>
     </table>
     </div>
     <div class="clr"></div>
   </div>
<?php }?>