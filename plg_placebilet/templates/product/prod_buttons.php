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

use \Joomla\CMS\Language\Text as JText;
extract($displayData);

?>
<div class="prod_buttons buttons">

		<input type="hidden" name="quantity" id="quantity" oninput="jshop.reloadPrices();" class="inputbox" value="1" min="0" >
         
		<input type="submit" class="btn btn-success button btn-buy" value="<?php print JText::_('JSHOP_ADD_TO_CART')?>" onclick="jQuery('#to').val('cart');" >

        <?php if (FALSE && $enable_wishlist){?>
			<input type="submit" class="btn button btn-wishlist btn-secondary" value="<?php print JText::_('JSHOP_ADD_TO_WISHLIST')?>" onclick="jQuery('#to').val('wishlist');" >
        <?php }?>

		<?php print $_tmp_product_html_buttons;?>

</div>
<div id="jshop_image_loading" style="display:none"></div>