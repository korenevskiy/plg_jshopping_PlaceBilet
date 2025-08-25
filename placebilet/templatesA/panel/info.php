<?php 
/**
* @version      4.15.2 20.06.2016
* @author       MAXXmarketing GmbH
* @package      Jshopping
* @copyright    Copyright (C) 2010 webdesigner-profi.de. All rights reserved.
* @license      GNU/GPL
*/
use \Joomla\CMS\Language\Text as JText;
defined('_JEXEC') or die();

require __DIR__ .'/home.php';
return;

?>
 
<div id="j-sidebar-container" class="span2">
    <?php echo $this->sidebar; ?>
</div>
 
 

<div id="j-main-container">
<?php print $this->tmp_html_start ?? ''?>

<table width="100%" style="background: #88a1;border-radius:10px;">
<tr>
 <td width="50%" valign="top" style="padding:10px;">
     
            <p valign="middle" class="text">
                     
                    <div>Web. <a href="//www.explorer-office.ru/" target="_blank"><strong>www.explorer-office.ru</strong></a>
                    <br>VKontakte: <a href="//vk.com/placebilet" target="_blank"><strong>www.vk.com/placebilet</strong></a>
                    <br>FaceBook: <a href="//fb.com/groups/placebilet/" target="_blank"><strong>www.fb.com/groups/placebilet</strong></a>
                    <br>E-mail: <a href="mailto:info@explorer-office.ru" target="_blank"><strong>info@explorer-office.ru</strong></a> 
                    
                    
                    </div>
            </p> 
    <br>
    <strong> <em>Explorer-Office</em></strong>
    <br>IP Korenevskiy Sergei Borisovich<br>
    <br>Address: Russia, 302016,<br>
    Karachevskiy per., home.18, apt.55<br><br>
    Tel: +7 (900)488-12-00<br>
    eMail: <strong>
    <a class="link" href="mailto:info@explorer-office.ru">info@explorer-office.ru</a>
    </strong><br><br>
    </p>
    <p><strong>Tax Identification Number:<br></strong>
	575207065347
    <br><br>
    </p>
    <p><strong>Director:</strong> 
    <br>Sergei Korenevskiy</p>
 </td>
 <td valign="top" style="padding:10px;">
    
    <div id="contacts" style="vertical-align:top; flex: 5;">
        <table cellpadding="0" cellspacing="0" width="100%" style="border-radius: 10px;">
            <tr> 
                <td><div style="margin: 20px 0px; font:bold 18pt  'Helvetica Neue', Helvetica, Arial, sans-serif;  "><img width="170" height="30"  src="<?= Joomla\CMS\Uri\Uri::root()?>/plugins/jshopping/placebilet/media/images/logo_site-.png" alt="<?=   JText::_('JPLUGIN')?>" />
					
                    <nobr><?=   JText::_('JSHOP_PLACE_BILET_NAME')?></nobr></div>
                </td>
            </tr>
            <tr>
                <td valign="middle">
                     <hr>
                    
                    
                    <div class="infobilet"><?= JText::_('JSHOP_PLACE_BILET_DESC')?></div>
                </td>
            </tr>
        </table>
    </div>
 </td>
</table>
	
<?php print $this->tmp_html_end ?? ''?>
</div>	
	
