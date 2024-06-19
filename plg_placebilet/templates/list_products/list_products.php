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
use \Joomla\CMS\Factory as JFactory;
use \Joomla\CMS\Filesystem\Path as JPath;

use \Joomla\Registry\Registry as JRegistry;
use \Joomla\CMS\HTML\HTMLHelper as JHtml;
use \Joomla\CMS\Language\Language as JLanguage;
use \Joomla\CMS\Plugin\CMSPlugin as JPlugin;
use Joomla\CMS\Plugin\PluginHelper as JPluginHelper;
defined('_JEXEC') or die('Restricted access');



?>
<div class="jshop list_product" id="comjshop_list_product">
<?php foreach ($this->rows as $k=>$product) : ?>
	<div class = "block_product sblock<?php echo $this->count_product_to_row;?>">
		<?php 
			
		$templates = [];
	
		$templates[] = JPATH_ROOT.'/templates/'. JFactory::getApplication()->getTemplate().'/html/com_jshopping/list_products';
		$templates[] = JPATH_PLUGINS.'/jshopping/placebilet/templates/list_products';
		$templates[] = JPATH_COMPONENT.'/com_jshopping/templates/'.JSFactory::getConfig()->template.'/list_products';
		$templates[] = dirname(__FILE__);

		if($file = JPath::find($templates, $product->template_block_product))
			include($file);
		?>
    </div>
<?php endforeach; ?>
	
	<div class = "clearfix"></div>
</div>