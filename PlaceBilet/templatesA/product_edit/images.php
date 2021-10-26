<?php
/**
* @version      4.11.2 12.11.2015
* @author       MAXXmarketing GmbH
* @package      Jshopping
* @copyright    Copyright (C) 2010 webdesigner-profi.de. All rights reserved.
* @license      GNU/GPL
*/
defined('_JEXEC') or die();
	
JHtml::_('script', 'system/modal.js', true, true);
JHtml::_('stylesheet', 'system/modal.css', array(), true);
?>
<script type="text/javascript">
	var _JSHOP_IMAGE_SELECT = "<?php echo _JSHOP_IMAGE_SELECT;?>";
</script>

<div id="product_images_tab" class="tab-pane <?php if ($this->product->parent_id!=0){?>active<?php }?>">
   <table >
   <tr>
      <?php
      $i=0;
      $count_in_row = 5;
      if (count($lists['images']))
      foreach($lists['images'] as $image){
      ?>
          <td style="vertical-align: top; text-align: center;">
          <div id="foto_product_<?php print $image->image_id?>">
            <input type="text" name="old_image_descr[<?php print $image->image_id?>]" value="<?php print htmlspecialchars($image->name);?>" size="22" class="middle" />
            <div style="height:3px;"></div>
            <div style="padding-bottom:5px;padding-right:5px;">
                <a class="modal" href="<?php echo getPatchProductImage($image->image_name, 'full', 1)?>" rel="{handler: 'image'}">
                <img style="cursor:pointer" src="<?php echo getPatchProductImage($image->image_name, 'thumb', 1)?>" alt="" />
                </a>
            </div>
            <?php print _JSHOP_ORDERING?>: <input type="text" name="old_image_ordering[<?php print $image->image_id?>]" value="<?php print $image->ordering;?>" class="small" />
            <div style="height:3px;"></div>
            <input type="radio" name="set_main_image" id="set_main_image_<?php echo $image->image_id?>" value="<?php echo $image->image_id?>" <?php if ($row->image == $image->image_name) echo 'checked="checked"';?>/> 
			<label style="min-width: 50px;float:none;" for="set_main_image_<?php echo $image->image_id?>"><?php echo _JSHOP_SET_MAIN_IMAGE;?></label>
			<?php print $image->tmp_data_img?>
            <div class="link_delete_foto">
                <a class="btn btn-mini" href="#" onclick="if (confirm('<?php print _JSHOP_DELETE_IMAGE;?>')) deleteFotoProduct('<?php echo $image->image_id?>');return false;">
                    <img src="components/com_jshopping/images/publish_r.png"> <?php print _JSHOP_DELETE_IMAGE;?>
                </a>
            </div>
          </div>
          </td>
      <?php
       if (++$i % $count_in_row == 0) echo '</tr><tr>';
      }
      ?>
   </tr>
   </table>
   <div style="height:10px;"></div>
   <div class="col width-45" style="float:left">
        <fieldset class="adminform">
        <legend><?php echo _JSHOP_UPLOAD_IMAGE?></legend>
        <div style="height:4px;"></div>
        <?php for($i=0; $i < $jshopConfig->product_image_upload_count; $i++){?>
        <div style="padding-bottom:6px;">
            <input type="text" name="product_image_descr_<?php print $i;?>" size="35" title="<?php print _JSHOP_TITLE?>" />
            <input type="file" class="product_image" name="product_image_<?php print $i;?>" />
            <input type="text" class="product_folder_image" name="product_folder_image_<?php print $i;?>" style="display:none;" />
            <input type="button" name="select_image_<?php print $i;?>" value="<?php echo _JSHOP_IMAGE_SELECT;?>" onclick="SqueezeBox_init(); product_images_request(<?php echo $i;?>, 'index.php?option=com_jshopping&controller=product_images&task=display');" class="product_folder_image"/>
            <br/>
			<input type="checkbox" value="1" name="image_from_folder_<?php print $i;?>" id="image_from_folder_<?php print $i;?>" onclick="changeProductField(this);"/>
			<label for="image_from_folder_<?php print $i;?>">
				<?php print _JSHOP_IMAGE_SELECT?>
			</label>
			<?php 
			if (isset($this->plugin_template_images_load)){
				print $this->plugin_template_images_load[$i];
			}
			?>
        </div>
        <?php } ?>        
        </fieldset>
    </div>
    
    <div class="col width-55"  style="float:left">
    
        <fieldset class="adminform">
        <legend><?php echo _JSHOP_IMAGE_THUMB_SIZE?></legend>
            <table class="tmiddle"><tr>
            <td><input type="radio" name="size_im_product" id="size_1" checked="checked" onclick="setDefaultSize(<?php echo $jshopConfig->image_product_width; ?>,<?php echo $jshopConfig->image_product_height; ?>, 'product')" value="1" /></td>
            <td><label for="size_1" style="margin:0px;"><?php echo _JSHOP_IMAGE_SIZE_1;?></label></td>
            </tr></table>
            <table class="tmiddle"><tr>
            <td><input type="radio" name="size_im_product" value="3" id="size_3" onclick="setOriginalSize('product')" value="3"/></td>
            <td><label for="size_3" style="margin:0px;"><?php echo _JSHOP_IMAGE_SIZE_3;?></label></td>
            </tr></table>
            <table class="tmiddle"><tr>
            <td><input type="radio" name="size_im_product" id="size_2" onclick="setManualSize('product')" value="2" /></td>
            <td><label for="size_2" style="margin:0px;"><?php echo _JSHOP_IMAGE_SIZE_2;?></label></td>
            <td> <?php echo JHTML::tooltip(_JSHOP_IMAGE_SIZE_INFO)?></td>
            </tr></table>            
            <div class="key1"><?php echo _JSHOP_IMAGE_WIDTH?></div>
            <div class="value1"><input type="text" id="product_width_image" name="product_width_image" value="<?php echo $jshopConfig->image_product_width?>" disabled="disabled" /></div>
            <div class="key1"><?php echo _JSHOP_IMAGE_HEIGHT?></div>
            <div class="value1"><input type="text" id="product_height_image" name="product_height_image" value="<?php echo $jshopConfig->image_product_height?>" disabled="disabled" /></div>
        </fieldset>
        
        <fieldset class="adminform">
        <legend><?php echo _JSHOP_IMAGE_SIZE ?></legend>
            <table class="tmiddle"><tr>
            <td><input type="radio" name="size_full_product" id="size_full_1" onclick="setDefaultSize(<?php echo $jshopConfig->image_product_full_width; ?>,<?php echo $jshopConfig->image_product_full_height; ?>, 'product_full')" value="1" checked="checked" /></td>
            <td><label for="size_full_1" style="margin:0px;"><?php echo _JSHOP_IMAGE_SIZE_1;?></label></td>
            </tr></table>
            <table class="tmiddle"><tr>
            <td><input type="radio" name="size_full_product" id="size_full_3" onclick="setFullOriginalSize('product_full')" value="3" /></td>
            <td><label for="size_full_3" style="margin:0px;"><?php echo _JSHOP_IMAGE_SIZE_3;?></label></td>
            </tr></table>
            <table class="tmiddle"><tr>
            <td><input type="radio" name="size_full_product" id="size_full_2" onclick="setFullManualSize('product_full')" value="2"/></td>
            <td><label for="size_full_2" style="margin:0px;"><?php echo _JSHOP_IMAGE_SIZE_2;?></label></td>
            <td> <?php echo JHTML::tooltip(_JSHOP_IMAGE_SIZE_INFO)?></td>
            </tr></table>            
            <div class="key1"><?php echo _JSHOP_IMAGE_WIDTH?></div>
            <div class="value1"><input type="text" id="product_full_width_image" name="product_full_width_image" value="<?php echo $jshopConfig->image_product_full_width; ?>" disabled="disabled" /></div>
            <div class="key1"><?php echo _JSHOP_IMAGE_HEIGHT?></div>
            <div class="value1"><input type="text" id="product_full_height_image" name="product_full_height_image" value="<?php echo $jshopConfig->image_product_full_height; ?>" disabled="disabled" /></div>
        </fieldset>
        
    </div>
    <div class="clr"></div>
    <?php $pkey='plugin_template_images'; if ($this->$pkey){ print $this->$pkey;}?>
    <br/>
    <div class="helpbox">
        <div class="head"><?php echo _JSHOP_ABOUT_UPLOAD_FILES;?></div>
        <div class="text">
            <?php print _JSHOP_IMAGE_UPLOAD_EXT_INFO?><br/>
            <?php print sprintf(_JSHOP_SIZE_FILES_INFO, ini_get("upload_max_filesize"), ini_get("post_max_size"));?>
        </div>
    </div>
</div>