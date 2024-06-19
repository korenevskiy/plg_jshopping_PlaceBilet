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
use \Joomla\CMS\Document\HtmlDocument as JDocument;
use \Joomla\CMS\Language\Text as JText;

defined('_JEXEC') or die();

//echo "XXXXXXXXXXXXXXXXXXXXX";

//foreach ($displayData as $var => $val)
//	$this->$var = $val;

require_once PlaceBiletPath.DS.'Lib'.DS.'social_share.php';
$social = JSocial_Share::getInstance($displayData['params']);//->onBeforeDisplayProductView($view);   



$params					= $displayData['params'];
$product_categories		= $displayData['product_categories'];
$date_event				= $displayData['date_event'];
$product_id				= $displayData['product_id'];
//$image					= $displayData['image'];
//$description			= strip_tags($displayData['description']);
$product_name			= $displayData['product_name'];
$product_image					= $displayData['image'] ?? '';
$product_description			= strip_tags($displayData['description'] ?? '');

$date = JHTML::_('date', $date_event, JText::_('DATE_FORMAT_LC3')." h:m");
$name_product = htmlentities($product_name.' '.$date, ENT_QUOTES, "UTF-8");

$CategoriesRedirect = $params->CategoriesRedirect ?? FALSE;
//        $product_categories = $view->get('product')->product_categories;  
//        $date_event = $view->get('product')->date_event;  
//        $product_id = $view->get('product')->product_id;  
        
        $CategoriesRedirect_id = (int) $CategoriesRedirect ;//Категория редиректа если продукта не существует.
        $CategoriesRedirect_parent_id = (int) strstr($CategoriesRedirect,'-');//родитель Категории редиректа если продукта не существует.
        $cat_id = 0;
        
//        toPrint(null,"\$CategoriesRedirect_id:$CategoriesRedirect_id - \$CategoriesRedirect_parent_id:$CategoriesRedirect_parent_id");
//        toPrint($product_categories,'$product_categories',0);
        if(empty($cat_id))
        foreach ($product_categories as $cat){
            if($cat->category_id == $CategoriesRedirect_id)
                $cat_id = $cat->category_id;
        }
        if(empty($cat_id))
        foreach ($product_categories as $cat){
            if($cat->category_parent_id == $CategoriesRedirect_id)
                $cat_id = $cat->category_id;
        }
//        $cat_id = FALSE;
//        JUri::root();
        $link = ($cat_id)?(JUri::root().SEFLink("index.php?option=com_jshopping&controller=category&task=view&category_id=$cat_id")):JURI::current();
        $link = ($cat_id)?(JUri::root().SEFLink("index.php?option=com_jshopping&controller=product&task=view&category_id=$cat_id&product_id=$product_id", 1)):JURI::current();
//        toPrint($link,'$link');
        $url = &$link;
//        $date = JFactory::getDate($date_event)-> format(DATE_FORMAT_FILTER_DATE);
//        toPrint($date,'$date');
            
        
//toPrint($date_event,'$product->date_event');


//toPrint($date,'$date');
        
        $jshopConfig = JSFactory::getConfig();
        $doc = JFactory::getDocument();
//        $product = $view->product;
//        $name_product = htmlentities($product_name.' '.$date, ENT_QUOTES, "UTF-8");
        $ogurl = '<meta property="og:url" content="'.$link.'"/>';
        $ogtype = '<meta property="og:type" content="website"/>';
        $ogtitle = '<meta property="og:title" content="'.$name_product.'"/>';
        $doc->addCustomTag($ogurl);
        $doc->addCustomTag($ogtype);
        $doc->addCustomTag($ogtitle);
        if ($product_image){
            $ogimage = '<meta property="og:image" content="'.$jshopConfig->image_product_live_path.'/'.$product_image.'"/>';
            $doc->addCustomTag($ogimage);
        }
        if ($product_description){
            $ogdescription = '<meta property="og:description" content="'.$product_description.'"/>';
            $doc->addCustomTag($ogdescription);
        }

//        $uri = JURI::getInstance();
//        //$url = $uri->getScheme() ."://" . $uri->getHost() . $uri->getPath();
//		$url = '//'.$uri->getHost().$uri->getPath();
                
                
//        $view->get('product')->product_full_image = getPatchProductImage($product_image, 'full'); // !!!!!!!!!!!!!! Проверить это значение
        $_tmp_product_html = '';
        if ($params->get("facebookLikeButton", 1)){
            $_tmp_product_html .= '<div class="facebook-like-button">'.$social->getFacebookLikeButton($url, $name_product).'</div>';
        }
        if ($params->get("facebookShareButton", 1)){
            $_tmp_product_html .= '<div class="facebook-share">'.$social->getFacebookShare($url).'</div>';
        }
        if ($params->get("pinterestButton", 1)){
            $_tmp_product_html .= '<div class="pinterest">'.$social->getPinterestButton($url, $jshopConfig->image_product_live_path.'/'.$product_image).'</div>'; 
        }
        if ($params->get("twitterButton", 1)){
            $_tmp_product_html .= '<div class="tweet-button">'.$social->getTweetButton($url, $name_product).'</div>';
        }
        if($params->get("plusButton")) {
            $_tmp_product_html .= '<div class="google-plus-one-button">'.$social->getGooglePlusOne($url).'</div>';
        }
        if ($params->get("vkShareButton", 1)){
            $_tmp_product_html .= '<div class="vk-share-button">'.$social->getVkShareButton($url).'</div>';
        }
        $_tmp_product_html .= '<div style="clear:both;"></div>';
        
        $_tmp_product_html = "<div class=\"social_share\">$_tmp_product_html</div>";
        
		
echo $_tmp_product_html;

 