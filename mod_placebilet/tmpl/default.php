<?php
 /** ----------------------------------------------------------------------
 * plg_placebilet - Plugin Joomshopping Component for CMS Joomla
 * ------------------------------------------------------------------------
 * author    Sergei Borisovich Korenevskiy
 * @copyright (C) 2019 //explorer-office.ru. All Rights Reserved. 
 * @license GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 * @package		Jshopping,plg_placebilet
 * @subpackage  mod_placebilet
 * Websites: //explorer-office.ru/download/
 * Technical Support:  Forum - //fb.com/groups/multimodulefb.com/groups/placebilet/
 * Technical Support:  Forum - //vk.com/placebilet
 * -------------------------------------------------------------------------
 * */
defined('_JEXEC') or die;

use \Joomla\CMS\Factory as JFactory;
use \Joomla\CMS\HTML\HTMLHelper as JHtml;
use modPlaceBiletHelper as Helper;
use \Joomla\CMS\Language\Text as JText;

//use \Joomla\Module\Placebilet\Administrator\Helper\PlaceBiletHelper as Helper; // Этот тип класса не поддерживается Ajax

$id = (int) $module->id;
$doc = $app->getDocument();

JHtml::_('form.csrf');

$param = Helper::$param; //$params->toObject(); // $this->params = new Reg($this->params); // $this->params->toObject();
// toPrint( Helper::getEventTitleList(), 'eventList',true,'message',true);
// toPrint($param, '$param',true,'message',true);
//JHtml::script($img);// register($img, $function);
//$wa = new \Joomla\CMS\WebAsset\WebAssetManager;
$wa = JFactory::getApplication()->getDocument()->getWebAssetManager();
$wa->useScript('jquery');
$wa->registerAndUseScript('juqery.fullscreen', 'administrator/modules/mod_placebilet/media/jquery.fullscreen.js');

//$wa->registerAndUseScript('Instascan', 'https://rawgit.com/schmich/instascan-builds/master/instascan.min.js', [], ['defer' => true]);
$wa->registerAndUseScript('Instascan', 'administrator/modules/mod_placebilet/media/instascan.min.js', [], ['defer' => true]);
$wa->registerAndUseScript('BeepJS', 'administrator/modules/mod_placebilet/media/beep.js', [], ['defer' => true]);
$wa->registerAndUseScript('mod_placebilet.admin', 'administrator/modules/mod_placebilet/media/placebilet.js');
//$wa->registerAndUseScript('mod_placebilet.admin.js', '/administrator/modules/mod_placebilet/media/placebilet.php',['relative' => false, 'version' => 'auto'],['type'=>'text/javascript']);
$wa->registerAndUseStyle('mod_placebilet.admin', 'administrator/modules/mod_placebilet/media/style.css');
//$wa->registerScript('jquery.ui', 'modules/mod_multi/media/jquery/jquery-ui-1.13.2/jquery-ui.min.js');
//$wa->registerStyle('jquery.ui', 'modules/mod_multi/media/jquery/jquery-ui-1.13.2/jquery-ui.min.css');
//JFactory::getApplication()->getDocument()->getWebAssetManager()->useStyle('jquery.ui')->useScript('jquery.ui');

$wa->addInlineScript('
	document.addEventListener("DOMContentLoaded", function(){form_QR_' . $id . '.t = "' . JFactory::getApplication()->getFormToken() . '"}); 
');
//        array_unshift($languages, HTMLHelper::_('select.option', '', Text::_('JDEFAULTLANGUAGE')));
//        $select = JHtml::_('select.genericlist', Helper::getEventTitleList(), 'select_EventID_'.$id, 'class="form-select"', 'id', 'title', null);
//JFactory::getApplication()->getDocument()->getWebAssetManager()->usePreset('jquery.ui');
//JFactory::getApplication()->getDocument()->getWebAssetManager()->usePreset('jquery.ui');
//$wa->useAsset($img, $link_title);
//$wa->useStyle('jquery.ui')->useScript('jquery.ui');

JText::script('JSHOP_PUSHKA_CAMERA_NONE');
JText::script('JSHOP_PUSHKA_ALERT_NOCAMERA');
JText::script('JSHOP_PUSHKA_ALERT_ERROR');
//JText::script('JSHOP_PUSHKA_ALERT_NOSSL');


//JText::script('');
?>

<div class="mod-placebilet placebilet mod<?= $id ?>">
	<a id='aTagAjaxLinkTest<?= $id ?>' target='_blank' href='?&QRcode=js1.1111111111&option=com_ajax&module=placebilet&method=getStatus&id=<?= $id ?>&lang=<?=JFactory::getApplication()->getLanguage()->getTag()?>&format=json&<?= $app->getFormToken() ?>=1'><?= $app->getFormToken() ?></a>
	<form id="form_QR_<?= $id ?>" data-id="<?= $id ?>" data-beep="<?= $param->pushka_camera_beep ?? 'yes' ?>"  data-lang="<?=JFactory::getApplication()->getLanguage()->getTag()?>"
		  class='mod_placebiletFormQR'
		  data-btn_Visit_Statuses='<?= json_encode($param->btn_visit_statuses ?? ['O']) ?>'
		  data-btn_Refund_Statuses='<?= json_encode($param->btn_refund_statuses ?? ['O']) ?>'
		  data-btn_Cancel_Statuses='<?= json_encode($param->btn_cancel_statuses ?? ['O']) ?>'
		  data-debug='<?= JFactory::getApplication()->getConfig()->get('debug') || JFactory::getApplication()->getConfig()->get('error_reporting')=='maximum' ? '1' : '0'?>'
		  >

		<div>
		  <?php echo JHTML::_('form.token'); ?>

		</div>

		<?php if ($param->pushka_camera ?? true): ?>
			<div class="controls camera">
				<button id="btn_camera_start_<?= $id ?>" class="btn  _btn-outline-primary btn-primary  _btn-sm" type="button"><?= JText::_('JSHOP_PUSHKA_START_CAMERAS') ?></button>
				<button id="btn_fullscreen_<?= $id ?>" class="btn btn-secondary  _btn-sm btnFullscreen" type="button"><i class="  fa  fa-solid fa-maximize "></i></button>
				<select id="select_CamerasQR_<?= $id ?>"  class="form-select _form-select-sm cameras"  
						data-selectDefault="<?= $param->pushka_camera_select ?? 'first' ?>" aria-label="<?= JText::_('JSHOP_PUSHKA_CAMERAS_LIST') ?>">
					<option value=""><?= JText::_('JSHOP_PUSHKA_CAMERA_SELECT') ?></option>
				</select>
				<button id="btn_camera_stop_<?= $id ?>" class="btn btn-secondary _btn-outline-primary _btn-sm" type="button"><?= JText::_('JSHOP_PUSHKA_STOP_CAMERAS') ?></button>
			</div>
		<?php endif; ?>
		<video id="videoView_<?= $id ?>" class="video" style="display: none;"></video>

		<?php
		if (($param->pushka_platform ?? 'auto') == 'auto') {
			echo JHtml::_('select.genericlist', Helper::getEventTitleList(), 'eventID', ['id' => 'select_EventID_' . $id, 'option.key' => 'id', 'option.text' => 'title',
				'list.attr' => [
					'class' => 'form-select nextFocus',
					'data-nextFocus' => 'input_CodeQR_' . $id
				]
			]);
		}
		if (($param->pushka_platform ?? 'auto') == 'other'):
			?>
			<div class='input-group _flex-nowrap'>
				<!--<label class='input-group-text  btn-outline-secondary' id='labelEventID_<?= $id ?>' for='select_EventID_<?= $id ?>'><i class="fa fa-tag" aria-hidden="true"></i></label>-->
				<button onclick="return select_EventID_<?= $id ?>.value = ''"  class="btn btn-outline-secondary" type="button"  label="<?= JText::_('JSHOP_PUSHKA_QR_CLEAR') ?>"><i class="fa fa-times" aria-hidden="true"></i></button>
				<input id='select_EventID_<?= $id ?>' 
					   name='eventID' class='form-control nextFocus' aria-describedby='labelEventID_<?= $id ?>' inputmode="numeric" type='text' data-nextFocus="input_CodeQR_<?= $id ?>" 
					   placeholder='<?= JText::_('JSHOP_PUSHKA_EVENTID') ?>' aria-label='<?= JText::_('JSHOP_PUSHKA_EVENTID') ?>'>
				
			</div>
		<?php endif; ?>
		<div class="input-group flex-nowrap">
			 <!--<span class="input-group-text" id="addon-wrapping">@</span>-->
			<!--<label class="qrcode-text-btn input-group-text  btn-outline-secondary" id="qr_label_<?= $id ?>" for="input_CodeQR_<?= $id ?>">-->
				<!--<i class="fa fa-tag" aria-hidden="true"></i> -->
				<!--<i class="fa fa-barcode" aria-hidden="true"></i>-->
				<!--<i class="fa fa-qrcode fade" aria-hidden="true"></i>-->
			<!--</label>-->

			<button id="buttonClear_<?= $id ?>" class="btn btn-outline-secondary" type="button" label="<?= JText::_('JSHOP_PUSHKA_QR_CLEAR') ?>"><i class="fa fa-times" aria-hidden="true"></i></button>
			<!-- -->
			<input id="input_CodeQR_<?= $id ?>" name='QRcode' class="form-control nextFocus" aria-describedby="qr_label_<?= $id ?>" type="text" 
						   placeholder="<?= JText::_('JSHOP_PUSHKA_QR_CODE') ?>"  aria-label="<?= JText::_('JSHOP_PUSHKA_QR_CODE') ?>"
						   data-nextFocus="btn_camera_start_<?= $id ?>"
						   _onchange="fieldOnChangeQRcode.call(form_QR_<?= $id ?>,this);" 
						   _onkeyup="if(event.key==13 || event.which == 13){ event.preventDefault();cameraScan.call({id:<?= $id ?>},this.value,true);return false; }  return true;" 
						   _onkeypress=" if(event.key==13 || event.which == 13){ event.preventDefault();cameraScan.call({id:<?= $id ?>},this.value,false);return false; }  return true;" 
						   > 
			<button id="button_GetStatus_<?= $id ?>"  class="qrcode-text-btn  btn btn-outline-secondary" type="button" label="<?= JText::_('JSHOP_PUSHKA_QR_CLEAR') ?>"><i class="fa fa-qrcode fade" aria-hidden="true"></i></button>
		</div>
	</form>


	<message id="message_<?= $id ?>" class="message" style='display:none'  
			 data-nocameras="<?= JText::_('JSHOP_PUSHKA_NOT_CAMERAS') ?>"
			 data-active="<?= JText::_('JSHOP_PUSHKA_STATUS_ACTIVE') ?>"
			 data-visited="<?= JText::_('JSHOP_PUSHKA_STATUS_VISITED') ?>"
			 data-refunded="<?= JText::_('JSHOP_PUSHKA_STATUS_REFUNDED') ?>"
			 data-canceled="<?= JText::_('JSHOP_PUSHKA_STATUS_CANCELED') ?>"
			 >
	</message>

	<?php // echo $module->content;   ?>

	<div class="controls action">
		<button id="btn_visit_<?= $id ?>" class="button-visit btn _btn-primary btn-action _btn-info -success btn-block btn-lg <?= $param->pushka_visit ? '' : 'hidden' ?>" type="button" style='display:none'><?= $param->button_name_visit ?: JText::_('JSHOP_PUSHKA_STATUS_VISIT') ?></button>
		<button id="btn_refund_<?= $id ?>" readonly class="button-refund btn btn-warning   btn-lg <?= $param->pushka_refund ? '' : 'hidden' ?>" type="button" style='display:none'><?= $param->button_name_refund ?: JText::_('JSHOP_PUSHKA_STATUS_REFUND') ?></button>
		<button id="btn_cancel_<?= $id ?>" readonly class="button-cancel btn btn-light  btn-lg <?= $param->pushka_cancel ? '' : 'hidden' ?>" type="button" style='display:none'><?= $param->button_name_cancel ?: JText::_('JSHOP_PUSHKA_STATUS_CANCEL') ?></button>
	</div>

	<!--JSHOP_PUSHKA_STATUS_ACTIVE="Активный"
	
	JSHOP_PUSHKA_STATUS_VISIT="Посетить"
	JSHOP_PUSHKA_STATUS_REFUND="Возместить"
	JSHOP_PUSHKA_STATUS_CANCEL="Отменить"
	
	JSHOP_PUSHKA_STATUS_VISITED="Посещён"
	JSHOP_PUSHKA_STATUS_REFUNDED="Возмещён"
	JSHOP_PUSHKA_STATUS_CANCELED="Отменён"-->
</div>





<script type="text/javascript" data-module='<?= $id ?>'>
	document.getElementById("form_QR_<?= $id ?>").t="<?= JFactory::getApplication()->getFormToken() ?>";
</script>


<script type="text/javascript"  data-module='<?= $id ?>'>

</script>

<script type="text/javascript"  data-module='<?= $id ?>'>


</script>

<script type="text/javascript"  data-module='<?= $id ?>'>

</script>

<?php return ?>
<?php ?>

