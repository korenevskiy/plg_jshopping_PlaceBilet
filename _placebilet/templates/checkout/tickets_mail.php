<?php defined('_JEXEC') or die();
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
//include_once __DIR__.'/../../Lib/phpqrcode/qrlib.php'; 
//QRcode::png('QR code ^)');
//return;
//<style>html{background-color: black;color: white;}</style>
?>


<?php


//use Joomla\CMS\Helper\ModuleHelper;
//use Joomla\CMS\HTML\HTMLHelper;
//use Joomla\CMS\Plugin\PluginHelper;
//use modPlaceBiletHelper as Helper;
//use Joomla\CMS\Uri\Uri;
//use Joomla\Registry\Registry as JRegistry;
//use \Joomla\CMS\Factory as JFactory;
use \Joomla\CMS\Language\Text as JText;
use voku\helper\UTF8 as UTF;
defined('_JEXEC') or die();

extract($displayData) ;

//ini_set('display_errors', '1');
//ini_set('display_startup_errors', '1');
//error_reporting(E_ALL);


//echo 'hello';
//return;
/* 
 * Отображение списка материалов сайта которые содержат Youtube ссылки
 */

//SELECT a.id, a.title, c.id, c.title
//FROM ma0ic_content a, ma0ic_categories c 
//WHERE a.catid = c.id AND (a.introtext LIKE 'youtube' OR a.fulltext LIKE 'youtube')
//return;
//$_SERVER['option'] = 'com_ajax';
//$_SERVER['module'] = 'multi';
////$_SERVER['method'] = 'com_ajax';
////$_SERVER['option'] = 'com_ajax';
//$_SERVER['format'] = 'debug';


//error_reporting(E_ALL);

//ob_start();
//include  __DIR__.'/../../../../../index.php'; 
//$out2 = ob_get_clean();


//$articles = JFactory::getDbo()->setQuery($query)->loadObjectList();//'id'

		 

 
//$imageAlias = 'js63.31793205726';
 
//$pathTemp = JFactory::getConfig()->get('tmp_path'); // JPATH_ROOT
//$imageName = 'del_' . (time()  + 100 ) . '_' . md5('js63.31793205726') . uniqid('') . '.png';
//$imagePath = $pathTemp . '/' . $imageName; // com_jshopping/files/files_products/


//include_once __DIR__.'/../../Lib/phpqrcode/qrlib.php'; 

//define('IMAGE_WIDTH',220);
//define('IMAGE_HEIGHT',220);

//ob_start();
//$imageData = ob_get_clean();

//				$data['QRcode']			= $QRcode;
//				
//				$data['pushka_id']		= $pushka_IDs[$index] ?? '';
//				$data['addprice']		= $prices[$index] ?? 0;
//				$data['place_name']		= $place_name;
//				
//				$data['attributeName']			= $product_attributes[$index]['attributeName']??'';
//				$data['placeName']			= $product_attributes[$index]['placeName']??'';
				
//				$data['QRsrc']			= 'data: ' . mime_content_type($imagePath) . ';base64,' . $imageData;
//				
//				$data['site_name']		= $siteName;
//				$data['site_url']		= $siteUrl;
//				$data['categories_name']	= $prodCatNames[$product_order_item->product_id] ?? [];
//				
//				$data['product_name']	= $product_order_item->product_name;
//				$data['count_places']	= $product_order_item->count_places;
//				$data['date_event']		= $product_order_item->date_event;
//				$data['event_id']		= $product_order_item->event_id ?? '';
////				$data['order_id']		= $order->manufacturer;
//				
//				$data['order_id']		= $order->order_id;
//				$data['order_number']	= $order->order_number;
//				$data['order_date']		= $order->order_date;
//				$data['order_m_date']	= $order->order_m_date;
//				$data['phone']			= $order->d_mobil_phone ?: $order->d_phone ?: $order->mobil_phone ?: $order->phone;
//				$data['email']			= $order->d_email ?: $order->email;
////				$data['order_id']		= $product_order_item->event_id ?? '';
//				
//				
//				$data['f_name']			= $order->d_f_name ?: $order->f_name;
//				$data['l_name']			= $order->d_l_name ?: $order->l_name;
//				$data['m_name']			= $order->d_m_name ?: $order->m_name;
//				$data['FIO']			= $order->d_FIO ?: $order->FIO;


//ob_start();
?>













<?php 
/**
* @version      4.0.0 2023.03.20
* @author       Korenevskiys Sergei Borisovich
* @package      Explorer Office
* @copyright    Copyright (C) 2010 explorer-office.ru.  All rights reserved.
* @license      GNU/GPL
*/
//https://phpqrcode.sourceforge.net
//use Joomla\Component\Jshopping\Site\Helper\Selects;
//use \Joomla\CMS\Language\Text as JText;
//defined('_JEXEC') or die();
//
//JHtml::_('behavior.formvalidator');


//cid:<?=$imageAlias ? >
?>
<style>
	.ticket_js{
		display: flex; 
		margin: 5px; 
		border: 5px solid gray; 
		border-radius: 25px; 
		padding:0px; 
		overflow: hidden;
		
		font-family: sans-serif;
		flex-wrap: wrap;
		justify-content: center;
		width: fit-content;
	}
	.ticket_js > *{
		/*border: 1px solid black;*/
	}
	.ticket_js .QR{
			writing-mode: tb;
			text-orientation: sideways;
			text-align: center;
			text-align-last: center;
			text-transform: uppercase;
			font-family: monospace;
			font-size: x-large;
			transform: rotate(180deg);
	}
	.ticket_js .datetime{
		display:block;
		font-size: x-large;
		display: block;
		text-align: center;
		color: black;
		color: #162f52; 
		text-shadow: 0px 0px 4px white, 0px 0px 4px white, 0px 0px 4px white, 0px 0px 4px white, 0px 0px 4px white, 0px 0px 4px white, 0px 0px 4px white, 0px 0px 8px black, 0px 0px 8px black, 0px 0px 8px transparent, 0px 0px 8px black, 0px 0px 8px transparent;
	}
	.ticket_js .info{
		/*border: 1px solid black;*/
	}
	.ticket_js .info dl{
		display: grid;
		grid-template: auto / 10em 1fr;
		grid-template-rows: auto;
		grid-template-columns: 1fr auto; 
		margin: 0;
	}
	.ticket_js .info dt{
		grid-column-start: 1;
		  border-top: 1px solid #ccc;
	}
	.ticket_js .info dd{
		grid-column-start: 2;
		margin-inline-start: 0px;
		padding-inline-start: 10px;
	}
	.ticket_js .info dt + dd {
		border-top: 1px solid #ccc;
	}
</style>
<div class="ticket_js" style="		display: flex; 
		margin: 5px; 
		border: 5px solid gray; 
		border-radius: 25px; 
		padding:0px; 
		overflow: hidden;
		
		font-family: sans-serif;
		flex-wrap: wrap;
		justify-content: center;
		width: fit-content;
		align-items: center;">
	<img src="cid:<?= $imageAlias?>" width="210" height="210" alt="<?=$QRcode?>" download="<?=$QRcode?>.png" style="
			margin: 1px 0 1px 4px;
			writing-mode: tb;
			text-orientation: sideways;
			text-align: center;
			text-align-last: center;
			text-transform: uppercase;
			font-family: monospace;
			font-size: x-large;
			
			border-radius: 20px;"/>
	
	<div class="QR" style="    
		 writing-mode: tb;
		text-orientation: sideways;
		text-align: center;
		text-align-last: center;
		text-transform: uppercase;
		font-family: monospace;
		font-size: x-large;
		transform: rotate(180deg);">
		<?=$QRcode?>
	</div>
	
	<div  style=" padding:10px 10px 3px 10px; max-width: 440px;">
		<center class="place_name">
			<span class="place_name_info">
			<?= JText::_('PLACE')?></span>
			<?= $place_name  ?>
			<?php if($placeCount > 1){ ?>
			<big><b style='float:right;font-size: larger'> : <?= $placeIndex ?></b></big>
			<?php } ?>
		</center>
		
		<h4 class="product" style="margin: 5px 0px 0px; "  title="<?=$date_event_print?>" >
			<?=$product_name?>
			
			<span class="datetime"  style="	display:block;
				font-size: x-large;
				display: block;
				text-align: center;
				color: black;
				color: #162f52; 
				text-shadow: 0px 0px 4px white, 0px 0px 4px white, 0px 0px 4px white, 0px 0px 4px white, 0px 0px 4px white, 0px 0px 4px white, 0px 0px 4px white, 0px 0px 8px black, 0px 0px 8px black, 0px 0px 8px transparent, 0px 0px 8px black, 0px 0px 8px transparent;
				">
			<!--	<?= date("j", $date_event_unix); ?>
				<?= JText::_(date("F", $date_event_unix))?>
				<?= date("H:i", $date_event_unix); ?> -->
			</span>
		</h4>
		
		
		<div class="info"   >
			<dl style="display: grid;
					grid-template-rows: auto;
					grid-template-columns: auto auto; 
					margin: 0;">
				
				
				<dt style="
						grid-column-start: 1;
						border-top: 1px solid #ccc;">
						<?=JText::_('VALID')?>
				</dt>
				<dd class="date" style="
						grid-column-start: 2;
						margin-inline-start: 0px;
						padding-inline-start: 10px;
						border-top: 1px solid #ccc;">
					<?=$date_tickets_print?>
				</dd>
				
				<dt style="
						grid-column-start: 1;
						border-top: 1px solid #ccc;">
					<?=JText::_('BUY')?>
				</dt>
				<dd class="date" style="
						grid-column-start: 2;
						margin-inline-start: 0px;
						padding-inline-start: 10px;
						border-top: 1px solid #ccc;">
					<?=$order_datetime_print?>
				</dd>
					
					
				<dt style="
						grid-column-start: 1;
						border-top: 1px solid #ccc;">
					<?=JText::_('JSHOP_ORDER')?>
				</dt>
				<dd style="
						grid-column-start: 2;
						margin-inline-start: 0px;
						padding-inline-start: 10px;border-top: 1px solid #ccc;">
					<?=$order_number?>
				</dd>
				
				
				<?php if($f_name || $l_name || $m_name): ?>
				<dt style="
						grid-column-start: 1;
						border-top: 1px solid #ccc;">
					<?= JText::_('JSHOP_FIELD_FIO')?>
				</dt>
				<dd style="
							grid-column-start: 2;
							margin-inline-start: 0px;
							padding-inline-start: 10px;
							border-top: 1px solid #ccc;">
						<?=$f_name?> <?=$l_name?> <?=$m_name?>
				</dd>
				<?php endif; ?>
				
				
				<?php if($FIO): ?>
				<dt style="
						grid-column-start: 1;
						border-top: 1px solid #ccc;">
					<?= JText::_('JSHOP_FIELD_FIO')?>
				</dt>
				<dd style="
							grid-column-start: 2;
							margin-inline-start: 0px;
							padding-inline-start: 10px;
							border-top: 1px solid #ccc;">
						<?=$FIO?>
				</dd>
				<?php endif; ?>
					
					
				
				<?php if($categories_name): ?>
				<dt style="
						grid-column-start: 1;
						border-top: 1px solid #ccc;">
					<?= count($categories_name)==1 ? JText::_('JCATEGORY') : JText::_('JCATEGORIES')?>
				</dt>
					<?php foreach ($categories_name as $cat_name){ ?>
					<dd style="
							grid-column-start: 2;
							margin-inline-start: 0px;
							padding-inline-start: 10px;
							border-top: 1px solid #ccc;">
						<?=$cat_name?>
					</dd>
					<?php } ?>
				<?php endif; ?>
					
				<?php if($product_attributes): ?>
				<dt style="
						grid-column-start: 1;
						border-top: 1px solid #ccc;">
					<?= count($product_attributes)==1 ? JText::_('JSHOP_PLACE_BILET_ATTRIBUTES') : JText::_('JSHOP_PLACE_BILET_ATTRIBUTES')?>
				</dt>
					<?php foreach ($product_attributes as $var_id => $attr_var){ 
						if(empty($attr_var->attr_name) && empty($attr_var->var_name))
							continue;
						?>
					<dd style="
							grid-column-start: 2;
							margin-inline-start: 0px;
							padding-inline-start: 10px;
							border-top: 1px solid #ccc;">
						<?= $attr_var->attr_name .': '. $attr_var->var_name?>
					</dd>
					<?php } ?>
				<?php endif; ?>
					
				<dt style="
						grid-column-start: 1;
						border-top: 1px solid #ccc;">
					<?=JText::_('COST')?>
				</dt>
				<dd style="
						grid-column-start: 2;
						margin-inline-start: 0px;
						padding-inline-start: 10px;border-top: 1px solid #ccc;">
					<b><?= trim(trim($addprice, '0'), '.') ?> <?=$currency_code?> <?=$pushka_id ? JText::_('JSHOP_PLACE_BILET_PK') : ''?></b>
				</dd>
					
			</dl>
			
			<center style="
					margin-top: 5px;
					word-wrap: break-word;
					word-break: break-word;
					font-size: xx-small;
					line-height: xx-small;">
				<a target="_blank"  href="<?=$siteUrl;?>"><?= UTF::str_starts_with($siteUrl,'http:')? substr($siteUrl,5) : $siteUrl?></a> /<?=$siteName;?>
				<br><a href="https://explorer-office.ru/download/" target="_blank"><?=JText::_('JSHOP_PLACE_BILET_PLATFORM');?>//explorer-office.ru</a>
			</center>
		</div>
	</div>
	
</div>



<?php 

//$html = ob_get_clean();

//echo $html;
return;


$subject = 'Тест Пушки ';
$recipient = 'koreshs@mail.ru';
$mailfrom = 'message@explorer-office.ru';
$fromname = '';


//	echo 'ExceptionOK:<br>';

//ob_start();
//header_remove();
//$png = ob_get_clean();


//echo "<br>Запрос данные:type: ". gettype($QRdata) .'  <pre>';
//echo print_r($QRdata,true);
//echo "</pre><br>";

//echo "$imageName <img src='/tmp/$imageName'>";

//echo QRcode::png('some othertext 1234', 'test.png');
//return;
//

$mailer = \JFactory::getMailer();
//$mailer->setSender(array($mailfrom, $fromname));
$mailer->addRecipient($recipient);
$mailer->setSubject($subject);
$mailer->setBody($html);
//$mailer->AddEmbeddedImage($imagePath, $imageAlias, $imageName, 'base64', 'image/jpeg');
//		if ($pdfsendtype){
//			$mailer->addAttachment($jshopConfig->pdf_orders_path."/".$this->order->pdf_file);
//		}
$mailer->isHTML(true);
//		$dispatcher->triggerEvent($this->getSendMailTriggerType($type), 
//			array(&$mailer, &$this->order, &$manuallysend, &$pdfsend, &$vendor, &$this->vendors_send_message, &$this->vendor_send_order));
$answer = $mailer->Send() ? 'Yes' : 'No';
		
echo "testMail:$answer <br>";

echo $html;

?>