<?php
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

defined('_JEXEC') or die();

use \Joomla\CMS\Factory as JFactory;
use \Joomla\CMS\Date\Date as JDate;
use \Joomla\CMS\HTML\HTMLHelper as JHtml;
use \Joomla\CMS\Language\Language as JLanguage;
use \Joomla\CMS\Language\Text as JText;
use \Joomla\Registry\Registry as JRegistry;
use \Joomla\Input\Input as JInput;
use \Joomla\CMS\Uri\Uri as JUri;
use \Joomla\CMS\Router\Route as JRoute;
use Joomla\CMS\Form\FormHelper as JFormHelper;


//toPrint();

JHtml::stylesheet('plugins/jshopping/placebilet/media/admin.css', [], []);
JHtml::stylesheet('plugins/jshopping/placebilet/media/print.css', [], ['media'=>'print']);
//JFactory::getDocument()->addStyleSheet('plugins/jshopping/placebilet/media/print.css', [], ['type' => 'text/css','media'=>'print' ]);
//@media print {}
//<link rel="stylesheet" media="print" href="print.css">
//<link rel="stylesheet" media="screen" href="print.css">
?>
<div id="j-main-container"  class="j-main-container page_report">
	<form action="index.php?option=com_jshopping&controller=statistics" method="post" name="adminForm" id="adminForm" enctype="multipart/form-data" >
	<div class="panel_top btn-toolbar d-flex" style="gap: 10px;">
	<?php

$this->input = \JFactory::getApplication()->getInput();

$PCS = JText::_('JSHOP_PLACE_BILET_PCS');
		
//toPrint(null,'',0,'',true);
//toPrint($where,'$where',0,'message',true);
//toPrint($query,'$query',0,'pre',true);
//toPrint($this->input->getArray(),'$this->input',0,'message',true);
//toPrint($order_items,'$order_items',0,'pre',true);

//toPrint($this->order_items,'$this->order_items',0,'message',true);
//toPrint($this->orders_all,'$this->orders_all',0,'message',true);
		
		$this->fieldDateStart;
		$this->fieldDateStop;
		
		$this->fieldCategories;
		$this->fieldEvents;
		$this->placePushka;
		
		$this->order_items;
		$this->orders_all;
		
		$this->columnStatus;		// Имеющиеста статусы	$status_code => object(status_code id,status_id,status_code,title)
		$this->statusList;			// Все статусы			$status_code => object(status_code id,status_id,status_code,title)
//		$this->columnSumm = 0;
//		$this->columnCount = 0;
		$this->rowAttributes;
//		$this->currency_list; //$this->currency_list[$order_item->currency_code_iso??0]
		
// <editor-fold defaultstate="collapsed" desc="Поля даты">


			$timezone = 'GMT';
			$timezone = 'UTC';
			$timezone = JFactory::getApplication()->getConfig()->get('offset', 'UTC');
			$timezone = JFactory::getUser()->getParam('timezone', $timezone);
//			$zone = new \DateTimeZone( $timezone );
			$date_event = 'now'; // $row->date_event ?:
            $dt_DateTime = JDate::getInstance($date_event, $timezone);

//			if($date_event == 'now')
//				$dt_DateTime= $dt_DateTime->setTime(0, 0);
	
//			$formateDate =  $row->date_event != '0000-00-00 00:00:00' ? $dt_DateTime->toSql(true ) : '';
			$formateDate = $dt_DateTime->toSql(true);


	
		echo JHTML::_('calendar', $this->fieldDateStart ?? '', 'field_date_start', 'field_date_start', '%Y-%m-%d', //%Y-%m-%d %H:%M:%S
				['class' => 'inputbox prettycheckbox', 'size' => '25', 'maxlength' => '19', 'required' => true, 'showTime' => false]);

		echo JHTML::_('calendar', $this->fieldDateStop ?? '', 'field_date_stop', 'field_date_stop', '%Y-%m-%d', //%Y-%m-%d %H:%M:%S 
				['class' => 'inputbox prettycheckbox', 'size' => '25', 'maxlength' => '19', 'required' => true, 'showTime' => false]);


		
		$fieldEventIDs = JFormHelper::loadFieldType('sql', true);
		$fieldEventIDs->setup(simplexml_load_string('
			<field
				name="field_Card"
				type="radio"
				label="[[%1:]],JSHOP_PLACE_BILET_CARDTYPE" 
				zlayout="joomla.form.field.list-fancy-select"
				xlayout="joomla.form.field.radio.switcher"
				multiple="false"
				default="0"
				style=""
				parentclass="btn-group"
				class="input-group btn-group"
				> 
				<option value="0">JSHOP_PLACE_BILET_CARDTYPE</option>
				<option value="pushka">JSHOP_PLACE_BILET_CARDPUSHKA</option>
				<option value="bank">JSHOP_PLACE_BILET_CARDBANK</option>
			</field>'), $this->placePushka ?? [0] );
		$fieldEventIDs->setDatabase($this->db);
		$fieldEventIDs->hidden = true;
		echo $fieldEventIDs->renderField([]); //['hiddenLabel' => false,'hiddenDescription'=>true,'id'=>1234]

		
//		$langs = implode(',', PlaceBiletHelper::getLanguageList('c.name_'));
		$langs = implode(',', PlaceBiletHelper::getLanguageList());



		$fieldCategories = JFormHelper::loadFieldType('sql', true);
		$fieldCategories->setup(simplexml_load_string('
			<field
				name="field_Categories"
				type="sql"
				label="--[[%1:]]:--,JCATEGORIES" 
				query="
SELECT category_id, CONCAT(if(category_publish,\'✔\',\'❌\'), CONCAT_WS(\' /\', ' . $langs . ' )) title
FROM #__jshopping_categories  ;"
				multiple="true"
				key_field="category_id"
				value_field="title"
				layout="joomla.form.field.list-fancy-select"
				default=""
				style=""
				parentclass=""
				class="input-group"
				>
				<option value="">--[[%1:]]:--,JCATEGORIES</option>
			</field>'), $this->fieldCategories ?? []);
		$fieldCategories->hidden = true;
		$fieldCategories->setDatabase($this->db);
		echo $fieldCategories->renderField(['hiddenLabel' => true, 'hiddenDescription' => true, 'id' => 123]);
//		echo $fieldCategories->getRenderer('joomla.form.field.list')->render($data);





		$fieldEventIDs = JFormHelper::loadFieldType('sql', true);
		$fieldEventIDs->setup(simplexml_load_string('
			<field
				name="field_Events"
				type="sql"
				label="[[%1:]],JSHOP_PLACE_BILET_EVENTS_PROCULTURE" 
				query="
SELECT event_id id, CONCAT_WS(\' /\', event_id,  ' . $langs . ' ) title, date_event date 
FROM #__jshopping_products 
WHERE  event_id != 0 
GROUP BY event_id
ORDER BY date_event;"
				multiple="true"
				key_field="id" 
				value_field="title"
				layout="joomla.form.field.list-fancy-select"
				default=""
				style=""
				parentclass=""
				class="input-group"
				>
				<xoption value="pushka">JSHOP_PLACE_BILET_EVENTS_NOPUSHKA</xoption>
				<option value="">[[%1:]],JSHOP_PLACE_BILET_EVENTS_PROCULTURE</option>
			</field>'), $this->fieldEvents ?? [0] );
		$fieldEventIDs->setDatabase($this->db);
		$fieldEventIDs->hidden = true;
		echo $fieldEventIDs->renderField(['hiddenLabel' => true, 'hiddenDescription' => true, 'id' => 1234]);





//<field name="protocol" type="radio" default="0" class="btn-group" label="..." description="...">
//    <option value="0">JNO</option>
//    <option value="1">JYES</option>
//</field>// </editor-fold>

//toPrint(null,'',false,false,false);
//toPrint($this->columnStatus,'$this->columnStatus',true,'pre',true);

//toPrint($this->rowAttributes,'$this->rowAttributes: '.count($this->rowAttributes), 0, 'message', true);
		$i = 1;
		$summas = ['summ_tickets_active'=> 0,];
		$countes = ['count_tickets_active'=> 0,];
	?>
	</div>
		
	<div class="orderTable">
		
		<div class="titles line">
			<label>ID</label>
			<label class="titleName"><span class="titleEvent"><?= JText::_('JSHOP_PLACE_BILET_TITLE_EVENT') ?></span><span class="titleAttr"><?= JText::_('JSHOP_PLACE_BILET_TITLE_ATTR') ?></span></label>
			<label><?= JText::_('JSHOP_PLACE_BILET_SALETICKETS') ?> <span class=_pcs>(<?=$PCS?>)</span></label>
			<?php
			foreach ($this->columnStatus as $status_code => $status){ // $status_code => object(status_id,status_code,title)
				echo "<label 'col$i statusCode $status->status_code statusID $status->status_id'>$status->title</label>";
				$i++;
			}
			?>
			<label><?= JText::_('JSHOP_PLACE_BILET_SALESUM') ?>
				<span class=_cur><?= isset($this->order_items) && $this->order_items ? 
						' ('.reset( $this->order_items )->currency_code .')'
						:  strtolower(JText::_('COST')) ?></span>
			</label>
		</div>
		
	<?php
//toPrint(null,'$this->order_items '.count($this->order_items).':',0,'message',true);
foreach($this->order_items as $_product_id => $order_item):
	?>
<div class="line">
	<?php 
	
//toPrint($order_item->tickets_cost,'$order_item->tickets_cost',0,'message',true);
	
		echo "<div class='event'>";
		echo "<div class='id'>$order_item->product_id</div>";
		echo "<div class='name'>$order_item->product_name</div>";
//		$title = rtrim(rtrim($order_item->summ_tickets_buy, "0"),"\.")  . ' ' . $order_item->currency_code;
		$title = rtrim(rtrim($order_item->summ_tickets_active, "0"),"\.")  . ' ' . $order_item->currency_code;
		echo "<div class='buyTickets' title='$title'><span class='text-nowrap'>$order_item->count_tickets_active</span></div>";
		
		if(! isset($countes['count_tickets_active']))
			$countes['count_tickets_active'] = 0;
		if(! isset($summas['summ_tickets_active']))
			$summas['summ_tickets_active'] = 0;
		
		$countes['count_tickets_active'] += $order_item->count_tickets_active;	// Подсчёт Всего Количество
		$summas['summ_tickets_active'] += $order_item->summ_tickets_active;		// Подсчёт Всего Сумма
			//$order_item->count_tickets_buy
//				$order_item->summ_tickets_active;  // INT
//				$order_item->count_tickets_active; // INT
//			$order_item->summ_tickets_buy = rtrim(rtrim($order_item->summ_tickets_buy, "0"),"\.");
//			$order_item->count_tickets_buy;
//toPrint($countes['count_tickets_active'],' ',0,'message',true);
		
		$i = 1;
		foreach ($this->columnStatus as $status_code => $status){ // $status_code => object(status_id,status_code,title)
		 
//toPrint($status_code,'$status_code',0,'message',true);
//$view->order_items[$item->product_id]->tickets_cost[$go_status_code][$go_index][$item->order_item_id]
//				$title = ($order_item->tickets_cost[$status_code] ? rtrim(array_sum($order_item->tickets_cost[$status_code]??[0]), "0\.")  : 0).' '. $order_item->currency_code;
				$summa = array_sum(array_map(function($costs){ return array_sum($costs); }, ($order_item->tickets_cost[$status_code]??[]) ));
				$count = array_sum(array_map(function($costs){ return count($costs); }, $order_item->tickets_cost[$status_code]??[]));
				$title = $summa.' '. $order_item->currency_code;
//				$title = ($order_item->tickets_cost[$status_code] ?  array_sum($order_item->tickets_cost[$status_code]??[0])   : 0).' '. $order_item->currency_code;
//				echo "<div class='val col$i ' title='$title'><span class='text-nowrap'>". 
//						($order_item->tickets_cost[$status_code] ? count($order_item->tickets_cost[$status_code]??[]) : 0) ."</span></div>";
				echo "<div class='val col$i ' title='$title'><span class='text-nowrap'>$count</span></div>";
			$i++;
			
			if(! isset($summas[$status_code]))
				$summas[$status_code] = 0;
			if(! isset($countes[$status_code]))
				$countes[$status_code] = 0;
		
			$summas[$status_code] += $summa;
			$countes[$status_code] += $count;
		}
		echo "<div class='buySum' title='$order_item->count_tickets_active $PCS'><span class='text-nowrap'>$order_item->summ_tickets_active</span></div>";
		echo "</div>";
		
		foreach ($order_item->attributes as $attr_id => $attr){

//toPrint($attr,'$attr '. $order_item->product_id .' -----'.$attr_id, 0,'message',true);
//			$view->order_items[$item->product_id]->attributes[$attr_id][$go_status_code][$go_index] = $prices[$go_index] ?? 0;
			echo "<div class='attr'>";
			
			echo "<div class='id'></div>";
			echo "<div class='name'>{$this->rowAttributes[$attr_id]->attr_name}</div>";
//			$order_item->attr_tickets_active[$attr_id][$index][$item->order_item_id] = $prices[$index] ?? 0;
			$attr_tickets_active_summa = array_sum(array_map(fn($costs)=>array_sum($costs??[]),$order_item->attr_tickets_active[$attr_id] ?? []));
			$attr_tickets_active_count = array_sum(array_map(fn($costs)=>array_sum($costs??[]),$order_item->attr_tickets_active_counts[$attr_id] ?? []));
//			$attr_tickets_active_count = array_sum(array_map(fn($costs)=>count($costs??[]),$order_item->attr_tickets_active[$attr_id] ?? []));
//			$attr_tickets_active_summa = array_sum($order_item->attr_tickets_active[$attr_id] ?? [0]) . $order_item->currency_code;
			echo "<div class='buy' title='$attr_tickets_active_summa $order_item->currency_code'><span class='text-nowrap'>$attr_tickets_active_count</span></div>";
			$i = 1;
			foreach ($this->columnStatus as $status_code => $status){ // $status_code => object(status_id,status_code,title)
////toPrint($status_code,'$status_code',0,'message',true);
//					$this->order_items[$item->product_id]->attributes[$attr_id][$go_status_code][$go_index][$item->order_item_id];
					$summa = array_sum(array_map(function($costs){ return array_sum($costs); }, ($attr[$status_code]??[]) ));
					$count = array_sum(array_map(function($costs){ return count($costs); }, $attr[$status_code]??[]));
					$title = $summa . ' ' . $order_item->currency_code;
				echo "<div class='val col$i ' title='$title'><span class='text-nowrap'>$count</span></div>";
				$i++;
			}
			echo "<div class='sum' title='$attr_tickets_active_count $PCS'><span class='text-nowrap'>$attr_tickets_active_summa</span></div>";
			
			
//				echo "<div class='field'>";
//					echo "<div class='name'></div>";
//					echo "<div class='buy'></div>";
//					echo "<div class='sum'></div>";
//				echo "</div>";
				
			
			echo "</div>";
		}
	?>
</div>		
	<?php 
endforeach;
	?>
		
		<div class="titles line">
			<label>ID</label>
			<label class="titleName"><span class="titleEvent"><?= JText::_('JSHOP_PLACE_BILET_TITLE_EVENT') ?></span><span class="titleAttr"><?= JText::_('JSHOP_PLACE_BILET_TITLE_ATTR') ?></span></label>
			<label><?= JText::_('JSHOP_PLACE_BILET_SALETICKETS') ?> <span class=_pcs>(<?=$PCS?>)</span></label>
			<?php 
			$i = 1;
			foreach ($this->columnStatus as $status_code => $status){ // $status_code => object(status_id,status_code,title)
				echo "<label 'col$i statusCode $status->status_code statusID $status->status_id'>$status->title</label>";
				$i++;
			}
				?> 
			<label><?= JText::_('JSHOP_PLACE_BILET_SALESUM') ?>
				<span class=_cur> (<?= ' ('.isset($this->order_items) && $this->order_items ? 
						 reset( $this->order_items )->currency_code
						: strtolower(JText::_('COST')) ?>)</span></label>
		</div>
		
		<?php $cur = isset($this->order_items) && $this->order_items ? ' ('.reset( $this->order_items )->currency_code .')' : strtolower(JText::_('COST'))?>
		<div class="summ line">
			<label>#</label>
			<label class="titleName"><?= JText::_('JSHOP_PLACE_BILET_SUMMAS') ?></label>
			<label title="<?=$summas['summ_tickets_active'] .' ' . $cur ?>"><?=$countes['count_tickets_active']?></label>
			<?php 
			$i = 1; 
			foreach ($this->columnStatus as $status_code => $status){ // $status_code => object(status_id,status_code,title)
				
//				$summas[$status_code] = $summa;
//				$countes[$status_code] = $count;
//				$summas['summ_tickets_active'] += $order_item->summ_tickets_active;
//				$countes['count_tickets_active'] += $order_item->count_tickets_active;
		
				echo "<label 'col$i statusCode $status->status_code statusID $status->status_id' title='$summas[$status_code] $cur'>$countes[$status_code]</label>";
				$i++;
			}
				?> 
			<label title='<?=$countes['count_tickets_active'] .' ' . $PCS ?>'><?=$summas['summ_tickets_active']?></label>
		</div>
		
	</div>
	
<input type="hidden" name="task" value="" />
<input type="hidden" name="hidemainmenu" value="0" />

<xinput type="hidden" name="filter_order" value="<?php //echo $this->filter_order?>" />
<xinput type="hidden" name="filter_order_Dir" value="<?php //echo $this->filter_order_Dir?>" />
<xinput type="hidden" name="boxchecked" value="0" />
	</form>
	
<script>
jQuery(function(){
	jshopAdmin.setMainMenuActive('<?php print JURI::base()?>index.php?option=com_jshopping&controller=statistics');
});
</script>
<?php 

// <editor-fold defaultstate="collapsed" desc="Стили">

?>
<style>
.orderTable {
  --columnsStatus: <?= $i ?>;
}


</style>
<style media="all and (max-width: 500px)">

</style>
<style media="print">
	
</style>
<?php 
// </editor-fold>
?>
</div>
