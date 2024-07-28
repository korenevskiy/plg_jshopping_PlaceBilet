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
defined('_JEXEC') or die('Restricted access');

$afterRowsRender = true;

$templates = [];
	
?>
<div class="jshop" id="comjshop">
    <h1><?php print $this->category->name?></h1>
    <div class="category_description">
        <?php print $this->category->description?>
    </div>

    <div class="jshop_list_category <?=count($this->categories)?>">
    <?php if (count($this->categories)) : ?>
        <div class = "jshop list_category     d-flex p-2 bd-highlight">
            <?php foreach($this->categories as $k=>$category) : ?>
                
                <div class = "sblock<?php echo $this->count_category_to_row;?> jshop_categ category">
					<?php if($category->category_image){ ?>
                    <div class="_sblock2 image">
                        <a href="<?php print $category->category_link;?>">
                            <img class="jshop_img" src="<?php print $this->image_category_path;?>/<?php if ($category->category_image) print $category->category_image; else print $this->noimage;?>" alt="<?php print htmlspecialchars($category->name)?>" title="<?php print htmlspecialchars($category->name)?>" />
                        </a>
                    </div>
					<?php } ?>
                    <div class = "sblock2">
                        <div class="category_name">
                            <span class="product_link" href="<?php print $category->category_link?>">
                                <?php
                                // Create a DateTime object from the string
								//$dateTime = new DateTime($category->category_add_date??'');
								// Format the DateTime object to get only the date part
								//$dateOnly = $dateTime->format('Y-m-d');
                                print $category->name ;// .' <span class="cat-date">'.$dateOnly.'</span>'; ?>
                            </span>
                        </div>
                        <p class="category_short_description">
                            <?php print $category->short_description?>
                        </p>                       
                    </div>
					

					<?php 
					$rows = [];
					foreach ($this->rows as &$product){
						if(isset($product->category_ids) && is_array($product->category_ids) && in_array($category->category_id, $product->category_ids)){
							$rows[] = &$product;
						}
					}
	
					if($rows){
						
						$templates = [];
						$templates[] = JPATH_ROOT.'/templates/'. JFactory::getApplication()->getTemplate().'/html/com_jshopping';
						$templates[] = JPATH_PLUGINS.'/jshopping/placebilet/templates';
						$templates[] = JPATH_COMPONENT.'/com_jshopping/templates/'.JSFactory::getConfig()->template;
						$templates[] = realpath(dirname(__FILE__)."/../");
					}
					
					if($rows && $file = JPath::find($templates, 'category/list_products.php')){
						include($file);
						$afterRowsRender = false;
					}
					?>
                </div>
            <?php endforeach; ?>
            <div class = "clearfix"></div>
			
        </div>
    <?php endif; ?>
    </div>
    <?php 
	
	$rows = $this->rows;
	
	if($afterRowsRender){
			
		$templates = [];
		$templates[] = JPATH_ROOT.'/templates/'. JFactory::getApplication()->getTemplate().'/html/com_jshopping';
		$templates[] = JPATH_PLUGINS.'/jshopping/placebilet/templates';
		$templates[] = JPATH_COMPONENT.'/com_jshopping/templates/'.JSFactory::getConfig()->template;
		$templates[] = realpath(dirname(__FILE__)."/../");
	}
	
	if($afterRowsRender && $file = JPath::find($templates, 'list_products.php'))
		include($file);
		
	?>
</div>