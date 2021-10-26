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
<?php if (count ($this->demofiles)){?>
    <div class="list_product_demo">
        <table>
            <?php foreach($this->demofiles as $demo){?>
                <tr>
                    <td class="descr"><?php print $demo->demo_descr?></td>            
                    <?php if ($this->config->demo_type == 1) { ?>
                        <td class="download"><a target="_blank" href="<?php print $this->config->demo_product_live_path."/".$demo->demo;?>" onClick="popupWin = window.open('<?php print SEFLink("index.php?option=com_jshopping&controller=product&task=showmedia&media_id=".$demo->id);?>', 'video', 'width=<?php print $this->config->video_product_width;?>,height=<?php print $this->config->video_product_height;?>,top=0,resizable=no,location=no'); popupWin.focus(); return false;"><img src = "<?php print $this->config->live_path.'images/play.gif'; ?>" alt = "play" title = "play"/></a></td>
                    <?php } else { ?>
                        <td class="download"><a target="_blank" href="<?php print $this->config->demo_product_live_path."/".$demo->demo;?>"><?php print _JSHOP_DOWNLOAD;?></a></td>
                    <?php }?>
                </tr>
            <?php }?>
        </table>
    </div>
<?php } ?>