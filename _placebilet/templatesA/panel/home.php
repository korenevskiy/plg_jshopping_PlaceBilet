<?php defined('_JEXEC') or die('Restricted access');
/**
* @version      4.3.1 13.08.2013
* @author       MAXXmarketing GmbH
* @package      Jshopping
* @copyright    Copyright (C) 2010 webdesigner-profi.de. All rights reserved.
* @license      GNU/GPL
*/

use \Joomla\CMS\Language\Text as JText;
use Joomla\Component\Jshopping\Administrator\Helper\HelperAdmin as JSHelperAdmin;


/** @var \Joomla\CMS\WebAsset\WebAssetManager $wa */
$wa = JFactory::getApplication()->getDocument()->getWebAssetManager();
//$wa->addInlineStyle(".prod_buttons:not(.buttons){display: none !important;}");
$wa->registerAndUseStyle('placebilet.admin', 'plugins/jshopping/placebilet/media/admin.css');

?>
<?php print $this->tmp_html_start ?? ''?>
<div>
<style>

</style>
    <div  class="panelhome" style=" ">
 
	<div id="cpanel" class="cpanel" >
       <?php \JSHelperAdmin::displayMainPanelIco(); ?>
		<div style="float:left;">
        <div class="icon">
            <a href="<?= Joomla\CMS\Uri\Uri::root()?>administrator/index.php#mod_placebilet" class="qr" title="QR Scanner Module">
				<!--<i class="fa fa-qrcode fade" aria-hidden="true"></i>-->
                <img src="<?= Joomla\CMS\Uri\Uri::root()?>plugins/jshopping/placebilet/media/qr_icon.svg" alt="">
                <span>QR Scanner</span>
            </a>
        </div>
		</div>
		
		<div style="float:left;">
        <div class="icon">
            <a href="<?= Joomla\CMS\Uri\Uri::root()?>administrator/index.php?option=com_jshopping&controller=statistics" class="" title="Statistics Reports">
				<!--<i class="fa fa-qrcode fade" aria-hidden="true"></i>-->
                <img src="<?= Joomla\CMS\Uri\Uri::root()?>administrator/components/com_jshopping/images/jshop_stats_b.png" alt="">
                <span><?= JText::_('JSHOP_PLACE_BILET_STATISTICS')?></span>
            </a>
        </div>
		</div>
    </div>
 
 
	<ul id="contacts" style="">
			<li>
            <h3 style="margin: 20px 0px; font:bold 18pt  'Helvetica Neue', Helvetica, Arial, sans-serif;  ">
				<img width="170" height="30"  src="<?= Joomla\CMS\Uri\Uri::root()?>plugins/jshopping/placebilet/media/images/logo_site-.png" alt="<?=   JText::_('JPLUGIN')?>" />
				<nobr><?=   JText::_('JSHOP_PLACE_BILET_NAME')?></nobr>
			</h3>
			</li>
			
			<li>	<img width="20" height="20" src="<?= Joomla\CMS\Uri\Uri::root() ?>plugins/jshopping/placebilet/media/images/phone_icon_100.png" align="left" border="0">
					Tel. <a href="tel:+79004881200" target="_blank">+7 900-488-12-00</a>
			</li>
			
			<li>	<img width="20" height="20"  src="<?= Joomla\CMS\Uri\Uri::root() ?>plugins/jshopping/placebilet/media/images/world_wide_web_90.png" align="left" border="0">
					Web. <a href="//www.explorer-office.ru/download" target="_blank">//explorer-office.ru/download</a>
			</li>
			
			
			<li>	<img width="20" height="20" src="<?= Joomla\CMS\Uri\Uri::root() ?>plugins/jshopping/placebilet/media/images/vk_messenger_100-100.png" align="left" border="0">
					VK.com: <a href="//vk.com/placebilet" target="_blank">//vk.com/placebilet</a>
			</li>
			
			<li>	<img width="20" height="20" src="<?= Joomla\CMS\Uri\Uri::root() ?>plugins/jshopping/placebilet/media/images/telegram.png" align="left" border="0">
					Telegram: <a href="https://t.me/placebilet" target="_blank">//t.me/placebilet</a>
			</li>
			
			
			<li>	<img width="20" height="20" src="<?= Joomla\CMS\Uri\Uri::root() ?>plugins/jshopping/placebilet/media/images/github.webp" align="left" border="0">
					Github: <a href="https://github.com/korenevskiy/plg_jshopping_PlaceBilet" target="_blank">//github.com/korenevskiy/plg_jshopping_PlaceBilet</a>
			</li>
			
			
			<li>	<img width="20" height="20" src="<?= Joomla\CMS\Uri\Uri::root() ?>plugins/jshopping/placebilet/media/images/max.webp" align="left" border="0">
					Max: <a href="https://max.ru/join/l2YuX1enTVg2iJ6gkLlaYUvZ3JKwDFek5UXtq5FipLA" target="_blank">//max.ru/join/l2YuX1enTVg2iJ6gkLlaYUvZ3JKwDFek5UXtq5FipLA</a>
			</li>
			
			
			<li>	<img width="27" height="20"  src="<?= Joomla\CMS\Uri\Uri::root() ?>plugins/jshopping/placebilet/media/images/at.gif" align="left" border="0">
					E-mail: <a href="mailto:info@explorer-office.ru" target="_blank">info@explorer-office.ru</a> 
			</li>
			
			<li>	
<!-- <br>FaceBook: <a href="//fb.com/groups/placebilet/" target="_blank">www.fb.com/groups/placebilet</a> -->
				<hr>
				<div class="infobilet"><?= JText::_('JSHOP_PLACE_BILET_DESC')?></div>
				<details>
					<summary><?= JText::_('JSHOP_ABOUT_AS')?></summary>
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
				</details>
			</li>

			
            
	</ul>
     
     
 </div>

</div>
<?php print $this->tmp_html_end ?? ''?>