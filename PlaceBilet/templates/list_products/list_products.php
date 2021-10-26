<?php 
/**
* @version      4.9.1 13.08.2013
* @author       MAXXmarketing GmbH
* @package      Jshopping
* @copyright    Copyright (C) 2010 webdesigner-profi.de. All rights reserved.
* @license      GNU/GPL
*/
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
 
    <div class = "sblock<?php echo $this->count_product_to_row;?>">
        <div class = "block_product">
            <?php 
			

 

			$templates = [];
			
			$templates[] = JPATH_ROOT.'/templates/'. JFactory::getApplication()->getTemplate().'/html/com_jshopping/list_products';
			$templates[] = JPATH_PLUGINS.'/jshopping/PlaceBilet/templates/list_products';
			$templates[] = JPATH_COMPONENT.'/com_jshopping/templates/'.JSFactory::getConfig()->template.'/list_products';
			$templates[] = dirname(__FILE__);
			
			if($file = JPath::find($templates, $product->template_block_product))
				include($file);
			 
			
			?>
        </div>
    </div>
            

<?php endforeach; ?>
</div>